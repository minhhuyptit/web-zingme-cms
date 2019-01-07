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
$query_rs_facebook = "SELECT * FROM facebook WHERE visible = 1";
$rs_facebook = mysql_query($query_rs_facebook, $conn_vietchuyen) or die(mysql_error());
$row_rs_facebook = mysql_fetch_assoc($rs_facebook);
$totalRows_rs_facebook = mysql_num_rows($rs_facebook);

?>
<section class="facebook">
<div id="fb-root"></div>
		<script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v3.0';
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
        
        <div class="fb-page" data-href="<?php echo $row_rs_facebook['facebookurl']; ?>" data-tabs="timeline" data-width="<?php echo $row_rs_facebook['width']; ?>" data-height="<?php echo $row_rs_facebook['height']; ?>" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="<?php echo $row_rs_facebook['showface']; ?>"><blockquote cite="<?php echo $row_rs_facebook['facebookurl']; ?>" class="fb-xfbml-parse-ignore"><a href="<?php echo $row_rs_facebook['facebookurl']; ?>">English learning and sharing</a></blockquote></div>
</section>
<?php
mysql_free_result($rs_facebook);
?>
