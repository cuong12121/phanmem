<?php
/*
 * Huy write
 */
	// controller
	class CertificationsControllersHome extends FSControllers
	{
		var $module;
		var $view;
		function display()
		{
			// call models
			$model = $this -> model;
			$query_body = $model->set_query_body();
			$list = $model->get_list($query_body);
			$total = $model->getTotal($query_body);
			$pagination = $model->getPagination($total);
			$home = $model-> get_record('id = 1','fs_certifications_home');

			$arr_cat = array();
			if(!empty($list)){
				foreach ($list as $item) {
					$cat = $model-> get_record('id = '.$item-> category_id,'fs_certifications_categories','id,name,name2,des');
					if(!empty($cat)){
						$arr_cat[$item->id] = $cat;
					}
				}
			}

			$breadcrumbs = array();
			$breadcrumbs[] = array(0=>'Giấy chứng nhận', 1 => FSRoute::_('index.php?module=certifications&view=home&Itemid=67'));

			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			$tmpl -> set_seo_special();
						
			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}		
	}	
?>