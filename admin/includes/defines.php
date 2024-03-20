<?php
   
	$sort_path = $_SERVER['SCRIPT_NAME'];
//	$sort_path = str_replace('/index.php','', $sort_path);
	$sort_path =  (preg_replace('/\/[a-zA-Z0-9\_]+\.php/i', '', $sort_path));
	
	// lấy folder administrator
	$pos = strripos($sort_path,'/');
	$folder_admin = substr($sort_path,($pos+1));
		
	if (!defined('DS')) {
		define('DS', DIRECTORY_SEPARATOR);
	}				
	
	define('URL_ROOT', "https://" . $_SERVER['HTTP_HOST'] . str_replace($folder_admin, '', $sort_path));	
	define('URL_ADMIN', "https://" . $_SERVER['HTTP_HOST'] . str_replace($folder_admin, '', $sort_path).'admin'.'/');	
	define('URL_ROOT_REDUCE',str_replace($folder_admin, '', $sort_path));
	

	$path = $_SERVER['SCRIPT_FILENAME'];
	$path = str_replace('index.php','', $path);
	$path = str_replace('index2.php','', $path);
	$path = str_replace('/',DS, $path);
	$path = str_replace('\\',DS, $path);
	$path = str_replace(DS.$folder_admin.DS,DS, $path);
	
	define('PATH_BASE', $path);
	define('IS_REWRITE', 1);
	define('WRITE_LOG_MYSQL',0);
	define('LINK_AMIN', 'admin');
	define('USE_MEMCACHE',0);
	// define('TOKEN_GHTK','DdA30b1f8345C333289bB9afFec52d3b674F3746');
	// define('TOKEN_GHTK','43D409ca554Efe73531eA87826d72B9e1d85555a'); test

	$positions = array ('left' => 'Bên trái','right' => 'Bên phải','out_left'=>'Trượt trái','out_right' => 'Trượt phải',"home_r"=>"Bên phải slideshow",'home_r_mobile' => 'Bên phải slideshowmobile', "pos1" => "Pos 1" , 'pos2' =>'Pos2', "pos3"=> "Pos 3","pos4" => "Pos 4" , "pos5" => "Pos 5", "pos6" => "pos6", "pos7" => "pos7", "pos8" => "Pos 8", "pos9" => "Pos 9", "pos10" => "Pos 10", "footer_r" => "footer_r", "popup" => "Popup" , 'product_searchs' => 'Tìm kiếm nhiều', 'video_product' => 'Video product','right_b' =>'right_b bên phải tin tức','fix_icon' =>'Chứng năng nhanh' , 'popup' => 'Popup');
?>


