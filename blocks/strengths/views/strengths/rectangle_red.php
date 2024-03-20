<?php
global $tmpl,$config; 
	$tmpl -> addStylesheet('retangle','blocks/strengths/assets/css');
	FSFactory::include_class('fsstring');
	?>
<div class='strengths_retangle_block cls'>

<?php foreach($list as $item){ ?>
	<div class="item">
		<div class="item-inner">
			<div class="item-l">
				<i class="fa fa-<?php echo trim($item -> icon); ?>"></i>
			</div>
			<div class="item-r">
				<span class="name">
					<?php echo $item -> title; ?>
				</span>
				<span class="sumamry">
					<?php echo $item -> summary; ?>
				</span>
			</div>
		</div>
	</div>
<?php } ?>
       
 </div>

