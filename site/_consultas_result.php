<?php
@session_start();
include_once '../controller/C_Reportes.php';
$obj = new C_Reportes();

//$obj->__set('coduse', $valor);
$nomasesor = '';
$periodo1 = '';
$periodo2 = '';
$tipo = '';
$asesor = '';
$nomasesor = '';

switch ($_GET['cod1']) {

    case 'QUERY01':
        $dias = '0 day';
        $mes = $_GET['cod2'];
        $ano = $_GET['cod3'];
        $asesor = $_GET['cod4'];
        $diasatraso = $_GET['cod5'];
        $tipo = $_GET['cod6'];
        switch ($diasatraso) {
            case '1': $dias = '-1 day';
                break;
            case '2': $dias = '-2 day';
                break;
            case '3': $dias = '-3 day';
                break;
        }
        $lista = $obj->consultar_query01($mes, $ano, $asesor, $dias);
        $periodo1 = $mes;
        $periodo2 = $ano;
        break;

    case 'QUERY02':
        //TIPO MES: TODOS
        $mes = $_GET['cod2'];
        $ano = $_GET['cod3'];
        $asesor = trim($_GET['cod4']);
        $tipo = $_GET['cod5'];
        $lista = $obj->consultar_query02($mes, $ano, $asesor);
        $periodo1 = $mes;
        $periodo2 = $ano;
        break;

    case 'QUERY03':
        $mes = $_GET['cod2'];
        $ano = $_GET['cod3'];
        $asesor = trim($_GET['cod4']);
        $tipo = $_GET['cod5'];
        $lista = $obj->consultar_query03($mes, $ano, $asesor);
        $periodo1 = $mes;
        $periodo2 = $ano;
        break;

    case 'QUERY04':
        //TIPO RANGO
        $dias = '0 day';
        $desde = $_GET['cod2'];
        $hasta = $_GET['cod3'];
        $getdatos_asesor = trim($_GET['cod4']);
        $datos_asesor = explode(',', $getdatos_asesor);                
        $asesor = $datos_asesor[0];
        $nomasesor = $datos_asesor[1];
        
        
        $diasatraso = trim($_GET['cod5']);
        $tipo = $_GET['cod6'];
        switch ($diasatraso) {
            case '1': $dias = '-1 day';
                break;
            case '2': $dias = '-2 day';
                break;
            case '3': $dias = '-3 day';
                break;
        }
        $lista = $obj->consultar_query04($desde, $hasta, $asesor, $dias);
        $periodo1 = date("Y-m-d", strtotime($desde));
        $periodo2 = date("Y-m-d", strtotime($hasta));
        //$periodo1 = date("d/m/Y", strtotime($desde));
        //$periodo2 = date("d/m/Y", strtotime($hasta));
        break;

    case 'QUERY05':
        $desde = $_GET['cod2'];
        $hasta = $_GET['cod3'];
        $getdatos_asesor = trim($_GET['cod4']);
        $datos_asesor = explode(',', $getdatos_asesor);                
        $asesor = $datos_asesor[0];
        $nomasesor = $datos_asesor[1];        
        $tipo = $_GET['cod5'];
        $lista = $obj->consultar_query05($desde, $hasta, $asesor);
        $periodo1 = date("Y-m-d", strtotime($desde));
        $periodo2 = date("Y-m-d", strtotime($hasta));
        //$periodo1 = date("d/m/Y", strtotime($desde));
        //$periodo2 = date("d/m/Y", strtotime($hasta));
        break;

    case 'QUERY06':
        $desde = $_GET['cod2'];
        $hasta = $_GET['cod3'];
        $getdatos_asesor = trim($_GET['cod4']);
        $datos_asesor = explode(',', $getdatos_asesor);                
        $asesor = $datos_asesor[0];
        $nomasesor = $datos_asesor[1];
        $tipo = $_GET['cod5'];
        $lista = $obj->consultar_query06($desde, $hasta, $asesor);
        $periodo1 = date("Y-m-d", strtotime($desde));
        $periodo2 = date("Y-m-d", strtotime($hasta));
        //$periodo2 = date("d/m/Y", strtotime($hasta));
        break;

    default:
        break;
}

