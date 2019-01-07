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

$KTColParam1_rs_chitiettin = "2";
if (isset($_GET["id"])) {
  $KTColParam1_rs_chitiettin = $_GET["id"];
}
mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_chitiettin = sprintf("SELECT tintuc.ID_tintuc, theloai.keyword, theloaitin.keyseo, tintuc.tieudetin, theloai.ID_theloai, theloai.tentheloai, theloaitin.ID_theloaitin, theloaitin.tentheloaitin, tintuc.solandoc, tintuc.ngaycapnhat, tintuc.trichdantin, tintuc.noidungtin FROM ((tintuc LEFT JOIN theloai ON theloai.ID_theloai=tintuc.ID_theloai) LEFT JOIN theloaitin ON theloaitin.ID_theloaitin=tintuc.ID_theloaitin) WHERE tintuc.ID_tintuc=%s ", GetSQLValueString($KTColParam1_rs_chitiettin, "int"));
$rs_chitiettin = mysql_query($query_rs_chitiettin, $conn_vietchuyen) or die(mysql_error());
$row_rs_chitiettin = mysql_fetch_assoc($rs_chitiettin);
$totalRows_rs_chitiettin = mysql_num_rows($rs_chitiettin);

// Make a custom transaction instance
$customTransaction = new tNG_custom($conn_conn_vietchuyen);
$tNGs->addTransaction($customTransaction);
// Register triggers
$customTransaction->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "VALUE", "1");
// Set custom transaction SQL
$customTransaction->setSQL("UPDATE tintuc SET solandoc=solandoc+1 WHERE ID_tintuc={GET.id}");
// Add columns
// End of custom transaction instance

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rscustom = $tNGs->getRecordset("custom");
$row_rscustom = mysql_fetch_assoc($rscustom);
$totalRows_rscustom = mysql_num_rows($rscustom);

?>
	<section class="chitietbaiviet">
    	<header class="chitietbaiviet_title">
        	<span class="linkcam">
            	<!--<a href="layout_theloai.php?cat=<?php echo $row_rs_chitiettin['ID_theloai']; ?>">
					<?=$row_rs_chitiettin['tentheloai'];?>	
                </a> -->  
                
                <a href="<?=$url?><?php echo $row_rs_chitiettin['keyword']; ?>.html">
					<?=$row_rs_chitiettin['tentheloai'];?>	
                </a> 
                         
            </span> | 
            <span class="linkden">
                <!--<a href="layout_theloaitin.php?cat=<?php echo $row_rs_chitiettin['ID_theloai']; ?>&subcat=<?php echo $row_rs_chitiettin['ID_theloaitin']; ?>">-->
                <a href="<?=$url?><?php echo $row_rs_chitiettin['keyword']; ?>/<?php echo $row_rs_chitiettin['keyseo']; ?>.html">
                <?php 
                    echo $row_rs_chitiettin['tentheloaitin']; 
                ?>
                </a>            </span>
            <span class="date-time">
				<?php 
                    echo "  (".date('G:i', strtotime($row_rs_chitiettin['ngaycapnhat'])); ?> ngày <?php echo date('d/m/Y', strtotime($row_rs_chitiettin['ngaycapnhat'])).")";
                ?>            </span>         | Xem (<?php echo $row_rs_chitiettin['solandoc']; ?>)</header>
        <article class="chitietbaiviet_content">
       	  	  <h1><?php echo $row_rs_chitiettin['tieudetin']; ?></h1>
            <p><?php echo $row_rs_chitiettin['trichdantin']; ?></p>
            <p><?php echo $row_rs_chitiettin['noidungtin']; ?></p>
        </article>
    </section>
<?php
mysql_free_result($rs_chitiettin);
?>
