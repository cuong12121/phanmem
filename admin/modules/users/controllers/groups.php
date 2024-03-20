<?php
	// models 
	// include 'modules/'.$module.'/models/groups.php';

class UsersControllersGroups extends Controllers
{
	var $module;
	function __construct()
	{
		$this->view = 'groups' ; 
		parent::__construct(); 
	}
	function display()
	{
		parent::display();
		$sort_field = $this -> sort_field;
		$sort_direct = $this -> sort_direct;
		
		$model  = $this -> model;
		$list = $this -> model->get_data('');
		$pagination = $model->getPagination('');
		include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
	}

	function add()
	{
		$model = $this -> model;
		include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
	}
	function edit()
	{
		$model = $this -> model;
		$ids = FSInput::get('id',array(),'array');
		$id = $ids[0];
		$data = $model->get_record_by_id($id);

		$list_module = $model->get_records('','fs_permission_tasks','DISTINCT(module)');
		$list_view   = $model->get_records('','fs_permission_tasks','DISTINCT(view)');

		$arr_view = array();
		foreach ($list_module as $module_it) {
			$arr_view[$module_it->module] = $model->get_records('module = "'.$module_it->module.'"','fs_permission_tasks','DISTINCT(view)');
		}

		$arr_task = array();
		foreach ($list_module as $module_it) {
			foreach ($list_view as $view_it) {
				$list_task = $model->get_records('module = "'.$module_it->module.'" AND view = "'.$view_it->view.'"','fs_permission_tasks','*','ordering ASC');
				if(!empty($list_task)){
					$arr_task[$module_it->module][$view_it->view] = $list_task;
				}
				 
			}
		}
		
		//printr($arr_task);
		include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
	}
}

?>