function calcular($objeto, $indice, $num) {
    $cantidad = 0;
    foreach ($objeto as $value) {
        if ($value[$indice] == $num) {
            $cantidad++;
        }
    }
    return $cantidad;
}

function getDiasEspanhol($fecha) {
    $dias = array('Dias', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo');
    $dia = $dias[date('N', strtotime($fecha))];
    return $dia;
}

function getDiaCompleto($fecha) {
    $dia = getDiasEspanhol($fecha);
//    $getfecha = explode('/', $fecha);
//    $ano = $getfecha[0];
//    $mes = $getfecha[1];
//    $dia = $getfecha[2];
    $fechaesp = date('d/m/Y', strtotime($fecha));
    $diacompleto = $dia . ', ' . $fechaesp;
    return $diacompleto;
}

function arrayDias($desde, $hasta) {
    $fechas = array();
    while ($desde <= $hasta) {
        array_push($fechas, $desde);
        $desde = date('Y-m-d', strtotime($desde . '+1 day'));
    }
    return $fechas;
}

function listarFeriados2016($vardia) {
    $resultado = 'Si';
    $feriado = array(
        '01-01', // Año Nuevo (irrenunciable) 
        '24-03', // Jueves Santo (feriado religioso) 
        '25-03', // Viernes Santo (feriado religioso) 
        '26-03', // Sabado Gloria (feriado religioso) 
        '01-05', // Día Nacional del Trabajo (irrenunciable)         
        '29-06', // Dia de San Pedro y San Pablo
        '28-07', // Feriado de Fiestas Patrias
        '29-07', // Feriado de Fiestas Patrias
        '30-08', // Dia de Santa Rosa de Lima
        '08-10', // Combate de Angamos         
        '01-11', // Día de Todos los Santos (feriado religioso) 
        '08-12', // Inmaculada Concepción de la Virgen (feriado religioso)         
        '25-12' // Natividad del Señor (feriado religioso) (irrenunciable) 
    );

    $dia = date("d", strtotime($vardia));
    $mes = date("m", strtotime($vardia));
    $variable = $dia . '-' . $mes;

    if (in_array($variable, $feriado, true)) {
        
    } else {
        $resultado = 'No';
    }
    return $resultado;
}

$size_lista = count($lista);
?>
<style>
    div.centerTable{
        text-align: center;
    }



    div.centerTable table {
        margin: 0 auto;
        text-align: left;
    }
</style>
<div id = "cuerpo">
    <h4 style = "text-align: center;">Resultados de la Consulta</h4>
    <hr/>
    <div class="centerTable">
        <table class = "" border="1" style = "width: 210mm; font-size: 10px; "  >
            <thead>
                <tr style="background-color: #d35400; color: white; height: 30px; text-align: center; vertical-align: middle; font-size: 9px; ">
                    <th style="text-align: center">FECHA VISITA</th>
                    <th style="text-align: center">FECHA REGISTRO</th>
                    <th>CLIENTE</th>                    
                    <th>CODIGO</th>
                    <th  style="text-align: center">DIAS ATRASO</th>                
                </tr>
            </thead>
            <tbody>
                <?php
                $tecatraso_0 = 0;
                $tecatraso_1 = 0;
                $tecatraso_2 = 0;
                $tecatraso_3 = 0;
                $tecatraso_4 = 0;

                $comatraso_0 = 0;
                $comatraso_1 = 0;
                $comatraso_2 = 0;
                $comatraso_3 = 0;
                $comatraso_4 = 0;

                $ambtatraso_0 = 0;
                $ambtatraso_1 = 0;
                $ambtatraso_2 = 0;
                $ambtatraso_3 = 0;
                $ambtatraso_4 = 0;

                $dia_no_reg = 0;

                $obj->__set('coduse', $asesor);
                $user_query = $obj->cargarAsesoresxCoduse();
                $tipo_usuario = '';

                if ($user_query[3] == 'SI') {
                    $tipo_usuario = 'VT';
                }
                if ($user_query[4] == 'SI') {
                    $tipo_usuario = 'VC';
                }


                if ($tipo == 'Mes') {
                    echo '<p>Mes</p>';
                } elseif ($tipo == 'Rango') {

                    $dias_calendario = arrayDias($periodo1, $periodo2);

                    foreach ($dias_calendario as $dias) {
                        
                        //echo $dias.'<br/>';

                        $dia_espanhol = getDiaCompleto($dias);
                        $fechaquery = date("Y/m/d", strtotime($dias)); //consulta para todos los dias                                                                                                        
                        $cadenadia = explode(',', $dia_espanhol);
                        $nombre_dia = $cadenadia[0];
                        $es_feriado = listarFeriados2016($dias);

                        if ($nombre_dia == 'Domingo') {
                            ?>                            
                                    <!--                            <tr style="background-color: #cccccc">
                                                                    <td colspan="6"><?php //echo $dia_espanhol;    ?></td>
                                                                </tr>  
                                                                <tr>
                                                                    <td colspan="6" style="color:red;">Dia no Laborable</td>
                                                                </tr>                            -->
                            <?php
                        } elseif ($es_feriado == 'Si') {
                            ?>                            
                                    <!--                            <tr style="background-color: #cccccc">
                                                                    <td colspan="6"></td>
                                                                </tr>  -->
                            <tr>
                                <td><?php echo $dia_espanhol; ?></td>
                                <td></td>
                                <td style="color:red;">Dia no Laborable. Feriado</td>
                                <td></td>
                                <td></td>
                            </tr>                            
                            <?php
                        } else {
                            ?>
            <!--                            <tr style="background-color: #cccccc">
                                <td colspan="6"><?php //echo $dia_espanhol;    ?></td>
                            </tr> -->
                            <?php
                            $lista_query = $obj->consultar_query_day($fechaquery, $asesor);
                            $cantidad_lista_query = count($lista_query);
                            $corredor = 0;
                            if ($cantidad_lista_query > 0) {
                                foreach ($lista_query as $visxdia) {
                                    $corredor++; //Si es mayor a 4 dias solo descontar como un día.                                    
                                    $codrep = $visxdia[0];
                                    $tiporep = $visxdia[4];
                                    $visita = array();

                                    if ($tiporep == '1' || $tiporep == '2') {

                                        $visita = $obj->mostrarVisitasxCodRep($codrep);

                                        $tiporeporte = $visita[15]; //tipo
                                        $tipovisita = $obj->getTipoVisita($visita[6], $tiporeporte); //atendido

                                        $horainicio = date("H:i", strtotime($visita[8]));
                                        $horafin = date("H:i", strtotime($visita[9]));
                                        $fechavisita = date("Y/m/d", strtotime($visita[1]));

                                        /*
                                          $tv = 'vno';  //colorir el tipo de visita.
                                          if ($visita[6] == 1 || $visita[6] == 2) {
                                          $tv = 'vsi';
                                          }
                                         * 
                                         */


                                        $cliente = $visita[4];
                                        $nomasesor = $visita[3];
                                        $fecharegistro = date("d/m/Y", strtotime($visita[2]));
                                        /*
                                          if (trim($visita[4]) == '20478013206') {
                                          $cliente = '<span style="color:blue">' . $visita[4] . '</span>';
                                          }

                                          if ($visita[15] == 1) {
                                          $url = '<a target="_blank" href="http://agromicrob.ddns.net:8070/humasoft/site/_reptecnicov2_verweb.php?cod=' . $visita[0] . '">' . $visita[0] . '</a>';
                                          $tipocultivo = $visita[13];
                                          $tr = 'vt'; //tipo de reporte
                                          } elseif ($visita[15] == 2) {
                                          $url = '<a target="_blank" href="http://agromicrob.ddns.net:8070/humasoft/site/_repcomercialv2_verweb.php?cod=' . $visita[0] . '">' . $visita[0] . '</a>';
                                          $tipocultivo = $visita[11];
                                          $tr = 'vc'; //tipo de reporte
                                          }
                                         * 
                                         */

                                        $mostrarfecha = date("d/m/Y", strtotime($visita[1]));
                                        $fecha1 = date_create($visita[1]);
                                        $fecha2 = date_create($visita[2]);
                                        $interval = date_diff($fecha1, $fecha2);
                                        //CALCULAR DIAS DE ATRASO

                                        $dia_atraso = $interval->format('%a');
                                        if ($tiporep == '1') {
                                            switch ($dia_atraso) {
                                                case '0': $tecatraso_0++;
                                                    break;
                                                case '1': $tecatraso_1++;
                                                    break;
                                                case '2': $tecatraso_2++;
                                                    break;
                                                case '3': $tecatraso_3++;
                                                    break;
                                                default:
                                                    if ($corredor == $cantidad_lista_query) {
                                                        $tecatraso_4++;
                                                    }
                                                    break;
                                            }
                                        } elseif ($tiporep == '2') {
                                            switch ($dia_atraso) {
                                                case '0': $comatraso_0++;
                                                    break;
                                                case '1': $comatraso_1++;
                                                    break;
                                                case '2': $comatraso_2++;
                                                    break;
                                                case '3': $comatraso_3++;
                                                    break;
                                                default:
                                                    if ($corredor == $cantidad_lista_query) {
                                                        $comatraso_4++;
                                                    }
                                                    break;
                                            }
                                        }
                                    } elseif ($tiporep == '3') {
                                        $visita = $obj->mostrarActividadesxCodRep($codrep);

                                        $fechavisita = $visita[5];

                                        $horainicio = date("H:i", strtotime($visita[6]));
                                        $horafin = date("H:i", strtotime($visita[7]));
                                        $fecharegistro = date("d/m/Y", strtotime($visita[11]));
                                        $cliente = $visita[3];
                                        $nomasesor = $visita[4];
                                        $fecha1 = date_create($visita[5]);
                                        $fecha2 = date_create($visita[11]);
                                        $interval = date_diff($fecha1, $fecha2);
                                        $dia_atraso = $interval->format('%a');
                                        switch ($dia_atraso) {
                                            case '0': $ambtatraso_0++;
                                                break;
                                            case '1': $ambtatraso_1++;
                                                break;
                                            case '2': $ambtatraso_2++;
                                                break;
                                            case '3': $ambtatraso_3++;
                                                break;
                                            default:
                                                if ($corredor == $cantidad_lista_query) {
                                                        $ambtatraso_4++;
                                                    }
                                                break;
                                        }
                                    }

                                    if ($dia_atraso <> 0) {
                                        $dia_espanhol_visita = getDiaCompleto($fechavisita);
                                        ?>                                        
                                        <tr>
                                            <td style=""><?php echo date("d/m/Y", strtotime($fechavisita)).' '.$horainicio . ' - ' . $horafin; ?></td>
                                            <td style="text-align: center;"><?php echo $fecharegistro; ?></td>
                                            <td><?php echo $cliente; ?></td>
                                            <!--<td><?php // echo $nomasesor;    ?></td>-->
                                            <td><?php echo $codrep; ?></td>
                                            <td style="text-align: center;"><?php echo $interval->format('%a dias'); ?></td>
                                        </tr>
                                        <?php
                                    } else {
                                        ?>
                                        <tr>                                            
                                            <td style=""><?php echo date("d/m/Y", strtotime($fechavisita)). ' ' . $horainicio . ' - ' . $horafin; ?></td>
                                            <td style="text-align: center;"><?php echo $fecharegistro; ?></td>
                                            <td><?php echo $cliente; ?></td>
                                            <!--<td><?php // echo $nomasesor;    ?></td>-->
                                            <td><?php echo $codrep; ?></td>
                                            <td style="text-align: center;">0</td>
                                        </tr>
                                        <?php
                                    }
                                }
                            } else {
                                //DIA QUE NO REGISTRO
                                $fecha1 = date_create($dias);
                                $fecha2 = date_create($periodo2);
                                $interval = date_diff($fecha1, $fecha2);
                                $dia_atraso = $interval->format('%a');
                                $dia_no_reg++;
                                /*
                                if ($tipo_usuario == 'VT') {
                                    switch ($dia_atraso) {
                                        case '0': $tecatraso_0++;
                                            break;
                                        case '1': $tecatraso_1++;
                                            break;
                                        case '2': $tecatraso_2++;
                                            break;
                                        case '3': $tecatraso_3++;
                                            break;
                                        default: //$tecatraso_4++;
                                            break;
                                    }
                                } elseif ($tipo_usuario == 'VC') {
                                    switch ($dia_atraso) {
                                        case '0': $comatraso_0++;
                                            break;
                                        case '1': $comatraso_1++;
                                            break;
                                        case '2': $comatraso_2++;
                                            break;
                                        case '3': $comatraso_3++;
                                            break;
                                        default: //$comatraso_4++;
                                            break;
                                    }
                                }
                                 * 
                                 */
                                ?> 
                <!--                                <tr style="background-color: #cccccc">
                <td colspan="6"><?php echo $dia_espanhol; ?></td>
                </tr>  -->
                                <tr>
                                    <td><?php echo $dia_espanhol; ?></td>
                                    <td></td>
                                    <td>No Registro Reporte</td>
                                    <td></td>
                                    <!--<td style="text-align: center;"><?php //echo $interval->format('%a dias');   ?></td>-->
                                    <td style="text-align: center;"><?php echo '-1 dia'; ?></td>
                                </tr>                            
                                <?php
                            }
                        }
                    }
                }
                ?>                
            </tbody>               
        </table>
        <br/>
        <br/>
        <p style="">
            Visitas Técnicas, Comerciales y de Apoyo a Oficina según Fecha de Registro.<br/>
            Periodo: <?php echo $periodo1 . ' - ' . $periodo2; ?>
        </p>
        <br/> 
        <?php
//Calcular Sanciones
        $tecsancion_0 = $tecatraso_0 * 0;
        $tecsancion_1 = $tecatraso_1 * 3;
        $tecsancion_2 = $tecatraso_2 * 10;
        $tecsancion_3 = $tecatraso_3 * 20;
        $tecsancion_4 = $tecatraso_4 . ' Dias';

        $comsancion_1 = $comatraso_1 * 10;
        $comsancion_2 = $comatraso_2 * 20;
        $comsancion_3 = $comatraso_3 * 40;

        $ambtsancion_1 = $ambtatraso_1 * 0;
        $ambtsancion_2 = $ambtatraso_2 * 0;
        $ambtsancion_3 = $ambtatraso_3 * 0;
        $ambtsancion_4 = $ambtatraso_4 * 0;

        $sancion_0 = 0;
        $sancion_1 = $tecsancion_1 + $comsancion_1 + $ambtsancion_1;
        $sancion_2 = $tecsancion_2 + $comsancion_2 + $ambtsancion_2;
        $sancion_3 = $tecsancion_3 + $comsancion_3 + $ambtsancion_3;
        $sancion_4 = $tecatraso_4 + $comatraso_4 + $ambtatraso_4 + $dia_no_reg;
        if ($sancion_4 == 1) {
            $sancion_4 = $sancion_4 . ' día laborable';
        } else {
            $sancion_4 = $sancion_4 . ' días laborables';
        }

        $total_tecsanciones = $tecsancion_0 + $tecsancion_1 + $tecsancion_2 + $tecsancion_3;
        $total_comsanciones = $comsancion_1 + $comsancion_2 + $comsancion_3;
        $total_ambtsanciones = $ambtatraso_1 + $ambtatraso_2 + $ambtatraso_3 + $ambtatraso_4;
        $total_sanciones = $sancion_1 + $sancion_2 + $sancion_3;
        ?>

        <p>Cantidad de días que no registro reporte: <?php echo $dia_no_reg . ' días.'; ?></p>
        <table class="table table-bordered" style="width: 50%; font-size: 10px;">
            <thead style="text-align: center; background-color: #330099; color: whitesmoke;">
                <tr>
                    <td rowspan="2" style="vertical-align: middle; text-align: center;">DESCRIPCION</td>
                    <td colspan="5" style="text-align: center;">DIAS DE ATRASO</td>
                </tr>
                <tr>
                    <td>A TIEMPO</td>
                    <td>1 DIA</td>
                    <td>2 DIAS</td>
                    <td>3 DIAS</td>
                    <td>4 DIAS O MAS</td>                    
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>REPORTES TÉCNICOS</td>
                    <td style="text-align: center;"><?php echo $tecatraso_0; ?></td>
                    <td style="text-align: center;"><?php echo $tecatraso_1; ?></td>
                    <td style="text-align: center;"><?php echo $tecatraso_2; ?></td>
                    <td style="text-align: center;"><?php echo $tecatraso_3; ?></td>
                    <td style="text-align: center;"><?php echo $tecatraso_4; ?></td>
                </tr>
                <tr>
                    <td>REPORTES COMERCIALES</td>
                    <td style="text-align: center;"><?php echo $comatraso_0; ?></td>
                    <td style="text-align: center;"><?php echo $comatraso_1; ?></td>
                    <td style="text-align: center;"><?php echo $comatraso_2; ?></td>
                    <td style="text-align: center;"><?php echo $comatraso_3; ?></td>
                    <td style="text-align: center;"><?php echo $comatraso_4; ?></td>
                </tr>
                <tr>
                    <td>APOYO A OFICINA</td>
                    <td style="text-align: center;"><?php echo $ambtatraso_0; ?></td>
                    <td style="text-align: center;"><?php echo $ambtatraso_1; ?></td>
                    <td style="text-align: center;"><?php echo $ambtatraso_2; ?></td>
                    <td style="text-align: center;"><?php echo $ambtatraso_3; ?></td>
                    <td style="text-align: center;"><?php echo $ambtatraso_4; ?></td>
                </tr>
                <tr>
                    <td>Sanciones</td>
                    <td style="text-align: center;"><?php echo 'S/.' . number_format(0, 2); ?></td>
                    <td style="text-align: center;"><?php echo 'S/.' . number_format($sancion_1, 2); ?></td>
                    <td style="text-align: center;"><?php echo 'S/.' . number_format($sancion_2, 2); ?></td>
                    <td style="text-align: center;"><?php echo 'S/.' . number_format($sancion_3, 2); ?></td>
                    <td style="text-align: center;"><?php echo $sancion_4; ?></td>                    
                </tr>
                <tr>
                    <td>Total Sanciones</td>
                    <td colspan="5" style="text-align: center; font-weight: bolder;"><?php echo $sancion_4 . ' y S/.' . number_format($total_sanciones, 2); ?></td>
                </tr>
            </tbody>                
        </table>
        <br/>
        <br/>
        <p>Detalle de Sanciones</p>
        <p>Asesor: <?php echo strtoupper($nomasesor);?> <br/>
        Periodo: <?php echo date("d/m/Y", strtotime($periodo1)) . ' a ' . date("d/m/Y", strtotime($periodo2)); ?> 
        </p>
        <br/>
        <table style="font-size: 12px;">
            <tr style="font-weight: bolder;">
                <td width="300">DESCRIPCION</td>   
                <td style="text-align: center" width="100">CANTIDAD</td>
                <td style="text-align: right" width="50">SANCION</td>                
                <td style="text-align: right" width="100">TOTAL SOLES</td>
                <td style="text-align: right" width="150">TOTAL DIAS</td>
            </tr>
            <tr>
                <td>REPORTES COMERCIALES</td>   
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>&nbsp;&nbsp;Reportes a Tiempo</td>
                <td style="text-align: center"><?php echo $comatraso_0; ?></td>
                <td style="text-align: right">S/. 0.00</td>
                <td style="text-align: right">S/. 0.00</td>
                <td></td>
            </tr>
            <tr>
                <td>&nbsp;&nbsp;Reportes con un dia de atraso</td>
                <td style="text-align: center"><?php echo $comatraso_1; ?></td>
                <td style="text-align: right">S/. 10.00</td>
                <td style="text-align: right">S/. <?php echo number_format($comsancion_1,2); ?></td>
                <td></td>
            </tr>
            <tr>
                <td>&nbsp;&nbsp;Reportes con dos dias de atraso</td>
                <td style="text-align: center"><?php echo $comatraso_2; ?></td>
                <td style="text-align: right">S/. 20.00</td>
                <td style="text-align: right">S/. <?php echo number_format($comsancion_2,2); ?></td>
                <td></td>
            </tr>
            <tr>
                <td>&nbsp;&nbsp;Reportes con tres dias de atraso</td>
                <td style="text-align: center"><?php echo $comatraso_3; ?></td>
                <td style="text-align: right">S/. 40.00</td>
                <td style="text-align: right">S/. <?php echo number_format($comsancion_3,2); ?></td>
                <td></td>
            </tr>
            <tr>
                <td>&nbsp;&nbsp;Reportes con cuatro dias de atraso</td>
                <td style="text-align: center"><?php echo $comatraso_4; ?></td>
                <td style="text-align: right">1 dia</td>
                <td></td>
                <td style="text-align: right"><?php echo $comatraso_4.' dias';?></td>
            </tr>            
            <tr>
                <td>DIAS LABORABLES NO REGISTRADOS</td>
                <td style="text-align: center"><?php echo $dia_no_reg; ?></td>
                <td style="text-align: right">1 dia</td>
                <td></td>
                <td style="text-align: right"><?php echo $dia_no_reg.' dias'; ?></td>
            </tr>
            <tr>
                <td>-</td>
                <td style="text-align: center"></td>
                <td style="text-align: right"></td>
                <td style="text-align: right"></td>
                <td></td>
            </tr>
            <tr>                
                <td style="text-align: right" colspan="3">SUB TOTAL SANCIONES</td>
                <td style="text-align: right">S/. <?php echo number_format($total_sanciones,2);?></td>
                <td style="text-align: right"><?php echo $sancion_4; ?></td>                
            </tr>
            <tr>
                <td>-</td>
                <td style="text-align: center"></td>
                <td style="text-align: right"></td>
                <td style="text-align: right"></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="5" style="text-align: center; font-weight: bolder;">SANCIÓN TOTAL: <?php echo $sancion_4 . ' y S/.' . number_format($total_sanciones, 2); ?> </td>                
            </tr>
        </table>
        <br/><br/>
        

        <p>Tabla de Sanciones</p>
        <table class="table table-bordered" style="width: 50%; font-size: 10px;">
            <thead style="text-align: center; background-color: #832588; color: whitesmoke;">
                <tr>
                    <td rowspan="1" style="vertical-align: middle; text-align: center;">REPORTE</td>
                    <td colspan="1" style="text-align: center;">1 DIA</td>
                    <td colspan="1" style="text-align: center;">2 DIAS</td>
                    <td colspan="1" style="text-align: center;">3 DIAS</td>
                    <td colspan="1" style="text-align: center;">4 DIAS O MAS</td>
                </tr>                
            </thead>
            <tbody>
                <tr>
                    <td>TECNICO</td>
                    <td style="text-align: right;">S/. 3,00</td>
                    <td style="text-align: right;">S/. 10,00</td>
                    <td style="text-align: right;">S/. 20,00</td>
                    <td style="text-align: center;">Descuento de 1 dia laboral</td>                    
                </tr>
                <tr>
                    <td>COMERCIAL</td>
                    <td style="text-align: right;">S/. 10,00</td>
                    <td style="text-align: right;">S/. 20,00</td>
                    <td style="text-align: right;">S/. 40,00</td>
                    <td style="text-align: center;">Descuento de 1 dia laboral</td>                    
                </tr>
            </tbody>
        </table>
        <br/>
    </div>       