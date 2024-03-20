<?php global $tmpl,$config;?>
<?php  $tmpl -> addStylesheet('hotline','blocks/onlinesupport/assets/css')?>
<div class="hotline">
				<div class="hotline-phone">
					<span><?php echo $config['hotline1']; ?></span>
				</div>
				<div class="hotline-athis">
				<?php if(isset($config['facebook']) && !empty($config['facebook'])){?>
					<a href="<?php echo $config['facebook']; ?>"  title="Link youtube" rel="nofollow" target="_blink"><img alt="link facebook" src="<?=URL_ROOT;?>/blocks/share/assets/images/facebook.png" /></a>	
				<?php }?>
				<?php if(isset($config['googleplus']) && !empty($config['googleplus'])){?>
					<a href="<?php echo $config['googleplus']; ?>"  title="Link googleplus" rel="nofollow" target="_blink"><img alt="link googleplus" src="<?=URL_ROOT;?>/blocks/share/assets/images/google.png" /></a>	
				<?php }?>
				<?php if(isset($config['twitter']) && !empty($config['twitter'])){?>
					<a href="<?php echo $config['twitter']; ?>"  title="Link twitter" rel="nofollow" target="_blink"><img alt="link twitter" src="<?=URL_ROOT;?>/blocks/share/assets/images/twitter.png" /></a>	
				<?php }?>
				<?php if(isset($config['youtube']) && !empty($config['youtube'])){?>
					<a href="<?php echo $config['youtube']; ?>"  title="Link youtube" rel="nofollow" target="_blink"><img alt="link youtube" src="<?=URL_ROOT;?>/blocks/share/assets/images/youtube.png" /></a>	
				<?php }?>
				</div>
				<div class="clear"></div>
			</div>
			
