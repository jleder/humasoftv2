<?php
require_once '../controller/C_Viaticos.php';
$viaticos = new Viatico();
$viadet = new ViaticoDet();
$empleados = new Empleado();
//$ubicacion = new Ubicacion();
//print_r($_SERVER);

$codpersona = $_GET['cod1'];
$codviatico = $_GET['cod2'];
$viaticos->codviatico = $codviatico;
$viadet->codviatico = $codviatico;
$empleados->codpersona = $codpersona;

$listPeriodoViatico = $viaticos->listarViaticoByCod();
$listEmpleado = $empleados->listarEmpleadoByCod();
$listaDetalleViatico = $viadet->listarDetalleViaticoByCodViatico();
$listaDetalleViaticoComb = $viadet->listarDetalleViaticoCombByCodViatico();
$listaTipoViaticos = $viaticos->listarTipoViaticoAll();


?>
<div class="form-group">
    <div class="col-sm-12 text-right"><a class="btn btn-default" href="_viaticoquery_excel.php?cod1=<?php echo $codpersona;?>&cod2=<?php echo $codviatico; ?>" target="_blank"><img src="img/iconos/excelicon.png" height="20" /></a></div>
</div>
<div class="form-group">
    <h1 class="text-center">Rendición de Viáticos</h1>
</div>
<div class="form-group">
    <span class="col-sm-2 control-label">Persona:</span><label class="col-sm-6"><?php echo $listEmpleado[1] . ' ' . $listEmpleado[2]; ?></label>
</div>
<div class="form-group">
    <span class="col-sm-2 control-label">Periodo:</span><label class="col-sm-2"><?php echo $listPeriodoViatico[2] . '/' . $listPeriodoViatico[3]; ?></label>
</div>
<div class="form-group">            
    <span class="col-sm-2 control-label">Cargo:</span><label class="col-sm-6"><?php echo $listEmpleado[15]; ?></label>
</div>
<div class="form-group">
    <span class="col-sm-2 control-label">Saldo Anterior:</span><label class="col-sm-3"><?php echo $listPeriodoViatico[5]; ?></label>
