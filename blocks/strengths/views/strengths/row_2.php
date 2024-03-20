<?php
global $tmpl,$config; 
$tmpl -> addStylesheet('row_2','blocks/strengths/assets/css');
FSFactory::include_class('fsstring');
?>
<div class="container">
	<div class="block-strengths block-strengths-1 cls">
		<?php foreach($list as $item){ ?>
			<div class="item">
				<div class="img-svg">
					<a href="<?php echo $item->link ?>" alt="<?php echo $item->title ?>"><?php echo $item -> image_svg; ?></a>
				</div>
				<div class="content-right">
					<a class="title" href="<?php echo $item->link ?>" alt="<?php echo $item->title ?>"><?php echo $item -> title; ?></a>
					<a class="summary" href="<?php echo $item->link ?>" alt="<?php echo $item->title ?>"><?php echo $item -> summary; ?></a>
				</div>
			</div>
		<?php } ?>
	</div>
</div>
