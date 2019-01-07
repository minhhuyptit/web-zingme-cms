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
$tfi_listcopyright1 = new TFI_TableFilter($conn_conn_vietchuyen, "tfi_listcopyright1");
$tfi_listcopyright1->addColumn("copyright.tenwebsite", "STRING_TYPE", "tenwebsite", "%");
$tfi_listcopyright1->addColumn("copyright.logo", "STRING_TYPE", "logo", "%");
$tfi_listcopyright1->addColumn("copyright.dienthoai", "STRING_TYPE", "dienthoai", "%");
$tfi_listcopyright1->addColumn("copyright.email", "STRING_TYPE", "email", "%");
$tfi_listcopyright1->addColumn("copyright.website1", "STRING_TYPE", "website1", "%");
$tfi_listcopyright1->addColumn("copyright.website2", "STRING_TYPE", "website2", "%");
$tfi_listcopyright1->addColumn("copyright.website3", "STRING_TYPE", "website3", "%");
$tfi_listcopyright1->Execute();

// Sorter
$tso_listcopyright1 = new TSO_TableSorter("rscopyright1", "tso_listcopyright1");
$tso_listcopyright1->addColumn("copyright.tenwebsite");
$tso_listcopyright1->addColumn("copyright.logo");
$tso_listcopyright1->addColumn("copyright.dienthoai");
$tso_listcopyright1->addColumn("copyright.email");
$tso_listcopyright1->addColumn("copyright.website1");
$tso_listcopyright1->addColumn("copyright.website2");
$tso_listcopyright1->addColumn("copyright.website3");
$tso_listcopyright1->setDefault("copyright.tenwebsite");
$tso_listcopyright1->Execute();

// Navigation
$nav_listcopyright1 = new NAV_Regular("nav_listcopyright1", "rscopyright1", "../", $_SERVER['PHP_SELF'], 10);

//NeXTenesio3 Special List Recordset
$maxRows_rscopyright1 = $_SESSION['max_rows_nav_listcopyright1'];
$pageNum_rscopyright1 = 0;
if (isset($_GET['pageNum_rscopyright1'])) {
  $pageNum_rscopyright1 = $_GET['pageNum_rscopyright1'];
}
$startRow_rscopyright1 = $pageNum_rscopyright1 * $maxRows_rscopyright1;

// Defining List Recordset variable
$NXTFilter_rscopyright1 = "1=1";
if (isset($_SESSION['filter_tfi_listcopyright1'])) {
  $NXTFilter_rscopyright1 = $_SESSION['filter_tfi_listcopyright1'];
}
// Defining List Recordset variable
$NXTSort_rscopyright1 = "copyright.tenwebsite";
if (isset($_SESSION['sorter_tso_listcopyright1'])) {
  $NXTSort_rscopyright1 = $_SESSION['sorter_tso_listcopyright1'];
}
mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);

$query_rscopyright1 = "SELECT copyright.tenwebsite, copyright.logo, copyright.dienthoai, copyright.email, copyright.website1, copyright.website2, copyright.website3, copyright.ID_copyright FROM copyright WHERE {$NXTFilter_rscopyright1} ORDER BY {$NXTSort_rscopyright1}";
$query_limit_rscopyright1 = sprintf("%s LIMIT %d, %d", $query_rscopyright1, $startRow_rscopyright1, $maxRows_rscopyright1);
$rscopyright1 = mysql_query($query_limit_rscopyright1, $conn_vietchuyen) or die(mysql_error());
$row_rscopyright1 = mysql_fetch_assoc($rscopyright1);

if (isset($_GET['totalRows_rscopyright1'])) {
  $totalRows_rscopyright1 = $_GET['totalRows_rscopyright1'];
} else {
  $all_rscopyright1 = mysql_query($query_rscopyright1);
  $totalRows_rscopyright1 = mysql_num_rows($all_rscopyright1);
}
$totalPages_rscopyright1 = ceil($totalRows_rscopyright1/$maxRows_rscopyright1)-1;
//End NeXTenesio3 Special List Recordset

