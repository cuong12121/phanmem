<?php
/*
 * Huy write
 */

class FSFiles
{
	function __construct(){
		FSFactory::include_class('errors');
	}
	/*
	 * Upload in host
	 * @size_max: max of file
	 * input_tag_name: name of tag input
	 */
	function uploadImage($input_tag_name, $path ,$size_max= 2000000, $suffix = '',$crop = 0,$crop_width = 0, $crop_height = 0)
	{
		if (($_FILES[$input_tag_name]["type"] != "image/gif")
		&& ($_FILES[$input_tag_name]["type"] != "image/png")
		&& ($_FILES[$input_tag_name]["type"] != "image/jpeg")
		&& ($_FILES[$input_tag_name]["type"] != "image/pjpeg")){
			Errors:: setError('Extension of file is not format');
			return false;
		}
		if($_FILES[$input_tag_name]["size"] > $size_max){
			Errors:: setError('File have too large size');
			return false;
		}
	  		
		  	if ($_FILES[$input_tag_name]["error"] > 0)
		    {
		    	Errors:: setError("File error");
		    	return false;
		    }
		  	else
		    {
//			    if($path[strlen($path)-1]!="/")
//				{
//					$path .= "/";
//				}
		    	$file_new = $_FILES[$input_tag_name]["name"];
		    	$file_ext = $this -> getExt($_FILES[$input_tag_name]["name"]);
		    	
		    	// if change file when upload
		    	if(trim($suffix) != '')
		    	{
			    	
			    	$file_name = $this -> getFileName($_FILES[$input_tag_name]["name"], $file_ext);
			    	
			    	$file_new = $file_name . $suffix.".".$file_ext;
			    	
		    	} 
		    	// if not change, must check exist
		    	else
		    	{
			    	if (file_exists($path . $_FILES[$input_tag_name]["name"]))
			      	{
		     			Errors:: setError($_FILES[$input_tag_name]["name"] . FSText :: _(" already exists. ") );
		     			return false;
			      	}
		    	}
		    	
		    	if(!$this -> create_folder($path)){
		    		Errors:: setError("Not create folder ".$path);
	    			return false;
		    	}
		    	// crop image
		    	if($crop  && $crop_width && $crop_height)
		    	{
		    		// calculate new size
		    		list($old_width,$old_height) = getimagesize($_FILES[$input_tag_name]["tmp_name"]);
		    		if(($crop_width/$crop_height)>($old_width/$old_height))
					{
						$new_height = $crop_height;
						$new_width = $new_height*$old_width/$old_height;
					}
					else
					{
						$new_width = $crop_width;
						$new_height = (($new_width*$old_height)/$old_width);			
					}
					
					$cropped_tmp=imagecreatetruecolor($new_width,$new_height);
					
					if($file_ext == "png"){
            			$source = imagecreatefrompng($_FILES[$input_tag_name]["tmp_name"]);
			        }elseif($file_ext == "jpg" || $file_ext == "jpeg"){
			            $source = imagecreatefromjpeg($_FILES[$input_tag_name]["tmp_name"]);
			        }elseif($file_ext == "gif"){
			            $source = imagecreatefromgif($_FILES[$input_tag_name]["tmp_name"]);
			        } 
					
					if(!imagecopyresampled($cropped_tmp,$source,0,0,0,0,$new_width,$new_height, $old_width,$old_height))
					{
						Errors:: setError("Cannot Initialize new GD image stream");
						return false;
					}
					
					if($file_ext == "png"){
            			$source = imagepng($cropped_tmp,$path . $file_new,0); 
			        }elseif($file_ext == "jpg" || $file_ext == "jpeg"){
			            $source = imagejpeg($cropped_tmp,$path . $file_new,90);
			        }elseif($file_ext == "gif"){
		            	$source = imagegif($cropped_tmp,$path . $file_new,0);
			        } 
					
			    	if(!$source)
			        {
			        	Errors::setErrors("Not create a new image from file or URL");
			        	return false;
			        }
			        
					imagedestroy($cropped_tmp);
					imagedestroy($source);
					
				 	chmod($path . $file_new, 0777); 	
		    	}
		    	else
		    	{
		    		ini_set("safe_mode",0);
    		      	if(!move_uploaded_file($_FILES[$input_tag_name]["tmp_name"],$path . $file_new))
			      	{
			      		Errors:: setError("Not upload file when move upload. Check permission write folder");
			      		return false;
			      	}
		    	}

		      	return $file_new;
		    }
	}
	
