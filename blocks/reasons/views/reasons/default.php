<?php
global $tmpl,$config; 
	$tmpl -> addStylesheet('default','blocks/reasons/assets/css');
	FSFactory::include_class('fsstring');
?>

<?php if(!isset($color)){
	$color = '';
}?>

<div class="block_reasons_default" id="cai_reasons_<?php echo $cat->id;?>" style="background-image: url(<?php echo $cat->image;?>);"> 
<!-- <div class="block_reasons_default" id="cai_reasons_<?php //echo $cat->id;?>"> -->
	
	<div class="container">
		<div class="block_reasons_default_body cls">
			<div class="reasons_defaul_left">
				<div class="title_core"><?php echo $cat->name2;?></div>
				<h2 class="block_title" <?php echo (@$color)?'style = "'.@$color.'"':'';?> ><?php echo $cat->name;?></h2>
				<div class="content_reasons">
					<?php echo $cat->des;?>
				</div>
				<div class="attention_reasons">
					<?php echo $cat->attention;?>
				</div>
			</div>
			<div class="reasons_defaul_right">
				<?php if(!empty($list)){?>
					<?php foreach ($list as $item){ ?>
						<div class="item">
							<h3 class=" block_title2" <?php echo (@$color)?'style = "'.@$color.'"':'';?>><?php echo $item->title;?></h3>
							<div class="summary"><?php echo $item->summary;?></div>
						</div>
					<?php } ?>
				<?php }?>
			</div>
		</div>
	</div>	
</div>


