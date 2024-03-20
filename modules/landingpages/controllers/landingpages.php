<?php
/*
 * Huy write
 */
	// controller

class LandingpagesControllersLandingpages extends FSControllers
{
	var $module;
	var $view;
	
	function display()
	{
			// call models
		$model = $this -> model;
		
		$data = $model->getContents();
		$id = FSInput::get ( 'id', 0, 'int' );
		if(!$data)
			setRedirect ( FSRoute::_ ( 'index.php?module=notfound&view=notfound' ), FSText::_('Link này không tồn tại') );
		global $tmpl,$module_config;
		// $tmpl -> set_data_seo($data);
		
		$code = FSInput::get('code');
		
		$Itemid = 7;
		
		if ($code != $data->alias || $id != $data->id ) {
			$link = FSRoute::_("index.php?module=contents&view=content&code=".trim($data->alias)."&ccode=".trim($category-> alias)."&id=".$data->id."&Itemid=$Itemid");					
			setRedirect($link);
		}
		
		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>$data->title, 1 => '');	
		global $tmpl;	
		$tmpl -> assign('breadcrumbs', $breadcrumbs);
			// seo
		$tmpl -> set_data_seo($data);
			// call views			
		include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
	}
	
	
	

	
}

?>