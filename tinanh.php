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

mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_tinanh = "SELECT ID_tintuc, tieudetin, hinhtrichdan, trichdantin, ID_theloai FROM tintuc WHERE ID_phanloaitin = 3 AND kiemduyet=1 ORDER BY ngaycapnhat DESC LIMIT 0,5";
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
	       <header class="tinanh_title">TIN ẢNH ĐẸP</header>
		<!-- fullwidth slider -->
		<div class="grid_12">
			
			<div id="fullwidth_slider" class="everslider fullwidth-slider">
				<ul class="es-slides">
					<?php do { ?>
					  <li> 
                      		<a href="<?=$url?>cat<?=$row_rs_tinanh['ID_theloai'];?>/detail<?=$row_rs_tinanh['ID_tintuc'];?>/<?=vietdecode($row_rs_tinanh['tieudetin']);?>.html"><img src="<?php echo $objDynamicThumb1->Execute(); ?>" border="0" alt="<?php echo $row_rs_tinanh['tieudetin']; ?>" /></a>
					    <!--<a href="layout_chitiettin.php?cat=<?php echo $row_rs_tinanh['ID_theloai']; ?>&id=<?php echo $row_rs_tinanh['ID_tintuc']; ?>"><img src="<?php echo $objDynamicThumb1->Execute(); ?>" border="0" alt="<?php echo $row_rs_tinanh['tieudetin']; ?>" /></a>-->
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