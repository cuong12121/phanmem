<?php
	class ProductsControllersPricequotation extends Controllers{
	
		function __construct()
		{
			$this->view = 'comments' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $model->get_data();
			$categories = $model->get_categories_tree_all();
			$pagination = $model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		function add()
		{
			return;
		}
		
		function format_money($row)
		{	if($row)
				return format_money($row,'VNĐ');
			else 
			return $row;
		}
		

	}
?>
