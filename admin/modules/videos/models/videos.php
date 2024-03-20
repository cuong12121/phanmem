<?php 
	class VideosModelsVideos extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'videos';
			$this -> table_name = 'fs_videos';
			$this -> arr_img_paths = array(array('resized',400,267,'cut_image'),array('small',200,133,'cut_image'),array('large',600,400,'cut_image'),array('compress',1,1,'compress'));

			$cyear = date('Y');
			$cmonth = date('m');
			$cday = date('d');
			
			$this-> video_folder = 'media/videos/' . $cyear . '/'. $cmonth . '/' . $cday.'/';
			$this -> img_folder = 'images/videos';
			$this -> field_img = 'image';
//			$this -> image_watermark = array('path_image_watermark'=>'images/mask/icon-videos-big.png','position'=>0); //Đóng dấu nên ảnh
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
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND a.title LIKE '%".$keysearch."%' ";
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

		function hot($value)
		{
			$ids = FSInput::get('id',array(),'array');
			
			if(count($ids))
			{
				global $db;
				$str_ids = implode(',',$ids);
				$sql = " UPDATE ".$this -> table_name."
							SET is_hot = $value
						WHERE id IN ( $str_ids ) " ;
				$db->query($sql);
				$rows = $db->affected_rows();
				return $rows;
			}
			return 0;
			
		}

		function save($row = array(), $use_mysql_real_escape_string = 1) {
			$id = FSInput::get ( 'id', 0, 'int' );
			// $title = FSInput::get ( 'title' );
			// if (! $title)
			// 	return false;
			// $id = FSInput::get ( 'id', 0, 'int' );
			$category_id = FSInput::get ( 'category_id', 'int', 0 );
			if (! $category_id) {
				Errors::_ ( 'Bạn phải chọn danh mục' );
				return;
			}
			
			$cat = $this->get_record_by_id ( $category_id, 'fs_videos_categories' );
			
			$row ['category_id_wrapper'] = $cat->list_parents;
			$row ['category_alias_wrapper'] = $cat->alias_wrapper;
			$row ['category_name'] = $cat->name;
			$row ['category_alias'] = $cat->alias;
			$row ['category_published'] = $cat->published;
			$record_relate = FSInput::get ( 'products_record_related', array (), 'array' );
			$row ['products_related'] = '';
			if (count ( $record_relate )) {
				$record_relate = array_unique ( $record_relate );
				$row ['products_related'] = ',' . implode ( ',', $record_relate ) . ',';
			}
			
			
			$fsFile = FSFactory::getClass ( 'FsFiles', '' );

			if(isset($_FILES['link_video_upload']["name"]) && $_FILES['link_video_upload']["name"]){
				$path = PATH_BASE . str_replace ( '/', DS, $this->video_folder );
				$fsFile -> create_folder($path);
				// print_r($_FILES['link_video_upload']);
				// die('vvv');
				$link_sound_exist = $fsFile->upload_video("link_video_upload", $path, 3000000000, '_' . time () );
			
				if($link_sound_exist){

					$row['link_video'] = $this->video_folder.$link_sound_exist;

				}

			}else{
								
			}
			if($id && $row['link_video']){
				$video_old = $this -> get_field_by_id($id, 'link_video',$this -> table_name);
				
				if($video_old && $video_old != $row['link_video']){
					if(strpos($video_old, 'media/videos/') !== false){
						$path = PATH_BASE.$video_old ;
						$path = str_replace ( '/', DS, $path );
						$fsFile->remove_file_by_path ( $path );
					}
				}
			}

			$result_id = parent::save ( $row );
			return $result_id;
		}


		function get_categories_tree() {
			global $db;
			$query = " SELECT a.*
			FROM 
			fs_videos_categories AS a
			ORDER BY ordering ";
			$result = $db->getObjectList ( $query );
			$tree = FSFactory::getClass ( 'tree', 'tree/' );
			$list = $tree->indentRows2 ( $result );
			return $list;
		}

		function get_categories()
		{
			global $db;
			$query = " SELECT a.*
						  FROM 
						  	fs_videos_categories AS a
						  	ORDER BY ordering ";
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}


		///


		function get_products_categories_tree() {
			global $db;
			$sql = " SELECT id, name, parent_id AS parent_id 
					FROM ".FSTable_ad::_('fs_products_categories')."
					ORDER BY ordering ASC ";
			$categories = $db->getObjectList ( $sql );
			
			$tree = FSFactory::getClass ( 'tree', 'tree/' );
			$rs = $tree->indentRows ( $categories, 1 );
			return $rs;
		}
		function ajax_get_products_related() {
			$news_id = FSInput::get ( 'product_id', 0, 'int' );
			$category_id = FSInput::get ( 'category_id', 0, 'int' );
			$keyword = FSInput::get ( 'keyword' );
			$where = ' WHERE published = 1 ';
			if ($category_id) {
				$where .= ' AND (category_id_wrapper LIKE "%,' . $category_id . ',%"	) ';
			}
			$where .= " AND ( name LIKE '%" . $keyword . "%' OR alias LIKE '%" . $keyword . "%' )";
			
			$query_body = ' FROM '.FSTable_ad::_('fs_products').' ' . $where;
			$ordering = " ORDER BY created_time DESC , id DESC ";
			$query = ' SELECT id,category_id,name,category_name ' . $query_body . $ordering . ' LIMIT 40 ';
			global $db;
			$result = $db->getObjectList ( $query );
			return $result;
		}
		/*
		 *====================AJAX RELATED NEWS==============================
		 */
		function get_products_related($products_related) {
			if (! $products_related)
				return;
			$query = " SELECT id, name 
						FROM ".FSTable_ad::_('fs_products')."
						WHERE id IN (0" . $products_related . "0) 
						 ORDER BY POSITION(','+id+',' IN '0" . $products_related . "0')
						";
			global $db;
			$result = $db->getObjectList ( $query );
			return $result;
		}

	}
	
?>