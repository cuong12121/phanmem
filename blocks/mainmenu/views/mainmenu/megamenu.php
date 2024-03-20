<?php
global $tmpl,$config; 
//$tmpl -> addScript('jquery.hoverIntent.minified','libraries/jquery/mega_menu/js');
//$tmpl -> addScript('jquery.dcmegamenu.1.3','libraries/jquery/mega_menu/js');
//$tmpl -> addStylesheet('menu','libraries/jquery/mega_menu');
$tmpl -> addScript('megamenu','blocks/mainmenu/assets/js');
$tmpl -> addStylesheet('megamenu','blocks/mainmenu/assets/css');
$Itemid = FSInput::get('Itemid');
?>
<div class="dcjq-mega-menu">	
	<ul id = 'megamenu' class="menu mypopup cls">
		<?php if(1==1){?>
			<li class="level_0 sort home <?php echo ($Itemid=='1')?'activated':'';?>"><a  class="menu_item_a"  href="<?php echo URL_ROOT;?>" title="<?php echo $config['site_name']?>" rel="home" ><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
				viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
				<g>
					<g>
						<path d="M421.936,211.786v238.533h-90.064V347.155c0-9.045-7.331-16.375-16.375-16.375H200.324
						c-9.045,0-16.375,7.331-16.375,16.375v103.164H94.431V211.786H61.681v254.908c0,9.045,7.331,16.375,16.375,16.375h122.269
						c9.045,0,16.375-7.331,16.375-16.375V363.531h82.422v103.164c0,9.045,7.331,16.375,16.375,16.375h122.815
						c9.045,0,16.375-7.331,16.375-16.375V211.786H421.936z"/>
					</g>
				</g>
				<g>
					<g>
						<path d="M506.815,255.508L269.373,33.351c-6.25-5.857-15.966-5.895-22.27-0.104L5.295,255.405
						c-6.659,6.119-7.096,16.474-0.977,23.133c3.226,3.521,7.636,5.3,12.063,5.3c3.957,0,7.931-1.43,11.075-4.318L258.085,67.635
						l226.355,211.787c6.616,6.184,16.965,5.83,23.144-0.77C513.758,272.047,513.419,261.687,506.815,255.508z"/>
					</g>
				</g>
			</svg>
		Trang chủ</a> </li>
	<?php }?>
	<?php $i = 0;?>

	<?php foreach($level_0 as $item){?>
		<?php $link = FSRoute::_($item -> link); ?>
		<?php $class = 'level_0';?>
		<?php $class .= $item -> description ? ' long ': ' sort' ?>
		<?php if($arr_activated[$item->id]) $class .= ' activated ';?>
		<?php if($i >= count($level_0) - 3 && $i > 4) $class .= ' sub_right ' ?>

		<?php 
		$ban_class = '';
		$lis_b = array();
		$cou_lis_b = 0;
		if(!empty($banner_0[$item->id])){
			$ban_class = 'menu_banner';			
			$lis_b = $banner_0[$item->id];
			$cou_lis_b = count($lis_b);	
		}
		?>
		<li class="<?php echo $class; ?> <?php echo $ban_class; ?>">
			<a href="<?php echo $link; ?>" id="menu_item_<?php echo $item->id;?>" class="menu_item_a" title="<?php echo htmlspecialchars($item -> name);?>" <?php echo $item->nofollow?'rel="nofollow"':''; ?>>
				<?php echo $item -> icon;?>
				<?php echo $item -> name;?>
			</a>
			<!--	LEVEL 1			-->
			<?php if(isset($children[$item -> id]) && count($children[$item -> id])  ){?>
				<span class="drop_down"><span></span>
			</span>
			<div class='highlight' style="--i:<?php echo $cou_lis_b;?>" >
				<ul class='highlight1'>
				<?php }?>
				<?php if(isset($children[$item -> id]) && count($children[$item -> id])  ){?>
					<?php $j = 0;?>
					<?php foreach($children[$item -> id] as $key=>$child){?>
						<?php $link = FSRoute::_($child -> link); ?>
						
						<li class='sub-menu sub-menu-level1 <?php if($arr_activated[$child->id]) $class .= ' activated ';?> '>
							<a href="<?php echo $link; ?>" class="<?php echo $class?> sub-menu-item" id="menu_item_<?php echo $child->id;?>" title="<?php echo htmlspecialchars($child -> name);?>"  <?php echo $child->nofollow?'rel="nofollow"':''; ?>>
								<?php echo $child -> name;?>
							</a>
							<!--	LEVEL 2			-->
							<?php if(isset($children[$child -> id]) && count($children[$child -> id])  ){?>
								<span class="drop_down2">
									<span></span>
								</span>
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
				<!-- banner -->
				<?php 
				if(!empty($lis_b)){
						//$lis_b = $banner_0[$item->id];
					?>
					<div class="box_banner_menu_0 <?php echo ($cou_lis_b == 2)?'it_ban_2':''?>" >
						<?php foreach ($lis_b as $ba){ ?>
							<div class="it_ba">
								<a href="<?php echo $ba->link;?>">
									<?php echo set_image_webp($ba->image,'compress',@$ba->name,'lazy',1,'');  ?>
								</a>
							</div>
						<?php } ?>
					</div>

				<?php } ?>
				<!-- end banner -->
			</div>
		<?php }?>
		<!--	end LEVEL 1			-->

	</li>	
	<?php $i ++; ?>	
<?php };?>
<!--	CHILDREN				-->
</ul>
</div>
