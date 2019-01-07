<?php require_once('Connections/conn_vietchuyen.php'); ?>
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

$KTColParam1_rs_nhomtin = "Am-nhac";
if (isset($_GET["keyword"])) {
  $KTColParam1_rs_nhomtin = $_GET["keyword"];
}
$KTColParam2_rs_nhomtin = "K-pop";
if (isset($_GET["keyseo"])) {
  $KTColParam2_rs_nhomtin = $_GET["keyseo"];
}
mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_nhomtin = sprintf("SELECT theloai.ID_theloai, theloai.tentheloai, theloai.keyword, theloaitin.ID_theloaitin, theloaitin.tentheloaitin, theloaitin.keyseo, nhomtin.ID_nhomtin, nhomtin.tennhomtin, nhomtin.ngaycapnhat, nhomtin.visible FROM ((nhomtin LEFT JOIN theloai ON theloai.ID_theloai=nhomtin.ID_theloai) LEFT JOIN theloaitin ON theloaitin.ID_theloaitin=nhomtin.ID_theloaitin) WHERE theloai.keyword=%s  AND theloaitin.keyseo=%s  AND nhomtin.visible=1 ORDER BY nhomtin.ngaycapnhat DESC LIMIT 0,3", GetSQLValueString($KTColParam1_rs_nhomtin, "text"),GetSQLValueString($KTColParam2_rs_nhomtin, "text"));
$rs_nhomtin = mysql_query($query_rs_nhomtin, $conn_vietchuyen) or die(mysql_error());
$row_rs_nhomtin = mysql_fetch_assoc($rs_nhomtin);
$totalRows_rs_nhomtin = mysql_num_rows($rs_nhomtin);

mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_tintuc = "SELECT ID_tintuc, tieudetin, hinhtrichdan, ID_theloai, ID_tintuc, ID_theloaitin FROM tintuc WHERE ID_nhomtin = 123456789 AND kiemduyet = 1 ORDER BY ngaycapnhat DESC LIMIT 0,5";
$rs_tintuc = mysql_query($query_rs_tintuc, $conn_vietchuyen) or die(mysql_error());
$row_rs_tintuc = mysql_fetch_assoc($rs_tintuc);
$totalRows_rs_tintuc = mysql_num_rows($rs_tintuc);
?>
	<?php do { ?>
        <?php if ($totalRows_rs_nhomtin > 0) { // Show if recordset not empty ?>
        <section class="chuyendemoinhat">
            <header class="chuyendemoinhat_title">
            	<span class="linkden">
                	<!--<a href="layout_cactinchuyende.php?chuyende=<?php echo $row_rs_nhomtin['ID_nhomtin']; ?>">-->
                    	<a href="<?=$url?>chuyende<?=$row_rs_nhomtin['ID_nhomtin'];?>/<?=vietdecode($row_rs_nhomtin['tennhomtin']);?>.html">
																<?php echo ucwords($row_rs_nhomtin['tennhomtin']); ?>
                    </a>
                </span>
            </header>
          <section class="chuyendemoinhat_cen">
              <?php
  if ($totalRows_rs_nhomtin>0) {
    $nested_query_rs_tintuc = str_replace("123456789", $row_rs_nhomtin['ID_nhomtin'], $query_rs_tintuc);
    mysql_select_db($database_conn_vietchuyen);
    $rs_tintuc = mysql_query($nested_query_rs_tintuc, $conn_vietchuyen) or die(mysql_error());
    $row_rs_tintuc = mysql_fetch_assoc($rs_tintuc);
    $totalRows_rs_tintuc = mysql_num_rows($rs_tintuc);
    $nested_sw = false;
    if (isset($row_rs_tintuc) && is_array($row_rs_tintuc)) {
		$dem = 0;
      	do { //Nested repeat
		$dem++;
		if($dem == 1){
?>	
            <article class="baiviet_1">
                <a href="<?=$url?>a<?=$row_rs_tintuc['ID_theloai']; ?>/b<?=$row_rs_tintuc['ID_theloaitin']; ?>/c<?=$row_rs_tintuc['ID_tintuc']; ?>/<?=vietdecode($row_rs_tintuc['tieudetin']);?>.html">
                	<img src="<?=$url?>images/<?php echo $row_rs_tintuc['hinhtrichdan']; ?>" width="280px" alt="<?php echo $row_rs_tintuc['tieudetin']; ?>"></a>
                <h5>
                	<span class="linkcam">
                    	<a href="<?=$url?>a<?=$row_rs_tintuc['ID_theloai']; ?>/b<?=$row_rs_tintuc['ID_theloaitin']; ?>/c<?=$row_rs_tintuc['ID_tintuc']; ?>/<?=vietdecode($row_rs_tintuc['tieudetin']);?>.html"><?php echo $row_rs_tintuc['tieudetin']; ?></a>
                    </span>
                </h5>
            </article>
             <?php
		 }else{
		 ?>
              <article class="baiviet">
                <h5>
                    <span class="linkden">
                            <a href="<?=$url?>a<?=$row_rs_tintuc['ID_theloai']; ?>/b<?=$row_rs_tintuc['ID_theloaitin']; ?>/c<?=$row_rs_tintuc['ID_tintuc']; ?>/<?=vietdecode($row_rs_tintuc['tieudetin']);?>.html"><?php echo $row_rs_tintuc['tieudetin']; ?></a>
                    </span>
                </h5>
              </article>
              <?php
		 }
      } while ($row_rs_tintuc = mysql_fetch_assoc($rs_tintuc)); //Nested move next
    }
  }
?>
            </section>
            <section class="xemthem">
            	<span class="linkden">
                	<!--<a href="layout_cactinchuyende.php?chuyende=<?php echo $row_rs_nhomtin['ID_nhomtin']; ?>">Xem thêm</a>-->
                    <a href="<?=$url?>chuyende<?=$row_rs_nhomtin['ID_nhomtin'];?>/<?=vietdecode($row_rs_nhomtin['tennhomtin']);?>.html">Xem thêm</a>
                </span>
            </section>
      </section>
          <?php } // Show if recordset not empty ?>

	    <?php } while ($row_rs_nhomtin = mysql_fetch_assoc($rs_nhomtin)); ?>
<?php
mysql_free_result($rs_nhomtin);

mysql_free_result($rs_tintuc);
?>
