<?php
$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}
include '../database/Conexion.php';
include '../model/Producto.php';
include '../model/Pedido.php';
include '../model/PedidoDetalle.php';
include '../model/Comisiones.php';
include '../model/ClientexVendedor.php';
include '../model/ClientexVendedorCompartido.php';
include '../model/Propuesta.php';
include '../model/Menu.php';


$prod = new C_Producto();
$prop = new C_Propuesta();
$pedido = new Pedido();
$pedidodet = new PedidoDetalle();
$comision = new Comisiones();
$clixven = new ClientexVendedor();
$clixvencomp = new ClientexVendedorCompartido();

if (isset($_POST['accion'])) {

    switch ($_POST['accion']) {
        case 'RegPedidoV1':

            $exito = true;
            $pedido->__set('codpedido', trim($_POST['codpedido']));
            $pedido->__set('codcli', trim(strtoupper($_POST['codcli'])));
            $pedido->__set('ruc', trim(strtoupper($_POST['ruc'])));
            $pedido->__set('nomcliente', trim(strtoupper($_POST['nomcliente'])));
            $pedido->__set('telefono', trim(strtoupper($_POST['telefono'])));
            $pedido->__set('dircli', trim(strtoupper($_POST['dircli'])));
            $pedido->__set('contacto', trim(strtoupper($_POST['contacto'])));
            $pedido->__set('numero_oc', trim(strtoupper($_POST['numero_oc'])));
            $pedido->__set('fecoc', trim(strtoupper($_POST['fecoc'])));
            $pedido->__set('fecpedido', trim(strtoupper($_POST['fecpedido'])));
            $pedido->__set('fpago', trim(strtoupper($_POST['fpago'])));
            $pedido->__set('codven', trim(strtoupper($_POST['codven'])));
            $pedido->__set('nomven', trim(strtoupper($_POST['nomven'])));
            $pedido->__set('tipodcto', trim(strtoupper($_POST['tipodcto'])));
            $pedido->__set('descuento', trim($_POST['descuento']));
            $pedido->__set('subtotal', trim($_POST['subtotal']));
            $pedido->__set('valorventa', trim($_POST['valorventa']));
            $pedido->__set('igv', trim($_POST['igv']));
            $pedido->__set('flete', trim($_POST['flete']));
            $pedido->__set('fau', trim($_POST['fau']));
            $pedido->__set('totalpagar', trim(strtoupper($_POST['totalpagar'])));
            $pedido->__set('lugar_entrega', trim(strtoupper($_POST['lugar_entrega'])));
            $pedido->__set('detalle_entrega', trim(strtoupper($_POST['detalle_entrega'])));
            $pedido->__set('obs', trim(strtoupper($_POST['obs'])));
            $pedido->__set('dom_user', trim(strtoupper($_SESSION['usuario'])));

            $rpta_regpedido = $pedido->insert_peddb01();

            if ($rpta_regpedido) {
                //Insertar OrdenPedido
                $vectordesp = $_SESSION['carrito'];
                $cantdesp = count($vectordesp);

                if ($cantdesp > 0) {
                    foreach ($vectordesp as $cardesp) {
                        $pedidodet->__set('codpedido', trim($_POST['codpedido']));
                        $pedidodet->__set('codprod', trim($cardesp['codprod']));
                        $pedidodet->__set('nomprod', trim(strtoupper($cardesp['nomprod'])));
                        $pedidodet->__set('cantidad', trim($cardesp['cantidad']));
                        $pedidodet->__set('umedida', trim($cardesp['umedida']));
                        $pedidodet->__set('precio', trim($cardesp['precio']));
                        $pedidodet->__set('dom_user', trim(strtoupper($_SESSION['usuario'])));

                        $rpta_pedidodet = $pedidodet->insert_peddb02();
                        if ($rpta_pedidodet) {
                            
                        } else {
                            $exito = FALSE;
                            return FALSE;
                        }
                    }
                }
                //Buscar Comision
                $clixven->__set('codcli', trim(strtoupper($_POST['codcli'])));
                $clixven->__set('codven', trim($_POST['codven']));
                $fau = trim($_POST['fau']);                
                $porcentaje_comision = 0;
                
                $vector_comision = $clixven->buscarClientexVendedor();                
                if ($vector_comision) {
                    $porcentaje_comision = $vector_comision[5];
                }                
                
                $valorventa = ($_POST['valorventa']);                
                $montocomision =    $valorventa * ($porcentaje_comision / 100);
                $comision_final = $comision->calcularComisionPrincipal($montocomision, $fau);

                //Registrar Comisiones
                $comision->__set('codpedido', trim($_POST['codpedido']));
                $comision->__set('tipocomision', 'PAQ');
                $comision->__set('codven', trim($_POST['codven']));
                $comision->__set('nomven', trim($_POST['nomven']));
                $comision->__set('monto', $comision_final);
                $comision->__set('comision', $porcentaje_comision);
                $comision->__set('dom_user', trim(strtoupper($_SESSION['usuario'])));
                $comision->insert_comdb01();
            }

            if ($exito) {
                ?>
                <script>
                    alert('OK. Todo se registro bien');
                    from_unico('', 'principal', '_pedido.php');
                </script>

                <?php
            } else {
                ?><script>alert('ERROR. No se registro pedido');</script><?php
            }

            break;

        default:
            break;
    }
}