<?php
class FsGlobal
{
	
	function __construct(){
	}
	/***************	FOR ONE LANGUAGE ***********/
	function getConfig($name){
		$fstable  = FSFactory:: getClass('fstable');
		global $db;
		$sql = " SELECT value FROM ".$fstable->_('fs_config')."
		WHERE name = '$name' ";
		$db->query($sql);
		return $db->getResult();
	}
	/***************	FOR ONE LANGUAGE ***********/
	/*
	 * Lấy các biến config trong bảng fs_config_module cho giao diện hiện tại 
	 */
	function get_module_config($module,$view = '',$task = '',$params = array()){
		if(!$module)
			return;

		$view = $view ? $view : $module;
		if(USE_MEMCACHE){
			$fsmemcache = FSFactory::getClass('fsmemcache');
			$mem_key = 'config_module_'.$module.'_'.$view.'_'.$task;
			
			$config_in_memcache = $fsmemcache -> get($mem_key);
			
			if($config_in_memcache){
				return $config_in_memcache;
			}else{
				$where = '';
				$where .= 'module = "'.$module.'" AND view = "'.$view.'"';
				if($task == 'display' || !$task){
					$where .= ' AND ( task = "display" OR task = "" OR task IS NULL)';
				}else{
					$where .= ' AND task = "'.$task.'" ';
				}
				
				$fstable  = FSFactory:: getClass('fstable');
				global $db;
				$sql = " SELECT cache,params,fields_seo_title,fields_seo_keyword,fields_seo_description,fields_seo_h1,fields_seo_h2,fields_seo_image_alt,value_seo_title,value_seo_keyword,value_seo_description  FROM fs_config_modules
				WHERE $where ";
				$rs =  $db->getObject($sql);
				$config_in_memcache = $fsmemcache -> set($mem_key,$rs,180);
				return $rs;
			}
		}else{
			$where = '';
			$where .= 'module = "'.$module.'" AND view = "'.$view.'"';
			if($task == 'display' || !$task){
				$where .= ' AND ( task = "display" OR task = "" OR task IS NULL)';
			}else{
				$where .= ' AND task = "'.$task.'" ';
			}
			
			$fstable  = FSFactory:: getClass('fstable');
			global $db;
			$sql = " SELECT cache,params,fields_seo_title,fields_seo_keyword,fields_seo_description,fields_seo_h1,fields_seo_h2,fields_seo_image_alt,value_seo_title,value_seo_keyword,value_seo_description FROM fs_config_modules
			WHERE $where ";
			$rs =  $db->getObject($sql);
//			$config_in_memcache = $fsmemcache -> set($mem_key,$rs,1000);
			return $rs;
		}
	}
	
	
	/*
	 * get config is common
	 */
	function get_all_config(){
//		global $db;
//		$fstable  = FSFactory:: getClass('fstable');
//		$sql = " SELECT * FROM ".$fstable->_('fs_config')."
//				WHERE is_common = 1
//			 ";
//		$db->query($sql);
//		$list =  $db->getObjectList();
//		$array_config = array();
//		foreach($list as $item){
//			$array_config[$item -> name] = $item -> value;
//		}
//		return $array_config;
		
		
		if(USE_MEMCACHE){
			$fsmemcache = FSFactory::getClass('fsmemcache');
			$mem_key = 'config_commom';
			
			$config_in_memcache = $fsmemcache -> get($mem_key);
			
			if($config_in_memcache){
				return $config_in_memcache;
			}else{
				global $db;
				$fstable  = FSFactory:: getClass('fstable');
				$sql = " SELECT * FROM ".$fstable->_('fs_config')."
				WHERE is_common = 1
				";
				$db->query($sql);
				$list =  $db->getObjectList();
				$array_config = array();
				foreach($list as $item){
					$array_config[$item -> name] = $item -> value;
				}
				$fsmemcache -> set($mem_key,$array_config,1000);
				return $array_config;
			}
		}else{
			global $db;
			$fstable  = FSFactory:: getClass('fstable');
			$sql = " SELECT * FROM ".$fstable->_('fs_config')."
			WHERE is_common = 1
			";
			$db->query($sql);
			$list =  $db->getObjectList();
			$array_config = array();
			foreach($list as $item){
				$array_config[$item -> name] = $item -> value;
			}
			return $array_config;
		}
	}
	
	/***************	FOR MULTILANGUAGE ***********/
//	function getConfig($name)
//	{
//		$lang =$_SESSION['lang'];
//		global $db;
//		$sql = " SELECT value FROM ".'fs_config_'.$lang."
//			WHERE name = '$name' ";
//		$db->query($sql);
//		return $db->getResult();
//	}
//	/*
//	 * get config is common
//	 */
//	function get_all_config(){
//		global $db;
//		$lang =$_SESSION['lang'];
//		$sql = " SELECT * FROM ".'fs_config_'.$lang."
//				WHERE is_common = 1
//			 ";
//		$db->query($sql);
//		$list =  $db->getObjectList();
//		$array_config = array();
//		foreach($list as $item){
//			$array_config[$item -> name] = $item -> value;
//		}
//		return $array_config;
//	}
	
