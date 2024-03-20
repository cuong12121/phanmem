<?php
global $tmpl; 
$tmpl -> addStylesheet('col_1','blocks/newslist/assets/css');
?>
<div class='news_list_body_col_1'>
	<?php 
	$Itemid = 4;
	for($i = 0; $i < count($list); $i ++ ){
		$item = $list[$i];
		$link = FSRoute::_("index.php?module=news&view=news&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias."&Itemid=$Itemid");			
		?>
		<?php if($i == 0){ ?>
			<figure>
				<a href='<?php echo $link;?>' title="<?php echo $item->title;?>">
					<img src='<?php echo URL_ROOT.str_replace('/original/','/resized/',$item -> image)?>' alt="<?php echo $item -> title?>"/>
				</a>
			</figure>
			<a  class="special-tt" href='<?php echo $link;?>' title="<?php echo $item->title;?>"><?php echo get_word_by_length(50,$item->title);?>
			</a>
		<?php }else{?>
			<a  class="nomal-tt" href='<?php echo $link;?>' title="<?php echo $item->title;?>"><?php echo get_word_by_length(50,$item->title);?>
			</a>
		<?php } ?>


	<?php }	?>
</div>
