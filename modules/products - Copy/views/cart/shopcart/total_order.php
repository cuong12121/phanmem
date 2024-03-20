<?php if(isset($_COOKIE['cart']) AND !empty($product_list)) { ?>
<?php
	$i = 0; 
	$id_last = 0;
	$total = 0;
	$quantity = 0;
	$cat_id_last = 0;
	$total_price_extent = 0;
	$ship_HL = 0;
	foreach ($product_list as $prd) {
		$i++;
		$product = $this -> getProductById($prd['product_id']);
		if(!$product){
			continue;
		}

		//Check đơn vị vận chuyển có phải Hải Linh Ko strpos($product->category_id_wrapper
		$cat_product = $model-> get_record('id = ' . $product-> category_id,'fs_products_categories','hai_linh_ship');
		// printr($cat_product);
		if ($cat_product->hai_linh_ship == 1) {
		    $ship_HL = 1;
		}
		
		/////////
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

}
?>