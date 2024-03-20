<?php
class SalesModelsSales extends FSModels {
	var $limit;
	var $prefix;
	var $image_watermark;
	function __construct() {
		$limit = FSInput::get ( 'limit', 20, 'int' );
		$this->limit = $limit;
		$this->view = 'sales';
		$this->type = 'sales';

		$fstable = FSFactory::getClass ( 'fstable' );					
		$this -> table_name = FSTable_ad::_ ('fs_sales');
		$this -> table_types = FSTable_ad::_ ('fs_' . $this->type . '_types');


		// $this->table_name = 'fs_sales';
		$this->use_table_extend = 0;
//		$this->table_category = 'fs_' . $this->type . '_categories';
		// $this->table_types = 'fs_' . $this->type . '_types';
		//synchronize
		//			$this -> array_synchronize = array('fs_estores_sales'=>array('id'=>'product_id','published'=>'record_published','alias'=>'product_alias','name'=>'product_name','category_name'=>'category_name','category_alias'=>'category_alias','category_alias_wrapper'=>'category_id_wrapper','category_id'=>'category_id','manufactory_country_id'=>'manufactory_country_id','manufactory_country_name'=>'manufactory_country_name','manufactory_country_flag'=>'manufactory_country_flag','manufactory_id'=>'manufactory_id','manufactory_alias'=>'manufactory_alias','manufactory_name'=>'manufactory_name'));
		// calculate filters:
		$this->calculate_filters = 0;
		// config for save
		$cyear = date ( 'Y' );
		$cmonth = date ( 'm' );
		$cday = date ( 'd' );
		$this->img_folder = 'images/sales/' . $cyear . '/' . $cmonth . '/' . $cday;
		$this->check_alias = 1;
		$this->field_img = 'image';
		$this->image_watermark = 0; //Đóng dấu nên ảnh
		$this -> arr_img_paths = array(array('compress',1,1,'compress'));
		parent::__construct ();
		$this->load_params ();
	}
	
//	function load_params() {
//		$module_params = $this->get_params ( $this->module, 'product' );
//		
//		if ($module_params) { // params from fs_config_modules
//			$this->module_params = $module_params;
//			$arr_img_paths = array ();
//			$arr_img_paths_other = array ();
//			
//			FSFactory::include_class ( 'parameters' );
//			$current_parameters = new Parameters ( $module_params );
//			// large size
//			$image_large_size = $current_parameters->getParams ( 'image_large_size' );
//			$image_large_method = $current_parameters->getParams ( 'image_large_method' );
//			if (! $image_large_method)
//				$image_large_method = 'resize_image'; // giữ nguyên dạng ảnh, thêm khoảng trắng
//			$image_large_width = $this->get_dimension ( $image_large_size, 'width' );
//			$image_large_height = $this->get_dimension ( $image_large_size, 'height' );
//			if (! $image_large_width && ! $image_large_height) {
//				$image_large_width = 374;
//				$image_large_height = 380;
//			}
//			$arr_img_paths [] = array ('large', $image_large_width, $image_large_height, $image_large_method );
//			$arr_img_paths_other [] = array ('large', $image_large_width, $image_large_height, $image_large_method );
//			
//			// resized: ảnh đại diện trong trang danh sách
//			$image_resized_size = $current_parameters->getParams ( 'image_resized_size' );
//			$image_resized_method = $current_parameters->getParams ( 'image_resized_method' );
//			if (! $image_resized_method)
//				$image_resized_method = 'resize_image'; // giữ nguyên dạng ảnh, thêm khoảng trắng
//			
//
//			$image_resized_width = $this->get_dimension ( $image_resized_size, 'width' );
//			$image_resized_height = $this->get_dimension ( $image_resized_size, 'height' );
//			if (! $image_resized_width && ! $image_resized_height) {
//				$image_resized_width = 204;
//				$image_resized_height = 190;
//			}
//			$arr_img_paths [] = array ('resized', $image_resized_width, $image_resized_height, $image_resized_method );
//			
//			// small: ảnh nhỏ làm slideshow
//			$image_small_size = $current_parameters->getParams ( 'image_small_size' );
//			$image_small_method = $current_parameters->getParams ( 'image_small_method' );
//			if (! $image_small_method)
//				$image_small_method = 'resize_image'; // giữ nguyên dạng ảnh, thêm khoảng trắng
//			$image_small_width = $this->get_dimension ( $image_small_size, 'width' );
//			$image_small_height = $this->get_dimension ( $image_small_size, 'height' );
//			if ($image_small_width || $image_small_height) {
//				$arr_img_paths [] = array ('small', $image_small_width, $image_small_height, $image_small_method );
//				$arr_img_paths_other [] = array ('small', $image_small_width, $image_small_height, $image_small_method );
//			}
//			$this->arr_img_paths = $arr_img_paths;
//			$this->arr_img_paths_other = $arr_img_paths_other;
//		
//		} else {
//			// default
//			$this->arr_img_paths = array (array ('large', 374, 380, 'resize_image' ), array ('resized', 204, 190, 'resize_image' ), array ('small', 47, 35, 'resize_image' ) );
//			$this->arr_img_paths_other = array (array ('large', 374, 380, 'resize_image' ), array ('small', 47, 35, 'resize_image' ) );
//		}
//	}
	/*
		 * Trả lại kích thước chiều dài hoặc chiều rộng
		 */
//	function get_dimension($size, $dimension = 'width') {
//		if (! $size)
//			return 0;
//		$array = explode ( 'x', $size );
//		if ($dimension == 'width') {
//			return (intval ( @$array [0] ));
//		} else {
//			return (intval ( @$array [1] ));
//		}
//	}
	
	/*
		 * Lấy parameter từ cấu hình vào.............................................................................
		 */
//	function get_params($module, $view, $task = '') {
//		
//		$where = '';
//		$where .= 'module = "' . $module . '" AND view = "' . $view . '"';
//		if ($task == 'display' || ! $task) {
//			$where .= ' AND ( task = "display" OR task = "" OR task IS NULL)';
//		} else {
//			$where .= ' AND task = "' . $task . '" ';
//		}
//		
//		$fstable = FSFactory::getClass ( 'fstable' );
//		global $db;
//		$sql = " SELECT params  FROM " . $fstable->_ ( 'fs_config_modules' ) . "
//				WHERE $where ";
//		$db->query ( $sql );
//		$rs = $db->getResult ();
//		return $rs;
	
		//			FSFactory::include_class('parameters');
	//			$config_name = 'sales_';
	//			$data_params = $this -> get_records('');
	//			if($data -> task)
	//				$config_name  = '_'.$data -> task;
	//			$config = isset($config_module[$config_name])?$config_module[$config_name]:array()  ;	
	//			
	//			$current_parameters = new Parameters($data->params);
	//			$params = isset($config['params'])?$config['params']: null;
//	}
	
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
		// from
		if (isset ( $_SESSION [$this->prefix . 'text0'] )) {
			$date_from = $_SESSION [$this->prefix . 'text0'];
			if ($date_from) {
				$date_from = strtotime ( $date_from );
				$date_new = date ( 'Y-m-d H:i:s', $date_from );
				$where .= ' AND a.edited_time >=  "' . $date_new . '" ';
			}
		}
		
