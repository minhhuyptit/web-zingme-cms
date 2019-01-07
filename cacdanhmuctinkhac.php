<?php require_once('Connections/conn_vietchuyen.php'); ?>
<?php require_once('vietdecode.php'); ?>
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

$colname1_rs_cacdanhmuctinkhac = "6";
if (isset($_GET['cat'])) {
  $colname1_rs_cacdanhmuctinkhac = $_GET['cat'];
}
mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_cacdanhmuctinkhac = sprintf("SELECT ID_theloai, keyword, tentheloai, rand() AS songaunhien FROM theloai WHERE linkngoai = 0 AND ID_theloai != %s ORDER BY songaunhien ASC LIMIT 0,3", GetSQLValueString($colname1_rs_cacdanhmuctinkhac, "int"));
$rs_cacdanhmuctinkhac = mysql_query($query_rs_cacdanhmuctinkhac, $conn_vietchuyen) or die(mysql_error());
$row_rs_cacdanhmuctinkhac = mysql_fetch_assoc($rs_cacdanhmuctinkhac);
$totalRows_rs_cacdanhmuctinkhac = mysql_num_rows($rs_cacdanhmuctinkhac);

mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_tintuc_detail = "SELECT ID_tintuc, tieudetin, hinhtrichdan, ID_theloai, cohinh, cophim FROM tintuc WHERE ID_theloai = 123456789 AND kiemduyet=1 ORDER BY ngaycapnhat DESC LIMIT  0,5";
$rs_tintuc_detail = mysql_query($query_rs_tintuc_detail, $conn_vietchuyen) or die(mysql_error());
$row_rs_tintuc_detail = mysql_fetch_assoc($rs_tintuc_detail);
$totalRows_rs_tintuc_detail = mysql_num_rows($rs_tintuc_detail);

// Show Dynamic Thumbnail
$objDynamicThumb1 = new tNG_DynamicThumbnail("", "KT_thumbnail1");
$objDynamicThumb1->setFolder("images/");
$objDynamicThumb1->setRenameRule("{rs_tintuc_detail.hinhtrichdan}");
$objDynamicThumb1->setResize(80, 60, false);
$objDynamicThumb1->setWatermark(false);
?>
	<?php 
		$dem = 0;
		do { 
		$dem++;
	?>
	  <section class="<?=($dem % 3 == 0) ? "cacdanhmuckhac_last":"cacdanhmuckhac";?>">
	    <header class="cacdanhmuckhac_title">
        	<span class="linkcam">
        		<!--<a href="layout_theloai.php?cat=<?php echo $row_rs_cacdanhmuctinkhac['ID_theloai']; ?>"><?php echo $row_rs_cacdanhmuctinkhac['tentheloai']; ?></a>-->
                <a href="<?=$url?><?php echo $row_rs_cacdanhmuctinkhac['keyword']; ?>.html"><?php echo $row_rs_cacdanhmuctinkhac['tentheloai']; ?></a>
                
           	</span>
        </header>
	    <?php
  if ($totalRows_rs_cacdanhmuctinkhac>0) {
    $nested_query_rs_tintuc_detail = str_replace("123456789", $row_rs_cacdanhmuctinkhac['ID_theloai'], $query_rs_tintuc_detail);
    mysql_select_db($database_conn_vietchuyen);
    $rs_tintuc_detail = mysql_query($nested_query_rs_tintuc_detail, $conn_vietchuyen) or die(mysql_error());
    $row_rs_tintuc_detail = mysql_fetch_assoc($rs_tintuc_detail);
    $totalRows_rs_tintuc_detail = mysql_num_rows($rs_tintuc_detail);
    $nested_sw = false;
    if (isset($row_rs_tintuc_detail) && is_array($row_rs_tintuc_detail)) {
    $dem1 = 0;  
	do { //Nested repeat
	$dem1++;
?>
        <article class="<?=($dem1 % 5 == 0) ? "cacdanhmuckhac_baiviet_last" : "cacdanhmuckhac_baiviet";?>">
        	<?php if($dem1 == 1){ ?>
            		<a href="<?=$url?>cat<?=$row_rs_tintuc_detail['ID_theloai'];?>/detail<?=$row_rs_tintuc_detail['ID_tintuc'];?>/<?=vietdecode($row_rs_tintuc_detail['tieudetin']);?>.html"><img class="canhlechohinh" border="0" src="<?=$url?><?php echo $objDynamicThumb1->Execute(); ?>"></a>
            	<!--<a href="layout_chitiettin.php?cat=<?php echo $row_rs_tintuc_detail['ID_theloai']; ?>&id=<?php echo $row_rs_tintuc_detail['ID_tintuc']; ?>"><img class="canhlechohinh" border="0" src="<?=$url?><?php echo $objDynamicThumb1->Execute(); ?>"></a>-->
            <?php } ?>
            	<span class="linkden">
                		<a href="<?=$url?>cat<?=$row_rs_tintuc_detail['ID_theloai'];?>/detail<?=$row_rs_tintuc_detail['ID_tintuc'];?>/<?=vietdecode($row_rs_tintuc_detail['tieudetin']);?>.html"><?php echo $row_rs_tintuc_detail['tieudetin']; ?></a>
                	<!--<a href="layout_chitiettin.php?cat=<?php echo $row_rs_tintuc_detail['ID_theloai']; ?>&id=<?php echo $row_rs_tintuc_detail['ID_tintuc']; ?>"><?php echo $row_rs_tintuc_detail['tieudetin']; ?></a>-->        
                </span>
        </article>
	      <?php
      } while ($row_rs_tintuc_detail = mysql_fetch_assoc($rs_tintuc_detail)); //Nested move next
    }
  }
?>
	  </section>
	  <?php } while ($row_rs_cacdanhmuctinkhac = mysql_fetch_assoc($rs_cacdanhmuctinkhac)); ?>
<?php
mysql_free_result($rs_cacdanhmuctinkhac);

mysql_free_result($rs_tintuc_detail);
?>
