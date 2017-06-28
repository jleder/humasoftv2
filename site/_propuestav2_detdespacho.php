<?php
header("Cache-Control: no-cache, must-revalidate");
$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["conectado"])) {
    if ($_SESSION["conectado"] == 'SI') {
        date_default_timezone_set("America/Bogota");
        include_once '../controller/C_Propuestas.php';
        $pro = new C_Propuesta();
        $desp = new C_Despacho();
        $detd = new C_DetalleDespacho();

//$hoy = $obj->obtFechadeHoy();
        $codprop = $_GET['codprop'];
        $pro->__set('codprop', $codprop);
        $detprop = $pro->getPropuestasxAprobGerenteByCod();
        $hoy = date("Y");
        ?>
        <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="utf-8">
                <title>Humasoft</title>
                <meta name="description" content="description">
                <meta name="author" content="Juan">
                <?php include 'head.php'; ?>   
                <style type="text/css">                                
                    .centro { text-align: center;}
                    #form_reg {
                        font-family: inherit; font-size: smaller;
                    }

                    .derecha {text-align: right; }
                    .tablinha { border: solid 1.5px; }
                    .tablinha td, th { padding: 5px;}
                    .subtitulo { color: #000077; font-size: small;}
                    #portapdf { 
                        width: 100%; 
                        height: 500px; 
                        border: 1px solid #484848; 
                        margin: 0 auto; 
                    } 
                    .entregado { background-color: #9de9a2; }
                    .noentregado { background-color: #f2f2f1;; }            

                    .panel-heading label { font-size: 1.5em;}
                    .panel-body { font-size: 1.2em;}
                </style> 
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
                                        <li><a href="#">Despachos x Propuesta</a></li>
                                    </ol>
                                </div>
                            </div>
                            <div class="row">
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
                                            $info = $pro->getPropuestasxAprobGerenteByCod();

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
                                                            <tr>
                                                                <td>Forma de Pago</td>
                                                                <td>                                                                    
                                                                    <?php
                                                                    if (!empty($detprop[18])) {
                                                                        echo $detprop[18];
                                                                    } else {
                                                                        echo 'No Definido';
                                                                    }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Observaciones</td>
                                                                <td>                                                                    
                                                                    <?php echo $detprop[17]; ?>
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
                                                            $listaFiles = $pro->getArchivoByCodProp();
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
                                                                            <button class="btn btn-default" onclick="eliminarArchivo('<?php echo trim($codarchivo); ?>', '<?php echo trim($url); ?>')" title="Eliminar Archivo"><img src="img/iconos/trash.png" height="15" /></button>
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
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h4>Información de Despachos</h4>
                                                    <?php
                                                    $desp->codprop = $codprop;
                                                    $listdesp = $desp->despachosByCodprop();
                                                    if (count($listdesp)) {
                                                        $c = 0;
                                                        foreach ($listdesp as $despachos) {
                                                            $detd->__set('coddesp', $despachos['coddesp']);
                                                            $estdespacho = $detd->getLastDetDespByCoddesp();
                                                            $colorestilo = '';
                                                            $estado = '';
                                                            if ($estdespacho) {
                                                                if ($estdespacho[3] == 'ENTREGADO') {
                                                                    $colorestilo = '#9de9a2';
                                                                    $estado = $estdespacho[3];
                                                                } else {
                                                                    $colorestilo = '#f2f2f1';
                                                                    $estado = $estdespacho[3];
                                                                }
                                                            } else {
                                                                $colorestilo = '#f2f2f1';
                                                                $estado = '<span style="color: orange;">Desconocido</span></p>';
                                                            }

                                                            $c++;
                                                            ?>
                                                            <div class="row" style="background-color: <?php echo $colorestilo; ?>; padding: 5px;"> 
                                                                <div class="col-lg-4">                                            
                                                                    Despacho: <?php echo $despachos['descripcion']; ?><br/>
                                                                </div>
                                                                <div class="col-lg-8">                                            
                                                                    Estado: 
                                                                    <?php
                                                                    echo $estado;
                                                                    ?>
                                                                </div>
                                                            </div>
                                                            <div class="row"> 
                                                                <div class="col-lg-5"> 
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <table class="table table-bordered" style="font-size: 10px;">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>Entrega Prevista</td>
                                                                                        <td><?php echo date("d/m/Y", strtotime($despachos['fecprev'])); ?></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>Prioridad</td>
                                                                                        <td><?php echo $despachos['prioridad']; ?></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>Monto a Despachar</td>
                                                                                        <td><?php echo $despachos['moneda'] . number_format($despachos['montodesp'], 2); ?></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>Saldo</td>
                                                                                        <td><?php echo $despachos['moneda'] . number_format($despachos['saldo'], 2); ?></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>Observaciones</td>
                                                                                        <td><?php echo $despachos['obs']; ?></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table> 
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-12 text-center">
                                                                            <a class="btn btn-default" href="#divdespacho" onclick="javascript:cargar('#divdespacho', '_propuestav1_despacho_edit.php?cod=<?php echo trim($despachos['coddesp']); ?>')" title="Modificar">
                                                                                <img src="img/iconos/edit.png" height="15" /> Modificar
                                                                            </a>                                                                                                                                         
                                                                            <button type="button" class="btn btn-default" onclick="eliminarDespacho('<?php echo trim($despachos['coddesp']); ?>', '0', '1')" title="Eliminar Despacho"><img src="img/iconos/trash.png" height="15" /> Eliminar</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-7">                                            
                                                                    <p><i>Seguimiento de este Despacho</i></p>
                                                                    <table class="table table-condensed" style="font-size: 10px; width: 100%;">
                                                                        <thead>
                                                                            <tr style="background-color: #f2f2f1;">                                                                                                                                                                                
                                                                                <th>ESTADO DESPACHO</th>
                                                                                <th>FECHA ESTADO</th>
                                                                                <th>OBSERVACIONES</th>                                                        
                                                                                <th><i class="fa fa-cogs"></i></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $lista = $detd->getDetDespByCoddesp();
                                                                            if (count($lista)) {
                                                                                foreach ($lista as $value) {
                                                                                    ?>
                                                                                    <tr>                                                                        
                                                                                        <td><?php echo $value['estado']; ?></td>
                                                                                        <td><?php echo date("d/m/Y", strtotime($value['fecha'])); ?></td>
                                                                                        <td><?php echo $value['obs']; ?></td>                                                                
                                                                                        <td>
                                                                                            <a class="btn btn-default" href="#divdespacho<?php echo $c; ?>" onclick="javascript:cargar('#divdespacho<?php echo $c; ?>', '_propuestav1_detdesp_edit.php?cod=<?php echo trim($value['codigo']); ?>')" title="Modificar">
                                                                                                <img src="img/iconos/edit.png" height="10" />
                                                                                            </a>
                                                                                            <a class="btn btn-default" onClick="return confirmSubmit()" href="javascript:cargar('#principal', '_propuestav1_despacho_elim.php?cod1=<?php echo trim($codprop); ?>&cod2=<?php echo trim($value['codigo']); ?>&tipo=2')" title="Eliminar">
                                                                                                <img src="img/iconos/trash.png" height="10" />
                                                                                            </a>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <?php
                                                                                }
                                                                            } else {
                                                                                echo '<td colspan=5 style="color: red;">No hay estados registrados</td>';
                                                                            }
                                                                            ?>
                                                                        </tbody>
                                                                        <tfoot>                                            
                                                                            <tr style="">

                                                                                <td colspan="4">
                                                                                    <button type="button" class="btn btn-default" onclick="agregarEstadoDespacho(<?php echo $despachos["coddesp"] ?>)">
                                                                                        <img src="img/iconos/add.jpg" height="15" /> Agregar Estado
                                                                                    </button> 
                                                                                </td>
                                                                            </tr>
                                                                        </tfoot>
                                                                    </table>
                                                                    <br/>
                                                                    <div style="font-size: 0.9em;" id="divdespacho<?php echo $c; ?>">
                                                                    </div>

                                                                </div>
                                                            </div>

                                                            <br/><br/>
                                                            <?php
                                                        }
                                                    } else {
                                                        echo '<span>No hay despachos programados para esta propuesta</span>';
                                                    }
                                                    ?>
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

                    function agregarArchivo() {
                        var header = 'Agregar Archivo';
                        var form = $(
                                '<form id="upload_file" name="upload_file" action="#" method="POST" enctype="multipart/form-data" >' +
                                '<input type="hidden" name="codprop" value="<?php echo $codprop; ?>" />' +
                                '<input type="hidden" name="accion" value="UploadFile" />' +
                                '<div class="form-group">' +
                                '<label class="col-md-4 control-label">Tipo de Archivo</label><div class="col-md-8">' +
                                '<select name="descripcion" id="descripcion" class="form-control input-sm">' +
                                '<option value="DESPACHO">Archivo Despacho</option>' +
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

                    function agregarEstadoDespacho(coddesp) {

                        var header = 'Agregar Estado';

                        var form = $('<form id="form_regestado" name="form_regestado" method="POST" action="#" >' +
                                '<div class="form-group">' +
                                '<label class="col-md-4 control-label">Fecha</label>' +
                                '<div class="col-md-8">' +
                                '<input class="form-control" id="fecestadodesp" type="date" name="fecestadodesp" value="<?php echo date("Y-m-d"); ?>" />' +                                
                                '<input id="coddesp" type="hidden" name="coddesp" value="'+coddesp+'" />' +
                                '</div>' +
                                '<div class="form-group">' +
                                '<label class="col-md-4 control-label">Estado</label><div class="col-md-8">' +
                                '<select class="form-control" name="estado" id="estado">' +
                                '<option value="EN OFICINA">EN OFICINA</option>' +
                                '<option value="EN CURSO">EN CURSO</option>' +
                                '<option value="DESPACHO PARCIAL">DESPACHO PARCIAL</option>' +
                                '<option value="DESPACHADO">DESPACHADO</option>' +
                                '<option value="ENTREGADO">ENTREGADO</option>' +
                                '</select>' +
                                '</div>' +
                                '</div>' +
                                '<div class="form-group">' +
                                '<label class="col-md-4 control-label">Observación</label><div class="col-md-8"><textarea class="form-control" id="obs" name="obs" rows ="2" cols="20"></textarea></div>' +
                                '</div>'+
                                '<form>');
                        var button = $('<button id="cancel_estadodesp" type="cancel" class="btn btn-danger btn-label-left">' +
                                '<span><i class="fa fa-clock-o txt-danger"></i></span>' +
                                'Cancelar' +
                                '</button>' +
                                '<button type="submit" id="submit_estadodesp" class="btn btn-success btn-label-left pull-right">' +
                                '<span><i class="fa fa-clock-o"></i></span>' +
                                'Enviar' +
                                '</button>' +
                                '</form>');
                        OpenModalBox(header, form, button);
                        $('#cancel_estadodesp').on('click', function () {
                            CloseModalBox();
                        });
                        $('#submit_estadodesp').on('click', function () {

                            var coddesp = $("#coddesp").val();
                            var fecha = $("#fecestadodesp").val();
                            var estado = $("#estado").val();                            
                            var obs = $("#obs").val();
                            
                            var objeto = {
                                coddesp: coddesp,
                                fecha: fecha,
                                estado: estado,                                
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
                                data: {accion: 'RegDetDespacho', obj: objeto}
                            });
                            CloseModalBox();
                            //}
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
?>