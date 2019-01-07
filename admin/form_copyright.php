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

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("tenwebsite", true, "text", "", "", "", "Xin vui lòng nhập tên website");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_FileDelete trigger
//remove this line if you want to edit the code by hand 
function Trigger_FileDelete(&$tNG) {
  $deleteObj = new tNG_FileDelete($tNG);
  $deleteObj->setFolder("../images/");
  $deleteObj->setDbFieldName("logo");
  return $deleteObj->Execute();
}
//end Trigger_FileDelete trigger

//start Trigger_ImageUpload trigger
//remove this line if you want to edit the code by hand 
function Trigger_ImageUpload(&$tNG) {
  $uploadObj = new tNG_ImageUpload($tNG);
  $uploadObj->setFormFieldName("logo");
  $uploadObj->setDbFieldName("logo");
  $uploadObj->setFolder("../images/");
  $uploadObj->setMaxSize(5000);
  $uploadObj->setAllowedExtensions("gif, jpg, jpe, jpeg, png");
  $uploadObj->setRename("auto");
  return $uploadObj->Execute();
}
//end Trigger_ImageUpload trigger

// Make an insert transaction instance
$ins_copyright = new tNG_multipleInsert($conn_conn_vietchuyen);
$tNGs->addTransaction($ins_copyright);
// Register triggers
$ins_copyright->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_copyright->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_copyright->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$ins_copyright->registerTrigger("AFTER", "Trigger_ImageUpload", 97);
// Add columns
$ins_copyright->setTable("copyright");
$ins_copyright->addColumn("tenwebsite", "STRING_TYPE", "POST", "tenwebsite");
$ins_copyright->addColumn("logo", "FILE_TYPE", "FILES", "logo");
$ins_copyright->addColumn("diachi", "STRING_TYPE", "POST", "diachi");
$ins_copyright->addColumn("dienthoai", "STRING_TYPE", "POST", "dienthoai");
$ins_copyright->addColumn("email", "STRING_TYPE", "POST", "email");
$ins_copyright->addColumn("website1", "STRING_TYPE", "POST", "website1");
$ins_copyright->addColumn("website2", "STRING_TYPE", "POST", "website2");
$ins_copyright->addColumn("website3", "STRING_TYPE", "POST", "website3");
$ins_copyright->addColumn("motawebsite", "STRING_TYPE", "POST", "motawebsite");
$ins_copyright->addColumn("tukhoaseo", "STRING_TYPE", "POST", "tukhoaseo");
$ins_copyright->setPrimaryKey("ID_copyright", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_copyright = new tNG_multipleUpdate($conn_conn_vietchuyen);
$tNGs->addTransaction($upd_copyright);
// Register triggers
$upd_copyright->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_copyright->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_copyright->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$upd_copyright->registerTrigger("AFTER", "Trigger_ImageUpload", 97);
// Add columns
$upd_copyright->setTable("copyright");
$upd_copyright->addColumn("tenwebsite", "STRING_TYPE", "POST", "tenwebsite");
$upd_copyright->addColumn("logo", "FILE_TYPE", "FILES", "logo");
$upd_copyright->addColumn("diachi", "STRING_TYPE", "POST", "diachi");
$upd_copyright->addColumn("dienthoai", "STRING_TYPE", "POST", "dienthoai");
$upd_copyright->addColumn("email", "STRING_TYPE", "POST", "email");
$upd_copyright->addColumn("website1", "STRING_TYPE", "POST", "website1");
$upd_copyright->addColumn("website2", "STRING_TYPE", "POST", "website2");
$upd_copyright->addColumn("website3", "STRING_TYPE", "POST", "website3");
$upd_copyright->addColumn("motawebsite", "STRING_TYPE", "POST", "motawebsite");
$upd_copyright->addColumn("tukhoaseo", "STRING_TYPE", "POST", "tukhoaseo");
$upd_copyright->setPrimaryKey("ID_copyright", "NUMERIC_TYPE", "GET", "ID_copyright");

// Make an instance of the transaction object
$del_copyright = new tNG_multipleDelete($conn_conn_vietchuyen);
$tNGs->addTransaction($del_copyright);
// Register triggers
$del_copyright->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_copyright->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$del_copyright->registerTrigger("AFTER", "Trigger_FileDelete", 98);
// Add columns
$del_copyright->setTable("copyright");
$del_copyright->setPrimaryKey("ID_copyright", "NUMERIC_TYPE", "GET", "ID_copyright");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rscopyright = $tNGs->getRecordset("copyright");
$row_rscopyright = mysql_fetch_assoc($rscopyright);
$totalRows_rscopyright = mysql_num_rows($rscopyright);

// Show Dynamic Thumbnail
$objDynamicThumb1 = new tNG_DynamicThumbnail("../", "KT_thumbnail1");
$objDynamicThumb1->setFolder("../images/");
$objDynamicThumb1->setRenameRule("{rscopyright.logo}");
$objDynamicThumb1->setResize(100, 0, true);
$objDynamicThumb1->setWatermark(false);

//Start Restrict Access To Page
$restrict = new tNG_RestrictAccess($conn_conn_vietchuyen, "../");
//Grand Levels: Level
$restrict->addLevel("1");
$restrict->Execute();
//End Restrict Access To Page
?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
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
if (@$_GET['ID_copyright'] == "") {
?>
      <?php echo NXT_getResource("Insert_FH"); ?>
      <?php 
// else Conditional region1
} else { ?>
      <?php echo NXT_getResource("Update_FH"); ?>
      <?php } 
// endif Conditional region1
?>
    Copyright </h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" enctype="multipart/form-data">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rscopyright > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table width="99%" cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td width="11%" class="KT_th"><label for="tenwebsite_<?php echo $cnt1; ?>">Tên website:</label></td>
            <td colspan="2"><input type="text" name="tenwebsite_<?php echo $cnt1; ?>" id="tenwebsite_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscopyright['tenwebsite']); ?>" size="45" maxlength="255" />
                <?php echo $tNGs->displayFieldHint("tenwebsite");?> <?php echo $tNGs->displayFieldError("copyright", "tenwebsite", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="logo_<?php echo $cnt1; ?>">Logo:</label></td>
            <td width="30%"><input type="file" name="logo_<?php echo $cnt1; ?>" id="logo_<?php echo $cnt1; ?>" size="45" />
                <?php echo $tNGs->displayFieldError("copyright", "logo", $cnt1); ?> </td>
            <td width="59%"><?php 
// Show If File Exists (region4)
if (tNG_fileExists("../images/", "{rscopyright.logo}")) {
?>
                <img src="<?php echo $objDynamicThumb1->Execute(); ?>" border="0" />
                <?php } 
// EndIf File Exists (region4)
?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="diachi_<?php echo $cnt1; ?>">Địa chỉ:</label></td>
            <td colspan="2"><input type="text" name="diachi_<?php echo $cnt1; ?>" id="diachi_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscopyright['diachi']); ?>" size="45" maxlength="255" />
                <?php echo $tNGs->displayFieldHint("diachi");?> <?php echo $tNGs->displayFieldError("copyright", "diachi", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="dienthoai_<?php echo $cnt1; ?>">Điện thoại:</label></td>
            <td colspan="2"><input type="text" name="dienthoai_<?php echo $cnt1; ?>" id="dienthoai_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscopyright['dienthoai']); ?>" size="45" maxlength="45" />
                <?php echo $tNGs->displayFieldHint("dienthoai");?> <?php echo $tNGs->displayFieldError("copyright", "dienthoai", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="email_<?php echo $cnt1; ?>">Email:</label></td>
            <td colspan="2"><input type="text" name="email_<?php echo $cnt1; ?>" id="email_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscopyright['email']); ?>" size="45" maxlength="100" />
                <?php echo $tNGs->displayFieldHint("email");?> <?php echo $tNGs->displayFieldError("copyright", "email", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="website1_<?php echo $cnt1; ?>">Website1:</label></td>
            <td colspan="2"><input type="text" name="website1_<?php echo $cnt1; ?>" id="website1_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscopyright['website1']); ?>" size="45" maxlength="145" />
                <?php echo $tNGs->displayFieldHint("website1");?> <?php echo $tNGs->displayFieldError("copyright", "website1", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="website2_<?php echo $cnt1; ?>">Website2:</label></td>
            <td colspan="2"><input type="text" name="website2_<?php echo $cnt1; ?>" id="website2_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscopyright['website2']); ?>" size="45" maxlength="145" />
                <?php echo $tNGs->displayFieldHint("website2");?> <?php echo $tNGs->displayFieldError("copyright", "website2", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="website3_<?php echo $cnt1; ?>">Website3:</label></td>
            <td colspan="2"><input type="text" name="website3_<?php echo $cnt1; ?>" id="website3_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscopyright['website3']); ?>" size="45" maxlength="145" />
                <?php echo $tNGs->displayFieldHint("website3");?> <?php echo $tNGs->displayFieldError("copyright", "website3", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="motawebsite_<?php echo $cnt1; ?>">Mô tả website:</label></td>
            <td colspan="2"><textarea name="motawebsite_<?php echo $cnt1; ?>" id="motawebsite_<?php echo $cnt1; ?>" cols="80" rows="5"><?php echo KT_escapeAttribute($row_rscopyright['motawebsite']); ?></textarea>
                <?php echo $tNGs->displayFieldHint("motawebsite");?> <?php echo $tNGs->displayFieldError("copyright", "motawebsite", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="tukhoaseo_<?php echo $cnt1; ?>">Từ khóa seo:</label></td>
            <td colspan="2"><textarea name="tukhoaseo_<?php echo $cnt1; ?>" id="tukhoaseo_<?php echo $cnt1; ?>" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rscopyright['tukhoaseo']); ?></textarea>
                <?php echo $tNGs->displayFieldHint("tukhoaseo");?> <?php echo $tNGs->displayFieldError("copyright", "tukhoaseo", $cnt1); ?> </td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_copyright_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rscopyright['kt_pk_copyright']); ?>" />
        <?php } while ($row_rscopyright = mysql_fetch_assoc($rscopyright)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['ID_copyright'] == "") {
      ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
            <?php 
      // else Conditional region1
      } else { ?>
            <div class="KT_operations">
              <input type="submit" name="KT_Insert1" value="<?php echo NXT_getResource("Insert as new_FB"); ?>" onclick="nxt_form_insertasnew(this, 'ID_copyright')" />
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
