<?php 
/*
	Copyright (c) 2016, AKSAMEDIA - JASA PEMBUATAN WEBSITE
*/

use Dompdf\Dompdf;


class PrintPdf  {
	
	public static function printTransaction(array $config){
		$dompdf = new DOMPDF();		
		$dompdf->load_html($config['html']);
		//$dompdf->set_paper(DEFAULT_PDF_PAPER_SIZE, 'portrait');
		$dompdf->render();
		$dompdf->stream("Label-transaksi.pdf", array("Attachment"=>0));
		exit();
	}

}