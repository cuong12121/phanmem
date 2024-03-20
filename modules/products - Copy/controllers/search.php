<?php
/*
 * Huy write
 */
// controller


class ProductsControllersSearch extends FSControllers {
	var $module;
	var $view;
	
	function display() {
		// call models
		$model = $this->model;
		
		$query_body = $model->set_query_body ();

		$query_body_cat = $model->set_query_body_cat ();
		$list_cat = $model->get_list_cat ( $query_body_cat );

		$query_body_manf = $model->set_query_body_manf ();
		$list_manf = $model->get_list_manf ( $query_body_manf );

		// print_r($list_cat);

		$list = $model->get_list ( $query_body );
		$list_sell = $model->get_list_sell ();
		
		$news_query_body = $model->set_new_query_body ();

		$news_list = $model->get_list_next ( $news_query_body );
		
		$total = $model->getTotal ( $query_body );
		$pagination = $model->getPagination ( $total );
		$types = $model->get_types ();
		$keyword = FSInput::get ( 'keyword' );
		$cat = FSInput::get ( 'cat' );
		$manf = FSInput::get ( 'manf' );
		$cat_act = $model ->  get_cat($cat);
		$manf_act = $model ->  get_manf($manf);

		if (! $keyword)
			return;
		$array_menu = array (array ('ban-chay-nhat', 'Bán chạy nhất' ), array ('khuyen-mai', 'Khuyễn mãi' ), array ('gia-thap-nhat', 'Giá từ thấp tới cao' ), array ('gia-cao-nhat', 'Giá từ cao tới thấp' ), array ('moi-nhat', 'Mới nhất' ), array ('xem-nhieu', 'Xem nhiều' ) );
		
		global $tmpl, $module_config;
		$str_manufactory_title = '';
		$title = '"' . $keyword . '" - tìm kiếm';
		if($cat_act || $manf_act ) {
			$title .= ' trong';
		}
		if ($cat_act) {
			$title .= ' danh mục '.$cat_act-> name;
		}
		if ($manf_act) {
			$title .= ' thương hiệu '.$manf_act-> name;
		}
		
		// breadcrumbs
		$breadcrumbs [] = array (0 => 'Tìm kiếm', 1 => '' );
		global $tmpl;
		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );
		$tmpl->assign ( 'noindex', 1 );
		$tmpl->assign ( 'canonical', URL_ROOT);
		
		// call views			
		include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';
	}
		function fetch_pages(){
		// call models
			$pagecurrent = FSInput::get('pagecurrent',0,'int');
			$model = $this -> model;
	
			$query_body = $model -> set_query_body();
			$total = $model -> getTotal($query_body);
			$types = $model -> get_types();
			$list = $model -> get_list($query_body);
			if(!$list)
				return ;
			
			
			$totalCurrent = $pagecurrent+ count($list);
			// Lấy loại 
			$arr_products=array();
	
			include 'modules/'.$this->module.'/views/'.$this->view.'/fetch_pages.php';
			
			$arr_products['content']= $html;
			if($totalCurrent < $total )
				$arr_products['next']= 'true';
			$arr_products['totalCurrent']=$totalCurrent;
			
			echo json_encode($arr_products);
			
			return ;
		}
		function get_ajax_search(){
			
	        $result =  array();
		        $model = new ProductsModelsSearch();
		        $list = $model->get_ajax_search();
		        // $query = isset($_GET['query']) ? $_GET['query'] : FALSE;
		      
		        if($list){
		            foreach($list as $item){
						$price = calculator_price($item->price,$item->price_old,$item -> is_hotdeal,$item->date_start,$item->date_end);		
		                $result[] = array(
		                	'value' =>  FSRoute::_('index.php?module=products&view=product&code='.$item->alias.'&id='.$item -> id.'&ccode='.$item->category_alias),
		                    'data' => array(
        									'text'=>$item->name,
        									"brand"=>$item->category_name,
        									"price"=>format_money($price['price']),
        									"image"=> URL_ROOT.str_replace('/original/', '/resized/', $item->image),
										)
		                );
		            }
		        }
		        

		        $sugges_result = array( 
				        	'query' =>  FSInput::get('query'),
				        	'suggestions' =>  $result
		        			);
		        echo json_encode($sugges_result);        			
	    	}
	
		function get_ajax_search_compare(){

	        $result =  array();
	        $ids = FSInput::get('ids');
	        $codes = FSInput::get('codes');
	        $table_name = FSInput::get('table_name');
		        $model = new ProductsModelsSearch();
		       $list = $model->get_ajax_search_compare($ids,$table_name);
		        // $query = isset($_GET['query']) ? $_GET['query'] : FALSE;
		      
		        if($list){
		            foreach($list as $item){
		            	$ids_cp = $ids?str_replace(',','-',$ids).'-'.$item ->id:$item -> id;
		            	$codes_cp = $codes?$codes.'-va-'.$item ->alias:$item -> alias;
						$price = calculator_price($item->price,$item->price_old,$item -> is_hotdeal,$item->date_start,$item->date_end);		
		                $result[] = array(
		                	'value' =>  FSRoute::_('index.php?module=products&view=compare&ids='.$ids_cp.'&codes='.$codes_cp),
		                	
		                    'data' => array(
        									'text'=>$item->name,
        									"brand"=>$item->category_name,
        									"price"=>format_money($price['price']),
        									"image"=> URL_ROOT.str_replace('/original/', '/resized/', $item->image),
										)
		                );
		            }
		        }

		        $sugges_result = array( 
				        	'query' =>  FSInput::get('query'),
				        	'suggestions' =>  $result
		        			);
		        echo json_encode($sugges_result);        			
	    	}
	
	
	}
?>