<?php 
class ServicesModelsCat extends FSModels
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
		$query = " FROM ".$fs_table -> getTable('fs_services')."
		WHERE ( category_id = $cid 
		OR category_id_wrapper like '%,".$cid.",%' )
		AND published = 1 AND category_published = 1
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
			$query = " SELECT id,name, icon, alias,parent_id as parent_id,seo_title,seo_keyword,seo_description,list_parents
			FROM ".$fs_table -> _('fs_services_categories')." 
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


		function get_data($query_body)
		{
			if(!$query_body)
				return;

			global $db;
			$query = " SELECT id,title,summary,image, created_time,category_id, category_alias, alias";
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
		
		/*
		 * get Most Reading new
		 * LIMIT IN 600 days
		 */
		// function get_most_read_contents($category_id,$limit,$str_contents_ids,$limit_day = 4){
		// 	if(!$limit)
		// 		$limit = 9;
		// 	$query = ' SELECT id, title,image, summary,alias, category_alias,category_id
		// 			  FROM fs_contents
		// 			  WHERE published = 1
		// 			  AND category_id_wrapper like "%,'.$category_id.',%"
		// 			  AND id NOT IN ('.$str_contents_ids.')
		// 			  AND updated_time >= DATE_SUB(CURDATE(), INTERVAL '.$limit_day.' DAY)
		// 			ORDER BY created_time DESC
		// 			 ';
		// 	global $db;
		// 	$sql = $db->query_limit($query,$limit);
		// 	return  $db->getObjectList();
		// }
		
		function get_list_parent($list_parents,$cat_id){
			if(!$list_parents)
				return;
			$fs_table = FSFactory::getClass('fstable');
			$query = 'SELECT name,id,alias,parent_id FROM '.$fs_table -> getTable('fs_services_categories').
			' WHERE id IN (0'.$list_parents.'0) AND id <> '.$cat_id.'
			ORDER BY POSITION(","+id+"," IN "0'.$list_parents.'0")';
			global $db;
			$db->query($query);
			$list = $db->getObjectList();
			return $list;
		}
	}
	
	?>