<?php
class UsersModelsFace extends FSModels{
  function __construct(){
    parent::__construct();
    $this->table_name = 'fs_members';
    $this -> arr_img_paths = array(array('resized',300,300,'cut_image'));
    $this -> img_folder = 'images/members/';
  }
  function checkExitsEmail($email)
  {
    global $db;

    if (!$email)
    {
      return false;
    }
    $sql = 'SELECT *
    FROM '.$this->table_name.' 
    WHERE email = \''.$email.'\'';
    $db->query($sql);
    return $db->getObject();
  }
  function checkExitsUser($user)
  {

    global $db;
    if (!$user)
    {
      return false;
    }
    $where = '';
    if(isset($user['email']) && @$user['email']){
     $where .= 'username = \''.@$user['email'].'\'';
   }else{
     if(!@$user['id'])
      return false;
    $where .= 'fb_id = "'.$user['id'].'" ';
  }
  $sql = 'SELECT *
  FROM '.$this->table_name.' 
  WHERE '.$where.' ';
  $db->query($sql);
  return $db->getObject();
}
function save($user)
{
  global $db, $config;
        //$file = $this->upload_avatar();
  $row = array();

  $yearnow = date('Y'); 
  $expired_level = ($yearnow+1).'-12-31 23:59:59';
  $row['expired_level'] = $expired_level;
  $row['update_level_date'] =date("Y-m-d H:i:s");
  
  $row['email'] = @$user['email'];
  $row['username'] = @$user['email'];
//        $row['password'] = md5(FSInput::get("rpassword"));
//        if (!$row['email'] && !FSInput::get("rpassword"))
//            return;
//        $row['full_name'] = $user->last_name.' '.$user->first_name;
  $row['full_name'] = $user['name'];
  $row['sex'] = $user['gender'];
  $row['fb_id'] = $user['id'];
  $row['link'] = $user['link'];
  $row['published'] = 1;
  $row['access_token'] = @$user -> access_token;

//        $image = $this -> save_image_from_fb($user);
//        if($image){
//        	$row['image'] = $image;
//        }
  $row['created_time'] = date("Y-m-d H:i:s");
//        $row['learn_last_time'] = date("Y-m-d H:i:s");
  $row['is_online'] = 1;
  $row['last_time'] = date("Y-m-d H:i:s");

  if($config['check_donate_points']) {
    $row['point']  = $config['donate_points'];
  }
  $level_default = $this->  get_record('published = 1 AND is_default = 1','fs_members_level', '*');
  $row['level'] = $level_default-> id;
  $row['level_name'] = $level_default-> name;
        // echo 'dfdfdf';
        // print_r($row);die;
  $id = $this->_add($row, $this->table_name);
  $fstring = FSFactory::getClass('FSString','','../');
  if($id) {
    $row2 = array();
    $row2['affiliate_code'] = $fstring->generateRandomString(8).$id;
    $this-> _update($row2, 'fs_members', 'id='.$id);
  }

  if($config['check_donate_points'] && $config['donate_points']) {
    $row3 = array();
    $row3['user_id'] = $id;
    $row3['value'] = $config['donate_points'];
    $row3['note'] = 'Tặng điểm cho thành viên đăng ký mới.';
    $row3['created_time']  = $time;
    $row3['type'] = 'register';
    $id3 = $this -> _add($row3, 'fs_history_point_members');
  }

  return $id;
}

function save_image_from_fb($user){
  $link_image_remote = 'https://graph.facebook.com/'. $user->id .'/picture?type=large';
  FSFactory::include_class('remote');
  $this -> arr_img_paths = array(array('resized',300,300,'cut_image'));
  $folder = $this -> img_folder;
  $cyear = date('Y');
  $cmonth = date('m');
  $cday = date('d');

  $folder_original = $folder.$cyear.'/'.$cmonth.'/'.$cday.'/'.'original'.'/';
  $filename = $user ->id.'_'.time().'.jpg';
  $image_full = FSRemote::save_image_not_extend($link_image_remote,$filename,$get_type = 1,$folder_original,0);
  $path_original_full = PATH_BASE.str_replace('/', DS,$image_full);

  $arr_img_paths = $this -> arr_img_paths;
  $fsFile = FSFactory::getClass('FsFiles');

  foreach($arr_img_paths as $item){
   $path_resize_full = str_replace(DS.'original'.DS, DS.$item[0].DS, $path_original_full);
   $path_resize_sort = str_replace('/'.$filename, '', $path_resize_full);
   $fsFile -> create_folder($path_resize_sort);
   $method_resize = $item[3]?$item[3]:'cut_image';
   if(!$fsFile ->$method_resize($path_original_full, $path_resize_full,$item[1], $item[2])){

   }
 }
 return $image_full;	
}

