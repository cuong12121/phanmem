<?php 
	class RegionsBModelsRegions extends FSModels
	{
		function __construct()
		{
		}
	
		
		function get_list(){
			return $this -> get_records('published  = 1','fs_locations_regions','id,name',' ordering ASC, id ASC ');
		}
	}
?>