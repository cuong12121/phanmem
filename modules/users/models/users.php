<?php 
class UsersModelsUsers extends FSModels
{
	function __construct()
	{
	}
	function getConfig($name)
	{
		global $db;
		$sql = " SELECT value FROM fs_config 
		WHERE name = '$name' ";
			// $db->query($sql);
		return $db->getResult($sql);
	}


	/********** REGISTER ***********/
		/*
		 * save register
		 */
		function save()
		{
			global $db,$config;
			$row = array();
			$time = date("Y-m-d H:i:s");

			$yearnow = date('Y');	
			$expired_level = ($yearnow+1).'-12-31 23:59:59';
			$row['expired_level'] = $expired_level;
			$row['update_level_date'] =date("Y-m-d H:i:s");
			$row['email'] =   FSInput::get("email");
			$row['username'] = FSInput::get("email");
			$password_de = FSInput::get("r_password");
			$row['password'] = md5($password_de);
			$row['full_name'] =   FSInput::get("name");
			$row['address'] =   FSInput::get("city");
			// $row['city'] =   FSInput::get("city");
			$row['gender'] =   FSInput::get("gender");
			$row['telephone'] =   FSInput::get("telephone");

			$birth_day = FSInput::get('date');
			$birth_month = FSInput::get('month'); 
			$birth_year = FSInput::get('year');

			$row['birthday'] = $birth_year.'-'.$birth_month.'-'.$birth_day;

			$row['v_birthday'] =FSInput::get("birthday");

			$row['block'] =  0;
			$row['published'] =  1;

			$level_default = $this-> get_record('published = 1 AND is_default = 1','fs_members_level', '*');
			$row['level'] = $level_default-> id;
			$row['level_name'] = $level_default-> name;
			
			$fstring = FSFactory::getClass('FSString','','../');
			$row['activated_code'] =  $fstring->generateRandomString(32);
			$row['created_time']  = $time;
			$row['edited_time']  = $time;
			if($config['check_donate_points']) {
				$row['point']  = $config['donate_points'];
			}

			$id = $this -> _add($row, 'fs_members');

			if($id) {
				$row2 = array();
				$row2['affiliate_code'] = $fstring->generateRandomString(8).$id;
				$this-> _update($row2, 'fs_members', ' id='.$id);
			}

			if($config['check_donate_points'] && $config['donate_points']) {
				$row3 = array();
				$row3['user_id'] = $id;
				$row3['value'] = $config['donate_points'];
				$row3['note'] = 'Tặng điểm cho thành viên đăng ký mới.';
				$row3['created_time']  = $time;
				$row3['type'] = 'register';
				$id = $this -> _add($row3, 'fs_history_point_members');
			}

//			if($id){
//				$this -> send_mail_activated_user($row['full_name'],$row['username'],$password_de,$row['activated_code'],$id,$row['email']);
//			}
			return $id;	
		}
		
		function buy_fast_save(){
			$fsstring = FSFactory::getClass('FSString','','../');
			$row = array ();
			$name = FSInput::get('name_buy_fast');
			$phone = FSInput::get('telephone_buy_fast');
			$email = FSInput::get('email_buy_fast');
			$mes = FSInput::get('mes_buy_fast');

			if (!$email)
				return;
			$time = date ( "Y-m-d H:i:s" );

			$row ['phone'] = $phone;
			$row ['time'] = $time;
			$row ['name'] = $name;
			$row ['email'] = $email;
			$row ['message'] = $mes;
			$id =  $this -> _add($row, 'fs_phone_fast',1);
			return $id;
		}
		function update_account($username,$user_id,$address_book_id){
			$row = array('user_id' => $user_id, 'username' => $username);
			$this -> _update($row, 'fs_address_book', 'WHERE id = '.$address_book_id);
		}
		
