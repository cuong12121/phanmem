<?php
class UsersModelsGoogle extends FSModels{
    function __construct()
    {   
        parent::__construct();
        $this->table_name = 'fs_members';
        $this -> arr_img_paths = array(array('resized',300,300,'cut_image'));
        $this -> img_folder = 'images/members/';
    }
//    function check_exits_email($email)
//    {
//        global $db;
//
//        if (!$email)
//        {
//            return false;
//        }
//        $sql = 'SELECT *
//              FROM '.$this->table_name.' 
//              WHERE email = \''.$email.'\'';
//        $db->query($sql);
//      return $db->getObject();
//    }
    function save($user)
    {
        global $db;
        //$file = $this->upload_avatar();
        $row = array();
        $row['email'] = $user->email;
//        $row['password'] = md5(FSInput::get("rpassword"));
//        if (!$row['email'] && !FSInput::get("rpassword"))
//            return;
        $row['full_name'] = $user->last_name.' '.$user->first_name;
        $row['sex'] = $user->gender;
        $row['published'] = 1;
//        $image = $this -> save_image_from_gg($user);
//        if($image){
//          $row['image'] = $image;
//        }
        $row['type'] = 2;// google
        $row['created_time'] = date("Y-m-d H:i:s");
        $id = $this->_add($row, $this->table_name);
        return $id;
    }
    
    function get_link_avatar_from_user($user_id){
        $data = file_get_contents('http://picasaweb.google.com/data/entry/api/user/'.$user_id.'?alt=json');
        $d = json_decode($data);
        $avatar = $d->{'entry'}->{'gphoto$thumbnail'}->{'$t'};
        if(!$avatar)
            return;
        $avatar = str_replace('s64-c', 's300-c', $avatar)   ;
        
        return $avatar;
    }
    
    function save_image_from_gg($user){
        $avatar = $this-> get_link_avatar_from_user($user['fb_id']);
        if(!$avatar)
            return;
//      $link_image_remote = 'https://graph.facebook.com/'. $user->id .'/picture?type=large';
        $link_image_remote = $avatar;
        FSFactory::include_class('remote');
        $this -> arr_img_paths = array(array('resized',300,300,'cut_image'));
        $folder = $this -> img_folder;
        $cyear = date('Y');
        $cmonth = date('m');
        $cday = date('d');
        
        $folder_original = $folder.$cyear.'/'.$cmonth.'/'.$cday.'/'.'original'.'/';
        $filename = $user ->id.'_'.time().'.jpg';
//      $image_full = FSRemote::save_image_not_extend($link_image_remote,$filename,$get_type = 1,$folder_original,0);
        $image_full = FSRemote::save_image_special($link_image_remote, 1,$folder_original);
        $path_original_full = PATH_BASE.str_replace('/', DS,$image_full);
        
        $arr_img_paths = $this -> arr_img_paths;
        $fsFile = FSFactory::getClass('FsFiles');
        
        foreach($arr_img_paths as $item){
            $path_resize_full = str_replace(DS.'original'.DS, DS.$item[0].DS, $path_original_full);
            $path_resize_sort = str_replace('/'.$filename, '', $path_resize_full);
//          $fsFile -> create_folder($path_resize_sort);
//          $method_resize = $item[3]?$item[3]:'cut_image';
//          if(!$fsFile ->$method_resize($path_original_full, $path_resize_full,$item[1], $item[2])){
//              
//          }
            if(!$fsFile ->copy_file($path_original_full, $path_resize_full)){
            }
        }
        return $image_full; 
    }
        
    
    function edit()
    {
        global $db;
        
        $file = $this->upload_avatar();
        
        $row = array();
        $row['full_name'] = FSInput::get("full_name");
        $row['avatar'] = $file;
        //$row['lastname'] = FSInput::get("lastname");        
        $row['sex'] = FSInput::get("sex");
        $row['show_sex'] = FSInput::get("show_sex");
        $row['days'] = FSInput::get("days");
        $row['month'] = FSInput::get("month");
        $row['year'] = FSInput::get("year");
        $row['birthday'] = $row['days'].'/'.$row['month'].'/'.$row['year'];
        $row['show_birthday'] = FSInput::get("show_birthday");
        $row['city_id'] = FSInput::get("city_id");      
        $row['show_city'] = FSInput::get("show_city");       
        $row['mobile'] = FSInput::get("mobile");
        
        $row['contactname'] = FSInput::get("contactname");
        $row['contactaddress'] = FSInput::get("contactaddress");
        $row['contactphone'] = FSInput::get("contactphone");
        $row['contactemail'] = FSInput::get("contactemail");
        $row['is_newsletter'] = FSInput::get("is_newsletter");      
        $row['published'] = 1;
        $fstring = FSFactory::getClass('FSString', '', '../');
        $id = $this->_update($row, $this->table_name, 'id='.$_COOKIE['user_id']);
        return $id;
    }
    
