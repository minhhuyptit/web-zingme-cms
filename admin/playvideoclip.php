<?php require_once('../Connections/conn_vietchuyen.php'); ?>
<?php
// Load the tNG classes
require_once('../includes/tng/tNG.inc.php');

// Make unified connection variable
$conn_conn_vietchuyen = new KT_connection($conn_vietchuyen, $database_conn_vietchuyen);

//Start Restrict Access To Page
$restrict = new tNG_RestrictAccess($conn_conn_vietchuyen, "../");
//Grand Levels: Level
$restrict->addLevel("1");
$restrict->Execute();
//End Restrict Access To Page

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

$colname_rs_playvideoclip = "26";
if (isset($_GET['id'])) {
  $colname_rs_playvideoclip = $_GET['id'];
}
mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_playvideoclip = sprintf("SELECT ID_videoclip, tenvideoclip, hinhvideoclip, taptinvideoclip, youtube FROM videoclip WHERE ID_videoclip = %s", GetSQLValueString($colname_rs_playvideoclip, "int"));
$rs_playvideoclip = mysql_query($query_rs_playvideoclip, $conn_vietchuyen) or die(mysql_error());
$row_rs_playvideoclip = mysql_fetch_assoc($rs_playvideoclip);
$totalRows_rs_playvideoclip = mysql_num_rows($rs_playvideoclip);
?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>vietchuyen.edu.vn</title>
<script type="text/javascript" src="../jwplayer/jwplayer.js"></script>
</head>

<body>


<div id="myElement">Loading the player...</div>
<?php 
// Show IF Conditional region1 
	if (@$row_rs_playvideoclip['youtube'] != "") {
?>
  	<script type="text/javascript">
		jwplayer("myElement").setup({
			file: "<?php echo $row_rs_playvideoclip['youtube']; ?>",
			image: "../images/<?php echo $row_rs_playvideoclip['hinhvideoclip']; ?>",
			width: "300",
			height: "250",
			autostart: "true"
		});
	</script>
<?php 
	} else { 
?>	
  	<script type="text/javascript">
		jwplayer("myElement").setup({
			file: "../video/<?php echo $row_rs_playvideoclip['taptinvideoclip']; ?>",
			image: "../images/<?php echo $row_rs_playvideoclip['hinhvideoclip']; ?>",
			width: "300",
			height: "250",
			autostart: "true"
		});
	</script>
<?php } 
// endif Conditional region1
?>



</body>
</html>
<?php
mysql_free_result($rs_playvideoclip);
?>
