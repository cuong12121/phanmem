<?php
	class SellsControllersRetail extends Controllers
	{
		function __construct()
		{
			$this-> view = 'retail' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $this -> model->get_data('');
			$categories = $model->get_records('','fs_groups_file');
			$pagination = $model->getPagination('');
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}


		function add()
		{
			$model = $this -> model;
			$technicalStaff = $model->get_records('published = 1','fs_users');
			$saleman = $model->get_records('published = 1','fs_users');
			$cities = $model->get_records('published = 1','fs_cities');
			$warehouses = $model->get_records('published = 1','fs_warehouses');
			$stt_next = 1;
			//printr($users);
			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}
		
		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			$technicalStaff = $model->get_records('published = 1','fs_users');
			$saleman = $model->get_records('published = 1','fs_users');
			$cities = $model->get_records('published = 1','fs_cities');
			$warehouses = $model->get_records('published = 1','fs_warehouses');
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}


		function ajax_search_products(){
			$html ='';
			$key = FSInput::get('key');
			$model = $this -> model;
			$data = $model->get_records('name like "%'.$key.'%" OR code like "%'.$key.'%" OR barcode like "%'.$key.'%" ','fs_products','*');
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/search_product.php';
			return;
		}

		function ajax_set_product_search(){
			$html ='';
			$id = FSInput::get('id');
			$model = $this -> model;
			$data = $model->get_record('id = '. $id,'fs_products','*');
			include 'modules/'.$this->module.'/views/'.$this->view.'/load_product.php';
			return;
		}

		function ajax_add_boxContentTab(){
			global $config;
			$model = $this -> model;
			$stt_next = FSInput::get('stt_next');
			$technicalStaff = $model->get_records('published = 1','fs_users');
			$saleman = $model->get_records('published = 1','fs_users');
			$cities = $model->get_records('published = 1','fs_cities');
			$html ='';
			include 'modules/'.$this->module.'/views/'.$this->view.'/boxContentTab.php';
			return;
		}

		

	}
	
?>