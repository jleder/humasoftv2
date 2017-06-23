<?php
@session_start();
include_once '../controller/C_Producto.php';
$obj = new C_Producto();
?>
<html>
    <head>
        <script>
            $(document).ready(function () {
                $("#form").submit(function (e) {
                    e.preventDefault();

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
                });
            });
        </script> 
    </head>
    <body>


        <form id="form" name="form" action="#" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-12">
                    <h3>Lista de Precios 60 Dias - Precios con Descuentos</h3>
                </div>            
            </div>
            <div class="row">
                <div class="col-lg-9">
                    <table class="table table-striped" style="font-size: 9px;">
                        <thead>
                            <tr style="color: white; background-color: #1da8f4;">
                                <th>Categoria</th>
                                <th widht='100%' >Producto Huma Gro</th>
                                <th>Precio 60</th>
                                <th>Precio Dscto 1</th>
                                <th>Precio Dscto 2</th>                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $listaprod = $obj->getListaPrecioProductosAll2();

//                            echo '<pre>';
//                            print_r($listaprod);
//                            echo '</pre>';


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


//                            echo '<pre>';
//                            print_r($categorias);
//                            echo '</pre>';
//                            
//                            echo '<pre>';
//                            print_r($codprod);
//                            echo '</pre>';


                            $arrayficho = array();

                            $cant = count($nomprod);
                            for ($i = 0; $i < $cant; $i++) {
                                array_push($arrayficho, array('codprod' => $codprod[$i], 'nomprod' => $nomprod[$i], '60' => 0.00, '61' => 0.00, '62' => 0.00));
                            }

                            foreach ($listaprod as $value) {
                                $indice = array_search($value['codigoprod'], array_column($arrayficho, 'codprod'));
                                if ($value['codlis'] == '60') {
                                    $arrayficho[$indice]['60'] = $value['precio'];
                                } elseif ($value['codlis'] == '61') {
                                    $arrayficho[$indice]['61'] = $value['precio'];
                                } elseif ($value['codlis'] == '62') {
                                    $arrayficho[$indice]['62'] = $value['precio'];
                                }
                            }

                            $numfila = count($arrayficho);
                            if ($numfila > 0) {
                                foreach ($arrayficho as $valor) {

                                    echo '<tr>';
                                    echo '<td width="">' . $valor['codprod'] . ' <input type="hidden" id="" name="codprod[]" value="' . $valor['codprod'] . '" /> </td>';
                                    echo '<td width="50%">' . $valor['nomprod'] . '</td>';
                                    echo '<td width=""><input type="number" class="form-control input-sm" name="lista60[]" value="' . $valor['60'] . '" min="0" step="any" /></td>';
                                    echo '<td width=""><input type="number" class="form-control input-sm" name="lista61[]" value="' . $valor['61'] . '" min="0" step="any" /></td>';
                                    echo '<td width=""><input type="number" class="form-control input-sm" name="lista62[]" value="' . $valor['62'] . '" min="0" step="any" /></td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="5">No hay productos.</td></tr>';
                            }
                            ?>

                        </tbody>
                    </table>
                    <p style="text-align: right;">                        
                        <input type="submit" value="Actualizar Precios 60" class="btn btn-success" />                        
                        <input type="hidden" id="accion" name="accion" value="ActListaPrecio60" />                        
                    </p>
                </div>
            </div>
        </form>
        <br/>
        <div id="result"></div>
    </body>
</html>

