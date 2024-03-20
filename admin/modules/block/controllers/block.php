<?php
class BlockControllersBlock extends Controllers {
	function __construct() {
		// CONFIG
        $this->view = 'block'; 
		global $positions;		
		$this->position = $positions;
		parent::__construct ();
	}
	function display() {
        parent::display();
		$sort_field = $this -> sort_field;
		$sort_direct = $this -> sort_direct;
		$positions = $this->position;
		$arr_positions = array();
		foreach($positions as $key => $p){
			$arr_positions[$key] = $p.' ['.$key.']';
		} 
							
		$model = $this->model;
		$list = $model->get_data ('');
        
		$pagination = $model->getPagination ('');
		
		$listmoduletype = $model->get_records('published = 1','fs_blocks_exist');
		$arr_module_types = array();
		foreach($listmoduletype as $item){
			$arr_module_types[$item -> block] = $item -> name.' ['.$item -> block.']';
		} 
		
		// views

		include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
	}
	
	function add() {
		$positions = $this->position;
		$model = $this->model;
        
		$menus_items_all = $model->getMenuItems ();
        
		$listmoduletype = $model->get_records('published = 1','fs_blocks_exist');
        
		$news_categories = $model->get_news_categories ();
        
        $contents_categories = $model->get_records('level = 0','fs_contents_categories','*');
        
		include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
	}
	function edit() {
		$positions = $this->position;
		$model = $this->model;
		
		$menus_items_all = $model->getMenuItems ();
		$cids = FSInput::get ('id', array (), 'array' );
		$cid = $cids [0];
		$data = $model->get_record_by_id($cid);
		if(!$data)
			die('Not found url');
        
		$listmoduletype = $model->get_records('published = 1','fs_blocks_exist');
        
		$news_categories = $model->get_news_categories ();
        $contents_categories = $model->get_records('level = 0','fs_contents_categories','*');
		// load config of eblocks
		if (@$data->module && @$data->module != 'contents')
			if (file_exists ( PATH_BASE . 'blocks' . DS . $data->module . DS . 'config.php' ))
				include_once '../blocks/' . $data->module . '/config.php';
                
		FSFactory::include_class ( 'parameters' );
		$current_parameters = new Parameters ( $data->params );
		$params = isset ( $params ) ? $params : array ('suffix' => array ('name' => 'Hậu tố', 'type' => 'text' ) );
		
		include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
	}
	
}

?>