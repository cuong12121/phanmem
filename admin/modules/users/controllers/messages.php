<?php
	class UsersControllersMessages extends Controllers
	{
		function __construct()
		{
			$this->view = 'messages' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $model->get_data();
			$update_noti = $model->update_view_noti();
			$pagination = $model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		function add()
		{
			$model = $this -> model;
			if($_SESSION['ad_groupid'] != 6){
				$msg = "Chỉ có tài khoản giám đốc mới có quyền này !";
				setRedirect(FSRoute::_('index.php?module='.$this -> module.'&view='.$this -> view.'&task=display'),$msg,'error');
			}
			// /$category_products =  $model->get_records('published = 1 AND level = 0','fs_products_categories');
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
		
		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			if($_SESSION['ad_groupid'] != 6){
				$msg = "Chỉ có tài khoản giám đốc mới có quyền này !";
				setRedirect(FSRoute::_('index.php?module='.$this -> module.'&view='.$this -> view.'&task=display'),$msg,'error');
			}
			$data = $model->get_record_by_id($id);
			// data from fs_messages_categories
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
		function show_recipients($recipients){
			$recipients = str_replace("'", "", $recipients);
			$recipients = str_replace(",", ", ", $recipients);
			return $recipients; 
		}
		function send_email(){
			$model = $this -> model;
			$id = FSInput::get('id');
			$data = $model->get_record('id ='. $id ,'fs_messages');

			$mailer = FSFactory::getClass('Email','mail');
			$select = 'SELECT * FROM fs_config WHERE published = 1';
			global $db;
			$db -> query($select);
			$config = $db->getObjectListByKey('name');
			$site_name  = $config['site_name']-> value;
			$footer_mail_status_card  = $config['footer_mail_status_card']-> value;

			$where = "";
			if($data->recipients_username){
				$category_wrapper_id = trim($data->recipients_username,',');
				$arr_cat = explode(',',$category_wrapper_id);
				$i=0;
				foreach ($arr_cat as $cat_item) {
					if($i==0){
						$where .= " cats_product LIKE '%,".$cat_item.",%'";
					}else{
						$where .= " OR cats_product LIKE '%,".$cat_item.",%'";
					}
					$i++;
				}
			}

			$members = $model->get_records($where,'fs_members','email,full_name');

			foreach ($members as $item) {
				$mailer -> AddAddress($item->email,$item->full_name);
			}
			$mailer -> setSender(array('cskh.hailinh@gmail.com',"HaiLinh.vn"));
			$mailer -> isHTML(true);
			$mailer -> setSubject($data->subject);
			$body = str_replace('/upload_images/',URL_ROOT.'/upload_images/',$data->message);
			
			// printr($body);
			$mailer -> setBody($body);
		
			if(!$mailer ->Send()){
				echo "Có lỗi xảy ra!";
				return;
			}else{
				echo "Thành công";
				return 1;
			}
		}
	}


	function show_recipients($controle,$recipients){
			$recipients = str_replace("'", "", $recipients);
			$recipients = str_replace(",", ", ", $recipients);
			return $recipients; 
		}
?>