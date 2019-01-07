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

$KTColParam1_rs_seo_tieudebaiviet = "2";
if (isset($_GET["id"])) {
  $KTColParam1_rs_seo_tieudebaiviet = $_GET["id"];
}
mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_seo_tieudebaiviet = sprintf("SELECT theloai.ID_theloai, theloai.tentheloai, tintuc.ID_tintuc, tintuc.tieudetin, theloaitin.ID_theloaitin, theloaitin.tentheloaitin FROM ((tintuc LEFT JOIN theloai ON theloai.ID_theloai=tintuc.ID_theloai) LEFT JOIN theloaitin ON theloaitin.ID_theloaitin=tintuc.ID_theloaitin) WHERE tintuc.ID_tintuc=%s ", GetSQLValueString($KTColParam1_rs_seo_tieudebaiviet, "int"));
$rs_seo_tieudebaiviet = mysql_query($query_rs_seo_tieudebaiviet, $conn_vietchuyen) or die(mysql_error());
$row_rs_seo_tieudebaiviet = mysql_fetch_assoc($rs_seo_tieudebaiviet);
$totalRows_rs_seo_tieudebaiviet = mysql_num_rows($rs_seo_tieudebaiviet);

mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_seo = "SELECT motawebsite, tukhoaseo FROM copyright";
$rs_seo = mysql_query($query_rs_seo, $conn_vietchuyen) or die(mysql_error());
$row_rs_seo = mysql_fetch_assoc($rs_seo);
$totalRows_rs_seo = mysql_num_rows($rs_seo);

mysql_free_result($rs_seo_tieudebaiviet);

mysql_free_result($rs_seo);
?>
<title><?php echo $row_rs_seo_tieudebaiviet['tieudetin']; ?></title>
<meta name="description" content="<?php echo $row_rs_seo['motawebsite']; ?>">
<meta name="keywords" content="<?php echo $row_rs_seo['tukhoaseo']; ?>">