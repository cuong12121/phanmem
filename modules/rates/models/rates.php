<?php 
class RatesModelsRates extends FSModels
{
	function __construct()
	{
		$keyword = FSInput::get('keyword');
		$limit = $keyword?10:5;
		$page = FSInput::get('page');
		$this->limit = $limit;
		$this->page = $page;
		$this->module  = FSInput::get('rate_module');  
	}
	function set_query_body()
	{
		$id = FSInput::get('id',1,'int');
		$keyword = FSInput::get('keyword');
		$where = '';
		if($keyword){
			$keyword_fulltext = str_replace(' ', ' +', $keyword);
			$where .= ' AND MATCH ( `email`,`name`,rate)  AGAINST ("+'.$keyword_fulltext.'" IN BOOLEAN MODE) ';
		}

		$fs_table = FSFactory::getClass('fstable');
		$query = ' FROM fs_'.$this->module.'_rates
		WHERE  record_id = '.$id.' 
		AND published = 1 
		'.$where;
		return $query;
	}
		function get_countrate($id){

		if(!$id)
			return;

		$where="";
		$where .= 'published=1 AND parent_id= '.$id ;
		$query = " SELECT count(*)
		FROM fs_".$this->module."_rates
		WHERE ".$where ;
		
		global $db;
		$result = $db->getResult($query);
		return $result;
	}
	function set_query_body_no_keyword()
	{
		$id = FSInput::get('id',1,'int');

		$fs_table = FSFactory::getClass('fstable');
		$query = " FROM fs_".$this->module."_rates
		WHERE  record_id = $id 
		AND published = 1 
		";
		return $query;
	}
	function get_parents($query_body) {
		if (! $query_body)
			return;
		$this->page = FSInput::get('page');	
		$query_select = 'SELECT name,created_time,id,email,comment,rate,parent_id,level,record_id,is_admin,avatar ';
		$query = $query_select;
		$query .= $query_body.' AND parent_id = 0 ';
		$query .= ' ORDER BY  id DESC  ';
		global $db;
		$db->query_limit ( $query, $this->limit, $this->page );
		$result = $db->getObjectList ();
		return $result;
	}
	function get_list($query_body) {
		if (! $query_body)
			return;
		$this->page = FSInput::get('page');	
		$query_select = 'SELECT name,created_time,id,email,comment,rate,parent_id,level,record_id,is_admin,avatar ';
		$query = $query_select;
		$query .= $query_body.' AND parent_id > 0 ';
		$query .= ' ORDER BY  id ASC  ';
		global $db;
//			$db->query_limit ( $query, $this->limit, $this->page );
		$result = $db->getObjectList ($query);
		return $result;
	}
	/********* TÌM KIẾM THEO KEYWORD ********/
	function get_list_by_keyword($query_body) {
		if (! $query_body)
			return;
		$this->page = FSInput::get('page');	
		$query_select = 'SELECT name,created_time,id,email,comment,rate,parent_id,level,record_id,is_admin,avatar ';
		$query = $query_select;
		$query .= $query_body.'  ';
		$query .= ' ORDER BY  id DESC  ';
		global $db;
		$db->query_limit ( $query, $this->limit, $this->page );
		$result = $db->getObjectList ();
		return $result;
	}
	function get_parents_by_ids($parent_ids){
		if (! $parent_ids)
			return;
		return $this -> get_records(' id IN ('.$parent_ids.') ',"fs_".$this->module."_rates",'name,created_time,id,email,comment,rate,parent_id,level,record_id,is_admin,avatar','created_time DESC');

	}
	function get_children_by_parents($parent_ids){
		if (! $parent_ids)
			return;
		return $this -> get_records(' parent_id IN ('.$parent_ids.') ',"fs_".$this->module."_rates",'name,created_time,id,email,comment,rate,parent_id,level,record_id,is_admin,avatar','created_time DESC');

	}

	/********* end TÌM KIẾM THEO KEYWORD ********/

	function getTotal($query_body)
	{
		if(!$query_body)
			return ;
		global $db;
		$query = "SELECT count(*)";
		$query .= $query_body.' AND parent_id = 0 ';
		$sql = $db->query($query);
		$total = $db->getResult();
		return $total;
	}
	function getPagination($total) {
		FSFactory::include_class ( 'AjaxPaginationrate' );
		$pagination = new AjaxPaginationrate ( $this->limit, $total, $this->page );
		return $pagination;
	}

