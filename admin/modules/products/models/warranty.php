<?php 
	class ProductsModelsWarranty extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'warranty';
			$this -> table_name = 'fs_warranty';
			$this -> check_alias = 0;
			parent::__construct();
		}
	}
?>