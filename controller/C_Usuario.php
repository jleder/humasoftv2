<?php
$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}
include '../database/Conexion.php';
include '../model/Usuario.php';
include '../model/Perfil.php';
include '../model/Recurso.php';
include '../model/Menu.php';
$obj = new C_Usuario();
$perf = new C_Perfil();
$rec = new C_Recurso();


if (isset($_POST['accion'])) {

    switch ($_POST['accion']) {

        case 'RegUsuario':
            $obj->__set('coduse', trim($_POST['coduse']));
            $obj->__set('desuse', trim($_POST['desuse']));
            $obj->__set('pwduse', trim($_POST['pwduse']));
            $obj->__set('email', trim($_POST['email']));
            $obj->__set('vendedor', trim($_POST['vendedor']));
            $obj->__set('vc', trim($_POST['vc']));
            $obj->__set('vt', trim($_POST['vt']));
            $obj->__set('externo', trim($_POST['externo']));
            $obj->__set('store', trim($_POST['store']));
            $rpta = $obj->insert_aausdb01();
            if ($rpta) {
                ?>
                <script>
                    alert('SE REGISTRO CON EXITO');                    
                </script>                
                <?php
            } else {
                ?>
                <script>
                    alert('NO SE PUDO REGISTRAR');
                </script>
                <div class="alert alert-danger" id="mensaje">No se pudo actualizar.</div>
                <?php
            }
            break;

        case 'RegUsuario2':

            $obj->__set('coduse', trim($_POST['coduse']));
            $obj->__set('desuse', trim($_POST['desuse']));
            $obj->__set('pwduse', trim($_POST['pwduse']));
            $rpta = $obj->insert_aausdb012();            
            if ($rpta) {                
                ?>                
                <script>
                    alert('SE REGISTRO CON EXITO AHORA DEBE CARGAR');                                        
                    from_unico('', 'ajax-content', '_usuario.php');
                </script>                
                <?php
                //header('Location:http://localhost:8080/humasoftv2/site/Dashboard.php#_usuario.php');
            } else {
                ?>
                <script>
                    alert('NO SE PUDO REGISTRAR');
                </script>
                <div class="alert alert-danger" id="mensaje">No se pudo actualizar.</div>
                <?php
            }
            break;

        case 'ModUsuario':
            $obj->__set('coduse', trim(strtoupper($_POST['coduse'])));
            $obj->__set('newcoduse', trim(strtoupper($_POST['newcoduse'])));
            $obj->__set('desuse', trim(($_POST['desuse'])));
            $obj->__set('pwduse', trim(($_POST['pwduse'])));
            $obj->__set('email', trim($_POST['email']));
            $obj->__set('vendedor', trim(($_POST['vendedor'])));
            $obj->__set('vc', trim(($_POST['vc'])));
            $obj->__set('vt', trim(($_POST['vt'])));
            $obj->__set('activo', trim(($_POST['activo'])));
            $obj->__set('externo', trim(($_POST['externo'])));
            $obj->__set('store', trim(($_POST['store'])));
            $rpta = $obj->update_aausdb01();
            if ($rpta) {
                ?>
                <script>
                    alert('SE ACTUALIZÓ CON EXITO');
                </script>
                <div class="alert alert-success" id="mensaje">Se actualizo corretamente.</div>
                <?php
            } else {
                ?>
                <script>
                    alert('NO SE PUDO ACTUALIZAR');
                </script>
                <div class="alert alert-danger" id="mensaje">No se pudo actualizar.</div>
                <?php
            }
            break;

        case 'Actualizar':

            $obj->__set('usuario', $_POST['usuario']);
            $obj->__set('correo', $_POST['correo']);

            if (!empty($_POST['clave_new'])) {
                $obj->__set('clave', $_POST['clave_new']);
            } else {
                $obj->__set('clave', $_POST['clave_actual']);
            }

            $imgActual = $_POST['fotoActual'];
            $imgNueva = $_FILES['fotoNueva']['name'];
            if (!empty($_FILES['fotoNueva']['name'])) {
                $obj->__set('foto', $imgNueva);
            } else {
                $obj->__set('foto', $imgActual);
            }
            ?>
            <div class="alert alert-warning" id="mensaje">Se modifico corretamente.</div>

            <?php
            $rpta = $obj->actualizarUsuario();
            if ($rpta) {

                if (!empty($_FILES['fotoNueva']['name'])) {
                    $ruta = "../site/img/usuarios/";
                    copy($_FILES['fotoNueva']['tmp_name'], $ruta . $_FILES['fotoNueva']['name']);
                }
                ?>
                <div class="alert alert-warning" id="mensaje">Se modifico corretamente.</div>

                <?php
            } else {
                ?>
                <div class="alert alert-danger" id="mensaje">No se pudo actualizar.</div>                
                <?php
            }
            break;
        /*
          case 'CambiarSenha':

          $obj->__set('usuario', $_POST['id']);
          $obj->__set('clave', $_POST['clave']);

          $rpta = $obj->actualizarClave();
          if ($rpta) {
          ?>
          <div class="alert alert-success" id="mensaje">Se modifico corretamente.</div>
          <?php
          } else {
          ?>
          <div class="alert alert-danger" id="mensaje">No se pudo actualizar.</div>
          <?php
          }
          break;
         */

        case 'RegPerfil':

            $perf->__set('nombre', trim($_POST['nombre']));
            $perf->__set('obs', trim($_POST['obs']));
            $perf->__set('dom_user', $_SESSION['usuario']);

            $rpta = $perf->insert_aaperfil();
            if ($rpta) {
                ?>
                <script>
                    alert('SE REGISTRO CON EXITO');
                    from_unico('', 'divuserypermiso', '_adm_perfil.php');
                </script>                   
                <?php
            } else {
                ?>
                <script>
                    alert('NO SE PUDO REGISTRAR');
                </script>
                <div class="alert alert-danger" id="mensaje">No se pudo registrar.</div>
                <?php
            }
            break;

        case 'ModPerfil':

            $perf->__set('id_perfil', trim($_POST['id_perfil']));
            $perf->__set('nombre', trim($_POST['nombre']));
            $perf->__set('obs', trim($_POST['obs']));
            $perf->__set('dom_user', $_SESSION['usuario']);

            $rpta = $perf->update_aaperfil();
            if ($rpta) {
                ?>
                <script>
                    alert('SE ACTUALIZO CON EXITO');
                    from_unico('', 'divuserypermiso', '_adm_perfil.php');
                </script>                
                <?php
            } else {
                ?>
                <script>
                    alert('LO SENTIMOS! NO SE PUDO ACTUALIZAR');
                </script>
                <div class="alert alert-danger" id="mensaje">No se pudo actualizar.</div>
                <?php
            }
            break;

        case 'RegRecurso':

            $rec->__set('nombre', trim($_POST['nombre']));
            $rec->__set('tipo', trim($_POST['tipo']));
            $rec->__set('orden', trim($_POST['orden']));
            $rec->__set('url', trim($_POST['url']));
            $rec->__set('dom_user', ($_SESSION['usuario']));

            $rpta = $rec->insert_aarecurso();
            if ($rpta) {
                ?>
                <script>
                    alert('SE REGISTRO CON EXITO');
                    from_unico('', 'divuserypermiso', '_adm_recurso.php');
                </script>                   
                <?php
            } else {
                ?>
                <script>
                    alert('NO SE PUDO REGISTRAR');
                </script>
                <div class="alert alert-danger" id="mensaje">No se pudo registrar.</div>
                <?php
            }
            break;

        case 'ModRecurso':
            $rec->__set('id_recurso', trim(strtoupper($_POST['id_recurso'])));
            $rec->__set('nombre', trim($_POST['nombre']));
            $rec->__set('tipo', trim($_POST['tipo']));
            $rec->__set('orden', trim($_POST['orden']));
            $rec->__set('url', trim($_POST['url']));
            $rec->__set('dom_user', ($_SESSION['usuario']));

            $rpta = $rec->update_aarecurso();
            if ($rpta) {
                ?>
                <script>
                    alert('SE ACTUALIZO CON EXITO');
                    from_unico('', 'divuserypermiso', '_adm_recurso.php');
                </script>                
                <?php
            } else {
                ?>
                <script>
                    alert('LO SENTIMOS! NO SE PUDO ACTUALIZAR');
                </script>
                <div class="alert alert-danger" id="mensaje">No se pudo actualizar.</div>
                <?php
            }
            break;


        default:
            break;
    }
}
?>
<script type='text/javascript'>
//    setTimeout("document.getElementById('mensaje').style.visibility='hidden'", 1000);
    $("#mensaje").delay(1000).hide(500);
</script>