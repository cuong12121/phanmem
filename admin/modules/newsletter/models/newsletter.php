<?php 
	class NewsletterModelsNewsletter extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 2000;
			$this -> view = 'newsletter';
			
			$this -> table_name = 'fs_newsletter';
			parent::__construct();
		}
		
		function setQuery(){
			
			// ordering
			$ordering = "";
			$where = "  ";
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
				$ordering .= " ORDER BY ordering DESC , id DESC ";
			
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND ( a.name LIKE '%".$keysearch."%' )";
				}
			}
			$query = " SELECT a.*, a.alias as ccode
						  FROM 
						  ".$this -> table_name." AS a
						  	WHERE 1=1".
						 $where.
						 $ordering. " ";
						
			return $query;
		}
		
		
		function save($row = array(), $use_mysql_real_escape_string = 1){
			$name = FSInput::get('name');
			if(!$name){
				Errors::_('You must entere name');
				return false;
			}
				
			$id = FSInput::get('id',0,'int');
			$fsstring = FSFactory::getClass('FSString','','../');
			$alias = $fsstring -> stringStandart($name);
			if($this -> check_exist_alias($name,$alias,$id, $this -> table_name)){
				Errors::_('Name must unique');
				return false;
			}
			$row['alias'] = $alias;
				
			$id =  parent::save($row);
			return $id;
		}
	}
	
?>