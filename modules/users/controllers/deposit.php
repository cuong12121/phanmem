<?php
/*
 * Tuan write
 */
	// controller
	
	class UsersControllersDeposit
	{
		var $module;
		var $view;
		function __construct()
		{
			
			$this->module  = 'users';
			$this->view  = 'deposit';
			include 'modules/'.$this->module.'/models/'.$this->view.'.php';
		}
		function add()
		{
			$model = new UsersModelsDeposit();
			$data  = $model -> getConfig("content_deposit_money");
			include 'modules/'.$this->module.'/views/'.$this->view.'/add.php';
		}
		
	}
	
?>
