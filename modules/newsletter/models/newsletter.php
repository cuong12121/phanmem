<?php
	class NewsletterModelsNewsletter extends FSModels{ 
		function save(){
			
			$name = FSInput::get('name');
			$email = FSInput::get('email');
			$published = 1;
			$time = date("Y-m-d H:i:s");
			
			$sql = " INSERT INTO 
						fs_newsletter (`name`,`email`,created_time,edited_time,published)
						VALUES ('$name','$email','$time','$time','$published')";
			global $db;
			$db->query($sql);
			$id = $db->insert();
			return $id;
		}
		
	}
	
?>