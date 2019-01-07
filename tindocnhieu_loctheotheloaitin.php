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

$KTColParam1_rs_tindocnhieu = "The-gioi";
if (isset($_GET["keyword"])) {
  $KTColParam1_rs_tindocnhieu = $_GET["keyword"];
}
$KTColParam2_rs_tindocnhieu = "Phong-su";
if (isset($_GET["keyseo"])) {
  $KTColParam2_rs_tindocnhieu = $_GET["keyseo"];
}
mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_tindocnhieu = sprintf("SELECT theloai.ID_theloai, theloai.tentheloai, theloai.keyword, theloaitin.ID_theloaitin, theloaitin.tentheloaitin, theloaitin.keyseo, tintuc.ID_tintuc, tintuc.tieudetin, tintuc.solandoc, tintuc.kiemduyet, tintuc.ngaycapnhat FROM ((tintuc LEFT JOIN theloai ON theloai.ID_theloai=tintuc.ID_theloai) LEFT JOIN theloaitin ON theloaitin.ID_theloaitin=tintuc.ID_theloaitin) WHERE theloai.keyword=%s  AND theloaitin.keyseo=%s  AND tintuc.kiemduyet=1 ORDER BY tintuc.solandoc DESC, tintuc.ngaycapnhat DESC LIMIT 0,5", GetSQLValueString($KTColParam1_rs_tindocnhieu, "text"),GetSQLValueString($KTColParam2_rs_tindocnhieu, "text"));
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
        		<a href="<?=$url?>a<?=$row_rs_tindocnhieu['ID_theloai']; ?>/b<?=$row_rs_tindocnhieu['ID_theloaitin']; ?>/c<?=$row_rs_tindocnhieu['ID_tintuc']; ?>/<?=vietdecode($row_rs_tindocnhieu['tieudetin']);?>.html"><?php echo $row_rs_tindocnhieu['tieudetin']; ?></a>
        	<!--<a href="layout_chitiettin.php?cat=<?php echo $row_rs_tindocnhieu['ID_theloai']; ?>&subcat=<?php echo $row_rs_tindocnhieu['ID_theloaitin']; ?>&id=<?php echo $row_rs_tindocnhieu['ID_tintuc']; ?>"><?php echo $row_rs_tindocnhieu['tieudetin']; ?></a>-->
        </span>
      </h3>
      <p><?php echo date('G:i',strtotime($row_rs_tindocnhieu['ngaycapnhat'])); ?> ngày <?php echo date('d/m/Y',strtotime($row_rs_tindocnhieu['ngaycapnhat'])); ?> </p>
    </article>
    <?php } while ($row_rs_tindocnhieu = mysql_fetch_assoc($rs_tindocnhieu)); ?>
</section>
<?php
mysql_free_result($rs_tindocnhieu);
?>