	/*
	 * from HOST to Host.
	 * Not use in case upload
	 * img_destination: path . name destination
	 * $img_source: path . name source
	 */
	function cropImge($img_source, $img_destination,$crop_width = 1, $crop_height = 1)
	{
		if (!file_exists($img_source)) {
			Errors::setError("File $img_source not exist");
			return false;
		}
		list($old_width,$old_height) = getimagesize($img_source);
		if(($crop_width/$crop_height)>($old_width/$old_height))
		{
			$new_height = $crop_height;
			$new_width = $new_height*$old_width/$old_height;
		}
		else
		{
			$new_width = $crop_width;
			$new_height = (($new_width*$old_height)/$old_width);			
		}
		$file_ext = $this -> getExt($img_source);
		$cropped_tmp = @imagecreatetruecolor($new_width,$new_height)
			or die("Cannot Initialize new GD image stream when cropped");

		//		Add back-ground: white replace transparent
		imagealphablending($cropped_tmp, false);
  		imagesavealpha($cropped_tmp,true);
  		$transparent = imagecolorallocatealpha($cropped_tmp, 0, 0, 0, 0);
  		imagefilledrectangle($cropped_tmp, 0, 0, $new_width, $new_height, $transparent);
			
			
		if($file_ext == "png"){
            $source = imagecreatefrompng($img_source);
        }elseif($file_ext == "jpg" || $file_ext == "jpeg"){
            $source = imagecreatefromjpeg($img_source);
        }elseif($file_ext == "gif"){
            $source = imagecreatefromgif($img_source);
        } 
        if(!$source)
        {
        	Errors::setError("Not create a new image from file or URL when cropped");
        	return false;
        }
        if(!imagecopyresampled($cropped_tmp,$source,0,0,0,0,$new_width,$new_height, $old_width,$old_height))
        {
        	Errors::setErrors("Not copy and resize part of an image with resampling when cropped");
        	return false;
        }
					
        if($file_ext == "png"){
           	$result  =  imagepng($cropped_tmp,$img_destination,0); 
        }elseif($file_ext == "jpg" || $file_ext == "jpeg"){
            $result  =  imagejpeg($cropped_tmp,$img_destination,90);
        }elseif($file_ext == "gif"){
            $result  =  imagegif($cropped_tmp,$img_destination,0);
        } 
        if( !$result)
        {
        	Errors::setError("Not output a image to either the browser or a file when cropped" );
        	return false;
        }
		
		imagedestroy($cropped_tmp);
		imagedestroy($source);
		
	 	chmod($img_destination, 0777); 
	 	return true;
	}
	/*
	 * from HOST to Host.
	 * Not use in case upload
	 * img_destination: path . name destination
	 * Note: Note crop
	 * Note: Not insert white background
	 */
	function resized_not_crop($img_source, $img_destination,$new_width = 1, $new_height = 1)
	{
		if (!file_exists($img_source)) {
			Errors::setError("File $img_source not exist");
			return false;
		}
		list($old_width,$old_height) = getimagesize($img_source);
		$file_ext = $this -> getExt($img_source);
		$cropped_tmp = @imagecreatetruecolor($new_width,$new_height)
			or die("Cannot Initialize new GD image stream when cropped");
		
		//		Add back-ground: white replace transparent
		imagealphablending($cropped_tmp, false);
  		imagesavealpha($cropped_tmp,true);
  		$transparent = imagecolorallocatealpha($cropped_tmp, 0, 0, 0, 0);
  		imagefilledrectangle($cropped_tmp, 0, 0, $new_width, $new_height, $transparent);
			
		if($file_ext == "png"){
            $source = imagecreatefrompng($img_source);
        }elseif($file_ext == "jpg" || $file_ext == "jpeg"){
            $source = imagecreatefromjpeg($img_source);
        }elseif($file_ext == "gif"){
            $source = imagecreatefromgif($img_source);
        } 

        if(!$source){
        	Errors::setError("Not create a new image from file or URL when cropped");
        	return false;
        }
        if(!imagecopyresampled($cropped_tmp,$source,0,0,0,0,$new_width,$new_height, $old_width,$old_height))
        {
        	Errors::setErrors("Not copy and resize part of an image with resampling when cropped");
        	return false;
        }
					
        if($file_ext == "png"){
           	$result  =  imagepng($cropped_tmp,$img_destination,0); 
        }elseif($file_ext == "jpg" || $file_ext == "jpeg"){
            $result  =  imagejpeg($cropped_tmp,$img_destination,90);
        }elseif($file_ext == "gif"){
            $result  =  imagegif($cropped_tmp,$img_destination,0);
        } 
        if( !$result)
        {
        	Errors::setError("Not output a image to either the browser or a file when cropped" );
        	return false;
        }
		
		imagedestroy($cropped_tmp);
		imagedestroy($source);
		
	 	chmod($img_destination, 0777); 
	 	return true;
	}
	/*
	 * from HOST to Host.
	 * Resize and insert white background
	 * Not use in case upload
	 * img_destination: path . name destination
	 * $img_source: path . name source
	 */
	
