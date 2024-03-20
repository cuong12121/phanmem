<?php
/*
 * Huy write
 */

class FSPdf
{
	function __construct(){
		FSFactory::include_class('errors');
	}
	function html2pdf(){
		$html = "<html><body>xxxx</body></html>";
		require_once("libraries/dompdf/dompdf_config.inc.php");
		$dompdf = new DOMPDF();
		  $dompdf->load_html($_POST["html"]);
		  $dompdf->set_paper($_POST["paper"], $_POST["orientation"]);
		  $dompdf->render();
		
		  $dompdf->stream("dompdf_out.pdf", array("Attachment" => false));
		
		  exit(0);
	}
}