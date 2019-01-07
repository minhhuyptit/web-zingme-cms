<?php require_once('Connections/conn_vietchuyen.php'); ?>
<?php
//MX Widgets3 include
require_once('includes/wdg/WDG.php');

// Load the common classes
require_once('includes/common/KT_common.php');

// Load the tNG classes
require_once('includes/tng/tNG.inc.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("");

// Make unified connection variable
$conn_conn_vietchuyen = new KT_connection($conn_vietchuyen, $database_conn_vietchuyen);

//start Trigger_CheckPasswords trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckPasswords(&$tNG) {
  $myThrowError = new tNG_ThrowError($tNG);
  $myThrowError->setErrorMsg("Xác nhận mật khẩu không trùng khớp.");
  $myThrowError->setField("password");
  $myThrowError->setFieldErrorMsg("Xác nhận mật khẩu không trùng khớp.");
  return $myThrowError->Execute();
}
//end Trigger_CheckPasswords trigger

//start Trigger_CheckUnique trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckUnique(&$tNG) {
  $tblFldObj = new tNG_CheckUnique($tNG);
  $tblFldObj->setTable("thanhvien");
  $tblFldObj->addFieldName("email");
  $tblFldObj->setErrorMsg("Email này đã có người khác dùng rồi");
  return $tblFldObj->Execute();
}
//end Trigger_CheckUnique trigger

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("email", true, "text", "email", "", "", "Please enter a valid value.");
$formValidation->addField("username", true, "text", "", "", "", "Please enter a valid value.");
$formValidation->addField("password", true, "text", "", "", "", "Please enter a valid value.");
$tNGs->prepareValidation($formValidation);
// End trigger

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_quequan = "SELECT * FROM quequan ORDER BY tenquequan ASC";
$rs_quequan = mysql_query($query_rs_quequan, $conn_vietchuyen) or die(mysql_error());
$row_rs_quequan = mysql_fetch_assoc($rs_quequan);
$totalRows_rs_quequan = mysql_num_rows($rs_quequan);

mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_nghenghiep = "SELECT * FROM nghenghiep ORDER BY tennghenghiep ASC";
$rs_nghenghiep = mysql_query($query_rs_nghenghiep, $conn_vietchuyen) or die(mysql_error());
$row_rs_nghenghiep = mysql_fetch_assoc($rs_nghenghiep);
$totalRows_rs_nghenghiep = mysql_num_rows($rs_nghenghiep);

// Make an insert transaction instance
$userRegistration = new tNG_insert($conn_conn_vietchuyen);
$tNGs->addTransaction($userRegistration);
// Register triggers
$userRegistration->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$userRegistration->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$userRegistration->registerTrigger("END", "Trigger_Default_Redirect", 99, "register_ok.php");
$userRegistration->registerConditionalTrigger("{POST.password} != {POST.re_password}", "BEFORE", "Trigger_CheckPasswords", 50);
$userRegistration->registerTrigger("BEFORE", "Trigger_CheckUnique", 30);
// Add columns
$userRegistration->setTable("thanhvien");
$userRegistration->addColumn("hoten", "STRING_TYPE", "POST", "hoten");
$userRegistration->addColumn("diachi", "STRING_TYPE", "POST", "diachi");
$userRegistration->addColumn("email", "STRING_TYPE", "POST", "email");
$userRegistration->addColumn("gioitinh", "STRING_TYPE", "POST", "gioitinh");
$userRegistration->addColumn("ngaysinh", "DATE_TYPE", "POST", "ngaysinh");
$userRegistration->addColumn("dienthoai", "STRING_TYPE", "POST", "dienthoai");
$userRegistration->addColumn("ID_quequan", "NUMERIC_TYPE", "POST", "ID_quequan");
$userRegistration->addColumn("ID_nghenghiep", "NUMERIC_TYPE", "POST", "ID_nghenghiep");
$userRegistration->addColumn("username", "STRING_TYPE", "POST", "username");
$userRegistration->addColumn("password", "STRING_TYPE", "POST", "password");
$userRegistration->addColumn("chuthich", "STRING_TYPE", "POST", "chuthich");
$userRegistration->addColumn("ngaycapnhat", "DATE_TYPE", "POST", "ngaycapnhat");
$userRegistration->setPrimaryKey("ID_thanhvien", "NUMERIC_TYPE");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsthanhvien = $tNGs->getRecordset("thanhvien");
$row_rsthanhvien = mysql_fetch_assoc($rsthanhvien);
$totalRows_rsthanhvien = mysql_num_rows($rsthanhvien);

