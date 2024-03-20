<?php
global $tmpl,$config; 
$tmpl -> addStylesheet('list_slideshow','blocks/newslist/assets/css');
$page = 3;
FSFactory::include_class('fsstring');
?>

<a class="view-all" href="" title="xem tất cả" >Xem thêm ›</a>
<div class="clear"></div>

<div class='news_list_body newslist_list_slideshow cls' >
	<?php 
	$Itemid = 4;
		for($i = 0; $i < count($list); $i ++ ){
		$item = $list[$i];
		$link = FSRoute::_("index.php?module=news&view=news&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias."&Itemid=$Itemid");
	?>
		<?php if($i==0) { ?>
			<div class="item_large">
				<figure class="new_image">
					<a href="<?php echo $link; ?>" title="<?php echo htmlspecialchars(@$item->title); ?>"  class="image">
						<?php echo set_image_webp($item->image,'resized',@$item->title,'lazy',1,''); ?>
					</a>
				</figure>
				<a class="title" href="<?php echo $link; ?>" title="<?php echo htmlspecialchars(@$item->title); ?>"  >
					<?php echo $item->title; ?>	
				</a>
				
			</div>
		<?php } ?>

		<?php if($i==1) { ?>
			<div class="list_news">
		<?php } ?>

			<?php if($i > 0) { ?>
				<div class="item">
					<a class="title" href="<?php echo $link; ?>" title="<?php echo htmlspecialchars(@$item->title); ?>"  >
						<?php echo $item->title; ?>	
					</a>
				</div>
			<?php } ?>

		<?php }?> 
	</div>
</div>
