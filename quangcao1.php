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
$query_rs_quangcao = "SELECT ID_quangcao, tieude, taptinquangcao, url, target, fileflash, rand() AS songaunhien FROM quangcao WHERE visible = 1 ORDER BY songaunhien ASC LIMIT 0,1";
$rs_quangcao = mysql_query($query_rs_quangcao, $conn_vietchuyen) or die(mysql_error());
$row_rs_quangcao = mysql_fetch_assoc($rs_quangcao);
$totalRows_rs_quangcao = mysql_num_rows($rs_quangcao);
?>
<?php do { ?>
  <?php 
// Show IF Conditional region1 
if (@$row_rs_quangcao['fileflash'] == 0) {
?>
	<section class="qc">
    <a href="<?php echo $row_rs_quangcao['url']; ?>" target="_blank"><img src="<?=$url?>images/quangcao/<?php echo $row_rs_quangcao['taptinquangcao']; ?>" width="300" height="250" border="0"></a> <br />
    </section>
    <?php 
// else Conditional region1
} else { ?>
	<section class="qc">
    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="300">
      <param name="movie" value="<?=$url?>images/quangcao/<?php echo $row_rs_quangcao['taptinquangcao']; ?>">
      <param name="quality" value="high">
      <embed src="<?=$url?>images/quangcao/<?php echo $row_rs_quangcao['taptinquangcao']; ?>" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="300"></embed>
      </object>
    </section>
    <br />
    <?php } 
// endif Conditional region1
?>
  <?php } while ($row_rs_quangcao = mysql_fetch_assoc($rs_quangcao)); ?>
<?php
mysql_free_result($rs_quangcao);
?>
