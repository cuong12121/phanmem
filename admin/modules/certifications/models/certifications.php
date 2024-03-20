<?php 
	class CertificationsModelsCertifications extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 10;
			$this -> view = 'certifications';
			$this -> table_name = 'fs_certifications';
			$this -> table_cat = 'fs_certifications_categories';
			// config for save
			$cyear = date ( 'Y' );
			$cmonth = date ( 'm' );
			$cday = date ( 'd' );
			//$this -> arr_img_paths = array(array('large',340,240,'resize_image'));
			//$this -> arr_img_paths = array(array('resized2',150,150,'cut_image'),array('resized',300,300,'cut_image'),array('large',400,400,'cut_image'),array('compress',1,1,'compress'));
			$this -> arr_img_paths = array(array('resized2',150,150,'cut_image'),array('resized',300,300,'cut_image'),array('large',400,400,'cut_image'),array('compress',1,1,'compress'));
			$this -> img_folder = 'images/certification/'.$cyear . '/' . $cmonth . '/' . $cday;
			$this -> check_alias = 0;
			$this -> field_img = 'image';
			parent::__construct();
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
						  	" . $this->table_name . " AS a
						  	WHERE 1=1".
						 $where.
						 $ordering. " ";
						
			return $query;
		}

		function save($row = array(), $use_mysql_real_escape_string = 1){
            
			
			$row = array();
			$category_id = FSInput::get ( 'category_id', 'int', 0 );
			if (! $category_id) {
				Errors::_ ( 'Bạn phải chọn danh mục' );
				return;
			}
			$cat = $this->get_record_by_id ( $category_id, $this -> table_cat );
		
			$row ['category_id_wrapper'] = $cat->list_parents;
			$row ['category_alias_wrapper'] = $cat->alias_wrapper;
			$row ['category_name'] = $cat->name;
			$row ['category_alias'] = $cat->alias;
            
			return parent::save($row);
		}

		function get_categories_tree() {
			global $db;
			$query = " SELECT a.*
			FROM 
			" . $this->table_cat . " AS a
			ORDER BY ordering ";
			$result = $db->getObjectList ( $query );
			$tree = FSFactory::getClass ( 'tree', 'tree/' );
			$list = $tree->indentRows2 ( $result );
			return $list;
		}
        
		
	
	}
	
?>