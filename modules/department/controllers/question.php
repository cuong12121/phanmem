<?php
/*
 * Huy write
 */
	// controller
	
	class FaqControllersQuestion extends FSControllers
	{
		var $module;
		var $view;
		function display()
		{
			// call models
			$model = $this -> model;
			
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=>'Gửi câu hỏi', 1 => '');
			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			
			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
	/* 
		 * save
		 */
		function save(){
			if(! $this -> check_captcha())
			{
				echo '<div id="message_rd"><div class="message-content suc">Bạn nhập sai mã hiển thị</div></div>';
				echo "<script type='text/javascript'>alert('Bạn nhập sai mã hiển thị'); </script>";
				$this -> display();
				return;
			}
			$model = $this->model;
			$id = $model->save();
			if($id)
			{
				$link = FSRoute::_("index.php?module=faq&view=question");
				$msg = "Cám ơn bạn đã gửi câu hỏi cho chúng tôi";
				setRedirect($link,$msg);
				return;
			}
			else{
				echo "<script type='text/javascript'>alert('Xin lỗi bạn không thể gửi được cho BQT'); </script>";
				$this -> display();
				return;
			}
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
	}
	
?>