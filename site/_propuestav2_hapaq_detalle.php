<?php
session_start();
include '../controller/C_Producto.php';
$obj = new C_Producto();

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
    $_SESSION['carritodesp'] = array(); //carrito despacho
    $_SESSION['unidades'] = array();
}

$getvariables = $_GET['cod3'];
$variables = explode(',', $getvariables);
$tipo = $variables[0];

//variables globales
$descuento = 0;
$ha = 1;
$pca = 0;
$pcc = 0;
$pud = 'f';
$pup = 'f';
$verfc = 'f';
$incluyeigv = 'f';
$valigv = 1;


if ($tipo == 'ONLYTABLE') {

    $ha = $variables[1];  //HECTAREAS    
    $descuento = $variables[2];
    $pca = $variables[3];
    $pcc = $variables[4];
    $pud = $variables[5];
    $incluyeigv = $variables[6];
    $valigv = $variables[7];
    $pup = $variables[8];
    $verfc = $variables[9];
}

//    echo '<pre>';
//    print_r($bidones);
//    echo '</pre>';

if ($tipo == 'BYUNIDAD') {

    $un = $_GET['cod1'];  //unidades
    $fc = $_GET['cod2'];  //factor convencional por cliente
    $pre = $_GET['cod4'];  //precios
    $cong = $_GET['cod5'];  //precios congelados 
//$est = $_GET['cod6'];  //nuevo precio, o precio especial
    $bd = $_GET['cod6'];  //bidones
    $tipoa = 'FERTIRRIEGO'; //tipo de aplicación
    $ordenta = '00';


    $ha = $variables[2];  //HECTAREAS
    $nitrogeno = $variables[3];
    $descuento = $variables[4];
    $pca = $variables[5];
    $pcc = $variables[6];
    $pud = $variables[7];

    $incluyeigv = $variables[8];
    $valigv = $variables[9];
    $pup = $variables[10];
    $verfc = $variables[11];

    $unidades = explode(',', $un);
    $factores = explode(',', $fc);
    $factorbidon = explode(',', $bd);

    $precio60 = explode(',', $pre);
    $congelar = explode(',', $cong);
//$establecido = explode(',', $est);

    $nt = array('N', 'P', 'K', 'Ca', 'Mg', 'S', 'B', 'Co', 'Cu', 'Fe', 'Mn', 'Mo', 'Si', 'Zn'); //array de nutrientes
    $ncant = count($unidades);
    for ($i = 0; $i < $ncant; $i++) {
        if ($unidades[$i] > 0) {

//Aqui creamos sesion para las unidades.            
            $_SESSION['unidades'] = $obj->addArrayUnidades($_SESSION['unidades'], $nt[$i], $unidades[$i], $i, $factores[$i]);

            $obj->__set('inicial', trim($nt[$i]));
            $getproducto = $obj->getProductoByNut();
            $codprod = $getproducto[0]['codigo'];
            $precio = $getproducto[0]['pventa'];

            if ($nt[$i] == 'N') {
                if ($nitrogeno == 'si') {
                    $litros = ($unidades[$i]) / ($factores[$i]);
                } elseif ($nitrogeno == '50') {
                    $unddscto = ($unidades[$i] * 0.5);
                    $litros = ($unddscto) / ($factores[$i]);
                } elseif ($nitrogeno == 'no') {
                    $litros = 0;
                }
            } else {
                $litros = ($unidades[$i]) / ($factores[$i]);
            }
            $congelado = $congelar[$i];

            if ($litros > 0) {
//$precio = leerPrecioDcto($establecido[$i], $congelado, $descuento, $precio, $precio60[$i]);
                $preciodcto = leerPrecioDcto($congelado, $descuento, $precio, $precio60[$i]);
                agregarItemAlCarrito($codprod, $litros, $tipoa, $ordenta, $precio, $congelado, $preciodcto, $factorbidon[$i]);
            }
        }
    }
}

