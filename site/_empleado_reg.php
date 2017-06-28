<?php
/*
 * Proyecto Humasoft.
 * Desarrollado por Juan Leder
 */

/**
 * Description of _empleado_reg
 *
 * @author Emergencia
 */
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />                            
        <script type="text/javascript">

            function validar() {

                var horainicio = $("#horainicio").val();
                var horafin = $("#horafin").val();

                if (horainicio === "00:00") {
                    alert("Debe seleccionar hora de inicio");
                    $("#horainicio").focus();
                    return false;
                } else if (horafin === "00:00") {
                    alert("Debe seleccionar hora de fin");
                    $("#horafin").focus();
                    return false;
                    return true;
                }
            }
            $(document).ready(function () {
                $("#form").submit(function (e) {
                    e.preventDefault();
                    var rpta = validar();
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
        <div class="row">
            <div id="breadcrumb" class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="#">RR.HH.</a></li>
                    <li><a href="#">Registrar Empleado</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <div class="box-name">
                            <i class="fa fa-bar-chart-o"></i>
                            <span>Formulario Registrar Empleado</span>
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
                    <div class="box-content">
                        <h4 class="page-header" style="text-align: center;">Datos Personales</h4>
                        <form id="form" name="form" action="#" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group">
                                <label class="control-label col-sm-1">Nombre:</label>
                                <div class="col-sm-3">
                                    <input type = "text" name = "nombre" placeholder="nombre" value = "" class="form-control" id="nombre" />
                                </div>
                                <label class="col-sm-1">Apellido:</label>
                                <div class="col-sm-3">
                                    <input type = "text" name = "apellido" placeholder="apellido" value = "" class="form-control" id="apellido" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-1">DNI:</label>
                                <div class="col-sm-2">
                                    <input type = "text" name = "dni" placeholder="dni" value = "" class="form-control" id="dni" />
                                </div>                                
                                <label class="control-label col-sm-1">Nacimiento:</label>
                                <div class="col-sm-2">
                                    <input type = "text" name = "fecnac" placeholder="fecnac" value = "" class="form-control" id="fecnac" />
                                </div>
                                <label class="control-label col-sm-1">Sexo:</label>
                                <div class="col-sm-2">
                                    <input type = "text" name = "sexo" placeholder="sexo" value = "" class="form-control" id="sexo" />
                                </div>
                                <label class="control-label col-sm-1">Telefono:</label>
                                <div class="col-sm-2">
                                    <input type = "text" name = "telefono" placeholder="telefono" value = "" class="form-control" id="telefono" />
                                </div>
                            </div>                            
                            <div class="form-group">
                                <label class="control-label col-sm-1">Celular:</label>
                                <div class="col-sm-2">
                                    <input type = "text" name = "celular" placeholder="celular" value = "" class="form-control" id="celular" />
                                </div>
                                <label class="control-label col-sm-1">Email:</label>
                                <div class="col-sm-2">
                                    <input type = "text" name = "email" placeholder="email" value = "" class="form-control" id="email" />
                                </div>
                                <label class="control-label col-sm-1">Fotografia:</label>
                                <div class="col-sm-2">
                                    <input type = "text" name = "foto" placeholder="foto" value = "" class="form-control" id="foto" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-1">Domicilio:</label>                                
                                <div class="col-sm-4">
                                    <input type = "text" name = "direccion" value = "" class="form-control" id="direccion" />
                                </div>                                
                                <div class="col-sm-4">
                                    <input type = "text" name = "dist"  value = "" class="form-control" id="dist" />
                                </div>
                            </div> 
                            <h4 class="page-header" style="text-align: center;">Datos Laborales</h4>
                            <div class="form-group">
                                <label class="control-label col-sm-2">Profesión:</label>
                                <div class="col-sm-2">
                                    <input type = "text" name = "profesion" placeholder="profesion" value = "" class="form-control" id="profesion" />
                                </div>
                                <label class="control-label col-sm-1">Cargo:</label>
                                <div class="col-sm-2">
                                    <input type = "text" name = "cargo" placeholder="cargo" value = "" class="form-control" id="cargo" />
                                </div>
                                <label class="control-label col-sm-1">Salario:</label>
                                <div class="col-sm-2">
                                    <input type = "text" name = "salario" placeholder="salario" value = "" class="form-control" id="salario" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2">Fecha Ingreso:</label>                                
                                <div class="col-sm-2">
                                    <input type = "text" name = "fecingreso" placeholder="fecingreso" value = "" class="form-control" id="fecingreso" />
                                </div>
                                <label class="control-label col-sm-2">Fecha Salida:</label>                                                                
                                <div class="col-sm-3">
                                    <input type = "text" name = "fecsalida" placeholder="fecsalida" value = "" class="form-control" id="fecsalida" />
                                </div>
                                <label class="control-label col-sm-2">Zona de Trabajo:</label>
                                <div class="col-lg-3">
                                    <input type = "text" name = "tipo" placeholder="tipo" value = "" class="form-control" id="tipo" />
                                </div>                                
                                <label class="control-label col-sm-2">Estado:</label>
                                <div class="col-lg-3">
                                    <input type = "text" name = "estado" placeholder="estado" value = "" class="form-control" id="tipo" />
                                </div>
                            </div>
                            <center>
                                <input type="submit" value="Guardar" class="btn btn-success" />
                                <a href="#" onclick="cargar('#principal', '_empleado.php')" class="btn btn-danger">Regresar</a>
                                <input type = "hidden" name = "tipo" placeholder="tipo" value = "I" id="tipo" />
                                <input type="hidden" id="accion" name="accion" value="RegEmpleado" />                    
                            </center>                                   
                        </form>
                    </div>                    
                </div>
            </div>
        </div>

        <br/>
        <p><div id="result"></div>
    </body>
</html>