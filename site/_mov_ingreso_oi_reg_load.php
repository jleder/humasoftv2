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

    case 'LoadDatosImportacion':
        include '../controller/C_OrdenCompra.php';

        $oimp = new OrdenCompra();
        $numero = $_GET['cod2'];
        $oimp->__set('numero_oc', trim($numero));
        $lista = $oimp->listarByNumOC();
        ?>

        <div class="col-lg-6">
            Proveedor<input type = "text" name = "nomproveedor" value = "<?php echo $lista[2]; ?>" class="form-control" readonly="" />
        </div>
        <div class="col-lg-3">
            Emision<input type = "text" name = "fecha_oc" placeholder="DD/MM/YYYY" value = "<?php echo date("d/m/Y", strtotime($lista[7])); ?>" class="form-control" readonly="" />
        </div>
        <div class="col-lg-3">
            Entrega<input type = "text" name = "fecentrega" placeholder="DD/MM/YYYY" value = "<?php echo date("d/m/Y", strtotime($lista[9])); ?>" class="form-control" readonly="" />
        </div>
        <?php
        break;

    case 'LoadDatosImportacionDetalle':

        include '../controller/C_OrdenCompra.php';
        $oimpdet = new OrdenCompraDetalle();
        $numero = $_GET['cod2'];
        $oimpdet->__set('numero_oc', trim($numero));
        $listaDetalle = $oimpdet->listarByNumOC();
        ?>
        <table class="table table-bordered" style="font-size: 10px;">
            <thead>
                <tr>            
                    <th></th>
                    <th style="text-align: center;">COD PROD</th>
                    <th style="text-align: center;">DESCRIPCION</th>
                    <th style="text-align: center;">UND.</th>
                    <th style="text-align: center;">CANT</th>
                    <th style="text-align: center;">SALDO</th>
                    <th style="text-align: center;">CANT RECIBIDA</th>
                </tr>
            </thead>   
            <tbody>
                <?php
                $ncarrito = count($listaDetalle);

                if ($ncarrito > 0) {
                    $indice = 1;
                    foreach ($listaDetalle as $producto) {
                        $codigo = $producto['codigo'];
                        $codprod = $producto['codprod'];
                        $nombre = strtoupper($producto['nombre']);                        
                        $umedida = $producto['umedida'];
                        $cantidad = $producto['cantidad'];                                                
                        $precio = $producto['preciou'];
                        $saldo = 0;
                        if($producto['saldo']<> ''){
                           $saldo = $producto['saldo']; 
                        }
                        ?>
                        <tr style="font-size: 10px;">                    
                            <td style="text-align: center;">
                                <input type="hidden" name="codigo[]" value="<?php echo $codigo; ?>" />
                                <input type="hidden" name="precio[]" value="<?php echo $precio; ?>" />
                                <?php echo $indice; ?>
                            </td>
                            <td style="text-align: left;"><input type="hidden" name="codprod[]" value="<?php echo $codprod; ?>" /><?php echo $codprod; ?></td>
                            <td><?php echo $nombre; ?></td>
                            <td style="text-align: center;"><input type="hidden" name="umedida[]" value="<?php echo $umedida; ?>" /><?php echo $umedida; ?></td>
                            <td style="text-align: center;"><?php echo number_format($cantidad, 2); ?></td>
                            <td style="text-align: center;"><input type="hidden" name="saldo[]" value="<?php echo $saldo; ?>" /><?php echo number_format($saldo, 2); ?></td>
                            <td><input type="number" style="width: 100px;" value="<?php echo $saldo;?>" step="any" name="cantidad[]" id="cantidad" /></td>
                        </tr>
                        <?php
                        $indice++;
                    }
                } else {
                    echo '<tr style="color:red"><td colspan=7>No hay productos.</td></tr>';
                }
                ?>        
            </tbody>
        </table>

        <?php
        break;
}

