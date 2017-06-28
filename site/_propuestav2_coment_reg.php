<?php
//
session_start();
include '../controller/C_Propuestas.php';
$pro = new C_Propuesta;

$coduse = $_SESSION["usuario"];
$desuse = $_SESSION["nombreUsuario"];
$objeto = $_GET['objeto'];
$codprop = $objeto['codprop'];
$coditem = $objeto['coditem'];
$comentario = $objeto['comentario'];


$pro->__set('codprop', trim($codprop));
$pro->__set('coditem', trim($coditem));
$pro->__set('comentario', trim($comentario));
$pro->__set('desuse', trim($desuse));
$pro->__set('domuser', trim($coduse));

$result = $pro->insert_propdb15();
if ($result) {
   return 'Suceso';

} else {
   return 'Error';

}