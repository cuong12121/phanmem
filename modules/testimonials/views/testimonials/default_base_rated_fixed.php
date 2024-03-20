<span class='rate' itemprop="aggregateRating"   itemscope itemtype="http://schema.org/AggregateRating" >
	<?php $point = (($data -> id % 10)/10)+ 4 ; ?>
	<?php $ratingCount = round(($data -> id)/5) ; ?>
	<?php $reviewCount = $data -> id ; ?>
	<meta name="ratingValue"  itemprop="ratingValue" content="<?php echo $point; ?>" />
	<meta name="bestRating"  itemprop="bestRating"  content="5" />
	<meta name="ratingCount"  itemprop="ratingCount"  content="<?php echo $ratingCount; ?>" />
	<meta name="reviewCount"  itemprop="reviewCount"  content="<?php echo $reviewCount; ?>" />
	<?php for($i = 0; $i < 5;$i ++){?>
		<?php if($point > $i){?>
			<i class="icon_v1 star_on"></i>
		<?php }else{?>
			<i class="icon_v1 star_off"></i>
		<?php }?>
	<?php }?>
</span>
