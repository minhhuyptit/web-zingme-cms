<?php require_once('../Connections/conn_vietchuyen.php'); ?>
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
$tfi_listthanhvien1 = new TFI_TableFilter($conn_conn_vietchuyen, "tfi_listthanhvien1");
$tfi_listthanhvien1->addColumn("thanhvien.hoten", "STRING_TYPE", "hoten", "%");
$tfi_listthanhvien1->addColumn("thanhvien.gioitinh", "STRING_TYPE", "gioitinh", "%");
$tfi_listthanhvien1->addColumn("thanhvien.ngaysinh", "DATE_TYPE", "ngaysinh", "=");
$tfi_listthanhvien1->addColumn("thanhvien.email", "STRING_TYPE", "email", "%");
$tfi_listthanhvien1->addColumn("thanhvien.dienthoai", "STRING_TYPE", "dienthoai", "%");
$tfi_listthanhvien1->addColumn("thanhvien.username", "STRING_TYPE", "username", "%");
$tfi_listthanhvien1->addColumn("thanhvien.accesslevel", "NUMERIC_TYPE", "accesslevel", "=");
$tfi_listthanhvien1->addColumn("thanhvien.active", "NUMERIC_TYPE", "active", "=");
$tfi_listthanhvien1->addColumn("thanhvien.ngaycapnhat", "DATE_TYPE", "ngaycapnhat", "=");
$tfi_listthanhvien1->Execute();

// Sorter
$tso_listthanhvien1 = new TSO_TableSorter("rsthanhvien1", "tso_listthanhvien1");
$tso_listthanhvien1->addColumn("thanhvien.hoten");
$tso_listthanhvien1->addColumn("thanhvien.gioitinh");
$tso_listthanhvien1->addColumn("thanhvien.ngaysinh");
$tso_listthanhvien1->addColumn("thanhvien.email");
$tso_listthanhvien1->addColumn("thanhvien.dienthoai");
$tso_listthanhvien1->addColumn("thanhvien.username");
$tso_listthanhvien1->addColumn("thanhvien.accesslevel");
$tso_listthanhvien1->addColumn("thanhvien.active");
$tso_listthanhvien1->addColumn("thanhvien.ngaycapnhat");
$tso_listthanhvien1->setDefault("thanhvien.ngaycapnhat DESC");
$tso_listthanhvien1->Execute();

// Navigation
$nav_listthanhvien1 = new NAV_Regular("nav_listthanhvien1", "rsthanhvien1", "../", $_SERVER['PHP_SELF'], 10);

mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_Recordset1 = "SELECT tenquequan, ID_quequan FROM quequan ORDER BY tenquequan";
$Recordset1 = mysql_query($query_Recordset1, $conn_vietchuyen) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_Recordset2 = "SELECT tennghenghiep, ID_nghenghiep FROM nghenghiep ORDER BY tennghenghiep";
$Recordset2 = mysql_query($query_Recordset2, $conn_vietchuyen) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

//NeXTenesio3 Special List Recordset
$maxRows_rsthanhvien1 = $_SESSION['max_rows_nav_listthanhvien1'];
$pageNum_rsthanhvien1 = 0;
if (isset($_GET['pageNum_rsthanhvien1'])) {
  $pageNum_rsthanhvien1 = $_GET['pageNum_rsthanhvien1'];
}
$startRow_rsthanhvien1 = $pageNum_rsthanhvien1 * $maxRows_rsthanhvien1;

// Defining List Recordset variable
$NXTFilter_rsthanhvien1 = "1=1";
if (isset($_SESSION['filter_tfi_listthanhvien1'])) {
  $NXTFilter_rsthanhvien1 = $_SESSION['filter_tfi_listthanhvien1'];
}
// Defining List Recordset variable
$NXTSort_rsthanhvien1 = "thanhvien.ngaycapnhat DESC";
if (isset($_SESSION['sorter_tso_listthanhvien1'])) {
  $NXTSort_rsthanhvien1 = $_SESSION['sorter_tso_listthanhvien1'];
}
mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);

