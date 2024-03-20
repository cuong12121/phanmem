<?php
class ProductsModelsCat extends FSModels {
	function __construct() {
		parent::__construct ();
		global $module_config;
		FSFactory::include_class('parameters');
		$current_parameters = new Parameters(@$module_config->params);
		$limit   = $current_parameters->getParams('limit'); 
		$limit = $limit ? $limit: 20;
		$this->limit = $limit;
	}
	function get_compare_product($table_name) {
		if (isset ( $_SESSION [$table_name] )) {
			$compare = $_SESSION [$table_name];
			global $db;
			$result = "";
			for($i  = 0;$i < 3; $i++ ){
				@$one =$compare[$i];
				if (! empty ( $one )) {
					$query = " SELECT name,id,image
					FROM fs_products
					WHERE id=$one
					AND published = 1
					";
					$db->query ( $query );
					$result [] = reset ( $db->getObjectList () );
				} else {
					$result [] = "";
				}
			}
			return $result;
		} else {
			return "";
		}
	}


	function get_products_tag_group($products_related) {
		if (!$products_related || $products_related =='' || $products_related==',' || $products_related==',,' || $products_related==',,,' )
			return;
		$limit = 15;
		$rest_products_related_ = substr($products_related, 1, -1);  // retourne "abcde"
		
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = " SELECT  *
		FROM " . $fs_table->getTable ( 'fs_products_tags' ) . "
		WHERE id IN ( $rest_products_related_ )
		AND published = 1
		ORDER BY  ordering ASC , id DESC
		LIMIT $limit
		";
		
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}


