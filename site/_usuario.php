<?php
header("Cache-Control: no-cache, must-revalidate");
$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["conectado"])) {
    if ($_SESSION["conectado"] == 'SI') {
        include_once '../controller/C_Usuario.php';
        $obj = new C_Usuario();
        $lista = $obj->listar_aausdb01_todos();
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
                                        <li><a href="#">Seguridad</a></li>
                                        <li><a href="#">Usuarios</a></li>
                                    </ol>
                                </div>
                            </div>

                            <div class="row">                        
                                <div class="col-xs-12 col-sm-12">
                                    <div class="box">
                                        <div class="box-header">
                                            <div class="box-name">
                                                <i class="fa fa-briefcase"></i>
                                                <span>Tabla de Usuarios</span>
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
                                            <h5 class="page-header">Usuarios</h5>
                                            <div id="divusuario">

                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="well"> 
                                                            <h4 class="page-header" style="text-align: center;">Lista de Usuarios del Sistema</h4>
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <a class="btn btn-default btn-sm" href="#" onclick="abrirModal()">
                                                                        <img src="img/iconos/Add.png" height="15px" title="Crear nuevo registro"  >
                                                                        <span>Crear Usuario</span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <br/>
                                                            <div id="modalbox">
                                                                <div class="devoops-modal">
                                                                    <div class="devoops-modal-header">
                                                                        <div class="modal-header-name">
                                                                            <span>Basic table</span>
                                                                        </div>
                                                                        <div class="box-icons">
                                                                            <a class="close-link">
                                                                                <i class="fa fa-times"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="devoops-modal-inner">
                                                                    </div>
                                                                    <div class="devoops-modal-bottom">
                                                                    </div>

                                                                </div>
                                                            </div>

                                                            <div class="row" id="divuserypermiso">

                                                            </div>

                                                            <br/>


                                                            <div class="row" style="font-size: 11px;">
                                                                <div class="col-lg-12">
                                                                    <div class="box">
                                                                        <div class="box-header">
                                                                            <div class="box-name">
                                                                                <i class="fa fa-users"></i>
                                                                                <span>Usuarios de Intranet</span>
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
                                                                                        <th>NRO.</th>   
                                                                                        <th>TITULAR</th>
                                                                                        <th>USUARIO</th>
                                                                                        <th>CLAVE</th>
                                                                                        <th>VENDEDOR</th>
                                                                                        <th>ASESOR COMERCIAL</th>
                                                                                        <th>ASESOR TECNICO</th>
                                                                                        <th>ACTIVO</th>
                                                                                        <th>OPCIONES</th>                            
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <?php
                                                                                    if (count($lista) > 0) {
                                                                                        $i = 0;
                                                                                        foreach ($lista as $value) {
                                                                                            $i++;
                                                                                            $activo = 'SI';
                                                                                            $coduse = trim($value["coduse"]);
                                                                                            if ($value['activo'] == 'f') {
                                                                                                $activo = 'NO';
                                                                                            }
                                                                                            ?>
                                                                                            <tr style="">
                                                                                                <td width="5%"><?php echo $i ?></td>
                                                                                                <td width=""><?php echo $value['desuse']; ?></td>
                                                                                                <td width=""><?php echo $value['coduse']; ?></td>
                                                                                                <td width=""><?php echo $value['pwduse']; ?></td>
                                                                                                <td width=""><?php echo $value['vendedor']; ?></td>
                                                                                                <td width=""><?php echo $value['vc']; ?></td>
                                                                                                <td width=""><?php echo $value['vt']; ?></td>
                                                                                                <td width=""><?php echo $activo; ?></td>
                                                                                                <td width="" align="center">
                                                                                                    <a onclick="cargar('#divuserypermiso', '_usuario_editar.php?id=<?php echo trim($coduse); ?>')" href="#" title="Modificar usuario" class="btn btn-default"><span class="fa fa-edit txt-info"></span></a>
                                                                                                    <a onclick="return confirmSubmit()" href="javascript:cargar('#divuserypermiso', '_usuario_elim.php?id=<?php echo trim($coduse); ?>')" title="Eliminar usuario" class="btn btn-danger"><span class="fa fa-trash-o"></span></a>
                                                                                                </td>                               
                                                                                            </tr>
                                                                                            <?php
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                                </tbody>
                                                                            </table>
                                                                            <br/>
                                                                            <br/>
                                                                            <div id="result2"></div>
                                                                        </div>
                                                                    </div>                                
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
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




                    function abrirModal() {

                        var header = 'Crear nuevo usuario';
                        var form = $('<form id="form_reguser" name="form_reguser" action="#" method="post" enctype="multipart/form-data">' +
                                '<div class="form-group">' +
                                '<label class="col-md-4 control-label">Nombre Completo</label><div class="col-md-8"><input type="text" class="form-control" name="desuse" /></div>' +
                                '</div>' +
                                '<div class="form-group">' +
                                '<label class="col-md-4 control-label">Usuario</label><div class="col-md-8"><input type="text" class="form-control" name="coduse" /></div>' +
                                '</div>' +
                                '<div class="form-group">' +
                                '<label class="col-md-4 control-label">Contraseña</label><div class="col-md-8"><input type="password" class="form-control" name="pwduse" /></div>' +
                                '</div>' +
                                '<div class="form-group">' +
                                '<div class="col-md-12 text-center"><button type="submit" id="event_submit" class="btn btn-success">Enviar</button></div>' +
                                '</div>' +
                                '<input type="hidden" name="accion" value="RegUsuario2" />' +
                                '<div id="result"></div>');
                        var button = $('<button id="event_cancel" type="cancel" class="btn btn-danger btn-label-left">' +
                                '<span><i class="fa fa-clock-o txt-danger"></i></span>' +
                                'Cancel' +
                                '</button>' +
                                '<button type="submit" id="event_submit2" class="btn btn-success btn-label-left pull-right">' +
                                '<span><i class="fa fa-clock-o"></i></span>' +
                                'Enviar' +
                                '</button>' +
                                '</form>');
                        OpenModalBox(header, form, button);
                        $('#event_cancel').on('click', function () {
                            CloseModalBox();
                        });
                        $('#event_submit2').on('click', function () {

                            alert('Aun no entro al form');

                            $("#form_reguser").submit(function (e) {
                                e.preventDefault();
                                var f = $(this);
                                aler('Hola');
                                var formData = new FormData(document.getElementById("form_reguser"));

                                $.ajax({
                                    url: "../controller/C_Usuario.php",
                                    type: "post",
                                    dataType: "html",
                                    data: formData,
                                    cache: false,
                                    contentType: false,
                                    processData: false
                                })
                                        .done(function (res) {
                                            $("#result").html(res);
                                            //location.reload();
                                        });
                            });

                            CloseModalBox();
                        });
                    }
                </script>
            </body>
        </html>
        <?php
    }
} else {
    header("Location:recursos/logout.php");
}
?>




<!--<script src="js/devoops.js"></script>-->

