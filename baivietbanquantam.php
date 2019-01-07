<?php require_once('Connections/conn_vietchuyen.php'); ?>
<?php require_once("catchuoi.php"); ?>
<?php
// Load the tNG classes
require_once('includes/tng/tNG.inc.php');

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

$colname_rs_tinanh = "5";
if (isset($_GET['cat'])) {
  $colname_rs_tinanh = $_GET['cat'];
}
$colname2_rs_tinanh = "524";
if (isset($_GET['id'])) {
  $colname2_rs_tinanh = $_GET['id'];
}
mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_tinanh = sprintf("SELECT ID_tintuc, tieudetin, hinhtrichdan, ID_theloai, cohinh, cophim, trichdantin FROM tintuc WHERE ID_theloai = %s AND ID_tintuc != %s ORDER BY ngaycapnhat DESC LIMIT 0,9", GetSQLValueString($colname_rs_tinanh, "int"),GetSQLValueString($colname2_rs_tinanh, "int"));
$rs_tinanh = mysql_query($query_rs_tinanh, $conn_vietchuyen) or die(mysql_error());
$row_rs_tinanh = mysql_fetch_assoc($rs_tinanh);
$totalRows_rs_tinanh = mysql_num_rows($rs_tinanh);

// Show Dynamic Thumbnail
$objDynamicThumb1 = new tNG_DynamicThumbnail("", "KT_thumbnail1");
$objDynamicThumb1->setFolder("images/");
$objDynamicThumb1->setRenameRule("{rs_tinanh.hinhtrichdan}");
$objDynamicThumb1->setResize(300, 185, false);
$objDynamicThumb1->setWatermark(false);
?>
		
	    <section class="tinanh">
	       <header class="tinanh_title">Bạn có thể quan tâm</header>
		<!-- fullwidth slider -->
		<div class="grid_12">
			
			<div id="fullwidth_slider" class="everslider fullwidth-slider">
				<ul class="es-slides">
					<?php do { ?>
					  <li> 
                      <a href="<?=$url?>cat<?=$row_rs_tinanh['ID_theloai'];?>/detail<?=$row_rs_tinanh['ID_tintuc'];?>/<?=vietdecode($row_rs_tinanh['tieudetin']);?>.html"><img src="<?=$url?><?php echo $objDynamicThumb1->Execute(); ?>" border="0" alt="<?php echo $row_rs_tinanh['tieudetin']; ?>" /></a>
					    <!--<a href="layout_chitiettin.php?cat=<?php echo $row_rs_tinanh['ID_theloai']; ?>&id=<?php echo $row_rs_tinanh['ID_tintuc']; ?>"><img src="<?=$url?><?php echo $objDynamicThumb1->Execute(); ?>" border="0" alt="<?php echo $row_rs_tinanh['tieudetin']; ?>" /></a>-->
					    <div class="fullwidth-title">
                        	<a href="<?=$url?>cat<?=$row_rs_tinanh['ID_theloai'];?>/detail<?=$row_rs_tinanh['ID_tintuc'];?>/<?=vietdecode($row_rs_tinanh['tieudetin']);?>.html"><?php echo $row_rs_tinanh['tieudetin']; ?></a>
					      <!--<a href="layout_chitiettin.php?cat=<?php echo $row_rs_tinanh['ID_theloai']; ?>&id=<?php echo $row_rs_tinanh['ID_tintuc']; ?>"><?php echo $row_rs_tinanh['tieudetin']; ?></a>-->
					      <span><?php echo catchuoi($row_rs_tinanh['trichdantin'],120,1) ; ?></span>
                        </div>
				    </li>
					<?php } while ($row_rs_tinanh = mysql_fetch_assoc($rs_tinanh)); ?>
                </ul>
			</div>
		</div>
		<!-- fullwidth slider -->
	    </section>

<?php
mysql_free_result($rs_tinanh);
?>