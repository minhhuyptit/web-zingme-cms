<?php require_once('../Connections/conn_vietchuyen.php'); ?><?php require_once('../Connections/conn_vietchuyen.php'); ?>
<?php
// Load the common classes
require_once('../includes/common/KT_common.php');

// Load the tNG classes
require_once('../includes/tng/tNG.inc.php');

// Load the tNG classes
require_once('../includes/tng/tNG.inc.php');

// Load the required classes
require_once('../includes/tfi/TFI.php');
require_once('../includes/tso/TSO.php');
require_once('../includes/nav/NAV.php');

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
$tfi_listvideoclip1 = new TFI_TableFilter($conn_conn_vietchuyen, "tfi_listvideoclip1");
$tfi_listvideoclip1->addColumn("videoclip.tenvideoclip", "STRING_TYPE", "tenvideoclip", "%");
$tfi_listvideoclip1->addColumn("videoclip.hinhvideoclip", "STRING_TYPE", "hinhvideoclip", "%");
$tfi_listvideoclip1->addColumn("videoclip.taptinvideoclip", "STRING_TYPE", "taptinvideoclip", "%");
$tfi_listvideoclip1->addColumn("videoclip.youtube", "STRING_TYPE", "youtube", "%");
$tfi_listvideoclip1->addColumn("videoclip.ngaycapnhat", "DATE_TYPE", "ngaycapnhat", "=");
$tfi_listvideoclip1->addColumn("videoclip.visible", "NUMERIC_TYPE", "visible", "=");
$tfi_listvideoclip1->Execute();

// Sorter
$tso_listvideoclip1 = new TSO_TableSorter("rsvideoclip1", "tso_listvideoclip1");
$tso_listvideoclip1->addColumn("videoclip.tenvideoclip");
$tso_listvideoclip1->addColumn("videoclip.hinhvideoclip");
$tso_listvideoclip1->addColumn("videoclip.taptinvideoclip");
$tso_listvideoclip1->addColumn("videoclip.youtube");
$tso_listvideoclip1->addColumn("videoclip.ngaycapnhat");
$tso_listvideoclip1->addColumn("videoclip.visible");
$tso_listvideoclip1->setDefault("videoclip.ngaycapnhat DESC");
$tso_listvideoclip1->Execute();

// Navigation
$nav_listvideoclip1 = new NAV_Regular("nav_listvideoclip1", "rsvideoclip1", "../", $_SERVER['PHP_SELF'], 10);

//NeXTenesio3 Special List Recordset
$maxRows_rsvideoclip1 = $_SESSION['max_rows_nav_listvideoclip1'];
$pageNum_rsvideoclip1 = 0;
if (isset($_GET['pageNum_rsvideoclip1'])) {
  $pageNum_rsvideoclip1 = $_GET['pageNum_rsvideoclip1'];
}
$startRow_rsvideoclip1 = $pageNum_rsvideoclip1 * $maxRows_rsvideoclip1;

// Defining List Recordset variable
$NXTFilter_rsvideoclip1 = "1=1";
if (isset($_SESSION['filter_tfi_listvideoclip1'])) {
  $NXTFilter_rsvideoclip1 = $_SESSION['filter_tfi_listvideoclip1'];
}
// Defining List Recordset variable
$NXTSort_rsvideoclip1 = "videoclip.ngaycapnhat DESC";
if (isset($_SESSION['sorter_tso_listvideoclip1'])) {
  $NXTSort_rsvideoclip1 = $_SESSION['sorter_tso_listvideoclip1'];
}
mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);

$query_rsvideoclip1 = "SELECT videoclip.tenvideoclip, videoclip.hinhvideoclip, videoclip.taptinvideoclip, videoclip.youtube, videoclip.ngaycapnhat, videoclip.visible, videoclip.ID_videoclip FROM videoclip WHERE {$NXTFilter_rsvideoclip1} ORDER BY {$NXTSort_rsvideoclip1}";
$query_limit_rsvideoclip1 = sprintf("%s LIMIT %d, %d", $query_rsvideoclip1, $startRow_rsvideoclip1, $maxRows_rsvideoclip1);
$rsvideoclip1 = mysql_query($query_limit_rsvideoclip1, $conn_vietchuyen) or die(mysql_error());
$row_rsvideoclip1 = mysql_fetch_assoc($rsvideoclip1);

if (isset($_GET['totalRows_rsvideoclip1'])) {
  $totalRows_rsvideoclip1 = $_GET['totalRows_rsvideoclip1'];
} else {
  $all_rsvideoclip1 = mysql_query($query_rsvideoclip1);
  $totalRows_rsvideoclip1 = mysql_num_rows($all_rsvideoclip1);
}
$totalPages_rsvideoclip1 = ceil($totalRows_rsvideoclip1/$maxRows_rsvideoclip1)-1;
//End NeXTenesio3 Special List Recordset

