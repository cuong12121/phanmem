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

				foreach ($parts as $key=> $part) {
				    $clean = trim($part); // loại bỏ khoảng trắng
				    $data['list'] = str_replace('/', ':', $clean);
				    $data['product_code'] = $sku;
				   
				    
				}

				$return = $data;

			}

			return $return;

		}

		function update_pdf_false()
		{
			global $db;
			$query = "SELECT * FROM fs_order_uploads WHERE created_time BETWEEN '2025-06-01 00:00:00.000000' AND '2025-06-12 00:00:00.000000' AND id_file_pdf_google_drive LIKE '%<b>Warning</b>:%' ORDER BY fs_order_uploads.id ASC";

			$values = $db->getObjectList($query);

			foreach ($values as $key => $value) {
				
				$link = $value->file_pdf;
				$id = $value->id;
				$id_google_drive = file_get_contents('https://drive.'.DOMAIN.'/createfile_gg.php?link=https://'.DOMAIN.'/'.$link);

				$sql = "UPDATE fs_order_uploads SET id_file_pdf_google_drive = '$id_google_drive' WHERE id = '$id'";

				$values = $db->query($sql);
			}
			echo "thành công";

		}


		function export_pdf_count_shopee()
		{
			global $db;

			$H = date('G');
			$M = date('i');

	        if ($H < 12) {
			    $house_id = 13;
			} elseif (($H >= 12 && $H < 14) ||($H == 14 && $M < 30) ) {
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

				
				$dir_file = str_replace('//admin', '/admin', $dir_file);
		

				$sql= "UPDATE fs_order_uploads_history_prints SET file_pdf_dem = '$dir_file'  WHERE `id`=".$id_print;

				$result = $db->query($sql);

				echo $id_print;

		        
			}   
		}

		//phần thử return quantity vs sku


		function findBestMatch($productName, $categories) {
		    $productWords = array_map('mb_strtolower', preg_split('/\s+/', $productName));

		    $bestMatch = null;
		    $maxMatches = 0;

		    foreach ($categories as $category) {
		        $categoryWords = array_map('mb_strtolower', preg_split('/[\/\s]+/', $category));
		        $matches = count(array_intersect($productWords, $categoryWords));

		        if ($matches > $maxMatches) {
		            $maxMatches = $matches;
		            $bestMatch = $category;
		        }
		    }

		    return $bestMatch;
		}

		function getProductQuantityByFuzzyName($searchName, $products) {
		    // Lấy danh sách tên sản phẩm từ mảng
		    $productNames = array_column($products, 'name');

		    // Tìm tên gần giống nhất
		    $bestMatch = $this->findBestMatch($searchName, $productNames);

		    // Tìm lại trong mảng gốc để lấy số lượng
		    foreach ($products as $product) {
		        if ($product['name'] === $bestMatch) {
		            return $product['quantity'];
		        }
		    }

		    return 0; // Nếu không tìm thấy
		}


		function return_ar_pd_sl($mang3, $rawText)
		{

		    $cleanText = preg_replace("/\r|\n/", " ", $rawText);

		    $pattern = '/\d+\.\s(.*?)(?:S\s*L:\s*(\d+))/';


		    // Regex bắt tên sản phẩm và số lượng tương ứng
		    preg_match_all($pattern, $cleanText, $matches, PREG_SET_ORDER);



		    // Mảng kết quả
		    $mang2 = [];

		    foreach ($matches as $match) {
		        $mang2[] = [
		            'name' => trim($match[1]),
		            'quantity' => (int)$match[2]
		        ];
		    }

		    // Trường hợp sai lệch số lượng sku và tên tìm được thì lấy số lượng theo tên tìm được

			if (count($mang2) !== count($mang3)) {
				// Lấy chỉ số lớn nhất trong $mang2
				$maxIndex = count($mang2) - 1;

				// Cắt $mang3 từ index 0 đến $maxIndex
				$mang3_filtered = array_slice($mang3, 0, $maxIndex + 1);

				$mang3 = $mang3_filtered;

			}


		    $result = [];
		    for ($i=0; $i<count($mang3);$i++) {

		        $quantity = $this->getProductQuantityByFuzzyName($mang3[$i]['name'], $mang2);

		        $result[$i]['sku'] = $mang3[$i]['sku'];

		        $result[$i]['quantity'] =  $quantity;

		    }

		   

		    return $result;
		}

		function normalize_array($array) {
		    return array_map(function($item) {
		        return $item['mvd'] . '|' . $item['sku'];
		    }, $array);
		}


		function show_export_file_compare_pdf_excel()
		{
			$model  = $this -> model;

			// $filePath = 'https://dienmayai.com//admin/export/pdf/count_print//2025/06/14/13_1749860119.pdf';

			// $data_pdf = $this->return_info_to_file_pdf($filePath);

			// echo"<pre>";

			// print_r($data_pdf);

			// echo"</pre>";

			// die;




			// // gộp mảng lại 

			// $data_pdfs = [];
			// foreach ($data_pdf as $subArray) {
			//     foreach ($subArray as $item) {
			//         $data_pdfs[] = $item;
			//     }
			// }

			

			$url_ex = 'https://dienmayai.com/admin/export/excel/order_item//2025/06/14/file_nhat_2_2_14_06_25_13.xlsx';

			$data_ex = $this->data_excel($url_ex);

			echo"<pre>";

			print_r($data_ex);

			echo"</pre>";

			die;

			// echo"<pre>";

			// print_r($data_pdfs);

			// echo"</pre>";


		}

		function export_file_compare_pdf_excel()
		{
			$model  = $this -> model;

			$filePath = $_GET['file'];

			$data_pdf = $this->return_info_to_file_pdf($filePath);


			// gộp mảng lại 

			$data_pdfs = [];
			foreach ($data_pdf as $subArray) {
			    foreach ($subArray as $item) {
			        $data_pdfs[] = $item;
			    }
			}

			

			$url_ex = 'https://dienmayai.com/admin/export/excel/order_item//2025/06/14/file_nhat_2_2_14_06_25_13.xlsx';

			$data_ex = $this->data_excel($url_ex);

			

			$norm1 = $this->normalize_array($data_pdfs);
			$norm2 = $this->normalize_array($data_ex);

			$onlyInArray1 = array_diff($norm1, $norm2);
			$onlyInArray2 = array_diff($norm2, $norm1);

			// In ra kết quả
			echo "Sku not in excel:\n";

			echo "<pre>";
			print_r($onlyInArray1);
			echo "</pre>";
			// foreach ($onlyInArray1 as $item) {
			//     list($mvd, $sku) = explode('|', $item);
			//     echo "- MVD: $mvd, SKU: $sku\n";
			// }

			echo "\nSku in excel not in pdf:\n";
			echo "<pre>";
			print_r($onlyInArray2);
			echo "</pre>";
		}


		

		function return_sku_in_pdf()
		{
			$model  = $this -> model;

			$filePath = $_GET['file'];

			// $filePath = 'https://dienmayai.com/files/orders/2025/06/08/hn86nnt3_1749400132_cv.pdf';

			// Load PDF file
			$parser = new Parser();
			$pdf = $parser->parseFile($filePath);

			// Extract text
			$string = $pdf->getText();


			$pattern = '/Mã đơn hàng:\s*([\s\S]*?)\s*Từ:/';


			if (preg_match($pattern, $string, $matches)) {
			    echo "Kết quả: " . $matches[1];  // SPXVN054643113956 250613EKPY3BNW
			} else {
			    echo $string;
			}

			die;


			// $pattern = '/\b[A-Z0-9]{4}\s*-\s*[A-Z]{2}\s*-\s*\d{2}\s*-\s*[A-Z]{3}\s*-\s*\d{2}\s*-\s*\d{3}\b/';

			$pattern = '/\b[A-Z0-9]{4}\s*-\s*[A-Z]{2}\s*-\s*\d{2}\s*-\s*[A-Za-z]{3}\s*-\s*\d{2}\b/';

			preg_match_all($pattern, $string, $matches);

			// Loại bỏ khoảng trắng trong mỗi kết quả
			$cleaned = array_map(function($sku) {
			    return preg_replace('/\s+/', '', $sku);
			}, $matches[0]);

			$data = [];

			
			// $array_sku =[['sku'=>'663D', 'name'=>'Túi Ngủ Văn Phòng KAW'], ['sku'=>'360A', 'name'=>'Nhiệt kế']];

			if(!empty($cleaned) && count($cleaned)>0){

				foreach ($cleaned as $key => $value) {

					$sku_short = substr(trim($value), 0, 10);
					
					$produt = $model->get_record('code = "'.$sku_short.'"','fs_products','name');

					$array_sku[$key]['name'] = $produt->name;
					$array_sku[$key]['sku'] = $sku_short;
				}
				$data = $this->return_ar_pd_sl($array_sku, $string);

			}

			if(count($data)==0){
				echo $string;
			}
			else{
				echo "<pre>";

				print_r($data);

				echo "</pre>";
			}

	
			die;

		}

		


		function return_product_sku_quantity_to_text($string)
		{
			$model  = $this -> model;
			// $pattern = '/\b[A-Z0-9]{4}\s*-\s*[A-Z]{2}\s*-\s*\d{2}\s*-\s*[A-Z]{3}\s*-\s*\d{2}\s*-\s*\d{3}\b/';

			$pattern = '/\b[A-Za-z0-9]{4}\s*-\s*[A-Za-z]{2}\s*-\s*\d{2}\s*-\s*[A-Za-z]{3}\s*-\s*\d{2}\b/';

			preg_match_all($pattern, $string, $matches);

			
	 
	    	
			// Loại bỏ khoảng trắng trong mỗi kết quả
			$cleaneds = array_map(function($sku) {
			    return preg_replace('/\s+/', '', $sku);
			}, $matches[0]);

			$cleaned = array_reverse(array_unique($cleaneds));


			$data = [];

			// $array_sku =[['sku'=>'663D', 'name'=>'Túi Ngủ Văn Phòng KAW'], ['sku'=>'360A', 'name'=>'Nhiệt kế']];

			if(!empty($cleaned) && count($cleaned)>0){

				foreach ($cleaned as $key => $value) {

					$sku_short = substr(trim($value), 0, 10);
					
					$produt = $model->get_record('code = "'.$sku_short.'"','fs_products','name');

					$array_sku[$key]['name'] = $produt->name;
					$array_sku[$key]['sku'] = $sku_short;
				}
				$data = $this->return_ar_pd_sl($array_sku, $string);

			}

			return $data;
		}


		function findMVD($content){
		    
            // $text = trim(PdfToText::getText($filePath));

            $pattern = '/Mã đơn hàng:\s*([\s\S]*?)\s*Từ:/';

            preg_match($pattern, $content, $matches);

        	$maVanDon_ar = isset($matches[1]) ? $matches[1] : null;

        	$maVanDon  = [];

        	if(!empty($maVanDon_ar)){
        		$maVanDon  = explode("\n", $maVanDon_ar);
        	}
           
            return $maVanDon;
            
		}   
		function return_info_to_file_pdf($url_file)
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

			// $patternSku = '/([A-Z0-9]{4})-[A-Z]{2}-[0-9]{2}-[A-Z]{3}-[0-9]{2}-(SL[0-9]|[0-9]{2,3})/i';
			//     // Pattern cho SL (số lượng)
			// $patternQty = '/S[\s\S]*?L:\s*(\d+)/'; //kể cả trường hợp S L 
			
			$ar_sku_show =[];
			
			foreach ($pages as $index => $page) {
			    $pageNumber = $index + 1;
			    $text = $page->getText();

			    $mvd_ar = $this->findMVD($text);


			    $mvd = !empty($mvd_ar)&& count($mvd_ar)>0?$mvd_ar[0]:'';

			    // Chuẩn bị mảng kết quả
			    $results = [];

			    $data = $this->return_product_sku_quantity_to_text($text);


			    if(!empty($data) && count($data)>0){

				    for ($i = 0; $i < count($data); $i++) {

				    	$check_sl = [];
				    	
				        $skuFull = $data[$i]['sku'];
				        $skuShort = substr($skuFull, 0, 7); // Lấy 4 ký tự đầu của SKU

				        $sku_full_check = substr(trim($skuFull), 0, 10); // Lấy 10 ký tự đầu của SKU

				        $check_combo = $this->combo_Return_code($sku_full_check);

				        $quantity_get = $data[$i]['quantity'];

				        if(!empty($check_combo)){
				        	
				        	$show_more = $check_combo;

				        	$ar_sku_show[$index][] =  $show_more;

				        }
				        
				        $results[] = [
				        	'mvd'=> $mvd,
				            'sku' => $sku_full_check,
				            
				        ];
				    }
				}    
			    array_push($data_result, array_reverse($results));
			 
			}

			return $data_result;
			
		}

		function show_combo()
		{
			$code  = file_get_contents('https://api.phanmemttp.xyz/api.php?key_number=1');

			$data = json_decode($code);

			$ar = [];

			$ar_sku_show= [];

			// Thêm trường sku_add
			foreach ($data as &$group) {
			    foreach ($group as &$item) {
			    	$array_data = $this->combo_Return_code($item->sku_full_check);
			    	

			        $item->combo =  !empty($array_data)?$array_data['list']:'';
			        $item->product_combo_code =  !empty($array_data)?$array_data['product_code']:'';
			    }
			}

			// foreach ($data as $i => $order) {
			//     foreach ($order as $j => $items) {
			//         $sku_full_check = $items->sku_full_check;
			       
		    //      	$check_combo = $this->combo_Return_code($sku_full_check);
			       
			//         if(!empty($check_combo)){
			        	
			//         	$show_more = $check_combo;

			//         	$ar_sku_show[$i][] =  $show_more;

			//         }

			       

			//     }
			// }

			// In kết quả
			echo "<pre>";
			print_r($data);

			echo "</pre>";
			die;

		}

		function clone_function()
		{
			global $db;

			$model = $this -> model;

			$y = [190, 200, 210, 220, 230, 240];
			$k = [100, 108,116, 124,132,140,148,156,164,172,180, 188];

			$baseDir =  PATH_BASE.'/admin/export/pdf/count_print/';
			$houseid = 6;

			$data_in = file_get_contents('https://drive.dienmayai.com/file_in.php');

			$data_json = json_decode($data_in,true);

			$dem = 0;
			foreach ($data_json as $key => $value) {
				$dem++;

				$id = $value['id'];

				$urls = ['https://dienmayai.com/'.$value['file_pdf'] ];


				$filename = $model->downloadMultipleFiles($urls);


				$filename = str_replace('https://dienmayai.com', '', $filename[0]['file_link']) ;

				$url_json = 'https://api.phanmemttp.xyz/api.php?key_number='.$dem;

				$content = file_get_contents($url_json);

				

				$data_result = json_decode($content, true);

				

				foreach ($data_result as &$group) {
				    foreach ($group as &$item) {
				    	$array_data = $this->combo_Return_code($item['sku_full_check']);
				    	

				        $item['combo'] = !empty($array_data) ? $array_data['list'] : '';
				        $item['product_combo_code'] = !empty($array_data) ? $array_data['product_code'] : '';
				        $item['count_show_more'] = !empty($array_data['list']) ? count($array_data['list']) : 0;
				    }
				}

			

				$model->calculateCumulativeQuantities($data_result);

				$data_result = $model->show_list_array_run($data_result);

				
				
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
				    $pdf->Image($imagePath, 105, 2, 40, 90);

				    $pdf->SetFont('Arial', 'B', 14);
				    $pdf->SetTextColor(0, 0, 0); // Màu đen

				    // === ✅ Ghi đè dữ liệu text theo danh sách ===
				    $index_data = $pageNo - 1;
				    $data_all = $data_result[$index_data];
				    $pdf->SetFont('Arial', 'B', 14);
				    $pdf->SetTextColor(0, 0, 0); // Màu đen

				    
				   
				    for ($i = 0; $i < count($data_all); $i++) {
				    	
				    	
				    	//phần ghi mã sản phẩm khi có combo 

				    	$item->combo =  !empty($array_data)?$array_data['list']:'';
				        $item->product_combo_code =  !empty($array_data)?$array_data['product_code']:'';
				    	if(!empty($data_all[$i]['combo'])  && count($data_all[$i]['combo'])>0){

				    		$show_sku = $data_all[$i]['combo'];

				    		$pdf->SetFont('Arial', 'B', 14);
				    		$pdf->SetTextColor(0, 0, 0); // Màu đen

				    		for ($z=0; $z < count($show_sku); $z++) { 

				    			
				    			
				    			$pdf->SetXY(105, $k[$z]);
				    			

				    			$write_show_more = $ar_sku_show[$index_data][$i][$z];

				    			$pdf->Write(10, $write_show_more);
				    		}
				    		
				    	}
				    	else{
				    		$kk = !empty($z)?$z:0;
				    		//phần ghi mã sản phẩm khi có số sản phẩm lớn hơn 2
				    		if(count($data_all)>1){
				    			// trường hợp tồn tại sản phẩm combo thì không in sku combo
					    		if(empty($data_all[$i]['product_combo_code']) ){

					    			$pdf->SetFont('Arial', 'B', 14);
							    	$pdf->SetTextColor(0, 0, 0); // Màu đen

							        $pdf->SetXY(105, $k[$kk+$i]);
							        $write_show_more_pd = $data_result[$index_data][$i]['sku'].':'.$data_result[$index_data][$i]['quantity'];

							        $pdf->Write(10, $write_show_more_pd);

					    		}

				    		}
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
				    $pdf->SetFont('Arial', 'B', 14);
				    $pdf->SetTextColor(0, 0, 0); // Màu đen
				}

				
				$path_date = $this->generateDailyPath($baseDir);

				$timestamp = time();

				$file_name = $houseid.'_'.$timestamp.'.pdf';

				$dir_file_name = $path_date.'/'.$file_name;

				// Xuất file
				// $pdf->Output('I', 'print/output3.pdf'); ///i là xem trực tiếp còn F là lưu vào đường dẫn;


				$pdf->Output('F', $dir_file_name); ///i là xem trực tiếp còn F là lưu vào đường dẫn;

				

				$dir_file_name_convert = str_replace('/www/wwwroot/'.DOMAIN, '', $dir_file_name);

				$sql = "UPDATE fs_order_uploads_history_prints SET file_pdf_dem = '$dir_file_name_convert' WHERE id = '$id'";

				$values = $db->query($sql);

				// echo $dir_file_name;

			}
			echo "Thành công";

		}


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

			// $patternSku = '/([A-Z0-9]{4})-[A-Z]{2}-[0-9]{2}-[A-Z]{3}-[0-9]{2}-(SL[0-9]|[0-9]{2,3})/i';
			//     // Pattern cho SL (số lượng)
			// $patternQty = '/S[\s\S]*?L:\s*(\d+)/'; //kể cả trường hợp S L 

			$y = [190, 200, 210, 220, 230, 240];
			$k = [100, 108,116, 124,132,140,148,156,164,172,180, 188];

			
			$ar_sku_show =[];

			$ar_sku_quantity_on_2 =[];
			
			foreach ($pages as $index => $page) {
			    $pageNumber = $index + 1;
			    $text = $page->getText();

			    // Chuẩn bị mảng kết quả
			    $results = [];

			    $data = $this->return_product_sku_quantity_to_text($text);

			    if(!empty($data) && count($data)>0){

				    for ($i = 0; $i < count($data); $i++) {

				    	$check_sl = [];
				    	
				        $skuFull = $data[$i]['sku'];
				        $skuShort = substr($skuFull, 0, 7); // Lấy 4 ký tự đầu của SKU

				        $sku_full_check = substr(trim($skuFull), 0, 10); // Lấy 10 ký tự đầu của SKU

				        $check_combo = $this->combo_Return_code($sku_full_check);

				        $quantity_get = $data[$i]['quantity'];

				        if(!empty($check_combo)){
				        	
				        	$show_more = $check_combo;

				        	$ar_sku_show[$index][] =  $show_more;

				        }
				        
				        $results[] = [
				            'sku' => $skuShort,
				            'quantity' => $quantity_get,
				            'sku_full' => $skuFull,
				            'sku_full_check' => $sku_full_check,
				            'count_show_more'=> !empty($check_combo)?count($show_more):0,
				           
				        ];
				    }
				}    
			    array_push($data_result, array_reverse($results));
			 
			}
			

			foreach ($ar_sku_show as $key => $group) {
			    // Nếu là mảng chứa nhiều mảng con, thì gộp lại
			    $merged = [];
			    foreach ($group as $subArray) {
			        $merged = array_merge($merged, $subArray);
			    }
			    // Gán lại mảng đã gộp dưới dạng một mảng 2 chiều như cũ
			    $ar_sku_show[$key] = [ $merged ];
			}

		

			$model->calculateCumulativeQuantities($data_result);

			$data_result = $model->show_list_array_run($data_result);

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
			    $pdf->Image($imagePath, 105, 2, 40, 90);

			    $pdf->SetFont('Arial', 'B', 14);
			    $pdf->SetTextColor(0, 0, 0); // Màu đen

			    // === ✅ Ghi đè dữ liệu text theo danh sách ===
			    $index_data = $pageNo - 1;
			    $data_all = $data_result[$index_data];
			    $pdf->SetFont('Arial', 'B', 14);
			    $pdf->SetTextColor(0, 0, 0); // Màu đen

			    
			   
			    for ($i = 0; $i < count($data_all); $i++) {
			    	
			    	
			    	//phần ghi mã sản phẩm khi có combo 

			    	
			    	if(!empty($ar_sku_show[$index_data][$i])  && count($ar_sku_show[$index_data][$i])>0){

			    		$show_sku = $ar_sku_show[$index_data][$i];

			    		$pdf->SetFont('Arial', 'B', 14);
			    		$pdf->SetTextColor(0, 0, 0); // Màu đen

			    		for ($z=0; $z < count($show_sku); $z++) { 

			    			
			    			
			    			$pdf->SetXY(105, $k[$z]);
			    			

			    			$write_show_more = $ar_sku_show[$index_data][$i][$z];

			    			$pdf->Write(10, $write_show_more);
			    		}
			    		
			    	}
			    	else{

			    		$kk = !empty($z)?$z:0;
			    		//phần ghi mã sản phẩm khi có số sản phẩm lớn hơn 2
			    		if(count($data_all)>1){

			    				// $dem = $data_result[$index_data][$i]['count_show_more'];

			    				$pdf->SetFont('Arial', 'B', 14);
						    	$pdf->SetTextColor(0, 0, 0); // Màu đen

						        $pdf->SetXY(105, $k[$kk+$i]);
						        $write_show_more_pd = $data_result[$index_data][$i]['sku'].':'.$data_result[$index_data][$i]['quantity'];

						        $pdf->Write(10, $write_show_more_pd);

			    			
			    		}
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
			    $pdf->SetFont('Arial', 'B', 14);
			    $pdf->SetTextColor(0, 0, 0); // Màu đen
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

		function data_excel($url)
		{
			// $files = 'ex2.xlsx';
            // $file_path = PATH_BASE.'files/'.$files;
            require_once("../libraries/PHPExcel-1.8/Classes/PHPExcel.php");
            $file_path =PATH_BASE.'/admin/export/excel/order_item//2025/06/14/file_nhat_2_2_14_06_25_13.xlsx';
            $objReader = PHPExcel_IOFactory::createReaderForFile($file_path);
            // $data = new PHPExcel_IOFactory();
            // $data->setOutputEncoding('UTF-8');
            $objReader->setLoadAllSheets();


            $objexcel = $objReader->load($file_path);
            $data =$objexcel->getSheet(1)->toArray('null',true,true,true);

            // $data->load($file_path);
            unset($heightRow);  
            $heightRow=$objexcel->setActiveSheetIndex(1)->getHighestRow();
            // printr($data);
            unset($j);

          
            $row = [];
            //chạy vòng đầu để check lỗi trước
            for($j=2;$j<=$heightRow;$j++){
            	$k= $j-2;
            	if(!empty($data[$j]['G'])){
            		$row[$k]['mvd'] = trim($data[$j]['G']);
            		$row[$k]['sku'] =  substr(trim($data[$j]['J']), 0, 10)   ;
	                
            	}
            }	

            return $row;
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



	// phần này để in ra view

	function view_so_khop($controle,$id)
	{
		$model = $controle -> model;
		$data = $model->get_record('id = ' .$id,'fs_order_uploads_history_prints','id,compare_ex_pdf');
		$link = URL_ROOT.$data-> compare_ex_pdf;

		$check = !empty($data-> compare_ex_pdf)?'<a target="_blink" href="' . $link . '">Xem file</a>':'';

	
		return $check;
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

	function view_excel_nhat($controle,$id){
		$model = $controle -> model;
		$data = $model->get_record('id = ' .$id,'fs_order_uploads_history_prints','id,file_xlsx');
		$link = URL_ROOT.$data-> file_xlsx;

		$check = !empty($data-> file_xlsx)?'<a target="_blink" href="' . $link . '">Xem file</a>':'';

		
		return $check;
	}


	function view_status($controle,$id){
		$model = $controle -> model;
		$data = $model->get_record('id = ' .$id,'fs_order_uploads_history_prints','id,file_pdf,total_file_success,total_file');
		$tt = $data-> total_file_success.'/'.$data-> total_file;
		$txt = "In thành công ".$tt." order";
		return $txt;
	}

	function view_id($controle,$id){
		
		
		return $id;
	}


	//chỗ này 

	
	
	
?>