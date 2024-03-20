
<?php 
	class ProductsModelsFavourites
	{
		var $limit;
		var $page;
		function __construct()
		{
			$limit = 3;
			$page = FSInput::get('page');
			$this->limit = $limit;
			$this->page = $page;
		}
		
		function set_query_body($str_product_id){
			if(!$str_product_id)
				return;
			$sort = FSInput::get('sort','DESC');
			$sortby= FSInput::get('sortby','id');
			if(!$sortby)
				$sortby = 'id';
			if(!$sort)
				$sort = 'DESC';

			$order = " ORDER BY $sortby $sort";
			
			$sql = "  FROM fs_products 
					WHERE id IN ($str_product_id)
					". $order. " ";
			return $sql;
		}
		/*
		/*
		 * input: task, sim_number
		 */
		function getFavourites($query_body)
		{
			global $db;
			if(!$query_body)
				return array();
			$query = " SELECT * ".$query_body;
				
			$db->query_limit($query,$this->limit,$this->page);
			$result = $db->getObjectList();
			return $result;
		}
		function getTotal($query_body)
		{
			global $db;
			if(!$query_body)
				return array();
			$query = " SELECT count(*) ".$query_body;
				
			$db->query($query);
			$total = $db->getResult();
			return $total;
		}
		
		function getPagination($total)
		{
			FSFactory::include_class('Pagination');
			$pagination = new Pagination($this->limit,$total,$this->page);
			return $pagination;
		}
		
		/*
		 * delete from table fs_products_favourites
		 */
		function delete()
		{
			if(!isset($_SESSION['user_id']))
				return ;
			$userid = $_SESSION['user_id'];
			$cids = FSInput::get('id',array(),'array');
			if(count($cids))
			{
				global $db;
				$str_cids = implode(',',$cids);
				$sql = " DELETE FROM fs_products_favourites
						WHERE product_id IN ($str_cids )
							AND userid = $userid ";
				// $db->query($sql);
				
				$rows = $db->affected_rows($sql);
				return $rows;
			}
			return 0;
		}
		
		function save()
		{
			global $db;
			$productids = FSInput::get('data');
			if(!$productids)
				return 0;
			$arr_pid = explode(",",$productids);
			$userid = $_SESSION['user_id'];
			$username = $_SESSION['username'];
			$time = date('Y-m-d H:i:s');
			
			$j = 0;
			for($i = 0 ; $i < count($arr_pid); $i ++)
			{
				$pid = $arr_pid[$i];
				$query_exist = "SELECT EXISTS (SELECT * FROM fs_products_favourites 
								WHERE product_id='$pid'
								AND userid = '$userid'
								)
								";
				$db->query($query_exist);
				$exist = $db->getResult();
				if($exist){
					return 2;
				}
				else
				{
					$sql = " INSERT INTO fs_products_favourites
									(product_id,`userid`,`username`,created_time,updated_time)
									VALUES ('$pid','$userid','$username','$time','$time')
									";
					// $db->query($sql);
					$id = $db->insert($sql);
					$i ++;
				}
			}
			return 1;
		}
		
				/*
		 * get categories contain products
		 */
		function get_cats($array_cats_id)
		{
			if(!$array_cats_id)
				return ;
				
			$str_cats_id = implode(",",$array_cats_id);
			// get rootid
			
			global $db;
			// query get alias
			$query = " SELECT id,alias,name,root_alias
						FROM fs_categories 
						WHERE id IN ( $str_cats_id ) ";
			$sql = $db->query($query);
			$cats = $db->getObjectList();	
			return $cats;
		}
		
		function get_favourite_ids(){
			if(!isset($_SESSION['user_id']))
				return ;
			$userid = $_SESSION['user_id'];
			$query = " SELECT product_id
						FROM fs_products_favourites 
						WHERE userid = '".$userid."' ";
			global $db;
			$db->query($query);
			$rs = $db->getObjectList();
			$i = 0;
			if(!count($rs))
				return;
			$str_id = '';
			foreach($rs as $item){
				if($i > 0)
					$str_id .= ',';
				$str_id .= $item -> product_id;
				$i ++;
			}		
			return $str_id;
		}
		function  get_favourite($id){
				if(!isset($_SESSION['user_id']))
				return ;
			$userid = $_SESSION['user_id'];
			$query = " SELECT product_id,created_time
						FROM fs_products_favourites 
						WHERE product_id  = ".$id." AND
						 userid = '".$userid."' ";
			global $db;
			$db->query($query);
			$rs = $db->getObject();
			return $rs;
		}
	}
	
?>