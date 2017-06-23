<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!DOCTYPE html>
                    <?php 
                    include "../controller/";
                    $obj = new NombreClase();
                    $id = $_GET["id"];
                    $obj->__set("codigo", "$id");
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
                                url: "../controller/",
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
codele<input type = "text" name = "codele" placeholder="codele" value = "<?php echo $lista[1];?>" class="form-control" id="codele" />
</div>
<div class="col-lg-3">
desele<input type = "text" name = "desele" placeholder="desele" value = "<?php echo $lista[2];?>" class="form-control" id="desele" />
</div>
</div>
                            </div>  
                        </div>
                        <center>
                            <input type="submit" value="Guardar" class="btn btn-primary" />
                            <a href="#" onclick="cargar('#principal', '')" class="btn btn-danger">Regresar</a>
                            <input type="hidden" id="accion" name="accion" value="" />                    
                            <input type="hidden" id="codigo" name="codigo" value="<?php echo trim($lista[0]); ?>" />          
                        </center>
                    </div>                       
                </form>
                <br/>
                <p><div id="result_u"></div>
            </body>
        </html>