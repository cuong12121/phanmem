<?php 
class WarrantyinfoModelsWarrantyinfo extends FSModels
{
	var $limit;
	var $prefix ;
	function __construct()
	{
		$this -> limit = 10;
		$this -> view = 'warrantyinfo';

		$this -> table_name = 'fs_warranty_info';
			// config for save
		$this -> arr_img_paths = array(array('resized',120,120,'cut_image'),array('large',660,360,'resized_not_crop'));
			//$this -> arr_img_paths = array(array('resized',120,120,'cut_image'),array('large',330,180,'resized_not_crop'));
		// $this -> img_folder = 'images/warrantyinfo';
		$this -> check_alias = 0;
		// $this -> field_img = 'image';
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

				if (isset ( $_SESSION [$this->prefix . 'text0'] )) {
			$text0 = $_SESSION [$this->prefix . 'text0'];
			if ($text0) {
				$where .= ' AND a.imei like  "%' . $text0.'%"' ;
			}
		}



		if (isset ( $_SESSION [$this->prefix . 'text1'] )) {
			$text1 = $_SESSION [$this->prefix . 'text1'];
			if ($text1) {
				$where .= ' AND a.phone like  "%' . $text1.'%"' ;
			}
		}


		if (isset ( $_SESSION [$this->prefix . 'text2'] )) {
			$text2 = $_SESSION [$this->prefix . 'text2'];
			if ($text2) {
				$where .= ' AND a.name like  "%' . $text2.'%"' ;
			}
		}



		$query = " SELECT a.*
		FROM 
		".$this -> table_name." AS a
		WHERE 1=1".
		$where.
		$ordering. " ";
		return $query;
	}


	function save($row = array(), $use_mysql_real_escape_string = 1){
		$phone = FSInput::get('phone');
		if(!$phone)
			return false;
		$alias= FSInput::get('imei');
		$begin_time = FSInput::get('begin_time');
		$end_time = FSInput::get('end_time');
		$row['begin_time'] = date('Y-m-d H:i:s',strtotime($begin_time));
		$row['end_time'] =  date('Y-m-d H:i:s',strtotime($end_time));
		$row['alias'] = $alias;
		return parent::save($row);
	}

}

?>