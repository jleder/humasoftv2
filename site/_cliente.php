<?php
@session_start();
include_once '../controller/C_Cliente.php';
$obj = new C_Cliente();
$list_clientes = $obj->getClientesAll();
?>
<html>
    <head>  
        <meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8" />
        <link rel="stylesheet" href="css/layout_html5.css" type="text/css" media="all" />          
        <script src="util/media/js/jquery.js" type="text/javascript"></script>
        <script src="util/media/js/jquery.dataTables.js" type="text/javascript"></script>
        <script src="util/media/js/js_menu.js" type="text/javascript"></script>               

    </head>
    <body>     
        <div id="divcliente">
            <div class="row">
                <div id="breadcrumb" class="col-md-12">
                    <ol class="breadcrumb">
                        <li><a href="dashboard.php">Dashboard</a></li>
                        <li><a href="#">Clientes</a></li>
                        <li><a href="#">Lista de Clientes</a></li>
                    </ol>
                </div>
            </div>        
            <div class="row">
                <div class="col-sm-12">
                    <div class="well">                    
                        <h4 class="page-header" style="text-align: center;">Lista de Clientes</h4>

                        <div class="box">
                            <div class="box-header">
                                <div class="box-name">
                                    <i class="fa fa-users"></i>
                                    <span>Clientes de Agro Micro Biotech</span>
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
                                <table  class="table table-bordered table-striped table-hover table-heading table-datatable" id="datatable-1" style="font-size: 10px; ">
                                    <thead>
                                        <tr>
                                            <th>RAZON SOCIAL</th>
                                            <th>RUC</th>                         
                                            <th>CODIGO</th>
                                            <th>TELEFONO</th>
                                            <th>CIUDAD</th>
                                            <th>DEPARTAMENTO</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        
                                            foreach($list_clientes as $lista) {
                                                ?>
                                                <tr style="">                                                                
                                                    <td width="">
                                                        <a href="#" onclick="cargar('#principal', '_cliente_ver.php?id=<?php echo trim($lista['codcliente']); ?>')" title="Ver Cliente">
                                                            <?php echo trim($lista['nombre']); ?>
                                                        </a>
                                                    </td>
                                                    <td width=""><?php echo trim($lista['codcliente']); ?></td>                                                                
                                                    <td width=""><?php echo trim($lista['abrev']); ?></td>                                                                
                                                    <td width=""><?php echo trim($lista['telefono']); ?></td>
                                                    <td width=""><?php echo trim($lista['ciudad']); ?></td>
                                                    <td width=""><?php echo trim($lista['departamento']); ?></td>
                                                    <td width="">                                                                                                         
                                                        <a class="btn btn-default" href="#" onclick="cargar('#divcliente', '_cliente_editar.php?id=<?php echo trim($lista['codcliente']); ?>')" title="Modificar"><span class="fa fa-edit txt-info"></span></a>
                                                        <a onclick="return confirmSubmit()" href="javascript:cargar('#divcliente', '_cliente_elim.php?id=<?php echo trim($lista['codcliente']); ?>')" title="Eliminar" class="btn btn-danger"><span class="fa fa-trash-o"></span></a>
                                                    </td>
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
        </div>
    </body>
</html>

