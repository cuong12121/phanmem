<?php
class TestimonialsBModelsTestimonials {
	
	function __construct() {
	
	}
	
	function get_testimonials($limit) {
		$query = " SELECT *
						  FROM fs_testimonials
						  WHERE published = 1
						  ORDER BY ordering DESC, id DESC
						  LIMIT " . $limit;
		global $db;
		
		$db->query ( $query );
		
		return $db->getObjectList ();
	}
}

?>