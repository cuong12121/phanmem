
<?php 
class ProductsModelsSearch extends FSModels
{

	function __construct() {
		parent::__construct ();
		global $module_config;
		$limit = 20;
		$this->limit = $limit;
	}

		/* return query run
		 * get products list in category list.
		 * These categories is Children of category_current
		 */
		function getPagination($total) {
			FSFactory::include_class ( 'Pagination' );
			$pagination = new Pagination ( $this->limit, $total, $this->page );
			return $pagination;
		}
		function get_product_from_ids($str_product_ids){
			if(!$str_product_ids)
				return;
			$query = " SELECT *
			FROM fs_products
			WHERE id IN ($str_product_ids) ";
			$query;
			global $db;
			$db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
		function get_cat($alias){
			if(!$alias)
				return;
			$query = " SELECT *
			FROM fs_products_categories
			WHERE alias = '$alias'";
			$query;
			global $db;
			$db->query($query);
			$result = $db->getObject();
			return $result;
		}
		function get_manf($alias){
			if(!$alias)
				return;
			$query = " SELECT *
			FROM fs_manufactories
			WHERE alias = '$alias'";
			$query;
			global $db;
			$db->query($query);
			$result = $db->getObject();
			return $result;
		}
		function set_query_body()
		{
			$keyword = FSInput::get('keyword');
			$cat = FSInput::get('cat');
			$manf = FSInput::get('manf');

			if(!$keyword)
				return ;
			$where = "";
			$where2 = "";
			
			$keyword = urldecode($keyword);
			$keyword = str_replace('+',' ',$keyword);

			$tags = $this-> get_record('published = 1 AND (name = "'.$keyword.'" OR name = " '.$keyword.'")','fs_products_tags','*');

			// print_r($tags);

			if(!empty($tags)) {
				setRedirect(FSRoute::_('index.php?module=products&view=tags&code='.$tags->alias.'&id='.$tags -> id));
			}
			
			$arr_tags = explode ( ' ', $keyword );
			$total_tags = count ( $arr_tags );

			$where .= ' AND p.name like "%'.$keyword.'%" ';

			if ($cat != 'all') {
				$where .= ' AND p.category_alias ="'. $cat.'"';
				$where2 .= ' AND p.category_alias ="'. $cat.'"';
		
			}
			if ($manf != 'all') {
				$where .= ' AND p.manufactory_alias ="'. $manf.'"';
				$where2 .= ' AND p.manufactory_alias ="'. $manf.'"';
				
			}

			$where3 = ' AND p.published = 1 and p.category_published = 1 AND p.is_trash = 0';

			$where .= ' OR p.tags like "%'.$keyword.'%" ' . $where2  . $where3;

			// $where .= ' OR p.description like "%'.$keyword.'%" ' . $where2  . $where3;

			$fs_table = FSFactory::getClass('fstable');
			
			
			// $where .= " AND ( name like '%".$keyword."%'  OR tags like '%".$keyword."%' ) ";
			$sql   = "	SELECT p.*
			FROM ".$fs_table -> getTable('fs_products')." as p INNER JOIN fs_products_categories as c ON p.category_id = c.id
			WHERE p.published = 1 and p.category_published = 1 AND p.is_trash = 0 ".$where." 
			ORDER BY c.ordering DESC

			";
			return $sql;
			
		}
		/* return query run
		 * get products list in category list.
		 * These categories is Children of category_current
		 */

		function set_query_body_cat()
		{
			$keyword = FSInput::get('keyword');
			$manf = FSInput::get('manf');
			if(!$keyword)
				return ;
			$where = "";
			
			$keyword = urldecode($keyword);
			$keyword = str_replace('+',' ',$keyword);
			
			$arr_tags = explode ( ' ', $keyword );
			$total_tags = count ( $arr_tags );
			if ($total_tags) {
				$where .= ' AND ((';
				$j = 0;
				for($i = 0; $i < $total_tags; $i ++) {
					$item = trim ( $arr_tags [$i] );
					if ($item) {
						if ($j > 0)
							$where .= ' AND ';
						$where .= " p.name like '%" . $item . "%'";
						$j ++;
					}
				}
				$where .= ' ) OR p.tags like "%'.$keyword.'%" )';
			}
			if ($manf != 'all') {
				$where .= ' AND manufactory_alias ="'. $manf.'"';
			}
			$where .= ' AND category_published =1';

			$fs_table = FSFactory::getClass('fstable');
			
			
			// $where .= " AND ( name like '%".$keyword."%'  OR tags like '%".$keyword."%' ) ";
			$sql   = "	SELECT DISTINCT c.id as id, c.alias as alias, c.name as name
			FROM ".$fs_table -> getTable('fs_products_categories')." AS c INNER JOIN fs_products AS p on p.category_id = c.id
			WHERE c.published = 1".$where." 

			";
			return $sql;	
		}


		function set_query_body_manf()
		{
			$keyword = FSInput::get('keyword');
			$cat = FSInput::get('cat');
			if(!$keyword)
				return ;
			$where = "";
			
			$keyword = urldecode($keyword);
			$keyword = str_replace('+',' ',$keyword);
			
			$arr_tags = explode ( ' ', $keyword );
			$total_tags = count ( $arr_tags );
			if ($total_tags) {
				$where .= ' AND ((';
				$j = 0;
				for($i = 0; $i < $total_tags; $i ++) {
					$item = trim ( $arr_tags [$i] );
					if ($item) {
						if ($j > 0)
							$where .= ' AND ';
						$where .= " p.name like '%" . $item . "%'";
						$j ++;
					}
				}
				$where .= ' ) OR p.tags like "%'.$keyword.'%" )';
			}
			if ($cat != 'all') {
				$where .= ' AND category_alias ="'. $cat.'"';
			}
			$where .= ' AND category_published =1';

			$fs_table = FSFactory::getClass('fstable');
			
			
			// $where .= " AND ( name like '%".$keyword."%'  OR tags like '%".$keyword."%' ) ";
			$sql   = "	SELECT DISTINCT m.id as id, m.alias as alias, m.name as name
			FROM ".$fs_table -> getTable('fs_manufactories')." AS m INNER JOIN fs_products AS p on p.manufactory = m.id
			WHERE m.published = 1  ".$where." 

			";
			return $sql;	
		}

		function set_new_query_body()
		{
			$keyword = FSInput::get('keyword');
			if(!$keyword)
				return ;
			$keyword = str_replace('+', ' ',$keyword);
			// $keyword = mysql_real_escape_string($keyword);


			$fs_table = FSFactory::getClass('fstable');
			$where = "";
			
			$where .= " AND ( title like '%".$keyword."%' OR tags like '%".$keyword."%' ) ";
			$sql   = "	SELECT id,title,alias,category_alias,image  
			FROM ".$fs_table -> getTable('fs_news')."
			WHERE published =1 AND is_trash = 0 ".
			$where ;
			return $sql;
			
		}
		function get_list($query_body)
		{
			if(!$query_body)
				return;
			$query_ordering = $this -> set_query_order_by();
			$query = $query_body;
			//$query .= $query_ordering;
			global $db;
			$sql = $db->query_limit($query,$this->limit,$this->page);
			$result = $db->getObjectList();
			return $result;
		}

		function get_list_cat($query_body)
		{
			if(!$query_body)
				return;
			$query_ordering = $this -> set_query_cat_order_by();
			$query = $query_body;
			$query .= $query_ordering;
			global $db;
			$sql = $db->query_limit($query,$this->limit,$this->page);
			$result = $db->getObjectList();
			return $result;
		}

		function get_list_manf($query_body)
		{
			if(!$query_body)
				return;
			$query_ordering = $this -> set_query_manf_order_by();
			$query = $query_body;
			$query .= $query_ordering;
			global $db;
			$sql = $db->query_limit($query,$this->limit,$this->page);
			$result = $db->getObjectList();
			return $result;
		}

		function get_list_next($query_body) {
			if(!$query_body)
				return;
			$query_ordering = $this -> set_query_order_by_news();
			$query = $query_body;
			$query .= $query_ordering;
			global $db;
			$sql = $db->query_limit($query,$this->limit,$this->page);
			$result = $db->getObjectList();
			return $result;
		}
		function get_list_ajax($query_body,$limit) {
			if (! $query_body)
				return;
			$query_ordering = $this->set_query_order_by ();
			$query_select = $this->set_query_select ();
			$query = $query_select;
			$query .= $query_body;
			$query .= $query_ordering;
			global $db;
			$pagecurrent = FSInput::get('pagecurrent',0,'int');
			$db->query_limit_export ( $query, $pagecurrent,$limit);
			$result = $db->getObjectList ();
			return $result;
		}
		function get_total_curent($query_body,$limit) {
			if (! $query_body)
				return;
			$query = " SELECT id";
			$query .= $query_body;
			global $db;
			$pagecurrent = FSInput::get('pagecurrent',0,'int');
			$db->query_limit_export ( $query, 0, $pagecurrent+ $this->limit);
			$result = $db->getObjectList ();
			return $result;
		}
		
	/*
		 * Insert order by into query select
		 */
	function set_query_order_by(){
		$order  = FSInput::get('order');
		$query_ordering = '';
		if($order){
			switch ($order){
				case 'asc':
				$query_ordering='ORDER BY price '.$order;
				break;
				case 'desc':
				$query_ordering='ORDER BY price '.$order;
				break;
				case 'old':
				$query_ordering='ORDER BY status ASC';
				break;	
				case 'new':
				$query_ordering='ORDER BY status DESC';
				break;	
				case 'alpha':
				$query_ordering='ORDER BY name asc';
				break;	
				case 'promotion':
				$query_ordering='ORDER BY is_promotion asc';
				break;				
			}
		}else{
			$query_ordering='ORDER BY  is_service ASC , ordering DESC';
		}

		return $query_ordering;
	}

	function set_query_cat_order_by(){
		$order  = FSInput::get('order');
		$query_ordering = '';
		if($order){
			switch ($order){
				case 'asc':
				$query_ordering='ORDER BY price '.$order;
				break;
				case 'desc':
				$query_ordering='ORDER BY price '.$order;
				break;
				case 'old':
				$query_ordering='ORDER BY status ASC';
				break;	
				case 'new':
				$query_ordering='ORDER BY status DESC';
				break;	
				case 'alpha':
				$query_ordering='ORDER BY name asc';
				break;	
				case 'promotion':
				$query_ordering='ORDER BY is_promotion asc';
				break;				
			}
		}else{
			$query_ordering='ORDER BY  c.id ASC , c.ordering DESC';
		}

		return $query_ordering;
	}


	function set_query_manf_order_by(){
		$order  = FSInput::get('order');
		$query_ordering = '';
		if($order){
			switch ($order){
				case 'asc':
				$query_ordering='ORDER BY price '.$order;
				break;
				case 'desc':
				$query_ordering='ORDER BY price '.$order;
				break;
				case 'old':
				$query_ordering='ORDER BY status ASC';
				break;	
				case 'new':
				$query_ordering='ORDER BY status DESC';
				break;	
				case 'alpha':
				$query_ordering='ORDER BY name asc';
				break;	
				case 'promotion':
				$query_ordering='ORDER BY is_promotion asc';
				break;				
			}
		}else{
			$query_ordering='ORDER BY  m.id ASC , m.ordering DESC';
		}

		return $query_ordering;
	}
		/*
		 * Insert order by into query select
		 */
		function set_query_order_by_news(){
			$order  = FSInput::get('order');
			$query_ordering = '';
			if($order){
				switch ($order){
					case 'asc':
					$query_ordering='ORDER BY price '.$order;
					break;
					case 'desc':
					$query_ordering='ORDER BY price '.$order;
					break;
					case 'old':
					$query_ordering='ORDER BY status ASC';
					break;	
					case 'new':
					$query_ordering='ORDER BY status DESC';
					break;	
					case 'alpha':
					$query_ordering='ORDER BY name asc';
					break;	
					case 'promotion':
					$query_ordering='ORDER BY is_promotion asc';
					break;				
				}
			}else{
				$query_ordering='ORDER BY   created_time DESC, id DESC';
			}
			
			return $query_ordering;
		}
		function set_query_select(){
			$query = " SELECT *";
			return $query;
		}
		function getTotal($query_body){
			global $db;
//			$query = "SELECT count(*) ";
			$query = $query_body;
			$db->query($query);
			$result= $db->getObjectList();
//			$total = $db->getResult();
			return count($result);
		}
		
		function getLoadmore($total,$pagecurrent) {
			FSFactory::include_class ( 'Loadmore' );
			$loadmore = new Loadmore ($pagecurrent,$this->limit,$total,$this->page);
			return $loadmore;
		}
		function get_breadcrumb(){
			$array_breadcrumb = array();
			$array_breadcrumb[0] = array();
			$array_breadcrumb[0][] = array('name'=>'Tìm kiếm sản phẩm','link'=>'','selected'=>1);
			
			return $array_breadcrumb;
		}
		function get_types(){
			return $list = $this -> get_records('published = 1','fs_products_types','id,name,image,alias,image,icon','ordering ASC');
		}
		function get_ajax_search($limit = 15){

			global $db;
			$where[1] = '';
			$where[2] = '';
			$where[3] = '';
			$where[4] = '';
			$query = FSInput::get('query', '');
			if(!$query)
				return;

			$where[1] .= " AND name like  '%" . $query . "%'";			
			// $where[2] .= " AND tags like  '%" . $query . "%'";
			$where[2] .= " AND summary like  '%" . $query . "%'";
			$where[3] .= " AND description like  '%" . $query . "%'";

			// $arr_tags = explode ( ' ', $query );
			// $total_tags = count ( $arr_tags );
			// if ($total_tags) {
			// 	$where[3] .= ' AND (';
			// 	$j = 0;
			// 	for($i = 0; $i < $total_tags; $i ++) {
			// 		$item = trim ( $arr_tags [$i] );
			// 		if ($item  AND strlen($item) > 1) {
			// 			if ($j > 0)
			// 				$where[3] .= ' AND ';
			// 			$where[3] .= " `name` like '%" . $item . "%'";
			// 			$j ++;
			// 		}
			// 	}
			// 	$where[3] .= ' ) ';
			// }

			// if ($total_tags) {
			// 	$where[4] .= ' AND (';
			// 	$j = 0;
			// 	for($i = 0; $i < $total_tags; $i ++) {
			// 		$item = trim ( $arr_tags [$i] );
					
			// 		if ($item AND strlen($item) > 1) {

			// 			if ($j > 0)
			// 				$where[4] .= ' OR ';
			// 			$where[4] .= " `name` like '%" . $item . "%'";
			// 			$where[4] .= " OR `tags` like '%" . $item . "%'";
			// 			$j ++;
			// 		}
			// 	}
			// 	$where[4] .= ' ) ';
			// }

			$list = array();
			for($i = 1; $i < 3; $i ++)	{				
				$sql_where = $where[$i];
				
				  // $where .= " AND `name` like '%" .  $query . "%'";
				$query = '  SELECT *
				FROM fs_products 
				WHERE published = 1 AND is_trash = 0  '.$sql_where.' 
				ORDER BY ordering DESC
				LIMIT 8
				';  

				$sql = $db->query($query);
				$result = $db->getObjectList();

				$list = array_merge($list,$result);					
			}

			
			return $this -> unique_array_objects($list);
		}

		function unique_array_objects($list){

			$arr_keys = array();
			$rs = array();
			foreach($list as $item){
				if(!in_array($item -> id,$arr_keys)){
					$rs[] = $item;
					$arr_keys[] = $item->id;
				}
			}    	
			return $rs;
		}
		function get_ajax_search_compare($ids,$table_name){
			global $db;
			$where_c = '';
			$where[1] = '';
			$where[2] = '';
			$where[3] = '';
			$where[4] = '';
			$query = FSInput::get('query', '');
			if(!$query)
				return;

			$where[1] .= " AND name like  '%" . $query . "%'";			
			$where[2] .= " AND tags like  '%" . $query . "%'";

			$arr_tags = explode ( ' ', $query );
			$total_tags = count ( $arr_tags );
			
			if ($total_tags) {
				$where[3] .= ' AND (';
				$j = 0;
				for($i = 0; $i < $total_tags; $i ++) {
					$item = trim ( $arr_tags [$i] );
					if ($item) {
						if ($j > 0)
							$where[3] .= ' AND ';
						$where[3] .= " `name` like '%" . $item . "%'";
						$j ++;
					}
				}
				$where[3] .= ' ) ';
			}

			if ($total_tags) {
				$where[4] .= ' AND (';
				$j = 0;
				for($i = 0; $i < $total_tags; $i ++) {
					$item = trim ( $arr_tags [$i] );
					if ($item) {
						if ($j > 0)
							$where[4] .= ' OR ';
						$where[4] .= " `name` like '%" . $item . "%'";
						$where[4] .= " OR `tags` like '%" . $item . "%'";
						$j ++;
					}
				}
				$where[4] .= ' ) ';
			}
			

			if($ids){
				$where_c .= ' AND id NOT IN ('.$ids.') ';
			}
			if($table_name){
				$where_c .= ' AND tablename = "fs_products_'.$table_name.'" ';
			}

			$list = array();
			for($i = 1; $i < 5; $i ++)	{
				$sql_where = 	$where_c;			
				$sql_where .= $where[$i];
            // $where .= " AND `name` like '%" .  $query . "%'";
				$query = '  SELECT *
				FROM fs_products 
				WHERE published = 1 AND is_trash = 0 '.$sql_where.' 

				ORDER BY is_service ASC , ordering DESC
				LIMIT 8
				';

				$sql = $db->query($query);
				$result = $db->getObjectList();
				$list = array_merge($list,$result);					
			}
			
			return $this -> unique_array_objects($list);
		}

		function get_price_by_colors() {
			$fs_table = FSFactory::getClass ( 'fstable' );
			$query = " SELECT id,color_code,record_id
			FROM " . $fs_table->getTable ( 'fs_products_price' ) . "
			";
			global $db;
			$sql = $db->query ( $query );
			$result = $db->getObjectList ();
			return $result;
		}

		function get_list_sell(){
			$fs_table = FSFactory::getClass ( 'fstable' );
			$query = " SELECT id, name, alias, image, price, price_old, category_alias, category_id 
			FROM " . $fs_table->getTable ( 'fs_products' ) . " 
			WHERE published = 1 AND is_sell = 1 AND category_published = 1 ORDER BY ordering DESC limit 20
			";
			global $db;
			$sql = $db->query ( $query );
			$result = $db->getObjectList ();
			return $result;
		}
		
		
	}
	
	?>