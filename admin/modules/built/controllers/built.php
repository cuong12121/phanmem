<?php
class BuiltControllersBuilt  extends Controllers
{
	function __construct()
	{
		$this->view = 'built' ; 
		parent::__construct(); 
		$array_status = array( 0 => 'Chưa hoàn tất',1 => 'Đã hoàn tất',2=>'Đã hủy');
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
		
		$list = $this -> model->get_data();
		

		$array_status = $this -> arr_status;
		$array_obj_status = array();
		foreach($array_status as $key => $name){
			$array_obj_status[] = (object)array('id'=>($key+1),'name'=>$name);
		}

		$pagination = $this -> model->getPagination();
		// $warehouse = $model->get_warehouse ();
		// $payment_method = $model->get_payment_method();
		$order_type = $model->get_records ('','fs_order_type');

		include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
	}
	function add() {
		$model = $this->model;
		// $warehouse = $model->get_warehouse ();
		// $payment_method = $model->get_payment_method();
		// $order_type = $model->get_records ('','fs_order_type');
		$categories_filter = $model->get_records('published = 1 AND level = 0','fs_products_categories');
		$categories = $model->get_categories_tree();
		// data from fs_news_categories
		$maxOrdering = $model->getMaxOrdering ();
		include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
	}
	function edit()
	{
		$ids = FSInput::get('id',array(),'array');
		$id = $ids[0];
		$model = $this->model;
		$data = $model->get_record_by_id($id);
		// $warehouse = $model->get_warehouse ();
		// $payment_method = $model->get_payment_method();
		$categories_filter = $model->get_records('published = 1 AND level = 0','fs_products_categories');
		$categories = $model->get_categories_tree();
		// printr($categories);
		// $order_type = $model->get_records ('','fs_order_type');
		// $products_related = $model -> get_products_related($data -> products_id);
		$maxOrdering = $model->getMaxOrdering ();

		$order_items = $model->get_order_items( $data->id );
		// echo "<pre>";
		// print_r($order_items);
		// die;

		$config = $model->getConfig();

		include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
	}
	function ajax_get_products_related(){
		
		$model = $this -> model;
		$data = $model->ajax_get_products_related();
		$html = $this -> products_genarate_related($data);
		echo $html;
		return;
	}
	function ajax_remove_order_item(){
		$model = $this -> model;
		$data = $model->ajax_remove_order_item();
		echo $data;
		return;
	}


	function ajax_change_count_item(){
		$model = $this -> model;
		$data = $model->ajax_change_count_item();
		echo $data;
		return;
	}

	
	function products_genarate_related($data){
		$str_exist = FSInput::get('str_exist');
		$html = '';
			$html .= '<div class="products_related">';
			foreach ($data as $item){
				
				$html .= '<div class="products_item_select" data-id="'.$item->id.'" data-name="'.$item->name.'" data-price="'.$item->price.'" onclick="javascript: set_products_to_input(this)" >';	
				$html .= $item -> name;				
				$html .= '</div>';	
				
			}
			$html .= '</div>';
			return $html;
	}

	function cancel_order(){
		$model = $this -> model;

		$rs  = $model -> cancel_order();

		$Itemid = 61;	
		$id = FSInput::get('id');
		$link = 'index.php?module=order&view=order&task=edit&id='.$id;
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
		$link = 'index.php?module=order&view=order&task=edit&id='.$id;
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
		$id = $_GET['id'];
		if(!$id){
			return false;
		}
		setRedirect('index.php?module='.$this -> module.'&view='.$this -> view.'&task=export_file&raw=1&id='.$id);
	}

