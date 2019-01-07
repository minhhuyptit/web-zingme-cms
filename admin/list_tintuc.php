<?php require_once('../Connections/conn_vietchuyen.php'); ?>
<?php
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');

// Load the common classes
require_once('../includes/common/KT_common.php');

// Load the tNG classes
require_once('../includes/tng/tNG.inc.php');

// Load the required classes
require_once('../includes/tfi/TFI.php');
require_once('../includes/tso/TSO.php');
require_once('../includes/nav/NAV.php');

// Make unified connection variable
$conn_conn_vietchuyen = new KT_connection($conn_vietchuyen, $database_conn_vietchuyen);

//Start Restrict Access To Page
$restrict = new tNG_RestrictAccess($conn_conn_vietchuyen, "../");
//Grand Levels: Level
$restrict->addLevel("1");
$restrict->Execute();
//End Restrict Access To Page

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

// Filter
$tfi_listtintuc1 = new TFI_TableFilter($conn_conn_vietchuyen, "tfi_listtintuc1");
$tfi_listtintuc1->addColumn("theloai.ID_theloai", "NUMERIC_TYPE", "ID_theloai", "=");
$tfi_listtintuc1->addColumn("theloaitin.ID_theloaitin", "NUMERIC_TYPE", "ID_theloaitin", "=");
$tfi_listtintuc1->addColumn("nhomtin.ID_nhomtin", "NUMERIC_TYPE", "ID_nhomtin", "=");
$tfi_listtintuc1->addColumn("phanloaitin.ID_phanloaitin", "NUMERIC_TYPE", "ID_phanloaitin", "=");
$tfi_listtintuc1->addColumn("tintuc.tieudetin", "STRING_TYPE", "tieudetin", "%");
$tfi_listtintuc1->addColumn("tintuc.hinhtrichdan", "STRING_TYPE", "hinhtrichdan", "%");
$tfi_listtintuc1->addColumn("tintuc.ngaycapnhat", "DATE_TYPE", "ngaycapnhat", "=");
$tfi_listtintuc1->Execute();

// Sorter
$tso_listtintuc1 = new TSO_TableSorter("rstintuc1", "tso_listtintuc1");
$tso_listtintuc1->addColumn("theloai.tentheloai");
$tso_listtintuc1->addColumn("theloaitin.tentheloaitin");
$tso_listtintuc1->addColumn("nhomtin.tennhomtin");
$tso_listtintuc1->addColumn("phanloaitin.tenphanloaitin");
$tso_listtintuc1->addColumn("tintuc.tieudetin");
$tso_listtintuc1->addColumn("tintuc.hinhtrichdan");
$tso_listtintuc1->addColumn("tintuc.ngaycapnhat");
$tso_listtintuc1->setDefault("tintuc.ngaycapnhat DESC");
$tso_listtintuc1->Execute();

// Navigation
$nav_listtintuc1 = new NAV_Regular("nav_listtintuc1", "rstintuc1", "../", $_SERVER['PHP_SELF'], 10);

mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_Recordset1 = "SELECT tentheloai, ID_theloai FROM theloai ORDER BY tentheloai";
$Recordset1 = mysql_query($query_Recordset1, $conn_vietchuyen) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_Recordset2 = "SELECT ID_theloaitin, tentheloaitin, ID_theloai FROM theloaitin ORDER BY tentheloaitin ASC";
$Recordset2 = mysql_query($query_Recordset2, $conn_vietchuyen) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_Recordset3 = "SELECT ID_nhomtin, tennhomtin, ID_theloaitin FROM nhomtin ORDER BY tennhomtin ASC";
$Recordset3 = mysql_query($query_Recordset3, $conn_vietchuyen) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_Recordset4 = "SELECT tenphanloaitin, ID_phanloaitin FROM phanloaitin ORDER BY tenphanloaitin";
$Recordset4 = mysql_query($query_Recordset4, $conn_vietchuyen) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_Recordset5 = "SELECT username, ID_thanhvien FROM thanhvien ORDER BY username";
$Recordset5 = mysql_query($query_Recordset5, $conn_vietchuyen) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);

//NeXTenesio3 Special List Recordset
$maxRows_rstintuc1 = $_SESSION['max_rows_nav_listtintuc1'];
$pageNum_rstintuc1 = 0;
if (isset($_GET['pageNum_rstintuc1'])) {
  $pageNum_rstintuc1 = $_GET['pageNum_rstintuc1'];
}
$startRow_rstintuc1 = $pageNum_rstintuc1 * $maxRows_rstintuc1;

