<?php
include 'PDFMerger.php'; 
use PDFMerger\PDFMerger; 
$pdf = new PDFMerger;

$path = $_SERVER['SCRIPT_FILENAME'];
$path = str_replace('merge-example.php','', $path);


$pdf->addPDF('pdf1.pdf', '1')      //  1 is page1 ,'1,2,3'  are pdf pagenumbers that you want to include in merge
	->addPDF('pdf2.pdf', 'all')
	
	//save vào thư mục
	->merge('file',$path.'TEST.pdf');
	
	//tải xuống
	// ->merge('download', 'TEST.pdf');
	
	//REPLACE 'file' WITH 'browser', 'download', 'string', or 'file' for output options
	//You do not need to give a file path for browser, string, or download - just the name.
