<?php
global $tmpl;
$tmpl -> addStylesheet('home_amp','modules/services/assets/css');
//	$tmpl -> addScript('cat','modules/contents/assets/js');

$total_list = count($list);
$Itemid = 7;
FSFactory::include_class('fsstring');
?>	
<h1 class="img-title-cat page_title title_services">
	<span><?php echo $cat->name;?></span>
</h1>
<div class="cat_item_store">
	<ul>
		<li class="item_tabsds" id="item_tabds_0">
			<a title="Xem thêm"  href="/dich-vu.html">Tất cả</a>
		</li>
		<?php $x = 0; foreach ($list_cats as $cat_l) { ?>
			<?php $link = FSRoute::_('index.php?module=services&view=cat&id='.$cat_l -> id.'&ccode='.$cat_l -> alias. '&Itemid=93'); ?>
			<li class="item_tabsds <?php if($cat_l -> id == $cat -> id) echo 'active';  ?>">
				<a href="<?php echo $link; ?>" title = "<?php echo $cat_l -> name; ?>"><?php
				echo $cat_l -> name;?></a> 
			</li>
		<?php } ?>
	</ul> 
</div>
<div class="contents_cat wapper-page  wapper-page-cat services-block">
	<div class="wapper-content-page">
		<?php 
		if($total_list){
			for($i = 0; $i < $total_list; $i ++){
				$class='';	
				$item = $list[$i];
				
				$link = FSRoute::_("index.php?module=services&view=services&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias."&Itemid=$Itemid");
				?>
				 <?php $image_webp = $this -> image_webp(URL_ROOT.str_replace('/original/', '/resized/', $item -> image)) ;?>
				<div id="item_<?php echo $i; ?>" class="item aos-item">
					<div class="img">
						<a href="<?php echo $link ?>" title="<?php echo $item->title; ?>">
							<amp-img width="300" height="200" src="<?php echo URL_ROOT.str_replace('/original/', '/resized/', $item -> image); ?>" alt="<?php echo $item->title; ?>"/>
						</a>
					</div>
					<div class="name_item">
						<a href="<?php echo $link ?>" title="<?php echo $item->title; ?>"><?php echo $item->title; ?></a>
					</div>
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