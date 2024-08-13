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

			if (!isset($_SESSION)) {
			    session_start();
			} 
			$link = $_SERVER['HTTP_REFERER'];

			$inputData = $_POST;

			// Lưu dữ liệu nhập liệu vào session
			$_SESSION['input_data'] = $inputData;

			$number = FSInput::get('number');


			$requester = FSInput::get('requester');
			$storeName = FSInput::get('storeName');
			$deliveryPerson = FSInput::get('deliveryPerson');
			$department = FSInput::get('department');
			$storeCode = FSInput::get('storeCode');
			$customerPhone = FSInput::get('customerPhone');
			$customerPhone = FSInput::get('customerPhone');

			$diachinhanhang = FSInput::get('diachinhanhang');

			$tennguoinhan = FSInput::get('tennguoinhan');

			for ($i=1; $i <= $number; $i++) { 
				$productName = FSInput::get('productName'.$i);

				$productCode = FSInput::get('productCode'.$i);

				$soluong = FSInput::get('soluong'.$i);

				$phivanchuyen = FSInput::get('phivanchuyen'.$i);


				$tongsotiennguoimuathanhtoan = FSInput::get('tongsotiennguoimuathanhtoan'.$i);

				$dongia = FSInput::get('dongia'.$i);

				$thanhtien = FSInput::get('thanhtien'.$i);

				$hotennguoithutien = FSInput::get('hotennguoithutien'.$i);

				if($productName==''){
					$msg = 'Không được để trống tên sản phẩm thứ '.$i;
					setRedirect($link,$msg,'error');
				}

				if($productCode==''){
					$msg = 'Không được để trống mã đơn hàng thứ '.$i;
					setRedirect($link,$msg,'error');
				}

				if($soluong==''){
					$msg = 'Không được để trống Số lượng thứ '.$i;
					setRedirect($link,$msg,'error');
				}

				if($phivanchuyen==''){
					$msg = 'Không được để trống Phí vận chuyển thứ '.$i;
					setRedirect($link,$msg,'error');
				}
				if($tongsotiennguoimuathanhtoan==''){
					$msg = 'Không được để trống Tổng số tiền người mua thanh toán thứ '.$i;
					setRedirect($link,$msg,'error');
				}

				if($dongia==''){
					$msg = 'Không được để trống đơn giá thứ '.$i;
					setRedirect($link,$msg,'error');
				}

				if($thanhtien==''){
					$msg = 'Không được để trống thành tiền '.$i;
					setRedirect($link,$msg,'error');
				}

				if($hotennguoithutien==''){
					$msg = 'Không được để trống Họ tên người thu tiền '.$i;
					setRedirect($link,$msg,'error');
				}
			}

			// Giả sử dữ liệu nhập liệu được truyền qua $_POST
			
			if($requester==''){

				$msg = 'Không được để trống họ tên người yêu cầu xuất';

				setRedirect($link,$msg,'error');
				
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

			echo"thành công";	

		
		}
		
		
	}
	
?>