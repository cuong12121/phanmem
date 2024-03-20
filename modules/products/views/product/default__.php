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
$tmpl -> addStylesheet('magiczoomplus','libraries/jquery/magiczoomplus');
$tmpl -> addScript('magiczoomplus','libraries/jquery/magiczoomplus');
$tmpl -> addScript('product_images_magiczoom','modules/products/assets/js');
$tmpl -> addStylesheet('product_images_magiczoom','modules/products/assets/css');
//$tmpl -> addScript('shopcart','modules/products/assets/js');
$tmpl -> addScript("jquery.autocomplete","blocks/search/assets/js");
$tmpl -> addScript("jquery.lazy.iframe.min","libraries/jquery/jquery.lazy/plugins");
$tmpl -> addScript('product','modules/products/assets/js');
global $insights;
if (!$insights){ 
	$tmpl -> addScript3('https://apis.google.com/js/platform.js');
}

?>
<div class='product' itemscope="" itemtype="https://schema.org/Product">
	<meta itemprop="url" content="<?php echo URL_ROOT.substr($_SERVER['REQUEST_URI'],1); ?>">
	<?php if(IS_MOBILE) { ?>
		<div class="product_name">
			<h1 itemprop="name"><?php echo $data -> name; ?> </h1>
			<?php  include_once 'default_base_rated_fixed.php'; ?>
			<?php if(!$is_mobile && 1==2) { include 'default_share.php'; } ?>
		</div>
	<?php } ?>
	<div class="detail_main cls">
		<div class='frame_left'>
			<?php if($data-> price_old > $data-> price) { ?>
				<span class='price_discount'><?php echo ceil(($data -> price  - $data -> price_old) * 100 / $data-> price_old);?>%</span>
			<?php }?>
			<?php if(@$data-> sale_off && 1==2) { ?>
				<span class="icon_hot">Sale</span>
			<?php } ?>
			<?php 
			if(!IS_MOBILE){
				include_once 'images/styling.php';
			}else{
				include_once 'images/mobile.php'; 
			}?>
			<?php //include_once 'default_nav_tab.php'; ?>
			<?php include 'default_share.php';?>
			<?php include 'default_orders.php';?>
		</div>
		<div class='frame_center'>
			<?php  include_once 'default_base.php'; ?>
		</div>
		<div class="clear"></div>
		<!--	Phụ kiện khuyến mại	-->
		<?php include_once 'default_accessories_compatable.php'; ?> 
		<div class="frame_b_l">
			<?php  include_once 'default_tabs_horizontal.php'; ?> 
			<?php  include_once 'default_quick_order.php'; ?> 
		</div>
	</div>
	<?php if(1==1) { ?>
		<div class='frame_right'>
			<div class="advantage">
				<div class="strengths">
					<label for="">Chế độ bảo hành</label>
					<?php echo $tmpl -> load_direct_blocks('strengths',array('style'=>'rectangle2', 'catid'=> '53')); ?>
				</div>
			</div>
			<?php if(!IS_MOBILE){ ?>
				<div class="frame_b_r">
					<!--	Phụ kiện khuyến mại	-->
					<?php //include_once 'default_accessories_compatable.php'; ?> 
					<?php if($relate_news){?>
						<div id="prodetails_tab50" class="prodetails_tab">
							<?php 	
							$title_relate =  'Tin tức';
							$relate_type = 3;
							$list_related = $relate_news;
							$blanks = 0;
							include 'news_related/vertical.php';
							?>
						</div>
					<?php }?>
				</div>
			<?php } ?>
		</div>
	<?php } ?>
	<div class='clear'></div>


<!-- <div class="sape_ma">
	<div class="streng_product">
		<?php //echo $tmpl -> load_direct_blocks('strengths',array('style'=>'rectangle4', 'catid'=> '50')); ?>
	</div>
</div> -->

<?php 
//	if(count($products_in_cat)){
//		$title_relate =  'Sản phẩm cùng danh mục';
//		$relate_type = 1;
//		$list_related = $products_in_cat;
//	
//		include 'related/rps_default_related.php';	
//	}
//	if(count($relate_products_list)){
//		$title_relate =  'Có thể bạn có cấu hình tương đương';
//		$relate_type = 2;
//		$list_related = $relate_products_list;
//		include 'related/rps_default_related.php';	
//	}
//	if(count($products_same_price)){
//		$title_relate =  'Sản phẩm có mức giá tương đương';
//		$relate_type = 3;
//		$list_related = $products_same_price;
//		include 'related/rps_default_related.php';	
//	}
?>
<div class='clear'></div>
<input type="hidden" value="<?php echo $data->id; ?>" name='product_id' id='product_id'  />
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

<?php include 'default_remarketing.php';?>

<div class="wrapper_modal_alert_2"></div>
