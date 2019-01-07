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
$formValidation->addField("ID_theloai", true, "numeric", "", "", "", "Xin vui lòng chọn danh mục tin cấp 1");
$formValidation->addField("keyseo", true, "text", "", "", "", "Xin vui lòng nhập từ khóa để SEO");
$formValidation->addField("tentheloaitin", true, "text", "", "", "", "Please enter a valid value.");
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

// Make an insert transaction instance
$ins_theloaitin = new tNG_multipleInsert($conn_conn_vietchuyen);
$tNGs->addTransaction($ins_theloaitin);
// Register triggers
$ins_theloaitin->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_theloaitin->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_theloaitin->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$ins_theloaitin->registerTrigger("BEFORE", "Trigger_SetOrderColumn", 50);
// Add columns
$ins_theloaitin->setTable("theloaitin");
$ins_theloaitin->addColumn("ID_theloai", "NUMERIC_TYPE", "POST", "ID_theloai");
$ins_theloaitin->addColumn("keyseo", "STRING_TYPE", "POST", "keyseo");
$ins_theloaitin->addColumn("tentheloaitin", "STRING_TYPE", "POST", "tentheloaitin");
$ins_theloaitin->addColumn("visiblemenu2", "CHECKBOX_1_0_TYPE", "POST", "visiblemenu2", "0");
$ins_theloaitin->addColumn("visible2", "CHECKBOX_1_0_TYPE", "POST", "visible2", "0");
$ins_theloaitin->addColumn("linkngoai", "CHECKBOX_1_0_TYPE", "POST", "linkngoai", "0");
$ins_theloaitin->addColumn("url", "STRING_TYPE", "POST", "url");
$ins_theloaitin->addColumn("target", "STRING_TYPE", "POST", "target");
$ins_theloaitin->setPrimaryKey("ID_theloaitin", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_theloaitin = new tNG_multipleUpdate($conn_conn_vietchuyen);
$tNGs->addTransaction($upd_theloaitin);
// Register triggers
$upd_theloaitin->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_theloaitin->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_theloaitin->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$upd_theloaitin->setTable("theloaitin");
$upd_theloaitin->addColumn("ID_theloai", "NUMERIC_TYPE", "POST", "ID_theloai");
$upd_theloaitin->addColumn("keyseo", "STRING_TYPE", "POST", "keyseo");
$upd_theloaitin->addColumn("tentheloaitin", "STRING_TYPE", "POST", "tentheloaitin");
$upd_theloaitin->addColumn("visiblemenu2", "CHECKBOX_1_0_TYPE", "POST", "visiblemenu2");
$upd_theloaitin->addColumn("visible2", "CHECKBOX_1_0_TYPE", "POST", "visible2");
$upd_theloaitin->addColumn("linkngoai", "CHECKBOX_1_0_TYPE", "POST", "linkngoai");
$upd_theloaitin->addColumn("url", "STRING_TYPE", "POST", "url");
$upd_theloaitin->addColumn("target", "STRING_TYPE", "POST", "target");
$upd_theloaitin->setPrimaryKey("ID_theloaitin", "NUMERIC_TYPE", "GET", "ID_theloaitin");

// Make an instance of the transaction object
$del_theloaitin = new tNG_multipleDelete($conn_conn_vietchuyen);
$tNGs->addTransaction($del_theloaitin);
// Register triggers
$del_theloaitin->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_theloaitin->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_theloaitin->setTable("theloaitin");
$del_theloaitin->setPrimaryKey("ID_theloaitin", "NUMERIC_TYPE", "GET", "ID_theloaitin");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rstheloaitin = $tNGs->getRecordset("theloaitin");
$row_rstheloaitin = mysql_fetch_assoc($rstheloaitin);
$totalRows_rstheloaitin = mysql_num_rows($rstheloaitin);
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
  str = f.tentheloaitin.value;
  str= str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a");  
  str= str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e");  
  str= str.replace(/ì|í|ị|ỉ|ĩ/g,"i");  
  str= str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,"o");  
  str= str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u");  
  str= str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y");  
  str= str.replace(/đ/g,"d"); 
  str= str.replace(/Đ/g,"D");
  str= str.replace(/Â/g,"A");
  str= str.replace(/Ẩ/g,"A"); 
  str= str.replace(/Ả/g,"A");  
  str= str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_/g,"-"); 
/* tìm và thay thế các kí tự đặc biệt trong chuỗi sang kí tự - */ 
  str= str.replace(/-+-/g,"-"); //thay thế 2- thành 1- 
  str= str.replace(/^\-+|\-+$/g,"");
  
    f.keyseo.value = str;
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
if (@$_GET['ID_theloaitin'] == "") {
?>
      <?php echo NXT_getResource("Insert_FH"); ?>
      <?php 
// else Conditional region1
} else { ?>
      <?php echo NXT_getResource("Update_FH"); ?>
      <?php } 
