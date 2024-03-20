<?php global $tmpl,$config;?>
<?php $tmpl -> addStylesheet('column','blocks/share/assets/css'); ?>
<div class="title">Kết nối với chúng tôi</div>
<div class="share_column">
	<?php if(isset($config['facebook']) && !empty($config['facebook'])){?>
		<a class="facebook-icon" href="<?php echo $config['facebook']; ?>"  title="Link youtube" rel="nofollow" target="_blink">
			<i class="fa fa-facebook"></i>Facebook
		</a>	
	<?php }?>
	<?php if(isset($config['googleplus']) && !empty($config['googleplus'])){?>
		<a class="googleplus-icon" href="<?php echo $config['googleplus']; ?>"  title="Link googleplus" rel="nofollow" target="_blink">
			<i class="fa fa-google-plus"></i>Google plus
		</a>	
	<?php }?>
	<?php if(isset($config['twitter']) && !empty($config['twitter'])){?>
		<a class="twitter-icon" href="<?php echo $config['twitter']; ?>"  title="Link twitter" rel="nofollow" target="_blink">
			<i class="fa fa-twitter"></i>Twitter
		</a>
	<?php }?>
	<?php if(isset($config['youtube']) && !empty($config['youtube'])){?>
		<a class="youtube-icon" href="<?php echo $config['youtube']; ?>"  title="Link youtube" rel="nofollow" target="_blink">
			<i class="fa fa-youtube"></i>Youtube
		</a>	
	<?php }?>
	<div class="clear"></div>
</div>
			
