<?php

   	require_once(PATH_BASE.'vendor/autoload.php');

   	require_once('vendor/autoload.php');
	use Escarter\PopplerPhp\PdfToText;
	use Escarter\PopplerPhp\getOutput;
	use Escarter\PopplerPhp\PdfToHtml;

	use setasign\fpdf;

	use setasign\Fpdi\Fpdi;

	use setasign\Fpdi\PdfReader;

	use Smalot\PdfParser\Parser;
	use PhpOffice\PhpSpreadsheet\IOFactory;

	class Print_historyControllersHistory extends Controllers
	{
		function __construct()
		{
			$this->view = 'history';
			parent::__construct();
			$model = $this -> model;
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			$model  = $this -> model;
			$list = $this -> model->get_data();

			$query = $this -> model->setQuery();
			$pagination = $model->getPagination();
			$wrap_id_warehouses = $model->get_wrap_id_warehouses();

			$test = !empty($_GET['test'])?1:0;


			// echo $wrap_id_warehouses;
			
			$warehouses = $model -> get_records('published = 1 AND id IN ('.$wrap_id_warehouses.')','fs_warehouses');
			$platforms = $model -> get_records('published = 1','fs_platforms');
			$houses = $model -> get_records('published = 1','fs_house');
			// if($test==1){
			// 	// echo "<pre>";
			// 	// var_dump($list);
			// 	// echo "</pre>";

			// 	// die;
				
			// 	include 'modules/'.$this->module.'/views/'.$this->view.'/list1.php';
			// }
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
			


		}

		function generateDailyPath($baseDir = 'uploads') {
		    // Get the current year, month, and day
		    $year = date('Y');
		    $month = date('m');
		    $day = date('d');

		    // Construct the path
		    $path = $baseDir . '/' . $year . '/' . $month . '/' . $day;

		    if (!is_dir($path)) {

			    mkdir($path, 0755, true);
			}

		    return $path;
		}

		function combo_Return_code($sku)
		{
			global $db;

			$query = " SELECT code_combo FROM  fs_products WHERE 1=1 AND code = '$sku'"; 
			$values = $db->getObjectList($query);

			$return = '';

			if(!empty($values[0]) && !empty($values[0]->code_combo)){

				$parts = explode(',', $values[0]->code_combo);
				$data = [];

				foreach ($parts as $part) {
				    $clean = trim($part); // loại bỏ khoảng trắng
				    $data[] = substr($clean, 0, 7);
				}

				$return = $data;

			}

			return $return;

		}


		function export_pdf_count_shopee()
		{
			global $db;

			$H = date('G');
			$M = date('i');

	        if ($H < 8) {
			    $house_id = 13;
			} elseif (($H > 8 && $H < 14) ||($H == 14 && $M < 30) ) {
			    $house_id = 18;
			} else {
			    $house_id = 15;
			} 
			
			// $house_id = 13;
			
			$query = "SELECT file_pdf, id 
        FROM fs_order_uploads_history_prints 
        WHERE platform_id = 2 
        AND warehouse_id IN (1, 2)
        AND house_id = $house_id 
        ORDER BY id DESC 
        LIMIT 2";
			$values = $db->getObjectList($query);

			foreach ($values as $key => $value) {  


				$url_file_pdf = 'https://'.DOMAIN.'/'.$value->file_pdf;

				$id_print = $value->id;
				

				$dir_file = $this->export_file_pdf($url_file_pdf, $house_id);
			

				$sql= "UPDATE fs_order_uploads_history_prints SET file_pdf_dem = '$dir_file'  WHERE `id`=".$id_print;

				$db->query($sql);

		        
			}   
		}

		// class PDF_Rotate_FPDI extends FPDI {
			//     protected $angle = 0;

			//     function Rotate($angle, $x = -1, $y = -1) {
			//         if ($x == -1) $x = $this->x;
			//         if ($y == -1) $y = $this->y;
			//         if ($this->angle != 0) $this->_out('Q');
			//         $this->angle = $angle;
			//         if ($angle != 0) {
			//             $angle *= M_PI / 180;
			//             $c = cos($angle);
			//             $s = sin($angle);
			//             $cx = $x * $this->k;
			//             $cy = ($this->h - $y) * $this->k;
			//             $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm',
			//                 $c, $s, -$s, $c, $cx, $cy));
			//         }
			//     }

			//     function _endpage() {
			//         if ($this->angle != 0) {
			//             $this->angle = 0;
			//             $this->_out('Q');
			//         }
			//         parent::_endpage();
			//     }
			// }



		function export_file_pdf($url_file, $houseid)
		{

			$baseDir =  PATH_BASE.'/admin/export/pdf/count_print/';

			$parser = new Parser();

			$urls = [
			    $url_file
			    
			];


			$model = $this -> model;

			$filename = $model->downloadMultipleFiles($urls);


			$filename = str_replace('https://dienmayai.com', '', $filename[0]['file_link']) ;

			// Load PDF file
			$pdf = $parser->parseFile($filename);
			// Get all pages
			$pages = $pdf->getPages();
			$data_result = [];
			 
			$pattern = '/([A-Z0-9]{4})-[A-Z]{2}-[0-9]{2}-[A-Z]{3}-[0-9]{2}-(SL[0-9]|[0-9]{2,3})/i';

			$patternSku = '/([A-Z0-9]{4})-[A-Z]{2}-[0-9]{2}-[A-Z]{3}-[0-9]{2}-(SL[0-9]|[0-9]{2,3})/i';
			    // Pattern cho SL (số lượng)
			$patternQty = '/S[\s\S]*?L:\s*(\d+)/'; //kể cả trường hợp S L 

			$data_result = [];

			

			$y = [175, 191, 205, 219, 233, 247];
			$k = [130, 140, 150, 160];
			$ar_sku_show =[];


			foreach ($pages as $index => $page) {
			    $pageNumber = $index + 1;
			    $text = $page->getText();
			    $texts = preg_replace('/\r?\n/', '', $text);
			   
			    // Lấy tất cả các kết quả
			    preg_match_all($patternSku, $texts, $matchesSku);
			    preg_match_all($patternQty, $text, $matchesQty);
			 
			    //xóa kết quả trùng nhau trong mảng sku tìm thấy
			 
			    $matchesSku[0] = array_reverse(array_unique($matchesSku[0]));
			    
			    // Chuẩn bị mảng kết quả
			    $results = [];
			    // Đảm bảo số lượng SKU và số lượng khớp nhau về thứ tự
			    $count = min(count($matchesSku[0]), count($matchesQty[1]));
			    for ($i = 0; $i < $count; $i++) {


			    	
			        $skuFull = $matchesSku[0][$i];
			        $skuShort = substr($skuFull, 0, 7); // Lấy 4 ký tự đầu của SKU

			        $sku_full_check = substr(trim($skuFull), 0, 10); // Lấy 10 ký tự đầu của SKU

			        $check_combo = $this->combo_Return_code($sku_full_check);

			        $quantity_get = $matchesQty[1][$i];

			        
			        if(!empty($check_combo)){

			        	$show_more = $check_combo;

			        	$ar_sku_show[$index][$i][] =  $show_more;

			        }
			        else {
			        	if (intval($quantity_get) >1){

			        		

			        		$ar_sku_show[$index][$i][] =  [$skuShort.':'.$quantity_get];
			        	}
			        	
			        }
			        

			        $results[] = [
			            'sku' => $skuShort,
			            'quantity' => $quantity_get,
			            'sku_full' => $skuFull,
			            'sku_full_check' => $sku_full_check,
			            'show_more' => $ar_sku_show,

			        ];
			    }
			    array_push($data_result, array_reverse($results));
			 
			}
			$model->calculateCumulativeQuantities($data_result);

			echo "<pre>";

			print_r($data_result);

			echo "</pre>";

			die;

			$data_result = $model->show_list_array_run($data_result);

			// check là combo và số lượng sản phẩm lớn hơn 2 thì note mã sản phẩm với số lượng sản phẩm


			// $produt-> type_id == 9 && $produt-> code_combo && $produt-> code_combo !=''

			// Đang làm
			
			$pdf = new Fpdi();

			$filePath = $filename;

			$pageCount = $pdf->setSourceFile($filePath);

			
			

			for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {

			    $templateId = $pdf->importPage($pageNo);
			    $size = $pdf->getTemplateSize($templateId);
			    $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);

			    // Chèn template gốc
			    $pdf->useTemplate($templateId);

			    // $pdf->Image('z6666321666436_8c947a3b83f172e254bee07a90a68508.jpg', $x, $y, $w, $h);

			    // Chèn ảnh thường (logo)
			    $imagePath =  PATH_BASE.'/admin/export/pdf/images/Capture.jpg';
			    $pdf->Image($imagePath, 105, 2, 40, 100);

			    $pdf->SetFont('Arial', 'B', 14);
			    $pdf->SetTextColor(0, 0, 0); // Màu đen

			    // === ✅ Ghi đè dữ liệu text theo danh sách ===
			    $index_data = $pageNo - 1;
			    $data_all = $data_result[$index_data];
			    $pdf->SetFont('Arial', 'B', 14);
			    $pdf->SetTextColor(0, 0, 0); // Màu đen

			    for ($i = 0; $i < count($data_all); $i++) {
			    	$dem =0;

			    	//phần ghi mã sản phẩm khi có combo hoặc số lượng lớn hơn 1

			    	if(!empty($data_result[$index_data][$i]['show_more'])){

			    		$pdf->SetFont('Arial', 'B', 14);
			    		$pdf->SetTextColor(0, 0, 0); // Màu đen

			    		$pdf->SetXY(105, $k[$dem]);
			    		$dem++;
			    		$write_show_more = $data_result[$index_data][$i]['show_more']; 
			    		$pdf->Write(10, $write_show_more);
			    	}

			    	$pdf->SetFont('Arial', 'B', 14);
			    	$pdf->SetTextColor(0, 0, 0); // Màu đen

			        $pdf->SetXY(105, $y[$i]);
			        $write = $data_result[$index_data][$i]['parent_index'] . '--' .
			                 $data_result[$index_data][$i]['show_list'] . '==>' .
			                 $data_result[$index_data][$i]['all'] . '--' .
			                 $data_result[$index_data][$i]['all_to_sku'];
			        $pdf->Write(10, $write);
			    }

			    $pdf->SetFont('Arial', 'B', 14);
			    $pdf->SetTextColor(0, 0, 0); // Màu đen
			    $pdf->SetXY(105, $y[count($data_all)]); // Tọa độ X-Y
			    $pdf->Write(10, $pageNo);
			    // $pdf->SetFont('Arial', 'B', 14);
			    // $pdf->SetTextColor(0, 0, 0); // Màu đen
			}

			$path_date = $this->generateDailyPath($baseDir);

			$timestamp = time();

			$file_name = $houseid.'_'.$timestamp.'.pdf';

			$dir_file_name = $path_date.'/'.$file_name;



			// Xuất file
			// $pdf->Output('I', 'print/output3.pdf') ///i là xem trực tiếp còn F là lưu vào đường dẫn;

			$pdf->Output('F', $dir_file_name); ///i là xem trực tiếp còn F là lưu vào đường dẫn;



			$dir_file_name_convert = str_replace('/www/wwwroot/'.DOMAIN, '', $dir_file_name);

			return $dir_file_name_convert;
		}


		function add()
		{
			$model = $this -> model;
			
			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}

		function edit()
		{
			$model = $this -> model;
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$data = $model->get_record_by_id($id);
		
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
	}

	

	function view_pdf($controle,$id){
		$model = $controle -> model;
		$data = $model->get_record('id = ' .$id,'fs_order_uploads_history_prints','id,file_pdf');
		$link = URL_ROOT.$data-> file_pdf;
		return '<a target="_blink" href="' . $link . '">Xem file</a>';
	}

	function view_pdf_dem($controle,$id){
		$model = $controle -> model;
		$data = $model->get_record('id = ' .$id,'fs_order_uploads_history_prints','id,file_pdf_dem');
		$link = URL_ROOT.$data-> file_pdf_dem;

		$check = !empty($data-> file_pdf_dem)?'<a target="_blink" href="' . $link . '">Xem file</a>':'';

		
		return $check;
	}


	function view_status($controle,$id){
		$model = $controle -> model;
		$data = $model->get_record('id = ' .$id,'fs_order_uploads_history_prints','id,file_pdf,total_file_success,total_file');
		$tt = $data-> total_file_success.'/'.$data-> total_file;
		$txt = "In thành công ".$tt." order";
		return $txt;
	}


	//chỗ này 

	
	
	
?>