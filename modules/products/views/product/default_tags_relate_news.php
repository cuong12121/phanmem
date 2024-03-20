<?php FSFactory::include_class('fsstring');
$total_news = count($news_relate_tags);
$total_reviews = count($reviews_relate_tags);
?>
<div class="new_cat">
	<?php 
	if(count($total_news)){
		for($i = 0; $i < $total_news; $i ++){
			$news = $news_relate_tags[$i];
			$link_news = FSRoute::_("index.php?module=news&view=news&id=".$news->id."&code=".$news->alias."&ccode=".$news-> category_alias."&Itemid=44");
	?>
	<div class='item'>
		<?php if($news->image){?>
		<div class='frame_img'>
			<a class='item-img' href="<?php echo $link_news; ?>">
				<img src="<?php echo URL_ROOT.str_replace('/original/','/large/', $news->image); ?>" alt="<?php echo htmlspecialchars(@$news->title); ?>" />
			</a>
		</div>
		<?php }?>
		<div class="news-intro">
			<h2><a href="<?php echo $link_news; ?>" title="<?php echo htmlspecialchars(@$news->title); ?>"><?php echo htmlspecialchars(@$news->title); ?></a></h2>
			<div class='item-date'><?php //echo date('F d,Y',strtotime($news -> created_time)); ?></div>
			<div class='item-sum'>	<?php echo FSString::getWord('40',$news->summary) ; ?>	</div>
			<div class="view-detail"><a href="<?php echo $link_news; ?>" title="Chi tiết">Chi tiết</a></div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
	<?php 
		}
	} 
	?>
</div>
<div class="review_cat">
	<?php 
	if(count($total_reviews)){
		for($j = 0; $j < $total_reviews; $j ++){
			$review = $reviews_relate_tags[$j];
			$link_review = FSRoute::_("index.php?module=reviews&view=review&id=".$review->id."&code=".$review->alias."&ccode=".$review-> category_alias."&Itemid=44");
		?>
	<div class='item'>
		<?php if($review->image){?>
		<div class='frame_img'>
			<a class='item-img' href="<?php echo $link_news; ?>">
				<img  src="<?php echo URL_ROOT.str_replace('/original/','/large/', $review->image); ?>" alt="<?php echo htmlspecialchars(@$review->title); ?>" />
			</a>
		</div>
		<?php }?>
		<div class="news-intro">
			<h2><a href="<?php echo $link_review; ?>" title="<?php echo htmlspecialchars(@$review->title); ?>"><?php echo htmlspecialchars(@$review->title); ?></a></h2>
			<div class='item-date'><?php //echo date('F d,Y',strtotime($news -> created_time)); ?></div>
			<div class='item-sum'>	<?php echo FSString::getWord('40',$review->summary) ; ?>	</div>
			<div class="view-detail"><a href="<?php echo $link_review; ?>" title="Chi tiết">Chi tiết</a></div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
	<?php 
		}
	} 
	?>
</div>