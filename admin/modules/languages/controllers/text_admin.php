<?php
	// models 
	
	class LanguagesControllersText_admin extends Controllers{
	function display() {
			// call models
		$model = $this -> model;
			
		// danh sách các ngôn ngữ
		$list_lang = $model->get_languages ();
		
		$list = $model->get_texts ();
			// call views
			include 'modules/'.$this->module.'/views/'.$this-> view.'/list.php';
		}
		
	
	}
