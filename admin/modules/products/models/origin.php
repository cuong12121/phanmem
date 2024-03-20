<?php 
	class ProductsModelsOrigin extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'origin';
			$this -> table_name = 'fs_origin';
			$this -> check_alias = 0;
			parent::__construct();
		}
	}
?>