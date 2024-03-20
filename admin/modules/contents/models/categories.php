<?php 
	class ContentsModelsCategories extends ModelsCategories
	{
		function __construct()
		{
			$this -> table_items = 'fs_contents';
			$this -> table_name = 'fs_contents_categories';
			$this -> check_alias = 1;
			$this -> call_update_sitemap = 0;
			
			// exception: key (field need change) => name ( key change follow this field)
			$this -> field_except_when_duplicate = array(array('list_parents','id'),array('alias_wrapper','alias'));
			$limit = FSInput::get('limit',20,'int');
			$this -> limit = $limit;
			
		}
	}
	
?>