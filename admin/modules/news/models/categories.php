<?php 
	class NewsModelsCategories extends ModelsCategories
	{
		function __construct()
		{
			$this -> limit = 20;
			
			$this -> table_items = 'fs_news';
			$this -> table_name = 'fs_news_categories';
			$this -> check_alias = 1;
			$this -> call_update_sitemap = 1;
			$this -> arr_img_paths = array(array('large',800,600,'cut_image'),array('compress',1,1,'compress'));
			// exception: key (field need change) => name ( key change follow this field)
			$this -> field_except_when_duplicate = array(array('list_parents','id'),array('alias_wrapper','alias'));
			$cyear = date ( 'Y' );
			$cmonth = date ( 'm' );
			$cday = date ( 'd' );
			$this->img_folder = 'images/news/' . $cyear . '/' . $cmonth . '/' . $cday;
			$this->check_alias = 0;
			$this->field_img = 'image';
			parent::__construct();
		}
	}
	
?>