<?php
class GalleryBModelsGallery {
	
	function __construct() {
	
	}
	
	function get_gallery($limit) {
		$query = " SELECT *
						  FROM fs_images
						  WHERE published = 1
						  ORDER BY ordering DESC, id DESC
						  LIMIT " . $limit;
		global $db;
		
		$db->query ( $query );
		
		return $db->getObjectList ();
	}
}

?>