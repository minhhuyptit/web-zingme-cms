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
$tfi_listnhomtin1 = new TFI_TableFilter($conn_conn_vietchuyen, "tfi_listnhomtin1");
$tfi_listnhomtin1->addColumn("theloai.ID_theloai", "NUMERIC_TYPE", "ID_theloai", "=");
$tfi_listnhomtin1->addColumn("theloaitin.ID_theloaitin", "NUMERIC_TYPE", "ID_theloaitin", "=");
$tfi_listnhomtin1->addColumn("nhomtin.tennhomtin", "STRING_TYPE", "tennhomtin", "%");
$tfi_listnhomtin1->addColumn("nhomtin.ngaycapnhat", "DATE_TYPE", "ngaycapnhat", "=");
$tfi_listnhomtin1->addColumn("nhomtin.visible", "NUMERIC_TYPE", "visible", "=");
$tfi_listnhomtin1->Execute();

// Sorter
$tso_listnhomtin1 = new TSO_TableSorter("rsnhomtin1", "tso_listnhomtin1");
$tso_listnhomtin1->addColumn("theloai.tentheloai");
$tso_listnhomtin1->addColumn("theloaitin.tentheloaitin");
$tso_listnhomtin1->addColumn("nhomtin.tennhomtin");
$tso_listnhomtin1->addColumn("nhomtin.ngaycapnhat");
$tso_listnhomtin1->addColumn("nhomtin.visible");
$tso_listnhomtin1->setDefault("nhomtin.ngaycapnhat DESC");
$tso_listnhomtin1->Execute();

// Navigation
$nav_listnhomtin1 = new NAV_Regular("nav_listnhomtin1", "rsnhomtin1", "../", $_SERVER['PHP_SELF'], 10);

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

//NeXTenesio3 Special List Recordset
$maxRows_rsnhomtin1 = $_SESSION['max_rows_nav_listnhomtin1'];
$pageNum_rsnhomtin1 = 0;
if (isset($_GET['pageNum_rsnhomtin1'])) {
  $pageNum_rsnhomtin1 = $_GET['pageNum_rsnhomtin1'];
}
$startRow_rsnhomtin1 = $pageNum_rsnhomtin1 * $maxRows_rsnhomtin1;

// Defining List Recordset variable
$NXTFilter_rsnhomtin1 = "1=1";
if (isset($_SESSION['filter_tfi_listnhomtin1'])) {
  $NXTFilter_rsnhomtin1 = $_SESSION['filter_tfi_listnhomtin1'];
}
// Defining List Recordset variable
$NXTSort_rsnhomtin1 = "nhomtin.ngaycapnhat DESC";
if (isset($_SESSION['sorter_tso_listnhomtin1'])) {
  $NXTSort_rsnhomtin1 = $_SESSION['sorter_tso_listnhomtin1'];
}
mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);

$query_rsnhomtin1 = "SELECT theloai.tentheloai AS ID_theloai, theloaitin.tentheloaitin AS ID_theloaitin, nhomtin.tennhomtin, nhomtin.ngaycapnhat, nhomtin.visible, nhomtin.ID_nhomtin FROM (nhomtin LEFT JOIN theloai ON nhomtin.ID_theloai = theloai.ID_theloai) LEFT JOIN theloaitin ON nhomtin.ID_theloaitin = theloaitin.ID_theloaitin WHERE {$NXTFilter_rsnhomtin1} ORDER BY {$NXTSort_rsnhomtin1}";
$query_limit_rsnhomtin1 = sprintf("%s LIMIT %d, %d", $query_rsnhomtin1, $startRow_rsnhomtin1, $maxRows_rsnhomtin1);
$rsnhomtin1 = mysql_query($query_limit_rsnhomtin1, $conn_vietchuyen) or die(mysql_error());
$row_rsnhomtin1 = mysql_fetch_assoc($rsnhomtin1);

