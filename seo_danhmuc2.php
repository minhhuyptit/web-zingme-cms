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

$colname_rs_seo_danhmuc2 = "-1";
if (isset($_GET['keyseo'])) {
  $colname_rs_seo_danhmuc2 = $_GET['keyseo'];
}
mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_seo_danhmuc2 = sprintf("SELECT tentheloaitin FROM theloaitin WHERE keyseo = %s", GetSQLValueString($colname_rs_seo_danhmuc2, "text"));
$rs_seo_danhmuc2 = mysql_query($query_rs_seo_danhmuc2, $conn_vietchuyen) or die(mysql_error());
$row_rs_seo_danhmuc2 = mysql_fetch_assoc($rs_seo_danhmuc2);
$totalRows_rs_seo_danhmuc2 = mysql_num_rows($rs_seo_danhmuc2);

mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_seo = "SELECT motawebsite, tukhoaseo FROM copyright";
$rs_seo = mysql_query($query_rs_seo, $conn_vietchuyen) or die(mysql_error());
$row_rs_seo = mysql_fetch_assoc($rs_seo);
$totalRows_rs_seo = mysql_num_rows($rs_seo);
?>
<title><?php echo $row_rs_seo_danhmuc2['tentheloaitin']; ?></title>
<meta name="description" content="<?php echo $row_rs_seo['motawebsite']; ?>">
<meta name="keywords" content="<?php echo $row_rs_seo['tukhoaseo']; ?>">
<?php
mysql_free_result($rs_seo_danhmuc2);

mysql_free_result($rs_seo);
?>
