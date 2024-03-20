<?php
/*
 * Huy write
 */
	// controller
	class AlbumsControllersHome extends FSControllers
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
			
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=>'Bộ sưu tập', 1 => FSRoute::_('index.php?module=albums&view=home&Itemid=177'));
			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			$tmpl -> set_seo_special();

			$array_items = array();
			if(!empty($list)){
				foreach ($list as $item){
					$item_in_cat = $model->get_records('published = 1 AND category_id = ' . $item->id,'fs_albums','name,image,title');
					if(!empty($item_in_cat)){
						$array_items[$item->id] = $item_in_cat;
					}
				}
				
			}
			
			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		
	}
	
?>