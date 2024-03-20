<?php  	global $tmpl,$config;
$tmpl -> addStylesheet('landingpages','modules/landingpages/assets/css');
//$tmpl -> addScript('detail','modules/contents/assets/js');
FSFactory::include_class('fsstring');

$print = FSInput::get('print',0);

?>
<div class="landingpages_detail landingpages">
		<!-- CONTENT NAME-->
		<div class='description'>
			<?php  
			$str = $data -> content;
			$str1 = str_replace('<p>{{','{{' , $str);
			$str1 = str_replace('}}</p>','}}' , $str1);
			$str1 = str_replace('}}','{{' , $str1);
			$place=array();
			$place=explode('{{',$str1);

			foreach ($place as $item) {
				$item1 = explode(':',$item);
				if($item1[0]=='block'){
					 $block_name=$item1[1];
					echo $tmpl -> load_position($item1[1]);
				}
				else if($item1[0]=='button'){
					echo  '<div class="wrapper_ict"><a href="#proform" class="booking_nows" title="Đặt bàn ngay">Đặt bàn ngay</a></div>';
				}
				else if($item1[0]=='button2'){
					echo  '<div class="wrapper_ict_ab cls"><a href="#proform" class="booking_absolute" title="Đặt bàn ngay">Đặt bàn ngay</a></div>';
				}
				else{
					echo $item;
				}

			}

			// preg_match_all ( '#{{tmpl_block(.*?)}}#is', $data -> content, $blocks );
			// $block = $blocks[0];
			// $count_block = count($block);


			
			// $str = $data -> content;
			 
			
			// $pos = strpos($str,'?postt=0');

			// if($pos != false){
				
			// 	$str1 = str_replace(array('{{tmpl_block?='), array(''), $block);

			// 	$str2=str_replace(array('style='), array(''), $str1);
			// 	$str2 = preg_replace ( '#\?postt(.*?)}}#is', '', $str2 );
				 
				
				   
			
				
			// 	$block0 = explode('&amp;',$str2[0]);
			
			// 	$site = preg_replace ( '#{{tmpl_block(.*?)postt=0}}#is', $tmpl -> load_position('pos8'), $str );

			// }
			

				// $tmpl -> load_direct_blocks($block,array('style'=>'form'))


			 ?>


		</div>
			
		

</div>

<!-- {{tmpl_block?=testimonials&style=rectangle}} -->
