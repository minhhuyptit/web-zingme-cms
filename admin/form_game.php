<?php require_once('../Connections/conn_vietchuyen.php'); ?><?php
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
$formValidation->addField("ID_theloaigame", true, "numeric", "", "", "", "Xin vui lòng chọn danh mục game");
$formValidation->addField("tengame", true, "text", "", "", "", "Xin vui lòng nhập tên game");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_FileDelete1 trigger
//remove this line if you want to edit the code by hand 
function Trigger_FileDelete1(&$tNG) {
  $deleteObj = new tNG_FileDelete($tNG);
  $deleteObj->setFolder("../game/");
  $deleteObj->setDbFieldName("taptingame");
  return $deleteObj->Execute();
}
//end Trigger_FileDelete1 trigger

//start Trigger_FileUpload trigger
//remove this line if you want to edit the code by hand 
function Trigger_FileUpload(&$tNG) {
  $uploadObj = new tNG_FileUpload($tNG);
  $uploadObj->setFormFieldName("taptingame");
  $uploadObj->setDbFieldName("taptingame");
  $uploadObj->setFolder("../game/");
  $uploadObj->setMaxSize(15000);
  $uploadObj->setAllowedExtensions("swf");
  $uploadObj->setRename("auto");
  return $uploadObj->Execute();
}
//end Trigger_FileUpload trigger

//start Trigger_FileDelete trigger
//remove this line if you want to edit the code by hand 
function Trigger_FileDelete(&$tNG) {
  $deleteObj = new tNG_FileDelete($tNG);
  $deleteObj->setFolder("../game/hinhgame/");
  $deleteObj->setDbFieldName("hinhgame");
  return $deleteObj->Execute();
}
//end Trigger_FileDelete trigger

//start Trigger_ImageUpload trigger
//remove this line if you want to edit the code by hand 
function Trigger_ImageUpload(&$tNG) {
  $uploadObj = new tNG_ImageUpload($tNG);
  $uploadObj->setFormFieldName("hinhgame");
  $uploadObj->setDbFieldName("hinhgame");
  $uploadObj->setFolder("../game/hinhgame/");
  $uploadObj->setMaxSize(5000);
  $uploadObj->setAllowedExtensions("gif, jpg, jpe, jpeg, png");
  $uploadObj->setRename("auto");
  return $uploadObj->Execute();
}
//end Trigger_ImageUpload trigger

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
$query_rs_danhmucgame = "SELECT ID_theloaigame, tentheloaigame FROM theloaigame WHERE visiblemenu = 1 ORDER BY sapxep ASC";
$rs_danhmucgame = mysql_query($query_rs_danhmucgame, $conn_vietchuyen) or die(mysql_error());
$row_rs_danhmucgame = mysql_fetch_assoc($rs_danhmucgame);
$totalRows_rs_danhmucgame = mysql_num_rows($rs_danhmucgame);

