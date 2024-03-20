<?php
class BlockModelsBlock extends FSModels {
	var $limit;
	var $page;
    var $prefix ;
	function __construct() {
		parent::__construct ();
		$limit = 30;
		$page = FSInput::get ( 'page' );
		$this->limit = $limit;
		$this->page = $page;
        $this -> view = 'block';
		//$lang = $_SESSION ['lang'];
		$this->table_menu_item = 'fs_url_items';
		$this->table_name = 'fs_blocks';
        $this->table_blocks_exist = 'fs_blocks_exist';
        $this->table_content_cate = 'fs_contents_categories';
	
	}
	function setQuery()
		{
			// ordering
			$ordering = "";
			if(isset($_SESSION[$this -> prefix.'sort_field']))
			{
				$sort_field = $_SESSION[$this -> prefix.'sort_field'];
				$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
				$sort_direct = $sort_direct?$sort_direct:'asc';
				$ordering = '';
//				if($sort_field)
//					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
			}
			$where = "  WHERE 1=1 ";
			
            // from
			//if(isset($_SESSION[$this -> prefix.'text0']))
//			{
//				$date_from = $_SESSION[$this -> prefix.'text0'];
//				if($date_from){
//					$date_from = strtotime($date_from);
//					$date_new = date('Y-m-d H:i:s',$date_from);
//					$where .= ' AND a.created_time >=  "'.$date_new.'" ';
//				}
//			}
			
			// to
			//if(isset($_SESSION[$this -> prefix.'text1']))
//			{
//				$date_to = $_SESSION[$this -> prefix.'text1'];
//				if($date_to){
//					$date_to = $date_to . ' 23:59:59';
//					$date_to = strtotime($date_to);
//					$date_new = date('Y-m-d H:i:s',$date_to);
//					$where .= ' AND a.created_time <=  "'.$date_new.'" ';
//				}
//			}
            
			if(isset($_SESSION[$this -> prefix.'keysearch'])){
				$keysearch = $_SESSION[$this -> prefix.'keysearch'];
				if($keysearch){
					$where .= " AND ( a.title LIKE '%".$keysearch."%' OR a.id LIKE '%".$keysearch."%' )
										";
				}
           
			}
            
            if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter){
					$where .= ' AND a.module =  "'.$filter.'"' ;
				}
			}	
		  if(isset($_SESSION[$this -> prefix.'filter1'])){
				$filter = $_SESSION[$this -> prefix.'filter1'];
				if($filter){
					$where .= ' AND a.position =  "'.$filter.'"' ;
				}
			}
			
			$query = " SELECT a.*
						  FROM 
						  	".$this -> table_name." AS a "
						 .$where.
						 $ordering. " ";
			return $query;
	}

	function getMenuItems() {
		$query = " SELECT a.name, a.parent_id as parent_id, a.id
							  FROM " . $this->table_menu_item . " AS a
							  WHERE show_admin = 0
							  AND published = 1
							  ORDER BY id ASC ";
		
		global $db;
		$sql = $db->query ( $query );
		$menus_item = $db->getObjectList ();
		
		$fstree = FSFactory::getClass ( 'tree', 'tree/' );
		$list = $fstree->indentRows ( $menus_item, 3 );
		return $list;
	}


	/*
	 * Save
	 */
	function save($row = array(),$use_mysql_real_escape_string = 1) {
		
		global $db;
        $row = array();
		$title = FSInput::get('title');
		if(!$title)
			return false;
                
		$params = $this->generate_params ();
		$type = FSInput::get ( 'type' );
		$row['module'] = $type;
		$row['params'] = $params;

		$suffix = $this->get_record( 'block = "'.$type.'"', 'fs_blocks_exist', '*', '' );
		$row['link_admin'] = $suffix-> link_admin;
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
		$row['listItemid'] = $listItemid;
        // contents categories
		$contents_categories = FSInput::get ( 'contents_categories', array (), 'array' );
		$str_contents_categories = implode ( ',', $contents_categories );
		if ($str_contents_categories) {
			$str_contents_categories = ',' . $str_contents_categories . ',';
		}
        $row['contents_categories'] = $str_contents_categories;
		// products categories
//		$news_categories = FSInput::get ( 'news_categories', array (), 'array' );
//		$str_news_categories = implode ( ',', $news_categories );
//		if ($str_news_categories) {
//			$str_news_categories = ',' . $str_news_categories . ',';
//		}
		
		return parent::save($row);
	
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