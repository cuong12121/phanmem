<?php
/*
 * Huy write
 */
include 'blocks/regions/models/regions.php';

class RegionsBControllersRegions {
	function __construct() {
	}
	function display($parameters, $title) {
		$model = new RegionsBModelsRegions();
		
		$style = $parameters->getParams ( 'style' );
		
		$regions = $model -> get_list();
		
		include 'blocks/regions/views/regions/' . $style . '.php';
	}
}
?>