<?php
// Require the MXI classes
require_once ('includes/mxi/MXI.php');
?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>vietchuyen.edu.vn</title>
</head>
    
<body>
<?php
  mxi_includes_start("user_welcome.php");
  require(basename("user_welcome.php"));
  mxi_includes_end();
?>
<br>=============================================
<br>Đây là trang chủ.
</body>
</html>
