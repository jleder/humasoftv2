<?php
$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}
include '../database/Conexion.php';
include '../model/Movimiento.php';
include '../model/MovimientoDetalle.php';
include '../model/Almacen.php';
include '../model/Inventario.php';
include '../model/Producto.php';
include '../model/OrdenCompra.php';
include '../model/OrdenCompraDetalle.php';
include '../model/Menu.php';

$mov = new Movimiento();
$movdet = new MovimientoDetalle();
$alma = new Almacen();
$inv = new Inventario();


if (isset($_POST['accion'])) {

    switch ($_POST['accion']) {

        case 'RegMovOrdenImp':

            $exito = true;

            //Convertir fecha en formato yyyy/mm/dd
            $con = new Conexion();
            $fecmov = trim($_POST['fecmov']);
            $new_fecmov = $con->transformDDMMAAtoAAMMDD($fecmov);

            $mov->__set('idalmacen', trim($_POST['idalmacen']));
            $mov->__set('fecmov', trim($_POST['fecmov']));
            $mov->__set('tipomov', trim('E'));
            $mov->__set('transac_tipo', trim('IM')); //INGRESO X IMPORTACIONES
            $mov->__set('transac_numero', trim($_POST['transac_numero']));
            $mov->__set('obs', trim(strtoupper($_POST['obs'])));
            $mov->__set('dom_user', trim($_SESSION['usuario']));

            //Regitrar Cabecera de Orden de Compra
            $result = $mov->insert_movdb01();
            if ($result) {

                //Insertar OrdenPedido       
                $ocodet = new OrdenCompraDetalle();

                $vec_codigo = $_POST['codigo'];  //cod ordencompra detalle
                $vec_codprod = $_POST['codprod'];
                $vec_precio = $_POST['precio'];
                $vec_umedida = $_POST['umedida'];
                $vec_cantidad = $_POST['cantidad'];
                $vec_saldo = $_POST['saldo'];

                $sizevec = count($vec_codprod);
                //Obtener el ultimo id
                $get_idmovimiento = $movdet->n_fila($result);
                $idmovimiento = $get_idmovimiento[0];


                for ($i = 0; $i < $sizevec; $i++) {

                    $movdet->__set('idmovimiento', trim($idmovimiento));
                    $movdet->__set('idproducto', trim($vec_codprod[$i]));
                    $movdet->__set('umedida', trim($vec_umedida[$i]));
                    $movdet->__set('cantidad', trim($vec_cantidad[$i]));
                    $movdet->__set('precio', trim($vec_precio[$i]));
                    $movdet->__set('dom_user', $_SESSION['usuario']);

                    $result_movdet = $movdet->insert_movdb02();

                    if (!$result_movdet) {
                        ?>
                        <script>alert('ERROR AL REGISTRAR EN DETALLE MOVIMIENTO');</script>
                        <?php
                        $exito = false;
                    } else {

                        //ACTUALIZAR SALDO
                        $saldo = ($vec_saldo[$i] - $vec_cantidad[$i]);
                        $ocodet->__set('codigo', $vec_codigo[$i]);
                        $ocodet->__set('saldo', $saldo);
                        $ocodet->actualizarSaldo();

                        //ACTUALIZAR STOCK                        
                        $inv->__set('codalmacen', trim($_POST['idalmacen']));
                        $inv->__set('codprod', trim($vec_codprod[$i]));
                        $inv->__set('umedida', trim($vec_umedida[$i]));
                        $existe = $inv->existe_producto();
                        if ($existe) {
                            //Actualizo Stock
                            $codigo = $existe[0];
                            $stock = $existe[4];
                            $stock_nuevo = ($stock + $vec_cantidad[$i]);
                            $inv->__set('codigo', $codigo);
                            $inv->__set('stock', $stock_nuevo);
                            $inv->update_stock();
                        } else {
                            //Registro en la BD
                            $stock = $vec_cantidad[$i];
                            $inv->__set('stock', $stock);
                            $inv->insert_invdb01();
                        }
                    }
                }



                /*
                  $vectordesp = $_SESSION['carrito'];
                  $cantdesp = count($vectordesp);

                  if ($cantdesp > 0) {
                  foreach ($vectordesp as $cardesp) {


                  $result_movdet = $movdet->insert_movdb02();
                  if ($result_movdet) {

                  $inv->__set('codalmacen', trim($_POST['codalmacen']));
                  $inv->__set('codprod', trim(strtoupper($cardesp['codprod'])));
                  $inv->__set('umedida', trim($cardesp['umedida']));

                  $existe = $inv->existe_producto();
                  if ($existe) {
                  //Actualizo Stock
                  $stock = ($existe[3] + $cardesp['cantidad']);
                  $inv->__set('stock', $stock);
                  $inv->update_stock();
                  } else {
                  //Registro en la BD
                  $stock = $cardesp['cantidad'];
                  $inv->__set('stock', $stock);
                  $inv->insert_invdb01();
                  }
                  } else {
                  $exito = FALSE;
                  return FALSE;
                  }
                  }
                  }
                 */
            } else {
                $exito = FALSE;
            }
            if ($exito) {
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