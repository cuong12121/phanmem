<?php
class Export_pdfControllersExport_pdf extends FSControllers{
	var $module;
	var $view;
	function display()
	{
		$model = $this -> model;
		$types = $model->get_records('published = 1','fs_products_types','*','','','id');
		$list_cats = $model ->get_cats();
		$array_cats = array();
		$array_products = array();
		$i = 0;
		foreach (@$list_cats as $item)
		{
			if($item->id == 84){
				$query_body = $model->set_query_body($item->id);
				$products_in_cat = $model->get_list($query_body);
				$cat_name = $model->get_record('published = 1 AND id =84','fs_products_categories');

			}
			if(!empty($products_in_cat)){
				$array_cats[] = $item;
				$i ++;
			}
		}
				// printr($products_in_cat);
				// echo "<pre>";
				// print_r($products_in_cat);
		$types = $model -> get_types();
		$extends_items = $model->get_records('published = 1','fs_extends_items','id, name,name_other','','','id');
				// call views			
		include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
	}
	
	function export_nows(){
		// $model_print = @$_SESSION['model_print'];
		// $arr_id = @$_SESSION['id_all_print'];
		// $link ='';
		// if(!$arr_id ){
		// 	$link =URL_ROOT.'admin/products';
		// 	setRedirect($link);
		// 	return;
		// }
		$this->export_barcode_ajax();
		// if($model_print == 'ExportBarCode'){
		// 	$this->export_barcode_ajax($arr_id);
		// }elseif ($model=='ExportBarCodeLabels') {
		// 	$this->export_barcode_labels_ajax($arr_id);
		// }
	}

	function export_barcode_ajax(){
		// if(!$arr_id){
		// 	return;
		// }
		$model  = $this -> model;
		$list = $model->get_data_for_export_ajax();
		
		require_once('libraries/fpdf/tcpdf.php');
		global $config;
		$fsFile = FSFactory::getClass('FsFiles');
		$idss=session_id();
		$method_resize ='resized_not_crop';
		// ob_start();
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetHeaderData('',0,'','', array(0,0,0), array(255,255,255));
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->SetPrintFooter(false);
		$pdf->SetPrintHeader(false);
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$pdf->AddPage('L', 'A4');
		$pdf->SetAuthor('Dương Toản');
		$pdf->SetTitle('In mã vạch','UTF-8');
		$pdf->SetFont('robotob', '', 22, '', true);

		$pdf->SetFont('roboto', '', 11, '', true);

		// define barcode style
		$style = array(
			'position' => '',
			'align' => 'C',
			'stretch' => false,
			'fitwidth' => true,
			'cellfitalign' => 'L',
			'border' => false,
			'hpadding' => 'auto',
			'vpadding' => 'auto',
			'fgcolor' => array(0,0,0),
			    'bgcolor' => false, //array(255,255,255),
			    'text' => true,
			    'font' => 'roboto',
			    'fontsize' => 8,
			    'stretchtext' => 3
			);

		$counter = 1;

		$i = 0 ;

		foreach ($list as $item){
			$product = $model->get_record('id = '.$item->product_id,'fs_products','code,barcode,id');
			if(!$product->code || !$product->barcode || $product->code == '' || $product->barcode == ''){
				continue;
			}

			for ($i=1; $i <= $item->count; $i++){
				
			    $x = $pdf->GetX();
			    $y = $pdf->GetY();
			    $pdf->setCellMargins(0,0,25,0);
			    // The width is set to the the same as the cell containing the name.
			    // The Y position is also adjusted slightly.
			    $pdf->Cell(50, 0, get_word_by_length(15,$product->code), 0, 20, 'C', FALSE, '', 0, FALSE, 'B', 'M');
			    $pdf->SetXY($x,$y);
			    // $pdf->Cell(0, 0, 'CODE 39 EXTENDED', 0, 1);
				$pdf->write1DBarcode($product->barcode, 'C39E', '', '', 50, 15, 0.4, $style, 'N');

			    //Reset X,Y so wrapping cell wraps around the barcode's cell.
			    $pdf->SetXY($x,$y);
			    $pdf->Cell(30, 25, '', 0, 0, 'L', FALSE, '', 0, FALSE, 'C', 'B');
			    if($counter == 5)
			    {
			        $pdf->Ln(20);
			        $counter = 1;
			    }else{
			        $counter++;
			    }
		    }
		}



		$pdf->Ln(30);

		ob_end_clean();
		$pdf->Output('in-ma-vach.pdf', 'I');
		ob_end_flush();
	}

