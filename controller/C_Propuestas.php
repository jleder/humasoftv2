<?php
$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}
include '../database/Conexion.php';
include '../model/Propuesta.php';
include '../model/Producto.php';
include '../model/Cliente.php';
include '../model/EstadoComercial.php';
include '../model/Despacho.php';
include '../model/EstadoDespacho.php';
include '../model/Menu.php';

//$obj = new C_Solicitud();
$pro = new C_Propuesta();
$desp = new C_Despacho();
$ecom = new C_EstadoComercial();
if (isset($_POST['accion'])) {

    switch ($_POST['accion']) {

        case 'RegPropuestaV2':
            //propdb10
            //AVERIGUAR SI YA EXISTE ESE CODIGO DE PROPUESTA
            $codprop = trim($_POST['codprop']);
            $pro->__set('codprop', trim(strtoupper($_POST['codprop'])));
            $existe = $pro->existeCodPropuesta();

            if ($existe) {
                ?>
                <script>
                    alert('ESTE CODIGO YA EXISTE. CAMBIE EL CODIGO DE LA PROPUESTA.');
                    $("#codprop").focus();
                </script>
                <?php
            } else {
                if (isset($_SESSION['item']) && isset($_SESSION['car'])) {
                    $vectoritem = $_SESSION['item'];
                    $vectocar = $_SESSION['car'];
                    $vectorund = $_SESSION['und'];
                    $vectordesp = $_SESSION['cardesp'];

                    $cantitem = count($vectoritem);
                    $cantvcar = count($vectocar);
                    $cantvund = count($vectorund);
                    $cantdesp = count($vectordesp);
                    //Obteniendo Parametros para Tabla Propuesta propdb10
                    $cliente = trim(strtoupper($_POST['codcliente']));
                    $cliente_explode = explode('|', $cliente);
                    $codcliente = $cliente_explode[0];


                    $pro->__set('codcliente', $codcliente);
                    $pro->__set('nomcliente', trim(strtoupper($_POST['nomcliente'])));
                    $pro->__set('asunto', trim($_POST['asunto']));
                    $pro->__set('descripcion', trim($_POST['obs']));
                    $pro->__set('variedad', trim(strtoupper($_POST['variedad'])));
                    $pro->__set('efenologica', trim(strtoupper($_POST['efenologica'])));
                    $pro->__set('domuser', trim($_SESSION['usuario']));
                    $pro->__set('elaboradopor', trim($_SESSION['nombreUsuario']));
                    $pro->__set('demo', trim($_POST['demo']));
                    $pro->__set('condiciones', trim($_POST['condicion2']));
                    $pro->__set('obs_atec', trim($_POST['obs_atec']));
                    $pro->__set('fpago', trim($_POST['fpago']));
                    $pro->__set('numdespacho', trim($_POST['numdespacho']));

                    if ($_POST['vendedor'] == 'Asesor Externo') {
                        $pro->__set('codvendedor', trim($_POST['asesorexterno']));
                        $pro->__set('nomvendedor', trim($_POST['nomasesorexterno']));
                    } else {
                        $pro->__set('codvendedor', trim($_POST['vendedor']));
                        $pro->__set('nomvendedor', trim($_POST['nomvendedor']));
                    }

                    //VALIDAR CONTACTO
                    $pro->__set('contactos', trim($_POST['contacto']));
                    if (trim($_POST['contacto']) === 'otro') {
                        $pro->__set('contactos', trim($_POST['newcontacto']));
                    }

                    //VALIDAR TRATO                    
                    $pro->__set('trato', trim($_POST['trato']));
                    if (trim($_POST['trato']) === 'otro') {
                        $pro->__set('trato', trim($_POST['newtrato']));
                    }

                    //REGISTRAR NUEVO CULTIVO
                    if (trim(strtoupper($_POST['newcultivo'])) <> '') {
                        $pro->__set('cultivo', trim(strtoupper($_POST['newcultivo'])));
                        $pro->registrarCultivo();
                    } elseif ($_POST['cultivo'] <> '0') {
                        $exp_cultivo = explode(',', $_POST['cultivo']);
                        $cultivo = $exp_cultivo[1];
                        $pro->__set('cultivo', $cultivo);
                    }

                    //REGISTRAR NUEVA VARIEDAD
                    if (trim(strtoupper($_POST['newvariedad'])) <> '') {
                        $pro->__set('variedad', trim(strtoupper($_POST['newvariedad'])));
                        $pro->registrarVariedad();
                    }

                    //REGISTRAR NUEVA ETAPA FENOLOGICA
                    if (trim(strtoupper($_POST['newefenologica'])) <> '') {
                        $pro->__set('efenologica', trim(strtoupper($_POST['newefenologica'])));
                        $pro->registrarEfenologica();
                    }

                    //REGISTRA PROPUESTA
                    $result = $pro->insertPropxAprob();
                    if ($result) {

                        $exito = true;
                        for ($i = 0; $i < $cantitem; $i++) {

                            //VARIABLES PARA INSERTAR ITEM
                            $coditem = $pro->generarCodItemProp();
                            if ($coditem) {
                                $pro->__set('coditem', $coditem);
                            } else {
                                $pro->__set('coditem', '1');
                            }

                            $plantilla = $vectoritem[$i][7];
                            $pud = $vectoritem[$i][8];
                            $ha = $vectoritem[$i][5];
                            //$modificado = $vectoritem[$i][11];

                            $pro->__set('descuento', trim($vectoritem[$i][0]));
                            $pro->__set('pcc', trim($vectoritem[$i][1]));
                            $pro->__set('pca', trim($vectoritem[$i][2]));
                            $pro->__set('precioAMBT', $vectoritem[$i][3]);
                            $pro->__set('fa', $vectoritem[$i][4]);
                            $pro->__set('ha', $vectoritem[$i][5]);
                            $pro->__set('nitrogeno', $vectoritem[$i][6]);
                            $pro->__set('plantilla', trim($plantilla));
                            $pro->__set('pud', trim($pud));
                            $pro->__set('estadoitem', trim($vectoritem[$i][9]));
                            $pro->__set('modificado', trim($vectoritem[$i][10]));
                            $pro->__set('incluyeigv', trim($vectoritem[$i][11]));
                            $pro->__set('valigv', trim($vectoritem[$i][12]));
                            $pro->__set('pup', trim($vectoritem[$i][13]));
                            $pro->__set('itemdesc', trim($vectoritem[$i][14]));
                            $pro->__set('verfc', trim($vectoritem[$i][15]));

                            //*** INSERTAR ITEM                            
                            $rptaitem = $pro->insertItem();
                            if ($rptaitem) {

                                //INSERTAR UNIDADES EN LA TABLA propdb13

                                if ($plantilla == 'HECTAREA PAQ') {

                                    if (count($cantvund) > 0) {
                                        foreach ($vectorund[$i] as $unidad) {
                                            $codnut = $unidad['codnut'];
                                            $und = $unidad['unidad'];
                                            $ord = $unidad['orden'];
                                            $fc = $unidad['factor'];
                                            $pro->insert_propdb13($codnut, $und, $ord, $fc);
                                        }
                                    }
                                }


                                ///REGISTRAR PRE DETALLE PRODUCTOS
                                $size = count($vectocar[$i]);
                                if ($size > 0) {
                                    foreach ($vectocar[$i] as $carrito) {

                                        $cantidadtotal = $carrito['cantidad'] * $ha;
                                        $costototal = ($cantidadtotal * $carrito['preciodcto']);
                                        $preciodcto = $carrito['preciodcto'];

                                        $pro->__set('ordenta', $carrito['ordenta']);
                                        $pro->__set('ordenprod', $carrito['ordenprod']);
                                        $pro->__set('codprod', $carrito['codprod']);
                                        $pro->__set('cantidad', $carrito['cantidad']);
                                        $pro->__set('cantidadtotal', $cantidadtotal);
                                        $pro->__set('costo', $carrito['precio']);
                                        $pro->__set('costototal', $costototal);
                                        $pro->__set('preciodcto', $preciodcto);
                                        $pro->__set('umedida', $carrito['umedida']);
                                        $pro->__set('taplicacion', $carrito['tipoa']);
                                        $pro->__set('congelado', $carrito['congelado']);

                                        $result2 = $pro->insertPropxAprobDetalle();
                                        if ($result2) {
                                            
                                        } else {
                                            $exito = false;
                                            ?><script>alert('Error al registrar CARRITO de Productos');</script><?php
                                        }
                                    }
                                }

                                //REGISTRAR DETALLE PRODUCTOS (REDONDEADO)
                                if ($cantdesp > 0) {
                                    foreach ($vectordesp[$i] as $cardesp) {

                                        $codprod = $cardesp['codprod'];
                                        $cantidad1 = $cardesp['cantidad1'];
                                        $cantidad2 = $cardesp['cantidad2'];
                                        $umedida1 = $cardesp['umedida1'];
                                        $umedida2 = $cardesp['umedida2'];
                                        $preciou = $cardesp['precio1'];
                                        $preciodcto = $cardesp['precio2'];
                                        $preciototal = $cardesp['preciototal'];
                                        $factorb = $cardesp['factorb'];
                                        $ordendesp = $cardesp['ordendesp'];

                                        $result100 = $pro->insert_propdb14($codprod, $cantidad1, $cantidad2, $umedida1, $umedida2, $preciou, $preciodcto, $preciototal, $factorb, $ordendesp);
                                        if ($result100) {
                                            
                                        } else {
                                            $exito = false;
                                            ?><script>alert('Error al registrar DISTRIBUCION de Productos');</script><?php
                                        }
                                    }
                                }
                            } else {
                                ?><script>alert('Error al registrar ITEM');</script><?php
                                $exito = false;
                            }
                        }

                        //ENVIAR MAIL
                        if ($exito) {
                            if (isset($_POST['modoprueba'])) {
                                
                            } else {

                                if ($_SESSION['usuario'] <> 'PRUEBA') {

                                    $pro->sendmailPropxAprob();
                                }
                            }
                            unset($_SESSION['item']);
                            unset($_SESSION['car']);
                            unset($_SESSION['und']);
                            unset($_SESSION['cardesp']);
                            //$pro->sendmail_propinsert_gerente();
                            ?>
                            <script>
                                alert('EN HORA BUENA :)!! Sus datos se han registrado correctamente.');
                            </script>
                            <?php
                        }
                    } else {
                        ?>
                        <script>alert('ERROR :(!! No se pudo registrar. Por favor verifique sus datos.');</script>
                        <?php
                    }
                } else {
                    ?>
                    <script>
                        alert('DEBE CREAR AL MENOS UN ITEM.');
                    </script>
                    <?php
                }
            }
            break;

        case 'UpdatePropuestaV2':

            $pro->__set('codpropold', trim(strtoupper($_POST['codpropold'])));
            $pro->__set('codprop', trim(strtoupper($_POST['codprop'])));
            $pro->__set('codcliente', trim(strtoupper($_POST['codcliente'])));
            $pro->__set('nomcliente', trim(strtoupper($_POST['nomcliente'])));
            $pro->__set('asunto', trim($_POST['asunto']));
            $pro->__set('descripcion', trim($_POST['obs']));
            $pro->__set('cultivo', trim(strtoupper($_POST['cultivo'])));
            $pro->__set('variedad', trim(strtoupper($_POST['variedad'])));
            $pro->__set('efenologica', trim(strtoupper($_POST['efenologica'])));
            $pro->__set('contactos', trim($_POST['contacto']));
            $pro->__set('elaboradopor', trim($_SESSION['nombreUsuario']));
            $pro->__set('asesor', trim($_POST['vendedor']));
            $pro->__set('zona', trim(strtoupper($_POST['zona'])));
            $pro->__set('lugar', trim(strtoupper($_POST['lugar'])));
            $pro->__set('demo', trim(strtoupper($_POST['demo'])));
            $pro->__set('fpago', trim(strtoupper($_POST['fpago'])));
            $pro->__set('obs_atec', trim($_POST['obs_atec']));
            $pro->__set('domuser', trim($_SESSION['usuario']));

            $result = $pro->update_propdb10();

            if ($result) {

                //ACTUALIZAR PROPDB12
                $ndetitem = $_POST['ndetitem'];
                for ($c = 0; $c < $ndetitem; $c++) {

                    $pro->__set('coditem', trim($_POST['coditem' . $c]));
                    $pro->__set('itemdesc', trim(strtoupper($_POST['pv2_itemdesc' . $c])));
                    $pro->__set('descuento', trim(strtoupper($_POST['pv2_descuento' . $c])));
                    $pro->__set('pcc', trim($_POST['pv2_pcc' . $c]));
                    $pro->__set('pca', trim($_POST['pv2_pca' . $c]));
                    $pro->__set('precioAMBT', trim($_POST['precioambt' . $c]));
                    $pro->__set('fa', trim($_POST['pv2_fa' . $c]));
                    $pro->__set('ha', trim($_POST['pv2_ha' . $c]));
                    $pro->__set('nitrogeno', trim($_POST['pv2_nitrogeno' . $c]));
                    $pro->__set('plantilla', trim($_POST['pv2_plantilla' . $c]));
                    $pro->__set('pud', trim($_POST['pv2_pud' . $c]));
                    $pro->__set('estadoitem', trim($_POST['pv2_estado' . $c]));
                    $pro->__set('modificado', trim($_POST['pv2_modificado' . $c]));
                    $resultpropdb12 = $pro->update_propdb12();

                    if ($resultpropdb12) {

                        //ACTUALIZAR PROPDB11 -> PRODUCTOS
                        //cantidad de productos en el carrito dentro de un item.
                        $ncar = $_POST['ncar' . $c];
                        for ($i = 0; $i < $ncar; $i++) {
                            $pro->__set('codprod', trim($_POST['codprod' . $c . $i]));
                            $pro->__set('taplicacion', trim($_POST['taplicacion' . $c . $i]));
                            $pro->__set('cantidad', trim($_POST['litros' . $c . $i]));
                            $pro->__set('costo', trim($_POST['precio' . $c . $i]));
                            $pro->__set('costototal', trim($_POST['costototal' . $c . $i]));
                            $pro->__set('preciodcto', trim($_POST['preciodcto' . $c . $i]));
                            $pro->__set('cantidadtotal', trim($_POST['ltsxha' . $c . $i]));
                            $pro->__set('ordenta', trim($_POST['ordenta' . $c . $i]));
                            $pro->__set('ordenprod', trim($_POST['ordenprod' . $c . $i]));
                            $pro->__set('umedida', trim($_POST['umedida' . $c . $i]));

                            //Actualizar Datos                            
                            $resultpropdb11 = $pro->update_propdb11();
                            if ($resultpropdb11) {
                                
                            } else {
                                return FALSE;
                            }
                        }
                    } else {
                        return false;
                    }
                }
                $pro->mailPropuestaUpdate();
                ?>
                <script>
                    //alert('Entre a UpdatePropuestaV2');
                    alert('OK :)!! Se ha actualizado el estado de la propuesta.');
                    //from_unico('', 'principal', '_propuestav2_aprob01.php');
                </script>
                <?php
            } else {
                ?>
                <script>alert('ERROR :(!! No se pudo actualizar esta propuesta.');</script>
                <?php
            }
            break;

        //cambiar estado de propuesta desde intranet
        case 'AprobPropuesta':
            $pro->__set('codprop', trim(strtoupper($_POST['codprop'])));
            $pro->__set('obs_aprob', trim(strtoupper($_POST['obs_aprob'])));
            $pro->__set('estadoaprob', trim(strtoupper($_POST['estadoaprob'])));
            $pro->__set('elaboradopor', trim(strtoupper($_POST['elaboradopor'])));

            $result = $pro->aprobarPropuesta();
            if ($result) {
                $pro->sendmailMsjAprobacion();
                ?>
                <script>
                    alert('OK :)!! Se ha actualizado el estado de la propuesta.');
                    from_unico('', 'bodytable', '_propuestav2_aprob01.php');
                </script>
                <?php
            } else {
                ?>
                <script>alert('ERROR :(!! No se pudo actualizar esta propuesta.');</script>
                <?php
            }
            break;

        //cambiar estado de propuesta desde verweb
        case 'AprobPropuesta2':
            $pro->__set('codprop', trim(strtoupper($_POST['codprop'])));
            $pro->__set('elaboradopor', trim(strtoupper($_POST['elaboradopor'])));
            $codigo = trim(strtoupper($_POST['codprop']));
            $vectoritem = $_SESSION['itemcar'];
            $cantitem = count($vectoritem);
            $suceso = 0;
            $error = 0;

            for ($i = 0; $i < $cantitem; $i++) {
                //VARIABLES PARA INSERTAR ITEM                
                $coditem = $vectoritem[$i]['coditem'];
                $pro->__set('coditem', $coditem);
                $pro->__set('itemdesc', $vectoritem[$i]['itemdesc']);
                $pro->__set('descuento', $_POST['dscto' . $i]);
                $pro->__set('pcc', $_POST['pcc' . $i]);
                $pro->__set('pca', $_POST['pca' . $i]);
                $pro->__set('precioAMBT', $_POST['preambt' . $i]);
                $pro->__set('fa', $_POST['fau' . $i]);
                $pro->__set('ha', $_POST['pv2_ha' . $i]);
                $pro->__set('nitrogeno', $_POST['pv2_nitrogeno' . $i]);
                $pro->__set('plantilla', $_POST['pv2_plantilla' . $i]);
                $pro->__set('pud', $_POST['pv2_pud' . $i]);
                $pro->__set('estadoitem', $_POST['estadoitem' . $i]);
                $pro->__set('modificado', $_POST['modificado' . $i]);
                $result = $pro->update_propdb12();
                if ($result) {
                    $suceso++;
                } else {
                    $error++;
                    ?>
                    <script>alert('ERROR :(!! No se pudo actualizar esta propuesta.');</script>
                    <?php
                    $banderinha = 'error';
                    return;
                }
            }
            if ($suceso > 0 && $error == 0) {
                $pro->sendmailMsjAprobacion();
                ?>
                <script>
                    alert('OK :)!! Se ha actualizado con éxito el estado de la propuesta.');
                    location.href = '../site/_propuestav2_aprob03_rpta.php?cod=<?php echo $codigo; ?>';
                </script>
                <?php
            } elseif ($suceso > 0 && $error > 0) {
                $pro->sendmailMsjAprobacion();
                ?>
                <script>
                    alert('Algo anda mal!! Unos de los items no se pudo actualizar.');
                    location.href = '../site/_propuestav2_aprob03_rpta.php?cod=<?php echo $codigo; ?>';
                </script>
                <?php
            } elseif ($suceso == 0 && $error > 0) {
                ?>
                <script>
                    alert('Lo sentimos!! No se pudo modificar el estado.');
                </script>
                <?php
            }
            break;

        case 'DespachoAdjunto':
            $pro->__set("codprop", trim($_POST['codprop']));
            //Subir Propuesta en PDF
            if (isset($_FILES['nomarchivo']['name'])) {
                $result = $pro->uploadFileNombreOriginal('nomarchivo', 'DESPACHO', 'DESP-');
                if ($result) {
                    ?>
                    <script>alert('OK :)!! El archivo se subio exitosamente.');</script>
                    <?php
                } else {
                    ?>
                    <script>alert('ERROR :(!! No se pudo subir el archivo.');</script>
                    <?php
                }
            }
            break;

        case 'RegComentario':

            $pro->__set('codprop', $_POST['codprop']);
            $pro->__set('coditem', $_POST['coditem']);
            $comentario = $_GET['comentario'];
            $desuse = $_SESSION['nombreUsuario'];
            $pro->insert_propdb15($comentario, $desuse);

            if (isset($_FILES['nomarchivo']['name'])) {
                $result = $pro->uploadFileNombreOriginal('nomarchivo', 'DESPACHO', 'DESP-');
                if ($result) {
                    ?>
                    <script>alert('OK :)!! El archivo se subio exitosamente.');</script>
                    <?php
                } else {
                    ?>
                    <script>alert('ERROR :(!! No se pudo subir el archivo.');</script>
                    <?php
                }
            }
            break;

        case 'RegEstadoComercial':

            $codprop = trim(strtoupper($_POST['codprop']));
            $estado = trim(strtoupper($_POST['estado']));
            $ecom->__set('codprop', $codprop);
            $ecom->__set('fecha', trim($_POST['fecha']));
            $ecom->__set('estado', $estado);
            $ecom->__set('obs', trim(strtoupper($_POST['obs'])));
            $ecom->__set('dom_user', $_SESSION['usuario']);

            //Asignar otro estado comercial
            if ($estado == 'OTRO') {
                $ecom->__set('estado', trim(strtoupper($_POST['estado2'])));
            }
            $result = $ecom->insert_propdb16();

            if ($result) {
                echo 'Se registro con exito';
                ?>
                <script>
                    alert('OK :)!! Se ha registrado el estado comercial.');                      
                </script>
                <?php
            } else {
                echo 'Error';
                ?>
                <script>alert('ERROR :(!! No se pudo registrar el estado comercial.');</script>
                <?php
            }
            break;

        //Se debe eliminar el Case RegEstadoComercial, si es que esto está funcionando bien
        case 'RegEstadoComercialV2':
            $con = new Conexion();
            $objeto = $_POST['obj'];
            $codprop = trim(strtoupper($objeto['codprop']));
            $estado = trim(strtoupper($objeto['estado']));
            $ecom->__set('codprop', $codprop);
            $ecom->__set('fecha', trim($objeto['fecha']));
            $ecom->__set('estado', $estado);
            $ecom->__set('obs', trim(strtoupper($objeto['obs'])));
            $ecom->__set('dom_user', $_SESSION['usuario']);

            //Asignar otro estado comercial
            if ($estado == 'OTRO') {
                $ecom->__set('estado', trim(strtoupper($objeto['estado2'])));
            }
            $result = $ecom->insert_propdb16();

            if ($result) {
                echo "<script>
                    $.confirm({
                        title: 'Confirm!',
                        content: 'OK. Se registro con éxito!',
                        buttons: {
                            OK: function () {
                            location.reload();
                            }
                        }
                    });
                </script>";
            } else {
                echo "<script>
                    $.confirm({
                        title: 'Confirm!',
                        content: 'ERROR. No se pudo registrar!',
                        buttons: {
                            OK: function () {
                            $.alert('Volver a Intentarlo!');
                            }
                        }
                    });
                </script>";
            }
            break;

        case 'ModEstadoComercial':

            $codprop = trim(strtoupper($_POST['codprop']));
            $estado = trim(strtoupper($_POST['estado']));

            $ecom->__set('codestado', trim($_POST['codestado']));
            $ecom->__set('codprop', $codprop);
            $ecom->__set('fecha', trim($_POST['fecha']));
            $ecom->__set('estado', $estado);
            $ecom->__set('obs', trim(strtoupper($_POST['obs'])));
            $ecom->__set('usemod', trim($_SESSION['usuario']));

            //Asignar otro estado comercial
            if ($estado == 'OTRO') {
                $ecom->__set('estado', trim(strtoupper($_POST['estado2'])));
            }
            $result = $ecom->update_propdb16();

            if ($result) {
                ?>
                <script>
                    alert('OK :)!! Se ha actualizado el estado comercial.');
                    from_unico('', 'bodytable', '_propuestav2_ecomercial.php?codprop=<?php echo $codprop; ?>');
                </script>
                <?php
            } else {
                ?>
                <script>alert('ERROR :(!! No se pudo registrar el estado comercial.');</script>
                <?php
            }
            break;

        case 'UploadFile':
            $directorio = '../site/archivos/propuestas/';
            $descripcion = trim(strtoupper($_POST['descripcion']));
            $prefijo = $pro->obtenerPrefijoArchivo(trim($descripcion));
            $codprop = trim($_POST['codprop']);
            $pro->__set('codprop', $codprop);
            //Subir Propuesta en PDF
            if (isset($_FILES['archivo']['name'])) {
                $result = $pro->uploadFile('archivo', $descripcion, $prefijo);
            }

            if ($result) {
                ?>
                <script>
                    alert('OK :)!! Se ha subido el archivo.');                    
                </script>
                <?php
            } else {
                ?>
                <script>alert('LO SENTIMOS :(!! No se pudo subir este archivo.');</script>
                <?php
            }
            break;

        //Enviar Mail de Area Tecnica a Area Comercial
        case 'sendmailATaAC':
            $msjError = '<div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>';
            $msjSucess = '<div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>';

            $pro->codprop = trim($_POST['m_codprop']);
            $pro->nomcliente = trim($_POST['m_nomcliente']);
            $pro->nomvendedor = trim($_POST['m_nomvendedor']);
            $pro->cultivo = trim($_POST['m_cultivo']);
            $pro->mailpara = trim($_POST['mailpara']);
            $pro->mailmsj = trim($_POST['mailmsj']);
            $pro->estado_ger = 'APROBADO';

            //Actualizar estado de propuesta para APROBADO                        
            $pro->updateEstadoGerencial();
            //Enviar mail a Area Comercial
            if ($pro->sendmailMsjAprobacionATaAC()) {
                $msjSucess .= '<strong>OK</strong> Se envio la propuesta a Área Comercial.</div>';
                echo $msjSucess;
            } else {
                $msjError .= '<strong>Ups!</strong> Error al enviar la propuesta.</div>';
                echo $msjError;
            }
            break;

        //Enviar Mail de Area Comercial a Despacho
        case 'sendmailACaDESP':
            $msjError = '<div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>';
            $msjSucess = '<div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>';

            $objeto = $_POST['obj'];

            $pro->codprop = trim($objeto['codprop']);
            $pro->nomcliente = trim($objeto['nomcliente']);
            $pro->nomvendedor = trim($objeto['nomvendedor']);
            $pro->cultivo = trim($objeto['cultivo']);
            $pro->mailpara = trim($objeto['mailpara']);
            $pro->mailmsj = trim($objeto['mailmsj']);
            //$pro->estado_ger = 'APROBADO';
            //Actualizar estado de propuesta para APROBADO                        
            //$pro->updateEstadoGerencial();
            //Enviar mail a Despacho
            if ($pro->sendmailMsjAprobacionACaDESP()) {
                $msjSucess .= '<strong>OK</strong> Se envio la propuesta a Despacho.</div>';
                echo $msjSucess;
            } else {
                $msjError .= '<strong>Ups!</strong> Error al enviar mensaje.</div>';
                echo $msjError;
            }
            break;

        case 'sendmailACaVEND':
            $msjError = '<div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>';
            $msjSucess = '<div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>';

            $objeto = $_POST['obj'];

            $pro->codprop = trim($objeto['codprop']);
            $pro->nomcliente = trim($objeto['nomcliente']);
            $pro->nomvendedor = trim($objeto['nomvendedor']);
            $pro->cultivo = trim($objeto['cultivo']);
            $pro->mailpara = trim($objeto['mailpara']);
            $pro->mailcc = trim($objeto['mailcc']);
            $pro->mailmsj = trim($objeto['mailmsj']);
            //$pro->estado_ger = 'APROBADO';
            //Actualizar estado de propuesta para APROBADO                        
            //$pro->updateEstadoGerencial();
            //Enviar mail a Despacho
            if ($pro->sendmailMsjAprobacionACaVEND()) {
                $msjSucess .= '<strong>OK</strong> Se envio la propuesta a Vendedor.</div>';
                echo $msjSucess;
            } else {
                $msjError .= '<strong>Ups!</strong> Error al enviar mensaje.</div>';
                echo $msjError;
            }
            break;

        case 'RegDespacho':

            $coddesp = $desp->generarCodDespacho();
            $objeto = $_POST['obj'];
            $desp->__set('coddesp', trim(strtoupper($coddesp)));
            $desp->__set('codprop', trim(strtoupper($objeto['codprop'])));
            $desp->__set('prioridad', trim(strtoupper($objeto['prioridad'])));
            $desp->__set('montodesp', trim($objeto['montodesp']));
            $desp->__set('saldo', trim($objeto['saldo']));
            $desp->__set('moneda', trim(strtoupper($objeto['moneda'])));
            $desp->__set('fecprev', trim(strtoupper($objeto['fecprev'])));
            $desp->__set('descripcion', trim(strtoupper($objeto['descripcion'])));
            $desp->__set('obs', trim(strtoupper($objeto['obs'])));
            $desp->__set('domuser', $_SESSION['usuario']);

            //insertar nuevo despacho
            $result = $desp->registrarDespacho();
            if ($result) {
                ?>
                <script>
                    $.alert({
                        title: 'OK!',
                        content: 'Se registro con exito!',
                    });
                </script>                
                <?php
            } else {
                ?>
                <div class="alert alert-danger" style="vertical-align: middle;" id="mensaje">Falla. No se pudo registrar. :(</div>                
                <?php
            }

            break;

        case 'ActDespacho':

            $desp->__set('coddesp', trim(strtoupper($_POST['coddesp'])));
            $desp->__set('codprop', trim(strtoupper($_POST['codprop'])));
            $desp->__set('prioridad', trim(strtoupper($_POST['prioridad'])));
            $desp->__set('fecprev', trim(strtoupper($_POST['fecprev'])));
            $desp->__set('montodesp', trim($_POST['montodesp']));
            $desp->__set('saldo', trim($_POST['saldo']));
            $desp->__set('moneda', trim(strtoupper($_POST['moneda'])));
            $desp->__set('descripcion', trim(strtoupper($_POST['descripcion'])));
            $desp->__set('obs', trim(strtoupper($_POST['obs'])));
            $desp->__set('domuser', $_SESSION['usuario']);

            //ACTUALIZAR despacho
            $result = $desp->modificarDespacho();
            if ($result) {
                ?>
                <div class="alert alert-success" style="vertical-align: middle;" id="mensaje">OK. Se actualizó con suceso :) </div>                
                <?php
            } else {
                ?>
                <div class="alert alert-danger" style="vertical-align: middle;" id="mensaje">Falla. No se pudo actualizar. :(</div>
                <?php
            }

            break;

        default:
            break;
    }
}