<?php 
class CertificationsModelsHome extends FSModels
{
	var $limit;
	var $prefix ;
	function __construct()
	{
		$this -> limit = 10;
		$this -> view = 'home';
		//$this->table_category_name = 'fs_strengths_categories';
		$this->type = 'home';
		$this -> table_name = 'fs_certifications_home';
			// config for save
		$this -> arr_img_paths = array(array('compress',1,1,'compress'),array('resized',250,150,'cut_image'));

		$this -> img_folder = 'images/certifications';
		$this -> check_alias = 0;
		$this -> field_img = 'image';
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
				$where .= " AND a.title LIKE '%" . $keysearch . "%' ";
			}
		}
		
		$query = " SELECT a.*
		FROM 
		" . $this-> table_name . " AS a
		WHERE 1=1 " . $where . $ordering . " ";
		return $query;
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
	}

?>