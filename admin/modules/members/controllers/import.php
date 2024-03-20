<?php 

class MembersControllersImport
	{
		var $module;
		var $gid;
		function __construct()
		{
			global $module;
			$this->module = 'members' ; 
		}
		
		/*
		 * export file xml sample
		 */
		function sample()
		{
			$file = 'samples/sample-user-activated.xls';
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false);			
			header("Content-type: application/force-download");			
			header("Content-Disposition: attachment; filename=\""."sample-user-activated.xls"."\";" );	
			header("Content-Transfer-Encoding: binary");			
			readfile("$file");
			exit();	
		}
		
		function  display()
		{
			include 'modules/'.$this->module.'/views/import/import.php';
		}

		function import_save()
		{
			// models 
			include 'modules/'.$this -> module.'/models/import.php';			
			$model = new MembersModelsImport();
			if(!$model->uploadfile())
			{
				setRedirect("index.php?module=members&view=import",FSText::_('No'),'error');
				return;	
			}
			$total = $model->readXMLfile();
			if(!$total)
			{
				setRedirect("index.php?module=members&view=import",FSText::_('Error'),'error');
				return;	
			}
			else 
			{
				setRedirect("index.php?module=members&view=import","There are ".$total. " members is activated");
				return;	
			}
			
			
		}
	}
?>