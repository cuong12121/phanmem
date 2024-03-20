<?php

	class ProductsControllersTags extends FSControllers
	{
		var $module;
		var $view;
		function __construct()
		{
			parent::__construct ();
		}
		function display()
		{
			$model = $this->model;
			$code = FSInput::get ('code');
			if (!$code){
				return;
			}

			if(!$code){
				setRedirect(FSRoute::_('index.php?module=notfound&view=notfound'),'Link này không tồn tại');
			}


			$data = $model->get_record(' published = 1 AND alias = "'.$code.'"','fs_products_tags');

			
			
			
			if(empty($data)){
				setRedirect(FSRoute::_('index.php?module=notfound&view=notfound'),'Link này không tồn tại');
			}
			
			
			$types = $model->get_types ();
			
			$query_body = $model -> set_query_body($data);
			$list = $model -> get_list($query_body);
			$total = $model->getTotal ( $query_body );
			$pagination = $model->getPagination ( $total );
			
			$list_news = $model -> get_records('published = 1 AND is_trash = 0 AND tag_group like "%,'.$data->id.',%" ','fs_news','*','id DESC','15');

			
			global $tmpl, $module_config;

			$title = $data->name;
			// breadcrumbs
			$breadcrumbs [] = array (0 => 'Tags', 1 => '' );
			global $tmpl;
			$tmpl->assign ( 'breadcrumbs', $breadcrumbs );
			// print_r($data);
			// if(empty($list) AND empty($news_list)){
			// 	$tmpl->assign ('noindex',1);
			// }
			// $tmpl->assign ('noindex',1);
			$tmpl->assign ('canonical',URL_ROOT);
			if(!$data-> seo_title) {
				$data-> seo_title = $title;
			}
			$this->set_header($data);
   			$tmpl->set_data_seo($data);
		
			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}


		function set_header($data, $image_first = '') {
		    global $config,$tmpl;
		    $image = URL_ROOT . str_replace ( '/original/', '/large/', $data->image );
		    $str = '<meta property="og:image"  content="' . $image . '" />
		    <meta property="og:image:width" content="600 "/>
		    <meta property="og:image:height" content="315"/>
		    ';

	        if($data -> nofollow == 1){
	            $tmpl->assign ('noindex', 'NOINDEX,NOFOLLOW');
	        }
		    $tmpl->addHeader ( $str );
		  }



	
		 function get_ajax_search(){
		        $result =  array();
		        $model = new ProductsModelsSearch();
		        $list = $model->get_ajax_search();
		        // $query = isset($_GET['query']) ? $_GET['query'] : FALSE;
		      
		        if($list){
		            foreach($list as $item){
						$price = $item->price;		
		                $result[] = array(
		                	'value' =>  FSRoute::_('index.php?module=products&view=product&code='.$item->alias.'&id='.$item -> id.'&ccode='.$item->category_alias),
		                    'data' => array(
        									'text'=>$item->name,
        									"brand"=>$item->category_name,
        									"price"=>format_money($item->price),
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
						$price = $item->price;		
		                $result[] = array(
		                	'value' =>  FSRoute::_('index.php?module=products&view=compare&ids='.$ids_cp.'&codes='.$codes_cp),
		                	
		                    'data' => array(
        									'text'=>$item->name,
        									"brand"=>$item->category_name,
        									"price"=>format_money($price),
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