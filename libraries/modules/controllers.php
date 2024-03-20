<?php

class Controllers 
{
	var $module;
		
	    
    function Controllers() {
    	$moduls = FSInput::get('module');
        
    }
  	function callView()
  	{
  		include '../administrator/modules/'.$this->module.'/views/categories/list.php';
  	}
	function getModel($name = '', $prefix = '')
	{
	}
	function setRedirect($url,$msg)
	{
		
	}
	
}