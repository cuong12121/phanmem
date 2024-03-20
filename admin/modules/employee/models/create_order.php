<?php 
class EmployeeModelsCreate_order extends FSModels
{
	var $limit;
	var $prefix ;
	function __construct()
	{
		$this -> limit = 20;
		$this -> view = 'create_order';

		$this -> table_name = 'fs_warranty_create_order';
		// 	// config for save
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


		if (isset ( $_SESSION [$this->prefix . 'filter0'] )) {
			$filter = $_SESSION [$this->prefix . 'filter0'];
			if ($filter) {
				$where .= ' AND a.status = ' . $filter;
			}
		}
		
		if (isset ( $_SESSION [$this->prefix . 'keysearch'] )) {
			if ($_SESSION [$this->prefix . 'keysearch']) {
				$keysearch = $_SESSION [$this->prefix . 'keysearch'];
				$where .= " AND a.name LIKE '%" . $keysearch . "%' ";
			}
		}

		if($_SESSION['ad_groupid'] == 3){
			$where .= ' AND is_import = 2 AND a.employees_id = ' . $_SESSION['ad_userid'];
		}


		
		
		$query = " SELECT a.*
		FROM 
		" . $this->table_name . " AS a
		WHERE 1=1 " . $where . $ordering . " ";
		return $query;
	}

	function save($row = array(), $use_mysql_real_escape_string = 0) {
		$id = FSInput::get ('id');
		$link = "index.php?module=warranty&view=create_order";
		if($id){
			$link .="&id=".$id;
		}
		

	
		$date = FSInput::get('date');
		$row['date'] = date('Y-m-d',strtotime($date));
		

		if(!$id){
			$row['creator_id'] = $_SESSION['ad_userid'];
			$row['creator_name'] = $_SESSION['ad_username'];
			$row['status'] = 1;
		}
		
		
		$id = parent::save ( $row );
		return $id;
	}

	// function remove(){
	// 	if(method_exists($this,'check_remove')){
	// 		if(!$this -> check_remove()){
	// 			Errors::_(FSText::_('Can not remove these records because have data are related'));
	// 			return false;
	// 		}
	// 	}
	// 	$cids = FSInput::get('id',array(),'array'); 
		
	// 	foreach ($cids as $cid){
	// 		if( $cid != 1)
	// 			$cids[] = $cid ;
	// 	}
	// 	if(!count($cids))
	// 		return false;		
	// 	$i= 0;
	// 	foreach ($cids as $id) {
	// 		$data = $this->get_record_by_id($id);
	// 		if(!empty($data)){
	// 			if($data-> type == 1 AND $data-> status_type_1 == 1){
	// 				continue;
	// 			}

	// 			$sql = " DELETE FROM ".$this -> table_name." WHERE id = ".$data-> id;
	// 			global $db;
	// 			$rows = $db->affected_rows($sql);
	// 			if($rows){
	// 				$i++;
	// 			}
	// 		}
	// 	}
	// 	return $i;
	// }
}

?>