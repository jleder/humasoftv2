<?php
/*
 * Proyecto Humasoft.
 * Desarrollado por Juan Leder
 */
session_start();
include '../controller/C_Viaticos.php';

$viatico = new Viatico();
$viating = new ViaticoIngreso();
$viategr = new ViaticoDet();


$objeto = $_GET['objeto'];
$viatico->codpersona = trim($objeto['codpersona']);
$viatico->periodo = trim($objeto['periodo']);
$viatico->periodo_mes = trim($objeto['periodo_mes']);
$viatico->periodo_ano = trim($objeto['periodo_ano']);

$total_ingreso = 0;
$total_egreso = 0;
$saldo_anterior = 0;
$saldo_final = 0;
$codpersona = trim($objeto['codpersona']);
$codviatico = 0;

$existe = $viatico->listarExistePeriodo();
if ($existe) {
    //Si existe obtenemos el id
    $codviatico = $existe[0];
    $saldo_anterior = $existe[6];
    $viating->codviatico = trim($codviatico);
    $listaIngreso = $viating->listarIngresosByCodviatico();
    ?>
    <div class="row">
        <div class="col-md-12">
            <h3 class="lead">Tabla de Ingresos</h3>
            <table class="table table-bordered" style="font-size: 11px;">
                <thead>
                    <tr>
                        <td><span class="fa fa-tag"></span></td>
                        <th>Fecha</th>
                        <th>Detalle</th>
                        <th style="text-align: center">Monto</th>
                        <th style="text-align: center"><span class="fa fa-cog text-center"></span></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($listaIngreso) > 0) {
                        $i = 0;
                        foreach ($listaIngreso as $ingreso) {
                            $i++;
                            $total_ingreso += $ingreso['valor'];
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo date("d/m/Y", strtotime($ingreso['fecha'])); ?></td>
                                <td><?php echo $ingreso['descripcion']; ?></td>
                                <td style="text-align: right;">S/.<?php echo number_format($ingreso['valor'], 2); ?></td>
                                <td style="text-align: center">
                                    <button class="btn btn-default btn-sm"><span class="fa fa-edit text-info"></span></button>
                                    <button class="btn btn-danger btn-sm"><span class="fa fa-trash-o"></span></button>
                                </td>
                            </tr>

                            <?php
                        }
                        ?>
                        <tr style="font-weight: bolder; font-size: small; text-align: right;">
                            <td colspan="3" style="text-align: right; font-weight: bold;">Total Ingresos</td>                                                        
                            <td><?php echo 'S/.' . number_format($total_ingreso, 2); ?></td>                        
                            <td></td>
                        </tr>
                        <?php
                    } else {
                        ?>
                        <tr>
                            <td colspan="5">No se encontraron resultados</td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <br/>
    <br/>
    <?php
    $viategr->codviatico = trim($codviatico);
    $listaEgreso = $viategr->listarDetalleViaticoByCodViatico();
    ?>
    <div class="row">    
        <div class="col-md-12">
            <h3 class="lead">Tabla de Egresos</h3>
            <table class="table table-bordered" style="font-size: 11px;">
                <thead>
                    <tr style="background-color:#e3ebeb">
                        <th>Item</th>
                        <th style="text-align: center;">Fecha</th>                                            
                        <th>Categoria</th>
                        <th>Razon Social</th>
                        <th>Concepto</th>
                        <th>Zona de Gasto</th>
                        <th style="text-align: center;">Valor</th>
                        <th style="text-align: center;">IGV</th>
                        <th style="text-align: center;">Precio Venta</th>
                        <td><span class="fa fa-cog"></span></td>
                    </tr>                    
                </thead>
                <tbody>
                    <?php
                    if (count($listaEgreso) > 0) {
                        $item = 0;
                        $valor_total = 0;
                        $valigv_total = 0;
                        $pventa_total = 0;
                        foreach ($listaEgreso as $valor) {
                            $item++;
                            ?>
                            <tr>
                                <td><?php echo $item; ?></td>
                                <td><?php echo date("d/m/Y", strtotime($valor['fecha'])); ?></td>                            
                                <td><?php echo $valor['desele']; ?></td>
                                <td><?php echo $valor['proveedor']; ?></td>
                                <td><?php echo $valor['concepto']; ?></td>
                                <td><?php echo $valor['nomzona']; ?></td>
                                <td style="text-align: right;"><?php echo 'S/.' . number_format($valor['valor'], 2); ?></td>
                                <td style="text-align: right;"><?php echo 'S/.' . number_format($valor['valigv'], 2); ?></td>
                                <td style="text-align: right;"><?php echo 'S/.' . number_format($valor['pventa'], 2); ?></td>
                                <td style="text-align: center">
                                    <button class="btn btn-default btn-sm"><span class="fa fa-edit text-info"></span></button>
                                    <button class="btn btn-danger btn-sm"><span class="fa fa-trash-o"></span></button>
                                </td>
                            </tr>

                            <?php
                            $valor_total+= $valor['valor'];
                            $valigv_total+= $valor['valigv'];
                            $pventa_total+= $valor['pventa'];
                        }
                        $total_egreso = $pventa_total;
                        ?>
                        <tr style="font-weight: bolder; font-size: small; text-align: right;">
                            <td colspan="6"></td>
                            <td><?php echo 'S/.' . number_format($valor_total, 2); ?></td>
                            <td><?php echo 'S/.' . number_format($valigv_total, 2); ?></td>
                            <td><?php echo 'S/.' . number_format($pventa_total, 2); ?></td>                        
                            <td></td>
                        </tr>
                    <?php } else {
                        ?>
                        <tr>
                            <td colspan="10">No se encontraron resultados</td>
                        </tr>
                    <?php }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
    $saldo_final = ($saldo_anterior + $total_ingreso) - $total_egreso;
    ?>
    <div class="row">    
        <div class="col-md-12">
            <h3 class="lead">Saldo Final</h3>
            <table class="table table-bordered" style="font-size: 11px; width: 300px;">                
                <tbody>
                    <tr>
                        <td>Saldo Anterior</td>
                        <td style="text-align: right;">S/. <?php echo number_format($saldo_anterior, 2); ?></td>
                    </tr>
                    <tr>
                        <td>Total Ingresos</td>
                        <td style="text-align: right;">S/. <?php echo number_format($total_ingreso, 2); ?></td>
                    </tr>
                    <tr>
                        <td>Total Egresos</td>
                        <td style="text-align: right;">S/. <?php echo number_format($total_egreso, 2); ?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bolder; font-size: medium;">Saldo Final</td>
                        <td style="text-align: right; font-weight: bolder; font-size: medium;">S/. <?php echo number_format($saldo_final, 2); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 text-right"><a class="btn btn-default" href="_viaticoquery_excel.php?cod1=<?php echo $codpersona; ?>&cod2=<?php echo $codviatico; ?>" target="_blank"><img src="img/iconos/excelicon.png" height="20" /></a></div>
    </div>

    <?php
} else {
    
}
?>

