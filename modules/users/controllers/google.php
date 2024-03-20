<?php
/**
 * @author ndson
 * @category controller
 */
class UsersControllersGoogle extends FSControllers{
    function __construct(){
        $model = $this -> model;
        parent::__construct();
    }
    
    function google_login(){ 
        echo '11111';
        global $config;
        $model = $this -> model;
        $strHTML = '';
        // require(PATH_BASE.'libraries'.DS.'google'.DS.'gconfig.php');
        require(PATH_BASE.'libraries'.DS.'google'.DS.'gconfig.php');
        // $redirect_uri = URL_ROOT.'oauth2callback';
        // $client = new Google_Client();
        // // echo $client_id;
        // $client->setClientId($client_id);
        // $client->setClientSecret($client_secret);
        // $client->setRedirectUri($redirect_uri);
        // $client->setScopes('email');
        $fstring = FSFactory::getClass('FSString','','../');
        if (isset($_GET['code'])) {
            // $client->authenticate($_GET['code']);
            // $_SESSION['access_token']  = $client->getAccessToken();          
            // $access_token = json_decode($_SESSION['access_token']);
            // //$client->refreshToken($access_token->refresh_token);
            // $token_url = 'https://www.googleapis.com/oauth2/v1/userinfo?alt=json&access_token='.$access_token->access_token;
            // $token_data = file_get_contents($token_url);
            // $guser = json_decode($token_data);
            // echo "<pre>";
            // print_r($guser);
            // die();
            $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
              //Create Object of Google Service OAuth 2 class
            $google_service = new Google_Service_Oauth2($google_client);

  //Get user profile data from google
            $guser = $google_service->userinfo->get();

            // print_r( $guser);
            // echo 'xxx';


            if (!empty($guser)){  
            // echo '<pre>';
            // print_r($guser);die;            
                $data = $model->check_exits_email($guser['email']);
                if ($data){
                    if(!$data -> published || $data -> block ){
                        $link = URL_ROOT;
                        $msg = "Your account is locked or not activated";
                        setRedirect($link, $msg);
                        return;
                    }

                // $model->loginMailOnly($guser->email);
                    $model -> upload_last_time($data -> id);

                    $time =time()+60*60*24*30;        
                    setcookie('google',1,$time,'/');
                    setcookie('full_name',$data->full_name,$time,'/');
                    setcookie('email',$data->email,$time,'/');
                // setcookie('username',$data->email,$time,'/');
                    setcookie('user_id',$data->id,$time,'/');


                    if($data -> username){                          
                        setcookie('username',$data->username,$time,'/');
                    }   

                    $return['error']    = true;

                    if(isset($_SESSION['social_redirect']) && $_SESSION['social_redirect']){
                        $link = base64_decode($_SESSION['social_redirect']);
                        unset($_SESSION['social_redirect']);
                    }else{
                        $link = URL_ROOT;                               
                    }

                    $return['url']      =  $link;                           
                    $return['msg']      =  "Successful login";
                    $strHTML  = '<script type="text/javascript">';
                    $strHTML .= '   window.opener.location.reload(true); ';
                    // $strHTML .= '    window.opener.login_facebook('.json_encode($return).');';
                    $strHTML .= '   alert("'.$return['msg'].'");';
                    $strHTML .= '   window.close();';
                    $strHTML .= '</script>';
                }else{

                // print_r($guser);die;
                    $yearnow = date('Y');   
                    $expired_level = ($yearnow+1).'-12-31 23:59:59';
                    $row['expired_level'] = $expired_level;
                    $row['update_level_date'] =date("Y-m-d H:i:s");
                    $row['full_name'] = $guser['given_name'].' '.$guser['family_name'];
                    $row['email'] = $guser->email;
                    $row['username'] = $guser->email;
                    $row['sex'] = $guser['gender'];
                    $row['image'] = $guser['picture'];
                    // $row['password'] = '123456';
                    $row['type'] = '2';
                    // $row['gg_id'] = $guser->id;
                    $row['published'] =  1;
                    $row['created_time'] = date("Y-m-d H:i:s");
                    $level_default = $model->  get_record('published = 1 AND is_default = 1','fs_members_level', '*');
                    $row['level'] = $level_default-> id;
                    $row['level_name'] = $level_default-> name;
                    // if($config['check_donate_points']) {
                    //     $row['point']  = $config['donate_points'];
                    // }
                    $id = $model-> _add($row,'fs_members', 1);
                    if($id){
                        $row2 = array();
                        $row2['affiliate_code'] = $fstring->generateRandomString(8).$id;
                        $model-> _update($row2, 'fs_members', 'id='.$id);

                        // if($config['check_donate_points'] && $config['donate_points']) {
                        //     $row3 = array();
                        //     $row3['user_id'] = $id;
                        //     $row3['value'] = $config['donate_points'];
                        //     $row3['note'] = 'Tặng điểm cho thành viên đăng ký mới.';
                        //     $row3['created_time']  =date("Y-m-d H:i:s");
                        //     $row3['type'] = 'register';
                        //     $model -> _add($row3, 'fs_history_point_members');
                        // }

                    // $model->_update(array('code' => 'CVN'.str_pad($id, 6, "0", STR_PAD_LEFT) ,'published' => 1),'fs_members',' id = '.$id.' ');

                        $time =time()+60*60*24*30;        
                        setcookie('google',1,$time,'/');
                        setcookie('full_name',$row['full_name'],$time,'/');
                        setcookie('email',$row['email'],$time,'/');
                        setcookie('username',$row['email'],$time,'/');
                    // echo 'manh';
                    // echo $id;die;
                        setcookie('user_id',$id,$time,'/');

                    // $model->loginMailOnly($guser->email);
                        $return['error']    = true;
                        $return['url']      =  URL_ROOT;
                        $return['msg']      =  "Save Successful Members";
                        $strHTML  = '<script type="text/javascript">';
                        // $strHTML .= '    window.opener.login_facebook('.json_encode($return).');';
                        $strHTML .= '   window.opener.location.reload(true); ';
                        $strHTML .= '   alert("'.$return['msg'].'");';
                        $strHTML .= '   window.close();';
                        $strHTML .= '</script>';
                    }//end: if($id)
                }//end: if ($data)
            }else{
             echo "kk";
             unset($_SESSION['access_token']);
            }//end: if (!empty($guser))
        }//end: if (isset($_GET['code']))
        // if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
        //     /* $client->setAccessToken($_SESSION['access_token']);
        //     unset($_SESSION['access_token']);
        //     $this->google_login(); */
        //     unset($_SESSION['access_token']);
        // } else {
        //     $authUrl = $client->createAuthUrl();
        //     $strHTML  = '<script type="text/javascript">';
        //     $strHTML .= '   top.location.href="'.$authUrl.'"';
        //     $strHTML .= '</script>';
        // }
        echo $strHTML;
    }
    
} 
?>