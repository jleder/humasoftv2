<?php
/*
 * Proyecto Humasoft.
 * Desarrollado por Juan Leder
 */
?>
<!DOCTYPE html>
<?php
include "../controller/C_Empleados";
$obj = new NombreClase();
$id = $_GET["id"];
$obj->__set("codpersona", "$id");
$lista = $obj->listarbycod();
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />                            
        <script type="text/javascript">
        < style >
                    .pre {
                    background - color:#F5F5F5;
                    border:1px solid #00000;
                    padding:10px;
                    overflow:auto
                            margin:7px;
                    color:#0150c0;
                    }
            < /style>

                    $(document).ready(function () {
            $("#form").submit(function (event) {
            event.preventDefault();
            var f = $(this);
            var formData = new FormData(document.getElementById("form"));
            //var nomcli = $("#codcli option:selected").html();
            //formData.append("nomcli", nomcli);
            $.ajax({
            url: "../controller/C_Empleados",
                    type: "post",
                    dataType: "html",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false
            })
                    .done(function (res) {
                    $("#result_u").html(res);
                    });
            });
            });
        </script>                
    </head>
    <body> 
        <form id="form" name="form" action="#" method="post" enctype="multipart/form-data">                    
            <div id="form_reg">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <img src="img/iconos/modificar.png" height="45px"/> 
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-3">
                                nombre<input type = "text" name = "nombre" placeholder="nombre" value = "<?php echo $lista[1]; ?>" class="form-control" id="nombre" />
                            </div>
                            <div class="col-lg-3">
                                apellido<input type = "text" name = "apellido" placeholder="apellido" value = "<?php echo $lista[2]; ?>" class="form-control" id="apellido" />
                            </div>
                            <div class="col-lg-3">
                                dni<input type = "text" name = "dni" placeholder="dni" value = "<?php echo $lista[3]; ?>" class="form-control" id="dni" />
                            </div>
                            <div class="col-lg-3">
                                fecnac<input type = "text" name = "fecnac" placeholder="fecnac" value = "<?php echo $lista[4]; ?>" class="form-control" id="fecnac" />
                            </div>
                            <div class="col-lg-3">
                                sexo<input type = "text" name = "sexo" placeholder="sexo" value = "<?php echo $lista[5]; ?>" class="form-control" id="sexo" />
                            </div>
                            <div class="col-lg-3">
                                telefono<input type = "text" name = "telefono" placeholder="telefono" value = "<?php echo $lista[6]; ?>" class="form-control" id="telefono" />
                            </div>
                            <div class="col-lg-3">
                                celular<input type = "text" name = "celular" placeholder="celular" value = "<?php echo $lista[7]; ?>" class="form-control" id="celular" />
                            </div>
                            <div class="col-lg-3">
                                email<input type = "text" name = "email" placeholder="email" value = "<?php echo $lista[8]; ?>" class="form-control" id="email" />
                            </div>
                            <div class="col-lg-3">
                                foto<input type = "text" name = "foto" placeholder="foto" value = "<?php echo $lista[9]; ?>" class="form-control" id="foto" />
                            </div>
                            <div class="col-lg-3">
                                direccion<input type = "text" name = "direccion" placeholder="direccion" value = "<?php echo $lista[10]; ?>" class="form-control" id="direccion" />
                            </div>
                            <div class="col-lg-3">
                                dist<input type = "text" name = "dist" placeholder="dist" value = "<?php echo $lista[11]; ?>" class="form-control" id="dist" />
                            </div>
                            <div class="col-lg-3">
                                prov<input type = "text" name = "prov" placeholder="prov" value = "<?php echo $lista[12]; ?>" class="form-control" id="prov" />
                            </div>
                            <div class="col-lg-3">
                                dep<input type = "text" name = "dep" placeholder="dep" value = "<?php echo $lista[13]; ?>" class="form-control" id="dep" />
                            </div>
                            <div class="col-lg-3">
                                salario<input type = "text" name = "salario" placeholder="salario" value = "<?php echo $lista[14]; ?>" class="form-control" id="salario" />
                            </div>
                            <div class="col-lg-3">
                                cargo<input type = "text" name = "cargo" placeholder="cargo" value = "<?php echo $lista[15]; ?>" class="form-control" id="cargo" />
                            </div>
                            <div class="col-lg-3">
                                fecingreso<input type = "text" name = "fecingreso" placeholder="fecingreso" value = "<?php echo $lista[16]; ?>" class="form-control" id="fecingreso" />
                            </div>
                            <div class="col-lg-3">
                                fecsalida<input type = "text" name = "fecsalida" placeholder="fecsalida" value = "<?php echo $lista[17]; ?>" class="form-control" id="fecsalida" />
                            </div>
                            <div class="col-lg-3">
                                profesion<input type = "text" name = "profesion" placeholder="profesion" value = "<?php echo $lista[18]; ?>" class="form-control" id="profesion" />
                            </div>
                            <div class="col-lg-3">
                                tipo<input type = "text" name = "tipo" placeholder="tipo" value = "<?php echo $lista[19]; ?>" class="form-control" id="tipo" />
                            </div>
                        </div>
                    </div>  
                </div>
                <center>
                    <input type="submit" value="Guardar" class="btn btn-primary" />
                    <a href="#" onclick="cargar('#principal', '_empleado.php')" class="btn btn-danger">Regresar</a>
                    <input type="hidden" id="accion" name="accion" value="ModEmpleado" />                    
                    <input type="hidden" id="codpersona" name="codpersona" value="<?php echo trim($lista[0]); ?>" />          
                </center>
            </div>                       
        </form>
        <br/>
        <p><div id="result_u"></div>
    </body>
</html>