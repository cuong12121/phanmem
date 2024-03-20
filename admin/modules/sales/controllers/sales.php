<?php
class SalesControllersSales extends Controllers {
	function __construct() {
		$limit = FSInput::get ( 'limit', 20, 'int' );
		$this->limit = $limit;
		$this->view = 'sales';
		parent::__construct ();
	}
	function display() {
		parent::display ();
		$sort_field = $this->sort_field;
		$sort_direct = $this->sort_direct;
		
		$model = $this->model;
		$list = $model->get_data ();
		$types = $model->get_types ();
//		$origin = $model->get_records ( '', 'fs_sales_origins' );
		$pagination = $model->getPagination ();
		include 'modules/' . $this->module . '/views/' . $this->view . '/list.php';
	}
//	function view_name($data) {
//		$link = FSRoute::_ ( 'index.php?module=sales&view=product&id=' . $data->id . '&code=' . $data->alias . '&ccode=' . $data->category_alias );
//		return '<a target="_blink" href="' . $link . '" title="Xem ngoài font-end">' . $data->name . '</a>';
//	}
	
	function select_type() {
		$model = $this->model;
		$types = $model->get_types ();
		include 'modules/' . $this->module . '/views/' . $this->view . '/select_types.php';
	}
	function add() {
		$model = $this->model;
			$type = FSInput::get('type');
			if($type)
			{
			
//			$category = $model->get_record_by_id ( $cid, 'fs_sales_categories' );
//			$tablename = $category->tablename;
//			$relate_categories = $model->getRelatedCategories ( $category->tablename );
//			$manufactories = $model->getManufactories ( $category->tablename );
			//			$sizes = $model->get_size($category -> tablename);
			//			$colors = $model -> get_records('published = 1','fs_sales_colors');
			// types
			$types = $model->get_records ( 'published = 1', 'fs_sales_types' );
			
			//				$videos = $model -> get_records('published = 1','fs_videos');
			// extend field
//			$extend_fields = $model->getExtendFields ( $category->tablename );
//			$data_foreign = $model->get_data_foreign ( $extend_fields );
//			$maxOrdering = $model->getMaxOrdering ();
			
			// all categories
			$products_categories = $model->get_products_categories ();
			
//			$uses = $model->get_uses ();
			
//			$advices = $model->get_categories_tree ();
			
			// news related
//			$news_categories = $model->get_news_categories_tree ();
			switch ($type){
				case '1':
					include 'modules/' . $this->module . '/views/' . $this->view . '/countdown/default.php';
					break;		
				case '2':
					include 'modules/' . $this->module . '/views/' . $this->view . '/parity/default.php';
					break;		
				case '3':
					include 'modules/' . $this->module . '/views/' . $this->view . '/sale_n_promotion_m/default.php';
					break;		
				case '4':
					include 'modules/' . $this->module . '/views/' . $this->view . '/sale_n_select_gift/default.php';
					break;
				case '5':
					$products_categories = $model->get_products_categories_combo ();
					include 'modules/' . $this->module . '/views/' . $this->view . '/combo_price_down/default.php';
					break;		
				case '6':
					$products_categories = $model->get_products_categories_combo ();
					include 'modules/' . $this->module . '/views/' . $this->view . '/combo_select_gift/default.php';
					break;		
				case '7':
					include 'modules/' . $this->module . '/views/' . $this->view . '/total_has_gift/default.php';
					break;		
				case '8':
					include 'modules/' . $this->module . '/views/' . $this->view . '/total_price_down/default.php';
					break;		
				default:	
			}
			
		} else {
			$types = $model->get_types ();
			include 'modules/' . $this->module . '/views/' . $this->view . '/select_type.php';
		}
	}
	
