<?php
/*
 * Huy write
 */
	// controller
	include 'plugins/rates/models/rates.php';
	
	class RatesPControllersRates
	{
		var $module;
		var $view;
		function display($data){
			$model = new RatesPModelsRates();
			// $rates = $model->get_rates ( $id);
			$query_body = $model->set_query_body();
			$rates = $model->get_parents($query_body);
			$rates_children = $model->get_list($query_body);
			if(isset($_COOKIE['user_id'])) {
				$addess_book = $model->get_record('id = ' .$_COOKIE['user_id'],'fs_members');
			}
			
			global $config;
			// if(empty($rates)){
			// 	$id = 0;
			// 	$rates[0] = (object) array('name' => 'Quản trị viên', 'created_time' =>'2019-06-19 07:15:34' , 'id' =>'1' , 'email' => $config['admin_email'], 'rate' => 'Xin chào quý khách. Quý khách hãy để lại bình luận, chúng tôi sẽ phản hồi sớm', 'parent_id' => '0', 'level' => '0', 'record_id' =>$id , 'is_admin' =>'1' ,'avatar'=>'');
			// }

			// echo "<pre>";
			// print_r($rates);
			// die;

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
			if(!empty($list_parent)){
				foreach ($list_parent as $item){
					$count_rt[$item->id]=$model->get_countrate($item->id); 
				}
			}
			
			$pagination1 = $model->getPagination($total,$data);
			
			$count1 = $model->get_countr(1);
			$count2 = $model->get_countr(2);
			$count3 = $model->get_countr(3);
			$count4 = $model->get_countr(4);
			$count5 = $model->get_countr(5);

	
			$amp = FSInput::get('amp',0,'int');
			
			

			include 'plugins/rates/views/rates'.($amp?'_amp':'').'/default.php';
			// $return['content']= $html;
			
			// echo json_encode($return);
		}

	}
	
?>