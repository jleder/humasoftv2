
<?php
header("Cache-Control: no-cache, must-revalidate");
$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["conectado"])) {
    if ($_SESSION["conectado"] == 'SI') {
        include '../controller/C_Proyecciones.php'; 
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
                                        <li><a href="#">Proyección</a></li>
                                        <li><a href="#">Consultas</a></li>
                                        <li><a href="#">Proyeccion x Asesor</a></li>
                                    </ol>
                                </div>
                            </div>

                            <div class="row">                        
                                <div class="col-xs-12 col-sm-12">
                                    <div class="box">
                                        <div class="box-header">
                                            <div class="box-name">
                                                <i class="fa fa-briefcase"></i>
                                                <span>Formulario para Registrar </span>
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
                                            <h5 class="page-header">Datos de Viático</h5>
                                            
                                            
                                            
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

                   $('#submit_estado').on('click', function () {

                            var codprop = $("#codprop").val();
                            var fecha = $("#fecha").val();
                            var estado = $("#estado").val();
                            var mensaje = $("#obs").val();
                            var objEstado = {
                                codprop: codprop,
                                fecha: fecha,
                                estado: estado,
                                obs: mensaje
                            };
                            if (validarEstadoComercial()) {
                                $.ajax({
                                    url: '../controller/C_Propuestas.php',
                                    type: 'post',
                                    dataType: 'html',
                                    success: function (res) {
                                        $("#result_estado").html(res);
                                        //location.reload();
                                    },
                                    error: function (jqXHR, status, error) {
                                        alert('Disculpe, existió un problema');
                                    },
                                    complete: function (jqXHR, status) {

                                        //$("#" + divcomentario).load('_propuestav2_coment_list.php?coditem=' + coditem + '&corredor=' + corredor);

                                    },
                                    data: {accion: 'RegEstadoComercialV2', obj: objEstado}
                                });
                                CloseModalBox();
                            }
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