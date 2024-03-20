<?php 
$html ='';
foreach($list as $item ){
	$discount ='';		
	if($item -> is_hotdeal){
		if($item -> date_end >  date('Y-m-d H:i:s') && $item->date_start <  date('Y-m-d H:i:s')){
			$price = $item->price;
			$price_old = $item->price_old;
		}else{
			$price = $item->price_old;
			$price_old = '';
		}
	}else{
		$price= $item->price;
		$price_old = $item->price_old;
	}
	$link = FSRoute::_('index.php?module='.$this -> module.'&view=product&code='.$item->alias.'&id='.$item -> id.'&ccode='.$item->category_alias.'&Itemid=5');

		$html .='<li class="product">';
			$html .='<div class="frame_inner">';
            	$html .='<div class="frame_img_cat ">';
			    	$html .='<a href="'.$link.'" title = "'.$item -> name .'" >';
			       		$html .='<img class="img-responsive" src="'.URL_ROOT.str_replace('/original/', '/resized/', $item->image).'" alt="'.htmlspecialchars ($item -> name).'"  />';
			   		$html .='</a>';
		        $html .='</div>';
			   	$html .='<div class="frame_title">';
					$html .='<h2 class="name" ><a href="'.$link.'" title = "'.$item -> name .'" >'.get_word_by_length(52,$item -> name).'</a> </h2>';	
             	$html .='</div>';
			 	$html .='<div class="frame_price">';
					$html .='<span class="price">'.format_money($price,'VNĐ').'</span>';
		            $html .='<span class="price_old">';
		            if($item-> discount ){
			         	$html .=($price_old)?format_money($price_old,'đ'):''; 
			        }	
					$html .='</span>';
				$html .='</div>';
	        $html .='</div>';  
		$html .='</li>';

} 