$nav_listvideoclip1->checkBoundries();

// Show Dynamic Thumbnail
$objDynamicThumb1 = new tNG_DynamicThumbnail("../", "KT_thumbnail1");
$objDynamicThumb1->setFolder("../images/");
$objDynamicThumb1->setRenameRule("{rsvideoclip1.hinhvideoclip}");
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
<script src="../includes/nxt/scripts/list.js" type="text/javascript"></script>
<script src="../includes/nxt/scripts/list.js.php" type="text/javascript"></script>
<script type="text/javascript">
$NXT_LIST_SETTINGS = {
  duplicate_buttons: true,
  duplicate_navigation: true,
  row_effects: true,
  show_as_buttons: true,
  record_counter: true
}
</script>
<style type="text/css">
  /* Dynamic List row settings */
  .KT_col_tenvideoclip {width:140px; overflow:hidden;}
  .KT_col_hinhvideoclip {width:140px; overflow:hidden;}
  .KT_col_taptinvideoclip {width:100px; overflow:hidden;}
  .KT_col_youtube {width:400px; overflow:hidden;}
  .KT_col_ngaycapnhat {width:120px; overflow:hidden;}
  .KT_col_visible {width:40px; overflow:hidden;}
</style>
</head>

<body>
	
<div class="KT_tng" id="listvideoclip1">
  <h1> Videoclip
    <?php
  $nav_listvideoclip1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options"> <a href="<?php echo $nav_listvideoclip1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
        <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listvideoclip1'] == 1) {
?>
          <?php echo $_SESSION['default_max_rows_nav_listvideoclip1']; ?>
          <?php 
  // else Conditional region1
  } else { ?>
          <?php echo NXT_getResource("all"); ?>
          <?php } 
  // endif Conditional region1
?>
            <?php echo NXT_getResource("records"); ?></a> &nbsp;
        &nbsp;
                            <?php 
  // Show IF Conditional region2
  if (@$_SESSION['has_filter_tfi_listvideoclip1'] == 1) {
?>
                              <a href="<?php echo $tfi_listvideoclip1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
                              <?php 
  // else Conditional region2
  } else { ?>
                              <a href="<?php echo $tfi_listvideoclip1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
                              <?php } 
  // endif Conditional region2
?>
      </div>
      <table width="99%" cellpadding="2" cellspacing="0" class="KT_tngtable">
        <thead>
          <tr class="KT_row_order">
            <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
            </th>
            <th id="tenvideoclip" class="KT_sorter KT_col_tenvideoclip <?php echo $tso_listvideoclip1->getSortIcon('videoclip.tenvideoclip'); ?>"> <a href="<?php echo $tso_listvideoclip1->getSortLink('videoclip.tenvideoclip'); ?>">Tên Videoclip</a> </th>
            <th id="hinhvideoclip" class="KT_sorter KT_col_hinhvideoclip <?php echo $tso_listvideoclip1->getSortIcon('videoclip.hinhvideoclip'); ?>"> <a href="<?php echo $tso_listvideoclip1->getSortLink('videoclip.hinhvideoclip'); ?>">Hình Videoclip</a> </th>
            <th id="taptinvideoclip" class="KT_sorter KT_col_taptinvideoclip <?php echo $tso_listvideoclip1->getSortIcon('videoclip.taptinvideoclip'); ?>"> <a href="<?php echo $tso_listvideoclip1->getSortLink('videoclip.taptinvideoclip'); ?>">Tập tin Videoclip</a> </th>
            <th id="youtube" class="KT_sorter KT_col_youtube <?php echo $tso_listvideoclip1->getSortIcon('videoclip.youtube'); ?>"> <a href="<?php echo $tso_listvideoclip1->getSortLink('videoclip.youtube'); ?>">Youtube</a> </th>
            <th id="ngaycapnhat" class="KT_sorter KT_col_ngaycapnhat <?php echo $tso_listvideoclip1->getSortIcon('videoclip.ngaycapnhat'); ?>"> <a href="<?php echo $tso_listvideoclip1->getSortLink('videoclip.ngaycapnhat'); ?>">Ngày cập nhật</a> </th>
            <th id="visible" class="KT_sorter KT_col_visible <?php echo $tso_listvideoclip1->getSortIcon('videoclip.visible'); ?>"> <a href="<?php echo $tso_listvideoclip1->getSortLink('videoclip.visible'); ?>">Visible</a> </th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listvideoclip1'] == 1) {
