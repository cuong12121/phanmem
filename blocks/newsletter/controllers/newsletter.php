<?php
/*
 * Huy write
 */
	
	class NewsletterBControllersNewsletter
	{
		function __construct()
		{
		}
		function display($parameters,$title)
		{
			$style = $parameters->getParams('style'); 
			
			include 'blocks/newsletter/views/newsletter/'.$style.'.php';
		}
	}
	
?>