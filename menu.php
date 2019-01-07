<?php require_once('Connections/conn_vietchuyen.php'); ?>
<?php require_once('vietdecode.php'); ?>
<?php
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
$query_rs_master_theloai = "SELECT ID_theloai, tentheloai, url, target, linkngoai, keyword FROM theloai WHERE visiblemenu1 = 1 ORDER BY sapxep ASC";
$rs_master_theloai = mysql_query($query_rs_master_theloai, $conn_vietchuyen) or die(mysql_error());
$row_rs_master_theloai = mysql_fetch_assoc($rs_master_theloai);
$totalRows_rs_master_theloai = mysql_num_rows($rs_master_theloai);

mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_detail_theloaitin = "SELECT ID_theloaitin, keyseo, tentheloaitin, url, target, linkngoai, ID_theloai FROM theloaitin WHERE ID_theloai = 123456789 AND visiblemenu2 = 1 ORDER BY sapxep ASC";
$rs_detail_theloaitin = mysql_query($query_rs_detail_theloaitin, $conn_vietchuyen) or die(mysql_error());
$row_rs_detail_theloaitin = mysql_fetch_assoc($rs_detail_theloaitin);
$totalRows_rs_detail_theloaitin = mysql_num_rows($rs_detail_theloaitin);
?>
<nav class="container">
  <div class="nav emerald-black">
    <ul class="dropdown clear">
      <li><a href="<?=$url?>index.html"><i class="icon-home"></i></a></li>
      <?php 
	  	$count = 0;
	  	do { 
		$count++;
	  ?>
        <li <?php if($count == $totalRows_rs_master_theloai-1){echo 'class=rtl';}?>>
        <?php if($row_rs_master_theloai['linkngoai'] == 1){ ?>
        <a href="<?php echo $row_rs_master_theloai['url']; ?>" target="<?php echo $row_rs_master_theloai['target']; ?>"><?php echo $row_rs_master_theloai['tentheloai']; ?></a>
        <?php }else{ ?>
        <!--<a href="layout_theloai.php?cat=<?php echo $row_rs_master_theloai['ID_theloai']; ?>"><?php echo $row_rs_master_theloai['tentheloai']; ?></a>-->
        <a href="<?=$url?><?php echo $row_rs_master_theloai['keyword']; ?>.html">
			<?php echo $row_rs_master_theloai['tentheloai']; ?>
        </a>
        <?php } ?>
          <ul>
            <?php
  if ($totalRows_rs_master_theloai>0) {
    $nested_query_rs_detail_theloaitin = str_replace("123456789", $row_rs_master_theloai['ID_theloai'], $query_rs_detail_theloaitin);
    mysql_select_db($database_conn_vietchuyen);
    $rs_detail_theloaitin = mysql_query($nested_query_rs_detail_theloaitin, $conn_vietchuyen) or die(mysql_error());
    $row_rs_detail_theloaitin = mysql_fetch_assoc($rs_detail_theloaitin);
    $totalRows_rs_detail_theloaitin = mysql_num_rows($rs_detail_theloaitin);
    $nested_sw = false;
    if (isset($row_rs_detail_theloaitin) && is_array($row_rs_detail_theloaitin)) {
      do { //Nested repeat
?>
              <li>
              	<!--<a href="layout_theloaitin.php?cat=<?php echo $row_rs_detail_theloaitin['ID_theloai']; ?>&subcat=<?php echo $row_rs_detail_theloaitin['ID_theloaitin']; ?>"><?php echo $row_rs_detail_theloaitin['tentheloaitin']; ?></a>-->
                
                <a href="<?=$url?><?php echo $row_rs_master_theloai['keyword']; ?>/<?php echo $row_rs_detail_theloaitin['keyseo']; ?>.html"><?php echo $row_rs_detail_theloaitin['tentheloaitin']; ?></a>
             </li>           
              <?php
      } while ($row_rs_detail_theloaitin = mysql_fetch_assoc($rs_detail_theloaitin)); //Nested move next
    }
  }
?>
          </ul>
            </li>
        <?php } while ($row_rs_master_theloai = mysql_fetch_assoc($rs_master_theloai)); ?></ul>
  </div>
  <!-- End #nav Section -->
</nav>
<?php
mysql_free_result($rs_master_theloai);

mysql_free_result($rs_detail_theloaitin);
?>
