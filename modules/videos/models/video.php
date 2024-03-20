
<?php 
	class VideosModelsVideo extends FSModels
	{
		function __construct()
		{
			$limit = 10;
			$page = FSInput::get('page');
			$this->limit = $limit;
			$this->page = $page;
			$fstable = FSFactory::getClass('fstable');
			$this->table_name  = $fstable->_('fs_videos');
			$this->table_category  = $fstable->_('fs_videos_categories');
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
		/*
		 * get Category current
		 */
		function get_category_by_id($category_id)
		{
			if(!$category_id)
				return "";
			$query = " SELECT *
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
		function get_data()
		{
			$id = FSInput::get('id',0,'int');
			if($id){
				$where = " AND id = '$id' ";				
			} else {
				$code = FSInput::get('code');
				$where = " AND alias = '$code' ";
			}
			$fs_table = FSFactory::getClass('fstable');
			$query = " SELECT *
						FROM ".$fs_table -> getTable('fs_videos')." 
						WHERE published = 1
						".$where." ";
			global $db;
			$sql = $db->query($query);
			$result = $db->getObject();
			return $result;
		}
		
	function  get_relate_by_tags($tags,$exclude = '',$category_id, $limit){
			if(!$tags)
				return;
			$arr_tags = explode(',',$tags);
			$where = ' WHERE 1 = 1';
			$where .= ' AND  category_id = '.$category_id.' ';
			
			if($exclude)
				$where .= ' AND id <> '.$exclude.' ';
			$total_tags = count($arr_tags);
			if($total_tags){
				$where .= ' AND (';
				$j = 0;
				for($i = 0; $i < $total_tags; $i ++){
					$item = trim($arr_tags[$i]);
					if($item){
						if($j > 0)
							$where .= ' OR ';
						$where .= " title like '%".addslashes($item)."%' ";
						$j ++;
					}
				}
				$where .= ' )';
			}
			
			global $db;
			$fs_table = FSFactory::getClass('fstable');
			
			$query = " SELECT id,title,alias, category_id , image, category_alias,summary
						FROM ".$fs_table -> getTable('fs_videos')."
							".$where."
						ORDER BY  id DESC, ordering DESC
						LIMIT 0,$limit
						";
			$db->query($query);
			$result = $db->getObjectList();
			
			return $result;
		}

	
		function get_related($category_id, $exclude = '', $limit)
		{
			$where = ' published = 1';
			if($category_id)
				$where .= ' AND category_id = '.$category_id.' ';
			
			if($exclude)
				$where .= ' AND id NOT IN ('.$exclude.') ';
			
			global $db;
			$fs_table = FSFactory::getClass('fstable');
			
			$query = " SELECT *
						FROM ".$fs_table -> getTable('fs_videos')."
						WHERE 
							".$where."
						ORDER BY  id DESC, ordering DESC
						LIMIT 0,$limit
						";
			$db->query($query);
			$result = $db->getObjectList();
			
			return $result;
		}
		

		function update_hits($news_id){
			if(USE_MEMCACHE){
				$fsmemcache = FSFactory::getClass('fsmemcache');
				$mem_key = 'array_hits';
				
				$data_in_memcache = $fsmemcache -> get($mem_key);
				if(!isset($data_in_memcache))
					$data_in_memcache = array();
				if(isset($data_in_memcache[$news_id])){
					$data_in_memcache[$news_id]++;
				}else{
					$data_in_memcache[$news_id] = 1;
				}
				$fsmemcache -> set($mem_key,$data_in_memcache,10000);
				
			}else{
				if(!$news_id)
					return;
					
				// count
				global $db,$econfig;
				$sql = " UPDATE fs_videos 
						SET hits = hits + 1 
						WHERE  id = '$news_id' 
					 ";
				$db->query($sql);
				$rows = $db->affected_rows();
				return $rows;
			}
		}
        function add_like($id) {
    		if (! $id)
    			return;
    		if(isset($_COOKIE['upload_'.$id])){
    			echo "-1";
    			return;
    		}
    		// count
    		global $db;
    		$sql = " UPDATE fs_videos 
    					SET `like` = `like` + 1 
    					WHERE  id = '$id' 
    				 ";
    		$db->query ( $sql );
    		$rows = $db->affected_rows ();
    		setcookie('upload_'.$id, 1);
    		return $rows;
    	}
	
	function get_like_by_id($id) {
    		if (! $id)
    			return;
    		return $this -> get_result('id = '.$id,'fs_videos','`like`');
    	}
	
        function get_image_owner($user_id){
    		if (! $user_id)
    			return;
    		return $this -> get_records('user_id = '.$user_id,'fs_videos','*','id DESC limit 6');
    	}
		
	}
	
?>