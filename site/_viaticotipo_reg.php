<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
        <form id="form" name="form" action="#" method="post" enctype="multipart/form-data">
            <div id="etiqueta">   
                <img src="img/iconos/Add.png" height="45px"/>   
                <label></label>
            </div>

            <div id="form_reg">
                <div class="panel panel-default">                        
                    <div class="panel-heading">Llenar datos</div>
                    <div class="panel-body">                                                            
                        <div class="row">
                            <div class="col-lg-3">
                                codele<input type = "text" name = "codele" placeholder="codele" value = "" class="form-control" id="codele" />
                            </div>
                            <div class="col-lg-3">
                                desele<input type = "text" name = "desele" placeholder="desele" value = "" class="form-control" id="desele" />
                            </div>
                        </div>
                    </div>  
                </div>
                <center>
                    <input type="submit" value="Guardar" class="btn btn-success" />
                    <a href="#" onclick="cargar('#principal', '')" class="btn btn-danger">Regresar</a>
                    <input type="hidden" id="accion" name="accion" value="" />                    
                </center>
            </div>                       
        </form>
        <br/>
        <p><div id="result"></div>
    </body>
</html>