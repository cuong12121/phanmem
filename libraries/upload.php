<?php
class Upload{
	function __construct(){
	
	}
	/**
	 * Upload images
	 *
	 * @param string $input_tag_name
	 * @param string $path
	 * @param int $size_max
	 * @param string $suffix
	 * @param int $crop
	 * @param int $crop_width
	 * @param int $crop_height
	 * @return string or boolan
	 */
	function uploadImage($input_tag_name, $path ,$size_max= 2000000, $suffix = '',$crop = 0,$crop_width = 0, $crop_height = 0)
	{
		if (($_FILES[$input_tag_name]["type"] != 'image/gif')
			&& ($_FILES[$input_tag_name]["type"] != 'image/png')
			&& ($_FILES[$input_tag_name]["type"] != 'image/jpeg')
			&& ($_FILES[$input_tag_name]["type"] != 'image/pjpeg')
			&& ($_FILES[$input_tag_name]["type"] != 'image/x-png')
			&& ($_FILES[$input_tag_name]["type"] != 'application/octet-stream')
		   ){
			fwrite_stream('error.txt','Extension of file is not format'.json_encode($_FILES),0);
			return false;
		}
		if($_FILES[$input_tag_name]["size"] > $size_max){
			fwrite_stream('error.txt','File have too large size',0);
			return false;
		}

		  	if ($_FILES[$input_tag_name]["error"] > 0)
		    {
		    	fwrite_stream('error.txt','File error',0);
		    	return false;
		    }
		  	else
		    {
				// standart name
		    	$file_new = $_FILES[$input_tag_name]['name']; // co ca duoi
//		    	$file_new = $this->generator($file_new,$path,$suffix);
				$file_ext = $this -> getExt($file_new);
		    	$file_new = $this -> getFileName($file_new, $file_ext);
			// if change file when upload
		    	if(trim($suffix) != ''){
		    		// $file_new = $file_new . $suffix.".".$file_ext;
			    	$file_new = $file_new . $suffix;
		    	}else{
		    		$file_new = $file_new .".".$file_ext;
		    	}
		    	$file_new = $file_new.'.'.$file_ext;

		    	if (!is_dir($path)){
			    	if(!$this -> create_folder($path)){
			    		fwrite_stream('error.txt','Not create folder '.$path,0);
		    			return false;
			    	}else chmod($path, 0777);
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
						fwrite_stream('error.txt','Cannot Initialize new GD image stream',0);
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
			        	fwrite_stream('error.txt','Not create a new image from file or URL',0);
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
			      		fwrite_stream('error.txt','Not upload file when move upload. Check permission write folder',0);
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
	 * Co ảnh
	 */
	function cropImge($img_source, $img_destination,$crop_width = 1, $crop_height = 1)
	{
		if (!file_exists($img_source)) {
			fwrite_stream('error.txt',"File $img_source not exist",0);
			return false;
		}
		// size crop
		if(!$crop_width && !$crop_height){
			fwrite_stream('error.txt','Bạn phải nhập kích cỡ ảnh resize',0);
			return false;
		}
		list($old_width,$old_height) = getimagesize($img_source);
		if(!$crop_width){
			$crop_width  = $old_width * $crop_width/ $old_height ;
		}
		if(!$crop_height){
			$crop_height = $old_height * $crop_width /$old_width  ;
		}

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

		// transparent
		imagealphablending($cropped_tmp, false);
  		imagesavealpha($cropped_tmp,true);
        	$transparent = imagecolorallocatealpha($cropped_tmp, 255, 255, 255, 127);
  		imagefilledrectangle($cropped_tmp, 0, 0, $new_width, $new_height, $transparent);
    	// end transparent

		if($file_ext == "png"){
            $source = imagecreatefrompng($img_source);
        }elseif($file_ext == "jpg" || $file_ext == "jpeg"){
            $source = imagecreatefromjpeg($img_source);
        }elseif($file_ext == "gif"){
            $source = imagecreatefromgif($img_source);
        }
        if(!$source)
        {
        	fwrite_stream('error.txt',"Not create a new image from file or URL when cropped ".__FUNCTION__,0);
        	return false;
        }
        if(!imagecopyresampled($cropped_tmp,$source,0,0,0,0,$new_width,$new_height, $old_width,$old_height))
        {
        	fwrite_stream('error.txt',"Not copy and resize part of an image with resampling when cropped",0);
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
        	fwrite_stream('error.txt',"Not output a image to either the browser or a file when cropped",0);
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
	function resized_not_crop($img_source, $img_destination,$new_width = 1, $new_height = 1){
		if(!$new_width && !$new_height){
			fwrite_stream('error.txt',"Bạn phải nhập kích cỡ ảnh resize",0);
			return false;
		}
		list($old_width,$old_height) = getimagesize($img_source);
		if(!$new_width){
			$new_width  = $old_width * $new_height/ $old_height ;
		}
		if(!$new_height){
			$new_height = $old_height * $new_width /$old_width  ;
		}
		if (!file_exists($img_source)) {
			fwrite_stream('error.txt',"File $img_source not exist".json_encode($_FILES),0);
			return false;
		}

		$file_ext = $this -> getExt($img_source);
		$cropped_tmp = @imagecreatetruecolor($new_width,$new_height)
			or fwrite_stream('error.txt',"Cannot Initialize new GD image stream when cropped".json_encode($_FILES),0);
		 // transparent
		imagealphablending($cropped_tmp, false);
  		imagesavealpha($cropped_tmp,true);
        $transparent = imagecolorallocatealpha($cropped_tmp, 255, 255, 255, 127);//
  		imagefilledrectangle($cropped_tmp, 0, 0, $new_width, $new_height, $transparent);
	    	// end transparent

		if($file_ext == "png"){
            $source = imagecreatefrompng($img_source);
        }elseif($file_ext == "jpg" || $file_ext == "jpeg"){
            $source = imagecreatefromjpeg($img_source);
        }elseif($file_ext == "gif"){
            $source = imagecreatefromgif($img_source);
        }

        if(!$source){
	        	fwrite_stream('error.txt',"Not create a new image from file or URL when cropped ".$img_source.__FUNCTION__,0);
        	return false;
        }
        if(!imagecopyresampled($cropped_tmp,$source,0,0,0,0,$new_width,$new_height, $old_width,$old_height))
        {
        	fwrite_stream('error.txt',"Not copy and resize part of an image with resampling when cropped".json_encode($_FILES),0);
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
        	fwrite_stream('error.txt',"Not output a image to either the browser or a file when cropped".json_encode($_FILES),0);
        	return false;
        }

		imagedestroy($cropped_tmp);
		imagedestroy($source);

	 	chmod($img_destination, 0777);
	 	return true;
	}
	/* Resize lại ảnh, giữ nguyên hình dạng và có trèn thêm khoảng trắng
	 * from HOST to Host.
	 * Resize and insert white background
	 * Not use in case upload
	 * img_destination: path . name destination
	 * $img_source: path . name source
	 */
	function resize_image($img_source, $img_destination,$crop_width = 1, $crop_height = 1)
	{
		if (!file_exists($img_source)) {
			fwrite_stream('error.txt',"File $img_source not exist".json_encode($_FILES),0);
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

		// transparent
		imagealphablending($newpic, false);
  		imagesavealpha($newpic,true);
        $transparent = imagecolorallocatealpha($newpic, 255, 255, 255, 127);//
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
        	fwrite_stream('error.txt',"Not create a new image from file or URL when cropped ".__FUNCTION__.json_encode($_FILES),0);
        	return false;
        }
//        if(!imagecopyresampled($cropped_tmp,$source,0,0,0,0,$real_width,$real_height, $old_width,$old_height))
        if(!imagecopyresampled($newpic, $source, 0, 0, 0, 0, $real_width, $real_height, $old_width, $old_height))
        {
        	fwrite_stream('error.txt',"Not copy and resize part of an image with resampling when cropped".json_encode($_FILES),0);
        	return false;
        }

        // create frame
        $final = imagecreatetruecolor($crop_width, $crop_height);
        // transparent
        imagealphablending($final, false);//
        imagesavealpha($final,true);//
        $transparent = imagecolorallocatealpha($final, 255, 255, 255, 127);//
    	imagefill($final, 0, 0, $transparent);
    	// end transparent

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
        	fwrite_stream('error.txt',"Not output a image to either the browser or a file when cropped".json_encode($_FILES),0);
        	return false;
        }

		imagedestroy($newpic);
		imagedestroy($source);

	 	chmod($img_destination, 0777);
	 	return true;
	}
	function copy_file($file_source, $file_destination)
	{
		if (!file_exists($file_source)) {
			fwrite_stream('error.txt',"File $file_source not exist".json_encode($_FILES),0);
			return false;
		}
		return copy($file_source, $file_destination);
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
			fwrite_stream('error.txt',"File $img_source not exist".json_encode($_FILES),0);
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
			$real_width = $crop_width;
			$real_height = (($real_width*$old_height)/$old_width);
			$x_crop = 0;
			$y_crop = ((abs ( $real_height - $crop_height )) / 2) * $old_height / $real_height;
			$y_crop = round ( $y_crop );
		} else {
			$real_height = $crop_height;
			$real_width = $real_height * $old_width / $old_height;
			$x_crop = ((abs ( $real_width - $crop_width )) / 2) * $old_width / $real_width;
			$x_crop = round ( $x_crop );
			$y_crop = 0;
		}
		
		$file_ext = $this->getExt ( $img_source );
		// new
		$newpic = imagecreatetruecolor ( $crop_width, $crop_height ) or die ( "Cannot Initialize new GD image stream when cropped" );
		// transparent
		imagealphablending ( $newpic, false );
		imagesavealpha ( $newpic, true );
		$transparent = imagecolorallocatealpha ( $newpic, 255, 255, 255, 127 ); //
		imagefilledrectangle ( $newpic, 0, 0, $crop_width, $crop_height, $transparent );
		
		if ($file_ext == "png") {
			$source = imagecreatefrompng ( $img_source );
		} elseif ($file_ext == "jpg" || $file_ext == "jpeg") {
			$source = imagecreatefromjpeg ( $img_source );
		} elseif ($file_ext == "gif") {
			$source = imagecreatefromgif ( $img_source );
		}
		if (! $source) {
			Errors::setError ( "Not create a new image from file or URL when cropped from" . $img_source );
			return false;
		}
		if (! imagecopyresampled ( $newpic, $source, 0, 0, $x_crop, $y_crop, $real_width, $real_height, $old_width, $old_height )) {
			Errors::setErrors ( "Not copy and resize part of an image with resampling when cropped" );
			return false;
		}
		
		if ($file_ext == "png") {
			$result = imagepng ( $newpic, $img_destination, 0 );
		} elseif ($file_ext == "jpg" || $file_ext == "jpeg") {
			$result = imagejpeg ( $newpic, $img_destination, 90 );
		} elseif ($file_ext == "gif") {
			$result = imagegif ( $newpic, $img_destination, 0 );
		}
		if (! $result) {
			echo "Not output a image to either the browser or a file when cropped";
			return false;
		}
		
		imagedestroy ( $newpic );
		imagedestroy ( $source );
		
		return true;
	}
	
	/*
	 * Tạo ra ảnh mới bằng cách cắt đi các vùng nếu cần thiết
	 * Tuy nhiên sẽ cắt ảnh từ trên xuống
	 */
	function cut_image_top($img_source, $img_destination, $crop_width = 1, $crop_height = 1) {
		if (! file_exists ( $img_source )) {
			Errors::setError ( "File $img_source not exist" );
			return false;
		}
		list ( $old_width, $old_height ) = getimagesize ( $img_source );
		
		if (($crop_width / $crop_height) > ($old_width / $old_height)) {
			$real_width = $crop_width;
			$real_height = (($real_width * $old_height) / $old_width);
			$x_crop = 0;
			$y_crop = 0;
		} else {
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
		// transparent
		imagealphablending($newpic, false);
  		imagesavealpha($newpic,true);
       	$transparent = imagecolorallocatealpha($newpic, 255, 255, 255, 127);//
  		imagefilledrectangle($newpic, 0, 0, $crop_width, $crop_height, $transparent);

		if($file_ext == "png"){
            $source = imagecreatefrompng($img_source);
        }elseif($file_ext == "jpg" || $file_ext == "jpeg"){
            $source = imagecreatefromjpeg($img_source);
        }elseif($file_ext == "gif"){
            $source = imagecreatefromgif($img_source);
        }
        if(!$source)
        {
        	fwrite_stream('error.txt',"Not create a new image from file or URL when cropped from $img_source".json_encode($_FILES),0);
        	return false;
        }
        if(!imagecopyresampled($newpic, $source,0,0, $x_crop, $y_crop, $real_width, $real_height, $old_width, $old_height))
        {
        	fwrite_stream('error.txt',"Not copy and resize part of an image with resampling when cropped".json_encode($_FILES),0);
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
        	fwrite_stream('error.txt',"Not output a image to either the browser or a file when cropped".json_encode($_FILES),0);
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
		$file_name =  basename($file,".".$ext);
		return $this -> standarzed_file_name($file_name);
	}
	
	function standarzed_file_name($file_name){
		$fsstring = FSFactory::getClass('FSString','','../');
		return  $fsstring -> stringStandart($file_name);
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
   				fwrite_stream('error.txt',"Not remove $folder.$file. You must check permission.".json_encode($_FILES),0);
   			}
		}
		else
		{
			fwrite_stream('error.txt',"Not found file : ".$folder.$file.json_encode($_FILES),0);
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
   				fwrite_stream('error.txt',"Not remove $path_file. You must check permission.".json_encode($_FILES),0);
   				Errors::setError("Not remove $path_file. You must check permission.");
   			}
		}
		else
		{
			fwrite_stream('error.txt',"Not found file : ".$path_file.json_encode($_FILES),0);
		}
		return true;
	}
	function create_folder($path,$chmod = '0777'){
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
	    			fwrite_stream('error.txt',"Not create folder: ".$folder_current.json_encode($_FILES),0);
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
	function upload_file($input_tag_name, $path ,$size_max= 20000000, $suffix = '')
	{
		if ($_FILES[$input_tag_name]["size"] > $size_max)
	  	{
	  		fwrite_stream('error.txt',"file have too large size".json_encode($_FILES),0);
		  	return false;
	  	}

	  	if ($_FILES[$input_tag_name]["error"] > 0)
	    {
	    	fwrite_stream('error.txt',"File error".json_encode($_FILES),0);
	    	return false;
	    }
    	$file_new = $_FILES[$input_tag_name]["name"];
    	$file_ext = $this -> getExt($_FILES[$input_tag_name]["name"]);

    	// if change file when upload
    	if(trim($suffix) != ''){
	    	$file_name = $this -> getFileName($_FILES[$input_tag_name]["name"], $file_ext);
	    	$file_new = $file_name . $suffix.".".$file_ext;
    	}
    	// if not change, must check exist
    	else
    	{
	    	if (file_exists($path . $_FILES[$input_tag_name]["name"]))
	      	{
	      		fwrite_stream('error.txt',$_FILES[$input_tag_name]["name"] . FSText :: _(" already exists. ").json_encode($_FILES),0);
     			return false;
	      	}
    	}

    	if(!is_dir($path))
    	{
    		if(!$this -> create_folder($path)){
	    		fwrite_stream('error.txt',"Not create folder ".$path.json_encode($_FILES),0);
    			return false;
	    	}
    	}
    	chmod($path, 0777);
    	if(!move_uploaded_file($_FILES[$input_tag_name]["tmp_name"],$path . $file_new)){
      		fwrite_stream('error.txt',"Not upload file when move upload. Check permission write folder".$path.$file_new ,0);
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
			fwrite_stream('error.txt','Extension of file is not format. Only user extension: gif,jpg,png,swf',0);
			return false;
		}
	}
	function uploadExcel($input_tag_name, $path,$size_max= 2000000, $suffix){
		$file_new = $_FILES[$input_tag_name]["name"];
		$file_ext = $this -> getExt($_FILES[$input_tag_name]["name"]);
		if($file_ext == 'xls' || $file_ext == 'xlsx')
			return $this->upload_file($input_tag_name, $path ,$size_max, $suffix);
		else{
			fwrite_stream('error.txt','Extension of file is not format. Only user extension: xls,xlsx',0);
			return false;
		}

	}
	/*
	*  *.swf
	*/
	function uploadFlash($input_tag_name, $path, $size_max = 2000000, $suffix = '', $crop = 0, $crop_width = 0, $crop_height = 0) {
		$file_new = $_FILES [$input_tag_name] ["name"];
		$file_ext = $this->getExt ( $_FILES [$input_tag_name] ["name"] );
		if ($file_ext == 'swf')
			return $this->upload_file ( $input_tag_name, $path, $size_max, $suffix );
		else {
			Errors::setError ( 'Extension of file is not format. Only user extension: swf' );
			return false;
		}
	}
	/*
	 * Upload các file doc đuôi: .rar,.zip,.doc,.docx,.pdf
	 */
	function upload_doc($input_tag_name, $path,$size_max= 2000000, $suffix){
		$file_new = $_FILES[$input_tag_name]["name"];
		$file_ext = $this -> getExt($_FILES[$input_tag_name]["name"]);
		if($file_ext == 'rar' || $file_ext == 'zip' || $file_ext == 'doc' || $file_ext == 'docx' || $file_ext == 'pdf')
			return $this->upload_file($input_tag_name, $path ,$size_max, $suffix);
		else{
			fwrite_stream('error.txt','Extension of file is not format. Only user extension: .rar,.zip,.doc,.docx,.pdf',0);
			return false;
		}
	}
	/*
	 * Upload các file doc đuôi: .rar,.zip,.doc,.docx,.pdf
	 */
	function upload_media($input_tag_name, $path, $size_max = 2000000, $suffix) {
		$file_new = $_FILES [$input_tag_name] ["name"];
		$file_ext = $this->getExt ( $_FILES [$input_tag_name] ["name"] );
		if ($file_ext == 'flv' || $file_ext == 'swf')
			return $this->upload_file ( $input_tag_name, $path, $size_max, $suffix );
		else {
			Errors::setError ( 'Extension of file is not format. Only user extension: .flv,.swf' );
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
			fwrite_stream('error.txt',"File size is too large",0);
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
				fwrite_stream('error.txt',$file_name . FSText::_(" already exists. "),0);
				return false;
			}
		}

		if(!is_dir($path))
		{
			if(!mkdir($path))
			{
				fwrite_stream('error.txt',"Not create folder <strong>".$path."</strong>",0);
				return false;
			}
		}

		ini_set("safe_mode",0);
		if(!move_uploaded_file($_FILES[$input_tag_name]["tmp_name"],$path . $file_name))
		{
			fwrite_stream('error.txt',"Not upload file when move upload to $path. Check permission write folder",0);
			return false;
		}
		return $file_name;
	}

	function generator($file_name,$path,$suffix=''){
		$file_info = pathinfo($path.$file_name); //array(dirname=>'.',basename=>'SafariIco.exe',extension=>'exe',filename=>'SafariIco'); //Require php5
		$name_file = $file_info['filename'].$suffix;
	
		$ext_file = $file_info['extension'];
		$d = 1;
		$file_new = $file_name;
		while (file_exists($path.$file_new)) {
			$file_new = $name_file.'_'.$d.'.'.$ext_file;
			$d++;
		}
		return $file_new;
	}

	function add_logo($path,$filename,$filelogo = 'images/logo.png',$vitri=5,$text=''){
		$insertLogo 	= 0;
		if(file_exists($filelogo)){
			$img_logo 	= imagecreatefrompng($filelogo);

			$sExtension = substr( $filename, ( strrpos($filename, '.') + 1 ) ) ;
			$sExtension = strtolower($sExtension);

			switch ($sExtension){
			case "jpg" :
				$image 			= imagecreatefromjpeg($path . $filename);

				$insertLogo 	= 1;
				break;
			case "png" :
				return '';
				$image 			= imagecreatefrompng($path . $filename);

				$insertLogo 	= 1;
				break;
			case "gif" :
				$image 			= imagecreatefromgif($path . $filename);
				$insertLogo 	= 1;
				break;
			}

			$white = imagecolorallocate($img_logo, 255, 255, 255);
			if($text!=""){
				$sxt 	= imagesx($img_logo)/2-13;
				$syt 	= imagesy($img_logo)/2-7;
				imagestring($img_logo, 10, $sxt, $syt,$text . "%", $white);
			}
			if($insertLogo==1){

				switch($vitri){
					case 1:
						$dpy 	= 5;
						$dpx 	= 5;
						$sx 	= imagesx($img_logo);
						$sy 	= imagesy($img_logo);
					break;
					case 2:
						$dpy 	= 5;
						$dpx 	= imagesx($image)/2-(imagesx($img_logo)/2);
						$sx 	= imagesx($img_logo);
						$sy 	= imagesy($img_logo);
					break;
					case 3:
						$dpy 	= 5;
						$dpx 	= imagesx($image)-(imagesx($img_logo)+5);
						$sx 	= imagesx($img_logo);
						$sy 	= imagesy($img_logo);
					break;
					case 4:
						$dpy 	= imagesy($image)/2-(imagesy($img_logo)/2+5);
						$dpx 	= 5;
						$sx 	= imagesx($img_logo);
						$sy 	= imagesy($img_logo);
					break;
					case 6:
						$dpy 	= imagesy($image)/2-(imagesy($img_logo)/2+5);
						$dpx 	= imagesx($image)-(imagesx($img_logo)+5);
						$sx 	= imagesx($img_logo);
						$sy 	= imagesy($img_logo);
					break;
					case 7:
						$dpy 	= imagesy($image)-(imagesy($img_logo));
						$dpx 	= 0;
						$sx 	= imagesx($img_logo);
						$sy 	= imagesy($img_logo);
					break;
					case 8:
						$dpy 	= imagesy($image)-(imagesy($img_logo)+5);
						$dpx 	= imagesx($image)/2-(imagesx($img_logo)/2);
						$sx 	= imagesx($img_logo);
						$sy 	= imagesy($img_logo);
					break;
					case 9:
						$dpy 	= imagesy($image)-(imagesy($img_logo));
						$dpx 	= imagesx($image)-(imagesx($img_logo));
						$sx 	= imagesx($img_logo);
						$sy 	= imagesy($img_logo);
					break;
					//CĂN GIỮA
					default:
						$dpy 	= imagesy($image)/2-(imagesy($img_logo)/2);
						$dpx 	= imagesx($image)/2-(imagesx($img_logo)/2);
						$sx 	= imagesx($img_logo);
						$sy 	= imagesy($img_logo);
					break;
				}
				@imagecopy($image, $img_logo, $dpx, $dpy, 0, 0, $sx, $sy);
				switch ($sExtension){
				case "jpg" :
					@imagejpeg($image, $path . $filename,100);
					break;
				case "gif" :
					@imagegif($image, $path . $filename,100);
					break;
				case "png" :
					@imagepng($image, $path . $filename,100);
					break;
				}
				imagedestroy($image);
			}
		}
	}
}
?>