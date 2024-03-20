<?php 
class Request_productsModelsViet_nam_import_products extends FSModels
{
	var $limit;
	var $prefix ;
	function __construct()
	{
		$this -> limit = 20;
		$this -> view = 'viet_nam_import_products';
		$this -> table_name = 'fs_import_products';
			// config for save
		// $this -> arr_img_paths = array(array('resized2',150,150,'cut_image'),array('resized',300,300,'cut_image'),array('large',400,400,'cut_image'),array('compress',1,1,'compress'));
		// $this -> img_folder = 'images/warranty';
		// $this -> check_note_code = 1;
		// $this -> field_img = 'image';
		parent::__construct();
	}

	function setQuery() {
		
		// ordering
		$ordering = "";
		$where = "  ";
		// from
		if(isset($_SESSION[$this -> prefix.'text0']))
		{
			$date_from = $_SESSION[$this -> prefix.'text0'];
			if($date_from){
				$date_from = strtotime($date_from);
				$date_new = date('Y-m-d H:i:s',$date_from);
				$where .= ' AND a.date >=  "'.$date_new.'" ';
			}
		}
		
			// to
		if(isset($_SESSION[$this -> prefix.'text1']))
		{
			$date_to = $_SESSION[$this -> prefix.'text1'];
			if($date_to){
				$date_to = $date_to . ' 23:59:59';
				$date_to = strtotime($date_to);
				$date_new = date('Y-m-d H:i:s',$date_to);
				$where .= ' AND a.date <=  "'.$date_new.'" ';
			}
		}



		if (isset ( $_SESSION [$this->prefix . 'filter0'] )) {
			$filter = $_SESSION [$this->prefix . 'filter0'];
			if ($filter) {
				$where .= ' AND a.status = ' . $filter;
			}
		}

		if (isset ( $_SESSION [$this->prefix . 'sort_field'] )) {
			$sort_field = $_SESSION [$this->prefix . 'sort_field'];
			$sort_direct = $_SESSION [$this->prefix . 'sort_direct'];
			$sort_direct = $sort_direct ? $sort_direct : 'asc';
			$ordering = '';
			if ($sort_field)
				$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
		}
		
		if (! $ordering)
			$ordering .= " ORDER BY created_time DESC , id DESC ";
		
		if (isset ( $_SESSION [$this->prefix . 'keysearch'] )) {
			if ($_SESSION [$this->prefix . 'keysearch']) {
				$keysearch = $_SESSION [$this->prefix . 'keysearch'];
				$where .= " AND a.name LIKE '%" . $keysearch . "%' ";
			}
		}

		if($_SESSION['ad_groupid'] == 3){
			$where .= ' AND is_import = 2 AND a.employees_id = ' . $_SESSION['ad_userid'];
		}

		if($_SESSION['ad_groupid'] == 1){
			$where .= ' AND a.creator_id = ' . $_SESSION['ad_userid'];
		}
		
		
		$query = " SELECT a.*
		FROM 
		" . $this->table_name . " AS a
		WHERE type = 5 " . $where . $ordering . " ";
		return $query;
	}

	function save($row = array(), $use_mysql_real_escape_string = 0) {
		$id = FSInput::get ('id');
		$status = FSInput::get ('status');
		$name = FSInput::get ('name');

		$row['type'] = 5;
		$date_to_ha_noi = FSInput::get('date_to_ha_noi');
		if($date_to_ha_noi){
			$row['date_to_ha_noi'] = date('Y-m-d',strtotime($date_to_ha_noi));
		}

		$date_finish = FSInput::get('date_finish');
		if($date_finish){
			$row['date_finish'] = date('Y-m-d',strtotime($date_finish));
		}

		$ngay_thuc_hien = FSInput::get('ngay_thuc_hien');
		if($ngay_thuc_hien){
			$row['ngay_thuc_hien'] = date('Y-m-d',strtotime($ngay_thuc_hien));
		}

		$ngay_dat_hang = FSInput::get('ngay_dat_hang');
		if($ngay_dat_hang){
			$row['ngay_dat_hang'] = date('Y-m-d',strtotime($ngay_dat_hang));
		}

	
		if(!$id){
			$row['creator_id'] = $_SESSION['ad_userid'];
			$row['creator_name'] = $_SESSION['ad_username'];
			$row['status'] = 1;
			$row['is_find'] = 1;
		}

		$id = parent::save ( $row );
		
		return $id;
	}

	function remove(){
		global $db;
		// check remove
		if(method_exists($this,'check_remove')){
			if(!$this -> check_remove()){
				Errors::_(FSText::_('Can not remove these records because have data are related'));
				return false;
			}
		}
		$cids = FSInput::get('id',array(),'array'); 
		
		if(!count($cids))
			return false;
		$str_cids = implode(',',$cids);
		
		$i = 0;
		foreach ($cids as $id) {
			$data = $this->get_record('id = ' . $id,$this -> table_name);
			if(!empty($data) && $data-> is_import < 2){
				$sql = " DELETE FROM ".$this -> table_name." WHERE id = " . $id;
				$row = $db->affected_rows($sql);
				if($row){
					$i++;
				}
			}
		}
		return $i;
	}
}

?>