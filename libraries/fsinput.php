<?php
 
class  FSInput
{
	function __contruct()
	{
	}
	
	
	public static function  get( $varname , $default = null, $type = ''  , $method = '')
	{
		global $HTTP_POST_VARS, $HTTP_GET_VARS, $HTTP_COOKIE_VARS, $_REQUEST;
		
		$value	=	$default;
		
		if ( isset( $_POST[ $varname ] ) )
		{
			$value	= 	$_POST[ $varname ];
		}
		else if ( isset($_GET[ $varname ]) )
		{
			$value 	= 	$_GET[ $varname ];
		}
		else if( isset($_REQUEST[ $varname ] ) )
		{
			$value	=	$_REQUEST[ $varname ];
		}
		else if( isset($_FILES[ $varname ] ) )
		{
			$value	=	$_FILES[ $varname ];
		}
		if(!isset($value) && !isset($default))
			return; 
			
		if(!isset($value) && isset($default))
		{
			$value = $default;
		}
//		if(empty($value)){
//			if(isset($default)){
//				$value = $default;	
//			}
//		}

		// $value = preg_replace('/[^a-zA-Z0-9\-\_\!\$\#\@\^\&\*\(\)\^\+\ \.\?]/',"", $value);
		// $value = preg_replace("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/","",$value);
		// $value = preg_replace("/(FROM|SELECT|INSERT|DELETE|WHERE|DROP TABLE|SHOW TABLES|#|\*|--|\\\\)/","",$value);
		  $value = str_ireplace( 
                            array ( 
                                    '*', 
                                    'SELECT ', 
                                    'UPDATE ', 
                                    'DELETE ', 
                                    'INSERT ', 
                                    'INTO ', 
                                    'VALUES ', 
                                    'FROM ', 
                                    'LEFT ', 
                                    'UNION '
                                  ), 
                            array ( 
                                    "", 
                                    "", 
                                    "", 
                                    "", 
                                    "", 
                                    "", 
                                    "", 
                                    "", 
                                    "", 
                                    ""
                                  ), 
                          $value
                          ); 

		switch ( $type )
		{			
			case 'txt':
				$value = FSInput::def( trim($value ));
				break;
			case 'int':
				$value = FSInput::cint($value );
				break;
			case 'sql':
				$value = FSInput::csql( trim($value ));
				break;
			case 'money':
				$value = FSInput::money( trim($value ));
				break;
			case 'array':
				$value = FSInput::carray( $value );
				break;
			default:
				$value = @FSInput::cstr( trim($value ));
				break;
		}

		
		return $value;
	}
	/*
	 * Lấy giá trị INT từ STRING 
	 */
	public static function get_filter_int( $strval )
	{		
		$strval = FSInput::get($strval);
		return filter_var($strval, FILTER_SANITIZE_NUMBER_INT);
	}
		
	public static function encode( $strval )
	{		
		if(strlen($strval)) {
			$strval = htmlentities($_POST[$strval], ENT_QUOTES);
		}
		return $strval;
	}
	
	public static function decode( $strval )
	{
		if(strlen($strval)) {
			$strval = html_entity_decode($strval, ENT_QUOTES);
		}
		return $strval;
	}
	
	public static function cstr( $strval )
	{
//		if ( get_magic_quotes_gpc() == 0 ) $strval = addslashes($strval);
//		if ( get_magic_quotes_gpc() == 0 ) $strval = stripslashes($strval);
		
//		if(strlen($strval))
//			$strval = htmlspecialchars($strval);
		global $db;
		$strval = $db -> escape_string($strval);
		return $strval;
	}
	
	
	public static function def( $strval )
	{
		if ( @get_magic_quotes_gpc() == 0 ) $strval = addslashes($strval);
		
		$strval = htmlspecialchars($strval);
		
		return $strval;
	}
	
	
	public static function csql( $strval )
	{
		if ( get_magic_quotes_gpc() == 0 ) $strval = addslashes($strval);
		
		return $strval;
	}
	
	
	public static function cint( $intval ){
		if(!isset($intval)){
			return null;
		}
		if(empty($intval)){
			return $intval;
		}
		$intval = (int) $intval;
		
		return $intval;
	}
	public static function carray( $arrayval )
	{
		return (array)$arrayval;
	}

		public static function money( $strval )
	{
		return filter_var($strval, FILTER_SANITIZE_NUMBER_INT);	
	}
	
}
?>