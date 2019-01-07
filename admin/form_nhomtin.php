<?php require_once('../Connections/conn_vietchuyen.php'); ?>
<?php
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');

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

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("ID_theloai", true, "numeric", "", "", "", "Xin vui lòng chọn danh mục tin cấp 1");
$formValidation->addField("ID_theloaitin", true, "numeric", "", "", "", "");
$formValidation->addField("tennhomtin", true, "text", "", "", "", "Xin vui lòng nhập tên chuyên đề");
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
$query_rs_theloai = "SELECT ID_theloai, tentheloai FROM theloai WHERE linkngoai = 0 ORDER BY tentheloai ASC";
$rs_theloai = mysql_query($query_rs_theloai, $conn_vietchuyen) or die(mysql_error());
$row_rs_theloai = mysql_fetch_assoc($rs_theloai);
$totalRows_rs_theloai = mysql_num_rows($rs_theloai);

mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_Recordset1 = "SELECT tentheloai, ID_theloai FROM theloai ORDER BY tentheloai";
$Recordset1 = mysql_query($query_Recordset1, $conn_vietchuyen) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_theloaitin = "SELECT ID_theloaitin, tentheloaitin, ID_theloai FROM theloaitin WHERE linkngoai = 0 ORDER BY tentheloaitin ASC";
$rs_theloaitin = mysql_query($query_rs_theloaitin, $conn_vietchuyen) or die(mysql_error());
$row_rs_theloaitin = mysql_fetch_assoc($rs_theloaitin);
$totalRows_rs_theloaitin = mysql_num_rows($rs_theloaitin);

mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_Recordset2 = "SELECT tentheloaitin, ID_theloaitin FROM theloaitin ORDER BY tentheloaitin";
$Recordset2 = mysql_query($query_Recordset2, $conn_vietchuyen) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

