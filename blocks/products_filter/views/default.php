<?php global $tmpl;
$tmpl -> addStylesheet('products_filter_default','blocks/products_filter/assets/css');
//	$tmpl -> addScript('products_filter_default','blocks/products_filter/assets/js');
?>
<?php $html_current = '';?>
<?php $html_filter = '';?>
<?php 
if(count($arr_fields_current)){
	foreach( $arr_fields_current as $item){
		$html_current .= '<div class="field_item">';
		$html_current .= '<div class="field_name normal">';
		$html_current .= '<span>'.$item -> field_show.'</span>';
		$html_current .= '</div>';
		$buff_filter_id = array_diff($arr_filter_request,array($item -> alias));
		$str_filter_id = implode(",",$buff_filter_id);
		$link = FSRoute::addParameters('filter',$str_filter_id);
		$html_current .= '<div class="actived  field_label">';
		$html_current .= '<h3 ><a href="'.$link.'" title="'.$item ->filter_show.'" >'.$item ->filter_show.'</a></h3>';
		$html_current .= '</div>';
		$html_current .= '</div>';
	}
}
foreach($arr_filter_by_field as $field_show => $filters){
	$html_filter .= '<div class="field_item">';
	$html_filter .= '<div class="field_name normal">';
	$html_filter .= '<span>'.$filters[0] -> field_show.'</span>';
	$html_filter .= '</div>';
	$html_filter .= '<div class="field_label">';
	foreach($filters as $filter){
		$str_filter_id = $filter_request?$filter_request.",".$filter -> alias:$filter -> alias;
		$link = FSRoute::addParameters('filter',$str_filter_id);
		$html_filter .= '<h3><a href="'.$link.'" title="'.$filter ->filter_show.'" >'.$filter ->filter_show.': (<span>'.$filter-> total.'</span>)</a></h3>';
	}
	$html_filter .= '</div>';
	$html_filter .= '</div>';
}
?>
<div class='block_content clearfix'>
	<?php echo $html_current.$html_filter; ?>
</div>
