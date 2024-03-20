<?php 
	class MembersModelsImport
	{
	
		/********** IMPORT ***************/
		function uploadfile()
		{
			if ($_FILES["file_upload"]["error"] > 0)
		    {
		    	Errors::setError(FSText::_('Error when upload'),'error');
		    	return false;
		    }
			if($_FILES["file_upload"]["type"] != 'text/xml')
			{
				Errors::setError(FSText::_('File invalid format'),'error');
				return false;
			}
		  	
		    if (file_exists("tmpl/mb_new_import.xml"))
		    {
		    	if(!unlink("tmpl/mb_new_import.xml"))
		    	{
		    		Errors::setError(FSText::_('Can not remove file mb_import.xml in folder tmpl'),'error');
		    		return false;
		    	}
		    }
		    
		    if(!move_uploaded_file($_FILES["file_upload"]["tmp_name"],"tmpl/mb_new_import.xml"))
		    {
		    	Errors::setError(FSText::_('Error when upload'),'error');
		    	return false;
		    }
		    	
		    return true;
		}
		
		/*
		 * Read XML file and save
		 */
		
		function readXMLfile()
		{
			$file  = "tmpl/mb_new_import.xml";	
		 	$doc = new DOMDocument();
		  	$doc->load($file );
			
		  	// rootNode
			$mbs =   $doc->getElementsByTagName( "users" );
			$mbs1 =  $mbs->item(0);
			
			// sim list
			$sim_list = $mbs1-> getElementsByTagName( "user" );
//			$i = 0;
//			$str_arr  = array() ;
			
			$import_error = array();
			$count_import_suc = 0;
			
			foreach($sim_list as $sim ) 
			{
				$row = array();
				$sim_number = $sim->getElementsByTagName( "username" );
				if($sim_number->item(0))
				{
					$sim_number = $sim_number->item(0)->nodeValue;
	
					$row['sim_number'] = $sim_number;
					
					// save

					if(!$this->import_update($row))
					{
						$import_error[] = $sim_number;
					}
					else
					{
						$count_import_suc++;
					}
				}
			}
			if(count($import_error))
			{
				$str_error = implode(",",$import_error);
				Errors::setError($str_error." kh&#244;ng th&#7875; l&#432;u",'error');
			}
			// remove tmpl after save
			unlink("tmpl/mb_new_import.xml");
			return $count_import_suc;
		}
		
		/*
		 * save into database
		 */
		function import_update($row)
		{
			$userid = $this -> import_check_save($row);
			if(!$userid)
				return false;
			
			$sim_number =  $row['sim_number'] ;
			$time = date("Y-m-d H:i:s");
			// update into members
			$value = 1;
			global $db;
			$sql = " UPDATE fs_members
							SET isActivated = $value,
							actived_date = '$time'
						WHERE sim_number = $sim_number ";
		 	$db->query($sql);
			$rows = $db->affected_rows($sql);
//			if(!$rows)
//				return false;
			// update into sims
			$value = 0; // published reverse with isActivated of member
			$sql = " UPDATE fs_sims
							SET published = $value							
						WHERE sim_number = $sim_number ";
		 	//$db->query($sql);
			$rows = $db->affected_rows($sql);
//			return $rows;				
			
			return true;
		}
		
		function import_check_save($row)
		{
			$sim_number =  $row['sim_number'] ;
			global $db;
			$sql = " SELECT id
						FROM fs_members
						WHERE sim_number = '$sim_number'" ;
				//$db->query($sql);
				$rows = $db->getObject($sql);
			if(!isset($rows->id))
			{
				Errors::setError("Không thành viên nào có sim: ".$sim_number,'error');
				return false;
			}
			return true;
		}	
	}
	
	
?>