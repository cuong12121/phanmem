<?php
	$source_pdf="lazada.pdf";
	$output_folder="MyFolder";

    if (!file_exists($output_folder)) { mkdir($output_folder, 0777, true);}
	$a= passthru("pdftohtml $source_pdf $output_folder/lazada",$b);
	var_dump($a);
?>