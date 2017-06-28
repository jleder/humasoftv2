<?php ?>
<!DOCTYPE html>
<?php
include "../controller/C_Viaticos.php";
$obj = new NombreClase();
$id = $_GET["id"];
$obj->__set("codviatico", "$id");
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
                        <img src="img/iconos/modificar.png" height="45px"/> Actualizar Periodo de Viático
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-3">
                                codpersona<input type = "text" name = "codpersona" placeholder="codpersona" value = "<?php echo $lista[1]; ?>" class="form-control" id="codpersona" />
                            </div>
                            <div class="col-lg-3">
                                periodo_mes<input type = "text" name = "periodo_mes" placeholder="periodo_mes" value = "<?php echo $lista[2]; ?>" class="form-control" id="periodo_mes" />
                            </div>
                            <div class="col-lg-3">
                                periodo_ano<input type = "text" name = "periodo_ano" placeholder="periodo_ano" value = "<?php echo $lista[3]; ?>" class="form-control" id="periodo_ano" />
                            </div>
                            <div class="col-lg-3">
                                cargo<input type = "text" name = "cargo" placeholder="cargo" value = "<?php echo $lista[4]; ?>" class="form-control" id="cargo" />
                            </div>
                            <div class="col-lg-3">
                                saldo<input type = "text" name = "saldo" placeholder="saldo" value = "<?php echo $lista[5]; ?>" class="form-control" id="saldo" />
                            </div>
                            <div class="col-lg-3">
                                dom_user<input type = "text" name = "dom_user" placeholder="dom_user" value = "<?php echo $lista[6]; ?>" class="form-control" id="dom_user" />
                            </div>
                        </div>
                    </div>  
                </div>
                <center>
                    <input type="submit" value="Guardar" class="btn btn-primary" />
                    <a href="#" onclick="cargar('#principal', '_viaticos.php')" class="btn btn-danger">Regresar</a>
                    <input type="hidden" id="accion" name="accion" value="ModViatico" />                    
                    <input type="hidden" id="codviatico" name="codviatico" value="<?php echo trim($lista[0]); ?>" />          
                </center>
            </div>                       
        </form>
        <br/>
        <p><div id="result_u"></div>
    </body>
</html>

