<?php 
	class RouterMessages{
		function enURL($array_params,$url){
			$url = URL_ROOT.'messages.html';
			foreach($array_params as $key=>$value){
				if($key == 'module' || $key == 'view')
					continue;
				$url .= '&'.$key.'='.$value;
			}
			return $url;
		}
	}
	
?>