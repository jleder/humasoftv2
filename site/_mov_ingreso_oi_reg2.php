<?php
session_start();
unset($_SESSION['carrito_oc']);
include '../controller/C_Movimientos.php';

$obj_producto = new C_Producto();
$obj_almacen = new Almacen();
$oimp = new OrdenCompra();
$oimpdet = new OrdenCompraDetalle();

$numero = $_GET['codigo'];
$oimp->__set('numero_oc', trim($numero));
$oimpdet->__set('numero_oc', trim($numero));
$lista = $oimp->listarByNumOC();
$listaDetalle = $oimpdet->listarByNumOC();

$listaProductos = $obj_producto->getProductosAll();
$listaAlmacen = $obj_almacen->listarAlmacenes();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
                        url: "../controller/C_Movimientos.php",
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

            function getInfoImport() {
                var transac_numero = $("#transac_numero").val();
                if (transac_numero === '') {
                    alert("Ingrese Numero");
                } else {
                    from_2('LoadDatosImportacion', transac_numero, 'divinfoimport', '_mov_ingreso_oi_reg_load.php');
                }

            }

            function getTablaProducto() {
                var transac_numero = $("#transac_numero").val();
                if (transac_numero === '') {
                    alert("Ingrese Numero");
                } else {
                    from_2('LoadDatosImportacionDetalle', transac_numero, 'divcarrito', '_mov_ingreso_oi_reg_load.php');
                }
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
                from_2(accion, variables, 'divcarrito', '_ordimport_reg_car.php');
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
        <div class="row">
            <div id="breadcrumb" class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="#">Inventario</a></li>
                    <li><a href="#">Ingreso por Importacion</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-9">
                <form id="form_compra" name="form_compra" action="#" method="post" enctype="multipart/form-data">
                    <div id="form_reg">
                        <div class="panel panel-default">                        
                            <div class="panel-heading">Nota de Ingreso a partir de Orden de Importación</div>
                            <div class="panel-body">                                                            
                                <div class="row">                            
                                    <div class="col-lg-3">
                                        Número Orden de Importación<input type = "text" name = "transac_numero" value = "<?php echo $lista[0]; ?>"  class="form-control" id="transac_numero" readonly="" />
                                    </div>                                
                                </div>                                
                                <div class="row" id="divinfoimport">
                                    <div class="col-lg-6">
                                        Proveedor<input type = "text" name = "nomproveedor" value = "<?php echo $lista[2]; ?>" class="form-control" readonly="" />
                                    </div>
                                    <div class="col-lg-3">
                                        Emision<input type = "text" name = "fecha_oc" placeholder="DD/MM/YYYY" value = "<?php echo date("d/m/Y", strtotime($lista[7])); ?>" class="form-control" readonly="" />
                                    </div>
                                    <div class="col-lg-3">
                                        Entrega<input type = "text" name = "fecentrega" placeholder="DD/MM/YYYY" value = "<?php echo date("d/m/Y", strtotime($lista[9])); ?>" class="form-control" readonly="" />
                                    </div>
                                </div>
                                <hr/>
                                <div class="row">                                                                
                                    <div class="col-lg-3">
                                        Fecha Ingreso<input type = "text" name = "fecmov" placeholder="DD/MM/YYYY" value = "" class="form-control" id="cal" />
                                    </div>
                                    <div class="col-lg-3">
                                        Almacen
                                        <select name = "idalmacen" class="form-control" id="idalmacen">                                            
                                            <?php
                                            foreach ($listaAlmacen as $almacen) {
                                                echo '<option value="' . $almacen['codalmacen'] . '">' . trim($almacen['nombre']) . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        Tipo Transaccion
                                        <input type = "text" name = "transac_tipo" value = "INGRESO X IMPORTACION" class="form-control" readonly="" />
                                    </div>                                    
                                </div>                                                                                               
                                <div class="row">                                                                
                                    <div class="col-lg-12">
                                        Observaciones
                                        <textarea rows="3" cols="20" name = "obs" class="form-control" id="obs"></textarea>
                                    </div>                            
                                </div>                                
                                <div class="row">
                                    <div class="col-lg-12" id="divcarrito">
                                        <table class="table table-bordered" style="font-size: 10px;">
                                            <thead>
                                                <tr>            
                                                    <th></th>
                                                    <th style="text-align: center;">COD PROD</th>
                                                    <th style="text-align: center;">DESCRIPCION</th>
                                                    <th style="text-align: center;">UND.</th>
                                                    <th style="text-align: center;">CANT</th>
                                                    <th style="text-align: center;">SALDO</th>
                                                    <th style="text-align: center;">CANT RECIBIDA</th>
                                                </tr>
                                            </thead> 
                                            <tbody>
                                                <?php
                                                $ncarrito = count($listaDetalle);

                                                if ($ncarrito > 0) {
                                                    $indice = 1;
                                                    foreach ($listaDetalle as $producto) {
                                                        $codigo = $producto['codigo'];
                                                        $codprod = $producto['codprod'];
                                                        $nombre = strtoupper($producto['nombre']);
                                                        $umedida = $producto['umedida'];
                                                        $cantidad = $producto['cantidad'];
                                                        $precio = $producto['preciou'];
                                                        $saldo = 0;
                                                        if ($producto['saldo'] <> '') {
                                                            $saldo = $producto['saldo'];
                                                        }
                                                        ?>
                                                        <tr style="font-size: 10px;">                    
                                                            <td style="text-align: center;">
                                                                <input type="hidden" name="codigo[]" value="<?php echo $codigo; ?>" />
                                                                <input type="hidden" name="precio[]" value="<?php echo $precio; ?>" />
                                                                <?php echo $indice; ?>
                                                            </td>
                                                            <td style="text-align: left;"><input type="hidden" name="codprod[]" value="<?php echo $codprod; ?>" /><?php echo $codprod; ?></td>
                                                            <td><?php echo $nombre; ?></td>
                                                            <td style="text-align: center;"><input type="hidden" name="umedida[]" value="<?php echo $umedida; ?>" /><?php echo $umedida; ?></td>
                                                            <td style="text-align: center;"><?php echo number_format($cantidad, 2); ?></td>
                                                            <td style="text-align: center;"><input type="hidden" name="saldo[]" value="<?php echo $saldo; ?>" /><?php echo number_format($saldo, 2); ?></td>
                                                            <td><input type="number" style="width: 100px;" value="<?php echo $saldo; ?>" step="any" name="cantidad[]" id="cantidad" /></td>
                                                        </tr>
                                                        <?php
                                                        $indice++;
                                                    }
                                                } else {
                                                    echo '<tr style="color:red"><td colspan=7>No hay productos.</td></tr>';
                                                }
                                                ?>        
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>  
                        </div>
                        <center>
                            <input type="submit" value="Guardar" class="btn btn-success" />
                            <a href="#" onclick="cargar('#principal', '_ordimport.php')" class="btn btn-danger">Regresar</a>
                            <input type="hidden" id="accion" name="accion" value="RegMovOrdenImp" />
                        </center>
                    </div>                       
                </form>
                <br/>
                <div id="result_compra"></div>
            </div>
        </div>

        <script type="text/javascript">

            $(function () {
                $('#cal').datepicker($.extend({
                    showMonthAfterYear: false,
                    dateFormat: 'dd/mm/yy'
                },
                        $.datepicker.regional['es']
                        ));
            });
        </script>
    </body>
</html>