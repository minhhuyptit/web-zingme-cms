<?php require_once('Connections/conn_vietchuyen.php'); ?>
<?php
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
$query_rs_baianhvideo = "SELECT ID_tintuc, tieudetin, hinhtrichdan, ID_theloai, cohinh, cophim FROM tintuc WHERE kiemduyet = 1 ORDER BY ngaycapnhat DESC LIMIT 20,4";
$rs_baianhvideo = mysql_query($query_rs_baianhvideo, $conn_vietchuyen) or die(mysql_error());
$row_rs_baianhvideo = mysql_fetch_assoc($rs_baianhvideo);
$totalRows_rs_baianhvideo = mysql_num_rows($rs_baianhvideo);
?>
	<section class="baianhvideo">
    	<header class="baianhvideo_title">Bài ảnh & Video</header>
        <?php 
		$count = 0;
		do { 
		$count++;
		?>
          <article class="<?=($count % 4 == 0)?"box_baianhvideo_last":"box_baianhvideo";?>">
          		 <a href="<?=$url?>cat<?=$row_rs_baianhvideo['ID_theloai'];?>/detail<?=$row_rs_baianhvideo['ID_tintuc'];?>/<?=vietdecode($row_rs_baianhvideo['tieudetin']);?>.html">
           <!-- <a href="layout_chitiettin.php?cat=<?php echo $row_rs_baianhvideo['ID_theloai']; ?>&id=<?php echo $row_rs_baianhvideo['ID_tintuc']; ?>">-->
            	<img src="<?=$url?>images/<?php echo $row_rs_baianhvideo['hinhtrichdan']; ?>" width="160" height="120" alt="<?php echo $row_rs_baianhvideo['tieudetin']; ?>">
            </a>
            <h4>
            	<span class="linkden">
                		<a href="<?=$url?>cat<?=$row_rs_baianhvideo['ID_theloai'];?>/detail<?=$row_rs_baianhvideo['ID_tintuc'];?>/<?=vietdecode($row_rs_baianhvideo['tieudetin']);?>.html"><?php echo $row_rs_baianhvideo['tieudetin']; ?></a>
                	<!--<a href="layout_chitiettin.php?cat=<?php echo $row_rs_baianhvideo['ID_theloai']; ?>&id=<?php echo $row_rs_baianhvideo['ID_tintuc']; ?>"><?php echo $row_rs_baianhvideo['tieudetin']; ?></a>-->
                </span>
              <?php if ($row_rs_baianhvideo['cophim'] == 1) { ?>
						<img src="<?=$url?>images/video_icon.png">
			  <?php } ?>
				
              <?php if ($row_rs_baianhvideo['cohinh'] == 1) {?>
		                <img src="<?=$url?>images/camera_icon.png">
              <?php } ?> 
             </h4>  
      </article>
          <?php } while ($row_rs_baianhvideo = mysql_fetch_assoc($rs_baianhvideo)); ?>
    </section>
<?php
mysql_free_result($rs_baianhvideo);
?>
