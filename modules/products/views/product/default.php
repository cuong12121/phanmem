<?php  	global $tmpl,$config,$is_mobile;

if(!empty(@$relate_products_list)) {
	$total_relative = count(@$relate_products_list);	
}
else $total_relative = 0;


$Itemid = 6;
$noWord = 80;
FSFactory::include_class('fsstring');
$tmpl -> addStylesheet('products');
$tmpl -> addStylesheet('product','modules/products/assets/css');
$tmpl -> addStylesheet('plugin_animate.min','libraries/jquery/owl.carousel.2/assets');
// $tmpl -> addStylesheet('plugin_animate.min','libraries/jquery/owl.carousel.2/assets');
$tmpl -> addStylesheet('share_facebook_coupon','modules/products/assets/css');

// rating
//$tmpl -> addScript('jquery-ui','libraries/jquery/jquery.ui');
//$tmpl -> addScript('jquery.ui.stars','libraries/jquery/jquery.ui.stars/js');
//$tmpl -> addStylesheet('jquery.ui.stars','libraries/jquery/jquery.ui.stars/css');

// $tmpl -> addScript('main');
$tmpl -> addScript('form');

// magiczoom
$tmpl -> addStylesheet('owl.carousel','libraries/jquery/owl.carousel.2/assets');
$tmpl -> addScript('owl.carousel.min','libraries/jquery/owl.carousel.2');
$tmpl -> addStylesheet('owl.carousel','libraries/jquery/owl.carousel.2/assets');
$tmpl -> addScript('owl.carousel.min','libraries/jquery/owl.carousel.2');
// $tmpl -> addStylesheet('magiczoomplus','libraries/jquery/magiczoomplus');
// $tmpl -> addScript('magiczoomplus','libraries/jquery/magiczoomplus');
$tmpl -> addScript('product_images_magiczoom','modules/products/assets/js');
$tmpl -> addStylesheet('product_images_magiczoom','modules/products/assets/css');
//$tmpl -> addScript('shopcart','modules/products/assets/js');
$tmpl -> addScript("jquery.autocomplete","blocks/search/assets/js");
$tmpl -> addScript("jquery.lazy.iframe.min","libraries/jquery/jquery.lazy/plugins");
$tmpl -> addScript('product','modules/products/assets/js');

if(!$is_mobile){
	$tmpl -> addScript('popup_video_full','modules/products/assets/js');
}else{
	$tmpl -> addScript('popup_video_full_mobile','modules/products/assets/js');
}

global $insights;
if (!$insights){ 
	// /$tmpl -> addScript3('https://apis.google.com/js/platform.js');
}

