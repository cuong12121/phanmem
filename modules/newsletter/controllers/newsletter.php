<?php
/*
 * Huy write
 */
	// controller
	
	class NewsletterControllersNewsletter extends FSControllers {
	
//		function display()
//		{
//			// call models
//			$model = new NewsletterModelsNewsletter();
//			$cats  = $model->getCategories();
//			if(!$cats)
//			{
//				echo "Not found Category";	
//				die;
//			}
//			     
//			$newsletter = $model->getNewsletterList();
//			if(!$newsletter)
//				die('Not found service');
//			
//			$arr_newsletter = array();
//			foreach($newsletter as $item){
////				if(!isset($arr_newsletter[$item -> category_id]));
////					$arr_newsletter[$item -> category_id] = array();
//				$arr_newsletter[$item -> category_id][$item->id] = $item;
//				
//			}
//			// call views			
//			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
//		}
		
		function save(){
				$model = $this->model;			
			$return = FSInput::get('return');
			if($return)
				$url = base64_decode($return);
			else 	
				$url = URL_ROOT;
			$email = FSInput::get('email');
			if($model -> check_exist($email,'','email','fs_newsletter')){
				$msg = FSText::_('Email này đã được đăng kí trong hệ thống.!');
				setRedirect($url,$msg);
			}
			$rs = $model -> save();
			
			if($rs)
				$msg = FSText::_('Bạn đã đăng ký nhận email thành công.!');
			else 	
				$msg = FSText::_('Xin lỗi. Bạn chưa đăng kí nhận email thành công!');
			
			setRedirect($url,$msg);
		}
	}
	
?>