<?php
/*
 * Huy write
 */
	// controller
	
	class NotfoundControllersNotfound extends FSControllers
	{
		var $module;
		var $view;
		function display()
		{

		//header('Location: http://msmobile.com.vn/');
		 //header('Location: http://msmobile.com.vn', true, 301);
		 //setRedirect('http://msmobile.com.vn/');
		  //exit();
			global $tmpl;
			$tmpl -> setTitle('404 Page');
			$tmpl -> setMetades('Xin lỗi, chúng tôi không tìm thấy trang mà bạn cần!');
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';

		}
	}
	
?>