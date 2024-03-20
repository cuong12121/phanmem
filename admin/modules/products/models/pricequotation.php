<?php 
	class ProductsModelsPricequotation extends FSModels{
	
		var $limit;
		var $prefix ;
	function __construct() {
			$this -> limit = 20;
			$this -> view = 'comments';
			$this -> table_name = 'fs_products';
			$this -> table_category_name = 'fs_products_categories';
			parent::__construct();
		}

}
?>
