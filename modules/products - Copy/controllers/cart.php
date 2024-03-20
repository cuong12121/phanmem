<?php
/*
 * Huy write
 */
// controller


class ProductsControllersCart extends FSControllers {

	function ajax_buy_compatables() {

		$model = $this->model;
		$list = array();

		$product_id_main = FSInput::get('product_id');
		$str_id_compatables = FSInput::get('str_id_compatables');
		if(!$str_id_compatables){
			return false;			
		}

		//main product
		$product_main = $model -> get_record('id = '.$product_id_main, 'fs_products' , '*' );

		$check_sale_off_product_main = $model -> check_sale_off($product_main-> id);
		if($check_sale_off_product_main && $check_sale_off_product_main-> total_item > $check_sale_off_product_main-> total_item_buy){
			$product_main-> price = $check_sale_off_product_main-> price;
			$product_main-> sale_off =1;
		}else {
			$product_main-> sale_off =0;
		}

		$sale_off = $product_main -> sale_off; 
		// $json = $_REQUEST["data"];
		$product_id = $product_main -> id; // product_id
		$quantity = 1; // số lượng
		// $price_id = $json -> price_id; // id của bảng fs_products_prices
		$price = $product_main -> price; // giá
		// $type = $json -> type; // xác định loại giảm giá
		// $type = $type?$type:'none';
		// $is_gift = 0;
		// $is_combo = isset($json -> is_combo)?$json -> is_combo:0; 
		// $gifts = isset($json -> gift)?$json -> gift:null;

		$list[] = array (
			// 'product_id' => $product_id,
			// 'quantity' => $quantity,
			// 'sale_off'=> $sale_off,
			// 'parent_product'=> $product_id,
			// 'price'=> $price,
			// 'price_old'=> $product_main -> price_old,
			// 'sid'=> $product_id.'_'.'0',

			'parent_product'=> $product_id,
			'product_id' => $product_id,
			'quantity' => $quantity,
			'sale_off'=> $sale_off,
			'box_extend_string'=>'',
			'color_id'=>'',
			'region_id'=>'',
			'warranty_id'=>'',
			'price'=> $price,
			'price_old'=> $product_main -> price_old,
			'sid'=> $product_id.'_'.'0'

		);


		// list compatable
		$arr_id_compatables = explode("_", $str_id_compatables);


		// print_r($arr_id_compatables);die;
		foreach ($arr_id_compatables as $id_compatables) {
			$product = $model -> get_record('id = '.$id_compatables, 'fs_products' , '*' );
			$price_compatable = $model -> get_record('product_id = '.$product_id_main.' AND product_compatable_id = '.$id_compatables, 'fs_products_compatables' , '*' );
		// $json = $_REQUEST["data"];
		$product_id = $product -> id; // product_id
		$quantity = 1; // số lượng
		// $price_id = $json -> price_id; // id của bảng fs_products_prices
		$price = $price_compatable -> price; // giá
		// $type = $json -> type; // xác định loại giảm giá
		// $type = $type?$type:'none';
		$is_attach = 1;
		$id_attach = $price_compatable-> product_id; 
		// $gifts = isset($json -> gift)?$json -> gift:null;
		if (!$product_id || ! $quantity)
			return;
		FSFactory::include_class ( 'errors' );

		$list[] = array (
			'product_id' => $product_id,
			'quantity' => $quantity,
					// 'price_id'=> $price_id,
			'price'=> $price,
			'price_old'=> $price_compatable -> price_old,
					// 'unit'=> $record_price -> unit,
			'id_attach'=> $id_attach,
			'is_attach'=> $is_attach,
					// 'is_total_shopcart' => 1,
			'parent_product' => $price_compatable-> product_id,
			'sid'=> $id_compatables.'_'.'2'.'_'.$price_compatable-> product_id,
			'box_extend_string'=>'',
			'color_id'=>'',
			'region_id'=>'',
			'warranty_id'=>''
		);
	}


	if (! isset ( $_COOKIE ['cart'] )) {
		$product_list = $list;
		// echo '<pre>';
		// print_r($product_list);die;
			// $compatable_price = $model->getPrice ($product_id,$price_id,$is_combo);
		$item_data = json_encode($product_list);
		setcookie('cart', $item_data, time() + (86400 * 30), '/');

	} else {

		$product_list = json_decode($_COOKIE['cart'],true);
		$exist_prd = 0;
// 		echo '<pre>';
// 		print_r($product_list);
// 		echo "-----------";
// 		print_r($list);
// die;
		foreach($product_list as &$item){
			foreach ($list as $keylist => $value) {
				if($item['product_id'] == $value['product_id'] && $item['sid'] == $value['sid']) {
					$item['quantity'] = $item['quantity'] + $value['quantity'];
					unset($list[$keylist]);
				}
			}
		}

		foreach ($list as $value) {
			$product_list[] = $value;
		}

		$product_list = $this-> update_price_cart($product_list);

		$item_data = json_encode($product_list);
		setcookie('cart', $item_data, time() + (86400 * 30), '/');
	}


	return;
}

function buy_again(){

	$model = $this->model;
	$order_id = FSInput::get('order_id');
	if(!$order_id){
		return;
	}
	$order = $model->get_record('id = '. $order_id,'fs_order');
	if(empty($order)){
		return;
	}

	$order_detail = $model->get_records('order_id = '. $order_id,'fs_order_items');
	// printr($order_detail);
	if(empty($order_detail)){
		return;
	}

	foreach ($order_detail as $order_item){
		$product_main = $model -> get_record('id = '.$order_item->product_id, 'fs_products' , '*' );
		if(empty($product_main)){
			continue;
		}

		$quantity = $order_item->count;
		$check_sale_off_product_main = $model -> check_sale_off($product_main-> id);
		if(!empty($check_sale_off_product_main) && $check_sale_off_product_main-> total_item > $check_sale_off_product_main-> total_item_buy) {
			$product_main-> price = $check_sale_off_product_main-> price;
			$product_main-> sale_off = 1;
		} else {
			$product_main-> sale_off = 0;
		}
		// printr($product_main);
		$product_id = $product_main -> id;
		$sale_off = $product_main -> sale_off;
		$price = $product_main -> price;
		$box_extend_string = 0;
		$color_id = $order_item->color_id;
		$sid=  $product_id.'_'.'0'.'_'.$color_id.'_'.$box_extend_string;
		
		if (!$product_id || !$quantity)
			return;
		FSFactory::include_class ( 'errors' );
		if (! isset ( $_COOKIE ['cart'] )) {
			// $product_list = array ();
			$product_list [] = array (
				'product_id' => $product_id,
				'quantity' => $quantity,
				'sale_off'=> $sale_off,
				'box_extend_string'=>$box_extend_string,
				'color_id'=>$color_id,
				'price'=> $price,
				'price_old'=> $product_main -> price_old,
				'sid'=> $sid
			);

		} else {
			$product_list = json_decode($_COOKIE['cart'],true);
			$exist_prd = 0;
			foreach($product_list as &$item){
				if($item['product_id'] == $product_id && $item['sid'] == @$sid && $item['color_id'] == $color_id && $item['box_extend_string'] == $box_extend_string ){ // cùng sp và loại giá
					$item['quantity'] = $item['quantity'] + $quantity;
					$exist_prd ++;
				}
			}
			// if not exist product
			if (! $exist_prd) {
				$product_list [] = array (
					'product_id' => $product_id,
					'quantity' => $quantity,
					'box_extend_string'=>$box_extend_string,
					'color_id'=>$color_id,
					'parent_product'=> $product_id,
					'price'=> $price,
					'price_old'=> $product_main -> price_old,
					'sale_off'=> $sale_off,
					'sid'=> $sid
				);
			}
		}


	}

	// printr($product_list);
	$product_list = $this-> update_price_cart($product_list);
	$item_data = json_encode($product_list);
	setcookie('cart', $item_data, time() + (86400 * 30), '/');


	
	$link = FSRoute::_('index.php?module=products&view=cart&task=shopcart&Itemid=11&action=gio-hang');
	setRedirect($link);

}



function ajax_buy_product() {

	$model = $this->model;
	$product_id_main = FSInput::get('product_id');
	$quantity = FSInput::get('buy_count');
	if(!$quantity){
		$quantity = 1;
	}
	$color_id = FSInput::get('color_curent_id',0,'int'); // color
	$region_id = FSInput::get('region_curent_id',0,'int'); // khu vuc
	$warranty_id = FSInput::get('warranty_curent_id',0,'int'); // bao hanh
	
	$box_extend = FSInput::get('box_extend',array(),'array');



	$is_ajax =  FSInput::get('is_ajax',0,'int');
	$no_services =  FSInput::get('no_services',0,'int');




	if($is_ajax == 0){ // nut mua ngay
		$box_extend_string = implode(',', $box_extend);

		if(!$no_services) {
			$arr_services = FSInput::get('services',array(),'array');
			$services = json_encode($arr_services);
		}


	}else{ // nut them vao gio hang
		$box_extend_string = FSInput::get('box_extend_string');
		if(!$no_services) {
			$txt_services =FSInput::get('txt_services');
			$txt_services = trim($txt_services,',');
			$arr_services =  implode(',', $txt_services);
			$services = json_encode($arr_services);
		}
	}

	if(empty($box_extend_string) || $box_extend_string == ''){
		$box_extend_string = 0;
	}

	$product_main = $model -> get_record('id = '.$product_id_main, 'fs_products' , '*' );

	$check_sale_off_product_main = $model -> check_sale_off($product_main-> id);

	if(!empty($check_sale_off_product_main) && $check_sale_off_product_main-> total_item > $check_sale_off_product_main-> total_item_buy) {
		$product_main-> price = $check_sale_off_product_main-> price;
		$product_main-> sale_off = 1;
	} else {
		$product_main-> sale_off = 0;
	}
	$product_id = $product_main -> id; // product_id
	$sale_off = $product_main -> sale_off; 
	

	if($no_services) {
$price = $product_main -> price2; // giá
}	 else {
		$price = $product_main -> price; // giá
	}

	$sid=  $product_id.'_'.'0'.'_'.$color_id.'_'.$box_extend_string.'_'.$region_id.'_'.$warranty_id;
	
	if (!$product_id || ! $quantity)
		return;
	FSFactory::include_class ( 'errors' );


	if (! isset ( $_COOKIE ['cart'] )) {
		$product_list = array ();
		if (!$product_id) {
			echo  "Không tồn tại sản phẩm trong giỏ hàng" ;
			return;
		}
		$product_list [] = array (
			'product_id' => $product_id,
			'quantity' => $quantity,
			'sale_off'=> $sale_off,
			'box_extend_string'=>$box_extend_string,
			'color_id'=>$color_id,
			'region_id'=>$region_id,
			'warranty_id'=>$warranty_id,
			'price'=> $price,
			'price_old'=> $product_main -> price_old,
			'sid'=> $sid,
			'no_services' => $no_services,
			'services' => @$services
		);
	} else {
		$product_list = json_decode($_COOKIE['cart'],true);
			// printr($product_list);
		$exist_prd = 0;

		foreach($product_list as &$item){
				if($item['product_id'] == $product_id && $item['sid'] == @$sid && $item['color_id'] == $color_id && $item['box_extend_string'] == $box_extend_string && $item['no_services'] == $no_services){ // cùng sp và loại giá
					$item['quantity'] = $item['quantity'] + $quantity;
					$check_sale_off = $model -> check_sale_off($item['product_id']);
					
					if($check_sale_off && $check_sale_off-> total_item > $check_sale_off-> total_item_buy){
						$item['price'] = $check_sale_off->price;
					}else{
						$data_product = $this -> getProductById($item['product_id']);
						// print_r($data_product);die;
						if($item['no_services']) {
							$item['price'] = $data_product->price2;
						} else {
							$item['price'] = $data_product->price;
						}	
					}
					$exist_prd ++;
				}
			}

			// print_r($product_list);die;

			// if not exist product
			if (! $exist_prd) {
				$product_list [] = array (
					'product_id' => $product_id,
					'quantity' => $quantity,
					'box_extend_string'=>$box_extend_string,
					'color_id'=>$color_id,
					'region_id'=>$region_id,
					'warranty_id'=>$warranty_id,
					'parent_product'=> $product_id,
					'price'=> $price,
					'price_old'=> $product_main -> price_old,
					'sale_off'=> $sale_off,
					'sid'=> $sid,
					'no_services' => $no_services,
					'services' => @$services
				);
			}
		}
		// printr($product_list);

		$total_price = 0;
		$quantity = 0;
		$str_ids = '';

		if (isset ( $product_list ) && $product_list) {
			$i = 0;
			foreach ( $product_list as $item1 ) {
				$i ++;
				$check_sale_off = $model -> check_sale_off($item1['product_id']);

				if($check_sale_off && $check_sale_off-> total_item > $check_sale_off-> total_item_buy){
					$item1['price'] = $check_sale_off->price;
				}else{
					$data_product = $this -> getProductById($item1['product_id']);
					if($item['no_services']) {
						$item1['price'] = $data_product->price2;
					} else {
						$item1['price'] = $data_product->price;
					}	
				}

				$total_price += $item1['price'] * $item1['quantity'];


				if(isset($item1['is_gift']) && $item1['is_gift'] == 1){

				}else{
					$quantity +=  $item1['quantity'];
				}
				
				if ($str_ids)
					$str_ids .= ',';
				$str_ids .= $item1['product_id'];
			}
		}



		if ($str_ids)
			$arr_products = $model->get_products_by_ids ( $str_ids );
		//printr($product_list);
		// $product_list = $this-> update_price_cart($product_list);
		$item_data = json_encode($product_list);

		// printr($item_data);
		setcookie('cart', $item_data, time() + (86400 * 30), '/');

		$link = FSRoute::_('index.php?module=products&view=cart&task=shopcart&Itemid=11&action=gio-hang');

		setRedirect($link);
	}

