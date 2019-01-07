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

//$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rs_theloaitin = 26;
$pageNum_rs_theloaitin = 0;
if (isset($_GET['pageNum_rs_theloaitin'])) {
  $pageNum_rs_theloaitin = $_GET['pageNum_rs_theloaitin']-1;
}
$startRow_rs_theloaitin = $pageNum_rs_theloaitin * $maxRows_rs_theloaitin;

$KTColParam1_rs_theloaitin = "Doi-song";
if (isset($_GET['keyword'])) {
  $KTColParam1_rs_theloaitin = $_GET['keyword'];
}
$KTColParam2_rs_theloaitin = "Bat-dong-san";
if (isset($_GET['keyseo'])) {
  $KTColParam2_rs_theloaitin = $_GET['keyseo'];
}
mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_theloaitin = sprintf("SELECT theloai.ID_theloai, theloai.keyword, theloai.tentheloai, tintuc.ID_tintuc, tintuc.tieudetin, tintuc.hinhtrichdan, tintuc.trichdantin, tintuc.kiemduyet, tintuc.ngaycapnhat, theloaitin.ID_theloaitin, theloaitin.tentheloaitin FROM ((tintuc LEFT JOIN theloai ON theloai.ID_theloai=tintuc.ID_theloai) LEFT JOIN theloaitin ON theloaitin.ID_theloaitin=tintuc.ID_theloaitin) WHERE theloai.keyword=%s  AND tintuc.kiemduyet=1  AND theloaitin.keyseo=%s ORDER BY tintuc.ngaycapnhat DESC ", GetSQLValueString($KTColParam1_rs_theloaitin, "text"),GetSQLValueString($KTColParam2_rs_theloaitin, "text"));
$query_limit_rs_theloaitin = sprintf("%s LIMIT %d, %d", $query_rs_theloaitin, $startRow_rs_theloaitin, $maxRows_rs_theloaitin);
$rs_theloaitin = mysql_query($query_limit_rs_theloaitin, $conn_vietchuyen) or die(mysql_error());
$row_rs_theloaitin = mysql_fetch_assoc($rs_theloaitin);

if (isset($_GET['totalRows_rs_theloaitin'])) {
  $totalRows_rs_theloaitin = $_GET['totalRows_rs_theloaitin'];
} else {
  $all_rs_theloaitin = mysql_query($query_rs_theloaitin);
  $totalRows_rs_theloaitin = mysql_num_rows($all_rs_theloaitin);
}
$totalPages_rs_theloaitin = ceil($totalRows_rs_theloaitin/$maxRows_rs_theloaitin)-1;

$KTColParam1_rs_danhmuctincap2 = "The-gioi";
if (isset($_GET["keyword"])) {
  $KTColParam1_rs_danhmuctincap2 = $_GET["keyword"];
}
mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_danhmuctincap2 = sprintf("SELECT theloaitin.ID_theloaitin, theloaitin.tentheloaitin, theloai.ID_theloai, theloai.tentheloai, theloaitin.visible2, theloaitin.keyseo, theloai.keyword, theloaitin.sapxep FROM (theloaitin LEFT JOIN theloai ON theloai.ID_theloai=theloaitin.ID_theloai) WHERE theloaitin.visible2=1  AND theloai.keyword=%s ORDER BY theloaitin.sapxep ASC ", GetSQLValueString($KTColParam1_rs_danhmuctincap2, "text"));
$rs_danhmuctincap2 = mysql_query($query_rs_danhmuctincap2, $conn_vietchuyen) or die(mysql_error());
$row_rs_danhmuctincap2 = mysql_fetch_assoc($rs_danhmuctincap2);
$totalRows_rs_danhmuctincap2 = mysql_num_rows($rs_danhmuctincap2);

$queryString_rs_theloaitin = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rs_theloaitin") == false && 
        stristr($param, "totalRows_rs_theloaitin") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rs_theloaitin = "&" . htmlentities(implode("&", $newParams));
  }
}
//$queryString_rs_theloaitin = sprintf("&totalRows_rs_theloaitin=%d%s", $totalRows_rs_theloaitin, $queryString_rs_theloaitin);

