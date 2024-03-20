<?php

define('HOME_PATH', $_SERVER['DOCUMENT_ROOT'] . '/pdf-merger1/');
define('HOME_URL', "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
define('FILES_PATH', HOME_PATH . 'files/');
define('FILES_URL', HOME_URL . 'files/');
define('OUTPUT_PATH', HOME_PATH . 'output/');
define('OUTPUT_URL', HOME_URL . 'output/');



// echo HOME_PATH;

$files = glob(FILES_PATH . '*.pdf');

$output_files = glob(OUTPUT_PATH . '*.pdf');

?>