<?php session_start(); ?>
<?php require_once('Connections/conn_vietchuyen.php'); ?>
<?php
// Load the tNG classes
require_once('includes/tng/tNG.inc.php');

// Make unified connection variable
$conn_conn_vietchuyen = new KT_connection($conn_vietchuyen, $database_conn_vietchuyen);
?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>User welcome</title>
</head>

<body>
<?php
//Show If User Is Logged In (region2)
$isLoggedIn1 = new tNG_UserLoggedIn($conn_conn_vietchuyen);
//Grand Levels: Level
$isLoggedIn1->addLevel("1");
$isLoggedIn1->addLevel("2");
$isLoggedIn1->addLevel("3");
if ($isLoggedIn1->Execute()) {
?>
  Chào mừng bạn <?php echo $_SESSION['kt_login_user']; ?> đã login. | <a href="user_profile.php">Thông tin cá nhân</a>
  <?php
//Show If User Is Logged In (region1)
$isLoggedIn = new tNG_UserLoggedIn($conn_conn_vietchuyen);
//Grand Levels: Level
$isLoggedIn->addLevel("1");
if ($isLoggedIn->Execute()) {
?>
    | <a href="admin/admincp.php">Trang quản lý</a>
  <?php
}
//End Show If User Is Logged In (region1)
?>
  | <a href="admin/logout.php?logout=1">Thoát</a>
  <?php
}
//End Show If User Is Logged In (region2)
?></body>
</html>
