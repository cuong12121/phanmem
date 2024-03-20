<?php
	class NewsControllersNews_comments extends Controllers
	{
		function __construct()
		{
			$this->view = 'news_comments' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $model->get_data();
			
			// check if filter0
//			if(!isset($_SESSION[$this -> prefix.'filter0']) || (isset($_SESSION[$this -> prefix.'filter0']) && $_SESSION[$this -> prefix.'filter0'] != 1) ){
			$estores = $model->get_all_record('fs_estores');
//			}
			$categories = $model->get_categories_tree();
			$pagination = $model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		function add()
		{
			$model = $this -> model;
			$estores = $model->get_all_record('fs_estores');
			$estore_id_first = isset($estores[0]->id) ? $estores[0]->id : 0;
			$categories = $model->get_categories_tree();
			
			// data from fs_news_categories
			$categories_home  = $model->get_categories_tree();
			$maxOrdering = $model->getMaxOrdering();
			

			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}
		
		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			$estores = $model->get_all_record('fs_estores');
			$data = $model->get_record_by_id($id);
			
			$estore_name = $model -> get_field_by_id($data -> estore_id,'estore_name','fs_estores');
			$news =  $model -> get_record_by_id($data -> content_id,'fs_news');
			$category_name =  $model -> get_field_by_id($news -> category_id,'name','fs_news_categories');
//			$estore_id = $data -> estore_id;
//			$categories  = $model->get_categories_tree();
//			$estore_name  = $model->get_estore_name_by_estore_id($estore_id);
			
			// data from fs_news_categories

			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
		
		
		/*
		 * load Category by city id. 
		 * Use Ajax
		 */
		function cats_by_estoreid()
		{
			$model  = $this -> model;
			$cid = FSInput::get('cid');
			$rs  = $model -> get_categories_tree_by_estore_id($cid);
			
			$json = '['; // start the json array element
			$json_names = array();
//			$json_names[] = "{id: 0, name: '--C&#7845;p &#273;&#7897; Cha--'}";
			foreach( $rs as $item)
			{
				$json_names[] = "{id: $item->id, name: '$item->treename'}";
			}
			$json .= implode(',', $json_names);
			$json .= ']'; // end the json array element
			echo $json;
		}
		
	}
	
?>