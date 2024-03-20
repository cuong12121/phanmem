<?php 
class EmployeeModelsImport_products extends FSModels
{
	var $limit;
	var $prefix ;
	function __construct()
	{
		$this -> limit = 20;
		$this -> view = 'import_products';
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
				$where .= ' AND a.is_find = ' . $filter;
			}
		}

		if (isset ( $_SESSION [$this->prefix . 'filter1'] )) {
			$filter = $_SESSION [$this->prefix . 'filter1'];
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
		
		
		$query = " SELECT a.*
		FROM 
		" . $this->table_name . " AS a
		WHERE 1=1 " . $where . $ordering . " ";
		return $query;
	}

	function save($row = array(), $use_mysql_real_escape_string = 0) {
		$id = FSInput::get ('id');
		$status = FSInput::get ('status');
		$name = FSInput::get ('name');
		// $link = "index.php?module=warranty&view=return";
		// if($id){
		// 	$link .="&id=".$id;
		// }

		// $date_finish = FSInput::get('date_finish');
		// if(!$date_finish){
		// 	$row['date_finish'] = date('Y-m-d',strtotime($date_finish));
		// }

		$date_to_ha_noi = FSInput::get('date_to_ha_noi');
		if($date_to_ha_noi){
			$row['date_to_ha_noi'] = date('Y-m-d',strtotime($date_to_ha_noi));
		}

		$date_to_tq = FSInput::get('date_to_tq');
		if($date_to_tq){
			$row['date_to_tq'] = date('Y-m-d',strtotime($date_to_tq));
		}

		$date_phat_hanh = FSInput::get('date_phat_hanh');
		if($date_phat_hanh){
			$row['date_phat_hanh'] = date('Y-m-d',strtotime($date_phat_hanh));
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
		

		if($id){
			$row2 = array();
			if($ngay_dat_hang){
				$row2['ngay_dat_hang'] = $row['ngay_dat_hang'];
			}
			$row2['code_product'] = FSInput::get ('code_product');
			$row2['name'] = $name;
			$row2['count'] = FSInput::get ('count');
			$row2['code'] = FSInput::get ('code');
			$row2['code_deposit'] =  FSInput::get ('code_deposit');
			if($date_phat_hanh){
				$row2['date_phat_hanh'] =  $row['date_phat_hanh'];
			}
			if($date_to_tq){
				$row2['date_to_tq'] =  $row['date_to_tq'];
			}
			if($date_to_ha_noi){
				$row2['date_to_ha_noi'] =  $row['date_to_ha_noi'];
			}
			$row2['note_nhan_vien_nhan_hang'] =  FSInput::get ('note_nhan_vien_nhan_hang');
			$row2['note_nhan_hang'] =  FSInput::get ('note_nhan_hang');
			$row2['product_error'] =  FSInput::get ('product_error');
			$row2['nhap_hang_khieu_nai'] =  FSInput::get ('nhap_hang_khieu_nai');
			$row2['type'] = 1;
			$row2['record_id'] = $id;
			if($status == 2){
				$row2['published'] = 1;
			}
			$check = $this->get_record('type = 1 AND record_id = '.$id,'fs_list_import_products');
			// dd($check);
			if(!empty($check)){
				$this->_update($row2,'fs_list_import_products','id = '.$check->id);
			}else{
				$this->_add($row2,'fs_list_import_products');
			}
		}

		return $id;
	}
}

?>