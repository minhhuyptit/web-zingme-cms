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
$query_rs_danhmuctin1_master = "SELECT ID_theloai, tentheloai, keyword FROM theloai WHERE linkngoai = 0 AND visiblemenu1 = 1 ORDER BY sapxep ASC";
$rs_danhmuctin1_master = mysql_query($query_rs_danhmuctin1_master, $conn_vietchuyen) or die(mysql_error());
$row_rs_danhmuctin1_master = mysql_fetch_assoc($rs_danhmuctin1_master);
$totalRows_rs_danhmuctin1_master = mysql_num_rows($rs_danhmuctin1_master);

mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_danhmuctin2_detail = "SELECT ID_theloaitin, keyseo, tentheloaitin, ID_theloai FROM theloaitin WHERE ID_theloai = 123456789 AND visiblemenu2 = 1 ORDER BY sapxep ASC";
$rs_danhmuctin2_detail = mysql_query($query_rs_danhmuctin2_detail, $conn_vietchuyen) or die(mysql_error());
$row_rs_danhmuctin2_detail = mysql_fetch_assoc($rs_danhmuctin2_detail);
$totalRows_rs_danhmuctin2_detail = mysql_num_rows($rs_danhmuctin2_detail);
?>
	<section class="sitemap">
      <?php
	  $count = 0; 
	  do { 
	  $count++;
	  ?>
      <section class="<?= ($count % 6 == 0) ? "sitemap_box_1":"sitemap_box"; ?>">
        <header class="linkcam"><a href="<?=$url?><?php echo $row_rs_danhmuctin1_master['keyword']; ?>.html"><?php echo $row_rs_danhmuctin1_master['tentheloai']; ?></a></header>
        <?php
  if ($totalRows_rs_danhmuctin1_master>0) {
    $nested_query_rs_danhmuctin2_detail = str_replace("123456789", $row_rs_danhmuctin1_master['ID_theloai'], $query_rs_danhmuctin2_detail);
    mysql_select_db($database_conn_vietchuyen);
    $rs_danhmuctin2_detail = mysql_query($nested_query_rs_danhmuctin2_detail, $conn_vietchuyen) or die(mysql_error());
    $row_rs_danhmuctin2_detail = mysql_fetch_assoc($rs_danhmuctin2_detail);
    $totalRows_rs_danhmuctin2_detail = mysql_num_rows($rs_danhmuctin2_detail);
    $nested_sw = false;
    if (isset($row_rs_danhmuctin2_detail) && is_array($row_rs_danhmuctin2_detail)) {
	  $dem = 0;
	  do {
	  if(++$dem > 4){
		  continue;
	  }
?>
        <p>
        	<span class="linkden">
        		<!--<a href="layout_theloaitin.php?cat=<?php echo $row_rs_danhmuctin2_detail['ID_theloai']; ?>&subcat=<?php echo $row_rs_danhmuctin2_detail['ID_theloaitin']; ?>"><?php echo $row_rs_danhmuctin2_detail['tentheloaitin']; ?></a>-->
                <a href="<?=$url?><?php echo $row_rs_danhmuctin1_master['keyword']; ?>/<?php echo $row_rs_danhmuctin2_detail['keyseo']; ?>.html"><?php echo $row_rs_danhmuctin2_detail['tentheloaitin']; ?></a>
        	</span></p>
        <?php
      } while ($row_rs_danhmuctin2_detail = mysql_fetch_assoc($rs_danhmuctin2_detail)); //Nested move next
    }
  }
?>
</section>
        <?php } while ($row_rs_danhmuctin1_master = mysql_fetch_assoc($rs_danhmuctin1_master)); ?>
  </section>
<?php
mysql_free_result($rs_danhmuctin1_master);

mysql_free_result($rs_danhmuctin2_detail);
?>
