<?php
/*
 * Huy write
 */

class FSMemcache{
	var $memc;
	var $key_site;
	function __construct(){
		$this -> key_site = 'msmobile_';
	}
	
	function connect(){
		$this -> memc = new Memcache;
		$connect = @$this -> memc ->pconnect('localhost', 11211) ;
		return $connect;
	}

	function get_version(){
		$this -> connect();
		return $this -> memc -> getVersion();
	}
	
	function get($key){
		$key = $this -> key_site.$key;
		if(!$this -> check_exist_memcache())
			return false;
		if(!$this -> connect())
			return;
		
		return $this -> memc->get($key);
	}
	function delete($key){
		// PEL: mới >=2.0
//		$this -> memc->delete($key);

		// PLE: cũ	
		$this ->set($key,'',0);
	}
	
	function set($key,$value,$time){
		$key = $this -> key_site.$key;
		if(!$this -> check_exist_memcache())
			return false;
		if(!$this -> connect())
			return;
		$this -> memc -> set($key, $value, false, $time) or die ("Failed to save data at the server");
	}
	function add($key,$value,$time){
		$key = $this -> key_site.$key;
		if(!$this -> check_exist_memcache())
			return false;
		if(!$this -> connect())
			return;
		$this -> memc -> add($key, $value, false, $time) or die ("Failed to save data at the server");
	}
	function append($key,$value){
		$key = $this -> key_site.$key;
		if(!$this -> check_exist_memcache())
			return false;
		if(!$this -> connect())
			return;
		$this -> memc -> append($key, $value) or die ("Failed to save data at the server");
	}
	function  flush($time){
		$this -> memc -> $time($time);
	}
	
	function check_exist_memcache(){
		if(class_exists('Memcache'))
	  		return true;
		return false;
	}
}
//
// 
////Can Use 127.0.0.1 instead "localhost"
//$version = $memcache->getVersion();
//echo "Server's version: ".$version."<br/>\n";
//$tmp_object = new stdClass;
//$tmp_object->str_attr = 'test';
//$tmp_object->int_attr = 123;
//$memcache->set('key', $tmp_object, false, 10) or die ("Failed to save data at the server");
//echo "Store data in the cache (data will expire in 10 seconds)<br/>\n";
//$get_result = $memcache->get('key');
//echo "Data from the cache:<br/>\n";
//var_dump($get_result);