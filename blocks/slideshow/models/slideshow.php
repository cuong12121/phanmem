<?php 
	class SlideshowBModelsSlideshow extends FSModels	{
		function __construct()
		{
		}
		
		// function get_data($category_id,$limit = 10){	
		// 	$where = "";
		// 	global $is_mobile;
		// 	//$cid = FSInput::get ( 'cid', 0, 'int' );
		// 	$cid = $category_id;

		// 	if($cid){
		// 		$get_id=$this->get_record("wrapper_id like '%,".$cid.",%'",'fs_slideshow');
		// 		if($get_id){
					
		// 			$get_cat=$this->get_records("category_id = ".$category_id."",'fs_slideshow');
		// 			if(!empty($get_cat) && count($get_cat)>=2){
		// 				$where .= " AND wrapper_id like '%,".$cid.",%' ";
		// 				$where .= " AND category_id = ".$category_id." ";
		// 			}
		// 			if($is_mobile){
		// 				if(empty($get_cat) || count($get_cat)<2){
		// 					$where .= " AND category_id = 47 ";
		// 				}
		// 			}
					
		// 		}else{
					
		// 			if(!$is_mobile){
		// 				$where .= " AND  category_id = 45  ";
		// 			}else{
		// 				$where .= " AND  category_id = 47  ";
		// 			}
					
		// 		}
				
		// 	}else{
		// 		if($category_id){
		// 			$where .= " AND category_id = ".$category_id." ";
		// 		}
		// 	}
			
		// 	$fstable = FSFactory::getClass('fstable');
		// 	$table_name  = $fstable->_('fs_slideshow');						
		// 	$query = "  SELECT id,name,image,url,summary,name2
		// 			FROM ".$table_name."
		// 			WHERE published = 1 ".$where."
		// 			ORDER BY ordering ";
		// 	global $db;
		// 	$db->query($query);
		// 	$result = $db->getObjectList();
		// 	return $result;
		// }

		function get_data($category_id,$limit = 10){	
			$where = "";
			// echo 'a';
			// die;
			if($category_id){
				// echo 'a';
				// die;
				$where .= " AND category_id = ".$category_id." ";
			}
			$fstable = FSFactory::getClass('fstable');
			$table_name  = $fstable->_('fs_slideshow');						
			$query = "  SELECT id,name,image,url,summary,name2,is_bold,is_text,url2,url_name2,url_name
					FROM ".$table_name."
					WHERE published = 1 ".$where."
					ORDER BY ordering ";
			global $db;
			$db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
	}
	
?>