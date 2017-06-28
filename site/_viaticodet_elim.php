
<?php
include '../controller/C_Viaticos.php.php';
$obj = new C_Viaticos . php();
$obj->__set('coddetalle', $id);
$rpta = $obj->delete();
if ($rpta) {
    ?>
    <div id="mensaje" class="alert alert-success">Se elimino corretamente.</div>
    <script>
        from_unico("", "divclixempleado", "_viaticos.php");
    </script>              
    <?php
} else {
    ?> 

    <div class="alert alert-danger">No se pudo eliminar, debido a que este cliente tiene datos asociados.

        <a href="#" class="" onclick="cargar('#principal', '_viaticos.php')">Volver</a></div>

    <?php
}
            