// Defining List Recordset variable
$NXTFilter_rstintuc1 = "1=1";
if (isset($_SESSION['filter_tfi_listtintuc1'])) {
  $NXTFilter_rstintuc1 = $_SESSION['filter_tfi_listtintuc1'];
}
// Defining List Recordset variable
$NXTSort_rstintuc1 = "tintuc.ngaycapnhat DESC";
if (isset($_SESSION['sorter_tso_listtintuc1'])) {
  $NXTSort_rstintuc1 = $_SESSION['sorter_tso_listtintuc1'];
}
mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);

$query_rstintuc1 = "SELECT theloai.tentheloai AS ID_theloai, theloaitin.tentheloaitin AS ID_theloaitin, nhomtin.tennhomtin AS ID_nhomtin, phanloaitin.tenphanloaitin AS ID_phanloaitin, thanhvien.username AS ID_thanhvien, tintuc.tieudetin, tintuc.hinhtrichdan, tintuc.cohinh, tintuc.cophim, tintuc.cotinnong, tintuc.solandoc, tintuc.ngaycapnhat, tintuc.kiemduyet, tintuc.ID_tintuc FROM ((((tintuc LEFT JOIN theloai ON tintuc.ID_theloai = theloai.ID_theloai) LEFT JOIN theloaitin ON tintuc.ID_theloaitin = theloaitin.ID_theloaitin) LEFT JOIN nhomtin ON tintuc.ID_nhomtin = nhomtin.ID_nhomtin) LEFT JOIN phanloaitin ON tintuc.ID_phanloaitin = phanloaitin.ID_phanloaitin) LEFT JOIN thanhvien ON tintuc.ID_thanhvien = thanhvien.ID_thanhvien WHERE {$NXTFilter_rstintuc1} ORDER BY {$NXTSort_rstintuc1}";
$query_limit_rstintuc1 = sprintf("%s LIMIT %d, %d", $query_rstintuc1, $startRow_rstintuc1, $maxRows_rstintuc1);
$rstintuc1 = mysql_query($query_limit_rstintuc1, $conn_vietchuyen) or die(mysql_error());
$row_rstintuc1 = mysql_fetch_assoc($rstintuc1);

if (isset($_GET['totalRows_rstintuc1'])) {
  $totalRows_rstintuc1 = $_GET['totalRows_rstintuc1'];
} else {
  $all_rstintuc1 = mysql_query($query_rstintuc1);
  $totalRows_rstintuc1 = mysql_num_rows($all_rstintuc1);
}
$totalPages_rstintuc1 = ceil($totalRows_rstintuc1/$maxRows_rstintuc1)-1;
//End NeXTenesio3 Special List Recordset

$nav_listtintuc1->checkBoundries();

// Show Dynamic Thumbnail
$objDynamicThumb1 = new tNG_DynamicThumbnail("../", "KT_thumbnail1");
$objDynamicThumb1->setFolder("../images/");
$objDynamicThumb1->setRenameRule("{rstintuc1.hinhtrichdan}");
$objDynamicThumb1->setResize(80, 0, true);
$objDynamicThumb1->setWatermark(false);
$objDynamicThumb1->setPopupSize(800, 600, false);
$objDynamicThumb1->setPopupNavigation(false);
$objDynamicThumb1->setPopupWatermark(false);
?><!DOCTYPE html>
<html xmlns:wdg="http://ns.adobe.com/addt">
<head>
<meta charset="utf-8" />
<title>vietchuyen.edu.vn</title><link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" /><script src="../includes/common/js/base.js" type="text/javascript"></script><script src="../includes/common/js/utility.js" type="text/javascript"></script><script src="../includes/skins/style.js" type="text/javascript"></script><script src="../includes/nxt/scripts/list.js" type="text/javascript"></script><script src="../includes/nxt/scripts/list.js.php" type="text/javascript"></script><script type="text/javascript">
$NXT_LIST_SETTINGS = {
  duplicate_buttons: true,
  duplicate_navigation: true,
  row_effects: true,
  show_as_buttons: true,
  record_counter: true
}
</script><style type="text/css">
  /* Dynamic List row settings */
  .KT_col_ID_theloai {width:100px; overflow:hidden;}
  .KT_col_ID_theloaitin {width:100px; overflow:hidden;}
  .KT_col_ID_nhomtin {width:140px; overflow:hidden;}
  .KT_col_ID_phanloaitin {width:100px; overflow:hidden;}
  .KT_col_tieudetin {width:260px; overflow:hidden;}
  .KT_col_hinhtrichdan {width:80px; overflow:hidden;}
  .KT_col_ngaycapnhat {width:110px; overflow:hidden;}
