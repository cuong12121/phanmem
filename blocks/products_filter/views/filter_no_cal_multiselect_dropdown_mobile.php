<?php global $tmpl,$is_mobile;
//	$tmpl -> addStylesheet('jquery-ui','libraries/jquery/jquery-ui-1.11.4');
//	$tmpl -> addScript("jquery-ui","libraries/jquery/jquery-ui-1.11.4","top");
//	$tmpl -> addStylesheet('jquery-ui','libraries/jquery/jquery.ui');
//	$tmpl -> addScript("jquery-ui","libraries/jquery/jquery.ui","top");
	$tmpl -> addStylesheet('products_filter_no_cal_dropdown_mobile','blocks/products_filter/assets/css');
	$tmpl -> addScript('products_filter_no_cal_dropdown','blocks/products_filter/assets/js');
	$html_filter = '';
	$html_filter3 = '';
	$html_current= '';
	if($cat){
		$tablename = $cat -> tablename;
		$link_dell = FSRoute::_('index.php?module=products&view=cat&cid='.$cat->id.'&ccode='.$cat->alias);
	}else{
		$tablename = 'fs_products';
		$link_dell = FSRoute::_('index.php?module=products&view=home');
	}
?>
<?php //if($is_mobile) include 'subcats.php'; ?>
<?php 
$i = 0;
$html_filter = $html_filter.$html_filter3;
// unset($arr_filter_by_field['manufactory']);
 
if($tablename != 'fs_products') {
foreach($arr_filter_by_field as $field_show => $filters){
		if( (strpos($cat -> list_parents, ',227,') !== false) && ($filters[0] -> field_name == 'manufactory')){
			continue;
		}
		
			
		$html_filter .= '<div class="field_area field_item" id="m-'.$filters[0] -> field_name.'">';
		$closed = 0;
//		if($i > 2){	
//			if(!in_array( $filters[0] -> field_name, $arr_fieldname_current)){
//				$closed = 1;
//			}
//		}
		$count_filter = count($filters);
		$item_in_column = 5;
		$cols = floor($count_filter/$item_in_column);
		if($cols > 3){
			$cols = 3;
		}
		
		$html_filter .= '<div class="field_name normal field  '.($closed?'field_closed':'field_opened' ). ' " data-id="id_field_'.$filters[0] -> field_name.'">';
		
		$html_filter .= '<span>'.$filters[0] -> field_show.'</span>';


		$html_filter .= '</div><div id="'.$filters[0] -> field_name.'"  class="field_label filters_in_field filters_in_field_'.$cols.'_column filter_4_'.$filters[0] -> field_name.'" '.($closed?' style="display:none"':'' ). '  >';

		

		$html_filter .= '<div class="filters_in_field_inner cls">';
		$html_filter .='<span class="close"><svg height="10px" viewBox="0 0 64 64" enable-background="new 0 0 64 64">
  <g>
    <path fill="#4e4b4b" d="M28.941,31.786L0.613,60.114c-0.787,0.787-0.787,2.062,0,2.849c0.393,0.394,0.909,0.59,1.424,0.59   c0.516,0,1.031-0.196,1.424-0.59l28.541-28.541l28.541,28.541c0.394,0.394,0.909,0.59,1.424,0.59c0.515,0,1.031-0.196,1.424-0.59   c0.787-0.787,0.787-2.062,0-2.849L35.064,31.786L63.41,3.438c0.787-0.787,0.787-2.062,0-2.849c-0.787-0.786-2.062-0.786-2.848,0   L32.003,29.15L3.441,0.59c-0.787-0.786-2.061-0.786-2.848,0c-0.787,0.787-0.787,2.062,0,2.849L28.941,31.786z"></path>
  </g>
</svg></span>';
		

 // || $filters[0]-> field_name !='manufactory'

		if($filters[0] -> field_name != 'color_id'){
			foreach($filters as $filter){
				




				if(!empty($arr_filter_request) && count($arr_filter_request) && in_array($filter -> alias, $arr_filter_request)){
					$buff_filter_id = array_diff($arr_filter_request,array($filter -> alias));
					$str_filter_id = implode(",",$buff_filter_id);
					$link = FSRoute::addParameters('filter',$str_filter_id);
			
					$html_filter .= '<div class="activated cls item"><a href="'.$link.'" title="'.$filter ->filter_show.'" >'.$filter ->filter_show.'</a></div>';
					$html_current .=  '<a href="'.$link.'" title="'.$filter ->filter_show.'" >'.$filter ->filter_show.' </a>';
				}else{
					$str_filter_id = $filter_request?$filter_request.",".$filter -> alias:$filter -> alias;
					$link = FSRoute::addParameters('filter',$str_filter_id);
					$html_filter .= '<div class="cls item"><a href="'.$link.'" title="'.$filter ->filter_show.'" ><i class="icon_v1 "></i>'.$filter ->filter_show.'</a></div>';	
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
		$html_filter .= '</div>';
		$i ++;
}
}
?>



<div class='block_product_filter cls'>
	<div class="block_product_filter_tt">
		Lọc theo
	</div>
	<div class="block_product_filter_ct">
		<?php echo $html_filter; ?>
	</div>
	
</div>

<?php if ($html_current ){?>

    <?php $html_current = '<div class="choosedfilter">'.$html_current; ?>
     <?php $html_current .= '<a  class="reset" href="'.$link_dell.'" >Xóa hết</a></div>'; ?>    	
      <?php $tmpl->assign ( 'filter_current', $html_current ); ?>

<?php } ?>