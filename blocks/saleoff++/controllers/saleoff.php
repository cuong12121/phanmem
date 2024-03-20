<?php
/*
 * Huy write
 */
	// models 
include 'blocks/saleoff/models/saleoff.php';

class SaleoffBControllersSaleoff
{
	function __construct()
	{
	}
	function display($parameters,$title,$block_id = 0, $link_title = '',$showTitlte = 0){
		$ordering = $parameters->getParams('ordering'); 
		$type  = $parameters->getParams('type'); 
		$limit = $parameters->getParams('limit');
		$limit = $limit ? $limit:8; 
		$filter_category_auto = $parameters->getParams('filter_category_auto');
			// call models
		$model = new SaleoffBModelsSaleoff();
		$sale = $model-> get_sale(1);
		if ($sale) {
			$sale -> status = 'now';
		}
		if(!$sale) {
			$sale = $model-> get_sale_being(1);
			if($sale) {
				$sale -> status = 'coming';
			}
		}
		if(!$sale){
			return;
		}
		
		$list = $model -> get_list_product($sale-> id);
			// $list = $model -> get_list($ordering,$limit,$type,$filter_category_auto);
		if(!$list)
			return;
		
		$identity = $block_id;
		$style = $parameters->getParams('style');
		$style = $style ? $style : 'default';

		// $types = $model->get_types ();
		$types = $model -> get_records('published = 1','fs_products_types','id, name','','','id');
			// $types = $model -> get_types();
		
			// call views
		include 'blocks/saleoff/views/saleoff/'.$style.'.php';
	}
}

?>