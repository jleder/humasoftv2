<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!DOCTYPE html>
<?php
include "../controller/C_Viaticos.php";
$obj = new NombreClase();
$id = $_GET["id"];
$obj->__set("coddetalle", "$id");
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
            url: "../controller/C_Viaticos.php",
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
                        <img src="img/iconos/modificar.png" height="45px"/> Modificar Detalle Viatico
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-3">
                                codviatico<input type = "text" name = "codviatico" placeholder="codviatico" value = "<?php echo $lista[1]; ?>" class="form-control" id="codviatico" />
                            </div>
                            <div class="col-lg-3">
                                codtipo<input type = "text" name = "codtipo" placeholder="codtipo" value = "<?php echo $lista[2]; ?>" class="form-control" id="codtipo" />
                            </div>
                            <div class="col-lg-3">
                                fecha<input type = "text" name = "fecha" placeholder="fecha" value = "<?php echo $lista[3]; ?>" class="form-control" id="fecha" />
                            </div>
                            <div class="col-lg-3">
                                doctipo<input type = "text" name = "doctipo" placeholder="doctipo" value = "<?php echo $lista[4]; ?>" class="form-control" id="doctipo" />
                            </div>
                            <div class="col-lg-3">
                                docnum<input type = "text" name = "docnum" placeholder="docnum" value = "<?php echo $lista[5]; ?>" class="form-control" id="docnum" />
                            </div>
                            <div class="col-lg-3">
                                proveedor<input type = "text" name = "proveedor" placeholder="proveedor" value = "<?php echo $lista[6]; ?>" class="form-control" id="proveedor" />
                            </div>
                            <div class="col-lg-3">
                                concepto<input type = "text" name = "concepto" placeholder="concepto" value = "<?php echo $lista[7]; ?>" class="form-control" id="concepto" />
                            </div>
                            <div class="col-lg-3">
                                valor<input type = "text" name = "valor" placeholder="valor" value = "<?php echo $lista[8]; ?>" class="form-control" id="valor" />
                            </div>
                            <div class="col-lg-3">
                                igv<input type = "text" name = "igv" placeholder="igv" value = "<?php echo $lista[9]; ?>" class="form-control" id="igv" />
                            </div>
                            <div class="col-lg-3">
                                valigv<input type = "text" name = "valigv" placeholder="valigv" value = "<?php echo $lista[10]; ?>" class="form-control" id="valigv" />
                            </div>
                            <div class="col-lg-3">
                                pventa<input type = "text" name = "pventa" placeholder="pventa" value = "<?php echo $lista[11]; ?>" class="form-control" id="pventa" />
                            </div>
                            <div class="col-lg-3">
                                codzona<input type = "text" name = "codzona" placeholder="codzona" value = "<?php echo $lista[12]; ?>" class="form-control" id="codzona" />
                            </div>
                            <div class="col-lg-3">
                                nomzona<input type = "text" name = "nomzona" placeholder="nomzona" value = "<?php echo $lista[13]; ?>" class="form-control" id="nomzona" />
                            </div>
                            <div class="col-lg-3">
                                codsubzona<input type = "text" name = "codsubzona" placeholder="codsubzona" value = "<?php echo $lista[14]; ?>" class="form-control" id="codsubzona" />
                            </div>
                            <div class="col-lg-3">
                                nomsubzona<input type = "text" name = "nomsubzona" placeholder="nomsubzona" value = "<?php echo $lista[15]; ?>" class="form-control" id="nomsubzona" />
                            </div>
                            <div class="col-lg-3">
                                dist<input type = "text" name = "dist" placeholder="dist" value = "<?php echo $lista[16]; ?>" class="form-control" id="dist" />
                            </div>
                            <div class="col-lg-3">
                                prov<input type = "text" name = "prov" placeholder="prov" value = "<?php echo $lista[17]; ?>" class="form-control" id="prov" />
                            </div>
                            <div class="col-lg-3">
                                dep<input type = "text" name = "dep" placeholder="dep" value = "<?php echo $lista[18]; ?>" class="form-control" id="dep" />
                            </div>
                        </div>
                    </div>  
                </div>
                <center>
                    <input type="submit" value="Guardar" class="btn btn-primary" />
                    <a href="#" onclick="cargar('#principal', '_viaticos.php')" class="btn btn-danger">Regresar</a>
                    <input type="hidden" id="accion" name="accion" value="ModDetalleViatico" />                    
                    <input type="hidden" id="coddetalle" name="coddetalle" value="<?php echo trim($lista[0]); ?>" />          
                </center>
            </div>                       
        </form>
        <br/>
        <p><div id="result_u"></div>
    </body>
</html>

