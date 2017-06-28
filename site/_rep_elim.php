<?php
include '../controller/C_Reportes.php';

$obj = new C_Reportes();
$id = $_GET['id'];
$tipo = $_GET['tipo'];
$obj->__set('codrep', trim($id));
$rpta = $obj->eliminarReporte();

if ($tipo == 1) {
    $pagina = '_reptecnicov2.php';
}
if ($tipo == 2) {
    $pagina = '_repcomercialv2.php';
}

if ($rpta == "t") {
    $obj->delete_intravisitas();
    ?>
    <div class="alert alert-success">Se elimino corretamente.</div>
    <script>
        from_unico('<?php echo $_GET['id']; ?>', 'divreptecnico', '<?php echo $pagina; ?>');
    </script>
        <!--<a href="#" class="btn btn-primary" onclick="javascript:cargar('#principal', '<?php echo $pagina; ?>')">Regresar</a></div>-->
    <?php
} else {
    ?>
    <div class="alert alert-danger">No se pudo eliminar.</div>
    <script>
        from_unico('<?php echo $_GET['id']; ?>', 'divreptecnico', '<?php echo $pagina; ?>');
    </script>
    <!--<a href="#" class="btn btn-danger" onclick="javascript:cargar('#principal', '<?php echo $pagina; ?>')">Regresar</a></div>-->
    <?php
}
?>
<script type='text/javascript'>
    $("#mensaje").delay(5000).hide(2500);
</script>