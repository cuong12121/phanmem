<?php  	global $tmpl;
$tmpl -> addStylesheet('detail','modules/services/assets/css');
//$tmpl -> addScript('detail','modules/contents/assets/js');
FSFactory::include_class('fsstring');

$print = FSInput::get('print',0);
?>
<div class="content_inner">
<div class="content_detail wapper-page wapper-page-detail" itemscope="" itemtype="https://schema.org/Product">
<meta itemprop="url" content="<?php echo URL_ROOT.substr($_SERVER['REQUEST_URI'],1); ?>">

		<!-- CONTENT NAME-->

		<h1 class='page_title' itemprop="name">
			<span><?php	echo $data -> title; ?></span>
			
		</h1>
		
		<?php  include_once 'default_base_rated_fixed.php'; ?>

<!-- PRICE -->
		<div class='price cls' itemprop="offers" itemscope="" itemtype="https://schema.org/AggregateOffer">

			<link itemprop="availability" href="https://schema.org/InStock">
			<meta itemprop="lowPrice" content="<?php echo $data -> maxPrice; ?>">
			<meta itemprop="highPrice" content="<?php echo $data -> minPrice; ?>">
			<meta itemprop="priceCurrency" content="VND">

		</div>


<!-- PRICE -->


<!-- 		<img src="<?php echo URL_ROOT.str_replace('/original/', '/original/', $data -> image); ?>" longdesc="<?php echo URL_ROOT.str_replace('/original/', '/original/', $data -> image); ?>" alt="<?php echo $data -> title; ?>"  class="hidden"  itemprop="image" /> -->


		<div class='description'>
			<?php   echo $data -> content; ?>
		</div>

		<?php include_once 'default_share.php'; ?>

		
		<div id="prodetails_tab30" class="prodetails_tab">
        	<div class='tab_content_right'>
        		<?php 	include 'plugins/comments/controllers/comments.php'; ?>
        		<?php $pcomment = new CommentsPControllersComments(); ?>
				<?php		$pcomment->display($data); ?>
        		<?php 	include 'default_comments_fb.php'; ?>
        	</div>
   		</div>

   		</div>

</div>

