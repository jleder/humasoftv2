<?php
include '../controller/C_Solicitud.php';
$obj = new C_Propuesta();
//session_start();

if (!isset($_SESSION['car'])) {
    $_SESSION['car'] = array();
    $_SESSION['item'] = array();
    $_SESSION['und'] = array();
    $_SESSION['cardesp'] = array();
    $_SESSION['propuesta'] = array();
}

//CONDICION: SI 
if (isset($_GET['cod1'])) {

    $carritoordenado = ordenarCarrito($_SESSION['carrito']);
    $varitem = $_GET['cod1'];
    $itemdesc = $_GET['cod2'];
    $prop = $_GET['cod3'];

//Creando Arreglos Previos
    $itemdet = explode(',', $varitem);
    $_SESSION['propuesta'] = explode(',', $prop);
    $itemdet[14] = $itemdesc;
    $varpup = $itemdet[13]; //Si hay precio unitario producto PUP;

    //Creando item PUP (Producto Precio Unitario)
    if ($varpup == 't') {
        $carritopup = array();
        $item_pup = $itemdet;
        $item_pup[14] = $_GET['cod4'];
        foreach ($carritoordenado as $valor) {
            //Obtener Precio
            $codprod = $valor['codprod'];
            $obj->__set('codprod', $codprod);
            $getpreciodcto = $obj->obtenerPrecioDctoPUP();
            $preciodcto = $getpreciodcto[2];
            //Crear Carrito PUP
            $carritopup = $obj->agregarProductoAlCarrito($carritopup, $codprod, $valor['cantidad'], $valor['tipoa'], $valor['ordenta'], $valor['precio'], $valor['congelado'], $preciodcto, $valor['factorb']);
        }
        //Para terminar, decimos que la opcion 1.b no es pup;
        $itemdet[13] = 'f'; //declaramos pup como falso
        array_push($_SESSION['car'], $carritopup);
        array_push($_SESSION['item'], $item_pup);
        array_push($_SESSION['cardesp'], $_SESSION['carritodesp']);

        if (isset($_SESSION['unidades'])) {
            if (count($_SESSION['unidades']) > 0) {
                $unidadordenado = ordenarUnidades($_SESSION['unidades']);
                array_push($_SESSION['und'], $unidadordenado);
            } else {
                array_push($_SESSION['und'], NULL);
            }
        } else {
            array_push($_SESSION['und'], NULL);
        }
    }

    //Proceso Core
    //Crear Arreglos de los Arreglos Previos de Guardar Item
    if (isset($_SESSION['unidades'])) {
        if (count($_SESSION['unidades']) > 0) {
            $unidadordenado = ordenarUnidades($_SESSION['unidades']);
            array_push($_SESSION['und'], $unidadordenado);
        } else {
            array_push($_SESSION['und'], NULL);
        }
    } else {
        array_push($_SESSION['und'], NULL);
    }
    array_push($_SESSION['car'], $carritoordenado);
    array_push($_SESSION['item'], $itemdet);
    array_push($_SESSION['cardesp'], $_SESSION['carritodesp']);
}




