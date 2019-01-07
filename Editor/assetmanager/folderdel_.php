<?php require_once('../../Connections/conn_vietchuyen.php'); ?><?php
// Load the tNG classes
require_once('../../includes/tng/tNG.inc.php');

// Make unified connection variable
$conn_conn_vietchuyen = new KT_connection($conn_vietchuyen, $database_conn_vietchuyen);

//Start Restrict Access To Page
$restrict = new tNG_RestrictAccess($conn_conn_vietchuyen, "../../");
//Grand Levels: Level
$restrict->addLevel("1");
$restrict->Execute();
//End Restrict Access To Page

$sMsg = "";

if(isset($_POST["inpCurrFolder"]))
  {
  $sDestination = pathinfo($_POST["inpCurrFolder"]);

  //DELETE ALL FILES IF FOLDER NOT EMPTY
    $dir = $_POST["inpCurrFolder"];
    $handle = opendir($dir);
    while($file = readdir($handle)) if($file != "." && $file != "..") unlink($dir . "/" . $file);
    closedir($handle);

  if(rmdir($_POST["inpCurrFolder"])==0)
    $sMsg = "";
  else
    $sMsg = "<script>document.write(getTxt('Folder deleted.'))</script>";
  }
?>


<base target="_self">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script>
  var sLang=parent.oUtil.langDir;
  document.write("<scr"+"ipt src='language/"+sLang+"/folderdel_.js'></scr"+"ipt>");
</script>
<script>writeTitle()</script>
<script>
function refresh()
  {
    (opener?opener:openerWin).refreshAfterDelete(document.getElementById("inpDest").value);
  }
</script>
</head>
<body onLoad="loadTxt()" style="overflow:hidden;margin:0px;">

<table width=100% height=100% align=center style="" cellpadding=0 cellspacing=0 ID="Table1">
<tr>
<td valign=top style="padding-top:5px;padding-left:15px;padding-right:15px;padding-bottom:12px;height:100%">

  <br>
  <input type="hidden" ID="inpDest" NAME="inpDest" value="<?php echo $sDestination['dirname']; ?>">
  <div><b><?php echo $sMsg; ?>&nbsp;</b></div>

</td>
</tr>
<tr>
<td class="dialogFooter" align="right">
  <table cellpadding="1" cellspacing="0">
    <tr>
    <td>
      <input type="button" name="btnCloseAndRefresh" id="btnCloseAndRefresh" value="close & refresh" onClick="refresh();if(self.closeWin)self.closeWin();else self.close();" class="inpBtn" onMouseOver="this.className='inpBtnOver';" onMouseOut="this.className='inpBtnOut'">
    </td>
    </tr>
  </table>
</td>
</tr>
</table>


</body>
</html>