		// to
		if (isset ( $_SESSION [$this->prefix . 'text1'] )) {
			$date_to = $_SESSION [$this->prefix . 'text1'];
			if ($date_to) {
				$date_to = $date_to . ' 23:59:59';
				$date_to = strtotime ( $date_to );
				$date_new = date ( 'Y-m-d H:i:s', $date_to );
				$where .= ' AND a.edited_time <=  "' . $date_new . '" ';
			}
		}
//		if (isset ( $_SESSION [$this->prefix . 'filter0'] )) {
//			$filter = $_SESSION [$this->prefix . 'filter0'];
//			if ($filter) {
//				$where .= ' AND a.category_id_wrapper like   "%,' . $filter . '%," ';
//			}
//		}
//			// SP nổi bật
//		if (isset ( $_SESSION [$this->prefix . 'filter1'] )) {
//			$filter = $_SESSION [$this->prefix . 'filter1'];
//			if ($filter) {
//				if ($filter == 1)
//					$where .= ' AND a.is_hot = 1';
//				else
//					$where .= ' AND a.is_hot = 0';
//			}
//		}
		
		// Trang chủ
//		if (isset ( $_SESSION [$this->prefix . 'filter3'] )) {
//			$filter = $_SESSION [$this->prefix . 'filter3'];
//			if ($filter) {
//				if ($filter == 1)
//					$where .= ' AND a.show_in_homepage = 1';
//				else
//					$where .= ' AND a.show_in_homepage = 0';
//			}
//		}
		

//		//Kích hoạt
//		if (isset ( $_SESSION [$this->prefix . 'filter5'] )) {
//			$filter = $_SESSION [$this->prefix . 'filter5'];
//			if ($filter) {
//				if ($filter == 1)
//					$where .= ' AND a.published = 1';
//				else
//					$where .= ' AND a.published = 0';
//			}
//		}
		if (! $ordering)
			$ordering .= " ORDER BY edited_time DESC , id DESC ";
		
		if (isset ( $_SESSION [$this->prefix . 'keysearch'] )) {
			if ($_SESSION [$this->prefix . 'keysearch']) {
				$keysearch = $_SESSION [$this->prefix . 'keysearch'];
				$where .= " AND ( a.name LIKE '%" . $keysearch . "%' OR a.alias LIKE '%" . $keysearch . "%' OR a.id = '" . $keysearch . "' OR a.code LIKE '%" . $keysearch . "%')";
			}
		}
		
		$query = " SELECT a.*, b.name as type_name
						  FROM 
						  	" . $this->table_name . " AS a
						  	LEFT JOIN fs_sales_types AS b ON a.type = b.id 
						  	WHERE 1=1 " . $where . $ordering . " ";
		return $query;
	}
	
	/*
		 * select in category
		 */
