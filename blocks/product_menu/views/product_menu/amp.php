<?php global $config,$tmpl; ?>
<?php global $tmpl;
	$tmpl -> addStylesheet('amp','blocks/product_menu/assets/css');	
?>

<amp-sidebar id="product_menu_sidebar"  layout="nodisplay"  side="left" >
  
 
  	<div class="close-nav-wrapper"><div role="button" tabindex="0" on="tap:product_menu_sidebar.close" class="close-nav">X</div></div>
    
    <div class="product_menu" id="product_menu_top">
		
		<ul class = 'product_menu_ul_innner scroll-bar'  >
			<?php $t = 0;?>
			<?php foreach($level_0 as $item){?>
				<?php $link = FSRoute::_('index.php?module=products&view=cat&cid='.$item->id.'&ccode='.$item->alias); ?>
				<?php $class = $item-> level ?'level_0 level_1_same_0' :'level_0';?>
				<!--	LEVEL 0			-->
				<li class="<?php echo $class; ?> li-product-menu-item closed" id="li-menu_item_<?php echo $item->id;?>">
					<a href="<?php echo $link; ?>" id="menu_item_<?php echo $item->id;?>" class="menu_item_a" title="<?php echo htmlspecialchars($item -> name);?>">
						
						
						<span class="text-menu"><?php echo $item -> name;?></span>
					</a>
				
					<!--	LEVEL 1			-->
					<?php if(isset($children[$item -> id]) && count($children[$item -> id])  ){?>
					<div class='cat_filters_home_wrapper'>
						<ul class="cat_filters_home_ul">
							<?php foreach($children[$item -> id] as $key=>$child){?>
								<?php $link = FSRoute::_('index.php?module=products&view=cat&cid='.$child->id.'&ccode='.$child->alias); ?>
								
								<li  >
										
										<a href="<?php echo $link; ?>" id="menu_item_<?php echo $child->id;?>" title="<?php echo htmlspecialchars($child -> name);?>">
											<?php echo $child -> name;?>
										</a>									
								</li>
						<?php }?>
						</ul>
					</div>	
					

					<?php } ?> 
				</li>
				<?php $t ++; ?>	
			<?php }//.foreach($level_0 as $item)?>
			<!--	CHILDREN				-->
		</ul>
		
	</div>
</amp-sidebar>