	function get_rates_child($parent_id) {
		global $db;
		if (! $parent_id)
			return;
		$query = " SELECT name,created_time,id,email,comment,rate,parent_id,level,record_id,is_admin,avatar
		FROM fs_".$this->module."_rates
		WHERE parent_id = $parent_id 
		AND published = 1 
		ORDER BY  created_time  DESC
		";
		$db->query ( $query );
		$result = $db->getObjectList ();

		$tree  = FSFactory::getClass('tree','tree/');
		$list = $tree -> indentRows2($result);
		return $list;
	}





	function save_rate(){

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
		$actual_link =  FSInput::get('linkurlall');

		if(mb_strtolower($name) == 'Admin'){
			return;
		}

		if(isset($_COOKIE['user_id'])){
			$user_id = @$_COOKIE['user_id']; 
			$avatar = @$_COOKIE['avatar']; 
			$user = $this ->get_record_by_id($user_id,'fs_members','full_name,email');
			$is_admin = 0;
				// if($task == 'save_reply'){
			// if(@$user-> level){
			// 	$is_admin = 1;
			// }
			
			// echo $name . "----";
			// echo $email . "----";
			if($user_id){
				$name = $user->full_name;
				$email = $user->email;
			}
			// echo $content . "----";
			// echo $record_id . "----";
			// die;
		}

		

		if(!$name || !$email || !$content || !$record_id)
			return false;

		$time = date('Y-m-d H:i:s');
		$published = 0;

		$type = FSInput::get('type');
		$tablename = 'fs_'.$type.'_rates';
		$tablename_record = 'fs_'.$type;

		$sql = " INSERT INTO ".$tablename."
		(name,email,comment,record_id,parent_id,published,created_time,edited_time,user_id,avatar,is_admin,replied,rate,link)
		VALUES('$name','$email','$content','$record_id','$parent_id','$published','$time','$time','$user_id','$avatar','$is_admin',2,'$rate','$actual_link')
		";
		// die;

		global $db;
			// $db->query($sql);
		$id = $db->insert($sql);
	
		if($id){
			$this -> recalculate_rate($record_id,$time,$rate);
				//index.php?module=rates&view=rates&raw=1&id="+id+"&rate_module="+rate_module+"&rate_view="+rate_view+"&rate_return="+rate_return
			$link_detail = FSRoute::_('/index.php?module=rates&view=rates&raw=1&id='.$record_id.'&rate_module='.$module.'&rate_view='.$view.'&rate_return='.$return);
			$link_detail = str_replace(URL_ROOT, '/', $link_detail);

			$link_detail = md5($link_detail);
			$str_link = $link_detail;

			$this -> remove_cached($link_detail);

			if($parent_id){
				$parent = $this -> get_record('id = '.$parent_id ,$tablename);

				$data = $this ->  get_record('id = '.$record_id ,$tablename_record);

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
//					$row2['type'] = 'rate_reply';
//					$row2['action_user_name'] = $_COOKIE['full_name'];
//					$this -> _add($row2, 'fs_notify');


					// if($user-> level){
						//$this -> mail_to_after_successful($id,$module,$view);
					// }
			}

		}
		return $id;
	}

	function recalculate_rate($record_id, $time , $rate) {
		if(!$rate ){
			if($record_id){
				$cookie_rating = isset($_COOKIE['rating_product'])?$_COOKIE['rating_product']:'';
				$cookie_rating .= ','.$record_id.',';
				setcookie ("rating_product", $cookie_rating, time() + 3600); //60s
			}
		}
		$type = FSInput::get('type');
		$tablename = 'fs_'.$type.'_rates';
		$tablename_record = 'fs_'.$type;

		$sql = "SELECT 
		record_id, 
		COUNT(*) AS total, 
		COUNT(IF(published = 1,1,null)) AS published,
		COUNT(IF(published = 0,1,null)) AS unpublished
		FROM ".$tablename."
		where record_id = " . $record_id . "
		";
		global $db;
		$rs = $db->getObject ( $sql );
		
		$sql_rate = "";
		if($rate){
			$sql = "SELECT count(rate) AS rate_count, sum(rate) AS rate_sum
			FROM ".$tablename."
			where record_id = " . $record_id . " AND published = 1
			AND rate > 0
			";
			$rate_oj = $db->getObject($sql);
			// echo "<pre>";
			// print_r($rate_oj);
			// die;
			$rate_sum = $rate_oj -> rate_sum?$rate_oj -> rate_sum:0;
			$sql_rate = ", rate_count = ".$rate_oj -> rate_count.","
			." rate_sum = ".$rate_sum." ";
		}	
		$total = $rs->total?$rs->total:0;
		// $total = $total + 1;
		$published = $rs->published?$rs->published:0;
		$sql = " UPDATE  ".$tablename_record."
		SET rates_total = " . $total . ",
		rates_published = " . $published . ",
		rates_unread = rates_unread + 1,
		rates_last_time = '" . $time . "' ".$sql_rate."
		WHERE id = " . $record_id . "
		";
		global $db;
		$db->query ( $sql );
		$rows = $db->affected_rows ();
	}
	
//	function save_rate(){
//			$name = FSInput::get('name');
//			$email = FSInput::get('email');
//			$text = FSInput::get('text');
//			$record_id = FSInput::get('record_id',0,'int');
//			$parent_id = FSInput::get('parent_id',0,'int');
//			if(!$name || !$email || !$text || !$record_id)
//				return false;
//			
//			$time = date('Y-m-d H:i:s');
//			$published =(strtolower($name) != 'msmobile') ? 1 : 0;
//			
//			 $sql = " INSERT INTO fs_products_rates
//						(name,email,comment,product_id,parent_id,published,created_time,edited_time)
//						VALUES('$name','$email','$text','$record_id','$parent_id','$published','$time','$time')
//						";
//			global $db;
//			// $db->query($sql);
//			$id = $db->insert($sql);
//			if($id)
//				$this -> recalculate_rate($record_id,$time);
//			return $id;
//		}
//		
//		function recalculate_rate($record_id,$time){
//			$sql = " UPDATE  fs_products
//						SET rates_total = rates_total + 1,
//						    rates_unread = rates_unread + 1,
//						    rates_last_time = '".$time."' 
//						    WHERE id = ".$record_id."
//						";
//			global $db;
//			// $db->query($sql);
//			$rows = $db->affected_rows($sql);
//		}
//	
	
