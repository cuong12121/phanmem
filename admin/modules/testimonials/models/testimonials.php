<?php 
class TestimonialsModelsTestimonials extends FSModels
{
	var $limit;
	var $prefix ;
	function __construct()
	{
		$this -> limit = 10;
		$this -> view = 'testimonials';

		$this -> table_name = 'fs_testimonials';
			// config for save
		$this -> arr_img_paths = array(array('resized',120,120,'cut_image'),array('large',400,250,'cut_image'));
			//$this -> arr_img_paths = array(array('resized',120,120,'cut_image'),array('large',330,180,'resized_not_crop'));
		$cyear = date ( 'Y' );
		$cmonth = date ( 'm' );
		$cday = date ( 'd' );
		$this -> img_folder = 'images/testimonials/' . $cyear . '/' . $cmonth . '/' . $cday;
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

		$query = " SELECT a.*, b.name as city_name
		FROM 
		fs_testimonials AS a
		LEFT JOIN fs_cities AS b ON a.city_id = b.id
		WHERE 1=1".
		$where.
		$ordering. " ";

		return $query;
	}


	function save($row = array(), $use_mysql_real_escape_string = 1){
		$title = FSInput::get('title');
		if(!$title)
			return false;
						// images hover
		$image_image_video = $_FILES["image_video"]["name"];
		if($image_image_video){
			$image_icon = $this->upload_image('image_video','_'.time(),2000000,$this -> arr_img_paths);
			if($image_icon){
				$row['image_video'] = $image_icon;
			}
		}
			//$row['map'] = htmlspecialchars_decode(FSInput::get('map'));
			//$row['link_map'] = htmlspecialchars_decode(FSInput::get('link_map'));
			//$row['description'] = htmlspecialchars_decode(FSInput::get('description'));

		$alias= FSInput::get('alias');
		$fsstring = FSFactory::getClass('FSString','','../');
		$city_id  = FSInput::get('city_id',0,'int');
		$result =  $this->get_result('id = '.$city_id.' ' ,'fs_cities','name');
		$row['city_name'] = $result;
		return parent::save($row);
	}

}

?>