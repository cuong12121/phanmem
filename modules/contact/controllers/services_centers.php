<?php
class ContactControllersServices_centers extends FSControllers {
	
	function display(){

		$redis = new Redis();

		// Thiết lập kết nối
		$redis->connect('127.0.0.1', 6379);

		$check =0;

		if ($redis->exists('refresh')) {

	    	$check = $redis->get("refresh");
	    }

	    return $check;

	    die;

		// var_dump(1);die;
		// $model = $this->model;
		// $list=$model->get_address_list();
		// $regions = $model->get_regions();
		// $manufactories = $model->get_manufactories();
		// $breadcrumbs = array ();
		// $breadcrumbs [] = array (0 => FSText::_ ( 'Trung tâm bảo hành' ), 1 => '' );
		// global $tmpl;
		// $tmpl->assign ( 'breadcrumbs', $breadcrumbs );
		// $tmpl -> set_seo_special();
		// include 'modules/'.$this->module.'/views/'.$this->view.'/'.'default.php';
	}
		
		/* 
		 * save
		 */
		function save(){
//			if(! $this -> check_captcha())
//			{
//				echo '<div id="message_rd"><div class="message-content suc">Bạn nhập sai mã hiển thị</div></div>';
//				echo "<script type='text/javascript'>alert('Bạn nhập sai mã hiển thị'); </script>";
//				$this -> display();
//				return;
//			}
			$model = new ContactModelsContact();
			$id = $model->save();
			if($id)
			{
				$link = FSRoute::_("index.php?module=contact&Itemid=14");
				$msg = "Nội dung đã được gửi. Xin cảm ơn vì đã liên hệ với chúng tôi !";
				if(!$this -> send_mail()){
					$msg = FSText::_("Nội dung đã được gửi. Xin cảm ơn vì đã liên hệ với chúng tôi !");
				}
				setRedirect($link,$msg);
				return;
			}	else{
				echo "<script type='text/javascript'>alert('Xin lỗi bạn không thể gửi được cho BQT'); </script>";
				$this -> display();
				return;
			}
		}
		
	// function sendmail
		function send_mail()
		{
				include 'libraries/errors.php';
				// send Mail()
				//$mailer = FSInput::get('contact_email');
				$mailer = FSFactory::getClass('Email','mail');
				$global = new FsGlobal();
				
				// config to user gmail
//				$mailer -> Mailer = 'smtp';
//				$mailer -> useSMTP(true,'ssl://smtp.gmail.com','webmail.ant@gmail.com','ANt!!!!2011!!','ssl',465);
				
				// sender
				$sender_name = FSInput::get('contact_name');
				//$sender_email = FSInput::get('contact_email');

				// Recipient
						
				$to = $global-> getConfig('admin_email');
				$site_name = $global-> getConfig('site_name');
				//$to= FSInput::get('to');
				//$sender_email = FSInput::get('email');
				global $config;
				$subject = ' -  Liên hệ từ khách hàng';
				$message = FSInput::get('message');
				$message = str_replace(',', '<br/>', $message);
				$contact_fullname = FSInput::get('contact_name');
				//$contact_email = FSInput::get('contact_email');
				$contact_telephone = FSInput::get('contact_phone');
				$contact_subject = FSInput::get('contact_subject');
				$address = FSInput::get('contact_address');
				$fax = FSInput::get('contact_fax');
				$content = htmlspecialchars_decode(FSInput::get('message'));
//				$phone_send = FSInput::get('contact_phone');
//				$hour_work = FSInput::get('hour');
//				$minute_work = FSInput::get('minute');
				
				$mailer -> isHTML(true);
				$mailer -> setSender(array($sender_email,$sender_name));
				$mailer -> AddAddress($to,'admin');
				
				$mailer -> AddCC('mrmanhkut3@gmail.com','Nguyễn Duy Mạnh');
				$mailer -> setSubject(''.html_entity_decode($site_name).' '.$subject);
				// body
				
				$body = '';
				$body .= '<p align="left"><strong>Họ tên: </strong> '.$contact_fullname.'</p>';
                $body .= '<p align="left"><strong>Địa chỉ: </strong> '.$address.'</p>';
				// $body .= '<p align="left"><strong>Email : </strong> '.$contact_email.'</p>';
				$body .= '<p align="left"><strong>Điện thoại : </strong> '.$contact_telephone.'</p>';
				$body .= '<p align="left"><strong>Nội dung : </strong> '.$content.'</p>';
				
//				$body .= '<p align="left"><strong>Started work time: </strong> '.$date_work .' '.$hour_work.':'.$minute_work.'</p>';
//				$body .= $message;
				$mailer -> setBody($body);
				if(!$mailer ->Send())
					return false;
				return true;
		}
		
		/*
		 * function check Captcha
		 */
		function check_captcha(){
			$captcha = FSInput::get('txtCaptcha');
			
			if ( $captcha == $_SESSION["security_code"]){
				return true;
			} else {
			}
			return false;
		}
		function map(){
			$model = new ContactModelsContact();
			$google_map = $model -> get_address_current();
			$str_des = '';
			$str_des .= '<center>';
            $str_des .= '    	<h3>'.@$google_map -> name. '</h3>';
            $str_des .= '    	<p><strong>Add: </strong>'.@$google_map -> address. '</p>';
            $str_des .= '    	<p><strong>Telephone: </strong>'.@$google_map -> phone. '</p>';
            $str_des .= '    	</center>';
            include 'modules/'.$this->module.'/views/'.$this->view.'/'.'map.php';
		}


		function ajax_get_services_centers() {
			$model = $this->model;
			$manu_id = FSInput::get('manufactories_sl');
			$region_id = FSInput::get('province_sl');

			if(!$manu_id || !$region_id ){
				return false;
			}
			$list = $model->ajax_get_services_centers($manu_id,$region_id);
			// printr($list);
			include 'modules/'.$this->module.'/views/'.$this->view.'/items.php';
			return;
		}
	}
	
?>