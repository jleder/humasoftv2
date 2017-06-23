<?php
$estado_session = session_status();

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}
include '../database/Conexion.php';
include '../model/Cliente.php';
include '../model/Ubicacion.php';
include '../model/Menu.php';

$obj = new C_Cliente();
if (isset($_POST['accion'])) {

    switch ($_POST['accion']) {
        case 'RegCliente':            
            $getubic_cod = trim($_POST['ubicacion']);            
            $ubicacion_cod = explode('-', $getubic_cod);
            $coddepa = trim($ubicacion_cod[0]);
            $codprov = trim($ubicacion_cod[1]);
            $coddist = trim($ubicacion_cod[2]);
            
            $getubic_desc = trim($_POST['ubicacion_desc']);
            $ubicacion_desc = explode('-', $getubic_desc);
            $nomdepa = trim($ubicacion_desc[0]);
            $nomprov = trim($ubicacion_desc[1]);
            $nomdist = trim($ubicacion_desc[2]);
            
            $getzona_cod = trim($_POST['zona']);
            $zona_cod = explode('-', $getzona_cod);
            $codzona = trim($zona_cod[0]);
            $codsubzona = trim($zona_cod[1]);
            

            $obj->__set('codcliente', trim(($_POST['codigo'])));
            $obj->__set('nombre', trim(($_POST['nombre'])));
            $obj->__set('ruc', trim(($_POST['codigo'])));
            $obj->__set('abrev', trim(strtoupper($_POST['abrev'])));
            $obj->__set('web', trim($_POST['web']));
            $obj->__set('telefono', trim($_POST['telefono']));
            $obj->__set('direccion', trim(($_POST['direccion'])));
            $obj->__set('ubdist', trim($coddist));
            $obj->__set('ciudad', trim($nomdist));
            $obj->__set('ubprov', trim($codprov));
            $obj->__set('provincia', trim($nomprov));
            $obj->__set('ubdepa', trim($coddepa));
            $obj->__set('departamento', trim($nomdepa));
            $obj->__set('codzona', trim($codzona));
            $obj->__set('codsubzona', trim($codsubzona));
            $obj->__set('notas', trim(($_POST['notas'])));
            $obj->__set('coduse', trim(($_SESSION['usuario'])));

            $rpta = $obj->insertarCliente();
            if ($rpta) {
                ?>
                <div class="alert alert-success" id="mensaje">Se registro correctamente<br/>         
                    <a href="#" class="" onclick="cargar('#principal', '_cliente.php')">Volver</a></div>
                <?php
            } else {
                ?>
                <div class="alert alert-danger" id="mensaje">No se pudo registrar<br/>
                    <a href="#" onclick="cargar('#principal', '_cliente.php')">Regresar</a></div>
                <?php
            }
            break;

        case 'ActCliente':
            
            $getubic_cod = trim($_POST['ubicacion']);            
            $ubicacion_cod = explode('-', $getubic_cod);
            $coddepa = trim($ubicacion_cod[0]);
            $codprov = trim($ubicacion_cod[1]);
            $coddist = trim($ubicacion_cod[2]);
            
            $getubic_desc = trim($_POST['ubicacion_desc']);
            $ubicacion_desc = explode('-', $getubic_desc);
            $nomdepa = trim($ubicacion_desc[0]);
            $nomprov = trim($ubicacion_desc[1]);
            $nomdist = trim($ubicacion_desc[2]);
            
            $getzona_cod = trim($_POST['zona']);
            $zona_cod = explode('-', $getzona_cod);
            $codzona = trim($zona_cod[0]);
            $codsubzona = trim($zona_cod[1]);

            $codigoactual = trim($_POST['codigoactual']);
            $obj->__set('codcliente', trim(($_POST['codcliente'])));
            $obj->__set('nombre', trim(($_POST['nombre'])));
            $obj->__set('direccion', trim(($_POST['direccion'])));
            $obj->__set('telefono', trim(($_POST['telefono'])));
            $obj->__set('web', trim($_POST['web']));
            $obj->__set('abrev', trim(strtoupper($_POST['abrev'])));
            $obj->__set('ubdist', trim($coddist));
            $obj->__set('ciudad', trim($nomdist));
            $obj->__set('ubprov', trim($codprov));
            $obj->__set('provincia', trim($nomprov));
            $obj->__set('ubdepa', trim($coddepa));
            $obj->__set('departamento', trim($nomdepa));
            $obj->__set('codzona', trim($codzona));
            $obj->__set('codsubzona', trim($codsubzona));
            $obj->__set('validado', trim($_POST['validado']));
            $obj->__set('usemod', trim(($_SESSION['usuario'])));

            $rpta = $obj->modificarCliente($codigoactual);
            if ($rpta) {
                ?>
                <div class="alert alert-success" id="mensaje">Se modifico correctamente</div>
                <?php
            } else {
                ?>
                <div class="alert alert-danger" id="mensaje">No se pudo modificar</div>
                <?php
            }
            break;

        case 'RegFundo':

            $obj->__set('codcliente', trim(($_POST['codcliente'])));
            $obj->__set('nombre', trim(($_POST['nombre'])));
            $obj->__set('direccion', trim(($_POST['direccion'])));
            $obj->__set('ciudad', trim(($_POST['ciudad'])));
            $obj->__set('provincia', trim(($_POST['provincia'])));
            $obj->__set('departamento', trim(($_POST['departamento'])));

            $rpta = $obj->insertarFundo();
            if ($rpta) {
                ?>
                <script> alert('OK, Se registro correctamente.');</script>
                <div class="alert alert-success" id="mensaje">Se registro correctamente<br/>         
                    <!--<a href="#" class="" onclick="cargar('#principal', '_fundo.php')">Volver</a></div>-->
                    <?php
                } else {
                    ?>
                    <script> alert('Error, No se pudo registrar.');</script>
                    <div class="alert alert-danger" id="mensaje">No se pudo registrar</div>
                    <!--<a href="#" onclick="cargar('#principal', '_fundo.php')">Regresar</a></div>-->
                    <?php
                }

                break;

            case 'ActFundo':

                $obj->__set('codfundo', trim(($_POST['codfundo'])));
                $obj->__set('nombre', trim(($_POST['nombre'])));
                $obj->__set('direccion', trim(($_POST['direccion'])));
                $obj->__set('ciudad', trim(($_POST['ciudad'])));
                $obj->__set('provincia', trim(($_POST['provincia'])));
                $obj->__set('departamento', trim(($_POST['departamento'])));
                $obj->__set('usemod', trim($_SESSION['usuario']));


                $rpta = $obj->modificarFundo();
                if ($rpta) {
                    ?>
                    <script> alert('OK, Se actualizo correctamente.');</script>
                    <div class="alert alert-success">Se actulizo correctamente</div>
                    <?php
                } else {
                    ?>
                    <div class="alert alert-danger">No se pudo actualizar. Verifique sus datos.</div>
                    <?php
                }
                break;

            case 'RegContacto':

                $obj->__set('codcliente', trim(($_POST['codcliente'])));
                $obj->__set('codfundo', trim(($_POST['codfundo'])));
                $obj->__set('nombre', trim(($_POST['nombre'])));
                $obj->__set('dni', trim(($_POST['dni'])));
                $obj->__set('cargo', trim(($_POST['cargo'])));
                $obj->__set('telefono', trim(($_POST['telefono'])));
                $obj->__set('anexo', trim(($_POST['anexo'])));
                $obj->__set('celular', trim(($_POST['celular'])));
                $obj->__set('email', trim(($_POST['email'])));
                $obj->__set('coduse', $_SESSION['usuario']);


                if (trim($_POST['fecnac']) == '') {
                    $obj->__set('fecnac', 'NULL');
                } else {
                    $fecnac = "'" . trim($_POST['fecnac']) . "'";
                    $obj->__set('fecnac', $fecnac);
                }

                if (trim($_POST['codfundo']) == '') {
                    $obj->__set('codfundo', 'NULL');
                }

                $rpta = $obj->insertarContacto();
                if ($rpta) {
                    ?>
                    <script> alert('OK, Se registro correctamente.');</script>
                    <div class="alert alert-success" id="mensaje">Se registro correctamente. Actualice la página.</div>
                    <?php
                } else {
                    ?>                                
                    <div class="alert alert-danger" id="mensaje">No se pudo registrar. Actualice la página.</div>
                    <?php
                }
                break;

            case 'ActContacto':

                $obj->__set('codcontacto', trim(($_POST['codcontacto'])));
                $obj->__set('codcliente', trim(($_POST['codcliente'])));
                $obj->__set('codfundo', trim(($_POST['codfundo'])));
                $obj->__set('nombre', trim(($_POST['nombre'])));
                $obj->__set('fecnac', trim(($_POST['fecnac'])));
                $obj->__set('dni', trim(($_POST['dni'])));
                $obj->__set('cargo', trim(($_POST['cargo'])));
                $obj->__set('telefono', trim(($_POST['telefono'])));
                $obj->__set('anexo', trim(($_POST['anexo'])));
                $obj->__set('celular', trim(($_POST['celular'])));
                $obj->__set('email', trim(($_POST['email'])));
                $obj->__set('usemod', trim($_SESSION['usuario']));

                if (trim($_POST['fecnac']) == '') {
                    $obj->__set('fecnac', 'NULL');
                } else {
                    $fecnac = "'" . trim($_POST['fecnac']) . "'";
                    $obj->__set('fecnac', $fecnac);
                }

                if (trim($_POST['codfundo']) == '') {
                    $obj->__set('codfundo', 'NULL');
                }

                $rpta = $obj->modificarConctacto();


                if ($rpta) {
                    ?>
                    <div class="alert alert-success" id="mensaje">Se actualizo correctamente.</div>
                    <?php
                } else {
                    ?>
                    <div class="alert alert-danger" >No se pudo actualizar. Verificar los datos ingresados.</div>
                    <?php
                }
                break;

            case 'RegFCDefault':
                $result = FALSE;
                $nt = array('N', 'P', 'K', 'Ca', 'Mg', 'S', 'B', 'Co', 'Cu', 'Fe', 'Mn', 'Mo', 'Si', 'Zn');
                $fc = array(1.8, 8.5, 6.5, 1.5, 1.3, 1.3, 1.3, 1.3, 1.3, 1.3, 1.3, 1.3, 1.3, 1.3);
                $od = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14');

                for ($i = 0; $i < count($fc); $i++) {
                    $obj->__set('codnut', $nt[$i]);
                    $obj->__set('codcliente', '20478013206');
                    $obj->__set('nombre', 'Agro Micro Biotech S.A.C.');
                    $obj->__set('factor', $fc[$i]);
                    $obj->__set('orden', $od[$i]);
                    $obj->__set('coduse', $_SESSION['usuario']);
                    $rpta = $obj->insertFactorConversion();
                    if ($rpta) {
                        $result = TRUE;
                    } else {
                        $result = FALSE;
                    }
                }

                if ($result) {
                    ?>
                    <div class="alert alert-success" id="mensaje">Se actualizo correctamente.</div>
                    <?php
                } else {
                    ?>
                    <div class="alert alert-danger" >No se pudo actualizar. Verificar los datos ingresados.</div>
                    <?php
                }
                break;

            case 'RegFC':
                $nt = array('N', 'P', 'K', 'Ca', 'Mg', 'S', 'B', 'Co', 'Cu', 'Fe', 'Mn', 'Mo', 'Si', 'Zn');
                $od = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14');

                for ($i = 0; $i < count($nt); $i++) {

                    $factor = $_POST[$nt[$i]];

                    $obj->__set('codnut', $nt[$i]);
                    $obj->__set("codcliente", trim($_POST['codcliente']));
                    $obj->__set('nombre', trim($_POST['nombre']));
                    $obj->__set('factor', $factor);
                    $obj->__set('orden', $od[$i]);
                    $obj->__set('coduse', $_SESSION['usuario']);
                    $rpta = $obj->insertFactorConversion();
                    if ($rpta) {
                        ?>
                        <div class="alert alert-success" id="mensaje">Se actualizo correctamente.</div>
                        <?php
                    } else {
                        ?>
                        <div class="alert alert-danger" >No se pudo actualizar. Verificar los datos ingresados.</div>
                        <?php
                    }
                }
                break;

            case 'ActFC':
                $nt = array('N', 'P', 'K', 'Ca', 'Mg', 'S', 'B', 'Co', 'Cu', 'Fe', 'Mn', 'Mo', 'Si', 'Zn');
                $od = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14');

                for ($i = 0; $i < count($nt); $i++) {

                    $factor = $_POST[$nt[$i]];

                    $obj->__set('codnut', $nt[$i]);
                    $obj->__set("codcliente", trim($_POST['codcliente']));
                    $obj->__set('nombre', trim($_POST['nombre']));
                    $obj->__set('factor', $factor);
                    $obj->__set('orden', $od[$i]);
                    $obj->__set('coduse', $_SESSION['usuario']);
                    $rpta = $obj->updateFactorConversion();
                    if ($rpta) {
                        ?>
                        <div class="alert alert-success" id="mensaje">Se actualizo correctamente.</div>
                        <?php
                    } else {
                        ?>
                        <div class="alert alert-danger" >No se pudo actualizar. Verificar los datos ingresados.</div>
                        <?php
                    }
                }
                break;

            default:
                break;
        }
    }
    ?>