	function edit() {
		$ids = FSInput::get ( 'id', array (), 'array' );
		$id = $ids [0];
		$model = $this->model;
		$data = $model->get_record_by_id ( $id );
		
		
		// news related
//		$news_categories = $model->get_news_categories_tree ();
//		$news_related = $model->get_news_related ( $data->news_related );
		
		// advices related
		//			$advices_categories = $model->get_advices_categories_tree();
		//			$advices_related = $model -> get_advices_related($data -> advices_related);
		//			
		// video related
		//			$video_related = $model -> get_video_related($data -> video_related);
		

		// types
		$types = $model->get_types ();
//		$images = $model->get_product_images ( $data->id );
		
//		$prices = $model->get_prices ( $data->id );
		
		
		//			$videos = $model -> get_records('published = 1','fs_videos');
		// colors
		//			$colors = $model -> get_records('published = 1','fs_sales_colors');
		//			$colors_to_upload_image = array();
		//			$array_data_by_color = array();
		//			foreach (@$colors as $item)
		//			{
		//				$data_by_color = $model -> get_data_by_color($item->id,$data->id );
		//				if(count($data_by_color) && $data_by_color){
		//					$array_data_by_color [$item->id] = $data_by_color;	
		//					$colors_to_upload_image[$item ->id ] = $item;
		//				}
		//			}
		//			if(!$array_data_by_color){
		//				$colors_to_upload_image = $colors;
		//			}
		

//		$data_ext = $model->getProductExt ( $data->tablename, $data->id );
//		$data_foreign = $model->get_data_foreign ( $extend_fields );
		// together
//		$sales_incentives = $model->get_sales_incentives ( $data->id );
		
		/*
			 * Lấy tham số cấu hình module
			 */
//		$module_params = $model->module_params;
//		FSFactory::include_class ( 'parameters' );
//		$current_parameters = new Parameters ( $module_params );
//		$use_manufactory = $current_parameters->getParams ( 'use_manufactory' );
//		$use_model = $current_parameters->getParams ( 'use_model' );
//		if ($use_manufactory) {
//			$manufactories = $model->getManufactories ( $tablename );
//		}
//		$origin = $model->getOrigin ( $tablename );
		//			$sizes = $model->get_size($tablename);
		//			$colors = $model -> get_records('published = 1','fs_sales_colors');
		

		// add hidden input tag : ext_id into detail form 
//		$this->params_form = array ('ext_id' => @$data_ext->id );
//		$uploadConfig = base64_encode ( 'edit|' . $id );
//		include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
		$type = $data -> type;
		switch ($type){
			case '1':
				$products_categories = $model->get_products_categories ();
				$products_countdown = $model -> get_products_in_sale($data -> id);
				include 'modules/' . $this->module . '/views/' . $this->view . '/countdown/default.php';
				break;		
			case '2':
				$products_categories = $model->get_products_categories ();
				$products_in_sale = $model -> get_products_in_sale($data -> id);
				include 'modules/' . $this->module . '/views/' . $this->view . '/parity/default.php';
				break;
			case '3':
				$products_categories = $model->get_products_categories ();
				$products_in_sale = $model -> get_products_in_sale($data -> id);
				include 'modules/' . $this->module . '/views/' . $this->view . '/sale_n_promotion_m/default.php';
				break;						
			case '4':
				$products_categories = $model->get_products_categories ();
				$products_in_sale = $model -> get_products_in_sale($data -> id);
				include 'modules/' . $this->module . '/views/' . $this->view . '/sale_n_select_gift/default.php';
				break;						
			case '5':
				$products_categories = $model->get_products_categories_combo ();
				$products_in_sale = $model -> get_combo_in_sale($data -> id);
				include 'modules/' . $this->module . '/views/' . $this->view . '/combo_price_down/default.php';
				break;						
			case '6':
				$products_categories = $model->get_products_categories_combo ();
				$products_in_sale = $model -> get_combo_in_sale($data -> id);
				include 'modules/' . $this->module . '/views/' . $this->view . '/combo_select_gift/default.php';
				break;	
			case '7':
				$products_categories = $model->get_products_categories ();
				$products_in_sale = $model -> get_products_in_sale($data -> id);
				include 'modules/' . $this->module . '/views/' . $this->view . '/total_has_gift/default.php';
				break;	
			case '8':
				include 'modules/' . $this->module . '/views/' . $this->view . '/total_price_down/default.php';
				break;		
			default:	
		}
	}
	
