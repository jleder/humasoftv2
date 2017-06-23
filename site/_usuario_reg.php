<!DOCTYPE html>
<html>
    <head>
        <script type="text/javascript" src="js/js_inscoltec.js"></script>        
        <style type="text/css">            
            @import "util/media/themes/smoothness/jquery-ui-1.8.4.custom.css";            
        </style>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />                            
        <script type="text/javascript">                       
            
            function validar() {                
                
                var clave = $("#pwduse").val();
                var newclave = $("#pwduse2").val();
                
                if (clave === '') {
                    alert("DEBE INGRESAR UNA CLAVE");
                    $("#pwduse").focus();
                    return false;
                } else if (newclave === '') {
                    alert("DEBE VOLVER A INGRESAR SU CLAVE");
                    $("#pwduse2").focus();
                    return false;
                } else if (clave !== newclave){
                    alert("LAS CLAVES INGRESADAS NO COINCIDEN. POR FAVOR VOLVER A INGRESAR LAS CLAVES");
                    $("#pwduse").val("");
                    $("#pwduse2").val("");
                    $("#pwduse").focus();
                    return false;                    
                }
                return true;
            }
            
                $(document).ready(function () {
                    $("#form_reguser").submit(function (e) {                        
                        e.preventDefault();                        
                        var rpta = validar();
                        if (rpta === true) {

                            var f = $(this);
                            var formData = new FormData(document.getElementById("form_reguser"));

                            $.ajax({
                                url: "../controller/C_Usuario.php",
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
        <div class="col-lg-3">
            <form id="form_reguser" name="form_reguser" action="#" method="post" enctype="multipart/form-data">                
                <div id="form_reg">
                    <div class="panel panel-default">                        
                        <div class="panel-heading">Crear Nuevo Usuario</div>
                        <div class="panel-body">                                                            
                            
                            <div class="row">
                                <div class="col-lg-12">
                                    Nombre Completo<input required="" type = "text" name = "desuse" placeholder="desuse" value = "" class="form-control" id="desuse" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    Usuario<input required="" type = "text" name = "coduse" placeholder="" value = "" class="form-control" id="coduse" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    Clave<input type = "password" name = "pwduse" placeholder="" value = "" class="form-control" id="pwduse" />
                                </div>       
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                  Repetir Clave<input type = "password" name = "pwduse2" placeholder="" value = "" class="form-control" id="pwduse2" />
                                </div>       
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    E-mail<input type = "email" name = "email" placeholder="email" value = "" class="form-control" id="email" />
                                </div>       
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    Es Vendedor
                                    <select name="vendedor" id="vendedor" class="form-control">
                                        <option value="SI">SI</option>
                                        <option value="NO">NO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    Es Asesor Comercial
                                    <select name="vc" id="vc" class="form-control">
                                        <option value="SI">SI</option>
                                        <option value="NO">NO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    Es Asesor Tecnico
                                    <select name="vt" id="vt" class="form-control">
                                        <option value="SI">SI</option>
                                        <option value="NO">NO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    Es Asesor Externo
                                    <select name="externo" id="externo" class="form-control">
                                        <option value="SI">SI</option>
                                        <option value="NO">NO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    Tiene Acceso a Zona Tiendas
                                    <select name="store" id="store" class="form-control">
                                        <option value="t">SI</option>
                                        <option value="f">NO</option>
                                    </select>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <center>
                        <input type="submit" value="Guardar" class="btn btn-success" />
                        <a href="#" onclick="cargar('#divuserypermiso', '_usuario.php')" class="btn btn-danger">Regresar</a>
                        <input type="hidden" id="accion" name="accion" value="RegUsuario" />                    
                    </center>
                </div>                       
            </form>
            <br/>
        </div>
        <br/><br/>
        <div class="col-lg-12">
        <p><div id="result"></div>
        </div>
    </body>
</html>