$query_rsthanhvien1 = "SELECT thanhvien.hoten, thanhvien.gioitinh, thanhvien.ngaysinh, quequan.tenquequan AS ID_quequan, nghenghiep.tennghenghiep AS ID_nghenghiep, thanhvien.email, thanhvien.dienthoai, thanhvien.username, thanhvien.accesslevel, thanhvien.active, thanhvien.ngaycapnhat, thanhvien.ID_thanhvien FROM (thanhvien LEFT JOIN quequan ON thanhvien.ID_quequan = quequan.ID_quequan) LEFT JOIN nghenghiep ON thanhvien.ID_nghenghiep = nghenghiep.ID_nghenghiep WHERE {$NXTFilter_rsthanhvien1} ORDER BY {$NXTSort_rsthanhvien1}";
$query_limit_rsthanhvien1 = sprintf("%s LIMIT %d, %d", $query_rsthanhvien1, $startRow_rsthanhvien1, $maxRows_rsthanhvien1);
$rsthanhvien1 = mysql_query($query_limit_rsthanhvien1, $conn_vietchuyen) or die(mysql_error());
$row_rsthanhvien1 = mysql_fetch_assoc($rsthanhvien1);

if (isset($_GET['totalRows_rsthanhvien1'])) {
  $totalRows_rsthanhvien1 = $_GET['totalRows_rsthanhvien1'];
} else {
  $all_rsthanhvien1 = mysql_query($query_rsthanhvien1);
  $totalRows_rsthanhvien1 = mysql_num_rows($all_rsthanhvien1);
}
$totalPages_rsthanhvien1 = ceil($totalRows_rsthanhvien1/$maxRows_rsthanhvien1)-1;
//End NeXTenesio3 Special List Recordset

$nav_listthanhvien1->checkBoundries();
?><!DOCTYPE html>
<html>
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
  .KT_col_hoten {width:110px; overflow:hidden;}
  .KT_col_gioitinh {width:40px; overflow:hidden;}
  .KT_col_ngaysinh {width:100px; overflow:hidden;}
  .KT_col_email {width:100px; overflow:hidden;}
  .KT_col_dienthoai {width:100px; overflow:hidden;}
  .KT_col_username {width:80px; overflow:hidden;}
  .KT_col_accesslevel {width:40px; overflow:hidden;}
  .KT_col_active {width:40px; overflow:hidden;}
  .KT_col_ngaycapnhat {width:80px; overflow:hidden;}
</style>
</head>

<body>
	
<div class="KT_tng" id="listthanhvien1">
  <h1>
    Thành viên
      <?php
  $nav_listthanhvien1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options">
        <a href="<?php echo $nav_listthanhvien1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
<?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listthanhvien1'] == 1) {
?>
          <?php echo $_SESSION['default_max_rows_nav_listthanhvien1']; ?> 
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
  if (@$_SESSION['has_filter_tfi_listthanhvien1'] == 1) {
?>
        <a href="<?php echo $tfi_listthanhvien1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
<?php 
  // else Conditional region2
  } else { ?>
        <a href="<?php echo $tfi_listthanhvien1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
<?php } 
  // endif Conditional region2
