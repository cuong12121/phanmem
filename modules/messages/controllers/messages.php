<?php
/*
 * Huy write
 */
// controller
class MessagesControllersMessages extends FSControllers {
	var $module;
	var $view;
	function display() {
		$fssecurity = FSFactory::getClass ( 'fssecurity' );
		$fssecurity->checkLogin ();
		// call models
		$this->inbox ();
	}
	
	function inbox() {
		$fssecurity = FSFactory::getClass ( 'fssecurity' );
		$fssecurity->checkLogin ();
		$model = $this->model;
		$user = $model->get_user();
		$data = $model->getMessages ();
		$total = $model->getTotal ();
		$str_userid = "";
		$arr_userid = array ();
		
		
		// choise userid
		foreach ( $data as $item ) {
			if ($item->sender_id)
				$arr_userid [] = $item->sender_id;
		}
		$str_userid = implode ( ",", $arr_userid );
		
		if ($str_userid)
			$members = $model->getListMember ( $str_userid );
		
		$arr_email = array ();
		if (isset ( $members )) {
			foreach ( $members as $item ) {
				$arr_email [$item->id] = $item->email;
				$arr_fullname [$item->id] = $item->full_name;
                $arr_username [$item->id] = $item->username;
                $arr_member [$item->id] = $item;
			}
		}
		
		$pagination = $model->getPagination ();
		include 'modules/' . $this->module . '/views/' . $this->view . '/inbox.php';
	}
	function outbox() {
		$fssecurity = FSFactory::getClass ( 'fssecurity' );
		$fssecurity->checkLogin ();
		$model = $this->model;
        $user = $model->get_user();
		$total = $model->getTotal ();
		$data = $model->getMessages ();
		
		$str_userid = "";
		$arr_userid = array ();
		
		// choise sim_number
		foreach ( $data as $item ) {
			if ($item->sender_id)
				$arr_userid [] = $item->sender_id;
		}
		$str_userid = implode ( ",", $arr_userid );
		
		if ($str_userid)
			$members = $model->getListMember ( $str_userid );
		
		$arr_email = array ();
		if (isset ( $members )) {
			foreach ( $members as $item ) {
				$arr_email [$item->id] = $item->email;
				$arr_fullname [$item->id] = $item->full_name;
                $arr_username [$item->id] = $item->username;
			}
		}
		
		$pagination = $model->getPagination ();
		include 'modules/' . $this->module . '/views/' . $this->view . '/outbox.php';
	}
	
	function delete() {
		$fssecurity = FSFactory::getClass ( 'fssecurity' );
		$fssecurity->checkLogin ();
		$model = $this->model;
		$Itemid = FSInput::get ( 'Itemid' );
		$last_task = FSInput::get ( 'last_task', '' );
		if ($last_task) {
			$url_redirect = "index.php?module=messages&view=messages&task=$last_task&Itemid=$Itemid";
		} else {
			$url_redirect = "index.php?module=messages&view=messages&Itemid=$Itemid";
		}
		$sort = FSInput::get ( 'sort' );
		if ($sort)
			$url_redirect .= "&sort=$sort";
		$sortby = FSInput::get ( 'sortby' );
		if ($sortby)
			$url_redirect .= "&sortby=$sortby";
		$rows = $model->delete ();
		$url_redirect = FSRoute::_ ( $url_redirect );
		if ($rows) {
			setRedirect ( $url_redirect, FSText::_ ( 'Bạn đã xóa thành công ' . $rows . ' e-mail' ) );
		} else {
			setRedirect ( $url_redirect,FSText::_ ( 'Không có email nào được xóa' ), 'error' );
		}
	}
	
	function listUserInMessages() {
	
	}
	
	function view_fast() {
		$fssecurity = FSFactory::getClass ( 'fssecurity' );
		$fssecurity->checkLogin ();
		$model = $this->model;
		
		$data = $model->getMessagesById ();
		$replies = $model->getRepliesByMsgid ();
		
		// list member
		$str_userid = "";
		$arr_userid = array ();
		
		// choise sim_number
		

		if ($data->sender_id) {
			$arr_userid [] = $data->sender_id;
		}
		if ($data->recipients_id) {
			$arr_userid [] = $data->recipients_id;
		}
		if (count ( $replies )) {
			foreach ( $replies as $item ) {
				if ($item->sender_id) {
					$arr_userid [] = $item->sender_id;
				}
				if ($item->recipients_id) {
					$arr_userid [] = $item->recipients_id;
				}
			}
		}
		$arr_userid = array_unique ( $arr_userid );
		$str_userid = implode ( ",", $arr_userid );
		$str_userid = str_replace ( "'", "", $str_userid );
		if ($str_userid)
			$members = $model->getListMember ( $str_userid );
		
		$arr_email = array ();
		if (isset ( $members )) {
			foreach ( $members as $item ) {
				$arr_email [$item->id] = $item->email;
				$arr_fullname [$item->id] = $item->full_name;
			}
		}
		$arr_fullname [$_COOKIE['user_id']] = "t&#244;i";
		
		// mark read
		$id = FSInput::get ( 'id' );
		$mark_read = $model->mark_read ( $id );
		
		include 'modules/' . $this->module . '/views/' . $this->view . '/view_fast.php';
	}
	function detail() {
		$fssecurity = FSFactory::getClass ( 'fssecurity' );
		$fssecurity->checkLogin ();
		$model = $this->model;
		
		$data = $model->getMessagesById ();
		$replies = $model->getRepliesByMsgid ();
		
		// list member
		$str_userid = "";
		$arr_userid = array ();
		$arr_fullname = array ();
		$arr_username = array ();
		
		// choise sim_number
		

		if ($data->sender_id) {
			$arr_userid [] = $data->sender_id;
		}
		if ($data->recipients_id) {
			$arr_userid [] = $data->recipients_id;
		}
		if (count ( $replies )) {
			foreach ( $replies as $item ) {
				if ($item->sender_id) {
					$arr_userid [] = $item->sender_id;
				}
				if ($item->recipients_id) {
					$arr_userid [] = $item->recipients_id;
				}
			}
		}
		$arr_userid = array_unique ( $arr_userid );
		$str_userid = implode ( ",", $arr_userid );
		$str_userid = str_replace ( "'", "", $str_userid );
		if ($str_userid)
			$members = $model->getListMember ( $str_userid );
		
		$arr_email = array ();
		if (isset ( $members )) {
			foreach ( $members as $item ) {
				$arr_email [$item->id] = $item->email;
				$arr_fullname [$item->id] = $item->full_name;
				$arr_username [$item->id] = $item->username;
			}
		}
		$arr_fullname [$_COOKIE['user_id']] = "Me";
		
		// mark read
		$id = FSInput::get ( 'id' );
		$mark_read = $model->mark_read ( $id );
		
		include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
	}
	//		******************************************************
	/************* COMPOSE *******************/
	function compose() {
		$fssecurity = FSFactory::getClass ( 'fssecurity' );
		$fssecurity->checkLogin ();
		$username = FSInput::get('username');
		$product_id = FSInput::get('product_id',0,'int');
		if($product_id){
			$model = $this->model;
			$product = $model -> get_record_by_id($product_id,'fs_products');
		}
		
		include 'modules/' . $this->module . '/views/' . $this->view . '/compose.php';
	}
	
