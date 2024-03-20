<?php
	// models 
//	include 'modules/'.$module.'/models/'.$view.'.php';
		  
	class ContactControllersContact extends Controllers
	{
		function __construct()
		{
			$this->view = 'contact' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$list = $this -> model->get_data('');
			$pagination = $this -> model->getPagination('');
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}

		function edit() {
			$ids = FSInput::get ( 'id', array (), 'array' );
			$id = $ids [0];
			$model = $this->model;
			$department = $model->get_records('','fs_contact_department');
			$data = $model->get_record_by_id ( $id );
			// data from fs_news_categories
			include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
		}

		function send_email(){
			$return= FSInput::get('return');
			$link = base64_decode($return);
			$id= FSInput::get('id');
			if(!$id){
				setRedirect($link,'Có lỗi xảy ra !');
				return false;
			}

			$model = $this -> model;
			$data = $model->get_record('id = '. $id, 'fs_contact');

			if($data ->department_id){
				$department = $model->get_record('id = '. $data ->department_id, 'fs_contact_department');
				if(empty($department->email)){
					setRedirect($link,'Có lỗi xảy ra !, Phòng ban này chưa nhập email.','error');
					return false;
				}
				
				$mailer = FSFactory::getClass('Email','mail');
				$select = 'SELECT * FROM fs_config WHERE published = 1';
				global $db;
				$db -> query($select);
				$config = $db->getObjectListByKey('name');
				// $admin_name  = $config['admin_name']-> value;
				// $admin_email  = $config['admin_email']-> value;
				$site_name  = $config['site_name']-> value;
				
				$mailer -> isHTML(true);
				$mailer -> setSender(array('buixuanthangcntt1@gmail.com','Admin'));
				$mailer -> AddAddress($department->email,$department->name);
				$mailer -> setSubject($site_name.' - Phòng ban bạn nhận được 1 liên hệ');
				// body
				$body = '';
				$body .= '<div>Chào '.$department->name.'</div>';
				$body .= '<div>Có 1 liên hệ vừa gửi cho phòng bạn</div>';
				$body .= '<div>Người gửi: '.$data->fullname.'</div>';
				$body .= '<div>Email: '.$data->email.'</div>';
				$body .= '<div>Điện thoại: '.$data->telephone.'</div>';
				$body .= '<div>Nội dung: '.$data->content.'</div>';
				
				// printr($body);			
				$mailer -> setBody($body);
				if(!$mailer ->Send())
					return false;
				// return true;
				setRedirect($link,'Gửi thành công');
			}else{
				setRedirect($link,'Có lỗi xảy ra !, Liên hệ này chưa chọn phòng ban tiếp nhận.','error');
				return false;
			}
		}
	}

	function view_send_mail_bt($controle,$id) {
		$return =  base64_encode($_SERVER['REQUEST_URI']);
		$link = 'index.php?module=contact&view=contact&task=send_email&id='.$id.'&return='.$return;
		
			// $url = base64_decode($_)
		return '<a href="'.$link.'" style="
			    background: #007cff;
			    display: inline-block;
			    padding: 5px 13px;
			    border-radius: 5px;
			    color: #FFF;
			    font-weight: bold;
			    margin-right: 10px;
			    margin-top: 10px;
			">Gửi</a>';
		
	}
	
?>