	function resize_image($img_source, $img_destination,$crop_width = 1, $crop_height = 1)
	{
		if (!file_exists($img_source)) {
			Errors::setError("File $img_source not exist");
			return false;
		}
		list($old_width,$old_height) = getimagesize($img_source);
		if(!$crop_width && !$crop_height){
			$crop_width = $old_width;
			$crop_height = $old_height;
		} else if(!$crop_width){
			$crop_width = 	$crop_height * $old_width / $old_height;
		} else if(!$crop_height){
			$crop_height = 	$crop_width *  $old_height/$old_width;
		}
		if(($crop_width/$crop_height)>($old_width/$old_height))
		{
			$real_height = $crop_height;
			$real_width = $real_height*$old_width/$old_height;
		}
		else
		{
			$real_width = $crop_width;
			$real_height = (($real_width*$old_height)/$old_width);			
		}
		
		// copy to resize. Image inner frame
//		$newpic = imagecreatetruecolor(round($real_width), round($real_height));
//    	imagecopyresampled($newpic, $source, 0, 0, 0, 0, $real_width, $real_height, $src_w, $src_h);
		
		$file_ext = $this -> getExt($img_source);
		
		// new
		$newpic = imagecreatetruecolor(round($real_width), round($real_height))
//		$cropped_tmp = @imagecreatetruecolor($real_width,$real_height)
			or die("Cannot Initialize new GD image stream when cropped");
			
		//		Add back-ground: white
		imagealphablending($newpic, false);
  		imagesavealpha($newpic,true);
  		$transparent = imagecolorallocatealpha($newpic, 0, 0, 0, 0);
  		imagefilledrectangle($newpic, 0, 0, $real_width, $real_height, $transparent);
  		
			
		if($file_ext == "png"){
            $source = imagecreatefrompng($img_source);
        }elseif($file_ext == "jpg" || $file_ext == "jpeg"){
            $source = imagecreatefromjpeg($img_source);
        }elseif($file_ext == "gif"){
            $source = imagecreatefromgif($img_source);
        } 
        if(!$source)
        {
        	Errors::setError("Not create a new image from file or URL when cropped");
        	return false;
        }
//        if(!imagecopyresampled($cropped_tmp,$source,0,0,0,0,$real_width,$real_height, $old_width,$old_height))
        if(!imagecopyresampled($newpic, $source, 0, 0, 0, 0, $real_width, $real_height, $old_width, $old_height))
        {
        	Errors::setErrors("Not copy and resize part of an image with resampling when cropped");
        	return false;
        }
        
        // create frame 
        $final = imagecreatetruecolor($crop_width, $crop_height);
    	$backgroundColor = imagecolorallocate($final, 255, 255, 255);
    	imagefill($final, 0, 0, $backgroundColor);
        
    	imagecopy($final, $newpic, (abs($crop_width - $real_width)/ 2), (abs($crop_height - $real_height) / 2), 0, 0, $real_width, $real_height);
    	
					
        if($file_ext == "png"){
           	$result  =  imagepng($final,$img_destination,0); 
//           	$result  =  imagepng($cropped_tmp,$img_destination,0); 
        }elseif($file_ext == "jpg" || $file_ext == "jpeg"){
            $result  =  imagejpeg($final,$img_destination,90);
//            $result  =  imagejpeg($cropped_tmp,$img_destination,90);
        }elseif($file_ext == "gif"){
            $result  =  imagegif($final,$img_destination,0);
//            $result  =  imagegif($cropped_tmp,$img_destination,0);
        } 
        if( !$result)
        {
        	Errors::setError("Not output a image to either the browser or a file when cropped" );
        	return false;
        }
		
		imagedestroy($newpic);
		imagedestroy($source);
		
	 	chmod($img_destination, 0777); 
	 	return true;
	}
	
