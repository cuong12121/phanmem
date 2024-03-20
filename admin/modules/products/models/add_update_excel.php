<?php 
class ProductsModelsAdd_update_excel extends FSModels
{
	function __construct() {

		$this->type = 'products';
		$this->table_name = 'fs_products';
		$this->use_table_extend = 1;
		$this->table_category = 'fs_' . $this->type . '_categories';
		$this->table_types = 'fs_' . $this->type . '_types';;

		$this->calculate_filters = 1;

		parent::__construct ();
		$this->load_params ();
	}

	function get_data_for_export($tablename)
	{

		global $db;
		$query = " SELECT id,name,code,alias,summary,description,image,manufactory,manufactory_name,driver,partnumber,price,dealer_price ";
		$query .= " FROM fs_products ";
		$query .= " WHERE tablename = '".$tablename."'";
		$query .= " ORDER BY  ordering DESC, id DESC ";
		$query .= "LIMIT 0, 1 ";
		global $db;
		$db -> query($query);
		$rs = $db->getObjectList();
		return $rs;
	}
		// Cập nhật thông tin  sản phẩm


	//Nhúng file PHPExcel
	function import_film_info_new($excel,$path){
		$fsstring = FSFactory::getClass('FSString','','../');
		// require_once 'Classes/PHPExcel.php';
		require_once("../libraries/excel/PHPExcel/Classes_new/PHPExcel.php");
		// echo $path.$excel;
		// die;
		//Đường dẫn file
		$file = $path.$excel;
		//Tiến hành xác thực file
		$objFile = PHPExcel_IOFactory::identify($file);
		$objData = PHPExcel_IOFactory::createReader($objFile);

		//Chỉ đọc dữ liệu
		$objData->setReadDataOnly(true);

		// Load dữ liệu sang dạng đối tượng
		$objPHPExcel = $objData->load($file);

		//Lấy ra số trang sử dụng phương thức getSheetCount();
		// Lấy Ra tên trang sử dụng getSheetNames();

		//Chọn trang cần truy xuất
		$sheet = $objPHPExcel->setActiveSheetIndex(0);

		//Lấy ra số dòng cuối cùng
		$Totalrow = $sheet->getHighestRow();
		//Lấy ra tên cột cuối cùng
		$LastColumn = $sheet->getHighestColumn();

		//Chuyển đổi tên cột đó về vị trí thứ, VD: C là 3,D là 4
		$TotalCol = PHPExcel_Cell::columnIndexFromString($LastColumn);

		//Tạo mảng chứa dữ liệu
		$data = array();

		//Tiến hành lặp qua từng ô dữ liệu
		//----Lặp dòng, Vì dòng đầu là tiêu đề cột nên chúng ta sẽ lặp giá trị từ dòng 2
		for ($i = 2; $i <= $Totalrow; $i++) {
		    //----Lặp cột
		    for ($j = 0; $j < $TotalCol; $j++) {
		        // Tiến hành lấy giá trị của từng ô đổ vào mảng
		        $data[$i - 2][$j] = $sheet->getCellByColumnAndRow($j, $i)->getValue();;
		    }
		}
		//Hiển thị mảng dữ liệu
		
		// printr($data);
		
		$manfs = $this -> get_records('','fs_manufactories','*','','','id');

		// printr($manfs);

		
		$cats =$this -> get_records('','fs_products_categories','alias,name,root_alias,id,tablename,list_parents,published,alias_wrapper','','','id');



		// printr($cats);

		$rs = 0;
		$rs_add = 0;
		$rs_up = 0;
		$not_code_txt = '';
		$not_code_int = 2;
		$total_not_code = 0;

		// ko nhập id danh mục
		$not_cat_txt = '';
		$not_cat_int = 2;
		$total_not_cat = 0;

		//ko nhập tên
		$not_name_txt = '';
		$not_name_int = 2;
		$total_not_name = 0;

		// bắt thêm mới bị trùng mã
		$not_exit_code_txt = '';
		$not_exit_code_int = 2;
		$total_not_exit_code = 0;

		// bắt thêm mới bị trùng tên
		$not_exit_name_txt = '';
		$not_exit_name_int = 2;
		$total_not_exit_name = 0;


		foreach ($data as $key => $item) {
			$row = array();
			// if($item[0]=='ketthuc'){
			// 	$msg =  'Có ' . $rs_add . ' sản phẩm được thêm mới , Có ' . $rs_up . 'sản phẩm được update';
			// 	if($total_not_code > 0){
			// 		$msg .= ', Có ' .$total_not_code . ' không nhập mã sản phẩm ở các dòng ' . $not_code_txt;
			// 	}
			// 	if($total_not_cat > 0){
			// 		$msg .= ', Có ' .$total_not_cat . ' không nhập id danh mục ở các dòng ' . $not_cat_txt;
			// 	}
			// 	return $msg;
			// }
			if($item[0]){
				$row['code'] = $item[0];
			}else{
				$not_code_txt .= $not_code_int .',';
				$total_not_code++;
				// $not_code_int++;
				// $not_cat_int++;
				// continue;
			}

			if($item[1]){
				$row['name'] = $item[1];
			}else{
				$not_name_txt .= $not_name_int .',';
				$total_not_name++;
			}

			if(!$item[4]){
				$not_cat_txt .= $not_cat_int .',';
				$total_not_cat++;
				// $not_cat_int++;
				// $not_code_int++;
				// continue;
			}

			

			if(!$item[0] || !$item[1] || !$item[4]){
				// $total_not_code++;
				// $total_not_cat++;
				// $total_not_name++;
				$not_exit_code_int ++;
				$not_code_int++;
				$not_cat_int++;
				$not_name_int++;
				continue;
			}

			$product_exist_name = $this -> get_record('name="'.$item[1].'"','fs_products','id,name');

			if($product_exist_name){

				$not_exit_name_txt .= $not_exit_name_int .',';
				$total_not_exit_name++;

				$not_exit_name_int ++;
				$not_exit_code_int ++;
				$not_code_int++;
				$not_cat_int++;
				$not_name_int++;


				continue;
			}

			
			$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
			
			$row['alias'] = $fsstring->stringStandart($row['name']);
			

			if($item[2]){
				$price_old = $item[2];
			}else{
				$price_old = 0;
			}

			if($item[3]){
				$price= $item[3];
			}else{
				$price = 0;
			}

			if($price_old < $price){
				$price_old = $price;
				
			}

			$row['price_old'] = $price_old;
			
			$row['price'] = $price;

			if($price_old > $price){
				$row ['discount'] = round((($price_old - $price) / $price_old) * 100);
			}else{
				$row ['discount'] = 0;
			}
			

			if($item[4]){
				$cat = $cats[$item[4]];
				if(!empty($cat)){
					$table_name = isset($cat->tablename)?$cat->tablename:'';
					$row ['category_id'] = $cat->id;
					$row ['category_id_wrapper'] = $cat->list_parents;
					$row ['category_root_alias'] = $cat->root_alias;
					$row ['category_alias_wrapper'] = $cat->alias_wrapper;
					$row ['category_name'] = $cat->name;
					$row ['category_alias'] = $cat->alias;
					$row ['category_published'] = $cat->published;
					$row ['tablename'] = $cat->tablename;
				}
				
			}

			$row['edited_time'] = date('Y-m-d H:i:s');
			
			$product_exist = $this -> get_record('code="'.$item[0].'"','fs_products','id,code,tablename');

			if(!$product_exist){
				$row['action_username'] = $_SESSION['ad_username'];
				$row['action_id'] = $_SESSION['ad_userid'];
				$row['nofollow'] = 1;
				$row['published'] = 0;
				$row['created_time'] =date('Y-m-d H:i:s');
				
				$product_new_id = $this -> _add($row,'fs_products',1);
				if($product_new_id && $row['tablename'] !='fs_products'){

					$row_tablename = $row['tablename'];
					unset($row['action_username']);
					unset($row['action_id']);
					unset($row['nofollow']);
					unset($row['tablename']);
					
					$row['record_id'] = $product_new_id;
					// printr($row);
					$product_add_id = $this -> _add($row,$row_tablename,1);
					if($product_add_id){
						$rs_add++;
					}
				}
			}else{
				$not_exit_code_txt .= $not_exit_code_int .',';
				$total_not_exit_code++;
			}
			$not_exit_name_int ++;
			$not_exit_code_int ++;
			$not_cat_int++;
			$not_code_int++;
			$not_name_int++;
			$rs++;
			
		}

		$msg =  'Có ' . $rs_add . ' thêm mới';
		if($total_not_exit_code > 0){
			$msg .= ', Có ' .$total_not_exit_code . ' lỗi mã sản phẩm đã tồn tại ở các dòng ' . $not_exit_code_txt;
		}
		if($total_not_exit_name > 0){
			$msg .= ', Có ' .$total_not_exit_name . ' lỗi tên sản phẩm đã tồn tại ở các dòng ' . $not_exit_name_txt;
		}
		if($total_not_code > 0){
			$msg .= ', Có ' .$total_not_code . ' lỗi không nhập mã sản phẩm ở các dòng ' . $not_code_txt;
		}
		if($total_not_cat > 0){
			$msg .= ', Có ' .$total_not_cat . ' lỗi không nhập id danh mục ở các dòng ' . $not_cat_txt;
		}

		if($total_not_name > 0){
			$msg .= ', Có ' .$total_not_name . ' lỗi không nhập tên ở các dòng ' . $not_name_txt;
		}
		return $msg;

	}
	
