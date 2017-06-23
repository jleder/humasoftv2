<?php
@session_start();
include_once '../controller/C_Reportes.php';
$obj = new C_Reportes();

switch ($_GET['cod1']) {

    case 'MA00':
        $mes = $_GET['cod2'];
        $ano = $_GET['cod3'];
        $lista = $obj->search_ma00($mes, $ano);

        break;

    case 'MA01':
        $mes = $_GET['cod2'];
        $ano = $_GET['cod3'];
        $codcli = $_GET['cod4'];
        $obj->__set('codcliente', trim($codcli));        
        $lista = $obj->search_ma01($mes, $ano);

        break;

    case 'MA10':
        $mes = $_GET['cod2'];
        $ano = $_GET['cod3'];
        $asesor = $_GET['cod4'];
        $obj->__set('coduse', trim($asesor));
        $lista = $obj->search_ma10($mes, $ano);

        break;

    case 'MA11':
        $mes = $_GET['cod2'];
        $ano = $_GET['cod3'];
        $asesor = $_GET['cod4'];
        $codcliente = $_GET['cod5'];
        $obj->__set('coduse', trim($asesor));
        $obj->__set('codcliente', trim($codcliente));
        $lista = $obj->search_ma11($mes, $ano);

        break;

    case 'DH00':
        $desde = trim($_GET['cod2']);
        $hasta = trim($_GET['cod3']);
        $lista = $obj->search_dh00($desde, $hasta);
        break;

    case 'DH01':
        $desde = trim($_GET['cod2']);
        $hasta = trim($_GET['cod3']);
        $codcliente = $_GET['cod4'];
        $obj->__set('codcliente', trim($codcliente));
        $lista = $obj->search_dh01($desde, $hasta);
        break;

    case 'DH10':
        $desde = trim($_GET['cod2']);
        $hasta = trim($_GET['cod3']);
        $asesor = $_GET['cod4'];
        $obj->__set('coduse', trim($asesor));
        $lista = $obj->search_dh10($desde, $hasta);

        break;

    case 'DH11':
        $desde = trim($_GET['cod2']);
        $hasta = trim($_GET['cod3']);
        $asesor = $_GET['cod4'];
        $codcliente = $_GET['cod5'];
        $obj->__set('coduse', trim($asesor));
        $obj->__set('codcliente', trim($codcliente));
        $lista = $obj->search_dh11($desde, $hasta);
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

//$lista = $obj->search_asesor();
$size_lista = count($lista)
?>
<div id = "cuerpo">
    <h4 style = "text-align: center;">Lista de Reportes Técnicos</h4>   
    <hr/>
    <div class="row" style="">                
        <div class="col-lg-2">
            <div class="alert alert-success">
                # (VTSI) Visitas Atendidas: <?php echo calcular($lista, 6, 1); ?>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="alert alert-danger">
                # (VTNO)  Visitas No Atendidas: <?php echo calcular($lista, 6, 3); ?>   
            </div>
        </div>
        <div class="col-lg-2">
            <div class="alert alert-warning">
                # (LTSI) Llamadas Atendidas: <?php echo calcular($lista, 6, 2); ?>   
            </div>
        </div>
        <div class="col-lg-2">
            <div class="alert alert-warning">
                # (LTNO) Llamadas No Atendidas: <?php echo calcular($lista, 6, 4); ?>   
            </div>
        </div>
        <div class="col-lg-2">
            <div class="alert alert-info">
                # Total de Visitas: <?php echo $size_lista; ?>
            </div>
        </div>
    </div>                                    

    <table class = "table table-hover" style = "font-size: 10px; "  >
        <thead>
            <tr style="background-color: black; color: white; height: 30px; text-align: center; vertical-align: middle; font-size: 9px; ">
                <th>FECHA VISITA</th>
                <th>FECHA REG.</th>
                <th>ASESOR</th>
                <th>CLIENTE</th>
                <th>ENCARGADO</th>
                <th>NRO. REP</th>
                <th>OPCIONES</th>
            </tr>
        </thead>
        <tbody>

            <?php
            if (count($lista) > 0) {
                for ($i = 0; $i < (count($lista)); $i++) {
                    $fechaVisita = date("d/m/Y", strtotime($lista[$i][1]));
                    $fechaReg = date("d/m/Y G:i", strtotime($lista[$i][2]));
                    $icono = $obj->mostrarIconoComercial($lista[$i][6]);
                    $codigos = $lista[$i][0]; //Envia el codcliente y codfundo

                    $estilo = '';
                    if ($lista[$i][5] == 'f') {
                        //color rojo padron #dc8a8a
                        if ($lista[$i][6] != 1) {
                            echo "<tr style='background-color: #aebfef; color: red; font-weight: bolder;'>";
                        } else {
                            echo "<tr style='background-color: #aebfef; font-weight: bolder;'>";
                        }
                    } else {

                        if ($lista[$i][6] != 1) {
                            echo "<tr style='color: red; font-weight: bolder;'>";
                        } else {
                            echo "<tr>";
                        }
                    }
                    ?> 
                <td align="center" width="">
                    <?php echo $icono . ' ' . $fechaVisita; ?></td>
                <td width=""><?php echo $fechaReg; ?></td>
                <td><?php echo $lista[$i]['desuse']; ?></td>                                
                <td width=""><?php echo $lista[$i][4] ?></td>
                <td width=""><?php echo $lista[$i][5] ?></td>                                                                                
                <td width=""><?php echo $lista[$i][0]; ?></td>
                <td width="" align="left">                                    


                    <?php if ($lista[$i][6] == 1) { ?>                                
                        <!--<a class="btn btn-default" onClick="cargar('#principal', '_reptecnicov2_ver.php?cod=<?php //echo trim($lista[$i][0]); ?>')" href="#" title="Ver"><img src="img/iconos/ver.png" height="20" /> </a>-->                                                                
                               <a class="btn btn-default" href="_reptecnicov2_verweb.php?cod=<?php echo trim($lista[$i][0]); ?>" target="_blank" title="Ver"><img src="img/iconos/ver.png" height="20" /> </a>
                    <?php } else { ?>
                        <!--<a href="#" onclick="cargar('#principal', '_reptecnico_ver_no.php?id=<?php echo trim($lista[$i][0]); ?>')" title="Ver"><img src="img/iconos/ver.png" height="20" /> </a>-->
                    <?php } ?>
                    <?php if ($lista[$i][6] == 1) { ?>
                        <!--<a href="#" onclick="cargar('#principal', '_reptecnico_editar.php?id=<?php echo trim($lista[$i][0]); ?>')" title="Modificar"><img src="img/iconos/editar.jpg" height="20" /> </a>-->
                    <?php } else { ?>
                        <!--<a href="#" onclick="cargar('#principal', '_reptecnico_editar_no.php?id=<?php echo trim($lista[$i][0]); ?>')" title="Modificar"><img src="img/iconos/editar.jpg" height="20" /> </a>-->
                    <?php } ?>                                
                    <!--<a onClick="cargar('#principal', '_cambiar_estado_alumno.php?id=<?php //echo ($lista[$i][0]);                ?>')" href="#" title="Crear Reporte Comercial"><img src="img/iconos/repcom.JPG" height="20" /> </a>-->                                    
                    <!--<a onClick="cargar('#principal', '_cambiar_estado_alumno.php?id=<?php //echo ($lista[$i][0]);                ?>')" href="#" title="Crear Producto Demo"><img src="img/iconos/demo.jpg" height="20" /> </a>-->                                                                    
                    <a class="btn btn-default" onClick="return confirmSubmit()" href="javascript:cargar('#principal', '_rep_elim.php?id=<?php echo trim($lista[$i][0]); ?>&tipo=1')" title="Eliminar"><img src="img/iconos/trash.png" height="20" /></a>
                    <?php  if (!empty(trim($lista[$i][8]))) { ?>
                    <a class="btn btn-default" onClick="cargar('#principal', '_rep_adjunto.php?id=<?php echo trim($lista[$i][0]); ?>&tipo=1')" href="#" title="Ver Archivo Adjunto"><img src="img/iconos/adjunto.png" height="20" /> </a>                                    
                    <?php } ?>
                </td>  
                </tr>
                <?php
            }
        }
        ?>
        </tbody>               
    </table>
</div>       
