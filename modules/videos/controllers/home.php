<?php
/*
 * Huy write
 */
// controller
class VideosControllersHome extends FSControllers {
	
	function display() {
		// call models
		$model = $this->model;
		$query_body = $model->set_query_body ();
		$list = $model->get_list ( $query_body );	
		$list_cats = $model -> get_cats();
		$total = $model->get_total ( $query_body );
		$pagination = $model->getPagination ( $total );
		$breadcrumbs = array ();
		$breadcrumbs [] = array (0 => 'Video', 1 => FSRoute::_ ( 'index.php?module=videos&view=home&Itemid=47' ) );
		global $tmpl;
		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );
		$tmpl->set_seo_special ();
		
		include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';
	}
}
?>