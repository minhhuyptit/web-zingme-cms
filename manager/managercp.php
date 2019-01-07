<?php
// Require the MXI classes
require_once ('../includes/mxi/MXI.php');

// Include Multiple Static Pages
$mxiObj = new MXI_Includes("vietchuyen");
$mxiObj->IncludeStatic("", "admin_default.php", "", "", "");
$mxiObj->IncludeStatic("list_tintuc", "list_tintuc.php", "", "", "");
$mxiObj->IncludeStatic("form_tintuc", "form_tintuc.php", "", "", "");
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
