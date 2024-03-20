<?php 
	class Addm_moduleModelsAdd extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'add';
			
			$this -> table_news = 'fs_menus_admin';
			$this -> table_name = 'fs_menus_admin';
			$this -> check_alias = 0;
			$this -> call_update_sitemap = 0;
			parent::__construct();
		}
		function get_data(){
			global $db;
			$query = "SELECT id,name,published,parent_id FROM ".$this->table_name." WHERE parent_id = 0 ORDER BY id DESC ";
			$sql = $db->query($query);			
			$adm_menus = $db->resultArray();	
					
			foreach($adm_menus as $key=>&$menu){
				$db->query("SELECT id,name,link,published,parent_id FROM ".$this->table_name." WHERE parent_id = ".$menu['id']." ORDER BY ordering");
				$menu['child'] = $db->resultArray();
			}
			//print_r($adm_menus);
			return !empty($adm_menus)?$adm_menus:array();
		}
		function get_menu_parent(){
			global $db;
			$query = "SELECT id,name FROM ".$this->table_name." WHERE parent_id = 0 ORDER BY id DESC ";
			$db->query($query);			
			$adm_menus = $db->resultArray();
			return !empty($adm_menus)?$adm_menus:array();
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
			if(isset($_SESSION[$this -> prefix.'filter'])){
				$filter = $_SESSION[$this -> prefix.'filter'];
				if($filter){
					$where .= ' AND b.id =  "'.$filter.'" ';
				}
			}
			if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND ( a.name LIKE '%".$keysearch."%'  )";
				}
			}
			
			$query = ' SELECT a.*
						  FROM 
						  	'.$this -> table_name.' AS a
						  	WHERE 1=1'.
						 $where.
						 $ordering. " ";
						
			return $query;
		}
		function getMemberById()
		{
			$userid = $_SESSION['ad_userid'];
			if(!$userid)
				$id = 0;
			$query = " SELECT a.*
						  FROM fs_users AS a
						  WHERE a.id = $userid ";
			global $db;
			$sql = $db->query($query);
			$result = $db->getObject();
			return $result;
		}
		
		
		
	}
	
?>