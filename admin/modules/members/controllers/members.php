<?php

class MembersControllersMembers extends Controllers
{
	function __construct()
	{
		$this->view = 'members' ; 
		parent::__construct(); 
	}

	function display()
	{
		parent::display();
		$sort_field = $this -> sort_field;
		$sort_direct = $this -> sort_direct;

		if(	isset($_POST['city'])){
			$_SESSION[$this -> prefix.'city']  =  $_POST['city'] ;
			$ss_city =  $_POST['city'] ;
		}
		if(	isset($_POST['published'])){
			$_SESSION[$this -> prefix.'published']  =  $_POST['published'] ;
			$ss_published = $_SESSION[$this -> prefix.'published'];
		}
		
		$model  = $this -> model;
		$list = $model->getMembers();
		$arr_level = $model -> get_level();
		$pagination = $model->getPagination();

		include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';

	}
	function add()
	{
		$model = $this -> model;
		$cities  = $model -> getCity();
		$districts  = $model -> getDistricts();
		$wards  = $model -> getWards();
		$maxOrdering = $model->getMaxOrdering();
		$arr_level = $model -> get_level();

		include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
	}
	
	function edit()
	{
		$model  = $this -> model;
		$data = $model->getMemberById();
		if(!$data)
			die('Not found url');
		$cities  = $model -> getCity();
		if(@$data -> city_id)
		{
			$districts  = $model -> getDistricts(@$data -> city_id);
		}
		else
		{
			$districts  = $model -> getDistricts();
		}

		if(@$data-> district_id){
			$wards  = $model -> getWards(@$data-> district_id);
		} else {
			$wards  = $model -> getWards();
		}

		$history_point = $model-> get_records('user_id = '.$data-> id,'fs_history_point_members','*','created_time DESC');

		$orders =  $model-> get_records('user_id = '.$data-> id,'fs_order','*','created_time DESC');
		// echo $data-> id;
		// print_r($orders);

		$where_affi = ' AND YEAR(created_time) = '.date("Y");

		$orders_affi =  $model-> get_records('affiliate_id = '.$data-> id.$where_affi,'fs_order','*','created_time DESC');

		$list_changepoint_byadmin = $model-> get_records('user_id = '.$data-> id.' AND type = "admin_change"','fs_history_point_members', '*');

		$arr_level = $model -> get_level();
		include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
	}


	function save_price_affi(){
		$model  = $this -> model;
		$user_id = FSInput::get('user_id');
		$month = FSInput::get('month');
		$year = FSInput::get('year');
		$value = FSInput::get('value');

		$time = date ( 'Y-m-d H:i:s' );

		$check = $model-> get_record('user_id = '.$user_id.' AND month='.$month.' AND year ='.$year,'fs_history_affi_members','id');

		if(!empty($check)) {
			$row = array();
			$row['value'] = $value;
			
			$row['edited_time'] = $time;
			$row['action_id']= $_SESSION['ad_userid'];
			$row['action_username'] = $_SESSION['ad_username'];

			$id = $model-> _update($row,'fs_history_affi_members','id = '.$check-> id);
		} else {
			$row = array();
			$row['value'] = $value;
			$row['year'] = $year;
			$row['month'] = $month;
			$row['user_id'] = $user_id;
			$row['created_time'] = $time;
			$row['edited_time'] = $time;
			$row['action_id']= $_SESSION['ad_userid'];
			$row['action_username'] = $_SESSION['ad_username'];
			$id = $model-> _add($row,'fs_history_affi_members');

		}

		echo $id;


	}

	function load_orderaffi_monthyear(){
		$model  = $this -> model;
		$user_id = FSInput::get('user_id');
		$month = FSInput::get('month');
		$year = FSInput::get('year');

		$where = '';
		if($month > 0) {
			$where .= ' AND MONTH(created_time) = '.$month;
		}
		if($year > 0) {
			$where .= ' AND YEAR(created_time) = '.$year;
		}

		if($month && $year) {
			$price_affi = $model-> get_record('user_id = '.$user_id.' AND month='.$month.' AND year ='.$year,'fs_history_affi_members','*');
		}

		$orders_affi =  $model-> get_records('affiliate_id = '.$user_id.$where,'fs_order','*','created_time DESC');
		include 'modules/'.$this->module.'/views/'.$this -> view.'/orders_affi_ajax.php';
		// print_r($orders_affi);

	}


