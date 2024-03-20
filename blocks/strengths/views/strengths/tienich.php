<?php
global $tmpl,$config,$is_mobile; 
$tmpl -> addStylesheet('tienich','blocks/strengths/assets/css');
$tmpl -> addScript('tienich','blocks/strengths/assets/js');
FSFactory::include_class('fsstring');
?>
<div class='strengths_tienich_block cls'>
	<ul class="menu_ti cls">
		<?php $i=0; ?>
		<?php foreach($list as $item){?>
			<li class="menu_item_str menu_item_str_<?php echo $i ;?> <?php echo $i?'':'active'; ?>" id="li_str_<?php echo $item-> id; ?>" ><div class="name_item"><div class="stt"><!-- 0<?php echo $i+1 ?> --></div><?php echo $item-> title; ?></div></li>
			<?php $i++ ;} ?>
		</ul>
		<?php $i=0; ?>
		<?php foreach($list as $item){?>
			<div class="content_str <?php echo $i?'c_no':'c_yes'; ?>" id="content_str_<?php echo $item-> id; ?>" >
				<div class="item-inner">
					<div class="image">
						<img src='<?php echo URL_ROOT.str_replace('/original/','/large/',$item -> image)?>' alt="<?php echo $item -> title?>"/>
					</div>
					<div class="item-r">

						<div class="summary">
							<?php echo $item -> summary; ?>
						</div>
					</div>
				</div>
			</div>

			<?php $i++; } ?>

		</div>

