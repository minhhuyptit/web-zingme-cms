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
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_rs_theloai = 26;
$pageNum_rs_theloai = 0;
if (isset($_GET['pageNum_rs_theloai'])) {
  $pageNum_rs_theloai = $_GET['pageNum_rs_theloai'];
}
$startRow_rs_theloai = $pageNum_rs_theloai * $maxRows_rs_theloai;

$KTColParam1_rs_theloai = "The-thao";
if (isset($_GET["keyword"])) {
  $KTColParam1_rs_theloai = $_GET["keyword"];
}
mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_theloai = sprintf("SELECT tintuc.ID_tintuc, theloai.ID_theloai, tintuc.tieudetin, theloai.tentheloai, tintuc.hinhtrichdan, tintuc.trichdantin, tintuc.kiemduyet, tintuc.ngaycapnhat, theloai.keyword FROM (tintuc LEFT JOIN theloai ON theloai.ID_theloai=tintuc.ID_theloai) WHERE tintuc.kiemduyet=1  AND theloai.keyword=%s ORDER BY tintuc.ngaycapnhat DESC ", GetSQLValueString($KTColParam1_rs_theloai, "text"));
$query_limit_rs_theloai = sprintf("%s LIMIT %d, %d", $query_rs_theloai, $startRow_rs_theloai, $maxRows_rs_theloai);
$rs_theloai = mysql_query($query_limit_rs_theloai, $conn_vietchuyen) or die(mysql_error());
$row_rs_theloai = mysql_fetch_assoc($rs_theloai);

if (isset($_GET['totalRows_rs_theloai'])) {
  $totalRows_rs_theloai = $_GET['totalRows_rs_theloai'];
} else {
  $all_rs_theloai = mysql_query($query_rs_theloai);
  $totalRows_rs_theloai = mysql_num_rows($all_rs_theloai);
}
$totalPages_rs_theloai = ceil($totalRows_rs_theloai/$maxRows_rs_theloai)-1;

$colname_rs_danhmuctincap2 = "10";
if (isset($_GET['cat'])) {
  $colname_rs_danhmuctincap2 = $_GET['cat'];
}
mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_danhmuctincap2 = sprintf("SELECT ID_theloaitin, tentheloaitin, ID_theloai FROM theloaitin WHERE ID_theloai = %s AND visiblemenu2=1 ORDER BY sapxep ASC", GetSQLValueString($colname_rs_danhmuctincap2, "int"));
$rs_danhmuctincap2 = mysql_query($query_rs_danhmuctincap2, $conn_vietchuyen) or die(mysql_error());
$row_rs_danhmuctincap2 = mysql_fetch_assoc($rs_danhmuctincap2);
$totalRows_rs_danhmuctincap2 = mysql_num_rows($rs_danhmuctincap2);

$queryString_rs_theloai = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rs_theloai") == false && 
        stristr($param, "totalRows_rs_theloai") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rs_theloai = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rs_theloai = sprintf("&totalRows_rs_theloai=%d%s", $totalRows_rs_theloai, $queryString_rs_theloai);

$TFM_LimitLinksEndCount = 5;
$TFM_temp = $pageNum_rs_theloai + 1;
$TFM_startLink = max(1,$TFM_temp - intval($TFM_LimitLinksEndCount/2));
$TFM_temp = $TFM_startLink + $TFM_LimitLinksEndCount - 1;
$TFM_endLink = min($TFM_temp, $totalPages_rs_theloai + 1);
if($TFM_endLink != $TFM_temp) $TFM_startLink = max(1,$TFM_endLink - $TFM_LimitLinksEndCount + 1);

