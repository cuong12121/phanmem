<?php

$html_filter3 ="";
if(!empty($sub_cats)){
	$html_filter3 .= '<div class="field_area field_item field_area_cat">';
	$html_filter3 .= '	<div class="field_name normal field" >';		
	$html_filter3 .= '		<span>Danh mục</span>';
	$html_filter3 .= '	</div>';
	// $html_filter3 .= '</div>';
	$html_filter3 .= '<div   class="field_label filters_in_field filters_in_field_0_column subcats " >';
	$html_filter3 .= '	<div class="filters_in_field_inner cls">';

	$alias = FSinput::get('ccode');
	$cat_p = $model-> get_record('alias =  "'.$alias.'"','fs_products_categories','*');
	$cat_parent = $model-> get_record('id =  "'.$cat_p-> parent_id.'"','fs_products_categories','*');
	$filter = FSinput::get('filter');
	$sort = FSinput::get('sort');
	foreach($sub_cats as $sub){

		// if($sub -> id == 418) {
		if(1 == 2) {
		}
		else {

		// $filter = isset($tables[$sub -> tablename])?$tables[$sub -> tablename]:null;
		// if(!$filter)
		// 	continue;
			$link = FSRoute::_('index.php?module=products&view=cat&ccode='.$sub -> alias.'&cid='.$sub -> id.'&filter='.$filter.'&sort='.$sort);
			if($sub-> alias == $alias || $sub-> alias == @$cat_parent-> alias) {
				$html_filter3 .= '<div class="item activated"><a href="'.$link.'" title="'.$sub -> name.'"  ><span >'.$sub -> name.'</span></a></div>';
			}
			else {
				$html_filter3 .= '<div class="item"><a href="'.$link.'" title="'.$sub -> name.'"  ><span >'.$sub -> name.'</span></a></div>';	
			}
		}
		
	}
	$html_filter3 .= '	</div>';
	$html_filter3 .= '</div>';
	$html_filter3 .= '</div>';
}
?>