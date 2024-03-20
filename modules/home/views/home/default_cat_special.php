	<?php 
		$Itemid_cat = 34;
		$link_cat = FSRoute::_("index.php?module=products&view=cat&ccode=".$cat_special -> alias."&cid=".$cat_special->id."&Itemid=".$Itemid_cat);
		?>
		
		<div class="cat_item_store">
			<div class='cat-title'>
				
				<h2  class='cat-title-main' id="cat-<?php echo $cat_special -> alias;?>">
					<div class="title_icon"><i class="icon_v1"></i></div>
					<a href="<?php echo $link_cat; ?>" title="<?php echo $cat_special->name;?>"><?php echo $cat_special->name;?></a>
				</h2>
				
				<ul class="nav nav-tabs pull-left">
					<?php if(isset($sub_cats_special) && $sub_cats_special){ ?>
					<?php foreach ($sub_cats_special as $sub_cat) {?>
						<li class="item_tabs" id="item_tab_<?php echo  $sub_cat->id.$sub_cat->id?>">
							<a title="Xem thêm  <?php echo $sub_cat -> name; ?>"  href="javascript:void(0)" onclick="javascript: load_product(<?php echo $cat_special->id; ?>,<?php echo $sub_cat->id; ?>,0)" ><?php echo $sub_cat->name;?></a>
						</li>
					<?php }?>
					<?php }?>
					<li class="item_tabs view_all" >
						<a  href="<?php echo $link_cat;?>" title="Xem thêm <?php echo $sub_cat->name;?>">Xem tất cả &rsaquo;</a>
					</li>
				</ul>
				
                <div class="clear"></div>
			</div>
			<div class="clear"></div>
			<?php include 'default_items_special.php';?>
            <div class="clear"></div>
		</div>
		
	<div class='clear'></div>
</div>