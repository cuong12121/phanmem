<?php
/*
 * Huy write
 */
class WeblinksBControllersWeblinks {
	function __construct() {
	
	}
	function display($parameters, $title) {
		$style = $parameters->getParams ( 'style' );
		$style = $style ? $style : 'default';
		// call views
		include 'blocks/weblinks/views/weblinks/' . $style . '.php';
	}
}

?>