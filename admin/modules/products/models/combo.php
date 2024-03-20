<?php
class ProductsModelsCombo extends FSModels {
	var $limit;
	var $prefix;
	var $image_watermark;
	function __construct() {
		parent::__construct ();
		$this->limit = 20;
		$this->view = 'combo';
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
		$this->img_folder = 'upload_images/images/' . $this->type . '/' . $cyear . '/' . $cmonth . '/' . $cday;
		$this->img_folder2 = 'images/' . $this->type . '/' . $cyear . '/' . $cmonth . '/' . $cday;
		$this -> arr_img_paths_other_plus = array(array('large',500,500,'resized_not_crop'), array ('small', 120, 70, 'cut_image' ));
		$this -> arr_img_paths_hot =array(array ('resized', 470, 340, 'resized_not_crop' ));
		$this -> arr_img_paths_video_review = array(array('large',500,286,'cut_image'));
		$this->check_alias = 1;
		$this->field_img = 'image';
		$this->field_reset_when_duplicate = array ('comments_total' );
		$this->image_watermark =1; //Đóng dấu nên ảnh
		$this->image_watermark_pos = 8; //Đóng dấu nên ảnh
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
				$where .= ' AND a.category_id_wrapper like   "%,' . $filter . ',%" ';
			}
		}
		// lọc loại sản phẩm
		if (isset ( $_SESSION [$this->prefix . 'filter1'] )) {
			$filter = $_SESSION [$this->prefix . 'filter1'];
			if ($filter) {
				$where .= ' AND manufactory  =' . $filter . '';
			}
		}
		// lọc loại sản phẩm
		if (isset ( $_SESSION [$this->prefix . 'filter2'] )) {
			$filter = $_SESSION [$this->prefix . 'filter2'];
			if ($filter) {
				$where .= ' AND a.type = ' . $filter;
			}
		}
		
		// SP nổi bật
		if (isset ( $_SESSION [$this->prefix . 'filter3'] )) {
			$filter = $_SESSION [$this->prefix . 'filter3'];
			if ($filter) {
				if($filter == 1)
					$where .= ' AND a.is_sell = 1';
				else 
					$where .= ' AND a.is_sell != 1';
			}

		}

		// SP nổi bật
		if (isset ( $_SESSION [$this->prefix . 'filter4'] )) {
			$filter = $_SESSION [$this->prefix . 'filter4'];
			if ($filter) {
				if($filter == 1)
					$where .= ' AND a.show_in_home = 1';
				else 
					$where .= ' AND a.show_in_home != 1';
			}

		}

		// lọc loại sản phẩm
		if (isset ( $_SESSION [$this->prefix . 'filter5'] )) {
			$filter = $_SESSION [$this->prefix . 'filter5'];
			if ($filter) {
				$where .= ' AND status  =' . $filter . '';
			}
		}

		// SP nổi bật
		if (isset ( $_SESSION [$this->prefix . 'filter6'] )) {
			$filter = $_SESSION [$this->prefix . 'filter6'];
			if ($filter) {
				if($filter == 1)
					$where .= ' AND a.is_hot = 1';
				else 
					$where .= ' AND a.is_hot != 1';
			}

		}


		// ng tạo
		if (isset ( $_SESSION [$this->prefix . 'filter7'] )) {
			$filter = $_SESSION [$this->prefix . 'filter7'];
			if ($filter) {
				$where .= ' AND creator_id  =' . $filter . '';
			}
		}

		
		if (! $ordering)
			$ordering .= " ORDER BY created_time DESC , id DESC ";
		
		if (isset ( $_SESSION [$this->prefix . 'keysearch'] )) {
			if ($_SESSION [$this->prefix . 'keysearch']) {
				$keysearch = $_SESSION [$this->prefix . 'keysearch'];

				$code_repalce = preg_replace("/[^a-zA-Z0-9]/", "", $keysearch);

				$where .= " AND ( a.code LIKE '%" . $keysearch . "%' OR a.name LIKE '%" . $keysearch . "%' OR a.code_repalce LIKE '%" . $code_repalce . "%' OR a.alias LIKE '%" . $keysearch . "%' OR a.id = '".$keysearch."' )";
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
		WHERE 1=1 AND is_trash = 0 AND is_combo = 1" . $where . $ordering . " ";
		return $query;
	}

	function setQueryExport() {
		
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
				$where .= ' AND a.category_id_wrapper like   "%,' . $filter . ',%" ';
			}
		}
		// lọc loại sản phẩm
		if (isset ( $_SESSION [$this->prefix . 'filter2'] )) {
			$filter = $_SESSION [$this->prefix . 'filter2'];
			if ($filter) {
				$where .= ' AND a.types like   "%,' . $filter . ',%" ';
			}
		}
		
		// SP nổi bật
		if (isset ( $_SESSION [$this->prefix . 'filter3'] )) {
			$filter = $_SESSION [$this->prefix . 'filter3'];
			if ($filter) {
				if($filter == 1)
					$where .= ' AND a.is_hot = 1';
				else 
					$where .= ' AND a.is_hot != 1';
			}

		}
		// lọc loại sản phẩm
		if (isset ( $_SESSION [$this->prefix . 'filter1'] )) {
			$filter = $_SESSION [$this->prefix . 'filter1'];
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

		$limit = '';
		$text0 = 0;

		echo $export_from = FSInput::get('export_from',0,'int');
		echo $export_to = FSInput::get('export_to',1,'int');

		die;

		if(!$export_to || $export_from > $export_to){
			return;
		}
		// lọc loại sản phẩm
		if (isset ($export_to )) {
			$limit .= ' LIMIT '.$export_from;
			
		}
		if ($export_to) {				
			$limit .= ','.($export_to - $export_from + 1);			
		}

		
		echo $query = " SELECT a.* FROM " . $this->table_name . " AS a WHERE 1=1 " . $where . $ordering . " " . $limit;
		die;
		return $query;
	}
	
	/*
		 * select in category
		 */
	function get_categories() {
		$where ='';
		if (isset ( $_SESSION [$this->prefix . 'category_keysearch'] )) {
			if ($_SESSION [$this->prefix . 'category_keysearch']) {
				$keysearch = $_SESSION [$this->prefix . 'category_keysearch'];
				$where .= " AND ( name LIKE '%" . $keysearch . "%' OR alias LIKE '%" . $keysearch . "%' OR id = '".$keysearch."')";
			}
		}
		global $db;
		$sql = " SELECT id, name, parent_id AS parent_id 
		FROM " . $this->table_category . ' WHERE 1 = 1'. $where . ' ORDER BY level ASC, name ASC';
		$db->query ( $sql );
		$categories = $db->getObjectList ();
		return $categories;
		// $tree = FSFactory::getClass ( 'tree', 'tree/' );
		// $rs = $tree->indentRows ( $categories, 0 );
		// return $rs;
	}

	function get_categories_tree() {
		$where ='';
		if (isset ( $_SESSION [$this->prefix . 'category_keysearch'] )) {
			if ($_SESSION [$this->prefix . 'category_keysearch']) {
				$keysearch = $_SESSION [$this->prefix . 'category_keysearch'];
				$where .= " AND ( name LIKE '%" . $keysearch . "%' OR alias LIKE '%" . $keysearch . "%' OR id = '".$keysearch."')";
			}
		}
		global $db;
		$sql = " SELECT id, name,list_parents, parent_id AS parent_id 
		FROM " . $this->table_category . " ORDER BY ordering ASC";
		$db->query ( $sql );
		$categories = $db->getObjectList ();
		
		$tree = FSFactory::getClass ( 'tree', 'tree/' );
		$rs = $tree->indentRows ( $categories, 0 );
		return $rs;
	}


	function ajax_getCategories_filter($cat_ft_id) {
		$where ='';

		global $db;
		$sql = " SELECT id, name, parent_id AS parent_id 
		FROM " . $this->table_category . " WHERE list_parents LIKE '%,$cat_ft_id,%'";
		
		$db->query ( $sql );
		$categories = $db->getObjectList ();
		
		$tree = FSFactory::getClass ( 'tree', 'tree/' );
		$rs = $tree->indentRows ( $categories, 0 );
		return $rs;
	}

	function get_categories_extra_tree($tablename) {
		global $db;
		$sql = " SELECT id, name, parent_id AS parent_id 
		FROM " . $this->table_category . ' WHERE tablename = "' .$tablename.'"';
		$db->query ( $sql );
		$categories = $db->getObjectList();
		
		$tree = FSFactory::getClass ( 'tree', 'tree/' );
		$rs = $tree->indentRows ( $categories, 1 );
		return $rs;
	}

	function get_categories_filter() {
		global $db;
		$sql = " SELECT id, name, parent_id AS parent_id 
		FROM " . $this->table_category . ' WHERE parent_id = 0';
		$db->query ( $sql );
		$categories = $db->getObjectList();
		
		// $tree = FSFactory::getClass ( 'tree', 'tree/' );
		// $rs = $tree->indentRows ( $categories, 1 );
		return $categories;
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
	

	function save($row = array(), $use_mysql_real_escape_string = 1) {
		$this->save_new_session();
		$return = FSInput::get ('return');
		$url = base64_decode ($return);
		$name = FSInput::get ('name');
		$id = FSInput::get ('id');
		$this -> assign_without_editing($id);

		$code = FSInput::get ('code');
		$category_id = FSInput::get ('category_id');
		$category_id_0n  = $category_id;
		if(!$id){
			$link = 'index.php?module=products&view=products&task=add&cid='.$category_id;
		}else{
			$link = 'index.php?module=products&view=products&task=edit&id='.$id;
		}

		if (!$name) {
			setRedirect($link,FSText :: _('Bạn phải nhập tên !'),'error');
		}

		if (!$code) {
			setRedirect($link,FSText :: _('Bạn phải nhập mã !'),'error');
		}

		if(!$id){
			$check_code = $this->get_result('code="'.$code.'"');
			if($check_code){
				setRedirect($link,FSText :: _('Mã nhập đã tồn tại !'),'error');
				return false;
			}
		}else{
			$check_code = $this->get_result('code="'.$code.'" AND id != '.$id);
			if($check_code){
				setRedirect($link,FSText :: _('Mã nhập đã tồn tại !'),'error');
				return false;
			}
		}

		if(!$id){
			$check_name = $this->get_result('name="'.$name.'"');
			if($check_name){
				Errors::_ ( 'Tên sản phẩm đã tồn tại, bạn nên nhập tên khác!','alert' );
				// setRedirect($link,FSText :: _('Mã nhập đã tồn tại !'),'error');
				// return false;
			}
		}else{
			$check_name = $this->get_result('name="'.$name.'" AND id != '.$id);
			if($check_name){
				Errors::_ ( 'Tên sản phẩm đã tồn tại, bạn nên nhập tên khác!','alert' );
				// return false;
			}
		}

		// if(!$id){
			
		// 	$check_name = $this->get_result('name="'.$name.'"');
		// 	if($check_name){
		// 		setRedirect($link,FSText :: _('Tên nhập đã tồn tại !'),'error');
		// 		return false;
		// 	}
			
		// }else{
		// 	$check_name = $this->get_result('name="'.$name.'" AND id != '.$id);
		// 	if($check_name){
		// 		setRedirect('index.php?module=products&view=categories&task=edit&id='.$id,FSText :: _('Tên danh mục đã tồn tại !'),'error');
		// 		return false;
		// 	}
		// }


		
		$id = FSInput::get ( 'id', 0, 'int' );


		if (!$id) {
			$check_save_new = 1;
		} else {
			$check_save_new = 0;
		}

		if (!$id) {
			$row ['creator_name'] = $_SESSION['ad_username'];
			$row ['creator_id'] = $_SESSION['ad_userid'];
		}

		$alias = FSInput::get ( 'alias' );
		$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
		
		if (! $alias) {
			$row ['alias'] = $fsstring->stringStandart ( $name );
		} else {
			$row ['alias'] = $fsstring->stringStandart ( $alias );
		}

		$row ['code_repalce'] = preg_replace("/[^a-zA-Z0-9]/", "", $code);
		$row ['is_trash'] = 0;
		$row ['is_combo'] = 1;
		


		$is_hotdeal_show_home = FSInput::get('is_hotdeal_show_home');
		if(isset($is_hotdeal_show_home ) && $is_hotdeal_show_home != 0)
		{
			$rs = $this -> _update_column('fs_products', 'is_hotdeal_show_home','0');
		}
		// category and category_id_wrapper

		// $cats_id = FSInput::get ( 'category_id', array (), 'array' );
		// $str_cats_id = implode ( ',', $cats_id );

		// $category_id = $cats_id[0];
		// $row['category_id'] = $category_id;

		$category_id = FSInput::get ( 'category_id', 0, 'int' );
		if (! $category_id) {
			Errors::_ ( 'You must select category' );
			return false;	
		}

		$cat = $this->get_record_by_id ( $category_id, $this->table_category );


		// category and category_id_wrapper danh mục phụ
		$category_id_arr = FSInput::get ( 'category_id_wrapper',array (), 'array');

		$category_id = array();

		foreach ($category_id_arr as $cat_item) {
			$cat_item_check = $this->get_record('id = ' . $cat_item,'fs_products_categories');
			if($cat_item_check -> tablename == $cat->tablename){
				$category_id[] = $cat_item_check->id;
			}
		}

		// printr($category_id);

		$str_category_id = implode ( ',', $category_id );
		if ($str_category_id) {
			$str_category_id = ',' . $str_category_id . ',';
		}
		$wrapper_id_all ="";
		$wrapper_alias ="";
		for($i = 0; $i < count($category_id) ; $i ++)
		{ 
			$item = $category_id[$i];
			$alias = $this -> get_record_by_id($item,'fs_products_categories','alias,list_parents');
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
			$alias = $this -> get_record_by_id($item,'fs_products_categories','alias');
			$wrapper_alias .= $alias->alias.',';
		}
		$array_wrap_alias=explode(',',$wrapper_alias);
		$arr_show_alias=array_unique($array_wrap_alias);
		$arr_show_count_alias=implode(',',$arr_show_alias);
		$arr_show_count=implode(',',$arr_show);


		$arr_list_parents = explode(',',$cat->list_parents);

		unset($arr_list_parents[count($arr_list_parents) - 1]);
		unset($arr_list_parents[0]);

		$array_merge = array_merge($arr_list_parents, $arr_show);
		$array_merge = array_unique($array_merge, 0);
		$str_show_count=implode(',',$array_merge);
		// printr($str_show_count);

		$str_show_count_alias = "";
		foreach ($array_merge as $val) {
			$get_alias = $this->get_record('id= ' .$val ,'fs_products_categories');
			if($get_alias){
				$str_show_count_alias .= $get_alias->alias . ',';
			}
			
		}
				
		
		$row ['category_id_wrapper'] = ','.$str_show_count.',';
		$row ['category_alias_wrapper'] = ','. $str_show_count_alias;

		// echo "<pre>";
		// print_r($row);
		// die;




		// $row ['category_id_wrapper'] = $cat->list_parents;
		// $row ['category_alias_wrapper'] = $cat->alias_wrapper;
		
		$row ['category_root_alias'] = $cat->root_alias;
		
		$row ['category_name'] = $cat->name;
		$row ['category_alias'] = $cat->alias;
		$row ['category_published'] = $cat->published;
		$row ['show_in_homepage'] = $cat->show_in_homepage;
		$row ['tablename'] = $cat->tablename;

		// $ic = 0;
		// foreach ($cats_id as $catid) {
		// 	if($ic) {
		// 		$cat2 =  $this->get_record_by_id ( $catid, $this->table_category );
		// 		$row ['category_id_wrapper'] .= $catid.',';
		// 		$row ['category_alias_wrapper'] .= $cat2 ->alias.',';
		// 	}
		// 	$ic++;	
		// }
		
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
			$row ['manufactory_id_wrapper']  = $manufactory -> list_parents;
			$row ['manufactory_alias_wrapper'] = $manufactory -> alias_wrapper;
			$row ['manufactory_alias'] = $manufactory->alias;
			$row ['manufactory_name'] = $manufactory->name;
			$row ['manufactory_image'] = $manufactory->image;
		}
		
		//price
		$price_old = FSInput::get ('price_old');
		$price = FSInput::get ('price');
		$discount = FSInput::get ( 'discount');
		
		
		$price_old = $this -> standart_money($price_old, 0);
		$price = $this -> standart_money($price , 0);

		$discount= $this -> standart_money($discount, 0);
	
		if($price_old < $price){
			$price_old = $price;
		}

		if ($discount > 100 || $discount < 0 || $discount == 0 ) {
			$row ['price_old'] =  $price_old;
			
			if($price_old > $price){
				$row ['price'] = $price;
				$row ['discount'] = round((($price_old - $price) / $price_old) * 100);
			}else{
				$row ['price'] = $price_old;
				$row ['discount'] = 0;
			}
			
		} else {
			$row ['price_old'] = $price_old;
			$row ['discount'] = $discount;
			$row ['price'] = $price_old * (100 - $discount) / 100;			
		}


		// $price_old= $this -> standart_money($price_old, 0);
		// $discount = FSInput::get ( 'discount');
		// $discount= $this -> standart_money($discount, 0);
		// $discount_unit = FSInput::get ( 'discount_unit', 'price' );
		// if ($discount_unit == 'percent') {
		// 	if ($discount > 100 || $discount < 0) {
		// 		$row ['price_old'] = $price_old;
		// 		$row ['price'] = $price_old;
		// 		$row ['discount'] = 0;
				
		// 	} else {
		// 		$row ['price_old'] = $price_old;
		// 		$row ['discount'] = $discount;
		// 		$row ['price'] = $price_old * (100 - $discount) / 100;			
		// 	}

		// } else {
		// 	if ($discount > $price_old || $discount < 0) {
		// 		$row ['price_old'] = $price_old;
		// 		$row ['price'] = $price_old;
		// 		$row ['discount'] = 0;
		// 	} else {
		// 		$row ['price_old'] = $price_old;
		// 		$row ['discount'] = $discount;
		// 		$row ['price'] = $price_old - $discount;
		// 	}
		// }
		// image
			// $image_name = $_FILES["image_video"]["name"];
			// if($image_name){
			// 	$image = $this->upload_image('image_video','_'.time(),2000000,$this -> arr_img_paths);
			// 	if($image){
			// 		$row['image_video'] = $image;
			// 	}
			// }
		// image
		// $image_hot_name = $_FILES["image_hot"]["name"];
		// if($image_hot_name){
		// 	$image_hot = $this->upload_image('image_hot','_'.time(),2000000,$this -> arr_img_paths_hot);
		// 	if($image_hot){
		// 		$row['image_hot'] = $image_hot;
		// 	}
		// }


		// $landingpage_image_left = @$_FILES["landingpage_image_left"]["name"];
		// if($landingpage_image_left){
		// 	if($id)
		// 		$this -> remove_image($id,$path_arr = array(),$field='landingpage_image_left',$table_name= '');

		// 	$image = $this->upload_image_sub('landingpage_image_left','_'.time(),2000000);
		// 	if($image){

		// 		$row['landingpage_image_left'] = $image;
		// 	}
		// }

		// $landingpage_image_right = @$_FILES["landingpage_image_right"]["name"];
		// if($landingpage_image_right){
		// 	if($id)
		// 		$this -> remove_image($id,$path_arr = array(),$field='landingpage_image_right',$table_name= '');

		// 	$image = $this->upload_image_sub('landingpage_image_right','_'.time(),2000000);
		// 	if($image){

		// 		$row['landingpage_image_right'] = $image;
		// 	}
		// }
		// $types = FSInput::get ( 'types', array (), 'array' );
		// $str_types = implode ( ',', $types );
		// if ($str_types) {
		// 	$str_types = ',' . $str_types . ',';
		// }
		// $row ['types'] = $str_types;

		$type = FSInput::get ('type');
		$row ['type'] = $type;

		$style_types = FSInput::get ( 'style_types', array (), 'array' );

		$str_style_types = implode ( ',', $style_types );
		if ($str_style_types) {
			$str_style_types = ',' . $str_style_types . ',';
		}
		$row ['style_types'] = $str_style_types;
		
		// remove color
		if (! $this->remove_color ( $id )) {
		}
		// edit color
		if (! $this->save_exist_color ( $id )) {
			//				return false;
		}

		// save color
		// if (! $this->save_new_color ( $id )) {
		// }
		
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

				// remove extend
		if (! $this->remove_extend ( $id )) {
		}			

		// edit color
		if (! $this->save_exist_extend ( $id )) {
			//				return false;
		}
		// save color
		if (! $this->save_new_extend ( $id )) {
		}

		// remove memory
		if (! $this->remove_usage_states ( $id )) {
		}	

		// edit color
		if (! $this->save_exist_usage_states ( $id )) {
			//				return false;
		}
		// save color
		if (! $this->save_new_usage_states ( $id )) {
		}

		// remove memory
		if (! $this->remove_regions ( $id )) {
		}	

		// edit color
		if (! $this->save_exist_regions ( $id )) {
			//				return false;
		}
		// save color
		if (! $this->save_new_regions ( $id )) {
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



		//video

		if (! $this->remove_days ( $id )) {		
		}
		if (! $this->save_exist_days ( $id)) {
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

		// related products
		$record_compare = FSInput::get('products_record_compare',array(),'array');
		$row['products_compare'] ='';
		if(count($record_compare)){
			$record_compare = array_unique($record_compare);
			$row['products_compare'] = implode(',', $record_compare);	
		}

		$record_news_relate = FSInput::get('news_record_related',array(),'array');
		$row['news_related'] ='';
		if(count($record_news_relate)){
			$record_news_relate = array_unique($record_news_relate);
			$row['news_related'] = ','.implode(',', $record_news_relate).',';	
		}	

		$id = parent::save ( $row );



			
		if($check_save_new) {
			$row_img = array();
			$row_img['record_id'] = $id;
			$row_img['session_id'] = '';
			$this-> _update($row_img,'fs_products_images','session_id = "'.session_id().'"');
		}

		if (! $this->save_new_price ( $id, $row['price'] , $row['price_old'] )) {
		}

		$this -> update_products_compatable($id);

		if ($id) {
			$old_record = $this->get_record_by_id ( $id );
			$this->save_history ( $old_record );
		}
		if (!isset($id)) {
			Errors::setError ( 'Not save' );
			return false;
		}
		
		// 	update total product in fs_products_category
		//			$this -> update_total_products($cat->root_id);
		
		if($id){
			$this->save_new_days ( $id );
			$this -> save_accessories_incentives($id);
			$this->save_new_color ( $id );	

			$uploadConfig = base64_encode(session_id());;
			$data_session = base64_decode ($uploadConfig );

			$get_image_color = $this->get_record('record_id=0 AND session_id ="'.$data_session.'"','fs_products_images');
			$row_id['record_id']=$id;
			$row_id['session_id']='';
			if(!empty($get_image_color)){
				$this->_update ( $row_id, 'fs_products_images', 'session_id = "'.$data_session.'"' );
			}
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


	function remove_days($record_id) {
		if (! $record_id)
			return true;
		$other_days_remove = FSInput::get('other_days',array(),'array');
		$str_other_days = implode(',',$other_days_remove);
		if ($str_other_days) {
			global $db;
			
    				// remove in database
			$sql = " DELETE FROM fs_products_video_review
			WHERE record_id = $record_id AND id IN ($str_other_days)";
			$db->query ( $sql );
			$rows = $db->affected_rows ();
			
			return $rows;
		}
		return true;
	}
	function save_exist_days($id) {
		global $db;
    		// EXIST FIELD
		$days_exist_total = FSInput::get ( 'days_exist_total' );
		
		$sql_alter = "";
		$arr_sql_alter = array ();
		$rs = 0;
		for ($i = 0; $i < $days_exist_total; $i++) {
			$id_days_exist = FSInput::get('id_days_exist_'.$i);
			$days_name = FSInput::get('days_name_exist_'.$i);
			if($id_days_exist){
				$row = array();
				$row ['link'] = $days_name;

				$image_name_menu = $_FILES["days_image_exist_".$i]["name"];
				if($image_name_menu){
					$image_menu = $this->upload_image('days_image_exist_'.$i,'_'.time(),2000000,$this -> arr_img_paths_video_review);
					if($image_menu){
						$row['image'] = str_replace('upload_images/','',$image_menu);
					}
				}


				
//                    echo $days_exist_total;die;
				$u = $this->_update($row, 'fs_products_video_review', ' id=' . $id_days_exist);
				if ($u)
					$rs ++;
			}		
		}
		
		return $rs;
	}
	
	function save_new_days($record_id) {
		global $db;
		for($i = 0; $i < 20; $i ++) {
			$row = array ();
			$row ['link'] = FSInput::get ( 'new_days_name_' . $i );
			if (! $row ['link']) {
				continue;
			}
			$row ['record_id'] = $record_id;


			$image_name_menu = $_FILES["new_days_image_".$i]["name"];
			if($image_name_menu){
				$image_menu = $this->upload_image('new_days_image_'.$i,'_'.time(),2000000,$this -> arr_img_paths_video_review);
				if($image_menu){
					$row['image'] = str_replace('upload_images/','',$image_menu);
				}
			}

			$rs = $this->_add ( $row, 'fs_products_video_review', 1 );
		}
		return true;
	}

	function get_days($tours_id){
		return $this -> get_records('record_id = '.$tours_id,'fs_products_video_review');
	}



	function update_products_compatable($product_id){
		if(!$product_id)
			return;
		$arr = FSInput::get ( 'products_record_compatable', array (), 'array' );
		$str_prices_is = '';
		if (empty ( $arr )) 
			return;
		$arr = array_unique ( $arr );
		$str_prices_is = implode ( ',', $arr ) ;
		if($str_prices_is){
			$str_prices_is = ',' . $str_prices_is . ',';
		}
		
		$arr_prices = $this -> get_prices_by_ids($str_prices_is,$product_id); 
		
		$this -> _remove(' product_compatable_id NOT IN (0'.$str_prices_is.'0) AND product_id = '.$product_id ,'fs_products_compatables');
		$arr_saleproducts_exist = $this -> get_records('product_compatable_id IN (0'.$str_prices_is.'0) AND product_id = '.$product_id ,'fs_products_compatables','*','','','product_id');
		
		$str_products_id = '';

		
		foreach($arr_prices as $item){
			$row = array();
			$row['price'] = FSInput::get('price_value_'.$item -> id,0,'money');
			$row['group_id'] = FSInput::get('types_compatables_'.$item -> id,0,'int');
			if($row['group_id']) {
				$group = $this-> get_record('id = '.$row['group_id'], 'fs_products_types_compatables', name);
			}
			$row['group_name'] = $group-> name;
			$row['ordering'] = FSInput::get('ordering_value_'.$item -> id,0,'int');
			$row['price_old'] = $item -> price_old?$item -> price_old:$item -> price;
			$row['product_id'] = $product_id;
			// $row['id'] = $item -> id;
			$row['product_compatable_id'] = $item -> id;
			$row['product_compatable_name'] = $item -> name;
			$str_products_id .= ','.$item -> id;

			$check_ex =  $this -> get_records('product_compatable_id ='.$item-> id.' AND product_id = '.$product_id ,'fs_products_compatables','*');
			
			if(!empty($check_ex)){	
				$this -> _update($row, 'fs_products_compatables','product_compatable_id ='.$item-> id.' AND product_id = '.$product_id);
			}else{
				$this -> _add($row, 'fs_products_compatables');
			}
		}
		// $str_products_id = $str_products_id?$str_products_id.',':'';
		// $row1 = array();
		// $row1['products_ids'] = $str_products_id;
		// $row1['prd_prices_ids'] = $str_prices_is;
		// $this -> _update($row1, 'fs_sales',' id = '.$sale_id);
		return true;
	}

	function  get_prices_by_ids($str_prices_id){
		if (! $str_prices_id)
			return;
		$query = " SELECT id, name, price, price_old
		FROM fs_products
		WHERE id IN (0" . $str_prices_id . "0) ";
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectListByKey('id');
		return $result;
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
		// echo $ext_id;
		// printr($row);
		// echo $tablename;
		// die;
		$this->_update ( $row2, $this->table_name, ' id =  ' . $record_id );

		// chuyển danh mục có bảng khác sẽ xóa record_id đó ở các bảng khác
		if ($ext_id){
			$check_ext_id = $this->get_record('id = ' . $ext_id, $tablename,'id');
			if(!$check_ext_id){
				$rs = $this->_add ( $row, $tablename );
				if($rs){
					$product_tables = $this->get_product_tables();
					foreach ($product_tables as $product_table) {
						$check_id_remove = $this->get_record('record_id = ' . $record_id, $product_table->table_name,'id');
						if($product_table->table_name == $tablename){
							continue;
						}
						if($check_id_remove){
							$rm = $this->_remove('record_id ='  .$record_id,$product_table->table_name);
							break;
						}
					}
				}
			}else{
				$rs = $this->_update ( $row, $tablename, ' id =  ' . $ext_id , 1);
			}
			
		} else {
			$check_ext_id = $this->get_record('record_id = ' . $row['record_id'], $tablename,'id');
			if($check_ext_id){
				return $this->_update ( $row, $tablename, ' record_id =  ' .$row['record_id'] , 1);
			}else{
				return $this->_add ( $row, $tablename );
			}
			
		}
		return;
	}


	function get_product_tables(){
		global $db;
		$query = "SELECT DISTINCT(a.table_name) FROM fs_products_tables as a ";
					  
		$db->query($query);
		$list = $db->getObjectList();
		foreach ($list as $item) {
			$item->created_table = $db-> checkExistTable($item->table_name);
		}
		return $list;
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

	function save_new_price__($record_id) {
		// die;
		$price_min = FSInput::get ( 'price',0,'money' );
		$price_old_min = FSInput::get ( 'price_old',0,'money' );
		$unit_min = FSInput::get ( 'unit');

		if (! $record_id)
			return true;
		global $db;
		for ( $i = 0; $i < 20; $i ++ ) {
			$row = array ();
			
			$row ['price'] = FSInput::get ( 'new_price_' . $i , 0, 'money' );			
			$row ['price_old'] = FSInput::get ( 'new_price_old_' . $i , 0, 'money' );
			$row ['unit'] = FSInput::get ( 'new_unit_' . $i );
			$row ['unit_band'] = FSInput::get ( 'new_unit_band_' . $i );
			if(!$row ['price'] ){
				$row ['price']  = $this ->  convert_price_standart($row ['unit'],$price_min,$unit_min);				
			}
			if(!$row ['price_old'] ){
				$row ['price_old']  = $this ->  convert_price_standart($row ['unit'],$price_old_min,$unit_min);
			}

			if(!$row ['unit'])
				continue;
			$row ['record_id'] = $record_id;
			// print_r($row);die;
			$rs = $this->_add ( $row, 'fs_products_prices', 0 );
		}
		return true;
	}


	function save_new_price($record_id, $price, $price_old) {
		// die;
		$price_min = FSInput::get ( 'price',0,'money' );
		$price_old_min = FSInput::get ( 'price_old',0,'money' );
		$unit_min = FSInput::get ( 'unit');

		if (! $record_id)
			return true;
		global $db;
		$row = array ();

		$row ['price'] = $price;	
		$row ['price_old'] = $price_old;

			// $row ['unit'] = FSInput::get ( 'new_unit_' . $i );
			// $row ['unit_band'] = FSInput::get ( 'new_unit_band_' . $i );

		// if(!$row ['price'] ){
		// 	$row ['price']  = $this ->  convert_price_standart($row ['unit'],$price_min,$unit_min);				
		// }
		// if(!$row ['price_old'] ){
		// 	$row ['price_old']  = $this ->  convert_price_standart($row ['unit'],$price_old_min,$unit_min);
		// }

			// if(!$row ['unit'])
			// 	continue;

		// print_r($row);die;
		$item_price = $this-> get_record('record_id = '.$record_id,'fs_products_prices');
		if(!empty($item_price)) {
			$rs = $this->_update ( $row, 'fs_products_prices', 'record_id = '.$record_id );
		} else {
			$row ['record_id'] = $record_id;
			// print_r($row);die;
			$rs = $this->_add ( $row, 'fs_products_prices', 0 );
		}

		return true;
	}



	function save_history($old_record) {
		if (! $old_record)
			return;
		$user_group = $_SESSION ['ad_groupid'];
		$user_id = $_SESSION ['ad_userid'];
		$username = $_SESSION ['ad_username'];
		//			$fullname = $_SESSION['cms_fullname'];
		

		$fields_in_table = $this->get_field_table (  FSTable_ad::_ ('fs_products_history') );
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
		$row ['record_id'] = $old_record->id; // synchronize
		$row ['action_time'] = $time; // synchronize
		$row ['action_username'] = $username; // synchronize
		$row ['action_id'] = $user_id; // synchronize
		//			$row['action_name'] = $fullname;// synchronize
		$this->_add ( $row,  FSTable_ad::_ ('fs_products_history'), 1 );
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
		WHERE record_id = $product_id 
		ORDER BY ordering ASC, image ASC ";
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}

	function get_product_slideshow_highlight($product_id) {
		if (! $product_id)
			return;
		$query = " SELECT *
		FROM fs_products_slideshow_highlight
		WHERE record_id = $product_id
		ORDER BY ordering ASC, image ASC ";
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
		if (empty( $extend_fields))
			return array ();
		$data_foreign = array ();
		foreach ( $extend_fields as $field ) {
			if ($field->field_type == 'foreign_one' || $field->field_type == 'foreign_multi') {
				$table_name = $field->foreign_tablename;
				$data_foreign [$field->field_name] = $this->get_records ( 'group_id = ' . $field->foreign_id, FSTable_ad::_ ('fs_extends_items') );
			}
		}
		return $data_foreign;
	}
	function get_data_for_export() {
		// ordering
		global $db;
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
				$where .= ' AND a.category_id_wrapper like   "%,' . $filter . ',%" ';
			}
		}
		// lọc loại sản phẩm
		if (isset ( $_SESSION [$this->prefix . 'filter2'] )) {
			$filter = $_SESSION [$this->prefix . 'filter2'];
			if ($filter) {
				$where .= ' AND a.types like   "%,' . $filter . ',%" ';
			}
		}
		
		// SP nổi bật
		if (isset ( $_SESSION [$this->prefix . 'filter3'] )) {
			$filter = $_SESSION [$this->prefix . 'filter3'];
			if ($filter) {
				if($filter == 1)
					$where .= ' AND a.is_hot = 1';
				else 
					$where .= ' AND a.is_hot != 1';
			}

		}
		// lọc loại sản phẩm
		if (isset ( $_SESSION [$this->prefix . 'filter1'] )) {
			$filter = $_SESSION [$this->prefix . 'filter1'];
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

		$limit = '';
		$text0 = 0;

		$export_from = FSInput::get('export_from',0,'int');
		$export_to = FSInput::get('export_to',1,'int');

		
		
		if(!$export_to || $export_from > $export_to){
			return;
		}
		// lọc loại sản phẩm
		if (isset ($export_to )) {
			$limit .= ' LIMIT '.$export_from;
			
		}
		if ($export_to) {				
			$limit .= ','.($export_to - $export_from);			
		}

		
		$query = " SELECT a.* FROM " . $this->table_name . " AS a WHERE 1=1 " . $where . $ordering . " " . $limit;

		$sql = $db->query ( $query );
		
		$result = $db->getObjectList();
		
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
		WHERE published = 1 AND is_trash = 0 AND id IN (0".$product_related."0) 
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
		$where = ' WHERE published = 1 AND is_trash = 0 ';
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
	 // function get_products_compatable($product_compatable){
	 // 	if(!$product_compatable)
	 // 		return;
	 // 	$query   = " SELECT id, name 
	 // 	FROM fs_products
	 // 	WHERE id IN (".$product_compatable.") 
	 // 	ORDER BY POSITION(','+id+',' IN '".$product_compatable."')
	 // 	";
	 // 	global $db;
	 // 	$sql = $db->query($query);
	 // 	$result = $db->getObjectList();
	 // 	return $result;
	 // }

	 function get_products_compatable($product_id){
	 	if(!$product_id)
	 		return;
	 	$query   = " SELECT *
	 	FROM fs_products_compatables
	 	WHERE product_id = $product_id
	 	ORDER BY ordering ASC
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

	 	$query_body = ' FROM fs_products AS a '.$where;
	 	$ordering = " ORDER BY created_time DESC , id DESC ";
	 	$query = ' SELECT a.id,a.category_id,a.name,a.category_name, a.price, a.price_old'.$query_body.$ordering.' LIMIT 40 ';
	 	global $db;
	 	$sql = $db->query($query);
	 	$result = $db->getObjectList();
	 	return $result;
	 }


	/*
	 *====================AJAX compatable PRODUCTS end.==============================
	 */
 /*
		 *==================== AJAX compare PRODUCTS==============================
		 */
 function get_products_compare($product_compare){
 	if(!$product_compare)
 		return;
 	$query   = " SELECT id, name 
 	FROM fs_products
 	WHERE id IN (".$product_compare.") 
 	ORDER BY POSITION(','+id+',' IN '".$product_compare."')
 	";
 	global $db;
 	$sql = $db->query($query);
 	$result = $db->getObjectList();
 	return $result;
 }
 function ajax_get_products_compare(){
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
	 *====================AJAX compare PRODUCTS end.==============================
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
			$row2 = array();
			$id_exist = FSInput::get ( 'id_exist_' . $item );
			$row ['record_id'] = $record_id;
			$color = $this->get_record_by_id ( $item, 'fs_products_colors' );
			$row ['color_id'] = $item;
			$row ['color_code'] =$color->code;
			$row ['color_name'] =$color->name;
			$row ['price'] = FSInput::get ( 'color_price_exist_' . $item );
			$row ['image'] = FSInput::get ( 'name_price_exist_' . $item );
			$row ['is_default'] = FSInput::get ( 'color_default_exist_' . $item );
			$u = $this->_update ( $row, 'fs_products_price', ' id=' . $id_exist );
			//update màu mặc định sang tab bảng ảnh
			$check_image_default = $this->get_record('record_id = ' . $record_id . ' AND color_id = ' . $item,'fs_products_images');

			if(!empty($check_image_default)){
				$row2['is_default'] = $row ['is_default'];
				$rs2 = $this->_update ( $row2, 'fs_products_images', ' id=' . $check_image_default-> id );
			}

			

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
			$row ['is_default'] = FSInput::get ( 'new_color_default_' . $item );
			$upload_area = "other_image_" . $item;
			if ($_FILES [$upload_area] ["name"]) {
				$image = $this->upload_image ( $upload_area, '_' . time (), 2000000, $this->arr_img_paths_other );
				$row ['image'] = $image;
			}

			// printr($row);
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

	function save_exist_extend($record_id) {
		
		$rs = 0;	
		global $db;
		// Thay doi du lieu da nhap 
		$other_extend_exit= FSInput::get('other_extend_exit',array(),'array');	
		foreach ($other_extend_exit as $item){
			$id_exist = FSInput::get ( 'id_extend_exist_' . $item );
			$row ['record_id'] = $record_id;
			$extend = $this->get_record_by_id ( $item, 'fs_extends_items' );
			$row ['extend_id'] = $item;
			$row ['extend_name'] =$extend->name;
			$row ['extend_alias'] =$extend->alias;

			$group_extend = $this->get_record_by_id ( $extend-> group_id, 'fs_extends_groups' );
			$row ['group_extend_id'] = $group_extend-> id;
			$row ['ground_extend_name'] =$group_extend->name;
			$row ['price'] = FSInput::get ( 'extend_price_exist_' . $item );
			$row ['is_default'] = FSInput::get ( 'extend_default_exist_' . $item );
			
			$u = $this->_update ( $row, 'fs_products_price_extend', ' id=' . $id_exist );
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
			//$row ['memory_alias'] =$memory->alias;
			$row ['price'] = FSInput::get ( 'new_memory_price_' . $item );
			$rs = $this->_add ( $row, 'fs_memory_price', 0 );
		}
		return true;
	}	

	function save_new_extend($record_id) {
		if (! $record_id)
			return true;
		$other_extend = FSInput::get('other_extend',array(),'array');	
		global $db;
		foreach($other_extend as $item){
			$row = array ();
			$row ['record_id'] = $record_id;
			$extend = $this->get_record_by_id ( $item, 'fs_extends_items' );
			$row ['extend_id'] = $item;
			$row ['extend_name'] =$extend->name;
			$row ['extend_alias'] =$extend->alias;
			$group_extend = $this->get_record_by_id ( $extend-> group_id, 'fs_extends_groups' );
			$row ['group_extend_id'] = $group_extend-> id;
			$row ['ground_extend_name'] =$group_extend->name;
			$row ['price'] = FSInput::get ( 'new_extend_price_' . $item );
			$row ['is_default'] = FSInput::get ( 'new_extend_default_' . $item );
			//print_r($row);
			//die();
			$rs = $this->_add ( $row, 'fs_products_price_extend', 0 );
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

	function remove_extend($record_id) {
		
		$rs = 0;	
		global $db;
		
		$other_extend_exit= FSInput::get('other_extend_exit',array(),'array');	
		$str_other_extend = implode ( ',', $other_extend_exit );
		$whewe ='';
		if ($str_other_extend) {
			$whewe .=' AND extend_id NOT IN ('.$str_other_extend.')';
		}
	// remove in database
		$sql = " DELETE FROM fs_products_price_extend
		WHERE record_id = ".$record_id."".
		$whewe;
		$db->query ( $sql );
		$rows = $db->affected_rows ();
		return $rows;

		

		// END EXIST FIELD
	}


	/***********************************/
	function save_exist_usage_states($record_id) {
		
		$rs = 0;	
		global $db;
		// Thay doi du lieu da nhap 
		$other_usage_states_exit= FSInput::get('other_usage_states_exit',array(),'array');	
		foreach ($other_usage_states_exit as $item){
			$id_exist = FSInput::get ( 'id_usage_states_exist_' . $item );
			$row ['record_id'] = $record_id;
			$usage_states = $this->get_record_by_id ( $item, 'fs_usage_states' );
			$row ['usage_states_id'] = $item;
			$row ['usage_states_name'] =$usage_states->name;
			$row ['price'] = FSInput::get ( 'usage_states_price_exist_' . $item );
			
			$u = $this->_update ( $row, 'fs_usage_states_price', ' id=' . $id_exist );
			if ($u)
				$rs ++;
			
		}
		return $rs;

		// END EXIST FIELD
	}
	function save_new_usage_states($record_id) {
		if (! $record_id)
			return true;
		$other_usage_states = FSInput::get('other_usage_states',array(),'array');	
		// print_R($_REQUEST);
		// print_r($other_usage_states);
		global $db;
		foreach($other_usage_states as $item){
			
			$row = array ();
			$row ['record_id'] = $record_id;
			$usage_states = $this->get_record_by_id ( $item, 'fs_usage_states' );
			$row ['usage_states_id'] = $item;
			$row ['usage_states_name'] =$usage_states->name;
			$row ['price'] = FSInput::get ( 'new_usage_states_price_' . $item );
			$rs = $this->_add ( $row, 'fs_usage_states_price', 0 );
		}
		return true;
	}	
	function remove_usage_states($record_id) {
		
		$rs = 0;	
		global $db;
		
		$other_usage_states_exit= FSInput::get('other_usage_states_exit',array(),'array');	
		$str_other_usage_states = implode ( ',', $other_usage_states_exit );
		$whewe ='';
		if ($str_other_usage_states) {
			$whewe .=' AND usage_states_id NOT IN ('.$str_other_usage_states.')';
		}
	// remove in database
		$sql = " DELETE FROM fs_usage_states_price
		WHERE record_id = ".$record_id."".
		$whewe;
		$db->query ( $sql );
		$rows = $db->affected_rows ();
		return $rows;

		

		// END EXIST FIELD
	}

	/***********************************/
	function save_exist_regions($record_id) {
		
		$rs = 0;	
		global $db;
		// Thay doi du lieu da nhap 
		$other_regions_exit= FSInput::get('other_regions_exit',array(),'array');	
		foreach ($other_regions_exit as $item){
			$id_exist = FSInput::get ( 'id_regions_exist_' . $item );
			$row ['record_id'] = $record_id;
			$regions = $this->get_record_by_id ( $item, 'fs_locations_regions' );
			$row ['region_id'] = $item;
			$row ['region_name'] =$regions->name;
			$row ['price'] = FSInput::get ( 'regions_price_exist_' . $item );
			
			$u = $this->_update ( $row, 'fs_products_regions_price', ' id=' . $id_exist );
			if ($u)
				$rs ++;
			
		}
		return $rs;

		// END EXIST FIELD
	}
	function save_new_regions($record_id) {
		if (! $record_id)
			return true;
		$other_regions = FSInput::get('other_regions',array(),'array');	
		
		global $db;
		foreach($other_regions as $item){
			
			$row = array ();
			$row ['record_id'] = $record_id;
			$region = $this->get_record_by_id ( $item, 'fs_locations_regions' );
			$row ['region_id'] = $item;
			$row ['region_name'] =$region->name;
			$row ['price'] = FSInput::get ( 'new_regions_price_' . $item );
			$rs = $this->_add ( $row, 'fs_products_regions_price', 0 );
		}
		return true;
	}	
	function remove_regions($record_id) {
		
		$rs = 0;	
		global $db;
		
		$other_regions_exit= FSInput::get('other_regions_exit',array(),'array');	
		$str_other_regions = implode ( ',', $other_regions_exit );
		$whewe ='';
		if ($str_other_regions) {
			$whewe .=' AND region_id NOT IN ('.$str_other_regions.')';
		}
	// remove in database
		$sql = " DELETE FROM fs_products_regions_price
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
	// function get_product_images_plus($record_id) {
	// 	if (! $record_id)
	// 		return;
	// 	$query = " SELECT image,id,content
	// 					FROM fs_products_images_plus
	// 					WHERE record_id = $record_id";
	// 	global $db;
	// 	$sql = $db->query ( $query );
	// 	$result = $db->getObjectList ();
	// 	return $result;
	// }
	// function remove_images_plus($record_id) {

	// 	$rs = 0;	
	// 	global $db;

	// 	$other_image_plus= FSInput::get('other_image_plus',array(),'array');	
	// 	$str_other_images_plus = implode ( ',', $other_image_plus );

	// 	if ($str_other_images_plus) {
	// 		$whewe .=' AND id  IN ('.$str_other_images_plus.')';



	// 		$query = " SELECT image 
	// 						FROM fs_" . $this->type . "_images_plus
	// 						WHERE record_id = $record_id
	// 						$whewe
	// 						";
	// 		$sql = $db->query ( $query );
	// 		$images_need_remove = $db->getObjectList ();
	// 		$fsFile = FSFactory::getClass ( 'FsFiles', '' );
	// 			$arr_img_paths = $this->arr_img_paths_other_plus;
	// 			foreach ( $images_need_remove as $item ) {

	// 				if ($item->image) {
	// 					$path = PATH_BASE.$item->image;
	// 					$path = str_replace ( '/', DS, $path );
	// 					$fsFile->remove_file_by_path ( $path );
	// 					if (count ( $arr_img_paths )) {
	// 						foreach ( $arr_img_paths as $item ) {
	// 							$path_resize = str_replace ( DS . 'original' . DS, DS . $item [0] . DS, $path );
	// 							$fsFile->remove_file_by_path ( $path_resize );
	// 						}
	// 					}
	// 				}
	// 			}
	// 		// remove in database
	// 		$sql = " DELETE FROM fs_products_images_plus
	// 					WHERE record_id = ".$record_id."".
	// 						$whewe;
	// 		$db->query ( $sql );
	// 		$rows = $db->affected_rows ();
	// 		return $rows;
	// 	// END EXIST FIELD
	// 	}
	// }
	// function save_exist_images_plus($record_id) {

	// 	$rs = 0;	
	// 	global $db;
	// 	// Thay doi du lieu da nhap 
	// 	$other_color_exit= FSInput::get('image_plus_exist_total',array(),'array');	
	// 	foreach ($other_color_exit as $item){
	// 		$row ['record_id'] = $record_id;
	// 		$row ['content'] = FSInput::get ( 'content_plus_exit_' . $item );
	// 		$row ['image'] = FSInput::get ( 'name_image_plus_exist_' . $item );
	// 		$upload_area_exit = "image_plus_exit_" . $item;

	// 		if ($_FILES [$upload_area_exit] ["name"]) {

	// 			$image_exit = $this->upload_image ( $upload_area_exit, '_' . time (), 2000000, $this->arr_img_paths_other_plus );
	// 			$row ['image'] = $image_exit;
	// 		}

	// 		$u = $this->_update ( $row, 'fs_products_images_plus', ' id=' . $item );
	// 		if ($u)
	// 			$rs ++;

	// 	}
	// 	return $rs;
	
	// 	// END EXIST FIELD
	// }
	// function save_new_images_plus($record_id) {
	// 	if (! $record_id)
	// 		return true;
	// 	global $db;
	// 	for($i = 0; $i < 5; $i ++) {

	// 		$row = array ();

	// 		$upload_area = "new_image_plus_" . $i;
	// 		if ($_FILES [$upload_area] ["name"]) {
	// 			$image = $this->upload_image ( $upload_area, '_' . time (), 2000000, $this->arr_img_paths_other_plus );
	// 			$row ['image'] = $image;
	// 			$row ['record_id'] = $record_id;
	// 			$row ['content'] = FSInput::get ( 'new_content_plus_'.$i );
	// 			$rs = $this->_add ( $row, 'fs_products_images_plus', 0 );
	// 		}
	// 	}
	// 	return true;
	// }	

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
	function remove_compare(){
		$id = FSInput::get('id',0,'int');
		$product_compare_id = FSInput::get('product_compare_id',0,'int');
		if(!$id || !$product_compare_id)	
			return;

		$sql = " SELECT products_compare 
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
			if($item != $product_compare_id){
				if($i > 0)
					$str .= ',';
				$str .= $item;
				$i ++;
			}
		}	
		$row['products_compare'] = $str;
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


function is_hotdeal($value)
{
	$ids = FSInput::get('id',array(),'array');

	if(count($ids))
	{
		global $db;
		$str_ids = implode(',',$ids);
		$sql = " UPDATE ".$this -> table_name."
		SET is_hotdeal = $value
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
		 * value: == 1 :new
		 * value  == 0 :unnew
		 * published record
		 */
		function is_feed($value)
		{
			
			$ids = FSInput::get('id',array(),'array');
			
			if(count($ids))
			{
				global $db;
				$str_ids = implode(',',$ids);
				$sql = " UPDATE ".$this -> table_name."
				SET is_feed = $value
				WHERE id IN ( $str_ids ) " ;
				
				// $db->query($sql);
				$rows = $db->affected_rows($sql);
				return $rows;
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

		/********IMAGE*****/
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

	$fsFile = FSFactory::getClass('FsFiles');
	
	if($this->image_watermark){
		$fsFile->add_logo($path,$file_name,PATH_BASE.str_replace('/',DS, 'images/mask/mask_large.png'),$this->image_watermark_pos);
	}	

	if (is_string ( $file_name ) and $file_name != '' and ! empty ( $this->arr_img_paths_other )) {
		$image_new = basename ( $file_name );
		$fsFile = FSFactory::getClass ( 'FsFiles' );
		foreach ( $this->arr_img_paths_other as $item ) {

			$path_resize = str_replace ( DS . 'original' . DS, DS . $item [0] . DS, $path );
			$path_resize = str_replace('upload_images/','',$path_resize);
			$fsFile->create_folder ( $path_resize );
			$method_resize = $item [3] ? $item [3] : 'resized_not_crop';
			$fsFile->$method_resize ( $path . $file_name, $path_resize . $file_name, $item [1], $item [2] );

			$file_ext = $fsFile -> getExt($image_new);
			$fsFile -> convert_to_webp($path_resize.$image_new,$file_ext);
		}
	}
	$data = base64_decode ( FSInput::get ( 'data' ) );
	$data = explode ( '|', $data );
	$row = array ();
	if ($data [0] == 'add')
		$row ['session_id'] = $data [1];
	else
		$row ['record_id'] = $data [1];
	$row ['image'] = str_replace('upload_images/','',$this->img_folder) . '/original/' . $file_name;
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
		$check_image_default = $this->get_record('record_id = ' . $data [1] . ' AND color_id = ' . $value,'fs_products_price');

		if ($field == 'color') {
			$row ['color_id'] = $value;
			if(!empty($check_image_default->is_default)){
				$row ['is_default'] = $check_image_default-> is_default;
			}
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
					@unlink ( str_replace ( '/original/', '/' . $image [0] . '/', $path ).'.webp' );
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

	/********SLIDESHOW HIGHLIGHT*****/

	/**
	 * Lấy danh sách ảnh
	 * 
	 * @return Object list
	 */
	function get_other_slideshow_highlight() {
		$data = base64_decode ( FSInput::get ( 'data' ) );
		$data = explode ( '|', $data );
		$where = 'record_id = ' . $data [1];
		if ($data [0] == 'add')
			$where = 'session_id = \'' . $data [1] . '\'';
		global $db;
		$query = '  SELECT *
		FROM ' . 'fs_' . $this->type . '_slideshow_highlight' . ' 
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
function upload_other_slideshow_highlight() {
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
		$image_new = basename ( $file_name );
		foreach ( $this->arr_img_paths_other as $item ) {
			$path_resize = str_replace ( DS . 'original' . DS, DS . $item [0] . DS, $path );
			$fsFile->create_folder ( $path_resize );
			$method_resize = $item [3] ? $item [3] : 'resized_not_crop';
			$fsFile->$method_resize ( $path . $file_name, $path_resize . $file_name, $item [1], $item [2] );
			$file_ext = $fsFile -> getExt($image_new);
			$fsFile -> convert_to_webp($path_resize.$image_new,$file_ext);
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
	$rs = $this->_add ( $row, 'fs_' . $this->type . '_slideshow_highlight' );
	$row ['id'] = $rs;
	echo json_encode ( $row );
	return true;
}
	/**
	 * Sửa thuộc tính của ảnh
	 * 
	 * @return Bool
	 */
	function change_attr_slideshow_highlight() {
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
		// if ($field == 'color') {
		// 	$row ['color_id'] = $value;
		// }
		$rs = $this->_update ( $row, 'fs_' . $this->type . '_slideshow_highlight', ' id = ' . $id . $where );
		return $rs;
	}
	function delete_other_slideshow_highlight($record_id = 0) {
		global $db;
		if ($record_id)
			$where = 'record_id = \'' . $record_id . '\'';
		else {
			$id = FSInput::get ( 'id', 0 );
			$where = 'id = \'' . $id . '\'';
		}
		$query = '  SELECT *
		FROM fs_' . $this->type . '_slideshow_highlight
		WHERE ' . $where;
		$db->query ( $query );
		$listImages = $db->getObjectList ();
		if ($listImages) {
			foreach ( $listImages as $item ) {
				$query = '  DELETE FROM fs_' . $this->type . '_slideshow_highlight
				WHERE id = \'' . $item->id . '\'';
				$db->query ( $query );
				$path = PATH_BASE . $item->image;
				@unlink ( $path );
				foreach ( $this->arr_img_paths_other as $image ) {
					@unlink ( str_replace ( '/original/', '/' . $image [0] . '/', $path ) );
					@unlink ( str_replace ( '/original/', '/' . $image [0] . '/', $path ).'.webp' );

				}
			}
		}
	}
	
	function sort_other_slideshow_highlight() {
		global $db;
		if (isset ( $_POST ["sort"] )) {
			if (is_array ( $_POST ["sort"] )) {
				foreach ( $_POST ["sort"] as $key => $value ) {
					$db->query ( "UPDATE fs_" . $this->type . "_slideshow_highlight SET ordering = $key WHERE id = $value" );
				}
			}
		}
	}		/*
		 *==================== end. SLIDESHOW HIGHLIGHT==============================


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

		function getOrigins(){
			global $db;
			$query   = " SELECT *
			FROM fs_origin 
			WHERE published = 1";
			$db->query($query);
			$result = $db->getObjectList();
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

		function get_data_by_extend_price($extend_id,$record_id){
			global $db;
			if(!$extend_id)
				return false;
			
			$query   = " SELECT *
			FROM fs_products_price_extend 
			WHERE extend_id = ".$extend_id."
			AND record_id =".$record_id;
			$db->query($query);
			$result = $db->getObject();
			return $result;
		}

		function get_data_by_usage_states($usage_states_id,$record_id){
			global $db;
			if(!$usage_states_id)
				return false;
			
			$query   = " SELECT *
			FROM fs_usage_states_price 
			WHERE usage_states_id = ".$usage_states_id."
			AND record_id =".$record_id;
			$db->query($query);
			$result = $db->getObject();
			return $result;
		}
		function get_data_by_regions($region_id,$record_id){
			global $db;
			if(!$region_id)
				return false;
			
			$query   = " SELECT *
			FROM fs_products_regions_price 
			WHERE region_id = ".$region_id."
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

		// uploadAjaxVideoReview

		function uploadAjaxVideoReview() {
			$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
			$file_names = array();
			global $db;
			$path = PATH_BASE . $this->img_folder2 . '/original/';
			$upload = FSFactory::getClass ( 'FsFiles', '' );
			if (isset($_FILES['files_video_review']) && !empty($_FILES['files_video_review'])) {
				$no_files = count($_FILES["files_video_review"]['name']);
				for ($i = 0; $i < $no_files; $i++) {
					if ($_FILES["files_video_review"]["error"][$i] > 0) {
							//echo "Error: " . $_FILES["files"]["error"][$i] . "<br>";
					} else {
						$file_names[$i]  = $fsstring -> stringStandart2($_FILES["files_video_review"]["name"][$i]);
						$file_names[$i]  = str_replace('.', '_'.time().'.',$file_names[$i]);
						if (file_exists($path.$file_names[$i])) {
								//echo 'File already exists : '.$path.$file_names[$i]. "<br>";
						} else {
							move_uploaded_file($_FILES["files_video_review"]["tmp_name"][$i], $path.$file_names[$i]);
								//echo 'File successfully uploaded :'.$path. $file_names[$i] . "<br>";
						}

					}
				}
			} else {
				echo 'Please choose at least one file';
			}

			$upload->create_folder ( $path );
			foreach ($file_names as $file_name2 ) {
				$file_name =$fsstring-> stringStandart2($file_name2);
				$fsFile = FSFactory::getClass ( 'FsFiles' );
					# code..
				if (is_string ( $file_name ) and $file_name != '' and ! empty ( $this -> arr_img_paths_video_review )) {
					foreach ( $this -> arr_img_paths_video_review as $item ) {
						$path_resize = str_replace ( '/original/', '/' . $item [0] . '/', $path );
						$upload->create_folder ( $path_resize );
						$method_resize = $item [3] ? $item [3] : 'resized_not_crop';
						$upload->$method_resize ( $path . $file_name, $path_resize . $file_name, $item [1], $item [2] );
						// $file_ext = $fsFile -> getExt($file_name);
						// $fsFile -> convert_to_webp($path_resize.$file_name,$file_ext);
					}
				}
				$data = base64_decode ( FSInput::get ( 'data' ) );
				$data = explode ( '|', $data );
				$row = array ();
				if ($data [0] == 'add'){
					$row ['session_id'] = $data [1];
					$max_ordering = $this -> get_max_images_video_review('',$row ['session_id']);
				}else{
					$row ['record_id'] = $data [1];
					$max_ordering = $this -> get_max_images_video_review($row ['record_id']);
				}
				$row ['image'] = $this->img_folder2 . '/original/' . $file_name;
				$row ['ordering'] = $max_ordering;
				// $row ['title'] = FSInput::get ('title');
				// $row ['link'] = FSInput::get ('link');

				$rs = $this->_add ( $row, 'fs_products_video_review' );
			}
			return true;

		}

		function get_max_images_video_review($record_id,$session_id = ''){
			$where = '';
			if($record_id)
				$where .= ' record_id = '.$record_id.' ';
			else 
				$where .= ' session_id = "'.$session_id.'" ';
			if(!$where)
				return;
			$query = " SELECT Max(ordering)
			FROM fs_products_video_review
			WHERE $where
			";

			global $db;
			$sql = $db->query($query);
			$result = $db->getResult();
			if(!$result)
				return 1;
			return ($result + 1);
		}


		function getAjaxImagesVideoReview() {
			$data = base64_decode ( FSInput::get ( 'data' ) );
			$data = explode ( '|', $data );
			$where = 'record_id = ' . $data [1];
			if ($data [0] == 'add')
				$where = 'session_id = \'' . $data [1] . '\'';
			global $db;
			$query = '  SELECT *
			FROM fs_products_video_review 
			WHERE ' . $where . '
			ORDER BY ordering,  id DESC';
			$sql = $db->query ( $query );
			return $db->getObjectList ();
		}


		function deleteAjaxImagesVideoReview($record_id = 0) {
			global $db;
			if (isset($projects_id))
				$where = 'record_id = \'' . $projects_id . '\'';
			else {
				$data = FSInput::get ( 'data', 0 );
				$where = 'id = \'' . $data . '\'';
			}
			$query = '  SELECT *
			FROM fs_products_video_review
			WHERE ' . $where;
			$query;
			$db->query ( $query );

			$listImages = $db->getObjectList ();
			if ($listImages) {
				foreach ( $listImages as $item ) {
					$query = '  DELETE FROM fs_products_video_review
					WHERE id = \'' . $item->id . '\'';
					$db->query ( $query );
					$path = PATH_BASE . $item->image;
					@unlink ( $path );
					foreach ( $this->arr_img_paths_slideshow as $image ) {
						@unlink ( str_replace ( '/original/', '/' . $image [0] . '/', $path ) );
						@unlink ( str_replace ( '/original/', '/' . $image [0] . '/', $path.'.webp' ) );
					}
				}
			}
		}


		function sortAjaxImagesVideoReview() {
			global $db;
			$arr =  FSInput::get ( 'sort_item_video_review', array (), 'array' );
			if (!empty($arr)) {
				foreach ( $arr as $key => $value ) {
					$db->query ( "UPDATE fs_products_video_review SET ordering = $key WHERE id = $value" );
				}
			}
		}


		function addTitleAjaxImagesVideoReview($record_id = 0) {
			global $db;
			if ($record_id)
				$where = 'record_id = \'' . $record_id . '\'';
			else {
				$data = FSInput::get ( 'data', 0 );
				$where = 'id = ' . $data;
			}
			$row['title'] = FSInput::get ( 'titleimage' );
			$rs = $this->_update ( $row, 'fs_products_video_review',$where);
			return $rs;
		}


		function addLinkAjaxImagesVideoReview($record_id = 0) {
			global $db;
			if ($record_id)
				$where = 'record_id = \'' . $record_id . '\'';
			else {
				$data = FSInput::get ( 'data', 0 );
				$where = 'id = ' . $data;
			}
			$row['link'] = FSInput::get ( 'linkElement' );
			$rs = $this->_update ( $row, 'fs_products_video_review',$where);
			return $rs;
		}

		// END uploadAjaxVideoReview

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
					

					$row = array ();
					$row2 = array ();
					$row ['is_trash'] = 1;
					$row2 ['is_trash'] = 1; 
					$row2['eraser_id'] = $user_id;
					$row2['eraser_name'] = $username;
					$row2['eraser_time'] = date('Y-m-d H:i:s');
					$rs = $this->_update ( $row2, $this->table_name, '  id = ' . $item, 0 );
					if ($this->use_table_extend) {
						$record = $this->get_record ( 'id = ' . $item, $this->table_name );
						$table_extend = $record->tablename;
						// calculate filters:
						$arr_table_name_changed [] = $table_extend;
						global $db;
						if ($table_extend && $table_extend !='fs_products' && $db->checkExistTable ( $table_extend )) {
							$rs = $this->_update ( $row, $table_extend, '  record_id = ' . $item );
						}
					}
					$record_change_success ++;
				}
			}
			return $record_change_success;
		}


	}
?>