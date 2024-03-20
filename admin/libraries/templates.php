<?php
class Templates {
	var $tmpl;
	var $variables;

	function __construct($file = null, $tmpl = null) {
		$this->tmpl = $tmpl;
		// echo '11111111';
	}

	function assign($key, $value) {

		$this->variables [$key] = $value;
	}

	function get_variables($key) {
		return isset ( $this->variables[$key] ) ? $this->variables [$key] : '';
	}
}