function leerPrecioDcto($congelado, $dscto, $precioA, $precio60) {
    $preciodcto = 0;

    if ($congelado == 'T') {
        $preciodcto = $precio60;
    } else {
        $preciodcto = $precioA - ($precioA * ($dscto / 100));
    }
    return $preciodcto;
}

if ($tipo == 'BYPRODUCTO') {
    $codigo = $_GET['cod1'];
    $cantidad = $_GET['cod2'];
    $ha = $_GET['cod4'];  //HECTAREAS    

    $precio = $variables[1];
    $preciodcto = $variables[8];
    $ordenta = $variables[2];
    $tipoa = $variables[3];
    $congelado = $variables[4];
    $descuento = $variables[5];
    $pcc = $variables[6];
    $pca = $variables[7];
    $factorbidon = $variables[9];
    $pud = $variables[10];
    $incluyeigv = $variables[11];
    $valigv = $variables[12];
    $pup = $variables[13];
    $verfc = $variables[14];
//from_7(codprod, cantidad, tipo, ha, precio, codtipoa, nomtipoa, 'divproductos', '_propuestav2_loadproductos.php');
    agregarItemAlCarrito(trim($codigo), trim($cantidad), $tipoa, $ordenta, $precio, $congelado, $preciodcto, $factorbidon);
}

/* function addArrayUnidades2($codnut, $unidad, $orden, $factor) {
  $indice = array_search(trim($codnut), array_column($_SESSION['unidades'], trim('codnut')), false);
  if (strlen($indice) == '') {
  array_push($_SESSION['unidades'], array('codnut' => $codnut, 'unidad' => trim($unidad), 'orden' => $orden, 'factor'=>$factor));
  } else {
  $_SESSION['unidades'][$indice]['unidad'] = $unidad;
  $_SESSION['unidades'][$indice]['factor'] = $factor;
  }
  } */

function agregarItemAlCarrito($codigo, $cantidad, $tipoa, $ordenta, $precio, $congelado, $preciodcto, $factorb) {
    $obj = new C_Producto();
//OBTENER INFO DE PRODUCTOS
    $obj->__set('codigo', $codigo);
    $getproducto = $obj->getProdxPrecioByCod();

    if ($getproducto) {
        $catprod = $getproducto[0]['codcate'];
        $nomcate = $getproducto[0]['desele'];
        $codprod = $getproducto[0]['codigo'];
        $nomprod = $getproducto[0]['nombre'];
        $umedida = $getproducto[0]['umedida'];
        $orden = $getproducto[0]['orden'];

        $precioA = $getproducto[0]['precio'];
        $precioB = $getproducto[1]['precio'];
        $precioC = $getproducto[2]['precio'];
        $precioD = $getproducto[3]['precio'];
        $precioE = $getproducto[4]['precio'];

        $indice = array_search(trim($codprod), array_column($_SESSION['carrito'], trim('codprod')), false);

        if (strlen($indice) == '') {   // ME PASE HORAS INVESTIGANDO COMO HACER QUE EL CERO NO TE TOME COMO VACIO "". SOLUCION UTILIZAR = strlen
            array_push($_SESSION['carrito'], array('ordenta' => $ordenta, 'tipoa' => trim($tipoa), 'ordenprod' => $orden, 'catprod' => trim($catprod), 'nomcate' => trim($nomcate), 'codprod' => trim($codprod), 'nomprod' => $nomprod, 'umedida' => $umedida, 'precio' => $precio, 'preciodcto' => $preciodcto, 'precioA' => $precioA, 'precioB' => $precioB, 'precioC' => $precioC, 'precioD' => $precioD, 'precioE' => $precioE, 'congelado' => $congelado, 'cantidad' => $cantidad, 'factorb' => $factorb));
        } elseif (trim($_SESSION['carrito'][$indice]['ordenta']) == trim($ordenta)) {
            echo '<script>';
            echo 'alert("Este producto ya esta en el carrito. Se actualizara la cantidad y precio");';
            echo '</script>';
            $_SESSION['carrito'][$indice]['cantidad'] = $cantidad;
            $_SESSION['carrito'][$indice]['precio'] = $precio;
            $_SESSION['carrito'][$indice]['preciodcto'] = $preciodcto;
            $_SESSION['carrito'][$indice]['congelado'] = $congelado;
            $_SESSION['carrito'][$indice]['factorb'] = $factorb;
        } else {
            array_push($_SESSION['carrito'], array('ordenta' => $ordenta, 'tipoa' => trim($tipoa), 'ordenprod' => $orden, 'catprod' => trim($catprod), 'nomcate' => trim($nomcate), 'codprod' => trim($codprod), 'nomprod' => $nomprod, 'umedida' => $umedida, 'precio' => $precio, 'preciodcto' => $preciodcto, 'precioA' => $precioA, 'precioB' => $precioB, 'precioC' => $precioC, 'precioD' => $precioD, 'precioE' => $precioE, 'congelado' => $congelado, 'cantidad' => $cantidad, 'factorb' => $factorb));
        }
    }
}

