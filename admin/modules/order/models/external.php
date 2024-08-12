<?php 
	class OrderModelsExternal extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'tags';
			$this -> table_name = 'fs_tags';
			parent::__construct();
		}
		
		function setQuery(){
			
			// ordering
			$ordering = "";
			$where = "  ";
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
					$where .= " AND a.name LIKE '%".$keysearch."%' ";
				}
			}
			
			$query = " SELECT a.*
						  FROM 
						  	".$this -> table_name." AS a
						  	WHERE 1=1 ".
						 $where.
						 $ordering. " ";
			return $query;
		}
		
		function bold($value)
		{
			$ids = FSInput::get('id',array(),'array');
			
			if(count($ids))
			{
				global $db;
				$str_ids = implode(',',$ids);
				$sql = " UPDATE ".$this -> table_name."
							SET is_bold = $value
						WHERE id IN ( $str_ids ) " ;
				// $db->query($sql);
				$rows = $db->affected_rows($sql);
				return $rows;
			}
			// 	update sitemap
			if($this -> call_update_sitemap){
				$this -> call_update_sitemap();
			}
			
			return 0;
		}

		function save($row = array(), $use_mysql_real_escape_string = 1){

			$requester = FSInput::get('requester');
			$storeName = FSInput::get('storeName');
			$deliveryPerson = FSInput::get('deliveryPerson');
			$department = FSInput::get('department');
			$storeCode = FSInput::get('storeCode');
			$customerPhone = FSInput::get('customerPhone');
			$customerPhone = FSInput::get('customerPhone');

			$diachinhanhang = FSInput::get('diachinhanhang');

			$tennguoinhan = FSInput::get('tennguoinhan');

			$link = FSRoute::_('index.php?module=order&view=external&task=add');

			

			if($requester==''){
				$msg = 'Không được để trống họ tên người yêu cầu xuất';
				setRedirect($link,$msg,'error');
				header("Location: $link");
				
				die;
			}


			if($storeName==''){
				$msg = 'Không được để trống tên gian hàng';
				setRedirect($link,$msg,'error');
			}
			if($deliveryPerson==''){
				$msg = 'Không được để trống họ tên nvc giao';
				setRedirect($link,$msg,'error');
			}

			if($department==''){
				$msg = 'Không được để trống bộ phận';
				setRedirect($link,$msg,'error');
			}

			if($storeCode==''){
				$msg = 'Không được để trống mã gian hàng';
				setRedirect($link,$msg,'error');
			}

			if($customerPhone==''){
				$msg = 'Không được để trống số điện thoại khách hàng';
				setRedirect($link,$msg,'error');
			}

			if($diachinhanhang==''){
				$msg = 'Không được để trống địa chỉ nhận hàng';
				setRedirect($link,$msg,'error');
			}

			if($tennguoinhan==''){
				$msg = 'Không được để trống tên người nhận hàng';
				setRedirect($link,$msg,'error');
			}	

			
			
		
		}
		
		
	}
	
?>