<?php
class NewsModelsNews extends FSModels {
	var $limit;
	var $prefix;
	function __construct() {
		$this->limit = 50;
		$this->view = 'news';
		
		$this -> table_category_name = FSTable_ad::_ ('fs_news_categories');
		$this->table_types = FSTable_ad::_('fs_news_types');
		
		$this -> arr_img_paths = array(array('resized2',300,300,'cut_image'),array('resized',500,313,'cut_image'),array('small',120,120,'cut_image'),array('large',800,500,'cut_image'));

		$this -> arr_img_paths_banner = array(array('large',800,600,'cut_image'),array('compress',1,1,'compress'));

		$this -> table_name = FSTable_ad::_ ('fs_news');
		
		// config for save
		$cyear = date ( 'Y' );
		$cmonth = date ( 'm' );
		$cday = date ( 'd' );
		$this->img_folder = 'images/news/' . $cyear . '/' . $cmonth . '/' . $cday;
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
		
		// estore
		if (isset ( $_SESSION [$this->prefix . 'filter0'] )) {
			$filter = $_SESSION [$this->prefix . 'filter0'];
			if ($filter) {
				$where .= ' AND a.category_id_wrapper like  "%,' . $filter . ',%" ';
			}
		}
		
		if (! $ordering)
			$ordering .= " ORDER BY created_time DESC , id DESC ";
		
		if (isset ( $_SESSION [$this->prefix . 'keysearch'] )) {
			if ($_SESSION [$this->prefix . 'keysearch']) {
				$keysearch = $_SESSION [$this->prefix . 'keysearch'];
				$where .= " AND a.title LIKE '%" . $keysearch . "%' OR a.id='".$keysearch."'";
			}
		}
		

		$module =$_GET['module'];
		$view= $_GET['view'];
		$permission = FSSecurity::check_permission_other($module, $view, 'display');
		
		if(!$permission){
			$where .= " AND a.creator_id = ". $_SESSION['ad_userid'];
		}


		$query = " SELECT a.*
		FROM 
		" . $this->table_name . " AS a
		WHERE 1=1 AND is_trash = 0 " . $where . $ordering . " ";
		return $query;
	}
	
