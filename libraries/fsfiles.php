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

		// echo '<pre>';
		// print_r($_FILES[$input_tag_name]);
		// die;

		if (($_FILES[$input_tag_name]["type"] != "image/gif")
		&& ($_FILES[$input_tag_name]["type"] != "image/png")
		&& ($_FILES[$input_tag_name]["type"] != "image/jpeg")
		&& ($_FILES[$input_tag_name]["type"] != "image/pjpeg")){
			Errors:: setError('Extension of file is not format');
			return false;
		}
		if($_FILES[$input_tag_name]["size"] > $size_max){
			Errors:: setError('Image have too large size. Maximum: '.round($size_max/1014).' Kb' );
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
				// standart name
		    	$file_new = $_FILES[$input_tag_name]["name"]; // co ca duoi
		    	$file_ext = $this -> getExt($file_new);
		    	$file_name = $this -> getFileName($file_new, $file_ext);

    	    	$fsstring = FSFactory::getClass('FSString','','../');
				$file_name = $fsstring -> stringStandart($file_name);
				
		    	// if change file when upload
		    	if(trim($suffix) != ''){
			    	$file_new = $file_name . $suffix.".".$file_ext;
		    	}else{
		    		$file_new = $file_name .".".$file_ext;
		    	}
		    	// check exist
		    	if (file_exists($path . $file_new)){
	     			Errors:: setError($file_new . FSText :: _(" already exists. ") );
	     			return false;
		      	}
		    	
		    	if(!$this -> create_folder($path)){
		    		Errors:: setError("Not create folder ".$path);
	    			return false;
		    	}
		    	chmod($path, 0777); 	
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
	 * Zoom bé ảnh lại cho lọt vào size mới. nhưng ko trèn thêm khoảng trắng, mà tạo ra 1 ảnh thước khác
	 */
	function convert_to_webp($img_source,$file_ext = 'jpg'){
		// echo $file_ext;
		// die;
		// Convert webp
		if($file_ext == "png"){
			$webp_buf = imagecreatefrompng($img_source);
			imagepalettetotruecolor($webp_buf);
			// imagealphablending($webp_buf, true);
			// imagesavealpha($webp_buf, true);
			// imagepalettetotruecolor($webp_buf);

		}elseif($file_ext == "jpg" || $file_ext == "jpeg"){
			$webp_buf = imagecreatefromjpeg($img_source);
		}elseif($file_ext == "gif"){
			$webp_buf = imagecreatefromgif($img_source);
		} 
		if($file_ext != "gif") {
		$webp = imagewebp( $webp_buf, $img_source . ".webp");
		imagedestroy($webp_buf);
		chmod($img_source, 0777); 
		return true;
		}

	}
		function convert_to_webp222($img_source,$file_ext = 'jpg'){
		// Convert webp
		if($file_ext == "png"){
			$webp_buf = imagecreatefrompng($img_source);

		}elseif($file_ext == "jpg" || $file_ext == "jpeg"){
			$webp_buf = imagecreatefromjpeg($img_source);
		}elseif($file_ext == "gif"){
			$webp_buf = imagecreatefromgif($img_source);
		} 
		imagewebp( $webp_buf, $img_source . ".webp");
		imagedestroy($webp_buf);
		chmod($img_destination, 0777); 
		return true;
	}
	
	function compress($img_source, $img_destination,$crop_width = 1, $crop_height = 1)
	{
		if (!file_exists($img_source)) {
			Errors::setError("File $img_source not exist");
			return false;
		}
		
		$file_ext = $this -> getExt($img_source);


		if (extension_loaded('imagick')){
			$imagick = new Imagick(); 
			$imagick->readImage($img_source);
		    // zoom lại trước khi chém
			// $imagick->resizeImage($new_width, $new_height, imagick::FILTER_LANCZOS, 1, true);

			if($file_ext == "png"){
				$imagick->setImageFormat('png');
				$imagick->setImageCompressionQuality(100);

	        }elseif($file_ext == "jpg" || $file_ext == "jpeg"){
	            
	        	$imagick->setImageFormat('jpeg');	

	        	$imagick->setSamplingFactors(array('2x2', '1x1', '1x1'));
				// $imagick->optimizeImageLayers();

				$imagick->setImageCompression (Imagick::COMPRESSION_LOSSLESSJPEG);
				// $imagick->setImageCompression(Imagick::COMPRESSION_JPEG);
				$imagick->setImageCompressionQuality(100);


				
				$imagick->stripImage();
				$profiles = $imagick->getImageProfiles("icc", true);
				if(!empty($profiles)) {
		            $imagick->profileImage('icc', $profiles['icc']);
		        }

		  //       $imagick->setImageResolution(72,72);
				// $imagick->setImageUnits(1);

		        $imagick->setInterlaceScheme(Imagick::INTERLACE_JPEG);
		        $imagick->setColorspace(Imagick::COLORSPACE_SRGB);
	        }elseif($file_ext == "gif"){
	            $imagick->setImageFormat('gif');
	        } 

			$imagick->writeImage($img_destination);
			$imagick->destroy();	

			$this -> convert_to_webp($img_destination,$file_ext);
		
		}else{
			$this -> copy_file($img_source,$img_destination);

			$this -> convert_to_webp($img_destination,$file_ext);			
		}
		
		
	 	chmod($img_destination, 0777); 
	 	return true;
	}
	
	/*
	 * from HOST to Host.
	 * Not use in case upload
	 * img_destination: path . name destination
	 * $img_source: path . name source
	 * Zoom bé ảnh lại cho lọt vào size mới. nhưng ko trèn thêm khoảng trắng, mà tạo ra 1 ảnh thước khác
	 */
	
	function cropImge($img_source, $img_destination,$crop_width = 1, $crop_height = 1)
	{
		if (!file_exists($img_source)) {
			Errors::setError("File $img_source not exist");
			return false;
		}
		// size crop
		if(!$crop_width && !$crop_height){
			Errors::setError("Bạn phải nhập kích cỡ ảnh resize");
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


		if (extension_loaded('imagick')){
			$imagick = new Imagick(); 
			$imagick->readImage($img_source);
		    // zoom lại trước khi chém
			$imagick->resizeImage($new_width, $new_height, imagick::FILTER_LANCZOS, 1, true);

			if($file_ext == "png"){
				$imagick->setImageFormat('png');
				$imagick->setImageCompressionQuality(100);

	        }elseif($file_ext == "jpg" || $file_ext == "jpeg"){
	            
	        	$imagick->setImageFormat('jpeg');	

	        	$imagick->setSamplingFactors(array('2x2', '1x1', '1x1'));
				// $imagick->optimizeImageLayers();

				$imagick->setImageCompression (Imagick::COMPRESSION_LOSSLESSJPEG);
				// $imagick->setImageCompression(Imagick::COMPRESSION_JPEG);
				$imagick->setImageCompressionQuality(100);


				
				$imagick->stripImage();
				$profiles = $imagick->getImageProfiles("icc", true);
				if(!empty($profiles)) {
		            $imagick->profileImage('icc', $profiles['icc']);
		        }

		  //       $imagick->setImageResolution(72,72);
				// $imagick->setImageUnits(1);

		        $imagick->setInterlaceScheme(Imagick::INTERLACE_JPEG);
		        $imagick->setColorspace(Imagick::COLORSPACE_SRGB);
	        }elseif($file_ext == "gif"){
	            $imagick->setImageFormat('gif');
	        } 

			$imagick->writeImage($img_destination);
			$imagick->destroy();

			$this -> convert_to_webp($img_destination,$file_ext);	
		
		}else{
			// new
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

			$this -> convert_to_webp($img_destination,$file_ext);
		}
		
		
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
			Errors::setError("Bạn phải nhập kích cỡ ảnh resize");
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
			Errors::setError("File $img_source not exist");
			return false;
		}
		
		$file_ext = $this -> getExt($img_source);

		if (extension_loaded('imagick')){
			$imagick = new Imagick(); 
			$imagick->readImage($img_source);
			$imagick->scaleImage($new_width, $new_height);
			
			if($file_ext == "png"){
				$imagick->setImageFormat('png');
				$imagick->setImageCompressionQuality(100);

	        }elseif($file_ext == "jpg" || $file_ext == "jpeg"){
	            
	        	$imagick->setImageFormat('jpeg');	

	        	$imagick->setSamplingFactors(array('2x2', '1x1', '1x1'));
				// $imagick->optimizeImageLayers();

				$imagick->setImageCompression (Imagick::COMPRESSION_LOSSLESSJPEG);
				// $imagick->setImageCompression(Imagick::COMPRESSION_JPEG);
				$imagick->setImageCompressionQuality(100);


				
				$imagick->stripImage();
				$profiles = $imagick->getImageProfiles("icc", true);
				if(!empty($profiles)) {
		            $imagick->profileImage('icc', $profiles['icc']);
		        }

		  //       $imagick->setImageResolution(72,72);
				// $imagick->setImageUnits(1);

		        $imagick->setInterlaceScheme(Imagick::INTERLACE_JPEG);
		        $imagick->setColorspace(Imagick::COLORSPACE_SRGB);
	        }elseif($file_ext == "gif"){
	            $imagick->setImageFormat('gif');
	        } 
			


			$imagick->writeImage($img_destination);
			$imagick->destroy();
		}else{
			$cropped_tmp = @imagecreatetruecolor($new_width,$new_height)
			or die("Cannot Initialize new GD image stream when cropped");
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
		}	

		
		
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
	function resize_image($img_source, $img_destination,$crop_width = 1, $crop_height = 1){
		
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
		
		$file_ext = $this -> getExt($img_source);
		
		if (extension_loaded('imagick')){
			$imagick = new Imagick(); 
			$imagick->readImage($img_source);
			if($file_ext == 'png'){
				$imagick->setImageBackgroundColor(new \ImagickPixel('transparent'));	
			}else{
				$imagick->setImageBackgroundColor('#FFF');	
			}
			
			$imagick->thumbnailImage($crop_width, $crop_height, true, true);
				    
			if($file_ext == "png"){
				$imagick->setImageFormat('png');
				$imagick->setImageCompressionQuality(100);

	        }elseif($file_ext == "jpg" || $file_ext == "jpeg"){
	            
	        	$imagick->setImageFormat('jpeg');	

	        	$imagick->setSamplingFactors(array('2x2', '1x1', '1x1'));
				// $imagick->optimizeImageLayers();

				$imagick->setImageCompression (Imagick::COMPRESSION_LOSSLESSJPEG);
				// $imagick->setImageCompression(Imagick::COMPRESSION_JPEG);
				$imagick->setImageCompressionQuality(100);


				
				$imagick->stripImage();
				$profiles = $imagick->getImageProfiles("icc", true);
				if(!empty($profiles)) {
		            $imagick->profileImage('icc', $profiles['icc']);
		        }

		  //       $imagick->setImageResolution(72,72);
				// $imagick->setImageUnits(1);

		        $imagick->setInterlaceScheme(Imagick::INTERLACE_JPEG);
		        $imagick->setColorspace(Imagick::COLORSPACE_SRGB);
	        }elseif($file_ext == "gif"){
	            $imagick->setImageFormat('gif');
	        } 

			// $imagick->setImagePage($crop_width, $crop_width, 0, 0);
			$imagick->writeImage($img_destination);
			$imagick->destroy();	
		}else{
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
	        	Errors::setError("Not output a image to either the browser or a file when cropped" );
	        	return false;
	        }
			
			imagedestroy($newpic);
			imagedestroy($source);
		}	
				
	 	chmod($img_destination, 0777); 
	 	return true;
	}

	function upload_video($input_tag_name, $path, $size_max = 300000000, $suffix) {
		$file_new = $_FILES [$input_tag_name] ["name"];


		$file_ext = $this->getExt ( $_FILES [$input_tag_name] ["name"] );
		if ($file_ext == 'mp4' || $file_ext == 'flv' || $file_ext == '3gp')
			return $this->upload_file ( $input_tag_name, $path, $size_max, $suffix );
		else {
			Errors::setError ( 'Extension of file is not format. Only user extension: .flv,.mp4,3gp' );
			return false;
		}
	}
	function copy_file($file_source, $file_destination){
		$this -> create_folder(dirname($file_destination));
		// echo $file_source;
		// die;
		if (!file_exists($file_source)) {
			Errors::setError("File $file_source not exist");
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

		if (extension_loaded('imagick')){
			$imagick = new Imagick(); 
			$imagick->readImage($img_source);
			
		    // zoom lại trước khi chém
			$imagick->thumbnailImage($real_width, $real_height, true, true);
			
			// chém ảnh
			$imagick->cropImage($crop_width, $crop_height, (abs($crop_width - $real_width)/ 2), (abs($crop_height - $real_height) / 2));

			if($file_ext == "png"){
				$imagick->setImageFormat('png');
				$imagick->setImageCompressionQuality(100);

	        }elseif($file_ext == "jpg" || $file_ext == "jpeg"){
	            
	        	$imagick->setImageFormat('jpeg');	

	        	$imagick->setSamplingFactors(array('2x2', '1x1', '1x1'));
				// $imagick->optimizeImageLayers();

				$imagick->setImageCompression (Imagick::COMPRESSION_LOSSLESSJPEG);
				// $imagick->setImageCompression(Imagick::COMPRESSION_JPEG);
				$imagick->setImageCompressionQuality(100);


				
				$imagick->stripImage();
				$profiles = $imagick->getImageProfiles("icc", true);
				if(!empty($profiles)) {
		            $imagick->profileImage('icc', $profiles['icc']);
		        }

		  //       $imagick->setImageResolution(72,72);
				// $imagick->setImageUnits(1);

		        $imagick->setInterlaceScheme(Imagick::INTERLACE_JPEG);
		        $imagick->setColorspace(Imagick::COLORSPACE_SRGB);
	        }elseif($file_ext == "gif"){
	            $imagick->setImageFormat('gif');
	        } 
	        
			    		
			$imagick->writeImage($img_destination);
			$imagick->destroy();	
		}else{
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
		}

		
		
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
	/*
	 * Sinh ra file chuẩn từ file hoặc gốc
	 */
	function genarate_filename_standard($link_file){
		$file = basename ( $link_file);
		$pos = strripos ( $file, '.' );
		if(!$pos)
			return;
		$file_name = substr($file, 0,($pos + 1 ));
		$file_text = $this -> getExt($file);
		$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
		$file_name =  $fsstring->stringStandart ( $file_name );
		return $file_name.'.'. strtolower($file_text);
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
		// printr($arr_folder);
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


	function upload_file_multiple($input_tag_name, $path ,$size_max= 2000000, $suffix = '')
	{
		$countfiles = count($_FILES[$input_tag_name]['name']);
		$file_name_all = "";
		for($i=0;$i<$countfiles;$i++){
			if ($_FILES[$input_tag_name]["size"][$i] > $size_max)
		  	{
		  		Errors:: setError('file have too large size');
			  	return false;
		  	}
		  		
		  	if ($_FILES[$input_tag_name]["error"][$i] > 0)
		    {
		    	Errors:: setError("File error 1");
		    	return false;
		    }

	    	$file_new = $_FILES[$input_tag_name]["name"][$i];
	    	$file_ext = $this -> getExt($_FILES[$input_tag_name]["name"][$i]);
	    	
			if(trim($suffix) != ''){
		    	$file_name = $this -> getFileName($_FILES[$input_tag_name]["name"][$i], $file_ext);
		    	$file_new = $file_name . $suffix.".".$file_ext;
	    	} 
	    	else
	    	{
		    	if (file_exists($path . $_FILES[$input_tag_name]["name"][$i]))
		      	{
	     			Errors:: setError($_FILES[$input_tag_name]["name"][$i] . FSText :: _(" already exists. ") );
	     			return false;
		      	}
	    	}
			
	    	if(!is_dir($path))
	    	{
	    		if(!$this -> create_folder($path)){
		    		Errors:: setError("Not create folder ".$path);
	    			return false;
		    	}
	    	}

	    	// echo $path;
	    	// die;
	    	chmod($path, 0777); 	
	    	if(!move_uploaded_file($_FILES[$input_tag_name]["tmp_name"][$i],$path . $file_new)){
	      		Errors:: setError("Not upload file when move upload. Check permission write folder");
	      		return false;
	      	}
	      	if($i == (int)$countfiles - 1){
	      		$file_name_all .= $file_new;
	      	}else{
	      		$file_name_all .= $file_new.'t,t';
	      	}
		}
		// echo $file_name_all;
		// die;
		return $file_name_all;
	}
	
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
    			if(trim($suffix) != ''){
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
		    	// echo $path;
		    	// die;
    	if(!is_dir($path))
    	{
    		if(!$this -> create_folder($path)){
	    		Errors:: setError("Not create folder ".$path);
    			return false;
	    	}
//    		if(!mkdir($path))
//    		{
//    			Errors:: setError("Not create folder ".$path);
//    			return false;
//    		}
    	}
    	chmod($path, 0777); 	
//    		ini_set("safe_mode",0);
    	if(!move_uploaded_file($_FILES[$input_tag_name]["tmp_name"],$path . $file_new)){
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
			return $this->upload_file($input_tag_name, $path ,$size_max, $suffix);
		else{
			Errors:: setError('Extension of file is not format. Only user extension: xls,xlsx');
			return false;
		}
	
	}
	/*
	*  *.swf
	*/
	function uploadFlash($input_tag_name, $path ,$size_max= 2000000, $suffix = '',$crop = 0,$crop_width = 0, $crop_height = 0){
		$file_new = $_FILES[$input_tag_name]["name"];
		$file_ext = $this -> getExt($_FILES[$input_tag_name]["name"]);
		if($file_ext == 'swf')
			return $this->upload_file($input_tag_name, $path ,$size_max, $suffix);
		else{
			Errors:: setError('Extension of file is not format. Only user extension: swf');
			return false;
		}
	}
	/*
	 * Upload các file doc đuôi: .rar,.zip,.doc,.docx,.pdf
	 */
	function upload_doc($input_tag_name, $path,$size_max= 2000000, $suffix, $ext = 'rar,zip,doc,docx,pdf'){
		$file_new = $_FILES[$input_tag_name]["name"];
		$file_ext = $this -> getExt($_FILES[$input_tag_name]["name"]);
		
//		if($file_ext == 'rar' || $file_ext == 'zip' || $file_ext == 'doc' || $file_ext == 'docx' || $file_ext == 'pdf')
		if(strpos($ext, $file_ext) !== false)
			return $this->upload_file($input_tag_name, $path ,$size_max, $suffix);
		else{
			Errors:: setError('Extension of file is not format. Only user extension: .rar,.zip,.doc,.docx,.pdf');
			return false;
		}
	}

	function upload_ico($input_tag_name, $path,$size_max= 2000000, $suffix, $ext = 'ico'){
		$file_new = $_FILES[$input_tag_name]["name"];
		$file_ext = $this -> getExt($_FILES[$input_tag_name]["name"]);
		
//		if($file_ext == 'rar' || $file_ext == 'zip' || $file_ext == 'doc' || $file_ext == 'docx' || $file_ext == 'pdf')
		if(strpos($ext, $file_ext) !== false)
			return $this->upload_file($input_tag_name, $path ,$size_max, $suffix);
		else{
			Errors:: setError('Extension of file is not format. Only user extension: .ico');
			return false;
		}
	}
	/*
	 * Upload các file doc đuôi: .rar,.zip,.doc,.docx,.pdf
	 */
	function upload_media($input_tag_name, $path,$size_max= 2000000, $suffix){
		$file_new = $_FILES[$input_tag_name]["name"];
		$file_ext = $this -> getExt($_FILES[$input_tag_name]["name"]);
		if($file_ext == 'flv' || $file_ext == 'swf')
			return $this->upload_file($input_tag_name, $path ,$size_max, $suffix);
		else{
			Errors:: setError('Extension of file is not format. Only user extension: .flv,.swf');
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
				Errors:: setError($file_name . FSText::_(" already exists. ") );
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
	
	/*
	 * @ratio: 
	 *           ratio=0: ko làm gì 
	 *           ratio > 0: tỉ lệ: 1/ratio so với ảnh gốc |
	 *           ratio < 0: tỉ lệ max: 1/ratio so với ảnh gốc. (Nếu lớn hơn tỉ lệ này thì zoomlại, bé hơn thì tự nhiên)  
	 */
function add_logo($path,$filename,$filelogo = 'images/logo.png',$vitri=5,$text='', $ratio= 0){
	
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
				$width_logo_old = imagesx($img_logo);
				$height_logo_old = imagesy($img_logo);
				$width_image =  imagesx($image);
				$height_image = imagesy($image);

				if(!$ratio){
					$width_logo_new =  $width_logo_old;
					$height_logo_new =  $height_logo_old;
				}elseif($ratio > 0){
					$height_logo_new =  $height_image/$ratio ; // tính tỉ lệ theo chiều cao
					$width_logo_new =  $height_logo_new * $width_logo_old / $height_logo_old; // giữ tỉ lệ chiều rộng ko bị méo logo
				}else{// nếu chiều cao logo mới nhỏ hơn chiều cao logo cũ thì ta mới chuyển sang kích thước mới 
					$height_logo_new =  $height_image/abs($ratio) ; // tính tỉ lệ theo chiều cao
					echo $height_logo_old;
					if( $height_logo_new  < $height_logo_old){
						$width_logo_new =  $height_logo_new * $width_logo_old / $height_logo_old; // giữ tỉ lệ chiều rộng ko bị méo logo
					}else{
						$width_logo_new =  $width_logo_old;
						$height_logo_new =  $height_logo_old;
					}
				}
				switch($vitri){
					//Bên trái trên ảnh
					case 1:
						$dpy 	= 5;
						$dpx 	= 5;
						$sx 	= imagesx($img_logo);
						$sy 	= imagesy($img_logo);
					break;
					//Giữa trên ảnh
					case 2:
						$dpy 	= 5;
						$dpx 	= imagesx($image)/2-(imagesx($img_logo)/2);
						$sx 	= imagesx($img_logo);
						$sy 	= imagesy($img_logo);
					break;
					//Bên phải trên ảnh
					case 3:
						$dpy 	= 10;
						$dpx 	= imagesx($image)-(imagesx($img_logo)+10);
						$sx 	= imagesx($img_logo);
						$sy 	= imagesy($img_logo);
					break;
					//Bên trái giữa ảnh
					case 4:
						$dpy 	= imagesy($image)/2-(imagesy($img_logo)/2+5);
						$dpx 	= 5;
						$sx 	= imagesx($img_logo);
						$sy 	= imagesy($img_logo);
					break;
					//Bên phải giữa ảnh
					case 6:
						$dpy 	= imagesy($image)/2-(imagesy($img_logo)/2+5);
						$dpx 	= imagesx($image)-(imagesx($img_logo)+5);
						$sx 	= imagesx($img_logo);
						$sy 	= imagesy($img_logo);
					break;
					//Bên trái dưới ảnh
					case 7:
						$dpy 	= imagesy($image)-(imagesy($img_logo)+10);
						$dpx 	= 10;
						$sx 	= imagesx($img_logo);
						$sy 	= imagesy($img_logo);
					break;
					//Giữa dưới ảnh
					case 8:
						$dpy 	= imagesy($image)-(imagesy($img_logo)+5);
						$dpx 	= imagesx($image)/2-(imagesx($img_logo)/2);
						$sx 	= imagesx($img_logo);
						$sy 	= imagesy($img_logo);
					break;
					//Bên phải dưới ảnh
					case 9:
						$dpy 	= imagesy($image)-(imagesy($img_logo));
						$dpx 	= imagesx($image)-(imagesx($img_logo));
						$sx 	= imagesx($img_logo);
						$sy 	= imagesy($img_logo);
					break;
					//CĂN GIỮA
					//
						case 10:
						$dpy 	= imagesy($image)-(imagesy($img_logo)+20);
						$dpx 	= imagesx($image)/2-(imagesx($img_logo)/2);
						$sx 	= imagesx($img_logo);
						$sy 	= imagesy($img_logo);
					break;
					default:
						$dpy 	= imagesy($image)/2-(imagesy($img_logo)/2);
						$dpx 	= imagesx($image)/2-(imagesx($img_logo)/2);
						$sx 	= imagesx($img_logo);
						$sy 	= imagesy($img_logo);
					break;
				}

				if (extension_loaded('imagick')){
					$imagick = new Imagick($path . $filename);
					$mask = new Imagick($filelogo);
					$imagick->compositeImage($mask, Imagick::COMPOSITE_DEFAULT , $dpx, $dpy ,Imagick::CHANNEL_ALL);
					$imagick->writeImage($path . $filename);
					$imagick->destroy();		
				}else{
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
				}
				
				imagedestroy($image);
			}
		}
	}
}