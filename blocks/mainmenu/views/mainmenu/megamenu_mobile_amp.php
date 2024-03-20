<?php
global $tmpl,$config; 
$tmpl -> addStylesheet('megamenu_mobile_amp','blocks/mainmenu/assets/css');
$Itemid = FSInput::get('Itemid');
?>

<div class="dccq-mega-menu">
	<input type="checkbox" name="" id="chk_mobile">
	<ul id = "megamenu" class = "menu_mb">
		<li class="level_00 sort home <?php echo ($Itemid=='1')?'activated':'';?>"><a  class="menu_item_a"  href="<?php echo URL_ROOT;?>" title="<?php echo $config['site_name']?>" rel="home" >Trang chủ</a> 
			<label for="chk_mobile" class="show_menu_btn_mb_hide">
				<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 21.9 21.9" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 21.9 21.9">
					<path d="M14.1,11.3c-0.2-0.2-0.2-0.5,0-0.7l7.5-7.5c0.2-0.2,0.3-0.5,0.3-0.7s-0.1-0.5-0.3-0.7l-1.4-1.4C20,0.1,19.7,0,19.5,0  c-0.3,0-0.5,0.1-0.7,0.3l-7.5,7.5c-0.2,0.2-0.5,0.2-0.7,0L3.1,0.3C2.9,0.1,2.6,0,2.4,0S1.9,0.1,1.7,0.3L0.3,1.7C0.1,1.9,0,2.2,0,2.4  s0.1,0.5,0.3,0.7l7.5,7.5c0.2,0.2,0.2,0.5,0,0.7l-7.5,7.5C0.1,19,0,19.3,0,19.5s0.1,0.5,0.3,0.7l1.4,1.4c0.2,0.2,0.5,0.3,0.7,0.3  s0.5-0.1,0.7-0.3l7.5-7.5c0.2-0.2,0.5-0.2,0.7,0l7.5,7.5c0.2,0.2,0.5,0.3,0.7,0.3s0.5-0.1,0.7-0.3l1.4-1.4c0.2-0.2,0.3-0.5,0.3-0.7  s-0.1-0.5-0.3-0.7L14.1,11.3z"/>
				</svg>
			</label>
		</li>
		
		<?php $i = 0;?>
		<?php foreach($level_0 as $item){?>

			<?php if(!empty($item -> link)){

				$link = FSRoute::_($item -> link);
			}else{
				$link= '';
			}

			?> 

			<?php $class = 'level_00';?>
			<?php $class .= @$item -> description ? ' long ': ' sort' ?>
			 
			<?php if(isset($arr_activated[$item->id]) && $arr_activated[$item->id] ) $class .= ' activated ';?>
			<?php if($i):?><?php endif;?>

			<?php $level_00 = 0;?>
			
			<li class="<?php echo $class; ?>">
				<?php if(!empty($link)){?>
					<a href="<?php echo $link; ?>" id="menu_item_<?php echo $item->id;?>" class="menu_item_a" title="<?php echo htmlspecialchars($item -> name);?>" <?php echo $item->nofollow?'rel="nofollow"':''; ?>>
						<?php echo $item -> name;?>
					</a>
				<?php }else {?>
					<span class="menu_title_mobile"><?php echo $item -> name;?></span>
				<?php }?>
				<!--	LEVEL 1			-->

				<?php if(isset($children[$item -> id]) && !empty($children[$item -> id])  ){?>

					<input type="checkbox" name="" id="drop_down_1_<?php echo $level_00;?>" >
					<label for="drop_down_1_<?php echo $level_00;?>" class="manu_mobile_up" id="drop_lable_1_<?php echo $level_00;?>"></label>
					<div class='highlight'>
						<ul class='highlight1'>
							<label for="drop_down_1_<?php echo $level_00;?>" class="manu_mobile_hide" id="drop_lable_1_<?php echo $level_00;?>"><?php echo $item -> name;?></label>

						<?php }?>
						<?php if(isset($children[$item -> id]) && !empty($children[$item -> id])  ){?>
							<?php $j = 0;?>

							<?php $level_1 = 0 ;?>

							<?php foreach($children[$item -> id] as $key=>$child){?>
								<?php $link = FSRoute::_($child -> link); ?>

								<li class='sub-menu sub-menu-level1 <?php if(isset($arr_activated[$child->id])) $class .= ' activated ';?> '>
									<div class="images-sub-menu1">
										<a href="<?php echo $link; ?>" class="<?php echo $class?> sub-menu-item" id="menu_item_<?php echo $child->id;?>" title="<?php echo htmlspecialchars($child -> name);?>"  <?php echo $child->nofollow?'rel="nofollow"':''; ?>>
											<?php echo $child -> name;?>
										</a>
									</div>
									</li>
									<?php $j++;?>
								<?php }?>
							<?php }?>
							<?php if(isset($children[$item -> id]) && !empty($children[$item -> id])  ){?>
							</ul>
							
						</div>
						<?php $level_00++;?>
					<?php }?>
					<!--	end LEVEL 1			-->

				</li>	
				<?php $i ++; ?>	
			<?php } ?>
			<!--	CHILDREN				-->
		</ul>
	</div>
	<div class="clear"></div>