?>
      </div>
      <table cellpadding="2" cellspacing="0" class="KT_tngtable">
        <thead>
          <tr class="KT_row_order">
            <th>
              <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
            </th>
            <th id="hoten" class="KT_sorter KT_col_hoten <?php echo $tso_listthanhvien1->getSortIcon('thanhvien.hoten'); ?>">
              <a href="<?php echo $tso_listthanhvien1->getSortLink('thanhvien.hoten'); ?>">Họ tên</a>
            </th>
            <th id="gioitinh" class="KT_sorter KT_col_gioitinh <?php echo $tso_listthanhvien1->getSortIcon('thanhvien.gioitinh'); ?>">
              <a href="<?php echo $tso_listthanhvien1->getSortLink('thanhvien.gioitinh'); ?>">Giới tính</a>            </th>
            <th id="ngaysinh" class="KT_sorter KT_col_ngaysinh <?php echo $tso_listthanhvien1->getSortIcon('thanhvien.ngaysinh'); ?>">
              <a href="<?php echo $tso_listthanhvien1->getSortLink('thanhvien.ngaysinh'); ?>">Ngày sinh</a>
            </th>
            <th id="email" class="KT_sorter KT_col_email <?php echo $tso_listthanhvien1->getSortIcon('thanhvien.email'); ?>">
              <a href="<?php echo $tso_listthanhvien1->getSortLink('thanhvien.email'); ?>">Email</a>
            </th>
            <th id="dienthoai" class="KT_sorter KT_col_dienthoai <?php echo $tso_listthanhvien1->getSortIcon('thanhvien.dienthoai'); ?>">
              <a href="<?php echo $tso_listthanhvien1->getSortLink('thanhvien.dienthoai'); ?>">Điện thoại</a>
            </th>
            <th id="username" class="KT_sorter KT_col_username <?php echo $tso_listthanhvien1->getSortIcon('thanhvien.username'); ?>">
              <a href="<?php echo $tso_listthanhvien1->getSortLink('thanhvien.username'); ?>">Username</a>
            </th>
            <th id="accesslevel" class="KT_sorter KT_col_accesslevel <?php echo $tso_listthanhvien1->getSortIcon('thanhvien.accesslevel'); ?>">
              <a href="<?php echo $tso_listthanhvien1->getSortLink('thanhvien.accesslevel'); ?>">Quyền</a>            </th>
            <th id="active" class="KT_sorter KT_col_active <?php echo $tso_listthanhvien1->getSortIcon('thanhvien.active'); ?>">
              <a href="<?php echo $tso_listthanhvien1->getSortLink('thanhvien.active'); ?>">Kích hoạt</a>            </th>
            <th id="ngaycapnhat" class="KT_sorter KT_col_ngaycapnhat <?php echo $tso_listthanhvien1->getSortIcon('thanhvien.ngaycapnhat'); ?>">
              <a href="<?php echo $tso_listthanhvien1->getSortLink('thanhvien.ngaycapnhat'); ?>">Ngày cập nhật</a>
            </th>
            <th>&nbsp;</th>
          </tr>
<?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listthanhvien1'] == 1) {
?>
          <tr class="KT_row_filter">
            <td>&nbsp;</td>
            	<td><input type="text" name="tfi_listthanhvien1_hoten" id="tfi_listthanhvien1_hoten" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listthanhvien1_hoten']); ?>" size="5" maxlength="55" /></td>
            	<td><input type="text" name="tfi_listthanhvien1_gioitinh" id="tfi_listthanhvien1_gioitinh" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listthanhvien1_gioitinh']); ?>" size="5" maxlength="45" /></td>
            	<td><input type="text" name="tfi_listthanhvien1_ngaysinh" id="tfi_listthanhvien1_ngaysinh" value="<?php echo @$_SESSION['tfi_listthanhvien1_ngaysinh']; ?>" size="5" maxlength="22" /></td>
            	<td><input type="text" name="tfi_listthanhvien1_email" id="tfi_listthanhvien1_email" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listthanhvien1_email']); ?>" size="5" maxlength="100" /></td>
            	<td><input type="text" name="tfi_listthanhvien1_dienthoai" id="tfi_listthanhvien1_dienthoai" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listthanhvien1_dienthoai']); ?>" size="5" maxlength="50" /></td>
            	<td><input type="text" name="tfi_listthanhvien1_username" id="tfi_listthanhvien1_username" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listthanhvien1_username']); ?>" size="5" maxlength="100" /></td>
            	<td><input type="text" name="tfi_listthanhvien1_accesslevel" id="tfi_listthanhvien1_accesslevel" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listthanhvien1_accesslevel']); ?>" size="5" maxlength="100" /></td>
            	<td><input type="text" name="tfi_listthanhvien1_active" id="tfi_listthanhvien1_active" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listthanhvien1_active']); ?>" size="5" maxlength="100" /></td>
            	<td><input type="text" name="tfi_listthanhvien1_ngaycapnhat" id="tfi_listthanhvien1_ngaycapnhat" value="<?php echo @$_SESSION['tfi_listthanhvien1_ngaycapnhat']; ?>" size="5" maxlength="22" /></td>
            
            <td><input type="submit" name="tfi_listthanhvien1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
          </tr>
