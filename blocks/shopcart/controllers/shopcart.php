<?php
/*
 * Huy write
 */
	// models 
	include 'blocks/shopcart/models/shopcart.php';
	
	class ShopcartBControllersShopcart
	{
		function __construct()
		{
		}
		function display($parameters,$title){
			$style = $parameters->getParams('style');
			$style = $style ? $style : 'default';

			$model = new ShopcartBModelsShopcart();
			
			

			if($style == 'dropdown'){
				$total_price = 0;

				$quantity = 0;
				$str_ids = '';
				if(isset($_SESSION['cart'])) {
					$product_list = $_SESSION['cart'];
					$i = 0; 
					if($product_list) {


						foreach ($product_list as $item) {
					  		$i++;
					  		$total_price += $item['price'] * $item['quantity'];
							$quantity += $item['quantity'];
							if ($str_ids)
								$str_ids .= ',';
							$str_ids .= $item['product_id'];
						}

						// tính chiết khấu	
						$session_order = $model -> getOrder();
						$user = $model -> get_user();

						
						// Tính chiết khấu nếu có đăng nhập
						$total_before_discount_by_cardcode = 0;
						$total_discount_by_cardcode = 0;
						$chiet_khau =  0;

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

			  		}
				}
				
				if($str_ids)
					$arr_products = $model -> get_products_by_ids($str_ids);
			}
			// call views
			include 'blocks/shopcart/views/shopcart/'.$style.'.php';
		}
	}
	
?>