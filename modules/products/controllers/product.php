<?php

class ProductsControllersProduct extends FSControllers {
	var $module;
	var $view;
	function __construct() {
		parent::__construct ();
		$arr_layout = array (array ('characteristic', 'Thông số kĩ thuật', 'thong-so-ki-thuat' ), array ('accessories', 'Phụ kiện', 'phu-kien' ) );
		$this->arr_layout = $arr_layout;
	}
	function display() {
		// call mod

		$id = FSInput::get ( 'id' );
		//echo $id;
		//die();
		$model = $this->model;
		$style_types_rule = array('doi-1'=>'1 đổi 1 13 tháng','gia-soc'=>'Giá sốc','tra-gop'=>'Trả góp 0%','bao-hanh-24'=>'BH 24 tháng','doi-1-24'=>'1 đổi 1 24 tháng','hot-sale'=>'Hot sale','bh-ca-roi-vo'=>'BH cả rơi vỡ');
		$data = $model->get_product ();
		if (! $data){
			setRedirect((URL_ROOT.'404-page.html'),'Sản phẩm này không tồn tại');
		}
		// print_r($data);
		$point_default = $this -> cal_point($data);


		$update_hits = $this-> update_hits();

		$sale = $model-> get_sale();
		// if($sale) {
		// 	$list_order = $model->get_order($sale-> code);
		// 	if(!empty($list_order)) {
		// 		$number_sale = $sale-> number_sale - count($list_order);
		// 	} else {
		// 		$number_sale = $sale-> number_sale;
		// 	}
		// }

		if(@$_COOKIE['user_id']) {
			$check_wishlist = $model-> get_record('user_id = '.$_COOKIE['user_id'].' AND product_id = '.$data-> id,'fs_members_wishlist');
		}
		if(!empty($check_wishlist)) {
			$wishlist = 1;
		} else {
			$wishlist = 0;
		}

		$member_levels = $model-> member_level();

		//print_r($data);
		//die();
		if (! $data){
			setRedirect((URL_ROOT.'404-page.html'),'Sản phẩm này không tồn tại');
		}

		$prices_extend_default =  $model -> get_records('record_id = '.$data-> id.' AND is_default = 1','fs_products_price_extend', '*');

		$check_sale_off = $model -> check_sale_off($data-> id);
		if($check_sale_off && $check_sale_off-> total_item > $check_sale_off-> total_item_buy) {
			$data-> price = $check_sale_off-> price;
			$data-> sale_off =1;
		}

		// printr($check_sale_off);
		

		$list_product_combo = array();

		$list_combos = $model -> list_combo($data-> id);

		foreach ($list_combos as $combo) {
			$list_product_combo[$combo-> id] = $model-> get_list_product_combo($combo-> products_ids, $combo-> id);
		}

		// echo '<pre>';

		// print_r($list_product_combo);die;

		// $list_gift = $model->check_gift($data);

		$data-> summary = ($data-> summary);
		$code = FSInput::get('code');
		$id = FSInput::get('id',0,'int');
		if($code != $data-> alias  || $id != $data-> id ){
			$link = FSRoute::_("index.php?module=products&view=product&code=".trim($data->alias)."&id=".$data -> id."&ccode=".trim($data-> category_alias)."&Itemid=$Itemid");
			setRedirect($link);
		}
		$price_quantity = $model-> get_records('record_id = '.$data-> id,'fs_products_prices_quantity','*');
		// print_r($price_quantity);
		$prices_by_regions = $model->prices_by_regions ($data -> id);

		$products_viewed = $model->setCookie();


		$arr_price = calculator_price($data->price,$data->price_old,$data -> is_hotdeal,$data->date_start,$data->date_end,'',$prices_by_regions);
		$price_by_region = $arr_price['price'];
		
		$price_old_by_region = $arr_price['price_old'];
		
		$total_compare=0;

		$fsstring = FSFactory::getClass ( 'FSString', '' );


		if($data -> is_hotdeal){
			if($data -> date_end >  date('Y-m-d H:i:s') && $data->date_start <  date('Y-m-d H:i:s')){
				$price = $data->price;
				$price_old = $data->price_old;
			}else{
				$price= $data->price;
				$price_old = $data->price_old;
			}
		}else{
			$price= $data->price;
			$price_old = $data->price_old;
		}	

		//$price;

		if(isset($_SESSION[$data->tablename])) {
			$arr_prd_compare = $_SESSION[$data->tablename];
			$total_compare =count($arr_prd_compare);
		}

		$cat = $model->getCategoryById ( $data->category_id );
		if (! $cat){
			setRedirect(FSRoute::_('index.php?module=notfound&view=notfound'),'Danh mục này không tồn tại');
		}
		$ccode = FSInput::get ( 'ccode' );

		// if ($cat->alias != $ccode) {
		// 	$Itemid = 6;
		// 	$link = FSRoute::_ ( 'index.php?module=products&view=product&code=' . $data->alias . '&id=' . $data->id . '&ccode=' . $cat->alias . '&Itemid=' . $Itemid );
		// 	setRedirect ( $link );
		// }

		$arr_group_image = $model-> get_group_image($data->id);
		$arr_color_image = $model-> get_color_image($data->id);

		$list_group_image = array();
		$list_color_image = array();

		if(!empty($arr_group_image)) {
			foreach ($arr_group_image as $key => $value) {
				$list_group_image[$key] = $model-> get_records('record_id = '.$data-> id.' AND group_id = '.$key,'fs_products_images','*','ordering ASC');
			}

		}

		if(!empty($arr_color_image)) {
			foreach ($arr_color_image as $key => $value) {
				$list_color_image[$key] = $model-> get_records('record_id = '.$data-> id.' AND color_id = '.$key,'fs_products_images','*','ordering ASC');
			}
		}
		// echo '<pre>';
		// print_r($list_group_image);
		// print_r($list_color_image);die;

		
		$extend = $model->getProductExt ( $data->tablename, $data->id );
		
		// extension field
		$ext_fields = $model->get_ext_fields ( $cat->tablename );
		$data_extends = $model -> get_data_extends( );
//		$data_foreign = $model -> get_data_foreign($ext_fields );
		$str_group_fields = '';
		$arr_ext_fileds_by_group = array();
		if(!empty($ext_fields)){
			$i = 0;
			foreach($ext_fields as $item){
				if($item -> group_id){
					if($i > 0)
						$str_group_fields .= ',';
					$str_group_fields .= $item -> group_id;
					$i ++; 
					if(!isset($arr_ext_fileds_by_group[$item -> group_id]))
						$arr_ext_fileds_by_group[$item -> group_id] = array();
					$arr_ext_fileds_by_group[$item -> group_id][] = $item;
				}else{
					if(!isset($arr_ext_fileds_by_group[0]))
						$arr_ext_fileds_by_group[0] = array();
					$arr_ext_fileds_by_group[0][] = $item;
				}
			}
		}
		$ext_group_fields = $model ->  get_ext_group_fields($str_group_fields);
		$ccode = FSInput::get ( 'ccode' );
		$spAlias = FSInput::get ( 'code' );
		//echo "$ccode | ".$cat->alias;
		// cho nay la neu category ma ko co thi ra 1 cai view temid = 6
		if ($cat->alias != $ccode || $spAlias != $data->alias) {
			$Itemid = 6;
			//$link = FSRoute::_ ( 'index.php?module=products&view=product&code=' . $data->alias . '&id='.$data ->id.'&ccode=' . $cat->alias . '&Itemid=' . $Itemid );
	//	$link = URL_ROOT.' ';  // 404 ve trang chu
	//	setRedirect ($link);
//			movePage(301,"http://msmobile.com.vn/");
			
		}
		


		$description = $model->insert_keyword_to_content ( $data->description );
		// if(!$amp){
		$description = str_replace('<iframe','<div class="video_wrapper" ><iframe',$description);
		$description = str_replace('</iframe>','</iframe></div>',$description);
		// }
		$arr_news_name_core = $model -> get_news_name_core();

		$cities = $model -> get_records('published = 1','fs_cities','*','ordering ASC ');
		
		// seo
		global $tmpl, $module_config;
		
		
		// param from config_module
		FSFactory::include_class ( 'parameters' );
		$current_parameters = new Parameters ( $module_config->params );
		$tabs = $current_parameters->getParams('tabs');
		$limit = $current_parameters->getParams ( 'limit' );
		$use_model = $current_parameters->getParams ( 'use_model' );
		$use_configuration = $current_parameters->getParams ( 'use_configuration' );
		$use_price = $current_parameters->getParams ( 'use_price' );
		$this->limit = $limit;
		$image_small_size = $current_parameters->getParams ( 'image_small_size' );
		$image_small_width = $this->get_dimension ( $image_small_size, 'width' );
		$image_small_height = $this->get_dimension ( $image_small_size, 'height' );
		
		$product_images = $model->getImages ( $data->id );
		$product_image_default = $model->getImageDefault ( $data->id );


		// printr($product_image_default);

		$slideshow_highlight = $model->get_slideshow_highlight ( $data->id );
		
		//Lấy dữ liệu theo  màu 
		$price_by_color= $model->get_price_by_colors ( $data->id );

		//Lấy dữ liệu theo  màu 
		// $images_plus = $model->get_images_plus ( $data->id );
		//lấy dữ liệu giá bổ sung


		//lấy group 
		$price_by_extend_group = $model->get_price_by_extend_group ( $data->id );
		$extends_groups_data =  $model->get_records('','fs_extends_groups','*','','','id');
		// echo "<pre>";
		// print_r($price_by_extend_group);
		// die;

		$price_by_extend =array();
		//lấy group 
		$price_by_extend_group = $model->get_price_by_extend_group ( $data->id );
		if(!empty($price_by_extend_group)) {
			foreach ($price_by_extend_group as $extend_group) {
				$price_by_extend[$extend_group -> group_extend_id] = $model->get_price_by_extend ( $data->id , $extend_group -> group_extend_id);
			}
		}
		//echo "<pre>";
		//print_r($price_by_extend);
		//die();


		//$price_by_extend= $model->get_price_by_extend ( $data->id );


		//Lấy dữ liệu theo bộ nhớ
		$price_by_memory = $model->get_records( 'record_id='.$data->id,'fs_memory_price','*' );

		$price_by_usage_states = $model->get_records( 'record_id='.$data->id,'fs_usage_states_price','*' );

		$price_by_warranty = $model->get_records( 'record_id='.$data->id,'fs_warranty_price','*' );
		
		$price_by_origin = $model->get_records( 'record_id='.$data->id,'fs_origin_price','*' );

		$price_by_species = $model->get_records( 'record_id='.$data->id,'fs_species_price','*' );


		$product_memory = $model->get_records( 'record_id='.$data->id,'fs_products_memory','*' );
		// $relate_news = $model->get_relate_news ( $data->news_related ,'','');		// loại trừ category_id = 41
		// if(!$relate_news){
		// 	//	lấy  danh sách  tin tức liên quan theo tag
		// 	$relate_news = $model->get_news_relate_tags ($data->name_core, $data->tags ,'fs_news','','');// loại trừ category_id = 41
		// }
		
		// $relate_news = $model->get_news_new ();// loại trừ category_id = 41
		

		$relate_tutorial = $model->get_relate_news ( $data->news_related ,'','');


		$relate_news_auto = $model->get_relate_news_auto();

		


		// if(!$relate_tutorial){
			//	lấy  danh sách  tin tức liên quan theo tag
			// $relate_tutorial = $model->get_news_relate_tags ($data->name_core, $data->tags ,'fs_news',41,'');// loại trừ category_id = 41
		// }
		
		// products in cat
		
		// products in manufactory
		$products_in_manufactory = $model->get_products_in_manufactory ( $data->category_id,$data->manufactory, $data->id );

		if($data->tag_group) {
			$tag_group = $model->get_products_tag_group ( $data->tag_group);
		}
		
		// sản phẩm gợi ý ( lấy từ database)
		if($data->products_related) {
			$relate_products_list = $model->get_products_related ( $data->products_related, $data->id );
		}
		$products_in_cat = $model->get_products_in_cat ( $data->category_id, $data->id );

		// $products_list_gift = $model->get_products_list_gift ($data->list_gift);
		$products_list_gift = $model->get_products_list_gift ($data);

		if(empty($relate_products_list)) {
			$relate_products_list = $products_in_cat;
		}

		

		//list combo

		if($data->combo_products_id) {
			$products_in_combo = $model->get_products_combo ( $data->combo_products_id, $data->id );
		}

		

		// Video review
		$list_video_review = $model->get_records('record_id = ' . $data->id, 'fs_products_video_review');
		$style_status = $model -> get_records('published = 1','fs_products_status','*','','','id');

		if(!empty( $data->support_id)){
			$support = $model -> get_record('published = 1 AND id =' . $data->support_id,'fs_products_support');
		}
		

		// sản phẩm có cấu hình tương đương
		// $products_same_config = $model -> get_products_same_config ( $data->tablename, $ext_fields,$extend, $data , 8 );
		
		// sản phẩm cùng khoảng giá
		$products_same_price = $model->get_products_same_price ( $data->id, $data->price );
		
		//			$total_relative  = count($relate_products_list);
		$types = $model->get_types ();
		// get compatable products 
		$types_compatables = $model->get_types_compatables($data -> id);
		// $products_compatables  = $model -> get_records('product_id ='.$data -> id,'fs_products_compatables');
		$products_compatables = array();

		foreach ($types_compatables as $types_compatable) {
			$products_compatables[$types_compatable-> group_id]  = $model -> get_records('product_id ='.$data -> id.' AND group_id = '.$types_compatable-> group_id,'fs_products_compatables','*','ordering ASC');
			foreach ($products_compatables[$types_compatable-> group_id] as $products_compatable) {
				$product_compatable_id[$products_compatable-> product_compatable_id] = $model-> get_record('id ='.$products_compatable -> product_compatable_id,'fs_products','*');
			}
		}

		$array_products_service  = $model -> get_products_by_ids($data -> products_service);

		$array_products_compare  = $model -> get_products_by_ids($data -> products_compare);
		if(!$array_products_compare){
			$array_products_compare = $products_same_price ;
		}
		
		// get from table fs_product_incentives
		$products_incentives = $model -> get_products_incentives($data -> id);
		// get from table fs_product to support display incentives products 
		$array_products_incentives = $model -> get_products_by_ids($data -> products_incentives);
		// get products from products_shops
		// comments
//		$comments = $model-> get_comments($data -> id);
		
		$session_order = $model -> getOrder();
		$user = $model -> get_user();
		//input info
		$sender_name = isset($session_order-> sender_name)?$session_order-> sender_name:@$user->full_name;
		$sender_sex = isset($session_order->sender_sex)?$session_order->sender_sex:@$user -> sex;
		$sender_address = isset($session_order->sender_address)?$session_order->sender_address:@$user -> address;
		$sender_email = isset($session_order->sender_email)?$session_order->sender_email:@$user -> email;
		$sender_telephone = isset($session_order->sender_telephone)?$session_order->sender_telephone:@$user -> mobilephone;
		$discount_code = isset($session_order->discount_code)?$session_order->discount_code:'';
		
//		$link = FSRoute::_('index.php?module=products&view=product&code='.$data -> alias.'&id='.$item -> id.'&ccode='.$cat->alias.'&Itemid='.$Itemid);
// 		breadcrumbs
//		$lis_cat_parent = $model->get_list_parent ( $data->category_id_wrapper );
		// $breadcrumbs = array ();
//		for($i = 0; $i < count ( $lis_cat_parent ); $i ++) {
//			$item = $lis_cat_parent [$i];
//			$breadcrumbs [] = array (0 => $item->name, 1 => FSRoute::_ ( 'index.php?module=products&view=cat&ccode=' . $item->alias . '&Itemid=10' ) );
//		}

		// $breadcrumbs[] = array(0=>$cat -> name, 1 => FSRoute::_('index.php?module=products&view=cat&cid='.$data -> category_id.'&ccode='.$data -> category_alias));
		$cat = $model ->get_record('id = ' .$data ->category_id , 'fs_products_categories','list_parents'); 
		$list_cat = $model -> get_list_cat($cat -> list_parents);

		global $breadcrumbs;
		$breadcrumbs = array();
		$k= 0;
		for($i = count($list_cat); $i > 0; $i--){
			// echo $i;
			$item = $list_cat[$i-1];
			$breadcrumbs[] = array(0=>$item->name, 1 => FSRoute::_('index.php?module='.$this->module.'&view=cat&ccode='.$item->alias.'&cid='.$item->id.'&Itemid=86'));

			$cat_parent = $model -> get_records('parent_id = ' . $item->id,'fs_products_categories','id, name, alias','ordering ASC');

			// echo "<pre>";
			// print_r($cat_parent);
			if(!empty($cat_parent)){
				$cat_parent_arr = array();
				foreach ($cat_parent as $key => $it) {

					$cat_parent_arr[$key][0] = $it->name;
					$cat_parent_arr[$key][1] = FSRoute::_('index.php?module='.$this->module.'&view=cat&ccode='.$it->alias.'&cid='.$it->id.'&Itemid=86');
				}
				// printr($cat_parent_arr);
				$breadcrumbs[$k][2] = $cat_parent_arr	;
			}

			$k++;
		}
		// die;

		// printr($breadcrumbs);

		$filter_manu = $model -> get_filter_menu($data->manufactory, $data->tablename);
		if($filter_manu){

			

			$breadcrumbs[] = array(0=>$data->manufactory_name, 1 => FSRoute::_('index.php?module=products&view=cat&cid='.$data -> category_id.'&ccode='.$data -> category_alias.'&manu='.$data->manufactory_alias.'&checkmanu=1'));
			//$breadcrumbs[] = array(0=>$data->manufactory_name, 1 => FSRoute::_('index.php?module=products&view=cat&cid='.$data -> category_id.'&ccode='.$data -> category_alias.'&filter='.$filter_manu->alias));
		}
//		$breadcrumbs[] = array(0=>$data->name, 1 => '');	
		global $tmpl;
		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );
		$new_products_right = $model->get_list_new_product();
		$hot_products_right = $model->get_list_hot_product();

