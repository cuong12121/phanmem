<?php
/*
 * Huy write
 */
	// controller

class DepartmentControllersDepartment extends FSControllers
{
	var $module;
	var $view;
	function display()
	{
			// call models
		$model = $this -> model;
//			$cat  = $model->get_category();
//			if(!$cat)
//			{
//				echo "Kh&#244;ng th&#7845;y Category";	
//				die;
//			}
//			global $tags_group;
		$query_body = $model->set_query_body();
		$regions = $model -> get_regions();
		$list = $model->get_list($query_body);
		if(isset($_SESSION["city"]) && !empty($_SESSION["city"])){
			$region_active = $model -> get_record('id = ' . $_SESSION["city"] ,'fs_address_regions','id,name');
		}
		
		$dataCity = $model->get_city(); 
		$info_other = $model->get_info_other(); 
		$district = $model->get_categories_tree();
						//echo count($list);
//			$total = $model->getTotal($query_body);
//			$pagination = $model->getPagination($total);
		
		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Hệ thống cửa hàng', 1 => FSRoute::_('index.php?module=department&view=department&Itemid=2'));
		global $tmpl;	
		$tmpl -> assign('breadcrumbs', $breadcrumbs);
		$tmpl -> set_seo_special();
			// seo
			// $tmpl -> set_data_seo($cat);
		
			// call views			
		include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
	}
	function get_agency(){
		$city_id = FSInput::get('district_id');
		if($city_id==0){
			unset($_SESSION["district"]);
		}else{
			$_SESSION["district"]=$city_id;
		}
	}
	function loadDistricts(){
		$city_id = FSInput::get('city_id');
		$_SESSION["city"]=$city_id;
		global $config;
		
		$listDistricts = $this->model->getListDistricts($city_id);
		$html = '';
		foreach($listDistricts as $item){
			$html .= '<option  value="'.$item->id.'">'.$item->name.'</option>';
		}
		echo $html;
	}
}

?>