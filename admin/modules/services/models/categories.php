<?php 
	class ServicesModelsCategories extends ModelsCategories
	{
		function __construct()
		{
			$this -> table_items = FSTable_ad::_ ('fs_services');
			$this -> table_name = FSTable_ad::_ ('fs_services_categories');
			$this -> check_alias = 1;
			$this -> call_update_sitemap = 0;
			
			// exception: key (field need change) => name ( key change follow this field)
			$this -> field_except_when_duplicate = array(array('list_parents','id'),array('alias_wrapper','alias'));
			$limit = FSInput::get('limit',20,'int');
			$this -> limit = $limit;
			
		}
	}
	
?>