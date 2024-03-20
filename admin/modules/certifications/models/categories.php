<?php 
	class CertificationsModelsCategories extends ModelsCategories
	{
		function __construct()
		{
			$this -> limit = 20;		
			$this -> table_items = 'fs_certifications';
			$this -> table_name = 'fs_certifications_categories';
			$this -> check_alias = 1;
			$this -> call_update_sitemap = 1;
			
			// exception: key (field need change) => name ( key change follow this field)
			//$this -> field_except_when_duplicate = array(array('list_parents','id'));
			$this -> arr_img_paths = array(array('resized',420,300,'cut_image'),array('compress',1,1,'compress'));
			$cyear = date ( 'Y' );
			$cmonth = date ( 'm' );
			$cday = date ( 'd' );
			$this -> img_folder = 'images/certification/'.$cyear . '/' . $cmonth . '/' . $cday;
			$this -> check_alias = 0;
			$this -> field_img = 'image';
			$this -> field_except_when_duplicate = array(array('list_parents','id'));

			parent::__construct();
		}
	}
	
?>