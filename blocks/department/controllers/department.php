<?php
/*
 * Huy write
 */
	// models 
	include 'blocks/department/models/department.php';
	
	class DepartmentBControllersDepartment extends FSControllers
	{
		function __construct()
		{
		}
		function display($parameters,$title,$block_id = 0, $link_title = '',$showTitlte = 0){

			$limit = $parameters->getParams('limit');
			$limit = $limit ? $limit:8; 
			$style = $parameters->getParams('style');
			$style = $style ? $style : 'default';

			$model = new DepartmentBModelsDepartment();


			$list_address = $model -> get_list_address();
			$query_body = $model->set_query_body();
			$regions = $model -> get_regions();
			$list = $model->get_list($query_body);
			$dataCity = $model->get_city(); 
			$info_other = $model->get_info_other(); 
			$district = $model->get_categories_tree();

			
			include 'blocks/department/views/department/'.$style.'.php';
	
		}
	}
	
?>