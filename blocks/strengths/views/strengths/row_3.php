<?php
global $tmpl,$config; 
$tmpl -> addStylesheet('row_3','blocks/strengths/assets/css');
// FSFactory::include_class('fsstring');
?>

<div class="block-strengths block-strengths-row-3 cls" >
	<div class="block_title">
		<?php echo $title; ?>
	</div>
	<div class="box_item_r cls">
		
		<?php 
		$i = 0;
		foreach($list as $item){	
			?>
			<div class="item item_<?php echo $i % 2;?>">
				<div class="icon_svg">
					<div class="inner_icon">
						<?php //echo $item -> icon; ?>
						<?php echo set_image_webp($item->image,'compress',@$item->title,'','0','');  ?>
						
					</div>
				</div>
				<div class="content-right">
					<a class="title" href="<?php echo $item->link ?>" alt="<?php echo $item->title ?>"><?php echo $item -> title; ?></a>
					<div class="summary"><?php echo $item -> summary;?></div>
				</div>
			</div>
		<?php 
		$i++;
		} 
		?>
	</div>
</div>