// Captcha Image
$captcha_id_obj = new KT_CaptchaImage("captcha_id_id");
?><!DOCTYPE html>
<html xmlns:wdg="http://ns.adobe.com/addt">
<head>
<meta charset="utf-8">
<title>Đăng ký</title><link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" /><script src="includes/common/js/base.js" type="text/javascript"></script><script src="includes/common/js/utility.js" type="text/javascript"></script><script src="includes/skins/style.js" type="text/javascript"></script><?php echo $tNGs->displayValidationRules();?>
<script type="text/javascript" src="includes/common/js/sigslot_core.js"></script>
<script type="text/javascript" src="includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="includes/wdg/classes/Calendar.js"></script>
<script type="text/javascript" src="includes/wdg/classes/SmartDate.js"></script>
<script type="text/javascript" src="includes/wdg/calendar/calendar_stripped.js"></script>
<script type="text/javascript" src="includes/wdg/calendar/calendar-setup_stripped.js"></script>
<script src="includes/resources/calendar.js"></script>
</head>

<body>
<form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
	<table cellpadding="2" cellspacing="0">
	  <tr>
	<td align="right" class="KT_th"><label for="hoten">Họ tên:</label></td>
	<td>
		<input type="text" name="hoten" id="hoten" value="<?php echo KT_escapeAttribute($row_rsthanhvien['hoten']); ?>" size="32" />
		<?php echo $tNGs->displayFieldHint("hoten");?>
		<?php echo $tNGs->displayFieldError("thanhvien", "hoten"); ?>	</td>
</tr>
	  <tr>
	<td align="right" class="KT_th"><label for="diachi">Địa chỉ:</label></td>
	<td>
		<input type="text" name="diachi" id="diachi" value="<?php echo KT_escapeAttribute($row_rsthanhvien['diachi']); ?>" size="32" />
		<?php echo $tNGs->displayFieldHint("diachi");?>
		<?php echo $tNGs->displayFieldError("thanhvien", "diachi"); ?>	</td>
</tr>
	  <tr>
	<td align="right" class="KT_th"><label for="email">(*)Email:</label></td>
	<td>
		<input type="text" name="email" id="email" value="<?php echo KT_escapeAttribute($row_rsthanhvien['email']); ?>" size="32" />
		<?php echo $tNGs->displayFieldHint("email");?>
		<?php echo $tNGs->displayFieldError("thanhvien", "email"); ?>	</td>
</tr>
	  <tr>
	<td align="right" class="KT_th"><label for="gioitinh_1">Giới tính</label></td>
	<td>
	
		<div>
			<input <?php if (!(strcmp(KT_escapeAttribute($row_rsthanhvien['gioitinh']),"Nam"))) {echo "CHECKED";} ?> type="radio" name="gioitinh" id="gioitinh_1" value="Nam" />
			<label for="gioitinh_1">Nam</label>
		</div>
	
		<div>
			<input <?php if (!(strcmp(KT_escapeAttribute($row_rsthanhvien['gioitinh']),"Nữ"))) {echo "CHECKED";} ?> type="radio" name="gioitinh" id="gioitinh_2" value="Nữ" />
			<label for="gioitinh_2">Nữ</label>
		</div>
	
		<?php echo $tNGs->displayFieldError("thanhvien", "gioitinh"); ?>	</td>
</tr>
	  <tr>
	<td align="right" class="KT_th"><label for="ngaysinh">Ngày sinh:</label></td>
	<td>
		<input name="ngaysinh" id="ngaysinh" value="<?php echo KT_formatDate($row_rsthanhvien['ngaysinh']); ?>" size="32" wdg:mondayfirst="true" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="yes" />
		<?php echo $tNGs->displayFieldHint("ngaysinh");?>
		<?php echo $tNGs->displayFieldError("thanhvien", "ngaysinh"); ?>	</td>
</tr>
	  <tr>
	<td align="right" class="KT_th"><label for="dienthoai">Điện thoại:</label></td>
	<td>
		<input type="text" name="dienthoai" id="dienthoai" value="<?php echo KT_escapeAttribute($row_rsthanhvien['dienthoai']); ?>" size="32" />
		<?php echo $tNGs->displayFieldHint("dienthoai");?>
		<?php echo $tNGs->displayFieldError("thanhvien", "dienthoai"); ?>	</td>
