<?php 
	class ImagesModelsimages extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'images';
			$this -> type = 'images';
			$this -> table_name = 'fs_images';
			$this -> table_category = 'fs_'.$this -> type.'_categories';
			
			$this -> arr_img_paths = array(array('small',100,100,'cut_image'),array('resized',500,313,'cut_image'),array('large',1000,625,'cut_image'));
			$this -> arr_img_paths_other = array(array('small',100,100,'cut_image'),array('large',1000,625,'cut_image'),array('resized',500,313,'cut_image'),array('compress',1,1,'compress'));
			// config for save
			$cyear = date('Y');
			$cmonth = date('m');
			$cday = date('d');
			$this -> img_folder = 'images/'.$this -> type.'/'.$cyear.'/'.$cmonth.'/'.$cday;
			$this -> check_alias = 1;
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
			if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter){
//					$where .= ' AND a.category_id_wrapper like   "%'.$filter.'%" ';
					$where .= ' AND category_id  =    '.$filter.' ';
				}
			}
			if(isset($_SESSION[$this -> prefix.'filter1'])){
				$filter = $_SESSION[$this -> prefix.'filter1'];
				if($filter){
					$where .= ' AND a.type = '.$filter.' ';
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
		
		function save($row = array(),$use_mysql_real_escape_string = 1){
		
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
			
			// category and category_id_wrapper
			$category_id = FSInput::get('category_id',0,'int');
			if(!$category_id)
				return false;
			$cat =  $this->get_record_by_id($category_id,$this -> table_category);
			$row['category_id_wrapper'] = $cat -> list_parents;
//			$row['category_root_alias'] = $cat -> root_alias;
//			$row['category_alias_wrapper'] = $cat -> alias_wrapper;
//			$row['category_name'] = $cat -> name;
			$row['category_alias'] = $cat -> alias;
//			$row['tablename'] = $cat -> tablename;
			
				
			// remove other_image
			if(!$this -> remove_other_images($id)){
//				return false;
			}
			if(!$this -> save_exist_images()){
//				return false;
			}
					$id = parent::save($row);
			if(!$id){
				Errors::setError('Not save');
				return false;
			}
			
		
				// upload other_imge
				if(!$this->upload_other_images($id))
				{
					Errors::setError('Can not upload other_image');
				}
			
			return $id;
		}
			/*
		 * select in category of home
		 */
		function get_categories_tree()
		{
			global $db;
			$query = " SELECT a.*
						  FROM 
						  	".$this -> table_category." AS a
						  	ORDER BY ordering ";
			$sql = $db->query($query);
			$result = $db->getObjectList();
			$tree  = FSFactory::getClass('tree','tree/');
			$list = $tree -> indentRows2($result);
			return $list;
		}
//		function upload_other_images($record_id)
//		{
//			global $db;
//			$fsFile = FSFactory::getClass('FsFiles','');
//			for($i = 0 ; $i < 5; $i ++)
//			{
//				$upload_area   = "other_image_".$i;
//				if($_FILES[$upload_area]["name"])
//				{
//					$row = array();
//					$image = $this -> upload_image($upload_area,'_'.time(),2000000,$this -> arr_img_paths_other);
////					$row['name'] = FSInput::get('new_name_'.$i);
////					$row['ordering'] = FSInput::get('new_ordering_'.$i);
//					$row['record_id'] = $record_id;
//					$row['image'] = $image;
//					$rs = $this -> _add($row, 'fs_'.$this->type.'_images');
//				}
//			}
//			return true;
//		}
	
		
		
		/*
		 * get data from fs_project_images
		 */
		function get_project_images($record_id){
			if(!$record_id)
				return;
			$query   = " SELECT image,id,ordering,name 
						FROM fs_images_images
						WHERE record_id = $record_id";
			global $db;
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
		
		/*
		 * remove other_images for project when save project
		 * These images is not main images. 
		 */
		function remove_other_images($record_id){
			if(!$record_id)
				return true;
			$other_images_remove = FSInput::get('other_image',array(),'array');
			$str_other_images = implode(',',$other_images_remove);
			if($str_other_images)
			{
				global $db;
				
				// remove images in folder contain these images
				$query   = " SELECT image 
						FROM fs_".$this -> type."_images
						WHERE record_id = $record_id
						AND id IN ($str_other_images)
						";
				$sql = $db->query($query);
				$images_need_remove = $db->getObjectList();
				
				$fsFile = FSFactory::getClass('FsFiles','');
				$arr_img_paths = $this -> arr_img_paths_other;
				foreach ($images_need_remove as $item) {
					if($item->image){
						$path = str_replace(URL_ROOT, PATH_BASE, $item->image);
						$path = str_replace('/',DS, $path);
						$fsFile-> remove_file_by_path($path);
						
						if(count($arr_img_paths)){
							foreach($arr_img_paths as $item){
								$path_resize = str_replace(DS.'original'.DS, DS.$item[0].DS, $path);
								$fsFile-> remove_file_by_path($path_resize);
							}
						}
					}
				}
				
				// remove in database
				$sql = " DELETE FROM fs_images_images
						WHERE record_id = $record_id
							AND id IN ($str_other_images)" ;
				$db->query($sql);
				$rows = $db->affected_rows();
				return $rows;
			}
			return true;
		}
//		function remove(){
//			
//			// remove other image
//			$record_id = FSInput::get('id');
//			$this -> remove_image_by_record_id();
//			
//			// remove main image
//			$img_paths = array();
//			$img_paths[] = PATH_IMG_images_ORIGINAL;
//			$img_paths[] = PATH_IMG_images_STANDART;
//			$img_paths[] = PATH_IMG_images_CROPPED;
//			return parent::remove('image',$img_paths);
//		}
		
		/*
		 * Remove all record and image in table fs_project_images when remove project
		 */
		function _______remove_image_by_record_id()
		{
			$cids = FSInput::get('id',array(),'array');
			foreach ($cids as $cid){
				if( $cid != 1){
					$cids[] = $cid ;
				}
			}
			$str_cids = implode(',',$cids);
			if(!$str_cids)	
				return true;
			global $db;
			$query   = " SELECT image 
						FROM fs_images_images
						WHERE record_id IN ($str_cids)
						";
			
			$sql = $db->query($query);
			$images_need_remove = $db->getObjectList();
			
			if(!count($images_need_remove))
				return true;
			
			$fsFile = FSFactory::getClass('FsFiles','');
			foreach ($images_need_remove as $item) {
				if($item->image)
				{
					$fsFile-> remove($item->image, PATH_IMG_images_ORIGINAL);
					$fsFile-> remove($item->image, PATH_IMG_images_STANDART);
					$fsFile-> remove($item->image, PATH_IMG_images_CROPPED);
				}
			}
			
			// remove in database
			$sql = " DELETE FROM fs_images_images
					WHERE record_id IN  ($str_cids)
						" ;
			$db->query($sql);
			$rows = $db->affected_rows();
			return $rows;
				
		}
	/*
		 * Lưu ảnh đã tồn tại
		 */
		function save_exist_images(){
			global $db;
				
			// EXIST FIELD
			$images_exist_total = FSInput::get('images_exist_total');
				
			$sql_alter = "";
			$arr_sql_alter = array();
			$rs = 0;
			
			for($i= 0 ; $i < $images_exist_total ; $i++){
				
				$id_exist = FSInput::get('id_exist_'.$i);
				
				$name_exist = FSInput::get('name_exist_'.$i);
				$name_exist_begin = FSInput::get('name_exist_'.$i."_begin");
				
				$ordering_exist = FSInput::get('ordering_exist_'.$i);
				$ordering_exist_begin = FSInput::get('ordering_'.$i.'_begin');
				
				if( ($name_exist != $name_exist_begin) || ($ordering_exist != $ordering_exist_begin) ) {
					
					$row = array();
					$row['name'] = $name_exist;
					$row['ordering'] = $ordering_exist;
					
					$u = $this -> _update($row, 'fs_images_images',' id='.$id_exist);
					if($u)
						$rs ++;
				}
			}
			return $rs;
			// END EXIST FIELD
		}
		
		function typical($value)
		{
			$ids = FSInput::get('id',array(),'array');
			
			if(count($ids))
			{
				global $db;
				$str_ids = implode(',',$ids);
				$sql = " UPDATE ".$this -> table_name."
							SET typical = $value
						WHERE id IN ( $str_ids ) " ;
				$db->query($sql);
				$rows = $db->affected_rows();
				return $rows;
			}
			
			return 0;
		}
		
	
	/**
	 * Lấy danh sách ảnh
	 * 
	 * @return Object list
	 */
	function get_other_images() {
		$data = base64_decode ( FSInput::get ( 'data' ) );
		$data = explode ( '|', $data );
		$where = 'record_id = ' . $data [1];
		if ($data [0] == 'add')
			$where = 'session_id = \'' . $data [1] . '\'';
		global $db;
		$query = '  SELECT *
                        FROM ' . 'fs_' . $this->type . '_images' . ' 
                        WHERE ' . $where . '
                        ORDER BY ordering, id DESC';
		$sql = $db->query ( $query );
		return $db->getObjectList ();
	}
	
	/**
	 * Update project id vào images
	 */
	function update_other_images($id = 0) {
		global $db;
		$session_id = FSInput::get ( 'session_id' );
		$query = '  UPDATE fs_' . $this->type . '_images SET record_id = ' . $id . ', session_id = \'\'
                        WHERE session_id = \'' . $session_id . '\'';
		$db->query ( $query );
		$rows = $db->affected_rows ();
		return $rows;
	}
	
	/**
	 * Upload và resize ảnh
	 * 
	 * @return Bool
	 */
	function upload_other_images() {
		global $db;
		$path = PATH_BASE . $this->img_folder . DS . 'original' . DS;
		require_once (PATH_BASE . 'libraries' . DS . 'upload.php');
		$upload = new Upload ();
		$upload->create_folder ( $path );
		$file_name = $upload->uploadImage ( 'file', $path, 10000000, '_' . time () );

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
		$rs = $this->_add ( $row, 'fs_' . $this->type . '_images' );
		$row ['id'] = $rs;
		echo json_encode ( $row );
		return true;
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
		$rs = $this->_update ( $row, 'fs_' . $this->type . '_images', ' id = ' . $id . $where );
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
                        FROM fs_' . $this->type . '_images
                        WHERE ' . $where;
		$db->query ( $query );
		$listImages = $db->getObjectList ();
		if ($listImages) {
			foreach ( $listImages as $item ) {
				$query = '  DELETE FROM fs_' . $this->type . '_images
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
					$db->query ( "UPDATE fs_" . $this->type . "_images SET ordering = $key WHERE id = $value" );
				}
			}
		}
	}
}
?>