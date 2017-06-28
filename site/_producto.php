<?php
header("Cache-Control: no-cache, must-revalidate");
$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["conectado"])) {
    if ($_SESSION["conectado"] == 'SI') {
        include_once '../controller/C_Producto.php';
        $obj = new C_Producto();
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
                                        <li><a href="_producto.php">Lista de Productos</a></li>
                                    </ol>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                    <div class="box">
                                        <div class="box-header">
                                            <div class="box-name">
                                                <i class="fa fa-table"></i>
                                                <span>Tabla de Productos Huma Gro</span>
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
                                            <div class="row" style="font-size: x-small;" >
                                                <div class="col-md-12">
                                                    <a  href="#" class="btn btn-default btn-sm" onclick="javascript:cargar('#bodytable', '_producto_reg.php')">
                                                        <img src="img/iconos/Add.png" height="20px" title="Crear nuevo registro"  ><br/>
                                                        <span>Crear Producto</span>
                                                    </a>
                                                    <a class="btn btn-default btn-sm" href="#" onclick="cargar('#principal', '_producto.php')">
                                                        <img src="img/iconos/box.png" height="20px" title="Listar Productos"  ><br/>
                                                        <span>Lista de Productos</span>
                                                    </a>                
                                                    <?php if ($_SESSION['usuario'] == 'JLP' || $_SESSION['usuario'] == 'ADM') { ?>
                                                        <a class="btn btn-default btn-sm" href="#" onclick="cargar('#bodytable', '_producto_listaprecio.php')">
                                                            <img src="img/iconos/dollar.png" height="20px" title="Ver Lista de Precios"  ><br/>
                                                            <span>Lista de Precios</span>
                                                        </a>
                                                    <?php } ?>
                                                    <a class="btn btn-default btn-sm" href="#" onclick="cargar('#bodytable', '_producto_listapredscto.php')">
                                                        <img src="img/iconos/cost.png" height="20px" title="Ver Lista de Precios Descuento"  ><br/>
                                                        <span>Precios 60 Dias</span>
                                                    </a>
                                                    <?php if ($_SESSION['usuario'] == 'JLP' || $_SESSION['usuario'] == 'ADM' || $_SESSION['usuario'] == 'JRI' || $_SESSION['usuario'] == 'DDI' || $_SESSION['usuario'] == 'ISA') { ?>
                                                        <a class="btn btn-default btn-sm" href="#" onclick="cargar('#bodytable', '_producto_stock.php')">
                                                            <img src="img/iconos/stock.ico" height="20px" title="Ver Stock de Productos"  ><br/>
                                                            <span>Stock Producto</span>
                                                        </a>
                                                    <?php } ?>
                                                    <?php if ($_SESSION['usuario'] == 'JLP' || $_SESSION['usuario'] == 'ADM' || $_SESSION['usuario'] == 'JRI' || $_SESSION['usuario'] == 'DDI' || $_SESSION['usuario'] == 'ISA') { ?>
                                                        <a class="btn btn-default btn-sm" href="_producto_preciocom.php">
                                                            <img src="img/iconos/cost.png" height="20px" title="Precios para Comisiones"  ><br/>
                                                            <span>Precio Comisiones</span>
                                                        </a>
                                                    <?php } ?>
                                                    <a class="" href="#" onclick="cargar('#principal', '_producto_llenartabla.php')">Llenar Tabla</a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12" id='bodytable' style="height: 500px; overflow: scroll; ">
                                                    <h3>Lista de Productos <a href="_producto_reg.php" class="btn btn-primary"><span class="fa fa-plus-circle"></span> Registrar Producto</a></h3>
                                                    <table class="table table-striped" style="font-size: 11px;">
                                                        <thead>
                                                            <tr style="color: white; background-color: #1da8f4;">
                                                                <th>Categoria</th>
                                                                <th>Codigo</th>
                                                                <th>Descripcion</th>
                                                                <th>Abreviatura</th>
                                                                <th>U. Medida</th>
                                                                <th>P. Venta</th>
                                                                <th>Activo</th>
                                                                <th></th>                                                
                                                            </tr>                    
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $listaprod = $obj->getProductosAll();
                                                            foreach ($listaprod as $valor) {
                                                                ?>                        
                                                                <tr>
                                                                    <td><?php echo $valor['codcate'] ?></td>
                                                                    <td><?php echo $valor['codigo'] ?></td>
                                                                    <td><?php echo $valor['nombre'] ?></td>
                                                                    <td><?php echo $valor['descorto'] ?></td>
                                                                    <td><?php echo $valor['umedida'] ?></td>
                                                                    <td><?php echo $valor['pventa'] ?></td>
                                                                    <td><?php echo $valor['activo'] ?></td>
                                                                    <td>
                                                                        <a href="#" onclick="cargar('#bodytable', '_producto_edit.php?cod=<?php echo trim($valor['codigo']); ?>')" title="Modificar"><img src="img/iconos/editar.jpg" height="20" /> </a>
                                                                        <a onClick="return confirmSubmit()" href="javascript:cargar('#principal', '_producto_elim.php?cod=<?php echo trim($valor['codigo']); ?>')" title="Eliminar"><img src="img/iconos/trash.png" height="20" /></a>
                                                                    </td>
                                                                    <?php
                                                                }
                                                                ?>
                                                        </tbody>
                                                    </table>
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
            </body>
        </html>

        <?php
    }
} else {
    header("Location:recursos/logout.php");
}
?>