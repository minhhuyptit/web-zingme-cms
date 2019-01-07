<?php include_once("catchuoi.php"); ?>
<?php include_once("vietdecode.php"); ?>
<?php require_once('Connections/conn_vietchuyen.php'); ?>
<?php
// Load the tNG classes
require_once('includes/tng/tNG.inc.php');

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
$query_rs_theloai_master = "SELECT ID_theloai, tentheloai, keyword FROM theloai WHERE linkngoai = 0 AND visible1 = 1 AND ID_theloai != 12 ORDER BY sapxep ASC";
$rs_theloai_master = mysql_query($query_rs_theloai_master, $conn_vietchuyen) or die(mysql_error());
$row_rs_theloai_master = mysql_fetch_assoc($rs_theloai_master);
$totalRows_rs_theloai_master = mysql_num_rows($rs_theloai_master);

mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_theloaitin_detail = "SELECT ID_theloaitin, keyseo, tentheloaitin, ID_theloai FROM theloaitin WHERE ID_theloai = 123456789 AND visible2 = 1 ORDER BY sapxep ASC";
$rs_theloaitin_detail = mysql_query($query_rs_theloaitin_detail, $conn_vietchuyen) or die(mysql_error());
$row_rs_theloaitin_detail = mysql_fetch_assoc($rs_theloaitin_detail);
$totalRows_rs_theloaitin_detail = mysql_num_rows($rs_theloaitin_detail);

mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_tintuc_detail = "SELECT ID_tintuc, tieudetin, hinhtrichdan, trichdantin, ID_theloai, cohinh, cophim FROM tintuc WHERE ID_theloai = 123456789 AND kiemduyet = 1 ORDER BY ngaycapnhat DESC LIMIT 0,6";
$rs_tintuc_detail = mysql_query($query_rs_tintuc_detail, $conn_vietchuyen) or die(mysql_error());
$row_rs_tintuc_detail = mysql_fetch_assoc($rs_tintuc_detail);
$totalRows_rs_tintuc_detail = mysql_num_rows($rs_tintuc_detail);

