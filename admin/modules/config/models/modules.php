<?php
class ConfigModelsModules extends FSModels {
	
	function __construct() {
		parent::__construct ();
		$this->table_name = 'fs_config_modules';
	}
	
	function getData() {
		return $this->get_records ( 'published = 1', 'fs_config_modules', '*', 'module  ASC, ordering ASC' );
	}
	/*
		 * 
		 * Save
		 */
	function save($row = array(), $use_mysql_real_escape_string = 1) {
		$row = array ();
		// SEO_TITLE
		$str_seo_title = '1,';
		$arr_field_seo_title = array ();
		for($i = 0; $i < 3; $i ++) {
			if (! $i) {
				$str_seo_title .= FSInput::get ( 'seo_title_field_name_' . $i );
				$arr_field_seo_title [] = FSInput::get ( 'seo_title_field_name_' . $i );
			} else {
				$seo_title_conjugate = FSInput::get ( 'seo_title_conjugate_' . $i, 0, 'int' );
				if ($seo_title_conjugate) {
					$seo_title_field_name = FSInput::get ( 'seo_title_field_name_' . $i );
					if (! in_array ( $seo_title_field_name, $arr_field_seo_title )) {
						$str_seo_title .= '|';
						$str_seo_title .= $seo_title_conjugate . ',';
						$str_seo_title .= FSInput::get ( 'seo_title_field_name_' . $i );
					}
				}
			}
		}
		$row ['fields_seo_title'] = $str_seo_title;
		
		// SEO special
		$row ['value_seo_title'] = FSInput::get('value_seo_title');
		$row ['value_seo_keyword'] = FSInput::get('value_seo_keyword');
		$row ['value_seo_description'] = FSInput::get('value_seo_description');
		
		// SEO_META_KEYWORD
		$str_seo_keyword = '1,';
		$arr_field_seo_keyword = array ();
		for($i = 0; $i < 3; $i ++) {
			if (! $i) {
				$str_seo_keyword .= FSInput::get ( 'seo_keyword_field_name_' . $i );
				$arr_field_seo_keyword [] = FSInput::get ( 'seo_keyword_field_name_' . $i );
			} else {
				$seo_keyword_conjugate = FSInput::get ( 'seo_keyword_conjugate_' . $i, 0, 'int' );
				if ($seo_keyword_conjugate) {
					$seo_keyword_field_name = FSInput::get ( 'seo_keyword_field_name_' . $i );
					if (! in_array ( $seo_keyword_field_name, $arr_field_seo_keyword )) {
						$str_seo_keyword .= '|';
						$str_seo_keyword .= $seo_keyword_conjugate . ',';
						$str_seo_keyword .= FSInput::get ( 'seo_keyword_field_name_' . $i );
					}
				}
			}
		}
		$row ['fields_seo_keyword'] = $str_seo_keyword;
		// SEO_META_KEYWORD
		$str_seo_description = '1,';
		$arr_field_seo_description = array ();
		for($i = 0; $i < 3; $i ++) {
			if (! $i) {
				$str_seo_description .= FSInput::get ( 'seo_description_field_name_' . $i );
				$arr_field_seo_description [] = FSInput::get ( 'seo_description_field_name_' . $i );
			} else {
				$seo_description_conjugate = FSInput::get ( 'seo_description_conjugate_' . $i, 0, 'int' );
				if ($seo_description_conjugate) {
					$seo_description_field_name = FSInput::get ( 'seo_description_field_name_' . $i );
					if (! in_array ( $seo_description_field_name, $arr_field_seo_description )) {
						$str_seo_description .= '|';
						$str_seo_description .= $seo_description_conjugate . ',';
						$str_seo_description .= FSInput::get ( 'seo_description_field_name_' . $i );
					}
				}
			}
		}
		$row ['fields_seo_description'] = $str_seo_description;
		
		// H1
		$row ['fields_seo_h1'] = FSInput::get ( 'fields_seo_h1' );
		
		// H2
		$arr_field_h2 = FSInput::get ( 'fields_seo_h2', array (), 'array' );
		$row ['fields_seo_h2'] = count ( $arr_field_h2 ) ? implode ( '|', $arr_field_h2 ) : '';
		
		// FIELDS_SEO_IMAGE_ALT
		$str_seo_image_alt = '1,';
		$arr_field_seo_image_alt = array ();
		for($i = 0; $i < 3; $i ++) {
			if (! $i) {
				$str_seo_image_alt .= FSInput::get ( 'seo_image_alt_field_name_' . $i );
				$arr_field_seo_image_alt [] = FSInput::get ( 'seo_image_alt_field_name_' . $i );
			} else {
				$seo_image_alt_conjugate = FSInput::get ( 'seo_image_alt_conjugate_' . $i, 0, 'int' );
				if ($seo_image_alt_conjugate) {
					$seo_image_alt_field_name = FSInput::get ( 'seo_image_alt_field_name_' . $i );
					if (! in_array ( $seo_image_alt_field_name, $arr_field_seo_image_alt )) {
						$str_seo_image_alt .= '|';
						$str_seo_image_alt .= $seo_image_alt_conjugate . ',';
						$str_seo_image_alt .= FSInput::get ( 'seo_image_alt_field_name_' . $i );
					}
				}
			}
		}
		$row ['fields_seo_image_alt'] = $str_seo_image_alt;
		
		// cache
//		$row ['cache'] = FSInput::get ( 'cache', 0, 'int' );
		
		$id = FSInput::get ( 'id', 0, 'int' );
		// params
		$params = $this->generate_params ($id);
		$row ['params']  = $params;
		$rs = $this->_update ( $row, 'fs_config_modules', ' id = ' . $id );
		return $rs ? $id : 0;
	}
	
	function generate_params($id) {
		$data = $this->get_record_by_id($id);
			
		// load config of module
		if(file_exists(PATH_BASE.'modules'.DS.$data -> module.DS.'config.php'))
			include_once '../modules/'.$data -> module.'/config.php';
		FSFactory::include_class('parameters');
		$config_name = $data -> module."_".$data -> view;
		if($data -> task)
			$config_name  = '_'.$data -> task;
		
		$str_params = '';
//		$module = FSInput::get ( 'modules' );
		// load config of eblocks
//		if (file_exists ( PATH_BASE . 'blocks' . DS . $module . DS . 'config.php' ))
//			include_once '../blocks/' . $module . '/config.php';
		$config = isset($config_module[$config_name])?$config_module[$config_name]:array()  ;
		$params = isset($config['params'])?$config['params']: null;
		if(!$params)
			return '';
		$i = 0;
		foreach ( $params as $key => $value ) {
			if ($i > 0)
				$str_params .= chr ( 13 );
			if ($value ['type'] == 'text') {
				$str_params .= $key . '=' . FSInput::get ( 'params_' . $key );
			} else if ($value ['type'] == 'select') {
				if (@$value ['attr'] ['multiple'] == 'multiple') {
					$v = FSInput::get ( 'params_' . $key, array (), 'array' );
					$v = $v ? implode ( ',', $v ) : '';
					$str_params .= $key . '=' . $v;
				} else {
					$str_params .= $key . '=' . FSInput::get ( 'params_' . $key );
				}
			} else if ($value ['type'] == 'is_check') {
				$str_params .= $key . '=' . FSInput::get ( 'params_' . $key );
			}
			$i ++;
		}
		return $str_params;
	}
}

?>