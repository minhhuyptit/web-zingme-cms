<?php require_once('../Connections/conn_vietchuyen.php'); ?><?php
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
$query_rs_copyright = "SELECT tenwebsite, diachi, dienthoai, email, website1, website2, website3 FROM copyright";
$rs_copyright = mysql_query($query_rs_copyright, $conn_vietchuyen) or die(mysql_error());
$row_rs_copyright = mysql_fetch_assoc($rs_copyright);
$totalRows_rs_copyright = mysql_num_rows($rs_copyright);
?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>vietchuyen.edu.vn</title>
<link href="admin.css" rel="stylesheet" type="text/css">
</head>

<body>
<p><strong><?php echo $row_rs_copyright['tenwebsite']; ?></strong><br>
  Địa chỉ: <?php echo $row_rs_copyright['diachi']; ?><br>
  Email: <a href="mailto:<?php echo $row_rs_copyright['email']; ?>"><?php echo $row_rs_copyright['email']; ?></a><br>
  2018 Cover by: <a href="<?php echo $row_rs_copyright['website1']; ?>">Nguyễn Huy</a> <br>
  SDT: <strong><?php echo $row_rs_copyright['dienthoai']; ?></strong></p>
</body>
</html>
<?php
mysql_free_result($rs_copyright);
?>