		/*
		 * Register addressbook
		 */
		function register_address_book(){
			$time = date("Y-m-d H:i:s");	
			$data_address = array(
				'category_id'=>FSInput::get('cat_code'),
				'name'=>FSInput::get('name_address'),
				'business_license'=>FSInput::get('business_license'),
				'activity_filed'=>FSInput::get('activity_filed'),
				'main_areas'=>FSInput::get('main_areas'),
				'partner'=>FSInput::get('partner'),
				'partner_country_id'=>FSInput::get('partner_country_id'),
				'revenue'=>FSInput::get('revenue'),
				'quantity_staff'=>FSInput::get('quantity_staff'),
				'working_time_from'=>FSInput::get('working_time_from'),
				'working_time_to'=>FSInput::get('working_time_to'),
				'lunch_break_from'=>FSInput::get('lunch_break_from'),
				'lunch_break_to'=>FSInput::get('lunch_break_to'),
				'holiday_week'=>FSInput::get('holiday_week'),
				'country_id'=>FSInput::get('address_country_id'),
				'city_id'=>FSInput::get('address_city_id'),
				'district_id'=>FSInput::get('address_district_id'),
				'commune_id'=>FSInput::get('address_commune_id'),
				'street'=>FSInput::get('address_street'),
				'house'=>FSInput::get('address_house'),
				'region_phone'=>FSInput::get('address_region_phone'),
				'phone'=>FSInput::get('address_phone'),
				'region_fax'=>FSInput::get('address_region_fax'),
				'fax'=>FSInput::get('address_fax'),
				'hotline'=>FSInput::get('address_hotline'),
				'email_baokim'=>FSInput::get('email_baokim'),
				'website'=>FSInput::get('address_website'),
				'published'=>1,
				'created_time'=>$time,
				'edited_time'=>$time,
			);
			$certificate = FSInput::get('certificate',array(),'array');
			$object_service = FSInput::get('object_service',array(),'array');
			if(!empty($certificate) && is_array($certificate)){
				$data_address['certificate'] = ','.implode(',',$certificate).',';
			}
			if(!empty($object_service) && is_array($object_service)){
				$data_address['object_service'] = ','.implode(',',$object_service).',';
			}
			// Lấy thông tin bổ sung về danh mục (loại hình hoạt động)
			$categories = $this->get_record_by_id(FSInput::get('cat_code'),'fs_address_book_categories');
			$category_name = $categories->name;
			$data_address['category_name'] = $categories->name;
			$data_address['category_alias'] = $categories->alias;
			$data_address['category_alias_wrapper'] = $categories->alias_wrapper;
			$data_address['category_id_wrapper'] = $categories->list_parents;
			
			// partner country
			$detail = $this->get_record_by_id(FSInput::get('partner_country_id',0,'int'),'fs_countries');
			$data_address['partner_country_name'] = $detail->name;
			$data_address['partner_country_flag'] = $detail->flag;
			
			// country for address book
			if($detail = $this->get_record_by_id(FSInput::get('address_country_id'),'fs_countries')){
				$country_name = $detail->name;
				$data_address['country_name'] = $country_name;
				$data_address['country_flag'] = $detail->flag;
			}
			//	city for address book
			if($detail = $this->get_record_by_id(FSInput::get('address_city_id',0,'int'),'fs_cities')){
				$city_name = $detail->name;
				$data_address['city_name'] = $city_name;
			}
			//	district for address book			
			if($detail = $this->get_record_by_id(FSInput::get('address_district_id',0,'int'),'fs_districts')){
				$district_name = $detail->name;
				$data_address['district_name'] = $district_name;
			}
			//	commune for address book	
			if($detail = $this->get_record_by_id(FSInput::get('address_commune_id',0,'int'),'fs_commune')){
				$commune_name = $detail->name;
				$data_address['commune_name'] = $commune_name;
			}
			// Kiểm tra xem đăng ký mới hay sửa danh bạ
			$address_book_id = FSInput::get('address_book_id');
			if(!empty($address_book_id)){ 
				return $address_book_id;
			}else{
				//update content_search
				$fsstring = FSFactory::getClass('FSString','');	
				$content_search = $fsstring -> removeHTML($category_name.' '.FSInput::get('name_address').' '.FSInput::get('main_areas').' '.FSInput::get('activity_filed').' '.$country_name.' '.$city_name.' '.$district_name.' '.$commune_name);	
				
				$data_address['content_search'] =  $fsstring ->convert_utf8_to_telex($content_search).' '.$fsstring ->remove_viet_sign($content_search);
				$address_book_id = $this->_add($data_address,'fs_address_book');
				return $address_book_id;
			}
		}
		
		function upload_avatar(){
			$avatar = $_FILES["avatar"]["name"];
			if(!$avatar)
				return ;
			$fsFile = FSFactory::getClass('FsFiles');
			$img_folder = 'images/avatar/original/';
			$path = str_replace('/', DS, $img_folder);
			$path = PATH_BASE.$path;
			
			$avatar = $fsFile -> uploadImage('avatar', $path ,2000000, '_'.time());
			if(!$avatar)
				return;
			// resize avatar : 50x50
			$path_resize = str_replace(DS.'original'.DS, DS.'resized'.DS, $path);
			if(!$fsFile ->resized_not_crop($path.$avatar, $path_resize.$avatar,50, 50))
				return false;
			return	$img_folder.$avatar;
		}
		
