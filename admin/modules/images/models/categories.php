<?php 
class ImagesModelsCategories extends ModelsCategories
{
	function __construct()
	{
		$this -> limit = 10;
		$this -> table_items = 'fs_images';
		$this -> table_name = 'fs_images_categories';
		$this -> check_alias = 1;
		$this -> call_update_sitemap = 0;
		parent::__construct();
	}

	function home($value)
	{
		$ids = FSInput::get('id',array(),'array');
		
		if(count($ids))
		{
			global $db;
			$str_ids = implode(',',$ids);
			$sql = " UPDATE ".$this -> table_name."
			SET show_in_homepage = $value
			WHERE id IN ( $str_ids ) " ;
			$db->query($sql);
			$rows = $db->affected_rows();
			return $rows;
		}
		
		return 0;
	}
	
	
}

?>