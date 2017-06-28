<?php
$accion = $_GET['cod1'];

switch ($accion) {
    case 'LoadPrecioA':
        include '../controller/C_Proyecciones.php';
        $prod = new C_Producto();
        $codprod = $_GET['cod2'];
        $get = $prod->getPrecioA($codprod);
        $preciou = $get[3];
        ?>  
        Precio Unitário
        <input type="number" name="preciou" id="preciou" class="form-control" value="<?php echo $preciou ?>" step="any" min="0" />
        <?php
        break;
    
}