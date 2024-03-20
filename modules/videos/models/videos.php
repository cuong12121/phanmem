<?php
class VideosModelsVideos extends FSModels {
	function __construct()
		{
			parent::__construct();
			global $module_config;
			FSFactory::include_class('parameters');
			$current_parameters = new Parameters($module_config->params);
			$limit   = $current_parameters->getParams('limit'); 
			//$limit = 2;
			if(!$limit) {
				$limit = 4;
			}
			$this->limit = $limit;
		}
		
		function set_query_body($cid)
		{
			$date1  = FSInput::get("date_search");
			$where  = "";
			$fs_table = FSFactory::getClass('fstable');
			$query = " FROM ".$fs_table -> getTable('fs_videos')."
						  WHERE category_id = $cid 
						  	AND published = 1 AND is_admin = 0
						  	". $where.
						    " ORDER BY  ordering DESC, id DESC
						 ";
            print_r($query);
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
					setRedirect(FSRoute::_('index.php?module=notfound&view=notfound&Itemid=1000'),'Not exist this url','error');
				$where = " AND id = '$id' ";
			}
			$query = " SELECT *
						FROM ".$fs_table -> getTable('fs_videos_categories')." 
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
			$query = " SELECT *";
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