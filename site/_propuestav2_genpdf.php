<?php
date_default_timezone_set("America/Bogota");
include_once '../controller/C_Propuestas.php';
$pro = new C_Propuesta();

$codprop = $_GET['codprop'];
$pro->__set('codprop', $codprop);
$propuesta = $pro->getPropuestasxAprobGerenteByCod();
$detitem = $pro->getItemByCodProp();

function cambiarColorFila($color) {
    if ($color == '#fff') {
        $color = '#F1F1F1'; //blanco humo
    } elseif ($color == '#F1F1F1') {
        $color = '#fff';
    }

    return $color;
}

function colorFilaInicio() {
    return '#fff';
}

function cuenta_veces_valor($array, $valor) {
    $nom_aplic = array_column($array, 'taplicacion');
    $contadores = array_count_values($nom_aplic);
    return $contadores[$valor];
}

function getArrayComparacion($opcion, $carrito) {
    $carritoPyK = array();
    $i = 0;
    foreach ($carrito as $valor) {

        if ($valor['codprod'] == 'MAC-0002') {
            array_push($carritoPyK, array('codprod' => $valor['codprod'], 'nomprod' => $valor['nombre'], 'litros' => 71.76, 'unidades' => 610.00, 'montoce' => 1.41, 'precio' => 895.00));
            unset($carrito[$i]);
        } elseif ($valor['codprod'] == 'MAC-0011') {
            array_push($carritoPyK, array('codprod' => $valor['codprod'], 'nomprod' => $valor['nombre'], 'litros' => 76.92, 'unidades' => 500.00, 'montoce' => 19.61, 'precio' => 845.00));
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

function getTablaComparativa($valor) {

    $tabla = "<table class='table1' border='1' style='font-size: 9px;' align='left'>
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
                        <td style='padding: 5px; font-weight: bolder; width: 40mm;'>" . $valor['nomprod'] . "</td>
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
                        </table>";
    return $tabla;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />     
        <style>            
            ol li {
                list-style-type: lower-latin;
            }

            .row {
                margin-right: 5mm;
                margin-left: 3mm;
                width: 175mm;
                font-size: 11px;
                padding-left: 5mm;
            }

            .row-tablemargen {                
                margin-left: 10mm;
                width: 170mm;
            }

            .row:before,
            .row:after {
                display: table;
                content: " ";
            }

            .row:after {
                clear: both;
            }

            .row:before,
            .row:after {
                display: table;
                content: " ";
            }

            .row:after {
                clear: both;
            }


            .col-lg-1,            
            .col-lg-2,            
            .col-lg-3,            
            .col-lg-4,            
            .col-lg-5,            
            .col-lg-6,            
            .col-lg-7,            
            .col-lg-8,            
            .col-lg-9,            
            .col-lg-10,            
            .col-lg-11,            
            .col-lg-12 {
                position: relative;
                min-height: 1px;
                padding-right: 15px;
                padding-left: 15px;
            }

            .table-striped > tbody > tr:nth-child(odd) > td,
            .table-striped > tbody > tr:nth-child(odd) > th {
                background-color: #f9f9f9;
            }

            table {
                max-width: 100%;
                background-color: transparent;                                
            }

            th {
                text-align: left;
            }

            .table1 {
                width: 100%;
                margin-bottom: 20px;
                border-collapse: collapse;
                border-color: #00FF00;                
                font-size: 9px;
            }

            .table1 td { vertical-align: middle; padding: 3px 3px 3px 3px;}
            .table1 tr:nth-child(even) {
                background-color: #666666;
            }

            /*.table1  thead  tr  td { padding-top: 27px; padding-bottom: 7px; }*/

            .table > thead > tr > th,
            .table > tbody > tr > th,
            .table > tfoot > tr > th,
            .table > thead > tr > td,
            .table > tbody > tr > td,
            .table > tfoot > tr > td {
                padding: 8px;
                line-height: 1.428571429;
                vertical-align: top;
                border-top: 1px solid #666666;
            }

            .table > thead > tr > th {
                vertical-align: bottom;
                border-bottom: 2px solid #dddddd;
            }

            .table > caption + thead > tr:first-child > th,
            .table > colgroup + thead > tr:first-child > th,
            .table > thead:first-child > tr:first-child > th,
            .table > caption + thead > tr:first-child > td,
            .table > colgroup + thead > tr:first-child > td,
            .table > thead:first-child > tr:first-child > td {
                border-top: 0;
            }

            .table > tbody + tbody {
                border-top: 2px solid #dddddd;
            }

            .table .table {
                background-color: #ffffff;
            }

            .pagina { }


            .row { margin-top: 5px;}
            .obl { font-weight: bolder; color: red; } 
            .numericos { padding: 2px; width: 90%; height: 23px; }
            .txtnum { width: 100px; }         
            .mas {vertical-align: middle; float: left; text-align: center; min-height: 45px; display: flex; align-items: center; margin-left: 3px; margin-right: 3px;}
            .cuadrito { vertical-align: middle; font-size: 9px; text-align: center; width: auto; min-height: 45px; height: auto; background-color: #e8e8e8; padding-top: 3px; margin-left: 5px; margin-right: 5px; float: left; border-color: #000000; border-style: ridge; border-width: 1px; }
            .cuadront { float: left; background-color: #e8e8e8; min-height: 45px; text-align: center; font-size: 9px; }
            .cuadrito2 { font-size: 0.9em; text-align: center; border-style: double; border-width: 1px; border-color: #000; padding: 3px; }

            .cuadro_two { float: left; height: 80px; width: 90px; background-color: #e2e2e2; align-items: center; padding-top: 10px; }
            .cuadro_one {float: left; padding: 5px; height: 125px; width: 100px; background-color:  #666666; margin-right: 10px; }
            .asunto { text-indent: 30px;  }
            .asunto span { text-decoration: underline; font-weight: 400; }
            .pruebaa { font-size: 10px; }
            .textcurvo { font-style: italic; text-decoration: underline; font-weight: 400;  }


        </style>                          
    </head>
    <body>        
        <div class="row">
            <div class="col-lg-7">
                <table>
                    <tr>
                        <td style="width: 60mm; text-align: left;"><img src="img/iconos/logo1.jpg" height="70px;" /></td>
                        <td style="width: 65mm; text-align: center;"><img src="img/iconos/logo2.jpg" height="70px;" /></td>
                        <td style="width: 60mm; text-align: center;"><img src="img/iconos/logo3.jpg" height="70px;" /></td>
                    </tr>
                </table>                    
            </div>
        </div>
        <div class="row">
            <div class="col-lg-7" style="text-align: right; font-size: 11px;">
                Lima, <?php echo date("d/m/Y", strtotime($propuesta[4])); ?><br/>                        
                <strong><?php echo $propuesta[0]; ?></strong>
            </div>
        </div>    
        <div class="row">
            <div class="col-lg-7" style="font-size: 11px;">
                <?php echo $propuesta[20] . ' ' . $propuesta[5]; ?><br/>
                <?php echo $propuesta[2]; ?><br/>                        
            </div>
        </div>
        <div class="row">
            <div class="col-lg-7">
                <p class="">
                    Presente,
                </p>
                <p class="">
                    <span class="asunto"><strong>Asunto: </strong></span><span><em><strong><?php echo $propuesta[6]; ?></strong></em></span>
                </p>                    
                <p style="text-align: justify;"><?php echo $propuesta[3]; ?></p>
            </div>
        </div>

        <?php
        $ndetitem = count($detitem);
        if ($ndetitem > 0) {
            foreach ($detitem as $item) {
                ?>
                <div class="row">
                    <div class="col-lg-7"> 
                        <div style="background-color: #cccccc; padding: 2mm; width: 158mm; margin-left: 5mm; text-align: center;"><?php echo $item['itemdesc']; ?></div>
                    </div>
                </div>
                <?php
                $pro->__set('coditem', $item['coditem']);
                $ha = $item['ha'];
                $dcto = $item['descuento'];
                $plantilla = $item['plantilla'];
                $nitrogeno = $item['nitrogeno'];
                $pud = $item['pud'];
                $incluyeigv = $item['incluyeigv'];
                $valigv = $item['valigv'];
                $pup = $item['pup'];
                $verfc = $item['verfc'];
                $pyk = $item['pyk'];


                if ($plantilla == "HECTAREA PAQ") {

                    if ($pup == 't') {
                        $carrito = $pro->getDetallePropxAprobGerenteByCodProp();
                        $precio_total = 0;
                        $precio_totalA = 0;
                        $precio_totalE = 0;

                        //Recoger productos para el Comparativo entre Humagro y Convencional
                        $productosPyK = array();
                        $productosPUP = $item;

                        if ($pyk == 't') {
                            $productosPyK = getArrayComparacion('PyK', $carrito);
                            $productosPUP = getArrayComparacion('', $carrito);
                            if (count($productosPyK) > 0) {
                                ?>
                                <div class="row">
                                    <div class="col-lg-7"> 
                                        <p class="textcurvo">Análisis económico de la comparación de la fuente FOSFORO Y POTASIO de los productos Huma Gro Vs Convencionales:</p>
                                    </div>
                                </div>
                                <br/>
                                <?php
                                foreach ($productosPyK as $valor) {
                                    $tabla = getTablaComparativa($valor);
                                    echo '<div class="row-tablemargen"><div class="col-lg-7" style="margin-left: 10mm;">';
                                    echo $tabla;
                                    echo '</div></div>';
                                    echo '<br/>';
                                }
                            }
                        }
                        ?>
                        <div class="row">
                            <div class="col-lg-7"> 
                                <p class="textcurvo">Análisis Económico:</p>
                            </div>
                        </div>
                        <br/>        
                        <?php
                        foreach ($carrito as $producto) {

                            $codprod = $producto['codprod'];
                            $ltxha = ($producto['cantidad'] * $ha);

                            $costo_total = $ltxha * $producto['costo'];
                            $costo_total_dcto = $ltxha * $producto['preciodcto'];

                            $precio_total+= $costo_total;
                            ?>                                    
                            <div class="row-tablemargen">
                                <div class="col-lg-7" style="margin-left: 10mm;">
                                    <table class="table1" border="1" style=" font-size: 9px;" align="left">
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
                                                <td style="width: 40mm;"><?php echo $producto['nombre']; ?></td>
                                                <td style="text-align: center;"><?php echo number_format($producto['cantidad'], 2); ?></td>
                                                <td style="text-align: center;"><?php echo number_format($ltxha, 2); ?></td>
                                                <td style="text-align: center;">$ <?php echo $producto['costo']; ?></td>
                                                <td style="text-align: center;">$ <?php echo $producto['preciodcto']; ?></td>
                                                <td style="text-align: center;">$<?php echo number_format($costo_total, 2); ?></td>                                        
                                            </tr>
                                            <tr>
                                                <td colspan="1" style="border-left: 0px; border-bottom: 0px;"></td>
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
                        echo '<br/>';
                        echo '<br/>';
                        //FIN DE PRECIO UNITARIO CON DESCUENTO POR PRODUCTO
                    } elseif ($pup == 'f') {


                        $carrito = $pro->getDetallePropxAprobGerenteByCodProp();

                        //*****MOSTRAR UNIDADES
                        $vectorund = $pro->getUnidades();
                        $aplicaciones = array_unique(array_column($carrito, 'taplicacion'));
                        ?>
                        <div class="row" style="margin-left: -40mm; text-align: center;">
                            <div class="">
                                <table>
                                    <tr>                                        
                                        <?php
                                        $napp = 0;
                                        $asterisco = FALSE;
                                        $slash = FALSE;
                                        foreach ($aplicaciones as $app) {

                                            $nomapp = $app;
                                            $novo_texto = wordwrap($nomapp, 10, "<br />\n");
                                            //echo "$novo_texto\n";

                                            if ($napp == 0) {

                                                if ($novo_texto == trim('FERTIRRIEGO')) {
                                                    if (count($vectorund) > 0) {
                                                        foreach ($vectorund as $valund) {
                                                            if ($valund['codnut'] == 'N' && $nitrogeno == 'no') {
                                                                if ($verfc == 't') {
                                                                    echo '<td><table border="1" style="border-collapse: collapse;"><tr><td class="cuadront"><strong>' . $valund['codnut'] . '</strong></td></tr><tr><td style="font-size: 10px; padding: 3px;">' . $valund['unidad'] . '</td></tr><tr><td>' . $valund['fc'] . '</td></tr></table></td>';
                                                                } else {
                                                                    echo '<td><table border="1" style="border-collapse: collapse;"><tr><td class="cuadront"><strong>' . $valund['codnut'] . '</strong></td></tr><tr><td style="font-size: 10px; padding: 3px;">' . $valund['unidad'] . '</td></tr></table></td>';
                                                                }
                                                                echo '<td class="mas">/</td>';
                                                                $slash = TRUE;
                                                            } elseif ($valund['codnut'] == 'N' && $nitrogeno == '50') {
                                                                if ($verfc == 't') {
                                                                    echo '<td><table border="1" style="border-collapse: collapse;"><tr><td class="cuadront"><strong>' . $valund['codnut'] . '</strong></td></tr><tr><td style="font-size: 10px; padding: 3px;">' . number_format($valund['unidad'], 2) . '</td></tr><tr><td>' . $valund['fc'] . '</td></tr></table></td>';
                                                                } else {
                                                                    echo '<td><table border="1" style="border-collapse: collapse;"><tr><td class="cuadront"><strong>' . $valund['codnut'] . '</strong></td></tr><tr><td style="font-size: 10px; padding: 3px;">' . number_format($valund['unidad'], 2) . '</td></tr></table></td>';
                                                                }
                                                                echo '<td class="mas">*</td>';
                                                                $asterisco = TRUE;
                                                            } else {
                                                                if ($verfc == 't') {
                                                                    echo '<td><table border="1" style="border-collapse: collapse;"><tr><td class="cuadront"><strong>' . $valund['codnut'] . '</strong></td></tr><tr><td style="font-size: 10px; padding: 3px;">' . number_format($valund['unidad'], 2) . '</td></tr><tr><td>' . $valund['fc'] . '</td></tr></table></td>';
                                                                } else {
                                                                    echo '<td><table border="1" style="border-collapse: collapse;"><tr><td class="cuadront"><strong>' . $valund['codnut'] . '</strong></td></tr><tr><td style="font-size: 10px; padding: 3px;">' . number_format($valund['unidad'], 2) . '</td></tr></table></td>';
                                                                }
                                                            }
                                                        }
                                                    }
                                                } else {
                                                    echo '<td class="cuadrito">' . $novo_texto . '</td>';
                                                }
                                            } else {
                                                echo '<td class="mas">+</td><td class="cuadrito">' . $novo_texto . '</td>';
                                            }
                                            $napp++;
                                        }
                                        //Area Presuepuestada
                                        ?>
                                    </tr>
                                </table>                                
                            </div>
                        </div>
                        <?php
                        if ($asterisco || $slash) {
                            ?>
                            <div class="row">
                                <div class="col-lg-7">
                                    <p style="font-size: 9px;">
                                        <?php
                                        if ($asterisco)
                                            echo '(*) Solo se considera el 50% de Nitrogeno.';
                                        if ($slash)
                                            echo '(/) No se considera Nitrogeno.';
                                        ?>
                                    </p>
                                </div>
                            </div>
                            <?php
                        }

                        //CREANDO ARREGLOS PARA PRODUCTOS CONGELADOS Y NO CONGELADOS

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
                        //ORDENAR ARREGLO
                        sort($array_pncong);
                        ?>
                        <!--*****MOSTRAR TABLA DE PRODUCTOS-->
                        <div class="row">
                            <div class="col-lg-7"> 
                                <p class="textcurvo">Análisis Económico:</p>
                            </div>
                        </div>
                        <br/>  
                        <?php
                        if ($pud == 't') {
                            ?>                        
                            <div class="row-tablemargen">
                                <div class="col-lg-7">
                                    <table class="table1" border="1" style=" font-size: 9px;" align="center">
                                        <thead>
                                            <tr>
                                                <td colspan="2" style="background-color: #a5db72; text-align: center; vertical-align: middle;">Área Presupuestada</td>
                                                <td style="vertical-align: middle; text-align: right; padding-right: 5px;"><?php echo $ha; ?></td>
                                                <td style="vertical-align: middle; padding-left: 5px;">Ha.</td>
                                                <td colspan="2" style="border-top: 0px; border-right: 0px; border-bottom: 0px;"></td>
                                                <td style="border-top: 0px; border-right: 0px; border-bottom: 0px;"></td>                                                
                                            </tr>
                                            <tr>
                                                <td colspan="6" style="border-left: 0px; border-right: 0px;"></td>                                                
                                                <td style="border-right: 0px;"></td>                                                                                       
                                            </tr>
                                            <tr style="background-color: #a5db72;">
                                                <td style="width: 27mm; text-align: center;">Aplicación</td>
                                                <td style="width: 38mm; text-align: center;">Producto</td>
                                                <td style="width: 10mm; text-align: center;">Lts/Ha</td>
                                                <td style="width: 15mm; text-align: center; font-size: 8.5px;">Lts/<?php echo $ha; ?> Ha.</td>
                                                <td style="width: 13mm; text-align: center; vertical-align: middle;">Precio Unit</td>                                                   
                                                <td  style="width: 16mm; text-align: center; font-size: 8.5px;">Precio U Dscto</td>                                                
                                                <td style="width: 15mm; text-align: center;">Precio Total</td>
                                            </tr>
                                        </thead>
                                        <tbody style="">
                                            <?php
                                            $total_general = 0;
                                            $indice = 0;
                                            $indice_aplicacion = 0;
                                            $color = colorFilaInicio(); //blanco
                                            $precio_totalcongelado = 0;
                                            $precio_totalnocong = 0;

                                            foreach ($carrito as $productos) {
                                                $ltxha = $productos['cantidad'] * $ha;
                                                if ($pud == 'f') {
                                                    $precio_total = $ltxha * $productos['costo'];
                                                } else {
                                                    $precio_total = $ltxha * $productos['preciodcto'];
                                                }

                                                if ($productos['congelado'] == 't') {
                                                    $costo_congelado = $productos['preciodcto'] * $ltxha;
                                                    $precio_totalcongelado+= $costo_congelado;
                                                    $precio_totalnocong+= $precio_total;
                                                }

                                                $total_general+=$precio_total;
                                                ?>
                                                <tr style="background-color: <?php echo $color; ?>">
                                                    <?php
                                                    //******************* TIPO DE APLICACIÓN                                            
                                                    /* Algoritmo para mostrar Tipo de Aplicaciones */
                                                    if ($indice == $indice_aplicacion) {
                                                        $nom_aplicacion = $carrito[$indice]['taplicacion'];
                                                        $numeroindice = cuenta_veces_valor($carrito, $nom_aplicacion);
                                                        echo '<td rowspan="' . $numeroindice . '">' . $productos['taplicacion'] . '</td>';
                                                        $indice_aplicacion += $numeroindice;
                                                    }

                                                    /* Algoritmo Antiguo para mostrar Tipo de Aplicaciones
                                                      if ($indice > 0) {
                                                      $indiceant = $indice - 1;

                                                      if ($carrito[$indice]['taplicacion'] <> $carrito[$indiceant]['taplicacion']) {
                                                      //echo $productos['taplicacion'];
                                                      }
                                                      } else {
                                                      //echo $productos['taplicacion'];
                                                      } */
                                                    $indice++;

                                                    //echo '</td>';
                                                    ?>
                                                    <td><?php echo $productos['nombre'] ?></td>
                                                    <td style="vertical-align: middle; text-align: right; padding-right: 3px;"><?php echo number_format($productos['cantidad'], 2); ?></td>
                                                    <td style="vertical-align: middle; text-align: right; padding-right: 3px;"><?php echo number_format($ltxha, 2); ?></td>
                                                    <td style="vertical-align: middle; text-align: right; padding-right: 3px;">$<?php echo $productos['costo'] ?></td>
                                                    <?php if ($pud == 't') { ?>                                    
                                                        <td style="vertical-align: middle; text-align: right; padding-right: 3px;">$ <?php echo $productos['preciodcto']; ?></td>
                                                    <?php } ?>
                                                    <td style="vertical-align: middle; text-align: right; padding-right: 3px;">$<?php echo number_format($precio_total, 2); ?></td>
                                                </tr>
                                                <?php
                                                $color = cambiarColorFila($color);
                                            }
                                            if ($pud <> 't') {
                                                ?>
                                                <tr>
                                                    <td colspan="2" style="border-left: 0px; border-bottom: 0px; border-right: 0px;"></td>
                                                    <td colspan="2" style="border-left: 0px;"></td>
                                                    <td colspan="1" style="padding-top: 4px; padding-bottom: 4px; text-align: center;">Sub Total</td>
                                                    <td style="padding-top: 4px; padding-bottom: 4px; text-align: right;">$<?php echo number_format($total_general, 2); ?></td>                        
                                                </tr>
                                            <?php } ?>
                                            <tr>

                                                <?php
                                                $preciorestado = ($total_general - $precio_totalnocong);
                                                if ($pud == 't') {
                                                    $precioAMBT = $pro->calcularPrecioAMBT(0, $preciorestado, $precio_totalcongelado);
                                                } else {
                                                    $precioAMBT = $pro->calcularPrecioAMBT($dcto, $preciorestado, $precio_totalcongelado);
                                                }


                                                if ($pud == 't') {
                                                    $col1 = 2;
                                                    echo '<td colspan="3" style="border-left: 0px; border-bottom: 0px;"></td>';
                                                } else {
                                                    $col1 = 2;
                                                    echo '<td colspan="2" style="border-left: 0px; border-bottom: 0px;"></td>';
                                                }
                                                ?>                                              
                                                <td colspan="<?php echo $col1; ?>" style="padding-top: 4px; padding-bottom: 4px; border-top: 1px; text-align: right;">Precio con descuento</td>
                                                <td colspan="1" style="padding-top: 4px; padding-bottom: 4px; text-align: center;">Total</td>
                                                <td style="padding-top: 4px; padding-bottom: 4px; text-align: right;"><strong>$<?php echo number_format($precioAMBT, 2); ?></strong></td>
                                            </tr>


                                            <?php
                                            if ($ha > 1) {
                                                $precxha = $precioAMBT / $ha;
                                                ?> 
                                                <tr>

                                                    <?php
                                                    if ($pud == 't') {
                                                        $col2 = 3;
                                                        echo '<td colspan="3" style="border-left: 0px; border-bottom: 0px;"></td>';
                                                    } else {
                                                        $col2 = 3;
                                                        echo '<td colspan="2" style="border-left: 0px; border-bottom: 0px;"></td>';
                                                    }
                                                    ?>                                                    
                                                    <td colspan="<?php echo $col2; ?>" style="padding-top: 4px; padding-bottom: 4px; text-align: right;">Precio con descuento / Hectárea</td>                            
                                                    <td style="padding-top: 4px; padding-bottom: 4px; text-align: right;">$<?php echo number_format($precxha, 2); ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>                       
                            <?php
                        } elseif ($pud == 'f') {
                            ?>
                            <div class="row-tablemargen">
                                <div class="col-lg-7">
                                    <?php
                                    if (count($array_pcong) == 0) {
                                        //***** P O R C E N T A J E
                                        ?>
                                        <table class="table1" border="1" style=" font-size: 9px;" align="center">
                                            <thead>
                                                <tr>
                                                    <td colspan="2" style="background-color: #a5db72; text-align: center; vertical-align: middle;">Área Presupuestada</td>
                                                    <td style="vertical-align: middle; text-align: right; padding-right: 5px;"><?php echo $ha; ?></td>
                                                    <td style="vertical-align: middle; padding-left: 5px;">Ha.</td>
                                                    <td colspan="2" style="border-top: 0px; border-right: 0px; border-bottom: 0px;"></td>                                        
                                                    <?php if ($pud == 't') { ?>
                                                        <td style="border-top: 0px; border-right: 0px; border-bottom: 0px;"></td>
                                                    <?php } ?>
                                                </tr>
                                                <tr>
                                                    <td colspan="6" style="border-left: 0px; border-right: 0px;"></td>
                                                    <?php if ($pud == 't') { ?>                                        
                                                        <td style="border-right: 0px;"></td>                                        
                                                    <?php } ?>
                                                </tr>
                                                <tr style="background-color: #a5db72;">
                                                    <td style="width: 27mm; text-align: center;">Aplicación</td>
                                                    <td style="width: 38mm; text-align: center;">Producto</td>
                                                    <td style="width: 10mm; text-align: center;">Lts/Ha</td>
                                                    <td style="width: 15mm; text-align: center; font-size: 8.5px;">Lts/<?php echo $ha; ?> Ha.</td>
                                                    <td style="width: 13mm; text-align: center; vertical-align: middle;">Precio Unit</td>   
                                                    <?php if ($pud == 't') { ?>
                                                        <td  style="width: 16mm; text-align: center; font-size: 8.5px;">Precio U Dscto</td>
                                                    <?php } ?>
                                                    <td style="width: 15mm; text-align: center;">Precio Total</td>
                                                </tr>
                                            </thead>
                                            <tbody style="">
                                                <?php
                                                $total_general = 0;
                                                $indice = 0;
                                                $indice_aplicacion = 0;
                                                $color = colorFilaInicio(); //blanco
                                                $precio_totalcongelado = 0;
                                                $precio_totalnocong = 0;



                                                foreach ($carrito as $productos) {
                                                    $ltxha = $productos['cantidad'] * $ha;
                                                    if ($pud == 'f') {
                                                        $precio_total = $ltxha * $productos['costo'];
                                                    } else {
                                                        $precio_total = $ltxha * $productos['preciodcto'];
                                                    }

                                                    if ($productos['congelado'] == 't') {
                                                        $costo_congelado = $productos['preciodcto'] * $ltxha;
                                                        $precio_totalcongelado+= $costo_congelado;
                                                        $precio_totalnocong+= $precio_total;
                                                    }

                                                    $total_general+=$precio_total;
                                                    ?>
                                                    <tr style="background-color: <?php echo $color; ?>">
                                                        <?php
                                                        //******************* TIPO DE APLICACIÓN                                            
                                                        /* Algoritmo para mostrar Tipo de Aplicaciones */
                                                        if ($indice == $indice_aplicacion) {
                                                            $nom_aplicacion = $carrito[$indice]['taplicacion'];
                                                            $numeroindice = cuenta_veces_valor($carrito, $nom_aplicacion);
                                                            echo '<td rowspan="' . $numeroindice . '">' . $productos['taplicacion'] . '</td>';
                                                            $indice_aplicacion += $numeroindice;
                                                        }

                                                        /* Algoritmo Antiguo para mostrar Tipo de Aplicaciones
                                                          if ($indice > 0) {
                                                          $indiceant = $indice - 1;

                                                          if ($carrito[$indice]['taplicacion'] <> $carrito[$indiceant]['taplicacion']) {
                                                          //echo $productos['taplicacion'];
                                                          }
                                                          } else {
                                                          //echo $productos['taplicacion'];
                                                          } */
                                                        $indice++;

                                                        //echo '</td>';
                                                        ?>
                                                        <td><?php echo $productos['nombre'] ?></td>
                                                        <td style="vertical-align: middle; text-align: right; padding-right: 3px;"><?php echo number_format($productos['cantidad'], 2); ?></td>
                                                        <td style="vertical-align: middle; text-align: right; padding-right: 3px;"><?php echo number_format($ltxha, 2); ?></td>
                                                        <td style="vertical-align: middle; text-align: right; padding-right: 3px;">$<?php echo $productos['costo'] ?></td>
                                                        <?php if ($pud == 't') { ?>                                    
                                                            <td style="vertical-align: middle; text-align: right; padding-right: 3px;">$ <?php echo $productos['preciodcto']; ?></td>
                                                        <?php } ?>
                                                        <td style="vertical-align: middle; text-align: right; padding-right: 3px;">$<?php echo number_format($precio_total, 2); ?></td>
                                                    </tr>
                                                    <?php
                                                    $color = cambiarColorFila($color);
                                                }
                                                if ($pud <> 't') {
                                                    ?>
                                                    <tr>
                                                        <td colspan="2" style="border-left: 0px; border-bottom: 0px; border-right: 0px;"></td>
                                                        <td colspan="2" style="border-left: 0px;"></td>
                                                        <td colspan="1" style="padding-top: 4px; padding-bottom: 4px; text-align: center;">Sub Total</td>
                                                        <td style="padding-top: 4px; padding-bottom: 4px; text-align: right;">$<?php echo number_format($total_general, 2); ?></td>                        
                                                    </tr>
                                                <?php } ?>
                                                <tr>

                                                    <?php
                                                    $preciorestado = ($total_general - $precio_totalnocong);
                                                    if ($pud == 't') {
                                                        $precioAMBT = $pro->calcularPrecioAMBT(0, $preciorestado, $precio_totalcongelado);
                                                    } else {
                                                        $precioAMBT = $pro->calcularPrecioAMBT($dcto, $preciorestado, $precio_totalcongelado);
                                                    }


                                                    if ($pud == 't') {
                                                        $col1 = 2;
                                                        echo '<td colspan="3" style="border-left: 0px; border-bottom: 0px;"></td>';
                                                    } else {
                                                        $col1 = 2;
                                                        echo '<td colspan="2" style="border-left: 0px; border-bottom: 0px;"></td>';
                                                    }
                                                    ?>                                              
                                                    <td colspan="<?php echo $col1; ?>" style="padding-top: 4px; padding-bottom: 4px; border-top: 1px; text-align: right;">Precio con descuento</td>
                                                    <td colspan="1" style="padding-top: 4px; padding-bottom: 4px; text-align: center;">Total</td>
                                                    <td style="padding-top: 4px; padding-bottom: 4px; text-align: right;"><strong>$<?php echo number_format($precioAMBT, 2); ?></strong></td>
                                                </tr>


                                                <?php
                                                if ($ha > 1) {
                                                    $precxha = $precioAMBT / $ha;
                                                    ?> 
                                                    <tr>

                                                        <?php
                                                        if ($pud == 't') {
                                                            $col2 = 3;
                                                            echo '<td colspan="3" style="border-left: 0px; border-bottom: 0px;"></td>';
                                                        } else {
                                                            $col2 = 3;
                                                            echo '<td colspan="2" style="border-left: 0px; border-bottom: 0px;"></td>';
                                                        }
                                                        ?>                                                    
                                                        <td colspan="<?php echo $col2; ?>" style="padding-top: 4px; padding-bottom: 4px; text-align: right;">Precio con descuento / Hectárea</td>                            
                                                        <td style="padding-top: 4px; padding-bottom: 4px; text-align: right;">$<?php echo number_format($precxha, 2); ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>

                                        <?php
                                    } else {
                                        //**** M I X T O
                                        ?>
                                        <table class="table1" border="1" style=" font-size: 9px;" align="center">
                                            <thead>
                                                <tr>
                                                    <td colspan="2" style="background-color: #a5db72; text-align: center; vertical-align: middle;">Área Presupuestada</td>
                                                    <td style="vertical-align: middle; text-align: right; padding-right: 5px;"><?php echo $ha; ?></td>
                                                    <td style="vertical-align: middle; padding-left: 5px;">Ha.</td>
                                                    <td colspan="2" style="border-top: 0px; border-right: 0px; border-bottom: 0px;"></td>                                                    
                                                </tr>
                                                <tr>
                                                    <td colspan="6" style="border-left: 0px; border-right: 0px;"></td>                                                    
                                                </tr>
                                                <tr style="background-color: #a5db72;">
                                                    <td style="width: 27mm; text-align: center;">Aplicación</td>
                                                    <td style="width: 38mm; text-align: center;">Producto</td>
                                                    <td style="width: 10mm; text-align: center;">Lts/Ha</td>
                                                    <td style="width: 15mm; text-align: center; font-size: 8.5px;">Lts/<?php echo $ha; ?> Ha.</td>
                                                    <td style="width: 13mm; text-align: center; vertical-align: middle;">Precio Unit</td>                                                    
                                                    <td style="width: 15mm; text-align: center;">Precio Total</td>
                                                </tr>
                                            </thead>
                                            <tbody style="">
                                                <?php
                                                $total_no_congelado = 0;
                                                $total_si_congelado = 0;
                                                $total_con_dcto = 0;

                                                $total_general = 0;
                                                $indice = 0;
                                                $indice_aplicacion = 0;
                                                $color = colorFilaInicio(); //blanco
                                                $precio_totalcongelado = 0;
                                                $precio_totalnocong = 0;


                                                //PRODUCTOS PORCENTAJES
                                                foreach ($carrito as $productos) {
                                                    if ($productos['congelado'] == 'f') {
                                                        $ltxha = $productos['cantidad'] * $ha;
                                                        $precio_total = $ltxha * $productos['costo'];

                                                        if ($productos['congelado'] == 't') {
                                                            $costo_congelado = $productos['preciodcto'] * $ltxha;
                                                            $precio_totalcongelado+= $costo_congelado;
                                                            $precio_totalnocong+= $precio_total;
                                                        }

                                                        //$total_general+=$precio_total;
                                                        $total_no_congelado+=$precio_total;
                                                        ?>
                                                        <tr style="background-color: <?php echo $color; ?>">
                                                            <?php
                                                            //******************* TIPO DE APLICACIÓN                                            
                                                            /* Algoritmo para mostrar Tipo de Aplicaciones */
                                                            if ($indice == $indice_aplicacion) {
                                                                $nom_aplicacion = $carrito[$indice]['taplicacion'];
                                                                $numeroindice = cuenta_veces_valor($carrito, $nom_aplicacion);
                                                                echo '<td rowspan="' . $numeroindice . '">' . $productos['taplicacion'] . '</td>';
                                                                $indice_aplicacion += $numeroindice;
                                                            }
                                                            $indice++;
                                                            ?>
                                                            <td><?php echo $productos['nombre'] ?></td>
                                                            <td style="vertical-align: middle; text-align: right; padding-right: 3px;"><?php echo number_format($productos['cantidad'], 2); ?></td>
                                                            <td style="vertical-align: middle; text-align: right; padding-right: 3px;"><?php echo number_format($ltxha, 2); ?></td>
                                                            <td style="vertical-align: middle; text-align: right; padding-right: 3px;">$<?php echo $productos['costo'] ?></td>                                                            
                                                            <td style="vertical-align: middle; text-align: right; padding-right: 3px;">$<?php echo number_format($precio_total, 2); ?></td>
                                                        </tr>
                                                        <?php
                                                        $color = cambiarColorFila($color);
                                                    }
                                                }
                                                $total_con_dcto = $total_no_congelado * (1 - ($dcto / 100));
                                                ?>
                                                <tr>                                                    
                                                    <td colspan="3" style="border-left: 0px; border-bottom: 0px; border-right: 0px;"></td>                                                    
                                                    <td colspan="1" style="padding-top: 4px; padding-bottom: 4px; text-align: center;">Sub Total</td>
                                                    <td style="padding-top: 4px; padding-bottom: 4px; text-align: right;">$<?php echo number_format($total_no_congelado, 2); ?></td>
                                                </tr>
                                                <tr>                                    
                                                    <td colspan="2"></td>
                                                    <td colspan="2" style="background-color: #adc676; text-align: right;">Precio Total de Productos con Dscto por Paquete.</td>
                                                    <td style="background-color: #adc676; text-align: right;">$<?php echo number_format($total_con_dcto, 2); ?></td>                                                    
                                                </tr>                            
                                                <tr>
                                                    <td colspan="6"></td>
                                                </tr>    
                                                <?php
                                                //PUD
                                                $indice = 0;
                                                //$indice_aplicacion = 0;
                                                foreach ($carrito as $productos) {
                                                    if ($productos['congelado'] == 't') {
                                                        $ltxha = $productos['cantidad'] * $ha;
                                                        $precio_total = $ltxha * $productos['preciodcto'];

                                                        //$total_general+=$precio_total;
                                                        $total_si_congelado+=$precio_total;
                                                        ?>
                                                        <tr style="background-color: <?php echo $color; ?>">
                                                            <td></td>
                                                            <?php
                                                            //******************* TIPO DE APLICACIÓN                                            
                                                            /* Algoritmo para mostrar Tipo de Aplicaciones */
                                                            if ($indice == $indice_aplicacion) {
                                                                $nom_aplicacion = $carrito[$indice]['taplicacion'];
                                                                $numeroindice = cuenta_veces_valor($carrito, $nom_aplicacion);
                                                                echo '<td rowspan="' . $numeroindice . '">' . $productos['taplicacion'] . '</td>';
                                                                $indice_aplicacion += $numeroindice;
                                                            }
                                                            $indice++;
                                                            ?>
                                                            <td><?php echo $productos['nombre'] ?></td>
                                                            <td style="vertical-align: middle; text-align: right; padding-right: 3px;"><?php echo number_format($productos['cantidad'], 2); ?></td>
                                                            <td style="vertical-align: middle; text-align: right; padding-right: 3px;"><?php echo number_format($ltxha, 2); ?></td>
                                                            <td style="vertical-align: middle; text-align: right; padding-right: 3px;">$<?php echo $productos['preciodcto'] ?></td>
                                                            <td style="vertical-align: middle; text-align: right; padding-right: 3px;">$<?php echo number_format($precio_total, 2); ?></td>
                                                        </tr>
                                                        <?php
                                                        $color = cambiarColorFila($color);
                                                    }
                                                }
                                                ?>
                                                <tr>                                
                                                    <td colspan="3"></td>
                                                    <td colspan="2" style="background-color: #adc676; text-align: right;">Precio Total Productos sin Dscto por Paquete.</td>                    
                                                    <td style="background-color: #adc676; text-align: right;">$<?php echo number_format($total_si_congelado, 2); ?></td>                                                    
                                                </tr>
                                                <tr>
                                                    <td colspan="6"></td>
                                                </tr>
                                                <?php
                                                $sub_total = $total_no_congelado + $total_si_congelado;
                                                ?>
                                                <tr>
                                                    <td colspan="4"></td>
                                                    <td colspan="1" style="background-color: #dcdcdc; text-align: right;">Sub Total</td>
                                                    <td colspan="1" style="background-color: #dcdcdc; text-align: right;"><?php echo number_format($sub_total, 2); ?></td>                                                    
                                                </tr>
                                                <?php
                                                $precioAMBT = $total_con_dcto + $total_si_congelado;
                                                ?>
                                                <tr>
                                                    <td colspan="3" style="color: red;"></td>
                                                    <td style="background-color: #adc676; text-align: right" colspan="2">Precio Total HUMA GRO con descuento para <?php echo $ha; ?> Ha</td>
                                                    <td style="background-color: #adc676; text-align: right; font-weight: bolder;" colspan="1"><?php echo number_format($precioAMBT, 2); ?></td>                                                    
                                                </tr>
                                                <?php
                                                if ($ha > 1) {
                                                    $precxha = $precioAMBT / $ha;
                                                    ?> 
                                                    <tr>
                                                        <?php
                                                        $col2 = 3;
                                                        echo '<td colspan="2" style="border-left: 0px; border-bottom: 0px;"></td>';
                                                        ?>                                                    
                                                        <td colspan="<?php echo $col2; ?>" style="padding-top: 4px; padding-bottom: 4px; text-align: right;">Precio con descuento / Hectárea</td>                            
                                                        <td style="padding-top: 4px; padding-bottom: 4px; text-align: right;">$<?php echo number_format($precxha, 2); ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        } //FIN DE PRODUCTOS PUD
                        //MOSTRAR DESPACHO
                        $detredondeo = $pro->getRedondeoByCodProp();
                        ?>       
                        <div class="row">
                            <div class="col-lg-7"> 
                                <p class="textcurvo">Redondeo por Despachar:</p>
                            </div>
                        </div>
                        <br/>
                        <div class="row-tablemargen">
                            <div class="col-lg-7">
                                <table class="table1" border="1" align="center">
                                    <thead>
                                        <tr style="background-color: #a5db72;">                        
                                            <th style="padding-top: 3px; padding-bottom: 3px; width: 60mm; text-align: center;">Productos Huma Gro</th>                                                
                                            <th style="padding-top: 3px; padding-bottom: 3px; width: 15mm; text-align: center;">Bidones</th>
                                            <th style="padding-top: 3px; padding-bottom: 3px; width: 15mm; text-align: center;">Litros</th>
                                            <th style="padding-top: 3px; padding-bottom: 3px; width: 20mm; text-align: center;">Precio Unit</th>
                                            <?php if ($pud == 't') { ?>
                                                <th style="padding-top: 3px; padding-bottom: 3px; width: 25mm; text-align: center;">Precio Unit Dscto</th>
                                            <?php } ?>
                                            <th style="padding-top: 3px; padding-bottom: 3px; width: 20mm; text-align: center;">Precio Total</th>                   
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $precio_total_desp = 0;
                                        $ptotal_desp = 0;
                                        $ncarritodesp = count($detredondeo);
                                        $color = colorFilaInicio();
                                        if ($ncarritodesp > 0) {

                                            foreach ($detredondeo as $productodesp) {

                                                $nomproducto = $productodesp['nomprod'];
                                                $bidones = $productodesp['cantidad1']; //bidones
                                                $litrosdesp = $productodesp['cantidad2']; //litros
                                                $precio1 = $productodesp['preciou']; //precio unitario
                                                $precio2 = $productodesp['preciodcto']; // precio unitario con descuento

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
                                                <tr style="background-color: <?php echo $color; ?>">
                                                    <td><?php echo $nomproducto . ' ' . $asterisco; ?></td>
                                                    <td style="text-align: right;"><?php echo number_format($bidones, 2); ?></td>
                                                    <td style="text-align: right;"><?php echo number_format($litrosdesp, 2); ?></td>                                                        
                                                    <td style="text-align: right;">$ <?php echo number_format($precio1, 2); ?></td>
                                                    <?php if ($pud == 't') { ?>                                                            
                                                        <td style="text-align: right;">$ <?php echo number_format($precio2, 2); ?></td>
                                                    <?php } ?>
                                                    <td style="text-align: right;">$<?php echo number_format($ptotal_desp, 2); ?></td>
                                                </tr>
                                                <?php
                                                $color = cambiarColorFila($color);
                                            }
                                        } else {
                                            echo '<tr style="color:red"><td colspan=9>El carrito está vacio.</td></tr>';
                                        }

                                        if ($pud == 'f') {
                                            ?>
                                            <tr>             
                                                <td colspan="3" style="border-left: 0px;"></td>
                                                <td colspan="1" style="padding-top: 4px; padding-bottom: 4px; text-align: center; font-weight: bold;">Sub Total</td>
                                                <td style="padding-top: 4px; padding-bottom: 4px; text-align: right; font-weight: bold;">$<?php echo number_format($precio_total_desp, 2); ?></td>                        
                                            </tr> 
                                            <?php
                                        }
                                        //$precio_totalcongelado = 0;
                                        $preciorestado2 = ($precio_total_desp - $precio_totalnocong);

                                        if ($pud == 't') {
                                            $precioAMBT2 = $pro->calcularPrecioAMBT(0, $preciorestado2, $precio_totalcongelado);
                                        } else {
                                            $precioAMBT2 = $pro->calcularPrecioAMBT($dcto, $preciorestado2, $precio_totalcongelado);
                                        }
                                        ?>
                                        <tr>
                                            <?php
                                            if ($pud == 't') {
                                                $cold = 3;
                                                echo '<td style="border-left: 0px; border-bottom: 0px;"></td>';
                                            } else {
                                                $cold = 3;
                                            }
                                            ?>
                                            <td colspan="<?php echo $cold; ?>" style="padding-top: 4px; padding-bottom: 4px; text-align: right; font-weight: bold;">Precio Redondeado con descuento</td>
                                            <td colspan="1" style="padding-top: 4px; padding-bottom: 4px; text-align: center; font-weight: bold;">Total</td>
                                            <td style="padding-top: 4px; padding-bottom: 4px; text-align: right; font-weight: bold; color: blue;">$<?php echo number_format($precioAMBT2, 2); ?></td>                        
                                        </tr>                    
                                        <?php
                                        $igv = 0;
                                        if ($incluyeigv == 't') {
                                            $igv = ($precioAMBT2 * $valigv) / 100;
                                            $pagototal = $precioAMBT2 + $igv;
                                            ?>
                                            <tr>
                                                <?php if ($pud == 't') { ?>
                                                    <td></td>
                                                <?php } ?>
                                                <td colspan="3" style="border-left: 0px; border-bottom: 0px;"></td>                        
                                                <td style="text-align: center; font-weight: bold;">IGV</td>
                                                <td style="text-align: right; font-weight: bold;"><?php echo number_format($igv, 2); ?></td>
                                            </tr>
                                            <tr>
                                                <?php if ($pud == 't') { ?>
                                                    <td></td>
                                                <?php } ?>
                                                <td colspan="3" style="border-left: 0px; border-bottom: 0px;"></td>                        
                                                <td style="text-align: center; font-weight: bold;">Total a Pagar</td>
                                                <td style="text-align: right; font-weight: bold;"><?php echo number_format($pagototal, 2); ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>                            
                                <p style="font-size: 9px;">
                                    (*) Bidones de 9.46 Litros <br/>
                                    (**) Bidones de 10 Litros.
                                </p>
                            </div>
                        </div>

                        <?php
                    }
                } elseif ($plantilla == "VOLUMEN PAQ") {

                    //MOSTRAR DESPACHO
                    $detredondeo = $pro->getRedondeoByCodProp();
                    ?>                      
                    <div class="row">
                        <div class="col-lg-7"> 
                            <p class="textcurvo">Análisis Económico:</p>
                        </div>
                    </div>
                    <br/>
                    <div class="row-tablemargen">
                        <div class="col-lg-7">
                            <table class="table1" border="1" align="center">
                                <thead>                                        
                                    <tr style="background-color: #a5db72;">                        
                                        <th style="padding-top: 3px; padding-bottom: 3px; width: 60mm; text-align: center;">Productos Huma Gro</th>                                                
                                        <th style="padding-top: 3px; padding-bottom: 3px; width: 15mm; text-align: center;">Bidones</th>
                                        <th style="padding-top: 3px; padding-bottom: 3px; width: 15mm; text-align: center;">Litros</th>
                                        <th style="padding-top: 3px; padding-bottom: 3px; width: 20mm; text-align: center;">Precio Unit</th>
                                        <?php if ($pud == 't') { ?>
                                            <th style="padding-top: 3px; padding-bottom: 3px; width: 25mm; text-align: center;">Precio Unit Dscto</th>
                                        <?php } ?>
                                        <th style="padding-top: 3px; padding-bottom: 3px; width: 20mm; text-align: center;">Precio Total</th>                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $precio_total_desp = 0;
                                    $ptotal_desp = 0;
                                    $ncarritodesp = count($detredondeo);
                                    $color = colorFilaInicio();
                                    $precio_totalcongelado = 0;

                                    if ($ncarritodesp > 0) {


                                        foreach ($detredondeo as $productodesp) {

                                            $nomproducto = $productodesp['nomprod'];
                                            $bidones = $productodesp['cantidad1']; //bidones
                                            $litrosdesp = $productodesp['cantidad2']; //litros
                                            $precio1 = $productodesp['preciou']; //precio unitario
                                            $precio2 = $productodesp['preciodcto']; // precio unitario con descuento

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
                                            <tr style="background-color: <?php echo $color; ?>">
                                                <td><?php echo $nomproducto . ' ' . $asterisco; ?></td>
                                                <td style="text-align: right;"><?php echo number_format($bidones, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($litrosdesp, 2); ?></td>                                                        
                                                <td style="text-align: right;">$<?php echo number_format($precio1, 2); ?></td>
                                                <?php if ($pud == 't') { ?>                                                            
                                                    <td style="text-align: right;">$<?php echo number_format($precio2, 2); ?></td>
                                                <?php } ?>
                                                <td style="text-align: right;">$<?php echo number_format($ptotal_desp, 2); ?></td>
                                            </tr>
                                            <?php
                                            $color = cambiarColorFila($color);
                                        }
                                    } else {
                                        echo '<tr style="color:red"><td colspan=9>El carrito está vacio.</td></tr>';
                                    }

                                    if ($pud == 'f') {
                                        ?>
                                        <tr>                                                
                                            <td colspan="3" style="border-left: 0px; text-align: right; font-weight: bold;"></td>
                                            <td colspan="1" style="padding-top: 4px; padding-bottom: 4px; text-align: center; font-weight: bold;">Sub Total</td>
                                            <td style="padding-top: 3px; padding-bottom: 3px; text-align: right; font-weight: bold;">$<?php echo number_format($precio_total_desp, 2); ?></td>                        
                                        </tr> 
                                        <?php
                                    }


                                    $preciorestado2 = ($precio_total_desp - $precio_totalcongelado);

                                    if ($pud == 't') {
                                        $precioAMBT2 = $pro->calcularPrecioAMBT(0, $preciorestado2, $precio_totalcongelado);
                                    } else {
                                        $precioAMBT2 = $pro->calcularPrecioAMBT($dcto, $preciorestado2, $precio_totalcongelado);
                                    }
                                    ?>
                                    <tr>
                                        <?php
                                        if ($pud == 't') {
                                            $cold = 3;
                                            echo '<td style="border-left: 0px; border-bottom: 0px;"></td>';
                                        } else {
                                            $cold = 3;
                                        }
                                        ?>                                              
                                        <td colspan="<?php echo $cold; ?>" style="padding-top: 3px; padding-bottom: 3px; vertical-align: middle; text-align: right; font-weight: bold;">Precio Redondeado con descuento</td>
                                        <td colspan="1" style="vertical-align: middle; text-align: center; font-weight: bold;">Total</td>
                                        <td style="vertical-align: middle; text-align: right; font-weight: bold; color: blue;">$<?php echo number_format($precioAMBT2, 2); ?></td>                        
                                    </tr>                    
                                </tbody>
                            </table>    
                        </div>
                    </div>
                    <?php
                }
                ?>                                                                    
                <?php
            }
        } else {
            echo 'No se ha registrado ningún item.';
        }
        ?>                                
        <div class="row">
            <div class="col-lg-7">
                <p class="textcurvo">Condiciones técnicas y de ventas:</p>                                                                        
                <?php
                $condiciones = $pro->getCondicionesByCodProp();
                echo '<ol style="width: 180mm; margin-left:-30px; list-style-type: lower-alpha; font-size: 7.5px;">';
                foreach ($condiciones as $condicion) {
                    echo '<li style="padding-left: 5px; text-align:justify;">';
                    echo '<span>' . trim($condicion['condicion']) . '</span>';
                    echo '</li>';
                }
                echo '</ol>';
                ?> 
            </div>

        </div> 
        <div class="row">
            <div class="col-lg-7">       
                Cordialmente,<br/>
                <strong>Agro Micro Biotech S.A.C.</strong>
            </div>
        </div>



    </body>
</html>

