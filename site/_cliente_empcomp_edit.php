<!DOCTYPE html>
<?php
include "../controller/C_ClientexVendedor.php";
$obj = new NombreClase();
$id = $_GET["id"];
$obj->__set("codigo", "$id");
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
            url: "../controller/C_ClientexVendedor.php",
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
                        <img src="img/iconos/modificar.png" height="45px"/> Modificar
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-3">
                                codclv<input type = "text" name = "codclv" placeholder="codclv" value = "<?php echo $lista[1]; ?>" class="form-control" id="codclv" />
                            </div>
                            <div class="col-lg-3">
                                codven<input type = "text" name = "codven" placeholder="codven" value = "<?php echo $lista[2]; ?>" class="form-control" id="codven" />
                            </div>
                            <div class="col-lg-3">
                                nomven<input type = "text" name = "nomven" placeholder="nomven" value = "<?php echo $lista[3]; ?>" class="form-control" id="nomven" />
                            </div>
                            <div class="col-lg-3">
                                comisionpaq<input type = "text" name = "comisionpaq" placeholder="comisionpaq" value = "<?php echo $lista[4]; ?>" class="form-control" id="comisionpaq" />
                            </div>
                            <div class="col-lg-3">
                                comisionpud<input type = "text" name = "comisionpud" placeholder="comisionpud" value = "<?php echo $lista[5]; ?>" class="form-control" id="comisionpud" />
                            </div>
                            <div class="col-lg-3">
                                obs<input type = "text" name = "obs" placeholder="obs" value = "<?php echo $lista[6]; ?>" class="form-control" id="obs" />
                            </div>
                            <div class="col-lg-3">
                                fecreg<input type = "text" name = "fecreg" placeholder="fecreg" value = "<?php echo $lista[7]; ?>" class="form-control" id="fecreg" />
                            </div>
                            <div class="col-lg-3">
                                fecmod<input type = "text" name = "fecmod" placeholder="fecmod" value = "<?php echo $lista[8]; ?>" class="form-control" id="fecmod" />
                            </div>
                            <div class="col-lg-3">
                                coduse<input type = "text" name = "coduse" placeholder="coduse" value = "<?php echo $lista[9]; ?>" class="form-control" id="coduse" />
                            </div>
                            <div class="col-lg-3">
                                usemod<input type = "text" name = "usemod" placeholder="usemod" value = "<?php echo $lista[10]; ?>" class="form-control" id="usemod" />
                            </div>
                            <div class="col-lg-3">
                                codcia<input type = "text" name = "codcia" placeholder="codcia" value = "<?php echo $lista[11]; ?>" class="form-control" id="codcia" />
                            </div>
                        </div>
                    </div>  
                </div>
                <center>
                    <input type="submit" value="Guardar" class="btn btn-primary" />
                    <a href="#" onclick="cargar('#principal', '_cliente_empcomp.php')" class="btn btn-danger">Regresar</a>
                    <input type="hidden" id="accion" name="accion" value="ModClientexVendedorCompartido" />                    
                    <input type="hidden" id="codigo" name="codigo" value="<?php echo trim($lista[0]); ?>" />          
                </center>
            </div>                       
        </form>
        <br/>
        <p><div id="result_u"></div>
    </body>
</html>