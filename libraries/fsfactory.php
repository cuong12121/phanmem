<?php
/*
 * Huy write
 */

class FSFactory
{
	var $className = "";
	
	/*
	 * folder : contain class
	 * prefix : "../" or "". For back-end or font-end use.
	 */
//	function getClass($className,$folder = "",$prefix = '')
//	{
//		
//		$className = strtolower($className);
//		if($folder)
//		{
//			require_once $prefix.'libraries/'.$folder.'/'.$className.'.php';
//		}
//		else
//		{
//			require_once $prefix.'libraries/'.$className.'.php';
//		}
//		$ob = new $className();
//		return $ob;
//	}
	public static function getClass($className,$folder = "",$prefix = '')
	{
		
		$className = strtolower($className);
		if($folder)
		{
			require_once $folder.'/'.$className.'.php';
		}
		else
		{
			require_once $className.'.php';
		}
		$ob = new $className();
		return $ob;
	}
	
	public static function include_class($className,$folder = "",$prefix = '')
	{
		
		$className = strtolower($className);
		if($folder)
		{
			require_once $folder.'/'.$className.'.php';
		}
		else
		{
			require_once $className.'.php';
		}
	}
	
	
}