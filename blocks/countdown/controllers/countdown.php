<?php
/*
 * Huy write
 */
	// models 
	include 'blocks/countdown/models/countdown.php';
	class CountdownBControllersCountdown 
	{
		function __construct()
		{
		}
		function display($parameters,$title)
		{
	        $ordering = $parameters->getParams('ordering'); 
	        $type  = $parameters->getParams('type'); 
			$limit = $parameters->getParams('limit');
			$limit = $limit ? $limit:3; 
			// call models
			$model = new CountdownBModelsCountdown();
			$style = $parameters->getParams('style');
			$style = $style?$style:'default';
			$types = $model -> get_types();

			$today_time = date('Y-m-d H:i:s');
			$data = $model -> get_record('id = 1','fs_event');

			if(($data -> date_end > $today_time )){
				$data-> status = '1';
			}else{
				$data-> status = '0';
			}



			if($style=="tabs"){
				$list_tabs =array();
				$list_tabs['new'] = $model -> get_list($ordering,$limit,'new');
				$list_tabs['selling'] = $model -> get_list($ordering,$limit,'selling');
				$list_tabs['old']  = $model -> get_list($ordering,$limit,'old');
				$html= array('new'=>'', 'selling'=>'', 'old'=>'');
				foreach ($list_tabs as $key=>$tabs){
					$link_fisrt = FSRoute::_('index.php?module=products&view=product&code='.@$tabs[0] -> alias.'&ccode='.@$tabs[0]->category_alias.'&id='.@$tabs[0]->id);
					$image_first = str_replace('/original/', '/resized/', @$tabs[0]->image);
					
					
					$i =0;
					if(count($tabs)){
						foreach ($tabs as $item) {
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
								$link = FSRoute::_('index.php?module=products&view=product&code='.$item -> alias.'&ccode='.$item->category_alias.'&id='.$item->id);
								$image = str_replace('/original/', '/resized/', $item->image);	
								$html[$key] .= '<div class="item">';
									//nội dung  sản phẩm
									$html[$key] .= '<div class="frame_inner">';
									  	$html[$key] .= '<div class="frame_image ">';
							  				$html[$key] .= '<a href="'.$link.'" title="'.$item->name.'">';
												$html[$key] .= '<img  class="img-responsive" alt="'.$item->name.'" src="'.URL_ROOT.$image.'" />';
											$html[$key] .= '</a>';
							        	$html[$key] .= '</div>';
								        $html[$key] .= '<div class="frame_title">';
											$html[$key] .= '<h2>';
												$html[$key] .= '<a href="'.$link.'" title = "'.$item -> name .'" class="name" >'. get_word_by_length(50,$item -> name).'</a>';
											$html[$key] .= '</h2>';
							        	$html[$key] .= '</div>';
							        	$html[$key] .= '<div class="frame_warranty">';
											 $html[$key] .= '<span>'.($item->warranty)?'Bảo hành: '.$item->warranty:'&nbsp;'.'</span>';
			                    		$html[$key] .= '</div>';
							        	$html[$key] .= '<div class="frame_price">';
				                           	$html[$key] .= '<span class="price ">'.format_money($price,'đ').'</span>';
											if($item ->discount ){
												$html[$key] .= '<span class="old_price">';
												$html[$key] .=($price_old)?format_money($price_old,'đ'):'';
												$html[$key] .='</span>';
											}
				                            $html[$key] .= '<div class="clearfix"></div> ';
			                       		$html[$key] .= '</div>';		
									$html[$key] .= '</div>';
									
									
									//end nội dung  sản phẩm
										$html[$key] .= '<a class="frame_view" href="'.$link.'">';
//										$html[$key] .= '<h2 class="name_view" ><a href="'.$link.'" title = "'.$item -> name .'" >'.$item -> name.'</a> </h2>';	
//								    	$html[$key] .='<div class="price_view"><span>'.format_money($price,'đ').'</span></div>';
//										$html[$key] .='<div class="divider"></div>';
										$html[$key] .=$item -> accessories ;
										$html[$key] .= '</a>';
									//end summary
									if(count($types)){
										foreach($types as $type){
											if(strpos($item -> types,','.$type->id.',') !== false || $item -> types == $type->id){
												$html[$key] .= '<div class="product_type">';
												$html[$key] .= '<img src="'.URL_ROOT.str_replace('/original/', '/original/', $type->image).'" alt="'.$type -> name.'" />';
												$html[$key] .= '</div>';
											break;	
											 }
										}
									}
									//end types
									@$discount_percent = round((($item -> price_old - $price)/$item -> price_old)*100);
									if($discount_percent){
										$html[$key] .= '<div class="discount_percent">';
												$html[$key] .= '-<span>'.$discount_percent.'</span>%';
				                    	$html[$key] .= '</div>';
									}
								$html[$key] .= '</div>';
								
							$i++;
						}
						$html[$key] .= '<div class="clearfix"></div>';
					}
				
				}
			}else{
				$list = $model -> get_list($ordering,$limit,$type);
			}


		
			// call views
			include 'blocks/countdown/views/countdown/'.$style.'.php';
		}
	}
	
?>