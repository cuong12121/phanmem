<?php 
class MembersModelsMembers extends FSModels
{
	var $limit;
	var $prefix ;
	function __construct()
	{
		$limit = 100;
		$this -> view = 'members';
		$this->limit = $limit;
		$this -> table_name = 'fs_members';

		$this->arr_img_paths = array (array ('resized', 300, 300, 'cut_image' ), array ('small', 120, 80, 'cut_image' ), array ('large', 900, 600, 'cut_image' ) );
		// $this->table_name = 'fs_news';
		
		// config for save
		$cyear = date ( 'Y' );
		$cmonth = date ( 'm' );
		$cday = date ( 'd' );
		$this->img_folder = 'images/members/' . $cyear . '/' . $cmonth . '/' . $cday;
		$this->check_alias = 0;
		$this->field_img = 'image';


		parent::__construct();

	}

	function getMembers()
	{
		global $db;
		$query = $this->setQuery();
		if(!$query)
			return array();

		$sql = $db->query_limit($query,$this->limit,$this->page);
		$result = $db->getObjectList();

		if(	isset($_POST['filter'])){
			$_SESSION[$this -> prefix.'filter']  =  $_POST['filter'] ;
		}
		
		return $result;
	}
	function get_member_info($start = 0,$end = 0){
		global $db;
		$query = $this->setQuery();
		if(!$query)
			return array();
		$sql = $db->query_limit_export($query,$start,$end);
		$result = $db->getObjectList();
		if(	isset($_POST['filter'])){
			$_SESSION[$this -> prefix.'filter']  =  $_POST['filter'] ;
		}
		
		return $result;
	}


	function setQuery()
	{
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
		$where = "  WHERE 1=1 ";

		if(isset($_SESSION[$this -> prefix.'keysearch'])){
			$keysearch = $_SESSION[$this -> prefix.'keysearch'];
			if($keysearch){
				$where .= " AND ( a.full_name LIKE '%".$keysearch."%' )
				";
			}
		}
		if(isset($_SESSION[$this -> prefix.'filter0'])){
			$filter = $_SESSION[$this -> prefix.'filter0'];
			if($filter < 2){
				$where .= " AND published = $filter ";
			}
		}
//			
//			if(isset($_SESSION[$this -> prefix.'city'] ))
//			{
//				if($_SESSION[$this -> prefix.'city'] )
//				{
//					$city_id = $_SESSION[$this -> prefix.'city'];
//					$where .= " AND a.city_id  =".$city_id." ";
//				}
//			}
//			if(isset($_SESSION[$this -> prefix.'published'] ))
//			{
//				$status= $_SESSION[$this -> prefix.'published'];
//				switch($status)
//				{
//					case 'activated':
//						$where .= " AND a.published = 1 ";
//						break;	
//					case 'unactivated':
//						$where .= " AND a.published = 0 ";
//						break;
//				}
//			}

		$query = " SELECT *
		FROM 
		fs_members AS a
		$where
		$ordering 
		";
		return $query;
	}

	function getTotal()
	{
		global $db;
		$query = $this->setQuery();
		$sql = $db->query($query);
		$total = $db->getTotal();
		return $total;
	}


	function getPagination()
	{
		$total = $this->getTotal();			
		$pagination = new Pagination($this->limit,$total,$this->page);
		return $pagination;
	}

	/**************************** end EXPORT *********************/
		/*
		 * Select a Members by Id
		 */
		function getMemberById()
		{
			$ids = FSInput::get('id',array(0),'array');
			$id = $ids[0];
			if(!$id)
				$id = 0;
			$query = " SELECT a.*
			FROM fs_members AS a
			WHERE a.id = $id ";
			
			global $db;
			$sql = $db->query($query);
			$result = $db->getObject();
			return $result;
		}
		
		function getCity()
		{
			global $db ;
			$sql = " SELECT id, name FROM fs_cities ";
			//$db->query($sql);
			return $db->getObjectList($sql);
		}
		
		
		
