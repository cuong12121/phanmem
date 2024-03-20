<?php
	class Company_profitsControllersItems extends Controllers
	{
		function __construct()
		{
			$this->view = 'items'; 
			parent::__construct();
			$model = $this -> model;
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			$model  = $this -> model;
			$wrap_id_warehouses = $model->get_wrap_id_warehouses();
			$warehouses = $model -> get_records('published = 1 AND id IN ('.$wrap_id_warehouses.')','fs_warehouses','*','','','id');
			$platforms = $model -> get_records('published = 1','fs_platforms','*','','','id');
			$houses = $model -> get_records('published = 1','fs_house','*','','','id');
			$shipping_unit = $model -> get_records('published = 1','fs_shipping_unit','*','','','id');
			// $product_all = $model -> get_records('published = 1','fs_products','import_price,code','','','code');
			// dd($product_all);
			$list = $model->get_data();
			$pagination = $model->getPagination();
			$users = $model -> get_record('id = ' . $_SESSION['ad_userid'],'fs_users');
			$statics = $model-> get_data_statics();
			$tong_doanh_thu = 0;
			$tong_gia_von = 0;
			$tong_loi_nhuan = 0;
			$tong_don_hang = 0;
			if(!empty($statics)){
				$tong_don_hang = count($statics);
				foreach ($statics as $static_item){
					$tong_doanh_thu += $static_item-> doanh_thu_cong_ty;
					$tong_loi_nhuan += $static_item-> profit_company;
					$tong_gia_von += $static_item-> gia_von_cong_ty;
				}
			}

			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}

		function add()
		{
			$model = $this -> model;
			$warehouses = $model -> get_records('published = 1','fs_warehouses');
			$platforms = $model -> get_records('published = 1','fs_platforms');
			$houses = $model -> get_records('published = 1','fs_house');
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

		function ajax_add_time_profits(){
			$model = $this -> model;
			$data = array ('error' => true, 'messenger' => '', 'link'=> '');
			$go_time = FSInput::get('go_time');
			$to_time = FSInput::get('to_time');
			$doanh_thu = FSInput::get('doanh_thu');
			$chi_phi = FSInput::get('chi_phi');
			$loi_nhuan = FSInput::get('loi_nhuan');
			$tong_don_hang = FSInput::get('tong_don_hang');

			$row = array();
			$row['go_time'] = date('Y-m-d',strtotime($go_time));
			$row['to_time'] = date('Y-m-d',strtotime($to_time));
			$row['doanh_thu'] = $doanh_thu;
			$row['chi_phi'] = $chi_phi;
			$row['loi_nhuan'] = $loi_nhuan;
			$row['tong_don_hang'] = $tong_don_hang;
			
			$row['user_id'] = $_SESSION['ad_userid'];

			$check = $model->get_record('go_time = "'.$row['go_time'] . '" AND to_time = "'.$row['to_time'].'"','fs_profits_shops');

			if(!empty($check)){
				$model->_update($row,'fs_profits_company','id = '.$check->id);
				$rs = $check->id;
			}else{
				$rs = $model->_add($row,'fs_profits_company');
			}
			if($rs){
				$data = array ('error' => false, 'messenger' => 'Tạo mốc thành công', 'link'=> URL_ADMIN.'company_profits/profist_time/edit/'.$rs);
				echo json_encode ($data);
				return;
			}else{
				$data = array ('error' => true, 'messenger' => 'Có lỗi xảy ra !', 'link'=> '');
				echo json_encode ($data);
				return;
			}

		}

		
	}
	
?>