// Make an insert transaction instance
$ins_game = new tNG_multipleInsert($conn_conn_vietchuyen);
$tNGs->addTransaction($ins_game);
// Register triggers
$ins_game->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_game->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_game->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$ins_game->registerTrigger("AFTER", "Trigger_ImageUpload", 97);
$ins_game->registerTrigger("AFTER", "Trigger_FileUpload", 97);
// Add columns
$ins_game->setTable("game");
$ins_game->addColumn("ID_theloaigame", "NUMERIC_TYPE", "POST", "ID_theloaigame");
$ins_game->addColumn("tengame", "STRING_TYPE", "POST", "tengame");
$ins_game->addColumn("hinhgame", "FILE_TYPE", "FILES", "hinhgame");
$ins_game->addColumn("taptingame", "FILE_TYPE", "FILES", "taptingame");
$ins_game->addColumn("trichdangame", "STRING_TYPE", "POST", "trichdangame");
$ins_game->addColumn("noidunggame", "STRING_TYPE", "POST", "noidunggame");
$ins_game->addColumn("hot", "CHECKBOX_1_0_TYPE", "POST", "hot", "0");
$ins_game->addColumn("ngaycapnhat", "DATE_TYPE", "POST", "ngaycapnhat");
$ins_game->addColumn("urlgame", "STRING_TYPE", "POST", "urlgame");
$ins_game->addColumn("kiemduyet", "CHECKBOX_1_0_TYPE", "POST", "kiemduyet", "0");
$ins_game->setPrimaryKey("ID_game", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_game = new tNG_multipleUpdate($conn_conn_vietchuyen);
$tNGs->addTransaction($upd_game);
// Register triggers
$upd_game->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_game->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_game->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$upd_game->registerTrigger("AFTER", "Trigger_ImageUpload", 97);
$upd_game->registerTrigger("AFTER", "Trigger_FileUpload", 97);
// Add columns
$upd_game->setTable("game");
$upd_game->addColumn("ID_theloaigame", "NUMERIC_TYPE", "POST", "ID_theloaigame");
$upd_game->addColumn("tengame", "STRING_TYPE", "POST", "tengame");
$upd_game->addColumn("hinhgame", "FILE_TYPE", "FILES", "hinhgame");
$upd_game->addColumn("taptingame", "FILE_TYPE", "FILES", "taptingame");
$upd_game->addColumn("trichdangame", "STRING_TYPE", "POST", "trichdangame");
$upd_game->addColumn("noidunggame", "STRING_TYPE", "POST", "noidunggame");
$upd_game->addColumn("hot", "CHECKBOX_1_0_TYPE", "POST", "hot");
$upd_game->addColumn("ngaycapnhat", "DATE_TYPE", "POST", "ngaycapnhat");
$upd_game->addColumn("urlgame", "STRING_TYPE", "POST", "urlgame");
$upd_game->addColumn("kiemduyet", "CHECKBOX_1_0_TYPE", "POST", "kiemduyet");
$upd_game->setPrimaryKey("ID_game", "NUMERIC_TYPE", "GET", "ID_game");

// Make an instance of the transaction object
$del_game = new tNG_multipleDelete($conn_conn_vietchuyen);
$tNGs->addTransaction($del_game);
// Register triggers
$del_game->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_game->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$del_game->registerTrigger("AFTER", "Trigger_FileDelete", 98);
$del_game->registerTrigger("AFTER", "Trigger_FileDelete1", 98);
// Add columns
$del_game->setTable("game");
$del_game->setPrimaryKey("ID_game", "NUMERIC_TYPE", "GET", "ID_game");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsgame = $tNGs->getRecordset("game");
$row_rsgame = mysql_fetch_assoc($rsgame);
$totalRows_rsgame = mysql_num_rows($rsgame);

// Show Dynamic Thumbnail
$objDynamicThumb1 = new tNG_DynamicThumbnail("../", "KT_thumbnail1");
$objDynamicThumb1->setFolder("../game/hinhgame/");
$objDynamicThumb1->setRenameRule("{rsgame.hinhgame}");
$objDynamicThumb1->setResize(80, 0, true);
$objDynamicThumb1->setWatermark(false);
?><!DOCTYPE html>
<html xmlns:wdg="http://ns.adobe.com/addt">
<head>
<meta charset="utf-8" />
<title>Quản lý game</title>
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
<script type="text/javascript" src="../includes/wdg/classes/Calendar.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/SmartDate.js"></script>
<script type="text/javascript" src="../includes/wdg/calendar/calendar_stripped.js"></script>
<script type="text/javascript" src="../includes/wdg/calendar/calendar-setup_stripped.js"></script>
<script src="../includes/resources/calendar.js"></script>
</head>

<body>
<div class="KT_tng">
  <h1>
    <?php 
// Show IF Conditional region1 
if (@$_GET['ID_game'] == "") {
?>
      <?php echo NXT_getResource("Insert_FH"); ?>
      <?php 
// else Conditional region1
} else { ?>
      <?php echo NXT_getResource("Update_FH"); ?>
      <?php } 
// endif Conditional region1
?>
    Game </h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" enctype="multipart/form-data">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rsgame > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table width="99%" cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td width="23%" class="KT_th"><label for="ID_theloaigame_<?php echo $cnt1; ?>">Danh mục game:</label></td>
            <td colspan="2"><select name="ID_theloaigame_<?php echo $cnt1; ?>" id="ID_theloaigame_<?php echo $cnt1; ?>">
              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
              <?php 
do {  
?>
              <option value="<?php echo $row_rs_danhmucgame['ID_theloaigame']?>"<?php if (!(strcmp($row_rs_danhmucgame['ID_theloaigame'], $row_rsgame['ID_theloaigame']))) {echo "SELECTED";} ?>><?php echo $row_rs_danhmucgame['tentheloaigame']?></option>
              <?php
} while ($row_rs_danhmucgame = mysql_fetch_assoc($rs_danhmucgame));
  $rows = mysql_num_rows($rs_danhmucgame);
  if($rows > 0) {
      mysql_data_seek($rs_danhmucgame, 0);
	  $row_rs_danhmucgame = mysql_fetch_assoc($rs_danhmucgame);
  }
?>
            </select>
                <?php echo $tNGs->displayFieldError("game", "ID_theloaigame", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="tengame_<?php echo $cnt1; ?>">Tên game:</label></td>
            <td colspan="2"><input type="text" name="tengame_<?php echo $cnt1; ?>" id="tengame_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsgame['tengame']); ?>" size="32" maxlength="200" />
                <?php echo $tNGs->displayFieldHint("tengame");?> <?php echo $tNGs->displayFieldError("game", "tengame", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="hinhgame_<?php echo $cnt1; ?>">Hình game:</label></td>
            <td width="27%"><input type="file" name="hinhgame_<?php echo $cnt1; ?>" id="hinhgame_<?php echo $cnt1; ?>" size="32" />
                <?php echo $tNGs->displayFieldError("game", "hinhgame", $cnt1); ?> </td>
            <td width="50%"><?php 
// Show If File Exists (region4)
if (tNG_fileExists("../game/hinhgame/", "{rsgame.hinhgame}")) {
?>
                <img src="<?php echo $objDynamicThumb1->Execute(); ?>" border="0" />
                <?php } 
// EndIf File Exists (region4)
?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="taptingame_<?php echo $cnt1; ?>">Tập tin:</label></td>
            <td colspan="2"><input type="file" name="taptingame_<?php echo $cnt1; ?>" id="taptingame_<?php echo $cnt1; ?>" size="32" />
                <?php echo $tNGs->displayFieldError("game", "taptingame", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="trichdangame_<?php echo $cnt1; ?>">Trích dẫn game:</label></td>
            <td colspan="2"><textarea name="trichdangame_<?php echo $cnt1; ?>" id="trichdangame_<?php echo $cnt1; ?>" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rsgame['trichdangame']); ?></textarea>
                <?php echo $tNGs->displayFieldHint("trichdangame");?> <?php echo $tNGs->displayFieldError("game", "trichdangame", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="noidunggame_<?php echo $cnt1; ?>">Nội dung game:</label></td>
            <td colspan="2"><textarea name="noidunggame_<?php echo $cnt1; ?>" id="noidunggame_<?php echo $cnt1; ?>" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rsgame['noidunggame']); ?></textarea>
                <?php echo $tNGs->displayFieldHint("noidunggame");?> <?php echo $tNGs->displayFieldError("game", "noidunggame", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="hot_<?php echo $cnt1; ?>">Hot:</label></td>
            <td colspan="2"><input  <?php if (!(strcmp(KT_escapeAttribute($row_rsgame['hot']),"1"))) {echo "checked";} ?> type="checkbox" name="hot_<?php echo $cnt1; ?>" id="hot_<?php echo $cnt1; ?>" value="1" />
                <?php echo $tNGs->displayFieldError("game", "hot", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="ngaycapnhat_<?php echo $cnt1; ?>">Ngày cập nhật:</label></td>
            <td colspan="2"><input type="text" name="ngaycapnhat_<?php echo $cnt1; ?>" id="ngaycapnhat_<?php echo $cnt1; ?>" value="<?php echo KT_formatDate($row_rsgame['ngaycapnhat']); ?>" size="32" />
                <?php echo $tNGs->displayFieldHint("ngaycapnhat");?> <?php echo $tNGs->displayFieldError("game", "ngaycapnhat", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="urlgame_<?php echo $cnt1; ?>">URL:</label></td>
            <td colspan="2"><input name="urlgame_<?php echo $cnt1; ?>" id="urlgame_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsgame['urlgame']); ?>" size="32" maxlength="255" wdg:mondayfirst="true" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format.' '.$KT_screen_time_format; ?>" wdg:type="widget" wdg:singleclick="true" wdg:restricttomask="yes" />
                <?php echo $tNGs->displayFieldHint("urlgame");?> <?php echo $tNGs->displayFieldError("game", "urlgame", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="kiemduyet_<?php echo $cnt1; ?>">Kiểm duyệt:</label></td>
            <td colspan="2"><input  <?php if (!(strcmp(KT_escapeAttribute($row_rsgame['kiemduyet']),"1"))) {echo "checked";} ?> type="checkbox" name="kiemduyet_<?php echo $cnt1; ?>" id="kiemduyet_<?php echo $cnt1; ?>" value="1" />
                <?php echo $tNGs->displayFieldError("game", "kiemduyet", $cnt1); ?> </td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_game_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsgame['kt_pk_game']); ?>" />
        <?php } while ($row_rsgame = mysql_fetch_assoc($rsgame)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['ID_game'] == "") {
      ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
            <?php 
      // else Conditional region1
      } else { ?>
            <div class="KT_operations">
              <input type="submit" name="KT_Insert1" value="<?php echo NXT_getResource("Insert as new_FB"); ?>" onclick="nxt_form_insertasnew(this, 'ID_game')" />
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
mysql_free_result($rs_danhmucgame);
?>
