<?php 
	class FaqModelsQuestion extends FSModels
	{
		function __construct()
		{
			parent::__construct();
			$this->limit = 10;
		}
		function save(){
			$name = FSInput::get('txt_name');
			$email = FSInput::get('txt_email');
			$address = FSInput::get('txt_address');
			$subject = FSInput::get('txt_subject');
			$fsstring = FSFactory::getClass('FSString','','../');
			$alias = $fsstring -> stringStandart($subject);
			$question = htmlspecialchars_decode(FSInput::get('txt_question'));
			$time = date("Y-m-d H:i:s");
			$published = 0;
			$ordering  = $this->get_max_ordering();
			
			$sql = " INSERT INTO 
						fs_faq (name,`email`,address,title,alias,question,ordering,updated_time,created_time,published)
						VALUES ('$name','$email','$address','$subject','$alias','$question','$ordering','$time','$time','$published')";
			global $db;
			$db->query($sql);
			$id = $db->insert();
			return $id;
		}
		/*
		 * get Max value of Ordering field in table fs_categories
		 */
		function get_max_ordering()
		{
			$query = " SELECT Max(a.ordering)
					 FROM fs_faq AS a
					";
			global $db;
			$sql = $db->query($query);
			$result = $db->getResult();
			if(!$result)
				return 1;
			return ($result + 1);	
		}
	}
	
?>