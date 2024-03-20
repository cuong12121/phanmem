<?php 
	class ProductsModelsCategories_slideshow extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'categories_slideshow';
			
			// $this -> arr_img_paths = array(array('compress',1,1,'compress'));
			$this -> table_name = 'fs_products_categories_slideshow';
			
			// config for save
			$cyear = date('Y');
			$cmonth = date('m');
			$cday = date('d');
			$this -> img_folder = 'images/products/categories/slideshow/'.$cyear.'/'.$cmonth.'/'.$cday;
			$this -> check_alias = 0;
			$this -> field_img = 'image';
			
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
			
			// estore
			if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter){
					$where .= ' AND a.category_id =  "'.$filter.'" ';
				}
			}	
			
			if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND a.name LIKE '%".$keysearch."%' ";
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
		function  save($row = array(), $use_mysql_real_escape_string = 1){
			$category_id = FSInput::get('category_id',0,'int');
			if(!$category_id){
				return false;
			}
			$category = $this -> get_record_by_id($category_id,'fs_products_categories');
			if(!empty($category)){
				$arr_img_paths = array(array('large',1000,300,'cut_image'),array('compress',1,1,'compress'));
				$row['category_wrapper_id'] = $category->list_parents;
				$this -> arr_img_paths = $arr_img_paths; 
				return parent::save($row);
			}
			
		}
		
		/*
		 * select in category of home
		 */
		function get_categories()
		{
			global $db;
			$query = " SELECT a.*
						  FROM 
						  	fs_products_categories AS a 
						  	ORDER BY ordering ";
			$sql = $db->query($query);
			$result = $db->getObjectList();

			$tree  = FSFactory::getClass('tree','tree/');
			$list = $tree -> indentRows2($result);
			
			return $list;
		
		}
	}
?>