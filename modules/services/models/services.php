<?php 
class ServicesModelsServices extends FSModels
{
	function __construct()
	{
		$limit = 2;
		$page = FSInput::get('page');
		$this->limit = $limit;
		$this->page = $page;
		$fstable = FSFactory::getClass('fstable');
		$this->table_name  = $fstable->_('fs_Services');
		$this->table_category  = $fstable->_('fs_services_categories');
	}
	function get_category_by_id($category_id)
	{
		if(!$category_id)
			return "";
		$query = " SELECT id,name,name_display,is_comment, alias, display_tags,display_title,display_sharing,display_comment,display_category,display_created_time,display_related,updated_time
		FROM ".$this->table_category ."  
		WHERE id = $category_id ";
		global $db;
		$sql = $db->query($query);
		$result = $db->getObject();
		return $result;
	}
	
		/*
		 * get Article
		 */
		function getContents()
		{
			$id = FSInput::get('id',0,'int');
			if($id){
				$where = " AND id = '$id' ";				
			} else {
				$code = FSInput::get('code');
				if(!$code)
					die('Not exist this url');
				$where = " AND alias = '$code' ";
			}
			$fs_table = FSFactory::getClass('fstable');
			$query = " SELECT id,title,image,title_display,source_website,content,category_id,category_id_wrapper,category_alias,category_name, summary,display_column, display_title, alias, tags,tags_group, created_time, updated_time,comments_published,maxPrice,minPrice, rating_count,rating_sum,seo_title,seo_keyword,seo_description
			FROM ".$fs_table -> getTable('fs_services')." 
			WHERE published = 1 AND category_published = 1
			".$where." ";
			global $db;
			$sql = $db->query($query);
			$result = $db->getObject();
			return $result;
		}

		function getNewerContentsList($cid,$created_time)
		{
			global $db;
			$limit = 10;
			$id = FSInput::get('id');
			$query = " SELECT id,title,created_time, category_id 
			FROM ".$this->table_name."
			WHERE id <> $id
			AND category_id = $cid
			AND published = 1
			AND ( created_time > '$created_time' OR id > $id)
			ORDER BY  id DESC, ordering DESC
			LIMIT 0,$limit
			";
			$db->query($query);
			$result = $db->getObjectList();
			
			return $result;
		}
		function getOlderContentsList($cid,$created_time)
		{
			global $db;
			$limit = 10;
			$id = FSInput::get('id');
			$query = " SELECT id,title ,created_time,category_id
			FROM ".$this->table_name."
			WHERE id <> $id
			AND category_id = $cid
			AND published = 1
			AND ( created_time < '$created_time' OR id < $id)
			ORDER BY  id DESC, ordering DESC
			LIMIT 0,$limit
			";
			$db->query($query);
			$result = $db->getObjectList();
			
			return $result;
		}
		
		function getRelateContentsList($cid)
		{
			if(!$cid)
				die;
			$code = FSInput::get('code');	
			$where = '';
			if($code){
				$where .= " AND alias <> '$code' ";
			} else {
				$id = FSInput::get('id',0,'int');
				if(!$id)
					die('Not exist this url');
				$where .= " AND id <> '$id' ";
			}
			
			global $db;
			$limit = 20;
			$fs_table = FSFactory::getClass('fstable');
			
			$query = " SELECT id,title,alias, category_id ,category_alias,  image
			FROM ".$fs_table -> getTable('fs_services')."
			WHERE alias <> '".$code."'
			AND category_id = $cid
			AND published = 1
			".$where."
			ORDER BY  id DESC, ordering DESC
			LIMIT 0,$limit
			";
			$db->query($query);
			$result = $db->getObjectList();
			
			return $result;
		}
		
	/* 
		 * get array [id] = alias
		 */
	function get_content_category_ids($str_ids){
		if(!$str_ids)
			return;
		$fs_table = FSFactory::getClass('fstable');    
		
		  // search for category
		
		$query = " SELECT id,alias
		FROM ".$fs_table -> getTable('fs_services_categories')."
		WHERE id IN (".$str_ids.")
		";
		
		global $db;
		$sql = $db->query($query);
		$result = $db->getObjectList();
		$array_alias = array();
		if($result)
			foreach ($result as $item){
				$array_alias[$item -> id] = $item -> alias;
			}
			return $array_alias;
		}
		
		function get_comments($contents_id){
			global $db;
			if(!$contents_id)
				return;
//			$limit = 5;
//			$id = FSInput::get('id');
			$query = " SELECT name,created_time,id,email,comment
			FROM fs_services_comments
			WHERE contents_id = $contents_id
			AND published = 1
			ORDER BY  created_time  DESC
			";
			$db->query($query);
			$result = $db->getObjectList();
			
			return $result;
		}
		function save_comment(){
			$name = FSInput::get('name');
			$email = FSInput::get('email');
			$text = FSInput::get('text');
			$contents_id = FSInput::get('contents_id',0,'int');
			if(!$name || !$email || !$text || !$contents_id)
				return false;
			
			$time = date('Y-m-d H:i:s');
			$published =0;
			
			$sql = " INSERT INTO fs_services_comments
			(name,email,comment,contents_id,published,created_time,edited_time)
			VALUES('$name','$email','$text','$contents_id','$published','$time','$time')
			";
			global $db;
			//$db->query($sql);
			$id = $db->insert($sql);
			if($id)
				$this -> recalculate_comment($contents_id);
			return $id;
		}
		function recalculate_comment($contents_id){
			$sql = " UPDATE  fs_services
			SET comments_total = comments_total + 1,
			comments_unread = comments_unread + 1
			WHERE id = ".$contents_id."
			";
			global $db;
			//$db->query($sql);
			$rows = $db->affected_rows($sql);
		}
		function save_rating(){
			$id = FSInput::get('id',0,'int');
			$rate = FSInput::get('rate',0,'int');
			
			$sql = " UPDATE  fs_services
			SET rating_count = rating_count + 1,
			rating_sum = rating_sum + ".$rate."
			WHERE id = ".$id."
			";
			global $db;
			//$db->query($sql);
			$rows = $db->affected_rows($sql);
			
			// save cookies
			if($rows){
				$cookie_rating = isset($_COOKIE['rating_contents'])?$_COOKIE['rating_contents']:'';
				$cookie_rating .= $id.',';
				setcookie ("rating_contents", $cookie_rating, time() + 60); //60s
			}
			return $rows;
		}
		
