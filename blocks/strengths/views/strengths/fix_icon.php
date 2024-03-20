<?php
global $tmpl,$config; 
$tmpl -> addStylesheet('fix_icon','blocks/strengths/assets/css');
?>


<div class="block-strengths-fix-icon">
	<?php foreach($list as $item){ ?>
		<div class="item">
			<a href="<?php echo URL_ROOT . $item->link ?>" alt="<?php echo $item->title ?>">
				<?php echo $item -> icon; ?>
				<p><?php echo $item -> title; ?></p>	
			</a>
		</div>
	<?php } ?>
</div>


