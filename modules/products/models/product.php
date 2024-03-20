<?php
class ProductsModelsProduct extends FSModels {
	function __construct() {
		$limit = 6;
		$page = FSInput::get ( 'page' );
		$this->limit = $limit;
		$this->page = $page;
		
	}
	//		function setQuery()
	//		{
	//			$query = " SELECT id,title,summary,image, categoryid, tag
	//						  FROM fs_contents
	//						  WHERE categoryid = $cid 
	//						  	AND published = 1
	//						ORDERf BY  id DESC, ordering DESC
	//						 ";
	//			return $query;
	//		}
	/*
		 * get Category current
		 */
	//		function get_category_by_id($category_id)
	//		{
	//			if(!$category_id)
	//				return "";
	//			$query = " SELECT id,name,is_comment, icon
	//						FROM fs_news_categories 
	//						WHERE id = $category_id ";
	//			global $db;
	//			$sql = $db->query($query);
	//			$result = $db->getObject();
	//			return $result;
	//		}
	

	// function check_gift($data){
	// 	$fs_table = FSFactory::getClass ( 'fstable' );
	// 	$query = " SELECT * FROM fs_products_gift WHERE ";
	// 	global $db;
	// 	$sql = $db->query ( $query );
	// 	$result = $db->getObject ();
	// 	return $result;
	// }

	function get_data_extends() {
		return $this -> get_records('published = 1', 'fs_extends_items');	
	}
	
	function get_product() {
		$id = FSInput::get ( 'id' );
		$code = FSInput::get ( 'code' );
		$preview = FSInput::get ('preview');
		if (! $code && ! $id)
			return;
		$fs_table = FSFactory::getClass ( 'fstable' );
		
		$select = " * ";
		$where =' ';
		if(!$preview){
			$where .= "published = 1 AND is_trash = 0 AND category_published = 1";
			if (!$id){
				$where .= ' AND alias = "' . $code . '"';
			}else{
				$where .= ' AND id = ' . $id;
			}
		}else{
			$where .= ' id = ' . $id;
		}
		
		
		
		//echo $where;
		$result = $this->get_record ( $where, $fs_table->getTable ( 'fs_products' ), $select );
		//print_r($result);
		//die();
		return $result;
	}

	function get_list_cat($str_cats){
		if(!$str_cats)
			return;
		$where = ' published  = 1 AND id IN (0'.$str_cats.'0) ';
		$fs_table = FSFactory::getClass('fstable');
		$select = 'id, parent_id,name,alias, level';
		
		return $result = $this -> get_records($where,$fs_table -> getTable('fs_products_categories'),$select,"level DESC");
	}



	function get_sale() {
		$date_now = date('Y-m-d H:i:s');
		$fs_table = FSFactory::getClass ( 'fstable' );
		$select = " * ";
		$where = "published = 1 AND is_auto = 0 AND number_sale > 0 AND date_start < '$date_now' AND date_end > '$date_now'";
		$order="ordering ASC";
		$limit=1;
		$result = $this->get_record( $where, $fs_table->getTable ( 'fs_sale' ), $select,$order,$limit,'');
		return $result;
	}


	function get_order($code) {
		$result = $this -> get_records('code_sale ="'.$code.'"','fs_order','*',' id DESC ');
		return $result;
	}

	function member_level() {
		$result = $this -> get_records('','fs_members_level','*','ordering DESC ');
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
		$query = " SELECT id,name, alias,vat
		FROM " . $fs_table->getTable ( 'fs_products_categories' ) . " 
		WHERE alias = '$ccode' ";
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObject ();
		return $result;
	}
	function getCategoryById($id) {
		if (! $id)
			return;
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = " SELECT *
		FROM " . $fs_table->getTable ( 'fs_products_categories' ) . " 
		WHERE id = $id ";
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObject ();
		return $result;
	}
	function get_products_in_cat($category_id, $product_id) {
		if (! $category_id)
			return;
		$limit = 4;
		$query = " SELECT name,id , image,price,price_old,discount, alias,category_alias,category_id,gift,quantity, price,price_old,types,free_ship,manufactory_name,date_start,date_end,is_hot,is_hotdeal,style_types, type,promotion_info
		FROM fs_products
		WHERE category_id = $category_id
		AND published = 1  AND is_trash = 0 ORDER BY ordering LIMIT " . $limit;
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectListByKey ( 'id' );
		return $result;
	}

	// function get_products_in_cat($category_id, $product_id) {
	// 	if (! $category_id)
	// 		return;
	// 	$limit = 4;
	// 	$query = " SELECT name,id , image,price,price_old,discount, alias,category_alias,category_id,gift,quantity, price,price_old,types,free_ship,manufactory_name,date_start,date_end,is_hot,is_hotdeal,style_types, type
	// 	FROM fs_products
	// 	WHERE category_id = $category_id
	// 	AND published = 1  AND is_trash = 0 ORDER BY ordering LIMIT " . $limit;
	// 	global $db;
	// 	$sql = $db->query ( $query );
	// 	$result = $db->getObjectListByKey ( 'id' );
	// 	return $result;
	// }
	
	
	function get_products_in_manufactory($category_id ,$manufactory_id, $product_id) {
		if (! $manufactory_id)
			return;
		$limit = 8;
		$query = " SELECT name,id , image,price,price_old,discount, alias,category_alias,quantity, price,price_old,types,manufactory_image,manufactory_name,date_start,date_end,warranty,is_hotdeal,style_types, gift,free_ship,promotion_info, is_hot
		FROM fs_products
		WHERE category_id = ".$category_id ." and manufactory = ".$manufactory_id."
		AND published = 1 AND is_trash = 0 ORDER BY ordering LIMIT " . $limit;
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectListByKey ( 'id' );
		return $result;
	}
	