		$orders =  $model -> get_orders();
		
		// $style_types_rule = array('doi-1'=>'1 đổi 1<br/>13 tháng','gia-soc'=>'Giá sốc','tra-gop'=>'<span>Trả góp 0%</span>','bao-hanh-24'=>'BH <span>24</span> tháng');
		$style_types_rule = array('doi-1'=>'1 đổi 1<br/>13 tháng','gia-soc'=>'Giá sốc','tra-gop'=>'<span>Trả góp 0%</span>','bao-hanh-24'=>'BH <span>24</span> tháng','doi-1-24'=>'1 đổi 1 24 tháng','hot-sale'=>'Hot sale','bh-ca-roi-vo'=>'BH cả rơi vỡ');
		
		if(!empty($data->schema)){
			$tmpl->addHeader($data->schema);
		}

		$this->set_header ( $data );
		$tmpl->set_data_seo ( $data );
		
		// call views
		if($data -> landingpage){
			include 'modules/' . $this->module . '/views/' . $this->view . '/landingpage/'.$data -> landingpage.'/default.php';	
		}else{
			include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';	
		}
		
	}
	
//	/* Save comment */
//	function save_comment() {
//		$return = FSInput::get ( 'return' );
//		$url = base64_decode ( $return );
//		$is_ajax = FSInput::get ( 'ajax' );
//		if(!$is_ajax) $is_ajax = 0;
//		if(!$is_ajax) {
//			if (! $this->check_captcha ()) {
//				$msg = 'Mã hiển thị không đúng';
//				setRedirect ( $url, $msg, 'error' );
//			}
//			$model = $this->model;
//			if (! $model->save_comment ()) {
//				$msg = 'Chưa lưu thành công comment!';
//				setRedirect ( $url, $msg, 'error' );
//			} else {
//				setRedirect ( $url, 'Cảm ơn bạn đã gửi comment' );
//			}
//		}
//		else { 
//			$model = $this->model;
//			$name = FSInput::get('name');
//			$email = FSInput::get('email');
//			$text = FSInput::get('text');
//			$record_id = FSInput::get('record_id',0,'int');
//			$parent_id = FSInput::get('parent_id',0,'int');
//			$time = date('d/m/Y H:i');
//			$success = 0;
//			if (! $model->save_comment ()) {
//				$msg = 'Chưa lưu thành công comment!'; 
//			} else {
//				$msg = 'Cảm ơn bạn đã gửi comment' ;
//				$success = 1;
//			}
//			$return_arr = array(
//				"parent_id"=>$parent_id, 
//				"record_id"=>$record_id, 
//				"msg"=>$msg,
//				"save_time"=>$time,
//				"name"=>$name,
//				"textContent"=>$text,
//				"success" => $success 
//			);
//			echo json_encode($return_arr);
//			exit;
//		}
//	}
//	/* Save comment reply*/
//	function save_reply() {
//		$return = FSInput::get ( 'return' );
//		$is_ajax = FSInput::get ( 'ajax' );
//		if(!$is_ajax) $is_ajax = 0;
//		if(!$is_ajax) {
//			$url = base64_decode ( $return );
//			
//			$model = $this->model;
//			if (! $model->save_comment ()) {
//				$msg = 'Chưa lưu thành công comment!';
//				setRedirect ( $url, $msg, 'error' );
//			} else {
//				setRedirect ( $url, 'Cảm ơn bạn đã gửi comment' );
//			}
//		}
//		else { 
//			$model = $this->model;
//			$name = FSInput::get('name');
//			$email = FSInput::get('email');
//			$text = FSInput::get('text');
//			$record_id = FSInput::get('record_id',0,'int');
//			$parent_id = FSInput::get('parent_id',0,'int');
//			$time = date('d/m/Y H:i');
//			$success = 0;
//			if (! $model->save_comment ()) {
//				$msg = 'Chưa lưu thành công comment!'; 
//			} else {
//				$msg = 'Cảm ơn bạn đã gửi comment' ;
//				$success = 1;
//			}
//			$return_arr = array(
//				"parent_id"=>$parent_id, 
//				"record_id"=>$record_id, 
//				"msg"=>$msg,
//				"save_time"=>$time,
//				"name"=>$name,
//				"textContent"=>$text,
//				"success" => $success 
//			);
//			echo json_encode($return_arr);
//			exit;
//		}
//	}
	/* Save comment */
	
	function show_layout($link_image_remote) {
		$layout = FSInput::get ( 'layout', 'thong-so-ki-thuat' );
		$arr_layout = $this->arr_layout;
		$Itemid = FSInput::get ( 'Itemid' );
		$id = FSInput::get ( 'id' );
		foreach ( $arr_layout as $item ) {
			//				$link  = FSRoute::_("index.php?module=products&view=product&id=$id&layout=$item[2]&Itemid=$Itemid"); 
			$link = FSRoute::addParameters ( 'layout', $item [2] );
			if ($layout == $item [2]) {
				echo "<li class='prd_cat_current'> <span>&nbsp; </span> <a  href='" . $link . "' ><span>" . $item [1] . "</span></a>";
			} else {
				echo "<li class='prd_cat_menu'><span>&nbsp; </span><a  href='" . $link . "' ><span>" . $item [1] . "</span></a>";
			}
		}
		echo "<li class='prd_cat_menu'><span>&nbsp; </span><a  href='" . $link_image_remote . "' target='_blink' ><span>" . 'Ảnh' . "</span></a>";
	}
	
	// check captcha
	function check_captcha() {
		$captcha = FSInput::get ( 'txtCaptcha' );
		
		if ($captcha == $_SESSION ["security_code"]) {
			return true;
		} else {
		}
		return false;
	}
	function get_layout() {
		$arr_layout = $this->arr_layout;
		$layout = FSInput::get ( 'layout', 'thong-so-ki-thuat' );
		foreach ( $arr_layout as $item ) {
			if ($layout == $item [2]) {
				return $item [0];
			}
		}
		return $arr_layout [0] [0];
	}
	
	/*
		 * Save rating
		 */
	function rating() {
		$model = $this->model;
		if (! $model->save_rating ()) {
			echo '0';
			return;
		} else {
			echo '1';
			return;
		}
	}

	function get_dimension($size, $dimension = 'width') {
		if (! $size)
			return 0;
		$array = explode ( 'x', $size );
		if ($dimension == 'width') {
			return (intval ( @$array [0] ));
		} else {
			return (intval ( @$array [1] ));
		}
	}
	function ajax_compare() {
		$limit = 3;
		$id = FSInput::get('id',0,'int');
		$table_name = 'fs_products_'.FSInput::get('table_name');
		if(!$id || !$table_name){
			echo '';
			return;
		}
		if(isset($_SESSION[$table_name])){
			$compare=$_SESSION[$table_name];
		}else{
			$compare[0]=$id;
			$_SESSION[$table_name] = $compare;
			echo '';
			return;
		}
		// kiểm tra trùng lặp
		$is_duplicate = 0;
		foreach($compare as $pos => $record_id){
			if($id == $record_id){
				$is_duplicate = 1;
			}
		}
		// nếu ko trùng lặp
		if(!$is_duplicate){
			$stt=1;
			if((count($compare) + 1) >= $limit){
				$compare[0]=$id;
			}else{
				for($i=0;$i<$limit;$i++){
					if(empty($compare[$i])){
						$compare[$i]=$id;
						$positon=$i;
						break;
					}else{
						$stt=$stt+1;
					}
				}
			}
			$_SESSION[$table_name] = $compare;
		}
		if(count($compare) <= 1){
			echo '';
			return;
		}
		$str_list_id = '';
		foreach($compare as $pos => $record_id){
			if($str_list_id)
				$str_list_id .= '_';
			$str_list_id .= $record_id; 
		}
		
		echo '/so-sanh-san-pham.html&list='.$str_list_id;
		return;
	}
	// update hits
	function update_hits(){
		$model = new ProductsModelsProduct();
		$product_id = FSInput::get('id');
		$model -> update_hits($product_id);
	}
	
	function get_data_foreign($table_name,$value,$type){
		$model = $this -> model;
		return $model -> get_data_foreign($table_name,$value,$type);
	}

	
	function fetch_quantity_product_by_color(){
		$model = $this -> model;	
		$location = FSInput::get ( 'location' );
		$location = ($location)?$location:'sl_hn';
		$rid = FSInput::get ( 'rid' );	
		$color_id= FSInput::get ( 'color_id' );	
		$price_by_color = $model->get_price_by_colors ($rid);
		$quantity = 0;
		foreach ($price_by_color as $item){
			if($item->color_id == $color_id)
				$quantity += $item->$location;
		}
		$total = $quantity;
		if($total == 0){
			echo 'Hết hàng';
		}elseif ($total > 0 && $total <= 3) {
			echo 'Còn ít hàng';
		}else {
			echo 'Còn hàng';
		}
		
		return;
		
	}
	function buy(){
			$product_id = FSInput::get('id',0,'int'); // product_id

			$color_modal = FSInput::get('color_id');
			$color_id_exp = explode('_', $color_modal );
			$color_id     = @$color_id_exp[1];

			$memory_modal =  FSInput::get('memory_id');
			$memory_id_exp= explode('_', $memory_modal );
			$memory_id    = @$memory_id_exp[1];
			
			$usage_states_modal =  FSInput::get('usage_states_id');
			$usage_states_id_exp= explode('_', $usage_states_modal );
			$usage_states_id    = @$usage_states_id_exp[1];


			$region_modal =  FSInput::get('region_id');
			$region_id_exp= explode('_', $region_modal );
			$region_id    = @$region_id_exp[1];


			$warranty_modal= FSInput::get('warranty_id');
			$warranty_id_exp= explode('_', $warranty_modal );
			$warranty_id    = @$warranty_id_exp[1];


			FSFactory::include_class('errors');
			if(!$product_id)
				Errors::_('Sản phẩm chưa xác định');
			$model = $this -> model;	
			
			if(!isset($_SESSION['cart'])) {
				$product_list = array();
				
				$prices = $model -> getPrice();
				if($prices == '-1'){
					Errors::_("Không tồn tại sản phẩm trong giỏ hàng",'error');
					return;
				}
				$product_list[] = array($product_id,$prices[0],1,$color_id,$memory_id,$warranty_id,$usage_states_id,$region_id);
				
			} else {
				$product_list  = $_SESSION['cart'];
				
				$exist_prd  = 0;
				for ($j = 0; $j < count($product_list); $j ++) {
					$prd = $product_list[$j];
					
					if($prd[0] == $product_id) {
						$product_list[$j][1] ++;
						$exist_prd ++;
						break;
					} 
				}
				// if not exist product
				if(!$exist_prd) {
					$prices = $model -> getPrice();
					$product_list[count($product_list)] = array($product_id,$prices[0],1,$color_id,$memory_id,$warranty_id,$usage_states_id,$region_id);
				}
			}
			
			$_SESSION['cart']  = $product_list  ;
			
			
			$html ='';
			$html .=' <div class="modal-dialog">';
			$html .=' <div class="modal-content">';
			$html .='<div class="modal-header">';
			$html .='<h4 class="modal-title"><span>Thêm vào giỏ hàng</span></h4>';
			$html .=' </div>';
			$html .='<div class="modal-body">';
			if(!isset($_SESSION['cart'])) {
				$html .=' <div class="check-square-no mt10"><strong>Sản phẩm chưa thêm vào giỏ hàng</strong></div>';
			}else{
				$html .=' <div class="check-square mt10"><strong>Sản phẩm đã thêm vào giỏ hàng</strong></div>';
			}
			$html .='  </div>';
			$html .=' <div class="modal-footer">';
			$html .=' <button type="button" class="btn btn-default" data-dismiss="modal">Xem tiếp sản phẩm</button>';
			$html .=' <a  href="'. FSRoute::_("index.php?module=products&view=cart&task=eshopcart2").'" class="btn btn-default">Giỏ hàng của bạn</a>';
			$html .=' </div>';
			$html .='</div>';
			$html .='</div>';
			$html .=' </div>';
			echo $html;
			return;
		}		
		function load_price_by_dcare(){
			$value = FSInput::get('value');
			$model = $this->model;
			$data = $model->get_product ();
			$req_region = FSInput::get ('price_region');
			$req_color = FSInput::get ('price_color');	
			if (! $data)
				return;
			if($data -> is_hotdeal){
				if($data -> date_end >  date('Y-m-d H:i:s') && $data->date_start <  date('Y-m-d H:i:s'))
					$price = $data->price;
				else
					$price = $data->price_old;
			}else{
				$price= $data->price;
			}
			$rs ='';
			if($value == 3){
				$rs .=$price+300000;
				$price_dcare =300000;
			}else if($value == 0){
				$rs .= $price;
				$price_dcare =0;
			}
			$rs = $rs+$req_region+ $req_color;
			echo json_encode(array('price'=>"<span>". format_money($rs,'đ')."</span>",'price_dcare'=>$price_dcare));
			return;
		}


		/*
		 * function save info of sender and recipient
		 */
		function eshopcart2_simple_save(){
			$model = $this -> model;	
			$Itemid = FSInput::get('Itemid',0,'int');
			// get temporary data stored in fs_order:
			$order_id = $model -> eshopcart2_simple_save();
			$Itemid = FSInput::get('Itemid',0,'int');
			if($order_id) {
//				$send_mail  = $model -> mail_to_buyer_simple($order_id);
				$link = FSRoute::_('index.php?module=products&view=cart&task=finished&id='.$order_id.'&Itemid='.$Itemid);
				setRedirect($link,'Đơn hàng của bạn đã được gửi đi. Chúng tôi sẽ liên lạc với bạn trong thời gian sớm nhất. Xin cảm ơn!');
			} else {
				$link = FSRoute::_('index.php?module=products&view=cart&task=order&Itemid='.$Itemid);
				setRedirect($link);
			}
		}

		function show_image(){
			$model = $this -> model;	
			$id = FSInput::get('id',0,'int');
			$data = $model->get_product ();
			$product_images =  $model->getImages ($id);
			$array1 = array("0" => $data);
			$result = array_merge($array1, $product_images);
			$total =count($result);
			$i=0;
			$html ='';
			$html .=' <div class="modal-dialog">';
			$html .=' <div class="modal-content">';
			$html .='<div class="modal-header">';
			$html .='<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&nbsp;</button>';
			$html .=' </div>';
			$html .=' <div id="myCarouselPrd" class="carousel slide">';
			$html .=' <div class="carousel-inner">';
			foreach($product_images as $item){	
				$class ='';
				if($i==0){
					$class = 'active';
				}
				$html .='<div class="item '.$class.'">';
				$html .='<img src="'.URL_ROOT.str_replace('/original/','/large/', $item -> image).'" class="img-responsive" >';
				$html .='</div>';
				$i++;
			} 
			$html .='</div>';
			$html .='<a class="carousel-control left" href="#myCarouselPrd" data-slide="prev"> </a>';
			$html .='<a class="carousel-control right" href="#myCarouselPrd" data-slide="next"></a>';
			
			$html .='</div>';
			
			$html .='</div>';
			$html .='</div>';
			
			echo $html;
			return;

		}
		
			/*
		 * Tạo ra các tham số header ( cho fb)
		 */
			function set_header($data, $image_first = '') {
				global $config;
				$preview = FSInput::get ('preview');
				$link = FSRoute::_ ( "index.php?module=products&view=product&id=" . $data->id . "&code=" . $data->alias . "&ccode=" . $data->category_alias."&cid=" . $data->category_id );
				$image = URL_ROOT . str_replace ( '/original/', '/large/', $data->image );
				$str = '<meta property="og:image"  content="' . $image . '" />
				<meta property="og:image:width" content="600 "/>
				<meta property="og:image:height" content="315"/>
				';
				
				global $tmpl;
				if($data -> nofollow == 1 || $preview){
					$tmpl->assign ('noindex', 'NOINDEX,NOFOLLOW');
				}
				$tmpl->assign ( 'og_type','product');
				$tmpl->addHeader ( $str );
			}

	/*
	 * Chèn từ khóa vào nội dung ( bài viết hoặc sản phẩm)
	 */
	function insert_tags_to_charactestic($content,$arr_keyword_name,$link_new="" ) {
		if($link_new) {
			$content  = str_replace($content,'<a href="'.$link_new.'" target="_blink">'.$content.'</a>',$content);
			return $content;
		}
		$content = htmlspecialchars_decode($content);
		if(count($arr_keyword_name)){
			foreach($arr_keyword_name as $item){
				preg_match('#<a[^>]*>((^((?!</a>).)*$)*?)'.$item ->name_core.'(((^((?!<a>).)*$))*?)</a>#is',$content,$rs);
				if(count($rs))
					continue;

				$link = FSRoute::_("index.php?module=news&view=news&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias);

				$content  = str_replace($item -> name_core,'<a href="'.$link.'" target="_blink">'.$item -> name_core.'</a>',$content);
			}
		}
		return $content;
	}


	function export_product(){
		$model = $this -> model;
		$export = $model ->export_product();
		include 'modules/' . $this->module . '/views/' . $this->view . '/export_product.php';
	}


	function chose_product_other_compatables(){

		$model = $this -> model;
		$product_id = FSInput::get('product_id');
		$product_compatable_id = FSInput::get('product_compatable_id');
		$group_id =  FSInput::get('group_id');
		$html='';
		$data = array();
		$data ['error'] = true;

		// $list = $model->get_records('product_id = '.$product_id . ' AND group_id = ' .$group_id . ' AND id != ' . $id ,'fs_products_compatables','*','ordering ASC');

		$price_compatables = $model->get_record('product_id = '.$product_id.' and product_compatable_id='.$product_compatable_id ,'fs_products_compatables','*');
		$pro = $model-> get_record('id= '.$product_compatable_id,'fs_products','name,alias, category_alias,id, image');
		$link  = FSRoute::_('index.php?module=products&view=product&code='.$pro -> alias.'&id='.$pro -> id.'&ccode='.$pro -> category_alias.'&Itemid=37');
		if(empty($list)){
			$data ['pro'] = true;
		}

		// $html .='<div class="frame_inner">';
		$image = URL_ROOT.str_replace('/original/','/resized/', $pro -> image);
		
		$html .='<figure class="product_image">';
		$html .='<img src="'.$image.'" >';
		$html .='</figure>';

		$html .='<h2 class="name_compatable">';
		$html .= '<div class="check">';
		$html .='<input type="checkbox" checked="checked" name="product_compatable[]" class="check_product_compatable" id="check_product_compatable_'.$pro->id.'" onclick="click_check_product_compatable('.$pro-> id.')" value="'.$product_compatable_id.'" rel1="'.$price_compatables-> price_old.'" rel="'.$price_compatables-> price.'">';
		$html .= '</div>';
		$html .= '<a target="_blank" href="'.$link.'" title="'.htmlspecialchars ($pro -> name).'">'.$pro-> name.'</a>';
		$html .= '</h2>';

		$html .= '<div class="price_arae">';
		$html .='<span class="price_current">' .format_money($price_compatables-> price) .'</span>';
		$html .= '<span class="price_discount">'.ceil(($price_compatables-> price - $price_compatables-> price_old) / $price_compatables-> price_old * 100).'%</span>';
		$html .= '<div class="clear"></div>';
		$html .='<div class="price_old">' .format_money($price_compatables-> price_old) .'</div>';
		$html .='<div class="clear"></div>';
			// die;

		// $html .='</div>';
		$data ['html'] = $html;
		$data ['error'] = false;
		echo json_encode ( $data );
		
	}



	function update_total_money_compatable(){
		
		$model = $this -> model;
		$product_id = FSInput::get('product_id');
		$str_id_compatables = FSInput::get('str_id_compatables');
		$product = $model-> get_record('id='.$product_id,'fs_products','id,name, price, price_old');

		$total_price = $product -> price;
		$total_price_old = $product -> price_old;
		if($str_id_compatables) {
			$arr_id_compatables = explode("_",$str_id_compatables);
			foreach ($arr_id_compatables as $id_compatables) {
				$product_compatables = $model-> get_record('product_id='.$product_id.' and product_compatable_id='.$id_compatables,'fs_products_compatables',' price, price_old');
				// print_r($product_compatables);
				$total_price = $total_price + $product_compatables-> price;
				$total_price_old = $total_price_old + $product_compatables-> price_old;
			}
			$count_total = count($arr_id_compatables)+1;
		}
		else {
			$count_total = 1;
		}


		$html ='';
		$data = array();
		$data ['error'] = true;

		// $list = $model->get_records('product_id = '.$product_id . ' AND group_id = ' .$group_id . ' AND id != ' . $id ,'fs_products_compatables','*','ordering ASC');

		$html .= '<div class="label">Tổng tiền: </div>';
		$html .= '<div class="total_money">';
		$html .= '<strong id="total_money_compatable">'.format_money($total_price).'</strong>';
		$html .= '<span class="total_money_compatable_old">'.format_money($total_price_old).'</span>';
		$html .= '</div>';
		$html .= '<div class="count_total">';
		$html .= '<a href="javascript: buy_add_compatables('.$product_id.')">
		<div class="title">Mua '.$count_total.' sản phẩm</div>
		<div class="reduction">Tiết kiệm '.format_money($total_price_old - $total_price).'</div>
		</a>';
		$html .= '</div>';

			// die;
		// $html .='</div>';
		$data ['html'] = $html;
		$data ['error'] = false;
		echo json_encode ( $data );
	}

	function gotoSlide(){
		$model = $this -> model;
		$productID = FSInput::get('productID');
		$group_id = FSInput::get('group_id');
		$type = FSInput::get('type');

		if($type == 1) {
			$image_other = $model->getImagesGroup ($productID,$group_id);
		} else {
			$image_other = $model->getImagesColor ($productID,$group_id );
		}
		
		// print_r($image_other);
		$html = '';
		$data = array();
		if(!empty($image_other)) {
			// $html .= '<div class="area_sync1"><div id="sync1">';
			$i=0; foreach ($image_other as $item) {
				$data[] = set_image_webp($item-> image,'large','','',0,'');
				$html .= '<div class="item" onclick="gotoGallery('.$type.',0,'.$i.','.$group_id.')">';
				$html .= set_image_webp($item-> image,'large','','',0,'');
				$html .= '</div>';
				$i++;
			}
			// $html .= '</div></div>';
		}

		echo $html;
		// echo json_encode($data);

	}


	function popup_gallery(){
		$model = $this -> model;
		$productID = FSInput::get('productID'); 	
		$imageType = FSInput::get('imageType'); 
		$cid = FSInput::get('cid'); 		
		$colorID = FSInput::get('colorID'); 		
		$html='';

		switch($imageType){
			case '1':
			// $product_image_default = $model->getImageDefault ($productID);
			// $images_pro = $model->getImages_pro ($productID);
			$image_other = $model->getImagesGroup ($productID,$cid );

			$images = $image_other;
			
			if(!empty($images)){
				$html .='<div  class="fotorama" data-auto="false" data-allowfullscreen="true" data-nav="thumbs" data-fit="scaledown" data-thumbwidth="100" data-arrows="true" data-click="false" data-swipe="true" data-loop="true"> ';
				foreach ($images as $item) {
					$small = URL_ROOT.str_replace('/original/','/small/', $item -> image);
					$large = URL_ROOT.str_replace('/original/','/large/', $item -> image);
					$html .='<div onclick="ffsfs()" class="caption_ps" data-thumb="'.$small.'" data-img="'.$large.'" data-picid="'.@$item -> id.'"> </div>';
				}
				$html .='</div>';
			}

			break;

			case '2':
			// $product_image_default = $model->getImageDefault ($productID);
			// $images_pro = $model->getImages_pro ($productID);
			$image_other = $model->getImagesColor ($productID,$cid );

			$images = $image_other;
			
			if(!empty($images)){
				$html .='<div  class="fotorama" data-auto="false" data-allowfullscreen="true" data-nav="thumbs" data-fit="scaledown" data-thumbwidth="100" data-arrows="true" data-click="false" data-swipe="true" data-loop="true"> ';
				foreach ($images as $item) {
					$small = URL_ROOT.str_replace('/original/','/small/', $item -> image);
					$large = URL_ROOT.str_replace('/original/','/large/', $item -> image);
					$html .='<div onclick="ffsfs()" class="caption_ps" data-thumb="'.$small.'" data-img="'.$large.'" data-picid="'.@$item -> id.'"> </div>';
				}
				$html .='</div>';
			}

			break;


			case '4':
			$data = $model->get_record_by_id ($productID ,'fs_products','video' );
			if($data -> video){
				$query = parse_url($data -> video, PHP_URL_QUERY);
				parse_str($query, $arr);
				$variable = $arr['v'];
			}
				// $videos = $model->getImages ($productID );
				// if(count($videos)){
			$html .='<div class="fotorama" data-auto="false" data-allowfullscreen="true" data-nav="thumbs" data-fit="scaledown" data-thumbwidth="100" data-arrows="true" data-click="false" data-swipe="true">';
					// foreach ($videos as $item) {
			$html .=' <a href="http://www.youtube.com/watch?v='.$variable.'&?autoplay=1" data-thumb="//img.youtube.com/vi/'.$variable.'/maxresdefault.jpg" data-picid="'.$productID.'" data-video="true"></a>';
						// $html .=' <a href="http://www.youtube.com/watch?v=hbbejNuzS-o&?autoplay=1" data-thumb="//img.youtube.com/vi/hbbejNuzS-o/maxresdefault.jpg" data-picid="1124490" data-video="true"></a>';
					// }
			$html .='</div>';
				// }
			break;

			default:
			return;	
		}

		echo $html;
	}

	function add_wishlist(){
		$model = $this-> model;
		$time = date ( 'Y-m-d H:i:s' );
		$product_id = FSInput::get('product_id');
		$row = array();
		$row['product_id'] = $product_id;
		$row['user_id'] = $_COOKIE['user_id'];
		$row['created_time'] = $time;
		// print_r($row);
		$id = $model-> _add($row, 'fs_members_wishlist');
		return $id;
	}

	function remove_wishlist(){
		$model = $this-> model;
		$time = date ( 'Y-m-d H:i:s' );
		$product_id = FSInput::get('product_id');
		$id = $model-> _remove('product_id = '.$product_id.' AND user_id='.$_COOKIE['user_id'], 'fs_members_wishlist');
		return $id;
	}

	function save_order_status(){
		$return = FSInput::get ( 'return' );
		$url = base64_decode ( $return );
		$phone = FSInput::get('phone');
		$rest = substr($phone, 0, 1);
		if($rest != 0 || $rest != '0' ){
			return;
		}
		$model = $this->model;
		$id = $model->save_order_status ();
		if (! $id) {
			$msg = 'Chưa gửi thành công!';
			setRedirect ( $url, $msg, 'error' );
		} else {
			setRedirect ( $url, 'Quý khách đăng ký nhận thông tin thành công !' );
		}
	}

	function cal_point($data){
		$point = $data -> rating_count ? round(($data -> rating_sum /$data -> rating_count),2): 0;
		if(!$point){
			$a  = ($data -> id  * 3 ) % 30;
			$a =  $a > 15 ? (30 - $a) : $a;
			$a = (35 + $a)/10; 
			$point = $a;
		}
		return $point;
	}

	

}

?>
