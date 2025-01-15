<?php
class ProductsControllersProducts  extends Controllers
{
	function __construct()
	{	
		$this->limit = 20; 
		$this->view = 'products' ; 
		parent::__construct(); 
	}
	function display()
	{
		global $tmpl, $db;
		$model  = $this -> model;
		parent::display();
		$sort_field = $this -> sort_field;
		$sort_direct = $this -> sort_direct;

		$get_template = $_GET['get_template']??'';

		
		// Xác định trang hiện tại (mặc định là trang 1)
		$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
		$page = max($page, 1); // Đảm bảo không có số âm

		if(!empty($get_template)){

			$query = 'SELECT p.*, w.*
	        FROM fs_products AS p
	        LEFT JOIN fs_warehouses_products_total AS w ON p.id = w.product_id
	        WHERE  p.id BETWEEN 37898355 AND 37898669';
	        $result = $db->query_limit($query,50,$page);

	        $list = $db->getObjectList();

	        
	    }
	    else{
	    	$list = $model->get_data();
	    }    

		$categories = $model->get_categories_tree();
		$warehouses = $model -> get_records('published = 1','fs_warehouses');
		$pagination = $model->getPagination();
		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Danh sách sản phẩm', 1 => '');	
		

		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );

		

		

		if(!empty($get_template)){

			include 'modules/'.$this->module.'/views/lists1.php';
		}
		else{
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		
	}

	function SearchBYNamePD()
	{
		

		$page =1;

		$config = require PATH_BASE.'/includes/configs.php';

		$host = $config['dbHost'];
		$dbs = $config['dbName'];
		$user = $config['dbUser'];
		$pass = $config['dbPass'];
		$charset = 'utf8mb4';

		$dsn = "mysql:host=$host;dbname=$dbs;charset=$charset";
		$options = [
		    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		    PDO::ATTR_EMULATE_PREPARES   => false,
		];

		try {
		    $pdo = new PDO($dsn, $user, $pass, $options);
		} catch (\PDOException $e) {
		    throw new \PDOException($e->getMessage(), (int)$e->getCode());
		}


		// Nhận giá trị tìm kiếm từ request (GET hoặc POST)
		$search = isset($_GET['search']) ? trim($_GET['search']) : '';



		// Chuẩn bị truy vấn SQL với Prepared Statements để tránh SQL Injection
		$sql = "SELECT p.*, w.*
		        FROM fs_products AS p
		        LEFT JOIN fs_warehouses_products_total AS w ON p.id = w.product_id
		        WHERE p.id = :search OR p.name LIKE :name_search";

		$stmt = $pdo->prepare($sql);
		dd($stmt);

		// Bind giá trị vào tham số
		$stmt->bindValue(':search', $search, is_numeric($search) ? PDO::PARAM_INT : PDO::PARAM_STR);
		$stmt->bindValue(':name_search', "%$search%", PDO::PARAM_STR);

		// Thực thi truy vấn
		$stmt->execute();



		global $db;

		// Lấy tất cả kết quả
		$list = $stmt->fetchAll(PDO::FETCH_OBJ);

		dd($list);

		

		include 'modules/'.$this->module.'/views/lists1.php';



	}
	
	
	function add()
	{
		$model = $this -> model;
		$manufactories = $model->get_manufactories();
		$status = $model -> get_records('published = 1','fs_products_status');
		$types = $model -> get_records('published = 1','fs_products_types');
		$origins = $model -> get_records('published = 1','fs_products_origins');
		$maxOrdering = $model->getMaxOrdering();
		$categories = $model->get_categories_tree();

		$extend_fields = $model->getExtendFields('fs_products_parameter');
		$data_foreign = $model -> get_data_foreign($extend_fields);


		$module_params = $model -> module_params;
		FSFactory::include_class('parameters');
		$current_parameters = new Parameters($module_params);
		$uploadConfig = base64_encode('add|'.session_id());
		include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
	}

	function edit()
	{
		$ids = FSInput::get('id',array(),'array');
		$id = $ids[0];
		$model = $this -> model;
		$module =$_GET['module'];
		$view= $_GET['view'];
		$permission = FSSecurity::check_permission_other($module, $view, 'edit');
		$data = $model->get_record_by_id($id);

		$manufactories = $model->get_manufactories();
		$status = $model -> get_records('published = 1','fs_products_status');
		$types = $model -> get_records('published = 1','fs_products_types');
		$origins = $model -> get_records('published = 1','fs_products_origins');
		$categories = $model->get_categories_tree();

		$data_ext = $model->getProductExt($data -> tablename,$data->id);
		$extend_fields = $model->getExtendFields('fs_products_parameter');

		$data_foreign = $model -> get_data_foreign($extend_fields);
		$images = $model->get_product_images($data -> id);

		$this->params_form = array('ext_id'=>@$data_ext -> id) ;
		$uploadConfig = base64_encode('edit|'.$id);			
		include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
	}

		function search(){
			$model = $this -> model;

			
			if(isset($_REQUEST['keysearch']) AND !empty($_REQUEST['keysearch']))
			{
				$_SESSION[$this -> prefix.'category_keysearch']  =  $_REQUEST['keysearch']  ;
				$get_menu = $model->get_categories();

				$get_menu_tree = "";
				if(!empty($get_menu)){
					foreach ($get_menu as $key => $item) {
						$link = 'index.php?module=products&view=products&task=add&cid='.$item->id;
						
						$get_menu_tree .="<a class='link_search' href='".$link."'>".$item ->name."</a>";
					}

				}else{
					$get_menu_tree = "Không tìm thấy có kết quả nào.";
				}
				
			}else{

				$get_menu_tree = $this->get_menu_tree(0);
			}
			

			// return $get_menu_tree;
			
			include 'modules/'.$this->module.'/views/'.$this -> view.'/select_categories.php';
		}

		function get_menu_tree($parent_id) 
		{
			
			$model = $this -> model;
			$menu = "";
			$list = $model->get_records('published = 1 AND parent_id =' . $parent_id, 'fs_products_categories','*','name ASC ');
			if(!empty($list)){
				foreach ($list as $key => $item) {
					$link = 'index.php?module=products&view=products&task=add&cid='.$item->id;
					$link = FSRoute::_($link);
					$menu .="<li class='level".$item ->level."'>" ;
					$menu .="<a href='".$link."'>".$item ->name."</a>";
					if(!empty($this->get_menu_tree($item ->id))){
						$menu .="<span>+</span>";
					}
				    $menu .= "<ul class='sub-menu'>".$this->get_menu_tree($item ->id)."</ul>";
		 		    $menu .= "</li>";
				}
			}
		    return $menu;
		}
		
		
		function print_barcode(){
			$ids = FSInput::get('id',array(),'array');
			$str_id = implode(',',$ids);
			$_SESSION['id_all_print'] = $str_id;
			$_SESSION['model_print'] = 'products';
			setRedirect(URL_ROOT.'export-print.html');
		}






		// function cancel()
		// {
		// 	$id = FSInput::get('id',0,'int');
		// 	$model  = $this -> model;
		// 	$model -> assign_without_editing($id);
		// 	$module = FSInput::get('module');
		// 	$view = FSInput::get('view');
		// 	unset($_SESSION[$module][$view]);
		// 	$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
		// 	if($this -> page)
		// 		$link .= '&page='.$this -> page;	
		// 	setRedirect($link);	
		// }
		// function back()
		// {
		// 	$id = FSInput::get('id',0,'int');
		// 	$model  = $this -> model;
		// 	$model -> assign_without_editing($id);
		// 	$module = FSInput::get('module');
		// 	$view = FSInput::get('view');
		// 	unset($_SESSION[$module][$view]);
		// 	$page = FSInput::get('page',0,'int');
		// 	$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
		// 	if($this -> page)
		// 		$link .= '&page='.$this -> page;	
		// 	setRedirect($link);	
		// }
		
