<?php
class ModuleModelsModule extends ModelsCategories {
	var $limit;
	var $page;
	function __construct() {
		parent::__construct ();
		$limit = 30;
		$page = FSInput::get ( 'page' );
		$this->limit = $limit;
		$this->page = $page;
		$lang = $_SESSION ['lang'];
		$this->table_menu_item = 'fs_menus_items';
		$this->table_name = 'fs_blocks';
	
	}
	function setQuery() {
		$search = FSInput::get ( 'search' );
		$type = FSInput::get ( 'type' );
		$position = FSInput::get ( 'position' );
		
		// Save in session	
		if (isset ( $search )) {
			$_SESSION ['module_search'] = $search;
		}
		if (isset ( $type )) {
			$_SESSION ['module_type'] = $type;
		}
		if (isset ( $position )) {
			$_SESSION ['module_position'] = $position;
		}
		
		// where
		$where = " WHERE 1=1 "; // for adv
		if (isset($_SESSION ['module_search']) && $_SESSION ['module_search'] ) {
			$where .= " AND title like '%" . $_SESSION ['module_search'] . "%' ";
		}
		
		if (isset($_SESSION ['module_type']) && $_SESSION ['module_type']) {
			$where .= " AND module = '" . $_SESSION ['module_type'] . "' ";
		}
		
		if (isset($_SESSION ['module_position']) &&  $_SESSION ['module_position'] ) {
			$where .= " AND position = '" . $_SESSION ['module_position'] . "' ";
		}
		
		$ordering = "";
		if (isset ( $_SESSION ['module_sort_field'] )) {
			$sort_field = $_SESSION ['module_sort_field'];
			$sort_direct = $_SESSION ['module_sort_direct'];
			$sort_direct = $sort_direct ? $sort_direct : 'asc';
			$ordering = '';
			if ($sort_field)
				$ordering .= " ORDER BY $sort_field $sort_direct ";
		}
		$query = " SELECT *
						  FROM " . $this->table_name . "" . $where . $ordering;
		return $query;
	}
	function getModuleList() {
		global $db;
		$query = $this->setQuery ();
		$sql = $db->query_limit ( $query, $this->limit, $this->page );
		$result = $db->getObjectList ();
		
		return $result;
	}
	
	function getMenuItems() {
		$query = " SELECT a.name, a.parent_id as parent_id, a.id
							  FROM " . $this->table_menu_item . " AS a
							  WHERE show_admin = 0
							  ORDER BY ordering, group_id, parent_id ";
		
		global $db;
		$sql = $db->query ( $query );
		$menus_item = $db->getObjectList ();
		
		$fstree = FSFactory::getClass ( 'tree', 'tree/' );
		$list = $fstree->indentRows ( $menus_item, 3 );
		return $list;
	}
	function getTotal() {
		global $db;
		$query = $this->setQuery ();
		$sql = $db->query ( $query );
		$total = $db->getTotal ();
		return $total;
	}
	
	function getPagination() {
		$total = $this->getTotal ();
		$pagination = new Pagination ( $this->limit, $total, $this->page );
		return $pagination;
	}
	function getModuleTypeList() {
		$query = " SELECT *
								  FROM fs_blocks_exist
								  WHERE  published = 1
								  ORDER BY ordering 
								  ";
		
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectListByKey ( 'block' );
		return $result;
	}
	function getModuleById($cid) {
		$query = " SELECT *
						  FROM " . $this->table_name . "
						  WHERE id = $cid ";
		
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObject ();
		return $result;
	}
	
