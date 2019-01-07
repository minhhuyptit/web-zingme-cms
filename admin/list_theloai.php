<?php require_once('../Connections/conn_vietchuyen.php'); ?><?php require_once('../Connections/conn_vietchuyen.php'); ?>
<?php
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
$tor_listtheloai1 = new TOR_SetOrder($conn_conn_vietchuyen, 'theloai', 'ID_theloai', 'NUMERIC_TYPE', 'sapxep', 'listtheloai1_sapxep_order');
$tor_listtheloai1->Execute();

// Filter
$tfi_listtheloai1 = new TFI_TableFilter($conn_conn_vietchuyen, "tfi_listtheloai1");
$tfi_listtheloai1->addColumn("theloai.tentheloai", "STRING_TYPE", "tentheloai", "%");
$tfi_listtheloai1->addColumn("theloai.visiblemenu1", "NUMERIC_TYPE", "visible1", "=");
$tfi_listtheloai1->addColumn("theloai.visible1", "NUMERIC_TYPE", "visiblemenu1", "=");
$tfi_listtheloai1->addColumn("theloai.linkngoai", "NUMERIC_TYPE", "linkngoai", "=");
$tfi_listtheloai1->addColumn("theloai.url", "STRING_TYPE", "url", "%");
$tfi_listtheloai1->addColumn("theloai.target", "STRING_TYPE", "target", "%");
$tfi_listtheloai1->Execute();

// Sorter
$tso_listtheloai1 = new TSO_TableSorter("rstheloai1", "tso_listtheloai1");
$tso_listtheloai1->addColumn("theloai.sapxep"); // Order column
$tso_listtheloai1->setDefault("theloai.sapxep");
$tso_listtheloai1->Execute();

// Navigation
$nav_listtheloai1 = new NAV_Regular("nav_listtheloai1", "rstheloai1", "../", $_SERVER['PHP_SELF'], 10);

//NeXTenesio3 Special List Recordset
$maxRows_rstheloai1 = $_SESSION['max_rows_nav_listtheloai1'];
$pageNum_rstheloai1 = 0;
if (isset($_GET['pageNum_rstheloai1'])) {
  $pageNum_rstheloai1 = $_GET['pageNum_rstheloai1'];
}
$startRow_rstheloai1 = $pageNum_rstheloai1 * $maxRows_rstheloai1;

// Defining List Recordset variable
$NXTFilter_rstheloai1 = "1=1";
if (isset($_SESSION['filter_tfi_listtheloai1'])) {
  $NXTFilter_rstheloai1 = $_SESSION['filter_tfi_listtheloai1'];
}
// Defining List Recordset variable
$NXTSort_rstheloai1 = "theloai.sapxep";
if (isset($_SESSION['sorter_tso_listtheloai1'])) {
  $NXTSort_rstheloai1 = $_SESSION['sorter_tso_listtheloai1'];
}
mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);

$query_rstheloai1 = "SELECT theloai.tentheloai, theloai.visiblemenu1, theloai.visible1, theloai.linkngoai, theloai.url, theloai.target, theloai.ID_theloai, theloai.sapxep FROM theloai WHERE {$NXTFilter_rstheloai1} ORDER BY {$NXTSort_rstheloai1}";
$query_limit_rstheloai1 = sprintf("%s LIMIT %d, %d", $query_rstheloai1, $startRow_rstheloai1, $maxRows_rstheloai1);
$rstheloai1 = mysql_query($query_limit_rstheloai1, $conn_vietchuyen) or die(mysql_error());
$row_rstheloai1 = mysql_fetch_assoc($rstheloai1);

if (isset($_GET['totalRows_rstheloai1'])) {
  $totalRows_rstheloai1 = $_GET['totalRows_rstheloai1'];
} else {
  $all_rstheloai1 = mysql_query($query_rstheloai1);
  $totalRows_rstheloai1 = mysql_num_rows($all_rstheloai1);
}
$totalPages_rstheloai1 = ceil($totalRows_rstheloai1/$maxRows_rstheloai1)-1;
//End NeXTenesio3 Special List Recordset

$nav_listtheloai1->checkBoundries();
?><!DOCTYPE html>
<html>

<head>
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
  .KT_col_tentheloai {width:120px; overflow:hidden;}
  .KT_col_visible1 {width:50px; overflow:hidden;}
  .KT_col_visiblemenu1 {width:50px; overflow:hidden;}
  .KT_col_linkngoai {width:50px; overflow:hidden;}
  .KT_col_url {width:100px; overflow:hidden;}
  .KT_col_target {width:50px; overflow:hidden;}
</style><?php echo $tor_listtheloai1->scriptDefinition(); ?>
</head>

<body>
	
<div class="KT_tng" id="listtheloai1">
  <h1> Quản lý danh mục tin cấp 1
    <?php
  $nav_listtheloai1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options"> <a href="<?php echo $nav_listtheloai1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
        <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listtheloai1'] == 1) {
?>
          <?php echo $_SESSION['default_max_rows_nav_listtheloai1']; ?>
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
  if (@$_SESSION['has_filter_tfi_listtheloai1'] == 1) {
?>
                              <a href="<?php echo $tfi_listtheloai1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
                              <?php 
  // else Conditional region2
  } else { ?>
                              <a href="<?php echo $tfi_listtheloai1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
                              <?php } 
  // endif Conditional region2
