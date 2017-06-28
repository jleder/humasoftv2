<?php
@session_start();
include_once '../controller/C_Actividad.php';
$obj = new C_Actividad();
$obj->__set('user', $_SESSION['usuario']);
$listactiv = $obj->getActividad();
?>
<html>
    <head>  
        <meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8" />                
        <?php include 'head.php'; ?>   
    </head>
    <body>        
        <?php include 'header.php'; ?>
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
                                <li><a href="#">Visitas</a></li>
                                <li><a href="_actividad.php">Listar Actividades</a></li>
                            </ol>
                        </div>
                    </div>
                    <div id="divactividad">
                        <div class="row">
                            <div class="col-lg-12" style="text-align: center;">                
                                <label>ACTIVIDADES (APOYO A OFICINA)</label>
                            </div>
                        </div>
                        <div class="row" >
                            <div class="col-lg-2">
                                <a href="_actividad_reg_on.php" class="btn btn-default">
                                    <img src="img/iconos/Add.png" height="20px" title="Crear nuevo registro"  >
                                    <span>Registrar Actividad</span>
                                </a>
                            </div>
                        </div>

                        <div class="row">            
                            <div class="col-lg-12">
                                <div class="box">
                                    <div class="box-header">
                                        <div class="box-name">
                                            <i class="fa fa-list-alt"></i>
                                            <span>Tabla de Actividades</span>
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
                                    <div class="box-content no-padding">                            
                                        <table class="table table-bordered table-striped table-hover table-heading table-datatable" id="datatable-1" style="font-size: 10px;">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>FECHA ACTIVIDAD</th>                        
                                                    <th>RESPONSABLE</th>
                                                    <th>LUGAR</th>
                                                    <th>TIPO ACTIVIDAD</th>                                                                         
                                                    <th>DESCRIPCION</th>                                                                         
                                                    <th>CODIGO</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (count($listactiv) > 0) {
                                                    $contador = 1;
                                                    foreach ($listactiv as $lista) {
                                                        $fechainicio = date("d/m/Y", strtotime($lista['fecinicio']));
                                                        $horainicio = date("G:i", strtotime($lista['horainicio']));
                                                        $fechafin = 'INDEFINIDO';
                                                        $horafin = '';
                                                        if (!empty($lista['horafin'])) {
                                                            $horafin = date("G:i", strtotime($lista['horafin']));
                                                        }
                                                        if (!empty($lista['fechafin'])) {
                                                            $fechafin = date("d/m/Y", strtotime($lista['fecfin']));
                                                        }
                                                        ?>
                                                        <tr style="">    
                                                            <td width="10"><?php echo $contador; ?></td>
                                                            <td width="150"><?php echo $fechainicio . ', ' . $horainicio . ' - ' . $horafin; ?></td>                                                                                                
                                                            <td width="">
                                                                <?php echo $lista['nomtitular']; ?>
                                                            </td>
                                                            <td width="200">
                                                                <?php echo $lista['lugar']; ?>
                                                            </td>
                                                            <td width="">
                                                                <?php echo $lista['tactividad']; ?>
                                                            </td>
                                                            <td width="">
                                                                <?php echo $lista['descripcion']; ?>
                                                            </td>
                                                            <td width="100">
                                                                <?php echo $lista['codigo']; ?>
                                                            </td>
                                                            <td width="">                                                                                                         
                                                                <!--<a class="btn btn-warning" href="#" onclick="cargar('#divactividad', 'site/_actividad_edit.php?cod=<?php// echo trim($lista['codigo']); ?>')" title="Modificar"><span class="fa fa-edit"></span> </a>-->                                                                
                                                                <a class="btn btn-danger" onClick="return confirmSubmit()" href="javascript:cargar('#divactividad', '_actividad_elim.php?cod=<?php echo trim($lista['codigo']); ?>&tipo=2')" title="Eliminar"><span class="fa fa-trash-o"></span></a>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $contador++;
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr> 
                                                    <th></th>
                                                    <th>FECHA ACTIVIDAD</th>                        
                                                    <th>RESPONSABLE</th>
                                                    <th>LUGAR</th>
                                                    <th>TIPO ACTIVIDAD</th>                                                                         
                                                    <th>DESCRIPCION</th>                                                                         
                                                    <th>CODIGO</th>
                                                    <th></th>                                    
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
        </div>
        <!--End Container-->
        <?php include 'script.php'; ?>
        <script>

            function cargar(div, pagina)
            {
                $(div).load(pagina);
            }


            // Run Datables plugin and create 3 variants of settings
            function AllTables() {
                TestTable1();
                TestTable2();
                TestTable3();
                LoadSelect2Script(MakeSelect2);
            }
            function MakeSelect2() {
                $('select').select2();
                $('.dataTables_filter').each(function () {
                    $(this).find('label input[type=text]').attr('placeholder', 'Search');
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

