<?php
	class ConfigControllersModules  extends Controllers
	{
		function __construct(){
			parent::__construct(); 
		}
		function display()
		{
			$model  = $this -> model;
			$list = $model->getData();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		function edit() 
		{
			$model = $this -> model;
			$id = FSInput::get('id',0,'int');
			$data = $model->get_record_by_id($id);
			// load config of module
			if(file_exists(PATH_BASE.'modules'.DS.$data -> module.DS.'config.php'))
				include_once '../modules/'.$data -> module.'/config.php';
			FSFactory::include_class('parameters');
			$config_name = $data -> module."_".$data -> view;
			if($data -> task)
				$config_name  = '_'.$data -> task;
			$config = isset($config_module[$config_name])?$config_module[$config_name]:array()  ;	
			
			$current_parameters = new Parameters($data->params);
			$params = isset($config['params'])?$config['params']: null;
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
		function add(){
			return;
		}
		
		function clean_cache(){
			$m = FSInput::get('m');
			if(!$m){
				setRedirect('index.php?module=config&view=modules','Không xóa cache thành công');
			}
			// $array_folder_contain_cache = array('modules','header','footer');
			// foreach($array_folder_contain_cache as $folder){
			// 	$path = PATH_BASE.'cache'.DS.$folder.DS.$m.DS;
			// 	// echo $folder;
			// 	// if(is_dir($path)){
			// 	// 	foreach (glob($path."*") as $file) {
			// 	// 	 	unlink($file);
			// 	// 	}
			// 	// }
			// 	$this ->deleteDir($path);
			// }
			$path =  PATH_BASE.'cache'.DS.'modules'.DS.$m.DS;
			$this -> remove_memcached();
			$this ->deleteDir($path);

			setRedirect('index.php?module=config&view=modules','Bạn xóa cache thành công cho module này');
		}
		function remove_memcached()
		{
			$array_memkey = array('blocks','config_commom','menus','banners','block_slideshow_get_list','block_video_get_list');
			$fsmemcache = FSFactory::getClass('fsmemcache');
			foreach($array_memkey as $key){
				$fsmemcache -> delete($key);
			}
		}
		function deleteDir($dirPath) {
		    // if (! is_dir($dirPath)) {
		    //     throw new InvalidArgumentException("$dirPath must be a directory");
		    // }
		    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
		        $dirPath .= '/';
		    }
		    $files = glob($dirPath . '*', GLOB_MARK);
		    foreach ($files as $file) {
		        if (is_dir($file)) {
		            self::deleteDir($file);
		        } else {
		            unlink($file);
		        }
		    }
		    rmdir($dirPath);
		}
		
		/*
		 * Building.....
		 */
		function remove_old_file(){
					/** define the directory **/
			$dir = "images/temp/";
			
			/*** cycle through all files in the directory ***/
			foreach (glob($dir."*") as $file) {
			
			/*** if file is 24 hours (86400 seconds) old then delete it ***/
			if (filemtime($file) < time() - 86400) {
			    unlink($file);
			    }
			}
		}
	}
	
?>