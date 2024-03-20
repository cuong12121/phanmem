<?php
global $tmpl; 
$tmpl -> addStylesheet('newslist_grid','blocks/newslist/assets/css');
?>
<div class='news_list_body'>
	<?php 
	$Itemid = 4;
	for($i = 0; $i < count($list); $i ++ ){
		$item = $list[$i];
		$link = FSRoute::_("index.php?module=news&view=news&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias."&Itemid=$Itemid");			
		?>
		<div class='news-hot'>
			<?php echo set_image_webp($item->image,'small',@$item->title,'lazy',1,''); ?>
			<div class="info_new">
				<a href='<?php echo $link;?>'><?php echo $item->title;?></a>
				<div class="datetime"><svg enable-background="new 0 0 443.294 443.294" viewBox="0 0 443.294 443.294"><path d="m221.647 0c-122.214 0-221.647 99.433-221.647 221.647s99.433 221.647 221.647 221.647 221.647-99.433 221.647-221.647-99.433-221.647-221.647-221.647zm0 415.588c-106.941 0-193.941-87-193.941-193.941s87-193.941 193.941-193.941 193.941 87 193.941 193.941-87 193.941-193.941 193.941z"/><path d="m235.5 83.118h-27.706v144.265l87.176 87.176 19.589-19.589-79.059-79.059z"/></svg>
					<?php echo date('d/m/Y',strtotime($item -> created_time)); ?>
				</div>
			</div>
			<div class='clear'></div>
		</div>
		
	<?php }
	?>
</div>
