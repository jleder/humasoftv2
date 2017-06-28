<?php
include_once '../controller/C_Propuestas.php';
$cli = new C_Cliente();
$clientes = $cli->listarSoloClientes();
?>
<html>
    <body>
        <div class="row">
            <div id="breadcrumb" class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="#">Propuestas</a></li>
                    <li><a href="#">Propuestas por Cliente</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="well">
                    <div class="row">                        
                        <div class="col-md-3">
                            <label>Cliente</label>
                            <select id="clientes" name="clientes" title="Escribir nombre de Cliente">                                
                                <?php foreach ($clientes as $cliente) { ?>                                
                                    <option value="<?php echo trim($cliente[0]); ?>"> <?php echo trim($cliente['cliente']); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Estado Comercial</label>
                            <select id="ecomercial" name="ecomercial" title="Seleccione Estado Comercial">
                                <option value="TODOS">TODOS</option>
                                <option value="EN VENDEDOR">EN VENDEDOR</option>
                                <option value="EN CLIENTE">EN CLIENTE</option>
                                <option value="EN SEGUIMIENTO">EN SEGUIMIENTO</option>
                                <option value="APROBADO">APROBADO</option>
                                <option value="NO APROBADO">NO APROBADO</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <br/>
                            <!--<button type="button" class="btn btn-primary btn-app-sm btn-circle"><i class="fa fa-camera"></i></button>-->
                            <a class="btn btn-primary" href="#" onclick="buscar()"><i class="fa fa-search"></i> Buscar</a>
                        </div>                        
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-12" id="divresult">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">

            function buscar() {
                var codcliente = $("#clientes").val();
                var ecomer = $("#ecomercial").val();
                if (ecomer === 'TODOS') {
                    from_2('1', codcliente, 'divresult', '_propuestav2_cliente_result.php');
                } else {
                    from_3('2', codcliente, ecomer, 'divresult', '_propuestav2_cliente_result.php');
                }
            }


            function descargarExcel() {
                var excel = 'Excel';
                var result = excel.link("_propuestav2_cliente_excel.php");                
            }



            //<![CDATA[
            function Select2Test() {
                $("#clientes").select2();
                $("#ecomercial").select2();
            }
            $(document).ready(function () {
                // Load script of Select2 and run this
                LoadSelect2Script(Select2Test);
                WinMove();

            });
        </script>
    </body>
</html>
