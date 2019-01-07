<?php require_once('../Connections/conn_vietchuyen.php'); ?><?php
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
$tfi_listgame1 = new TFI_TableFilter($conn_conn_vietchuyen, "tfi_listgame1");
$tfi_listgame1->addColumn("theloaigame.ID_theloaigame", "NUMERIC_TYPE", "ID_theloaigame", "=");
$tfi_listgame1->addColumn("game.tengame", "STRING_TYPE", "tengame", "%");
$tfi_listgame1->addColumn("game.hinhgame", "STRING_TYPE", "hinhgame", "%");
$tfi_listgame1->addColumn("game.taptingame", "STRING_TYPE", "taptingame", "%");
$tfi_listgame1->addColumn("game.hot", "NUMERIC_TYPE", "hot", "=");
$tfi_listgame1->addColumn("game.urlgame", "STRING_TYPE", "urlgame", "%");
$tfi_listgame1->addColumn("game.ngaycapnhat", "DATE_TYPE", "ngaycapnhat", "=");
$tfi_listgame1->addColumn("game.kiemduyet", "NUMERIC_TYPE", "kiemduyet", "=");
$tfi_listgame1->Execute();

// Sorter
$tso_listgame1 = new TSO_TableSorter("rsgame1", "tso_listgame1");
$tso_listgame1->addColumn("theloaigame.tentheloaigame");
$tso_listgame1->addColumn("game.tengame");
$tso_listgame1->addColumn("game.hinhgame");
$tso_listgame1->addColumn("game.taptingame");
$tso_listgame1->addColumn("game.hot");
$tso_listgame1->addColumn("game.urlgame");
$tso_listgame1->addColumn("game.ngaycapnhat");
$tso_listgame1->addColumn("game.kiemduyet");
$tso_listgame1->setDefault("game.ngaycapnhat DESC");
$tso_listgame1->Execute();

// Navigation
$nav_listgame1 = new NAV_Regular("nav_listgame1", "rsgame1", "../", $_SERVER['PHP_SELF'], 10);

mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_Recordset1 = "SELECT tentheloaigame, ID_theloaigame FROM theloaigame ORDER BY tentheloaigame";
$Recordset1 = mysql_query($query_Recordset1, $conn_vietchuyen) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

//NeXTenesio3 Special List Recordset
$maxRows_rsgame1 = $_SESSION['max_rows_nav_listgame1'];
$pageNum_rsgame1 = 0;
if (isset($_GET['pageNum_rsgame1'])) {
  $pageNum_rsgame1 = $_GET['pageNum_rsgame1'];
}
$startRow_rsgame1 = $pageNum_rsgame1 * $maxRows_rsgame1;

// Defining List Recordset variable
$NXTFilter_rsgame1 = "1=1";
if (isset($_SESSION['filter_tfi_listgame1'])) {
  $NXTFilter_rsgame1 = $_SESSION['filter_tfi_listgame1'];
}
// Defining List Recordset variable
$NXTSort_rsgame1 = "game.ngaycapnhat DESC";
if (isset($_SESSION['sorter_tso_listgame1'])) {
  $NXTSort_rsgame1 = $_SESSION['sorter_tso_listgame1'];
}
mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);

$query_rsgame1 = "SELECT theloaigame.tentheloaigame AS ID_theloaigame, game.tengame, game.hinhgame, game.taptingame, game.solanchoi, game.solandownload, game.hot, game.urlgame, game.ngaycapnhat, game.kiemduyet, game.ID_game FROM game LEFT JOIN theloaigame ON game.ID_theloaigame = theloaigame.ID_theloaigame WHERE {$NXTFilter_rsgame1} ORDER BY {$NXTSort_rsgame1}";
$query_limit_rsgame1 = sprintf("%s LIMIT %d, %d", $query_rsgame1, $startRow_rsgame1, $maxRows_rsgame1);
$rsgame1 = mysql_query($query_limit_rsgame1, $conn_vietchuyen) or die(mysql_error());
$row_rsgame1 = mysql_fetch_assoc($rsgame1);

if (isset($_GET['totalRows_rsgame1'])) {
  $totalRows_rsgame1 = $_GET['totalRows_rsgame1'];
} else {
  $all_rsgame1 = mysql_query($query_rsgame1);
  $totalRows_rsgame1 = mysql_num_rows($all_rsgame1);
}
$totalPages_rsgame1 = ceil($totalRows_rsgame1/$maxRows_rsgame1)-1;
//End NeXTenesio3 Special List Recordset

$nav_listgame1->checkBoundries();