?>
<style>
    .mas {float: left; text-align: center; min-height: 45px; display: flex; align-items: center; margin-left: 3px; margin-right: 3px;}
    .cuadrito { font-size: 0.9em; text-align: center; width: auto; min-height: 45px; height: auto; background-color: #e8e8e8; padding: 5px 3px 5px 3px; margin-left: 5px; margin-right: 5px; float: left; display: flex; align-items: center; border-color: #000000; border-style: ridge; border-width: 1px; }
    .cuadront { float: left; min-height: 45px;}
    .cuadrito2 { font-size: 0.9em; text-align: center; border-style: double; border-width: 1px; border-color: #000; padding: 3px; }
</style>
<script>
    function editarItem() {
        var result = validar();
        var elemento = document.getElementById("cargatab2");
        var cliente = $("#combobox").val();
        var res_cliente = cliente.split("|");
        var codcli = res_cliente[0];
        if (result === false) {
            elemento.href = "#tab1";
        } else {
            from_unico(codcli, 'divfactor', '_propuestav2_loadfactor.php');
            elemento.href = "#tab2";
        }
    }

</script>

<?php
if (count($_SESSION['car']) > 0 && count($_SESSION['item']) > 0) {

    $contador = count($_SESSION['item']);
    $vectoritem = $_SESSION['item'];
    $vectorcarr = $_SESSION['car'];
    $propuesta = $_SESSION['propuesta'];
    ?>
    <table style="font-size: 11px;">
        <tr>
            <td style="width: 200px;">Codigo de Propuesta</td>
            <td><?php echo $propuesta[0]; ?></td>
        </tr>
        <tr>
            <td style="width: 200px;">Cliente</td>
            <td><?php echo $propuesta[1]; ?></td>
        </tr>
        <tr>
            <td style="width: 200px;">Contacto</td>
            <td><?php echo $propuesta[2]; ?></td>
        </tr>    
    </table>
    <?php
//    echo '<pre>';
//    print_r($_SESSION['und']);
//    echo '</pre>';
//RECORRER ITEMS
    for ($i = 0; $i < $contador; $i++) {

        $tipoprop = $vectoritem[$i][7];

        $item_dscto = $vectoritem[$i][0];
        $pcc = $vectoritem[$i][1];
        $pca = $vectoritem[$i][2];
        $ha = $vectoritem[$i][5];
        $pud = $vectoritem[$i][8];
        $pup = $vectoritem[$i][13];
//        echo '<pre>';
//        print_r($vectoritem);
//        echo '</pre>';
        
        //echo $pud;

        if ($tipoprop == "HECTAREA PAQ") {

            if ($pup == 't') {

                echo '<hr/>';
                echo '<p class="alert alert-success">' . $vectoritem[$i][14] . '</p>';
                echo '<div style="clear: both;"></div>';
                echo '<br/>';
                echo '<p>Análisis Económico:</p>';

                $precio_total = 0;
                $precio_totalA = 0;
                $precio_totalE = 0;

                foreach ($vectorcarr[$i] as $producto) {

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
                                    <!--<a class="btn btn-default" href="javascript:cargar('#divproductos', '_propuestav2_hapaq_detalle.php?cod1=<?php echo trim($indice); ?>&cod2=<?php echo trim($ha); ?>&cod3=ELIM&cod4=<?php echo trim($descuento); ?>')" title="Eliminar"><img src="img/iconos/trash.png" height="15" /></a>-->
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
                }
                //FIN DE PRECIO UNITARIO CON DESCUENTO POR PRODUCTO
            } else {

                echo '<hr/>';
                echo '<p class="alert alert-success">' . $vectoritem[$i][14] . '</p>';
                echo '<p class="">Descuento: ' . $vectoritem[$i][0] . '</p>';
                echo '<p class="">Precio Convencional Confirmado: ' . $vectoritem[$i][1] . '</p>';
                echo '<p class="">Precio Convencional Aproximado: ' . $vectoritem[$i][2] . '</p>';
                echo '<p class="">Hectareas: ' . $vectoritem[$i][5] . '</p>';
                echo '<p class="">Incluye Nitrogeno: ' . $vectoritem[$i][6] . '</p>';
                echo '<p class="">Es precio PUD: ' . $vectoritem[$i][8] . '</p>';
                echo '<p class="">Estado de Item: ' . $vectoritem[$i][9] . '</p>';
                echo '<p class="">Incluye IGV: ' . $vectoritem[$i][11] . '</p>';
                
                $aplicaciones = array_unique(array_column($vectorcarr[$i], 'tipoa'));
                //Mostrando los tipos de aplicaciones
                $nitrogeno = $vectoritem[$i][6];
                $napp = 0;

                $nunidades = count($_SESSION['und']);
                if ($nunidades > 0) {
                    $vectorund = $_SESSION['und'];
                    $cantvectorund = count($vectorund[$i]);                                        
                }                

                foreach ($aplicaciones as $app) {
                    $nomapp = $app;
                    $novo_texto = wordwrap($nomapp, 10, "<br />\n");
                    //echo "$novo_texto\n";
                    if ($napp == 0) {
                        if ($novo_texto == trim('FERTIRRIEGO')) {
                            if ($nunidades > 0) {
                                if ($cantvectorund > 0) {
                                    foreach ($vectorund[$i] as $valund) {
                                        if ($valund['codnut'] == 'N' && $nitrogeno == 'no') {
                                            echo '<div class="cuadront"><div class="cuadrito2"><strong>' . $valund['codnut'] . '</strong></div><div class="cuadrito2">' . $valund['unidad'] . '</div></div>';
                                            echo '<div class="mas">/</div>';
                                        } elseif ($valund['codnut'] == 'N' && $nitrogeno == '50') {
                                            echo '<div class="cuadront"><div class="cuadrito2"><strong>' . $valund['codnut'] . '</strong></div><div class="cuadrito2">' . $valund['unidad'] . '</div></div>';
                                            echo '<div class="mas">50%</div>';
                                        } elseif ($valund['codnut'] == 'N' && $nitrogeno == 'si') {
                                            echo '<div class="cuadront"><div class="cuadrito2"><strong>' . $valund['codnut'] . '</strong></div><div class="cuadrito2">' . $valund['unidad'] . '</div></div>';
                                        } elseif ($valund['codnut'] <> 'N') {
                                            echo '<div class="cuadront"><div class="cuadrito2"><strong>' . $valund['codnut'] . '</strong></div><div class="cuadrito2">' . $valund['unidad'] . '</div></div>';
                                        }
                                    }
                                }
                            }
                        } else {
                            echo '<div class="cuadrito">' . $novo_texto . '</div>';
                        }
                    } else {
                        echo '<div class="mas">+</div><div class="cuadrito">' . $novo_texto . '</div>';
                    }
                    $napp++;
                }
                ?>
                <div style="clear: both;"></div>
                <br/>

                <p>Análisis Económico:</p>
                <table class="table table-striped" style="font-size: 10px">
                    <thead>
                        <tr style="background-color: #ffeca1">
                            <th>TIPO APLICACIÓN</th>
                            <th>PRODUCTO</th>                                                
                            <th style="text-align: right;">Litros/Ha</th>
                            <th style="text-align: right;">Litros para <?php echo $vectoritem[$i][5]; ?> ha</th>
                            <th style="text-align: right;">Precio Unit.</th>
                            <?php if ($pud == 't') { ?>
                                <th style="text-align: right;">Precio Unit Dcto</th>
                            <?php } ?>
                            <th style="text-align: right;">Precio Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total_general = 0;
                        $indice = 0;
                        foreach ($vectorcarr[$i] as $productos) {
                            $ltxha = $productos['cantidad'] * $vectoritem[$i][5];
                            if ($pud == 'f') {
                                $precio_total = $ltxha * $productos['precio'];
                            } else {
                                $precio_total = $ltxha * $productos['preciodcto'];
                            }
                            $total_general+=$precio_total;
                            ?>
                            <tr>
                                <td>                            
                                    <?php
                                    //Algoritmo para mostrar Tipo de Aplicaciones
                                    if ($indice > 0) {
                                        $indiceant = $indice - 1;
                                        if ($vectorcarr[$i][$indice]['tipoa'] <> $vectorcarr[$i][$indiceant]['tipoa']) {
                                            echo $productos['tipoa'];
                                        }
                                    } else {
                                        echo $productos['tipoa'];
                                    }
                                    $indice++;
                                    ?>


                                </td>
                                <td><?php echo $productos['nomprod'] ?></td>
                                <td style="text-align: right;"><?php echo number_format($productos['cantidad'], 2); ?></td>
                                <td style="text-align: right;"><?php echo number_format($ltxha, 2); ?></td>
                                <td style="text-align: right;">$<?php echo $productos['precio'] ?></td>
                                <?php if ($pud == 't') { ?>                                    
                                    <td style="text-align: right;">$ <?php echo $productos['preciodcto']; ?></td>
                                <?php } ?>
                                <td style="text-align: right;">$<?php echo number_format($precio_total, 2); ?></td>
                            </tr>
                            <?php
                        }
                        if ($pud <> 't') {
                            ?>
                            <tr>
                                <td colspan="3"></td>
                                <td colspan="2" style="text-align: right;">SUB TOTAL</td>
                                <td style="text-align: right;">$<?php echo number_format($total_general, 2); ?></td>                        
                            </tr>
                        <?php } ?>
                        <tr>
                            <?php if ($pud == 't') { ?>
                                <td></td>
                            <?php } ?>
                            <td colspan="1"></td>
                            <td colspan="3" style="text-align: right;">HUMA GRO Precio con descuento para <?php echo $vectoritem[$i][5]; ?> Has.</td>
                            <td colspan="1" style="text-align: right;">Total</td>
                            <td style="text-align: right;">$<?php echo number_format($vectoritem[$i][3], 2); ?></td>
                        </tr>


                        <?php
                        if ($vectoritem[$i][5] > 1) {
                            $precxha = $vectoritem[$i][3] / $vectoritem[$i][5];
                            ?> 
                            <tr>
                                <?php if ($pud == 't') { ?>
                                    <td></td>
                                <?php } ?>
                                <td colspan="5" style="text-align: right;">HUMA GRO Precio con descuento / Ha.</td>                            
                                <td style="text-align: right;">$<?php echo number_format($precxha, 2); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>            
                <?php
            }
            //******************************* FIN HECTAREA PAQ
        } elseif ($tipoprop == "VOLUMEN PAQ") {
            echo '<hr/>';
            echo '<p class="alert alert-success">' . $vectoritem[$i][13] . '</p>';
            ?>
            <div style="clear: both;"></div>
            <br/>
            <p>Análisis Económico</p>
            <table class="table table-striped" style="font-size: 10px">
                <thead>
                    <tr style="background-color: #ffeca1">                        
                        <th>PRODUCTO</th>
                        <th style="text-align: right;">Litros</th>                        
                        <th style="text-align: right;">Precio Unit.</th>
                        <?php if ($pud == 't') { ?>
                            <th style="text-align: right;">Precio Unit Dcto</th>
                        <?php } ?>
                        <th style="text-align: right;">Precio Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_general = 0;
                    $indice = 0;
                    foreach ($vectorcarr[$i] as $productos) {
                        if ($pud == 'f') {
                            $precio_total = $productos['cantidad'] * $productos['precio'];
                        } else {
                            $precio_total = $productos['cantidad'] * $productos['preciodcto'];
                        }
                        $total_general+=$precio_total;
                        ?>
                        <tr>                            
                            <td><?php echo $productos['nomprod'] ?></td>
                            <td style="text-align: right;"><?php echo number_format($productos['cantidad'], 2); ?></td>
                            <td style="text-align: right;"><?php echo number_format($productos['precio'], 2); ?></td>
                            <?php if ($pud == 't') { ?>                                    
                                <td style="text-align: right;">$ <?php echo $productos['preciodcto']; ?></td>
                            <?php } ?>
                            <td style="text-align: right;">$<?php echo number_format($precio_total, 2); ?></td>                            
                        </tr>
                        <?php
                    }
                    if ($pud <> 't') {
                        ?>
                        <tr>
                            <td colspan="1"></td>
                            <td colspan="2" style="text-align: right;">SUB TOTAL</td>
                            <td style="text-align: right;">$<?php echo number_format($total_general, 2); ?></td>                        
                        </tr>
                    <?php } ?>
                    <tr> 
                        <?php if ($pud == 't') { ?>
                            <td></td>
                        <?php } ?>
                        <td colspan="2" style="text-align: right;">HUMA GRO Precio con descuento</td>
                        <td colspan="1" style="text-align: right;">Total</td>
                        <td style="text-align: right;">$<?php echo number_format($vectoritem[$i][3], 2); ?></td>
                    </tr>           
                </tbody>
            </table>            
            <?php
            //******************************* FIN VOLUMEN PAQ
        }
        ?>        
            <a class="btn btn-default" target="_blank" onclick="from_3(<?php echo $i;?>, '', '', 'divexperimento', '_propuestav2_hapaq_detalle_update.php')" href="javascript:_propuestav2_update.php?cod=<?php echo trim($valor['codprop']); ?>" title="Modificar Item"><img src="img/iconos/edit.png" height="15" /></a>            
            <!--<a class="btn btn-default" target="_blank" onclick="from_3('', '', '', 'divexperimento', '_propuestav2_hapaq_detalle_update')" href="javascript:_propuestav2_update.php?cod=<?php echo trim($valor['codprop']); ?>" title="Modificar Item"><img src="img/iconos/edit.png" height="15" /></a>-->            
        <a class="btn btn-default" onClick="return confirmSubmit();" href="javascript:cargar('#divexperimento', '_propuestav2_vista_previa_elim.php?indice=<?php echo $i; ?>')" title="Eliminar Item"><img src="img/iconos/trash.png" height="15" /></a>
        <!--<a class="btn btn-default" target="_blank" href="_propuestav2_update.php?cod=<?php echo trim($valor['codprop']); ?>" title="Adicionar Item a partir de este Item."><img src="img/iconos/Add_1.png" height="15" /></a>-->            
        <!--cargar('#divplantilla', '_propuestav2_hapaq_detalle_update.php')-->
        <?php
    }
} else {
    echo 'El carrito está vacio.';
}

unset($_SESSION['carrito']);
unset($_SESSION['unidades']);
unset($_SESSION['carritodesp']);

echo "<script>";
echo "cargar('#divproductos', '_vacio.php')";
echo "</script>";

function ordenarCarrito($datos) {
    foreach ($datos as $clave => $fila) {
        $categoria[$clave] = $fila['ordenta'];
        $producto[$clave] = $fila['ordenprod'];
    }
    array_multisort($categoria, SORT_ASC, $producto, SORT_ASC, $datos);
    return $datos;
}

function ordenarUnidades($datos) {
    foreach ($datos as $clave => $fila) {
        $orden[$clave] = $fila['orden'];
    }
    array_multisort($orden, SORT_ASC, $datos);
    return $datos;
}

function eliminarOpcion($key) {

    unset($_SESSION['car'][$key]);
}