	function update_price_cart($product_list){
		// $model = $this-> model;
		// if(empty($product_list)) return;
		// foreach ($product_list as &$item) {
		// 	if(!@$item['sale_off'] && !@$item['id_attach'] && !@$item['is_combo']) {

		// 		$check_sale_quantity = $model -> get_price_quantity($item['product_id'], $item['quantity']);

		// 		if(!empty($check_sale_quantity)){
		// 			$item['price'] = $check_sale_quantity-> price;
		// 		} else {
		// 			$check_sale_quantity = $model-> get_record('id = '.$item['product_id'],'fs_products', 'price');
		// 			$item['price'] = $check_sale_quantity-> price;
		// 		}

		// 	}
		// }

		return $product_list;

	}

	function ajax_buy_combo() {

		$model = $this->model;

		$id_combo = FSInput::get('id_combo');
		// $str_id_compatables = FSInput::get('str_id_compatables');
		// $arr_id_compatables = explode("_", $str_id_compatables);
		$arr_product_incombo = $model-> get_records('sale_id = '.$id_combo, fs_sales_products, '*');

		$list= array();

		foreach ($arr_product_incombo as $id_product) {
			$product_main = $model -> get_record('id = '.$id_product-> product_id , 'fs_products' , '*' );
			$price_combo = $model -> get_record('product_id = '.$product_main-> id.' AND sale_id = '.$id_combo, 'fs_sales_products' , '*' );
		// $json = $_REQUEST["data"];
		$product_id = $product_main -> id; // product_id
		$quantity = 1; // số lượng
		// $price_id = $json -> price_id; // id của bảng fs_products_prices
		$price = $price_combo -> price; // giá
		// $type = $json -> type; // xác định loại giảm giá
		// $type = $type?$type:'none';
		// $is_gift = 0;
		// $is_combo = isset($json -> is_combo)?$json -> is_combo:0; 
		// $gifts = isset($json -> gift)?$json -> gift:null;


		if (!$product_id || ! $quantity)
			return;
		FSFactory::include_class ( 'errors' );

		$list [] = array (
			'product_id' => $product_id,
			'quantity' => $quantity,
				// 'price_id'=> $price_id,
//				'price'=> $record_price -> price,
			'price'=> $price,
			'price_old'=> $product_main -> price_old,
				// 'unit'=> $record_price -> unit,
				// 'type'=> $type,
			'is_combo'=> 1,
			'id_combo' => $id_combo,
				// 'is_total_shopcart' => 1,
			'sid'=> $product_id.'_'.'1'.'_'.$id_combo
		);
	}


	if (! isset ( $_COOKIE ['cart'] )) {
		$product_list = $list;
		// echo '<pre>';
		// print_r($product_list);die;
			// $compatable_price = $model->getPrice ($product_id,$price_id,$is_combo);
		$item_data = json_encode($product_list);
		setcookie('cart', $item_data, time() + (86400 * 30), '/');

	} else {

		$product_list = json_decode($_COOKIE['cart'],true);
		$exist_prd = 0;
// 		echo '<pre>';
// 		print_r($product_list);
// 		echo "-----------";
// 		print_r($list);
// die;
		foreach($product_list as &$item){
			foreach ($list as $keylist => $value) {
				if($item['product_id'] == $value['product_id'] && $item['sid'] == $value['sid']) {
					$item['quantity'] = $item['quantity'] + $value['quantity'];
					unset($list[$keylist]);
				}
			}
		}

		foreach ($list as $value) {
			$product_list[] = $value;
		}

		$product_list = $this-> update_price_cart($product_list);

		$item_data = json_encode($product_list);
		setcookie('cart', $item_data, time() + (86400 * 30), '/');
	}




	// $html = $this->genarate_shopcart_popup ( $product_list, $arr_products );

	// 	// tính chiết khấu	
	// $session_order = $model -> getOrder();
	// 	// $user = $model -> get_user();


	// 	// Tính chiết khấu nếu có đăng nhập
	// $total_before_discount_by_cardcode = 0;
	// $total_discount_by_cardcode = 0;

	// if(!isset($session_order->total_discount_by_cardcode)){
	// 	if(isset($user )){
	// 		$date = date('Y-m-d');
	// 		if($user -> card_started_time <= $date && $user -> card_end_time >= $date){
	// 			$chiet_khau = $user -> 	chiet_khau;
	// 			$card_code = $user -> card_code;
	// 		}


	// 		$total_before_discount_by_cardcode = 0;
	// 		$total_discount_by_cardcode = 0;

	// 		$total_before_discount = 0;
	// 		$total_after_discount = 0;
	// 		$products_count = 0;

	// 			// print_r($product_list);
	// 			// die;

	// 			// 	Repeat products	
	// 		for($i = 0; $i < count ( $product_list ); $i ++) {
	// 			$prd = $product_list [$i];
	// 			$prd_id_array [] = $prd ['product_id'];

	// 				// cal
	// 			$total_before_discount += $prd ['price'] * $prd ['quantity'];
	// 			$products_count += $prd ['quantity'];

	// 				// loại sản phẩm được giảm giá tiếp cho thành viên
	// 			if($prd['is_total_shopcart']){
	// 				$total_before_discount_by_cardcode += 	$prd ['price'] * $prd ['quantity'];
	// 			}
	// 		}

	// 			// số tiền chiết khấu cho thành viên ( check qua mã thẻ)
	// 		$total_discount_by_cardcode = $total_before_discount_by_cardcode * $chiet_khau / 100;
	// 		$total_price = $total_price - $total_discount_by_cardcode;
	// 	}

	// }else{
	// 	$total_discount_by_cardcode  = $session_order->total_discount_by_cardcode;
	// 	$total_price = $total_price - $total_discount_by_cardcode;
	// }
	// 	// end tính chiết khấu.

	// 	// tổng giá để giảm tiếp 
	// $total_price_to_discount = $total_price;

	// $sale_alert = '';
	// if($total_price_to_discount){
	// 	$sales = $model->get_sales_total();
	// 	$price_above = 0;
	// 	$price_below = 0;
	// 	$type_above = '';
	// 	$type_below = '';
	// 	foreach($sales as $sale){
	// 		if($sale -> price_min > $total_price_to_discount){
	// 			$price_above = $sale -> price_min;
	// 			$type_above = $sale -> type; 
	// 		}
	// 		if($sale -> price_min <= $total_price_to_discount){
	// 			$price_below = $sale -> price_min;
	// 			$type_below = $sale -> type;
	// 			break;
	// 		}
	// 	}

	// 	if($price_below){
	// 		if($type_below == 7){
	// 			$sale_alert .= FSText::_('Bạn đã mua đơn hàng >='.format_money($price_below).' nên bạn được nhận quà.');
	// 		}else{
	// 			$sale_alert .= FSText::_('Bạn đã mua đơn hàng >='.format_money($price_below).' nên bạn được chiết khấu.');
	// 		}
	// 		if($price_above){
	// 			if($type_above == 7){
	// 				$sale_alert .= FSText::_(' Tuy nhiên, nếu bạn mua đơn hàng >='.format_money($price_above).' thì quà của bạn sẽ hấp dẫn hơn.');
	// 			}else{
	// 				$sale_alert .= FSText::_(' Tuy nhiên, nếu bạn mua đơn hàng >='.format_money($price_above).' thì bạn được chiết khấu cao hơn.');
	// 			}
	// 		}
	// 	}else{
	// 		if($price_above){
	// 			if($type_above == 7){
	// 				$sale_alert .= FSText::_('Nếu bạn mua đơn hàng >='.format_money($price_above).', những phần quà hấp dẫn đang đời bạn.');
	// 			}else{
	// 				$sale_alert .= FSText::_('Nếu bạn mua đơn hàng >='.format_money($price_above).', thì bạn được chiết khấu.');
	// 			}
	// 		}
	// 	}
	// }

	// $result = array ('total_price' => format_money ( $total_price, '' ), 'quantity' => $quantity, 'html' => $html, 'sale_alert' => $sale_alert );
	// echo json_encode ( $result );
	// 	//			echo count($product_list);	
	return;
}


function check_code(){
	$model = $this -> model;
	$code_input = FSInput::get('code_input');
	if(!$code_input){
		unset($_SESSION['code_sale_input']);
		unset($_SESSION['code_sale_message']);
		unset($_SESSION['code_sale_price_down']);
		return;
	}
	$check_code = $model -> check_code();

	$data = array ('error' => true, 'message' => '');
	$total_noshipping = 0;
	$total_no_sale = 0;
	$product_list = json_decode($_COOKIE['cart'],true);
	// printr($product_list);
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
						$extend_item = $model -> get_record_by_id($extend_item_val,'fs_products_price_extend');
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
				$data_price_color =  $model -> get_record('id = ' . $prd['color_id'] . ' AND record_id = ' . $product->id,'fs_products_price');
				if(!empty($data_price_color)){
					$price_color  = (int)$data_price_color-> price;
					$color_name =  "Màu " . $data_price_color-> color_name;
					$color_id =  $data_price_color-> id;
				}
				$data_color = $model-> get_record('id = ' . $prd['color_id'] ,'fs_products_price','color_id');
				if($data_color){
					$image_color =  $model -> get_record('color_id = ' .$data_color->color_id. ' AND record_id = ' . $product->id,'fs_products_images','image');
				}
			}
			
