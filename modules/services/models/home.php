<?php 
	class ServicesModelsHome extends FSModels
	{
		function __construct(){
		parent::__construct();
		global $module_config;
		FSFactory::include_class('parameters');
		$current_parameters = new Parameters($module_config->params);
		$limit   = $current_parameters->getParams('limit');
		$limit = $limit ? $limit: 8; 
		$this->limit = $limit;
	
		}
		function set_query_body()
		{
			$date1  = FSInput::get("date_search");
			$where  = "";
			$fs_table = FSFactory::getClass('fstable');
			$query = " FROM ".$fs_table -> getTable('fs_services')."
						  WHERE 
						  	 published = 1  AND category_published = 1
						  	". $where.
						    " ORDER BY  ordering DESC,created_time DESC, id DESC 
						 ";
			return $query;
		}
		
		/*
		 * get Category current
		 * By Id or By code
		 */
		function getCategory()
		{
			$fs_table = FSFactory::getClass('fstable');
			$code = FSInput::get('ccode');
			if($code){
				$where = " AND alias = '$code' ";
			} else {
				$id = FSInput::get('id',0,'int');
				if(!$id)
					die('Not exist this url');
				$where = " AND id = '$id' ";
			}
			$query = " SELECT id,name, icon, alias,parent_id as parent_id,seo_title,seo_keyword,seo_description
						FROM ".$fs_table -> getTable('fs_news_categories')." 
						WHERE published = 1 ".$where;
			global $db;
			$sql = $db->query($query);
			$result = $db->getObject();
			return $result;
		}
			function get_cats() {
		global $db;
		$query = 'SELECT * FROM fs_services_categories WHERE published = 1';
		$db->query($query);
		$result = $db->getObjectList();
		return $result;
	}

		function getServicesList($query_body)
		{
			if(!$query_body)
				return;
			global $db;
			$query = " SELECT id,title,summary,image,icon, created_time,category_id, category_alias, alias,comments_published";
			$query .= $query_body;
			$sql = $db->query_limit($query,$this->limit,$this->page);
			$result = $db->getObjectList();
			return $result;
		}
		
		function getTotal($query_body)
		{
			if(!$query_body)
				return ;
			global $db;
			$query = "SELECT count(*)";
			$query .= $query_body;
			$sql = $db->query($query);
			$total = $db->getResult();
			return $total;
		}
		
		function getPagination($total)
		{
			FSFactory::include_class('Pagination');
			$pagination = new Pagination($this->limit,$total,$this->page);
			return $pagination;
		}
	}
	
?>