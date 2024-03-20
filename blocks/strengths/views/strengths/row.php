<?php
global $tmpl,$config; 
$tmpl -> addStylesheet('row','blocks/strengths/assets/css');
FSFactory::include_class('fsstring');
?>
<div class="container">
	<div class="block-strengths">
		<?php foreach($list as $item){ ?>
			<div class="item">
				<div class="img-svg"><a href="<?php echo $item->link ?>"><?php echo $item -> image_svg; ?></a></div>
				
				<div class="title"><a href="<?php echo $item->link ?>"><?php echo $item -> title; ?></a></div>

			</div>
		<?php } ?>
		

	</div>
</div>