?>
      </div>
      <table width="99%" cellpadding="2" cellspacing="0" class="KT_tngtable">
        <thead>
          <tr class="KT_row_order">
            <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>            </th>
            <th id="tentheloai" class="KT_col_tentheloai">Danh mục tin 1</th>
            <th id="visible1" class="KT_col_visible1">Nhóm danh mục</th><th id="visiblemenu1" class="KT_col_visiblemenu1">Hiện danh mục</th><th id="linkngoai" class="KT_col_linkngoai">Link ngoài</th>
            <th id="url" class="KT_col_url">URL</th>
            <th id="target" class="KT_col_target">Target</th>
            <th id="sapxep" class="KT_sorter <?php echo $tso_listtheloai1->getSortIcon('theloai.sapxep'); ?> KT_order"> <a href="<?php echo $tso_listtheloai1->getSortLink('theloai.sapxep'); ?>"><?php echo NXT_getResource("Order"); ?></a> <a class="KT_move_op_link" href="#" onclick="nxt_list_move_link_form(this); return false;"><?php echo NXT_getResource("save"); ?></a> </th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listtheloai1'] == 1) {
?>
            <tr class="KT_row_filter">
              <td>&nbsp;</td>
              <td><input type="text" name="tfi_listtheloai1_tentheloai" id="tfi_listtheloai1_tentheloai" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listtheloai1_tentheloai']); ?>" size="20" maxlength="70" /></td>
              <td><input type="text" name="tfi_listtheloai1_visible1" id="tfi_listtheloai1_visible1" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listtheloai1_visible1']); ?>" size="20" maxlength="100" /></td><td><input type="text" name="tfi_listtheloai1_visiblemenu1" id="tfi_listtheloai1_visiblemenu1" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listtheloai1_visiblemenu1']); ?>" size="20" maxlength="100" /></td><td><input type="text" name="tfi_listtheloai1_linkngoai" id="tfi_listtheloai1_linkngoai" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listtheloai1_linkngoai']); ?>" size="20" maxlength="100" /></td>
              <td><input type="text" name="tfi_listtheloai1_url" id="tfi_listtheloai1_url" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listtheloai1_url']); ?>" size="20" maxlength="65" /></td>
              <td><input type="text" name="tfi_listtheloai1_target" id="tfi_listtheloai1_target" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listtheloai1_target']); ?>" size="20" maxlength="75" /></td>
              <td>&nbsp;</td>
              <td><input type="submit" name="tfi_listtheloai1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
            </tr>
            <?php } 
  // endif Conditional region3
?>
        </thead>
        <tbody>
          <?php if ($totalRows_rstheloai1 == 0) { // Show if recordset empty ?>
            <tr>
              <td colspan="9"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
            </tr>
            <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rstheloai1 > 0) { // Show if recordset not empty ?>
            <?php do { ?>
              <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                <td><input type="checkbox" name="kt_pk_theloai" class="id_checkbox" value="<?php echo $row_rstheloai1['ID_theloai']; ?>" />
                    <input type="hidden" name="ID_theloai" class="id_field" value="<?php echo $row_rstheloai1['ID_theloai']; ?>" />                </td>
                <td><div class="KT_col_tentheloai"><?php echo KT_FormatForList($row_rstheloai1['tentheloai'], 20); ?></div></td>
                <td align="center"><?php 
// Show IF Conditional region6 
if (@$row_rstheloai1['visible1'] == 1) {
?>
                    <img src="check.png" width="24" height="24">
                    <?php 
// else Conditional region6
} else { ?>
                    <img src="delete.png" width="24" height="24">
                    <?php } 
// endif Conditional region6
?></td>
                
                <td align="center"><?php 
// Show IF Conditional region4 
if (@$row_rstheloai1['visiblemenu1'] == 1) {
?>
                    <img src="check.png" width="24" height="24">
                    <?php 
// else Conditional region4
} else { ?>
                    <img src="delete.png" width="24" height="24">
                    <?php } 
// endif Conditional region4
?></td>
                <td align="center"><?php 
// Show IF Conditional region5 
if (@$row_rstheloai1['linkngoai'] == 1) {
?>
                    <img src="check.png" width="24" height="24">
                    
                    <?php 
// else Conditional region5
} else { ?>
                    <img src="delete.png" width="24" height="24">
                    <?php } 
// endif Conditional region5
?></td>
                <td><div class="KT_col_url"><?php echo KT_FormatForList($row_rstheloai1['url'], 20); ?></div></td>
                <td><div class="KT_col_target"><?php echo KT_FormatForList($row_rstheloai1['target'], 20); ?></div></td>
                <td class="KT_order"><input type="hidden" class="KT_orderhidden" name="<?php echo $tor_listtheloai1->getOrderFieldName() ?>" value="<?php echo $tor_listtheloai1->getOrderFieldValue($row_rstheloai1) ?>" />
                  <a class="KT_movedown_link" href="#move_down">v</a> <a class="KT_moveup_link" href="#move_up">^</a> </td>
                <td><a class="KT_edit_link" href="admincp.php?vietchuyen=form_theloai&ID_theloai=<?php echo $row_rstheloai1['ID_theloai']; ?>&KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a> <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a> </td>
              </tr>
              <?php } while ($row_rstheloai1 = mysql_fetch_assoc($rstheloai1)); ?>
            <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listtheloai1->Prepare();
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
        <a class="KT_additem_op_link" href="admincp.php?vietchuyen=form_theloai&KT_back=1" onclick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a> </div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>
</body>


</html>
<?php
mysql_free_result($rstheloai1);
?>