	function export_barcode_labels_ajax($arr_id){
		if(!$arr_id){
			return;
		}
		$model  = $this -> model;
		$list = $model->get_data_for_export_ajax($arr_id);
		
		require_once('libraries/fpdf/tcpdf.php');
		global $config;
		$fsFile = FSFactory::getClass('FsFiles');
		$idss=session_id();
		$method_resize ='resized_not_crop';
			// ob_start();
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetHeaderData('',0,'','', array(0,0,0), array(255,255,255));
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->SetPrintFooter(false);
		$pdf->SetPrintHeader(false);
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$pdf->AddPage('L', 'A4');
		$pdf->SetAuthor('Dương Toản');
		$pdf->SetTitle('In nhãn mã vạch','UTF-8');
		$pdf->SetFont('robotob', '', 22, '', true);

		$pdf->SetFont('roboto', '', 11, '', true);

			// define barcode style
		$style = array(
			'position' => '',
			'align' => 'C',
			'stretch' => false,
			'fitwidth' => true,
			'cellfitalign' => 'L',
			'border' => false,
			'hpadding' => 'auto',
			'vpadding' => 'auto',
			'fgcolor' => array(0,0,0),
		    'bgcolor' => false, //array(255,255,255),
		    'text' => false,
		    'font' => 'roboto',
		    'fontsize' => 8,
		    'stretchtext' => 3
			);

		$counter = 1;

		$i = 0 ;
		$tbl='';
		$tbl='<table border="1" style="width:100%;" cellspacing="0" cellpadding="5">';
		$tbl.='<tbody>';
		// foreach ($list as $item) 
		// {

		 //    $x = $pdf->GetX();
		 //    $y = $pdf->GetY();
		 //    $pdf->setCellMargins(0,0,25,0);
		 //    // The width is set to the the same as the cell containing the name.
		 //    // The Y position is also adjusted slightly.
		 //    // 
		 //    // 
		 
		 //    $pdf->Cell(50, 0, get_word_by_length(15,$item->product_name), 0, 20, 'C', FALSE, '', 0, FALSE, 'B', 'M');
		 //    $pdf->SetXY($x,$y);

		 //    // $pdf->Cell(0, 0, 'CODE 39 EXTENDED', 0, 1);
			// $pdf->write1DBarcode($item->code, 'C39E', '', '', 50, 10, 0.4, $style, 'N');

		 //    //Reset X,Y so wrapping cell wraps around the barcode's cell.
		 //    $pdf->SetXY($x,$y);
		 //    $pdf->Cell(30, 25, '', 0, 0, 'L', FALSE, '', 0, FALSE, 'C', 'B');
		    

		 //    if($counter == 5)
		 //    {
		 //        $pdf->Ln(30);
		 //        $counter = 1;
		 //    }else{
		 //        $counter++;
		 //    }
			$tbl.='<tr style="box-sizing: border-box;">';
				
				$tbl.='<td rowspan="4" style="transform: rotate(-90.0deg);">';
				 $pdf->StartTransform();          
 				$pdf->Rotate(90);
					$tbl.='<p>Xin Chào</p>';
				 $pdf->StopTransform();
				$tbl.='</td>';
				$tbl.='<td>ssdsdssd</td>';
			
			
			$tbl.='</tr>';
			$tbl.='<tr style="box-sizing: border-box;">';
				
				$tbl.='<td>ssdsdssd</td>';
				$tbl.='<td>ssdsdssd</td>';
		
			
			$tbl.='</tr>';
			$tbl.='<tr style="box-sizing: border-box;">';
				
				$tbl.='<td>ssdsdssd</td>';
				$tbl.='<td>ssdsdssd</td>';
				
			
			$tbl.='</tr>';
			$tbl.='<tr style="box-sizing: border-box;">';
				
				$tbl.='<td>ssdsdssd</td>';
				$tbl.='<td>ssdsdssd</td>';
			
			
			$tbl.='</tr>';

			
		// }

		$tbl.='</tbody>';
		$tbl.='</table>';

		$pdf->writeHTML($tbl, false, false, false, false, '');
			$pdf-> Ln(3);
	

		

		

		ob_end_clean();
		$pdf->Output('in-ma-vach.pdf', 'I');
		ob_end_flush();
	}
}

?>