</style>
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/JSRecordset.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/DependentDropdown.js"></script>
<?php
//begin JSRecordset
$jsObject_Recordset2 = new WDG_JsRecordset("Recordset2");
echo $jsObject_Recordset2->getOutput();
//end JSRecordset
?>
<?php
//begin JSRecordset
$jsObject_Recordset3 = new WDG_JsRecordset("Recordset3");
echo $jsObject_Recordset3->getOutput();
//end JSRecordset
?>
</head>

<body>
	
<div class="KT_tng" id="listtintuc1">
  <h1>
    Quản lý tin tức
      <?php
  $nav_listtintuc1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options">
        <a href="<?php echo $nav_listtintuc1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
<?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listtintuc1'] == 1) {
?>
          <?php echo $_SESSION['default_max_rows_nav_listtintuc1']; ?> 
<?php 
  // else Conditional region1
  } else { ?>
         <?php echo NXT_getResource("all"); ?>
<?php } 
  // endif Conditional region1
?>
<?php echo NXT_getResource("records"); ?></a>
					&nbsp;
					&nbsp;
<?php 
  // Show IF Conditional region2
  if (@$_SESSION['has_filter_tfi_listtintuc1'] == 1) {
?>
        <a href="<?php echo $tfi_listtintuc1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
<?php 
  // else Conditional region2
  } else { ?>
        <a href="<?php echo $tfi_listtintuc1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
<?php } 
  // endif Conditional region2
?>
      </div>
      <table cellpadding="2" cellspacing="0" class="KT_tngtable">
        <thead>
          <tr class="KT_row_order">
            <th>
              <input type="checkbox" name="KT_selAll" id="KT_selAll"/>            </th>
            <th id="ID_theloai" class="KT_sorter KT_col_ID_theloai <?php echo $tso_listtintuc1->getSortIcon('theloai.tentheloai'); ?>">
              <a href="<?php echo $tso_listtintuc1->getSortLink('theloai.tentheloai'); ?>">Danh mục tin cấp 1</a>            </th>
            <th id="ID_theloaitin" class="KT_sorter KT_col_ID_theloaitin <?php echo $tso_listtintuc1->getSortIcon('theloaitin.tentheloaitin'); ?>">
              <a href="<?php echo $tso_listtintuc1->getSortLink('theloaitin.tentheloaitin'); ?>">Danh mục tin cấp 2</a>            </th>
            <th id="ID_nhomtin" class="KT_sorter KT_col_ID_nhomtin <?php echo $tso_listtintuc1->getSortIcon('nhomtin.tennhomtin'); ?>">
              <a href="<?php echo $tso_listtintuc1->getSortLink('nhomtin.tennhomtin'); ?>">Chuyên đề</a>            </th>
            <th id="ID_phanloaitin" class="KT_sorter KT_col_ID_phanloaitin <?php echo $tso_listtintuc1->getSortIcon('phanloaitin.tenphanloaitin'); ?>">
              <a href="<?php echo $tso_listtintuc1->getSortLink('phanloaitin.tenphanloaitin'); ?>">Phân loại tin</a>            </th>
            <th id="tieudetin" class="KT_sorter KT_col_tieudetin <?php echo $tso_listtintuc1->getSortIcon('tintuc.tieudetin'); ?>">
              <a href="<?php echo $tso_listtintuc1->getSortLink('tintuc.tieudetin'); ?>">Tiêu đề</a>            </th>
            <th id="hinhtrichdan" class="KT_sorter KT_col_hinhtrichdan <?php echo $tso_listtintuc1->getSortIcon('tintuc.hinhtrichdan'); ?>">
              <a href="<?php echo $tso_listtintuc1->getSortLink('tintuc.hinhtrichdan'); ?>">Hình</a>            </th>
            <th id="ngaycapnhat" class="KT_sorter KT_col_ngaycapnhat <?php echo $tso_listtintuc1->getSortIcon('tintuc.ngaycapnhat'); ?>">
              <a href="<?php echo $tso_listtintuc1->getSortLink('tintuc.ngaycapnhat'); ?>">Ngày cập nhật</a>            </th>
            <th>&nbsp;</th>
          </tr>
