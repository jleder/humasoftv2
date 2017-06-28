<?php
/*
 * Proyecto Humasoft.
 * Desarrollado por Juan Leder
 */

header("Cache-Control: no-cache, must-revalidate");
$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["conectado"])) {
    if ($_SESSION["conectado"] == 'SI') {

        include '../controller/C_Proyecciones.php';
        $proy = new Proyeccion();
        $obj_producto = new C_Producto();

        $cultivo = $proy->listarCultivos();
        $clientes = $proy->listarSoloClientes();
        $listaEmp = $proy->listarEmpleadoAll();
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
                <style>
                    .selected{
                        cursor: pointer;
                    }
                    .selected:hover{
                        background-color: #0585C0;
                        color: white;
                    }

                    .seleccionada{
                        background-color: #0585C0;
                        color: white;
                    }


                </style>
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
                                        <li><a href="#">Proyecciones</a></li>
                                        <li><a href="#">Registrar</a></li>
                                    </ol>
                                </div>
                            </div>

                            <div class="row">                        
                                <div class="col-xs-12 col-sm-12">
                                    <div class="box">
                                        <div class="box-header">
                                            <div class="box-name">
                                                <i class="fa fa-briefcase"></i>
                                                <span>Registrar Proyeccion</span>
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
                                            <h5 class="page-header">Llene los Datos de Proyección</h5>
                                            <form id="form" name="form" action="#" method="post" enctype="multipart/form-data" class="form-horizontal">
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Año</label>
                                                    <div class="col-md-3">
                                                        <input type = "number" name = "proy_ano" placeholder="proy_ano" value = "<?php echo date("Y"); ?>" class="form-control" id="proy_ano" />
                                                    </div>
                                                    <label class="col-md-2 control-label">Mes</label>
                                                    <div class="col-md-3">
                                                        <select name="proy_mes" id="proy_mes">
                                                            <option value="0">- Seleccione -</option>
                                                            <?php
                                                            $meses = $proy->cargarMeses();
                                                            foreach ($meses as $key => $mes) {
                                                                ?>                                
                                                                <option value="<?php echo trim($key); ?>"> <?php echo trim($mes); ?></option>
                                                            <?php } ?>                                                    
                                                        </select>                                                        
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Asesor</label>
                                                    <div class="col-md-3">

                                                        <select id="codasesor"  name="codasesor">
                                                            <option value="<?php echo $_SESSION['codpersona'];?>"><?php echo $_SESSION['nombreUsuario']; ?></option>                                                            
                                                        </select> 
                                                    </div>
                                                    <label class="col-md-2 control-label">Cliente</label>
                                                    <div class="col-md-3">
                                                        <select name="codcliente" id="codcliente">
                                                            <?php foreach ($clientes as $cliente) { ?>                                
                                                                <option value="<?php echo trim($cliente[0]); ?>"> <?php echo trim($cliente['cliente']); ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Cultivo</label>
                                                    <div class="col-md-3">                                                        
                                                        <select id="cultivo"  name="cultivo">
                                                            <option value="">seleccione...</option>
                                                            <?php foreach ($cultivo as $valor) { ?>                                
                                                                <option value="<?php echo trim($valor['desele']); ?>"> <?php echo trim($valor['desele']); ?></option>
                                                            <?php } ?>
                                                            <option value="otro">..::Otro Cultivo</option>
                                                        </select>
                                                    </div>
                                                    <label class="col-md-2 control-label">Hectárea</label>
                                                    <div class="col-md-3">
                                                        <input type = "number" name = "ha" id="ha" value = "0" class="form-control" step="any" />
                                                    </div>                                                    
                                                </div>
                                                <h5 class="page-header">Ingrese Productos</h5>                                                
                                                <div class="form-group" id="divlitros">                                                    
                                                    <div class="col-md-4">                                    
                                                        Producto:           
                                                        <select id="codprod"  name="codprod" onchange="loadPrecioUnitario()">
                                                            <option value="0">- Seleccione -</option>
                                                            <?php foreach ($listaProductos as $val) { ?>                                
                                                                <option value="<?php echo $val['codigo'] ?>"> <?php echo trim($val['nombre']); ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>                                
                                                    <div class="col-md-2">
                                                        Cantidad
                                                        <input type="number" name="cantidad" id="cantidad" class="form-control" value="0" step="any" min="0" onblur="getCantPresentacion()" />
                                                    </div>
                                                    <div class="col-md-2">
                                                        U. Medida
                                                        <select class="form-control" name="umedida" id="umedida">
                                                            <option value="LT">LITROS</option>                                        
                                                        </select>
                                                    </div>                                                                                                        
                                                    <div class="col-md-2" id="divpreciou">
                                                        Precio Unitário
                                                        <input type="number" name="preciou" id="preciou" class="form-control" value="0" step="any" min="0" />
                                                    </div>                                                        
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 text-center">
                                                        <button type="button" id="btn_add" class="btn btn-primary btn-label-left"><span><i class="fa fa-plus-circle"></i></span> Agregar Producto</button>                                                        
                                                        <button title="Para eliminar: clic en el producto de la tabla y clic en este boton" type="button" id="btn_del" class="btn btn-danger btn-label-left"><span><i class="fa fa-trash-o"></i></span> Eliminar Producto</button>                                                        
                                                        <!--<button type="button" id="btn_num" class="btn btn-info">Show</button>-->
                                                        <!--<input type="number" id="numero" value="" />-->
                                                    </div>
                                                </div>                                              
                                                <div class="form-group">
                                                    <div class="col-md-12" id="divtabla_prod">
                                                        <table id="tbldetprod" class="table table-bordered">
                                                            <thead>
                                                                <tr style="background-color: #afafaf; color: white;">
                                                                    <th></th>
                                                                    <th>Producto</th>
                                                                    <th>Cantidad</th>
                                                                    <th>U Medida</th>
                                                                    <th>Precio U</th>
                                                                    <th>Sub Total</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="tbodyprod">
                                                                <tr>
                                                                    <td colspan="6">Tabla vacia</td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12" id="divresult"></div>
                                                </div>
                                                <div class="row text-center">
                                                    <button type="submit" class="btn btn-success btn-app-sm btn-circle"><i class="fa fa-save"></i></button>                                                    
                                                    <input type="hidden" id="accion" name="accion" value="RegProyeccion" />                    
                                                </div>                                                
                                            </form>     

                                        </div>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                        <!--End Content-->
                    </div>
                </div>
                <!--End Container-->
                <?php include 'script.php';?>
                <script type="text/javascript">

                    var detcodprod = Array();
                    var detnomprod = Array();
                    var detcanprod = Array();
                    var detundprod = Array();
                    var detpreprod = Array();
                    var producto = new Object;
                    var cont = 0;
                    var total = 0;
                    var id_fila_selected;

                    function loadPrecioUnitario() {
                        var codprod = $("#codprod").val();
                        from_2('LoadPrecioA', codprod, 'divpreciou', '_proyeccion_load.php');
                    }


                    //                    function Persona(codprod, nombre) {
                    //                        this.codprod = codprod;
                    //                        this.nombre = nombre;
                    //                    }

                    //var yo = new Persona("MA-001", "Breakout");
                    //document.writeln(yo.nombre);
                    function Select2Test() {
                        $("#proy_mes").select2();
                        $("#codcliente").select2();
                        $("#codasesor").select2();
                        $("#codprod").select2();
                        $("#cultivo").select2();
                    }

                    $(document).ready(function () {

                        $("#btn_add").click(function () {
                            agregar();
                        });

                        $("#btn_del").click(function () {
                            eliminar(id_fila_selected);
                        });

                        $("#btn_num").click(function () {
                            var numero = $("#numero").val();
                            mostrarValorColumna(numero);
                        });

                        $("#form").submit(function (e) {
                            e.preventDefault();

                            var Proyeccion = {
                                ano: $("#proy_ano").val(),
                                mes: $("#proy_mes").val(),
                                cultivo: $("#cultivo").val(),
                                ha: $("#ha").val(),
                                codcliente: $("#codcliente").val(),
                                codasesor: $("#codasesor").val()
                            };

                            var Productos = {
                                codprod: detcodprod,
                                nomprod: detnomprod,
                                cantidad: detcanprod,
                                umedida: detundprod,
                                preciou: detpreprod
                            };

                            $.ajax({
                                url: "../controller/C_Proyecciones.php",
                                type: "post",
                                dataType: "html",
                                //data: formData,                                                                
                                success: function (res) {
                                    $("#divresult").html(res);
                                    //$('#divresult').hide(5000);
                                },
                                error: function (jqXHR, status, error) {
                                    alert('Disculpe, existió un problema');
                                },
                                complete: function (jqXHR, status) {                                                                        
//                                    detcodprod.length = 0;
//                                    detnomprod.length = 0;
//                                    detcanprod.length = 0;
//                                    detundprod.length = 0;
//                                    detpreprod.length = 0;
//                                    $("#tbodyprod").empty();
                                    vaciarProducto();

                                    //alert('Petición realizada');
                                    //$("#getresult").load('_viatico_lista.php');
                                },
                                data: {accion: 'RegProyeccion', proyeccion: Proyeccion, detproducto: Productos}
                            });
                        });

                        LoadSelect2Script(Select2Test);
                        WinMove();
                    });

                    function agregar() {
                        var codprod = $("#codprod").val();
                        var nomprod = $("#codprod option:selected").html();
                        var cantidad = $("#cantidad").val();
                        var umedida = $("#umedida").val();
                        var preciou = $("#preciou").val();
                        var rpta = validarProducto();
                        if (rpta === true) {

                            detcodprod.push(codprod);
                            detnomprod.push(nomprod);
                            detcanprod.push(cantidad);
                            detundprod.push(umedida);
                            detpreprod.push(preciou);
                            mostrarTabla();
                        }
                    }

                    function mostrarTabla() {
                        var cantidad = detcodprod.length;
                        $("#tbodyprod").empty();
                        var c = 0;
                        var subtotal = 0;
                        for (var i = 0; i < cantidad; i++)
                        {
                            c++;
                            subtotal = parseFloat(detcanprod[i]) * parseFloat(detpreprod[i]);
                            var fila = '<tr class="selected" id="' + i + '" onclick="seleccionar(this.id);"><td>' + c + '</td><td id="nomcol' + c + '">' + detnomprod[i] + '</td><td>' + detcanprod[i] + '</td><td>' + detundprod[i] + '</td><td>' + detpreprod[i] + '</td><td>' + subtotal.toFixed(2) + '</td></tr>';
                            $("#tbldetprod").append(fila);
                        }
                    }

                    function mostrarValorColumna(id) {
                        var nombre = $("#nomcol" + id).html();
                        alert("Nombre de columna es" + nombre);
                    }

                    function seleccionar(id_fila) {
                        if ($("#" + id_fila).hasClass('seleccionada')) {
                            $("#" + id_fila).removeClass('seleccionada');
                        } else {
                            $("#" + id_fila).addClass('seleccionada');
                        }
                        id_fila_selected = id_fila;
                    }

                    function eliminar(pos) {
                        //alert(pos);
                        detcodprod.splice(pos, 1);
                        detnomprod.splice(pos, 1);
                        detcanprod.splice(pos, 1);
                        detundprod.splice(pos, 1);
                        detpreprod.splice(pos, 1);
                        $("#" + pos).remove();
                        mostrarTabla();

                    }

                    function vaciarProducto() {
                        detcodprod.length = 0;
                        detnomprod.length = 0;
                        detcanprod.length = 0;
                        detundprod.length = 0;
                        detpreprod.length = 0;
                        $("#tbodyprod").empty();
                    }


                    function validarProducto() {
                        var codprod = $("#codprod").val();
                        var canprod = $("#cantidad").val();
                        if (codprod === "0") {
                            alert('Seleccione un Producto');
                            $("#codprod").focus();
                            return false;
                        } else if (codprod !== '0') {
                            var result = $.inArray(codprod, detcodprod);
                            if (result >= 0) {
                                alert("Este producto ya existe");
                                return false;
                            }
                        } else if (canprod === '0') {
                            alert('Ingrese Cantidad');
                            $("#cantidad").focus();
                            return false;
                        }
                        return true;
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