<?php
/*
 * Huy write
 */
	// controller
	
	class RatesControllersRates extends FSControllers
	{
		var $module;
		var $view;
		function display(){
			$model = $this->model;
			// $rates = $model->get_rates ( $id);
			$keyword = FSInput::get('keyword'); // có keyword thôi phân trang
			if(!$keyword){
				$query_body = $model->set_query_body();
				$rates = $model->get_parents($query_body);
				$rates_children = $model->get_list($query_body);

				$total_rate = count ( $rates );
				if ($total_rate) {
					$list_parent = array ();
					$list_children = array ();
					foreach ( $rates as $item ) {
						if (! $item->parent_id) {

							$list_parent [] = $item;
	//						$rates_children = $model->get_rates_child($item->id);
						} 
					}
					
					foreach ( $rates_children as $child ) {
						if (! isset ( $list_children [$child->parent_id] ))
							$list_children [$child->parent_id] = array ();
						$list_children [$child->parent_id] [] = $child;
					}
				}
			
				$total = $model -> getTotal($query_body);
		
				$pagination1 = $model->getPagination($total);
			}else{

				$query_body = $model->set_query_body();
				// $rates = $model->get_parents($query_body);
				$rates = $model->get_list_by_keyword($query_body);
				$parent_ids = '';

				if(count($rates)){
					foreach ( $rates as $item ) {
						$parent_ids .= $parent_ids?',':'';
						if (! $item->parent_id) {
							$parent_ids .= $item-> id;							
						} else{
							$parent_ids .= $item-> parent_id;							
						}
					}
				}
			
				if($parent_ids){
					$list_parent = array ();
					$list_children = array ();
					$rates_parent = $model->get_parents_by_ids($parent_ids);
					$rates_children = $model->get_children_by_parents($parent_ids);
					foreach ( $rates_parent as $item ) {
						if (! $item->parent_id) {

							$list_parent [] = $item;
	//						$rates_children = $model->get_rates_child($item->id);
						} 
					}
					
					foreach ( $rates_children as $child ) {
						if (! isset ( $list_children [$child->parent_id] ))
							$list_children [$child->parent_id] = array ();
						$list_children [$child->parent_id] [] = $child;
					}

				}
			}	
				if(!empty($list_parent)){
				foreach ($list_parent as $item){
					$count_rt[$item->id]=$model->get_countrate($item->id); 
				}
			}
			
			$return = array();

	
			include 'modules/'.$this->module.'/views/'.$this->view.'/fetch_pages.php';
			// $return['content']= $html;
			
			// echo json_encode($return);
		}

	function save_rate() {

		$return = FSInput::get ( 'return' );
		$url = base64_decode ( $return );
		$email = FSInput::get('email');
		$name = FSInput::get('name');
		$name = strip_tags($name);
		$actual_link =  FSInput::get('linkurlall');
		$model = $this->model;

		if (! $model->save_rate ()) {
		// 	$msg = 'Chưa lưu thành công rate!';
		// 	setRedirect ( $url, $msg, 'error' );
			echo 0;
		} else {
			// setRedirect ( $url, 'Cảm ơn bạn đã gửi rate' );
			echo 1;
			return;
			// sendMailPhone
			// include 'modules/'.$this->module.'/controllers/emailsrate.php';
			// $user_emails = new  UsersControllersEmailsrate();
			// $user_emails -> sendMailrate($name,$email,$actual_link);
		}
	}
	/* Save rate reply*/
	function save_reply() {
		
		$return = FSInput::get ( 'return' );
		$url = base64_decode ( $return );
		$email = FSInput::get('email');
		$name = FSInput::get('name');
		$actual_link =  FSInput::get('linkurlall');
		$model = $this->model;
		if (! $model->save_rate ()) {
			// $msg = 'Chưa lưu thành công rate!';
			// setRedirect ( $url, $msg, 'error' );
			echo 0;

		} else {
			// echo 1;
			include 'modules/'.$this->module.'/controllers/sendmaireplyadmin.php';
			$user_emails = new  UsersControllersSendmaireplyadmin();
			// $user_emails -> sendMailrate($name,$email,$actual_link);
		}
	}

		

	}
	
?>