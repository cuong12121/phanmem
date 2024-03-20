<?php
global $tmpl,$config; 
	$tmpl -> addStylesheet('images','blocks/strengths/assets/css');
	FSFactory::include_class('fsstring');
	?>
<div class='strengths_images_block cls'>
	<div class="strengths_images_block_body cls">
		<?php foreach($list as $item){ ?>
			<div class="item ">			
				<figure class="str_image">
					<a href="<?php echo $link;?>" title = "<?php echo $item-> title .' ' .$item-> title2;?>">
						<?php echo set_image_webp($item->image,'original',@$item->title.' '.@$item-> title2,'','0','','0');  ?>
					</a>
				</figure>
				<div class="box_content">
					<div class="title">
						<?php echo $item-> title;?>
					</div>
					
					<a class="title2" href="<?php echo $link;?>" title = "<?php echo $item-> title .' ' .$item-> title2;?>">
						<?php echo $item-> title2;?>
					</a>
					
					<div class="summary">
						<?php echo $item-> summary;?>
					</div>
				</div>		
			</div>		
		<?php } ?> 
	</div>
	<div class="bottom_str">
		<?php if($link){?>
			<a href="<?php echo $link;?>" title="<?php echo $link_name;?>"><?php echo $link_name;?></a>
		<?php }?>
		<?php if($link2){?>
			<a href="<?php echo $link2;?>" title="<?php echo $link_name2;?>"><?php echo $link_name2;?></a>
		<?php }?>
	</div>
</div>

