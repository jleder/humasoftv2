<?php
@session_start();
include_once '../controller/C_Actividad.php';
date_default_timezone_set("America/Bogota");
$hoy = date("d/m/Y");
$obj = new C_Actividad();
$compania = $obj->getCompania();
$clientes = $obj->getClientes();
$codigo = $obj->generarCodActividad();
?>


<!DOCTYPE html>

<html>
    <head>
        <title>Registrar Actividad</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">        
        <?php include 'head.php'; ?>   
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
                } else if (horainicio >= horafin) {
                    alert('La hora fin debe ser mayor a hora inicio');
                    $("#horafin").focus();
                    return false;
                } else if (lugar === '') {
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
        </script>                
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
        <div class="col-lg-12">
            <br/>
            <!--<div id='calendar'></div>-->
            <form id="form" name="form" action="#" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="panel panel-default">
                            <div class="panel-heading">Registrar Actividad</div>
                            <div class="panel-body">                                
                                <div class="row">
                                    <div class="col-lg-3">
                                        Fecha actividad: <input required="" type = "text" name = "fecinicio" placeholder="fecinicio" value = "<?php echo $hoy; ?>" class="form-control" id="input_date" />

                                    </div>
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-2">
                                        Código: <input required="" type = "text" name = "codigo" value = "<?php echo $codigo; ?>" class="form-control" id="codigo" />
                                    </div>
                                    <div class="col-lg-2">
                                        Hora Inicio:                                     
                                        <?php echo $obj->generarHora('horainicio', 'form-control'); ?>
                                    </div>                                
                                    <div class="col-lg-2">
                                        Hora Fin:
                                        <?php echo $obj->generarHora('horafin', 'form-control'); ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6" hidden="">
                                        Empresa: 
                                        <select class="form-control input-sm" id="codempresa"  name="codempresa" onchange="cargarSedes()" onblur="cargarSedes()">                                                                
                                            <?php foreach ($compania as $valor) { ?>                                
                                                <option value="<?php echo $valor['codcia']; ?>"> <?php echo $valor['descia']; ?></option>
                                            <?php } ?>                                                                                
                                        </select>                                    
                                    </div>                                                                
                                    <div class="col-lg-4">
                                        Asesor
                                        <input type = "text" name = "nomtitular" readonly="" placeholder="nomtitular" value = "<?php echo $_SESSION['nombreUsuario']; ?>" class="form-control" id="nomtitular" />
                                    </div>
                                    <div class="col-lg-4">
                                        Tipo de Actividad:
                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <?php echo $obj->getTipoActividad('tactividad', '', 'nuevaActividad()', 'nuevaActividad()', ''); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4" id="divnewactividad" hidden="">
                                        Especificar Tipo de Actividad:
                                        <input type="text" id="tnewactividad" name="tnewactividad" class="form-control" name="" value="" />
                                    </div>                                
                                </div>
                                <div class="row">                                
                                    <div class="col-lg-6">
                                        Escribir Lugar o Cliente donde se realizó la actividad:

                                        <select id="combobox"  name="lugar" onchange="nuevoLugar()">                                        
                                            <option value=""></option>
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
                                        <textarea required="" name = "descripcion" class="form-control" id="descripcion" rows="3" cols="20"></textarea>                                    
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        Adjuntar un Archivo <input type = "file" name="adjunto1" id="adjunto1" />
                                    </div>
                                </div>
                            </div>  
                        </div>
                        <center>
                            <input type="submit" value="Guardar" class="btn btn-success btn-sm" />
                            <a href="#" class="btn btn-danger btn-sm" onclick="cargar('#principal', '_actividad.php')">Regresar</a>
                            <input type="hidden" id="accion" name="accion" value="RegActividad" />                                            
                        </center>
                    </div>
                </div>
            </form>
            <br/>
            <div id="result"></div>
        </div>
                        </div>
        </div>
        </div>
        <?php include 'script.php'; ?>
        <script type="text/javascript">
            // Run Select2 on element
            function Select2Test() {
                $("#tactividad").select2();
                $("#combobox").select2();
            }
            $(document).ready(function () {
                // Load script of Select2 and run this
                LoadSelect2Script(Select2Test);
                WinMove();
                // Initialize datepicker
                //$('#input_date').datepicker({setDate: new Date()});




                //$('#input_date2').datepicker({setDate: new Date()});                
                // Add tooltip to form-controls
                $('.form-control').tooltip();
            });

            $(function () {
                $('#input_date').datepicker($.extend({
                    showMonthAfterYear: false,
                    dateFormat: 'dd/mm/yy'
                },
                        $.datepicker.regional['es']
                        ));
            });

        </script>
    </body>
</html>
