<?php
include '../controller/C_Producto.php';
$prod = new C_Producto();

$modo = $_GET['cod1'];
$codprod = $_GET['cod2'];
$prod->__set('codigo', $codprod);

$lista = $prod->getProductoByCod();
$precio = 0;
if ($lista) {
    $precio = $lista[7];
}

if ($modo == 'Insert') {
    ?>
    <div class="col-md-2">
        Precio Unitário
        <input type="number" name="precio" id="precio" class="form-control" value="<?php echo number_format($precio, 2); ?>" step="any" min="0" />
    </div> 
    <div class="col-md-2">
        Congelar Precio Unit
        <select class="form-control " name="congelar2" id="congelar2">
            <option value="F">No</option>
            <option value="T">Si</option>
        </select>
    </div>
    <div id="" class="col-md-2">
        Precio Dscto
        <input type="number" name="preciodcto" id="preciodcto" class="form-control " value="<?php echo number_format($precio, 2); ?>" step="any" min="0" />
    </div>
<?php } elseif ($modo == 'Update') {
    ?>
    <div class="col-md-2">
        Precio Unitário
        <input type="number" name="precio_update" id="precio_update" class="form-control " value="<?php echo number_format($precio, 2); ?>" step="any" min="0" />
    </div> 
    <div class="col-md-2">
        Congelar Precio Unit
        <select class="form-control " name="congelar2_update" id="congelar2_update">
            <option value="F">No</option>
            <option value="T">Si</option>
        </select>
    </div>
    <div id="" class="col-md-2">
        Precio Dscto
        <input type="number" name="preciodcto_update" id="preciodcto_update" class="form-control " value="<?php echo number_format($precio, 2); ?>" step="any" min="0" />
    </div>
    <?php
}