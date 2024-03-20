<?php 
	class ProductsModelsGift_price_range extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'gift_price_range';
			$this -> arr_img_paths = array(array('resized',258,152,'resized_not_crop'),array('small',80,80,'resized_not_crop'));
			$this -> table_name = 'fs_products_gift_price_range';
			// config for save
			$cyear = date('Y');
			$cmonth = date('m');
			$cday = date('d');
			$this -> img_folder = 'images/products/gift/'.$cyear.'/'.$cmonth.'/'.$cday;
			$this -> check_alias = 0;
			$this -> field_img = 'image';
			parent::__construct();
		}
	

		function setQuery(){

				// ordering
			$ordering = "";
			$where = "  ";
			if(isset($_SESSION[$this -> prefix.'sort_field']))
			{
				$sort_field = $_SESSION[$this -> prefix.'sort_field'];
				$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
				$sort_direct = $sort_direct?$sort_direct:'asc';
				$ordering = '';
				if($sort_field)
					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
			}
			if(isset($_SESSION[$this -> prefix.'filter'])){
				$filter = $_SESSION[$this -> prefix.'filter'];
				if($filter){
					$where .= ' AND b.id =  "'.$filter.'" ';
				}
			}
			if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";


			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND ( a.title LIKE '%".$keysearch."%'  )";
				}
			}

			$query = ' SELECT a.*
			FROM 
			'.$this -> table_name.' AS a
			WHERE 1=1'.
			$where.
			$ordering. " ";

			return $query;
		}

		function get_categories_tree()
		{
			global $db;
			$query = " SELECT a.*
					   FROM fs_products_categories AS a
					   ORDER BY ordering ";
			$sql = $db->query($query);
			$result = $db->getObjectList();
			$tree  = FSFactory::getClass('tree','tree/');
			$list = $tree -> indentRows2($result);
			return $list;
		}
		function get_categories_filter() {
			global $db;
			$sql = " SELECT id, name, parent_id AS parent_id 
			FROM fs_products_categories WHERE parent_id = 0";
			$db->query ( $sql );
			$categories = $db->getObjectList();
			
			// $tree = FSFactory::getClass ( 'tree', 'tree/' );
			// $rs = $tree->indentRows ( $categories, 1 );
			return $categories;
		}
		function save($row = array(),$use_mysql_real_escape_string = 0) {
			$id = FSInput::get ( 'id', 0, 'int' );

			$price_min =  FSInput::get ('price_min');
			$price_max =  FSInput::get ('price_max');

			if($price_min && $price_max && $price_max > 0 AND $price_min < $price_max){
				$row ['price_min'] = $price_min;
				$row ['price_max'] = $price_max;
			}

			// related products gift
			$record_gift = FSInput::get ( 'products_record_gift', array (), 'array' );
			$row ['products_gift'] = '';
			if (count ( $record_gift )) {
				$record_gift = array_unique ( $record_gift );
				$row ['products_gift'] = ',' . implode ( ',', $record_gift ) . ',';
			}

			$id = parent::save ( $row );

			if (! $id) {
				Errors::setError ( 'Not save' );
				return false;
			}

			return $id;
		}
		function get_sale_promotion($id_pro,$id_manu){
			$where="";

			if($id_pro && !$id_manu){
				echo "1a";
				$query = "SELECT *
					 FROM fs_products_gift
					 WHERE  published = 1 and (promotion_products = $id_pro
					OR promotion_products like '%,".$id_pro.",%'
					OR promotion_products like '".$id_pro.",%'
					OR promotion_products like '%,".$id_pro."'
					) order by id desc
				";
			}else if($id_manu && !$id_pro){
				echo "1b";
				$query = "SELECT *
					 FROM fs_products_gift
					 WHERE  published = 1 and (promotion_manufactory = $id_manu
					OR promotion_manufactory like '%,".$id_manu.",%'
					OR promotion_manufactory like '".$id_manu.",%'
					OR promotion_manufactory like '%,".$id_manu."'
					) order by id desc
				";
			}else{
				echo "1c";
				$query = "SELECT *
					 FROM fs_products_gift
					 WHERE  published = 1 and ((promotion_manufactory = $id_manu
					OR promotion_manufactory like '%,".$id_manu.",%'
					OR promotion_manufactory like '".$id_manu.",%'
					OR promotion_manufactory like '%,".$id_manu."'
					) or (promotion_products = $id_pro
					OR promotion_products like '%,".$id_pro.",%'
					OR promotion_products like '".$id_pro.",%'
					OR promotion_products like '%,".$id_pro."'
					) ) order by id desc
				";
			}
			// echo $query;die;
			global $db;
				
			if(!$query)
				return;
			$sql = $db->query($query);
			$result = $db->getObject();
			return $result;
		}

		function get_sale_promotion_manu($id_manu){
			$where="";
			if(!$id_manu)
				return;
				$query = "SELECT *
					 FROM fs_products_gift
					 WHERE  published = 1 and (promotion_manufactory = $id_manu
					OR promotion_manufactory like '%,".$id_manu.",%'
					OR promotion_manufactory like '".$id_manu.",%'
					OR promotion_manufactory like '%,".$id_manu."'
					) order by id desc
				";
			
			// echo $query;die;
			global $db;
				
			if(!$query)
				return;
			$sql = $db->query($query);
			$result = $db->getObject();
			return $result;
		}
		function save_promotion_products($product_id,$sale){
			$data=$this->get_promotion_save($product_id);
			$list_pro_fl_manu=$this->get_promotion_products_save_fl_manu($data->promotion_manufactory);

			// echo "<pre>";
			// print_r($list_pro_fl_manu);
			// die;

			if($list_pro_fl_manu){
				foreach ($list_pro_fl_manu as  $value) {
					
					$check_promotion=$this->get_sale_promotion($value->id,$value->manufactory);
					
					

					// echo "<pre>";
					// print_r($value);
					// die;

					// if($value->price_old < $value->price || $value->price_old == 0 || $value->price_old == 0)
					// 	continue;
					// $row_price = array();
					// if($value->price == 0){
					// 	$row_price['price'] = $value->price_old;
					// 	$this->_update ( $row_price, "fs_products", ' id =  ' . $value->id );
					// }

					if($value->price == 0){
						$percent = round((($value->price_old - $value->price_old)/$value->price_old)*100);
					}else{
						$percent = round((($value->price_old - $value->price)/$value->price_old)*100);
					}
					
					// echo $sale;
					// die;
						if($percent < $sale && $check_promotion->id <= $product_id){
							
							$date_start = FSInput::get('date_start');
							$published_hour_start = FSInput::get('published_hour_start',date('H:i'));
							$date_end = FSInput::get('date_end');
							$published_hour_end = FSInput::get('published_hour_end',date('H:i'));
							if($date_start){
								$row['date_start'] = date('Y-m-d H:i:s',strtotime($published_hour_start. $date_start));
								$row2['date_start'] = date('Y-m-d H:i:s',strtotime($published_hour_start. $date_start));
							}
							if($date_end){
								$row['date_end'] = date('Y-m-d H:i:s',strtotime($published_hour_end. $date_end));
								$row2['date_end'] = date('Y-m-d H:i:s',strtotime($published_hour_end. $date_end));
							}



							$row ['discount_unit_km'] = "percent";
							$row ['name_promotion_pg'] = $data->title;
							$row2 ['name_promotion_pg'] = $data->title;
							$row ['id_promotion_pg'] = $data->id;
							$row2 ['id_promotion_pg'] = $data->id;
							$row2 ['discount_unit_km'] = "percent";


							if ($sale > 100 || $sale < 0) {
								
							} else {

								$price_old=$value->price_old;
								$row ['discount_km'] = $sale;
		                        $row ['discount_percent_km'] = $sale;
								$row ['price_km'] = $price_old * (100 - $sale) / 100;
								$row2 ['discount_km'] = $sale;
		                        $row2 ['discount_percent_km'] = $sale;
								$row2 ['price_km'] = $price_old * (100 - $sale) / 100;			
							}



							$ext_id=$value->id;
							$aa = $this->_update ( $row, "fs_products", ' id =  ' . $ext_id );
							echo $ext_id;

							// print_r($row);
							// die;
							

							if($value->tablename){
								$this->_update ( $row2, $value->tablename, ' record_id =  ' . $ext_id );
							}
							
						}
				}
				

				// die;
			}

		

			
			$arr_pro=explode(",",$data->promotion_products);
			// echo "<pre>";
			// echo $data->promotion_products;
			// print_r($data);
			// die;
			if(!empty($arr_pro)){

			for ($i=0; $i < count($arr_pro) ; $i++) { 


				$get_pro_sale=$this->get_promotion_products_save($arr_pro[$i]);
				if(!$get_pro_sale)
					continue;
				 // echo $arr_pro[$i];die;
				$check_promotion=$this->get_sale_promotion($get_pro_sale->id,$get_pro_sale->manufactory);
				if($get_pro_sale){
					$percent = round((($get_pro_sale->price_old - $get_pro_sale->price)/$get_pro_sale->price_old)*100);
					$get_pro_sale->id_promotion_pg;

					if($percent < $sale && $check_promotion->id<=$product_id){
//echo "sss";die;

						$date_start = FSInput::get('date_start');
						$published_hour_start = FSInput::get('published_hour_start',date('H:i'));
						$date_end = FSInput::get('date_end');
						$published_hour_end = FSInput::get('published_hour_end',date('H:i'));
						if($date_start){
							$row['date_start'] = date('Y-m-d H:i:s',strtotime($published_hour_start. $date_start));
							$row2['date_start'] = date('Y-m-d H:i:s',strtotime($published_hour_start. $date_start));
						}
						if($date_end){
							$row['date_end'] = date('Y-m-d H:i:s',strtotime($published_hour_end. $date_end));
							$row2['date_end'] = date('Y-m-d H:i:s',strtotime($published_hour_end. $date_end));
						}
						date_default_timezone_set('Asia/Ho_Chi_Minh');
						$now=date("Y-m-d G:i");
						
						if(strtotime($row['date_end']) < strtotime($now)){
							$row2['discount_unit_km'] = "";
							$row2['name_promotion_pg'] = "";
							$row2['id_promotion_pg'] = "";
							$row2['date_start']="";
							$row2['date_end']="";

							$row2 ['discount_km'] = 0;
							$row2 ['discount_percent_km'] = 0;
							$row2 ['price_km'] = 0;
							
							$row2 ['id_promotion_pg'] = 0;
							$row2 ['name_promotion_pg'] = "";
							$promotion_product_id=$get_pro_sale->id;							
							if($get_pro_sale->tablename){
								$this -> _update($row2,$get_pro_sale->tablename,'record_id = '.$promotion_product_id .'');
							}
							if($promotion_product_id){
								$this -> _update($row2,'fs_products','id = '.$promotion_product_id .'');
							}
						}else{
							$row ['discount_unit_km'] = "percent";
							$row ['name_promotion_pg'] = $data->title;
							$row ['id_promotion_pg'] = $data->id;
							$row2 ['discount_unit_km'] = "percent";
							// echo $sale;die;
							if ($sale > 100 || $sale < 0) {
								
							} else {
								$price_old=$get_pro_sale->price_old;
								$row ['discount_km'] = $sale;
								$row ['discount_percent_km'] = $sale;
								$row ['price_km'] = $price_old * (100 - $sale) / 100;


								$row2 ['discount_km'] = $sale;
								$row2 ['discount_percent_km'] = $sale;
								$row2 ['price_km'] = $price_old * (100 - $sale) / 100;			
							}
							// print_r($row);die;
							$ext_id=$get_pro_sale->id;
							//echo $ext_id;die;
							$this->_update ( $row, "fs_products", ' id =  ' . $ext_id );

							if($get_pro_sale->tablename){
								$this->_update ( $row2, $get_pro_sale->tablename, ' record_id =  ' . $ext_id );
							}
						}						
					}
				}
			}

		}

			

		}
		function save_extension($tablename, $record_id) {
			if(!$tablename)
				return;
			
			$row ['summary_auto'] = $summary_auto;
			
			//update summary_auto into table fs_TYPE
			$row2 ['summary_auto'] = $summary_auto;
			$this->_update ( $row2, $this->table_name, ' id =  ' . $record_id );
			if ($ext_id) {
				return $this->_update ( $row, $tablename, ' id =  ' . $ext_id );
			} else {
				return $this->_add ( $row, $tablename );
			}
			return;
		}
		function get_promotion_products($product_id){
				if(!$product_id)
					return;
			$query   = " SELECT price_old,price,name,id,manufactory
						FROM fs_products AS a
						WHERE id in ($product_id)";
			global $db; 
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;	
		}

		function get_promotion_products_save($product_id){
				if(!$product_id)
					return;
			 $query   = " SELECT price_old,price,name,id,manufactory,tablename,id_promotion_pg
						FROM fs_products AS a
						WHERE id in ($product_id)";
			global $db; 
			$sql = $db->query($query);
			$result = $db->getObject();
			return $result;	
		}
		function get_promotion_products_save_fl_manu($product_id){
				if(!$product_id)
					return;
			$query   = " SELECT price_old,price,name,id,manufactory,tablename,id_promotion_pg
						FROM fs_products AS a
						WHERE published=1 and manufactory in ($product_id)";
					
			global $db; 
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;	
		}

		function get_promotion_manufactory($product_id){
				if(!$product_id)
					return;
			 $query   = " SELECT name,id
						FROM fs_manufactories AS a
						WHERE id in ($product_id)";
			global $db; 
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;	
		}


		function get_promotion($id){
				
			$query   = "SELECT * 
				FROM fs_products_gift 
				WHERE id = $id";
				// echo $query;die;
			global $db;
			$sql = $db->query($query);
			$result = $db->getObject();
			return $result;	
		}

		function get_promotion_save($id){
			date_default_timezone_set('Asia/Ho_Chi_Minh');
			$now=date("Y-m-d G:i");
			// echo strtotime($now);die;
    		//$where = ' and date_start <= "'.$now.'" and date_end >= "'.$now.'"';
			$where ='';

			$query   = "SELECT * 
				FROM fs_products_gift 
				WHERE id = $id ".$where;
			// echo $query;die;
			global $db;
			$sql = $db->query($query);
			$result = $db->getObject();
			return $result;	
		}
		function remove_promotion_product(){
			
			$id = FSInput::get('id',0,'int');
			$promotion_product_id = FSInput::get('promotion_product_id',0,'int');
			if(!$id || !$promotion_product_id)	
				return;
			
			$sql = " SELECT promotion_products 
				FROM fs_products_gift 
				WHERE id = $id
					";
			global $db ;
			$db->query($sql);
			$rs =  $db->getResult();
			if(!$rs)	
				return;
	
			$arr = explode( ',',$rs);
			if(!count($arr))
				return;
			$str = '';
			$i  = 0;
			foreach($arr as $item){
				if($item != $promotion_product_id){
					if($i > 0)
						$str .= ',';
					$str .= $item;
					$i ++;
				}
			}	
			$row['promotion_products'] = $str;
			//print_r($row);
				
			$row2['discount_unit_km'] = "";
			$row2['name_promotion_pg'] = "";
			$row2['id_promotion_pg'] = "";
			$row2['date_start']="";
			$row2['date_end']="";

			$row2 ['discount_km'] = 0;
            $row2 ['discount_percent_km'] = 0;
			$row2 ['price_km'] = 0;
			
			$row2 ['id_promotion_pg'] = 0;
			$row2 ['name_promotion_pg'] = "";
			// echo $promotion_product_id;die;
			$data_products_remove=$this->get_promotion_products_save($promotion_product_id);
			// remove from fs_products_incentives
			// $this -> remove_from_promotion_products($id ,$promotion_product_id);		
			// echo $data_products_remove->tablename;die;	
			if($data_products_remove->id_promotion_pg==$id){	
				if($data_products_remove->tablename){
					$this -> _update($row2,$data_products_remove->tablename,'record_id = '.$promotion_product_id .'');
				}
				if($promotion_product_id){
					$this -> _update($row2,'fs_products','id = '.$promotion_product_id .'');
				}
			}
			return $this -> _update($row,'fs_products_gift','id = '.$id .'');
			
		}

		function remove_promotion_manu(){
			
			$id = FSInput::get('id',0,'int');
			$promotion_product_id = FSInput::get('promotion_manu_id',0,'int');
			if(!$id || !$promotion_product_id)	
				return;
			
			$sql = " SELECT promotion_manufactory 
				FROM fs_products_gift 
				WHERE id = $id
					";
			global $db ;
			$db->query($sql);
			$rs =  $db->getResult();
			if(!$rs)	
				return;
	
			$arr = explode( ',',$rs);
			if(!count($arr))
				return;
			$str = '';
			$i  = 0;
			foreach($arr as $item){
				if($item != $promotion_product_id){
					if($i > 0)
						$str .= ',';
					$str .= $item;
					$i ++;
				}
			}	
			$row['promotion_manufactory'] = $str;
			// print_r($row);
				
			$list_pro_fl_manu=$this->get_promotion_products_save_fl_manu($promotion_product_id);
			
			// print_r($list_pro_fl_manu);die;
			if($list_pro_fl_manu){
				foreach ($list_pro_fl_manu as  $value) {
					$row2['discount_unit_km'] = "";
					$row2['name_promotion_pg'] = "";
					$row2['id_promotion_pg'] = "";
					$row2['date_start']="1900-04-30 12:00";
					$row2['date_end']="1900-04-30 12:00";

					$row2 ['discount_km'] = 0;
		            $row2 ['discount_percent_km'] = 0;
					$row2 ['price_km'] = 0;
					$row2 ['id_promotion_pg'] = 0;
					$row2 ['name_promotion_pg'] = "";
					// $data_products_remove=$this->get_promotion_products_save($promotion_product_id);
					if($value->id_promotion_pg==$id){	
						if($value->tablename){
							$this -> _update($row2,$value->tablename,'record_id = '.$value->id .'');
						}
						if($promotion_product_id){
							$this -> _update($row2,'fs_products','id = '.$value->id .'');
						}
					}
						
				}
			}	
				
				
			// remove from fs_products_incentives
			//$this -> remove_from_promotion_products($id ,$promotion_product_id);			
			return $this -> _update($row,'fs_products_gift','id = '.$id .'');
		}
		function remove_from_promotion_products($id ,$promotion_product_id){
			$sql = " DELETE FROM fs_products_gift_products
						WHERE product_id = $id
							AND product_incenty_id = $promotion_product_id " ;
			global $db;
			$db->query($sql);
			$rows = $db->affected_rows();
		}
		
		
		function published($value)
		{
			$ids = FSInput::get('id',array(),'array');
			
			if(count($ids))
			{
				global $db;
				$str_ids = implode(',',$ids);
				
				
				$sql = " UPDATE ".$this -> table_name."
							SET published = $value
						WHERE id IN ( $str_ids ) " ;
				$db->query($sql);
				$rows = $db->affected_rows();
				
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
		function get_promotion_published($id){
				
			$query   = "SELECT * 
				FROM fs_products_gift 
				WHERE id IN ( $id ) ";
				//echo $query;die;
			global $db;
			$sql = $db->query($query);
			$result = $db->getObject();
			return $result;	
		}
		function remove(){
			// check remove
			//echo "ddd";die;
			if(method_exists($this,'check_remove')){
				if(!$this -> check_remove()){
					Errors::_(FSText::_('Can not remove these records because have data are related'));
					return false;
				}
			}
			$cids = FSInput::get('id',array(),'array');
			foreach ($cids as $cid){
				if( $cid != 1)
					$cids[] = $cid ;
			}
			if(!count($cids))
				return false;
			$str_cids = implode(',',$cids);
		
			$data_promotion_pub=$this->get_promotion_published($str_cids);
			//echo $data_promotion_pub->promotion_products;die;
			$this->save_promotion_products_published($data_promotion_pub->promotion_products);
		
			$field_img = isset($this -> field_img)?$this -> field_img:'';	
			$use_table_extend = isset($this -> use_table_extend)?$this -> use_table_extend:0;

			// array table_names is changed. ( for calculate filter)
			$arr_table_name_changed = array();				
			
			if($field_img || $use_table_extend){
				$select = 'id';
				if($field_img)
					$select .= ','.$field_img;
				if($use_table_extend)
					$select .= ',tablename';
					
				$query = " SELECT ".$select." FROM ".$this -> table_name."
						WHERE id IN (".$str_cids.") ";
				global $db;
				$sql = $db->query($query);
				$result = $db->getObjectList();
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
						WHERE id IN ( $str_cids ) " ;						
			global $db;
			$db->query($sql);
			$rows = $db->affected_rows();
			
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
		function save_promotion_products_published($promotion_products){
			$arr_pro=explode(",",$promotion_products);
			for ($i=0; $i <count($arr_pro) ; $i++) { 
				$get_pro_sale=$this->get_promotion_products_save($arr_pro[$i]);
					
				$row2['discount_unit_km'] = "";
				$row2['name_promotion_pg'] = "";
				$row2['id_promotion_pg'] = "";
				$row2['date_start']="";
				$row2['date_end']="";

				$row2 ['discount_km'] = 0;
				$row2 ['discount_percent_km'] = 0;
				$row2 ['price_km'] = 0;
				
				$row2 ['id_promotion_pg'] = 0;
				$row2 ['name_promotion_pg'] = "";
				$promotion_product_id=$get_pro_sale->id;							
				if($get_pro_sale->tablename){
					$this -> _update($row2,$get_pro_sale->tablename,'record_id = '.$promotion_product_id .'');
				}
				if($promotion_product_id){
					$this -> _update($row2,'fs_products','id = '.$promotion_product_id .'');
				}
			}
			
			return 1;
		}



		function get_products_categories_tree() {
			global $db;
			$sql = " SELECT id, name, parent_id AS parent_id 
					FROM ".FSTable_ad::_('fs_products_categories')."
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
			
			$query_body = ' FROM '.FSTable_ad::_('fs_products').' ' . $where;
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
						FROM ".FSTable_ad::_('fs_products')."
						WHERE id IN (0" . $products_related . "0) 
						 ORDER BY POSITION(','+id+',' IN '0" . $products_related . "0')
						";
			global $db;
			$result = $db->getObjectList ( $query );
			return $result;
		}


		function get_products_gift($products_gift) {
			if (! $products_gift)
				return;
			$query = " SELECT id, name 
						FROM ".FSTable_ad::_('fs_products_list_gift')."
						WHERE id IN (0" . $products_gift . "0) 
						 ORDER BY POSITION(','+id+',' IN '0" . $products_gift . "0')
						";
			global $db;
			$result = $db->getObjectList ( $query );
			return $result;
		}


		function ajax_get_products_gift() {
			// $news_id = FSInput::get ( 'product_id', 0, 'int' );
			// $category_id = FSInput::get ( 'category_id', 0, 'int' );
			$keyword = FSInput::get ( 'keyword' );
			$where = ' WHERE published = 1 ';
			// if ($category_id) {
			// 	$where .= ' AND (category_id_wrapper LIKE "%,' . $category_id . ',%"	) ';
			// }
			$where .= " AND ( name LIKE '%" . $keyword . "%' OR alias LIKE '%" . $keyword . "%' )";
			
			$query_body = ' FROM '.FSTable_ad::_('fs_products_list_gift').' ' . $where;
			$ordering = " ORDER BY created_time DESC , id DESC ";
			$query = ' SELECT id,name ' . $query_body . $ordering . ' LIMIT 40 ';
			global $db;
			$result = $db->getObjectList ( $query );
			return $result;
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
						WHERE id IN (0" . $manufactory_related . "0) 
						 ORDER BY POSITION(','+id+',' IN '0" . $manufactory_related . "0')
						";
			global $db;
			$result = $db->getObjectList ( $query );
			return $result;
		}
	}
?>