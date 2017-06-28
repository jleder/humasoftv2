<?php
header("Cache-Control: no-cache, must-revalidate");
$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["conectado"])) {
    if ($_SESSION["conectado"] == 'SI') {
        include '../controller/C_OrdenPedido.php';
        $pedidos = new Pedido();
        $listaPedidos = $pedidos->listarPedidoAll();
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
                                        <li><a href="_pedido.php">Pedidos</a></li>
                                        <li><a href="_pedido_reg.php">Listar Pedidos</a></li>
                                    </ol>
                                </div>
                            </div>
                            <div class="row">                        
                                <div class="col-xs-12 col-sm-12">
                                    <div class="box">
                                        <div class="box-header">
                                            <div class="box-name">
                                                <i class="fa fa-briefcase"></i>
                                                <span>Tabla de Pedidos</span>
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
                                            <a class="btn btn-primary" href="_pedido_reg.php">Registrar Pedido</a>
                                            <div class="row" id="divpedido">
                                                <div class="col-lg-12">
                                                    <br/>
                                                    <table class="table table-bordered table-striped table-hover table-heading table-datatable" id="datatable-1">
                                                        <thead>
                                                            <tr style="background-color: #009966; color: white;">
                                                                <th>Fecha Pedido</th>
                                                                <th>Nro Pedido</th>
                                                                <th>Cliente</th>
                                                                <th>Vendedor</th>
                                                                <th>Forma Pago</th>                    
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            foreach ($listaPedidos as $lista) {
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo date("d.m.Y", strtotime($lista['fecpedido'])); ?></td>
                                                                    <td><?php echo $lista['codpedido']; ?></td>
                                                                    <td><?php echo $lista['nomcliente']; ?></td>
                                                                    <td><?php echo $lista['nomven']; ?></td>
                                                                    <td><?php echo $lista['fpago']; ?></td>
                                                                    <td></td>
                                                                </tr>
                                                                <?php
                                                            }
                                                            ?>
                                                        </tbody>

                                                    </table>
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