	// remove sales_together
//	function remove_incentives() {
//		$model = $this->model;
//		if ($model->remove_incentives ()) {
//			echo '1';
//			return;
//		} else {
//			echo '0';
//			return;
//		}
//	}
	function ajax_get_sales_related() {
		$model = $this->model;
		$data = $model->ajax_get_sales_related ();
		$html = $this->sales_genarate_related ( $data );
		echo $html;
		return;
	}
	function sales_genarate_related($data) {
		$str_exist = FSInput::get ( 'str_exist' );
		$html = '';
		$html .= '<div class="sales_related">';
		foreach ( $data as $item ) {
			if ($str_exist && strpos ( ',' . $str_exist . ',', ',' . $item->id . ',' ) !== false) {
				$html .= '<div class="red sales_related_item  sales_related_item_' . $item->id . '" onclick="javascript: set_sales_related(' . $item->id . ')" style="display:none" >';
				$html .= $item->name;
				$html .= '</div>';
			} else {
				$html .= '<div class="sales_related_item  sales_related_item_' . $item->id . '" onclick="javascript: set_sales_related(' . $item->id . ')">';
				$html .= $item->name;
				$html .= '</div>';
			}
		}
		$html .= '</div>';
		return $html;
	}
	
	/***********
	 * NEWS RELATED
	 ************/
	function ajax_get_news_related() {
		$model = $this->model;
		$data = $model->ajax_get_news_related ();
		$html = $this->news_genarate_related ( $data );
		echo $html;
		return;
	}
	function news_genarate_related($data) {
		$str_exist = FSInput::get ( 'str_exist' );
		$html = '';
		$html .= '<div class="news_related">';
		foreach ( $data as $item ) {
			if ($str_exist && strpos ( ',' . $str_exist . ',', ',' . $item->id . ',' ) !== false) {
				$html .= '<div class="red news_related_item  news_related_item_' . $item->id . '" onclick="javascript: set_news_related(' . $item->id . ')" style="display:none" >';
				$html .= $item->title;
				$html .= '</div>';
			} else {
				$html .= '<div class="news_related_item  news_related_item_' . $item->id . '" onclick="javascript: set_news_related(' . $item->id . ')">';
				$html .= $item->title;
				$html .= '</div>';
			}
		}
		$html .= '</div>';
		return $html;
	}
	/***********
	 * end NEWS RELATED.
	 ************/
	/***********
	 * ADVICES RELATED
	 ************/
	function ajax_get_advices_related() {
		$model = $this->model;
		$data = $model->ajax_get_advices_related ();
		$html = $this->advices_genarate_related ( $data );
		echo $html;
		return;
	}
	function advices_genarate_related($data) {
		$str_exist = FSInput::get ( 'str_exist' );
		$html = '';
		$html .= '<div class="advices_related">';
		foreach ( $data as $item ) {
			if ($str_exist && strpos ( ',' . $str_exist . ',', ',' . $item->id . ',' ) !== false) {
				$html .= '<div class="red advices_related_item  advices_related_item_' . $item->id . '" onclick="javascript: set_advices_related(' . $item->id . ')" style="display:none" >';
				$html .= $item->title;
				$html .= '</div>';
			} else {
				$html .= '<div class="advices_related_item  advices_related_item_' . $item->id . '" onclick="javascript: set_advices_related(' . $item->id . ')">';
				$html .= $item->title;
				$html .= '</div>';
			}
		}
		$html .= '</div>';
		return $html;
	}
	
	
	
