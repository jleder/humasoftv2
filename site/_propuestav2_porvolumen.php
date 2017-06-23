<?php
include '../controller/C_Cliente.php';
$obj = new C_Cliente();
//$codcliente = trim($_GET['cod1']);
//$tcotizacion = trim($_GET['cod2']);
//$obj->__set('codcliente', $codcliente);
?>
<!--<script type="text/javascript" src="js/jspropuesta/regpropuesta.js"></script>-->
<script>

</script>
<div class="col-lg-12" style="background-color: gainsboro;">
    <h4>Ingresar Litros para Aplicación Fertirriego</h4>
    <table style="font-size: 10px; text-align: center;">
        <tbody>            
            <?php
            $listafc = array('N', 'P', 'K', 'Ca', 'Mg', 'S', 'B', 'Co', 'Cu', 'Fe', 'Mn', 'Mo', 'Si', 'Zn'); //array de nutrientes
            $listaA = $obj->getPrecioxProdFertirriego();
            $lista60 = $obj->getListaPrecioDscto();


            echo '<tr>';
            echo '<td></td>';
            foreach ($listafc as $fc1) {
                echo '<td>' . $fc1 . '</td>';
            }
            echo '</tr>';
            echo '<tr>';
            echo '<td>Litros</td>';
            foreach ($listafc as $fc2) {
                echo '<td><input class="numericos" type="number" id="lt' . $fc2 . '" name="lt' . $fc2 . '" step="any" value="0" /></td>';
            }
            echo '</tr>';
            echo '<tr>';
            echo '<td>P.B.</td>';
            foreach ($listafc as $fc6) {
                $valor = 10;
                if($fc6 == 'S' || $fc6 == 'Si' || $fc6 == 'Mo' || $fc6 == 'Co' || $fc6 == 'B'){
                    $valor = 9.46;
                }
                echo '<td><input class="numericos" type="number" id="bd' . $fc6 . '" name="bd' . $fc6 . '" step="any" value="'.number_format($valor,2).'" /></td>';
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
            foreach ($listafc as $fc3) {
                echo '<td>';
                foreach ($lista60 as $pre) {
                    if (trim($fc3) == trim($pre['inicial2']) && $pre['precio'] > 0) {
                        echo '<input class="numericos" step="any" type="number" id="prec' . $fc3 . '" name="pre' . $fc3 . '"  value="' . $pre['precio'] . '"/>';
                    } elseif (trim($fc3) == trim($pre['inicial2']) && $pre['precio']== '0') {
                        echo '<input class="numericos" step="any" type="number" id="prec' . $fc3 . '" name="pre' . $fc3 . '"  value="0.0"/>';
                    }
                }
                echo '</td>';
            }
            echo '</tr>';            
            echo '<tr>';
            echo '<td>Congelar P.U.</td>';
            foreach ($listafc as $fc5) {
                echo '<td><input type="checkbox" id="cong' . $fc5. '" name="cong' . $fc5. '"  value="ON" /></td>';
            }
            echo '</tr>';                        
            ?>
        </tbody>
    </table>    
    <br/> 
    <div style="font-size: 9px;">    
    <span>P.B. = Presentación de Producto en Bidones de 10LT o 9.46LT</span><br/>
    <span>Congelar P.U. = Congelar Precio Unitario</span><br/>
    </div>
    <p style="text-align: right">
        <a class="btn btn-primary" id="porvolumen" onclick="addbyVolumen()" href="#">Insertar o Actualizar Productos</a>
    </p>
</div>



