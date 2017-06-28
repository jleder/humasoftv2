<?php
header("Cache-Control: no-cache, must-revalidate");
$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["conectado"])) {
    if ($_SESSION["conectado"] == 'SI') {
        include_once '../controller/C_Reportes.php';
        $obj = new C_Reportes();
        $obj->insertarAccion('Hizo clic en el boton Rep. Comercial');
        $ano = date("Y");
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
                                        <li><a href="#">Visitas</a></li>
                                        <li><a href="_consultas.php">Multas</a></li>
                                    </ol>
                                </div>
                            </div>

                            <div class="row">                        
                                <div class="col-xs-12 col-sm-12">
                                    <div class="box">
                                        <div class="box-header">
                                            <div class="box-name">
                                                <i class="fa fa-briefcase"></i>
                                                <span>Multas y Sanciones</span>
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
                                        <div class="box-content form-horizontal">                                                                    

                                            <h4 class="page-header" style="text-align: center;">Consultas</h4>
                                            <?php
                                            $lista = $obj->ultimosRepComercial();
                                            $size_lista = count($lista);
                                            $mes = $obj->cargarMeses();
                                            $asesor = $obj->cargarAsesoresxRepComercial();
                                            $clientes = $obj->listarSoloClientes();
                                            ?>
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
                                                            <input id='ano'  type = "number" width="100px" size="5"  name="ano" class="form-control" value = "<?php echo $ano; ?>" /> 
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
                                                        <?php foreach ($asesor as $valor) { ?>
                                                            <option value="<?php echo trim($valor[0]); ?>"><?php echo $valor[1]; ?></option>
                                                        <?php } ?>                       
                                                    </select>                     
                                                </div>
                                                <div class="col-md-2">
                                                    Días de Atraso<br/>
                                                    <select name="diasatraso" id="diasatraso" class="form-control">
                                                        <option value="todos">Todos...</option>
                                                        <option value="0">0 Días</option>
                                                        <option value="1">1 Día</option>
                                                        <option value="2">2 Días</option>
                                                        <option value="3">3 Días</option>                        
                                                        <option value="4 o Mas">4 Días o Más</option>
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

                                            <div id = "cuerpo" style="min-height: 400px;" >
                                                <h4 style = "text-align: center;">Resultados de la Consulta</h4>
                                            </div>
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
                        var asesor = $('#asesor').val();
                        var nomasesor = $("#asesor option:selected").html();
                        var diasatraso = $('#diasatraso').val();

                        //Consulta por Mes
                        if ($("#btnmes").is(':checked'))
                        {
                            var mes = $('#mes').val();
                            var ano = $('#ano').val();
                            var tipo = 'Mes';

                            if (diasatraso !== 'todos' && diasatraso !== '4 o Mas') {
                                from_6('QUERY01', mes, ano, asesor, diasatraso, tipo, 'cuerpo', '_consultas_result.php');
                            }
                            if (diasatraso === 'todos') {
                                from_5('QUERY02', mes, ano, asesor, tipo, 'cuerpo', '_consultas_result.php');
                            }
                            if (diasatraso === '4 o Mas') {
                                from_5('QUERY03', mes, ano, asesor, tipo, 'cuerpo', '_consultas_result.php');
                            }

                            //Consulta por Rango de Fechas
                        } else if ($("#btnfecha").is(':checked')) {
                            var desde = document.getElementById('cal').value;
                            var hasta = document.getElementById('cal2').value;
                            var datos = [asesor, nomasesor];
                            var tipo = 'Rango';

                            if (desde === '' || hasta === '') {
                                alert('Debe ingresar fecha de inicio y final');
                            } else {
                                if (diasatraso !== 'todos' && diasatraso !== '4 o Mas') {
                                    from_6('QUERY04', desde, hasta, datos, diasatraso, tipo, 'cuerpo', '_consultas_result.php');
                                }
                                if (diasatraso === 'todos') {
                                    //alert('diasatraso=todos');                            
                                    from_5('QUERY05', desde, hasta, datos, tipo, 'cuerpo', '_consultas_result.php');
                                }
                                if (diasatraso === '4 o Mas') {
                                    //alert('diasatraso=4 o mas');                            
                                    from_5('QUERY06', desde, hasta, datos, tipo, 'cuerpo', '_consultas_result.php');
                                }
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