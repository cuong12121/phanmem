<?php
/*
 * Huy write
 */
	// controller
	
	class ProductsControllersCompare extends FSControllers {
		function display()
		{
			$model = new ProductsModelsCompare();
			$ids = FSInput::get('id',0,'array');
			$ids = array_filter($ids);
			$str_ids = implode(',',$ids);
			$first_id = isset($ids[0])?$ids[0]:0;
			$first_item = $model -> get_product_by_id($first_id); 
			$tablename = isset($first_item->tablename)?$first_item->tablename:'';
			$data  = $model -> getProducts($tablename,$str_ids);


			$data_extends = $model-> get_data_extends();
			// extension field
			$ext_fields = $model ->  get_ext_fields($tablename);
			$str_group_fields = '';
			$arr_ext_fileds_by_group = array();
			if(!empty($ext_fields)){
				$i = 0;
				foreach($ext_fields as $item){
					if($item -> group_id){
						if($i > 0)
							$str_group_fields .= ',';
						$str_group_fields .= $item -> group_id;
						$i ++; 
						if(!isset($arr_ext_fileds_by_group[$item -> group_id]))
							$arr_ext_fileds_by_group[$item -> group_id] = array();
						$arr_ext_fileds_by_group[$item -> group_id][] = $item;
					}else{
						if(!isset($arr_ext_fileds_by_group[0]))
							$arr_ext_fileds_by_group[0] = array();
						$arr_ext_fileds_by_group[0][] = $item;
					}
				}
			}
			$ext_group_fields = $model ->  get_ext_group_fields($str_group_fields);
		
			$title = 'So sánh';
			$h2 = 'Kết quả so sánh';
			$h3 = '';
			$title_sort = '';
			$i = 0;
			$records_id = ''; 
			$records_alias = ''; 
			if(count($data)){
				$title .= ' giữa ';
					$h2 .= ' giữa ';
					$h3 .= ' giữa ';
				foreach($data as $item){
					$p_data = $model-> get_record('id = '.$item-> record_id,'fs_products','name_display');
					if($i){
						$title .= ' và ';
						$h2 .= ' và ';
						$h3 .= ' và ';
						$title_sort .= ' và ';
						$records_id .= ',';
						$records_alias .= '-va-';
					}
					if(@$p_data-> name_display) $item -> name = $p_data-> name_display;
					$title .= $item -> name;
					$h2 .= $item -> name;
					$h3 .= $item -> name;
					$title_sort .= $item -> name;
					$records_id .= $item -> record_id;
					$records_alias .= $item -> alias;
					$i ++; 
				}
			}
			global $tmpl,$module_config,$config;
			$tmpl -> setMetakey($title); 
			
			$tmpl -> setTitle($title); 

						// $tmpl->assign ('noindex',1);
			// $tmpl->assign ('canonical',URL_ROOT);
		       
		    // $tmpl->assign ('noindex', 'NOINDEX,NOFOLLOW');

		    $meta_des = str_replace('{name}',$h3,$config['meta_des_ss']);
		    $tmpl -> setMetades($meta_des); 


			$breadcrumbs[] = array(0=>'So sánh sản phẩm', 1 => '');
			
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			include 'modules/'.$this->module.'/views/'.$this->view.'/compare.php';
		}





		function get_data_foreign($table_name,$value,$type){
			$model = $this -> model;
			return $model -> get_data_foreign($table_name,$value,$type);
		}

		function delete_all_compare(){
			$model = $this -> model;
			$table_name = FSInput::get('table_name');
			$cid = FSInput::get('cid');
			unset($_SESSION[$table_name]);
			if(isset($_SESSION[$table_name])){
				print_r(1);
			}else{
				$link = FSRoute::_("index.php?module=products&view=compare&cid=".$cid);
				setRedirect($link);
				return $table_name;
			}
		}
		
		function ajax_get_search_prd()
		{
			$table_name = FSInput::get('table_name');
			$model = $this -> model;	
			$cat = $model ->get_record('tablename ="'.$table_name.'"','fs_products_categories');
			$query_body = $model->set_query_body($table_name);
			$list_cmp = $model->get_list($query_body,$table_name);
			$types = $model -> get_types();
			$total = $model -> getTotal($query_body);	
			$pagination = $model->getPagination($total);
			include 'modules/'.$this->module.'/views/'.$this->view.'/fetch_search_pages.php';
			return;
		}

		function load_resultcompare()
		{
			include 'modules/'.$this->module.'/views/'.$this->view.'/compare_result.php';
			return;
		}

		function save_pdf(){
			$str_ids = FSInput::get('str_ids_product');
			$_SESSION ['save_pdf'] = $str_ids;
			return true;
		}

		// function export_pdf(){
		// 	ob_start();
		// 	ini_set("session.auto_start", 0);
		// 	require_once('libraries/fpdf/tcpdf.php');
		// 	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// 	$pdf->AddPage();
		// 	// $pdf->SetFont('Arial','B',16);
		// 	$pdf->Cell(40,10,'Hello World!');
		// 	$pdf->Output();
		// 	ob_end_flush(); 
		// }

		function export_pdf(){
			ob_start();
			ini_set("session.auto_start", 0);
			$model  = $this -> model;
			global $config;
			
			
			if(!isset($_SESSION['save_pdf'])) {
				$url=URL_ROOT;
				setRedirect ( $url, 'Vui lòng lựa chọn sản phẩm');
			}

	$data_extends = $model-> get_data_extends();			

			$str_ids  = $_SESSION ['save_pdf'];
			$ids = explode(',',$str_ids);

			
			$ids = array_filter($ids);
			$first_id = isset($ids[0])?$ids[0]:0;
			$first_item = $model -> get_product_by_id($first_id); 
			$tablename = isset($first_item->tablename)?$first_item->tablename:'';
			$data  = $model -> getProducts($tablename,$str_ids);

			$ext_fields = $model ->  get_ext_fields($tablename);
			$str_group_fields = '';
			$arr_ext_fileds_by_group = array();
			if(count($ext_fields)){
				$i = 0;
				foreach($ext_fields as $item){
					if($item -> group_id){
						if($i > 0)
							$str_group_fields .= ',';
						$str_group_fields .= $item -> group_id;
						$i ++; 
						if(!isset($arr_ext_fileds_by_group[$item -> group_id]))
							$arr_ext_fileds_by_group[$item -> group_id] = array();
						$arr_ext_fileds_by_group[$item -> group_id][] = $item;
					}else{
						if(!isset($arr_ext_fileds_by_group[0]))
							$arr_ext_fileds_by_group[0] = array();
						$arr_ext_fileds_by_group[0][] = $item;
					}
				}
			}
			$ext_group_fields = $model ->  get_ext_group_fields($str_group_fields);
		
			$title = 'So sánh';
			$title_sort = '';
			$i = 0;
			$records_id = ''; 
			$records_alias = ''; 
			if(count($data)){
				$title .= ' giữa ';
				foreach($data as $item){
					if($i){
						$title .= ' và ';
						$title_sort .= ' và ';
						$records_id .= ',';
						$records_alias .= '-va-';
					}
					$title .= $item -> name;
					$title_sort .= $item -> name;
					$records_id .= $item -> record_id;
					$records_alias .= $item -> alias;
					$i ++; 
				}
			}

			require_once('libraries/fpdf/tcpdf.php');
			$fsFile = FSFactory::getClass('FsFiles');
			$idss=session_id();
			// $image=str_replace('/', '', $test_path['1']);
			$method_resize ='resized_not_crop';
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	// set document information
		// $pdf->SetCreator(PDF_CREATOR);'
			$pdf->SetHeaderData('',0,'','', array(0,0,0), array(255,255,255));
			
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			$pdf->AddPage('M', 'A4');
			// $pdf-> Ln(10);
			$pdf->SetAuthor('Xuân Thắng');
			$pdf->SetTitle($title,'UTF-8');
			// $pdf->Cell(100,10, $pdf->Image(URL_ROOT.$config['logo_pdf'], $pdf->GetX(), $pdf->GetY()), 0, 0, 'L');
			// 
			
			$logo = $config['logo_mobile']; 
	 		$pdf->Image($logo, 15, 15, 60, 0, '');
			
			$pdf->SetFont('roboto', '', 12, '', true);

			$html=<<<EOD
	 		<h2 style="text-align:right;">{$config['company']}</h2>
EOD;
				$pdf->writeHTML($html, false, false, false, false, '');
				$pdf-> Ln(10);
				$pdf->SetFont('robotob', '', 16, '', true);
				$html=<<<EOD
			 	<p style="text-align:center;">SO SÁNH SẢN PHẨM</p>
EOD;
				$pdf->writeHTML($html, false, false, false, false, '');
				$pdf-> Ln(10);
				$pdf->SetFont('roboto', '', 11, '', true);
				$total = count($data);
				$cols = $total >= 4?5:($total + 2);

$tbl='<table border="1" style="width:100%;" cellspacing="0" cellpadding="5">
	<tbody>
		<tr style="background-color:#498d3d;box-sizing: border-box;font-family:robotob;">
			<td colspan="2" style="border:1px solid #498d3d;font-size:14px;color:#fff;">THÔNG SỐ TỔNG QUAN: </td>
		</tr>
		<tr>
			<td width="'. 100/($cols) .'%">Hình ảnh</td>';

			for($i  = 0; $i < $total; $i ++ ){
				@$item = $data[$i];
				$img_product = URL_ROOT.str_replace('/original/','/resized/',$item->image);
				$tbl.='<td align="center" width="'. 100/($cols).'%">'.'<img src="'.$img_product.'"/>'.$item->name.'</td>';

			}

		$tbl.='</tr>';
		$tbl.='<tr>
		<td width="'. 100/($cols) .'%">Giá</td>';
		for($i  = 0; $i  < $total; $i ++ ){
			$item = @$data[$i];
			$tbl.='<td align="center" width="'. 100/($cols).'%">'.format_money($item->price).'</td>';
		}
		$tbl.='</tr>';
		$tbl.='<tr>
		<td width="'. 100/($cols) .'%">Khuyến mại</td>';
		for($i  = 0; $i  < $total; $i ++ ){
			$item = @$data[$i];
			$gift_accessories = $model->get_record('id = ' . $item->record_id,'fs_products','gift_accessories');
			$tbl.='<td align="center" width="'. 100/($cols).'%">'.$gift_accessories -> gift_accessories.'</td>';
		}
		$tbl.='</tr>';
				$j = 0;
				if(count($arr_ext_fileds_by_group) && 1==1){
					foreach($arr_ext_fileds_by_group as $group_id => $fileds_in_group){
						$k = 0;
						$group_field = $ext_group_fields[$group_id];
						foreach($fileds_in_group as $row){
							$field_name = $row -> field_name;
							$field_type = $row -> field_type;
							$tbl.='<tr>';
							if(!$k){
								$tbl.='<td rowspan="'.count($fileds_in_group).'" width="'. 40/($cols).'%">Thông số kỹ thuật</td>';
							}

							if($row->field_name_display){
								$show_field_name_display = $row->field_name_display;
							}else{
								$show_field_name_display = $row->field_name;
							}

							$tbl.='<td width="'. 60/($cols).'%">'. $show_field_name_display .'</td>';
							for($i  = 0; $i  < $total; $i ++ ){
								$item = @$data[$i];
									if($field_type == 'foreign_one' && !empty($data_extends)){
										foreach($data_extends as $ex){
											if($ex ->id == @$item->$field_name){
												$show_field = $ex ->name;
												break;
											}
										}
									}elseif($field_type == 'foreign_multi' && !empty($data_extends)){
										foreach($data_extends as $ex){
											if(strpos(@$item->$field_name, ','.$ex ->id.',') !== false){
												$show_field = $ex ->name .',';
											}
										}
									}else{
										$show_field = @$item->$field_name;
									}
								$tbl.='<td width="'. 100/($cols).'%">'.$show_field.'</td>';
								
							}
							$tbl.='</tr>';
							$k ++;
							$j ++;
						}
					}
				}
	$tbl.='</tbody>
</table>

';

$pdf->writeHTML($tbl, false, false, false, false, '');
$pdf-> Ln(3);



			// -----------//

				$pdf->Output();
				ob_end_flush(); 


		}

	}
?>