	/*
		 * Save
		 */
	function save() {
		global $db;
		$title = FSInput::get ( 'title' );
		$published = FSInput::get ( 'published' );
		$showTitle = FSInput::get ( 'showTitle' );
		$ordering = FSInput::get ( 'ordering' );
		$position = FSInput::get ( 'position' );
		$content = htmlspecialchars_decode ( FSInput::get ( 'content' ) );
		$params = $this->generate_params ();
		$type = FSInput::get ( 'type' );
		$id = FSInput::get ( 'id' );
		// listItemid
		$area_select = FSInput::get ( 'area_select' );
		if (! $area_select || $area_select == 'none') {
			$listItemid = 'none';
		} else if ($area_select == 'all') {
			$listItemid = 'all';
		} else {
			$menus_items = FSInput::get ( 'menus_items', array (), 'array' );
			$listItemid = implode ( ',', $menus_items );
			if ($listItemid) {
				$listItemid = ',' . $listItemid . ',';
			}
		}
		
		// products categories
//		$news_categories = FSInput::get ( 'news_categories', array (), 'array' );
//		$str_news_categories = implode ( ',', $news_categories );
//		if ($str_news_categories) {
//			$str_news_categories = ',' . $str_news_categories . ',';
//		}
		
		if (@$id) {
			$sql = " UPDATE  " . $this->table_name . " SET 
							title = '$title',
							published = '$published',
							showTitle = '$showTitle',
							ordering = '$ordering',
							content = '$content',
							params  = '$params',
							position  = '$position',
							listItemid  = '$listItemid',
							module  = '$type'
						WHERE id = 	$id 
				";
			$db->query ( $sql );
			$rows = $db->affected_rows ();
			if ($rows) {
				return $id;
			}
			return 0;
		} else {
			$sql = " INSERT INTO " . $this->table_name . " 
							(title,published,ordering,content,position,params,listItemid,module,news_categories)
							VALUES ('$title','$published','$ordering','$content','$position','$params','$listItemid','$type','$str_news_categories')
							";
			$db->query ( $sql );
			$id = $db->insert ();
			return $id;
		}
	
	}
	function generate_params() {
		$str_params = '';
		$module = FSInput::get ( 'type' );
		// load config of eblocks
		if (file_exists ( PATH_BASE . 'blocks' . DS . $module . DS . 'config.php' ))
			include_once '../blocks/' . $module . '/config.php';
		$params = isset ( $params ) ? $params : array ('suffix' => array ('name' => 'Hậu tố', 'type' => 'text' ) );
		$i = 0;
		foreach ( $params as $key => $value ) {
			if ($i > 0)
				$str_params .= chr ( 13 );
			if ($value ['type'] == 'text') {
				$str_params .= $key . '=' . FSInput::get ( 'params_' . $key );
			} else if ($value ['type'] == 'select') {
				if (@$value ['attr'] ['multiple'] == 'multiple') {
					$v = FSInput::get ( 'params_' . $key, array (), 'array' );
					$v = $v ? implode ( ',', $v ) : '';
					$str_params .= $key . '=' . $v;
				} else {
					$str_params .= $key . '=' . FSInput::get ( 'params_' . $key );
				}
			} else if ($value ['type'] == 'is_check') {
				$str_params .= $key . '=' . FSInput::get ( 'params_' . $key );
			}
			$i ++;
		}
		return $str_params;
	}
	
	function htmlspecialbo($str) {
		$arrDenied = array ('<', '>', '"' );
		$arrReplace = array ('&lt;', '&gt;', '&quot;' );
		$str = str_replace ( $arrDenied, $arrReplace, $str );
		return $str;
	}
	/*
	 * remove record
	 */
	function remove() {
		$cids = FSInput::get ( 'cid', array (), 'array' );
		
		if (count ( $cids )) {
			global $db;
			$str_cids = implode ( ',', $cids );
			$sql = " DELETE FROM " . $this->table_name . " 
						WHERE id IN ( $str_cids ) ";
			$db->query ( $sql );
			$rows = $db->affected_rows ();
			return $rows;
		}
		return 0;
	
	}
	/*
	 * value: == 1 :published
	 * value  == 0 :unpublished
	 * published record
	 */
	function published($value) {
		$cids = FSInput::get ( 'cid', array (), 'array' );
		
		if (count ( $cids )) {
			global $db;
			$str_cids = implode ( ',', $cids );
			$sql = " UPDATE " . $this->table_name . "
							SET published = $value
						WHERE id IN ( $str_cids ) ";
			$db->query ( $sql );
			$rows = $db->affected_rows ();
			return $rows;
		}
		return 0;
	}
	
	/*
		 * Select all list category of product
		 */
	function get_news_categories() {
		global $db;
		$result = $this->get_records ( '', 'fs_news_categories', '*', 'ordering, parent_id' );
		$tree = FSFactory::getClass ( 'tree', 'tree/' );
		$list = $tree->indentRows2 ( $result );
		
		return $list;
	}

}

?>