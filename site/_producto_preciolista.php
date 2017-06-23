<?php
header("Cache-Control: no-cache, must-revalidate");
$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["conectado"])) {
    if ($_SESSION["conectado"] == 'SI') {
        if ($_SESSION['usuario'] == 'ADM' || $_SESSION['usuario'] == 'JLP') {
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
                                            <li><a href="_producto_preciolista.php">Tabla Lista de Precios</a></li>
                                        </ol>
                                    </div>
                                </div>
                                <div class="row">                        
                                    <div class="col-xs-12 col-sm-12">
                                        <div class="box">
                                            <div class="box-header">
                                                <div class="box-name">
                                                    <i class="fa fa-table"></i>
                                                    <span>Tabla Lista de Precios</span>
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

                                                <form id="form_preciolista" name="form" action="#" method="post" enctype="multipart/form-data">                                                    
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <table class="table table-striped" style="font-size: 11px;">
                                                                <thead>
                                                                    <tr style="color: white; background-color: #1da8f4;">
                                                                        <th></th>
                                                                        <th>Categoria</th>
                                                                        <th widht='100%' >Producto Huma Gro</th>                                    
                                                                        <th>Lista A</th>
                                                                        <th>Lista B</th>
                                                                        <th>Lista C</th>
                                                                        <th>Lista D</th>
                                                                        <th>Lista E</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $listaprod = $obj->getListaPrecioProductosAll();


                                                                    //obteniendo categorias
                                                                    $colcateg = array_column($listaprod, 'desele');
                                                                    $arraycat = array_unique($colcateg);
                                                                    $categorias = array_values($arraycat);

                                                                    //obteniendo codproducto y nomproducto
                                                                    $colcodprod = array_column($listaprod, 'codigoprod');
                                                                    $colnomprod = array_column($listaprod, 'nombre');
                                                                    $arraycodprod = array_unique($colcodprod);
                                                                    $arraynomprod = array_unique($colnomprod);

                                                                    $codprod = array_values($arraycodprod);
                                                                    $nomprod = array_values($arraynomprod);

                                                                    $arrayficho = array();

                                                                    $cant = count($nomprod);
                                                                    for ($i = 0; $i < $cant; $i++) {
                                                                        array_push($arrayficho, array('codprod' => $codprod[$i], 'nomprod' => $nomprod[$i], '01' => 0.00, '02' => 0.00, '03' => 0.00, '04' => 0.00, '05' => 0.00));
                                                                    }

                                                                    foreach ($listaprod as $value) {
                                                                        $indice = array_search($value['codigoprod'], array_column($arrayficho, 'codprod'));
                                                                        if ($value['codlis'] == '01') {
                                                                            $arrayficho[$indice]['01'] = $value['precio'];
                                                                        } elseif ($value['codlis'] == '02') {
                                                                            $arrayficho[$indice]['02'] = $value['precio'];
                                                                        } elseif ($value['codlis'] == '03') {
                                                                            $arrayficho[$indice]['03'] = $value['precio'];
                                                                        } elseif ($value['codlis'] == '04') {
                                                                            $arrayficho[$indice]['04'] = $value['precio'];
                                                                        } elseif ($value['codlis'] == '05') {
                                                                            $arrayficho[$indice]['05'] = $value['precio'];
                                                                        }
                                                                    }

                                                                    $numfila = count($arrayficho);
                                                                    if ($numfila > 0) {
                                                                        $i = 0;
                                                                        foreach ($arrayficho as $valor) {
                                                                            $i++;
                                                                            echo '<tr>';
                                                                            echo '<td>' . $i . '</td>';
                                                                            echo '<td width="">' . $valor['codprod'] . ' <input type="hidden" id="" name="codprod[]" value="' . $valor['codprod'] . '" /> </td>';
                                                                            echo '<td width="50%">' . $valor['nomprod'] . '</td>';
                                                                            echo '<td width=""><input type="number" class="form-control input-sm" name="listaA[]" value="' . $valor['01'] . '" min="0" step="any" /></td>';
                                                                            echo '<td width=""><input type="number" class="form-control input-sm" name="listaB[]" value="' . $valor['02'] . '" min="0" step="any" /></td>';
                                                                            echo '<td width=""><input type="number" class="form-control input-sm" name="listaC[]" value="' . $valor['03'] . '" min="0" step="any" /></td>';
                                                                            echo '<td width=""><input type="number" class="form-control input-sm" name="listaD[]" value="' . $valor['04'] . '" min="0" step="any" /></td>';
                                                                            echo '<td width=""><input type="number" class="form-control input-sm" name="listaE[]" value="' . $valor['05'] . '" min="0" step="any" /></td>';
                                                                            echo '</tr>';
                                                                        }
                                                                    } else {
                                                                        echo '<tr><td colspan="7">No hay productos.</td></tr>';
                                                                    }
                                                                    ?>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 text-center">
                                                            <input type="submit" value="Actualizar Precios" class="btn btn-success" />
                                                            <input type="hidden" id="accion" name="accion" value="ActListaPrecio" />
                                                        </div>
                                                    </div>                                                    
                                                </form>                        
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12" id="result">

                                            </div>
                                        </div>                                            
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!--End Container-->
                    <?php include 'script.php'; ?>
                    <script>
                        $(document).ready(function () {
                            $("#form_preciolista").submit(function (e) {
                                e.preventDefault();

                                var f = $(this);
                                var formData = new FormData(document.getElementById("form_preciolista"));

                                $.ajax({
                                    url: "../controller/C_Producto.php",
                                    type: "post",
                                    dataType: "html",
                                    data: formData,
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    success: function (res) {
                                        //                                    $("#divingreso").css("display", "none");
                                        $("#result").html(res);
                                    },
                                    error: function (jqXHR, status, error) {
                                        alert('Disculpe, existió un problema');
                                    },
                                    complete: function (jqXHR, status) {
                                        alert('Petición realizada');
                                        //$("#getresult").load('_viatico_lista.php');
                                    }
                                });

                            });
                        });
                    </script> 
                </body>
            </html>

            <?php
        } else {
            ?>
            <div class="row">
                <div class="col-md-12">
                    <p style="color: red;">Lo sentimos. Este usuario no tiene permisos para acceder a esta información.</p>
                </div>            
            </div>
            <?php
        }
    }
} else {
    header("Location:recursos/logout.php");
}
?>
