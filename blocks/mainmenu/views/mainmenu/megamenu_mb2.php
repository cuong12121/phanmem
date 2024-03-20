<?php global $tmpl;
	$tmpl -> addStylesheet('megamenu_mb2','blocks/mainmenu/assets/css');
	$tmpl -> addScript('megamenu_mb2','blocks/mainmenu/assets/js');
?>

<div class="megamenu_mb ">
	<div class="close_all">
		<div class="navicon-line"></div>
		<div class="navicon-line"></div>
	</div>
	<ul class="menu scroll_bar">
		<div class="label" id="menu_">Menu</div>
		<?php echo $html ;?>      
	</ul>
</div>