		function get_comment_by_id($comment_id){
			if(!$comment_id)
				return false;
			$query = " SELECT * 
			FROM fs_services_comments
			WHERE id =  $comment_id
			AND published = 1
			";
			global $db;
			$db->query($query);
			return $result = $db->getObject();
		}
		
		function  get_relate_by_tags($tags,$exclude = ''){
			if(!$tags)
				return;
			$arr_tags = explode(',',$tags);
			$where = ' WHERE published = 1';
			if($exclude)
				$where .= ' AND id <> '.$exclude.' ';
			$total_tags = count($arr_tags);
//			if($total_tags){
//				$where .= ' AND (';
//				$j = 0;
//				for($i = 0; $i < $total_tags; $i ++){
//					$item = trim($arr_tags[$i]);
//					if($item){
//						if($j > 0)
//							$where .= ' OR ';
//						$where .= " title like '%".$item."%' ";
//						$j ++;
//					}
//				}
//				$where .= ' )';
//			}
			
			global $db;
			$limit = 10;
			$fs_table = FSFactory::getClass('fstable');
			
			$query = " SELECT id,title,alias, category_id , image, category_alias,summary
			FROM ".$fs_table -> getTable('fs_services')."
			".$where."
			ORDER BY  id DESC, ordering DESC
			LIMIT 0,$limit
			";
			$db->query($query);
			$result = $db->getObjectList();
			
			return $result;
		}
		function getRelateContentList($cid)
		{
			if(!$cid)
				die;
			$code = FSInput::get('code');	
			$where = '';
			if($code){
				$where .= " AND alias <> '$code' ";
			} else {
				$id = FSInput::get('id',0,'int');
				if(!$id)
					die('Not exist this url');
				$where .= " AND id <> '$id' ";
			}
			
			global $db;
			$limit = 5;
			$fs_table = FSFactory::getClass('fstable');
			
			$query = " SELECT id,title,alias, category_id,category_alias
			FROM ".$fs_table -> getTable('fs_services')."
			WHERE alias <> '".$code."'
			AND category_id = $cid
			AND published = 1
			".$where."
			ORDER BY  id DESC, ordering DESC
			LIMIT 0,$limit
			";
			$db->query($query);
			$result = $db->getObjectList();
			
			return $result;
		}
		
		/*
		 * get Most Reading new
		 * LIMIT IN 600 days
		 * exclude: id bị loại trừ, truyền vào dạng 3,4,5
		 */
		function get_most_read_contents($category_id,$limit,$type ='',$limit_day = 6,$exclude = ''){
			if(!$limit)
				$limit = 9;
			$where = '';
			if($category_id){
				$where .= ' AND category_id_wrapper like "%,'.$category_id.',%"';
			}	
			if($limit_day){
				$where .= ' AND updated_time >= DATE_SUB(CURDATE(), INTERVAL '.$limit_day.' DAY)';
			}	
			
			if($type && $type != 'default'){
				$where .= ' AND type = "'.$type.'" ';
			}	
			
			if($exclude)
				$where .= ' AND id NOT LIKE ('.$exclude.') ';
			
			$query = ' SELECT id, title,image, summary,alias, category_alias,category_id
			FROM fs_services
			WHERE published = 1
			'.$where.'					  
			ORDER BY created_time DESC
			';
			global $db;
			$sql = $db->query_limit($query,$limit);
			return  $db->getObjectList();
		}
		/*
		 * get Most Reading new
		 * LIMIT IN 600 days
		 * exclude: id bị loại trừ, truyền vào dạng 3,4,5
		 */
		function get_other_contents($limit = 20,$type ='',$exclude = ''){
			if(!$limit)
				$limit = 9;
			$where = '';
			
			if($type && $type != 'default'){
				$where .= ' AND type = "'.$type.'" ';
			}	
			
			if($exclude)
				$where .= ' AND id NOT LIKE ('.$exclude.') ';
			
			$query = ' SELECT id, title,image, summary,alias, category_alias,category_id
			FROM fs_services
			WHERE published = 1
			'.$where.'					  
			ORDER BY created_time ASC
			';
			global $db;
			$sql = $db->query_limit($query,$limit);
			return  $db->getObjectList();
		}
		
		function update_hits($new_id){
			
			if(!$new_id)
				return;
			
			// count
			global $db,$econfig;
			$sql = " UPDATE fs_services 
			SET hits = hits + 1 
			WHERE  id = '$new_id' 
			";
			//$db->query($sql);
			$rows = $db->affected_rows($sql);
			return $rows;
		}
		
		function get_list_parent($list_parents){
			if(!$list_parents)
				return;
			$fs_table = FSFactory::getClass('fstable');
			$query = 'SELECT name,id,alias,parent_id FROM '.$fs_table -> getTable('fs_services_categories').
			' WHERE id IN (0'.$list_parents.'0) 
			ORDER BY POSITION(","+id+"," IN "0'.$list_parents.'0")';
			global $db;
			$db->query($query);
			$list = $db->getObjectList();
			return $list;
		}
	}
	
	?>