	function set_query_body_normal($cid) {
		if (! $cid)
			return;
		$where = "";
		$fs_table = FSFactory::getClass ( 'fstable' );
		$price_from = FSInput::get ( 'pricef', 0, 'int' );
		$price_to = FSInput::get ( 'pricet', 0, 'int' );
		if ($price_from) {
			$where .= " AND a.price >= " . $price_from . " ";
		}
		if ($price_to) {
			$where .= " AND a.price <= " . $price_to . " ";
		}
		
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
				$filter_from_db = $this->getFilterFromRequest ( $str_standart_filter );
				for($i = 0; $i < count ( $filter_from_db ); $i ++) {
					$item = $filter_from_db [$i];
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
						$where .= " AND  $item->field_name =  '" . $filter_value . "' ";
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
		
		$type_alias = FSInput::get('type');
		if($type_alias){
			$type = $this -> get_record('alias = "'.$type_alias.'"','fs_products_types');
			if($type)	
				$where .= ' AND types LIKE "%,'.$type -> id.',%" ';
		}
		
		$query = '';
		//			$query = " SELECT id,name,summary,image,price,   alias
		$query .= " FROM " . $fs_table->getTable ( 'fs_products' ) . " AS a
		WHERE category_id_wrapper_extra like '%," . $cid . ",%'
		AND published = 1 AND is_trash = 0 
		" . $where . "";

		return $query;
	}
	
	//	return 1: fs_products
	//  return 0: fs_products_...(detail) 
	function select_table($category) {
		$filter = FSInput::get ( 'filter' );
		global $db;
		if ($filter && $category->tablename && ($db->checkExistTable ( $category->tablename ))) {
			return 0;
		}
		return 1;
	}
	function check_cats_parent($cid) {
		$soon = $this -> get_records('published = 1 AND parent_id ='.$cid,'fs_products_categories','id,parent_id,alias,name' );
		if(!empty($soon)) {
			return 1;
		}
		else {
			return 0;
		}
	}


	function get_list($query_body, $tablename,$level,$is_special) {
		if (! $query_body)
			return;
		// echo $query_body;
		$query_ordering = $this->set_query_order_by ( $tablename,$level);
		$query_select = $this->set_query_select ( $tablename );
		$query = $query_select;
		$query .= $query_body;
		$query.= $query_ordering;
		$query;
		global $db;
		// $db->query_limit ( $query, $this->limit, $this->page );
		if(!$is_special) {
			$db->query_limit ( $query, $this->limit, $this->page );
		} else {
			if(!$this->page) {
				$db->query_limit ( $query, $this->limit - 1, $this->page );
			} else {
				$db->query_limit_1 ( $query, $this->limit, $this->page );
			}
		}

		$result = $db->getObjectList ();
		return $result;
	}

	function get_first_item($query_body, $tablename,$level) {
		if (! $query_body)
			return;
		// echo $query_body;
		$query_ordering = $this->set_query_order_by ( $tablename,$level);
		$query_select = $this->set_query_select ( $tablename );
		$query = $query_select;
		$query .= $query_body;
		$query.= $query_ordering;

		$query;
		global $db;
		$db->query_limit ( $query, 1,0 );
		$result = $db->getObject ();
		return $result;
	}
	
	
	/*
		 * $table_type: 1: fs_products
		 * $table_type: 0: fs_products_...(detail)
		 */
	function set_query_body($category) {
		if ($category->tablename)
			return $this->set_query_body_filter ( $category , $category->id, $category->tablename );
		else
			return $this->set_query_body_normal ( $category->id );

		//			if($table_type)
	//				return $this -> set_query_body_normal($category -> id);
	//			else 
	//				return $this -> set_query_body_filter($category -> tablename);
	}
	
	function set_query_body_filter($cat,$category_id,$tablename) {
		if (! $tablename)
			return;
		global $db,$tmpl;
		$where = '';
		// filter

		// printr($category);
		$ccode = FSInput::get ( 'ccode' );
		$filter = FSInput::get ('filter');
		$checkmanu = FSInput::get ('checkmanu');
		$filter_old ='';

		if($checkmanu == 1){
			if(!empty($cat->alias1) AND !empty($cat->alias2)){
				$cat_m_manu ='';
				$cat_m_manu  = str_replace($cat->alias1.'-','',$ccode);
				$cat_m_manu  = str_replace('-'.$cat->alias2,'',$cat_m_manu);
				if(!empty($cat_m_manu)){
					if($filter){
						$filter .= ','.$cat_m_manu;
					}else{
						$filter = $cat_m_manu;
					}
				}

			}


			if(!empty($cat_m_manu)){
				if($filter){
					$filter .= ','.$cat_m_manu;
				}else{
					$filter = $cat_m_manu;
				}
				$filter_old =  $cat_m_manu;
			}


			if(!empty($filter_old) || $filter_old=='' AND $cat->alias2==''){
				$filter_old = str_replace($cat->alias.'-','',$ccode);
				if($filter){
					$filter .= ','.$filter_old;
				}else{
					$filter = $filter_old;
				}
			}
			
		}



		// echo $filter;
		// die;
		
		
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

				$filter_name_current = '';
				$closed  = 0;
				
				for($i = 0; $i < count ( $filter_from_db ); $i ++) {
					$item = $filter_from_db [$i];
					$calculator = $item->calculator;
					$field_name =  $item->field_name;
					$closed = 1;
					if($filter_name_current != $field_name){
						if($i)
							$where .= ') AND ( ';
						else 
							$where .= ' AND ( ';
						$filter_name_current = $field_name;
					}else{
						$where .= ' OR ';
					}
					
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
					
//					// Tìm hãng sản xuất để đưa ra ngoài
//					if($field_name == 'manufactory'){
//						$manu_tmpl = $tmpl -> get_variables('manu');
//						if(!$manu_tmpl) {
//							$tmpl -> assign('manu',array($filter_value));
//						}else{
//							$manu_tmpl[] = $filter_value;
//							$tmpl -> assign('manu',$manu_tmpl);
//						}
//					}
					
					
//					if($item->field_name == 'price'){
//						$item->field_name = $item->field_name.'+('.$item->field_name.'*'.$cat->vat.')/100'; 
//					}
					switch ($calculator) {
						case '1' :
						break;
						case '2' :
						$where .= " a." .$field_name . " LIKE '%" . $filter_value . "%' ";
						break;
						case '3' :
						$where .= " a." .$field_name . " is NULL  ";
						break;
						case '4' :
						$where .= " a." .$field_name . " is NOT NULL  ";
						break;
						case '5' :
						$where .= " ( CONVERT( a.".$field_name.", DECIMAL(10,2)) = ".$filter_value." OR  a." .$field_name . " = '" . $filter_value . "') ";
						break;
						case '6' :
						$where .= " CONVERT( a.".$field_name.", DECIMAL(10,2))  > " . $filter_value . " ";
//							$where .= " a." .$field_name . " > " . $filter_value . " ";
						break;
						case '7' :
						$where .= " CONVERT( a.".$field_name.", DECIMAL(10,2))< " . $filter_value . " ";
//							$where .= " a." .$field_name . " < " . $filter_value . " ";
						break;
						case '8' :
						$where .= " CONVERT( a.".$field_name.", DECIMAL(10,2)) >= " . $filter_value . " ";
//							$where .= " a." .$field_name . " >= " . $filter_value . " ";
						break;
						case '9' :
						$where .= " CONVERT( a.".$field_name.", DECIMAL(10,2)) <= " . $filter_value . " ";
//							$where .= " a." .$field_name . " <= " . $filter_value . " ";
						break;
						case '10' :
						$where .= " ( CONVERT( a.".$field_name.", DECIMAL(10,2)) > " . $filter_value1 . "  ";
						$where .= " AND CONVERT( a.".$field_name.", DECIMAL(10,2)) < " . $filter_value2 . " ) ";

//							$where .= " ( a." .$field_name . " > " . $filter_value1 . "  ";
//							$where .= " AND a." .$field_name . " < " . $filter_value2 . " ) ";
						break;
						case '11' :
						$where .= " ( CONVERT( a.".$field_name.", DECIMAL(10,2)) > " . $filter_value1 . "  ";
						$where .= " AND CONVERT( a.".$field_name.", DECIMAL(10,2)) <= " . $filter_value2 . " ) ";
//							$where .= " ( a." .$field_name . " > " . $filter_value1 . "  ";
//							$where .= " AND a." .$field_name . " <= " . $filter_value2 . " ) ";
						break;
						case '12' :
						$where .= " ( CONVERT( a.".$field_name.", DECIMAL(10,2)) >= " . $filter_value1 . "  ";
						$where .= " AND CONVERT( a.".$field_name.", DECIMAL(10,2)) < " . $filter_value2 . " ) ";
//							$where .= " ( a." .$field_name . " >= " . $filter_value1 . "  ";
//							$where .= " AND a." .$field_name . " < " . $filter_value2 . " ) ";
						break;
						case '13' :
						$where .= "(  CONVERT( a.".$field_name.", DECIMAL(10,2)) >= " . $filter_value1 . "  ";
						$where .= " AND CONVERT( a.".$field_name.", DECIMAL(10,2)) <= " . $filter_value2 . " ) ";
//							$where .= "(  a." .$field_name . " >= " . $filter_value1 . "  ";
//							$where .= " AND a." .$field_name . " <= " . $filter_value2 . " ) ";
						break;
						case '14' ://FOREIGN_ONE
						if ($field_name != 'manufactory') {
							$where .= " $field_name = '" . $filter_value . "' ";	
						}
						else {
							$where .= "manufactory_id_wrapper like'%," . $filter_value . ",%' ";	
						}
						

						break;
						case '15' ://FOREIGN_MULTI
						$where .= "  $field_name like  '%," . $filter_value . ",%' ";
						break;
						default :
						break;
					}
				}
				if($closed)
					$where .= ')  ';
			}
		}

