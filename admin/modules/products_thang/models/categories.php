<?php 
class ProductsModelsCategories extends ModelsCategories
{
	var $limit;
	var $prefix ;
	function __construct()
	{
		parent::__construct();
		$this -> limit = 1000;
		$this -> type = 'products';
		$this -> table_items = 'fs_'.$this -> type;
		$this -> table_name = 'fs_'.$this -> type.'_categories';
		$this -> check_alias = 1;
		$this -> call_update_sitemap = 0;
		$this->img_folder = 'images/' . $this->type . '/cat';
		$this->field_img = 'image';
		$this->arr_img_paths = array (array ('resized', 128, 128, 'cut_image' ), array ('large', 480, 640, 'cut_image' ),array('compress',1,1,'compress') );
		$this -> arr_img_paths_banner1 = array(array('resized',600,200,'resized_not_crop'));
		$this -> arr_img_paths_icon_cat = array(array('resized',150,150,'cut_image'));
		$this -> arr_img_paths_menu = array(array('resized',230,340,'cut_image'));
			//synchronize
		$this -> array_synchronize = array('fs_products_filters_values' => array('id'=> 'category_id','alias'=>'category_alias')); // đồng bộ dữ liệu ngoài bảng extend. Viết dang  array(tablename => array(field1, field2,...))
			// exception: key (field need change) => name ( key change follow this field)
		$this -> field_except_when_duplicate = array(array('list_parents','id'),array('alias_wrapper','alias'));
		$this -> calculate_filters = 0;	

	}

		/*
		 * Show list category of product follow page
		 */
		function get_categories_tree()
		{
			global $db;
			$query = $this->setQuery();
			$sql = $db->query($query);
			$result = $db->getObjectList();
			$tree  = FSFactory::getClass('tree','tree/');
			$list = $tree -> indentRows2($result);
			$limit = $this->limit;
			$page  = $this->page?$this->page:1;
			
			$start = $limit*($page-1);
			$end = $start + $limit;
			
			$list_new = array();
			$i = 0;
			foreach ($list as $row){
				if($i >= $start && $i < $end){
					$list_new[] = $row;
				}
				$i ++;
				if($i > $end)
					break;
			}
			return $list_new;
		}
		/*
		 * Select all list category of product
		 */
		function get_categories_tree_all()
		{
			global $db;
			$query = $this->setQuery();
			$sql = $db->query($query);
			$result = $db->getObjectList();
			$tree  = FSFactory::getClass('tree','tree/');
			$list = $tree -> indentRows2($result);
			
			return $list;
		}
		
