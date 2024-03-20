<?php  	global $tmpl,$config;

$total_relative = count(@$relate_products_list);
$Itemid = 6;
$noWord = 80;
FSFactory::include_class('fsstring');
$tmpl -> addStylesheet('product','modules/products/assets/css');
$tmpl -> addStylesheet('plugin_animate.min','libraries/jquery/owl.carousel.2/assets');


// rating
//$tmpl -> addScript('jquery-ui','libraries/jquery/jquery.ui');
//$tmpl -> addScript('jquery.ui.stars','libraries/jquery/jquery.ui.stars/js');
//$tmpl -> addStylesheet('jquery.ui.stars','libraries/jquery/jquery.ui.stars/css');


$tmpl -> addScript('main');
$tmpl -> addScript('form');

// magiczoom
$tmpl -> addStylesheet('owl.carousel','libraries/jquery/owl.carousel.2/assets');
$tmpl -> addScript('owl.carousel.min','libraries/jquery/owl.carousel.2');
$tmpl -> addStylesheet('magiczoomplus','libraries/jquery/magiczoomplus');
$tmpl -> addScript('magiczoomplus','libraries/jquery/magiczoomplus');
$tmpl -> addScript('product_images_magiczoom','modules/products/assets/js');
$tmpl -> addStylesheet('product_images_magiczoom','modules/products/assets/css');

$tmpl -> addStylesheet('note8','modules/products/assets/css/langdingpage/');

$tmpl -> addScript('note8','modules/products/assets/js/landingpage');
//$tmpl -> addScript('shopcart','modules/products/assets/js');
$tmpl -> addScript("jquery.autocomplete","blocks/search/assets/js");
$tmpl -> addScript("jquery.lazy.iframe.min","libraries/jquery/jquery.lazy/plugins");
$tmpl -> addScript('product','modules/products/assets/js');
$tmpl -> addScript3('https://apis.google.com/js/platform.js');


?>
<section class=" section section1 cls">
	<div class="container">
		<div class="left">
			<img alt="<?php echo $data -> name; ?>" src="/modules/products/assets/images/note8/titlepre.png" /> 
		</div>
		<div class="right">
			<img alt="<?php echo $data -> name; ?>" src="/modules/products/assets/images/note8/quamoi4.png" /> 
		</div>
	</div>

</section>
<section class=" section section2 cls">
	<div class="container">
		<div class="left left-img">
			<img alt="<?php echo $data -> name; ?>" src="/modules/products/assets/images/note8/elite.png" /> 
		</div>
		<div class="left text-right">
			<ul>
				<li>Phòng chờ hạng thương gia</li>	
				<li>Uống café và xem phim miễn phí vào thứ 7 hàng tuần</li>	
				<li>Đặc quyền 1 đổi 1</li>	
				<li>1 năm bảo hiểm rơi vào nước</li>	
				<li class='small'>Chi tiết công bố vào 13/09</li>	
			</ul>
		</div>
	</div>

</section>
<section class=" section section3 cls">
	<div class="container">
		<div class="title">Màn Hình Vô Cực thu Trọn Cuộc Sống</div>
		<div class="summary">Màn hình lớn với kích thước rộng hơn để trải nghiệm những điều tuyệt vời hơn. Galaxy Note8 với màn hình rộng 6.3 inch, phá vỡ mọi khuôn khổ giới hạn. Đây là màn hình lớn nhất trên các dòng Galaxy Note, nhưng vẫn thật vừa vặn trong lòng bàn tay.</div>

		<div class="f_container">
			<figure class="video-figure planet" data-media-v4-ogv="//image.samsung.com/vn/smartphones/galaxy-note8/videos/note8-design.ogv" data-media-v4-mp4="//image.samsung.com/vn/smartphones/galaxy-note8/videos/note8-design.mp4" data-media-v4-webm="//image.samsung.com/vn/smartphones/galaxy-note8/videos/note8-design.webm" data-preload-steel="true" data-none-play="none" data-top-video="true" data-cover="//image.samsung.com/vn/smartphones/galaxy-note8/images/galaxy-note8_design_planet_start.jpg">
				<video preload="auto" muted="" playsinline="" class="playend"><source src="//image.samsung.com/vn/smartphones/galaxy-note8/videos/note8-design.mp4" type="video/mp4"><source src="//image.samsung.com/vn/smartphones/galaxy-note8/videos/note8-design.webm" type="video/webm"><source src="//image.samsung.com/vn/smartphones/galaxy-note8/videos/note8-design.ogv" type="video/ogg"></video><img alt="Hình ảnh nhật thực toàn phần khi mặt trăng sắp che phủ toàn bộ mặt trời" src="//image.samsung.com/vn/smartphones/galaxy-note8/images/galaxy-note8_design_planet.jpg" data-media-s2="//image.samsung.com/vn/smartphones/galaxy-note8/images/galaxy-note8_design_planet_m.jpg" data-media-s4="//image.samsung.com/vn/smartphones/galaxy-note8/images/galaxy-note8_design_planet.jpg" style="visibility: hidden;">
				<figcaption class="blind">Video nhật thực toàn phần</figcaption>
			<span class="hide-bg" style="opacity: 0;"><img src="//image.samsung.com/vn/smartphones/galaxy-note8/images/galaxy-note8_design_planet_start.jpg" alt=""></span></figure>
			<figure class="phone">
				<img alt="Galaxy Note8 ở chế độ màn hình ngang" src="//image.samsung.com/vn/smartphones/galaxy-note8/images/galaxy-note8_design_phone_big.png" data-media-s4="//image.samsung.com/vn/smartphones/galaxy-note8/images/galaxy-note8_design_phone_big.png">
			</figure>
		</div>
	
	</div>

