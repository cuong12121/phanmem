<?php 
$tmpl -> addScript('jwplayer','libraries/jquery/jwplayer_6.8');
$tmpl -> addScript('video','modules/news/assets/js');
?>
 <div class='video_clip'>
	<!--	CONTENT -->
 		<?php 
	 	$Itemid  = FSInput::get('Itemid'); 
	 	$i = 0;
	 	foreach ( $video_in_news as $item ) :
	 	?>
	 		<?php if($item -> video):?>
		 		<div class='item' id='item_<?php echo $i; ?>'>
				 			<div id="video_first_area_player">Loading the player...</div>
				 			<input type="hidden" id='video_link' value="<?php echo $item -> video; ?>">
			 				<input type="hidden" id='img_link' value="<?php echo URL_ROOT.str_replace('/original/','/small/', $data -> image); ?>">
					 		<p><?php echo $item -> summary; ?></p>
			 	
			 	</div>
			 	<?php break;?>
				<?php $i ++; ?>
			<?php endif;?>
	 	<?php endforeach; ?>
	<div class='clear'></div>
</div>