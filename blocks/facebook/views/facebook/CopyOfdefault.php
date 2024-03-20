<?php
global $tmpl; 
$tmpl -> addStylesheet('demo','blocks/facebook/assets/css');
//$tmpl -> addScript('jquery-ui.min','blocks/facebook/assets/js');
$tmpl -> addScript('mopSlider-2.4','blocks/facebook/assets/js');
$tmpl -> addScript('script','blocks/facebook/assets/js');
$tmpl -> addScript('jquery.pngFix','blocks/facebook/assets/pngFix');
?>	
        <div class="title-block">
            <div class="left"></div>
            <div class="center"><span><img src="<?php echo URL_ROOT."templates/default/images/icon-social.png";?>" alt="software" />LIKE US ON FACEBOOK</span></div>
            <div class="right"></div>
            <div class='clear'></div>     
        </div>
        <div class="content-block">
			<iframe src="//www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fionevn&amp;width=310&amp;height=190&amp;colorscheme=light&amp;show_faces=true&amp;border_color&amp;stream=false&amp;header=true" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:310px; height:190px;" allowTransparency="true"></iframe>
 		</div>
