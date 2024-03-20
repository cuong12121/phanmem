<?php 
	class UsersModelsFiles extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 10;
			$this -> view = 'files';
			$this -> table_name = 'fs_files';
			parent::__construct();
		}

		function setQuery() {
		
			// ordering
			$ordering = "";
			$where = "  ";
			if (isset ( $_SESSION [$this->prefix . 'sort_field'] )) {
				$sort_field = $_SESSION [$this->prefix . 'sort_field'];
				$sort_direct = $_SESSION [$this->prefix . 'sort_direct'];
				$sort_direct = $sort_direct ? $sort_direct : 'asc';
				$ordering = '';
				if ($sort_field)
					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
			}
			
			// estore
			if (isset ( $_SESSION [$this->prefix . 'filter0'] )) {
				$filter = $_SESSION [$this->prefix . 'filter0'];
				if ($filter) {
					$where .= ' AND a.category_id like  "%' . $filter . '%" ';
				}
			}
			
			if (! $ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			if (isset ( $_SESSION [$this->prefix . 'keysearch'] )) {
				if ($_SESSION [$this->prefix . 'keysearch']) {
					$keysearch = $_SESSION [$this->prefix . 'keysearch'];
					$where .= " AND a.name LIKE '%" . $keysearch . "%' ";
				}
			}
			
			$query = " SELECT a.*
							  FROM 
							  	" . $this->table_name . " AS a
							  	WHERE 1=1 " . $where . $ordering . " ";
			return $query;
		}
	
		
		function save($row = array(),$use_mysql_real_escape_string = 0) {
			$id = FSInput::get ( 'id', 0, 'int' );

			// file downlaod
	      	$file_upload = $_FILES["file_upload"]["name"];
			if($file_upload){
				$path_original = '../images/users/download_file/';
				if($id){
					$img_paths = array();
					$img_paths[] = $path_original;
				}

				$fsFile = FSFactory::getClass('FsFiles');
				// upload
				$file_upload_name = $fsFile -> upload_file("file_upload", $path_original ,100000000, '_'.time());
				if(!$file_upload_name)
					return false;
				$row['file_upload'] = 'images/users/download_file/'.$file_upload_name;
			}

			$id = parent::save ( $row );
			if (! $id) {
				Errors::setError ( 'Not save' );
				return false;
			}
			return $id;
		}
	}
	
?>