	function get_products_related($products_related, $product_id) {
		if (!$products_related || ! $product_id)
			return;
		$limit = 4;
		$rest_products_related_ = substr($products_related, 1, -1);  // retourne "abcde"
		
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = " SELECT  name,id , image,price,price_old,discount, alias,category_alias,category_id,quantity, price,price_old,types,manufactory_image,manufactory_name,date_start,date_end,is_hotdeal,is_hot,style_types, type,gift,free_ship,promotion_info
		FROM " . $fs_table->getTable ( 'fs_products' ) . "
		WHERE id IN ( $rest_products_related_ )
		AND id <>  $product_id
		AND published = 1 AND status = 1 AND is_trash = 0
		ORDER BY  ordering DESC , id DESC
		LIMIT $limit
		";
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
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


	function get_products_combo($products_related, $product_id) {
		if (!$products_related || ! $product_id)
			return;
		$limit = 10;
		$rest_products_related_ = substr($products_related, 1, -1);  // retourne "abcde"
		
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = " SELECT  name,id , image,price,price_old,discount, alias,category_alias,category_id,quantity, price,price_old,types,manufactory_image,manufactory_name,date_start,date_end,is_hotdeal,is_hot,style_types, type
		FROM " . $fs_table->getTable ( 'fs_products' ) . "
		WHERE id IN ( $rest_products_related_ )
		AND id <>  $product_id
		AND published = 1 AND status = 1 AND is_trash = 0
		ORDER BY  ordering DESC , id DESC
		LIMIT $limit
		";
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}

	function get_products_list_gift($data) {
		$gift_id ='';
		$list_gift = $this->get_records('published = 1','fs_products_gift','*','priority DESC');
		foreach ($list_gift as $item) {
			if($item-> products_related){
				$data_id = ','.$data-> id.',';
				$pos = strpos($item-> products_related,$data_id);
				if($pos !== false){
					$gift_id = $item-> id;
				}
			}else{
				if($item-> manufactory_related && $item-> category_id_wrapper){
					$pos = strpos($item-> manufactory_related, ','.$data-> manufactory.',');
					$pos2 = strpos($item-> category_id_wrapper, ','.$data-> category_id.',');
					if($pos !== false && $pos2 !== false){
						$gift_id = $item-> id;
					}
				}elseif($item-> manufactory_related){
					$pos = strpos($item-> manufactory_related, ','.$data-> manufactory.',');
					if($pos !== false){
						$gift_id = $item-> id;
					}
				}elseif($item-> category_id_wrapper){
					$pos = strpos($item-> category_id_wrapper, ','.$data-> category_id.',');
					if($pos !== false){
						$gift_id = $item-> id;
					}
				}
			}
		}

		if($gift_id){
			$data_gift = $this->get_record('published = 1 AND id = ' . $gift_id,'fs_products_gift','*','priority DESC');
			if(!$data_gift-> products_gift){
				return;
			}
			
			$products_related = $data_gift-> products_gift;

			$rest_products_related_ = substr($products_related, 1, -1);

			$fs_table = FSFactory::getClass ( 'fstable' );
			$query = " SELECT *
			FROM " . $fs_table->getTable ( 'fs_products_list_gift' ) . "
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

	// function get_products_list_gift($products_related) {
	// 	if (!$products_related)
	// 		return;
	// 	$limit = 10;
	// 	$rest_products_related_ = substr($products_related, 1, -1);  // retourne "abcde"
	
	// 	$fs_table = FSFactory::getClass ( 'fstable' );
	// 	$query = " SELECT *
	// 	FROM " . $fs_table->getTable ( 'fs_products_list_gift' ) . "
	// 	WHERE id IN ( $rest_products_related_ )
	// 	AND published = 1 
	// 	ORDER BY  ordering DESC , id DESC
	// 	LIMIT $limit
	// 	";
	// 	global $db;
	// 	$sql = $db->query ( $query );
	// 	$result = $db->getObjectList ();
	// 	return $result;
	// }

	// function get_products_same_price($record_id,$price) {
	// 	if (! $price || ! $record_id)
	// 		return;
	// 	$limit = 5;
	// 	$products  =$this->get_record_by_id($record_id,'fs_products');
	// 	$cat_id= $products->category_id;
	// 	$fs_table = FSFactory::getClass ( 'fstable' );
	// 	$query = " SELECT id,name,name_core,summary,image,price,price_old,discount,types, alias,is_hot, category_id,category_alias, ABS(price - ".$price.") as price_subtract,manufactory_image,manufactory_name,style_types, type
	// 	FROM " . $fs_table->getTable ( 'fs_products' ) . "
	// 	WHERE published = 1 AND is_trash = 0
	// 	AND id <>  $record_id
	// 	AND category_id =  $cat_id  AND status = 1
	// 	ORDER BY price_subtract ASC
	// 	LIMIT $limit
	// 	";
	// 	global $db;
	// 	$sql = $db->query ( $query );
	// 	$result = $db->getObjectList ();
	// 	return $result;
	// }


	function get_products_same_price($record_id,$price) {
		if (! $price || ! $record_id)
			return;
		$limit = 4;
		$products  =$this->get_record_by_id($record_id,'fs_products');
		$cat_id= $products->category_id;
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = " SELECT id,name,name_core,gift_accessories,image,price,price_old,discount,types, alias,is_hot, category_id,category_alias,manufactory_name,style_types, type, promotion_info
		FROM " . $fs_table->getTable ( 'fs_products' ) . "
		WHERE published = 1 AND is_trash = 0 AND price <  " . $products->price.  " AND price > 0
		AND id <>  $record_id
		AND category_id =  $cat_id AND is_trash = 0
		ORDER BY price DESC, ordering DESC 
		LIMIT $limit
		";
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList();

		$query2 = " SELECT id,name,name_core,summary,image,price,price_old,discount,types, alias,is_hot, category_id,category_alias,manufactory_name,style_types, type
		FROM " . $fs_table->getTable ( 'fs_products' ) . "
		WHERE published = 1 AND is_trash = 0 AND price >=  " . $products->price.  " AND price > 0
		AND id <>  $record_id
		AND category_id =  $cat_id  AND status = 1
		ORDER BY price ASC, ordering DESC 
		LIMIT $limit
		";

		global $db;
		$sql2 = $db->query ( $query2 );
		$result2 = $db->getObjectList();

		
		$result3 = array_merge($result,$result2);
		// printr($result3);
		return $result3;
	}
	function getRelateContent($product_name, $product_main_key) {
		if (! $product_name)
			return;
		$where = '';
		$where .= ' AND ( title like "%' . $product_name . '%" ';
		if ($product_main_key) {
			$arr_main_key = explode ( ',', $product_main_key );
			foreach ( $arr_main_key as $item ) {
				if ($item) {
					$where .= ' OR title like "%' . $item . '%" ';
					$where .= ' OR main_key like "%' . $item . '%" ';
				}
			}
		}
		$where .= ') ';
		$limit = 5;
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = " SELECT id,title, alias, category_id
		FROM " . $fs_table->getTable ( 'fs_news' ) . "
		WHERE published  = 1
		AND id > 2
		" . $where . "
		ORDER BY  ordering DESC , id DESC
		LIMIT $limit
		";
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}

	function getImages($record_id) {
		if (! $record_id)
			return;
		$limit = 10;
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = " SELECT id,image, record_id,title as name , content, color_id,is_default
		FROM " . $fs_table->getTable ( 'fs_products_images' ) . "
		WHERE record_id =  $record_id
		ORDER BY is_default DESC, ordering ASC, id ASC
		LIMIT $limit
		";
		global $db;
		$result = $db->getObjectList ($query );
		return $result;
	}

	function getImageDefault($record_id) {
		if (! $record_id)
			return;
		$limit = 10;
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = " SELECT id,image, record_id,title as name , content, color_id,is_default
		FROM " . $fs_table->getTable ( 'fs_products_images' ) . "
		WHERE record_id =  $record_id AND is_default = 1 ";
		global $db;
		$result = $db->getObject ($query );
		return $result;
	}

	function get_group_image($record_id) {
		if (! $record_id)
			return;
		$limit = 100;
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = " SELECT g.*
		FROM " . $fs_table->getTable ( 'fs_products_images' ) . " as m
		INNER JOIN fs_products_image_groups as g ON m.group_id = g.id
		WHERE m.record_id =  $record_id 
		GROUP BY g.id
		ORDER BY g.ordering ASC, id ASC
		";
		global $db;
		$result = $db->getObjectListByKey ('id',$query );
		return $result;
	}

	function get_color_image($record_id) {
		if (! $record_id)
			return;
		$limit = 100;
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = " SELECT g.*
		FROM " . $fs_table->getTable ( 'fs_products_images' ) . " as m
		INNER JOIN fs_products_colors as g ON m.color_id = g.id
		WHERE m.record_id =  $record_id 
		GROUP BY g.id
		ORDER BY g.ordering ASC, id ASC
		";
		global $db;
		$result = $db->getObjectListByKey ('id',$query );
		return $result;
	}

	

	function getImages_other($record_id) {
		if (! $record_id)
			return;
		$limit = 10;
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = " SELECT image,title as name
		FROM " . $fs_table->getTable ( 'fs_products_images' ) . "
		WHERE record_id =  $record_id
		ORDER BY ordering ASC, id ASC
		LIMIT $limit
		";
		global $db;
		$result = $db->getObjectList ($query );
		return $result;
	}

		function getImagesGroup($record_id,$cid) {
		if (! $record_id)
			return;
		$limit = 100;
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = " SELECT image,title as name
		FROM " . $fs_table->getTable ( 'fs_products_images' ) . "
		WHERE record_id =  $record_id AND group_id = $cid
		ORDER BY ordering ASC, id ASC
		LIMIT $limit";
		global $db;
		$result = $db->getObjectList ($query );
		return $result;
	}

	function getImagesColor($record_id,$cid) {
		if (! $record_id)
			return;
		$limit = 100;
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = " SELECT image,title as name
		FROM " . $fs_table->getTable ( 'fs_products_images' ) . "
		WHERE record_id =  $record_id AND color_id = $cid
		ORDER BY ordering ASC, id ASC
		LIMIT $limit
		";
		global $db;
		$result = $db->getObjectList ($query );
		return $result;
	}


	

	function getImages_pro($record_id) {
		if (! $record_id)
			return;
		$limit = 10;
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = " SELECT image,name
		FROM " . $fs_table->getTable ( 'fs_products' ) . "
		WHERE id =  $record_id
		ORDER BY ordering ASC, id ASC
		LIMIT $limit
		";
		global $db;
		$result = $db->getObject ($query );
		return $result;
	}


	
	function get_slideshow_highlight($record_id) {
		if (! $record_id)
			return;
		$limit = 10;
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = " SELECT id,image, record_id,title as name , content, color_id
		FROM " . $fs_table->getTable ( 'fs_products_slideshow_highlight' ) . "
		WHERE record_id =  $record_id
		ORDER BY ordering ASC, id ASC
		LIMIT $limit
		";
		global $db;
		$result = $db->getObjectList ($query );
		return $result;
	}
	function get_price_by_colors($record_id) {
		if (! $record_id)
			return;
		$limit = 10;
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = " SELECT *
		FROM " . $fs_table->getTable ( 'fs_products_price' ) . "
		WHERE record_id =  $record_id
		ORDER BY  price ASC
		";
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}

	// function get_price_by_extend($record_id, $group_id) {
	// 	if (! $record_id)
	// 		return;
	// 	$limit = 10;
	// 	$fs_table = FSFactory::getClass ( 'fstable' );
	// 	$query = " SELECT *
	// 	FROM " . $fs_table->getTable ( 'fs_products_price_extend' ) . " AS p
	// 	INNER JOIN fs_extends_items as e on p.extend_id = e.id
	// 	WHERE record_id =  $record_id AND group_extend_id = $group_id
	// 	ORDER BY  e.ordering, p.price
	// 	";
	// 	global $db;
	// 	$sql = $db->query ( $query );
	// 	$result = $db->getObjectList ();
	// 	return $result;
	// }

	function get_price_by_extend($record_id, $group_id) {
		if (! $record_id)
			return;
		$limit = 10;
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = " SELECT *
		FROM " . $fs_table->getTable ( 'fs_products_price_extend' ) . "
		WHERE record_id =  $record_id AND group_extend_id = $group_id
		ORDER BY ABS(price)
		";
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}

	
	function get_price_by_extend_group($record_id) {
		if (! $record_id)
			return;
		$limit = 10;
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = " SELECT DISTINCT group_extend_id, ground_extend_name
		FROM " . $fs_table->getTable ( 'fs_products_price_extend' ) . "
		WHERE record_id =  $record_id
		ORDER BY group_ordering ASC
		";
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}
	
	function getProductsee($product_alias){
		$query = "  SELECT id,name,alias,category_alias,category_id ,image,price,price_old,quantity,alias,discount,types,is_hot,is_new,style_types,type FROM fs_products WHERE alias = '$product_alias'";
		global $db;
		$db->query($query);
		return $db->getObject();
	}
//set cookie đã xem
	function setCookie() {
		$listProduct = array();
		$code = FSInput::get('code');
//            var_dump($code);die;
//            unset($_SESSION['products']);
            // $exits_array = in_array($code,  $ss_products);
//            var_dump($exits_array);die;
		if(isset($_SESSION['products']) && in_array($code,  $_SESSION['products'])){
			$ss_products = isset($_SESSION['products'])?$_SESSION['products']:null;
			$count = count( $ss_products);
			if($count>=4)
				array_shift($_SESSION['products']);
			$_SESSION['products'][] = $code;
		}else{
			$_SESSION['products'][] = $code;
		}

		if (isset($_SESSION['products'])) {
			$_SESSION['products'] = array_unique($_SESSION['products'], 0);
			foreach ($_SESSION['products'] as $value) {
				$product = $this->getProductsee($value);
				$listProduct[] = $product;
			}
		}
		
		return array_reverse($listProduct);
	}
	
	/* 
		 * get array [id] = alias
		 */
	function get_content_category_ids($str_ids) {
		if (! $str_ids)
			return;
		$fs_table = FSFactory::getClass ( 'fstable' );
		
		// search for category
		

		$query = " SELECT id,alias
		FROM " . $fs_table->getTable ( 'fs_news_categories' ) . "
		WHERE id IN (" . $str_ids . ")
		";
		
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		$array_alias = array ();
		if ($result)
			foreach ( $result as $item ) {
				$array_alias [$item->id] = $item->alias;
			}
			return $array_alias;
		}
		
		function getProductExt($tablename, $product_id) {
			$id = FSInput::get ( 'id', 0, 'int' );
			if (! $tablename || $tablename == 'fs_products')
				return array ();
			global $db;
			if (! $db->checkExistTable ( $tablename ))
				return array ();
			
			$query = " SELECT *
			FROM $tablename 
			WHERE 
			record_id = $product_id	
			";
			$db->query ( $query );
			$result = $db->getObject ();
			
			return $result;
			
		}
		
	/*
		 * Lấy dữ liệu từ các bảng mở rộng
		 */
	function get_all_data_foreign($extend_fields) {
		if (! count ( $extend_fields ))
			return array ();
		$data_foreign = array ();
		foreach ( $extend_fields as $field ) {
			if ($field->field_type == 'foreign_one' || $field->field_type == 'foreign_multi') {
				$table_name = $field->foreign_tablename;
				$id = $field->foreign_id;
				$data_foreign [$field->field_name] = $this->get_records ('id = '.$id, $table_name );
			}
		}
		return $data_foreign;
	}
	/*
		 * Lấy dữ liệu từ các bảng mở rộng
		 */
	function get_data_foreign($table_name,$value,$type = 'foreign_one'){
		
		if(!$value)
			return;
		$where = '';
		if($type == 'foreign_one'){
			$where  = ' id = '.intval($value).' ';
			return $this -> get_result($where,$table_name,'name');
		}else{
			$where  = ' id IN (0'.$value.'0) ';
			$rs =  $this -> get_records($where,$table_name,'name' );
			$html = '<ul class="foreign_multi">';
			for($i = 0; $i < count($rs); $i ++){
				$html .= '<li>'.$rs[$i]->name.'</li>';		
			}
			$html .='</ul>';
			return $html;
		}
		
	}

	function get_products_same_config ( $table_name, $ext_fields,$extend, $data , $limit = 4 ){
		if(!$table_name || !count($ext_fields) || !$extend)
			return;
		$where = '';
		foreach($ext_fields as $field){
			if($field -> is_config){
				$fname = $field -> field_name;
				$ftype = $field -> field_type;
				$value = isset($extend -> $fname) ? $extend -> $fname : '';
				if(!$value)
					break;
				if($ftype == 'foreign_multi'){
					$arr_value = explode(',', $value);
					foreach($arr_value as $v){
						if(!$v)
							continue;
						if($where)
							$where .= ' OR ';
						$where .= $fname. ' LIKE "%,'.$v.',%" ';
					}
				}else{
					if($where)
						$where .= ' OR ';
					$where .= $fname. ' = "'.addslashes($value).'" ';
				}
			}
		}
		if(!$where)
			return;
		$where = '('.$where.')';
		
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = " SELECT record_id as id,name,summary,image,price,price_old,discount,types, alias, category_id,category_alias,manufactory_image,manufactory_name
		FROM " . $table_name . "
		WHERE published = 1
		AND record_id <>  ".$data -> id." AND  ".$where ."
		ORDER BY ordering ASC 
		LIMIT $limit
		";
		global $db;
		$db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}
	
	function get_ext_group_fields($str_group_fields)
	{
			// get rootid
		if(!$str_group_fields)
			return ;
		
		global $db;
			// query get alias
		$query = " SELECT *
		FROM fs_products_fields_groups 
		WHERE id IN ($str_group_fields)
		ORDER BY ordering ASC ";
		$db->query($query);
		$rs = $db->getObjectListByKey('id');	
		return $rs;
	}
	
	function get_comments($product_id) {
		global $db;
		if (! $product_id)
			return;
		
		//			$limit = 5;
		//			$id = FSInput::get('id');
		$query = " SELECT name,created_time,id,email,comment,parent_id,level,product_id
		FROM fs_products_comments
		WHERE product_id = $product_id
		AND published = 1
		ORDER BY  created_time  DESC
		";
		$db->query ( $query );
		$result = $db->getObjectList ();
		
		$tree  = FSFactory::getClass('tree','tree/');
		$list = $tree -> indentRows2($result);
		return $list;
	}
	function _save_comment() {
		$name = FSInput::get ( 'name' );
		$email = FSInput::get ( 'email' );
		$text = FSInput::get ( 'text' );
		$record_id = FSInput::get ( 'record_id', 0, 'int' );
		$row ['rate'] = FSInput::get ( 'rate', 0, 'int' );
		$time = date ( 'Y-m-d H:i:s' );
		$published = 1;
		
		$sql = " INSERT INTO fs_products_comments
		(name,email,comment,product_id,published,created_time,edited_time)
		VALUES('$name','$email','$text','$record_id','$published','$time','$time')
		";
		global $db;
		$db->query ( $sql );
		$id = $db->insert ();
		return $id;
	}
	

	function get_address($str_id) {
		if (! $str_id)
			return;
		
		$query = " SELECT id,name, image
		FROM fs_address
		WHERE id IN (" . $str_id . ") 
		AND published = 1
		ORDER BY ordering
		";
		global $db;
		$db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}
	
	function get_products_by_ids($str_products_together) {
		if (! $str_products_together)
			return;
		$query = " SELECT name,name_core,id , image, alias,category_id,category_alias,gift_accessories,is_hotdeal,date_start,date_end,h_price,price,price_old,promotion_info
		FROM fs_products
		WHERE id IN (" . $str_products_together . ") 
		AND published = 1 AND is_trash = 0
		LIMIT 5
		";
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectListByKey ( 'id' );
		return $result;
	}
	
	function get_products_incentives($product_id) {
		
		$query = " SELECT *
		FROM fs_products_incentives AS a
		WHERE product_id = $product_id";
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}
	
	function get_products_shops($str_shop_ids) {
		if (! $str_shop_ids)
			return;
		$query = " SELECT a.*
		FROM fs_products_shops AS a
		WHERE a.shop_id IN ($str_shop_ids)
		AND is_promotion = 1
		";
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}
	/*
		 * Lấy danh sách category 
		 */
	function get_list_parent($list_parents) {
		if (! $list_parents)
			return;
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = 'SELECT name,id,alias,parent_id FROM ' . $fs_table->getTable ( 'fs_products_categories' ) . ' WHERE id IN (0' . $list_parents . '0) 
		ORDER BY parent_id ASC' ;
		global $db;
		$db->query ( $query );
		$list = $db->getObjectList ();
		return $list;
	}
	/*
		 * get alias of parent_root
		 */
	function get_ext_fields($tablename) {
		// get rootid
		if (! $tablename)
			return;
		
		global $db;
		// query get alias  
		// tam thơi xóa điều kiệns AND is_compare = 1
		$query = " SELECT *
		FROM fs_products_tables 
		WHERE table_name = '$tablename'
		ANd  is_filter <> 1 AND is_price <> 1
		ORDER BY ordering  
		";
		$db->query ( $query );
		$rs = $db->getObjectList ();
		return $rs;
	}



	function get_news_relate_tags($name_core,$tag ,$tablename,$category_id_includes  = '',$category_id_excludes = '') {
		if (!$tag && !$name_core)
			return;

		$where = '  WHERE published = 1 ';
		if($category_id_includes){
			$where .= ' AND category_id_wrapper LIKE "%,'.$category_id_includes.',%" ';
		}
		if($category_id_excludes){
			$where .= ' AND category_id_wrapper NOT LIKE "%,'.$category_id_excludes.',%" ';
		}

		if($name_core){
			$tag .=  $name_core.','.$tag;
		}

		$arr_tags = explode ( ',', $tag );
		
		$total_tags = count ( $arr_tags );
		if ($total_tags) {
			$where .= ' AND (';
			$j = 0;
			for($i = 0; $i < $total_tags; $i ++) {
				$item = trim ( $arr_tags [$i] );
				if ($item) {
					if ($j > 0)
						$where .= ' OR ';
					$where .= " tags like '%" . $item . "%' OR  title like '%" . $item . "%'";
					$j ++;
				}
			}
			$where .= ' )';
		}
		
		global $db;
		$limit = 6;
		$fs_table = FSFactory::getClass ( 'fstable' );
		
		$query = " SELECT id,title,alias ,category_id ,image , category_alias ,summary,created_time
		FROM " . $fs_table->getTable ( $tablename ) . " 
		" . $where . "
		ORDER BY id DESC,ordering DESC
		LIMIT 0,$limit
		";
		$db->query ( $query );
		$result = $db->getObjectList ();
		
		return $result;
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

	function get_news_new(){
		return $list = $this -> get_records('published = 1','fs_news','id,title,summary,image, alias, category_id,category_alias','ordering DESC','4');
	}

	function update_hits($product_id){
		if(USE_MEMCACHE){
			$fsmemcache = FSFactory::getClass('fsmemcache');
			$mem_key = 'array_hits';
			
			$data_in_memcache = $fsmemcache -> get($mem_key);
			if(!isset($data_in_memcache))
				$data_in_memcache = array();
			if(isset($data_in_memcache[$product_id])){
				$data_in_memcache[$product_id]++;
			}else{
				$data_in_memcache[$product_id] = 1;
			}
			$fsmemcache -> set($mem_key,$data_in_memcache,10000);
			
		}else{
			if(!$product_id)
				return;
			
			// count
			global $db,$econfig;
			$sql = " UPDATE fs_products 
			SET hits = hits + 1 
			WHERE  id = '$product_id' 
			";
			// $db->query($sql);
			$rows = $db->affected_rows($sql);
			return $rows;
		}
	}
	function get_price_product(){
		$fs_table = FSFactory::getClass ( 'fstable' );
		$price_id = FSInput::get ( 'price_id' );
		if (!$price_id)
			return;
		$query = " SELECT *
		FROM " . $fs_table->getTable ( 'fs_products_price' ) . " 
		WHERE id = $price_id";
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObject ();
		return $result;	
	}

	function get_types_compatables($product_id){
		$query = " SELECT DISTINCT group_id, group_name
		FROM " . 'fs_products_compatables'. " 
		WHERE product_id = $product_id ORDER BY ordering ASC";
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;	
	}
		/*
		 * get temporary data stored in fs_order
		 * 1
		 */
		function getOrder() {
			$session_id = session_id();
			$query = " SELECT *
			FROM fs_order
			WHERE  session_id = '$session_id' 
			AND is_temporary = 1 ";
			global $db;
			$db -> query($query);
			return $rs = $db->getObject();
			
		}
		function get_user(){
			if(!isset($_SESSION['username']))
				return false;
			$username = $_SESSION['username'];
			if(!$username)
				return;
			$query = " SELECT full_name,sex,address as address,email, mobilephone,mobilephone
			FROM fs_members 
			WHERE  username = '$username' ";
			global $db;
			$db -> query($query);
			return $rs = $db->getObject();
		}
		/*
		 * if currency = 'VND' return
		 * else transform. 
		 */
		function getPrice() {
			$product_id = FSInput::get('id');
			if(!$product_id)
				return -1;
			$query = " SELECT price,  discount
			FROM fs_products 
			WHERE id = $product_id
			";
			global $db;
			$db -> query($query);
			$rs = $db->getObject();
			
			return array($rs->price,$rs -> discount);
		}
		function eshopcart2_simple_save(){
			
			//$username = isset($_SESSION['username'])?$_SESSION['username'] : '';
			//$user_id = $this ->get_user_id();
			$username = isset($_SESSION['username'])?$_SESSION['username'] : '';
			$user_id ='';
			
			$sender_email  = FSInput::get('sender_email');
			
			if(!$sender_email)
				return;
			
			$quantity = FSInput::get('quantity');
			$price =  FSInput::get('price');
			$warranty =  FSInput::get('warranty');
			
			
			//mau san pham
			$color_id =  FSInput::get('color');
			$color =$this->get_record_by_id($color_id,'fs_products_price');
			if($color)
				$price = $price + $color->price;
			
			if($warranty == 3){
				$total_before_discount =  ($price+300000)* $quantity;
			}else if($warranty == 2){
				$total_before_discount =  ($price+300000)* $quantity;
			}else {
				$total_before_discount =  $price* $quantity;
			}
			//khu  vực
			$region =  FSInput::get('region');
			$data =$this->get_record_by_id(FSInput::get('id'),'fs_products');
			if($data){
				if($region == 'sl_hn'){
					$total_before_discount = $total_before_discount+$data->ha_hoi;
				}else if($region =='sl_hcm'){	
					$total_before_discount = $total_before_discount+$data->ho_chi_minh;
				}elseif($region =='sl_dn')	{
					$total_before_discount =$total_before_discount+$data->da_nang;
				}	
				
			}
			$total_after_discount = $total_before_discount;
			$products_count = $quantity; 					
			$prd_id_str =  FSInput::get('id');
			
			$session_id = session_id();
			
			$sender_name  = FSInput::get('sender_name');
			$sender_telephone  = FSInput::get('sender_telephone');
			$sender_address  = FSInput::get('sender_address');
			$time = date("Y-m-d H:i:s");
			if(!$sender_name || !$sender_email  )
				return false;
			
			$fsstring = FSFactory::getClass('FSString');
			$random_string = $fsstring -> generateRandomString(8);
			$code_order = $random_string;
			
			$sql = " INSERT INTO 
			fs_order (`username`,`user_id`,products_id,is_temporary,session_id,sender_name,
			sender_address,sender_email,sender_telephone,
			created_time,edited_time,total_before_discount,total_after_discount,products_count,is_activated,code_order)
			VALUES ('$username','$user_id','$prd_id_str','0','$session_id','$sender_name',
			'$sender_address','$sender_email','$sender_telephone',
			'$time','$time','$total_before_discount','$total_after_discount','$products_count','0','$code_order');
			";
			global $db;
			// $db->query($sql);
			$id = $db->insert($sql);
			
			// update
			$this -> save_order_items($id);

			return $id;
		}
		function get_user_id(){
			$username = $_SESSION['username'];
			if(!$username)
				return;
			$query = " SELECT id
			FROM fs_members 
			WHERE  username = '$username' ";
			global $db;
			$db -> query($query);
			return $rs = $db->getResult();
		}
		/*
		 * Save data into fs_order_items
		 */
		function save_order_items($order_id){
			if(!$order_id)
				return false;
			
			global $db;
			
			// remove before update or inser
			$sql = " DELETE FROM fs_order_items
			WHERE order_id = '$order_id'"  ;
			
			// $db->query($sql);
			$rows = $db->affected_rows($sql);	
			
			$quantity = FSInput::get('quantity');
			$price =  FSInput::get('price');
			$price_old =  FSInput::get('price_old');
			$products_count = $quantity; 					
			$prd_id =  FSInput::get('id');	
			$warranty =  FSInput::get('warranty');
			$region =  FSInput::get('region');
			//mau san pham
			$color_id =  FSInput::get('color');
			$color =$this->get_record_by_id($color_id,'fs_products_price');
			if($color) 
				$price = $price + $color->price;
			if($warranty == 3){
				$total_money =  ($price +300000)* $quantity;
			}else if($warranty == 2){
				$total_money =  ($price +300000)* $quantity;
			}else{
				$total_money =  $price* $quantity;
			}
			//khu  vực
			$region =  FSInput::get('region');
			$data =$this->get_record_by_id(FSInput::get('id'),'fs_products');
			if($data){
				if($region == 'sl_hn'){
					$total_money = $total_money+$data->ha_hoi;
				}else if($region =='sl_hcm'){	
					$total_money = $total_money+$data->ho_chi_minh;
				}elseif($region =='sl_dn')	{
					$total_money =$total_money+$data->da_nang;
				}	
				
			}	
//			$total_money = $quantity*$price;
			
			// insert data
			$sql = " INSERT INTO fs_order_items (order_id,product_id,price,count,discount,total,warranty,color_id,region)
			VALUES ('$order_id','$prd_id','$price','$quantity','$price_old','$total_money','$warranty','$color_id','$region') "; 
			
				// $db->query($sql);
			$rows = $db->affected_rows($sql);
			return true;				
			
			
		}
		function get_relate_news($news_related,$category_id_includes  = '',$category_id_excludes = '') {
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
		$query = ' SELECT id,title,summary,image, alias, category_id,category_alias,created_time
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


	function get_relate_news_auto() {
		$limit = 6;
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = ' SELECT id,title,summary,image, alias, category_id,category_alias,created_time
		FROM ' . $fs_table->getTable ( 'fs_news' ) . '
		WHERE published = 1 AND is_trash = 0
		ORDER BY  ordering DESC , id DESC
		LIMIT '.$limit.'
		';
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}




	function get_images_plus($record_id) {
		if (! $record_id)
			return;
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = " SELECT *
		FROM " . $fs_table->getTable ( 'fs_products_images_plus' ) . "
		WHERE record_id =  $record_id
		ORDER BY  id DESC
		";
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}
	
	function get_list_new_product()
	{
		global $db;
		$query = "SELECT name,id , image,price,price_old,discount, alias,category_alias,quantity, price,price_old,types,manufactory_image,manufactory_name,date_start,date_end,warranty,is_hotdeal,summary,accessories
		FROM fs_products WHERE published = 1  AND category_published = 1 AND show_in_homepage = 1  AND is_new = 1
		ORDER BY  ordering DESC, created_time DESC, id DESC LIMIT 0,5";
		$db->query($query);
		$result = $db->getObjectList();
		return $result;
	}
	function get_list_hot_product()
	{
		global $db;
		$query = "SELECT name,id , image,price,price_old,discount, alias,category_alias,quantity, price,price_old,types,manufactory_image,manufactory_name,date_start,date_end,warranty,is_hotdeal,summary,accessories
		FROM fs_products  WHERE is_sell = 1 ORDER BY sale_count DESC, created_time DESC, id DESC LIMIT 0,5";
		$db->query($query);
		$result = $db->getObjectList();
		return $result;
	}
	function remove_cached($link_detail){
			// $this -> remove_memcached();
		$fsCache = FSFactory::getClass('FSCache');
		$module_rm = 'comments';

		$str_link = $link_detail;
		
			// xoa chi tiết tin
		$fsCache -> remove($str_link,'modules/'.$module_rm);
		
		
			// $files = glob(PATH_BASE.'/cache/modules/comments/*' ); 
			// foreach( $files as $file ){			
			// 	if( is_file( $file ) ) {				
			// 		if( !@unlink( $file ) ) {
			// 			//Handle your errors 
			// 		} 
			// 	} 
			// }			
		
			// $files = glob(PATH_BASE.'/cache/modules/comments/*' ); 
			// foreach( $files as $file ){			
			// 	if( is_file( $file ) ) {				
			// 		if( !@unlink( $file ) ) {
			// 			//Handle your errors 
			// 		} 
			// 	} 
			// }			

		echo '1';
	}

	function get_orders(){
		return $this -> get_records('sender_name <> "" AND sender_telephone <> ""','fs_order','*',' id DESC ', '10');
	}

	function get_filter_menu($manu_id,$table_name){
		if(!$manu_id || !$table_name)
			return;
		return $this -> get_record(' tablename = "'.$table_name.'" AND field_name = "manufactory" AND filter_value = "'.$manu_id.'" ','fs_products_filters','*');	
	}

	function prices_by_regions($record_id){
		return $this -> get_records('record_id = '.$record_id.' ','fs_products_regions_price','*','',100,'region_id');
	}

	function get_news_name_core(){
		return $this -> get_records('name_core is not null AND name_core <> "" ','fs_news','id,name_core,title,alias,category_id,category_alias',' ordering ASC ',100);
	}

	function export_product() {

		$start = FSInput::get ( 'start' );
		$end = FSInput::get ( 'end' );
		$range = $end - $start + 1;
		$query = " SELECT *
		FROM fs_products 
		ORDER BY id ASC limit $start,$range ";
		global $db;
		$sql = $db->query($query);
		return  $db->getObjectList();
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
			$query2 = " SELECT s.price,s.total_item,s.total_item_buy
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

	function list_combo($product_id){
		$today_time = date('Y-m-d H:i:s');
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = " SELECT id,name, products_ids
		FROM " . $fs_table->getTable ( 'fs_sales' ) . "
		WHERE published = 1  AND type = 5 AND products_ids LIKE '%,".$product_id.",%' ORDER BY ordering ASC";
		global $db;
		$sql = $db->query ( $query );
		$sale = $db->getObjectList();
		return $sale;
	}

	function get_list_product_combo($products_ids, $combo_id){
		$list_product = array();
		$fs_table = FSFactory::getClass ( 'fstable' );
		$arr_id = explode(",", $products_ids);
		global $db;
		if(empty($arr_id)) return;
		foreach ($arr_id as $id) {
			if(!$id) continue;
			$query = " SELECT p.id,p.alias,p.category_alias,p.name, p.image, p.price_old, s.price, p.category_id, s.sale_id
			FROM " . $fs_table->getTable ( 'fs_products' ) . " as p INNER JOIN fs_sales_products as s ON p.id = s.product_id
			WHERE p.published = 1  AND s.sale_id = ".$combo_id." AND p.id =".$id;
			$sql = $db->query ( $query );
			$list_product[] = $db->getObject();
		}

		return $list_product;

	}


	function save_order_status(){
		$fsstring = FSFactory::getClass('FSString','','../');
		$row = array ();
		$name = FSInput::get('name');
		$phone = FSInput::get('phone');
		$email = FSInput::get('email');
		$product_id = FSInput::get('id');
		
		if(!$name || !$phone || !$email || !$product_id){
			return false;
		}
		$data = $this->get_record('id = ' . $product_id,'fs_products','name, code');

		$time = date ( "Y-m-d  H:i:s" );
		$row ['product_id'] = $product_id;
		$row ['product_name'] = $data->name;
		$row ['product_code'] = $data->code;
		$row ['phone'] = $phone;
		$row ['created_time'] = $time;
		$row ['name'] = $name;
		$row ['email'] = $email;

		$id =  $this -> _add($row, 'fs_order_status',1);
		return $id;
	}

}

?>