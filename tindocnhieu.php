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
$query_rs_tindocnhieu = "SELECT ID_tintuc, tieudetin, ID_theloai, ngaycapnhat FROM tintuc WHERE kiemduyet = 1 ORDER BY solandoc DESC, ngaycapnhat DESC LIMIT 0,5";
$rs_tindocnhieu = mysql_query($query_rs_tindocnhieu, $conn_vietchuyen) or die(mysql_error());
$row_rs_tindocnhieu = mysql_fetch_assoc($rs_tindocnhieu);
$totalRows_rs_tindocnhieu = mysql_num_rows($rs_tindocnhieu);
?>

<section class="tindocnhieu">
  <header class="tindocnhieu_title">ĐỌC NHIỀU NHẤT</header>
  <?php 
		$count = 0;
		do { ?>
    <article class="baiviet"> <span class="<?php echo ($count < 3) ? "sothutu":"sothutu_xanh"; ?>">
      <?=++$count?>
      </span>
      <h3>
      	<span class="linkden">
        		<a href="<?=$url?>cat<?=$row_rs_tindocnhieu['ID_theloai'];?>/detail<?=$row_rs_tindocnhieu['ID_tintuc'];?>/<?=vietdecode($row_rs_tindocnhieu['tieudetin']);?>.html"><?php echo $row_rs_tindocnhieu['tieudetin']; ?></a>
        	<!--<a href="layout_chitiettin.php?cat=<?php echo $row_rs_tindocnhieu['ID_theloai']; ?>&id=<?php echo $row_rs_tindocnhieu['ID_tintuc']; ?>"><?php echo $row_rs_tindocnhieu['tieudetin']; ?></a>-->
        </span>
      </h3>
      <p><?php echo date('G:i',strtotime($row_rs_tindocnhieu['ngaycapnhat'])); ?> ngày <?php echo date('d/m/Y',strtotime($row_rs_tindocnhieu['ngaycapnhat'])); ?> </p>
    </article>
    <?php } while ($row_rs_tindocnhieu = mysql_fetch_assoc($rs_tindocnhieu)); ?>
</section>
<?php
mysql_free_result($rs_tindocnhieu);
?>
