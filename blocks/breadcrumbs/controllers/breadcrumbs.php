<?php
/*
 * Huy write
 */
	class BreadcrumbsBControllersBreadcrumbs
	{
		function __construct()
		{
		}
		function display($parameters,$title)
		{
			$style = $parameters->getParams('style');
			$style = $style?$style:'default';
			$Itemid = FSInput::get ( 'Itemid',1,'int' );	

			global $tmpl;
			$breadcrumbs = $tmpl -> get_variables('breadcrumbs');
			// echo "<pre>";
			// printr($breadcrumbs);
			// call views
			include 'blocks/breadcrumbs/views/breadcrumbs/'.$style.'.php';
		}
	}
?>