	function export_file(){
		FSFactory::include_class('excel','excel');
		$model  = $this -> model;
		$filename = 'Bao-gia-'.date('d-m-Y');
		$id = $_GET['id'];
		
		$data = $model->get_record_by_id($id);
		
		if(empty($data)){
			echo 'error';
			exit;
		}else {
			$list = $model->get_records('order_id = ' . $id,'fs_built_items');
			// printr($list);
			// $excel = FSExcel();
			// $excel->set_params(array('out_put_xls'=>'export/excel/'.$filename.'.xls','out_put_xlsx'=>'export/excel/'.$filename.'.xlsx'));

			// foreach ($list as $item){
			// 	$key = isset($key)?($key+1):2;
			// 	$excel->obj_php_excel->getActiveSheet()->setCellValue('A'.$key, 'DH'.str_pad($item -> id, 8 , "0", STR_PAD_LEFT) );
			// 	$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.$key, $item->sender_name);
			// 	$excel->obj_php_excel->getActiveSheet()->setCellValue('C'.$key, $item->sender_telephone);
			// 	$excel->obj_php_excel->getActiveSheet()->setCellValue('D'.$key, $str_all_name);
			// 	$excel->obj_php_excel->getActiveSheet()->setCellValue('E'.$key, format_money($item -> total_after_discount));
			// 	$excel->obj_php_excel->getActiveSheet()->setCellValue('F'.$key, $item->created_time);
			// 	$excel->obj_php_excel->getActiveSheet()->setCellValue('G'.$key, $item->products_count);
			// 	$excel->obj_php_excel->getActiveSheet()->setCellValue('H'.$key, $item->sender_comments);
			// 	$excel->obj_php_excel->getActiveSheet()->setCellValue('I'.$key, $item->sender_address);
			// }

			// $excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
			// $excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
			// $excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
			// $excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray( $style_header );
			// $excel->obj_php_excel->getActiveSheet()->duplicateStyle( $excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:J1' );

			// $output = $excel->write_files();

			// $path_file =   PATH_ADMINISTRATOR.DS.str_replace('/',DS, $output['xls']);
			// header("Pragma: public");
			// header("Expires: 0");
			// header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			// header("Cache-Control: private",false);			
			// header("Content-type: application/force-download");			
			// header("Content-Disposition: attachment; filename=\"".$filename.'.xls'."\";" );			
			// header("Content-Transfer-Encoding: binary");
			// header("Content-Length: ".filesize($path_file));
			// echo $link_excel = URL_ROOT.LINK_AMIN.'/export/excel/'. $filename.'.xls';
			// setRedirect($link_excel);
			// readfile($path_file);

			$excel = FSExcel ();
			$excel->set_params(array('out_put_xls'=>'export/excel/'.$filename.'.xls','out_put_xlsx'=>'export/excel/'.$filename.'.xlsx'));

			$style_header = array (
				// 'fill' => array ('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array ('rgb' => 'fff' ) ), 'font' => array ('bold' => true )
			);
			$style_header1 = array (
				// 'font' => array ('bold' => true ) 
			);

			$style_total = array (
				// 'fill' => array ('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array ('rgb' => 'fc0203' ) ), 'font' => array ('bold' => true, 'color' => array('rgb' => 'ffffff') )
			);
			$style_title = array(
				// 'font' => array(
				// 	'size' => 18,
				// 	'bold' => true,
				// 	'color' => array('rgb' => 'ff0000')
				// )
			);
			$style_tt = array(
				// 'font' => array(
				// 	'size' => 20,
				// 	'bold' => true,
				// 	'color' => array('rgb' => '000'),
				// 	'center' => 'true',
				// )
			);
			$style_wh = array(
				// 'font' => array(
				// 	'size' => 16,
				// 	'bold' => true,
				// 	'color' => array('rgb' => 'ffffff'),
				// 	'center' => 'true',
				// )
			);

			$border_none = array('borders' => array('allborders' => array('style' => 
				PHPExcel_Style_Border::BORDER_DOUBLE, 'color' => array('rgb' => 'fffffff'))));
			$border_b = array('borders' => array('allborders' => array('style' => 
				PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000'))));
			$border_top = array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '222222')));

			$border_none_top = array('borders' => array('top' => array('style' => 
				PHPExcel_Style_Border::BORDER_DOUBLE, 'color' => array('rgb' => 'fffffff'))));


			$styleArray = array(
			   'font'  => array(
			   		'bold'  => true,
			        'color' => array('rgb' => 'FF0000'),
			        'size'  => 13,
			        'name'  => 'Times New Roman'
			));      
			
			// $phpExcel = new PHPExcel();
			// $phpExcel->getActiveSheet()->getDefaultStyle()->applyFromArray ($styleArray);

			// $excel->obj_php_excel->getActiveSheet ()->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


			$excel->obj_php_excel->getActiveSheet ()->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

			// $excel->obj_php_excel->getActiveSheet ()->getDefaultStyle()->applyFromArray ( $border_none );

			// $excel->obj_php_excel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Times New Roman');

			// $excel->obj_php_excel->getActiveSheet ()->getDefaultStyle()->getAlignment()->setWrapText(true);

			$excel->obj_php_excel->getActiveSheet()->getStyle('A2:J100')->getFont()->setSize(13);
			
			$excel->obj_php_excel->getActiveSheet ()->getColumnDimension('A')->setWidth ( 6 );
			// $excel->obj_php_excel->getActiveSheet ()->getRowDimension('A')->setRowHeight(40);

			$excel->obj_php_excel->getActiveSheet ()->getColumnDimension ( 'B' )->setWidth ( 25 );
			$excel->obj_php_excel->getActiveSheet ()->getColumnDimension ( 'C' )->setWidth ( 10 );
			$excel->obj_php_excel->getActiveSheet ()->getColumnDimension ( 'D' )->setWidth ( 15 );
			$excel->obj_php_excel->getActiveSheet ()->getColumnDimension ( 'E' )->setWidth ( 10 );
			$excel->obj_php_excel->getActiveSheet ()->getColumnDimension ( 'F' )->setWidth ( 15 );
			$excel->obj_php_excel->getActiveSheet ()->getColumnDimension ( 'G' )->setWidth ( 15 );
			$excel->obj_php_excel->getActiveSheet ()->getColumnDimension ( 'H' )->setWidth ( 18 );
			$excel->obj_php_excel->getActiveSheet ()->getColumnDimension ( 'I' )->setWidth ( 20 );
			$excel->obj_php_excel->getActiveSheet ()->getColumnDimension ( 'J' )->setWidth ( 15 );

			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setName('setName');
			$objDrawing->setDescription('setDescription');
			$logo_URL =	PATH_BASE.'images/config/logo_excel.png'; // DIR chứ không phải URL
			$objDrawing->setPath($logo_URL);
			$objDrawing->setCoordinates('A1');
			$objDrawing->setWorksheet($excel->obj_php_excel->getActiveSheet());

			$excel->obj_php_excel->getActiveSheet()->mergeCells('A1:B5');
			


			$excel->obj_php_excel->getActiveSheet()->mergeCells('C1:J1');
			$excel->obj_php_excel->getActiveSheet ()->setCellValue ('C1', 'CÔNG TY TNHH KINH DOANH THƯƠNG MẠI HẢI LINH');


			$excel->obj_php_excel->getActiveSheet ()->getStyle ('C3:J3')->applyFromArray ( $border_none_top );
			$excel->obj_php_excel->getActiveSheet()->getStyle('A1:B5')->applyFromArray ( array('borders' => array('allborders' => array('style' => 
				PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => 'd4d4d4')))) );

			$excel->obj_php_excel->getActiveSheet()->getStyle('K2:K3')->applyFromArray ( array('borders' => array('allborders' => array('style' => 
				PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => 'd4d4d4')))) );