		// manufactory
		$manufactories_request = FSInput::get ( 'manu', '' );
		if ($manufactories_request) {
			$arr_manufactories_request = explode(',',$manufactories_request);
			if(count($arr_manufactories_request)){
				$where .= " AND (";
				$m = 0;
				foreach($arr_manufactories_request as $item){
					if($item){
						if($m)
							$where .= " OR ";
						$where .= " manufactory_alias = '".	$item."' ";
						$m ++; 
					}
				}
				$where .= " ) ";
			}
		}
		

		
	// Tìm hãng sản xuất để đưa ra ngoài
//					if($field_name == 'manufactory'){
//						$manu_tmpl = $tmpl -> get_variables('manu');
//						if(!$manu_tmpl) {
//							$tmpl -> assign('manu',array($filter_value));
//						}else{
//							$manu_tmpl[] = $filter_value;
//							$tmpl -> assign('manu',$manu_tmpl);
//						}
//					}
		
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
			$where .= 'AND category_id_wrapper_extra like "%,'.$category_id.',%" '; 
		}
		$sql = " 	FROM $tablename AS a
		WHERE published = 1 AND is_trash = 0 ".$where;

		
		return $sql;

	}
	
	/*
		 * Insert order by into query select
		 */
	function set_query_order_by($table_type,$level) {
		$order = FSInput::get ( 'sort' );
		$query_ordering = '';
		switch ($order) {
			case 'gia-thap-nhat' :
//					$query_ordering = 'ORDER BY price ' . $order;
			$query_ordering='ORDER BY price ASC ';
			break;
			case 'gia-cao-nhat' :
//					$query_ordering = 'ORDER BY price ' . $order;
			$query_ordering='ORDER BY ABS(price) DESC';
			break;
			case 'moi-nhat' :
//					$query_ordering = 'ORDER BY status ASC';
			$query_ordering = 'ORDER BY ordering DESC';
			break;
			case 'xem-nhieu' :
//					$query_ordering = 'ORDER BY status ASC';
			$query_ordering = 'ORDER BY hits DESC';
			break;
			case 'khuyen-mai' :
//					$query_ordering = 'ORDER BY status ASC';
			$query_ordering = 'ORDER BY (price_old - price)/price DESC';
			break;
			case 'ban-chay-nhat' :
//					$query_ordering = 'ORDER BY status ASC';
			$query_ordering = 'ORDER BY is_sell DESC, ordering DESC';
			break;
			default:
			if($level == 0){
				// $query_ordering = 'ORDER BY ordering ASC, id DESC';
				$query_ordering = 'ORDER BY ordering2 DESC,ordering DESC, id DESC';
			}else{
				$query_ordering = 'ORDER BY ordering DESC,ordering2 DESC, id DESC';
			}
			
			break;
		}
		return $query_ordering;
	}
	
	/*
		 * Insert select into query select
		 * 1: fs_products
		 */
	function set_query_select($tablename) {
		if (! $tablename || $tablename == 'fs_products' ) {
			$query = " SELECT id,name,alias,category_alias,category_id ,image,price,price_old,quantity,alias,discount,types,is_hot,is_new,style_types,type,gift,free_ship,is_promotion,name_core,is_special,promotion_info,status  ";
		} else {
			$query = " SELECT record_id as id,alias,category_alias,category_id, name, image, price,price_old,discount,types,is_hot,style_types,is_new,type,gift,free_ship,is_promotion,name_core,is_special,promotion_info,status ";
		}
		return $query;
	}
	
	/*
		 * get Category current
		 */
	function get_category() {
		$id = FSInput::get ( 'cid', 0, 'int' );
		if(!$id){
			return;
		}
		$where = 'published = 1 ';
		if ($id) {
			$where .= " AND id = '$id'  ";
		} else {
			$code = FSInput::get ( 'ccode' );
			if (! $code)
				return;
			$where .= " AND alias = '$code' ";
		}



		$fs_table = FSFactory::getClass ( 'fstable' );
		$result = $this->get_record ( $where, $fs_table->getTable ( 'fs_products_categories' ), 'name,id,alias,parent_id,list_parents,seo_title,seo_keyword,seo_description,description,tablename,vat,level,parent_id, description,banner1, banner2, link_banner1,summary, link_banner2, name_banner1, name_banner2 ,image,icon,news_related,videos_related,alias1,alias2,name1,name2,nofollow,link_video_related,link_news_related,`schema`,aq_related,tags,tag_group,is_accessories' );
		return $result;
	}

	function get_category_m() {
		$id = FSInput::get ( 'cid', 0, 'int' );
		$where = 'published = 1 ';
		if ($id) {
			$where .= " AND id = '$id'  ";
		} else {
			$code = FSInput::get ( 'ccode' );
			if (! $code)
				return;
			$where .= " AND alias = '$code' ";
		}
		$fs_table = FSFactory::getClass ( 'fstable' );
		$result = $this->get_record ( $where, $fs_table->getTable ( 'fs_products_categories' ), 'name,id,alias,parent_id,list_parents,seo_title,seo_keyword,seo_description,description,tablename,vat,level,parent_id, description,banner1, banner2, link_banner1,summary, link_banner2, name_banner1, name_banner2 ,image,icon,news_related,videos_related,nofollow' );
		return $result;
	}
	/*
		 * get Category current
		 */
	function get_categories() {
		global $db;
		$query = " SELECT id,name, alias,tags_group,tablename,root_id, list_parents,image,level,parent_id,nofollow
		FROM fs_products_categories 
		WHERE 
		show_in_homepage = 1
		ORDER BY ordering
		";
		$db->query($query);
		$list = $db->getObjectList();

		return $list;	
	}
	function get_types(){
		global $db;
		$query = "SELECT *
		FROM fs_products_types
		WHERE  published = 1

		ORDER BY ordering
		";
		if(!$query)
			return;
		$sql = $db->query($query);
		$result = $db->getObjectListByKey('id');
		return $result;
	}
	function getFilterFromRequest($str_filter,$tablename = '',$set_key_alias = 0) {
		if (! $str_filter)
			return;
		global $db;
		$where = '';
		if($tablename)
			$where .= " AND tablename = '".$tablename."' ";
		else 
			$where .= " AND ( tablename = '' OR tablename = 'fs_products' )  ";
		$query = " SELECT *
		FROM fs_products_filters
		WHERE alias IN ($str_filter)
		AND published = 1
		".$where."
		ORDER BY field_name
		";
		$db->query ( $query );
		if($set_key_alias)
			$result = $db->getObjectListByKey('alias');
		else
			$result = $db->getObjectList ();

		return $result;
	}
	
	/*
		 * get Category current
		 */
	function getCategoryByCode() {
		$fs_table = FSFactory::getClass ( 'fstable' );
		$ccode = FSInput::get ( 'ccode' );
		if (! $ccode)
			return;
		$query = " SELECT id,name, alias,tags_group,tablename,is_accessories, root_id, is_accessories,list_parents,icon
		FROM " . $fs_table->getTable ( 'fs_products_categories' ) . " 
		WHERE alias = '$ccode' ";
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObject ();
		return $result;
	}
	function getProductsList($cid) {
		global $db;
		$query = $this->setQuery ( $cid );
		$sql = $db->query_limit ( $query, $this->limit, $this->page );
		$result = $db->getObjectList ();
		return $result;
	}

	function getProductsManuSpecial($cat,$manu_id){

		global $db;
		if(!$manu_id AND $manu_id == ''){
			return false;
		}

		$query_body = $this -> set_query_body($cat);
		$query_select = $this->set_query_select ( $cat->tablename );
		
		$where = ' AND manufactory = '.$manu_id;
		
		$fstable = FSFactory::getClass('fstable');
		$table_name  = $fstable->_($cat->tablename);
		$order = " ORDER BY ordering ASC, id DESC ";
		$query   = $query_select . $query_body . $where . $order ." LIMIT 12" ;

					// FROM ".$table_name." 
					// WHERE category_id_wrapper like '%,".$cat->id.",%' AND manufactory = ".$manu_id." AND show_product_special_cat = 1 AND published = 1 AND is_trash = 0 "
					// .$order." 
					// LIMIT 12";

		$db->query($query);
		$result = $db->getObjectList();
		return $result;
	}

	function get_sub_cats($cid){
		return $this -> get_records('published = 1 AND parent_id ='.$cid,'fs_products_categories','id,parent_id,alias,name,image_icon_cat,image,alias1,alias2,name1,name2,manufactory_related','ordering ASC' );
	}

	function get_relate_news($news_related,$category_id_includes  = '',$category_id_excludes = '') {
		if (! $news_related)
			return;
		$limit = 5;
		$where = ' ';
		if($category_id_includes){
			$where .= ' AND category_id_wrapper LIKE "%,'.$category_id_includes.',%" ';
		}
		if($category_id_excludes){
			$where .= ' AND category_id_wrapper NOT LIKE "%,'.$category_id_excludes.',%" ';
		}
		$rest_news_related_ = substr($news_related, 1, -1);  // retourne "abcde"
		
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = ' SELECT id,title,summary,image, alias, category_id,created_time,category_alias
		FROM ' . $fs_table->getTable ( 'fs_news' ) . '
		WHERE ID IN ( '.$rest_news_related_.' )
		AND published = 1 AND is_trash = 0 '.$where.'
		ORDER BY  ordering DESC , id DESC
		LIMIT '.$limit.'
		';
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}


	function get_relate_videos($news_related,$category_id_includes  = '',$category_id_excludes = '') {
		if (! $news_related)
			return;
		$limit = 6;
		$where = ' ';
		if($category_id_includes){
			$where .= ' AND category_id_wrapper LIKE "%,'.$category_id_includes.',%" ';
		}
		if($category_id_excludes){
			$where .= ' AND category_id_wrapper NOT LIKE "%,'.$category_id_excludes.',%" ';
		}
		$rest_news_related_ = substr($news_related, 1, -1);  // retourne "abcde"
		
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = ' SELECT *
		FROM ' . $fs_table->getTable ( 'fs_videos' ) . '
		WHERE ID IN ( '.$rest_news_related_.' )
		AND published = 1 '.$where.'
		ORDER BY  ordering DESC , id DESC
		LIMIT '.$limit.'
		';
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}
	
	function getTotal($query_body) {
		global $db;
		$query = "SELECT count(*) ";
		$query .= $query_body;
		$db->query ( $query );
		$total = $db->getResult ();
		return $total;
	}
	
	function getPagination($total) {
		FSFactory::include_class ( 'Pagination' );
		$pagination = new Pagination ( $this->limit, $total, $this->page );
		return $pagination;
	}
	
	function get_breadcrumb($cat_id, $root_id, $list_parents, $is_accessories) {
		if (! $root_id || ! $cat_id || ! $list_parents)
			return;
		global $db;
		$query = " SELECT parent_id,id,level,name,alias
		FROM fs_products_categories
		WHERE ((root_id = $root_id ) OR level = 0)
		AND published = 1
		";
		$db->query ( $query );
		$list = $db->getObjectList ();
		$array_breadcrumb = array ();
		$array_breadcrumb [0] = array ();
		$array_breadcrumb [0] [] = array ('name' => 'Store', 'link' => '', 'selected' => 1 );
		
		// root
		$array_breadcrumb [1] = array ();
		foreach ( $list as $item ) {
			if ($item->level == 0) {
				$Itemid = $item->is_accessories ? 36 : 34;
				$link = FSRoute::_ ( 'index.php?module=products&view=cat&ccode=' . $item->alias . '&Itemid=' . $Itemid );
				$selected = $item->id == $root_id ? 1 : 0;
				
				$array_breadcrumb [1] [] = array ('name' => $item->name, 'link' => $link, 'selected' => $selected );
			}
		}
		
		$array_list_parents = explode ( ',', $list_parents );
		
		//			$array_cat = array();
		$count_parent = count ( $array_list_parents ) - 2;
		$j = 2;
		if ($count_parent) {
			$Itemid = $is_accessories ? 36 : 34;
			// rootid -> cat_current
			for($i = ($count_parent); $i > 1; $i --) {
				
				$cat_item = $array_list_parents [$i];
				$array_breadcrumb [$j] = array ();
				foreach ( $list as $item ) {
					if ($item->parent_id == $cat_item) {
						$link = FSRoute::_ ( 'index.php?module=products&view=cat&ccode=' . $item->alias . '&Itemid=' . $Itemid );
						$selected = $item->id == $array_list_parents [$i - 1] ? 1 : 0;
						$array_breadcrumb [$j] [] = array ('name' => $item->name, 'link' => $link, 'selected' => $selected );
					}
				}
				$j ++;
			}
		}
		return $array_breadcrumb;
	}
	
	function get_product_from_ids($str_product_ids) {
		if (! $str_product_ids)
			return;
		$query = " SELECT id,is_hot,is_sale,is_new
		FROM fs_products
		WHERE id IN ($str_product_ids) ";
		$query;
		global $db;
		$db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}
	
	function get_list_parent($list_parents, $cat_id) {
		if (! $list_parents)
			return;
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = 'SELECT name,id,alias,parent_id FROM ' . $fs_table->getTable ( 'fs_products_categories' ) . ' WHERE published =1 AND id IN (0' . $list_parents . '0) AND id <> ' . $cat_id . '
		ORDER BY POSITION( concat(",",id,",") IN "0' . $list_parents . '0")';
		global $db;
		$db->query ( $query );
		$list = $db->getObjectList ();
		return $list;
	}
	

	function get_group_manu($manufactory) {
		$where = 'published = 1 ';
		if (!$manufactory)
			return;
		$where .= " AND manufactory = $manufactory ";
		$fs_table = FSFactory::getClass ( 'fstable' );
		$result = $this->get_records ( $where, $fs_table->getTable ( 'fs_products_groups' ), '*','ordering DESC, id DESC' );
		
		return $result;
	}
	function get_products($query_body, $tablename) {
		if (! $query_body)
			return;
		$query_ordering = $this->set_query_order_by ( $tablename );
		$query_select = $this->set_query_select ( $tablename );
		$query = $query_select;
		$query .= $query_body;
		$query .= $query_ordering;
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}
	function get_price_by_colors() {
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = " SELECT id,color_code,record_id
		FROM " . $fs_table->getTable ( 'fs_products_price' ) . "
		";
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}
	function get_manufactory_by_id($manu_id){

		if (!$manu_id)
			return;
		return $this -> get_record('published = 1 AND id = '.$manu_id.' ','fs_manufactories');
		
	}

	function check_sale_off($product_id){
		$today_time = date('Y-m-d H:i:s');
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = " SELECT id,name, finished_time
		FROM " . $fs_table->getTable ( 'fs_sales' ) . "
		WHERE published = 1 AND started_time < '".$today_time ."' AND finished_time > '".$today_time."' AND type = 1 AND is_default = 1 ORDER BY ordering ASC";
		global $db;
		$sql = $db->query ( $query );
		$sale = $db->getObject ();
		if($sale) {
			$query2 = " SELECT s.price
			FROM " . $fs_table->getTable ( 'fs_sales_products' ) . " as s INNER JOIN ".$fs_table->getTable ( 'fs_products' ) ." as p ON s.product_id = p.id
			WHERE published = 1 AND p.id = $product_id
			";
			$sql2 = $db->query ( $query2 );
			$result = $db->getObject ();
			if($result) {
				return $result;	
			} else {
				return 0;
			}
		}
		else {
			return 0;
		}
	}


	function get_relate_aq($aq_related,$category_id_includes  = '',$category_id_excludes = '') {
		if (! $aq_related)
			return;
		$limit = 6;

		$rest_aq_related_ = substr($aq_related , 1, -1);  // retourne "abcde"
		$where='';
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = ' SELECT *
		FROM ' . $fs_table->getTable ( 'fs_aq' ) . '
		WHERE ID IN ( '.$rest_aq_related_.' )
		AND published = 1 '.$where.'
		ORDER BY  ordering DESC , id DESC LIMIT '.$limit.'
		';
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}

	function get_relate_aq_new($data,$checkmanu,$manufactory_id) {
		$gift_id ='';
		// echo $checkmanu;
		// echo $manufactory_id;
		// die;
		
		if($manufactory_id != 0 && $checkmanu == 1){
			// echo 2;
			$list_aq = $this->get_records('published = 1','fs_products_setup_aq','*','priority DESC');
		}else{
			$list_aq = $this->get_records('published = 1 AND ISNULL(manufactory_related) OR published = 1 AND manufactory_related = "" ','fs_products_setup_aq','*','priority DESC');
			// printr($list_aq);
		}

		if(empty($list_aq)){
			return;
		}
		
		if($manufactory_id != 0 && $checkmanu == 1){
			foreach ($list_aq as $item) {

				if($item-> manufactory_related && $item-> category_id_wrapper && $manufactory_id != 0 && $checkmanu==1){

					$pos = strpos($item-> manufactory_related, ','.$manufactory_id.',');
					$pos2 = strpos($item-> category_id_wrapper, ','.$data-> id.',');
					if($pos !== false && $pos2 !== false){
						$gift_id = $item-> id;
					}
				}elseif($item-> manufactory_related && $manufactory_id != 0 && $checkmanu==1){
					
					$pos = strpos($item-> manufactory_related, ','.$manufactory_id.',');
					if($pos !== false){
						$gift_id = $item-> id;
					}
				}
			}
		}else{
			foreach ($list_aq as $item) {
				if($item-> category_id_wrapper){
					$pos = strpos($item-> category_id_wrapper, ','.$data-> id.',');
					if($pos !== false){
						$gift_id = $item-> id;
					}
				}
			}
		}

		if($gift_id){
			$data_gift = $this->get_record('published = 1 AND id = ' . $gift_id,'fs_products_setup_aq','*','priority DESC');
			if(!$data_gift-> products_aq){
				return;
			}
			
			$products_related = $data_gift-> products_aq;

			$rest_products_related_ = substr($products_related, 1, -1);

			$fs_table = FSFactory::getClass ( 'fstable' );
			$query = " SELECT *
			FROM " . $fs_table->getTable ( 'fs_aq' ) . "
			WHERE id IN ( $rest_products_related_ )
			AND published = 1 
			ORDER BY  ordering DESC , id DESC
			
			";
			global $db;
			$sql = $db->query ( $query );
			$result = $db->getObjectList ();
			return $result;
		}
		
	}
}

?>