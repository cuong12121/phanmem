<?php
global $tmpl,$config; 
	$tmpl -> addStylesheet('default','blocks/material/assets/css');
	FSFactory::include_class('fsstring');
?>

<?php if(!isset($color)){
	$color = '';
}?>

<div class="block_material_default" > 	
	<div class="block_material_default_body cls">				
		<?php if(!empty($list)){?>
			<?php foreach ($list as $item){ ?>
				<div class="item">
					<div class="material_defaul_left">
						<div class="title_core"><?php echo $item->title2;?></div>
						<h2 class="block_title" <?php echo (@$color)?'style = "'.@$color.'"':'';?> ><?php echo $item->title;?></h2>
						<div class="content_material">
							<?php echo $item->summary;?>
						</div>
					</div>
					<div class="material_defaul_right">
						<?php echo set_image_webp($item->image,'large',@$item->title,'','','');  ?>
					</div>
				</div>
			<?php } ?>
		<?php }?>	
	</div>
</div>


