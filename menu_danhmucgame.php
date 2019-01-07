<?php require_once('Connections/conn_vietchuyen.php'); ?>
<?php require_once('vietdecode.php'); ?>
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
$query_rs_master_theloai = "SELECT ID_theloaigame, tentheloaigame FROM theloaigame WHERE visiblemenu = 1 ORDER BY sapxep ASC";
$rs_master_theloai = mysql_query($query_rs_master_theloai, $conn_vietchuyen) or die(mysql_error());
$row_rs_master_theloai = mysql_fetch_assoc($rs_master_theloai);
$totalRows_rs_master_theloai = mysql_num_rows($rs_master_theloai);
?>
<nav class="container">
  <div class="nav emerald-black">
    <ul class="dropdown clear">
      <li><a href="<?=$url?>index.html"><i class="icon-home"></i></a></li>
      <?php do {  ?>
        <li> 
        		<a href="<?=$url?>gamecat<?=$row_rs_master_theloai['ID_theloaigame'];?>/<?=vietdecode($row_rs_master_theloai['tentheloaigame']);?>.html"><?php echo $row_rs_master_theloai['tentheloaigame']; ?></a>
        	<!--<a href="layout_danhmucgameonline.php?cat=<?php echo $row_rs_master_theloai['ID_theloaigame']; ?>"><?php echo $row_rs_master_theloai['tentheloaigame']; ?></a>-->
        </li>
        <?php } while ($row_rs_master_theloai = mysql_fetch_assoc($rs_master_theloai)); ?>
    </ul>
  </div>
  <!-- End #nav Section -->
</nav>
<?php
mysql_free_result($rs_master_theloai);
?>
