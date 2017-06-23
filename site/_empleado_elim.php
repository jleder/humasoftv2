<?php
include '../controller/C_Empleados.php';
$obj = new C_Empleados();
$obj->__set('codpersona', $id);
$rpta = $obj->delete();
if ($rpta) {
    ?>
    <div id="mensaje" class="alert alert-success">Se elimino corretamente.</div>
    <script>
        from_unico("", "divclixempleado", "_empleado.php");
    </script>              
    <?php
} else {
    ?> 

    <div class="alert alert-danger">No se pudo eliminar, debido a que este cliente tiene datos asociados.

        <a href="#" class="" onclick="cargar('#principal', '_empleado.php')">Volver</a></div>

    <?php
}
            