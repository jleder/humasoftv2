<?php

/* 
 * Proyecto Humasoft.
 * Desarrollado por Juan Leder
 */

?>
<!DOCTYPE html>
                    <?php 
                    include "../controller/Proyeccion";
                    $obj = new NombreClase();
                    $id = $_GET["id"];
                    $obj->__set("codproy", "$id");
                    $lista = $obj->listarbycod();    
                    ?>
                    
                    <html>
                    <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />                            
                <script type="text/javascript">
                <style>
                .pre {
                  background-color:#F5F5F5;
                  border:1px solid #00000;
                  padding:10px;
                  overflow:auto
                  margin:7px;
                  color:#0150c0;
                }
                </style>

                    $(document).ready(function () {
                        $("#form").submit(function (event) {
                            event.preventDefault();
                            var f = $(this);
                            var formData = new FormData(document.getElementById("form"));
                            //var nomcli = $("#codcli option:selected").html();
                            //formData.append("nomcli", nomcli);
                            $.ajax({
                                url: "../controller/Proyeccion",
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
proy_ano<input type = "text" name = "proy_ano" placeholder="proy_ano" value = "<?php echo $lista[1];?>" class="form-control" id="proy_ano" />
</div>
<div class="col-lg-3">
proy_mes<input type = "text" name = "proy_mes" placeholder="proy_mes" value = "<?php echo $lista[2];?>" class="form-control" id="proy_mes" />
</div>
<div class="col-lg-3">
codasesor<input type = "text" name = "codasesor" placeholder="codasesor" value = "<?php echo $lista[3];?>" class="form-control" id="codasesor" />
</div>
<div class="col-lg-3">
codcliente<input type = "text" name = "codcliente" placeholder="codcliente" value = "<?php echo $lista[4];?>" class="form-control" id="codcliente" />
</div>
<div class="col-lg-3">
ha<input type = "text" name = "ha" placeholder="ha" value = "<?php echo $lista[5];?>" class="form-control" id="ha" />
</div>
<div class="col-lg-3">
cultivo<input type = "text" name = "cultivo" placeholder="cultivo" value = "<?php echo $lista[6];?>" class="form-control" id="cultivo" />
</div>
<div class="col-lg-3">
total<input type = "text" name = "total" placeholder="total" value = "<?php echo $lista[7];?>" class="form-control" id="total" />
</div>
</div>
                            </div>  
                        </div>
                        <center>
                            <input type="submit" value="Guardar" class="btn btn-primary" />
                            <a href="#" onclick="cargar('#principal', '_proyeccion.php')" class="btn btn-danger">Regresar</a>
                            <input type="hidden" id="accion" name="accion" value="ModProyeccion" />                    
                            <input type="hidden" id="codproy" name="codproy" value="<?php echo trim($lista[0]); ?>" />          
                        </center>
                    </div>                       
                </form>
                <br/>
                <p><div id="result_u"></div>
            </body>
        </html>
