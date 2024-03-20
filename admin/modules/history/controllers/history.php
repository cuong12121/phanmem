<?php
class HistoryControllersHistory extends Controllers {

	function display() {
		parent::display ();
		$sort_field = $this->sort_field;
		$sort_direct = $this->sort_direct;
		
		$model = $this->model;
		$list = $model->get_data ();

		$users = $model -> get_users();
		
		$pagination = $model->getPagination ();
		include 'modules/' . $this->module . '/views/' . $this->view . '/list.php';
	}



}
	function description_history($data){
		$str = '';
		if(@$data -> task == 'save' || @$data -> task == 'apply'){
			if(!$data -> ids_action) {
				$str =  "Thêm mới record";
			}else{
				$str =  "Sửa record id = ".$data -> ids_action;
			}
		}
		if(@$data -> task == 'published' || @$data -> task == 'unpublished'){			
			$str =  $data -> task." record id = ".$data -> ids_action;			
		}
		if(@$data -> task == 'remove' || @$data -> task == 'del' || @$data -> task == 'delete'){			
			$str =  "Xóa record id = ".$data -> ids_action;			
		}
		return $str;
	}
?>