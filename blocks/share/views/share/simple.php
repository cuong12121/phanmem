<?php
global $tmpl,$config; 
?>	
<div class="share_icon">
	<?php if(isset($config['share']) && !empty($config['share'])){ ?>
		<?php echo $config['share']; ?>	
	<?php }?>
</div>
