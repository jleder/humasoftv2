<?php
$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}
include '../database/Conexion.php';
include '../model/Producto.php';
include '../model/Menu.php';

$obj = new C_Producto();
if (isset($_POST['accion'])) {

    $msjError = '<div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>';
    $msjSucess = '<div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>';
    
    //$msjSucess .= '<strong>OK</strong> Se registró con éxito.</div>';
    //$msjError .= '<strong>Error</strong> Hay un error en los datos del formulario Registrar Ingreso. Por favor vuelva a intentarlo.</div>';

    switch ($_POST['accion']) {
        case 'RegProducto':

            $obj->__set('codigo', trim(strtoupper($_POST['codigo'])));
            $obj->__set('codcate', trim(strtoupper($_POST['codcate'])));
            $obj->__set('nombre', trim(strtoupper($_POST['nombre'])));
            $obj->__set('codigoprov', trim(strtoupper($_POST['codigoprov'])));
            $obj->__set('umedida', trim(strtoupper($_POST['umedida'])));
            $obj->__set('stkmin', trim(strtoupper($_POST['stkmin'])));
            $obj->__set('stkmax', trim(strtoupper($_POST['stkmax'])));
            $obj->__set('pventa', trim(strtoupper($_POST['pventa'])));
            $obj->__set('observa', trim(strtoupper($_POST['observa'])));
            $obj->__set('domuser', trim(strtoupper($_SESSION['usuario'])));
            $obj->__set('palmacen', trim(strtoupper($_POST['palmacen'])));
            $obj->__set('peso', trim(strtoupper($_POST['peso'])));
            $obj->__set('umed_com', trim(strtoupper($_POST['umed_com'])));
            $obj->__set('lithec', trim(strtoupper($_POST['lithec'])));
            $obj->__set('descorto', trim(strtoupper($_POST['descorto'])));

            $result = $obj->insertProducto();

            if ($result) {
                $listaprecios = array('01', '02', '03', '04', '05');

                foreach ($listaprecios as $codlis) {
                    if ($codlis <> '01') {
                        $obj->__set('pventa', trim('0.00'));
                    }
                    $obj->insertarListaPrecios($codlis);
                }
                ?>                
                <div class="alert alert-success" style="vertical-align: middle;" id="mensaje">OK. Se registro con suceso :) </div>                
                <script>
                    alert('EN HORA BUENA :)!! Sus datos se han registrado correctamente.');
                    from_unico('', 'principal', '_producto.php');
                </script>
                <?php
            } else {
                ?>
                <div class="alert alert-danger" style="vertical-align: middle;" id="mensaje">Falla. No se pudo registrar. :(</div>
                <script>
                    alert('ERROR :(!! No se pudo registrar. Por favor verifique sus datos.');
                </script>
                <?php
            }
            break;

        case 'ActProducto':

            $obj->__set('codigo', trim(strtoupper($_POST['codigo'])));
            $obj->__set('codcate', trim(strtoupper($_POST['codcate'])));
            $obj->__set('nombre', trim(strtoupper($_POST['nombre'])));
            $obj->__set('codigoprov', trim(strtoupper($_POST['codigoprov'])));
            $obj->__set('umedida', trim(strtoupper($_POST['umedida'])));
            $obj->__set('stkmin', trim(strtoupper($_POST['stkmin'])));
            $obj->__set('stkmax', trim(strtoupper($_POST['stkmax'])));
            $obj->__set('pventa', trim(strtoupper($_POST['pventa'])));
            $obj->__set('observa', trim(strtoupper($_POST['observa'])));
            $obj->__set('domuser', trim(strtoupper($_SESSION['usuario'])));
            $obj->__set('palmacen', trim(strtoupper($_POST['palmacen'])));
            $obj->__set('peso', trim(strtoupper($_POST['peso'])));
            $obj->__set('umed_com', trim(strtoupper($_POST['umed_com'])));
            $obj->__set('lithec', trim(strtoupper($_POST['lithec'])));
            $obj->__set('descorto', trim(strtoupper($_POST['descorto'])));

            $result = $obj->updateProducto();
            if ($result) {
                $obj->__set('codlis', trim('01'));
                $obj->updateListaPrecios();
                ?>                
                <div class="alert alert-success" style="vertical-align: middle;" id="mensaje">OK. Se registro con suceso :) </div>                
                <script>
                    alert('EN HORA BUENA :)!! Sus datos se han registrado correctamente.');
                    from_unico('', 'principal', '_producto.php');
                </script>
                <?php
            } else {
                ?>
                <div class="alert alert-danger" style="vertical-align: middle;" id="mensaje">Falla. No se pudo registrar. :(</div>
                <script>
                    alert('ERROR :(!! No se pudo registrar. Por favor verifique sus datos.');
                </script>
                <?php
            }
            break;

        case 'ActListaPrecio':

            $obj->__set('domuser', trim(strtoupper($_SESSION['usuario'])));

            $codprod = $_POST['codprod'];
            $listaA = $_POST['listaA'];
            $listaB = $_POST['listaB'];
            $listaC = $_POST['listaC'];
            $listaD = $_POST['listaD'];
            $listaE = $_POST['listaE'];

            $nprod = count($codprod);
            //$listaprecios = array('01'=>$listaA, '02'=>$listaB, '03'=>$listaC, '04'=>$listaD, '05'=>$listaE);

            for ($i = 0; $i < $nprod; $i++) {
                $obj->__set('codigo', trim($codprod[$i]));
                $obj->__set('codlis', trim('01'));
                $obj->__set('pventa', trim($listaA[$i]));
                $result = $obj->updateListaPrecios();
            }

            for ($i = 0; $i < $nprod; $i++) {
                $obj->__set('codigo', trim($codprod[$i]));
                $obj->__set('codlis', trim('02'));
                $obj->__set('pventa', trim($listaB[$i]));
                $result = $obj->updateListaPrecios();
            }

            for ($i = 0; $i < $nprod; $i++) {
                $obj->__set('codigo', trim($codprod[$i]));
                $obj->__set('codlis', trim('03'));
                $obj->__set('pventa', trim($listaC[$i]));
                $result = $obj->updateListaPrecios();
            }

            for ($i = 0; $i < $nprod; $i++) {
                $obj->__set('codigo', trim($codprod[$i]));
                $obj->__set('codlis', trim('04'));
                $obj->__set('pventa', trim($listaD[$i]));
                $result = $obj->updateListaPrecios();
            }

            for ($i = 0; $i < $nprod; $i++) {
                $obj->__set('codigo', trim($codprod[$i]));
                $obj->__set('codlis', trim('05'));
                $obj->__set('pventa', trim($listaE[$i]));
                $result = $obj->updateListaPrecios();
            }




            /*
              echo '<pre>';
              print_r($listaprecios);
              echo '</pre>';
              echo $listaprecios[0];
              echo '<br/>';
              echo $listaprecios[1];
             */

            if ($result) {
                ?>                
                <div class="alert alert-success" style="vertical-align: middle;" id="mensaje">OK. Se registro con suceso :) </div>                
                <script>
                    alert('EN HORA BUENA :)!! Sus datos se han registrado correctamente.');
                    from_unico('', 'principal', '_producto.php');
                </script>
                <?php
            } else {
                ?>
                <div class="alert alert-danger" style="vertical-align: middle;" id="mensaje">Falla. No se pudo registrar. :(</div>
                <script>
                    alert('ERROR :(!! No se pudo registrar. Por favor verifique sus datos.');
                </script>
                <?php
            }
            break;

        case 'ActListaPrecio60':

            $obj->__set('domuser', trim(strtoupper($_SESSION['usuario'])));

            $codprod = $_POST['codprod'];
            $lista60 = $_POST['lista60'];
            $lista61 = $_POST['lista61'];
            $lista62 = $_POST['lista62'];

            $nprod = count($codprod);
            //$listaprecios = array('01'=>$listaA, '02'=>$listaB, '03'=>$listaC, '04'=>$listaD, '05'=>$listaE);

            for ($i = 0; $i < $nprod; $i++) {
                $obj->__set('codigo', trim($codprod[$i]));
                $obj->__set('codlis', trim('60'));
                $obj->__set('pventa', trim($lista60[$i]));
                $result = $obj->updateListaPrecios();
            }

            for ($i = 0; $i < $nprod; $i++) {
                $obj->__set('codigo', trim($codprod[$i]));
                $obj->__set('codlis', trim('61'));
                $obj->__set('pventa', trim($lista61[$i]));
                $result = $obj->updateListaPrecios();
            }

            for ($i = 0; $i < $nprod; $i++) {
                $obj->__set('codigo', trim($codprod[$i]));
                $obj->__set('codlis', trim('62'));
                $obj->__set('pventa', trim($lista62[$i]));
                $result = $obj->updateListaPrecios();
            }

            /*
              echo '<pre>';
              print_r($listaprecios);
              echo '</pre>';
              echo $listaprecios[0];
              echo '<br/>';
              echo $listaprecios[1];
             */

            if ($result) {
                ?>                
                <div class="alert alert-success" style="vertical-align: middle;" id="mensaje">OK. Se registro con suceso :) </div>                
                <script>
                    alert('EN HORA BUENA :)!! Sus datos se han registrado correctamente.');
                    from_unico('', 'principal', '_producto.php');
                </script>
                <?php
            } else {
                ?>
                <div class="alert alert-danger" style="vertical-align: middle;" id="mensaje">Falla. No se pudo registrar. :(</div>
                <script>
                    alert('ERROR :(!! No se pudo registrar. Por favor verifique sus datos.');
                </script>
                <?php
            }
            break;

        case 'ActListaComisiones':

            $obj->__set('domuser', trim(strtoupper($_SESSION['usuario'])));

            $codprod = $_POST['codprod'];
            $listaLB = $_POST['listaLB'];
            $listaLN = $_POST['listaLN'];
            $listaLS = $_POST['listaLS'];
            $listaCB = $_POST['listaCB'];
            $listaCN = $_POST['listaCN'];
            $listaCS = $_POST['listaCS'];

            $nprod = count($codprod);
            //$listaprecios = array('01'=>$listaA, '02'=>$listaB, '03'=>$listaC, '04'=>$listaD, '05'=>$listaE);

            for ($i = 0; $i < $nprod; $i++) {
                $obj->__set('codigo', trim($codprod[$i]));
                $obj->__set('codlis', trim('LB'));
                $obj->__set('pventa', trim($listaLB[$i]));
                $result1 = $obj->updateListaPrecios();
            }

            for ($i = 0; $i < $nprod; $i++) {
                $obj->__set('codigo', trim($codprod[$i]));
                $obj->__set('codlis', trim('LN'));
                $obj->__set('pventa', trim($listaLN[$i]));
                $result2 = $obj->updateListaPrecios();
            }

            for ($i = 0; $i < $nprod; $i++) {
                $obj->__set('codigo', trim($codprod[$i]));
                $obj->__set('codlis', trim('LS'));
                $obj->__set('pventa', trim($listaLS[$i]));
                $result3 = $obj->updateListaPrecios();
            }

            for ($i = 0; $i < $nprod; $i++) {
                $obj->__set('codigo', trim($codprod[$i]));
                $obj->__set('codlis', trim('CB'));
                $obj->__set('pventa', trim($listaCB[$i]));
                $result4 = $obj->updateListaPrecios();
            }

            for ($i = 0; $i < $nprod; $i++) {
                $obj->__set('codigo', trim($codprod[$i]));
                $obj->__set('codlis', trim('CN'));
                $obj->__set('pventa', trim($listaCN[$i]));
                $result5 = $obj->updateListaPrecios();
            }

            for ($i = 0; $i < $nprod; $i++) {
                $obj->__set('codigo', trim($codprod[$i]));
                $obj->__set('codlis', trim('CS'));
                $obj->__set('pventa', trim($listaCS[$i]));
                $result6 = $obj->updateListaPrecios();
            }

            if ($result1 && $result2 && $result3 && $result4 && $result5 && $result6) {
                $msjSucess .= '<strong>OK!</strong> Se actualizó con éxito.</div>';    
                echo $msjSucess;
            } else {
                $msjError .= '<strong>Error!</strong> No se pudo actualizar.</div>';
                echo $msjError;
            }
            break;

        case 'LlenarTabla':
            $result = $obj->llenartabla_lista_precio2();
            if ($result) {
                echo 'OK';
            } else {
                echo 'error';
            }
            break;

        case 'LlenarTabla_Precio60':
            $result = $obj->llenartabla_preciocondscto();
            if ($result) {
                echo 'OK';
            } else {
                echo 'error';
            }
            break;

        case 'RegFileStock':

            $fecha = $_POST['fecha'];
            $carpeta = '../site/archivos/filestock/';
            $filename = $_FILES['url']['name']; //nombre de archivo
            $tmpname = $_FILES['url']['tmp_name']; //nombre temporal de la imagen

            $result = $obj->insert_filestock($fecha, $filename);
            if ($result) {
                move_uploaded_file($tmpname, "$carpeta$filename"); //movemos el archivo a la carpeta de destino                
                ?>                                
                <script>
                    alert('SE SUBIO SATISFACTORIAMENTE :)!!');
                    from_unico('', 'bodytable', '_producto_stock.php');
                </script>
                <?php
            } else {
                ?>                                
                <script>
                    alert('NO SE PUDO SUBIR ESTE ARCHIVO :(');
                </script>
                <?php
            }
            break;

        default:
            break;
    }
}