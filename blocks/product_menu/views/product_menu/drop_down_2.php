<!--
ÁP dụng cho vidic.com.vn
Có danh mục con + Filter
-->
<?php global $tmpl;
$tmpl -> addStylesheet('drop_down_2','blocks/product_menu/assets/css');
$tmpl -> addScript('drop_down2','blocks/product_menu/assets/js');
?>
<?php
global $tmpl; 
$Itemid = FSInput::get('Itemid');
$max_filter_in_column = 7;
$total =count($level_0);
$colums = 4;
?>
<div class="product_menu" id="product_menu_top">
	<div class='menu_label <?php echo ($Itemid=='1')?'product_menu_normal active':'';?>' data-id="product_menu_ul">
		
		<span>			
			<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
			 viewBox="0 0 455 455" style="enable-background:new 0 0 455 455;" xml:space="preserve">
		<g>
			<rect y="312.5" width="455" height="30"/>
			<rect y="212.5" width="455" height="30"/>
			<rect y="112.5" width="455" height="30"/>
		</g>
		</svg>

			Danh mục<font> sản phẩm</font>
		</span>
		
	</div>
	<div id = 'product_menu_ul' class="menu <?php echo ($Itemid=='1')?'bl':'no'; ?>" >
		bff
		<ul class = 'product_menu_ul_innner scroll-bar'  >


			<?php $t = 0;?>
			<?php foreach($level_0 as $item){?>
				<?php $link = FSRoute::_('index.php?module=products&view=cat&cid='.$item->id.'&ccode='.$item->alias.'&Itemid='.$Itemid); ?>
				<?php $class = $item-> level ?'level_0 level_1_same_0' :'level_0';?>
				<!--	LEVEL 0			-->
				<li class="<?php echo $class; ?> li-product-menu-item closed" id="li-menu_item_<?php echo $item->id;?>">
					<a href="<?php echo $link; ?>" id="menu_item_<?php echo $item->id;?>" class="menu_item_a" title="<?php echo htmlspecialchars($item -> name);?>">
						<span class="icon_svg"><?php echo $item-> icon; ?></span>
						
						<span class="text-menu"><?php echo $item -> name;?></span>
					</a>
					<!--	LEVEL 1			-->
					<div class="menu_manu" id="<?php echo $item->alias; ?>">
						<ul class="ul_manu_menu cls">
							<?php 
								$filter_in_table_name = isset($arr_filter_by_field[$item -> tablename])?$arr_filter_by_field[$item -> tablename]:array();

							?>
							<?php foreach($filter_in_table_name as $data) { ?>
								
								<?php foreach($data as $items) { ?>
									<?php $link_manu = FSRoute::_('index.php?module=products&view=cat&cid='.$item->id.'&ccode='.$item->alias.'&filter='.$items->alias.'&Itemid='.$Itemid); ?>
								<li class="level_1" id="<?php echo $items-> alias; ?>">
									<a href="<?php echo $link_manu; ?>" title="<?php echo $items-> filter_show; ?>"><?php echo $items-> filter_show; ?></a>
								</li>
								<?php  }?>
							<?php }?>
						</ul>
					</div>
				</li>
				<?php $t ++; ?>	
			<?php }//.foreach($level_0 as $item)?>
			<!--	CHILDREN				-->
		</ul>
	</div>
</div>