//	function get_categories_tree() {
//		global $db;
//		$where = '';
//		if (isset ( $_SESSION [$this->prefix . 'category_keysearch'] )) {
//			if ($_SESSION [$this->prefix . 'category_keysearch']) {
//				$keysearch = $_SESSION [$this->prefix . 'category_keysearch'];
//				$where .= " AND ( name LIKE '%" . $keysearch . "%' OR alias LIKE '%" . $keysearch . "%' OR id = '" . $keysearch . "')";
//			}
//		}
//		$sql = " SELECT id, name, parent_id AS parent_id  ,level
//				FROM " . $this->table_category . "
//				WHERE 1=1 " . $where;
//		$db->query ( $sql );
//		$categories = $db->getObjectList ();
//		
//		$tree = FSFactory::getClass ( 'tree', 'tree/' );
//		$list = $tree->indentRows2 ( $categories );
//		return $list;
//	}
	/*
		 * select in type
		 */
	function get_types() {
		global $db;
		$query = " SELECT id, name 
				FROM " . $this->table_types." where published = 1";
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}
	
	function save($row = array(), $use_mysql_real_escape_string = 0) {
		$name = FSInput::get ( 'name' );
		if (! $name) {
			Errors::_ ( 'You must entere name' );
			return false;
		}
		$sort= FSInput::get('sort');
		$fsstring = FSFactory::getClass('FSString','','../');
		
		$id = FSInput::get ( 'id', 0, 'int' );
		
		$started_date = FSInput::get('started_date');
		$started_hour = FSInput::get('started_hour',date('H:i'));
		if($started_date){
			$row['started_time'] = date('Y-m-d H:i:s',strtotime($started_hour.':0 '. $started_date));
		}	
		
		$finished_date = FSInput::get('finished_date');
		$finished_hour = FSInput::get('finished_hour',date('H:i'));
		if($finished_date && $finished_hour){
			$row['finished_time'] = date('Y-m-d H:i:s',strtotime($finished_hour.':0 '. $finished_date));
		}
		
		
		// category and category_id_wrapper
//		$category_id = FSInput::get ( 'category_id', 0, 'int' );
//		if (! $category_id) {
//			Errors::_ ( 'You must select category' );
//			return false;
//		}
//		
//		$cat = $this->get_record_by_id ( $category_id, $this->table_category );
//		$row ['category_id_wrapper'] = $cat->list_parents;
//		$row ['category_root_alias'] = $cat->root_alias;
//		$row ['category_alias_wrapper'] = $cat->alias_wrapper;
//		$row ['category_name'] = $cat->name;
//		$row ['category_alias'] = $cat->alias;
//		$row ['category_published'] = $cat->published;
//		$row ['promotion_main'] = $cat->promotion_main;
//		$row ['hotline'] = $cat->hotline;
//		$row ['tablename'] = $cat->tablename;
//		$row ['specs'] = ''; // khi sửa ta xóa specs đi để còn update đc
//		$manufactory_id = FSInput::get ( 'manufactory' );
//		if ($manufactory_id) {
//			$manufactory = $this->get_record_by_id ( $manufactory_id, 'fs_manufactories' );
//			$row ['manufactory'] = $manufactory_id;
//			$row ['manufactory_alias'] = $manufactory->alias;
//			$row ['manufactory_name'] = $manufactory->name;
//			$row ['manufactory_image'] = $manufactory->image;
//		
//		//			$row ['manufactory_published'] = $manufactory->published;
//		}
		// $origin_id = FSInput::get ( 'origin_id' );
		// if ($origin_id) {
		// 	$origin = $this->get_record_by_id ( $origin_id, 'fs_sales_origins' );
		// 	$row ['origin_id'] = $origin_id;
		// 	$row ['origin_name'] = $origin -> name;
		// }
//		$color_id = FSInput::get ( 'color_id' );
//		if ($color_id) {
//			$color = $this->get_record_by_id ( $color_id, 'fs_sales_colors' );
//			$row ['color_id'] = $color_id;
//			$row ['color_name'] = $color->name;
//		}
		
//		$row ['device_info'] = FSInput::get ( 'device_info' );
//		$row ['partnumber'] = FSInput::get ( 'partnumber' );
		//price
//		$price = FSInput::get ( 'price', 0, 'money'  );
//		
//		$price_old = FSInput::get ( 'price_old', 0, 'money'  );
//		
//		$row ['price'] = $price;
//		$row ['price_old'] = $price_old;
		
		// user
		$user_group = isset($_SESSION ['ad_group'])?$_SESSION ['ad_group']:'';
		$user_id = isset($_SESSION ['ad_userid'])?$_SESSION ['ad_userid']:'';
		$username = isset($_SESSION ['ad_username'])?$_SESSION ['ad_username']:'';
		$fullname = isset($_SESSION ['ad_fullname'])?$_SESSION ['ad_fullname']:'';
		if (! $id) {
			$row ['action_id'] = $user_id;
			$row ['action_name'] = $username;
			$row ['editor_id'] = $user_id;
			$row ['editor_name'] = $username;
		
		} else {
			$row ['editor_id'] = $user_id;
			$row ['editor_name'] = $username;
		}
		
		// $types = FSInput::get ( 'types', array (), 'array' );
		// $str_types = implode ( ',', $types );
		// if ($str_types) {
		// 	$str_types = ',' . $str_types . ',';
		// }
		// $row ['types'] = $str_types;
		
		$use_ids = FSInput::get ( 'use_ids', array (), 'array' );
		$str_use_ids = implode ( ',', $use_ids );
		if ($str_use_ids) {
			$str_use_ids = ',' . $str_use_ids . ',';
		}
		$row ['use_ids'] = $str_use_ids;
		$type = FSInput::get('type');
		if($type == 2){
			$row['price'] = FSInput::get ( 'price', 0, 'money'  );
		}elseif($type == 7){
			$row['price_min'] = FSInput::get ( 'price_min', 0, 'money'  );
		}
		// related sales
//		$record_news_relate = FSInput::get ( 'news_record_related', array (), 'array' );
//		$row ['news_related'] = '';
//		if (count ( $record_news_relate )) {
//			$record_news_relate = array_unique ( $record_news_relate );
//			$row ['news_related'] = ',' . implode ( ',', $record_news_relate ) . ',';
//		}
//		
//		$record_video_relate = FSInput::get ( 'video_record_related', array (), 'array' );
//		$row ['video_related'] = '';
//		if (count ( $record_video_relate )) {
//			$record_video_relate = array_unique ( $record_video_relate );
//			$row ['video_related'] = ',' . implode ( ',', $record_video_relate ) . ',';
//		}

		$image_name_2 = $_FILES["image2"]["name"];
		if($image_name_2){
			$image_2 = $this->upload_image('image2','_'.time(),2000000,$this -> arr_img_paths);
			if($image_2){
				$row['image2'] = $image_2;
			}
		}
		
		$rid = parent::save ( $row );
		if (! $rid) {
			Errors::setError ( 'Not save' );
			return false;
		}
		switch ($type){
			case '1':
				$this -> update_products_countdown($rid);
				break;	
			case '2':
				$this -> update_products_parity($rid);
				break;	
			case '3':
				$this -> update_products_salenpromotionm($rid);
				break;	
			case '4':
				$this -> update_products_salenselectgift($rid);
				break;	
			case '5':
				$this -> update_products_combopricedown($rid);
				break;	
			case '6':
				$this -> update_products_comboselectgift($rid);
				break;	
			case '7':
				$this -> update_products_totalhasgift($rid);
				break;	
			case '8':
				break;	
		}
//		if (! $id) {
//			$this->update_other_images ( $rid );
//		}
//		// remove price
//		if (! $this->remove_price ( $rid )) {
//		}
//		// edit price
//		if (! $this->save_exist_price ( $rid )) {
//			//				return false;
//		}
//		// save price
//		if (! $this->save_new_price ( $rid )) {
//		}
//		// Update lại giá cho bảng fs_sales ( dùng giá thấp nhất)
//		$this -> update_price($rid);
		// remove color
//		if (! $this->remove_color ( $rid )) {
//		}
//		// edit color
//		if (! $this->save_exist_color ( $rid )) {
//			//				return false;
//		}
//		// save color
//		if (! $this->save_new_color ( $rid )) {
//		}
		
		/*
		 * Cập nhật lại màu sắc vào bảng màu ( lấy từ price )
		 */
//		$this->update_color_into_sales ( $rid ,$cat->tablename );
		
		return $rid;
	}
	
	function update_products_countdown($sale_id){
		if(!$sale_id)
			return;
		$arr = FSInput::get ( 'countdown_products', array (), 'array' );
		$str_prices_is = '';
		if (!count ( $arr )) 
			return;
		$arr = array_unique ( $arr );
		$str_prices_is = implode ( ',', $arr ) ;
		if($str_prices_is){
			$str_prices_is = ',' . $str_prices_is . ',';
		}

		
		
		$arr_prices = $this -> get_prices_by_ids($str_prices_is); 
		
		$this -> _remove(' price_id NOT IN (0'.$str_prices_is.'0) AND sale_id = '.$sale_id ,'fs_sales_products');
		$arr_saleproducts_exist = $this -> get_records('price_id IN (0'.$str_prices_is.'0) AND sale_id = '.$sale_id ,'fs_sales_products','*','','','price_id');
		
		$str_products_id = '';
		
		foreach($arr_prices as $item){
			$row = array();
			$row['ordering'] = FSInput::get('ordering_'.$item -> id,0,'int');
			$row['total_item'] = FSInput::get('total_item_'.$item -> id,0,'int');
			$row['total_item_buy'] = FSInput::get('total_item_buy_'.$item -> id,0,'int');
			$price = FSInput::get('price_value_'.$item -> id,0,'money');
			if($price == 0 || $price > $item -> price ){
				$price = $item -> price;
			}
			$row['price'] = $price ;

			$row['price_old'] = $item -> price_old?$item -> price_old:$item -> price;
			$row['sale_id'] = $sale_id;
			$row['unit'] = $item -> unit;
			$row['price_id'] = $item -> id;
			$row['product_id'] = $item -> record_id;
			$str_products_id .= ','.$item -> record_id;
			
			if($arr_saleproducts_exist && array_key_exists($item -> id, $arr_saleproducts_exist)){	
				$this -> _update($row, 'fs_sales_products',' id = '.$arr_saleproducts_exist[$item -> id]->id);
			}else{
				$this -> _add($row, 'fs_sales_products');
			}
		}
		$str_products_id = $str_products_id?$str_products_id.',':'';
		$row1 = array();
		$row1['products_ids'] = $str_products_id;
		$row1['prd_prices_ids'] = $str_prices_is;
		$this -> _update($row1, 'fs_sales',' id = '.$sale_id);
		return true;
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
		
		// 	calculate filters: 
		$arr_table_name_changed = array ();
		
		$field_change_arr = explode ( ',', $field_change );
		$total_field_change = count ( $field_change_arr );
		$record_change_success = 0;
		for($i = 0; $i < $total; $i ++) {
			$str_update = '';
			$update = 0;
			$row = array ();
			foreach ( $field_change_arr as $field_item ) {
				$field_value_original = FSInput::get ( $field_item . '_' . $i . '_original' );
				$field_value_new = FSInput::get ( $field_item . '_' . $i );
				if (is_array ( $field_value_new )) {
					$field_value_new = count ( $field_value_new ) ? ',' . implode ( ',', $field_value_new ) . ',' : '';
				}
				
				if ($field_value_original != $field_value_new) {
					$update = 1;
					//	        	          $row[$field_item] = htmlspecialchars_decode($field_value_new);
					$row [$field_item] = htmlspecialchars_decode ( $field_value_new );
				
		//	        	          $str_update[] = "`".$field_item."` = '".$field_value_new."'";
				}
			}
			if ($update) {
				// update price when change discount
				//				$discount = FSInput::get ( 'discount_' . $i );
				//				$discount_unit = FSInput::get ( 'discount_unit_' . $i );
				$price = FSInput::get ( 'price_' . $i , 0, 'money' );
				$price_old = FSInput::get ( 'price_old_' . $i, 0, 'money' );
				$row ['price'] = $price;
				$row ['price_old'] = $price_old;
				//				if ($discount_unit == 'percent') {
				//					if ($discount > 100 || $discount < 0) {
				//					} else {
				//						$row ['price'] = $price_old * (100 - $discount) / 100;
				//					}
				//				} else {
				//					if ($discount > $price_old || $discount < 0) {
				//					} else {
				//						$row ['price'] = $price_old - $discount;
				//					}
				//				}
				// user
				$user_group = $_SESSION ['ad_group'];
				$user_id = $_SESSION ['ad_userid'];
				$username = $_SESSION ['ad_username'];
				$fullname = $_SESSION ['ad_fullname'];
				
				$row2 ['editor_id'] = $user_id;
				$row2 ['editor_name'] = $username;
				
				$id = FSInput::get ( 'id_' . $i, 0, 'int' );
				$rs = $this->_update ( $row, $this->table_name, '  id = ' . $id, 0 );
				$this->_update ( $row2, $this->table_name, '  id = ' . $id, 0 );
				if ($this->use_table_extend) {
					$record = $this->get_record ( 'id = ' . $id, $this->table_name );
					$table_extend = $record->tablename;
					// calculate filters:
					$arr_table_name_changed [] = $table_extend;
					global $db;
					if ($table_extend && $table_extend != 'fs_sales' && $db->checkExistTable ( $table_extend )) {
						$rs = $this->_update ( $row, $table_extend, '  record_id = ' . $id );
					}
				}
				
				//synchronize
				$array_synchronize = $this->array_synchronize;
				if (count ( $array_synchronize )) {
					foreach ( $array_synchronize as $table_name => $fields ) {
						$i = 0;
						$syn = 0;
						$row5 = array ();
						$where = ' WHERE ';
						foreach ( $fields as $cur_field => $syn_field ) {
							if (! $i) {
								$where .= $syn_field . ' = ' . $id;
							} else {
								if (isset ( $row [$cur_field] )) {
									$row5 [$syn_field] = $row [$cur_field];
									$syn = 1;
								}
							}
							$i ++;
						}
						if ($syn)
							$rs = $this->_update ( $row5, $table_name, $where, 0 );
					}
				}
				
				if (! $rs) {
					continue;
				}
				//					return false;
				$record_change_success ++;
			}
		}
		
		// calculate filters:
		if ($this->calculate_filters) {
			$this->caculate_filter ( $arr_table_name_changed );
		}
		return $record_change_success;
	}
	/*
		Can xoa image_other
		*/
	function remove() {
		$cids = FSInput::get ( 'id', array (), 'array' );
		if (! count ( $cids ))
			return false;
		$str_cids = '';
		$i = 0;
		foreach ( $cids as $cid ) {
			if ($i)
				$str_cids .= ',';
			$str_cids .= $cid;
		}
		if (! $str_cids)
			return;
		$this -> _remove( ' sale_id IN  (' . $str_cids . ') ' , 'fs_sales_products' );
		return parent::remove ();
	}
	
	
	/*
		 * Upload imge 
		 * upload to folder: URL_IMG_PD_PRD.category_alias
		 */
	function uploadImage($category_alias) {
		
		$fsFile = FSFactory::getClass ( 'FsFiles', '' );
		$path = PATH_IMG_PD_PRD . $category_alias . "/";
		$image = $fsFile->uploadImage ( "image", $path, 2000000, '_' . time () );
		
		if (! $image)
			return false;
		$path_crop = PATH_IMG_PD_PRD_CROPPED . $category_alias . DS;
		$fsFile->create_folder ( $path_crop );
		if (! $fsFile->cropImge ( $path . $image, $path_crop . $image, 150, 150 )) {
			return false;
		}
		
		return $image;
	}
	
	
	function get_sales_by_ids($str_sales_together) {
		if (! $str_sales_together)
			return;
		$query = " SELECT name,id 
						FROM fs_sales
						WHERE id IN (" . $str_sales_together . ") ";
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
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
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}
	
	/*
		 * select in category
		 */
	function get_products_categories() {
		global $db;
		$sql = " SELECT id, name, parent_id AS parent_id 
				FROM fs_products_categories";
		$db->query ( $sql );
		$categories = $db->getObjectList ();
		
		$tree = FSFactory::getClass ( 'tree', 'tree/' );
		$rs = $tree->indentRows ( $categories, 1 );
		return $rs;
	}
	/*
		 * select in category
		 */
	function get_products_categories_combo() {
		global $db;
		$sql = " SELECT id, name, parent_id AS parent_id 
				FROM fs_products_categories";
		$db->query ( $sql );
		$categories = $db->getObjectList ();
		
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
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}
	function save_exist_price($record_id) {
		
		$rs = 0;
		global $db;
		// Thay doi du lieu da nhap 
		$price_ids_exit = FSInput::get ( 'price_id_exit', array (), 'array' );
//		$is_default = FSInput::get ( 'default_price' );
		foreach ( $price_ids_exit as $item ) {
			$id_exist = FSInput::get ( 'id_exist_' . $item );
			$row ['record_id'] = $record_id;
			$row ['price'] = FSInput::get ( 'price_exist_' . $item ,0,'money' );
			$row ['price_old'] = FSInput::get ( 'price_old_exist_' . $item,0,'money' );
			$row ['unit'] = FSInput::get ( 'unit_exist_' . $item );

			$u = $this->_update ( $row, 'fs_sales_prices', ' id=' . $item );
			if ($u)
				$rs ++;
		}
		return $rs;
	
		// END EXIST FIELD
	}
	function save_new_price($record_id) {
		
		if (! $record_id)
			return true;
		global $db;
		for ( $i = 0; $i < 20; $i ++ ) {
			$row = array ();
			
			$row ['price'] = FSInput::get ( 'new_price_' . $i , 0, 'money' );
			$row ['price_old'] = FSInput::get ( 'new_price_old_' . $i , 0, 'money' );
			$row ['unit'] = FSInput::get ( 'new_unit_' . $i );
			if(!$row ['price'] || !$row ['unit'])
				continue;
			$row ['record_id'] = $record_id;
			print_r($row);
			$rs = $this->_add ( $row, 'fs_sales_prices', 0 );
		}
		return true;
	}
	function remove_price($record_id) {
		
		$rs = 0;
		global $db;
		
		$price_ids_remove = FSInput::get ( 'price_ids_remove' );
		if(!$price_ids_remove)
			return;
			
		$whewe = '';
		
		// remove in database
		$sql = ' DELETE FROM fs_sales_prices
					WHERE record_id = ' . $record_id . ' AND id IN (0' . $price_ids_remove.')';
		$db->query ( $sql );
		$rows = $db->affected_rows ();
		return $rows;
	
		// END EXIST FIELD
	}
	
	// Update lại giá trong bảng fs_product ( dùng giá thấp nhất)
	function update_price($record_id) {
		
		$rs = 0;
		$price_min = $this -> get_record('record_id='.$record_id.' ORDER BY price ASC ','fs_sales_prices','*');
		if(!$price_min)
			return;
		$row = array();
		$row ['price'] = $price_min -> price;
		$row ['price_old'] = $price_min -> price_old;
		$row ['unit'] = $price_min -> unit;
		$this->_update ( $row, 'fs_sales', ' id=' . $record_id );
	
		// END EXIST FIELD
	}
	
	
	/******END PRICE ********/
	
	/******ADD PRODUCTS ********/
	function ajax_get_products_countdown() {
		$category_id = FSInput::get ( 'category_id', 0, 'int' );
		$keyword = FSInput::get ( 'keyword' );
		$where = ' WHERE published = 1 ';
		if ($category_id) {
			$where .= ' AND (category_id_wrapper LIKE "%,' . $category_id . ',%"	) ';
		}
		$where .= " AND ( name LIKE '%" . $keyword . "%' OR alias LIKE '%" . $keyword . "%' OR a.id  = '".$keyword."' )";
		
		$query_body = ' FROM fs_products AS a 
						INNER JOIN fs_products_prices AS b   ON a.id = b.record_id
						
		' . $where;
		$ordering = " ORDER BY created_time DESC , id DESC ";
		$query = ' SELECT a.id,a.category_id,name,a.category_name, b.id as price_id, b.unit as unit, b.price, b.price_old ' . $query_body . $ordering . ' LIMIT 40 ';
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}
	
	
	function  get_prices_by_ids($str_prices_id){
		if (! $str_prices_id)
			return;
		$query = " SELECT *
						FROM fs_products_prices
						WHERE id IN (0" . $str_prices_id . "0) ";
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectListByKey('id');
		return $result;
	}
	function  get_products_by_ids($str_id){
		
		if (! $str_id)
			return;
		$query = " SELECT *
						FROM fs_products
						WHERE id IN (0" . $str_id . "0) ";
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectListByKey('id');
		return $result;
	}
	/****** .end ADD PRODUCTS ********/
	
	function get_products_in_sale($sale_id){
		if (! $sale_id)
			return;
		$query = ' SELECT a.ordering,a.total_item,a.total_item_buy,b.id,a.id as sale_product_id, b.unit,a.price,a.price_old, c.id as product_id,c.name
					FROM fs_sales_products AS a
					LEFT JOIN fs_products_prices AS b ON a.price_id = b.id
					LEFT JOIN fs_products AS c ON  a.product_id = c.id 
					WHERE a.sale_id = '.$sale_id.' 
					 ORDER BY a.id ASC
					';
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}
	
	/*
	 * Lấy dữ liệu từ sale_product để add quà
	 */
	function get_sale_product_select($sale_id){
		if (! $sale_id)
			return;
		$sale_product_id = FSInput::get ( 'sale_product_id', 0, 'int' );
		if (! $sale_product_id)
			return;
		$query = ' SELECT b.id,a.id as sale_product_id, b.unit,b.price,b.price_old, c.id as product_id,c.name
					FROM fs_sales_products AS a
					LEFT JOIN fs_products_prices AS b ON a.price_id = b.id
					LEFT JOIN fs_products AS c ON  a.product_id = c.id 
					WHERE a.sale_id = '.$sale_id.' 
					AND a.id = '.$sale_product_id.'
					 ORDER BY a.id ASC
					';
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObject();
		return $result;
	}
	/*
	 * Lấy dữ liệu từ sale_product để add quà
	 */
	function get_gifts($sale_product_id){
		if (! $sale_product_id)
			return;
		$query = ' SELECT b.id, b.unit,a.price,a.price_old, c.id as product_id,c.name
					FROM fs_sales_products_gifts AS a
					LEFT JOIN fs_products_prices AS b ON a.price_id = b.id
					LEFT JOIN fs_products AS c ON  a.product_id = c.id 
					WHERE a.sale_product_id = '.$sale_product_id.' 
					 ORDER BY a.id ASC
					';
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList();
		return $result;
	}
	
	function get_combo_in_sale($sale_id){
		if (! $sale_id)
			return;
		$query = ' SELECT c.id,a.price,a.price_old, c.name
					FROM fs_sales_products AS a
					LEFT JOIN fs_products AS c ON  a.product_id = c.id 
					WHERE a.sale_id = '.$sale_id.' 
					 ORDER BY a.id ASC
					';
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}
	
	
	/*********** PARITY ************/
	function ajax_get_products_parity() {
		$category_id = FSInput::get ( 'category_id', 0, 'int' );
		$keyword = FSInput::get ( 'keyword' );
		$where = ' WHERE published = 1 AND is_combo <> 1 ';
		if ($category_id) {
			$where .= ' AND (category_id_wrapper LIKE "%,' . $category_id . ',%"	) ';
		}
		$where .= " AND ( name LIKE '%" . $keyword . "%' OR alias LIKE '%" . $keyword . "%' )";
		
		$query_body = ' FROM fs_products AS a 
						INNER JOIN fs_products_prices AS b   ON a.id = b.record_id
						
		' . $where;
		$ordering = " ORDER BY created_time DESC , id DESC ";
		$query = ' SELECT a.id,a.category_id,name,a.category_name, b.id as price_id, b.unit as unit, b.price, b.price_old ' . $query_body . $ordering . ' LIMIT 40 ';
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}
	function update_products_parity($sale_id){
		if(!$sale_id)
			return;
		$arr = FSInput::get ( 'parity_products', array (), 'array' );
		$str_prices_is = '';
		if (!count ( $arr )) 
			return;
		$arr = array_unique ( $arr );
		
		$str_prices_is = implode ( ',', $arr ) ;
		if($str_prices_is){
			$str_prices_is = ',' . $str_prices_is . ',';
		}
		
		$arr_prices = $this -> get_prices_by_ids($str_prices_is); 
		
		$this -> _remove(' price_id NOT IN (0'.$str_prices_is.'0) AND sale_id = '.$sale_id ,'fs_sales_products');
		$arr_saleproducts_exist = $this -> get_records('price_id IN (0'.$str_prices_is.'0) AND sale_id = '.$sale_id ,'fs_sales_products','*','','','price_id');
		
		$str_products_id = '';
		
		foreach($arr_prices as $item){
			$row = array();
//			$row['price'] = FSInput::get('price_value_'.$item -> id,0,'money');
			$row['price_old'] = $item -> price_old?$item -> price_old:$item -> price;
			$row['sale_id'] = $sale_id;
			$row['unit'] = $item -> unit;
			$row['price_id'] = $item -> id;
			$row['product_id'] = $item -> record_id;
			$str_products_id .= ','.$item -> record_id;
			
			if($arr_saleproducts_exist && array_key_exists($item -> id, $arr_saleproducts_exist)){	
				$this -> _update($row, 'fs_sales_products',' id = '.$arr_saleproducts_exist[$item -> id]->id);
			}else{
				$this -> _add($row, 'fs_sales_products');
			}
		}
		$str_products_id = $str_products_id?$str_products_id.',':'';
		$row1 = array();
		$row1['products_ids'] = $str_products_id;
		$row1['prd_prices_ids'] = $str_prices_is;
		$this -> _update($row1, 'fs_sales',' id = '.$sale_id);
		return true;
	}
	/*********** end PARITY ************/
	
	/*********** SALE_N_PROMOTION_M ************/
	function ajax_get_products_salenpromotionm() {
		$category_id = FSInput::get ( 'category_id', 0, 'int' );
		$keyword = FSInput::get ( 'keyword' );
		$where = ' WHERE published = 1 AND is_combo <> 1 ';
		if ($category_id) {
			$where .= ' AND (category_id_wrapper LIKE "%,' . $category_id . ',%"	) ';
		}
		$where .= " AND ( name LIKE '%" . $keyword . "%' OR alias LIKE '%" . $keyword . "%' )";
		
		$query_body = ' FROM fs_products AS a 
						INNER JOIN fs_products_prices AS b   ON a.id = b.record_id
						
		' . $where;
		$ordering = " ORDER BY created_time DESC , id DESC ";
		$query = ' SELECT a.id,a.category_id,name,a.category_name, b.id as price_id, b.unit as unit, b.price, b.price_old ' . $query_body . $ordering . ' LIMIT 40 ';
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}
	function update_products_salenpromotionm($sale_id){
		if(!$sale_id)
			return;
		$arr = FSInput::get ( 'add_products', array (), 'array' );
		$str_prices_is = '';
		if (!count ( $arr )) 
			return;
		$arr = array_unique ( $arr );
		
		$str_prices_is = implode ( ',', $arr ) ;
		if($str_prices_is){
			$str_prices_is = ',' . $str_prices_is . ',';
		}
		
		$arr_prices = $this -> get_prices_by_ids($str_prices_is); 
		
		$this -> _remove(' price_id NOT IN (0'.$str_prices_is.'0) AND sale_id = '.$sale_id ,'fs_sales_products');
		$arr_saleproducts_exist = $this -> get_records('price_id IN (0'.$str_prices_is.'0) AND sale_id = '.$sale_id ,'fs_sales_products','*','','','price_id');
		
		$str_products_id = '';
		
		foreach($arr_prices as $item){
			$row = array();
//			$row['price'] = FSInput::get('price_value_'.$item -> id,0,'money');
			$row['price_old'] = $item -> price_old?$item -> price_old:$item -> price;
			$row['sale_id'] = $sale_id;
			$row['unit'] = $item -> unit;
			$row['price_id'] = $item -> id;
			$row['product_id'] = $item -> record_id;
			$str_products_id .= ','.$item -> record_id;
			
			if($arr_saleproducts_exist && array_key_exists($item -> id, $arr_saleproducts_exist)){	
				$this -> _update($row, 'fs_sales_products',' id = '.$arr_saleproducts_exist[$item -> id]->id);
			}else{
				$this -> _add($row, 'fs_sales_products');
			}
		}
		$str_products_id = $str_products_id?$str_products_id.',':'';
		$row1 = array();
		$row1['products_ids'] = $str_products_id;
		$row1['prd_prices_ids'] = $str_prices_is;
		$this -> _update($row1, 'fs_sales',' id = '.$sale_id);
		return true;
	}
	/*********** end SALE_N_PROMOTION_M ************/
	
	/*********** SALE N SELECT GIFT ************/
	function ajax_get_products_salenselectgift() {
		$category_id = FSInput::get ( 'category_id', 0, 'int' );
		$keyword = FSInput::get ( 'keyword' );
		$where = ' WHERE published = 1 AND is_combo <> 1 ';
		if ($category_id) {
			$where .= ' AND (category_id_wrapper LIKE "%,' . $category_id . ',%"	) ';
		}
		$where .= " AND ( name LIKE '%" . $keyword . "%' OR alias LIKE '%" . $keyword . "%' )";
		
		$query_body = ' FROM fs_products AS a 
						INNER JOIN fs_products_prices AS b   ON a.id = b.record_id
						
		' . $where;
		$ordering = " ORDER BY created_time DESC , id DESC ";
		$query = ' SELECT a.id,a.category_id,name,a.category_name, b.id as price_id, b.unit as unit, b.price, b.price_old ' . $query_body . $ordering . ' LIMIT 40 ';
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}
	function update_products_salenselectgift($sale_id){
		if(!$sale_id)
			return;
		$arr = FSInput::get ( 'add_products', array (), 'array' );
		$str_prices_is = '';
		if (!count ( $arr )) 
			return;
		$arr = array_unique ( $arr );
		
		$str_prices_is = implode ( ',', $arr ) ;
		if($str_prices_is){
			$str_prices_is = ',' . $str_prices_is . ',';
		}
		
		$arr_prices = $this -> get_prices_by_ids($str_prices_is); 
		
		$this -> _remove(' price_id NOT IN (0'.$str_prices_is.'0) AND sale_id = '.$sale_id ,'fs_sales_products');
		$arr_saleproducts_exist = $this -> get_records('price_id IN (0'.$str_prices_is.'0) AND sale_id = '.$sale_id ,'fs_sales_products','*','','','price_id');
		
		$str_products_id = '';
		
		foreach($arr_prices as $item){
			$row = array();
//			$row['price'] = FSInput::get('price_value_'.$item -> id,0,'money');
			$row['price_old'] = $item -> price_old?$item -> price_old:$item -> price;
			$row['sale_id'] = $sale_id;
			$row['unit'] = $item -> unit;
			$row['price_id'] = $item -> id;
			$row['product_id'] = $item -> record_id;
			$str_products_id .= ','.$item -> record_id;
			
			if($arr_saleproducts_exist && array_key_exists($item -> id, $arr_saleproducts_exist)){	
				$this -> _update($row, 'fs_sales_products',' id = '.$arr_saleproducts_exist[$item -> id]->id);
			}else{
				$this -> _add($row, 'fs_sales_products');
			}
		}
		$str_products_id = $str_products_id?$str_products_id.',':'';
		$row1 = array();
		$row1['products_ids'] = $str_products_id;
		$row1['prd_prices_ids'] = $str_prices_is;
		$this -> _update($row1, 'fs_sales',' id = '.$sale_id);
		return true;
	}
	/*********** end  SALE N SELECT GIFT ************/
	
	/*********** SALE N SELECT GIFT: SECLECT GIFTS ************/
	
	function save_gifts_salenselectgift(){
		$sale_product_id = FSInput::get('sale_product_id',0,'int');
		if(!$sale_product_id)
			return;
		$arr = FSInput::get ( 'add_gifts', array (), 'array' );
		$str_prices_is = '';
		if (!count ( $arr )) 
			return;
		$arr = array_unique ( $arr );
		
		$str_prices_is = implode ( ',', $arr ) ;
		if($str_prices_is){
			$str_prices_is = ',' . $str_prices_is . ',';
		}
		$arr_prices = $this -> get_prices_by_ids($str_prices_is); 
		
		$this -> _remove(' price_id NOT IN (0'.$str_prices_is.'0) AND sale_product_id = '.$sale_product_id ,'fs_sales_products_gifts');
		$arr_saleproducts_exist = $this -> get_records('price_id IN (0'.$str_prices_is.'0) AND sale_product_id = '.$sale_product_id ,'fs_sales_products_gifts','*','','','price_id');
		
		$str_products_id = '';
		
		foreach($arr_prices as $item){
			$row = array();
//			$row['price'] = FSInput::get('price_value_'.$item -> id,0,'money');
			$row['price_old'] = $item -> price_old?$item -> price_old:$item -> price;
			$row['sale_product_id'] = $sale_product_id;
			$row['unit'] = $item -> unit;
			$row['price_id'] = $item -> id;
			$row['product_id'] = $item -> record_id;
			$str_products_id .= ','.$item -> record_id;
			
			if($arr_saleproducts_exist && array_key_exists($item -> id, $arr_saleproducts_exist)){	
				$this -> _update($row, 'fs_sales_products_gifts',' id = '.$arr_saleproducts_exist[$item -> id]->id);
			}else{
				$this -> _add($row, 'fs_sales_products_gifts');
			}
		}
		$str_products_id = $str_products_id?$str_products_id.',':'';
//		$row1 = array();
//		$row1['products_ids'] = $str_products_id;
//		$row1['prd_prices_ids'] = $str_prices_is;
//		$this -> _update($row1, 'fs_sales',' id = '.$sale_product_id);
		return true;
	}
	
	function ajax_get_gifts_salenselectgift__() {
		$category_id = FSInput::get ( 'category_id', 0, 'int' );
		$keyword = FSInput::get ( 'keyword' );
		$where = ' WHERE published = 1  ';
		if ($category_id) {
			$where .= ' AND (category_id_wrapper LIKE "%,' . $category_id . ',%"	) ';
		}
		$where .= " AND ( name LIKE '%" . $keyword . "%' OR alias LIKE '%" . $keyword . "%' )";
		
		$query_body = ' FROM fs_products AS a 
						
						
		' . $where;
		$ordering = " ORDER BY created_time DESC , id DESC ";
		$query = ' SELECT a.id,a.category_id,name,a.category_name,price, price_old,0 as price_id, 0 as unit ' . $query_body . $ordering . ' LIMIT 40 ';
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}	

	function ajax_get_gifts_salenselectgift() {
		$category_id = FSInput::get ( 'category_id', 0, 'int' );
		$keyword = FSInput::get ( 'keyword' );
		$where = ' WHERE published = 1  ';
		if ($category_id) {
			$where .= ' AND (category_id_wrapper LIKE "%,' . $category_id . ',%"	) ';
		}
		$where .= " AND ( name LIKE '%" . $keyword . "%' OR alias LIKE '%" . $keyword . "%' )";
		
		$query_body = ' FROM fs_products AS a 
						LEFT JOIN fs_products_prices AS b   ON a.id = b.record_id
						
		' . $where;
		$ordering = " ORDER BY created_time DESC , id DESC ";
		$query = ' SELECT a.id,a.category_id,name,a.category_name, b.id as price_id, b.unit as unit, b.price, b.price_old ' . $query_body . $ordering . ' LIMIT 40 ';
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}
	function update_gifts_salenselectgift($sale_id){
		if(!$sale_id)
			return;
		$arr = FSInput::get ( 'add_products', array (), 'array' );
		$str_prices_is = '';
		if (!count ( $arr )) 
			return;
		$arr = array_unique ( $arr );
		
		$str_prices_is = implode ( ',', $arr ) ;
		if($str_prices_is){
			$str_prices_is = ',' . $str_prices_is . ',';
		}
		
		$arr_prices = $this -> get_prices_by_ids($str_prices_is); 
		
		$this -> _remove(' price_id NOT IN (0'.$str_prices_is.'0) AND sale_id = '.$sale_id ,'fs_sales_products');
		$arr_saleproducts_exist = $this -> get_records('price_id IN (0'.$str_prices_is.'0) AND sale_id = '.$sale_id ,'fs_sales_products','*','','','price_id');
		
		$str_products_id = '';
		
		foreach($arr_prices as $item){
			$row = array();
//			$row['price'] = FSInput::get('price_value_'.$item -> id,0,'money');
			$row['price_old'] = $item -> price_old?$item -> price_old:$item -> price;
			$row['sale_id'] = $sale_id;
			$row['unit'] = $item -> unit;
			$row['price_id'] = $item -> id;
			$row['product_id'] = $item -> record_id;
			$str_products_id .= ','.$item -> record_id;
			
			if($arr_saleproducts_exist && array_key_exists($item -> id, $arr_saleproducts_exist)){	
				$this -> _update($row, 'fs_sales_products',' id = '.$arr_saleproducts_exist[$item -> id]->id);
			}else{
				$this -> _add($row, 'fs_sales_products');
			}
		}
		$str_products_id = $str_products_id?$str_products_id.',':'';
		$row1 = array();
		$row1['products_ids'] = $str_products_id;
		$row1['prd_prices_ids'] = $str_prices_is;
		$this -> _update($row1, 'fs_sales',' id = '.$sale_id);
		return true;
	}
	/*********** end  SALE N SELECT GIFT ************/
	
	/*********** TYPE 5: Combo giảm giá ************/
	function ajax_get_products_combopricedown() {
		$category_id = FSInput::get ( 'category_id', 0, 'int' );
		$keyword = FSInput::get ( 'keyword' );
		$where = ' WHERE published = 1 ';
		if ($category_id) {
			$where .= ' AND (category_id_wrapper LIKE "%,' . $category_id . ',%"	) ';
		}
		$where .= " AND ( name LIKE '%" . $keyword . "%' OR alias LIKE '%" . $keyword . "%' )";
		
		$query_body = ' FROM fs_products AS a 
						
		' . $where;
		$ordering = " ORDER BY created_time DESC , id DESC ";
		$query = ' SELECT a.id,a.category_id,name,a.category_name, a.price, a.price_old ' . $query_body . $ordering . ' LIMIT 40 ';
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}
	function update_products_combopricedown($sale_id){

		if(!$sale_id)
			return;
		$arr = FSInput::get ( 'add_products', array (), 'array' );

		
		$str_prices_is = '';
		if (!count ( $arr )) 
			return;
		$arr = array_unique ( $arr );
		
		$str_prices_is = implode ( ',', $arr ) ;
		if($str_prices_is){
			$str_prices_is = ',' . $str_prices_is . ',';
		}
		
//		$arr_prices = $this -> get_prices_by_ids($str_prices_is); 
		// $arr_products = $this -> get_products_by_ids($str_prices_is); 

		$arr_prices = $this -> get_prices_by_ids($str_prices_is); 

		// print_r($arr_prices);die;
		
		$this -> _remove(' product_id NOT IN (0'.$str_prices_is.'0) AND sale_id = '.$sale_id ,'fs_sales_products');
		$arr_saleproducts_exist = $this -> get_records('product_id IN (0'.$str_prices_is.'0) AND sale_id = '.$sale_id ,'fs_sales_products','*','','','product_id');
		
		$str_products_id = '';
		$combo_products_prices = '';
		
		foreach($arr_prices as $item){
			$row = array();
			$row['price'] = FSInput::get('price_value_'.$item -> id,0,'money');
			$row['price_old'] = $item -> price_old?$item -> price_old:$item -> price;
			$row['sale_id'] = $sale_id;
			$row['unit'] = $item -> unit;
			$row['type'] = 5;
			$row['price_id'] = $item -> id;
			$row['product_id'] = $item -> record_id;
			$str_products_id .= ','.$item -> record_id;
			
			if($arr_saleproducts_exist && array_key_exists($item -> id, $arr_saleproducts_exist)){	
				$this -> _update($row, 'fs_sales_products',' id = '.$arr_saleproducts_exist[$item -> id]-> id);
			}else{
				$this -> _add($row, 'fs_sales_products');
			}
		}
		$str_products_id = $str_products_id?$str_products_id.',':'';
		$row1 = array();
		$row1['products_ids'] = $str_products_id;
		$row1['prd_prices_ids'] = $str_prices_is;

		$this -> _update($row1, 'fs_sales',' id = '.$sale_id);
		return true;
	}
	/*********** end TYPE 5: Combo giảm giá ************/
	
	/*********** Type 6: Combo select gift ************/
	function ajax_get_products_comboselectgift() {
		$category_id = FSInput::get ( 'category_id', 0, 'int' );
		$keyword = FSInput::get ( 'keyword' );
		$where = ' WHERE published = 1 AND is_combo = 1 ';
		if ($category_id) {
			$where .= ' AND (category_id_wrapper LIKE "%,' . $category_id . ',%"	) ';
		}
		$where .= " AND ( name LIKE '%" . $keyword . "%' OR alias LIKE '%" . $keyword . "%' )";
		
		$query_body = ' FROM fs_products AS a 
						
		' . $where;
		$ordering = " ORDER BY created_time DESC , id DESC ";
		$query = ' SELECT a.id,a.category_id,name,a.category_name, a.price, a.price_old ' . $query_body . $ordering . ' LIMIT 40 ';
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}
	function update_products_comboselectgift($sale_id){
		if(!$sale_id)
			return;
		$arr = FSInput::get ( 'add_products', array (), 'array' );
		
		$str_prices_is = '';
		if (!count ( $arr )) 
			return;
		$arr = array_unique (array_filter( $arr ));
		if(!$arr){
			return;
		}
		

		$str_prices_is = ',' . implode ( ',', $arr ) . ',';
		
//		$arr_prices = $this -> get_prices_by_ids($str_prices_is); 
		$arr_products = $this -> get_products_by_ids($str_prices_is); 
		
		$this -> _remove(' product_id NOT IN (0'.$str_prices_is.'0) AND sale_id = '.$sale_id ,'fs_sales_products');
		$arr_saleproducts_exist = $this -> get_records('product_id IN (0'.$str_prices_is.'0) AND sale_id = '.$sale_id ,'fs_sales_products','*','','','product_id');
		
		$str_products_id = '';
		$combo_products_prices = '';
		
		foreach($arr_products as $item){
			$row = array();
			$row['price_old'] = $item -> price_old?$item -> price_old:$item -> price;
			$row['price'] = $item -> price_old?$item -> price_old:$item -> price;
			$row['sale_id'] = $sale_id;
//			$row['unit'] = $item -> unit;
			$row['price_id'] = 0;
			$row['product_id'] = $item -> id;
			$str_products_id .= ','.$item -> combo_products_id;
			$combo_products_prices .= ','.$item -> combo_products_prices;
			$row['product_in_combo'] = $item -> combo_products_id ;
			
			if($arr_saleproducts_exist && array_key_exists($item -> id, $arr_saleproducts_exist)){	
				$this -> _update($row, 'fs_sales_products',' id = '.$arr_saleproducts_exist[$item -> id]->id);
			}else{
				$this -> _add($row, 'fs_sales_products');
			}
		}
		$str_products_id = $str_products_id?$str_products_id.',':'';
		$row1 = array();
		$row1['products_ids'] = $str_products_id;
		$row1['prd_prices_ids'] = $combo_products_prices;
		$this -> _update($row1, 'fs_sales',' id = '.$sale_id);
		return true;
	}
	/*********** end Type 6: Combo select gift ************/
	
	/*********** Type 7: total_has_gift ************/
	function ajax_get_products_totalhasgift() {
		$category_id = FSInput::get ( 'category_id', 0, 'int' );
		$keyword = FSInput::get ( 'keyword' );
		$where = ' WHERE published = 1 AND is_combo <> 1 ';
		if ($category_id) {
			$where .= ' AND (category_id_wrapper LIKE "%,' . $category_id . ',%"	) ';
		}
		$where .= " AND ( name LIKE '%" . $keyword . "%' OR alias LIKE '%" . $keyword . "%' )";
		
		$query_body = ' FROM fs_products AS a 
						INNER JOIN fs_products_prices AS b   ON a.id = b.record_id
						
		' . $where;
		$ordering = " ORDER BY created_time DESC , id DESC ";
		$query = ' SELECT a.id,a.category_id,name,a.category_name, b.id as price_id, b.unit as unit, b.price, b.price_old ' . $query_body . $ordering . ' LIMIT 40 ';
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}
	function update_products_totalhasgift($sale_id){
		if(!$sale_id)
			return;
		$arr = FSInput::get ( 'add_products', array (), 'array' );
		
		$str_prices_is = '';
		if (!count ( $arr )) 
			return;
		$arr = array_unique ( $arr );
		$str_prices_is = implode ( ',', $arr ) ;
		if($str_prices_is){
			$str_prices_is = ',' . $str_prices_is . ',';
		}
		$arr_prices = $this -> get_prices_by_ids($str_prices_is); 

		
		$this -> _remove(' price_id NOT IN (0'.$str_prices_is.'0) AND sale_id = '.$sale_id ,'fs_sales_products');
		$arr_saleproducts_exist = $this -> get_records('price_id IN (0'.$str_prices_is.'0) AND sale_id = '.$sale_id ,'fs_sales_products','*','','','price_id');
		
		$str_products_id = '';
		
		foreach($arr_prices as $item){
			$row = array();
//			$row['price'] = FSInput::get('price_value_'.$item -> id,0,'money');
			$row['price_old'] = $item -> price_old?$item -> price_old:$item -> price;
			$row['sale_id'] = $sale_id;
			$row['unit'] = $item -> unit;
			$row['price_id'] = $item -> id;
			$row['product_id'] = $item -> record_id;
			$str_products_id .= ','.$item -> record_id;
			
			if($arr_saleproducts_exist && array_key_exists($item -> id, $arr_saleproducts_exist)){	
				$this -> _update($row, 'fs_sales_products',' id = '.$arr_saleproducts_exist[$item -> id]->id);
			}else{
				$this -> _add($row, 'fs_sales_products');
			}
		}
		$str_products_id = $str_products_id?$str_products_id.',':'';
		$row1 = array();
		$row1['products_ids'] = $str_products_id;
		$row1['prd_prices_ids'] = $str_prices_is;
		$this -> _update($row1, 'fs_sales',' id = '.$sale_id);
		return true;
	}
	/*********** end Type 7: total_has_gift ************/
	
}
?>