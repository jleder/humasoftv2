<?php
header("Cache-Control: no-cache, must-revalidate");
$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["conectado"])) {
    if ($_SESSION["conectado"] == 'SI') {

        unset($_SESSION['carrito']);
        include '../controller/C_OrdenPedido.php';

        $obj_cliente = new ClientexVendedor();
        $obj_producto = new C_Producto();

        $listaClientes = $obj_cliente->getClientesAll();
        $listaVendedores = $obj_cliente->listar_aausdb01_vendedores();
        $listaProductos = $obj_producto->getProductosAll();
        ?>
        <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="utf-8">
                <title>Humasoft</title>
                <meta name="description" content="description">
                <meta name="author" content="Juan">
                <?php include 'head.php'; ?>   
            </head>
            <body> 
                <?php include 'header.php'; ?>
                <!--End Header-->

                <!--Start Container-->
                <div id="main" class="container-fluid">
                    <div class="row">
                        <div id="sidebar-left" class="col-xs-2 col-sm-2">
                            <?php include 'menu.php'; ?>
                        </div>
                        <!--Start Content-->                        
                        <div id="content" class="col-xs-12 col-sm-10">                            
                            <div class="row">
                                <div id="breadcrumb" class="col-md-12">
                                    <ol class="breadcrumb">
                                        <li><a href="Dashboard.php">Dashboard</a></li>
                                        <li><a href="_pedido.php">Pedidos</a></li>
                                        <li><a href="_pedido_reg.php">Registrar Pedido</a></li>
                                    </ol>
                                </div>
                            </div>

                            <div class="row">                        
                                <div class="col-xs-12 col-sm-12">
                                    <div class="box">
                                        <div class="box-header">
                                            <div class="box-name">
                                                <i class="fa fa-briefcase"></i>
                                                <span>Formulario para Registrar Pedido</span>
                                            </div>
                                            <div class="box-icons">
                                                <a class="collapse-link">
                                                    <i class="fa fa-chevron-up"></i>
                                                </a>
                                                <a class="expand-link">
                                                    <i class="fa fa-expand"></i>
                                                </a>
                                                <a class="close-link">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            </div>
                                            <div class="no-move"></div>
                                        </div>
                                        <div class="box-content form-horizontal">                                                                                                                
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <form id="form_pedido" name="form_pedido" action="#" method="post" enctype="multipart/form-data">                
                                                        <div id="form_reg">
                                                            <div class="panel panel-default">                        
                                                                <div class="panel-heading">Llenar datos</div>
                                                                <div class="panel-body">                                                            
                                                                    <div class="row">                            
                                                                        <div class="col-lg-3">
                                                                            Número de Pedido<input type = "text" name = "codpedido" value = "" class="form-control" id="codpedido" />
                                                                        </div>
                                                                        <div class="col-lg-3">
                                                                            Fecha Pedido<input type = "text" name = "fecpedido" placeholder="YYYY/MM/DD" value = "" class="form-control" id="cal" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">                                                                
                                                                        <div class="col-lg-6">
                                                                            Cliente
                                                                            <select name = "codcli" class="form-control input-sm" id="codcli" onchange="getInfoCliente()">                                        
                                                                                <option value="0"></option>                                        
                                                                                <?php
                                                                                foreach ($listaClientes as $cliente) {
                                                                                    echo '<option value="' . $cliente['codcliente'] . '">' . strtoupper($cliente['nombre']) . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div id="infocliente">
                                                                        <div class="row">                                                                
                                                                            <div class="col-lg-3">
                                                                                RUC<input type = "text" name = "ruc" placeholder="" value = "" class="form-control" id="ruc" />
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                Nombre de Cliente<input type = "text" name = "nomcliente" placeholder="" value = "" class="form-control" id="nomcliente" />
                                                                            </div>
                                                                            <div class="col-lg-3">
                                                                                Telefono Cliente<input type = "text" name = "telefono" placeholder="" value = "" class="form-control" id="telefono" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">                                                                
                                                                            <div class="col-lg-12">
                                                                                Direccion Cliente
                                                                                <textarea rows="3" cols="20" name = "dircli" class="form-control" id="dircli"></textarea>
                                                                            </div>
                                                                            <div class="col-lg-12">
                                                                                Mes
                                                                                <input type="week" class="form-control" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">                                                                
                                                                        <div class="col-lg-6">
                                                                            Contacto<input type = "text" name = "contacto" placeholder="" value = "" class="form-control" id="contacto" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">                                                                
                                                                        <div class="col-lg-3">
                                                                            Número de Orden de Compra<input type = "text" name = "numero_oc" placeholder="" value = "" class="form-control" id="numero_oc" />
                                                                        </div>
                                                                        <div class="col-lg-3">
                                                                            Fecha de Orcen de Compra<input type = "text" name = "fecoc" placeholder="YYYY/MM/DD" value = "" class="form-control" id="cal2" />
                                                                        </div>
                                                                        <div class="col-lg-3">
                                                                            Forma de Pago<input type = "text" name = "fpago"  value = "" class="form-control" id="fpago" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">                                                                
                                                                        <div class="col-lg-6">
                                                                            Vendedor                                    
                                                                            <select name="codven" class="form-control input-sm" id="codven">
                                                                                <option value="0">seleccione...</option>                                        
                                                                                <?php
                                                                                foreach ($listaVendedores as $vendedor) {
                                                                                    echo '<option value="' . $vendedor['coduse'] . '">' . strtoupper($vendedor['desuse']) . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-lg-3">
                                                                            Tipo Dscto                                    
                                                                            <select name = "tipodcto" class="form-control" id="tipodcto" onchange="mostrarDescuento()">
                                                                                <option value="PUD">DSCTO POR PRODUCTO UNITARIO</option>
                                                                                <option value="PAQ">DSCTO POR PAQUETE</option>                              
                                                                            </select>
                                                                        </div>
                                                                        <div hidden="" id="divdcto" class="col-lg-3">
                                                                            Descuento ($)
                                                                            <input type="number" name="descuento" id="descuento" value="0" class="form-control input-sm" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">                                                                
                                                                        <div class="col-lg-3">
                                                                            IGV (%)<input type = "number" name = "igv" value = "18.00" step="any" class="form-control input-sm" id="igv" />
                                                                        </div>             
                                                                        <div class="col-lg-3">
                                                                            Flete ($)<input type = "number" step="any" name = "flete" value = "0" class="form-control" id="flete" />
                                                                        </div> 
                                                                        <div class="col-lg-3">
                                                                            Factor Aprobación<input type = "number" step="any" name = "fau" value = "0" class="form-control" id="fau" />
                                                                        </div> 
                                                                    </div>
                                                                    <div class="row">                                                                
                                                                        <div class="col-lg-12">
                                                                            Lugar de Entrega
                                                                            <input type = "text" name = "lugar_entrega" placeholder="" value = "" class="form-control" id="lugar_entrega" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">                                                                
                                                                        <div class="col-lg-12">
                                                                            Detalle de Entrega
                                                                            <textarea rows="3" cols="20" name = "detalle_entrega" class="form-control" id="detalle_entrega"></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">                                                                
                                                                        <div class="col-lg-12">
                                                                            Observaciones
                                                                            <textarea rows="3" cols="20" name = "obs" class="form-control" id="obs"></textarea>
                                                                        </div>                            
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <h4>Agregar Productos</h4>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-6">                                    
                                                                            Producto:           
                                                                            <select class="form-control input-sm" id="codprod"  name="codprod" onchange="" onblur="">
                                                                                <option value=""></option>
                                                                                <?php foreach ($listaProductos as $val) { ?>                                
                                                                                    <option value="<?php echo $val['codigo'] ?>"> <?php echo trim($val['nombre']); ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>                                
                                                                        <div class="col-lg-2">
                                                                            Cantidad
                                                                            <input type="number" name="cantidad" id="cantidad" class="form-control input-sm" value="0" step="any" min="0" />
                                                                        </div>
                                                                        <div class="col-lg-2">
                                                                            U. Medida
                                                                            <select class="form-control input-sm" name="umedida" id="umedida">
                                                                                <option value="LT">LITROS</option>
                                                                                <option value="BD">BIDONES</option>
                                                                                <option value="BD">CAJA</option>
                                                                                <option value="0">OTRO</option>                                        
                                                                            </select>
                                                                        </div>   
                                                                        <div class="col-lg-2">
                                                                            Precio Unitário
                                                                            <input type="number" name="precio" id="precio" class="form-control input-sm" value="0" step="any" min="0" />
                                                                        </div> 
                                                                    </div>
                                                                    <div class="row">                                
                                                                        <div style="text-align: right" class="col-lg-12">
                                                                            <br/>
                                                                            <a href="#divproductos" class="btn btn-default btn-sm" onclick="addProducto()" ><img src="img/iconos/add-car.png" height="20" /> Agregar Producto</a>
                                                                        </div>                                                    
                                                                    </div>
                                                                    <br/>
                                                                    <div class="row">
                                                                        <div class="col-lg-12" id="divcarrito">

                                                                        </div>
                                                                    </div>
                                                                </div>  
                                                            </div>
                                                            <center>
                                                                <input type="submit" value="Guardar" class="btn btn-success" />
                                                                <a href="#" onclick="cargar('#principal', '_pedido.php')" class="btn btn-danger">Regresar</a>
                                                                <input type="hidden" id="accion" name="accion" value="RegPedidoV1" />
                                                            </center>
                                                        </div>                       
                                                    </form>
                                                    <br/>
                                                    <div id="result_pedido"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                        <!--End Content-->
                    </div>
                </div>
                <!--End Container-->
                <?php include 'script.php'; ?>

                <script type="text/javascript">


                    $(document).ready(function () {
                        $("#form_pedido").submit(function (e) {
                            e.preventDefault();
                            var f = $(this);

                            var formData = new FormData(document.getElementById("form_pedido"));
                            var nomcli = $("#codcli option:selected").html();
                            var nomven = $("#codven option:selected").html();
                            formData.append("nomcli", nomcli);
                            formData.append("nomven", nomven);

                            $.ajax({
                                url: "../controller/C_OrdenPedido.php",
                                type: "post",
                                dataType: "html",
                                data: formData,
                                cache: false,
                                contentType: false,
                                processData: false
                            })
                                    .done(function (res) {
                                        $("#result_pedido").html(res);
                                    });
                        });
                    });

                    function getInfoCliente() {
                        var codcli = $("#codcli").val();
                        from_unico(codcli, 'infocliente', '_pedido_reg_loadinfocli.php');
                    }

                    function addProducto() {
                        var accion = "ADDPRODUCTO";
                        var codprod = $("#codprod").val();
                        var nomprod = $("#codprod option:selected").html();
                        var cantidad = $("#cantidad").val();
                        var umedida = $("#umedida").val();
                        var precio = $("#precio").val();
                        var descuento = $("#descuento").val();
                        var igv = $("#igv").val();
                        var flete = $("#flete").val();

                        var variables = [codprod, nomprod, cantidad, umedida, precio, descuento, igv, flete];
                        from_2(accion, variables, 'divcarrito', '_pedido_reg_car.php');
                    }

                    function mostrarDescuento() {
                        var tipodcto = $("#tipodcto").val();
                        var divdcto = document.getElementById('divdcto');

                        switch (tipodcto) {
                            case 'PAQ':
                                divdcto.style.display = "block";
                                break;
                            case 'PUD':
                                divdcto.style.display = "none";
                                $("#descuento").val("0");
                                break;
                        }
                    }

                    function actualizarTabla() {

                    }

                </script>
            </body>
        </html>
        <?php
    }
} else {
    header("Location:recursos/logout.php");
}
?>




