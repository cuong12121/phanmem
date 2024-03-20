<?php
/*
 * Huy write
 */
	class ShareBControllersShare
	{
		function __construct()
		{
		}
		function display($parameters,$title)
		{
			$style = $parameters->getParams('style');
			$style = $style?$style:'default';

			include 'blocks/share/views/share/'.$style.'.php';
		}
	}
?>
