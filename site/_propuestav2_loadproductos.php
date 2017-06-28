<?php
@session_start();
date_default_timezone_set("America/Bogota");
include_once '../controller/C_ActualizarItemPropuesta.php';
$prop = new C_Propuesta();
$prod = new C_Producto();
$listaprod = $prod->getProductosAll();
$tipoa = $prop->getTipoAplicacion();
?>
<div class="col-sm-12">
    <div class="row">
        <div class="col-lg-12"><h5>Por Producto:</h5></div>
    </div>
    <div class="row">
        <div class="col-lg-4">                                    
            Producto:           
            <select class="form-control input-sm" id="comboprod_update"  name="comboprod_update" onchange="cargarPreciosxProducto()" onblur="">
                <option value=""></option>                
                <?php foreach ($listaprod as $val) { ?>                                
                    <option value="<?php echo $val[0] ?>"> <?php echo trim($val[2]); ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-lg-3">
            Tipo Aplicación:
            <select class="form-control input-sm" name="tipoa_update" id="tipoa_update">
                <?php
                foreach ($tipoa as $aplicacion) {
                    ?>
                    <option value="<?php echo trim($aplicacion['codele']); ?>"><?php echo trim($aplicacion['desele']); ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
        <div class="col-lg-3">
            Litros/Ha.
            <input type="number" name="cantidad_update" id="cantidad_update" class="form-control input-sm" value="0" step="any" min="0" />
        </div> 
        <div id="" class="col-lg-2">
            Presentación Bidones                                                            
            <select name="bidones_update" id="bidones_update" class="form-control input-sm" >
                <option value="10.00">10 LT</option>
                <option value="9.46">9.46 LT</option>
            </select>
        </div>                                                    

    </div>
    <div class="row">
        <div id="divpreciou_update">
            <div class="col-lg-2">
                Precio Unitário
                <input type="number" name="precio_update" id="precio_update" class="form-control input-sm" value="0" step="any" min="0" />
            </div>                                                        
            <div id="" class="col-lg-2">
                Precio Dscto
                <input type="number" name="preciodcto_update" id="preciodcto_update" class="form-control input-sm" value="0" step="any" min="0" />
            </div>
            <div class="col-lg-2">
                Congelar Precio Dcto
                <select class="form-control input-sm" name="congelar2_update" id="congelar2_update">
                    <option value="F">No</option>
                    <option value="T">Si</option>
                </select>
            </div>
        </div>
        <div class="col-lg-3">
        </div>
        <div style="text-align: right" class="col-lg-3">
            <br/>            
            <button type="button" class="btn btn-primary" onclick="addbyProductoUpdate()" >Insertar o Actualizar Productos</button>
        </div>                                                    
    </div>
</div>
<script type="text/javascript">
                $(document).ready(function () {
                    $('#comboprod_update').combobox();
                });
                //]]>
</script>