	function changepass()
	{
		$model  = $this -> model;
		$data = $model->getMemberById();
		if(!$data)
			die('Not found url');
		$groups = $this -> arr_group;
		$categories  = $model -> get_categories_tree();
		include 'modules/'.$this->module.'/views/'.$this -> view.'/changepass.php';
	}
	function apply()
	{
		$model  = $this -> model;
		if(! $this -> check_save())
		{
			$link = "index.php?module=members";
			$msg = FSText::_("Sorry! Ban khong luu duoc");
			setRedirect($link,$msg,'error');
		}
		else
		{
			$id = $model->save();
			if($id)
			{
					// create folder
//	            	$model -> create_folder_upload($id);

				$link ="index.php?module=members&view=members&task=edit&id=$id";
				$msg = FSText::_("Ban da thay doi thanh cong");
				setRedirect($link,$msg);
			}
			else
			{
				$link = "index.php?module=members&view=members";
				$msg = FSText::_("Sorry! You can not change infomation");
				setRedirect($link,$msg,'error');
			}
		}

	}
	function save()
	{

		$model  = $this -> model;

		if(! $this -> check_save())
		{
			$link = "index.php?module=members&view=members";
			$msg = FSText::_("Sorry! Ban khong luu duoc");
			setRedirect($link,$msg,'error');
		}
		else
		{
			$id = $model->save();

			if($id)
			{
					// create folder
//	            $model -> create_folder_upload($id);
				$link = "index.php?module=members&view=members";
				$msg = "Bạn đã thay đổi thành công";
				setRedirect($link,$msg);
			}
			else
			{
				$link = "index.php?module=members&view=members";
				$msg = FSText::_("Sorry! You can not change infomation");
				setRedirect($link,$msg,'error');
			}
		}

	}

	function check_save()
	{
		$id = FSInput::get('cid');
		$email = FSInput::get("username");
//			$re_email = FSInput::get("re_email");
		if(!$email )
		{
			Errors::setError(FSText::_("Chưa nhập Email"));
			return false;
		}
//			if($email != $re_email)
//			{
//				Errors::setError(FSText::_("Email kh&ocirc;ng tr&ugrave;ng nhau"));
//				return false;
//			}	


		$model  = $this -> model;
		$edit_pass = FSInput::get('edit_pass');

		if($edit_pass){
				// check pass
			$password = FSInput::get("password1");
			$re_password = FSInput::get("re-password1");
			if(!$id && !$password){
				Errors::setError("Y&#234;u c&#7847;u nh&#7853;p password");
				return false;
			}
			if($password)
			{
				if($password != $re_password)
				{
					Errors::setError("Password khong khop voi Re-password");
					return false;
				}
			}
		}

			// edit
		return true;
	}
	

