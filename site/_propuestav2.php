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
        include_once '../controller/C_Propuestas.php';
        unset($_SESSION['carrito']);
        unset($_SESSION['car']);
        ?>
        <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="utf-8">
                <title>Humasoft</title>
                <meta name="description" content="description">
                <meta name="author" content="Juan">
                <?php include 'head.php'; ?> 
                <style>
                    .estado_aprob, .estado_vend, .estado_clie, .estado_noaprob, .estado_seg { 
                        background-color: #00cc00; 
                        color: white; 
                        padding: 3px 5px; 
                        border-radius: 3px; 
                        font-weight: bolder; 
                    }
                    .estado_clie { background-color: #f4bd1d; color: black;}
                    .estado_vend { background-color: #f4f41d; color: black; }            
                    .estado_noaprob { background-color: #ff0033;}
                    .estado_seg { background-color: #1da8f4;}
                    .btn2 { padding: 2px; background-color: blue; border: 1px solid #acacac; }
                    .btn-icon { background-color: #e3e3e3; padding: 5px; display: inline-block; line-height: 10px; margin-left: .3em; margin-top: .3em;}
                    .btn-icon:hover { background-color: #f7f7f7; padding: 5px;}
                    .btn2:active,
                    .btn2.active {
                        background-color: #cccccc \9;
                    }
                </style>
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
                                        <li><a href="_propuestav2.php">Propuestas</a></li>
                                        <li><a href="_propuestav2.php">Lista de Propuestas</a></li>
                                    </ol>
                                </div>
                            </div>

                            <?php
                            $obj = new C_Propuesta();
                            $cli = new C_Cliente();
                            $ecom = new C_EstadoComercial();
                            $despa = new C_Despacho();
                            $det = new C_DetalleDespacho();
                            $codrol = $_SESSION['codrol'];

                            if ($codrol == 1) {
                                include './_propuestav2_list_00ad.php';
                            } elseif ($codrol == 5) {  //Area Técnica
                                include './_propuestav2_list_01at.php';
                            } elseif ($codrol == 7) {  //Area Comercial
                                include './_propuestav2_list_02ac.php';
                            } elseif ($codrol == 6) {  //Area Despacho
                                include './_propuestav2_list_03ds.php';
                            }
                            ?>


                        </div>
                        <!--End Content-->
                    </div>
                </div>
                <!--End Container-->
        <?php include 'script.php'; ?>

                <script type="text/javascript">

                    function buscarpor() {
                        var busqueda = $("#tipobusqueda").val();
                        var divnroprop = document.getElementById('divnroprop');
                        var divcliente = document.getElementById('divcliente');
                        var divrango = document.getElementById('divrango');
                        var divvendedor = document.getElementById('divvendedor');

                        switch (busqueda) {
                            case 'nroprop':
                                divnroprop.style.display = "block";
                                divcliente.style.display = "none";
                                divrango.style.display = "none";
                                divvendedor.style.display = "none";
                                break;
                            case 'cliente':
                                divcliente.style.display = "block";
                                divnroprop.style.display = "none";
                                divrango.style.display = "none";
                                divvendedor.style.display = "none";
                                break;
                            case 'rango':
                                divrango.style.display = "block";
                                divcliente.style.display = "none";
                                divnroprop.style.display = "none";
                                divvendedor.style.display = "none";
                                break;
                            case 'vendedor':
                                divvendedor.style.display = "block";
                                divrango.style.display = "none";
                                divcliente.style.display = "none";
                                divnroprop.style.display = "none";
                                break;
                        }
                    }

                    // Run Datables plugin and create 3 variants of settings
                    function AllTables() {
                        TestTable1();
                        LoadSelect2Script(MakeSelect2);
                    }
                    function MakeSelect2() {
                        $('select').select2();
                        $('.dataTables_filter').each(function () {
                            $(this).find('label input[type=text]').attr('placeholder', 'Buscar');
                        });
                    }
                    $(document).ready(function () {
                        // Load Datatables and run plugin on tables 
                        LoadDataTablesScripts(AllTables);
                        // Add Drag-n-Drop feature
                        WinMove();
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










