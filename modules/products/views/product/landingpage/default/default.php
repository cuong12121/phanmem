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

$tmpl -> addStylesheet('default','modules/products/views/product/landingpage/default/assets/css');


$tmpl -> addScript('default','modules/products/views/product/landingpage/default/assets/js');
//$tmpl -> addScript('shopcart','modules/products/assets/js');
$tmpl -> addScript("jquery.autocomplete","blocks/search/assets/js");
$tmpl -> addScript("jquery.lazy.iframe.min","libraries/jquery/jquery.lazy/plugins");
$tmpl -> addScript('product','modules/products/assets/js');
$tmpl -> addScript3('https://apis.google.com/js/platform.js');


?>
<?php include 'default_base.php'; ?>
<?php include 'default_features.php'; ?>
<div class="container">
	<div id="prodetails_tab2" class="prodetails_tab">
			<div class="tab-title cls">
				<div class="cat-title-main" id="characteristic-label">
					<div class="title_icon"><i class="icon_v1"></i></div>
					<span>Thông số kĩ thuật</span>
				</div>
			</div>
			<div class='tab_label'><span>Thông số kĩ thuật </span><strong>của <?php echo $data -> name; ?></strong></div>
        	<div class='tab_content_right'>
        		<div class='characteristic'>
        		<?php include 'modules/' . $this->module . '/views/' . $this->view .'/default_characteristic.php';?>
            
            	</div>
          </div>
   	</div>

	<div id="prodetails_tab30" class="prodetails_tab">
        	<div class='tab_content_right'>
        		<?php 	include 'plugins/comments/controllers/comments.php'; ?>
        		<?php $pcomment = new CommentsPControllersComments(); ?>
				<?php		$pcomment->display($data); ?>
				<?php include 'modules/' . $this->module . '/views/' . $this->view .'/default_comments_fb.php';?>
        		
        	</div>
   	</div>
   	<?php include 'modules/' . $this->module . '/views/' . $this->view .'/default_quick_order.php';?>
   	

</div>
