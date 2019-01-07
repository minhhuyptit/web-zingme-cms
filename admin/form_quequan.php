<?php require_once('../Connections/conn_vietchuyen.php'); ?><?php require_once('../Connections/conn_vietchuyen.php'); ?>
<?php
// Load the common classes
require_once('../includes/common/KT_common.php');

// Load the tNG classes
require_once('../includes/tng/tNG.inc.php');

// Load the tNG classes
require_once('../includes/tng/tNG.inc.php');

// Load the KT_back class
require_once('../includes/nxt/KT_back.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../");

// Make unified connection variable
$conn_conn_vietchuyen = new KT_connection($conn_vietchuyen, $database_conn_vietchuyen);

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
$formValidation->addField("tenquequan", true, "text", "", "", "", "Xin vui lòng nhập vào tên quê quán");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_CheckUnique trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckUnique(&$tNG) {
  $tblFldObj = new tNG_CheckUnique($tNG);
  $tblFldObj->setTable("quequan");
  $tblFldObj->addFieldName("tenquequan");
  $tblFldObj->setErrorMsg("Tên quê quán này đã tồn tại rồi");
  return $tblFldObj->Execute();
}
//end Trigger_CheckUnique trigger

// Make an insert transaction instance
$ins_quequan = new tNG_multipleInsert($conn_conn_vietchuyen);
$tNGs->addTransaction($ins_quequan);
// Register triggers
$ins_quequan->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_quequan->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_quequan->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$ins_quequan->registerTrigger("BEFORE", "Trigger_CheckUnique", 30);
// Add columns
$ins_quequan->setTable("quequan");
$ins_quequan->addColumn("tenquequan", "STRING_TYPE", "POST", "tenquequan");
$ins_quequan->setPrimaryKey("ID_quequan", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_quequan = new tNG_multipleUpdate($conn_conn_vietchuyen);
$tNGs->addTransaction($upd_quequan);
// Register triggers
$upd_quequan->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_quequan->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_quequan->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$upd_quequan->registerTrigger("BEFORE", "Trigger_CheckUnique", 30);
// Add columns
$upd_quequan->setTable("quequan");
$upd_quequan->addColumn("tenquequan", "STRING_TYPE", "POST", "tenquequan");
$upd_quequan->setPrimaryKey("ID_quequan", "NUMERIC_TYPE", "GET", "ID_quequan");

// Make an instance of the transaction object
$del_quequan = new tNG_multipleDelete($conn_conn_vietchuyen);
$tNGs->addTransaction($del_quequan);
// Register triggers
$del_quequan->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_quequan->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_quequan->setTable("quequan");
$del_quequan->setPrimaryKey("ID_quequan", "NUMERIC_TYPE", "GET", "ID_quequan");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsquequan = $tNGs->getRecordset("quequan");
$row_rsquequan = mysql_fetch_assoc($rsquequan);
$totalRows_rsquequan = mysql_num_rows($rsquequan);
?><!DOCTYPE html>
<html>
<head><title>vietchuyen.edu.vn</title>
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
if (@$_GET['ID_quequan'] == "") {
?>
      <?php echo NXT_getResource("Insert_FH"); ?>
      <?php 
// else Conditional region1
} else { ?>
      <?php echo NXT_getResource("Update_FH"); ?>
      <?php } 
// endif Conditional region1
?>
    Quê quán</h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rsquequan > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table width="99%" cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td width="20%" class="KT_th"><label for="tenquequan_<?php echo $cnt1; ?>">Tên quê quán:</label></td>
          <td width="80%"><input type="text" name="tenquequan_<?php echo $cnt1; ?>" id="tenquequan_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsquequan['tenquequan']); ?>" size="60" maxlength="65" />
                <?php echo $tNGs->displayFieldHint("tenquequan");?> <?php echo $tNGs->displayFieldError("quequan", "tenquequan", $cnt1); ?> </td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_quequan_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsquequan['kt_pk_quequan']); ?>" />
        <?php } while ($row_rsquequan = mysql_fetch_assoc($rsquequan)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['ID_quequan'] == "") {
      ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
            <?php 
      // else Conditional region1
      } else { ?>
            <div class="KT_operations">
              <input type="submit" name="KT_Insert1" value="<?php echo NXT_getResource("Insert as new_FB"); ?>" onclick="nxt_form_insertasnew(this, 'ID_quequan')" />
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