		function save_estore($user_id)
		{
			if(!$user_id)
				return false;
			global $db;
			$username = FSInput::get("username");
			$cpn_name = FSInput::get("cpn_name");
			$estore_name = $cpn_name;
			
			$fsstring = FSFactory::getClass('FSString','');	
			$estore_alias = $fsstring -> stringStandart($cpn_name);	
			$estore_name_not_sign = $fsstring -> remove_viet_sign($cpn_name);
			
			$cpn_telephone = FSInput::get("cpn_telephone");
			$cpn_mobilephone = FSInput::get("cpn_mobilephone");
			$cpn_fax = FSInput::get("cpn_fax");
			$cpn_website = FSInput::get("cpn_website");
			$cpn_province = FSInput::get("province");
			$cpn_district = FSInput::get("district");
			$cpn_address = FSInput::get("cpn_address");
			$cpn_intro = strip_tags($_POST["cpn_intro"]);
			
			
			$time = date("Y-m-d H:i:s");
			$published = 0;
			$activated = 0;
			
			$sql = " INSERT INTO 
			fs_estores (user_id,`username`,estore_name,estore_alias,estore_name_not_sign,telephone,mobilephone,fax,website
			,created_time,edited_time,published,`activated`,`address`,`estore_intro`,`city_id`,`district_id`,`etemplate`)
			VALUES ('$user_id','$username','$cpn_name','$estore_alias','$estore_name_not_sign','$cpn_telephone','$cpn_mobilephone','$cpn_fax','$cpn_website',
			'$time','$time','$published','$activated','$cpn_address','$cpn_intro','$cpn_province','$cpn_district','default') 
			";
			// $db->query($sql);
			
			$id = $db->insert($sql);
			
			return $id;
		}

		function edit_save(){

			global $db;
			$password = FSInput::get("password");
			$re_password = FSInput::get("re-password");
			$verify_old_password = FSInput::get("verify_old_password");
			$full_name = FSInput::get("full_name");
			$telephone = FSInput::get("telephone");
			$email = FSInput::get("email");
			$sex =  FSInput::get("sex");
			$address =  FSInput::get("address");
			$birth_day = FSInput::get('date');
			$birth_month = FSInput::get('month'); 
			$birth_year = FSInput::get('year'); 
			$city_id = FSInput::get('city_id'); 

			$city = $this-> get_record('id = '.$city_id,'fs_cities','*');

			

			$user_id = $_COOKIE['user_id'];
			$user = $this-> get_record('id = '.$user_id,'fs_members','*');

			$row = array();

			$row['city'] = $city_id;
			$row['city_id'] = $city_id;
			$row['city_name'] = $city-> name;
			$row['address'] = $address;
			$row['birthday'] = $birth_year.'-'.$birth_month.'-'.$birth_day;

			if($password){
				$password = md5($password);
				$verify_old_password =  md5($verify_old_password);
				if($verify_old_password == $user-> password) {
					$check_pass = 1;
					$row['password'] = $password;
				} else {
					$check_pass = 2;
				}
			}

			$row['full_name'] = $full_name;
			$row['telephone'] = $telephone;
			$row['email'] = $email;
			$row['sex'] = $sex;

			// print_r($row);die;

			$save = $this-> _update($row,'fs_members','id = '.$user_id);

			if($save) {
				if(@$check_pass == 2) {
					return 2;
				} else {
					return 1;
				}
			}
			else{
				return false;
			}
		}
		
		
// 		function edit_save()
// 		{
// 			global $db;
// 			$password = FSInput::get("password");
// 			if($password)
// 			{
// 				$password = md5($password);
// 				$sql_pwd  = "password = '$password' ,";
// 			}
// 			else
// 				$sql_pwd = "";
// 			$update="";	

// 			$full_name      =  FSInput::get("full_name");
// 			$full_name=( !empty($full_name))?"full_name = '$full_name'":"";
// 			$update=$full_name;

// 			$birth_day      =  FSInput::get("birth_day");
// 			$birth_month      =  FSInput::get("birth_month");
// 			$birth_year      =  FSInput::get("birth_year");
// 			if(!empty($birth_day) && !empty($birth_month) && !empty($birth_year)){
// 				$birthday = date("Y-m-d",mktime(0, 0, 0, $birth_month, $birth_day, $birth_year));
// 			}
// 			$birthday=( !empty($birthday))?"birthday = '$birthday'":"";
// 			$update=(!empty($birthday) && !empty($update))?"$update,$birthday":$update.$birthday;

// 			$address =  FSInput::get("address");
// 			$address=( !empty($address))?"address = '$address'":"";
// 			$update=(!empty($address) && !empty($update))?"$update,$address":$update.$address;

// 			$job =  FSInput::get("job");
// 			$job=( !empty($job))?"job = '$job'":"";
// 			$update=(!empty($job)  && !empty($update))?"$update,$job":$update.$job;

// 			$email      =  FSInput::get("email");
// 			$email=( !empty($email))?"email = '$email'":"";
// 			$update=(!empty($email) && !empty($update))?"$update,$email":$update.$email;

// 			$phone      =  FSInput::get("mobilephone");
// 			$phone=( !empty($phone))?"mobilephone = '$phone'":"";
// 			$update=(!empty($phone) && !empty($update))?"$update,$phone":$update.$phone;

// 			$city =  FSInput::get("city");
// 			$city=( !empty($city))?"city = '$city'":"";
// 			$update=(!empty($city)  && !empty($update))?"$update,$city":$update.$city;

// 			$gender =  FSInput::get("gender");
// 			$gender=( !empty($gender))?"gender = '$gender'":"";
// 			$update=(!empty($gender)  && !empty($update))?"$update,$gender":$update.$gender;

// 			$telephone =  FSInput::get("telephone");
// 			$telephone=( !empty($gender))?"telephone = '$telephone'":"";
// 			$update=(!empty($telephone)  && !empty($update))?"$update,$telephone":$update.$telephone;

// 			$v_birthday =  FSInput::get("v_birthday");
// 			$v_birthday=( !empty($v_birthday))?"v_birthday = '$v_birthday'":"";
// 			$update=(!empty($v_birthday)  && !empty($update))?"$update,$v_birthday":$update.$v_birthday;

// 			if(!empty($update)){
// 				$sql = " UPDATE  fs_members SET 
// 				".$update."

// 				WHERE username = 	'".$_SESSION['username']."' 
// 				";
// //				echo $sql;die;
// 				// $db->query($sql);
// 				$rows = $db->affected_rows($sql);
// 				if($rows)
// 				{
// 					return $rows;
// 				}
// 			}
// 			else{
// 				return false;
// 			}
// 		}
		/*
		 * check exist username
		 * Sim must active
		 * published == 1: OK.  not use
		 * published != 1: not OK
		 */
		function checkUsername($username)
		{
			global $db ;
			$username = FSInput::get("username");
			if(!$username )
			{
				Errors::setError("H&#227;y nh&#7853;p s&#7889; username");
				return false;
			}
			$sql = " SELECT count(*)
			FROM fs_members
			WHERE 
			username = '$username'
			";
			$db -> query($sql);
			$count =  $db->getResult();
			if(!$count)
			{
				Errors::setError("Username ");
				return false;
			}
			return true;
			
		}
		
