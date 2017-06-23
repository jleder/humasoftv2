<?php
include_once '../controller/C_Reportes.php';
$obj = new C_Reportes();

$codlote = $_GET['cod'];
if ($codlote == 'nuevo') {
    $lcult = $obj->listarCultivos();
    $lefen = $obj->listarEtapaFenologica();
    ?>   
    <div class="form-group">  
        <label class="col-sm-3 control-label">Nombre de Lote:</label>
        <div class="col-sm-9">            
            <input maxlength="80" type = "text" name = "humanombre" placeholder="Ejemplo: Lote Huma Gro 1" value = "" class="form-control" id="humanombre" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Ha. Total:</label>
        <div class="col-sm-3">
            <input type = "number" name = "humahatotal" step="any" value = "0.0" class="form-control" id="humahatotal" />
        </div>
        <label class="col-sm-3 control-label">Ha. Trabajada:</label>
        <div class="col-sm-3">
            <input type = "number" name = "humahatrabajada" step="any" value = "0.0" class="form-control" id="humahatrabajada" />
        </div>
    </div>
    <div class="form-group">        
        <label class="col-sm-3 control-label">Tipo Cultivo:</label>            
        <div class="col-sm-5">            
            <select class="form-control" id="humatipocultivo"  name="humatipocultivo" onchange="otroCultivoHuma()" onblur="otroCultivoHuma()">                        
                <?php foreach ($lcult as $valor) { ?>                                
                    <option value="<?php echo $valor['desele']; ?>"> <?php echo $valor['desele']; ?></option>
                <?php } ?>
                <option value="otro">..::Nuevo Cultivo</option>
            </select>
        </div>
        <div id="divnewcultivohuma" class="col-sm-4" hidden="">                
            <input type="text" name="newcultivohuma" class="form-control" id="newcultivohuma" value="" placeholder="Escribir cultivo" />               
        </div>  
    </div>
    <div class="form-group">
        <div id="divvariedadhuma" >
            <label class="col-sm-3 control-label">Variedad:</label>            
            <div class="col-sm-5">                
                <select name="humavariedad" id="humavariedad" class="form-control" onchange="otroVariedadHuma()">
                    <option value="0">..:: Seleccione ::..</option>                                                
                    <option value="DESCONOCIDO">Desconocido</option>
                    <option value="OTRO">..:: Otro ::..</option>
                </select>                        
            </div>
            <div id="divnewvariedadhuma" class="col-sm-4" hidden="">                
                <input type="text" name="newvariedadhuma" class="form-control" id="newvariedadhuma" value="" placeholder="Escribir variedad" />
            </div> 
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Patron:</label>
        <div class="col-sm-5">            
            <?php echo $obj->generarPatrones2('humapatron', 'form-control', 'otroPatronHuma()', 'otroPatronHuma()', ''); ?>
        </div>
        <div id="divnewpatronhuma" class="col-sm-4" hidden="">            
            <input type="text" name="newpatronhuma" class="form-control" id="newpatronhuma" value="" placeholder="Escribir patron" />               
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Densidad:</label>
        <div class="col-sm-3">            
            <input type = "number" name = "humadensidad" step="any" placeholder="densidad" value = "0.0" class="form-control" id="humadensidad" />
        </div>
        <label class="col-sm-3 control-label">Edad Cultivo:</label>
        <div class="col-sm-3">            
            <select name="humaedadcultivo" id="humaedadcultivo" class="form-control">                                    
                <option value="SEMILLA">Semilla</option>
                <option value="VIVERO">Vivero</option>
                <option value="PLANTIN">Plantin</option>                                                    
                <option value="Entre 1 y 6 meses">Entre 1 y 6 meses</option>
                <option value="Menos de 1 año">Menos de 1 año</option>
                <option value="1 año">1 año</option>
                <option value="2 años">2 años</option>
                <option value="3 años">3 años</option>
                <option value="4 años">4 años</option>
                <option value="5 años">5 años</option>
                <option value="6 años">6 años</option>
                <option value="7 años">7 años</option>
                <option value="8 años">8 años</option>
                <option value="9 años">9 años</option>
                <option value="10 años">10 años</option>
                <option value="Mayor a 10 años">Mayor a 10 años</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Étapa Fenológica:</label>
        <div class="col-sm-5">
            <select class="form-control" id="humaefenologica"  name="humaefenologica">                        
                <?php foreach ($lefen as $valor) { ?>                                
                    <option value="<?php echo $valor['desele']; ?>"> <?php echo $valor['desele']; ?></option>
                <?php } ?>
                <option value="OTRA">..::OTRA::..</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Tipo de Riego:</label>
        <div class="col-sm-3">            
            <?php echo $obj->generarTipoRiego('humatriego', 'form-control'); ?>                                
        </div>
        <label class="col-sm-3 control-label">Tipo de Suelo:</label>
        <div class="col-sm-3">            
            <?php echo $obj->generarTipoSuelo('humatsuelo', 'form-control'); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Vol. Agua Foliar:</label>        
        <div class="col-sm-3">
            <input type = "number" step="any" name="humavolaguafoliar" placeholder="volaguafoliar" value="0.0" class="form-control" id="humavolaguafoliar" />
        </div>
        <label class="col-sm-3 control-label">Unidad Medida:</label>        
        <div class="col-sm-3">            
            <select name="humaum_volaguafoliar" id="humaum_volaguafoliar"  class="form-control">
                <option value="LTS">LTS</option>
                <option value="CYL">CYL</option>                            
            </select>  
        </div>
    </div>

    <?php
} else {
    $obj->__set('codlotehuma', $codlote);
    $valueL = $obj->getLoteByID();
    $crearloteHuma = FALSE;
    ?>
    <input type="hidden" name="reglote" id="reglote" value="FALSE" />
    <div class="col-lg-6">
        <span class="texto-opaco">Nombre de Lote:</span><br/>
        <?php echo $valueL[3]; ?>
    </div>
    <div class="col-lg-6">
        <span class="texto-opaco">Ha. Trabajadas:</span><br/>
        <?php echo $valueL[4]; ?>
    </div>
    <div class="col-lg-6">
        <span class="texto-opaco">Tipo de Cultivo:</span><br/>
        <?php echo $valueL[5]; ?>
    </div>
    <div class="col-lg-6">
        <span class="texto-opaco">Variedad:</span><br/>
        <?php echo $valueL[6]; ?>
    </div>
    <div class="col-lg-6">
        <span class="texto-opaco">Tipo de Riego:</span><br/>
        <?php echo $valueL[8]; ?>
    </div>
    <div class="col-lg-6">
        <span class="texto-opaco">Tipo de Suelo:</span><br/>
        <?php echo $valueL[9]; ?>
    </div>    
<?php } ?>

<div class="row">
    <div class="col-lg-12">
        Antecedentes a la visita (Temas por ver, resolver y/o planificar) <span class="obl">(*)</span>
        <textarea class="form-control" name="humarpta1" id="humarpta1" rows="3" cols="20"></textarea>                                    
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        Visita de Rutina - Seguimiento (Evaluación) <span class="obl">(*)</span>
        <textarea class="form-control" name="humarpta2" id="humarpta2" rows="3" cols="20"></textarea>                                    
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        Recomendaciones / Notas <span class="obl">(*)</span>
        <textarea class="form-control" name="humarpta3" id="humarpta3" rows="3" cols="20"></textarea>                                    
    </div>
</div>

<script type="text/javascript">
    
    $(document).ready(function () {
        // Load script of Select2 and run this
        LoadSelect2Script(Select2Test);
        WinMove();

        // Create Wysiwig editor for textare
        TinyMCEStart('#humarpta1', null);
        TinyMCEStart('#humarpta2', null);
    });
</script>                