<?php 
class AlbumsModelsAlbums extends FSModels
{
	var $limit;
	var $prefix ;
	function __construct()
	{
		$this -> limit = 10;
		$this -> view = 'albums';
		$this -> table_name = 'fs_albums';
		$this -> arr_img_paths = array(array('small',150,74,'cut_image'),array('resized',500,500,'cut_image'),array('large',1260,620,'cut_image'),array('compress',1,1,'compress'));
		$this -> img_folder = 'images/albums';
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

	function setQuery1(){
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
				$where .= " AND title LIKE '%".$keysearch."%' ";
			}
		}

		$query = " SELECT * FROM  fs_albums AS a WHERE 1=1". $where . $ordering. " ";
		return $query;
		
	}

}

?>