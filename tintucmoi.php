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

mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_tinso1 = "SELECT ID_tintuc, tieudetin, hinhtrichdan, trichdantin, ID_theloai FROM tintuc WHERE kiemduyet = 1 ORDER BY ngaycapnhat DESC LIMIT 0,1";
$rs_tinso1 = mysql_query($query_rs_tinso1, $conn_vietchuyen) or die(mysql_error());
$row_rs_tinso1 = mysql_fetch_assoc($rs_tinso1);
$totalRows_rs_tinso1 = mysql_num_rows($rs_tinso1);

mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_tinso2_4 = "SELECT ID_tintuc, tieudetin, hinhtrichdan, ID_theloai FROM tintuc WHERE kiemduyet = 1 ORDER BY ngaycapnhat DESC LIMIT 1,3";
$rs_tinso2_4 = mysql_query($query_rs_tinso2_4, $conn_vietchuyen) or die(mysql_error());
$row_rs_tinso2_4 = mysql_fetch_assoc($rs_tinso2_4);
$totalRows_rs_tinso2_4 = mysql_num_rows($rs_tinso2_4);

mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_tinso5 = "SELECT ID_tintuc, tieudetin, hinhtrichdan, ID_theloai FROM tintuc WHERE kiemduyet = 1 ORDER BY ngaycapnhat DESC LIMIT 4,1";
$rs_tinso5 = mysql_query($query_rs_tinso5, $conn_vietchuyen) or die(mysql_error());
$row_rs_tinso5 = mysql_fetch_assoc($rs_tinso5);
$totalRows_rs_tinso5 = mysql_num_rows($rs_tinso5);

mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_tinso6_13 = "SELECT ID_tintuc, tieudetin, ID_theloai FROM tintuc WHERE kiemduyet = 1 ORDER BY ngaycapnhat DESC LIMIT 6,18";
$rs_tinso6_13 = mysql_query($query_rs_tinso6_13, $conn_vietchuyen) or die(mysql_error());
$row_rs_tinso6_13 = mysql_fetch_assoc($rs_tinso6_13);
$totalRows_rs_tinso6_13 = mysql_num_rows($rs_tinso6_13);
?>
<link href="css/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />
<section class="tintucmoi">
  <section class="tintucmoi_col_1">
    <article> 
		<a href="<?=$url?>cat<?=$row_rs_tinso1['ID_theloai'];?>/detail<?=$row_rs_tinso1['ID_tintuc'];?>/<?=vietdecode($row_rs_tinso1['tieudetin']);?>.html"><img src="images/<?php echo $row_rs_tinso1['hinhtrichdan']; ?>" alt="<?php echo $row_rs_tinso1['tieudetin']; ?>" name="anhmoi" width="470px" height="260px" id="anhmoi"></a><br>
        
        <!--<a href="layout_chitiettin.php?cat=<?php echo $row_rs_tinso1['ID_theloai']; ?>&id=<?php echo $row_rs_tinso1['ID_tintuc']; ?>"><img src="images/<?php echo $row_rs_tinso1['hinhtrichdan']; ?>" alt="<?php echo $row_rs_tinso1['tieudetin']; ?>" name="anhmoi" width="470px" height="260px" id="anhmoi"></a><br>-->
      <h2>
      	<span class="linkden">
      	<a href="<?=$url?>cat<?=$row_rs_tinso1['ID_theloai'];?>/detail<?=$row_rs_tinso1['ID_tintuc'];?>/<?=vietdecode($row_rs_tinso1['tieudetin']);?>.html"><?php echo $row_rs_tinso1['tieudetin']; ?></a>
        <!--<a href="layout_chitiettin.php?cat=<?php echo $row_rs_tinso1['ID_theloai']; ?>&id=<?php echo $row_rs_tinso1['ID_tintuc']; ?>"><?php echo $row_rs_tinso1['tieudetin']; ?></a>-->
        </span>
      </h2>
    <p><?php echo $row_rs_tinso1['trichdantin']; ?></p>
    </article>
    <?php 
		$count = 0;
		do {
		$count++; 
	?>
    <article class="<?php echo ($count == 3) ? "tintuc_2_4_last" : "tintuc_2_4" ?>"> 
    	<a href="<?=$url?>cat<?=$row_rs_tinso2_4['ID_theloai'];?>/detail<?=$row_rs_tinso2_4['ID_tintuc'];?>/<?=vietdecode($row_rs_tinso2_4['tieudetin']);?>.html"><img src="images/<?php echo $row_rs_tinso2_4['hinhtrichdan']; ?>" width="151px" height="112px"></a>
       <!-- <a href="layout_chitiettin.php?cat=<?php echo $row_rs_tinso2_4['ID_theloai']; ?>&id=<?php echo $row_rs_tinso2_4['ID_tintuc']; ?>"><img src="images/<?php echo $row_rs_tinso2_4['hinhtrichdan']; ?>" width="151px" height="112px"></a>-->
        <h1>
        	<span class="linkden">
            	<a href="<?=$url?>cat<?=$row_rs_tinso2_4['ID_theloai'];?>/detail<?=$row_rs_tinso2_4['ID_tintuc'];?>/<?=vietdecode($row_rs_tinso2_4['tieudetin']);?>.html"><?php echo $row_rs_tinso2_4['tieudetin']; ?></a>
            	<!--<a href="layout_chitiettin.php?cat=<?php echo $row_rs_tinso2_4['ID_theloai']; ?>&id=<?php echo $row_rs_tinso2_4['ID_tintuc']; ?>"><?php echo $row_rs_tinso2_4['tieudetin']; ?></a>-->
            </span>
        </h1>
    </article>
    <?php } while ($row_rs_tinso2_4 = mysql_fetch_assoc($rs_tinso2_4)); ?>
  </section>
  <section class="tintucmoi_col_2" id="content_1">
    <article class="tintuc_5"> 
    	<a href="<?=$url?>cat<?=$row_rs_tinso5['ID_theloai'];?>/detail<?=$row_rs_tinso5['ID_tintuc'];?>/<?=vietdecode($row_rs_tinso5['tieudetin']);?>.html"><img src="images/<?php echo $row_rs_tinso5['hinhtrichdan']; ?>" width="180px" height="113px"></a><br>
      <!--<a href="layout_chitiettin.php?cat=<?php echo $row_rs_tinso5['ID_theloai']; ?>&id=<?php echo $row_rs_tinso5['ID_tintuc']; ?>"><img src="images/<?php echo $row_rs_tinso5['hinhtrichdan']; ?>" width="180px" height="113px"></a><br>-->
      <h1>
      	<span class="linkden">
        	<a href="<?=$url?>cat<?=$row_rs_tinso5['ID_theloai'];?>/detail<?=$row_rs_tinso5['ID_tintuc'];?>/<?=vietdecode($row_rs_tinso5['tieudetin']);?>.html"><?php echo $row_rs_tinso5['tieudetin']; ?></a>
        </span>
      </h1>
      <hr style="border:1px dashed gray" />
    </article>
    <?php do { ?>
      <article class="tintuc_5_13">
        <h1>
        	<span class="linkden">
            	<a href="<?=$url?>cat<?=$row_rs_tinso6_13['ID_theloai'];?>/detail<?=$row_rs_tinso6_13['ID_tintuc'];?>/<?=vietdecode($row_rs_tinso6_13['tieudetin']);?>.html"><?php echo $row_rs_tinso6_13['tieudetin']; ?></a>
                <!--<a href="layout_chitiettin.php?cat=<?php echo $row_rs_tinso6_13['ID_theloai']; ?>&id=<?php echo $row_rs_tinso6_13['ID_tintuc']; ?>"><?php echo $row_rs_tinso6_13['tieudetin']; ?></a>-->
            </span>
        </h1>
        <hr style="border:1px dashed gray" />
      </article>
      
      <?php } while ($row_rs_tinso6_13 = mysql_fetch_assoc($rs_tinso6_13)); ?>
  </section>
</section>
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>!window.jQuery && document.write(unescape('%3Cscript src="js/minified/jquery-1.9.1.min.js"%3E%3C/script%3E'))</script>-->
	<!-- custom scrollbars plugin -->
	<script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
	<script>
		(function($){
			$(window).load(function(){
				$("#content_1").mCustomScrollbar({
					scrollButtons:{
						enable:true
					}
				});
			});
		})(jQuery);
	</script>
<?php
mysql_free_result($rs_tinso1);
mysql_free_result($rs_tinso2_4);
mysql_free_result($rs_tinso5);
mysql_free_result($rs_tinso6_13);
?>
