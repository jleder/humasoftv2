<?php
session_start();
include '../controller/C_ActualizarItemPropuesta.php';
$prod = new C_Producto();
$prop = new C_Propuesta();

$i = $_GET['cod1']; //Posicion del Arreglo de Item

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
    $_SESSION['carritodesp'] = array(); //carrito despacho
    $_SESSION['unidades'] = array();
}

$_SESSION['item_update'] = $_SESSION['item'][$i];
$_SESSION['und_update'] = $_SESSION['und'][$i];
$_SESSION['car_update'] = $_SESSION['car'][$i];
$_SESSION['cardesp_update'] = $_SESSION['cardesp'][$i];
$vectoritem = $_SESSION['item_update'];

//echo '<pre>';
//print_r($vectoritem);
//echo '<br/>';
//print_r($carrito);
//echo '<br/>';
//print_r($unidades);
//echo '<br/>';
//print_r($carritodesp);
//echo '<br/>';
//echo '</pre>';

$item_dscto = $vectoritem[0];
$pcc = $vectoritem[1];
$pca = $vectoritem[2];
$preambt = $vectoritem[3];
$ha = $vectoritem[5];
$nitrogeno = $vectoritem[6];
$tipoprop = $vectoritem[7];
$pud = $vectoritem[8];
$incluyeigv = $vectoritem[11];
$valigv = $vectoritem[12];
$pup = $vectoritem[13];
$itemdesc = $vectoritem[14];




/* if ($tipo == 'ONLYTABLE') {
  $ha = $variables[1];  //HECTAREAS
  $descuento = $variables[2];
  $pca = $variables[3];
  $pcc = $variables[4];
  $pud = $variables[5];
  $incluyeigv = $variables[6];
  $valigv = $variables[7];
  $pup = $variables[8];
  } */
?>
<body>    
    <div class="row">
        <div class="col-lg-12">
            <table  style="font-size: 1em; td { padding: 9px;}">            
                <tbody>
                    <tr>
                        <td style="width: 300px;">Título de Item <span class="obl">*</span> </td>
                        <td>
                            <textarea name="titulo_item_update" id="titulo_item_update" class="form-control input-sm"><?php echo $itemdesc; ?></textarea>
                            <input type="hidden" id="posicion" value="<?php echo $i; ?>" />
                            <input type="hidden" id="pup_update" value="<?php echo $pup; ?>" />
                            <input type="hidden" id="tipoprop_update" value="<?php echo $tipoprop; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 300px;">Número de Hectáreas <span class="obl">*</span> </td>
                        <td><input required="" type = "number" name="ha_update" id="ha_update" value = "<?php echo $ha; ?>" class="form-control input-sm"  step="any"  /></td>
                    </tr>        
                    <tr>
                        <td>Precio Convencional Aproximado</td>
                        <td><input type = "number" step="any" name="pca_update" value = "<?php echo $pca; ?>" class="form-control input-sm" id="pca_update" /></td>
                    </tr>
                    <tr>
                        <td>Precio Convencional Confirmado</td>
                        <td><input type = "number" step="any" name="pcc_update" value = "<?php echo $pcc; ?>" class="form-control input-sm" id="pcc_update" /></td>
                    </tr>
                    <tr>
                        <td>Otros El PUD es: <?php echo $pud; ?></td>
                        <td>
                            <p><input onclick="loadIGV()" type="checkbox" name="checkigv_update" id="checkigv_update" value="IGV" /> Incluir IGV</p>
                            <p id="divigv_update" style="display: none" ><input class="form-control input-sm" type="number" name="valigv_update" id="valigv_update" value="18" /> </p>
                            <p><input type="checkbox" checked="" name="mta" id="mta_update" value="MTA" /> Mostrar Columna Tipo Aplicación</p>
                            <p><input type="checkbox" name="pud" id="pud_update" value="PUD" /> Mostrar Precio Unitario con Descuento por Paquete</p>
                        </td>
                    </tr>
                    <tr>
                        <td>Seleccione Tipo de Descuento</td>
                        <td>
                            <select name="tipodcto" class="form-control" id="tipodcto" onchange="mostrarCampoDcto()">
                                <option value="PREPOR">Por Porcentaje</option>
                                <option value="PRE60">Precios 60</option>
                                <option value="PRECLI">Precio Cliente Antiguo</option>
                                <option value="PREPRO">Precio Promocion</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <div id="divtipodcto">
                                <input type = "number" step="any" name="dcto_update" value = "<?php echo $item_dscto; ?>" class="form-control input-sm" id="dcto_update" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><a class="btn btn-primary btn-sm" onclick="generarTablaxHas()">Generar Tabla</a></td>
                    </tr>                
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <h4>4. Agregar Productos</h4>            
            <div class="cuadro_one">
                <div class="cuadro_two">
                    <p style="text-align: center;"><a href="#" onclick="tipoPropuestaUpdateItem('POR UNIDADES')" ><img src="img/iconos/unidad-icon.png" height="50px" /></a></p>
                </div>
                <div style="clear: both"></div>
                <p style="text-align: center; color: white;">Por Unidades</p>
            </div>                                                    
            <div class="cuadro_one">
                <div class="cuadro_two">
                    <p style="text-align: center;"><a href="#" onclick="tipoPropuestaUpdateItem('POR LITROS')" ><img src="img/iconos/bottle-icon.png" height="50px" /></a></p>
                </div>
                <div style="clear: both"></div>
                <p style="text-align: center; color: white;">Por Producto</p>
            </div>                                                    
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" id="addproductos_update"></div>
    </div>
    <hr/>
    <h4><img src="img/iconos/add-car.png" height="20px" /> Carrito de Productos</h4>
    <div class="row">
        <div class="col-md-12" id="divproductos_update">
            <?php
            $variables = array($i, $item_dscto, $pca, $pcc, $ha, $nitrogeno, $pud, $incluyeigv, $valigv);
            $_GET['cod1'] = 'carga';
            $_GET['cod2'] = $variables;
            include './_propuestav2_hapaq_detalle_10.php';
            ?>
        </div>
    </div>
    <br/><br/>
    <div class = "row">
        <div class = "col-lg-12" style = "text-align: center;">

            <a class = "btn btn-danger btn-sm" href = "#" onclick = "cargar('#divexperimento', '_propuestav2_vista_previa.php')" >Cancelar</a>
            <a class = "btn btn-info btn-sm" href="#" onclick="updateItem()">Actualizar Item</a>                
        </div>
    </div>    
    <br/><br/><br/>
</body>