	/***********
	 * PARITY
	 ************/
	function ajax_get_products_parity() {
		$model = $this->model;
		$data = $model->ajax_get_products_parity ();
		$html = $this->genarate_products_parity ( $data );
		echo $html;
		return;
	}
	function genarate_products_parity($data) {
		$str_exist = FSInput::get ( 'str_exist' );
		$html = '';
		$html .= '<div class="products_parity">';
		foreach ( $data as $item ) {
			$price = $item -> price_old ? $item -> price_old: $item -> price;
			$price = format_money($price,'',0);
			if ($str_exist && strpos ( ',' . $str_exist . ',', ',' . $item->price_id . ',' ) !== false) {
				$html .= '<div class="red products_parity_item  products_parity_item_' . $item->price_id . '" onclick="javascript: set_products_parity(' . $item->price_id . ')" style="display:none" >';
			} else {
				$html .= '<div class="products_parity_item  products_parity_item_' . $item->price_id . '" onclick="javascript: set_products_parity(' . $item->price_id . ')">';
			}
			$html .= $item->name.' <strong>( '.$item -> unit.' )</strong>';
			$html .= '<span class="red">  - <font class="price_product_label" id="price_parity_'.$item->price_id.'">'.$price.'</font>đ</span>';
			$html .= '</div>';
		}
		$html .= '</div>';
		return $html;
	}
	/***********
	 * end COUNTDOWN.
	 ************/
	/***********
	 * COUNTDOWN
	 ************/
	function ajax_get_products_countdown() {
		$model = $this->model;
		$data = $model->ajax_get_products_countdown ();
		// print_r($data);
		$html = $this->genarate_products_countdown ( $data );
		echo $html;
		return;
	}
	function genarate_products_countdown($data) {
		$str_exist = FSInput::get ( 'str_exist' );
		$html = '';
		$html .= '<div class="products_countdown">';
		foreach ( $data as $item ) {
			$price = $item -> price_old ? $item -> price_old: $item -> price;
			$price = format_money($price,'',0);
			if ($str_exist && strpos ( ',' . $str_exist . ',', ',' . $item->price_id . ',' ) !== false) {
				$html .= '<div class="red products_countdown_item  products_countdown_item_' . $item->price_id . '" onclick="javascript: set_products_countdown(' . $item->price_id . ')" style="display:none" >';
			} else {
				$html .= '<div class="products_countdown_item  products_countdown_item_' . $item->price_id . '" onclick="javascript: set_products_countdown(' . $item->price_id . ')">';
			}
			$html .= $item->name.' <strong>( '.$item -> unit.' )</strong>';
			$html .= '<span class="red">  - <font class="price_product_label" id="price_countdown_'.$item->price_id.'">'.$price.'</font>đ</span>';
			$html .= '</div>';
		}
		$html .= '</div>';
		return $html;
	}
	/***********
	 * end COUNTDOWN.
	 ************/
	
	/***********
	 * sale_n_promotion_m
	 ************/
	function ajax_get_products_salenpromotionm() {
		$model = $this->model;
		$data = $model->ajax_get_products_salenpromotionm ();
		$html = $this->genarate_products_salenpromotionm ( $data );
		echo $html;
		return;
	}
	function genarate_products_salenpromotionm($data) {
		$str_exist = FSInput::get ( 'str_exist' );
		$html = '';
		$html .= '<div class="products_add">';
		foreach ( $data as $item ) {
			$price = $item -> price_old ? $item -> price_old: $item -> price;
			$price = format_money($price,'',0);
			if ($str_exist && strpos ( ',' . $str_exist . ',', ',' . $item->price_id . ',' ) !== false) {
				$html .= '<div class="red products_add_item  products_add_item_' . $item->price_id . '" onclick="javascript: set_products_add(' . $item->price_id . ')" style="display:none" >';
			} else {
				$html .= '<div class="products_add_item  products_add_item_' . $item->price_id . '" onclick="javascript: set_products_add(' . $item->price_id . ')">';
			}
			$html .= $item->name.' <strong>( '.$item -> unit.' )</strong>';
			$html .= '<span class="red">  - <font class="price_product_label" id="price_add_'.$item->price_id.'">'.$price.'</font>đ</span>';
			$html .= '</div>';
		}
		$html .= '</div>';
		return $html;
	}
	/***********
	 * end sale_n_promotion_m.
	 ************/
	
