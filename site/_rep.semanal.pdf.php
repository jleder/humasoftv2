<?php

$tipo = $_GET['tipo'];

date_default_timezone_set("America/Bogota");
$getfecha = getdate();
$dia = $getfecha['mday'];
$mes = $getfecha['mon'];
$ano = $getfecha['year'];
$hoy = $ano . '-' . $mes . '-' . $dia;
//$hoy = '2016-11-05';

if ($tipo == 'v3') {

    ob_start();
    include(dirname(__FILE__) . '/_rep.semanal.2.php');
    $content = ob_get_clean();

// convert in PDF
    require_once(dirname(__FILE__) . './html2pdf_v4.03/html2pdf.class.php');
    try {
        $html2pdf = new HTML2PDF('P', 'A4', 'es', 'false', 'UTF-8');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('archivos/repgersemanal/' . $hoy . '_v2.pdf', 'f');
    } catch (HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
} elseif ($tipo == 'v1') {

} {

    ob_start();
    include(dirname(__FILE__) . '/_rep.semanal.php');
    $content = ob_get_clean();

// convert in PDF
    require_once(dirname(__FILE__) . './html2pdf_v4.03/html2pdf.class.php');
    try {
        $html2pdf = new HTML2PDF('P', 'A4', 'es', 'false', 'UTF-8');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('archivos/repgersemanal/' . $hoy . '.pdf', 'f');
    } catch (HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
}
?>
<script>window.close();</script>