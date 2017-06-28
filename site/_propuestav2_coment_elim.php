<?php

/* 
 * Proyecto Humasoft.
 * Desarrollado por Juan Leder
 */

include '../controller/C_Solicitud.php';
$pro = new C_Propuesta();
$codigo = $_GET['codigo'];
$pro->__set('codcomentario', $codigo);
$pro->delete_propdb15ByCodigo();