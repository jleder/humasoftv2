<?php
include '../controller/C_Solicitud.php';
$ecom = new C_EstadoComercial();

$codestado = $_GET['codestado'];
$codprop = $_GET['codprop'];

$ecom->__set('codestado', $codestado);

$lista = $ecom->listar_propdb16_by_cod();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />   
        <!--calendario-->        
        <script type="text/javascript" src="js/js_inscoltec.js"></script>        
        <style type="text/css">            
            @import "util/media/themes/smoothness/jquery-ui-1.8.4.custom.css";            
        </style>
        <!--FIN DE CALENDARIO-->
        <script type="text/javascript">
            $(document).ready(function () {
                $("#form_ec_edit").submit(function (e) {
                    e.preventDefault();
                    var f = $(this);
                    var formData = new FormData(document.getElementById("form_ec_edit"));

                    var rpta = validar();
                    if (rpta === true) {

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
                                    $("#resultado").html(res);
                                });
                    }
                });
            });

            function validar() {
                var estado = $("#estado").val();
                var estado2 = $("#estado2").val();

                if (estado === 'OTRO' && estado2 === '') {
                    alert("Debe ingresar el estado");
                    $("#estado2").focus();
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
        </script>                
    </head>
    <body> 
        <div class="col-lg-4">
            <form id="form_ec_edit" name="form_ec_edit" action="#" method="post" enctype="multipart/form-data">
                <div id="form_reg">
                    <div class="panel panel-default">                        
                        <div class="panel-heading">Actualizar Estado Comercial</div>
                        <div class="panel-body">                                                            
                            <div class="row">                            
                                <input type = "hidden" name = "codprop" placeholder="codprop" value = "<?php echo $codprop; ?>" class="form-control" id="codprop" />                            
                                <div class="col-lg-12">
                                    Fecha<input type = "text" name = "fecha" placeholder="fecha" value = "<?php echo date("Y/m/d", strtotime($lista[2])); ?>" class="form-control" id="cal" />
                                </div>
                            </div>
                            <div class="row">                            
                                <div class="col-lg-12">
                                    Estado                                
                                    <select name="estado" id="estado" class="form-control" onchange="verificarEstadoComercial()">
                                        <option value="<?php echo $lista[3]; ?>"><?php echo $lista[3]; ?></option>
                                        <option value="<?php echo $lista[3]; ?>">cambiar por...</option>
                                        <option value="EN VENDEDOR">EN VENDEDOR</option>
                                        <option value="EN CLIENTE">EN CLIENTE</option>
                                        <option value="EN SEGUIMIENTO">EN SEGUIMIENTO</option>
                                        <option value="APROBADO">APROBADO</option>
                                        <option value="NO APROBADO">NO APROBADO</option>
                                        <option value="OTRO">OTRO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row" id="divestado" style="display: none;">                            
                                <div class="col-lg-12">
                                    Escribir nuevo Estado Comercial
                                    <input type="text" maxlength="50" class="form-control" name="estado2" id="estado2" value="" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    Observaciones:
                                    <textarea name="obs" id="obs" rows="4" cols="20" class="form-control"><?php echo $lista[4]; ?></textarea>                                
                                </div>                            
                            </div>
                        </div>  
                    </div>
                    <center>
                        <input type="submit" value="Guardar" class="btn btn-success" />
                        <a href="#" onclick="cargar('#bodytable', '_propuestav2_ecomercial.php?codprop=<?php echo $codprop; ?>')" class="btn btn-danger">Regresar</a>
                        <input type="hidden" id="accion" name="accion" value="ModEstadoComercial" />
                        <input type="hidden" id="codestado" name="codestado" value="<?php echo $lista[0]; ?>" />
                    </center>
                </div>
            </form>
        </div>
        <br/><br/>
        <p><div id="resultado"></div>
    </body>
</html>

