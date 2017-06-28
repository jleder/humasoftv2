<?php
$modo = $_GET['cod1'];
$pup = '';


if ($modo == 'carga') {
    $array_carrito = $_SESSION['car_update'];
    $array_unidad = $_SESSION['und_update'];
    $array_cardesp = $_SESSION['cardesp_update'];
    $variables = $_GET['cod2'];

    //Obtener Variables
    $posicion = $variables[0];
    $descuento = $variables[1];
    $pca = $variables[2];
    $pcc = $variables[3];
    $ha = $variables[4];
    $nitrogeno = $variables[5];
    $pud = $variables[6];
    $incluyeigv = $variables[7];
    $valigv = $variables[8];
} elseif ($modo == 'producto_add_byunidad') {
    session_start();
    include '../controller/C_ActualizarItemPropuesta.php';
    $prod = new C_Producto();
    $prop = new C_Propuesta();
    $array_carrito = $_SESSION['car_update'];
    $array_unidad = $_SESSION['und_update'];
    $array_cardesp = $_SESSION['cardesp_update'];
    //Obtener Parametros
    $getvariables = $_GET['cod2'];
    $getunidades = $_GET['cod3'];
    $getfc = $_GET['cod4'];  //factores de conversion
    $getprecio = $_GET['cod5'];  //precios 60
    $getcong = $_GET['cod6'];  //congelado
    $getbidones = $_GET['cod7'];  //bidones    
    //
    //Conversion en Arreglos
    $variables = explode(',', $getvariables);
    $unidades = explode(',', $getunidades);
    $factores = explode(',', $getfc);
    $factorbidon = explode(',', $getbidones);
    $precio60 = explode(',', $getprecio);
    $congelar = explode(',', $getcong);

    //Obtener variables        
    $posicion = $variables[0];
    $descuento = $variables[1];
    $pca = $variables[2];
    $pcc = $variables[3];
    $ha = $variables[4];
    $nitrogeno = $variables[5];
    $pud = $variables[6];
    $incluyeigv = $variables[7];
    $valigv = $variables[8];
    $tipoa = 'FERTIRRIEGO'; //tipo de aplicación
    $ordenta = '00';


    //$pup = $variables[10]; tener en cuenta esta variable    

    $nt = array('N', 'P', 'K', 'Ca', 'Mg', 'S', 'B', 'Co', 'Cu', 'Fe', 'Mn', 'Mo', 'Si', 'Zn'); //array de nutrientes
    $ncant = count($unidades);

    for ($i = 0; $i < $ncant; $i++) {
        if ($unidades[$i] > 0) {
            //Aqui creamos sesion para las unidades.
            $array_unidad = $prod->addArrayUnidades($array_unidad, $nt[$i], $unidades[$i], $i, $factores[$i]);
            $prod->__set('inicial', trim($nt[$i]));
            $getproducto = $prod->getProductoByNut();
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
                $preciodcto = leerPrecioDcto($congelado, $descuento, $precio, $precio60[$i]);
                $array_carrito = $prop->agregarProductoAlCarrito($array_carrito, $codprod, $litros, $tipoa, $ordenta, $precio, $congelado, $preciodcto, $factorbidon[$i]);
            }
        }
    }
    //mostrarArreglo($carrito);
} elseif ($modo == 'producto_add_byproduct') {
    session_start();
    include '../controller/C_ActualizarItemPropuesta.php';
    $prod = new C_Producto();
    $prop = new C_Propuesta();
    $array_carrito = $_SESSION['car_update'];
    $array_unidad = $_SESSION['und_update'];
    $array_cardesp = $_SESSION['cardesp_update'];
    //Obtener Parametros
    $getvar_item = $_GET['cod2'];    
    $getvar_prod = $_GET['cod3'];
    
    //Conversion en Arreglos
    $var_item = explode(',', $getvar_item);
    $var_prod = explode(',', $getvar_prod);
    
    //Obtener variables            
    $descuento = $var_item[0];
    $pcc = $var_item[1];
    $pca = $var_item[2];
    $ha = $var_item[3];    
    $pud = $var_item[4];
    $incluyeigv = $var_item[5];
    $valigv = $var_item[6];
    $pup = $var_item[7];        
    
    $ordenta = $var_prod[0];
    $tipoa = $var_prod[1];
    $codprod = $var_prod[2];
    $precio = $var_prod[3];
    $preciodcto = $var_prod[4];    
    $congelado = $var_prod[5];    
    $litros = $var_prod[6];    
    $factorbidon = $var_prod[7];    
    $array_carrito = $prop->agregarProductoAlCarrito($array_carrito, $codprod, $litros, $tipoa, $ordenta, $precio, $congelado, $preciodcto, $factorbidon);    
    
} elseif ($modo == 'producto_delete') {
    session_start();
    include '../controller/C_ActualizarItemPropuesta.php';
    $prod = new C_Producto();
    $indice_elim = $_GET['cod2'];

    $array_item = $_SESSION['item_update'];
    $array_unidad_temp = $_SESSION['und_update'];
    $array_carrito_temp = $_SESSION['car_update'];
    $array_cardesp_temp = $_SESSION['cardesp_update'];
    $rowarray_unidad = count($array_unidad_temp);

    $descuento = $array_item[0];
    $pcc = $array_item[1];
    $pca = $array_item[2];
    $ha = $array_item[5];
    $nitrogeno = $array_item[6];
    $pud = $array_item[8];
    $incluyeigv = $array_item[11];
    $valigv = $array_item[12];

    $array_carrito = $prod->removeItemArray($indice_elim, $array_carrito_temp);
    $array_cardesp = $prod->removeItemArray($indice_elim, $array_cardesp_temp);
    if ($rowarray_unidad > 0) {
        if ($indice_elim <= $rowarray_unidad) {
            $array_unidad = $prod->removeItemArray($indice_elim, $array_unidad_temp);
        }
    }
}
?>    
<div class="row" id="divcarrito">
    <div class="col-lg-12">        
        <?php
        echo 'Descuento: ' . $descuento;
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
        <table class="table table-striped" style="width: 80%; font-size: 0.8em">
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
                                    <a class="btn btn-default" href="javascript:cargar('#divproductos_update', '_propuestav2_hapaq_detalle_10.php?cod1=producto_delete&cod2=<?php echo trim($indice); ?>')" title="Eliminar"><img src="img/iconos/trash.png" height="15" /></a>
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
                    $ncarrito = $array_carrito;
                    if ($ncarrito > 0) {
                        $indice = 0;
                        foreach ($array_carrito as $producto) {

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
                                        if ($array_carrito[$indice]['tipoa'] <> $array_carrito[$indiceant]['tipoa']) {
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
                                    <a class="btn btn-default" href="javascript:cargar('#divproductos_update', '_propuestav2_hapaq_detalle_10.php?cod1=producto_delete&cod2=<?php echo trim($indice); ?>')" title="Eliminar"><img src="img/iconos/trash.png" height="15" /></a>
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
                        $precioAMBT = $prod->calcularPrecioAMBT(0, $preciorestado, $precio_totalcongelado);
                    } else {
                        $precioAMBT = $prod->calcularPrecioAMBT($descuento, $preciorestado, $precio_totalcongelado);
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
        $array_cardesp = $prod->crearDespacho($ha, $array_carrito);
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
                    $ncarritodesp = count($array_cardesp);

                    if ($ncarritodesp > 0) {

                        foreach ($array_cardesp as $productodesp) {
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
                        $precioAMBT2 = $prod->calcularPrecioAMBT(0, $preciorestado2, $precio_totalcongelado);
                    } else {
                        $precioAMBT2 = $prod->calcularPrecioAMBT($descuento, $preciorestado2, $precio_totalcongelado);
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
            <?php
        }
        $_SESSION['car_update'] = $array_carrito;
        $_SESSION['cardesp_update'] = $array_cardesp;
        $_SESSION['und_update'] = $array_unidad;
        ?>
    </div>
</div>
<div class="row" style="">
    <div class="col-lg-12">    
        <?php
        $factorAprobacion = $prod->calcularFactorAprobacion($precioAMBT, $precio_totalE);
        $dif_preambt_conv = $prod->calcularPrecioSaldo($precioAMBT, $pcc, $pca);
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
                <input type="hidden" id="factor_update" name="factor_update" value="<?php echo $factorAprobacion; ?>" />            
            </div>
        </div>

        <div class="row"><div class="col-md-4">Descuento:</div><div class="col-md-3"><?php echo $descuento; ?></div></div>
        <div class="row"><div class="col-md-4">Monto Congelado:</div><div class="col-md-3"> <?php echo number_format($precio_totalcongelado, 2); ?></div></div>
        <input type="hidden" id="preambt_update" name="preambt_update" value="<?php echo $precioAMBT; ?>" min="0" step="any" />
        <div class="row"><div class="col-md-4">Diferencia (Convencional - Precio HUMA GRO):</div><div class="col-md-3"> <?php echo number_format($dif_preambt_conv, 2); ?></div></div>
    </div>
    </

    <br/>        
</div>
<?php

//Funciones de esta Pagina
function mostrarArreglo($array) {
    echo '<pre>';
    print_r($array);
    echo '</pre>';
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
