<?php
$codprop = $_GET['codprop'];
$_GET['codprop'] = $codprop;
ob_start();
include(dirname(__FILE__) . '/_propuestav2_genpdf.php');
$content = ob_get_clean();

// convert in PDF
require_once(dirname(__FILE__) . '/html2pdf_v4.03/html2pdf.class.php');
try {
    $nomarchivo = $codprop;
    $html2pdf = new HTML2PDF('P', 'A4', 'es', 'false', 'UTF-8');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));    
    $html2pdf->Output('archivos/repgersemanal/' . $nomarchivo . '.pdf', 't');
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}