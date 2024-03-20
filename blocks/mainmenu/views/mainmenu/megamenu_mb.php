<?php global $tmpl;
$tmpl -> addStylesheet('megamenu_mb','blocks/mainmenu/assets/css');
$tmpl -> addScript('megamenu_mb','blocks/mainmenu/assets/js');
?>
<div class="megamenu_mb ">
	<div class="close_all">
		<div class="close_all_inner">
		<div class="navicon-line"></div>
		<div class="navicon-line"></div>
		<span>Đóng</span>
		</div>
	</div>
	<div class="label" id="menu_">&nbsp;</div>
	<ul class="menu scroll_bar cls">
		<?php echo $html ;?>      
	</ul>
	<div class="text_menu">
		<?php global $config;
				echo $config['text_menu']; ?>
	</div>
</div>