		function ajax_get_product_models(){
			$model  = $this -> model;
			$cid = FSInput::get('cid');
			$rs  = $model -> get_product_models($cid);
			
			$json = '['; // start the json array element
			$json_names = array();
			foreach( $rs as $item)
			{
				$json_names[] = "{id: $item->id, name: '$item->name'}";
			}
			$json .= implode(',', $json_names);
			$json .= ']'; // end the json array element
			echo $json;
		}

		function ajax_convert_alias(){
			$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
			$name = FSInput::get('name');
			$alias = $fsstring->stringStandart($name);
			echo $alias;
			return;
		}





		// function export(){
		// 	setRedirect('index.php?module='.$this -> module.'&view='.$this -> view.'&task=export_file&raw=1');
		// }	

		function export(){

			FSFactory::include_class('excel','excel');
			$model  = $this -> model;
			$filename = 'Danh_sach_san_pham';
			$list = $model->get_data_for_export();
			// dd($list);

			if(empty($list)){
				echo 'error';exit;
			}else {
				$excel = FSExcel();
				$excel->set_params(array('out_put_xls'=>'export/excel/'.$filename.'.xlsx','out_put_xlsx'=>'export/excel/'.$filename.'.xlsx'));
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

				$excel->obj_php_excel->getActiveSheet ()->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$excel->obj_php_excel->getActiveSheet ()->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$excel->obj_php_excel->getActiveSheet ()->getDefaultStyle()->getAlignment()->setWrapText(true);
				
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('N')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('O')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('P')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('Q')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('R')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('S')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('T')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('U')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('V')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('W')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('X')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('Y')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('Z')->setWidth(30);
				// $excel->obj_php_excel->getActiveSheet()->getColumnDimension('AA')->setWidth(30);
				// $excel->obj_php_excel->getActiveSheet()->getColumnDimension('AB')->setWidth(30);
				// $excel->obj_php_excel->getActiveSheet()->getColumnDimension('AC')->setWidth(30);
				// $excel->obj_php_excel->getActiveSheet()->getColumnDimension('AD')->setWidth(30);
				// $excel->obj_php_excel->getActiveSheet()->getColumnDimension('AE')->setWidth(30);
				// $excel->obj_php_excel->getActiveSheet()->getColumnDimension('AF')->setWidth(30);

				
				$excel->obj_php_excel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				$excel->obj_php_excel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				$excel->obj_php_excel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				$excel->obj_php_excel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				$excel->obj_php_excel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				$excel->obj_php_excel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				$excel->obj_php_excel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				$excel->obj_php_excel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				$excel->obj_php_excel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				$excel->obj_php_excel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				$excel->obj_php_excel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				$excel->obj_php_excel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				$excel->obj_php_excel->getActiveSheet()->getStyle('M')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				$excel->obj_php_excel->getActiveSheet()->getStyle('N')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				$excel->obj_php_excel->getActiveSheet()->getStyle('O')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				$excel->obj_php_excel->getActiveSheet()->getStyle('P')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				$excel->obj_php_excel->getActiveSheet()->getStyle('Q')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				$excel->obj_php_excel->getActiveSheet()->getStyle('R')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				$excel->obj_php_excel->getActiveSheet()->getStyle('S')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				$excel->obj_php_excel->getActiveSheet()->getStyle('T')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				$excel->obj_php_excel->getActiveSheet()->getStyle('U')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				$excel->obj_php_excel->getActiveSheet()->getStyle('V')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				$excel->obj_php_excel->getActiveSheet()->getStyle('W')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				$excel->obj_php_excel->getActiveSheet()->getStyle('X')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				$excel->obj_php_excel->getActiveSheet()->getStyle('Y')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				$excel->obj_php_excel->getActiveSheet()->getStyle('Z')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				// $excel->obj_php_excel->getActiveSheet()->getStyle('AA')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				// $excel->obj_php_excel->getActiveSheet()->getStyle('AB')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				// $excel->obj_php_excel->getActiveSheet()->getStyle('AC')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				// $excel->obj_php_excel->getActiveSheet()->getStyle('AD')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				// $excel->obj_php_excel->getActiveSheet()->getStyle('AE')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				// $excel->obj_php_excel->getActiveSheet()->getStyle('AF')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
	
				
				
				$excel->obj_php_excel->getActiveSheet()->setCellValue('A1', 'ID');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('B1', 'Tên');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('C1', 'Sản phẩm cha');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('D1', 'Loại');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('E1', 'Trạng thái');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('F1', 'Mã');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('G1', 'Mã vạch');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('H1', 'Giá nhập');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('I1', 'VAT(%)');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('J1', 'Giá bán lẻ');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('K1', 'Giá sỉ');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('L1', 'Giá đón gói');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('M1', 'Giá cũ');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('N1', 'Danh mục');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('O1', 'Thương hiệu');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('P1', 'Khối lượng');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('Q1', 'Đơn vị tính');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('R1', 'Dài');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('S1', 'Rộng');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('T1', 'Cao');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('U1', 'Link hướng dẫn sử dụng');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('V1', 'Ảnh');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('W1', 'Xuất xứ');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('X1', 'Địa chỉ bảo hành');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('Y1', 'Số điện thoại bảo hành');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('Z1', 'Số tháng bảo hành');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('AA1', 'Link video bảo hành');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('AB1', 'Tồn');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('AC1', 'Tổng tồn');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('AD1', 'Tạm giữ');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('AE1', 'Có thể bán');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('AF1', 'Giá bán thấp nhất');
				
				$total_money = 0;
				$total_quantity = 0;
				$i=0;

				$manus = $model -> get_records('','fs_manufactories','id,name','','','id');
				$status = $model -> get_records('','fs_products_status','id,name','','','id');
				$types = $model -> get_records('','fs_products_types','id,name','','','id');
				$origins = $model -> get_records('','fs_products_origins','id,name','','','id');
				$categories = $model -> get_records('','fs_products_categories','id,name','','','id');
	

				foreach ($list as $item){
					$type_name = !empty($types[$item->type_id]) ? $types[$item->type_id]-> name : '';
					$manu_name = !empty($manus[$item->manufactory]) ? $manus[$item->manufactory]-> name : '';
					$status_name = !empty($status[$item->status_id]) ? $status[$item->status_id]-> name : '';
					$origin_name = !empty($origins[$item->origin_id]) ? $origins[$item->origin_id]-> name : '';
					$cat_name = !empty($categories[$item->category_id]) ? $categories[$item->category_id]-> name : '';
					$tong_ton = $this->get_amount_all($item-> id);
					$tam_giu = $this->get_amount_hold($item-> id);

					
					if(!empty($_SESSION [$this->prefix . 'filter1']) && $_SESSION [$this->prefix . 'filter1'] > 0){
						$co_the_ban = $item-> amount_can_by;
					}else{
						$co_the_ban = $this->get_can_buy($item-> id);
					}

					if(strpos($item-> image,'images/products/') !== false){
						$image = URL_ROOT.$item-> image;
					}else{
						$image = $item-> image;
					}

					$key = isset($key)?($key+1):2;
					$excel->obj_php_excel->getActiveSheet()->setCellValue('A'.$key, $item->id);		
					$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.$key, $item->name);	
					$excel->obj_php_excel->getActiveSheet()->setCellValue('C'.$key, $item->parent_id_name); 
					$excel->obj_php_excel->getActiveSheet()->setCellValue('D'.$key, $type_name);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('E'.$key, $status_name);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('F'.$key, $item->code);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('G'.$key, $item->barcode);

					if($_SESSION['ad_groupid'] == 1){
					$excel->obj_php_excel->getActiveSheet()->setCellValue('H'.$key, 0);
					}else{
					$excel->obj_php_excel->getActiveSheet()->setCellValue('H'.$key, $item->import_price);	
					}


					$excel->obj_php_excel->getActiveSheet()->setCellValue('I'.$key, $item->vat);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('J'.$key, $item->price);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('K'.$key, $item->price_wholesale);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('L'.$key, $item->price_pack);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('M'.$key, $item->price_old);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('N'.$key, $cat_name);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('O'.$key, $manu_name);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('P'.$key, $item->shipping_weight);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('Q'.$key, $item->unit);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('R'.$key, $item->length);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('S'.$key, $item->width);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('T'.$key, $item->height);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('U'.$key, $item->tutorial_link);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('V'.$key, $image);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('W'.$key, $origin_name);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('X'.$key, $item->warranty_address);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('Y'.$key, $item->warranty_phone);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('Z'.$key, $item->warranty);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('AA'.$key, $item->warranty_link);

					$excel->obj_php_excel->getActiveSheet()->setCellValue('AB'.$key, $item->amount);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('AC'.$key, $tong_ton);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('AD'.$key, $tam_giu);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('AE'.$key, $co_the_ban);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('AF'.$key, $item->price_min);
					$i ++;
				}

				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray( $style_header );
				$excel->obj_php_excel->getActiveSheet()->duplicateStyle( $excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:AF1');

				$excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(40);
				
//				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getAlignment()->setIndent(1);// padding cell
				
				$output = $excel->write_files();

				
				if(empty($output['xls'])){


					$link = FSRoute::_('index.php?module=products&view=products', FSText :: _('file xuất có vấn đề xin kiểm tra lại'),'error');
					setRedirect($link);
				}

				
				
				$path_file =   PATH_ADMINISTRATOR.DS.str_replace('/',DS, $output['xls']);
				header("Pragma: public");
				header("Expires: 0");
				header("Cache-Control:no-cache, must-revalidate, post-check=0, pre-check=0");
				header("Cache-Control: private",false);		
				header("Content-type: application/force-download");		
				header("Content-Disposition: attachment; filename=\"".$filename.'.xlsx'."\";" );
				header("Content-Transfer-Encoding: binary");
				header("Content-Length: ".filesize($path_file));	

				echo $link_excel = URL_ROOT.LINK_AMIN.'/export/excel/'. $filename.'.xlsx';
				?>
				<?php setRedirect($link_excel); ?>
				<?php 
				readfile($path_file);
			}
		}

