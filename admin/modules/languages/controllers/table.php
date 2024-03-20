<?php
	// models 
	class LanguagesControllersTable   extends Controllers
	{
		var $module;
		var $gid;
		function __construct()
		{
//			global $module;
//			$this->module = 'languages' ; 
//			$this->view = 'table' ;
			parent::__construct();  
		}
		function display()
		{
			// call models
			$model = new LanguagesModelsTable();
			
			$table_id = FSInput::get('id',0,'int');
			$table = $model->getTable($table_id);
			$main_field = $table -> main_field_display;
			$language_not_default = $model->get_languages();
			$list = $model->get_list($table,$language_not_default);
			
			$total = $model -> getTotal($table,$language_not_default);
			$pagination = $model->getPagination($total);

			// call views
			include 'modules/'.$this->module.'/views/'.$this-> view.'/list.php';
		}
		
		function back(){
			setRedirect('index.php?module=languages&view=tables');	
		}
		function translate(){
			$model = new LanguagesModelsTable();
			// table
			$table_id = FSInput::get('table',0,'int');
			$table = $model->getTable($table_id);	
			
			// language
			$lang_id = FSInput::get('language',0,'int');
			$language = $model->get_language_by_id($lang_id);

			// create table if not exist
			$create_table = $model ->create_table($table -> table_name , $table -> table_name . '_' . $language-> lang_sort);  
				
			$id = FSInput::get('id',0,'int');	

			$fields_in_table = $model -> get_field_table($table -> table_name);
			
			// Function hỗ trợ	
			$support_func = $table -> functions;
			$arr_func = array();
			if($support_func){ 
				$str_func = explode('|',$support_func);
				if(count($str_func)){
					foreach($str_func as $item){
						$arr_bff = explode('=>',$item);
						if(!isset($arr_bff[0]) || !isset($arr_bff[1]))
							continue;
						$arr_func[$arr_bff[1]] = $arr_bff[0];
					}
				}
			}	
			
			$data_old  = $model->get_data($table -> table_name,$id);	
			$data_new  = $model->get_data($table -> table_name . '_' . $language-> lang_sort,$id);

			// call views
			include 'modules/'.$this->module.'/views/'.$this-> view.'/translate.php';
		}
		
		function apply()
		{
			$model = new LanguagesModelsTable();
			// check password and repass
			// call Models to save
			$table_id = FSInput::get('table',0,'int');
			$id = FSInput::get('id',0,'id');
			$lang_id = FSInput::get('lang_id',0,'int');
			$before_id = FSInput::get('before_id',0,'int');
			$before_page = FSInput::get('before_page',0,'int');
			$rid = $model->save();
			$link = 'index.php?module=languages&view=table&task=translate&id='.$id.'&language='.$lang_id.'&table='.$table_id.'&before_id='.$before_id.'&before_page='.$before_page;
			if($rid)
			{
				setRedirect($link,FSText :: _('Saved'));	
			}
			else
			{
				setRedirect($link,FSText :: _('Not save'),'error');	
			}
			
		}
		
		function save()
		{
			$model = new LanguagesModelsTable();
			// check password and repass
			// call Models to save
			$table_id = FSInput::get('table',0,'int');
			$rid = $model->save();
			$before_id = FSInput::get('before_id',0,'int');
			$before_page = FSInput::get('before_page',0,'int');
			
			$link = "index.php?module=languages&view=table&id=".$before_id."&page=".$before_page;
			if($rid)
			{
				setRedirect($link,FSText :: _('Saved'));	
			}
			else
			{
				setRedirect($link,FSText :: _('Not save'),'error');	
			}
			
		}
		
		function cancel()
		{
			$id = FSInput::get('table',0,'int');
			$before_id = FSInput::get('before_id',0,'int');
			$before_page = FSInput::get('before_page',0,'int');
			
			setRedirect('index.php?module=languages&view=table&id='.$before_id."&page=".$before_page);	
		}
		
		/*
		 * Tự động dịch lại alias
		 */
		function genarate_alias(){
			$original = FSInput::get('txt');
			if(!$original)
				return;
			$fsstring = FSFactory::getClass('FSString','','../');
			$rs = $fsstring -> stringStandart($original);
			echo $rs;	
		}
		
		function function_support(){
			$model  = $this -> model;
			$function_support = FSInput::get('function_support');
			if(!$function_support)
				return;
			$model -> $function_support();
			return;
		}
	}
?>