<?php 
global $tmpl;
$tmpl -> addStylesheet('products');
$tmpl -> addStylesheet('home','modules/home/assets/css');
$tmpl -> addScript('home','modules/home/assets/js');
$Itemid = 30;
$Itemid_detail = 31;
$cols = 4;
FSFactory::include_class('fsstring');
?>
<div class="wapper-content-page container">
	<div class="title_mod">
		<span>Sản phẩm bán chạy</span>
	</div>
	<div class="clear"></div>
	

	<div class="cat_item_store" id="cat_item_store">
		<ul>
			<?php 
			for($i = 0 ; $i < count($array_cats) ; $i ++)
			{ 
				$cati = $array_cats[$i];
			?>
				<li class="item_tabs <?php echo $i == 0 ? 'active' : ''  ?>" id="item_tab_<?php echo $cati-> id;?>">
					<a title="Xem thêm <?php echo $cati-> name; ?>"  href="javascript:void(0)" onclick="javascript:load_product(<?php echo $cati->id; ?>, <?php echo $cati->id;?>)" ><?php echo $cati->name; ?></a>
				</li>

			<?php }?>
		</ul>
	</div>
	<?php include 'default_items.php';?>
	<div class="clear"></div>
</div>



<div class='clear'></div>
</div><div class="wapper-content-page-bottom">&nbsp;</div>