</tr>
	  <tr>
	<td align="right" class="KT_th"><label for="ID_quequan">Quê quán:</label></td>
	<td>
		<select name="ID_quequan" id="ID_quequan">
<?php 
do {  
?>
			<option value="<?php echo $row_rs_quequan['ID_quequan']?>"<?php if (!(strcmp($row_rs_quequan['ID_quequan'], $row_rsthanhvien['ID_quequan']))) {echo "SELECTED";} ?>><?php echo $row_rs_quequan['tenquequan']?></option>
<?php
} while ($row_rs_quequan = mysql_fetch_assoc($rs_quequan));
  $rows = mysql_num_rows($rs_quequan);
  if($rows > 0) {
      mysql_data_seek($rs_quequan, 0);
	  $row_rs_quequan = mysql_fetch_assoc($rs_quequan);
  }
?>
		</select>
		<?php echo $tNGs->displayFieldError("thanhvien", "ID_quequan"); ?>	</td>
</tr>
	  <tr>
	<td align="right" class="KT_th"><label for="ID_nghenghiep">ID_nghenghiep:</label></td>
	<td>
		<select name="ID_nghenghiep" id="ID_nghenghiep">
<?php 
do {  
?>
			<option value="<?php echo $row_rs_nghenghiep['ID_nghenghiep']?>"<?php if (!(strcmp($row_rs_nghenghiep['ID_nghenghiep'], $row_rsthanhvien['ID_nghenghiep']))) {echo "SELECTED";} ?>><?php echo $row_rs_nghenghiep['tennghenghiep']?></option>
<?php
} while ($row_rs_nghenghiep = mysql_fetch_assoc($rs_nghenghiep));
  $rows = mysql_num_rows($rs_nghenghiep);
  if($rows > 0) {
      mysql_data_seek($rs_nghenghiep, 0);
	  $row_rs_nghenghiep = mysql_fetch_assoc($rs_nghenghiep);
  }
?>
		</select>
		<?php echo $tNGs->displayFieldError("thanhvien", "ID_nghenghiep"); ?>	</td>
</tr>
	  <tr>
	<td align="right" class="KT_th"><label for="username">(*)Username:</label></td>
	<td>
		<input type="text" name="username" id="username" value="<?php echo KT_escapeAttribute($row_rsthanhvien['username']); ?>" size="32" />
		<?php echo $tNGs->displayFieldHint("username");?>
		<?php echo $tNGs->displayFieldError("thanhvien", "username"); ?>	</td>
</tr>
	  <tr>
	<td align="right" class="KT_th"><label for="password">(*)Password:</label></td>
	<td>
		<input type="password" name="password" id="password" value="" size="32" />
		<?php echo $tNGs->displayFieldHint("password");?>
		<?php echo $tNGs->displayFieldError("thanhvien", "password"); ?>	</td>
</tr>
<tr>
	<td align="right" class="KT_th"><label for="re_password">Re-type Password:</label></td>
	<td>
		<input type="password" name="re_password" id="re_password" value="" size="32" />	</td>
</tr>
	  <tr>
	<td align="right" class="KT_th"><label for="chuthich">Chú thích:</label></td>
	<td>
		<textarea name="chuthich" id="chuthich" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rsthanhvien['chuthich']); ?></textarea>
		<?php echo $tNGs->displayFieldHint("chuthich");?>
		<?php echo $tNGs->displayFieldError("thanhvien", "chuthich"); ?>	</td>
</tr>
		  <tr>
		    <td align="right" class="KT_th">&nbsp;</td>
		    <td><?php
	echo $tNGs->getErrorMsg();
?></td>
      </tr>
	  <tr align="center"> 
	    <td colspan="2">
				<input type="submit" name="KT_Insert1" id="KT_Insert1" value="Đăng ký" />				</td>
	  </tr>      
    </table>
		<input type="hidden" name="ngaycapnhat" id="ngaycapnhat" value="<?php echo KT_formatDate($row_rsthanhvien['ngaycapnhat']); ?>" />
		
</form>

	
</body>
</html>
<?php
mysql_free_result($rs_quequan);

mysql_free_result($rs_nghenghiep);
?>
