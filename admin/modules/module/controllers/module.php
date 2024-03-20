<?php
class ModuleControllersModule extends Controllers {
	function __construct() {
		// CONFIG 
		global $positions;		
		$this->position = $positions;
		parent::__construct ();
	}
	function display() {
		$sort_field = FSInput::get ( 'sort_field' );
		$sort_direct = FSInput::get ( 'sort_direct' );
		$sort_direct = $sort_direct ? $sort_direct : 'asc';
		
		$positions = $this->position;
		if (@$sort_field) {
			$_SESSION ['module_sort_field'] = $sort_field;
			$_SESSION ['module_sort_direct'] = $sort_direct;
		}
		if (isset ( $_POST ['search'] )) {
			$_SESSION ['module_search'] = $_POST ['search'];
		}
		$model = $this->model;
		$listmodule = $model->getModuleList ();
		$pagination = $model->getPagination ();
		
		$listmoduletype = $model->getModuleTypeList ();
		// views
		

		include 'modules/module/views/list.php';
	}
	
	function add() {
		$positions = $this->position;
		$model = $this->model;
		$menus_items_all = $model->getMenuItems ();
		$listmoduletype = $model->getModuleTypeList ();
		$news_categories = $model->get_news_categories ();
		include 'modules/module/views/detail.php';
	}
	function edit() {
		$positions = $this->position;
		$model = $this->model;
		
		$menus_items_all = $model->getMenuItems ();
		$cids = FSInput::get ( 'cid', array (), 'array' );
		$cid = $cids [0];
		$data = $model->getModuleById ( $cid );
		$listmoduletype = $model->getModuleTypeList ();
		$news_categories = $model->get_news_categories ();
		// load config of eblocks
		if (@$data->module && @$data->module != 'contents')
			if (file_exists ( PATH_BASE . 'blocks' . DS . $data->module . DS . 'config.php' ))
				include_once '../blocks/' . $data->module . '/config.php';
		FSFactory::include_class ( 'parameters' );
		$current_parameters = new Parameters ( $data->params );
		$params = isset ( $params ) ? $params : array ('suffix' => array ('name' => 'Hậu tố', 'type' => 'text' ) );
		
		include 'modules/module/views/detail.php';
	}
	function remove() {
		$model = $this->model;
		
		$rows = $model->remove ();
		if ($rows) {
			setRedirect ( 'index.php?module=module', $rows . ' ' . FSText::_ ( 'record was deleted' ) );
		} else {
			setRedirect ( 'index.php?module=module', FSText::_ ( 'Not delete' ), 'error' );
		}
	}
	function published() {
		$model = $this->model;
		$rows = $model->published ( 1 );
		if ($rows) {
			setRedirect ( 'index.php?module=module', $rows . ' ' . FSText::_ ( 'record was published' ) );
		} else {
			setRedirect ( 'index.php?module=module', FSText::_ ( 'Error when published record' ), 'error' );
		}
	}
	function unpublished() {
		$model = $this->model;
		$rows = $model->published ( 0 );
		if ($rows) {
			setRedirect ( 'index.php?module=module', $rows . ' ' . FSText::_ ( 'record was published' ) );
		} else {
			setRedirect ( 'index.php?module=module', FSText::_ ( 'Error when published record' ), 'error' );
		}
	}
	function save() {
		$model = $this->model;
		$cid = $model->save ();
		if ($cid) {
			
			setRedirect ( 'index.php?module=module&task=edit&cid=' . $cid, FSText::_ ( 'Saved' ) );
		} else {
			setRedirect ( 'index.php?module=module', FSText::_ ( 'Not save' ), 'error' );
		}
	
	}
	function cancel() {
		setRedirect ( 'index.php?module=module' );
	}
}

?>