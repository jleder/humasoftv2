<?php
include '../controller/C_Propuestas.php';
$ecom = new C_EstadoComercial();

$codestado = $_GET['codestado'];
//$codprop = $_GET['codprop'];

$ecom->__set('codestado', $codestado);
$rpta = $ecom->delete_propdb16();
if ($rpta) {
    ?>
    <script>
        alert('OK :)!! Se ha eliminado correctamente.');        
    </script>
    <?php
} else {
    ?> 
    <script>
        alert('Lo sentimos. No se pudo eliminar.');
    </script>
    <?php
}



/* 
 * Proyecto Humasoft.
 * Desarrollado por Juan Leder
 */

//include '../controller/C_Solicitud.php';
//$pro = new C_Propuesta();
//$codigo = $_GET['codigo'];
//$pro->__set('codcomentario', $codigo);
//$pro->delete_propdb15ByCodigo();