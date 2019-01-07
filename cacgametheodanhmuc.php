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

$KTColParam1_rs_loctinchuyende = "1";
if (isset($_GET["cat"])) {
  $KTColParam1_rs_loctinchuyende = $_GET["cat"];
}
mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_loctinchuyende = sprintf("SELECT theloaigame.ID_theloaigame, theloaigame.tentheloaigame, game.ID_game, game.tengame, game.hinhgame, game.trichdangame, game.solanchoi, game.solandownload, game.hot, game.ngaycapnhat, game.kiemduyet FROM (game LEFT JOIN theloaigame ON theloaigame.ID_theloaigame=game.ID_theloaigame) WHERE theloaigame.ID_theloaigame=%s  AND game.kiemduyet=1 ORDER BY game.ngaycapnhat DESC ", GetSQLValueString($KTColParam1_rs_loctinchuyende, "int"));
$rs_loctinchuyende = mysql_query($query_rs_loctinchuyende, $conn_vietchuyen) or die(mysql_error());
$row_rs_loctinchuyende = mysql_fetch_assoc($rs_loctinchuyende);
$totalRows_rs_loctinchuyende = mysql_num_rows($rs_loctinchuyende);
?>
<link rel="stylesheet" href="<?=$url?>plugin/css/mediaBoxes.css" />
<?php if ($totalRows_rs_loctinchuyende == 0) { // Show if recordset empty ?>
  <header class="title_chuyende">Đang cập nhật game</header>
  <?php } // Show if recordset empty ?>
<?php if ($totalRows_rs_loctinchuyende > 0) { // Show if recordset not empty ?>
  <header class="title_chuyende"><?php echo $row_rs_loctinchuyende['tentheloaigame']; ?></header>
  <div id="grid">
    <!-- -------------------------- BOX MARKUP -------------------------- -->
    <?php do { ?>
      <div class="box" data-category="Category 1">
        <div class="box-image">
          <div data-thumbnail="<?=$url?>game/hinhgame/<?php echo $row_rs_loctinchuyende['hinhgame']; ?>" ></div>
            <div data-image="<?=$url?>game/hinhgame/<?php echo $row_rs_loctinchuyende['hinhgame']; ?>" ></div>
                    
              
          <div class="thumbnail-caption">
            <div class="hover-lightbox open-lightbox-iframe"></div>
                <!--<a href="layout_gameonline.php?cat=<?php echo $row_rs_loctinchuyende['tentheloaigame']; ?>&id=
                                                       <?php echo $row_rs_loctinchuyende['ID_game']; ?>">-->
                    <a href="<?=$url?>gamecat<?=$row_rs_loctinchuyende['ID_theloaigame'];?>/game<?=$row_rs_loctinchuyende['ID_game'];?>/<?=vietdecode($row_rs_loctinchuyende['tengame']);?>.html">
                        <div class="hover-url"></div>
                </a>          
            </div>
        
            <div class="lightbox-text">
                  <?php echo $row_rs_loctinchuyende['tentheloaigame']; ?> | 
                  <span><?php echo $row_rs_loctinchuyende['tengame']; ?></span>            </div>
        </div>
        
        <div class="box-caption">
          <div class="box-title">
              <span class="linkden">
                <!--<a href="layout_gameonline.php?cat=<?php echo $row_rs_loctinchuyende['ID_theloaigame']; ?>&id=
													   <?php echo $row_rs_loctinchuyende['ID_game']; ?>">-->
                    <a href="<?=$url?>gamecat<?=$row_rs_loctinchuyende['ID_theloaigame'];?>/game<?=$row_rs_loctinchuyende['ID_game'];?>/<?=vietdecode($row_rs_loctinchuyende['tengame']);?>.html">
                    <?php echo $row_rs_loctinchuyende['tengame']; ?>                
               	</a>              </span>          </div>
            <div class="box-date"><?php echo date('G:i', strtotime($row_rs_loctinchuyende['ngaycapnhat'])); ?> 
                ngày <?php echo date('d/m/Y', strtotime($row_rs_loctinchuyende['ngaycapnhat'])); ?>                </div>
            <div class="box-text">
                <?php echo catchuoi($row_rs_loctinchuyende['trichdangame'], 130, 1); ?>                </div>
            <div class="box-more"> 
                <a href="layout_gameonline.php?cat=<?php echo $row_rs_loctinchuyende['ID_theloaigame']; ?>&id=
													   <?php echo $row_rs_loctinchuyende['ID_game']; ?>">Vào chơi</a>            </div>
          </div>
            </div>
      <?php } while ($row_rs_loctinchuyende = mysql_fetch_assoc($rs_loctinchuyende)); ?>
  </div>
  <!-- SCRIPTS FOR THE PLUGIN -->
  <script src="<?=$url?>plugin/js/jquery-1.10.2.min.js"></script>
  <script src="<?=$url?>plugin/js/rotate-patch.js"></script>
  <script src="<?=$url?>plugin/js/waypoints.min.js"></script> 
  <!-- if you wont use the Lazy Load feature erase this line -->
  <script src="<?=$url?>plugin/js/mediaBoxes.min.js"></script>
  
  <script>
	  
	    $('document').ready(function(){
	        
	        //INITIALIZE THE PLUGIN
	        $('#grid').mediaBoxes({
	        	theme: 'theme1',
				showFilterBar: false,
				imagesToLoad: 3,
				imagesToLoadStart: 3,
				lazyLoad: false,
				isFitWidth: false,
				horizontalSpaceBetweenThumbnails: 15,
				verticalSpaceBetweenThumbnails: 15,
				columnWidth: 'auto',
				columns: 3,
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
      <?php } // Show if recordset not empty ?>
<?php
mysql_free_result($rs_loctinchuyende);
?>