			$total_item = ($price_color + $total_price_extent + $prd['price'] ) * $prd['quantity'];

			$check_sale_off = $model -> check_sale_off($prd['product_id']);
			$check_combo = $model->get_record('is_combo = 1 AND id = '. $prd['product_id'], 'fs_products','id');


			$price_item = $prd['price'] * $prd['quantity'];

			if($check_code-> is_auto == 1){
				$total_noshipping += $total_item;
			}else{
				if($check_sale_off && $check_sale_off-> total_item > $check_sale_off-> total_item_buy || $check_combo){
					$total_no_sale += $total_item;
				}else{
					$total_noshipping += $total_item;
				}
			}
			
		}
	}


	// $total_noshipping = FSInput::get('total_noshipping',0,'int');
	if($check_code){
		if($total_noshipping == 0 || $total_noshipping < $check_code-> min_price) {
			
			if($check_code-> is_auto == 1){
				$data['message'] = 'Mã giảm giá này áp dụng với đơn hàng trên '.format_money($check_code-> min_price, "₫",0);
			}else{
				
				$data['message'] = 'Mã giảm giá này áp dụng với đơn hàng trên '.format_money($check_code-> min_price, "₫",0);
			}
			

			unset($_SESSION['code_sale_input']);
			unset($_SESSION['code_sale_message']);
			unset($_SESSION['code_sale_price_down']);
			$_SESSION['code_sale_message'] = $data ['message'];
			$_SESSION['code_sale_input'] = $code_input;
		}elseif($check_code-> is_auto == 1 && $check_code-> user_id != $_COOKIE['user_id']){
			$data ['message'] = 'Mã giảm giá này chỉ áp dụng với tài khoản được nhận mã giảm giá !. Xin vui lòng đăng nhập đúng tài khoản.';
			unset($_SESSION['code_sale_input']);
			unset($_SESSION['code_sale_message']);
			unset($_SESSION['code_sale_price_down']);
			$_SESSION['code_sale_message'] = $data ['message'];
			$_SESSION['code_sale_input'] = $code_input;
		}
		else{
			if($check_code->type_sale==1){
				$data['type_down'] =  1;
			}else{
				$data['type_down'] =  2;
			}
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

			
			$price_ship = FSInput::get('price_ship');
			if($price_ship AND $total_code > 0){
				$total_code = $total_code + $price_ship;
			}

			$data['total_code'] = format_money($total_code,'₫',0);
			$data['total_down'] = format_money($total_down,'₫',0);
			$data ['error'] = false;
			if($check_code-> is_auto == 1){
				$data ['message'] = 'Đơn hàng của bạn được giảm ' . format_money($total_down,'₫',0);
			}else{
				$data ['message'] = 'Đơn hàng của bạn được giảm ' . format_money($total_down,'₫',0);
			}
			
			$_SESSION['code_sale_input'] = $code_input;
			$_SESSION['code_sale_message'] = $data ['message'];
			$_SESSION['code_sale_price_down'] = $total_down;

		}
		
	}else{
		$data ['message'] = 'Mã giảm giá không tồn tại hoặc đã hết hạn . Xin vui lòng kiểm tra lại !';
		unset($_SESSION['code_sale_input']);
		unset($_SESSION['code_sale_message']);
		unset($_SESSION['code_sale_price_down']);
		$_SESSION['code_sale_message'] = $data ['message'];
		$_SESSION['code_sale_input'] = $code_input;

	}

	echo json_encode ($data);
	return;
}

function check_code1()
{
	$model = $this -> model;
	$check_code = $model -> check_code();
	if($check_code){
		// $getorder = $model -> get_order($check_code -> money_dow);
	}
	$data = array ('error' => true, 'message' => '', 'html' => '' , 'html2' => '' );
	$total_noshipping = FSInput::get('total_noshipping',0,'int');
	$datenow = getdate();


	if($check_code){
		if($total_noshipping < $check_code-> min_price) {
			$data ['html'] .='<div class="pull-right" align="right" ><label>Thành tiền:</label><span> '.format_money($total_noshipping,' VNĐ').'</span></div>';
			$data ['html'] .='<div class = "clear" ></div>';
			$data ['html'] .='<div class="pull-right" align="right" ><label>Khuyến mãi:<span> Mã khuyến mãi áp dụng với đơn hàng trên '.format_money($check_code-> min_price, 'VNĐ').'</span></label> <span id="shipping_value"></span></div>';
			$data ['html'] .='<div class = "clear" ></div>';
			$data ['html'] .='<div class="pull-right" align="right" ><label>Thanh toán:</label><span id="total_after">'. format_money($total_noshipping,' VNĐ').'</span></div>';

			$data ['html2'] .='<div> Mã khuyến mãi áp dụng với đơn hàng trên '.format_money($check_code-> min_price, '₫').'</div>';
			$data ['total_value'] = $total_noshipping;
			$data ['error2']='Mã khuyến mãi áp dụng với đơn hàng trên '.format_money($check_code-> min_price, "VNĐ");
		}
		else{
			$data ['html'] .= '<input type="hidden" name="price_send" id="price_send" value="'.$check_code-> money_dow.'">';
			$data ['html'] .='<input type="hidden" name="code_card_send" id="code_card_send" value="'.$check_code-> code.'">';
			$data ['html'] .='<input type="hidden" name="date_send" id="date_send" value="'.$check_code-> date_start.'">';
			$data ['html'] .='<div class="pull-right" align="right" ><font>Thành tiền(VNĐ):</font><span> '.format_money($total_noshipping,' VNĐ').'</span></div>';
			$data ['html'] .='<div class = "clear" ></div>';
			$data ['code_card_send'] = $check_code-> code;
			$data ['price_send'] = (int)$check_code-> money_dow;
			$data ['html2'] .= '<input type="hidden" name="price_send" id="price_send" value="'.$check_code-> money_dow.'">';

			if($check_code->type_sale==1){
				$data['type_down'] =  1;
				$data ['html'] .='<div class="pull-right" align="right" ><font>Khuyến mãi:<span>'.$check_code-> money_dow.' %</span></font> <span id="shipping_value"></span></div>';
				$data ['html'] .='<input type="hidden" name="type_down" id="type_down" value="1">';

				$data ['html2'] .='<div><label>Khuyến mãi:</label> '.$check_code-> money_dow.'%</div>';
				$data ['html2'] .='<input type="hidden" name="type_down" id="type_down" value="1">';
			}
			else{
				$data['type_down'] =  2;
				$data ['html2'] .='<div> <label>Khuyến mãi:</label> <span>'.$check_code-> money_dow.' ₫</div>';
				$data ['html2'] .='<input type="hidden" name="type_down" id="type_down" value="2">';
			}
			if($check_code->type_sale==1){
				$total_code = $total_noshipping - ($total_noshipping * ($check_code-> money_dow/100));
				$total_down=$total_noshipping * ($check_code-> money_dow/100);
			} else{
				$total_code = $total_noshipping - $check_code-> money_dow;
				$total_down=$check_code-> money_dow;
			}
			$data ['html'] .='<div class = "clear" ></div>';
			$data ['html'] .='<div class="pull-right" align="right" ><label>Thanh toán:</label><span id="total_after">'. format_money($total_code,' VNĐ').'</span></div>';

			$data ['total_code'] = format_money($total_code,'đ');
			$data ['total_value'] = $total_code;
			$data['total_down']=$total_down;
			$data ['val_total_code'] = $total_code;
			$data ['html2'] .='<div><label>Thanh toán:</label> '. format_money($total_code,'đ').'</div>';
		}

	}else if($check_code && $check_code ->date_end < $datenow){
		$data ['html'] .= '<div class="errors_code">Xin lỗi! mã này chỉ được sử dụng đến ngày'.$check_code-> date_end.' </div>';
		$data ['html2'] .= '<div class="errors_code">Xin lỗi! mã này chỉ được sử dụng đến ngày'.$check_code-> date_end.' </div>';
		$data ['html'] .='<div class="pull-right" align="right" ><label>Thành tiền:</label><span> '.format_money($total_noshipping,' VNĐ').'</span></div>';
		$data ['html'] .='<div class = "clear" ></div>';
		$data ['html'] .='<div class="pull-right" align="right" ><label>Khuyến mãi:0 VND</label> <span id="shipping_value"></span></div>';
		$data ['html'] .='<div class = "clear" ></div>';
		$data ['html'] .='<div class="pull-right" align="right" ><label>Thanh toán:</label><span id="total_after">'. format_money($total_noshipping,' VNĐ').'</span></div>';
		$data ['total_value'] = $total_noshipping;
		$data ['error2']='Xin lỗi! mã này chỉ được sử dụng đến ngày'.$check_code-> date_end;

	}else if($check_code && $getorder &&  count($getorder) == $check_code->number_sale){
		$data ['html'] .= '<div class="errors_code">Xin lỗi! Số lượng đơn hàng nhận được khuyến đã hết </div>';
		$data ['html2'] .= '<div class="errors_code">Xin lỗi! Số lượng đơn hàng nhận được khuyến đã hết </div>';
		$data ['html'] .='<div class="pull-right" align="right" ><label>Thành tiền:</label><span> '.format_money($total_noshipping,' VNĐ').'</span></div>';
		$data ['html'] .='<div class = "clear" ></div>';
		$data ['html'] .='<div class="pull-right" align="right" ><label>Khuyến mãi:0 VND</label> <span id="shipping_value"></span></div>';
		$data ['html'] .='<div class = "clear" ></div>';
		$data ['html'] .='<div class="pull-right" align="right" ><label>Thanh toán:</label><span id="total_after">'. format_money($total_noshipping,' VNĐ').'</span></div>';
		$data ['total_value'] = $total_noshipping;
		$data ['error2']="Xin lỗi! Số lượng đơn hàng nhận được khuyến đã hết";
	}
	else{
		$data ['html'] .= '<div class="errors_code">Mã giảm giá không tồn tại</div>';
		$data ['html2'] .= '<div class="errors_code">Mã giảm giá không tồn tại</div>';
		$data ['html'] .='<div class="pull-right" align="right" ><label>Thành tiền:</label><span> '.format_money($total_noshipping,' VNĐ').'</span></div>';
		$data ['html'] .='<div class = "clear" ></div>';
		$data ['html'] .='<div class="pull-right" align="right" ><label>Khuyến mãi:0 VND</label> <span id="shipping_value"></span></div>';
		$data ['html'] .='<div class = "clear" ></div>';
		$data ['html'] .='<div class="pull-right" align="right" ><label>Thanh toán:</label><span id="total_after">'. format_money($total_noshipping,' VNĐ').'</span></div>';
		$data ['error2']="Mã giảm giá không tồn tại";
		$data ['total_value'] = $total_noshipping;


	}
	$data ['html'] .='<div class = "clear" ></div>';
	$data ['html'] .='<div class="total-price_note">'.FSText::_('Chú ý: Giá trị đơn hàng là tạm tính').')</div>';
	
	$data ['error'] = false;
	echo json_encode ( $data );


}