	/*
	 * Ghi lại lần đăng nhập vào hệ thống
	 */
	function upload_last_time($user_id){
		if(!$user_id)
			return;
		$time = date("Y-m-d H:i:s");
		$row = array();
		$row['last_time'] = $time;
//		$row['learn_last_time'] = $time;
		$row['is_online'] = 1;
//		if(!$days){
//			return $this -> _update($row, 'fs_members','id = '.$user_id);
//		}
		
//		$today = date('Y-m-d');
//		if($learn_last_time){
//			$learn_last_time = new DateTime($learn_last_time); 
//			$today = new DateTime($today); 
//			$diff=date_diff($learn_last_time,$today)->format("%a");
//			$diff = intval($diff);
//			$row['days'] = $days >=  $diff ? ($days - $diff):0;	
//		}
		$this -> _update($row, 'fs_members','id = '.$user_id);
	}


//    function edit()
//    {
//        global $db;
//        
//        $file = $this->upload_avatar();
//        
//        $row = array();
//        $row['full_name'] = FSInput::get("full_name");
//        $row['avatar'] = $file;
//        //$row['lastname'] = FSInput::get("lastname");        
//        $row['sex'] = FSInput::get("sex");
//		$row['show_sex'] = FSInput::get("show_sex");
//		$row['days'] = FSInput::get("days");
//		$row['month'] = FSInput::get("month");
//		$row['year'] = FSInput::get("year");
//		$row['birthday'] = $row['days'].'/'.$row['month'].'/'.$row['year'];
//		$row['show_birthday'] = FSInput::get("show_birthday");
//		$row['city_id'] = FSInput::get("city_id");		
//		$row['show_city'] = FSInput::get("show_city");		 
//        $row['mobile'] = FSInput::get("mobile");
//		
//		$row['contactname'] = FSInput::get("contactname");
//		$row['contactaddress'] = FSInput::get("contactaddress");
//		$row['contactphone'] = FSInput::get("contactphone");
//		$row['contactemail'] = FSInput::get("contactemail");
//		$row['is_newsletter'] = FSInput::get("is_newsletter");		
//        $row['published'] = 1;
//        $fstring = FSFactory::getClass('FSString', '', '../');
//        $id = $this->_update($row, $this->table_name, 'id='.$_COOKIE['user_id']);
//        return $id;
//    }
//    
//    function checkExitsUsername()
//    {
//        global $db;
//        if(isset($_COOKIE['user_id'])) /* Sửa thông tin */
//            return true;
//        $email = FSInput::get("email");
//        if (!$email)
//        {
//            return false;
//        }
//        $sql = 'SELECT count(id) 
//    			FROM  '.$this->table_name.'
//                WHERE email = \''.$email.'\'';
//        $db->query($sql);
//        $count = $db->getResult();
//        if ($count)
//        {
//            $this->alert_error('Tên đăng nhập này đã có người sử dụng');
//            return false;
//        }
//        return true;
//    }
//    
//   
//    
//    function getListCities(){
//        global $db;
//        $query = '  SELECT id, name
//                    FROM fs_local_cities 
//                    WHERE published = 1
//                    ORDER BY ordering';
//		$sql = $db->query($query);
//		$result = $db->getObjectList();
//		return $result;
//    }
//    
//    function getListDistricts($city_id = 1){
//        global $db;
//        $query = '  SELECT id, name
//                    FROM fs_local_districts 
//                    WHERE published = 1 AND city_id = '.$city_id.'
//                    ORDER BY ordering';
//		$sql = $db->query($query);
//		$result = $db->getObjectList();
//		return $result;
//    }
//    function login()
//    {
//        global $db;
//        $email = FSInput::get('lemail');
//        $password = md5(FSInput::get('lpassword'));
//        $sql = "SELECT *
//    			FROM fs_members
//    			WHERE email = '$email' AND password = '$password'";
//        $db->query($sql);
//        return $db->getObject();
//    }
//    
//    function getUserInfo(){
//        global $db;
//        if(!isset($_SESSION['email']))
//            return false;
//        $sql = 'SELECT m.*,
//                    (SELECT name FROM fs_local_cities AS c WHERE c.id = m.city_id LIMIT 1) AS city 
//    			FROM fs_members AS m
//    			WHERE email = \''.$_SESSION['email'].'\'';
//        $db->query($sql);
//        return $db->getObject();
//    }
//    
//    function getJobsave($userid){
//        global $db;
//        if(!isset($userid))
//            return false;
//        $query = 'SELECT count(id) AS countjob,user_id
//    			FROM fs_products_favorite
//    			WHERE user_id = \''.$userid.'\'';
//        $sql = $db->query($query);
//		$result = $db->getObject();
//		return $result;
//    }
//    
//    function checkPass(){
//        global $db;
//        if(!isset($_COOKIE['user_id'])) /* Sửa thông tin */
//            return false;
//        $password = FSInput::get("password");
//        if (!$password)
//        {
//            return false;
//        }
//        $sql = 'SELECT count(id) 
//    			FROM  '.$this->table_name.'
//                WHERE password = \''.md5($password).'\' AND id = '.$_COOKIE['user_id'];
//        $db->query($sql);
//        $count = $db->getResult();
//        if ($count)
//        {
//            return true;
//        }
//        $this->alert_error('Mật khẩu hiện tại không đúng');
//        return false;
//    }
//    
//    function changepass(){
//        global $db;
//        $row = array();
//        $row['password'] = md5(FSInput::get("new_password"));
//        $id = $this->_update($row, $this->table_name, 'id='.$_COOKIE['user_id']);
//        return $id;
//    }
//    
//    function getListOrder(){
//        global $db;
//        if(!isset($_COOKIE['user_id']))
//            return false;
//        $query = '  SELECT *
//                    FROM fs_order 
//                    WHERE status = 1 AND user_id = '.$_COOKIE['user_id'].'
//                    ORDER BY id DESC';
//		$sql = $db->query($query);
//		$result = $db->getObjectList();
//		return $result;
//    }
//    
//    function getOrder($id){
//        global $db;
//        $query = '  SELECT *
//                    FROM fs_order 
//                    WHERE id = '.$id.'
//                    ORDER BY id DESC
//                    LIMIT 1';
//		$sql = $db->query($query);
//		$result = $db->getObject();
//		return $result;
//    }
//    
//    function getProductsOrder($id){
//        global $db;
//        $query = '  SELECT name, alias, category_alias, image, o.*
//                    FROM fs_products AS p
//                        INNER JOIN fs_order_items AS o ON o.product_id = p.id
//                    WHERE order_id = '.$id;
//		$sql = $db->query($query);
//		$result = $db->getObjectList();
//		return $result;
//    }
//    
//    function getProductsFavorite(){
//        global $db;
//        if(!isset($_COOKIE['user_id']))
//            return false;
//        $query = '  SELECT *
//                    FROM fs_products
//                        INNER JOIN fs_products_favorite ON fs_products.id = fs_products_favorite.product_id
//                    WHERE fs_products.published = 1 AND user_id = '.$_COOKIE['user_id'].'
//                    ORDER BY fs_products_favorite.created_time DESC';
//		$sql = $db->query($query);
//        return $db->getObjectList();
//    }
//    // Lay thong tin nha tuyen dung
//    function getRecruiters($recruiters_id = 0){
//        global $db;
//        $query = '  SELECT *
//                    FROM fs_products_recruiters 
//                    WHERE id = '.$recruiters_id.'
//                    LIMIT 1';
//		$sql = $db->query($query);
//		$result = $db->getObject();
//		return $result;
//	}
//    
//    // Lay noi lam viec
//    function getCity($city_id = 0){
//        global $db;
//        $query = '  SELECT *
//                    FROM fs_local_cities 
//                    WHERE id = '.$city_id.'
//                    LIMIT 1';
//		$sql = $db->query($query);
//		$result = $db->getObject();
//		return $result;
//	}
//    
//    // Lấy thông tin user. Tham số truyền vào là email
//    function getUserforgotpassword($email){
//        global $db;          
//        $query = '  SELECT *
//                    FROM fs_members 
//                    WHERE email = "'.$email.'" LIMIT 1';
//		$sql = $db->query($query);
//		$result = $db->getObject();
//		return $result;
//	}
//    
//    // thay đổi password
//    function changepassforgot($id,$password){
//        global $db;
//        $row = array();
//        $row['password'] = md5($password);
//        $id = $this->_update($row, $this->table_name, 'id='.$id);
//        return $id;
//    }
//    

}