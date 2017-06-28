<?php

$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}

include '../database/Conexion.php';
include '../model/Desaduanaje.php';

$obj = new Desaduanaje();


if (isset($_POST['accion'])) {

    switch ($_POST['accion']) {

        case 'I':
            
            echo $fecinicio = getFechaEspecial('fecinicio');
            echo $fecfin = getFechaEspecial('fecfin');
            $fecnac = getFechaEspecial('fecnac');
            $fecnum_dam = getFechaEspecial('fecnum_dam');
            $fecpago_dam = getFechaEspecial('fecpago_dam');
            $feclevante = getFechaEspecial('feclevante');
            $fecretadu = getFechaEspecial('fecretadu');            

            $obj->__set('numero_oc', trim(strtoupper($_POST['numero_oc'])));
            $obj->__set('numero_fact', trim(strtoupper($_POST['numero_fact'])));
            $obj->__set('regimen', trim(strtoupper($_POST['regimen'])));
            $obj->__set('fecinicio', trim($fecinicio));
            $obj->__set('fecfin', trim($fecfin));
            $obj->__set('modalidad', trim(strtoupper($_POST['modalidad'])));
            $obj->__set('fecnac', trim($fecnac));
            $obj->__set('numero_dam', trim(strtoupper($_POST['numero_dam'])));
            $obj->__set('fecnum_dam', trim($fecnum_dam));
            $obj->__set('fecpago_dam', trim($fecpago_dam));
            $obj->__set('canal', trim(strtoupper($_POST['canal'])));
            $obj->__set('feclevante', trim($feclevante));
            $obj->__set('fecretadu', trim($fecretadu));
            $obj->__set('p_accion', trim($_POST['accion']));
            $obj->__set('dom_user', trim($_SESSION['usuario']));

            $result = $obj->insert_desaduanaje_diferida();

            if ($result) {
                ?>                                
                <script>
                    alert('EN HORA BUENA :)!! Sus datos se han registrado correctamente.');
                </script>
                <?php

            } else {
                ?>                
                <script>
                    alert('ERROR :(!! No se pudo registrar. Por favor verifique sus datos.');
                </script>
                <?php

            }
            break;
    }
}

function getFechaEspecial($variablepost) {
    $con = new Conexion();
    if (empty($_POST[$variablepost])) {
        return 'NULL';
    } else {
        $trans_fecha = trim($_POST[$variablepost]);
        $fecha = $con->transformDDMMAAtoAAMMDD($trans_fecha);
        return "'" . trim($fecha) . "'";
    }
}