</div>
<div class="form-group">
    <div class="col-xs-12">
        <table class="table table-striped" style="font-size: 10px;">
            <thead>
                <tr style="background-color: #90c9e7">
                    <th rowspan="2">Item</th>
                    <th rowspan="2" style="text-align: center;">Fecha</th>                    
                    <th colspan="2" style="text-align: center;">Documento</th>
                    <th rowspan="2">Categoria</th>
                    <th rowspan="2">Razon Social</th>
                    <th rowspan="2">Concepto</th>
                    <th rowspan="2">Zona de Gasto</th>
                    <th rowspan="2" style="text-align: center;">Valor</th>
                    <th rowspan="2" style="text-align: center;">IGV</th>
                    <th rowspan="2" style="text-align: center;">Precio Venta</th>
                </tr>
                <tr style="background-color: #90c9e7">
                    <th style="text-align: center;">Tipo</th>
                    <th style="text-align: center;">Numero</th>                    
                </tr>
            </thead>
            <tbody>
                <?php
                $item = 0;
                $valor_total = 0;
                $valigv_total = 0;
                $pventa_total = 0;
                foreach ($listaDetalleViatico as $valor) {
                    $item++;
                    ?>
                    <tr>
                        <td><?php echo $item; ?></td>
                        <td><?php echo date("d/m/Y", strtotime($valor['fecha'])); ?></td>                    
                        <td><?php echo $valor['doctipo']; ?></td>
                        <td><?php echo $valor['docnum']; ?></td>
                        <td><?php echo $valor['desele']; ?></td>
                        <td><?php echo $valor['proveedor']; ?></td>
                        <td><?php echo $valor['concepto']; ?></td>
                        <td><?php echo $valor['nomzona']; ?></td>
                        <td style="text-align: right;"><?php echo 'S/.' . number_format($valor['valor'], 2); ?></td>
                        <td style="text-align: right;"><?php echo 'S/.' . number_format($valor['valigv'], 2); ?></td>
                        <td style="text-align: right;"><?php echo 'S/.' . number_format($valor['pventa'], 2); ?></td>
                    </tr>

                    <?php
                    $valor_total+= $valor['valor'];
                    $valigv_total+= $valor['valigv'];
                    $pventa_total+= $valor['pventa'];
                }
                ?>
                <tr style="font-weight: bolder; font-size: small; text-align: right;">
                    <td colspan="8"></td>
                    <td><?php echo 'S/.' . number_format($valor_total, 2); ?></td>
                    <td><?php echo 'S/.' . number_format($valigv_total, 2); ?></td>
                    <td><?php echo 'S/.' . number_format($pventa_total, 2); ?></td>                        
                </tr>
            </tbody>
        </table>
        <hr/>
        <h4>Detalles de Combustible y Lubrificantes</h4>
        <table class="table table-striped" style="font-size: 10px;">
            <thead>
                <tr style="background-color: #90c9e7">
                    <th rowspan="2">Item</th>
                    <th rowspan="2" style="text-align: center;">Fecha</th>                    
                    <th colspan="2" style="text-align: center;">Documento</th>                    
                    <th rowspan="2">Razon Social</th>                    
                    <th rowspan="2">Zona de Gasto</th>
                    <th colspan="4" style="text-align: center;">Consumo de Combustible</th>                                        
                    <th rowspan="2" style="text-align: center;">Valor</th>
                    <th rowspan="2" style="text-align: center;">IGV</th>
                    <th rowspan="2" style="text-align: center;">Precio Venta</th>
                </tr>
                <tr style="background-color: #90c9e7">
                    <th style="text-align: center;">Tipo</th>
                    <th style="text-align: center;">Numero</th>
                    <th style="text-align: center;">Km Cierre</th>
                    <th style="text-align: center;">Km Recorrido</th>
                    <th style="text-align: center;">Nro Galones</th>
                    <th style="text-align: center;">Precio x Galon</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $item = 0;
                $valor_total = 0;
                $valigv_total = 0;
                $pventa_total = 0;
                foreach ($listaDetalleViaticoComb as $valor) {
                    $item++;
                    ?>
                    <tr>
                        <td><?php echo $item; ?></td>
                        <td><?php echo date("d/m/Y", strtotime($valor['fecha'])); ?></td>                    
                        <td><?php echo $valor['doctipo']; ?></td>
                        <td><?php echo $valor['docnum']; ?></td>                        
                        <td><?php echo $valor['proveedor']; ?></td>
                        <td><?php echo $valor['nomzona']; ?></td>
                        <td style="text-align: right;"><?php echo number_format($valor['kmcierre'], 2); ?></td>
                        <td style="text-align: right;"><?php echo number_format($valor['kmrecorrido'], 2); ?></td>
                        <td style="text-align: right;"><?php echo number_format($valor['galones'], 2); ?></td>
                        <td style="text-align: right;"><?php echo 'S/.' . number_format($valor['pgalon'], 2); ?></td>                        
                        <td style="text-align: right;"><?php echo 'S/.' . number_format($valor['valor'], 2); ?></td>
                        <td style="text-align: right;"><?php echo 'S/.' . number_format($valor['valigv'], 2); ?></td>
                        <td style="text-align: right;"><?php echo 'S/.' . number_format($valor['pventa'], 2); ?></td>
                    </tr>

                    <?php
                    $valor_total+= $valor['valor'];
                    $valigv_total+= $valor['valigv'];
                    $pventa_total+= $valor['pventa'];
                }
                ?>
                <tr style="font-weight: bolder; font-size: small; text-align: right;">
                    <td colspan="10"></td>
                    <td><?php echo 'S/.' . number_format($valor_total, 2); ?></td>
                    <td><?php echo 'S/.' . number_format($valigv_total, 2); ?></td>
                    <td><?php echo 'S/.' . number_format($pventa_total, 2); ?></td>                        
                </tr>
            </tbody>
        </table>
        <hr/>
        <h4 class="text-right">Resumen de Egresos por Clasificación</h4>
        <table class="table table-striped" style="width: 50%; font-size: 10px;" align="right">
            <thead>
                <tr style="background-color: #c5ecd3">
                    <th>Nro Clasificación</th>
                    <th>Detalle</th>                                        
                    <th style="text-align: center;">Valor</th>
                    <th style="text-align: center;">IGV</th>
                    <th style="text-align: center;">Precio Venta</th>
                </tr>                
            </thead>
            <tbody>
                <?php
                $item = 0;
                $valor_total = 0;
                $valigv_total = 0;
                $pventa_total = 0;
                foreach ($listaTipoViaticos as $valor3) {
                    $item++;
                    $codtipo = $valor3['codele'];
                    $viadet->codtipo = $codtipo;
                    $totales = $viadet->listarEgresosxClasificacion();
                    if($totales[1]== 0){
                        $valor_total3 = '-';
                    }
                    if($totales[2]== 0){
                        $valigv_total3 = '-';
                    }
                    if($totales[3]== 0){
                        $pventa_total3 = '-';
                    }                    
                    ?>
                    <tr>
                        <td><?php echo $codtipo; ?></td>
                        <td><?php echo $valor3['desele']; ?></td>                                            
                        <td style="background-color: #e3e9e5; text-align: right;"><?php echo 'S/.' . number_format($totales[1], 2); ?></td>
                        <td style="background-color: #e3e9e5; text-align: right;"><?php echo 'S/.' . number_format($totales[2], 2); ?></td>
                        <td style="background-color: #e3e9e5; text-align: right;"><?php echo 'S/.' . number_format($totales[3], 2); ?></td>
                    </tr>

                    <?php
                    $valor_total+= $totales[1];
                    $valigv_total+= $totales[2];
                    $pventa_total+= $totales[3];
                }
                ?>
                <tr style="font-weight: bolder; font-size: small; text-align: right;">
                    <td colspan="2" style="text-align: right;">TOTAL EGRESOS</td>
                    <td><?php echo 'S/.' . number_format($valor_total, 2); ?></td>
                    <td><?php echo 'S/.' . number_format($valigv_total, 2); ?></td>
                    <td><?php echo 'S/.' . number_format($pventa_total, 2); ?></td>                        
                </tr>
            </tbody>
        </table>


    </div>
</div>
