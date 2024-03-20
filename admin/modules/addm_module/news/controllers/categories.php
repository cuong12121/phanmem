<?php
	class NewsControllersCategories extends Controllers
	{
		function __construct()
		{
			$this->view = 'categories' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $this -> model->get_categories_tree();
			$pagination = $model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		function add()
		{
			$model =  $this -> model;
			$categories = $model->get_categories_tree();
//			$tags_categories = $model->get_tags_categories();
			$maxOrdering = $model->getMaxOrdering();
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
		function edit()
		{
			$model =  $this -> model;
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$data = $model->get_record_by_id($id);
			$categories = $model->get_categories_tree();
//			$tags_categories = $model->get_tags_categories();
//			print_r($data);exit;
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
		
		function home()
		{
			$model = $this -> model;
			$rows = $model->home(1);
			$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
			if($rows)
			{
				setRedirect($link,$rows.' '.FSText :: _('record was home'));	
			}
			else
			{
				setRedirect($link,FSText :: _('Error when home record'),'error');	
			}
		}
		function unhome()
		{
			$model = $this -> model;
			$rows = $model->home(0);
			$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
			if($rows)
			{
				setRedirect($link,$rows.' '.FSText :: _('record was unhome'));	
			}
			else
			{
				setRedirect($link,FSText :: _('Error when unhome record'),'error');	
			}
		}
		
	}
	
?>