	/***********
	 * sale_n_select_gift
	 ************/
	function ajax_get_products_salenselectgift() {
		$model = $this->model;
		$data = $model->ajax_get_products_salenselectgift ();
		$html = $this->genarate_products_salenselectgift ( $data );
		echo $html;
		return;
	}
	function genarate_products_salenselectgift($data) {
		$str_exist = FSInput::get ( 'str_exist' );
		$html = '';
		$html .= '<div class="products_add">';
		foreach ( $data as $item ) {
			$price = $item -> price_old ? $item -> price_old: $item -> price;
			$price = format_money($price,'',0);
			if ($str_exist && strpos ( ',' . $str_exist . ',', ',' . $item->price_id . ',' ) !== false) {
				$html .= '<div class="red products_add_item  products_add_item_' . $item->price_id . '" onclick="javascript: set_products_add(' . $item->price_id . ')" style="display:none" >';
			} else {
				$html .= '<div class="products_add_item  products_add_item_' . $item->price_id . '" onclick="javascript: set_products_add(' . $item->price_id . ')">';
			}
			$html .= $item->name.' <strong>( '.$item -> unit.' )</strong>';
			$html .= '<span class="red">  - <font class="price_product_label" id="price_add_'.$item->price_id.'">'.$price.'</font>đ</span>';
			$html .= '</div>';
		}
		$html .= '</div>';
		return $html;
	}
	/***********
	 * end sale_n_select_gift.
	 ************/
	/***********
	 * sale_n_select_gift: select gift
	 ************/
	function gift_salenselectgift() {
		$ids = FSInput::get ( 'id', array (), 'array' );
		$id = $ids [0];
		$model = $this->model;
		$data = $model->get_record_by_id ( $id );
		
		// types
		$gift_categories = $model->get_products_categories ();
		$products_in_sale = $model -> get_products_in_sale($data -> id);
		// get sale_product current
		$sale_product_select = $model -> get_sale_product_select($data -> id);
		if($sale_product_select){
			$gifts =   $model -> get_gifts($sale_product_select -> sale_product_id);
		}
		include 'modules/' . $this->module . '/views/' . $this->view . '/sale_n_select_gift/gift.php';
	}
	function save_gifts_salenselectgift() {
		$model = $this->model;
		$id = $model->save_gifts_salenselectgift ();
		
		$rid = FSInput::get('id',0,'int');
		$sale_product_id = FSInput::get('sale_product_id',0,'int');
		
		$link = "index.php?module=sales&view=sales&task=gift_salenselectgift&id=".$rid."&sale_product_id=".$sale_product_id; 
		
//		if ($this->page)
//			$link .= '&page=' . $this->page;
		
		// call Models to save
		if ($id) {
			setRedirect ( $link , FSText::_ ( 'Saved' ) );
		} else {
			setRedirect ( $link, FSText::_ ( 'Not save' ), 'error' );
		}
	}
	function back_sale() {
		
		$rid = FSInput::get('id',0,'int');
		
		$link = "index.php?module=sales&view=sales&task=edit&id=".$rid; 
		
//		if ($this->page)
//			$link .= '&page=' . $this->page;
		
		// call Models to save
		setRedirect ( $link);
	}
	
	function ajax_get_gifts_salenselectgift() {
		$model = $this->model;
		$data = $model->ajax_get_gifts_salenselectgift ();
		$html = $this->genarate_gifts_salenselectgift ( $data );
		echo $html;
		return;
	}
	function genarate_gifts_salenselectgift($data) {
		$str_exist = FSInput::get ( 'str_exist' );
		$html = '';
		$html .= '<div class="gifts_add">';
		foreach ( $data as $item ) {
			$price = $item -> price_old ? $item -> price_old: $item -> price;
			$price = format_money($price,'',0);
			if ($str_exist && strpos ( ',' . $str_exist . ',', ',' . $item->price_id . ',' ) !== false) {
				$html .= '<div class="red gifts_add_item  gifts_add_item_' . $item->price_id . '" onclick="javascript: set_gifts_add(' . $item->price_id . ')" style="display:none" >';
			} else {
				$html .= '<div class="gifts_add_item  gifts_add_item_' . $item->price_id . '" onclick="javascript: set_gifts_add(' . $item->price_id . ')">';
			}
			$html .= $item->name.' <strong>( '.$item -> unit.' )</strong>';
			$html .= '<span class="red">  - <font class="price_product_label" id="price_add_'.$item->price_id.'">'.$price.'</font>đ</span>';
			$html .= '</div>';
		}
		$html .= '</div>';
		return $html;
	}
	/***********
	 * end sale_n_select_gift.
	 ************/
	
