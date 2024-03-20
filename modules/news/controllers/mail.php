<?php
/*
 * Huy write
 */
	// controller
	
	class NewsControllersMail
	{
		var $module;
		var $view;
		function __construct()
		{
			$this->module  = 'news';
			$this->view  = 'mail';
		}
		function display()
		{
			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		
		// task send
		function send(){
			$url = FSInput::get('url');
			$url_back = FSRoute::_('index.php?module=news&view=mail&raw=1&url='.$url);
			if(!$this->check_captcha())
			{
				setRedirect($url_back,'B&#7841;n nh&#7853;p l&#7895;i captcha','error');
			}	
			if(!$this->send_mail())
			{
				setRedirect($url_back,'Không gửi được mail','error');
			}	
			echo "<script type='text/javascript'>window.parent.close()</script>";
		}
		
		// function sendmail
		function send_mail()
		{
				// send Mail()
				$mailer = FSFactory::getClass('email','mail');
				// sender
				$sender_name = FSInput::get('name');
				$sender_email = FSInput::get('email');

				// Recipient
				$to= FSInput::get('to');
				$sender_email = FSInput::get('email');
				$subject = FSInput::get('subject');
				$message = FSInput::get('message');
				
				$mailer -> isHTML(true);
//				$mailer -> IsSMTP();
				$mailer -> setSender(array($sender_email,$sender_name));
				$mailer -> addRecipient(array($to,''));
				$url = FSInput::get('url');
				$url = base64_decode($url);
				
				$cc= FSInput::get('c');
				$arr_cc =  explode(',',$cc);
				for($i = 0; $i < count($arr_cc); $i ++ ){
					$item  = trim($arr_cc[$i]);
					$mailer -> addBCC(array($item,''));
				}
				
				$mailer -> addBCC(array('robocon_20062007@yahoo.com.vn','pham quoc huy'));
//				$mailer -> addBCC(array('phamhuy@finalstyle.com','pham van huy'));
//				$mailer -> addBCC(array('nguyenhung@finalstyle.com','nguyen quang hung'));
				$mailer -> setSubject('['.URL_ROOT.'] '.$subject);
				
				// body
				
				$body = '';
				$body .= '<div>';
				$body .= '<p><font face="Times New Roman"><strong>'.$sender_name.' (<a target="_blank" href="mailto:'.$sender_email.'">'.$sender_email.'</a>)</strong> gửi cho bạn bài báo</font></p>';
				$body .= '<p><a target="_blank" href="'.$url.'">'.$url.'</a></p>';
				if($message){
					$body .= '<p>với lời nhắn:</p><p>'.$message.'</p>';
				}
				$body .= '<p></p><hr><p></p><p><font face="Times New Roman">Email này được gửi bằng tiện ích "Gửi cho bạn bè" của </font>';
				$body .= '<b><font face="Times New Roman"><a target="_blank" style="text-decoration:none" href="'.URL_ROOT.'">';
				$body .= '<font color="#000000">'.URL_ROOT.'</font></a><br></font></b></p></div>';
				$mailer -> setBody($body);
				if(!$mailer ->Send())
					return false;
				return true;
		}
		
		/*
		 * function check Captcha
		 */
		function check_captcha()
		{
			$keystring = trim(FSInput::get("keystring"));
			if(!isset($keystring))
			{	
				return 0;
			}
			if($keystring != $_SESSION['captcha_keystring'])
			{
				return 0;
			}
			return 1;
		}
	}
	
?>