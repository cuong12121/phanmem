<?php
global $tmpl,$is_mobile,$config; 
$tmpl -> addStylesheet('owl.carousel','libraries/jquery/owl.carousel.2/assets');
$tmpl -> addScript('owl.carousel.min','libraries/jquery/owl.carousel.2');
$tmpl -> addStylesheet('slide2','blocks/gallery/assets/css');
$tmpl -> addScript('slide2','blocks/gallery/assets/js');
FSFactory::include_class('fsstring');
$page = 5;
?>

<p class="block_title">
	<span>
		<?php echo $title; ?>
	</span>
	<a title="Xem tất cả" href="<?php echo URL_ROOT.'hinh-anh.html' ?>" class="view-all-bl">Xem tất cả <svg fill="gray" width="10px" height="10px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M17.525 36.465l-7.071 7.07c-4.686 4.686-4.686 12.284 0 16.971L205.947 256 10.454 451.494c-4.686 4.686-4.686 12.284 0 16.971l7.071 7.07c4.686 4.686 12.284 4.686 16.97 0l211.051-211.05c4.686-4.686 4.686-12.284 0-16.971L34.495 36.465c-4.686-4.687-12.284-4.687-16.97 0z" class=""></path></svg></a>
</p>

<div class="block-gallery-slide2">
	<div class="gallery-slide2-content owl-carousel">
		<?php  $i = 0; foreach($list as $item){
			$link = FSRoute::_("index.php?module=images&view=images&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias);
		?>
			<?php if( !$i || !($i%$page) ){?>
                <div class="item ">
                    <div class="item_inner cls">
            <?php }?> 
            			<?php if( !$i || !($i%$page) ){?>
	        			<div class="gallery-item gallery-item-l">
	        				<div class="item-content">
	        					<a class="image" href="<?php echo $link; ?>" title="<?php echo $item -> name; ?>">
	        						<?php echo set_image_webp($item->image,'large',@$item->name,'owl-lazy',1,''); ?>
	        						<p><?php echo $item -> name; ?></p>
	        					</a>
	        					
	        				</div>
	        			</div>

	        			<?php }?>

	        			<?php if( !$i || !($i%$page) ){?>
	        			<div class="gallery-item gallery-item-r">
	        				 <?php $i++; continue;?>
	        			<?php }?>
		        			<div class="item-content">
		        				<a  class="image" href="<?php echo $link; ?>" title="<?php echo $item -> name; ?>">
		        					<?php echo set_image_webp($item->image,'resized',@$item->name,'owl-lazy',1,''); ?>
		        					<p><?php echo $item -> name; ?></p>
		        				</a>
		        				
		        			</div>
		        			
		        		<?php if(($i+1) == count($list) || !(($i+1)%$page) ){?>
	        			</div>
	        			<?php }?>
	        	
        			

			 	<?php if(($i+1) == count($list) || !(($i+1)%$page) ){?>
	                </div> <!-- .item_inner -->
	            </div> <!-- .item -->
	        <?php }?> 
	        <?php $i++;?>
 		<?php }?>
	</div>
	
</div>


<?php if(count($list) < 10){ ?>
</div>

</div>

<?php } ?>