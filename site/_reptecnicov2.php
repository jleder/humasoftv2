<?php
header("Cache-Control: no-cache, must-revalidate");
$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["conectado"])) {
    if ($_SESSION["conectado"] == 'SI') {
        @session_start();
        include_once '../controller/C_Reportes.php';
        $obj = new C_Reportes();
        $obj->insertarAccion('Hizo clic en el boton Rep. Técnico');
//$browser = get_browser();
        $hostname = gethostname();
        ?>
        <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="utf-8">
                <title>Humasoft</title>
                <meta name="description" content="description">
                <meta name="author" content="Juan">
                <?php include 'head.php'; ?>   
            </head>
            <body> 
                <?php include 'header.php'; ?>
                <!--End Header-->

                <!--Start Container-->
                <div id="main" class="container-fluid">
                    <div class="row">
                        <div id="sidebar-left" class="col-xs-2 col-sm-2">
                            <?php include 'menu.php'; ?>
                        </div>
                        <!--Start Content-->                        
                        <div id="content" class="col-xs-12 col-sm-10">                            
                            <div class="row">
                                <div id="breadcrumb" class="col-md-12">
                                    <ol class="breadcrumb">
                                        <li><a href="Dashboard.php">Dashboard</a></li>
                                        <li><a href="_reptecnicov2.php">Visitas</a></li>
                                        <li><a href="_reptecnicov2.php">Reporte Técnico</a></li>
                                    </ol>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="box">
                                        <div class="box-header">
                                            <div class="box-name">
                                                <i class="fa fa-bar-chart-o"></i>
                                                <span>Reportes Técnicos</span>
                                            </div>
                                            <div class="box-icons">
                                                <a class="collapse-link">
                                                    <i class="fa fa-chevron-up"></i>
                                                </a>
                                                <a class="expand-link">
                                                    <i class="fa fa-expand"></i>
                                                </a>
                                                <a class="close-link">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            </div>
                                            <div class="no-move"></div>
                                        </div>
                                        <div class="box-content">

                                            <div class="row">
                                                <div class="col-sm-12">                                
                                                    <a href="#" class="btn btn-success" onclick="javascript:cargar('#divreptecnico', '_reptecnicov2_reg.php')">                    
                                                        <span>Crear Reporte Técnico</span>
                                                    </a>            
                                                    <?php if ($_SESSION['usuario'] == 'JLP' || $_SESSION['usuario'] == 'JRI') { ?>            
                                                        <a href="#" class="btn btn-primary" onclick="javascript:cargar('#principal', '_reptecnicov2_rep11.php')">                        
                                                            <span>Ver Estadistica</span>
                                                        </a>
                                                    <?php } ?>
                                                </div>
                                            </div>                  
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    Leyendas: 
                                                    <img src="img/iconos/campo.jpg" height="15" /> = Visita Técnica Atendida | 
                                                    <img src="img/iconos/descarte.png" height="15" /> = Visita Técnica No Atendida | 
                                                    <img src="img/iconos/phone.gif" height="15" /> = Llamada Técnica Atendida | 
                                                    <img src="img/iconos/llamada-perdida.png" height="15" /> = Llamada Técnica No Atendida        
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                            if ($_SESSION['usuario'] == 'ADM' || $_SESSION['usuario'] == 'JLP' || $_SESSION['usuario'] == 'JRI' || $_SESSION['usuario'] == 'DDI' || $_SESSION['usuario'] == 'HGO') {
                                //Hacemos la carga solo si son estos usuarios. Con esto permitimos que otros usuarios puedan cargar la pagina mas rapido.
                                $lista = $obj->ultimosReportes();
                                $mes = $obj->cargarMeses();
                                $asesor = $obj->cargarAsesoresxRepTecnico();
                                $clientes = $obj->listarSoloClientes();
                                ?>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="box">
                                            <div class="box-header">
                                                <div class="box-name">
                                                    <i class="fa fa-table"></i>
                                                    <span></span>
                                                </div>
                                                <div class="box-icons">
                                                    <a class="collapse-link">
                                                        <i class="fa fa-chevron-up"></i>
                                                    </a>
                                                    <a class="expand-link">
                                                        <i class="fa fa-expand"></i>
                                                    </a>
                                                    <a class="close-link">
                                                        <i class="fa fa-times"></i>
                                                    </a>
                                                </div>
                                                <div class="no-move"></div>
                                            </div>
                                            <div class="box-content">

                                                <div class="row" style="text-align: center; font-size: smaller; margin-top: 5px; padding: 5px; text-decoration: none;" id="">
                                                    <div class="col-md-2">

                                                        <span>
                                                            <input type="radio" name="periodo" onclick="mostrarOcultarFechayMes('divmes')" id="btnmes" value="mes" checked> Consultar por Mes
                                                        </span>
                                                        <br/>

                                                        <span>
                                                            <input type="radio" onclick="mostrarOcultarFechayMes('divfecha')" name="periodo" value="fecha" id='btnfecha' /> Rango de Fechas
                                                        </span>

                                                    </div>
                                                    <div class="col-md-3">
                                                        <div id="divmes">                       
                                                            <div class="col-md-6">Mes:
                                                                <select width="2" name="mes" id='mes' class="form-control">                                
                                                                    <?php foreach ($mes as $key => $meses) { ?>
                                                                        <option value="<?php echo $key; ?>"><?php echo $meses; ?></option>
                                                                    <?php } ?>                       
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">Año:
                                                                <input id='ano'  type = "number" width="100px" size="5"  name="ano" class="form-control" value = "2016" /> 
                                                            </div>
                                                        </div>
                                                        <div id="divfecha" hidden="" >
                                                            <div class="col-md-6">
                                                                Desde: <input type="text" readonly=""  name="desde" placeholder="" value="" id="cal" class="form-control" />
                                                            </div>
                                                            <div class="col-md-6">
                                                                Hasta: 
                                                                <input type="text" placeholder="" readonly=""  value="" name="" id="cal2" class="form-control" />
                                                            </div>
                                                        </div>
                                                    </div>            
                                                    <div class="col-md-2">
                                                        ASESOR<br/>
                                                        <select name="asesor" id="asesor" class="form-control">
                                                            <option value="todos">..::Todos los asesores</option>
                                                            <?php foreach ($asesor as $valor) { ?>
                                                                <option value="<?php echo trim($valor[0]); ?>"><?php echo $valor[1]; ?></option>
                                                            <?php } ?>                       
                                                        </select>                     
                                                    </div>
                                                    <div class="col-md-2">
                                                        CLIENTE<br/>
                                                        <select name="cliente" id="cliente" class="form-control">
                                                            <option value="todos">..::Todos los clientes</option>
                                                            <?php foreach ($clientes as $value) { ?>
                                                                <option value="<?php echo $value[0]; ?>"><?php echo $value[1]; ?></option>
                                                            <?php } ?>                       
                                                        </select>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <br/>
                                                        <input type="submit" class="btn btn-success btn-sm" onclick="javascript:buscar()" value="Buscar" />
                                                    </div>                
                                                </div>
                                                <div id = "cuerpo" style="height: 400px; overflow: scroll;">
                                                    <h4 style = "text-align: center;">Lista de Reportes Técnicos</h4>            
                                                    <table class = "" width="100%" style = "font-size: 9px; "  >
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
                                                            $size_lista = count($lista);
                                                            if ($size_lista > 0) {
                                                                for ($i = 0; $i < ($size_lista); $i++) {
                                                                    $fechaVisita = date("d/m/Y", strtotime($lista[$i][1]));
                                                                    $fechaReg = date("d/m/Y G:i", strtotime($lista[$i][2]));
                                                                    $icono = $obj->mostrarIconoComercial($lista[$i][6]);
                                                                    $codigos = $lista[$i][0] . '|' . $lista[$i][7]; //Envia el codcliente y codfundo

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
                                                                <td align="">
                                                                    <?php echo $icono . ' ' . $fechaVisita; ?></td>
                                                                <td><?php echo $fechaReg; ?></td>
                                                                <td><?php echo $lista[$i]['desuse']; ?></td>                                

                                                                <td width=""><?php echo $lista[$i][4] ?></td>
                                                                <td width=""><?php echo $lista[$i][5] ?></td>                                                                                
                                                                <td width=""><?php echo $lista[$i][0]; ?></td>
                                                                <td width="" align="left">
                                                                    <!--<a class="btn btn-default" onClick="cargar('#principal', '_reptecnicov2_ver.php?cod=<?php //echo trim($lista[$i][0]);                  ?>')" href="#" title="Ver"><img src="img/iconos/ver.png" height="20" /> </a>-->                                                                
                                                                    <a class="btn btn-default btn-sm" href="_reptecnicov2_verweb.php?cod=<?php echo trim($lista[$i][0]); ?>" target="_blank" title="Ver"><img src="img/iconos/ver.png" height="15" /> </a>
                                                                    <a class="btn btn-default btn-sm" onClick="return confirmSubmit()" href="javascript:cargar('#divreptecnico', '_rep_elim.php?id=<?php echo trim($lista[$i][0]); ?>&tipo=1')" title="Eliminar"><img src="img/iconos/trash.png" height="15" /></a>
                                                                    <?php if (!empty(trim($lista[$i][8]))) { ?>
                                                                        <a class="btn btn-default" onClick="cargar('#divreptecnico', '_rep_adjunto.php?id=<?php echo trim($lista[$i][0]); ?>&tipo=1')" href="#" title="Ver Archivo Adjunto"><img src="img/iconos/adjunto.png" height="20" /> </a>
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
                                            <?php } else { ?>

                                                <br/>

                                                <div id = "cuerpo" style="height: 400px; overflow: scroll;">
                                                    <h4 style = "text-align: center;">Últimos Reportes Técnicos / Campo</h4>            
                                                    <table class = "" width="100%" style = "font-size: 9px; "  >
                                                        <thead>
                                                            <tr style="background-color: black; color: white; height: 30px; text-align: center; vertical-align: middle; font-size: 9px; ">
                                                                <th>FECHA VISITA</th>    
                                                                <th>FECHA REGISTRO</th>
                                                                <th>ASESOR</th>
                                                                <th>CLIENTE</th>
                                                                <th>ENCARGADO</th>
                                                                <th>NRO. REP</th>
                                                                <th>OPCIONES</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <?php
                                                            $obj->__set('coduse', $_SESSION['usuario']);
                                                            $lista2 = $obj->ultimosReportesxUsuario();
                                                            $size_lista = count($lista2);
                                                            if ($size_lista > 0) {
                                                                for ($i = 0; $i < $size_lista; $i++) {
                                                                    $fechaVisita = date("d/m/Y", strtotime($lista2[$i][1]));
                                                                    $fechaReg = date("d/m/Y", strtotime($lista2[$i][2]));
                                                                    $icono = $obj->mostrarIconoComercial($lista2[$i][6]);
                                                                    $codigos = $lista2[$i][0] . '|' . $lista2[$i][7]; //Envia el codcliente y codfundo

                                                                    $estilo = '';
                                                                    if ($lista2[$i][5] == 'f') {
                                                                        //color rojo padron #dc8a8a
                                                                        if ($lista2[$i][6] != 1) {
                                                                            echo "<tr style='background-color: #aebfef; color: red; font-weight: bolder;'>";
                                                                        } else {
                                                                            echo "<tr style='background-color: #aebfef; font-weight: bolder;'>";
                                                                        }
                                                                    } else {

                                                                        if ($lista2[$i][6] != 1) {
                                                                            echo "<tr style='color: red; font-weight: bolder;'>";
                                                                        } else {
                                                                            echo "<tr>";
                                                                        }
                                                                    }
                                                                    ?> 
                                                                <td><?php echo $icono . ' ' . $fechaVisita; ?></td>  
                                                                <td><?php echo $fechaReg; ?></td>
                                                                <td><?php echo $lista2[$i]['desuse']; ?></td>                                

                                                                <td width=""><?php echo $lista2[$i][4] ?></td>
                                                                <td width=""><?php echo $lista2[$i][5] ?></td>                                                                                
                                                                <td width=""><?php echo $lista2[$i][0]; ?></td>
                                                                <td width="" align="left">                                    



                                                                                                                                                                                                                                                                                                                                                                <!-- Momentaneamente <a class="btn btn-default" onClick="cargar('#principal', '_repcomercial_reg2.php?id=<?php echo trim($lista2[$i][0]); ?>')" href="#" title="Crear Reporte Comercial"><img src="img/iconos/repcom.JPG" height="20" /> </a>-->
                                                                                                                                                                                                                                                                                                                                                                <!--<a class="btn btn-default" onClick="cargar('#principal', '_cambiar_estado_alumno.php?id=<?php //echo ($lista2[$i][0]);                                          ?>')" href="#" title="Crear Producto Demo"><img src="img/iconos/demo.jpg" height="20" /> </a>-->                                                                    
                                                                    <?php if ($lista2[$i][6] == 1) { ?>                                
                                                                        <a class="btn btn-default btn-sm" onClick="cargar('#principal', '_reptecnicov2_ver.php?cod=<?php echo trim($lista2[$i][0]); ?>')" href="#" title="Ver"><img src="img/iconos/ver.png" height="15" /> </a>
                                                                        <a class="btn btn-default btn-sm" onClick="return confirmSubmit()" href="javascript:cargar('#principal', '_rep_elim.php?id=<?php echo trim($lista2[$i][0]); ?>&tipo=1')" title="Eliminar"><img src="img/iconos/trash.png" height="15" /></a>
                                                                    <?php } else { ?>
                                                                        <!--<a href="#" class="btn btn-default" onclick="cargar('#principal', '_reptecnico_ver_no.php?id=<?php echo trim($lista2[$i][0]); ?>')" title="Ver"><img src="img/iconos/ver.png" height="20" /> </a>-->
                                                                    <?php } ?>
                                                                    <?php if ($lista2[$i][6] == 1) { ?>
                                                                        <!--<a href="#" class="btn btn-default" onclick="cargar('#principal', '_reptecnico_editar.php?id=<?php echo trim($lista2[$i][0]); ?>')" title="Modificar"><img src="img/iconos/editar.jpg" height="20" /> </a>-->
                                                                    <?php } else { ?>
                                                                        <!--<a href="#" class="btn btn-default" onclick="cargar('#principal', '_reptecnico_editar_no.php?id=<?php echo trim($lista2[$i][0]); ?>')" title="Modificar"><img src="img/iconos/editar.jpg" height="20" /> </a>-->
                                                                    <?php } ?>                                   
                        <!--<a class="btn btn-default" onClick="return confirmSubmit()" href="javascript:cargar('#principal', '_reptecnico_elim.php?id=<?php echo trim($lista2[$i][0]); ?>&tipo=1')" title="Eliminar"><img src="img/iconos/trash.png" height="20" /></a>-->
                                                                    <?php if (!empty(trim($lista2[$i][8]))) { ?>
                                                                        <a class="btn btn-default" onClick="cargar('#principal', '_rep_adjunto.php?id=<?php echo trim($lista2[$i][0]); ?>&tipo=1')" href="#" title="Ver Archivo Adjunto"><img src="img/iconos/adjunto.png" height="20" /> </a>
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
                                            <?php } ?> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--End Content-->
                    </div>
                </div>
                <!--End Container-->
                <?php include 'script.php'; ?>

                <script type="text/javascript">

                    function buscar() {
                        var asesor = document.getElementById('asesor').value;
                        var cliente = document.getElementById('cliente').value;

                        if ($("#btnmes").is(':checked'))
                        {
                            var mes = document.getElementById('mes').value;
                            var ano = document.getElementById('ano').value;

                            if (asesor === "todos" && cliente === "todos") {
                                //from_2(mes, ano, 'cuerpo', '_reptecnico_search_asesor.php')
                                //alert('Mes y Año');
                                from_3('MA00', mes, ano, 'cuerpo', '_reptecnicov2_search_asesor.php');
                            }
                            if (asesor === 'todos' && cliente !== 'todos') {
                                //alert('Mes, Año y Cliente');                        
                                from_4('MA01', mes, ano, cliente, 'cuerpo', '_reptecnicov2_search_asesor.php');
                            }
                            if (asesor !== 'todos' && cliente === 'todos') {
                                //alert('Mes, Año y Asesor');
                                from_4('MA10', mes, ano, asesor, 'cuerpo', '_reptecnicov2_search_asesor.php');
                            }
                            if (asesor !== 'todos' && cliente !== 'todos') {
                                //alert('Mes, Año, Cliente y Asesor');
                                from_5('MA11', mes, ano, asesor, cliente, 'cuerpo', '_reptecnicov2_search_asesor.php');
                            }

                        } else {
                            var desde = document.getElementById('cal').value;
                            var hasta = document.getElementById('cal2').value;

                            if (asesor === "todos" && cliente === "todos") {
                                //from_2(mes, ano, 'cuerpo', '_reptecnico_search_asesor.php')                        
                                if (desde === '' || hasta === '') {
                                    alert('Debe ingresar fecha de inicio y final');
                                } else {
                                    from_3('DH00', desde, hasta, 'cuerpo', '_reptecnicov2_search_asesor.php');
                                }
                            }
                            if (asesor === 'todos' && cliente !== 'todos') {
                                //alert('Mes, Año y Cliente');
                                from_4('DH01', desde, hasta, cliente, 'cuerpo', '_reptecnicov2_search_asesor.php');
                            }
                            if (asesor !== 'todos' && cliente === 'todos') {
                                //alert('Mes, Año y Asesor');
                                from_4('DH10', desde, hasta, asesor, 'cuerpo', '_reptecnicov2_search_asesor.php');
                            }
                            if (asesor !== 'todos' && cliente !== 'todos') {
                                //alert('Mes, Año, Cliente y Asesor');
                                from_5('DH11', desde, hasta, asesor, cliente, 'cuerpo', '_reptecnicov2_search_asesor.php');
                            }

                        }
                    }

                    function mostrarOcultarFechayMes(id) {
                        var mes = document.getElementById('divmes');
                        var fecha = document.getElementById('divfecha');
                        if (id == 'divmes') {
                            mes.style.display = "block";
                            fecha.style.display = "none";
                        }
                        if (id == 'divfecha') {
                            fecha.style.display = "block";
                            mes.style.display = "none";
                        }
                    }

                </script>
            </body>
        </html>
        <?php
    }
} else {
    header("Location:recursos/logout.php");
}
?>