	/***********
	 * COBO PRICE DOWN
	 ************/
	function ajax_get_products_combopricedown() {
		$model = $this->model;
		$data = $model->ajax_get_products_combopricedown ();
		$html = $this->genarate_products_combopricedown ( $data );
		echo $html;
		return;
	}
	function genarate_products_combopricedown($data) {
		$str_exist = FSInput::get ( 'str_exist' );
		$html = '';
		$html .= '<div class="products_add">';
		foreach ( $data as $item ) {
			$price = $item -> price_old ? $item -> price_old: $item -> price;
			$price = format_money($price,'',0);
			if ($str_exist && strpos ( ',' . $str_exist . ',', ',' . $item->id . ',' ) !== false) {
				$html .= '<div class="red products_add_item  products_add_item_' . $item->id . '" onclick="javascript: set_products_add(' . $item->id . ')" style="display:none" >';
			} else {
				$html .= '<div class="products_add_item  products_add_item_' . $item->id . '" onclick="javascript: set_products_add(' . $item->id . ')">';
			}
			$html .= $item->name;
			$html .= '<span class="red">  - <font class="price_product_label" id="price_add_'.$item->id.'">'.$price.'</font>đ</span>';
			$html .= '</div>';
		}
		$html .= '</div>';
		return $html;
	}
	/***********
	 * end COBO PRICE DOWN.
	 ************/
	/***********
	 * COMBO SELECT GIFT
	 ************/
	function ajax_get_products_comboselectgift() {
		$model = $this->model;
		$data = $model->ajax_get_products_comboselectgift ();
		$html = $this->genarate_products_comboselectgift ( $data );
		echo $html;
		return;
	}
	function genarate_products_comboselectgift($data) {
		$str_exist = FSInput::get ( 'str_exist' );
		$html = '';
		$html .= '<div class="products_add">';
		foreach ( $data as $item ) {
			$price = $item -> price_old ? $item -> price_old: $item -> price;
			$price = format_money($price,'',0);
			if ($str_exist && strpos ( ',' . $str_exist . ',', ',' . $item->id . ',' ) !== false) {
				$html .= '<div class="red products_add_item  products_add_item_' . $item->id . '" onclick="javascript: set_products_add(' . $item->id . ')" style="display:none" >';
			} else {
				$html .= '<div class="products_add_item  products_add_item_' . $item->id . '" onclick="javascript: set_products_add(' . $item->id . ')">';
			}
			$html .= $item->name;
			$html .= '<span class="red">  - <font class="price_product_label" id="price_add_'.$item->id.'">'.$price.'</font>đ</span>';
			$html .= '</div>';
		}
		$html .= '</div>';
		return $html;
	}
	/***********
	 * end COBO PRICE DOWN.
	 ************/
	/***********
	 * sale_n_select_gift: select gift
	 ************/
	function gift_comboselectgift() {
		$ids = FSInput::get ( 'id', array (), 'array' );
		$id = $ids [0];
		$model = $this->model;
		$data = $model->get_record_by_id ( $id );
		
		// types
		$gift_categories = $model->get_products_categories ();
		$products_in_sale = $model -> get_products_in_sale($data -> id);
		// get sale_product current
		$sale_product_select = $model -> get_sale_product_select($data -> id);
		if($sale_product_select){
			$gifts =   $model -> get_gifts($sale_product_select -> sale_product_id);
		}
		include 'modules/' . $this->module . '/views/' . $this->view . '/sale_n_select_gift/gift.php';
	}
	function save_gifts_comboselectgift() {
		$model = $this->model;
		$id = $model->save_gifts_comboselectgift ();
		
		$rid = FSInput::get('id',0,'int');
		$sale_product_id = FSInput::get('sale_product_id',0,'int');
		
		$link = "index.php?module=sales&view=sales&task=gift_comboselectgift&id=".$rid."&sale_product_id=".$sale_product_id; 
		
//		if ($this->page)
//			$link .= '&page=' . $this->page;
		
		// call Models to save
		if ($id) {
			setRedirect ( $link , FSText::_ ( 'Saved' ) );
		} else {
			setRedirect ( $link, FSText::_ ( 'Not save' ), 'error' );
		}
	}
	
