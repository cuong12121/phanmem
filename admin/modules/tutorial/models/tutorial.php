<?php
class TutorialModelsTutorial extends FSModels {
	var $limit;
	var $prefix;
	function __construct() {
		$this->limit = 50;
		$this->view = 'tutorial';
		
		//$this -> table_category_name = FSTable_ad::_ ('fs_news_categories');
		//$this->table_types = FSTable_ad::_('fs_news_types');
		$this->table_content = FSTable_ad::_('fs_tutorial_content');
		$this -> arr_img_paths = array(array('resized',400,267,'cut_image'),array('small',200,100,'cut_image'),array('large',800,600,'cut_image'),array('compress',1,1,'compress'));
		$this -> table_name = FSTable_ad::_ ('fs_tutorial');

		$this -> arr_img_paths_menu = array(array('resized',400,267,'cut_image'),array('small',80,80,'cut_image'),array('compress',1,1,'compress'));
		
		// config for save
		$cyear = date ( 'Y' );
		$cmonth = date ( 'm' );
		$cday = date ( 'd' );
		$this->img_folder = 'upload_images/images/tutorial/' . $cyear . '/' . $cmonth . '/' . $cday;
		$this->img_folder2 = 'images/tutorial/' . $cyear . '/' . $cmonth . '/' . $cday;
		$this->check_alias = 0;
		$this->field_img = 'image';
		$this -> field_except_when_duplicate = array(array('id','id'),array('alias','alias'));
		$this-> field_reset_when_duplicate = array ('comments_total');
		$this->use_table_extend = 1;
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
					setRedirect('index.php?module=tutorial&view=tutorial&task=add',FSText :: _('Tiêu đề đã tồn tại !'),'error');
					return false;
				}
				
			}else{
				$check_name = $this->get_result('title="'.$name.'" AND id != '.$id);
				if($check_name){
					setRedirect('index.php?module=tutorial&view=tutorial&task=edit&id='.$id,FSText :: _('Tiêu đề đã tồn tại !'),'error');
					return false;
				}
			}	



			// $category_id = FSInput::get('category_id',0,'int');
			// if (! $category_id) {
			// 	Errors::_ ( 'Bạn phải chọn danh mục' );
			// 	return;
			// }
		
			//$cat =  $this->get_record_by_id($category_id,FSTable_ad::_ ('fs_news_categories'));

			//$category_id_0n = $cat->id;

			// category and category_id_wrapper danh mục phụ
			//$category_id_wrapper = FSInput::get ( 'category_id_wrapper',array (), 'array');

			

			// $str_category_id = implode ( ',', $category_id_wrapper );

			// if ($str_category_id) {
			// 	$str_category_id = ',' . $str_category_id . ',';
			// }

			// $wrapper_id_all ="";
			// $wrapper_alias ="";
			// for($i = 0; $i < count($category_id_wrapper) ; $i ++)
			// { 
			// 	$item = $category_id_wrapper[$i];
			// 	$alias = $this -> get_record_by_id($item,'fs_news_categories','alias,list_parents');
			// 	$wrapper_id_all .= $alias->list_parents;
			// }
			
			// $str_dd= str_replace(',,', ',', $wrapper_id_all);
			// $array_id=$str_dd.$category_id_0n.',';
			// $array_wrap_id=explode(',',$array_id);
			// $array_id_emp=array_filter($array_wrap_id);
			// $arr_show=array_unique($array_id_emp);
			// for($j = 0 ; $j < count($array_id_emp); $j ++)
			// { 
			// 	$item = $array_id_emp[$j];
			// 	// $alias = $this -> get_record_by_id($item,'fs_news_categories','alias');
			// 	$wrapper_alias .= $alias->alias.',';
			// }
			// $array_wrap_alias=explode(',',$wrapper_alias);
			// $arr_show_alias=array_unique($array_wrap_alias);
			// $arr_show_count_alias=implode(',',$arr_show_alias);
			// $arr_show_count=implode(',',$arr_show);

			// $arr_list_parents = explode(',',$cat->list_parents);

			// unset($arr_list_parents[count($arr_list_parents) - 1]);
			// unset($arr_list_parents[0]);

			// // printr($arr_list_parents);
			
			// $array_merge = array_merge($arr_list_parents, $arr_show);

			// $array_merge = array_unique($array_merge, 0);
			// $str_show_count=implode(',',$array_merge);
			// // printr($str_show_count);

			// $str_show_count_alias = "";
			// foreach ($array_merge as $val) {
			// 	$get_alias = $this->get_record('id= ' .$val ,'fs_news_categories');
			// 	if($get_alias){
			// 		$str_show_count_alias .= $get_alias->alias . ',';
			// 	}
				
			// }

			if(!$id){
				$row ['creator_id'] = $_SESSION['ad_userid'];
			}
			
			//$row ['category_id_wrapper'] = ','.$str_show_count.',';
			//$row ['category_alias_wrapper'] = ','. $str_show_count_alias;

			// echo "<pre>";
			// print_r($row);
			// die;






			
			// $row ['category_id_wrapper'] = $cat->list_parents;
			// $row ['category_alias_wrapper'] = $cat->alias_wrapper;
		//$row ['category_name'] = $cat->name;
		//$row ['category_alias'] = $cat->alias;
		//$row ['category_published'] = $cat->published;

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


		// $tags = FSInput::get ('tags');
		// if($tags){
		// 	$str_tag = ',';
		// 	$row ['tags'] = $tags;
		// 	$tags_arr = explode(',',$tags);
		// 	if(!empty($tags_arr)){
		// 		foreach ($tags_arr as $tag_it) {
		// 			$get_tag = $this-> get_record('name = "'.$tag_it.'"' ,'fs_products_tags');
		// 			if(!empty($get_tag)){
		// 				$str_tag .= $get_tag->id.',';
		// 			}else{
		// 				$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
		// 				$row_tag = array();
		// 				$row_tag['name'] = $tag_it;
		// 				$row_tag['alias'] = $fsstring->stringStandart ($row_tag['name']);
		// 				$row_tag['published'] = 1;
		// 				$row_tag['created_time'] = date('Y-m-d H:i:s');
		// 				$row_tag['user_id'] = $_SESSION['ad_userid'];
		// 				$row_tag['user_name'] = $_SESSION['ad_username'];
		// 				$add_tag_id = $this-> _add($row_tag,'fs_products_tags',1);
		// 				$str_tag .= $add_tag_id.',';
		// 			}
		// 		}
		// 	}

		// 	$row ['tag_group'] = $str_tag;
		// }





		// related products
		// $record_relate = FSInput::get ( 'products_record_related', array (), 'array' );
		// $row ['products_related'] = '';
		// if (count ( $record_relate )) {
		// 	$record_relate = array_unique ( $record_relate );
		// 	$row ['products_related'] = ',' . implode ( ',', $record_relate ) . ',';
		// }
		

		$record_news_relate = FSInput::get ( 'news_record_related', array (), 'array' );
		$row ['news_related'] = '';
		if (count ( $record_news_relate )) {
		 	$record_news_relate = array_unique ( $record_news_relate );
		 	$row ['news_related'] = ',' . implode ( ',', $record_news_relate ) . ',';
		}

		$record_aq_relate = FSInput::get ( 'aq_record_related', array (), 'array' );
		$row ['aq_related'] = '';
		if (count ( $record_aq_relate )) {
			$record_aq_relate = array_unique ( $record_aq_relate );
			$row ['aq_related'] = ',' . implode ( ',', $record_aq_relate ) . ',';
		}

		$result_id = parent::save ($row);


		$fsstring = FSFactory::getClass('FSString','','../');

		if($result_id) {

			//thêm mới
			for ($k=0; $k <10; $k++) { 

				$title2 = FSInput::get('title_'.$k,0,'');
				$title_core = FSInput::get('title_core_'.$k,0,'');
				$is_title = FSInput::get('is_title_'.$k,0,'');
				$is_menu = FSInput::get('is_menu_'.$k,0,'');
				$title_menu = FSInput::get('title_menu_'.$k,0,'');

				$description2 = FSInput::get('des_'.$k,0,'');

				$types = FSInput::get('types_'.$k,0,'');
				$range = FSInput::get('range_'.$k,0,'');

				$color = FSInput::get('color_'.$k,0,'');
				$background = FSInput::get('background_'.$k,0,'');

				$is_curved = FSInput::get('is_curved_'.$k,0,'');
				$color_curved = FSInput::get('color_curved_'.$k,0,'');


				$ordering = FSInput::get('ordering_'.$k,0,'');
				$published = FSInput::get('published_'.$k,0,'');


				if($published =='on'){
					$published = 1;			
				}
				if($is_menu =='on'){
					$is_menu = 1;			
				}
				if($is_title =='on'){
					$is_title = 1;			
				}
				if($is_curved =='on'){
					$is_curved = 1;			
				}

				$row2['title'] = $title2;
				$row2['title_core'] = $title_core;
				$row2['is_menu'] = $is_menu;
				$row2['is_title'] = $is_title;
				$row2['title_menu'] = $title_menu;
				$row2['description'] = str_replace('"',"'",$description2);
				$row2['types'] = $types;
				$row2['range'] = $range;
				$row2['color'] = $color;
				$row2['background'] = $background;
				$row2['is_curved'] = $is_curved;
				$row2['color_curved'] = $color_curved;
				$row2['ordering'] = $ordering;
				$row2['published'] = $published;

				
				$row2['record_id'] = $id ;
				$row2['alias'] = $fsstring -> stringStandart($title2);
				// printr($row2);
				if($title2) {
					$id_detail = $this -> _add($row2,$this->table_content,0);
				}

			}
			//update
			$sumc = FSInput::get('sumc',0,'int');
			if($sumc) {
				for ($j=0; $j <$sumc; $j++) { 
					// $name = FSInput::get('cname_'.$j,0,'');
					$title = FSInput::get('ctitle_'.$j,0,'');
					$title = str_replace('\"','"', $title);
					$title = str_replace("\'","'", $title);
					$description = FSInput::get('cdes_'.$j,0,'');				
					$cid = FSInput::get('cid_'.$j,0,'int');


					$title_core = FSInput::get('ctitle_core_'.$j,0,'');
					$is_title = FSInput::get('cis_title_'.$j,0,'');
					$is_menu = FSInput::get('cis_menu_'.$j,0,'');
					$title_menu = FSInput::get('ctitle_menu_'.$j,0,'');
					
					$types = FSInput::get('ctypes_'.$j,0,'');

					$range = FSInput::get('crange_'.$j,0,'');
					$color = FSInput::get('ccolor_'.$j,0,'');

					$background = FSInput::get('cbackground_'.$j,0,'');

					$is_curved = FSInput::get('cis_curved_'.$j,0,'');
					$color_curved = FSInput::get('ccolor_curved_'.$j,0,'');

				
					$ordering = FSInput::get('cordering_'.$j,0,'');
					$published = FSInput::get('cpublished_'.$j,0,'');


					if($published =='on'){
						$published = 1;			
					}
					if($is_menu =='on'){
						$is_menu = 1;			
					}
					if($is_title =='on'){
						$is_title = 1;			
					}
					if($is_curved =='on'){
						$is_curved = 1;			
					}
					

					$row3['title'] = $title;
					$row3['alias'] = $fsstring -> stringStandart($title);

					$row3['title'] = $title;
					$row3['title_core'] = $title_core;
					$row3['is_menu'] = $is_menu;
					$row3['is_title'] = $is_title;
					$row3['title_menu'] = $title_menu;
					$row3['types'] = $types;
					$row3['range'] = $range;
					$row3['color'] = $color;
					$row3['background'] = $background;
					$row3['is_curved'] = $is_curved;
					$row3['color_curved'] = $color_curved;
					$row3['ordering'] = $ordering;
					$row3['published'] = $published;
					

					$row3['description'] = $description;
					// printr($row3);
					if($title) {
						$this -> _update($row3,$this->table_content,'id ='.$cid,0);	
					}
				}
			}

			$old_record = $this->get_record_by_id ( $result_id );
			$this->save_history ( $old_record );
		}
		return $result_id;
	}
	
	/*
		 * select in category of home
		 */
	// function get_categories_tree() {
	// 	global $db;
	// 	$query = " SELECT a.*
	// 	FROM 
	// 	" . $this->table_category_name . " AS a
	// 	ORDER BY ordering ";
	// 	$result = $db->getObjectList ( $query );
	// 	$tree = FSFactory::getClass ( 'tree', 'tree/' );
	// 	$list = $tree->indentRows2 ( $result );
	// 	return $list;
	// }

	function duplicate(){
		$ids = FSInput::get('id',array(),'array');
		$rs = 0;
		$field_except = $this -> field_except_when_duplicate;
		$arr_fields_reset = $this -> field_reset_when_duplicate; // các trường không duplicate dữ liệu sang
		$time = date('Y-m-d H:i:s');
			
		if(count($ids)){
			global $db;
			$str_ids = implode(',',$ids);
			$records  = $this -> get_records(' id IN ('.$str_ids.')' ,$this -> table_name );
			if(!count($records))
				return false;

			// echo '<pre>';
			// print_r($records);
			// die;

			foreach($records as $item){
				$row = array();
				$field_key1 = 'name'; // title or name
				$key1 = ''; // title or name
				$key2 = ''; // alias
				$suffix_new = '';
				foreach($item as $key => $value){
					if($key == 'id' || (isset($this -> field_img) && $key == $this -> field_img) ) {
						continue;
					}
					if($key == 'name' || $key == 'title'){
						$key1 = $value;
						$field_key1 = $key;
						continue;
					}
					if($key == 'alias'){
						$key2 = $value;
						continue;
					}
					// if($key == 'code'){
					// 	$key3 = $value;
					// 	continue;
					// }
					if($key == 'edited_time' || $key == 'created_time' || $key == 'updated_time'){
						$row[$key]  =   $time;	
						continue;
					}
					if($key == 'action_username'){
						$username = $_SESSION ['ad_username'];						
						$row[$key] =   $username;	
					}



					if(in_array($key,$arr_fields_reset)){
						//echo $key;
						//die;
						$row[$key]  =   null;	
						continue;
					}
					
					$row[$key] = $value;
				}

				// echo '<pre>';
				// print_r($row);
				// die;


				if(!$key1)
					continue;
				$j = 0;

				while(true)	{
					if(!$j){
						$key1_copy = $key1.' copy';
						$key2_copy = $key2.'-copy';
						//$key3_copy = $key3.'-copy';
						$suffix_new = '-copy';
					} else { 
						$key1_copy = $key1.' copy '.$j;
						$key2_copy = $key2.'-copy-'.$j;
						//$key3_copy = $key3.'-copy-'.$j;
						$suffix_new = '-copy-'.$j;
					}

					//$where = $field_key1.' = "'.$db -> escape_string($key1_copy).'" OR alias = "'.$db -> escape_string($key2_copy).'" OR code = "'.$db -> escape_string($key3_copy).'"';
					$where = $field_key1.' = "'.$db -> escape_string($key1_copy).'" OR alias = "'.$db -> escape_string($key2_copy);

					$check_exist = $this -> get_count($where,$this -> table_name);


					if(!$check_exist){
						$row[$field_key1]= 	$key1_copy;			
						$row['alias']	= 	$key2_copy;
						//$row['code']	= 	$key3_copy;		
						break;
					}
					$j ++;
				}


			
				// duplicate image
				if(isset($this -> field_img) && $suffix_new){
					$field_img = $this -> field_img;
					// echo $item -> $field_img;
					// die;

					$link_img = $this -> duplicate_image('upload_images/'.$item -> $field_img, $suffix_new);
					if($link_img)
						$link_img = str_replace('upload_images/','',$link_img);
						$row[$field_img] = $link_img;


				}

				// echo $row[$field_img];
				// die;
				$new_record_id = $this -> _add($row, $this -> table_name,1);

				// echo $row[$field_img];
				// die;

				if($new_record_id){
					//$row2 = array();
					//$new_record = $this -> get_record(' id = '.$new_record_id ,$this -> table_name );
					// except : wrapper_alias, list_parents
					// if($field_except && count($field_except)){
					// 	foreach($field_except as $f){
					// 		$row2[$f[0]] = str_replace(','.$item -> $f[1].','  ,  ','.$new_record -> $f[1].',' , $row[$f[0]]);				
					// 	}
					// 	$this -> _update($row2, $this -> table_name, ' id = '.$new_record_id);
					// }
					// echo 'a';
					// die;
					
					// duplicate data extend
					if($this -> use_table_extend){

						$row3 = array();
//							$row3 = $row;
						//unset($row3['tablename']);

						$row3['record_id'] = $new_record_id;

						//$table_extend = $item -> tablename;
						$table_extend = $this -> table_content;
						// for caculator filters
						$arr_table_name_changed[] = $table_extend;
						
						if($table_extend && $table_extend != 'fs_products' && $db -> checkExistTable($table_extend)){

							$record_extend = $this -> get_records('record_id = '.$item -> id,$table_extend);

							// echo  '<pre>';
							// print_r($record_extend);
							// die;

							foreach($record_extend as $field_ext_name => $field_ext_value){

								

								// if(isset($row3[$field_ext_name]) || $field_ext_name == 'id')
								// 	continue;


								// echo  '<pre>';
								// print_r($field_ext_value);
								// die;
								$row5 = array();
								foreach ($field_ext_value as $key5 => $value5) {								
									$row5[$key5] = $value5;
																											
								}
								unset($row5['id']);
								$row5['record_id'] = $new_record_id;

								$tt = $this -> _add($row5, $table_extend,1);

								
								// echo '<pre>';
								// //echo $key3;
								// print_r($row5);
								// die;
								// if($field_ext_name == 'alias'){
								// 	$row3[$field_ext_name] = $row['alias'];
								// 	continue;
								// }
								// if($field_ext_name == 'name'){
								// 	$row3[$field_ext_name] = $row['name'];
								// 	continue;
								// }
								
								// $row3[$field_ext_value] = $db -> escape_string($field_ext_value);
								// echo '<pre>';
								// print_r($row3);
								// die;
							}
							//if(!$this -> _add($row5, $table_extend))
							if(!$tt)
								continue;
						}
					}
					
					$rs ++;
				}
			}
			// 	update sitemap
			if($this -> call_update_sitemap){
				$this -> call_update_sitemap();
			}
			// calculate filters:
//				if($this -> calculate_filters){
//					$this -> caculate_filter($arr_table_name_changed);
//				}
			return $rs;
		}
		
		return 0;
	}
	function get_author()
	{
		global $db;
		$query = " SELECT a.*
		FROM 
		fs_tutorial_author AS a
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
		

		$fields_in_table = $this->get_field_table ( 'fs_tutorial_history' );
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
		$row ['tutorial_id'] = $old_record->id; // synchronize
		$row ['action_time'] = $time; // synchronize
		$row ['action_username'] = $username; // synchronize
		$row ['action_id'] = $user_id; // synchronize
		//			$row['action_name'] = $fullname;// synchronize
		$this->_add ( $row, 'fs_tutorial_history', 1 );
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
						$cat = $this->get_record_by_id ( $field_value_new, 'fs_tutorial_categories' );
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
	function get_aq_categories_tree() {
		global $db;
		$sql = " SELECT id, name, parent_id AS parent_id 
		FROM fs_aq_categories
		ORDER BY ordering ASC ";
		$categories = $db->getObjectList ( $sql );
		
		$tree = FSFactory::getClass ( 'tree', 'tree/' );
		$rs = $tree->indentRows ( $categories, 1 );
		return $rs;
	}
	function ajax_get_aq_related() {
		$news_id = FSInput::get ( 'aq_id', 0, 'int' );
		$category_id = FSInput::get ( 'category_id', 0, 'int' );
		$keyword = FSInput::get ( 'keyword' );
		$where = ' WHERE published = 1 ';
		if ($category_id) {
			$where .= ' AND (category_id_wrapper LIKE "%,' . $category_id . ',%"	) ';
		}
		$where .= " AND ( title LIKE '%" . $keyword . "%' OR alias LIKE '%" . $keyword . "%' )";
		
		$query_body = ' FROM fs_aq ' . $where;

		$ordering = " ORDER BY created_time DESC , id DESC ";
		$query = ' SELECT id,category_id,title,category_name ' . $query_body . $ordering . ' LIMIT 40 ';
		global $db;
		$result = $db->getObjectList ( $query );
		return $result;
	}
	

	function get_aq_related($aq_related) {
		if (! $aq_related)
			return;
		$query = " SELECT id, title 
		FROM fs_aq
		WHERE id IN (0" . $aq_related . "0) 
		ORDER BY POSITION(','+id+',' IN '0" . $aq_related . "0')
		";
		global $db;
		$result = $db->getObjectList ( $query );
		return $result;
	}
	function remove_cache() {
		
		// $this -> remove_memcached();
		$fsCache = FSFactory::getClass ( 'FSCache' );
		
		$module_rm = 'tutorial';
		$view_rm = 'tutorial';
		$ids = FSInput::get ( 'id', array (), 'array' );
		
		$data = $this->get_record_by_id ( isset ( $ids [0] ) ? $ids [0] : 0 );
		if (! $data)
			return;
		
		$link_detail = FSRoute::_ ( 'index.php?module=tutorial&view=tutorial&id=' . $data->id . '&code=' . $data->alias . '&ccode=' . $data->category_alias );
		$link_detail = str_replace ( URL_ROOT, '/', $link_detail );
		
		$link_detail = md5 ( $link_detail );
		$str_link = $link_detail;
		
		// xoa chi tiết tin
		$fsCache->remove ( $str_link, 'modules/' . $module_rm . '/' . $view_rm );
		
		$fsCache->remove ( $str_link, 'modules/' . $module_rm . '/' . $view_rm );
		
		// xóa trang chủ
		$link_home = md5 ( '/' );
		$fsCache->remove ( $link_home, 'modules/home/home' );
		
		$files = glob ( PATH_BASE . '/cache/modules/tutorial/home/*' );
		foreach ( $files as $file ) {
			if (is_file ( $file )) {
				if (! @unlink ( $file )) {
					//Handle your errors 
				}
			}
		}
		$files = glob ( PATH_BASE . '/cache/modules/tutorial/cat/*' );
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


	function cdelete(){
		$id = FSInput::get ( 'id', 0, 'int' );
		$rs = $this-> _remove('id='.$id , $this->table_content);
	}

	function get_data_details_id($record_id) {
		global $db;
		$query = " SELECT *
		FROM ".$this->table_content." where record_id =".$record_id;
		$sql = $db->query($query);
		$list = $db->getObjectList();
		return $list;
	}
	function change_other_image_content() {
		$data = FSInput::get ( 'data', 0 );
		if(!$data){
			return;
		}
		$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
		$file_change = $_FILES["file_change"];
		$fsFile = FSFactory::getClass ( 'FsFiles', '' );
		// echo '<pre>';
		// print_r($file_change);
		// die;

		$file_names = array();
		if (isset($file_change) && !empty($file_change)) {

			$no_files = count($file_change['name']);

			for ($i = 0; $i < $no_files; $i++) {
				$row = array ();
				if ($file_change["error"][$i] > 0) {

					//echo "Error: " . $_FILES["files"]["error"][$i] . "<br>";
				} else {
					
					$_FILES["file_change2"]['name'] = $file_change['name'][$i];
					$_FILES["file_change2"]['type'] = $file_change['type'][$i];
					$_FILES["file_change2"]['tmp_name'] = $file_change['tmp_name'][$i];
					$_FILES["file_change2"]['error'] = $file_change['error'][$i];
					$_FILES["file_change2"]['size'] = $file_change['size'][$i];
					// echo '<pre>';
					// print_r($file_change2);
					// die;
					$img_menu = $this->upload_image('file_change2','_'.time(),2000000,$this -> arr_img_paths_menu,$this -> img_folder2);
					if($img_menu){
						$row4['img_menu'] = $img_menu;
					}

				}
				$rs = $this->_update ( $row4, 'fs_tutorial_content','id='.$data );
			}
		} else {
			echo 'Please choose at least one file';
		}
		return true;		

	}
	

	function getAjaxImagespnContent() {
		$data = base64_decode ( FSInput::get ( 'data' ) );
		$data = explode ( '|', $data );
		$where = 'id = ' . $data [1];
		global $db;

		$query = '  SELECT *
		FROM fs_tutorial_content 
		WHERE ' . $where;
		$sql = $db->query ( $query );
		return $db->getObject();
	}

	function delete_other_image_Content($record_id = 0) {
		$get_cat=$this->get_record_by_id($record_id,'fs_tutorial_content');
		global $db;
		if (isset($projects_id))
			$where = 'record_id = \'' . $projects_id . '\'';
		else {
			$data = FSInput::get ( 'data', 0 );
			$where = 'id = \'' . $data . '\'';
		}
		$query = '  SELECT *
		FROM fs_tutorial_content
		WHERE ' . $where;
		$query;
		$db->query ( $query );

		$listImages = $db->getObjectList ();
		if ($listImages) {
			foreach ( $listImages as $item ) {
				$row['img_menu']='';
				$this->_update ( $row, 'fs_tutorial_content','id='.$item->id );
				
				$path = PATH_BASE . $item-> img_menu;
				@unlink ( $path );
				@unlink ( $path .'.webp' );
				foreach ( $this -> arr_img_paths as $image ) {
					@unlink ( str_replace ( '/original/', '/' . $image [0] . '/', $path ));
					@unlink ( str_replace ( '/original/', '/' . $image [0] . '/', $path.'.webp'));
				}
			}
		}
	}


}

?>