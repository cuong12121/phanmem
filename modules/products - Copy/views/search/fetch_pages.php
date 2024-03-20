<?php 
$html ='';
$i=0;
	foreach ($list as $item) {
		$discount ='';		
		$promotion ='';
		$price = calculator_price($item->price,$item->price_old,$item -> is_hotdeal,$item->date_start,$item->date_end);
		$link = FSRoute::_('index.php?module=products&view=product&code='.$item->alias.'&id='.$item -> id.'&ccode='.$item->category_alias.'&Itemid=5');
			$html .='<li class="product '.$promotion.'">';
				$html .='<div class="frame_inner">';
					$html .='<div class="frame_img_cat ">';
				    	$html .='<a href="'.$link.'" title = "'.$item -> name .'" >';
				       		$html .='<img class="img-responsive" src="'.URL_ROOT.str_replace('/original/', '/resized/', $item->image).'" alt="'.htmlspecialchars ($item -> name).'"  />';
				   		$html .='</a>';
			        $html .='</div>';
			    	$html .='<div class="frame_title">';
						$html .='<h2 class="name" ><a href="'.$link.'" title = "'.$item -> name .'" >'.$item -> name.'</a> </h2>';	
                   	$html .='</div>';
			        $html .='<div class="frame_price">';
		       			$html .='<span class="price">'.format_money($price['price']).'</span>';
			        	$html .='<span class="price_old">';
		        			$html .=(@$price['percent'])?format_money($price['price_old']):'';
			        	$html .='</span>';
			        $html .='</div>';
			    $html .='</div>';    
			$html .='</li>';
			$i++;
	}
?>