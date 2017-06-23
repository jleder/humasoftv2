<?php
$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}
include '../database/Conexion.php';
include '../model/Producto.php';
include '../model/OrdenCompra.php';
include '../model/OrdenCompraDetalle.php';
include '../model/Proveedor.php';
include '../model/Menu.php';

$prod = new C_Producto();
$ocom = new OrdenCompra();
$ocod = new OrdenCompraDetalle();

if (isset($_POST['accion'])) {

    switch ($_POST['accion']) {

        case 'RegOrdenCompra':

            $exito = true;

            //Convertir fecha en formato yyyy/mm/dd
            $con = new Conexion();
            $fecha_oc = trim($_POST['fecha_oc']);
            $new_fecha_oc = $con->transformDDMMAAtoAAMMDD($fecha_oc);

            $ocom->__set('numero_oc', trim(strtoupper($_POST['numero_oc'])));
            $ocom->__set('codproveedor', trim($_POST['codproveedor']));
            $ocom->__set('codcia', trim($_POST['codcia']));
            $ocom->__set('contacto', trim(strtoupper($_POST['contacto'])));
            $ocom->__set('via', trim(strtoupper($_POST['via'])));
            $ocom->__set('fpago', trim(strtoupper($_POST['fpago'])));
            $ocom->__set('fecha_oc', trim($new_fecha_oc));
            $ocom->__set('obs', trim(strtoupper($_POST['obs'])));
            $ocom->__set('dom_user', $_SESSION['usuario']);

            //Regitrar Cabecera de Orden de Compra
            $result = $ocom->insert_ocodb01();
            if ($result) {
                //Insertar OrdenPedido
                $vectordesp = $_SESSION['carrito'];
                $cantdesp = count($vectordesp);

                if ($cantdesp > 0) {
                    foreach ($vectordesp as $cardesp) {
                        $ocod->__set('numero_oc', trim(strtoupper($_POST['numero_oc'])));
                        $ocod->__set('codprod', trim(strtoupper($cardesp['codprod'])));
                        $ocod->__set('cantidad', trim($cardesp['cantidad']));
                        $ocod->__set('saldo', trim($cardesp['cantidad']));
                        $ocod->__set('preciou', trim($cardesp['preciou']));
                        $ocod->__set('umedida', trim(strtoupper($cardesp['umedida'])));
                        $ocod->__set('cantidadp', trim($cardesp['cantidadp']));
                        $ocod->__set('presentacion', trim(strtoupper($cardesp['presentacion'])));
                        $ocod->__set('container', trim($cardesp['container']));
                        $ocod->__set('dom_user', $_SESSION['usuario']);

                        $result_ocod = $ocod->insert_ocodb02();
                        if ($result_ocod) {
                            
                        } else {
                            $exito = FALSE;
                            return FALSE;
                        }
                    }
                }
            } else {
                $exito = FALSE;
            }
            if ($exito) {                
                unset($_SESSION['carrito']);                
                ?>
                <script>
                    alert('OK. Todo se registro bien');
                    from_unico('', 'ajax-content', '_ordimport.php');
                </script>

                <?php
            } else {
                ?><script>alert('ERROR. No se registro la compra');</script><?php
            }

            break;

        case 'ModOrdenCompra':
            break;

        default:
            break;
    }
}