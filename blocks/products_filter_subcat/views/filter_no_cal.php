<?php global $tmpl;
	$tmpl -> addStylesheet('products_filter_no_cal','blocks/products_filter/assets/css');
	$tmpl -> addScript('products_filter_no_cal','blocks/products_filter/assets/js');
?>
<?php $html_filter = '';?>
<?php 
$i = 0;
foreach($arr_filter_by_field as $field_show => $filters){
		$html_filter .= '<div class="field_area">';
		if($i > 2){	
			$html_filter .= '<div class="field field_closed">';
		}else{
			$html_filter .= '<div class="field field_opened">';
		} 
		$html_filter .= $filters[0] -> field_show;
		if($i > 2){	
			$html_filter .= '</div><div class="filters_in_field filter_4_'.$filters[0] -> field_name.' " style="display:none" >';
		}else{
			$html_filter .= '</div><div class="filters_in_field filter_4_'.$filters[0] -> field_name.' ">';
		} 
		
		foreach($filters as $filter){
			if(count($arr_filter_request) && in_array($filter -> alias, $arr_filter_request)){
				$buff_filter_id = array_diff($arr_filter_request,array($filter -> alias));
				$str_filter_id = implode(",",$buff_filter_id);
				$link = FSRoute::addParameters('filter',$str_filter_id);
		
				$html_filter .= '<h3 class="activated"><a href="'.$link.'" title="'.$filter ->filter_show.'" >'.$filter ->filter_show.'</a></h3>';
			}else{
				$str_filter_id = $filter_request?$filter_request.",".$filter -> alias:$filter -> alias;
//				$link = FSRoute::addParameters('filter',$str_filter_id);
				$link = FSRoute::_('index.php?module=products&view=cat&ccode='.$cat->alias.'&filter='.$filter -> alias);
				$html_filter .= '<h3><a href="'.$link.'" title="'.$filter ->filter_show.'" >'.$filter ->filter_show.'</a></h3>';	
			}
		}
		$html_filter .= '</div>';
		$html_filter .= '</div>';
		$i ++;
}
?>
<div class='block_product_filter'>
	<?php echo $html_filter; ?>
</div>
