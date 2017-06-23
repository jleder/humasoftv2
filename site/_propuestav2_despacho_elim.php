<?php

include '../controller/C_Propuestas.php';

$desp = new C_Despacho();
$detd = new C_DetalleDespacho();
$coddesp = trim($_GET['cod1']);
$codigo = trim($_GET['cod2']);
$tipo = $_GET['tipo'];

//1 = Eliminar Despacho
//2 = Eliminar estado
$rpta = false;

if ($tipo == 1) {
    $desp->__set('coddesp', $coddesp);
    $detd->__set('coddesp', $coddesp);
    //Eliminar Estados
    $deletedet = $detd->deleteDetDespByCoddesp();
    if ($deletedet) {
        $rpta = $desp->eliminarDespacho();
    }
}
if ($tipo == 2) {
    $detd->__set('codigo', $codigo);
    $rpta = $detd->deleteDetDespByCodigo();
}

if ($rpta) {
    ?>
    <script>
        alert("OK, se elimino con exito");
    </script>
    <?php

} else {
    ?>
    <script>
        alert("ERROR, No se pudo eliminar");
    </script>
    <?php
}
