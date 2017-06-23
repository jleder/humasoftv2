<?php
$opcion = $_GET['cod1'];
switch ($opcion) {
    case 'loadVariedad':

        include '../controller/C_Solicitud.php';
        $prop = new C_Propuesta();
        $codcate = $_GET['cod2'];
        $variedades = $prop->getVariedadesByCultivo($codcate);
        
        ?>
        Variedad:                                    
        <select class="form-control input-sm" name="variedad" id="variedad" onchange="loadNuevaVariedad()">
            <option value="0">seleccione...</option>                                        
            <?php foreach ($variedades as $variedad) { ?>
                <option value="<?php echo $variedad['variedad']; ?>" ><?php echo $variedad['variedad']; ?></option>
            <?php } ?>
            <option value="otro">otra...</option>
        </select>
        <?php
        break;
    
}