		/******************************** SAVE *****************************************/
		/*
		 * 
		 * Save
		 */
		function save($row = array(), $use_mysql_real_escape_string = 1){

			// echo 'xxx';die;
			$username = FSInput::get('username');
			$row['email'] = FSInput::get('email');

			// $row['identity_card'] = FSInput::get('identity_card');
			$city_id = FSInput::get('city_id');
			if($city_id) {
				$city = $this-> get_record('id = '.$city_id, 'fs_cities', 'name');
				$row['city_id'] = $city_id;
				$row['city_name'] = $city-> name;
				$row['city'] = $city-> name;
			}
			$district_id = FSInput::get('district_id');
			if($district_id) {
				$district = $this-> get_record('id = '.$district_id, 'fs_districts', 'name');
				$row['district_id'] = $district_id;
				$row['district_name'] = $district-> name;
				// $row['district'] = $district-> name;
			}

			$ward_id = FSInput::get('ward_id');
			if($ward_id) {
				$ward = $this-> get_record('id = '.$ward_id, 'fs_wards', 'name');
				$row['ward_id'] = $ward_id;
				$row['ward_name'] = $ward-> name;
				// $row['district'] = $district-> name;
			}
			$level_id = FSInput::get('level');
			if($level_id) {
				$level = $this-> get_record('id = '.$level_id, 'fs_members_level', 'name');
				$row['level'] = $level_id;
				$row['level_name'] = $level-> name;
			}

			$birth_day = FSInput::get('birth_day');
			$birth_month = FSInput::get('birth_month'); 
			$birth_year = FSInput::get('birth_year'); 

			$row['birthday'] = $birth_year.'-'.$birth_month.'-'.$birth_day;

			if(!$username)
				return false;
			$edit_pass = FSInput::get('edit_pass');

			if($edit_pass){
				// $password1 = FSInput::get("password1")
				$row['password'] = md5(FSInput::get("password1"));

			}

			$user_id = FSInput::get('id');

			if($user_id) {
				$check_eror =$this-> get_record('id <> '.$user_id.' AND username = "'.$username.'"', 'fs_members', 'id');
				if(!empty($check_eror)) {
					Errors::_ ( 'Username này đã sử dụng!' );
					return false;
				}
			} else {
				$check_eror =$this-> get_record('username = "'.$username.'"', 'fs_members', 'id');
				if(!empty($check_eror)) {
					Errors::_ ( 'Username này đã sử dụng!' );
					return false;
				}
			}

			$value_point = $this-> get_record('id = '.$user_id, 'fs_members', 'point') -> point;

			for ($i=0; $i <10; $i++) { 


				$action_id  = $_SESSION['ad_userid']; 
				$time = date ( 'Y-m-d H:i:s' );
				$action_username = $_SESSION['ad_username']; 
				$value = FSInput::get('value_'.$i,0,'');
				$note = FSInput::get('note_'.$i,0,'');
				$type="admin_change";
				

				$row2 = array();

				$row2['action_id'] = $action_id;
				$row2['created_time'] = $time;
				$row2['action_username'] = $action_username;
				$row2['value'] = $value;
				$row2['type'] = $type;
				$row2['user_id'] = $user_id;
				$row2['note'] = $note;

				// print_r($row2);die;

				if($value) {
					$id_his = $this -> _add($row2,'fs_history_point_members',1);
					$value_point = $value_point + $row2['value'];
				}	

				if($value_point<0) {
					$value_point  = 0;
				}

				$row['point'] = $value_point;
			}

			$id = parent::save($row);

			if($id){
				return $id;
			} else {
				return $id_his;
			}

			
		}
		
		function remove(){
			$img_paths = array();
			$img_paths[] = PATH_IMG_MEMBER_AVATAR.'original'.DS;
			$img_paths[] = PATH_IMG_MEMBER_AVATAR.'resized'.DS;
			return parent::remove('avatar',$img_paths);
		}

		/*************** ADDRESS *************/
		/*
		 * get list District
		 * default: Ha Noi
		 */
		function getDistricts($cityid = '1')
		{
			if(!$cityid)
				$cityid = '1';
			global $db ;
			$sql = " SELECT id, name FROM fs_districts
			WHERE city_id = $cityid ";
			//$db->query($sql);
			return $db->getObjectList($sql);
		}

		function getWards($districtid = '1')
		{
			if(!$districtid)
				$districtid = '1';
			global $db ;
			$sql = " SELECT id, name FROM fs_wards
			WHERE district_id = $districtid ";
			//$db->query($sql);
			return $db->getObjectList($sql);
		}

		function getWards2($city_id = '1')
		{
			if(!$city_id)
				$city_id = '1';
			global $db ;
			$sql = " SELECT id, name FROM fs_wards
			WHERE city_id = $city_id ";
			//$db->query($sql);
			return $db->getObjectList($sql);
		}
		
		/*
		 * Createa folder when create user
		 */
		function create_folder_upload($id){
			$fsFile = FSFactory::getClass('FsFiles','');
			$path = PATH_BASE.'uploaded'.DS.'estores'.DS.$id;
			return $fsFile->create_folder($path);
		}
		
		function get_level(){
			$sql = " SELECT * FROM fs_members_level ";
			global $db ;
			$db->query($sql);
			return $db->getObjectList($sql);
		}
	}
	
	
	?>