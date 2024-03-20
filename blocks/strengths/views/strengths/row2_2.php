<?php
global $tmpl,$config; 
$tmpl -> addStylesheet('row2_2','blocks/strengths/assets/css');
FSFactory::include_class('fsstring');
?>

<div class="block-strengths-row2-2">
	<?php foreach($list as $item){ ?>
		
		<a class="item" title="<?php echo $item -> title; ?>" href="<?php echo $item->link ?>">
			<?php if(!empty($item->image)){ ?>
			<img src="<?php echo URL_ROOT .$item->image ?>" alt="<?php echo $item -> title; ?>">
			<?php } ?>
			<?php echo $item -> title; ?>
		</a>
		
	<?php } ?>
</div>

