
<?php 
	class ProductsModelsInstalment extends FSModels
	{
		var $limit;
		var $page;
		function __construct()
		{
			
		}
		function  get_product(){
			$fs_table = FSFactory::getClass ( 'fstable' );
			$select = "*";
			$where = "published = 1 and category_published = 1";
			$result = $this->get_records( $where, $fs_table->getTable ( 'fs_products' ) );
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
		function get_price_by_colors($record_id) {
			if (! $record_id)
				return;
			$limit = 10;
			$fs_table = FSFactory::getClass ( 'fstable' );
			$query = " SELECT *
							  FROM " . $fs_table->getTable ( 'fs_products_price' ) . "
							  WHERE record_id =  $record_id
							   ORDER BY  price DESC
							 ";
			global $db;
			$sql = $db->query ( $query );
			$result = $db->getObjectList ();
			return $result;
		}




			function get_price_by_extend($record_id, $group_id) {
		if (! $record_id)
			return;
		$limit = 10;
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = " SELECT *
		FROM " . $fs_table->getTable ( 'fs_products_price_extend' ) . "
		WHERE record_id =  $record_id AND group_extend_id = $group_id
		ORDER BY  price DESC
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
		ORDER BY  price DESC
		";
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}

		

		/*******ALEPAY ***********/
		/*
		 * Save new data into fs_order
		 * For 1 case: member buy
		 */
		function alepay_eshopcart_save(){
			$product_id   = FSInput::get('id',0,'int'); // product_id
			$color_id  = FSInput::get('color'); 
			$memory_id = FSInput::get('memory'); 
			$usage_states_id = FSInput::get('usage_states'); 
			$region_id = FSInput::get('region'); 
			$warranty_id = FSInput::get('warranty'); 
			$origin_id = FSInput::get('origin'); 
			$species_id = FSInput::get('species'); 
			$price = FSInput::get('price'); 
			$quantity = 1; 
	
			
			$product_list = array();

			
			$product_list[] = array($product_id,$price,$quantity,$color_id,$memory_id,$warranty_id,$origin_id,$species_id,$usage_states_id,$region_id);
			$_SESSION['cart']  = $product_list  ;
		 


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
			 	
			 	// $total_before_discount += $prd[1]*$prd[2]; 

			   // calculator color
			
			 	$color = $this -> get_record_by_id($prd[3],'fs_products_price');
			 	if(!empty( $color))
					$total_before_discount = $total_before_discount + $color->price;
			   
			   // calculator memory
			    $memory = $this -> get_record_by_id($prd[4],'fs_memory_price');
			    if(!empty( $memory))
					$total_before_discount = $total_before_discount + $memory->price;


				// calculator memory
			    $warranty = $this -> get_record_by_id($prd[5],'fs_warranty_price');
			    if(!empty( $warranty))
					$total_before_discount = $total_before_discount + $warranty->price;

				// calculator memory
			    $origin = $this -> get_record_by_id($prd[6],'fs_origin_price');
			     if(!empty( $origin))
					$total_before_discount = $total_before_discount + $origin->price;

				// calculator memory
			    $species = $this -> get_record_by_id($prd[7],'fs_species_price');
			    if(!empty( $species))
					$total_before_discount = $total_before_discount + $species->price;

				$usage_states = $this -> get_record_by_id($prd[8],'fs_usage_states_price');
				if(!empty( $usage_states))
					$total_before_discount = $total_before_discount + $usage_states->price;

				$region = $this -> get_record_by_id($prd[8],'fs_products_regions_price');
				if(!empty( $region))
					$total_before_discount = $total_before_discount + $region->price;

				 $total_before_discount = $total_before_discount*$prd[2]; 
				
				 // calculator warranty
				
			 	$products_count += $prd[2]; 
			}
		
			$total_after_discount = $total_before_discount;
			$prd_id_str = implode(',',$prd_id_array);
			$session_id = session_id();
			
			$row = array();
			
			$row['products_id']           = $prd_id_str;
			$row['is_temporary']          = 0;
			$row['session_id']            = $session_id;
			$row['total_before_discount'] = $total_before_discount;
			$row['total_after_discount']  = $total_after_discount;
			$row['products_count']        = $products_count;
			
			$row['sender_name']           = FSInput::get('ale_sender_name');
			$row['sender_telephone']      = FSInput::get('ale_sender_telephone');
			$row['sender_email']          = FSInput::get('ale_sender_email');
			$row['sender_address']   	  = FSInput::get('ale_sender_address');
			$row['sender_comments']  	  = FSInput::get('ale_sender_comments');

			$row['is_instalment']  	  = FSInput::get('is_instalment');
			$row['instalment_finance']  	  = 'alepay';
			

			$row['created_time']     	  = date("Y-m-d H:i:s");
			$row['edited_time']      	  = date("Y-m-d H:i:s");
			
			$id =$this -> _add($row, 'fs_order');
		
			// update
			$this -> save_order_items($id);
			if($id) {
				unset($_SESSION['cart']);
			}
			return $id;
		}


/*
		 * Save data into fs_order_items
		 */
		function save_order_items($order_id){
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
			$sql = " INSERT INTO fs_order_items (order_id,product_id,price,total,color_id,color_name,color_price,memory_id,memory_name,memory_price,warranty_id,warranty_name,warranty_price,origin_id,origin_name,origin_price,species_id,species_name,species_price,usage_states_id,usage_states_name,usage_states_price,region_id,region_name,region_price)
					VALUES "; 
					
			$array_insert = array();
			
			// Repeat products
			for($i = 0; $i < count($product_list); $i ++) {
				
				$prd = $product_list[$i];
				$total_money = $prd[1];
				
				   // calculator color
			 	$color = $this -> get_record_by_id($prd[3],'fs_products_price');
			 	if(!empty( $color))
					$total_money = $total_money + $color->price;
			   
			   // calculator status
			    $memory = $this -> get_record_by_id($prd[4],'fs_memory_price');
			    if(!empty( $memory))
					$total_money = $total_money + $memory->price;


				 // calculator status
				$warranty = $this -> get_record_by_id($prd[5],'fs_warranty_price');
				if(!empty( $warranty))
					$total_money = $total_money + $warranty->price;
				
				$origin = $this -> get_record_by_id($prd[6],'fs_origin_price');
				if(!empty( $origin))
					$total_money = $total_money + $origin->price;

				$species = $this -> get_record_by_id($prd[7],'fs_species_price');
				if(!empty( $species))
					$total_money = $total_money + $species->price;

				$usage_states = $this -> get_record_by_id($prd[8],'fs_usage_states_price');
				if(!empty( $usage_states))
					$total_money = $total_money + $usage_states->price;

				$region = $this -> get_record_by_id($prd[8],'fs_region_price');
				if(!empty( $region))
					$total_money = $total_money + $region->price;


				$total_money = $total_money * $prd[2];
				
				$color_name = isset($color->color_name)?$color->color_name:'';
				$color_price = isset($color->price)?$color->price:0;
				$memory_name = isset($memory->memory_name)?$memory->memory_name:"";
				$memory_price = isset($memory->price)?$memory->price:"";
				$warranty_name = isset($warranty->warranty_name)?$warranty->warranty_name:"";
				$warranty_price = isset($warranty->price)?$warranty->price:"";
				$origin_name = isset($origin->origin_name)?$origin->origin_name:"";
				$origin_price = isset($origin->price)?$origin->price:"";
				$species_name = isset($species->species_name)?$species->species_name:"";
				$species_price = isset($species->price)?$species->price:"";
				$usage_states_name = isset($usage_states->species_name)?$usage_states->species_name:"";
				$usage_states_price = isset($usage_states->price)?$usage_states->price:"";
				$region_name = isset($region->species_name)?$region->species_name:"";
				$region_price = isset($region->price)?$region->price:"";

				$array_insert[] = "('$order_id','$prd[0]','$prd[1]','$prd[2]','$total_money','$prd[3]','$color_name','$color_price','$prd[4]','$memory_name','$memory_price','$prd[5]','$warranty_name','$warranty_price','$prd[6]','$origin_name','$origin_price','$prd[7]','$species_name','$species_price','$prd[8]','$usage_states_name','$usage_states_price','$region_name','$region_price') ";
			}
			if(count($array_insert)) {
				$sql_insert = implode(',',$array_insert);
			$sql .= $sql_insert;
				//$db->query($sql);
				$rows = $db->affected_rows($sql);
				return true;				
			} else {
				return;
			}
				
		}

		function alepay_result_save(){
			
			require('libraries/alepay-installment/config.php');
			require('libraries/alepay-installment/Lib/Alepay.php');

			$alepay = new Alepay($config);

			$encryptKey = $config['encryptKey'];

			if (isset($_REQUEST['data']) && isset($_REQUEST['checksum'])) {
			    $alepay = new Alepay($config);
			    $utils = new AlepayUtils();
			    $result = $utils->decryptCallbackData($_REQUEST['data'], $encryptKey);
			    //  echo '<pre>';
			    // print_r($result);
			    //  echo '</pre>';
			    $obj_data = json_decode($result);
			}

			// print_r($_REQUEST['data']);

			$errorCode = $obj_data->errorCode ;
			
	     	$info = json_decode($alepay->getTransactionInfo($obj_data->data));
	     	

	     	$row = array();
	     	$order_id = $info -> orderCode;
	     	$record = $this ->  get_record_by_id($order_id,'fs_order');
	     	$row['instalment_finance_code'] = $info -> transactionCode;
	     	$row['instalment_finance_status'] = $errorCode;
	     	$row['instalment_finance_card'] = $info -> method;
	     	$row['instalment_finance_bank'] = $info -> bankCode;
	     	$row['instalment_finance_message'] = $info -> message;
	     	$row['instalment_finance_month'] = $info -> month;

	     	$row['instalment_finance_amount'] = $info -> amount;
	     	$row['payment_before'] = $record -> total_after_discount - $info -> amount;// trả trước
	     	$row['instalment_finance_payment_4_month'] = ($info -> amount  + $info -> payerFee)/$info -> month;

	     	if($errorCode == '000'){
	     		$row['status'] = 1;
	     	}

	     	$this -> _update($row,'fs_order',' id = '.$order_id);
	     	
	     	return $order_id;
	     	

	}

		function get_banks(){
			return $this -> get_records(' published = 1','fs_alepay_banks','*','ordering ASC');
		}
		
			 function get_filter_menu($manu_id,$table_name){
		 	if(!$manu_id || !$table_name)
		 		return;
		 	return $this -> get_record(' tablename = "'.$table_name.'" AND field_name = "manufactory" AND filter_value = "'.$manu_id.'" ','fs_products_filters','*');	
		 }
		
			 function prices_by_regions($record_id){
			return $this -> get_records('record_id = '.$record_id.' ','fs_products_regions_price','*','',100,'region_id');
		}
	
	}
	
	
?>