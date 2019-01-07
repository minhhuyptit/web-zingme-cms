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
$tor_listtheloaitin1 = new TOR_SetOrder($conn_conn_vietchuyen, 'theloaitin', 'ID_theloaitin', 'NUMERIC_TYPE', 'sapxep', 'listtheloaitin1_sapxep_order');
$tor_listtheloaitin1->Execute();

// Filter
$tfi_listtheloaitin1 = new TFI_TableFilter($conn_conn_vietchuyen, "tfi_listtheloaitin1");
$tfi_listtheloaitin1->addColumn("theloai.ID_theloai", "NUMERIC_TYPE", "ID_theloai", "=");
$tfi_listtheloaitin1->addColumn("theloaitin.tentheloaitin", "STRING_TYPE", "tentheloaitin", "%");
$tfi_listtheloaitin1->addColumn("theloaitin.visiblemenu2", "NUMERIC_TYPE", "visiblemenu2", "=");
$tfi_listtheloaitin1->addColumn("theloaitin.visible2", "NUMERIC_TYPE", "visible2", "=");
$tfi_listtheloaitin1->addColumn("theloaitin.linkngoai", "NUMERIC_TYPE", "linkngoai", "=");
$tfi_listtheloaitin1->addColumn("theloaitin.url", "STRING_TYPE", "url", "%");
$tfi_listtheloaitin1->addColumn("theloaitin.target", "STRING_TYPE", "target", "%");
$tfi_listtheloaitin1->Execute();

// Sorter
$tso_listtheloaitin1 = new TSO_TableSorter("rstheloaitin1", "tso_listtheloaitin1");
$tso_listtheloaitin1->addColumn("theloaitin.sapxep"); // Order column
$tso_listtheloaitin1->setDefault("theloaitin.sapxep");
$tso_listtheloaitin1->Execute();

// Navigation
$nav_listtheloaitin1 = new NAV_Regular("nav_listtheloaitin1", "rstheloaitin1", "../", $_SERVER['PHP_SELF'], 10);

mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_Recordset1 = "SELECT tentheloai, ID_theloai FROM theloai ORDER BY tentheloai";
$Recordset1 = mysql_query($query_Recordset1, $conn_vietchuyen) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

//NeXTenesio3 Special List Recordset
$maxRows_rstheloaitin1 = $_SESSION['max_rows_nav_listtheloaitin1'];
$pageNum_rstheloaitin1 = 0;
if (isset($_GET['pageNum_rstheloaitin1'])) {
  $pageNum_rstheloaitin1 = $_GET['pageNum_rstheloaitin1'];
}
$startRow_rstheloaitin1 = $pageNum_rstheloaitin1 * $maxRows_rstheloaitin1;

// Defining List Recordset variable
$NXTFilter_rstheloaitin1 = "1=1";
if (isset($_SESSION['filter_tfi_listtheloaitin1'])) {
  $NXTFilter_rstheloaitin1 = $_SESSION['filter_tfi_listtheloaitin1'];
}
// Defining List Recordset variable
$NXTSort_rstheloaitin1 = "theloaitin.sapxep";
if (isset($_SESSION['sorter_tso_listtheloaitin1'])) {
  $NXTSort_rstheloaitin1 = $_SESSION['sorter_tso_listtheloaitin1'];
}
mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);

$query_rstheloaitin1 = "SELECT theloai.tentheloai AS ID_theloai, theloaitin.tentheloaitin, theloaitin.visiblemenu2, theloaitin.visible2, theloaitin.linkngoai, theloaitin.url, theloaitin.target, theloaitin.ID_theloaitin, theloaitin.sapxep FROM theloaitin LEFT JOIN theloai ON theloaitin.ID_theloai = theloai.ID_theloai WHERE {$NXTFilter_rstheloaitin1} ORDER BY {$NXTSort_rstheloaitin1}";
$query_limit_rstheloaitin1 = sprintf("%s LIMIT %d, %d", $query_rstheloaitin1, $startRow_rstheloaitin1, $maxRows_rstheloaitin1);
$rstheloaitin1 = mysql_query($query_limit_rstheloaitin1, $conn_vietchuyen) or die(mysql_error());
$row_rstheloaitin1 = mysql_fetch_assoc($rstheloaitin1);

