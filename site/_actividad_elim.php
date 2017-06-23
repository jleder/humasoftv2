<script type='text/javascript'>    
    $("#msjelim").delay(2000).hide(1000);
</script>
<?php
include '../controller/C_Actividad.php';
$obj = new C_Actividad();
$id = $_GET['cod'];
$obj->__set('codigo', $id);
$rpta = $obj->elimActividad();
if ($rpta) {
    $obj->delete_intravisitas();
    ?>
    <div id="msjelim" class="alert alert-success">Se elimino corretamente.</div>
    <script>
        from_unico('', 'principal', '_actividad.php');
    </script>

    <?php
} else {
    ?> 
    <div class="alert alert-danger">No se pudo eliminar, debido a que este cliente tiene datos asociados.
        <a href="#" class="" onclick="cargar('#principal', '_actividad.php')">Volver</a></div>
    <?php
}