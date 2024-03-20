<?php
global $tmpl,$config; 
$tmpl -> addStylesheet('row_5','blocks/strengths/assets/css');
// FSFactory::include_class('fsstring');
?>

<div class="block-strengths block-strengths-2 block-strengths-row-5">
	<?php foreach($list as $item){ ?>
		<div class="item">
			<a href="<?php echo $item->link ?>" alt="<?php echo $item->title ?>">
				<?php echo $item -> image_svg; ?>	
			</a>
			<div class="content-right">
				<a class="title_name" href="<?php echo $item->link ?>" alt="<?php echo $item->title ?>"><?php echo $item -> title; ?></a>
			</div>
		</div>
	<?php } ?>
</div>