// Show Dynamic Thumbnail
$objDynamicThumb1 = new tNG_DynamicThumbnail("../", "KT_thumbnail1");
$objDynamicThumb1->setFolder("../game/hinhgame/");
$objDynamicThumb1->setRenameRule("{rsgame1.hinhgame}");
$objDynamicThumb1->setResize(80, 0, true);
$objDynamicThumb1->setWatermark(false);
$objDynamicThumb1->setPopupSize(800, 600, true);
$objDynamicThumb1->setPopupNavigation(false);
$objDynamicThumb1->setPopupWatermark(false);
?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Quản lý game</title><link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" /><script src="../includes/common/js/base.js" type="text/javascript"></script><script src="../includes/common/js/utility.js" type="text/javascript"></script><script src="../includes/skins/style.js" type="text/javascript"></script><script src="../includes/nxt/scripts/list.js" type="text/javascript"></script><script src="../includes/nxt/scripts/list.js.php" type="text/javascript"></script><script type="text/javascript">
$NXT_LIST_SETTINGS = {
  duplicate_buttons: true,
  duplicate_navigation: true,
  row_effects: true,
  show_as_buttons: true,
  record_counter: true
}
</script><style type="text/css">
  /* Dynamic List row settings */
  .KT_col_ID_theloaigame {width:100px; overflow:hidden;}
  .KT_col_tengame {width:140px; overflow:hidden;}
  .KT_col_hinhgame {width:140px; overflow:hidden;}
  .KT_col_taptingame {width:140px; overflow:hidden;}
  .KT_col_hot {width:40px; overflow:hidden;}
  .KT_col_urlgame {width:80px; overflow:hidden;}
  .KT_col_ngaycapnhat {width:120px; overflow:hidden;}
  .KT_col_kiemduyet {width:40px; overflow:hidden;}
</style>
</head>
<body>
<div class="KT_tng" id="listgame1">
  <h1>
    Quản lý Game
      <?php
  $nav_listgame1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options">
        <a href="<?php echo $nav_listgame1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
