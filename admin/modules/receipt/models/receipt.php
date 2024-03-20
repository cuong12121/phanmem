<?php 
class ReceiptModelsReceipt extends FSModels
{
	var $limit;
	var $prefix ;
	function __construct()
	{
		$this -> limit = 20;
		$this -> view = 'receipt';
		$this -> table_name = 'fs_receipt';
		$this -> arr_img_paths = array(array('resized',400,400,'cut_image'),array('large',400,400,'cut_image'));

			// config for save
		$cyear = date('Y');
		$cmonth = date('m');
		$cday = date('d');
		$this -> img_folder = 'images/receipt/'.$cyear.'/'.$cmonth.'/'.$cday;
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
				$where .= " AND a.name LIKE '%".$keysearch."%' OR id=".$keysearch;
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
		//print_r($_SESSION);
		$query = " SELECT a.*
		FROM 
		".$this -> table_name." AS a
		WHERE 1=1 ".
		$where.
		$ordering. " ";
		return $query;
	}

	function save($row = array(),$use_mysql_real_escape_string = 0){
		$name = FSInput::get('name');
		if(!$name)
			return false;
		$phone = FSInput::get('phone');
		if(!$phone)
			return false;
		$imei = FSInput::get('imei');
		if(!$imei)
			return false;

		$row2['name'] = $name;
		$row2['phone'] = $phone;
		$row2['imei'] = $imei;
		$today = date('Y-m-d H:i');
		$row2['created_time'] = $today;
		$row2['published'] = 1;

		$cus = $this -> get_record('imei = "'.$imei.'"','fs_warranty_info');

		if($cus) {
			$row['record_id'] = $cus-> id;
			$row['name'] = $cus-> name;
			$row['phone'] = $cus -> phone;
			$row['imei'] = $cus -> imei;
		}
		else {
			$cus_id = $this-> _add($row2,'fs_warranty_info');
			$row['customer_id'] = $cus_id;
			$row['customer_name'] = $name;
			$row['customer_phone'] = $phone;
		}
	//	echo $row['customer_id'];
	//	die();
		$end_time = FSInput::get('end_time');
		if($end_time) {
			$row['end_time'] = date('Y-m-d',strtotime($end_time));
		} else {
			$row['end_time'] = NULL;
		}
		
		$row['begin_time'] = $today;
		// $alias= FSInput::get('alias');
		$fsstring = FSFactory::getClass('FSString','','../');
		$row['alias'] = $fsstring -> stringStandart($imei);
	//	$row['step'] = 0;
		$row['more_info'] = htmlspecialchars_decode(FSInput::get('more_info'));
		$id = FSInput::get('id',0,'int');
		if(!$this -> remove_other_images($id))
			return false;
			// upload other_imge
		return parent::save($row);

	}
	function remove(){
		$img_paths = array();
		$path_original =  PATH_IMG_ADDRESS.'original'.DS;
			$path_resize =  PATH_IMG_ADDRESS.'resized'.DS; //142x100
			$path_large =  PATH_IMG_ADDRESS.'large'.DS; //309x219
			$img_paths[] = $path_original;
			$img_paths[] = $path_resize;
			$img_paths[] = $path_large;
			return parent::remove('image',$img_paths);
		}
		