$nav_listcopyright1->checkBoundries();

// Show Dynamic Thumbnail
$objDynamicThumb1 = new tNG_DynamicThumbnail("../", "KT_thumbnail1");
$objDynamicThumb1->setFolder("../images/");
$objDynamicThumb1->setRenameRule("{rscopyright1.logo}");
$objDynamicThumb1->setResize(100, 0, true);
$objDynamicThumb1->setWatermark(false);
?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
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
  .KT_col_tenwebsite {width:140px; overflow:hidden;}
  .KT_col_logo {width:100px; overflow:hidden;}
  .KT_col_dienthoai {width:70px; overflow:hidden;}
  .KT_col_email {width:100px; overflow:hidden;}
  .KT_col_website1 {width:120px; overflow:hidden;}
  .KT_col_website2 {width:120px; overflow:hidden;}
  .KT_col_website3 {width:120px; overflow:hidden;}
</style>
</head>

<body>
	
<div class="KT_tng" id="listcopyright1">
  <h1> Copyright
    <?php
  $nav_listcopyright1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options"> <a href="<?php echo $nav_listcopyright1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
        <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listcopyright1'] == 1) {
?>
          <?php echo $_SESSION['default_max_rows_nav_listcopyright1']; ?>
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
  if (@$_SESSION['has_filter_tfi_listcopyright1'] == 1) {
?>
                              <a href="<?php echo $tfi_listcopyright1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
                              <?php 
  // else Conditional region2
  } else { ?>
                              <a href="<?php echo $tfi_listcopyright1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
                              <?php } 
  // endif Conditional region2
?>
      </div>
      <table width="99%" cellpadding="2" cellspacing="0" class="KT_tngtable">
        <thead>
          <tr class="KT_row_order">
            <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
            </th>
            <th id="tenwebsite" class="KT_sorter KT_col_tenwebsite <?php echo $tso_listcopyright1->getSortIcon('copyright.tenwebsite'); ?>"> <a href="<?php echo $tso_listcopyright1->getSortLink('copyright.tenwebsite'); ?>">Tenwebsite</a> </th>
            <th id="logo" class="KT_sorter KT_col_logo <?php echo $tso_listcopyright1->getSortIcon('copyright.logo'); ?>"> <a href="<?php echo $tso_listcopyright1->getSortLink('copyright.logo'); ?>">Logo</a> </th>
            <th id="dienthoai" class="KT_sorter KT_col_dienthoai <?php echo $tso_listcopyright1->getSortIcon('copyright.dienthoai'); ?>"> <a href="<?php echo $tso_listcopyright1->getSortLink('copyright.dienthoai'); ?>">Dienthoai</a> </th>
            <th id="email" class="KT_sorter KT_col_email <?php echo $tso_listcopyright1->getSortIcon('copyright.email'); ?>"> <a href="<?php echo $tso_listcopyright1->getSortLink('copyright.email'); ?>">Email</a> </th>
            <th id="website1" class="KT_sorter KT_col_website1 <?php echo $tso_listcopyright1->getSortIcon('copyright.website1'); ?>"> <a href="<?php echo $tso_listcopyright1->getSortLink('copyright.website1'); ?>">Website1</a> </th>
            <th id="website2" class="KT_sorter KT_col_website2 <?php echo $tso_listcopyright1->getSortIcon('copyright.website2'); ?>"> <a href="<?php echo $tso_listcopyright1->getSortLink('copyright.website2'); ?>">Website2</a> </th>
            <th id="website3" class="KT_sorter KT_col_website3 <?php echo $tso_listcopyright1->getSortIcon('copyright.website3'); ?>"> <a href="<?php echo $tso_listcopyright1->getSortLink('copyright.website3'); ?>">Website3</a> </th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listcopyright1'] == 1) {
