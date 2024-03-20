<?php
global $tmpl; 
$tmpl -> addStylesheet('newslist_style1','blocks/newslist/assets/css');
$Itemid = 4;
$i = 0;
?>
<div class="block_content newslist_style1">
	<div class="item">
		<h2 class="block_title pull-left">
			<span><?php echo FSText::_('Có thể bạn quan tâm')?></span>
		</h2>
		<div class="arrow-right pull-left"></div>
	</div>
	<?php
		foreach($list as $item){
			$link = FSRoute::_("index.php?module=news&view=news&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias."&Itemid=$Itemid");
			$i ++;
	?>
	<div class="item">
		<h4 class="item-title">
			<span class="btn-info iconbox pull-left"><i class="fa fa-bookmark"></i></span>
			<a class="flever_15" href="<?php echo $link; ?>" title="<?php echo $item->title?>"><?php echo get_word_by_length(40,$item->title);?></a>
		</h4>
	</div>		
	<?php	} ?>
</div>