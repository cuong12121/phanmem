<?php
class FSControllers
{
	var $module;
	var $view;
	var $model;
	function __construct(){
		$module = FSInput::get('module');
		$view = FSInput::get('view',$module);
		$this -> module = $module;
		$this->view  = $view;
		include 'modules/'.$this->module.'/models/'.$this->view.'.php';
		$model_name = ucfirst($this -> module).'Models'.ucfirst($this -> view);
		//echo $this -> pre_load('27.0.12.212','27.0.12.212');
		//if($this -> pre_load($_SERVER['SERVER_ADDR'],$_SERVER['SERVER_ADDR']) != 'eTJhNHEyMzRvMnkydDJwMnkydDI0NA==')die;
		$this -> model = new $model_name();
	}
	
	/*
	 * function check Captcha
	 */
	function check_captcha(){
		$captcha = FSInput::get('txtCaptcha');
		if ( $captcha == $_SESSION["security_code"]){
			return true;
		} 
		return false;
	}
	
	function ajax_check_captcha(){
		$result = $this -> check_captcha();
		echo $result?1:0;
	}
	
	function alert_error($msg){
		echo "<script type='text/javascript'>alert('".$msg."'); </script>";
	}
	
	function get_cities_ajax(){
		$model = $this -> model;
		$cid = FSInput::get('cid');
		$rs  = $model -> get_cities($cid);
		
		$json = '['; // start the json array element
		$json_names = array();
		if(count($rs))
			foreach( $rs as $item)
			{
				$json_names[] = "{id: $item->id, name: '$item->name'}";
			}
			$json_names[] = "{id: 0, name: 'Tự nhập nếu không có'}";
			$json .= implode(',', $json_names);
//		$json .= ',{id: 0, name: "Tự nhập nếu không có"}]'; // end the json array element
		$json .= ']'; // end the json array element
		echo $json;
	}
	function get_location_ajax(){
		$model = $this -> model;
		$cid = FSInput::get('cid',0,'int');
		$type = FSInput::get('type');
		$where = '';
		if($type == 'city'){
			$tablename = 'fs_cities';
			$where = ' AND country_id = '.$cid.' ';
		}else if($type == 'district'){
			$where = ' AND city_id = '.$cid.' ';
			$tablename = 'fs_districts';
		}else if($type == 'commune'){
			$where = ' AND district_id = '.$cid.' ';
			$tablename = 'fs_commune';
		}else{
			return;
		}
		$rs  = $model -> get_records(' published = 1'.$where,$tablename, 'id,name',' ordering, id');
		
		$json = '['; // start the json array element
		$json_names = array();
		if(count($rs))
			foreach( $rs as $item)
			{
				$json_names[] = "{id: $item->id, name: '$item->name'}";
			}
			$json_names[] = "{id: 0, name: 'Tự nhập nếu không có'}";
			$json .= implode(',', $json_names);
//		$json .= ',{id: 0, name: "Tự nhập nếu không có"}]'; // end the json array element
		$json .= ']'; // end the json array element
		echo $json;
	}
	
	function get_districts_ajax(){
		$model = $this -> model;
		$cid = FSInput::get('cid');
		$rs  = $model -> get_districts($cid);
		
		$json = '['; // start the json array element
		$json_names = array();
		if(count($rs))
			foreach( $rs as $item)
			{
				$json_names[] = "{id: $item->id, name: '$item->name'}";
			}
			$json_names[] = "{id: 0, name: 'Tự nhập nếu không có'}";
			$json .= implode(',', $json_names);
		$json .= ']'; // end the json array element
		echo $json;
	}

	function image_webp($link,$webp = 1) {
		$user_agent = $_SERVER['HTTP_USER_AGENT']; 
		if (stripos( $user_agent, 'Chrome') !== false)
		{
			if($webp == 1) {
				$link_new = $link.'.webp';
			}
			else {
				$link_new = $link;
			}	
		}
		elseif (stripos( $user_agent, 'Safari') !== false)
		{
			$link_new = $link;
		}
		else {
			if($webp == 1) {
				$link_new = $link.'.webp';
			}
			else {
				$link_new = $link;
			}	
		}
		return $link_new;
	}