$TFM_LimitLinksEndCount = 5;
$TFM_temp = $pageNum_rs_theloaitin + 1;
$TFM_startLink = max(1,$TFM_temp - intval($TFM_LimitLinksEndCount/2));
$TFM_temp = $TFM_startLink + $TFM_LimitLinksEndCount - 1;
$TFM_endLink = min($TFM_temp, $totalPages_rs_theloaitin + 1);
if($TFM_endLink != $TFM_temp) $TFM_startLink = max(1,$TFM_endLink - $TFM_LimitLinksEndCount + 1);
$currentPage=$url."trang-";
$keyword=$row_rs_danhmuctincap2['keyword'];
$keyseo=$row_rs_danhmuctincap2['keyseo'];
?>
	<section class="tintuctheotheloai">
    	<header class="tintuctheotheloai_title">
        	<span class="linkcam">
            	<a href="<?=$url?><?php echo $row_rs_theloaitin['keyword']; ?>.html"><?php echo $row_rs_theloaitin['tentheloai']; ?></a>
                <!--<a href="layout_theloai.php?cat=<?php echo $row_rs_theloaitin['ID_theloai']; ?>"><?php echo $row_rs_theloaitin['tentheloai']; ?></a>-->
            </span> <img style="position:relative; top:3px" src="<?=$url?>images/play_red_icon.png"> 
    	  <?php 
		  	$dem = 0;
		  	do { 
			$dem++;
			?>
         	<?php
				if($row_rs_danhmuctincap2['keyseo'] == $_GET['keyseo']){
			 ?>
             	<span class="maunendanhmuccon"><?php echo $row_rs_danhmuctincap2['tentheloaitin']; ?></span>
             <?php 
			 	}else{
			 ?>
             	<span class="linkden">
                	<a href="<?=$url?><?php echo $row_rs_theloaitin['keyword']; ?>/<?php echo $row_rs_danhmuctincap2['keyseo']; ?>.html"><?php echo $row_rs_danhmuctincap2['tentheloaitin']; ?></a>
                    <!--<a href="layout_theloaitin.php?cat=<?php echo $row_rs_danhmuctincap2['ID_theloai']; ?>&subcat=<?php echo $row_rs_danhmuctincap2['ID_theloaitin']; ?>"><?php echo $row_rs_danhmuctincap2['tentheloaitin']; ?></a>-->
                </span>
             <?php 
			 	}
			 ?>
				<?php	
					if($dem < $totalRows_rs_danhmuctincap2){
						echo "&nbsp;|&nbsp;";
					}
				?>  
   	        <?php } while ($row_rs_danhmuctincap2 = mysql_fetch_assoc($rs_danhmuctincap2)); ?></header>
        <?php 
		$count = 0;
		do { 
		$count++;
		if($count == 1){
		?>
        <article class="tintuctheotheloai_baiviet">
              <!--<a href="layout_chitiettin.php?cat=<?php echo $row_rs_theloaitin['ID_theloai']; ?>&subcat=<?php echo $row_rs_theloaitin['ID_theloaitin']; ?>&id=<?php echo $row_rs_theloaitin['ID_tintuc']; ?>">-->
              <a href="<?=$url?>a<?=$row_rs_theloaitin['ID_theloai']; ?>/b<?=$row_rs_theloaitin['ID_theloaitin']; ?>/c<?=$row_rs_theloaitin['ID_tintuc']; ?>/<?=vietdecode($row_rs_theloaitin['tieudetin']);?>.html">
              <img src="<?=$url?>images/<?php echo $row_rs_theloaitin['hinhtrichdan']; ?>" alt="<?php echo $row_rs_theloaitin['tieudetin']; ?>"
          width="380" height="200" class="canhlechohinh"></a>
              <h1>
              	<span class="linkden">
                	<!--<a href="layout_chitiettin.php?cat=<?php echo $row_rs_theloaitin['ID_theloai']; ?>&subcat=<?php echo $row_rs_theloaitin['ID_theloaitin']; ?>&id=<?php echo $row_rs_theloaitin['ID_tintuc']; ?>"><?php echo $row_rs_theloaitin['tieudetin']; ?></a>-->
                    <a href="<?=$url?>a<?=$row_rs_theloaitin['ID_theloai']; ?>/b<?=$row_rs_theloaitin['ID_theloaitin']; ?>/c<?=$row_rs_theloaitin['ID_tintuc']; ?>/<?=vietdecode($row_rs_theloaitin['tieudetin']);?>.html"><?php echo $row_rs_theloaitin['tieudetin']; ?></a>
                </span>
              </h1>
          <p class="date-time"><?php echo date('G:i', strtotime($row_rs_theloaitin['ngaycapnhat'])); ?> ngày <?php echo date('d/m/Y', strtotime($row_rs_theloaitin['ngaycapnhat'])); ?></p>
              <p><?php echo $row_rs_theloaitin['trichdantin']; ?></p>
         </article>
        <?php }
			if($count >= 2 && $count <= 16){ ?>
          <article class="tintuctheotheloai_baiviet">
              <!--<a href="layout_chitiettin.php?cat=<?php echo $row_rs_theloaitin['ID_theloai']; ?>&subcat=<?php echo $row_rs_theloaitin['ID_theloaitin']; ?>&id=<?php echo $row_rs_theloaitin['ID_tintuc']; ?>">-->
              <a href="<?=$url?>a<?=$row_rs_theloaitin['ID_theloai']; ?>/b<?=$row_rs_theloaitin['ID_theloaitin']; ?>/c<?=$row_rs_theloaitin['ID_tintuc']; ?>/<?=vietdecode($row_rs_theloaitin['tieudetin']);?>.html">
              <img src="<?=$url?>images/<?php echo $row_rs_theloaitin['hinhtrichdan']; ?>" alt="<?php echo $row_rs_theloaitin['tieudetin']; ?>"
          width="150" height="100" class="canhlechohinh"></a>
            <h1>
			  	<span class="linkden">
                	<!--<a href="layout_chitiettin.php?cat=<?php echo $row_rs_theloaitin['ID_theloai']; ?>&subcat=<?php echo $row_rs_theloaitin['ID_theloaitin']; ?>&id=<?php echo $row_rs_theloaitin['ID_tintuc']; ?>"><?php echo $row_rs_theloaitin['tieudetin']; ?></a>-->
                    <a href="<?=$url?>a<?=$row_rs_theloaitin['ID_theloai']; ?>/b<?=$row_rs_theloaitin['ID_theloaitin']; ?>/c<?=$row_rs_theloaitin['ID_tintuc']; ?>/<?=vietdecode($row_rs_theloaitin['tieudetin']);?>.html"><?php echo $row_rs_theloaitin['tieudetin']; ?></a>
                </span>
            </h1>
              <p class="date-time"><?php echo date('G:i', strtotime($row_rs_theloaitin['ngaycapnhat'])); ?> ngày <?php echo date('d/m/Y', strtotime($row_rs_theloaitin['ngaycapnhat'])); ?></p>
              <p><?php echo $row_rs_theloaitin['trichdantin']; ?></p>
           </article>
         <?php } 
		 	if($count == 16){
		 ?>
         	<h1 class="tieudetintuckhac">Các tin tức khác</h1>
          <?php } 
		  	if($count > 16){
		  ?>
          	<article class="tintuctheotheloai_baiviet_17_26">
              <h1>
			  	<span class="linkden">
                	<a href="<?=$url?>a<?=$row_rs_theloaitin['ID_theloai']; ?>/b<?=$row_rs_theloaitin['ID_theloaitin']; ?>/c<?=$row_rs_theloaitin['ID_tintuc']; ?>/<?=vietdecode($row_rs_theloaitin['tieudetin']);?>.html"><?php echo $row_rs_theloaitin['tieudetin']; ?></a>
                </span>&nbsp; 
                <span class="date-time"><?php echo date('G:i', strtotime($row_rs_theloaitin['ngaycapnhat'])); ?> ngày <?php echo date('d/m/Y', strtotime($row_rs_theloaitin['ngaycapnhat'])); ?>
                </span>
              </h1>
           </article>
          <?php } ?>
          <?php } while ($row_rs_theloaitin = mysql_fetch_assoc($rs_theloaitin)); ?>
    </section>
    