		/*
		 * value: == 1 :hot
		 * value  == 0 :unhot
		 * published record
		 */
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
		function upload_other_images_2($id)
		{
			global $db;
			$fsFile = FSFactory::getClass('FsFiles','');
			for($i = 0 ; $i < 5; $i ++)
			{
				$upload_area   = "other_image_".$i;
				if($_FILES[$upload_area]["name"])
				{
					// upload
//					$path =  PATH_IMG_PRODUCTS.$category_alias.'/original'.DS;
					$path =  PATH_IMG_ADDRESS.'/original'.DS;
					$image = $fsFile -> uploadImage($upload_area, $path ,2000000, '_'.time());
					if(	!$image)
						return false;
					
					// rezise to standart : 300x175
//					$path_crop =  PATH_IMG_PRODUCTS.$category_alias.'/resized'.DS;
					$path_crop =  PATH_IMG_ADDRESS.'/resized'.DS;
					if(!$fsFile ->resize_image($path.$image, $path_crop.$image,130, 130))
					{
						return false;
					}
					
					$path_resize = PATH_IMG_ADDRESS.'large'.DS;
					if(!$fsFile ->resize_image($path.$image, $path_resize.$image,770, 500))
						return false;
					
				// rezise to medium : 356x356
					$path_resize = PATH_IMG_ADDRESS.'medium'.DS;
					if(!$fsFile ->resize_image($path.$image, $path_resize.$image,245, 208))
						return false;

					// rezise to standart : 70x70
					$path_small = PATH_IMG_ADDRESS.'small'.DS;
					if(!$fsFile ->resize_image($path.$image, $path_small.$image,70,70)){
						return false;
					}
					
					
					$sql = " INSERT INTO fs_showroom_images
					(address_id,image)
					VALUES ('$id','$image')
					";
//					print_r($sql);exit;
					$db->query($sql);
					if(!$db->insert())
						return false;		
				}		
			}
			return true;
		}
		function get_showroom_images($address_id){
			if(!$address_id)
				return;
			$query   = " SELECT image,id 
			FROM fs_showroom_images
			WHERE address_id = $address_id";
			global $db;
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
		function remove_other_images($add_id)
		{
			if(!$add_id)
				return true;
			$other_images_remove = FSInput::get('other_image',array(),'array');
			$str_other_images = implode(',',$other_images_remove);
			if($str_other_images)
			{
				global $db;
				
				// remove images in folder contain these images
				$query   = " SELECT image 
				FROM fs_showroom_images
				WHERE address_id = $add_id
				AND id IN ($str_other_images)
				";
				$sql = $db->query($query);
				$images_need_remove = $db->getObjectList();
				
				$fsFile = FSFactory::getClass('FsFiles','');
				foreach ($images_need_remove as $item) {
					if($item->image)
					{
						$fsFile-> remove($item->image, PATH_IMG_ADDRESS.'original'.DS);
						$fsFile-> remove($item->image, PATH_IMG_ADDRESS.'resized'.DS);
						$fsFile-> remove($item->image, PATH_IMG_ADDRESS.'large'.DS);
						$fsFile-> remove($item->image, PATH_IMG_ADDRESS.'medium'.DS);
						$fsFile-> remove($item->image, PATH_IMG_ADDRESS.'small'.DS);
						
					}
				}
				
				// remove in database
				$sql = " DELETE FROM fs_showroom_images
				WHERE address_id = $add_id
				AND id IN ($str_other_images)" ;
				$db->query($sql);
				$rows = $db->affected_rows();
				return $rows;
			}
			return true;
		}
		function getListDistricts($city_id = 0){
			global $db;
			$sqlWhere = '';
			if($city_id)
				$sqlWhere = ' AND provinceid = "'.$city_id.'"';
			$query = '  SELECT id, name,alias
			FROM district 
			WHERE published = 1 '.$sqlWhere.'
			ORDER BY alias ASC';
//                        echo $query;die;
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}

		// function get_data_2($user_id){
		// 	$query = " SELECT *
		// 	FROM fs_receipt where technical_id =".$user_id." 
		// 	ORDER BY id ASC"
		// 	;
		// 	global $db;
		// 	$sql = $db->query($query);
		// 	return  $db->getObjectList();
		// }


		function getListCustomer($phone){
			global $db;
			$sqlWhere = '';
			if($phone)
				$sqlWhere = ' AND phone like "%'.$phone.'%"';
			$query = '  SELECT id, name, phone, imei, device_name
			FROM fs_warranty_info 
			WHERE published = 1 '.$sqlWhere;
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}

		function getListCustomer3($imei){
			global $db;
			$sqlWhere = '';
			if($imei)
				$sqlWhere = ' AND imei like "%'.$imei.'%"';
			$query = '  SELECT id, name, phone, imei, device_name
			FROM fs_warranty_info 
			WHERE published = 1 '.$sqlWhere;
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}

		function getListCustomer2($name){
			global $db;
			$sqlWhere = '';
			if($name)
				$sqlWhere = ' AND name like "%'.$name.'%"';
			$query = ' SELECT id, name, phone, imei, device_name
			FROM fs_warranty_info 
			WHERE published = 1 '.$sqlWhere;
//                        echo $query;die;
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}

		function getListCustomer_receip($name){
			global $db;
			$sqlWhere = ' AND status = 1';
			if($name)
				$sqlWhere = ' AND name like "%'.$name.'%"';
			$query = 'SELECT DISTINCT id,name
			FROM fs_warehouse 
			WHERE published = 1 '.$sqlWhere.' Group by name order by id ASC';
//                        echo $query;die;
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}


		function get_categories_tree2()
		{
			global $db;
			$query = " SELECT *
			FROM 
			province AS a where 1=1 order by a.alias asc
			";
			//	echo $query;			
			$sql = $db->query($query);
			$result = $db->getObjectList();
			// $tree  = FSFactory::getClass('tree','tree/');
			// $list = $tree -> indentRows2($result);
			return $result;
		}
		function get_city(){
			global $db;
			$query = " SELECT a.*
			FROM province
			AS a
			ORDER BY alias asc ";
			$sql = $db->query($query);
			$list = $db->getObjectList();
			return $list;
		}
		function get_categories_tree()
		{
			global $db;
			$query = " SELECT name,id,province_name,provinceid
			FROM 
			district AS a where 1=1 order by a.alias asc
			";
			//	echo $query;			
			$sql = $db->query($query);
			$result = $db->getObjectList();
			// $tree  = FSFactory::getClass('tree','tree/');
			// $list = $tree -> indentRows2($result);
			return $result;
		}

		function remove_days($record_id) {
			if (! $record_id)
				return true;
			$other_days_remove = FSInput::get('other_days',array(),'array');
			$str_other_days = implode(',',$other_days_remove);
			if ($str_other_days) {
				global $db;

    				// remove in database
				$sql = " DELETE FROM fs_address_other
				WHERE record_id = $record_id AND id IN ($str_other_days)";
				$db->query ( $sql );
				$rows = $db->affected_rows ();
				return $rows;
			}
			return true;
		}
		function save_exist_days($id) {
			global $db;
    		// EXIST FIELD
			$days_exist_total = FSInput::get ( 'days_exist_total' );

			$sql_alter = "";
			$arr_sql_alter = array ();
			$rs = 0;
			for ($i = 0; $i < $days_exist_total; $i++) {
				$id_days_exist = FSInput::get('id_days_exist_' . $i);
				$days_name = mysql_real_escape_string(FSInput::get('days_name_exist_' . $i));
				$row = array();
				$row ['source'] = $days_name;
//                    if($i==1){
//                        echo $id_days_exist;die;
//                    }
				$u = $this->_update($row, 'fs_address_other', ' id=' . $id_days_exist);
				if ($u)
					$rs ++;
			}
			return $rs;
		}

		function save_new_days($record_id) {
        //    die;
			global $db;
			for($i = 0; $i < 20; $i ++) {
				$row = array ();
				$row ['source'] = (FSInput::get ( 'new_days_name_' . $i ));

				if (! $row ['source']) {
					continue;
				}

				$row ['record_id'] = $record_id;
				$rs = $this->_add ( $row, 'fs_address_other', 1 );
			}
			return true;
		}
		function get_days($tours_id){
			return $this -> get_records('record_id = '.$tours_id,'fs_address_other');
		}
		
		function get_regions(){
			return $this -> get_records('',FSTable_ad::_('fs_address_regions'),'*','ordering ASC ');
		}

		function export_address() {
			$query = " SELECT *
			FROM fs_address 
			ORDER BY id ASC"
			;
			global $db;
			$sql = $db->query($query);
			return  $db->getObjectList();
		}

		function get_customer_by_id($customer_id) {
			$query = " SELECT *
			FROM fs_customer WHERE id = ".$customer_id;
			global $db;
			$sql = $db->query($query);
			return  $db->getObject();
		}
		

		function get_config(){
			$query = " SELECT *
			FROM fs_config";
			global $db;
			$sql = $db->query($query);
			return  $db->getObjectList();
		}

		function get_coupon_by_id($id){
			$query = " SELECT *
			FROM fs_coupon where receipt_id=".$id;
			global $db;
			$sql = $db->query($query);
			return  $db->getObject();
		}

		

		function savetechnical(){
			$time = date('Y-m-d H:i');
			$row['time_step1']=$time;
			$technical_id = FSInput::get('technical_id');
			$technical = $this-> get_record('id = '.$technical_id, 'fs_users');
			$row['technical_id'] = $technical_id;
			$row['technical_name'] = $technical-> username;
			$row['step'] = 1;

			$receipt_id = FSInput::get('receipt_id');
			$this -> _update($row,'fs_receipt','id = '.$receipt_id);
		}

		function savelinh_kien(){
			$time = date('Y-m-d H:i');
			$arr_id = FSInput::get('arr_id');
			$receipt_id = FSInput::get('receipt_id');
			$technical_note = FSInput::get('technical_note');
			$arrid = explode(',', $arr_id);

			if(!empty($arrid)) {
				$row1['technical_note']=$technical_note;
				$row1['fs_receipt_id']=$receipt_id;
				$row1['technical_id'] = $_SESSION['ad_userid'];
				$row1['technical_name'] = $_SESSION['ad_username'];
				$row1['type'] = 1;
				$row1['status'] = 0;
				$row1['published'] = 0;
				$row1['store_id'] =  $_SESSION['store_id'];
				$store = $this-> get_record('id = '.$row1['store_id'] , 'fs_store');
				$row1['store_name'] =  $store-> name;
				$row1['created_time'] = $time;
				$accessories_coupon_id = $this->_add ( $row1, 'fs_accessories_coupon', 1 );
				foreach ($arrid as $detail_id) {
					if($detail_id) {
						$detail = $this-> get_record('id = '.$detail_id , 'fs_warehouse');
						$row2['name'] = $detail-> name;
						$row2['record_id'] = $detail_id;
						$row2['accessories_coupon_id'] = $accessories_coupon_id;
						$row2['receipt_id'] = $receipt_id;
						$this->_add ( $row2, 'fs_accessories_coupon_detail', 1 );
					}
				}
			}

			$row['time_step2']=$time;
			$row['accessories_coupon_id']=@$accessories_coupon_id;
			//$accessories = FSInput::get('accessories');
			//$row['accessories'] = $accessories;
			$row['step'] = 2;
			$row['is_linhkien'] = 1;
			$this -> _update($row,'fs_receipt','id = '.$receipt_id);
		}

		function saveylinh_kien(){
			$time = date('Y-m-d H:i');
			$row['time_step3']=$time;
			$is_cap = FSInput::get('is_cap');
			$row['is_cap'] = $is_cap;
			$row['user_inventory_id'] = $_SESSION['ad_userid'];
			$row['user_inventory_name'] = $_SESSION['ad_username'];
			$row['step'] = 3;
			$receipt_id = FSInput::get('receipt_id');
			$this -> _update($row,'fs_receipt','id = '.$receipt_id);
		}

		function savestep7(){
			$time = date('Y-m-d H:i');
			$row['time_step7']=$time;
			$row['step'] = 7;
			$receipt_id = FSInput::get('receipt_id');
			$this -> _update($row,'fs_receipt','id = '.$receipt_id);
		}

		function savestep4(){
			$time = date('Y-m-d H:i');
			$row['time_step4']=$time;
			$row['step'] = 4;
			$is_linhkien = FSInput::get('is_linhkien');
			$row['is_linhkien'] = @$is_linhkien;
			$receipt_id = FSInput::get('receipt_id');
			$this -> _update($row,'fs_receipt','id = '.$receipt_id);
		}

		function savestep5(){
			$time = date('Y-m-d H:i');
			$row['time_step5']=$time;
			$row['step'] = 5;
			$receipt_id = FSInput::get('receipt_id');
			$is_sua = FSInput::get('is_sua');
			$row['is_sua'] = $is_sua;
			$this -> _update($row,'fs_receipt','id = '.$receipt_id);
		}

		function savestep6(){
			$time = date('Y-m-d H:i');
			$row['time_step6']=$time;
			$row['step'] = 6;
			$receipt_id = FSInput::get('receipt_id');
			$this -> _update($row,'fs_receipt','id = '.$receipt_id);
		}
	}
	
	?>