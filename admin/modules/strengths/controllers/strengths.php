<?php
	// models 
//	include 'modules/'.$module.'/models/'.$view.'.php';
		  
	class StrengthsControllersStrengths extends Controllers
	{
		function __construct()
		{
			// parent::display();
			// $sort_field = $this -> sort_field;
			// $sort_direct = $this -> sort_direct;
			$this->view = 'strengths' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $model->get_data();
			$categories = $model->get_categories_tree();
			
			$pagination = $model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
        
        function add()
		{
			$model = $this -> model;
			$categories = $model->get_categories_tree();
			$maxOrdering = $model->getMaxOrdering();

			$categories_product = $model->get_categories_product_tree();
			$categories_filter = $model->get_categories_filter();

			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}
		
		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			$categories = $model->get_categories_tree();
			$cities = $model->get_all_record('fs_cities');
			$data = $model->get_record_by_id($id);
			$manufactory_related = $model -> get_manufactory_related($data -> manufactory_related);

			$category_id_wrapper = explode(',',$data ->category_id_wrapper);
			unset($category_id_wrapper[count($category_id_wrapper) - 1]);
			unset($category_id_wrapper[0]);
			$category_id_wrapper_str = implode(',',$category_id_wrapper);
			$category_id_wrapper_select = $model -> get_records('id IN ('. $category_id_wrapper_str .')','fs_products_categories','name');
			$category_id_wrapper_select_name = '';
			foreach($category_id_wrapper_select as $csl) {
				$category_id_wrapper_select_name .=  $csl->name .' ,';
			}



			$categories_product = $model->get_categories_product_tree();
			$categories_filter = $model->get_categories_filter();
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
		function ajax_get_manufactory_related(){
			$model = $this -> model;
			$data = $model->ajax_get_manufactory_related();
			$html = $this -> manufactory_genarate_related($data);
			echo $html;
			return;
		}
		
		function manufactory_genarate_related($data){
			$str_exist = FSInput::get('str_exist');
			$html = '';
				$html .= '<div class="manufactory_related">';
				foreach ($data as $item){
					if($str_exist && strpos(','.$str_exist.',', ','.$item->id.',') !== false ){
						$html .= '<div class="red manufactory_related_item  manufactory_related_item_'.$item -> id.'" onclick="javascript: set_manufactory_related('.$item->id.')" style="display:none" >';	
						$html .= $item -> name;				
						$html .= '</div>';					
					}else{
						$html .= '<div class="manufactory_related_item  manufactory_related_item_'.$item -> id.'" onclick="javascript: set_manufactory_related('.$item->id.')">';	
						$html .= $item -> name;				
						$html .= '</div>';	
					}
				}
				$html .= '</div>';
				return $html;
		}

	}
	
?>