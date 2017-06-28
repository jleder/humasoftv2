<?php
session_start();
include '../controller/C_Solicitud.php';
//
$obj = new C_Solicitud();
$cultivo = trim($_GET['cod1']);
$opc = trim($_GET['cod2']);
$repvar = $obj->generarVariedades3(trim($cultivo));

switch ($opc) {
    case 'opc_humavariedad':
        ?>
        <label class="col-sm-3 control-label">Variedad:</label>            
        <div class="col-sm-5">                                                
            <select name="humavariedad" id="humavariedad" class="form-control" onchange="otroVariedadHuma()">
                <option value="0">..:: Seleccione ::..</option>
                <?php foreach ($repvar as $valor) { ?>                                
                    <option value="<?php echo $valor['variedad']; ?>"> <?php echo $valor['variedad']; ?></option>
                <?php } ?>
                <option value="DESCONOCIDO">Desconocido</option>
                <option value="OTRO">..:: Otro ::..</option>
            </select>
        </div>
        <div id="divnewvariedadhuma" class="col-sm-4" hidden="">
            <input type="text" name="newvariedadhuma" class="form-control" id="newvariedadhuma" value="" placeholder="Escribir variedad" />
        </div> 
        <?php
        break;

    case 'opc_testvariedad':
        ?>
        <label class="col-sm-3 control-label">Variedad:</label>            
        <div class="col-sm-5">                                                
            <select name="testvariedad" id="testvariedad" class="form-control" onchange="otroVariedadTest()">
                <option value="0">..:: Seleccione ::..</option>
                <?php foreach ($repvar as $valor) { ?>                                
                    <option value="<?php echo $valor['variedad']; ?>"> <?php echo $valor['variedad']; ?></option>
                <?php } ?>
                <option value="DESCONOCIDO">Desconocido</option>
                <option value="OTRO">..:: Otro ::..</option>
            </select>
        </div>
        <div id="divnewvariedadtest" class="col-sm-4" hidden="">
            <input type="text" name="newvariedadtest" class="form-control" id="newvariedadtest" value="" placeholder="Escribir variedad" />
        </div> 
        <?php
        break;

    default : echo 'No encontrado';
        break;
}