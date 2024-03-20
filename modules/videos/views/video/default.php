<?php  	global $tmpl;
//$tmpl -> addStylesheet('videos','modules/videos/assets/css');
$tmpl -> addStylesheet('video','modules/videos/assets/css');

$tmpl -> addScript('normal','modules/videos/assets/js');
// $tmpl -> addScript('jwplayer','libraries/jquery/jwplayer-7.4.3','top');
// $tmpl -> addScript('video','modules/videos/assets/js','top');

//$tmpl -> addScript('form');
//$tmpl -> addScript('main');
//$tmpl -> addScript('news_detail','modules/videos/assets/js');

$print = FSInput::get('print',0);
?>
<div class="video_detail page_no_home cls">
	<div class="video_bottom_l cls">
		<h1 class='content_title'>
			<?php	echo $data -> title; ?>
		</h1>

		



	    <?php include_once 'default_video.php'; ?>
	    <div class="description">
	    	<?php	echo $data -> summary; ?>
	    </div>
	</div>

    <div class="video_bottom_r right_b cls">
      <?php if($tmpl->count_block('right_b')) {?>                 
          <?php  echo $tmpl -> load_position('right_b', 'XHTML2');?>                          
      <?php }?>         
    </div>

    <div class="clear"></div>
	<?php include_once 'default_related.php'; ?>			
</div>