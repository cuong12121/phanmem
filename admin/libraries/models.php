<?php 
class FSModels
{
	var $limit;
	var $page;
	var $table_name;
	var $prefix;
	var $arr_img_paths;
	var $img_folder;
	var $call_update_sitemap;
	var $field_except_when_duplicate; // this field is updated auto follow other field ( not update by REQUEST ). Example : list_parents
	var $field_reset_when_duplicate; // các trường không duplicate VD: hits,.... định dạng: array('hits','comments_unread',...)
	
	// đồng bộ dữ liệu ngoài bảng extend. Viết dang  array(tablename => array(field1_curent => field1_remote, field2_curent =>field2_remote,...)): 

	//trường 1 dùng để so sánh với id của dữ liêu
	var $array_synchronize = array(); 
	var $use_table_extend;  // use table extend. Example: fs_products_mobile
	var $type;  // ex: products, pharmacology
	var $calculate_filters;  // 1: calculate filters
	var $module_params;  // 
	var $image_watermark = array(); 

	function __construct()
	{
		$module = FSInput::get('module');
		$view = FSInput::get('view',$module);
		$this -> module = $module;
		$this -> view = $view;

		$page = FSInput::get('page',0,'int');
		$this->page = $page;
		$prefix = $this -> module .'_'.$this -> view .'_';
		$this -> prefix = $prefix;
//			$this -> arr_img_paths = array();
//			$this -> img_folder = '';
		$this -> calculate_filters = 0; 
		$this -> load_params();
	}

		/*
		 * Lấy tham số từ bảng module_config để cấu hình cho từng module
		 */
		function load_params(){
			
		}
		
		function get_data()
		{
			global $db;
			$query = $this->setQuery();
			if(!$query)
				return array();
			// echo $query;
			// die;
			$sql = $db->query_limit($query,$this->limit,$this->page);
			$result = $db->getObjectList();
			
			return $result;
		}
		
		function setQuery()
		{
			$field_search = 'name';
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
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			$where = "  ";
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND ".$field_search." LIKE '%".$keysearch."%' ";
				}
			}
			
			$query = " SELECT a.*
			FROM 
			".$this -> table_name ." AS a
			WHERE 1=1 ".
			$where.
			$ordering. " ";
			return $query;
		}
		
		/*
		 * show total of models
		 */
		function getTotal_()
		{
			global $db;
			$query = $this->setQuery();
			$total = $db->getTotal($query);
			return $total;
		}

		function getTotal()
		{
			global $db;
			$query = $this->setQuery();

			$query = preg_replace ( '#SELECT(.*?)FROM#is',' SELECT count(id) FROM', $query );		
			
			$total = $db->getResult($query);
			return $total;
		}
		
		function getPagination()
		{
			$total = $this->getTotal();			
			$pagination = new Pagination($this->limit,$total,$this->page);
			return $pagination;
		}


		
		/*
		 * get info of Category
		 */
		function get_record_by_id($id,$table_name = '')
		{
			if(!$id)
				return;
			if(!$table_name)
				$table_name = $this -> table_name;
			$query = " SELECT *
			FROM ".$table_name."
			WHERE id = $id ";
			global $db;
			$result = $db->getObject($query);
			return $result;
		}
		/*
		 * get record 
		 */
		function get_record($where = '',$table_name = '',$select = '*',$ordering = '')
		{
			if(!$where)
				return;
			if(!$table_name)
				$table_name = $this -> table_name;
			$query = " SELECT ".$select."
			FROM ".$table_name."
			WHERE ".$where ;
			if($ordering)
				$query .= ' ORDER BY '.$ordering;
			global $db;
			$db->query($query);
			$result = $db->getObject();
			return $result;
		}
	/*
	 * get record by rid
	 */
	function get_records($where = '',$table_name = '',$select = '*',$ordering = '', $limit = '',$field_key = ''){
		$sql_where = " ";
		if($where){
			$sql_where .= ' WHERE '.$where ;
		}
		if(!$table_name)
			$table_name = $this -> table_name;
		$query = " SELECT ".$select."
		FROM ".$table_name.$sql_where;
		if($ordering)
			$query .= ' ORDER BY '.$ordering;
		if($limit)
			$query .= ' LIMIT '.$limit;

		// echo $query;
		global $db;
		if(!$field_key)
			$result = $db->getObjectList($query);
		else 
			$result = $db->getObjectListByKey($field_key,$query);
		return $result;
	}
	
	function get_count($where = '',$table_name = ''){
		if(!$where)
			return;
		if(!$table_name)
			$table_name = $this -> table_name;
		$query = " SELECT count(*)
		FROM ".$table_name."
		WHERE ".$where ;
		
		global $db;
		$result = $db->getResult($query);
		return $result;
	}
	
		/*
		 * Return result
		 */
		function get_result($where = '',$table_name = '',$field = 'id'){
			if(!$where)
				return;
			if(!$table_name)
				$table_name = $this -> table_name;
			$select = " SELECT ".	$field ." ";
			$query = $select."  FROM ".$table_name."
			WHERE ".$where ;
			
			global $db;
			$result = $db->getResult($query);
			return $result;
		}
		
		function get_field_by_id($id,$field,$table_name = '')
		{
			if(!$id)
				return;
			if(!$table_name)
				$table_name = $this -> table_name;
			$query = " SELECT $field
			FROM ".$table_name."
			WHERE id = $id ";
			global $db;
			$result = $db->getResult($query);
			return $result;
		}
		/*
		 * get record by rid
		 */
		function get_record_by_rid($id,$table_name = '')
		{
			if(!$id)
				return;
			if(!$table_name)
				$table_name = $this -> table_name;
			$query = " SELECT *
			FROM ".$table_name."
			WHERE rid = $id ";
			
			global $db;
			$result = $db->getObject($query);
			return $result;
		}
		
		/*
		 * remove record
		 * $img_field is image field need remove.
		 * $img_paths is paths contain image
		 */
		function remove(){

			// check remove
			
			if(method_exists($this,'check_remove')){
				if(!$this -> check_remove()){
					Errors::_(FSText::_('Can not remove these records because have data are related'));
					return false;
				}
			}
			$cids = FSInput::get('id',array(),'array'); 
			


			
			if($this -> table_name == 'fs_products_tags'){
				if(count($cids) > 1){
					echo "chỉ được chọn 1 tag để xóa";
					die;
				}
				$get_tag = $this->get_record('id = '.$cids[0],'fs_products_tags','name,id');
				$get_products = $this->get_records('tag_group like "%,'.$cids[0].',%"','fs_products','tag_group,id,tags');
				if(!empty($get_products)){
					foreach ($get_products as $item_pro) {
						$row_tag_pro = array();
					
					
						$str_tag_pro = str_replace($cids[0].',','',$item_pro->tag_group);
						
						$row_tag_pro['tag_group'] = $str_tag_pro;

						$str_tag_pro_name ='';
						if($str_tag_pro !== ',' && $str_tag_pro!=='' && $str_tag_pro!==',,' && $str_tag_pro!==',,,'){
							$rest_str_tag_pro = substr($str_tag_pro, 1, -1);
							
							$get_tags_up = $this->get_records('id IN ('.$rest_str_tag_pro.')','fs_products_tags','name,id');

							if(!empty($get_tags_up)){
								$t=1;
								foreach ($get_tags_up as $get_tags_up_it){
									if(count($get_tags_up) == $t){
										$str_tag_pro_name .= $get_tags_up_it->name;
									}else{
										$str_tag_pro_name .= $get_tags_up_it->name . ',';
									}
									
									$t++;
								}
							}
						}

						

						$row_tag_pro['tags'] = $str_tag_pro_name;

						
						$this->_update($row_tag_pro,'fs_products','id = '.$item_pro->id);
					}
				}

				$get_news = $this->get_records('tag_group like "%,'.$cids[0].',%"','fs_news','tag_group,id,tags');
				if(!empty($get_news)){
					foreach ($get_news as $item_new) {
						$row_tag_new = array();

						$str_tag_new_name = str_replace($get_tag->name.',','',$item_new->tags);

						if(strpos($item_new->tags,',' !== false)){
							$str_tag_new_name = str_replace($get_tag->name.',','',$item_new->tags);
						}else{
							$str_tag_new_name = str_replace($get_tag->name,'',$item_new->tags);
						}

						if($str_tag_new_name == ','){
							$str_tag_new_name = '';
						}

						

						$str_tag_new = str_replace($cids[0].',','',$item_new->tag_group);
						
						$row_tag_new['tag_group'] = $str_tag_new;



						$str_tag_new_name ='';
						if($str_tag_new !== ',' && $str_tag_new!=='' && $str_tag_new!==',,' && $str_tag_new!==',,,'){
							$rest_str_tag_new = substr($str_tag_new, 1, -1);
							
							$get_tags_up_new = $this->get_records('id IN ('.$rest_str_tag_new.')','fs_products_tags','name,id');

							if(!empty($get_tags_up_new)){
								$g=1;
								foreach ($get_tags_up_new as $get_tags_up_it_new){
									if(count($get_tags_up_new) == $g){
										$str_tag_new_name .= $get_tags_up_it_new->name;
									}else{
										$str_tag_new_name .= $get_tags_up_it_new->name . ',';
									}
									
									$g++;
								}
							}
						}

						$row_tag_new['tags'] = $str_tag_new_name;
						$this->_update($row_tag_new,'fs_news','id = '.$item_new->id);
					}
				}
			}

			
			foreach ($cids as $cid){
				if( $cid != 1)
					$cids[] = $cid ;
			}
			if(!count($cids))
				return false;
			$str_cids = implode(',',$cids);
			
			$field_img = isset($this -> field_img)?$this -> field_img:'';
			$remove_field_img = isset($this -> remove_field_img)?$this -> remove_field_img:'';


			$use_table_extend = isset($this -> use_table_extend)?$this -> use_table_extend:0;

			// array table_names is changed. ( for calculate filter)
			$arr_table_name_changed = array();				
			

			if($field_img || $use_table_extend || $remove_field_img){
				$select = 'id';
				if($field_img)
					$select .= ','.$field_img;
				if($use_table_extend)
					$select .= ',tablename';
				
				$query = " SELECT ".$select." FROM ".$this -> table_name."
				WHERE id IN (".$str_cids.") ";

				global $db;
				$result = $db->getObjectList($query);
				if(!$result)
					return;
				foreach($result as $item){
					// remove img					
					if($field_img){
						$old_image = $item -> $field_img;
						
						$arr_img_paths = $this -> arr_img_paths;
						if(count($arr_img_paths)){
							foreach($arr_img_paths as $item_path){
								$path_resize = str_replace('/original/', '/'.$item_path[0].'/', $old_image);
								$path_resize = PATH_BASE.str_replace('/',DS,$path_resize);
								unlink($path_resize); 
							}	
						}
						$old_image = PATH_BASE.str_replace('/',DS, $old_image);
						unlink($old_image); 
					} 

					if($remove_field_img) {
						$old_field_img = $item -> $remove_field_img;
						$old_field_img = PATH_BASE.str_replace('/',DS, $old_field_img);
						unlink($old_field_img); 
					}

					if($use_table_extend){
						// remove data in table fs_Type_extend
						$table_extend = $item -> tablename; 
						// for caculator filters
						$arr_table_name_changed[] = $table_extend;
						if($table_extend){
							if($table_extend && $table_extend !='fs_products' && $db -> checkExistTable($table_extend))
								$this -> _remove('record_id  = '.$item -> id,$table_extend);
						}
					}
					
					//synchronize
					$array_synchronize = $this -> array_synchronize;
					if(count($array_synchronize)){
						foreach($array_synchronize as $table_name => $fields){
							$syn = 0;
							$row5 = array();
							$where = '';
							foreach($fields as $cur_field => $syn_field){
								$where .= $syn_field .' = '.$item -> id;
								break;
							}
							$rs = $this -> _update($row5,$table_name, $where,0 );
							$this -> _remove($where,$table_name);
						}
					}
				}
			}



			$sql = " DELETE FROM ".$this -> table_name." 
			WHERE id IN ( $str_cids ) ";
			
			global $db;
			$rows = $db->affected_rows($sql);
			
			// update sitemap
			if($this -> call_update_sitemap){
				$this -> call_update_sitemap();
			}
			// 	calculate filters:
//			if($this -> calculate_filters){
//				$this -> caculate_filter($arr_table_name_changed);
//			}
			return $rows;
		}
		/*
		 * remove record
		 * $img_field is image field need remove.
		 * $img_paths is paths contain image
		 */

		/*
		 * value: == 1 :published
		 * value  == 0 :unpublished
		 * published record
		 */
		function published($value)
		{
			
			$ids = FSInput::get('id',array(),'array');
			// if($module == 'products' && $view == 'products' || $module == 'news' && $view == 'news'){
			// 	foreach ($ids as $id) {
			
			// 	}
			// }

			if(count($ids))
			{
				global $db;
				$str_ids = implode(',',$ids);
				$sql = " UPDATE ".$this -> table_name."
				SET published = $value
				WHERE id IN ( $str_ids ) " ;
				$rows = $db->affected_rows($sql);
				
				// 	update sitemap
				if($this -> call_update_sitemap){
					$this -> call_update_sitemap();
				}
				// array table_names is changed. ( for calculate filter)
				$arr_table_name_changed = array();				
				// update table fs_TYPE_extend
				if($this -> use_table_extend){
					foreach($ids as $id){
						$record = $this -> get_record('id = '.$id,$this ->  table_name);
						$table_extend = $record -> tablename;
	        			// calculate filter:
						$arr_table_name_changed[] = $table_extend;
						global $db;
						if($table_extend && $table_extend != 'fs_products' && $db -> checkExistTable($table_extend)){
							$row['published'] = $value;
							$rs = $this -> _update($row,$table_extend, ' record_id = '.$id );
						}
					}
				}
				//synchronize
				$array_synchronize = $this -> array_synchronize;
				if(count($array_synchronize)){
					foreach($array_synchronize as $table_name => $fields){
						$i = 0;
						$syn = 0;
						$row5 = array();
						$where = ' ';
						foreach($fields as $cur_field => $syn_field){
							if(!$i){
								$where .= $syn_field .' = '.$id;
							}else{
								if($cur_field == 'published'){
									$row5[$syn_field] = $value;
									$syn = 1;
								}
							}
							$i ++;
						}
						if($syn){
							$rs = $this -> _update($row5,$table_name, $where );
						}
					}
				}
				
				// calculate filters:
//				if($this -> calculate_filters){
//					$this -> caculate_filter($arr_table_name_changed);
//				}
				return $rows;
			}
			
			return 0;
		}

		/*
		 * value: == 1 :published
		 * value  == 0 :unpublished
		 * published record
		 */
		function ajax_reverse()
		{
			
			$id = FSInput::get('id');
			$value = FSInput::get('value',0,'int');
			// $value = $_GET['value'];
			$field = FSInput::get('field');
			

			if(!$id || !$field)
				return;
			
			global $db;
			
			$sql = ' UPDATE '.$this -> table_name.'
			SET '.$field.' = '.$value.'
			WHERE id = '.$id ;

			$rows = $db->affected_rows($sql);
			
			
				// array table_names is changed. ( for calculate filter)
			$arr_table_name_changed = array();				
				// update table fs_TYPE_extend
			if($field == 'published' || $field == 'is_sell' || $field == 'is_hot' || $field == 'show_product_special_cat' || $field == 'is_new' || $field == 'is_promotion'){ 

				if($this -> use_table_extend){
					
					$record = $this -> get_record('id = '.$id,$this ->  table_name);
					$table_extend = $record -> tablename;
	        			// calculate filter:
					$arr_table_name_changed[] = $table_extend;
					global $db;
					if($table_extend && $table_extend != 'fs_products' && $db -> checkExistTable($table_extend)){
						$row[$field] = $value;
						$rs = $this -> _update($row,$table_extend, ' record_id = '.$id );
					}
					
				}
					//synchronize
				$array_synchronize = $this -> array_synchronize;
				if(count($array_synchronize)){
					foreach($array_synchronize as $table_name => $fields){
						$i = 0;
						$syn = 0;
						$row5 = array();
						$where = ' ';
						foreach($fields as $cur_field => $syn_field){
							if(!$i){
								$where .= $syn_field .' = '.$id;
							}else{
								if($cur_field == $field){
									$row5[$syn_field] = $value;
									$syn = 1;
								}
							}
							$i ++;
						}
						if($syn){
							$rs = $this -> _update($row5,$table_name, $where );
						}
					}
				}
			}

				// print_r($rows);die;

				// calculate filters:
//				if($this -> calculate_filters){
//					$this -> caculate_filter($arr_table_name_changed);
//				}
			return $rows;
			
			
			return 0;
		}

		/*
		 * value: == 1 :published
		 * value  == 0 :unpublished
		 * published record
		 */
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
						if($key == 'code'){
							$key3 = $value;
							continue;
						}
						if($key == 'edited_time' || $key == 'created_time' || $key == 'updated_time'){
							$row[$key]  =   $time;	
							continue;
						}
						if($key == 'action_username'){
							$username = $_SESSION ['ad_username'];						
							$row[$key] =   $username;	
						}
						if(in_array($key,$arr_fields_reset)){
							$row[$key]  =   null;	
							continue;
						}
						
						$row[$key] = $value;
					}
