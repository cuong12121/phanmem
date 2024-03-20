<?php
/*
 * Huy write
 */

class FSRemote
{
	function __construct(){
		FSFactory::include_class('errors');
	}
	
	function connect_remote($get_type,$link)
	{
		if(!$link)
			return;
		$conts = "";
		//---------------------------------------------------
		if($get_type=="1")
		{
			$file=fopen($link,'rb');
			if($file)
			{
				while (!feof($file)) {
					$conts.= fread($file, 16384 );
				}
				fclose($file);
				
				if(!$conts)
					return false;
			}
			else
				return false;
			
		}
		
		//---------------------------------------------------
		if($get_type=="2")
		{
			$conts=file_get_contents($link);
			if(!$conts)
				return false;
		}
		
		//---------------------------------------------------
		if($get_type=="3")
			{
//				$link=str_replace('news.zing.vn','www.zing.vn',$link);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$link);
			curl_setopt($ch, CURLOPT_VERBOSE, 1);
			curl_setopt($ch, CURLOPT_POST, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			$conts=curl_exec($ch);
			curl_close ($ch);
		}
		if(!$conts)
			return false;
		return $conts;
	}
	
	/*
	 * Kiểm tra xem có phải là ảnh từ trang khác hay là bản thân nó
	 * 1: remote
	 * 0: on location
	 */
	function check_content_remote($link_img){
		if(strpos($link_img,'http') === false){
			return false;
		}
		if(strpos($link_img,URL_ROOT) !== false){
			return false;
		}
		return true;
	}
	/*
	 * Tự động lấy ảnh từ server khác về
	 */
	function save_image_in_remote_content($content,$link_root = ''){
		 preg_match_all('#<img (.*?)>#is',$content,$images);
		 preg_match_all('#<input (.*?)>#is',$content,$images);
		$arr_images = array();
		if(!count($images[0]))
			return $content;
		foreach($images[0] as $item){
			preg_match('#src([\s]*)=([\s]*)[\'|\"](.*?)[\'|\"]#is',$item,$link_img);
			$link_img = $link_img[3];
			if (filter_var($link_img, FILTER_VALIDATE_URL) === FALSE) {
			}else{
				continue;
			}
			$new_link_img = $link_img;
			if(strpos($new_link_img,'../') === 0 ){
				$new_link_img = str_replace('../', $link_root,$new_link_img); 
			}elseif(strpos($new_link_img,'http://') !== 0){
				$new_link_img = $link_root.$new_link_img;
			}
				
			if(FSRemote :: check_content_remote($new_link_img)){
				$image_link_local = FSRemote::save_image($new_link_img);
				if($image_link_local){
					$content = str_replace($link_img,$image_link_local, $content);
				}
			}
		}
		return $content;
	}
	
	/*
	 * Lưu ảnh lại theo ngày
	 */
	function save_image($link,$get_type = 1,$folder = '/upload_images/images/',$by_date = 1){
		if(strpos($link,'.gif') !== false || strpos($link,'.jpg') !== false || strpos($link,'.png') !== false || strpos($link,'.jpge') !== false){
			
			$fsFile = FSFactory::getClass('FsFiles','');
			
			if($by_date){
				$cyear = date('y');
				$cmonth = date('m');
				$cday = date('d');
				$folder .= $cyear.'/'.$cmonth.'/'.$cday.'/';
			}
			
			$fsFile -> create_folder($folder);
			
			// get file name			
			$filename = FSRemote::get_filename_from_url($link);
			$file  = PATH_BASE.str_replace('/',DS, $folder).$filename;
			$contents = FSRemote::connect_remote($get_type, $link);
			if(!$contents)
				return;
			$handle = fopen($file, 'w');
			$fw = fwrite($handle, $contents);
			fclose($handle);
			if(!$fw)
				return false;
			return $folder.$filename;
		}
		return false;
	}
	/*
	 * Lưu ảnh lại theo ngày
	 */
	function save_image_special($link,$get_type = 1,$folder = '/upload_images/images/',$by_date = 1){
		if(strpos($link,'.gif') !== false || strpos($link,'.jpg') !== false || strpos($link,'.png') !== false || strpos($link,'.jpge') !== false){
			
			$fsFile = FSFactory::getClass('FsFiles','');
//			$folder = '/upload_images/images/';
//			$cyear = date('y');
//			$cmonth = date('m');
//			$cday = date('d');
//			$folder .= $cyear.'/'.$cmonth.'/'.$cday.'/';
			
			$fsFile -> create_folder($folder);
			
			// get file name			
			$filename = FSRemote::get_filename_from_url($link,'_'.time());

			$file  = PATH_BASE.str_replace('/',DS, $folder).$filename;
			$contents = FSRemote::connect_remote($get_type, $link);
			if(!$contents)
				return;
			$handle = fopen($file, 'w');
			$fw = fwrite($handle, $contents);
			fclose($handle);
			if(!$fw)
				return false;
			return $folder.$filename;
		}
		return false;
	}
	/*
	 * Lưu ảnh dạng không extend (từ facebook
	 */
	function save_image_not_extend($link,$filename,$get_type = 1,$folder = '/upload_images/images/',$by_date = 1){
			
			$fsFile = FSFactory::getClass('FsFiles','');
//			$folder = '/upload_images/images/';
//			$cyear = date('y');
//			$cmonth = date('m');
//			$cday = date('d');
//			$folder .= $cyear.'/'.$cmonth.'/'.$cday.'/';
			
			$fsFile -> create_folder($folder);
			
			// get file name			
//			$filename = FSRemote::get_filename_from_url($link,'_'.time());

			$file  = PATH_BASE.str_replace('/',DS, $folder).$filename;
			$contents = FSRemote::connect_remote($get_type, $link);
			if(!$contents)
				return;
			$handle = fopen($file, 'w');
			$fw = fwrite($handle, $contents);
			fclose($handle);
			if(!$fw)
				return false;
			return $folder.$filename;
	}
	
	function get_filename_from_url($url,$subfolder = ''){
		if(!$url)
			return;
		$pos_sepa = strripos($url,"/");
		$filename = substr($url,($pos_sepa + 1 ));
		if($subfolder)
			$filename = str_replace('.', $subfolder.'.', $filename);
		return $filename;
	}
	
}