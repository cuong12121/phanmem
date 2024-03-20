<?php
/*
 * Huy write
 */
	// controller
	
	class ServicesControllersHome extends FSControllers
	{
		var $module;
		var $view;
		function display()
		{
			//die();
			// call models
			$model = $this -> model;
			// $amp = FSInput::get ( 'amp', 0, 'int' );
			$query_body = $model->set_query_body();
			$list = $model->getServicesList($query_body);
			$total = $model->getTotal($query_body);
			$pagination = $model->getPagination($total);
			$list_cats = $model -> get_cats();
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=>FSText::_("Dịch vụ"), 1 => FSRoute::_('index.php?module=services&view=home&Itemid=93'));
			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			$tmpl -> set_seo_special();
			$this->set_header ( );
			// call views			
			include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';
		}
		
	/*
		 * Tạo ra các tham số header ( cho fb)
		 */
	function set_header() {
		global $config;

		// $amp = FSInput::get('amp',0,'int');
		$lang = isset($_SESSION['lang'])?$_SESSION['lang']:'vi';
		$str = '';
		// if(!$amp  && $lang == 'vi'){
		// 	$link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; 
		// }
		global $tmpl;
		$tmpl->addHeader ( $str );
	}
}
	
?>