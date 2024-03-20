<?php
/*
 * Huy write
 */
	// controller
	
	class DiscountControllersDiscount extends FSControllers
	{
		var $module;
		var $view;
		

		
		function save(){
			$model = $this -> model;
			$return = FSInput::get('return');
			if($return)
				$url = base64_decode($return);
			else 	
				$url = URL_ROOT;
			$email = FSInput::get('email');
			$discount_id = FSInput::get('discount_id');
			
			// check exist
			if($model -> check_exist($email,$discount_id)){
				$msg = FSText::_('Email này đã được đăng kí trong hệ thống!');
				setRedirect($url,$msg);
			}
			
			// check limit
			if(!$model -> check_limit($discount_id)){
				$msg = FSText::_('Xin lỗi, Chương trình này đã đủ số người tham dự. Hẹn gặp lại các bạn ở chương trình sau!');
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