		function export_file_vgp(){
			global $config,$tmpl,$is_mobile;
			FSFactory::include_class('excel','excel');
			$model  = $this -> model;

			$filename = 'product-export-'.time();
			//die();

			unset($list);
			$list = $model->get_data_for_export();
			//print_r($list);
			//die();
			$categories = $model -> get_records('','fs_products_categories','id,code,alias,name,tablename','','','id');

			if(empty($list)){
				echo 'error';exit;
			}else {
				$excel = FSExcel();
				$excel->set_params(array('out_put_xls'=>'export/excel/'.$filename.'.xls','out_put_xlsx'=>'export/excel/'.$filename.'.xlsx'));

				$style_header = array ('fill' => array ('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array ('rgb' => 'dddddd' ) ), 'font' => array ('bold' => true ) );
				$style_header1 = array ('font' => array ('bold' => true ) );

				$style_total = array ('fill' => array ('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array ('rgb' => 'fc0203' ) ), 'font' => array ('bold' => true, 'color' => array('rgb' => 'ffffff') ) );
				$style_title = array(
					'font' => array(
						'size' => 18,
						'bold' => true,
						'color' => array('rgb' => '1e5480')
					)
				);
				$style_tt = array(
					'font' => array(
						'size' => 20,
						'bold' => true,
						'color' => array('rgb' => '000'),
						'center' => 'true',
					)
				);
				$style_wh = array(
					'font' => array(
						'size' => 16,
						'bold' => true,
						'color' => array('rgb' => 'ffffff'),
						'center' => 'true',
					)
				);

				$border_none = array('borders' => array('allborders' => array('style' => 
					PHPExcel_Style_Border::BORDER_DOUBLE, 'color' => array('rgb' => 'fffffff'))));
				$border_b = array('borders' => array('allborders' => array('style' => 
					PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => 'eeeeee'))));
				$border_top = array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '222222')));


				$excel->obj_php_excel->getActiveSheet ()->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$excel->obj_php_excel->getActiveSheet ()->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$excel->obj_php_excel->getActiveSheet ()->getDefaultStyle()->applyFromArray ( $border_none );

				$excel->obj_php_excel->getActiveSheet ()->getDefaultStyle()->getAlignment()->setWrapText(true);

				//$excel->obj_php_excel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
				//$excel->obj_php_excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
				//$excel->obj_php_excel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				//$excel->obj_php_excel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );

				$excel->obj_php_excel->getActiveSheet ()->getColumnDimension ( 'A' )->setWidth ( 7 );
				$excel->obj_php_excel->getActiveSheet ()->getColumnDimension ( 'B' )->setWidth ( 8 );
				$excel->obj_php_excel->getActiveSheet ()->getColumnDimension ( 'C' )->setWidth ( 35 );
				$excel->obj_php_excel->getActiveSheet ()->getColumnDimension ( 'D' )->setWidth ( 35 );
				$excel->obj_php_excel->getActiveSheet ()->getColumnDimension ( 'E' )->setWidth ( 40 );
				$excel->obj_php_excel->getActiveSheet ()->getColumnDimension ( 'F' )->setWidth ( 20 );
				$excel->obj_php_excel->getActiveSheet ()->getColumnDimension ( 'G' )->setWidth ( 22 );
				$excel->obj_php_excel->getActiveSheet ()->getColumnDimension ( 'H' )->setWidth ( 22 );

		//		$objDrawing = new PHPExcel_Worksheet_Drawing();
		//		$objDrawing->setName($config['site_name']);
		//		$objDrawing->setDescription($config['meta_des']);
		//	$logo_URL =	PATH_BASE.$config['logo_blue']; // DIR chứ không phải URL
		//$objDrawing->setPath($logo_URL);
		//$objDrawing->setCoordinates('A1');
		//$objDrawing->setWorksheet($excel->obj_php_excel->getActiveSheet());

		//$excel->obj_php_excel->getActiveSheet()->mergeCells('A1:B3');
				$excel->obj_php_excel->getActiveSheet()->mergeCells('D2:H2');
				$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'D2', $config['site_name'] );
				$excel->obj_php_excel->getActiveSheet()->mergeCells('A5:G6');
				$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'A5', 'Bảng báo giá sản phẩm');
				$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'A8', 'STT' );
				$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'B8', 'ID sp' );
				$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'C8', 'Tên sản phẩm' );
				$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'D8', 'URL Hình ảnh' );
				$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'E8', 'URL sản phẩm' );
				$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'F8', 'Danh mục SP' );
				$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'G8', 'Giá chưa chiết khấu (VNĐ)' );
				$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'H8', 'Giá đã chiết khấu (VNĐ)' );

					//				$excel->obj_php_excel->getActiveSheet()->setCellValue('C1', 'Images');
		//$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'H10', 'Đơn giá (VNĐ)' );
		//$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'I10', 'Thành tiền (VNĐ)' );

				$i = 0;
				$total_money = 0;
				$total_quantity = 0;


			//	print_r($list);
			//	die();


				foreach ($list as $item){

					$link = FSRoute::_('index.php?module=products&view=product&code='.$item -> alias.'&ccode='.$item->category_alias.'&id='.$item->id.'&cid='.$item->category_id.'&Itemid=35');
					$link_img = URL_ROOT.$item->image;

					$key = isset ( $key ) ? ($key + 1) : 9;

					$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'A' . $key, ($i + 1) );
					$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'B' . $key, $item->id );
					$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'C' . $key, $item->name );
					$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'D' . $key, $link_img );

					//$objDrawing = new PHPExcel_Worksheet_Drawing();
					//$objDrawing->setName($item-> name);
					//$objDrawing->setDescription($item-> image);
					//$objDrawing->setPath(PATH_BASE.str_replace('/',DS, str_replace('/original/','/resized/', $item->image)));
				//	$objDrawing->setCoordinates('C'.($i+9)); //want to insert image in C33
					//$objDrawing->setResizeProportional(false);
				//	$objDrawing->setHeight(40); 
					//$objDrawing->setWidth(40); 
				//	$objDrawing->setWorksheet($excel->obj_php_excel->getActiveSheet());
					$excel->obj_php_excel->getActiveSheet ()->getStyle ( 'A'.($i+9).':H'.($i+9) )->applyFromArray ( $border_b );

			//$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'C' . $key, $item->code );

					$excel->obj_php_excel->getActiveSheet ()->getCell('C'.$key)->getHyperlink()->setUrl($link);
					$excel->obj_php_excel->getActiveSheet ()->getCell('D'.$key)->getHyperlink()->setUrl($link_img);
					$excel->obj_php_excel->getActiveSheet ()->getCell('E'.$key)->getHyperlink()->setUrl($link);

					$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'E' . $key, $link );

					$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'F' . $key, $item->category_name );
					$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'G' . $key, $item->price_old );
					$excel->obj_php_excel->getActiveSheet ()->setCellValue ( 'H' . $key, $item->price );

			//$excel->obj_php_excel->getActiveSheet ()->getRowDimension ( $i + 11 )->setRowHeight ( 60 );
					$i ++;


					//$key = isset($key)?($key+1):2;
					//$excel->obj_php_excel->getActiveSheet()->setCellValue('A'.$key, $item->id);		
					//$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.$key, $item->name);	

					//$excel->obj_php_excel->getActiveSheet()->getRowDimension($i + 2)->setRowHeight(20);
					//$i ++;
				}

				$t=$i+11;
				$r=$i+9;
				$tr=$i+12;

				$excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
		//$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray( $style_header );
				$excel->obj_php_excel->getActiveSheet()->duplicateStyle( $excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:B1' );

				$excel->obj_php_excel->getActiveSheet()->mergeCells('A4:H4');
				$excel->obj_php_excel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$excel->obj_php_excel->getActiveSheet ()->getRowDimension ( 1 )->setRowHeight ( 20 );
				$excel->obj_php_excel->getActiveSheet ()->getStyle ( 'A8' )->getFont ()->setSize ( 12 );
		// $excel->obj_php_excel->getActiveSheet ()->getStyle ( 'A10' )->get ()->setHeight( 40 );
				$excel->obj_php_excel->getActiveSheet ()->getStyle ( 'A8' )->getFont ()->setName ( 'Arial' );
				$excel->obj_php_excel->getActiveSheet ()->getStyle ( 'A8' )->applyFromArray ( $style_header );
				$excel->obj_php_excel->getActiveSheet ()->duplicateStyle ( $excel->obj_php_excel->getActiveSheet ()->getStyle ( 'A8' ), 'B8:H8' );
				$excel->obj_php_excel->getActiveSheet ()->getRowDimension(8)->setRowHeight(30);
		//$excel->obj_php_excel->getActiveSheet ()->getRowDimension($t)->setRowHeight(20);
		//$excel->obj_php_excel->getActiveSheet ()->getRowDimension($t-2)->setRowHeight(5);

				$excel->obj_php_excel->getActiveSheet ()->getStyle ( 'A5' )->applyFromArray ( $style_tt );
				$excel->obj_php_excel->getActiveSheet ()->getStyle ( 'A5' )->applyFromArray ( $border_top );
				$excel->obj_php_excel->getActiveSheet ()->getStyle ( 'F2' )->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$excel->obj_php_excel->getActiveSheet ()->getStyle ( 'F2:F4' )->applyFromArray ( $border_none );

				$excel->obj_php_excel->getActiveSheet ()->getStyle ( 'F2' )->applyFromArray ( $style_title);
		// $excel->obj_php_excel->getActiveSheet ()->getStyle ('H11:H'.($i+11)) -> getNumberFormat () -> setFormatCode (PHPExcel_Style_NumberFormat::FORMAT_GENERAL);
		// // $excel->obj_php_excel->getActiveSheet ()->getStyle ('I11:I'.($tr)) -> getNumberFormat () -> setFormatCode (PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				$excel->obj_php_excel->getActiveSheet ()->getStyle ('G9:G'.($i+11)) ->getNumberFormat()->setFormatCode('#,##0');

				$excel->obj_php_excel->getActiveSheet ()->getStyle ('H9:H'.($tr)) ->getNumberFormat()->setFormatCode('#,##0');
		//$excel->obj_php_excel->getActiveSheet()->getStyle('E2:E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		//$excel->obj_php_excel->getActiveSheet()->getStyle('G8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


				$output = $excel->write_files();
				$path_file =   PATH_ADMINISTRATOR.DS.str_replace('/',DS, $output['xls']);
				header("Pragma: public");
				header("Expires: 0");
				header("Cache-Control:no-cache, must-revalidate, post-check=0, pre-check=0");
				header("Cache-Control: private",false);		
				header("Content-type: application/force-download");		
				header("Content-Disposition: attachment; filename=\"".$filename.'.xls'."\";" );
				header("Content-Transfer-Encoding: binary");
				header("Content-Length: ".filesize($path_file));	

				echo $link_excel = URL_ROOT.'admin_apmin24new/export/excel/'. $filename.'.xls';
				?>
				<?php setRedirect($link_excel); ?>
				<?php 
				readfile($path_file);
			}
		}
		function export_fileeeee(){
			FSFactory::include_class('excel','excel');
			$model  = $this -> model;
			$filename = 'product-export';
			$list = $model->get_data_for_export();
			$categories = $model -> get_records('','fs_products_categories','id,code,alias,name,tablename','','','id');
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

				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);


				$excel->obj_php_excel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				$excel->obj_php_excel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );



				$excel->obj_php_excel->getActiveSheet()->setCellValue('A1', 'Id');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('B1', 'Name');

				$i = 0;
				$total_money = 0;
				$total_quantity = 0;
				foreach ($list as $item){
					$key = isset($key)?($key+1):2;
					$excel->obj_php_excel->getActiveSheet()->setCellValue('A'.$key, $item->id);		
					$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.$key, $item->name);	

					$excel->obj_php_excel->getActiveSheet()->getRowDimension($i + 2)->setRowHeight(20);
					$i ++;
				}

				$excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray( $style_header );
				$excel->obj_php_excel->getActiveSheet()->duplicateStyle( $excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:B1' );


				$output = $excel->write_files();

				$path_file =   PATH_ADMINISTRATOR.DS.str_replace('/',DS, $output['xls']);
				header("Pragma: public");
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				echo $link_excel = URL_ROOT.'admin_apmin24new/export/excel/'. $filename.'.xls';
				?>
				<?php setRedirect($link_excel); ?>
				<?php 
				header("Cache-Control: private",false);			
				header("Content-type: application/force-download");			
				header("Content-Disposition: attachment; filename=\"".$filename.'.xls'."\";" );			
				header("Content-Transfer-Encoding: binary");
				header("Content-Length: ".filesize($path_file));
				readfile($path_file);
			}
		}
		// remove products_together
		function remove_compatable(){
			$model  = $this -> model;
			if($model -> remove_compatable()){
				echo '1';
				return;
			}else{
				echo '0';
				return;
			}
		}
		// remove products_together
		function remove_incentives(){
			$model  = $this -> model;
			if($model -> remove_incentives()){
				echo '1';
				return;
			}else{
				echo '0';
				return;
			}
		}
		// remove products_together
		function remove_compare(){
			$model  = $this -> model;
			if($model -> remove_compare()){
				echo '1';
				return;
			}else{
				echo '0';
				return;
			}
		}
		function ajax_get_products_related(){
			$model = $this -> model;
			$data = $model->ajax_get_products_related();
			$html = $this -> products_genarate_related($data);
			echo $html;
			return;
		}
		function products_genarate_related($data){
			$str_exist = FSInput::get('str_exist');
			$html = '';
			$html .= '<div class="products_related">';
			foreach ($data as $item){
				if($str_exist && strpos(','.$str_exist.',', ','.$item->id.',') !== false ){
					$html .= '<div class="red products_related_item  products_related_item_'.$item -> id.'" onclick="javascript: set_products_related('.$item->id.')" style="display:none" >';	
					$html .= $item -> name;				
					$html .= '</div>';					
				}else{
					$html .= '<div class="products_related_item  products_related_item_'.$item -> id.'" onclick="javascript: set_products_related('.$item->id.')">';	
					$html .= $item -> name;				
					$html .= '</div>';	
				}
			}
			$html .= '</div>';
			return $html;
		}


		/////combo/////////

		function ajax_get_products_combo(){
			$model = $this -> model;
			$data = $model->ajax_get_products_combo();
			$html = $this -> products_genarate_combo($data);
			echo $html;
			return;
		}

				function ajax_get_memory_related(){
			$model = $this -> model;
			$data = $model->ajax_get_memory_related();
			$html = $this -> memory_genarate_related($data);
			echo $html;
			return;
		}


		function memory_genarate_related($data){
			$str_exist = FSInput::get('str_exist');
			$html = '';
				$html .= '<div class="products_related">';
				foreach ($data as $item){
					if($str_exist && strpos(','.$str_exist.',', ','.$item->id.',') !== false ){
						$html .= '<div class="red products_related_item  products_related_item_'.$item -> id.'" onclick="javascript: set_products_related_pb('.$item->id.')" style="display:none" >';	
						$html .= $item -> name;				
						$html .= '</div>';					
					}else{
						$html .= '<div class="products_related_item  products_related_item_'.$item -> id.'" onclick="javascript: set_products_related_pb('.$item->id.')">';	
						$html .= $item -> name;				
						$html .= '</div>';	
					}
				}
				$html .= '</div>';
				return $html;
		}


		function products_genarate_combo($data){
			$str_exist = FSInput::get('str_exist');
			$html = '';
			$html .= '<div class="products_combo">';
			foreach ($data as $item){
				if($str_exist && strpos(','.$str_exist.',', ','.$item->id.',') !== false ){
					$html .= '<div class="red products_combo_item  products_combo_item_'.$item -> id.'" onclick="javascript: set_products_combo('.$item->id.')" style="display:none" >';	
					$html .= $item -> name;				
					$html .= '</div>';					
				}else{
					$html .= '<div class="products_combo_item  products_combo_item_'.$item -> id.'" onclick="javascript: set_products_combo('.$item->id.')">';	
					$html .= $item -> name;				
					$html .= '</div>';	
				}
			}
			$html .= '</div>';
			return $html;
		}
		/////////end combo//////////

		/***********
		 * products_compatable
		 ************/

		function ajax_get_types_compatable(){
			$product_id = FSInput::get('product_id');
			$model = $this -> model;
			$types_compatables = $model->get_records('published = 1','fs_products_types_compatables','*');
			$html = '';
			$html .= '<select name="types_compatables_'.$product_id.'">';
			foreach ($types_compatables as $types) {
				$html .= '<option value="'.$types-> id.'">'.$types-> name.'</option>';
			}
			$html .= '</select>';
			echo $html;
			return;
		}

		function ajax_get_products_compatable(){
			$model = $this -> model;
			$data = $model->ajax_get_products_compatable();
			$html = $this -> products_genarate_compatable($data);
			echo $html;
			return;
		}


		function products_genarate_compatable($data){
			$str_exist = FSInput::get('str_exist');
			$html = '';
			$html .= '<div class="products_compatable">';

			foreach ( $data as $item ) {
				$price = $item -> price_old ? $item -> price_old: $item -> price;
				$price = format_money($price,'',0);
				if ($str_exist && strpos ( ',' . $str_exist . ',', ',' . $item->id . ',' ) !== false) {
					$html .= '<div class="red products_compatable_item  products_compatable_item_' . $item->id . '" onclick="javascript: set_products_compatable(' . $item->id . ')" style="display:none" >';
				} else {
					$html .= '<div class="products_compatable_item  products_compatable_item_' . $item->id . '" onclick="javascript: set_products_compatable(' . $item->id . ')">';
				}
				$html .= $item->name;
				$html .= '<span class="red">  - <font class="price_product_label" id="price_compatable_'.$item->id.'">'.$price.'</font>đ</span>';
				$html .= '</div>';
			}

			// foreach ($data as $item){
			// 	if($str_exist && strpos(','.$str_exist.',', ','.$item->id.',') !== false ){
			// 		$html .= '<div class="red products_compatable_item  products_compatable_item_'.$item -> id.'" onclick="javascript: set_products_compatable('.$item->id.')" style="display:none" >';	
			// 		$html .= $item -> name;				
			// 		$html .= '</div>';					
			// 	}else{
			// 		$html .= '<div class="products_compatable_item  products_compatable_item_'.$item -> id.'" onclick="javascript: set_products_compatable('.$item->id.')">';	
			// 		$html .= $item -> name;				
			// 		$html .= '</div>';	
			// 	}
			// }


			$html .= '</div>';
			return $html;
		}		/***********
		 * end products_compatable.
		 ************/

		/***********
		 * products_compare
		 ************/
		function ajax_get_products_compare(){
			$model = $this -> model;
			$data = $model->ajax_get_products_compare();
			$html = $this -> products_genarate_compare($data);
			echo $html;
			return;
		}
		function products_genarate_compare($data){
			$str_exist = FSInput::get('str_exist');
			$html = '';
			$html .= '<div class="products_compare">';
			foreach ($data as $item){
				if($str_exist && strpos(','.$str_exist.',', ','.$item->id.',') !== false ){
					$html .= '<div class="red products_compare_item  products_compare_item_'.$item -> id.'" onclick="javascript: set_products_compare('.$item->id.')" style="display:none" >';	
					$html .= $item -> name;				
					$html .= '</div>';					
				}else{
					$html .= '<div class="products_compare_item  products_compare_item_'.$item -> id.'" onclick="javascript: set_products_compare('.$item->id.')">';	
					$html .= $item -> name;				
					$html .= '</div>';	
				}
			}
			$html .= '</div>';
			return $html;
		}		/***********
		 * end products_compare.
		 ************/

		/***********
		 * products_service
		 ************/
		function ajax_get_products_service(){
			$model = $this -> model;
			$data = $model->ajax_get_products_service();
			$html = $this -> products_genarate_service($data);
			echo $html;
			return;
		}
		function products_genarate_service($data){
			$str_exist = FSInput::get('str_exist');
			$html = '';
			$html .= '<div class="products_service">';
			foreach ($data as $item){
				if($str_exist && strpos(','.$str_exist.',', ','.$item->id.',') !== false ){
					$html .= '<div class="red products_service_item  products_service_item_'.$item -> id.'" onclick="javascript: set_products_service('.$item->id.')" style="display:none" >';	
					$html .= $item -> name;				
					$html .= '</div>';					
				}else{
					$html .= '<div class="products_service_item  products_service_item_'.$item -> id.'" onclick="javascript: set_products_service('.$item->id.')">';	
					$html .= $item -> name;				
					$html .= '</div>';	
				}
			}
			$html .= '</div>';
			return $html;
		}		/***********
		 * end products_service.
		 ************/

		/***********
		 * NEWS RELATED
		 ************/
		function ajax_get_news_related(){
			$model = $this -> model;
			$data = $model->ajax_get_news_related();
			$html = $this -> news_genarate_related($data);
			echo $html;
			return;
		}
		function news_genarate_related($data){
			$str_exist = FSInput::get('str_exist');
			$html = '';
			$html .= '<div class="news_related">';
			foreach ($data as $item){
				if($str_exist && strpos(','.$str_exist.',', ','.$item->id.',') !== false ){
					$html .= '<div class="red news_related_item  news_related_item_'.$item -> id.'" onclick="javascript: set_news_related('.$item->id.')" style="display:none" >';	
					$html .= $item -> title;				
					$html .= '</div>';					
				}else{
					$html .= '<div class="news_related_item  news_related_item_'.$item -> id.'" onclick="javascript: set_news_related('.$item->id.')">';	
					$html .= $item -> title;				
					$html .= '</div>';	
				}
			}
			$html .= '</div>';
			return $html;
		}
		/***********
		 * end NEWS RELATED.
		 ************/
		function is_hot()
		{
			$model = $this -> model;
			$rows = $model->is_hot(1);
			$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
			$page = FSInput::get('page',0);
			if($page > 1)
				$link .= '&page='.$page;
			if($rows)
			{
				setRedirect($link,$rows.' '.FSText :: _('record was event'));	
			}
			else
			{
				setRedirect($link,FSText :: _('Error when hot record'),'error');	
			}
		}
		function unis_hot()
		{
			$model = $this -> model;
			$rows = $model->is_hot(0);
			$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
			$page = FSInput::get('page',0);
			if($page > 1)
				$link .= '&page='.$page;
			if($rows)
			{
				setRedirect($link,$rows.' '.FSText :: _('record was un_hot'));	
			}
			else
			{
				setRedirect($link,FSText :: _('Error when un_hot record'),'error');	
			}
		}	
		function is_feed()
		{
			$model = $this -> model;
			$rows = $model->is_feed(1);
			$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
			$page = FSInput::get('page',0);
			if($page > 1)
				$link .= '&page='.$page;
			if($rows)
			{
				setRedirect($link,$rows.' '.FSText :: _('record was event'));	
			}
			else
			{
				setRedirect($link,FSText :: _('Error when hot record'),'error');	
			}
		}
		function unis_feed()
		{
			$model = $this -> model;
			$rows = $model->is_feed(0);
			$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
			$page = FSInput::get('page',0);
			if($page > 1)
				$link .= '&page='.$page;
			if($rows)
			{
				setRedirect($link,$rows.' '.FSText :: _('record was un_hot'));	
			}
			else
			{
				setRedirect($link,FSText :: _('Error when un_hot record'),'error');	
			}
		}	
		function is_new()
		{
			$model = $this -> model;
			$rows = $model->is_new(1);
			$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
			$page = FSInput::get('page',0);
			if($page > 1)
				$link .= '&page='.$page;
			if($rows)
			{
				setRedirect($link,$rows.' '.FSText :: _('record was event'));	
			}
			else
			{
				setRedirect($link,FSText :: _('Error when new record'),'error');	
			}
		}
		function unis_new()
		{
			$model = $this -> model;
			$rows = $model->is_new(0);
			$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
			$page = FSInput::get('page',0);
			if($page > 1)
				$link .= '&page='.$page;
			if($rows)
			{
				setRedirect($link,$rows.' '.FSText :: _('record was un_new'));	
			}
			else
			{
				setRedirect($link,FSText :: _('Error when un_new record'),'error');	
			}
		}
		function is_sell()
		{
			$model = $this -> model;
			$rows = $model->is_sell(1);
			$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
			$page = FSInput::get('page',0);
			if($page > 1)
				$link .= '&page='.$page;
			if($rows)
			{
				setRedirect($link,$rows.' '.FSText :: _('record was event'));	
			}
			else
			{
				setRedirect($link,FSText :: _('Error when old record'),'error');	
			}
		}
		function is_hotdeal()
		{

			$model = $this -> model;
			$rows = $model->is_hotdeal(1);
			$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
			$page = FSInput::get('page',0);
			if($page > 1)
				$link .= '&page='.$page;
			if($rows)
			{
				setRedirect($link,$rows.' '.FSText :: _('record was event'));	
			}
			else
			{
				setRedirect($link,FSText :: _('Error when old record'),'error');	
			}
		}
		function unis_hotdeal()
		{
			$model = $this -> model;
			$rows = $model->is_hotdeal(0);
			$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
			$page = FSInput::get('page',0);
			if($page > 1)
				$link .= '&page='.$page;
			if($rows)
			{
				setRedirect($link,$rows.' '.FSText :: _('record was un_new'));	
			}
			else
			{
				setRedirect($link,FSText :: _('Error when un_new record'),'error');	
			}
		}
		function unis_sell()
		{
			$model = $this -> model;
			$rows = $model->is_sell(0);
			$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
			$page = FSInput::get('page',0);
			if($page > 1)
				$link .= '&page='.$page;
			if($rows)
			{
				setRedirect($link,$rows.' '.FSText :: _('record was un_sell'));	
			}
			else
			{
				setRedirect($link,FSText :: _('Error when un_old record'),'error');	
			}
		}
		function is_old()
		{
			$model = $this -> model;
			$rows = $model->is_old(1);
			$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
			$page = FSInput::get('page',0);
			if($page > 1)
				$link .= '&page='.$page;
			if($rows)
			{
				setRedirect($link,$rows.' '.FSText :: _('record was event'));	
			}
			else
			{
				setRedirect($link,FSText :: _('Error when old record'),'error');	
			}
		}
		function unis_old()
		{
			$model = $this -> model;
			$rows = $model->is_old(0);
			$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
			$page = FSInput::get('page',0);
			if($page > 1)
				$link .= '&page='.$page;
			if($rows)
			{
				setRedirect($link,$rows.' '.FSText :: _('record was un_old'));	
			}
			else
			{
				setRedirect($link,FSText :: _('Error when un_old record'),'error');	
			}
		}
		function is_promotion()
		{
			$model = $this -> model;
			$rows = $model->promotion(1);
			$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
			$page = FSInput::get('page',0);
			if($page > 1)
				$link .= '&page='.$page;
			if($rows)
			{
				setRedirect($link,$rows.' '.FSText :: _('record was event'));	
			}
			else
			{
				setRedirect($link,FSText :: _('Error when hot record'),'error');	
			}
		}
		function unis_promotion()
		{
			$model = $this -> model;
			$rows = $model->promotion(0);
			$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
			$page = FSInput::get('page',0);
			if($page > 1)
				$link .= '&page='.$page;
			if($rows)
			{
				setRedirect($link,$rows.' '.FSText :: _('record was un_hot'));	
			}
			else
			{
				setRedirect($link,FSText :: _('Error when un_hot record'),'error');	
			}
		}
		function format_money($row)
		{	if($row)
			return format_money($row,'VNĐ');
			else 
				return $row;
		}

		function ajax_check_name()
		{	
			$model  = $this -> model;
			$name = FSInput::get('name');
			$data_id = FSInput::get('data_id',0,'int');
			$result = $model->get_result('name="'.$name.'" AND id != ' .  $data_id);
			// printr($result);
			if($result){
				echo 1;
			}else{
				echo 0;
			}
			return;
		}

		function ajax_check_code()
		{	
			$model  = $this -> model;
			$code = FSInput::get('code');
			$data_id = FSInput::get('data_id',0,'int');
			$result = $model->get_result('code="'.$code.'" AND id != ' .  $data_id);
			// printr($result);
			if($result){
				echo 1;
			}else{
				echo 0;
			}
			return;
		}


		function ajax_getCategories_filter(){
			$model  = $this -> model;
			$cat_ft_id = FSInput::get('cat_ft_id');
			$categories  = $model -> ajax_getCategories_filter($cat_ft_id);
			
			// $json = '['; // start the json array element
			// $json_names = array();
			// foreach( $rs as $item)
			// {
			// 	$json_names[] = "{id: $item->id, name: '$item->name'}";
			// }
			// $json .= implode(',', $json_names);
			// $json .= ']'; // end the json array element
			// echo $json;
		}

		function ajax_getExtendFields(){
			$cid_before = FSInput::get('cid_before');
			$cid_after = FSInput::get('cid_after');
			$data_id = FSInput::get('data_id');

			if(!$cid_before || !$cid_after ){
				return false;
			}
			
			
			$model  = $this -> model;

			$data_cid_before = $model->get_record('id = '. $cid_before ,'fs_products_categories','id, tablename');

			$data_cid_after = $model->get_record('id = '. $cid_after ,'fs_products_categories','id, tablename');
			// $data_cid_before -> tablename;
			// $data_cid_after -> tablename;
			if($data_id){
				$data_ext = $model->getProductExt($data_cid_before-> tablename,$data_id);
			}
			if($data_cid_before -> tablename == $data_cid_after -> tablename){
				$extend_fields = $model->getExtendFields($data_cid_after -> tablename);
				$data_foreign = $model -> get_data_foreign($extend_fields);
				include 'modules/' . $this->module . '/views/' . $this->view . '/detail_extend.php';
				return;
			}else{
				$extend_fields = $model->getExtendFields($data_cid_after -> tablename);
				$data_foreign = $model -> get_data_foreign($extend_fields);
				include 'modules/' . $this->module . '/views/' . $this->view . '/detail_extend.php';
				return;
			}

			
		}



	/**
	* Lấy danh sách ảnh của sản phẩm
	*/
