<?php
/*
 * Huy write
 */
	// controller
	
	class RssControllersHome extends FSControllers
	{
		var $module;
		var $view;
		function display()
		{
			$file_key = 'rss_home';
			$fsCache = FSFactory::getClass('FSCache');
			$cache_time = 600;
			$content_cache = $fsCache -> get($file_key,'modules/rss/home',$cache_time);
			if($content_cache){
		    	echo $content_cache;
		    } else {
		    	ob_start();
		    	$model = $this -> model;
				$categories = $model -> get_categories();
				include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
				 $content_page = ob_get_contents();
	  			 ob_end_clean();
	  			  $fsCache -> put($file_key, $content_page,'modules/rss/home');
	  			  echo 	$content_page;
		    }
			
		}
		
	}
	
?>