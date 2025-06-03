<?php
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
			$pagination = $model->getPagination();
			$wrap_id_warehouses = $model->get_wrap_id_warehouses();

			$test = !empty($_GET['test'])?1:0;


			// echo $wrap_id_warehouses;
			
			$warehouses = $model -> get_records('published = 1 AND id IN ('.$wrap_id_warehouses.')','fs_warehouses');
			$platforms = $model -> get_records('published = 1','fs_platforms');
			$houses = $model -> get_records('published = 1','fs_house');
			if($test==1){
				
				include 'modules/'.$this->module.'/views/'.$this->view.'/list1.php';
			}
			else{
				include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
			}


		}


		function export_pdf_count_shopee()
		{
			global $db;
			

			
			$query = "SELECT file_pdf 
        FROM fs_order_uploads_history_prints 
        WHERE platform_id = 2 
        AND warehouse_id IN (1, 2)
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

	
	
	
?>