// endif Conditional region1
?>
    Danh mục tin cấp 2</h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rstheloaitin > 1) {
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
                <option value="<?php echo $row_rs_theloai['ID_theloai']?>"<?php if (!(strcmp($row_rs_theloai['ID_theloai'], $row_rstheloaitin['ID_theloai']))) {echo "SELECTED";} ?>><?php echo $row_rs_theloai['tentheloai']?></option>
                <?php
} while ($row_rs_theloai = mysql_fetch_assoc($rs_theloai));
  $rows = mysql_num_rows($rs_theloai);
  if($rows > 0) {
      mysql_data_seek($rs_theloai, 0);
	  $row_rs_theloai = mysql_fetch_assoc($rs_theloai);
  }
?>
              </select>
                <?php echo $tNGs->displayFieldError("theloaitin", "ID_theloai", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="keyseo">Từ khóa:</label></td>
            <td><input type="text" name="keyseo" id="keyseo" value="<?php echo KT_escapeAttribute($row_rstheloaitin['keyseo']); ?>" size="32" onClick="FillBilling(this.form)" readonly="readonly" />
                <?php echo $tNGs->displayFieldHint("keyseo");?> <?php echo $tNGs->displayFieldError("theloaitin", "keyseo", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="tentheloaitin">Danh mục tin cấp 2:</label></td>
            <td><input type="text" name="tentheloaitin" id="tentheloaitin" value="<?php echo KT_escapeAttribute($row_rstheloaitin['tentheloaitin']); ?>" size="32" maxlength="65" />
                <?php echo $tNGs->displayFieldHint("tentheloaitin");?> <?php echo $tNGs->displayFieldError("theloaitin", "tentheloaitin", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="visiblemenu2_<?php echo $cnt1; ?>">Hiện danh mục:</label></td>
            <td><input  <?php if (!(strcmp(KT_escapeAttribute($row_rstheloaitin['visiblemenu2']),"1"))) {echo "checked";} ?> type="checkbox" name="visiblemenu2_<?php echo $cnt1; ?>" id="visiblemenu2_<?php echo $cnt1; ?>" value="1" />
                <?php echo $tNGs->displayFieldError("theloaitin", "visiblemenu2", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="visible2_<?php echo $cnt1; ?>">Nhóm danh mục:</label></td>
            <td><input  <?php if (!(strcmp(KT_escapeAttribute($row_rstheloaitin['visible2']),"1"))) {echo "checked";} ?> type="checkbox" name="visible2_<?php echo $cnt1; ?>" id="visible2_<?php echo $cnt1; ?>" value="1" />
                <?php echo $tNGs->displayFieldError("theloaitin", "visible2", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="linkngoai_<?php echo $cnt1; ?>">Link ngoài:</label></td>
            <td><input  <?php if (!(strcmp(KT_escapeAttribute($row_rstheloaitin['linkngoai']),"1"))) {echo "checked";} ?> type="checkbox" name="linkngoai_<?php echo $cnt1; ?>" id="linkngoai_<?php echo $cnt1; ?>" value="1" />
                <?php echo $tNGs->displayFieldError("theloaitin", "linkngoai", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="url_<?php echo $cnt1; ?>">Url:</label></td>
            <td><input type="text" name="url_<?php echo $cnt1; ?>" id="url_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rstheloaitin['url']); ?>" size="32" maxlength="65" />
                <?php echo $tNGs->displayFieldHint("url");?> <?php echo $tNGs->displayFieldError("theloaitin", "url", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="target_<?php echo $cnt1; ?>">Target:</label></td>
            <td><select name="target_<?php echo $cnt1; ?>" id="target_<?php echo $cnt1; ?>">
                <option value="_blank" <?php if (!(strcmp("_blank", KT_escapeAttribute($row_rstheloaitin['target'])))) {echo "SELECTED";} ?>>Mở cửa sổ mới</option>
                <option value="_self" <?php if (!(strcmp("_self", KT_escapeAttribute($row_rstheloaitin['target'])))) {echo "SELECTED";} ?>>Hiện cùng cửa sổ</option>
              </select>
                <?php echo $tNGs->displayFieldError("theloaitin", "target", $cnt1); ?> </td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_theloaitin_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rstheloaitin['kt_pk_theloaitin']); ?>" />
        <?php } while ($row_rstheloaitin = mysql_fetch_assoc($rstheloaitin)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['ID_theloaitin'] == "") {
      ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
            <?php 
      // else Conditional region1
      } else { ?>
            <div class="KT_operations">
              <input type="submit" name="KT_Insert1" value="<?php echo NXT_getResource("Insert as new_FB"); ?>" onclick="nxt_form_insertasnew(this, 'ID_theloaitin')" />
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
mysql_free_result($rs_theloai);

mysql_free_result($Recordset1);
?>