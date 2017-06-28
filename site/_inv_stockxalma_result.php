<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../controller/C_Movimientos.php';

$inv = new Inventario();

$codalmacen = $_GET['cod2'];
$inv->__set('codalmacen', $codalmacen);
$lista = $inv->getStockxAlmacen();
?>
<div class="col-md-12">

    <table class="table table-bordered" style="font-size: 11px;">
        <thead>
            <tr style="background-color: #95d3e0">
                <th></th>
                <th>CODIGO</th>
                <th>PRODUCTO</th>
                <th>UNIDAD</th>
                <th>STOCK</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i=1;
            foreach ($lista as $value) {
                ?>
                <tr style="background-color: white;">
                    <td><?php echo $i;?></td>
                    <td><?php echo $value['codprod'];?></td>
                    <td><?php echo $value['nombre'];?></td>
                    <td><?php echo $value['umedida'];?></td>
                    <td><?php echo number_format($value['stock'],2);?></td>
                </tr>
                <?php
                $i++;
            }
            ?>                       
        </tbody>
    </table>


</div>
