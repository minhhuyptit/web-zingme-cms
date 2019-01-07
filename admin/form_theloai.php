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
$formValidation->addField("tentheloai", true, "text", "", "", "", "Xin vui lòng nhập danh mục tin cấp 1");
$formValidation->addField("keyword", true, "text", "", "", "", "Xin vui lòng nhập từ khóa");
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
  $tblFldObj->setTable("theloai");
  $tblFldObj->addFieldName("tentheloai");
  $tblFldObj->setErrorMsg("Danh mục tin này đã có rồi");
  return $tblFldObj->Execute();
}
//end Trigger_CheckUnique trigger

// Make an insert transaction instance
$ins_theloai = new tNG_multipleInsert($conn_conn_vietchuyen);
$tNGs->addTransaction($ins_theloai);
// Register triggers
$ins_theloai->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_theloai->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_theloai->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$ins_theloai->registerTrigger("BEFORE", "Trigger_SetOrderColumn", 50);
$ins_theloai->registerTrigger("BEFORE", "Trigger_CheckUnique", 30);
// Add columns
$ins_theloai->setTable("theloai");
$ins_theloai->addColumn("tentheloai", "STRING_TYPE", "POST", "tentheloai");
$ins_theloai->addColumn("keyword", "STRING_TYPE", "POST", "keyword");
$ins_theloai->addColumn("visiblemenu1", "CHECKBOX_1_0_TYPE", "POST", "visiblemenu1", "0");
$ins_theloai->addColumn("visible1", "CHECKBOX_1_0_TYPE", "POST", "visible1", "0");
$ins_theloai->addColumn("linkngoai", "CHECKBOX_1_0_TYPE", "POST", "linkngoai", "0");
$ins_theloai->addColumn("url", "STRING_TYPE", "POST", "url");
$ins_theloai->addColumn("target", "STRING_TYPE", "POST", "target");
$ins_theloai->setPrimaryKey("ID_theloai", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_theloai = new tNG_multipleUpdate($conn_conn_vietchuyen);
$tNGs->addTransaction($upd_theloai);
// Register triggers
$upd_theloai->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_theloai->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_theloai->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$upd_theloai->registerTrigger("BEFORE", "Trigger_CheckUnique", 30);
// Add columns
$upd_theloai->setTable("theloai");
$upd_theloai->addColumn("tentheloai", "STRING_TYPE", "POST", "tentheloai");
$upd_theloai->addColumn("keyword", "STRING_TYPE", "POST", "keyword");
$upd_theloai->addColumn("visiblemenu1", "CHECKBOX_1_0_TYPE", "POST", "visiblemenu1");
$upd_theloai->addColumn("visible1", "CHECKBOX_1_0_TYPE", "POST", "visible1");
$upd_theloai->addColumn("linkngoai", "CHECKBOX_1_0_TYPE", "POST", "linkngoai");
$upd_theloai->addColumn("url", "STRING_TYPE", "POST", "url");
$upd_theloai->addColumn("target", "STRING_TYPE", "POST", "target");
$upd_theloai->setPrimaryKey("ID_theloai", "NUMERIC_TYPE", "GET", "ID_theloai");

// Make an instance of the transaction object
$del_theloai = new tNG_multipleDelete($conn_conn_vietchuyen);
$tNGs->addTransaction($del_theloai);
// Register triggers
$del_theloai->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_theloai->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_theloai->setTable("theloai");
$del_theloai->setPrimaryKey("ID_theloai", "NUMERIC_TYPE", "GET", "ID_theloai");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rstheloai = $tNGs->getRecordset("theloai");
$row_rstheloai = mysql_fetch_assoc($rstheloai);
$totalRows_rstheloai = mysql_num_rows($rstheloai);
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
<script type="text/javascript">
<!--
function FillBilling(f) {
  //if(f.billingtoo.checked == true) {
  str = f.tentheloai.value;
  str= str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a");  
  str= str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e");  
  str= str.replace(/ì|í|ị|ỉ|ĩ/g,"i");  
  str= str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,"o");  
  str= str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u");  
  str= str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y");  
  str= str.replace(/đ/g,"d"); 
  str= str.replace(/Đ/g,"D");
  str= str.replace(/Â/g,"A"); 
  str= str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_/g,"-"); 
/* tìm và thay thế các kí tự đặc biệt trong chuỗi sang kí tự - */ 
  str= str.replace(/-+-/g,"-"); //thay thế 2- thành 1- 
  str= str.replace(/^\-+|\-+$/g,"");
  
    f.keyword.value = str;
    //f.keyword.value = f.tieudetin.value;
  //}
}
function FillBilling1(f) {
  //if(f.billingtoo.checked == true) {
  str = f.tieudetin_CN.value;
  str= str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a");  
  str= str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e");  
  str= str.replace(/ì|í|ị|ỉ|ĩ/g,"i");  
  str= str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,"o");  
  str= str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u");  
  str= str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y");  
  str= str.replace(/đ/g,"d");  
  str= str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_/g,"-"); 