?>
<div class='product' itemscope="" itemtype="https://schema.org/Product">
	<meta itemprop="url" content="<?php echo URL_ROOT.substr($_SERVER['REQUEST_URI'],1); ?>">
	<div class="product_name  cls">
		<h1 itemprop="name"><?php echo $data -> name; ?> </h1>
		<?php  include_once 'default_base_rated_fixed.php'; ?>
		<?php if(!IS_MOBILE) { ?>
			<div class="share_top">
				<?php include 'default_share.php';?>
			</div>
		<?php } ?>


	</div>
	<div class="product_detail">	
		<div class="detail_main cls">
			<div class="detail_main_top cls">
				<div class='frame_left'>				
					<?php include_once 'images/magiczoom.php';?>			
					<?php //include 'default_share.php';?>
					<?php if(IS_MOBILE) { ?>
						<div class="share_top">
							<?php include 'default_share.php';?>
						</div>
					<?php } ?>

					<?php if(!IS_MOBILE){?>
						<?php if($data-> sets || $data-> warranty_info || $data-> change_return){?>
							<div class="products_sets">
								<div class="products_sets1">
									<div class="sets cls">
										<?php echo $data-> sets; ?>
									</div>
									<div class="clear"></div>
								</div>
								<div class="products_sets2 hide">
									<div class="sets">
										<?php echo $data-> sets2; ?>
									</div>
									<div class="warranty_info">
										<?php //echo $data-> warranty_info2; ?>
									</div>
									<div class="change_return">
										<?php //echo $data-> change_return2; ?>
									</div>
									<div class="clear"></div>
								</div>
							</div>
						<?php } ?>
					<?php } ?>
					<?php if(!IS_MOBILE){?>
						<?php if($data-> promotion_more){?>
							<div class="promotion_more">
								<div class="promotion_more1">
									<div class="title">
										<p class="t">Ưu đãi thêm</p>
										<div class="promotion_title">
											<?php echo $data-> promotion_more_note; ?>
										</div>
									</div>
									<div class="info">
										<?php echo $data-> promotion_more;?>
									</div>
								</div>
								<div class="promotion_more2 hide">
									<div class="title">
										<p class="t">Ưu đãi thêm</p>
										<div class="promotion_title">
											<?php echo $data-> promotion_more_note; ?>
										</div>
									</div>
									<div class="info">
										<?php echo $data-> promotion_more2;?>
									</div>
								</div>
							</div>
							<?php if($data-> read_more){ ?>
								<div class="read_more">
									<?php echo $data-> read_more;?>
								</div>
							<?php } ?>
						<?php }?>
					<?php } ?>
				</div>
				<div class='frame_center'>
					<?php  include_once 'default_base.php'; ?>
					<div class='compare_box compare_box_top'>
						<div class="cat-title-main" id="characteristic-label">
							<span class="compare-mb">So sánh với sản phẩm <span></span></span>
						</div>
						<input type="text" name="compare_name" id="compare_name2" placeholder="Nhập tên sản phẩm cần so sánh..." />
					</div>
				</div>			
			</div>
			<?php  //include_once 'default_accessories_compatable.php'; ?>
		</div>
	</div>
	<div class="product_detail">
		<?php if(IS_MOBILE){ ?>
			<div class="frame_left">
				<?php if($data-> sets || $data-> warranty_info || $data-> change_return){?>
					<div class="products_sets">
						<div class="products_sets1">
							<div class="sets cls">
								<?php echo $data-> sets; ?>
							</div>
							<div class="clear"></div>
						</div>
						<div class="products_sets2 hide">
							<div class="sets">
								<?php echo $data-> sets2; ?>
							</div>
							<div class="warranty_info">
								<?php //echo $data-> warranty_info2; ?>
							</div>
							<div class="change_return">
								<?php //echo $data-> change_return2; ?>
							</div>
							<div class="clear"></div>
						</div>
					</div>
				<?php } ?>
			</div>

			<div class="frame_center">
				<?php if($data-> promotion_more){?>
					<div class="promotion_more">
						<div class="promotion_more1">
							<div class="title">
								<p class="t">Ưu đãi thêm</p>
								<div class="promotion_title">
									<?php echo $data-> promotion_more_note; ?>
								</div>
							</div>
							<div class="info">
								<?php echo $data-> promotion_more;?>
							</div>
						</div>
						<div class="promotion_more2 hide">
							<div class="title">
								<p class="t">Ưu đãi thêm</p>
								<div class="promotion_title">
									<?php echo $data-> promotion_more_note; ?>
								</div>
							</div>
							<div class="info">
								<?php echo $data-> promotion_more2;?>
							</div>
						</div>
					</div>
					<?php if($data-> read_more){ ?>
						<div class="read_more">
							<?php echo $data-> read_more;?>
						</div>
					<?php } ?>
				<?php }?>
			</div>
		<?php } ?>
		<div class="banner_pro">
			<?php if($tmpl->count_block('pos6')) {?>
				<div class="pos6">
					<div class="container">
						<?php  echo $tmpl -> load_position('pos6','XHTML2'); ?>
					</div>
				</div>
			<?php }?>
<!-- 			<?php if($data->banner){
				// echo set_image_webp($data->banner,'compress',@$data->name,'','','');
}?> -->
</div>
</div>

<div class="clear"></div>