	function save($row = array(), $use_mysql_real_escape_string = 1) {
		
			
		$name = FSInput::get('title');
		$id = FSInput::get('id');

	
		$this -> assign_without_editing($id);
		$this->save_new_session();
		if(!$id){
			$check_name = $this->get_result('title="'.$name.'"');
			if($check_name){
				setRedirect('index.php?module=news&view=news&task=add',FSText :: _('Tiêu đề đã tồn tại !'),'error');
				return false;
			}
			
		}else{
			$check_name = $this->get_result('title="'.$name.'" AND id != '.$id);
			if($check_name){
				setRedirect('index.php?module=news&view=news&task=edit&id='.$id,FSText :: _('Tiêu đề đã tồn tại !'),'error');
				return false;
			}
		}	



			$category_id = FSInput::get('category_id',0,'int');
		if (! $category_id) {
			Errors::_ ( 'Bạn phải chọn danh mục' );
			return;
		}
		
			$cat =  $this->get_record_by_id($category_id,FSTable_ad::_ ('fs_news_categories'));

			$category_id_0n = $cat->id;

			// category and category_id_wrapper danh mục phụ
			$category_id_wrapper = FSInput::get ( 'category_id_wrapper',array (), 'array');

			

			$str_category_id = implode ( ',', $category_id_wrapper );

			if ($str_category_id) {
				$str_category_id = ',' . $str_category_id . ',';
			}

			$wrapper_id_all ="";
			$wrapper_alias ="";
			for($i = 0; $i < count($category_id_wrapper) ; $i ++)
			{ 
				$item = $category_id_wrapper[$i];
				$alias = $this -> get_record_by_id($item,'fs_news_categories','alias,list_parents');
				$wrapper_id_all .= $alias->list_parents;
			}
			
			$str_dd= str_replace(',,', ',', $wrapper_id_all);
			$array_id=$str_dd.$category_id_0n.',';
			$array_wrap_id=explode(',',$array_id);
			$array_id_emp=array_filter($array_wrap_id);
			$arr_show=array_unique($array_id_emp);
			for($j = 0 ; $j < count($array_id_emp); $j ++)
			{ 
				$item = $array_id_emp[$j];
				// $alias = $this -> get_record_by_id($item,'fs_news_categories','alias');
				$wrapper_alias .= $alias->alias.',';
			}
			$array_wrap_alias=explode(',',$wrapper_alias);
			$arr_show_alias=array_unique($array_wrap_alias);
			$arr_show_count_alias=implode(',',$arr_show_alias);
			$arr_show_count=implode(',',$arr_show);

			$arr_list_parents = explode(',',$cat->list_parents);

			unset($arr_list_parents[count($arr_list_parents) - 1]);
			unset($arr_list_parents[0]);

			// printr($arr_list_parents);
			
			$array_merge = array_merge($arr_list_parents, $arr_show);

			$array_merge = array_unique($array_merge, 0);
			$str_show_count=implode(',',$array_merge);
			// printr($str_show_count);

			$str_show_count_alias = "";
			foreach ($array_merge as $val) {
				$get_alias = $this->get_record('id= ' .$val ,'fs_news_categories');
				if($get_alias){
					$str_show_count_alias .= $get_alias->alias . ',';
				}
				
			}

			if(!$id){
				$row ['creator_id'] = $_SESSION['ad_userid'];
			}
			
			$row ['category_id_wrapper'] = ','.$str_show_count.',';
			$row ['category_alias_wrapper'] = ','. $str_show_count_alias;

			// echo "<pre>";
			// print_r($row);
			// die;






			
			// $row ['category_id_wrapper'] = $cat->list_parents;
			// $row ['category_alias_wrapper'] = $cat->alias_wrapper;
		$row ['category_name'] = $cat->name;
		$row ['category_alias'] = $cat->alias;
		$row ['category_published'] = $cat->published;

		$row ['is_trash'] = 0;
		
		// $row['content'] = $_POST['content'];
		

		// user
		// $user_group = $_SESSION['ad_group'];
		$user_id = $_SESSION ['ad_userid'];
		$username = $_SESSION ['ad_username'];
		//			$fullname = $_SESSION['ad_fullname'];
		if (! $id) {
			$row ['action_id'] = $user_id;
			$row ['action_name'] = $username;
		}


		$tags = FSInput::get ('tags');
		if($tags){
			$str_tag = ',';
			$row ['tags'] = $tags;
			$tags_arr = explode(',',$tags);
			if(!empty($tags_arr)){
				foreach ($tags_arr as $tag_it) {
					$get_tag = $this-> get_record('name = "'.$tag_it.'"' ,'fs_products_tags');
					if(!empty($get_tag)){
						$str_tag .= $get_tag->id.',';
					}else{
						// $fsstring = FSFactory::getClass ( 'FSString', '', '../' );
						// $row_tag = array();
						// $row_tag['name'] = trim($tag_it);
						// $row_tag['alias'] = $fsstring->stringStandart ($row_tag['name']);
						// $row_tag['published'] = 1;
						// $row_tag['created_time'] = date('Y-m-d H:i:s');
						// $row_tag['user_id'] = $_SESSION['ad_userid'];
						// $row_tag['user_name'] = $_SESSION['ad_username'];
						// $add_tag_id = $this-> _add($row_tag,'fs_products_tags',1);
						// $str_tag .= $add_tag_id.',';
					}
				}
			}

			$row ['tag_group'] = $str_tag;
		}

		$fsFile = FSFactory::getClass ( 'FsFiles' );
		//banner
		$image_banner_name = $_FILES["banner"]["name"];
		if($image_banner_name){
			$image_banner = $this->upload_image('banner','_'.time(),200000000,$this -> arr_img_paths_banner);
			if($image_banner){
				$row['banner'] = $image_banner;
			}
		}


		// related products
		$record_relate = FSInput::get ( 'products_record_related', array (), 'array' );
		$row ['products_related'] = '';
		if (count ( $record_relate )) {
			$record_relate = array_unique ( $record_relate );
			$row ['products_related'] = ',' . implode ( ',', $record_relate ) . ',';
		}
		$record_news_relate = FSInput::get ( 'news_record_related', array (), 'array' );
		$row ['news_related'] = '';
		if (count ( $record_news_relate )) {
			$record_news_relate = array_unique ( $record_news_relate );
			$row ['news_related'] = ',' . implode ( ',', $record_news_relate ) . ',';
		}
		$result_id = parent::save ( $row );
		if ($result_id) {
			$old_record = $this->get_record_by_id ( $result_id );
			//				if(!$id){
			//					$row['id'] = $result_id;
			$this->save_history ( $old_record );
			
		//				}else{
		//					$this -> save_history($old_record);
		//				}
		}
		return $result_id;
	}
	
