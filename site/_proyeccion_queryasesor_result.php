<?php
include '../controller/C_Proyecciones.php';
$proy = new Proyeccion();
$obj = $_POST['obj'];
//print_r($obj);
$proy->codasesor = $obj['codasesor'];
$proy->proy_ano = $obj['proy_ano'];
$proy->proy_mes = $obj['proy_mes'];
?>
<h3>Tabla de Proyecciones por Clientes</h3>
<table class="table table-bordered" style="font-size: 10px;">
    <thead>
        <tr>
            <th></th>
            <th>CLIENTE</th>
            <th>PRODUCTO</th>
            <th>LITROS</th>            
        </tr>
    </thead>
    <tbody>
        <?php
        $listaproy = $proy->consultarProyeccionxAsesor();
        $m = 0;
        foreach ($listaproy as $valor) {
            $m++;
            ?>
            <tr>
                <td><?php echo $m; ?></td>
                <td><?php echo $valor['cliente'] ?></td>
                <td><?php echo $valor['producto'] ?></td>
                <td><?php echo $valor['litros'] ?></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>
<hr/>
<h3>Tabla de Proyecciones por Litros</h3>
<table class="table table-bordered" style="font-size: 10px;">
    <thead>
        <tr>
            <th></th>
            <th>PRODUCTOS</th>
            <th style="text-align: center;">LITROS</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $listadet = $proy->consultarProyeccionxAsesorLitros();
        $litros = 0;
        $i = 0;
        foreach ($listadet as $valor) {
            $i++;
            $litros+= $valor['litros'];
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $valor['nombre']; ?></td>
                <td style="text-align: right;"><?php echo $valor['litros']; ?></td>
            </tr>            
            <?php
        }
        ?>       
            <tr>
                <td></td>
                <td style="font-weight: bold;">TOTAL LITROS</td>
                <td style="font-weight: bold; text-align: right;"><?php echo number_format($litros,0); ?></td>
            </tr>
    </tbody>
</table>
