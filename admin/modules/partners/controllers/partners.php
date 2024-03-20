<?php
class PartnersControllersPartners extends Controllers {

		function __construct()
		{
			// parent::display();
			// $sort_field = $this -> sort_field;
			// $sort_direct = $this -> sort_direct;
			$this->view = 'strengths' ; 
			parent::__construct(); 
		}
	function display() {
		parent::display ();
		$sort_field = $this->sort_field;
		$sort_direct = $this->sort_direct;
		
		$model = $this->model;
		$list = $model->get_data ();
			$categories = $model->get_categories_tree();
		
		$pagination = $model->getPagination ();
		include 'modules/' . $this->module . '/views/' . $this->view . '/list.php';
	}
	function add()
	{
		$model = $this -> model;
			$categories = $model->get_categories_tree();
			$maxOrdering = $model->getMaxOrdering();
		
		$uploadConfig = base64_encode('add|'.session_id());


		include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		
	}
	function edit()
	{
		$ids = FSInput::get('id',array(),'array');
	
		
		$id = $ids[0];
		$model = $this -> model;
			$categories = $model->get_categories_tree();
$data = $model->get_record_by_id($id,FSTable_ad::_ ('fs_partners'));
		
		$this->params_form = array('ext_id'=>@$data_ext -> id) ;			
			$uploadConfig = base64_encode('edit|'.$id);	


		include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		
	}
	function is_hot() {
		$model = $this->model;
		$rows = $model->hot ( 1 );
		$link = 'index.php?module=' . $this->module . '&view=' . $this->view;
		$page = FSInput::get ( 'page', 0 );
		if ($page > 1)
			$link .= '&page=' . $page;
		if ($rows) {
			setRedirect ( $link, $rows . ' ' . FSText::_ ( 'record was event' ) );
		} else {
			setRedirect ( $link, FSText::_ ( 'Error when hot record' ), 'error' );
		}
	}
	function unis_hot() {
		$model = $this->model;
		$rows = $model->hot ( 0 );
		$link = 'index.php?module=' . $this->module . '&view=' . $this->view;
		$page = FSInput::get ( 'page', 0 );
		if ($page > 1)
			$link .= '&page=' . $page;
		if ($rows) {
			setRedirect ( $link, $rows . ' ' . FSText::_ ( 'record was un_hot' ) );
		} else {
			setRedirect ( $link, FSText::_ ( 'Error when un_hot record' ), 'error' );
		}
	}
	function get_other_images() {
		$list_other_images = $this->model->get_other_images ();
		include 'modules/' . $this->module . '/views/' . $this->view . '/detail_images_list.php';
	}
	/**
	 * Upload nhiều ảnh cho sản phẩm
	 */
	function upload_other_images() {
		$this->model->upload_other_images ();
	}
	/**
	 * Xóa ảnh
	 */
	function delete_other_image() {
		$this->model->delete_other_image ();
	}
	
	/**
	 * Sắp xếp ảnh
	 */
	function sort_other_images() {
		$this->model->sort_other_images ();
	}
	
	/*
    	 * Sửa thuộc tính của ảnh
    	 */
	function change_attr_image() {
		$this->model->change_attr_image ();
	}
	function getAjaxImagespn(){
		$listimages = $this->model->getAjaxImagespn();   
		//print_r($listImages);
		include 'modules/' . $this->module . '/views/' . $this->view . '/detail_pn_images_list.php';
	} 
	function uploadAjaxImagespn(){

		$this->model->uploadAjaxImagespn();
	}
	function add_title_other_imagess(){
		$this->model->add_title_other_imagess();
	}
	function delete_other_imagess(){
		$this->model->delete_other_imagess();
	}
	function sort_other_imagess(){
		$this->model->sort_other_imagess();
	} 
}
?>