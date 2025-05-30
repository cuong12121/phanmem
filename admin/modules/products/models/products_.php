<?php
class ProductsModelsProducts extends FSModels {
	var $limit;
	var $prefix;
	var $image_watermark;
	function __construct() {
		$this->limit = 20;
		$this->view = 'products';
		$this->type = 'products';
		$this->table_name = 'fs_products';
		$this->use_table_extend = 1;
		$this->table_category = 'fs_' . $this->type . '_categories';
		$this->table_types = 'fs_' . $this->type . '_types';
		//synchronize
		//			$this -> array_synchronize = array('fs_estores_products'=>array('id'=>'product_id','published'=>'record_published','alias'=>'product_alias','name'=>'product_name','category_name'=>'category_name','category_alias'=>'category_alias','category_alias_wrapper'=>'category_id_wrapper','category_id'=>'category_id','manufactory_country_id'=>'manufactory_country_id','manufactory_country_name'=>'manufactory_country_name','manufactory_country_flag'=>'manufactory_country_flag','manufactory_id'=>'manufactory_id','manufactory_alias'=>'manufactory_alias','manufactory_name'=>'manufactory_name'));
		// calculate filters:
		$this->calculate_filters = 1;
		// config for save
		$cyear = date ( 'Y' );
		$cmonth = date ( 'm' );
		$cday = date ( 'd' );
		$this->img_folder = 'images/' . $this->type . '/' . $cyear . '/' . $cmonth . '/' . $cday;
		$this -> arr_img_paths_other_plus = array(array('large',778,390,'resized_not_crop'), array ('small', 120, 70, 'cut_image' ));
		$this -> arr_img_paths_hot =array ('resized', 400, 400, 'resized_not_crop' ));
		$this->check_alias = 1;
		$this->field_img = 'image';
		$this->field_reset_when_duplicate = array('comments_total');
		$this->image_watermark = array('path_image_watermark'=>'images/mask/default.png','position'=>0); //Đóng dấu nên ảnh
		parent::__construct ();
		$this->load_params ();
	}
	
	function load_params() {
		$module_params = $this->get_params ( $this->module, 'product' );
		
		if ($module_params) { // params from fs_config_modules
			$this->module_params = $module_params;
			$arr_img_paths = array ();
			$arr_img_paths_other = array ();
			
			FSFactory::include_class ( 'parameters' );
			$current_parameters = new Parameters ( $module_params );
			// large size
			$image_large_size = $current_parameters->getParams ( 'image_large_size' );
			$image_large_method = $current_parameters->getParams ( 'image_large_method' );
			if (! $image_large_method)
				$image_large_method = 'resize_image'; // giữ nguyên dạng ảnh, thêm khoảng trắng
			$image_large_width = $this->get_dimension ( $image_large_size, 'width' );
			$image_large_height = $this->get_dimension ( $image_large_size, 'height' );
			if (! $image_large_width && ! $image_large_height) {
				$image_large_width = 374;
				$image_large_height = 380;
			}
			$arr_img_paths [] = array ('large', $image_large_width, $image_large_height, $image_large_method );
			$arr_img_paths_other [] = array ('large', $image_large_width, $image_large_height, $image_large_method );
			
			// resized: ảnh đại diện trong trang danh sách
			$image_resized_size = $current_parameters->getParams ( 'image_resized_size' );
			$image_resized_method = $current_parameters->getParams ( 'image_resized_method' );
			if (! $image_resized_method)
				$image_resized_method = 'resize_image'; // giữ nguyên dạng ảnh, thêm khoảng trắng
			

			$image_resized_width = $this->get_dimension ( $image_resized_size, 'width' );
			$image_resized_height = $this->get_dimension ( $image_resized_size, 'height' );
			if (! $image_resized_width && ! $image_resized_height) {
				$image_resized_width = 204;
				$image_resized_height = 190;
			}
			$arr_img_paths [] = array ('resized', $image_resized_width, $image_resized_height, $image_resized_method );
			
			// small: ảnh nhỏ làm slideshow
			$image_small_size = $current_parameters->getParams ( 'image_small_size' );
			$image_small_method = $current_parameters->getParams ( 'image_small_method' );
			if (! $image_small_method)
				$image_small_method = 'resize_image'; // giữ nguyên dạng ảnh, thêm khoảng trắng
			$image_small_width = $this->get_dimension ( $image_small_size, 'width' );
			$image_small_height = $this->get_dimension ( $image_small_size, 'height' );
			if ($image_small_width || $image_small_height) {
				$arr_img_paths [] = array ('small', $image_small_width, $image_small_height, $image_small_method );
				$arr_img_paths_other [] = array ('small', $image_small_width, $image_small_height, $image_small_method );
			}
			$this->arr_img_paths = $arr_img_paths;
			$this->arr_img_paths_other = $arr_img_paths_other;
		
		} else {
			// default
			$this->arr_img_paths = array (array ('large', 374, 380, 'resize_image' ), array ('resized', 204, 190, 'resize_image' ), array ('small', 47, 35, 'resize_image' ) );
			$this->arr_img_paths_other = array (array ('large', 374, 380, 'resize_image' ), array ('small', 47, 35, 'resize_image' ) );
		}
	}
	/*
		 * Trả lại kích thước chiều dài hoặc chiều rộng
		 */
	function get_dimension($size, $dimension = 'width') {
		if (! $size)
			return 0;
		$array = explode ( 'x', $size );
		if ($dimension == 'width') {
			return (intval ( @$array [0] ));
		} else {
			return (intval ( @$array [1] ));
		}
	}
	
	/*
		 * Lấy parameter từ cấu hình vào.............................................................................
		 */
	function get_params($module, $view, $task = '') {
		
		$where = '';
		$where .= 'module = "' . $module . '" AND view = "' . $view . '"';
		if ($task == 'display' || ! $task) {
			$where .= ' AND ( task = "display" OR task = "" OR task IS NULL)';
		} else {
			$where .= ' AND task = "' . $task . '" ';
		}
		
		$fstable = FSFactory::getClass ( 'fstable' );
		global $db;
		$sql = " SELECT params  FROM " . $fstable->_ ( 'fs_config_modules' ) . "
				WHERE $where ";
		$db->query ( $sql );
		$rs = $db->getResult ();
		return $rs;
	
		//			FSFactory::include_class('parameters');
	//			$config_name = 'products_';
	//			$data_params = $this -> get_records('');
	//			if($data -> task)
	//				$config_name  = '_'.$data -> task;
	//			$config = isset($config_module[$config_name])?$config_module[$config_name]:array()  ;	
	//			
	//			$current_parameters = new Parameters($data->params);
	//			$params = isset($config['params'])?$config['params']: null;
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
		if (isset ( $_SESSION [$this->prefix . 'filter0'] )) {
			$filter = $_SESSION [$this->prefix . 'filter0'];
			if ($filter) {
				$where .= ' AND a.category_id_wrapper like   "%,' . $filter . '%," ';
			}
		}
		// lọc loại sản phẩm
		if (isset ( $_SESSION [$this->prefix . 'filter1'] )) {
			$filter = $_SESSION [$this->prefix . 'filter1'];
			if ($filter) {
				$where .= ' AND a.types like   "%,' . $filter . '%," ';
			}
		}
		
		// SP nổi bật
		if (isset ( $_SESSION [$this->prefix . 'filter2'] )) {
			$filter = $_SESSION [$this->prefix . 'filter2'];
			if ($filter) {
				if($filter == 1)
					$where .= ' AND a.is_hot = 1';
				else 
					$where .= ' AND a.is_hot = 0';
			}
		}
		// lọc loại sản phẩm
		if (isset ( $_SESSION [$this->prefix . 'filter3'] )) {
			$filter = $_SESSION [$this->prefix . 'filter3'];
			if ($filter) {
				$where .= ' AND manufactory  =' . $filter . '';
			}
		}
		if (! $ordering)
			$ordering .= " ORDER BY created_time DESC , id DESC ";
		
		if (isset ( $_SESSION [$this->prefix . 'keysearch'] )) {
			if ($_SESSION [$this->prefix . 'keysearch']) {
				$keysearch = $_SESSION [$this->prefix . 'keysearch'];
				$where .= " AND ( a.name LIKE '%" . $keysearch . "%' OR a.alias LIKE '%" . $keysearch . "%' OR a.id = '".$keysearch."' )";
			}
		}
		
		$query = " SELECT a.*
						  FROM 
						  	" . $this->table_name . " AS a
						  	WHERE 1=1 " . $where . $ordering . " ";
		return $query;
	}
	
	/*
		 * select in category
		 */
	function get_categories_tree() {
		global $db;
		$sql = " SELECT id, name, parent_id AS parent_id 
				FROM " . $this->table_category;
		$db->query ( $sql );
		$categories = $db->getObjectList ();
		
		$tree = FSFactory::getClass ( 'tree', 'tree/' );
		$rs = $tree->indentRows ( $categories, 1 );
		return $rs;
	}
	/*
		 * select in type
		 */
	function get_type() {
		global $db;
		$query = " SELECT id, name 
				FROM " . $this->table_types;
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}
	/*
		 * select in type
		 */
	function get_manufactories() {
		global $db;
		$query = " SELECT id, name 
				FROM fs_manufactories ";
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}
	

	function save() {
		$name = FSInput::get ( 'name' );
		if (! $name) {
			Errors::_ ( 'You must entere name' );
			return false;
		}
		$id = FSInput::get ( 'id', 0, 'int' );
		
		$alias = FSInput::get ( 'alias' );
		$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
		
		if (! $alias) {
			$row ['alias'] = $fsstring->stringStandart ( $name );
		} else {
			$row ['alias'] = $fsstring->stringStandart ( $alias );
		}
		$is_hotdeal_show_home = FSInput::get('is_hotdeal_show_home');
		if(isset($is_hotdeal_show_home ) && $is_hotdeal_show_home != 0)
		{
				$rs = $this -> _update_column('fs_products', 'is_hotdeal_show_home','0');
		}
		// category and category_id_wrapper
		$category_id = FSInput::get ( 'category_id', 0, 'int' );
		if (! $category_id){
			Errors::_ ( 'You must select category' );
			return false;	
		}
			
		$cat = $this->get_record_by_id ( $category_id, $this->table_category );
		$row ['category_id_wrapper'] = $cat->list_parents;
		$row ['category_root_alias'] = $cat->root_alias;
		$row ['category_alias_wrapper'] = $cat->alias_wrapper;
		$row ['category_name'] = $cat->name;
		$row ['category_alias'] = $cat->alias;
		$row ['category_published'] = $cat->published;
		$row ['show_in_homepage'] = $cat->show_in_homepage;
		$row ['tablename'] = $cat->tablename;
		
		$is_hotdeal = FSInput::get('is_hotdeal');
		//price
		$h_price = FSInput::get ( 'h_price');
		$row['h_price'] = $this -> standart_money($h_price, 0);
		$date_start = FSInput::get('date_start');
		$published_hour_start = FSInput::get('published_hour_start',date('H:i'));
		$date_end = FSInput::get('date_end');
		$published_hour_end = FSInput::get('published_hour_end',date('H:i'));
		if($date_start){
			$row['date_start'] = date('Y-m-d H:i:s',strtotime($published_hour_start. $date_start));
		}
		if($date_end){
			$row['date_end'] = date('Y-m-d H:i:s',strtotime($published_hour_end. $date_end));
		}
		if($is_hotdeal){
			if( date('Y-m-d H:i:s') > $row['date_end']){
				Errors::_ ( 'Thời gian khuyến mại đã quá hạn','alert' );
				
			}
			if($row['date_start']  > $row['date_end']){
				Errors::_ ( 'Thời gian phải nhỏ hơn thời gian kết thúc','alert' );			
			}
		}
		
		// ionevn
		$row['is_accessories'] = $cat -> is_accessories;
		$row['is_service'] = $cat -> is_service;
		$manufactory_id = FSInput::get ( 'manufactory' );
		if ($manufactory_id) {
			$manufactory = $this->get_record_by_id ( $manufactory_id, 'fs_manufactories' );
			$row ['manufactory'] = $manufactory_id;
			$row ['manufactory_alias'] = $manufactory->alias;
			$row ['manufactory_name'] = $manufactory->name;
			$row ['manufactory_image'] = $manufactory->image;
			
		}
		
		//price
		$price_old = FSInput::get ( 'price_old');
		$price_old= $this -> standart_money($price_old, 0);
		$discount = FSInput::get ( 'discount');
		$discount= $this -> standart_money($discount, 0);
		$discount_unit = FSInput::get ( 'discount_unit', 'price' );
		if ($discount_unit == 'percent') {
			if ($discount > 100 || $discount < 0) {
				$row ['price_old'] = $price_old;
				$row ['price'] = $price_old;
				$row ['discount'] = 0;
				
			} else {
				$row ['price_old'] = $price_old;
				$row ['discount'] = $discount;
				$row ['price'] = $price_old * (100 - $discount) / 100;			
			}
		
		} else {
			if ($discount > $price_old || $discount < 0) {
				$row ['price_old'] = $price_old;
				$row ['price'] = $price_old;
				$row ['discount'] = 0;
			} else {
				$row ['price_old'] = $price_old;
				$row ['discount'] = $discount;
				$row ['price'] = $price_old - $discount;
			}
		}
		// image
			// $image_name = $_FILES["image_video"]["name"];
			// if($image_name){
			// 	$image = $this->upload_image('image_video','_'.time(),2000000,$this -> arr_img_paths);
			// 	if($image){
			// 		$row['image_video'] = $image;
			// 	}
			// }
		// image
			$image_hot_name = $_FILES["image_hot"]["name"];
			if($image_hot_name){
				$image_hot = $this->upload_image('image_hot','_'.time(),2000000,$this -> arr_img_paths_hot);
				if($image_hot){
					$row['image_hot'] = $image_hot;
				}
			}

			echo $row['image_hot'];die;

	             
		
					
		$types = FSInput::get ( 'types', array (), 'array' );
		$str_types = implode ( ',', $types );
		if ($str_types) {
			$str_types = ',' . $str_types . ',';
		}
		$row ['types'] = $str_types;
		// remove color
		if (! $this->remove_color ( $id )) {
		}
		// edit color
		if (! $this->save_exist_color ( $id )) {
			//				return false;
		}
		// save color
		if (! $this->save_new_color ( $id )) {
		}
		
		// remove memory
		if (! $this->remove_memory ( $id )) {
		}	
		// edit color
		if (! $this->save_exist_memory ( $id )) {
			//				return false;
		}
		// save color
		if (! $this->save_new_memory ( $id )) {
		}


			// remove memory
		if (! $this->remove_warranty ( $id )) {
		}	
		// edit color
		if (! $this->save_exist_warranty ( $id )) {
			//				return false;
		}
		// save color
		if (! $this->save_new_warranty ( $id )) {
		}

		// remove memory
		if (! $this->remove_origin ( $id )) {
		}	
		// edit color
		if (! $this->save_exist_origin ( $id )) {
			//				return false;
		}
		// save color
		if (! $this->save_new_origin ( $id )) {
		}

		// remove memory
		if (! $this->remove_species ( $id )) {
		}	
		// edit color
		if (! $this->save_exist_species ( $id )) {
			//				return false;
		}
		// save color
		if (! $this->save_new_species ( $id )) {
		}


		// 	360
		$link_360 = $this -> upload_360($id);
		if($link_360){
			$row['link_360'] = $link_360;
		}
		
		// related products
		$record_relate = FSInput::get('products_record_related',array(),'array');
		$row['products_related'] ='';
		if(count($record_relate)){
			$record_relate = array_unique($record_relate);
			$row['products_related'] = ','.implode(',', $record_relate).',';	
		}	
		// related products
		$record_compatable = FSInput::get('products_record_compatable',array(),'array');
		$row['products_compatable'] ='';
		if(count($record_compatable)){
			$record_compatable = array_unique($record_compatable);
			$row['products_compatable'] = implode(',', $record_compatable);	
		}
	// related products
		$record_service = FSInput::get('products_record_service',array(),'array');
		$row['products_service'] ='';
		if(count($record_service)){
			$record_service = array_unique($record_service);
			$row['products_service'] = implode(',', $record_service);	
		}

		$record_news_relate = FSInput::get('news_record_related',array(),'array');
		$row['news_related'] ='';
		if(count($record_news_relate)){
			$record_news_relate = array_unique($record_news_relate);
			$row['news_related'] = ','.implode(',', $record_news_relate).',';	
		}	
		$id = parent::save ( $row );
		if (! $id) {
			Errors::setError ( 'Not save' );
			return false;
		}
		
		// 	update total product in fs_products_category
		//			$this -> update_total_products($cat->root_id);
		
		if($id){
			$this -> save_accessories_incentives($id);
		}
	
		$tablename = $cat->tablename;
		// save extension
//		if ($tablename) {
//			$ext_id = $this->save_extension ( $tablename, $id );
//			if (! $ext_id) {
//				Errors::setError ( 'C&#243; l&#7895;i khi l&#432;u ph&#7847;n m&#7903; r&#7897;ng' );
//			}
//		}
		return $id;
	}
	
	/*
		 * save into extension table
		 * (insert or update)
		 */
	function save_extension($tablename, $record_id) {
		if(!$tablename || $tablename == 'fs_products')
			return;
		
		$data = $this->get_record ( 'id = ' . $record_id, $this->table_name );
		global $db;
		// field default: cai nay can xem lai vi hien dang ko su dung. Can phai su dung de luoc bot cac  truong thua
		$field_default = $this->get_records ( ' type = "' . $this->type . '"  ', 'fs_tables' );
		if (! $record_id)
			return false;
		
		if (! $db->checkExistTable ( $tablename ))
			return false;
		$ext_id = FSInput::get ( 'ext_id' );
		
		// data same fs_TYPE
		$row ['record_id'] = $record_id;
		$fields_all_of_ext_table = $this->get_field_table ( $tablename, 1 );
		foreach ( $data as $field_name => $value ) {
			if ($field_name == 'id' || $field_name == 'tablename')
				continue;
			if (! isset ( $fields_all_of_ext_table [$field_name] ))
				continue;
			if($field_name == 'record_id')	
				continue;	
			$row [$field_name] = $value;
		}
		// main extension ==> add into summary field
		$summary_auto = '';
		// extention
		$fields_ext = $this->getExtendFields ( $tablename );
		global $db;
		if (count ( $fields_ext ) > 1) {
			for($i = 0; $i < count ( $fields_ext ); $i ++) {
				$fname = strtolower ( $fields_ext [$i]->field_name );
				if (! array_key_exists ( strtolower ( $fname ), $row )) {
					$ftype = $fields_ext [$i]->field_type;
					$display_name = $fields_ext [$i]->field_name_display;
					$f_is_main = $fields_ext [$i]->is_main;
					switch ($ftype) {
						case 'image' :
							$upload_area = $fname;
							if ($_FILES [$upload_area] ["name"]) {
								$fsFile = FSFactory::getClass ( 'FsFiles', '' );
								$path = str_replace ( '/', DS, $this->img_folder );
								$image = $fsFile->uploadImage ( $upload_area, $path, 2000000, '_ext' . time () );
								$row [$fname] = $image;
							}
							break;
						case 'text' :
							if ( get_magic_quotes_gpc() == 0 )
								$row [$fname] = htmlspecialchars_decode($_POST [$fname]);
							else 
								$row [$fname] = $db -> escape_string(htmlspecialchars_decode ( $_POST [$fname] ));
							// summary_auto
							if ($f_is_main && $row [$fname])
								$summary_auto .= '<span class="sum_item"><span class="sum_item_lb">' . $display_name . ': </span>' . $row [$fname] . '</span>';
							break;
						case 'foreign_multi' :
							$values = FSInput::get ( $fname, array (), 'array' );
							if (! count ( $values ))
								break;
							$str_values = implode ( ',', $values );
							$row [$fname] = count ( $values ) ? ',' . $str_values . ',' : '';
							
							// summary_auto
							if (! $f_is_main)
								break;
							$table_name = $fields_ext [$i]->foreign_tablename;
							// check exit extend_table
							if (! $db->checkExistTable ( $table_name ))
								break;
							$data_foreign = $this->get_records ( ' id IN (' . $str_values . ')', $table_name );
							if (! count ( $data_foreign ))
								break;
							$summary_auto .= '<span class="sum_item"><span class="sum_item_lb">' . $display_name . ': </span>';
							$s = 0;
							foreach ( $data_foreign as $item ) {
								if ($s > 0)
									$summary_auto .= ', ';
								$summary_auto .= $item->name;
								$s ++;
							}
							$summary_auto .= '</span>';
							break;
						case 'foreign_one' :
							$value = FSInput::get ( $fname );
							$row [$fname] = $value;
							if (!$value)
								break;
		// summary_auto
							if (! $f_is_main)
								break;
							$table_name = $fields_ext [$i]->foreign_tablename;
							// check exit extend_table
							if (! $db->checkExistTable ( $table_name ))
								break;
							$data_foreign = $this->get_record ( ' id =  ' . $value . '', $table_name );
							if (! $data_foreign)
								break;
							$summary_auto .= '<span class="sum_item"><span class="sum_item_lb">' . $display_name . ': </span>' . $data_foreign->name;
							$summary_auto .= '</span>';
							break;
						case 'datetime' :
							$row [$fname] = date ( 'Y-m-d H:i:s', strtotime ( FSInput::get ( $fname ) ) );
							if ($f_is_main && $row [$fname])
								$summary_auto .= '<span class="sum_item"><span class="sum_item_lb">' . $display_name . ': </span>' . $row [$fname] . '</span>';
							break;
						default :
							if ( get_magic_quotes_gpc() == 0 )
								$row [$fname] = htmlspecialchars_decode(FSInput::get ( $fname ));
							else 
								$row [$fname] =  htmlspecialchars_decode(FSInput::get ( $fname ));
								
							if ($f_is_main && $row [$fname])
								$summary_auto .= '<span class="sum_item"><span class="sum_item_lb">' . $display_name . ': </span>' . $row [$fname] . '</span>';
							break;
					
					}
				}
			}
		}
		$row ['summary_auto'] = $summary_auto;
		
		//update summary_auto into table fs_TYPE
		$row2 ['summary_auto'] = $summary_auto;
//		echo $ext_id;
//		print_r($row);
//		echo $tablename;
//		die;
		$this->_update ( $row2, $this->table_name, ' id =  ' . $record_id );
		if ($ext_id) {
			$rs = $this->_update ( $row, $tablename, ' id =  ' . $ext_id , 1);
		} else {
			return $this->_add ( $row, $tablename );
		}
		return;
	}
	function save_accessories_incentives($product_id){
			if(!$product_id)
				return;
			global $db;
			$query = ' SELECT id,product_incenty_id,product_id 
						FROM fs_products_incentives
						WHERE product_id =  '.$product_id ;
			$db->query($query);
			$list = $db->getObjectList();
			if(count($list)){
				foreach($list as $item){
					$product_incenty_id = $item -> product_incenty_id;
					$price_new = FSInput::get('price_new_'.$product_incenty_id);
					$price_new_begin = FSInput::get('price_new_'.$product_incenty_id."_begin");
					
					if($price_new != $price_new_begin){
						$sql = ' UPDATE  fs_products_incentives SET ';
			            $sql .=  ' `price_new` =  "'.$price_new.'"';
			            $sql .=  ' WHERE product_id =    '.$product_id.' ';
			            $sql .=  ' AND product_incenty_id = '.$product_incenty_id.' ';
			            
			            // $db->query($sql);
			            $db->affected_rows($sql);
					}
				}
			}
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
				$discount = FSInput::get ( 'discount_' . $i );
				$discount_unit = FSInput::get ( 'discount_unit_' . $i );
				$price_old = FSInput::get ( 'price_old_' . $i );
				$price_old= $this -> standart_money($price_old, 0);
				if ($discount_unit == 'percent') {
						if ($discount > 100 || $discount < 0) {
							$row ['price_old'] = $price_old;
							$row ['price'] = $price_old;
							$row ['discount'] = 0;
							
						} else {
							$row ['price_old'] = $price_old;
							$row ['discount'] = $discount;
							$row ['price'] = $price_old * (100 - $discount) / 100;			
						}
					
					} else {
						if ($discount > $price_old || $discount < 0) {
							$row ['price_old'] = $price_old;
							$row ['price'] = $price_old;
							$row ['discount'] = 0;
						} else {
							$row ['price_old'] = $price_old;
							$row ['discount'] = $discount;
							$row ['price'] = $price_old - $discount;
						}
					}
				$id = FSInput::get ( 'id_' . $i, 0, 'int' );
				$rs = $this->_update ( $row, $this->table_name, '  id = ' . $id, 0 );
				if ($this->use_table_extend) {
					$record = $this->get_record ( 'id = ' . $id, $this->table_name );
					$table_extend = $record->tablename;
					// calculate filters:
					$arr_table_name_changed [] = $table_extend;
					global $db;
					if ($table_extend && $table_extend !='fs_products' && $db->checkExistTable ( $table_extend )) {
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
				
				if (! $rs){
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
		 * upload other images for product
		 * These images is not main images. 
		 */
	//		function update_total_product_from_category_ids($str_cat_id){
	//			if(!$str_cat_id)
	//				return;
	//			global $db;
	//			$query = " SELECT DISTINCT root_id
	//						FROM fs_products_categories 
	//						WHERE id IN ($str_cat_id) ";
	//			$db->query($query);
	//			$list = $db->getObjectList();
	//			if(!count($list))	
	//				return;
	//			foreach($list as $item){
	//				$this -> update_total_products($item -> root_id);
	//			}
	//		}
	
	/*
		 * get data from fs_product_images
		 */
	function get_product_images($product_id) {
		if (! $product_id)
			return;
		$query = " SELECT *
						FROM fs_products_images
						WHERE record_id = $product_id";
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}
	//		
	//		function  update_total_products($root_id){
	//			if(!$root_id)
	//				return;
	//			global $db;
	//			$query = " SELECT id
	//						FROM fs_products_categories 
	//						WHERE root_id = $root_id ";
	//			$sql = $db->query($query);
	//			$list = $db->getObjectList();
	//			if(!count($list))	
	//				return;
	//			foreach($list as $item){
	//				$cat_id = $item ->id;
	//				$query = " SELECT count(*)
	//						FROM fs_products 
	//						WHERE published = 1
	//						AND category_id_wrapper like '%,$cat_id,%' ";
	//				$db->query($query);
	//				$total = $db->getResult();
	//				$row['total_products']  = $total;
	//				$this -> _update($row, 'fs_products_categories',' WHERE id = '.$cat_id.' ');
	//			}
	//		}
	

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
	function get_product_models($manufactory_id) {
		if (! $manufactory_id)
			return;
		global $db;
		$query = " SELECT *
						FROM fs_products_models 
						WHERE manufactory_id  = $manufactory_id
						";
		$sql = $db->query ( $query );
		$rs = $db->getObjectList ();
		
		return $rs;
	}
	/*
		 * select all group in table fs_group
		 */
	function getRelatedCategories($tablename) {
		global $db;
		if ($tablename) {
			$query = " SELECT name,id,parent_id as parent_id,level 
							FROM fs_products_categories
							WHERE	tablename  = '$tablename'
							 ";
		} else {
			$pid = FSInput::get ( 'pid', 0 );
			if ($pid) {
				$query = " SELECT name,id ,parent_id as parent_id,level  
								FROM fs_products_categories
								WHERE tablename = (								
									SELECT tablename 
									FROM fs_products_categories 
										WHERE id = 
											(	SELECT category_id FROM fs_products
												WHERE id = $pid )
									)
									";
			} else {
				$query = " SELECT name,id,parent_id as parent_id,level 
							FROM fs_products_categories
							WHERE	tablename  = '' OR tablename IS NULL 
							 ";
			}
		}
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		$tree = FSFactory::getClass ( 'tree', 'tree' );
		$result_tree = $tree->indentRows2 ( $result, 3 );
		if (count ( $result_tree ))
			$result = $result_tree;
		else {
			foreach ( $result as $item ) {
				$item->treename = $item->name;
			}
		}
		return $result;
	}
	
	function getExtendFields($tablename) {
		global $db;
		if ($tablename == 'fs_products' || $tablename == '')
			return;
		
		$exist_table = $db->checkExistTable ( $tablename );
		if (! $exist_table) {
			Errors::setError ( FSText::_ ( 'Table' ) . ' ' . $tablename . FSText::_ ( ' is not exist' ) );
			return;
		}
		
		$cid = FSInput::get ( 'cid' );
		$query = " SELECT * 
						FROM fs_products_tables
						WHERE table_name =  '$tablename' 
						AND field_name <> 'id' 
						ORDER BY ordering ASC ";
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		
		return $result;
	}
	/*
		 * select data FROM table extension 
		 */
	function getProductExt($tablename, $id = 0) {
		if (! $id)
			return;
		global $db;
		if ($tablename == 'fs_products')
			return;
		
		// check exist table	
		if (!$tablename || $tablename == 'fs_products' || !$db->checkExistTable ( $tablename ))
			return;
		
		$query = " SELECT *
						  FROM $tablename
						  WHERE record_id = $id ";
		
		$sql = $db->query ( $query );
		$result = $db->getObject ();
		
		return $result;
	}
	
	function getTablenameFromCat() {
		$cid = FSInput::get ( 'cid' );
		$query = " SELECT tablename
						  FROM fs_products_categories
						  WHERE id = $cid ";
		
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getResult ();
		return $result;
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
	
	/*
		 * get alias of parent_root
		 */
	function get_alias_parent_root($cid) {
		// get rootid
		$rootid = $cid;
		while ( $cid ) {
			$cid = $this->get_parent_id ( $cid );
			if ($cid) {
				$rootid = $cid;
			}
		}
		global $db;
		// query get alias
		$query = " SELECT alias
						FROM fs_products_categories 
						WHERE id = $rootid ";
		$sql = $db->query ( $query );
		$root_alias = $db->getResult ();
		return $root_alias;
	}
	
	/*
		 * get Id of parent
		 */
	function get_parent_id($categoryid) {
		global $db;
		$query = " SELECT parent_id as parent_id
						FROM fs_products_categories 
						WHERE id = $categoryid ";
		$sql = $db->query ( $query );
		$alias = $db->getResult ();
		
		return $alias;
	}
	
	/*
		 * Lấy dữ liệu từ các bảng mở rộng
		 */
	function get_data_foreign($extend_fields) {
		if (! count ( $extend_fields ))
			return array ();
		$data_foreign = array ();
		foreach ( $extend_fields as $field ) {
			if ($field->field_type == 'foreign_one' || $field->field_type == 'foreign_multi') {
				$table_name = $field->foreign_tablename;
				$data_foreign [$field->field_name] = $this->get_records ( '', $table_name );
			}
		}
		return $data_foreign;
	}
	function get_data_for_export() {
		global $db;
		$query = $this->setQuery ();
		if (! $query)
			return array ();
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		
		return $result;
	}
	function get_products_by_ids($str_products_together){
			if(!$str_products_together)
				return;
			$query   = " SELECT name,id 
						FROM fs_products
						WHERE id IN (".$str_products_together.") ";
			global $db;
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;	
		}
	function get_products_incentives($product_id){
			
		$query   = " SELECT b.name,b.id, a.price_old,a.price_new,a.product_incenty_id 
					FROM fs_products_incentives AS a
					LEFT JOIN fs_products AS b ON a.product_incenty_id = b.id
					WHERE a.product_id = $product_id";
		global $db;
		$sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;	
	}
	function get_products_related($product_related){
		if(!$product_related)
				return;
		$query   = " SELECT id, name 
					FROM fs_products
					WHERE id IN (0".$product_related."0) 
					 ORDER BY POSITION(','+id+',' IN '0".$product_related."0')
					";
		global $db;
		$sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;
	}
	
	
	/*
		 *==================== AJAX RELATED PRODUCTS==============================
		 */
	
	function ajax_get_products_related(){
		$news_id = FSInput::get('product_id',0,'int');
		$category_id = FSInput::get('category_id',0,'int');
		$keyword = FSInput::get('keyword');
		$where = ' WHERE published = 1 ';
		if($category_id){
			$where .= ' AND (category_id_wrapper LIKE "%,'.$category_id.',%"	) ';
		}
		$where .= " AND ( name LIKE '%".$keyword."%' OR alias LIKE '%".$keyword."%' )";
		
		$query_body = ' FROM fs_products '.$where;
		$ordering = " ORDER BY created_time DESC , id DESC ";
		$query = ' SELECT id,category_id,name,category_name '.$query_body.$ordering.' LIMIT 40 ';
		global $db;
		$sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;
	}
	/*
	 *====================AJAX RELATED PRODUCTS end.==============================
	 */
	 /*
		 *==================== AJAX compatable PRODUCTS==============================
		 */
	function get_products_compatable($product_compatable){
		if(!$product_compatable)
				return;
		$query   = " SELECT id, name 
					FROM fs_products
					WHERE id IN (".$product_compatable.") 
					 ORDER BY POSITION(','+id+',' IN '".$product_compatable."')
					";
		global $db;
		$sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;
	}
	function ajax_get_products_compatable(){
		$news_id = FSInput::get('product_id',0,'int');
		$category_id = FSInput::get('category_id',0,'int');
		$keyword = FSInput::get('keyword');
		$where = ' WHERE published = 1 ';
		if($category_id){
			$where .= ' AND (category_id_wrapper LIKE "%,'.$category_id.',%"	) ';
		}
		$where .= " AND ( name LIKE '%".$keyword."%' OR alias LIKE '%".$keyword."%' )";
		
		$query_body = ' FROM fs_products '.$where;
		$ordering = " ORDER BY created_time DESC , id DESC ";
		$query = ' SELECT id,category_id,name,category_name '.$query_body.$ordering.' LIMIT 40 ';
		global $db;
		$sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;
	}
	/*
	 *====================AJAX compatable PRODUCTS end.==============================
	 */

	/*
		 *==================== AJAX service PRODUCTS==============================
		 */
	function get_products_service($product_service){
		if(!$product_service)
				return;
		$query   = " SELECT id, name 
					FROM fs_products
					WHERE id IN (".$product_service.") 
					 ORDER BY POSITION(','+id+',' IN '".$product_service."')
					";
		global $db;
		$sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;
	}
	function ajax_get_products_service(){
		$news_id = FSInput::get('product_id',0,'int');
		$category_id = FSInput::get('category_id',0,'int');
		$keyword = FSInput::get('keyword');
		$where = ' WHERE published = 1 ';
		if($category_id){
			$where .= ' AND (category_id_wrapper LIKE "%,'.$category_id.',%"	) ';
		}
		$where .= " AND ( name LIKE '%".$keyword."%' OR alias LIKE '%".$keyword."%' )";
		
		$query_body = ' FROM fs_products '.$where;
		$ordering = " ORDER BY created_time DESC , id DESC ";
		$query = ' SELECT id,category_id,name,category_name '.$query_body.$ordering.' LIMIT 40 ';
		global $db;
		$sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;
	}
	/*
	 *====================AJAX service PRODUCTS end.==============================
	 */
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
	/*
	 *====================AJAX RELATED NEWS end.==============================
	 */

	
	// Color 
	function get_color($prd_id){
		return $this -> get_records('prd_id = '.$prd_id,'fs_products_color');
	}

	function save_exist_color($record_id) {
		
		$rs = 0;	
		global $db;
		// Thay doi du lieu da nhap 
		$other_color_exit= FSInput::get('other_color_exit',array(),'array');	
		foreach ($other_color_exit as $item){
			$id_exist = FSInput::get ( 'id_exist_' . $item );
			$row ['record_id'] = $record_id;
			$color = $this->get_record_by_id ( $item, 'fs_products_colors' );
			$row ['color_id'] = $item;
			$row ['color_code'] =$color->code;
			$row ['color_name'] =$color->name;
			$row ['price'] = FSInput::get ( 'color_price_exist_' . $item );
			$row ['image'] = FSInput::get ( 'name_price_exist_' . $item );
			$u = $this->_update ( $row, 'fs_products_price', ' id=' . $id_exist );
			if ($u)
				$rs ++;
			
		}
		return $rs;
	
		// END EXIST FIELD
	}
	function save_new_color($record_id) {
		if (! $record_id)
			return true;
		$other_color = FSInput::get('other_color',array(),'array');	
		global $db;
		foreach($other_color as $item){
			
			$row = array ();
			$row ['record_id'] = $record_id;
			$color = $this->get_record_by_id ( $item, 'fs_products_colors' );
			$row ['color_id'] = $item;
			$row ['color_code'] =$color->code;
			$row ['color_name'] =$color->name;
			$row ['sl_hn'] = FSInput::get ( 'new_color_slhn_' . $item );
			$row ['sl_hcm'] = FSInput::get ( 'new_color_slhcm_' . $item );
			$row ['sl_dn'] = FSInput::get ( 'new_color_sldn_' . $item );
			$row ['price'] = FSInput::get ( 'new_color_price_' . $item );
			$upload_area = "other_image_" . $item;
			if ($_FILES [$upload_area] ["name"]) {
				$image = $this->upload_image ( $upload_area, '_' . time (), 2000000, $this->arr_img_paths_other );
				$row ['image'] = $image;
			}
			$rs = $this->_add ( $row, 'fs_products_price', 0 );
		}
		return true;
	}	
	function remove_color($record_id) {
		
		$rs = 0;	
		global $db;
		
		$other_color_exit= FSInput::get('other_color_exit',array(),'array');	
		$str_other_images = implode ( ',', $other_color_exit );
			$whewe ='';
		if ($str_other_images) {
			$whewe .=' AND color_id NOT IN ('.$str_other_images.')';
			
			
		}
		$query = " SELECT image 
						FROM fs_products_price
						WHERE record_id = $record_id
						$whewe
						";
						
		$sql = $db->query ( $query );
		$images_need_remove = $db->getObjectList ();
		$fsFile = FSFactory::getClass ( 'FsFiles', '' );
			$arr_img_paths = $this->arr_img_paths_other;
			foreach ( $images_need_remove as $item ) {
				
				if ($item->image) {
					$path = PATH_BASE.$item->image;
					$path = str_replace ( '/', DS, $path );
					$fsFile->remove_file_by_path ( $path );
					if (count ( $arr_img_paths )) {
						foreach ( $arr_img_paths as $item ) {
							$path_resize = str_replace ( DS . 'original' . DS, DS . $item [0] . DS, $path );
							$fsFile->remove_file_by_path ( $path_resize );
						}
					}
				}
			}
		// remove in database
		$sql = " DELETE FROM fs_products_price
					WHERE record_id = ".$record_id."".
						$whewe;
		$db->query ( $sql );
		$rows = $db->affected_rows ();
		return $rows;
			
		
	
		// END EXIST FIELD
	}
	/***********************************/
	function save_exist_memory($record_id) {
		
		$rs = 0;	
		global $db;
		// Thay doi du lieu da nhap 
		$other_memory_exit= FSInput::get('other_memory_exit',array(),'array');	
		foreach ($other_memory_exit as $item){
			$id_exist = FSInput::get ( 'id_memory_exist_' . $item );
			$row ['record_id'] = $record_id;
			$memory = $this->get_record_by_id ( $item, 'fs_memory' );
			$row ['memory_id'] = $item;
			$row ['memory_name'] =$memory->name;
			$row ['price'] = FSInput::get ( 'memory_price_exist_' . $item );
			
				$u = $this->_update ( $row, 'fs_memory_price', ' id=' . $id_exist );
				if ($u)
					$rs ++;
			
		}
		return $rs;
	
		// END EXIST FIELD
	}
	function save_new_memory($record_id) {
		if (! $record_id)
			return true;
		$other_memory = FSInput::get('other_memory',array(),'array');	
		global $db;
		foreach($other_memory as $item){
			
			$row = array ();
			$row ['record_id'] = $record_id;
			$memory = $this->get_record_by_id ( $item, 'fs_memory' );
			$row ['memory_id'] = $item;
			$row ['memory_name'] =$memory->name;
			$row ['price'] = FSInput::get ( 'new_memory_price_' . $item );
			$rs = $this->_add ( $row, 'fs_memory_price', 0 );
		}
		return true;
	}	
	function remove_memory($record_id) {
		
		$rs = 0;	
		global $db;
		
		$other_memory_exit= FSInput::get('other_memory_exit',array(),'array');	
		$str_other_memory = implode ( ',', $other_memory_exit );
			$whewe ='';
		if ($str_other_memory) {
			$whewe .=' AND memory_id NOT IN ('.$str_other_memory.')';
		}
	// remove in database
		$sql = " DELETE FROM fs_memory_price
					WHERE record_id = ".$record_id."".
						$whewe;
		$db->query ( $sql );
		$rows = $db->affected_rows ();
		return $rows;
			
		
	
		// END EXIST FIELD
	}
	function save_exist_origin($record_id) {
		
		$rs = 0;	
		global $db;
		// Thay doi du lieu da nhap 
		$other_origin_exit= FSInput::get('other_origin_exit',array(),'array');	
		foreach ($other_origin_exit as $item){
			$id_exist = FSInput::get ( 'id_origin_exist_' . $item );
			$row ['record_id'] = $record_id;
			$origin = $this->get_record_by_id ( $item, 'fs_origin' );
			$row ['origin_id'] = $item;
			$row ['origin_name'] =$origin->name;
			$row ['price'] = FSInput::get ( 'origin_price_exist_' . $item );
			
				$u = $this->_update ( $row, 'fs_origin_price', ' id=' . $id_exist );
				if ($u)
					$rs ++;
			
		}
		return $rs;
	
		// END EXIST FIELD
	}
	function save_new_origin($record_id) {
		if (! $record_id)
			return true;
		$other_origin = FSInput::get('other_origin',array(),'array');	
		global $db;
		foreach($other_origin as $item){
			
			$row = array ();
			$row ['record_id'] = $record_id;
			$origin = $this->get_record_by_id ( $item, 'fs_origin' );
			$row ['origin_id'] = $item;
			$row ['origin_name'] =$origin->name;
			$row ['price'] = FSInput::get ( 'new_origin_price_' . $item );
			$rs = $this->_add ( $row, 'fs_origin_price', 0 );
		}
		return true;
	}	
	function remove_origin($record_id) {
		
		$rs = 0;	
		global $db;
		
		$other_origin_exit= FSInput::get('other_origin_exit',array(),'array');	
		$str_other_origin = implode ( ',', $other_origin_exit );
			$whewe ='';
		if ($str_other_origin) {
			$whewe .=' AND origin_id NOT IN ('.$str_other_origin.')';
		}
	// remove in database
		$sql = " DELETE FROM fs_origin_price
					WHERE record_id = ".$record_id."".
						$whewe;
		$db->query ( $sql );
		$rows = $db->affected_rows ();
		return $rows;
			
		
	
		// END EXIST FIELD
	}

	function save_exist_species($record_id) {
		
		$rs = 0;	
		global $db;
		// Thay doi du lieu da nhap 
		$other_species_exit= FSInput::get('other_species_exit',array(),'array');	
		foreach ($other_species_exit as $item){
			$id_exist = FSInput::get ( 'id_species_exist_' . $item );
			$row ['record_id'] = $record_id;
			$species = $this->get_record_by_id ( $item, 'fs_species' );
			$row ['species_id'] = $item;
			$row ['species_name'] =$species->name;
			$row ['price'] = FSInput::get ( 'species_price_exist_' . $item );
			
				$u = $this->_update ( $row, 'fs_species_price', ' id=' . $id_exist );
				if ($u)
					$rs ++;
			
		}
		return $rs;
	
		// END EXIST FIELD
	}
	function save_new_species($record_id) {
		if (! $record_id)
			return true;
		$other_species = FSInput::get('other_species',array(),'array');	
		global $db;
		foreach($other_species as $item){
			
			$row = array ();
			$row ['record_id'] = $record_id;
			$species = $this->get_record_by_id ( $item, 'fs_species' );
			$row ['species_id'] = $item;
			$row ['species_name'] =$species->name;
			$row ['price'] = FSInput::get ( 'new_species_price_' . $item );
			$rs = $this->_add ( $row, 'fs_species_price', 0 );
		}
		return true;
	}	
	function remove_species($record_id) {
		
		$rs = 0;	
		global $db;
		
		$other_species_exit= FSInput::get('other_species_exit',array(),'array');	
		$str_other_species = implode ( ',', $other_species_exit );
			$whewe ='';
		if ($str_other_species) {
			$whewe .=' AND species_id NOT IN ('.$str_other_species.')';
		}
	// remove in database
		$sql = " DELETE FROM fs_species_price
					WHERE record_id = ".$record_id."".
						$whewe;
		$db->query ( $sql );
		$rows = $db->affected_rows ();
		return $rows;
			
		
	
		// END EXIST FIELD
	}
	
	/***********************************/
	function save_exist_warranty($record_id) {
		
		$rs = 0;	
		global $db;
		// Thay doi du lieu da nhap 
		$other_warranty_exit= FSInput::get('other_warranty_exit',array(),'array');	
		foreach ($other_warranty_exit as $item){
			$id_exist = FSInput::get ( 'id_warranty_exist_' . $item );
			$row ['record_id'] = $record_id;
			$warranty = $this->get_record_by_id ( $item, 'fs_warranty' );
			$row ['warranty_id'] = $item;
			$row ['warranty_name'] =$warranty->name;
			$row ['price'] = FSInput::get ( 'warranty_price_exist_' . $item );
			
				$u = $this->_update ( $row, 'fs_warranty_price', ' id=' . $id_exist );
				if ($u)
					$rs ++;
			
		}
		return $rs;
	
		// END EXIST FIELD
	}
	function save_new_warranty($record_id) {
		if (! $record_id)
			return true;
		$other_warranty = FSInput::get('other_warranty',array(),'array');	
		global $db;
		foreach($other_warranty as $item){
			
			$row = array ();
			$row ['record_id'] = $record_id;
			$warranty = $this->get_record_by_id ( $item, 'fs_warranty' );
			$row ['warranty_id'] = $item;
			$row ['warranty_name'] =$warranty->name;
			$row ['price'] = FSInput::get ( 'new_warranty_price_' . $item );
			$rs = $this->_add ( $row, 'fs_warranty_price', 0 );
		}
		return true;
	}	
	function remove_warranty($record_id) {
		
		$rs = 0;	
		global $db;
		
		$other_warranty_exit= FSInput::get('other_warranty_exit',array(),'array');	
		$str_other_warranty = implode ( ',', $other_warranty_exit );
			$whewe ='';
		if ($str_other_warranty) {
			$whewe .=' AND warranty_id NOT IN ('.$str_other_warranty.')';
		}
	// remove in database
		$sql = " DELETE FROM fs_warranty_price
					WHERE record_id = ".$record_id."".
						$whewe;
		$db->query ( $sql );
		$rows = $db->affected_rows ();
		return $rows;
			
		
	
		// END EXIST FIELD
	}
	
	/*
	 * get data from fs_product_images
	 */
	function get_product_images_plus($record_id) {
		if (! $record_id)
			return;
		$query = " SELECT image,id,content
						FROM fs_products_images_plus
						WHERE record_id = $record_id";
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}
	function remove_images_plus($record_id) {
		
		$rs = 0;	
		global $db;
		
		$other_image_plus= FSInput::get('other_image_plus',array(),'array');	
		$str_other_images_plus = implode ( ',', $other_image_plus );
		
		if ($str_other_images_plus) {
			$whewe .=' AND id  IN ('.$str_other_images_plus.')';
			
			
		
			$query = " SELECT image 
							FROM fs_" . $this->type . "_images_plus
							WHERE record_id = $record_id
							$whewe
							";
			$sql = $db->query ( $query );
			$images_need_remove = $db->getObjectList ();
			$fsFile = FSFactory::getClass ( 'FsFiles', '' );
				$arr_img_paths = $this->arr_img_paths_other_plus;
				foreach ( $images_need_remove as $item ) {
					
					if ($item->image) {
						$path = PATH_BASE.$item->image;
						$path = str_replace ( '/', DS, $path );
						$fsFile->remove_file_by_path ( $path );
						if (count ( $arr_img_paths )) {
							foreach ( $arr_img_paths as $item ) {
								$path_resize = str_replace ( DS . 'original' . DS, DS . $item [0] . DS, $path );
								$fsFile->remove_file_by_path ( $path_resize );
							}
						}
					}
				}
			// remove in database
			$sql = " DELETE FROM fs_products_images_plus
						WHERE record_id = ".$record_id."".
							$whewe;
			$db->query ( $sql );
			$rows = $db->affected_rows ();
			return $rows;
		// END EXIST FIELD
		}
	}
	function save_exist_images_plus($record_id) {
		
		$rs = 0;	
		global $db;
		// Thay doi du lieu da nhap 
		$other_color_exit= FSInput::get('image_plus_exist_total',array(),'array');	
		foreach ($other_color_exit as $item){
			$row ['record_id'] = $record_id;
			$row ['content'] = FSInput::get ( 'content_plus_exit_' . $item );
			$row ['image'] = FSInput::get ( 'name_image_plus_exist_' . $item );
			$upload_area_exit = "image_plus_exit_" . $item;
			
			if ($_FILES [$upload_area_exit] ["name"]) {
				
				$image_exit = $this->upload_image ( $upload_area_exit, '_' . time (), 2000000, $this->arr_img_paths_other_plus );
				$row ['image'] = $image_exit;
			}
								
			$u = $this->_update ( $row, 'fs_products_images_plus', ' id=' . $item );
			if ($u)
				$rs ++;
			
		}
		return $rs;
	
		// END EXIST FIELD
	}
	function save_new_images_plus($record_id) {
		if (! $record_id)
			return true;
		global $db;
		for($i = 0; $i < 5; $i ++) {
			
			$row = array ();
			
			$upload_area = "new_image_plus_" . $i;
			if ($_FILES [$upload_area] ["name"]) {
				$image = $this->upload_image ( $upload_area, '_' . time (), 2000000, $this->arr_img_paths_other_plus );
				$row ['image'] = $image;
				$row ['record_id'] = $record_id;
				$row ['content'] = FSInput::get ( 'new_content_plus_'.$i );
				$rs = $this->_add ( $row, 'fs_products_images_plus', 0 );
			}
		}
		return true;
	}	

	function upload_360($id){
		$link_360 = isset($_FILES["link_360"]["name"])?$_FILES["link_360"]["name"]:'';
		if(!$link_360){
			return;
		}
		// remove old if exists record and img
		$foder='images/products/360/';
		$path = PATH_BASE.str_replace ( '/', DS, $foder );
		if($id){
			$img_paths = array();
			$img_paths[] = $path;
			$this-> remove_file($id,$img_paths,'link_360',$this -> table_name);
		}
		
		$fsFile = FSFactory::getClass('FsFiles');
		// upload
		$link_360 = $fsFile -> uploadFlash("link_360", $path ,2000000, '_'.time());
		if(!$link_360)
			return false;
		return $link_360;
	}
	function remove_compatable(){
			$id = FSInput::get('id',0,'int');
			$product_compatable_id = FSInput::get('product_compatable_id',0,'int');
			if(!$id || !$product_compatable_id)	
				return;
				
			$sql = " SELECT products_compatable 
				FROM fs_products 
				WHERE id = $id
					";
			global $db ;
			// $db->query($sql);
			$rs =  $db->getResult($sql);
			if(!$rs)	
				return;

			$arr = explode( ',',$rs);
			if(!count($arr))
				return;
			$str = '';
			$i  = 0;
			foreach($arr as $item){
				if($item != $product_compatable_id){
					if($i > 0)
						$str .= ',';
					$str .= $item;
					$i ++;
				}
			}	
			$row['products_compatable'] = $str;
			return $this -> _update($row,'fs_products','id = '.$id .'');
		}
	function remove_incentives(){
		$id = FSInput::get('id',0,'int');
		$product_incentives_id = FSInput::get('product_incentives_id',0,'int');
		if(!$id || !$product_incentives_id)	
			return;
				
		$sql = " SELECT products_incentives 
			FROM fs_products 
			WHERE id = $id
				";
		global $db ;
		$rs =  $db->getResult($sql);
		if(!$rs)	
			return;

		$arr = explode( ',',$rs);
		if(!count($arr))
			return;
		$str = '';
		$i  = 0;
		foreach($arr as $item){
			if($item != $product_incentives_id){
				if($i > 0)
					$str .= ',';
				$str .= $item;
				$i ++;
			}
		}	
		$row['products_incentives'] = $str;
			
		// remove from fs_products_incentives
		$this -> remove_from_products_incentives($id ,$product_incentives_id);			
		return $this -> _update($row,'fs_products','id = '.$id .'');
	}	
	function remove_from_products_incentives($id ,$product_incentives_id){
		$sql = " DELETE FROM fs_products_incentives
					WHERE product_id = $id
						AND product_incenty_id = $product_incentives_id " ;
		global $db;
		$rows = $db->affected_rows($sql);
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
				$sql = " UPDATE ".$this -> table_name."
							SET show_in_home = $value
						WHERE id IN ( $str_ids ) " ;
				$rows = $db->affected_rows($sql);
				return $rows;
			}
			// 	update sitemap
			if($this -> call_update_sitemap){
				$this -> call_update_sitemap();
			}
			
			return 0;
		}
		/*
		 * value: == 1 :hot
		 * value  == 0 :unhot
		 * published record
		 */
		function hot($value)
		{
			$ids = FSInput::get('id',array(),'array');
			
			if(count($ids))
			{
				global $db;
				$str_ids = implode(',',$ids);
				$sql = " UPDATE ".$this -> table_name."
							SET is_hot = $value
						WHERE id IN ( $str_ids ) " ;
				$rows = $db->affected_rows($sql);
				return $rows;
			}
			// 	update sitemap
			if($this -> call_update_sitemap){
				$this -> call_update_sitemap();
			}
			return 0;
		}
/*
		 * value: == 1 :new
		 * value  == 0 :unnew
		 * published record
		 */
		function is_new($value)
		{
			$ids = FSInput::get('id',array(),'array');
			
			if(count($ids))
			{
				global $db;
				$str_ids = implode(',',$ids);
				$sql = " UPDATE ".$this -> table_name."
							SET is_new = $value
						WHERE id IN ( $str_ids ) " ;
				// $db->query($sql);
				$rows = $db->affected_rows($sql);
				return $rows;
			}
			// 	update sitemap
			if($this -> call_update_sitemap){
				$this -> call_update_sitemap();
			}
			return 0;
		}
/*
		 * value: == 1 :new
		 * value  == 0 :unnew
		 * published record
		 */
		function is_hot($value)
		{
			$ids = FSInput::get('id',array(),'array');
			
			if(count($ids))
			{
				global $db;
				$str_ids = implode(',',$ids);
				$sql = " UPDATE ".$this -> table_name."
							SET is_hot = $value
						WHERE id IN ( $str_ids ) " ;
				// $db->query($sql);
				$rows = $db->affected_rows($sql);
				return $rows;
			}
			// 	update sitemap
			if($this -> call_update_sitemap){
				$this -> call_update_sitemap();
			}
			return 0;
		}
		/*
		 * value: == 1 :old
		 * value  == 0 :unold
		 * published record
		 */
		function is_sell($value)
		{
			$ids = FSInput::get('id',array(),'array');
			
			if(count($ids))
			{
				global $db;
				$str_ids = implode(',',$ids);
				$sql = " UPDATE ".$this -> table_name."
							SET is_sell = $value
						WHERE id IN ( $str_ids ) " ;
				// $db->query($sql);
				$rows = $db->affected_rows($sql);
				return $rows;
			}
			// 	update sitemap
			if($this -> call_update_sitemap){
				$this -> call_update_sitemap();
			}
			return 0;
		}
		/*
		 * value: == 1 :old
		 * value  == 0 :unold
		 * published record
		 */
		function is_old($value)
		{
			$ids = FSInput::get('id',array(),'array');
			
			if(count($ids))
			{
				global $db;
				$str_ids = implode(',',$ids);
				$sql = " UPDATE ".$this -> table_name."
							SET is_old = $value
						WHERE id IN ( $str_ids ) " ;
				// $db->query($sql);
				$rows = $db->affected_rows($sql);
				return $rows;
			}
			// 	update sitemap
			if($this -> call_update_sitemap){
				$this -> call_update_sitemap();
			}
			return 0;
		}
		function get_data_by_color($color_id,$record_id)
		{
			global $db;
			if(!$color_id)
				return false;
			
			$query   = " SELECT *
						FROM fs_products_price 
						WHERE color_id = ".$color_id."
							AND record_id =".$record_id;
			$db->query($query);
			$result = $db->getObject();
			return $result;
		}
	/**
	 * Lấy danh sách ảnh
	 * 
	 * @return Object list
	 */
	function get_other_images() {
		$data = base64_decode ( FSInput::get ( 'data' ) );
		$data = explode ( '|', $data );
		$where = 'record_id = ' . $data [1];
		if ($data [0] == 'add')
			$where = 'session_id = \'' . $data [1] . '\'';
		global $db;
		$query = '  SELECT *
                        FROM ' . 'fs_' . $this->type . '_images' . ' 
                        WHERE ' . $where . '
                        ORDER BY ordering, id DESC';
		$sql = $db->query ( $query );
		return $db->getObjectList ();
	}


/**
	 * Upload và resize ảnh
	 * 
	 * @return Bool
	 */
	function upload_other_images() {
		global $db;
		$path = PATH_BASE . $this->img_folder . DS . 'original' . DS;
		require_once (PATH_BASE . 'libraries' . DS . 'upload.php');
		$upload = new Upload ();
		$upload->create_folder ( $path );
		$file_name = $upload->uploadImage ( 'file', $path, 10000000, '_' . time () );
		//            $upload->create_folder ( $path );
		// xoay ảnh trên IOS và save ghi đè lên ảnh cũ.
		

		//            require_once($_SERVER['DOCUMENT_ROOT'].'/libraries/lib/WideImage.php'); // Gọi thư viện WideImage.php
		//            $uploadedFileName = $path.$file_name;  // lấy ảnh từ  đã upload lên 
		//            $load_img = WideImage::load($uploadedFileName);
		//            $exif = exif_read_data($uploadedFileName); // 
		//            $orientation = @$exif['Orientation'];                        
		//            if(!empty($orientation)) {
		//                switch($orientation) {
		//                    case 8:
		//                        $image_p = imagerotate($uploadedFileName,90,0);
		//                        //echo 'It is 8';
		//                        break;
		//                    case 3:
		//                        $image_p = imagerotate($uploadedFileName,180,0);
		//                        
		//                        //echo 'It is 3';
		//                        break;
		//                    case 6:
		//                        $load_img->rotate(90)->saveToFile($uploadedFileName);
		//                        //$image_p = imagerotate($uploadedFileName,-90,0);
		//                        //echo 'It is 6';
		//                        break;
		//            
		//                }
		//                //imagejpeg ( $image_p , $path.'test.jpg' ,  100 );              
		//            } 
		//            
		// END save ảnh xoay trên IOS   
		if (is_string ( $file_name ) and $file_name != '' and ! empty ( $this->arr_img_paths_other )) {
			$fsFile = FSFactory::getClass ( 'FsFiles' );
			foreach ( $this->arr_img_paths_other as $item ) {
				$path_resize = str_replace ( DS . 'original' . DS, DS . $item [0] . DS, $path );
				$fsFile->create_folder ( $path_resize );
				$method_resize = $item [3] ? $item [3] : 'resized_not_crop';
				$fsFile->$method_resize ( $path . $file_name, $path_resize . $file_name, $item [1], $item [2] );
			}
		}
		$data = base64_decode ( FSInput::get ( 'data' ) );
		$data = explode ( '|', $data );
		$row = array ();
		if ($data [0] == 'add')
			$row ['session_id'] = $data [1];
		else
			$row ['record_id'] = $data [1];
		$row ['image'] = $this->img_folder . '/original/' . $file_name;
		$rs = $this->_add ( $row, 'fs_' . $this->type . '_images' );
		$row ['id'] = $rs;
		echo json_encode ( $row );
		return true;
	}
	/**
	 * Sửa thuộc tính của ảnh
	 * 
	 * @return Bool
	 */
	function change_attr_image() {
		global $db;
		$data = base64_decode ( FSInput::get ( 'data' ) );
		$data = explode ( '|', $data );
		$row = array ();
		$where = '';
		if ($data [0] == 'add') {
			$where .= ' AND session_id = "' . $data [1] . '" ';
		} else {
			$where .= ' AND record_id = "' . $data [1] . '" ';
		}
		$field = FSInput::get ( 'field' );
		$value = FSInput::get ( 'value' );
		$id = FSInput::get ( 'id', 0, 'int' );
		if (! $id)
			return;
		if ($field == 'color') {
			$row ['color_id'] = $value;
		}
		$rs = $this->_update ( $row, 'fs_' . $this->type . '_images', ' id = ' . $id . $where );
		return $rs;
	}
	function delete_other_image($record_id = 0) {
		global $db;
		if ($record_id)
			$where = 'record_id = \'' . $record_id . '\'';
		else {
			$id = FSInput::get ( 'id', 0 );
			$where = 'id = \'' . $id . '\'';
		}
		$query = '  SELECT *
                        FROM fs_' . $this->type . '_images
                        WHERE ' . $where;
		$db->query ( $query );
		$listImages = $db->getObjectList ();
		if ($listImages) {
			foreach ( $listImages as $item ) {
				$query = '  DELETE FROM fs_' . $this->type . '_images
                                WHERE id = \'' . $item->id . '\'';
				$db->query ( $query );
				$path = PATH_BASE . $item->image;
				@unlink ( $path );
				foreach ( $this->arr_img_paths_other as $image ) {
					@unlink ( str_replace ( '/original/', '/' . $image [0] . '/', $path ) );
				}
			}
		}
	}
	
	function sort_other_images() {
		global $db;
		if (isset ( $_POST ["sort"] )) {
			if (is_array ( $_POST ["sort"] )) {
				foreach ( $_POST ["sort"] as $key => $value ) {
					$db->query ( "UPDATE fs_" . $this->type . "_images SET ordering = $key WHERE id = $value" );
				}
			}
		}
	}		/*
		 *==================== end.OTHER IMAGES==============================
		 */
		 function get_data_by_warranty($warranty_id,$record_id){
			global $db;
			if(!$warranty_id)
				return false;
			
			$query   = " SELECT *
						FROM fs_warranty_price 
						WHERE warranty_id = ".$warranty_id."
							AND record_id =".$record_id;
			$db->query($query);
			$result = $db->getObject();
			return $result;
		}
		/*
		 *==================== end.OTHER IMAGES==============================
		 */
		 function get_data_by_origin($origin_id,$record_id){
			global $db;
			if(!$origin_id)
				return false;
			
			$query   = " SELECT *
						FROM fs_origin_price 
						WHERE origin_id = ".$origin_id."
							AND record_id =".$record_id;
			$db->query($query);
			$result = $db->getObject();
			return $result;
		}
		/*
		 *==================== end.OTHER IMAGES==============================
		 */
		 function get_data_by_species($species_id,$record_id){
			global $db;
			if(!$species_id)
				return false;
			
			$query   = " SELECT *
						FROM fs_species_price 
						WHERE species_id = ".$species_id."
							AND record_id =".$record_id;
			$db->query($query);
			$result = $db->getObject();
			return $result;
		}
		/*
		 *==================== end.OTHER IMAGES==============================
		 */
		 function get_data_by_memory($memory_id,$record_id){
			global $db;
			if(!$memory_id)
				return false;
			
			$query   = " SELECT *
						FROM fs_memory_price 
						WHERE memory_id = ".$memory_id."
							AND record_id =".$record_id;
			$db->query($query);
			$result = $db->getObject();
			return $result;
		}
		function remove_cache()
		{

			// $this -> remove_memcached();
			$fsCache = FSFactory::getClass('FSCache');
			$type = FSInput::get('type');
			
			$module_rm = 'products';
			$view_rm = 'product';
			$ids = FSInput::get('id',array(),'array');
			$data = $this -> get_record_by_id(isset($ids[0])?$ids[0]:0);
			if(!$data)
				return;
			
			$link_detail = FSRoute::_('index.php?module=products&view=product&id='.$data->id.'&code='.$data -> alias.'&ccode='.$data-> category_alias);
			$link_detail = str_replace(URL_ROOT, '/', $link_detail);

			$link_detail = md5($link_detail);
			$str_link = $link_detail;
			
			// xoa chi tiết tin
			$fsCache -> remove($str_link,'modules/'.$module_rm.'/'.$view_rm.'/'.$data->category_alias);

			$fsCache -> remove($str_link,'modules/'.$module_rm.'/'.$view_rm.'/'.$data->category_alias);
	
			
			// xóa category
			// $link_detail = FSRoute::_('index.php?module=news&view=cat&ccode='.$data->alias.'&id='.$data -> id.'&Itemid=10');
			// $link_detail = str_replace(URL_ROOT, '/', $link_detail);
			// $link_detail = md5($link_detail);
			// $str_link = $link_detail;
			
			// xóa trang chủ
			$link_home = md5('/');
			$fsCache -> remove($link_home,'modules/home/home');
			$fsCache -> remove($link_home,'modules/home/mhome');


		
			$files = glob(PATH_BASE.'/cache/modules/products/cat/'.$data->category_alias.'/*' ); 
			foreach( $files as $file ){			
				if( is_file( $file ) ) {				
					if( !@unlink( $file ) ) {
						//Handle your errors 
					} 
				} 
			}		
	
			return 1;
		}
			/*
		 * value: == 1 :hot
		 * value  == 0 :unhot
		 * published record
		 */
		function promotion($value)
		{
			$ids = FSInput::get('id',array(),'array');
			
			if(count($ids))
			{
				global $db;
				$str_ids = implode(',',$ids);
				$sql = " UPDATE ".$this -> table_name."
							SET is_promotion = $value
						WHERE id IN ( $str_ids ) " ;
				// $db->query($sql);
				$rows = $db->affected_rows($sql);
				return $rows;
			}
			// 	update sitemap
			if($this -> call_update_sitemap){
				$this -> call_update_sitemap();
			}
			return 0;
		}

		function remove_memcached()
		{
			$array_memkey = array('blocks','config_commom','menus','banners');
			$fsmemcache = FSFactory::getClass('fsmemcache');
			foreach($array_memkey as $key){
				$fsmemcache -> delete($key);
			}
		}
	}
?>