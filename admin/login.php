<?php 

function login(){

  global $db;
  $redirecttttt = FSInput::get('redirect');
  $url = base64_decode($redirecttttt);
    //echo $url;
  //  die();
  $password = FSInput::get('password');
  $username = FSInput::get('username');
  if(!$password || !$username)
    return;
  $password = fSencode(md5(md5($password)));
  $password = hash('sha256', $password);


  $db->query('SELECT u.id, u.username, u.email,u.published,u.full_name,u.group_id
    FROM fs_users AS u
    WHERE u.username = \''.$username.'\' AND u.password = \''.$password.'\'
    LIMIT 1');
  $user = $db->getObject();

  if(!$user){
    return false;
  }
  
  if(isset($_SESSION['ad_username'])){
      
      unset($_SESSION['ad_userid']);
      unset($_SESSION['ad_fullname']);
      unset($_SESSION['ad_groupid']);
      unset($_SESSION['ad_username']);
      unset($_SESSION['ad_useremail']);
   
      
  }

  // printr($user);

  $_SESSION['ad_logged']     = 1;

  $_SESSION['ad_userid']     = $user-> id;
  $_SESSION['ad_fullname']     = $user-> full_name;
  $_SESSION['ad_groupid']    = $user-> group_id;

  $_SESSION['ad_username']   = $user->username;
  $_SESSION['ad_useremail']  = $user->email;

  return true;
}

require_once("../includes/config.php");
require_once ("includes/defines.php");
require_once ("../includes/functions.php");
//require_once('../libraries/database/mysql.php');
require_once ('../libraries/database/pdo.php');
global $db;
$db = new FS_PDO();
require_once("../libraries/fsinput.php");
$action     = FSInput::get('action');
$redirecttttt = FSInput::get('redirect');
$url = base64_decode($redirecttttt);
session_start();
if(isset($_SESSION['ad_logged']) && $_SESSION['ad_logged']==1){
  if($url != '' && $url != '/'.LINK_AMIN.'/index.php?module=users&view=log&task=display') {
   header( "Location: ".$url );
 }
 else {
  header( "Location: ".URL_ADMIN );
}

}



  if($action == "login"){
  	if(!login()){
      echo '<script type="text/javascript">alert(\'Tên đăng nhập hoặc mật khẩu không đúng!\')</script>';
    }else{
      // if($_SESSION['ad_userid'] == 9){
      
      //   header( "Location: index.php" );
      // }
      global $db;
      $db->query('SELECT u.id, u.username, u.email,u.published
      FROM fs_users AS u
      WHERE u.id = \''.$_SESSION['ad_userid'].'\' AND u.published = 1
      LIMIT 1');
      $user = $db->getObject();

      if(!$user){
        echo '<script type="text/javascript">alert(\'Tài khoản đang chưa được kích hoạt!\')</script>';
        
      }elseif($url!= '' && $url != '/'.LINK_AMIN.'/index.php?module=users&view=log&task=display') {
        header( "Location: ".$url );
      }else {
        header( "Location:".URL_ADMIN );
      } 
    }
  }
?>


<!DOCTYPE html>
<html lang="vi">

<head>

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
	<title>Quản trị Admin</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="copyright" content="© Thiết kế website Delectech" /> 
  <meta name="robots" content="noindex, nofollow"/>

  <!-- Bootstrap Core CSS -->
  <link href="templates/default/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- MetisMenu CSS -->
  <link href="templates/default/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="templates/default/dist/css/sb-admin-2.css" rel="stylesheet">

  <!-- Custom Fonts -->
  <link href="templates/default/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
      <script type="text/javascript" src="templates/default/js/jquery-1.11.0.min.js"></script>
      <script type="text/javascript" src="templates/default/js/helper.js"></script>
      <script type="text/javascript">
        $(document).ready(function() {
          $('#usermane').focus();
          init_position_box($('#login-from'));
          $(window).resize(function () {	 
            init_position_box($('#login-from'));
          });
        });
      </script>
    </head>
    
    <body>
      <div class="container">
        <div class="row text-center ">
            <div class="col-md-12">
                <br /><br />

            </div>
        </div>
         <div class="row text-center ">
            <div class="col-md-12">
                <br /><br />

            </div>
        </div>
       
         <div class="row ">
               
                  <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h2 style="color: #f00;margin-top: 0px;margin-bottom: 0px;font-size: 30px; text-align: center;">
                                    <a href="http://seochuanchua.vn" target="_blank">
                                           <img src="templates/default/images/logo_ttp.png">   
                                    </a>

                                </h2>
                            </div>
                            <div class="panel-body">
                                <form role="form" action="login.php" method="post" name="frm_login" id="frm_login">
                                       <br />
                                     <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-tag"  ></i></span>
                                            <input type="text" class="form-control" placeholder="username" name="username" id="username"  value="" />
                                        </div>
                                                                              <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                                            <input class="form-control" placeholder="Password" name="password" id="password" type="password" value="" />
                                        </div>
                                     <input class="btn btn-primary btn-block" type="submit" value="<?php echo 'Đăng nhập'; ?>" />
                                    <input name="action" type="hidden" value="login"/>
                                    </form>
                            </div>
                           
                        </div>
                    </div>
        </div>
    </div>

    <!-- Bootstrap Core JavaScript -->
    <script src="templates/default/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="templates/default/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="templates/default/dist/js/sb-admin-2.js"></script>

  </body>
  </html>