?>
	<section class="tintuctheotheloai">
    	<header class="tintuctheotheloai_title"><span class="linkcam"><a href=""><?php echo $row_rs_theloai['tentheloai']; ?></a></span><img style="position:relative; top:3px" src="<?=$url?>images/play_red_icon.png"> 
        
        	<?php 
		  	$dem = 0;
		  	do { 
			$dem++;
			?>
             	<span class="linkden">
                	<!--<a href="layout_theloaitin.php?cat=<?php echo $row_rs_danhmuctincap2['ID_theloai']; ?>&subcat=<?php echo $row_rs_danhmuctincap2['ID_theloaitin']; ?>"><?php echo $row_rs_danhmuctincap2['tentheloaitin']; ?></a>-->
                    <a href="<?=$url?>menu<?php echo $row_rs_danhmuctincap2['ID_theloai']; ?>/menu<?php echo $row_rs_danhmuctincap2['ID_theloaitin']; ?>/<?php echo vietdecode($row_rs_danhmuctincap2['tentheloaitin']); ?>.html"><?php echo $row_rs_danhmuctincap2['tentheloaitin']; ?></a>
                </span>
				<?php	
					if($dem < $totalRows_rs_danhmuctincap2){
						echo "&nbsp;|&nbsp;";
					}
				?>  
   	        <?php } while ($row_rs_danhmuctincap2 = mysql_fetch_assoc($rs_danhmuctincap2)); ?>
        
        </header>
        <?php 
		$count = 0;
		do { 
		$count++;
		if($count == 1){
		?>
        <article class="tintuctheotheloai_baiviet">
        			<a href="<?=$url?>cat<?=$row_rs_theloai['ID_theloai'];?>/detail<?=$row_rs_theloai['ID_tintuc'];?>/<?=vietdecode($row_rs_theloai['tieudetin']);?>.html">
              <!--<a href="<?=$url?>layout_chitiettin.php?cat=<?php echo $row_rs_theloai['ID_theloai']; ?>&id=<?php echo $row_rs_theloai['ID_tintuc']; ?>">-->
              	<img src="<?=$url?>images/<?php echo $row_rs_theloai['hinhtrichdan']; ?>" alt="<?php echo $row_rs_theloai['tieudetin']; ?>" width="380" height="200" class="canhlechohinh">
              </a>
              <h1>
              	<span class="linkden">
                		<a href="<?=$url?>cat<?=$row_rs_theloai['ID_theloai'];?>/detail<?=$row_rs_theloai['ID_tintuc'];?>/<?=vietdecode($row_rs_theloai['tieudetin']);?>.html"><?php echo $row_rs_theloai['tieudetin']; ?></a>
                	<!--<a href="<?=$url?>layout_chitiettin.php?cat=<?php echo $row_rs_theloai['ID_theloai']; ?>&id=<?php echo $row_rs_theloai['ID_tintuc']; ?>"><?php echo $row_rs_theloai['tieudetin']; ?></a>-->
                </span>
              </h1>
          <p class="date-time"><?php echo date('G:i', strtotime($row_rs_theloai['ngaycapnhat'])); ?> ngày <?php echo date('d/m/Y', strtotime($row_rs_theloai['ngaycapnhat'])); ?></p>
              <p><?php echo $row_rs_theloai['trichdantin']; ?></p>
         </article>
        <?php }
			if($count >= 2 && $count <= 16){ ?>
          <article class="tintuctheotheloai_baiviet">
          			<a href="<?=$url?>cat<?=$row_rs_theloai['ID_theloai'];?>/detail<?=$row_rs_theloai['ID_tintuc'];?>/<?=vietdecode($row_rs_theloai['tieudetin']);?>.html">
              <!--<a href="<?=$url?>layout_chitiettin.php?cat=<?php echo $row_rs_theloai['ID_theloai']; ?>&id=<?php echo $row_rs_theloai['ID_tintuc']; ?>">-->
              		<img src="<?=$url?>images/<?php echo $row_rs_theloai['hinhtrichdan']; ?>" alt="<?php echo $row_rs_theloai['tieudetin']; ?>" width="150" height="100" class="canhlechohinh">
         		</a>
            <h1>
                  <span class="linkden">
                  			<a href="<?=$url?>cat<?=$row_rs_theloai['ID_theloai'];?>/detail<?=$row_rs_theloai['ID_tintuc'];?>/<?=vietdecode($row_rs_theloai['tieudetin']);?>.html"><?php echo $row_rs_theloai['tieudetin']; ?></a>
                        <!--<a href="<?=$url?>layout_chitiettin.php?cat=<?php echo $row_rs_theloai['ID_theloai']; ?>&id=<?php echo $row_rs_theloai['ID_tintuc']; ?>"><?php echo $row_rs_theloai['tieudetin']; ?></a>-->
                  </span>	
            </h1>
              <p class="date-time"><?php echo date('G:i', strtotime($row_rs_theloai['ngaycapnhat'])); ?> ngày <?php echo date('d/m/Y', strtotime($row_rs_theloai['ngaycapnhat'])); ?></p>
              <p><?php echo $row_rs_theloai['trichdantin']; ?></p>
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
                  			<a href="<?=$url?>cat<?=$row_rs_theloai['ID_theloai'];?>/detail<?=$row_rs_theloai['ID_tintuc'];?>/<?=vietdecode($row_rs_theloai['tieudetin']);?>.html"><?php echo $row_rs_theloai['tieudetin']; ?></a>
                        <!--<a href="<?=$url?>layout_chitiettin.php?cat=<?php echo $row_rs_theloai['ID_theloai']; ?>&id=<?php echo $row_rs_theloai['ID_tintuc']; ?>"><?php echo $row_rs_theloai['tieudetin']; ?></a>-->
                </span>&nbsp;
               	  <span class="date-time"><?php echo date('G:i', strtotime($row_rs_theloai['ngaycapnhat'])); ?> ngày <?php echo date('d/m/Y', strtotime($row_rs_theloai['ngaycapnhat'])); ?>
                  </span>
              </h1>
           </article>
          <?php } ?>
          <?php } while ($row_rs_theloai = mysql_fetch_assoc($rs_theloai)); ?>
    </section>
    
    <section class="phantrang">
       <p class="boxes">
        <?php
        $TFM_Previous = $pageNum_rs_theloai - 5;
        if ($TFM_Previous >= 0) {
           printf('...<a href="'."%s?pageNum_rs_theloai=%d%s", $currentPage, $TFM_Previous, $queryString_rs_theloai.'">');
           echo "[Previous "."5"." pages] </a>...";
           //Basic-UltraDev Previous X pages SB
        }
        ?>
    <?php
        for ($i = $TFM_startLink; $i <= $TFM_endLink; $i++) {
          $TFM_LimitPageEndCount = $i -1;
          if($TFM_LimitPageEndCount != $pageNum_rs_theloai) {
            printf('<a href="'."%s?pageNum_rs_theloai=%d%s", $currentPage, $TFM_LimitPageEndCount, $queryString_rs_theloai.'">');
            echo "$i</a>";
          }else{
            echo "<span class=current>$i</span>";
          }
        if($i != $TFM_endLink) echo(" ");}
        ?>
        <?php
        $TFM_Next = $pageNum_rs_theloai + 5;
        $TFM_Last = $totalPages_rs_theloai+1;
        if ($TFM_Next - 1 < $totalPages_rs_theloai) { 
          printf('...<a href="'."%s?pageNum_rs_theloai=%d%s", $currentPage, $TFM_Next, $queryString_rs_theloai.'">');
            echo "[Next "."5"." of ".$TFM_Last." pages] </a>...";
        }
        ?>
        </p>
</section>
<?php
mysql_free_result($rs_theloai);

mysql_free_result($rs_danhmuctincap2);
?>
