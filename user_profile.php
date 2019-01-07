<?php require_once('Connections/conn_vietchuyen.php'); ?><?php
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
  $myThrowError->setErrorMsg("Could not create account.");
  $myThrowError->setField("password");
  $myThrowError->setFieldErrorMsg("The two passwords do not match.");
  return $myThrowError->Execute();
}
//end Trigger_CheckPasswords trigger

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("email", true, "text", "email", "", "", "Xin vui lòng nhập vào email");
$formValidation->addField("dienthoai", false, "text", "phone", "", "", "Xin vui lòng nhập đúng vào định dạng điện thoại");
$formValidation->addField("password", true, "text", "", "", "", "Xin vui lòng nhập vào password");
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

//start Trigger_CheckOldPassword trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckOldPassword(&$tNG) {
  return Trigger_UpdatePassword_CheckOldPassword($tNG);
}
//end Trigger_CheckOldPassword trigger

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

// Make an update transaction instance
$upd_thanhvien = new tNG_update($conn_conn_vietchuyen);
$tNGs->addTransaction($upd_thanhvien);
// Register triggers
$upd_thanhvien->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_thanhvien->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_thanhvien->registerTrigger("END", "Trigger_Default_Redirect", 99, "user_profile_ok.php");
$upd_thanhvien->registerConditionalTrigger("{POST.password} != {POST.re_password}", "BEFORE", "Trigger_CheckPasswords", 50);
$upd_thanhvien->registerTrigger("BEFORE", "Trigger_CheckOldPassword", 60);
// Add columns
$upd_thanhvien->setTable("thanhvien");
$upd_thanhvien->addColumn("hoten", "STRING_TYPE", "POST", "hoten");
$upd_thanhvien->addColumn("diachi", "STRING_TYPE", "POST", "diachi");
$upd_thanhvien->addColumn("email", "STRING_TYPE", "POST", "email");
$upd_thanhvien->addColumn("dienthoai", "STRING_TYPE", "POST", "dienthoai");
$upd_thanhvien->addColumn("gioitinh", "STRING_TYPE", "POST", "gioitinh");
$upd_thanhvien->addColumn("ID_quequan", "NUMERIC_TYPE", "POST", "ID_quequan");
$upd_thanhvien->addColumn("ID_nghenghiep", "NUMERIC_TYPE", "POST", "ID_nghenghiep");
$upd_thanhvien->addColumn("username", "STRING_TYPE", "CURRVAL", "");
$upd_thanhvien->addColumn("password", "STRING_TYPE", "POST", "password");
$upd_thanhvien->addColumn("ngaycapnhat", "DATE_TYPE", "POST", "ngaycapnhat");
$upd_thanhvien->addColumn("ngaysinh", "DATE_TYPE", "POST", "ngaysinh");
$upd_thanhvien->addColumn("chuthich", "STRING_TYPE", "POST", "chuthich");
$upd_thanhvien->setPrimaryKey("ID_thanhvien", "NUMERIC_TYPE", "SESSION", "KT_login_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsthanhvien = $tNGs->getRecordset("thanhvien");
$row_rsthanhvien = mysql_fetch_assoc($rsthanhvien);
$totalRows_rsthanhvien = mysql_num_rows($rsthanhvien);
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Cập nhật thông tin cá nhân</title><link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" /><script src="includes/common/js/base.js" type="text/javascript"></script><script src="includes/common/js/utility.js" type="text/javascript"></script><script src="includes/skins/style.js" type="text/javascript"></script><?php echo $tNGs->displayValidationRules();?>
</head>

<body>
<form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
<table align="center" cellpadding="2" cellspacing="0">
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
	<td align="right" class="KT_th"><label for="email">Email:</label></td>
	<td>
		<input type="text" name="email" id="email" value="<?php echo KT_escapeAttribute($row_rsthanhvien['email']); ?>" size="32" />
		<?php echo $tNGs->displayFieldHint("email");?>
		<?php echo $tNGs->displayFieldError("thanhvien", "email"); ?>	</td>
</tr>
			<tr>
	<td align="right" class="KT_th"><label for="dienthoai">Điện thoại:</label></td>
	<td>
		<input type="text" name="dienthoai" id="dienthoai" value="<?php echo KT_escapeAttribute($row_rsthanhvien['dienthoai']); ?>" size="32" />
		<?php echo $tNGs->displayFieldHint("dienthoai");?>
		<?php echo $tNGs->displayFieldError("thanhvien", "dienthoai"); ?>	</td>
</tr>
			<tr>
	<td align="right" class="KT_th"><label for="gioitinh_1">Giới tính:</label></td>
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
	<td align="right" class="KT_th"><label for="ID_nghenghiep">Nghề nghiệp:</label></td>
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
	<td align="right" class="KT_th">Username:</td>
	<td><?php echo KT_escapeAttribute($row_rsthanhvien['username']); ?></td>
</tr>    
			<tr>
	<td align="right" class="KT_th"><label for="old_password">Old Password:</label></td>
	<td>
		<input type="password" name="old_password" id="old_password" value="" size="32" />
		<?php echo $tNGs->displayFieldError("thanhvien", "old_password"); ?>	</td>
</tr>
<tr>
	<td align="right" class="KT_th"><label for="password">Password:</label></td>
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
	<td align="right" class="KT_th"><label for="ngaysinh">Ngaysinh:</label></td>
	<td>
		<input type="text" name="ngaysinh" id="ngaysinh" value="<?php echo KT_formatDate($row_rsthanhvien['ngaysinh']); ?>" size="32" />
		<?php echo $tNGs->displayFieldHint("ngaysinh");?>
		<?php echo $tNGs->displayFieldError("thanhvien", "ngaysinh"); ?>	</td>
</tr>
			<tr>
	<td align="right" class="KT_th"><label for="chuthich">Chú thích:</label></td>
	<td>
		<textarea name="chuthich" id="chuthich" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rsthanhvien['chuthich']); ?></textarea>
		<?php echo $tNGs->displayFieldHint("chuthich");?>
		<?php echo $tNGs->displayFieldError("thanhvien", "chuthich"); ?>	</td>
</tr>
			<tr align="right"> 
				<td colspan="2" align="center">
				  <input type="submit" name="KT_Update1" id="KT_Update1" value="Cập nhật thông tin cá nhân" />
				<label>
				<input type="reset" name="Reset" id="button" value="Làm lại">
				</label></td>
			</tr>      
		</table>
		<input type="hidden" name="ngaycapnhat" id="ngaycapnhat" value="<?php echo KT_formatDate($row_rsthanhvien['ngaycapnhat']); ?>" />
		
</form>

</body>
</html><?php
mysql_free_result($rs_quequan);

mysql_free_result($rs_nghenghiep);
?>
