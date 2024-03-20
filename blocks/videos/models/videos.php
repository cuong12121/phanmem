<?php
class VideosBModelsVideos {
	function __construct() {
	}
	
	function get_list($ordering, $limit) {
		global $db;
		$where = '';
		$order = '';
		global $tmpl;
		switch ($ordering) {
			case 'new' :
			$order .= ' id DESC ';
			break;
			case 'selling' :
			$order .= ' ordering DESC ';
			break;
			default :
			$order = " ordering";
		}
		$query = ' SELECT id, title, image,file_flash, created_time,link_video,summary, hits, date_published
		FROM fs_videos
		WHERE published  = 1 
		' . $where . '
		ORDER BY ' . $order .' LIMIT '.$limit;
		
		$db->query ( $query );
		$list = $db->getObjectList();
		return $list;
	}
	function get_list2($ordering, $limit) {
		global $db;
		$where = '';
		$order = '';
		global $tmpl;
		switch ($ordering) {
			case 'new' :
			$order .= ' id DESC ';
			break;
			case 'selling' :
			$order .= ' ordering DESC ';
			break;
			default :
			$order = " ordering";
		}
		$query = ' SELECT id, title, image,file_flash, created_time,link_video,summary, hits, date_published
		FROM fs_videos
		WHERE published  = 1 AND show_in_homepage = 1
		' . $where . '
		ORDER BY ' . $order .' LIMIT '.$limit;
		
		$db->query ( $query );
		$list = $db->getObjectList();
		return $list;
	}
}
?>