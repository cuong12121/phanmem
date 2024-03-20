<div class="ship-mn cls">
	<?php
		$data_ships =  $model->get_records('published = 1','fs_ships');
		if($ship_HL == 1 AND !empty($data_ships)){
			if(isset($_SESSION['sesstion_km_ship']) && $_SESSION['sesstion_km_ship'] > 30){
				$km_ship = $_SESSION['sesstion_km_ship'] - 30;
			}
			else{
				$km_ship = '';
			}
			
			if($km_ship != '' && $km_ship > 0){
				//Tìm loại xe có trọng lượng cao nhất
				$get_max_kg = $model->get_record('published = 1','fs_ships','MAX(kilogam_max) as max_kg');
				$max_kg = $get_max_kg->max_kg;
				$check_ship_max = $model->get_record('published = 1 AND kilogam_max = '.$max_kg ,'fs_ships');

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
						$check_ship = $model-> get_record('published = 1 AND kilogam_min < ' . $total_kg_still . ' AND kilogam_max >= ' . $total_kg_still ,'fs_ships');
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
					$check_ship = $model-> get_record('published = 1 AND kilogam_min < ' . $total_kg . ' AND kilogam_max >= ' . $total_kg ,'fs_ships');
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
				}

				if($config['free_ship_pay_online'] == 1){
					if(isset($_SESSION['pay_method']) && $_SESSION['pay_method'] == 2){
						$price_ship = 0;
					}
				}


			}
		}
	?>



	<font><?php echo FSText::_('Phí vận chuyển');?>: </font>
	<span class="price_ship1">
		Chúng tôi sẽ liên hệ lại với bạn sau.
	</span>
	<?php if(1==2){ ?>
	<span class="price_ship">
		<?php

			if($ship_HL == 1 && !isset($_SESSION['sesstion_km_ship'])) {
				echo "Chưa tính được !";
				echo '<input type="hidden" id="price_ship" value="0">';
				echo '<input type="hidden" id="check_ship_HL" value="1">';
			} 
			elseif($ship_HL == 1 && $km_ship == 0 && $check_set_kg == 1 ){
				echo "Miễn phí vận chuyển.(Đơn vị vận chuyển Hải Yến)";
				echo '<input type="hidden" id="price_ship" value="0">';
				echo '<input type="hidden" id="check_ship_HL" value="1">';
			}
			elseif($ship_HL == 1 && !empty($check_ship) && $km_ship > 0 && $total_kg <= 0 && $check_set_kg == 0) {
				echo "Chưa tính được trọng lượng của sản phẩm. Chúng tôi sẽ liên hệ lại với bạn.";
				echo '<input type="hidden" id="price_ship" value="0">';
				echo '<input type="hidden" id="check_ship_HL" value="1">';
				
			}
			elseif($ship_HL == 1 && !empty($check_ship) && $km_ship > 0 && $check_set_kg == 1) {
				if((int)$config['free_ships'] == 1){
					echo "Miễn phí vận chuyển.(Đơn vị vận chuyển Hải Yến)";
					echo '<input type="hidden" id="price_ship" value="0">';
					echo '<input type="hidden" id="check_ship_HL" value="1">';
				}else{
					echo format_money($price_ship,$current = '₫',$text_if_rezo = '0') . ' (Đơn vị vận chuyển Hải Yến)';
					$total += $price_ship;
					echo '<input type="hidden" id="price_ship" value="'.$price_ship.'">';
					echo '<input type="hidden" id="check_ship_HL" value="1">';
				}
				
			}
			else{ //GHTK


				if($total_kg > 0 && $check_set_kg == 1){
					if(isset($_SESSION['pick_province']) && isset($_SESSION['pick_district']) && isset($_SESSION['address'])){
						$data_set_ghtk = array(
					        "pick_province" => $config['ghtk_pick_province'],
					        "pick_district" => $config['ghtk_pick_district'],
					        "pick_ward"=> $config['ghtk_pick_ward'],
					        "pick_address"=> $config['ghtk_pick_address'],
					        "province" => $_SESSION['pick_province'],
					        "district" => $_SESSION['pick_district'],
					        "address" => $_SESSION['address'],
					        "weight" => $total_kg * 1000,
					        "value" => $total,
					        "transport" => "road"
					    );

						// printr($data_set_ghtk);


						$curl = curl_init();

						curl_setopt_array($curl, array(
						    CURLOPT_URL => "https://services.giaohangtietkiem.vn/services/shipment/fee?" . http_build_query($data_set_ghtk),
						    CURLOPT_RETURNTRANSFER => true,
						    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						    CURLOPT_HTTPHEADER => array(
						        "Token: ".TOKEN_GHTK,
						    ),
						));

						$result = curl_exec($curl);
						curl_close($curl);
					    $result_decode = json_decode($result, true);
						
						// printr($result_decode);
				
					    if(!empty($result_decode) && $result_decode['fee']['delivery'] == 1 ){
					    	if($config['free_ships'] == 1){
					    		echo "Miễn phí vận chuyển.(Đơn vị vận chuyển GHTK)";
								echo '<input type="hidden" id="price_ship" value="0">';
								echo '<input type="hidden" id="check_ship_HL" value="0">';
					    	}else{
					    		$price_ship = $result_decode['fee']['fee'];
					    		//giảm 50% khi thanh toán bằng vnpay
								if(isset($_SESSION['pay_method']) && $_SESSION['pay_method'] == 1){
									$price_ship = round($price_ship / 2);
								}
								if($config['free_ship_pay_online'] == 1){
									if(isset($_SESSION['pay_method']) && $_SESSION['pay_method'] == 2){
										$price_ship = 0;
									}
								}
						    	$total += $price_ship;
						    	echo format_money($price_ship,$current = '₫',$text_if_rezo = '0') . ' (Đơn vị vận chuyển GHTK)';
						    	echo '<input type="hidden" id="price_ship" value="'.$price_ship.'">';
								echo '<input type="hidden" id="check_ship_HL" value="0">';
					    	}
					    }else{
					    	echo "Khu vực này GHTK không hỗ trợ giao hàng. Chúng tôi sẽ liên hệ lại với bạn sau !";
					    }
					}else{
						echo "Nhập đủ địa chỉ để tính phí ship";
					}
				}else{
					echo "Chưa tính được trọng lượng của sản phẩm. Chúng tôi sẽ liên hệ lại với bạn.";
				}
				
			}

		?>	
	</span>

	<?php } ?>



</div>