//	function get_other_images(){
//        	$list_other_images = $this->model->get_other_images();   
//	        include 'modules/' . $this->module . '/views/' . $this->view . '/detail_images_list.php';
//	} 
	/**
	 * Upload nhiều ảnh cho sản phẩm
	 */
	function upload_other_images() {
		$this->model->upload_other_images ();
	}
	/**
	 * Xóa ảnh
	 */
	function delete_other_image() {
		$this->model->delete_other_image ();
	}
	
	/**
	 * Sắp xếp ảnh
	 */
	function sort_other_images() {
		$this->model->sort_other_images ();
	}
	
	/*
    	 * Sửa thuộc tính của ảnh
    	 */
	function change_attr_image() {
		$this->model->change_attr_image ();
	}

		function change_extend_image() {
		$this->model->change_extend_image ();
	}
	/*********** SLIDESHOW HIGHLGITH **********/
	function upload_other_slideshow_highlight() {
		$this->model->upload_other_slideshow_highlight ();
	}
	/**
	 * Xóa ảnh
	 */
	function delete_other_slideshow_highlight() {
		$this->model->delete_other_slideshow_highlight ();
	}
	///VIDEO REVIEWS AJAX

	function uploadAjaxVideoReview(){
		$this->model->uploadAjaxVideoReview();
	}

	function getAjaxImagesVideoReview(){
		$listImagesVideoReview = $this->model->getAjaxImagesVideoReview();   
		include 'modules/' . $this->module . '/views/' . $this->view . '/detail_video_review_list.php';
	}

	function deleteAjaxImagesVideoReview() {
		$this->model->deleteAjaxImagesVideoReview();
	}

	function sortAjaxImagesVideoReview() {
		$this->model->sortAjaxImagesVideoReview();
	}

	function addTitleAjaxImagesVideoReview(){
		$this->model->addTitleAjaxImagesVideoReview();
	}

	function addLinkAjaxImagesVideoReview(){
		$this->model->addLinkAjaxImagesVideoReview();
	}
	
	/**
	 * Sắp xếp ảnh
	 */
	function sort_other_slideshow_highlight() {
		$this->model->sort_other_slideshow_highlight ();
	}
	
	/*
    	 * Sửa thuộc tính của ảnh
    	 */
	function change_attr_slideshow_highlight() {
		$this->model->change_attr_slideshow_highlight ();
	}
	/*********** SLIDESHOW HIGHLGITH **********/

	function remove_cache() {

		$model = $this -> model;

		$rows = $model->remove_cache();

		$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
		$page = FSInput::get('page',0);
		if($page > 1)
			$link .= '&page='.$page;
		if($rows){
			setRedirect($link,FSText :: _('Bạn đã xóa cache thành công'));	
		}

	}

	function ajax_get_tags(){
		$model = $this -> model;
		$data = $model->ajax_get_tags();
		echo $data;
		return;
	}

	function ajax_get_product_name(){
		$html ='';
		$name = FSInput::get('name');
		$id = FSInput::get('id',0,'int');
		if(!$name){
			echo $html;
			return;
		}
		$model = $this -> model;
		$data = $model->get_records('id <> '.$id.' AND name like "%'.$name.'%" OR code like "%'.$name.'%" AND id <> '.$id.' OR barcode like "%'.$name.'%" AND id <> '.$id,'fs_products','id,name');
		
		if(!empty($data)){
			$html .='<div class="html_show">';
			foreach ($data as $item) {
				$html .= '<div class="item" data-id="'.$item->id.'" onclick="set_parent_id(this)">'.$item->name.'</div>';
			}
			$html .= '</div>';
		}
		echo $html;
		return;
	}

	function ajax_show_all_image(){
		$model = $this -> model;
		$id = FSInput::get('id',0,'int');
		$data = array ('error' => true, 'html' => '');
		$html = '';
		if($id && $id > 0){
			$html .= '<div class="list-img-popup">';
			$product = $model->get_record('id = '.$id,'fs_products','image');
			$list_image = $model->get_records('record_id = '.$id,'fs_products_images','image');
			if($product-> image){
				$data['error'] = false;
				$html .= '<div class="item"><image width="100px" src="'.URL_ROOT.$product-> image.'"></div>';
			}
			if(!empty($list_image)){
				$data['error'] = false;
				foreach ($list_image as $item) {
					$html .= '<div class="item"><image width="100px" src="'.URL_ROOT.$item-> image.'"></div>';
				}
			}
			$html .= '</div>';
			$data['html'] = $html;
		}
		echo json_encode ($data);
		return;
	}


	function ajax_show_info_product(){
		$model = $this -> model;
		$id = FSInput::get('id',0,'int');
		$data = $model->get_record('id = '.$id, 'fs_products');

		$status = $model->get_records('', 'fs_products_status','*','','','id');
		$types = $model ->get_records('published = 1','fs_products_types','*','','','id');
		$data_warehouses = $this -> model->get_records('product_id = '.$id,'fs_warehouses_products','*','','','warehouses_id');
		$warehouses = $model -> get_records('published = 1','fs_warehouses');
		include 'modules/' . $this->module . '/views/' . $this->view . '/ajax_show_info_product.php';
		return;
	}

	function get_amount_all($id){
		$model = $this -> model;
		$amount = 0;
		$data = $model->get_records('product_id = ' .$id,'fs_warehouses_products','amount');
		if(!empty($data)){
			foreach ($data as $item) {
				if($item->amount){
					$amount += (float)$item->amount;
				}
			}
		}
		return $amount;
	}

	function get_amount_hold($id){
		$model = $this -> model;
		if(!empty($_SESSION['products_products_filter1'])){
			$link = FSRoute::_('index.php?module=products&view=view_amount_hold&id='.$id.'&warehouse_id='.$_SESSION['products_products_filter1']);

			$data = $model->get_record('product_id = ' .$id . ' AND warehouses_id = ' . $_SESSION['products_products_filter1'],'fs_warehouses_products','amount,amount_hold');
			return @$data->amount_hold;
		}else{

			$link = FSRoute::_('index.php?module=products&view=view_amount_hold&id='.$id);

			$amount = 0;
			$data = $model->get_records('product_id = ' .$id,'fs_warehouses_products','amount,amount_hold');
			if(!empty($data)){
				foreach ($data as $item) {
					if($item->amount_hold){
						$amount += (float)$item->amount_hold;
					}
					
				}
			}
			return $amount;
		}
	}


	function get_can_buy($id){
		$model = $this -> model;
		$link = FSRoute::_('index.php?module=products&view=inventory_detail&id='.$id);
		if(!empty($_SESSION['products_products_filter1'])){
		
			$data = $model->get_record('product_id = ' .$id . ' AND warehouses_id = ' . $_SESSION['products_products_filter1'],'fs_warehouses_products','amount,amount_hold');
			$amount = 0;
			$amount = @$data->amount - @$data->amount_hold;
			return $amount;
		}else{
			$amount = 0;
			$data = $model->get_records('product_id = ' .$id,'fs_warehouses_products','amount,amount_hold');
			if(!empty($data)){
				foreach ($data as $item) {
					if($item->amount_hold){
						$amount += $item->amount - $item->amount_hold;
					}else{
						$amount += $item->amount;
					}
				}
			}
			return $amount;
		}
	}

	function reset_amount_hold(){
		$model = $this -> model;
		$rows = $model->reset_amount_hold(1);
		$link = FSRoute::_('index.php?module='.$this -> module.'&view='.$this -> view);
		$page = FSInput::get('page',0);
		if($page > 1){
			$link .= '&page='.$page;
		}
		$link = FSRoute::_($link);
		if($rows)
		{
			setRedirect($link,FSText :: _('Reset thành công'));	
		}
		else
		{
			setRedirect($link,FSText :: _('Không có bản ghi nào được Reset'),'error');	
		}
	}

}



