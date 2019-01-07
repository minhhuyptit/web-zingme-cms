<?php require_once("Connections/conn_vietchuyen.php"); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /><!--Khi chạy trên di động cần dòng này-->
<?php include("seo_keyword.php"); ?>
<style>
#sticky {
 height:50px; /* chiều cao của menu*/
 width:100%; /* độ rộng của menu*/
 position:relative;
 z-index:9999999999;
}
</style>
<link rel="stylesheet" type="text/css" href="<?=$url?>css/style1.css">

<!--Start Menu CSS and Javascript-->
<link rel="stylesheet" type="text/css" href="<?=$url?>menu/css/flatmenu.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?=$url?>menu/css/font-awesome.min.css"  />
<link rel="stylesheet" media="screen,projection" href="<?=$url?>css/ui.totop.css" />
<script type="text/javascript" src="jQuery/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="scripts/flatmenu-responsive.js"></script><!--Tác dụng menu khi ỏ các kích thước di động, tablet-->
<!--End Menu CSS-->

	<!-- CSS -->
	<link rel="stylesheet" href="<?=$url?>everslider/css/everslider.css">
	<link rel="stylesheet" href="<?=$url?>everslider/css/everslider-custom.css">
	<!-- JavaScript -->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script type="text/javascript" src="<?=$url?>everslider/js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="<?=$url?>everslider/js/jquery.mousewheel.js"></script>
	<script type="text/javascript" src="<?=$url?>everslider/js/jquery.everslider.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){			
			/* Fullwidth slider */
			$('#fullwidth_slider').everslider({
				mode: 'carousel',
				moveSlides: 1,
				slideEasing: 'easeInOutCubic',
				slideDuration: 700,
				navigation: true,
				keyboard: true,
				nextNav: '<span class="alt-arrow">Next</span>',
				prevNav: '<span class="alt-arrow">Next</span>',
				ticker: true,
				tickerAutoStart: true,
				tickerHover: true,
				tickerTimeout: 2000
			});
		});
	</script>
    
    <!--Start Khu vực Scroll-->
	<script src="<?=$url?>js/jquery.nicescroll.js"></script>

	<script>
	  $(document).ready(function() {
		var nice = $("html").niceScroll();  // The document page (body)
	  });
	</script>
	<!--End Khu vực Scroll-->
</head>

<body>
<!--Start Sticky-->	
<script>
var $stickyHeight = 50; // chiều cao của menu
var $padding = 0; // khoảng cách top của menu khi dính
var $topOffset = 30; // khoảng cách từ top của menu khi bắt đầu dính (tức là khoảng cách tính từ trên xuống đến vị trí đặt menu )
var $footerHeight = 0; // Định vị điểm dừng của menu, tính từ chân lên 
/* <![CDATA[ */
function scrollSticky(){
 if($(window).height() >= $stickyHeight) {
     var aOffset = $('#sticky').offset();
if($(document).height() - $footerHeight - $padding < $(window).scrollTop() + $stickyHeight) {
         var $top = $(document).height() - $stickyHeight - $footerHeight - $padding - 0;
         $('#sticky').attr('style', 'position:absolute; top:'+$top+'px;');

     }else if($(window).scrollTop() + $padding > $topOffset) {
         $('#sticky').attr('style', 'position:fixed; top:'+$padding+'px;');
}else{
         $('#sticky').attr('style', 'position:relative;');
     }
 }
}
$(window).scroll(function(){
 scrollSticky();
});
</script>
<!--End Sticky-->	

  <!--Start Header-->
  <header class="header_top">
   	<section class="wrapper_header">
        <section class="logo">
        	<?php include("inc_logo.php"); ?>
        </section>
        <section class="search">
            <?php include("form_search.php"); ?>
        </section>
        <section class="bookmark">
        	<?php include("inc_bookmark.php"); ?>
        </section>
        <section class="choose_style">
            <?php include("inc_choose_style.php"); ?>
        </section>
    </section>
  </header>
  <!--End Header-->
  
  <!--Start Menu-->
  <div id="sticky">
  <section class="bg_menungang">
  		<section class="wrapper_menu">
        	<?php include("menu.php"); ?>
        </section>
  </section>
  </div>
  <!--End Menu-->
  
<section class="wrapper">
  <section class="banner">
    <?php include("inc_banner.php"); ?>
  </section>
  <section class="content"> 
    <!--Start Content Left-->
    <section class="content_left"> 
      <!--Start Tin tức mới-->
      <?php include("tintucmoi.php"); ?>
      <!--End Tin tức mới--> 
      
      <!--Start Bài ảnh & Video-->
      <?php include("baianhvideo.php"); ?>
      <!--End Bài ảnh & Video--> 
      
      <!--Start Tin mới theo thể loại-->
 	  <?php include("tintucmoitheloai.php"); ?>
      <!--End Tin mới theo thể loại--> 
      
      <!--Start Blog-->
       <?php include("blog.php"); ?>
   	  <!--End Blog-->
      
      <!--Start Gameonline--> 
       <?php include("gameonline.php"); ?>
      <!--End Gameonline--> 
      
    </section>
    <!--End Content Left-->
    <aside class="content_right">
      <section class="quangcao"> 
          <?php include("quangcao.php"); ?>
      </section>
      
      <!--Start Tin ảnh-->
      	<?php include("tinanh.php"); ?>
       <!--End Tin ảnh-->
      
      <!--Start tin đọc nhiều-->
		<?php include("tindocnhieu.php"); ?>
      <!--End tin đọc nhiều-->
      
      <!--Start các chuyên đề mới-->
      	<?php include("cacchuyendemoi.php"); ?>
      <!--End các chuyên đề mới-->
      
      <!--Start Facebook-->
      	<?php include("inc_facebook.php"); ?>
      <!--End Facebook-->
    </aside>
  </section>
  
  <!--Start Sitemap-->
  	<?php include("sitemap.php"); ?>
  <!--End Sitemap--> 
</section>

<!--Start Footer-->
	<?php include("inc_footer.php"); ?>
<!--End Footer-->

<!--Start To Top-->	
	<script src="<?=$url?>js/jquery.ui.totop.js" type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function() {
	
			/*var defaults = {
	  			containerID: 'toTop', // fading element id
				containerHoverID: 'toTopHover', // fading element hover id
				scrollSpeed: 1200,
				easingType: 'linear' 
	 		};*/
			$().UItoTop({ easingType: 'easeOutQuart' });
		});
	</script>
<!--End To Top-->	

</body>
</html>
