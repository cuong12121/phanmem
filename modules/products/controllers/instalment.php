<?php
/*
 * Huy write
 */
// controller


class ProductsControllersInstalment extends FSControllers {
	var $module;
	var $view;
	function __construct() {
		parent::__construct ();
	}
	function display() {
		$id = FSInput::get('id',0,'int');
		$model = $this->model;
		if($id){
			$data = $model->get_record_by_id($id,'fs_products');
			$prices_extend_default =  $model -> get_records('record_id = '.$data-> id.' AND is_default = 1','fs_products_price_extend', '*');
			$code = FSInput::get('code');
			if($code != $data-> alias ){
				$link = FSRoute::_("index.php?module=products&view=instalment&code=".trim($data->alias)."&id=".$data -> id);
				
				setRedirect($link);
			}
			$cat = $model->getCategoryById ( $data->category_id );
			$prices_by_regions = $model->prices_by_regions ($data -> id);
			$arr_price = calculator_price($data->price,$data->price_old,$data -> is_hotdeal,$data->date_start,$data->date_end,'',$prices_by_regions);
			$price_by_region = $arr_price['price'];

			if(!empty($prices_extend_default)) {
				$price_default = $price_by_region;
				foreach ($prices_extend_default as $price_extend_default) {
					$price_default = $price_default + (int)($price_extend_default-> price);
				}

			}

			$price_old_by_region = $arr_price['price_old'];
			if($data -> is_hotdeal){
				if($data -> date_end >  date('Y-m-d H:i:s') && $data->date_start <  date('Y-m-d H:i:s')){
					$price = $data->price;
					$price_old = $data->price_old;
					$discount = $price_old - $price;
				}else{
					$price = $data->price;
					$price_old = $data->price_old;
					$discount	= $price_old - $price;
				}
			}else{
				$price= $data->price;
				$price_old = $data->price_old;
				$discount	= $price_old - $price;
			}
		}else{
			$list = $this->model->get_product();
			// call views
			$arr_products=array();
			$i=0;
			if(count($list)){
				foreach ($list as $key=>$item) {
					$link = FSRoute::_('index.php?module='.$this -> module.'&view=product&code='.$item->alias.'&id='.$item -> id.'&ccode='.$item->category_alias.'&Itemid=5');
					if($item -> is_hotdeal){
						if($item -> date_end >  date('Y-m-d H:i:s') && $item->date_start <  date('Y-m-d H:i:s')){
							$price = $item->price;
							$price_old = $item->price_old;
							$discount = $price_old - $price;
						}else{
							$price = $item->price_old;
							$price_old = '';
							$discount	= $price_old - $price;
						}
					}else{
						$price= $item->price;
						$price_old = $item->price_old;
						$discount	= $price_old - $price;
					}
					$arr_products[$i]['value']=$item->id;
					$arr_products[$i]['label']=preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $item->name);
					$arr_products[$i]['image']=URL_ROOT.str_replace('/original/','/resized/', $item -> image);
					$arr_products[$i]['price']=format_money($price ,' ₫');
					$arr_products[$i]['d_price']=$price;
					$arr_products[$i]['discount']=($discount)?format_money($discount,' ₫'):'0 ₫';
					$arr_products[$i]['link']=$link;
					$i++;
				}
	//			echo '<pre>';
	//			print_r($arr_products);
	//			echo '</pre>';
				
			}
		}
		
		
			//Lấy dữ liệu theo  màu 
		$price_by_color= $model->get_price_by_colors ( $data->id );

		//Lấy dữ liệu theo  màu 
		// $images_plus = $model->get_images_plus ( $data->id );

		//lấy dữ liệu giá bổ sung

		//lấy group 
		$price_by_extend_group = $model->get_price_by_extend_group ( $data->id );
		if(!empty($price_by_extend_group)) {
			foreach ($price_by_extend_group as $extend_group) {
				$price_by_extend[$extend_group -> group_extend_id] = $model->get_price_by_extend ( $data->id , $extend_group -> group_extend_id);
			}
		}
		//e
		
		//Lấy dữ liệu theo bộ nhớ
		$price_by_memory = $model->get_records( 'record_id='.$data->id,'fs_memory_price','*' );

		$price_by_usage_states = $model->get_records( 'record_id='.$data->id,'fs_usage_states_price','*' );

		$price_by_regions = $model->get_records( 'record_id='.$data->id,'fs_products_regions_price','*' );

		$price_by_warranty = $model->get_records( 'record_id='.$data->id,'fs_warranty_price','*' );
		
