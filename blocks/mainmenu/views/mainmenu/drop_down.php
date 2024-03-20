
<?php global $tmpl;
$tmpl -> addStylesheet('drop_down','blocks/mainmenu/assets/css');
$tmpl -> addScript('drop_down','blocks/mainmenu/assets/js');
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
				<?php $link = FSRoute::_($item-> link); ?>
				<?php $class = $item-> level ?'level_0 level_1_same_0' :'level_0';?>
				
				<li class="<?php echo $class; ?> li-product-menu-item closed" id="li-menu_item_<?php echo $item->id;?>">
					<a href="<?php echo $link; ?>" id="menu_item_<?php echo $item->id;?>" class="menu_item_a" title="<?php echo htmlspecialchars($item -> name);?>">
						<span class="icon"><?php echo $item -> icon;?></span>
						<span class="text-menu"><?php echo $item -> name;?></span>
						<?php if(!empty($level_1)){  ?>
						<svg  fill="gray" width="10px" height="10px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" ><path d="M17.525 36.465l-7.071 7.07c-4.686 4.686-4.686 12.284 0 16.971L205.947 256 10.454 451.494c-4.686 4.686-4.686 12.284 0 16.971l7.071 7.07c4.686 4.686 12.284 4.686 16.97 0l211.051-211.05c4.686-4.686 4.686-12.284 0-16.971L34.495 36.465c-4.686-4.687-12.284-4.687-16.97 0z" class=""></path></svg>
						<?php } ?>
					
					</a>

					<!--	LEVEL 1			-->
					
					<?php if(!empty($level_1[$item->id])){
						echo '<pre>';
						//print_r($level_1[$item->id]);
						echo count($level_1[$item->id]);

						
					?>
						<div class="level1">
							
							<?php if(@count($level_1[$item->id] > 5)){?>
								<div class="subcat cls scroll_bar">
								<?php for ($i=1; $i < 6 ; $i++) { 

								?>
									<div class="col-number col-<?php echo $i ?>">
									<?php
										foreach($level_1[$item->id] as $lv1){
										
										if($lv1->link){
											$link_lv1 = FSRoute::_($lv1->link);
										}else{
											$link_lv1 = 'javascript:void(0)';
										}
									?>
										<?php if($lv1->column_number == $i){ ?>
											<div class="col">
												<a href="<?php echo $link_lv1; ?>" title="<?php echo $lv1->name ?>" class="name">
													<?php echo $lv1->name ?>
												</a>
												<?php if(!empty($level_2[$lv1->id])){  ?>
													<div class="manu mn_lv2">
														<?php foreach ($level_2[$lv1->id] as $lv2) {
															$link_lv2 = FSRoute::_($lv2->link)
														?>
															<a href="<?php echo $link_lv2; ?>" title="<?php echo $lv2->name ?>"><?php echo $lv2->name ?></a>
														<?php } ?>
													</div>
												<?php } ?>
											</div>
										<?php   } ?>
									<?php } ?>
									</div>
								<?php } ?>	
								</div>
							<?php }else{?>
								<div class="subcat cls scroll_bar">
									<?php foreach($level_1[$item->id] as $lv1){
										if($lv1->link){
											$link_lv1 = FSRoute::_($lv1->link);
										}else{
											$link_lv1 = 'javascript:void(0)';
										}
									?>
										<div class="col-number">
											<div class="col">
												<a href="<?php echo $link_lv1; ?>" title="<?php echo $lv1->name ?>" class="name">
													<?php echo $lv1->name ?>
												</a>
												<?php if(!empty($level_2[$lv1->id])){  ?>
													<div class="manu mn_lv2">
														<?php foreach ($level_2[$lv1->id] as $lv2) {
															$link_lv2 = FSRoute::_($lv2->link)
														?>
															<a href="<?php echo $link_lv2; ?>" title="<?php echo $lv2->name ?>"><?php echo $lv2->name ?></a>
														<?php } ?>
													</div>
												<?php } ?>
											</div>
										</div>
									<?php } ?>
								</div>
							<?php } ?>

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