
<?php 
	class Products_filterBModelsProducts_filter extends FSModels
	{
		function __construct()
		{
		} 
		
		/*
		 * Lấy bộ lọc không tính count cho mỗi filter
		 */
		function get_filters_not_calculate(){
			
		}
		/*
		 * Lấy bộ lọc có tính count theo từng filter
		 */
		function get_filters_has_calculate($cat){
			$module = FSInput::get('module');
			if($module != 'products')
				return ;
			$where =  '';	
			$filter = FSInput::get ( 'filter' );
			$count_filter = 0;
			if ($filter) {
				$arr_filter = explode ( ',', $filter );
//				$arr_standart_filter = array ();
				for($i = 0; $i < count ( $arr_filter ); $i ++) {
					$filter_item = $arr_filter [$i];
					if ($filter_item) {
//						$arr_standart_filter [] = "'" . $filter_item . "'";
						$where .= ' AND url_alias LIKE  ",%'.$filter_item.'%," '; 
						$count_filter ++;
					}
				}
			}
			
			$where .= ' AND url_total_params =  '.$count_filter.' '; 
			if($cat -> id){
				$where .= ' AND category_id = '.$cat->id.' '; 
			} 
//			if($cat -> tablename){
//				$where .= ' AND tablename = "'.$cat->tablename.'" AND is_common <> 1'; 
//			} else {
//				$where .= '  AND is_common = 1'; 
//			}
			$query = ' SELECT record_id,id, total, filter_show,field_name,field_show,alias, calculator,record_id
						FROM fs_products_filters_values 
						WHERE published = 1 '.$where.' GROUP BY record_id';
				global $db;
			$db->query($query);
			return $result = $db->getObjectList();
		}
		/*
		 * Lấy bộ lọc có không tính toán tổng
		 */
		function get_filters_no_calculate($cat){
			$module = FSInput::get('module');
			$view = FSInput::get('view');
			if($module != 'products')
				return ;
//			if($view != 'product' || $view != 'cat' )
//				return ;
			$where =  '';	
			
			if($cat -> tablename){
				$where .= ' AND tablename = "'.$cat->tablename.'" '; 
			} else {
				$where .= ' AND is_common = 1';
			}
			$query = ' SELECT id, filter_show, field_name,field_show,alias, calculator,filter_value
						FROM fs_products_filters
						WHERE published = 1 '.$where.'
						ORDER BY field_ordering,ordering,filter_show ASC
						'
			;
				global $db;
			$db->query($query);
			return $result = $db->getObjectList();
		}
		
		/*
		 * Lấy những filer đang duyệt từ bảng fs_products_filters
		 */
		function get_filter_is_browing($cat){
			$module = FSInput::get('module');
			if($module != 'products')
				return ;
			$where =  '';	
			$filter = FSInput::get ( 'filter' );
			if (!$filter) 
				return;
				
			$where .= ' AND (';
			$arr_filter = explode ( ',', $filter );
			$count_filter = 0;
			for($i = 0; $i < count ( $arr_filter ); $i ++) {
				$filter_item = $arr_filter [$i];
				if ($filter_item) {
					if($count_filter)
						$where .= ' OR ';
					$where .= ' alias =  "'.trim($filter_item).'" ';
					$count_filter ++;
				}
			}
			$where .= ' ) ';
//			if($cat -> tablename){
//				$where .= ' AND tablename = "'.$cat->tablename.'" AND is_common <> 1'; 
//			} else {
//				$where .= ' AND is_common = 1';
//			}
			$query = ' SELECT *
						FROM fs_products_filters 
						WHERE published = 1 '.$where.' ORDER BY  is_common DESC,field_ordering,ordering,filter_show ASC';
				global $db;
			$db->query($query);
			return $result = $db->getObjectList();
		}
		/*
		 * Lấy những filer đang duyệt từ bảng fs_products_filters
		 * Tạm bỏ:
		 */
		function __get_filter_is_browing($cat){
			$module = FSInput::get('module');
			if($module != 'products')
				return ;
			$where =  '';	
			$filter = FSInput::get ( 'filter' );
			if (!$filter) 
				return;
				
			$where .= ' AND (';
			$arr_filter = explode ( ',', $filter );
			$count_filter = 0;
			for($i = 0; $i < count ( $arr_filter ); $i ++) {
				$filter_item = $arr_filter [$i];
				if ($filter_item) {
					if($count_filter)
						$where .= ' OR ';
					$where .= ' alias =  "'.trim($filter_item).'" ';
					$count_filter ++;
				}
			}
			$where .= ' ) ';
			
			$where .= ' AND url_total_params = 0 '; 
			if($cat -> id){
				$where .= ' AND category_id = '.$cat->id.' '; 
			} 
//			if($cat -> tablename){
//				$where .= ' AND tablename = "'.$cat->tablename.'" AND is_common <> 1'; 
//			} else {
//				$where .= ' AND is_common = 1';
//			}
			$query = ' SELECT record_id,id, total, filter_show,field_name,field_show,alias, calculator,record_id
						FROM fs_products_filters_values 
						WHERE published = 1 '.$where.'';
				global $db;
			$db->query($query);
			return $result = $db->getObjectList();
		}
		
		/******** CATEGORIES *************/
		
		/*
		 * get Cats includes: cat_current and parent
		 */
		function get_category(){
			$module = FSInput::get('module');
			$view = FSInput::get('view');
			if($module !='products' || ($view != 'cat' && $view != 'product' ) )
				return;
			$ccode = FSInput::get('ccode');
			$cid = FSInput::get('cid');
			$query  = " SELECT name,alias,alias1,alias2, id, level,manufactory_related , parent_id as parent_id, tablename,image,list_parents
						FROM fs_products_categories
						WHERE  published = 1 
						AND id = '$cid'
						";
			global $db;
			$db->query($query);
			return $result = $db->getObject();
		}

		function get_sub_cats($cid){
			return $this -> get_records('published = 1 AND parent_id ='.$cid,'fs_products_categories','id,parent_id,alias,name','ordering DESC' );
		}

		
		function get_products($query){
			if(!$query)
				return;
			global $db;
			$db->query($query);
			return $result = $db->getObjectList();
		}
		
//		function getCats($cid, $parent_id = 0)
//		{
//			if(!$cid || !$parent_id)
//				return;
//			global $db;
//			$where  = " ";
//			if(!$parent_id)
//			{
//				$where .= " parent_id = $cid ";
//			}
//			else
//			{
//				$where .= " parent_id IN ($cid,$parent_id) 
//							OR id  = $parent_id";
//			}
//			$query  = " SELECT name, id, level, parent_id, tablename
//						FROM fs_categories
//						WHERE  published = 1 
//						AND id IN ($cid,$parent_id) 
//						ORDER BY id
//						";
//			$db->query($query);
//			$result = $db->getObjectList();
//			
//			return $result;
//		}
		
		/*
		 * Select all product in categoryid
		 */
		function getProducts($catid,$tablename)
		{
			if(!$catid)
				return;
			if(!$tablename || $tablename == 'fs_products' )
				return;
				
			global $db;
			if(!$db -> checkExistTable($tablename))
				return false;
			$query  = " SELECT *
						FROM $tablename
						WHERE 
						categoryid  = $catid 
						";
			$db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
		
		/*
		 * select data in fs_products_filters for tablename
		 */
		function getFilter($tablename)
		{
			if(!$tablename)
				return;
			global $db;
			$query  = " SELECT *
						FROM fs_products_filters
						WHERE tablename  = '$tablename'
						AND published = 1
						ORDER BY field_ordering,ordering,filter_show ASC
						";
			
			$db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
		
		/*
		 * set body query
		 * For: all records from fs_products_....(detail)
		 * 
		 */
		function set_query($tablename){
			if(!$tablename)
				return;
			global $db;			
			if(!$db -> checkExistTable($tablename))
				return;
				$where = '';
			// filter
			$filter = FSInput::get('filter');
			if($filter)
			{
				$arr_filter = explode(',',$filter);
				$arr_standart_filter = array();
				for($i = 0 ; $i < count($arr_filter); $i ++ )
				{
					$filter_item = $arr_filter[$i];
					if($filter_item){
						$arr_standart_filter[] = 	"'".$filter_item."'";
					}	
				}
				if(count($arr_standart_filter))
				{
					$str_standart_filter = implode(",",$arr_standart_filter);
					
					// get filter in table fs_products_filter follow request
					$filter_from_db = $this -> getFilterFromRequest($str_standart_filter);
					for($i = 0; $i < count( $filter_from_db); $i ++ )
					{
						$item = 	$filter_from_db[$i];
						$calculator = $item -> calculator;
						
						$filter_value = '';
						$filter_value1 = '';
						$filter_value2 = '';
						if($calculator > 9)
						{
							$filter_value = $filter -> filter_value;
							$arr_value = explode(",",$filter_value,2);
							$filter_value1 = @$arr_value[0]?$arr_value[0]:"";
							$filter_value2 = @$arr_value[1]?$arr_value[1]:"";
						}
						else
						{
							$filter_value = $item -> filter_value;
						}
					
						switch ($calculator)	
						{
							case '1':
								break;
							case '2':
								$where .= " AND  a.".$item ->field_name." LIKE '%".$filter_value."%' ";
								break;
							case '3':
								$where .= " AND  a.".$item ->field_name." is NULL  ";
								break;
							case '4':
								$where .= " AND  a.".$item ->field_name." is NOT NULL  ";
								break;
							case '5':
								$where .= " AND  a.".$item ->field_name." = '".$filter_value."' ";
								break;
							case '6':
								$where .= " AND  a.".$item ->field_name." > '".$filter_value."' ";
								break;
							case '7':
								$where .= " AND  a.".$item ->field_name." < '".$filter_value."' ";
								break;
							case '8':
								$where .= " AND  a.".$item ->field_name." >= '".$filter_value."' ";
								break;
							case '9':
								$where .= " AND  a.".$item ->field_name." <= '".$filter_value."' ";
								break;
							case '10':
								$where .= " AND a.".$item ->field_name." < '".$filter_value1."'  ";
								$where .= " AND a.".$item ->field_name." > '".$filter_value2."'  ";
								break;
							case '11':
								$where .= " AND a.".$item ->field_name." < '".$filter_value1."'  ";
								$where .= " AND a.".$item ->field_name." >= '".$filter_value2."'  ";
								break;
							case '12':
								$where .= " AND a.".$item ->field_name." <= '".$filter_value1."'  ";
								$where .= " AND a.".$item ->field_name." > '".$filter_value2."'  ";
								break;
							case '13':
								$where .= " AND a.".$item ->field_name." <= '".$filter_value1."'  ";
								$where .= " AND a.".$item ->field_name." >= '".$filter_value2."'  ";
								break;
							default:
								break;
						}										
					} 
				}
				
			}
			
			// manufactory
			$manufactory = FSInput::get('manu','');
			if($manufactory)
			{
				$where .= " AND a.ext_manufactory_alias = '".$manufactory."' ";
			}
			$price_from = FSInput::get('pricef',0,'int');
			$price_to = FSInput::get('pricet',0,'int');
			if($price_from)
			{
				$where .= " AND a.ext_price >= ".$price_from." ";
			}
			if($price_to)
			{
				$where .= " AND a.ext_price <= ".$price_to." ";
			}
			$order = '';
			$ccode = FSInput::get('ccode');
//			$sql   = " SELECT a.id  as pid ,a.name,a.image,a.summary,a.price, a.categoryid,a.estores_count, b.*
			$sql   = " SELECT a.*
						FROM $tablename AS a
						WHERE a.ext_category_alias_wrapper  like '%,$ccode,%' "
						.$where." "
						.$order." "
					;
			return $sql;
		}
		
		/*
		 * get Filter from request
		 */
		function getFilterFromRequest($str_filter)
		{
			if(!$str_filter)
				return;
			global $db;
			$query  = " SELECT *
						FROM fs_products_filters
						WHERE alias IN ($str_filter)
						AND published = 1
						ORDER BY field_ordering,ordering,filter_show ASC
						";
			$db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
		
		/*get filter follow tablename of products
		 * 
		 */
		function get_filter_by_tablename($tablename){
			if(!$tablename)
				return;
			global $db;
			$query  = " SELECT *
						FROM fs_products_filters
						WHERE tablename  = '$tablename'
						AND published = 1
						ORDER BY is_common DESC, field_ordering,ordering,filter_show ASC
						";
			
			$db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
		
		/*
		 * get Manufactories
		 */
		function getManufactories($array_manufactoryid){
			$str = "";
			$i = 0;
			
			global $db;
			$ccode = FSInput::get('ccode');
			$str_manufactoryid = implode(",",$array_manufactoryid);

			$query   = " SELECT id,name,alias
						FROM fs_manufactories 
						WHERE alias IN ($str_manufactoryid)"
					;
			
			$db->query($query);
			$list = $db->getObjectList();
			
			return $list;
		}
		
		function count_by_filter($filter,$where_url,$tablename){
			$where = $where_url;
			if(!$where)
				$where .= ' 1 = 1 ';
			if($filter){
				$calculator = $filter->calculator;
				
				$filter_value = '';
				$filter_value1 = '';
				$filter_value2 = '';
				if ($calculator > 9) {
					$filter_value = $filter->filter_value;
					$arr_value = explode ( ",", $filter_value, 2 );
					$filter_value1 = @$arr_value [0] ? $arr_value [0] : 0;
					$filter_value2 = @$arr_value [1] ? $arr_value [1] : 0;
				} else {
					$filter_value = $filter->filter_value;
				}
				switch ($calculator) {
					case '1' :
						break;
					case '2' :
						$where .= " AND  a." . $filter->field_name . " LIKE '%" . $filter_value . "%' ";
						break;
					case '3' :
						$where .= " AND  a." . $filter->field_name . " is NULL  ";
						break;
					case '4' :
						$where .= " AND  a." . $filter->field_name . " is NOT NULL  ";
						break;
					case '5' :
						$where .= " AND  a." . $filter->field_name . " = '" . $filter_value . "' ";
						break;
					case '6' :
						$where .= " AND  a." . $filter->field_name . " > " . $filter_value . " ";
						break;
					case '7' :
						$where .= " AND  a." . $filter->field_name . " < " . $filter_value . " ";
						break;
					case '8' :
						$where .= " AND  a." . $filter->field_name . " >= " . $filter_value . " ";
						break;
					case '9' :
						$where .= " AND  a." . $filter->field_name . " <= " . $filter_value . " ";
						break;
					case '10' :
						$where .= " AND a." . $filter->field_name . " > " . $filter_value1 . "  ";
						$where .= " AND a." . $filter->field_name . " < " . $filter_value2 . "  ";
						break;
					case '11' :
						$where .= " AND a." . $filter->field_name . " > " . $filter_value1 . "  ";
						$where .= " AND a." . $filter->field_name . " <= " . $filter_value2 . "  ";
						break;
					case '12' :
						$where .= " AND a." . $filter->field_name . " >= " . $filter_value1 . "  ";
						$where .= " AND a." . $filter->field_name . " < " . $filter_value2 . "  ";
						break;
					case '13' :
						$where .= " AND a." . $filter->field_name . " >= " . $filter_value1 . "  ";
						$where .= " AND a." . $filter->field_name . " <= " . $filter_value2 . "  ";
						break;
					case '14' ://FOREIGN_ONE
						$where .= " AND   $filter->field_name = '" . $filter_value . "' ";
						break;
					case '15' ://FOREIGN_MULTI
						$where .= " AND $filter->field_name like  '%," . $filter_value . ",%' ";
						break;
					default :
						break;
				}
			}
			$query = ' SELECT count(*) FROM '.$tablename. ' AS a WHERE '.$where;
//				echo $query.'<br />';
			global $db;
			$db->query($query);
			$result = $db->getResult();
			return $result;
		}
		
		function set_query_from_url($category_id,$tablename) {
			if (! $tablename)
				return;
			global $db;
			$where = ' published = 1 ';
			// filter
			$filter = FSInput::get ( 'filter' );
			if ($filter) {
				$arr_filter = explode ( ',', $filter );
				$arr_standart_filter = array ();
				for($i = 0; $i < count ( $arr_filter ); $i ++) {
					$filter_item = $arr_filter [$i];
					if ($filter_item) {
						$arr_standart_filter [] = "'" . $filter_item . "'";
					}
				}
				
				if (count ( $arr_standart_filter )) {
					$str_standart_filter = implode ( ",", $arr_standart_filter );
					
					// get filter in table fs_products_filter follow request
					$filter_from_db = $this->getFilterFromRequest ( $str_standart_filter,$tablename );
					for($i = 0; $i < count ( $filter_from_db ); $i ++) {
						$item = $filter_from_db [$i];
//						echo '<pre>';
//						print_r($item);
//						echo '</pre>';
						$calculator = $item->calculator;
						
						$filter_value = '';
						$filter_value1 = '';
						$filter_value2 = '';
						if ($calculator > 9) {
							$filter_value = $item->filter_value;
							$arr_value = explode ( ",", $filter_value, 2 );
							$filter_value1 = @$arr_value [0] ? $arr_value [0] : "";
							$filter_value2 = @$arr_value [1] ? $arr_value [1] : "";
						} else {
							$filter_value = $item->filter_value;
						}
						
						switch ($calculator) {
							case '1' :
								break;
							case '2' :
								$where .= " AND  a." . $item->field_name . " LIKE '%" . $filter_value . "%' ";
								break;
							case '3' :
								$where .= " AND  a." . $item->field_name . " is NULL  ";
								break;
							case '4' :
								$where .= " AND  a." . $item->field_name . " is NOT NULL  ";
								break;
							case '5' :
								$where .= " AND  a." . $item->field_name . " = '" . $filter_value . "' ";
								break;
							case '6' :
								$where .= " AND  a." . $item->field_name . " > " . $filter_value . " ";
								break;
							case '7' :
								$where .= " AND  a." . $item->field_name . " < " . $filter_value . " ";
								break;
							case '8' :
								$where .= " AND  a." . $item->field_name . " >= " . $filter_value . " ";
								break;
							case '9' :
								$where .= " AND  a." . $item->field_name . " <= " . $filter_value . " ";
								break;
							case '10' :
								$where .= " AND a." . $item->field_name . " > " . $filter_value1 . "  ";
								$where .= " AND a." . $item->field_name . " < " . $filter_value2 . "  ";
								break;
							case '11' :
								$where .= " AND a." . $item->field_name . " > " . $filter_value1 . "  ";
								$where .= " AND a." . $item->field_name . " <= " . $filter_value2 . "  ";
								break;
							case '12' :
								$where .= " AND a." . $item->field_name . " >= " . $filter_value1 . "  ";
								$where .= " AND a." . $item->field_name . " < " . $filter_value2 . "  ";
								break;
							case '13' :
								$where .= " AND a." . $item->field_name . " >= " . $filter_value1 . "  ";
								$where .= " AND a." . $item->field_name . " <= " . $filter_value2 . "  ";
								break;
							case '14' ://FOREIGN_ONE
								$where .= " AND   $item->field_name = '" . $filter_value . "' ";
								break;
							case '15' ://FOREIGN_MULTI
								$where .= " AND $item->field_name like  '%," . $filter_value . ",%' ";
								break;
							default :
								break;
						}
					}
				}
			}
			
			// manufactory
	//		$manufactory = FSInput::get ( 'manu', '' );
	//		if ($manufactory) {
	//			$where .= " AND a.ext_manufactory_alias = '" . $manufactory . "' ";
	//		}
	//		$price_from = FSInput::get ( 'pricef', 0, 'int' );
	//		$price_to = FSInput::get ( 'pricet', 0, 'int' );
	//		if ($price_from) {
	//			$where .= " AND a.ext_price >= " . $price_from . " ";
	//		}
	//		if ($price_to) {
	//			$where .= " AND a.ext_price <= " . $price_to . " ";
	//		}
	//		$ccode = FSInput::get ( 'ccode' );
			//			$sql   = " SELECT a.id  as pid ,a.name,a.image,a.summary,a.price, a.categoryid,a.estores_count, b.*
			if($category_id){
				$where .= 'AND category_id_wrapper like "%,'.$category_id.',%" '; 
			}
			return $where;
		}
		
	/*
		 * get Filter from request
		 */
		function get_menufactories($arr_manufactories_request)
		{
			$where = '';
			if($arr_manufactories_request){
				foreach($arr_manufactories_request as $item){
					$where .= ' OR alias = "'.$item.'"';					
				}
				
			}
			global $db;
			$query  = ' SELECT *
						FROM fs_manufactories
						WHERE published = 1
						AND 
						(	is_common = 1
							'.$where.'
						)
						
						ORDER BY ordering ASC,id DESC
						';
			$db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
		function get_colors()
		{
			global $db;
			$query  = ' SELECT *
						FROM fs_products_colors
						WHERE published = 1
						';
			$db->query($query);
			$result = $db->getObjectListByKey('id');
			return $result;
		}

		function get_record_by_id($id, $table_name = '', $select = '*') {
			if (! $id)
				return;
			if (! $table_name)
				$table_name = $this->table_name;
			$query = " SELECT " . $select . "
						  FROM " . $table_name . "
						  WHERE id = $id ";
			
			global $db;
			$sql = $db->query ( $query );
			$result = $db->getObject ();
			return $result;
		}
		
				/*
		 * get record 
		 */
		function get_record($where = '',$table_name = '',$select = '*')
		{
			if(!$where)
				return;
			if(!$table_name)
				$table_name = $this -> table_name;
			$query = " SELECT ".$select."
						  FROM ".$table_name."
						  WHERE ".$where ;

					//	  echo $query;
						//  die();
			global $db;
			$db->query($query);
			$result = $db->getObject();
			return $result;
		}
	}
	
?>