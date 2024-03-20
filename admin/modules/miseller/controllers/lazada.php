<?php
	// models 
//	include 'modules/'.$module.'/models/'.$view.'.php';
		  
	class MisellerControllersLazada extends Controllers
	{
		function __construct()
		{
			// parent::display();
			// $sort_field = $this -> sort_field;
			// $sort_direct = $this -> sort_direct;
			$this->view = 'lazada' ; 
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
			
			$maxOrdering = $model->getMaxOrdering();

			$categories = $model->get_categories_tree();
			$shop = $model->get_records('1=1','fs_miseller_lazada_shop','*');
			$hazmat = $model->get_records('1=1','fs_miseller_lazada_hazmat','*');
			$warranty =$model->get_records('1=1','fs_miseller_lazada_warranty','*');
			$warrantytype = $model->get_records('1=1','fs_miseller_lazada_warrantytype','*');
			$color = $model->get_records('1=1','fs_miseller_lazada_color','*');

			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}
		
		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			// $categories = $model->get_categories_tree();

			$data = $model->get_record_by_id($id);

			$categories = $model->get_categories_tree();
			$shop = $model->get_records('1=1','fs_miseller_lazada_shop','*');
			$hazmat = $model->get_records('1=1','fs_miseller_lazada_hazmat','*');
			$warranty =$model->get_records('1=1','fs_miseller_lazada_warranty','*');
			$warrantytype = $model->get_records('1=1','fs_miseller_lazada_warrantytype','*');
			$color = $model->get_records('1=1','fs_miseller_lazada_color','*');

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