function ajax_buy() {
	$json = $_REQUEST["data"];
	$json = json_decode($json);
		$product_id = $json -> product_id; // product_id
		$quantity = $json -> quantity; // số lượng
		$price_id = $json -> price_id; // id của bảng fs_products_prices
		$price = $json -> price; // giá
		$type = $json -> type; // xác định loại giảm giá
		$type = $type?$type:'none';
		$is_gift = 0;
		$is_combo = isset($json -> is_combo)?$json -> is_combo:0; 
		
		$gifts = isset($json -> gift)?$json -> gift:null;

		if (!$product_id || ! $quantity)
			return;
		FSFactory::include_class ( 'errors' );
		
		$model = $this->model;

		if (! isset ( $_SESSION ['cart'] )) {
			$product_list = array ();
			$record_price = $model->getPrice ($product_id,$price_id,$is_combo);

			if (!$record_price) {
				echo  "Không tồn tại sản phẩm trong giỏ hàng" ;
				return;
			}
			// sid:  $product_id.'_'.$price_id.'_'.$price.'_'.$gift_4_product.'_'.'$sale_type';
			$product_list [] = array (
				'product_id' => $product_id,
				'quantity' => $quantity,
				'price_id'=> $price_id,
//				'price'=> $record_price -> price,
				'price'=> $price,
				'price_old'=> $record_price -> price_old,
				'unit'=> $record_price -> unit,
				'type'=> $type,
				'is_combo'=> $is_combo,
				'is_total_shopcart' => 1,
				'sid'=> $product_id.'_'.$price_id.'_'.$price.'_'.'0'.'_'.'0'
			);

		} else {
			$product_list = $_SESSION ['cart'];
			
			$exist_prd = 0;
			foreach($product_list as &$item){
				if($item['product_id'] == $product_id && $item['price_id'] == $price_id && $item['price'] == $price){ // cùng sp và loại giá
					$item['quantity'] = $item['quantity'] + $quantity;
					$exist_prd ++;
				}
			}
			// if not exist product
			if (! $exist_prd) {
				$record_price = $model->getPrice ($product_id,$price_id,$is_combo);
				$product_list [] = array (
					'product_id' => $product_id,
					'quantity' => $quantity,
					'price_id'=> $price_id,
					'price'=> $price,
					'price_old'=> $record_price -> price_old,
					'unit'=> $record_price -> unit,
					'type'=> $type,
					'is_combo'=> $is_combo,
					'is_total_shopcart' => 1,
					'sid'=> $product_id.'_'.$price_id.'_'.$price.'_'.'0'.'_'.'0'
					
				);
			}
		}

		// GIFT
		if($gifts){
			
			foreach($gifts as $gift){
				
				$record_price = $model->getPrice ($gift->product_id ,$gift->price_id,0);
				if(!$record_price)
					return;
				$record  = array (
					'product_id' => $gift->product_id,
					'quantity' => $gift->quantity,
					'price_id'=> $gift->price_id,
					'price'=> $gift->price,
					'price_old'=> $record_price -> price_old,
					'unit'=> $record_price -> unit,
					'type'=> $type,
					'is_gift'=>1,
					'is_total_shopcart' => 1,
					'gift_4_product'=>$product_id,
					
						// sid:  $product_id.'_'.$price_id.'_'.$price.'_'.$gift_4_product.'_'.'$sale_type';

					'sid'=> $product_id.'_'.$gift->price_id.'_'. $gift->price.'_'.$product_id.'_'.$type
				);
				// $product_list = $_SESSION ['cart'];
				$c = 0;
				foreach($product_list as &$item){
					if($item['sid'] == $record['sid']){
						$item['quantity'] = $item['quantity'] + $gift->quantity;
						$c = 1;
					}					
				}
				if(!$c){
					$product_list[] = $record;
				}
				
			}
		}
		
// print_r($product_list);
// 		die;	
		$total_price = 0;
		$quantity = 0;
		$str_ids = '';
		if (isset ( $product_list ) && $product_list) {

			$i = 0;
			foreach ( $product_list as $item1 ) {
				$i ++;
				$total_price += $item1['price'] * $item1['quantity'];
				if(isset($item1['is_gift']) && $item1['is_gift'] == 1){

				}else{
					$quantity +=  $item1['quantity'];
				}
				
				if ($str_ids)
					$str_ids .= ',';
				$str_ids .= $item1['product_id'];
			}
		}
		if ($str_ids)
			$arr_products = $model->get_products_by_ids ( $str_ids );


		$_SESSION ['cart'] = $product_list;
		
		$html = $this->genarate_shopcart_popup ( $product_list, $arr_products );

		// tính chiết khấu	
		$session_order = $model -> getOrder();
		// $user = $model -> get_user();


		// Tính chiết khấu nếu có đăng nhập
		$total_before_discount_by_cardcode = 0;
		$total_discount_by_cardcode = 0;

		if(!isset($session_order->total_discount_by_cardcode)){
			if(isset($user )){
				$date = date('Y-m-d');
				if($user -> card_started_time <= $date && $user -> card_end_time >= $date){
					$chiet_khau = $user -> 	chiet_khau;
					$card_code = $user -> card_code;
				}


				$total_before_discount_by_cardcode = 0;
				$total_discount_by_cardcode = 0;

				$total_before_discount = 0;
				$total_after_discount = 0;
				$products_count = 0;

				// print_r($product_list);
				// die;

				// 	Repeat products	
				for($i = 0; $i < count ( $product_list ); $i ++) {
					$prd = $product_list [$i];
					$prd_id_array [] = $prd ['product_id'];
					
					// cal
					$total_before_discount += $prd ['price'] * $prd ['quantity'];
					$products_count += $prd ['quantity'];

					// loại sản phẩm được giảm giá tiếp cho thành viên
					if($prd['is_total_shopcart']){
						$total_before_discount_by_cardcode += 	$prd ['price'] * $prd ['quantity'];
					}
				}

				// số tiền chiết khấu cho thành viên ( check qua mã thẻ)
				$total_discount_by_cardcode = $total_before_discount_by_cardcode * $chiet_khau / 100;
				$total_price = $total_price - $total_discount_by_cardcode;
			}
			
		}else{
			$total_discount_by_cardcode  = $session_order->total_discount_by_cardcode;
			$total_price = $total_price - $total_discount_by_cardcode;
		}
		// end tính chiết khấu.
		
		// tổng giá để giảm tiếp 
		$total_price_to_discount = $total_price;
		
		$sale_alert = '';
		if($total_price_to_discount){
			$sales = $model->get_sales_total();
			$price_above = 0;
			$price_below = 0;
			$type_above = '';
			$type_below = '';
			foreach($sales as $sale){
				if($sale -> price_min > $total_price_to_discount){
					$price_above = $sale -> price_min;
					$type_above = $sale -> type; 
				}
				if($sale -> price_min <= $total_price_to_discount){
					$price_below = $sale -> price_min;
					$type_below = $sale -> type;
					break;
				}
			}

			if($price_below){
				if($type_below == 7){
					$sale_alert .= FSText::_('Bạn đã mua đơn hàng >='.format_money($price_below).' nên bạn được nhận quà.');
				}else{
					$sale_alert .= FSText::_('Bạn đã mua đơn hàng >='.format_money($price_below).' nên bạn được chiết khấu.');
				}
				if($price_above){
					if($type_above == 7){
						$sale_alert .= FSText::_(' Tuy nhiên, nếu bạn mua đơn hàng >='.format_money($price_above).' thì quà của bạn sẽ hấp dẫn hơn.');
					}else{
						$sale_alert .= FSText::_(' Tuy nhiên, nếu bạn mua đơn hàng >='.format_money($price_above).' thì bạn được chiết khấu cao hơn.');
					}
				}
			}else{
				if($price_above){
					if($type_above == 7){
						$sale_alert .= FSText::_('Nếu bạn mua đơn hàng >='.format_money($price_above).', những phần quà hấp dẫn đang đời bạn.');
					}else{
						$sale_alert .= FSText::_('Nếu bạn mua đơn hàng >='.format_money($price_above).', thì bạn được chiết khấu.');
					}
				}
			}
		}
		
		
		
		$result = array ('total_price' => format_money ( $total_price, '' ), 'quantity' => $quantity, 'html' => $html, 'sale_alert' => $sale_alert );

		echo json_encode ( $result );
		//			echo count($product_list);	
		

		return;
	}

	function get_quantity_gifts_4_total($sale_id){
		if (! isset ( $_SESSION ['cart'] ))
			return 0;
		$total_price = 0;
		$product_list = $_SESSION ['cart'];
		
		$i = 0;

		foreach ( $product_list as $item ) {
			$i ++;
			if(!$item['is_total_shopcart'])
				continue;
			$total_price += $item['price'] * $item['quantity'];						
		}
		
		if(!$sale_id)
			return 0;
		
		$model = $this->model;
		$sale = $model -> get_sale($sale_id);
		if(!$sale -> price_min || $total_price < $sale -> price_min)
			return 0;
		return floor($total_price/$sale -> price_min);
	}

	/* Mua nhanh: chỉ cấn điền số điện thoại để gọi lại */
	function buy_fast_save(){
		$return = FSInput::get ( 'return' );
		$url = base64_decode ( $return );

		$model = $this->model;
		$session_order = $model -> buy_fast_save();
		if (! $session_order) {
			$msg = FSText::_('Chưa gửi thành công!');
			setRedirect ( $url, $msg, 'error' );

		} else {
				// $send_sms = $model -> sms_to_buyer($session_order);
			$send_mail  = $model -> mail_to_buyer($session_order,$fast = 1);
			setRedirect ( $url, 'Cảm ơn bạn đã liên hệ. Chúng tôi sẽ gọi lại cho bạn' );
				// echo "<script>";
				// echo " alert('".FSText::_('Cảm ơn bạn đã liên hệ. Chúng tôi sẽ gọi lại cho bạn')."');      
				// window.location.href='".$url."';
				// </script>";
		}
	}
	
	function ajax_add_gift_4_total() {
		$json = $_REQUEST["data"];
		$json = json_decode($json);
		$product_id = $json -> product_id; // product_id		
		$price_id = $json -> price_id; // id của bảng fs_products_prices
		$sale_id= $json -> sale_id; 
		$price = 0; // giá
		$type = 'totalhasgift'; // xác định loại giảm giá
		
		$is_gift = 1;
		$is_combo = 0; 
		$quantity = $this -> get_quantity_gifts_4_total($sale_id);
		
		if (!$product_id || ! $quantity)
			return;
		FSFactory::include_class ( 'errors' );
		
		$model = $this->model;

		
		
		$product_list = $_SESSION ['cart'];
		
		$exist_prd = 0;
		$products_new =  array();
		foreach($product_list as &$item){
			if($item['type'] == 'totalhasgift' && $item['is_gift'] == 1){

			}else{
				$products_new [] = $item;
			}
			
		}
		// if not exist product
		if (! $exist_prd) {
			$record_price = $model->getPrice ($product_id,$price_id,$is_combo);
			$products_new [] = array (
				'product_id' => $product_id,
				'quantity' => $quantity,
				'price_id'=> $price_id,
				'price'=> $price,
				'price_old'=> $record_price -> price,
				'unit'=> $record_price -> unit,
				'type'=> $type,
				'is_gift'=>1,
				'is_combo'=> $is_combo,
				'is_total_shopcart' =>0, 
				'sale_id' =>$sale_id,
				'sid'=> $product_id.'_'.$price_id.'_'.$price.'_'.'0'.'_'.$type
				// sid:  $product_id.'_'.$price_id.'_'.$price.'_'.$gift_4_product.'_'.'$sale_type';


			);
		}
		

		$_SESSION ['cart'] = $products_new;
		

		echo count($products_new);
		return count($products_new);
	}

	function genarate_shopcart_popup($product_list,$arr_products){
		$i = 0; 
		if(!$product_list) 
			return;
		$html = '';
		foreach ($product_list as $prd) {
			$i++;
			$product = isset($arr_products[$prd['product_id']])?$arr_products[$prd['product_id']]:null;
			if(!$product)
				continue;
			$link_detail =FSRoute::_('index.php?module=products&view=product&code='.$product->alias.'&ccode='.$product -> category_alias.'&id='.$product->id.'&cid='.$product->category_id.'&Itemid=6');

			$html.= '<div class="item clearfix">';
			$html.= '<a href="'.$link_detail.'" class="item-img">'; 
			if($product -> image){ 
				$image_small = URL_ROOT.str_replace('/original/', '/resized/', $product->image);
				$html.= '<img width="60"  src="'.$image_small.'" alt="'.htmlspecialchars ($product -> name).'"  />';
			} else {
				$html.= '<img  width="60" src="'.URL_ROOT.'"images/no-img.gif" alt="'.htmlspecialchars ($product -> name).'" />';
			}	 
			$html.= '</a> ';
			$html.= '<div class="other_info">';
			$html.= '<a class="name" href="'.$link_detail.'" > '. $product -> name . ' </a> 	';
			$html.= '<div>'.$prd['quantity'].' x <span class="price">'.format_money($prd['price'],'').'</span></div>';
			$html.= '</div>';
			$html.= '</div>';
		}
		return $html;
	}

	function get_price_ship(){
		$city_id = FSInput::get('city_id',0,'int');
		$model = $this -> model;
		$city =$model-> get_record('id = '.$city_id,'fs_cities','*');
		$data = array();
		$data['price_ship'] = $city-> price_ship;
		$data['text_price_ship'] = format_money($city-> price_ship);

		echo json_encode ( $data );
	}

	function shopcart(){

		// echo '<pre>';
		// print_r($_SESSION['cart']);

		$model = $this -> model;	
		$sale=$model->get_sale_2();
		$cities  = $model -> get_cities();

		/*		print_r($sale);*/
		// get temporary data stored in fs_order:
		$session_order = $model -> getOrder();
		$user = $model -> get_user();
		// echo $user-> level; 
		if(@$user-> level) {
			$level_user = $model-> get_record('id='.@$user-> level,'fs_members_level','*');
		}

		if(@$user-> city_id) {
			$city_user = $model-> get_record('id = '.$user-> city_id,'fs_cities','*');

		}

		// print_r($level_user);die;
		$Itemid = FSInput::get('Itemid',0,'int');
		$action = FSInput::get('action');
		$cities = $model -> get_records('','fs_cities');

		
		
		// REQUIRE LOGIN
//			if(!isset($_COOKIE['username']) ){
//				if(!$session_order ) {
//					$link = FSRoute::_('index.php?module=products&view=cart&task=eshopcart&eid='.$eid.'&Itemid='.$Itemid);
//					setRedirect($link)
//				}
//			}
		// tổng giá để giảm tiếp
		$total_price_to_discount = 0;
		$gift_4_total = null;
		$count_products = 0;
		// if(isset($_COOKIE ['cart'])){
		// 	$product_list = json_decode($_COOKIE['cart'],true);

		// 	if (isset ( $product_list ) && $product_list) {
		// 		foreach ( $product_list as $item ) {
		// 			$total_price_to_discount += $item['price'] * $item['quantity'];
		// 			$count_products += $item['quantity'];

		// 		}
		// 	}
		// }
		
		
		
		$sale_alert = '';
		$sale_total_current = null;
		if($total_price_to_discount){
			$sales = $model->get_sales_total();
			$price_above = 0;
			$price_below = 0;
			$type_above = '';
			$type_below = '';
			foreach($sales as $sale){
				if($sale -> price_min > $total_price_to_discount){
					$price_above = $sale -> price_min;
					$type_above = $sale -> type; 
				}
				if($sale -> price_min <= $total_price_to_discount){
					$price_below = $sale -> price_min;
					$type_below = $sale -> type;
					$gifts = $model -> get_gifts_in_sale($sale -> id );
					$sale_total_current = $sale;
					break;
				}
			}

		}

		// Tính chiết khấu nếu có đăng nhập
		$total_before_discount_by_cardcode = 0;
		$total_discount_by_cardcode = 0;
		
	// 	if(!isset($session_order->total_discount_by_cardcode) || !$session_order->total_discount_by_cardcode){
	// 		if(isset($user )){
	// 			$date = date('Y-m-d');

	// 			if(@$user -> card_started_time <= $date && @$user -> card_end_time >= $date){
	// 				$chiet_khau = $user -> 	chiet_khau;
	// 				$card_code = $user -> card_code;
	// 			}
	// //			print_r($user);
	// //			die;

	// 			$total_before_discount_by_cardcode = 0;
	// 			$total_discount_by_cardcode = 0;

	// 			$total_before_discount = 0;
	// 			$total_after_discount = 0;
	// 			$products_count = 0;

	// 			// print_r($product_list);
	// 			// die;

	// 			// 	Repeat products	
	// 			if( !empty($product_list)){
	// 				for($i = 0; $i < count ( $product_list ); $i ++) {
	// 					$prd = @$product_list [$i];
	// 					$prd_id_array [] = $prd ['product_id'];

	// 					// cal
	// 					$total_before_discount += $prd ['price'] * $prd ['quantity'];
	// 					$products_count += $prd ['quantity'];

	// 					// loại sản phẩm được giảm giá tiếp cho thành viên
	// 					if(@$prd['is_total_shopcart']){
	// 						$total_before_discount_by_cardcode += 	$prd ['price'] * $prd ['quantity'];
	// 					}
	// 				}
	// 			}	
	// 			// số tiền chiết khấu cho thành viên ( check qua mã thẻ)
	// 			$total_discount_by_cardcode = $total_before_discount_by_cardcode * @$chiet_khau / 100;
	// 		}

	// 	}else{
	// 		$total_discount_by_cardcode  = $session_order->total_discount_by_cardcode;
	// 	}

		// breadcrumbs
		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Đơn hàng', 1 => '');
		global $tmpl;	
		$tmpl -> assign('breadcrumbs', $breadcrumbs);

		
		
		//input info
		$sender_name = isset($session_order-> sender_name)?$session_order-> sender_name:@$user->full_name;
		$sender_sex = isset($session_order->sender_sex)?$session_order->sender_sex:@$user -> sex;
		$sender_address = isset($session_order->sender_address)?$session_order->sender_address:@$user -> address;
		$sender_email = isset($session_order->sender_email)?$session_order->sender_email:@$user -> email;
		$sender_telephone = isset($session_order->sender_telephone)?$session_order->sender_telephone:@$user -> mobilephone;
		$sender_telephone = isset($session_order->sender_telephone)?$session_order->sender_telephone:@$user -> mobilephone;
		$sender_city = isset($session_order->sender_city)?$session_order->sender_city:@$user -> city_id;
		$sender_city = isset($session_order->sender_district)?$session_order->sender_district:@$user -> district_id;
		$card_code = isset($session_order->card_code)?$session_order->card_code:@$user -> card_code;
		// $total_discount_by_cardcode  = isset($session_order->total_discount_by_cardcode)?$session_order->total_discount_by_cardcode:0;
		// }
		
//			$discount_code = isset($session_order->discount_code)?$session_order->discount_code:'';

		if(isset($_COOKIE['user_id'])){
			$data_user = $model->get_record('id = '.$_COOKIE['user_id'],'fs_members');
			$data_user_email = $data_user->email;
			$addess_books = $model->get_records('user_id = '.$_COOKIE['user_id'],'fs_members_addess_book');
			$addess_books_default = $model->get_record('user_id = '.$_COOKIE['user_id'] . ' AND is_default = 1','fs_members_addess_book');
			if($addess_books_default){
				$data_user = $addess_books_default;
				$data_user -> email = $data_user_email;
				if($data_user-> city_id){
					$_SESSION['pick_province'] = $data_user->city_name;
					$_SESSION['pick_district'] = $data_user->district_name;
					$_SESSION['address'] = $data_user->address . ', '. $data_user->ward_name;
					// die;
					$district_user = $model-> get_records('city_id = '.$data_user-> city_id,'fs_districts','*');
					$ward_user = $model-> get_records('district_id = '.$data_user-> district_id,'fs_wards','*');

				}
				
			}

		}

		$list_bankings =  $model->get_records('published = 1','fs_bankings','*','ordering ASC');
		

		
		include 'modules/'.$this->module.'/views/'.$this->view.'/shopcart/simple.php';
	}

	function getProductById($product_id) {
		$model = $this -> model;
		return $model -> getProductById($product_id) ;
	}
	function getComboById($combo_id) {
		$model = $this -> model;
		return $model -> getComboById($combo_id) ;
	}
	function getProductCategoryById($category_id) {
		$model = $this -> model;
		return $model -> getProductCategoryById($category_id) ;
	}



	function recal_ajax(){
		$Itemid = FSInput::get('Itemid');
		$total_price = 0;
		$sale_total_gift = null;
		$model = $this -> model;
		$sid_change = FSInput::get('sid');	
		$quantity_change = FSInput::get('q_sid');
		if(isset($_COOKIE['cart'])) {
			// $product_list  = $_SESSION['cart'];
			$product_list = json_decode($_COOKIE['cart'],true);
			$products_new = array();
			$count_products = 0;
			// printr($product_list);
				// Repeat products
			for($i = 0; $i < count($product_list); $i ++) {
				$prd = $product_list[$i];
				if($prd['sid'] == $sid_change){
					$quantity = $quantity_change;
				}else{
					$quantity =$prd['quantity'];
				}
//					$color_price_old = FSInput::get('color_price_'.$prd[0]);
//					$color_price = FSInput::get('color_'.$prd[0]);
//					$color = $model -> get_record_by_id($color_price,'fs_products_price');
//					$price = $prd[2]- $color_price_old;
//					$price =$price +$color->price;
				if($quantity) {
					$b = $prd;
					$b['quantity']  = $quantity;
					$products_new[] = $b;
					$count_products ++;
				}		
			}




			// echo '==</br>';
			// printr($products_new);


			if(	$products_new){
				$quantity_gifts_total = 0;			
				$products_new1 = array();

				foreach($products_new as &$item){
						// 	else{
					$products_new1[]	= $item;
				}		


					// print_r($products_new1);
					// die('11');
				$product_list = $this-> update_price_cart($products_new1);

				$item_data = json_encode($product_list);
				setcookie('cart', $item_data, time() + (86400 * 30), '/');
				// $_SESSION['cart'] = $products_new1;

			}else{
					// die('22');
				// unset($_SESSION['cart']);
				setcookie('cart', null, -1, '/'); 
			}
	//			$_SESSION['cart'] = $products_new;
				// die;
				// if del all
			if(!$count_products) {
				include 'modules/'.$this->module.'/views/'.$this->view.'/shopcart/items.php';
				return;
			}
			
		}

		include 'modules/'.$this->module.'/views/'.$this->view.'/shopcart/items.php';
		return;

	}

	function recal_ajax_map(){
		$Itemid = FSInput::get('Itemid');
		$total_price = 0;
		$sale_total_gift = null;
		$model = $this -> model;
		if(isset($_COOKIE['cart'])) {
			$product_list = json_decode($_COOKIE['cart'],true);
			$products_new = array();
			$count_products = 0;
			for($i = 0; $i < count($product_list); $i ++) {
				$prd = $product_list[$i];
				$quantity =$prd['quantity'];
				if($quantity) {
					$b = $prd;
					$b['quantity']  = $quantity;
					$products_new[] = $b;
					$count_products ++;
				}		
			}

			if($products_new){
				$quantity_gifts_total = 0;			
				$products_new1 = array();

				foreach($products_new as &$item){
					$products_new1[]	= $item;
				}		
				// $product_list = $this-> update_price_cart($products_new1);

				$item_data = json_encode($product_list);
				setcookie('cart', $item_data, time() + (86400 * 30), '/');
			}else{
				setcookie('cart', null, -1, '/'); 
			}
			if(!$count_products) {
				include 'modules/'.$this->module.'/views/'.$this->view.'/shopcart/items.php';
				return;
			}
		}

		include 'modules/'.$this->module.'/views/'.$this->view.'/shopcart/items.php';
		return;
	}

	function check_show_vnpay(){
		$i = 0; 
		$id_last = 0;
		$total = 0;
		$quantity = 0;
		$cat_id_last = 0;
		$total_price_extent = 0;
		$product_list = json_decode($_COOKIE['cart'],true);
		foreach ($product_list as $prd) {
			$i++;
			$product = $this -> getProductById($prd['product_id']);
			if(!$product){
				continue;
			}
			$prd_name = $product -> name;
			if(@$prd['id_combo']) {
				$combo = $this -> getComboById($prd['id_combo']);
			} else {
				$combo = '';
			}
			$id_last = $prd['product_id'];
			$cat_id_last = $product -> category_id;
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
						$extend_item = $model -> get_record_by_id($extend_item_val,'fs_products_price_extend');
						$arr_info_extent[] = $extend_item-> extend_name . ": +" . format_money($extend_item-> price);
						$total_price_extent  += $extend_item-> price; 
					}
				}
			}
			
			if(!empty($arr_info_extent)){
				$string_info_extent =  implode(' ; ',$arr_info_extent);
			}
			$price_color = 0;
			$color_name = "";
			$color_id ="";
			$image_color = '';
			if($prd['color_id'] && $prd['color_id'] !=0){
				$data_price_color =  $model -> get_record('id = ' . $prd['color_id'] . ' AND record_id = ' . $product->id,'fs_products_price');
				if(!empty($data_price_color)){
					$price_color  = (int)$data_price_color-> price;
				}
			}
			$total +=  ($price_color + $total_price_extent + $prd['price'] ) * $prd['quantity'];
		}

		echo $total;
		return;
	}

	function recal(){
		$Itemid = FSInput::get('Itemid');
		$total_price = 0;
		$sale_total_gift = null;
		$model = $this -> model;
		if(isset($_COOKIE['cart'])) {
			// $product_list  = $_SESSION['cart'];
			$product_list = json_decode($_COOKIE['cart'],true);
			$products_new = array();
			$count_products = 0;
			// printr($product_list);
				// Repeat products
			for($i = 0; $i < count($product_list); $i ++) {
				$prd = $product_list[$i];
				$quantity = FSInput::get('quantity_'.$prd['sid']);	
//					$color_price_old = FSInput::get('color_price_'.$prd[0]);
//					$color_price = FSInput::get('color_'.$prd[0]);
//					$color = $model -> get_record_by_id($color_price,'fs_products_price');
//					$price = $prd[2]- $color_price_old;
//					$price =$price +$color->price;
				if($quantity) {
					$b = $prd;
					$b['quantity']  = $quantity;
					$products_new[] = $b;
					$count_products ++;
				}		
			}

			// echo '==</br>';
			// print_r($products_new)


			if(	$products_new){
				$quantity_gifts_total = 0;			
				$products_new1 = array();

				foreach($products_new as &$item){
						// 	else{
					$products_new1[]	= $item;
				}		


					// print_r($products_new1);
					// die('11');
				$product_list = $this-> update_price_cart($products_new1);

				$item_data = json_encode($product_list);
				setcookie('cart', $item_data, time() + (86400 * 30), '/');
				// $_SESSION['cart'] = $products_new1;

			}else{
					// die('22');
				// unset($_SESSION['cart']);
				setcookie('cart', null, -1, '/'); 
			}
	//			$_SESSION['cart'] = $products_new;
				// die;
				// if del all
			if(!$count_products) {
				$link = FSRoute::_('index.php?module=products&view=cart&task=shopcart');
				setRedirect($link);
			}
		}

		$link = FSRoute::_('index.php?module=products&view=cart&task=shopcart');
		setRedirect($link);
	}

	function update_cart($product_new){
		if($product_new) {
			$product_list  = $product_new;
			$product_list_2  = $product_new;
			foreach ($product_list as $key1 => &$item) {
				foreach ($product_list_2 as $key2=> $item2) {
					if($item['sid'] == $item2['sid'] && $key1 != $key2) {
						$item['quantity'] += $item2['quantity'];
						unset($product_list[$key2]);
					}
				}
			}
			$product_list = $this-> update_price_cart($product_list);
			$item_data = json_encode($product_list);
			setcookie('cart', $item_data, time() + (86400 * 30), '/');
		}

		$link = FSRoute::_('index.php?module=products&view=cart&task=shopcart');
		setRedirect($link);
	}

	
	// function edel() {
	// 	$pid = FSInput::get('id',0,'int');
	// 	$Itemid = FSInput::get('Itemid',0,'int');
	// 	// $color = FSInput::get('color',0,'int');
	// 	// $size = FSInput::get('size',0,'int');

	// 	if($pid) {
	// 		if(isset($_SESSION['cart'])) {
	// 			$product_list  = $_SESSION['cart'];

	// 			// count products of eid current:
	// 			$count_products_current = 0;
	// 			// Repeat estores
	// 			$products_new = array();

	// 					// Repeat products
	// 			for($i = 0; $i < count($product_list); $i ++) {
	// 				$prd = $product_list[$i];
	// 				if($pid == $prd[0])
	// 				{
	// 					continue;
	// 				}
	// 				else {
	// 					$products_new[] = $prd;
	// 				} 
	// 			}
	// 			$_SESSION['cart'] = $products_new;

	// 		}
	// 	}

	// 	$link = FSRoute::_('index.php?module=products&view=cart&task=eshopcart2&Itemid='.$Itemid);
	// 	setRedirect($link);
	// }


	function edel() {

		$pid = FSInput::get('id',0,'int');
		$sid = FSInput::get('sid');
		$sid = base64_decode($sid);
		$parent_product = FSInput::get('parent_product',0,'int');
		$combo = FSInput::get('id_combo');
		$no_services = FSInput::get('no_services',0,'int');
		$arr_sid = explode('_', $sid);
		$gift_4_product = @$arr_sid[3];
		$price_id = $arr_sid[1];
		$total_price = 0;
		$sale_total_gift = null;
		$model = $this -> model;
		// die;

		$Itemid = FSInput::get('Itemid',0,'int');
		if($pid) {
			if(isset($_COOKIE['cart'])) {

				$product_list = json_decode($_COOKIE['cart'],true);

				// printr($product_list);
				// echo '11';die;

				$products_new = array();

				if($pid == $parent_product) {
					
					foreach($product_list as &$item){
						if((@$item['parent_product'] == $parent_product && $item['product_id'] != $pid ) || (@$item['id_combo'] == $combo && $item['product_id'] != $pid && $combo) ) {

							$product_old = $model-> get_record('id = '.$item['product_id'],'fs_products','id, name, price, price_old');

							$check_sale_off_product_main = $model -> check_sale_off($product_old-> id);
							if($check_sale_off_product_main && $check_sale_off_product_main-> total_item > $check_sale_off_product_main-> total_item_buy){
								$product_old-> price = $check_sale_off_product_main-> price;
							}

							$item['price'] = $product_old-> price;
							$item['price_old'] = $product_old-> price_old;
							$item['sid'] =  $product_old-> id.'_'.'0';
							$item['is_combo'] = 0;
							$item['parent_product'] = 0;


						}

						if($item['sid'] == $sid || ( @$item['gift_4_product'] == $pid && $item['price_id'] == $price_id) ){ 
							
						}else{
							$products_new[]	= $item;
							if(@$item['is_total_shopcart']){
								$total_price += $item['price'] * $item['quantity'];	
							}							
							// Lấy quà tổng ( nếu có)	
							if(@$item['type'] == 'totalhasgift'  && @$item['is_gift'] && $item['sale_id'] ){
								$sale_total_gift = $model -> get_sale( $item['sale_id']);				
							}
						}
					}
				} else {

					// echo '1111';die;
					// print_r($product_list);
					// echo 'sid:'.$sid;die;

					
					foreach($product_list as &$item){
						// if(@$item['id_combo'] == $combo && $item['product_id'] != $pid && $combo) {
							
						// 	$product_old = $model-> get_record('id = '.$item['product_id'],'fs_products','id, name, price, price_old');

						// 	$check_sale_off_product_main = $model -> check_sale_off($product_old-> id);
						// 	if($check_sale_off_product_main) {
						// 		$product_old-> price = $check_sale_off_product_main-> price;
						// 	// $data-> sale_off =1;
						// 	}

						// 	$item['price'] = $product_old-> price;
						// 	$item['price_old'] = $product_old-> price_old;
						// 	$item['sid'] =  $product_old-> id.'_'.'0';
						// 	$item['is_combo'] = 0;
						// 	$item['id_combo'] = 0;
						// 	$item['parent_product'] = 0;


						// }

						// echo $sid;die;

						// if($item['no_services'] == $no_services) {
						// 	echo '11111111111111111';die;
						// }
						// echo '222222222222222';die;
						if(($item['sid'] == $sid && $item['no_services'] == $no_services) || ( @$item['gift_4_product'] == $pid && $item['price_id'] == $price_id) ){ 

						}else{
							$products_new[]	= $item;
							if(@$item['is_total_shopcart']){
								$total_price += $item['price'] * $item['quantity'];	
							}							
							// Lấy quà tổng ( nếu có)	
							if(@$item['type'] == 'totalhasgift'  && @$item['is_gift'] && $item['sale_id'] ){
								$sale_total_gift = $model -> get_sale( $item['sale_id']);				
							}
						}
					}
				}

				// print_r($products_new);die;


				if(	$products_new){
					
					$quantity_gifts_total = 0;			
					if(isset($sale_total_gift) && $total_price && $sale_total_gift -> price_min <= $total_price  ){
						$quantity_gifts_total = floor($total_price/$sale_total_gift -> price_min);
					}

					$products_new1 = array();
					foreach($products_new as &$item){

										// Lấy quà tổng ( nếu có)	
						if(@$item['type'] == 'totalhasgift'  && $item['is_gift'] && $item['sale_id'] ){

							if($quantity_gifts_total ){
								$b = $item;
								$b['quantity'] = $quantity_gifts_total;
								$products_new1[]	= $b;
							}
						}else{
							$products_new1[]	= $item;
						}

					}		
							 // print_r($products_new1);
							 // die('11');
					$this-> update_cart($products_new1);
					// $_SESSION['cart'] = $products_new1;

				}else{
						 // die('22');
					setcookie('cart', null, -1, '/'); 
					// unset($_SESSION['cart']);
				}


			}
		}
	 // die('33');
		$link = FSRoute::_('index.php?module=products&view=cart&task=shopcart');
		// $this-> update_cart();
		setRedirect($link);
	}









	function del_all() {
		setcookie('cart', null, -1, '/'); 
		$link = FSRoute::_('index.php?module=products&view=cart&task=shopcart');
		setRedirect($link);
	}

		/*
		 * Tính lại chiết khấu
		 */
		function resubmit_form(){
			$model = $this -> model;	
			$Itemid = FSInput::get('Itemid',0,'int');
			// get temporary data stored in fs_order:
			$order_id = $model -> shopcart_save();
			// die;
			$Itemid = FSInput::get('Itemid',0,'int');
			if($order_id) {
				$link = FSRoute::_('index.php?module=products&view=cart&task=shopcart&Itemid='.$Itemid);
				setRedirect($link);
			} else {
				$link = FSRoute::_('index.php?module=products&view=cart&task=shopcart&Itemid='.$Itemid);
				setRedirect($link);
			}
			
		}


