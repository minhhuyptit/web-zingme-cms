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

mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_theloaitin_master = "SELECT theloai.ID_theloai, theloai.tentheloai, theloai.keyword, theloaitin.ID_theloaitin, theloaitin.tentheloaitin, theloaitin.keyseo, theloaitin.visible2, theloaitin.sapxep FROM (theloaitin LEFT JOIN theloai ON theloai.ID_theloai=theloaitin.ID_theloai) WHERE theloai.keyword='Blog'  AND theloaitin.visible2=1 ORDER BY theloaitin.sapxep ASC ";
$rs_theloaitin_master = mysql_query($query_rs_theloaitin_master, $conn_vietchuyen) or die(mysql_error());
$row_rs_theloaitin_master = mysql_fetch_assoc($rs_theloaitin_master);
$totalRows_rs_theloaitin_master = mysql_num_rows($rs_theloaitin_master);

mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_tintuc_detail = "SELECT ID_tintuc, tieudetin, hinhtrichdan, ID_theloai FROM tintuc WHERE ID_theloaitin = 123456789 AND kiemduyet = 1 ORDER BY ngaycapnhat DESC LIMIT 0,3";
$rs_tintuc_detail = mysql_query($query_rs_tintuc_detail, $conn_vietchuyen) or die(mysql_error());
$row_rs_tintuc_detail = mysql_fetch_assoc($rs_tintuc_detail);
$totalRows_rs_tintuc_detail = mysql_num_rows($rs_tintuc_detail);
?>
	<section class="blog">
    	<header class="blog_title">
        	<span class="linkcam">
            	<!--<a href="layout_theloai.php?cat=12">BLOG</a>-->
                <a href="<?=$url?>Blog.html">BLOG</a>
            </span>
        </header>
        <?php 
		$count = 0;
		do { 
		$count++;
		?>
<section class="<?=($count % 4 == 0) ? "box_blog_last":"box_blog";?>">
            <header class="box_blog_title">
            	<span class="linkden">
                	<!--<a href="layout_theloaitin.php?cat=<?php echo $row_rs_theloaitin_master['ID_theloai']; ?>&subcat=<?php echo $row_rs_theloaitin_master['ID_theloaitin']; ?>"><?php echo $row_rs_theloaitin_master['tentheloaitin']; ?></a>-->
                    <a href="<?=$url?><?php echo $row_rs_theloaitin_master['keyword']; ?>/<?php echo $row_rs_theloaitin_master['keyseo']; ?>.html"><?php echo $row_rs_theloaitin_master['tentheloaitin']; ?></a>
              </span>
</header>
            <?php
  if ($totalRows_rs_theloaitin_master>0) {
    $nested_query_rs_tintuc_detail = str_replace("123456789", $row_rs_theloaitin_master['ID_theloaitin'], $query_rs_tintuc_detail);
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
			<article class="blog_tin_1">
            		<a href="<?=$url?>cat<?=$row_rs_tintuc_detail['ID_theloai'];?>/detail<?=$row_rs_tintuc_detail['ID_tintuc'];?>/<?=vietdecode($row_rs_tintuc_detail['tieudetin']);?>.html">
            	<!--<a href="layout_chitiettin.php?cat=<?php echo $row_rs_tintuc_detail['ID_theloai']; ?>&id=<?php echo $row_rs_tintuc_detail['ID_tintuc']; ?>">-->
                	<img src="<?=$url?>images/<?php echo $row_rs_tintuc_detail['hinhtrichdan']; ?>" width="150px" height="100px">
                </a>
                <h5>
                	<span class="linkden">
                    		<a href="<?=$url?>cat<?=$row_rs_tintuc_detail['ID_theloai'];?>/detail<?=$row_rs_tintuc_detail['ID_tintuc'];?>/<?=vietdecode($row_rs_tintuc_detail['tieudetin']);?>.html"><?php echo $row_rs_tintuc_detail['tieudetin']; ?></a>
                    	<!--<a href="layout_chitiettin.php?cat=<?php echo $row_rs_tintuc_detail['ID_theloai']; ?>&id=<?php echo $row_rs_tintuc_detail['ID_tintuc']; ?>"><?php echo $row_rs_tintuc_detail['tieudetin']; ?></a>-->
                    </span>
                </h5>
    </article>
			<?php } else {?>
            <article class="blog_tin_2_3">
              <h5>
                   <span class="linkden">
                   			<a href="<?=$url?>cat<?=$row_rs_tintuc_detail['ID_theloai'];?>/detail<?=$row_rs_tintuc_detail['ID_tintuc'];?>/<?=vietdecode($row_rs_tintuc_detail['tieudetin']);?>.html"><?php echo $row_rs_tintuc_detail['tieudetin']; ?></a>
                       <!--<a href="layout_chitiettin.php?cat=<?php echo $row_rs_tintuc_detail['ID_theloai']; ?>&id=<?php echo $row_rs_tintuc_detail['ID_tintuc']; ?>"><?php echo $row_rs_tintuc_detail['tieudetin']; ?></a>-->
                   </span> 
              </h5>
            </article>
            <?php } ?>
            
              <?php
      } while ($row_rs_tintuc_detail = mysql_fetch_assoc($rs_tintuc_detail)); //Nested move next
    }
  }
?>
          </section>
          <?php } while ($row_rs_theloaitin_master = mysql_fetch_assoc($rs_theloaitin_master)); ?>
    </section>
<?php
mysql_free_result($rs_theloaitin_master);

mysql_free_result($rs_tintuc_detail);
?>
