<?php 
class WarrantyModelsWarranty extends FSModels
{
	var $limit;
	var $prefix ;
	function __construct()
	{
		$this -> limit = 20;
		$this -> view = 'warranty';

		$this -> table_name = 'fs_warranty';
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
		
		$query = " SELECT a.*
		FROM 
		" . $this->table_name . " AS a
		WHERE 1=1 " . $where . $ordering . " ";
		return $query;
	}

	function save($row = array(), $use_mysql_real_escape_string = 0) {
		$id = FSInput::get ('id');
		$code = FSInput::get ('code');
		$link = "index.php?module=warranty&view=warranty";
		if($id){
			$link .="&id=".$id;
		}

		if(!$code){
			setRedirect(FSRoute::_($link),'Chưa nhập mã sản phẩm !','error');
		}
		$product = $this->get_record('code = "'.$code.'"','fs_products');

		if(empty($product) ){
			setRedirect(FSRoute::_($link),'Mã sản phẩm không đúng !','error');
		}
		

		if(!$id){
			$row['creator_id'] = $_SESSION['ad_userid'];
			$row['creator_name'] = $_SESSION['ad_username'];
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