function view_history($controle,$record_id) {

	$link = FSRoute::_('index.php?module=products&view=history&record_id=' . $record_id);
	return '<a href="' . $link . '" title="Lịch sử" target="_blink"><img border="0" src="'.URL_ADMIN.'templates/default/images/clock_red.png" alt="Lịch sử"></a>';
}

function view_name($controle,$id){
	$model = $controle -> model;
	$data = $model->get_record('id = ' .$id,'fs_products','id,alias,category_alias,published');
	$link = FSRoute::_('index.php?module=products&view=product&id='.$data->id.'&code='.$data -> alias.'&ccode='.$data-> category_alias);
	$link .= '?preview=1';
	return '<a target="_blink" href="' . $link . '" title="Xem ngoài font-end">Xem trước</a>';
}

function view_amount($controle,$id){
	$model = $controle -> model;
	$link = FSRoute::_('index.php?module=products&view=inventory_detail&id='.$id);

	if(!empty($_SESSION['products_products_filter1'])){
		$data = $model->get_record('product_id = ' .$id . ' AND warehouses_id = ' . $_SESSION['products_products_filter1'],'fs_warehouses_products','amount');
		return '<a target="_blink" href="' . $link . '">'.@$data->amount.'</a>';
	}else{
		$amount = 0;
		$data = $model->get_records('product_id = ' .$id,'fs_warehouses_products','amount');
		if(!empty($data)){
			foreach ($data as $item) {
				if($item->amount){
					$amount += (float)$item->amount;
				}
				
			}
		}
		return '<a target="_blink" href="' . $link . '">'.@$amount.'</a>';
	}

	
}