	/*
	 * from HOST to Host.
	 * Resized and cut image
	 * Not have background
	 * Not use in case upload
	 * img_destination: path . name destination
	 * $img_source: path . name source
	 */
	function cut_image($img_source, $img_destination,$crop_width = 1, $crop_height = 1)
	{
		if (!file_exists($img_source)) {
			Errors::setError("File $img_source not exist");
			return false;
		}
		list($old_width,$old_height) = getimagesize($img_source);
		
		if(($crop_width/$crop_height)>($old_width/$old_height))
		{
			$real_width = $crop_width;
			$real_height = (($real_width*$old_height)/$old_width);	
			$x_crop = 0;
			$y_crop = 0;
		}
		else
		{
			$real_height = $crop_height;
			$real_width = $real_height*$old_width/$old_height;
			$x_crop = ((abs($real_width - $crop_width))/2)*$old_height/$crop_height;
			$x_crop = round($x_crop);
			$y_crop = 	0;	
		}
		
		$file_ext = $this -> getExt($img_source);
		// new
		$newpic = imagecreatetruecolor($crop_width,$crop_height)
			or die("Cannot Initialize new GD image stream when cropped");
					
		if($file_ext == "png"){
            $source = imagecreatefrompng($img_source);
        }elseif($file_ext == "jpg" || $file_ext == "jpeg"){
            $source = imagecreatefromjpeg($img_source);
        }elseif($file_ext == "gif"){
            $source = imagecreatefromgif($img_source);
        } 
        if(!$source)
        {
        	Errors::setError("Not create a new image from file or URL when cropped from".$img_source);
        	return false;
        }
        if(!imagecopyresampled($newpic, $source,0,0, $x_crop, $y_crop, $real_width, $real_height, $old_width, $old_height))
        {
        	Errors::setErrors("Not copy and resize part of an image with resampling when cropped");
        	return false;
        }
					
        if($file_ext == "png"){
           	$result  =  imagepng($newpic,$img_destination,0); 
        }elseif($file_ext == "jpg" || $file_ext == "jpeg"){
            $result  =  imagejpeg($newpic,$img_destination,90);
        }elseif($file_ext == "gif"){
            $result  =  imagegif($newpic,$img_destination,0);
        } 
        if( !$result)
        {
        	echo "Not output a image to either the browser or a file when cropped" ;
        	return false;
        }
		
		imagedestroy($newpic);
		imagedestroy($source);
		
//	 	chmod($img_destination, 0655); 
	 	return true;
	}
	
	function getExt($file)
	{
		return strtolower(substr($file, (strripos($file, '.')+1),strlen($file)));
		
	}
	function getFileName($file,$ext)
	{
		return basename($file,".".$ext);
	}
	
	// remove follow path
	function remove($file,$folder)
	{
		if($folder[strlen($folder)-1]!=DS)
		{
			$folder .= DS;
		}
		if (file_exists($folder.$file)) {
		   // 	yes the file does exist
   			if(!unlink($folder.$file))
   			{
   				Errors::setError("Not remove $folder.$file. You must check permission.");
   			}
		}
		else 
		{
			Errors::setError("Not found file : ".$folder.$file);
		}
		return true;
	}
	// remove follow path
	function remove_file_by_path($path_file)
	{
		if (file_exists($path_file)) {
		   // 	yes the file does exist
   			if(!unlink($path_file))
   			{
   				Errors::setError("Not remove $path_file. You must check permission.");
   			}
		}
		else 
		{
			Errors::setError("Not found file : ".$path_file);
		}
		return true;
	}
	
	function create_folder($path,$chmod = '0777')
	{
		$path = str_replace('/', DS,$path);
		$folder_reduce = str_replace(PATH_BASE,'',$path);
		$arr_folder = explode(DS,$folder_reduce); 
		if(!count($arr_folder))
			return;
		$folder_current = PATH_BASE;

		foreach($arr_folder as $item){
			$folder_current .=  $item;
			if(!is_dir($folder_current))
	    	{
	    		if(!mkdir($folder_current))
	    		{
	    			Errors:: setError("Not create folder: ".$folder_current );
	    			chmod($folder_current, $chmod); 	
	    			return false;
	    		}
	    	}
			$folder_current .=  DS;
		}
    	return true;
	}
	
