<?php 
	class RssModelsRss extends FSModels
	{
		function __construct()
		{
			parent::__construct();
			$this -> limit = 20;
		}
		
	/*
		 * Lấy value từ fs_config
		 */
		function get_config($key)
		{
			if(!$key)
				return;
			$query = ' SELECT value
					 FROM fs_config
					 WHERE `name` = "'.$key.'" ';
			global $db;
			$db->query($query);
			$result = $db->getResult();
			return $result;
		}
		/*
		 * Xem nhiều nhất
		 */
//		function get_products(){ 
//			$limit  = 100;
//			global $db;
//			$query = " SELECT id,name,summary,image, created_time,category_id, category_alias,category_name ,alias
//					FROM fs_products
//					WHERE published = 1
//					 ORDER BY id DESC 
//					 LIMIT ".$limit."
//			";
//			$sql = $db->query($query);
//			return $result = $db->getObjectList();
//		}
		
	
		/*
		 * Mới nhất
		 */
		function get_news($cat_id){
			global $db;
			$limit  = 400;
			$where = '';
			$tool = isset($_GET['tool'])?$_GET['tool']:0;
			$ordering = ' ORDER BY ordering DESC ';
			if($tool == 1){
				$where .= ' AND  is_rss = 1 ';
			}elseif($tool == 2){
				$where .= ' AND  is_highlight = 1  ';
				$ordering = ' ORDER BY  ordering DESC ';
			}
			
			if($cat_id){
				$where .= ' AND category_id = '.$cat_id.'  ';
				
			}
		
			$query = " SELECT id,title,summary,content,image, created_time,published_time,category_id, category_alias,category_name ,alias,creator,hits,tags
					FROM fs_news
					WHERE published = 1
					".$where."
					 ORDER BY  ordering DESC 
					  LIMIT ".$limit."
			";
			
			$sql = $db->query($query);
			return $result = $db->getObjectList();
		}
		
		/*
		 * Mới nhất
		 */
		function get_news_categories(){
			global $db;
			$limit  = 2;
			$query = " SELECT id,name,alias
					FROM fs_news_categories
					WHERE published = 1
					 ORDER BY  ordering ASC
					  LIMIT ".$limit."
			";
			
			$sql = $db->query($query);
			return $result = $db->getObjectList();
		}
		/*
		 * Mới nhất
		 */
		function get_category(){
			$ccode = FSInput::get('ccode');
			if(!$ccode)
				return;
			global $db;
			$limit  = 2;
			$query = " SELECT id,name,alias
					FROM fs_news_categories
					WHERE published = 1
					ANd alias = '".$ccode."'
					 ORDER BY  ordering ASC
			";
			
			$sql = $db->query($query);
			return $result = $db->getObject();
		}
	}
?>