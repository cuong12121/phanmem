<?php
	class Iframe_huong_danControllersIframe_huong_dan extends Controllers{
		function __construct()
		{
			parent::__construct(); 
		}
		function display()
		{

			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
	}
	
?>