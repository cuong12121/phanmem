<?php
global $tmpl; 
$tmpl -> addStylesheet('right','blocks/newslist/assets/css');
?>
<div class="block_title"><h4><span>Bài viết gần đây</span></h4></div>
<div class='news_list_body_right'>
	<?php 
	$Itemid = 4;
	for($i = 0; $i < count($list); $i ++ ){
		$item = $list[$i];
		$link = FSRoute::_("index.php?module=news&view=news&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias."&Itemid=$Itemid");			
		?>
		<div class='news-item cls'>

			<figure>
				<a href='<?php echo $link;?>' title="<?php echo $item->title;?>">
					<img src='<?php echo URL_ROOT.str_replace('/original/','/resized/',$item -> image)?>' alt="<?php echo $item -> title?>"/>
				</a>
			</figure>

			<div class="content-r" >
				<h3><a href='<?php echo $link;?>' title="<?php echo $item->title;?>"><?php echo $item->title;?>
				</a></h3>
				<div class="datetime">
					<?php echo date('d/m/Y',strtotime($item -> created_time)); ?>
				</div>
			</div>

			<div class='clear'></div>

		</div>   
	<?php }	?>
</div>
