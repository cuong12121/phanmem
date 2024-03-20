<?php 
	class SitemapModelsSitemap extends FSModels
	{
		function __construct()
		{
			parent::__construct();
			$this -> limit = 20;
		}
		
		/*
		 * Xem nhiều nhất
		 */
		function get_products(){ 
			$limit  = 40000;
			$cid = FSInput::get('cid');
			
			global $db;
			$query = " SELECT id,name,image, created_time,category_id, category_alias,category_name ,alias
					FROM fs_products
					WHERE published = 1 AND category_id_wrapper LIKE '%,".$cid.",%'
					 ORDER BY id DESC 
					 LIMIT ".$limit."
			";
			$sql = $db->query($query);
			return $result = $db->getObjectList();
		}

		/*
		 * Xem nhiều nhất
		 */
		function get_products_cat(){ 
			$limit  = 40000;
			global $db;
			$query = " SELECT id,name,alias
					FROM fs_products_categories
					WHERE published = 1
					 ORDER BY id DESC 
					 LIMIT ".$limit."
			";
			$sql = $db->query($query);
			return $result = $db->getObjectList();
		}
		/*
		 * Mới nhất
		 */
		function get_news(){
			$limit  = 400000;
			global $db;
			$query = " SELECT id,title,summary,image, created_time,category_id, category_alias,category_name ,alias
					FROM fs_news
					WHERE published = 1
					 ORDER BY id DESC 
					 LIMIT ".$limit."
			";
			$sql = $db->query($query);
			return $result = $db->getObjectList();


		}

		
		/*
		 * Xem nhiều nhất
		 */
		function get_news_cat(){ 
			$limit  = 400;
			global $db;
			$query = " SELECT id,name,alias
					FROM fs_news_categories
					WHERE published = 1
					 ORDER BY id DESC 
					 LIMIT ".$limit."
			";
			$sql = $db->query($query);
			return $result = $db->getObjectList();
		}

		/*
		 * Mới nhất
		 */
		function get_contents(){
			$limit  = 400;
			global $db;
			$query = " SELECT id,title,summary,image, created_time,category_id, category_alias,category_name ,alias
					FROM fs_contents
					WHERE published = 1
					 ORDER BY id DESC 
					 LIMIT ".$limit."
			";
			$sql = $db->query($query);
			return $result = $db->getObjectList();

		}
	}
?>