		$price_by_origin = $model->get_records( 'record_id='.$data->id,'fs_origin_price','*' );

		$price_by_species = $model->get_records( 'record_id='.$data->id,'fs_species_price','*' );

		// $banks = $model -> get_banks();


		global $tmpl;
		$title = 'Mua trả góp '.$data -> name.' lãi suất thấp';

		$tmpl->addTitle( $data -> installment_seo_title ? $data -> installment_seo_title: $title);
		
		$tmpl->addMetakey($data -> installment_seo_keyword ? $data -> installment_seo_keyword: $title);
		$tmpl->addMetades($data -> installment_seo_description ? $data -> installment_seo_description: $title);


		$breadcrumbs = array ();


		$breadcrumbs[] = array(0=>$cat -> name, 1 => FSRoute::_('index.php?module=products&view=cat&cid='.$data -> category_id.'&ccode='.$data -> category_alias));

		$filter_manu = $model -> get_filter_menu($data->manufactory, $data->tablename);
		if($filter_manu){
			$breadcrumbs[] = array(0=>$data->manufactory_name, 1 => FSRoute::_('index.php?module=products&view=cat&cid='.$data -> category_id.'&ccode='.$data -> category_alias.'&filter='.$filter_manu->alias));
		}
		$breadcrumbs[] = array(0=>$data->name, 1 => FSRoute::_('index.php?module=products&view=product&code='.$data -> alias.'&ccode='.$data->category_alias.'&id='.$data->id.'&cid='.$data->category_id) );	

