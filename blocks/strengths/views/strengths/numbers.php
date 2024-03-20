<?php
global $tmpl,$config; 
	$tmpl -> addStylesheet('numbers','blocks/strengths/assets/css');
	$tmpl -> addScript('numbers','blocks/strengths/assets/js');
	FSFactory::include_class('fsstring');
?>

<div class="block-strengths-numbers_mb ">
	<div class="block-strengths-numbers  cls">
		<?php $i=0; foreach($list as $item){ ?>
			<div class="item">
				<div class="body">
					<!-- <div class="icon isvgbf">
						<?php //echo $item-> icon; ?>
					</div> -->
					<div class="text">
						<span class="txt" id="txt_<?php echo $i; ?>" data-t="<?php echo $item -> title; ?>">0</span>
						<span class="sum"><?php echo $item-> title2; ?></span>
					</div>
					<?php if($i == 1){?>
						<div class="box_start">
							<?php 
							for ($ii=0; $ii < 5; $ii++) { 
								echo $item-> icon;
							}?>
						</div>

					<?php }?>
					<div class="title">
						<?php echo $item -> summary; ?>
					</div>
				</div>
			</div>
		<?php $i++; } ?>
	</div>
	<div class="sum_cat">
		<?php echo $cat->des;?>
	</div>
</div>