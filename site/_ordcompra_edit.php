<?php
//session_start();
//unset($_SESSION['carrito_oc']);

include '../controller/C_OrdenCompra.php';
$ocom = new OrdenCompra();
$ocod = new OrdenCompraDetalle();
$obj_proveedor = new Proveedor();
$obj_producto = new C_Producto();

$listaProductos = $obj_producto->getProductosAll();

$numero_oc = $_GET['cod'];
$ocom->__set('numero_oc', $numero_oc);
$ocod->__set('numero_oc', $numero_oc);

$listaoc = $ocom->listarOCByNumOC();

//Obteniendo Variables
$codproveedor = $listaoc[1];
$nomprovedor = $listaoc[2];
$codcia = $listaoc[3];
$contacto = $listaoc[4];
$via = $listaoc[5];
$fpago = $listaoc[6];
$fecha_oc = $listaoc[7];
$obs = $listaoc[8];
$descia = $listaoc[10];
$dircia = $listaoc[11];
$telcia = $listaoc[12];
$ruccia = $listaoc[13];
$dirent = $listaoc[14];
$discia = $listaoc[15];
$pais = $listaoc[16];
?>
<html>
    <head>
        <!--calendario-->        
        <script type="text/javascript" src="js/js_inscoltec.js"></script>
        <style type="text/css">            
            @import "util/media/themes/smoothness/jquery-ui-1.8.4.custom.css";   
        </style>

        <script type="text/javascript">

            $(document).ready(function () {
                $("#form_compra").submit(function (e) {
                    e.preventDefault();
                    var f = $(this);

                    var formData = new FormData(document.getElementById("form_compra"));
                    //var nomcli = $("#codcli option:selected").html();
                    //var nomven = $("#codven option:selected").html();
                    //formData.append("nomcli", nomcli);
                    //formData.append("nomven", nomven);

                    $.ajax({
                        url: "../controller/C_OrdenCompra.php",
                        type: "post",
                        dataType: "html",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false
                    })
                            .done(function (res) {
                                $("#result_compra").html(res);
                            });
                });
            });

            function getInfoCia() {
                var codcia = $("#codcia").val();
                from_2('LoadCia', codcia, 'divinfocia', '_ordcompra_reg_load.php');
            }

            function addProducto() {
                var accion = "ADDPRODUCTO";
                var codprod = $("#codprod").val();
                var nomprod = $("#codprod option:selected").html();
                var cantidad = $("#cantidad").val();
                var umedida = $("#umedida").val();
                var cantidadp = $("#cantidadp").val();
                var present = $("#presentacion").val();
                var preciou = $("#preciou").val();
                var container = $("#container").val();

                var variables = [codprod, nomprod, cantidad, umedida, preciou, present, cantidadp, container];
                from_2(accion, variables, 'divcarrito', '_ordcompra_reg_car.php');
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

            function getCantPresentacion() {
                var cantidad = $("#cantidad").val();
                var present = $("#presentacion").val();
                var cantpre = 0;
                var result = 0;

                if (present === 'TOTTE') {
                    result = parseFloat(cantidad) / 1040;
                    cantpre = Math.ceil(result);
                    $("#cantidadp").val(cantpre);
                } else if (present === 'PALLET') {
                    result = parseFloat(cantidad) / 900;
                    cantpre = Math.ceil(result);
                    $("#cantidadp").val(cantpre);
                }
            }

            function loadPrecioUnitario() {
                var codprod = $("#codprod").val();
                from_2('LoadPrecioUnitario', codprod, 'divpreciou', '_ordcompra_reg_load.php');
            }
        </script>                
    </head>
    <body> 
        <div class="col-lg-6">
            <form id="form_compra" name="form_compra" action="#" method="post" enctype="multipart/form-data">
                <div id="form_reg">
                    <div class="panel panel-primary">                        
                        <div class="panel-heading">Modificar Orden de Compra</div>
                        <div class="panel-body">                                                            
                            <div class="row">                            
                                <div class="col-lg-3">
                                    Número Orden de Compra<input type = "text" name = "numero_oc" value = "<?php echo trim($numero_oc); ?>" class="form-control" id="numero_oc" />
                                </div>
                                <div class="col-lg-3">
                                    Fecha<input type = "text" name = "fecha_oc" placeholder="YYYY/MM/DD" value = "<?php echo date("Y/m/d", strtotime($fecha_oc)); ?>" class="form-control" id="cal" />
                                </div>
                            </div>
                            <div class="row">                                                                
                                <div class="col-lg-6">
                                    Proveedor
                                    <select name = "codproveedor" class="form-control input-sm" id="codproveedor" onchange="">
                                        <option value="<?php echo trim($codproveedor); ?>"><?php echo trim($nomprovedor); ?></option>
                                        <?php
                                        foreach ($listaProveedor as $proveedor) {
                                            echo '<option value="' . $proveedor['codigo'] . '">' . strtoupper($proveedor['nombre']) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">                                                                
                                <div class="col-lg-6">
                                    Compania
                                    <select name = "codcia" class="form-control input-sm" id="codcia" onchange="getInfoCia()">
                                        <option value="<?php echo trim($codcia); ?>"><?php echo trim($descia); ?></option>                                        
                                        <?php
                                        foreach ($listaCompania as $cia) {
                                            echo '<option value="' . trim($cia['codcia']) . '">' . strtoupper(trim($cia['descia'])) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div id="divinfocia">
                                <div class="row">                                                                
                                    <div class="col-lg-3">
                                        RUC<input type = "text" name = "ruc" placeholder="" value = "<?php echo trim($ruccia); ?>" class="form-control" id="ruc" />
                                    </div>
                                    <div class="col-lg-6">
                                        Dirección Fiscal<input type = "text" name = "dirfiscal" placeholder="" value = "<?php echo trim($dircia); ?>" class="form-control" id="dirfiscal" />
                                    </div>
                                    <div class="col-lg-3">
                                        Ciudad<input type = "text" name = "ciudad" placeholder="" value = "<?php echo trim($discia); ?>" class="form-control" id="ciudad" />
                                    </div>
                                </div>
                                <div class="row">                                                                
                                    <div class="col-lg-3">
                                        Pais<input type = "text" name = "pais" placeholder="" value = "<?php echo trim($pais); ?>" class="form-control" id="pais" />
                                    </div>
                                    <div class="col-lg-3">
                                        Telefono<input type = "text" name = "telefono" placeholder="" value = "<?php echo trim($telcia); ?>" class="form-control" id="telefono" />
                                    </div>
                                    <div class="col-lg-6">
                                        Contacto<input type = "text" name = "contacto" placeholder="" value = "<?php echo trim($contacto); ?>" class="form-control" id="contacto" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        Dirección de Entrega<input type = "text" name = "direntrega" placeholder="" value = "<?php echo trim($dirent); ?>" class="form-control" id="direntrega" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">                                                                
                                <div class="col-lg-3">
                                    Via
                                    <select class="form-control input-sm" name="via" id="via">
                                        <option value="<?php echo trim($via); ?>"><?php echo trim($via); ?></option>
                                        <option value="<?php echo trim($via); ?>">cambiar por...</option>
                                        <option value="MARITIMA">Maritima</option>
                                        <option value="AEREA">Aerea</option>
                                    </select>                                    
                                </div>                                
                                <div class="col-lg-3">
                                    Forma de Pago<input type = "text" name = "fpago"  value = "<?php echo trim($fpago); ?>" class="form-control" id="fpago" />
                                </div>
                            </div>                                                                                    
                            <div class="row">                                                                
                                <div class="col-lg-12">
                                    Observaciones
                                    <textarea rows="3" cols="20" name = "obs" class="form-control" id="obs"><?php echo trim($obs); ?></textarea>
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
                                    <select class="form-control input-sm" id="codprod"  name="codprod" onchange="loadPrecioUnitario()" onblur="">
                                        <option value=""></option>
                                        <?php foreach ($listaProductos as $val) { ?>                                
                                            <option value="<?php echo $val['codigo'] ?>"> <?php echo trim($val['nombre']); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>                                
                                <div class="col-lg-3">
                                    Cantidad
                                    <input type="number" name="cantidad" id="cantidad" class="form-control input-sm" value="0" step="any" min="0" onblur="getCantPresentacion()" />
                                </div>
                                <div class="col-lg-3">
                                    U. Medida
                                    <select class="form-control input-sm" name="umedida" id="umedida">
                                        <option value="LT">LITROS</option>                                        
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    Presentación
                                    <select class="form-control input-sm" name="presentacion" id="presentacion" onchange="getCantPresentacion()">
                                        <option value="PALLET">PALLET</option>
                                        <option value="TOTTE">TOTTE</option>                                        
                                        <option value="0">OTRO</option>                                        
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    Cantidad Presentación
                                    <input type="number" name="cantidadp" id="cantidadp" class="form-control input-sm" value="0" step="any" min="0" />
                                </div>
                                <div class="col-lg-3">
                                    Container Size
                                    <input type="number" name="container" id="container" class="form-control input-sm" value="40" step="any" min="0" />
                                </div>
                                <div class="col-lg-3" id="divpreciou">
                                    Precio Unitário
                                    <input type="number" name="preciou" id="preciou" class="form-control input-sm" value="0" step="any" min="0" />
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
                        <input type="submit" value="Actualizar" class="btn btn-success" />
                        <a href="#" onclick="cargar('#principal', '_ordcompra.php')" class="btn btn-danger">Regresar</a>
                        <input type="hidden" id="accion" name="accion" value="RegOrdenCompra" />
                    </center>
                </div>                       
            </form>
            <br/>
            <div id="result_compra"></div>
        </div>
        <script src="autocompleteboot/js/bootstrap.js" type="text/javascript"></script>
        <script src="autocompleteboot/js/bootstrap-combobox.js" type="text/javascript"></script>
        <script type="text/javascript">
                            $(document).ready(function () {
                                $('#codcli').combobox();
                            });

                            $(document).ready(function () {
                                $('#codprod').combobox();
                            });

        </script>
    </body>
</html>