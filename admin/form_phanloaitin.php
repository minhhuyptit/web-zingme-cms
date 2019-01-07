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
$formValidation->addField("tenphanloaitin", true, "text", "", "", "", "Xin vui lòng nhập vào tên phân loại tin");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_CheckUnique trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckUnique(&$tNG) {
  $tblFldObj = new tNG_CheckUnique($tNG);
  $tblFldObj->setTable("phanloaitin");
  $tblFldObj->addFieldName("tenphanloaitin");
  $tblFldObj->setErrorMsg("Tên phân loại tin này đã có trong hệ thống rồi");
  return $tblFldObj->Execute();
}
//end Trigger_CheckUnique trigger

// Make an insert transaction instance
$ins_phanloaitin = new tNG_multipleInsert($conn_conn_vietchuyen);
$tNGs->addTransaction($ins_phanloaitin);
// Register triggers
$ins_phanloaitin->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_phanloaitin->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_phanloaitin->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$ins_phanloaitin->registerTrigger("BEFORE", "Trigger_CheckUnique", 30);
// Add columns
$ins_phanloaitin->setTable("phanloaitin");
$ins_phanloaitin->addColumn("tenphanloaitin", "STRING_TYPE", "POST", "tenphanloaitin");
$ins_phanloaitin->setPrimaryKey("ID_phanloaitin", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_phanloaitin = new tNG_multipleUpdate($conn_conn_vietchuyen);
$tNGs->addTransaction($upd_phanloaitin);
// Register triggers
$upd_phanloaitin->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_phanloaitin->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_phanloaitin->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$upd_phanloaitin->registerTrigger("BEFORE", "Trigger_CheckUnique", 30);
// Add columns
$upd_phanloaitin->setTable("phanloaitin");
$upd_phanloaitin->addColumn("tenphanloaitin", "STRING_TYPE", "POST", "tenphanloaitin");
$upd_phanloaitin->setPrimaryKey("ID_phanloaitin", "NUMERIC_TYPE", "GET", "ID_phanloaitin");

// Make an instance of the transaction object
$del_phanloaitin = new tNG_multipleDelete($conn_conn_vietchuyen);
$tNGs->addTransaction($del_phanloaitin);
// Register triggers
$del_phanloaitin->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_phanloaitin->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_phanloaitin->setTable("phanloaitin");
$del_phanloaitin->setPrimaryKey("ID_phanloaitin", "NUMERIC_TYPE", "GET", "ID_phanloaitin");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsphanloaitin = $tNGs->getRecordset("phanloaitin");
$row_rsphanloaitin = mysql_fetch_assoc($rsphanloaitin);
$totalRows_rsphanloaitin = mysql_num_rows($rsphanloaitin);
?><!DOCTYPE html>
<html>
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
</head>

<body>
<div class="KT_tng">
  <h1>
    <?php 
// Show IF Conditional region1 
if (@$_GET['ID_phanloaitin'] == "") {
?>
      <?php echo NXT_getResource("Insert_FH"); ?>
      <?php 
// else Conditional region1
} else { ?>
      <?php echo NXT_getResource("Update_FH"); ?>
      <?php } 
// endif Conditional region1
?>
    Phân loại tin</h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rsphanloaitin > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table width="99%" cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td width="20%" class="KT_th"><label for="tenphanloaitin_<?php echo $cnt1; ?>">Tên phân loại tin:</label></td>
          <td width="80%"><input type="text" name="tenphanloaitin_<?php echo $cnt1; ?>" id="tenphanloaitin_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsphanloaitin['tenphanloaitin']); ?>" size="60" maxlength="100" />
                <?php echo $tNGs->displayFieldHint("tenphanloaitin");?> <?php echo $tNGs->displayFieldError("phanloaitin", "tenphanloaitin", $cnt1); ?> </td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_phanloaitin_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsphanloaitin['kt_pk_phanloaitin']); ?>" />
        <?php } while ($row_rsphanloaitin = mysql_fetch_assoc($rsphanloaitin)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['ID_phanloaitin'] == "") {
      ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
            <?php 
      // else Conditional region1
      } else { ?>
            <div class="KT_operations">
              <input type="submit" name="KT_Insert1" value="<?php echo NXT_getResource("Insert as new_FB"); ?>" onclick="nxt_form_insertasnew(this, 'ID_phanloaitin')" />
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
