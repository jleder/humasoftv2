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
        $codprop = $_GET['codprop'];
        $obj->codprop = $codprop;
        $hoy = date("d-m-Y");
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
                                        <li><a href="#">Detalles Comerciales</a></li>
                                    </ol>
                                </div>
                            </div>

                            <div class="row">                        
                                <div class="col-xs-7 col-sm-7">
                                    <div class="box">
                                        <div class="box-header">
                                            <div class="box-name">
                                                <i class="fa fa-briefcase"></i>
                                                <span>Estado Comercial</span>
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
                                                <div class="col-md-12" id="bodytable2">                                                                                                            
                                                    <button type="button" class="btn btn-primary" onclick="agregarEstadoComercial()">Agregar Estado</button>
                                                    <p class="col-md-12" id="result_estado"></p>
                                                    <table class="table table-striped" style=" padding: 5px; font-size: 10px;">
                                                        <thead>
                                                            <tr style="color: #000; background-color: #e7eaea;">
                                                                <th></th>
                                                                <th>Fecha</th>
                                                                <th>Estado</th>
                                                                <th>Observaciones</th>
                                                                <th></th>                                                
                                                            </tr>                    
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $ecom = new C_EstadoComercial();

                                                            $ecom->__set('codprop', $codprop);
                                                            $lista = $ecom->listar_propdb16_all_by_codprop();
                                                            if (count($lista) > 0) {
                                                                $i = 0;
                                                                foreach ($lista as $valor) {
                                                                    $i++;
                                                                    ?>                        
                                                                    <tr>
                                                                        <td><?php echo $i; ?></td>
                                                                        <td><?php echo date("d/m/Y", strtotime($valor['fecha'])); ?></td>
                                                                        <td><?php echo $valor['estado'] ?></td>
                                                                        <td><?php echo $valor['obs'] ?></td>                                        
                                                                        <td>                                                                            
                                                                            <button type="button" class="btn btn-default" onclick="eliminarEstadoComercial(<?php echo trim($valor['codestado']); ?>)" title="Eliminar Estado Comercial"><img src="img/iconos/trash.png" height="15" /></button>
                                                                        </td>                                    
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            } else {
                                                                echo '<tr>';
                                                                echo '<td colspan="5">No se encontraron datos.</td>';
                                                                echo '</tr>';
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-5 col-sm-5">
                                    <div class="box">
                                        <div class="box-header">
                                            <div class="box-name">
                                                <i class="fa fa-file-text-o"></i>
                                                <span>Detalles de Propuesta</span>
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
                                            <?php
                                            $info = $obj->getPropuestasxAprobGerenteByCod();

                                            $nomcliente = $info[2];
                                            $fecelaboracion = $info[4];
                                            $contactos = $info[5];
                                            $nomvendedor = $info[8];
                                            $cultivo = $info[10];
                                            $codvendedor = $info[22];
                                            ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                            <tr>
                                                                <td>Código</td>
                                                                <td>
                                                                    <input type="hidden" name="codprop" id="codprop" value="<?php echo $codprop; ?>" />
                                                                    <?php echo $codprop; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Fecha Elaboración</td>
                                                                <td>
                                                                    <input type="hidden" name="fecelaboracion" id="fecelaboracion" value="<?php echo $fecelaboracion ?>" />
                                                                    <?php echo date("d.m.Y", strtotime($fecelaboracion)); ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Cliente</td>
                                                                <td>
                                                                    <input type="hidden" name="nomcliente" id="nomcliente" value="<?php echo $nomcliente; ?>" />
                                                                    <?php echo $nomcliente; ?>
                                                                </td>
                                                            </tr>                                                            
                                                            <tr>
                                                                <td>Asesor</td>
                                                                <td>
                                                                    <input type="hidden" name="nomvendedor" id="nomvendedor" value="<?php echo $nomvendedor; ?>" />
                                                                    <?php echo $nomvendedor; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Cultivo</td>
                                                                <td>
                                                                    <input type="hidden" name="cultivo" id="cultivo" value="<?php echo $cultivo; ?>" />
                                                                    <?php echo $cultivo; ?>
                                                                </td>
                                                            </tr>                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">                        
                                <div class="col-xs-12 col-sm-12">
                                    <div class="box">
                                        <div class="box-header">
                                            <div class="box-name">
                                                <i class="fa fa-paperclip"></i>
                                                <span>Archivos</span>
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
                                                    <button type="button" class="btn btn-primary" onclick="agregarArchivo()">Agregar Archivo</button>
                                                    <p id="result_archivos"></p>
                                                    <table class="table table-striped" style=" padding: 5px; font-size: 10px;">
                                                        <thead>
                                                            <tr style="color: white; background-color: #1da8f4;">
                                                                <th></th>
                                                                <th>Código Propuesta</th>
                                                                <th>Tipo de Archivo</th>
                                                                <th>Nombre de Archivo</th>
                                                                <th></th>                            
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $listaFiles = $obj->getArchivoByCodProp();
                                                            $i = 1;

                                                            $narchivos = count($listaFiles);
                                                            if ($narchivos > 0) {
                                                                foreach ($listaFiles as $valor) {
                                                                    $url = html_entity_decode($valor["url"]);
                                                                    $codarchivo = $valor["codarchivo"];
                                                                    ?>
                                                                    <tr>
                                                                        <th style="text-align: center;"><?php echo $i; ?></th>
                                                                        <th><?php echo $valor['codigo']; ?></th>
                                                                        <th><?php echo $valor['descripcion']; ?></th>
                                                                        <th><?php echo $valor['url']; ?></th>
                                                                        <th><a target="_blank" href="archivos/propuestas/<?php echo $valor['url'] ?>" ><?php echo $valor['url'] ?></a> </th>
                                                                        <th>                                
                                                                            <button class="btn btn-default" onclick="eliminarArchivo('<?php echo $codarchivo;?>','<?php echo $url;?>' )" title="Eliminar Archivo"><img src="img/iconos/trash.png" height="15" /></button>
                                                                        </th>
                                                                    </tr>
                                                                    <?php
                                                                    $i++;
                                                                }
                                                            } else {
                                                                echo '<tr>';
                                                                echo '<td colspan="5">No se encontraron archivos subidos.<td>';
                                                                echo '</tr>';
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

                            <div class="row">                        
                                <div class="col-xs-12 col-sm-12">
                                    <div class="box">
                                        <div class="box-header">
                                            <div class="box-name">
                                                <i class="fa fa-truck"></i>
                                                <span>Despachos</span>
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
                                                <div class="col-lg-12">                
                                                    <button type="button" class="btn btn-primary" onclick="agregarDespacho()">Agregar Despacho</button>
                                                    <p class="col-md-12" id="result_despacho"></p>
                                                    <table class="table table-striped" style=" padding: 5px; font-size: 10px;">
                                                        <thead>
                                                            <tr style="color: white; background-color: #1da8f4;">
                                                                <th></th>
                                                                <th>Fecha Registro</th>
                                                                <th>Código Propuesta</th>
                                                                <th>Despacho</th>
                                                                <th>Entrega Prevista</th>
                                                                <th>Monto Despachado</th>
                                                                <th>Saldo</th>                            
                                                                <th>Estado</th>
                                                                <th></th>                                                
                                                            </tr>                    
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $desp = new C_Despacho();
                                                            $desp->codprop = $codprop;
                                                            $listaDesp = $desp->despachosByCodprop();
                                                            if (count($listaDesp) > 0) {
                                                                $i= 0;
                                                                foreach ($listaDesp as $valor) {
                                                                    $i++;
                                                                    ?>                        
                                                                    <tr>
                                                                        <td><?php echo $i; ?></td>
                                                                        <td><?php echo date("d/m/Y", strtotime($valor['fecreg'])); ?></td>
                                                                        <td><?php echo $valor['codprop'] ?></td>                                
                                                                        <td><?php echo $valor['descripcion'] ?></td>
                                                                        <td><strong><?php echo date("d/m/Y", strtotime($valor['fecprev'])); ?></strong></td>
                                                                        <td style="text-align:center;"><?php echo $valor['moneda'] . $valor['montodesp'] ?></td>
                                                                        <td style="text-align:center;"><?php echo $valor['moneda'] . $valor['saldo'] ?></td>                                
                                                                        <td></td>
                                                                        <td>
                                                                            <a class="btn btn-default" href="#" onclick="javascript:cargar('#divdespacho', '_propuestav2_despacho_edit.php?coddesp=<?php echo trim($valor['coddesp']); ?>')" title="Modificar Estado Comercial"><img src="img/iconos/edit.png" height="15" /></a>
                                                                            <button type="button" class="btn btn-default" onclick="eliminarDespacho('<?php echo trim($valor['coddesp']); ?>','0', '1')" title="Eliminar Despacho"><img src="img/iconos/trash.png" height="15" /></button>
                                                                        </td>                                    
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            } else {
                                                                ?>
                                                                <tr>
                                                                    <td colspan="9">No hay datos</td>
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
                            <div class="row">                        
                                <div class="col-xs-12 col-sm-12">
                                    <div class="box">
                                        <div class="box-header">
                                            <div class="box-name">
                                                <i class="fa fa-envelope"></i>
                                                <span>Enviar Correo Electrónico</span>
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
                                                <div class="col-md-6">
                                                    <?php
                                                    $getJefe = '';
                                                    $correo_vend = '';
                                                    $correo_jefe = '';

                                                    //Obtener correo de vendedor
                                                    if ($codvendedor <> '') {
                                                        $obj->codvendedor = $codvendedor;
                                                        $getVendedor = $obj->getCorreoByCodVendedor();
                                                        $correo_vend = trim($getVendedor[3]);

                                                        //obtener correo de jefe de zona
                                                        $codjefe = $getVendedor[4];
                                                        //Buscar si tiene jefe
                                                        if ($codjefe <> '0') {
                                                            $obj->codvendedor = $codjefe;
                                                            $obj->__set('codvendedor', $codjefe);
                                                            $getJefe = $obj->getCorreoByCodVendedor();
                                                            $correo_jefe = trim($getJefe[3]);
                                                        }
                                                    }
                                                    ?>

                                                    <p class="text-center">
                                                        <img class="img-rounded" src="img/iconos/clientes2.png" height="80" />
                                                    </p>
                                                    <p class="alert alert-info text-center">                                                        
                                                        <!--<img class="img-rounded" src="img/iconos/clientes2.png" height="80" />-->
                                                        Enviar correo a <strong>Vendedor</strong> adjunto con la Propuesta en PDF.
                                                        <br/><br/>  
                                                        <button type="button" class="btn btn-primary" onclick="mailToVendedor()">Enviar Mail</button>
                                                    </p>  
                                                    <p id="result_mail_vend"></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="text-center">
                                                        <img class="img-rounded" src="img/iconos/icon-car2.png" height="80" />
                                                    </p>
                                                    <p class="alert alert-warning text-center">
                                                        Enviar correo a <strong>Área de Despacho</strong> adjunto con la Orden de Compra del Cliente.
                                                        <br/><br/>  
                                                        <button type="button" class="btn btn-primary" onclick="mailToDespacho()">Enviar Mail</button>
                                                    </p>
                                                    <p id="result_mail_desp"></p>
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
                        $("#upload_file").submit(function (e) {
                            e.preventDefault();
                            var f = $(this);
                            var formData = new FormData(document.getElementById("upload_file"));
                            $.ajax({
                                url: "../controller/C_Propuestas.php",
                                type: "post",
                                dataType: "html",
                                data: formData,
                                cache: false,
                                contentType: false,
                                processData: false
                            })
                                    .done(function (res) {
                                        $("#result_archivos").html(res);
                                        location.reload();
                                    });
                        });
                    });
                    function validarEstadoComercial() {
                        var estado = $("#estado").val();
                        var estado2 = $("#estado2").val();
                        if (estado === 'OTRO' && estado2 === '') {
                            $("#estado2").focus();
                            $.alert({
                                title: 'Atención!',
                                content: 'Debe escribir el estado!'
                            });
                            return false;
                        }
                        return true;
                    }

                    function verificarEstadoComercial() {
                        var estado = $("#estado").val();
                        if (estado === 'OTRO') {
                            $("#divestado").show();
                        } else if (estado !== 'OTRO') {
                            $("#divestado").hide();
                        }
                    }

                    function agregarEstadoComercial() {
                        var header = 'Registrar Estado Comercial';
                        var form = $(
                                '<form id="form_ec_reg" name="form_ec_reg" action="#" method="post" enctype="multipart/form-data">' +
                                '<div class="row">' +
                                '<input type = "hidden" name = "codprop" placeholder="codprop" value = "<?php echo $codprop; ?>" class="form-control" id="codprop" />' +
                                '<div class="col-lg-12">' +
                                'Fecha<input type = "date" name = "fecha" placeholder="fecha" value = "" class="form-control" id="fecha" />' +
                                '</div>' +
                                '</div>' +
                                '<div class="row">' +
                                '<div class="col-lg-12">' +
                                'Estado' +
                                '<select name="estado" id="estado" class="form-control" onchange="verificarEstadoComercial()" >' +
                                '<option value="EN VENDEDOR">EN VENDEDOR</option>' +
                                '<option value="EN CLIENTE">EN CLIENTE</option>' +
                                '<option value="EN SEGUIMIENTO">EN SEGUIMIENTO</option>' +
                                '<option value="APROBADO">APROBADO</option>' +
                                '<option value="NO APROBADO">NO APROBADO</option>' +
                                '<option value="OTRO">OTRO</option>' +
                                '</select>' +
                                '</div>' +
                                '</div>' +
                                '<div class="row" id="divestado" style="display: none;">' +
                                '<div class="col-lg-12">' +
                                'Escribir nuevo Estado Comercial' +
                                '<input type="text" class="form-control" name="estado2" id="estado2" maxlength="50" />' +
                                '</div>' +
                                '</div>' +
                                '<div class="row">' +
                                '<div class="col-lg-12">' +
                                'Observaciones:' +
                                '<textarea name="obs" id="obs" rows="4" cols="20" class="form-control"></textarea>' +
                                '</div>' +
                                '</div>' +
                                '</form>');
                        var button = $('<button id="cancelar_estado" type="cancel" class="btn btn-danger btn-label-left">' +
                                '<span><i class="fa fa-clock-o txt-danger"></i></span>' +
                                'Cancelar' +
                                '</button>' +
                                '<button type="submit" id="submit_estado" class="btn btn-success btn-label-left pull-right">' +
                                '<span><i class="fa fa-clock-o"></i></span>' +
                                'Enviar' +
                                '</button>');
                        OpenModalBox(header, form, button);
                        $('#cancelar_estado').on('click', function () {
                            CloseModalBox();
                        });
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
                    }

                    function agregarArchivo() {
                        var header = 'Agregar Archivo';
                        var form = $(
                                '<form id="upload_file" name="upload_file" action="#" method="POST" enctype="multipart/form-data" >' +
                                '<input type="hidden" name="codprop" value="<?php echo $codprop; ?>" />' +
                                '<input type="hidden" name="accion" value="UploadFile" />' +
                                '<div class="form-group">' +
                                '<label class="col-md-4 control-label">Tipo de Archivo</label><div class="col-md-8">' +
                                '<select name="descripcion" id="descripcion" class="form-control input-sm">' +
                                '<option value="PROPUESTA EN PDF">Propuesta en PDF</option>' +
                                '<option value="PROPUESTA EN WORD">Propuesta en WORD</option>' +
                                '<option value="PROPUESTA EN EXCEL">Propuesta en EXCEL</option>' +
                                '<option value="GUIA ORDEN DE COMPRA">Orden de Compra</option>' +
                                '<option value="FACTURA">Factura</option>' +
                                '<option value="GUIA DE REMISION">Guia de Remision</option>' +
                                '</select>' +
                                '</div>' +
                                '</div>' +
                                '<div class="form-group">' +
                                '<label class="col-md-4 control-label">Archivo</label><div class="col-md-8"><input type="file" name="archivo" /></div>' +
                                '</div>' +
                                '<div class="form-group">' +
                                '<div class="col-md-12 text-center"><br/><br/>' +
                                '<button type="submit" id="submit_file" class="btn btn-success"><i class="fa fa-cloud-upload"></i> Subir</button>' +
                                '</div></div></form>');
                        var button = $('');
                        OpenModalBox(header, form, button);
                    }

                    function agregarDespacho() {
                        var header = 'Nuevo Despacho';
                        var form = $('<form id="form_despacho" name="form_despacho" method="POST" action="#" >' +
                                '<div class="form-group">' +
                                '<label class="col-md-4 control-label">Código Propuesta</label><div class="col-md-8"><input type="text" name="codprop" id="codprop_desp" class="form-control" readonly="" value="<?php echo $codprop; ?>" /></div>' +
                                '</div>' +
                                '<div class="form-group">' +
                                '<label class="col-md-4 control-label">Prioridad</label><div class="col-md-8">' +
                                '<select name="prioridad" id="prioridad" class="form-control">' +
                                '<option value="NORMAL">NORMAL (72hrs)</option>' +
                                '<option value="URGENTE">URGENTE (48hrs)</option>' +
                                '<option value="MUY URGENTE">MUY URGENTE</option>' +
                                '</select> ' +
                                '</div>' +
                                '</div>' +
                                '<div class="form-group">' +
                                '<label class="col-md-4 control-label">Entrega Prevista</label><div class="col-md-8"><input type="date" name="fecprev" id="fecprev" class="form-control" value="<?php echo $hoy; ?>" /></div>' +
                                '</div>' +
                                '<div class="form-group">' +
                                '<label class="col-md-4 control-label">Monto Despachado</label><div class="col-md-8"><input type="number" step="any" name="montodesp" id="montodesp" class="form-control" value="0" /></div>' +
                                '</div>' +
                                '<div class="form-group">' +
                                '<label class="col-md-4 control-label">Saldo</label><div class="col-md-8"><input type="number" step="any" name="saldo" id="saldo" class="form-control" value="0" /></div>' +
                                '</div>' +
                                '<div class="form-group">' +
                                '<label class="col-md-4 control-label">Moneda</label><div class="col-md-8">' +
                                '<select name="moneda" id="moneda" class="form-control">' +
                                '<option value="$">$. DOLAR</option>' +
                                '<option value="S/.">S/. SOLES</option>' +
                                '</select>' +
                                '</div>' +
                                '</div>' +
                                '<div class="form-group">' +
                                '<label class="col-md-4 control-label">Nombre</label><div class="col-md-8"><input type="text" maxlength="90" id="descripcion" name="descripcion" class="form-control" value="" /></div>' +
                                '</div>' +
                                '<div class="form-group">' +
                                '<label class="col-md-4 control-label">Observación</label><div class="col-md-8"><textarea class="form-control" name="obs" id="obs" rows="4" cols="5"></textarea></div>' +
                                '</div>');
                        var button = $('<button id="cancel_despacho" type="cancel" class="btn btn-danger btn-label-left">' +
                                '<span><i class="fa fa-clock-o txt-danger"></i></span>' +
                                'Cancelar' +
                                '</button>' +
                                '<button type="submit" id="submit_despacho" class="btn btn-success btn-label-left pull-right">' +
                                '<span><i class="fa fa-clock-o"></i></span>' +
                                'Enviar' +
                                '</button>' +
                                '</form>');
                        OpenModalBox(header, form, button);
                        $('#cancel_despacho').on('click', function () {
                            CloseModalBox();
                        });
                        $('#submit_despacho').on('click', function () {

                            var codprop = $("#codprop_desp").val();
                            var prioridad = $("#prioridad").val();
                            var fecprevista = $("#fecprev").val();
                            var montodesp = $("#montodesp").val();
                            var saldo = $("#saldo").val();
                            var moneda = $("#moneda").val();
                            var nombre = $("#descripcion").val();
                            var obs = $("#obs").val();
                            var objDespacho = {
                                codprop: codprop,
                                prioridad: prioridad,
                                fecprev: fecprevista,
                                montodesp: montodesp,
                                saldo: saldo,
                                moneda: moneda,
                                descripcion: nombre,
                                obs: obs
                            };
                            //if (validarDespacho()) {
                            $.ajax({
                                url: '../controller/C_Propuestas.php',
                                type: 'post',
                                dataType: 'html',
                                success: function (res) {
                                    $("#result_despacho").html(res);
                                    location.reload();
                                },
                                error: function (jqXHR, status, error) {
                                    alert('Disculpe, existió un problema');
                                },
                                complete: function (jqXHR, status) {

                                    //$("#" + divcomentario).load('_propuestav2_coment_list.php?coditem=' + coditem + '&corredor=' + corredor);

                                },
                                data: {accion: 'RegDespacho', obj: objDespacho}
                            });
                            CloseModalBox();
                            //}
                        });
                    }

                    function mailToVendedor() {
                        var header = 'Enviar Correo a Vendedor';
                        var form = $(
                                '<div class="form-group">' +
                                '<label class="col-md-4 control-label">Tu Nombre:</label><div class="col-md-8"><input type="text" class="form-control" name="mailnom" id="mailnom" value="<?php echo $_SESSION['nombreUsuario']; ?>" placeholder="Anonimo" /></div>' +
                                '</div>' +
                                '<div class="form-group">' +
                                '<label class="col-md-4 control-label">Tu Correo:</label><div class="col-md-8"><input type="email" class="form-control" name="mailde" id="mailde" value="<?php echo $_SESSION['email_usuario']; ?>" placeholder="tucorreo@ejemplo.com" /></div>' +
                                '</div>' +
                                '<div class="form-group">' +
                                '<label class="col-md-4 control-label">Para:</label><div class="col-md-8"><input type="email" id="mailpara" class="form-control"  name="mailpara" value="<?php echo $correo_vend; ?>" placeholder="usuario1@ejemplo.com; usuario2@ejemplo.com" /></div>' +
                                '</div>' +
                                '<div class="form-group">' +
                                '<label class="col-md-4 control-label">CC</label><div class="col-md-8"><input type="email" id="mailcc" name="mailcc" class="form-control" value="<?php echo $correo_jefe; ?>" /></div>' +
                                '</div>' +
                                '<div class="form-group">' +
                                '<label class="col-md-4 control-label">Mensaje</label><div class="col-md-8"><textarea placeholder="Escriba un Mensaje" class="form-control" id="mailmsj" name="mailmsj" rows="4" cols="20"></textarea></div>' +
                                '</div>');
                        var button = $('<button id="cancel_mailvendedor" type="cancel" class="btn btn-danger btn-label-left">' +
                                '<span><i class="fa fa-clock-o txt-danger"></i></span>' +
                                'Cancelar' +
                                '</button>' +
                                '<button type="submit" id="submit_mailvendedor" class="btn btn-success btn-label-left pull-right">' +
                                '<span><i class="fa fa-clock-o"></i></span>' +
                                'Enviar' +
                                '</button>' +
                                '</form>');
                        OpenModalBox(header, form, button);
                        $('#cancel_mailvendedor').on('click', function () {
                            CloseModalBox();
                        });
                        $('#submit_mailvendedor').on('click', function () {

                            var codprop = $("#codprop").val();
                            var mailnom = $("#mailnom").val();
                            var mailde = $("#mailde").val();
                            var mailpara = $("#mailpara").val();
                            var mailcc = $("#mailcc").val();
                            var mailmsj = $("#mailmsj").val();
                            var nomcliente = $("#nomcliente").val();
                            var nomvendedor = $("#nomvendedor").val();
                            var cultivo = $("#cultivo").val();
                            var mailVendedor = {
                                codprop: codprop,
                                mailnom: mailnom,
                                mailde: mailde,
                                mailpara: mailpara,
                                mailcc: mailcc,
                                mailmsj: mailmsj,
                                nomcliente: nomcliente,
                                nomvendedor: nomvendedor,
                                cultivo: cultivo
                            };
                            $.ajax({
                                url: '../controller/C_Propuestas.php',
                                type: 'post',
                                dataType: 'html',
                                success: function (res) {
                                    $("#result_mail_vend").html(res);
                                },
                                error: function (jqXHR, status, error) {
                                    alert('Disculpe, existió un problema');
                                },
                                complete: function (jqXHR, status) {

                                    //$("#" + divcomentario).load('_propuestav2_coment_list.php?coditem=' + coditem + '&corredor=' + corredor);

                                },
                                data: {accion: 'sendmailACaVEND', obj: mailVendedor}
                            });
                            CloseModalBox();
                        });
                    }

                    function mailToDespacho() {
                        var header = 'Enviar Correo a Despacho';
                        var form = $(
                                '<div class="form-group">' +
                                '<label class="col-md-4 control-label">Tu Nombre:</label><div class="col-md-8"><input type="text" class="form-control" name="mailnom_desp" id="mailnom_desp" value="<?php echo $_SESSION['nombreUsuario']; ?>" placeholder="Anonimo" /></div>' +
                                '</div>' +
                                '<div class="form-group">' +
                                '<label class="col-md-4 control-label">Tu Correo:</label><div class="col-md-8"><input type="email" class="form-control" name="mailde_desp" id="mailde_desp" value="<?php echo $_SESSION['email_usuario']; ?>" placeholder="tucorreo@ejemplo.com" /></div>' +
                                '</div>' +
                                '<div class="form-group">' +
                                '<label class="col-md-4 control-label">Para:</label><div class="col-md-8"><input type="email" id="mailpara_desp" class="form-control"  name="mailpara_desp" value="isandoval@agromicrobiotech.com" placeholder="usuario1@ejemplo.com; usuario2@ejemplo.com" /></div>' +
                                '</div>' +
                                '<div class="form-group">' +
                                '<label class="col-md-4 control-label">Mensaje</label><div class="col-md-8"><textarea placeholder="Escriba un Mensaje" class="form-control" id="mailmsj_desp" name="mailmsj_desp" rows="4" cols="20"></textarea></div>' +
                                '</div>');
                        var button = $('<button id="cancel_maildespacho" type="cancel" class="btn btn-danger btn-label-left">' +
                                '<span><i class="fa fa-clock-o txt-danger"></i></span>' +
                                'Cancelar' +
                                '</button>' +
                                '<button type="submit" id="submit_maildespacho" class="btn btn-success btn-label-left pull-right">' +
                                '<span><i class="fa fa-clock-o"></i></span>' +
                                'Enviar' +
                                '</button>' +
                                '</form>');
                        OpenModalBox(header, form, button);
                        $('#cancel_maildespacho').on('click', function () {
                            CloseModalBox();
                        });
                        $('#submit_maildespacho').on('click', function () {

                            var codprop = $("#codprop").val();
                            var mailnom = $("#mailnom_desp").val();
                            var mailde = $("#mailde_desp").val();
                            var mailpara = $("#mailpara_desp").val();
                            var mailmsj = $("#mailmsj_desp").val();
                            var nomcliente = $("#nomcliente").val();
                            var nomvendedor = $("#nomvendedor").val();
                            var cultivo = $("#cultivo").val();
                            alert('Esto es codprop' + codprop);
                            var mailDespacho = {
                                codprop: codprop,
                                mailnom: mailnom,
                                mailde: mailde,
                                mailpara: mailpara,
                                mailmsj: mailmsj,
                                nomcliente: nomcliente,
                                nomvendedor: nomvendedor,
                                cultivo: cultivo
                            };
                            $.ajax({
                                url: '../controller/C_Propuestas.php',
                                type: 'post',
                                dataType: 'html',
                                success: function (res) {
                                    $("#result_mail_desp").html(res);
                                },
                                error: function (jqXHR, status, error) {
                                    alert('Disculpe, existió un problema');
                                },
                                complete: function (jqXHR, status) {

                                    //$("#" + divcomentario).load('_propuestav2_coment_list.php?coditem=' + coditem + '&corredor=' + corredor);

                                },
                                data: {accion: 'sendmailACaDESP', obj: mailDespacho}
                            });
                            CloseModalBox();
                        });
                    }

                    function eliminarEstadoComercial(codestado) {

                        $.confirm({
                             icon: 'fa fa-spinner fa-spin',                            
                            title: 'Confirmar!',
                            content: '¿Desea eliminar este estado?',
                            buttons: {
                                OK: {
                                    text: 'ELIMINAR',
                                    btnClass: 'btn-red',
                                    keys: ['enter', 'shift'],
                                    action: function () {
                                        $.ajax({
                                            url: '_propuestav2_ecomercial_elim.php',
                                            type: 'GET',
                                            dataType: 'html',
                                            success: function (res) {
                                                $("#result_estado").html(res);
                                                location.reload();
                                            },
                                            error: function (jqXHR, status, error) {
                                                alert('Error al enviar datos');
                                            },
                                            complete: function (jqXHR, status) {
                                                //$("#" + divcomentario).load('_propuestav2_coment_list.php?coditem=' + coditem + '&corredor=' + corredor);
                                            },
                                            data: {codestado: codestado}
                                        });
                                    }
                                },
                                CANCELAR: function () {
                                    $.alert('Cancelado!');
                                }
                            }
                        });                        
                    }
                    
                    function eliminarArchivo(codarchivo, url) {

                        $.confirm({
                             icon: 'fa fa-spinner fa-spin',                            
                            title: 'Confirmar!',
                            content: '¿Desea eliminar este Archivo?',
                            buttons: {
                                OK: {
                                    text: 'ELIMINAR',
                                    btnClass: 'btn-red',
                                    keys: ['enter', 'shift'],
                                    action: function () {
                                        $.ajax({
                                            url: '_propuestav2_archivo_elim.php',
                                            type: 'GET',
                                            dataType: 'html',
                                            success: function (res) {
                                                $("#result_archivos").html(res);
                                                location.reload();
                                            },
                                            error: function (jqXHR, status, error) {
                                                alert('Error al enviar datos');
                                            },
                                            complete: function (jqXHR, status) {
                                                //$("#" + divcomentario).load('_propuestav2_coment_list.php?coditem=' + coditem + '&corredor=' + corredor);
                                            },
                                            data: {codarchivo: codarchivo, url: url}
                                        });
                                    }
                                },
                                CANCELAR: function () {
                                    $.alert('Cancelado!');
                                }
                            }
                        });                        
                    }
                    
                    function eliminarDespacho(coddesp, coddetalle, tipo) {

                        $.confirm({
                             icon: 'fa fa-spinner fa-spin',                            
                            title: 'Confirmar!',
                            content: '¿Desea eliminar este Despacho?',
                            buttons: {
                                OK: {
                                    text: 'ELIMINAR',
                                    btnClass: 'btn-red',
                                    keys: ['enter', 'shift'],
                                    action: function () {
                                        $.ajax({
                                            url: '_propuestav2_despacho_elim.php',
                                            type: 'GET',
                                            dataType: 'html',
                                            success: function (res) {
                                                $("#result_despacho").html(res);
                                                location.reload();
                                            },
                                            error: function (jqXHR, status, error) {
                                                alert('Error al enviar datos');
                                            },
                                            complete: function (jqXHR, status) {
                                                //$("#" + divcomentario).load('_propuestav2_coment_list.php?coditem=' + coditem + '&corredor=' + corredor);
                                            },
                                            data: {cod1: coddesp, cod2: coddetalle, tipo: tipo}
                                        });
                                    }
                                },
                                CANCELAR: function () {
                                    $.alert('Cancelado!');
                                }
                            }
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