<?php
global $tmpl; 
	$tmpl -> addStylesheet("video_home","blocks/videos/assets/css");
	$tmpl -> addScript("video_home","blocks/videos/assets/js");	
	$html ='';
?>
<?php 
  $html .= '<div class="videos_block_body block_body cls" id="bl_video">';
 	foreach($list as $item){
 		 $html .= ' <div class="video_item">';
 			 $html .= ' <div class="video_item_inner video_item_inner_has_img">';
 				$html .= set_image_webp($item -> image,'compress',@$item -> name,'lazy',1,'');

			$html .= '<video width="100%" height="auto" poster="'. URL_ROOT.str_replace("/original/","/compress/",$item -> image.".webp").'" id="video_'.$item->id.'"  loop="" muted="" > ';          		
            			$html .= ' <source src=" '. URL_ROOT.$item->link_video. '" type="video/mp4">';
		 		$html .= ' </video> ';
		 		
		 			$html .= ' <div class="btn_play_pause pause" onclick="playPause('.$item->id.');"></div>';

	 		$html .= '</div>';
	 		//$html .= ' <div class="container">';
	 			//$html .= ' <div class="summary">';
			 		//$html .=  $item->summary;
			 	//$html .= '</div>';
	 		//$html .= '</div>';		
 		$html .= '</div>';
 	}	
$html .= '</div>';
echo $html;
?>
