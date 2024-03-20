<?php 
	class AqModelsCat extends FSModels
	{
		function __construct()
		{
			parent::__construct();
			global $module_config;
			FSFactory::include_class('parameters');
			$current_parameters = new Parameters($module_config->params);
			$limit   = $current_parameters->getParams('limit'); 
	//		$limit = 6;
			$this -> limit = 5;
		}
		function set_query_body($cid)
		{
			$date1  = FSInput::get("date_search");
			$where  = "";
			$fs_table = FSFactory::getClass('fstable');
			$query = " FROM ".$fs_table -> getTable('fs_aq')."
						  WHERE ( category_id = $cid 
						  	OR category_id_wrapper like '%,".$cid.",%' )
						  	AND published = 1
						  	". $where.
						    " ORDER BY  ordering DESC, id DESC
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
			$query = " SELECT id,name, icon, alias,parent_id as parent_id,seo_title,seo_keyword,seo_description,updated_time
						FROM ".$fs_table -> getTable('fs_aq_categories')." 
						WHERE published = 1 ".$where;
			global $db;
			$sql = $db->query($query);
			$result = $db->getObject();
			return $result;
		}
		function get_data($query_body)
		{
			if(!$query_body)
				return;
				
			global $db;
			$query = " SELECT *";
			$query .= $query_body;
			$sql = $db->query($query);
			$result = $db->getObjectList();
			
			return $result;
		}
		
//		function getTotal($query_body)
//		{
//			if(!$query_body)
//				return ;
//			global $db;
//			$query = "SELECT count(*)";
//			$query .= $query_body;
//			$sql = $db->query($query);
//			$total = $db->getResult();
//			return $total;
//		}
//		
//		function getPagination($total)
//		{
//			FSFactory::include_class('Pagination');
//			$pagination = new Pagination($this->limit,$total,$this->page);
//			return $pagination;
//		}
	}
	
?>