// Show Dynamic Thumbnail
$objDynamicThumb1 = new tNG_DynamicThumbnail("", "KT_thumbnail1");
$objDynamicThumb1->setFolder("images/");
$objDynamicThumb1->setRenameRule("{rs_tintuc_detail.hinhtrichdan}");
$objDynamicThumb1->setResize(75, 60, true);
$objDynamicThumb1->setWatermark(false);
?>
	<?php do { ?>
	  <section class="tintucmoitheloai">
	    <header class="tintucmoitheloai_title">
	      <section class="tentheloai">
	        <span class="linkcam"><a href="<?=$url?><?php echo $row_rs_theloai_master['keyword']; ?>.html"><?php echo $row_rs_theloai_master['tentheloai']; ?></a></span>
	        <img src="images/play_icon.gif" alt="absmiddle"> &nbsp;
	        <?php
  if ($totalRows_rs_theloai_master>0) {
    $nested_query_rs_theloaitin_detail = str_replace("123456789", $row_rs_theloai_master['ID_theloai'], $query_rs_theloaitin_detail);
    mysql_select_db($database_conn_vietchuyen);
    $rs_theloaitin_detail = mysql_query($nested_query_rs_theloaitin_detail, $conn_vietchuyen) or die(mysql_error());
    $row_rs_theloaitin_detail = mysql_fetch_assoc($rs_theloaitin_detail);
    $totalRows_rs_theloaitin_detail = mysql_num_rows($rs_theloaitin_detail);
    $nested_sw = false;
    if (isset($row_rs_theloaitin_detail) && is_array($row_rs_theloaitin_detail)) {
		$count = 0;
      do { //Nested repeat
	  	$count++;
?>
            <span class="linkden <?="stt-$count"?>" >
            	<!--<a href="layout_theloaitin.php?cat=<?php echo $row_rs_theloaitin_detail['ID_theloai']; ?>&subcat=<?php echo $row_rs_theloaitin_detail['ID_theloaitin']; ?>"><?php echo $row_rs_theloaitin_detail['tentheloaitin']; ?></a>-->
                <a href="<?=$url?><?php echo $row_rs_theloai_master['keyword']; ?>/<?php echo $row_rs_theloaitin_detail['keyseo']; ?>.html"><?php echo $row_rs_theloaitin_detail['tentheloaitin']; ?></a>
            </span>
            <span class="<?="vertical-bar-$count"?>"><?php echo ($count == $totalRows_rs_theloaitin_detail) ? "":"&nbsp;|&nbsp;"; ?> </span>
              <?php
      } while ($row_rs_theloaitin_detail = mysql_fetch_assoc($rs_theloaitin_detail)); //Nested move next
    }
  }
?>
</section>
	      </header> 
	    <section class="tintucmoitheloai_cen">
              <?php
  if ($totalRows_rs_theloai_master>0) {
    $nested_query_rs_tintuc_detail = str_replace("123456789", $row_rs_theloai_master['ID_theloai'], $query_rs_tintuc_detail);
    mysql_select_db($database_conn_vietchuyen);
    $rs_tintuc_detail = mysql_query($nested_query_rs_tintuc_detail, $conn_vietchuyen) or die(mysql_error());
    $row_rs_tintuc_detail = mysql_fetch_assoc($rs_tintuc_detail);
    $totalRows_rs_tintuc_detail = mysql_num_rows($rs_tintuc_detail);
    $nested_sw = false;
    if (isset($row_rs_tintuc_detail) && is_array($row_rs_tintuc_detail)) {
	  $count1 = 0;
      do { //Nested repeat
	  $count1++;
?>				
				<?php if($count1 == 1){ ?>
                <section class="tintheloai_col_1">     
                  <article class="tintheloai_1">
                    <a href="<?=$url?>cat<?=$row_rs_tintuc_detail['ID_theloai'];?>/detail<?=$row_rs_tintuc_detail['ID_tintuc'];?>/<?=vietdecode($row_rs_tintuc_detail['tieudetin']);?>.html">
                    	<img src="images/<?php echo $row_rs_tintuc_detail['hinhtrichdan']; ?>" width="180px" height="150px" class="canhlechohinh" alt="<?php echo $row_rs_tintuc_detail['tieudetin']; ?>">
                    </a>
                    <h5>
						<span class="linkden">
                        		<a href="<?=$url?>cat<?=$row_rs_tintuc_detail['ID_theloai'];?>/detail<?=$row_rs_tintuc_detail['ID_tintuc'];?>/<?=vietdecode($row_rs_tintuc_detail['tieudetin']);?>.html"><?php echo $row_rs_tintuc_detail['tieudetin']; ?></a>
                           <!-- <a href="layout_chitiettin.php?cat=<?php echo $row_rs_tintuc_detail['ID_theloai']; ?>&id=<?php echo $row_rs_tintuc_detail['ID_tintuc']; ?>"><?php echo $row_rs_tintuc_detail['tieudetin']; ?></a>-->

                        </span>
                    </h5>
                      <p><?php echo catchuoi($row_rs_tintuc_detail['trichdantin'],120,1); ?></p>
                    </article>              
                 </section>
                 <?php } ?>
                <section class="tintheloai_col_2">
                <?php  if($count1 == 2){ ?>
                  <article class="tintheloai_2"> 
                  		<a href="<?=$url?>cat<?=$row_rs_tintuc_detail['ID_theloai'];?>/detail<?=$row_rs_tintuc_detail['ID_tintuc'];?>/<?=vietdecode($row_rs_tintuc_detail['tieudetin']);?>.html">                                    
                  	<!--<a href="layout_chitiettin.php?cat=<?php echo $row_rs_tintuc_detail['ID_theloai']; ?>&id=<?php echo $row_rs_tintuc_detail['ID_tintuc']; ?>">-->
                    	<img src="<?=$url?><?php echo $objDynamicThumb1->Execute(); ?>" border="0" class="canhlechohinh" alt="<?php echo $row_rs_tintuc_detail['tieudetin']; ?>" />
                    </a>
                    <h5>
                    	<span class="linkden">
                        		<a href="<?=$url?>cat<?=$row_rs_tintuc_detail['ID_theloai'];?>/detail<?=$row_rs_tintuc_detail['ID_tintuc'];?>/<?=vietdecode($row_rs_tintuc_detail['tieudetin']);?>.html"><?php echo $row_rs_tintuc_detail['tieudetin']; ?></a>
                        	<!--<a href="layout_chitiettin.php?cat=<?php echo $row_rs_tintuc_detail['ID_theloai']; ?>&id=<?php echo $row_rs_tintuc_detail['ID_tintuc']; ?>"><?php echo $row_rs_tintuc_detail['tieudetin']; ?></a>-->
                        </span>
                    </h5>
                        
                  </article>
                    <?php } 
						if($count1 > 2){
					?>
                  <article class="tintheloai_3_6">
                    <h5>
						<span class="linkden">
                        	<a href="<?=$url?>cat<?=$row_rs_tintuc_detail['ID_theloai'];?>/detail<?=$row_rs_tintuc_detail['ID_tintuc'];?>/<?=vietdecode($row_rs_tintuc_detail['tieudetin']);?>.html"><?php echo catchuoi($row_rs_tintuc_detail['tieudetin'],100,1); ?></a>
                        	<!--<a href="layout_chitiettin.php?cat=<?php echo $row_rs_tintuc_detail['ID_theloai']; ?>&id=<?php echo $row_rs_tintuc_detail['ID_tintuc']; ?>"><?php echo catchuoi($row_rs_tintuc_detail['tieudetin'],100,1); ?></a>-->
                        </span>
                    </h5>
                    </article>
                    <?php } ?>
                  </section>
                <?php
      } while ($row_rs_tintuc_detail = mysql_fetch_assoc($rs_tintuc_detail)); //Nested move next
    }
  }
?>
	    </section>
	 </section>
	  <?php } while ($row_rs_theloai_master = mysql_fetch_assoc($rs_theloai_master)); ?>
<?php
mysql_free_result($rs_theloai_master);

mysql_free_result($rs_theloaitin_detail);

mysql_free_result($rs_tintuc_detail);
?>
