<?php 
global $config,$tmpl;
$tmpl -> addStylesheet('menu_mobile','blocks/mainmenu/assets/css');
$ccode = FSInput::get('ccode');
$module = FSInput::get('module');
?>

<div class="block-menu_mobile">
	<div class="tab-group cls">
		<?php foreach ($list as $key => $item){ ?>	
			<?php $link = FSRoute::_($item-> link); ?>
			<div class="item_menu_mb">
				<div>
					<a href="<?php echo $link ?>" title = "<?php echo $item->name; ?>" class="icon_menu">
						<?php echo $item-> icon; ?>
				</a>
				</div>
				<a href="<?php echo $link ?>" title ="<?php echo $item->name; ?>" class="name_menu">
					<span><?php echo $item-> name; ?></span>
				</a>
			</div>
		<?php } ?>
	</div>
</div>