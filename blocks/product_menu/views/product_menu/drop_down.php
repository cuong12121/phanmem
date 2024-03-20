
<?php global $tmpl;
$tmpl -> addStylesheet('drop_down','blocks/product_menu/assets/css');
$tmpl -> addScript('drop_down','blocks/product_menu/assets/js');
?>
<?php
global $tmpl; 
$Itemid = FSInput::get('Itemid');
$max_filter_in_column = 7;
$total =count($level_0);
$colums = 4;
?>
<div class="product_menu <?php echo ($Itemid!='1')?'inner_':''; ?>" id="product_menu_top">
	
	<div id = 'product_menu_ul' class="menu <?php echo ($Itemid=='1')?'bl':'no'; ?>" >
		<ul class = 'product_menu_ul_innner scroll-bar'  >


			<?php $t = 0;?>
			<!--	LEVEL 0			-->
			<?php foreach($level_0 as $item){?>
				<?php $link = FSRoute::_('index.php?module=products&view=cat&cid='.$item->id.'&ccode='.$item->alias.'&Itemid='.$Itemid); ?>
				<?php $class = $item-> level ?'level_0 level_1_same_0' :'level_0';?>
				<?php  $level_1 = $array_lv1[$item ->id]; ?>
				<li class="<?php echo $class; ?> li-product-menu-item closed" id="li-menu_item_<?php echo $item->id;?>">
					<a href="<?php echo $link; ?>" id="menu_item_<?php echo $item->id;?>" class="menu_item_a" title="<?php echo htmlspecialchars($item -> name);?>">
						<span class="text-menu"><?php echo $item -> name;?></span>
						<?php if(!empty($level_1)){  ?>
						<svg  fill="gray" width="10px" height="10px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" ><path d="M17.525 36.465l-7.071 7.07c-4.686 4.686-4.686 12.284 0 16.971L205.947 256 10.454 451.494c-4.686 4.686-4.686 12.284 0 16.971l7.071 7.07c4.686 4.686 12.284 4.686 16.97 0l211.051-211.05c4.686-4.686 4.686-12.284 0-16.971L34.495 36.465c-4.686-4.687-12.284-4.687-16.97 0z" class=""></path></svg>
						<?php } ?>
					
					</a>

					<!--	LEVEL 1			-->
					
					<?php if(!empty($level_1)){  ?>
						<div class="level1">
							<div class="subcat cls scroll_bar">
								<?php foreach($level_1 as $lv1){
									$link_lv1 = FSRoute::_('index.php?module=products&view=cat&cid='.$lv1->id.'&ccode='.$lv1->alias.'&Itemid='.$Itemid);
								?>
									<div class="col">
										<a href="<?php echo $link_lv1; ?>" title="<?php echo $lv1->name ?>" class="name">
											<?php echo $lv1->name ?>
										</a>

										<div class="manu">
											<?php 
											$manf_by_cat = $array_manf[$item ->id];
											?>
											<?php foreach ($manf_by_cat as $mn) {
												// $link_manu = FSRoute::_('index.php?module=products&view=cat&ccode='.$lv1 ->alias.'&cid='.$lv1 ->id.'&filter='.$mn->alias.'&Itemid=9');

												$link_manu = FSRoute::_('index.php?module=products&view=cat&ccode='.$lv1 ->alias.'&cid='.$lv1 ->id.'&Itemid=9');
												if(!empty($mn->alias)){
													if(!empty($lv1 ->alias1) || !empty($lv1 ->alias2)){
														$link_manu = str_replace($lv1->alias,$lv1->alias1.'-'.$mn->alias.'-'.$lv1->alias2,$link_manu);
														$link_manu = str_replace('-pc'.$lv1->id,'-pcm'.$lv1->id,$link_manu);
													}else{
														$link_manu = str_replace($lv1->alias,$lv1->alias.'-'.$mn->alias,$link_manu);
														$link_manu = str_replace('-pc'.$lv1->id,'-pcm'.$lv1->id,$link_manu);
													}
												}
												
											?>
												<a href="<?php echo $link_manu; ?>" title="<?php echo $mn->filter_show ?>"><?php echo $mn->filter_show ?></a>
											<?php } ?>
											
											
										</div>

									</div>

								<?php } ?>
							</div>

							<div class="banner">
								<?php echo set_image_webp($item->image_menu,'resized',@$item->name,'lazy',1,''); ?>
							</div>
						</div>
					<?php } ?>
					<!--	END LEVEL 1			-->
				</li>
				<?php $t ++; ?>	
			<?php }//.foreach($level_0 as $item)?>
			<!--	CHILDREN				-->
			

			<?php

			if(count($level_0) > 10){ ?>
				<li class="level_0 li-product-menu-item view_all" id="li-menu_item_1">
					<a href="javascript:void(0)" class="menu_item_a" title="Xem thêm">
						<span class="text-menu">Xem thêm</span>
						<svg width="10px" height="10px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" ><path d="M17.525 36.465l-7.071 7.07c-4.686 4.686-4.686 12.284 0 16.971L205.947 256 10.454 451.494c-4.686 4.686-4.686 12.284 0 16.971l7.071 7.07c4.686 4.686 12.284 4.686 16.97 0l211.051-211.05c4.686-4.686 4.686-12.284 0-16.971L34.495 36.465c-4.686-4.687-12.284-4.687-16.97 0z" class=""></path></svg>
					</a>
				</li>
			<?php } ?>
		</ul>
	</div>
</div>