<?php
class ImagesModelsImages extends FSModels {
	function __construct() {
		$limit = 6;
		$page = FSInput::get ( 'page' );
		$this->limit = $limit;
		$this->page = $page;
			$fstable = FSFactory::getClass('fstable');
			$this->table_name  = $fstable->_('fs_images');
			$this->table_category  = $fstable->_('fs_images_categories');
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
	//		function get_category_by_id($category_id)
	//		{
	//			if(!$category_id)
	//				return "";
	//			$query = " SELECT id,name,is_comment, icon
	//						FROM fs_news_categories 
	//						WHERE id = $category_id ";
	//			global $db;
	//			$sql = $db->query($query);
	//			$result = $db->getObject();
	//			return $result;
	//		}
	

	/*
		 * get Article
		 */
	function get_images() {
		$id = FSInput::get ( 'id' );
		$code = FSInput::get ( 'code' );
		if (! $code && ! $id)
			return;
		$fs_table = FSFactory::getClass ( 'fstable' );
		
		$select = " * ";
		$where = "published = 1";
		if (! $id)
			$where .= ' AND alias = "' . $code . '"';
		else
			$where .= ' AND id = ' . $id;
		
		$result = $this->get_record ( $where, $this -> table_name, $select );
		return $result;
	}
	/*
		 * get Category current
		 */
	function getCategoryByCode() {
		$fs_table = FSFactory::getClass ( 'fstable' );
		$ccode = FSInput::get ( 'ccode' );
		if (! $ccode)
			return;
		$query = " SELECT id,name, alias
						FROM " . $fs_table->getTable ( 'fs_images_categories' ) . " 
						WHERE alias = '$ccode' ";
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObject ();
		return $result;
	}
	function getCategoryById($id) {
		if (! $id)
			return;
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = " SELECT id,name,alias
						FROM " . $fs_table->getTable ( 'fs_images_categories' ) . " 
						WHERE id = $id ";
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObject ();
		return $result;
	}
	function getRelateImagesList($category_id, $record_id) {
//		if (! $category_id || ! $record_id)
//			return;
		$limit = 6;
		$where = "  ";
		$where .= " AND category_id = $category_id ";
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = " SELECT *
						  FROM " . $fs_table->getTable ( 'fs_images' ) . "
						  WHERE published = 1
						  	AND id <>  $record_id
						  	".$where."
						     ORDER BY  ordering DESC , id DESC
						     LIMIT $limit
						 ";
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}

	function getWithoutRelatedImagesList($category_id, $record_id) {
//		if (! $category_id || ! $record_id)
//			return;
		$limit = 6;
		$where = "  ";
		$where .= " AND category_id <> $category_id ";
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = " SELECT *
						  FROM " . $fs_table->getTable ( 'fs_images' ) . "
						  WHERE published = 1
						  	AND id <>  $record_id
						  	".$where."
						     ORDER BY  ordering DESC , id DESC
						     LIMIT $limit
						 ";
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}

	function getImages($record_id) {
		if (! $record_id)
			return;
		$limit = 100;
		$fs_table = FSFactory::getClass ( 'fstable' );
		$query = " SELECT id,image, record_id
						  FROM fs_images_images 
						  WHERE record_id =  $record_id
						  ORDER BY ordering ASC, image ASC
						     LIMIT $limit
						 ";
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}
	
	/* 
		 * get array [id] = alias
		 */
	function get_content_category_ids($str_ids) {
		if (! $str_ids)
			return;
		$fs_table = FSFactory::getClass ( 'fstable' );
		
		// search for category
		

		$query = " SELECT id,alias
                          FROM " . $fs_table->getTable ( 'fs_news_categories' ) . "
                          WHERE id IN (" . $str_ids . ")
                         ";
		
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		$array_alias = array ();
		if ($result)
			foreach ( $result as $item ) {
				$array_alias [$item->id] = $item->alias;
			}
		return $array_alias;
	}
	
	function get_comments($record_id) {
		global $db;
		if (! $record_id)
			return;
		
		$query = " SELECT *
						FROM fs_products_comments
						WHERE record_id = $record_id
							AND published = 1
						ORDER BY  created_time  DESC
						";
		$db->query ( $query );
		$result = $db->getObjectList ();
		
		$tree  = FSFactory::getClass('tree','tree/');
		$list = $tree -> indentRows2($result);
		return $list;
	}
	function get_images_by_ids($str_images_together) {
		if (! $str_images_together)
			return;
		$query = " SELECT name,id , image,price, alias,category_alias,quantity, price,price_old,is_new,is_hot,is_sale
						FROM fs_images
						WHERE id IN (" . $str_images_together . ") 
						AND published = 1";
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectListByKey ( 'id' );
		return $result;
	}
	function get_images_in_cat($category_id, $limit = FALSE) {
		if (! $category_id)
			return;
		if (isset ( $limit ) && ! empty ( $limit )) {
			$limit = "LIMIT " . $limit;
		} else {
			$limit = "";
		}
		$query = " SELECT name,id , image,price, alias,category_alias,quantity, price,price_old,is_new,is_hot,is_sale
						FROM fs_images
						WHERE category_id = $category_id
							AND published = 1 ORDER BY ordering " . $limit;
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectListByKey ( 'id' );
		return $result;
	}
	/*
		 * Lấy danh sách category 
		 */
	function get_list_parent($list_parents) {
		if (!$list_parents)
			return;
		$fs_table = FSFactory::getClass ( 'fstable' );
		echo $query = 'SELECT name,id,alias,parent_id FROM ' . $fs_table->getTable ( 'fs_images_categories' ) . ' WHERE id IN (0' . $list_parents . '0) 
					ORDER BY parent_id ASC' ;
		global $db;
		$db->query ( $query );
		$list = $db->getObjectList ();
		return $list;
	}
		
function save_comment(){
			$name = FSInput::get('name');
			$name = strip_tags($name);
			$email = FSInput::get('email');
			$email = strip_tags($email);
			
			$rate = FSInput::get ( 'rate' );
			$content = FSInput::get('content');
			$content = strip_tags($content);
			$record_id = FSInput::get('record_id',0,'int');
			$parent_id = FSInput::get('parent_id',0,'int');
			$module = FSInput::get('module');
			$view = FSInput::get('view');
			$return  = FSInput::get('return');
			$task = FSInput::get('task');
			

			$user_id = @$_COOKIE['user_id']; 
			$user = $this ->get_record_by_id($user_id,'fs_members','level');
			$is_admin = 0;
			// if($task == 'save_reply'){
			if(@$user-> level){
				$is_admin = 1;
			}
			if(mb_strtolower($name) == 'msmobile'){
				return;
			}
			if(!$name || !$email || !$content || !$record_id)
				return false;
			
			$time = date('Y-m-d H:i:s');
			$published =1;
			
			$sql = " INSERT INTO fs_".$module."_comments
						(name,email,comment,record_id,parent_id,published,created_time,edited_time,user_id,rate)
						VALUES('$name','$email','$content','$record_id','$parent_id','$published','$time','$time','$user_id','$rate')
						";
			global $db;
			// $db->query($sql);
			$id = $db->insert($sql);
			if($id){
				$this -> recalculate_comment($record_id,$time, $rate);
				//index.php?module=comments&view=comments&raw=1&id="+id+"&cmt_module="+cmt_module+"&cmt_view="+cmt_view+"&cmt_return="+cmt_return
				$link_detail = FSRoute::_('/index.php?module=comments&view=comments&raw=1&id='.$record_id.'&cmt_module='.$module.'&cmt_view='.$view.'&cmt_return='.$return);
				$link_detail = str_replace(URL_ROOT, '/', $link_detail);

				$link_detail = md5($link_detail);
				$str_link = $link_detail;

				// $this -> remove_cached($link_detail);

				if($parent_id){
					$parent = $this -> get_record('id = '.$parent_id ,'fs_products_comments');

					$data = $this ->  get_record('id = '.$record_id ,'fs_'.$module);

					// Insert vào notify
//					$row2 = array();
//					$row2['user_id'] = $parent ->user_id;
//					$time = date("Y-m-d H:i:s");
//					$row2['created_time'] = $time;
//					$row2['readers_id'] = '';
//					$link = FSRoute::_('index.php?module='.$module.'&view='.$view.'&code='.$data -> alias.'&id='.$data -> id.'&ccode='.$data->category_alias);
//					if($module ==  'products')
//						$row2['message'] = 'Bạn nhận được 1 câu trả lời từ  <a href="'.$link.'" >'.$data -> name.'</a> ';
//					else
//						$row2['message'] = 'Bạn nhận được 1 câu trả lời từ  <a href="'.$link.'" >'.$data -> title.'</a> ';
//					$row2['image'] = $data -> image;
//					$row2['is_read'] = 0;
//					$row2['record_id'] = $id;
//					$row2['type'] = 'comment_reply';
//					$row2['action_user_name'] = $_COOKIE['full_name'];
//					$this -> _add($row2, 'fs_notify');

					
					if($user-> level){
						//$this -> mail_to_after_successful($id,$module,$view);
					}
				}

			}
			return $id;
		}
	function recalculate_comment($record_id, $time , $rate) {
		if(!$rate ){
			if($record_id){
				$cookie_rating = isset($_COOKIE['rating_product'])?$_COOKIE['rating_product']:'';
				$cookie_rating .= ','.$record_id.',';
				setcookie ("rating_product", $cookie_rating, time() + 3600); //60s
			}
		}
		$sql = "SELECT 
				    record_id, 
				    COUNT(*) AS total, 
				    COUNT(IF(published = 1,1,null)) AS published,
				    COUNT(IF(published = 0,1,null)) AS unpublished
				FROM fs_images_comments
				where record_id = " . $record_id . "
						";
		global $db;
		$rs = $db->getObject ( $sql );
		
		$sql_rate = "";
		if($rate){
			$sql = "SELECT count(rate) AS rating_count, sum(rate) AS rating_sum
				FROM fs_images_comments
				where record_id = " . $record_id . " AND published = 1
				AND rate > 0
						";
			$rate_oj = $db->getObject ( $sql );
			$sql_rate = ", rating_count = ".$rate_oj -> rating_count.","
						." rating_sum = ".$rate_oj -> rating_sum." ";
		}	
		$total = $rs->total?$rs->total:0;
		$published = $rs->published?$rs->published:0;
		
		$sql = " UPDATE  fs_images
						SET comments_total = " . $total . ",
						    comments_published = " . $published . ",
						    comments_unread = comments_unread + 1,
						    comments_last_time = '" . $time . "' ".$sql_rate."
						    WHERE id = " . $record_id . "
						";
		global $db;
		$db->query ( $sql );
		$rows = $db->affected_rows ();
	}
}

?>