<?php 
	class ContentsModelsTranslate_content extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'translate_content';
			$this -> table_name = 'fs_translate_content';
			$this->table_template='fs_template';
			$this->field_img = 'image';
			
			parent::__construct();
		}
		function save(){
			$name = FSInput::get('name');
			if(!$name){
				Errors::_('You must entere name');
				return false;
			}	
			
			$id = FSInput::get('id',0,'int');
				
			$alias= FSInput::get('alias');
			$fsstring = FSFactory::getClass('FSString','','../');
		
			if(!$alias){
				$row['alias'] = $fsstring -> stringStandart($name);
			} else {
				$row['alias'] = $fsstring -> stringStandart($alias);
			}
			
			$template = FSInput::get ('etemplate_id',0,'int');
			$row['etemplate_id'] = $template;
			$id = parent::save($row);
			if(!$id){
				Errors::setError('Not save');
				return false;
			}
			
		
			
			return $id;
		}
		function get_all_template() {
		global $db;
		$query = " SELECT id, name,image,template
				FROM " . $this->table_template;
		global $db;
		$sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;
	}
	}
?>