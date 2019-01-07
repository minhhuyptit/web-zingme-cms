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
?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>vietchuyen.edu.vn</title>
<link href="admin.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../ScriptLibrary/jquery-latest.pack.js"></script>
<script type="text/javascript" src="../ScriptLibrary/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="../ScriptLibrary/jquery.csstransform.pack.js"></script>
<script type="text/javascript">
<!--
function dmxRotate(context, angle, duration, easing, callback) {//v1.1
  var _css = { rotate : angle };
  if (duration) {
    jQuery(context).animate( _css, duration * 1000, easing, callback);
  } else {
    jQuery(context).css(_css);
  }
}
//-->
</script>
</head>

<body>
<div class="box_icon">
	<img src="category.png" width="128" height="128" onMouseOver="dmxRotate(this, '+=360', 0.5, 'easeInOutBack')"><span class="linkxanh"><a href="admincp.php?vietchuyen=list_theloai">Quản lý danh mục tin tức cấp 1</a></span></div>
<div class="box_icon">
	<img src="computer.png" width="128" height="128" onMouseOver="dmxRotate(this, '+=360', 0.5, 'easeInOutBack')"><span class="linkxanh"><a href="admincp.php?vietchuyen=list_theloaitin">Quản lý danh mục tin tức cấp 2</a></span></div>
<div class="box_icon">
	<img src="inventory_categories.png" width="128" height="128" onMouseOver="dmxRotate(this, '+=360', 0.5, 'easeInOutBack')"><span class="linkxanh"><a href="admincp.php?vietchuyen=list_nhomtin">Quản lý các chuyên đề tin tức</a></span></div>
<div class="box_icon">
	<img src="desktop.png" width="128" height="128" onMouseOver="dmxRotate(this, '+=360', 0.5, 'easeInOutBack')"><span class="linkxanh"><a href="admincp.php?vietchuyen=list_phanloaitin">Quản lý các phân loại tin tức</a></span></div>
<div class="box_icon">
	<img src="Location-News-icon.png" width="128" height="128" onMouseOver="dmxRotate(this, '+=360', 0.5, 'easeInOutBack')"><span class="linkxanh"><a href="admincp.php?vietchuyen=list_tintuc">Quản lý tin tức</a></span></div>
<div class="box_icon">
	<img src="advertisin.png" width="128" height="128" onMouseOver="dmxRotate(this, '+=360', 0.5, 'easeInOutBack')"><span class="linkxanh"><a href="admincp.php?vietchuyen=list_quangcao">Quản lý quảng cáo</a></span></div>
<div class="box_icon">
	<img src="video128.png" width="128" height="128" onMouseOver="dmxRotate(this, '+=360', 0.5, 'easeInOutBack')"><span class="linkxanh"><a href="admincp.php?vietchuyen=list_videoclip">Quản lý Videoclip</a></span></div>
<div class="box_icon">
	<img src="personal.png" width="128" height="128" onMouseOver="dmxRotate(this, '+=360', 0.5, 'easeInOutBack')"><span class="linkxanh"><a href="admincp.php?vietchuyen=list_thanhvien">Quản lý thành viên</a></span></div>
<div class="box_icon">
	<img src="services.png" width="128" height="128" onMouseOver="dmxRotate(this, '+=360', 0.5, 'easeInOutBack')"><span class="linkxanh"><a href="admincp.php?vietchuyen=list_nghenghiep">Quản lý nghề nghiệp</a></span></div>
<div class="box_icon">
	<img src="blog.png" width="128" height="128" onMouseOver="dmxRotate(this, '+=360', 0.5, 'easeInOutBack')"><span class="linkxanh"><a href="admincp.php?vietchuyen=list_quequan">Quản lý quê quán</a></span></div>
<div class="box_icon">
	<img src="statistics.png" width="128" height="128" onMouseOver="dmxRotate(this, '+=360', 0.5, 'easeInOutBack')"><span class="linkxanh"><a href="admincp.php?vietchuyen=list_theloaigame">Quản lý danh mục game</a></span></div>
<div class="box_icon">
	<img src="paleta.png" width="128" height="128" onMouseOver="dmxRotate(this, '+=360', 0.5, 'easeInOutBack')"><span class="linkxanh"><a href="admincp.php?vietchuyen=list_game">Quản lý game</a></span></div>
</body>
</html>
