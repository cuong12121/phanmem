<?php
	class PromotionControllersPromotion extends Controllers
	{
		function __construct()
		{
			$this->view = 'promotion' ; 
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
		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			$categories  = $model->get_categories_tree();
//			$tags_categories = $model->get_tags_categories();
			$data = $model->get_record_by_id($id);
			// data from fs_news_categories
			
			$promotion_products = $model -> get_promotion_products($data -> id);
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
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
	}
?>