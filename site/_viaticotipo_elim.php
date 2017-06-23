<?php
include '../controller/.php';
$obj = new Viatico();
$obj->__set('codigo', $id);
$rpta = $obj->delete();
if ($rpta) {
    ?>
    <div id="mensaje" class="alert alert-success">Se elimino corretamente.</div>
    <script>
        from_unico("", "divclixempleado", "");
    </script>              
    <?php
} else {
    ?> 

    <div class="alert alert-danger">No se pudo eliminar, debido a que este cliente tiene datos asociados.

        <a href="#" class="" onclick="cargar('#principal', '')">Volver</a></div>

    <?php
}