<?php
	// models 
//	include 'modules/'.$module.'/models/'.$view.'.php';
		  
	class Seo_keywordsControllersSeo_keywords extends Controllers
	{
		function __construct()
		{
			$this->view = 'seo_keywords' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$model = $this -> model;
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;		
			$pagination = $this -> model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}

		function loadseo_keywords()
		{	
			$model  = $this -> model;
			$main_keyword = FSInput::get('main_keyword');
			$data_id = FSInput::get('data_id');
			$data_module = FSInput::get('data_module');
			$fs_table = FSFactory::getClass('fsstring');

			$result = $model-> get_all_keyword_new($main_keyword,$data_id,$data_module);

			if(empty($result)){
				$result = $model->get_all_keyword_pro($main_keyword,$data_id,$data_module);
			}
		
			if(!empty($result)){
				echo 1;
			}else{
				echo 0;
			}
			return;
		}


		function update_keywords(){

			$model  = $this -> model;

			$main_keyword = FSInput::get('main_keyword');
			$stt_active = FSInput::get('stt_active');
			$list_point_seo = FSInput::get('list_point_seo');
			include 'modules/'.$this->module.'/views/'.$this->view.'/update_keywords.php';
		}
		
  //       function loadseo_keywords()
		// {	
		// 	$model  = $this -> model;
		// 	$main_keyword = FSInput::get('main_keyword');		
		// 	$fs_table = FSFactory::getClass('fsstring');

		// 	$result = $model-> get_all_keyword_new($main_keyword);

		// 	if(empty($result)){
		// 		$result = $model->get_all_keyword_pro($main_keyword);
		// 	}
		
		// 	if(!empty($result)){
		// 		echo 1;
		// 	}else{
		// 		echo 0;
		// 	}
		// 	return;
		// }
       	
	}
	
?>