		/*
		 * function login 
		 */
		function login()
		{
			global $db;
			$username = FSInput::get('username');	
			$password = md5(FSInput::get('password'));

			$sql = " SELECT id, username, full_name,block, published 
			FROM fs_members
			WHERE username = '$username'
			AND password = '$password' 
			AND block <> 1
			";
			$db -> query($sql);
			return $db -> getObject();
		}
		function login_2($username,$password)
		{
			global $db;
			$password = md5($password);
			$sql = " SELECT id, username, full_name,block, published 
			FROM fs_members
			WHERE username = '$username'
			AND password = '$password' 
			AND block <> 1
			";
			$db -> query($sql);
			return $db -> getObject();
		}
		/*
		/*
		 * function forget
		 */
		function forget()
		{
			global $db;
			$email = FSInput::get('email');	
			if(!$email)
				return false;
			$sql = " SELECT email, username, id ,full_name
			FROM fs_members
			WHERE email = '$email'
			";
			$db -> query($sql);
			return $db -> getObject();
		}
		
		function resetPass($userid)
		{
			$fstring = FSFactory::getClass('FSString','','../');
			$newpass =  $fstring->generateRandomString(8);
			$newpass_encode = md5($newpass);
			global $db;
			$sql = " UPDATE  fs_members SET 
			password = '$newpass_encode'
			WHERE 
			id = $userid
			";
			// $db->query($sql);
			$rows = $db->affected_rows($sql);
			if(!$rows)
			{
				return false;
			}
			return $newpass;
		}
		
		/* save building */
		function save_changepass()
		{

			global $db;
			$password = FSInput::get("password");
			$re_password = FSInput::get("re-password");
			$verify_old_password = FSInput::get("verify_old_password");

			$user_id = $_COOKIE['user_id'];
			$user = $this-> get_record('id = '.$user_id,'fs_members','*');
			$row = array();
			if($password){
				$password = md5($password);
				$verify_old_password =  md5($verify_old_password);
				if($verify_old_password == $user-> password) {
					// $check_pass = 1;
					$row['password'] = $password;
				} else {
					// $check_pass = 2;
				}
			}

			$save = $this-> _update($row,'fs_members','id = '.$user_id);

			return $save;
			// global $db;
			// $text_pass_new = FSInput::get("text_pass_new");
			// if(!$text_pass_new)
			// 	return false;

			// $username = $_SESSION['username'];

			// $password_old_buid = md5(FSInput::get("text_pass_old"));
			// $password_new_buid = md5(FSInput::get("text_pass_new"));

			// $sql= "UPDATE fs_members SET password='".$password_new_buid."'  WHERE `username`='".$username."' and password='".$password_old_buid."'";

   //          // $db->query($sql);
			// $rows = $db->affected_rows($sql);
			// return $rows;

		}

