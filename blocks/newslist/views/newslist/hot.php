<?php
global $tmpl,$is_mobile; 
$tmpl -> addStylesheet('newslist_hot','blocks/newslist/assets/css');
?>
<div class='news_list_hot'>
	<?php $link_cat = FSRoute::_("index.php?module=news&view=cat&id=".$cat->id."&code=".$cat->alias);	 ?>
	<div class="news_cat_title cls">
		<span class="name"><a href="<?php echo $link_cat; ?>"><?php echo $cat-> name; ?></a></span>
		<span class="readmore"><a href="<?php echo $link_cat; ?>">Xem tất cả</a></span>
	</div>
	<div class="list_news">
	<?php 
	$Itemid = 4;
	for($i = 0; $i < count($list); $i ++ ){
		$item = $list[$i];
		$link = FSRoute::_("index.php?module=news&view=news&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias."&Itemid=$Itemid");			
		?>
		<div class='news-hot'>
			<div class="images">
				<a href="<?php echo $link; ?>" title="<?php echo $item-> title; ?>">
					<?php echo set_image_webp($item->image,'small',@$item->title,'',0,''); ?>
				</a>
			</div>
			<a class="title" href='<?php echo $link;?>' title="<?php echo $item-> title; ?>"><?php echo $is_mobile?getWord(10,$item->title):$item-> title;?></a>
			<div class='clear'></div>
		</div>
	<?php }
	?>
	</div>
</div>