	/*
		 * Save compose-message
		 */
	function save_compose() {
		$fssecurity = FSFactory::getClass ( 'fssecurity' );
		$fssecurity->checkLogin ();
		$Itemid = FSInput::get ( 'Itemid' );
        		//if (! $this->check_captcha ()) {
//        			$msg = "B&#7841;n c&#7847;n nh&#7853;p m&#227; hi&#7875;n th&#7883;";
//        			$link = FSRoute::_ ( "index.php?module=messages&task=compose&Itemid=$Itemid" );
//        			setRedirect ( $link, $msg );
//        		}
		$model = $this->model;
		if (! $model->save_compose ()) {
			$msg = "Bạn không gửi được tin nhắn";
			$link = FSRoute::_ ( "index.php?module=messages&task=compose&Itemid=$Itemid" );
			setRedirect ( $link, $msg );
		} else {
			$msg = "Bạn đã gửi thành công tin nhắn";
			$link = FSRoute::_ ( "index.php?module=messages&task=inbox&Itemid=$Itemid" );
			setRedirect ( $link, $msg );
		}
	}
    
    /*
	 * View information of member
	 */
	function get_ajax_save_compose()
	{
		$model = $this->model;
        $row = $model -> save_compose();
        if (!$row) {
			return false;
		} else {
            $html = '';
            echo $html;
		}
		return;
	}
	
	/*
		 * Save forward-message
		 */
	function save_forward() {
		$fssecurity = FSFactory::getClass ( 'fssecurity' );
		$fssecurity->checkLogin ();
		$Itemid = FSInput::get ( 'Itemid' );
		$id = FSInput::get ( 'message_id' );
		$model = $this->model;
		if (! $model->save_compose ()) {
			$msg = "Bạn không gửi được tin nhắn";
			$link = FSFSRoute::_ ( "index.php?module=messages&task=detail&id=$id&Itemid=$Itemid" );
			setRedirect ( $link, $msg );
		} else {
			$msg = "Bạn đã gửi thành công tin nhắn";
			$link = FSRoute::_ ( "index.php?module=messages&task=detail&id=$id&Itemid=$Itemid" );
			setRedirect ( $link, $msg );
		}
	}
	
	/*
		 * function check Captcha
		 */
	function check_captcha() {
		$keystring = trim ( FSInput::get ( "keystring" ) );
		if (! isset ( $keystring )) {
			return 0;
		}
		if ($keystring != $_SESSION ['captcha_keystring']) {
			return 0;
		}
		return 1;
	}
	
	function reply() {
		Security::checkLogin ();
		include 'modules/' . $this->module . '/views/' . $this->view . '/reply.php';
	}
	function forward() {
		$fssecurity = FSFactory::getClass ( 'fssecurity' );
		$fssecurity->checkLogin ();
		$model = $this->model;
		$data = $model->getMessagesById ();
		include 'modules/' . $this->module . '/views/' . $this->view . '/forward.php';
	}
	
	function save_reply() {
		$fssecurity = FSFactory::getClass ( 'fssecurity' );
		$fssecurity->checkLogin ();
		$Itemid = FSInput::get ( 'Itemid' );
		$model = $this->model;
		$id = FSInput::get ( 'message_id' );
		if (! $model->save_reply ()) {
			$msg = "Bạn chưa gửi được tin nhắn";
			$link = FSRoute::_ ( "index.php?module=messages&task=detail&id=$id&Itemid=$Itemid" );
			setRedirect ( $link, $msg );
		} else {
			$msg = "Bạn đã gửi thành công tin nhắn";
			$link = FSRoute::_ ( "index.php?module=messages&task=detail&id=$id&Itemid=$Itemid" );
			setRedirect ( $link, $msg );
		}
	}
}

?>