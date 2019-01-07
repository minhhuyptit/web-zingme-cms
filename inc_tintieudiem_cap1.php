<?php require_once('Connections/conn_vietchuyen.php'); ?>
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

$KTColParam1_rs_tintieudiem = "The-gioi";
if (isset($_GET["keyword"])) {
  $KTColParam1_rs_tintieudiem = $_GET["keyword"];
}
mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_tintieudiem = sprintf("SELECT theloai.ID_theloai, theloai.tentheloai, theloai.keyword, tintuc.ID_tintuc, tintuc.tieudetin, tintuc.hinhtrichdan, tintuc.kiemduyet, tintuc.ngaycapnhat, tintuc.ID_phanloaitin FROM (tintuc LEFT JOIN theloai ON theloai.ID_theloai=tintuc.ID_theloai) WHERE theloai.keyword=%s  AND tintuc.kiemduyet=1  AND tintuc.ID_phanloaitin=1 ORDER BY tintuc.ngaycapnhat DESC  LIMIT 0,5", GetSQLValueString($KTColParam1_rs_tintieudiem, "text"));
$rs_tintieudiem = mysql_query($query_rs_tintieudiem, $conn_vietchuyen) or die(mysql_error());
$row_rs_tintieudiem = mysql_fetch_assoc($rs_tintieudiem);
$totalRows_rs_tintieudiem = mysql_num_rows($rs_tintieudiem);

// Show Dynamic Thumbnail
$objDynamicThumb1 = new tNG_DynamicThumbnail("", "KT_thumbnail1");
$objDynamicThumb1->setFolder("images/");
$objDynamicThumb1->setRenameRule("{rs_tintieudiem.hinhtrichdan}");
$objDynamicThumb1->setResize(100, 80, false);
$objDynamicThumb1->setWatermark(false);
?>
<?php if ($totalRows_rs_tintieudiem > 0) { // Show if recordset not empty ?>
  <section class="tintieudiem">
    <header class="tintieudiem_title">Tiêu điểm</header>
    <?php 
		$count = 0;
		do { 
		$count++;
		?>
    <article class="<?=($count == $totalRows_rs_tintieudiem) ? "tintieudiem_baiviet_cuoi":"tintieudiem_baiviet"?>"> 
    		<a href="<?=$url?>cat<?=$row_rs_tintieudiem['ID_theloai'];?>/detail<?=$row_rs_tintieudiem['ID_tintuc'];?>/<?=vietdecode($row_rs_tintieudiem['tieudetin']);?>.html">
    	<!--<a href="layout_chitiettin.php?cat=<?php echo $row_rs_tintieudiem['ID_theloai']; ?>&id=<?php echo $row_rs_tintieudiem['ID_tintuc']; ?>">-->
        	<img class="canhlechohinh" src="<?=$url?><?php echo $objDynamicThumb1->Execute(); ?>" border="0" alt="<?php echo $row_rs_tintieudiem['tieudetin']; ?>" />
        </a>
      <h1>
      	<span class="linkden">
        		<a href="<?=$url?>cat<?=$row_rs_tintieudiem['ID_theloai'];?>/detail<?=$row_rs_tintieudiem['ID_tintuc'];?>/<?=vietdecode($row_rs_tintieudiem['tieudetin']);?>.html"><?php echo $row_rs_tintieudiem['tieudetin']; ?></a>
       		<!--<a href="layout_chitiettin.php?cat=<?php echo $row_rs_tintieudiem['ID_theloai']; ?>&id=<?php echo $row_rs_tintieudiem['ID_tintuc']; ?>"><?php echo $row_rs_tintieudiem['tieudetin']; ?></a>-->
        </span>
      </h1>
      <p><?php echo date('G:i',strtotime($row_rs_tintieudiem['ngaycapnhat'])); ?> ngày <?php echo date('d/m/Y',strtotime($row_rs_tintieudiem['ngaycapnhat'])); ?></p>
                </article>
    <?php } while ($row_rs_tintieudiem = mysql_fetch_assoc($rs_tintieudiem)); ?> 
    </section>
  <?php } // Show if recordset not empty ?>
<?php
mysql_free_result($rs_tintieudiem);
?>
