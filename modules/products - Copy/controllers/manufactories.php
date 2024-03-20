<?php
	/*
	 * Huy write
	 */
	// controller
class ProductsControllersManufactories extends FSControllers {
	
		function display(){
		$model = $this->model;
			
		$list = $model->get_list();
		$list_hot  = $model->get_list_hot();


		$arr_manu_by_key  = array();
		$lastletter='';
		foreach ($list as $item){
			$currentleter = substr($item->alias , 0 , 1);
			if ($lastletter != $currentleter){
			    $lastletter = $currentleter;

			}
			$arr_manu_by_key[$currentleter][] = $item->id;
			
		}
	


		// breadcrumbs
		$breadcrumbs = array ();
		$breadcrumbs [] = array (0 => FSText::_ ( 'Thương hiệu' ), 1 => '' );
		global $tmpl;
		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );

		$tmpl -> set_seo_special();
		// call views
		include 'modules/'.$this->module.'/views/'.$this->view.'/'.'default.php';
		}
	}
	
?>