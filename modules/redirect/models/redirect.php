<?php 
	class RedirectModelsRedirect extends FSModels
	{
		function __construct()
		{
			parent::__construct();
		}
		/*
		 * Lấy thông tin từ bảng new từ link cũ để thực hiện việc redirect
		 */
		function get_news_by_old_link()
		{
			$root = 'http://msmobile.com.vn/';
			$link = FSInput::get('link');
			$link1 = $root.$link.'/';
			$link2 = $root.'/'.$link.'/';
			
			$query = " SELECT id, alias,category_alias
						FROM fs_news
						WHERE link = '".$link1."' OR link = '".$link2."'" ;
			global $db;
			$sql = $db->query($query);
			$result = $db->getObject();
			return $result;
		}
		
		function get_cat_by_old_link()
		{
			$link = FSInput::get('link');
			$link = '/'.$link.'/';
			$query = " SELECT id,name,  alias
						FROM fs_news_categories 
						WHERE old_path = '".$link."'";
			global $db;
			$sql = $db->query($query);
			$result = $db->getObject();
			return $result;
		}
		
	}
	
?>