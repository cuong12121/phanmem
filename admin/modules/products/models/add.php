<?php 
class ProductsModelsAdd extends FSModels
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
	function import_film_info($excel,$path){
		$fsstring = FSFactory::getClass('FSString','','../');	
		$file_path = $path.$excel;
		require_once("../libraries/excel/phpExcelReader/Excel/reader.php");
		$data = new Spreadsheet_Excel_Reader();
		$data->setOutputEncoding('UTF-8');
//                        echo $file_path.'fffff';die;
		$data->read($file_path);
		unset($total_product);			
		$total_product =count($data->sheets[0]['cells']);
		$info_import_product =array();
		unset($j);

//			$categories = $this -> get_records('','fs_products_categories','*',' ordering DESC ','','code');
//			$manufactories = $this -> get_records('','fs_manufactories','*','','','code');
			// lấy toàn bộ dữ liệu trong bảng products_tables
		$products_tables_all = $this -> get_records('','fs_products_tables');
			//Lấy  tên trong bang exel
		$arr_field_name = $data->sheets['0']['cells']['1'];
		$total_field_name =count($arr_field_name);
			//end Lấy  tên trong bang exel

		$rs = 0;
		for($j=2;$j<=$total_product+1;$j++){
			// $info_import_product['id'] = preg_replace('/[^0-9]+/i','',$this->get_cell_content_by_name($data,0,$j,'id',$arr_field_name));
				//$info_import_product['category_id'] = preg_replace('/[^0-9]+/i','',$this->get_cell_content_by_name($data,0,$j,'category_id',$arr_field_name));
			$info_import_product['cid'] = $this->get_cell_content_by_name($data,0,$j,'id_danhmuc',$arr_field_name);
			$info_import_product['manfid'] = $this->get_cell_content_by_name($data,0,$j,'id_hangsx',$arr_field_name);
			$info_import_product['name'] = $this->get_cell_content_by_name($data,0,$j,'name',$arr_field_name);
			$info_import_product['types'] = $this->get_cell_content_by_name($data,0,$j,'loai',$arr_field_name);
			$info_import_product['description'] = $this->get_cell_content_by_name($data,0,$j,'mo_ta',$arr_field_name);
			$info_import_product['code'] = $this->get_cell_content_by_name($data,0,$j,'code',$arr_field_name);
			$info_import_product['quantity'] = $this->get_cell_content_by_name($data,0,$j,'quantity',$arr_field_name);
			$info_import_product['alias'] = $this->get_cell_content_by_name($data,0,$j,'alias',$arr_field_name);
			//	echo $info_import_product['name'].'sss';
			//	echo $info_import_product['code'];
			//////	die;
			if(!$info_import_product['name'] || !$info_import_product['cid'])
				continue;
//				$info_import_product['description'] = $this->get_cell_content_by_name($data,0,$j,'Description',$arr_field_name);
//				$info_import_product['summary'] = $this->get_cell_content_by_name($data,0,$j,'Summary',$arr_field_name);
//				$info_import_product['specs'] = $this->get_cell_content_by_name($data,0,$j,'Specs',$arr_field_name);
			// $info_import_product['price'] =  preg_replace('/[^0-9]+/i','',$this->get_cell_content_by_name($data,0,$j,'price',$arr_field_name));
			$info_import_product['price_old'] =  preg_replace('/[^0-9]+/i','',$this->get_cell_content_by_name($data,0,$j,'price_old',$arr_field_name));
			$info_import_product['discount'] =  $this->get_cell_content_by_name($data,0,$j,'discount',$arr_field_name);
			$info_import_product['discount_unit'] =  $this->get_cell_content_by_name($data,0,$j,'discount_unit',$arr_field_name);
//				$info_import_product['published'] = preg_replace('/[.*]+/i','',$this->get_cell_content_by_name($data,0,$j,'published',$arr_field_name));

			$info_import_product['is_new'] =  $this->get_cell_content_by_name($data,0,$j,'is_new',$arr_field_name);
			$info_import_product['is_sell'] =  $this->get_cell_content_by_name($data,0,$j,'is_sell',$arr_field_name);
			$info_import_product['gift'] = $this->get_cell_content_by_name($data,0,$j,'bao_hanh',$arr_field_name);

			$row = array();
			if($info_import_product['name']){
				$row['name'] = $info_import_product['name'];
			}
			if($info_import_product['types']){
				$row['types'] = $info_import_product['types'];
			}
			if($info_import_product['description']){
				$row['description'] = $info_import_product['description'];
			}
			if($info_import_product['code']){
				$row['code'] = $info_import_product['code'];
			}
			if($info_import_product['alias']){
				$row['alias'] = $info_import_product['alias'];
			}else{
				$row['alias'] = $fsstring -> stringStandart($row['name']);
			}
			if($info_import_product['quantity']){
				$row['quantity'] = $info_import_product['quantity'];
			}
//                                if($info_import_product['name']){
//                                    $row['alias2'] = $fsstring -> stringStandart($row['name']);
//                                }
//				$row['description'] =  nl2br($info_import_product['description']);
//				$row['summary'] = $info_import_product['summary'];
//				$row['specs'] =  $info_import_product['specs'];
			$price = $info_import_product['price'];
			$discount = $info_import_product['discount'];
			if($info_import_product['discount_unit']){
				$row['discount_unit'] = $info_import_product['discount_unit'];
			}
//				$row['discount'] = $info_import_product['discount'];
			$row['edited_time'] = $row['edited_time'] = date('Y-m-d H:i:s');
			$row['published'] =1;
			$row['is_accessories'] =0;
			$row['is_new'] =$info_import_product['is_new'];
			$row['is_sell'] =$info_import_product['is_sell'];
			$row['gift'] =$info_import_product['gift'];



                                //price
			$price_old = $info_import_product['price_old'];
			$discount = $info_import_product['discount'];
			$discount_unit =    $info_import_product['discount_unit'];
			if ($discount_unit == 'percent') {
				if ($discount > 100 || $discount < 0) {
					$row ['price_old'] = $price_old;
					$row ['price'] = $price_old;
					$row ['discount'] = 0;
					//$row ['discount_percent'] = 0;

				} else {
					$row ['price_old'] = $price_old;
					$row ['discount'] = $discount;
				//	$row ['discount_percent'] = $discount;
					$row ['price'] = $price_old * (100 - $discount) / 100;		
				}

			}else if($discount_unit == 'gift'){
			//	$row ['discount_percent'] = 'gift';
				$row ['price_old'] = $price_old;
				$row ['price'] = $price_old;
				$row ['discount'] = 0;
				//$row ['discount_percent'] = 0;
			} 
			else {
				if ($discount > $price_old || $discount < 0) {
					$row ['price_old'] = $price_old;
					$row ['price'] = $price_old;
					$row ['discount'] = 0;
					//$row ['discount_percent'] = 0;
				} else {
					$row ['price_old'] = $price_old;
					$row ['discount'] = $discount;
					$row ['price'] = $price_old - $discount;
					//$row ['discount_percent'] = round(100*($discount/$price_old));
				}
			}


//				$category_code = '';
//				foreach($categories as $c){
//					if($c -> code && strpos($info_import_product['category_code'],$c -> code) === 0){
//						$category_code = $c -> code;
//						break;
//					}
//				}
//				$info_import_product['category_code'] = $category_code;

//				$category_code = trim(@$info_import_product['category_code']);
//				$cat = isset($categories[$category_code])?$categories[$category_code]:'';
//				$row ['category_id'] = $cat->id;
//				$row ['category_id_wrapper'] = $cat->list_parents;
//				$row ['category_root_alias'] = $cat->root_alias;
//				$row ['category_alias_wrapper'] = $cat->alias_wrapper;
//				$row ['category_name'] = $cat->name;
//				$row ['category_alias'] = $cat->alias;
//				$row ['tablename'] = $cat->tablename;

//				$manufactories_code = '';
//				foreach($manufactories as $m){
//					if($m -> code && strpos($info_import_product['manufactory_code'],$m -> code) === (strlen($category_code)) ){
//						$manufactories_code = $m -> code;
//						break;
//					}
//				}
//				$info_import_product['manufactories_code'] = $manufactories_code;
//				$manufactories_code = trim(@$info_import_product['manufactories_code']);
//				$manu = isset($manufactories[$manufactories_code])?$manufactories[$manufactories_code]:'';

//				$row ['manufactory'] = $manu -> id;
//				$row ['manufactory_alias'] = $manu->alias;
//				$row ['manufactory_name'] = $manu->name;
//				$row ['manufactory_image'] = $manu->image;



			$product_exist =$this -> get_record('id="'.@$info_import_product['id'].'"','fs_products','id,alias,name,tablename,category_id,specs');
			if(@$info_import_product['manfid']){
				$manf =$this -> get_record('id="'.$info_import_product['manfid'].'"','fs_manufactories','*');
				// $table_name = isset($cat->tablename)?$cat->tablename:'';
				$row ['manufactory'] = $manf->id;
				$row ['manufactory_id_wrapper'] = $manf->list_parents;
				// $row ['category_root_alias'] = $manf->root_alias;
				$row ['manufactory_alias_wrapper'] = $manf->alias_wrapper;
				$row ['manufactory_name'] = $manf->name;
				$row ['manufactory_alias'] = $manf->alias;
				// $row ['category_published'] = $manf->published;
				// $row ['tablename'] = $cat->tablename;

			}
			if(@$info_import_product['cid']){
				$cat =$this -> get_record('id="'.$info_import_product['cid'].'"','fs_products_categories','alias,name,root_alias,id,tablename,list_parents,published,alias_wrapper');
				$table_name = isset($cat->tablename)?$cat->tablename:'';
				$row ['category_id'] = $cat->id;
				$row ['category_id_wrapper'] = $cat->list_parents;
				$row ['category_root_alias'] = $cat->root_alias;
				$row ['category_alias_wrapper'] = $cat->alias_wrapper;
				$row ['category_name'] = $cat->name;
				$row ['category_alias'] = $cat->alias;
				$row ['category_published'] = $cat->published;
				$row ['tablename'] = $cat->tablename;

			}else{
				$table_name = isset($product_exist->tablename)?$product_exist->tablename:'';
			}

			if(!$product_exist){
//                                        $row['alias']=$row['alias2'];
//                                        unset($row['alias2']);
				$row['created_time'] =date('Y-m-d H:i:s');
				$product_new_id = $this -> _add($row,'fs_products',1);
				if($product_new_id){
					$this -> save_extend_from_specs_in_excel( $product_new_id,1,$products_tables_all,$table_name,$row,1);
					$rs++;
				}
			}else{
//                                        echo "<pre>";
//                                    print_r($row);die;
				$result = $this -> _update($row,'fs_products','  id = "'.$product_exist -> id.'"',1);
//					if($row['specs'] != $product_exist -> specs){
				$ext_id = $this->save_extend_from_specs_in_excel( $product_exist -> id,0,$products_tables_all,$table_name,$row,1 );	
//					}
//						$ext_id = $this->save_extend_from_specs_in_excel($info_import_product['specs'], $product_exist -> id,0,$products_tables_all,$table_name,$row,0 );
//					}
				$rs++;

			}
		}
		return $rs;
	}

		/*
		 * Lưu lại trường mở rộng trong trường SPECS từ EXCEL
		 * Chú ý cấu trúc SPECS: Mỗi trường mở rộng một dòng
		 * 
		 */
		function save_extend_from_specs_in_excel( $product_id,$add = 1,$products_tables_all,$table_name,$row,$edit_specs = 0){
//			echo $table_name;
//			echo $product_id;
//                        print_r($row);die;
			if(!$table_name || !$product_id)
				return;
			
			
			$row2 = $row;
			$row3 = $row;
//			$row2 = array();
//			print_r($list_extend);

			unset($row3['is_accessories']);
			unset($row2['is_accessories']);
			unset($row2['description']);
			unset($row3['description']);

			if($add){
				$row2['record_id']=$product_id;
				unset($row2['tablename']);
//                            unset($row3['alias2']);
				$this -> _add($row2, $table_name,1);
				$this -> _update($row3, 'fs_products','id = '.$product_id,1);
			}else{
				unset($row2['tablename']);
//                            unset($row3['alias2']);
//                            print_r($row2);die;
				$this -> _update($row2, $table_name,'record_id = '.$product_id,1);
				$this -> _update($row3, 'fs_products','id = '.$product_id,1);
			}
		}
		
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