if (isset($_GET['totalRows_rstheloaitin1'])) {
  $totalRows_rstheloaitin1 = $_GET['totalRows_rstheloaitin1'];
} else {
  $all_rstheloaitin1 = mysql_query($query_rstheloaitin1);
  $totalRows_rstheloaitin1 = mysql_num_rows($all_rstheloaitin1);
}
$totalPages_rstheloaitin1 = ceil($totalRows_rstheloaitin1/$maxRows_rstheloaitin1)-1;
//End NeXTenesio3 Special List Recordset

$nav_listtheloaitin1->checkBoundries();
?><!DOCTYPE html>
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
  .KT_col_tentheloaitin {width:120px; overflow:hidden;}
  .KT_col_visiblemenu2 {width:40px; overflow:hidden;}
  .KT_col_visible2 {width:40px; overflow:hidden;}
  .KT_col_linkngoai {width:40px; overflow:hidden;}
  .KT_col_url {width:100px; overflow:hidden;}
  .KT_col_target {width:40px; overflow:hidden;}
</style>
<?php echo $tor_listtheloaitin1->scriptDefinition(); ?>

</head>

<body>
	
<div class="KT_tng" id="listtheloaitin1">
  <h1>
    Quản lý danh mục tin cấp 2
      <?php
  $nav_listtheloaitin1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options">
        <a href="<?php echo $nav_listtheloaitin1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
<?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listtheloaitin1'] == 1) {
?>
          <?php echo $_SESSION['default_max_rows_nav_listtheloaitin1']; ?> 
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
  if (@$_SESSION['has_filter_tfi_listtheloaitin1'] == 1) {
?>
        <a href="<?php echo $tfi_listtheloaitin1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
<?php 
  // else Conditional region2
  } else { ?>
        <a href="<?php echo $tfi_listtheloaitin1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
<?php } 
  // endif Conditional region2
?>
      </div>
      <table width="99%" cellpadding="2" cellspacing="0" class="KT_tngtable">
        <thead>
          <tr class="KT_row_order">
            <th>
              <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
            </th>
            <th id="ID_theloai" class="KT_col_ID_theloai">Danh mục tin cấp 1</th>
            <th id="tentheloaitin" class="KT_col_tentheloaitin">Danh mục tin cấp 2</th>
            <th id="visiblemenu2" class="KT_col_visiblemenu2">Hiện danh mục</th>
            <th id="visible2" class="KT_col_visible2">Nhóm danh mục</th>
            <th id="linkngoai" class="KT_col_linkngoai">Link ngoài</th>
            <th id="url" class="KT_col_url">Url</th>
            <th id="target" class="KT_col_target">Target</th>
            <th id="sapxep" class="KT_sorter <?php echo $tso_listtheloaitin1->getSortIcon('theloaitin.sapxep'); ?> KT_order">
              <a href="<?php echo $tso_listtheloaitin1->getSortLink('theloaitin.sapxep'); ?>"><?php echo NXT_getResource("Order"); ?></a>
              <a class="KT_move_op_link" href="#" onclick="nxt_list_move_link_form(this); return false;"><?php echo NXT_getResource("save"); ?></a>
            </th>
            <th>&nbsp;</th>
          </tr>
<?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listtheloaitin1'] == 1) {
?>
          <tr class="KT_row_filter">
            <td>&nbsp;</td>
            	<td>
		<select name="tfi_listtheloaitin1_ID_theloai" id="tfi_listtheloaitin1_ID_theloai">
      <option value="" <?php if (!(strcmp("", @$_SESSION['tfi_listtheloaitin1_ID_theloai']))) {echo "SELECTED";} ?>><?php echo NXT_getResource("None"); ?></option>
