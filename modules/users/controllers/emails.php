<?php
/*
 * Huy write
 */
	// controller
	
	class UsersControllersEmail
	{
		var $module;
		var $view;
		function __construct()
		{
			
			$this->module  = 'users';
			$this->view  = 'email';
		}
		
		function sendMailForget($user,$resetPass)
		{
				// send Mail()
				$mailer = FSFactory::getClass('Email','mail/');
				$global = new FsGlobal();
				$admin_name = $global -> getConfig('admin_name');
				$admin_email = $global -> getConfig('admin_email');
				global $config;
				
				$mailer -> isHTML(true);
//				$mailer -> IsSMTP();
				$mailer -> setSender(array($admin_email,$admin_name));
				$mailer -> AddAddress($user->email,$user->fname." ".$user->full_name);
//				$mailer -> addBCC(array('phamhuy@finalstyle.com','pham van huy'));
				$mailer -> setSubject('Thay đổi mật khẩu');
				
				// body
				$body = '';
				$body .= '<div>Austores.vn Chào bạn!</div>';
				$body .= '<div>Bạn đã sử dụng chức năng lấy lại mật khẩu</div>';
				$body .= '<div>Mật khẩu đăng nhập mới của bạn là: <strong>'.$resetPass.'</strong> (Vui lòng thay đổi mật khẩu ngay sau khi đăng nhập).</div>';
				$body .= '<div>Ch&acirc;n th&agrave;nh c&#7843;m &#417;n!</div>';
								
				$mailer -> setBody($body);
				if(!$mailer ->Send())
					return false;
				return true;
		}
		
		
		
	}
	
?>