        /*
         * check duplicate email
         */
        function check_change_pass(){
        	global $db ;

        	$password = FSInput::get("password");
        	$re_password = FSInput::get("re-password");
        	$verify_old_password = FSInput::get("verify_old_password");

        	$user_id = $_COOKIE['user_id'];
        	$user = $this-> get_record('id = '.$user_id,'fs_members','*');

        	if($password){
        		$password = md5($password);
        		$verify_old_password =  md5($verify_old_password);
        		if($verify_old_password == $user-> password) {
        			return true;
        		} else {
        			return false;
        		}
        	}

			// $db->query($sql);
        	// $rs =  $db->getResult($sql);
        	// return $rs;
        }

		/*
		 * check old pass
		 * 
		 */
		function checkOldpass($old_pass)
		{
			global $db ;
			$username = $_SESSION['username'];
			$old_pass = md5($old_pass);
			$sql = " SELECT count(*) 
			FROM fs_members 
			WHERE 
			username = '$username'
			AND password   = '$old_pass'
			";
			$db -> query($sql);
			$count =  $db->getResult();
			if(!$count)
			{
				return false;
			}
			return true;
		}
		/*
		 * check exist email and identify card.
		 */
		function checkExistUsers()
		{
			global $db ;
			$email      =  FSInput::get("email");
			$username      =  FSInput::get("username");
			if(!$email ||  !$username)
			{
				Errors::setError("BÃƒÂ¡Ã‚ÂºÃ‚Â¡n phÃƒÂ¡Ã‚ÂºÃ‚Â£i nhÃƒÂ¡Ã‚ÂºÃ‚Â­p Ãƒâ€žÃ¢â‚¬ËœÃƒÂ¡Ã‚ÂºÃ‚Â§y Ãƒâ€žÃ¢â‚¬ËœÃƒÂ¡Ã‚Â»Ã‚Â§ thÃƒÆ’Ã‚Â´ng tin vÃƒÆ’Ã‚Â o trÃƒâ€ Ã‚Â°ÃƒÂ¡Ã‚Â»Ã¯Â¿Â½ng email vÃƒÆ’Ã‚Â  username");
				return false;
			}
			$sql = " SELECT count(*) 
			FROM fs_members 
			WHERE 
			email = '$email'
			OR username = '$username'
			";
			$db -> query($sql);
			$count = $db->getResult();
			if($count)
			{
				Errors::setError("Email hoặc Username Ãƒâ€žÃ¢â‚¬ËœÃƒÆ’Ã‚Â£ Ãƒâ€žÃ¢â‚¬ËœÃƒâ€ Ã‚Â°ÃƒÂ¡Ã‚Â»Ã‚Â£c sÃƒÂ¡Ã‚Â»Ã‚Â­ dÃƒÂ¡Ã‚Â»Ã‚Â¥ng");
				return false;
			}
			return true;
			
		}
		
		/*
		 * check exist email .
		 */
		function check_exits_email()
		{
			global $db ;
			$email      =  FSInput::get("email");
			if(!$email){
				return false;
			}
			$sql = " SELECT count(*) 
			FROM fs_members 
			WHERE 
			email = '$email'
			";
			$db -> query($sql);
			$count = $db->getResult();
			if($count){
				$this -> alert_error('Email này đã có người sử dụng');
				return false;
			}
			return true;
		}
		/*
		 * check exist username .
		 */
		function check_exits_username()
		{
			global $db ;
			$username      =  FSInput::get("username");
			if(!$username){
				return false;
			}
			$sql = " SELECT count(*) 
			FROM fs_members 
			WHERE 
			username = '$username'
			";
			$db -> query($sql);
			$count = $db->getResult();
			if($count){
				$this -> alert_error('Username này đã có người sử dụng');
				return false;
			}
			return true;
		}
		
		function ajax_check_exits_username()
		{
			global $db ;
			$username      =  FSInput::get("username");
			if(!$username){
				return false;
			}
			$sql = " SELECT count(*) 
			FROM fs_members 
			WHERE 
			username = '$username'
			";
			$db -> query($sql);
			$count = $db->getResult();
			if($count){
				return false;
			}
			return true;
		}
		
		function ajax_check_exits_email()
		{
			global $db ;
			$email  =  FSInput::get("email");
			if(!$email){
				return false;
			}
			$sql = " SELECT count(*) 
			FROM fs_members 
			WHERE 
			username = '$email'
			";
			$db -> query($sql);
			$count = $db->getResult();

			if($count > 0){
				return false;
				
			} else {
				return true;
				
			}
			
		}
		
