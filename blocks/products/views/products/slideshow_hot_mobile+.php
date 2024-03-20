<?php
global $tmpl,$config; 
$tmpl -> addStylesheet('slideshow_hot_mobile','blocks/products/assets/css');
FSFactory::include_class('fsstring');
?>

<?php if(isset($list) && !empty($list)){?>
	<div class="products_blocks_wrapper  block slideshow-hot">
		<div class="slideshow-hot-list products_blocks_slideshow_hot cls">
			<?php foreach($list as $item){?>
				<?php $link = FSRoute::_("index.php?module=products&view=product&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias.'&cid='.$item -> category_id); ?>
				<div class="item" >
					<div class="frame_inner">
						<figure class="product_image "  >
							<?php $image_small = str_replace('/original/', '/resized/', $item->image); ?>
							<a href="<?php echo $link;?>" title='<?php echo htmlspecialchars($item->name);?>'  itemprop="url">
								<img itemprop="image" alt="<?php echo htmlspecialchars($item->name);?>" src="<?php echo URL_ROOT.$image_small;?>"  />
							</a>
							
						</figure>
						
						<h2><a href="<?php echo $link; ?>" title = "<?php echo $item -> name ; ?>" class="name" >
			  				<?php echo FSString::getWord(15,$item -> name); ?>
			        	</a></h2>	

						<div class='price_arae'>
					  		<div class='price_current'><?php echo format_money($item -> price).''?></div>
				        
			            	
		            	</div>

		            

		            	<?php $accessories = substr($item -> accessories, strpos($item -> accessories, "<p"), strpos($item -> accessories, "</p>")+4); ?>
						<?php $accessories = str_replace('<p>-', '<p>', $accessories ); ?>
						<?php $accessories = str_replace('<p>&bull;', '<p>', $accessories ); ?>
						
						<div class="summary_inner">
							
		            		<?php echo  $accessories;?>
		            		
	            		</div>
					</div>	
				</div>

			<?php }?>

		</div>
	</div>		
<?php }?>
