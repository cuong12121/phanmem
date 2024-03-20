<?php 	  
	class LanguagesModelsText extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> table_name = 'fs_languages_text';
			parent::__construct();
		}
		
		function get_language_by_sort($lang_sort)
		{
			if(!$lang_sort){
				$lang_sort = 'en';
			}
			global $db;
			
			$query = " SELECT a.*
						  FROM 
						  	fs_languages AS a
						  WHERE lang_sort = '$lang_sort'
						 ";
			$sql = $db->query($query);
			$result = $db->getObject();
			
			return $result;
		}
		
		function get_languages(){
			global $db;
			$query = " SELECT *
						  FROM 
						  	fs_languages AS a
						 ";
			$sql = $db->query($query);
			$result = $db->getObjectList();
			
			return $result;
		}
		
		function get_text_by_language($lang_sort){
			if(!$lang_sort)	
				return;
			global $db;
			$field = 'lang_'.$lang_sort;
			$query = " SELECT id,lang_key,".$field." as lang_value
						  FROM 
						  	fs_languages_text AS a
						 ";
			$sql = $db->query($query);
			$result = $db->getObjectList();
			
			return $result;
		}
		function get_texts(){
			global $db;
			$query = " SELECT *
						  FROM 
						  	fs_languages_text AS a
						  ORDER BY lang_key ASC 
						 ";
			$sql = $db->query($query);
			$result = $db->getObjectList();
			
			return $result;
		}
		
		
		/*
		 * store
		 */
		function save(){
			$id = FSInput::get('id',0,'int');
			$lang_key = FSInput::get('lang_key');
			if($this -> check_duplicate($lang_key, $id)){
				Errors::_('Đã có key này rồi, bạn hãy check lại');
				return false;
			}
			$row = array();	
			$row['lang_key']  = $lang_key;	
			$list_lang = $this->get_languages();
			foreach($list_lang as $lang){
				$row['lang_'.$lang -> lang_sort] = FSInput::get('lang_value_'.$lang -> lang_sort);
			}
			
			if($id){
				$rs = $this -> _update($row, 'fs_languages_text','id = '.$id);
			}else{
				$rs = $this -> _add($row, 'fs_languages_text');
			}
			return $rs;
		}
		
		function check_duplicate($key,$id){
			return $this -> check_exist($key,$id,'lang_key','fs_languages_text');
		}
	}
	