function view_amount_all($controle,$id){
	$model = $controle -> model;
	$link = FSRoute::_('index.php?module=products&view=inventory_detail&id='.$id);
	$amount = 0;
	$data = $model->get_records('product_id = ' .$id,'fs_warehouses_products','amount');
	if(!empty($data)){
		foreach ($data as $item) {
			if($item->amount){
				$amount += (float)$item->amount;
			}
		}
	}
	return '<a target="_blink" href="' . $link . '">'.@$amount.'</a>';
}


function view_amount_hold($controle,$id){
	$model = $controle -> model;
	
	if(!empty($_SESSION['products_products_filter1'])){

		$link = FSRoute::_('index.php?module=products&view=view_amount_hold&id='.$id.'&warehouse_id='.$_SESSION['products_products_filter1']);

		$data = $model->get_record('product_id = ' .$id . ' AND warehouses_id = ' . $_SESSION['products_products_filter1'],'fs_warehouses_products','amount,amount_hold');
		return '<a target="_blink" href="' . $link . '">'.@$data->amount_hold.'</a>';
	}else{

		$link = FSRoute::_('index.php?module=products&view=view_amount_hold&id='.$id);

		$amount = 0;
		$data = $model->get_records('product_id = ' .$id,'fs_warehouses_products','amount,amount_hold');
		if(!empty($data)){
			foreach ($data as $item) {
				if($item->amount_hold){
					$amount += (float)$item->amount_hold;
				}
				
			}
		}
		return '<a target="_blink" href="' . $link . '">'.@$amount.'</a>';
	}
}