<section class="phantrang">
       <p class="boxes">
        <?php
        $TFM_Previous = $pageNum_rs_theloaitin - 4;
        if ($TFM_Previous >= 1) {
           //printf('...<a href="'."%s?pageNum_rs_theloaitin=%d%s", $currentPage, $TFM_Previous, $queryString_rs_theloaitin.'">');
		   printf('...<a href="'."%s%d/%s/%s", $currentPage, $TFM_Previous, $keyword, $keyseo.'.html">'); 
           echo "[Previous "."5"." pages] </a>...";
           //Basic-UltraDev Previous X pages SB
        }
        ?>
    	<?php
        for ($i = $TFM_startLink; $i <= $TFM_endLink; $i++) {
          $TFM_LimitPageEndCount = $i -1;
		  $hocwebgiare = $i;
          if($TFM_LimitPageEndCount != $pageNum_rs_theloaitin) {
            //printf('<a href="'."%s?pageNum_rs_theloaitin=%d%s", $currentPage, $hocwebgiare, $queryString_rs_theloaitin.'">');
			printf('<a href="'."%s%d/%s/%s", $currentPage, $hocwebgiare, $keyword, $keyseo.'.html">');
            echo "$i</a>";
          }else{
            echo "<span class=current>$i</span>";
          }
        if($i != $TFM_endLink) echo(" ");}
        ?>
        <?php
        $TFM_Next = $pageNum_rs_theloaitin + 6;
        $TFM_Last = $totalPages_rs_theloaitin+1;
        if ($TFM_Next - 1 < $totalPages_rs_theloaitin + 1) { 
          printf('...<a href="'."%s%d/%s/%s", $currentPage, $TFM_Next, $keyword, $keyseo.'.html">');
            echo "[Next "."5"." of ".$TFM_Last." pages] </a>...";
        }
        ?>
        </p>
</section>
<?php
mysql_free_result($rs_theloaitin);

mysql_free_result($rs_danhmuctincap2);
?>
