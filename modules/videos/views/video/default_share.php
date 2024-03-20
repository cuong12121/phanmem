<div class='hit_share'>
	<?php $link = URL_ROOT.substr($_SERVER['REQUEST_URI'],1); ?>
	<!-- Load Facebook SDK for JavaScript -->
	<div id="fb-root"></div>

	<!-- Your like button code -->
	<div class="fb-like" 
		data-href="<?php echo $link; ?>" 
		data-layout="button_count" 
		data-action="like" 
		data-show-faces="true">
	</div>
	<!-- Your share button code -->
	<div class="fb-share-button" 
		data-href="<?php echo $link; ?>" 
		data-layout="button_count">
	</div>
	
	<div class="g-plus" data-action="share" data-annotation="bubble" data-href="<?php echo $link; ?>"></div>
	
</div>
