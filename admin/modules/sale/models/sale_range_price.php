<?php 
	class SaleModelsSale_range_price extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 10;
			$this -> view = 'sale_range_price';
			$this -> table_name = FSTable_ad::_ ('fs_sale_range_price');
			// config for save
			$this -> arr_img_paths = array(array('resized',297,374,'resized_not_crop'),array('large',450,566,'resized_not_crop'));
			$this -> img_folder = 'images/sale';
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
		
		function setQuery(){
			
			// ordering
			$ordering = "";
			if(isset($_SESSION[$this -> prefix.'sort_field']))
			{
				$sort_field = $_SESSION[$this -> prefix.'sort_field'];
				$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
				$sort_direct = $sort_direct?$sort_direct:'asc';
				$ordering = '';
				if($sort_field)
					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
					
			}
			if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			$where = "  ";
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND name LIKE '%".$keysearch."%' ";
				}
			}
			
			$query = " SELECT a.*
						  FROM 
						  	".$this -> table_name." AS a
						  	WHERE 1=1 ".
						 $where.
						 $ordering. " ";
						
			return $query;
		}
        
		
		function save($row = array(), $use_mysql_real_escape_string = 1){
			$title = FSInput::get('title');
			if(!$title)
				return false;
	        $date_start = FSInput::get('date_start');
			$published_hour_start = FSInput::get('published_hour_start',date('H:i'));
			if($date_start){
				$row['date_start'] = date('Y-m-d H:i:s',strtotime($published_hour_start
					.':0 '. $date_start));
			}	
			
			$date_end = FSInput::get('date_end');
			$published_hour_end = FSInput::get('published_hour_end',date('H:i'));
			if($date_end && $published_hour_end){
				$row['date_end'] = date('Y-m-d H:i:s',strtotime($published_hour_end.':0 '. $date_end));
			}

			$alias= FSInput::get('alias');
			$fsstring = FSFactory::getClass('FSString','','../');
			return parent::save($row);
		}
	}
	
?>