	function ajax_get_gifts_comboselectgift() {
		$model = $this->model;
		$data = $model->ajax_get_gifts_comboselectgift ();
		$html = $this->genarate_gifts_totalhasgift ( $data );
		echo $html;
		return;
	}
	function genarate_gifts_comboselectgift($data) {
		$str_exist = FSInput::get ( 'str_exist' );
		$html = '';
		$html .= '<div class="gifts_add">';
		foreach ( $data as $item ) {
			$price = $item -> price_old ? $item -> price_old: $item -> price;
			$price = format_money($price,'',0);
			if ($str_exist && strpos ( ',' . $str_exist . ',', ',' . $item->price_id . ',' ) !== false) {
				$html .= '<div class="red gifts_add_item  gifts_add_item_' . $item->price_id . '" onclick="javascript: set_gifts_add(' . $item->price_id . ')" style="display:none" >';
			} else {
				$html .= '<div class="gifts_add_item  gifts_add_item_' . $item->price_id . '" onclick="javascript: set_gifts_add(' . $item->price_id . ')">';
			}
			$html .= $item->name.' <strong>( '.$item -> unit.' )</strong>';
			$html .= '<span class="red">  - <font class="price_product_label" id="price_add_'.$item->price_id.'">'.$price.'</font>đ</span>';
			$html .= '</div>';
		}
		$html .= '</div>';
		return $html;
	}
	/***********
	 * end sale_n_select_gift.
	 ************/
	
	/***********
	 * TYPE 7: total_has_gift
	 ************/
	function ajax_get_products_totalhasgift() {
		$model = $this->model;
		$data = $model->ajax_get_products_totalhasgift ();
		$html = $this->genarate_products_totalhasgift ( $data );
		echo $html;
		return;
	}
	function genarate_products_totalhasgift($data) {
		$str_exist = FSInput::get ( 'str_exist' );
		$html = '';
		$html .= '<div class="products_add">';
		foreach ( $data as $item ) {
			$price = $item -> price_old ? $item -> price_old: $item -> price;
			$price = format_money($price,'',0);
			if ($str_exist && strpos ( ',' . $str_exist . ',', ',' . $item->price_id . ',' ) !== false) {
				$html .= '<div class="red products_add_item  products_add_item_' . $item->price_id . '" onclick="javascript: set_products_add(' . $item->price_id . ')" style="display:none" >';
			} else {
				$html .= '<div class="products_add_item  products_add_item_' . $item->price_id . '" onclick="javascript: set_products_add(' . $item->price_id . ')">';
			}
			$html .= $item->name.' <strong>( '.$item -> unit.' )</strong>';
			$html .= '<span class="red">  - <font class="price_product_label" id="price_add_'.$item->price_id.'">'.$price.'</font>đ</span>';
			$html .= '</div>';
		}
		$html .= '</div>';
		return $html;
	}
	/***********
	 * end total_has_gift.
	 ************/
	
}

function view_data($controle,$data) {
		$link = FSRoute::_ ( 'index.php?module=sales&view=product&id=' . $data->id . '&code=' . $data->alias  );
		return '<a target="_blink" href="' . $link . '" class="view_data">' . 
			'<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 32 32" height="32px" id="Layer_1" version="1.1" viewBox="0 0 32 32" width="25px" xml:space="preserve"><g><g><path d="M16.333,13.759L16.333,13.759c-0.006-0.001-0.012-0.001-0.018-0.001c-0.006,0-0.012,0-0.018,0v0.001    c-1.21,0.03-2.183,1.02-2.183,2.237s0.972,2.208,2.183,2.237v0.002c0.006,0,0.012-0.002,0.018-0.002    c0.005,0,0.011,0.002,0.018,0.002v-0.002c1.219-0.029,2.183-1.02,2.183-2.237S17.552,13.789,16.333,13.759z" fill="#515151"/><path d="M29.586,14.186c-2.76-2.246-7.407-5.51-13.253-5.621v0c-0.006,0-0.012,0-0.018,0c-0.006,0-0.012,0-0.018,0    v0C10.453,8.676,5.801,11.94,3.041,14.186c-0.132,0.107-1.036,0.8-1.051,1.686c-0.011,0.624,0.28,1.085,0.699,1.471    c2.255,2.181,7.176,6.059,13.609,6.087v0.002c0.006,0,0.012,0,0.018,0c0.005,0,0.011,0,0.018,0v-0.002    c6.445-0.028,11.351-3.906,13.607-6.087c0.419-0.386,0.709-0.847,0.697-1.471C30.621,14.986,29.719,14.293,29.586,14.186z     M16.315,21.752c-3.162-0.021-5.719-2.59-5.719-5.756s2.557-5.735,5.719-5.755c3.17,0.02,5.718,2.589,5.718,5.755    S19.485,21.73,16.315,21.752z" fill="#515151"/></g></g></svg>' .
		 '</a>';
}

?>