<?php
class DiscountControllersMembers extends Controllers {
	function display() {
		parent::display ();
		
		$sort_field = $this->sort_field;
		$sort_direct = $this->sort_direct;
		
		$model = $this->model;
		$list = $model->get_data ();
		$discounts = $model->get_discounts ();
		$pagination = $model->getPagination ();
		include 'modules/' . $this->module . '/views/' . $this->view . '/list.php';
	}
	function add() {
	}
	
	function display_discount($data) {
		$discount  = $data->discount ? $data->discount : 0;
		if ($data->unit == 1)
			return $discount . ' ' . 'đ';
		else
			return $discount . ' ' . '%';
	}
	function display_sex($sex) {
		$tsex = $sex=='female'?'Nữ':'Nam';
		return FSText::_($tsex);
	}

}
?>