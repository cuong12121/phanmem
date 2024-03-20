<?php global $tmpl;
//	$tmpl -> addStylesheet('jquery-ui','libraries/jquery/jquery-ui-1.11.4');
//	$tmpl -> addScript("jquery-ui","libraries/jquery/jquery-ui-1.11.4","top");
//	$tmpl -> addStylesheet('jquery-ui','libraries/jquery/jquery.ui');
//	$tmpl -> addScript("jquery-ui","libraries/jquery/jquery.ui","top");
	$tmpl -> addStylesheet('products_filter_no_cal','blocks/products_filter/assets/css');
	$tmpl -> addScript('products_filter_no_cal','blocks/products_filter/assets/js',"top");
?>
<?php $html_filter = '';?>
<?php 
$i = 0;
foreach($arr_filter_by_field as $field_show => $filters){
		$html_filter .= '<div class="field_area field_item">';
		$closed = 0;
//		if($i > 2){	
//			if(!in_array( $filters[0] -> field_name, $arr_fieldname_current)){
//				$closed = 1;
//			}
//		}
		
		$html_filter .= '<div class="field_name normal field  '.($closed?'field_closed':'field_opened' ). ' " data-id="id_field_'.$filters[0] -> field_name.'">';
		
		$html_filter .= $filters[0] -> field_show;
		$html_filter .= '</div><div id="'.$filters[0] -> field_name.'"  class="field_label filters_in_field filter_4_'.$filters[0] -> field_name.'" '.($closed?' style="display:none"':'' ). '  >';
		
		if($filters[0] -> field_name != 'color_id'){
			foreach($filters as $filter){
				if(count($arr_filter_request) && in_array($filter -> alias, $arr_filter_request)){
					$buff_filter_id = array_diff($arr_filter_request,array($filter -> alias));
					$str_filter_id = implode(",",$buff_filter_id);
					$link = FSRoute::addParameters('filter',$str_filter_id);
			
					$html_filter .= '<h3 class="activated"><a href="'.$link.'" title="'.$filter ->filter_show.'" >'.$filter ->filter_show.'</a></h3>';
				}else{
					$str_filter_id = $filter_request?$filter_request.",".$filter -> alias:$filter -> alias;
					$link = FSRoute::addParameters('filter',$str_filter_id);
					$html_filter .= '<h3><a href="'.$link.'" title="'.$filter ->filter_show.'" >'.$filter ->filter_show.'</a></h3>';	
				}
			}
		}else{ // Màu sắc có giao diện riêng
//			print_r($colors);
			foreach($filters as $filter){
				
//				echo $filter -> filter_value;
				if(!isset($colors[$filter -> filter_value]))
					continue;
				$color = $colors[$filter -> filter_value];
				if(count($arr_filter_request) && in_array($filter -> alias, $arr_filter_request)){
					$buff_filter_id = array_diff($arr_filter_request,array($filter -> alias));
					$str_filter_id = implode(",",$buff_filter_id);
					$link = FSRoute::addParameters('filter',$str_filter_id);
			
					$html_filter .= '<a href="'.$link.'" title="'.$filter ->filter_show.'"  class="activated"><span style="background: #'.$color -> code.'"></span></a>';
				}else{
					$str_filter_id = $filter_request?$filter_request.",".$filter -> alias:$filter -> alias;
					$link = FSRoute::addParameters('filter',$str_filter_id);
					$html_filter .= '<a href="'.$link.'" title="'.$filter ->filter_show.'" ><span style="background: #'.$color -> code.'"></span></a>';	
				}
			}
		}
		$html_filter .= '</div>';
		$html_filter .= '</div>';
		$i ++;
}
?>
<div class='block_product_filter'>
	<?php // include 'filter_no_cal_manufactories.php'; ?>
	<?php echo $html_filter; ?>
</div>
