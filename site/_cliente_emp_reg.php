<?php
include '../controller/C_ClientexVendedor.php';
$obj = new ClientexVendedor();

$clientes = $obj->getClientesAll();
$vendedores = $obj->listar_aausdb01_vendedores();
?>


<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />            
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
                $("#form_clv").submit(function (e) {
                    e.preventDefault();
                    var rpta = validar();


                    if (rpta === true) {

                        var nomcli = $("#codcli option:selected").html();
                        var nomven = $("#codven option:selected").html();


                        var f = $(this);
                        var formData = new FormData(document.getElementById("form_clv"));
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
                                    $("#result_clv").html(res);
                                });

                    }
                });
            });
        </script>                
    </head>
    <body> 
        <div class="row">
            <div id="breadcrumb" class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="#">Clientes</a></li>
                    <li><a href="#">Reg. Cliente x Vendedor</a></li>
                </ol>
            </div>
        </div>  
        <div class="row">
            <div class="col-lg-12">
                <form id="form_clv" name="form_clv" action="#" method="post" enctype="multipart/form-data">                
                    <div id="form_reg">
                        <div class="panel panel-default">                        
                            <div class="panel-heading">Registrar Cliente x Vendedor</div>
                            <div class="panel-body">                                                            
                                <div class="row">
                                    <div class="col-lg-6">
                                        Cliente
                                        <select name = "codcli" id="codcli">                                        
                                            <option value="0"></option>                                        
                                            <?php
                                            foreach ($clientes as $cliente) {
                                                echo '<option value="' . $cliente['codcliente'] . '">' . strtoupper($cliente['nombre']) . '</option>';
                                            }
                                            ?>
                                        </select>                                    
                                    </div>
                                    <div class="col-lg-4">
                                        Vendedor
                                        <select name = "codven" id="codven">
                                            <option value="0">seleccione...</option>                                        
                                            <?php
                                            foreach ($vendedores as $vendedor) {
                                                echo '<option value="' . $vendedor['coduse'] . '">' . strtoupper($vendedor['desuse']) . '</option>';
                                            }
                                            ?>
                                        </select>                                    
                                    </div>
                                    <div class="col-lg-2">
                                        Fecha Inicio<input type = "text" name = "fecapertura" value = "" placeholder="yyyy/mm/dd" class="form-control" id="fecapertura" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        ¿Se comparte este cliente?
                                        <select name = "compartido" class="form-control" id="compartido">
                                            <option value="f">NO</option>
                                            <option value="t">SI</option>                                        
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        % Comision por Paquete<input min="0" type = "number" step="any" name = "comisionpaq" placeholder="" value = "" class="form-control" id="comisionpaq" />
                                    </div>                                                                
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        Personas con quien comparte este cliente.
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <center>
                            <input type="submit" value="Guardar" class="btn btn-success" />                        
                            <input type="hidden" id="accion" name="accion" value="RegClientexVendedor" />                    
                        </center>
                    </div>                       
                </form>
                <br/>
                <p><div id="result_clv"></div>
            </div>
        </div>

        <script type="text/javascript">
            function Select2Test() {
                $("#codven").select2();
                $("#codcli").select2();
            }
            $(document).ready(function () {
                // Load script of Select2 and run this
                LoadSelect2Script(Select2Test);
                WinMove();
                $('.form-control').tooltip();
            });

            $(function () {
                $('#fecapertura').datepicker($.extend({
                    showMonthAfterYear: false,
                    dateFormat: 'dd/mm/yy'
                },
                        $.datepicker.regional['es']
                        ));
            });
        </script>
    </body>

</html>