<?php if($tmpl->count_block('pos1')) {?>
	<div class="pos1_product">
		<?php  echo $tmpl -> load_position('pos1','XHTML2'); ?>
	</div>
<?php }?>
<div class="products_bottom cls">
	<div class="product_detail_l">
		<div class="detail_main_bot">
			<div class="cls">
				<?php 
				$check_ts_new = 0;
				$check_ts = 0;
				if(!empty($ext_fields)){
					foreach($ext_fields as $item){
						$field_name = $item -> field_name;
						$field_type = $item -> field_type;
						if(isset($extend->$field_name) && $extend->$field_name){
							$check_ts_new = 1;
							$check_ts = 1;
						}
					}
				}
				if($relate_tutorial){
					$check_ts_new = 1;
				}
				?>

				<div class="frame_b_l <?php echo $check_ts_new == 0 ? "frame_b_l_full1" : "" ?>">
					<?php if($check_ts_new) { ?>
						<div class="default_characteristic_mobile">
							<?php include 'default_characteristic.php'; ?>
						</div>					
					<?php } ?>
					<?php  	include_once 'default_tabs_horizontal.php'; ?>
					<?php 	include_once 'default_compare.php'; ?>
					<?php  //include_once 'default_buttons2.php'; ?>
					<?php  	include_once 'default_quick_order.php'; ?> 



					<?php 
					if(!empty($products_in_manufactory)) {
						$title_relate =  'Sản phẩm cùng hãng sản xuất';
						$list_related = $products_in_manufactory;
					} else {
						$title_relate =  'Sản phẩm khác';
						$list_related = $relate_products_list;
					}


					if(!empty($list_related)){
						echo '<div class="product_tabs_t detail-slide-pro">';
						include 'related/default_related.php';
						echo '</div>';
					}
					?>


					<div class="product_tabs_t rate-comment-plugin" id="c_tabs_rates">
						<div class="tab-title tab-title-2 cls">
							<div class="cat-title-main" id="">
								<h3><span>Đánh giá <span title="tt_main_color">sản phấm</span></span></h3>
							</div>
						</div>

						<div id="prodetails_tab3" class="prodetails_tab">
							<div class='tab_content_right'>
								<?php   include 'plugins/rates/controllers/rates.php'; ?>
								<?php $rates = new RatesPControllersRates(); ?>
								<?php $rates->display($data); ?>
							</div>
						</div>

						<div id="prodetails_tab20" class="prodetails_tab">
							<div class='tab_content_right'>
								<?php 	include 'plugins/comments/controllers/comments.php'; ?>
								<?php $pcomment = new CommentsPControllersComments(); ?>
								<?php		$pcomment->display($data); ?>
								<?php 	//include 'default_comments_fb.php'; ?>
							</div>
						</div>

					</div>
				</div>


				<div class='clear'></div>
				<?php //echo $tmpl -> load_direct_blocks('certifications',array('style'=>'style2','manuid'=>$data->manufactory)); ?>
				<?php //include_once 'list_video_review.php'; ?> 

			</div>
		</div>
	</div>
	<div class="product_detail_r">
		<div class="default_characteristic_pc">
			<?php 
			if($check_ts == 1){
				include 'default_characteristic.php';
			}
			?>
		</div>


		<?php if(!empty($relate_tutorial)){ ?>
			<?php 	
			$title_relate =  'Tin tức về '.$data-> name;
			$relate_type = 3;
			$list_related = $relate_tutorial;
			$blanks = 0;
			include 'news_related/vertical.php';
			?>

		<?php }else{ ?>

			<?php 	
			$title_relate =  'Tin tức mới nhất ';
			$relate_type = 3;
			$list_related = $relate_news_auto;
			$blanks = 0;
			include 'news_related/vertical.php';
			?>

		<?php } ?>
	</div>
</div>


<div class='clear'></div>
<input type="hidden" value="<?php echo $data->id; ?>" name='product_id' id='product_id'  />

