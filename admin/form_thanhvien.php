<?php require_once('../Connections/conn_vietchuyen.php'); ?>
<?php
// Load the common classes
require_once('../includes/common/KT_common.php');

// Load the tNG classes
require_once('../includes/tng/tNG.inc.php');

// Load the KT_back class
require_once('../includes/nxt/KT_back.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../");

// Make unified connection variable
$conn_conn_vietchuyen = new KT_connection($conn_vietchuyen, $database_conn_vietchuyen);

//Start Restrict Access To Page
$restrict = new tNG_RestrictAccess($conn_conn_vietchuyen, "../");
//Grand Levels: Level
$restrict->addLevel("1");
$restrict->Execute();
//End Restrict Access To Page

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

//start Trigger_CheckOldPassword trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckOldPassword(&$tNG) {
  return Trigger_UpdatePassword_CheckOldPassword($tNG);
}
//end Trigger_CheckOldPassword trigger

mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_quequan = "SELECT ID_quequan, tenquequan FROM quequan ORDER BY tenquequan ASC";
$rs_quequan = mysql_query($query_rs_quequan, $conn_vietchuyen) or die(mysql_error());
$row_rs_quequan = mysql_fetch_assoc($rs_quequan);
$totalRows_rs_quequan = mysql_num_rows($rs_quequan);

mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_Recordset1 = "SELECT tenquequan, ID_quequan FROM quequan ORDER BY tenquequan";
$Recordset1 = mysql_query($query_Recordset1, $conn_vietchuyen) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_nghenghiep = "SELECT ID_nghenghiep, tennghenghiep FROM nghenghiep ORDER BY tennghenghiep ASC";
$rs_nghenghiep = mysql_query($query_rs_nghenghiep, $conn_vietchuyen) or die(mysql_error());
$row_rs_nghenghiep = mysql_fetch_assoc($rs_nghenghiep);
$totalRows_rs_nghenghiep = mysql_num_rows($rs_nghenghiep);

mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_Recordset2 = "SELECT tennghenghiep, ID_nghenghiep FROM nghenghiep ORDER BY tennghenghiep";
$Recordset2 = mysql_query($query_Recordset2, $conn_vietchuyen) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

