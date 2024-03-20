<?php global $tmpl;
	$tmpl -> addStylesheet('banners_wrapper','blocks/banners/assets/css');
?>
<div class='banners  banners-<?php echo $style; ?> block_inner block_banner<?php echo $suffix;?>'  >
	<?php $i = 0;?>
	<?php foreach($list as $item){?>
		<?php if($item -> type == 1){?>
			<?php if($item -> image){?>
				<a href="<?php echo $item -> link;?>" title='<?php echo $item -> name;?>'  id="banner_item_<?php echo $item ->id; ?>">
					<?php if($item -> width && $item -> height){?>
					<img class="img-old img-responsive"  alt="<?php echo $item -> name; ?>" src="<?php echo URL_ROOT.$item -> image;?>" width="274px" height="<?php echo $item -> height;?>" style="height: 451px; "  >
					<?php } else { ?>
					<img class="img-old img-responsive" alt="<?php echo $item -> name; ?>" src="<?php echo URL_ROOT.$item -> image;?>" style="height: 451px; width: 274px;" >
					<?php }?>
				</a>
				<a class="description"  href="<?php echo $item -> link;?>" title='<?php echo $item -> name;?>'  id="banner_item_<?php echo $item ->id; ?>">
					<?php echo $item -> content; ?>
				</a>
			<?php }?>		
		<?php } else if($item -> type == 2){?>
			<?php if($item -> flash){?>
			<a href="<?php echo $item -> link;?>" title='<?php echo $item -> name;?>' id="banner_item_<?php echo $item ->id; ?>">
				<embed menu="true" loop="true" play="true" src="<?php echo URL_ROOT.$item->flash?>"  wmode="transparent"
				pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="<?php echo $item -> width;?>" height="<?php echo $item -> height;?>">
			</a>
			<?php }?>
		<?php } else {?>
			<div class='banner_item_<?php echo $i; ?> banner_item' <?php echo $item -> width?'style="width:'.$item -> width.'px"':'';?> id="banner_item_<?php echo $item ->id; ?>">
				<?php echo $item -> content; ?>
			</div>
		<?php }?>
		<?php $i ++; ?>
	<?php }?>   
		<div class="clear"></div>     	
</div>
	<div class="clear"></div>     	

 