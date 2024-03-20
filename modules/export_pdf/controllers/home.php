<?php

class HomeControllersHome extends FSControllers{
		var $module;
		var $view;
		function display()
		{
			
			$model = $this -> model;
			$types = $model->get_records('published = 1','fs_products_types','*','','','id');
			$list_cats = $model ->get_cats();
			$array_cats = array();
			$array_products = array();
			$i = 0;
			
			foreach (@$list_cats as $item)
			{
				if($item->id == 84){
					$query_body = $model->set_query_body($item->id);
					$products_in_cat = $model->get_list($query_body);
					$cat_name = $model->get_record('published = 1 AND id =84','fs_products_categories');
					
				}
				if(!empty($products_in_cat)){
					$array_cats[] = $item;
					$i ++;
				}
			}

			// printr($products_in_cat);
			// echo "<pre>";
			// print_r($products_in_cat);
			$types = $model -> get_types();
			$extends_items = $model->get_records('published = 1','fs_extends_items','id, name,name_other','','','id');
			

			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function fetch_pages()
		{
			$model = $this -> model;		
			$cat_id =FSInput::get('cid');
			$cid =FSInput::get('cid');
			$cat_name = $model->get_record('published = 1 AND id = '.$cid,'fs_products_categories');
			$query_body = $model->set_query_body($cat_id);

			//die($query_body );
			$list = $model->get_list($query_body);
			$types = $model -> get_types();
			$extends_items = $model->get_records('published = 1','fs_extends_items','id, name,name_other','','','id');
			include 'modules/'.$this->module.'/views/'.$this->view.'/fetch_pages.php';
			return;
		}
		
	
	}
	
?>