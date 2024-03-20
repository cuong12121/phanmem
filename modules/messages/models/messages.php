<?php
class MessagesModelsMessages extends FSModels {
	var $limit;
	var $page;
	function __construct() {
		$limit = 12;
		$page = FSInput::get ( 'page' );
		$this->limit = $limit;
		$this->page = $page;
	}
	
	function setQuery() {
		$task = FSInput::get ( 'task', 'inbox' );
		$email = $this->getEmailFromUserid ();
		
		if ($task == 'inbox') {
			return $this->setQueryInbox ();
		} else {
			return $this->setQueryOutbox ();
		}
	}
	/*
		 * input: $_COOKIE['user_id']
		 * output: email
		 */
	function getEmailFromUserid() {
		$user_id = $_COOKIE['user_id'];
		global $db;
		$sql = " SELECT email 
					FROM fs_members
					WHERE id = '$user_id' ";
		$db->query ( $sql );
		return $db->getResult ();
	}
	
	/*
		 * set SQL for inbox
		 */
	function setQueryInbox() {
		$sort = FSInput::get ( 'sort', 'DESC' );
		$sortby = FSInput::get ( 'sortby', 'id' );
		if (! $sortby)
			$sortby = 'id';
		if (! $sort)
			$sort = 'DESC';
		$user_id = $_COOKIE['user_id'];
		
		$order = " ORDER BY $sortby $sort";
		
		$sql = " SELECT * 
					FROM fs_messages
					WHERE (`recipients_id` LIKE \"%'$user_id'%\" OR recipients_username = 'all') 
					AND ( deleters_id NOT LIKE  \"%'$user_id'%\"  
							OR deleters_id is NULL )
					" . $order . " ";
		return $sql;
	}
    
    /*
	 * get user_id 
	 */
	function get_user() {
        global $db;
		$user_id = $_COOKIE['user_id'];
		if (!$user_id)
			return false;

		$sql = ' SELECT id,username,full_name,image
					FROM fs_members 
                    WHERE id  = '.$user_id
				;
		$db->query ( $sql );
		return $db->getObject ();
	}
    
	/*
		 * set SQL for outbox
		 */
	function setQueryOutbox() {
		$sort = FSInput::get ( 'sort', 'DESC' );
		$sortby = FSInput::get ( 'sortby', 'id' );
		if (! $sortby)
			$sortby = 'id';
		if (! $sort)
			$sort = 'DESC';
		
		$order = " ORDER BY $sortby $sort";
		$user_id = $_COOKIE['user_id'];
		$sql = " SELECT * 
					FROM fs_messages
					WHERE `sender_id` =  '$user_id' 
					AND ( deleters_id NOT LIKE  \"%'$user_id'%\"  
							OR deleters_id is NULL ) 
					" . $order . " ";
		return $sql;
	}
	
	/*
		 * input: task, sim_number
		 */
	function getMessages() {
		global $db;
		$query = $this->setQuery ();
		if (! $query)
			return array ();
		
		$sql = $db->query_limit ( $query, $this->limit, $this->page );
		$result = $db->getObjectList ();
		return $result;
	}
	function getTotal() {
		global $db;
		$query = $this->setQuery ();
		$sql = $db->query ( $query );
		$total = $db->getTotal ();
		return $total;
	}
	
	function getPagination() {
		//			$task = FSInput::get('task','inbox');
		//			$Itemid = FSInput::get('Itemid');
		//			$url = "index.php?module=messages&task=$task&Itemid=$Itemid";
		$total = $this->getTotal ();
		if (! $total)
			return;
		FSFactory::include_class ( 'Pagination' );
		$pagination = new Pagination ( $this->limit, $total, $this->page );
		return $pagination;
	}
	
	/*
		 * input:list sim_number
		 * output: email of sender or recipient
		 */
	function getListMember($str_userid) {
		if (! $str_userid)
			return false;
		global $db;
		$sql = " SELECT *
					FROM fs_members
					WHERE id IN ($str_userid) ";
		$db->query ( $sql );
		return $db->getObjectList ();
	}
	
	/*
		 * input: messsage id
		 * output: email of sender or recipient
		 */
	function getSimListFromMsgid($msgid) {
		$sql = " SELECT sender_id ,recipients_id
					FROM fs_messages
					WHERE id = $msgid ";
		global $db;
		$db->query ( $sql );
		$msg = $db->getObject ();
		if (! $msg) {
			return;
		}
		$arr_sims = array ();
		$arr_sims [] = $msg->sender_id;
		$recipients = $msg->recipients_id;
		$recipients = str_replace ( "'", "", $recipients );
		$arr_recipients = explode ( ",", $recipients );
		if (count ( $arr_recipients )) {
			foreach ( $arr_recipients as $item ) {
				$arr_sims [] = $item;
			}
		}
		return $arr_sims;
	}
	
	/************* DETAIL ************/
	function getMessagesById() {
		$id = FSInput::get ( 'id', 0 );
		$sql = " SELECT * 
					FROM fs_messages
					WHERE id = $id
					 ";
		global $db;
		$db->query ( $sql );
		return $db->getObject ();
	}
	
	function getRepliesByMsgid() {
		$id = FSInput::get ( 'id', 0 );
		$sql = " SELECT * 
					FROM fs_messages_replies
					WHERE message_id= $id
					 ";
		global $db;
		$db->query ( $sql );
		return $db->getObjectList ();
	
	}
	function checkExistMember($username) {
		global $db;
		$sql = " SELECT id 
					FROM fs_members 
					WHERE username = '$username' ";
		$db->query ( $sql );
		return $db->getResult ();
	}
	function getMemberByUsername($username) {
		global $db;
		$sql = " SELECT * 
					FROM fs_members 
					WHERE username = '$username' ";
		$db->query ( $sql );
		return $db->getObject();
	}
	/************* ACTION ************/
	function delete() {
		$user_id = $_COOKIE['user_id'];
		$cids = FSInput::get ( 'id', array (), 'array' );
		if (count ( $cids )) {
			global $db;
			$str_cids = implode ( ',', $cids );
			$sql = " UPDATE fs_messages
							SET deleters_id = concat_ws(' ',\",'$user_id'\",deleters_id)
							where id IN ( $str_cids )";
			$db->query ( $sql );
			$rows = $db->affected_rows ();
			return $rows;
		}
		return 0;
	}
	/*
		 * Mark messages is read.
		 */
	function mark_read($id) {
		$user_id = $_COOKIE['user_id'];
		global $db;
		$sql = " UPDATE fs_messages
						SET readers_id = concat_ws(' ',\",'$user_id'\",readers_id)
						WHERE id = $id 
						AND ( readers_id is NULL 
							OR readers_id NOT LIKE  \"%'$user_id'%\" )";
		$db->query ( $sql );
		$rows = $db->affected_rows ();
		return $rows;
	}
	/*
		 * compose and save
		 */
	function save_compose() {
		global $db;
        // send cho nhieu nguoi
		$recipients = FSInput::get ( 'recipients_username' );
		$array_recipients = explode ( ";", $recipients );
		$array_username_error = array ();
		$array_username_suc = array ();
		$array_id_suc = array ();
		
		// check exist sim
		foreach ( $array_recipients as $item ) {
			$item = trim($item);
			$user =  $this->getMemberByUsername ( $item );
			if ($user){
				$array_username_suc [] = "\'" . $item . "\'";
				$array_id_suc [] = "\'" . $user -> id . "\'";
			}else{
				$array_username_error [] = $item;
			}
		}
		if (count ( $array_username_error )) {
			$str_array = implode ( ",", $array_username_error );
			$fserrors = FSFactory::getClass('Errors');
			$fserrors -> _( $str_array . " does not exist ",'alert');
		}
		if (! count ( $array_username_suc )) {
			return false;
		}
		if (count ( $array_username_suc )) {
			$str_username_suc = implode ( ",", $array_username_suc );
			$str_id_suc = implode ( ",", $array_id_suc );
		}
		
		// save
		$recipients = FSInput::get ( 'recipients' );
		$subject = FSInput::get ( 'subject' );
		$message = htmlspecialchars_decode ( FSInput::get ( 'texta_message' ) );
		$sender_id = $_COOKIE['user_id'];
		$sender_username = $_SESSION ['username'];
		$created_time = date ( 'Y-m-d H:i:s' );
		$message_size = strlen ( $message );
		$sql = " INSERT INTO 
						fs_messages (sender_id,recipients_id,sender_username,recipients_username,subject, message, created_time,message_size)
						VALUES ('$sender_id','$str_id_suc','$sender_username','$str_username_suc','$subject','$message','$created_time','$message_size')
					";
		
		$db->query ( $sql );
		$id = $db->insert ();
		return $id;
	}
	
	function save_reply() {
		global $db;
		$recipients = FSInput::get ( 'recipients' );
		$array_recipients = explode ( ";", $recipients );
		$message_id = FSInput::get ( 'message_id' );
		$sender_id = $_COOKIE['user_id'];
		$sender_username = $_SESSION ['username'];
		
		$array_username_error = array ();
		$array_in = array (); // member was entered in this message.
		$array_out = array (); // member is never entered  in this message.
		$array_username_out = array (); 
		$array_username_in = array (); 
		

		// get List sim_number in message
		$listsim = $this->getSimListFromMsgid ( $message_id );
		
		// check exist sim
		foreach ( $array_recipients as $item ) {
			$item = trim($item);
			$user =  $this->getMemberByUsername ( $item );
			if ($user){
				if ($item != $sender_id) {
					if (in_array ( $user -> id, $listsim )) {
						// in
						$array_in [] = "\'" . $user -> id . "\'";
						$array_username_in [] = "\'" . $user -> id . "\'";
					} else {
						// out
						$array_out [] = "\'" . $user -> id . "\'";
						$array_username_out [] = "\'" . $item . "\'";
					}
				}
				
//				$array_username_suc [] = "\'" . $item . "\'";
//				$array_id_suc [] = "\'" . $user -> id . "\'";
			}else{
				$array_username_error [] = $item;
			}
			
		}

		if (count ( $array_username_error )) {
			$str_array = implode ( ",", $array_username_error );
			$fserrors = FSFactory::getClass('Errors');
			$fserrors -> _( $str_array . " không tồn tại ",'alert');
		}
		if (! count ( $array_in )) {
			return false;
		}
		
		$recipients = FSInput::get ( 'recipients' );
		$message = htmlspecialchars_decode ( FSInput::get ( 'message' ) );
		$created_time = date ( 'Y-m-d H:i:s' );
		$message_size = strlen ( $message );
		
		$subject = $this->getSubject ( $message_id );
		// save new message if count(array_out) > 0
		if (count ( $array_out )) {
			$str_out = implode ( ",", $array_out );
			$array_username_out = implode ( ",", $array_username_in );
			$sql = " INSERT INTO 
						fs_messages (sender_id,recipients_id,sender_username,recipients_username,subject, message, created_time,message_size)
						VALUES ('$sender_id','$str_out','$sender_username','$array_username_out','$subject','$message','$created_time','$message_size')
					";
//			$sql = " INSERT INTO 
//						fs_messages (sender_id,recipients_id,sender_username,recipients_username,subject, message, created_time,message_size)
//						VALUES ('$sender_id','$str_id_suc','$sender_username','$str_username_suc','$subject','$message','$created_time','$message_size')
//					";
			
			$db->query ( $sql );
			$msg_new_id = $db->insert ();
			if (! $msg_new_id) {
				$fserrors = FSFactory::getClass('Errors');
				$fserrors -> _('Không thể tạo tin mới cho những người không nằm trong tin nhắn này','alert');
			}
		}
		$str_in = implode ( ",", $array_in );
		$str_username_in = implode ( ",", $array_username_in );
		// save reply
		$sql = " INSERT INTO 
						fs_messages_replies (message_id,sender_id, recipients_id,sender_username, recipients_username, created_time, message, message_size)
						VALUES ('$message_id','$sender_id','$str_in','$sender_username','$str_username_in','$created_time','$message','$message_size')
					";
		$db->query ( $sql );
		$id = $db->insert ();
		return $id;
	}
	
	function getSubject($msgid) {
		$sql = " SELECT subject 
					FROM fs_messages
					WHERE id = $msgid ";
		global $db;
		$db->query ( $sql );
		return $db->getResult ();
	}

}

?>