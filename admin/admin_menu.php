<?php require_once('../Connections/conn_vietchuyen.php'); ?><?php
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
?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>vietchuyen.edu.vn</title>
<link href="p7pmm/p7PMMh03.css" rel="stylesheet" type="text/css" media="all">
<script type="text/javascript" src="p7pmm/p7PMMscripts.js"></script>
</head>

<body>
<div id="p7PMM_1" class="p7PMMh03">
  <ul class="p7PMM">
    <li><a href="../index.php">Trang chủ</a></li>
  <li><a>Quản lý tin tức</a>
        <div>
          <ul>
            <li><a href="admincp.php?vietchuyen=list_theloai">Quản lý danh mục tin cấp 1</a></li>
            <li><a href="admincp.php?vietchuyen=list_theloaitin">Quản lý danh mục tin cấp 2</a></li>
            <li><a href="admincp.php?vietchuyen=list_nhomtin">Quản lý các chuyên đề tin</a></li>
            <li><a href="admincp.php?vietchuyen=list_phanloaitin">Quản lý phân loại tin</a></li>
            <li><a href="admincp.php?vietchuyen=list_tintuc">Quản lý các bài viết</a></li>
          </ul>
        </div>
    </li>
    <li><a>Quản lý khác</a>
        <div>
          <ul>
            <li><a href="admincp.php?vietchuyen=list_quangcao">Quản lý quảng cáo</a></li>
            <li><a href="admincp.php?vietchuyen=list_videoclip">Quản lý Videoclip</a></li>
            <li><a href="admincp.php?vietchuyen=list_theloaigame">Quản lý danh mục game</a></li>
            <li><a href="admincp.php?vietchuyen=list_game">Quản lý game</a></li>
          </ul>
        </div>
    </li>
    <li><a>Quản lý thành viên</a>
        <div>
          <ul>
            <li><a href="admincp.php?vietchuyen=list_quequan">Quản lý quê quán</a></li>
            <li><a href="admincp.php?vietchuyen=list_nghenghiep">Quản lý nghề nghiệp</a></li>
            <li><a href="admincp.php?vietchuyen=list_thanhvien">Quản lý thành viên</a></li>
          </ul>
        </div>
    </li>
   <li><a href="admincp.php?vietchuyen=list_copyright">Quản lý Copyright</a></li>
    <li><a href="admincp.php">Trang quản lý</a></li>
    <li><a href="logout.php?logout=1">Thoát ra</a></li>
  </ul>
  <div class="p7pmmclearfloat">&nbsp;</div>
  <!--[if lte IE 6]>
<style>.p7PMMh03 ul ul li {float:left; clear: both; width: 100%;}.p7PMMh03 {text-align: left;}.p7PMMh03 ul ul a {height: 1%;}</style>
<![endif]-->
  <!--[if IE 5.500]>
<style>.p7PMMh03 {position: relative; z-index: 9999999;}</style>
<![endif]-->
  <!--[if IE 7]>
<style>.p7PMMh03, .p7PMMh03 a{zoom:1;}.p7PMMh03 ul ul li{float:left;clear:both;width:100%;}</style>
<![endif]-->
  <script type="text/javascript">
<!--
P7_PMMop('p7PMM_1',1,4,-5,-5,0,0,0,0,2,3,1,1,0);
//-->
  </script>
</div>
</body>
</html>
