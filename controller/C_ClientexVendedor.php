<?php
$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}
include '../database/Conexion.php';
include '../model/ClientexVendedor.php';
include '../model/ClientexVendedorCompartido.php';

$obj = new ClientexVendedor();
$clvdb02 = new ClientexVendedorCompartido();

if (isset($_POST['accion'])) {

    switch ($_POST['accion']) {
        case 'RegClientexVendedor':

            $obj->__set('codcli', trim($_POST['codcli']));
            $obj->__set('codven', trim($_POST['codven']));
            $obj->__set('nomven', trim(strtoupper($_POST['nomven'])));
            $obj->__set('nomcli', trim(strtoupper($_POST['nomcli'])));
            $obj->__set('fecapertura', trim($_POST['fecapertura']));
            $obj->__set('compartido', trim($_POST['compartido']));
            $obj->__set('comisionpaq', $_POST['comisionpaq']);
            $obj->__set('dom_user', $_SESSION['usuario']);

            $result = $obj->insert_clvdb01();

            if ($result) {
                ?>                
                <div class="alert alert-success" style="vertical-align: middle;" id="mensaje">OK. Se registro con suceso :) </div>
                <script>
                    alert('EN HORA BUENA :)!! Sus datos se han registrado correctamente.');
                    from_unico('', 'divclixempleado', '_cliente_emp.php');
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

        case 'ModClientexVendedor':

            $obj->__set('codclv', trim($_POST['codclv']));
            $obj->__set('codcli', trim($_POST['codcli']));
            $obj->__set('codven', trim($_POST['codven']));
            $obj->__set('nomven', trim(strtoupper($_POST['nomven'])));
            $obj->__set('nomcli', trim(strtoupper($_POST['nomcli'])));
            $obj->__set('fecapertura', trim($_POST['fecapertura']));
            $obj->__set('compartido', trim($_POST['compartido']));
            $obj->__set('comisionpaq', $_POST['comisionpaq']);
            $obj->__set('dom_user', $_SESSION['usuario']);

            $result = $obj->update_clvdb01();

            if ($result) {
                ?>                
                <div class="alert alert-success" style="vertical-align: middle;" id="mensaje">OK. Se modifico con suceso :) </div>
                <script>
                    alert('EN HORA BUENA :)!! Sus datos se han modificado correctamente.');
                    from_unico('', 'divclixempleado', '_cliente_emp.php');
                </script>
                <?php
            } else {
                ?>
                <div class="alert alert-danger" style="vertical-align: middle;" id="mensaje">Falla. No se pudo registrar. :(</div>
                <script>
                    alert('ERROR :(!! No se pudo modificar. Por favor verifique sus datos.');
                </script>
                <?php
            }
            break;

        case 'RegClientexVendedorCompartido':

            $clvdb02->__set('codclv', trim($_POST['codclv']));
            $clvdb02->__set('codven', trim($_POST['codven']));
            $clvdb02->__set('nomven', trim(strtoupper($_POST['nomven'])));
            $clvdb02->__set('comisionpaq', trim($_POST['comisionpaq']));
            $clvdb02->__set('obs', trim(strtoupper($_POST['obs'])));
            $clvdb02->__set('dom_user', trim($_SESSION['usuario']));

            $result = $clvdb02->insert_clvdb02();

            if ($result) {
                ?>                                
                <script>
                    alert('EN HORA BUENA :)!! Sus datos se han registrado correctamente.');
                </script>
                <?php
            } else {
                ?>                
                <script>
                    alert('ERROR :(!! No se pudo registrar. Por favor verifique sus datos.');
                </script>
                <?php
            }
            break;

        case 'ModClientexVendedorCompartido':

            $clvdb02->__set('codigo', trim($_POST['codigo']));
            $clvdb02->__set('codclv', trim($_POST['codclv']));
            $clvdb02->__set('codven', trim($_POST['codven']));
            $clvdb02->__set('nomven', trim(strtoupper($_POST['nomven'])));
            $clvdb02->__set('comisionpaq', trim($_POST['comisionpaq']));
            $clvdb02->__set('obs', trim(strtoupper($_POST['obs'])));
            $clvdb02->__set('dom_user', trim($_SESSION['usuario']));

            $result = $clvdb02->update_clvdb02();

            if ($result) {
                ?>                                
                <script>
                    alert('EN HORA BUENA :)!! Sus datos se han modificado correctamente.');                    
                </script>
                <?php
            } else {
                ?>                
                <script>
                    alert('ERROR :(!! No se pudo modificar. Por favor verifique sus datos.');
                </script>
                <?php
            }
            break;
        default:
            break;
    }
}