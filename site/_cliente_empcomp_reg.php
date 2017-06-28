<?php
include '../controller/C_ClientexVendedor.php';
$clvdb01 = new ClientexVendedor();
$clvdb02 = new ClientexVendedorCompartido();

$codclv = $_GET['cod'];

$vendedores = $clvdb01->listar_aausdb01_vendedores();
?>


<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />                            
        <script type="text/javascript">

            function validar() {

                var vendedor = $("#codven").val();

                if (vendedor === "0") {
                    alert("Debe seleccionar vendedor");
                    $("#codven").focus();
                    return false;
                }
                return true;
            }


            $(document).ready(function () {
                $("#form_clv2").submit(function (e) {
                    e.preventDefault();
                    var rpta = validar();
                    if (rpta === true) {

                        var f = $(this);
                        var formData = new FormData(document.getElementById("form_clv2"));
                        var nomven = $("#codven option:selected").html();
                        formData.append("nomven", nomven);

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
                                    $("#result").html(res);
                                });

                    }
                });
            });
        </script>                
    </head>
    <body> 
        <form id="form_clv2" name="form_clv2" action="#" method="post" enctype="multipart/form-data">            
            <div id="form_reg">
                <div class="panel panel-default">                        
                    <div class="panel-heading">Llenar datos</div>
                    <div class="panel-body">                                                            
                        <div class="row">                                                                                        
                            <div class="col-lg-4">
                                Vendedor
                                <select name = "codven" class="form-control input-sm" id="codven">
                                    <option value="0">seleccione...</option>                                      
                                    <?php
                                    foreach ($vendedores as $vendedor) {
                                        echo '<option value="' . $vendedor['coduse'] . '">' . strtoupper($vendedor['desuse']) . '</option>';
                                    }
                                    ?>
                                </select>

                            </div>                            
                            <div class="col-lg-2">
                                % Comision PAQ<input type = "number" name = "comisionpaq" value = "0" step="any" class="form-control input-sm" id="comisionpaq" />
                            </div>            
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                Observación
                                <textarea name="obs" id="obs" class="form-control" rows="4" cols="20"></textarea>
                            </div>                            
                        </div>
                    </div>  
                </div>
                <center>
                    <input type="submit" value="Guardar" class="btn btn-success" />                    
                    <input type="hidden" id="accion" name="accion" value="RegClientexVendedorCompartido" />                    
                    <input type = "hidden" name = "codclv" value = "<?php echo $codclv; ?>" id="codclv" />
                </center>
            </div>                       
        </form>
        <br/>
        <p><div id="result"></div>
    </body>
</html>