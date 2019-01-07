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
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_rs_ketquatimkiem = 10;
$pageNum_rs_ketquatimkiem = 0;
if (isset($_GET['pageNum_rs_ketquatimkiem'])) {
  $pageNum_rs_ketquatimkiem = $_GET['pageNum_rs_ketquatimkiem'];
}
$startRow_rs_ketquatimkiem = $pageNum_rs_ketquatimkiem * $maxRows_rs_ketquatimkiem;

$KTColParam1_rs_ketquatimkiem = "ronaldo";
if (isset($_GET["keyword"])) {
  $KTColParam1_rs_ketquatimkiem = $_GET["keyword"];
}
mysql_select_db($database_conn_vietchuyen, $conn_vietchuyen);
$query_rs_ketquatimkiem = sprintf("SELECT theloaitin.ID_theloaitin, theloai.keyword, theloaitin.tentheloaitin, theloai.tentheloai, theloai.ID_theloai, tintuc.ID_tintuc, tintuc.hinhtrichdan, tintuc.tieudetin, tintuc.trichdantin, tintuc.cophim, tintuc.cohinh, tintuc.kiemduyet, tintuc.ngaycapnhat FROM ((tintuc LEFT JOIN theloai ON theloai.ID_theloai=tintuc.ID_theloai) LEFT JOIN theloaitin ON theloaitin.ID_theloaitin=tintuc.ID_theloaitin) WHERE tintuc.tieudetin LIKE %s  AND tintuc.kiemduyet=1 OR tintuc.trichdantin LIKE %s  AND tintuc.kiemduyet=1 ORDER BY tintuc.ngaycapnhat DESC ", GetSQLValueString("%" . $KTColParam1_rs_ketquatimkiem . "%", "text"),GetSQLValueString("%" . $KTColParam1_rs_ketquatimkiem . "%", "text"));
$query_limit_rs_ketquatimkiem = sprintf("%s LIMIT %d, %d", $query_rs_ketquatimkiem, $startRow_rs_ketquatimkiem, $maxRows_rs_ketquatimkiem);
$rs_ketquatimkiem = mysql_query($query_limit_rs_ketquatimkiem, $conn_vietchuyen) or die(mysql_error());
$row_rs_ketquatimkiem = mysql_fetch_assoc($rs_ketquatimkiem);

if (isset($_GET['totalRows_rs_ketquatimkiem'])) {
  $totalRows_rs_ketquatimkiem = $_GET['totalRows_rs_ketquatimkiem'];
} else {
  $all_rs_ketquatimkiem = mysql_query($query_rs_ketquatimkiem);
  $totalRows_rs_ketquatimkiem = mysql_num_rows($all_rs_ketquatimkiem);
}
$totalPages_rs_ketquatimkiem = ceil($totalRows_rs_ketquatimkiem/$maxRows_rs_ketquatimkiem)-1;

$queryString_rs_ketquatimkiem = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rs_ketquatimkiem") == false && 
        stristr($param, "totalRows_rs_ketquatimkiem") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rs_ketquatimkiem = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rs_ketquatimkiem = sprintf("&totalRows_rs_ketquatimkiem=%d%s", $totalRows_rs_ketquatimkiem, $queryString_rs_ketquatimkiem);

$TFM_LimitLinksEndCount = 5;
$TFM_temp = $pageNum_rs_ketquatimkiem + 1;
$TFM_startLink = max(1,$TFM_temp - intval($TFM_LimitLinksEndCount/2));
$TFM_temp = $TFM_startLink + $TFM_LimitLinksEndCount - 1;
$TFM_endLink = min($TFM_temp, $totalPages_rs_ketquatimkiem + 1);
if($TFM_endLink != $TFM_temp) $TFM_startLink = max(1,$TFM_endLink - $TFM_LimitLinksEndCount + 1);

