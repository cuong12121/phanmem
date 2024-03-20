<!--
ÁP dụng cho vidic.com.vn
Có danh mục con + Filter
-->
<?php global $tmpl;
	$tmpl -> addStylesheet('drop_down_mobile','blocks/product_menu/assets/css');
	$tmpl -> addScript('drop_down_mobile','blocks/product_menu/assets/js');
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
		<span class="icon-menu">
			<svg id="Layer_1" x="0px" y="0px" viewBox="0 0 512 512" xml:space="preserve" width="20px" height="20px">
			<g>
				<g>
					<path d="M491.318,235.318H20.682C9.26,235.318,0,244.577,0,256s9.26,20.682,20.682,20.682h470.636    c11.423,0,20.682-9.259,20.682-20.682C512,244.578,502.741,235.318,491.318,235.318z" fill="#FFFFFF"/>
				</g>
			</g>
			<g>
				<g>
					<path d="M491.318,78.439H20.682C9.26,78.439,0,87.699,0,99.121c0,11.422,9.26,20.682,20.682,20.682h470.636    c11.423,0,20.682-9.26,20.682-20.682C512,87.699,502.741,78.439,491.318,78.439z" fill="#FFFFFF"/>
				</g>
			</g>
			<g>
				<g>
					<path d="M491.318,392.197H20.682C9.26,392.197,0,401.456,0,412.879s9.26,20.682,20.682,20.682h470.636    c11.423,0,20.682-9.259,20.682-20.682S502.741,392.197,491.318,392.197z" fill="#FFFFFF"/>
				</g>
			</g>
			<g>
			</g>

			</svg>
			
		</span>
		Danh mục sản phẩm
	</div>
	<div id = 'product_menu_ul' class="menu" >
	<ul class = 'product_menu_ul_innner scroll-bar'  >

			

		<?php $t = 0;?>
		<?php foreach($level_0 as $item){?>
			<?php $link = FSRoute::_('index.php?module=products&view=cat&cid='.$item->id.'&ccode='.$item->alias.'&Itemid='.$Itemid); ?>
			<?php $class = $item-> level ?'level_0 level_1_same_0' :'level_0';?>
			<!--	LEVEL 0			-->
			<li class="<?php echo $class; ?> li-product-menu-item closed" id="li-menu_item_<?php echo $item->id;?>">
				<a href="<?php echo $link; ?>" id="menu_item_<?php echo $item->id;?>" class="menu_item_a" title="<?php echo htmlspecialchars($item -> name);?>">
					<?php if($item -> image){?>
					<span class="img-menu img-menu-black"><img class="grayscale" src="<?php echo URL_ROOT.$item->image;?>" alt="<?php echo htmlspecialchars($item -> name);?>" /></span>
					<?php }?>
					<?php if($item -> icon){?>
					<span class="img-menu-white img-menu"><img class="grayscale" src="<?php echo URL_ROOT.$item->icon;?>" alt="<?php echo htmlspecialchars($item -> icon);?>" /></span>
					<?php }?>
					<span class="text-menu"><?php echo $item -> name;?></span>
				</a>
				
				<!--	LEVEL 1			-->
				<?php if(isset($children[$item -> id]) && count($children[$item -> id])  ){?>
				<div class='cat_filters_home_wrapper'>
					<ul class="cat_filters_home_ul">
						<?php foreach($children[$item -> id] as $key=>$child){?>
							<?php $link = FSRoute::_('index.php?module=products&view=cat&cid='.$child->id.'&ccode='.$child->alias.'&Itemid='.$Itemid); ?>
							
							<li class='sub-menu sub-menu-level1 child_of_<?php echo $child -> parent_id; ?> <?php if($arr_activated[$child->id]) $class .= ' activated ';?> ' >
												
									<a href="<?php echo $link; ?>" id="menu_item_<?php echo $child->id;?>" title="<?php echo htmlspecialchars($child -> name);?>">
										<?php echo $child -> name;?>
									</a>

									<!--	LEVEL 2			-->
									<?php if(isset($children[$child -> id]) && count($children[$child -> id])  ){?>
									<div class='cat_filters_home_wrapper_sub_level2'>
										<ul class="cat_filters_home_ul">
											<?php foreach($children[$child -> id] as $key1=>$child1){?>
												<?php $link = FSRoute::_('index.php?module=products&view=cat&cid='.$child1->id.'&ccode='.$child1->alias.'&Itemid='.$Itemid); ?>
												
												<li class='sub-menu sub-menu-level2 child_of_<?php echo $child1 -> parent_id; ?> <?php if($arr_activated[$child1->id]) $class .= ' activated ';?> ' >
														
														<a href="<?php echo $link; ?>" id="menu_item_<?php echo $child1->id;?>" title="<?php echo htmlspecialchars($child1 -> name);?>">
															<?php echo $child1 -> name;?>
														</a>									
												</li>
										<?php }?>
										</ul>
									</div>	
									<span class="bt_after_child"></span>
									<?php }?>

							</li>
										
					<?php }?>
					

									</div>	
				<span class="bt_after"></span>
				<?php }?>
			</li>
			<?php $t ++; ?>	
		<?php }//.foreach($level_0 as $item)?>
		<!--	CHILDREN				-->
	</ul>
	</div>
</div>