<?php 
	class NewsModelsAuthor extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{


			$this->limit = 50;
			$this->view = 'author';
		
			
			$this -> arr_img_paths = array(array('resized',300,300,'cut_image'),array('small',100,100,'cut_image'));

			$this -> table_name = FSTable_ad::_ ('fs_news_author');
			
			// config for save
			$cyear = date ( 'Y' );
			$cmonth = date ( 'm' );
			$cday = date ( 'd' );
			$this->img_folder = 'upload_images/images/news/author/' . $cyear . '/' . $cmonth . '/' . $cday;
			$this->check_alias = 0;
			$this->field_img = 'image';
			
			parent::__construct ();
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

		// function save($row = array(),$use_mysql_real_escape_string = 0){
		// 	$type_id = FSInput::get('type_id');
		// 	$row = array();
		// 	if($type_id == 1){
		// 		$row['type_name'] = 'Người kiểm duyệt';
		// 	}else{
		// 		$row['type_name'] = 'Người viết';
		// 	}
		// 	$result_id = parent::save ( $row );
		// 	return $result_id;
		// }

	}
	
?>