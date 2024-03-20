<?php
class AlbumsBModelsAlbums {
	
	function __construct() {
	
	}
	
	function get_albums($limit) {
		$query = " SELECT *
						  FROM fs_albums
						  WHERE published = 1 AND show_in_home = 1
						  ORDER BY ordering DESC, id DESC
						  LIMIT " . $limit;
		global $db;
		
		$db->query ( $query );
		
		return $db->getObjectList ();
	}
}

?>