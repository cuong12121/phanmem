<?php
	global $tmpl;
	$tmpl -> addStylesheet('default','blocks/instagram/assets/css');
?>
<div class="instagram_default">
	<div class="sum_instagram">
		<a href="<?php echo $link;?>" title = "<?php echo $summary;?>" target="_blink"><?php echo $summary;?></a>
	</div>
	<!-- LightWidget WIDGET --><script src="https://cdn.lightwidget.com/widgets/lightwidget.js"></script><iframe src="//lightwidget.com/widgets/<?php echo $code;?>.html" scrolling="no" allowtransparency="true" class="lightwidget-widget" style="width:100%;border:0;overflow:hidden;"></iframe>
</div>