<div class="tabs-popup hide">
	<div class="container">
		<div class="menu-tab">
			<?php if(!empty($arr_group_image)){
				foreach ($arr_group_image as $key=> $group_image) { ?>
					<div class="item item_1_<?php echo $key; ?>">
						<a href="javascript:void(0)" onclick="gotoGallery(1,0,0,<?php echo $key; ?>);" id='group_image_<?php echo $group_image->id;?>' rel="image_large" class='selected' title="<?php echo $data -> name; ?>" >
							<span class="group_name"><?php echo $group_image-> name; ?></span>
						</a>
					</div>
				<?php } ?>
			<?php } ?>
			
			<?php if(!empty($arr_color_image)){
				foreach ($arr_color_image as $key=> $color_image) { ?>
					<div class="item item_2_<?php echo $key; ?>">
						<a href="javascript:void(0)" onclick="gotoGallery(2,0,0,<?php echo $key; ?>);" id='group_image_<?php echo $color_image->id;?>' rel="image_large" class='selected' title="<?php echo $data -> name; ?>" >
							<span class="group_name"><?php echo $color_image-> name; ?></span>
						</a>
					</div>
				<?php } ?>
			<?php } ?>
			<?php if(!empty($list_video_review)){?>
				<div class="item item_3">
					<a href="javascript:void(0)" onclick="open_popup_content(3)">
						Video
					</a>
				</div>
			<?php } ?>
			<div class="item item_1">
				<a href="javascript:void(0)" onclick="open_popup_content(1)">
					Thông số kỹ thuật
				</a>
			</div>
			<div class="item item_2">
				<a href="javascript:void(0)" onclick="open_popup_content(2)">
					Bài viết
				</a>
			</div>
			<div class="item close-tabs-popup">
				<div class="inner inner-close-tabs-popup">
					<span>Đóng</span>
					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="357px" height="357px" viewBox="0 0 357 357" style="enable-background:new 0 0 357 357;" xml:space="preserve">
						<g>
							<g id="close">
								<polygon points="357,35.7 321.3,0 178.5,142.8 35.7,0 0,35.7 142.8,178.5 0,321.3 35.7,357 178.5,214.2 321.3,357 357,321.3     214.2,178.5   "/>
							</g>
						</g>
					</svg>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="tab-popup-content hide">
	<input type="hidden" id="is_mobile" value="<?php echo $is_mobile; ?>">
	<?php if($is_mobile) { ?>
		<div class="popup-content popup-content-0 hide">
		</div>
	<?php } ?>
	<div class="popup-content popup-content-3">
		<div class="popup-content-inner">
			<?php include_once 'popup_video.php'; ?>
		</div>
	</div>
	<div class="popup-content popup-content-1 hide">
		<div class="popup-content-inner">
			<?php include_once 'default_characteristic_detail.php'; ?>
		</div>
	</div>
	<div class="popup-content popup-content-2 description hide">
		<div class="popup-content-inner">
			<?php 
			$description_new = '';
			$description = $data-> description;
			$description = str_replace('<img','<img class="lazy"',$description); 
        // $description = str_replace('<img  src=','<img data-src=',$description_img);
			$arr_data = preg_split('/(<img[^>]+\>)/i', html_entity_decode($description), -1, PREG_SPLIT_DELIM_CAPTURE); 
			foreach ($arr_data as $idata) {
				if (strpos($idata, '<img') !== false) {
					$idata = str_replace('src', 'data-src', $idata);
					$idata = str_replace('<img', '<img class="lazy2"', $idata);
					$description_new .= $idata;
				} else {
					$description_new .= $idata;
				}
			}
			?>
			<?php if($description_new) echo $description_new; else echo "Đang cập nhật!"?>
		</div>
	</div>
</div>
</div>

<script type="text/javascript">
	var product_id = '<?php echo $data -> id; ?>';
	var product_price = <?php echo $data -> price; ?>;
	var check_fb_viewcontent = 1;
</script>		
<?php 
global $insights;
		//if (!$insights){
?>

<!-- Tiep thi lai dong adword -->
<script type="text/javascript">
	var google_tag_params = {
		dynx_itemid: '<?php echo $data -> id; ?>',
		dynx_itemid2: '<?php echo $data -> id; ?>',
		dynx_pagetype: 'offerdetail',
		dynx_totalvalue: <?php echo $price; ?>,

	};
</script>


<?php 
	//	}
?>

<?php //include 'default_remarketing.php';?>

<div class="wrapper_modal_alert_2"></div>


<div class="popup-video-full">
	<div class="close" onclick="close_popup_video_full()">X</div>
	<div class="content-video">
		<div class="video">

		</div>
	</div>
	
</div>