<?php

require_once 'dompdf/autoload.inc.php';


$html = file_get_contents("front/pdftemplate.php");

// reference the Dompdf namespace
use Dompdf\Dompdf;


// instantiate and use the dompdf class
$dompdf = new Dompdf();



$dompdf->loadHtml($html);

$dompdf->set_option('isRemoteEnabled', TRUE);


// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();
