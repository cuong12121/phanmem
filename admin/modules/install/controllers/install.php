<?php
	class InstallControllersInstall extends Controllers
	{
		
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$list = $this -> model->get_data();
			$pagination = $this -> model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		
		function edit(){
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			$data = $model->get_record_by_id($id);
			$service = $model -> get_record_by_id($data->service_id,'fs_services');
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
	}
	
?>