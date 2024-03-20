<?php global $config,$tmpl; ?>
<amp-sidebar id="mainmenu_sidebar"  layout="nodisplay"  side="right" >
  
 
  	<div class="close-nav-wrapper"><div role="button" tabindex="0" on="tap:mainmenu_sidebar.close" class="close-nav">X</div></div>
    <ul class="mainmanu">
    		<li><a href="<?php echo URL_ROOT;?>" class="navbar-brand visible-xs visible-sm  visible-md">
             	<span>Trang chủ</span>
             </a>
             </li>
			    		<?php $url = $_SERVER['REQUEST_URI'];?>
			    		<?php $url = substr($url,strlen(URL_ROOT_REDUCE));?>
			    		<?php $url = URL_ROOT.$url; ?>
			    		<?php foreach($level_0 as $item):?>
							<?php $link = FSRoute::_($item -> link); ?>
							<?php $class = 'level_0';?>
							<?php $class .= $item -> description ? ' long ': ' sort' ?>
							<?php if($arr_activated[$item->id]) $class .= ' activated ';?>
							
							
							<li class="<?php echo $class; ?>">
								<a href="<?php echo $link; ?>" id="menu_item_<?php echo $item->id;?>" class="menu_item_a" title="<?php echo htmlspecialchars($item -> name);?>" <?php echo $item->nofollow?'rel="nofollow"':''; ?>>
									<?php echo $item -> name;?>
								</a>
								
								<!--	LEVEL 1			-->
								<?php if(isset($children[$item -> id]) && count($children[$item -> id])  ){?>
									<span class="drop_down"></span>
									
										<ul class='highlight'>
								<?php }?>
								<?php if(isset($children[$item -> id]) && count($children[$item -> id])  ){?>
									<?php $j = 0;?>
									<?php foreach($children[$item -> id] as $key=>$child){?>
										<?php $link = FSRoute::_($child -> link); ?>
										
										<li class='sub-menu sub-menu-level1 level_1 <?php if($arr_activated[$child->id]) $class .= ' activated ';?> '>
											
												<a href="<?php echo $link; ?>" class="<?php echo $class?> sub-menu-item" id="menu_item_<?php echo $child->id;?>" title="<?php echo htmlspecialchars($child -> name);?>"  <?php echo $child->nofollow?'rel="nofollow"':''; ?>>
													<?php echo $child -> name;?>
												</a>
												
											
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
									
									
								<?php }?>
								<!--	end LEVEL 1			-->
								
							</li>	
							
						<?php endforeach;?>
			        </ul>
  </ul>
</amp-sidebar>

