<?php
// models 
class ProductsControllersFilters extends Controllers {
	var $module;
	function __construct() {
		$this->type = 'products';
		parent::__construct ();
	}
	function display() {
		// call models
		$model = $this->model;
		$table_name = FSInput::get ( 'tablename' );

		$table_name = strtolower($table_name);
		if(strpos($table_name, 'fs_'.$this->type.'_') === false){
			$table_name = 'fs_'.$this->type.'_'.$table_name;
		}
			
		$fields = $model->getFieldList ( $table_name );
		$fields_common = $model->getFieldListCommon ( $this->type );

		
		
		$field = FSInput::get ( 'field' );
		// filters follow current field
		$filters = $model->getFilters ( $table_name, $field );
		
		$field_ordering = 0;
		// array of filter_value by current field
		$arr_filters_value_by_current_field = array ();
		if (!empty ( $filters )) {
			foreach ( $filters as $f ) {
				$arr_filters_value_by_current_field [] = $f->filter_value;
			}
			$field_ordering = isset($filters[0] ->  field_ordering)?$filters[0] ->  field_ordering:0;
		}
		
		$field_current = $model->get_field_current ( $field, $table_name );
		// foreign:
		if (isset ( $field_current ) && ! empty ( $field_current ) && ($field_current->field_type == 'foreign_one' || $field_current->field_type == 'foreign_multi')) {
			if($field_current -> is_common){
				// 	get data in table foreign				
				$foreign = $model->get_all_record 	( $field_current->foreign_tablename,' ordering, id  ' );	
			}else{
				$foreign = $model->get_records 	( 'group_id = '.$field_current ->foreign_id.'','fs_extends_items','*',' ordering ,id '  );
			}
		}
		
		// all filters follow field
		$filters_in_table = $model->get_filters_in_table ( $table_name );
		
		// count field in filter_in_table
		$count_field_by_filter_in_table = $model->get_count_field_by_filter_in_table ( $table_name );
		
		$calculators = array (//								array("1","h&#227;ng s&#7843;n xu&#7845;t"),
		2 => array ("2", "LIKE" ), 3 => array ("3", "Null" ), 4 => array ("4", "Not Null" ), 5 => array ("5", "==" ), 6 => array ("6", ">" ), 7 => array ("7", "<" ), 8 => array ("8", ">=" ), 9 => array ("9", "<=" ), 10 => array ("10", " > value1 AND < value2" ), 11 => array ("11", " > value1 AND <= value2" ), 12 => array ("12", " >= value1 AND < value2" ), 13 => array ("13", " >= value1 AND <= value2" ), 14 => array ("14", "FOREIGN_ONE" ), 15 => array ("15", "FOREIGN_MULTI" ) );
		
		// call views
		

		include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';
	}
	function edit() {
		$model = $this->model;
		$data = $model->getTableFields ();
		include 'modules/' . $this->module . '/views/tables/detail.php';
	}
	
	function remove() {
		$cids = FSInput::get ( 'cid', array (), 'array' );
		$remove_admin = 0;
		$model = $this->model;
		
		$rows = $model->remove ();
		if ($rows) {
			setRedirect ( 'index.php?module=' . $this->module, $rows . ' ' . FSText::_ ( 'record was deleted' ) );
		} else {
			setRedirect ( 'index.php?module=' . $this->module, FSText::_ ( 'Not delete' ), 'error' );
		}
	}
	function save() {
		$model = $this->model;
		$tablename = FSInput::get ( 'tablename' );
		$field = FSInput::get ( 'field' );
		if (! $field) {
			setRedirect ( 'index.php?module=' . $this->module . '&view=filters&tablename=' . $tablename, 'Bạn phải chọn trường để lọc', 'msg' );
		}
		$tablename_long= $tablename;
		if(strpos($tablename, 'fs_'.$this->type.'_') === false)
			$tablename_long = 'fs_'.$this->type.'_'. $tablename;	
		$rs = $model->save2 ($tablename_long );
		if ($rs) {
			setRedirect ( 'index.php?module=' . $this->module . '&view=filters&tablename=' . $tablename . '&field=' . $field, "L&#432;u th&#224;nh c&#244;ng" );
		} else {
			setRedirect ( 'index.php?module=' . $this->module . '&view=filters&tablename=' . $tablename . '&field=' . $field, FSText::_ ( 'Error' ), 'error' );
		}
	}
	//		function cancel()
	//		{
	//			$tablename = FSInput::get('tablename');
	//			setRedirect('index.php?module='.$this -> module.'&view=tables&task=edit&tablename='.$tablename);	
	//		}
	function cancel() {
		$link = 'index.php?module=products&view=tables';
		setRedirect ( $link );
	}
}

?>