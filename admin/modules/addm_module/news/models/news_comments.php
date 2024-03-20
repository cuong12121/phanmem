<?php 
	class NewsModelsNews_comments extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'news_comments';
			$this -> table_name = 'fs_news_comments';
			parent::__construct();
		}
		
		function setQuery(){
			
			// ordering
			$ordering = "";
			$where = "  ";
			if(isset($_SESSION[$this -> prefix.'sort_field']))
			{
				$sort_field = $_SESSION[$this -> prefix.'sort_field'];
				$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
				$sort_direct = $sort_direct?$sort_direct:'asc';
				$ordering = '';
				if($sort_field)
					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
			}
			
			// owner
//			$owner = 0;
//			if(isset($_SESSION[$this -> prefix.'filter0'])){
//				$owner = $_SESSION[$this -> prefix.'filter0'];
//				if($owner == 1){ //  owner not is estore
//					$where .= ' AND a.estore_id =  0 ';
//				} 
//			}
			
			// if owner is estore
			if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter){
					$where .= ' AND a.estore_id =  "'.$filter.'" ';
				}
			}	
			
			// categories
			if(isset($_SESSION[$this -> prefix.'filter1'])){
				$filter = $_SESSION[$this -> prefix.'filter1'];
				if($filter){
					$where .= ' AND (d.category_id_wrapper =  "'.$filter.'"
								OR d.category_id_wrapper like  "%,'.$filter.'"
								OR d.category_id_wrapper like  "%,'.$filter.',%"
								OR d.category_id_wrapper like  "'.$filter.',%"
								)';
				}
			}
			
			if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND a.comment LIKE '%".$keysearch."%' ";
				}
			}
			
			$query = " SELECT a.*, b.name as category_name, c.estore_name, d.title
						  FROM 
						  	fs_news_comments AS a
						  	LEFT JOIN fs_news AS d ON a.content_id = d.id
						  	LEFT JOIN fs_news_categories AS b ON d.category_id = b.id
						  	LEFT JOIN fs_estores AS c ON a.estore_id = c.id
						  	WHERE 1=1 ".
						 $where.
						 $ordering. " ";
			return $query;
		}
		
		function save(){
			$title = FSInput::get('title');
			if(!$title)
				return false;
			$image = $_FILES["image"]["name"];
			if($image){
				
				$path_original =  PATH_IMG_NEWS.'news'.DS.'original'.DS;
				$path_resize =  PATH_IMG_NEWS.'news'.DS.'resized'.DS; //142x100
				$path_slideshow_small =  PATH_IMG_NEWS.'news'.DS.'slideshow_small'.DS; // slideshow small
				$path_slideshow_large =  PATH_IMG_NEWS.'news'.DS.'slideshow_large'.DS; // slideshow large
				
				// remove old if exists record and img
				$id = FSInput::get('id',0,'int');
				if($id){
					$img_paths = array();
					$img_paths[] = $path_original;
					$img_paths[] = $path_resize;
					$img_paths[] = $path_slideshow_small;
					$img_paths[] = $path_slideshow_large;
					$this -> remove_image($id,$img_paths);
				}
				$fsFile = FSFactory::getClass('FsFiles');
				
				// upload
				$image = $fsFile -> uploadImage("image", $path_original ,2000000, '_'.time());
				if(!$image)
					return false;
					
				
				// rezise to standart : 142x100
				if(!$fsFile ->resized_not_crop($path_original.$image, $path_resize.$image,142, 100))
				{
					return false;
				}
				
				// rezise to size : 64x44
				if(!$fsFile ->resized_not_crop($path_original.$image, $path_slideshow_small.$image,64, 44))
				{
					return false;
				}
				
				// rezise to size : 435x294
				if(!$fsFile ->resized_not_crop($path_original.$image, $path_slideshow_large.$image,435, 294))
				{
					return false;
				}
				$row['image'] = 	$image;
			}
				
			$row['description'] = htmlspecialchars_decode(FSInput::get('description'));
			$alias= FSInput::get('alias');
			$fsstring = FSFactory::getClass('FSString','','../');
			if(!$alias){
				$row['alias'] = $fsstring -> stringStandart($title);
			} else {
				$row['alias'] = $fsstring -> stringStandart($alias);
			}
			
			//pr
			$row['is_pr'] = FSInput::get('is_pr',0,'int');
			if($row['is_pr']){
				$pr_created_hour = FSInput::get('pr_created_hour',0,'int');
				$pr_created_hour = ($pr_created_hour > 23 || $pr_created_hour < 0) ? 0: $pr_created_hour ; 
				$pr_created_minute = FSInput::get('pr_created_minute',0,'int');
				$pr_created_minute = ($pr_created_minute > 59 || $pr_created_minute < 0) ? 0: $pr_created_minute ;
				$pr_created_time = FSInput::get('pr_created_time1');
				$row['pr_created_time'] = date('Y-m-d H:i:s',strtotime($pr_created_time.' '.$pr_created_hour.':'.$pr_created_minute.':0'));;
			}
			
			// buy HOT position
			$row['is_hot'] = FSInput::get('is_hot',0,'int');
			if($row['is_hot']){
				$hot_started_hour = FSInput::get('hot_started_hour',0,'int');
				$hot_started_hour = ($hot_started_hour > 23 || $hot_started_hour < 0) ? 0: $hot_started_hour ; 
				$hot_started_minute = FSInput::get('hot_started_minute',0,'int');
				$hot_started_minute = ($hot_started_minute > 59 || $hot_started_minute < 0) ? 0: $hot_started_minute ;
				$hot_started_time = FSInput::get('hot_started_time1');
				$row['hot_started_time'] = date('Y-m-d H:i:s',strtotime($hot_started_time.' '.$hot_started_hour.':'.$hot_started_minute.':0'));
				
				$hot_expired_hour = FSInput::get('hot_expired_hour',0,'int');
				$hot_expired_hour = ($hot_expired_hour > 23 || $hot_expired_hour < 0) ? 0: $hot_expired_hour ; 
				$hot_expired_minute = FSInput::get('hot_expired_minute',0,'int');
				$hot_expired_minute = ($hot_expired_minute > 59 || $hot_expired_minute < 0) ? 0: $hot_expired_minute ;
				$hot_expired_time = FSInput::get('hot_expired_time1');
				$row['hot_expired_time'] = date('Y-m-d H:i:s',strtotime($hot_expired_time.' '.$hot_expired_hour.':'.$hot_expired_minute.':0'));
			}
			// buy SLIDESHOW position
			$row['is_slideshow'] = FSInput::get('is_slideshow',0,'int');
			if($row['is_slideshow']){
				$slideshow_started_hour = FSInput::get('slideshow_started_hour',0,'int');
				$slideshow_started_hour = ($slideshow_started_hour > 23 || $slideshow_started_hour < 0) ? 0: $slideshow_started_hour ; 
				$slideshow_started_minute = FSInput::get('slideshow_started_minute',0,'int');
				$slideshow_started_minute = ($slideshow_started_minute > 59 || $slideshow_started_minute < 0) ? 0: $slideshow_started_minute ;
				$slideshow_started_time = FSInput::get('slideshow_started_time1');
				$row['slideshow_started_time'] = date('Y-m-d H:i:s',strtotime($slideshow_started_time.' '.$slideshow_started_hour.':'.$slideshow_started_minute.':0'));
				
				$slideshow_expired_hour = FSInput::get('slideshow_expired_hour',0,'int');
				$slideshow_expired_hour = ($slideshow_expired_hour > 23 || $slideshow_expired_hour < 0) ? 0: $slideshow_expired_hour ; 
				$slideshow_expired_minute = FSInput::get('slideshow_expired_minute',0,'int');
				$slideshow_expired_minute = ($slideshow_expired_minute > 59 || $slideshow_expired_minute < 0) ? 0: $slideshow_expired_minute ;
				$slideshow_expired_time = FSInput::get('slideshow_expired_time1');
				$row['slideshow_expired_time'] = date('Y-m-d H:i:s',strtotime($slideshow_expired_time.' '.$slideshow_expired_hour.':'.$slideshow_expired_minute.':0'));
			}
			
			$category_id = FSInput::get('category_id',0,'int');
			if(!$category_id)
				return false;
			$cat =  $this->get_record_by_id($category_id,'fs_news_categories');
			$row['category_id_wrapper'] = $cat -> list_parents;
			
			return parent::save($row);
		}
		
		/*
		 * select in category by estore_id
		 */
		function get_categories_tree_by_estore_id($estore_id)
		{
			if(!$estore_id)
				return;
			global $db;
			$query = " SELECT a.*
						  FROM 
						  	fs_news_categories AS a
						  	WHERE estore_id = $estore_id
						  	ORDER BY ordering ";
			$sql = $db->query($query);
			$result = $db->getObjectList();
			$tree  = FSFactory::getClass('tree','tree/');
			$list = $tree -> indentRows2($result);
			return $list;
		}
		/*
		 * select in category by estore_id
		 */
		function get_estore_name_by_estore_id($estore_id)
		{
			if(!$estore_id)
				return;
			global $db;
			$query = " SELECT estore_name
						  FROM 
						  	fs_estores
						  	WHERE id = $estore_id
						  	 ";
			$sql = $db->query($query);
			return $result = $db->getResult();
		}
		
		/*
		 * select in category of home
		 */
		function get_categories_tree()
		{
			global $db;
			$query = " SELECT a.*
						  FROM 
						  	fs_news_categories AS a
						  	ORDER BY ordering ";
			$sql = $db->query($query);
			$result = $db->getObjectList();
			$tree  = FSFactory::getClass('tree','tree/');
			$list = $tree -> indentRows2($result);
			return $list;
		}
		
	}
	
?>