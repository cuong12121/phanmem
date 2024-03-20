<?php
/*
 * Huy write
 */
	// controller
	
	class ProductsControllersFavourites
	{
		var $module;
		var $view;
		function __construct()
		{
			
			$this->module  = 'products';
			$this->view  = 'favourites';
			include 'modules/'.$this->module.'/models/'.$this->view.'.php';
		}
		function display()
		{
			$fssecurity  = FSFactory::getClass('fssecurity');
            $fssecurity -> checkLogin();
			$model = new ProductsModelsFavourites();
			
			$str_product_id = $model -> get_favourite_ids();
			$query_body = $model -> set_query_body($str_product_id);
			$data  = $model -> getFavourites($query_body);
			$total = $model -> getTotal($query_body);			
			$pagination = $model->getPagination($total);
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		
		/*
		 * delete record in table products_favourites
		 */
		function delete()
		{
			$fssecurity  = FSFactory::getClass('fssecurity');
            $fssecurity -> checkLogin();
			$model = new ProductsModelsFavourites();
			$Itemid = FSInput::get('Itemid');
			$url_redirect = "index.php?module=users&task=user_info&Itemid=40";
			$sort = FSInput::get('sort');
			if($sort)
				$url_redirect .= "&sort=$sort";
			$sortby = FSInput::get('sortby');
			if($sortby)
				$url_redirect .= "&sortby=$sortby";
				
			$rows = $model->delete();
			$url_redirect = FSRoute::_($url_redirect);
			if($rows)
			{
				setRedirect($url_redirect,FSText::_('Xóa thành công sản phẩm yêu thích'));	
			}
			else
			{
				setRedirect($url_redirect,FSText::_('Chưa xóa thành công'),'error');	
			}
		}
		
		/*
		 * add record into products_favourites
		 * for ajax
		 */
		function add()
		{
			$fssecurity  = FSFactory::getClass('fssecurity');
            $fssecurity -> checkLogin();
			$model = new ProductsModelsFavourites();
			$result  = $model -> save();
			if($result == 1)
			{
				echo 1;
				return;
			}
			else if($result == 2)
			{
				echo '2';
				return;
			} else {
				echo 0;
				return;
			}
		}
		function get_favourite($id){
			$model = new ProductsModelsFavourites();
			return $model -> get_favourite($id) ;
		}
		
	}
	
?>