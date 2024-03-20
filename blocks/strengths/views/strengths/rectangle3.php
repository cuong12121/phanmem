<?php
global $tmpl,$config,$is_mobile; 
$tmpl -> addStylesheet('retangle3','blocks/strengths/assets/css');
FSFactory::include_class('fsstring');
?>
<div class='strengths_retangle3_block cls'>
	<?php $i=0; ?>
	<?php foreach($list as $item){ $i++; ?>
		<div class="item item_<?php echo $i; ?>" >
			<div class="item-inner">
				<div class="item-l">
					<div class="isvg">
						<a href="<?php echo $item->link; ?>" title="<?php echo $item -> title;?>">
							<?php echo $item -> icon; ?>
						</a>
					</div>
				</div>
				<div class="item-r">
					<a href="<?php echo $item->link; ?>" title="<?php echo $item -> title;?>"> 
						<span class="title">
							<?php echo $item -> title; ?>
						</span><br>
						<?php echo $item -> summary; ?>
					</a>
				</div>
			</div>
		</div>
		<div class="item_break"></div>
	<?php } ?>

</div>

