<?php
global $tmpl; 
$tmpl -> addStylesheet('owl.carousel','libraries/jquery/owl.carousel.2/assets');
//$tmpl -> addStylesheet('owl.theme','libraries/jquery/owl.carousel');

$tmpl -> addScript('owl.carousel.min','libraries/jquery/owl.carousel.2');
//$tmpl -> addScript('progress_bar','libraries/jquery/owl.carousel');
//$tmpl -> addScript('progress_bar','libraries/jquery/owl.carousel');
//$tmpl -> addScript('slideshow','blocks/slideshow/assets/js');
$tmpl -> addScript('products','blocks/products/assets/js');
$tmpl -> addStylesheet('products','blocks/products/assets/css');
FSFactory::include_class('fsstring');
?>
<?php if(isset($list) && !empty($list)){?>
	<div class="products_blocks_wrapper hide1 block slideshow-home">
		<div class="slideshow-home-list products_blocks_slideshow"  id="<?php echo "products_blocks_slideshow_".$identity; ?>">
			<?php foreach($list as $item){?>
				<?php $link = FSRoute::_("index.php?module=products&view=product&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias.'&cid='.$item -> category_id); ?>
				<div class="slideshow-home-item item" >
					<div class="product_image">
						<a href="<?php  echo $link;?>" title="<?php echo $item -> name; ?>"  rel="nofollow" >
							<img src="<?php echo URL_ROOT.str_replace('/original/','/resized/',$item->image);?>"  alt="<?php $item->name;?> " />
						</a>	
					</div>
					<div class="frame_title">
						<h2>	<a href="<?php  echo $link;?>" title="<?php echo $item -> name; ?>"  ><span><?php echo get_word_by_length( 50,$item -> name,'...');?></span></a></h2>
					</div>
					<div class="frame_price">
						<span class="price"><?php echo  format_money($item -> price); ?></span>
						<?php if($item -> price_old){ ?>
							<span class="old_price "><?php echo  format_money($item -> price_old); ?></span>
						<?php }?>
						<div class="clear"></div> 
					</div>
					<p class="shiped">Miễn phí vận chuyển</p>
					<?php if($item -> quality){ ?>
						<p><?php echo $item -> quality; ?></p>
					<?php } ?>
				</div>
				
			<?php }?>
			
		</div>
	</div>		
<?php }?>