<?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listtintuc1'] == 1) {
?>
          <tr class="KT_row_filter">
            <td>&nbsp;</td>
            	<td>
		<select name="tfi_listtintuc1_ID_theloai" id="tfi_listtintuc1_ID_theloai">
      <option value="" <?php if (!(strcmp("", @$_SESSION['tfi_listtintuc1_ID_theloai']))) {echo "SELECTED";} ?>><?php echo NXT_getResource("None"); ?></option>
<?php
do {  
?>
			<option value="<?php echo $row_Recordset1['ID_theloai']?>"<?php if (!(strcmp($row_Recordset1['ID_theloai'], @$_SESSION['tfi_listtintuc1_ID_theloai']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['tentheloai']?></option>
<?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
		</select>	</td>
            	<td>
		<select name="tfi_listtintuc1_ID_theloaitin" id="tfi_listtintuc1_ID_theloaitin" wdg:subtype="DependentDropdown" wdg:type="widget" wdg:recordset="Recordset2" wdg:displayfield="tentheloaitin" wdg:valuefield="ID_theloaitin" wdg:fkey="ID_theloai" wdg:triggerobject="tfi_listtintuc1_ID_theloai" wdg:selected="<?php @$_SESSION['tfi_listtintuc1_ID_theloaitin'] ?>">
		  <option value=""><?php echo NXT_getResource("None"); ?></option>
		</select>	</td>
            	<td>
		<select name="tfi_listtintuc1_ID_nhomtin" id="tfi_listtintuc1_ID_nhomtin" wdg:subtype="DependentDropdown" wdg:type="widget" wdg:recordset="Recordset3" wdg:displayfield="tennhomtin" wdg:valuefield="ID_nhomtin" wdg:fkey="ID_theloaitin" wdg:triggerobject="tfi_listtintuc1_ID_theloaitin" wdg:selected="<?php @$_SESSION['tfi_listtintuc1_ID_nhomtin'] ?>">
		  <option value=""><?php echo NXT_getResource("None"); ?></option>
		</select>	</td>
            	<td>
		<select name="tfi_listtintuc1_ID_phanloaitin" id="tfi_listtintuc1_ID_phanloaitin">
      <option value="" <?php if (!(strcmp("", @$_SESSION['tfi_listtintuc1_ID_phanloaitin']))) {echo "SELECTED";} ?>><?php echo NXT_getResource("None"); ?></option>
<?php
do {  
?>
			<option value="<?php echo $row_Recordset4['ID_phanloaitin']?>"<?php if (!(strcmp($row_Recordset4['ID_phanloaitin'], @$_SESSION['tfi_listtintuc1_ID_phanloaitin']))) {echo "SELECTED";} ?>><?php echo $row_Recordset4['tenphanloaitin']?></option>
<?php
} while ($row_Recordset4 = mysql_fetch_assoc($Recordset4));
  $rows = mysql_num_rows($Recordset4);
  if($rows > 0) {
      mysql_data_seek($Recordset4, 0);
	  $row_Recordset4 = mysql_fetch_assoc($Recordset4);
  }
?>
		</select>	</td>
            	<td><input type="text" name="tfi_listtintuc1_tieudetin" id="tfi_listtintuc1_tieudetin" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listtintuc1_tieudetin']); ?>" size="20" maxlength="100" /></td>
            	<td><input type="text" name="tfi_listtintuc1_hinhtrichdan" id="tfi_listtintuc1_hinhtrichdan" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listtintuc1_hinhtrichdan']); ?>" size="20" maxlength="100" /></td>
            	<td><input type="text" name="tfi_listtintuc1_ngaycapnhat" id="tfi_listtintuc1_ngaycapnhat" value="<?php echo @$_SESSION['tfi_listtintuc1_ngaycapnhat']; ?>" size="10" maxlength="22" /></td>
            	<td><input type="submit" name="tfi_listtintuc1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
          </tr>
<?php } 
  // endif Conditional region3
?>
        </thead>
        <tbody>
<?php if ($totalRows_rstintuc1 == 0) { // Show if recordset empty ?>
          <tr>
            <td colspan="9"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
          </tr>
<?php } // Show if recordset empty ?>
<?php if ($totalRows_rstintuc1 > 0) { // Show if recordset not empty ?>
<?php do { ?>
          <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
            <td>
              <input type="checkbox" name="kt_pk_tintuc" class="id_checkbox" value="<?php echo $row_rstintuc1['ID_tintuc']; ?>" />
              <input type="hidden" name="ID_tintuc" class="id_field" value="<?php echo $row_rstintuc1['ID_tintuc']; ?>" />            </td>
            <td>
              <div class="KT_col_ID_theloai"><?php echo KT_FormatForList($row_rstintuc1['ID_theloai'], 200); ?></div>            </td>
            <td>
              <div class="KT_col_ID_theloaitin"><?php echo KT_FormatForList($row_rstintuc1['ID_theloaitin'], 200); ?></div>            </td>
            <td>
              <div class="KT_col_ID_nhomtin"><?php echo KT_FormatForList($row_rstintuc1['ID_nhomtin'], 200); ?></div>            </td>
            <td>
              <div class="KT_col_ID_phanloaitin"><?php echo KT_FormatForList($row_rstintuc1['ID_phanloaitin'], 20); ?></div>            </td>
            <td>
              <div class="KT_col_tieudetin"><?php echo KT_FormatForList($row_rstintuc1['tieudetin'], 200); ?><br>
                Xem (<?php echo $row_rstintuc1['solandoc']; ?>) | User: <?php echo $row_rstintuc1['ID_thanhvien']; ?><br>
                <?php 
// Show IF Conditional region7 
if (@$row_rstintuc1['cotinnong'] == 1) {
?>
                  <img src="new.png" align="absmiddle">
                  <?php } 
// endif Conditional region7
?>
                  <?php 
// Show IF Conditional region5 
if (@$row_rstintuc1['cohinh'] == 1) {
?>
                    <img src="camera.png" width="16" height="16" align="absmiddle">
                    <?php } 
// endif Conditional region5
?>
                  <?php 
// Show IF Conditional region6 
if (@$row_rstintuc1['cophim'] == 1) {
?> 
                    <img src="video.png" width="16" height="16" align="absmiddle">
                    <?php } 
// endif Conditional region6
?> | Kiểm duyệt: 
                  <?php 
// Show IF Conditional region4 
if (@$row_rstintuc1['kiemduyet'] == 1) {
?>
                    <img src="check.png" width="16" height="16" align="absmiddle">
                    <?php 
// else Conditional region4
} else { ?>
                    <img src="delete.png" width="16" height="16" align="absmiddle">
                    <?php } 
// endif Conditional region4
?><br>
              </div>            </td>
            <td><a href="<?php echo $objDynamicThumb1->getPopupLink(); ?>" onclick="<?php echo $objDynamicThumb1->getPopupAction(); ?>" target="_blank"><img src="<?php echo $objDynamicThumb1->Execute(); ?>" border="0" /></a></td>
            <td>
              <div class="KT_col_ngaycapnhat"><?php echo KT_formatDate($row_rstintuc1['ngaycapnhat']); ?></div>            </td>
            <td>
              <a class="KT_edit_link" href="admincp.php?vietchuyen=form_tintuc&ID_tintuc=<?php echo $row_rstintuc1['ID_tintuc']; ?>&KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a>
              <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a>            </td>
          </tr>
<?php } while ($row_rstintuc1 = mysql_fetch_assoc($rstintuc1)); ?>
<?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listtintuc1->Prepare();
            require("../includes/nav/NAV_Text_Navigation.inc.php");
          ?>
        </div>
      </div>
      <div class="KT_bottombuttons">
        <div class="KT_operations">
          <a class="KT_edit_op_link" href="#" onclick="nxt_list_edit_link_form(this); return false;"><?php echo NXT_getResource("edit_all"); ?></a>
          <a class="KT_delete_op_link" href="#" onclick="nxt_list_delete_link_form(this); return false;"><?php echo NXT_getResource("delete_all"); ?></a>
        </div>
        <span>&nbsp;</span>
        <!--<select name="no_new" id="no_new">
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
        </select>-->
        <a class="KT_additem_op_link" href="admincp.php?vietchuyen=form_tintuc&KT_back=1" onclick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a>
      </div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>

</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

mysql_free_result($Recordset4);

mysql_free_result($Recordset5);

mysql_free_result($rstintuc1);
?>
