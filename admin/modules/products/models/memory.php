<?php 
	class ProductsModelsMemory extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'memory';
			$this -> table_name = 'fs_memory';
			$this -> check_alias = 0;
			parent::__construct();
		}
	}
?>