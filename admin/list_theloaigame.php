<?php require_once('../Connections/conn_vietchuyen.php'); ?><?php
// Load the common classes
require_once('../includes/common/KT_common.php');

// Load the tNG classes
require_once('../includes/tng/tNG.inc.php');

// Load the required classes
require_once('../includes/tor/TOR.php');
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

// Order
$tor_listtheloaigame1 = new TOR_SetOrder($conn_conn_vietchuyen, 'theloaigame', 'ID_theloaigame', 'NUMERIC_TYPE', 'sapxep', 'listtheloaigame1_sapxep_order');
$tor_listtheloaigame1->Execute();

// Filter
$tfi_listtheloaigame1 = new TFI_TableFilter($conn_conn_vietchuyen, "tfi_listtheloaigame1");
$tfi_listtheloaigame1->addColumn("theloaigame.tentheloaigame", "STRING_TYPE", "tentheloaigame", "%");
$tfi_listtheloaigame1->addColumn("theloaigame.visiblemenu", "NUMERIC_TYPE", "visiblemenu", "=");
$tfi_listtheloaigame1->addColumn("theloaigame.visible", "NUMERIC_TYPE", "visible", "=");
$tfi_listtheloaigame1->Execute();

// Sorter
$tso_listtheloaigame1 = new TSO_TableSorter("rstheloaigame1", "tso_listtheloaigame1");
$tso_listtheloaigame1->addColumn("theloaigame.sapxep"); // Order column
$tso_listtheloaigame1->setDefault("theloaigame.sapxep");
$tso_listtheloaigame1->Execute();

// Navigation
$nav_listtheloaigame1 = new NAV_Regular("nav_listtheloaigame1", "rstheloaigame1", "../", $_SERVER['PHP_SELF'], 10);

//NeXTenesio3 Special List Recordset
$maxRows_rstheloaigame1 = $_SESSION['max_rows_nav_listtheloaigame1'];
$pageNum_rstheloaigame1 = 0;
if (isset($_GET['pageNum_rstheloaigame1'])) {
  $pageNum_rstheloaigame1 = $_GET['pageNum_rstheloaigame1'];
}
$startRow_rstheloaigame1 = $pageNum_rstheloaigame1 * $maxRows_rstheloaigame1;

// Defining List Recordset variable
$NXTFilter_rstheloaigame1 = "1=1";
if (isset($_SESSION['filter_tfi_listtheloaigame1'])) {
  $NXTFilter_rstheloaigame1 = $_SESSION['filter_tfi_listtheloaigame1'];
}
// Defining List Recordset variable
$NXTSort_rstheloaigame1 = "theloaigame.sapxep";
if (isset($_SESSION['sorter_tso_listtheloaigame1'])) {
  $NXTSort_rstheloaigame1 = $_SESSION['sorter_tso_listtheloaigame1'];
}
mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);

$query_rstheloaigame1 = "SELECT theloaigame.tentheloaigame, theloaigame.visiblemenu, theloaigame.visible, theloaigame.ID_theloaigame, theloaigame.sapxep FROM theloaigame WHERE {$NXTFilter_rstheloaigame1} ORDER BY {$NXTSort_rstheloaigame1}";
$query_limit_rstheloaigame1 = sprintf("%s LIMIT %d, %d", $query_rstheloaigame1, $startRow_rstheloaigame1, $maxRows_rstheloaigame1);
$rstheloaigame1 = mysql_query($query_limit_rstheloaigame1, $conn_vietchuyen) or die(mysql_error());
$row_rstheloaigame1 = mysql_fetch_assoc($rstheloaigame1);

if (isset($_GET['totalRows_rstheloaigame1'])) {
  $totalRows_rstheloaigame1 = $_GET['totalRows_rstheloaigame1'];
} else {
  $all_rstheloaigame1 = mysql_query($query_rstheloaigame1);
  $totalRows_rstheloaigame1 = mysql_num_rows($all_rstheloaigame1);
}
$totalPages_rstheloaigame1 = ceil($totalRows_rstheloaigame1/$maxRows_rstheloaigame1)-1;
//End NeXTenesio3 Special List Recordset

$nav_listtheloaigame1->checkBoundries();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
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
  .KT_col_tentheloaigame {width:140px; overflow:hidden;}
  .KT_col_visiblemenu {width:140px; overflow:hidden;}
  .KT_col_visible {width:140px; overflow:hidden;}
</style>
<?php echo $tor_listtheloaigame1->scriptDefinition(); ?>
</head>

<body>
<div class="KT_tng" id="listtheloaigame1">
  <h1> Danh mục game
    <?php
  $nav_listtheloaigame1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options"> <a href="<?php echo $nav_listtheloaigame1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
        <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listtheloaigame1'] == 1) {
