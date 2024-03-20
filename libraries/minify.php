<?php
class Minify {
	/**
	 * Concatenate an array of files into a string
	 *
	 * @param $files
	 * @return string
	 */
	function concatenateFiles($files) {
		$buffer = '';
		
		foreach ( $files as $file ) {
			$buffer .= file_get_contents ( __DIR__ . '/' . $file );
		}
		
		return $buffer;
	}
	
	/**
	 * @param $files
	 * @return mixed|string
	 */
	//function minifyCSS($files)
	//{
	//    $buffer = concatenateFiles($files);
	//
	//    $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
	//    $buffer = str_replace(["\r\n","\r","\n","\t",'  ','    ','     '], '', $buffer);
	//    $buffer = preg_replace(['(( )+{)','({( )+)'], '{', $buffer);
	//    $buffer = preg_replace(['(( )+})','(}( )+)','(;( )*})'], '}', $buffer);
	//    $buffer = preg_replace(['(;( )+)','(( )+;)'], ';', $buffer);
	//
	//    return $buffer;
	//}
	static	function minifyContentCSS($contents) {
		
		// Remove comments
		$buffer = preg_replace ( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $contents );
		// Remove space after colons
		$buffer = str_replace ( ': ', ':', $buffer );
		// Remove whitespace
		$buffer = str_replace ( array ("\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', $buffer );
		return $buffer;
	}
	
	/**
	 * @param $files
	 * @return mixed|string
	 */
	function minifyJS($files) {
		$buffer = concatenateFiles ( $files );
		
		$buffer = preg_replace ( "/((?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:\/\/.*))/", "", $buffer );
		//    $buffer = str_replace(["\r\n","\r","\t","\n",'  ','    ','     '], '', $buffer);
		//    $buffer = preg_replace(['(( )+\))','(\)( )+)'], ')', $buffer);
		

		return $buffer;
	}
}