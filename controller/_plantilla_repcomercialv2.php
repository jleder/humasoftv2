<?php
$reporte = $_POST['reporte'];

function arreglarHora($hora, $minuto) {
    $h = strlen($hora);
    $m = strlen($minuto);
    if ($h == 1) {
        $hora = '0' . $hora;
    }
    if ($m == 1) {
        $minuto = '0' . $minuto;
    }
    $resultado = $hora . ':' . $minuto;
    if($resultado == ':') { $resultado = '';}
    return $resultado;
}

function tipoVisita($valor) {

        $rpta = '';

        switch ($valor) {

            case 1:
                $rpta = 'VISITA COMERCIAL';
                break;
            case 2:
                $rpta = 'LLAMADA COMERCIAL';
                break;
            case 3:
                $rpta = 'VISITA COMERCIAL NO ATENDIDA';
                break;
            case 4:
                $rpta = 'LLAMADA COMERCIAL NO ATENDIDA';
                break;
        }
        return $rpta;
    }

//
$horaingreso = arreglarHora($reporte[9], $reporte[10]);
$horasalida = arreglarHora($reporte[11], $reporte[12]);
$horaproxvis = arreglarHora($reporte[14], $reporte[15]);

//SOLUCION A FECHA NULA
$fechaprox = '';
if (!empty(trim($reporte[13]))) {
    $fechaprox = date("d/m/Y", strtotime($reporte[13]));
}
if ($horaproxvis == '00:00' || empty(trim($horaproxvis))) {
    $horaproxvis = '';
}
?>
<style>
    .margen { margin-left: 3mm;}
    .preg td{ text-align: justify; background: #cccccc; padding: 5px;  }  img { width: 350px;} .result { font-weight: bold; font-size: 11px; } .titulo{margin-top: 50px; font-size: 10px;} table, body { font-size: 9px; } tr{ padding: 2px;}
    .codrep { color: #ff0000; }

    table.tableau { text-align: left; background-color: #ccccff; border: solid 1px #cccccc; }
    table.tableau td { width: 15mm; font-family: courier; }
    table.tableau th { width: 15mm; font-family: courier; }

    table.rep { vertical-align: top; padding: 3px;  }
    table.rep td { width: 95mm;  border: solid 1px #cccccc; text-align: justify; }
    table.rep th { width: 95mm;  border: solid 1px #cccccc; text-align: center; background: #ccccff; }

    table.cabecera { vertical-align: top; }
    table.cabecera td { width: 95mm;  border: solid 1px #cccccc; text-align: justify; }
    table.cabecera th { width: 95mm;  border: solid 1px #cccccc; text-align: center; background: #ccccff; }

    .blue {background-color: #66ccff; text-align: center; padding: 3px; width: 190mm; }
</style>
<div class="margen">
    <table style="width: 190mm; padding: 5px;">          
        <tbody>
            <tr>
                <td style="width: 190mm;"><img src="../site/img/logo_reptecnico.JPG" height="100px;" width="150px" /></td>                    
            </tr>
            <tr style="">
                <td style="width: 190mm;">
                    <h4 style="text-align: center">
                        <?php $titulo = tipoVisita($reporte[21]); echo $titulo ?> <span class="codrep">N° <?php echo $reporte[0]; ?></span>
                    </h4>
                </td>                                                           
            </tr>
        </tbody>
    </table>          
    <table style="width: 190mm; background: #ccffcc; padding: 5px" >
        <tbody>                                
            <tr class="titulo">
                <td style="width: 60mm;"><br/>Empresa:</td>
                <td style="width: 60mm;"><br/>Fundo:</td>
                <td style="width: 70mm;" colspan="2"><br/>Contacto:</td>
            </tr>
            <tr class="result">
                <td style="width: 60mm;">
                    <strong><?php echo $reporte[2]; ?></strong>
                </td>
                <td style="width: 60mm;"><?php echo $reporte[4]; ?></td>
                <td style="width: 70mm;" colspan="2"><?php echo $reporte[7]; ?></td>                    
            </tr>                        
            <tr class="titulo">
                <td style="width: 60mm;"><br/>Zona:</td>
                <td style="width: 60mm;"><br/>Cultivo:</td>
                <td style="width: 70mm;" colspan="2"><br/></td>
            </tr>
            <tr class="result">
                <td>
                    <?php echo $reporte[22]; ?>
                </td>
                <td><?php echo $reporte[23]; ?></td>
                <td colspan="2"></td>                    
            </tr> 
            <tr class="titulo">
                <td><br/>Asesor:</td>
                <td><br/>Fecha Visita:</td>
                <td><br/>Hora Ingreso:</td>
                <td><br/>Hora Salida:</td>
            </tr>
            <tr class="result">
                <td><?php echo $reporte[6]; ?></td>
                <td><?php echo date("d/m/Y", strtotime($reporte[8])); ?></td>
                <td><?php echo $horaingreso ?></td>
                <td><?php echo $horasalida; ?></td>
            </tr>

<!--<tr>
    <td colspan="7"><hr/></td>
</tr>-->
        </tbody>
    </table>
    <br/>
    <?php
    $rptaHuma = $_POST['rptaHuma'];
    ?>
    <!--Aqui va el codigo del lote-->        
    <table style="width: 190mm;">               
        <tbody>
            <tr>
                <td style="background-color: #66ccff; text-align: center; width: 190mm;"><h5>DETALLES DE LA VISITA</h5></td>
            </tr>             
            <tr class="preg">
                <td style="width: 193mm;"><strong> Visita Anterior </strong></td>
            </tr>
            <tr>
                <td style="width: 193mm;">
                    <?php echo $rptaHuma[0][6]; ?><br/><br/>
                </td>                            
            </tr>
            <tr class="preg">
                <td style=" width: 193mm;"><strong> Temas tratados en esta visita/llamada </strong> </td>
            </tr>
            <tr>
                <td style="width: 193mm;" >
                    <?php echo $rptaHuma[1][6]; ?><br/><br/>
                </td>
            </tr>
            <tr class="preg">
                <td style="width: 193mm;"><strong>Notas de esta visita (Notas de fotos) o posibles pedidos</strong> </td>
            </tr>
            <tr>
                <td style="width: 193mm;">
                    <?php echo $rptaHuma[2][6]; ?><br/><br/>
                </td>
            </tr>
        </tbody>
    </table>
    <br/>

    <table style="width: 190mm; padding: 5px;">            
        <tbody>         
            <tr>
                <td style="width: 95mm;"><br/><strong>Próxima Visita:</strong></td>                    
                <td style="width: 95mm;"><br/><strong>Motivo:</strong></td>
            </tr>
            <tr class="">
                <td style="width: 95mm;"><?php echo $fechaprox . ' - ' . $horaproxvis; ?></td>                    
                <td style="width: 95mm;"><?php echo $reporte[16]; ?></td>
            </tr>
            <tr>
                <td style="text-align: center;"><br/><br/><br/><strong><?php echo $reporte[7]; ?></strong></td>                    
                <td style="text-align: center;"><br/><br/><br/><strong><?php echo $reporte[6]; ?></strong></td>
            </tr>
            <tr>
                <td style="text-align: center;"> FIRMADO POR </td>                    
                <td style="text-align: center;"> ASESOR HUMAGRO </td>
            </tr>

        </tbody>
    </table>
</div>