</section>

<section class=" section section4 cls">
	<article class="feature-spen invisible">
		<div class="f_header-type1">
	
			<h3 class="c_tit-type1"><span>Bút S Pen. Một Phương Thức Giao Tiếp Hoàn Toàn Mới</span></h3>
			<p class="c_desc-type1">Sử dụng bút S Pen để thể hiện cá tính của bạn theo cách thật khác biệt. Vẽ các biểu tượng Emoji để thể hiện cảm xúc hoặc viết thông điệp trực tiếp lên ảnh và gửi tin nhắn dưới dạng chữ viết tay. <br>Trải nghiệm những điều ý nghĩa nhất với S Pen.</p>
		</div>	
		<div class="f_container" >
				
				<figure class="bg-img woman">
					<img alt="Hình ảnh một cô gái trên ván trượt với hình vẽ sóng lượn tạo hiệu ứng như đang trượt ván trên nước." src="//image.samsung.com/vn/smartphones/galaxy-note8/images/galaxy-note8_spen_sketch01.jpg" data-media-s1="//image.samsung.com/vn/smartphones/galaxy-note8/images/galaxy-note8_spen_sketch01_s.jpg" data-media-s2="//image.samsung.com/vn/smartphones/galaxy-note8/images/galaxy-note8_spen_sketch01_m.jpg" data-media-s4="//image.samsung.com/vn/smartphones/galaxy-note8/images/galaxy-note8_spen_sketch01.jpg">
				</figure>
				
				
				<div class="path-draw">
					<svg xmlns="http://www.w3.org/2000/svg" id="spen01" style="width: 1920px; height: 2000px;">
						<path fill="none" stroke="#000000" stroke-width="400" stroke-miterlimit="10" d="M1083.5,1780c0,0,77.166626-106.7131348,243.5-124c108.0286865-11.2272949,256-116.5,267.5-183.5"></path>
						<path fill="none" stroke="#000000" stroke-width="100" stroke-miterlimit="10" d="M669.5,1681c0,0,113.5-23.4882812,199,11.5117188"></path>
					</svg>
					<svg xmlns="http://www.w3.org/2000/svg" id="spen02">
						<path fill="none" stroke="#000000" stroke-width="300" stroke-miterlimit="10" d="M793.424,1071.526c6.277-16.195,23.308-31.781,35.112-43.71c37.685-38.083,122.95-68.778,173.888-84.29c127.497-38.828,260.236-70.508,321-193"></path>
						<path fill="none" stroke="#000000" stroke-width="100" stroke-miterlimit="10" d="M370.574,960.104c29.688-4.357,62.979-6.217,94.721-3.923c30.975,2.239,94.29-0.325,111.279,23.036"></path>
					</svg>
					<svg xmlns="http://www.w3.org/2000/svg" id="spen03" style="width: 767px; height: 931px;">
						<path fill="none" stroke="#000000" stroke-width="180" stroke-miterlimit="10" d="M448,874.25c4.622-10.011,18.038-18.313,26.52-24.613c19.136-14.213,40.832-22.519,63.844-28.045c23.851-5.727,47.879-8.945,71.488-16.159c14.183-4.334,28.754-9.252,41.653-16.669c17.534-10.082,29.62-23.144,40.494-40.014"></path>
						<path fill="none" stroke="#000000" stroke-width="50" stroke-miterlimit="10" d="M239,826.25c37.678-2.546,79.131-8.898,115,7.5"></path>
					</svg>
					<canvas width="1920" height="2000" style="display: block;"></canvas>
					<figure class="spen" style="transition: none; left: 866.84px; top: 1691.84px;">
						<img alt="Đầu bút S Pen chạm vào màn hình Vô cực của Galaxy Note8" src="//image.samsung.com/vn/smartphones/galaxy-note8/images/galaxy-note8_spen_spen.png" data-media-s1="//image.samsung.com/vn/smartphones/galaxy-note8/images/galaxy-note8_spen_spen_s.png" data-media-s2="//image.samsung.com/vn/smartphones/galaxy-note8/images/galaxy-note8_spen_spen_m.png" data-media-s4="//image.samsung.com/vn/smartphones/galaxy-note8/images/galaxy-note8_spen_spen.png">
					</figure>
				</div>
				<figure class="phone">
					<img alt="Mặt trước của Galaxy Note8 bán trong suốt ở chế độ nằm ngang cùng hình ảnh một cô gái trên ván trượt với hình vẽ sóng lượn tạo hiệu ứng như đang trượt ván trên nước." src="//image.samsung.com/vn/smartphones/galaxy-note8/images/galaxy-note8_spen_phone.png" data-media-s1="//image.samsung.com/vn/smartphones/galaxy-note8/images/galaxy-note8_spen_phone_s.png" data-media-s4="//image.samsung.com/vn/smartphones/galaxy-note8/images/galaxy-note8_spen_phone.png">
				</figure>
			</div>
	</article>
</section>	