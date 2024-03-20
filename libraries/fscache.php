<?php
/*
 * Huy write
 */
class FSCache{
	private $cacheDir = 'cache';  
//	private $expiryInterval = CACHE_TIME; 
	  
	public function setCacheDir($val) {
		$this->cacheDir = $val; 
	}  
//	public function setExpiryInterval($val) {  
//		$this->expiryInterval = $val; 
//	}  
	
	public function exists($key) {
		
	}
	
	public function put($key, $content,$folder = '',$ext='.cache',$compress = 0)  {

		$time = time(); //Current Time  
		if (! file_exists($this->cacheDir.'/' .$folder.'/'))  
			$this -> create_folder($this->cacheDir.'/' .$folder.'/'); 
		
		$filename_cache = $this->cacheDir . '/' .$folder.'/'. $key .  $ext; //Cache filename  
    if($compress){
        $content = $this -> minify_output($content);
  
    //    FSFactory::include_class('tiny-html-minifier','html_minifier');
    //    $content = TinyMinify::html($content);  
        // FSFactory::include_class('html','html_minifier');
       // $content = TinyMinify::html($content);  
       // $content = Minify_HTML::minify($content);

    }
        if($ext == '.php'){
$content = 
'<?php 
echo 
<<<EOD
<style>
'.$content.'
</style>
EOD;
?>';
    }
		file_put_contents ($filename_cache ,  $content); // save the content  
	}

  function minify_output($buffer){
      $search = array('/\>[^\S ]+/s','/[^\S ]+\</s','/(\s)+/s');
      $replace = array('>','<','\\1');
      if (preg_match("/\<html/i",$buffer) == 1 && preg_match("/\<\/html\>/i",$buffer) == 1) {
          $buffer = preg_replace($search, $replace, $buffer);
      }
      return $buffer;
  }
	
	public function get($key,$folder = '',$cache_time,$ext='.cache')  {
   		$filename_cache = $this->cacheDir . '/' .$folder.'/'. $key .  $ext; //Cache filename  
   		if (file_exists($filename_cache) )  
   		{  
   			if((time() - filemtime($filename_cache)) < $cache_time){
				return file_get_contents ($filename_cache); 
			} 
  		}  
  		return null;  
  	} 
  	
  	/*
  	 * Kiểm tra file đó còn hoạt động được không?
  	 */
	public function check_activated($key,$folder = '',$cache_time,$ext='.cache')  {
   		$filename_cache = $this->cacheDir . DS .$folder.DS. $key . $ext; //Cache filename  
   		if (file_exists($filename_cache) )  
   		{  
   			if((time() - filemtime($filename_cache)) < $cache_time){
				return true; 
			} 
  		}  
  		return null;  
  	} 
	/*
  	 * Kiểm tra file tĩnh đó còn hoạt động được không? ( cho css, js)
  	 */
	public function check_static_activated($key,$folder = '',$ext='.cache')  {
   		$filename_cache = $this->cacheDir . DS .$folder.DS. $key . $ext; //Cache filename  
   		if (file_exists($filename_cache) )  
   		{  
				return true; 
  		}  
  		return null;  
  	} 
  	public function remove($key,$folder = '')  {
   		$filename_cache = PATH_BASE.$this->cacheDir . DS .$folder.DS. $key . '.cache'; //Cache filename  
   		@unlink($filename_cache);
  	}  

  	function create_folder($path){
  		$fsFile = FSFactory::getClass('FsFiles');
  		return $fsFile -> create_folder($path);
  	}
  	/*
  	 * Remove tr�n mobile:
  	 */
  	public function remove_m($key,$folder = '')  {
   		$filename_cache = $this->cacheDir_mobile . DS .$folder.DS. $key . '.cache'; //Cache filename
   		unlink($filename_cache);
  	}  

    
     public function fopen_file($file){
       // $content_css = file_get_contents ( $file , false);
       // return $content_css;
      $path_file = str_replace(URL_ROOT, PATH_BASE , $file);
      $path_file = str_replace('/', DS , $path_file);
      $content_css = file_get_contents ( $path_file , false);
      return $content_css;
      // $open_file = fopen($path_file, "r") or die("Unable to open file!");
      // return fgets($open_file);
      // fclose($open_file);
    }
}
