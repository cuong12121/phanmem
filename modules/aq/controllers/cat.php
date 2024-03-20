<?php
/*
 * Huy write
 */
	// controller
	
	class AqControllersCat extends FSControllers
	{
		var $module;
		var $view;
		function display()
		{
			// call models
			$model = $this -> model;
			$cat  = $model->getCategory();
			if(!$cat)
			{
				echo "Not found Category";	
				die;
			}
			global $tags_group;
//            $tags_group = $cat -> tags_group;
			$query_body = $model->set_query_body($cat->id);
			$list = $model->get_data($query_body);
//			$total = $model->getTotal($query_body);
//			$pagination = $model->getPagination($total);
			
			$breadcrumbs = array();
			//$breadcrumbs[] = array(0=>'Câu hỏi thường gặp', 1 => FSRoute::_('index.php?module=aq&view=home&Itemid=2'));
			$breadcrumbs[] = array(0=>FSText::_('Hỏi đáp'), 1 => FSRoute::_('index.php?module=aq&view=home&Itemid=2'));
			$breadcrumbs[] = array(0=>$cat->name, 1 => FSRoute::_('index.php?module=aq&view=cat&id='.$cat -> id.'&ccode='.$cat -> alias.''));
			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			// seo
			$tmpl -> set_data_seo($cat);
			
			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
	}
	
?>