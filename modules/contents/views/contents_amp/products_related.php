<?php $tmpl -> addStylesheet('products'); ?>
<?php if($list_related && count($list_related)){?>

<div class="products-list-related">
    <div class='product_grid'>
    	<div class='product_grid_inner'>
	    <?php $tmp = 0; ?>
		<?php foreach($list_related as $item){ ?>
	        <?php $tmp++; ?>
				<?php $link = FSRoute::_("index.php?module=products&view=product&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias.'&cid='.$item -> category_id); ?>
        		<div  class="item" itemscope itemtype="http://schema.org/Product">	
                            <div class="frame_inner">
                            	<link itemprop="url" href="<?php echo $link; ?>" />
		        	<figure class="product_image "  >
		        		<?php $image_small = str_replace('/original/', '/resized/', $item->image); ?>
		  				<a href="<?php echo $link;?>" title='<?php echo $item->name;?>'  itemprop="url">
							<img itemprop="image" alt="<?php echo $item->name;?>" data-src="<?php echo URL_ROOT.$image_small;?>"  class="lazy"/>
						</a>
						<div class="button_area">
		            		<a href="javascript:void(0)" onclick="add_cart(<?php echo $item -> id; ?>,1)" class="add_cart">
		            			<i ></i>
		            		</a>
		            		<a href="<?php echo $link; ?>"  class="detail_button" title="Chi tiết sản phẩm">
		            			<i ></i>
		            		</a>
		            	</div>
					<div class="summary">
					
						<div class="summary_inner"  itemprop="description">
							<a href="<?php echo $link; ?>"  class="detail_button" title="Chi tiết sản phẩm">
		            			<?php echo  $item -> accessories;?>
			            		</a>
			            		</div>
            			</div>
	        	</figure>
				<h2 itemprop="name"><a href="<?php echo $link; ?>" title = "<?php echo $item -> name ; ?>" class="name" >
  				<?php echo FSString::getWord(15,$item -> name); ?>
        	</a> </h2>	
        	<div class='price_arae' itemscope itemtype="http://schema.org/Offer">
		  		<div class='price_current' itemprop="price"><?php echo format_money($item -> price).''?></div>
	        
            	<?php if( $item -> price_old && $item -> price_old > $item -> price){?>
            		<div class='price_old'><span><?php echo format_money($item -> price_old).''?></span></div>
            	<?php }?>
            	</div>
            	<?php if( $item -> price_old && $item -> price_old > $item -> price){?>
            		<div class='discount'><span><?php echo '-'.round((($item -> price_old - $item -> price) /$item -> price_old) * 100).'%'; ?></span></div>
            	<?php }?>
			<a class="button-detail" href="<?php echo $link;?>"><span >+</span></a>
			<div class="clear"></div> 
			  <?php if(count($types)){?>
		<?php $k  = 0;?>
		<?php foreach($types as $type){?>
			<?php if(strpos($item -> types,','.$type->id.',') !== false || $item -> types == $type->id){?>
				<div class='product_type product_type_<?php echo $type -> alias; ?> product_type_order_<?php echo $k; ?>'><?php echo $type -> name; ?></div>
				<?php $k ++; ?>
			<?php }?>
			
		<?php }?>
	<?php }?>  									
                            </div>   <!-- end .frame_inner -->
	                            
                           			
				<div class="clear"></div> 
			</div>
		<?php } ?>
</div><!--end: .vertical-->
</div>
</div>
<?php } ?>
