<?php
include '../controller/C_Cliente.php';
$obj = new C_Cliente();
$codcliente = trim($_GET['cod1']);
$modo = trim($_GET['cod2']);
$obj->__set('codcliente', $codcliente);
?>
<div class="col-lg-12">


<!--<input type="checkbox" id="ajusteprecioA" name="" onclick="ajustarPrecioA()" value="ON" /> Ajustar Precios A-->
    <?php
    if ($modo == 'Insert') {
        ?>
        <h4>Por Unidades:</h4>
        <div class="row">
            <div class="col-lg-4">
                <input type="radio" name="nitrogeno" value="si" checked="" /> Con Nitrogeno (Huma Gro) 
            </div>
            <div class="col-lg-4">
                <input type="radio" name="nitrogeno" value="50" /> Con 50% Nitrogeno (Huma Gro) 
            </div>
            <div class="col-lg-4">
                <input type="radio" name="nitrogeno" value="no" /> Sin Nitrogeno (Huma Gro) 
            </div>
        </div>
        <br/>
        <table style="font-size: 10px; text-align: center;">
            <tbody>            
                <?php
                $listafc = $obj->getFactorConversionByCliente();
                $listaA = $obj->getPrecioxProdFertirriego();
                $lista60 = $obj->getListaPrecioDscto();

                if (count($listafc) > 0) {
                    
                } else {
                    $listafc = $obj->getFactorConversionDefault();
                }

                echo '<tr>';
                echo '<td></td>';
                foreach ($listafc as $fc1) {
                    echo '<td>' . $fc1['codnut'] . '</td>';
                }
                echo '</tr>';
                echo '<tr>';
                echo '<td>Unidades</td>';
                foreach ($listafc as $fc1) {
                    echo '<td><input class="numericos" type="number" id="un' . $fc1['codnut'] . '" name="un' . $fc1['codnut'] . '" step="any" value="0" /></td>';
                }
                echo '</tr>';
                echo '<tr>';
                echo '<td>F.C.</td>';
                foreach ($listafc as $fc2) {
                    echo '<td><input readonly="" class="numericos" type="number" id="fc' . $fc2['codnut'] . '" name="fc' . $fc2['codnut'] . '" step="any" value="' . $fc2['factor'] . '" /></td>';
                }
                echo '</tr>';
                echo '<tr>';
                echo '<td>P.B.</td>';
                foreach ($listafc as $fc3) {
                    $valor = 10;
                    if ($fc3['codnut'] == 'S' || $fc3['codnut'] == 'Si' || $fc3['codnut'] == 'Mo' || $fc3['codnut'] == 'Co' || $fc3['codnut'] == 'B') {
                        $valor = 9.46;
                    }
                    echo '<td><input step="any" class="numericos" type="number" id="bd' . $fc3['codnut'] . '" name="bd' . $fc3['codnut'] . '" step="any" value="' . number_format($valor, 2) . '" /></td>';
                }
                echo '</tr>';
                //********PRECIOS A
                echo '<tr>';
                echo '<td>Precios Unit</td>';
                foreach ($listaA as $precioA) {
                    echo '<td><input readonly="" class="numericos" type="number" id="preA" name="preA" step="any" value="' . number_format($precioA['pventa'], 2) . '" /></td>';
                }
                echo '</tr>';
                //********PRECIOS 60
                echo '<tr>';
                echo '<td>Precios 60</td>';
                foreach ($listafc as $fc4) {
                    echo '<td>';
                    foreach ($lista60 as $pre) {
                        if (trim($fc4['codnut']) == trim($pre['inicial2']) && $pre['precio'] > 0) {
                            echo '<input step="any" class="numericos" type="number" id="prec' . $fc4['codnut'] . '" name="pre' . $fc4['codnut'] . '"  value="' . $pre['precio'] . '"/>';
                        } elseif (trim($fc4['codnut']) == trim($pre['inicial2']) && $pre['precio'] == '0') {
                            echo '<input step="any" class="numericos" type="number" id="prec' . $fc4['codnut'] . '" name="pre' . $fc4['codnut'] . '"  value="0.0"/>';
                        }
                    }
                    echo '</td>';
                }
                echo '</tr>';
                echo '<tr>';
                echo '<td>Congelar P.U.</td>';
                foreach ($listafc as $fc5) {
                    echo '<td><input type="checkbox" id="cong' . $fc5['codnut'] . '" name="cong' . $fc5['codnut'] . '"  value="ON" /></td>';
                }
                echo '</tr>';
                ?>
            </tbody>
        </table>        
        <br/>     
        <input type="checkbox" id="ajustefactor" name="" onclick="ajustarFactores()" value="ON" /> Ajustar Factor de Conversión (F.C.)<br/>
        <br>
        <div style="font-size: 9px;">
            <span>F.C. = Factor de Conversión por Cliente</span><br/>
            <span>P.B. = Presentación de Producto en Bidones de 10LT o 9.46LT</span><br/>
            <span>Congelar P.U. = Congelar Precio Unitario</span><br/>
        </div>
        <p style="text-align: right">
            <button type="button" class="btn btn-primary" onclick="addbyUnidad()">Insertar o Actualizar Productos</button>            
        </p>
        <?php
    } elseif ($modo == 'Update') {
        //session_start();
        $posicion = $_GET['cod3'];
        $array_unidad = $_SESSION['und'][$posicion];
        ?>
        <h4>Por Unidades:</h4>
        <div class="row">
            <div class="col-lg-4">
                <input type="radio" name="nitrogeno_update" value="si" checked="" /> Con Nitrogeno (Huma Gro) 
            </div>
            <div class="col-lg-4">
                <input type="radio" name="nitrogeno_update" value="50" /> Con 50% Nitrogeno (Huma Gro) 
            </div>
            <div class="col-lg-4">
                <input type="radio" name="nitrogeno_update" value="no" /> Sin Nitrogeno (Huma Gro) 
            </div>
        </div>
        <br/>
        <table style="font-size: 10px; text-align: center;">
            <tbody>            
                <?php
                $listafc = $obj->getFactorConversionByCliente();
                $listaA = $obj->getPrecioxProdFertirriego();
                $lista60 = $obj->getListaPrecioDscto();

                if (count($listafc) > 0) {
                    
                } else {
                    $listafc = $obj->getFactorConversionDefault();
                }

                echo '<tr>';
                echo '<td></td>';
                foreach ($listafc as $fc1) {
                    echo '<td>' . $fc1['codnut'] . '</td>';
                }
                echo '</tr>';
                echo '<tr>';
                echo '<td>Unidades</td>';

                foreach ($listafc as $fc1) {
                    $indice_search = array_search(trim($fc1['codnut']), array_column($array_unidad, trim('codnut')), false);
                    if (strlen($indice_search) == '') {
                        echo '<td><input class="numericos" type="number" id="un_update' . $fc1['codnut'] . '" name="un_update' . $fc1['codnut'] . '" step="any" value="0" /></td>';
                    } elseif ($array_unidad[$indice_search]['codnut'] == $fc1['codnut']) {
                        echo '<td><input class="numericos" type="number" id="un_update' . $fc1['codnut'] . '" name="un_update' . $fc1['codnut'] . '" step="any" value="' . $array_unidad[$indice_search]['unidad'] . '" /></td>';
                    }
                }
                echo '</tr>';
                echo '<tr>';
                echo '<td>F.C.</td>';
                foreach ($listafc as $fc2) {
                    echo '<td><input readonly="" class="numericos" type="number" id="fc_update' . $fc2['codnut'] . '" name="fc_update' . $fc2['codnut'] . '" step="any" value="' . $fc2['factor'] . '" /></td>';
                }
                echo '</tr>';
                echo '<tr>';
                echo '<td>P.B.</td>';
                foreach ($listafc as $fc3) {
                    $valor = 10;
                    if ($fc3['codnut'] == 'S' || $fc3['codnut'] == 'Si' || $fc3['codnut'] == 'Mo' || $fc3['codnut'] == 'Co' || $fc3['codnut'] == 'B') {
                        $valor = 9.46;
                    }
                    echo '<td><input step="any" class="numericos" type="number" id="bd_update' . $fc3['codnut'] . '" name="bd_update' . $fc3['codnut'] . '" step="any" value="' . number_format($valor, 2) . '" /></td>';
                }
                echo '</tr>';
                //********PRECIOS A
                echo '<tr>';
                echo '<td>Precios Unit</td>';
                foreach ($listaA as $precioA) {
                    echo '<td><input readonly="" class="numericos" type="number" id="preA_update" name="preA_update" step="any" value="' . number_format($precioA['pventa'], 2) . '" /></td>';
                }
                echo '</tr>';
                //********PRECIOS 60
                echo '<tr>';
                echo '<td>Precios 60</td>';
                foreach ($listafc as $fc4) {
                    echo '<td>';
                    foreach ($lista60 as $pre) {
                        if (trim($fc4['codnut']) == trim($pre['inicial2']) && $pre['precio'] > 0) {
                            echo '<input step="any" class="numericos" type="number" id="prec_update' . $fc4['codnut'] . '" name="pre_update' . $fc4['codnut'] . '"  value="' . $pre['precio'] . '"/>';
                        } elseif (trim($fc4['codnut']) == trim($pre['inicial2']) && $pre['precio'] == '0') {
                            echo '<input step="any" class="numericos" type="number" id="prec_update' . $fc4['codnut'] . '" name="pre_update' . $fc4['codnut'] . '"  value="0.0"/>';
                        }
                    }
                    echo '</td>';
                }
                echo '</tr>';
                echo '<tr>';
                echo '<td>Congelar P.U.</td>';
                foreach ($listafc as $fc5) {
                    echo '<td><input type="checkbox" id="cong_update' . $fc5['codnut'] . '" name="cong_update' . $fc5['codnut'] . '"  value="ON" /></td>';
                }
                echo '</tr>';
                ?>
            </tbody>
        </table>        
        <br/>     
        <input type="checkbox" id="ajustefactor_update" name="" onclick="ajustarFactoresUpdate()" value="ON" /> Ajustar Factor de Conversión (F.C.)<br/>
        <br>
        <div style="font-size: 9px;">
            <span>F.C. = Factor de Conversión por Cliente</span><br/>
            <span>P.B. = Presentación de Producto en Bidones de 10LT o 9.46LT</span><br/>
            <span>Congelar P.U. = Congelar Precio Unitario</span><br/>
        </div>
        <p style="text-align: right">
            <a class="btn btn-primary" onclick="addbyUnidad_Update()" href="#">Insertar o Actualizar Productos</a>
        </p>
    <?php } ?>
</div>