/*
		 * function save info of sender and recipient
		 */
function shopcart_save(){
	global $config;
	$model = $this -> model;
	$is_vnpay = FSInput::get('is_vnpay',0,'int');

	$order_id = $model -> shopcart_save();
	$Itemid = FSInput::get('Itemid',0,'int');

	if($order_id) {
		$data = $model->get_record('id = ' . $order_id,'fs_order');
		if(!empty($data) AND $data-> shipping_unit == 2){
			$date = date('Y-m-d');
			$list_products = $model -> get_records('order_id = '.$order_id,'fs_order_items','product_id,count,weight');
			$i_list_products = 0;
			$list_products_gh = array();
			$total_weight = 0;
			foreach($list_products as $gh_product) {
				$gh_pro = $model -> get_record('id = '.$gh_product-> product_id,'fs_products','id,name,category_id');
				// $cat = $model->get_record('id = '.$gh_pro->category_id,'fs_products_categories','kilogam');
				
				$list_products_gh[$i_list_products]['name'] = $gh_pro-> name;
				$list_products_gh[$i_list_products]['quantity'] = $gh_product-> count;
				$list_products_gh[$i_list_products]['weight'] = $gh_product-> weight;
				
				$total_weight = $total_weight + $list_products_gh[$i_list_products]['quantity'] * $list_products_gh[$i_list_products]['weight'];
				$i_list_products++;
			}

			// số tiền thu hộ
			if($data->is_vnpay == 1){
				$pick_money  = 0;
			}elseif ($data->is_vnpay == 2) {
				$pick_money  = 0;
			}else{
				$pick_money  = (float)$data-> total_after_discount;
			}

			
			//phí ship có free hay ko, nếu = 1 là có
			if($config['free_ships'] == 1){
				$is_freeship = 1;
			}elseif($config['free_ship_pay_online'] == 1){
				if(isset($_SESSION['pay_method']) && $_SESSION['pay_method'] == 2){
					$is_freeship = 1;
				}
			}else{
				$is_freeship = 0;
			}

			

			$data_ghtk =  array(
				'products' => $list_products_gh,
				'order' => array(
					'id' => 'DH'.str_pad($data -> id, 8 , "0", STR_PAD_LEFT),
					"pick_name"=> $config['ghtk_pick_name'],
					"pick_address"=> $config['ghtk_pick_address'],
					"pick_province"=> $config['ghtk_pick_province'],
					"pick_district"=> $config['ghtk_pick_district'],
					"pick_ward"=> $config['ghtk_pick_ward'],
					"pick_tel"=> $config['ghtk_pick_tel'],
					"tel"=> $data-> sender_telephone,
					"name"=> $data-> sender_name,
					"address"=> $data-> sender_address,
					"province"=> $data-> city_name,
					"district"=> $data-> district_name,
					"ward" => $data-> ward_name,
					"hamlet" => "Khác",
					"is_freeship"=>$is_freeship,
					"pick_date"=> $date,
					"pick_money"=>$pick_money,
					"note"=>$data-> sender_comments,
					"value"=>0,
					"transport"=> 'road',
					"total_weight" => $total_weight
				)
			);

			$data_string = json_encode($data_ghtk);
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => "https://services.giaohangtietkiem.vn/services/shipment/order",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS =>$data_string,
				CURLOPT_HTTPHEADER => array(
					"token: ".TOKEN_GHTK,
					"Content-Type: application/json"
				),
			));

			$result = curl_exec($curl);
			curl_close($curl);
			
			
			$result_decode = json_decode($result, true);
			// printr($result_decode);
			// echo '<pre>';
			// echo $result_decode['success'];
			// die;
			if((int)$result_decode['success'] == 1) {
				$rowgh = array();
				$rowgh['is_ghtk'] = 1;

				if($config['free_ships'] == 1){
					$rowgh['shipping_money'] = 0;
					$rowgh['shipping_note'] = "Miễn phí phí vận chuyển";
				}elseif($config['free_ship_pay_online'] == 1){
					

					if(isset($_SESSION['pay_method']) && $_SESSION['pay_method'] == 2){
						$rowgh['shipping_money'] = 0;
						$rowgh['shipping_note'] = "Miễn phí phí vận chuyển do thanh toán online 100%";
					}else{
						$rowgh['shipping_money'] = $result_decode['order']['fee'];
						$rowgh['total_after_discount'] = (float)$data-> total_after_discount + (float)$result_decode['order']['fee'];
					}
				}else{
					

					$rowgh['shipping_money'] = $result_decode['order']['fee'];
					$rowgh['total_after_discount'] = (float)$data-> total_after_discount + (float)$result_decode['order']['fee'];
				}

				// printr($rowgh);

				$model-> _update($rowgh,'fs_order', 'id = '.$data-> id);
			}else{
				$rowgh = array();
				$rowgh['is_ghtk'] = 1;
				$rowgh['shipping_money'] = 0;
				$rowgh['shipping_note'] = "Chưa tính được phí ship!. Liên hệ lại";
				$model-> _update($rowgh,'fs_order', 'id = '.$data-> id);
			}
			// echo "<pre>";
			// print_r($rowgh);

			// printr($result_decode);
			// curl_close ($ch);
		}


		//vnpay
		if($is_vnpay == 1){
			$vnp_Returnurl  = FSRoute::_('index.php?module=products&view=cart&task=finished&id='.$order_id.'&Itemid='.$Itemid);
			$bank_code = FSInput::get('bank_code');
			
			if(!empty($data)){
				require('libraries/vnpay_php/config.php');
				$vnp_TxnRef = $order_id;
				$vnp_OrderInfo = ($data-> sender_comments AND $data-> sender_comments != '') ? $data-> sender_comments : 'mua online';
				$vnp_OrderType = 'other';
				$vnp_Amount = $data-> total_after_discount * 100;
				$vnp_Locale = 'vn';
				$vnp_BankCode = $bank_code;
				$vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
				$inputData = array(
					"vnp_Version" => "2.0.0",
					"vnp_TmnCode" => $vnp_TmnCode,
					"vnp_Amount" => $vnp_Amount,
					"vnp_Command" => "pay",
					"vnp_CreateDate" => date('YmdHis'),
					"vnp_CurrCode" => "VND",
					"vnp_IpAddr" => $vnp_IpAddr,
					"vnp_Locale" => $vnp_Locale,
					"vnp_OrderInfo" => $vnp_OrderInfo,
					"vnp_OrderType" => $vnp_OrderType,
					"vnp_ReturnUrl" => $vnp_Returnurl,
					"vnp_TxnRef" => $vnp_TxnRef,
				);

				if (isset($vnp_BankCode) && $vnp_BankCode != "") {
					$inputData['vnp_BankCode'] = $vnp_BankCode;
				}
				ksort($inputData);
				$query = "";
				$i = 0;
				$hashdata = "";
				foreach ($inputData as $key => $value) {
					if ($i == 1) {
						$hashdata .= '&' . $key . "=" . $value;
					} else {
						$hashdata .= $key . "=" . $value;
						$i = 1;
					}
					$query .= urlencode($key) . "=" . urlencode($value) . '&';
				}

				$vnp_Url = $vnp_Url . "?" . $query;
				if (isset($vnp_HashSecret)) {
				   // $vnpSecureHash = md5($vnp_HashSecret . $hashdata);
					$vnpSecureHash = hash('sha256', $vnp_HashSecret . $hashdata);
					$vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
				}
				// $returnData = array('code' => '00'
				//     , 'message' => 'success'
				//     , 'data' => $vnp_Url);
				// echo json_encode($returnData);
				// die;
				$send_mail  = $model -> mail_to_buyer($order_id);
				header('Location:'.$vnp_Url);
				
			}
			
		}else{
			

			if(isset($_SESSION['pay_method'])){
				unset($_SESSION['pay_method']);
			}

			if(isset($_SESSION['destination'])){
				unset($_SESSION['destination']);
			}

			if(isset($_SESSION['sesstion_km_ship'])){
				unset($_SESSION['sesstion_km_ship']);
			}

			if(isset($_SESSION['pay_method'])){
				unset($_SESSION['pay_method']);
			}

			if(isset($_SESSION['code_sale_input'])){
				unset($_SESSION['code_sale_input']);
			}


			if(isset($_SESSION['code_sale_message'])){
				unset($_SESSION['code_sale_message']);
			}

			if(isset($_SESSION['code_sale_price_down'])){
				unset($_SESSION['code_sale_price_down']);
			}



			$send_mail  = $model -> mail_to_buyer($order_id);
			$link = FSRoute::_('index.php?module=products&view=cart&task=finished&id='.$order_id.'&Itemid='.$Itemid);
			setRedirect($link,'Đơn hàng của bạn đã được gửi đi. Chúng tôi sẽ liên lạc với bạn trong thời gian sớm nhất. Xin cảm ơn!');
		}

		
	} else {
		$link = FSRoute::_('index.php?module=products&view=cart&task=order&Itemid='.$Itemid);
		setRedirect($link);
	}

}


		/*
		 * function save info of sender and recipient
		 */
		function eshopcart2_save(){

			//die();

			$product_id   = FSInput::get('id',0,'int'); // product_id
			$color_id  = FSInput::get('color'); 
			$extend_price_n = array();
		//	$extend_price_n = FSInput::get('extend_price_n'); 
			//print_r($extend_price_n);
			//die();
			$memory_id = FSInput::get('memory'); 
			$usage_states_id = FSInput::get('usage_states'); 
			$region_id = FSInput::get('region');
			$warranty_id = FSInput::get('warranty'); 
			$origin_id = FSInput::get('origin'); 
			$species_id = FSInput::get('species'); 
			$price = FSInput::get('price'); 
			$quantity = FSInput::get('quantity',1,'int'); 

			$price_fix = FSInput::get('price_fix');
			$type_down = FSInput::get('type_down');
			$code_sale = FSInput::get('code_sale');
			$price_send = FSInput::get('price_send');


			$model = $this -> model;	
			$product_list = array();

			$step_data = base64_encode(serialize($_REQUEST));
			$arr_unset = array('module','view','code','id','Itemid','ccode','color','species','quantity','sender_name','sender_telephone','sender_address','city_receiver','method_receiver','price','price_old','task');
			$step_data = unserialize(base64_decode($step_data));
			foreach($arr_unset as $item){
				unset($step_data[$item]);
			}
			// echo "++++++++++++++++++++++++++++++++++++<br>";
			$extend_price_n = ($step_data['extend_price_n']);
			$extend_price = ','; 
			foreach ($extend_price_n as $extend_price_i) {
				$extend_price .= $extend_price_i.',';

			}
			$extend_price;

		//die();
			// if(!isset($_SESSION['cart'])) {
			$product_list[] = array($product_id,$price,$quantity,$color_id,$memory_id,$warranty_id,$origin_id,$species_id,$usage_states_id,$region_id,$extend_price,$price_fix,$type_down,$code_sale,$price_send);
			$_SESSION['cart']  = $product_list  ;
			// 			print_r($product_list);
			// die();

			// }
			
			$session_order = $model -> eshopcart2_save();
		//	$session_order = $model -> eshopcartsms_save();
		//	echo $session_order."dfdfdf";
		//	die;
			if($session_order) {
			//	echo $session_order;
			//	die();
				//echo "Dfdfd";
				//die();
				// $send_sms = $model -> sms_to_buyer($session_order);
				$send_mail  = $model -> mail_to_buyer($session_order);

				$link = FSRoute::_('index.php?module=products&view=cart&task=finished&id='.$session_order);
				setRedirect($link,'Bạn đã đặt hàng thành công. Chúng tôi sẽ liên lạc với bạn trong thời gian sớm nhất. Xin cảm ơn!');
			} else {
				//	echo "Dfdfdhhhhhhhhhhhhhhhhhhhhhhhhhhhhh";
				//die();
				$link = FSRoute::_('index.php?module=products&view=cart&task=order');
				setRedirect($link);
			}
		}

		
		function finished() {
			$model = $this -> model;	
			$order = $model -> getOrderById();
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=>'Thanh toán', 1 => '');
			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);

			if($order){
				$order_detail = $model -> get_orderdetail_by_orderId($order->id);
				// print_r($order_detail);die;
				$i = 0;
				$str_product_ids = '';
				foreach($order_detail as $item){
					if($i > 0)
						$str_product_ids .= ',';
					$str_product_ids .= $item -> product_id;	
					$i ++;
				}

				$products = $model -> get_products_from_orderdetail($str_product_ids);
				if(!$order_detail){
					echo "Bạn hãy chọn và thanh toán sản phẩm";
					return;
				}
				include 'modules/'.$this->module.'/views/'.$this->view.'/finished/finished.php';
			} else {

				echo "B&#7841;n h&#227;y ch&#7885;n v&#224; thanh to&#225;n s&#7843;n ph&#7849;m1";
				return;
			}
		}


		function finished_ipn_vnpay() {
			$model = $this -> model;
			$id = $_GET['vnp_TxnRef'];

			$order = $model -> getOrderByIdVnpay($id);
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=>'Xác thực VNPAY', 1 => '');
			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			include 'modules/'.$this->module.'/views/'.$this->view.'/finished/finished_ipn_vnpay.php';
			
		}

		function ajax_get_user_from_card() {
			$model = $this -> model;	
			$user = $model -> ajax_get_user_from_card();
			$date = date('Y-m-d');
			if(!$user){
				$result  = array ('message' => 'Mã số thẻ không đúng');
			}elseif($user -> card_started_time > $date || $user -> card_end_time < $date){

				$result  = array ('message' => 'Thẻ đã hết hạn');	
			}else{
				$result = array ('full_name' => $user -> full_name, 'mobilephone' => $user -> mobilephone, 'address' => $user -> address, 'email' => $user -> email , 'message'=> '');
			}


			echo json_encode ( $result );


			return;
		}


		function ajax_get_addess_book(){
			$model = $this -> model;
			$id = FSInput::get('id');
			if(!$id){
				return;
			}
			$add = $model ->get_record('id ='.$id,'fs_members_addess_book');
			$data = array();
			if(!empty($add)){
				$data['full_name'] = $add->full_name;
				$data['telephone'] =  $add->telephone;
				$data['email'] =  $add->email;
				$data['address'] = $add->address;
				$city = '';
				if($add->city_id){
					$data_city = $model ->get_records('published = 1','fs_cities');
					foreach ($data_city as $item) {
						if($item->id==$add->city_id){
							$city .= '<option selected value='.$item->id.' latitude_warehouse='.$item->latitude_warehouse.' longitude_warehouse='.$item->longitude_warehouse.' latitude='.$item->latitude.' longitude='.$item->longitude.' >'.$item->name.'</option>';
						}else{
							$city .= '<option value='.$item->id.' latitude_warehouse='.$item->latitude_warehouse.' longitude_warehouse='.$item->longitude_warehouse.' latitude='.$item->latitude.' longitude='.$item->longitude.' >'.$item->name.'</option>';
						}
						
					}
				}
				$data['city_id'] = $city;


				$district = '';
				if($add->district_id){
					$data_district = $model ->get_records('published = 1 AND city_id = '. $add->city_id ,'fs_districts');
					foreach ($data_district as $item) {
						if($item->id==$add->district_id){
							$district .= '<option selected value='.$item->id.' latitude='.$item->latitude.' longitude='.$item->longitude.' >'.$item->name.'</option>';
						}else{
							$district .= '<option value='.$item->id.' latitude='.$item->latitude.' longitude='.$item->longitude.' >'.$item->name.'</option>';
						}
						
					}
				}
				$data['district_id'] = $district;


				$ward = '';
				if($add->ward_id){
					$data_ward = $model ->get_records('published = 1 AND district_id = '. $add->district_id ,'fs_wards');
					foreach ($data_ward as $item) {
						if($item->id==$add->ward_id){

							$ward .= '<option selected value='.$item->id.' latitude='.$item->latitude.' longitude='.$item->longitude.' >'.$item->name.'</option>';
							$ward_id = $item->id;
							$ward_ss = $model -> get_record('id  = ' . $ward_id,'fs_wards');
							$district_ss = $model -> get_record('id  = ' . $ward_ss -> district_id,'fs_districts');
							$city_ss = $model -> get_record('id  = ' . $ward_ss -> city_id,'fs_cities');
							// $_SESSION['set_session_address'] = $add->address.', '.$ward_ss->name . ', '.$district_ss->name . ', '.$city_ss->name;
							$_SESSION['address'] = $ward_ss->name;
							if($add->address && !empty($add->address) && $add->address != ''){
								$_SESSION['address'] = $add->address . ', '. $ward_ss->name;
							}
							
							$_SESSION['pick_province'] = $city_ss->name;
							$_SESSION['pick_district'] = $district_ss->name;


						}else{
							$ward .= '<option value='.$item->id.' latitude='.$item->latitude.' longitude='.$item->longitude.' >'.$item->name.'</option>';
						}
					}

				}
				$data['ward_id'] = $ward;

				echo json_encode ( $data );
				return;
			}else{
				return;
			}
		}

		function ajax_check_is_district_free(){
			$model = $this -> model;
			$district_id = FSInput::get('district_id');
			if(!$district_id){
				return false;
			}
			
			$data_district = $model ->get_record('id = '. $district_id ,'fs_districts');
			if(!empty($data_district) && $data_district->free_ship == 1){
				echo 1;
				return;
			}else{
				echo 0;
				return;
			}
			
		}

		function ajax_unset_sesstion_km_ship(){
			unset($_SESSION['sesstion_km_ship']);
			echo 1;
			return;
		}

		function ajax_set_sesstion_km_ship(){
			$is_district_free = FSInput::get('is_district_free');
			$destination = FSInput::get('destination');
			$km_ship = FSInput::get('in_kilo');

			if(!$km_ship && $destination){
				return false;
			}
			if($is_district_free == 1){
				$_SESSION['sesstion_km_ship'] = 30; // quận huyện này được free ship set = 30 thì sẽ trả về 0 km
			}else{
				$_SESSION['sesstion_km_ship'] = round($km_ship, 1);
			}

			
			echo 1;
			return;
		}


		function set_session_address(){
			$model = $this -> model;
			$ward_id = FSInput::get('ward_id');
			$ward = $model -> get_record('id  = ' . $ward_id,'fs_wards');
			$district = $model -> get_record('id  = ' . $ward -> district_id,'fs_districts');
			$city = $model -> get_record('id  = ' . $ward -> city_id,'fs_cities');
			$address_user = FSInput::get('address_user');;
			if($address_user && !empty($address_user) && $address_user != ''){
				$_SESSION['address'] = $address_user . ', '. $ward->name;
			}

			$_SESSION['pick_province'] = $city->name;

			$_SESSION['pick_district'] = $district->name;

			echo 1;
			return;
		}

		function ajax_set_seetion_pay_method(){
			$model = $this -> model;
			$pay_method = FSInput::get('pay_method');
			if($pay_method == 1){
				$_SESSION['pay_method'] = 1;
			}
			elseif($pay_method == 2){
				$_SESSION['pay_method'] = 2;
			}
			else{
				$_SESSION['pay_method'] = 0;
			}
			echo 1;
			return;
			
		}

		function ajax_get_lat_lng_warehouse(){
			$warehouse_id = FSInput::get('warehouse_id',0,'int');
			$model = $this -> model;
			$city =$model-> get_record('id = '.$warehouse_id,'fs_warehouse','*');
			$data = array();
			$data['latitude'] = $city-> latitude;
			$data['longitude'] = $city-> longitude;
			echo json_encode ( $data );
			return;
		}

		function ajax_get_lat_lng_ward(){
			$ward_id = FSInput::get('ward_id',0,'int');
			$model = $this -> model;
			$city =$model-> get_record('id = '.$ward_id,'fs_wards','*');
			$data = array();
			$data['latitude'] = $city-> latitude;
			$data['longitude'] = $city-> longitude;
			echo json_encode( $data );
			return;
		}


		function get_ward(){
			$model  = $this -> model;
			$cid = FSInput::get('cid');
			$rs  = $model -> get_records('district_id = '. $cid,'fs_wards','id,name,latitude,longitude');

			$data = array ('error' => true, 'message' => '', 'html' => '<option value="">Chọn Xã phường</option>' );

			if($rs){
				foreach ( $rs as $item ) {
					$data ['html'] .= '<option latitude="' . $item->latitude . '" longitude="' . $item->longitude . '" value="' . $item->id . '">' . $item->name . '</option>';
				}
			}
			$data ['error'] = false;
			echo json_encode ( $data );
			return;

		}



		function get_district(){
			$model  = $this -> model;
			$cid = FSInput::get('cid');
			$rs  = $model -> get_records('city_id = '. $cid,'fs_districts','id,name,latitude,longitude');

			$data = array ('error' => true, 'message' => '', 'html' => '<option value="">Chọn Quận huyện</option>' );

			if($rs){
				foreach ( $rs as $item ) {
					$data ['html'] .= '<option latitude="' . $item->latitude . '" longitude="' . $item->longitude . '" value="' . $item->id . '">' . $item->name . '</option>';
				}
			}
			$data ['error'] = false;
			echo json_encode ( $data );
			return;

		}


	}

	?>
