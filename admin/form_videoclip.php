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
$formValidation->addField("tenvideoclip", true, "text", "", "", "", "Xin vui lòng nhập vào tên videoclip.");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_FileDelete1 trigger
//remove this line if you want to edit the code by hand 
function Trigger_FileDelete1(&$tNG) {
  $deleteObj = new tNG_FileDelete($tNG);
  $deleteObj->setFolder("../video/");
  $deleteObj->setDbFieldName("taptinvideoclip");
  return $deleteObj->Execute();
}
//end Trigger_FileDelete1 trigger

//start Trigger_FileUpload trigger
//remove this line if you want to edit the code by hand 
function Trigger_FileUpload(&$tNG) {
  $uploadObj = new tNG_FileUpload($tNG);
  $uploadObj->setFormFieldName("taptinvideoclip");
  $uploadObj->setDbFieldName("taptinvideoclip");
  $uploadObj->setFolder("../video/");
  $uploadObj->setMaxSize(100000);
  $uploadObj->setAllowedExtensions("flv");
  $uploadObj->setRename("auto");
  return $uploadObj->Execute();
}
//end Trigger_FileUpload trigger

//start Trigger_FileDelete trigger
//remove this line if you want to edit the code by hand 
function Trigger_FileDelete(&$tNG) {
  $deleteObj = new tNG_FileDelete($tNG);
  $deleteObj->setFolder("../images/");
  $deleteObj->setDbFieldName("hinhvideoclip");
  return $deleteObj->Execute();
}
//end Trigger_FileDelete trigger

//start Trigger_ImageUpload trigger
//remove this line if you want to edit the code by hand 
function Trigger_ImageUpload(&$tNG) {
  $uploadObj = new tNG_ImageUpload($tNG);
  $uploadObj->setFormFieldName("hinhvideoclip");
  $uploadObj->setDbFieldName("hinhvideoclip");
  $uploadObj->setFolder("../images/");
  $uploadObj->setMaxSize(5000);
  $uploadObj->setAllowedExtensions("gif, jpg, jpe, jpeg, png");
  $uploadObj->setRename("auto");
  return $uploadObj->Execute();
}
//end Trigger_ImageUpload trigger

