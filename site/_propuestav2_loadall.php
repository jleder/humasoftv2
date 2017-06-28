<?php
$opcion = $_GET['cod1'];
switch ($opcion) {
    case 'loadVariedad':

        include '../controller/C_Propuestas.php';
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

    case 'loadZona':

        include '../controller/C_Propuestas.php';
        $prop = new C_Propuesta();
        $obj_ubic = new Ubicacion();
        $codvendedor = $_GET['cod2'];
        $prop->codvendedor = $codvendedor;
        $list_zona = $obj_ubic->getZona();
        $list_zona2 = $prop->obtenerZonaxVendedor();
        ?>
        Zona:
        <select name="zona" id="zona" class="form-control">            
            <?php
            if (count($list_zona2) > 0) {
                foreach ($list_zona2 as $zona) {                    
                    echo '<option value="' . $zona['zona'] . '">' . $zona['zona'] . '</option>';
                }
            } else {
                echo '<option value="0">seleccione...</option>';
                foreach ($list_zona as $zona) {                    
                    echo '<option value="' . $zona['zona'] . '">' . $zona['zona'] . '</option>';
                }
            }
            ?>
        </select>
        <?php
        break;
}