function crearDespacho($ha, $arraycarrito) {
    $carritodesp = array();
    foreach ($arraycarrito as $carrito) {
//si el cod producto ya existe, aumentamos la cantidad.        
        $codprod = $carrito['codprod'];
        $litros = $carrito["cantidad"];
        $factorb = $carrito["factorb"];
        $litroxdist = ($litros / $factorb) * $ha;
        $bidon = ceil($litroxdist); //aqui redondea el bidon
        $litrosxbidon = $factorb * $bidon;
        $cantidad1 = $bidon;
        $cantidad2 = $litrosxbidon;
        $umedida1 = 'BD';
        $umedida2 = 'LT';
        $precio1 = $carrito['precio'];
        $precio2 = $carrito['preciodcto'];
        $ordendesp = $carrito['ordenprod'];
        $preciototal = $precio2 * $cantidad2;
        $indice = array_search(trim($codprod), array_column($carritodesp, trim('codprod')), false);
        if (strlen($indice) == '') {
            array_push($carritodesp, array('ordenprod' => $carrito['ordenprod'],
                'codprod' => trim($carrito['codprod']),
                'nomprod' => $carrito['nomprod'],
                'litros' => $litros,
                'cantidad1' => $cantidad1,
                'umedida1' => $umedida1,
                'cantidad2' => $cantidad2,
                'umedida2' => $umedida2,
                'precio1' => $precio1,
                'precio2' => $precio2,
                'preciototal' => $preciototal,
                'factorb' => $factorb,
                'ordendesp' => $ordendesp));
        } else {
            $litros_anterior = $carritodesp[$indice]['litros'];
            $litros_total = $litros + $litros_anterior;
            $litroxdist = ($litros_total / $factorb) * $ha;
            $bidon = ceil($litroxdist); //aqui redondea el bidon
            $litrosxbidon = $factorb * $bidon;
            $carritodesp[$indice]['cantidad1'] = $bidon;
            $carritodesp[$indice]['cantidad2'] = $litrosxbidon;
        }
    }
    return $carritodesp;
}

function ordenarCarrito($datos) {

    foreach ($datos as $clave => $fila) {
        $categoria[$clave] = $fila['ordenta'];
        $producto[$clave] = $fila['ordenprod'];
    }
    array_multisort($categoria, SORT_ASC, $producto, SORT_ASC, $datos);
    return $datos;
}

function removeItemCarrito($indice) {
    unset($_SESSION['carrito'][$indice]);
    $_SESSION['carrito'] = array_values($_SESSION['carrito']);
}

function limpiarCarrito() {
    unset($_SESSION['carrito']);
}

if ($_GET['cod3'] == 'ELIM') {
    $indice = $_GET['cod1'];
    $ha = $_GET['cod2'];
    $descuento = $_GET['cod4'];
    removeItemCarrito($indice);
    echo "<script>";
    echo "cargar('#divproductos', '_propuestav2_hapaq_detalle.php?cod1=none&cod2=none&cod3=none')";
    echo "</script>";
}

if ($_GET['cod3'] == 'LIMPIAR') {
    limpiarCarrito();
    echo "<script>";
    echo "cargar('#divproductos', '_propuestav2_hapaq_detalle.php?cod1=none&cod2=none&cod3=none')";
    echo "</script>";
}

