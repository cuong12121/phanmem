<?php
	class ProfitsControllersExcel extends Controllers
	{
		function __construct()
		{
			$this->view = 'excel'; 
			parent::__construct();

			$model = $this -> model;
		}

		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			$model  = $this -> model;
			$platforms = $model -> get_records('published = 1','fs_platforms');
			$list = $this -> model->get_data();
			$pagination = $model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}

		function import_excel(){
			$model = $this -> model;
			$fsFile = FSFactory::getClass('FsFiles');
			$path = PATH_BASE.'files/excel/refunds';
			$path = str_replace('/', DS,$path);
	        $excel = $fsFile -> upload_file("excel", $path ,100000000, '_'.time());
	        $platform_id = FSInput::get('platform_id');

	        if(!$platform_id || !$excel){
				return false;
			}

			$file_path = $path.$excel;
			require_once("../libraries/PHPExcel-1.8/Classes/PHPExcel.php");
			$objReader = PHPExcel_IOFactory::createReaderForFile($file_path);
			$objReader->setLoadAllSheets();
			$objexcel = $objReader->load($file_path);
			$data_upload =$objexcel->getActiveSheet()->toArray('null',true,true,true);
			// printr($data);

			unset($heightRow);	
			$heightRow=$objexcel->setActiveSheetIndex()->getHighestRow();
			unset($j);

	      
			if($platform_id == 1){
				$this->import_lazada($heightRow,$data_upload);
			}elseif($platform_id == 2){
				$this->import_shopee($heightRow,$data_upload);
			}elseif($platform_id == 3){
				$this->import_tiki($heightRow,$data_upload);
			}else{
				$this->import_shopee($heightRow,$data_upload);
			}

		}

		function import_tiki($heightRow,$data_upload){
			$model = $this -> model;
			$count_ss = 0;
			$i = 0;
			$l = 0;
			$row_error = "";
			for($j=2;$j<=$heightRow;$j++){
				$row = array();
				$code = trim($data_upload[$j]['A']);
				if(!$code || $code == 'null' ){
					$l++;
					$row_error .= $j.",";
					continue;
				}
				
				$list = $model->get_records('is_refund = 0 AND is_shoot = 1 AND code = "'.$code.'"','fs_order_uploads_detail','*');

				if(empty($list)){
					$l++;
					$row_error .= $j.",";
					continue;
				}
				$gia_goc = 0;
				$price_package = 0;
				foreach ($list as $item) {
					$gia_goc += $item-> total_price;
					$price_package += $item-> price_package;
				}

				$row['code'] = $code;
				$row['gia_goc'] = $gia_goc;
				$row['price_package'] = $price_package;
				$row['gia_ban'] = $this->covert_get_excel($data_upload[$j]['B']);
				$row['is_seeding'] = $list[0]->is_seeding;
				$row['platform_id'] = $list[0]->platform_id;
				$row['warehouse_id'] = $list[0]->warehouse_id;
				$row['shop_id'] = $list[0]->shop_id;
				$row['date'] = $list[0]->date;
				$row['house_id'] = $list[0]->house_id;
				$row['list_user_id_manage_shop'] = $list[0]->list_user_id_manage_shop;
				$row['shipping_unit_id'] = $list[0]->shipping_unit_id;
				
				$row['phi_giao_dich_dieu_chinh_tiki'] = $this->covert_get_excel($data_upload[$j]['C']);
				$row['phi_giao_dich_boi_thuong_1_phan_tiki'] = $this->covert_get_excel($data_upload[$j]['D']);
				$row['cac_khoan_phat_tiki'] = $this->covert_get_excel($data_upload[$j]['E']);
				$row['hoa_hong_lien_ket_tiki'] = $this->covert_get_excel($data_upload[$j]['F']);
				$row['phi_hoan_hang_tiki'] = $this->covert_get_excel($data_upload[$j]['G']);
				

				$row['phi_luu_kho'] = $this->covert_get_excel($data_upload[$j]['H']);
				$row['phi_cong_an'] = $this->covert_get_excel($data_upload[$j]['I']);
				$row['phi_quang_cao'] = $this->covert_get_excel($data_upload[$j]['J']);

				$row['action_username'] = $_SESSION ['ad_username'];
				$row['action_userid'] = $_SESSION ['ad_userid'];

				if($row['is_seeding'] == 1){
					$profit = - $row['price_package'] - $row['phi_giao_dich_dieu_chinh_tiki'] - $row['phi_giao_dich_boi_thuong_1_phan_tiki'] - $row['cac_khoan_phat_tiki'] - $row['hoa_hong_lien_ket_tiki'] - $row['phi_hoan_hang_tiki'] -  $row['phi_luu_kho'] - $row['phi_cong_an'] - $row['phi_quang_cao'];
				}else{
					$profit = $row['gia_ban'] - $row['gia_goc'] - $row['price_package'] - $row['phi_giao_dich_dieu_chinh_tiki'] - $row['phi_giao_dich_boi_thuong_1_phan_tiki'] - $row['cac_khoan_phat_tiki'] - $row['hoa_hong_lien_ket_tiki'] - $row['phi_hoan_hang_tiki'] -  $row['phi_luu_kho'] - $row['phi_cong_an'] - $row['phi_quang_cao'];
				}

				

				$row['profit'] = $profit;

				$check = $model->get_record('code = "' .$code.'"' ,'fs_order_uploads_profits','id');
				if(!empty($check)){
					$row['updated_time'] = date('Y-m-d H:i:s');
					$add_id =$model -> _update($row,'fs_order_uploads_profits','id = '.$check->id);
				}else{
					$row['created_time'] = date('Y-m-d H:i:s');
					$add_id =$model -> _add($row,'fs_order_uploads_profits');
				}

				if($add_id){
					$i++;
				}
			}

			$link = FSRoute::_('index.php?module=profits&view=excel');
			$message = 'Thành công '.$i.' dòng. ';
			if($l > 0){
				$message .= 'Lỗi dòng ở các dòng '.$row_error . ' kiểm tra lại mã có tồn tại không';
			}
			setRedirect($link,$message);
		}


		function import_shopee($heightRow,$data_upload){
			$model = $this -> model;
			$count_ss = 0;
			$i = 0;
			$l = 0;
			$row_error = "";
			for($j=2;$j<=$heightRow;$j++){
				$row = array();
				$code = trim($data_upload[$j]['A']);
				if(!$code || $code == 'null' ){
					$l++;
					$row_error .= $j.",";
					continue;
				}
				
				$list = $model->get_records('is_refund = 0 AND is_shoot = 1 AND code = "'.$code.'"','fs_order_uploads_detail','*');

				if(empty($list)){
					$l++;
					$row_error .= $j.",";
					continue;
				}
				$gia_goc = 0;
				$price_package = 0;
				foreach ($list as $item) {
					$gia_goc += $item-> total_price;
					$price_package += $item-> price_package;
				}

				$row['code'] = $code;
				$row['gia_goc'] = $gia_goc;
				$row['price_package'] = $price_package;

				$row['gia_ban'] = $this->covert_get_excel($data_upload[$j]['B']);
				$row['is_seeding'] = $list[0]->is_seeding;
				$row['platform_id'] = $list[0]->platform_id;
				$row['warehouse_id'] = $list[0]->warehouse_id;
				$row['shop_id'] = $list[0]->shop_id;
				$row['date'] = $list[0]->date;
				$row['house_id'] = $list[0]->house_id;
				$row['list_user_id_manage_shop'] = $list[0]->list_user_id_manage_shop;
				$row['shipping_unit_id'] = $list[0]->shipping_unit_id;
				
				$row['so_tien_ban_tro_gia_cho_sp_shp'] = $this->covert_get_excel($data_upload[$j]['C']);
				$row['so_tien_hoan_tra_cho_nguoi_mua_shp'] = $this->covert_get_excel($data_upload[$j]['D']);
				$row['sp_duoc_tro_gia_tu_shp'] = $this->covert_get_excel($data_upload[$j]['E']);
				$row['ma_giam_gia_shp'] = $this->covert_get_excel($data_upload[$j]['F']);
				$row['nguoi_ban_hoan_xu_shp'] = $this->covert_get_excel($data_upload[$j]['G']);
				$row['phi_vc_nguoi_mua_tra_shp'] = $this->covert_get_excel($data_upload[$j]['H']);
				$row['phi_vc_duoc_tro_gia_tu_shp'] = $this->covert_get_excel($data_upload[$j]['I']);
				$row['phi_vc_thuc_te_shp'] = $this->covert_get_excel($data_upload[$j]['J']);
				$row['phi_co_dinh_shp'] = $this->covert_get_excel($data_upload[$j]['K']);
				$row['phi_dich_vu_shp'] = $this->covert_get_excel($data_upload[$j]['L']);

				$row['phi_don_fake'] = $this->covert_get_excel($data_upload[$j]['M']);
				$row['phi_thanh_toan_shp'] = $this->covert_get_excel($data_upload[$j]['N']);
				$row['phi_luu_kho'] = $this->covert_get_excel($data_upload[$j]['O']);
				$row['phi_cong_an'] = $this->covert_get_excel($data_upload[$j]['P']);
				$row['phi_quang_cao'] = $this->covert_get_excel($data_upload[$j]['Q']);

				$row['action_username'] = $_SESSION ['ad_username'];
				$row['action_userid'] = $_SESSION ['ad_userid'];

			
				if($row['is_seeding'] == 1){
					$profit = - $row['price_package'] - $row['so_tien_ban_tro_gia_cho_sp_shp'] - $row['so_tien_hoan_tra_cho_nguoi_mua_shp'] - $row['sp_duoc_tro_gia_tu_shp'] - $row['ma_giam_gia_shp'] - $row['nguoi_ban_hoan_xu_shp']- $row['phi_vc_nguoi_mua_tra_shp'] - $row['phi_vc_duoc_tro_gia_tu_shp'] - $row['phi_vc_thuc_te_shp'] - $row['phi_co_dinh_shp'] - $row['phi_dich_vu_shp'] - $row['phi_don_fake'] - $row['phi_thanh_toan_shp']  - $row['phi_luu_kho'] - $row['phi_cong_an'] - $row['phi_quang_cao'];
				}else{
					$profit = $row['gia_ban'] - $row['gia_goc'] - $row['price_package'] - $row['so_tien_ban_tro_gia_cho_sp_shp'] - $row['so_tien_hoan_tra_cho_nguoi_mua_shp'] - $row['sp_duoc_tro_gia_tu_shp'] - $row['ma_giam_gia_shp'] - $row['nguoi_ban_hoan_xu_shp']- $row['phi_vc_nguoi_mua_tra_shp'] - $row['phi_vc_duoc_tro_gia_tu_shp'] - $row['phi_vc_thuc_te_shp'] - $row['phi_co_dinh_shp'] - $row['phi_dich_vu_shp'] - $row['phi_don_fake'] - $row['phi_thanh_toan_shp']  - $row['phi_luu_kho'] - $row['phi_cong_an'] - $row['phi_quang_cao'];
				}

				$row['profit'] = $profit;

				$check = $model->get_record('code = "' .$code.'"' ,'fs_order_uploads_profits','id');
				if(!empty($check)){
					$row['updated_time'] = date('Y-m-d H:i:s');
					$add_id =$model -> _update($row,'fs_order_uploads_profits','id = '.$check->id);
				}else{
					$row['created_time'] = date('Y-m-d H:i:s');
					$add_id =$model -> _add($row,'fs_order_uploads_profits');
				}

				if($add_id){
					$i++;
				}
			}

			$link = FSRoute::_('index.php?module=profits&view=excel');
			$message = 'Thành công '.$i.' dòng. ';
			if($l > 0){
				$message .= 'Lỗi dòng ở các dòng '.$row_error . ' kiểm tra lại mã có tồn tại không';
			}
			setRedirect($link,$message);
		}

		function import_lazada($heightRow,$data_upload){
			$model = $this -> model;
			$count_ss = 0;
			$i = 0;
			$l = 0;
			$row_error = "";
			for($j=2;$j<=$heightRow;$j++){
				$row = array();
				$code = trim($data_upload[$j]['A']);
				if(!$code || $code == 'null' ){
					$l++;
					$row_error .= $j.",";
					continue;
				}
				
				$list = $model->get_records('is_refund = 0 AND is_shoot = 1 AND code = "'.$code.'"','fs_order_uploads_detail','*');

				if(empty($list)){
					$l++;
					$row_error .= $j.",";
					continue;
				}
				$gia_goc = 0;
				$price_package = 0;
				foreach ($list as $item) {
					$gia_goc += $item-> total_price;
					$price_package += $item-> price_package;
				}

				$row['code'] = $code;
				$row['gia_goc'] = $gia_goc;
				$row['price_package'] = $price_package;
				$row['gia_ban'] = $this->covert_get_excel($data_upload[$j]['B']);
				$row['is_seeding'] = $list[0]->is_seeding;
				$row['platform_id'] = $list[0]->platform_id;
				$row['warehouse_id'] = $list[0]->warehouse_id;
				$row['shop_id'] = $list[0]->shop_id;
				$row['date'] = $list[0]->date;
				$row['house_id'] = $list[0]->house_id;
				$row['list_user_id_manage_shop'] = $list[0]->list_user_id_manage_shop;
				$row['shipping_unit_id'] = $list[0]->shipping_unit_id;
				
				$row['phi_vc_tra_boi_khach_lzd'] = $this->covert_get_excel($data_upload[$j]['C']);
				$row['phi_vc_tro_gia_lzd'] = $this->covert_get_excel($data_upload[$j]['D']);
				$row['phi_km_goi_sp_lazd'] = $this->covert_get_excel($data_upload[$j]['E']);
				$row['phi_km_ma_giam_gia_lazd'] = $this->covert_get_excel($data_upload[$j]['F']);
				$row['phi_km_combo_lzd'] = $this->covert_get_excel($data_upload[$j]['G']);
				$row['phi_km_ma_giam_gia_vc_lzd'] = $this->covert_get_excel($data_upload[$j]['H']);
				$row['phi_km_lazcoin_lzd'] = $this->covert_get_excel($data_upload[$j]['I']);
				$row['voucher_tich_luy_lzd'] = $this->covert_get_excel($data_upload[$j]['J']);
				$row['tai_tro_hien_sp_nap_tien_lzd'] = $this->covert_get_excel($data_upload[$j]['K']);
				$row['phi_co_dinh_lzd'] = $this->covert_get_excel($data_upload[$j]['L']);
				$row['phi_thanh_toan_lzd'] = $this->covert_get_excel($data_upload[$j]['M']);
				$row['phi_vc_tra_boi_nha_ban_hang_lzd'] = $this->covert_get_excel($data_upload[$j]['N']);
				$row['phi_gioi_thieu_sp_lzd'] = $this->covert_get_excel($data_upload[$j]['O']);
				$row['phi_tra_gop_lzd'] = $this->covert_get_excel($data_upload[$j]['P']);
				$row['phi_qc_tiep_thi_lien_ket_lzd'] = $this->covert_get_excel($data_upload[$j]['Q']);
				$row['tai_tro_hien_thi_sp_tin_dung_lzd'] = $this->covert_get_excel($data_upload[$j]['R']);
				$row['phi_dv_tmdt_lzd'] = $this->covert_get_excel($data_upload[$j]['S']);
				$row['phi_dv_chuong_trinh_km_max_lzd'] = $this->covert_get_excel($data_upload[$j]['T']);
				$row['phi_khac_lzd'] = $this->covert_get_excel($data_upload[$j]['U']);
				$row['phi_don_fake'] = $this->covert_get_excel($data_upload[$j]['V']);
				$row['phi_luu_kho'] = $this->covert_get_excel($data_upload[$j]['W']);
				$row['phi_cong_an'] = $this->covert_get_excel($data_upload[$j]['X']);
				$row['phi_quang_cao'] = $this->covert_get_excel($data_upload[$j]['Y']);
				$row['action_username'] = $_SESSION ['ad_username'];
				$row['action_userid'] = $_SESSION ['ad_userid'];

				

				if($row['is_seeding'] == 1){
					$profit = - $row['price_package'] - $row['phi_vc_tra_boi_khach_lzd'] - $row['phi_vc_tro_gia_lzd'] - $row['phi_km_goi_sp_lazd'] - $row['phi_km_ma_giam_gia_lazd'] - $row['phi_km_combo_lzd']- $row['phi_km_ma_giam_gia_vc_lzd'] - $row['phi_km_lazcoin_lzd'] - $row['voucher_tich_luy_lzd'] - $row['tai_tro_hien_sp_nap_tien_lzd'] - $row['phi_co_dinh_lzd'] - $row['phi_thanh_toan_lzd'] - $row['phi_vc_tra_boi_nha_ban_hang_lzd'] - $row['phi_gioi_thieu_sp_lzd'] - $row['phi_tra_gop_lzd'] - $row['phi_qc_tiep_thi_lien_ket_lzd'] - $row['tai_tro_hien_thi_sp_tin_dung_lzd'] - $row['phi_dv_tmdt_lzd'] - $row['phi_dv_chuong_trinh_km_max_lzd'] - $row['phi_khac_lzd'] - $row['phi_don_fake'] - $row['phi_luu_kho'] - $row['phi_cong_an'] - $row['phi_quang_cao'];
					
				}else{
					$profit = $row['gia_ban'] - $row['gia_goc'] - $row['price_package'] - $row['phi_vc_tra_boi_khach_lzd'] - $row['phi_vc_tro_gia_lzd'] - $row['phi_km_goi_sp_lazd'] - $row['phi_km_ma_giam_gia_lazd'] - $row['phi_km_combo_lzd']- $row['phi_km_ma_giam_gia_vc_lzd'] - $row['phi_km_lazcoin_lzd'] - $row['voucher_tich_luy_lzd'] - $row['tai_tro_hien_sp_nap_tien_lzd'] - $row['phi_co_dinh_lzd'] - $row['phi_thanh_toan_lzd'] - $row['phi_vc_tra_boi_nha_ban_hang_lzd'] - $row['phi_gioi_thieu_sp_lzd'] - $row['phi_tra_gop_lzd'] - $row['phi_qc_tiep_thi_lien_ket_lzd'] - $row['tai_tro_hien_thi_sp_tin_dung_lzd'] - $row['phi_dv_tmdt_lzd'] - $row['phi_dv_chuong_trinh_km_max_lzd'] - $row['phi_khac_lzd'] - $row['phi_don_fake'] - $row['phi_luu_kho'] - $row['phi_cong_an'] - $row['phi_quang_cao'];
				}

				$row['profit'] = $profit;

				$check = $model->get_record('code = "' .$code.'"' ,'fs_order_uploads_profits','id');
				if(!empty($check)){
					$row['updated_time'] = date('Y-m-d H:i:s');
					$add_id =$model -> _update($row,'fs_order_uploads_profits','id = '.$check->id);
				}else{
					$row['created_time'] = date('Y-m-d H:i:s');
					$add_id =$model -> _add($row,'fs_order_uploads_profits');
				}

				if($add_id){
					$i++;
				}
			}

			$link = FSRoute::_('index.php?module=profits&view=excel');
			$message = 'Thành công '.$i.' dòng. ';
			if($l > 0){
				$message .= 'Lỗi dòng ở các dòng '.$row_error . ' kiểm tra lại mã có tồn tại không';
			}
			setRedirect($link,$message);
		}

		function covert_get_excel($data){
			$data = trim($data);
			if(!$data || $data == 'null' ){
				return 0;
			}else{
				return $data;
			}
		}


		function import_excel1(){
			$model = $this -> model;
			$fsFile = FSFactory::getClass('FsFiles');
			$path = PATH_BASE.'files/excel/refunds';
			$path = str_replace('/', DS,$path);
	        $excel = $fsFile -> upload_file("excel", $path ,100000000, '_'.time());
	        if(	!$excel){
				return false;
			}else{
				$file_path = $path.$excel;
				require_once("../libraries/PHPExcel-1.8/Classes/PHPExcel.php");
				$objReader = PHPExcel_IOFactory::createReaderForFile($file_path);
				$objReader->setLoadAllSheets();
				$objexcel = $objReader->load($file_path);
				$data_upload =$objexcel->getActiveSheet()->toArray('null',true,true,true);
				// printr($data);

				unset($heightRow);	
				$heightRow=$objexcel->setActiveSheetIndex()->getHighestRow();
				unset($j);

				$count_ss = 0;
				$i = 0;
				$l = 0;
				$row_error = "";
				for($j=2;$j<=$heightRow;$j++){
					$tracking_code = trim($data_upload[$j]['A']);
					if(!$tracking_code || $tracking_code == 'null' ){
						$l++;
						$row_error .= $j.",";
						continue;
					}
					
					$list = $model->get_records('is_refund = 0 AND is_print = 1 AND tracking_code = "'.$tracking_code.'"','fs_order_uploads_detail','*');
					
					if(empty($list)){
						$l++;
						$row_error .= $j.",";
						continue;
					}

					


					foreach ($list as $data) {
						if($data-> is_refund == 1){
							$i++;
							continue;
						}
						$row = array();
						$row['order_uploads_id'] = $data-> record_id;
						$row['order_uploads_detail_id'] = $data-> id;
						$row['platform_id'] = $data-> platform_id;
						$row['warehouse_id'] = $data-> warehouse_id;
						$row['shop_name'] = $data-> shop_name;
						$row['shop_id'] = $data-> shop_id;
						$row['shop_code'] = $data-> shop_code;
						$row['date'] = $data-> date;
						$row['code'] = $data-> code;
						$row['sku'] = $data-> sku;
						$row['color'] = $data-> color;
						$row['size'] = $data-> size;
						$row['date_refund'] =  date('Y-m-d');
						$row['sku_nhanh'] = $data-> sku_nhanh;
						$row['count'] = $data-> count;
						$row['shipping_unit_name'] = $data-> shipping_unit_name;
						$row['shipping_unit_id'] = $data-> shipping_unit_id;
						$row['house_id'] = $data-> house_id;
						$row['weight'] = $data-> weight;
						$row['lazada_sku'] = $data-> lazada_sku;
						$row['user_id'] = $data-> user_id;
						$row['product_id'] = $data-> product_id;
						$row['product_code'] = $data-> product_code;
						$row['product_price'] = $data-> product_price;
						$row['total_price'] = $data-> total_price;
						$row['tracking_code'] = $data-> tracking_code;
						$row['product_name'] = $data-> product_name;
						$row['created_time'] = date('Y-m-d H:i:s');
						$row['action_userid'] = $_SESSION ['ad_userid'];
						$row['action_username'] = $_SESSION ['ad_username'];
						$row['user_id_manage_shop'] = $data-> user_id_manage_shop;
						$row['list_user_id_manage_shop'] = $data-> list_user_id_manage_shop;
						$add_id = $model-> _add($row,'fs_order_uploads_detail_refund');
						if($add_id){
							$update_quantity = $this->plus_quantity_product($row['warehouse_id'],$row['product_id'],(float)$row['count'],$data-> is_shoot);
							if($data-> is_package == 1){
								$this->plus_money($data);
							}
							if($update_quantity){
								$row2 = array();
								$row2['is_refund'] = 1;
								$row2['date_refund'] = date('Y-m-d H:i:s');
								$model-> _update($row2,'fs_order_uploads_detail','id ='.$data->id);
								$i++;
							}else{
								$model->_remove('id = '.$add_id,'fs_order_uploads_detail_refund');
								$l++;
								$row_error .= $j.",";
								continue;
							}
							
							
						}else{
							$l++;
							$row_error .= $j.",";
							continue;
						}

					}


				}
				$link = FSRoute::_('index.php?module=refunds&view=excel');
				$message = 'Thành công '.$i.' dòng';
				if($l > 0){
					$message .= 'Lỗi dòng ở các dòng '.$row_error . ' kiểm tra lại mã có tồn tại không';
				}
				setRedirect($link,$message);
			}
		}

		function download_file_lazada(){
			$path_file = PATH_BASE.LINK_AMIN.'export'.DS.'excel'.'mau_loi_nhuan_lazada.xlsx'; 
			$fsstring = FSFactory::getClass('FSString');
			$file_export_name = 'mau_loi_nhuan_lazada';
			$file_ext = $this -> getExt(basename('export'.DS.'excel'.DS.'mau_loi_nhuan_lazada.xlsx'));
			$file_export_name = $file_export_name.'.'.$file_ext;
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control: no-cache,must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false);			
			header("Content-type: application/force-download");			
			header("Content-Disposition: attachment; filename=\"".$file_export_name."\";" );
			header("Content-Transfer-Encoding: binary");
			header("Cache-Control:no-cache, must-revalidate, post-check=0, pre-check=0");
			header("Content-Length: ".filesize($path_file));
			echo $link_excel = URL_ADMIN.'/export/mau_loi_nhuan/'. $file_export_name;
			?>
			<?php setRedirect($link_excel); ?>
			<?php 
			readfile($path_file);
			exit();	
		}

		function download_file_shoppe(){
			$path_file = PATH_BASE.LINK_AMIN.'export'.DS.'excel'.'mau_loi_nhuan_shoppe.xlsx'; 
			$fsstring = FSFactory::getClass('FSString');
			$file_export_name = 'mau_loi_nhuan_shoppe';
			$file_ext = $this -> getExt(basename('export'.DS.'excel'.DS.'mau_loi_nhuan_shoppe.xlsx'));
			$file_export_name = $file_export_name.'.'.$file_ext;
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control: no-cache,must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false);			
			header("Content-type: application/force-download");			
			header("Content-Disposition: attachment; filename=\"".$file_export_name."\";" );
			header("Content-Transfer-Encoding: binary");
			header("Cache-Control:no-cache, must-revalidate, post-check=0, pre-check=0");
			header("Content-Length: ".filesize($path_file));
			echo $link_excel = URL_ADMIN.'/export/mau_loi_nhuan/'. $file_export_name;
			?>
			<?php setRedirect($link_excel); ?>
			<?php 
			readfile($path_file);
			exit();	
		}

		function download_file_tiki(){
			$path_file = PATH_BASE.LINK_AMIN.'export'.DS.'excel'.'mau_loi_nhuan_tiki.xlsx'; 
			$fsstring = FSFactory::getClass('FSString');
			$file_export_name = 'mau_loi_nhuan_tiki';
			$file_ext = $this -> getExt(basename('export'.DS.'excel'.DS.'mau_loi_nhuan_tiki.xlsx'));
			$file_export_name = $file_export_name.'.'.$file_ext;
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control: no-cache,must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false);			
			header("Content-type: application/force-download");			
			header("Content-Disposition: attachment; filename=\"".$file_export_name."\";" );
			header("Content-Transfer-Encoding: binary");
			header("Cache-Control:no-cache, must-revalidate, post-check=0, pre-check=0");
			header("Content-Length: ".filesize($path_file));
			echo $link_excel = URL_ADMIN.'/export/mau_loi_nhuan/'. $file_export_name;
			?>
			<?php setRedirect($link_excel); ?>
			<?php 
			readfile($path_file);
			exit();	
		}

		function getExt($file){
			return strtolower(substr($file, (strripos($file, '.')+1),strlen($file)));
		}
	}
?>