<?php
@session_start();
include_once '../controller/C_Reportes.php';
$obj = new C_Reportes();
$objtec = new C_Reportes();
date_default_timezone_set("America/Bogota");
//Capturar fecha actual - Teniendo en cuenta que este metodo se ejecutara los dias sabados.
//$hasta = '2016-11-05';
$hasta = date('Y-m-d');

//Restar Dias
//$desde = '2016-10-30';
$desde = date('Y-m-d', strtotime('-6 day'));

$finicio = date('l, d/M/Y', strtotime($desde));
$ffin = date('l, d/M/Y', strtotime($hasta));

//$ldiastec = $objtec->mostrarDias($desde, $hasta, '1');
//$ldias = $obj->mostrarDias($desde, $hasta, '2');
$soldias = $obj->mostrarDiasxSolicitud($desde, $hasta);
$propdias = $obj->mostrarDiasxPropAprob($desde, $hasta);
$listavendedores = $obj->getVendedores();
$ventasEnero = $obj->ventasEnero2017();

//ARREGLOS PARA EL RESUMEN GENERAL DE VISITAS TECNICAS Y COMERCIALES
$array_resvt = array();
$array_resvc = array();
?>
<html>
    <head>
        <title>Reporte Gerencial Semanal</title>
        <style>
            /*body { background-color: whitesmoke;}*/
            .pagina { width: 200mm; margin: auto; background-color: white; }
            /*.margen { padding-left: 10mm; padding-right: 8mm; padding-bottom: 8mm; padding-top: 15mm;}*/
            .margen { padding: 0px;}
            .titulo { text-align: center; font-weight: bolder; font-size: 14px; width: 200mm; }
            .divtitulo_reptecnico { width: 195mm; background-color: #b1dbf9; padding: 5px; text-align: center; font-weight: bolder; font-size: 14px; }
            .divtitulo_resumen { width: 195mm; background-color: #1ABC9C; padding: 5px; text-align: center; font-weight: bolder; font-size: 14px; }
            .divdia { font-style: italic; font-size: 12px; font-weight: bold; color: #1a5708; background-color:  #e0e0e0; padding: 5px; width: 195mm;}
            .titulo-base { font-size: 10px; padding: 0px 5px 0px 12px; color: #666666; width: 192mm; text-align: justify;}
            .titulo-rpta { font-size: 9px; padding: 8px 5px 0 5px; width: 195mm;}            
            .titulo-rg { width: 195mm; font-size: 12px; font-weight: bold; text-align: left; color: blue;}            
            .texto { font-size: 10px; padding: 5px; }
            .ninguno { color: black; padding: 5px; background-color: #ffcccc; font-size: 12px; width: 100mm;}
            .centro { text-align: center;}

            .vsi, .vno {
                color: green; 
                padding: 2px;                 
                font-weight: bolder; 
            }

            .vno { color: red; }

            .vt { background-color: #cfe9f5; border-radius: 5px; font-size: 10px;  }
            .vc { border-radius: 5px; font-size: 10px; }

            .lsi { background-color:#1ABC9C; color:black; padding:2px;}
            .lno { background-color:#F5B7B1; color:black; padding:2px;}
            .ambt { background-color: #f9fc48; padding: 1px; color: blue; font-weight: bolder;}

            .cuadrado1 {  width: 30px; height: 10px; background: black; }
            .cuadrado2 { width: 30px; height: 10px; background: #9b59b6; }
            .cuadrado3 { width: 30px; height: 10px; background: #f39c12; }
            .cuadrado4 { width: 30px; height: 10px; background: #e74c3c; }
            .humasoft { color: blue; text-align: center;}

        </style>
    </head>
    <body>
        <div class="pagina">

            <div class="titulo">HUMA SOFT - REPORTE GERENCIAL SEMANAL<br/><br/></div>
            <div class="humasoft"><?php echo $finicio . ' to ' . $ffin; ?><br/><br/></div>                
            <!--Inicio de Visitas Técnicas-->            
            <div class="divtitulo_reptecnico">
                VISITAS TÉCNICAS Y COMERCIALES
            </div> 
            <br/>            
            <div class="texto" style="color: blue;">Leyendas:</div>                        
            <table style="width: 150mm; font-size: 8px;">
                <tbody>
                    <tr>
                        <td style="width: 100mm;">                                                                
                            <table style="width: 100mm; font-size: 7px;">
                                <tbody>
                                    <tr>
                                        <td colspan="4">TIPO DE VISITA</td>                                        
                                    </tr>                                        
                                    <tr>
                                        <td style="width: 10mm;">VTSI</td>
                                        <td style="width: 60mm;">VISITA TÉCNICA ATENDIDA</td>
                                        <td style="width: 10mm;">VCSI</td>
                                        <td style="width: 60mm;">VISITA COMERCIAL ATENDIDA</td>
                                    </tr>                                        
                                    <tr>
                                        <td>VTNO</td>
                                        <td>VISITA TÉCNICA NO ATENDIDA</td>
                                        <td>VCNO</td>
                                        <td>VISITA COMERCIAL NO ATENDIDA</td>
                                    </tr>
                                    <tr>
                                        <td>LTSI</td>
                                        <td>LLAMADA TÉCNICA ATENDIDA</td>
                                        <td>LCSI</td>
                                        <td>LLAMADA COMERCIAL ATENDIDA</td>
                                    </tr>
                                    <tr>
                                        <td>LTNO</td>
                                        <td>LLAMADA TÉCNICA NO ATENDIDA</td>
                                        <td>LCNO</td>
                                        <td>LLAMADA COMERCIAL NO ATENDIDA</td>
                                    </tr>
                                    <tr>
                                        <td style="color: blue;">AMBT</td>
                                        <td>ACTIVIDADES APOYO A OFICINA</td>                                        
                                        <td></td>
                                        <td></td>
                                    </tr>

                                </tbody>                                    
                            </table>
                        </td>
                        <td style="width: 50mm;">
                            <table style="width: 50mm; font-size: 7px;">
                                <tbody>
                                    <tr>
                                        <td colspan="2">COLOR DE VISITA</td>

                                    </tr>                                        
                                    <tr>
                                        <td style="width: 10mm;"><div class="cuadrado1"></div></td>
                                        <td style="width: 10mm; ">0 dias de atraso</td>
                                    </tr>
                                    <tr>
                                        <td><div class="cuadrado2"></div></td>
                                        <td>1 dia de atraso</td>
                                    </tr>
                                    <tr>
                                        <td><div class="cuadrado3"></div></td>
                                        <td>2 dias de atraso</td>
                                    </tr>
                                    <tr>
                                        <td><div class="cuadrado4"></div></td>
                                        <td>3 dias o más de atraso</td>
                                    </tr>                                                                                    
                                </tbody>                                    
                            </table>
                        </td>
                    </tr>                                            
                </tbody>
            </table>
            <br/>

            <?php
            //Arreglo de Visitas Tecnicas            
            $rangodias = $objtec->arrayDias($desde, $hasta);
            $array_semana = array();

            foreach ($rangodias as $d) {
                $dia = $objtec->getDiasEspanhol($d);
                array_push($array_semana, $dia);
            }

            //llenar mi nuevo arreay
            $array_vtec_new = array();
            $array_vcom_new = array();

            $array_vtec_asesores = $objtec->mostrarAsesoresVT();
            $array_vcom_asesores = $objtec->mostrarAsesoresVC();

            //POBLAR ARREGLO PARA TARDANZAS DE REP TECNICOS
            foreach ($array_vtec_asesores as $asesores) {
                $coduse = trim($asesores['coduse']);
                foreach ($array_semana as $key => $dia) {
                    array_push($array_vtec_new, array('coduse' => $coduse, 'dia' => $dia, 'T' => 0, 'P' => 0));
                }
            }

            //POBLAR ARREGLO PARA TARDANZAS DE REP COMERCIALES
            foreach ($array_vcom_asesores as $asesores) {
                $coduse = trim($asesores['coduse']);
                foreach ($array_semana as $key => $dia) {
                    array_push($array_vcom_new, array('coduse' => $coduse, 'dia' => $dia, 'T' => 0, 'P' => 0));
                }
            }

            //POBLAR ARRAY PARA RESUMEN GENERAL DE REP TECNICO
            foreach ($array_vtec_asesores as $valor) {
                array_push($array_resvt, array('coduse' => $valor['coduse'], 'asesor' => $valor['desuse'], 'VTSI' => 0, 'VTNO' => 0, 'LTSI' => 0, 'LTNO' => 0));
            }

            //POBLAR ARRAY PARA RESUMEN GENERAL DE REP COMERCIAL
            foreach ($array_vcom_asesores as $valor) {
                array_push($array_resvc, array('coduse' => $valor['coduse'], 'asesor' => $valor['desuse'], 'VCSI' => 0, 'VCNO' => 0, 'LCSI' => 0, 'LCNO' => 0));
            }

            if (count($rangodias) > 0) {
                foreach ($rangodias as $dia) {
                    ?>
                    <div class="divdia"><?php echo date('l, d/M/Y', strtotime($dia)); ?></div><br/>                      
                    <?php
                    //recorrer visitas por dia
                    $visitasxsem = $obj->getVisitasXSemana($dia);

                    $dia_atraso = date('Y/m/d', strtotime($dia));
                    $dia_atraso1 = date('Y/m/d', strtotime($dia . '+1 day'));
                    $dia_atraso2 = date('Y/m/d', strtotime($dia . '+2 day'));
                    $dia_atraso3 = date('Y/m/d', strtotime($dia . '+3 day'));
                    $dia_atraso4 = date('Y/m/d', strtotime($dia . '+4 day'));

                    if (count($visitasxsem) > 0) {


                        foreach ($visitasxsem as $visxdia) {
                            $codrep = $visxdia['codigo'];
                            $tipovisitaxdia = $visxdia['tipo'];
                            $visita = array();
                            /* echo '<pre>';
                              print_r($visxdia);
                              echo '</pre>';
                             */
                            //SI LA VISITA ES TECNICA O COMERCIAL
                            if ($tipovisitaxdia == '1' || $tipovisitaxdia == '2') {
                                $visita = $obj->mostrarVisitasxCodRep($codrep);

                                $tiporeporte = $visita[15]; //tipo
                                $tipovisita = $obj->getTipoVisita($visita[6], $tiporeporte); //atendido
                                //Si el tiporeporte es TECNICO
                                if ($tiporeporte == 1) {

                                    $indice = array_search($visita[12], array_column($array_resvt, 'coduse'), false);
                                    $nvisita = $array_resvt[$indice][$tipovisita];
                                    $nvisita++;
                                    $array_resvt[$indice][$tipovisita] = $nvisita;
                                } elseif ($tiporeporte == 2) {
                                    //Si el tiporeporte es COMERCIAL

                                    $indice = array_search($visita[12], array_column($array_resvc, 'coduse'), false);
                                    $nvisita = $array_resvc[$indice][$tipovisita];


                                    $nvisita++;
                                    $array_resvc[$indice][$tipovisita] = $nvisita;
                                }

                                $horainicio = date("H:i", strtotime($visita[8]));
                                $horafin = date("H:i", strtotime($visita[9]));
                                $fechavisita = date("Y/m/d", strtotime($visita[1]));

                                $tv = 'vno';  //colorir el tipo de visita.
                                if ($visita[6] == 1 || $visita[6] == 2) {
                                    $tv = 'vsi';
                                }


                                $cliente = $visita[4];
                                if (trim($visita[4]) == '20478013206') {
                                    $cliente = '<span style="color:blue">' . $visita[4] . '</span>';
                                }

                                if ($visita[15] == 1) {
                                    $url = '<a target="_blank" href="http://humagroperu.ddns.net:8070/humasoft/site/_reptecnicov2_verweb.php?cod=' . $visita[0] . '">' . $visita[0] . '</a>';
                                    $tipocultivo = $visita[13];
                                    $tr = 'vt'; //tipo de reporte
                                } elseif ($visita[15] == 2) {
                                    $url = '<a target="_blank" href="http://humagroperu.ddns.net:8070/humasoft/site/_repcomercialv2_verweb.php?cod=' . $visita[0] . '">' . $visita[0] . '</a>';
                                    $tipocultivo = $visita[11];
                                    $tr = 'vc'; //tipo de reporte
                                }

                                $mostrarfecha = date("d/m/Y", strtotime($visita[1]));


                                if ($fechavisita == $dia_atraso) {
                                    $print = '<strong> ' . strtoupper($visita[3]) . '</strong>, ' . $horainicio . '-' . $horafin . ', <strong><span class="' . $tv . ' ' . $tr . '">' . $tipovisita . '</span>, ' . $cliente . '/' . $visita[10] . '</strong>, <strong>' . $visita[5] . '</strong>, ' . $tipocultivo . ', ' . $url;
                                } elseif ($fechavisita == $dia_atraso1) {
                                    $print = '<span style="color:#9b59b6">Fec. Visita: ' . $mostrarfecha . ', <strong>' . strtoupper($visita[3]) . '</strong>, ' . $horainicio . '-' . $horafin . ', <strong><span class="' . $tv . ' ' . $tr . '">' . $tipovisita . '</span>, ' . $cliente . '/' . $visita[10] . '</strong>, <strong>' . $visita[5] . '</strong>, ' . $tipocultivo . ', ' . $url . '</span>';
                                } elseif ($fechavisita == $dia_atraso2) {
                                    $print = '<span style="color:#f39c12">Fec. Visita: ' . $mostrarfecha . ', <strong>' . strtoupper($visita[3]) . '</strong>, ' . $horainicio . '-' . $horafin . ', <strong><span class="' . $tv . ' ' . $tr . '">' . $tipovisita . '</span>, ' . $cliente . '/' . $visita[10] . '</strong>, <strong>' . $visita[5] . '</strong>, ' . $tipocultivo . ', ' . $url . '</span>';
                                } elseif ($fechavisita <= $dia_atraso3) {
                                    $print = '<span style="color:#e74c3c">Fec. Visita: ' . $mostrarfecha . ', <strong>' . strtoupper($visita[3]) . '</strong>, ' . $horainicio . '-' . $horafin . ', <strong><span class="' . $tv . ' ' . $tr . '">' . $tipovisita . '</span>, ' . $cliente . '/' . $visita[10] . '</strong>, <strong>' . $visita[5] . '</strong>, ' . $tipocultivo . ', ' . $url . '</span>';
                                }
                                ?>
                                <div class="titulo-rpta"><?php echo $print; ?></div>
                                <?php if (!empty($visita[16])) { ?>
                                    <div class="titulo-base"><strong>- Nota al cliente: </strong><?php echo $visita[16]; ?></div>
                                    <?php
                                }
                                //Obtener comentarios de esta visita
                                $obj->__set('codrep', $visita[0]);

                                $comentarios = $obj->obtRespuestasHumarepTecnico();
                                $ncoment = count($comentarios);
                                if ($ncoment > 0) {


                                    if ($ncoment == 1) {    //Si solo tiene un registro, entonces es observacion          
                                        $visitaAnt = strlen($comentarios[0]['respuesta']);
                                        if ($visitaAnt <= 200) {
                                            $texto1 = $comentarios[0]['respuesta'];
                                        } else {
                                            $texto1 = substr($comentarios[0]['respuesta'], 0, 200) . '[...]';
                                        }
                                        ?>
                                        <div class="titulo-base"><strong>- Observaciones:</strong> <?php echo $texto1; ?> </div>

                                        <?php
                                    } else {
                                        $visitaAnt = strlen($comentarios[0]['respuesta']);
                                        $visitaEsta = strlen($comentarios[1]['respuesta']);
                                        $visitaNota = strlen($comentarios[2]['respuesta']);

                                        $texto1 = '';
                                        $texto2 = '';
                                        $texto3 = '';

                                        if ($visitaAnt <= 200) {
                                            $texto1 = $comentarios[0]['respuesta'];
                                        } else {
                                            $texto1 = substr($comentarios[0]['respuesta'], 0, 200) . '[...]';
                                        }
                                        if ($visitaEsta <= 200) {
                                            $texto2 = $comentarios[1]['respuesta'];
                                        } else {
                                            $texto2 = substr($comentarios[1]['respuesta'], 0, 200) . '[...]';
                                        }
                                        if ($visitaNota <= 200) {
                                            $texto3 = $comentarios[2]['respuesta'];
                                        } else {
                                            $texto3 = substr($comentarios[2]['respuesta'], 0, 200) . '[...]';
                                        }
                                        ?>
                                        <div class="titulo-base"><strong>- Visita Ant.:</strong> <?php echo $texto1; ?> </div>
                                        <div class="titulo-base"><strong>- Esta Visita:</strong> <?php echo $texto2; ?> </div>
                                        <div class="titulo-base"><strong>- Notas:</strong> <?php echo $texto3; ?> </div>
                                        <?php
                                    }
                                    ?>
                                    <br/>
                                    <?php
                                }

                                //Algo mas simple para la suma de puntuales y tardanzas.                            
                                $fecvisita = date("Y/m/d", strtotime($visita[1]));
                                $nndia = $objtec->getDiasEspanhol($dia);
                                $nncoduse = trim($visita[12]);

                                if ($tipovisitaxdia == '1') {

                                    for ($i = 0; $i < count($array_vtec_new); $i++) {

                                        if ($nndia == $array_vtec_new[$i]['dia'] && $nncoduse == $array_vtec_new[$i]['coduse']) {
                                            if ($fechavisita > $fecvisita) {
                                                $tarde = $array_vtec_new[$i]['T'];
                                                $tarde++;
                                                $array_vtec_new[$i]['T'] = $tarde;
                                            } else {
                                                $tarde = $array_vtec_new[$i]['P'];
                                                $tarde++;
                                                $array_vtec_new[$i]['P'] = $tarde;
                                            }
                                        }
                                    }
                                }
                                if ($tipovisitaxdia == '2') {

                                    //Algo mas simple para la suma de puntuales y tardanzas.                                                        
                                    for ($i = 0; $i < count($array_vcom_new); $i++) {

                                        if ($nndia == $array_vcom_new[$i]['dia'] && $nncoduse == $array_vcom_new[$i]['coduse']) {
                                            if ($fechavisita > $fecvisita) {
                                                $tarde = $array_vcom_new[$i]['T'];
                                                $tarde++;
                                                $array_vcom_new[$i]['T'] = $tarde;
                                            } else {
                                                $tarde = $array_vcom_new[$i]['P'];
                                                $tarde++;
                                                $array_vcom_new[$i]['P'] = $tarde;
                                            }
                                        }
                                    }
                                }


                                // SI LA VISITA ES TIPO ACTIVIDAD
                            } elseif ($tipovisitaxdia == '3') {

                                $visita = $obj->mostrarActividadesxCodRep($codrep);

                                $fechavisita = date("Y/m/d", strtotime($visita[5]));
                                $horainicio = date("H:i", strtotime($visita[6]));
                                $horafin = date("H:i", strtotime($visita[7]));

                                $url = '<a target="_blank" href="http://humagroperu.ddns.net:8070/humasoft/site/_actividad_verweb.php?cod=' . $visita[0] . '">' . $visita[0] . '</a>';


                                $mostrarfecha = date("d/m/Y", strtotime($visita[5]));

                                if ($fechavisita == $dia_atraso) {
                                    $print = '<strong>' . $visita[4] . '</strong>, ' . $horainicio . '-' . $horafin . ', <span class="ambt">AMBT</span> <strong>' . $visita[3] . '</strong>, <strong>' . $visita[10] . '</strong>, ' . $url;
                                } elseif ($fechavisita == $dia_atraso1) {
                                    $print = '<span style="color:#9b59b6">Fec. Actividad: ' . $mostrarfecha . ', <strong>' . $visita[4] . '</strong>, ' . $horainicio . '-' . $horafin . ', <span class="abmt">AMBT</span> <strong>' . $visita[3] . '</strong>, <strong>' . $visita[10] . '</strong>, ' . $url . '</span>';
                                } elseif ($fechavisita == $dia_atraso2) {
                                    $print = '<span style="color:#f39c12">Fec. Actividad: ' . $mostrarfecha . ', <strong>' . $visita[4] . '</strong>, ' . $horainicio . '-' . $horafin . ', <span class="abmt">AMBT</span> <strong>' . $visita[3] . '</strong>, <strong>' . $visita[10] . '</strong>, ' . $url . '</span>';
                                } elseif ($fechavisita <= $dia_atraso3) {
                                    $print = '<span style="color:#e74c3c">Fec. Actividad: ' . $mostrarfecha . ', <strong>' . $visita[4] . '</strong>, ' . $horainicio . '-' . $horafin . ', <span class="abmt">AMBT</span> <strong>' . $visita[3] . '</strong>, <strong>' . $visita[10] . '</strong>, ' . $url . '</span>';
                                }
                                ?>
                                <div class="titulo-rpta"><?php echo $print; ?></div>                                                            
                                <div class="titulo-base"><strong>- Observaciones:</strong> <?php echo $visita[8]; ?> </div>
                                <br/>
                                <?php
                            }
                        }
                    } else {
                        echo '<div style="color: red; font-size:9px;">No se registraron visitas esta fecha</div>';
                    }
                    ?>                            
                    <br/>                            
                    <?php
                }
            } else {
                echo '<div class="ninguno">No hay visitas técnicas registradas esta semana.</div>';
            }
            ?>
            <br/>
            <!--Fin de reporte tecnico dia-->                    

            <div class="divtitulo_reptecnico">
                SOLICITUD DE PROPUESTAS
            </div>                 
            <br/>

            <?php
            if (count($soldias) > 0) {
                foreach ($soldias as $dia) {
                    ?>

                    <div class="divdia"><?php echo date('l, d/M/Y', strtotime($dia['fecha'])); ?></div><br/>                           
                    <?php
                    //recorrer visitas por dia
                    $visitas = $obj->mostrarSolicitudPropxDia($dia['fecha']);
                    $i = 0;
                    if (count($visitas) > 0) {
                        foreach ($visitas as $solprop) {
                            $i++;
                            $print = '<strong>' . $solprop['asesor'] . '</strong>,<strong> ' . $solprop['cliente'] . '/' . $solprop['fundo'] . '</strong>,' . $solprop['cultivo'] . ', ' . $solprop['ha'] . 'ha., ' . $solprop['codsolicitud'];
                            ?>
                            <div class="titulo-rpta"><?php echo $i . '. ' . $print; ?></div>
                            <?php
                        }
                    } else {
                        echo '<div style="color: red; font-size:9px;">No se registraron solicitudes esta fecha.</div>';
                    }
                    ?>                            
                    <br/>                            
                    <?php
                }
            } else {
                echo '<div class="ninguno">No hay Solicitudes registradas esta semana.</div>';
            }
            ?>            
            <!--Fin de reporte por dias-->


            <!--Fin de Resumen General-->        

            <br/><br/>                        
            <!--Inicio de Propuestas Aprobadas-->                            
            <div class="divtitulo_reptecnico">PROPUESTAS ENVIADAS</div>
            <br/>
            <?php
            $vendedores_penv = array();
            foreach ($rangodias as $dia) {
                ?>                        
                <div class="divdia"><?php echo date('l, d/M/Y', strtotime($dia)); ?></div><br/>                           
                <?php
                //recorrer visitas por dia
                //recorrer visitas por dia
                $visitaspropaprob = $obj->mostrarPropEnviadasxDia($dia);
                if (count($visitaspropaprob) > 0) {
                    $i = 0;
                    foreach ($visitaspropaprob as $value) {
                        $i++;

                        $monto = '';
                        if ($value['moneda'] == '$') {
                            $monto = number_format($value['monto'], 2);
                            $monto = '<span style="color: blue; font-weight: bolder">' . $value['moneda'] . ' ' . $monto . '</span>';
                        } else {
                            $monto = number_format($value['monto'], 2);
                            $monto = '<span style="color: green; font-weight: bolder">' . $value['moneda'] . ' ' . $monto . '</span>';
                        }

                        $print = $value['codprop'] . ', <strong>' . $value['asesor'] . '</strong>,<strong> ' . $value['cliente'] . '</strong>, ' . $value['cultivo'] . ', ' . $value['ha'] . 'ha., ' . $value['descuento'] . '%, ' . $monto;
                        array_push($vendedores_penv, array('vendedor' => $value['asesor'], 'moneda' => $value['moneda'], 'monto' => $value['monto']));
                        ?>
                        <div class="titulo-rpta"><?php echo $i . '. ' . $print; ?></div>
                        <?php
                    }
                } else {
                    echo '<div style="color: red; font-size:9px;">No se enviaron propuestas esta fecha.</div>';
                }
                echo '<br/>';
            }
            ?>                            
            <!--Fin de reporte por dias-->
            <br/><br/>                        
            <!--Inicio de Propuestas Aprobadas-->                            
            <div class="divtitulo_reptecnico">PROPUESTAS APROBADAS</div>                 
            <br/>
            <?php
            $vendedores_paprob = array();
            foreach ($rangodias as $dia) {
                ?>                        
                <div class="divdia"><?php echo date('l, d/M/Y', strtotime($dia)); ?></div><br/>                           
                <?php
                //recorrer visitas por dia
                //recorrer visitas por dia
                $visitaspropaprob = $obj->mostrarPropAprobxDia($dia);
                if (count($visitaspropaprob) > 0) {
                    $i = 0;
                    foreach ($visitaspropaprob as $value) {
                        $i++;

                        $monto = '';
                        if ($value['moneda'] == '$') {
                            $monto = number_format($value['monto'], 2);
                            $monto = '<span style="color: blue; font-weight: bolder">' . $value['moneda'] . ' ' . $monto . '</span>';
                        } else {
                            $monto = number_format($value['monto'], 2);
                            $monto = '<span style="color: green; font-weight: bolder">' . $value['moneda'] . ' ' . $monto . '</span>';
                        }

                        $print = $value['codprop'] . ', <strong>' . $value['asesor'] . '</strong>,<strong> ' . $value['cliente'] . '</strong>, ' . $value['cultivo'] . ', ' . $value['ha'] . 'ha., ' . $value['descuento'] . '%, ' . $monto;
                        array_push($vendedores_paprob, array('vendedor' => $value['asesor'], 'moneda' => $value['moneda'], 'monto' => $value['monto']));
                        ?>
                        <div class="titulo-rpta"><?php echo $i . '. ' . $print; ?></div>
                        <?php
                    }
                } else {
                    echo '<div style="color: red; font-size:9px;">No se aprobaron propuestas este día.</div>';
                }
                echo '<br/>';
            }
            ?>                                                            
            <br/>
            <br/>
            <br/>
            <br/>
            <!-- ********************************************************************************************************** -->   
            <!-- INICIO DE LOS RESUMENES GENERALES -->   
            <div class="divtitulo_resumen">RESUMEN GENERAL SEMANAL</div>
            <br/>
            <br/>

            <!-- INICIO VISITAS TECNICAS -->   
            <div class="titulo-rg">
                RESUMEN GENERAL VISITAS TÉCNICAS Y COMERCIALES
            </div>
            <p style="font-size: 10px">Visitas Técnicas detalladas por día.</p>
            <table style="width: 140mm; font-size: 9px; border: 1px #6666ff groove;">
                <thead>
                    <tr style="background-color: #dadada;">
                        <th></th>
                        <?php foreach ($array_semana as $dias) { ?>
                            <th colspan="2"><?php echo $dias ?></th>
                        <?php } ?>                            
                        <th style="" colspan="3">TOTAL VISITAS</th>
                    </tr>
                    <tr style="background-color: #dadada;">
                        <th>ASESORES</th>
                        <?php foreach ($array_semana as $dias) { ?>
                            <th>P</th>
                            <th>T</th>
                        <?php } ?>    
                        <th>P</th>
                        <th>T</th>
                        <th>-</th>
                    </tr>
                </thead>     
                <tbody>
                    <?php foreach ($array_vtec_asesores as $asesores) { ?>
                        <tr>
                            <td><?php echo trim($asesores['desuse']); ?></td>
                            <?php
                            $totalvisitas;
                            $totalp = 0;
                            $totalt = 0;
                            foreach ($array_vtec_new as $vtec) {
                                if (trim($asesores['coduse']) == $vtec['coduse']) {
                                    ?>
                                    <td style="text-align: center; "><?php echo $vtec['P']; ?></td>
                                    <td style="text-align: center;"><?php echo $vtec['T']; ?></td>
                                    <?php
                                    $totalp+= $vtec['P'];
                                    $totalt+= $vtec['T'];
                                }
                            }
                            $totalvisitas = $totalp + $totalt;
                            ?>  
                            <td style="text-align: center; font-weight: bolder; color: blue; "><?php echo $totalp; ?></td>
                            <td style="text-align: center; font-weight: bolder; color: red; "><?php echo $totalt; ?></td>
                            <td style="text-align: center; font-weight: bolder; "><?php echo $totalvisitas; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <br/>

            <p style="font-size: 10px">Resumen por Tipos de Visitas Técnicas.</p>
            <table style="width: 140mm; font-size: 9px; border: 1px #6666ff groove;">
                <thead>
                    <tr style="background-color: #dadada">
                        <th colspan="5">CANTIDAD DE VISITAS TÉCNICAS POR ASESOR</th>
                        <th colspan="3">TOTAL VISITAS</th>
                    </tr>
                    <tr style="background-color: #eeeeee">                        
                        <th>ASESORES</th>
                        <th class="vsi">VTSI</th>
                        <th class="vno">VTNO</th>
                        <th class="lsi">LTSI</th>
                        <th class="lno">LTNO</th>
                        <th>SI</th>                                
                        <th>NO</th>                                
                        <th>TOTAL</th>                                
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($array_resvt) > 0) {
                        foreach ($array_resvt AS $valor) {
                            $totalsi = ($valor['VTSI'] + $valor['LTSI']);
                            $totalno = ($valor['VTNO'] + $valor['LTNO']);
                            $totalvisitas = ($valor['VTSI'] + $valor['VTNO'] + $valor['LTSI'] + $valor['LTNO']);
                            $estilo = '';
                            if ($totalvisitas == 0) {
                                $estilo = 'style="color: red;"';
                            }
                            ?>
                            <tr>                                
                                <td <?php echo $estilo ?>><?php echo $valor['asesor']; ?></td>
                                <td class="centro" style="color: green"><?php echo $valor['VTSI']; ?></td>
                                <td class="centro" style="color: red"><?php echo $valor['VTNO']; ?></td>                                
                                <td class="centro" style="color: green"><?php echo $valor['LTSI']; ?></td>
                                <td class="centro" style="color: red"><?php echo $valor['LTNO']; ?></td>                                
                                <td class="centro"><?php echo $totalsi; ?></td>
                                <td class="centro"><?php echo $totalno; ?></td>
                                <td class="centro"><?php echo $totalvisitas; ?></td>                                
                            </tr>    <?php
                        }
                    }
                    ?>  
                </tbody>
            </table>                        
            <!-- FIN VISITAS TECNICAS -->   
            <br/>
            <!-- INICIO VISITAS COMERCIALES -->   
            <div class="titulo-rg">
                RESUMEN GENERAL VISITAS COMERCIALES
            </div>  
            <p style="font-size: 10px">Visitas Comerciales detalladas por día.</p>
            <table style="width: 140mm; font-size: 9px; border: 1px #6666ff groove;">
                <thead>
                    <tr style="background-color: #dadada;">
                        <th></th>
                        <?php foreach ($array_semana as $dias) { ?>
                            <th colspan="2"><?php echo $dias ?></th>
                        <?php } ?>                            
                        <th colspan="3">TOTAL VISITAS</th>
                    </tr>
                    <tr style="background-color: #dadada;">
                        <th>ASESORES</th>
                        <?php foreach ($array_semana as $dias) { ?>
                            <th>P</th>
                            <th>T</th>
                        <?php } ?>                            
                        <th>P</th>
                        <th>T</th>
                        <th>-</th>
                    </tr>
                </thead>     
                <tbody>
                    <?php foreach ($array_vcom_asesores as $asesores) { ?>
                        <tr>
                            <td><?php echo trim($asesores['desuse']); ?></td>
                            <?php
                            $totalvisitas;
                            $totalp = 0;
                            $totalt = 0;
                            foreach ($array_vcom_new as $vcom) {
                                if (trim($asesores['coduse']) == $vcom['coduse']) {
                                    ?>
                                    <td style="text-align: center; "><?php echo $vcom['P']; ?></td>
                                    <td style="text-align: center;"><?php echo $vcom['T']; ?></td>
                                    <?php
                                    $totalp+= $vcom['P'];
                                    $totalt+= $vcom['T'];
                                }
                            }
                            $totalvisitas = $totalp + $totalt;
                            ?>  
                            <td style="text-align: center; font-weight: bolder; color: blue; "><?php echo $totalp; ?></td>
                            <td style="text-align: center; font-weight: bolder; color: red; "><?php echo $totalt; ?></td>
                            <td style="text-align: center; font-weight: bolder; "><?php echo $totalvisitas; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>                                
            <p style="font-size: 10px">Resumen por Tipos de Visitas Comerciales.</p>
            <table style="width: 140mm; font-size: 9px; border: 1px #6666ff groove;">
                <thead>
                    <tr style="background-color: #dadada">
                        <th colspan="5">CANTIDAD DE VISITAS COMERCIALES POR ASESOR</th>
                        <th colspan="3">TOTAL VISITAS</th>
                    </tr>
                    <tr style="background-color: #eeeeee">                        
                        <th>ASESORES</th>
                        <th class="vsi">VCSI</th>
                        <th class="vno">VCNO</th>
                        <th class="lsi">LCSI</th>
                        <th class="lno">LCNO</th>
                        <th class="">SI</th>
                        <th class="">NO</th>
                        <th>TOTAL</th>                            
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($array_resvc) > 0) {
                        foreach ($array_resvc AS $valor) {

                            $totalsi = ($valor['VCSI'] + $valor['LCSI']);
                            $totalno = ($valor['VCNO'] + $valor['LCNO']);
                            $totalvisitas = ($valor['VCSI'] + $valor['VCNO'] + $valor['LCSI'] + $valor['LCNO']);
                            $estilo = '';
                            if ($totalvisitas == 0) {
                                $estilo = 'style="color: red;"';
                            }
                            ?>
                            <tr>                                
                                <td <?php echo $estilo ?>><?php echo $valor['asesor']; ?></td>
                                <td class="centro" style="color: green"><?php echo $valor['VCSI']; ?></td>
                                <td class="centro" style="color: red"><?php echo $valor['VCNO']; ?></td>                                
                                <td class="centro" style="color: green"><?php echo $valor['LCSI']; ?></td>
                                <td class="centro" style="color: red"><?php echo $valor['LCNO']; ?></td>                                
                                <td class="centro"><?php echo $totalsi; ?></td>
                                <td class="centro"><?php echo $totalno; ?></td>
                                <td class="centro"><?php echo $totalvisitas; ?></td>                                
                            </tr>    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>   



            <!-- FIN VISITAS COMERCIALES -->   




            <!--INICIO DE SOLICITUD DE PROPUESTAS-->                
            <?php
            $asesorsolp = $obj->mostrarAsesoresxSemana_SolProp($desde, $hasta);
            if (count($asesorsolp) > 0) {
                ?>

                <div class="titulo-rg">RESUMEN GENERAL SOLICITUD DE PROPUESTAS</div>                
                <table style="width: 140mm; font-size: 9px; border: 1px #6666ff groove;">
                    <thead>
                        <tr style="background-color: #dadada">
                            <th colspan="3">CANTIDAD DE SOLICITUD DE PROPUESTAS POR ASESOR</th>
                        </tr>
                        <tr style="background-color: #eeeeee">
                            <th></th>
                            <th>ASESORES</th>                                        
                            <th>TOTAL</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        foreach ($asesorsolp AS $valor) {
                            $i++;
                            $coduse = $valor['coduse'];
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo strtoupper($valor['desuse']); ?></td>                                                                                                                                            
                                <td class="centro"><?php echo $valor['cantidad'] ?></td>                                    
                            </tr>    
                        <?php } ?>
                    </tbody>
                </table>  
            <?php } ?>
            <!--FIN DE SOLICITUD DE PROPUESTAS-->
            <br/>

            <!--Inicio PROPUESTAS ENVIADAS-->
            <div class="titulo-rg">RESUMEN GENERAL DE PROPUESTAS ENVIADAS</div>                
            <table style="width: 140mm; font-size: 9px; border: 1px #6666ff groove;">
                <thead>
                    <tr style="background-color: #dadada">
                        <th colspan="5">CANTIDAD DE PROPUESTAS ENVIADAS POR VENDEDOR</th>
                    </tr>
                    <tr style="background-color: #eeeeee">
                        <th></th>
                        <th>VENDEDORES</th>                                                                    
                        <th>TOTAL SOLES</th>
                        <th>TOTAL DOLARES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $nombres = array_column($listavendedores, 'desuse');
                    $nombresunique = array_unique($nombres);
                    $valnombres = array_values($nombresunique);

                    $arregloficho = array();
                    foreach ($valnombres as $vendedor) {
                        $vendedor;
                        $montosol = 0;
                        $montodol = 0;
                        foreach ($vendedores_penv as $value) {
                            if ($vendedor == $value['vendedor']) {
                                if ($value['moneda'] == '$') {
                                    $montodol+=$value['monto'];
                                } else {
                                    $montosol+=$value['monto'];
                                }
                            }
                        }
                        array_push($arregloficho, array('vendedor' => $vendedor, 'montosol' => $montosol, 'montodol' => $montodol));
                    }
                    $i = 0;
                    $montosol_total = 0;
                    $montodol_total = 0;
                    foreach ($arregloficho as $value) {
                        $i++;
                        $montosol_total += $value['montosol'];
                        $montodol_total += $value['montodol'];
                        if ($value['montosol'] == 0 && $value['montodol'] == 0) {
                            $estilo = 'color: red;';
                        } else {
                            $estilo = 'color: black;';
                        }
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><span style="<?php echo $estilo; ?>"><?php echo $value['vendedor']; ?></span></td>
                            <td style="text-align: right;">S/. <?php echo number_format($value['montosol'], 2); ?></td>
                            <td style="text-align: right; color: blue;">$ <?php echo number_format($value['montodol'], 2); ?></td>            
                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <td></td>
                        <td>MONTO TOTAL SEMANAL</td>
                        <td style="text-align: right;"><strong>S/. <?php echo number_format($montosol_total, 2); ?></strong></td>            
                        <td style="text-align: right; color: blue;"><strong>$ <?php echo number_format($montodol_total, 2); ?></strong></td>                        
                    </tr> 
                </tbody>
            </table>                           
            <!-- FIN DE PROPUESTAS ENVIADAS -->                 
            <br/>                             

            <!-- INICIO PROPUESTAS APROBADAS -->
            <div class="titulo-rg">PROPUESTAS APROBADAS </div>
            <table style="width: 140mm; font-size: 9px; border: 1px #6666ff groove;">
                <thead>
                    <tr style="background-color: #dadada">
                        <th colspan="5">CANTIDAD DE PROPUESTAS APROBADAS POR VENDEDOR</th>
                    </tr>
                    <tr style="background-color: #eeeeee">
                        <th></th>
                        <th>VENDEDORES</th>                                                                    
                        <th>TOTAL SOLES</th>
                        <th>TOTAL DOLARES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $nombres = array_column($listavendedores, 'desuse');
                    $nombresunique = array_unique($nombres);
                    $valnombres = array_values($nombresunique);

                    $arregloficho = array();
                    foreach ($valnombres as $vendedor) {
                        $vendedor;
                        $montosol = 0;
                        $montodol = 0;
                        foreach ($vendedores_paprob as $value) {
                            if ($vendedor == $value['vendedor']) {
                                if ($value['moneda'] == '$') {
                                    $montodol+=$value['monto'];
                                } else {
                                    $montosol+=$value['monto'];
                                }
                            }
                        }
                        array_push($arregloficho, array('vendedor' => $vendedor, 'montosol' => $montosol, 'montodol' => $montodol));
                    }
                    $i = 0;
                    $montosol_total = 0;
                    $montodol_total = 0;
                    foreach ($arregloficho as $value) {
                        $i++;
                        $montosol_total += $value['montosol'];
                        $montodol_total += $value['montodol'];
                        if ($value['montosol'] == 0 && $value['montodol'] == 0) {
                            $estilo = 'color: red;';
                        } else {
                            $estilo = 'color: black;';
                        }
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><span style="<?php echo $estilo; ?>"><?php echo $value['vendedor']; ?></span></td>
                            <td style="text-align: right;">S/. <?php echo number_format($value['montosol'], 2); ?></td>
                            <td style="text-align: right; color: blue;">$ <?php echo number_format($value['montodol'], 2); ?></td>            
                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <td></td>
                        <td>MONTO TOTAL SEMANAL</td>
                        <td style="text-align: right;"><strong>S/. <?php echo number_format($montosol_total, 2); ?></strong></td>            
                        <td style="text-align: right; color: blue;"><strong>$ <?php echo number_format($montodol_total, 2); ?></strong></td>                        
                    </tr> 
                </tbody>
            </table>
            <br/>
            <div class="titulo-rg">CANTIDAD Y MONTO DE PROPUESTAS APROBADAS</div>
            <br/>
            

            <!-- FIN DE PROPUESTAS APROBADAS-->

            <!-- INICIO DE PROPUESTAS APROBADAS POR PERIODO -->
            <?php
            $mes_inicio = 1; //recorrido
            //$fecha_reporte = date('Y-m-d');
            $mes_fin = date('n');
            //$mes_fin = '6';
            $ano = date('Y');

            if ($mes_fin > 3) {
                $mes_inicio = ($mes_fin-2);
            }
            

            while ($mes_inicio <= $mes_fin) {
                $mes = $mes_inicio;                
                $listaventas = $obj->getPropAprobDolarByMes($ano, $mes);          
                $nom_mes = $obj->getMes($mes_inicio);
                ?>
                <table style="width: 100mm; font-size: 9px; border: 1px #6666ff groove;">
                    <thead style="border: 1px #6666ff groove;" >
                        <tr>
                            <th colspan="4"><?php echo 'MES ' . $nom_mes; ?></th>
                            <th colspan="2"><?php echo 'AÑO ' . $ano; ?></th>
                        </tr>
                        <tr>
                            <th></th>
                            <th style="width: 30mm;">Representante</th>
                            <th>Cantidad</th>
                            <th>Monto</th>
                            <th>Cantidad</th>
                            <th>Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $corredor = 1;
                        foreach ($listaventas as $ventas) {
                            $listaventas2 = $obj->getPropAprobDolarByAsesorByAno($ano, $ventas['asesor']);
                            ?>
                            <tr>
                                <td style="text-align: center;"><?php echo $corredor; ?></td>
                                <td ><?php echo $ventas['desuse']; ?></td>
                                <td style="text-align: center;"><?php echo $ventas['cantidad']; ?></td>
                                <td style="text-align: right;">$<?php echo number_format($ventas['total'], 2); ?></td>
                                <td style="text-align: center;"><?php echo $listaventas2[1]; ?></td>
                                <td style="text-align: right;">$<?php echo number_format($listaventas2[2], 2); ?></td>
                            </tr>
                            <?php
                            $corredor++;
                        }
                        ?>
                    </tbody>
                </table>
                <br/><br/>
                <?php
                $mes_inicio++;
            }
            
            $listaventasxano = $obj->getPropAprobDolarByAno($ano);
            
            ?>
            <table style="width: 100mm; font-size: 9px; border: 1px #6666ff groove;">
                <thead>
                    <tr>                        
                        <th colspan="4"><?php echo 'ACUMULADO AÑO ' . $ano; ?></th>
                    </tr>
                    <tr>
                        <th></th>
                        <th style="width: 30mm;">Representante</th>
                        <th>Cantidad</th>
                        <th>Monto</th>                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $corredor = 1;
                    foreach ($listaventasxano as $ventas2) {                        
                        ?>
                        <tr>
                            <td style="text-align: center;"><?php echo $corredor; ?></td>
                            <td ><?php echo $ventas2['desuse']; ?></td>
                            <td style="text-align: center;"><?php echo $ventas2['cantidad']; ?></td>
                            <td style="text-align: right;">$<?php echo number_format($ventas2['total'], 2); ?></td>                            
                        </tr>
                        <?php
                        $corredor++;
                    }
                    ?>
                </tbody>
            </table>
            <!-- FIN DE LOS RESUMENES GENERALES -->   

        </div>
        <!--Fin de Pagina-->
    </body>
</html>