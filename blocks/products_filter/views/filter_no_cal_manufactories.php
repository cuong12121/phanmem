<?php 
	$str_filter_id = $manufactories_request?$manufactories_request.",".'ten-thuong-hieu':'ten-thuong-hieu';
	$link_search = FSRoute::addParameters('manu',$str_filter_id);
$i = 0;
$html_manufactory = '';
		$html_manufactory .= '<div class="field_area field_item">';
		$html_manufactory .= '<div class="field field_opened field_name normal  field_opened ">';
		$html_manufactory .= 'Hãng sản xuất';
		$html_manufactory .= '</div><div class="filters_in_field filter_4_manufactory  field_label">';
		$html_manufactory .= '<div class="filter_4_manufactory_list ">';
		
	
		
		foreach($manufactories as $filter){
			if(count($arr_manufactories_request) && in_array($filter -> alias, $arr_manufactories_request)){
				$buff_filter_id = array_diff($arr_manufactories_request,array($filter -> alias));
				$str_filter_id = implode(",",$buff_filter_id);
				$link = FSRoute::addParameters('manu',$str_filter_id);
				$html_manufactory .= '<h3 class="activated"><a href="'.$link.'" title="'.$filter ->name.'" >'.$filter ->name.'</a></h3>';
			}else{
				$str_filter_id = $manufactories_request?$manufactories_request.",".$filter -> alias:$filter -> alias;
				$link = FSRoute::addParameters('manu',$str_filter_id);
//				$link = FSRoute::_('index.php?module=products&view=cat&ccode='.$cat->alias.'&cid='.$cat -> id.'&filter='.$str_filter_id);
				$html_manufactory .= '<h3><a href="'.$link.'" title="'.$filter ->name.'" >'.$filter ->name.'</a></h3>';	
			}
		}
		$html_manufactory .= '</div>';
		$html_manufactory .= '</div>';
		$html_manufactory .= '</div>';
?>
<?php echo $html_manufactory; ?>
