<?php 
	ini_set('display_errors','1');
	ini_set('display_startup_errors','1');
	error_reporting (E_ALL);

	if(!defined('DS')) {
	  define('DS', DIRECTORY_SEPARATOR);
	}

	$rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);
	$path = $rootDir.'/pdf_to_img/';
	$path = str_replace('/',DS,$path);


	$im = new Imagick();
	// $im->setImageBackgroundColor(new \ImagickPixel('transparent'));
	$im->setResolution(300,300);
	$im->readimage($path.'123.pdf[0]'); 
	$im->setImageFormat('jpg');    
	
	$im->setImageBackgroundColor('white');
	$im->setImageCompressionQuality(100);
	// $im->scaleImage(800, 800, true);
	$im->stripImage();
	$profiles = $im->getImageProfiles("icc", true);
	if(!empty($profiles)) {
        $im->profileImage('icc', $profiles['icc']);
    }
	$im->setInterlaceScheme(Imagick::INTERLACE_JPEG);
	$im->setColorspace(Imagick::COLORSPACE_SRGB);
	$im->mergeImageLayers(Imagick::LAYERMETHOD_FLATTEN);
	$im->setImageAlphaChannel(Imagick::ALPHACHANNEL_REMOVE);
	$im->writeImage($path.'123.jpg'); 
	$im->clear(); 
	$im->destroy();


	// $image = new Imagick;

	// $image->setResolution(300, 300);

	// $image->setBackgroundColor('white');

	// $image->readImage("123.pdf[0]");

	// $image->setImageFormat('jpg');

	// $image->setImageCompressionQuality(100);
	// // $image->scaleImage(500, 500, true);

	// $image->mergeImageLayers(Imagick::LAYERMETHOD_FLATTEN);

	// $image->setImageAlphaChannel(Imagick::ALPHACHANNEL_REMOVE);
	// $image->writeImage('123.jpg');
	// $image->clear(); 
	// $image->destroy();

	// $imagick = new Imagick();
	// $imagick->readImage('76572.pdf[0]');
	// $imagick = $imagick->flattenImages();
	// $imagick->writeFile('76572.jpg');

// 	$imagick = new Imagick();
// $imagick->readImage('76572.pdf[0]');
// $imagick->writeImage('76572.jpg');
// $cmd = "gswin64 -sDEVICE=pngalpha -sOutputFile=76572.pdf -r144 76572.pdf";

// $cmd = "gs -sDEVICE=pngalpha -o %stdout -r144 76572.pdf | convert -background transparent - 76572.png";
// shell_exec($cmd);
?>