	/*
		 * Save rating
		 */
	function save_rating(){
		$id = FSInput::get('id',0,'int');
		$rate = FSInput::get('rate',0,'int');
		if(!$id)	
			return;
		$type = FSInput::get('type');
		$tablename = 'fs_'.$type.'_rates';
		$tablename_record = 'fs_'.$type;

		$sql = " UPDATE  ".$tablename_record."
		SET rate_count = rate_count + 1,
		rate_sum = rate_sum + ".$rate."
		WHERE id = ".$id."
		";
		global $db;
			// $db->query($sql);
		$rows = $db->affected_rows($sql);

			// save cookies
		if($rows){
			$cookie_rating = isset($_COOKIE['rating_product'])?$_COOKIE['rating_product']:'';
			$cookie_rating .= $id.',';
				setcookie ("rating_product", $cookie_rating, time() + 60); //60s
			}
			return $rows;
		}

		function save_vote_result() {
			$id           = FSInput::get ( 'id', 0, 'int' );
			$pDesign      = $_POST['pDesign'];
			$pFeatures      = $_POST['pFeatures'];
			$pPerformance      = $_POST['pPerformance'];
			if (! $id)
				return;
			$type = FSInput::get('type');
			$tablename = 'fs_'.$type.'_rates';
			$tablename_record = 'fs_'.$type;

			$sql = " UPDATE  ".$tablename_record."
			SET rating_count_vote = rating_count_vote + 1,
			rating_design_sum = rating_design_sum + " . $pDesign . ",
			rating_features_sum = rating_features_sum + " . $pFeatures . ",
			rating_performance_sum = rating_performance_sum + " . $pPerformance . "
			WHERE id = " . $id . "
			";
			global $db;
			$db->query ( $sql );
			$rows = $db->affected_rows ();
			return $rows;
		}
		function get_rate_by_id($rate_id) {
			if (! $rate_id)
				return false;
			$query = " SELECT * 
			FROM fs_contents_rates
			WHERE id =  $rate_id
			AND published = 1
			";
			global $db;
			$db->query ( $query );
			return $result = $db->getObject ();
		}


		function remove_cached($link_detail){
		// $this -> remove_memcached();
			$fsCache = FSFactory::getClass('FSCache');
			$module_rm = 'rates';

			$str_link = $link_detail;

		// xoa chi tiết tin
			$fsCache -> remove($str_link,'modules/'.$module_rm);


		// $files = glob(PATH_BASE.'/cache/modules/rates/*' ); 
		// foreach( $files as $file ){			
		// 	if( is_file( $file ) ) {				
		// 		if( !@unlink( $file ) ) {
		// 			//Handle your errors 
		// 		} 
		// 	} 
		// }			

		// $files = glob(PATH_BASE.'/cache/modules/rates/*' ); 
		// foreach( $files as $file ){			
		// 	if( is_file( $file ) ) {				
		// 		if( !@unlink( $file ) ) {
		// 			//Handle your errors 
		// 		} 
		// 	} 
		// }			

			echo '1';
		}

	}
	
	?>