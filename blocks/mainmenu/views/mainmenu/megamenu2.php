<?php

global $tmpl,$config; 

$tmpl -> addScript('megamenu','blocks/mainmenu/assets/js');

$tmpl -> addStylesheet('megamenu2','blocks/mainmenu/assets/css');

$Itemid = FSInput::get('Itemid');

?>

<div class="dcjq-mega-menu2 ">

	

	
	<ul id = 'megamenu2' class="menu mypopup cls">
		<?php $i = 0;?>

		<?php foreach($level_0 as $item):?>
			

			<?php $link = FSRoute::_($item -> link); ?>

			<?php $class = 'level_0';?>

			<?php $class .= $item -> description ? ' long ': ' sort' ?>

			<?php if($arr_activated[$item->id]) $class .= ' activated ';?>
            
          
            
			<li class="<?php echo $class; ?>">

				<a href="<?php echo $link; ?>" id="menu_item_<?php echo $item->id;?>" class="menu_item_a" title="<?php echo htmlspecialchars($item -> name);?>" <?php echo $item->nofollow?'rel="nofollow"':''; ?>>

					<div class="icon_menu">
						<?php echo @$item->icon;?>
					</div>
					<?php echo $item -> name;?>

				</a>

				<!--	LEVEL 1			-->

				<?php if(isset($children[$item -> id]) && count($children[$item -> id])  ){?>

					<span class="drop_down">&nbsp;</span>
					<span class="click_m"></span>
					<div class='highlight'>

						<ul class='highlight1'>

				<?php }?>

				<?php if(isset($children[$item -> id]) && count($children[$item -> id])  ){?>

					<?php $j = 0;?>

					<?php foreach($children[$item -> id] as $key=>$child){?>

						<?php $link = FSRoute::_($child -> link); ?>

						

						<li class='sub-menu sub-menu-level1 <?php if($arr_activated[$child->id]) $class .= ' activated ';?> '>
								<a href="<?php echo $link; ?>" class="<?php echo $class?> sub-menu-item" id="menu_item_<?php echo $child->id;?>" title="<?php echo htmlspecialchars($child -> name);?>"  <?php echo $child->nofollow?'rel="nofollow"':''; ?>>

									<div class="images-sub-menu1">
										
										<?php echo $child -> name;?>								
									</div>
							</a>

							<svg  aria-hidden="true" focusable="false" data-prefix="fal" data-icon="chevron-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-chevron-down fa-w-14 fa-2x"><path  d="M443.5 162.6l-7.1-7.1c-4.7-4.7-12.3-4.7-17 0L224 351 28.5 155.5c-4.7-4.7-12.3-4.7-17 0l-7.1 7.1c-4.7 4.7-4.7 12.3 0 17l211 211.1c4.7 4.7 12.3 4.7 17 0l211-211.1c4.8-4.7 4.8-12.3.1-17z" class=""></path></svg>
							<!--	LEVEL 2			-->

							<?php if(isset($children[$child -> id]) && count($children[$child -> id])  ){?>

								<ul class='highlight_level2'>

							<?php }?>

							<?php if(isset($children[$child -> id]) && count($children[$child -> id])  ){?>

									<?php foreach($children[$child -> id] as $child2){?>

										<?php $link = FSRoute::_($child2 -> link); ?>

										<li class='sub-menu2 <?php if($arr_activated[$child2->id]) $class .= ' activated ';?> '  <?php echo $child2->nofollow?'rel="nofollow"':''; ?>>

											<a href="<?php echo $link; ?>" class="<?php echo $class?> sub-menu-item" id="menu_item_<?php echo $child2->id;?>" title="<?php echo htmlspecialchars($child2 -> name);?>">

												<?php echo $child2 -> name;?>

											</a>

										</li>

										<div class="clear"></div>

									<?php }?>

							<?php }?>

							<?php if(isset($children[$child -> id]) && count($children[$child -> id])  ){?>

									<div class='clear'></div>

								</ul>

							<?php }?>

							<!--	end LEVEL 2			-->

							

						</li>

						<?php $j++;?>

					<?php }?>

				<?php }?>

				<?php if(isset($children[$item -> id]) && count($children[$item -> id])  ){?>

						</ul>

						<div class='menu_desc'><?php echo $item -> description; ?></div>

					</div>

				<?php }?>

				<!--	end LEVEL 1			-->

				
		
			</li>	

			<?php $i ++;  if($i > 7) break;?>	
        
		<?php endforeach;?>

		<!--	CHILDREN				-->

	</ul>
</div>

<div class="clear"></div>