<?php

/*
 * Huy write
 */
// models 

include 'blocks/testimonials/models/testimonials.php';

class TestimonialsBControllersTestimonials 
{
	
	function __construct() 
	{
	}
	
	function display($parameters, $title) 
	{
		
		$ordering = $parameters->getParams ( 'ordering' );
		$model = new TestimonialsBModelsTestimonials ();
		$limit = $parameters->getParams('limit');
		$limit = $limit ? $limit:3; 
		$list = $model->get_testimonials ($limit);
		if(!$list)
			return;
//		$style = $parameters->getParams ( 'style' );
		// call views

//		$style = $style ? $style : 'default';
		$style = 'grid_slideshow'; 
		include 'blocks/testimonials/views/testimonials/' . $style . '.php';
	}

}

?>