	function save_extend_from_specs_in_excel($product_exist,$row){
       // printr($row);
		if(!$product_exist || !$row)
			return;
		 // printr($product_exist);
		 // echo $product_exist->tablename;
		 // echo $product_exist->id;
		 // die;
		$this -> _update($row, $product_exist->tablename,'record_id = '.$product_exist->id);
	}

	function get_string_id($str,$group_name){
		$arr = explode('+',$str);
		// printr($arr_xuat_xu);
		$str_id = ',';
		foreach ($arr as $item) {
			$get_id = $this->get_record('name = "' .$item .'" AND group_id = "' .$group_name. '"','fs_extends_items','id');
			if(!empty($get_id)){
				$str_id .= $get_id->id.',';
			}else{
				continue;
			}
		}
		return $str_id;
	}

	function get_int_id($str,$group_name){

		$get_id = $this->get_record('name = "' .$str .'" AND group_id = "' .$group_name. '"','fs_extends_items','id');
		if(!empty($get_id)){
			return $get_id->id;
		}else{
			return '';
		}

		
	}



	function import_film_info($excel,$path){
		$fsstring = FSFactory::getClass('FSString','','../');	
		$file_path = $path.$excel;
		// require_once("../libraries/excel/phpExcelReader/Excel/reader.php");
		require_once("../libraries/excel/phpExcelReader/Excel/excel_reader2.php");
		
		$data = new Spreadsheet_Excel_Reader();
		// $data->setOutputEncoding('UTF-8');
		$data->setOutputEncoding('utf-8');

		// header("content-type:application/csv;charset=UTF-8");
                       // echo $file_path.'fffff';die;
		$data->read($file_path);
		unset($total_product);			
		$total_product =count($data->sheets[0]['cells']);
		$info_import_product =array();
		unset($j);
		$arr_field_name = $data->sheets['0']['cells']['1'];
		$total_field_name =count($arr_field_name);
		// printr($total_product);

		// die;

		$rs = 0;
		for($j=0;$j<=$total_product;$j++){
			$info_import_product['id'] = preg_replace('/[^0-9]+/i','',$this->get_cell_content_by_name($data,0,$j,'id',$arr_field_name));
			$info_import_product['code'] = $this->get_cell_content_by_name($data,0,$j,'code',$arr_field_name);
			$info_import_product['xuat_xu'] = $this->get_cell_content_by_name($data,0,$j,'xuat_xu',$arr_field_name);
			$info_import_product['vo'] = $this->get_cell_content_by_name($data,0,$j,'vo',$arr_field_name);
			$info_import_product['loai_day'] = $this->get_cell_content_by_name($data,0,$j,'loai_day',$arr_field_name);
			$info_import_product['duongkinh'] = $this->get_cell_content_by_name($data,0,$j,'duongkinh',$arr_field_name);
			$info_import_product['do_day'] = $this->get_cell_content_by_name($data,0,$j,'do_day',$arr_field_name);
			$info_import_product['do_chiu_nuoc'] = $this->get_cell_content_by_name($data,0,$j,'do_chiu_nuoc',$arr_field_name);
			$info_import_product['mau_mat'] = $this->get_cell_content_by_name($data,0,$j,'mau_mat',$arr_field_name);
			$info_import_product['mat_kinh'] = $this->get_cell_content_by_name($data,0,$j,'mat_kinh',$arr_field_name);

			if( !$info_import_product['id'] && !$info_import_product['code'] )
				continue;

			// echo "<pre>";
			// print_r($info_import_product);
			// die();

			$row = array();
			if($info_import_product['xuat_xu']){
				$str_xuat_xu = $this->get_string_id($info_import_product['xuat_xu'],'Xuất xứ');
				$row['xuat_xu'] = $str_xuat_xu;
			}
			if($info_import_product['vo']){
				$info_import_product['vo'];

				$str_vo = $this->get_string_id($info_import_product['vo'],'Vỏ');
				
				$row['vo'] = $str_vo;
			}
			if($info_import_product['loai_day']){
				$str_loai_day= $this->get_string_id($info_import_product['loai_day'],'Dây đồng hồ');
				$row['loai_day'] = $str_loai_day;
			}
			if($info_import_product['duongkinh']){
				$row['duongkinh'] = $info_import_product['duongkinh'];
			}
			if($info_import_product['do_day']){
				$row['do_day'] = $info_import_product['do_day'];
			}
			if($info_import_product['do_chiu_nuoc']){
				$row['do_chiu_nuoc'] = $info_import_product['do_chiu_nuoc'];
			}
			if($info_import_product['do_chiu_nuoc']){
				$row['do_chiu_nuoc'] = $info_import_product['do_chiu_nuoc'];
			}
			if($info_import_product['mau_mat']){
				$row['mau_mat'] = $info_import_product['mau_mat'];
			}
			if($info_import_product['mat_kinh']){
				$row['mat_kinh'] = $info_import_product['mat_kinh'];
			}

			if($info_import_product['id']){
				$product_exist =$this -> get_record('id="'.$info_import_product['id'].'"','fs_products','id,code,tablename');
			}else{
				$product_exist =$this -> get_record('code="'.$info_import_product['code'].'"','fs_products','id,code,tablename');
			}

			// $table_name = isset($product_exist->tablename)?$product_exist->tablename:'';
			echo $product_exist->id."++";
			if(!$product_exist){
				continue;
			}else{
	
				$ext_id = $this->save_extend_from_specs_in_excel($product_exist,$row);	

				$rs++;

			}
		}
		// echo $rs;
		// die;
		return $rs;
	}

		

