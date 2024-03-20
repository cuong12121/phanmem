<?php 
global $config,$tmpl;
$tmpl -> addStylesheet('submenu','blocks/mainmenu/assets/css');
?>

<div class="block-submenu">
	<div class="tab-group">
		<?php foreach ($list_submenu_new as $key => $item){ ?>
			
			<?php 
				$link = FSRoute::_('index.php?module=news&view=cat&ccode='.$item -> alias); 
			?>
			<a href="<?php echo $link ?>"><?php echo $item->name; ?></a>
		<?php } ?>
	</div>
</div>