?>
            <tr class="KT_row_filter">
              <td>&nbsp;</td>
              <td><input type="text" name="tfi_listvideoclip1_tenvideoclip" id="tfi_listvideoclip1_tenvideoclip" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listvideoclip1_tenvideoclip']); ?>" size="20" maxlength="255" /></td>
              <td><input type="text" name="tfi_listvideoclip1_hinhvideoclip" id="tfi_listvideoclip1_hinhvideoclip" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listvideoclip1_hinhvideoclip']); ?>" size="20" maxlength="145" /></td>
              <td><input type="text" name="tfi_listvideoclip1_taptinvideoclip" id="tfi_listvideoclip1_taptinvideoclip" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listvideoclip1_taptinvideoclip']); ?>" size="20" maxlength="145" /></td>
              <td><input type="text" name="tfi_listvideoclip1_youtube" id="tfi_listvideoclip1_youtube" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listvideoclip1_youtube']); ?>" size="20" maxlength="255" /></td>
              <td><input type="text" name="tfi_listvideoclip1_ngaycapnhat" id="tfi_listvideoclip1_ngaycapnhat" value="<?php echo @$_SESSION['tfi_listvideoclip1_ngaycapnhat']; ?>" size="10" maxlength="22" /></td>
              <td><input type="text" name="tfi_listvideoclip1_visible" id="tfi_listvideoclip1_visible" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listvideoclip1_visible']); ?>" size="20" maxlength="100" /></td>
              <td><input type="submit" name="tfi_listvideoclip1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
            </tr>
            <?php } 
  // endif Conditional region3
?>
        </thead>
        <tbody>
          <?php if ($totalRows_rsvideoclip1 == 0) { // Show if recordset empty ?>
            <tr>
              <td colspan="8"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
            </tr>
            <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rsvideoclip1 > 0) { // Show if recordset not empty ?>
            <?php do { ?>
              <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                <td><input type="checkbox" name="kt_pk_videoclip" class="id_checkbox" value="<?php echo $row_rsvideoclip1['ID_videoclip']; ?>" />
                    <input type="hidden" name="ID_videoclip" class="id_field" value="<?php echo $row_rsvideoclip1['ID_videoclip']; ?>" />
                </td>
                <td><div class="KT_col_tenvideoclip"><?php echo KT_FormatForList($row_rsvideoclip1['tenvideoclip'], 200); ?></div></td>
                <td><?php 
// Show If File Exists (region5)
if (tNG_fileExists("../images/", "{rsvideoclip1.hinhvideoclip}")) {
?>
                    <img src="<?php echo $objDynamicThumb1->Execute(); ?>" border="0" />
                    <?php } 
// EndIf File Exists (region5)
?></td>
                <td><div class="KT_col_taptinvideoclip"><?php echo KT_FormatForList($row_rsvideoclip1['taptinvideoclip'], 200); ?></div></td>
                <td><div class="KT_col_youtube"><?php echo KT_FormatForList($row_rsvideoclip1['youtube'], 400); ?></div></td>
                <td><div class="KT_col_ngaycapnhat"><?php echo KT_formatDate($row_rsvideoclip1['ngaycapnhat']); ?></div></td>
                <td align="center"><?php 
// Show IF Conditional region4 
if (@$row_rsvideoclip1['visible'] == 1) {
?>
                    <img src="check.png" width="24" height="24">
                    <?php 
// else Conditional region4
} else { ?>
                    <img src="delete.png" width="24" height="24">
                    <?php } 
// endif Conditional region4
?></td>
                <td><a class="KT_edit_link" href="admincp.php?vietchuyen=form_videoclip&ID_videoclip=<?php echo $row_rsvideoclip1['ID_videoclip']; ?>&KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a> <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a> </td>
              </tr>
              <?php } while ($row_rsvideoclip1 = mysql_fetch_assoc($rsvideoclip1)); ?>
            <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listvideoclip1->Prepare();
            require("../includes/nav/NAV_Text_Navigation.inc.php");
          ?>
        </div>
      </div>
      <div class="KT_bottombuttons">
        <div class="KT_operations"> <a class="KT_edit_op_link" href="#" onclick="nxt_list_edit_link_form(this); return false;"><?php echo NXT_getResource("edit_all"); ?></a> <a class="KT_delete_op_link" href="#" onclick="nxt_list_delete_link_form(this); return false;"><?php echo NXT_getResource("delete_all"); ?></a> </div>
<span>&nbsp;</span>
        <select name="no_new" id="no_new">
          <option value="1">1</option>
          <option value="3">3</option>
          <option value="6">6</option>
        </select>
        <a class="KT_additem_op_link" href="admincp.php?vietchuyen=form_videoclip&KT_back=1" onclick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a> </div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>
</body>
</html>
<?php
mysql_free_result($rsvideoclip1);
?>
