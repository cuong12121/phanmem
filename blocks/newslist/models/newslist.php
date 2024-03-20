
<?php 
	class NewslistBModelsNewslist extends FSModels
	{
		function __construct()
		{
		}
		
		function setQuery($str_cats,$ordering,$limit,$type){
			$where = '';
			$order = '';	
			if($str_cats)
					$where .= ' AND category_id_wrapper LIKE "%,'.$str_cats.',%" ';	
			switch ($type){
			case 'hit_most':
//				$limit_day = 7;
//				$where .= '  AND published_time >= DATE_SUB(CURDATE(), INTERVAL '.$limit_day.' DAY) ';	
				$where .= ' AND is_hot = 1';
				break;
			case 'ramdom':	
				$order .= ' RAND(),';
				break;
			case 'newest':
				$order .= ' ordering DESC,created_time DESC,';
			    break;	
            case 'hot':
				$where .= ' AND is_hot = 1';
			    break;
            case 'hits':
				$order .= ' hits DESC, ';
			    break;
			}
			$order .= ' ordering DESC,created_time DESC';
			$query = " SELECT title,alias,image,summary,hits,updated_time,id,category_alias,is_hot,comments_total,created_time,category_name,editor,author_id
						  FROM fs_news
						 WHERE  published = 1 AND is_trash = 0 AND category_published = 1 ".$where."
						  ORDER BY  ".$order."
						 LIMIT $limit  
						 ";
			return $query;
		}
		function get_list($str_cats,$ordering,$limit,$type){
			global $db;
		
			$query = $this->setQuery($str_cats,$ordering,$limit,$type);
			if(!$query)
				return;

			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}	
		function get_cats(){
			global $db;
			$query = " SELECT id,name, alias, list_parents,image,level,parent_id
					FROM fs_news_categories 
					WHERE published = 1 AND level = 0 AND show_in_homepage = 1
					ORDER BY ordering ASC LIMIT 5
			";
			$db->query($query);
			$result = $db->getObjectList();
			return $result;	
		}	
		function get_Cat($cat_id){
			global $db;
			$query = " SELECT id,name, alias, list_parents,image,level,parent_id
					FROM fs_news_categories 
					WHERE published = 1 AND id = $cat_id AND show_in_homepage = 1 
					ORDER BY ordering";
			$db->query($query);
			$result = $db->getObject();
			return $result;	
		}
		
	}
	
?>