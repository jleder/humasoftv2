<?php
header("Cache-Control: no-cache, must-revalidate");
$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["conectado"])) {
    if ($_SESSION["conectado"] == 'SI') {
        include_once '../controller/C_Propuestas.php';
        $obj = new C_Propuesta();
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
                                        <li><a href="_propuestav2.php">Propuestas</a></li>
                                        <li><a href="_propuestav2_pendientes.php">Lista de Propuestas Pendientes</a></li>
                                    </ol>
                                </div>
                            </div>

                            <div class="row">                        
                                <div class="col-xs-12 col-sm-12">
                                    <div class="box">
                                        <div class="box-header">                                            
                                            <div class="box-name">
                                                <i class="fa fa-dollar"></i>
                                                <span>Propuestas Pendientes</span>
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
                                            <table  class="table table-bordered table-striped table-hover table-heading " id="datatable-1" style="font-size: 10px; ">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Fecha Registro</th>
                                                        <th>Nro. Propuesta</th>
                                                        <th>Cliente</th>                                
                                                        <th>Forma de Pago</th>
                                                        <th>Demo</th>
                                                        <th>Vendedor</th>
                                                        <th>Estado GER</th>                                                                       
                                                        <th></th>
                                                    </tr>                    
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $listaprop = $obj->getPropuestasPendientes();
                                                    $i = 0;
                                                    foreach ($listaprop as $valor) {

                                                        $obj->__set('codprop', $valor['codprop']);
                                                        $array_item = $obj->getItemPropuestaByCodProp();
                                                        $mostrarEstado = 'SI';

                                                        $estados = $obj->getItemPropuestaByCodProp();

                                                        foreach ($estados as $estado) {
                                                            if ($estado['estado'] <> 'PENDIENTE') {
                                                                $mostrarEstado = 'NO';
                                                                break;
                                                            }
                                                        }
                                                        if ($mostrarEstado == 'SI') {
                                                            $i++;
                                                            ?>                        
                                                            <tr>
                                                                <td><?php echo $i; ?></td>
                                                                <td><?php echo date("d/m/Y", strtotime($valor['fecreg'])); ?></td>
                                                                <td><?php echo $valor['codprop'] ?></td>
                                                                <td><?php echo $valor['nomcliente'] ?></td>
                                                                <td><?php echo $valor['fpago'] ?></td>
                                                                <td><?php echo $valor['demo'] ?></td>
                                                                <td><?php echo $valor['vendedor'] ?></td>                            
                                                                <td>    
                                                                    <?php
                                                                    foreach ($estados as $estadoshow) {
                                                                        $valestado = $obj->getestadoPropuesta(trim($estadoshow['estado']));
                                                                        echo '<p>' . $valestado . '</p>';
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <a class="btn btn-default" href="_propuestav2_aprob02_verweb.php?cod=<?php echo $valor['codprop'] ?>" target="_blank" title="Ver Propuesta"><span class="fa fa-eye text-info" style="font-size: medium;"></span></a>
                                                                </td>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                </tbody>
                                            </table>
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