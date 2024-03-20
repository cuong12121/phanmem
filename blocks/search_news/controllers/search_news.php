<?php

/*
 * Huy write
 */
	// models 
	
	
	class Search_newsBControllersSearch_news
	{
		function __construct()
		{
		}
		function display($parameters = array(),$title = '')
		{
			$style = $parameters->getParams('style');
			$style = $style ? $style : 'default';
			// call views
			include 'blocks/search_news/views/search_news/'.$style.'.php';
		}
	}
	
?>