?>
          <?php echo $_SESSION['default_max_rows_nav_listtheloaigame1']; ?>
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
  if (@$_SESSION['has_filter_tfi_listtheloaigame1'] == 1) {
?>
                  <a href="<?php echo $tfi_listtheloaigame1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
                  <?php 
  // else Conditional region2
  } else { ?>
                  <a href="<?php echo $tfi_listtheloaigame1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
                  <?php } 
  // endif Conditional region2
?>
      </div>
      <table width="99%" cellpadding="2" cellspacing="0" class="KT_tngtable">
        <thead>
          <tr class="KT_row_order">
            <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
            </th>
            <th id="tentheloaigame" class="KT_col_tentheloaigame">Danh mục game</th>
            <th id="visiblemenu" class="KT_col_visiblemenu">Hiện danh mục</th>
            <th id="visible" class="KT_col_visible">Nhóm danh mục</th>
            <th id="sapxep" class="KT_sorter <?php echo $tso_listtheloaigame1->getSortIcon('theloaigame.sapxep'); ?> KT_order"> <a href="<?php echo $tso_listtheloaigame1->getSortLink('theloaigame.sapxep'); ?>"><?php echo NXT_getResource("Order"); ?></a> <a class="KT_move_op_link" href="#" onclick="nxt_list_move_link_form(this); return false;"><?php echo NXT_getResource("save"); ?></a> </th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listtheloaigame1'] == 1) {
?>
            <tr class="KT_row_filter">
              <td>&nbsp;</td>
              <td><input type="text" name="tfi_listtheloaigame1_tentheloaigame" id="tfi_listtheloaigame1_tentheloaigame" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listtheloaigame1_tentheloaigame']); ?>" size="20" maxlength="45" /></td>
              <td><input type="text" name="tfi_listtheloaigame1_visiblemenu" id="tfi_listtheloaigame1_visiblemenu" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listtheloaigame1_visiblemenu']); ?>" size="20" maxlength="100" /></td>
              <td><input type="text" name="tfi_listtheloaigame1_visible" id="tfi_listtheloaigame1_visible" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listtheloaigame1_visible']); ?>" size="20" maxlength="100" /></td>
              <td>&nbsp;</td>
              <td><input type="submit" name="tfi_listtheloaigame1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
            </tr>
            <?php } 
  // endif Conditional region3
?>
        </thead>
        <tbody>
          <?php if ($totalRows_rstheloaigame1 == 0) { // Show if recordset empty ?>
            <tr>
              <td colspan="6"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
            </tr>
            <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rstheloaigame1 > 0) { // Show if recordset not empty ?>
            <?php do { ?>
              <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                <td><input type="checkbox" name="kt_pk_theloaigame" class="id_checkbox" value="<?php echo $row_rstheloaigame1['ID_theloaigame']; ?>" />
                    <input type="hidden" name="ID_theloaigame" class="id_field" value="<?php echo $row_rstheloaigame1['ID_theloaigame']; ?>" />
                </td>
                <td><div class="KT_col_tentheloaigame"><?php echo KT_FormatForList($row_rstheloaigame1['tentheloaigame'], 200); ?></div></td>
                <td align="center"><?php 
// Show IF Conditional region5 
if (@$row_rstheloaigame1['visiblemenu'] == 1) {
?>
                    <img src="check.png" width="24" height="24" />
                    <?php 
// else Conditional region5
} else { ?>
                    <img src="delete.png" width="24" height="24" />
                    <?php } 
// endif Conditional region5
?></td>
                <td align="center"><?php 
// Show IF Conditional region4 
if ($row_rstheloaigame1['visible'] == 1) {
?>
                      <img src="check.png" width="24" height="24" />
                      <?php 
// else Conditional region4
} else { ?>
                      <img src="delete.png" width="24" height="24" />
                <?php } 
// endif Conditional region4
?></td>
                <td class="KT_order"><input type="hidden" class="KT_orderhidden" name="<?php echo $tor_listtheloaigame1->getOrderFieldName() ?>" value="<?php echo $tor_listtheloaigame1->getOrderFieldValue($row_rstheloaigame1) ?>" />
                  <a class="KT_movedown_link" href="#move_down">v</a> <a class="KT_moveup_link" href="#move_up">^</a> </td>
                <td><a class="KT_edit_link" href="admincp.php?vietchuyen=form_theloaigame&amp;ID_theloaigame=<?php echo $row_rstheloaigame1['ID_theloaigame']; ?>&amp;KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a> <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a> </td>
              </tr>
              <?php } while ($row_rstheloaigame1 = mysql_fetch_assoc($rstheloaigame1)); ?>
            <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listtheloaigame1->Prepare();
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
        <a class="KT_additem_op_link" href="admincp.php?vietchuyen=form_theloaigame&amp;KT_back=1" onclick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a> </div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rstheloaigame1);
?>
