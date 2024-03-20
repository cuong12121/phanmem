<div class="rating_area cls">
	<?php if($is_mobile){ ?>
		<span class="label_form">Chọn đánh giá</span>
	<?php }else{ ?>
		<span class="label_form">Chọn đánh giá của bạn</span>
	<?php } ?>
	
	<span id="ratings" class="cls">
		<?php $point = $data -> rating_count ? round($data -> rating_sum /$data -> rating_count): 5 ; ?>
		<?php
		// check cookies
		$disable_rating = 0;
		$str_cookies_rating = isset($_COOKIE['rating_product'])?$_COOKIE['rating_product']:'';
		if(strpos($str_cookies_rating,','.$data->id.',') !== false){
			$disable_rating = 1;
		}
		?>
		<?php for($i = 0; $i < 5;$i ++){?>
			<?php if($point > $i){?>
				<i class="icon_v1 star_on" id ="rate_<?php echo ($i+1); ?>" value="<?php echo ($i+1); ?>"></i>
			<?php }else{?>
				<i class="icon_v1 star_off"  id ="rate_<?php echo ($i+1); ?>" value="<?php echo ($i+1); ?>"></i>
			<?php }?>
		<?php }?>
		
		<input type="hidden" name='rating_disable' id='rating_disable' value='<?php echo $disable_rating;?>'>	
		<input type="hidden" name='rating_value' id='rating_value' value='5'>	
		<!-- end RATING	-->
	</span>
	<span class="rsStar hide"></span>
	
</div>