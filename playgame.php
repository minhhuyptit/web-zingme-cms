<?php require_once('Connections/conn_vietchuyen.php'); ?>
<?php
// Load the common classes
require_once('includes/common/KT_common.php');

// Load the tNG classes
require_once('includes/tng/tNG.inc.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("");

// Make unified connection variable
$conn_conn_vietchuyen = new KT_connection($conn_vietchuyen, $database_conn_vietchuyen);

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

$colname_rs_playgame = "1";
if (isset($_GET['id'])) {
  $colname_rs_playgame = $_GET['id'];
}
mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_playgame = sprintf("SELECT ID_game, tengame, hinhgame, taptingame, trichdangame, noidunggame, solanchoi, solandownload, urlgame FROM game WHERE ID_game = %s", GetSQLValueString($colname_rs_playgame, "int"));
$rs_playgame = mysql_query($query_rs_playgame, $conn_vietchuyen) or die(mysql_error());
$row_rs_playgame = mysql_fetch_assoc($rs_playgame);
$totalRows_rs_playgame = mysql_num_rows($rs_playgame);

// Make a custom transaction instance
$customTransaction = new tNG_custom($conn_conn_vietchuyen);
$tNGs->addTransaction($customTransaction);
// Register triggers
$customTransaction->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "VALUE", "1");
// Set custom transaction SQL
$customTransaction->setSQL("UPDATE game SET solanchoi=solanchoi+1 WHERE ID_game={GET.id}");
// Add columns
// End of custom transaction instance

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rscustom = $tNGs->getRecordset("custom");
$row_rscustom = mysql_fetch_assoc($rscustom);
$totalRows_rscustom = mysql_num_rows($rscustom);

// Download File downloadObj1
$downloadObj1 = new tNG_Download("", "KT_download1");
$downloadObj1->setConnection($conn_conn_vietchuyen, "conn_vietchuyen");
// Download Counter
$downloadObj1->setTable("game");
$downloadObj1->setPrimaryKey("ID_game", "NUMERIC_TYPE", "{rs_playgame.ID_game}");
$downloadObj1->setCounterField("solandownload");
// Execute
$downloadObj1->setFolder("game/");
$downloadObj1->setRenameRule("{rs_playgame.taptingame}");
$downloadObj1->Execute();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Play game</title>
<script src="<?=$url?>Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<link href="<?=$url?>includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="<?=$url?>includes/common/js/base.js" type="text/javascript"></script>
<script src="<?=$url?>includes/common/js/utility.js" type="text/javascript"></script>
<script src="<?=$url?>includes/skins/style.js" type="text/javascript"></script>
</head>
<body>
<section class="playgame">
  <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" class="game">
        <param name="movie" value="<?=$url?>game/<?php echo $row_rs_playgame['taptingame']; ?>">
        <param name="quality" value="high">
    <embed src="<?=$url?>game/<?php echo $row_rs_playgame['taptingame']; ?>" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" class="game"></embed>
  </object>
  <h1><?php echo $row_rs_playgame['tengame']; ?></h1>
      <p class="chudam">Số lần chơi: <?php echo $row_rs_playgame['solanchoi']; ?></p>
      <p class="chudam">Số lần download: <?php echo $row_rs_playgame['solandownload']; ?></p>
      <p class="linkcam">
      	<a href="<?=$url?><?php echo $downloadObj1->getDownloadLink(); ?>">Tải game vế máy</a>
      </p>
</section>
</body>
</html>
<?php
mysql_free_result($rs_playgame);
?>