		global $tmpl;
		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );

		
		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );
		include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';
	}
	function  load_data(){
		$id = FSInput::get('product_id');
		if(!$id)
			return ;
		$data = $this->model->get_record_by_id($id,'fs_products');
		if($data -> is_hotdeal){
			if($data -> date_end >  date('Y-m-d H:i:s') && $data->date_start <  date('Y-m-d H:i:s')){
				$price = $data->price;
				$price_old = $data->price_old;
				$discount = $price_old - $price;
			}else{
				$price = $data->price_old;
				$price_old = '';
				$discount	= $price_old - $price;
			}
		}else{
			$price= $data->price;
			$price_old = $data->price_old;
			$discount	= $price_old - $price;
		}
		$link=FSRoute::_('index.php?module='.$this -> module.'&view=product&code='.$data->alias.'&id='.$data -> id.'&ccode='.$data->category_alias.'&Itemid=5');
		$image = URL_ROOT.str_replace('/original/','/resized/', $data -> image);
		
		$html ='';
		$html .='<div class="product-img">';
		$html .='<img  width="100px"  id="product-icon" src="'.$image.'"  alt="">';
		$html .='</div>';
		$html .='<div id="product-description">';
		$html .='<h2 class="name">';
		$html .='<a href="'.$link.'" title = "" >';
		$html .=$data->name;
		$html .='</a>';
		$html .='</h2>';
		$html .='<div class="price">';
		$html .='<span>';
		$html .=format_money($price ,' ₫');
		$html .='</span>';
		$html .='</div>';
		$html .='<div class="discount">';
		$html .='Khuyến mại: <span>'.format_money($discount ,' ₫').'</span>';
		$html .='</div>';
		$html .='</div>';
		echo $html;
		return;
	}
	function calculator(){
		$slpercent = FSInput::get('slpercent');
		$slmonth = FSInput::get('slmonth');
		$product_id = FSInput::get('product_id');
		$product_price =FSInput::get('product_price');
		if(!$product_price)
			return;
		if($slmonth ==6 || $slmonth==8 ){
			$ls =0.0166;
		}else{
			$ls =0.0166;
		}
		//giá trả trước
		$price_dicker_before =($product_price/100)*$slpercent;
		
		//giá trả hàng tháng
		$price_dicker_monthly = round((($product_price-$price_dicker_before)/$slmonth +  ($product_price-$price_dicker_before)* $ls),-3);
		
		$html ='';

		
		// $html .='<div class="td-left">';
		// $html .='<b>Lãi suất thực</b>';
		// $html .='</div>';
		// $html .='<div class="td-right">';
		// $html .='';
		// $html .='</div>';
		// $html .='<div class="clearfix"></div>';
		
		// $html .='<div class="td-left">';
		// $html .='<b>Trả trước</b>';
		// $html .='</div>';
		// $html .='<div class="td-right">';
		// $html .=format_money($price_dicker_before,' ₫');

		// $html .='</div>';
		// $html .='<div class="clearfix"></div>';
		
		// $html .='<div class="td-left">';
		// $html .='<b>Góp mỗi tháng</b>';
		// $html .='</div>';
		// $html .='<div class="td-right">';
		// $html .=format_money($price_dicker_monthly,' ₫');
		
		// $html .='</div>';
		// $html .='<div class="clearfix"></div>';
		
		// $html .='<div class="td-left">';
		// $html .='<b>Tổng góp + trả trước</b>';
		// $html .='</div>';
		// $html .='<div class="td-right">';
		// $instalment_total = 	($price_dicker_monthly*$slmonth)+$price_dicker_before; 
		// $html .=format_money($instalment_total,' ₫');
		
		// $html .='</div>';
		// $html .='<div class="clearfix"></div>';
		// $html .='<br />';
		

		$html .='<table class="table_ins">';
		$html .='<tbody>';

		$html .='<tr>';
		$html .='<td>';
		$html .='<b>Trả trước</b>';
		$html .='</td>';
		$html .='<td>';
		$html .=format_money($price_dicker_before,' ₫');
		$html .='</td>';
		$html .='</tr>';

		$html .='<tr>';
		$html .='<td>';
		$html .='<b>Góp mỗi tháng</b>';
		$html .='</td>';
		$html .='<td>';
		$html .=format_money($price_dicker_monthly,' ₫');
		$html .='</td>';
		$html .='</tr>';

		$html .='<tr>';
		$html .='<td>';
		$html .='<b>Tổng góp + trả trước</b>';
		$html .='</td>';
		$html .='<td>';
		$instalment_total = 	($price_dicker_monthly*$slmonth)+$price_dicker_before; 
		$html .=format_money($instalment_total,' ₫');
		$html .='</td>';
		$html .='</tr>';

		$html .='<tr>';
		$html .='<td>';
		$html .='<b>Chênh so với mua trả thẳng</b>';
		$html .='</td>';
		$html .='<td>';
		$dif_price = 	$instalment_total - $product_price; 
		$html .=format_money($dif_price,' ₫');
		$html .='</td>';
		$html .='</tr>';
		$html .='</tbody>';
		$html .='</table>';



		

		echo json_encode(array('instalment_money_before' => $price_dicker_before,'instalment_money_per_month'=>  $price_dicker_monthly,'instalment_money_total'=>$instalment_total,'html'=>$html));
		

		return;
	}
	
	

	/*********** ALEPAY *****************/
	function alepay_save_installment(){

		$model = $this->model;

		require('libraries/alepay-installment/config.php');
		require('libraries/alepay-installment/Lib/Alepay.php');

		$alepay = new Alepay($config);


		$data = array();
		

		parse_str(file_get_contents('php://input'), $params); // Lấy thông tin dữ liệu bắn vào
		


		$data['cancelUrl'] = URL_DEMO;
		// $link = FSRoute::_("index.php?module=products&view=instalment&code=tra-gop&id=".trim($params['id']));
		// $data['cancelUrl'] = $link;

		$data['amount'] = intval(preg_replace('@\D+@', '', $params['ale_payment_after']));
		
		$data['currency'] = 'VND';
		
		$data['totalItem'] = 1;
		$data['checkoutType'] = 2; // Thanh toán trả góp
		$data['buyerName'] = trim($params['ale_sender_name']);
		$data['buyerEmail'] = trim($params['ale_sender_email']);
		$data['buyerPhone'] = trim($params['ale_sender_telephone']);
		$data['buyerAddress'] = trim($params['ale_sender_address']);
		$data['buyerCity'] = trim($params['ale_sender_city']);
		$data['buyerCountry'] = 'Viet Nam';
		$data['paymentHours'] = 48; //48 tiếng :  Thời gian cho phép thanh toán (tính bằng giờ)

		foreach ($data as $k => $v) {
			if (empty($v)) {
				echo $k;
				$alepay->return_json("NOK", "Bắt buộc phải nhập/chọn tham số [ " . $k . " ]");
				die();
			}
		}

		$order_id = $model -> alepay_eshopcart_save();
		$data['orderDescription'] = 'Thanh toán trả góp tại alepay cho hóa đơn '.$order_id;
		$data['orderCode'] = $order_id;
		
		$result = $alepay->sendOrderToAlepay($data); // Khởi tạo
		

		if (isset($result) && !empty($result->checkoutUrl)) {
			$alepay->return_json('OK', 'Thành công', $result->checkoutUrl);
		} else {
			$alepay->return_json($result->errorCode, $result->errorDescription);
		}

	}

	function alepay_result(){

		$model = $this->model;
		$order_id = $model -> alepay_result_save();



	}
	
	/*********** end ALEPAY *****************/
}

?>