		/*
		 * Lưu lại trường mở rộng trong trường SPECS từ EXCEL
		 * Chú ý cấu trúc SPECS: Mỗi trường mở rộng một dòng
		 * 
		 */
		
		
		function get_cell_content_by_name($data,$sheet_index,$row_index,$field_name,$arr_field_name){
			$dem=1;
			foreach ($arr_field_name as $key=>$item) {
				if($field_name == $item){
					if($dem > 1){
						Errors::_ ( 'File bạn vừa nhập có '.$dem.' : '.$field_name);
						return false;
					}
					else
						$content = isset($data->sheets[$sheet_index]['cells'][$row_index][$key])?$data->sheets[$sheet_index]['cells'][$row_index][$key]:'';
					$dem++;
				}
			} 
			return $content;
		}

		function seems_utf8($str) {
			for ($i=0; $i<strlen($str); $i++) {
	            if (ord($str[$i]) < 0x80) continue; # 0bbbbbbb
	            elseif ((ord($str[$i]) & 0xE0) == 0xC0) $n=1; # 110bbbbb
	            elseif ((ord($str[$i]) & 0xF0) == 0xE0) $n=2; # 1110bbbb
	            elseif ((ord($str[$i]) & 0xF8) == 0xF0) $n=3; # 11110bbb
	            elseif ((ord($str[$i]) & 0xFC) == 0xF8) $n=4; # 111110bb
	            elseif ((ord($str[$i]) & 0xFE) == 0xFC) $n=5; # 1111110b
	            else return false; # Does not match any model
	            for ($j=0; $j<$n; $j++) { # n bytes matching 10bbbbbb follow ?
	            	if ((++$i == strlen($str)) || ((ord($str[$i]) & 0xC0) != 0x80))
	            		return false;
	            }
	        }
	        return true;
	    }
	}
	
	?>