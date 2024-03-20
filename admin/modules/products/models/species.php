<?php 
	class ProductsModelsSpecies extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'species';
			$this -> table_name = 'fs_species';
			$this -> check_alias = 0;
			parent::__construct();
		}
	}
?>