	/*
	 * Upload in host
	 * @size_max: max of file
	 * input_tag_name: name of tag input
	 */
	function upload_file($input_tag_name, $path ,$size_max= 2000000, $suffix = '')
	{
		if ($_FILES[$input_tag_name]["size"] > $size_max)
	  	{
	  		Errors:: setError('file have too large size');
		  	return false;
	  	}
	  		
	  	if ($_FILES[$input_tag_name]["error"] > 0)
	    {
	    	Errors:: setError("File error");
	    	return false;
	    }
		    	$file_new = $_FILES[$input_tag_name]["name"];
		    	$file_ext = $this -> getExt($_FILES[$input_tag_name]["name"]);
		    	
		    	// if change file when upload
		    	if(trim($suffix) != '')
		    	{
			    	
			    	$file_name = $this -> getFileName($_FILES[$input_tag_name]["name"], $file_ext);
			    	
			    	$file_new = $file_name . $suffix.".".$file_ext;
			    	
		    	} 
		    	// if not change, must check exist
		    	else
		    	{
			    	if (file_exists($path . $_FILES[$input_tag_name]["name"]))
			      	{
		     			Errors:: setError($_FILES[$input_tag_name]["name"] . FSText :: _(" already exists. ") );
		     			return false;
			      	}
		    	}
		    	
		    	if(!is_dir($path))
		    	{
		    		if(!mkdir($path))
		    		{
		    			Errors:: setError("Not create folder ".$path);
		    			return false;
		    		}
		    	}
		    	chmod($path, 0777); 	
		    		ini_set("safe_mode",0);
    		      	if(!move_uploaded_file($_FILES[$input_tag_name]["tmp_name"],$path . $file_new))
			      	{
			      		Errors:: setError("Not upload file when move upload. Check permission write folder");
			      		return false;
			      	}

		      	return $file_new;
	}
	
	/*
	* image and *.swf
	*/
	function uploadBanner($input_tag_name, $path ,$size_max= 2000000, $suffix = '',$crop = 0,$crop_width = 0, $crop_height = 0){
		$file_new = $_FILES[$input_tag_name]["name"];
		$file_ext = $this -> getExt($_FILES[$input_tag_name]["name"]);
		if($file_ext == 'gif' || $file_ext == 'jpg' || $file_ext == 'jpge'|| $file_ext == 'png')
		return $this->uploadImage($input_tag_name, $path ,$size_max, $suffix,$crop ,$crop_width, $crop_height);
		else if($file_ext == 'swf')
		return $this->uploadFile($input_tag_name, $path ,$size_max, $suffix);
		else{
			Errors:: setError('Extension of file is not format. Only user extension: gif,jpg,png,swf');
			return false;
		}
	}
	function uploadExcel($input_tag_name, $path,$size_max= 2000000, $suffix){
		$file_new = $_FILES[$input_tag_name]["name"];
		$file_ext = $this -> getExt($_FILES[$input_tag_name]["name"]);
		if($file_ext == 'xls' || $file_ext == 'xlsx')
			return $this->upload_file($input_tag_name, $path ,$size_max= 2000000, $suffix);
		else{
			Errors:: setError('Extension of file is not format. Only user extension: xls,xlsx');
			return false;
		}
	
	}
	
		function uploadFile($input_tag_name, $path ,$size_max= 2000000, $suffix = ''){

		if ($_FILES[$input_tag_name]["error"] > 0)
		{
			Errors:: setError("File error");
			return false;
		}
		if($_FILES[$input_tag_name]["size"] > $size_max){
			Errors:: setError("File size is too large");
			return false;
		}

		if($path[strlen($path)-1]!="/")
		{
			$path .= "/";
		}
		$file_name = $_FILES[$input_tag_name]["name"];
		$file_ext = $this -> getExt($file_name);

		// if change filename when upload
		if(trim($suffix) != ''){
			$file_name = $this -> getFileName($file_name, $file_ext);
			$file_name = $file_name . $suffix.".".$file_ext;
		}
		// if not change, must check exist
		else
		{
			if (file_exists($path . $file_name))
			{
				Errors:: setError($file_name . Text::_(" already exists. ") );
				return false;
			}
		}

		if(!is_dir($path))
		{
			if(!mkdir($path))
			{
				Errors:: setError("Not create folder <strong>".$path."</strong>");
				return false;
			}
		}
		chmod($path, 0777);
		ini_set("safe_mode",0);
		if(!move_uploaded_file($_FILES[$input_tag_name]["tmp_name"],$path . $file_name))
		{
			Errors:: setError("Not upload file when move upload to $path. Check permission write folder");
			return false;
		}
		return $file_name;
	}
}