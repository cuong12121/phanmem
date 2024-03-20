<?php
/*
 * Huy write
 */
	// controller
	
	class NewsControllersHome extends FSControllers
	{
		var $module;
		var $view;
		function display()
		{
			// call models
			$model = $this -> model;

			$amp = FSInput::get ( 'amp', 0, 'int' );
			$query_body = $model->set_query_body();
			$list = $model->getNewsList($query_body);
			
			$total = $model->getTotal($query_body);
			$pagination = $model->getPagination($total);
			
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=>'Tin tức', 1 => FSRoute::_('index.php?module=news&view=home&Itemid=2'));
			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			$tmpl -> set_seo_special();
			$this->set_header ( );
			
			// call views			
			include 'modules/' . $this->module . '/views/' . $this->view.($amp?'_amp':'') . '/default.php';
		}
		
	/*
		 * Tạo ra các tham số header ( cho fb)
		 */
	function set_header() {
		global $config;

		$amp = FSInput::get('amp',0,'int');
		$lang = isset($_SESSION['lang'])?$_SESSION['lang']:'vi';
		$str = '';
		if(!$amp  && $lang == 'vi'){
			$link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; 
			$str .= '<link rel="amphtml" href="'.str_replace('.html','.amp',$link).'">';
		}
		global $tmpl;
		$tmpl->addHeader ( $str );
	}
}
	
?>