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

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("tieude", true, "text", "", "", "", "Xin vui lòng nhập vào tiêu đề");
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

//start Trigger_FileDelete trigger
//remove this line if you want to edit the code by hand 
function Trigger_FileDelete(&$tNG) {
  $deleteObj = new tNG_FileDelete($tNG);
  $deleteObj->setFolder("../images/quangcao/");
  $deleteObj->setDbFieldName("taptinquangcao");
  return $deleteObj->Execute();
}
//end Trigger_FileDelete trigger

//start Trigger_FileUpload trigger
//remove this line if you want to edit the code by hand 
function Trigger_FileUpload(&$tNG) {
  $uploadObj = new tNG_FileUpload($tNG);
  $uploadObj->setFormFieldName("taptinquangcao");
  $uploadObj->setDbFieldName("taptinquangcao");
  $uploadObj->setFolder("../images/quangcao/");
  $uploadObj->setMaxSize(5000);
  $uploadObj->setAllowedExtensions("jpg, gif, png, swf");
  $uploadObj->setRename("auto");
  return $uploadObj->Execute();
}
//end Trigger_FileUpload trigger

// Make an insert transaction instance
$ins_quangcao = new tNG_multipleInsert($conn_conn_vietchuyen);
$tNGs->addTransaction($ins_quangcao);
// Register triggers
$ins_quangcao->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_quangcao->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_quangcao->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$ins_quangcao->registerTrigger("BEFORE", "Trigger_SetOrderColumn", 50);
$ins_quangcao->registerTrigger("AFTER", "Trigger_FileUpload", 97);
// Add columns
$ins_quangcao->setTable("quangcao");
$ins_quangcao->addColumn("tieude", "STRING_TYPE", "POST", "tieude");
$ins_quangcao->addColumn("taptinquangcao", "FILE_TYPE", "FILES", "taptinquangcao");
$ins_quangcao->addColumn("fileflash", "CHECKBOX_1_0_TYPE", "POST", "fileflash", "0");
$ins_quangcao->addColumn("url", "STRING_TYPE", "POST", "url");
$ins_quangcao->addColumn("target", "STRING_TYPE", "POST", "target");
$ins_quangcao->addColumn("vitri", "STRING_TYPE", "POST", "vitri");
$ins_quangcao->addColumn("visible", "CHECKBOX_1_0_TYPE", "POST", "visible", "0");
$ins_quangcao->setPrimaryKey("ID_quangcao", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_quangcao = new tNG_multipleUpdate($conn_conn_vietchuyen);
$tNGs->addTransaction($upd_quangcao);
// Register triggers
$upd_quangcao->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_quangcao->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_quangcao->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$upd_quangcao->registerTrigger("AFTER", "Trigger_FileUpload", 97);
// Add columns
$upd_quangcao->setTable("quangcao");
$upd_quangcao->addColumn("tieude", "STRING_TYPE", "POST", "tieude");
$upd_quangcao->addColumn("taptinquangcao", "FILE_TYPE", "FILES", "taptinquangcao");
$upd_quangcao->addColumn("fileflash", "CHECKBOX_1_0_TYPE", "POST", "fileflash");
$upd_quangcao->addColumn("url", "STRING_TYPE", "POST", "url");
$upd_quangcao->addColumn("target", "STRING_TYPE", "POST", "target");
$upd_quangcao->addColumn("vitri", "STRING_TYPE", "POST", "vitri");
$upd_quangcao->addColumn("visible", "CHECKBOX_1_0_TYPE", "POST", "visible");
$upd_quangcao->setPrimaryKey("ID_quangcao", "NUMERIC_TYPE", "GET", "ID_quangcao");

// Make an instance of the transaction object
$del_quangcao = new tNG_multipleDelete($conn_conn_vietchuyen);
$tNGs->addTransaction($del_quangcao);
// Register triggers
$del_quangcao->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_quangcao->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$del_quangcao->registerTrigger("AFTER", "Trigger_FileDelete", 98);
// Add columns
$del_quangcao->setTable("quangcao");
$del_quangcao->setPrimaryKey("ID_quangcao", "NUMERIC_TYPE", "GET", "ID_quangcao");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsquangcao = $tNGs->getRecordset("quangcao");
$row_rsquangcao = mysql_fetch_assoc($rsquangcao);
$totalRows_rsquangcao = mysql_num_rows($rsquangcao);
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
<script src="../Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
</head>

<body>
<div class="KT_tng">
  <h1>
    <?php 
// Show IF Conditional region1 
if (@$_GET['ID_quangcao'] == "") {
?>
      <?php echo NXT_getResource("Insert_FH"); ?>
      <?php 
// else Conditional region1
} else { ?>
      <?php echo NXT_getResource("Update_FH"); ?>
      <?php } 
// endif Conditional region1
?>
    Quảng cáo</h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" enctype="multipart/form-data">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rsquangcao > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table width="99%" cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td width="20%" class="KT_th"><label for="tieude_<?php echo $cnt1; ?>">Tiêu đề:</label></td>
          <td colspan="2"><input type="text" name="tieude_<?php echo $cnt1; ?>" id="tieude_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsquangcao['tieude']); ?>" size="32" maxlength="65" />
                <?php echo $tNGs->displayFieldHint("tieude");?> <?php echo $tNGs->displayFieldError("quangcao", "tieude", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="taptinquangcao_<?php echo $cnt1; ?>">Tập tin (JPG/PNG/GIF/SWF):</label></td>
            <td width="31%"><input type="file" name="taptinquangcao_<?php echo $cnt1; ?>" id="taptinquangcao_<?php echo $cnt1; ?>" size="32" />
                <?php echo $tNGs->displayFieldError("quangcao", "taptinquangcao", $cnt1); ?> </td>
            <td width="49%"><?php 
// Show IF Conditional region4 
if (@$row_rsquangcao['fileflash'] == 0) {
?>
                <img src="../images/quangcao/<?php echo $row_rsquangcao['taptinquangcao']; ?>">
                <?php 
// else Conditional region4
} else { ?>
                <script type="text/javascript">
AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','300','height','250','src','../images/quangcao/<?php echo $row_rsquangcao['taptinquangcao']; ?>','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','../images/quangcao/<?php echo $row_rsquangcao['taptinquangcao']; ?>' ); //end AC code
</script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="300" height="250">
                  <param name="movie" value="../images/quangcao/<?php echo $row_rsquangcao['taptinquangcao']; ?>">
                  <param name="quality" value="high">
                  <embed src="../images/quangcao/<?php echo $row_rsquangcao['taptinquangcao']; ?>" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="300" height="250"></embed>
                </object></noscript>
  
  <?php } 
// endif Conditional region4
?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="fileflash_<?php echo $cnt1; ?>">File flash?:</label></td>
            <td colspan="2"><input  <?php if (!(strcmp(KT_escapeAttribute($row_rsquangcao['fileflash']),"1"))) {echo "checked";} ?> type="checkbox" name="fileflash_<?php echo $cnt1; ?>" id="fileflash_<?php echo $cnt1; ?>" value="1" />
                <?php echo $tNGs->displayFieldError("quangcao", "fileflash", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="url_<?php echo $cnt1; ?>">Url:</label></td>
            <td colspan="2"><input type="text" name="url_<?php echo $cnt1; ?>" id="url_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsquangcao['url']); ?>" size="32" maxlength="100" />
                <?php echo $tNGs->displayFieldHint("url");?> <?php echo $tNGs->displayFieldError("quangcao", "url", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="target_<?php echo $cnt1; ?>">Target:</label></td>
            <td colspan="2"><select name="target_<?php echo $cnt1; ?>" id="target_<?php echo $cnt1; ?>">
              <option value="_blank" <?php if (!(strcmp("_blank", KT_escapeAttribute($row_rsquangcao['target'])))) {echo "SELECTED";} ?>>Mở cửa sổ mới</option>
              <option value="_self" <?php if (!(strcmp("_self", KT_escapeAttribute($row_rsquangcao['target'])))) {echo "SELECTED";} ?>>Hiện cùng cửa sổ</option>
            </select>
                <?php echo $tNGs->displayFieldError("quangcao", "target", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="vitri_<?php echo $cnt1; ?>">Vị trí:</label></td>
            <td colspan="2"><select name="vitri_<?php echo $cnt1; ?>" id="vitri_<?php echo $cnt1; ?>">
              <option value="right" <?php if (!(strcmp("right", KT_escapeAttribute($row_rsquangcao['vitri'])))) {echo "SELECTED";} ?>>Cột phải</option>
              <option value="left" <?php if (!(strcmp("left", KT_escapeAttribute($row_rsquangcao['vitri'])))) {echo "SELECTED";} ?>>Cột trái</option>
              <option value="top" <?php if (!(strcmp("top", KT_escapeAttribute($row_rsquangcao['vitri'])))) {echo "SELECTED";} ?>>Bên trên</option>
              <option value="bottom" <?php if (!(strcmp("bottom", KT_escapeAttribute($row_rsquangcao['vitri'])))) {echo "SELECTED";} ?>>Bên dưới</option>
              <option value="center" <?php if (!(strcmp("center", KT_escapeAttribute($row_rsquangcao['vitri'])))) {echo "SELECTED";} ?>>Giữa trang</option>
            </select>
                <?php echo $tNGs->displayFieldError("quangcao", "vitri", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="visible_<?php echo $cnt1; ?>">Visible:</label></td>
            <td colspan="2"><input  <?php if (!(strcmp(KT_escapeAttribute($row_rsquangcao['visible']),"1"))) {echo "checked";} ?> type="checkbox" name="visible_<?php echo $cnt1; ?>" id="visible_<?php echo $cnt1; ?>" value="1" />
                <?php echo $tNGs->displayFieldError("quangcao", "visible", $cnt1); ?> </td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_quangcao_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsquangcao['kt_pk_quangcao']); ?>" />
        <?php } while ($row_rsquangcao = mysql_fetch_assoc($rsquangcao)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['ID_quangcao'] == "") {
      ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
            <?php 
      // else Conditional region1
      } else { ?>
            <div class="KT_operations">
              <input type="submit" name="KT_Insert1" value="<?php echo NXT_getResource("Insert as new_FB"); ?>" onclick="nxt_form_insertasnew(this, 'ID_quangcao')" />
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
