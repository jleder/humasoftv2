<?php
include_once '../controller/C_Propuestas.php';
$prop = new C_Propuesta();
$modo = $_GET['cod1'];
$cliente = $_GET['cod2'];

$prop->__set('codcliente', $cliente);

if ($modo == '1') {
    $result = $prop->consultaPropxCli();
} elseif ($modo == '2') {
    $ecomer = $_GET['cod3'];
    $result = $prop->consultaPropxClixEcomer($ecomer);
}

?>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn-default" href="#" onclick="descargarExcel();">Descargar Excel</a>           
    </div>
</div>
<div class="row" id="divexport">
    <div class="col-md-12">
        <table class="table table-bordered table-striped table-hover table-heading table-datatable">
            <thead>
                <tr>
                    <th>Fecha Registro</th>
                    <th>Codigo Propuesta</th>                    
                    <th>Cliente</th>
                    <th>Vendedor</th>
                    <th>Forma de Pago</th>
                    <th>Estado Comercial</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($result as $val) {
                    ?>
                    <tr>
                        <td><?php echo date("d/m/Y", strtotime($val['fecreg']));?></td>
                        <td><?php echo $val['codprop'];?></td>                        
                        <td><?php echo $val['nomcliente'];?></td>
                        <td><?php echo $val['vendedor'];?></td>
                        <td><?php echo $val['fpago'];?></td>
                        <td><?php echo $val['estado'];?></td>                        
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

