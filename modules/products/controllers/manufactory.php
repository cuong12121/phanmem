<?php
/*
 * Huy write
 */
	// controller
	
	class ProductsControllersManufactory extends FSControllers
	{
		var $module;
		var $view;
		

		function display()
		{
			// call models
			$model = $this -> model;
			$manu  = $model->get_manufactory();
			if(!$manu){
				 setRedirect(FSRoute::_('index.php?module=notfound&view=notfound&Itemid=1000'));
				return ;
			}	
			$query_body = $model -> set_query_body($manu);
			$list = $model -> get_list($query_body);
			// if(!$list){
			// 	setRedirect(FSRoute::_('index.php?module=notfound&view=notfound&Itemid=1000'));
			// 	return ;
			// }
			$total = $model -> getTotal($query_body);
			$pagination = $model->getPagination($total);
			$array_products = array();
						
			// Lấy loại 
			$types = $model -> get_types();
				// breadcrumbs
			$breadcrumbs = array();
			$breadcrumbs [] = array (0 => FSText::_ ( 'Thương hiệu' ), 1 => FSRoute::_('index.php?module=products&view=manufactories' ));
			$breadcrumbs [] = array (0 => $manu->name, 1 => '' );
			
			global $tmpl,$module_config;
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			// seo
			$tmpl -> set_data_seo($manu);
	
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
	
			
		}
		function mdisplay()
		{
			// call models
			$model = $this -> model;
			$cat  = $model->get_category();
			if(!$cat){
				echo "Kh&#244;ng t&#236;m th&#7845;y Category";	
			return;
			}				
			$query_body = $model -> set_query_body($cat);
			$list = $model -> get_list($query_body,$cat -> tablename);
			$total = $model -> getTotal($query_body);
			$pagination = $model->getPagination($total);
			$array_products = array();
			foreach (@$list as $item){
				$image_other =  $model -> get_record('record_id = '.$item->id,'fs_products_images','image');
				if($image_other){
					$array_products[$item->id] = $image_other ->image;	
				}
			}
			
			// Lấy loại 
			$types = $model -> get_types();
			
			$arr_order = array(
					array(null,'Sắp xếp theo'),
					array('gia-tang','Giá tăng dần'),
					array('gia-giam','Giá giảm dần'),
					array('alpha','A -> Z'),
				);
			$sort = FSInput::get('order','new');

			// breadcrumbs
			$lis_cat_parent = $model -> get_list_parent($cat -> list_parents,$cat->id);
			$breadcrumbs = array();
			for($i = count($lis_cat_parent); $i > 0 ; $i --){
				$item = $lis_cat_parent[$i - 1];
				$breadcrumbs[] = array(0=>$item->name, 1 => FSRoute::_('index.php?module=products&view=cat&ccode='.$item->alias.'&cid='.$item->id));
			}
			$breadcrumbs [] = array (0 => $cat->name, 1 => '' );
			
			global $tmpl,$module_config;
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			// seo
			$tmpl -> set_data_seo($cat);
			
			// call views
				include 'modules/'.$this->module.'/views/'.$this->view.'/mdefault.php';
			
		}
		
	}
	
?>