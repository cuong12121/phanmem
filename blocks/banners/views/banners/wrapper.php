<?php global $tmpl;
$tmpl -> addStylesheet('banners_wrapper','blocks/banners/assets/css');
?>

<div class='banners  banners-<?php echo $style; ?>' >
	
	<?php foreach($list as $item){?> 
		<?php if($item -> type == 1){?>
			<?php if($item -> image){?>
				<a rel="nofollow" href="<?php echo $item -> link;?>" title='<?php echo $item -> name;?>'>
					<img class="img-responsive" alt="<?php echo $item -> name; ?>" src="<?php echo URL_ROOT.''.$item -> image;?>" width="<?php echo $item -> width;?>" height="<?php echo $item -> height;?>">
				</a>
			<?php }?>		
		<?php } else if($item -> type == 2){?>
			<?php if($item -> flash){?>
				<a rel="nofollow" href="<?php echo $item -> link;?>" title='<?php echo $item -> name;?>'>
					<embed menu="true" loop="true" play="true" src="<?php echo URL_ROOT.'images/banners/flash/'.$item->flash?>" 
						pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="<?php echo $item -> width;?>" height="<?php echo $item -> height;?>">
					</a>
				<?php }?>
			<?php } else {?>
				<?php echo $item -> content; ?>
			<?php }?>
		</div>
		<div class="bottom-adv"></div>
	</div>	
<?php }?>        
</div>

