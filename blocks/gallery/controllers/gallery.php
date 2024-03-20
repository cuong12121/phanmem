<?php

/*
 * Huy write
 */
// models 

include 'blocks/gallery/models/gallery.php';

class GalleryBControllersGallery
{
	
	function __construct() 
	{
	}
	
	function display($parameters, $title) 
	{
		
		$ordering = $parameters->getParams ( 'ordering' );
		$model = new GalleryBModelsGallery ();
		$limit = $parameters->getParams('limit');
		$limit = $limit ? $limit:5; 
		$list = $model->get_gallery ($limit);
		if(!$list)
			return;
		$style = $parameters->getParams ( 'style' );
		$summary = $parameters->getParams ( 'summary' );
		// call views

		$style = $style ? $style : 'default';
		
		// $style = 'grid_slideshow'; 
		include 'blocks/gallery/views/gallery/' . $style . '.php';
	}

}

?>