			$excel->obj_php_excel->getActiveSheet()->mergeCells('C2:J2');
			$excel->obj_php_excel->getActiveSheet ()->setCellValue ('C2', 'VPGD: Tầng 3, CT2&3 Chung cư Dream Town - Tây Mỗ - Nam Từ Liêm - HN;');
			$excel->obj_php_excel->getActiveSheet()->mergeCells('C3:J3');
			$excel->obj_php_excel->getActiveSheet ()->setCellValue ('C3', 'Tổng kho: KCN Phú Minh - Cổ Nhuế - Bắc Từ Liêm - Hà Nội');

			$excel->obj_php_excel->getActiveSheet()->mergeCells('C4:J4');
			$excel->obj_php_excel->getActiveSheet ()->setCellValue ('C4', 'Hotline: 1900 599 828 Ext 2');
			$excel->obj_php_excel->getActiveSheet()->mergeCells('C5:J5');
			$excel->obj_php_excel->getActiveSheet ()->setCellValue ('C5', 'Website: www.hailinh.com.vn;   Email: info@hailinh.com.vn');
			$excel->obj_php_excel->getActiveSheet()->mergeCells('I6:J6');
			$excel->obj_php_excel->getActiveSheet ()->setCellValue ('I6', 'Mẫu số: 005/BBG/HL');
			$excel->obj_php_excel->getActiveSheet()->getStyle('I6')->getFont()->setSize(11);
			$excel->obj_php_excel->getActiveSheet()->mergeCells('A7:J7');
			$excel->obj_php_excel->getActiveSheet ()->setCellValue ('I8', 'Số: ……./'.date('Y'));
			$excel->obj_php_excel->getActiveSheet()->getStyle('I8')->getFont()->setBold(true);
			$excel->obj_php_excel->getActiveSheet()->getStyle('I8')->getFont()->setItalic(true);

