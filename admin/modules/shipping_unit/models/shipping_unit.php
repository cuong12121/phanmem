<?php
class Shipping_unitModelsShipping_unit extends FSModels {
	var $limit;
	var $prefix;
	function __construct() {
		$this->limit = 20;
		$this->view = 'shipping_unit';
		
		$this -> arr_img_paths = array(array('resized',0,0,'resize_image'));

		$this->table_name = FSTable_ad::_('fs_shipping_unit');
        // $this->table_name_cate = FSTable_ad::_('fs_shipping_unit_categories');
//        $this->table_pro_cate = FSTable_ad::_('fs_products_categories');
//        $this->table_new_cate = FSTable_ad::_('fs_news_categories');
//        $this->table_content_cate = FSTable_ad::_('fs_contents_categories');
        $this->table_name_item = FSTable_ad::_('fs_url_items');
		$this->img_folder = 'images/shipping_unit';
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
		$query = " SELECT *
						  FROM 
						  " . $this->table_name . "
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

		$price = FSInput::get ('price');
		$price = $this -> standart_money($price , 0);
		$row ['price'] = $price;
		
		$fsFile = FSFactory::getClass ( 'FsFiles' );
		$flash = $_FILES ["flash"] ["name"];
		if ($flash) {
			$flash = $fsFile->upload_media ( 'flash', PATH_BASE . 'images' . DS . 'shipping_unit' . DS . 'flash' . DS, 2000000 );
			if ($flash) {
				$row ['flash'] = 'images/shipping_unit/flash/' . $flash;
			}
		}
		
		
	
		$id = parent::save ( $row );
		return $id;
	}

	function standart_money($money,$method){
		$money = str_replace(',','' , trim($money));
		$money = str_replace(' ','' , $money);
		$money = str_replace('.','' , $money);
//		$money = intval($money);
		$money = (double)($money);
		if(!$method)
			return $money;
		if($method == 1){
			$money = $money * 1000;
			return $money; 
		}
		if($method == 2){
			$money = $money * 1000000;
			return $money; 
		}
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