if ($_GET['cod3'] == 'CREATEITEM') {
    if (!isset($_SESSION['car'])) {
        $_SESSION['car'] = array();
        $_SESSION['item'] = array();
    }

    $descuento = 0;
    $precioAMBT = 0;
    $fa = 0;


    array_push($_SESSION['car'], $_SESSION['carrito']);
    echo "<script>";
    echo 'var dcto = $("#dcto").val(); ';
    echo "cargar('#divexperimento', '_propuestav2_experimento.php?cod1='+dcto)";
    echo "</script>";
    limpiarCarrito();
}

function calcularFactorAprobacion($precioAMBT, $precioTotalE) {
    $x = ($precioAMBT - $precioTotalE);
    if ($precioTotalE > 0) {
        $fag = ($x / $precioTotalE) * 100; //Factor Aprobacion Gerencial
    } else {
        $fag = 0;
    }
    $fau = ($fag - 25); //Factor Aprobacion Usuario    
    return $fau;
}

function calcularPrecioSaldo($precioAMBT, $pcc, $pca) {

    $presaldo = 0;
    if ($pcc > 0) {
        $presaldo = ($pcc - $precioAMBT);
    } else {
        if ($pca > 0) {
            $presaldo = ($pca - $precioAMBT);
        }
    }
    return $presaldo;
}