			$excel->obj_php_excel->getActiveSheet()->getStyle('B9')->getFont()->setSize(16);
			$excel->obj_php_excel->getActiveSheet()->getStyle('C9:J10')->getFont()->setSize(14);
			$excel->obj_php_excel->getActiveSheet()->getStyle('B9')->getFont()->setItalic(true);
			$excel->obj_php_excel->getActiveSheet()->getStyle('B9:J10')->getFont()->setBold(true);

			$excel->obj_php_excel->getActiveSheet ()->getStyle('B9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$excel->obj_php_excel->getActiveSheet()->setCellValue ('B9', 'Kính gửi:');
			$excel->obj_php_excel->getActiveSheet()->mergeCells('C9:H9');
			$excel->obj_php_excel->getActiveSheet ()->setCellValue ('C9', $data->sender_title);
			$excel->obj_php_excel->getActiveSheet()->mergeCells('C10:I10');
			$excel->obj_php_excel->getActiveSheet ()->setCellValue ('C10', 'Người liên hệ: '.$data->sender_name);

			$excel->obj_php_excel->getActiveSheet()->mergeCells('A11:J11');
			$excel->obj_php_excel->getActiveSheet()->getStyle('A11:J11')->getFont()->setItalic(true);
			$excel->obj_php_excel->getActiveSheet ()->setCellValue ('A11', 'Công ty TNHH Kinh Doanh Thương Mại Hải Linh, chân thành cảm ơn sự quan tâm của Quý Khách hàng đối với sản phẩm do chúng tôi cung cấp. Với mong muốn, mang đến Quý khách hàng các sản phẩm chất lượng và giá tốt nhất kèm dịch vụ linh hoạt, chúng tôi xin gửi tới Quý Khách hàng bảng báo giá sản phẩm theo yêu cầu như sau:');

			$excel->obj_php_excel->getActiveSheet()->getRowDimension(11)->setRowHeight(60);
			$excel->obj_php_excel->getActiveSheet()->getRowDimension(12)->setRowHeight(34);
			$excel->obj_php_excel->getActiveSheet()->getStyle('A12:J12')->getFont()->setBold(true);
			$excel->obj_php_excel->getActiveSheet()->getStyle('A12:J12')->getFont()->setSize(11);
			$excel->obj_php_excel->getActiveSheet ()->getStyle('A12:J12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$excel->obj_php_excel->getActiveSheet ()->getStyle ('A12:J12')->applyFromArray ( $border_b );
			$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'A12', 'STT' );
			$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'B12', 'MÔ TẢ');
			$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'C12', 'HÃNG');
			$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'D12', 'MÃ HÀNG');
			$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'E12', 'ĐƠN VỊ');
			$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'F12', 'SỐ LƯỢNG');
			$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'G12', 'ĐƠN GIÁ');
			$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'H12', 'THÀNH TIỀN');
			$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'I12', 'HÌNH ẢNH');
			$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'J12', 'GHI CHÚ');

			$i = 0;
			$total_money = 0;
			$total_quantity = 0;

			foreach($list as $built_it){
				$item = $model->get_record('id = '. $built_it-> product_id,'fs_products');
				$total_money += $item->price;
				// printr($item);
				$link = FSRoute::_('index.php?module=products&view=product&code='.$item -> alias.'&ccode='.$item->category_alias.'&id='.$item->id.'&cid='.$item->category_id.'&Itemid=35');
				$key = isset ( $key ) ? ($key + 1) : 13;
				$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'A' . $key, ($i + 1) );
				// echo PATH_BASE.str_replace('/',DS, str_replace('/original/','/resized/', $item->image));
				// die;
				$objDrawing = new PHPExcel_Worksheet_Drawing();
				$objDrawing->setName('PHPExcel logo');
				$objDrawing->setDescription('PHPExcel logo');
				$objDrawing->setPath(PATH_BASE.str_replace('/',DS, str_replace('/original/','/resized/', $item->image)));
				$objDrawing->setHeight(80); 
				$objDrawing->setWidth(80);
				$objDrawing->setOffsetX(10); 
				$objDrawing->setOffsetY(10); 
				$objDrawing->setCoordinates('I'.($i+13)); //want to insert image in C33
				$objDrawing->setWorksheet($excel->obj_php_excel->getActiveSheet());


				$excel->obj_php_excel->getActiveSheet ()->getStyle ( 'A'.($i+13).':J'.($i+13) )->applyFromArray ( $border_b );
				$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'B' . $key, $item-> name );
				$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'C' . $key, $item-> manufactory_name );
				$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'D' . $key, $item-> code );
				// $excel->obj_php_excel->getActiveSheet ()->getCell('I'.$key)->getHyperlink()->setUrl($link);
				$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'E' . $key, $built_it-> unit );
				$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'F' . $key, $built_it-> count );
				$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'G' . $key, format_money($built_it -> price) );
				$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'H' . $key, format_money($built_it -> total ));
				$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'J' . $key, $built_it -> note );
				$excel->obj_php_excel->getActiveSheet ()->getRowDimension ( $i + 13 )->setRowHeight ( 100 );


				// $excel->obj_php_excel->getActiveSheet ()->getStyle( 'A'.($i+13).':J'.($i+13) )->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$excel->obj_php_excel->getActiveSheet ()->getStyle( 'A'.($i+13))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$excel->obj_php_excel->getActiveSheet ()->getStyle( 'E'.($i+13))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$excel->obj_php_excel->getActiveSheet ()->getStyle( 'F'.($i+13))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$i ++;
			}
			
			$r=$i+13;
			$t=$i+14;
			$tr=$i+15;
			// echo $r;
			// die;
			$excel->obj_php_excel->getActiveSheet()->mergeCells( 'A'.$r.':C'.$r);
			$excel->obj_php_excel->getActiveSheet ()->setCellValue('A'.$r, 'TỔNG THANH TOÁN');
			$excel->obj_php_excel->getActiveSheet()->getStyle('A'.$r.':C'.$r)->getFont()->setSize(11);
			$excel->obj_php_excel->getActiveSheet()->getStyle('A'.$r.':C'.$r)->getFont()->setItalic(true);
			$excel->obj_php_excel->getActiveSheet()->getStyle('A'.$r.':C'.$r)->getFont()->setBold(true);
			$excel->obj_php_excel->getActiveSheet()->getRowDimension($r)->setRowHeight(30);
			$excel->obj_php_excel->getActiveSheet ()->getStyle('A'.$r.':C'.$r)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'H'.$r ,format_money($data->total_after_discount));
			

			$excel->obj_php_excel->getActiveSheet()->mergeCells( 'H'.$t.':J'.$t);
			$excel->obj_php_excel->getActiveSheet ()->setCellValue('H'.$t, 'Hà nội, Ngày '.date('d').' tháng '.date('m').' năm ' .date('Y'));
			$excel->obj_php_excel->getActiveSheet()->getStyle('H'.$t.':J'.$t)->getFont()->setBold(true);
			$excel->obj_php_excel->getActiveSheet()->getStyle('H'.$t.':J'.$t)->getFont()->setItalic(true);
			$excel->obj_php_excel->getActiveSheet()->getStyle('H'.$t.':J'.$t)->getFont()->setSize(11);
			$excel->obj_php_excel->getActiveSheet()->getRowDimension($t)->setRowHeight(30);



			$excel->obj_php_excel->getActiveSheet()->setCellValue( 'A'.($t+1),'1.');
			$excel->obj_php_excel->getActiveSheet()->setCellValue( 'A'.($t+2),'2.');
			$excel->obj_php_excel->getActiveSheet()->setCellValue( 'A'.($t+5),'3.');
			$excel->obj_php_excel->getActiveSheet()->setCellValue( 'A'.($t+6),'4.');

			$excel->obj_php_excel->getActiveSheet()->getStyle('A'.($t+1).':A'.($t+6))->getFont()->setBold(true);
			$excel->obj_php_excel->getActiveSheet ()->getStyle('A'.($t+1).':A'.($t+6))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


			$excel->obj_php_excel->getActiveSheet()->mergeCells( 'B'.($t+1).':I'.($t+1));
			$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.($t+1),'Đơn gía trên chưa bao gồm 10% VAT; và bao gồm chi phí vận chuyển đến chân công trình (chưa bao gồm phí bốc dỡ và các chi phí khác,…)');

			$excel->obj_php_excel->getActiveSheet()->mergeCells( 'B'.($t+2).':D'.($t+2));
			$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.($t+2),'Cam kết tiêu chuẩn chất lượng sản phẩm:');
			$excel->obj_php_excel->getActiveSheet()->getStyle('B'.($t+2))->getFont()->setBold(true);


			$excel->obj_php_excel->getActiveSheet()->mergeCells('B'.($t+3).':H'.($t+4));
			$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.($t+3),' - Sản phẩm chính hãng theo đúng tiêu chuẩn chất lượng của nhà sản xuất;
 - Sản phẩm được đóng gói trong hộp cartoon, theo đúng quy cách và tiêu chuẩn của nhà sản xuất.');
			

			$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.($t+5),'Hiệu lực báo giá:');
			$excel->obj_php_excel->getActiveSheet()->getStyle('B'.($t+5))->getFont()->setBold(true);

			$excel->obj_php_excel->getActiveSheet()->mergeCells('C'.($t+5).':G'.($t+5));
			$excel->obj_php_excel->getActiveSheet()->setCellValue('C'.($t+5),'Báo giá có hiệu lực trong vòng 30 ngày kể từ ngày báo giá.');

			$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.($t+6),'Hình thức thanh toán:');
			$excel->obj_php_excel->getActiveSheet()->getStyle('B'.($t+6))->getFont()->setBold(true);

			$excel->obj_php_excel->getActiveSheet()->mergeCells('C'.($t+6).':G'.($t+6));
			$excel->obj_php_excel->getActiveSheet()->setCellValue('C'.($t+6),'Thanh toán trước 100% đơn hàng trước khi giao hàng.');

			$excel->obj_php_excel->getActiveSheet()->mergeCells('B'.($t+7).':E'.($t+7));
			$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.($t+7),'Rất hân hạnh được hợp tác cùng Quý khách hàng !');
			$excel->obj_php_excel->getActiveSheet()->getStyle('B'.($t+7).':E'.($t+7))->getFont()->setItalic(true);
			
			$excel->obj_php_excel->getActiveSheet()->mergeCells('B'.($t+8).':C'.($t+8));
			$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.($t+8),'Trân trọng cảm ơn !');
			$excel->obj_php_excel->getActiveSheet()->getStyle('B'.($t+8).':C'.($t+8))->getFont()->setBold(true);
		
			$excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(30);
			$excel->obj_php_excel->getActiveSheet()->getRowDimension('C2:J3')->setRowHeight(18);
			$excel->obj_php_excel->getActiveSheet()->getRowDimension(4)->setRowHeight(30);
			$excel->obj_php_excel->getActiveSheet()->getRowDimension(5)->setRowHeight(30);
			$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
			$excel->obj_php_excel->getActiveSheet()->getStyle('A1:J200')->getFont()->setName('Times New Roman');
			$excel->obj_php_excel->getActiveSheet()->getStyle('A1:E200')->getAlignment()->setWrapText(true);
    
			$excel->obj_php_excel->getActiveSheet()->getRowDimension(7)->setRowHeight(40);

			$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray( $style_header );
			$excel->obj_php_excel->getActiveSheet()->duplicateStyle( $excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:J1' );

			

			$output = $excel->write_files();

			// printr($output);
			$path_file = PATH_ADMINISTRATOR.DS.str_replace('/',DS, $output['xls']);
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

	function showStatus($status){
		$arr_status = $this -> arr_status;
		return @$arr_status[$status];
	}

	function print_barcode(){
		
		setRedirect(URL_ROOT.'export-print.html');
	}

	
}
	function desc_order_code($controle,$data){

		$estore_code = 'DH';
		$estore_code .= str_pad($data -> id, 8 , "0", STR_PAD_LEFT);
		$link_view = "index.php?module=".$controle -> module."&view=".$controle -> view."&task=edit&id=".$data->id;
		$str = '<a href="'.$link_view.'"  />' .$estore_code.'</a>';
		// if($data -> is_instalment){ 
		// 	$str .= '( Mua trả góp)';
		// }elseif($data -> type == 'fast'){
		// 	$str .= '<strong>( Mua nhanh)<strong>';
		// }
		return $str;
	}
	function showStatus($controle,$status){
		$arr_status = $controle -> arr_status;
		return @$arr_status[$status];
	}

	function get_ajax_search(){
		$model = $this -> model;
        $result =  array();
        $list = $model->get_ajax_search();
        if($list){
            foreach($list as $item){
				$price = calculator_price($item->price,$item->price_old,$item -> is_hotdeal,$item->date_start,$item->date_end);		
                $result[] = array(
                	'value' =>  FSRoute::_('index.php?module=products&view=product&code='.$item->alias.'&id='.$item -> id.'&ccode='.$item->category_alias),
                    'data' => array(
									'text'=>$item->name,
									"brand"=>$item->category_name,
									"price"=>format_money($price['price']),
									"image"=> URL_ROOT.str_replace('/original/', '/resized/', $item->image),
								)
                );
            }
        }
        

        $sugges_result = array( 
		        	'query' =>  FSInput::get('query'),
		        	'suggestions' =>  $result
        			);
        echo json_encode($sugges_result);        			
	}
	
?>