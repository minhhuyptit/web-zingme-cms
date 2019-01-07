<?php require_once('../Connections/conn_vietchuyen.php'); ?>
<?php
// Require the MXI classes
require_once ('../includes/mxi/MXI.php');

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

// Include Multiple Static Pages
$mxiObj = new MXI_Includes("vietchuyen");
$mxiObj->IncludeStatic("", "admin_default.php", "", "", "");
$mxiObj->IncludeStatic("list_theloai", "list_theloai.php", "", "", "");
$mxiObj->IncludeStatic("list_theloaitin", "list_theloaitin.php", "", "", "");
$mxiObj->IncludeStatic("list_nhomtin", "list_nhomtin.php", "", "", "");
$mxiObj->IncludeStatic("list_phanloaitin", "list_phanloaitin.php", "", "", "");
$mxiObj->IncludeStatic("list_tintuc", "list_tintuc.php", "", "", "");
$mxiObj->IncludeStatic("list_quangcao", "list_quangcao.php", "", "", "");
$mxiObj->IncludeStatic("list_videoclip", "list_videoclip.php", "", "", "");
$mxiObj->IncludeStatic("list_thanhvien", "list_thanhvien.php", "", "", "");
$mxiObj->IncludeStatic("list_nghenghiep", "list_nghenghiep.php", "", "", "");
$mxiObj->IncludeStatic("list_quequan", "list_quequan.php", "", "", "");
$mxiObj->IncludeStatic("list_theloaigame", "list_theloaigame.php", "", "", "");
$mxiObj->IncludeStatic("list_game", "list_game.php", "", "", "");
$mxiObj->IncludeStatic("form_theloai", "form_theloai.php", "", "", "");
$mxiObj->IncludeStatic("form_theloaitin", "form_theloaitin.php", "", "", "");
$mxiObj->IncludeStatic("form_nhomtin", "form_nhomtin.php", "", "", "");
$mxiObj->IncludeStatic("form_phanloaitin", "form_phanloaitin.php", "", "", "");
$mxiObj->IncludeStatic("form_tintuc", "form_tintuc.php", "", "", "");
$mxiObj->IncludeStatic("form_quangcao", "form_quangcao.php", "", "", "");
$mxiObj->IncludeStatic("form_videoclip", "form_videoclip.php", "", "", "");
$mxiObj->IncludeStatic("form_thanhvien", "form_thanhvien.php", "", "", "");
$mxiObj->IncludeStatic("form_nghenghiep", "form_nghenghiep.php", "", "", "");
$mxiObj->IncludeStatic("form_quequan", "form_quequan.php", "", "", "");
$mxiObj->IncludeStatic("form_theloaigame", "form_theloaigame.php", "", "", "");
$mxiObj->IncludeStatic("form_game", "form_game.php", "", "", "");
$mxiObj->IncludeStatic("list_copyright", "list_copyright.php", "", "", "");
$mxiObj->IncludeStatic("form_copyright", "form_copyright.php", "", "", "");
// End Include Multiple Static Pages
?>
<!DOCTYPE html>
<html>
<head>
<meta  charset="utf-8" />
<title><?php echo $mxiObj->getTitle(); ?></title>
<link href="admin.css" rel="stylesheet" type="text/css">
<meta name="keywords" content="<?php echo $mxiObj->getKeywords(); ?>" />
<meta name="description" content="<?php echo $mxiObj->getDescription(); ?>" />
<base href="<?php echo mxi_getBaseURL(); ?>" />
</head>

<body>
<div class="wrapper">
  <div class="banner">
    <?php
	  mxi_includes_start("admin_banner.php");
	  require(basename("admin_banner.php"));
	  mxi_includes_end();
	?>
 </div>
          <div class="menuchinh">
            <?php
			  mxi_includes_start("admin_menu.php");
			  require(basename("admin_menu.php"));
			  mxi_includes_end();
			?>
		  </div>
          <div class="clear"></div>
          <div class="content">
            <?php
			  $incFileName = $mxiObj->getCurrentInclude();
  if ($incFileName !== null)  {
    mxi_includes_start($incFileName);
    require(basename($incFileName)); // require the page content
    mxi_includes_end();
}
			?>
          </div>
   <div class="clear"></div>
	<div class="footer">
      <?php
		  mxi_includes_start("admin_footer.php");
		  require(basename("admin_footer.php"));
		  mxi_includes_end();
	  ?>
</div>
</div>
</body>
</html>