		/************ LOGGED **************/
		/*
		 * get menu have group = usermenu
		 */
		function getMenusUser()
		{
			global $db ;
			$sql = " SELECT id,link, name, images 
			FROM fs_menus_items
			WHERE published  = 1
			AND group_id = 5 
			ORDER BY ordering";
			// $db->query($sql);
			return $db->getObjectList($sql);
		}
		
		
		/********** DETAIL INFORMATION OF MEMBER **/
		function getMember()
		{
			global $db ;
			$username = @$_COOKIE['username'];
			$google = @$_COOKIE['google'];
			$email =  @$_COOKIE['email'];
			$id = @$_COOKIE['user_id'];
			if($username && 1==2) {
				$sql = " SELECT *
				FROM fs_members
				WHERE username  = '$username' ";
			} else {
				$sql = " SELECT *
				FROM fs_members
				WHERE id  = '$id' ";
			}


			// $db->query($sql);
			return $db->getObject($sql);
		}
		function getProvince($provinceid)
		{
			global $db ;
			$sql = " SELECT name
			FROM fs_cities
			WHERE id   = '$provinceid' ";
			// $db->query($sql);
			return $db->getResult($sql);
		}
		function getDistrict($districtid)
		{
			global $db ;
			$sql = " SELECT name
			FROM fs_districts
			WHERE id   = '$districtid'";
			// $db->query($sql);
			return $db->getResult($sql);
		}
		
		function getUserByUsername($username)
		{
			global $db ;
			
			$sql = " SELECT full_name, id FROM fs_members WHERE username = '$username'";
					// $db->query($sql);
			return $db->getObject($sql);
		}
		function getUserById($userid)
		{
			global $db ;
			
			$sql = " SELECT full_name,id 
			FROM fs_members WHERE id = '$userid'";
					// $db->query($sql);
			return $db->getObject($sql);
		}
		
		/*
		 * Createa folder when create user
		 */
		function create_folder_upload($id){
			$fsFile = FSFactory::getClass('FsFiles','');
			$path = PATH_BASE.'uploaded'.DS.'estores'.DS.$id;
			return $fsFile->create_folder($path);
		}
		
		
		function send_mail_activated_user($name,$username,$password_de,$activated_code,$user_id,$email){
//			include 'libraries/errors.php';
			// send Mail()
			$mailer = FSFactory::getClass('Email','mail');
			$global = new FsGlobal();
			$admin_name = $global -> getConfig('admin_name');
			$admin_email = $global -> getConfig('admin_email');
			$mail_register_subject = $global -> getConfig('mail_register_subject');
			$mail_register_body = $global -> getConfig('mail_register_body');

//			global $config;
			// config to user gmail
			
			$mailer -> isHTML(true);
//			$mailer -> IsSMTP();
			$mailer -> setSender(array($admin_email,$admin_name));
			$mailer -> AddAddress($email,$name);
			$mailer -> AddBCC('phamhuy@finalstyle.com','pham van huy');
			$mailer -> setSubject($mail_register_subject);
			$url_activated = FSRoute::_('index.php?module=users&view=users&task=activate&code='.$activated_code.'&id='.$user_id);
			// body
			$body = $mail_register_body;
			$body = str_replace('{name}', $name, $body);
			$body = str_replace('{username}', $username, $body);
			$body = str_replace('{password}', $password_de, $body);
			$body = str_replace('{url_activated}', $url_activated, $body);
			
//			$body .= '<div>Chào bạn!</div>';
//			$body .= '<br/>';
//			$body .= '<div>Cảm ơn bạn đã đăng ký làm thành viên của <a href="'.URL_ROOT.'">'.URL_ROOT.'</a>';
//			$body .= '<div>Tài khoản của bạn đã được tạo và bạn phải kích hoạt trước khi sử dụng.</div>';
//			$body .= '<div>Để <strong>kích hoạt</strong> bạn hãy click vào link dưới đây:</div>';
			
//			$body .= '<a href="'.$url_activated.'">'.$url_activated.'</a>';
//			$body .= '<br/><br/>';
//			$body .= '<div>Thông tin tài khoản của bạn:</div>';
//			$body .= '<div>Tài khoản: <strong>'.$username.'</strong></div>';
//			$body .= '<div>Mật khẩu: <strong>'.$password_de.'</strong></div>';
//			$body .= '<br/><br/>';
//			$body .= '<div>Chân thành cảm ơn!</div>';
//			$body .= '<div><img src="http://pandabooks.vn/images/logos/logo_panda.jpg" alt="Pandabooks.vn logo"></div>';

			$mailer -> setBody($body);
			
			if(!$mailer ->Send()){
				Errors::_('Có lỗi khi gửi mail');
				return false;
			}
			return true;
			
			//en
		}
	/*
		/*
		 * function forget
		 */
		function activate(){
			global $db;
			$code = FSInput::get('code');	
			$id = FSInput::get('id',0,'int');
			if(!$code || !$id)
				return false;

			$sql = " SELECT username,id,published
			FROM fs_members
			WHERE 
			id = '$id'
			AND activated_code = '$code'
			AND block <> 1
			";
			$db -> query($sql);
			$rs =  $db -> getObject();
			include 'libraries/errors.php';
			if(!$rs){
				Errors::_('Không kích hoạt tài khoản thành công');
				return false;
			}
			if($rs -> published){
				Errors::_('Tài khoản này đã kích hoạt từ trước.');
				return false;
			}
			$time = date("Y-m-d H:i:s");
			$row['published'] = 1;
			$row['published_time'] = $time;
			if(!$this -> _update($row,'fs_members',' id = "'.$id.'" AND activated_code = "'.$code.'" ')){
				Errors::_('Không kích hoạt tài khoản thành công.');
				return false;
			}
			return true;
		}	

