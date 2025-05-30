<?php 
	class Order_itemsModelsItems extends FSModels
	{
		var $limit;
		var $page;
		function __construct()
		{
			$limit = 30;
			$page = FSInput::get('page');
			$this->limit = $limit;
			$this -> table_name = 'fs_order_uploads_detail';
		
			parent::__construct();
		}
		
		function setQuery()
		{
			// ordering
			$ordering = '';
			$where = " AND is_print = 1 ";

			// from
			if(isset($_SESSION[$this -> prefix.'text0']))
			{
				$date_from = $_SESSION[$this -> prefix.'text0'];
				if($date_from){
					$date_from = strtotime($date_from);
					$date_new = date('Y-m-d',$date_from);
					$where .= ' AND a.date >=  "'.$date_new.'" ';
				}
			}
			
			// to
			if(isset($_SESSION[$this -> prefix.'text1']))
			{
				$date_to = $_SESSION[$this -> prefix.'text1'];
				if($date_to){
					$date_to = $date_to . ' 23:59:59';
					$date_to = strtotime($date_to);
					$date_new = date('Y-m-d H:i:s',$date_to);
					$where .= ' AND a.date <=  "'.$date_new.'" ';
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter){
					
					$where .= ' AND a.house_id =  "'.$filter.'" ';
				}
			}


			if(isset($_SESSION[$this -> prefix.'filter1'])){
				$filter = $_SESSION[$this -> prefix.'filter1'];
				if($filter){
					
					$where .= ' AND a.warehouse_id =  "'.$filter.'" ';
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter2'])){
				$filter = $_SESSION[$this -> prefix.'filter2'];
				if($filter){
					
					$where .= ' AND a.platform_id =  "'.$filter.'" ';
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter3'])){
				$filter = $_SESSION[$this -> prefix.'filter3'];
				if($filter){
					$where .= ' AND a.shipping_unit_id =  "'.$filter.'" ';
				}
			}

			

			if(isset($_SESSION[$this -> prefix.'sort_field']))
			{
				$sort_field = $_SESSION[$this -> prefix.'sort_field'];
				$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
				$sort_direct = $sort_direct?$sort_direct:'asc';
				$ordering = '';
				if($sort_field)
					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
			}
			
			if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";


			$wrap_id_warehouses = $this->get_wrap_id_warehouses();
			$where .= ' AND warehouse_id IN ('.$wrap_id_warehouses.')';

			if($_SESSION['ad_groupid'] == 1){
				$where .= ' AND list_user_id_manage_shop LIKE "%,'.$_SESSION['ad_userid'].',%"';
			}


			$where2 = $where;
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND tracking_code LIKE '%".$keysearch."%' OR code LIKE '%".$keysearch."%' " . $where2;
				}
			}

			

			$query = "SELECT * FROM ".$this -> table_name." AS a WHERE 1=1 " . $where. $ordering. " ";
			return $query;
		}

		function setQueryExportNhat()
		{
			// ordering
			$ordering = '';
			$where = "  ";

			// from
			if(isset($_SESSION[$this -> prefix.'text0']))
			{
				$date_from = $_SESSION[$this -> prefix.'text0'];
				if($date_from){
					$date_from = strtotime($date_from);
					$date_new = date('Y-m-d',$date_from);
					$where .= ' AND a.date =  "'.$date_new.'" ';
				}
			}
			
				// to
			// if(isset($_SESSION[$this -> prefix.'text1']))
			// {
			// 	$date_to = $_SESSION[$this -> prefix.'text1'];
			// 	if($date_to){
			// 		$date_to = $date_to . ' 23:59:59';
			// 		$date_to = strtotime($date_to);
			// 		$date_new = date('Y-m-d H:i:s',$date_to);
			// 		$where .= ' AND a.date <=  "'.$date_new.'" ';
			// 	}
			// }

			if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter){
					
					$where .= ' AND a.house_id =  "'.$filter.'" ';
				}
			}


			if(isset($_SESSION[$this -> prefix.'filter1'])){
				$filter = $_SESSION[$this -> prefix.'filter1'];
				if($filter){
					
					$where .= ' AND a.warehouse_id =  "'.$filter.'" ';
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter2'])){
				$filter = $_SESSION[$this -> prefix.'filter2'];
				if($filter){
					
					$where .= ' AND a.platform_id =  "'.$filter.'" ';
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter3'])){
				$filter = $_SESSION[$this -> prefix.'filter3'];
				if($filter){
					$where .= ' AND a.shipping_unit_id =  "'.$filter.'" ';
				}
			}

			

			if(isset($_SESSION[$this -> prefix.'sort_field']))
			{
				$sort_field = $_SESSION[$this -> prefix.'sort_field'];
				$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
				$sort_direct = $sort_direct?$sort_direct:'asc';
				$ordering = '';
				if($sort_field)
					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
			}
			
			
			$ordering .= " ORDER BY sku_fisrt ASC,ABS(sku_fisrt),sku_last ASC,ABS(sku_last),color ASC,ABS(color),size ASC,ABS(size),created_time DESC , id DESC ";
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND tracking_code LIKE '%".$keysearch."%'";
				}
			}
			$users = $this -> get_record('id = ' . $_SESSION['ad_userid'],'fs_users');
			if($users->group_id == 1){
				$where .= " AND user_id = ".$_SESSION['ad_userid'];
			}


			$wrap_id_warehouses = $this->get_wrap_id_warehouses();
			$where .= ' AND warehouse_id IN ('.$wrap_id_warehouses.')';

			$query = "SELECT * FROM ".$this -> table_name." AS a WHERE 1=1 AND is_print = 1 AND is_shoot = 0 AND is_refund = 0 " . $where. $ordering. " ";


			// $query = "SELECT id,count,product_id,sku,product_name,`date`,color,size,is_print,is_shoot,is_refund,house_id,warehouse_id,platform_id,shipping_unit_id FROM ".$this -> table_name." AS a WHERE 1=1 AND is_print = 1 AND is_shoot = 0 AND is_refund = 0 " . $where. $ordering. " ";

			return $query;
		}


		function setQueryExportTong()
		{
			$link = FSRoute::_('index.php?module='.$this -> module.'&view='.$this -> view);	
			// ordering
			$ordering = '';
			$where = "  ";

			// from
			if(isset($_SESSION[$this -> prefix.'text0']))
			{
				$date_from = $_SESSION[$this -> prefix.'text0'];
				if($date_from){
					$date_from = strtotime($date_from);
					$date_new = date('Y-m-d',$date_from);
					$where .= ' AND a.date =  "'.$date_new.'" ';
				}
			}
			
			
			if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter){
					
					$where .= ' AND a.house_id =  "'.$filter.'" ';
				}
			}


			if(isset($_SESSION[$this -> prefix.'filter1'])){
				$filter = $_SESSION[$this -> prefix.'filter1'];
				if($filter){
					
					$where .= ' AND a.warehouse_id =  "'.$filter.'" ';
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter2'])){
				$filter = $_SESSION[$this -> prefix.'filter2'];
				if($filter){
					
					$where .= ' AND a.platform_id =  "'.$filter.'" ';
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter3'])){
				$filter = $_SESSION[$this -> prefix.'filter3'];
				if($filter){
					$where .= ' AND a.shipping_unit_id =  "'.$filter.'" ';
				}
			}

			if(!isset($_SESSION[$this -> prefix.'text0']) || $_SESSION[$this -> prefix.'text0'] == '' || !isset($_SESSION[$this -> prefix.'filter2']) || $_SESSION[$this -> prefix.'filter2'] == 0){
				setRedirect($link,FSText :: _('Vui lòng chọn Ngày và Sàn trước khi xuất file'),'error');
			}


			if(isset($_SESSION[$this -> prefix.'sort_field']))
			{
				$sort_field = $_SESSION[$this -> prefix.'sort_field'];
				$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
				$sort_direct = $sort_direct?$sort_direct:'asc';
				$ordering = '';
				if($sort_field)
					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
			}
			
			$ordering .= " ORDER BY sku_fisrt ASC,ABS(sku_fisrt),sku_last ASC,ABS(sku_last),color ASC,ABS(color),size ASC,ABS(size),created_time DESC , id DESC ";
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND tracking_code LIKE '%".$keysearch."%'";
				}
			}
			$users = $this -> get_record('id = ' . $_SESSION['ad_userid'],'fs_users');
			if($users->group_id == 1){
				$where .= " AND user_id = ".$_SESSION['ad_userid'];
			}
			//$query = "SELECT id,SUM(count) as total,product_id,sku,product_name,`date`,is_print,house_id,warehouse_id,platform_id,shipping_unit_id FROM ".$this -> table_name." AS a GROUP BY product_id HAVING 1=1 AND is_print = 1 " . $where. $ordering. " ";
			$wrap_id_warehouses = $this->get_wrap_id_warehouses();
			$where .= ' AND warehouse_id IN ('.$wrap_id_warehouses.')';
			
			$query = "SELECT id,count,product_id,sku,product_name,`date`,is_print,house_id,warehouse_id,platform_id,shipping_unit_id FROM ".$this -> table_name." AS a where 1=1 AND is_print = 1 " . $where. $ordering. " ";

			
			return $query;
		}


		function setQueryExportTongDetail()
		{
			$link = FSRoute::_('index.php?module='.$this -> module.'&view='.$this -> view);	
			// ordering
			$ordering = '';
			$where = "  ";

			// from
			if(isset($_SESSION[$this -> prefix.'text0']))
			{
				$date_from = $_SESSION[$this -> prefix.'text0'];
				if($date_from){
					$date_from = strtotime($date_from);
					$date_new = date('Y-m-d',$date_from);
					$where .= ' AND a.date =  "'.$date_new.'" ';
				}
			}
			
			
			if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter){
					
					$where .= ' AND a.house_id =  "'.$filter.'" ';
				}
			}


			if(isset($_SESSION[$this -> prefix.'filter1'])){
				$filter = $_SESSION[$this -> prefix.'filter1'];
				if($filter){
					
					$where .= ' AND a.warehouse_id =  "'.$filter.'" ';
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter2'])){
				$filter = $_SESSION[$this -> prefix.'filter2'];
				if($filter){
					
					$where .= ' AND a.platform_id =  "'.$filter.'" ';
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter3'])){
				$filter = $_SESSION[$this -> prefix.'filter3'];
				if($filter){
					$where .= ' AND a.shipping_unit_id =  "'.$filter.'" ';
				}
			}

			if(!isset($_SESSION[$this -> prefix.'text0']) || $_SESSION[$this -> prefix.'text0'] == '' || !isset($_SESSION[$this -> prefix.'filter2']) || $_SESSION[$this -> prefix.'filter2'] == 0){
				setRedirect($link,FSText :: _('Vui lòng chọn Ngày và Sàn trước khi xuất file'),'error');
			}


			$ordering .= " ORDER BY sku_fisrt ASC,ABS(sku_fisrt),sku_last ASC,ABS(sku_last),color ASC,ABS(color),size ASC,ABS(size),created_time DESC , id DESC ";
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND tracking_code LIKE '%".$keysearch."%' ";
				}
			}
			$users = $this -> get_record('id = ' . $_SESSION['ad_userid'],'fs_users');
			if($users->group_id == 1){
				$where .= " AND user_id = ".$_SESSION['ad_userid'];
			}
			$query = "SELECT * FROM ".$this -> table_name." AS a  WHERE 1=1 AND is_print = 1 " . $where. $ordering. " ";
			return $query;
		}


		function get_excel_nhat($start = 0,$end = 0){
			global $db;
			$query = $this->setQueryExportNhat();
			if(!$query)
				return array();
			$sql = $db->query_limit_export($query,$start,$end);
			$result = $db->getObjectList();
			return $result;
		}

		function show_product_combo($id_product){
		    
		    global $db;
		    $query =  "SELECT code_combo FROM fs_products AS a where 1=1 AND id = ".$id_product;
		    $sql  = $db->query($query);
	        $result = $db->getObjectList();
		    return $result;
		    
		}


		function get_excel_tong(){
			global $db;
			$query = $this->setQueryExportTong();

			$user = $_SESSION['ad_userid'];

			if($user==9){
				echo "<pre>";
					print_r($query);
				echo "</pre>";
				die;

			}

			if(!$query)
				return array();
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}

		function get_list_detail_tong(){
			global $db;
			$query = $this->setQueryExportTongDetail();

			if(!$query)
				return array();
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}

		


		

	}
	
?>