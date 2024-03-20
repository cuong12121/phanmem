<?php
global $tmpl,$config,$is_mobile; 
$tmpl -> addStylesheet('img','blocks/strengths/assets/css');
FSFactory::include_class('fsstring');
?>

<div class="note"><?php echo $cat[0]-> name; ?></div>
<div class='strengths_img_block cls'>
	<?php $i=0; ?>
	<?php foreach($list as $item){ $i++; ?>
		<div class="item item_<?php echo $i; ?>" <?php if(!$is_mobile && ($i==1)) echo 'data-aos="fade-down-right"' ?> <?php if(!$is_mobile && ($i==2)) echo 'data-aos="fade-down"' ?> <?php if(!$is_mobile && ($i==4)) echo 'data-aos="fade-up-right"' ?> <?php if(!$is_mobile && ($i==3)) echo 'data-aos="fade-down-left"' ?> <?php if(!$is_mobile && ($i==6)) echo 'data-aos="fade-up-left"' ?> <?php if(!$is_mobile && ($i==5)) echo 'data-aos="fade-up"' ?> >
			<div class="item-inner">
				<div class="image">
					<a href="<?php echo $item -> link; ?>" title="<?php echo $item -> title; ?>">
					<img src='<?php echo URL_ROOT.str_replace('/original/','/large/',$item -> image)?>' alt="<?php echo $item -> title?>"/>
					</a>
				</div>
				<div class="item-r">
					<div class="name">
						<a href="<?php echo $item-> link; ?>" title="<?php echo $item -> title; ?>"></a>
						<?php echo $item -> title; ?>
					</div>
				</div>
			</div>
		</div>
		<div class="item_break"></div>
	<?php } ?>

</div>

