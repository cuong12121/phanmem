<?php
	// models 
//	include 'modules/'.$module.'/models/'.$view.'.php';
		  
	class AlbumsControllersAlbums extends Controllers
	{
		function __construct()
		{
			$this->view = 'albums' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$model = $this -> model;
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			$categories = $model->get_records('','fs_albums_categories');
			$list = $this -> model->get_data();
			$pagination = $this -> model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
        
       	function add()
		{
			$model = $this -> model;
			$categories = $model->get_records('','fs_albums_categories');
			$maxOrdering = $model->getMaxOrdering();
			
			
			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}
		
		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			$categories = $model->get_records('','fs_albums_categories');
			$data = $model->get_record_by_id($id);
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
	}
	
?>