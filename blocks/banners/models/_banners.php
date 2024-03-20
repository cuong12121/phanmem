<?php 
	class BannersBModelsBanners
	{
		function __construct()
		{
		}
		function getList($category_id){
<<<<<<< .mine
			$where = '';
			if(!$category_id)
				return;
			$where .= ' AND category_id IN ('.$category_id.') ';
			$module = FSInput::get('module');
			$ccode = FSInput::get('ccode');
			/*if($ccode){
				if($module == 'products'){
					$where .= 'AND  products_categories_alias like "%,'.$ccode.',%" ';
				}else if($module == 'news'){
					$where .= 'AND  news_categories_alias like "%,'.$ccode.',%" ';
				}else{
				}
			}*/
			// Itemid
			$Itemid = FSInput::get ( 'Itemid', 1, 'int' );
			$where .= "AND (listItemid = 'all'
							OR listItemid like '%,$Itemid,%')
							";
=======
			// $where = '';
			// if(!$category_id)
			// 	return;
			// $where .= ' AND category_id IN ('.$category_id.') ';
			// $module = FSInput::get('module');
			// $ccode = FSInput::get('ccode');
			// /*if($ccode){
			// 	if($module == 'products'){
			// 		$where .= 'AND  products_categories_alias like "%,'.$ccode.',%" ';
			// 	}else if($module == 'news'){
			// 		$where .= 'AND  news_categories_alias like "%,'.$ccode.',%" ';
			// 	}else{
			// 	}
			// }*/
			// // Itemid
			// $Itemid = FSInput::get ( 'Itemid', 1, 'int' );
			// $where .= "AND (listItemid = 'all'
			// 				OR listItemid like '%,$Itemid,%')
			// 				";
>>>>>>> .r20455
			
			// $query = " SELECT name,id,category_id,type,image,flash,content,link,height,width
			// 			  FROM fs_banners AS a
			// 			  WHERE published = 1
			// 			 ".$where." ORDER BY ordering, id ";
			// global $db;
			// $db->query($query);
			// $list = $db->getObjectList();
			
			// return $list;
			// $global_class = FSFactory::getClass('FsGlobal');
			// $list = $global_class -> get_banners($category_id);
			// // print_r($list);
			// if(!$list)	
			// 	return;
			// return $list;
			$global_class = FSFactory::getClass('FsGlobal');
			$list = $global_class -> get_banners($category_id);
			// print_r($list);
			if(!$list)	
				return;
			return $list;
		}
	}
?>