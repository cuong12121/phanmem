<div class="total_shopcart_gifts clearfix">
	<div class="label label_combo"><span>Chọn quà</span></div>
	      		<?php foreach($gifts as $gift){?>
	      			<?php $link_gift = FSRoute::_('index.php?module=products&view=product&code='.$gift -> alias.'&id='.$gift -> id.'&ccode='.$gift->category_alias);?>
	      			<?php $selected = 0; ?>
	      			<?php if(isset($gift_4_total) && $gift_4_total['price_id'] ==  $gift -> price_id){
	      					$selected = 1;} 	?>
	      			<div class="gift <?php echo $selected?'selected':''; ?>" style="width: <?php echo (100/count($gifts)).'%';?>" >
		      			<div class="gift_inner">
		      				<a href="javascript: void(0)" onclick="javascript:select_gift_4_total(this,<?php echo $gift -> product_id; ?>,<?php echo $gift -> price_id; ?>,<?php echo $sale_total_current -> id; ?>)">
				            	<figure>
				            			<img class="img-responsive" src="<?php echo URL_ROOT.str_replace('/original/', '/resized/', $gift->image); ?>" alt="<?php echo htmlspecialchars ($gift -> name); ?>"  />
				            	</figure>
						    	<h2><?php echo get_word_by_length(30,$gift -> name); ?> ( <?php echo $gift -> unit; ?> )</h2>
						    	<input type="hidden" name="gift_prd_product_id" value="<?php echo $gift -> product_id; ?>" class="gift_prd_product_id">
						    	<input type="hidden" name="gift_prd_price_id" value="<?php echo $gift -> id; ?>" class="gift_prd_price_id">
						    	<input type="hidden" name="gift_prd_name" value="<?php echo get_word_by_length(30,$gift -> name); ?> ( <?php echo $gift -> unit; ?> )" class="gift_prd_name">
						        <div class="select_gift_icon"></div>
					       	</a> 
				        </div>
			        </div>
			       <?php }?> 
      	</div>
</div>