<?php require_once('Connections/conn_vietchuyen.php'); ?>
<?php require_once('vietdecode.php'); ?>
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

mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_gameonline = "SELECT ID_game, tengame, hinhgame, hot, ID_theloaigame FROM game WHERE kiemduyet = 1 ORDER BY ngaycapnhat DESC LIMIT 0,4";
$rs_gameonline = mysql_query($query_rs_gameonline, $conn_vietchuyen) or die(mysql_error());
$row_rs_gameonline = mysql_fetch_assoc($rs_gameonline);
$totalRows_rs_gameonline = mysql_num_rows($rs_gameonline);

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
?>

<link href="<?=$url?>includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="<?=$url?>includes/common/js/base.js" type="text/javascript"></script>
<script src="<?=$url?>includes/common/js/utility.js" type="text/javascript"></script>
<script src="<?=$url?>includes/skins/style.js" type="text/javascript"></script>
	<section class="gameonline">
    	<header class="gameonline_title">
        	<span class="bg_gameonline">GAME ONLINE</span>        </header>
        <?php 
			$dem = 0;
			do { 
				$dem++;
		?>
          <article class="<?=($dem % 4 == 0) ? "box_game_last" : "box_game";?>">
            <!--<a href="layout_gameonline.php?cat=<?php echo $row_rs_gameonline['ID_theloaigame']; ?>&id=<?php echo $row_rs_gameonline['ID_game']; ?>">-->
            	<a href="<?=$url?>gamecat<?=$row_rs_gameonline['ID_theloaigame'];?>/game<?=$row_rs_gameonline['ID_game'];?>/<?=vietdecode($row_rs_gameonline['tengame']);?>.html">
            	<img src="<?=$url?>game/hinhgame/<?php echo $row_rs_gameonline['hinhgame']; ?>" 
             	width="150px" height="auto" alt="<?php echo $row_rs_gameonline['tengame']; ?>"></a>
            <h5>
            	<span class="linkden">
                		<a href="<?=$url?>gamecat<?=$row_rs_gameonline['ID_theloaigame'];?>/game<?=$row_rs_gameonline['ID_game'];?>/<?=vietdecode($row_rs_gameonline['tengame']);?>.html"><?php echo $row_rs_gameonline['tengame']; ?></a>
<!--                    <a href="layout_gameonline.php?cat=<?php echo $row_rs_gameonline['ID_theloaigame']; ?>&id=<?php echo $row_rs_gameonline['ID_game']; ?>"><?php echo $row_rs_gameonline['tengame']; ?></a>
-->                </span>
            </h5>
          </article>
          <?php } while ($row_rs_gameonline = mysql_fetch_assoc($rs_gameonline)); ?>
    </section>
<?php
mysql_free_result($rs_gameonline);
?>