		/* ==================================================
		 * ================== ADDRESS BOOK  =================
		==================================================*/
		function get_address_book_by_key(){
			$key = FSInput::get('key');
			if(!$key)
				return;
			$sql = "SELECT id,name,country_name,category_alias,alias
			FROM fs_address_book
			WHERE published = 1
			AND content_search like '%$key%'
			ORDER BY hits DESC,created_time DESC
			LIMIT 60	";	
			global $db ;
			// $db->query($sql);
			return $db->getObjectList($sql);
		} 
		function get_address_book_properties(){
			$sql = "SELECT id,name,type
			FROM fs_address_book_property
			WHERE published = 1
			ORDER BY type ASC ,ordering ASC
			LIMIT 60	";	
			global $db ;
			// $db->query($sql);
			return $db->getObjectList($sql);
		} 
		function get_address_book($user_id){
			global $db ;
			$sql = " SELECT *
			FROM fs_members_addess_book
			WHERE user_id  = '$user_id' ORDER BY is_default DESC ";
			// $db->query($sql);
			return $db->getObjectList($sql);
		}
		function add_address_save()
		{
			global $db;
			$member = $this-> getMember();
			$row['user_id'] = $member-> id;
			$row['full_name'] =   FSInput::get("full_name");
			$row['city_id'] =   FSInput::get("city_id");
			$row['city_name'] = $this-> get_record('id = '.$row['city_id'],'fs_cities','name') -> name;
			$row['district_id'] =   FSInput::get("district_id");
			$row['district_name'] = $this-> get_record('id = '.$row['district_id'],'fs_districts','name') -> name;
			$row['ward_id'] =   FSInput::get("ward_id");
			$row['ward_name'] = $this-> get_record('id = '.$row['ward_id'],'fs_wards','name') -> name;
			$row['address'] =   FSInput::get("address");
			$row['telephone'] =   FSInput::get("telephone");

			$is_default =  FSInput::get("is_default");

			$check = $this-> get_records('user_id = '.$member-> id,'fs_members_addess_book','id');
			if(!empty($check)) {
				$is_default = 1;
			}

			if($is_default==1) {
				$row2 = array();
				$row2['is_default'] = 0;
				$up = $this -> _update($row2, 'fs_members_addess_book','user_id = '.$member-> id);
			}

			$row['is_default'] = $is_default;

			$id = $this -> _add($row, 'fs_members_addess_book');
			return $id;	
		}
		function get_address_book_by_id(){
			global $db ;
			$id =   FSInput::get("id");
			$sql = " SELECT *
			FROM fs_members_addess_book
			WHERE id  = $id ";
			// $db->query($sql);
			return $db->getObject($sql);
		}
		function edit_address_save(){


			global $db;
			$member = $this-> getMember();
			$id =  FSInput::get("id");
			if(!$id) return false;
			// $row['user_id'] = $member-> id;
			$record = $this-> get_record('id='.$id.' AND user_id='.$member-> id, 'fs_members_addess_book');
			if(empty($record )) return false;
			$row['full_name'] =   FSInput::get("full_name");
			$row['city_id'] =   FSInput::get("city_id");
			$row['city_name'] = $this-> get_record('id = '.$row['city_id'],'fs_cities','name') -> name;
			$row['district_id'] =   FSInput::get("district_id");
			$row['district_name'] = $this-> get_record('id = '.$row['district_id'],'fs_districts','name') -> name;
			$row['ward_id'] =   FSInput::get("ward_id");
			$row['ward_name'] = $this-> get_record('id = '.$row['ward_id'],'fs_wards','name') -> name;
			$row['address'] =   FSInput::get("address");
			$row['telephone'] =   FSInput::get("telephone");
			$is_default =  FSInput::get("is_default");

			if($is_default==1) {
				$row2 = array();
				$row2['is_default'] = 0;
				$up = $this -> _update($row2, 'fs_members_addess_book','user_id = '.$member-> id);
			}


			$row['is_default'] = $is_default;

			// echo $id;

			// print_r($row);die;

			if($is_default != 1) {
				$check_default = $this-> get_record('id = '.$id,'fs_members_addess_book','is_default') -> is_default;

			}

			$id = $this -> _update($row, 'fs_members_addess_book' ,'id='.$id);


			if($check_default) {
				$first_address = $this-> get_records('user_id = '.$member-> id,'fs_members_addess_book','*','id ASC', '1');

				$row3 = array();
				$row3['is_default'] = 1;
				$up3 = $this -> _update($row3, 'fs_members_addess_book' ,'id='.$first_address[0]-> id);
			}



			return $id;	
		}