// Make an insert transaction instance
$ins_thanhvien = new tNG_multipleInsert($conn_conn_vietchuyen);
$tNGs->addTransaction($ins_thanhvien);
// Register triggers
$ins_thanhvien->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_thanhvien->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_thanhvien->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$ins_thanhvien->registerConditionalTrigger("{POST.password} != {POST.re_password}", "BEFORE", "Trigger_CheckPasswords", 50);
// Add columns
$ins_thanhvien->setTable("thanhvien");
$ins_thanhvien->addColumn("hoten", "STRING_TYPE", "POST", "hoten");
$ins_thanhvien->addColumn("gioitinh", "STRING_TYPE", "POST", "gioitinh");
$ins_thanhvien->addColumn("ngaysinh", "DATE_TYPE", "POST", "ngaysinh");
$ins_thanhvien->addColumn("diachi", "STRING_TYPE", "POST", "diachi");
$ins_thanhvien->addColumn("email", "STRING_TYPE", "POST", "email");
$ins_thanhvien->addColumn("dienthoai", "STRING_TYPE", "POST", "dienthoai");
$ins_thanhvien->addColumn("ID_quequan", "NUMERIC_TYPE", "POST", "ID_quequan");
$ins_thanhvien->addColumn("ID_nghenghiep", "NUMERIC_TYPE", "POST", "ID_nghenghiep");
$ins_thanhvien->addColumn("username", "STRING_TYPE", "POST", "username");
$ins_thanhvien->addColumn("password", "STRING_TYPE", "POST", "password");
$ins_thanhvien->addColumn("accesslevel", "NUMERIC_TYPE", "POST", "accesslevel");
$ins_thanhvien->addColumn("active", "CHECKBOX_1_0_TYPE", "POST", "active", "0");
$ins_thanhvien->addColumn("ngaycapnhat", "DATE_TYPE", "VALUE", "{NOW_DT}");
$ins_thanhvien->addColumn("chuthich", "STRING_TYPE", "POST", "chuthich");
$ins_thanhvien->setPrimaryKey("ID_thanhvien", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_thanhvien = new tNG_multipleUpdate($conn_conn_vietchuyen);
$tNGs->addTransaction($upd_thanhvien);
// Register triggers
$upd_thanhvien->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_thanhvien->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_thanhvien->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$upd_thanhvien->registerConditionalTrigger("{POST.password} != {POST.re_password}", "BEFORE", "Trigger_CheckPasswords", 50);
$upd_thanhvien->registerTrigger("BEFORE", "Trigger_CheckOldPassword", 60);
// Add columns
$upd_thanhvien->setTable("thanhvien");
$upd_thanhvien->addColumn("hoten", "STRING_TYPE", "POST", "hoten");
$upd_thanhvien->addColumn("gioitinh", "STRING_TYPE", "POST", "gioitinh");
$upd_thanhvien->addColumn("ngaysinh", "DATE_TYPE", "POST", "ngaysinh");
$upd_thanhvien->addColumn("diachi", "STRING_TYPE", "POST", "diachi");
$upd_thanhvien->addColumn("email", "STRING_TYPE", "POST", "email");
$upd_thanhvien->addColumn("dienthoai", "STRING_TYPE", "POST", "dienthoai");
$upd_thanhvien->addColumn("ID_quequan", "NUMERIC_TYPE", "POST", "ID_quequan");
$upd_thanhvien->addColumn("ID_nghenghiep", "NUMERIC_TYPE", "POST", "ID_nghenghiep");
$upd_thanhvien->addColumn("username", "STRING_TYPE", "POST", "username");
$upd_thanhvien->addColumn("password", "STRING_TYPE", "POST", "password");
$upd_thanhvien->addColumn("accesslevel", "NUMERIC_TYPE", "POST", "accesslevel");
$upd_thanhvien->addColumn("active", "CHECKBOX_1_0_TYPE", "POST", "active");
$upd_thanhvien->addColumn("ngaycapnhat", "DATE_TYPE", "CURRVAL", "");
$upd_thanhvien->addColumn("chuthich", "STRING_TYPE", "POST", "chuthich");
$upd_thanhvien->setPrimaryKey("ID_thanhvien", "NUMERIC_TYPE", "GET", "ID_thanhvien");

// Make an instance of the transaction object
$del_thanhvien = new tNG_multipleDelete($conn_conn_vietchuyen);
$tNGs->addTransaction($del_thanhvien);
// Register triggers
$del_thanhvien->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_thanhvien->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_thanhvien->setTable("thanhvien");
$del_thanhvien->setPrimaryKey("ID_thanhvien", "NUMERIC_TYPE", "GET", "ID_thanhvien");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsthanhvien = $tNGs->getRecordset("thanhvien");
$row_rsthanhvien = mysql_fetch_assoc($rsthanhvien);
$totalRows_rsthanhvien = mysql_num_rows($rsthanhvien);
?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>vietchuyen.edu.vn</title><link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" /><script src="../includes/common/js/base.js" type="text/javascript"></script><script src="../includes/common/js/utility.js" type="text/javascript"></script><script src="../includes/skins/style.js" type="text/javascript"></script><?php echo $tNGs->displayValidationRules();?><script src="../includes/nxt/scripts/form.js" type="text/javascript"></script><script src="../includes/nxt/scripts/form.js.php" type="text/javascript"></script><script type="text/javascript">
$NXT_FORM_SETTINGS = {
  duplicate_buttons: true,
  show_as_grid: true,
  merge_down_value: true
}
</script>
</head>

<body>
<div class="KT_tng">
  <h1>
    <?php 
// Show IF Conditional region1 
if (@$_GET['ID_thanhvien'] == "") {
?>
<?php echo NXT_getResource("Insert_FH"); ?>
<?php 
// else Conditional region1
} else { ?>
<?php echo NXT_getResource("Update_FH"); ?>
<?php } 
// endif Conditional region1
?>
    Thành viên</h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
      <?php $cnt1++; ?>
      <?php 
// Show IF Conditional region1 
if (@$totalRows_rsthanhvien > 1) {
?>
      <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
      <?php } 
// endif Conditional region1
?>
      <table width="99%" cellpadding="2" cellspacing="0" class="KT_tngtable">
        <tr>
	<td width="20%" class="KT_th"><label for="hoten_<?php echo $cnt1; ?>">Họ tên:</label></td>
	<td width="80%">
		<input type="text" name="hoten_<?php echo $cnt1; ?>" id="hoten_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsthanhvien['hoten']); ?>" size="32" maxlength="55" />
		<?php echo $tNGs->displayFieldHint("hoten");?>
		<?php echo $tNGs->displayFieldError("thanhvien", "hoten", $cnt1); ?>
	</td>
</tr>
        <tr>
	<td class="KT_th"><label for="gioitinh_<?php echo $cnt1; ?>_1">Gioitinh:</label></td>
	<td>
	
		<div>
			<input <?php if (!(strcmp(KT_escapeAttribute($row_rsthanhvien['gioitinh']),"Nam"))) {echo "CHECKED";} ?> type="radio" name="gioitinh_<?php echo $cnt1; ?>" id="gioitinh_<?php echo $cnt1; ?>_1" value="Nam" />
			<label for="gioitinh_<?php echo $cnt1; ?>_1">Nam</label>
		</div>
	
		<div>
			<input <?php if (!(strcmp(KT_escapeAttribute($row_rsthanhvien['gioitinh']),"Nữ"))) {echo "CHECKED";} ?> type="radio" name="gioitinh_<?php echo $cnt1; ?>" id="gioitinh_<?php echo $cnt1; ?>_2" value="Nữ" />
			<label for="gioitinh_<?php echo $cnt1; ?>_2">Nữ</label>
		</div>
	
		<?php echo $tNGs->displayFieldError("thanhvien", "gioitinh", $cnt1); ?>
	</td>
</tr>
        <tr>
	<td class="KT_th"><label for="ngaysinh_<?php echo $cnt1; ?>">Ngày sinh:</label></td>
	<td>
		<input type="text" name="ngaysinh_<?php echo $cnt1; ?>" id="ngaysinh_<?php echo $cnt1; ?>" value="<?php echo KT_formatDate($row_rsthanhvien['ngaysinh']); ?>" size="32" maxlength="22" />
		<?php echo $tNGs->displayFieldHint("ngaysinh");?>
		<?php echo $tNGs->displayFieldError("thanhvien", "ngaysinh", $cnt1); ?>
	</td>
</tr>
        <tr>
	<td class="KT_th"><label for="diachi_<?php echo $cnt1; ?>">Địa chỉ</label></td>
	<td>
		<input type="text" name="diachi_<?php echo $cnt1; ?>" id="diachi_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsthanhvien['diachi']); ?>" size=" " maxlength="255" />
		<?php echo $tNGs->displayFieldHint("diachi");?>
		<?php echo $tNGs->displayFieldError("thanhvien", "diachi", $cnt1); ?>
	</td>
</tr>
        <tr>
	<td class="KT_th"><label for="email_<?php echo $cnt1; ?>">Email:</label></td>
	<td>
		<input type="text" name="email_<?php echo $cnt1; ?>" id="email_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsthanhvien['email']); ?>" size="32" maxlength="100" />
		<?php echo $tNGs->displayFieldHint("email");?>
		<?php echo $tNGs->displayFieldError("thanhvien", "email", $cnt1); ?>
	</td>
</tr>
        <tr>
	<td class="KT_th"><label for="dienthoai_<?php echo $cnt1; ?>">Điện thoại:</label></td>
	<td>
		<input type="text" name="dienthoai_<?php echo $cnt1; ?>" id="dienthoai_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsthanhvien['dienthoai']); ?>" size="32" maxlength="50" />
		<?php echo $tNGs->displayFieldHint("dienthoai");?>
		<?php echo $tNGs->displayFieldError("thanhvien", "dienthoai", $cnt1); ?>
	</td>
</tr>
        <tr>
	<td class="KT_th"><label for="ID_quequan_<?php echo $cnt1; ?>">Quê quán</label></td>
	<td>
		<select name="ID_quequan_<?php echo $cnt1; ?>" id="ID_quequan_<?php echo $cnt1; ?>">
      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
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
		<?php echo $tNGs->displayFieldError("thanhvien", "ID_quequan", $cnt1); ?>
	</td>
</tr>
        <tr>
	<td class="KT_th"><label for="ID_nghenghiep_<?php echo $cnt1; ?>">Nghề nghiệp</label></td>
	<td>
		<select name="ID_nghenghiep_<?php echo $cnt1; ?>" id="ID_nghenghiep_<?php echo $cnt1; ?>">
      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
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
		<?php echo $tNGs->displayFieldError("thanhvien", "ID_nghenghiep", $cnt1); ?>
	</td>
</tr>
        <tr>
	<td class="KT_th"><label for="username_<?php echo $cnt1; ?>">Username:</label></td>
	<td>
		<input type="text" name="username_<?php echo $cnt1; ?>" id="username_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsthanhvien['username']); ?>" size="32" maxlength="100" />
		<?php echo $tNGs->displayFieldHint("username");?>
		<?php echo $tNGs->displayFieldError("thanhvien", "username", $cnt1); ?>
	</td>
</tr>
        <?php 
// Show IF Conditional show_old_password_on_update_only 
if (@$_GET['ID_thanhvien'] != "") {
?>
<tr>
	<td class="KT_th"><label for="old_password_<?php echo $cnt1; ?>">Old Password:</label></td>
	<td>
		<input type="password" name="old_password_<?php echo $cnt1; ?>" id="old_password_<?php echo $cnt1; ?>" value="" size="32" maxlength="200" />
		<?php echo $tNGs->displayFieldError("thanhvien", "old_password", $cnt1); ?>
	</td>
</tr><?php } 
// endif Conditional show_old_password_on_update_only
?>
<tr>
	<td class="KT_th"><label for="password_<?php echo $cnt1; ?>">Password:</label></td>
	<td>
		<input type="password" name="password_<?php echo $cnt1; ?>" id="password_<?php echo $cnt1; ?>" value="" size="32" maxlength="200" />
		<?php echo $tNGs->displayFieldHint("password");?>
		<?php echo $tNGs->displayFieldError("thanhvien", "password", $cnt1); ?>
	</td>
</tr>
<tr>
	<td class="KT_th"><label for="re_password_<?php echo $cnt1; ?>">Re-type Password:</label></td>
	<td>
		<input type="password" name="re_password_<?php echo $cnt1; ?>" id="re_password_<?php echo $cnt1; ?>" value="" size="32" maxlength="200" />
	</td>
</tr>
        <tr>
	<td class="KT_th"><label for="accesslevel_<?php echo $cnt1; ?>">Phân quyền:</label></td>
	<td>
		<select name="accesslevel_<?php echo $cnt1; ?>" id="accesslevel_<?php echo $cnt1; ?>">
			
		  <option value="1" <?php if (!(strcmp(1, KT_escapeAttribute($row_rsthanhvien['accesslevel'])))) {echo "SELECTED";} ?>>Admin</option>
			
		  <option value="2" <?php if (!(strcmp(2, KT_escapeAttribute($row_rsthanhvien['accesslevel'])))) {echo "SELECTED";} ?>>User</option>
			
		  <option value="3" <?php if (!(strcmp(3, KT_escapeAttribute($row_rsthanhvien['accesslevel'])))) {echo "SELECTED";} ?>>Manager</option>
			
		</select>
		<?php echo $tNGs->displayFieldError("thanhvien", "accesslevel", $cnt1); ?>
	</td>
</tr> 
        <tr>
	<td class="KT_th"><label for="active_<?php echo $cnt1; ?>">Kích hoạt tài khoản:</label></td>
	<td>
		<input  <?php if (!(strcmp(KT_escapeAttribute($row_rsthanhvien['active']),"1"))) {echo "checked";} ?> type="checkbox" name="active_<?php echo $cnt1; ?>" id="active_<?php echo $cnt1; ?>" value="1" />
		<?php echo $tNGs->displayFieldError("thanhvien", "active", $cnt1); ?>
	</td>
</tr>     
        <tr>
	<td class="KT_th">Ngày cập nhật:</td>
	<td><?php echo KT_formatDate($row_rsthanhvien['ngaycapnhat']); ?></td>
</tr>    
        <tr>
	<td class="KT_th"><label for="chuthich_<?php echo $cnt1; ?>">Chú thích:</label></td>
	<td>
		<textarea name="chuthich_<?php echo $cnt1; ?>" id="chuthich_<?php echo $cnt1; ?>" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rsthanhvien['chuthich']); ?></textarea>
		<?php echo $tNGs->displayFieldHint("chuthich");?>
		<?php echo $tNGs->displayFieldError("thanhvien", "chuthich", $cnt1); ?>
	</td>
