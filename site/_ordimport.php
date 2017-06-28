<?php
header("Cache-Control: no-cache, must-revalidate");
$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["conectado"])) {
    if ($_SESSION["conectado"] == 'SI') {
        include '../controller/C_OrdenCompra.php';
        $ocom = new OrdenCompra();

        if (isset($_SESSION['carrito'])) {
            unset($_SESSION['carrito']);
        }

        $listaCompras = $ocom->listarAllOC();
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
                                        <li><a href="_ordimport.php">Importaciones</a></li>
                                        <li><a href="_ordimport.php">Ver Ordenes de Importación</a></li>
                                    </ol>
                                </div>
                            </div>

                            <div class="row">                        
                                <div class="col-xs-12 col-sm-12">
                                    <div class="box">
                                        <div class="box-header">
                                            <div class="box-name">
                                                <i class="fa fa-list-alt"></i>
                                                <span>Ordenes de Importación</span>
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
                                                    <a href="_ordimport_reg.php" class="btn btn-primary">Crear Orden Importación</a>
                                                    <table class="table table-bordered table-striped table-hover table-heading table-datatable" id="datatable-1" style="font-size: 11px;">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Fecha Orden</th>
                                                                <th>Número Orden</th>
                                                                <th>Proveedor</th>                    
                                                                <th>Forma Pago</th>                    
                                                                <th>Via</th>
                                                                <th style="font-size: 15px; text-align: center;"><span class="fa fa-cog"></span></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <?php
                                                            $corredor = 1;
                                                            foreach ($listaCompras as $lista) {
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $corredor; ?></td>
                                                                    <td><?php echo date("d.m.Y", strtotime($lista['fecha_oc'])); ?></td>
                                                                    <td><?php echo $lista['numero_oc']; ?></td>
                                                                    <td><?php echo $lista['nombre']; ?></td>                    
                                                                    <td><?php echo $lista['fpago']; ?></td>
                                                                    <td><?php echo $lista['via']; ?></td>
                                                                    <td style="text-align: center;">                        
                                                                        <a title="Linea de Tiempo" onclick="cargar('#ajax-content', '_ordcompra_view.php?cod=<?php echo trim($lista['numero_oc']); ?>')" class="btn btn-default"><span style="color:green;" class="fa fa-calendar"></span></a>
                                                                        <a title="Desaduanaje" onclick="cargar('#ajax-content', '_desadua_dif_reg.php?cod=<?php echo trim($lista['numero_oc']); ?>')" class="btn btn-default"><i class="fa fa-flag-o"></i></a>
                                                                        <a title="Generar Nota de Ingreso" href="#" onclick="cargar('#ajax-content', '_mov_ingreso_oi_reg2.php?codigo=<?php echo trim($lista['numero_oc']); ?>')" class="btn btn-default"><span style="color:#0099ff;" class="fa fa-info"></span></a>
                                                                        <a title="Descargar PDF" href="_ordcompra_getpdf.php?cod=<?php echo trim($lista['numero_oc']); ?>" class="btn btn-default" target="_blank"><span class="fa fa-download"></span></a>
                                                                        <a onclick="cargar('#divcompra', '_ordcompra_edit.php?cod=<?php echo trim($lista['numero_oc']); ?>')" class="btn btn-default"><span class="fa fa-pencil-square-o"></span></a>
                                                                        <a class="btn btn-default"><span style="color:red;" class="fa fa-trash-o"></span></a>                            
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                $corredor++;
                                                            }
                                                            ?>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th></th>
                                                                <th>Fecha Orden</th>
                                                                <th>Número Orden</th>
                                                                <th>Proveedor</th>                    
                                                                <th>Forma Pago</th>                    
                                                                <th>Via</th>
                                                                <th style="font-size: 15px; text-align: center;"><span class="fa fa-cog"></span></th>
                                                            </tr>
                                                        </tfoot>
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
                        TestTable2();
                        TestTable3();
                        LoadSelect2Script(MakeSelect2);
                    }
                    function MakeSelect2() {

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