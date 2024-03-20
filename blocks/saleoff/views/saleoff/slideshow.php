<?php
global $tmpl; 
	$tmpl -> addScript('jquery.carouFredSel-6.0.4-packed','libraries/responsive/coolcarousel');
	$tmpl -> addScript('products','blocks/products/assets/js');
	$tmpl -> addStylesheet('products','blocks/products/assets/css');
	FSFactory::include_class('fsstring');
	?>
<?php if(isset($list) && !empty($list)){?>
	<div class="products_blocks_wrapper hide block">
		<div class="frame_head">
			<span><?php echo $title; ?></span>
		</div>
		<div class="frame_body">
			<div class="products_blocks products_blocks_slideshow" id="<?php echo "products_blocks_slideshow_".$identity; ?>" >
				<div id="wrapper">
					<div id="carousel">
			        	<?php foreach($list as $item){?>
			        		<?php $link = FSRoute::_("index.php?module=products&view=product&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias."&cid=".$item-> category_id); ?>
			            	<div  class='item'>
			            		<div class='item_inner'>
				            		<a href="<?php  echo $link;?>" title="<?php echo $item -> name; ?>"  rel="nofollow" >
						            	<img src="<?php echo URL_ROOT.str_replace('/original/','/resized/',$item->image);?>"  alt="<?php $item->name;?> " />
						            </a>	
				                   	<a href="<?php  echo $link;?>" title="<?php echo $item -> name; ?>"  ><span><?php echo get_word_by_length( 50,$item -> name,'...');?></span></a>
				                   	<p class='author'>Người đăng: <span><?php echo $item -> user_full_name; ?></span> </p>
				                   	<p class='hit_download'>Lượt tải: <span><?php echo $item -> download; ?></span> | Lượt xem:  <span><?php echo $item -> hits; ?></span> </p>
				                   	<p class='assess hide'>Đánh giá: <span><?php echo $item -> download; ?></span> | Lượt xem:  <span><?php echo $item -> hits; ?></span> </p>
				                   	
				                   	<div class='rate'>
										<?php $point = $item -> rating_count ? round($item -> rating_sum /$item -> rating_count): 0 ; ?>
										<span id="statistics_ratesp">Đánh giá:</span>
										<?php for($i = 0; $i < 5;$i ++){?>
											<?php if($point > $i){?>
												<img alt="star on" src="<?php echo URL_ROOT.'blocks/products/assets/images/star-on.png'?>" />
											<?php }else{?>
												<img alt="star off" src="<?php echo URL_ROOT.'blocks/products/assets/images/star-off.png'?>" /> 
											<?php }?>
										<?php }?>
									</div>
								</div>
			                  </div>
			             <?php }?>	
					</div>
				</div>
				<a id="products_prev_<?php echo $identity; ?>" class="products_prev" href="#"></a>
				<a id="products_next_<?php echo $identity; ?>" class="products_next" href="#"></a>
			</div>		
		</div>		
	</div>		
 <?php }?>
 
 	