	/*
		 * select in category of home
		 */
	function get_categories_tree() {
		global $db;
		$query = " SELECT a.*
		FROM 
		" . $this->table_category_name . " AS a
		ORDER BY ordering ";
		$result = $db->getObjectList ( $query );
		$tree = FSFactory::getClass ( 'tree', 'tree/' );
		$list = $tree->indentRows2 ( $result );
		return $list;
	}

	
	function get_author()
	{
		global $db;
		$query = " SELECT a.*
		FROM 
		fs_news_author AS a
		ORDER BY ordering ";
		$sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;
	}
	
	function save_history($old_record) {
		if (! $old_record)
			return;
		$user_group = $_SESSION ['ad_groupid'];
		$user_id = $_SESSION ['ad_userid'];
		$username = $_SESSION ['ad_username'];
		//			$fullname = $_SESSION['cms_fullname'];
		

		$fields_in_table = $this->get_field_table ( 'fs_news_history' );
		$str_update = array ();
		$field_img = isset ( $this->field_img ) ? $this->field_img : 'image';
		
		// mảng  $row1 này chỉ phục vụ cho việc đồng bộ dữ liệu ra bảng ngoài theo cấu hình $array_synchronize
		$row = array ();
		for($i = 0; $i < count ( $fields_in_table ); $i ++) {
			$item = $fields_in_table [$i];
			$field = $item->Field;
			
			if ($field == 'id') {
				continue;
			}
			if (isset ( $old_record->$field )) {
				$row [$field] = $old_record->$field;
			}
		}
		$time = date ( 'Y-m-d H:i:s' );
		$row ['news_id'] = $old_record->id; // synchronize
		$row ['action_time'] = $time; // synchronize
		$row ['action_username'] = $username; // synchronize
		$row ['action_id'] = $user_id; // synchronize
		//			$row['action_name'] = $fullname;// synchronize
		$this->_add ( $row, 'fs_news_history', 1 );
	}
	/*
	     * Save all record for list form
	     */
	function save_all() {
		$total = FSInput::get ( 'total', 0, 'int' );
		if (! $total)
			return true;
		$field_change = FSInput::get ( 'field_change' );
		if (! $field_change)
			return false;
		$field_change_arr = explode ( ',', $field_change );
		$total_field_change = count ( $field_change_arr );
		$record_change_success = 0;
		for($i = 0; $i < $total; $i ++) {
			//	        	$str_update = '';
			$row = array ();
			$update = 0;
			foreach ( $field_change_arr as $field_item ) {
				$field_value_original = FSInput::get ( $field_item . '_' . $i . '_original' );
				$field_value_new = FSInput::get ( $field_item . '_' . $i );
				if (is_array ( $field_value_new )) {
					$field_value_new = count ( $field_value_new ) ? ',' . implode ( ',', $field_value_new ) . ',' : '';
				}
				
				if ($field_value_original != $field_value_new) {
					$update = 1;
					// category
					if ($field_item == 'category_id') {
						$cat = $this->get_record_by_id ( $field_value_new, 'fs_news_categories' );
						$row ['category_id_wrapper'] = $cat->list_parents;
						$row ['category_alias_wrapper'] = $cat->alias_wrapper;
						$row ['category_published'] = $cat->published;
						$row ['category_name'] = $cat->name;
						$row ['category_alias'] = $cat->alias;
						$row ['category_id'] = $field_value_new;
					} else {
						$row [$field_item] = $field_value_new;
					}
				}
			}
			if ($update) {
				$id = FSInput::get ( 'id_' . $i, 0, 'int' );
				$str_update = '';
				global $db;
				$j = 0;
				foreach ( $row as $key => $value ) {
					if ($j > 0)
						$str_update .= ',';
					$str_update .= "`" . $key . "` = '" . $value . "'";
					$j ++;
				}
				
				$sql = ' UPDATE  ' . $this->table_name . ' SET ';
				$sql .= $str_update;
				$sql .= ' WHERE id =    ' . $id . ' ';
				$rows = $db->affected_rows ( $sql );
				if (! $rows)
					return false;
				$record_change_success ++;
			}
		}
		return $record_change_success;
		
	}
	/*
		 * value: == 1 :hot
		 * value  == 0 :unhot
		 * published record
		 */
	function hot($value) {
		$ids = FSInput::get ( 'id', array (), 'array' );
		
		if (count ( $ids )) {
			global $db;
			$str_ids = implode ( ',', $ids );
			$sql = " UPDATE " . $this->table_name . "
			SET is_hot = $value
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
		 * value: == 1 :hot
		 * value  == 0 :unhot
		 * published record
		 */
	function promotion($value) {
		$ids = FSInput::get ( 'id', array (), 'array' );
		
		if (count ( $ids )) {
			global $db;
			$str_ids = implode ( ',', $ids );
			$sql = " UPDATE " . $this->table_name . "
			SET is_promotion = $value
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
		 * value: == 1 :hot
		 * value  == 0 :unhot
		 * published record
		 */
	function instalment($value) {
		$ids = FSInput::get ( 'id', array (), 'array' );
		
		if (count ( $ids )) {
			global $db;
			$str_ids = implode ( ',', $ids );
			$sql = " UPDATE " . $this->table_name . "
			SET is_instalment = $value
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
		 * value: == 1 :hot
		 * value  == 0 :unhot
		 * published record
		 */
	function ask($value) {
		$ids = FSInput::get ( 'id', array (), 'array' );
		
		if (count ( $ids )) {
			global $db;
			$str_ids = implode ( ',', $ids );
			$sql = " UPDATE " . $this->table_name . "
			SET is_ask = $value
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
		 * select in category
		 */
	function get_products_categories_tree() {
		global $db;
		$sql = " SELECT id, name, parent_id AS parent_id 
		FROM fs_products_categories
		ORDER BY ordering ASC ";
		$categories = $db->getObjectList ( $sql );
		
		$tree = FSFactory::getClass ( 'tree', 'tree/' );
		$rs = $tree->indentRows ( $categories, 1 );
		return $rs;
	}
	function ajax_get_products_related() {
		$news_id = FSInput::get ( 'product_id', 0, 'int' );
		$category_id = FSInput::get ( 'category_id', 0, 'int' );
		$keyword = FSInput::get ( 'keyword' );
		$where = ' WHERE published = 1 AND is_trash = 0 ';
		if ($category_id) {
			$where .= ' AND (category_id_wrapper LIKE "%,' . $category_id . ',%"	) ';
		}
		$where .= " AND ( name LIKE '%" . $keyword . "%' OR alias LIKE '%" . $keyword . "%' )";
		
		$query_body = ' FROM fs_products ' . $where;
		$ordering = " ORDER BY created_time DESC , id DESC ";
		$query = ' SELECT id,category_id,name,category_name ' . $query_body . $ordering . ' LIMIT 40 ';
		global $db;
		$result = $db->getObjectList ( $query );
		return $result;
	}
	/*
	 *====================AJAX RELATED NEWS==============================
	 */
	function get_products_related($products_related) {
		if (! $products_related)
			return;
		$query = " SELECT id, name 
		FROM fs_products
		WHERE id IN (0" . $products_related . "0) 
		ORDER BY POSITION(','+id+',' IN '0" . $products_related . "0')
		";
		global $db;
		$result = $db->getObjectList ( $query );
		return $result;
	}
	/*
		 * select in category
		 */
	function get_news_categories_tree() {
		global $db;
		$sql = " SELECT id, name, parent_id AS parent_id 
		FROM fs_news_categories
		ORDER BY ordering ASC ";
		$categories = $db->getObjectList ( $sql );
		
		$tree = FSFactory::getClass ( 'tree', 'tree/' );
		$rs = $tree->indentRows ( $categories, 1 );
		return $rs;
	}
	function ajax_get_news_related() {
		$category_id = FSInput::get ( 'category_id', 0, 'int' );
		$keyword = FSInput::get ( 'keyword' );
		$where = ' WHERE published = 1 ';
		if ($category_id) {
			$where .= ' AND (category_id_wrapper LIKE "%,' . $category_id . ',%"	) ';
		}
		$where .= " AND ( title LIKE '%" . $keyword . "%' OR alias LIKE '%" . $keyword . "%' )";
		
		$query_body = ' FROM fs_news ' . $where;
		$ordering = " ORDER BY created_time DESC , id DESC ";
		$query = ' SELECT id,category_id,title,category_name ' . $query_body . $ordering . ' LIMIT 40 ';
		global $db;
		$result = $db->getObjectList ( $query );
		return $result;
	}
	/*
	 *====================AJAX RELATED NEWS==============================
	 */
	function get_news_related($news_related) {
		if (! $news_related)
			return;
		$query = " SELECT id, title 
		FROM fs_news
		WHERE id IN (0" . $news_related . "0) 
		ORDER BY POSITION(','+id+',' IN '0" . $news_related . "0')
		";
		global $db;
		$result = $db->getObjectList ( $query );
		return $result;
	}
	
	function remove_cache() {
		
		// $this -> remove_memcached();
		$fsCache = FSFactory::getClass ( 'FSCache' );
		
		$module_rm = 'news';
		$view_rm = 'news';
		$ids = FSInput::get ( 'id', array (), 'array' );
		
		$data = $this->get_record_by_id ( isset ( $ids [0] ) ? $ids [0] : 0 );
		if (! $data)
			return;
		
		$link_detail = FSRoute::_ ( 'index.php?module=news&view=news&id=' . $data->id . '&code=' . $data->alias . '&ccode=' . $data->category_alias );
		$link_detail = str_replace ( URL_ROOT, '/', $link_detail );
		
		$link_detail = md5 ( $link_detail );
		$str_link = $link_detail;
		
		// xoa chi tiết tin
		$fsCache->remove ( $str_link, 'modules/' . $module_rm . '/' . $view_rm );
		
		$fsCache->remove ( $str_link, 'modules/' . $module_rm . '/' . $view_rm );
		
		// xóa trang chủ
		$link_home = md5 ( '/' );
		$fsCache->remove ( $link_home, 'modules/home/home' );
		
		$files = glob ( PATH_BASE . '/cache/modules/news/home/*' );
		foreach ( $files as $file ) {
			if (is_file ( $file )) {
				if (! @unlink ( $file )) {
					//Handle your errors 
				}
			}
		}
		$files = glob ( PATH_BASE . '/cache/modules/news/cat/*' );
		foreach ( $files as $file ) {
			if (is_file ( $file )) {
				if (! @unlink ( $file )) {
					//Handle your errors 
				}
			}
		}
		
		return 1;
	}
	
	function remove_memcached() {
		$array_memkey = array ('blocks', 'config_commom', 'menus', 'banners' );
		$fsmemcache = FSFactory::getClass ( 'fsmemcache' );
		foreach ( $array_memkey as $key ) {
			$fsmemcache->delete ( $key );
		}
	}

	function remove()
	{
		$cids = FSInput::get('id',array(),'array');
		$user_id = $_SESSION['ad_userid'];
		$username = $_SESSION['ad_username'];
		if(count($cids))
		{
			$record_change_success = 0;
			foreach($cids as $item) {
				$data = $this->get_record ( 'id = ' . $item, $this->table_name,'creator_id' );
				$permission = FSSecurity::check_permission($module, $view, 'remove');
				$permission_orther = FSSecurity::check_permission_other($module, $view, 'remove');

				if($permission && !$permission_orther){
					if($data->creator_id !=  $_SESSION['ad_userid']){
						continue;
					}
				}

				if(!$permission && !$permission_orther){
					continue;
				}
				
				$row2 = array ();
				$row2 ['is_trash'] = 1; 
				$row2['eraser_id'] = $user_id;
				$row2['eraser_name'] = $username;
				$row2['eraser_time'] = date('Y-m-d H:i:s');
				$rs = $this->_update ( $row2, $this->table_name, '  id = ' . $item, 0 );
				
				$record_change_success ++;
			}
		}
		return $record_change_success;
	}


}

?>