<?php

$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}
require_once '../database/Conexion.php';
require_once '../model/Viatico.php';
require_once '../model/ViaticoDet.php';
require_once '../model/Empleado.php';
require_once '../model/Ubicacion.php';
require_once '../model/ViaticoIngreso.php';
require_once '../model/Menu.php';

$viatico = new Viatico();
$viadet = new ViaticoDet();

if (isset($_POST['accion'])) {

    switch ($_POST['accion']) {

        case 'RegViatico':

            $periodo_mes = 0;

            $viatico->__set('codpersona', trim(strtoupper($_POST['codpersona'])));
            $viatico->__set('periodo_mes', trim($_POST['periodo_mes']));
            $viatico->__set('periodo_ano', trim($_POST['periodo_ano']));
            $viatico->__set('cargo', trim(strtoupper($_POST['cargo'])));
            $viatico->__set('saldo', trim($_POST['saldo']));
            $viatico->__set('coduse', trim($_SESSION['usuario']));
            $rpta = $viatico->insert_hs_vtcdb01();
            if ($rpta) {
                ?>
                <script>
                    alert('SE REGISTRO CON EXITO');
                </script>                
                <?php

            } else {
                ?>
                <script>
                    alert('NO SE PUDO REGISTRAR');
                </script>                
                <?php

            }
            break;

        case 'ModViatico':

            $periodo_mes = 0;

            $viatico->__set('codviatico', trim($_POST['codviatico']));
            $viatico->__set('codpersona', trim($_POST['codpersona']));
            $viatico->__set('periodo_mes', trim($_POST['periodo_mes']));
            $viatico->__set('periodo_ano', trim($_POST['periodo_ano']));
            $viatico->__set('cargo', trim(strtoupper($_POST['cargo'])));
            $viatico->__set('saldo', trim($_POST['saldo']));
            $viatico->__set('dom_user', trim($_SESSION['usuario']));
            $rpta = $viatico->update_hs_vtcdb01();
            if ($rpta) {
                ?>
                <script>
                    alert('SE MODIFICO CON EXITO');
                </script>                
                <?php

            } else {
                ?>
                <script>
                    alert('NO SE PUDO MODIFICAR');
                </script>                
                <?php

            }
            break;

        case 'RegDetalleViatico':

            //variables ubicacion  
            if (trim($_POST['codzona']) == '0') {
                $codzona = 'NULL';
                $codsubzona = 'NULL';
                $nomzona = '';
                $nomsubzona = '';
            } else {
                $ubcodzona = explode("|", trim($_POST['codzona']));
                $ubnomzona = explode("-", trim($_POST['zona']));
                $codzona = "'" . $ubcodzona[0] . "'";
                $codsubzona = "'" . $ubcodzona[1] . "'";
                $nomzona = $ubnomzona[0];
                $nomsubzona = $ubnomzona[1];
            }

            if (trim($_POST['codlugar']) == '0') {
                $dist = 'NULL';
                $prov = 'NULL';
                $dep = 'NULL';
            } else {
                $lugar = explode("-", trim($_POST['codlugar']));
                $dep = "'" . $lugar[0] . "'";
                $prov = "'" . $lugar[1] . "'";
                $dist = "'" . $lugar[2] . "'";
            }

            $combustible = trim($_POST['combustible']);
            $con = new Conexion();
            $trans_fecha = trim($_POST['fecha']);
            $fecha = $con->transformDDMMAAtoAAMMDD($trans_fecha);
            $coddetalle = $viadet->nextval();

            $viadet->__set('coddetalle', trim($coddetalle));
            $viadet->__set('codviatico', trim($_POST['codviatico']));
            $viadet->__set('codtipo', trim(strtoupper($_POST['codtipo'])));
            $viadet->__set('fecha', trim($fecha));
            $viadet->__set('doctipo', trim(strtoupper($_POST['doctipo'])));
            $viadet->__set('docnum', trim(strtoupper($_POST['docnum'])));
            $viadet->__set('proveedor', trim(strtoupper($_POST['proveedor'])));
            $viadet->__set('concepto', trim(strtoupper($_POST['concepto'])));
            $viadet->__set('valor', trim($_POST['valor']));
            $viadet->__set('igv', trim($_POST['igv']));
            $viadet->__set('valigv', trim($_POST['valigv']));
            $viadet->__set('pventa', trim($_POST['pventa']));
            $viadet->__set('codzona', trim($codzona));
            $viadet->__set('nomzona', trim(strtoupper($nomzona)));
            $viadet->__set('codsubzona', trim($codsubzona));
            $viadet->__set('nomsubzona', trim(strtoupper($nomsubzona)));
            $viadet->__set('dist', trim($dist));
            $viadet->__set('prov', trim($prov));
            $viadet->__set('dep', trim($dep));
            $viadet->__set('dom_user', trim($_SESSION['usuario']));

            $rpta = $viadet->insert_hs_vtcdb02();
            if ($rpta) {

                if ($combustible == 't') {

                    $viadet->__set('coddetalle', trim($coddetalle));
                    $viadet->__set('vehiculo', trim(strtoupper($_POST['vehiculo'])));
                    $viadet->__set('kmcierre', trim($_POST['kmcierre']));
                    $viadet->__set('kmrecorrido', trim($_POST['kmrecorrido']));
                    $viadet->__set('galones', trim($_POST['galones']));
                    $viadet->__set('pgalon', trim($_POST['pgalon']));
                    $viadet->__set('placa', trim(strtoupper($_POST['placa'])));
                    $rptacomb = $viadet->insert_hs_vtcdb03();

                    if ($rptacomb) {
                        
                    } else {
                        
                    }
                }
                ?>
                <script>
                    alert('SE REGISTRO CON EXITO');
                </script>                
                <?php

            } else {
                ?>
                <script>
                    alert('NO SE PUDO REGISTRAR');
                </script>                
                <?php

            }

            break;

        case 'ModDetalleViatico':


            //variables ubicacion
            $ubcodzona = split("|", trim($_POST['codzona']));
            $ubnomzona = split("|", trim($_POST['zona']));
            $lugar = split("-", trim($_POST['codlugar']));
            $combustible = trim($_POST['combustible']);

            $codzona = $ubcodzona[0];
            $codsubzona = $ubcodzona[1];
            $nomzona = $ubnomzona[0];
            $nomsubzona = $ubnomzona[1];
            $dist = $lugar[0];
            $prov = $lugar[1];
            $dep = $lugar[2];

            $viadet->__set('coddetalle', trim($_POST['coddetalle']));
            $viadet->__set('codviatico', trim($_POST['codviatico']));
            $viadet->__set('codtipo', trim(strtoupper($_POST['codtipo'])));
            $viadet->__set('fecha', trim($_POST['fecha']));
            $viadet->__set('doctipo', trim(strtoupper($_POST['doctipo'])));
            $viadet->__set('docnum', trim(strtoupper($_POST['docnum'])));
            $viadet->__set('proveedor', trim(strtoupper($_POST['proveedor'])));
            $viadet->__set('concepto', trim(strtoupper($_POST['concepto'])));
            $viadet->__set('valor', trim($_POST['valor']));
            $viadet->__set('igv', trim($_POST['igv']));
            $viadet->__set('valigv', trim($_POST['valigv']));
            $viadet->__set('pventa', trim($_POST['pventa']));
            $viadet->__set('codzona', trim($codzona));
            $viadet->__set('nomzona', trim(strtoupper($nomzona)));
            $viadet->__set('codsubzona', trim($codsubzona));
            $viadet->__set('nomsubzona', trim(strtoupper($nomsubzona)));
            $viadet->__set('dist', trim($dist));
            $viadet->__set('prov', trim($prov));
            $viadet->__set('dep', trim($dep));
            $viadet->__set('dom_user', trim($_SESSION['usuario']));
            $rpta = $viadet->update_hs_vtcdb02();
            if ($rpta) {

                if ($combustible == true) {

                    $viadet->__set('coddetalle', trim($_POST['coddetalle']));
                    $viadet->__set('vehiculo', trim(strtoupper($_POST['vehiculo'])));
                    $viadet->__set('kmcierre', trim($_POST['kmcierre']));
                    $viadet->__set('kmrecorrido', trim($_POST['kmrecorrido']));
                    $viadet->__set('galones', trim($_POST['galones']));
                    $viadet->__set('pgalon', trim($_POST['pgalon']));
                    $viadet->__set('placa', trim(strtoupper($_POST['placa'])));
                    $rptacomb = $viadet->update_hs_vtcdb03();
                    if ($rptacomb) {
                        
                    } else {
                        
                    }
                }
                ?>
                <script>
                    alert('SE MODIFICO CON EXITO');
                </script>                
                <?php

            } else {
                ?>
                <script>
                    alert('NO SE PUDO MODIFICAR');
                </script>                
                <?php

            }

            break;

        case "RegTipoViatico":

            $viatico->__set('codtab', trim('TV'));
            $viatico->__set('codele', trim(strtoupper($_POST['codele'])));
            $viatico->__set('desele', trim(strtoupper($_POST['desele'])));
            $result = $viatico->insert_altdb01();
            if ($rpta) {
                ?>
                <script>
                    alert('SE REGISTRO CON EXITO');
                </script>                
                <?php

            } else {
                ?>
                <script>
                    alert('NO SE PUDO REGISTRAR');
                </script>                
                <?php

            }
            break;

        case "ModTipoViatico":

            $viatico->__set('codtab', trim('TV'));
            $viatico->__set('codele', trim(strtoupper($_POST['codele'])));
            $viatico->__set('desele', trim(strtoupper($_POST['desele'])));
            $result = $viatico->update_altdb01();
            if ($rpta) {
                ?>
                <script>
                    alert('SE MODIFICO CON EXITO');
                </script>                
                <?php

            } else {
                ?>
                <script>
                    alert('NO SE PUDO MODIFICAR');
                </script>                
                <?php

            }
            break;

        case "RegViaticoIngreso":
            //Consultar si periodo ya existe
            $viating = new ViaticoIngreso();
            $con = new Conexion();
            $viatico->codpersona = trim($_POST['codpersona']);
            $viatico->periodo = trim($_POST['periodo']);
            $viatico->periodo_mes = trim($_POST['periodo_mes']);
            $viatico->periodo_ano = trim($_POST['periodo_ano']);
            $codviatico = 0;

            $msjError = '<div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>';
            $msjSucess = '<div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>';


            $existe = $viatico->listarExistePeriodo();

            if ($existe) {
                //Si existe obtenemos el id
                $codviatico = $existe[0];

                //Registrar el Viatico Ingreso
                $viating->codviatico = $codviatico;
                $fecha = $con->transformDDMMAAtoAAMMDD(trim($_POST['fecingreso']));
                $viating->fecha = $fecha;
                $viating->descripcion = $_POST['descripcion'];
                $viating->valor = $_POST['monto'];
                $viating->dom_user = $_SESSION['usuario'];

                $resultado = $viating->insert_hs_vtcdb04();
                if ($resultado) {
                    //Se debe usar echo para mostrar en el formulario resultado
                    $msjSucess .= '<strong>OK</strong> Se registró con éxito.</div>';
                    echo $msjSucess;
                } else {
                    //Se debe usar echo para mostrar en el formulario resultado
                    $msjError .= '<strong>Error</strong> Hay un error en los datos del formulario Registrar Ingreso. Por favor vuelva a intentarlo.</div>';
                    echo $msjError;
                }
            } else {
                //Si no existe registramos
                $viatico->cargo = trim($_POST['cargo']);
                $viatico->saldo = trim($_POST['saldo']);
                $viatico->dom_user = trim($_SESSION['usuario']);
                $resp = $viatico->insert_hs_vtcdb01();

                if ($resp) {
                    $get_codviatico = $viatico->n_fila($resp);
                    $codviatico = $get_codviatico[0];
                    //Registrar el Viatico Ingreso
                    $viating->codviatico = $codviatico;
                    $viating->fecha = $_POST['fecingreso'];
                    $viating->descripcion = $_POST['descripcion'];
                    $viating->valor = $_POST['monto'];
                    $viating->dom_user = $_SESSION['usuario'];

                    $resultado = $viating->insert_hs_vtcdb04();
                    if ($resultado) {
                        //Se debe usar echo para mostrar en el formulario resultado
                        $msjSucess .= '<strong>OK</strong> Se registró con éxito el ingreso y el periodo.</div>';
                        echo $msjSucess;
                    } else {
                        //Se debe usar echo para mostrar en el formulario resultado
                        $msjError .= '<strong>Error</strong> Hay un error en los datos del formulario Registrar Ingreso. Por favor vuelva a intentarlo.</div>';
                        echo $msjError;
                    }
                } else {
                    $msjError .= '<strong>Error</strong> Hay un error en los datos del periodo. Por favor vuelva a intentarlo.</div>';
                    echo $msjError;
                }
            }
            break;

        case "RegViaticoEgreso":

            $viatico->codpersona = trim($_POST['codpersona']);
            $viatico->periodo = trim($_POST['periodo']);
            $viatico->periodo_mes = trim($_POST['periodo_mes']);
            $viatico->periodo_ano = trim($_POST['periodo_ano']);
            $codviatico = 0;

            $msjError = '<div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>';
            $msjSucess = '<div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>';

            $existe = $viatico->listarExistePeriodo();
            if ($existe) {
                //Si existe obtenemos el id
                $codviatico = $existe[0];
            } else {
                $viatico->cargo = trim($_POST['cargo']);
                $viatico->saldo = trim($_POST['saldo']);
                $viatico->dom_user = trim($_SESSION['usuario']);
                $resp = $viatico->insert_hs_vtcdb01();
                if ($resp) {
                    $get_codviatico = $viatico->n_fila($resp);
                    $codviatico = $get_codviatico[0];
                } else {
                    $msjError .= '<strong>Error</strong> Hay un error en los datos del Periodo.</div>';
                    echo $msjError;
                    //return false;
                }
            }

            if ($codviatico == 0) {
                $msjError .= '<strong>Error</strong> Ocurrio un error al obtener el Periodo de Viático. Actualice el navegador y vuelva a intentarlo.</div>';
                    echo $msjError;
                
            } else {
                //variables ubicacion  
                if (trim($_POST['codzona']) == '0') {
                    $codzona = 'NULL';
                    $codsubzona = 'NULL';
                    $nomzona = '';
                    $nomsubzona = '';
                } else {
                    $ubcodzona = explode("|", trim($_POST['codzona']));
                    $ubnomzona = explode("-", trim($_POST['zona']));
                    $codzona = "'" . $ubcodzona[0] . "'";
                    $codsubzona = "'" . $ubcodzona[1] . "'";
                    $nomzona = $ubnomzona[0];
                    $nomsubzona = $ubnomzona[1];
                }

                if (trim($_POST['codlugar']) == '0') {
                    $dist = 'NULL';
                    $prov = 'NULL';
                    $dep = 'NULL';
                } else {
                    $lugar = explode("-", trim($_POST['codlugar']));
                    $dep = "'" . $lugar[0] . "'";
                    $prov = "'" . $lugar[1] . "'";
                    $dist = "'" . $lugar[2] . "'";
                }

                $combustible = trim($_POST['combustible']);
                $con = new Conexion();
                $trans_fecha = trim($_POST['fecha']);
                $fecha = $con->transformDDMMAAtoAAMMDD($trans_fecha);
                $coddetalle = $viadet->nextval();

                $viadet->__set('coddetalle', trim($coddetalle));
                $viadet->__set('codviatico', trim($codviatico));
                $viadet->__set('codtipo', trim(strtoupper($_POST['codtipo'])));
                $viadet->__set('fecha', trim($fecha));
                $viadet->__set('doctipo', trim(strtoupper($_POST['doctipo'])));
                $viadet->__set('docnum', trim(strtoupper($_POST['docnum'])));
                $viadet->__set('proveedor', trim(strtoupper($_POST['proveedor'])));
                $viadet->__set('concepto', trim(strtoupper($_POST['concepto'])));
                $viadet->__set('valor', trim($_POST['valor']));
                $viadet->__set('igv', trim($_POST['igv']));
                $viadet->__set('valigv', trim($_POST['valigv']));
                $viadet->__set('pventa', trim($_POST['pventa']));
                $viadet->__set('codzona', trim($codzona));
                $viadet->__set('nomzona', trim(strtoupper($nomzona)));
                $viadet->__set('codsubzona', trim($codsubzona));
                $viadet->__set('nomsubzona', trim(strtoupper($nomsubzona)));
                $viadet->__set('dist', trim($dist));
                $viadet->__set('prov', trim($prov));
                $viadet->__set('dep', trim($dep));
                $viadet->__set('dom_user', trim($_SESSION['usuario']));

                $rpta = $viadet->insert_hs_vtcdb02();
                if ($rpta) {

                    if ($combustible == 't') {

                        $viadet->__set('coddetalle', trim($coddetalle));
                        $viadet->__set('vehiculo', trim(strtoupper($_POST['vehiculo'])));
                        $viadet->__set('kmcierre', trim($_POST['kmcierre']));
                        $viadet->__set('kmrecorrido', trim($_POST['kmrecorrido']));
                        $viadet->__set('galones', trim($_POST['galones']));
                        $viadet->__set('pgalon', trim($_POST['pgalon']));
                        $viadet->__set('placa', trim(strtoupper($_POST['placa'])));
                        $rptacomb = $viadet->insert_hs_vtcdb03();

                        if ($rptacomb) {
                            $msjSucess .= '<strong>OK</strong> Todo se registro con éxito.</div>';
                            echo $msjSucess;
                        } else {
                            $msjError .= '<strong>Error</strong> No se pudo registrar los datos del combustible.</div>';
                            echo $msjError;
                        }
                    }else{
                        $msjSucess .= '<strong>OK</strong> Se registro satisfactoriamente.</div>';
                            echo $msjSucess;
                    }
                } else {
                    $msjError .= '<strong>Error</strong> No se pudo registrar los datos del Viatico Egreso.</div>';
                    echo $msjError;
                }
            }
            break;

        default : break;
    }
}