if (isset($_GET['totalRows_rsnhomtin1'])) {
  $totalRows_rsnhomtin1 = $_GET['totalRows_rsnhomtin1'];
} else {
  $all_rsnhomtin1 = mysql_query($query_rsnhomtin1);
  $totalRows_rsnhomtin1 = mysql_num_rows($all_rsnhomtin1);
}
$totalPages_rsnhomtin1 = ceil($totalRows_rsnhomtin1/$maxRows_rsnhomtin1)-1;
//End NeXTenesio3 Special List Recordset

$nav_listnhomtin1->checkBoundries();
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
  .KT_col_ID_theloai {width:140px; overflow:hidden;}
  .KT_col_ID_theloaitin {width:140px; overflow:hidden;}
  .KT_col_tennhomtin {width:200px; overflow:hidden;}
  .KT_col_ngaycapnhat {width:140px; overflow:hidden;}
  .KT_col_visible {width:140px; overflow:hidden;}
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

</head>

<body>
	
<div class="KT_tng" id="listnhomtin1">
  <h1>
    Quản lý các nhóm tin
      <?php
  $nav_listnhomtin1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options">
        <a href="<?php echo $nav_listnhomtin1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
<?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listnhomtin1'] == 1) {
?>
          <?php echo $_SESSION['default_max_rows_nav_listnhomtin1']; ?> 
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
  if (@$_SESSION['has_filter_tfi_listnhomtin1'] == 1) {
?>
        <a href="<?php echo $tfi_listnhomtin1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
<?php 
  // else Conditional region2
  } else { ?>
        <a href="<?php echo $tfi_listnhomtin1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
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
            <th id="ID_theloai" class="KT_sorter KT_col_ID_theloai <?php echo $tso_listnhomtin1->getSortIcon('theloai.tentheloai'); ?>">
              <a href="<?php echo $tso_listnhomtin1->getSortLink('theloai.tentheloai'); ?>">Danh mục tin cấp 1</a>
            </th>
            <th id="ID_theloaitin" class="KT_sorter KT_col_ID_theloaitin <?php echo $tso_listnhomtin1->getSortIcon('theloaitin.tentheloaitin'); ?>">
              <a href="<?php echo $tso_listnhomtin1->getSortLink('theloaitin.tentheloaitin'); ?>">Danh mục tin cấp 2</a>
            </th>
            <th id="tennhomtin" class="KT_sorter KT_col_tennhomtin <?php echo $tso_listnhomtin1->getSortIcon('nhomtin.tennhomtin'); ?>">
              <a href="<?php echo $tso_listnhomtin1->getSortLink('nhomtin.tennhomtin'); ?>">Tên chuyên đề</a>
            </th>
            <th id="ngaycapnhat" class="KT_sorter KT_col_ngaycapnhat <?php echo $tso_listnhomtin1->getSortIcon('nhomtin.ngaycapnhat'); ?>">
              <a href="<?php echo $tso_listnhomtin1->getSortLink('nhomtin.ngaycapnhat'); ?>">Ngày cập nhật</a>
            </th>
            <th id="visible" class="KT_sorter KT_col_visible <?php echo $tso_listnhomtin1->getSortIcon('nhomtin.visible'); ?>">
              <a href="<?php echo $tso_listnhomtin1->getSortLink('nhomtin.visible'); ?>">Visible</a>
            </th>
            <th>&nbsp;</th>
          </tr>
<?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listnhomtin1'] == 1) {
?>
          <tr class="KT_row_filter">
            <td>&nbsp;</td>
            	<td>
		<select name="tfi_listnhomtin1_ID_theloai" id="tfi_listnhomtin1_ID_theloai">
      <option value="" <?php if (!(strcmp("", @$_SESSION['tfi_listnhomtin1_ID_theloai']))) {echo "SELECTED";} ?>><?php echo NXT_getResource("None"); ?></option>
<?php
do {  
?>
			<option value="<?php echo $row_Recordset1['ID_theloai']?>"<?php if (!(strcmp($row_Recordset1['ID_theloai'], @$_SESSION['tfi_listnhomtin1_ID_theloai']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['tentheloai']?></option>
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
            	<td>
		<select name="tfi_listnhomtin1_ID_theloaitin" id="tfi_listnhomtin1_ID_theloaitin" wdg:subtype="DependentDropdown" wdg:type="widget" wdg:recordset="Recordset2" wdg:displayfield="tentheloaitin" wdg:valuefield="ID_theloaitin" wdg:fkey="ID_theloai" wdg:triggerobject="tfi_listnhomtin1_ID_theloai" wdg:selected="<?php @$_SESSION['tfi_listnhomtin1_ID_theloaitin'] ?>">
		  <option value=""><?php echo NXT_getResource("None"); ?></option>
		</select>
	</td>
            	<td><input type="text" name="tfi_listnhomtin1_tennhomtin" id="tfi_listnhomtin1_tennhomtin" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listnhomtin1_tennhomtin']); ?>" size="20" maxlength="55" /></td>
            	<td><input type="text" name="tfi_listnhomtin1_ngaycapnhat" id="tfi_listnhomtin1_ngaycapnhat" value="<?php echo @$_SESSION['tfi_listnhomtin1_ngaycapnhat']; ?>" size="10" maxlength="22" /></td>
            	<td><input type="text" name="tfi_listnhomtin1_visible" id="tfi_listnhomtin1_visible" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listnhomtin1_visible']); ?>" size="20" maxlength="100" /></td>
            
            <td><input type="submit" name="tfi_listnhomtin1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
          </tr>
<?php } 
  // endif Conditional region3
?>
        </thead>
        <tbody>
<?php if ($totalRows_rsnhomtin1 == 0) { // Show if recordset empty ?>
          <tr>
            <td colspan="7"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
          </tr>
<?php } // Show if recordset empty ?>
<?php if ($totalRows_rsnhomtin1 > 0) { // Show if recordset not empty ?>
<?php do { ?>
          <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
            <td>
              <input type="checkbox" name="kt_pk_nhomtin" class="id_checkbox" value="<?php echo $row_rsnhomtin1['ID_nhomtin']; ?>" />
              <input type="hidden" name="ID_nhomtin" class="id_field" value="<?php echo $row_rsnhomtin1['ID_nhomtin']; ?>" />
            </td>
            <td>
              <div class="KT_col_ID_theloai"><?php echo KT_FormatForList($row_rsnhomtin1['ID_theloai'], 20); ?></div>
            </td>
            <td>
              <div class="KT_col_ID_theloaitin"><?php echo KT_FormatForList($row_rsnhomtin1['ID_theloaitin'], 20); ?></div>
            </td>
            <td>
              <div class="KT_col_tennhomtin"><?php echo KT_FormatForList($row_rsnhomtin1['tennhomtin'], 200); ?></div>
            </td>
            <td>
              <div class="KT_col_ngaycapnhat"><?php echo KT_formatDate($row_rsnhomtin1['ngaycapnhat']); ?></div>
            </td>
            <td align="center"><?php 
// Show IF Conditional region4 
if (@$row_rsnhomtin1['visible'] == 1) {
?>
                <img src="check.png" width="24" height="24">
                <?php 
// else Conditional region4
} else { ?>
                <img src="delete.png" width="24" height="24">
                <?php } 
// endif Conditional region4
?></td>
            <td>
              <a class="KT_edit_link" href="admincp.php?vietchuyen=form_nhomtin&ID_nhomtin=<?php echo $row_rsnhomtin1['ID_nhomtin']; ?>&KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a>
              <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a>
            </td>
          </tr>
<?php } while ($row_rsnhomtin1 = mysql_fetch_assoc($rsnhomtin1)); ?>
<?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listnhomtin1->Prepare();
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
        <a class="KT_additem_op_link" href="admincp.php?vietchuyen=form_nhomtin&KT_back=1" onclick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a>
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

mysql_free_result($rsnhomtin1);
?>
