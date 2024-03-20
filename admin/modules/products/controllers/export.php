<?php
class ProductsControllersExport  extends Controllers
{
	function __construct()
	{	
		$this->limit = 20; 
		$this->view = 'export' ; 
		parent::__construct(); 
	}
	function display()
	{

		$model  = $this -> model;
//print_r($_SESSION);
		//$keysearch = @$_SESSION [$this->prefix . 'keysearch'];

		parent::display();
		$sort_field = $this -> sort_field;
		$sort_direct = $this -> sort_direct;

		
		$list = $model->get_data();
		$categories = $model->get_categories_tree();
		$type = $model->get_type();
		$types = $model -> get_records('published = 1','fs_products_types');
		$manufactories = $model->get_manufactories();
		$pagination = $model->getPagination();
		$style_status = $model -> get_records('published = 1','fs_products_status');

		include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
	}
	function view_name($data){
		$link = FSRoute::_('index.php?module=products&view=product&id='.$data->id.'&code='.$data -> alias.'&ccode='.$data-> category_alias);
		return '<a target="_blink" href="' . $link . '" title="Xem ngoài font-end">'.$data -> name.'</a>';
	}
	
	function add()
	{
		$model = $this -> model;
		$cid = FSInput::get('cid');
	
		$style_status = $model -> get_records('published = 1','fs_products_status');
		if($cid)
		{
			
			$category = $model->get_record_by_id($cid,'fs_products_categories'); 
			$tablename = $category->tablename;
			$relate_categories = $model->getRelatedCategories($category -> tablename);
			$manufactories = $model->getManufactories($category -> tablename);
			$origins = $model-> getOrigins();
				// types
			$types = $model -> get_records('published = 1','fs_products_types');
			$types_compatables = $model -> get_records('published = 1','fs_products_types_ompatables');

				// extend field
			$extend_fields = $model->getExtendFields($category -> tablename);


			$data_foreign = $model -> get_data_foreign($extend_fields);
			$maxOrdering = $model->getMaxOrdering();
			$maxOrdering2 = $model->getMaxOrdering2();
		

				// all categories
			$categories = $model->get_categories_tree();

				// news related
			$news_categories = $model->get_news_categories_tree();

				/*
				 * Lấy tham số cấu hình module
				 */
				$module_params = $model -> module_params;
				FSFactory::include_class('parameters');
				$current_parameters = new Parameters($module_params);
				$use_manufactory   = $current_parameters->getParams('use_manufactory');
				$use_model   = $current_parameters->getParams('use_model');
				if($use_manufactory){
					$manufactories = $model->getManufactories($tablename);
					if($use_model)
						$product_models = $model->get_product_models($manufactories[0]->id);
				}
				$memory  = $model -> get_records('published = 1','fs_memory');
				$usage_states  = $model -> get_records('published = 1','fs_usage_states');
				$regions =  $model -> get_records('published = 1','fs_locations_regions');
				$warranty  = $model -> get_records('published = 1','fs_warranty');
				$origin  = $model -> get_records('published = 1','fs_origin');
				$species  = $model -> get_records('published = 1','fs_species');
				
				$landingpage_template  = $model -> get_records('alias = "default" AND published = 1','fs_products_landingpages');

				$uploadConfig = base64_encode('add|'.session_id());
				include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
			}
			else{
				$categories = $model->get_categories_tree();
				include 'modules/'.$this->module.'/views/'.$this -> view.'/select_categories.php';
			}
		}
		
		
		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			$data = $model->get_record_by_id($id);
			$category= $model->get_record_by_id($data->category_id,'fs_products_categories');
			$origins = $model-> getOrigins();
			$tablename = $data->tablename ?  $data->tablename  : $category -> tablename;
			// extend field
			$extend_fields = $model->getExtendFields($tablename); 
			$relate_categories = $model->getRelatedCategories($tablename);
			
			// products related
			$categories = $model->get_categories_tree();
			$products_related = $model -> get_products_related($data -> products_related);
			
			// news related
			$news_categories = $model->get_news_categories_tree();
			$news_related = $model -> get_news_related($data -> news_related);
			
			$style_status = $model -> get_records('published = 1','fs_products_status');
			// types
			$types = $model -> get_records('published = 1','fs_products_types');
			$types_compatables = $model -> get_records('published = 1','fs_products_types_compatables');
//			$images_plus = $model->get_product_images_plus($data -> id);
			$images = $model->get_product_images($data -> id);

