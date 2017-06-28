<?php
include '../controller/C_OrdenCompra.php';
$ocom = new OrdenCompra();

$listaCompras = $ocom->listarAllOC();
?>

<div class="row">
    <div class="col-lg-12">
        <a class="btn btn-default btn-sm" href="#divcompra" onclick="cargar('#divcompra', '_ordcompra_reg.php')">Registrar Orden de Compra</a>
    </div>        
</div>
<div class="row" id="divcompra">
    <div class="col-lg-12">
        <br/>

        <table style="font-size: 11px;" id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr style="background-color: #e74c3c; color: white;">
                    <th>Fecha Orden Compra</th>
                    <th>Número OC</th>
                    <th>Proveedor</th>                    
                    <th>Forma Pago</th>                    
                    <th>Via</th>
                    <th style="font-size: 15px; text-align: center;"><span class="fa fa-cog"></span></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($listaCompras as $lista) {
                    ?>
                    <tr>
                        <td><?php echo date("d.m.Y", strtotime($lista['fecha_oc'])); ?></td>
                        <td><?php echo $lista['numero_oc']; ?></td>
                        <td><?php echo $lista['nombre']; ?></td>                    
                        <td><?php echo $lista['fpago']; ?></td>
                        <td><?php echo $lista['via']; ?></td>
                        <td style="text-align: center;">                        
                            <a onclick="cargar('#divcompra', '_ordcompra_view.php?cod=<?php echo trim($lista['numero_oc']); ?>')" class="btn btn-default"><span style="color:green;" class="fa fa-calendar"></span></a>
                            <a href="_ordcompra_genpdf.php?cod=<?php echo trim($lista['numero_oc']); ?>" class="btn btn-default" target="_blank"><span style="color:#0099ff;" class="fa fa-eye"></span></a>
                            <a href="_ordcompra_getpdf.php?cod=<?php echo trim($lista['numero_oc']); ?>" class="btn btn-default" target="_blank"><span class="fa fa-file-pdf-o"></span></a>
                            <a onclick="cargar('#divcompra', '_ordcompra_edit.php?cod=<?php echo trim($lista['numero_oc']); ?>')" class="btn btn-default"><span class="fa fa-pencil-square-o"></span></a>
                            <a class="btn btn-default"><span style="color:red;" class="fa fa-trash-o"></span></a>                            
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>

        </table>
    </div>
</div>