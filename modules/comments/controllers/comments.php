<?php
/*
 * Huy write
 */
	// controller
	
	class CommentsControllersComments extends FSControllers
	{
		var $module;
		var $view;
		function display(){
			$model = $this->model;
			// $comments = $model->get_comments ( $id);
			$keyword = FSInput::get('keyword'); // có keyword thôi phân trang
			if(!$keyword){
				$query_body = $model->set_query_body();
				$comments = $model->get_parents($query_body);
				$comments_children = $model->get_list($query_body);

				$total_comment = count ( $comments );
				if ($total_comment) {
					$list_parent = array ();
					$list_children = array ();
					foreach ( $comments as $item ) {
						if (! $item->parent_id) {

							$list_parent [] = $item;
	//						$comments_children = $model->get_comments_child($item->id);
						} 
					}
					
					foreach ( $comments_children as $child ) {
						if (! isset ( $list_children [$child->parent_id] ))
							$list_children [$child->parent_id] = array ();
						$list_children [$child->parent_id] [] = $child;
					}
				}
			
				$total = $model -> getTotal($query_body);
		
				$pagination = $model->getPagination($total);
			}else{

				$query_body = $model->set_query_body();
				// $comments = $model->get_parents($query_body);
				$comments = $model->get_list_by_keyword($query_body);
				$parent_ids = '';

				if(count($comments)){
					foreach ( $comments as $item ) {
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
					$comments_parent = $model->get_parents_by_ids($parent_ids);
					$comments_children = $model->get_children_by_parents($parent_ids);
					foreach ( $comments_parent as $item ) {
						if (! $item->parent_id) {

							$list_parent [] = $item;
	//						$comments_children = $model->get_comments_child($item->id);
						} 
					}
					
					foreach ( $comments_children as $child ) {
						if (! isset ( $list_children [$child->parent_id] ))
							$list_children [$child->parent_id] = array ();
						$list_children [$child->parent_id] [] = $child;
					}

				}
			}	
			
			$return = array();

	
			include 'modules/'.$this->module.'/views/'.$this->view.'/fetch_pages.php';
			// $return['content']= $html;
			
			// echo json_encode($return);
		}

	function save_comment() {
		$return = FSInput::get ( 'return' );
		$url = base64_decode ( $return );
		
		$model = $this->model;
		if (! $model->save_comment ()) {
		// 	$msg = 'Chưa lưu thành công comment!';
		// 	setRedirect ( $url, $msg, 'error' );
			echo 0;
		} else {
			// setRedirect ( $url, 'Cảm ơn bạn đã gửi comment' );
			echo 1;
		}
	}
	/* Save comment reply*/
	function save_reply() {
		$return = FSInput::get ( 'return' );
		$url = base64_decode ( $return );
		
		$model = $this->model;
		if (! $model->save_comment ()) {
			// $msg = 'Chưa lưu thành công comment!';
			// setRedirect ( $url, $msg, 'error' );
			echo 0;

		} else {
			echo 1;
		}
	}

		

	}
	
?>