		function setQuery(){
			
			// ordering
			$ordering = "";
			if(isset($_SESSION[$this -> prefix.'sort_field']))
			{
				$sort_field = $_SESSION[$this -> prefix.'sort_field'];
				$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
				$sort_direct = $sort_direct?$sort_direct:'asc';
				$ordering = '';
				if($sort_field)
					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
				
			}
			if(!$ordering)
				$ordering .= " ORDER BY ordering ASC , created_time DESC , id DESC ";
			
			$where = "  ";
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND name LIKE '%".$keysearch."%' ";
				}
			}
			
			$query = " SELECT a.*, a.parent_id as parent_id 
			FROM 
			".$this -> table_name." AS a
			WHERE 1=1".
			$where.
			$ordering. " ";
			
			return $query;
		}
		function get_tablenames(){
			$query = " 	   SELECT DISTINCT(a.table_name) 
			FROM fs_".$this -> type."_tables AS a 
			";
			global $db;
			$db->query($query);
			$list = $db->getObjectList();
			$list = array_merge( array(0=>(object) array('table_name'=>'fs_products')),$list);
			return $list;
		}
		function save($row = array(), $use_mysql_real_escape_string = 0){
			$name = FSInput::get ('name');
			$id = FSInput::get ('id');
			$this->save_new_session();
			if(!$id){
				$check_name = $this->get_result('name="'.$name.'"');
				if($check_name){
					setRedirect('index.php?module=products&view=categories&task=add',FSText :: _('Tên danh mục đã tồn tại !'),'error');
					return false;
				}
				
			}else{
				$check_name = $this->get_result('name="'.$name.'" AND id != '.$id);
				if($check_name){
					setRedirect('index.php?module=products&view=categories&task=edit&id='.$id,FSText :: _('Tên danh mục đã tồn tại !'),'error');
					return false;
				}
			}

			
			$cat = $this->get_record_by_id($id);
			$tablename = FSInput::get ( 'tablename' );
			$row['tablename'] = "fs_products_parameter";

			// // ko cho chuyen bang
			// if($id){
			// 	$data_id = $this ->get_categories_id($id);
			// 	if($data_id){
			// 		$table_id_name =  $data_id ->tablename;
			// 		if($tablename != $table_id_name ){
			// 			$data_table = $this ->get_data_table_thang($table_id_name);
			// 			$count_data =  count($data_table);
			// 			if($count_data > 0){
			// 				setRedirect('index.php?module=products&view=categories&task=edit&id='.$id,FSText :: _('Đã tồn tại sản phẩm trong danh mục nên ko chuyển được bảng !'),'error');
			// 				return false;
			// 			}
			// 		}
			// 	}
			// }
			

			// end ko cho chuyen bang
			$rid = parent::save ($row);
			
			if($tablename){
				//$this -> update_table_extend($rid,$tablename);
			}


		

			return $rid;
		}

		function update_products_compatable($category_id){
			if(!$category_id)
				return;
			$arr = FSInput::get ( 'products_record_compatable', array (), 'array' );

			$str_prices_is = '';

			if(empty( $arr )){
				$this -> _remove('category_id = '.$category_id ,'fs_products_categories_kilogam');
				return;
			} 
				
			$arr = array_unique ( $arr );
			$str_prices_is = implode ( ',', $arr ) ;
			if($str_prices_is){
				$str_prices_is = ',' . $str_prices_is . ',';
			}



			$this -> _remove(' manufactory_id NOT IN (0'.$str_prices_is.'0) AND category_id = '.$category_id ,'fs_products_categories_kilogam');
			
			$arr_prices = $this -> get_prices_by_ids($str_prices_is,$category_id); 

			
			foreach($arr_prices as $item){
				$row = array();
				$row['kilogam'] = FSInput::get('price_value_'.$item -> id);
				$row['category_id'] = $category_id;
				$row['manufactory_id'] = $item -> id;
				$row['manufactory_name'] = $item -> name;
				// printr($row);
				
				$check_ex =  $this -> get_records('manufactory_id ='.$item-> id.' AND category_id = '.$category_id ,'fs_products_categories_kilogam','*');

				if(!empty($check_ex)){	
					$this -> _update($row, 'fs_products_categories_kilogam','category_id ='.$category_id.' AND manufactory_id = '.$item -> id);
				}else{
					$this -> _add($row, 'fs_products_categories_kilogam');
				}
			}
			return true;
		}


		function update_seo_manu($category_id){
			if(!$category_id)
				return;
			$arr = FSInput::get ( 'products_record_seo_manu', array (), 'array' );

			$str_prices_is = '';

			if(empty( $arr )){
				$this -> _remove('category_id = '.$category_id ,'fs_products_categories_seo_manufactory');
				return;
			} 
				
			$arr = array_unique ( $arr );
			$str_prices_is = implode ( ',', $arr ) ;
			if($str_prices_is){
				$str_prices_is = ',' . $str_prices_is . ',';
			}



			$this -> _remove(' manufactory_id NOT IN (0'.$str_prices_is.'0) AND category_id = '.$category_id ,'fs_products_categories_seo_manufactory');
			
			$arr_prices = $this -> get_prices_by_ids($str_prices_is,$category_id); 

			
			foreach($arr_prices as $item){
				$row = array();
				$row['seo_title'] = FSInput::get('seo_title_'.$item -> id);
				$row['seo_keyword'] = FSInput::get('seo_keyword_'.$item -> id);
				$row['seo_description'] = FSInput::get('seo_description_'.$item -> id);
				$row['category_id'] = $category_id;
				$row['manufactory_id'] = $item -> id;
				$row['manufactory_name'] = $item -> name;
				// printr($row);
				
				$check_ex =  $this -> get_records('manufactory_id ='.$item-> id.' AND category_id = '.$category_id ,'fs_products_categories_seo_manufactory','*');

				if(!empty($check_ex)){	
					$this -> _update($row, 'fs_products_categories_seo_manufactory','category_id ='.$category_id.' AND manufactory_id = '.$item -> id);
				}else{
					$this -> _add($row, 'fs_products_categories_seo_manufactory');
				}
			}
			return true;
		}

		function  get_prices_by_ids($str_prices_id){
			if (! $str_prices_id)
				return;
			$query = " SELECT id, name
							FROM fs_manufactories
							WHERE id IN (0" . $str_prices_id . "0) ";
			global $db;
			$sql = $db->query ( $query );
			$result = $db->getObjectListByKey('id');
			return $result;
		}

		function get_products_categories_kilogam($cat_id){
		 	if(!$cat_id)
		 		return;
		 	$query   = " SELECT *
		 	FROM fs_products_categories_kilogam
		 	WHERE category_id = '$cat_id'
		 	ORDER BY id ASC
		 	";
		 	global $db;
		 	$sql = $db->query($query);
		 	$result = $db->getObjectList();
		 	return $result;
		 }

		function get_seo_manu($cat_id){
		 	if(!$cat_id)
		 		return;
		 	$query   = " SELECT *
		 	FROM fs_products_categories_seo_manufactory
		 	WHERE category_id = '$cat_id'
		 	ORDER BY id ASC
		 	";
		 	global $db;
		 	$sql = $db->query($query);
		 	$result = $db->getObjectList();
		 	return $result;
		}







		function get_data_table_thang($tablename){
    		$query = " SELECT *
    				FROM $tablename"
    				;
    		global $db;
    		$sql = $db->query($query);
    		return  $db->getObjectList();
    	}

		function get_categories_id($id){
			$query = " SELECT *
			FROM fs_products_categories
			WHERE id =" . $id
			;
			global $db;
			$sql = $db->query($query);
			return  $db->getObject();
		}

		function get_data_table($tablename,$id){
			$query = " SELECT *
			FROM $tablename where category_id = " .$id
			;
			global $db;
			$sql = $db->query($query);
			return  $db->getObjectList();
		}

			/*
	 *====================AJAX RELATED NEWS==============================
	 */
		function get_news_related($news_related){
			if(!$news_related)
				return;
			$query   = " SELECT id, title 
			FROM fs_news
			WHERE id IN (0".$news_related."0) 
			ORDER BY POSITION(','+id+',' IN '0".$news_related."0')
			";
			global $db;
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
			
/*
		 * select in category
		 */
	function get_news_categories_tree() {
		global $db;
		$sql = " SELECT id, name, parent_id AS parent_id 
		FROM fs_news_categories" ;
		$db->query ( $sql );
		$categories = $db->getObjectList ();

		$tree = FSFactory::getClass ( 'tree', 'tree/' );
		$rs = $tree->indentRows ( $categories, 1 );
		return $rs;
	}
	function ajax_get_news_related(){
		$category_id = FSInput::get('category_id',0,'int');
		$keyword = FSInput::get('keyword');
		$where = ' WHERE published = 1 ';
		if($category_id){
			$where .= ' AND (category_id_wrapper LIKE "%,'.$category_id.',%"	) ';
		}
		$where .= " AND ( title LIKE '%".$keyword."%' OR alias LIKE '%".$keyword."%' )";

		$query_body = ' FROM fs_news '.$where;
		$ordering = " ORDER BY created_time DESC , id DESC ";
		$query = ' SELECT id,category_id,title,category_name '.$query_body.$ordering.' LIMIT 40 ';
		global $db;
		$sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;
	}

	function get_aq_related($aq_related){
		if(!$aq_related)
			return;
		$query   = " SELECT id, title 
		FROM fs_aq
		WHERE id IN (0".$aq_related."0) 
		ORDER BY POSITION(','+id+',' IN '0".$aq_related."0')
		";
		global $db;
		$sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;
	}

function get_aq_categories_tree() {
	global $db;
	$sql = " SELECT id, name, parent_id AS parent_id 
	FROM fs_aq_categories" ;
	$db->query ( $sql );
	$categories = $db->getObjectList ();

	$tree = FSFactory::getClass ( 'tree', 'tree/' );
	$rs = $tree->indentRows ( $categories, 1 );
	return $rs;
}
function ajax_get_aq_related(){
	$category_id = FSInput::get('category_id',0,'int');
	$keyword = FSInput::get('keyword');
	$where = ' WHERE published = 1 ';
	if($category_id){
		$where .= ' AND (category_id_wrapper LIKE "%,'.$category_id.',%"	) ';
	}
	$where .= " AND ( title LIKE '%".$keyword."%' OR alias LIKE '%".$keyword."%' )";

	$query_body = ' FROM fs_aq '.$where;
	$ordering = " ORDER BY created_time DESC , id DESC ";
	$query = ' SELECT id,category_id,title,category_name '.$query_body.$ordering.' LIMIT 40 ';
	global $db;
	$sql = $db->query($query);
	$result = $db->getObjectList();
	return $result;
}
	function show_in_menu($value) {
		$ids = FSInput::get ( 'id', array (), 'array' );
		
		if (count ( $ids )) {
			global $db;
			$str_ids = implode ( ',', $ids );
			$sql = " UPDATE " . $this->table_name . "
							SET show_in_menu = $value
						WHERE id IN ( $str_ids ) ";
			$rows = $db->affected_rows ( $sql );
			return $rows;
		}
		// 	update sitemap
		if ($this->call_update_sitemap) {
			$this->call_update_sitemap ();
		}
		return 0;
	}
	/*
	 *====================AJAX RELATED NEWS end.==============================
	 */


	function get_videos_categories_tree() {
		global $db;
		$sql = " SELECT id, name, parent_id AS parent_id 
		FROM fs_videos_categories" ;
		$db->query ( $sql );
		$categories = $db->getObjectList ();
		return $categories;
	}


	function get_videos_related($news_related){
		if(!$news_related)
			return;
		$query   = " SELECT id, title 
		FROM fs_videos
		WHERE id IN (0".$news_related."0) 
		ORDER BY POSITION(','+id+',' IN '0".$news_related."0')
		";
		global $db;
		$sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;
	}

	function ajax_get_videos_related(){
		$category_id = FSInput::get('category_id',0,'int');
		$keyword = FSInput::get('keyword');
		$where = ' WHERE published = 1 ';
		if($category_id){
			$where .= ' AND (category_id_wrapper LIKE "%,'.$category_id.',%"	) ';
		}
		$where .= " AND ( title LIKE '%".$keyword."%' OR alias LIKE '%".$keyword."%' )";

		$query_body = ' FROM fs_videos '.$where;
		$ordering = " ORDER BY created_time DESC , id DESC ";
		$query = ' SELECT id,category_id,title,category_name '.$query_body.$ordering.' LIMIT 40 ';
		global $db;
		$sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;
	}



	function update_table_extend($cid,$tablename){
		
		$record =  $this->get_record_by_id($cid,$this -> table_name);
		$alias =  $record -> alias;
		if($record -> parent_id){
			$parent =  $this->get_record_by_id($record -> parent_id,$this -> table_name);
			$list_parents = ','.$cid.$parent -> list_parents ;
			$alias_wrapper = ','.$alias.$parent -> alias_wrapper ;
		} else {
			$list_parents = ','.$cid.',';
			$alias_wrapper = ','.$alias.',' ;
		}
		
			// update table items
		$id = FSInput::get('id',0,'int');
		if($id){
			$row2['category_id_wrapper'] = $list_parents;
			$row2['category_alias'] = $record -> alias;
			$row2['category_alias_wrapper'] =  $alias_wrapper;
			$row2['category_name'] =  $record -> name;
			$row2['category_published'] =  $record -> published;
			$row3['is_accessories'] =  $record -> is_accessories;
			$row3['is_service'] =  $record -> is_service;
			
			$this -> _update($row2,$tablename,' category_id = '.$cid.' ');
			$this -> _update($row3,$this -> table_items,' category_id = '.$cid.' ');
		}
	}
	function published($value)
	{
		$ids = FSInput::get('id',array(),'array');
		
		if(count($ids))
		{
			global $db;
			foreach ($ids as $id) {
				$record =  $this->get_record_by_id($id,$this -> table_name);
				$tablename = $record->tablename;
				if(!$tablename)
					continue;
				$sql = " UPDATE ".$tablename."
				SET category_published = $value
				WHERE category_id IN ( $id ) " ;
					// $db->query($sql);
				$result = $db->getResult($sql);
			}
		}
		return parent::published($value);
	}
		/*
		 * value: == 1 :hot
		 * value  == 0 :unhot
		 * published record
		 */
		
		function home($value)
		{
			$ids = FSInput::get('id',array(),'array');
			if(count($ids))
			{
				global $db;
				$str_ids = implode(',',$ids);
				$sql = " UPDATE ".$this -> table_items."
				SET show_in_homepage = $value
				WHERE category_id IN ( $str_ids ) " ;
				// $db->query($sql);
				$result = $db->getResult($sql);
				
			}
			return parent::home($value);
		}

		function ajax_move_category(){
			$id_move = FSInput::get('id_move');
			$id_move_to = FSInput::get('id_move_to');
			if(!$id_move){
				return 'Phải chọn danh mục cần chuyển';
			}

			if(!$id_move_to){
				return 'Phải chọn danh mục cần chuyển đến';
			}

			if($id_move == $id_move_to){
				return '2 danh mục phải khác nhau';
			}

			$user_id = $_SESSION['ad_userid'];
			$username = $_SESSION['ad_username'];
			$cat_id_move = $this->get_record('id = '. $id_move,'fs_products_categories');
			$cat_id_move_to = $this->get_record('id = '. $id_move_to,'fs_products_categories');
			$products = $this->get_records('category_id = '. $id_move,'fs_products','category_id,category_name,category_alias,category_id_wrapper,category_alias_wrapper,tablename,alias,id');
			foreach ($products as $item) {
				$row = array();
				$row['category_id'] = $id_move_to;
				$row['category_name'] = $cat_id_move_to -> name;
				$row['category_alias'] = $cat_id_move_to -> alias;
				$row['category_id_wrapper'] = str_replace(','.$id_move.',', ','.$id_move_to.',', $item-> category_id_wrapper);
				$row['category_alias_wrapper'] = str_replace(','.$cat_id_move->alias.',', ','.$cat_id_move_to->alias.',', $item-> category_alias_wrapper);
				$row['action_id'] = $user_id;
				$row['action_username'] = $username;
				$row['edited_time'] = date('Y-m-d H:i:s');
				$rs = $this->_update ( $row, 'fs_products', '  id = ' . $item->id, 0 );
				if($rs){
					if($item->tablename != 'fs_products'){
						unset($row['action_id']);
						unset($row['action_username']);
						unset($row['edited_time']);
						$rs2 = $this->_update ( $row, $item->tablename, 'record_id = ' . $item->id, 0 );
					}
				}
			}

			return "Chuyển danh mục thành công";
			

		}


		function ajax_get_manufactory_related() {
			// $news_id = FSInput::get ( 'product_id', 0, 'int' );
			// $category_id = FSInput::get ( 'category_id', 0, 'int' );
			$keyword = FSInput::get ( 'keyword' );
			$where = ' WHERE published = 1 ';
			// if ($category_id) {
			// 	$where .= ' AND (category_id_wrapper LIKE "%,' . $category_id . ',%"	) ';
			// }
			$where .= " AND ( name LIKE '%" . $keyword . "%' OR alias LIKE '%" . $keyword . "%' )";
			
			$query_body = ' FROM '.FSTable_ad::_('fs_manufactories').' ' . $where;
			$ordering = " ORDER BY created_time DESC , id DESC ";
			$query = ' SELECT id,name ' . $query_body . $ordering . ' LIMIT 40 ';
			global $db;
			$result = $db->getObjectList ( $query );
			return $result;
		}


		function get_manufactory_related($manufactory_related) {
			if (! $manufactory_related)
				return;
			$query = " SELECT id, name 
						FROM ".FSTable_ad::_('fs_manufactories')."
						WHERE id IN (" . $manufactory_related . ") 
						 ORDER BY POSITION(','+id+',' IN '0" . $manufactory_related . "0')
						";
			global $db;
			$result = $db->getObjectList ( $query );
			return $result;
		}

		function getManufactories($tablename) {
			$where = '';
			if ($tablename) {
				$where .= 'OR tablenames like "%,' . $tablename . ',%"';
			}
			global $db;
			$query = ' SELECT id,name
			FROM fs_manufactories 
			WHERE tablenames is NULL
			' . $where . '	OR tablenames="" ';
			$sql = $db->query ( $query );
			$alias = $db->getObjectList ();
			
			return $alias;
		}


		function ajax_get_products_compatable(){
		 	// $news_id = FSInput::get('product_id',0,'int');
		 	$tablename = FSInput::get('tablename');

		 	$where = '';
			if ($tablename) {
				$where .= 'OR tablenames like "%,' . $tablename . ',%"';
			}
			global $db;
			$query = ' SELECT id,name
			FROM fs_manufactories 
			WHERE tablenames is NULL
			' . $where . '	OR tablenames="" ';
			$sql = $db->query ( $query );
			$alias = $db->getObjectList ();
			
			return $alias;
		}

		function ajax_get_seo_manu(){
		 	// $news_id = FSInput::get('product_id',0,'int');
		 	$tablename = FSInput::get('tablename');

		 	$where = '';
			if ($tablename) {
				$where .= 'OR tablenames like "%,' . $tablename . ',%"';
			}
			global $db;
			$query = ' SELECT id,name
			FROM fs_manufactories 
			WHERE tablenames is NULL
			' . $where . '	OR tablenames="" ';
			$sql = $db->query ( $query );
			$alias = $db->getObjectList ();
			
			return $alias;
		}
	}
	
?>