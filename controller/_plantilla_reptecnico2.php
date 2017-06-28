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
    if ($resultado == ':') {
        $resultado = '';
    }
    return $resultado;
}

//
$horaingreso = arreglarHora($reporte[9], $reporte[10]);
$horasalida = arreglarHora($reporte[11], $reporte[12]);
$horaproxvis = arreglarHora($reporte[14], $reporte[15]);

//SOLUCION A FECHA NULA
$fechaprox = '';
if ($reporte[13] != null) {
    $fechaprox = date("d/m/Y", strtotime($reporte[13]));
}
if ($horaproxvis == '00:00') {
    $horaproxvis = '';
}
?>
<style>
    .margen { margin-left: 3mm;}
    .preg td{ text-align: justify; background: #cccccc; padding: 4px;   }  img { width: 350px;} .result { font-weight: bold; font-size: 11px; } .titulo{margin-top: 50px; font-size: 10px;} table, body { font-size: 9px; } tr{ padding: 2px;}
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
                <td style="width: 190mm;"><h4 style="text-align: center">REPORTE VISITA TÉCNICA/CAMPO <span class="codrep">N° <?php echo $reporte[0]; ?></span></h4></td>                                                           
            </tr>
        </tbody>
    </table>          
    <table style="width: 190mm; background: #ccffcc; padding: 5px" >
        <tbody>                                
            <tr class="titulo">
                <td style="width: 60mm;"><br/>Empresa:</td>
                <td style="width: 60mm;"><br/>Fundo:</td>
                <td style="width: 70mm;" colspan="2"><br/>Encargado:</td>
            </tr>
            <tr class="result">
                <td style="width: 60mm;">
                    <strong><?php echo $reporte[2]; ?></strong>
                </td>
                <td style="width: 60mm;"><?php echo $reporte[4]; ?></td>
                <td style="width: 70mm;" colspan="2"><?php echo $reporte[7]; ?></td>                    
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

    <?php if ($reporte[21] == 3 || $reporte[21] == 4) { ?>

        <table style="width: 190mm; font-size: small;">               
            <tr style="width: 190mm">
                <td>
                    Observaciones: <br/>
                    <?php $obs = $_POST['rptaObs'];
                    echo $obs[6];
                    ?>
                </td>
            </tr>
        </table>


        <?php
    }

    if ($_POST['huma'] == TRUE) {
        $lshuma = $_POST['lshuma'];
        $rptaHuma = $_POST['rptaHuma'];
        ?>
        <!--Aqui va el codigo del lote-->        
        <table style="width: 190mm;">               
            <tbody>
                <tr>
                    <td style="background-color: #66ccff; text-align: center; width: 190mm;" colspan="5"><h5>LOTE HUMAGRO</h5></td>
                </tr>            
                <tr>
                    <td style="width: 38mm;" colspan="1"><br/>Nombre de Lote</td>            
                    <td style="width: 38mm;" colspan="1"><br/>Ha. Trabajada</td>
                    <td style="width: 38mm;" colspan="1"><br/>Tipo de Cultivo</td>
                    <td style="width: 38mm;" colspan="1"><br/>Edad de Cultivo</td>                                                                                                          
                    <td style="width: 38mm;" colspan="1"><br/>Variedad</td>                                
                </tr>
                <tr class="">
                    <td colspan="1"><strong><?php echo $lshuma[3]; ?></strong></td>
                    <td colspan="1"><strong><?php echo $lshuma[5]; ?></strong></td>                                           
                    <td colspan="1"><strong><?php echo $lshuma[6]; ?></strong></td>                    
                    <td><strong><?php echo $lshuma[11]; ?></strong></td>
                    <td><strong><?php echo $lshuma[8]; ?></strong></td>

                </tr>
                <tr class="">
                    <td colspan="1"><br/>Patron</td>
                    <td colspan="1"><br/>Etapa Fenologica</td>                                                    
                    <td colspan="1"><br/>Tipo de Suelo</td>                    
                    <td colspan="1"><br/>Tipo de Riego</td>
                    <td><br/>Densidad por Ha.</td>
                </tr>
                <tr>
                    <td colspan="1" style=""><strong><?php echo $lshuma[9]; ?></strong></td>
                    <td colspan="1" style=""><strong><?php echo $lshuma[12]; ?></strong></td>                                        
                    <td colspan="1"><strong><?php echo $lshuma[14]; ?></strong></td>                    
                    <td colspan="1"><strong><?php echo $lshuma[13]; ?></strong></td>
                    <td><strong><?php echo $lshuma[10]; ?></strong></td>                
                </tr>    
                <tr class="">
                    <td colspan="5"></td>
                </tr>
                <tr class="preg">
                    <td style="width: 190mm;" colspan="5">Antecedentes a la visita (Temas por ver, resolver y/o planificar) </td>
                </tr>
                <tr>
                    <td style="width: 190mm;" colspan="5">
    <?php echo $rptaHuma[0][6]; ?><br/><br/>
                    </td>                            
                </tr>
                <tr class="preg">
                    <td style="width: 190mm;" colspan="5">Visita de Rutina - Seguimiento (Evaluación)</td>
                </tr>
                <tr>
                    <td style="width: 190mm;" colspan="5">
    <?php echo $rptaHuma[1][6]; ?><br/><br/>
                    </td>
                </tr>
                <tr class="preg">
                    <td style="width: 190mm;" colspan="5">Recomendaciones / Notas </td>
                </tr>
                <tr>
                    <td style="width: 190mm;" colspan="5">
    <?php echo $rptaHuma[2][6]; ?><br/><br/>
                    </td>
                </tr>
            </tbody>
        </table>
    <?php } ?>
    <br/>
    <?php
    if ($_POST['test'] == TRUE) {
        $lstest = $_POST['lstest'];
        $rptaTest = $_POST['rptaTest'];
        ?>
        <!--Aqui va el codigo del lote-->

        <table style="width: 190mm;">               
            <tbody>
                <tr>
                    <td style="background-color: #ffcccc; height: 20px; width: 190mm;" colspan="5"><h5 style="text-align: center">LOTE TESTIGO</h5></td>
                </tr>
                <tr>
                    <td style="width: 38mm;" colspan="1"><br/>Nombre de Lote</td>            
                    <td style="width: 38mm;" colspan="1"><br/>Ha. Trabajada</td>
                    <td style="width: 38mm;" colspan="1"><br/>Tipo de Cultivo</td>
                    <td style="width: 38mm;" colspan="1"><br/>Edad de Cultivo</td>                                                                                                          
                    <td style="width: 38mm;" colspan="1"><br/>Variedad</td>                                
                </tr>
                <tr class="">
                    <td colspan="1"><strong><?php echo $lstest[3]; ?></strong></td>
                    <td colspan="1"><strong><?php echo $lstest[5]; ?></strong></td>                                           
                    <td colspan="1"><strong><?php echo $lstest[6]; ?></strong></td>                    
                    <td><strong><?php echo $lstest[11]; ?></strong></td>
                    <td><strong><?php echo $lstest[8]; ?></strong></td>

                </tr>
                <tr class="">
                    <td colspan="1"><br/>Patron</td>
                    <td colspan="1"><br/>Etapa Fenologica</td>                                                    
                    <td colspan="1"><br/>Tipo de Suelo</td>                    
                    <td colspan="1"><br/>Tipo de Riego</td>
                    <td><br/>Densidad por Ha.</td>
                </tr>
                <tr class="">
                    <td colspan="1" style=""><strong><?php echo $lstest[9]; ?></strong></td>
                    <td colspan="1" style=""><strong><?php echo $lstest[12]; ?></strong></td>                                        
                    <td colspan="1"><strong><?php echo $lstest[14]; ?></strong></td>                    
                    <td colspan="1"><strong><?php echo $lstest[13]; ?></strong></td>
                    <td><strong><?php echo $lstest[10]; ?></strong></td>                
                </tr>
                <tr class="">
                    <td colspan="5"></td>
                </tr>
                <tr class="preg">
                    <td style="width: 190mm;" colspan="5">Antecedentes a la visita (Temas por ver, resolver y/o planificar) </td>
                </tr>
                <tr>
                    <td style="width: 190mm;" colspan="5">
    <?php echo $rptaTest[0][6]; ?><br/><br/>
                    </td>                            
                </tr>
                <tr class="preg">
                    <td style="width: 190mm;" colspan="5">Visita de Rutina - Seguimiento (Evaluación)</td>
                </tr>
                <tr>
                    <td style="width: 190mm;" colspan="5">
    <?php echo $rptaTest[1][6]; ?><br/><br/>
                    </td>
                </tr>
                <tr class="preg">
                    <td style="width: 190mm;" colspan="5">Recomendaciones / Notas </td>
                </tr>
                <tr>
                    <td style="width: 190mm;" colspan="5">
    <?php echo $rptaTest[2][6]; ?><br/><br/>
                    </td>
                </tr>

            </tbody>
        </table>
<?php } ?>
    <br/>


    <table style="width: 190mm; padding: 5px;">            
        <tbody> 
            <tr>
                <td style="width: 190mm;" colspan="2"><br/><strong>Notas al cliente:</strong><br/> <?php echo $reporte[17]; ?></td>                    
            </tr>                
            <tr>
                <td style="width: 95mm;"><br/><strong>Próxima Visita:</strong></td>                    
                <td style="width: 95mm;"><br/><strong>Motivo:</strong></td>
            </tr>
            <tr class="">
                <td style="width: 95mm;"><?php echo $fechaprox . ' - ' . $horaproxvis; ?></td>                    
                <td style="width: 95mm;"><?php echo $reporte[16]; ?></td>
            </tr>
            <tr>
                <td style="text-align: center;"><br/><br/><br/><strong><?php echo $reporte[18]; ?></strong></td>                    
                <td style="text-align: center;"><br/><br/><br/><strong><?php echo $reporte[6]; ?></strong></td>
            </tr>
            <tr>
                <td style="text-align: center;"> FIRMADO POR </td>                    
                <td style="text-align: center;">ASESOR HUMAGRO</td>
            </tr>

        </tbody>
    </table>
</div>