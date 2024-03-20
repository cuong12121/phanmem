<?php
global $tmpl, $is_mobile;
$tmpl -> addStylesheet('owl.carousel','libraries/jquery/owl.carousel.2/assets');
$tmpl -> addScript('owl.carousel.min','libraries/jquery/owl.carousel.2');
$tmpl -> addStylesheet('lightbox','libraries/jquery/lightbox2/dist/css');
$tmpl -> addScript('lightbox','libraries/jquery/lightbox2/dist/js');
$tmpl -> addScript('style1','blocks/certifications/assets/js');
$tmpl -> addStylesheet('style1','blocks/certifications/assets/css');
FSFactory::include_class('fsstring');
$i = 1;

$total = count($list)
?>
<div class="certifications cls">

	<div class="title-certifications">
		<div class="tt-big">Chứng nhận</div>
		<div class="tt-small">Thương hiệu phân phối</div>
		
		<?php if(!$is_mobile){
		?>
		<a class="view-all" href="<?php echo FSRoute::_("index.php?module=certifications&view=home") ?>" class="view-all" title="xem tất cả">Xem tất cả</a>
		<?php } ?>

	</div>

	<div class="certifications-inner container">
		<div class="content-certifications owl-carousel">
		<?php foreach($list as $item){ ?>
			<?php $image = URL_ROOT.str_replace('/original/', '/resized/',$item -> image);?>
			
			<?php $class = '';?>
			<?php if($i == 1)$class .= ' first-item';?>
			<?php if($i == $total )$class .= ' last-item';?>
				<div class="box-certifications<?php echo $class;?> item">
		    		<a href="<?php echo URL_ROOT.str_replace('/original/', '/large/', $item -> image); ?>" data-lightbox="roadtrip" title="<?php $item->title;?> ">
		    			<img class="owl-lazy" data-src="<?php echo $image;?>" alt="<?php $item->title;?>" />
		    		</a>
				</div>
				<?php $i ++; ?>
		<?php }?>
		</div>
	</div>
</div>


