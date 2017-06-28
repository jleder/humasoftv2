<?php
@session_start();
$_SESSION["conectado"] = 'SI';
$_SESSION["usuario"] = 'ADM';
$_SESSION["nombreUsuario"] = 'Salvador Giha';

if ($_SESSION["conectado"] == 'SI') {
    if ($_SESSION["usuario"] == 'ADM' || $_SESSION["usuario"] == 'JLP') {
        date_default_timezone_set("America/Bogota");
        include_once '../controller/C_Propuestas.php';

        $pro = new C_Propuesta();

        $codprop = $_GET['cod'];
        $pro->__set('codprop', $codprop);
        $propuesta = $pro->getPropuestasxAprobGerenteByCod();

        if ($propuesta) {

            $detitem = $pro->getItemByCodProp();

            $pro->__set('codcliente', $propuesta[1]);
            $factores = $pro->getLast5Factores();
            ?>
            <!DOCTYPE html>
            <html>
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />                         
                    <!--calendario-->        
                    <script type="text/javascript" src="js/js_inscoltec.js"></script>      
                    <script type="text/javascript" src="js/fAjax.js"></script>
                    <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
                    <!--<link rel="stylesheet" type="text/css" href="css/bootstrap.css">-->                    
                    <link href="css/bootstrap.min.css" rel="stylesheet">
                    <link href="css/aprobar_propuesta.css" rel="stylesheet">
                    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
                    <link href='http://fonts.googleapis.com/css?family=Righteous' rel='stylesheet' type='text/css'>
                </head>
                <body>
                    <div class="container" >
                        <div class="row" style="background-color: #312e55; color: white; padding: 20px;">
                            <div class="col-lg-12">
                                <h1>HUMA GRO </h1>
                                <h3>APROBACIÓN DE PROPUESTAS ONLINE</h3>                                
                                Nombre Completo: <?php echo $_SESSION['nombreUsuario']; ?><br/>
                                Usuario: <?php echo $_SESSION['usuario']; ?><br/>
                                Propuesta Nro: <?php echo $codprop; ?><br/>                                                                   
                                <hr/>
                            </div>
                        </div>
                        <div class="row" id="flotar">
                            <div class="col-md-12">
                                <a class="btn btn-default" target="_blank" href="_propuestav2_getpdf.php?codprop=<?php echo trim($codprop); ?>" title="PDF">VER PROPUESTA EN PDF</a>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <form id="form" name="form" action="#" method="post" enctype="multipart/form-data">                        

                            <p style="text-align: right;">                            
                                <input type = "hidden" name = "codprop" placeholder="" value = "<?php echo $propuesta[0]; ?>" class="" id="codprop" />
                            </p> 

                            <?php
                            $demo = $propuesta[15];
                            if ($demo == 'SI') {
                                ?>
                                <div class="form-group">                            
                                    <div class="col-sm-12">
                                        <div class="alert alert-danger">Es una Propuesta DEMO</div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>

                            <div class="row">
                                <div class="col-lg-6">
                                    <?php
                                    $cultivo = $propuesta[10];
                                    $variedad = $propuesta[11];
                                    if ($cultivo === 0) {
                                        $cultivo = 'No Especificado';
                                    }
                                    if ($variedad === 0) {
                                        $variedad = 'No Especificado';
                                    }
                                    ?>
                                    <pre>Fecha:      <?php echo date("d/m/Y", strtotime($propuesta[4])); ?><br/>Código:     <span style="color: blue; font-size: 15px;"><?php echo $propuesta[0]; ?></span><br/>Contacto:   <?php echo $propuesta[5]; ?><br/>Cliente:    <span style="color: blue; font-size: 15px;"><?php echo $propuesta[2]; ?></span><br/>Cultivo:    <?php echo $cultivo; ?><br/>Variedad:   <?php echo $variedad; ?><br/>Vendedor:   <?php echo $propuesta[8]; ?><br/>Creado Por: <?php echo $propuesta[9]; ?><br/>Forma de Pago: <?php echo $propuesta[18]; ?><br/>Despachos:  <?php echo $propuesta[21]; ?></pre>
                                    <input type = "hidden" name = "codcliente" placeholder="" value = "<?php echo trim($propuesta[1]); ?>" class="" id="codcliente" />
                                    <input type = "hidden" name = "elaboradopor" placeholder="" value = "<?php echo trim($propuesta[9]); ?>" class="" id="elaboradopor" />
                                </div>                                
                            </div>                                                
                            <div class="row">
                                <div class="col-lg-6">                                
                                    <p style="background-color: whitesmoke; padding: 10px; color: blue;">Últimos FACTORES DE APROBACIÓN de este CLIENTE.</p>
                                    <?php
                                    if (count($factores) > 0) {
                                        ?>
                                        <table class="table table-striped" style="font-size: 11px;">
                                            <tbody>
                                                <tr style="">
                                                    <td>Fecha: </td>
                                                    <td>Propuesta: </td>
                                                    <td>Tipo: </td>
                                                    <td>Factor: </td>
                                                    <td>Descuento: </td>
                                                    <td>Estado GER: </td>
                                                </tr>
                                                <?php
                                                foreach ($factores as $valfactor) {

                                                    $fecreg = date("d/m/Y", strtotime($valfactor['fecreg']));
                                                    $linkprop = 'http://humagroperu.ddns.net:8070/humasoft/site/_propuestav2_aprob02_verweb.php?cod=';
                                                    $linkprop .= trim($valfactor['codprop']);
                                                    $pud = $valfactor['pud'];
                                                    if (trim($valfactor['codprop']) <> trim($codprop)) {
                                                        echo '<tr>';
                                                        echo '<td>' . $fecreg . '</td>';
                                                        echo '<td><a class="btn btn-info btn-sm" href="' . $linkprop . '" target="_blank">' . $valfactor['codprop'] . '</a></td>';
                                                        echo '<td>';
                                                        if ($pud == 't') {
                                                            echo 'U';
                                                        } else {
                                                            $pro->__set('coditem', $valfactor['coditem']);
                                                            $cantprod = $pro->getCantidadProductosByItem();
                                                            echo 'P' . $cantprod;
                                                        }
                                                        echo '</td>';
                                                        echo '<td>' . $valfactor['fa'] . '</td>';
                                                        echo '<td>' . $valfactor['descuento'] . '</td>';
                                                        echo '<td>' . $valfactor['estado'] . '</td>';
                                                        echo '</tr>';
                                                    }
                                                }
                                                ?>                                                            
                                            </tbody>
                                        </table>
                                        <?php
                                    } else {
                                        echo '<p style="color: red">Este cliente aún no posee FACTORES DE APROBACIÓN.</p>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">                                     
                                    <p style="background-color: whitesmoke; padding: 10px; color: blue;">OBSERVACIONES DE ESTA PROPUESTA.</p>
                                    <?php
                                    if ($propuesta[17] <> '') {
                                        echo '<p style="background-color: yellow; padding: 10px;">' . $propuesta[17] . '</p>';
                                    } else {
                                        echo 'No hay observaciones';
                                    }
                                    ?>
                                </div>                            
                            </div>
                            <br/>
                            <?php
                            //RECORRER ITEM
                            $ndetitem = count($detitem);
                            $_SESSION['itemcar'] = $detitem;
                            $corredor = 0;
                            if ($ndetitem > 0) {
                                foreach ($detitem as $item) {

                                    $ha = $item['ha'];
                                    $nitrogeno = $item['nitrogeno'];
                                    $pud = $item['pud'];
                                    $pup = $item['pup'];
                                    $verfc = $item['verfc'];
                                    $pyk = $item['pyk'];
                                    $plantilla = $item['plantilla'];
                                    $coditem = $item['coditem'];
                                    $pro->__set('coditem', $coditem);
                                    $detproductos = $pro->getDetallePropxAprobGerenteByCodProp();
                                    ?>
                                    <div class="row" id="divitem" style="background-color: #FAFAFA; box-shadow: 0px 0px 1px black;">
                                        <div class="col-md-12">                                            
                                            <!--parametros ocultos de item  pv2 = propuesta version 2-->
                                            <input type="hidden" id="pv2_ha<?php echo $corredor; ?>" name="pv2_ha<?php echo $corredor; ?>" value="<?php echo $item['ha']; ?>" />
                                            <input type="hidden" id="pv2_descuento<?php echo $corredor; ?>" value="<?php echo $item['descuento']; ?>" />
                                            <input type="hidden" id="pv2_pcc<?php echo $corredor; ?>" value="<?php echo $item['pcc']; ?>" />
                                            <input type="hidden" id="pv2_pca<?php echo $corredor; ?>" value="<?php echo $item['pca']; ?>" />
                                            <input type="hidden" id="pv2_precioambt<?php echo $corredor; ?>" value="<?php echo $item['precioambt']; ?>" />
                                            <input type="hidden" id="pv2_fa<?php echo $corredor; ?>" value="<?php echo $item[fa]; ?>" />
                                            <input type="hidden" name="pv2_nitrogeno<?php echo $corredor; ?>" value="<?php echo $item['nitrogeno']; ?>" />
                                            <input type="hidden" name="pv2_plantilla<?php echo $corredor; ?>" value="<?php echo $item['plantilla']; ?>" />
                                            <input type="hidden" name="pv2_pud<?php echo $corredor; ?>" value="<?php echo $item['pud']; ?>" />

                                            <!--fin de parametros ocultos-->                                                                                
                                            <div class="row">
                                                <div class="col-md-12" style="background-color: #000000; color: white;">
                                                    <h4 style=""><?php echo 'Item ' . ($corredor + 1) . ': ' . $item['itemdesc']; ?></h4>
                                                </div>
                                            </div>
                                            <div class="row" style="padding: 5px">
                                                <div class="col-md-12">
                                                    <?php if ($pup <> 't') { ?>
                                                        <div class="row">                                            
                                                            <div class="col-md-3">
                                                                Estado Actual                                                    
                                                            </div>
                                                            <div class="col-md-2">
                                                                <?php echo $item['estado']; ?>
                                                            </div>                                                                                                                                        
                                                            <div class="col-md-3">Hectarea</div>
                                                            <div class="col-md-2">
                                                                <?php echo $item['ha']; ?>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">Descuento</div>
                                                            <div class="col-md-2">
                                                                <input class="txtnum" type="number" step="any" onchange="" id="dscto<?php echo $corredor; ?>" name="dscto<?php echo $corredor; ?>" value="<?php echo $item['descuento']; ?>" />
                                                                <button type="button" onclick="setdscto(<?php echo $corredor; ?>)" href="#" >OK</button>
                                                            </div>
                                                            <div class="col-md-3">Precio HUMA GRO con Descuento</div>
                                                            <div class="col-md-2">
                                                                <input class="txtnum" type="number" step="any" id="preambtshow<?php echo $corredor; ?>" name="preambtshow" value="<?php echo $item['precioambt']; ?>" />
                                                                <!--<button type="button" onclick="setdscto(<?php echo $corredor; ?>)" href="#" >OK</button>-->
                                                            </div>                                            
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">Descuento Real</div>
                                                            <div class="col-md-2">0</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">Precio Convencional Confirmado</div>
                                                            <div class="col-md-2">
                                                                <input class="txtnum" type="number" step="any" id="pcc<?php echo $corredor; ?>" name="pcc<?php echo $corredor; ?>" value="<?php echo $item['pcc']; ?>" />
                                                            </div>
                                                            <div class="col-md-3">Precio Convencional Aproximado</div>
                                                            <div class="col-md-2">
                                                                <input class="txtnum" type="number" step="any" id="pca<?php echo $corredor; ?>" name="pca<?php echo $corredor; ?>" value="<?php echo $item['pca']; ?>" />
                                                            </div>
                                                        </div>
                                                    <?php } else { ?>                                                                                    
                                                        <div class="row">                                                  
                                                            <input class="txtnum" type="hidden" onchange="" id="dscto<?php echo $corredor; ?>" name="dscto<?php echo $corredor; ?>" value="<?php echo $item['descuento']; ?>" />
                                                            <input class="txtnum" type="hidden" id="preambtshow<?php echo $corredor; ?>" name="preambtshow" value="<?php echo $item['precioambt']; ?>" />
                                                            <input class="txtnum" type="hidden" id="pcc<?php echo $corredor; ?>" name="pcc<?php echo $corredor; ?>" value="<?php echo $item['pcc']; ?>" />                                                                                                
                                                            <input class="txtnum" type="hidden" id="pca<?php echo $corredor; ?>" name="pca<?php echo $corredor; ?>" value="<?php echo $item['pca']; ?>" />
                                                        </div>
                                                    <?php } ?>
                                                    <div id="divtable<?php echo $corredor; ?>">
                                                        <div class="row">
                                                            <div class="col-lg-12">                                                                                                                                                             
                                                                <?php
                                                                //Crear Carrito.
                                                                $carrito = array();

                                                                //RECORRER DETALLE DE PRODUCTOS
                                                                foreach ($detproductos as $producto) {

                                                                    $codigo = $producto['codprod'];
                                                                    $precio = $producto['costo'];
                                                                    $preciodcto = $producto['preciodcto'];

                                                                    $taplicacion = trim($producto['taplicacion']);
                                                                    $ordenta = trim($producto['ordenta']);
                                                                    $litros = $producto['cantidad'];
                                                                    $congelado = $producto['congelado'];


                                                                    $pro->__set('codprod', $codigo);
                                                                    $getproducto = $pro->getProdxPrecioByCod();

                                                                    if ($getproducto) {
                                                                        $orden = $getproducto[0]['orden'];
                                                                        $catprod = $getproducto[0]['codcate'];
                                                                        $nomcate = $getproducto[0]['desele'];
                                                                        $codprod = $getproducto[0]['codigo'];
                                                                        $nomprod = $getproducto[0]['nombre'];
                                                                        $umedida = $getproducto[0]['umedida'];

                                                                        $precioA = $getproducto[0]['precio'];
                                                                        $precioB = $getproducto[1]['precio'];
                                                                        $precioC = $getproducto[2]['precio'];
                                                                        $precioD = $getproducto[3]['precio'];
                                                                        $precioE = $getproducto[4]['precio'];

                                                                        //$indice = array_search(trim($codigo), array_column($carrito, 'codprod'));
                                                                        //if (strlen($indice) != '') {   // ME PASE HORAS INVESTIGANDO COMO HACER QUE EL CERO NO TE TOME COMO VACIO "". SOLUCION UTILIZAR = strlen
                                                                        //} else {
                                                                        array_push($carrito, array('ordenta' => $ordenta, 'taplicacion' => $taplicacion, 'ordenprod' => $orden, 'codprod' => trim($codprod), 'nomprod' => $nomprod, 'umedida' => $umedida, 'precioA' => $precioA, 'precioB' => $precioB, 'precioC' => $precioC, 'precioD' => $precioD, 'precioE' => $precioE, 'precio' => $precio, 'preciodcto' => $preciodcto, 'cantidad' => $litros, 'congelado' => $congelado));
                                                                        //}
                                                                    }
                                                                }

                                                                $arrr = ordenarCarrito($carrito);
                                                                $carrito = $arrr;

                                                                $_SESSION['itemtbl' . $corredor] = $item;
                                                                $_SESSION['carrito' . $corredor] = $carrito;

                                                                if ($plantilla == "HECTAREA PAQ") {

                                                                    if ($pup == 't') {

                                                                        $costo_total = 0;
                                                                        $costo_totalA = 0;
                                                                        $costo_totalE = 0;

                                                                        $precio_total = 0;
                                                                        $precio_totalA = 0;
                                                                        $precio_totalB = 0;
                                                                        $precio_totalC = 0;
                                                                        $precio_totalD = 0;
                                                                        $precio_totalE = 0;
                                                                        $recorrido = 0;
                                                                        $precxdcto = 0;


                                                                        //Recoger productos para el Comparativo entre Humagro y Convencional
                                                                        $productosPyK = array();
                                                                        $productosPUP = $carrito;

                                                                        if ($pyk == 't') {
                                                                            $productosPyK = getArrayComparacion('PyK', $carrito);
                                                                            $productosPUP = getArrayComparacion('', $carrito);
                                                                            if (count($productosPyK) > 0) {
                                                                                echo '<p><strong><u><i>Comparativo Económico:</i></u></strong></p>';
                                                                                foreach ($productosPyK as $valor) {
                                                                                    $tabla = getTablaComparativa($valor);
                                                                                    echo '<tabla><tr><td width="200px"></td><td>';
                                                                                    echo $tabla;
                                                                                    echo '</td></tr></tabla>';
                                                                                    echo '<br/>';
                                                                                }
                                                                            }
                                                                        }
                                                                        echo '<p><strong><u><i>Análisis Económico:</i></u></strong></p>';

                                                                        foreach ($productosPUP as $car) {

                                                                            $codprod = $car['codprod'];
                                                                            $ltxha = ($car['cantidad'] * $ha);

                                                                            $costo_total = $ltxha * $car['precio'];
                                                                            $costo_total_dcto = $ltxha * $car['preciodcto'];
                                                                            $precxdcto += $costo_total_dcto;

                                                                            $costo_totalA = $car['precioA'] * $ltxha;
                                                                            $costo_totalB = $car['precioB'] * $ltxha;
                                                                            $costo_totalC = $car['precioC'] * $ltxha;
                                                                            $costo_totalD = $car['precioD'] * $ltxha;
                                                                            $costo_totalE = $car['precioE'] * $ltxha;

                                                                            $precio_total += $costo_total;
                                                                            $precio_totalA += $costo_totalA;
                                                                            $precio_totalB += $costo_totalB;
                                                                            $precio_totalC += $costo_totalC;
                                                                            $precio_totalD += $costo_totalD;
                                                                            $precio_totalE += $costo_totalE;


                                                                            if ($car['congelado'] == 'T') {
                                                                                $costo_congelado = $car['preciodcto'] * $ltxha;
                                                                                $precio_totalcongelado+= $costo_congelado;
                                                                            }
                                                                            ?>                                    
                                                                            <div class="row">
                                                                                <div class="col-lg-9" style="margin-left: 10mm;">
                                                                                    <table class="table1" border="1" style=" font-size: 11px; width:100%;" align="left">
                                                                                        <thead>
                                                                                            <tr style="background-color: #dcdcdc; padding: 10px;">
                                                                                                <td style="padding: 5px; text-align: center;">Productos HUMA GRO</td>
                                                                                                <td style="text-align: center;">Litros/Ha</td>
                                                                                                <td style="text-align: center;">Litros/<?php echo $ha; ?> Ha</td>
                                                                                                <td style="text-align: center;">Precio Unit</td>
                                                                                                <td style="text-align: center;">Precio Unit Dcto</td>                            
                                                                                                <td style="text-align: center;">Precio Total</td>                                        
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            <tr>                                    
                                                                                                <td style=""><?php echo $car['nomprod']; ?></td>
                                                                                                <td style="text-align: center;"><?php echo number_format($car['cantidad'], 2); ?></td>
                                                                                                <td style="text-align: center;"><?php echo number_format($ltxha, 2); ?></td>
                                                                                                <td style="text-align: center;">$ <?php echo $car['precio']; ?></td>
                                                                                                <td style="text-align: center;">$ <?php echo $car['preciodcto']; ?></td>
                                                                                                <td style="text-align: center;">$<?php echo number_format($costo_total, 2); ?></td>                                        
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td colspan="1" style="border-left: 0px; border-bottom: 0px;">** Bidones de 10 Litros</td>
                                                                                                <td colspan="3" style="text-align: center; font-style: italic;">HUMA GRO Precio con descuento</td>
                                                                                                <td style="text-align: center; font-weight: bolder;">TOTAL</td>
                                                                                                <td style="text-align: center;;">$<?php echo number_format($costo_total_dcto, 2); ?></td>                                        
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                            <br/>
                                                                            <br/>
                                                                            <?php
                                                                        }
                                                                        //FIN DE PUP (PRECIO UNITARIO POR PRODUCTOS)
                                                                    } else {
                                                                        echo '<br/>';
                                                                        echo '<p><strong><u><i>Análisis Económico:</i></u></strong></p>';

                                                                        $vectorund = $pro->getUnidades();
                                                                        $aplicaciones = array_unique(array_column($carrito, 'taplicacion'));
                                                                        $_SESSION['vectorund' . $corredor] = $vectorund;

                                                                        $colorfc = 'red';
                                                                        if ($verfc == 't') {
                                                                            $colorfc = 'black';
                                                                        }

                                                                        //Mostrando los tipos de aplicaciones    
                                                                        ?>
                                                                        <div class="row text-center">
                                                                            <div class="col-md-12">
                                                                                <?php
                                                                                $napp = 0;
                                                                                foreach ($aplicaciones as $app) {
                                                                                    $nomapp = $app;
                                                                                    $novo_texto = wordwrap($nomapp, 10, "<br />\n");
                                                                                    //echo "$novo_texto\n";

                                                                                    if ($napp == 0) {
                                                                                        if ($novo_texto == trim('FERTIRRIEGO')) {
                                                                                            if (count($vectorund)) {
                                                                                                foreach ($vectorund as $valund) {

                                                                                                    if ($valund['codnut'] == 'N' && $nitrogeno == 'no') {
                                                                                                        echo '<div class="cuadront">'
                                                                                                        . '<div class="cuadrito2"><strong>' . $valund['codnut'] . '</strong></div>'
                                                                                                        . '<div class="cuadrito2">' . $valund['unidad'] . '</div>'
                                                                                                        . '<div class="cuadrito2" style="color: ' . $colorfc . ';">' . $valund['fc'] . '</div>'
                                                                                                        . '</div>';
                                                                                                        echo '<div class="mas">/</div>';
                                                                                                    } elseif ($valund['codnut'] == 'N' && $nitrogeno == '50') {
                                                                                                        echo '<div class="cuadront">'
                                                                                                        . '<div class="cuadrito2"><strong>' . $valund['codnut'] . '</strong></div>'
                                                                                                        . '<div class="cuadrito2">' . $valund['unidad'] . '</div>'
                                                                                                        . '<div class="cuadrito2" style="color: ' . $colorfc . ';">' . $valund['fc'] . '</div>'
                                                                                                        . '</div>';
                                                                                                        echo '<div class="mas">50%</div>';
                                                                                                    } else {
                                                                                                        echo '<div class="cuadront">'
                                                                                                        . '<div class="cuadrito2"><strong>' . $valund['codnut'] . '</strong></div>'
                                                                                                        . '<div class="cuadrito2">' . $valund['unidad'] . '</div>'
                                                                                                        . '<div class="cuadrito2" style="color: ' . $colorfc . ';">' . $valund['fc'] . '</div>'
                                                                                                        . '</div>';
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
                                                                            </div>
                                                                        </div>

                                                                        <?php
                                                                        //Arreglos para Productos congelados y no congelados
                                                                        $array_pncong = $carrito;
                                                                        $array_pcong = array();
                                                                        $mm = 0;
                                                                        foreach ($array_pncong as $prueba) {
                                                                            if ($prueba['congelado'] == 't') {
                                                                                array_push($array_pcong, $array_pncong[$mm]);
                                                                                unset($array_pncong[$mm]);
                                                                            }
                                                                            $mm++;
                                                                        }

                                                                        sort($array_pncong);

//                                                                        echo '<pre>Precios No congelados';
//                                                                        print_r($array_pncong);
//                                                                        echo '<br/>Precios Congelados';
//                                                                        print_r($array_pcong);
//                                                                        echo '</pre>';
                                                                        ?>
                                                                        <br/><br/>                                                                        
                                                                        <?php
                                                                        ///****INICIA PUD (PRECIO UNITARIO CON DESCUENTO)

                                                                        if ($pud == 't') {
                                                                            ?>
                                                                            <table class="table table-striped" style="font-size: 11px;">
                                                                                <thead>
                                                                                    <tr style="background-color: #cccccc">
                                                                                        <td>Aplicación</td>
                                                                                        <td>Producto</td>
                                                                                        <td style="text-align: right;">Lts/Ha</td>
                                                                                        <td style="text-align: right;">Lts/<?php echo $ha ?> Ha.</td>
                                                                                        <td  style="text-align: right">Precio Unit</td>                                                                                           
                                                                                        <td  style="text-align: right">Precio Unit Dcto</td>                                                                                        
                                                                                        <td  style="text-align: right">Precio Total</td>                                            
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <?php
                                                                                    $costo_total = 0;
                                                                                    $costo_totalA = 0;
                                                                                    $costo_totalE = 0;

                                                                                    $precio_total = 0;
                                                                                    $precio_totalA = 0;
                                                                                    $precio_totalB = 0;
                                                                                    $precio_totalC = 0;
                                                                                    $precio_totalD = 0;
                                                                                    $precio_totalE = 0;
                                                                                    $recorrido = 0;
                                                                                    $precio_totalcongelado = 0;
                                                                                    $precio_totalnocong = 0;

                                                                                    foreach ($carrito as $car) {
                                                                                        $congelado = $car['congelado'];
                                                                                        $ltxha = $car['cantidad'] * $ha;
                                                                                        if ($pud == 't') {
                                                                                            $costo_total = $car['preciodcto'] * $ltxha;
                                                                                        } else {
                                                                                            $costo_total = $car['precio'] * $ltxha;
                                                                                        }

                                                                                        if ($car['congelado'] == 't') {
                                                                                            $costo_congelado = $car['preciodcto'] * $ltxha;
                                                                                            $precio_totalcongelado+= $costo_congelado;
                                                                                            $precio_totalnocong+= $costo_total;
                                                                                        }

                                                                                        $costo_totalA = $car['precioA'] * $ltxha;
                                                                                        $costo_totalB = $car['precioB'] * $ltxha;
                                                                                        $costo_totalC = $car['precioC'] * $ltxha;
                                                                                        $costo_totalD = $car['precioD'] * $ltxha;
                                                                                        $costo_totalE = $car['precioE'] * $ltxha;

                                                                                        $precio_total += $costo_total;
                                                                                        $precio_totalA += $costo_totalA;
                                                                                        $precio_totalB += $costo_totalB;
                                                                                        $precio_totalC += $costo_totalC;
                                                                                        $precio_totalD += $costo_totalD;
                                                                                        $precio_totalE += $costo_totalE;
                                                                                        ?>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <?php
                                                                                                if ($recorrido > 0) {
                                                                                                    $indiceant = $recorrido - 1;
                                                                                                    if (trim($carrito[$recorrido]['taplicacion']) <> trim($carrito[$indiceant]['taplicacion'])) {
                                                                                                        echo $car['taplicacion'];
                                                                                                    }
                                                                                                } else {
                                                                                                    echo $car['taplicacion'];
                                                                                                }
                                                                                                ?>
                                                                                            </td>
                                                                                            <td><?php echo $car['nomprod']; ?></td>                                                
                                                                                            <td style="text-align: right;"><?php echo $car['cantidad']; ?></td>                                                
                                                                                            <td style="text-align: right;"><?php echo number_format($ltxha, 2); ?></td>
                                                                                            <td style="text-align: right"><input type="hidden" name="precio" value="<?php echo $car['precio']; ?>" /><?php echo $car['precio']; ?></td>
                                                                                            <?php if ($pud == 't') { ?>
                                                                                                <td style="text-align: right"><input type="hidden" name="preciodcto" value="<?php echo $car['preciodcto']; ?>" /><?php echo $car['preciodcto']; ?></td>
                                                                                            <?php } elseif ($pud == 'f') { ?>
                                                                                                <td  style="color: red; text-align: right">
                                                                                                    <?php
                                                                                                    if ($car['congelado'] == 'f') {
                                                                                                        echo number_format($car['precio'] - ($car['precio'] * $item['descuento']) / 100, 2);
                                                                                                    } else {
                                                                                                        echo '<span style="color:#01DF01; font-weight:bolder;">' . number_format($car['preciodcto'], 2) . '</span>';
                                                                                                    }
                                                                                                    ?>
                                                                                                </td>
                                                                                            <?php } ?>
                                                                                            <td style="text-align: right">$<?php echo number_format($costo_total, 2); ?></td>
                                                                                        </tr>                              
                                                                                        <?php
                                                                                        $recorrido++;
                                                                                    }
                                                                                    if ($pud == 'f') {
                                                                                        ?>
                                                                                        <tr>
                                                                                            <td colspan="4"></td>
                                                                                            <td colspan="2" style="text-align: right; font-weight: bold;">Sub Total:</td>
                                                                                            <td style="text-align: right; font-weight: bold; color: blue;">$<?php echo number_format($precio_total, 2); ?></td>                                                
                                                                                        </tr>
                                                                                        <?php
                                                                                    }

                                                                                    if ($pud == 'f') {
                                                                                        if ($precio_totalcongelado > 0) {
                                                                                            //retiramos el precio subtotal
                                                                                            $subprec1 = $precio_total - $precio_totalnocong;
                                                                                            //aplicamos el descuento solo a los productos que no tienen precios congelados
                                                                                            $subprec2 = ($subprec1 * (100 - ($item['descuento']))) / 100;
                                                                                            //AÑADIMOS AL RESULTADO EL TOTAL DE PRECIO CONGELADO
                                                                                            $precxdcto = $subprec2 + $precio_totalcongelado;
                                                                                        } else {
                                                                                            $precxdcto = ($precio_total * (100 - ($item['descuento']))) / 100;
                                                                                        }
                                                                                    } else {
                                                                                        $precxdcto = $precio_total;
                                                                                    }
                                                                                    ?>
                                                                                    <tr>                                                                    
                                                                                        <td colspan="3">
                                                                                            <!--Descuento Real-->
                                                                                            <?php
                                                                                            if ($precio_totalcongelado > 0) {
                                                                                                $dcto_real = (1 - ($precxdcto / $precio_total)) * 100;
                                                                                                echo "Descuento Real: " . number_format($dcto_real, 2);
                                                                                            }
                                                                                            ?>
                                                                                        </td>
                                                                                        <td colspan="3" style="text-align: right; font-weight: bold;">Precio HUMA GRO con Descuento:</td>
                                                                                        <td style="text-align: right; font-weight: bold; color: blue;">$<span id="phgdcto"><?php echo number_format($precxdcto, 2); ?></span></td>
                                                                                    </tr>
                                                                                    <?php
                                                                                    if ($ha > 1) {
                                                                                        $precxha = $precxdcto / $ha;
                                                                                        ?> 
                                                                                        <tr>                                                                       
                                                                                            <td colspan="3"></td>
                                                                                            <td colspan="3" style="text-align: right;">HUMA GRO Precio con descuento/Hectárea.</td>                        
                                                                                            <td style="text-align: right;">$<?php echo number_format($precxha, 2); ?></td>
                                                                                        </tr>
                                                                                    <?php } ?>
                                                                                </tbody>
                                                                            </table>

                                                                            <?php
                                                                            //***FIN DE PUD
                                                                        } else {
                                                                            ?>
                                                                            <table class="table table-striped" style="font-size: 11px;">
                                                                                <thead>
                                                                                    <tr style="background-color: #cccccc">
                                                                                        <td>Aplicación</td>
                                                                                        <td>Producto</td>
                                                                                        <td style="text-align: right;">Lts/Ha</td>
                                                                                        <td style="text-align: right;">Lts/<?php echo $ha ?> Ha.</td>
                                                                                        <td  style="text-align: right">Precio Unit</td>                                                                                           
                                                                                        <td  style="color: red; text-align: right">Precio Con Dcto</td>                                                                                        
                                                                                        <td  style="text-align: right">Precio Total</td>                                            
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <?php
                                                                                    $costo_total = 0;
                                                                                    $costo_totalA = 0;
                                                                                    $costo_totalE = 0;

                                                                                    $precio_total = 0;
                                                                                    $precio_totalA = 0;
                                                                                    $precio_totalB = 0;
                                                                                    $precio_totalC = 0;
                                                                                    $precio_totalD = 0;
                                                                                    $precio_totalE = 0;
                                                                                    $recorrido = 0;
                                                                                    $precio_totalcongelado = 0;
                                                                                    $precio_totalnocong = 0;

                                                                                    //**NO HAY CONGELADOS
                                                                                    if (count($array_pcong) == 0) {

                                                                                        foreach ($carrito as $car) {
                                                                                            $congelado = $car['congelado'];
                                                                                            $ltxha = $car['cantidad'] * $ha;
                                                                                            if ($pud == 't') {
                                                                                                $costo_total = $car['preciodcto'] * $ltxha;
                                                                                            } else {
                                                                                                $costo_total = $car['precio'] * $ltxha;
                                                                                            }

                                                                                            if ($car['congelado'] == 't') {
                                                                                                $costo_congelado = $car['preciodcto'] * $ltxha;
                                                                                                $precio_totalcongelado+= $costo_congelado;
                                                                                                $precio_totalnocong+= $costo_total;
                                                                                            }

                                                                                            $costo_totalA = $car['precioA'] * $ltxha;
                                                                                            $costo_totalB = $car['precioB'] * $ltxha;
                                                                                            $costo_totalC = $car['precioC'] * $ltxha;
                                                                                            $costo_totalD = $car['precioD'] * $ltxha;
                                                                                            $costo_totalE = $car['precioE'] * $ltxha;

                                                                                            $precio_total += $costo_total;
                                                                                            $precio_totalA += $costo_totalA;
                                                                                            $precio_totalB += $costo_totalB;
                                                                                            $precio_totalC += $costo_totalC;
                                                                                            $precio_totalD += $costo_totalD;
                                                                                            $precio_totalE += $costo_totalE;
                                                                                            ?>
                                                                                            <tr>
                                                                                                <td>
                                                                                                    <?php
                                                                                                    if ($recorrido > 0) {
                                                                                                        $indiceant = $recorrido - 1;
                                                                                                        if (trim($carrito[$recorrido]['taplicacion']) <> trim($carrito[$indiceant]['taplicacion'])) {
                                                                                                            echo $car['taplicacion'];
                                                                                                        }
                                                                                                    } else {
                                                                                                        echo $car['taplicacion'];
                                                                                                    }
                                                                                                    ?>
                                                                                                </td>
                                                                                                <td><?php echo $car['nomprod']; ?></td>                                                
                                                                                                <td style="text-align: right;"><?php echo $car['cantidad']; ?></td>                                                
                                                                                                <td style="text-align: right;"><?php echo number_format($ltxha, 2); ?></td>
                                                                                                <td style="text-align: right"><input type="hidden" name="precio" value="<?php echo $car['precio']; ?>" /><?php echo $car['precio']; ?></td>
                                                                                                <?php if ($pud == 't') { ?>
                                                                                                    <td style="text-align: right"><input type="hidden" name="preciodcto" value="<?php echo $car['preciodcto']; ?>" /><?php echo $car['preciodcto']; ?></td>
                                                                                                <?php } elseif ($pud == 'f') { ?>
                                                                                                    <td  style="color: red; text-align: right">
                                                                                                        <?php
                                                                                                        if ($car['congelado'] == 'f') {
                                                                                                            echo number_format($car['precio'] - ($car['precio'] * $item['descuento']) / 100, 2);
                                                                                                        } else {
                                                                                                            echo '<span style="color:#01DF01; font-weight:bolder;">' . number_format($car['preciodcto'], 2) . '</span>';
                                                                                                        }
                                                                                                        ?>
                                                                                                    </td>
                                                                                                <?php } ?>
                                                                                                <td style="text-align: right">$<?php echo number_format($costo_total, 2); ?></td>
                                                                                            </tr>                              
                                                                                            <?php
                                                                                            $recorrido++;
                                                                                        }
                                                                                        if ($pud == 'f') {
                                                                                            ?>
                                                                                            <tr>
                                                                                                <td colspan="4"></td>
                                                                                                <td colspan="2" style="text-align: right; font-weight: bold;">Sub Total:</td>
                                                                                                <td style="text-align: right; font-weight: bold; color: blue;">$<?php echo number_format($precio_total, 2); ?></td>                                                
                                                                                            </tr>
                                                                                            <?php
                                                                                        }
                                                                                        if ($pud == 'f') {
                                                                                            if ($precio_totalcongelado > 0) {
                                                                                                //retiramos el precio subtotal
                                                                                                $subprec1 = $precio_total - $precio_totalnocong;
                                                                                                //aplicamos el descuento solo a los productos que no tienen precios congelados
                                                                                                $subprec2 = ($subprec1 * (100 - ($item['descuento']))) / 100;
                                                                                                //AÑADIMOS AL RESULTADO EL TOTAL DE PRECIO CONGELADO
                                                                                                $precxdcto = $subprec2 + $precio_totalcongelado;
                                                                                            } else {
                                                                                                $precxdcto = ($precio_total * (100 - ($item['descuento']))) / 100;
                                                                                            }
                                                                                        } else {
                                                                                            $precxdcto = $precio_total;
                                                                                        }
                                                                                        ?>
                                                                                        <tr>                                                                    
                                                                                            <td colspan="3">
                                                                                                <!--Descuento Real-->
                                                                                                <?php
                                                                                                if ($precio_totalcongelado > 0) {
                                                                                                    $dcto_real = (1 - ($precxdcto / $precio_total)) * 100;
                                                                                                    echo "Descuento Real: " . number_format($dcto_real, 2);
                                                                                                }
                                                                                                ?>
                                                                                            </td>
                                                                                            <td colspan="3" style="text-align: right; font-weight: bold;">Precio HUMA GRO con Descuento:</td>
                                                                                            <td style="text-align: right; font-weight: bold; color: blue;">$<span id="phgdcto"><?php echo number_format($precxdcto, 2); ?></span></td>
                                                                                        </tr>
                                                                                        <?php
                                                                                        if ($ha > 1) {
                                                                                            $precxha = $precxdcto / $ha;
                                                                                            ?> 
                                                                                            <tr>                                                                       
                                                                                                <td colspan="3"></td>
                                                                                                <td colspan="3" style="text-align: right;">HUMA GRO Precio con descuento/Hectárea.</td>                        
                                                                                                <td style="text-align: right;">$<?php echo number_format($precxha, 2); ?></td>
                                                                                            </tr>
                                                                                            <?php
                                                                                        }
                                                                                        //***SI HAY CONGELADOS ()
                                                                                    } else {
                                                                                        //PROCESO CUANDO EXISTE PRODUCTOS CONGELADOS Y NO CONGELADOS
                                                                                        $total_no_congelado = 0;
                                                                                        $total_si_congelado = 0;
                                                                                        $total_con_dcto = 0;
                                                                                        $indice = 0;

                                                                                        //RECORRIDO DE PRODUCTOS NO CONGELADOS
                                                                                        foreach ($array_pncong as $car) {
                                                                                            $congelado = $car['congelado'];
                                                                                            $ltxha = $car['cantidad'] * $ha;
                                                                                            if ($pud == 't') {
                                                                                                $costo_total = $car['preciodcto'] * $ltxha;
                                                                                            } else {
                                                                                                $costo_total = $car['precio'] * $ltxha;
                                                                                            }
                                                                                            $total_no_congelado+=$costo_total;

                                                                                            if ($car['congelado'] == 't') {
                                                                                                $costo_congelado = $car['preciodcto'] * $ltxha;
                                                                                                $precio_totalcongelado+= $costo_congelado;
                                                                                                $precio_totalnocong+= $costo_total;
                                                                                            }


                                                                                            $costo_totalA = $car['precioA'] * $ltxha;
                                                                                            $costo_totalB = $car['precioB'] * $ltxha;
                                                                                            $costo_totalC = $car['precioC'] * $ltxha;
                                                                                            $costo_totalD = $car['precioD'] * $ltxha;
                                                                                            $costo_totalE = $car['precioE'] * $ltxha;

                                                                                            $precio_total += $costo_total;
                                                                                            $precio_totalA += $costo_totalA;
                                                                                            $precio_totalB += $costo_totalB;
                                                                                            $precio_totalC += $costo_totalC;
                                                                                            $precio_totalD += $costo_totalD;
                                                                                            $precio_totalE += $costo_totalE;
                                                                                            ?>
                                                                                            <tr>
                                                                                                <td>
                                                                                                    <?php
                                                                                                    if ($recorrido > 0) {
                                                                                                        $indiceant = $recorrido - 1;
                                                                                                        if (trim($carrito[$recorrido]['taplicacion']) <> trim($carrito[$indiceant]['taplicacion'])) {
                                                                                                            echo $car['taplicacion'];
                                                                                                        }
                                                                                                    } else {
                                                                                                        echo $car['taplicacion'];
                                                                                                    }
                                                                                                    ?>
                                                                                                </td>
                                                                                                <td><?php echo $car['nomprod']; ?></td>                                                
                                                                                                <td style="text-align: right;"><?php echo $car['cantidad']; ?></td>                                                
                                                                                                <td style="text-align: right;"><?php echo number_format($ltxha, 2); ?></td>
                                                                                                <td style="text-align: right"><input type="hidden" name="precio" value="<?php echo $car['precio']; ?>" /><?php echo $car['precio']; ?></td>
                                                                                                <?php if ($pud == 't') { ?>
                                                                                                    <td style="text-align: right"><input type="hidden" name="preciodcto" value="<?php echo $car['preciodcto']; ?>" /><?php echo $car['preciodcto']; ?></td>
                                                                                                <?php } elseif ($pud == 'f') { ?>
                                                                                                    <td  style="color: red; text-align: right">
                                                                                                        <?php
                                                                                                        if ($car['congelado'] == 'f') {
                                                                                                            echo number_format($car['precio'] - ($car['precio'] * $item['descuento']) / 100, 2);
                                                                                                        } else {
                                                                                                            echo '<span style="color:#01DF01; font-weight:bolder;">' . number_format($car['preciodcto'], 2) . '</span>';
                                                                                                        }
                                                                                                        ?>
                                                                                                    </td>
                                                                                                <?php } ?>
                                                                                                <td style="text-align: right">$<?php echo number_format($costo_total, 2); ?></td>
                                                                                            </tr>                              
                                                                                            <?php
                                                                                            $recorrido++;
                                                                                        }
                                                                                        ?>
                                                                                        <tr>
                                                                                            <td colspan="4"></td>
                                                                                            <td colspan="2" style="background-color: #dcdcdc; text-align: right;">SUB TOTAL</td>
                                                                                            <td style="background-color: #dcdcdc; text-align: right;">$<?php echo number_format($total_no_congelado, 2); ?></td>                                                                                                                    
                                                                                        </tr>
                                                                                        <tr>                                    
                                                                                            <td colspan="4"></td>
                                                                                            <td colspan="2" style="background-color: #adc676; text-align: right;">Precio Total de Productos con Dscto por Paquete.</td>
                                                                                            <?php
                                                                                            $total_con_dcto = $total_no_congelado * (1 - ($item['descuento'] / 100));
                                                                                            ?>
                                                                                            <td style="background-color: #adc676; text-align: right;">$<?php echo number_format($total_con_dcto, 2); ?></td>                                                                                            
                                                                                        </tr>                            
                                                                                        <tr>
                                                                                            <td colspan="8"></td>
                                                                                        </tr>
                                                                                        <?php
                                                                                        //RECORRIDO PRODUCTOS CONGELADOS
                                                                                        $indice = 0;
                                                                                        foreach ($array_pcong as $car) {

                                                                                            $congelado = $car['congelado'];
                                                                                            $ltxha = $car['cantidad'] * $ha;
                                                                                            $costo_total = $car['preciodcto'] * $ltxha;

                                                                                            $total_si_congelado+=$costo_total;


                                                                                            if ($car['congelado'] == 't') {
                                                                                                $costo_congelado = $car['preciodcto'] * $ltxha;
                                                                                                $precio_totalcongelado+= $costo_congelado;
                                                                                                $precio_totalnocong+= $costo_total;
                                                                                            }

                                                                                            $costo_totalA = $car['precioA'] * $ltxha;
                                                                                            $costo_totalB = $car['precioB'] * $ltxha;
                                                                                            $costo_totalC = $car['precioC'] * $ltxha;
                                                                                            $costo_totalD = $car['precioD'] * $ltxha;
                                                                                            $costo_totalE = $car['precioE'] * $ltxha;

                                                                                            $precio_total += $costo_total;
                                                                                            $precio_totalA += $costo_totalA;
                                                                                            $precio_totalB += $costo_totalB;
                                                                                            $precio_totalC += $costo_totalC;
                                                                                            $precio_totalD += $costo_totalD;
                                                                                            $precio_totalE += $costo_totalE;
                                                                                            ?>
                                                                                            <tr>
                                                                                                <td>
                                                                                                    <?php
                                                                                                    if ($recorrido > 0) {
                                                                                                        $indiceant = $recorrido - 1;
                                                                                                        if (trim($carrito[$recorrido]['taplicacion']) <> trim($carrito[$indiceant]['taplicacion'])) {
                                                                                                            echo $car['taplicacion'];
                                                                                                        }
                                                                                                    } else {
                                                                                                        echo $car['taplicacion'];
                                                                                                    }
                                                                                                    ?>
                                                                                                </td>
                                                                                                <td><?php echo $car['nomprod']; ?></td>                                                
                                                                                                <td style="text-align: right;"><?php echo $car['cantidad']; ?></td>                                                
                                                                                                <td style="text-align: right;"><?php echo number_format($ltxha, 2); ?></td>
                                                                                                <td style="text-align: right"><input type="hidden" name="precio" value="<?php echo $car['precio']; ?>" /><?php echo $car['precio']; ?></td>
                                                                                                <?php if ($pud == 't') { ?>
                                                                                                    <td style="text-align: right"><input type="hidden" name="preciodcto" value="<?php echo $car['preciodcto']; ?>" /><?php echo $car['preciodcto']; ?></td>
                                                                                                <?php } elseif ($pud == 'f') { ?>
                                                                                                    <td  style="color: red; text-align: right">
                                                                                                        <?php
                                                                                                        if ($car['congelado'] == 'f') {
                                                                                                            echo number_format($car['precio'] - ($car['precio'] * $item['descuento']) / 100, 2);
                                                                                                        } else {
                                                                                                            echo '<span style="color:#01DF01; font-weight:bolder;">' . number_format($car['preciodcto'], 2) . '</span>';
                                                                                                        }
                                                                                                        ?>
                                                                                                    </td>
                                                                                                <?php } ?>
                                                                                                <td style="text-align: right">$<?php echo number_format($costo_total, 2); ?></td>
                                                                                            </tr>                              
                                                                                            <?php
                                                                                            $recorrido++;
                                                                                        }
                                                                                        ?>
                                                                                        <tr>                                
                                                                                            <td colspan="4"></td>
                                                                                            <td colspan="2" style="background-color: #adc676; text-align: right;">Precio Total Productos sin Dscto por Paquete.</td>                    
                                                                                            <td style="background-color: #adc676; text-align: right;">$<?php echo number_format($total_si_congelado, 2); ?></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td colspan="7"></td>
                                                                                        </tr>
                                                                                        <?php
                                                                                        $sub_total = $total_no_congelado + $total_si_congelado;
                                                                                        ?>
                                                                                        <tr>
                                                                                            <td colspan="5"></td>
                                                                                            <td colspan="1" style="background-color: #dcdcdc; text-align: right;">Sub Total</td>
                                                                                            <td colspan="1" style="background-color: #dcdcdc; text-align: right;"><?php echo number_format($sub_total, 2); ?></td>
                                                                                        </tr>
                                                                                        <?php
                                                                                        $precxdcto = $total_con_dcto + $total_si_congelado;
                                                                                        ?>
                                                                                        <tr>
                                                                                            <td colspan="4"></td>
                                                                                            <td style="background-color: #adc676; text-align: right" colspan="2">Precio Total HUMA GRO con descuento para <?php echo $ha; ?> Ha</td>
                                                                                            <td style="background-color: #adc676; text-align: right; font-weight: bolder;" colspan="1"><?php echo number_format($precxdcto, 2); ?></td>                                                                                            
                                                                                        </tr>
                                                                                        <?php
                                                                                        if ($ha > 1) {
                                                                                            $precxha = $precxdcto / $ha;
                                                                                            ?> 
                                                                                            <tr>                                                                                                
                                                                                                <td></td>
                                                                                                <td colspan="5" style="text-align: right;">HUMA GRO Precio con descuento / Ha.</td>                            
                                                                                                <td style="text-align: right;">$<?php echo number_format($precxha, 2); ?></td>
                                                                                            </tr>
                                                                                            <?php
                                                                                        }



                                                                                        //***FIN PRODUCTOS CONGELADOS
                                                                                    }
                                                                                    ?>


                                                                                </tbody>
                                                                            </table>

                                                                            <?php
                                                                        }
                                                                    }
                                                                } elseif ($plantilla == 'VOLUMEN PAQ') {
                                                                    ?>
                                                                    <table class="table table-striped" style="width: 70%; font-size: 11px;">
                                                                        <thead>
                                                                            <tr style="background-color: #cccccc">                                                                    
                                                                                <td>Productos</td>
                                                                                <td style="text-align: right;">Litros</td>                                                                    
                                                                                <td  style="text-align: right">Precio Unit</td>   
                                                                                <?php if ($pud == 't') { ?>
                                                                                    <td  style="text-align: right">Precio Unit Dcto</td>
                                                                                <?php } elseif ($pud == 'f') { ?>
                                                                                    <td  style="color: red; text-align: right">Precio Con Dcto</td>
                                                                                <?php } ?>
                                                                                <td  style="text-align: right">Precio Total</td>                                            
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $costo_total = 0;
                                                                            $costo_totalA = 0;
                                                                            $costo_totalE = 0;

                                                                            $precio_total = 0;
                                                                            $precio_totalA = 0;
                                                                            $precio_totalB = 0;
                                                                            $precio_totalC = 0;
                                                                            $precio_totalD = 0;
                                                                            $precio_totalE = 0;
                                                                            $recorrido = 0;

                                                                            foreach ($carrito as $car) {
                                                                                $ltxha = $car['cantidad'] * 1;
                                                                                if ($pud == 't') {
                                                                                    $costo_total = $car['preciodcto'] * $ltxha;
                                                                                } else {
                                                                                    $costo_total = $car['precio'] * $ltxha;
                                                                                }

                                                                                $costo_totalA = $car['precioA'] * $ltxha;
                                                                                $costo_totalB = $car['precioB'] * $ltxha;
                                                                                $costo_totalC = $car['precioC'] * $ltxha;
                                                                                $costo_totalD = $car['precioD'] * $ltxha;
                                                                                $costo_totalE = $car['precioE'] * $ltxha;

                                                                                $precio_total += $costo_total;
                                                                                $precio_totalA += $costo_totalA;
                                                                                $precio_totalB += $costo_totalB;
                                                                                $precio_totalC += $costo_totalC;
                                                                                $precio_totalD += $costo_totalD;
                                                                                $precio_totalE += $costo_totalE;
                                                                                ?>
                                                                                <tr>                                                                        
                                                                                    <td><?php echo $car['nomprod']; ?></td>                                                
                                                                                    <td style="text-align: right;"><?php echo $car['cantidad']; ?></td>                                                                                                                        
                                                                                    <td style="text-align: right"><input type="hidden" name="precio" value="<?php echo $car['precio']; ?>" /><?php echo $car['precio']; ?></td> 
                                                                                    <?php if ($pud == 't') { ?>
                                                                                        <td style="text-align: right"><input type="hidden" name="preciodcto" value="<?php echo $car['preciodcto']; ?>" /><?php echo $car['preciodcto']; ?></td>
                                                                                    <?php } elseif ($pud == 'f') { ?>
                                                                                        <td  style="color: red; text-align: right"><?php echo number_format($car['precio'] - ($car['precio'] * $item['descuento']) / 100, 2); ?></td>
                                                                                    <?php } ?>                                                                            
                                                                                    <td style="text-align: right">$<?php echo number_format($costo_total, 2); ?></td>
                                                                                </tr>                              
                                                                                <?php
                                                                                $recorrido++;
                                                                            }
                                                                            if ($pud == 'f') {
                                                                                ?>
                                                                                <tr>
                                                                                    <td colspan="3"></td>
                                                                                    <td colspan="1" style="text-align: right; font-weight: bold;">Sub Total:</td>
                                                                                    <td style="text-align: right; font-weight: bold; color: blue;">$<?php echo number_format($precio_total, 2); ?></td>                                                
                                                                                </tr>
                                                                                <?php
                                                                            }

                                                                            if ($pud == 'f') {
                                                                                $precxdcto = ($precio_total * (100 - ($item['descuento']))) / 100;
                                                                            } else {
                                                                                $precxdcto = $precio_total;
                                                                            }
                                                                            ?>
                                                                            <tr>
                                                                                <?php // if ($pud == 't') {            ?>
                                                                                    <!--<td></td>-->
                                                                                <?php // }              ?>
                                                                                <td colspan="2"></td>
                                                                                <td colspan="2" style="text-align: right; font-weight: bold;">Precio HUMA GRO con Descuento:</td>
                                                                                <td style="text-align: right; font-weight: bold; color: blue;">$<span id="phgdcto"><?php echo number_format($precxdcto, 2); ?></span></td>
                                                                            </tr>
                                                                            <?php
                                                                            if ($ha > 1) {
                                                                                $precxha = $precxdcto / $ha;
                                                                                ?> 
                                                                                <tr>                                                                        
                                                                                    <td colspan="2"></td>
                                                                                    <td colspan="2">HUMA GRO Precio con descuento para <?php echo $ha; ?> Ha.</td>                        
                                                                                    <td style="text-align: right;">$<?php echo number_format($precxha, 2); ?></td>
                                                                                </tr>
                                                                            <?php } ?>
                                                                        </tbody>
                                                                    </table> 

                                                                <?php } ?>

                                                            </div>
                                                        </div>
                                                        <?php if ($pup <> 't') { ?>
                                                            <div class="row">
                                                                <div class="col-lg-2">
                                                                    <table class="" style="font-size: 10px;">                                                        
                                                                        <tbody>
                                                                            <tr>
                                                                                <td width="80px">Lista A</td>
                                                                                <td>$<?php echo number_format($precio_totalA, 2); ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Lista B</td>
                                                                                <td>$<?php echo number_format($precio_totalB, 2); ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Lista C</td>
                                                                                <td>$<?php echo number_format($precio_totalC, 2); ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Lista D</td>
                                                                                <td>$<?php echo number_format($precio_totalD, 2); ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Lista E</td>
                                                                                <td>$<span id="pretotalE<?php echo $corredor; ?>" hidden=""><?php echo $precio_totalE; ?></span><?php echo number_format($precio_totalE, 2); ?></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>         
                                                                <!--                                                <div class="col-lg-4" style="font-size: 10px">                                                    
                                                                
                                                                                                                </div>-->
                                                                <div class="col-lg-6">

                                                                    <!--valores ocultos-->
                                                                    <!--Precio con Descuento AMBT-->
                                                                    <input type="hidden" name="preambt<?php echo $corredor; ?>" step="any" id="preambt<?php echo $corredor; ?>" value="<?php echo $precxdcto; ?>"/>        
                                                                    <?php
                                                                    $fau = $pro->calcularFactorAprobacion($precxdcto, $precio_totalE);
                                                                    $fag = $fau + 25;
                                                                    ?>
                                                                    <!--Precio Lista Sin Dscto-->
                                                                    <input type="hidden" name="costototal<?php echo $corredor; ?>"  id="costototal<?php echo $corredor; ?>" value="<?php echo $precio_total; ?>" />
                                                                    <input type="hidden" name="fau<?php echo $corredor; ?>" value="<?php echo ($fau); ?>" />
                                                                    <input type="hidden" name="fag<?php echo $corredor; ?>" value="<?php echo ($fau + 25); ?>" />                                                    
                                                                    <h4>Factor Aprobación Usuario: <span style="background-color: yellow; padding: 3px;" id="fau<?php echo $corredor; ?>"><?php echo number_format($fau, 2); ?></span>  </h4>
                                                                    <h4>Factor Aprobación Gerente: <span style="background-color: #ffde80; padding: 3px;" id="fag<?php echo $corredor; ?>"><?php echo number_format($fag, 2); ?></span></h4>
                                                                </div>
                                                                <!--
                                                                <div class="col-lg-4">
                                                                    <p>Personalizar Tabla</p>
                                                                    <input type="checkbox" name="tipoa<?php echo $corredor ?>" id="tipoa<?php echo $corredor ?>" value="ON" checked="" /> Tipo Aplicación<br/>
                                                                    <input type="checkbox" name="lts<?php echo $corredor ?>" value="ON" checked="" /> Litros<br/>
                                                                    <input type="checkbox" name="ltsxha<?php echo $corredor ?>" value="ON" checked="" /> Lts/Ha<br/>
                                                                    <input type="checkbox" name="puxdscto<?php echo $corredor ?>" value="ON" checked="" /> Precio U. Dscto<br/>
                                                                </div>
                                                                -->
                                                            </div>
                                                            <br/>
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <p style="text-align: center">Porcentajes Aproximados:</p>

                                                                    <?php
                                                                    $dcto = $item['descuento'];
                                                                    $inicio = $dcto - 5;
                                                                    $fin = $dcto + 5;
                                                                    $array_fau = array();
                                                                    $array_fag = array();
                                                                    ?>
                                                                    <table style="font-size: 9px;">
                                                                        <tr>
                                                                            <td>DSCTO</td>
                                                                            <?php
                                                                            $iterador = 0;
                                                                            while ($inicio <= $fin) {
                                                                                if ($inicio == $dcto) {
                                                                                    echo '<td style="text-align: right; width:100px; color:blue; font-weight: bolder;"><span id="lbl' . $corredor . $iterador . '">' . $inicio . '</span>%</td>';
                                                                                } else {
                                                                                    echo '<td style="text-align: right; width:100px;"><span id="lbl' . $corredor . $iterador . '">' . $inicio . '</span>%</td>';
                                                                                }
                                                                                $inicio++;
                                                                                $iterador++;
                                                                            }
                                                                            ?>
                                                                        </tr>                                                        
                                                                        <tr>
                                                                            <td>TOTAL</td>
                                                                            <?php
                                                                            $home = $dcto - 5;
                                                                            $end = $dcto + 5;
                                                                            $j = 0;
                                                                            $montocalcu = 0;
                                                                            while ($home <= $end) {
                                                                                $porcentaje = (1 - ($home / 100));

                                                                                //inicio prueba
                                                                                if ($pud == 'f') {
                                                                                    if ($precio_totalcongelado > 0) {
                                                                                        //retiramos el precio subtotal
                                                                                        $subprec1 = $precio_total - $precio_totalnocong;
                                                                                        //aplicamos el descuento solo a los productos que no tienen precios congelados
                                                                                        $subprec2 = ($subprec1 * (($porcentaje)));
                                                                                        //AÑADIMOS AL RESULTADO EL TOTAL DE PRECIO CONGELADO
                                                                                        $montocalcu = $subprec2 + $precio_totalcongelado;
                                                                                    } else {
                                                                                        $montocalcu = ($precio_total * (($porcentaje)));
                                                                                    }
                                                                                } else {
                                                                                    $montocalcu = $precio_total;
                                                                                }
                                                                                //fin prueba
                                                                                //$montocalcu = ($precio_total * $porcentaje);
                                                                                $factor_aprobacion = $pro->calcularFactorAprobacion($montocalcu, $precio_totalE);
                                                                                array_push($array_fau, $factor_aprobacion);
                                                                                array_push($array_fag, ($factor_aprobacion + 25));

                                                                                if ($home == $dcto) {
                                                                                    echo '<td style="text-align: right; width:100px; color:blue; font-weight: bolder;">$<span id="monto' . $corredor . $j . '">' . number_format($montocalcu, 2) . '</span></td>';
                                                                                } else {
                                                                                    echo '<td style="text-align: right; width:100px;">$<span id="monto' . $corredor . $j . '">' . number_format($montocalcu, 2) . '</span></td>';
                                                                                }
                                                                                $home++;
                                                                                $j++;
                                                                            }
                                                                            ?>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>F.A.U.</td>
                                                                            <?php
                                                                            foreach ($array_fau as $fau) {
                                                                                echo '<td style="text-align: right; width:100px;">' . number_format($fau, 2) . '</td>';
                                                                            }
                                                                            ?>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>F.A.G.</td>
                                                                            <?php
                                                                            foreach ($array_fag as $fag) {
                                                                                echo '<td style="text-align: right; width:100px;">' . number_format($fag, 2) . '</td>';
                                                                            }
                                                                            ?>
                                                                        </tr>                                                        
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="row"> 
                                                                <div class="col-lg-7">
                                                                    <h4>Estado de Propuesta:</h4>
                                                                    <input type="hidden" name="estadoitem<?php echo $corredor; ?>" id="estadoitem<?php echo $corredor; ?>" value="APROBADO" />
                                                                    <input type="hidden" name="modificado<?php echo $corredor; ?>" id="modificado<?php echo $corredor; ?>" value="F" />
                                                                    <div style="clear: both"></div>
                                                                    <div class="cuadro_one">
                                                                        <div class="cuadro_two">
                                                                            <p style="text-align: center;"><a href="#hapaq" onclick="loadObs('APROBADO', <?php echo $corredor; ?>)" ><img src="img/iconos/aprobado.png" height="50px" /></a></p>
                                                                        </div>
                                                                        <div style="clear: both"></div>
                                                                        <p style="text-align: center; color: white;">Aprobar Tal Como Está</p>
                                                                    </div>
                                                                    <div class="cuadro_one">
                                                                        <div class="cuadro_two">
                                                                            <p style="text-align: center;"><a href="#hapud" onclick="loadObs('APROBADO CON CAMBIOS', <?php echo $corredor; ?>)" ><img src="img/iconos/aprobado2.png" height="50px" /></a></p>
                                                                        </div>
                                                                        <div style="clear: both"></div>
                                                                        <p style="text-align: center; color: white;">Aprobar con Cambios</p>
                                                                    </div>                                                                                                        
                                                                    <div class="cuadro_one">
                                                                        <div class="cuadro_two">
                                                                            <p style="text-align: center;"><a href="#volpaq" onclick="loadObs('NO APROBADO', <?php echo $corredor; ?>)" ><img src="img/iconos/noaprobado.png" height="50px" /></a></p>
                                                                        </div>
                                                                        <div style="clear: both"></div>
                                                                        <p style="text-align: center; color: white;">No Aprobado</p>
                                                                    </div>                                                                                    
                                                                    <div style="clear: both"></div>                                                    
                                                                    <br/>                                                                
                                                                    <p id="obstext<?php echo $corredor; ?>">Debe dar clic en una opción</p>
                                                                </div>                                                   
                                                            </div>       
                                                            <div class="row" style="font-size: 15px;">
                                                                <div class="col-lg-5" id="divcomentario<?php echo $corredor ?>">                                                            
                                                                    <h4>Comentarios</h4>
                                                                    <div class="x_content">
                                                                        <ul class="list-unstyled msg_list">
                                                                            <?php
                                                                            $pro->__set('coditem', $item['coditem']);
                                                                            $comentarios = $pro->getComentariosByCodItem();
                                                                            if (count($comentarios) > 0) {
                                                                                foreach ($comentarios as $comment) {
                                                                                    ?>


                                                                                    <li>
                                                                                        <p>
                                                                                            <span class="image">
                                                                                                <img src="img/usuarios/<?php echo $comment['imagen']; ?>" alt="img" />
                                                                                            </span>
                                                                                            <span>
                                                                                                <span><?php echo $comment["desuse"]; ?></span>
                                                                                                <span class="time"><?php echo date("d/m/y h:i", strtotime($comment["fecreg"])); ?></span>
                                                                                            </span>
                                                                                            <span class="message">                                                                                                
                                                                                                <?php echo $comment["comentario"]; ?>                                                                                                
                                                                                                <span class="time"><button onclick="delete_comentario('<?php echo $coditem; ?>', '<?php echo $corredor; ?>', '<?php echo $comment["codigo"]; ?>')" type="button" class="btn btn-danger btn-sm"><span class="fa fa-trash-o"></span></button></span>
                                                                                            </span>                                                                                            
                                                                                        </p>
                                                                                    </li>                                                                                    
                                                                                    <?php
                                                                                }
                                                                            } else {
                                                                                echo '<span class="alert alert-primary">No se encontraron comentarios.</span>';
                                                                            }
                                                                            ?>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br/><br/>
                                                            <div class="row" style="font-size: 15px;">
                                                                <div class="col-lg-5">
                                                                    <p>Agregar comentario:</p>
                                                                    <textarea class="form-control input-sm" name="comentario<?php echo $corredor; ?>" id="comentario<?php echo $corredor; ?>" rows="3" cols="20"></textarea>
                                                                    <p style="margin-top: 2px; text-align: right;"><a class="btn btn-primary btn-sm" href="#divcomentario" onclick="insert_comentario(<?php echo $coditem; ?>, <?php echo $corredor; ?>)">Agregar comentario</a></p>                                                    
                                                                </div>
                                                            </div>



                                                        <?php } else { ?>                                                
                                                            <div class="row">                                                
                                                                <div class="col-lg-6">                                                        
                                                                    <input type="hidden" name="preambt<?php echo $corredor; ?>" step="any" id="preambt<?php echo $corredor; ?>" value="<?php echo $precxdcto; ?>"/>
                                                                    <?php
                                                                    $fau = $pro->calcularFactorAprobacion($precxdcto, $precio_totalE);
                                                                    $fag = $fau + 25;
                                                                    ?>
                                                                    <!--Precio Lista Sin Dscto-->
                                                                    <input type="hidden" name="costototal<?php echo $corredor; ?>"  id="costototal<?php echo $corredor; ?>" value="<?php echo $precio_total; ?>" />
                                                                    <input type="hidden" name="fau<?php echo $corredor; ?>" value="<?php echo ($fau); ?>" />
                                                                    <input type="hidden" name="fag<?php echo $corredor; ?>" value="<?php echo ($fau + 25); ?>" />                                                                                                            
                                                                </div>                                                    
                                                            </div>                                                                                                
                                                            <div class="row"> 
                                                                <div class="col-lg-7">                                                        
                                                                    <input type="hidden" name="estadoitem<?php echo $corredor; ?>" id="estadoitem<?php echo $corredor; ?>" value="APROBADO" />
                                                                    <input type="hidden" name="modificado<?php echo $corredor; ?>" id="modificado<?php echo $corredor; ?>" value="F" />
                                                                </div>                                                   
                                                            </div>                                                                                                     
                                                        <?php } ?>
                                                    </div><!--Aqui termina el divtable-->      
                                                    <br/><br/>                                                                                        
                                                    <!--Fin del cuerpo del item-->
                                                </div>
                                            </div>
                                        </div>
                                        <!--Fin del divitem-->
                                    </div>
                                    <br/>

                                    <?php
                                    $corredor++;
                                }
                            } else {
                                echo 'No se ha registrado ningún item.';
                            }
                            ?>

                            <!-- ESTO ESTÁ FUERA DE TODO-->

                            <br/>
                            <div class="row">
                                <div class="col-lg-12">                                                                                                                               
                                    <p style="text-align: center">                            
                                        <input type="submit" value="OK" class="btn btn-success btn-lg" />
                                        <input type="hidden" id="accion" name="accion" value="AprobPropuesta2" />
                                    </p>                                               
                                </div>
                            </div>
                        </form>
                        <br/>
                        <div id="result"></div>                    
                    </div>                    
                    <script type="text/javascript">

                        function validar() {
                            var codprop = $("#codprop").val();
                            var cliente = $("#combobox").val();
                            if (codprop === "") {
                                alert('Debe escribir nro de proopuesta');
                                $("#codprop").focus();
                                return false;
                            } else if (cliente === "") {
                                alert('Debe seleccionar un cliente');
                                $("#combobox").focus();
                                return false;
                            }
                            return true;
                        }

                        function cerrar() {
                            window.close();
                        }

                        $(document).ready(function () {
                            $("#form").submit(function (e) {
                                e.preventDefault();
                                var rpta = validar();
                                if (rpta === true) {
                                    var f = $(this);
                                    var formData = new FormData(document.getElementById("form"));
                                    var aprobar = $("#estadoaprob").val();
                                    formData.append("estadoaprob", aprobar);
                                    $.ajax({
                                        url: "../controller/C_Propuestas.php",
                                        type: "post",
                                        dataType: "html",
                                        data: formData,
                                        cache: false,
                                        contentType: false,
                                        processData: false
                                    })
                                            .done(function (res) {
                                                $("#result").html(res);
                                            });
                                }
                            });
                        });

                        function setPorcentajes(dscto, costototal, corredor) {
                            var inicio = parseFloat(dscto) - 5;
                            var fin = parseFloat(dscto) + 5;
                            var i = 0;
                            while (inicio <= fin) {
                                $("#lbl" + corredor + i).html(inicio);
                                i++;
                                inicio++;
                            }

                            var home = parseFloat(dscto) - 5;
                            var end = parseFloat(dscto) + 5;
                            var j = 0;
                            var monto = 0;
                            while (home <= end) {

                                var porcent = (1 - (parseFloat(home) / 100));
                                monto = (parseFloat(costototal) * parseFloat(porcent));
                                //alert("monto: "+monto);                            
                                $("#monto" + corredor + j).html(monto.toFixed(2));
                                if (parseFloat(home) === parseFloat(dscto)) {
                                    $("#preambt" + corredor).val(monto.toFixed(2));
                                    $("#preambtshow" + corredor).val(monto.toFixed(2));
                                }
                                j++;
                                home++;
                            }

                            //var precioAMBT = $("#preambt" + corredor).val();                        
                            //var precioTotalE = $("#pretotalE" + corredor).html();
                            //setFactor(precioAMBT, precioTotalE, corredor);
                        }

                        //                    function setFactor(precioAMBT, precioTotalE, corredor) {
                        //
                        //                        var x = parseFloat(precioAMBT) - parseFloat(precioTotalE);
                        //                        var fag = (parseFloat(x) / parseFloat(precioTotalE)) * 100; //Factor Aprobacion Gerencial
                        //                        var fau = parseFloat(fag) - 25; //Factor Aprobacion Usuario                                        
                        //                        var fat = ("#fau" + corredor).val();
                        //                        alert(fat);
                        //                        $("#fau" + corredor).html(fau.toFixed(2));
                        //                        $("#fag" + corredor).html(fag.toFixed(2));
                        //                    }

                        function setdscto(corredor) {
                            var dscto = $("#dscto" + corredor).val();
                            var costototal = $("#costototal" + corredor).val(); //precio sin descuento                                                
                            setPorcentajes(dscto, costototal, corredor);
                            actualizarTabla(corredor);
                        }

                        function actualizarTabla(corredor) {

                            var coditem = $("#pv2_coditem" + corredor).val();
                            var ha = $("#pv2_ha" + corredor).val();
                            var dscto = $("#dscto" + corredor).val();
                            var div = 'divtable' + corredor;
                            var item = [coditem, ha];
                            from_3(dscto, corredor, item, div, '_propuestav2_aprob02_verweb_tbl.php');
                        }

                        function setmonto() {
                            var preambt = $("#preambt").val();
                            var costototal = $("#costototal").html();
                            var perc = 100 * (parseFloat(preambt) / parseFloat(costototal));
                            $("#dscto").val(perc.toFixed(2));
                            var dscto = perc.toFixed(2);
                            setPorcentajes(dscto, costototal);
                        }

                        function loadObs(estado, corredor) {

                            if (estado === 'APROBADO') {
                                $("#estadoitem" + corredor).val("APROBADO");
                                $("#divobs" + corredor).css("display", "none");
                                $("#modificado" + corredor).val("F");
                                $("#obstext" + corredor).html("Usted seleccionó: Aprobar Tal Como Está.");
                            } else if (estado === 'APROBADO CON CAMBIOS') {
                                $("#divobs" + corredor).css("display", "block");
                                $("#estadoitem" + corredor).val("APROBADO");
                                $("#modificado" + corredor).val("T");
                                $("#obstext" + corredor).html("Usted seleccionó: APROBAR CON CAMBIOS.");
                            } else if (estado === 'NO APROBADO') {
                                $("#divobs" + corredor).css("display", "block");
                                $("#estadoitem" + corredor).val("NO APROBADO");
                                $("#modificado" + corredor).val("F");
                                $("#obstext" + corredor).html("Usted seleccionó: NO APROBADO.");
                            }
                        }

                        function insert_comentario(coditem, corredor) {

                            var codprop = $("#codprop").val();
                            var coditem = coditem;
                            var comentario = $("#comentario" + corredor).val();
                            var divcomentario = 'divcomentario' + corredor;
                            if (comentario !== '') {

                                var sendInfo = {
                                    codprop: codprop,
                                    coditem: coditem,
                                    comentario: comentario
                                };

                                $.ajax({
                                    url: '_propuestav2_coment_reg.php',
                                    type: 'GET',
                                    dataType: 'html',
                                    success: function (res) {
                                        //$('<h1/>').text(json.title).appendTo('body');
                                        //$('<div class="content"/>').html(json.html).appendTo('body');
                                        $("#comentario" + corredor).val('');
                                        $("#comentario" + corredor).focus();
                                        //alert('Tu mensaje ha sido agregado :D');
                                    },
                                    error: function (jqXHR, status, error) {
                                        alert('Disculpe, existió un problema');
                                    },
                                    complete: function (jqXHR, status) {

                                        $("#" + divcomentario).load('_propuestav2_coment_list.php?coditem=' + coditem + '&corredor=' + corredor);
                                    },
                                    data: {objeto: sendInfo}
                                });
                                //from_3(codprop, coditem, comentario, divcomentario, '.php');
                            } else {
                                alert("Debe ingresar un comentario.");
                                $("#comentario" + corredor).focus();
                            }
                            //location.reload();
                        }

                        function confirmSubmit()
                        {
                            var agree = confirm("¿Desea ELIMINAR este comentario?");
                            if (agree)
                                return true;
                            else
                                return false;
                        }

                        function delete_comentario(coditem, corredor, codigo) {
                            var divcomentario = 'divcomentario' + corredor;
                            var eliminar = confirmSubmit();

                            if (eliminar) {

                                $.ajax({
                                    url: '_propuestav2_coment_elim.php',
                                    type: 'GET',
                                    dataType: 'html',
                                    success: function (res) {
                                        //alert('Tu mensaje ha sido eliminado');
                                    },
                                    error: function (jqXHR, status, error) {
                                        alert('Disculpe, no se pudo eliminar');
                                    },
                                    complete: function (jqXHR, status) {
                                        $("#" + divcomentario).load('_propuestav2_coment_list.php?coditem=' + coditem + '&corredor=' + corredor);
                                    },
                                    data: {codigo: codigo}
                                });
                            } else {
                                return false;
                            }
                        }
                    </script>
                </body>
            </html>
            <?php
        } else {
            echo '<p style="text-align: center;">';
            echo '<br/><br/><br/><img src="img/iconos/descarte.png" size="50px" /><br/> Lo sentimos. Esta propuesta no existe o fue eliminada.';
            echo '<br/><br/><br/><input type=button value="Cerrar Pagina" onclick="window.close()">';
            echo '</p>';
        }
    } else {
        echo 'Lo sentimos. Este usuario no tiene permisos para acceder a esta página.';
    }
} else {
    echo 'Para consultar estos datos debe iniciar sesión.';
}

function ordenarCarrito($datos) {
    //ordenar array
    foreach ($datos as $clave => $fila) {
        $categoria[$clave] = $fila['ordenta'];
        $producto[$clave] = $fila['ordenprod'];
    }
    array_multisort($categoria, SORT_ASC, $producto, SORT_ASC, $datos);
    return $datos;
}

function getArrayComparacion($opcion, $carrito) {
    $carritoPyK = array();
    $i = 0;
    foreach ($carrito as $valor) {

        if ($valor['codprod'] == 'MAC-0002') {
            array_push($carritoPyK, array('codprod' => $valor['codprod'], 'nomprod' => $valor['nomprod'], 'litros' => 71.76, 'unidades' => 610.00, 'montoce' => 1.41, 'precio' => 895.00));
            unset($carrito[$i]);
        } elseif ($valor['codprod'] == 'MAC-0011') {
            array_push($carritoPyK, array('codprod' => $valor['codprod'], 'nomprod' => $valor['nomprod'], 'litros' => 76.92, 'unidades' => 500.00, 'montoce' => 19.61, 'precio' => 845.00));
            unset($carrito[$i]);
        }
        $i++;
    }
    $carrito = array_values($carrito);

    if ($opcion == 'PyK') {
        return $carritoPyK;
    } else {
        return $carrito;
    }
}

//Funciones
function getTablaComparativa($valor) {

    $tabla = "<div class='row'><div class='col-lg-9' style='margin-left: 10mm;'>
                    <table border='1' style='width: 80%; font-size: 0.9em'>
                    <table class='table1' border='1' style='font-size: 11px; width:100%;' align='left'>
                <thead>
                    <tr style='background-color: #dcdcdc; padding: 10px;'>
                        <td style='text-align:center'>Producto Huma Gro</td>
                        <td style='text-align:center'>Lt/Kg</td>
                        <td style='text-align:center'>Unidades Equivalentes a</td>
                        <td style='text-align:center'>Monto C.E. (mS/cm) aportado al suelo</td>
                        <td style='text-align:center'>Precio</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style='padding: 5px; font-weight: bolder;'>" . $valor['nomprod'] . "</td>
                        <td style='text-align:center'>" . $valor['litros'] . " L</td>
                        <td style='text-align:center'>" . number_format($valor['unidades'], 2) . "</td>
                        <td style='text-align:center'>" . $valor['montoce'] . "</td>
                        <td style='text-align:right'>$ " . number_format($valor['precio'], 2) . "</td>
                    </tr>";
    if ($valor['codprod'] == 'MAC-0002') {
        $tabla .= "<tr>
                            <td>Ácido Fosfórico</td>
                            <td style='text-align:center'>1000 Kg</td>
                            <td style='text-align:center'>610.00</td>
                            <td style='text-align:center'>19.61</td>
                            <td style='text-align:right'>$ 1,180.00</td>
                            </tr>";
    } elseif ($valor['codprod'] == 'MAC-0011') {
        $tabla .= "<tr>
                            <td>Sulfato de Potasio</td>
                            <td style='text-align:center'>1000 Kg</td>
                            <td style='text-align:center'>500.00</td>
                            <td style='text-align:center'>19.61</td>
                            <td style='text-align:right'>$ 925.00</td>
                            </tr>";
    }
    $tabla .= "</tbody>
                        </table>
                        </div></div>";
    return $tabla;
}
?>
