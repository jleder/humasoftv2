<?php
header("Cache-Control: no-cache, must-revalidate");
$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["conectado"])) {
    if ($_SESSION["conectado"] == 'SI') {
        include '../controller/C_Producto.php';
        $obj = new C_Producto();

        $catproducto = $obj->getcategoria('CF');
        $umprincipal = $obj->getcategoria('UM');
        $umcompra = $obj->getcategoria('UM');
        ?>
        <!DOCTYPE html>
        <html>
            <head>                
                <?php include 'head.php'; ?>
            </head>
            <body>                        
                <?php include 'header.php'; ?>
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
                                        <li><a href="dashboard.php">Dashboard</a></li>
                                        <li><a href="#">Inventario</a></li>
                                        <li><a href="_producto.php">Productos</a></li>
                                        <li><a href="#">Lista de Productos</a></li>
                                    </ol>
                                </div>
                            </div>
                            <div class="row">                        
                                <div class="col-xs-12 col-sm-12">  

                                    <div class="box">
                                        <div class="box-header">
                                            <div class="box-name">
                                                <i class="fa fa-search"></i>
                                                <span>Formulario Registrar Producto</span>
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
                                        <div class="box-content">                                            
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <form id="form" name="form" action="#" method="post" enctype="multipart/form-data">           
                                                        <div id="form_reg">
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">Registrar Producto</div>
                                                                <div class="panel-body">
                                                                    <div class="row">
                                                                        <div class="col-lg-4">
                                                                            Categoria
                                                                            <select name="codcate" id="codcate" class="form-control">                                    
                                                                                <?php foreach ($catproducto as $value) { ?>
                                                                                    <option value="<?php echo $value['codele']; ?>"><?php echo $value['codele'] . ' ' . $value['desele']; ?></option>                                    
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-lg-5"></div>
                                                                        <div class="col-lg-3">
                                                                            Codigo Producto<input maxlength="8" type = "text" name = "codigo" placeholder="OVA-0001" value = "" class="form-control" id="codigo" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-9">
                                                                            Descripción<input maxlength="80" type = "text" name = "nombre" placeholder="nombre" value = "" class="form-control" id="nombre" />
                                                                        </div>
                                                                        <div class="col-lg-3">
                                                                            Abreviatura<input maxlength="15" type = "text" name = "descorto" placeholder="MEM" value = "" class="form-control" id="descorto" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-3">
                                                                            U.M. Principal
                                                                            <select name="umedida" id="umedida" class="form-control">                                    
                                                                                <?php foreach ($umprincipal as $value) { ?>
                                                                                    <option value="<?php echo $value['codele']; ?>"><?php echo $value['codele'] . ' ' . $value['desele']; ?></option>                                    
                                                                                <?php } ?>
                                                                            </select>                                                                
                                                                        </div>
                                                                        <div class="col-lg-3">
                                                                            U.M. Compra
                                                                            <select name="umed_com" id="umed_com" class="form-control">                                    
                                                                                <?php foreach ($umcompra as $value) { ?>
                                                                                    <option value="<?php echo $value['codele']; ?>"><?php echo $value['codele'] . ' ' . $value['desele']; ?></option>                                    
                                                                                <?php } ?>
                                                                            </select>                                
                                                                        </div>

                                                                        <div class="col-lg-6">
                                                                            Proveedor<input maxlength="20" type = "text" name = "codigoprov" placeholder="" value = "" class="form-control" id="codigoprov" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-3">
                                                                            Stock Minimo<input type = "number" step="any" name = "stkmin" placeholder="stkmin" value = "0.00" min="0" class="form-control" id="stkmin" />
                                                                        </div>
                                                                        <div class="col-lg-3">
                                                                            Stock Máximo<input type = "number" step="any" name = "stkmax" placeholder="stkmax" value = "0.00" min="0" class="form-control" id="stkmax" />
                                                                        </div>
                                                                        <div class="col-lg-3">
                                                                            Precio Venta<input type = "number" step="any" name = "pventa" placeholder="pventa" value = "0.00" min="0" class="form-control" id="pventa" />
                                                                        </div>
                                                                        <div class="col-lg-3">
                                                                            Precio Almacen<input type = "number" step="any"name = "palmacen" placeholder="palmacen" value = "0.00" min="0" class="form-control" id="palmacen" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">

                                                                        <div class="col-lg-6">
                                                                            Observaciones
                                                                            <textarea class="form-control" name="observa" id="observa" rows="4" cols="20"></textarea>                                    
                                                                        </div>                                


                                                                        <div class="col-lg-3">
                                                                            Peso x Litro<input type = "number" step="any" name = "peso" placeholder="peso" value = "0.00" min="0" class="form-control" id="peso" />
                                                                        </div>

                                                                        <div class="col-lg-3">
                                                                            Litro/Ha<input type = "number" step="any" name = "lithec" placeholder="lithec" value = "0.00" min="0" class="form-control" id="lithec" />
                                                                        </div>                            
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div id="cargando"></div>
                                                                        </div>
                                                                    </div>                            
                                                                </div>
                                                            </div>
                                                            <br/>
                                                            <div class="row" style="text-align: center;">
                                                                <input type="submit" value="Guardar" class="btn btn-success" />
                                                                <a href="#" onclick="cargar('#principal', '_producto.php')" class="btn btn-danger"> Regresar</a>
                                                                <input type="hidden" id="accion" name="accion" value="RegProducto" />                           
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <br/>
                                                    <button id="loading-example-btn" type="button" class="btn btn-primary" data-loading-text="loading stuff...">...</button>
                                                    <div id="result"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                
                <!--End Container-->
                <?php include 'script.php'; ?>
                <script type="text/javascript">

                    function validar() {
                        var codcate = $("#codcate").val();
                        var umprincipal = $("#umedida").val();
                        var umcompra = $("#umed_com").val();
                        var nombre = $("#nombre").val();
                        var codigo = $("#codigo").val();

                        if (codcate === "") {
                            alert('Debe seleccionar una categoria');
                            $("#codcate").focus();
                            return false;
                        } else if (umprincipal === "") {
                            alert('Debe seleccionar una medida');
                            $("#umedida").focus();
                            return false;
                        } else if (umcompra === "") {
                            alert('Debe seleccionar una medida');
                            $("#umed_com").focus();
                            return false;
                        } else if (nombre === "") {
                            alert('Debe escribir descripcion de producto');
                            $("#nombre").focus();
                            return false;
                        } else if (codigo === "") {
                            alert('Debe escribir un codigo');
                            $("#codigo").focus();
                            return false;
                        }
                        return true;
                    }

                    $(document).ready(function () {
                        
                    });

                    $("#form").submit(function (e) {
                        e.preventDefault();
                        var rpta = validar();
                        if (rpta === true) {
                            $("#result").html('<h2> <img src="img/iconos/loading.gif" width="25" height="25" alt="loading"/> Enviando datos...</h2>');
                            var f = $(this);
                            var formData = new FormData(document.getElementById("form"));

                            $.ajax({
                                url: "../controller/C_Producto.php",
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
            </body>
        </html>

        <?php
    }
} else {
    header("Location:recursos/logout.php");
}
?>