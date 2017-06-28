<?php
@session_start();
date_default_timezone_set("America/Bogota");
include_once '../controller/C_Solicitud.php';
$desp = new C_Despacho();
$codprop = $_GET['cod'];
$hoy = date("Y/m/d");
?>
<html>
    <head>
        <meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8" />
        <!--calendario-->        
        <script type="text/javascript" src="js/js_inscoltec.js"></script>        
        <style type="text/css">            
            @import "util/media/themes/smoothness/jquery-ui-1.8.4.custom.css";            
        </style> 

        <script>
            $(document).ready(function () {
                $("#form_despacho").submit(function (e) {
                    e.preventDefault();

                    var f = $(this);
                    var formData = new FormData(document.getElementById("form_despacho"));

                    $.ajax({
                        url: "../controller/C_Solicitud.php",
                        type: "post",
                        dataType: "html",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false
                    })
                            .done(function (res) {
                                $("#divdespacho").html(res);
                            });

                });
            });
        </script>
    </head>
    <body>
        <div id="divregestado">
            <div class="col-lg-12">
                <div class="panel panel-info">
                    <div class="panel-heading">Registrar Despacho</div>
                    <div class="panel-body" style="font-size: 1em;">
                        <form id="form_despacho" name="form_despacho" method="POST" action="#" >
                            <div class="row">
                                <div class="col-lg-4">Código Propuesta
                                    <input type="text" name="codprop" class="form-control" readonly="" value="<?php echo $codprop; ?>" />
                                </div>
                                <div class="col-lg-4">Prioridad
                                    <select name="prioridad" id="prioridad" class="form-control">                                        
                                        <option value="NORMAL">NORMAL (72hrs)</option>
                                        <option value="URGENTE">URGENTE (48hrs)</option>
                                        <option value="MUY URGENTE">MUY URGENTE</option>
                                    </select> 
                                </div>
                                <div class="col-lg-4">Entrega Prevista
                                    <input type="text" name="fecprev" id="cal" class="form-control" value="<?php echo $hoy; ?>" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">Monto Despachado
                                    <input type="number" step="any" name="montodesp" class="form-control" value="0" />
                                </div>                                
                                <div class="col-lg-4">Saldo
                                    <input type="number" step="any" name="saldo" class="form-control" value="0" />
                                </div>                                
                                <div class="col-lg-4">Moneda
                                    <select name="moneda" id="moneda" class="form-control">
                                        <option value="$">$. DOLAR</option>
                                        <option value="S/.">S/. SOLES</option>
                                    </select>
                                </div>                                
                            </div>

                            <div class="row">
                                <div class="col-lg-12">Descripción:
                                    <input type="text" maxlength="90" name="descripcion" class="form-control" value="" />
                                </div>
                                <div class="col-lg-12">Observación:
                                    <textarea class="form-control" name="obs" rows="4" cols="5"></textarea>
                                </div>
                            </div>                            
                            <div class="row" style="text-align: right">
                                <div class="col-lg-12">
                                    <br/>
                                    <input type="reset" value="Cancelar" id="cancelar" class="btn btn-danger" />                            
                                    <input type="submit" value="Guardar" id="guardar" class="btn btn-success" />                            
                                    <input id="accion" type="hidden" name="accion" value="RegDespacho" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>