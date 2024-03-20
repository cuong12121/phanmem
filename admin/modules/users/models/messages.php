<?php 
	class UsersModelsMessages extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'messages';
			$this -> table_name = 'fs_messages';
			parent::__construct();
		}
		
		function setQuery(){
			
			// ordering
			$ordering = "";
			$where = "  ";
			if(isset($_SESSION[$this -> prefix.'sort_field']))
			{
				$sort_field = $_SESSION[$this -> prefix.'sort_field'];
				$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
				$sort_direct = $sort_direct?$sort_direct:'asc';
				$ordering = '';
				if($sort_field)
					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
			}
			
			if(!$ordering)
				$ordering .= " ORDER BY id DESC ";
			
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND a.subject LIKE '%".$keysearch."%' ";
				}
			}
			
			$query = " SELECT a.*
						  FROM 
						  	".$this -> table_name." AS a
						  	WHERE 1=1 ".
						 $where.
						 $ordering. " ";
			return $query;
		}
		
		function save_($row = array(), $use_mysql_real_escape_string = 1) {
			$subject = FSInput::get('subject');

			if(!$subject){
				Errors::_('Bạn phải nhập tiêu đề');
				return;
			}
			$row2 = array();
			$row2['message'] = htmlspecialchars_decode(FSInput::get('message'));
			$id  = FSInput::get('id',0,'int');
			// Admin gửi ra ngoài				
			if(!$id){
				$recipients_username = FSInput::get('recipients_username');
				if(!$recipients_username || $recipients_username==','){
					Errors::_('Bạn phải nhập người nhận');
					return;
				}


					if($recipients_username == 'all'){
						$row['recipients_username'] = all;
					}elseif($recipients_username == 'dk'){
						$row['recipients_username'] = dk;
					}elseif(1==1){
						$row['recipients_username'] = $recipients_username;
					}

				else{
					$array_recipients = explode ( ";", $recipients_username );
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

					if(count ($array_username_error)) {
						$str_array = implode ( ",", $array_username_error );
						Errors::_( $str_array . " không tồn tại ",'alert');
					}

					if (! count ( $array_username_suc )) {
						return false;
					}
					if (count ( $array_username_suc )) {
						$str_username_suc = implode ( ",", $array_username_suc );
						$str_id_suc = implode ( ",", $array_id_suc );
						$row['recipients_id'] = $str_id_suc;
						$row['recipients_username'] = $str_username_suc;
					}
				}
				$row['sender_id'] = 0;
				$row['sender_username'] = 'Admin';
				$row['alias'] = stringStandart($subject);
			}
			$result_id =  parent::save($row);
			if($result_id){
				$this->_update2($row2 ,'fs_messages','id = '. $result_id);
			}
			return $result_id;
		}
		
		function getMemberByUsername($username) {
			global $db;
			$sql = " SELECT * 
						FROM fs_members 
						WHERE username = '$username' ";
			$db->query ( $sql );
			return $db->getObject();
		}

		function update_view_noti(){
			$noti = $this->get_record('1=1','fs_messages','id','id DESC');
			if(!empty($noti)){
				$row = array();
				$row['view_noti_id'] = $noti->id;
				$this->_update($row,'fs_users','id = '.$_SESSION['ad_userid']);
			}
		}
		
	}
	
?>