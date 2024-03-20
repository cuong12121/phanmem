<div class='share_bottom share'>

	<!-- AddThis Button BEGIN -->
	<div class="addthis_toolbox addthis_default_style">
		<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
		<div class="fb-share-button" data-href="<?php echo URL_ROOT . substr($_SERVER['REQUEST_URI'], 1); ?>" data-layout="button_count"></div>
                <div class="g-plus" data-action="share" data-annotation="bubble"></div>
		<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
	</div>

	<?php 	$tmpl -> addScript2('//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-555027bb1d2d5f59');?>	
	<?php 	$tmpl -> addScript2('https://apis.google.com/js/platform.js');?>
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.5";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
	<!-- AddThis Button END -->
</div>
