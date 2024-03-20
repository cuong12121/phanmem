<?php global $tmpl;
$tmpl -> addStylesheet('products_filter_no_cal_dropdown','blocks/products_filter/assets/css');
$tmpl -> addScript('products_filter_no_cal_dropdown','blocks/products_filter/assets/js');
$html_filter = '';
//if(empty($html_current)){
	$html_current= '';
//}

if($cat){
	$tablename = $cat -> tablename;
	$link_dell = FSRoute::_('index.php?module=products&view=cat&cid='.$cat->id.'&ccode='.$cat->alias);
}else{
	$tablename = 'fs_products';
	$link_dell = FSRoute::_('index.php?module=products&view=home');
}
?>
<?php //include 'subcats.php'; ?>
<?php 
$i = 0;
unset($arr_filter_by_field['manufactory']);
//unset($arr_filter_by_field['price']);
if($tablename != '') {
	foreach($arr_filter_by_field as $field_show => $filters){

		if($filters[0] -> field_name == 'price'){
			$html_filter .= '<div class="fl price_scroll cls" id="m-'.$filters[0] -> field_name.'">';
			$html_filter .= '<div class="fl price_ft">
			<label>Chọn mức giá: </label>';
			$v=0;

			foreach($filters as $filter){ 
				$v++;
				if($v>7){
					continue;
				}
				//$str_filter_id = $filter_request?$filter_request.",".$filter -> alias:$filter -> alias;
				//$link = FSRoute::addParameters('filter',$str_filter_id);

				//$html_filter .= '<a href="'.$link.'" title="'.$filter ->filter_show.'" >'.$filter ->filter_show.' </a>';

				if(!empty($arr_filter_request) && count($arr_filter_request) && in_array($filter -> alias, $arr_filter_request)){
					$buff_filter_id = array_diff($arr_filter_request,array($filter -> alias));
					$str_filter_id = implode(",",$buff_filter_id);
					$link = FSRoute::addParameters('filter',$str_filter_id);
					if($checkmanu == 1){
						$link = str_replace('-pc'.$cat->id,'-pcm'.$cat->id,$link);
						$link_dell = str_replace('-pc'.$cat->id,'-pcm'.$cat->id,$link);
					}
					$html_filter .= '<a href="'.$link.'" title="'.$filter ->filter_show.'" >'.$filter ->filter_show.'</a>';
					$html_current .=  '<a href="'.$link.'" title="'.$filter ->filter_show.'" >'.$filter ->filter_show.' </a>';
				}else{
					$str_filter_id = $filter_request?$filter_request.",".$filter -> alias:$filter -> alias;
					$link = FSRoute::addParameters('filter',$str_filter_id);
					if($checkmanu == 1){
						$link = str_replace('-pc'.$cat->id,'-pcm'.$cat->id,$link);	
					}
					$html_filter .= '<a href="'.$link.'" title="'.$filter ->filter_show.'" >'.$filter ->filter_show.'</a>';	
				}



			}
			$html_filter .= '</div>';
			$html_filter .= '</div>';
		}else{


			$html_filter .= '<div class="field_area field_item" id="m-'.$filters[0] -> field_name.'">';
			$closed = 0;

			$count_filter = count($filters);
			$item_in_column = 5;
			$cols = floor($count_filter/$item_in_column);
			if($cols > 3){
				$cols = 3;
			}
			
			$html_filter .= '<div class="field_name normal field  '.($closed?'field_closed':'field_opened' ). ' " data-id="id_field_'.$filters[0] -> field_name.'">';
			
			$html_filter .= '<span>'.str_replace('Hãng sản xuất', 'Hãng sản xuất', $filters[0] -> field_show).'</span>';


			$html_filter .= '<span data-name="'.$filters[0] -> field_name.'" class="icon"></span></div><div id="ft'.$filters[0] -> field_name.'"  class="field_label filters_in_field filters_in_field_'.$cols.'_column filter_4_'.$filters[0] -> field_name.'" '.($closed?' style="display:none"':'' ). '  >';

			

			$html_filter .= '<div class="filters_in_field_inner cls">';
			$html_filter .='<span class="close"><svg height="10px" viewBox="0 0 64 64" enable-background="new 0 0 64 64">
			<g>
			<path fill="#4e4b4b" d="M28.941,31.786L0.613,60.114c-0.787,0.787-0.787,2.062,0,2.849c0.393,0.394,0.909,0.59,1.424,0.59   c0.516,0,1.031-0.196,1.424-0.59l28.541-28.541l28.541,28.541c0.394,0.394,0.909,0.59,1.424,0.59c0.515,0,1.031-0.196,1.424-0.59   c0.787-0.787,0.787-2.062,0-2.849L35.064,31.786L63.41,3.438c0.787-0.787,0.787-2.062,0-2.849c-0.787-0.786-2.062-0.786-2.848,0   L32.003,29.15L3.441,0.59c-0.787-0.786-2.061-0.786-2.848,0c-0.787,0.787-0.787,2.062,0,2.849L28.941,31.786z"></path>
			</g>
			</svg></span>';
			

			if($filters[0] -> field_name == 'color'){
				foreach($filters as $filter){
					$get_code_color = $model->get_record('id = ' . $filter -> filter_value,'fs_products_colors','code');
					if(empty($get_code_color)){
						continue;
					}
					

					if(!empty($arr_filter_request) && count($arr_filter_request) && in_array($filter -> alias, $arr_filter_request)){
						$buff_filter_id = array_diff($arr_filter_request,array($filter -> alias));
						$str_filter_id = implode(",",$buff_filter_id);
						$link = FSRoute::addParameters('filter',$str_filter_id);
						if($checkmanu == 1){
							$link = str_replace('-pc'.$cat->id,'-pcm'.$cat->id,$link);
							$link_dell = str_replace('-pc'.$cat->id,'-pcm'.$cat->id,$link);
						}
						$html_filter .= '<div class="activated cls item item-color"><a style="background:#'.$get_code_color->code.'" href="'.$link.'" title="'.$filter ->filter_show.'" >'.''.'</a></div>';
						$html_current .=  '<a href="'.$link.'" title="'.$filter ->filter_show.'" >'.$filter ->filter_show.' </a>';
					}else{
						$str_filter_id = $filter_request?$filter_request.",".$filter -> alias:$filter -> alias;
						$link = FSRoute::addParameters('filter',$str_filter_id);
						if($checkmanu == 1){
							$link = str_replace('-pc'.$cat->id,'-pcm'.$cat->id,$link);	
						}
						$html_filter .= '<div class="cls item item-color"><a style="background:#'.$get_code_color->code.'" href="'.$link.'" title="'.$filter ->filter_show.'" >'.''.'</a></div>';	
					}
				}
			}

			elseif($filters[0] -> field_name == 'size'){
				foreach($filters as $filter){
					if(!empty($arr_filter_request) && count($arr_filter_request) && in_array($filter -> alias, $arr_filter_request)){
						$buff_filter_id = array_diff($arr_filter_request,array($filter -> alias));
						$str_filter_id = implode(",",$buff_filter_id);
						$link = FSRoute::addParameters('filter',$str_filter_id);
						if($checkmanu == 1){
							$link = str_replace('-pc'.$cat->id,'-pcm'.$cat->id,$link);
							$link_dell = str_replace('-pc'.$cat->id,'-pcm'.$cat->id,$link);
						}
						$html_filter .= '<div class="activated cls item item-size"><a href="'.$link.'" title="'.$filter ->filter_show.'" >'.$filter ->filter_show.'</a></div>';
						$html_current .=  '<a href="'.$link.'" title="'.$filter ->filter_show.'" >'.$filter ->filter_show.' </a>';
					}else{
						$str_filter_id = $filter_request?$filter_request.",".$filter -> alias:$filter -> alias;
						$link = FSRoute::addParameters('filter',$str_filter_id);
						if($checkmanu == 1){
							$link = str_replace('-pc'.$cat->id,'-pcm'.$cat->id,$link);	
						}
						$html_filter .= '<div class="cls item item-size"><a href="'.$link.'" title="'.$filter ->filter_show.'" >'.$filter ->filter_show.'</a></div>';	
					}
				}
			}
		 // Sao có giao diện riêng
			else{ 
				foreach($filters as $filter){
					if(!empty($arr_filter_request) && count($arr_filter_request) && in_array($filter -> alias, $arr_filter_request)){
						$buff_filter_id = array_diff($arr_filter_request,array($filter -> alias));
						$str_filter_id = implode(",",$buff_filter_id);
						$link = FSRoute::addParameters('filter',$str_filter_id);
						if($checkmanu == 1){
							$link = str_replace('-pc'.$cat->id,'-pcm'.$cat->id,$link);
							$link_dell = str_replace('-pc'.$cat->id,'-pcm'.$cat->id,$link);
						}
						$html_filter .= '<div class="activated cls item"><a href="'.$link.'" title="'.$filter ->filter_show.'" >'.$filter ->filter_show.'</a></div>';
						$html_current .=  '<a href="'.$link.'" title="'.$filter ->filter_show.'" >'.$filter ->filter_show.' </a>';
					}else{
						$str_filter_id = $filter_request?$filter_request.",".$filter -> alias:$filter -> alias;
						$link = FSRoute::addParameters('filter',$str_filter_id);
						if($checkmanu == 1){
							$link = str_replace('-pc'.$cat->id,'-pcm'.$cat->id,$link);	
						}
						$html_filter .= '<div class="cls item"><a href="'.$link.'" title="'.$filter ->filter_show.'" >'.$filter ->filter_show.'</a></div>';	
					}
				}
			}
			$html_filter .= '</div>';
			$html_filter .= '</div>';
			$html_filter .= '</div>';
			$i ++;
		}
	}
}
?>

<div class='block_product_filter cls'>
	<?php echo $html_filter; ?>
</div>

<?php if ($html_current ){?>
	<?php $html_current = '<div class="choosedfilter">'.$html_current; ?>
	<?php $html_current .= '<a  class="reset" href="'.$link_dell.'" >Xóa hết</a></div>'; ?>    	
	<?php $tmpl->assign ( 'filter_current', $html_current ); ?>
	<?php $tmpl->assign ( 'html_filter', $html_filter ); ?>
<?php } ?>