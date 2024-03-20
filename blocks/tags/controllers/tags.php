<?php
/*
 * Huy write
 */
	// models 
	include 'blocks/tags/models/tags.php';
	
	class TagsBControllersTags
	{
		function __construct()
		{
		}
		function display($parameters,$title)
		{
			// call models
			$model = new TagsBModelsTags();
			$list = $model->getList();
			if(!$list)
				return;
			// call views
			include 'blocks/tags/views/tags/default.php';
		}
	}
	
?>