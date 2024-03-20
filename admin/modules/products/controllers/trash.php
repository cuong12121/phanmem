<?php
	class ProductsControllersTrash  extends Controllers
	{
		function __construct()
		{	
			$limit = FSInput::get('limit',20,'int');
			$this -> limit = $limit;
			$this->view = 'products' ; 
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
		
		function restore_data(){
			$model = $this -> model;
			$rows = $model->restore_data(0);
			$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
			$page = FSInput::get('page',0);
			if($page > 1)
				$link .= '&page='.$page;
			if($rows){
				setRedirect($link,$rows.' '.FSText :: _('record was restore'));	
			}
		}
	}

	function restore($controle,$record_id){
		$link = 'index.php?module=products&view=trash&id='.$record_id.'&task=restore_data&raw=1';
		return '<a href="' . $link . '" target="_self"><img border="0" src="templates/default/images/toolbar/restore_icon.png" alt="Restore"></a>';
	}

?>