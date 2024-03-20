<?php  	global $tmpl;

$tmpl -> addScript('unitegallery.min','modules/images/assets/js');

$tmpl -> addScript('ug-theme-tiles','modules/images/assets/js');
$tmpl -> addScript('detail','modules/images/assets/js');
$tmpl -> addStylesheet('unite-gallery','modules/images/assets/css');
$tmpl -> addStylesheet('detail','modules/images/assets/css');


FSFactory::include_class('fsstring');

$print = FSInput::get('print',0);
?>
<div class="images_detail wapper-page wapper-page-detail" itemscope="" itemtype="https://schema.org/Product">
<meta itemprop="url" content="<?php echo URL_ROOT.substr($_SERVER['REQUEST_URI'],1); ?>">


		<!-- CONTENT NAME-->

		<h1 class='page_title' itemprop="name">
			<span><?php	echo $data -> name; ?></span>
			
		</h1>
		<?php  include_once 'default_base_rated_fixed.php'; ?>

		
		<?php if ($data -> summary){ ?>
			<div class='summary'>
			<?php   echo $data -> summary; ?>
		</div>
		<?php } ?>

			
		<div class='clear'></div>
			<?php  include_once 'list_images.php'; ?>
			
		<div class='clear'></div>

		<div id="prodetails_tab30" class="prodetails_tab">
        	<div class='tab_content_right'>
        		<?php 	include 'plugins/comments/controllers/comments.php'; ?>
        		<?php $pcomment = new CommentsPControllersComments(); ?>
				<?php		$pcomment->display($data); ?>
        		<?php 	include 'default_comments_fb.php'; ?>
        	</div>
   		</div>

</div>

