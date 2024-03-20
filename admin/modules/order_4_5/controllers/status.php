<?php
	class OrderControllersStatus  extends Controllers
	{
		function __construct()
		{
			$this->view = 'status' ; 
			parent::__construct(); 
			// $array_status = array( 0 => 'Mới tiếp nhận',1 => 'Đang xử lý',2=>'Đã chuyển qua kho',3=>'Đã đóng gói',4=>'Đang giao hàng',5=>'Hoàn thành',6=>'Hủy');
			$array_status = array( 0 => 'Mới tiếp nhận',1 => 'Đang xử lý',2=>'Chuyển qua kho đóng gói',4=>'Đang giao hàng',5=>'Hoàn thành',6=>'Hủy');
			$this -> arr_status = $array_status;
		}
		function display()
		{

			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			$text2 = FSInput::get('text2');
			if($text2){
				$_SESSION[$this -> prefix.'text2'] = $text2;
			}
			
			$model  = $this -> model;
		
			// $list = $this -> model->get_data();

			$query_body = $model->set_query_body();
			$list = $model->get_data2($query_body);
			$total = $model->getTotal2($query_body);
			$pagination = $model->getPagination2($total);
			$total_all = $model->getTotalAllPage();
			$total_all_id = $model->getTotalAllId();

			

			$array_status = $this -> arr_status;
			$array_obj_status = array();
			foreach($array_status as $key => $name){
				$array_obj_status[] = (object)array('id'=>($key+1),'name'=>$name);
			}
			
			$order_ids = '';
			foreach($list as $item){
				$order_ids .= $order_ids? ',':'';
				$order_ids .= $item -> id;
			}

			$list_order_details = $model -> get_order_details_by_order($order_ids);
			
		 

			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		function showStatus($status){
			$arr_status = $this -> arr_status;
			echo @$arr_status[$status];

		}
		function edit()
		{
			$model = $this -> model;
			$order  = $model -> getOrderById();
			$data = $model -> get_data_order();
			$config = $model->getConfig();
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}


		function change_satus_order(){
			$model = $this -> model;
			$status = FSInput::get('status',0,'int');
			
			$arr_status = $this -> arr_status;
			$rs = $model -> change_satus_order($status);
			$Itemid = 61;	
			$id = FSInput::get('id');
			$order = $model -> getOrderById($id);
			$link = 'index.php?module=order&view=status&task=edit&id='.$id;
			if(!$rs){
				$msg = 'Không chuyển được trạng thái đơn hàng';
				setRedirect($link,$msg,'error');
			}
			else {
				$msg = 'Đã chuyển trạng thái đơn hàng';

				
				$mailer = FSFactory::getClass('Email','mail');
				$select = 'SELECT * FROM fs_config WHERE published = 1';
				global $db;
				$db -> query($select);
				$config = $db->getObjectListByKey('name');
				// $admin_name  = $config['admin_name']-> value;
				// $admin_email  = $config['admin_email']-> value;
				$site_name  = $config['site_name']-> value;
				
				$mailer -> isHTML(true);
				$mailer -> setSender(array('buixuanthangcntt1@gmail.com','Quản trị viên'));
				$mailer -> AddAddress($order->sender_email,$order->sender_name);
				$mailer -> setSubject($site_name.' - Cập nhập trạng thái đơn hàng');
				// body
				$body = '';
				$body .= '<div>Chào '.$order->sender_name.'!</div>';
				$body .= '<div>Đơn hàng '.'DH'.str_pad($order -> id, 8 , "0", STR_PAD_LEFT).' của bạn đã được chuyển sang trạng thái: '.$arr_status[$status].'</div>';
				$body .= '<div>Xin cảm ơn!</div>';
				// printr($body);			
				$mailer -> setBody($body);
				$mailer ->Send();
				// 	return false;
				// return true;

				setRedirect($link);
			}
		}
		
		function cancel_order(){
			$model = $this -> model;
			
			$rs  = $model -> cancel_order();
			
			$Itemid = 61;	
			$id = FSInput::get('id');
			$link = 'index.php?module=order&view=status&task=edit&id='.$id;
			if(!$rs){
				$msg = 'Không hủy được đơn hàng';
				setRedirect($link,$msg,'error');
			}
			else {
				$msg = 'Đã hủy được đơn hàng';
				setRedirect($link);
			}
		}
		function finished_order(){
			$model = $this -> model;
			$rs  = $model -> finished_order();
			$Itemid = 61;	
			$id = FSInput::get('id');
			$link = 'index.php?module=order&view=status&task=edit&id='.$id;
			if(!$rs){
				$msg = 'Không hoàn tất được đơn hàng';
				setRedirect($link,$msg,'error');
			}
			else {
				$msg = 'Đã hoàn tất được đơn hàng thành công';
				setRedirect($link);
			}
		}


	// Excel toàn bộ danh sách copper ra excel
		function export(){
			setRedirect('index.php?module='.$this -> module.'&view='.$this -> view.'&task=export_file&raw=1');
		}
			
		function export_file(){
			FSFactory::include_class('excel','excel');
			$model  = $this -> model;
			$filename = 'danh_sach_don_hang';
			$list = $model->get_member_info(0,2000);
				// print_r($list);die;
			if(empty($list)){
				echo 'error';exit;
			}else {
				$excel = FSExcel();
				$excel->set_params(array('out_put_xls'=>'export/excel/'.$filename.'.xls','out_put_xlsx'=>'export/excel/'.$filename.'.xlsx'));
				$style_header = array(
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb'=>'ffff00'),
					),
					'font' => array(
						'bold' => true,
					)
				);
				$style_header1 = array(
					'font' => array(
						'bold' => true,
					)
				);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('G')->setWidth(13);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('H')->setWidth(50);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('I')->setWidth(60);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('J')->setWidth(60);
				$excel->obj_php_excel->getActiveSheet()->setCellValue('A1', 'Mã đơn hàng');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('B1', 'Người mua');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('C1', 'Số điện thoại');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('D1', 'Sản phẩm');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('E1', 'Giá trị');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('F1', 'Ngày mua');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('G1', 'Số lượng');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('H1', 'Ghi chú');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('I1', 'Địa chỉ');
				// $excel->obj_php_excel->getActiveSheet()->setCellValue('J1', 'Các trường thêm');

				foreach ($list as $item){
					$string_info_extent = '';
					$products_name = $model->get_data_order_name($item->id);
					$all_name = array();
					$arr_info_extent = array();


					foreach ($products_name as $product_name) {
						$all_name[] = $product_name->product_name;

						$total_price_extent = 0; 
						$arr_extend_item = explode(',',$product_name -> string_info_extent);
						foreach ($arr_extend_item as $extend_item_val ){
							if($extend_item_val != 0){
								$extend_item = $model -> get_record_by_id($extend_item_val,'fs_products_price_extend');

								$arr_info_extent[] = $extend_item-> extend_name . ": " . format_money2($extend_item-> price);
								$total_price_extent  += $extend_item-> price; 
							}
						}

						// echo "<pre>";
						// print_r($product_name);
						// die;
							
						if(!empty($product_name -> color_name)){
							$string_info_extent .= "Màu " .$product_name -> color_name ." ";
						}
						if(!empty($product_name -> color_price)){
							$string_info_extent .= ":".format_money2($product_name-> color_price) .",";
						}
						
				
					}

					if(!empty($arr_info_extent)){
						$string_info_extent .=  implode(' , ',$arr_info_extent);
					}

					
					// echo "<pre>";
					// print_r($item);die;
					// echo $string_info_extent;
					// die;
					$str_all_name = implode(",", $all_name);
					
					
					// echo $string_info_extent;
					// die;
					
					$key = isset($key)?($key+1):2;
					$excel->obj_php_excel->getActiveSheet()->setCellValue('A'.$key, 'DH'.str_pad($item -> id, 8 , "0", STR_PAD_LEFT) );
					$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.$key, $item->sender_name);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('C'.$key, $item->sender_telephone);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('D'.$key, $str_all_name);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('E'.$key, format_money($item -> total_after_discount));
					$excel->obj_php_excel->getActiveSheet()->setCellValue('F'.$key, $item->created_time);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('G'.$key, $item->products_count);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('H'.$key, $item->sender_comments);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('I'.$key, $item->sender_address);

					// $excel->obj_php_excel->getActiveSheet()->setCellValue('J'.$key, $string_info_extent);
				}


				
				$excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray( $style_header );
				$excel->obj_php_excel->getActiveSheet()->duplicateStyle( $excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:J1' );

				$output = $excel->write_files();

				$path_file =   PATH_ADMINISTRATOR.DS.str_replace('/',DS, $output['xls']);
				header("Pragma: public");
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Cache-Control: private",false);			
				header("Content-type: application/force-download");			
				header("Content-Disposition: attachment; filename=\"".$filename.'.xls'."\";" );			
				header("Content-Transfer-Encoding: binary");
				header("Content-Length: ".filesize($path_file));
				echo $link_excel = URL_ROOT.LINK_AMIN.'/export/excel/'. $filename.'.xls';
				setRedirect($link_excel);
				readfile($path_file);
			}
		}
	}
	
?>