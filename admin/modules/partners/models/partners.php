<?php 
	class PartnersModelsPartners extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'partners';
			$this->type = 'partners';
			$this->table_category_name = 'fs_partners_categories';
			
			$this -> arr_img_paths = array(array('resized',164,80,'resize_image'),array('compress',1,1,'compress'));
			$this->arr_img_paths_other = array (array ('large', 700, 600, 'resize_image' ), array ('small', 47, 35, 'resize_image' ) );
			$this -> table_name = 'fs_partners';
			
			// config for save
			$cyear = date('Y');
			$cmonth = date('m');
			$cday = date('d');
			$this -> img_folder = 'images/partners/'.$cyear.'/'.$cmonth.'/'.$cday;
			$this -> check_alias = 0;
			$this -> field_img = 'image';
//			$this -> field_width = 'width';
			
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
		if (isset ( $_SESSION [$this->prefix . 'filter0'] )) {
			$filter = $_SESSION [$this->prefix . 'filter0'];
			if ($filter) {
				$where .= ' AND a.category_id like  "%' . $filter . '%" ';
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

	// function save($row = array(), $use_mysql_real_escape_string = 1) {
	// 	$category_id = FSInput::get ( 'category_id', 'int', 0 );
	// 	if (! $category_id) {
	// 		Errors::_ ( 'Bạn phải chọn danh mục' );
	// 		return;
	// 	}
		
	// 	$cat = $this->get_record_by_id ( $category_id, 'fs_partners_categories' );
	// 	$row ['category_name'] = $cat->name;
	// 	$result_id = parent::save ( $row );
	// 	return $result_id;
	// }
		function upload_other_images() {
		global $db;
		$path = PATH_BASE . $this->img_folder . DS . 'original' . DS;
		require_once (PATH_BASE . 'libraries' . DS . 'upload.php');
		$upload = new Upload ();
		$upload->create_folder ( $path );
		$file_name = $upload->uploadImage ( 'file', $path, 10000000, '_' . time () );
		//            $upload->create_folder ( $path );
		// xoay ảnh trên IOS và save ghi đè lên ảnh cũ.
		

		//            require_once($_SERVER['DOCUMENT_ROOT'].'/libraries/lib/WideImage.php'); // Gọi thư viện WideImage.php
		//            $uploadedFileName = $path.$file_name;  // lấy ảnh từ  đã upload lên 
		//            $load_img = WideImage::load($uploadedFileName);
		//            $exif = exif_read_data($uploadedFileName); // 
		//            $orientation = @$exif['Orientation'];                        
		//            if(!empty($orientation)) {
		//                switch($orientation) {
		//                    case 8:
		//                        $image_p = imagerotate($uploadedFileName,90,0);
		//                        //echo 'It is 8';
		//                        break;
		//                    case 3:
		//                        $image_p = imagerotate($uploadedFileName,180,0);
		//                        
		//                        //echo 'It is 3';
		//                        break;
		//                    case 6:
		//                        $load_img->rotate(90)->saveToFile($uploadedFileName);
		//                        //$image_p = imagerotate($uploadedFileName,-90,0);
		//                        //echo 'It is 6';
		//                        break;
		//            
		//                }
		//                //imagejpeg ( $image_p , $path.'test.jpg' ,  100 );              
		//            } 
		//            
		// END save ảnh xoay trên IOS   
		if (is_string ( $file_name ) and $file_name != '' and ! empty ( $this->arr_img_paths_other )) {
			$fsFile = FSFactory::getClass ( 'FsFiles' );
			foreach ( $this->arr_img_paths_other as $item ) {
				$path_resize = str_replace ( DS . 'original' . DS, DS . $item [0] . DS, $path );
				$fsFile->create_folder ( $path_resize );
				$method_resize = $item [3] ? $item [3] : 'resized_not_crop';
				$fsFile->$method_resize ( $path . $file_name, $path_resize . $file_name, $item [1], $item [2] );
			}
		}
		$data = base64_decode ( FSInput::get ( 'data' ) );
		$data = explode ( '|', $data );
		$row = array ();
		if ($data [0] == 'add')
			$row ['session_id'] = $data [1];
		else
			$row ['record_id'] = $data [1];
		$row ['image'] = $this->img_folder . '/original/' . $file_name;
		$rs = $this->_add ( $row, FSTable_ad::_ ('fs_' . $this->type . '_images') );
		$row ['id'] = $rs;
		echo json_encode ( $row );
	
	
	return true;
	}
	
		function get_categories()
		{
			global $db;
			$query = " SELECT a.*
						  FROM 
						  	fs_partners_categories AS a
						  	ORDER BY ordering ";
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
		
		
	/**
	 * Sửa thuộc tính của ảnh
	 * 
	 * @return Bool
	 */
	 
	function change_attr_image() {
		global $db;
		$data = base64_decode ( FSInput::get ( 'data' ) );
		$data = explode ( '|', $data );
		$row = array ();
		$where = '';
		if ($data [0] == 'add') {
			$where .= ' AND session_id = "' . $data [1] . '" ';
		} else {
			$where .= ' AND record_id = "' . $data [1] . '" ';
		}
		$field = FSInput::get ( 'field' );
		$value = FSInput::get ( 'value' );
		$id = FSInput::get ( 'id', 0, 'int' );
		if (! $id)
			return;
		if ($field == 'color') {
			$row ['color_id'] = $value;
		}
		$rs = $this->_update ( $row, FSTable_ad::_ ('fs_' . $this->type . '_images'), ' id = ' . $id . $where );
		return $rs;
	}
	function delete_other_image($record_id = 0) {
		global $db;
		if ($record_id)
			$where = 'record_id = \'' . $record_id . '\'';
		else {
			$id = FSInput::get ( 'id', 0 );
			$where = 'id = \'' . $id . '\'';
		}
		$query = '  SELECT *
                        FROM '.FSTable_ad::_ ('fs_' . $this->type . '_images').'
                        WHERE ' . $where;
		$db->query ( $query );
		$listImages = $db->getObjectList ();
		if ($listImages) {
			foreach ( $listImages as $item ) {
				$query = '  DELETE FROM '.FSTable_ad::_ ('fs_' . $this->type . '_images').'
                                WHERE id = \'' . $item->id . '\'';
				$db->query ( $query );
				$path = PATH_BASE . $item->image;
				@unlink ( $path );
				foreach ( $this->arr_img_paths_other as $image ) {
					@unlink ( str_replace ( '/original/', '/' . $image [0] . '/', $path ) );
				}
			}
		}
	}
	
	function sort_other_images() {
		global $db;
		if (isset ( $_POST ["sort"] )) {
			if (is_array ( $_POST ["sort"] )) {
				foreach ( $_POST ["sort"] as $key => $value ) {
					$db->query ( " UPDATE ".FSTable_ad::_ ('fs_' . $this->type . '_images')." SET ordering = $key WHERE id = $value" );
				}
			}
		}
	}
	function uploadAjaxImagespn() {
		$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
		$file_names = array();
	
		global $db;
		$path = PATH_BASE . $this -> img_folder . '/original/';
		
		//die();
		//require_once (PATH_BASE . 'libraries' . DS . 'upload.php');
		//$upload = new Upload ();
		$upload = FSFactory::getClass ( 'FsFiles', '' );
		if (isset($_FILES['filesimg']) && !empty($_FILES['filesimg'])) {
			$no_files = count($_FILES["filesimg"]['name']);
			for ($i = 0; $i < $no_files; $i++) {
				if ($_FILES["filesimg"]["error"][$i] > 0) {
					//echo "Error: " . $_FILES["files"]["error"][$i] . "<br>";
				} else {
					$file_names[$i]  = $fsstring -> stringStandart2($_FILES["filesimg"]["name"][$i]);
					$file_names[$i]  = str_replace('.', '_'.time().'.',$file_names[$i]);
					if (file_exists($path.$file_names[$i])) {
						//echo 'File already exists : '.$path.$file_names[$i]. "<br>";
					} else {
						move_uploaded_file($_FILES["filesimg"]["tmp_name"][$i], $path.$file_names[$i]);
						//echo 'File successfully uploaded :'.$path. $file_names[$i] . "<br>";
					}

				}
			}
		} else {
			echo 'Please choose at least one file';
		}
	

		//$file_name = $upload->uploadImage ( 'Filedata', $path, 500000, '_' . time () );
		
		// $id = FSInput::get ( 'id' );
		// $sql = " SELECT count(*) 
		// 			FROM fs_partners_images 
		// 			WHERE 
		// 				id = '$id'
		// 			";

		
		$upload->create_folder ( $path );
		foreach ($file_names as $file_name2 ) {
			$file_name =$fsstring-> stringStandart2($file_name2);
			# code..
			if (is_string ( $file_name ) and $file_name != '' and ! empty ( $this->arr_img_paths_other )) {
				foreach ( $this->arr_img_paths_other as $item ) {
					$path_resize = str_replace ( '/original/', '/' . $item [0] . '/', $path );
					$upload->create_folder ( $path_resize );
					$method_resize = $item [3] ? $item [3] : 'cut_image';
					$upload->$method_resize ( $path . $file_name, $path_resize . $file_name, $item [1], $item [2] );
				}
			}
			$data = base64_decode ( FSInput::get ( 'data' ) );
			$data = explode ( '|', $data );
			$row = array ();
			if ($data [0] == 'add'){
				$row ['session_id'] = $data [1];
				$max_ordering = $this -> get_max_images('',$row ['session_id']);
			}else{
				$row ['record_id'] = $data [1];
				$max_ordering = $this -> get_max_images($row ['record_id']);
			}
			
			$row ['image'] = $this->img_folder  . '/original/' . $file_name;
			$row ['ordering'] = $max_ordering;
			$title = FSInput::get ( 'image_title' );


			$rs = $this->_add ( $row, 'fs_partners_images' );
		}

		$id = FSInput::get ( 'id' );
		
		$sql = " SELECT count(*) 
					FROM fs_partners_images 
					WHERE 
						record_id = '$id'
					";
		$db->query ( $sql );
		$count = $db->getResult ();
		
		return true;




	}
			function get_categories_tree() {
		global $db;
		$query = " SELECT a.*
						  FROM 
						  	" . $this->table_category_name . " AS a
						  	ORDER BY ordering ";
		$result = $db->getObjectList ( $query );
		$tree = FSFactory::getClass ( 'tree', 'tree/' );
		$list = $tree->indentRows2 ( $result );
		return $list;
	}
	function get_max_images($record_id,$session_id = ''){
		
		$where = '';
		if($record_id)
			$where .= ' record_id = '.$record_id.' ';
		else 
			$where .= ' session_id = "'.$session_id.'" ';
		if(!$where)
			return;
		$query = " SELECT Max(ordering)
		FROM fs_partners_images
		WHERE $where
		";

		global $db;
		$sql = $db->query($query);
		$result = $db->getResult();
		if(!$result)
			return 1;
		return ($result + 1);
	}
function getAjaxImagespn() {
		$data = base64_decode ( FSInput::get ( 'data' ) );
		$data = explode ( '|', $data );
		$where = 'record_id = ' . $data [1];
		if ($data [0] == 'add')
			$where = 'session_id = \'' . $data [1] . '\'';
		global $db;
		$query = '  SELECT *
		FROM fs_partners_images
		WHERE ' . $where . '
		ORDER BY ordering, id DESC';
		$sql = $db->query ( $query );
		return $db->getObjectList ();
	}
	function add_title_other_imagess($record_id = 0) {
		global $db;
		$summary = FSInput::get ( 'titleimage' );
		
		//$summary =  escape_string($_GET['title']);
		if ($record_id)
			$where = 'record_id = \'' . $record_id . '\'';
		else {
			$data = FSInput::get ( 'data', 0 );
			$where = 'id = ' . $data;
		}
		$query = '  UPDATE fs_partners_images SET summary = \'' . $summary . '\'
		WHERE ' . $where;
		
		$db->query ( $query );
		$rows = $db->affected_rows ();
		return $rows;
	}
function delete_other_imagess($partners_id = 0) {
		global $db;
		if ($partners_id)
			$where = 'record_id = \'' . $partners_id . '\'';
		else {
			$data = FSInput::get ( 'data', 0 );
			$where = 'id = \'' . $data . '\'';
		}
		$query = '  SELECT *
		FROM fs_partners_images
		WHERE ' . $where;
		$db->query ( $query );
		$listImages = $db->getObjectList ();
		if ($listImages) {
			foreach ( $listImages as $item ) {
				$query = '  DELETE FROM fs_partners_images
				WHERE id = \'' . $item->id . '\'';
				$db->query ( $query );
				$path = PATH_BASE . $item->image;
				@unlink ( $path );
				foreach ( $this->arr_img_paths_other as $image ) {
					@unlink ( str_replace ( '/original/', '/' . $image [0] . '/', $path ) );
				}
			}
		}
		$id = FSInput::get ( 'id' );
		
		$sql = " SELECT count(*) 
					FROM fs_partners_images 
					WHERE 
						record_id = '$id'
					";
		$db->query ( $sql );
		$count = $db->getResult ();
		
	}
function sort_other_imagess() {
		global $db;
		if (isset ( $_POST ["sort"] )) {
			if (is_array ( $_POST ["sort"] )) {
				foreach ( $_POST ["sort"] as $key => $value ) {
					$db->query ( "UPDATE fs_partners_images SET ordering = $key WHERE id = $value" );
				}
			}
		}
	}

}
		
	
?>