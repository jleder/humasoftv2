<?php

$estado_session = session_status();
date_default_timezone_set("America/Bogota");
?>
<script type='text/javascript'>
    //    setTimeout("document.getElementById('mensaje').style.visibility='hidden'", 1000);
    $("#mensaje").delay(2000).hide(1000);
</script>
<?php

$obj = new C_Login();
if (isset($_POST['accion'])) {
    switch ($_POST['accion']) {
        case 'login':

            $obj->__set('codpersona', trim(strtoupper($_POST['codpersona'])));
            $obj->__set('nombre', trim(strtoupper($_POST['nombre'])));
            $obj->__set('apellido', trim(strtoupper($_POST['apellido'])));
            $obj->__set('dni', trim(strtoupper($_POST['dni'])));
            $obj->__set('fecnac', trim(strtoupper($_POST['fecnac'])));
            $obj->__set('sexo', trim(strtoupper($_POST['sexo'])));
            $obj->__set('telefono', trim(strtoupper($_POST['telefono'])));
            $obj->__set('celular', trim(strtoupper($_POST['celular'])));
            $obj->__set('email', trim(strtoupper($_POST['email'])));
            $obj->__set('foto', trim(strtoupper($_POST['foto'])));
            $obj->__set('direccion', trim(strtoupper($_POST['direccion'])));
            $obj->__set('dist', trim(strtoupper($_POST['dist'])));
            $obj->__set('prov', trim(strtoupper($_POST['prov'])));
            $obj->__set('dep', trim(strtoupper($_POST['dep'])));
            $obj->__set('salario', trim(strtoupper($_POST['salario'])));
            $obj->__set('cargo', trim(strtoupper($_POST['cargo'])));
            $obj->__set('fecingreso', trim(strtoupper($_POST['fecingreso'])));
            $obj->__set('fecsalida', trim(strtoupper($_POST['fecsalida'])));
            $obj->__set('profesion', trim(strtoupper($_POST['profesion'])));
            $obj->__set('tipo', trim(strtoupper($_POST['tipo'])));




        default:
            break;
    }
}