</tr>
        
      </table>
      <input type="hidden" name="kt_pk_thanhvien_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsthanhvien['kt_pk_thanhvien']); ?>" />
      
      <?php } while ($row_rsthanhvien = mysql_fetch_assoc($rsthanhvien)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['ID_thanhvien'] == "") {
      ?>
          <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
          <?php 
      // else Conditional region1
      } else { ?>
          
	<div class="KT_operations">
	<input type="submit" name="KT_Insert1" value="<?php echo NXT_getResource("Insert as new_FB"); ?>" onclick="nxt_form_insertasnew(this, 'ID_thanhvien')" />
	</div>
	

          <input type="submit" name="KT_Update1" value="<?php echo NXT_getResource("Update_FB"); ?>" />
          <input type="submit" name="KT_Delete1" value="<?php echo NXT_getResource("Delete_FB"); ?>" onclick="return confirm('<?php echo NXT_getResource("Are you sure?"); ?>');" />
          <?php }
      // endif Conditional region1
      ?>
          <input type="button" name="KT_Cancel1" value="<?php echo NXT_getResource("Cancel_FB"); ?>" onclick="return UNI_navigateCancel(event, '../includes/nxt/back.php')" />
        </div>
      </div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>
</body>
</html>
<?php
mysql_free_result($rs_quequan);

mysql_free_result($Recordset1);

mysql_free_result($rs_nghenghiep);

mysql_free_result($Recordset2);
?>
