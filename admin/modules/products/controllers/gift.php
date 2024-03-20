<?php
	class ProductsControllersGift extends Controllers
	{
		function __construct()
		{
			$this->view = 'gift' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $model->get_data();
			$pagination = $model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		function add(){
			$model = $this -> model;
			$categories = $model->get_categories_tree();
			$categories_filter = $model->get_categories_filter();
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}

		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			// $categories  = $model->get_categories_tree();
//			$tags_categories = $model->get_tags_categories();
			$data = $model->get_promotion($id);
			// printr($data);
			// data from fs_news_categories
			// echo $data->promotion_products;die;
			// @$promotion_products = $model -> get_promotion_products($data->promotion_products);
			// @$promotion_manufactory = $model -> get_promotion_manufactory($data->promotion_manufactory);
			$products_categories = $model->get_products_categories_tree();
			$products_related = $model -> get_products_related($data -> products_related);
			$products_gift = $model -> get_products_gift($data -> products_gift);
			$manufactory_related = $model -> get_manufactory_related($data -> manufactory_related);



			$category_id_wrapper = explode(',',$data ->category_id_wrapper);
			unset($category_id_wrapper[count($category_id_wrapper) - 1]);
			unset($category_id_wrapper[0]);
			$category_id_wrapper_str = implode(',',$category_id_wrapper);
			$category_id_wrapper_select = $model -> get_records('id IN ('. $category_id_wrapper_str .')','fs_products_categories','name');
			$category_id_wrapper_select_name = '';
			foreach($category_id_wrapper_select as $csl) {
				$category_id_wrapper_select_name .=  $csl->name .' ,';
			}


			$categories = $model->get_categories_tree();
			// all categories
			$categories_filter = $model->get_categories_filter();


			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}


		function ajax_get_manufactory_related(){
			$model = $this -> model;
			$data = $model->ajax_get_manufactory_related();
			$html = $this -> manufactory_genarate_related($data);
			echo $html;
			return;
		}
		
		function manufactory_genarate_related($data){
			$str_exist = FSInput::get('str_exist');
			$html = '';
				$html .= '<div class="manufactory_related">';
				foreach ($data as $item){
					if($str_exist && strpos(','.$str_exist.',', ','.$item->id.',') !== false ){
						$html .= '<div class="red manufactory_related_item  manufactory_related_item_'.$item -> id.'" onclick="javascript: set_manufactory_related('.$item->id.')" style="display:none" >';	
						$html .= $item -> name;				
						$html .= '</div>';					
					}else{
						$html .= '<div class="manufactory_related_item  manufactory_related_item_'.$item -> id.'" onclick="javascript: set_manufactory_related('.$item->id.')">';	
						$html .= $item -> name;				
						$html .= '</div>';	
					}
				}
				$html .= '</div>';
				return $html;
		}


		function ajax_get_products_related(){
			$model = $this -> model;
			$data = $model->ajax_get_products_related();
			$html = $this -> products_genarate_related($data);
			echo $html;
			return;
		}
		function products_genarate_related($data){
			$str_exist = FSInput::get('str_exist');
			$html = '';
				$html .= '<div class="products_related">';
				foreach ($data as $item){
					if($str_exist && strpos(','.$str_exist.',', ','.$item->id.',') !== false ){
						$html .= '<div class="red products_related_item  products_related_item_'.$item -> id.'" onclick="javascript: set_products_related('.$item->id.')" style="display:none" >';	
						$html .= $item -> name;				
						$html .= '</div>';					
					}else{
						$html .= '<div class="products_related_item  products_related_item_'.$item -> id.'" onclick="javascript: set_products_related('.$item->id.')">';	
						$html .= $item -> name;				
						$html .= '</div>';	
					}
				}
				$html .= '</div>';
				return $html;
		}

		function ajax_get_products_gift(){
			$model = $this -> model;
			$data = $model->ajax_get_products_gift();
			$html = $this -> products_genarate_gift($data);
			echo $html;
			return;
		}
		function products_genarate_gift($data){
			$str_exist = FSInput::get('str_exist');
			$html = '';
				$html .= '<div class="products_gift">';
				foreach ($data as $item){
					if($str_exist && strpos(','.$str_exist.',', ','.$item->id.',') !== false ){
						$html .= '<div class="red products_gift_item  products_gift_item_'.$item -> id.'" onclick="javascript: set_products_gift('.$item->id.')" style="display:none" >';	
						$html .= $item -> name;				
						$html .= '</div>';					
					}else{
						$html .= '<div class="products_gift_item  products_gift_item_'.$item -> id.'" onclick="javascript: set_products_gift('.$item->id.')">';	
						$html .= $item -> name;				
						$html .= '</div>';	
					}
				}
				$html .= '</div>';
				return $html;
		}






		// remove products_together
		function remove_product(){
			$model  = $this -> model;
			if($model -> remove_promotion_product()){
				echo '1';
				return;
			}else{
				echo '0';
				return;
			}
		}

		function remove_manu(){
			$model  = $this -> model;
			if($model -> remove_promotion_manu()){
				echo '1';
				return;
			}else{
				echo '0';
				return;
			}
		}
		
		function published()
	{
		$model = $this -> model;
		$rows = $model->published(1);
		$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
		$page = FSInput::get('page',0);
		if($page > 1)
			$link .= '&page='.$page;	
		if($rows)
		{
			setRedirect($link,$rows.' '.FSText :: _('record was published'));	
		}
		else
		{
			setRedirect($link,FSText :: _('Error when published record'),'error');	
		}
	}
	function unpublished()
	{
		$model = $this -> model;
		$rows = $model->published(0);
		$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
		$page = FSInput::get('page',0);
		if($page > 1)
			$link .= '&page='.$page;
		if($rows)
		{
			setRedirect($link,$rows.' '.FSText :: _('record was unpublished'));	
		}
		else
		{
			setRedirect($link,FSText :: _('Error when unpublished record'),'error');	
		}
	}
	
	function remove()
	{
		$id = FSInput::get('id',0,'int');
		$model = $this -> model;

		$rows = $model->remove();
		if($rows)
		{
			setRedirect('index.php?module='.$this -> module.'&view='.$this -> view,$rows.' '.FSText :: _('record was deleted'));	
		}
		else
		{
			setRedirect('index.php?module='.$this -> module.'&view='.$this -> view,FSText :: _('Not delete'),'error');	
		}
	}
	}
?>