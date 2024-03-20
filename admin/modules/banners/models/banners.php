<?php
class BannersModelsBanners extends FSModels {
	var $limit;
	var $prefix;
	function __construct() {
		$this->limit = 20;
		$this->view = 'banners';
		
		$this -> arr_img_paths = array(array('resized',0,0,'resize_image'),array('compress',0,0,'compress'));

		$this->table_name = FSTable_ad::_('fs_banners');
        $this->table_name_cate = FSTable_ad::_('fs_banners_categories');
        $this->table_pro_cate = FSTable_ad::_('fs_products_categories');
        $this->table_new_cate = FSTable_ad::_('fs_news_categories');
        $this->table_content_cate = FSTable_ad::_('fs_contents_categories');
        $this->table_name_item = FSTable_ad::_('fs_url_items');
		$this->img_folder = 'images/banners';
		$this->check_alias = 0;
		$this->field_img = 'image';
		parent::__construct ();
	}
	
	function setQuery() {
		
		// ordering
		$ordering = "";
		$where = "  ";
		if (isset ( $_SESSION [$this->prefix . 'sort_field'] )) {
			$sort_field = $_SESSION [$this->prefix . 'sort_field'];
			$sort_direct = $_SESSION [$this->prefix . 'sort_direct'];
			$sort_direct = $sort_direct ? $sort_direct : 'asc';
			$ordering = '';
			if ($sort_field)
				$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
		}
		if (! $ordering)
			$ordering .= " ORDER BY ordering DESC , id DESC ";
		if (isset($_SESSION[$this->prefix . 'filter0']))
        {
            $filter = $_SESSION[$this->prefix . 'filter0'];
            if ($filter)
            {
                $where .= ' AND a.category_id =  "' . $filter . '" ';
            }
        }
		if (isset ( $_SESSION [$this->prefix . 'keysearch'] )) {
			if ($_SESSION [$this->prefix . 'keysearch']) {
				$keysearch = $_SESSION [$this->prefix . 'keysearch'];
				$where .= " AND ( a.name LIKE '%" . $keysearch . "%' )";
			}
		}
		$query = " SELECT a.*, a.alias as ccode,b.name as category_name
						  FROM 
						  " . $this->table_name . " AS a
						  LEFT JOIN ". $this->table_name_cate ." as b ON a.category_id  = b.id
						  	WHERE 1=1" . $where . $ordering . " ";
		
		return $query;
	}
		function getMenuItems() {
		$query = " SELECT a.name, a.parent_id as parent_id, a.id
							  FROM ".$this->table_name_item." AS a
							  WHERE published = 1
							  ORDER BY ordering, group_id, parent_id ";
		
		global $db;
		$sql = $db->query ( $query );
		$menus_item = $db->getObjectList ();
		
		$fstree = FSFactory::getClass ( 'tree', 'tree/' );
		$list = $fstree->indentRows ( $menus_item, 3 );
		return $list;
	}
	function save($row = array(),$use_mysql_real_escape_string = 1) {
		$name = FSInput::get ( 'name' );
		if (! $name) {
			Errors::_ ( 'You must enter name' );
			return false;
		}
		
		$fsFile = FSFactory::getClass ( 'FsFiles' );
		$flash = $_FILES ["flash"] ["name"];
		if ($flash) {
			$flash = $fsFile->upload_media ( 'flash', PATH_BASE . 'images' . DS . 'banners' . DS . 'flash' . DS, 2000000 );
			if ($flash) {
				$row ['flash'] = 'images/banners/flash/' . $flash;
			}
		}
		
		// news categories
		$news_categories = FSInput::get ( 'news_categories', array (), 'array' );
		$str_news_categories = implode ( ',', $news_categories );
		if ($str_news_categories) {
			$str_news_categories = ',' . $str_news_categories . ',';
		}
		$row['news_categories'] = $str_news_categories;
		if($str_news_categories){
			$list_news_cat = $this -> get_records(' id IN (0'.$str_news_categories.'0)','fs_news_categories','alias');
			$str_news_categories_alias = '';
			foreach($list_news_cat as $item){
				if($item -> alias){
					$str_news_categories_alias .= ','.$item -> alias;	
				}
			}
			$str_news_categories_alias .= ',';
			$row['news_categories_alias'] = $str_news_categories_alias;
		} 
		
		// products categories
		$products_categories = FSInput::get ( 'products_categories', array (), 'array' );
		$str_products_categories = implode ( ',', $products_categories );
		if ($str_products_categories) {
			$str_products_categories = ',' . $str_products_categories . ',';
		}
		$row['products_categories'] = $str_products_categories;
		if($str_products_categories){
			$list_products_cat = $this -> get_records(' id IN (0'.$str_products_categories.'0)','fs_products_categories','alias');
			$str_products_categories_alias = '';
			foreach($list_products_cat as $item){
				if($item -> alias){
					$str_products_categories_alias .= ','.$item -> alias;	
				}
			}
			$str_products_categories_alias .= ',';
			$row['products_categories_alias'] = $str_products_categories_alias;
		} 
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
		$id = parent::save ( $row );
		return $id;
	}
	
	/*
	 * Select all list category of new
	 */
	function get_news_categories() {
		global $db;
		$result = $this->get_records ( '', $this->table_new_cate , '*', 'ordering, parent_id' );
		$tree = FSFactory::getClass ( 'tree', 'tree/' );
		$list = $tree->indentRows2 ( $result );
		
		return $list;
	}
    
    function get_contents_categories() {
		global $db;
		$result = $this->get_records ( '', $this->table_content_cate , '*', 'ordering, parent_id' );
		$tree = FSFactory::getClass ( 'tree', 'tree/' );
		$list = $tree->indentRows2 ( $result );
		
		return $list;
	}
	/*
	 * Select all list category of product
	 */
	function get_products_categories() {
		global $db;
		$result = $this->get_records ( '', $this->table_pro_cate , '*', 'ordering, parent_id' );
		$tree = FSFactory::getClass ( 'tree', 'tree/' );
		$list = $tree->indentRows2 ( $result );
		
		return $list;
	}
}
?>