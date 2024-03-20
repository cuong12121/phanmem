<?php
class ProductsModelsCart extends FSModels {
	var $limit;
	var $page;
	function __construct() {
		parent::__construct ();
		$limit = 30;
		$this->limit = $limit;
		$fs_table = FSFactory::getClass ( 'fstable' );
		$this -> table_product =  $fs_table->getTable ( 'fs_products' );
		$this -> table_order =  $fs_table->getTable ( 'fs_order' );
		$this -> table_order_items =  $fs_table->getTable ( 'fs_order_items' );
	}
	
	/*
	 * tìm giá thật dựa trên id
	 */
	function getPrice($product_id, $price_id, $is_combo = 0) {
		
		if (!$product_id)
			return '';

		if ($is_combo) {
			$query = ' SELECT *
			FROM fs_products
			WHERE id = ' . $product_id . '
			';
		} else {
			if (! $price_id)
				return '';

			$query = ' SELECT *
			FROM fs_products_prices 
			WHERE record_id = ' . $product_id . '
			AND id = ' . $price_id . '
			';
		}
		
		global $db;
		return $db->getObject ( $query );
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
			$query2 = " SELECT s.price,s.total_item,s.total_item_buy,s.id
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

	function check_code()
	{
		// $code_sale = isset($_COOKIE['code_sale'])?$_COOKIE['code_sale'] : '';
		// if($code_sale){
		// 	$code_share=$_COOKIE['code_sale'];
		// }else{
			$code_share = FSInput::get('code_input');
		// }
		
		$result = $this->get_record( 'published = 1 AND number_sale > 0 AND CURDATE() < date_end AND code = "'.$code_share.'"', 'fs_sale', '*');
		return $result;

	}

	function get_sale_2() {
		$fs_table = FSFactory::getClass ( 'fstable' );
		$cookie_price = @$_COOKIE['price_cookie'];
		$select = " * ";
		if($cookie_price){
			$where = "published = 1  AND money_dow = '".$cookie_price."'";
		}else{
			$where = "published = 1";
		}
		$order="ordering ASC";
		$limit=1;
		$result = $this->get_records( $where, $fs_table->getTable ( 'fs_sale' ), $select,$order,$limit,'');
		return $result;
	}

	function get_order($money_dow) {
		$sale = $this-> get_sale_2();
		
		foreach ($sale as $item) {
			# code...
		}
		$result = $this -> get_records('date_end BETWEEN  "'.@$item->date_start.'" AND  "'.@$item->date_end.'" AND money_dow ="'.$money_dow.'"','fs_order','*',' id DESC ',@$item->number_sale ,'');
		return $result;
	}
	
	function get_products_by_ids($str_ids) {
		if (! $str_ids)
			return;
		return $this->get_records ( ' id IN (' . $str_ids . ') AND published = 1 ', 'fs_products', 'id,name,alias,category_id,category_name,category_alias,image', '', ' 20 ', 'id' );
	}
	
	/*
		 * get temporary data stored in fs_order
		 * 1
		 */
	function getOrder() {
		$session_id = session_id ();
		$query = " SELECT *
		FROM fs_order
		WHERE  session_id = '$session_id' 
		AND is_temporary = 1 ";
		global $db;
		$db->query ( $query );
		return $rs = $db->getObject ();
		
	}
	
	function getProductById($product_id) {
		if (! $product_id)
			return;
		$query = " SELECT name,price,price2,price_old,id,image, category_id,alias,category_alias,manufactory,category_id_wrapper
		FROM fs_products
		WHERE  id = $product_id ";
		global $db;
		$db->query ( $query );
		return $rs = $db->getObject ();
	}

	function getComboById($combo_id) {
		if (! $combo_id)
			return;
		$query = " SELECT name,id
		FROM fs_sales
		WHERE  id = $combo_id ";
		global $db;
		$db->query ( $query );
		return $rs = $db->getObject ();
	}
	
	function getProductCategoryById($category_id) {
		if (! $category_id)
			return;
		$query = " SELECT name,id,alias 
		FROM fs_products_categories
		WHERE  id = $category_id ";
		global $db;
		$db->query ( $query );
		return $rs = $db->getObject ();
	}

	function eshopcart2_save() {
		return $this -> eshopcart2_save_new();
	}

	function eshopcart2_save_new(){
		if(!isset($_SESSION['cart'])) 
			return false;
		$product_list  = $_SESSION['cart'];
		$prd_id_array = array();
		$total_before_discount = 0; 
		$total_after_discount = 0;
		$products_count = 0; 
// 	Repeat products	
		global $config;
		for($i = 0; $i < count($product_list); $i ++) {
			$prd = $product_list[$i];
			$prd_id_array[] = $prd[0];
			$total_before_discount += $prd[1]; 
			$extend_price = $prd[10];
			$price_fix =  $prd[11];
			$type_down = $prd[12];
			$code_sale =  $prd[13];
			$price_send =  $prd[14];

 	// $total_before_discount += $prd[1]*$prd[2]; 

   // calculator color

			$color = $this -> get_record_by_id($prd[3],'fs_products_price');
			$total_before_discount = $total_before_discount + $color->price;

   // calculator memory
			$memory = $this -> get_record_by_id($prd[4],'fs_memory_price');
			$total_before_discount = $total_before_discount + $memory->price;


	// calculator memory
			$warranty = $this -> get_record_by_id($prd[5],'fs_warranty_price');
			$total_before_discount = $total_before_discount + $warranty->price;

	// calculator memory
			$origin = $this -> get_record_by_id($prd[6],'fs_origin_price');
			$total_before_discount = $total_before_discount + $origin->price;

	// calculator memory
			$species = $this -> get_record_by_id($prd[7],'fs_species_price');
			$total_before_discount = $total_before_discount + $species->price;

			$usage_states = $this -> get_record_by_id($prd[8],'fs_usage_states_price');
			$total_before_discount = $total_before_discount + $usage_states->price;

			if($prd[9]){					
				$region = $this -> get_record(' region_id = '.$prd[9].' AND record_id = '.$prd[0],'fs_products_regions_price');
				$total_before_discount += $region->price;
			}

			$arr_extend = explode(",",$prd[10]);
			foreach ($arr_extend as $i_extend) {
				$extend  = $this -> get_record_by_id($i_extend,'fs_products_price_extend');
				if($extend) {
					$total_before_discount = $total_before_discount + $extend-> price;	
				}
				
			}
			
			$total_before_discount = $total_before_discount*$prd[2]; 
			
	 // calculator warranty
			
			$products_count += $prd[2]; 
		}

		if($type_down == 1) {
			$total_after_discount = $total_before_discount*(1 - $price_send/100);
		}elseif($type_down == 2) {
			$total_after_discount = $total_before_discount - $price_send;
		}else {
			$total_after_discount = $total_before_discount;
		}

		
		$prd_id_str = implode(',',$prd_id_array);
		$session_id = session_id();
		
		$row = array();
		
		$row['products_id']           = $prd_id_str;
		$row['is_temporary']          = 0;
		$row['session_id']            = $session_id;
		$row['total_before_discount'] = $total_before_discount;
		$row['total_after_discount']  = $total_after_discount;
		$row['products_count']        = $products_count;
		$row['code_sale']  = $code_sale;
		$row['value_sale']  = $type_down;
		$row['money_dow']  = $price_send;

//$row['extend_price'] = $extend_price;
		
		$row['sender_name']           = FSInput::get('sender_name');
		$row['sender_telephone']      = FSInput::get('sender_telephone');
		$row['sender_email']          = FSInput::get('sender_email');
		$row['sender_address']   	  = FSInput::get('sender_address');
		$row['sender_comments']  	  = FSInput::get('sender_comments');
// $row['city_id']  	  = FSInput::get('city_receiver');
// $row['method']  	  = FSInput::get('method_receiver');

		$row['is_instalment']  	  = FSInput::get('is_instalment');
		if($row['is_instalment']){
			$row['instalment_percent_before']  	  = FSInput::get('instalment_percent_before');
			$row['instalment_months']  	  = FSInput::get('instalment_months');
			$row['instalment_money_before']  	  = FSInput::get('instalment_money_before');
			$row['instalment_money_per_month']  	  = FSInput::get('instalment_money_per_month');
			$row['instalment_money_total']  	  = FSInput::get('instalment_money_total');
			$row['instalment_certificate']  	  = FSInput::get('instalment_certificate');

		}


		$row['created_time']     	  = date("Y-m-d H:i:s");
		$row['edited_time']      	  = date("Y-m-d H:i:s");
		
		$id =$this -> _add($row, 'fs_order');

// echo $id."=====================id";
// die();

// update
		$this -> save_order_items_2($id);
		if($id) {
			unset($_SESSION['cart']);
		}
		return $id;
	}


				
		/*
		 * Save data into fs_order_items
		 */
		function save_order_items_2($order_id){
			if(!$order_id)
				return false;

			global $db,$config;
			
			// remove before update or inser
			$sql = " DELETE FROM fs_order_items
			WHERE order_id = '$order_id'"  ;
			
			//$db->query($sql);
			$rows = $db->affected_rows($sql);	
			
			
			// insert data
			$prd_id_array = array();
			// Repeat estores
			if(!isset($_SESSION['cart']))
				return false;


			$product_list  = $_SESSION['cart'];
			$sql = " INSERT INTO fs_order_items (order_id,product_id,price,count,total,color_id,color_name,color_price,memory_id,memory_name,memory_price,warranty_id,warranty_name,warranty_price,origin_id,origin_name,origin_price,species_id,species_name,species_price,usage_states_id,usage_states_name,usage_states_price,region_id,region_name,region_price,extend_price)
			VALUES "; 

			$array_insert = array();
			
			// Repeat products
			for($i = 0; $i < count($product_list); $i ++) {
				
				$prd = $product_list[$i];
				$total_money = $prd[1];
				$price = $prd[1];

				$arr_extend = explode(",",$prd[10]);
				foreach ($arr_extend as $i_extend) {
					$extend  = $this -> get_record_by_id($i_extend,'fs_products_price_extend');
					$total_money = $total_money + $extend-> price;
				}
				
				   // calculator color
				$color = $this -> get_record_by_id($prd[3],'fs_products_price');
				$total_money = $total_money + $color->price;

			   // calculator status
				$memory = $this -> get_record_by_id($prd[4],'fs_memory_price');
				$total_money = $total_money + $memory->price;


				 // calculator status
				$warranty = $this -> get_record_by_id($prd[5],'fs_warranty_price');
				$total_money = $total_money + $warranty->price;
				
				$origin = $this -> get_record_by_id($prd[6],'fs_origin_price');
				$total_money = $total_money + $origin->price;

				$species = $this -> get_record_by_id($prd[7],'fs_species_price');
				$total_money = $total_money + $species->price;

				$usage_states = $this -> get_record_by_id($prd[8],'fs_usage_states_price');
				$total_money = $total_money + $usage_states->price;

				if($prd[9]){
					$region = $this -> get_record(' region_id = '.$prd[9].' AND record_id = '.$prd[0],'fs_products_regions_price');
					$price = $price + $region->price;
					$total_money = $total_money + $region->price;	
				}
				



				$total_money = $total_money * $prd[2];
				
				$array_insert[] = "('$order_id','$prd[0]','$price','$prd[2]','$total_money','$prd[3]','$color->color_name','$color->price','$prd[4]','$memory->memory_name','$memory->price','$prd[5]','$warranty->warranty_name','$warranty->price','$prd[6]','$origin->origin_name','$origin->price','$prd[7]','$species->species_name','$species->price','$prd[8]','$usage_states->usage_states_name','$usage_states->price','$prd[9]','$region->region_name','$region->price','$prd[10]') ";
			}
			if(count($array_insert)) {
				$sql_insert = implode(',',$array_insert);
				$sql .= $sql_insert;
				//echo $sql;
				//die();
				//$db->query($sql);
				$rows = $db->affected_rows($sql);
				return true;				
			} else {
				return;
			}

		}


		/*
		 * Save new data into fs_order
		 * For 1 case: member buy
		 */
		function buy_fast_save(){
			
			$id = FSInput::get('id',0,'int');
			$phone = FSInput::get('telephone_buy_fast');
			if(!$id || !$phone)
				return;
			$product = $this -> get_record_by_id($id,'fs_products');
			
			$total_before_discount = $product -> price;
			$total_after_discount = $product -> price;
			$products_count = 1;
			
			
			$prd_id_str = $id;
			$session_id = session_id();
			
			$row = array();
			
			$row['products_id']           = $prd_id_str;
			$row['is_temporary']          = 0;
			$row['session_id']            = $session_id;
			$row['total_before_discount'] = $total_before_discount;
			$row['total_after_discount']  = $total_after_discount;
			$row['products_count']        = $products_count;
			
			$row['sender_name']           = '';
			$row['sender_telephone']      = $phone;
			$row['sender_email']          = '';
			$row['sender_address']   	  = '';
			$row['sender_comments']  	  = '';
			$row['created_time']     	  = date("Y-m-d H:i:s");
			$row['edited_time']      	  = date("Y-m-d H:i:s");
			$row['type']  	  = 'fast';


			$rid =$this -> _add($row, 'fs_order');
			$this -> save_order_items_fast($rid,$product);	

			// update

			return $rid;
		}

		/* Mua sản phẩm ngay: gõ điện thoại để gọi đên */ 
		function save_order_items_fast($order_id,$product){
			if(!$order_id)
				return false;
			global $db,$config;
			$row = array();
			$row['order_id'] = $order_id;
			$row['product_id'] = $product -> id;
			$row['price'] = $product -> price;
			$row['count'] = 1;
			$row['total'] = $row['price'] * $row['count'];
			return $this -> _add($row,'fs_order_items');		

		}
		




	function shopcart_save() {
		global $config;
		$row = array ();
		$task = FSInput::get('task');
		$user = $this->get_user ();
		if(!empty($user)){
			$user_id = $user-> id;
		}else{
			$user_id ='';
		}
		if (! isset ( $_COOKIE ['cart'] ))
			return false;
		
		$sender_email = FSInput::get ( 'sender_email' );
		// if (! $sender_email)
		// 	return;
		$order_current = $this -> getOrder();
		$discount_code = FSInput::get ( 'discount_code' );
		$discount_successfult = 0;
		$product_list = json_decode($_COOKIE['cart'],true);
		$prd_id_array = array ();
		$total_before_discount = 0;
		$total_after_discount = 0;
		$products_count = 0;
		$total_before_discount_by_cardcode = 0;
		$total_discount_by_cardcode = 0;
		//khai báo check vận chuyển Hải Linh
		$ship_HL = 0;
		$price_ship = 0;
		$total_kg = 0;
		$km_ship = '';
		$check_set_kg = 1; // đã nhâp trọng lượng trong admin 1 là ok 0 là chưa
		////

		
		for($i = 0; $i < count ( $product_list ); $i ++) {
			$prd = $product_list[$i];
			$data_product = $this -> getProductById($prd['product_id']);

			if(!$data_product){
				continue;
			}

			$check_sale_off = $this -> check_sale_off($prd ['product_id']);
			// echo $prd ['price'];
			// echo $data_product->price;
			// die;

			if($check_sale_off && $check_sale_off-> total_item == $check_sale_off-> total_item_buy && @$prd ['price'] != @$data_product->price){
				setcookie('cart', null, -1, '/');
				$link = FSRoute::_('index.php?module=products&view=cart&task=shopcart&Itemid=11');
				$msg = 'Không thành công. Giỏ hàng của bạn có sản phẩm khuyến mãi đã bán hết, vui lòng thao tác mua lại !';
				setRedirect($link,$msg);
			}

			if($check_sale_off && $check_sale_off-> total_item > $check_sale_off-> total_item_buy && @$prd ['price'] != @$check_sale_off->price){
				setcookie('cart', null, -1, '/');
				$link = FSRoute::_('index.php?module=products&view=cart&task=shopcart&Itemid=11');
				$msg = 'Không thành công. Giỏ hàng của bạn có sản phẩm Flash sale có giá đang bán khác với giá trong giỏ hàng, vui lòng thao tác mua lại !';
				setRedirect($link,$msg);
			}

			

			if($check_sale_off && $check_sale_off-> total_item > $check_sale_off-> total_item_buy && $prd ['quantity'] > ($check_sale_off-> total_item - $check_sale_off-> total_item_buy)){
			
				$link = FSRoute::_('index.php?module=products&view=cart&task=shopcart&Itemid=11');
				$msg = 'Giỏ hàng của bạn có sản phẩm Flash sale có số lượng vượt quá số lượng còn lại, vui lòng nhập lại số lượng !';
				
				setRedirect($link,$msg);
			}



			//Check đơn vị vận chuyển có phải Hải Linh Ko
			$cat_product = $this-> get_record('id = ' . $data_product-> category_id,'fs_products_categories','hai_linh_ship');
			if ($cat_product->hai_linh_ship == 1) {
			    $ship_HL = 1;
			}
			if ($cat_product->hai_linh_ship == 1) {
			    $ship_HL = 1;
			}
			if ($cat_product->hai_linh_ship == 1) {
			    $ship_HL = 1;
			}
	
			
			if(!empty($data_product-> manufactory) && !empty($data_product->category_id) ){
				$cat_kilogam = $this->get_record('category_id = '.$data_product->category_id . ' AND manufactory_id = '. $data_product-> manufactory,'fs_products_categories_kilogam','kilogam');
			}

			if(!empty($cat_kilogam)){
				$total_kg += $prd['quantity'] * $cat_kilogam->kilogam;
			}else{
				$check_set_kg = 0; // chưa nhập trọng lượng
			}

			/////////


			$prd_id_array [] = $prd ['product_id'];

			//tính thêm giá khác
			$total_price_extent =0;
			$arr_info_extent = array();
			$arr_extend_item = array();
			$string_info_extent = '';
			$arr_extend_item = array();
			$arr_extend_item = explode(',',$prd['box_extend_string']);

			if(!empty($prd['box_extend_string'])){
			$arr_extend_item = explode(',',$prd['box_extend_string']);
				foreach ($arr_extend_item as $extend_item_val ){
					if($extend_item_val != 0){
						$extend_item = $this -> get_record_by_id($extend_item_val,'fs_products_price_extend');
						$arr_info_extent[] = $extend_item-> extend_name . ": +" . format_money($extend_item-> price,'₫','0₫');
						$total_price_extent  += $extend_item-> price; 
					}
				}
			}

			$string_info_extent = '';
			if(!empty($arr_info_extent)){
				$string_info_extent =  implode(' ; ',$arr_info_extent);
			}

			//mausac
			$price_color = 0;
			if($prd['color_id'] !=0){
				$data_price_color =  $this -> get_record('id = ' . $prd['color_id'] . ' AND record_id = ' . $prd['product_id'],'fs_products_price');
				if(!empty($data_price_color)){
					$price_color  = (float)$data_price_color-> price; 
					$color_name =  $data_price_color-> color_name;
					$color_id =  $data_price_color-> id;
				}
			}

			//khuvuc
			$price_region = 0;
			if($prd['region_id'] !=0){
				$data_price_region =  $this -> get_record('id = ' . $prd['region_id'] . ' AND record_id = ' . $prd['product_id'],'fs_products_regions_price');
				if(!empty($data_price_region)){
					$price_region  = (float)$data_price_region-> price; 
					$region_name =  $data_price_region-> region_name;
					$region_id =  $data_price_region-> id;
				}
			}

			//baohanh
			$price_warranty = 0;
			if($prd['warranty_id'] !=0){
				$data_price_warranty =  $this -> get_record('id = ' . $prd['warranty_id'] . ' AND record_id = ' . $prd['product_id'],'fs_warranty_price');
				if(!empty($data_price_warranty)){
					$price_warranty  = (float)$data_price_warranty-> price; 
					$warranty_name =  $data_price_warranty-> region_name;
					$warranty_id =  $data_price_warranty-> id;
				}
			}



		

			$total_before_discount +=  ($price_warranty + $price_region + $price_color + $prd['price'] + $total_price_extent) * $prd['quantity'];
			$products_count += $prd ['quantity'];
		}


		//quà tặng theo khoảng giá

		$gift_price_range = $this-> get_record('published = 1 AND price_min <= ' . $total_before_discount . ' AND price_max >= ' . $total_before_discount,'fs_products_gift_price_range');

		if(!empty($gift_price_range)){
			$row ['list_gift_price_range'] = $gift_price_range->products_gift;

			$gift_price_range_str = substr($gift_price_range->products_gift, 1, -1);
			$product_gift_price_range = $this-> get_records('published = 1 AND id IN ('.$gift_price_range_str.')','fs_products_list_gift');
			if(!empty($product_gift_price_range)){
				$list_gift_price_range_name =",";
				foreach ($product_gift_price_range as $product_gift_price_range_it) {
					$list_gift_price_range_name .= $product_gift_price_range_it->name.",";
				}
				$row ['list_gift_price_range_name'] = $list_gift_price_range_name;
			}
		}

		//end quà tặng theo khoảng giá

		//check ship
		$data_ships =  $this->get_records('published = 1','fs_ships');
		// echo $_SESSION['sesstion_km_ship'];
		// die;
		if($ship_HL == 1 AND !empty($data_ships)){
			if(isset($_SESSION['sesstion_km_ship']) && $_SESSION['sesstion_km_ship'] > 30){
				$km_ship = $_SESSION['sesstion_km_ship'] - 30;
			}else{
				$km_ship = '';
			}
			
			
			if($km_ship != '' && $km_ship > 0){
				//Tìm loại xe có trọng lượng cao nhất
				$get_max_kg = $this->get_record('published = 1','fs_ships','MAX(kilogam_max) as max_kg');
				$max_kg = $get_max_kg->max_kg;
				$check_ship_max = $this->get_record('published = 1 AND kilogam_max = '.$max_kg ,'fs_ships');

				if($total_kg > $max_kg){
					// Tìm tổng số xe chạy max kg
					$car_number = floor($total_kg / $max_kg);

					//Số tiền chạy cho các con xe max kg
					if($km_ship > 100){
						$price_ship_car_max = ($check_ship_max->money_type_2  * $km_ship) * $car_number;
					}else{
						$price_ship_car_max = $check_ship_max->money_type_1  * $km_ship * $car_number;
					}

					//Tìm loại xe chạy số còn lại
					$total_kg_still = $total_kg - ($car_number * $max_kg);
					if($total_kg_still > 0){
						$check_ship = $this-> get_record('published = 1 AND kilogam_min < ' . $total_kg_still . ' AND kilogam_max >= ' . $total_kg_still ,'fs_ships');
					}
					

					//Số tiền ship cho xe còn lại
					if(!empty($check_ship)){
						if($km_ship > 100){
							$price_ship_car_still = $check_ship->money_type_2  * $km_ship;
						}else{
							$price_ship_car_still = $check_ship->money_type_1  * $km_ship;
						}
					}

					//Tổng số tiền cho cả 2 loại xe
					$price_ship = $price_ship_car_max + $price_ship_car_still;
				}else{
					//Tìm loại xe
					$check_ship = $this-> get_record('published = 1 AND kilogam_min < ' . $total_kg . ' AND kilogam_max >= ' . $total_kg ,'fs_ships');
					if(!empty($check_ship)){
						if($km_ship > 100){
							$price_ship = $check_ship->money_type_2  * $km_ship;
						}else{
							$price_ship = $check_ship->money_type_1  * $km_ship;
						}
					}
				}
				//giảm 50% phí ship khi thanh toán bằng vnpay
				if(isset($_SESSION['pay_method']) && $_SESSION['pay_method'] == 1){
					$price_ship = round($price_ship / 2);
					$row ['shipping_note'] = 'Giảm 50% phí ship thanh toán bằng VNPay';
				}

				if($config['free_ship_pay_online'] == 1){
					if(isset($_SESSION['pay_method']) && $_SESSION['pay_method'] == 2){
						$price_ship = 0;
						$row ['shipping_note'] = 'Miễn phí vận chuyển khi thanh toán 100% online';
					}
				}
			}
		}


		if($ship_HL == 1 && !isset($_SESSION['sesstion_km_ship'])) {
			$row ['shipping_unit'] = 1;
			$row ['shipping_money'] = 0;
			$row ['km_ship'] = $km_ship;
			$row ['shipping_note'] = 'Chưa tính được số km, liên hệ lại';
			$price_ship = 0;
		} 
		elseif($ship_HL == 1 && $km_ship == 0 && $check_set_kg == 1 ){

			// echo "Miễn phí vận chuyển.(Đơn vị vận chuyển Hải Linh)";
			// echo '<input type="hidden" id="price_ship" value="0">';
			// echo '<input type="hidden" id="check_ship_HL" value="1">';
			$row ['shipping_unit'] = 1;
			$row ['shipping_money'] = 0;
			$row ['km_ship'] = 0;
			$row ['shipping_note'] = 'Miễn phí vận chuyển'; // nhỏ hơn 30km
		}
		elseif($ship_HL == 1 && !empty($check_ship) && $km_ship > 0 && $total_kg <= 0 || $check_set_kg == 0) {
			$row ['shipping_unit'] = 1;
			$row ['shipping_money'] = 0;
			$row ['km_ship'] = $km_ship;
			$row ['shipping_note'] = 'Chưa tính được trọng lượng của sản phẩm, liên hệ lại.';
			$price_ship = 0;
		}
		elseif($ship_HL == 1 && !empty($check_ship) && $km_ship > 0 && $check_set_kg == 1) {
			// echo format_money($price_ship,$current = '₫',$text_if_rezo = '0') . ' (Đơn vị vận chuyển Hải Linh)';
			// $total += $price_ship;
			// echo '<input type="hidden" id="price_ship" value="'.$price_ship.'">';
			// echo '<input type="hidden" id="check_ship_HL" value="1">';
			// echo $config['free_ships'];
			// die;
			if((int)$config['free_ships'] == 1){
				$row ['shipping_unit'] = 1;
				$row ['shipping_money'] = 0;
				$row ['km_ship'] = $km_ship;
				$row ['shipping_note'] = 'Miễn phí vận chuyển';
				$price_ship = 0;

			}else{
				$row ['shipping_unit'] = 1;
				$row ['shipping_money'] = $price_ship;
				$row ['km_ship'] = $km_ship;
				$row ['kilogam'] = $total_kg;
				if(isset($_SESSION['pay_method']) && $_SESSION['pay_method'] == 1){
					$row ['shipping_note'] = 'Thanh toán vnpay được giảm 50% phí ship';
				}
			}
		}
		else{
			// GHTK
			$row ['kilogam'] = $total_kg;
			$row ['shipping_unit'] = 2;
			// $row ['shipping_money'] = 0;
		}
		// printr($row);
		// kêt thúc check ship hải linh



		// triết khấu theo mã giảm giá
		$code_sale = FSInput::get ('code_sale');
		$total_noshipping = 0;
		$total_no_sale = 0;
		$total_down = 0;
		$check_code_suscess = 0;
		if($code_sale) {
			$check_code = $this->get_record( 'published = 1 AND number_sale > 0 AND CURDATE() < date_end AND code = "'.$code_sale.'"', 'fs_sale', '*');
			// printr($check_code);
			if($check_code){
				foreach ($product_list as $prd) {
					$product = $this -> getProductById($prd['product_id']);
					if(!$product){
						continue;
					}
					//Thêm giá khác
					$arr_info_extent = array();
					$arr_extend_item = array();
					$string_info_extent = '';
					$arr_extend_item = array();
					$total_price_extent=0;
					$total_item = 0;
					if(!empty($prd['box_extend_string'])){
						$arr_extend_item = explode(',',$prd['box_extend_string']);
						foreach ($arr_extend_item as $extend_item_val ){
							if($extend_item_val != 0 AND !empty($extend_item_val)){
								$extend_item = $this -> get_record_by_id($extend_item_val,'fs_products_price_extend');
								$arr_info_extent[] = $extend_item-> extend_name . ": +" . format_money($extend_item-> price);
								$total_price_extent  += $extend_item-> price; 
							}
						}
					}

					// Tính thêm giá màu
					$price_color = 0;
					$color_name = "";
					$color_id ="";
					$image_color = '';
					if($prd['color_id'] && $prd['color_id'] !=0){
						$data_price_color =  $this -> get_record('id = ' . $prd['color_id'] . ' AND record_id = ' . $product->id,'fs_products_price');
						if(!empty($data_price_color)){
							$price_color  = (int)$data_price_color-> price;
							$color_name =  "Màu " . $data_price_color-> color_name;
							$color_id =  $data_price_color-> id;
						}
						$data_color = $this-> get_record('id = ' . $prd['color_id'] ,'fs_products_price','color_id');
						if($data_color){
							$image_color =  $this -> get_record('color_id = ' .$data_color->color_id. ' AND record_id = ' . $product->id,'fs_products_images','image');
						}
					}
					
					$total_item = ($price_color + $total_price_extent + $prd['price'] ) * $prd['quantity'];

					$check_sale_off = $this -> check_sale_off($prd['product_id']);
					$check_combo = $this->get_record('is_combo = 1 AND id = '. $prd['product_id'], 'fs_products','id');

					$price_item = $prd['price'] * $prd['quantity'];

					if($check_code-> is_auto == 1){
						$total_noshipping += $total_item;
					}else{
						if($check_sale_off && $check_sale_off->total_item > $check_sale_off->total_item_buy || $check_combo){
							$total_no_sale += $total_item;
						}else{
							$total_noshipping += $total_item;
						}
					}
					
				}

				if($total_noshipping == 0 || $total_noshipping < $check_code-> min_price) {
					// $data ['message'] = 'Mã giảm giá này áp dụng với đơn hàng trên '.format_money($check_code-> min_price, "VNĐ ( Không tính cho sản phẩm flas sale, combo, giờ vàng giá sốc )");
				}elseif($check_code-> is_auto == 1 && $check_code-> user_id != $_COOKIE['user_id']){
					// $data ['message'] = 'Mã giảm giá này chỉ áp dụng với tài khoản được nhận mã giảm giá !. Xin vui lòng đăng nhập đúng tài khoản.';
				}
				else{
					// if($check_code->type_sale==1){
					// 	$data['type_down'] =  1;
					// }else{
					// 	$data['type_down'] =  2;
					// }
					if($check_code->type_sale==1){
						$total_code = $total_noshipping - ($total_noshipping * ($check_code-> money_dow/100));
						$total_down = $total_noshipping * ($check_code-> money_dow/100);
					} else{
						$total_code = $total_noshipping - $check_code-> money_dow;
						$total_down = $check_code-> money_dow;
						if($total_down > $total_noshipping ){
							$total_down = $total_noshipping;
						}
						if($check_code-> money_dow > $total_noshipping){
							$total_code = $total_no_sale;
						}
					}

					// $data['total_code'] = format_money($total_code); //số tiền còn lại
					// $data['total_down'] = format_money($total_down); // số tiền giảm
					// $data ['error'] = false;
					// $data ['message'] = 'Đơn hàng của bạn được giảm ' . format_money($total_down);

					$row['code_sale'] = $code_sale ;
					$row['money_dow'] = $total_down;
					$row['value_sale'] = $check_code->type_sale ; //loại giảim giá
					$check_code_suscess = 1;
				}
			}
		}


		$total_after_discount = $total_before_discount - $total_down + $price_ship;
		// echo $total_after_discount;
		// kết thúc triết khấu theo mã giảm giá

		

		$prd_id_str = implode ( ',', $prd_id_array );
		
		$session_id = session_id ();
		
		$sender_name = FSInput::get ( 'sender_name' );
		
		$user_point = FSInput::get ( 'user_point' );

		$sender_sex = FSInput::get ( 'sender_sex' );
		$sender_address = FSInput::get ( 'sender_address' );

		//			$sender_email  = FSInput::get('sender_email');
		$sender_telephone = FSInput::get ( 'sender_telephone' );
		$sender_comments = FSInput::get ( 'sender_comments' );
		$recipients_name = FSInput::get ( 'recipients_name' );
		$recipients_sex = FSInput::get ( 'recipients_sex' );
		$recipients_address = FSInput::get ( 'recipients_address' );
		$recipients_email = FSInput::get ( 'recipients_email' );
		$recipients_telephone = FSInput::get ( 'recipients_telephone' );
		$recipients_mobile = FSInput::get ( 'recipients_mobile' );
		$recipients_comments = FSInput::get ( 'recipients_comments' );
		$recipients_here = FSInput::get ( 'recipients_here' );
		$payment_method = FSInput::get ( 'payment_method' );
		$name_payment_method= FSInput::get ( 'name_payment_method' );
		$no_people = FSInput::get ( 'no_people' );
		$time = date ( "Y-m-d H:i:s" );
		//			if(!$sender_name || !$sender_email  || !$recipients_name || ! $recipients_address || !$recipients_email || !$recipients_telephone)
		//				return false;
		if (! $sender_name)
			return false;
		
		$received_hour = FSInput::get ( 'received_hour', 0 );
		$received_hour = $received_hour ? $received_hour : 0;
		$received_day = FSInput::get ( "received_day" );
		$received_month = FSInput::get ( "received_month" );
		$received_year = FSInput::get ( "received_year" );
		$received_time = date ( "Y-m-d H:i:s", mktime ( $received_hour, 0, 0, $received_month, $received_day, $received_year ) );
		
		//			discount_id = '$discount_id',
		//							discount_value = '$discount_value',
		//							discount_unit = '$discount_unit',
		//							discount_money = '$discount_money',
		//							discount_code = '$discount_code',
		

		$fsstring = FSFactory::getClass ( 'FSString' );
		$random_string = $fsstring->generateRandomString ( 8 );
		$code_order = $random_string;


		$row['name_payment_method'] = $name_payment_method;
		
		$row ['username'] = isset ( $user->username ) ? $user->username : '';
		$row ['user_id'] = isset ( $user->id ) ? $user->id : '';
		$row['user_point'] = $user_point;
		
		$row ['products_id'] = $prd_id_str;
		if($task == 'shopcart_save'){
			$row ['is_temporary'] = 0;
		}else{
			$row ['is_temporary'] = 1;
		}
		
		$row ['session_id'] = $session_id;
		$row ['total_before_discount'] = $total_before_discount;


		$row ['total_after_discount'] = $total_after_discount;
		$row ['products_count'] = $products_count;
		$row ['sender_sex'] = $sender_sex;
		$row ['sender_name'] = FSInput::get ( 'sender_name' );
		$row ['sender_telephone'] = FSInput::get ( 'sender_telephone' );
		$row ['sender_email'] = FSInput::get ( 'sender_email' );
		$row ['sender_address'] = FSInput::get ( 'sender_address' );
		$row ['sender_comments'] = FSInput::get ( 'sender_comments' );

		$row ['is_tax'] = FSInput::get ('is_tax');
		$row ['tax_company'] = FSInput::get ('tax_company');
		$row ['tax_address'] = FSInput::get ('tax_address');
		$row ['tax_code'] = FSInput::get ('tax_code');
		$row ['tax_email'] = FSInput::get ('tax_email');

		

		$row ['created_time'] = date ( "Y-m-d H:i:s" );
		$row ['edited_time'] = date ( "Y-m-d H:i:s" );
		$row ['total_discount_by_cardcode'] = $total_discount_by_cardcode;
		$row ['card_code'] = @$card_code;
		$row ['is_vnpay'] =  FSInput::get('is_vnpay',0,'int');

		if($ship_HL == 1){
			$sender_address_googlemap = FSInput::get ( 'sender_address_googlemap' );
			if($sender_address_googlemap){
				$row ['sender_address_googlemap'] = $sender_address_googlemap;
			}
		}
		

		$city_id = FSInput::get ( 'city_id' );
		if($city_id){
			$city = $this-> get_record('id = '.$city_id,'fs_cities','*');
			if(!empty($city)){
				$row['city_id'] = $city_id;
				$row['city_name'] = $city-> name;
				// $row['price_ship'] = $city-> price_ship;
			}
		}

		$district_id = FSInput::get ( 'district_id' );
		if($district_id){
			$district = $this-> get_record('id = '.$district_id,'fs_districts','*');
			if(!empty($city)){
				$row['district_id'] = $district_id;
				$row['district_name'] = $district-> name;
			}
		}

		$ward_id = FSInput::get ( 'ward_id' );
		if($ward_id){
			$ward = $this-> get_record('id = '.$ward_id,'fs_wards','*');
			if(!empty($ward)){
				$row['ward_id'] = $ward_id;
				$row['ward_name'] = $ward-> name;
			}
		}

		// printr($row);
		

		if(@$_COOKIE['affiliate_id']) {
			$row ['affiliate_id'] = $_COOKIE['affiliate_id'];
		}

		$lang = isset($_SESSION['lang'])?$_SESSION['lang']:'vi';
		// $row ['language'] = $lang;
		// printr($row);

		if(isset($order_current -> id) && $order_current -> id) {
			$id = $this->_update ( $row, 'fs_order' ,' id = '.$order_current -> id);
			$id = $order_current -> id;
		}else{
			$id = $this->_add ( $row, 'fs_order' );
		}
		
		// if($task == 'shopcart_save'){
		// 	$this->save_order_items ( $id );
		// }		

		
		// if ($discount_code && ! $discount_successfult) {
		// 	FSFactory::include_class ( 'errors' );
		// 	Errors::setError ( "Mã giảm giá không phù hợp" );
		// 	return false;
		// }
		if ($id) {
			$this->save_order_items ( $id );
			if($task == 'shopcart_save' && $row ['is_vnpay'] != 1 ){
				setcookie('cart', null, -1, '/'); 
				// unset ( $_SESSION ['cart'] );
			}
			if($check_code_suscess == 1){
				$minus_number_card = $check_code ->number_sale -  1;
				$row_card = array();
				$row_card['number_sale'] = $minus_number_card;
				$this->_update($row_card,'fs_sale','id = '.$check_code ->id);
			}			
		}
		return $id;
	}
	// function shopcart_save() {

	// 	// echo '222';die;
	// 	// $user_id = isset($_COOKIE['user_id'])?$_COOKIE['user_id'] : '';
	// 	$task = FSInput::get('task');

	// 	$user = $this->get_user ();

	
	// 		$user_id = $user-> id;
		
		
	// 	if (! isset ( $_COOKIE ['cart'] ))
	// 		return false;
		
	// 	$sender_email = FSInput::get ( 'sender_email' );
	// 	// if (! $sender_email)
	// 	// 	return;

	// 	$order_current = $this -> getOrder();

	// 	// UPDATE LẠI CHIẾT KHẤU THEO CARD_CODE

	// 	// Giảm giá theo mã thẻ
	// 	$chiet_khau = 0;
	// 	if(isset($user)){
	// 		$card_code = $user -> 	card_code;
	// 		// $chiet_khau = $user -> 	chiet_khau;
	// 	}else{
	// 	//	$card_code = FSInput::get ( 'card_code' );
	// 	//	$user = $this -> 	get_user_from_cardcode($card_code);
			
	// 	}

	// 	if(isset($user)){
	// 		$date = date('Y-m-d');
	// 		if(@$user -> card_started_time <= $date && @$user -> card_end_time >= $date){
	// 			$chiet_khau = $user -> 	chiet_khau;
	// 			$card_code = $user -> card_code;
	// 		}
	// 	}



	// 	if($chiet_khau < 0 || $chiet_khau > 100)
	// 		$chiet_khau = 0;

		
	// 	$discount_code = FSInput::get ( 'discount_code' );

	// 	$discount_successfult = 0;
		
	// 	// $product_list = $_SESSION ['cart'];
	// 	$product_list = json_decode($_COOKIE['cart'],true);

	// 	$prd_id_array = array ();
		
	// 	$total_before_discount = 0;
	// 	$total_after_discount = 0;
	// 	$products_count = 0;
		

	// 	$total_before_discount_by_cardcode = 0;
	// 	$total_discount_by_cardcode = 0;

	// 	// print_r($product_list);
	// 	// die;

	// 	// 	Repeat products	
	// 	for($i = 0; $i < count ( $product_list ); $i ++) {
	// 		$prd = $product_list [$i];
	// 		$prd_id_array [] = $prd ['product_id'];
			
	// 		// cal
	// 		$total_before_discount += $prd ['price'] * $prd ['quantity'];
	// 		$products_count += $prd ['quantity'];

	// 		// loại sản phẩm được giảm giá tiếp cho thành viên
	// 		if(isset($prd['is_total_shopcart'])){
	// 			$total_before_discount_by_cardcode += 	$prd ['price'] * $prd ['quantity'];
	// 		}
	// 	}

	// 	// số tiền chiết khấu cho thành viên ( check qua mã thẻ)
	// 	$total_discount_by_cardcode = $total_before_discount_by_cardcode * $chiet_khau / 100;

	// 	// triết khấu theo mã giảm giá

	// 	$row = array ();

	// 	$money_dow = FSInput::get ( 'price_send_h',0,'int' );
	// 	$code_sale = FSInput::get ( 'code_card_send_h', '' , 'txt' );
	// 	$value_sale = FSInput::get ( 'type_down_h', 0,'int' ); 

	// 	if($money_dow && $code_sale && $value_sale) {
	// 		$row['code_sale'] = $code_sale ;
	// 		$row['money_dow'] = $money_dow ;
	// 		$row['value_sale'] = $value_sale ;

	// 		if($value_sale == 1) {
	// 			$price_down = $money_dow*$total_before_discount/100;
	// 		} else {
	// 			$price_down = $money_dow;
	// 		}
			
	// 	}



	// 	/////////////
	// 	// default:
	// 	$total_after_discount = $total_before_discount - $total_discount_by_cardcode - @$price_down;
	// 	$discount_unit = '';
	// 	$discount_value = '';
	// 	$discount_id = '';
	// 	$discount_money = '';
		
	// 	// LÀM SAU
	// 	if ($discount_code) {
	// 		$discount_for_guest = $this->get_discount_4_guest ( $sender_email, $discount_code );
			
	// 		if ($discount_for_guest) {
	// 			$discount_unit = $discount_for_guest->unit;
	// 			$discount_value = $discount_for_guest->discount;
	// 			$discount_code = $discount_for_guest->code;
	// 			$discount_id = $discount_for_guest->discount_id;
	// 			if ($discount_unit == 1) { // tiền mặt
	// 				if ($discount_value < $total_before_discount) {
	// 					$discount_money = $discount_value;
	// 					$total_after_discount = $total_before_discount - $discount_money;
	// 					$discount_successfult = 1;
	// 				}
	// 			} else { // phần trăm
	// 				if ($discount_value < 100 && $discount_value > 0) {
	// 					$discount_money = $total_before_discount * $discount_value / 100;
	// 					$total_after_discount = $total_before_discount - $discount_money;
	// 					$discount_successfult = 1;
	// 				}
	// 			}
	// 		}
			
	// 	//				$discount = $total_before_discount * $discount_for_guest / 100;
	// 	//				$total_after_discount = $total_before_discount - $discount;
	// 	//				if($total_after_discount < 0){
	// 	//				 	$total_after_discount = $total_before_discount;
	// 	//				}
	// 	}
		
	// 	/////////////
		

	// 	//			$discount = $total_before_discount * $discount_for_guest / 100;
	// 	//			 $total_after_discount = $total_before_discount - $discount;
	// 	//			 if($total_after_discount < 0){
	// 	//			 	$total_after_discount = $total_before_discount;
	// 	//			 }
	// 	$prd_id_str = implode ( ',', $prd_id_array );
		
	// 	$session_id = session_id ();
		
	// 	$sender_name = FSInput::get ( 'sender_name' );
		
	// 	$user_point = FSInput::get ( 'user_point' );

	// 	$sender_sex = FSInput::get ( 'sender_sex' );
	// 	$sender_address = FSInput::get ( 'sender_address' );
	// 	//			$sender_email  = FSInput::get('sender_email');
	// 	$sender_telephone = FSInput::get ( 'sender_telephone' );
	// 	$sender_comments = FSInput::get ( 'sender_comments' );
	// 	$recipients_name = FSInput::get ( 'recipients_name' );
	// 	$recipients_sex = FSInput::get ( 'recipients_sex' );
	// 	$recipients_address = FSInput::get ( 'recipients_address' );
	// 	$recipients_email = FSInput::get ( 'recipients_email' );
	// 	$recipients_telephone = FSInput::get ( 'recipients_telephone' );
	// 	$recipients_mobile = FSInput::get ( 'recipients_mobile' );
	// 	$recipients_comments = FSInput::get ( 'recipients_comments' );
	// 	$recipients_here = FSInput::get ( 'recipients_here' );
	// 	$payment_method = FSInput::get ( 'payment_method' );
	// 	$name_payment_method= FSInput::get ( 'name_payment_method' );
	// 	$no_people = FSInput::get ( 'no_people' );
	// 	$time = date ( "Y-m-d H:i:s" );
	// 	//			if(!$sender_name || !$sender_email  || !$recipients_name || ! $recipients_address || !$recipients_email || !$recipients_telephone)
	// 	//				return false;
	// 	if (! $sender_name)
	// 		return false;
		
	// 	$received_hour = FSInput::get ( 'received_hour', 0 );
	// 	$received_hour = $received_hour ? $received_hour : 0;
	// 	$received_day = FSInput::get ( "received_day" );
	// 	$received_month = FSInput::get ( "received_month" );
	// 	$received_year = FSInput::get ( "received_year" );
	// 	$received_time = date ( "Y-m-d H:i:s", mktime ( $received_hour, 0, 0, $received_month, $received_day, $received_year ) );
		
	// 	//			discount_id = '$discount_id',
	// 	//							discount_value = '$discount_value',
	// 	//							discount_unit = '$discount_unit',
	// 	//							discount_money = '$discount_money',
	// 	//							discount_code = '$discount_code',
		

	// 	$fsstring = FSFactory::getClass ( 'FSString' );
	// 	$random_string = $fsstring->generateRandomString ( 8 );
	// 	$code_order = $random_string;


	// 	$row['name_payment_method'] = $name_payment_method;
		
	// 	$row ['username'] = isset ( $user->username ) ? $user->username : '';
	// 	$row ['user_id'] = isset ( $user->id ) ? $user->id : '';
	// 	$row['user_point'] = $user_point;
		
	// 	$row ['products_id'] = $prd_id_str;
	// 	if($task == 'shopcart_save'){
	// 		$row ['is_temporary'] = 0;
	// 	}else{
	// 		$row ['is_temporary'] = 1;
	// 	}
		
	// 	$row ['session_id'] = $session_id;
	// 	$row ['total_before_discount'] = $total_before_discount;


	// 	$row ['total_after_discount'] = $total_after_discount;
	// 	$row ['products_count'] = $products_count;
		
	// 	$row ['sender_name'] = FSInput::get ( 'sender_name' );
	// 	$row ['sender_telephone'] = FSInput::get ( 'sender_telephone' );
	// 	$row ['sender_email'] = FSInput::get ( 'sender_email' );
	// 	$row ['sender_address'] = FSInput::get ( 'sender_address' );
	// 	$row ['sender_comments'] = FSInput::get ( 'sender_comments' );
	// 	$row ['created_time'] = date ( "Y-m-d H:i:s" );
	// 	$row ['edited_time'] = date ( "Y-m-d H:i:s" );
	// 	$row ['total_discount_by_cardcode'] = $total_discount_by_cardcode;
	// 	$row ['card_code'] = @$card_code;


	// 	$city_id = FSInput::get ( 'city_id' );

	// 	$city = $this-> get_record('id = '.$city_id,'fs_cities','*');

	// 	$row['city_id'] = $city_id;
	// 	$row['city_name'] = $city-> name;
	// 	$row['price_ship'] = $city-> price_ship;

	// 	if(@$_COOKIE['affiliate_id']) {
	// 		$row ['affiliate_id'] = $_COOKIE['affiliate_id'];
	// 	}

	// 	$lang = isset($_SESSION['lang'])?$_SESSION['lang']:'vi';
	// 	// $row ['language'] = $lang;

	// 	if(isset($order_current -> id) && $order_current -> id) {
	// 		$id = $this->_update ( $row, 'fs_order' ,' id = '.$order_current -> id);
	// 		$id = $order_current -> id;
	// 	}else{
	// 		$id = $this->_add ( $row, 'fs_order' );
	// 	}
		
	// 	if($task == 'shopcart_save'){
	// 		$this->save_order_items ( $id );
	// 	}		

		
	// 	if ($discount_code && ! $discount_successfult) {
	// 		FSFactory::include_class ( 'errors' );
	// 		Errors::setError ( "Mã giảm giá không phù hợp" );
	// 		return false;
	// 	}
	// 	if ($id) {
			
	// 		if($task == 'shopcart_save'){
	// 			setcookie('cart', null, -1, '/'); 
	// 			// unset ( $_SESSION ['cart'] );
	// 		}			
	// 	}
	// 	return $id;
	// }


	function get_user_from_cardcode($card_code){
		if(!$card_code){
			return;
		}
		$date = date('Y-m-d');
		return  $this -> get_record(' card_code = "'.$card_code.'" AND published = 1 ','fs_members');

		
	}

	function get_user(){
		$user_id = @$_COOKIE['user_id'];
		if($user_id) return  $this -> get_record(' id = "'.$user_id.'" AND published = 1 ','fs_members');
		else return false;
	}

	// function get_user(){
	// 	// $user_id = @$_COOKIE['user_id'];
	// 	return  $this -> get_record(' id = "'.$user_id.'" AND published = 1 ','fs_members');
	// }

	
	/*
		 * Save data into fs_order_items
		 */
	function save_order_items($order_id) {
		if (! $order_id)
			return false;
		
		global $db;
		
		// remove before update or inser
		$sql = " DELETE FROM fs_order_items
		WHERE order_id = '$order_id'";
		
		$db->query ( $sql );
		$rows = $db->affected_rows ();
		$prd_id_array = array ();
		if (! isset ( $_COOKIE ['cart'] ))
			return false;
		
		$product_list = json_decode($_COOKIE['cart'],true);

		$array_insert = array ();
		$c = 0;
		$total_kg = 0;
		$total_price_extent = 0;
		for($i = 0; $i < count ( $product_list ); $i ++) {
			$row = array ();
			$arr_info_extent = array();
			$prd = $product_list[$i];
			$product = $this -> getProductById($prd['product_id']);

			$products_list_gift = $this->get_products_list_gift($product);

			if(!empty($product-> manufactory) && !empty($product->category_id) ){
				$cat_kilogam = $this->get_record('category_id = '.$product->category_id . ' AND manufactory_id = '. $product-> manufactory,'fs_products_categories_kilogam','kilogam');
			}

			$total_kg += $prd['quantity'] * $cat_kilogam->kilogam;
			$str_list_gift_id = '';
			$str_list_gift_name = '';
			if(!empty($products_list_gift)){
				foreach ($products_list_gift as $gift_item){
					$str_list_gift_id .= $gift_item->id .',';
					$str_list_gift_name .= $gift_item->name .',';
				}
			}

			$row['list_gift_id'] = $str_list_gift_id;
			$row['list_gift_name'] = $str_list_gift_name;

		
			if(@$prd['parent_product'] && @$prd['parent_product'] != $prd['product_id']) {
				$row['note'] = 'Mua kèm ('.@$prd['parent_product'].')';
			}
			if(@$prd['is_combo'] == 1 && @$prd['id_combo']) {
				$combo = $this-> get_record('id='.$prd['id_combo'],'fs_sales','*');
				$row['note'] = 'Combo ('.$combo-> name.')';
			}
			
			$row['no_services'] = @$prd['no_services'];
			$row['services'] = @$prd['services'];

			$arr_extend_item = explode(',',$prd['box_extend_string']);

			

			foreach ($arr_extend_item as $extend_item_val ){
				if($extend_item_val != 0){
					$extend_item = $this -> get_record_by_id($extend_item_val,'fs_products_price_extend');
			
					$arr_info_extent[] = $extend_item-> extend_name . ": " . format_money($extend_item-> price,'₫','0₫');
					$total_price_extent  += $extend_item-> price; 
				}
			}

			$string_info_extent = '';
			if(!empty($arr_info_extent)){
				$string_info_extent =  implode(' ; ',$arr_info_extent);
			}
			$row ['string_info_extent']= $string_info_extent;
			

			//mausac
			$price_color = 0;
			$color_name = "";
			$color_id ="";
			if($prd['color_id'] !=0){
				$data_price_color =  $this -> get_record('id = ' . $prd['color_id'] . ' AND record_id = ' . $prd['product_id'],'fs_products_price');
				if(!empty($data_price_color)){
					$price_color  = (int)$data_price_color-> price;
					$color_name =  $data_price_color-> color_name;
					$color_id =  $data_price_color-> id;
					$row ['color_id']= $color_id;
					$row ['color_name']= $color_name;
					$row ['color_price']= $price_color;
				}
			}

			//khu vuc
			$price_region = 0;
			$region_name = "";
			$region_id ="";
			if($prd['region_id'] !=0){
				$data_price_region =  $this -> get_record('id = ' . $prd['region_id'] . ' AND record_id = ' . $prd['product_id'],'fs_products_regions_price');
				if(!empty($data_price_region)){
					$price_region  = (float)$data_price_region-> price;
					$region_name =  $data_price_region-> color_name;
					$region_id =  $data_price_region-> id;
					$row ['region_id']= $region_id;
					$row ['region_name']= $region_name;
					$row ['region_price']= $price_region;
				}
			}



			//khu vuc
			$price_warranty = 0;
			$warranty_name = "";
			$warranty_id ="";
			if($prd['warranty_id'] !=0){
				$data_price_warranty =  $this -> get_record('id = ' . $prd['warranty_id'] . ' AND record_id = ' . $prd['product_id'],'fs_warranty_price');
				if(!empty($data_price_warranty)){
					$price_warranty  = (float)$data_price_warranty-> price;
					$warranty_name =  $data_price_warranty-> color_name;
					$warranty_id =  $data_price_warranty-> id;
					$row ['warranty_id']= $warranty_id;
					$row ['warranty_name']= $warranty_name;
					$row ['warranty_price']= $price_warranty;
				}
			}




	
			$total_item = ($price_color + $prd['price'] + $total_price_extent) * $prd['quantity'];
			$row ['weight'] = $prd['quantity'] * $cat_kilogam->kilogam;
			$row ['total'] = $total_item;
			$row ['order_id'] = $order_id;
			$row ['product_id'] = $prd ['product_id'];
			$row ['parent_product'] = @$prd ['parent_product'];
			$row ['price'] = $prd ['price'];
			$row ['price_old'] = $prd ['price_old'];
			$row ['count'] = $prd ['quantity'];
			$row ['unit'] = @$prd ['unit'];
			$row ['type'] = @$prd ['type'];
			$row ['is_gift'] = isset ( $prd ['is_gift'] ) ? $prd ['is_gift'] : 0;
			$row ['gift_4_product'] = isset ( $prd ['gift_4_product'] ) ? $prd ['gift_4_product'] : '';
			$lang = isset($_SESSION['lang'])?$_SESSION['lang']:'vi';
			// $row ['language'] = $lang;
			// printr($row);


			$rs = $this->_add ( $row, 'fs_order_items' );
			if ($rs){
				$check_sale_off = $this -> check_sale_off($prd ['product_id']);
				if($check_sale_off && $check_sale_off-> total_item > $check_sale_off-> total_item_buy){
					$row_ud_it_buy = array();
					$row_ud_it_buy['total_item_buy'] = (int)$check_sale_off-> total_item_buy + 1;
					$this->_update($row_ud_it_buy,'fs_sales_products','id = ' . $check_sale_off->id);
				}
				$c ++;
			}

				
		}
		return $c;
	}
	
	function getOrderById($id = 0) {
		if (! $id)
			$id = FSInput::get ( 'id', 0, 'int' );
		if (! $id)
			return;
		$query = " SELECT *
		FROM fs_order
		WHERE  id = $id
		";
		global $db;
		$db->query ( $query );
		return $rs = $db->getObject ();
	}

	function getOrderByIdVnpay($id) {
		if (! $id)
			return;
		$query = " SELECT *
		FROM fs_order
		WHERE  id = '$id' 
		";
		global $db;
		$db->query ( $query );
		return $rs = $db->getObject ();
	}
	
	function get_orderdetail_by_orderId($order_id) {
		if (! $order_id)
			return;
		$session_id = session_id ();
		$query = " SELECT a.*
		FROM fs_order_items AS a
		WHERE  a.order_id = $order_id ";
		global $db;
		$db->query ( $query );
		return $rs = $db->getObjectList ();
	}
	
	function get_products_from_orderdetail($str_product_ids) {
		if (! $str_product_ids)
			return false;
		$query = " SELECT a.*
		FROM fs_products AS a
		WHERE id IN ($str_product_ids) ";
		global $db;
		$db->query ( $query );
		$products = $db->getObjectListByKey ( 'id' );
		return $products;
	}
	
	function get_sales_total() {
		return $this -> get_records('published = 1 AND started_time <= NOW() AND finished_time >= NOW() AND type > 6 ','fs_sales','*',' price_min DESC, ordering DESC, type ASC');
	}

	function get_sale($sale_id) {
		return $this -> get_record(' id = '.$sale_id.' AND published = 1 AND started_time <= NOW() AND finished_time >= NOW()  ','fs_sales','*');
	}

	// function get_sale_totalhasgift() {
	// 	return $this -> get_record(' type = 7 AND published = 1 AND started_time <= NOW() AND finished_time >= NOW()  ','fs_sales','*');
	// }
	
	/* Lấy quà cho đơn hàng */
	function get_gifts_in_sale($sale_id) {
		if (! $sale_id)
			return;
		$query = ' SELECT b.id, b.unit,a.price,a.price_old, c.id as product_id,c.name,c.alias,c.category_id,c.category_alias,c.image, b.id as price_id
		FROM fs_sales_products AS a
		LEFT JOIN fs_products_prices AS b ON a.price_id = b.id
		LEFT JOIN fs_products AS c ON  a.product_id = c.id 
		WHERE a.sale_id = '.$sale_id.' 
		ORDER BY a.id ASC
		';
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList();
		return $result;
	}
	

	/*
		 * Gửi mail cho khách ngay sau khi đặt hàng
		 */
			/*
		 * Gửi mail cho khách ngay sau khi đặt hàng
		 */
	function mail_to_buyer($id){
		//	echo $id;
			//die();
				if(!$id)
					return;
				global $db;
			//config
				global $config;
				$site_name = isset($config['site_name'])?$config['site_name']:'';
			// get order
				$query = " SELECT * 
				FROM ".$this -> table_order."
				WHERE  id = '$id' 
				AND is_temporary = 0 ";	
				$db -> query($query);
				$order = $db->getObject();

		//	print_r($order);
		//	die();
//			$estore = $this -> getEstore($order -> estore_id);
				$data = $this -> get_orderdetail_by_orderId($id);
				if(count($data)){
					$i = 0;
					$str_prd_ids = '';
					foreach($data as $item){
						if($i > 0)
							$str_prd_ids .= ',';
						$str_prd_ids .= $item -> product_id;
						$i ++;
					}
					$arr_product = $this -> get_products_from_orderdetail($str_prd_ids);
					
				}

				if(!$order)
					return;

				// send Mail()
				$mailer = FSFactory::getClass('Email','mail');
				$global = new FsGlobal();
				$admin_name = $global -> getConfig('admin_name');
				$admin_email = $global -> getConfig('admin_email');
				$admin_email_arr =explode(",", $admin_email);
				$mail_order_body = $global -> getConfig('mail_order_body');
				$mail_order_subject = $global -> getConfig('mail_order_subject');
				$mail_order_subject = $mail_order_subject.' '.str_pad($order -> id, 8 , "0", STR_PAD_LEFT);
				$mailer -> setSender(array($admin_email,$site_name));
				foreach ($admin_email_arr as $item) {
					$mailer -> AddAddress($item,$admin_name);
					$mailer -> isHTML(true);
					$mailer -> setSubject($mail_order_subject); 
				}

			if(!empty($order->sender_email) && !empty($order->sender_name)){
				$mailer -> AddAddress($order->sender_email,$order->sender_name);	
			}
			



				$buyer_name = $order-> sender_name?$order-> sender_name:'Quý khách';

				// body
				$body = $mail_order_body;
				$body = str_replace('{name}', $buyer_name, $body);
				$body = str_replace('{ma_don_hang}', 'DH'.str_pad($order -> id, 8 , "0", STR_PAD_LEFT), $body);

				// SENDER
				$sender_info = '<table cellspacing="0" cellpadding="6" border="0" width="100%" class="tabl-info-customer">';
				$sender_info .= '	<tbody>'; 
				$sender_info .= ' <tr>';
				$sender_info .= '<td width="173px">Tên người đặt hàng </td>';
				$sender_info .= '<td width="5px">:</td>';
				$sender_info .= '<td>'.$buyer_name.'</td>';
				$sender_info .= '</tr>';
				$sender_info .= '<tr>';
				$sender_info .= '<td>Địa chỉ  </td>';
				$sender_info .= '<td width="5px">:</td>';
				$sender_info .= '<td>'.$order-> sender_address.', '. $order-> ward_name.', '.$order-> district_name.', '.$order-> city_name.'</td>';
				$sender_info .= '</tr>';
				$sender_info .= '<tr>';
				$sender_info .= '<td>Email </td>';
				$sender_info .= '<td width="5px">:</td>';
				$sender_info .= '<td>'.$order-> sender_email.'</td>';
				$sender_info .= '</tr>';
				$sender_info .= '<tr>';
				$sender_info .= '<td>Điện thoại </td>';
				$sender_info .= '<td width="5px">:</td>';
				$sender_info .= '<td>'. $order-> sender_telephone;
				$sender_info .= '<strong style="color:red"> (Gọi lại ngay)</strong>';
				$sender_info .= '</td>';
				$sender_info .= '</tr>';


//				$sender_info .= 			'</td>';

				if($order ->is_instalment ){ 
					$sender_info .= '<h3>Mua trả góp: </h3>';
					$sender_info .= '<tr>';
					$sender_info .= '<td>Trả trước: </td>';
					$sender_info .= '<td width="5px">:</td>';
					$sender_info .= '<td>'. $order -> instalment_percent_before.'%';
					$sender_info .= '</td>';
					$sender_info .= '</tr>';

					$sender_info .= '<tr>';
					$sender_info .= '<td>Thời gian vay: </td>';
					$sender_info .= '<td width="5px">:</td>';
					$sender_info .= '<td>'. $order -> instalment_months.' tháng';
					$sender_info .= '</td>';
					$sender_info .= '</tr>';

					$arr_certificates = array(1=>'CMND + Hộ Khẩu',2=>'CMND + Bằng lái xe',3=>'Giấy tờ chứng minh thu nhập',4=>'Sinh viên',5=>'Công chức - Giáo viên');

					$sender_info .= '<tr>';
					$sender_info .= '<td>Xác thực: </td>';
					$sender_info .= '<td width="5px">:</td>';
					$sender_info .= '<td>'. @$arr_certificates[$order -> instalment_certificate];
					$sender_info .= '</td>';
					$sender_info .= '</tr>';

					$sender_info .= '<tr>';
					$sender_info .= '<td>Trả trước: </td>';
					$sender_info .= '<td width="5px">:</td>';
					$sender_info .= '<td><strong>'. format_money($order -> instalment_money_before,'','0').'</strong>';
					$sender_info .= '</td>';
					$sender_info .= '</tr>';

					$sender_info .= '<tr>';
					$sender_info .= '<td>Trả hàng tháng: </td>';
					$sender_info .= '<td width="5px">:</td>';
					$sender_info .= '<td>'.format_money($order -> instalment_money_per_month,'','0').'/tháng';
					$sender_info .= '</td>';
					$sender_info .= '</tr>';


					$sender_info .= '<tr>';
					$sender_info .= '<td>Tổng phải trả: </td>';
					$sender_info .= '<td width="5px">:</td>';
					$sender_info .= '<td><strong>'.format_money($order -> instalment_money_total,'','0').'</strong>';
					$sender_info .= '</td>';
					$sender_info .= '</tr>';
				}


				$sender_info .= ' </tbody>';
				$sender_info .= '</table>';
//				$sender_info .= 			'</td>';
				// end SENDER

				// RECIPIENT
				$recipient_info = '<table cellspacing="0" cellpadding="6" border="0" width="100%" class="tabl-info-customer">';
				$recipient_info .= '	<tbody> ';
				$recipient_info .= '<tr>';
				$recipient_info .= '<td width="173px">Tên người nhận hàng</td>';
				$recipient_info .= '<td width="5px">:</td>';
				$recipient_info .= '<td>'.$order-> recipients_name.'</td>';
				$recipient_info .= '</tr>';
				$recipient_info .= '<tr>';
				$recipient_info .= '<td>Giới tính </td>';
				$recipient_info .= '<td width="5px">:</td>';
				$recipient_info .= '<td>';
				if(trim($order->recipients_sex) == 'female')
					$recipient_info .= "N&#7919;";
				else 
					$recipient_info .= "Nam";
				$recipient_info .= 	'</td>';
				$recipient_info .= ' </tr>';
				$recipient_info .= ' <tr>';
				$recipient_info .= '<td>Địa chỉ  </td>';
				$recipient_info .= '<td width="5px">:</td>';
				$recipient_info .= '<td>'.$order-> recipients_address .'</td>';
				$recipient_info .= '</tr>';
				$recipient_info .= ' <tr>';
				$recipient_info .= '<td>Email </td>';
				$recipient_info .= '<td width="5px">:</td>';
				$recipient_info .= '<td>'.$order-> recipients_email .'</td>';
				$recipient_info .= '</tr>';
				$recipient_info .= '<tr>';
				$recipient_info .= '<td>Điện thoại </td>';
				$recipient_info .= '<td width="5px">:</td>';
				$recipient_info .= '<td>'.$order-> recipients_telephone .'</td>';
				$recipient_info .= '</tr>';
				$recipient_info .= '<tr>';

				$recipient_info .= '<td>Thời gian đặt hàng</td>';
				$recipient_info .= '<td width="5px">:</td>';
				$recipient_info .= '<td>';
				$hour = date('H',strtotime($order-> received_time));
				if($hour)
					$recipient_info .= $hour." h, ";
				$recipient_info .=  "ng&#224;y ". date('d/m/Y',strtotime($order-> received_time));
				$recipient_info .= '</td>';
				$recipient_info .= '</tr>';

				$recipient_info .= '<td>Địa điểm nhân hàng </b></td>';
				$recipient_info .= '<td width="5px">:</td>';
				$recipient_info .= '<td>';
				$recipient_info .=  $order->recipients_here ? 'Đặt lấy tại nhà hàng':'Nhận tại địa chỉ người nhận';
				$recipient_info .= '</td>';
				$recipient_info .= '</tr>';

				$recipient_info .= '</tbody>';
				$recipient_info .= '</table>';
				// end RECIPIENT



				$order_detail = '	<table width="964" cellspacing="0" cellpadding="6" bordercolor="#CCC" border="1" align="center" style="border-style:solid;border-collapse:collapse;margin-top:2px">';
				$order_detail .= '		<thead style=" background: #E7E7E7;line-height: 12px;">';
				$order_detail .= '			<tr>';
				$order_detail .= '				<th width="30">STT</th>';
				$order_detail .= '				<th>T&#234;n s&#7843;n ph&#7849;m</th>';
				$order_detail .= '				<th width="117" >Giá</th>';
				$order_detail .= '				<th width="117">S&#7889; l&#432;&#7907;ng</th>';
				$order_detail .= '				<th width="117">T&#7893;ng gi&#225; ti&#7873;n</th>';
				$order_detail .= '			</tr>';
				$order_detail .= '		</thead>';
				$order_detail .= '		<tbody>';

//				$total_money = 0;
				$total_discount = 0;
				for($i = 0 ; $i < count($data); $i ++ ){
					$item = $data[$i];
					$link_view_product = FSRoute::_('index.php?module=products&view=product&code='.@$arr_product[$item->product_id] -> alias.'&id='.$item->product_id.'&ccode='.@$arr_product[$item->product_id] ->category_alias.'&cid='.@$arr_product[$item->product_id] ->category_id.'&Itemid=5');

					$order_detail .= '				<tr>';
					$order_detail .= '					<td align="center">';
					$order_detail .= '						<strong>'.($i+1).'</strong><br/>';
					$order_detail .= '					</td>';
					$order_detail .= '					<td> ';
					$order_detail .= '						<a href="'.$link_view_product.'">';
					$order_detail .= 							@$arr_product[$item -> product_id] -> name;
					$order_detail .= '						</a> ';
					$order_detail .= '					</td>';

					$order_detail .= '					<td> ';
					$order_detail .= '						<strong>';
					$order_detail .= 							format_money($item -> price);
					$order_detail .= '						</strong>';
					$order_detail .= '					</td>';
					$order_detail .= '					<td> ';
					$order_detail .= '						<strong>';
					$order_detail .= 							$item -> count?$item -> count:0;
					$order_detail .= '						</strong>';
					$order_detail .= '					</td>';
					$order_detail .= '					<td> ';
					$order_detail .= '						<span >';
					$order_detail .= 							format_money($item -> total);
					$order_detail .= '						</span>';
					$order_detail .= '					</td>';
					$order_detail .= '				</tr>';

					//quà tặng theo sản phẩm
					if(!empty($item -> list_gift_name)){ 
						$list_gift_name = substr($item -> list_gift_name, 0, -1);
						
						$list_gift_name = explode(',',$list_gift_name);
						
						foreach ($list_gift_name as $list_gift_it) {
							$order_detail .= '				<tr>';
							$order_detail .= '					<td align="center">';
							$order_detail .= '						<strong></strong><br/>';
							$order_detail .= '					</td>';
							$order_detail .= '					<td> ';
							$order_detail .= '						<a href="javascript:void(0)">';
							$order_detail .= 							$list_gift_it;
							$order_detail .= '						</a> ';
							$order_detail .= '					</td>';
							$order_detail .= '					<td> ';
							$order_detail .= '						<strong>0đ (Quà tặng)';
							$order_detail .= '						</strong>';
							$order_detail .= '					</td>';
							$order_detail .= '					<td> ';
							$order_detail .= '						<strong>';
							$order_detail .= 							$item -> count?$item -> count:0;
							$order_detail .= '						</strong>';
							$order_detail .= '					</td>';
							$order_detail .= '					<td> ';
							$order_detail .= '						<span >0đ (Quà tặng)';
							$order_detail .= '						</span>';
							$order_detail .= '					</td>';
							$order_detail .= '				</tr>';
						}
					}
					//end quà tặng theo sản phẩm
					
				
				}
				// quà tặng theo khoảng giá
				if(!empty($order -> list_gift_price_range_name)){
					$list_gift_price_range_name = substr($order -> list_gift_price_range_name, 1, -1);
					
					$list_gift_price_range_name = explode(',',$list_gift_price_range_name);
					
					foreach ($list_gift_price_range_name as $list_gift_price_range_name_it) {
						$order_detail .= '				<tr>';
						$order_detail .= '					<td align="center">';
						$order_detail .= '						<strong></strong><br/>';
						$order_detail .= '					</td>';
						$order_detail .= '					<td> ';
						$order_detail .= '						<a href="#">';
						$order_detail .= 							$list_gift_price_range_name_it;
						$order_detail .= '						</a> ';
						$order_detail .= '					</td>';

						$order_detail .= '					<td> ';
						$order_detail .= '						<strong>0đ (Quà tặng)';
										
						$order_detail .= '						</strong>';
						$order_detail .= '					</td>';
						$order_detail .= '					<td> ';
						$order_detail .= '						<strong>1';
					
						$order_detail .= '						</strong>';
						$order_detail .= '					</td>';
						$order_detail .= '					<td> ';
						$order_detail .= '						<span >0đ (Quà tặng)';
				
						$order_detail .= '						</span>';
						$order_detail .= '					</td>';
						$order_detail .= '				</tr>';

					}
				}


				// end quà tặng theo khoảng giá


				$order_detail .= '				<tr>';
				$order_detail .= '					<td colspan="4"  align="right"><strong>Tạm tính:</strong></td>';
				$order_detail .= '					<td ><strong >'.format_money($order -> total_before_discount).'</strong> </td>';
				$order_detail .= '				</tr>';

				$order_detail .= '				<tr>';
				$order_detail .= '					<td colspan="4"  align="right"><strong>Mã giảm giá:</strong></td>';
				$order_detail .= '					<td ><strong > -'.format_money($order-> money_dow,'₫','0').' ('.$order-> code_sale.')'.'</strong> </td>';
				$order_detail .= '				</tr>';

				$order_detail .= '				<tr>';
				$order_detail .= '					<td colspan="4"  align="right"><strong>Phí ship:</strong></td>';
				$order_detail .= '					<td ><strong >'.format_money($order-> shipping_money,'₫','0').'('.$order->shipping_note.')'.'</strong> </td>';
				$order_detail .= '				</tr>';

				$order_detail .= '				<tr>';
				$order_detail .= '					<td colspan="4"  align="right"><strong>Thanh toán:</strong></td>';
				$order_detail .= '					<td ><strong >'.format_money($order -> total_after_discount).'</strong></td>';
				$order_detail .= '				</tr>';
				$order_detail .= '		</tbody>';
				$order_detail .= '	</table>	';

				$body = str_replace('{thong_tin_nguoi_dat}', $sender_info, $body);
				$body = str_replace('{thong_tin_don_hang}', $order_detail, $body);

				$mailer -> setBody($body);


				

	
				if(!$mailer ->Send())
					return false;
				
				return true;
			}

			function get_price_quantity($product_id, $quantity) {
				if (! $product_id)
					return;
				$query = " SELECT price
				FROM fs_products_prices_quantity
				WHERE  record_id = $product_id AND quantity <= $quantity ORDER BY quantity DESC limit 1";
				global $db;
				$db->query ( $query );
				return $rs = $db->getObject ();

			}

			function ajax_get_user_from_card(){
				$card_code = FSInput::get('card_code');
				if(!$card_code)
					return;
				$date = date('Y-m-d');
				return  $this -> get_record(' card_code = "'.$card_code.'" AND published = 1  ','fs_members');

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

		
			
	}
?>
