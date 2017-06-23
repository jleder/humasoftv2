<?php
header("Cache-Control: no-cache, must-revalidate");
$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["conectado"])) {
    if ($_SESSION["conectado"] == 'SI') {
        include '../controller/C_Propuestas.php';
        $obj = new C_Propuesta();
        $codprop = trim($_GET['codprop']);
        $obj->__set('codprop', $codprop);
        $lista = $obj->getArchivoByCodProp();
        $info = $obj->getPropuestasxAprobGerenteByCod();

        $nomcliente = $info[2];
        $nomvendedor = $info[8];
        $cultivo = $info[10];
        $codvendedor = $info[22];

        $getJefe = '';
        $correo_vend = '';
        $correo_jefe = '';

        $obj->codvendedor = $codvendedor;
        $getVendedor = $obj->getCorreoByCodVendedor();
        $codjefe = $getVendedor[4];
        $correo_vend = $getVendedor[3];
        if ($codjefe <> '0') {
            $obj->codvendedor = $codjefe;
            $obj->__set('codvendedor', $codjefe);
            $getJefe = $obj->getCorreoByCodVendedor();
            $correo_jefe = trim($getJefe[3]);
        }
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
                                        <li><a href="#">Archivos </a></li>
                                    </ol>
                                </div>
                            </div>

                            <div class="row">                        
                                <div class="col-xs-12 col-sm-12">
                                    <div class="box">
                                        <div class="box-header">
                                            <div class="box-name">
                                                <i class="fa fa-briefcase"></i>
                                                <span>(A.T.) Archivos de la Propuesta:</span>
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
                                            <h5 class="page-header">Datos de Viático</h5>
                                            <div class="row">
                                                <div class="col-lg-7">
                                                    <form id="upload_file" name="upload_file" action="#" method="POST" enctype="multipart/form-data" >
                                                        <h3>Archivos Subidos para esta Propuesta</h3>
                                                        <input type="hidden" name="codprop" value="<?php echo $codprop; ?>" />
                                                        <input type="hidden" name="accion" value="UploadFile" />
                                                        <div class="row">
                                                            <div class="col-lg-5">
                                                                <select name="descripcion" id="descripcion" class="form-control input-sm">
                                                                    <option value="PROPUESTA EN PDF">Propuesta en PDF</option>
                                                                    <option value="PROPUESTA EN WORD">Propuesta en WORD</option>
                                                                    <option value="PROPUESTA EN EXCEL">Propuesta en EXCEL</option>
                                                                    <option value="GUIA ORDEN DE COMPRA">Orden de Compra</option>
                                                                    <option value="FACTURA">Factura</option>
                                                                    <option value="GUIA DE REMISION">Guia de Remision</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-5">
                                                                <input type="file" name="archivo" />
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <input class="btn btn-success btn-sm" type="submit" value="Subir" />
                                                            </div>
                                                        </div>                
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6" id="resultado">
                                                </div>
                                            </div>                                            
                                            <hr/>
                                            <div class="row">
                                                <div class="col-lg-9">
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
                                                            //$lista = $rec->listar_aarecurso_all();
                                                            $i = 1;
                                                            $narchivos = count($lista);
                                                            if ($narchivos > 0) {
                                                                foreach ($lista as $valor) {
                                                                    ?>
                                                                    <tr>
                                                                        <th style="text-align: center;"><?php echo $i; ?></th>
                                                                        <th><?php echo $valor['codigo']; ?></th>
                                                                        <th><?php echo $valor['descripcion']; ?></th>
                                                                        <th><?php echo $valor['url']; ?></th>
                                                                        <th><a target="_blank" href="archivos/propuestas/<?php echo $valor['url'] ?>" ><?php echo $valor['url'] ?></a> </th>
                                                                        <th>                                
                                                                            <a onClick="return confirmSubmit()" href="javascript:cargar('#divuserypermiso', '_adm_recurso_elim.php?id_recurso=<?php echo trim($valor['id_recurso']); ?>')" title="Eliminar Archivo"><img src="img/iconos/delete.png" /></a>
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
                                            <div class="row">
                                                <div class="col-md-6 form-horizontal" id="result_mail" >
                                                    <form id="send_mail_at" name="send_mail_at" action="#" method="POST" enctype="multipart/form-data" >
                                                        <div class="panel panel-primary" style="background: whitesmoke; font-size: 0.8em;">
                                                            <div class="panel-heading">
                                                                Enviar Correo con archivos adjuntos.
                                                                <button type="button" class="btn btn-default" onclick="prueba2()">Click me!</button>
                                                            </div>
                                                            <div class="panel-body">
                                                                <div class="form-group">
                                                                    <label class="col-md-3 control-label">Tu Nombre:</label>
                                                                    <div class="col-md-9"><input type="text" class="form-control" name="mailnom" id="mailnom" value="<?php echo $_SESSION['nombreUsuario']; ?>" placeholder="Anonimo" /></div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="col-md-3 control-label">Tu Correo:</label>
                                                                    <div class="col-md-9"><input type="email" class="form-control" name="mailde" id="mailde" value="<?php echo $_SESSION['email_usuario']; ?>" placeholder="tucorreo@ejemplo.com" /></div>
                                                                </div>
                                                                <div class="form-group" id="divmailpara">
                                                                    <label class="col-md-3 control-label">Para:</label>
                                                                    <div class="col-md-9">                                                                                                                                                               
                                                                        <input type="email" id="mailpara" class="form-control"  name="mailpara" value="acomercial@agromicrobiotech.com" placeholder="usuario1@ejemplo.com; usuario2@ejemplo.com" />
                                                                    </div>                           
                                                                </div>                                                                
                                                                <div class="form-group">
                                                                    <label class="col-md-3 control-label">Mensaje:</label>
                                                                    <div class="col-lg-9">
                                                                        <textarea placeholder="Escriba un Mensaje" class="form-control" id="mailmsj" name="mailmsj" rows="4" cols="20"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel-footer text-right">
                                                                <input type="hidden" name="narchivos" id="narchivos" value="<?php echo $narchivos; ?>" />
                                                                <input type="hidden" name="accion" value="sendmailATaAC" />
                                                                <input type="hidden" name="m_codprop" value="<?php echo $codprop; ?>" />
                                                                <input type="hidden" name="m_nomcliente" value="<?php echo $nomcliente; ?>" />
                                                                <input type="hidden" name="m_nomvendedor" value="<?php echo $nomvendedor; ?>" />
                                                                <input type="hidden" name="m_cultivo" value="<?php echo $cultivo; ?>" />
                                                                <button type="submit" class="btn btn-warning"><i class="fa fa-mail-forward"></i> Enviar Mail</button>
                                                            </div>
                                                        </div>
                                                    </form>
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
                    $(document).ready(function () {

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
                                        $("#resultado").html(res);
                                    });
                        });
                        $("#send_mail_at").submit(function (e) {
                            if (validarCorreo()) {
                                e.preventDefault();
                                var f = $(this);
                                var formData = new FormData(document.getElementById("send_mail_at"));
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
                                            $("#result_mail").html(res);
                                        });
                            }
                        });
                    });
                    function prueba() {
                        $.alert({
                            title: 'Alert!',
                            content: 'Simple alert!',
                        });
                    }

                    function prueba2() {
                        $.confirm({
                            title: 'Confirmar!',
                            content: '¿Desea eliminar este registro?',
                            buttons: {
                                Eliminar: {
                                    btnClass: 'btn-purple',
                                    action: function () {
                                        $.alert('Si!');
                                    }
                                },
                                Cancelar: function () {
                                    $.alert('No!');
                                },
                                somethingElse: {
                                    text: 'Something else',
                                    btnClass: 'btn-blue',
                                    keys: ['enter', 'shift'],
                                    action: function () {
                                        $.alert('Something else?');
                                    }
                                }
                            }
                        });
                    }

                    function validarCorreo() {
                        var narchivos = $("#narchivos").val();
                        if (narchivos === '0') {


                            var agree = confirm("¿Desea enviar el correo sin ningun archivo adjunto?");
                            if (agree)
                                return true;
                            else
                                return false;
                        } else {
                            return true;
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
?>