	/*
	 * Gọi các bảng khởi tạo cho menus
	 */
	function get_menu_by_group($group_id){
		global $is_mobile;
		if(USE_MEMCACHE){
			$fsmemcache = FSFactory::getClass('fsmemcache');
			$mem_key = 'menus';
			$menu_in_memcache = $fsmemcache -> get($mem_key);
			if($menu_in_memcache){
				$list = $menu_in_memcache;
			}else{
				global $db;
				if($is_mobile) {
					$sql = " SELECT id,link, name, alias, level, parent_id as parent_id, target,group_id,description,icon,image,show_filter
					FROM fs_menus_items
					WHERE published  = 1 
					ORDER BY ordering ASC ";
				} else {
					$sql = " SELECT id,link, name, alias, level, parent_id as parent_id, target,group_id,description,icon,image,show_filter
					FROM fs_menus_items AND  (is_mobile <> 1 OR is_mobile IS NULL) 
					WHERE published  = 1
					ORDER BY ordering ASC ";
				}
				$db->query($sql);
				$rs =  $db->getObjectList();
				$menu_in_memcache = $fsmemcache -> set($mem_key,$rs,100000);
				$list = $rs;
			}
			if(!count($list)){
				return;
			}
			$rs = array();
			foreach($list as $item){
				if($item -> group_id == $group_id){
					$rs[] = $item;
				}
			}
			return $rs;
		}else{
			global $db;
			if($is_mobile) {
				$sql = ' SELECT id,link, name, alias, level, parent_id as parent_id, target,group_id, description,icon,image,show_filter
				FROM fs_menus_items
				WHERE published  = 1 AND group_id = '.$group_id.'
				ORDER BY ordering ASC';
			} else {
				$sql = 'SELECT id,link, name, alias, level, parent_id as parent_id, target,group_id, description,icon,image,show_filter
				FROM fs_menus_items
				WHERE published  = 1 AND (is_mobile <> 1 OR is_mobile IS NULL) AND group_id = '.$group_id.'
				ORDER BY ordering ASC';
			}
			// echo $sql;
			$db->query($sql);
			$rs =  $db->getObjectList();
			return $rs;
		}
	}
	/*
	 * Lấy ra các block
	 */
	function get_blocks(){
		if(USE_MEMCACHE){
			$fsmemcache = FSFactory::getClass('fsmemcache');
			$mem_key = 'blocks';
		
			$blocks_in_memcache = $fsmemcache -> get($mem_key);
			
			if($blocks_in_memcache){
				return $blocks_in_memcache;
			}else{

				global $db;
				$sql = " SELECT id,title,content, ordering, module, position, showTitle, params ,listItemid,news_categories,contents_categories,link_title,link_admin
				FROM fs_blocks AS a 
				WHERE published = 1 
				ORDER by ordering";
				$db->query($sql);
				$rs =  $db->getObjectList();
				$blocks_in_memcache = $fsmemcache -> set($mem_key,$rs,1000);
				return $rs;
			}
			
		}else{
			global $db;
			$sql = 'SELECT id,title,content, ordering, module, position, showTitle, params ,listItemid,news_categories,contents_categories,link_title,link_admin
			FROM fs_blocks AS a 
			WHERE published = 1 
			ORDER BY ordering';
			$db->query($sql);
			$rs =  $db->getObjectList();
			return $rs;
		}
	}
	
	
/*
	 * Lấy ra các banner
	 */
function get_banners($category_id){
	if(USE_MEMCACHE){
		$fsmemcache = FSFactory::getClass('fsmemcache');
		$mem_key = 'banners';

		$banners_in_memcache = $fsmemcache -> get($mem_key);
		if($banners_in_memcache){
			$list = $banners_in_memcache ;
		}else{	
			global $db;
			$sql = " SELECT name,id,category_id,type,image,flash,content,link,height,width,listItemid,news_categories_alias,products_categories_alias 
			FROM fs_banners AS a 
			WHERE published = 1 
			ORDER by ordering";
			$db->query($sql);
			$list =  $db->getObjectList();

			$fsmemcache -> set($mem_key,$list,1000);
		}

		$ccode = FSInput::get('ccode');
		$module = FSInput::get('module');

		$rs = array();	

		foreach($list as $item){
				// In category
			if(strpos(','.$category_id.',', ','.$item -> category_id.',') === false)
				continue;

			
				// news_categories
			if($ccode && $module == 'news'){
				if(strpos($item -> news_categories_alias, ','.$ccode.',') === false)
					continue;
			}

			
				// products_categories
			if($ccode && $module == 'products'){
				if(strpos($item -> products_categories_alias, ','.$ccode.',') === false)
					continue;
					// if($item -> products_manufactory_alias)
					// 		continue;
			}
				// Itemid
			$Itemid = FSInput::get ( 'Itemid', 1, 'int' );
			if($item -> listItemid == 'all' || strpos($item -> listItemid, ','.$Itemid.',') !== false){
				$rs[] = $item;
			}

		}
		$fsmemcache -> set($mem_key,$rs,1000);
		return $rs;

	}else{
		$where = '';
		if(!$category_id)
			return;
		$where .= ' AND category_id IN ('.$category_id.') ';
		$module = FSInput::get('module');
		$ccode = FSInput::get('ccode');
		if($ccode){
			if($module == 'products'){
					//$where .= 'AND  products_categories_alias like "%,'.$ccode.',%" ';
			}else if($module == 'news'){
					//$where .= 'AND  news_categories_alias like "%,'.$ccode.',%" ';
			}else{
			}
		}
			// Itemid
		$Itemid = FSInput::get ( 'Itemid', 1, 'int' );
		$where .= "AND (listItemid = 'all'
		OR listItemid like '%,$Itemid,%')
		";

		$query = " SELECT name,id,category_id,type,image,flash,content,link,height,width
		FROM fs_banners AS a
		WHERE published = 1
		".$where." ORDER BY ordering, id ";
		global $db;
		$db->query($query);
		$list = $db->getObjectList();

		return $list;
	}
}
}