<?php } 
  // endif Conditional region3
?>
        </thead>
        <tbody>
<?php if ($totalRows_rsthanhvien1 == 0) { // Show if recordset empty ?>
          <tr>
            <td colspan="11"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
          </tr>
<?php } // Show if recordset empty ?>
<?php if ($totalRows_rsthanhvien1 > 0) { // Show if recordset not empty ?>
<?php do { ?>
          <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
            <td>
              <input type="checkbox" name="kt_pk_thanhvien" class="id_checkbox" value="<?php echo $row_rsthanhvien1['ID_thanhvien']; ?>" />
              <input type="hidden" name="ID_thanhvien" class="id_field" value="<?php echo $row_rsthanhvien1['ID_thanhvien']; ?>" />
            </td>
            <td>
              <div class="KT_col_hoten"><?php echo KT_FormatForList($row_rsthanhvien1['hoten'], 200); ?></div>
            </td>
            <td>
              <div class="KT_col_gioitinh"><?php echo KT_FormatForList($row_rsthanhvien1['gioitinh'], 20); ?></div>
            </td>
            <td>
              <div class="KT_col_ngaysinh"><?php echo KT_formatDate($row_rsthanhvien1['ngaysinh']); ?></div>
            </td>
            <td>
              <div class="KT_col_email"><?php echo KT_FormatForList($row_rsthanhvien1['email'], 200); ?></div>
            </td>
            <td>
              <div class="KT_col_dienthoai"><?php echo KT_FormatForList($row_rsthanhvien1['dienthoai'], 20); ?></div>
            </td>
            <td>
              <div class="KT_col_username"><?php echo KT_FormatForList($row_rsthanhvien1['username'], 20); ?></div>
            </td>
            <td><?php 
// Show IF Conditional region4 
if (@$row_rsthanhvien1['accesslevel'] == 1) {
?>
                Admin
  <?php } 
// endif Conditional region4
?>
              <?php 
// Show IF Conditional region5 
if (@$row_rsthanhvien1['accesslevel'] == 2) {
?>
                User
  <?php } 
// endif Conditional region5
?>
              <?php 
// Show IF Conditional region6 
if (@$row_rsthanhvien1['accesslevel'] == 3) {
?>
                Manager
  <?php } 
// endif Conditional region6
?></td>
            <td>
              <div class="KT_col_active"><?php echo KT_FormatForList($row_rsthanhvien1['active'], 20); ?></div>
            </td>
            <td>
              <div class="KT_col_ngaycapnhat"><?php echo KT_formatDate($row_rsthanhvien1['ngaycapnhat']); ?></div>
            </td>
            <td>
              <a class="KT_edit_link" href="admincp.php?vietchuyen=form_thanhvien&ID_thanhvien=<?php echo $row_rsthanhvien1['ID_thanhvien']; ?>&KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a>
              <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a>
            </td>
          </tr>
<?php } while ($row_rsthanhvien1 = mysql_fetch_assoc($rsthanhvien1)); ?>
<?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listthanhvien1->Prepare();
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
          <option value="3">3</option>
          <option value="6">6</option>
        </select>
        <a class="KT_additem_op_link" href="admincp.php?vietchuyen=form_thanhvien&KT_back=1" onclick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a>
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

mysql_free_result($rsthanhvien1);
?>
