<?php
//https://developers.facebook.com/apps/
/**
 * @author ndson
 * @category controller
 */
class UsersControllersFace extends FSControllers{
    function __construct(){
        parent::__construct();
	}
    
    
    function callback(){
     	require(PATH_BASE.'libraries'.DS.'facebook_sdk'.DS.'autoload.php');
     	$fb = new Facebook\Facebook([
		  'app_id' => '604199606716822', // Replace {app-id} with your app id
		  'app_secret' => 'bfe93a6745b4cd4b32f416d03986bed7',
		  'default_graph_version' => 'v2.2',
		  ]);

		$helper = $fb->getRedirectLoginHelper();

		try {
		  $accessToken = $helper->getAccessToken();
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		  // When Graph returns an error
		  echo 'Graph returned an error: ' . $e->getMessage();
		  exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		  // When validation fails or other local issues
		  echo 'Facebook SDK returned an error: ' . $e->getMessage();
		  exit;
		}

		if (! isset($accessToken)) {
		  if ($helper->getError()) {
		    header('HTTP/1.0 401 Unauthorized');
		    echo "Error: " . $helper->getError() . "\n";
		    echo "Error Code: " . $helper->getErrorCode() . "\n";
		    echo "Error Reason: " . $helper->getErrorReason() . "\n";
		    echo "Error Description: " . $helper->getErrorDescription() . "\n";
		  } else {
		    header('HTTP/1.0 400 Bad Request');
		    echo 'Bad request';
		  }
		  exit;
		}

		// Logged in
		// echo '<h3>Access Token</h3>';
		// var_dump($accessToken);
		// var_dump($accessToken->getValue());

			try {
			  // Returns a `Facebook\FacebookResponse` object
			  $response = $fb->get('/me?fields=email,id,name,gender,link,first_name,last_name,locale', $accessToken->getValue());
			} catch(Facebook\Exceptions\FacebookResponseException $e) {
			  echo 'Graph returned an error: ' . $e->getMessage();
			  exit;
			} catch(Facebook\Exceptions\FacebookSDKException $e) {
			  echo 'Facebook SDK returned an error: ' . $e->getMessage();
			  exit;
			}

			$user = $response->getGraphUser();

			$this -> exe_login($user);

			// print_r($user);
			// echo 'Name: ' . $user['name'];






		// The OAuth 2.0 client handler helps us manage access tokens
		$oAuth2Client = $fb->getOAuth2Client();

		// Get the access token metadata from /debug_token
		$tokenMetadata = $oAuth2Client->debugToken($accessToken);
		// echo '<h3>Metadata</h3>';
		// var_dump($tokenMetadata);

		// Validation (these will throw FacebookSDKException's when they fail)
		$tokenMetadata->validateAppId('203829640218671'); // Replace {app-id} with your app id
		// If you know the user ID this access token belongs to, you can validate it here
		//$tokenMetadata->validateUserId('123');
		$tokenMetadata->validateExpiration();

		if (! $accessToken->isLongLived()) {
		  // Exchanges a short-lived access token for a long-lived one
		  try {
		    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
		  } catch (Facebook\Exceptions\FacebookSDKException $e) {
		    echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
		    exit;
		  }

		  echo '<h3>Long-lived</h3>';
		  var_dump($accessToken->getValue());
		}

		$_SESSION['fb_access_token'] = (string) $accessToken;
     }

     function exe_login($user){
     	$data = $this->model->checkExitsUser($user);
				//testVar($data); echo 'xxx';die;
		if ($data)
		{
			if(!$data -> published || $data -> block ){
				$link = URL_ROOT;
				$msg = "Your account is locked or not activated";
				setRedirect($link, $msg);
			}
		    // neu ton tai thi cho dang nhap luon, ko quan tam tk mail nay dang ky thu cong hay bang face
		    $time =time()+60*60*24*30;        
			setcookie('face',1,$time,'/');
			setcookie('full_name',$data->full_name,$time,'/');
			setcookie('email',$data->email,$time,'/');
			setcookie('user_id',$data->id,$time,'/');

			
				if($data -> username){							
					setcookie('username',$data->username,$time,'/');
				}
				
				
				$this->model -> upload_last_time($data -> id);
					$return['error'] 	= true;
					$return['url']		=  URL_ROOT;                           
                    $return['msg']		=  "Successful login";
                       
                    
					$strHTML  = '<script type="text/javascript">';
					$strHTML .= '	window.opener.login_facebook('.json_encode($return).');';
					$strHTML .= '	window.close();';
					$strHTML .= '</script>';

//							}
					if(!$data->username ){
						$link = FSRoute::_('index.php?module=users&view=users&task=edit&Itemid=45');
						$msg = "Successful login. Please add your information";
						setRedirect($link, $msg);
					}

					if(isset($_SESSION['social_redirect']) && $_SESSION['social_redirect']){
						$link = base64_decode($_SESSION['social_redirect']);
						unset($_SESSION['social_redirect']);
					}else{
						$link = URL_ROOT;								
					}
					
					//echo $strHTML;
					$msg = "Successful login";
					setRedirect($link, $msg);
		}else{
				$id = $this->model->save($user);
				if($id){
					 $time =time()+60*60*24*30;        
					setcookie('face',1,$time,'/');
					setcookie('full_name',$user['name'],$time,'/');
					setcookie('email',$user['email'],$time,'/');
					setcookie('user_id',$id,$time,'/');


					$return['error'] 	= true;
					$return['url']		=  URL_ROOT;
					$return['msg']		=  "Save Successful Members";
					$strHTML  = '<script type="text/javascript">';
					$strHTML .= '	window.opener.login_facebook('.json_encode($return).');';
					$strHTML .= '	window.close();';
					$strHTML .= '</script>';
					
					$link = FSRoute::_('index.php?module=users&view=users&task=edit&Itemid=45');
					$msg = "Successful login. Please add your information";
					setRedirect($link, $msg);

				}
				$link = URL_ROOT;
                $msg = "Not saved successfully";
				setRedirect($link, $msg);
		}
     }
} 
?>
 
