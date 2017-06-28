<?php
include '../controller/C_Cliente.php';
$cli = new C_Cliente();
$lista = $cli->getClientesPendientes();
?>
<div id="divcliente">
    <div class="row">
        <div id="breadcrumb" class="col-md-12">
            <ol class="breadcrumb">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="#">Clientes</a></li>
                <li><a href="#">Clientes Pendientes</a></li>
            </ol>
        </div>
    </div>
    <div class="row">        
        <div class="col-sm-12">
            <div class="well">                    
                <h4 class="page-header">Clientes Pendientes de Aprobación</h4>
                <p>Estos clientes fueron registrados por asesores. Es necesario que se revisen si los datos son correctos.</p>
                <div class="box">
                    <div class="box-header">
                        <div class="box-name">
                            <i class="fa fa-users"></i>
                            <span>Clientes con datos no verificados</span>
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
                                    <th>NOMBRE DE CLIENTE</th>
                                    <th>RUC/DNI</th>                                        
                                    <th>ABREVIATURA</th>
                                    <th>FECHA REGISTRO</th>
                                    <th>CREADO POR</th>
                                    <th>VALIDADO</th>

                                    <th><span class="fa fa-cog"></span></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $corredor = 1;
                                foreach ($lista as $cliente) {

                                    $validado = 'Si';
                                    if ($cliente[11] == 'f') {
                                        $validado = 'No';
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo $corredor; ?></td>
                                        <td><?php echo $cliente['nombre'] ?></td>
                                        <td><?php echo $cliente['codcliente'] ?></td>                        
                                        <td><?php echo $cliente['abrev'] ?></td>
                                        <td><?php echo date("d/m/Y", strtotime($cliente['fecreg'])); ?></td>
                                        <td><?php echo $cliente['desuse'] ?></td>
                                        <td><?php echo $validado; ?></td>
                                        <td>                        
                                            <a class="btn btn-default" href="#" onclick="cargar('#divcliente', '_cliente_editar.php?id=<?php echo trim($cliente['codcliente']); ?>')" title="Modificar"><span class="fa fa-edit text-info"></span></a> 
                                            <a class="btn btn-danger" onClick="return confirmSubmit()" href="javascript:cargar('#divcliente', '_cliente_elim.php?id=<?php echo trim($cliente['codcliente']); ?>')" title="Eliminar"><span class="fa fa-trash-o"></span></a>
                                        </td>
                                    </tr>
                                    <?php
                                    $corredor++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>   
    <script>
        // Run Datables plugin and create 3 variants of settings
        function AllTables() {
            TestTable1();
            LoadSelect2Script(MakeSelect2);
        }
        function MakeSelect2() {            
            $('.dataTables_filter').each(function () {
                $(this).find('label input[type=text]').attr('placeholder', 'Buscar');
            });
        }
        $(document).ready(function () {            
            LoadDataTablesScripts(AllTables);            
            WinMove();
        });
    </script>
</div>
