<?php 
	class ProductsModelsView_amount_hold extends FSModels
	{
		var $limit;
		var $page;
		function __construct()
		{
			$limit = 100;
			$page = FSInput::get('page');
			$this->limit = $limit;
			$this -> table_name = 'fs_order_uploads_detail';
			// $this -> img_folder = 'images/products/types';
			// $this -> arr_img_paths = array(array('resized',0,32,'compress'));
			// $this -> field_img = 'image';
			// $this -> check_alias = 1;
			$this -> table_product = 'fs_products';
			parent::__construct();
		}
		
		function setQuery()
		{
		 	$product_id =  FSInput::get('id');
		 	$warehouse_id = FSInput::get('warehouse_id');
		 	if(!$product_id){
		 		echo "không tồn tại id sản phẩm để check";
		 		die;
		 		return;
		 	}
		 	$date_to = strtotime("2022-10-19 00:00:00");
			$date_to = date('Y-m-d H:i:s',$date_to);
			
			$ordering = '';
			$where = " AND product_id = " .$product_id . " AND is_shoot = 0 AND is_refund = 0 AND created_time > '" . $date_to . "'";
			if($warehouse_id){
				$where .= " AND warehouse_id = " .$warehouse_id;
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
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND tracking_code LIKE '%".$keysearch."%' ";
				}
			}
			
			$query = " 	SELECT * FROM ".$this -> table_name." WHERE 1=1 ". $where . $ordering . " ";
			return $query;
		}
		
		function check_remove(){
			$cids = FSInput::get('id',array(),'array');
			if(!count($cids))
				return true;
			foreach ($cids as $cid){
				if($cid)
					$count = $this -> get_count(' id like "%,'.$cid.',%"');
				if($count)
					return false;
			}
			return true;
		}
	}
	
?>