<?php
/*
 * Huy write
 */
// models 
include 'blocks/news_menu/models/news_menu.php';

class News_menuBControllersNews_menu {
	function __construct() {
	}
	function display($parameters, $title) {
		$style = $parameters->getParams ( 'style' );
		
		$style = $style ? $style : 'default';
		
		// call models
		$model = new News_menuBModelsNews_menu ();
		$list = $model->getList ();
		if (! $list)
			return;
		
		// need_chek
		$module = FSInput::get ( 'module' );
		$need_check = 0;
		if ($module == 'news') {
			$ccode = FSInput::get ( 'ccode' );
			$need_check = 1;
		}
		// call views
		include 'blocks/news_menu/views/news_menu/' . $style . '.php';
	}
}

?>