?>
            <tr class="KT_row_filter">
              <td>&nbsp;</td>
              <td><input type="text" name="tfi_listcopyright1_tenwebsite" id="tfi_listcopyright1_tenwebsite" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listcopyright1_tenwebsite']); ?>" size="20" maxlength="255" /></td>
              <td><input type="text" name="tfi_listcopyright1_logo" id="tfi_listcopyright1_logo" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listcopyright1_logo']); ?>" size="20" maxlength="45" /></td>
              <td><input type="text" name="tfi_listcopyright1_dienthoai" id="tfi_listcopyright1_dienthoai" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listcopyright1_dienthoai']); ?>" size="20" maxlength="45" /></td>
              <td><input type="text" name="tfi_listcopyright1_email" id="tfi_listcopyright1_email" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listcopyright1_email']); ?>" size="20" maxlength="100" /></td>
              <td><input type="text" name="tfi_listcopyright1_website1" id="tfi_listcopyright1_website1" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listcopyright1_website1']); ?>" size="20" maxlength="145" /></td>
              <td><input type="text" name="tfi_listcopyright1_website2" id="tfi_listcopyright1_website2" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listcopyright1_website2']); ?>" size="20" maxlength="145" /></td>
              <td><input type="text" name="tfi_listcopyright1_website3" id="tfi_listcopyright1_website3" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listcopyright1_website3']); ?>" size="20" maxlength="145" /></td>
              <td><input type="submit" name="tfi_listcopyright1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
            </tr>
            <?php } 
  // endif Conditional region3
?>
        </thead>
        <tbody>
          <?php if ($totalRows_rscopyright1 == 0) { // Show if recordset empty ?>
            <tr>
              <td colspan="9"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
            </tr>
            <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rscopyright1 > 0) { // Show if recordset not empty ?>
            <?php do { ?>
              <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                <td><input type="checkbox" name="kt_pk_copyright" class="id_checkbox" value="<?php echo $row_rscopyright1['ID_copyright']; ?>" />
                    <input type="hidden" name="ID_copyright" class="id_field" value="<?php echo $row_rscopyright1['ID_copyright']; ?>" />
                </td>
                <td><div class="KT_col_tenwebsite"><?php echo KT_FormatForList($row_rscopyright1['tenwebsite'], 200); ?></div></td>
                <td><?php 
// Show If File Exists (region4)
if (tNG_fileExists("../images/", "{rscopyright1.logo}")) {
?>
                    <img src="<?php echo $objDynamicThumb1->Execute(); ?>" border="0" />
                    <?php } 
// EndIf File Exists (region4)
?></td>
                <td><div class="KT_col_dienthoai"><?php echo KT_FormatForList($row_rscopyright1['dienthoai'], 20); ?></div></td>
                <td><div class="KT_col_email"><?php echo KT_FormatForList($row_rscopyright1['email'], 20); ?></div></td>
                <td><div class="KT_col_website1"><?php echo KT_FormatForList($row_rscopyright1['website1'], 200); ?></div></td>
                <td><div class="KT_col_website2"><?php echo KT_FormatForList($row_rscopyright1['website2'], 200); ?></div></td>
                <td><div class="KT_col_website3"><?php echo KT_FormatForList($row_rscopyright1['website3'], 200); ?></div></td>
                <td><a class="KT_edit_link" href="admincp.php?vietchuyen=form_copyright&amp;ID_copyright=<?php echo $row_rscopyright1['ID_copyright']; ?>&amp;KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a> <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a> </td>
              </tr>
              <?php } while ($row_rscopyright1 = mysql_fetch_assoc($rscopyright1)); ?>
            <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listcopyright1->Prepare();
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
        <a class="KT_additem_op_link" href="admincp.php?vietchuyen=form_copyright&amp;KT_back=1" onclick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a> </div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>
</body>
</html>
<?php
mysql_free_result($rscopyright1);
?>
