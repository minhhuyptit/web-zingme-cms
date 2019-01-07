<?php require_once('../Connections/conn_vietchuyen.php'); ?><?php require_once('../Connections/conn_vietchuyen.php'); ?>
<?php
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
$tfi_listnghenghiep1 = new TFI_TableFilter($conn_conn_vietchuyen, "tfi_listnghenghiep1");
$tfi_listnghenghiep1->addColumn("nghenghiep.tennghenghiep", "STRING_TYPE", "tennghenghiep", "%");
$tfi_listnghenghiep1->Execute();

// Sorter
$tso_listnghenghiep1 = new TSO_TableSorter("rsnghenghiep1", "tso_listnghenghiep1");
$tso_listnghenghiep1->addColumn("nghenghiep.tennghenghiep");
$tso_listnghenghiep1->setDefault("nghenghiep.tennghenghiep");
$tso_listnghenghiep1->Execute();

// Navigation
$nav_listnghenghiep1 = new NAV_Regular("nav_listnghenghiep1", "rsnghenghiep1", "../", $_SERVER['PHP_SELF'], 10);

//NeXTenesio3 Special List Recordset
$maxRows_rsnghenghiep1 = $_SESSION['max_rows_nav_listnghenghiep1'];
$pageNum_rsnghenghiep1 = 0;
if (isset($_GET['pageNum_rsnghenghiep1'])) {
  $pageNum_rsnghenghiep1 = $_GET['pageNum_rsnghenghiep1'];
}
$startRow_rsnghenghiep1 = $pageNum_rsnghenghiep1 * $maxRows_rsnghenghiep1;

// Defining List Recordset variable
$NXTFilter_rsnghenghiep1 = "1=1";
if (isset($_SESSION['filter_tfi_listnghenghiep1'])) {
  $NXTFilter_rsnghenghiep1 = $_SESSION['filter_tfi_listnghenghiep1'];
}
// Defining List Recordset variable
$NXTSort_rsnghenghiep1 = "nghenghiep.tennghenghiep";
if (isset($_SESSION['sorter_tso_listnghenghiep1'])) {
  $NXTSort_rsnghenghiep1 = $_SESSION['sorter_tso_listnghenghiep1'];
}
mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);

$query_rsnghenghiep1 = "SELECT nghenghiep.tennghenghiep, nghenghiep.ID_nghenghiep FROM nghenghiep WHERE {$NXTFilter_rsnghenghiep1} ORDER BY {$NXTSort_rsnghenghiep1}";
$query_limit_rsnghenghiep1 = sprintf("%s LIMIT %d, %d", $query_rsnghenghiep1, $startRow_rsnghenghiep1, $maxRows_rsnghenghiep1);
$rsnghenghiep1 = mysql_query($query_limit_rsnghenghiep1, $conn_vietchuyen) or die(mysql_error());
$row_rsnghenghiep1 = mysql_fetch_assoc($rsnghenghiep1);

if (isset($_GET['totalRows_rsnghenghiep1'])) {
  $totalRows_rsnghenghiep1 = $_GET['totalRows_rsnghenghiep1'];
} else {
  $all_rsnghenghiep1 = mysql_query($query_rsnghenghiep1);
  $totalRows_rsnghenghiep1 = mysql_num_rows($all_rsnghenghiep1);
}
$totalPages_rsnghenghiep1 = ceil($totalRows_rsnghenghiep1/$maxRows_rsnghenghiep1)-1;
//End NeXTenesio3 Special List Recordset

$nav_listnghenghiep1->checkBoundries();
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
  .KT_col_tennghenghiep {width:250px; overflow:hidden;}
</style>
</head>

<body>
	
<div class="KT_tng" id="listnghenghiep1">
  <h1> Nghề nghiệp
    <?php
  $nav_listnghenghiep1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options"> <a href="<?php echo $nav_listnghenghiep1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
        <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listnghenghiep1'] == 1) {
?>
          <?php echo $_SESSION['default_max_rows_nav_listnghenghiep1']; ?>
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
  if (@$_SESSION['has_filter_tfi_listnghenghiep1'] == 1) {
?>
                              <a href="<?php echo $tfi_listnghenghiep1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
                              <?php 
  // else Conditional region2
  } else { ?>
                              <a href="<?php echo $tfi_listnghenghiep1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
                              <?php } 
  // endif Conditional region2
?>
      </div>
      <table cellpadding="2" cellspacing="0" class="KT_tngtable">
        <thead>
          <tr class="KT_row_order">
            <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
            </th>
            <th id="tennghenghiep" class="KT_sorter KT_col_tennghenghiep <?php echo $tso_listnghenghiep1->getSortIcon('nghenghiep.tennghenghiep'); ?>"> <a href="<?php echo $tso_listnghenghiep1->getSortLink('nghenghiep.tennghenghiep'); ?>">Tên nghề nghiệp</a> </th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listnghenghiep1'] == 1) {
?>
            <tr class="KT_row_filter">
              <td>&nbsp;</td>
              <td><input type="text" name="tfi_listnghenghiep1_tennghenghiep" id="tfi_listnghenghiep1_tennghenghiep" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listnghenghiep1_tennghenghiep']); ?>" size="20" maxlength="65" /></td>
              <td><input type="submit" name="tfi_listnghenghiep1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
            </tr>
            <?php } 
  // endif Conditional region3
?>
        </thead>
        <tbody>
          <?php if ($totalRows_rsnghenghiep1 == 0) { // Show if recordset empty ?>
            <tr>
              <td colspan="3"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
            </tr>
            <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rsnghenghiep1 > 0) { // Show if recordset not empty ?>
            <?php do { ?>
              <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                <td><input type="checkbox" name="kt_pk_nghenghiep" class="id_checkbox" value="<?php echo $row_rsnghenghiep1['ID_nghenghiep']; ?>" />
                    <input type="hidden" name="ID_nghenghiep" class="id_field" value="<?php echo $row_rsnghenghiep1['ID_nghenghiep']; ?>" />
                </td>
                <td><div class="KT_col_tennghenghiep"><?php echo KT_FormatForList($row_rsnghenghiep1['tennghenghiep'], 200); ?></div></td>
                <td><a class="KT_edit_link" href="admincp.php?vietchuyen=form_nghenghiep&ID_nghenghiep=<?php echo $row_rsnghenghiep1['ID_nghenghiep']; ?>&KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a> <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a> </td>
              </tr>
              <?php } while ($row_rsnghenghiep1 = mysql_fetch_assoc($rsnghenghiep1)); ?>
            <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listnghenghiep1->Prepare();
            require("../includes/nav/NAV_Text_Navigation.inc.php");
          ?>
        </div>
      </div>
      <div class="KT_bottombuttons">
        <div class="KT_operations"> <a class="KT_edit_op_link" href="#" onclick="nxt_list_edit_link_form(this); return false;"><?php echo NXT_getResource("edit_all"); ?></a> <a class="KT_delete_op_link" href="#" onclick="nxt_list_delete_link_form(this); return false;"><?php echo NXT_getResource("delete_all"); ?></a> </div>
<span>&nbsp;</span>
        <select name="no_new" id="no_new">
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
        </select>
        <a class="KT_additem_op_link" href="admincp.php?vietchuyen=form_nghenghiep&KT_back=1" onclick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a> </div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>
</body>
</html>
<?php
mysql_free_result($rsnghenghiep1);
?>
