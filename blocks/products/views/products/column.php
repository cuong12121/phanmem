<?php
global $tmpl, $config; 
$tmpl -> addStylesheet('column','blocks/products/assets/css');
$tmpl -> addScript('buy_add','blocks/products/assets/js');
FSFactory::include_class('fsstring');
?>
<div class="body-block-column">
	<div class="title">
		<?php echo $title; ?>
	</div>
	<?php if(isset($list) && !empty($list)){?>

		<?php foreach($list as $item){?>
			<?php $link = FSRoute::_("index.php?module=products&view=product&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias.'&cid='.$item -> category_id); ?>
				<div class="item">
					<div class="frame_inner">
						<link itemprop="url" href="<?php echo $link; ?>" />
							<figure class="product_image "  >
								<?php $image_small = str_replace('/original/', '/resized/', $item->image); ?>
								<a href="<?php echo $link;?>" title='<?php echo htmlspecialchars($item->name);?>'  itemprop="url">
									<img itemprop="image" alt="<?php echo htmlspecialchars($item->name);?>" src="<?php echo URL_ROOT.$image_small;?>"  />
								</a>
								<div class="button_area">
									<a href="javascript:void(0)" onclick="add_cart(<?php echo $item -> id; ?>,1)" class="add_cart">
										<i ></i>
									</a>
									<a href="<?php echo $link; ?>"  class="detail_button" title="Chi tiết sản phẩm">
										<i ></i>
									</a>
								</div>
								
							</figure>
							<div class="manufactory_name"><?php echo $item -> manufactory_name ?></div>
							<h2 itemprop="name">
								<a href="<?php echo $link; ?>" title = "<?php echo htmlspecialchars($item -> name) ; ?>" class="name" >
									<?php echo FSString::getWord(15,$item -> name); ?>
								</a> 
							</h2>

							<div class='price_arae' itemscope itemtype="http://schema.org/Offer">
								<div class='price_current' itemprop="price"><?php echo format_money($item -> price).''?></div>
								
								<?php if( $item -> price_old && $item -> price_old > $item -> price){?>
									<div class='price_old'><span><?php echo format_money($item -> price_old).''?></span></div>
								<?php }?>
							</div>
							
							<div class='discount'>
								<span><?php echo '-'.round((($item -> price_old - $item -> price) /$item -> price_old) * 100).'%'; ?>
								
							</span>
						</div>    
						<div class="button_od">
							<a  rel="nofollow" href="javascript:void(0)" class="add_cart"  onclick="buy_add(<?php echo $item -> id; ?>)">
								<button type=""><?php echo $config['iconcart'] ?></button>
							</a>
						</div>	
						
						
						<div class="clear"></div> 
						
					</div>   <!-- end .frame_inner -->
					
				</div>



		<?php }?>

	<?php }?>
</div>