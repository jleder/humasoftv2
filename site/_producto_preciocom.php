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
                                        <li><a href="_producto_preciocom.php">Precio para Comisiones</a></li>
                                    </ol>
                                </div>
                            </div>
                            <div class="row">                        
                                <div class="col-xs-12 col-sm-12">
                                    <div class="box">
                                        <div class="box-header">
                                            <div class="box-name">
                                                <i class="fa fa-table"></i>
                                                <span>Tabla de Precios para Comisiones</span>
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

                                            <form id="form_comision" name="form_comision" action="#" method="post" enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <table class="table table-striped" style="font-size: 10px;">
                                                            <thead>
                                                                <tr style="color: white; background-color:  #1da8f4;">
                                                                    <th rowspan="2">Nro</th>
                                                                    <th rowspan="2">Categoria</th>
                                                                    <th rowspan="2" widht='100%' >Producto Huma Gro</th>                                    
                                                                    <th colspan="3" style="text-align: center;">A Credito</th>
                                                                    <th colspan="3" style="text-align: center;">Al Contado</th>                                    
                                                                </tr>
                                                                <tr style="color: white; background-color: #1da8f4;">                                    
                                                                    <th>Basico</th>
                                                                    <th>Normal</th>
                                                                    <th>Superior</th>
                                                                    <th style="background-color: #2167d5;">Basico</th>
                                                                    <th style="background-color: #2167d5;">Normal</th>
                                                                    <th style="background-color: #2167d5;">Superior</th>
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
                                                                    array_push($arrayficho, array('codprod' => $codprod[$i], 'nomprod' => $nomprod[$i], 'LB' => 0.00, 'LN' => 0.00, 'LS' => 0.00, 'CB' => 0.00, 'CN' => 0.00, 'CS' => 0.00));
                                                                }

                                                                foreach ($listaprod as $value) {
                                                                    $indice = array_search($value['codigoprod'], array_column($arrayficho, 'codprod'));
                                                                    if ($value['codlis'] == 'LB') {
                                                                        $arrayficho[$indice]['LB'] = $value['precio'];
                                                                    } elseif ($value['codlis'] == 'LN') {
                                                                        $arrayficho[$indice]['LN'] = $value['precio'];
                                                                    } elseif ($value['codlis'] == 'LS') {
                                                                        $arrayficho[$indice]['LS'] = $value['precio'];
                                                                    } elseif ($value['codlis'] == 'CB') {
                                                                        $arrayficho[$indice]['CB'] = $value['precio'];
                                                                    } elseif ($value['codlis'] == 'CN') {
                                                                        $arrayficho[$indice]['CN'] = $value['precio'];
                                                                    } elseif ($value['codlis'] == 'CS') {
                                                                        $arrayficho[$indice]['CS'] = $value['precio'];
                                                                    }
                                                                }

                                                                $numfila = count($arrayficho);
                                                                if ($numfila > 0) {
                                                                    $c = 0;
                                                                    foreach ($arrayficho as $valor) {
                                                                        $c++;
                                                                        echo '<tr>';
                                                                        echo '<td>' . $c . '</td>';
                                                                        echo '<td width="">' . $valor['codprod'] . ' <input type="hidden" id="" name="codprod[]" value="' . $valor['codprod'] . '" /> </td>';
                                                                        echo '<td width="50%">' . $valor['nomprod'] . '</td>';
                                                                        echo '<td width=""><input type="number" class="form-control input-sm" name="listaLB[]" value="' . $valor['LB'] . '" min="0" step="any" /></td>';
                                                                        echo '<td width=""><input type="number" class="form-control input-sm" name="listaLN[]" value="' . $valor['LN'] . '" min="0" step="any" /></td>';
                                                                        echo '<td width=""><input type="number" class="form-control input-sm" name="listaLS[]" value="' . $valor['LS'] . '" min="0" step="any" /></td>';
                                                                        echo '<td width=""><input type="number" class="form-control input-sm" name="listaCB[]" value="' . $valor['CB'] . '" min="0" step="any" /></td>';
                                                                        echo '<td width=""><input type="number" class="form-control input-sm" name="listaCN[]" value="' . $valor['CN'] . '" min="0" step="any" /></td>';
                                                                        echo '<td width=""><input type="number" class="form-control input-sm" name="listaCS[]" value="' . $valor['CS'] . '" min="0" step="any" /></td>';
                                                                        echo '</tr>';
                                                                    }
                                                                } else {
                                                                    echo '<tr><td colspan="9">No hay productos.</td></tr>';
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>                                                                                                                                                                        
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 text-center">
                                                        <input type="submit" value="Actualizar Precios" class="btn btn-success" />
                                                        <input type="hidden" id="accion" name="accion" value="ActListaComisiones" />
                                                    </div>
                                                </div>
                                            </form>                         
                                            <div class="row">
                                                <div class="col-md-12" id="result">

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
                <script>
                    $(document).ready(function () {
                        $("#form_comision").submit(function (e) {
                            e.preventDefault();
                            var f = $(this);
                            var formData = new FormData(document.getElementById("form_comision"));

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
    }
} else {
    header("Location:recursos/logout.php");
}
?>