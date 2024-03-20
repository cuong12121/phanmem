<?php 
	class ProductsModelsUsage_states extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'usage_states';
			$this -> table_name = 'fs_usage_states';
			$this -> check_alias = 0;
			parent::__construct();
		}
	}
?>