<?php
/*
 * Huy write
 */
	// controller
	
	class UsersControllersSendmaireplyadmin
	{
		var $module;
		var $view;
		function __construct()
		{
			
			$this->module  = 'users';
			$this->view  = 'email';
		}
		
		function sendMailComment($name,$mail,$link)
		{

				$mailer = FSFactory::getClass('Email','mail');
				$global = new FsGlobal();
				$admin_name = $global -> getConfig('admin_name');
				$admin_email = $global -> getConfig('admin_email');
				global $config;
				
				$mailer -> isHTML(true);
				$mailer -> setSender(array($admin_email,$admin_name));
				$mailer -> AddAddress($admin_email,$admin_name );
				// $mailer -> AddAddress($mail,$name);
				$mailer -> setSubject($config['site_name']);
				// body
				$body = '';
				$body .= '<div>Chào Admin!</div>';
				$body .= '<div>Khách hàng '.$name.'('.$mail.') đã trả lời bình luận trên bài viết '.$link.'</div>';
				$body .= '<div>Xin cảm ơn!</div>';			
				$mailer -> setBody($body);
				if(!$mailer ->Send())
					return false;
				// print_r($mailer);
				// die;
				return true;
		}
	}
	
?>
