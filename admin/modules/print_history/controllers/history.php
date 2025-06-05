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
			if($test==1){
				// echo "<pre>";
				// var_dump($list);
				// echo "</pre>";

				// die;
				
				include 'modules/'.$this->module.'/views/'.$this->view.'/list1.php';
			}
			else{
				include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
			}


		}


		function export_pdf_count_shopee()
		{
			global $db;
			
			$houseid = 15;
			
			$query = "SELECT file_pdf 
        FROM fs_order_uploads_history_prints 
        WHERE platform_id = 2 
        AND warehouse_id IN (1, 2)
        AND house_id = $houseid 
        ORDER BY id DESC 
        LIMIT 2";
			$values = $db->getObjectList($query);

			echo "<pre>";
				print_r($values);
				echo "</pre>";
			die;	


			foreach ($values as $key => $value) {     

				echo "<pre>";
				print_r($values);
				echo "</pre>";

				die;
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



		function export_file_pdf()
		{
			$parser = new Parser();

			$urls = [
			    "https://dienmayai.com/files/orders/2025/06/03/time_15_warehouse_1_platform_id_2_date_1748935866.pdf",
			    
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
			        $results[] = [
			            'sku' => $skuShort,
			            'quantity' => $matchesQty[1][$i],
			            'sku_full' => $skuFull,

			        ];
			    }
			    array_push($data_result, array_reverse($results));
			 
			}
			$model->calculateCumulativeQuantities($data_result);

			$data_result = $model->show_list_array_run($data_result);
			
			$pdf = new Fpdi();

			$filePath = $filename;

			$pageCount = $pdf->setSourceFile($filePath);

			$y = [175, 191, 205, 219, 233, 247];

			for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
			    $templateId = $pdf->importPage($pageNo);
			    $size = $pdf->getTemplateSize($templateId);
			    $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);

			    // Chèn template gốc
			    $pdf->useTemplate($templateId);

			    // $pdf->Image('z6666321666436_8c947a3b83f172e254bee07a90a68508.jpg', $x, $y, $w, $h);

			    // Chèn ảnh thường (logo)
			    $imagePath =  PATH_BASE.'/admin/export/pdf/images/Capture.jpg';
			    $pdf->Image($imagePath, 105, 2, 20, 50);

			    $pdf->SetFont('Arial', 'B', 14);
			    $pdf->SetTextColor(0, 0, 0); // Màu đen

			    // === ✅ Ghi đè dữ liệu text theo danh sách ===
			    $index_data = $pageNo - 1;
			    $data_all = $data_result[$index_data];
			    $pdf->SetFont('Arial', 'B', 14);
			    $pdf->SetTextColor(0, 0, 0); // Màu đen

			    for ($i = 0; $i < count($data_all); $i++) {
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

			// Xuất file
			// $pdf->Output('I', 'print/output3.pdf') ///i là xem trực tiếp còn F là lưu vào đường dẫn;

			$pdf->Output('F', PATH_BASE.'/admin/export/pdf/count_print/output.pdf'); ///i là xem trực tiếp còn F là lưu vào đường dẫn;
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


	function view_status($controle,$id){
		$model = $controle -> model;
		$data = $model->get_record('id = ' .$id,'fs_order_uploads_history_prints','id,file_pdf,total_file_success,total_file');
		$tt = $data-> total_file_success.'/'.$data-> total_file;
		$txt = "In thành công ".$tt." order";
		return $txt;
	}


	//chỗ này 

	
	
	
?>