// Make an insert transaction instance
$ins_videoclip = new tNG_multipleInsert($conn_conn_vietchuyen);
$tNGs->addTransaction($ins_videoclip);
// Register triggers
$ins_videoclip->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_videoclip->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_videoclip->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$ins_videoclip->registerTrigger("AFTER", "Trigger_ImageUpload", 97);
$ins_videoclip->registerTrigger("AFTER", "Trigger_FileUpload", 97);
// Add columns
$ins_videoclip->setTable("videoclip");
$ins_videoclip->addColumn("tenvideoclip", "STRING_TYPE", "POST", "tenvideoclip");
$ins_videoclip->addColumn("hinhvideoclip", "FILE_TYPE", "FILES", "hinhvideoclip");
$ins_videoclip->addColumn("taptinvideoclip", "FILE_TYPE", "FILES", "taptinvideoclip");
$ins_videoclip->addColumn("youtube", "STRING_TYPE", "POST", "youtube");
$ins_videoclip->addColumn("ngaycapnhat", "DATE_TYPE", "VALUE", "{NOW_DT}");
$ins_videoclip->addColumn("visible", "CHECKBOX_1_0_TYPE", "POST", "visible", "0");
$ins_videoclip->setPrimaryKey("ID_videoclip", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_videoclip = new tNG_multipleUpdate($conn_conn_vietchuyen);
$tNGs->addTransaction($upd_videoclip);
// Register triggers
$upd_videoclip->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_videoclip->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_videoclip->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$upd_videoclip->registerTrigger("AFTER", "Trigger_ImageUpload", 97);
$upd_videoclip->registerTrigger("AFTER", "Trigger_FileUpload", 97);
// Add columns
$upd_videoclip->setTable("videoclip");
$upd_videoclip->addColumn("tenvideoclip", "STRING_TYPE", "POST", "tenvideoclip");
$upd_videoclip->addColumn("hinhvideoclip", "FILE_TYPE", "FILES", "hinhvideoclip");
$upd_videoclip->addColumn("taptinvideoclip", "FILE_TYPE", "FILES", "taptinvideoclip");
$upd_videoclip->addColumn("youtube", "STRING_TYPE", "POST", "youtube");
$upd_videoclip->addColumn("ngaycapnhat", "DATE_TYPE", "CURRVAL", "");
$upd_videoclip->addColumn("visible", "CHECKBOX_1_0_TYPE", "POST", "visible");
$upd_videoclip->setPrimaryKey("ID_videoclip", "NUMERIC_TYPE", "GET", "ID_videoclip");

// Make an instance of the transaction object
$del_videoclip = new tNG_multipleDelete($conn_conn_vietchuyen);
$tNGs->addTransaction($del_videoclip);
// Register triggers
$del_videoclip->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_videoclip->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$del_videoclip->registerTrigger("AFTER", "Trigger_FileDelete", 98);
$del_videoclip->registerTrigger("AFTER", "Trigger_FileDelete1", 98);
// Add columns
$del_videoclip->setTable("videoclip");
$del_videoclip->setPrimaryKey("ID_videoclip", "NUMERIC_TYPE", "GET", "ID_videoclip");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsvideoclip = $tNGs->getRecordset("videoclip");
$row_rsvideoclip = mysql_fetch_assoc($rsvideoclip);
$totalRows_rsvideoclip = mysql_num_rows($rsvideoclip);

// Show Dynamic Thumbnail
$objDynamicThumb1 = new tNG_DynamicThumbnail("../", "KT_thumbnail1");
$objDynamicThumb1->setFolder("../images/");
$objDynamicThumb1->setRenameRule("{rsvideoclip.hinhvideoclip}");
$objDynamicThumb1->setResize(100, 0, true);
$objDynamicThumb1->setWatermark(false);
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
if (@$_GET['ID_videoclip'] == "") {
?>
      <?php echo NXT_getResource("Insert_FH"); ?>
      <?php 
// else Conditional region1
} else { ?>
      <?php echo NXT_getResource("Update_FH"); ?>
      <?php } 
// endif Conditional region1
?>
    Videoclip </h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" enctype="multipart/form-data">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rsvideoclip > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table width="99%" cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td width="20%" class="KT_th"><label for="tenvideoclip_<?php echo $cnt1; ?>">Tên Videoclip:</label></td>
          <td colspan="2"><input type="text" name="tenvideoclip_<?php echo $cnt1; ?>" id="tenvideoclip_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsvideoclip['tenvideoclip']); ?>" size="32" maxlength="255" />
                <?php echo $tNGs->displayFieldHint("tenvideoclip");?> <?php echo $tNGs->displayFieldError("videoclip", "tenvideoclip", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="hinhvideoclip_<?php echo $cnt1; ?>">Hình Videoclip:</label></td>
            <td width="68%"><input type="file" name="hinhvideoclip_<?php echo $cnt1; ?>" id="hinhvideoclip_<?php echo $cnt1; ?>" size="32" />
                <?php echo $tNGs->displayFieldError("videoclip", "hinhvideoclip", $cnt1); ?> </td>
            <td width="12%"><?php 
// Show If File Exists (region4)
if (tNG_fileExists("../images/", "{rsvideoclip.hinhvideoclip}")) {
?>
                <img src="<?php echo $objDynamicThumb1->Execute(); ?>" border="0" />
                <?php } 
// EndIf File Exists (region4)
?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="taptinvideoclip_<?php echo $cnt1; ?>">Tập tin Videoclip:</label></td>
            <td colspan="2"><input type="file" name="taptinvideoclip_<?php echo $cnt1; ?>" id="taptinvideoclip_<?php echo $cnt1; ?>" size="32" />
                <?php echo $tNGs->displayFieldError("videoclip", "taptinvideoclip", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="youtube_<?php echo $cnt1; ?>">Youtube:</label></td>
            <td colspan="2"><input type="text" name="youtube_<?php echo $cnt1; ?>" id="youtube_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsvideoclip['youtube']); ?>" size="32" maxlength="255" />
                <?php echo $tNGs->displayFieldHint("youtube");?> <?php echo $tNGs->displayFieldError("videoclip", "youtube", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th">Ngày cập nhật:</td>
            <td colspan="2"><?php echo KT_formatDate($row_rsvideoclip['ngaycapnhat']); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="visible_<?php echo $cnt1; ?>">Visible:</label></td>
            <td colspan="2"><input  <?php if (!(strcmp(KT_escapeAttribute($row_rsvideoclip['visible']),"1"))) {echo "checked";} ?> type="checkbox" name="visible_<?php echo $cnt1; ?>" id="visible_<?php echo $cnt1; ?>" value="1" />
                <?php echo $tNGs->displayFieldError("videoclip", "visible", $cnt1); ?> </td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_videoclip_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsvideoclip['kt_pk_videoclip']); ?>" />
        <?php } while ($row_rsvideoclip = mysql_fetch_assoc($rsvideoclip)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['ID_videoclip'] == "") {
      ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
            <?php 
      // else Conditional region1
      } else { ?>
            <div class="KT_operations">
              <input type="submit" name="KT_Insert1" value="<?php echo NXT_getResource("Insert as new_FB"); ?>" onclick="nxt_form_insertasnew(this, 'ID_videoclip')" />
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
