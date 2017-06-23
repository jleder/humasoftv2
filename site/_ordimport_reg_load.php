<?php
$accion = $_GET['cod1'];

switch ($accion) {
    case 'LoadPrecioUnitario':
        include '../controller/C_OrdenCompra.php';
        $prod = new C_Producto();
        $codprod = $_GET['cod2'];
        $get = $prod->getPrecioE($codprod);
        $preciou = $get[3];
        ?>  
        Precio Unitário
        <input type="number" name="preciou" id="preciou" class="form-control" value="<?php echo $preciou ?>" step="any" min="0" />
        <?php
        break;

    case 'LoadCia':
        include '../controller/C_Compania.php';
        $cia = new Compania();
        $codcia = $_GET['cod2'];
        $cia->__set('codcia', trim($codcia));
        $listacia = $cia->getInfoCiaByCod();                
        ?>

        <div class="row">                                                                
            <div class="col-lg-3">
                RUC<input type = "text" name = "ruc" placeholder="" value = "<?php echo $listacia[4]; ?>" class="form-control" id="ruc" />
            </div>
            <div class="col-lg-6">
                Dirección Fiscal<input type = "text" name = "dirfiscal" placeholder="" value = "<?php echo $listacia[2]; ?>" class="form-control" id="dirfiscal" />
            </div>
            <div class="col-lg-3">
                Ciudad<input type = "text" name = "ciudad" placeholder="" value = "<?php echo $listacia[6]; ?>" class="form-control" id="ciudad" />
            </div>
        </div>
        <div class="row">                                                                
            <div class="col-lg-3">
                Pais<input type = "text" name = "pais" placeholder="" value = "<?php echo $listacia[7]; ?>" class="form-control" id="pais" />
            </div>
            <div class="col-lg-3">
                Telefono<input type = "text" name = "telefono" placeholder="" value = "<?php echo $listacia[3]; ?>" class="form-control" id="telefono" />
            </div>
            <div class="col-lg-6">
                Contacto<input type = "text" name = "contacto" placeholder="" value = "Salvador Giha" class="form-control" id="contacto" />
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                Dirección de Entrega<input type = "text" name = "direntrega" placeholder="" value = "<?php echo $listacia[5]; ?>" class="form-control" id="direntrega" />
            </div>
        </div>
        <?php
        break;
}