<?php
do {  
?>
			<option value="<?php echo $row_Recordset1['ID_theloai']?>"<?php if (!(strcmp($row_Recordset1['ID_theloai'], @$_SESSION['tfi_listtheloaitin1_ID_theloai']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['tentheloai']?></option>
<?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
		</select>
	</td>
            	<td><input type="text" name="tfi_listtheloaitin1_tentheloaitin" id="tfi_listtheloaitin1_tentheloaitin" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listtheloaitin1_tentheloaitin']); ?>" size="20" maxlength="65" /></td>
            	<td><input type="text" name="tfi_listtheloaitin1_visiblemenu2" id="tfi_listtheloaitin1_visiblemenu2" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listtheloaitin1_visiblemenu2']); ?>" size="20" maxlength="100" /></td>
            	<td><input type="text" name="tfi_listtheloaitin1_visible2" id="tfi_listtheloaitin1_visible2" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listtheloaitin1_visible2']); ?>" size="20" maxlength="100" /></td>
            	<td><?php 
// Show IF Conditional region4 
if (@$row_rstheloaitin1['linkngoai'] == 1) {
?>
                    <input type="text" name="tfi_listtheloaitin1_linkngoai" id="tfi_listtheloaitin1_linkngoai" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listtheloaitin1_linkngoai']); ?>" size="20" maxlength="100" />
                  <?php 
// else Conditional region4
} else { ?>
            	    Else text: Replace this.
  <?php } 
// endif Conditional region4
?></td>
            	<td><input type="text" name="tfi_listtheloaitin1_url" id="tfi_listtheloaitin1_url" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listtheloaitin1_url']); ?>" size="20" maxlength="65" /></td>
            	<td><input type="text" name="tfi_listtheloaitin1_target" id="tfi_listtheloaitin1_target" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listtheloaitin1_target']); ?>" size="20" maxlength="65" /></td>
            
            <td>&nbsp;</td>
            <td><input type="submit" name="tfi_listtheloaitin1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
          </tr>
<?php } 
  // endif Conditional region3
?>
        </thead>
        <tbody>
<?php if ($totalRows_rstheloaitin1 == 0) { // Show if recordset empty ?>
          <tr>
            <td colspan="10"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
          </tr>
<?php } // Show if recordset empty ?>
<?php if ($totalRows_rstheloaitin1 > 0) { // Show if recordset not empty ?>
<?php do { ?>
          <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
            <td>
              <input type="checkbox" name="kt_pk_theloaitin" class="id_checkbox" value="<?php echo $row_rstheloaitin1['ID_theloaitin']; ?>" />
              <input type="hidden" name="ID_theloaitin" class="id_field" value="<?php echo $row_rstheloaitin1['ID_theloaitin']; ?>" />
            </td>
            <td>
              <div class="KT_col_ID_theloai"><?php echo KT_FormatForList($row_rstheloaitin1['ID_theloai'], 20); ?></div>
            </td>
            <td>
              <div class="KT_col_tentheloaitin"><?php echo KT_FormatForList($row_rstheloaitin1['tentheloaitin'], 200); ?></div>
            </td>
            <td align="center"><?php 
// Show IF Conditional region7 
if (@$row_rstheloaitin1['visiblemenu2'] == 1) {
?>
                <img src="check.png" width="24" height="24">
                <?php 
// else Conditional region7
} else { ?>
                <img src="delete.png" width="24" height="24">
                <?php } 
// endif Conditional region7
?></td>
            <td align="center"><?php 
// Show IF Conditional region6 
if (@$row_rstheloaitin1['visible2'] == 1) {
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
// Show IF Conditional region5 
if (@$row_rstheloaitin1['linkngoai'] == 1) {
?>
                <img src="check.png" width="24" height="24">
                <?php 
// else Conditional region5
} else { ?>
                <img src="delete.png" width="24" height="24">
                <?php } 
// endif Conditional region5
?></td>
            <td>
              <div class="KT_col_url"><?php echo KT_FormatForList($row_rstheloaitin1['url'], 20); ?></div>
            </td>
            <td>
              <div class="KT_col_target"><?php echo KT_FormatForList($row_rstheloaitin1['target'], 20); ?></div>
            </td>
            <td class="KT_order">
              <input type="hidden" class="KT_orderhidden" name="<?php echo $tor_listtheloaitin1->getOrderFieldName() ?>" value="<?php echo $tor_listtheloaitin1->getOrderFieldValue($row_rstheloaitin1) ?>" />
              <a class="KT_movedown_link" href="#move_down">v</a>
              <a class="KT_moveup_link" href="#move_up">^</a>
            </td>
            <td>
              <a class="KT_edit_link" href="admincp.php?vietchuyen=form_theloaitin&ID_theloaitin=<?php echo $row_rstheloaitin1['ID_theloaitin']; ?>&KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a>
              <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a>
            </td>
          </tr>
<?php } while ($row_rstheloaitin1 = mysql_fetch_assoc($rstheloaitin1)); ?>
<?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listtheloaitin1->Prepare();
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
        <select name="no_new" id="no_new">
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
        </select>
        <a class="KT_additem_op_link" href="admincp.php?vietchuyen=form_theloaitin&KT_back=1" onclick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a>
      </div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>

</body>

</html><?php
mysql_free_result($Recordset1);

mysql_free_result($rstheloaitin1);
?>