?>
<?php if ($totalRows_rs_ketquatimkiem > 0) { // Show if recordset not empty ?>
  <section class="ketquatimkiem">
    <header class="ketquatim_title">Kết quả tìm tử khóa "<span class="chudam"><?php echo $_GET['keyword']; ?></span>"</header>
    <?php do { ?>
      <article class="ketquatim_baiviet">
      		<a href="<?=$url?>cat<?=$row_rs_ketquatimkiem['ID_theloai'];?>/detail<?=$row_rs_ketquatimkiem['ID_tintuc'];?>/<?=vietdecode($row_rs_ketquatimkiem['tieudetin']);?>.html">
        <!--<a href="layout_chitiettin.php?cat=<?php echo $row_rs_ketquatimkiem['ID_theloai']; ?>&id=<?php echo $row_rs_ketquatimkiem['ID_tintuc']; ?>">-->
        	<img class="canhlechohinh" src="images/<?php echo $row_rs_ketquatimkiem['hinhtrichdan']; ?>" width="150" height="110" alt="<?php echo $row_rs_ketquatimkiem['tieudetin']; ?>"></a>
      <h1><span class="linkden">
      		<a href="<?=$url?>cat<?=$row_rs_ketquatimkiem['ID_theloai'];?>/detail<?=$row_rs_ketquatimkiem['ID_tintuc'];?>/<?=vietdecode($row_rs_ketquatimkiem['tieudetin']);?>.html">
      	<!--<a href="layout_chitiettin.php?cat=<?php echo $row_rs_ketquatimkiem['ID_theloai']; ?>&id=<?php echo $row_rs_ketquatimkiem['ID_tintuc']; ?>">-->
            <?php 
				$result = search_highlight($searchstring,"<span style='background-color:yellow'><b>$searchstring</b></span>",$row_rs_ketquatimkiem['tieudetin']); 
				if($result === false){
					echo $row_rs_ketquatimkiem['tieudetin'];
				}else{
					echo $result;
				}
				?>
             </a></span>
        </h1>
          <p class="date-time"><?php echo date('G:i', strtotime($row_rs_ketquatimkiem['ngaycapnhat'])); ?> ngày <?php echo date('d/m/Y', strtotime($row_rs_ketquatimkiem['ngaycapnhat'])); ?></p>
          <p class="date-time">
          	<span class="linkcam">
          	<!--<a href="layout_theloai.php?cat=<?php echo $row_rs_ketquatimkiem['ID_theloai']; ?>"><?php echo $row_rs_ketquatimkiem['tentheloai']; ?></a>-->
            
            <a href="<?=$url?><?php echo $row_rs_ketquatimkiem['keyword']; ?>.html"><?php echo $row_rs_ketquatimkiem['tentheloai']; ?></a>
            
            </span>&nbsp;<span class="linkden">
            	<!--<a href="layout_theloaitin.php?cat=<?php echo $row_rs_ketquatimkiem['ID_theloai']; ?>&subcat=<?php echo $row_rs_ketquatimkiem['ID_theloaitin']; ?>"><?php echo $row_rs_ketquatimkiem['tentheloaitin']; ?></a>-->        
                <a href="<?=$url?>menu<?php echo $row_rs_ketquatimkiem['ID_theloai']; ?>/menu<?php echo $row_rs_ketquatimkiem['ID_theloaitin']; ?>/<?php echo vietdecode($row_rs_ketquatimkiem['tentheloaitin']); ?>.html"><?php echo $row_rs_ketquatimkiem['tentheloaitin']; ?></a>
           	</span>
           </p>
          <p>	
		 	 <?php 
			 $result = search_highlight($searchstring,"<span style='background-color:yellow'><b>$searchstring</b></span>",$row_rs_ketquatimkiem['trichdantin']); 
				if($result === false){
					echo $row_rs_ketquatimkiem['trichdantin'];
				}else{
					echo $result;
				}
				?>
          </p>
      </article>
      <?php } while ($row_rs_ketquatimkiem = mysql_fetch_assoc($rs_ketquatimkiem)); ?>
      <section class="ketquatim_info"> 
    	<span class="chudam">Records <?php echo ($startRow_rs_ketquatimkiem + 1) ?> to <?php echo min($startRow_rs_ketquatimkiem + $maxRows_rs_ketquatimkiem, 			$totalRows_rs_ketquatimkiem) ?> of <?php echo $totalRows_rs_ketquatimkiem ?> 
        </span>
    </section>
    <section class="phantrang">
      <p class="boxes">
        <?php
						$TFM_Previous = $pageNum_rs_ketquatimkiem - 5;
						if ($TFM_Previous >= 0) {
						   printf('...<a href="'."%s?pageNum_rs_ketquatimkiem=%d%s", $currentPage, $TFM_Previous, $queryString_rs_ketquatimkiem.'">');
						   echo "[Previous "."5"." pages] </a>...";
						   //Basic-UltraDev Previous X pages SB
						}
            		?>
        <?php
				for ($i = $TFM_startLink; $i <= $TFM_endLink; $i++) {
				  $TFM_LimitPageEndCount = $i -1;
				  if($TFM_LimitPageEndCount != $pageNum_rs_ketquatimkiem) {
					printf('<a href="'."%s?pageNum_rs_ketquatimkiem=%d%s", $currentPage, $TFM_LimitPageEndCount, $queryString_rs_ketquatimkiem.'">');
					echo "$i</a>";
				  }else{
					echo "<span class=current>$i</span>";
				  }
				if($i != $TFM_endLink) echo(" ");}
        		?>
        <?php
				$TFM_Next = $pageNum_rs_ketquatimkiem + 5;
				$TFM_Last = $totalPages_rs_ketquatimkiem+1;
				if ($TFM_Next - 1 < $totalPages_rs_ketquatimkiem) { 
				  printf('...<a href="'."%s?pageNum_rs_ketquatimkiem=%d%s", $currentPage, $TFM_Next, $queryString_rs_ketquatimkiem.'">');
					echo "[Next "."5"." of ".$TFM_Last." pages] </a>...";
				}
        	   ?>
      </p>
    </section>
  </section>
  <?php } // Show if recordset not empty ?>
<?php if ($totalRows_rs_ketquatimkiem == 0) { // Show if recordset empty ?>
                <section class="search_error">Không tìm thấy kết quả nào. hãy thử tìm lại</section>
                <?php } // Show if recordset empty ?>
<?php
mysql_free_result($rs_ketquatimkiem);
?>