//					print_r($row);
//					die;
					if(!$key1)
						continue;
					$j = 0;
					while(true)	{
						if(!$j){
							$key1_copy = $key1.' copy';
							$key2_copy = $key2.'-copy';
							$key3_copy = $key3.'-copy';
							$suffix_new = '-copy';
						} else { 
							$key1_copy = $key1.' copy '.$j;
							$key2_copy = $key2.'-copy-'.$j;
							$key3_copy = $key3.'-copy-'.$j;
							$suffix_new = '-copy-'.$j;
						}
						$where = $field_key1.' = "'.$db -> escape_string($key1_copy).'" OR alias = "'.$db -> escape_string($key2_copy).'" OR code = "'.$db -> escape_string($key3_copy).'"';
						$check_exist = $this -> get_count($where,$this -> table_name);
						if(!$check_exist){
							$row[$field_key1]= 	$key1_copy;					
							$row['alias']	= 	$key2_copy;
							$row['code']	= 	$key3_copy;		
							break;
						}
						$j ++;
					}
					// duplicate image
					if(isset($this -> field_img) && $suffix_new){
						$field_img = $this -> field_img;
						$link_img = $this -> duplicate_image($item -> $field_img, $suffix_new);
						if($link_img)
							$row[$field_img] = $link_img;
					}
					$new_record_id = $this -> _add($row, $this -> table_name,1);
					if($new_record_id){
						$row2 = array();
						$new_record = $this -> get_record(' id = '.$new_record_id ,$this -> table_name );
						// except : wrapper_alias, list_parents
						if($field_except && count($field_except)){
							foreach($field_except as $f){
								$row2[$f[0]] = str_replace(','.$item -> $f[1].','  ,  ','.$new_record -> $f[1].',' , $row[$f[0]]);				
							}
							$this -> _update($row2, $this -> table_name, ' id = '.$new_record_id);
						}
						
						
						// duplicate data extend
						if($this -> use_table_extend){
							$row3 = array();
//							$row3 = $row;
							unset($row3['tablename']);
							$row3['record_id'] = $new_record_id;
							$table_extend = $item -> tablename;
							// for caculator filters
							$arr_table_name_changed[] = $table_extend;
							
							if($table_extend && $table_extend != 'fs_products' && $db -> checkExistTable($table_extend)){
								$record_extend = $this -> get_record('record_id = '.$item -> id,$table_extend);
								foreach($record_extend as $field_ext_name => $field_ext_value){
									if(isset($row3[$field_ext_name]) || $field_ext_name == 'id')
										continue;
									if($field_ext_name == 'code'){
										$row3[$field_ext_name] = $row['code'];
										continue;
									}
									if($field_ext_name == 'alias'){
										$row3[$field_ext_name] = $row['alias'];
										continue;
									}
									if($field_ext_name == 'name'){
										$row3[$field_ext_name] = $row['name'];
										continue;
									}
									$row3[$field_ext_name] = $db -> escape_string($field_ext_value);	
								}
								if(!$this -> _add($row3, $table_extend))
									continue;
							}
						}
						
						$rs ++;
					}
				}

				if($this -> table_name == 'fs_products'){
					$row_img = array();
					$records2  = $this -> get_records(' record_id IN ('.$str_ids.')' , 'fs_products_images' );
					// echo '<pre>';
					// print_r($records2);die;
					if(!empty($records2)) {
						foreach ($records2 as $key2 => $value2) {
							if($value2-> image && $suffix_new) {
								// $field_img = $this -> field_img;
								$link_img = $this -> duplicate_image_other($value2 -> image, $suffix_new);
								if($link_img) {
									$row_img['image'] = $link_img;
									$row_img['record_id'] = $new_record_id;
									$row_img['color_id'] = $value2-> color_id;
									$row_img['group_id'] = $value2-> group_id;
									$row_img['ordering'] = $value2-> ordering;
									$new_record_id_img = $this -> _add($row_img, 'fs_products_images',1);
								}
							}
						}
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
		/*
		 * get Max value of Ordering field in table fs_categories
		 */
		function getMaxOrdering()
		{
			$query = " SELECT Max(a.ordering)
			FROM ".$this -> table_name." AS a
			";
			global $db;
			$result = $db->getResult($query);
			if(!$result)
				return 1;
			return ($result + 1);
		}

		function getMaxOrdering2()
		{
			$query = " SELECT Max(a.ordering2)
			FROM ".$this -> table_name." AS a
			";
			global $db;
			$result = $db->getResult($query);
			if(!$result)
				return 1;
			return ($result + 1);
		}

		
		
		/*
		 * get field of table
		 */
		function get_field_table($table_name = '',$key_field_name = 0){
			if(!$table_name)	
				$table_name = $this -> table_name;
			global $db;
			$query = "SHOW COLUMNS FROM ".$table_name." ";
			$db->query($query);
			if($key_field_name)
				$fields_in_table = $db->getObjectListByKey('Field');
			else 
				$fields_in_table = $db->getObjectList();

			return $fields_in_table;
		}
		
		/*
		 * save into table
		 */
		public  function  save($row = array(),$use_mysql_real_escape_string = 1){

			// print_r($row);die;

			$this->save_new_session();
			$id = FSInput::get('id',0,'int');
			$return = FSInput::get ( 'return' );
			$url = base64_decode ( $return );
			if(!$id){
				$url =$url.'&task=add';
			}
			$title = FSInput::get('title');
			$name = FSInput::get('name');
			$subject = FSInput::get('subject');
			$group_name = FSInput::get('group_name');
			$username = FSInput::get('username');
			$redirect_from = FSInput::get('redirect_from');
			$msg = 'Bạn phải nhập tên hoặc title cho bài viết!';
			
			// if(!$name && !$title && !$group_name && !$subject && !$username && !$redirect_from){
			// 	setRedirect ( $url, $msg, 'error' );
			// }
			
			$this -> arr_img_paths_compress = array(array('compress',1,1,'compress'));
			$this-> convert_img_content();

			if(!$id)
				return $this -> save_new($row,$use_mysql_real_escape_string);
			else 
				return $this -> save_change($id,$row,$use_mysql_real_escape_string);
		}


		function convert_img_content(){

			$description = FSInput::get('description');
			if(!$description){
				$description = FSInput::get('content');
			}

			if(!$description) return true;

			$doc=new DOMDocument();
			$doc->loadHTML($description);
			 // just to make xpath more simple
			$xml=simplexml_import_dom($doc);
			$images=$xml->xpath('//img');
			
			$fsFile = FSFactory::getClass('FsFiles');
		// upload
			foreach ($images as $img) {
				$img=$img['src'];
				$img =  str_replace('\"/', '', $img);
				$img =  str_replace('\"', '', $img);
				$img_link = str_replace('\\', '/', $img);
				$img =  str_replace('/', DS, $img);
				if (strpos($img, 'http//') !== false || strpos($img, 'https//') !== false ) {
					continue;
				}
				$img_paths = PATH_BASE.$img;
				$arr_img = explode(DS, $img_paths);
				$ct_img = count($arr_img);
				$image = $arr_img[$ct_img - 1];
				$day= $arr_img[$ct_img - 2];
				$img2='';
				$max=0;
				for ($i=0; $i < count($arr_img); $i++) {
					$max++;
					if($i == $ct_img - 1){
						$img2.='original'.DS;
					}
					if($max < $ct_img){
						$img2.=$arr_img[$i].DS;	
					}else{
						$img2.=$arr_img[$i];
					}
				}

				$img_folder = str_replace($image, '', $img2);
				$img_link = str_replace('/'.$image, '', $img_link);
				$fsFile = FSFactory::getClass('FsFiles');
			// upload
				$path = $img_folder;
				$path2 =  str_replace(DS.'original'.DS,DS,$path);
			// $image = str_replace('%20', ' ',$image);
				$image = urldecode($image);
				foreach($this-> arr_img_paths_compress as $item){
					$path_resize = str_replace(DS.'original'.DS, DS.$item[0].DS, $path);
					$fsFile -> create_folder($path_resize);
					
					$method_resize = $item[3]?$item[3]:'resized_not_crop';
					if(!$fsFile ->$method_resize($path2.$image, $path_resize.$image,$item[1], $item[2]))
						return false;	

					// if($this->image_watermark){
					// 	if($item[0] == "resized" || $item[0] == "large" || $item[0] == "compress"){
					// 		$fsFile->add_logo($path_resize,$image,PATH_BASE.str_replace('/',DS, 'images/mask/mask_'.$item[0].'.png'),$this->image_watermark_pos);
					// 		$fsFile->add_logo($path_resize,$image,PATH_BASE.str_replace('/',DS, 'images/mask/mask_'.$item[0].'2.png'),$this->image_watermark_pos2);
					// 	}
					// }

					$file_ext = $fsFile -> getExt($image);
					$fsFile -> convert_to_webp($path_resize.$image,$file_ext);	
					
				}	
			}
		}

		function save_new_session($row = array(),$use_mysql_real_escape_string = 0){
			$id = FSInput::get('id',0,'int');
			$fields_in_table = $this -> get_field_table();
			global $db;
			$str_fields = array();
			$str_values = array();
			$field_img = isset($this -> field_img)?$this -> field_img:'image';
			$field_width =isset($this -> field_width)?$this -> field_width:'';
			// echo $warehouses_id = FSInput::get('warehouses_id'); die;
			for($i = 0; $i < count($fields_in_table); $i ++){
				$item = $fields_in_table[$i];
				$field  = $item -> Field;
				if($field == $field_img && !isset($row[$field_img]) && $field_img ){
					// $image = $_FILES[$field_img]["name"];
					// if($image){
					// 	$image = $this -> upload_image($field_img,'_'.time(),2000000);
					// 	$row[$field_img] = 	$image;
					// 	if(!isset($row[$field_img]) && $field_width){
					// 		// tính chiều rộng để thêm vào admin
					// 		list($root_width,$root_height) = getimagesize(URL_ROOT.$image);
					// 		$arr_img_paths = $this -> arr_img_paths;
					// 		$get_height =$arr_img_paths[0][2];
					// 		$new_width  = ceil($root_width * $get_height/ $root_height) ;
					// 		$row[$field_width] = $new_width;
					// 	}
					// }
				}
				// if($field == 'alias'){
				// 	if(!isset($row['alias'])){
				// 		$alias= FSInput::get('alias');
				// 		$fsstring = FSFactory::getClass('FSString','','../');
				// 		if(!$alias){
				// 			$title = FSInput::get('title');
				// 			if(!$title)
				// 				$title = FSInput::get('name');
				// 			if(!$title){
				// 				Errors::_('Cần nhập tên hoặc tiêu đề');
				// 				return false;
				// 			}
				// 			$row['alias'] = $fsstring -> stringStandart($title);
				// 		} else {
				// 			$row['alias'] = $fsstring -> stringStandart($alias);
				// 		}
				// 	}
				// 	if(isset($this -> check_alias) && $this -> check_alias){
				// 		if($this -> check_exist($row['alias'],$id)){
				// 			Errors::_('Alias của bạn đã bị trùng tên','alert');
				// 			$row['alias'] = $this -> genarate_alias_news($row['alias'],$id);
				// 		}
				// 	}
				// }
				if(isset($row[$field])){
					$str_fields[] =   $field;
					$str_values[]  =   $row[$field];					
				} else if(isset($_POST[$field])){
					$type  = $item -> Type;
//					$value = $_POST[$field];
					$value = FSInput::get($field);
					
					if(strpos($type,'text') !== false || strpos($type,'varchar') !== false){
						$str_fields[] =   $field;
						$str_values[]  =   $value;
						
					}else { 
						$str_fields[] =  $field;
						$str_values[]  =  $value;	
					}
				} else {
					if($field == 'edited_time' || $field == 'created_time' || $field == 'updated_time'){
						$time = date('Y-m-d H:i:s');
						$str_fields[] =   $field;
						$str_values[]  =   $time;	
					}
					
				}
			}
			if(!count($str_fields))
				return false;
			
			$module = FSInput::get('module');
			$view = FSInput::get('view');
			// echo "<pre>";
			// print_r($str_fields);
			// echo "<br>";
			// echo "<pre>";
			// print_r($str_values);
			// die;
			foreach ($str_fields as $key => $item) {
				// if(is_array($item)){
				// 	$item=$item[0];
				// }
				if(isset($_SESSION[$module][$view])){
					$_SESSION[$module][$view][$item] = $str_values[$key] ;
				}
				
			}

			



			// $str_fields = implode(',',$str_fields);
			// $str_values = implode(',',$str_values);
			
			// $sql = ' INSERT INTO  '.$this -> table_name ;
			// $sql .=  '('.$str_fields.") ";
			// $sql .=  'VALUES ('.$str_values.") ";
			

			// $id = $db->insert($sql);


			
// 			// calculate filters:
// 			if($this -> calculate_filters){
// 				// chỉ tính toán đếm bộ lọc khi có bảng mở rộng
// 				$tablename = $row['tablename'];
// 				// save extension
// 				if ($tablename && $tablename != 'fs_products') {


// 					$ext_id = $this->save_extension ( $tablename, $id );
			
// 					if (!isset($ext_id)) {
// 						Errors::setError ( 'có lỗi khi lưu phần mở rộng nhé' );
// 					}
// 				}
			
// 				$arr_table_name_changed = array();	
// 				if(isset($row['tablename']) && !empty($row['tablename']))
// 					$arr_table_name_changed[] = $row['tablename'];
// //				$this -> caculate_filter($arr_table_name_changed);
// 			}
			
			return true;
		}
		
		function save_new($row = array(),$use_mysql_real_escape_string = 0){

			
			$id = FSInput::get('id',0,'int');
			$fields_in_table = $this -> get_field_table();
			global $db;
			$str_fields = array();
			$str_values = array();
			$field_img = isset($this -> field_img)?$this -> field_img:'image';
			$field_width =isset($this -> field_width)?$this -> field_width:'';
			
			for($i = 0; $i < count($fields_in_table); $i ++){
				$item = $fields_in_table[$i];
				$field  = $item -> Field;
				if($field == $field_img && !isset($row[$field_img]) && $field_img ){
					$image = $_FILES[$field_img]["name"];
					if($image){
						$image = $this -> upload_image($field_img,'_'.time(),2000000);
						$row[$field_img] = 	str_replace('upload_images/','',$image);
						if(!isset($row[$field_img]) && $field_width){
							// tính chiều rộng để thêm vào admin
							list($root_width,$root_height) = getimagesize(URL_ROOT.$image);
							$arr_img_paths = $this -> arr_img_paths;
							$get_height =$arr_img_paths[0][2];
							$new_width  = ceil($root_width * $get_height/ $root_height) ;
							$row[$field_width] = $new_width;
						}
					}
				}
				if($field == 'alias'){
					if(!isset($row['alias'])){
						$alias= FSInput::get('alias');
						$fsstring = FSFactory::getClass('FSString','','../');
						if(!$alias){
							$title = FSInput::get('title');
							if(!$title)
								$title = FSInput::get('name');
							if(!$title){
								// Errors::_('Cần nhập tên hoặc tiêu đề');
								// return false;
							}
							$row['alias'] = $fsstring -> stringStandart($title);
						} else {
							$row['alias'] = $fsstring -> stringStandart($alias);
						}
					}
					if(isset($this -> check_alias) && $this -> check_alias){
						if($this -> check_exist($row['alias'],$id)){
							Errors::_('Alias của bạn đã bị trùng tên','alert');
							$row['alias'] = $this -> genarate_alias_news($row['alias'],$id);
						}
					}
				}
				
				
				if(empty($this->check_note_code)){
					if($field == 'code'){
						$row['code'] = FSInput::get('code');
						if($row['code']) {
							if($this -> check_exist($row['code'],$id,'code')){
								Errors::_('Mã của bạn đã bị trùng!','alert');
								$row['code'] = $this -> genarate_value_news($row['code'],$id,'code');
							}
						}
					}
				}
				

				if(isset($row[$field])){
					$str_fields[] =   "`".$field."`";
					$str_values[]  =   "'".$row[$field]."'";					
				} else if(isset($_POST[$field])){
					$type  = $item -> Type;
//					$value = $_POST[$field];
					$value = FSInput::get($field);
					
					if(strpos($type,'text') !== false || strpos($type,'varchar') !== false){

						$str_fields[] =   "`".$field."`";
						
						if($use_mysql_real_escape_string){
							$str_values[]  =   "'".$db -> escape_string($value)."'";
						}else{
							$str_values[]  =   "'".$value."'";
						}
						
					}else { 
						$str_fields[] =   "`".$field."`";
						if($use_mysql_real_escape_string){
							$str_values[]  =   "'".$db -> escape_string($value)."'";
						}else{
							$str_values[]  =   "'".$value."'";
						}	
					}
				} else {
					if($field == 'edited_time' || $field == 'created_time' || $field == 'updated_time'){
						$time = date('Y-m-d H:i:s');
						$str_fields[] =   "`".$field."`";
						$str_values[]  =   "'".$time."'";	
					}
					if($field == 'action_username'){
						$username = $_SESSION ['ad_username'];
						$str_fields[] =   "`".$field."`";
						$str_values[]  =   "'".$username."'";	
					}
					if($field == 'action_userid'){
						$userid = $_SESSION ['ad_userid'];
						$str_fields[] =   "`".$field."`";
						$str_values[]  =   "'".$userid."'";	
					}

					if($field == 'create_username'){
						$username = $_SESSION ['ad_username'];
						$str_fields[] =   "`".$field."`";
						$str_values[]  =   "'".$username."'";	
					}
					if($field == 'create_userid'){
						$userid = $_SESSION ['ad_userid'];
						$str_fields[] =   "`".$field."`";
						$str_values[]  =   "'".$userid."'";	
					}
				}
			}
			if(!count($str_fields))
				return false;

			
			$str_fields = implode(',',$str_fields);
			$str_values = implode(',',$str_values);
			
			$sql = ' INSERT INTO  '.$this -> table_name ;


			$sql .=  '('.$str_fields.") ";
			$sql .=  'VALUES ('.$str_values.") ";

			// echo $sql;die;


			$id = $db->insert($sql);




			
			// calculate filters:
			if($this -> calculate_filters){
				// chỉ tính toán đếm bộ lọc khi có bảng mở rộng
				$tablename = $row['tablename'];
				// save extension
				if ($tablename && $tablename != 'fs_products') {


					$ext_id = $this->save_extension ( $tablename, $id );
					
					if (!isset($ext_id)) {
						Errors::setError ( 'có lỗi khi lưu phần mở rộng nhé' );
					}
				}
				
				$arr_table_name_changed = array();	
				if(isset($row['tablename']) && !empty($row['tablename']))
					$arr_table_name_changed[] = $row['tablename'];
//				$this -> caculate_filter($arr_table_name_changed);
			}

			$module = FSInput::get('module');
			$view = FSInput::get('view');
			unset($_SESSION[$module][$view]);
			
			return $id;
		}
		
		/*
		 * Update:
		 * update field from :row, time and request
		 */
		function save_change($id,$row = array(),$use_mysql_real_escape_string = 0){
			if(!$id)
				return;
			global $db;
			$fields_in_table = $this -> get_field_table();
			$str_update = array();
			$field_img = isset($this -> field_img)?$this -> field_img:'image';
			$field_width =isset($this -> field_width)?$this -> field_width:'';
			// printr($_SESSION);
			// mảng  $row1 này chỉ phục vụ cho việc đồng bộ dữ liệu ra bảng ngoài theo cấu hình $array_synchronize
			
			for($i = 0; $i < count($fields_in_table); $i ++){
				$item = $fields_in_table[$i];
				$field  = $item -> Field;
				
				if($field == $field_img && !isset($row[$field_img]) && $field_img){
					$image = $_FILES[$field_img]["name"];
					if($image){
						// remove old if exists record and img
						$this -> remove_old_image($id,$field_img);
						
						$image = $this -> upload_image($field_img,'_'.time(),2000000);
						$row[$field_img] = 	str_replace('upload_images/','',$image);
						if($field_width){
							// tính chiều rộng để thêm vào admin
							list($root_width,$root_height) = getimagesize(URL_ROOT.$image);
							$arr_img_paths = $this -> arr_img_paths;
							$get_height =$arr_img_paths[0][2];
							$new_width  = ceil($root_width * $get_height/ $root_height) ;
							$row[$field_width] = $new_width;
						}
					}
				}
				
				if($field == 'alias'){
					if(!isset($row['alias'])){
						$alias= FSInput::get('alias');
						$fsstring = FSFactory::getClass('FSString','','../');
						if(!$alias){
							$title = FSInput::get('title');
							if(!$title)
								$title = FSInput::get('name');
							if(!$title){
								// Errors::_('Cần nhập tên hoặc tiêu đề');
								// return false;
							}
							$row['alias'] = $fsstring -> stringStandart($title);
						} else {
							$row['alias'] = $fsstring -> stringStandart($alias);
						}
					}
					
				// 	cuong tat tam phan nay cho k loi code
// 					if($this -> check_alias){
// 						if($this -> check_exist($row['alias'],$id)){
// 							Errors::_('Alias của bạn đã bị trùng tên','alert');
// 							$row['alias'] = $this -> genarate_alias_news($row['alias'],$id);
// //							return false;
// 						}
// 					}
				}
				if(isset($row[$field])){
					$str_update[] = "`".$field."` = '".$row[$field]."'";
				} else if(isset($_POST[$field])){
					$type  = $item -> Type;
					
					$value = $_POST[$field];
					
					if(strpos($type,'text') !== false || strpos($type,'varchar') !== false){

						$row[$field] = $value;

						
					}else{ 
//						$str_update[] = "`".$field."` = '".$_POST[$field]."'";
						$row[$field] = $_POST[$field];// synchronize
					}
				} else {
					if($field == 'edited_time' || $field == 'updated_time') {
						$time = date('Y-m-d H:i:s');
//						$str_update[] = "`".$field."` = '".$time."'";
						$row[$field] = $time;// synchronize
					}
					if($field == 'action_username'){
						$username = $_SESSION ['ad_username'];						
						$row[$field] =   $username;	
					}
					if($field == 'action_userid'){
						$userid = $_SESSION ['ad_userid'];						
						$userid = $_SESSION['ad_userid'];						
						$row[$field] =   $userid;	
					}
				}
			}
			
// 			cường tắt tạm cho đỡ lỗi code

// 			if(!$this -> check_note_code){
// 				if(@$row['code']) {
// 					if($this -> check_exist($row['code'],$id,'code')){
// 						Errors::_('Mã của bạn đã bị trùng!','alert');
// 						$row['code'] = $this -> genarate_value_news($row['code'],$id,'code');
// 					}
// 				}
// 			}
			
//			print_r($row);
//			die;
			// print_r($row);
			// die;
//			global $db;
			$rows = $this -> _update($row,$this ->  table_name, ' id = '.$id,1 );	

			//synchronize
			$array_synchronize = $this -> array_synchronize;
			if(count($array_synchronize)){
				foreach($array_synchronize as $table_name => $fields){
					$i = 0;
					$syn = 0;
					$row5 = array();
					$where = ' ';
					foreach($fields as $cur_field => $syn_field){
						if(!$i){
							$where .= $syn_field .' = '.$id;
						}else{
							if(isset($row[$cur_field])){
								$row5[$syn_field] = $row[$cur_field];
								$syn = 1;
							}
						}
						$i ++;
					}
					if($syn)
						$rs = $this -> _update($row5,$table_name, $where,0 );
				}
			}
			
			// 	calculate filters: 
			if($this -> calculate_filters){
				
				// chỉ tính toán đếm bộ lọc khi có bảng mở rộng
				$tablename = $row['tablename'];
				// save extension
				if ($tablename) {
					$ext_id = $this->save_extension ( $tablename, $id );
					if (! $ext_id) {
					 //	Errors::setError ( 'C&#243; l&#7895;i khi l&#432;u ph&#7847;n m&#7903; r&#7897;ng' );
					}
				}
				
				$arr_table_name_changed = array();	
				if(isset($row['tablename']) && !empty($row['tablename']))
					$arr_table_name_changed[] = $row['tablename'];
//				$this -> caculate_filter($arr_table_name_changed);
			}
			
			if($rows)
				$module = FSInput::get('module');
				$view = FSInput::get('view');
			if(isset($_SESSION[$module][$view])){
				unset($_SESSION[$module][$view]);
			}
			return $rows?$id:0;
		}
		
		/*
		 * Change alias of category in table_item (news,products,...)
		 */
		function _update2($row,$table_name,$where = '',$use_mysql_real_escape_string = 0){
			
			global $db;
			$total = count($row);
			if(!$total || !$table_name )
				return ;
			$sql = 'UPDATE '.$table_name.' SET ';
			$i = 0;
			foreach($row as $key => $value){
				if($use_mysql_real_escape_string)
					$sql .= "`".$key."` = '".$db -> escape_string($value)."'";
				else 
					$sql .= "`".$key."` = '".$value."'";
				if($i < $total - 1)
					$sql .=  ',';
				$i ++;
			}
			if($where)
				$where = ' WHERE '.$where;
			$sql .= $where;
			// echo $sql
			$rows = $db->affected_rows($sql);
			return $rows;
		}

		function _update($row,$table_name,$where = '',$use_mysql_real_escape_string = 1){
			global $db;
			$total = count($row);
			if(!$total || !$table_name )
				return ;
			$sql = 'UPDATE '.$table_name.' SET ';
			$i = 0;
			foreach($row as $key => $value){
				if($use_mysql_real_escape_string)
					$sql .= "`".$key."` = '".$db -> escape_string($value)."'";
				else 
					$sql .= "`".$key."` = '".$value."'";
				if($i < $total - 1)
					$sql .=  ',';
				$i ++;
			}
			if($where)
				$where = ' WHERE '.$where;
			$sql .= $where;
			
			// echo $sql;
			
			$rows = $db->affected_rows($sql);
			return $rows;
		}
		function _add($row,$table_name,$use_mysql_real_escape_string = 0){
			if(!$table_name)
				return false;
			global $db;	
			$str_fields = array();
			$str_values = array();
			
			if(!count($row))
				return;
			foreach($row as $field => $value){
				if($use_mysql_real_escape_string){
					$value = $db -> escape_string($value);	
					
				}
				$str_fields[] =   "`".$field."`";
				$str_values[]  =   '"'.$value.'"';
			}
			
			$str_fields = implode(',',$str_fields);
			$str_values = implode(',',$str_values);
			
			global $db;
			
			$sql = ' INSERT INTO  '.$table_name ;
			$sql .=  '('.$str_fields.') ';
			$sql .=  'VALUES ('.$str_values.') ';

			// echo $sql;
			// die();
			
			$id = $db->insert($sql);
			return $id;
		}
		
		function _add_multi($rows,$table_name,$use_mysql_real_escape_string = 0){
			if(!$table_name)
				return false;
			$str_fields = '';
			$str_fields2 = array(); // luu dang ko co "`"
			
			if(!count($rows))
				return;
			global $db;	
			$row_first = $rows[0];
			foreach($row_first as $field => $value){
				if($str_fields)
					$str_fields .= ',';
				$str_fields .=   "`".$field."`";
				$str_fields2[] =   $field;
			}
			$str_values = ''; 
			$i = 0;
			foreach($rows as $row){
				if($i)
					$str_values .= ',';
				$str_values .= '(';	
				$k = 0;
				foreach($str_fields2 as $field){
					if($k)
						$str_values .= ',';
					$value = isset($row[$field])?$row[$field]:'';
					if($use_mysql_real_escape_string){
						$value = $db -> escape_string($value);	
					}else{
					}
					$str_values  .=   "'".$value."'";
					$k ++;
				}
				$str_values .= ')';
				$i ++;
			}
			
			
			$sql = ' INSERT INTO  '.$table_name ;
			$sql .=  '('.$str_fields.") ";
			$sql .=  'VALUES '.$str_values." ";
			
			$id = $db->insert($sql);
			return $id;
		}
		
		/*
		 * Value need remove
		 */
		function _remove($where = '',$table_name = ''){
			$sql_where = '';
			if($where)
				$sql_where .= ' WHERE '.$where;
			if( !$table_name )
				$table_name = $this -> table_name ;
			$sql = " DELETE FROM ".$table_name. $sql_where;
			global $db;
			$rows = $db->affected_rows($sql);
			return $rows;
		}
		
		/*
		 * Return result
		 */
		function _get_result($where = '',$table_name = '',$field = 'id'){
			if(!$where)
				return;
			if(!$table_name)
				$table_name = $this -> table_name;
			$select = " SELECT ".	$field ." ";
			$query = $select."  FROM ".$table_name."
			WHERE ".$where ;
			
			global $db;
			$result = $db->getResult($query);
			return $result;
		}
		
		/*
		 * Update only param call
		 */
		function record_update($row,$id,$table_name = ''){
			if(!$table_name)
				$table_name = $this -> table_name;
			if(!count($row))
				return;
			
			$str_update = array();
			foreach($row as $key => $value){
				$str_update[] = "`".$key."` = '".$value."'";			
			}
			
			// convert to string
			$str_update = implode(',',$str_update);
			
			$sql = ' UPDATE  '.$table_name . ' SET ';
			$sql .=  $str_update;
			$sql .=  ' WHERE id = 	  '.$id.' ';
			
			global $db;
			$rows = $db->affected_rows($sql);
			if($rows)
				return $rows?$id:0;
		}
		
		
		function get_all_record($table_name,$ordering = ''){
			$query = " SELECT *
			FROM ".$table_name." WHERE published = 1 ";
			if($ordering)
				$query .= ' ORDER BY '.$ordering;
			global $db;
			$result = $db->getObjectList($query);
			return $result;
		}
		/*
		 * check exist name, alias
		 */
		function check_exist_alias($name,$alias,$id = '', $table_name){
			if(!$name || !$table_name)
				return;
			$query = " SELECT count(*)
			FROM ".$table_name." 
			WHERE (name = '".$name."'
			OR alias = '".$alias."') ";
			if($id)
				$query .= ' AND id <> '.$id.' ';
			
			global $db;
			$result = $db->getResult($query);
			return $result;
		}
		
		/*
		 * Remove img
		 */
		// remove image of id IN str_id
		function remove_image($sts_ids,$path_arr = array(),$field='image',$table_name= ''){
			if(!$sts_ids )
				return;
			if(!$table_name)	
				$table_name = $this -> table_name;
			
			$sql = " SELECT ".$field."
			FROM ".$table_name."
			WHERE  id IN (".$sts_ids.") ";
			;
			global $db;
			$list = $db->getObjectList($sql);
			
			for($i = 0; $i < count($list) ; $i ++){
				$image = $list[$i] -> $field;
				if($image)
					for($j = 0; $j < count($path_arr); $j ++ ){
						
						if(!@unlink($path_arr[$j].$image)){
							Errors::_('Not remove image'.$path_arr[$j].$image);
						}
					}
				}
				return true;
			}
			
		/*
		 * Note: Image link is fixed link. This have url_root
		 * Remove old width new method
		 */
		// remove image of id IN str_id
		function remove_old_image($sts_ids,$field='image',$table_name= ''){
			if(!$sts_ids)
				return;
			$path_arr = $this -> arr_img_paths;
			if(!$table_name)	
				$table_name = $this -> table_name;
			
			$sql = " SELECT ".$field."
			FROM ".$table_name."
			WHERE  id IN (".$sts_ids.") ";
			global $db;
			$list = $db->getObjectList($sql);
			
			for($i = 0; $i < count($list) ; $i ++){
				$image = $list[$i] -> $field;
				if($image){
//					$image = 	str_replace(URL_ROOT,PATH_BASE, $image);
					$image = 	PATH_BASE.str_replace('/',DS, $image);
					// if(!@unlink($image)){
					// 	Errors::_('Not remove image'.$image);
					// }
					for($j = 0; $j < count($path_arr); $j ++ ){
						$link = str_replace(DS.'original'.DS, DS.$path_arr[$j][0].DS, $image);
						$link_webp = $link.'.webp';

						if(!@unlink($link)){
							Errors::_('Not remove image'.$link);
						}
						if(!@unlink($link_webp)){
							Errors::_('Not remove image'.$link_webp);
						}
					}
				}
			}
			return true;
		}


		/*
		 * Remove file
		 */
		// remove file of id IN str_id
		function remove_file($sts_ids,$path_arr = array(),$field='image',$table_name= ''){
			if(!$sts_ids || !count($path_arr))
				return;
			if(!$table_name)	
				$table_name = $this -> table_name;
			
			$sql = " SELECT ".$field."
			FROM ".$table_name."
			WHERE  id IN (".$sts_ids.") ";
			global $db;
			$list = $db->getObjectList($sql);
			
			for($i = 0; $i < count($list) ; $i ++){
				$image = $list[$i] -> $field;
				if($image)
					for($j = 0; $j < count($path_arr); $j ++ ){
						
						if(!@unlink($path_arr[$j].$image)){
							Errors::_('Not remove image'.$path_arr[$j].$image);
						}
					}
				}
				return true;
			}
			
		/*
		 * Check exist of record in tables of language
		 */
		function check_translate($table_name,$rid){
			if(!$table_name)
				return false;
			global $db;
			$lang_arr = array('en','vi');
			$lang_current = $_SESSION['con_lang'];
			foreach($lang_arr as $lang){
				if($lang != $lang_current){
					$query = " SELECT id
					FROM ".$table_name."
					WHERE rid = $rid ";
					
					$result = $db->getResult($query);
					if($result)
						return true;
				}
			}
			return false;
		}
		/*
		 * get District
		 * default: Ha Noi
		 */
		function get_districts($city_id = '1473')
		{
			if(!isset($city_id))
				$city_id = 1473;
			global $db ;
			$sql = " SELECT id, name FROM fs_districts
			WHERE city_id = $city_id ";
			return $db->getObjectList($sql);
		}
		function get_cities_follow_country($country_id = '66'){
			if(!$country_id)
				$country_id = 1473;
			global $db ;
			$sql = " SELECT id, name FROM fs_cities
			WHERE country_id = $country_id ";
			return $db->getObjectList($sql);
		}
		
		function get_city()
		{
			global $db ;
			$sql = " SELECT id, name FROM fs_cities ";
			return $db->getObjectList($sql);
		}
		/*
		 * get Estore
		 */
		function get_estore(){
			$estore_id = $_SESSION['estore_id'];
			if(!$estore_id)
				return;
			
			global $db ;
			$sql = " SELECT *
			FROM fs_estores
			WHERE `id`  = '$estore_id' 
			";
			return $db->getObject($sql);
		}
		
		/*
		 * get rid
		 * 1. if rid exist: get Max rid
		 * 2. if rid not exist : get rid
		 */
		function get_record_id_for_language($table_name,$rid_need_check){
			if(!$table_name && !$rid_need_check)
				return 0;
			global $db;
			$lang_arr = array('en','vi');
			$lang_current = $_SESSION['con_lang'];
			$exist = 0;
			foreach($lang_arr as $lang){
				$query = " SELECT rid
				FROM ".$table_name.'_'.$lang."
				WHERE rid = $rid_need_check ";
				$result = $db->getResult($query);
				if($result){
					$exist = 1;
					break;
				}
			}
			if(!$exist)
				return $rid_need_check;
			$max_rid = 0;
			foreach($lang_arr as $lang){
				$query = " SELECT Max(rid) as max_rid
				FROM ".$table_name."
				";
				$result = $db->getResult($query);
				$max_rid = $max_rid > $result ? $max_rid: $result;
			}
			return $max_rid + 1; 
		}
		
		/*
	     * Save all record for list form
	     */
		function save_all(){
			$total = FSInput::get('total',0,'int');
			if(!$total)
				return true;
			global $db;
			$field_change = FSInput::get('field_change');
			if(!$field_change)
				return false;
          	// 	calculate filters: 
			$arr_table_name_changed = array();	
			$field_change_arr = explode(',',$field_change);
			$total_field_change = count($field_change_arr);
			$record_change_success = 0;
			for($i = 0; $i < $total; $i ++){
				$str_update = '';
				$update = 0;
				$row = array();
				foreach($field_change_arr as $field_item){
					$field_value_original = FSInput::get($field_item.'_'.$i.'_original')	;
					$field_value_new = FSInput::get($field_item.'_'.$i)	;
					if(is_array($field_value_new)){
						$field_value_new = count($field_value_new)?','.implode(',',$field_value_new).',':'';
					}
					
					if($field_value_original != $field_value_new){
						$update =1;
//	        	          $row[$field_item] = htmlspecialchars_decode($field_value_new);
						$row[$field_item] = $db -> escape_string($field_value_new);
//	        	          $row[$field_item] = $db -> escape_string($field_value_new);
//	        	          $str_update[] = "`".$field_item."` = '".$field_value_new."'";
					}    
				}
				if($update){
					$id = FSInput::get('id_'.$i, 0, 'int');
					$rs = $this -> _update($row,$this ->  table_name, '  id = '.$id,0 );
					if($this -> use_table_extend){
						$record = $this -> get_record('id = '.$id,$this ->  table_name);
						$table_extend = $record -> tablename;
	        			// calculate filters:
						$arr_table_name_changed[] = $table_extend;
						global $db;
						if($table_extend && $table_extend != 'fs_products' && $db -> checkExistTable($table_extend)){
							$rs = $this -> _update($row,$table_extend, '  record_id = '.$id );
						}
					}
					
		        	//synchronize
					$array_synchronize = $this -> array_synchronize;
					if(count($array_synchronize)){
						foreach($array_synchronize as $table_name => $fields){
							$j = 0;
							$syn = 0;
							$row5 = array();
							$where = ' WHERE ';
							foreach($fields as $cur_field => $syn_field){
								if(!$j){
									$where .= $syn_field .' = '.$id;
								}else{
									if(isset($row[$cur_field])){
										$row5[$syn_field] = $row[$cur_field];
										$syn = 1;
									}
								}
								$j ++;
							}
							if($syn)
								$rs = $this -> _update($row5,$table_name, $where,0 );
						}
					}
					
//		            if(!$rs)
//		                return false;
					$record_change_success ++;
				}
			}
			
	     	// calculate filters:
//			if($this -> calculate_filters){
//				$this -> caculate_filter($arr_table_name_changed);
//			}
			return $record_change_success;  
		}

		function sync_data($data_change, $data_sync){
			$id_change = $data_change[0];
			$table_change = $data_change[1];
			$data = $this-> get_record('id = '.$id_change,$table_change,'*');

			// echo 'id: '.$id_change.' / ';
			// print_r($data);
			// die;

			foreach ($data_sync as $sync) {
				$field_check = $sync['field_check'];
				$field_sync = $sync['field_sync'];
				$tablenames = $sync['tablenames'];
				$row = array();
				foreach ($field_sync as $key => $value) {
					$row[$key] = $data-> $value;
					// code...
				}

				foreach ($tablenames as $tablename) {
					$this-> _update($row,$tablename,$field_check.' = '.$id_change);
				}
				// print_r($row);die;
			}
		}

	  /*
         * Show list category of tags
         */
	  function get_tags_categories()
	  {
	  	global $db;
	  	$query = " SELECT a.*, a.parent_id as parent_id 
	  	FROM 
	  	".'fs_tags_categories'." AS a
	  	";
	  	$result = $db->getObjectList($query);
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
	  
	  function change_status($field,$value){
	  	if(!$field)
	  		return false;
	  	$ids = FSInput::get('id',array(),'array');
	  	if(count($ids))
	  	{
	  		global $db;
	  		$str_ids = implode(',',$ids);
	  		$sql = " UPDATE ".$this -> table_name."
	  		SET `".$field."` = $value
	  		WHERE id IN ( $str_ids ) " ;
	  		$rows = $db->affected_rows($sql);
	  		return $rows;
	  	}
	  	return 0;
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
			SET show_in_homepage = $value
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
		 * @Return: 1: tồn tại, 0: không tồn tại 
		 */
		function check_exist($value,$id = '',$field = 'alias',$table_name = ''){
			if(!$value)
				return false;
			if(!$table_name)
				$table_name = $this -> table_name;
			$query = " SELECT count(*)
			FROM ".$table_name." 
			WHERE 
			$field = '".$value."' ";
			if($id)
				$query .= ' AND id <> '.$id.' ';
			global $db;
			$result = $db->getResult($query);
			return $result;
		}
		/*
		 * Tạo ra alias mới nếu nó tồn tại 
		 */
		function genarate_alias_news($value,$id = '',$table_name = ''){
			if(!$value)
				return false;
			if(!$table_name)
				$table_name = $this -> table_name;
			$i = 1;
			while(true){
				$value_news = $value.'-'.$i; 
				if(!$this -> check_exist($value_news,$id)){
					return $value_news;
				}
				$i ++;
			}
		}

				/*
		 * Tạo ra alias mới nếu nó tồn tại 
		 */
				function genarate_value_news($value,$id = '',$field,$table_name = ''){
					if(!$value)
						return false;
					if(!$table_name)
						$table_name = $this -> table_name;
					$i = 1;
					while(true){
						$value_news = $value.'-'.$i; 
						if(!$this -> check_exist($value_news,$id,$field)){
							return $value_news;
						}
						$i ++;
					}
				}

				function upload_image($image_tag_name = 'image',$suffix = '', $max_size = 2000000,$arr_img_paths = array(),$img_folder = ''){
					if(!$img_folder)
						$img_folder = $this -> img_folder;
					$img_link = str_replace('\\', '/', $img_folder);
					$img_folder = str_replace('/', DS, $img_folder);
					$img_folder = PATH_BASE.$img_folder.DS;
					$fsFile = FSFactory::getClass('FsFiles');
			// upload
					$path = $img_folder.'original'.DS;
					if(!$fsFile -> create_folder($path)){
						Errors:: setError("Not create folder ".$path);
						return false;
					}

					$image = $fsFile -> uploadImage($image_tag_name, $path ,$max_size, $suffix);
					if(!$image)
						return false;
					if($this->image_watermark){
//				$fsFile->add_logo($path,$image,PATH_BASE.str_replace('/',DS, 'images/mask/default.png'),9);
					}	
					$img_link = $img_link.'/original/'.$image	;
					if(!count($arr_img_paths))
						$arr_img_paths = $this -> arr_img_paths;

					if(!count($arr_img_paths))
						return $img_link;
					foreach($arr_img_paths as $item){
						$path_resize = str_replace(DS.'original'.DS, DS.$item[0].DS, $path);

						$path_resize = str_replace('upload_images'.DS,'',$path_resize);
				// echo $path_resize;
				// die;
						$fsFile -> create_folder($path_resize);
						$method_resize = $item[3]?$item[3]:'resized_not_crop';
						if(!$fsFile ->$method_resize($path.$image, $path_resize.$image,$item[1], $item[2]))
							return false;	
						if(!$this->image_watermark) $this->image_watermark = FSInput::get ('image_watermark');
						if($this->image_watermark){
							if($item[0] == "resized" || $item[0] == "large"){
						// echo $path_resize,$image,PATH_BASE.str_replace('/',DS, 'images/mask/mask_'.$item[0].'.png'),5;
								$fsFile->add_logo($path_resize,$image,PATH_BASE.str_replace('/',DS, 'images/mask/mask_'.$item[0].'.png'),$this->image_watermark_pos);
								$fsFile->add_logo($path_resize,$image,PATH_BASE.str_replace('/',DS, 'images/mask/mask_'.$item[0].'_1.png'),$this->image_watermark_pos1);
							}
						}
						$file_ext = $fsFile -> getExt($img_link);
						$fsFile -> convert_to_webp($path_resize.$image,$file_ext);	

					}	
					return $img_link;	
				}

		/*
		Up ảnh phụ
		*/	
		function upload_image_sub($image_tag_name = 'image_sub',$suffix = '', $max_size = 2000000,$arr_img_paths = array(),$img_folder = ''){
			if(!$img_folder)
				$img_folder = $this -> img_folder;
			$img_link = str_replace('\\', '/', $img_folder);
			$img_folder = str_replace('/', DS, $img_folder);
			$img_folder = PATH_BASE.$img_folder.DS;
			$fsFile = FSFactory::getClass('FsFiles');
			// upload
			$path = $img_folder.'original'.DS;
			if(!$fsFile -> create_folder($path)){
				Errors:: setError("Not create folder ".$path);
				return false;
			}
			
			$image = $fsFile -> uploadImage($image_tag_name, $path ,$max_size, $suffix);
			if(!$image)
				return false;
			if($this->image_watermark){
				$fsFile->add_logo($path,$image,PATH_BASE.str_replace('/',DS, 'images/mask/default.png'),9);
			}	
			$img_link = $img_link.'/original/'.$image	;
			
			if(!count($arr_img_paths))
				return $img_link;
			foreach($arr_img_paths as $item){
				$path_resize = str_replace(DS.'original'.DS, DS.$item[0].DS, $path);
				$fsFile -> create_folder($path_resize);
				$method_resize = $item[3]?$item[3]:'resized_not_crop';
				if(!$fsFile ->$method_resize($path.$image, $path_resize.$image,$item[1], $item[2]))
					return false;	
				
			}	
			return $img_link;	
		}


		/*
		 * Duplicate ảnh
		 * $source_image là đường dẫn tương đối của ảnh
		 * $suffix_new: Thêm vào đuôi ảnh mới
		 */
		function duplicate_image($source_image,$suffix_new){
			if(!$source_image || !$suffix_new)
				return;
			$fsFile = FSFactory::getClass('FsFiles');
			$file_name = basename ( $source_image );
			$ext_image = $fsFile -> getExt($file_name);
			$file_name_not_ext = $fsFile -> getFileName($file_name,$ext_image);
			$file_name_new =  $file_name_not_ext.$suffix_new.'.'.$ext_image;
			$link_img_destination = str_replace('/'.$file_name, '/'.$file_name_new, $source_image);
			$path_source = PATH_BASE.str_replace('/',DS,$source_image);
			$path_destination = PATH_BASE.str_replace('/',DS,$link_img_destination);		
			$fsFile -> copy_file($path_source,$path_destination);

			$arr_img_paths = $this -> arr_img_paths;
			
			if(!count($arr_img_paths))
				return $img_link;
			// foreach($arr_img_paths as $item){

			// 	$path_source_resize = str_replace(DS.'original'.DS, DS.$item[0].DS, $path_source);
			// 	//$path_source_resize = str_replace('upload_images/','', $path_source);
			// 	$path_destination_resize = str_replace(DS.'original'.DS, DS.$item[0].DS, $path_destination);
			// 	//$path_destination_resize = str_replace('upload_images/','', $path_destination_resize);
			// 	echo $path_destination_resize;
			// 	die;

			// 	$fsFile -> copy_file($path_source_resize,$path_destination_resize);
			
			// 	$file_ext = $fsFile -> getExt($path_destination_resize);
			
			// 	// print_r( $arr_img_paths);
			// 	// die;
			// 	$fsFile -> convert_to_webp($path_destination_resize,$file_ext);	
			// }


			foreach($arr_img_paths as $item){
				$path_source_resize = str_replace(DS.'original'.DS, DS.$item[0].DS, $path_source);
				$path_source_resize = str_replace('upload_images'.DS, '', $path_source_resize);
				$path_destination_resize = str_replace(DS.'original'.DS, DS.$item[0].DS, $path_destination);
				$path_destination_resize = str_replace('upload_images'.DS, '', $path_destination_resize);
				
				$fsFile -> copy_file($path_source_resize,$path_destination_resize);

				$file_ext = $fsFile -> getExt($path_destination_resize);
				$fsFile -> convert_to_webp($path_destination_resize,$file_ext);	
			}	
			return $link_img_destination;	
		}
		

				/*
		 * Duplicate ảnh
		 * $source_image là đường dẫn tương đối của ảnh
		 * $suffix_new: Thêm vào đuôi ảnh mới
		 */
				function duplicate_image_other($source_image,$suffix_new){
					if(!$source_image || !$suffix_new)
						return;
					$fsFile = FSFactory::getClass('FsFiles');
					$file_name = basename ( $source_image );
					$ext_image = $fsFile -> getExt($file_name);
					$file_name_not_ext = $fsFile -> getFileName($file_name,$ext_image);
					$file_name_new =  $file_name_not_ext.$suffix_new.'.'.$ext_image;
					$link_img_destination = str_replace('/'.$file_name, '/'.$file_name_new, $source_image);
					$path_source = PATH_BASE.str_replace('/',DS,$source_image);
					$path_destination = PATH_BASE.str_replace('/',DS,$link_img_destination);		
					$fsFile -> copy_file($path_source,$path_destination);

					$arr_img_paths = $this -> arr_img_paths_other;

					if(!count($arr_img_paths))
						return $img_link;
			// foreach($arr_img_paths as $item){

			// 	$path_source_resize = str_replace(DS.'original'.DS, DS.$item[0].DS, $path_source);
			// 	//$path_source_resize = str_replace('upload_images/','', $path_source);
			// 	$path_destination_resize = str_replace(DS.'original'.DS, DS.$item[0].DS, $path_destination);
			// 	//$path_destination_resize = str_replace('upload_images/','', $path_destination_resize);
			// 	echo $path_destination_resize;
			// 	die;

			// 	$fsFile -> copy_file($path_source_resize,$path_destination_resize);

			// 	$file_ext = $fsFile -> getExt($path_destination_resize);

			// 	// print_r( $arr_img_paths);
			// 	// die;
			// 	$fsFile -> convert_to_webp($path_destination_resize,$file_ext);	
			// }


					foreach($arr_img_paths as $item){
						$path_source_resize = str_replace(DS.'original'.DS, DS.$item[0].DS, $path_source);
						$path_source_resize = str_replace('upload_images'.DS, '', $path_source_resize);
						$path_destination_resize = str_replace(DS.'original'.DS, DS.$item[0].DS, $path_destination);
						$path_destination_resize = str_replace('upload_images'.DS, '', $path_destination_resize);

						$fsFile -> copy_file($path_source_resize,$path_destination_resize);

						$file_ext = $fsFile -> getExt($path_destination_resize);
						$fsFile -> convert_to_webp($path_destination_resize,$file_ext);	
					}	
					return $link_img_destination;	
				}


				function update_sitemap($str_categories_id,$table_name = 'fs_news_categories',$module = 'news'){
					global $db;
					$sql = " SELECT * FROM  fs_sitemap
					WHERE record_id IN ( $str_categories_id ) 
					AND table_name = '".$table_name."'
					AND module = '".$module."'
					" ;
					$list_exit = $db->getObjectList($sql);
					$array_record_exit = array();
					$array_field = array('name','alias','alias_wrapper','parent_id','list_parents','level','published','ordering','created_time','updated_time');
					foreach($list_exit as $item){
						$record = $this -> get_record_by_id($item -> record_id,$table_name);
						if(!$record){
							$this -> _remove('record_id = '.$item -> record_id,'fs_sitemap' );
							continue;
						}
						$row = array();

						$row['record_id'] =  $record -> id;
						$row['module'] =  $module;
						$row['table_name'] =  $table_name;
						foreach($array_field as $field){
							$row[$field] =  $record -> $field;
						}
						$this -> _update($row, 'fs_sitemap','  record_id = '.$record -> id.' AND module = "'.$module.'" AND table_name = "'.$table_name.'"');
						$array_record_exit[] = $record -> id;
					}

					$arr_categories_id = explode(',',$str_categories_id);
					foreach($arr_categories_id as $item){

						if(in_array($item, $array_record_exit))
							continue;
						$record = $this -> get_record_by_id($item ,$table_name);
						if(!$record){
							$this -> _remove('record_id = '.$item,'fs_sitemap' );	
							continue;			
						}
						$row = array();

						$row['record_id'] =  $record -> id;
						$row['module'] =  $module;
						$row['table_name'] =  $table_name;
						foreach($array_field as $field){
							$row[$field] =  $record -> $field;
						}
						$this -> _add($row, 'fs_sitemap');
					}
				}
				function call_update_sitemap(){
					$cids = FSInput::get('id',array(),'array');
					if(!count($cids))
						return false;
					$str_cids = implode(',',$cids);
					$this -> update_sitemap($str_cids,$this -> table_name,$this -> module);
				}

	/*
		 * select in category
		 */
	function get_categories_tree()
	{
		global $db;
		$query = $this->setQuery();
		$result = $db->getObjectList($query);
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
		 * select in category of home
		 */
	function get_categories_tree_all()
	{
		global $db;
		$query = " SELECT a.*
		FROM 
		".$this -> table_category_name." AS a 
		ORDER BY ordering ";
		$result = $db->getObjectList($query);
		$tree  = FSFactory::getClass('tree','tree/');
		$list = $tree -> indentRows2($result);
		return $list;
	}
	
	/************************************************************************************************/
	/*  CALCULATE FILTER *****/
	/************************************************************************************************/
		/*
		 * Tính toán filter
		 * Nếu có $categories_id thì ta chỉ xét cho mỗi id này. NẾu không có ta phải xét tất
		 */
		function caculate_filter($arr_table_name = array(),$categories_id = null){
			// caculate for table fs_TYPE
//			$this -> calculate_filter_common();
			if(!count($arr_table_name))
				return true;
			foreach($arr_table_name as $table_name){
				// caculate for table fs_TYPE_extend
				$this -> calculate_filter_extend($table_name,$categories_id);
			}
			return true;
		}
		/*
		 * Xóa filter theo bảng hoặc category
		 */
		function remove_filters($arr_table_name = array(), $arr_categories_id = array()){
			// caculate for table fs_TYPE
			$this -> calculate_filter_common();
			if(count($arr_table_name)){
				foreach($arr_table_name as $table_name){
					// caculate for table fs_TYPE_extend
					$this -> _remove(' tablename = "'.$table_name.'"','fs_'.$this -> type.'_filters_values');	
				}		
			}
			if(count($arr_categories_id)){
				foreach($arr_categories_id as $category_id){
					// caculate for table fs_TYPE_extend
					$this -> _remove(' category_id = "'.$category_id.'"','fs_'.$this -> type.'_filters_values');	
				}		
			}
			return true;
		}
		
		function calculate_filter_common(){
			// get data from fs_TYPE
			$data = $this -> get_records('published = 1','fs_'.$this -> type);
			// get filter common
			$filters = $this -> get_records('is_common = 1','fs_'.$this -> type.'_filters');
			// get categories
			$categories = $this -> get_records('','fs_'.$this -> type.'_categories');
			
			if(!count($data) || !count($filters))
				return;
			$arr_filter = array(); 	

			$arr_filter_id_current = array();
			$arr_filter_fieldname_current = array();
			$array_exit = array();
			
			foreach( $data as $item){
				// duyệt ko có category
				$rs = $this -> genate_array_filter($arr_filter,$filters,$arr_filter_id_current,$arr_filter_fieldname_current,$array_exit ,$item,0);
				$arr_filter = $rs[0];
				$array_exit = $rs[1];
				if(count($categories)){
					foreach($categories as $category){
						$rs = $this -> genate_array_filter($arr_filter,$filters,$arr_filter_id_current,$arr_filter_fieldname_current,$array_exit ,$item,$category -> id);
						$arr_filter = $rs[0];
						$array_exit = $rs[1];
					}
				}
			}
			$this -> save_filter($arr_filter,$filters,'fs_'.$this -> type,$categories);
			return true;
		}
		
		/*
		 * Đêm bộ lọc trong trường bảng mở rộng
		 * Nếu $categories_id rỗng ta phải xét hết categories
		 */
		function calculate_filter_extend($table_name,$category_id =  null){
			// get filter 
			$filters = $this -> get_records(' tablename = "'.$table_name.'" OR tablename ="fs_'.$this -> type.'"','fs_'.$this -> type.'_filters','*',null,null,'id');
			
			// get categories
			if($category_id)
				$categories = $this -> get_records('id = '.$category_id,'fs_'.$this -> type.'_categories','*',null,null,'id');
			else
				$categories = $this -> get_records(' tablename = "'.$table_name.'"','fs_'.$this -> type.'_categories','*',null,null,'id');
			
			if(!count($filters))
				return;
			$arr_filter = array(); 	

			$arr_filter_id_current = array();
			$arr_filter_fieldname_current = array();
			$array_exit = array();
			// get data from fs_TYPE_extend
			$limit_for_data = 50;// số sản phẩm mỗi lần tính toán
			$total_data =  $this -> get_count('published = 1',$table_name);
			$repeat = ceil($total_data/$limit_for_data);
			
			for($k = 0; $k < $repeat; $k ++){
				$start = $k * $limit;
				
				$data = $this -> get_records('published = 1',$table_name,'*','',''.$start.','.$limit_for_data);
				foreach( $data as $item){
					// duyệt ko có category
					$rs = $this -> genate_array_filter($arr_filter,$filters,$arr_filter_id_current,$arr_filter_fieldname_current,$array_exit ,$item,0);
					$arr_filter = $rs[0];
					$array_exit = $rs[1];
					if(count($categories)){
						foreach($categories as $category){
							$rs = $this -> genate_array_filter($arr_filter,$filters,$arr_filter_id_current,$arr_filter_fieldname_current,$array_exit ,$item,$category -> id);
							$arr_filter = $rs[0];
							$array_exit = $rs[1];
						}
					}
				}
			}
			$this -> save_filter($arr_filter,$filters,$table_name,$categories);
			return true;
		}
		/*
		 * sinh mang filter khong co category
		 * $arr_filter_id_current : (Mảng id của các filter đang duyệt tới) có dạng:  (2,3,4)  
		 * $arr_filter_fieldname_current : mảng field_name của các filter đang duyệt tới. Để tránh duyệt cùng 1 fieldname .có dạng:  ('color','body','...) 
		 * $array_exit: có dạng array('0,1,2' => '2,0,1') dùng để check các filter đã duyệt. VD [1][2][3] = [2][1][3] sẽ bị trùng nhau 
		 * Thay đổi sau mỗi lần đệ quy: $arr_filter,$array_exit
		 */
		function genate_array_filter($arr_filter,$filters,$arr_filter_id_current,$arr_filter_fieldname_current,$array_exit ,$record,$category_id = 0){
			// check categories
			if($category_id && !($this -> check_item_in_category($category_id,$record) ))
				return array(0=> $arr_filter, 1 => $array_exit);

			// check xem đã duyệt lặp ngược chưa. Nếu rồi thì ko duyệt filter con nữa
			if($this -> check_exits($array_exit,$arr_filter_id_current,$category_id)){
				return array(0=> $arr_filter, 1 => $array_exit);
			}
			
			$str_ids_parent = count($arr_filter_id_current)? implode(',', $arr_filter_id_current):'';
			// duyệt con
			foreach($filters as $filter){
				// khong duyệt cùng field_name
				if(in_array($filter -> field_name,$arr_filter_fieldname_current))
					continue;
				$str_ids_current = $str_ids_parent?$str_ids_parent.',':'';	
				$str_ids_current .= $filter -> id;
				if(!isset($arr_filter[$category_id][$str_ids_current]))
					$arr_filter[$category_id][$str_ids_current] = 0;
				if($this -> calculate_record_compatible_filter($record,$filter -> filter_value,$filter -> calculator,$filter -> field_name)){
					$arr_filter[$category_id][$str_ids_current] ++;
					
					// gọi đệ quy để duyệt con:
					$arr_filter_id_current_child = $arr_filter_id_current;
					$arr_filter_id_current_child[] = $filter -> id;
					$arr_filter_fieldname_current_child = $arr_filter_fieldname_current;
					$arr_filter_fieldname_current_child[] = $filter -> field_name;
					$array_exit_child = $this -> generate_filter_array_exit($array_exit, $filter -> id, $arr_filter_id_current,$category_id);
					$array_exit = $array_exit_child;
					$rs = $this -> genate_array_filter($arr_filter,$filters,$arr_filter_id_current_child,$arr_filter_fieldname_current_child,$array_exit ,$record,$category_id);
//					$rs = $this -> genate_array_filter($arr_filter,$filters,$arr_filter_id_current_child,$arr_filter_fieldname_current_child,$array_exit_child ,$record,$category_id);
					$arr_filter = $rs[0];
					$array_exit = $rs[1];
				}
			}
			return array(0=> $arr_filter, 1 => $array_exit);
		}
		
		function calculate_filter_common_for_category($data){
			
		}
		
		/*
		 * Kiểm tra trùng lặp khi duyệt trong trường hợp đảo duyệt. VD [1][2][3] = [2][1][3] sẽ bị trùng nhau
		 * $array_exit: có dạng array('0,1,2' => '2,0,1') dùng để check các filter đã duyệt. VD [1][2][3] = [2][1][3] sẽ bị trùng nhau
		 * true: đã tồn tại
		 * false: chưa => phải duyệt
		 */
		function check_exits($array_exit = array(),$arr_filter_id_current = array(), $category_id = 0){
			// chưa tồn tại => true
			if(!count($array_exit) || !count($arr_filter_id_current))
				return false;
			// sắp xếp lại:
			$arr_filter_id_current_sort = $arr_filter_id_current;
			asort($arr_filter_id_current_sort);

			// chuyển qua chuỗi
			$str_filter_fieldname_current_sort = implode(',', $arr_filter_id_current_sort);	
			$str_filter_fieldname_current = implode(',', $arr_filter_id_current);
			
			// nếu chưa tồn tại trong mảng array_exit
			if(!isset($array_exit[$category_id][$str_filter_fieldname_current_sort]))
				return false;
			
			// kiểm tra xem có giống mảng đang gọi ko?	
			if($array_exit[$category_id][$str_filter_fieldname_current_sort] != $str_filter_fieldname_current)
				return true;
			
			return false;
		}
		
		/*
		 * Tính toán xem record này có thỏa mãn điều kiện filter đưa ra
		 * record: 1 record
		 * math: filter math
		 * field: filter filter
		 * return: yes or no
		 */
		function calculate_record_compatible_filter($record,$filter_value,$math,$field){
			
			$record_value = @$record -> $field;
			$filter_value1 = '';
			$filter_value2 = '';
			if($math > 9 && $math < 14)
			{
				$arr_value = explode(",",$filter_value,2);
				$filter_value1 = @$arr_value[0]?$arr_value[0]:"";
				$filter_value2 = @$arr_value[1]?$arr_value[1]:"";
			}
			
			switch ($math){	
				case '1':
				return false;
				case '2': // LIKE
				if($filter_value){
					if(stripos(mb_strtolower($record_value,'UTF-8'), $filter_value) !== false){
						return true;
					}
				}
				return false;
				case '3':	// Null	
				if(!$record_value || trim($record_value) == "")
					return true;
				return false;
				case '4':
				if(trim($record_value) != "")
					return true;
				return false;
				case '5': //==
				if( $record_value == $filter_value)
					return true;
				return false;
				case '6':
				if( $record_value > $filter_value)
					return true;
				return false;
				case '7':
				if( $record_value < $filter_value)
					return true;
				return false;
				case '8':
				if( $record_value >= $filter_value)
					return true;
				return false;
				case '9':
				if( $record_value <= $filter_value)
					return true;
				return false;
				case '10':
				if( $record_value > $filter_value1 && $record_value < $filter_value2)
					return true;
				return false;
				case '11':
				if( $record_value > $filter_value1 && $record_value <= $filter_value2)
					return true;
				return false;
				case '12':
				if( $record_value >= $filter_value1 && $record_value < $filter_value2)
					return true;
				return false;
				case '13':
				if( $record_value >= $filter_value1 && $record_value < $filter_value2)
					return true;
				return false;
				case '14': //FOREIGN_ONE
				if( $record_value == $filter_value){
					return true;
				}
				return false;
				case '15': //FOREIGN_MULTI
				if($filter_value){
					if(stripos(mb_strtolower($record_value,'UTF-8'), ','.$filter_value.',') !== false){
						return true;
					}
				}
				return false;
				default:
				return false;
			}
		}
		
		/*
		 * Sinh ra mảng chứa các filter_id đã duyệt
		 */
		function generate_filter_array_exit($array_exit, $filter_id, $filter_parrent_id,$category_id){
			$filter_parrent_current = $filter_parrent_id;
			$filter_parrent_current[] = $filter_id;
			$filter_parrent_current_sort = $filter_parrent_current;
			asort($filter_parrent_current_sort);
			$str_filter_parrent_current_sort = implode(',', $filter_parrent_current_sort);
			// nếu tồn tại thì ko thực hiện
			if(isset($array_exit[$category_id][$str_filter_parrent_current_sort]))
				return $array_exit;
			$array_exit[$category_id][$str_filter_parrent_current_sort] = implode(',', $filter_parrent_current);
			return $array_exit;
		}
		
		/*
		 * Kiểm tra xem item này có nằm trong category ko
		 */
		function check_item_in_category($category_id,$record){
			if(!$category_id)
				return false;
			if(stripos(mb_strtolower($record -> category_id_wrapper,'UTF-8'), ','.$category_id.',') !== false)
				return true;
			return false;
		}
		
		/*
		 * table_name == ''? common:extend
		 * $arr_filter: mảng kết quả filter sau khi tính toán
		 * $filters: mảng filter lấy từ db ra để đối chiếu
		 * $calculator_empty: có tính toán với biến count == 0 hay ko?
		 */
		function save_filter($arr_filter,$filters,$table_name = '',$categories,$calculator_empty = 0){
			if(!count($arr_filter))
				
				return;
			
			// remove old common data
			$this -> _remove('is_common = 1','fs_'.$this -> type.'_filters_values');
			// remove old extend data
			if($table_name){ 
				$this -> _remove('tablename = "'.$table_name.'"','fs_'.$this -> type.'_filters_values');
			}
			
			foreach($arr_filter as $category_id => $filters_in_cat){
				if(!count($filters_in_cat))
					continue;
				$category_alias  = 	$category_id?$categories[$category_id] -> alias:'';
				foreach( $filters_in_cat as $ids => $count){
					// nếu không đếm trường hợp count == 0
					if(!$calculator_empty && !$count)
						continue;
					$row = array();	
					$arr_ids = explode(',',$ids);
					$url_id = '';
					$url_alias = '';
					$total_ids = count($arr_ids);
					$j = 0;
					
//					$common = 0;
					for($i = $total_ids - 1; $i >= 0 ; $i -- ){
						if($i == ($total_ids - 1) ){
							$filter_current_id  =  $arr_ids[$i];
						} else {
							if(!$j){
								$url_id .= ',';
								$url_alias .= ',';
							}
							$url_id .= $arr_ids[$i].',';
							$url_alias .= $filters[$arr_ids[$i]] -> alias.',';
//							if(!$common && $filters[$arr_ids[$i]] -> is_common)
//								$common = 1 ;
							$j ++;
						}
					}	
					$filter_current = $filters[$filter_current_id];
					
					// row
					$row['category_id'] = $category_id;
					$row['category_alias'] = $category_alias;
					$row['url_ids'] = $url_id;
					$row['url_alias'] = $url_alias;
					$row['url_total_params'] = ($total_ids - 1);
					$row['record_id'] = $filter_current_id;
					$row['total'] = $count;
					$row['filter_show']  = $filter_current -> filter_show;
//					$row['tablename']  = $filter_current -> tablename;
					$row['tablename']  = $table_name;
					$row['field_name']  = $filter_current -> field_name;
					$row['field_show']  = $filter_current -> field_show;
					$row['alias']  = $filter_current -> alias;
					$row['calculator']  = $filter_current -> calculator;
					$row['calculator_show']  = $filter_current -> calculator_show;
					$row['filter_value']  = $filter_current -> filter_value;
					$row['published']  = $filter_current -> published;
					$row['is_common']  = $filter_current -> is_common;
					$row['is_condition']  = $filter_current -> is_condition;
					$this -> _add($row, 'fs_'.$this->type.'_filters_values');	
				}
			}
		}
		
		/*
		 * Đồng bộ lại trường liên quan, nếu A chọn B là relate thì B sẽ coi A là relate
		 */
		function sys_related($table_name = 'fs_news',$field_name = 'products_related',$record_ids ,$id){
			if(!$table_name || !$field_name || !$record_ids || !$id)
				return false;
			$list = $this -> get_records(' id IN (0'.$record_ids.'0) AND ('.$field_name.' NOT LIKE "%,'.$id.',%"  OR products_related IS NULL ) ' ,$table_name);
			foreach($list as $item){
				$related_value = $item -> $field_name;
				if(!$related_value)
					$related_value .= ',';
				$related_value .= $id.',';
				$row[$field_name] = $related_value;
				$this -> _update($row, $table_name,' id = '.$item -> id);
			}
		}
		
		function _update_column($table_name,$column_name = '',$value ='NULL'){
			$sql = 'UPDATE '.$table_name.' SET ' .$column_name.' = '.$value ;
			global $db;
			$rows = $db->affected_rows($sql);
			return $rows;
		}
		
		/*
		 * save into extension table
		 * (insert or update)
		 */
		function save_extension_exel($tablename, $record_id, $row_exel) {
			
			$data = $this->get_record ( 'id = ' . $record_id, $this->table_name );
			global $db;
			// field default: cai nay can xem lai vi hien dang ko su dung. Can phai su dung de luoc bot cac  truong thua
			$field_default = $this->get_records ( ' type = "' . $this->type . '"  ', 'fs_tables' );
			if (! $record_id)
				return;
			
			if (! $db->checkExistTable ( $tablename ))
				return;
			// data same fs_TYPE
			$row ['record_id'] = $record_id;
			$fields_all_of_ext_table = $this->get_field_table ( $tablename, 1 );
			foreach ( $data as $field_name => $value ) {
				if ($field_name == 'id' || $field_name == 'tablename')
					return;
				if (! isset ( $fields_all_of_ext_table [$field_name] ))
					return;
				$row [$field_name] = $value;
			}
			if($row_exel)
				$row2 = array_merge($row, $row_exel);
			else 
				$row2 = $row;
			$check_id = $this ->check_exist($record_id,$id = '','record_id',$tablename);
			if ($check_id) {
				return $this->_update ( $row2, $tablename, ' record_id =  ' . $record_id );
			} else {
				return $this->_add ( $row2, $tablename );
			}
			return;
		}
		
		function getExtendFields_exel($tablename) {
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
			AND field_name <> 'id' ";
			$result = $db->getObjectList ($query);
			
			return $result;
		}
		function buff_loop( $field_group,$table_name = ''){
			if(!$field_group)
				return false;
			$str_id = '';	
			$query ="	SELECT id , count(".$field_group.") as c , MAX(id) as mid
				FROM ".$table_name."
				GROUP BY ".$field_group."
				HAVING c >= 1
				";
				global $db;
				$arr_group_duplicate = $db->getObjectList($query);

				if(count($arr_group_duplicate)){
					$i = 0;
					foreach($arr_group_duplicate as $item)
					{
						if ($i)
							$str_id .= ',';
						$str_id .= $item->mid;
						$i++;	

					}

					$query1 = "	SELECT id , count(".$field_group.") as c 
						FROM ".$table_name."
						GROUP BY ".$field_group."
						HAVING c = 0
						";
						global $db;
						$arr_no_duplicate = $db->getObjectList($query1);
						$j = 0;		
						if(count($arr_no_duplicate)){
							$str_id .= ',';
							foreach($arr_no_duplicate as $item)
							{
								if ($j)
									$str_id .= ',';
								$str_id .= $item->id;
								$j++;	

							}
						}
					}
					if(!$str_id)
						return;


			// remove in multil
					$sql = " DELETE FROM ".$table_name."
					WHERE id NOT IN ($str_id)";

					global $db;
					$rows = $db->affected_rows ($sql);

					return $rows;

				}
		 /**
         * Upload và resize ảnh
         * 
         * @return Bool
         */ 
		 function upload_other_images(){
		 	$module = FSInput::get('module');
		 	global $db;
		 	$cyear = date ( 'Y' );
		 	$cmonth = date ( 'm' );
		 	$cday = date ( 'd' );
		 	
		 	$path = PATH_BASE.'images'.DS.$module .DS.$cyear.DS.$cmonth.DS.$cday.DS.'original'.DS;
		 	require_once(PATH_BASE.'libraries'.DS.'upload.php');
		 	$upload = new  Upload();
		 	$upload->create_folder ( $path );
		 	
		 	$file_name = $upload -> uploadImage('file', $path, 10000000, '_' . time () );

             // xoay ảnh trên IOS và save ghi đè lên ảnh cũ.
            require_once($_SERVER['DOCUMENT_ROOT'].'/libraries/lib/WideImage.php'); // Gọi thư viện WideImage.php
            $uploadedFileName = $path.$file_name;  // lấy ảnh từ  đã upload lên 
            $load_img = WideImage::load($uploadedFileName);
            $exif = exif_read_data($uploadedFileName); // 
            $orientation = @$exif['Orientation'];                        
            if(!empty($orientation)) {
            	switch($orientation) {
            		case 8:
            		$image_p = imagerotate($uploadedFileName,90,0);
                        //echo 'It is 8';
            		break;
            		case 3:
            		$image_p = imagerotate($uploadedFileName,180,0);
            		
                        //echo 'It is 3';
            		break;
            		case 6:
            		$load_img->rotate(90)->saveToFile($uploadedFileName);
                        //$image_p = imagerotate($uploadedFileName,-90,0);
                        //echo 'It is 6';
            		break;
            		
            	}
                //imagejpeg ( $image_p , $path.'test.jpg' ,  100 );              
            } 
            // END save ảnh xoay trên IOS   

            if(is_string($file_name) and $file_name!='' and !empty($this->arr_img_paths_other)){
	   //      	foreach ( $this->arr_img_paths_other as $item ) {
				// 	$path_resize = str_replace ( '/original/', '/'. $item [0].'/', $path );
				// 	$upload->create_folder ( $path_resize );
				// 	$method_resize = $item [3] ? $item [3] : 'resized_not_crop';
				// 	$upload->$method_resize ( $path . $file_name, $path_resize . $file_name, $item [1], $item [2] );
				// }
            	$fsFile = FSFactory::getClass('FsFiles');
            	foreach($this->arr_img_paths_other as $item){
            		$path_resize = str_replace(DS.'original'.DS, DS.$item[0].DS, $path);
            		$fsFile -> create_folder($path_resize);
            		$method_resize = $item[3]?$item[3]:'resized_not_crop';
            		if(!$fsFile ->$method_resize($path.$file_name, $path_resize.$file_name,$item[1], $item[2]))
            			return false;	
            		
            	}	
            }
            $data = base64_decode(FSInput::get('data'));
            $data = explode('|', $data);
            $row = array();
            if($data[0] == 'add')
            	$row['session_id'] = $data[1];
            else
            	$row['record_id'] = $data[1];
            $row['image'] = 'images/'.$module .'/'.$cyear.'/'.$cmonth.'/'.$cday.'/'.'original'.'/'.$file_name;
            $row['title'] = $_FILES['file']['name'];
            $rs = $this -> _add($row, 'fs_'.$module .'_images');
            
            return $rs ;
        }  
		// $fsFile = FSFactory::getClass('FsFiles');
		// 	// upload
		// 	$path = $img_folder.'original'.DS;
		// 	if(!$fsFile -> create_folder($path)){
	 //    		Errors:: setError("Not create folder ".$path);
  //   			return false;
	 //    	}
        
		// 	$image = $fsFile -> uploadImage($image_tag_name, $path ,$max_size, $suffix);
		// 	if(!$image)
		// 		return false;
		// 	if($this->image_watermark){
		// 		$fsFile->add_logo($path,$image,PATH_BASE.str_replace('/',DS, $this->image_watermark['path_image_watermark']),$this->image_watermark['position']);
		// 	}	
		// 	$img_link = $img_link.'/original/'.$image	;
		// 	if(!count($arr_img_paths))
		// 		$arr_img_paths = $this -> arr_img_paths;
        
		// 	if(!count($arr_img_paths))
		// 		return $img_link;
        
        function delete_other_image($record_id = 0){
        	$reocord_id = FSInput::get('reocord_id',0,'int');
        	$file_name = FSInput::get('name');
        	$id = FSInput::get('id');

        	$module = FSInput::get('module');
        	global $db;

        	$where = '';
        	if($file_name){
        		$where .= ' AND title = \''.$file_name.'\'';
        	}else{
        		$where .= ' AND id = '.$id;
        	}

        	if($reocord_id){
        		$where .= ' AND record_id = ' . $reocord_id ;  
        	}

        	$query = '  SELECT *
        	FROM fs_'.$module .'_images
        	WHERE  1 = 1 ' . $where;
        	$images = $db->getObject($query);
        	if($images){
        		$query = '  DELETE FROM fs_'.$module .'_images
        		WHERE id = \''.$images->id.'\'';
        		$db->query($query);
        		$path = PATH_BASE.$images->image;

        		@unlink($path);
        		foreach ( $this->arr_img_paths_other as $image){
        			@unlink(str_replace ( '/original/', '/'. $image[0] .'/', $path));
        		}
        	} 
        }
        
        function sort_other_images(){
        	$module = FSInput::get('module');
        	global $db;
        	if(isset($_POST["sort"])){
        		if(is_array($_POST["sort"])){
        			foreach($_POST["sort"] as $key=>$value){
        				$db->query("UPDATE fs_".$module."_images SET ordering = $key WHERE id = $value");
        			}
        		}
        	}
        }
        function change_text_image() {
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
        	
        	$row ['content'] = $value;
        	
        	$rs = $this->_update ( $row, 'fs_' . $this->type . '_images', ' id = ' . $id . $where );
        	return $rs;
        }

        function delete_image(){
        	$field = FSInput::get ( 'field' );

        	$id = FSInput::get ( 'id' );
        	$module = FSInput::get ( 'module' );
        	$view = FSInput::get ( 'view' );
        	global $db;
        	$row[$field] = '';
        	if($id){
        		$query = '  SELECT *
        		FROM '.$this->table_name .'
        		WHERE  1 = 1 AND id='.$id;
        		$images = $db->getObject($query);
        		
        		if($images){
        			
        			$path = PATH_BASE.$images-> $field;


        			@unlink($path);
        			@unlink($path.'.webp');
        			
        			
        			@unlink(str_replace ( '/original/', '/resized/', $path));
        			@unlink(str_replace ( '/original/', '/resized/', $path.'.webp'));
        			@unlink(str_replace ( '/original/', '/large/', $path));
        			@unlink(str_replace ( '/original/', '/large/', $path.'.webp'));
        			@unlink(str_replace ( '/original/', '/compress/', $path));
        			@unlink(str_replace ( '/original/', '/compress/', $path.'.webp'));
        			@unlink(str_replace ( '/original/', '/small/', $path));
        			@unlink(str_replace ( '/original/', '/small/', $path.'.webp'));
        			
        		}
        	}
        	
        	$rs = $this->_update ( $row, $this->table_name, ' id = ' . $id);

        	return $rs;
        }

        
		/*
		 * Đánh dấu đang đọc
		 */
		function assign_editing($id){
			$row['current_userid'] = $_SESSION['ad_userid'];
			$row['view_last_time'] = time();
			$this -> _update($row,$this->table_name,' id = '.$id);
		}
		/*
		 * Đánh dấu bỏ đọc
		 */
		function assign_without_editing($id){
			if(!$id)
				return;
			$row['current_userid'] = 0;
			$row['view_last_time'] = 0;
			$this -> _update($row,$this->table_name,' id = '.$id);
		}

		function get_user_by_id($user_id){
			return $this -> get_result('id='.$user_id,'fs_users','username');
		}

		function get_wrap_id_warehouses(){
			$users = $this -> get_record('id = ' . $_SESSION['ad_userid'],'fs_users');
			if($users-> wrap_id_warehouses){
				$wrap_id_warehouses =  substr($users-> wrap_id_warehouses, 1, -1);
			}else{
				$wrap_id_warehouses = '0';
			}
			return $wrap_id_warehouses;
		}


		

		function add_shoot($data){
			$row = array();
			$row['order_uploads_id'] = $data-> record_id;
			$row['order_uploads_detail_id'] = $data-> id;
			$row['platform_id'] = $data-> platform_id;
			$row['warehouse_id'] = $data-> warehouse_id;
			$row['shop_name'] = $data-> shop_name;
			$row['shop_id'] = $data-> shop_id;
			$row['shop_code'] = $data-> shop_code;
			$row['date'] = $data-> date;
			$row['code'] = $data-> code;
			$row['sku'] = $data-> sku;
			$row['color'] = $data-> color;
			$row['size'] = $data-> size;
			$row['date_shoot'] = date('Y-m-d');
			$row['sku_nhanh'] = $data-> sku_nhanh;
			$row['count'] = $data-> count;
			$row['shipping_unit_name'] = $data-> shipping_unit_name;
			$row['shipping_unit_id'] = $data-> shipping_unit_id;
			$row['house_id'] = $data-> house_id;
			$row['weight'] = $data-> weight;
			$row['lazada_sku'] = $data-> lazada_sku;
			$row['user_id'] = $data-> user_id;
			$row['product_id'] = $data-> product_id;
			$row['product_code'] = $data-> product_code;
			$row['product_price'] = $data-> product_price;
			$row['total_price'] = $data-> total_price;
			$row['tracking_code'] = $data-> tracking_code;
			$row['product_name'] = $data-> product_name;
			$row['created_time'] = date('Y-m-d H:i:s');
			$row['action_userid'] = $_SESSION ['ad_userid'];
			$row['action_username'] = $_SESSION ['ad_username'];
			$row['user_id_manage_shop'] = $data-> user_id_manage_shop;
			$row['list_user_id_manage_shop'] = $data-> list_user_id_manage_shop;
			$rs = $this-> _add($row,'fs_order_uploads_detail_shoot');
			return $rs;
		}

		function shoot_order($value = 1)
		{
			$ids = FSInput::get('id',array(),'array');

			if(!empty($ids)){
				$i=0;
				$j=0;
				foreach ($ids as $id) {
					$data = $this->get_record('id = '.$id,'fs_order_uploads_detail','*');
					
					if($data-> is_refund == 1 || $data-> is_package == 0){ // đã hoàn hàng hoặc chưa đón gói thì bỏ qua
						$j++;
						// continue;
						
					}

					// trước khi bắn ra kho kiểm tra số lượng sản phẩm của kho đó có đủ không
					$product_in_warehouse = $this->get_record('warehouses_id = ' . $data-> warehouse_id . ' AND product_id = '. $data-> product_id,'fs_warehouses_products');

					if(empty($product_in_warehouse)){ // ko có sp này trong kho
						$j++;
						// continue;
						
					}

					// if($product_in_warehouse -> amount < $data-> count ){ // ko đủ sl
					// 	$j++;
					// 	continue;
						
					// }

					$add_id = $this-> add_shoot($data,'fs_order_uploads_detail_shoot'); // lưu lịch sử bắn
					if($add_id){
						$this->minus_quantity_product($data-> count,$product_in_warehouse);
						$i++;
						$row2 = array();
						$row2['is_shoot'] = 1;
						$this-> _update($row2,'fs_order_uploads_detail','id ='.$id);
						$this->update_profits($data);
					}else{
						$j++;
						continue;
					}

				}
			}
			
			$a = array($i,$j);
			return $a;
		}

		//trừ tạm giữ đi
		function minus_quantity_product($count = 1,$data){
			// if($data->amount_hold){
			// 		printr($data);
			// 	}
			$row = array();
			if($data->amount_hold < $count || $data->amount_hold == 0){
				return;
			}else{
				$row['amount_hold'] = $data->amount_hold - $count;
			}
			
			$this->_update($row,'fs_warehouses_products','id = '.$data->id);
		}

		//nếu tất cả sản phẩm ở đơn này đã bắn ra kho thì chuyển trạng thái bắn ở lợi nhuận sang 1
		function update_profits($data){
			$get_list_shoot = $this->get_record('code = "'.$data->code.'" AND is_shoot = 0 AND is_print = 1','fs_order_uploads_detail');

			if(empty($get_list_shoot)){
				$row10 = array();
				$row10['is_shoot'] = 1;
				$this->_update($row10,'fs_profits','code = "'.$data->code.'" AND is_print = 1');
			}
		}

		//nếu tất cả sản phẩm ở đơn này đã hoàn  kho thì chuyển trạng thái hoàn ở lợi nhuận sang 1
		//- Đơn hoàn thì NBN sẽ bị mất tiền đóng hàng của đơn đóng
		//- Đơn hoàn sẽ giảm lợi nhuận của NBH và công ty xuống
		function update_profits_refund($data){
			$get_list_shoot = $this->get_record('code = "'.$data->code.'" AND is_refund = 0 AND is_print = 1','fs_order_uploads_detail','id');

			if(empty($get_list_shoot)){
				//tính số tiền đóng gói của đơn này
				$get_price_package = $this->get_record('code = "'.$data->code.'" AND is_package = 1','fs_order_uploads_detail','SUM(price_package) as total_price_package');
				//lấy ra phiếu lợi nhuận đã tạo của đơn này
				$bill_profits = $this->get_record('code = "'.$data->code.'" AND is_print = 1','fs_profits');
				if(!empty($bill_profits)){
					$row10 = array();
					$row10['is_refund'] = 1;
					$row10['profit'] = -$get_price_package->total_price_package;
					$row10['profit_company'] = $get_price_package->total_price_package;
					$row10['total_product_price'] = 0;
					$row10['gia_tri_don_hang'] = 0;
					$row10['doanh_thu_cong_ty'] = 0;
					$row10['gia_von_cong_ty'] = 0;
					
					$this->_update($row10,'fs_profits','code = "'.$data->code.'" AND is_print = 1');
				}
			}
		}

		//hoàn hàng
		function add_refund($data){
			$row = array();
			$row['order_uploads_id'] = $data-> record_id;
			$row['order_uploads_detail_id'] = $data-> id;
			$row['platform_id'] = $data-> platform_id;
			$row['warehouse_id'] = $data-> warehouse_id;
			$row['shop_name'] = $data-> shop_name;
			$row['shop_id'] = $data-> shop_id;
			$row['shop_code'] = $data-> shop_code;
			$row['date'] = $data-> date;
			$row['code'] = $data-> code;
			$row['sku'] = $data-> sku;
			$row['color'] = $data-> color;
			$row['size'] = $data-> size;
			$row['date_refund'] =  date('Y-m-d');
			$row['sku_nhanh'] = $data-> sku_nhanh;
			$row['count'] = $data-> count;
			$row['shipping_unit_name'] = $data-> shipping_unit_name;
			$row['shipping_unit_id'] = $data-> shipping_unit_id;
			$row['house_id'] = $data-> house_id;
			$row['weight'] = $data-> weight;
			$row['lazada_sku'] = $data-> lazada_sku;
			$row['user_id'] = $data-> user_id;
			$row['product_id'] = $data-> product_id;
			$row['product_code'] = $data-> product_code;
			$row['product_price'] = $data-> product_price;
			$row['total_price'] = $data-> total_price;
			$row['tracking_code'] = $data-> tracking_code;
			$row['product_name'] = $data-> product_name;
			$row['created_time'] = date('Y-m-d H:i:s');
			$row['action_userid'] = $_SESSION ['ad_userid'];
			$row['action_username'] = $_SESSION ['ad_username'];
			$row['user_id_manage_shop'] = $data-> user_id_manage_shop;
			$row['list_user_id_manage_shop'] = $data-> list_user_id_manage_shop;
			$add_id = $this-> _add($row,'fs_order_uploads_detail_refund');
			return $add_id;
		}

		//cộng tiền của tài khoản
		function plus_money($data){
			
			$user = $this->get_record('id = '.$data-> user_id_manage_shop,'fs_users');
			$row = array();
			$row['money'] = (float)$user-> money + (float)$data-> total_price - (float)$data-> price_package;
			$id_update = $this->_update($row,'fs_users','id = '.$data-> user_id_manage_shop);
			if($id_update){
				$row2 = array();
				$row2['money'] = $row['money'];
				$row2['user_id_manage_shop'] = $data-> user_id_manage_shop;
				$row2['list_user_id_manage_shop'] = $data-> list_user_id_manage_shop;
				$row2['order_detail_id'] = $data-> id;
				$row2['type'] = 'plus';
				$row2['summary'] = 'Cộng tiền hoàn hàng đơn: ' . $data-> tracking_code ;
				$row2['tracking_code'] = $data-> tracking_code;
				$row2['created_time'] = date('Y-m-d H:i:s');
				$row2['action_userid'] = $_SESSION['ad_userid'];
				$row2['action_username'] = $_SESSION['ad_username'];
				$this->_add($row2,'fs_shops_money_order_history');
			}
		}

		//trừ tiền của tài khoản
		function minus_money($data){
			$user = $this->get_record('id = '.$data-> user_id_manage_shop,'fs_users');
			$row = array();
			$row['money'] = (float)$user-> money - (float)$data-> total_price;
			$id_update = $this->_update($row,'fs_users','id = '.$data-> user_id_manage_shop);
			if($id_update){
				$row2 = array();
				$row2['money'] = -$data-> total_price;
				$row2['user_id_manage_shop'] = $data-> user_id_manage_shop;
				$row2['list_user_id_manage_shop'] = $data-> list_user_id_manage_shop;
				$row2['order_detail_id'] = $data-> id;
				$row2['type'] = 'minus';
				$row2['summary'] = 'Trừ tiền trên đơn hàng: ' . $data-> tracking_code ;
				$row2['tracking_code'] = $data-> tracking_code;
				$row2['created_time'] = date('Y-m-d H:i:s');
				$row2['action_userid'] = $_SESSION['ad_userid'];
				$row2['action_username'] = $_SESSION['ad_username'];
				$this->_add($row2,'fs_shops_money_order_history');
			}
		}
	}
?>