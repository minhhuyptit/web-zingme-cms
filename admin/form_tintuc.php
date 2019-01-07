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
$formValidation->addField("ID_theloai", true, "numeric", "", "", "", "Xin vui lòng nhập vào danh mục tin cấp 1");
$formValidation->addField("tieudetin", true, "text", "", "", "", "Xin vui lòng nhập vào tiêu đề tin");
$formValidation->addField("trichdantin", true, "text", "", "", "", "Please enter a valid value.");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_FileDelete trigger
//remove this line if you want to edit the code by hand 
function Trigger_FileDelete(&$tNG) {
  $deleteObj = new tNG_FileDelete($tNG);
  $deleteObj->setFolder("../images/");
  $deleteObj->setDbFieldName("hinhtrichdan");
  return $deleteObj->Execute();
}
//end Trigger_FileDelete trigger

//start Trigger_ImageUpload trigger
//remove this line if you want to edit the code by hand 
function Trigger_ImageUpload(&$tNG) {
  $uploadObj = new tNG_ImageUpload($tNG);
  $uploadObj->setFormFieldName("hinhtrichdan");
  $uploadObj->setDbFieldName("hinhtrichdan");
  $uploadObj->setFolder("../images/");
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

mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_nhomtin = "SELECT ID_nhomtin, tennhomtin, ID_theloai, ID_theloaitin FROM nhomtin WHERE visible = 1 ORDER BY tennhomtin ASC";
$rs_nhomtin = mysql_query($query_rs_nhomtin, $conn_vietchuyen) or die(mysql_error());
$row_rs_nhomtin = mysql_fetch_assoc($rs_nhomtin);
$totalRows_rs_nhomtin = mysql_num_rows($rs_nhomtin);

mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_Recordset3 = "SELECT tennhomtin, ID_nhomtin FROM nhomtin ORDER BY tennhomtin";
$Recordset3 = mysql_query($query_Recordset3, $conn_vietchuyen) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_phanloaitin = "SELECT ID_phanloaitin, tenphanloaitin FROM phanloaitin ORDER BY tenphanloaitin ASC";
$rs_phanloaitin = mysql_query($query_rs_phanloaitin, $conn_vietchuyen) or die(mysql_error());
$row_rs_phanloaitin = mysql_fetch_assoc($rs_phanloaitin);
$totalRows_rs_phanloaitin = mysql_num_rows($rs_phanloaitin);

mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_Recordset4 = "SELECT tenphanloaitin, ID_phanloaitin FROM phanloaitin ORDER BY tenphanloaitin";
$Recordset4 = mysql_query($query_Recordset4, $conn_vietchuyen) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

// Make an insert transaction instance
$ins_tintuc = new tNG_multipleInsert($conn_conn_vietchuyen);
$tNGs->addTransaction($ins_tintuc);
// Register triggers
$ins_tintuc->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_tintuc->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_tintuc->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$ins_tintuc->registerTrigger("AFTER", "Trigger_ImageUpload", 97);
// Add columns
$ins_tintuc->setTable("tintuc");
$ins_tintuc->addColumn("ID_theloai", "NUMERIC_TYPE", "POST", "ID_theloai");
$ins_tintuc->addColumn("ID_theloaitin", "NUMERIC_TYPE", "POST", "ID_theloaitin");
$ins_tintuc->addColumn("ID_nhomtin", "NUMERIC_TYPE", "POST", "ID_nhomtin");
$ins_tintuc->addColumn("ID_phanloaitin", "NUMERIC_TYPE", "POST", "ID_phanloaitin");
$ins_tintuc->addColumn("ID_thanhvien", "NUMERIC_TYPE", "POST", "ID_thanhvien");
$ins_tintuc->addColumn("tieudetin", "STRING_TYPE", "POST", "tieudetin");
$ins_tintuc->addColumn("hinhtrichdan", "FILE_TYPE", "FILES", "hinhtrichdan");
$ins_tintuc->addColumn("trichdantin", "STRING_TYPE", "POST", "trichdantin");
$ins_tintuc->addColumn("noidungtin", "STRING_TYPE", "POST", "noidungtin");
$ins_tintuc->addColumn("cohinh", "CHECKBOX_1_0_TYPE", "POST", "cohinh", "0");
$ins_tintuc->addColumn("cophim", "CHECKBOX_1_0_TYPE", "POST", "cophim", "0");
$ins_tintuc->addColumn("cotinnong", "CHECKBOX_1_0_TYPE", "POST", "cotinnong", "0");
$ins_tintuc->addColumn("ngaycapnhat", "DATE_TYPE", "VALUE", "{NOW_DT}");
$ins_tintuc->addColumn("kiemduyet", "CHECKBOX_1_0_TYPE", "POST", "kiemduyet", "0");
$ins_tintuc->setPrimaryKey("ID_tintuc", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_tintuc = new tNG_multipleUpdate($conn_conn_vietchuyen);
$tNGs->addTransaction($upd_tintuc);
// Register triggers
$upd_tintuc->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_tintuc->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_tintuc->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$upd_tintuc->registerTrigger("AFTER", "Trigger_ImageUpload", 97);
// Add columns
$upd_tintuc->setTable("tintuc");
$upd_tintuc->addColumn("ID_theloai", "NUMERIC_TYPE", "POST", "ID_theloai");
$upd_tintuc->addColumn("ID_theloaitin", "NUMERIC_TYPE", "POST", "ID_theloaitin");
$upd_tintuc->addColumn("ID_nhomtin", "NUMERIC_TYPE", "POST", "ID_nhomtin");
$upd_tintuc->addColumn("ID_phanloaitin", "NUMERIC_TYPE", "POST", "ID_phanloaitin");
$upd_tintuc->addColumn("ID_thanhvien", "NUMERIC_TYPE", "POST", "ID_thanhvien");
$upd_tintuc->addColumn("tieudetin", "STRING_TYPE", "POST", "tieudetin");
$upd_tintuc->addColumn("hinhtrichdan", "FILE_TYPE", "FILES", "hinhtrichdan");
$upd_tintuc->addColumn("trichdantin", "STRING_TYPE", "POST", "trichdantin");
$upd_tintuc->addColumn("noidungtin", "STRING_TYPE", "POST", "noidungtin");
$upd_tintuc->addColumn("cohinh", "CHECKBOX_1_0_TYPE", "POST", "cohinh");
$upd_tintuc->addColumn("cophim", "CHECKBOX_1_0_TYPE", "POST", "cophim");
$upd_tintuc->addColumn("cotinnong", "CHECKBOX_1_0_TYPE", "POST", "cotinnong");
$upd_tintuc->addColumn("ngaycapnhat", "DATE_TYPE", "CURRVAL", "");
$upd_tintuc->addColumn("kiemduyet", "CHECKBOX_1_0_TYPE", "POST", "kiemduyet");
$upd_tintuc->setPrimaryKey("ID_tintuc", "NUMERIC_TYPE", "GET", "ID_tintuc");

// Make an instance of the transaction object
$del_tintuc = new tNG_multipleDelete($conn_conn_vietchuyen);
$tNGs->addTransaction($del_tintuc);
// Register triggers
$del_tintuc->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_tintuc->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$del_tintuc->registerTrigger("AFTER", "Trigger_FileDelete", 98);
// Add columns
$del_tintuc->setTable("tintuc");
$del_tintuc->setPrimaryKey("ID_tintuc", "NUMERIC_TYPE", "GET", "ID_tintuc");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rstintuc = $tNGs->getRecordset("tintuc");
$row_rstintuc = mysql_fetch_assoc($rstintuc);
$totalRows_rstintuc = mysql_num_rows($rstintuc);

// Show Dynamic Thumbnail
$objDynamicThumb1 = new tNG_DynamicThumbnail("../", "KT_thumbnail1");
$objDynamicThumb1->setFolder("../images/");
$objDynamicThumb1->setRenameRule("{rstintuc.hinhtrichdan}");
$objDynamicThumb1->setResize(80, 0, true);
$objDynamicThumb1->setWatermark(false);
$objDynamicThumb1->setPopupSize(800, 600, true);
$objDynamicThumb1->setPopupNavigation(false);
$objDynamicThumb1->setPopupWatermark(false);
?>
<!DOCTYPE html>
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
<?php
//begin JSRecordset
$jsObject_rs_nhomtin = new WDG_JsRecordset("rs_nhomtin");
echo $jsObject_rs_nhomtin->getOutput();
//end JSRecordset
?>
<script language=JavaScript src='../Editor/scripts/innovaeditor.js'></script>
</head>
<body>
<div class="KT_tng">
  <h1>
    <?php 
// Show IF Conditional region1 
if (@$_GET['ID_tintuc'] == "") {
?>
      <?php echo NXT_getResource("Insert_FH"); ?>
      <?php 
// else Conditional region1
} else { ?>
      <?php echo NXT_getResource("Update_FH"); ?>
      <?php } 
// endif Conditional region1
?>
    Tin tức</h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" enctype="multipart/form-data">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rstintuc > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table width="99%" cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td width="85" class="KT_th"><label for="ID_theloai_<?php echo $cnt1; ?>">Danh mục 1:</label></td>
            <td colspan="2"><select name="ID_theloai_<?php echo $cnt1; ?>" id="ID_theloai_<?php echo $cnt1; ?>">
                <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                <?php 
do {  
?>
                <option value="<?php echo $row_rs_theloai['ID_theloai']?>"<?php if (!(strcmp($row_rs_theloai['ID_theloai'], $row_rstintuc['ID_theloai']))) {echo "SELECTED";} ?>><?php echo $row_rs_theloai['tentheloai']?></option>
                <?php
} while ($row_rs_theloai = mysql_fetch_assoc($rs_theloai));
  $rows = mysql_num_rows($rs_theloai);
  if($rows > 0) {
      mysql_data_seek($rs_theloai, 0);
	  $row_rs_theloai = mysql_fetch_assoc($rs_theloai);
  }
?>
              </select>
              <?php echo $tNGs->displayFieldError("tintuc", "ID_theloai", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="ID_theloaitin_<?php echo $cnt1; ?>">Danh mục  2:</label></td>
            <td colspan="2"><select name="ID_theloaitin_<?php echo $cnt1; ?>" id="ID_theloaitin_<?php echo $cnt1; ?>" wdg:subtype="DependentDropdown" wdg:type="widget" wdg:recordset="rs_theloaitin" wdg:displayfield="tentheloaitin" wdg:valuefield="ID_theloaitin" wdg:fkey="ID_theloai" wdg:triggerobject="ID_theloai_<?php echo $cnt1; ?>" wdg:selected="<?php echo $row_rstintuc['ID_theloaitin'] ?>">
                <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
              </select>
              <?php echo $tNGs->displayFieldError("tintuc", "ID_theloaitin", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="ID_nhomtin_<?php echo $cnt1; ?>">Chuyên đề:</label></td>
            <td colspan="2"><select name="ID_nhomtin_<?php echo $cnt1; ?>" id="ID_nhomtin_<?php echo $cnt1; ?>" wdg:subtype="DependentDropdown" wdg:type="widget" wdg:recordset="rs_nhomtin" wdg:displayfield="tennhomtin" wdg:valuefield="ID_nhomtin" wdg:fkey="ID_theloaitin" wdg:triggerobject="ID_theloaitin_<?php echo $cnt1; ?>" wdg:selected="<?php echo $row_rstintuc['ID_nhomtin'] ?>">
                <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
              </select>
              <?php echo $tNGs->displayFieldError("tintuc", "ID_nhomtin", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="ID_phanloaitin_<?php echo $cnt1; ?>">Phân loại tin:</label></td>
            <td colspan="2"><select name="ID_phanloaitin_<?php echo $cnt1; ?>" id="ID_phanloaitin_<?php echo $cnt1; ?>">
                <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                <?php 
do {  
?>
                <option value="<?php echo $row_rs_phanloaitin['ID_phanloaitin']?>"<?php if (!(strcmp($row_rs_phanloaitin['ID_phanloaitin'], $row_rstintuc['ID_phanloaitin']))) {echo "SELECTED";} ?>><?php echo $row_rs_phanloaitin['tenphanloaitin']?></option>
                <?php
} while ($row_rs_phanloaitin = mysql_fetch_assoc($rs_phanloaitin));
  $rows = mysql_num_rows($rs_phanloaitin);
  if($rows > 0) {
      mysql_data_seek($rs_phanloaitin, 0);
	  $row_rs_phanloaitin = mysql_fetch_assoc($rs_phanloaitin);
  }
?>
              </select>
              <?php echo $tNGs->displayFieldError("tintuc", "ID_phanloaitin", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="tieudetin_<?php echo $cnt1; ?>">Tiêu đề:</label></td>
            <td colspan="2"><input type="text" name="tieudetin_<?php echo $cnt1; ?>" id="tieudetin_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rstintuc['tieudetin']); ?>" size="32" maxlength="100" />
              <?php echo $tNGs->displayFieldHint("tieudetin");?> <?php echo $tNGs->displayFieldError("tintuc", "tieudetin", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="hinhtrichdan_<?php echo $cnt1; ?>">Hình:</label></td>
            <td width="229"><input type="file" name="hinhtrichdan_<?php echo $cnt1; ?>" id="hinhtrichdan_<?php echo $cnt1; ?>" size="32" />
              <?php echo $tNGs->displayFieldError("tintuc", "hinhtrichdan", $cnt1); ?> </td>
            <td width="102"><a href="<?php echo $objDynamicThumb1->getPopupLink(); ?>" onclick="<?php echo $objDynamicThumb1->getPopupAction(); ?>" target="_blank">
              <?php 
// Show If File Exists (region4)
if (tNG_fileExists("../images/", "{rstintuc.hinhtrichdan}")) {
?>
                <img src="<?php echo $objDynamicThumb1->Execute(); ?>" border="0" />
                <?php } 
// EndIf File Exists (region4)
?>
              </a></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="trichdantin_<?php echo $cnt1; ?>">Trích dẫn tin:</label></td>
            <td colspan="2"><textarea name="trichdantin_<?php echo $cnt1; ?>" id="trichdantin_<?php echo $cnt1; ?>" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rstintuc['trichdantin']); ?></textarea>
              <?php echo $tNGs->displayFieldHint("trichdantin");?> <?php echo $tNGs->displayFieldError("tintuc", "trichdantin", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="noidungtin_<?php echo $cnt1; ?>">Nội dung tin</label></td>
            <td colspan="2"><textarea name="noidungtin_<?php echo $cnt1; ?>" id="noidungtin_<?php echo $cnt1; ?>" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rstintuc['noidungtin']); ?></textarea>
              <script>
                var oEdit1 = new InnovaEditor("oEdit1");
            
                oEdit1.width=805;
                oEdit1.height=650;
            
                /***************************************************
                ADDING CUSTOM BUTTONS
                ***************************************************/
            
                oEdit1.arrCustomButtons = [["CustomName1","alert('Command 1 here.')","Caption 1 here","btnCustom1.gif"],
                ["CustomName2","alert(\"Command '2' here.\")","Caption 2 here","btnCustom2.gif"],
                ["CustomName3","alert('Command \"3\" here.')","Caption 3 here","btnCustom3.gif"]]
            
            
                /***************************************************
                RECONFIGURE TOOLBAR BUTTONS
                ***************************************************/
            
                //Use standard row toolbar
            
                oEdit1.toolbarMode = 0;
            
                oEdit1.features=["Save","FullScreen","Preview","Print", "Search","SpellCheck",
                "Table","AutoTable","Guidelines","Absolute", "Flash","Media","YoutubeVideo","InternalLink","CustomObject",
                "Form","Characters","ClearAll","XHTMLFullSource","XHTMLSource","BRK",
                "Cut","Copy","Paste","PasteWord","PasteText",
                "Undo","Redo","Hyperlink","Bookmark","Image",
                "JustifyLeft","JustifyCenter","JustifyRight","JustifyFull",
                "Numbering","Bullets","Indent","Outdent", "LTR","RTL",
                "Line","RemoveFormat","BRK",
                "StyleAndFormatting","TextFormatting","ListFormatting",
                "BoxFormatting","ParagraphFormatting","CssText","Styles",
                "CustomTag","Paragraph","FontName","FontSize",
                "Bold","Italic","Underline","Strikethrough", "Superscript","Subscript",
                "ForeColor","BackColor",
                "CustomName1","CustomName2","CustomName3"];// => Custom Button Placement
            
            
                /***************************************************
                OTHER SETTINGS
                ***************************************************/
                oEdit1.css="style/test.css";//Specify external css file here. If Table Auto Format is enabled, the table autoformat css rules must be defined in the css file.
            
            
                /*
                oEdit1.arrStyle = [["body",false,"","font-family:Verdana,Arial,Helvetica;font-size:x-small;"],
                      [".ScreenText",true,"Screen Text","font-family:Tahoma;"],
                      [".ImportantWords",true,"Important Words","font-weight:bold;"],
                      [".Highlight",true,"Highlight","font-family:Arial;color:red;"]];
            
                If you'd like to set the default writing to "Right to Left", you can use:
            
                oEdit1.arrStyle = [["BODY",false,"","direction:rtl;unicode-bidi:bidi-override;"]];
                */
            
            
                oEdit1.cmdAssetManager = "modalDialogShow('/Editor/assetmanager/assetmanager.php',640,465)"; //Command to open the Asset Manager add-on.
                oEdit1.cmdInternalLink = "modelessDialogShow('links.htm',365,270)"; //Command to open your custom link lookup page.
                oEdit1.cmdCustomObject = "modelessDialogShow('objects.htm',365,270)"; //Command to open your custom content lookup page.
            
                oEdit1.arrCustomTag=[["First Name","{%first_name%}"],
                ["Last Name","{%last_name%}"],
                ["Email","{%email%}"]];//Define custom tag selection
            
                oEdit1.customColors=["#ff4500","#ffa500","#808000","#4682b4","#1e90ff","#9400d3","#ff1493","#a9a9a9"];//predefined custom colors
            
                oEdit1.mode="XHTMLBody"; //Editing mode. Possible values: "HTMLBody" (default), "XHTMLBody", "HTML", "XHTML"
            
                oEdit1.REPLACE("noidungtin_<?php echo $cnt1;?>");

  </script>
              <?php echo $tNGs->displayFieldHint("noidungtin");?> <?php echo $tNGs->displayFieldError("tintuc", "noidungtin", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="cohinh_<?php echo $cnt1; ?>">Flag hình:</label></td>
            <td colspan="2"><input  <?php if (!(strcmp(KT_escapeAttribute($row_rstintuc['cohinh']),"1"))) {echo "checked";} ?> type="checkbox" name="cohinh_<?php echo $cnt1; ?>" id="cohinh_<?php echo $cnt1; ?>" value="1" />
              <?php echo $tNGs->displayFieldError("tintuc", "cohinh", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="cophim_<?php echo $cnt1; ?>">Flag phim:</label></td>
            <td colspan="2"><input  <?php if (!(strcmp(KT_escapeAttribute($row_rstintuc['cophim']),"1"))) {echo "checked";} ?> type="checkbox" name="cophim_<?php echo $cnt1; ?>" id="cophim_<?php echo $cnt1; ?>" value="1" />
              <?php echo $tNGs->displayFieldError("tintuc", "cophim", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="cotinnong_<?php echo $cnt1; ?>">Flag tin nóng:</label></td>
            <td colspan="2"><input  <?php if (!(strcmp(KT_escapeAttribute($row_rstintuc['cotinnong']),"1"))) {echo "checked";} ?> type="checkbox" name="cotinnong_<?php echo $cnt1; ?>" id="cotinnong_<?php echo $cnt1; ?>" value="1" />
              <?php echo $tNGs->displayFieldError("tintuc", "cotinnong", $cnt1); ?> </td>
          </tr>
          <tr>
            <td class="KT_th">Ngày cập nhật:</td>
            <td colspan="2"><?php echo KT_formatDate($row_rstintuc['ngaycapnhat']); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="kiemduyet_<?php echo $cnt1; ?>">Duyệt:</label></td>
            <td colspan="2"><input  <?php if (!(strcmp(KT_escapeAttribute($row_rstintuc['kiemduyet']),"1"))) {echo "checked";} ?> type="checkbox" name="kiemduyet_<?php echo $cnt1; ?>" id="kiemduyet_<?php echo $cnt1; ?>" value="1" />
              <?php echo $tNGs->displayFieldError("tintuc", "kiemduyet", $cnt1); ?> </td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_tintuc_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rstintuc['kt_pk_tintuc']); ?>" />
        <input type="hidden" name="ID_thanhvien_<?php echo $cnt1; ?>" id="ID_thanhvien_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rstintuc['ID_thanhvien']); ?>" />
        <?php } while ($row_rstintuc = mysql_fetch_assoc($rstintuc)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['ID_tintuc'] == "") {
      ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
            <?php 
      // else Conditional region1
      } else { ?>
            <div class="KT_operations">
              <input type="submit" name="KT_Insert1" value="<?php echo NXT_getResource("Insert as new_FB"); ?>" onclick="nxt_form_insertasnew(this, 'ID_tintuc')" />
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

mysql_free_result($rs_theloaitin);

mysql_free_result($Recordset2);

mysql_free_result($rs_nhomtin);

mysql_free_result($Recordset3);

mysql_free_result($rs_phanloaitin);

mysql_free_result($Recordset4);
?>
