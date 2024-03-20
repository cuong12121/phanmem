<?php
/*
 * Huy write
 */
	// controller

class ServicesControllersCat extends FSControllers
{
	var $module;
	var $view;
	function display()
	{
			// call models
		$model = $this -> model;
		$cat  = $model->getCategory();
		if(!$cat){
			$link = FSRoute::_('index.php?module=notfound&view=notfound&Itemid=1000');
			setRedirect($link);
		}
		$query_body = $model->set_query_body($cat->id);
		$list = $model->get_data($query_body);
		$total = $model->getTotal($query_body);
		$list_cats = $model -> get_cats();
		$pagination = $model->getPagination($total);
		//$amp = FSInput::get ( 'amp', 0, 'int' );
		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>$cat->name, 1 => FSRoute::_('index.php?module=services&view=cat&id='.$cat -> id.'&ccode='.$cat ->alias));
		global $tmpl;	
		$tmpl -> assign('breadcrumbs', $breadcrumbs);
			// seo
		$tmpl -> set_data_seo($cat);
		$this->set_header ( $cat );
			// call views			
		include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';
	}

	function set_header($data, $image_first = '') {
		global $config;
		$link = FSRoute::_ ( "index.php?module=service&view=cat&cid=" . $data->id . "&ccode=" . $data->alias );
		//$amp = FSInput::get('amp',0,'int');
		$str = '';
		// if(!$amp){
		// 	$link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; 
		// 	$str .= '<link rel="amphtml" href="'.str_replace('.html','.amp',$link).'">';
		// }
		global $tmpl;
		$tmpl->addHeader ( $str );
	}
	
}

?>