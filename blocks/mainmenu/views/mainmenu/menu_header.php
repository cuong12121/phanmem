
<?php global $tmpl;
$tmpl -> addStylesheet('menu_header','blocks/mainmenu/assets/css');
//$tmpl -> addScript('drop_down','blocks/mainmenu/assets/js');
?>
<?php
global $tmpl; 
$Itemid = FSInput::get('Itemid');
$max_filter_in_column = 7;
$total =count($level_0);
$colums = 4;
?>

	<ul class = 'menu_header_ul_innner scroll-bar'  >

		<?php $t = 0;?>
		<!--	LEVEL 0			-->
		<?php foreach($level_0 as $item){?>
			<?php $link = FSRoute::_($item-> link); ?>
			<?php $class = $item-> level ?'level_0 level_1_same_0' :'level_0';?>
			
			<li class = "<?php echo $class; ?> li-product-menu-item closed" id="li-menu_item_<?php echo $item->id;?>">
				<a href="<?php echo $link; ?>" id="menu_item_<?php echo $item->id;?>" class="menu_item_a" title="<?php echo htmlspecialchars($item -> name);?>">
					<?php echo $item -> icon;?>
					<span class="text-menu"><?php echo $item -> name;?></span>
								
				</a>
				<?php 
					if(!empty($level_1[$item->id])){?>
						<ul class="subcat">
						<?php 	
						foreach ($level_1[$item->id] as $lv1 ) { 
							$link_lv1 = $lv1->link;
						?>
							<li class="level_1">
								<a href="<?php echo $link_lv1;?>">
									<span class="text-menu"><?php echo $lv1 -> name;?></span>
								</a>
							</li>
						<?php } ?>
						</ul>	
					<?php }
				?>
				
			</li>
			<?php $t ++; ?>	
		<?php } ?>	
	</ul>
