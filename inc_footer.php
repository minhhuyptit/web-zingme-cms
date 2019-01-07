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
$query_rs_copyright = "SELECT tenwebsite, diachi, dienthoai, email, website1, website2, website3 FROM copyright";
$rs_copyright = mysql_query($query_rs_copyright, $conn_vietchuyen) or die(mysql_error());
$row_rs_copyright = mysql_fetch_assoc($rs_copyright);
$totalRows_rs_copyright = mysql_num_rows($rs_copyright);
?><footer class="footer"> <span class="chudendam"><?php echo $row_rs_copyright['tenwebsite']; ?></span><br>
  Email: <span class="chudendam"><span class="linkden"><a href="mailto:<?php echo $row_rs_copyright['email']; ?>"><?php echo $row_rs_copyright['email']; ?></a></span></span><br>
  SDT: <span class="chudendam"><?php echo $row_rs_copyright['dienthoai']; ?></span><br>
  <span class="chudendam">2018 © <span class="linkden"><a href="https://news.zing.vn/" target="_blank">news.zing.vn</a></span></span> Cover by: <span class="chudendam"><span class="linkden"><a href="<?php echo $row_rs_copyright['website1']; ?>" target="_blank">Nguyễn Huy</a></span></span> </footer>
<?php
mysql_free_result($rs_copyright);
?>