<?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listgame1'] == 1) {
?>
          <?php echo $_SESSION['default_max_rows_nav_listgame1']; ?> 
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
  if (@$_SESSION['has_filter_tfi_listgame1'] == 1) {
?>
        <a href="<?php echo $tfi_listgame1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
<?php 
  // else Conditional region2
  } else { ?>
        <a href="<?php echo $tfi_listgame1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
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
            <th id="ID_theloaigame" class="KT_sorter KT_col_ID_theloaigame <?php echo $tso_listgame1->getSortIcon('theloaigame.tentheloaigame'); ?>">
              <a href="<?php echo $tso_listgame1->getSortLink('theloaigame.tentheloaigame'); ?>">Danh mục game</a>
            </th>
            <th id="tengame" class="KT_sorter KT_col_tengame <?php echo $tso_listgame1->getSortIcon('game.tengame'); ?>">
              <a href="<?php echo $tso_listgame1->getSortLink('game.tengame'); ?>">Tên game</a>
            </th>
            <th id="hinhgame" class="KT_sorter KT_col_hinhgame <?php echo $tso_listgame1->getSortIcon('game.hinhgame'); ?>">
              <a href="<?php echo $tso_listgame1->getSortLink('game.hinhgame'); ?>">Hình</a>
            </th>
            <th id="taptingame" class="KT_sorter KT_col_taptingame <?php echo $tso_listgame1->getSortIcon('game.taptingame'); ?>">
              <a href="<?php echo $tso_listgame1->getSortLink('game.taptingame'); ?>">File</a>
            </th>
            <th id="hot" class="KT_sorter KT_col_hot <?php echo $tso_listgame1->getSortIcon('game.hot'); ?>">
              <a href="<?php echo $tso_listgame1->getSortLink('game.hot'); ?>">Hot</a>
            </th>
            <th id="urlgame" class="KT_sorter KT_col_urlgame <?php echo $tso_listgame1->getSortIcon('game.urlgame'); ?>">
              <a href="<?php echo $tso_listgame1->getSortLink('game.urlgame'); ?>">URL</a>
            </th>
            <th id="ngaycapnhat" class="KT_sorter KT_col_ngaycapnhat <?php echo $tso_listgame1->getSortIcon('game.ngaycapnhat'); ?>">
              <a href="<?php echo $tso_listgame1->getSortLink('game.ngaycapnhat'); ?>">Ngày cập nhật</a>
            </th>
            <th id="kiemduyet" class="KT_sorter KT_col_kiemduyet <?php echo $tso_listgame1->getSortIcon('game.kiemduyet'); ?>">
              <a href="<?php echo $tso_listgame1->getSortLink('game.kiemduyet'); ?>">Kiểm duyệt</a>
            </th>
            <th>&nbsp;</th>
          </tr>
<?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listgame1'] == 1) {
?>
          <tr class="KT_row_filter">
            <td>&nbsp;</td>
            	<td>
		<select name="tfi_listgame1_ID_theloaigame" id="tfi_listgame1_ID_theloaigame">
      <option value="" <?php if (!(strcmp("", @$_SESSION['tfi_listgame1_ID_theloaigame']))) {echo "SELECTED";} ?>><?php echo NXT_getResource("None"); ?></option>
<?php
do {  
?>
			<option value="<?php echo $row_Recordset1['ID_theloaigame']?>"<?php if (!(strcmp($row_Recordset1['ID_theloaigame'], @$_SESSION['tfi_listgame1_ID_theloaigame']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['tentheloaigame']?></option>
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
            	<td><input type="text" name="tfi_listgame1_tengame" id="tfi_listgame1_tengame" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listgame1_tengame']); ?>" size="20" maxlength="200" /></td>
            	<td><input type="text" name="tfi_listgame1_hinhgame" id="tfi_listgame1_hinhgame" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listgame1_hinhgame']); ?>" size="20" maxlength="100" /></td>
            	<td><input type="text" name="tfi_listgame1_taptingame" id="tfi_listgame1_taptingame" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listgame1_taptingame']); ?>" size="20" maxlength="200" /></td>
            	<td><input type="text" name="tfi_listgame1_hot" id="tfi_listgame1_hot" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listgame1_hot']); ?>" size="20" maxlength="100" /></td>
            	<td><input type="text" name="tfi_listgame1_urlgame" id="tfi_listgame1_urlgame" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listgame1_urlgame']); ?>" size="20" maxlength="255" /></td>
            	<td><input type="text" name="tfi_listgame1_ngaycapnhat" id="tfi_listgame1_ngaycapnhat" value="<?php echo @$_SESSION['tfi_listgame1_ngaycapnhat']; ?>" size="10" maxlength="22" /></td>
            	<td><input type="text" name="tfi_listgame1_kiemduyet" id="tfi_listgame1_kiemduyet" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listgame1_kiemduyet']); ?>" size="20" maxlength="100" /></td>
            
            <td><input type="submit" name="tfi_listgame1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
          </tr>
<?php } 
  // endif Conditional region3
?>
        </thead>
        <tbody>
<?php if ($totalRows_rsgame1 == 0) { // Show if recordset empty ?>
          <tr>
            <td colspan="10"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
          </tr>
<?php } // Show if recordset empty ?>
<?php if ($totalRows_rsgame1 > 0) { // Show if recordset not empty ?>
<?php do { ?>
          <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
            <td>
              <input type="checkbox" name="kt_pk_game" class="id_checkbox" value="<?php echo $row_rsgame1['ID_game']; ?>" />
              <input type="hidden" name="ID_game" class="id_field" value="<?php echo $row_rsgame1['ID_game']; ?>" />
            </td>
            <td>
              <div class="KT_col_ID_theloaigame"><?php echo KT_FormatForList($row_rsgame1['ID_theloaigame'], 20); ?></div>
            </td>
            <td>
              <div class="KT_col_tengame"><b><?php echo KT_FormatForList($row_rsgame1['tengame'], 100); ?></b>
              	<br>Số lần chơi: <?php echo $row_rsgame1['solanchoi']; ?>
                <br>Số lần download:<?php echo $row_rsgame1['solandownload']; ?>
              </div>
            </td>
            <td><a href="<?php echo $objDynamicThumb1->getPopupLink(); ?>" onclick="<?php echo $objDynamicThumb1->getPopupAction(); ?>" target="_blank"><img src="<?php echo $objDynamicThumb1->Execute(); ?>" border="0" /></a></td>
            <td>
              <div class="KT_col_taptingame"><?php echo KT_FormatForList($row_rsgame1['taptingame'], 20); ?></div>
            </td>
            <td>
              <div class="KT_col_hot"><?php echo KT_FormatForList($row_rsgame1['hot'], 20); ?></div>
            </td>
            <td>
              <div class="KT_col_urlgame"><?php echo KT_FormatForList($row_rsgame1['urlgame'], 20); ?></div>
            </td>
            <td>
              <div class="KT_col_ngaycapnhat"><?php echo KT_formatDate($row_rsgame1['ngaycapnhat']); ?></div>
            </td>
            <td align="center"><?php 
// Show IF Conditional region4 
if (@$row_rsgame1['kiemduyet'] == 1) {
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
              <a class="KT_edit_link" href="admincp.php?vietchuyen=form_game&amp;ID_game=<?php echo $row_rsgame1['ID_game']; ?>&amp;KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a>
              <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a>
            </td>
          </tr>
<?php } while ($row_rsgame1 = mysql_fetch_assoc($rsgame1)); ?>
<?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listgame1->Prepare();
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
        <a class="KT_additem_op_link" href="admincp.php?vietchuyen=form_game&amp;KT_back=1" onclick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a>
      </div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>

	
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($rsgame1);
?>