			/*
		 * load District by city id. 
		 * Use Ajax
		 */
			function district()
			{
				$model  = $this -> model;
				$cid = FSInput::get('cid');
				$rs  = $model -> getDistricts($cid);

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

					/*
		 * load District by city id. 
		 * Use Ajax
		 */
					function ward(){
						$model  = $this -> model;
						$cid = FSInput::get('cid');
						$rs  = $model -> getWards($cid);

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

							/*
		 * load District by city id. 
		 * Use Ajax
		 */
							function ward2(){
								$model  = $this -> model;
								$cid = FSInput::get('cid');
								$rs  = $model -> getWards2($cid);

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

		// Excel toàn bộ danh sách copper ra excel
		function export(){
			setRedirect('index.php?module='.$this -> module.'&view='.$this -> view.'&task=export_file&raw=1');
		}	
		function export_file(){
			FSFactory::include_class('excel','excel');
//			require_once 'excel.php';
			$model  = $this -> model;
			$filename = 'member-export';
			$list = $model->get_member_info();
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
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->setCellValue('A1', 'Tên truy cập');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('B1', 'Họ và tên');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('C1', 'Địa chỉ');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('D1', 'Email');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('E1', 'Điện thoại');
				foreach ($list as $item){
					$key = isset($key)?($key+1):2;
					$excel->obj_php_excel->getActiveSheet()->setCellValue('A'.$key, $item->username);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.$key, $item->full_name);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('C'.$key, $item->address);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('D'.$key, $item->email);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('E'.$key, $item->mobilephone);
				}
				$excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray( $style_header );
				$excel->obj_php_excel->getActiveSheet()->duplicateStyle( $excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:E1' );
				$output = $excel->write_files();
				
				$path_file =   PATH_ADMINISTRATOR.DS.str_replace('/',DS, $output['xls']);
				header("Pragma: public");
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Cache-Control: private",false);			
				header("Content-type: application/force-download");			
				header("Content-Disposition: attachment; filename=\"".$filename.'.xls'."\";" );			
				header("Content-Transfer-Encoding: binary");
				header("Content-Length: ".filesize($path_file));
				readfile($path_file);
			}
		}	

		// Excel toàn bộ danh sách copper ra excel
		function export_excel(){
			require_once 'excel.php';
			$model  = $this -> model;
			$start = FSInput::get('start');
			$start=(isset($start) && !empty($start))?$start:1;
			$start=$start-1;
			$end = FSInput::get('end');
			$end=(isset($end) && !empty($end))?$end:10;
			$list = $model->get_member_info($start,$end);
			if(empty($list)){
				echo 'error';exit;
			}else {
				$excel = V_Excel();
				$excel->set_params(array('out_put_xls'=>'export/excel/'.'danh_sach_'.date('H-i_j-n-Y',time()).'.xls','out_put_xlsx'=>'export/excel/'.'danh_sach_'.date('j-n-Y',time()).'.xlsx'));
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
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
				$excel->obj_php_excel->getActiveSheet()->setCellValue('A1', 'Tên truy cập');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('B1', 'Họ và tên');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('C1', 'Địa chỉ');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('D1', 'Email');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('E1', 'Điện thoại');
				foreach ($list as $item){
					$key = isset($key)?($key+1):2;
					$excel->obj_php_excel->getActiveSheet()->setCellValue('A'.$key, $item->username);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.$key, $item->fullname);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('C'.$key, $item->address);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('D'.$key, $item->email);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('E'.$key, $item->mobilephone);
				}
				$excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray( $style_header );
				$excel->obj_php_excel->getActiveSheet()->duplicateStyle( $excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:E1' );
				$output = $excel->write_files();
				echo URL_ROOT.'ione_admin/'.$output['xls'];
			}
		}	
		function quality_export(){
			$html='<form id="form1" name="form1" method="post" >';
			$html.='<h1 style="color:#FF0000; text-align:center">Bạn hãy điền số thứ tự của bản ghi muốn export</h1>';
			$html.='<p style="text-align:center"><label>Bắt đầu :</label>';
			$html.='<input type="text" name="start_at" id="start_at" /><br />';
			$html.='<label>Kết thúc: </label><input type="text" name="end_at" id="end_at" /><br><span>Nếu bạn không nhập số thứ tự thì hệ thống sẽ tự export từ 1 - 10</span></p>';
			$html.='<p style="text-align:center">';
			$html.='<label>';
			$html.='<input onclick="javascript:configClickExport();" type="submit" name="submit_quality" id="submit_quality" value="Ok" />';
			$html.='</label>';
			$html.='</p>';
			$html.='</form>';
			print_r($html);		
		}
	}

	function view_total($controle, $user_id){
		$model = $controle-> model;
		$yearnow = date('Y');
		$record = $model-> get_record('year = '.$yearnow.' AND user_id = '.$user_id,'fs_members_total', '*');
		if(!@$record-> total) {
			return 0;
		} else {
			return format_money($record-> total);
		}
	}

	function view_total_after_discount($controle, $total_after_discount) {
		return format_money($total_after_discount);
	}

	function view_status($controle, $status){
		if($status) {
			return 'Đã hoàn tất!';
		} else {
			return 'Chưa hoàn tất!';
		}
	}

	function view_views($controle, $id){
		$html = '<a title="Views" target="_blank" href="index.php?module=order&view=order&task=edit&id='.$id.'"><img border="0" alt="Views" src="templates/default/images/edit.png"></a>';
		return $html;
	}

	function view_code_order($controle, $id){
		return 'DH'.str_pad($id, 8 , "0", STR_PAD_LEFT);
	}


	function view_value($controle, $value){
		if($value < 0) {
			$class = "value_value point_down";
		} else {
			$class = "value_value point_up";
		}
		$html = '<div class="'.$class.'">'.$value.' điểm</div>';
		return $html;
	}

	function view_image_money($controle, $value){
		if($value < 0) {
			$class = "money_icon point_down";
		} else {
			$class = "money_icon point_up";
		}

		$html = '<div class="'.$class.'"><svg x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
		<g>
		<g>
		<path d="M437.019,74.98C388.668,26.629,324.381,0,256,0C187.62,0,123.333,26.629,74.981,74.98C26.629,123.332,0,187.619,0,256    s26.628,132.668,74.981,181.02C123.333,485.371,187.62,512,256,512c68.381,0,132.668-26.629,181.02-74.98    C485.372,388.668,512,324.381,512,256S485.372,123.332,437.019,74.98z M272.068,367.4H271v33.201c0,8.284-6.715,15-15,15    c-8.283,0-15-6.716-15-15V367.4h-33.199c-8.283,0-15-6.716-15-15s6.717-15,15-15h64.268c18.306,0,33.199-14.894,33.199-33.2    c0-18.306-14.894-33.2-33.2-33.2h-32.135c-34.848,0-63.199-28.351-63.199-63.199c0-34.849,28.352-63.2,63.199-63.2H241v-33.2    c0-8.284,6.717-15,15-15c8.285,0,15,6.716,15,15v33.2h33.201c8.283,0,15,6.716,15,15s-6.717,15-15,15h-64.268    c-18.307,0-33.199,14.893-33.199,33.2c0,18.306,14.893,33.199,33.199,33.199h32.135c34.848,0,63.199,28.352,63.199,63.2    S306.916,367.4,272.068,367.4z"></path>
		</g>
		</g>
		</svg></div>';
		return $html;

	}
	
	?>