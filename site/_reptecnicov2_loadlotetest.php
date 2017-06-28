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
            <input maxlength="80" type = "text" name = "testnombre" placeholder="Ejemplo: Lote Testigo 1" value = "" class="form-control" id="testnombre" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Ha. Total:</label>
        <div class="col-sm-3">
            <input type = "number" name = "testhatotal" step="any" value = "0.0" class="form-control" id="testhatotal" />
        </div>
        <label class="col-sm-3 control-label">Ha. Trabajada:</label>
        <div class="col-sm-3">
            <input type = "number" name = "testhatrabajada" step="any" value = "0.0" class="form-control" id="testhatrabajada" />
        </div>
    </div>
    <div class="form-group">        
        <label class="col-sm-3 control-label">Tipo Cultivo:</label>            
        <div class="col-sm-5">            
            <select class="form-control" id="testtipocultivo"  name="testtipocultivo" onchange="otroCultivoTest()">
                <?php foreach ($lcult as $valor) { ?>                                
                    <option value="<?php echo $valor['desele']; ?>"> <?php echo $valor['desele']; ?></option>
                <?php } ?>
                <option value="otro">..::Nuevo Cultivo</option>
            </select>
        </div>        
        <div id="divnewcultivotest" class="col-sm-4" hidden="">        
            <input type="text" name="newcultivotest" class="form-control" id="newcultivotest" value="" placeholder="Escribir cultivo" />           
        </div>                                             
    </div>
    <div class="form-group">
        <div id="divvariedadtest" >
            <label class="col-sm-3 control-label">Variedad:</label>            
            <div class="col-sm-5">                
                <select name="testvariedad" id="testvariedad" class="form-control" onchange="otroVariedadTest()">
                    <option value="0">..:: Seleccione ::..</option>                                                
                    <option value="DESCONOCIDO">Desconocido</option>
                    <option value="OTRO">..:: Otro ::..</option>
                </select>                
            </div>
            <div id="divnewvariedadtest" class="col-sm-4" hidden="">                
                <input type="text" name="newvariedadtest" class="form-control" id="newvariedadtest" value="" placeholder="Escribir variedad" />
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Patron:</label>
        <div class="col-sm-5">            
            <?php echo $obj->generarPatrones2('testpatron', 'form-control', 'otroPatronTest()', 'otroPatronTest()', ''); ?>
        </div>
        <div id="divnewpatrontest" class="col-sm-4" hidden="">            
            <input type="text" name="newpatrontest" class="form-control" id="newpatrontest" value="" placeholder="Escribir patron" />               
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Densidad:</label>
        <div class="col-sm-3">            
            <input type = "number" name = "testdensidad" step="any" placeholder="densidad" value = "0.0" class="form-control" id="testdensidad" />
        </div>
        <label class="col-sm-3 control-label">Edad Cultivo:</label>
        <div class="col-sm-3">            
            <select name="testedadcultivo" id="testedadcultivo" class="form-control">                                    
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
            <select class="form-control" id="testfenologica"  name="testfenologica">
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
            <?php echo $obj->generarTipoRiego('testtriego', 'form-control'); ?>                                
        </div>
        <label class="col-sm-3 control-label">Tipo de Suelo:</label>
        <div class="col-sm-3">            
            <?php echo $obj->generarTipoSuelo('testtsuelo', 'form-control'); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Vol. Agua Foliar:</label>        
        <div class="col-sm-3">
            <input type = "number" step="any" name="testvolaguafoliar" placeholder="" value="0.0" class="form-control" id="testvolaguafoliar" />
        </div>
        <label class="col-sm-3 control-label">Unidad Medida:</label>        
        <div class="col-sm-3">            
            <select name="testum_volaguafoliar" id="testum_volaguafoliar"  class="form-control">
                <option value="LTS">LTS</option>
                <option value="CYL">CYL</option>                            
            </select>  
        </div>
    </div>    
    <?php
} else {
    $obj->__set('codlotehuma', $codlote); //Es la misma consulta, asi que no hya problema.
    $valueL = $obj->getLoteByID();
    ?>

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
    <div class="col-sm-12">
        Antecedentes a la visita (Temas por ver, resolver y/o planificar) <span class="obl">(*)</span>
        <textarea class="form-control" name="testrpta1" id="testrpta1" rows="3" cols="20"></textarea>                                    
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        Visita de Rutina - Seguimiento (Evaluación) <span class="obl">(*)</span>
        <textarea class="form-control" name="testrpta2" id="testrpta2" rows="3" cols="20"></textarea>                                    
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        Recomendaciones / Notas <span class="obl">(*)</span>
        <textarea class="form-control" name="testrpta3" id="testrpta3" rows="3" cols="20"></textarea>                                    
    </div>
</div>