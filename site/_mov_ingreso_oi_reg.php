<?php
header("Cache-Control: no-cache, must-revalidate");
$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["conectado"])) {
    if ($_SESSION["conectado"] == 'SI') {
        unset($_SESSION['carrito_oc']);
        include '../controller/C_Movimientos.php';

        $obj_producto = new C_Producto();
        $obj_almacen = new Almacen();

        $listaProductos = $obj_producto->getProductosAll();
        $listaAlmacen = $obj_almacen->listarAlmacenes();
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
                                        <li><a href="">Inventario</a></li>
                                        <li><a href="_mov_ingreso_oi_reg.php">Ingreso por Importacion</a></li>
                                    </ol>
                                </div>
                            </div>
                            <div class="row">                        
                                <div class="col-xs-12 col-sm-12">
                                    <div class="box">
                                        <div class="box-header">
                                            <div class="box-name">
                                                <i class="fa fa-briefcase"></i>
                                                <span>Formulario para Registrar </span>
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
                                                <div class="col-lg-9">
                                                    <form id="form_compra" name="form_compra" action="#" method="post" enctype="multipart/form-data">
                                                        <div id="form_reg">
                                                            <div class="panel panel-default">                        
                                                                <div class="panel-heading">Nota de Ingreso a partir de Orden de Importación</div>
                                                                <div class="panel-body">                                                            
                                                                    <div class="row">                            
                                                                        <div class="col-lg-3">
                                                                            Número Orden de Importación<input type = "text" name = "transac_numero" value = "" class="form-control" id="transac_numero" onblur="getInfoImport()" />
                                                                        </div>                                
                                                                    </div>                                
                                                                    <div class="row" id="divinfoimport">
                                                                        <div class="col-lg-6">
                                                                            Proveedor<input type = "text" name = "nomproveedor" placeholder="" value = "" class="form-control" readonly="" />
                                                                        </div>
                                                                        <div class="col-lg-3">
                                                                            Emision<input type = "text" name = "fecha_oc" placeholder="DD/MM/YYYY" value = "" class="form-control" readonly=""/>
                                                                        </div>
                                                                        <div class="col-lg-3">
                                                                            Entrega<input type = "text" name = "fecentrega" placeholder="DD/MM/YYYY" value = "" class="form-control" readonly="" />
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
                                                                        <div style="text-align: right" class="col-lg-12">
                                                                            <br/>
                                                                            <a href="#divproductos" class="btn btn-default btn-sm" onclick="getTablaProducto()" ><img src="img/iconos/add-car.png" height="20" /> Cargar Productos</a>
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
        <?php
    }
} else {
    header("Location:recursos/logout.php");
}
?>