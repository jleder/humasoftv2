<?php
include '../controller/C_ClientexVendedor.php';
$obj = new ClientexVendedor();
$id = $_GET['cod'];
$obj->__set('codclv', $id);
$lista = $obj->listarByCod();
$vendedores = $obj->listar_aausdb01_vendedores();

$fecapertura = date("d/m/Y", strtotime($lista[3]));
$compartido = 'SI';
if ($lista[4] == 'f') {
    $compartido = 'NO';
}
?>


<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />                            
        <!--calendario-->        
        <script type="text/javascript" src="js/js_inscoltec.js"></script>
        <style type="text/css">            
            @import "util/media/themes/smoothness/jquery-ui-1.8.4.custom.css";   
        </style>
        <script type="text/javascript">
            
            function validar() {
                var vendedor = $("#codven").val();
                var cliente = $("#codcli").val();
                var fecapertura = $("#cal").val();

                if (cliente === "0") {
                    alert("Debe seleccionar un cliente");
                    $("#codcli").focus();
                    return false;
                } else if (vendedor === "0") {
                    alert("Debe seleccionar vendedor");
                    $("#codven").focus();
                    return false;
                } else if (fecapertura === "") {
                    alert("Debe ingresar fecha de inicio");
                    $("#cal").focus();
                    return false;
                }
                return true;
            }

            $(document).ready(function () {
                $("#form_clv_u").submit(function (e) {
                    e.preventDefault();
                    var rpta = validar();


                    if (rpta === true) {

                        var nomcli = $("#codcli option:selected").html();
                        var nomven = $("#codven option:selected").html();


                        var f = $(this);
                        var formData = new FormData(document.getElementById("form_clv_u"));
                        formData.append("nomcli", nomcli);
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
                                    $("#result_clv_u").html(res);
                                });
                    }
                });
            });
            
        </script>                
    </head>
    <body> 
        <form id="form_clv_u" name="form_clv_u" action="#" method="post" enctype="multipart/form-data">                    
            <div id="form_reg">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <img src="img/iconos/modificar.png" height="15px"/> Modificar
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6">
                                Cliente
                                <select name = "codcli" class="form-control input-sm" id="codcli">                                        
                                    <option value="<?php echo $lista[1]; ?>"><?php echo $lista[12]; ?></option>
                                </select>   
                            </div>
                            <div class="col-lg-4">
                                Vendedor                                
                                <select name = "codven" class="form-control input-sm" id="codven">
                                    <option value="<?php echo $lista[2]; ?>"><?php echo $lista[11]; ?></option>
                                    <option value="<?php echo $lista[2]; ?>">cambiar por...</option>
                                    <?php
                                    foreach ($vendedores as $vendedor) {
                                        echo '<option value="' . $vendedor['coduse'] . '">' . strtoupper($vendedor['desuse']) . '</option>';
                                    }
                                    ?>
                                </select>  
                            </div>
                            <div class="col-lg-2">
                                Fecha Inicio<input type = "text" name = "fecapertura" placeholder="fecapertura" value = "<?php echo $fecapertura; ?>" class="form-control" id="cal" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                ¿Se comparte este cliente?
                                <select name = "compartido" class="form-control input-sm" id="compartido">
                                    <option value="<?php echo $lista[4]; ?>"><?php echo $compartido; ?></option>
                                    <option value="<?php echo $lista[4]; ?>">cambiar por...</option>
                                    <option value="t">SI</option>
                                    <option value="f">NO</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                Comision por Paquete
                                <input type = "number" name = "comisionpaq" value = "<?php echo $lista[5]; ?>" class="form-control" id="comisionpaq" step="any" />
                            </div>                            
                        </div>
                    </div>  
                </div>
                <center>
                    <input type="submit" value="Guardar" class="btn btn-primary" />
                    <input type="hidden" id="accion" name="accion" value="ModClientexVendedor" />                    
                    <input type="hidden" id="codclv" name="codclv" value="<?php echo trim($lista[0]); ?>" />          
                </center>
            </div>                       
        </form>
        <br/>
        <p><div id="result_clv_u"></div>
    </body>
</html>