<?php 
	class BanksModelsBanks extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 10;
			$this -> view = 'banks';
			
			$this -> table_name = 'fs_alepay_banks';
			// config for save
			$this -> arr_img_paths = array(array('resized',90,20,'resized_not_crop'));
			$this -> img_folder = 'images/banks';
			$this -> check_alias = 0;
			$this -> field_img = 'image';
			parent::__construct();
		}
		
		function get_data()
		{
			global $db;
			$query = $this->setQuery();
			if(!$query)
				return array();
				
			$sql = $db->query_limit($query,$this->limit,$this->page);
			$result = $db->getObjectList();
			
			return $result;
		}
		
        
		
		function save($row = array(), $use_mysql_real_escape_string = 1){
			$name = FSInput::get('name');
			if(!$name)
				return false;
			//$row['map'] = htmlspecialchars_decode(FSInput::get('map'));
			//$row['link_map'] = htmlspecialchars_decode(FSInput::get('link_map'));
			//$row['description'] = htmlspecialchars_decode(FSInput::get('description'));
            
			$alias= FSInput::get('alias');
			$fsstring = FSFactory::getClass('FSString','','../');
            // $city_id  = FSInput::get('city_id',0,'int');
            // $result =  $this->get_result('id = '.$city_id.' ' ,'fs_cities','name');

            $card_types_1= FSInput::get('card_types_1',array(),'array');	
			$row['card_types'] = implode ( ',', $card_types_1 );

			
			return parent::save($row);
		}
		
	}
	
?>