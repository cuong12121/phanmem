<?php
class DiscountModelsDiscount extends FSModels {
	
	function save() {
		$time = date ( "Y-m-d H:i:s" );
		$row['discount_id'] = FSInput::get ( 'discount_id',0,'int' );
		if(!$row['discount_id'])
			return false;
		$row['email'] = FSInput::get ( 'email' );
		$row['published'] = 1;
		$row['created_time'] = $time;
		$row['edited_time'] = $time;
		
		$female = FSInput::get('female');
		if($female){
			$row['sex'] = 'female';
		}else{
			$row['sex'] = 'male';
		}
		
		$discount = $this -> get_record_by_id($row['discount_id'],'fs_discount');
		//
		$row['discount'] = $discount -> discount;
		$row['unit'] = $discount -> unit;
		
		
		$fstring = FSFactory::getClass('FSString','','../');
		$row['code'] = $fstring->generateRandomString(8);
		
		// expire_time : to end day
		$expire_time = strtotime("+".$discount -> activated_time." day", time());
		$expire_time =  date ( "Y-m-d",$expire_time ).'23:59:59';
		$row['expire_time'] = date ( "Y-m-d H:i:s", strtotime($expire_time) );
		
		$id = $this -> _add($row,'fs_discount_members');
		if(!$id)	
			return false;
		
		// update to fs_discount
		$this -> update_total_member($row['discount_id']);
		
		//send mail
		$this->send_mail ( $row['email'],$row['code'] );
		
		return $id;
	}
	
	function update_total_member($discount_id){
		if(!$discount_id)
			return false;
		$total = $this -> get_count('discount_id = '.$discount_id.' AND published = 1 ','fs_discount_members');
		$row['total'] = $total;
		return $this -> _update($row,'fs_discount','  id = '.$discount_id);	
	}
	
	function send_mail($email,$code) {
		include 'libraries/errors.php';
		// send Mail()
		$mailer = FSFactory::getClass ( 'Email', 'mail' );
		$global = new FsGlobal ();
		$admin_name = $global->getConfig ( 'admin_name' );
		$admin_email = $global->getConfig ( 'admin_email' );
		$mail_register_subject = $global->getConfig ( 'mail_discount_subject' );
		$mail_register_body = $global->getConfig ( 'mail_discount_body' );
		
		//			global $config;
		// config to user gmail
				
		

		$mailer->isHTML ( true );
		//			$mailer -> IsSMTP();
		$mailer->setSender ( array ($admin_email, $admin_name ) );
		$mailer->AddAddress ( $email );
		$mailer->AddBCC ( 'quynhtn@finalstyle.com', 'pham van huy' );
		$mailer->setSubject ( $mail_register_subject );
		// body
		$body = $mail_register_body;
		$body = str_replace ( '{code}', $code, $body );
		$body = str_replace ( '{email}', $email, $body );
		
		$mailer->setBody ( $body );
		
		if (! $mailer->Send ()) {
			Errors::_ ( 'Có lỗi khi gửi mail' );
			return false;
		}
		return true;
	}
	
	/*
	 * Check exist email follow discount_id
	 */
	function check_exist($email, $discount_id) {
		if (! $email || ! $discount_id)
			return true;
		$query = " SELECT count(*)
					  FROM fs_discount_members
					WHERE 
						email = '" . $email . "' AND discount_id = " . $discount_id;
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getResult ();
		return $result;
	}
	
	/*
	 * Check limit
	 */
	function check_limit($discount_id) {
		if (!$discount_id)
			return false;
		$limit = $this -> get_result('id = '.$discount_id,'fs_discount','`limit`');	
		$total = $this -> get_count('discount_id = '.$discount_id.' AND published = 1 ','fs_discount_members');
		return $total < $limit ? true: false;
	}
}
?>