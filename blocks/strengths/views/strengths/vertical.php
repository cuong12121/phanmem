<?php
global $tmpl,$config; 
	$tmpl -> addStylesheet('vertical','blocks/strengths/assets/css');
	FSFactory::include_class('fsstring');
	?>
<div class='strengths_vertical_block cls'>

<?php foreach($list as $item){ ?>
	<div class="item">
		<div class="item-inner">
			<div class="item-l">
				<span><?php echo $item -> image_svg; ?></span>
			</div>
			<div class="item-r">
				<strong class="name">
					<?php echo $item -> title; ?>
				</strong>
				<span class="sumamry">
					<?php echo $item -> summary; ?>
				</span>
			</div>
		</div>
	</div>
	
<?php } ?>
       
 </div>