    function checkExitsUsername()
    {
        global $db;
        if(isset($_COOKIE['user_id'])) /* Sửa thông tin */
            return true;
        $email = FSInput::get("email");
        if (!$email)
        {
            return false;
        }
        $sql = 'SELECT count(id) 
                FROM  '.$this->table_name.'
                WHERE username = \''.$email.'\'';
        $db->query($sql);
        $count = $db->getResult();
        if ($count)
        {
            $this->alert_error('Tên đăng nhập này đã có người dùng');
            return false;
        }
        return true;
    }
    function check_exits_email($email)
    {
        if(!$email)
            return;
        global $db;
        $sql = 'SELECT *
                FROM  '.$this->table_name.'
                WHERE username = \''.$email.'\'';
        $db->query($sql);
        $count = $db->getObject();
        return $count;
    }
    
/**
    * Đăng nhập
    * @param string $uname
    * @param string $password
    * @param bool $loadUser
    * @return bool
    */
    function loginMailOnly($email, $remember = false, $loadUser = true){
        global $db;
        $email    = get_magic_quotes_gpc()?stripslashes($email):$email;
         $sql = 'SELECT *
                FROM  '.$this->table_name.'
                WHERE email = \''.$email.'\' AND block <> 1 ';
        $db->query($sql);
        $user = $db -> getObject();
        if(!$user)
            return;
        $time =time()+60*60*24*30;                   
        setcookie('full_name', $user->full_name ,$time,'/');
        setcookie('email', $user->username ,$time,'/');
        setcookie('user_id', $user->id ,$time,'/');

//        $_SESSION['full_name'] = $user->full_name ;
        if($user->username ){           
            // setcookie('user_id', $user->username ,$time,'/');
        }
        
        
        return true;
    }
   
    
    /**
    * Thêm tài khoản: 'database field' => 'value'
    * @param array $data
    * @return int
    */ 
    function insertUser($data){
        global $db;
        if (!is_array($data)) $this->error('Data is not an array', __LINE__);
     //    switch(strtolower($this->passMethod)){
     //        case 'sha1':
     //            $password = "SHA1('".$data['password']."')"; break;
     //        case 'md5' :
     //            $password = "MD5('".$data['password']."')";break;
     //        case 'nothing':
     //            $password = $data[$this->tbFields['pass']];
        // }
     //    $data['password'] = $password;
        $time = date("Y-m-d H:i:s");
        $data['last_time'] = $time;
//      $data['learn_last_time'] = $time;
        $data['is_online'] = 1;
//          $image = $this -> save_image_from_gg($data);
//        if($image){
//          $data['image'] = $image;
//        }
    
        $id = $this -> _add($data,$this->table_name,1);
        return $id;
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
//      $row['learn_last_time'] = $time;
        $row['is_online'] = 1;
        // if(!$days){
        //  return $this -> _update($row, 'fs_members','id = '.$user_id);
        // }
        
//      $today = date('Y-m-d');
//      if($learn_last_time){
//          $learn_last_time = new DateTime($learn_last_time); 
//          $today = new DateTime($today); 
//          $diff=date_diff($learn_last_time,$today)->format("%a");
//          $diff = intval($diff);
//          $row['days'] = $days >=  $diff ? ($days - $diff):0; 
//      }
//      $this -> _update($row, 'fs_members','id = '.$user_id);
    }
    
    
    /**
    * Thêm tài khoản: 'database field' => 'value'
    * @param array $data
    * @return int
    */ 
    function updateUser($data, $user_id = 0){
        global $db;
        $row = array();
//        $row[''] = 
        $strUpdate = "published = '1'";
        foreach ($data as $k => $v )
            $strUpdate .= ",".$k."='".$this->escape($v)."'";
        if($this->userID)
            $user_id = $this->userID;
        $db->query("UPDATE `".$this->tbStore.'` SET '.$strUpdate.' WHERE id = \''.$user_id.'\'');
        $id = $db->affected_rows();
        return $id;
    }
}
?>