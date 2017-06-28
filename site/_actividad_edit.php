<?php
@session_start();
include_once '../controller/C_Actividad.php';
$obj = new C_Actividad();


date_default_timezone_set("America/Bogota");
$hoy = date("Y/m/d");
$id = $_GET['cod'];
$obj->__set('codigo', $id);
$listact = $obj->getActividadByCod();
$clientes = $obj->getClientes();

$horainicio = date("H:i", strtotime($listact[5]));
$horafin = date("H:i", strtotime($listact[6]));

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
        <!--fin calendario-->
        <script src="autocompleteboot/js/bootstrap.js" type="text/javascript"></script>
        <script src="autocompleteboot/js/bootstrap-combobox.js" type="text/javascript"></script>        
        <script type="text/javascript">

            function nuevaActividad() {
                var tactividad = $("#tactividad").val();
                var div = document.getElementById('divnewactividad');
                var tnewactividad = document.getElementById('tnewactividad');
                if (tactividad === 'Otro') {
                    div.style.display = "block";
                    tnewactividad.required;
                } else {
                    div.style.display = "none";
                    tnewactividad.value = '';
                }
            }

            function nuevoLugar() {
                var lugar = $("#combobox").val();
                var div = document.getElementById('divnewlugar');
                var newlugar = document.getElementById('newlugar');
                if (lugar === 'Otro') {
                    div.style.display = "block";
                    newlugar.required;
                } else {
                    div.style.display = "none";
                    newlugar.value = '';
                }
            }

            function validarRegActividad() {

                var horainicio = $("#horainicio").val();
                var horafin = $("#horafin").val();
                var lugar = $("#combobox").val();
                var newlugar = $("#newlugar").val();
                var tactividad = $("#tactividad").val();
                var tnewactividad = $("#tnewactividad").val();

                if (horainicio === "00:00") {
                    alert('Debe seleccionar hora de inicio');
                    $("#horainicio").focus();
                    return false;
                } else if (horafin === "00:00") {
                    alert('Debe seleccionar hora de fin');
                    $("#horafin").focus();
                    return false;
                } else if (horainicio >= horafin ) {
                    alert('La hora fin debe ser mayor a hora inicio');
                    $("#horafin").focus();
                    return false;
                } else if (lugar === '' ) {
                    alert('Debe escribir un lugar');
                    $("#combobox").focus();
                    return false;
                } else if (lugar === "Otro" && newlugar === "") {
                    alert('Debe escribir lugar');
                    $("#newlugar").focus();
                    return false;
                } else if (tactividad === "Otro" && tnewactividad === "") {
                    alert('Debe escribir tipo actividad');
                    $("#tnewactividad").focus();
                    return false;
                }
                return true;
            }

            $(document).ready(function () {
                $("#form").submit(function (e) {
                    e.preventDefault();
                    var rpta = validarRegActividad();
                    if (rpta === true) {

                        var f = $(this);
                        var formData = new FormData(document.getElementById("form"));

                        $.ajax({
                            url: "../controller/C_Actividad.php",
                            type: "post",
                            dataType: "html",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false
                        })
                                .done(function (res) {
                                    $("#result").html(res);
                                });

                    }
                });
            });

            $(document).ready(function () {
                $('#combobox').combobox();
            });

        </script>                
    </head>
    <body>         
        <form id="form" name="form" action="#" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">Actualizar Actividad</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    Fecha actividad: <input required="" type = "text" name = "fecinicio" placeholder="fecinicio" value = "<?php echo date("Y/m/d", strtotime($listact[4])); ?>" class="form-control" id="cal" />
                                </div>
                                <div class="col-lg-5"></div>
                                <div class="col-lg-2">
                                    Hora Inicio:
                                    <?php echo $obj->editarHora('horainicio', 'form-control', $horainicio); ?>
                                </div>                                
                                <div class="col-lg-2">
                                    Hora Fin:
                                    <?php echo $obj->editarHora('horafin', 'form-control', $horafin); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6" hidden="">
                                    Empresa: 
                                    <select class="form-control input-sm" id="codempresa"  name="codempresa">                                                                                                        
                                            <option value="<?php echo $listact[1]; ?>"> <?php echo $listact[2]; ?></option>
                                    </select>                                    
                                </div>                                                                
                                <div class="col-lg-4">
                                    Asesor 
                                    <input type = "text" name = "nomtitular" readonly="" placeholder="nomtitular" value = "<?php echo $listact[3]; ?>" class="form-control" id="nomtitular" />
                                </div>
                                <div class="col-lg-4">
                                    Tipo de Actividad:
                                    <?php echo $obj->editTipoActividad('tactividad', 'form-control', 'nuevaActividad()', 'nuevaActividad()', '', $listact[9]); ?>
                                </div>
                                <div class="col-lg-4" id="divnewactividad" hidden="">
                                    Especificar Tipo de Actividad:
                                    <input type="text" id="tnewactividad" name="tnewactividad" class="form-control" name="" value="" />
                                </div>                                
                            </div>
                            <div class="row">                                
                                <div class="col-lg-6">
                                    Escribir Lugar o Cliente donde se realizó la actividad:
                                    <select class="form-control input-sm" id="combobox"  name="lugar" onchange="nuevoLugar()">                                        
                                        <option value="<?php echo $listact[2];?>"><?php echo $listact[2];?><option>
                                        <option value="Otro">..::Otro lugar</option>
                                        <?php foreach ($clientes as $valor) { ?>                                
                                            <option value="<?php echo trim($valor[1]) ?>"> <?php echo trim($valor[1]); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-lg-6" hidden="" id="divnewlugar">
                                    ¿Dónde se realizó la actividad?
                                    <input type="text" name="newlugar" id="newlugar" value="" class="form-control" />                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    Describir lo que se hizo en esta actividad: 
                                    <textarea required="" name = "descripcion" class="form-control" id="descripcion" rows="3" cols="20"><?php echo $listact[7];?></textarea>                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <p>Archivo Subido: <?php echo $listact[8];?> </p>
                                    <p>Reemplazar archivo por: <input type = "file" name="adjunto1_new" id="adjunto1_new" /></p>                                    
                                    <input type="hidden" name="adjunto1" value="<?php echo $listact[8]; ?>" />
                                    
                                </div>
                            </div>
                        </div>  
                    </div>
                    <center>
                        <input type="submit" value="Actualizar" class="btn-sm btn-success" />
                        <a href="#" onclick="cargar('#principal', '_actividad.php')" class="btn-sm btn-danger">Regresar</a>
                        <input type="hidden" id="accion" name="accion" value="ActActividad" />                    
                        <input type="hidden" id="codigo" name="codigo" value="<?php echo $id;?>" />                    
                    </center>
                </div>
            </div>
        </form>
        <br/>
        <p><div id="result"></div>
    </body>
</html>