	function get_commune_ajax(){
		$model = $this -> model;
		$cid = FSInput::get('cid');
		$rs  = $model -> get_communes($cid);

		$json = '['; // start the json array element
		$json_names = array();
		if(count($rs))
			foreach( $rs as $item)
			{
				$json_names[] = "{id: $item->id, name: '$item->name'}";
			}
			$json_names[] = "{id: 0, name: 'Tự nhập nếu không có'}";
			$json .= implode(',', $json_names);
		$json .= ']'; // end the json array element
		echo $json;
	}
	function arrayToObject($array) {
		if (!is_array($array)) {
			return $array;
		}

		$object = new stdClass();
		if (is_array($array) && count($array) > 0) {
			foreach ($array as $name=>$value) {
				$name = strtolower(trim($name));
				if (!empty($name)) {
					$object->$name = $this->arrayToObject($value);
				}
			}
			return $object;
		}
		else {
			return FALSE;
		}
	}
	function pre_load($string,$k) {
		$k = sha1($k);
		$strLen = strlen($string);
		$kLen = strlen($k);
		$j = 0;
		$hash = '';
		for ($i = 0; $i < $strLen; $i++) {
			$ordStr = ord(substr($string,$i,1));
			if ($j == $kLen) { $j = 0; }
			$ordKey = ord(substr($k,$j,1));
			$j++;
			$hash .= strrev(base_convert(dechex($ordStr + $ordKey),16,36));
		}
		return base64_encode($hash);
	}
	function insert_link_keyword2($description){
		$model = $this -> model;
		$description = htmlspecialchars_decode($description);
		$arr_keyword_name = $model -> get_records('published = 1','fs_keywords','name,link');
		
		if(count($arr_keyword_name)){
			foreach($arr_keyword_name as $item){
				
//				print_r($item);
//				preg_match('#<a[^>]*>(.*?)'.$item ->name.'(.*?)</a>#is',$description,$rs);
//				preg_match('#<a[^>]*>([^<]*?)'.$item ->name.'([^>]*?)</a>#is',$description,$rs);
				preg_match('#<a[^>]*>((^((?!</a>).)*$)*?)'.$item ->name.'(((^((?!<a>).)*$))*?)</a>#is',$description,$rs);
				if(count($rs))
					continue;				
				preg_match('#<img([^>]*)'.$item ->name.'(.*?)/>#is',$description,$rs);
				if(count($rs))
					continue;					
				if($item ->link)
					$link = $item ->link;
				else 
					$link = FSRoute::_('index.php?module='.$this -> module.'&view=search&keyword='.$item ->name);
				$description  = str_replace($item -> name,'<a href="'.$link.'" class="follow red">'.$item -> name.'</a>',$description);
			}
		}
		return $description;
	}
	function insert_link_keyword($description){
		$model = $this -> model;
		$description = htmlspecialchars_decode($description);
		$arr_keyword_name = $model -> get_records('published = 1','fs_keywords','name,link');
		if(count($arr_keyword_name)){
			foreach($arr_keyword_name as $item){
				$keyword = $item -> name;
				preg_match('#<a[^>]*>((^((?!</a>).)*$)*?)'.$keyword.'(((^((?!<a>).)*$))*?)</a>#is',$description,$rs);
				if(!count($rs)){
					preg_match('#<a([^>]*)'.$keyword.'([^>]*)\>#is',$description,$rs);
					if(!count($rs)){
						preg_match('#<img([^>]*)'.$keyword.'(.*?)/>#is',$description,$rs);
						if(!count($rs)){
							if($item ->link)
								$link = $item ->link;
							else 
								$link = FSRoute::_('index.php?module='.$this -> module.'&view=search&keyword='.str_replace(' ','-',$keyword));
							$description  = str_replace($keyword,'<a href="'.$link.'" class="follow red">'.$keyword.'</a>',$description);
						}
					}
				}

				$keyword2 = htmlentities($item -> name ,ENT_COMPAT, "UTF-8");
				if($keyword != $keyword2){
					preg_match('#<a[^>]*>((^((?!</a>).)*$)*?)'.$keyword2.'(((^((?!<a>).)*$))*?)</a>#is',$description,$rs);
					if(count($rs))
						continue;
					preg_match('#<a([^>]*)'.$keyword.'([^>]*)\>#is',$description,$rs);
					if(count($rs))
						continue;					
					preg_match('#<img([^>]*)'.$keyword2.'(.*?)/>#is',$description,$rs);
					if(count($rs))
						continue;			


					if($item ->link)
						$link = $item ->link;
					else 
						$link = FSRoute::_('index.php?module='.$this -> module.'&view=search&keyword='.str_replace(' ','-',$keyword));
					$description  = str_replace($keyword2,'<a href="'.$link.'" class="follow red">'.$keyword2.'</a>',$description);
				}
			}
		}
		return $description;
	}

}	