function view_can_buy($controle,$id){
	$model = $controle -> model;
	$link = FSRoute::_('index.php?module=products&view=inventory_detail&id='.$id);
	if(!empty($_SESSION['products_products_filter1'])){
	
		$data = $model->get_record('product_id = ' .$id . ' AND warehouses_id = ' . $_SESSION['products_products_filter1'],'fs_warehouses_products','amount,amount_hold');
		$amount = 0;
		$amount = @$data->amount - @$data->amount_hold;
		return '<a target="_blink" href="' . $link . '">'.$amount.'</a>';
	}else{
		$amount = 0;
		$data = $model->get_records('product_id = ' .$id,'fs_warehouses_products','amount,amount_hold');
		if(!empty($data)){
			foreach ($data as $item) {
				if($item->amount_hold){
					$amount += $item->amount - $item->amount_hold;
				}else{
					$amount += $item->amount;
				}
			}
		}
		return '<a target="_blink" href="' . $link . '">'.@$amount.'</a>';
	}
}

function show_code($controle,$id){
	$model = $controle -> model;
	$data = $model->get_record('id = ' .$id,'fs_products','code');
	$link = URL_ROOT.'admin/warehouses/bill_detail/'.$id;
	return '<a target="_blank" href="' . $link . '">'.@$data->code.'</a>';
}


?>



