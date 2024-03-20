<?php global $tmpl;
	$tmpl -> addScript('out','blocks/banners/assets/js');
?>
<div class='banner-out' id = '<?php echo $out_id; ?>'  style="DISPLAY: none; POSITION: absolute; TOP: 0px; width:140px; overflow:hidden;" >
<div class='banners  banners-<?php echo $style; ?> block_inner block_banner<?php echo $suffix;?>' id = '<?php echo $id; ?>'  >
	<?php $i = 0;?>
	<?php foreach($list as $item){?>
		<?php if($item -> type == 1){?>
			<?php if($item -> image){?>
				<a rel="nofollow" href="<?php echo $item -> link;?>" title='<?php echo $item -> name;?>'>
					<img alt="<?php echo $item -> name; ?>" src="<?php echo URL_ROOT.$item -> image;?>" <?php echo $item -> width?'width="'.$item -> width.'"' :''?> <?php echo $item -> height?'height="'.$item -> height.'"' :''?> >
				</a>
				<?php if($i):?>
					<div class="adv_share">&nbsp;</div>
				<?php endif; ?>
			<?php }?>		
		<?php } else if($item -> type == 2){?>
			<?php if($item -> flash){?>
			<a rel="nofollow" href="<?php echo $item -> link;?>" title='<?php echo $item -> name;?>'>
				<embed menu="true" loop="true" play="true" src="<?php echo URL_ROOT.$item->flash?>"   wmode="transparent"
				pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="<?php echo $item -> width;?>" height="<?php echo $item -> height;?>">
			</a>
			<?php if($i):?>
				<div class="adv_share">&nbsp;</div>
			<?php endif; ?>
			<?php }?>
		<?php } else {?>
			<div class='banner_item_<?php echo $i; ?> banner_item' <?php echo $item -> width?'style="width:'.$item -> width.'px"':'';?>>
				<?php echo $item -> content; ?>
			</div>
		<?php }?>
		<?php $i ++; ?>
	<?php }?>   
	<div class="clear"></div>     	
</div>
</div>

 