			$slideshow_highlight =  $model->get_product_slideshow_highlight($data -> id);
			// colors
			$colors = $model -> get_records('published = 1','fs_products_colors');
			$colors_to_upload_image = array();
			$array_data_by_color = array();
			foreach (@$colors as $item)
			{
				$data_by_color = $model -> get_data_by_color($item->id,$data->id );
				if(!empty($data_by_color)){
					$array_data_by_color [$item->id] = $data_by_color;	
					$colors_to_upload_image[$item ->id ] = $item;
				}
			}
			if(!$array_data_by_color){
				$colors_to_upload_image = $colors;
			}
			
			$data_ext = $model->getProductExt($data -> tablename,$data->id);
			$data_foreign = $model -> get_data_foreign($extend_fields);
			$products_compatable = $model -> get_products_compatable($data -> id);
			$products_service = $model -> get_products_service($data -> products_service);
			$products_incentives = $model -> get_products_incentives($data -> id);
			$products_compare = $model -> get_products_compare($data -> products_compare);

			/*
			 * Lấy tham số cấu hình module
			 */
			$module_params = $model -> module_params;
			FSFactory::include_class('parameters');
			$current_parameters = new Parameters($module_params);
			$use_manufactory   = $current_parameters->getParams('use_manufactory');
			$use_model   = $current_parameters->getParams('use_model');
			if($use_manufactory){
				$manufactories = $model->getManufactories($tablename);
				if($use_model)
					$product_models = $model->get_product_models($data -> manufactory);
			}
			$memory  = $model -> get_records('published = 1','fs_memory');
			

			foreach (@$memory as $item){
				$data_by_memory = $model -> get_data_by_memory($item->id,$data->id );
				if(!empty($data_by_memory)){
					$array_data_by_memory [$item->id] = $data_by_memory;	
				}
			}


			$extend_price  = $model -> get_records('published = 1','fs_extends_items');
			foreach (@$extend_price as $item){
				$data_by_extend_price = $model -> get_data_by_extend_price($item->id,$data->id );
				//print_r($data_by_extend_price);
				if(!empty($data_by_extend_price)){
					$arr_data_by_extend_price [$item->id] = $data_by_extend_price;	
				}
			}



			$usage_states  = $model -> get_records('published = 1','fs_usage_states');
			foreach (@$usage_states as $item){
				$data_by_usage_states = $model -> get_data_by_usage_states($item->id,$data->id );
				if(!empty($data_by_usage_states)){
					$array_data_by_usage_states [$item->id] = $data_by_usage_states;	
				}
			}

			$regions =  $model -> get_records('published = 1','fs_locations_regions');
			foreach (@$regions as $item){
				$data_by_regions = $model -> get_data_by_regions($item->id,$data->id );

				if(!empty($data_by_regions) ){
					$array_data_by_regions [$item->id] = $data_by_regions;	
				}
			}

			$warranty  = $model -> get_records('published = 1','fs_warranty');
			foreach (@$warranty as $item){
				$data_by_warranty = $model -> get_data_by_warranty($item->id,$data->id );
				if(!empty($data_by_warranty)){
					$array_data_by_warranty [$item->id] = $data_by_warranty;	
				}
			}

			$origin  = $model -> get_records('published = 1','fs_origin');

			foreach (@$origin as $item){
				$data_by_origin = $model -> get_data_by_origin($item->id,$data->id );
				if(!empty($data_by_origin)){
					$array_data_by_origin [$item->id] = $data_by_origin;	
				}
			}

			$species  = $model -> get_records('published = 1','fs_species');
			
			foreach (@$species as $item){
				$data_by_species = $model -> get_data_by_species($item->id,$data->id );
				if(!empty($data_by_species)){
					$array_data_by_species [$item->id] = $data_by_species;	
				}
			}

			$landingpage_template  = $model -> get_record('alias = "default" AND published = 1','fs_products_landingpages');
			

			// add hidden input tag : ext_id into detail form 
			$this->params_form = array('ext_id'=>@$data_ext -> id) ;
			$uploadConfig = base64_encode('edit|'.$id);			
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
		
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

		// function export(){
		// 	setRedirect('index.php?module='.$this -> module.'&view='.$this -> view.'&task=export_file&raw=1');
		// }	

