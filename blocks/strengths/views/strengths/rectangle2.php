<?php
global $tmpl,$config,$is_mobile; 
	$tmpl -> addStylesheet('retangle2','blocks/strengths/assets/css');
	FSFactory::include_class('fsstring');
	?>
<div class='strengths_retangle2_block cls'>
<?php $i=0; ?>
<?php foreach($list as $item){ $i++; ?>
	<div class="item" >
		<div class="item-inner cls">
			<div class="item-l">
				<div class="isvg">
				<?php echo ($item -> icon); ?>
				</div>
			</div>
			<div class="item-r">
				<div class="name">
				<strong>
					<?php echo $item -> title; ?>
				</strong>
				</div>
				<div class="summary">
					<?php echo $item -> summary; ?>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
<div class="cat_summary">
	<?php echo $cat-> des; ?>
</div>
<div class="readmore">
	<a href="<?php echo $cat-> link ?>" title="Thông tin bảo hành">Thông tin bảo hành</a>
</div>
       
 </div>

