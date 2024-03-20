<?php 
global $tmpl;
//$tmpl -> addStylesheet('dropdown_top','blocks/mainmenu/assets/css');
//$tmpl -> addScript('dropdown_top','blocks/mainmenu/assets/js');
?>


 <div class='mainmenu mainmenu-<?php echo $style; ?>'>
<?php 
$date_class = FSFactory::getClass('fsdate');
$Itemid = FSInput::get('Itemid',0,'int');
$module = FSInput::get('module');
$view = FSInput::get('view');
?>
	<ul class="menu-top">
		<?php $k  = 1; ?>
		<?php foreach($array_menu_root as $item):?>
			<?php if(!$item -> parent_id){?>
				<?php $link = FSRoute::_($item ->link);?>
				<?php
					$has_children  = 0;
					if(isset($array_menu_children[$item -> id])){
						$has_children = 1;
					}
				?>
				<li class="menu-item level0 first-menu-item  <?php echo $parent_active == $item -> id? 'activated':''; ?> level0 <?php echo $has_children?"has_children":"" ?>">
					<a href="<?php echo $link; ?>" title="<?php echo $item -> name; ?>"><?php echo $item -> name; ?></a><span class="box-mt"></span>
				
					<?php if(isset($array_menu_children[$item -> id])){?>
						<ul>
							<?php $i = 0;?>
							<?php foreach($array_menu_children[$item -> id] as $child):?>
									<?php $link_child = FSRoute::_($child ->link);?>
									<?php // if($i):?>
										<!--<li class='sepa' ><span></span></li>-->
									<?php // endif;?>	
									<li class='sub-item  level1 <?php echo $id_active == $child -> id? 'activated':''; ?> ' >
										<a href='<?php echo $link_child; ?>' ><span> <?php echo $child -> name; ?></span></a>  
									</li>
									<?php $i ++;?>
							<?php endforeach;?>
						</ul>
				   <?php }?> 
				</li>
			<?php }?>
			<?php $k ++; ?>
		<?php endforeach;?>
	</ul> <!-- .menu-top -->
</div>