<?php
include '../controller/C_Reportes.php';
$obj = new C_Reportes();

$codcliente = $_GET['cod1'];
$atendido = $_GET['cod2'];
$obj->__set('codcliente', $codcliente);

$lista = $obj->cargarEncargadoxCliente();
$lfundo = $obj->cargarFundoxClienteOrdeByCod();
$numRep = $obj->generarCodRepComercial($atendido);
?>
<div class="form-group">
    <label class="col-sm-2 control-label">Fundo <span class="obl">(*)</span>:</label>
    <div class="col-sm-3">                                        
        <select class="form-control " name="codfundo" id="codfundo" onblur="cargarLote()" onchange="cargarLote()">                
            <option value="0">..::Seleccione Fundo</option>
            <?php
            if (count($lfundo) > 0) {
                for ($i = 0; $i < (count($lfundo)); $i++) {
                    ?>
                    <option value="<?php echo trim($lfundo[$i][1]); ?>"><?php echo trim($lfundo[$i][2]); ?></option>
                    <?php
                }
            }
            ?>                                         
            <option value="nuevo">..::Otro</option>
        </select>
    </div>
    <div id="divnvofundo" class="col-sm-3" hidden="">        
        <input maxlength="80" class="form-control" id="nomfundo" type="text" name="nomfundo" value="" placeholder="Nombre de Fundo" />
    </div>
</div>
<div class="form-group">                                    
    <label class="col-sm-2 control-label">Contacto <span class="obl">(*)</span>:</label>
    <div class="col-sm-2">                                        
        <select class="form-control " name="contacto" id="contacto" onblur="loadRubrica()" onchange="loadRubrica()">
            <option value="0">..::Seleccione Contacto</option>                            
             <?php
        if (count($lista) > 0) {
            for ($i = 0; $i < (count($lista)); $i++) {
                ?>
                <option value="<?php echo trim($lista[$i][4]) ?>"><?php echo trim($lista[$i][0]) . ' - ' . $lista[$i][1]; ?></option>
            <?php }
            ?>
            <option value="otro">..::Otro</option>
            <?php
        } else {
            ?>
            <option value="otro">..::Otro</option>
        <?php }
        ?>    
        </select>
    </div>
    <div id="divencargado" class="col-sm-3" hidden="">          
        <input maxlength="50" type="text" class="form-control" name="newcontacto" id="newcontacto" value="" placeholder="Nombre de Contacto"  />
    </div>
    <div id="divcelcontacto">
        <div class="col-sm-2">                                             
            <input maxlength="15" class="form-control " type="text"  name="celcontacto" id="celcontacto" value="" placeholder="Celular Contacto" />
        </div>
        <div class="col-sm-2">                                            
            <input maxlength="30" type="text" class="form-control " name="carcontacto" id="carcontacto" value="" placeholder="Cargo de Contacto" />
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Número Reporte <span class="obl">(*)</span>:</label>
    <div class="col-lg-2">                                        
        <input maxlength="20" type="text" class="form-control " name="codrep" id="codrep" value="<?php echo $numRep; ?>"  />
    </div>                                    
</div>