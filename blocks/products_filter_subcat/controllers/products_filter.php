<?php
/*
 * Huy write
 */
	// models 
	include 'blocks/products_filter/models/products_filter.php';
	
	class Products_filterBControllersProducts_filter{
		function __construct()
		{
			global $module_name;
		}
		
		function display($parameters,$title,$block_id = 0, $link_title = '',$showTitlte = 0){
			$this -> filter_no_cal($parameters,$title);
		}
		function filter_no_cal($parameters,$title){
			$model = new Products_filterBModelsProducts_filter();
			$cat = $model -> get_category();
			if(!$cat)
				return;
			$subcats = $model -> get_subcats($cat -> id);
			$list = $model -> get_filters_no_calculate($cat);
			if(!count($list) && !count($subcats))
				return;
			
			// filter is browing
			$filter = FSInput::get ( 'filter' );
			$arr_filter_is_browing = array();
			if ($filter){
				$arr_filter_is_browing = explode ( ',', $filter );
			} 
			
			$arr_fields_current = array(); // mảng đang duyệt trên URL
			$arr_fieldname_current = array(); // mảng đang duyệt trên URL
			$arr_filter_by_field = array();
			foreach($list as $item){
				if(!isset($arr_filter_by_field[$item -> field_name])){
					$arr_filter_by_field[$item -> field_name] = array();
				}
				$arr_filter_by_field[$item -> field_name][] = $item;
				
				if(count($arr_filter_is_browing) && in_array($item -> alias,$arr_filter_is_browing)){
					$arr_fields_current[] = $item;
					$arr_fieldname_current[] = $item -> field_name;
				}
			}
			
			
			$style = $parameters->getParams('style');
			$style = $style ? $style : 'default';
			
			// current field:
			$arr_fields_current = $model -> get_filter_is_browing($cat);
			$filter_request = FSInput::get('filter');
			$arr_filter_request = $filter_request?explode(',',$filter_request):null;
			// thêm hãng sản xuất
			// current field:
//			$manufactories_request = FSInput::get('manu');
//			$arr_manufactories_request = $manufactories_request?explode(',',$manufactories_request):null;
//			$manufactories = $model -> get_menufactories($arr_manufactories_request);
			
//			$colors = $model -> get_colors();
			
			// call views
			include 'blocks/products_filter/views/filter_no_cal_multiselect_dropdown.php';
		}
		function filter_has_cal_auto($parameters,$title){
			$model = new Products_filterBModelsProducts_filter();
			$cat = $model -> get_category();
			$fields_in_table_has_filter = $model -> get_filter_by_tablename($cat -> tablename?$cat -> tablename:'fs_products');
			if(!$fields_in_table_has_filter)
				return;
			$list = $model -> get_filters_has_calculate($cat);
//			if(!count($list))
//				return;
			$arr_filter_by_field = array();
			foreach($fields_in_table_has_filter as $field){
				foreach($list as $item){
					if($item -> record_id == $field -> id){
						if(!isset($arr_filter_by_field[$item -> field_name])){
							$arr_filter_by_field[$item -> field_name] = array();
						}
						$arr_filter_by_field[$item -> field_name][] = $item;
					}
				}
			}
//			if(!$arr_filter_by_field)
//				return;
			$style = $parameters->getParams('style');
			$style = $style ? $style : 'default';
			
			// current field:
			$arr_fields_current = $model -> get_filter_is_browing($cat);
			$filter_request = FSInput::get('filter');
			$arr_filter_request = $filter_request?explode(',',$filter_request):null;
			
			
			// call views
			include 'blocks/products_filter/views/'.$style.'.php';
		}
		function filter_has_cal($parameters,$title){
			$model = new Products_filterBModelsProducts_filter();
			$cat = $model -> get_category();
			$tablename = $cat -> tablename?$cat -> tablename:'fs_products';
			$fields_in_table_has_filter = $model -> get_filter_by_tablename($tablename);
			if(!$fields_in_table_has_filter)
				return;

			$where_url =  $model -> set_query_from_url($cat -> id,$tablename);
			
			// filter is browing
			$filter = FSInput::get ( 'filter' );
			$arr_filter_is_browing = array();
			if ($filter){
				$arr_filter_is_browing = explode ( ',', $filter );
			} 
			
			$arr_fields_current = array(); // mảng đang duyệt trên URL
			$arr_filter_by_field = array();
			foreach($fields_in_table_has_filter as $field){
				if(count($arr_filter_is_browing) && in_array($field -> alias,$arr_filter_is_browing)){
					$arr_fields_current[] = $field;
				}else{
					$count = $model -> count_by_filter($field,$where_url,$tablename);
//					if(!$count)
//						continue;
					$item = $field;
					$item -> total = $count;
									
					if(!isset($arr_filter_by_field[$field -> field_show])){
						$arr_filter_by_field[$field -> field_show] = array();
					}
					$arr_filter_by_field[$field -> field_show][] = $item;
				}
			}
			
				
////			$list = $model -> get_filters_has_calculate($cat);
////			if(!count($list))
////				return;
//			
//			foreach($fields_in_table_has_filter as $field){
//				foreach($list as $item){
//					if($item -> record_id == $field -> id){
//						if(!isset($arr_filter_by_field[$item -> field_name])){
//							$arr_filter_by_field[$item -> field_name] = array();
//						}
//						$arr_filter_by_field[$item -> field_name][] = $item;
//					}
//				}
//			}
//			if(!$arr_filter_by_field)
//				return;
			$style = $parameters->getParams('style');
			$style = $style ? $style : 'filter_has_cal_multiselect_dropdown';
			
			// current field:
//			$arr_fields_current = $model -> get_filter_is_browing($cat);
			$filter_request = FSInput::get('filter');
			$arr_filter_request = $filter_request?explode(',',$filter_request):null;
			
			
			// call views
			include 'blocks/products_filter/views/'.$style.'.php';
		}
	}	
		
