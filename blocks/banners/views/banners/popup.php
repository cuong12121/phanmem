<?php global $tmpl;
$tmpl -> addStylesheet('popup','blocks/banners/assets/css');
$tmpl -> addScript('popup','blocks/banners/assets/js');
?>
<div class="popup hide">
	<div class="container">
		<div class='banners banner_popup cls banners-<?php echo $style; ?> block_inner block_banner<?php echo $suffix;?>'  >

			<?php $i = 0;?>
			<?php foreach($list as $item){?>
				<?php $link_admin = $link_admin_banner.$item-> id; ?>
				<?php if($item -> type == 1){?>
					<div class="item">
						<?php if(!$i){?>
							<div id="close_form" class="close hide">x</div>
						<?php } ?>
						<?php if($item -> image){?>
							<a rel="nofollow" href="<?php echo $item -> link;?>" title='<?php echo $item -> name;?>'  id="banner_item_<?php echo $item ->id; ?>" class="banner_item">
								<?php if(!$load_lazy){ ?>
									<?php if($item -> width && $item -> height){?>
										<img class="img-old img-responsive lazy"  alt="<?php echo $item -> name; ?>"  data-src="<?php echo URL_ROOT.str_replace('/original/','/compress/',$item->image); ?>" width="<?php echo $item -> width;?>" height="<?php echo $item -> height;?>" >
									<?php } else { ?>
										<img class="img-old img-responsive lazy" alt="<?php echo $item -> name; ?>" data-src="<?php echo URL_ROOT.str_replace('/original/','/compress/',$item->image);?>" >
									<?php }?>
								<?php } else { ?>
									<?php if($item -> width && $item -> height){?>
										<img class="img-old img-responsive "  alt="<?php echo $item -> name; ?>"  src="<?php echo URL_ROOT.str_replace('/original/','/compress/',$item->image);?>" width="<?php echo $item -> width;?>" height="<?php echo $item -> height;?>" >
									<?php } else { ?>
										<img class="img-old img-responsive" alt="<?php echo $item -> name; ?>" src="<?php echo URL_ROOT.str_replace('/original/','/compress/',$item->image);?>" >
									<?php }?>
								<?php }?>
							</a>

						<?php }?>		
					<?php } else if($item -> type == 2){?>
						<?php if($item -> flash){?>
							<a rel="nofollow" href="<?php echo $item -> link;?>" title='<?php echo $item -> name;?>' id="banner_item_<?php echo $item ->id; ?>"  class="banner_item">
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
						<?php if($check_edit) { ?>
							<li class="admin_edit_detail"><a rel="nofollow" target="_blank" href="<?php echo $link_admin;?>" title="Sửa chi tiết"></a></li>
						<?php } ?>
					</div>
				<?php }?>   
				<div class="clear"></div>     	
			</div>
		</div>
	</div>
	<div class="clear"></div>     	