// Make an insert transaction instance
$ins_nhomtin = new tNG_multipleInsert($conn_conn_vietchuyen);
$tNGs->addTransaction($ins_nhomtin);
// Register triggers
$ins_nhomtin->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_nhomtin->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_nhomtin->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$ins_nhomtin->setTable("nhomtin");
$ins_nhomtin->addColumn("ID_theloai", "NUMERIC_TYPE", "POST", "ID_theloai");
$ins_nhomtin->addColumn("ID_theloaitin", "NUMERIC_TYPE", "POST", "ID_theloaitin");
$ins_nhomtin->addColumn("tennhomtin", "STRING_TYPE", "POST", "tennhomtin");
$ins_nhomtin->addColumn("ngaycapnhat", "DATE_TYPE", "VALUE", "{NOW_DT}");
$ins_nhomtin->addColumn("visible", "CHECKBOX_1_0_TYPE", "POST", "visible", "0");
$ins_nhomtin->setPrimaryKey("ID_nhomtin", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_nhomtin = new tNG_multipleUpdate($conn_conn_vietchuyen);
$tNGs->addTransaction($upd_nhomtin);
// Register triggers
$upd_nhomtin->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_nhomtin->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_nhomtin->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$upd_nhomtin->setTable("nhomtin");
$upd_nhomtin->addColumn("ID_theloai", "NUMERIC_TYPE", "POST", "ID_theloai");
$upd_nhomtin->addColumn("ID_theloaitin", "NUMERIC_TYPE", "POST", "ID_theloaitin");
$upd_nhomtin->addColumn("tennhomtin", "STRING_TYPE", "POST", "tennhomtin");
$upd_nhomtin->addColumn("ngaycapnhat", "DATE_TYPE", "CURRVAL", "");
$upd_nhomtin->addColumn("visible", "CHECKBOX_1_0_TYPE", "POST", "visible");
$upd_nhomtin->setPrimaryKey("ID_nhomtin", "NUMERIC_TYPE", "GET", "ID_nhomtin");

// Make an instance of the transaction object
$del_nhomtin = new tNG_multipleDelete($conn_conn_vietchuyen);
$tNGs->addTransaction($del_nhomtin);
// Register triggers
$del_nhomtin->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_nhomtin->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_nhomtin->setTable("nhomtin");
$del_nhomtin->setPrimaryKey("ID_nhomtin", "NUMERIC_TYPE", "GET", "ID_nhomtin");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsnhomtin = $tNGs->getRecordset("nhomtin");
$row_rsnhomtin = mysql_fetch_assoc($rsnhomtin);
$totalRows_rsnhomtin = mysql_num_rows($rsnhomtin);
?><!DOCTYPE html>
<html xmlns:wdg="http://ns.adobe.com/addt">
<head>
<meta charset="utf-8" />
<title>vietchuyen.edu.vn</title>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script src="../includes/skins/style.js" type="text/javascript"></script>
<?php echo $tNGs->displayValidationRules();?>
<script src="../includes/nxt/scripts/form.js" type="text/javascript"></script>
<script src="../includes/nxt/scripts/form.js.php" type="text/javascript"></script>
<script type="text/javascript">
$NXT_FORM_SETTINGS = {
  duplicate_buttons: true,
  show_as_grid: true,
  merge_down_value: true
}
</script>
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/JSRecordset.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/DependentDropdown.js"></script>
<?php
//begin JSRecordset
$jsObject_rs_theloaitin = new WDG_JsRecordset("rs_theloaitin");
echo $jsObject_rs_theloaitin->getOutput();
//end JSRecordset
?>
</head>

<body>
<div class="KT_tng">
  <h1>
    <?php 
// Show IF Conditional region1 
if (@$_GET['ID_nhomtin'] == "") {
?>
      <?php echo NXT_getResource("Insert_FH"); ?>
      <?php 
// else Conditional region1
} else { ?>
      <?php echo NXT_getResource("Update_FH"); ?>
      <?php } 
// endif Conditional region1
?>
    Nhomtin </h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rsnhomtin > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table width="99%" cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td width="20%" class="KT_th"><label for="ID_theloai_<?php echo $cnt1; ?>">Danh mục tin cấp 1:</label></td>
            <td width="80%"><select name="ID_theloai_<?php echo $cnt1; ?>" id="ID_theloai_<?php echo $cnt1; ?>">
              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
              <?php 
do {  
?>
              <option value="<?php echo $row_rs_theloai['ID_theloai']?>"<?php if (!(strcmp($row_rs_theloai['ID_theloai'], $row_rsnhomtin['ID_theloai']))) {echo "SELECTED";} ?>><?php echo $row_rs_theloai['tentheloai']?></option>
              <?php
} while ($row_rs_theloai = mysql_fetch_assoc($rs_theloai));
  $rows = mysql_num_rows($rs_theloai);
  if($rows > 0) {
      mysql_data_seek($rs_theloai, 0);
	  $row_rs_theloai = mysql_fetch_assoc($rs_theloai);
  }
?>
            </select>
                <?php echo $tNGs->displayFieldError("nhomtin", "ID_theloai", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="ID_theloaitin_<?php echo $cnt1; ?>">Danh mục tin cấp 2:</label></td>
            <td><select name="ID_theloaitin_<?php echo $cnt1; ?>" id="ID_theloaitin_<?php echo $cnt1; ?>" wdg:subtype="DependentDropdown" wdg:type="widget" wdg:recordset="rs_theloaitin" wdg:displayfield="tentheloaitin" wdg:valuefield="ID_theloaitin" wdg:fkey="ID_theloai" wdg:triggerobject="ID_theloai_<?php echo $cnt1; ?>" wdg:selected="<?php echo $row_rsnhomtin['ID_theloaitin'] ?>">
              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
            </select>
                <?php echo $tNGs->displayFieldError("nhomtin", "ID_theloaitin", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="tennhomtin_<?php echo $cnt1; ?>">Tennhomtin:</label></td>
            <td><input type="text" name="tennhomtin_<?php echo $cnt1; ?>" id="tennhomtin_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsnhomtin['tennhomtin']); ?>" size="32" maxlength="55" />
                <?php echo $tNGs->displayFieldHint("tennhomtin");?> <?php echo $tNGs->displayFieldError("nhomtin", "tennhomtin", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th">Ngày cập nhật:</td>
            <td><?php echo KT_formatDate($row_rsnhomtin['ngaycapnhat']); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="visible_<?php echo $cnt1; ?>">Visible:</label></td>
            <td><input  <?php if (!(strcmp(KT_escapeAttribute($row_rsnhomtin['visible']),"1"))) {echo "checked";} ?> type="checkbox" name="visible_<?php echo $cnt1; ?>" id="visible_<?php echo $cnt1; ?>" value="1" />
                <?php echo $tNGs->displayFieldError("nhomtin", "visible", $cnt1); ?> </td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_nhomtin_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsnhomtin['kt_pk_nhomtin']); ?>" />
        <?php } while ($row_rsnhomtin = mysql_fetch_assoc($rsnhomtin)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['ID_nhomtin'] == "") {
      ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
            <?php 
      // else Conditional region1
      } else { ?>
            <div class="KT_operations">
              <input type="submit" name="KT_Insert1" value="<?php echo NXT_getResource("Insert as new_FB"); ?>" onclick="nxt_form_insertasnew(this, 'ID_nhomtin')" />
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
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rs_theloai);

mysql_free_result($Recordset1);

mysql_free_result($rs_theloaitin);

mysql_free_result($Recordset2);
?>