function calcularPrecioAMBT($descuento, $preciorestado, $totalCongelado) {
    $dcto = (1 - ($descuento / 100));
    $precioAMBT = ($preciorestado * $dcto) + $totalCongelado;
    return $precioAMBT;
}
?>
<style>
    .inputpp, .inputppdesc { width: 60px; padding: 5px; }
    .inputppprec { width: 100px; padding: 5px; }
    .inputppdesc {background-color: #ffeca1;}
    .tabladcto { width: 450px; font-size: smaller; }
    .tabladcto td { padding: 2px;}
</style>
<script>

</script>
<h4><img src="img/iconos/add-car.png" height="20px" /> Carrito de Productos</h4>
<div class="row" id="divcarrito">
    <div class="col-xs-12">


        <?php
        if ($pup == 'indefinido') {

            $costo_total = 0;
            $costo_totalA = 0;
            $costo_totalE = 0;
            $costo_congelado = 0;
            $ltxha = 0;


            $precio_total = 0;
            $precio_totalcongelado = 0;
            $precio_totalA = 0;
            $precio_totalB = 0;
            $precio_totalC = 0;
            $precio_totalD = 0;
            $precio_totalE = 0;

//                    $arrr = ordenarCarrito($carrito);
//                    $carrito = $arrr;
            $ncarrito = 0;
            if (isset($_SESSION['carrito'])) {
                $ncarrito = count($_SESSION['carrito']);
            }

            if ($ncarrito > 0) {
                $indice = 0;
                foreach ($_SESSION['carrito'] as $producto) {

                    $codprod = $producto['codprod'];
                    $ltxha = ($producto['cantidad'] * $ha);

                    $costo_total = $ltxha * $producto['precio'];
                    $costo_total_dcto = $ltxha * $producto['preciodcto'];


                    $costo_totalA = $producto['precioA'] * $ltxha;
                    $costo_totalE = $producto['precioE'] * $ltxha;

                    $precio_total+= $costo_total;
                    $precio_totalA += $costo_totalA;
                    $precio_totalE += $costo_totalE;

                    if ($producto['congelado'] == 'T') {
                        $costo_congelado = $producto['preciodcto'] * $ltxha;
                        $precio_totalcongelado+= $costo_congelado;
                    }
                    ?>
                    <table border='1' style="width: 80%; font-size: 0.9em">
                        <thead>
                            <tr style="background-color: #dcdcdc; padding: 10px;">
                                <td style="padding: 5px; font-weight: bolder; text-align: center;">Productos HUMA GRO</td>                                    
                                <th style="text-align: center;">Litros/Ha</th>
                                <th style="text-align: center;">Litros para <?php echo $ha; ?> ha</th>
                                <th style="text-align: center;">Precio Unit</th>                            
                                <th style="text-align: center;">Precio Unit Dcto</th>                            
                                <th style="text-align: center;">Precio Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>                                    
                                <td><?php echo $producto['nomprod']; ?></td>
                                <td style="text-align: center;"><?php echo number_format($producto['cantidad'], 2); ?></td>
                                <td style="text-align: center;"><?php echo number_format($ltxha, 2); ?></td>
                                <td style="text-align: center;">$ <?php echo $producto['precio']; ?></td>
                                <td style="text-align: center;">$ <?php echo $producto['preciodcto']; ?></td>
                                <td style="text-align: center;">$<?php echo number_format($costo_total, 2); ?></td>
                                <td>
                                    <a class="btn btn-default" href="javascript:cargar('#divproductos', '_propuestav2_hapaq_detalle.php?cod1=<?php echo trim($indice); ?>&cod2=<?php echo trim($ha); ?>&cod3=ELIM&cod4=<?php echo trim($descuento); ?>')" title="Eliminar"><img src="img/iconos/trash.png" height="15" /></a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="1" style="border-left: 0px;"></td>
                                <td colspan="3" style="text-align: center; font-style: italic;">HUMA GRO Precio con descuento</td>
                                <td style="text-align: center; font-weight: bolder;">TOTAL</td>
                                <td style="text-align: center;;">$<?php echo number_format($costo_total_dcto, 2); ?></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                    <br/>
                    <br/>
                    <?php
                    $indice++;
                }
            } else {
                echo '<tr style="color:red"><td colspan=9>El carrito está vacio.</td></tr>';
            }
            //FIN DE PRECIO UNITARIO CON DESCUENTO POR PRODUCTO
        } else {
            ?>

            <table class="table table-striped" style="width: 80%; font-size: 0.8em">
                <thead>
                    <tr style="background-color: #ffeca1">
                        <th>TIPO APLICACIÓN</th>
                        <th>PRODUCTO</th>                                                
                        <th style="text-align: right;">Litros/Ha</th>
                        <th style="text-align: right;">Litros para <?php echo $ha; ?> ha</th>
                        <th style="text-align: right;">Precio Unit</th>
                        <?php if ($pud == 't') { ?>
                            <th style="text-align: right;">Precio Unit Dcto</th>
                        <?php } ?>
                        <th style="text-align: right;">Precio Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $costo_total = 0;
                    $costo_totalA = 0;
                    $costo_totalE = 0;
                    $costo_congelado = 0;
                    $ltxha = 0;


                    $precio_total = 0;
                    $precio_totalcongelado = 0;
                    $precio_totalA = 0;
                    $precio_totalB = 0;
                    $precio_totalC = 0;
                    $precio_totalD = 0;
                    $precio_totalE = 0;

//                    $arrr = ordenarCarrito($carrito);
//                    $carrito = $arrr;
                    $ncarrito = 0;
                    if (isset($_SESSION['carrito'])) {
                        $ncarrito = count($_SESSION['carrito']);
                    }

                    if ($ncarrito > 0) {
                        $indice = 0;
                        foreach ($_SESSION['carrito'] as $producto) {

                            $codprod = $producto['codprod'];
                            $ltxha = ($producto['cantidad'] * $ha);


                            if ($pud == 't') {
                                $costo_total = $ltxha * $producto['preciodcto'];
                            } else {
                                $costo_total = $ltxha * $producto['precio'];
                            }

                            $costo_totalA = $producto['precioA'] * $ltxha;
                            $costo_totalE = $producto['precioE'] * $ltxha;

                            $precio_total+= $costo_total;
                            $precio_totalA += $costo_totalA;
                            $precio_totalE += $costo_totalE;

                            if ($producto['congelado'] == 'T') {
                                $costo_congelado = $producto['preciodcto'] * $ltxha;
                                $precio_totalcongelado+= $costo_congelado;
                            }
                            ?>
                            <tr>
                                <td><?php
                                    if ($indice > 0) {
                                        $indiceant = $indice - 1;
                                        if ($_SESSION['carrito'][$indice]['tipoa'] <> $_SESSION['carrito'][$indiceant]['tipoa']) {
                                            echo $producto['tipoa'];
                                        }
                                    } else {
                                        echo $producto['tipoa'];
                                    }
                                    ?>
                                </td>
                                <td><?php
                                    echo $producto['nomprod'];
                                    if ($producto['congelado'] == 'T') {
                                        echo '*';
                                    }
                                    ?></td>                                
                                <td style="text-align: right;"><?php echo number_format($producto['cantidad'], 2); ?></td>
                                <td style="text-align: right;"><?php echo number_format($ltxha, 2); ?></td>
                                <td style="text-align: right;">$ <?php echo $producto['precio']; ?></td>
                                <?php if ($pud == 't') { ?>
                                    <td style="text-align: right;">$ <?php echo $producto['preciodcto']; ?></td>
                                <?php } ?>
                                <td style="text-align: right; font-weight: bold;">$<?php echo number_format($costo_total, 2); ?></td>                                
                                <td>
                                    <a class="btn btn-default" href="javascript:cargar('#divproductos', '_propuestav2_hapaq_detalle.php?cod1=<?php echo trim($indice); ?>&cod2=<?php echo trim($ha); ?>&cod3=ELIM&cod4=<?php echo trim($descuento); ?>')" title="Eliminar"><img src="img/iconos/trash.png" height="15" /></a>
                                </td>
                            </tr>
                            <?php
                            $indice++;
                        }
                    } else {
                        echo '<tr style="color:red"><td colspan=9>El carrito está vacio.</td></tr>';
                    }

                    if ($pud == 'f') {
                        ?>
                        <tr style="background-color: #dcdcdc">
                            <td colspan="4"></td>
                            <td style="text-align: right; font-weight: bold;">Sub Total</td>
                            <td style="text-align: right; font-weight: bold; color: blue;">$ <?php echo number_format($precio_total, 2); ?></td>
                            <td></td>
                        </tr>
                        <?php
                    }
                    $preciorestado = ($precio_total - $precio_totalcongelado);
                    if ($pud == 't') {
                        $precioAMBT = calcularPrecioAMBT(0, $preciorestado, $precio_totalcongelado);
                    } else {
                        $precioAMBT = calcularPrecioAMBT($descuento, $preciorestado, $precio_totalcongelado);
                    }
//($precio_total * (100 - ($descuento))) / 100; 
                    ?>                                                
                    <tr>
                        <?php
                        if ($pud == 't') {
                            echo '<td colspan="2"></td>';
                        } else {
                            echo '<td colspan="1"></td>';
                        }
                        ?>
                        <td colspan="3" style="text-align: right; font-weight: bold;">HUMA GRO Precio con descuento para <?php echo $ha; ?> Ha.</td>
                        <td colspan="1" style="text-align: right; font-weight: bold;">Total</td>
                        <td style="text-align: right; font-weight: bold; color: blue;">$ <span id="phgdcto"><?php echo number_format($precioAMBT, 2); ?></span></td>                                                
                        <td></td>
                    </tr>
                    <?php
                    if ($ha >= 1) {
                        $precxha = $precioAMBT / $ha;
                        ?> 
                        <tr>
                            <?php
                            if ($pud == 't') {
                                echo '<td colspan="4"></td>';
                            } else {
                                echo '<td colspan="3"></td>';
                            }
                            ?>
                            <td colspan="2" style="text-align: right;">Huma Gro precio con Descuento/Ha</td>                        
                            <td style="text-align: right;">$<?php echo number_format($precxha, 2); ?></td>
                            <td></td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>             
        </div>

        <?php
        $_SESSION['carritodesp'] = array();
        $_SESSION['carritodesp'] = crearDespacho($ha, $_SESSION['carrito']);
        ?>

        <div class="col-lg-12">
            <p>DESPACHO: Redondeo a Bidones</p>            
            <table class="table table-striped" style="width: 80%; font-size: 0.8em">
                <thead>
                    <tr style="background-color: #ccff99">                        
                        <th>PRODUCTOS HUMA GRO</th>                                                
                        <th style="text-align: right;">Bidones</th>
                        <th style="text-align: right;">Litros</th>
                        <th style="text-align: right;">Precio Unit</th>
                        <?php if ($pud == 't') { ?>
                            <th style="text-align: right;">Precio Unit Dscto</th>
                        <?php } ?>
                        <th style="text-align: right;">Precio Total</th>                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $precio_total_desp = 0;
                    $ptotal_desp = 0;
                    $ncarritodesp = 0;

                    if (isset($_SESSION['carritodesp'])) {
                        $ncarritodesp = count($_SESSION['carritodesp']);
                    }
                    if ($ncarritodesp > 0) {

                        foreach ($_SESSION['carritodesp'] as $productodesp) {
                            //array_push($_SESSION['carritodesp'], array('ordenprod' => $orden, 'codprod' => trim($codprod), 'nomprod' => $nomprod, 'cantidad1' => $cantidad1, 'umedida1' => $umedida1, 'cantidad2' => $cantidad2, 'umedida2' => $umedida2, 'precio1' => $precio1, 'precio2' => $precio2, 'congelado' => $congelado));
                            $nomproducto = $productodesp['nomprod'];
                            $bidones = $productodesp['cantidad1']; //bidones
                            $litrosdesp = $productodesp['cantidad2']; //litros
                            $precio1 = $productodesp['precio1']; //precio unitario
                            $precio2 = $productodesp['precio2']; // precio unitario con descuento

                            if ($pud == 't') {
                                $ptotal_desp = $litrosdesp * $precio2; //total litros * precio descuento unitario, el precio unitario descuento puede ser el mismo que el precio unitario.                            
                            } else {
                                $ptotal_desp = $litrosdesp * $precio1;
                            }
                            //$ptotal_desp = $litrosdesp * $precio2;  
                            $precio_total_desp+= $ptotal_desp;

                            //******* Aplicando Asteriscos
                            $asterisco = '**';
                            if ($productodesp['factorb'] == '9.46') {
                                $asterisco = '*';
                            }
                            ?>
                            <tr>                                
                                <td><?php echo $nomproducto . ' ' . $asterisco; ?></td>
                                <td style="text-align: right;"><?php echo number_format($bidones, 2); ?></td>
                                <td style="text-align: right;"><?php echo number_format($litrosdesp, 2); ?></td>
                                <?php if ($pud == 't') { ?>
                                    <td style="text-align: right;">$ <?php echo number_format($precio1, 2); ?></td>
                                    <td style="text-align: right;">$ <?php echo number_format($precio2, 2); ?></td>
                                <?php } else { ?>
                                    <td style="text-align: right;">$ <?php echo number_format($precio1, 2); ?></td>
                                <?php } ?>
                                <td style="text-align: right; font-weight: bold;">$<?php echo number_format($ptotal_desp, 2); ?></td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo '<tr style="color:red"><td colspan=9>El carrito está vacio.</td></tr>';
                    }

                    if ($pud == 'f') {
                        ?>
                        <tr>
                            <td colspan="1"></td>
                            <td colspan="2" style="text-align: right; font-weight: bold;"></td>
                            <td colspan="1" style="text-align: right; font-weight: bold;">Sub Total</td>
                            <td style="text-align: right; font-weight: bold;">$ <?php echo number_format($precio_total_desp, 2); ?></td>                        
                        </tr> 
                        <?php
                    }
                    $preciorestado2 = ($precio_total_desp - $precio_totalcongelado);

                    if ($pud == 't') {
                        $precioAMBT2 = calcularPrecioAMBT(0, $preciorestado2, $precio_totalcongelado);
                    } else {
                        $precioAMBT2 = calcularPrecioAMBT($descuento, $preciorestado2, $precio_totalcongelado);
                    }
                    ?>
                    <tr>
                        <?php if ($pud == 't') { ?>
                            <td></td>
                        <?php } ?>
                        <td colspan="1"></td>
                        <td colspan="2" style="text-align: right; font-weight: bold;">HUMA GRO Precio con descuento para <?php echo $ha ?> Has.</td>
                        <td colspan="1" style="text-align: right; font-weight: bold;">Total</td>
                        <td style="text-align: right; font-weight: bold; color: blue;">$ <?php echo number_format($precioAMBT2, 2); ?></td>                        
                    </tr> 
                    <?php
                    $igv = 0;
                    if ($incluyeigv == 't') {
                        $igv = ($precioAMBT2 * $valigv) / 100;
                        $pagototal = $precioAMBT2 + $igv;
                        ?>

                        <?php if ($pud == 't') { ?>
                        <td></td>
                    <?php } ?>
                    <td colspan="3"></td>                        
                    <td style="text-align: right; font-weight: bold;">IGV</td>
                    <td style="text-align: right; font-weight: bold;"><?php echo number_format($igv, 2); ?></td>

                    <tr>
                        <?php if ($pud == 't') { ?>
                            <td></td>
                        <?php } ?>
                        <td colspan="3"></td>                        
                        <td style="text-align: right; font-weight: bold;">Total por Pagar</td>
                        <td style="text-align: right; font-weight: bold;"><?php echo number_format($pagototal, 2); ?></td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
            <p>
                (*) Bidon de 9.46 Litros.<br/>
                (**) Bidon de 10 Litros.
            </p>
        <?php } ?>
    </div>
</div>
<div class="row" style="text-align: right">
    <div class="col-lg-12" style="text-align: right">            
        <a class="btn btn-default btn-sm" href="javascript:cargar('#divproductos', '_propuestav2_hapaq_detalle.php?cod1=none&cod2=none&cod3=LIMPIAR')" title="Limpiar">Limpiar Carrito</a>
        <!--<a href="#" class="btn btn-default btn-sm">Actualizar</a>-->
    </div>
</div>
<div class="row" style="">
    <div class="col-lg-12">    
        <?php
        $factorAprobacion = calcularFactorAprobacion($precioAMBT, $precio_totalE);
        $dif_preambt_conv = calcularPrecioSaldo($precioAMBT, $pcc, $pca);
        ?>
        <div class="row">
            <div class="col-md-4">
                <h4 style="color: blue;">Factor de Aprobación:</h4>
            </div>
            <div class="col-md-3" style="background-color: yellow;">
                <?php if ($factorAprobacion < 40) { ?>
                    <h4 style="color: red"><?php echo number_format($factorAprobacion, 2); ?></h4>
                <?php } else { ?>
                    <h4 style="color: green;"><?php echo number_format($factorAprobacion, 2); ?></h4>
                <?php } ?>
                <input type="hidden" id="factor" name="factor" value="<?php echo $factorAprobacion; ?>" />            
            </div>
        </div>

        <div class="row"><div class="col-md-4">Descuento:</div><div class="col-md-3"><?php echo $descuento; ?></div></div>
        <div class="row"><div class="col-md-4">Monto Congelado:</div><div class="col-md-3"> <?php echo number_format($precio_totalcongelado, 2); ?></div></div>
        <!--            <div class="row"><div class="col-md-3">Diferencia (Monto Total - Monto Congelado):</div><div class="col-md-3"> 
        <?php
//$dif_mt_mc = ($precio_total - $precio_totalcongelado);
//echo number_format($dif_mt_mc, 2);
        ?></div>
                    </div>-->
        <input type="hidden" id="preambt" name="preambt" value="<?php echo $precioAMBT; ?>" min="0" step="any" />
        <div class="row"><div class="col-md-4">Diferencia (Convencional - Precio HUMA GRO):</div><div class="col-md-3"> <?php echo number_format($dif_preambt_conv, 2); ?></div></div>
    </div>            
</div>
<div class="row" >
    <div class="col-lg-12" style="text-align: right;">
        <a class="btn btn-primary" href="javascript:crearItemHa()" title="Crear">Guardar Item</a>
    </div>
</div>