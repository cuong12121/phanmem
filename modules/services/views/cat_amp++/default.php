<?php
	global $tmpl;
	$tmpl -> addStylesheet('cat_amp','modules/services/assets/css');
//	$tmpl -> addScript('cat','modules/contents/assets/js');

	$total_list = count($list);
        $Itemid = 7;
	FSFactory::include_class('fsstring');
?>	

	<div class="contents_cat wapper-page  wapper-page-cat">
		
	<h1 class="img-title-cat page_title">
      <span><?php echo $cat->name;?></span>
    </h1>
	<div class="wapper-content-page">
		<?php 
		if($total_list){
			for($i = 0; $i < $total_list; $i ++){
				$class='';	
				$item = $list[$i];
				
				$link = FSRoute::_("index.php?module=services&view=services&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias."&Itemid=$Itemid");
		?>
		<div class='item <?php echo $class; ?>'>
			<div class='frame_img'>
				<a class='item-img' href="<?php echo $link; ?>">
					<amp-img src="<?php echo URL_ROOT.str_replace('/original/','/resized/', $item->image); ?>" alt="<?php echo htmlspecialchars(@$item->title); ?>" width="270" height="130" />
				</a>
			</div>
			<div class="details frame_right">
				<h2 class="title_content item_title"><a href="<?php echo $link; ?>" title="<?php echo htmlspecialchars(@$item->title); ?>"><?php echo htmlspecialchars(@$item->title); ?></a></h2>
				<div class='item-sum'>	<?php echo $item->summary; ?>	</div>
				<a class="read_more" href="<?php echo $link; ?>" title="<?php echo htmlspecialchars(@$item->title); ?>">Xem tiếp</a>
			</div>
			<div class="clear"></div>
		</div>
		<?php 
			}
			if($pagination) echo $pagination->showPagination(3);
		} else {
			echo FSText::_('Không có bài viết nào trong chuyên mục')." : <strong>".$cat->name."</strong>";
		 }
		?>
		</div>
		<div class='clear'></div>
	</div>