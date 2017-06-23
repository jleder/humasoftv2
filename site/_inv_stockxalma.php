<?php
header("Cache-Control: no-cache, must-revalidate");
$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["conectado"])) {
    if ($_SESSION["conectado"] == 'SI') {
        include '../controller/C_Movimientos.php';
        $obj_almacen = new Almacen();

        $listaAlmacen = $obj_almacen->listarAlmacenes();
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
                                        <li><a href="#">Inventarios</a></li>
                                        <li><a href="_inv_stockxalma.php">Stock x Almacen</a></li>
                                    </ol>
                                </div>
                            </div>

                            <div class="row">                        
                                <div class="col-xs-12 col-sm-12">
                                    <div class="box">
                                        <div class="box-header">
                                            <div class="box-name">
                                                <i class="fa fa-briefcase"></i>
                                                <span>Consultar Stock por Almacén</span>
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
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h4>Consulta de Stock por Almacen</h4>        
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <select name = "almacen" class="form-control" id="almacen">
                                                        <option value="0">Seleccione...</option>
                                                        <?php
                                                        foreach ($listaAlmacen as $almacen) {
                                                            echo '<option value="' . $almacen['codalmacen'] . '">' . trim($almacen['nombre']) . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <a class="btn btn-default" href="#" onclick="consulta()">Consultar</a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <hr/>  
                                                </div>
                                            </div>
                                            <div class="row" id="divinventario" >

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
                    function consulta() {
                        var codalmacen = $("#almacen").val();
                        if (codalmacen === '0') {
                            alert("Seleccione Almacen");
                        } else {
                            from_2('', codalmacen, 'divinventario', '_inv_stockxalma_result.php');
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