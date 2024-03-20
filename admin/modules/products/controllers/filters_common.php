<?php
	// models 
	class ProductsControllersFilters_common extends Controllers
	{
		var $module;
		function __construct()
		{
			$this -> type = 'products';
			$this->view = 'filters_common' ; 
			parent::__construct(); 
		}
		function display()
		{
			// call models
			$model =  $this -> model;
			$fields = $model -> getFieldList($this -> type);
			if(!count($fields)){
				echo "Không tìm thấy trường nào để sinh bộ lọc";
			}	
//				return;
			$first_field = 	$fields[0];	
			$field = FSInput::get('field');
			$field   = $field? $field: @$first_field -> fileld_name;
			// filters follow current field
			$filters = $model -> getFilters($this -> type,$field);
			
			// array of filter_value by current field
			$arr_filters_value_by_current_field = array();
			if(!empty($filters)){
				foreach($filters as $f){
					$arr_filters_value_by_current_field[] = $f -> filter_value;
				}
			}
			
			$field_current = $model  -> get_record(' type = "'.$this -> type.'" AND field_name = "'.$field.'"','fs_tables');
			// foreign:
			if(isset($field_current) && !empty($field_current) && ($field_current ->field_type == 'foreign_one' || $field_current ->field_type == 'foreign_multi')){
				// get data in table foreign 
				$foreign = $model -> get_all_record($field_current -> foreign_tablename);
			}
			
			// all filters follow field
			$filters_in_table = $model -> get_filters_in_table($this -> type);
			
			// count field in filter_in_table
			$count_field_by_filter_in_table = $model -> get_count_field_by_filter_in_table($this -> type);
			
			$calculators  = array(
//								array("1","h&#227;ng s&#7843;n xu&#7845;t"),
								2 => array("2","LIKE"),
								3 => array("3","Null"),
								4 => array("4","Not Null"),
								5 => array("5","=="),
								6 => array("6",">"),
								7 => array("7","<"),
								8 => array("8",">="),
								9 => array("9","<="),
								10 => array("10"," > value1 AND < value2"),
								11 => array("11"," > value1 AND <= value2"),
								12 => array("12"," >= value1 AND < value2"),
								13 => array("13"," >= value1 AND <= value2"),
								14 => array("14","FOREIGN_ONE"),
								15 => array("15","FOREIGN_MULTI")
							);
								
			// call views
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function cancel()
		{
			$link = 'index.php?module=products&view=tables';
			setRedirect($link);	
		}
		function back()
		{
			$link = 'index.php?module=products&view=tables';
			setRedirect($link);	
		}
	}
	
?>