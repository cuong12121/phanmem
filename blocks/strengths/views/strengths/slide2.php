<?php
global $tmpl,$config; 
$tmpl -> addStylesheet('owl.carousel','libraries/jquery/owl.carousel.2/assets');
$tmpl -> addScript('owl.carousel.min','libraries/jquery/owl.carousel.2');
$tmpl -> addScript('slide2','blocks/strengths/assets/js');
$tmpl -> addStylesheet('slide2','blocks/strengths/assets/css');
FSFactory::include_class('fsstring');
?>
<div class='strengths_slide2_block'>
	<div class="image">
		<?php $i=0; ?>
		<?php foreach($list as $item){ ?>
			<div class="item_str <?php echo $i?'hide':'' ;?>" id="img_str_<?php echo $item-> id; ?>">
				<img class="lazy" data-src='<?php echo URL_ROOT.str_replace('/original/','/large/',$item -> image)?>' alt="<?php echo $item -> title?>"/>
				<div class="namemb"><?php echo $item -> title; ?></div>
			</div>

			<?php $i++; } ?>
		</div>
		<ul class="list_str">
			<?php $i=0; ?>
			<?php foreach($list as $item){ ?>
				<li class="i_list_str <?php echo $i?'':'active'; ?>" id="i_list_str_<?php echo $item-> id; ?>">
					<div class="stt"><?php echo $i+1; ?></div><div class="name"><?php echo $item -> title; ?><br><span class="summary"><?php echo $item -> summary; ?></span></div>
				</li>
				<?php $i++; } ?>
			</ul>
		</div>

