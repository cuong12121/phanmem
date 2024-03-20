<?php 
	class NewsModelsCategories extends ModelsCategories
	{
		function __construct()
		{
			$this -> limit = 20;
			
			$this -> table_items = FSTable_ad::_('fs_news');
			$this -> table_name = FSTable_ad::_('fs_news_categories');
			$this -> check_alias = 1;
			$this -> call_update_sitemap = 1;
			
			// exception: key (field need change) => name ( key change follow this field)
			$this -> field_except_when_duplicate = array(array('list_parents','id'),array('alias_wrapper','alias'));
			parent::__construct();
		}


		function save($row = array(), $use_mysql_real_escape_string = 1){
			$name = FSInput::get ('name');
			$id = FSInput::get ('id');
			$this->save_new_session();
			if(!$id){
				$check_name = $this->get_result('name="'.$name.'"');
				if($check_name){
					setRedirect('index.php?module=news&view=categories&task=add',FSText :: _('Tên đã tồn tại !'),'error');
					return false;
				}
				
			}else{
				$check_name = $this->get_result('name="'.$name.'" AND id != '.$id);
				if($check_name){
					setRedirect('index.php?module=news&view=categories&task=edit&id='.$id,FSText :: _('Tên đã tồn tại !'),'error');
					return false;
				}
			}

			$record_id =  parent::save($row);
			
			return $record_id;
		}
	}
	
?>