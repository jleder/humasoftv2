<?php

/* 
 * Proyecto Humasoft.
 * Desarrollado por Juan Leder
 */
include '../controller/C_Propuestas.php';
$obj = new C_Propuesta();
$codigo = $_GET['codarchivo'];
$file = $_GET['url'];

$rpta = $obj->deleteFilePropAprob($codigo, $file);

if ($rpta) {
    ?>    
    <script>
        alert('SE ELIMINO CORRECTAMENTE :)!!');
    </script>
    <?php
} else {
    ?> 
    <script>
        alert('ERROR, NO SE PUDO ELIMINAR!!');
    </script>
    <?php
}