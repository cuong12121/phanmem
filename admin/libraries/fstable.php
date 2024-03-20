<?php 
	class FSTable_ad
	{
		function __construct()
		{
		}
		public static function _($table,$multi_lang = 1)
		{
			if(!$multi_lang)
				return $table;
			$lang = isset($_SESSION['ad_lang'])?$_SESSION['ad_lang']:'vi';
			if($lang == 'vi'){
				return $table;
			}else{
				return $table.'_'.'en';
			}
		}
		public static function getTable($table,$multi_lang = 1,$lang = '')
		{
			if(!$multi_lang)
				return $table;
			if(!$lang)
				$lang = isset($_SESSION['ad_lang'])?$_SESSION['ad_lang']:'vi';
			if($lang == 'vi'){
				return $table;
			}else{
				return $table.'_'.'en';
			}
		}
		public static function translate_table($table,$multi_lang = 1,$lang = '')
		{
			if(!$multi_lang)
				return $table;
			if(!$lang)
				$lang = isset($_SESSION['ad_lang'])?$_SESSION['ad_lang']:'vi';
//			$lang = isset($_SESSION['lang'])?$_SESSION['lang']:'vi';
			if($lang == 'vi'){
				return $table.'_'.'en';
			}else{
				return $table;
			}
		}
	}
?>