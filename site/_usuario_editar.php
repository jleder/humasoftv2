<?php
include '../controller/C_Usuario.php';
$obj = new C_Usuario();
$id = $_GET['id'];
$obj->__set('coduse', $id);
$usuario = $obj->listar_aausdb01_by_cod();
?>

<!DOCTYPE html>
<html>
    <head>
        <script type="text/javascript" src="js/js_inscoltec.js"></script>        
        <style type="text/css">            
            @import "util/media/themes/smoothness/jquery-ui-1.8.4.custom.css";            
        </style>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />                            
        <script type="text/javascript">
            $(document).ready(function () {
                $("#form_moduser").submit(function (e) {
                    e.preventDefault();
                    //var rpta = validar();
                    //if (rpta === true) {

                    var f = $(this);
                    var formData = new FormData(document.getElementById("form_moduser"));

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

                    //}

                });
            });
        </script>                
    </head>
    <body>
        <div class="col-lg-3">
            <form id="form_moduser" name="form_moduser" action="#" method="post" enctype="multipart/form-data">                
                <div id="form_reg">
                    <div class="panel panel-default">                        
                        <div class="panel-heading">Crear Nuevo Usuario</div>
                        <div class="panel-body">                                                            

                            <div class="row">
                                <div class="col-lg-12">
                                    Nombre Completo<input type = "text" name = "desuse" placeholder="desuse" value = "<?php echo $usuario[1]; ?>" class="form-control" id="desuse" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    Usuario<input type = "text" name = "newcoduse" placeholder="" value = "<?php echo trim($usuario[0]); ?>" class="form-control" id="newcoduse" />
                                    <input type = "hidden" name = "coduse" value = "<?php echo trim($usuario[0]); ?>" class="form-control" id="coduse" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    Clave<input type = "text" name = "pwduse" placeholder="pwduse" value = "<?php echo trim($usuario[2]);?>" class="form-control" id="pwduse" />
                                </div>       
                            </div>                           
                            <div class="row">
                                <div class="col-lg-12">
                                    E-mail<input type = "text" name = "email" placeholder="email" value = "<?php echo $usuario[5]; ?>" class="form-control" id="email" />
                                </div>       
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    Es Vendedor
                                    <select name="vendedor" id="vendedor" class="form-control">
                                        <option value="<?php echo $usuario[7]; ?>"><?php echo $usuario[7]; ?></option>
                                        <option value="<?php echo $usuario[7]; ?>">cambiar por...</option>
                                        <option value="SI">SI</option>
                                        <option value="NO">NO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    Es Asesor Comercial
                                    <select name="vc" id="vc" class="form-control">
                                        <option value="<?php echo $usuario[8]; ?>"><?php echo $usuario[8]; ?></option>
                                        <option value="<?php echo $usuario[8]; ?>">cambiar por...</option>
                                        <option value="SI">SI</option>
                                        <option value="NO">NO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    Es Asesor Tecnico
                                    <select name="vt" id="vt" class="form-control">
                                        <option value="<?php echo $usuario[9]; ?>"><?php echo $usuario[9]; ?></option>
                                        <option value="<?php echo $usuario[9]; ?>">cambiar por...</option>
                                        <option value="SI">SI</option>
                                        <option value="NO">NO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    Es Asesor Externo
                                    <select name="externo" id="externo" class="form-control">
                                        <option value="<?php echo $usuario[10]; ?>"><?php echo $usuario[10]; ?></option>
                                        <option value="<?php echo $usuario[10]; ?>">cambiar por...</option>
                                        <option value="SI">SI</option>
                                        <option value="NO">NO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    Tiene Acceso a Zona Tiendas
                                    <?php
                                    $store = 'SI';
                                    if ($usuario[11] == 'f') {
                                        $store = 'NO';
                                    }
                                    ?>
                                    <select name="store" id="store" class="form-control">
                                        <option value="<?php echo $usuario[11]; ?>"><?php echo $store; ?></option>
                                        <option value="<?php echo $usuario[11]; ?>">cambiar por...</option>                                        
                                        <option value="t">SI</option>
                                        <option value="f">NO</option>
                                    </select>
                                </div>
                            </div>                            
                            <div class="row">
                                <div class="col-lg-12">
                                    Usuario Activo
                                    <?php
                                    $activo = 'SI';
                                    if ($usuario[6] == 'f') {
                                        $activo = 'NO';
                                    }
                                    ?>
                                    <select name="activo" id="activo" class="form-control">
                                        <option value="<?php echo $usuario[6]; ?>"><?php echo $activo; ?></option>
                                        <option value="<?php echo $usuario[6]; ?>">cambiar por...</option>                                        
                                        <option value="t">SI</option>
                                        <option value="f">NO</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <center>
                        <input type="submit" value="Actualizar" class="btn btn-success" />
                        <a href="#" onclick="cargar('#divuserypermiso', '_usuario.php')" class="btn btn-danger">Regresar</a>
                        <input type="hidden" id="accion" name="accion" value="ModUsuario" />                    
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