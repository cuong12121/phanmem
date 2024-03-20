<?php
/*
 * Huy write
 */
	// controller

class ProductsControllersCat extends FSControllers {
	var $module;
	var $view;
	
	function display() {
		// call models
		$model = $this->model;
		// $cat = $model->get_category ();
		$cat_all =  $model -> get_records('','fs_products_categories','id,alias,alias1,alias2');
		
		$ccode = FSInput::get ( 'ccode' );

		$checkmanu = FSInput::get ('checkmanu');

		if($checkmanu == 1){
			$cat_check_ccode = $model->get_category();
			if(!empty($cat_check_ccode) AND $ccode == $cat_check_ccode->alias ){
				$link = FSRoute::_('index.php?module=products&view=cat&cid='.$cat_check_ccode ->id.'&ccode='.$cat_check_ccode -> alias);
				setRedirect($link,$msg='',$type='',$code = 301);
			}


			
			if(empty($cat_check_ccode->alias1) AND empty($cat_check_ccode->alias2)){
				$check_ccode = strpos($ccode, $cat_check_ccode->alias);
				if($check_ccode === false) {
					$link = FSRoute::_('index.php?module=products&view=cat&cid='.$cat_check_ccode ->id.'&ccode='.$cat_check_ccode -> alias);
					setRedirect($link,$msg='',$type='',$code = 301);
				}
			}

			foreach ($cat_all as $ct) {
				if(!empty($ct->alias1) AND !empty($ct->alias2) ){
					if(strpos('"'.$ccode.'"',$ct->alias1) == true AND strpos('"'.$ccode.'"',$ct->alias2) == true){
						$cat_m = $ct->id;
						break;
					}
				}
			}
		}


		$style_types_rule = array('doi-1'=>'1 đổi 1 13 tháng','gia-soc'=>'Giá sốc','tra-gop'=>'Trả góp 0%','bao-hanh-24'=>'BH 24 tháng','doi-1-24'=>'1 đổi 1 24 tháng','hot-sale'=>'Hot sale','bh-ca-roi-vo'=>'BH cả rơi vỡ');

		if(isset($cat_m) AND !empty($cat_m)){
			$cat = $model->get_record('published = 1 AND id = ' . $cat_m,'fs_products_categories','*');
		}else{
			$cat = $model->get_category ();
			// print_r($cat);die;
			if($cat->id != FSInput::get('cid')){
				$link = FSRoute::_('index.php?module=products&view=cat&cid='.$cat ->id.'&ccode='.$cat -> alias);
				setRedirect($link,$msg='',$type='',$code = 301);
			}
		}

		// print_r($cat);die;

		if (! $cat) {
			$link = FSRoute::_('index.php?module=notfound&view=notfound&Itemid=1000');
			setRedirect($link,$msg='',$type='',$code = 301);
		}

		if($cat->alias != FSInput::get('ccode') AND $checkmanu !=1 ){
			$link = FSRoute::_('index.php?module=products&view=cat&cid='.$cat ->id.'&ccode='.$cat -> alias);
			setRedirect($link,$msg='',$type='',$code = 301);
		}

		if($cat-> tag_group) {

			$tag_group = $model->get_products_tag_group ( $cat->tag_group);

		}
		

		// printr($cat);

		$amp = FSInput::get ( 'amp', 0, 'int' );
		$raw = FSInput::get ( 'raw', 0, 'int' );

		$filter = FSInput::get ( 'filter' );	

		$checkmanu = FSInput::get ('checkmanu');
		$filter_old ='';
		$filter_manu ='';
		if($checkmanu == 1){
			if(!empty($cat->alias1) AND !empty($cat->alias2)){
				$cat_m_manu ='';
				$cat_m_manu  = str_replace($cat->alias1.'-','',$ccode);
				$cat_m_manu  = str_replace('-'.$cat->alias2,'',$cat_m_manu);
				if(!empty($cat_m_manu)){
					if($filter){
						$filter .= ','.$cat_m_manu;
					}else{
						$filter = $cat_m_manu;
					}
					$filter_manu = $filter;
				}
			}


			if(!empty($cat_m_manu)){
				if($filter){
					$filter .= ','.$cat_m_manu;
				}else{
					$filter = $cat_m_manu;
				}
				$filter_manu = $filter;
				$filter_old =  $cat_m_manu;
			}


			if(!empty($filter_old) || $filter_old=='' AND $cat->alias2==''){
				$filter_old = str_replace($cat->alias.'-','',$ccode);
				if($filter){
					$filter .= ','.$filter_old;
				}else{
					$filter = $filter_old;
				}
				$filter_manu = $filter;
			}
			

			$check_alias_manu  = $model->get_record('alias = "'.$filter_old.'"','fs_manufactories');
			if(empty($check_alias_manu)){
				$link = FSRoute::_('index.php?module=products&view=cat&cid='.$cat ->id.'&ccode='.$cat -> alias);
				setRedirect($link,$msg='',$type='',$code = 301);
			}
			
		}



		
		$sub_cats = $model -> get_sub_cats($cat -> id);	
		if(empty($sub_cats)) {
			$sub_cats = $model -> get_sub_cats($cat -> parent_id);	
		}
		$parent_cat = $model-> get_record('id = '.$cat -> parent_id, 'fs_products_categories','*');
		
		$query_body = $model -> set_query_body($cat);
		$check = $model -> check_cats_parent($cat-> id);

		$first_item = $model -> get_first_item($query_body, $cat -> tablename,$cat -> level);

		// print_r($first_item);

		$list = $model -> get_list($query_body,$cat -> tablename,$cat -> level,@$first_item-> is_special);



		// if($list[0])

		if(!empty($list)){
			foreach ($list as $item) {
				$item_p = $model-> get_record('id = '.$item-> id,'fs_products','rate_count,rate_sum,image_hot');
				$item-> rate_sum = $item_p-> rate_sum;
				$item-> rate_count = $item_p-> rate_count;
				$item-> image_hot = $item_p-> image_hot;

				$check_sale_off = $model -> check_sale_off($item-> id);
				if($check_sale_off) {
					$item-> price = $check_sale_off-> price;
					$item -> sale_off = 1;
				}else{
					$item -> sale_off = 0;
				}

			}
		}


		$sort = FSInput::get ( 'sort' );	
		if($sort && $sort == 'gia-cao-nhat'){
			$list2 = array();
			foreach($list as $k => $v){
				$list2[$v->price.$v->id]= $v;
			}

			$list = $list2;
			krsort($list);
		}elseif($sort && $sort == 'gia-thap-nhat'){
			$list2 = array();
			foreach($list as $k => $v){
				$list2[$v->price.$v->id]= $v;
			}

			$list = $list2;
			ksort($list);
		}
		
		

		$total = $model->getTotal ( $query_body );
		
			$total_add_seo = 0; // nếu > 3 là ko chuyển qua dùng canonical
			$total_add_manu = 0;
			$tablename = $cat->tablename;
			$pagination = $model->getPagination ( $total );
			// $types = $model->get_types ();
			$arr_order = array (array (null, 'Sắp xếp theo' ), array ('gia-tang', 'Giá tăng dần' ), array ('gia-giam', 'Giá giảm dần' ), //					array('san-pham-cu','Cũ'),
			//					array('san-pham-moi','Mới'),
				array ('alpha', 'A -> Z' ) );
			//			$style  = FSInput::get('style'); 
			$sort = FSInput::get ( 'sort', 'moi-nhat' );
			//			$link_list = FSRoute::addParameters('style','list');
			//			$link_grid = FSRoute::addParameters('style','');
			if($sort)
				$total_add_seo ++;

			$page = FSInput::get('page');
			if($page > 1)
				$total_add_seo ++;

			$array_menu = array (
				array ('gia-thap-nhat', 'Giá thấp' ),array ('gia-cao-nhat', 'Giá cao' ),
				array ('moi-nhat', 'Mới nhất' ));
			global $tmpl,$module_config;
			$title = $cat-> name;
			$description = '';
			$description_manufactory = '';
			$str_manufactory_title = '';
			$manufactory_id = 0;

			$relate_news = $model->get_relate_news ( $cat->news_related ,'','');
			$relate_videos = $model->get_relate_videos ( $cat->videos_related ,'','');


			// $relate_aq = $model->get_relate_aq ( $cat->aq_related ,'','');
			$types = $model -> get_types();
			
			// set SEO follow filter
			if ($filter) {
				$arr_filter = explode ( ',', $filter );


				$arr_standart_filter = array ();
				for($i = 0; $i < count ( $arr_filter ); $i ++) {
					$filter_item = $arr_filter [$i];
					if ($filter_item) {
						$arr_standart_filter [] = "'" . $filter_item . "'";
					}
				}
				$total_add_seo += count ( $arr_standart_filter );
				if (count ( $arr_standart_filter )) {
					$str_standart_filter = implode ( ",", $arr_standart_filter );
					
					$filter_from_db = $model->getFilterFromRequest ( $str_standart_filter,$cat -> tablename,1 );
//						print_r($filter_from_db);
//						die;
					$seo_title_filter = '';
					$seo_keyword_filter = '';
					$seo_description_filter = '';
						// 	get filter in table fs_products_filter follow request
					for($i = 0; $i < count ( $arr_filter ); $i ++) {
						$filter_item = $arr_filter [$i];
						if ($filter_item) {
							if(!isset($filter_from_db[$filter_item]))
								continue;
							$filter_data = $filter_from_db[$filter_item];
							if($filter_data -> seo_title && $filter_data -> is_seo == 1 ){
									//$tmpl -> addTitle($filter_data -> seo_title;);

								if(!empty($cat->name1) AND !empty($cat->name2)){
									$seo_title_filter = $filter_data -> seo_title;
								}else{
									if($seo_title_filter){
										$seo_title_filter .= ' - ';
									}
									$seo_title_filter .= $filter_data -> seo_title;
									
								}
							}
							if($filter_data -> seo_meta_key)									
							{
								if($seo_keyword_filter){
									$seo_keyword_filter .= ' - ';
								}
								$seo_keyword_filter .= $filter_data -> seo_meta_key;
							}
							if($filter_data -> seo_meta_des){
								if($seo_description_filter){
									$seo_description_filter .= ' - ';
								}
								$seo_description_filter .= $filter_data -> seo_meta_des;
							}

							if(!$filter_data->is_seo){
								$total_add_seo += 1000;
							}

							



							if(@$filter_data->field_name == 'manufactory'){
								


								$manufactory_id = $filter_data->filter_value;
//									$manufactory_name = $filter_data->filter_show;
//									$manufactory_alias = $filter_data->alias;
								if($str_manufactory_title){
									// $str_manufactory_title .= ' - ';
								}
								if(!empty($cat->name1) AND !empty($cat->name2)){

									$str_manufactory_title = $filter_data->filter_show;
								}else{
									$str_manufactory_title .= $filter_data->filter_show;
								}

									// Nếu HSX đứng đầu thì chưa làm canonical
								if(!$i){
									$total_add_seo --;
								}
								$total_add_manu ++;

								if($filter_data -> description){
										// $cat->description_filter = $filter_data -> description;
									$description_manufactory = $filter_data -> description;
								}
								if($filter_data -> description_cat ){
									$description_manufactory_cat = $filter_data -> description_cat;
								}

								if($checkmanu != 1){

									$link = FSRoute::_('index.php?module=products&view=cat&cid='.$cat -> id.'&ccode='.$cat -> alias.'&manu='.$filter_data->alias.'&checkmanu=1');
									
									setRedirect($link,$msg='',$type='',$code = 301);
								}

							}else{
								if(@$filter_data->field_name == 'nhu_cau_su_dung') {
									$str_nhu_cau_su_dung_title = @$filter_data->filter_show;
								}

								if($filter_data -> description){
										// $cat->description_filter = $filter_data -> description;
									$description = $filter_data -> description;
								}
								if($filter_data -> description_cat){
									$description_cat = $filter_data -> description_cat;
								}

							}
						}

					}


					if($str_manufactory_title){
						// echo $str_manufactory_title;
						// die;
						if(!empty($cat->name1) AND !empty($cat->name2)){
							$title = $cat->name1 . ' ' . $str_manufactory_title . ' '. $cat->name2;
						}else{
							$title .= ' '.$str_manufactory_title;
						}
					}

					if(@$str_nhu_cau_su_dung_title){
						$title .= ' '.$str_nhu_cau_su_dung_title;
					}




					if($seo_title_filter){
						$seo_title_filter = str_replace('{name}', $title, $seo_title_filter);
						$cat -> seo_title_filter = $seo_title_filter;
					}
					if($seo_keyword_filter){
						$seo_keyword_filter = str_replace('{name}', $title, $seo_keyword_filter);
						$cat -> seo_keyword_filter = $seo_keyword_filter;
					}
					if($seo_description_filter){
						$seo_description_filter = str_replace('{name}', $title, $seo_description_filter);
						$cat -> seo_description_filter = $seo_description_filter;			
					}
					// echo $filter_manu;
					// die;
					if(!empty($filter_manu) && $filter_manu !='' && $checkmanu == 1){
						$filter_manu_arr = explode(',',$filter_manu);
						// printr($filter_manu_arr);
						// echo $filter_manu_arr[count($filter_manu_arr) - 1];

						if(!empty($filter_manu_arr)){
							
							$manufactory_act = $model->get_record('alias="'.$filter_manu_arr[0].'"','fs_manufactories','id,name');

							$cat-> name = $cat-> name.' '.@$manufactory_act-> name;
							

							if(!empty($manufactory_act)){
								$seo_manu_cat = $model->get_record('manufactory_id = '.$manufactory_act->id . ' AND category_id = ' .$cat->id,'fs_products_categories_seo_manufactory','seo_title,seo_keyword,seo_description');
								if(!empty($seo_manu_cat)){

									if($seo_manu_cat-> seo_title){
										$cat -> seo_title_filter = $seo_manu_cat-> seo_title;
									}
									if($seo_manu_cat-> seo_keyword){
										$cat -> seo_keyword_filter = $seo_manu_cat-> seo_keyword;
									}
									if($seo_manu_cat-> seo_description){
										$cat -> seo_description_filter = $seo_manu_cat-> seo_description;
									}
								}
							}
							
						}	
					}
				}
			}
			
			if(!$description){
				$description = $description_manufactory;
			}
			if(!$description){
				$description = $cat -> summary;
			}
			if($description){
				$description = str_replace('{name}', $title, $description);
			}


		// seo

			if(!$raw) {
				$tmpl -> set_data_seo($cat);
			}
			
			$relate_aq = $model->get_relate_aq_new($cat,$checkmanu,$manufactory_id);
			// printr($relate_aq);
		// breadcrumbs
			$lis_cat_parent = $model->get_list_parent ( $cat->list_parents, $cat->id );
			$breadcrumbs = array ();
			// print_r($lis_cat_parent);
			// die;
			$k = 0;
			for($i = count ( $lis_cat_parent ); $i > 0; $i --) {
				$item = $lis_cat_parent [$i - 1];
				
				$breadcrumbs [] = array (0 => $item->name, 1 => FSRoute::_ ( 'index.php?module=products&view=cat&ccode=' . $item->alias."&cid=".$item ->id . '&Itemid=10' ) );
				$cat_parent = $model -> get_records('published =1 AND parent_id = ' . $item->id,'fs_products_categories','id, name, alias','ordering ASC');
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

			$cat_root = isset($lis_cat_parent[count ( $lis_cat_parent ) - 1])?$lis_cat_parent[count ( $lis_cat_parent ) - 1]:$cat;


			$breadcrumbs [] = array (0 => $cat->name, 1 => FSRoute::_ ( 'index.php?module=products&view=cat&ccode=' . $cat->alias."&cid=".$cat ->id . '&Itemid=10' ) );

			$cat_parent = $model -> get_records('published =1 AND parent_id = ' . $cat->id,'fs_products_categories','id, name, alias','ordering ASC');
			
			if(!empty($cat_parent)){
				$cat_parent_arr = array();
				foreach ($cat_parent as $key => $it) {

					$cat_parent_arr[$key][0] = $it->name;
					$cat_parent_arr[$key][1] = FSRoute::_('index.php?module='.$this->module.'&view=cat&ccode='.$it->alias.'&cid='.$it->id.'&Itemid=86');
				}
				// printr($cat_parent_arr);
				$breadcrumbs[$k][2] = $cat_parent_arr	;
			}



			$manufactories_request = FSInput::get ('filter', '');
			
		// print_r($manufactories_request);
		// die;
			if($manufactories_request){
				$arr_manufactories_request = explode(',',$manufactories_request);
			// chỉ đưa ra ngoài breadcrumb nếu chọn 1 bộ lọc hãng sản xuất
				if(count($arr_manufactories_request) == 1){
					$manu_alias = $arr_manufactories_request[0];
					$manu = $model -> get_record('alias = "'.$manu_alias.'"','fs_manufactories');


					if($manu){
						$breadcrumbs [] = array (0 => $manu->name, 1 => FSRoute::_ ( 'index.php?module=products&view=cat&ccode=' . $cat->alias."&cid=".$cat ->id . '&filter=' . $manu->alias ));
					}
				}
			}
			if($manufactory_id){
				$manu = $model -> get_manufactory_by_id($manufactory_id);
			}

			
			//print_r($breadcrumbs);

			if(!$raw) {
				$tmpl->assign ( 'breadcrumbs', $breadcrumbs );
				$tmpl->assign ( 'tablename', $tablename );

		// seo
				$tmpl->set_data_seo ( $cat );

			} 



			$canonical = '';
			if($total_add_manu)
				$total_add_seo =  $total_add_seo > $total_add_manu ? $total_add_seo: $total_add_manu;
			if(isset($arr_standart_filter)){
				$count_arr_standart_filter = count($arr_standart_filter);
			}else{
				$count_arr_standart_filter =  0;
			}

			if(isset($filter_from_db)){
				$count_filter_from_db = count($filter_from_db);
			}else{
				$count_filter_from_db = 0;
			}

			



			// if($checkmanu == 1){
			// 	$count_filter_from_db +=1;

			// }
			
		// 		echo $count_arr_standart_filter;

		// 	echo '----';
		// // die;
		// 	echo $count_filter_from_db;
		// 	die;

			// if($count_arr_standart_filter != $count_filter_from_db ){
			// 	$link_canonical = FSRoute::_('index.php?module=products&view=cat&ccode=' . $cat->alias."&cid=".$cat ->id );
			// 	setRedirect($link_canonical);
			// }


			if($checkmanu == 1){
				// printr($filter_data);
				$link_canonical = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

				$canonical = $link_canonical;
				$tmpl -> assign('seo_index',1);

				if($count_arr_standart_filter >= 2){
					$tmpl -> assign('seo_index',0);
					$canonical = URL_ROOT . $ccode .'-pcm'.$cat->id.'.html';
				}

				if(!empty($filter_data) AND $filter_data->is_seo==0 ){
					$tmpl -> assign('seo_index',0);
					$canonical = FSRoute::_('index.php?module=products&view=cat&ccode=' . $cat->alias."&cid=".$cat ->id );
				}

			}else{
				if(!empty($cat->name1) AND !empty($cat->name2)){

					if($total_add_seo > 2){
						$canonical = FSRoute::_('index.php?module=products&view=cat&ccode=' . $cat->alias."&cid=".$cat ->id );
					}
				}else{
					if($total_add_seo > 1 || $count_arr_standart_filter != $count_filter_from_db ){
						$canonical = FSRoute::_('index.php?module=products&view=cat&ccode=' . $cat->alias."&cid=".$cat ->id );
					}
				}
			}


		//show sản phẩm đặc biệt theo hãng
			$list_manus_special = $model -> get_records('show_product_special_cat = 1 AND published = 1', 'fs_manufactories','*','ordering ASC');
			$array_manu_special = array();
			$array_products_special = array();

			foreach (@$list_manus_special as $manu_special)
			{

				$products_in_manu_special = $model -> getProductsManuSpecial($cat,$manu_special->id );

				if(!empty($products_in_manu_special)){
					$array_manu_special[] = $manu_special;
					$array_products_special[$manu_special->id] = $products_in_manu_special;	
				}

			}



		// printr($array_products_special);




		// if(!empty($filter) || !empty($sort)){
		// 	$canonical = FSRoute::_('index.php?module=products&view=cat&ccode=' . $cat->alias."&cid=".$cat ->id );
		// }
			$title = $cat-> name;
			if(!empty($cat->schema)){
				$tmpl->addHeader($cat->schema);
			}

			if(!$raw) {
				$this -> set_header(str_replace('/original/','/resized/',@$list[0]-> image ),  $canonical,$cat);
			}
			
			// call views
			if($cat-> is_accessories == 1 && $cat-> level == 0) {
				include 'modules/' . $this->module . '/views/' . $this->view.($amp?'_amp':'') . '/default_ppk.php';
			} else {
				if($cat-> is_accessories == 1) {
					include 'modules/' . $this->module . '/views/' . $this->view.($amp?'_amp':'') . '/default_pk.php';
				} else {
					include 'modules/' . $this->module . '/views/' . $this->view.($amp?'_amp':'') . '/default.php';
				}
			}
			
		}
		/*
		 * Táº¡o ra cÃ¡c tham sá»‘ header ( cho fb)
		 */
		function set_header($image_first = '' , $canonical = '',$data){
			
			$str = '';
			$image =  URL_ROOT.$image_first; 
			$str .= '<meta property="og:image"  content="'.$image.'" />
			<meta property="og:image:width" content="600 "/>
			<meta property="og:image:height" content="315"/>
			';
			$amp = FSInput::get('amp',0,'int');
			
			global $tmpl;
			if(!$amp){
				if($canonical){
					$tmpl->assign ('canonical', $canonical);	
					// die;

				}else{
					$link = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; 
					$str .= '<link rel="amphtml" href="'.str_replace('.html','.amp',$link).'">';	
				}				
			}else{
				if($canonical){
					// $link = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; 
					// $link =  str_replace('.amp','.html',$link);			
					// $str .= '<meta name="robots" content="noindex,nofollow">';
			//		setRedirect($link);
					
				}
			}
			global $tmpl;
			$tmpl -> addHeader($str);

			if($data -> nofollow == 1){
				$tmpl->assign ('noindex', 'NOINDEX,NOFOLLOW');
			}
		}

		function amp_add_size_into_img($content){
			preg_match_all('#<img(.*?)>#is',$content,$images);
			$arr_images = array();
			if(!count($images[0]))
				return $content;
			$i = 0;
			foreach($images[0] as $item){			
				
				unset($height);
				preg_match('#height([\s]*)=([\s]*)[\'|\"](.*?)[\'|\"]#is',$item,$height);

				if(!isset($height[3])){
					$item_new = str_replace('<img','<img height="400" ', $item);
		// $content = str_replace($item,$item_new, $content);
				}elseif(!$height[3]){
					$item_new = preg_replace('%height([\s]*)=([\s]*)[\'|\"](.*?)[\'|\"]%i', 'height="402"', $item);

		// $content = str_replace($item,$item_new, $content);
				}else{
					$item_new = $item;
		// $content = str_replace($item,$item_new, $content);
				}

				unset($width);
				preg_match('#width([\s]*)=([\s]*)[\'|\"](.*?)[\'|\"]#is',$item_new,$width);
				if(!isset($width[3])){
					$item_new_2 = str_replace('<img','<img width="600" ', $item_new);
		// $content = str_replace($item_new,$item_new_2, $content);
				}elseif(!$width[3]){
					$item_new_2 = preg_replace('%width([\s]*)=([\s]*)[\'|\"](.*?)[\'|\"]%i', 'width="602"', $item_new);
		// $content = str_replace($item_new,$item_new_2, $content);
				}else{
					$item_new_2 = preg_replace('%width([\s]*)=([\s]*)[\'|\"](.*?)[\'|\"]%i', 'width="601"', $item_new);
		// $content = str_replace($item_new,$item_new_2, $content);
				}

				if($item != $item_new_2){
					$content = str_replace($item,$item_new_2, $content);
				}


			}

			return $content;	
		}
	}
	
	?>