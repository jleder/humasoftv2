<?php
header("Cache-Control: no-cache, must-revalidate");
$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["conectado"])) {
    if ($_SESSION["conectado"] == 'SI') {

        require_once '../controller/C_Viaticos.php';
        $viaticos = new Viatico();
        $ubicacion = new Ubicacion();
        $empleados = new Empleado();
        $menu = new Menu();
        $listaEmp = $empleados->listarEmpleadoAll();

        $listaTipoViaticos = $viaticos->listarTipoViaticoAll();
        $listaZona = $ubicacion->getSubZonaByZona();
        $listaDist = $ubicacion->getDepaProvDist();
        //$numaleat = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 20);
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
                                        <li><a href="#">Viáticos</a></li>
                                        <li><a href="#">Listar Viáticos</a></li>
                                    </ol>
                                </div>
                            </div>

                            <div class="row">                        
                                <div class="col-xs-12 col-sm-12">
                                    <div class="box">
                                        <div class="box-header">
                                            <div class="box-name">
                                                <i class="fa fa-briefcase"></i>
                                                <span>Formulario para Listar, Modificar o Eliminar Viáticos <?php //echo $numaleat;   ?></span>
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
                                            <h5 class="page-header">Seleccione Periodo</h5>
                                            <div class="form-group" >
                                                <label class="col-sm-2 control-label">Persona <span class="obl">(*)</span>:</label>
                                                <div class="col-sm-3">
                                                    <select id="codpersona"  name="codpersona" onchange="loadCargoByCodPersona()">                                                    
                                                        <option value="0">- Seleccione -</option>
                                                        <?php foreach ($listaEmp as $valor) { ?>                                
                                                            <option value="<?php echo trim($valor[0]); ?>"> <?php echo trim($valor[1] . ' ' . $valor[2]); ?></option>
                                                        <?php } ?>
                                                    </select>                                             
                                                </div>                                
                                            </div>
                                            <div class="form-group" >
                                                <label class="col-sm-2 control-label">Periodo <span class="obl">(*)</span>:</label>
                                                <div class="col-sm-1">
                                                    <select name="periodo" id="periodo" class="form-control">                                        
                                                        <option value="I">- I -</option>
                                                        <option value="II">- II -</option>
                                                    </select>                                                
                                                </div>
                                                <div class="col-sm-2">
                                                    <select name="periodo_mes" id="periodo_mes">
                                                        <option value="0">- Seleccione -</option>
                                                        <?php
                                                        $meses = $viaticos->cargarMeses();
                                                        foreach ($meses as $key => $mes) {
                                                            ?>                                
                                                            <option value="<?php echo trim($key); ?>"> <?php echo trim($mes); ?></option>
                                                        <?php } ?>                                                    
                                                    </select>
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type = "number" name = "periodo_ano" placeholder="" value = "<?php echo date("Y"); ?>" class="form-control" id="periodo_ano" />
                                                </div> 
                                                <div class="col-sm-2">
                                                    <button type="button" class="btn btn-primary" onclick="obtenerListaViatico()">Listar Viáticos</button>
                                                </div>                                                
                                            </div>                                                                    
                                            <h5 class="page-header">Resultados</h5>                                            
                                            <div class="form-group">
                                                <div class="col-md-12" id="divviatico">
                                                </div>
                                            </div>                                            
                                            <div class="form-group">
                                                <div class="col-md-12" id="respuesta">

                                                </div>
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

                    function obtenerListaViatico() {

                        var validado = validarPeriodo();

                        if (validado) {

                            var codpersona = $("#codpersona").val();
                            var periodo = $("#periodo").val();
                            var periodo_mes = $("#periodo_mes").val();
                            var periodo_ano = $("#periodo_ano").val();

                            var Datos = {
                                codpersona: codpersona,
                                periodo: periodo,
                                periodo_mes: periodo_mes,
                                periodo_ano: periodo_ano
                            };

                            $.ajax({
                                url: '_viatico_lista.php',
                                type: 'GET',
                                dataType: 'html',
                                data: {objeto: Datos},
                                success: function (res) {                                    
                                    $("#divviatico").html(res);
                                },
                                error: function (jqXHR, status, error) {
                                    alert('Disculpe, existió un problema');
                                },
                                complete: function (jqXHR, status) {
                                    //alert('Petición realizada');
                                    //$("#getresult").load('_viatico_lista.php');
                                }
                            });
                        } else {
                            alert('Error al obtener datos.');
                        }
                    }
                    
                    function Select2Test() {
                        $("#codpersona").select2();
                        //$("#codviatico").select2();
                        $("#codtipo").select2();
                        $("#codzona").select2();
                        $("#codlugar").select2();
                        $("#periodo_mes").select2();

                    }

                    function validarPeriodo() {
                        var codpersona = $("#codpersona").val();
                        var periodo_mes = $("#periodo_mes").val();
                        var periodo_ano = $("#periodo_ano").val();

                        if (codpersona === '0') {
                            alert('Debe seleccionar una persona.');
                            $("#codpersona").focus();
                            return false;
                        } else if (periodo_mes === '0') {
                            alert('Debe seleccionar un mes.');
                            $("#periodo_mes").focus();
                            return false;
                        } else if (periodo_ano === "") {
                            alert('Debe ingresar año.');
                            $("#periodo_ano").focus();
                            return false;
                        }
                        return true;
                    }

                    $(document).ready(function () {
                        LoadSelect2Script(Select2Test);
                        WinMove();
                        $('#fecha').datepicker({setDate: new Date(), dateFormat: 'dd/mm/yy'});
                        $('#fecingreso').datepicker({setDate: new Date(), dateFormat: 'dd/mm/yy'});

                        $("#form_ingreso").submit(function (e) {
                            e.preventDefault();
                            var f = $(this);
                            var formData = new FormData(document.getElementById("form_ingreso"));
                            var codpersona = $("#codpersona").val();
                            var periodo = $("#periodo").val();
                            var periodo_mes = $("#periodo_mes").val();
                            var periodo_ano = $("#periodo_ano").val();
                            var cargo = $("#cargo").val();
                            var saldo = $("#saldo").val();
                            //var nomcli = $("#codcli option:selected").html();                                                        
                            formData.append("codpersona", codpersona);
                            formData.append("periodo", periodo);
                            formData.append("periodo_mes", periodo_mes);
                            formData.append("periodo_ano", periodo_ano);
                            formData.append("cargo", cargo);
                            formData.append("saldo", saldo);

                            $.ajax({
                                url: "../controller/C_Viaticos.php",
                                type: "post",
                                dataType: "html",
                                data: formData,
                                cache: false,
                                contentType: false,
                                processData: false,
                                success: function (res) {
                                    $("#divingreso").css("display", "none");
                                    $("#respuesta").html(res);
                                },
                                error: function (jqXHR, status, error) {
                                    alert('Disculpe, existió un problema');
                                },
                                complete: function (jqXHR, status) {
                                    //alert('Petición realizada');
                                    //$("#getresult").load('_viatico_lista.php');
                                }
                            });
                        });

                        $("#form_egreso").submit(function (e) {
                            alert("Entre al formulario egreso");
                            e.preventDefault();
                            var f = $(this);
                            var formData = new FormData(document.getElementById("form_egreso"));

                            var zona = $("#codzona option:selected").html();
                            var codpersona = $("#codpersona").val();
                            var periodo = $("#periodo").val();
                            var periodo_mes = $("#periodo_mes").val();
                            var periodo_ano = $("#periodo_ano").val();
                            var cargo = $("#cargo").val();
                            var saldo = $("#saldo").val();

                            formData.append("codpersona", codpersona);
                            formData.append("periodo", periodo);
                            formData.append("periodo_mes", periodo_mes);
                            formData.append("periodo_ano", periodo_ano);
                            formData.append("cargo", cargo);
                            formData.append("saldo", saldo);
                            formData.append("zona", zona);

                            $.ajax({
                                url: "../controller/C_Viaticos.php",
                                type: "post",
                                dataType: "html",
                                data: formData,
                                cache: false,
                                contentType: false,
                                processData: false,
                                success: function (res) {
                                    $("#divegreso").css("display", "none");
                                    $("#respuesta").html(res);
                                },
                                error: function (jqXHR, status, error) {
                                    alert('Disculpe, existió un problema al enviar el formulario');
                                },
                                complete: function (jqXHR, status) {
                                    alert('Petición realizada');
                                    //$("#getresult").load('_viatico_lista.php');
                                }
                            });
                        });

                    });                    
                </script>
            </body>
        </html>
        <?php
    }
} else {
    header("Location:recursos/logout.php");
}
?>
