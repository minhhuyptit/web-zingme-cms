<?php require_once('Connections/conn_vietchuyen.php'); ?>
<?php require_once('catchuoi.php'); ?>
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

$KTColParam1_rs_loctinchuyende = "3";
if (isset($_GET["chuyende"])) {
  $KTColParam1_rs_loctinchuyende = $_GET["chuyende"];
}
mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_loctinchuyende = sprintf("SELECT nhomtin.ID_nhomtin, nhomtin.tennhomtin, tintuc.ID_tintuc, tintuc.ID_theloai, tintuc.tieudetin, tintuc.hinhtrichdan, tintuc.trichdantin, tintuc.cohinh, tintuc.cophim, tintuc.kiemduyet, tintuc.ngaycapnhat FROM (tintuc LEFT JOIN nhomtin ON nhomtin.ID_nhomtin=tintuc.ID_nhomtin) WHERE nhomtin.ID_nhomtin=%s  AND tintuc.kiemduyet=1 ORDER BY tintuc.ngaycapnhat DESC ", GetSQLValueString($KTColParam1_rs_loctinchuyende, "int"));
$rs_loctinchuyende = mysql_query($query_rs_loctinchuyende, $conn_vietchuyen) or die(mysql_error());
$row_rs_loctinchuyende = mysql_fetch_assoc($rs_loctinchuyende);
$totalRows_rs_loctinchuyende = mysql_num_rows($rs_loctinchuyende);
?>
<link rel="stylesheet" href="<?=$url?>plugin/css/mediaBoxes.css" />
<header class="title_chuyende">Chủ đề <?php echo $row_rs_loctinchuyende['tennhomtin']; ?></header>
    <div id="grid">
    	<!-- -------------------------- BOX MARKUP -------------------------- -->
        <?php do { ?>
          <div class="box" data-category="Category 1">
            <div class="box-image">
              <div data-thumbnail="<?=$url?>images/<?php echo $row_rs_loctinchuyende['hinhtrichdan']; ?>" ></div>
                <div data-image="<?=$url?>images/<?php echo $row_rs_loctinchuyende['hinhtrichdan']; ?>" ></div>
              
              
              <div class="thumbnail-caption">
                <div class="hover-lightbox open-lightbox-iframe"></div>
                	<a href="<?=$url?>cat<?=$row_rs_loctinchuyende['ID_theloai'];?>/detail<?=$row_rs_loctinchuyende['ID_tintuc'];?>/<?=vietdecode($row_rs_loctinchuyende['tieudetin']);?>.html">
                <!--<a href="layout_chitiettin.php?cat=<?php echo $row_rs_loctinchuyende['ID_theloai']; ?>&id=
												   <?php echo $row_rs_loctinchuyende['ID_tintuc']; ?>">-->
                     <div class="hover-url"></div>
               	</a>                
              </div>
  
                <div class="lightbox-text">
                        <?php echo $row_rs_loctinchuyende['tennhomtin']; ?> | 
                        <span><?php echo $row_rs_loctinchuyende['tieudetin']; ?></span>
                </div>
            </div>
  
            <div class="box-caption">
              <div class="box-title">
              	  <span class="linkden">
                  		<a href="<?=$url?>cat<?=$row_rs_loctinchuyende['ID_theloai'];?>/detail<?=$row_rs_loctinchuyende['ID_tintuc'];?>/<?=vietdecode($row_rs_loctinchuyende['tieudetin']);?>.html">
			  		<!--<a href="layout_chitiettin.php?cat=<?php echo $row_rs_loctinchuyende['ID_theloai']; ?>&id=
													   <?php echo $row_rs_loctinchuyende['ID_tintuc']; ?>">-->
						<?php echo $row_rs_loctinchuyende['tieudetin']; ?>
                    </a>
                  </span>
              </div>
                <div class="box-date"><?php echo date('G:i', strtotime($row_rs_loctinchuyende['ngaycapnhat'])); ?> 
                    ngày <?php echo date('d/m/Y', strtotime($row_rs_loctinchuyende['ngaycapnhat'])); ?>                </div>
                <div class="box-text">
                    <?php echo catchuoi($row_rs_loctinchuyende['trichdantin'], 130, 1); ?>                </div>
                <div class="box-more"> 
                		<a href="<?=$url?>cat<?=$row_rs_loctinchuyende['ID_theloai'];?>/detail<?=$row_rs_loctinchuyende['ID_tintuc'];?>/<?=vietdecode($row_rs_loctinchuyende['tieudetin']);?>.html">Chi tiết</a>
                	<!--<a href="layout_chitiettin.php?cat=<?php echo $row_rs_loctinchuyende['ID_theloai']; ?>&id=<?php echo $row_rs_loctinchuyende['ID_tintuc']; ?>">Chi tiết</a>--> 
                </div>
              </div>
              </div>
          <?php } while ($row_rs_loctinchuyende = mysql_fetch_assoc($rs_loctinchuyende)); ?></div>

<!-- SCRIPTS FOR THE PLUGIN -->
	<script src="<?=$url?>plugin/js/jquery-1.10.2.min.js"></script>
	<script src="<?=$url?>plugin/js/rotate-patch.js"></script>
	<script src="<?=$url?>plugin/js/waypoints.min.js"></script> <!-- if you wont use the Lazy Load feature erase this line -->
	<script src="<?=$url?>plugin/js/mediaBoxes.min.js"></script>

	<script>
	  
	    $('document').ready(function(){
	        
	        //INITIALIZE THE PLUGIN
	        $('#grid').mediaBoxes({
	        	theme: 'theme1',
				showFilterBar: false,
				imagesToLoad: 10,
				imagesToLoadStart: 10,
				lazyLoad: false,
				isFitWidth: false,
				horizontalSpaceBetweenThumbnails: 15,
				verticalSpaceBetweenThumbnails: 15,
				columnWidth: 'auto',
				columns: 5,
				columnMinWidth: 180,
				isAnimated: true,
				caption: true,
				captionType: 'grid',
				hoverImageIconsAnimation: true,
				hoverImageIconsSpeedAnimation: 100,
				lightBox: true,
				lightboxKeyboardNav: true,
				lightBoxSpeedFx: 500,
				lightBoxZoomAnim: true,
				lightBoxText: true,
				lightboxPlayBtn: true,
				lightBoxAutoPlay: false,
				lightBoxPlayInterval: 4000,
				lightBoxShowTimer: true,
				lightBoxStopPlayOnClose: false,
				allWord: "All",
				loadMoreWord: "Xem thêm",
	        });

	    });    
	       
	</script>
<?php
mysql_free_result($rs_loctinchuyende);
?>
