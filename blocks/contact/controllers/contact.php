<?php
/*
 * Huy write
 */
	// models 
    include 'blocks/contact/models/contact.php';
	class ContactBControllersContact extends FSControllers
	{
		function __construct(){
		
		}
		function display($parameters,$title)
		{
		    $model = new ContactBModelsContact();
			$style = $parameters->getParams('style');
			$style = $style ? $style : 'default';
            $address = $model -> get_address_list();			
			// call views
			include 'blocks/contact/views/contact/'.$style.'.php';
		}
	}
	
?>