		function export(){
			FSFactory::include_class('excel','excel');
//			require_once 'excel.php';
			$model  = $this -> model;
			$filename = 'product-export-'.date('d-m-Y');
			$filter0 = @$_SESSION [$this->prefix . 'filter0'];
			$filter1 = @$_SESSION [$this->prefix . 'filter1'];
			$keysearch = @$_SESSION [$this->prefix . 'keysearch'];
			$fsstring = FSFactory::getClass ( 'FSString', '', '../' );

			if($keysearch) {
				$filename .= '-'.$fsstring->stringStandart ( $keysearch );
			}
			if ($filter0) {
				$cat_filter = $model -> get_records('id ='.$filter0,'fs_products_categories');
				$filename .=  '-'.$cat_filter[0]-> alias;
			}
			if ($filter1) {
				$manf_filter = $model ->  get_records('id ='.$filter1,'fs_manufactories');

				$filename .= '-'.$manf_filter[0]-> alias;
			}

			$list = $model->get_data_for_export();
			// print_r($_SESSION);
			//echo "<pre>";
			//print_r($list);die;
			//$categories = $model -> get_records('','fs_products_categories','id,code,alias,name,tablename','','','id');
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

				$excel->obj_php_excel->getActiveSheet ()->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$excel->obj_php_excel->getActiveSheet ()->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$excel->obj_php_excel->getActiveSheet ()->getDefaultStyle()->getAlignment()->setWrapText(true);
				
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
				// $excel->obj_php_excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
				// $excel->obj_php_excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
				// $excel->obj_php_excel->getActiveSheet()->getColumnDimension('J')->setWidth(40);
				// $excel->obj_php_excel->getActiveSheet()->getColumnDimension('K')->setWidth(40);
				// $excel->obj_php_excel->getActiveSheet()->getColumnDimension('L')->setWidth(40);
				// $excel->obj_php_excel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
				// $excel->obj_php_excel->getActiveSheet()->getColumnDimension('N')->setWidth(40);
				// $excel->obj_php_excel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
				// $excel->obj_php_excel->getActiveSheet()->getColumnDimension('P')->setWidth(25);
				// $excel->obj_php_excel->getActiveSheet()->getColumnDimension('Q')->setWidth(25);
				// $excel->obj_php_excel->getActiveSheet()->getColumnDimension('R')->setWidth(25);
				// $excel->obj_php_excel->getActiveSheet()->getColumnDimension('S')->setWidth(15);
				// $excel->obj_php_excel->getActiveSheet()->getColumnDimension('T')->setWidth(15);
				// $excel->obj_php_excel->getActiveSheet()->getColumnDimension('U')->setWidth(15);
				// $excel->obj_php_excel->getActiveSheet()->getColumnDimension('V')->setWidth(15);
				// $excel->obj_php_excel->getActiveSheet()->getColumnDimension('W')->setWidth(15);
				

				
				$excel->obj_php_excel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				$excel->obj_php_excel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				$excel->obj_php_excel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				$excel->obj_php_excel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				$excel->obj_php_excel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				$excel->obj_php_excel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
				$excel->obj_php_excel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );

				
				$excel->obj_php_excel->getActiveSheet()->setCellValue('A1', 'id');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('B1', 'ma_san_pham');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('C1', 'name');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('D1', 'price_old');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('E1', 'price');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('F1', 'id_danhmuc');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('G1', 'trang_thai');
				
		
				
				
				$total_money = 0;
				$total_quantity = 0;
				$i=0;
				//echo count($list);die;
				foreach ($list as $item){
					$key = isset($key)?($key+1):2;

					$excel->obj_php_excel->getActiveSheet()->setCellValue('A'.$key, $item->id);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.$key, $item->code);		
					$excel->obj_php_excel->getActiveSheet()->setCellValue('C'.$key, $item->name);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('D'.$key, $item->price_old);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('E'.$key, $item->price);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('F'.$key, $item->category_id);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('G'.$key, $item->status);
					$i ++;
				}

				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray( $style_header );
				$excel->obj_php_excel->getActiveSheet()->duplicateStyle( $excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:G1' );

				$excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(40);
				
//				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getAlignment()->setIndent(1);// padding cell
				
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

				echo $link_excel = URL_ROOT.LINK_AMIN.'/export/excel/'. $filename.'.xls';
				?>
				<?php setRedirect($link_excel); ?>
				<?php 
				readfile($path_file);
			}
		}



		function export_qc(){
			FSFactory::include_class('excel','excel');
			$model  = $this -> model;
			$filename = 'product-export-'.date('d-m-Y');
			$filter0 = @$_SESSION [$this->prefix . 'filter0'];
			$filter1 = @$_SESSION [$this->prefix . 'filter1'];
			$keysearch = @$_SESSION [$this->prefix . 'keysearch'];
			$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
			$style_status = $model -> get_records('published = 1','fs_products_status','*','id ASC','','id');
			if($keysearch) {
				$filename .= '-'.$fsstring->stringStandart ( $keysearch );
			}
			if ($filter0) {
				$cat_filter = $model -> get_records('id ='.$filter0,'fs_products_categories');
				$filename .=  '-'.$cat_filter[0]-> alias;
			}
			if ($filter1) {
				$manf_filter = $model ->  get_records('id ='.$filter1,'fs_manufactories');

				$filename .= '-'.$manf_filter[0]-> alias;
			}

			$list = $model->get_data_for_export_qc();
			// print_r($_SESSION);
			//echo "<pre>";
			//print_r($list);die;
			//$categories = $model -> get_records('','fs_products_categories','id,code,alias,name,tablename','','','id');
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

				$excel->obj_php_excel->getActiveSheet ()->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$excel->obj_php_excel->getActiveSheet ()->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$excel->obj_php_excel->getActiveSheet ()->getDefaultStyle()->getAlignment()->setWrapText(true);
				
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('J')->setWidth(40);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('K')->setWidth(40);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('L')->setWidth(40);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('N')->setWidth(40);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('P')->setWidth(25);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('Q')->setWidth(25);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('R')->setWidth(25);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('S')->setWidth(15);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('T')->setWidth(15);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('U')->setWidth(15);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('V')->setWidth(15);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('W')->setWidth(15);
				

				
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

				
				$excel->obj_php_excel->getActiveSheet()->setCellValue('A1', 'ID');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('B1', 'Tiêu đề');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('C1', 'Mô tả');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('D1', 'Liên kết');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('E1', 'Tình trạng');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('F1', 'Giá gốc');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('G1', 'Giá khuyến mãi');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('H1', 'Còn hàng');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('I1', 'Liên kết hình ảnh');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('J1', 'Nhãn hiệu');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('K1', 'Danh mục sản phẩm của google');
				
		
				
				
				$total_money = 0;
				$total_quantity = 0;
				$i=0;
				//echo count($list);die;
				foreach ($list as $item){
					$key = isset($key)?($key+1):2;
					$link = FSRoute::_('index.php?module=products&view=product&code='.$item -> alias.'&ccode='.$item->category_alias.'&id='.$item->id.'&cid='.$item->category_id.'&Itemid='.$Itemid);;
					$image = URL_ROOT . str_replace('/original/','/large/',$item->image);
					$status = $style_status[$item-> status]->name;
					$excel->obj_php_excel->getActiveSheet()->setCellValue('A'.$key, $item->code);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.$key, $item->name);		
					$excel->obj_php_excel->getActiveSheet()->setCellValue('C'.$key, strip_tags($item->description));
					$excel->obj_php_excel->getActiveSheet()->setCellValue('D'.$key, $link);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('E'.$key, 'Mới');
					$excel->obj_php_excel->getActiveSheet()->setCellValue('F'.$key, $item->price_old);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('G'.$key, $item->price);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('H'.$key, $status);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('I'.$key, $image);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('J'.$key, $item->manufactory_name);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('K'.$key, "Business && Industrial > Retail");
					$i ++;
				}

				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray( $style_header );
				$excel->obj_php_excel->getActiveSheet()->duplicateStyle( $excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:K1' );

				$excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(40);
				
//				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getAlignment()->setIndent(1);// padding cell
				
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

				echo $link_excel = URL_ROOT.LINK_AMIN.'/export/excel/'. $filename.'.xls';
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

}
function view_history($controle,$record_id) {
	$link = 'index.php?module=products&view=history&record_id=' . $record_id;
	return '<a href="' . $link . '" target="_blink"><img border="0" src="templates/default/images/clock_red.png" alt="History"></a>';
}

?>



