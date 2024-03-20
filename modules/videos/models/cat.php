<?php
class VideosModelsCat extends FSModels {
	function __construct() {
		parent::__construct ();
		global $module_config;
		FSFactory::include_class('parameters');
		$current_parameters = new Parameters(@$module_config->params);
		$limit   = $current_parameters->getParams('limit'); 
		if(!$limit)	
			$limit = 16;
		$this->limit = $limit;
	}
	
	function set_query_body($cid) {
		
		$where = "";
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = " FROM " . $fs_table->getTable ( 'fs_videos' ) . "
		WHERE category_id = $cid 
		AND published = 1 
		" . $where . "
		";
		return $query;
	}
	
	/*
		 * get Category current
		 * By Id or By code
		 */
	function getCategory() {
		$fs_table = FSFactory::getClass ( 'fstable' );
		$code = FSInput::get ( 'ccode' );
		$id = FSInput::get ( 'cid', 0, 'int' );
			if (! $id)
				setRedirect ( FSRoute::_ ( 'index.php?module=notfound&view=notfound&Itemid=1000' ), 'Not exist this url', 'error' );
			$where = " AND id = '$id' ";
		$query = " SELECT *
		FROM " . $fs_table->getTable ( 'fs_videos_categories' ) . " 
		WHERE published = 1 " . $where;
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObject ();
		return $result;
	}
	
	function get_cats() {
		global $db;
		$query = 'SELECT * FROM fs_videos_categories WHERE published = 1';
		$db->query($query);
		$result = $db->getObjectList();
		return $result;
	}

	function get_list($query_body) {
		
		if (! $query_body)
			return;
		
		global $db;
		
		$query = " SELECT * ";
		
		$query .= $query_body;
		$type = FSInput::get ( 'type', 'new' );
		$ordering = '';
		if ($type == 'vote') {
			$ordering .= 'ORDER BY `id` ASC ';
		} elseif ($type == 'hits') {
			$ordering .= 'ORDER BY `hits` DESC ';
		} else {
			$ordering .= 'ORDER BY id DESC ';
		}
		$query .= $ordering;
		$sql = $db->query_limit ( $query, $this->limit, $this->page );
		$result = $db->getObjectList ();
		return $result;
	}
	function getTotal($query_body) {
		if (! $query_body)
			return;
		global $db;
		$query = "SELECT count(*)";
		$query .= $query_body;
		$sql = $db->query ( $query );
		$total = $db->getResult ();
		return $total;
	}
	
	function getPagination($total) {
		FSFactory::include_class ( 'Pagination' );
		$pagination = new Pagination ( $this->limit, $total, $this->page );
		return $pagination;
	}
}

?>