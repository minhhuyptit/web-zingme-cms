<?php require_once('../Connections/conn_vietchuyen.php'); ?><?php
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
$formValidation->addField("tentheloaigame", true, "text", "", "", "", "Xin vui lòng nhập danh mục game");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_SetOrderColumn trigger
//remove this line if you want to edit the code by hand 
function Trigger_SetOrderColumn(&$tNG) {
  $orderFieldObj = new tNG_SetOrderField($tNG);
  $orderFieldObj->setFieldName("sapxep");
  return $orderFieldObj->Execute();
}
//end Trigger_SetOrderColumn trigger

//start Trigger_CheckUnique trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckUnique(&$tNG) {
  $tblFldObj = new tNG_CheckUnique($tNG);
  $tblFldObj->setTable("theloaigame");
  $tblFldObj->addFieldName("tentheloaigame");
  $tblFldObj->setErrorMsg("Danh mục game này đã có rồi trong hệ thống.");
  return $tblFldObj->Execute();
}
//end Trigger_CheckUnique trigger

// Make an insert transaction instance
$ins_theloaigame = new tNG_multipleInsert($conn_conn_vietchuyen);
$tNGs->addTransaction($ins_theloaigame);
// Register triggers
$ins_theloaigame->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_theloaigame->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_theloaigame->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$ins_theloaigame->registerTrigger("BEFORE", "Trigger_SetOrderColumn", 50);
$ins_theloaigame->registerTrigger("BEFORE", "Trigger_CheckUnique", 30);
// Add columns
$ins_theloaigame->setTable("theloaigame");
$ins_theloaigame->addColumn("tentheloaigame", "STRING_TYPE", "POST", "tentheloaigame");
$ins_theloaigame->addColumn("visiblemenu", "CHECKBOX_1_0_TYPE", "POST", "visiblemenu", "0");
$ins_theloaigame->addColumn("visible", "CHECKBOX_1_0_TYPE", "POST", "visible", "0");
$ins_theloaigame->setPrimaryKey("ID_theloaigame", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_theloaigame = new tNG_multipleUpdate($conn_conn_vietchuyen);
$tNGs->addTransaction($upd_theloaigame);
// Register triggers
$upd_theloaigame->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_theloaigame->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_theloaigame->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$upd_theloaigame->registerTrigger("BEFORE", "Trigger_CheckUnique", 30);
// Add columns
$upd_theloaigame->setTable("theloaigame");
$upd_theloaigame->addColumn("tentheloaigame", "STRING_TYPE", "POST", "tentheloaigame");
$upd_theloaigame->addColumn("visiblemenu", "CHECKBOX_1_0_TYPE", "POST", "visiblemenu");
$upd_theloaigame->addColumn("visible", "CHECKBOX_1_0_TYPE", "POST", "visible");
$upd_theloaigame->setPrimaryKey("ID_theloaigame", "NUMERIC_TYPE", "GET", "ID_theloaigame");

// Make an instance of the transaction object
$del_theloaigame = new tNG_multipleDelete($conn_conn_vietchuyen);
$tNGs->addTransaction($del_theloaigame);
// Register triggers
$del_theloaigame->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_theloaigame->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_theloaigame->setTable("theloaigame");
$del_theloaigame->setPrimaryKey("ID_theloaigame", "NUMERIC_TYPE", "GET", "ID_theloaigame");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rstheloaigame = $tNGs->getRecordset("theloaigame");
$row_rstheloaigame = mysql_fetch_assoc($rstheloaigame);
$totalRows_rstheloaigame = mysql_num_rows($rstheloaigame);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
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
</head>

<body>
<div class="KT_tng">
  <h1>
    <?php 
// Show IF Conditional region1 
if (@$_GET['ID_theloaigame'] == "") {
?>
      <?php echo NXT_getResource("Insert_FH"); ?>
      <?php 
// else Conditional region1
} else { ?>
      <?php echo NXT_getResource("Update_FH"); ?>
      <?php } 
// endif Conditional region1
?>
    Danh mục game</h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rstheloaigame > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table width="99%" cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td class="KT_th"><label for="tentheloaigame_<?php echo $cnt1; ?>">Danh mục game:</label></td>
            <td><input type="text" name="tentheloaigame_<?php echo $cnt1; ?>" id="tentheloaigame_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rstheloaigame['tentheloaigame']); ?>" size="32" maxlength="45" />
                <?php echo $tNGs->displayFieldHint("tentheloaigame");?> <?php echo $tNGs->displayFieldError("theloaigame", "tentheloaigame", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="visiblemenu_<?php echo $cnt1; ?>">Hiện danh mục:</label></td>
            <td><input  <?php if (!(strcmp(KT_escapeAttribute($row_rstheloaigame['visiblemenu']),"1"))) {echo "checked";} ?> type="checkbox" name="visiblemenu_<?php echo $cnt1; ?>" id="visiblemenu_<?php echo $cnt1; ?>" value="1" />
                <?php echo $tNGs->displayFieldError("theloaigame", "visiblemenu", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="visible_<?php echo $cnt1; ?>">Nhóm danh mục:</label></td>
            <td><input  <?php if (!(strcmp(KT_escapeAttribute($row_rstheloaigame['visible']),"1"))) {echo "checked";} ?> type="checkbox" name="visible_<?php echo $cnt1; ?>" id="visible_<?php echo $cnt1; ?>" value="1" />
                <?php echo $tNGs->displayFieldError("theloaigame", "visible", $cnt1); ?> </td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_theloaigame_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rstheloaigame['kt_pk_theloaigame']); ?>" />
        <?php } while ($row_rstheloaigame = mysql_fetch_assoc($rstheloaigame)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['ID_theloaigame'] == "") {
      ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
            <?php 
      // else Conditional region1
      } else { ?>
            <div class="KT_operations">
              <input type="submit" name="KT_Insert1" value="<?php echo NXT_getResource("Insert as new_FB"); ?>" onclick="nxt_form_insertasnew(this, 'ID_theloaigame')" />
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