		function remove_address(){
			global $db;
			$member = $this-> getMember();
			$id =  FSInput::get("id");
			if(!$id) return false;
			$record = $this-> get_record('id='.$id.' AND user_id='.$member-> id, 'fs_members_addess_book');
			if(empty($record )) return false;
			$id = $this-> _remove('id = '.$id,'fs_members_addess_book');
		}
		function getCity()
		{
			global $db ;
			$sql = " SELECT id, name FROM fs_cities ";
			//$db->query($sql);
			return $db->getObjectList($sql);
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

		function history_point($user_id){
			if(!$user_id)
				return;
			global $db ;
			$sql = " SELECT * FROM fs_history_point_members
			WHERE user_id = $user_id ORDER BY id DESC";
			//$db->query($sql);
			return $db->getObjectList($sql);
		}

		function list_orders($user_id){
			if(!$user_id)
				return;
			global $db ;
			$sql = " SELECT * FROM fs_order
			WHERE user_id = $user_id ORDER BY id DESC";
			//$db->query($sql);
			return $db->getObjectList($sql);
		}

		function list_orders_affi($user_id){
			if(!$user_id)
				return;
			global $db ;
			$where_affi = ' AND YEAR(created_time) = '.date("Y");
			$sql = " SELECT * FROM fs_order
			WHERE affiliate_id = $user_id".$where_affi." ORDER BY created_time DESC";
			//$db->query($sql);
			return $db->getObjectList($sql);
		}

		function list_wishlist($user_id){
			if(!$user_id)
				return;
			global $db ;
			$sql = " SELECT * FROM fs_members_wishlist
			WHERE user_id = $user_id ORDER BY id DESC";
			//$db->query($sql);
			return $db->getObjectList($sql);
		}

		function list_detail($order_id){
			if(!$order_id)
				return;
			global $db ;
			$sql = " SELECT * FROM fs_order_items
			WHERE order_id = $order_id ORDER BY id ASC";
			//$db->query($sql);
			return $db->getObjectList($sql);
		}

		function get_list_products(){
			global $db ;
			$limit = 10;
			$name =  FSInput::get("name");		
			$cid =  FSInput::get("cid");
			$page =  FSInput::get("page");
			$where = '';
			if($name) {
				$where .= ' AND name LIKE "%'.$name.'%"';
			}	
			if($cid) {
				$where .= ' AND category_id_wrapper LIKE "%'.$cid.'%"';
			}
			if(!$page) {
				$page = 1;
			}

			$qlimit = ' LIMIT '.($page - 1)*$limit.','.$limit;

			$sql = " SELECT id,name,alias,category_id,category_alias,image, price, price_old FROM fs_products
			WHERE published = 1". $where.' ORDER BY ordering DESC, id DESC'.$qlimit;

			return $db->getObjectList($sql);

		}

		function get_total_products(){
			global $db ;
			$limit = 10;
			$name =  FSInput::get("name");		
			$cid =  FSInput::get("cid");
			// $page =  FSInput::get("page");
			$where = '';
			if($name) {
				$where .= ' AND name LIKE "%'.$name.'%"';
			}	
			if($cid) {
				$where .= ' AND category_id_wrapper LIKE "%'.$cid.'%"';
			}

			// $qlimit = ' LIMIT '.($page - 1)*$limit.','.$limit;

			$sql = " SELECT count(id) as count FROM fs_products
			WHERE published = 1". $where.' ORDER BY ordering DESC, id DESC';

			return $db->getObject($sql);

		}


		function check_sale_off($product_id){
			$today_time = date('Y-m-d H:i:s');
			$fs_table = FSFactory::getClass ( 'fstable' );
			$query = " SELECT id,name, finished_time
			FROM " . $fs_table->getTable ( 'fs_sales' ) . "
			WHERE published = 1 AND started_time < '".$today_time ."' AND finished_time > '".$today_time."' AND type = 1 ORDER BY ordering ASC";
			global $db;
			$sql = $db->query ( $query );
			$sale = $db->getObject ();
			if($sale) {
				$query2 = " SELECT s.price
				FROM " . $fs_table->getTable ( 'fs_sales_products' ) . " as s INNER JOIN ".$fs_table->getTable ( 'fs_products' ) ." as p ON s.product_id = p.id
				WHERE published = 1 AND sale_id = ".$sale-> id." AND p.id = $product_id
				";
				$sql2 = $db->query ( $query2 );
				$result = $db->getObject ();
				if($result) {
					return $result;	
				} else {
					return 0;
				}
			}
			else {
				return 0;
			}
		}

		

		

	}
	
	?>