
<?php 
	class AqModelsAq extends FSModels
	{
		function __construct()
		{
			$limit = 2;
			$page = FSInput::get('page');
			$this->limit = $limit;
			$this->page = $page;
			$fstable = FSFactory::getClass('fstable');
			$this->table_name  = $fstable->_('fs_aq');
			$this->table_category  = $fstable->_('fs_aq_categories');
		}
//		function setQuery()
//		{
//			$query = " SELECT id,title,summary,image, categoryid, tag
//						  FROM fs_contents
//						  WHERE categoryid = $cid 
//						  	AND published = 1
//						ORDER BY  id DESC, ordering DESC
//						 ";

//			return $query;
//		}

function save(){
	// $user = $this -> get_user();
	// if(!$user)
	// 	return;
			$fsstring = FSFactory::getClass('FSString','','../');
			$title = FSInput::get('title');
			
			// $name = $user -> full_name;

			$content = FSInput::get('message');
			$time = date("Y-m-d H:i:s");
			$published = 0;
		
			$row = array();
			$row['asker'] = FSInput::get('asker');
			$row['phone'] = FSInput::get('phone');
			$row['email'] = FSInput::get('email');
			// $row['email'] = $user -> email;

			$row['title'] = $title;
			$row['alias'] = $fsstring -> stringStandart($title);
			
			$row['question'] = $content;
			$row['category_id'] = FSInput::get('category_id',0,'int');
			$row['created_time'] = $time;
			$row['published'] = $published;
			$row['ordering']  = $this->getMaxOrdering();

			$id =  $this -> _add($row, 'fs_aq',1);
			
			return $id;
		}


		/*
		 * get Category current
		 */
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
		function getAq()
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
			$query = " SELECT *
						FROM ".$fs_table -> getTable('fs_aq')." 
						WHERE published = 1  AND category_published = 1
						".$where." ";
			global $db;
			$sql = $db->query($query);
			$result = $db->getObject();
			return $result;
		}

	function getNewerAqList($cid,$created_time)
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
		function getOlderAqList($cid,$created_time)
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
		
		function getRelateAqList($cid)
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
			
			$query = " SELECT *
						FROM ".$fs_table -> getTable('fs_aq')."
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
                          FROM ".$fs_table -> getTable('fs_aq_categories')."
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
		
		function get_comments($advice_id){
			global $db;
			if(!$advice_id)
				return;
//			$limit = 5;
//			$id = FSInput::get('id');
			$query = " SELECT name,created_time,id,email,comment,parent_id,level,advice_id
						FROM fs_aq_comments
						WHERE advice_id = $advice_id
							AND published = 1
						ORDER BY  created_time  DESC
						";
			$db->query($query);
			$result = $db->getObjectList();
			$tree  = FSFactory::getClass('tree','tree/');
			$list = $tree -> indentRows2($result);
			return $list;
		}
		function save_comment(){
			$name = mysql_real_escape_string(FSInput::get('name'));
			$email = mysql_real_escape_string(FSInput::get('email'));
			$text =  mysql_real_escape_string(FSInput::get('text'));
			$record_id = FSInput::get('record_id',0,'int');
			$parent_id = FSInput::get('parent_id',0,'int');
			if(!$name || !$email || !$text || !$record_id)
				return false;
			$time = date('Y-m-d H:i:s');
			$published =0;
			
			 $sql = " INSERT INTO fs_aq_comments
						(name,email,comment,advice_id,parent_id,published,created_time,edited_time)
						VALUES('$name','$email','$text','$record_id','$parent_id','$published','$time','$time')
						";
			global $db;
			$db->query($sql);
			$id = $db->insert();
			if($id)
				$this -> recalculate_comment($record_id,$time);
			return $id;
		}
		function recalculate_comment($record_id,$time){
			 $sql = " UPDATE  fs_aq
						SET comments_total = comments_total + 1,
						    comments_unread = comments_unread + 1,
						    comments_last_time = '".$time."' 
						    WHERE id = ".$record_id."
						";
			global $db;
			$db->query($sql);
			$rows = $db->affected_rows();
		}
		function save_rating(){
			$id = FSInput::get('id',0,'int');
			$rate = FSInput::get('rate',0,'int');
			
			$sql = " UPDATE  fs_aq
						SET rating_count = rating_count + 1,
						    rating_sum = rating_sum + ".$rate."
						    WHERE id = ".$id."
						";
			global $db;
			$db->query($sql);
			$rows = $db->affected_rows();
			
			// save cookies
			if($rows){
				$cookie_rating = isset($_COOKIE['rating_advice'])?$_COOKIE['rating_advice']:'';
				$cookie_rating .= $id.',';
				setcookie ("rating_advice", $cookie_rating, time() + 60); //60s
			}
			return $rows;
		}
		
		function get_comment_by_id($comment_id){
			if(!$comment_id)
				return false;
			$query = " SELECT * 
						FROM fs_contents_comments
						WHERE id =  $comment_id
							AND published = 1
						";
			global $db;
			$db->query($query);
			return $result = $db->getObject();
		}
		
		function get_categories(){
			$query = " SELECT *
						FROM ".$this->table_category ."  
						WHERE published = 1 ORDER BY ordering ";
			global $db;
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
	}
	
?>