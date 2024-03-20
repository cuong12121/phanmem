<?php
global $tmpl; 
$tmpl -> addStylesheet('default','blocks/newslist/assets/css');
$total_new = 0;
if(!empty($list)){
	$total_new = count($list);
}
?>

<div class='news_list_body_default'>
	<div class="list_cats cls">
		<?php foreach ($list_cats as $cat) { 
			$Itemid = 4;
			$link_cat = FSRoute::_("index.php?module=news&view=cat&id=".$cat->id."&ccode=".$cat->alias."&Itemid=$Itemid");
			?>
			<div class="item_cat">
				<a href="<?php echo $link_cat; ?>" title="<?php echo $cat-> name; ?>"><?php echo $cat-> name; ?></a>
			</div>
		<?php } ?>
		<div class="item_cat">
			<?php
			$link_home = FSRoute::_("index.php?module=news&view=home"); ?>
			<a class="readmore" href="<?php echo $link_home; ?>" title="Xem thêm">Xem thêm<svg width="10px" height="10px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M17.525 36.465l-7.071 7.07c-4.686 4.686-4.686 12.284 0 16.971L205.947 256 10.454 451.494c-4.686 4.686-4.686 12.284 0 16.971l7.071 7.07c4.686 4.686 12.284 4.686 16.97 0l211.051-211.05c4.686-4.686 4.686-12.284 0-16.971L34.495 36.465c-4.686-4.687-12.284-4.687-16.97 0z" class=""></path></svg></a>
		</div>
	</div>
	<div class="news_list_body_default_inner cls">
	<?php 
	$Itemid = 4;
	$i = 1; 
	foreach ($list as $key => $item) {	
		$link = FSRoute::_("index.php?module=news&view=news&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias."&Itemid=$Itemid");			
		?>
		<div class='item cls'>
			<figure class="img">
				<a href='<?php echo $link;?>' title="<?php echo $item->title;?>">
					<?php echo set_image_webp($item->image,'resized2',@$item->title,'lazy',1,'width="270px" height="270px"' ); ?>
				</a>
			</figure>

			<div class="content-r" >
				<a class = "title" href='<?php echo $link;?>' title="<?php echo $item->title;?>"><?php echo $item->title;?></a>
				<div class="summary">
					<?php echo $item-> summary;?>
				</div>
				<div class="info">
					<span class="creator"><?php echo @$item-> creator?@$item-> creator:'Admin'; ?></span>
					<span>|</span>
					<span class="created_time"><?php echo date('d-m-Y',strtotime($item -> created_time)); ?></span>
				</div>
			</div>
		</div>


		<?php $i ++;?>
	<?php }	?>
	</div>
</div>
