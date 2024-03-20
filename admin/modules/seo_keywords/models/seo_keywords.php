<?php 
	class Seo_keywordsModelsSeo_keywords extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 10;
			$this -> view = 'seo_keywords';
			$this -> table_name = 'seo_keywords';
			//$this -> arr_img_paths = array(array('small',150,74,'cut_image'),array('resized',800,394,'cut_image'),array('large',1260,620,'cut_image'));
			//$this -> img_folder = 'images/albums';
			//$this -> check_alias = 0;
			//$this -> field_img = 'image';
			parent::__construct();
		}

		function get_all_keyword_new($keyword,$data_id,$data_module)
		{
			$where  = "";


			if($keyword){
				$where  = " WHERE main_keyword = '". $keyword ."'" ;
				if($data_module == 'news' && $data_id > 0){
					$where  .= " AND id != " . $data_id ;
				}
			}

			$fs_table = FSFactory::getClass('fstable');
			$query = " SELECT main_keyword FROM ".$fs_table -> getTable('fs_news') . $where;
			//echo $query;
			global $db;
			//$sql = $db->query($query);
			//$result = $db->getObjectList();
			$result = $db->getObjectList($query);
			return $result;
		}

		function get_all_keyword_pro($keyword,$data_id,$data_module)
		{
			$where  = "";
			if($keyword){
				$where  = " WHERE main_keyword = '". $keyword ."'" ;
				if($data_module == 'products' && $data_id > 0){
					$where  .= " AND id != " . $data_id ;
				} 
			}


			$fs_table = FSFactory::getClass('fstable');
			$query = " SELECT main_keyword FROM ".$fs_table -> getTable('fs_products') . $where;
			global $db;
			//$sql = $db->query($query);
			$result = $db->getObjectList($query);
			return $result;
		}	

	}

?>