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
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>vietchuyen.edu.vn</title>
</head>

<body>
<img src="banner1.jpg" width="600" height="80">
</body>
</html>
