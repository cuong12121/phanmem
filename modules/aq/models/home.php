<?php
class AqModelsHome extends FSModels {
	function __construct() {
		
		$limit_per_cat = 5;
		parent::__construct ();
		global $module_config;
		
		FSFactory::include_class ( 'parameters' );
		$current_parameters = new Parameters ( $module_config->params );
		$limit = $current_parameters->getParams ( 'limit' );
		$this->limit_per_cat = 5;
		$fstable = FSFactory::getClass ( 'fstable' );
		$this->table_name = $fstable->_ ( 'fs_aq' );
		$this->table_cat = $fstable->_ ( 'fs_aq_categories' );
	}
	function save_ask() {
		$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
		$title = FSInput::get ( 'title' );
		$name = FSInput::get ( 'name' );
		$content = htmlspecialchars_decode ( FSInput::get ( 'message' ) );
		$email = FSInput::get ( 'email' );
		$time = date ( "Y-m-d H:i:s" );
		$published = 0;
		
		$row = array ();
		$row ['asker'] = $name;
		$row ['title'] = $title;
		$row ['alias'] = $fsstring->stringStandart ( $title );
		$row ['email'] = $email;
		$row ['question'] = $content;
		$row ['created_time'] = $time;
		$row ['published'] = $published;
		$row ['ordering'] = $this->getMaxOrdering ();
		
		$id = $this->_add ( $row, $this->table_name, 1 );
		
		return $id;
	}
	function get_cats() {
		global $db;
		$query = " SELECT *
					FROM ".$this->table_cat."
					WHERE 
						show_in_homepage = 1
					ORDER BY ordering ASC 
							";
		$db->query ( $query );
		$list = $db->getObjectList ();
		
		return $list;
	}
	
	/*
		 * return products list in category list.
		 * These categories is Children of category_current
		 */
	function get_records_cat($cat_id) {
		global $db;
		if (! $cat_id)
			return false;
		
		$order = " ORDER BY ordering DESC, id DESC ";
		$query = " SELECT *
						FROM ".$this->table_name."
						WHERE category_id_wrapper like '%" . $cat_id . "%' AND published = 1 " . $order . " 
						LIMIT " . $this->limit_per_cat . " ";
			
		$db->query ( $query );
		$result = $db->getObjectList ();
		
		return $result;
	}
	
	function get_data_common(){
		return $this -> get_records('is_common = 1 AND published = 1 ',$this->table_name);
	}
	
}

?>