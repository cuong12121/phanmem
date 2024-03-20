<?php 
	class NewsModelsCat extends FSModels
	{
		function __construct()
		{
			parent::__construct();
			global $module_config;
			FSFactory::include_class('parameters');
			$current_parameters = new Parameters($module_config->params);
			$limit   = $current_parameters->getParams('limit'); 
	//		$limit = 6;
			$this->limit = $limit;
		}
		function set_query_body($cid)
		{
			$date1  = FSInput::get("date_search");
			$where  = "";
			$fs_table = FSFactory::getClass('fstable');
			$query = " FROM ".$fs_table -> getTable('fs_news')."
						  WHERE ( category_id = $cid 
						  	OR category_id_wrapper like '%,".$cid.",%' )
						  	AND published = 1 AND is_trash = 0 
						  	". $where.
						    " ORDER BY ordering DESC, id DESC
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
			$id = FSInput::get('cid',0,'int');

			if($id){
				$where = " AND id = '$id' ";
			}elseif($code){
				$where = " AND alias = '$code' ";
			}else{
				die('Not exist this url');
			}
			$query = " SELECT id,name, icon, alias,parent_id as parent_id,seo_title,seo_keyword,seo_description,`schema`
						FROM ".$fs_table -> getTable('fs_news_categories')." 
						WHERE published = 1 ".$where;
						
			global $db;
			$sql = $db->query($query);
			$result = $db->getObject();
			return $result;
		}
		function getNewsList($query_body)
		{
			if(!$query_body)
				return;
				
			global $db;
			$query = " SELECT id,title,summary,image, created_time,category_id, category_alias, alias,comments_total,comments_published,content";
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