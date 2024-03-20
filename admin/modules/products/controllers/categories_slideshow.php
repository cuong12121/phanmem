<?php
class ProductsControllersCategories_slideshow extends Controllers {
	function __construct() {
		$this->view = 'categories_slideshow';
		parent::__construct ();
	}
	function display() {
		parent::display ();
		$sort_field = $this->sort_field;
		$sort_direct = $this->sort_direct;
		
		$model = $this->model;
		$list = $model->get_data ();
		$categories = $model->get_categories ();
		
		$pagination = $model->getPagination ();
		include 'modules/' . $this->module . '/views/' . $this->view . '/list.php';
	}
	function add() {
		$model = $this->model;
		$categories = $model->get_categories ();
		
		// data from fs_news_categories
		$maxOrdering = $model->getMaxOrdering ();
		include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
	}
	
	function edit() {
		$ids = FSInput::get ( 'id', array (), 'array' );
		$id = $ids [0];
		$model = $this->model;
		$categories = $model->get_categories ();
		$data = $model->get_record_by_id ( $id );
		// data from fs_news_categories
		include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
	}
}
?>