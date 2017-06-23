<?php
session_start();
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
}
$accion = $_GET['cod1'];
$descuento = 0;
$igv = 0;
$flete = 0;

if ($accion == 'ADDPRODUCTO') {
    $getvariables = $_GET['cod2'];
    $variables = explode(',', $getvariables);
    $codprod = $variables[0];
    $nomprod = $variables[1];
    $cantidad = $variables[2];
    $umedida = $variables[3];
    $preciou = $variables[4];
    $presentacion = $variables[5];
    $cantpre = $variables[6];    
    $container = $variables[7];
    
    agregarItemAlCarrito($codprod, $nomprod, $cantidad, $umedida, $preciou, $presentacion, $cantpre, $container);
}

if ($accion == 'ELIM') {
    $indice = $_GET['cod2'];
    //removeItemCarrito($indice);
    echo "<script>";
    echo "alert('Entre a eliminar)";
    //echo "cargar('#divcarrito', '_pedido_reg_car.php?cod1=none&cod2')";
    echo "</script>";
}

if ($accion == 'LIMPIAR') {
    limpiarCarrito();
    echo "<script>";
    echo "cargar('#divproductos', '_propuestav2_hapaq_detalle.php?cod1=none&cod2=none&cod3=none')";
    echo "</script>";
}

function agregarItemAlCarrito($codprod, $nomprod, $cantidad, $umedida, $preciou, $presentacion, $cantpre, $container) {

    $indice = array_search(trim($codprod), array_column($_SESSION['carrito'], trim('codprod')), false);
    if (strlen($indice) == '') {
        array_push($_SESSION['carrito'], array('codprod' => trim($codprod), 'nomprod' => $nomprod, 'cantidad' => $cantidad, 'umedida' => $umedida, 'preciou' => $preciou, 'presentacion' => $presentacion, 'cantidadp' => $cantpre, 'container'=>$container));
    } else {
        echo '<script>';
        echo 'alert("Este producto ya esta en el carrito. Se actualizara la cantidad y precio");';
        echo '</script>';
        $_SESSION['carrito'][$indice]['cantidad'] = $cantidad;
        $_SESSION['carrito'][$indice]['preciou'] = $preciou;
        $_SESSION['carrito'][$indice]['umedida'] = $umedida;        
        $_SESSION['carrito'][$indice]['presentacion'] = $presentacion;
        $_SESSION['carrito'][$indice]['cantidadp'] = $cantpre;
        $_SESSION['carrito'][$indice]['container'] = $container;
    }
}

function removeItemCarrito($indice) {
    unset($_SESSION['carrito'][$indice]);
    $_SESSION['carrito'] = array_values($_SESSION['carrito']);
}

function limpiarCarrito() {
    unset($_SESSION['carrito']);
}

?>
<style>
    .tablacar {
        border-collapse: separate;
        /*border-collapse: collapse;*/
        border: red 5px solid;
        width: 100%;
    }
    .tablacar tbody {
        border: blue 5px solid;
    }

    .tablacar tr {
        border: green 5px solid;
    }
</style>

<table class="table table-condensed">
    <thead>
        <tr>            
            <th style="text-align: center;">CANT.</th>
            <th style="text-align: center;">PRESENT.</th>
            <th style="text-align: center;">CANT</th>
            <th style="text-align: center;">UND.</th>
            <th>DESCRIPCIÓN</th>            
            <th style="text-align: center;">PREC. UNIT.</th>
            <th style="text-align: center;">TOTAL</th>            
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $subtotal = 0;        
        //$valorventa = 0;
        //$totalpagar = 0;

        $ncarrito = 0;
        if (isset($_SESSION['carrito'])) {
            $ncarrito = count($_SESSION['carrito']);
        }

        if ($ncarrito > 0) {
            $indice = 0;
            foreach ($_SESSION['carrito'] as $producto) {

                $codprod = $producto['codprod'];
                $cantidad = $producto['cantidad'];
                $precio = $producto['preciou'];
                $totalxprod = ($cantidad * $precio);
                $subtotal+=$totalxprod;
                ?>
                <tr style="font-size: 10px;">                    
                    <td style="text-align: center;"><?php echo number_format($producto['cantidadp'], 2); ?></td>
                    <td><?php echo $producto['presentacion']; ?></td>
                    <td style="text-align: right;"><?php echo number_format($producto['cantidad'], 2); ?></td>
                    <td style="text-align: center;"><?php echo $producto['umedida']; ?></td>
                    <td><?php echo $producto['nomprod']; ?></td>
                    <td style="text-align: right;">$ <?php echo number_format($producto['preciou'], 2); ?></td>                    
                    <td style="text-align: right;">$<?php echo number_format($totalxprod, 2); ?></td>
                    <td>
                        <!--<a class="btn btn-default" href="javascript:cargar('#divcarrito', '_pedido_reg_car.php?cod1=ELIM&cod2=<?php //echo trim($indice)    ?>" title="Eliminar"><img src="img/iconos/trash.png" height="15" /></a>-->
                        <a class="btn btn-default" href="javascript:cargar('#divcarrito', '_pedido_reg_car2.php" title="Eliminar"><img src="img/iconos/trash.png" height="15" /></a>
                    </td>
                </tr>
                <?php
                $indice++;
            }
            ?>            
            
            <?php
            $valorventa = ($subtotal - $descuento);
            ?>
            <tr>
                <td colspan="4"></td>
                <td>Valor Venta</td>
                <td></td>
                <td style="text-align: right;">
                    $<?php echo number_format($valorventa, 2); ?>
                    <input type="hidden" name="valorventa" value="<?php echo $valorventa; ?>" />
                </td>
                <td></td>
            </tr> 
            <?php                        
            $totalpagar = ($valorventa);
            ?>
            <tr>
                <td colspan="4"></td>
                <td>Total a Pagar:</td>
                <td></td>
                <td style="text-align: right; font-weight: bolder;">
                    $<?php echo number_format($totalpagar, 2); ?>
                    <input type="hidden" name="totalpagar" value="<?php echo $totalpagar; ?>" />
                </td>
                <td></td>
            </tr> 
            <?php
        } else {
            echo '<tr style="color:red"><td colspan=6>No hay productos.</td></tr>';
        }
        ?>        
    </tbody>
</table>