<?php
header("Cache-Control: no-cache, must-revalidate");
$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["conectado"])) {
    if ($_SESSION["conectado"] == 'SI') {
        //@session_start();
        include_once '../controller/C_Reportes.php';
        $obj = new C_Reportes();
        $obj->insertarAccion('Hizo clic en el boton Rep. Comercial');
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
                                        <li><a href="dashboard.php">Dashboard</a></li>
                                        <li><a href="_repcomercialv2.php">Visitas</a></li>
                                        <li><a href="_repcomercialv2.php">Reporte Comercial</a></li>
                                    </ol>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="box">
                                        <div class="box-header">
                                            <div class="box-name">
                                                <i class="fa fa-bar-chart-o"></i>
                                                <span>Reportes Comerciales</span>
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
                                                    <a href="#" class="btn btn-success" onclick="javascript:cargar('#divreporte', '_repcomercialv2_reg.php')">
                                                        <span>Crear Reporte Comercial</span>
                                                    </a>            
                                                    <?php if ($_SESSION['usuario'] == 'ADM' || $_SESSION['usuario'] == 'JLP' || $_SESSION['usuario'] == 'JRI' || $_SESSION['usuario'] == 'DDI' || $_SESSION['usuario'] == 'HGO') { ?>
                                                        <a href="#" class="btn btn-primary" onclick="javascript:cargar('#principal', '_reptecnicov2_rep11.php')">                        
                                                            <span>Ver Estadistica</span>
                                                        </a>
                                                    <?php } ?>
                                                </div>
                                            </div>                  
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    Leyendas: 
                                                    <img src="img/iconos/campo.jpg" height="15" /> = Visita Comercial Atendida | 
                                                    <img src="img/iconos/descarte.png" height="15" /> = Visita Comercial No Atendida | 
                                                    <img src="img/iconos/phone.gif" height="15" /> = Llamada Comercial Atendida | 
                                                    <img src="img/iconos/llamada-perdida.png" height="15" /> = Llamada Comercial No Atendida
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if ($_SESSION['usuario'] == 'ADM' || $_SESSION['usuario'] == 'JLP' || $_SESSION['usuario'] == 'JRI' || $_SESSION['usuario'] == 'DDI' || $_SESSION['usuario'] == 'HGO') {
                                $lista = $obj->ultimosRepComercial();
                                $size_lista = count($lista);
                                $mes = $obj->cargarMeses();
                                $asesor = $obj->cargarAsesoresxRepComercial();
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


                                                <div class="" style="font-size: smaller; margin-top: 5px; padding: 5px; text-decoration: none; " id="">
                                                    <div class="col-md-2">
                                                        <strong>Tipo de Consulta</strong>
                                                        <br/>
                                                        <input type="radio" checked="" onclick="mostrarOcultarFechayMes('divmes')" name="periodo" value="mes" id="btnmes" /> Mes <br/>
                                                        <input type="radio" onclick="mostrarOcultarFechayMes('divfecha')" name="periodo" value="fecha" id='btnfecha' /> Rango de Fechas
                                                    </div>
                                                    <div class="col-md-4">
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
                                                                Desde: <input type="text" readonly="" name="desde" placeholder="" value="" id="cal" class="form-control" />
                                                            </div>
                                                            <div class="col-md-6">
                                                                Hasta: 
                                                                <input type="text" placeholder="" readonly="" value="" name="datepicker" id="cal2" class="form-control" />
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
                                                        <input type="submit" class="btn btn-success" onclick="javascript:buscar()" value="Buscar" />
                                                    </div>
                                                    <div class="col-md-4">

                                                    </div>
                                                </div>                                          
                                                <br/><br/><br/>

                                                <div id = "cuerpo" style="height: 400px; overflow: scroll; " >
                                                    <h4 style = "text-align: center;">Lista de Reportes Comerciales</h4>
                                                    <table class = "" width="100%" style = "font-size: 9px; "  >
                                                        <thead>
                                                            <tr style="background-color: #d35400; color: white; height: 30px; text-align: center; vertical-align: middle; font-size: 9px; ">
                                                                <th>FECHA VISITA</th>
                                                                <th>FECHA REG</th>
                                                                <th>ASESOR</th>
                                                                <th>CLIENTE</th>
                                                                <th>CONTACTO</th>
                                                                <th>NRO. REP</th>
                                                                <th>OPCIONES</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <?php
                                                            if ($size_lista > 0) {
                                                                for ($i = 0; $i < $size_lista; $i++) {
                                                                    $fechaVisita = date("d/m/Y", strtotime($lista[$i]['fechavisita']));
                                                                    $fechaReg = date("d/m/Y G:i", strtotime($lista[$i]['fecreg']));
                                                                    $icono = $obj->mostrarIconoComercial($lista[$i]['atendido']);

                                                                    $estilo = '';
                                                                    /*
                                                                      if ($lista[$i][5] == 'f') {
                                                                      //color rojo padron #dc8a8a
                                                                      if ($lista[$i][6] != 1) {
                                                                      echo "<tr style='background-color: #aebfef; color: red;'>";
                                                                      } else {
                                                                      echo "<tr style='background-color: #aebfef;'>";
                                                                      }
                                                                      } else { */

                                                                    if ($lista[$i][6] != 1) {
                                                                        echo "<tr style='color: red; '>";
                                                                    } else {
                                                                        echo "<tr>";
                                                                    }
                                                                    //}
                                                                    ?> 
                                                                <td align="center" width="">

                                                                    <?php echo $icono . ' ' . $fechaVisita; ?></td>
                                                                <td width=""><?php echo $fechaReg; ?></td>
                                                                <td><?php echo $lista[$i]['desuse']; ?></td>                                
                                                                <td width=""><?php echo $lista[$i]['nombre'] ?></td>
                                                                <td width=""><?php echo $lista[$i]['contacto'] ?></td>                                                                                
                                                                <td width=""><?php echo $lista[$i][0]; ?></td>
                                                                <td width="" align="left">
                                                                    <a class="btn btn-default" href="_repcomercialv2_verweb.php?cod=<?php echo trim($lista[$i][0]); ?>" target="_blank" title="Ver"><img src="img/iconos/ver.png" height="20" /></a>
                                                                    <!--La pagina _reptecnico_elim.php sirve para eliminar Visitas Tecnicas y Comerciales  -->
                                                                    <a class="btn btn-default" href="#" onclick="cargar('#divreportes', '_repcomercialv2_editadmin.php?cod=<?php echo trim($lista[$i][0]); ?>')" title="Eliminar"><img src="img/iconos/edit.png" height="15" /></a>
                                                                    <a class="btn btn-default" onClick="return confirmSubmit()" href="javascript:cargar('#divreportes', '_rep_elim.php?id=<?php echo trim($lista[$i][0]); ?>&tipo=2')" title="Eliminar"><img src="img/iconos/trash.png" height="15" /></a>
                                                                    <?php if (!empty(trim($lista[$i][8]))) { ?>
                                                                        <a class="btn btn-default" onClick="cargar('#divreportes', '_rep_adjunto.php?id=<?php echo trim($lista[$i][0]); ?>&tipo=2')" href="#" title="Ver Archivo Adjunto"><img src="img/iconos/adjunto.png" height="15" /> </a>                                                                                                                
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
                                                    <h4 style = "text-align: center;">Últimos Reportes Comerciales</h4>            
                                                    <table class = "" width="100%" style = "font-size: 9px; "  >
                                                        <thead>
                                                            <tr style="background-color: #d35400; color: white; height: 30px; text-align: center; vertical-align: middle; font-size: 9px; ">
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
                                                            $lista2 = $obj->ultimosRepComercialxUsuario();

                                                            if (count($lista2) > 0) {
                                                                for ($i = 0; $i < (count($lista2)); $i++) {
                                                                    $fechaVisita = date("d/m/Y", strtotime($lista2[$i]['fechavisita']));
                                                                    $fechaReg = date("d/m/Y G:i", strtotime($lista2[$i]['fecreg']));
                                                                    $icono = $obj->mostrarIconoComercial($lista2[$i]['atendido']);

                                                                    $estilo = '';
//                                if ($lista2[$i][5] == 'f') {
//                                    //color rojo padron #dc8a8a
//                                    if ($lista2[$i][6] != 1) {
//                                        echo "<tr style='background-color: #aebfef; color: red; font-weight: bolder;'>";
//                                    } else {
//                                        echo "<tr style='background-color: #aebfef; font-weight: bolder;'>";
//                                    }
//                                } else {

                                                                    if ($lista2[$i][6] != 1) {
                                                                        echo "<tr style='color: red; font-weight: bolder;'>";
                                                                    } else {
                                                                        echo "<tr>";
                                                                    }
                                                                    //}
                                                                    ?> 
                                                                <td width=""><?php echo $icono . ' ' . $fechaVisita; ?></td>    
                                                                <td width=""><?php echo $fechaReg; ?></td>
                                                                <td><?php echo $lista2[$i]['desuse']; ?></td>                                
                                                                <td width=""><?php echo $lista2[$i]['nombre'] ?></td>
                                                                <td width=""><?php echo $lista2[$i]['contacto'] ?></td>                                                                                
                                                                <td width=""><?php echo $lista2[$i][0]; ?></td>
                                                                <td width="" align="left">                                                                                  
                                                                    <a class="btn btn-default" href="_repcomercialv2_verweb.php?cod=<?php echo trim($lista2[$i][0]); ?>" target="_blank" title="Ver"><img src="img/iconos/ver.png" height="15" /> </a>
                                                                    <a class="btn btn-default" onClick="return confirmSubmit()" href="javascript:cargar('#divreportes', '_rep_elim.php?id=<?php echo trim($lista2[$i][0]); ?>&tipo=2')" title="Eliminar"><img src="img/iconos/trash.png" height="15" /></a>                                                                                                        
                                                                    <!--La pagina _reptecnico_elim.php sirve para eliminar Visitas Tecnicas y Comerciales  -->
                                                                    <!--<a onClick="return confirmSubmit()" href="javascript:cargar('#principal', '_reptecnico_elim.php?id=<?php echo trim($lista2[$i][0]); ?>&tipo=2')" title="Eliminar"><img src="img/iconos/trash.png" height="20" /></a>-->
                                                                    <?php if (!empty(trim($lista2[$i][8]))) { ?>
                                                                        <a class="btn btn-default" onClick="cargar('#divreportes', '_rep_adjunto.php?id=<?php echo trim($lista2[$i][0]); ?>&tipo=2')" href="#" title="Ver Archivo Adjunto"><img src="img/iconos/adjunto.png" height="20" /> </a>                                    
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
                                //from_2(mes, ano, 'cuerpo', '_repcomercial_search.php')
                                //alert('Mes y Año');
                                from_3('MA00', mes, ano, 'cuerpo', '_repcomercialv2_search.php');
                            }
                            if (asesor === 'todos' && cliente !== 'todos') {
                                //alert('Mes, Año y Cliente');
                                from_4('MA01', mes, ano, cliente, 'cuerpo', '_repcomercialv2_search.php');
                            }
                            if (asesor !== 'todos' && cliente === 'todos') {
                                //alert('Mes, Año y Asesor');
                                from_4('MA10', mes, ano, asesor, 'cuerpo', '_repcomercialv2_search.php');
                            }
                            if (asesor !== 'todos' && cliente !== 'todos') {
                                //alert('Mes, Año, Cliente y Asesor');
                                from_5('MA11', mes, ano, asesor, cliente, 'cuerpo', '_repcomercialv2_search.php');
                            }

                        } else {
                            var desde = document.getElementById('cal').value;
                            var hasta = document.getElementById('cal2').value;

                            if (asesor === "todos" && cliente === "todos") {
                                //from_2(mes, ano, 'cuerpo', '_repcomercial_search.php')
                                //alert('Solo rango');
                                if (desde === '' || hasta === '') {
                                    alert('Debe ingresar fecha de inicio y final');
                                } else {
                                    from_3('DH00', desde, hasta, 'cuerpo', '_repcomercialv2_search.php');
                                }
                            }
                            if (asesor === 'todos' && cliente !== 'todos') {
                                //alert('Mes, Año y Cliente');
                                from_4('DH01', desde, hasta, cliente, 'cuerpo', '_repcomercialv2_search.php');
                            }
                            if (asesor !== 'todos' && cliente === 'todos') {
                                //alert('Mes, Año y Asesor');
                                from_4('DH10', desde, hasta, asesor, 'cuerpo', '_repcomercialv2_search.php');
                            }
                            if (asesor !== 'todos' && cliente !== 'todos') {
                                //alert('Mes, Año, Cliente y Asesor');
                                from_5('DH11', desde, hasta, asesor, cliente, 'cuerpo', '_repcomercialv2_search.php');
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