/* tìm và thay thế các kí tự đặc biệt trong chuỗi sang kí tự - */ 
  str= str.replace(/-+-/g,"-"); //thay thế 2- thành 1- 
  str= str.replace(/^\-+|\-+$/g,"");
  
    f.keyword_CN.value = str;
    //f.keyword.value = f.tieudetin.value;
  //}
}
// -->
</script>
</head>
<body>
<div class="KT_tng">
  <h1>
    <?php 
// Show IF Conditional region1 
if (@$_GET['ID_theloai'] == "") {
?>
      <?php echo NXT_getResource("Insert_FH"); ?>
      <?php 
// else Conditional region1
} else { ?>
      <?php echo NXT_getResource("Update_FH"); ?>
      <?php } 
// endif Conditional region1
?>
    Danh mục tin cấp 1</h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rstheloai > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table width="99%" cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td width="20%" class="KT_th"><label for="tentheloai">Danh mục tin 1:</label></td>
            <td width="80%"><input type="text" name="tentheloai" id="tentheloai" value="<?php echo KT_escapeAttribute($row_rstheloai['tentheloai']); ?>" size="32" maxlength="70" />
                <?php echo $tNGs->displayFieldHint("tentheloai");?> <?php echo $tNGs->displayFieldError("theloai", "tentheloai", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="keyword">Từ khóa:</label></td>
            <td><input type="text" name="keyword" id="keyword_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rstheloai['keyword']); ?>" size="32"  onClick="FillBilling(this.form)" readonly="readonly" />
                <?php echo $tNGs->displayFieldHint("keyword");?> <?php echo $tNGs->displayFieldError("theloai", "keyword", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="visiblemenu1_<?php echo $cnt1; ?>">Hiện danh mục:</label></td>
            <td><input  <?php if (!(strcmp(KT_escapeAttribute($row_rstheloai['visiblemenu1']),"1"))) {echo "checked";} ?> type="checkbox" name="visiblemenu1_<?php echo $cnt1; ?>" id="visiblemenu1_<?php echo $cnt1; ?>" value="1" />
                <?php echo $tNGs->displayFieldError("theloai", "visiblemenu1", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="visible1_<?php echo $cnt1; ?>">Nhóm danh mục:</label></td>
            <td><input  <?php if (!(strcmp(KT_escapeAttribute($row_rstheloai['visible1']),"1"))) {echo "checked";} ?> type="checkbox" name="visible1_<?php echo $cnt1; ?>" id="visible1_<?php echo $cnt1; ?>" value="1" />
                <?php echo $tNGs->displayFieldError("theloai", "visible1", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="linkngoai_<?php echo $cnt1; ?>">Link ngoài:</label></td>
            <td><input  <?php if (!(strcmp(KT_escapeAttribute($row_rstheloai['linkngoai']),"1"))) {echo "checked";} ?> type="checkbox" name="linkngoai_<?php echo $cnt1; ?>" id="linkngoai_<?php echo $cnt1; ?>" value="1" />
                <?php echo $tNGs->displayFieldError("theloai", "linkngoai", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="url_<?php echo $cnt1; ?>">URL:</label></td>
            <td><input type="text" name="url_<?php echo $cnt1; ?>" id="url_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rstheloai['url']); ?>" size="32" maxlength="65" />
                <?php echo $tNGs->displayFieldHint("url");?> <?php echo $tNGs->displayFieldError("theloai", "url", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="target_<?php echo $cnt1; ?>">Target:</label></td>
            <td><select name="target_<?php echo $cnt1; ?>" id="target_<?php echo $cnt1; ?>">
                <option value="_blank" <?php if (!(strcmp("_blank", KT_escapeAttribute($row_rstheloai['target'])))) {echo "SELECTED";} ?>>Mở cửa sổ mới</option>
                <option value="_self" <?php if (!(strcmp("_self", KT_escapeAttribute($row_rstheloai['target'])))) {echo "SELECTED";} ?>>Hiện cùng cửa sở</option>
              </select>
                <?php echo $tNGs->displayFieldError("theloai", "target", $cnt1); ?> </td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_theloai_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rstheloai['kt_pk_theloai']); ?>" />
        <?php } while ($row_rstheloai = mysql_fetch_assoc($rstheloai)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['ID_theloai'] == "") {
      ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
            <?php 
      // else Conditional region1
      } else { ?>
            <div class="KT_operations">
              <input type="submit" name="KT_Insert1" value="<?php echo NXT_getResource("Insert as new_FB"); ?>" onclick="nxt_form_insertasnew(this, 'ID_theloai')" />
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