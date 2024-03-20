<?php
	// controller
	
	class UsersControllersPoint
	{
		var $module;
		var $view;
		function __construct()
		{
			
			$this->module  = 'users';
			$this->view  = 'point';
			include 'modules/'.$this->module.'/models/'.$this->view.'.php';
		}

		function display()
		{
			$fssecurity  = FSFactory::getClass('fssecurity');
            $fssecurity -> checkLogin();
            
			// call models
			$model = new UsersModelsPoint();
			
			$data = 	$model -> get_member();
			
			$arr_level = 	$model -> get_level();		

			$type = FSInput::get('type');
				
			include 'modules/'.$this->module.'/views/'.$this->view.'/default_money.php';
		}
		function policy(){
			FSFactory::include_class('fsglobal');
			$global = new FsGlobal();
				
			// sender
			$polyci = $global -> getConfig('polyci');
			echo $polyci;
		}
	}
?>
