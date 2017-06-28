<script type='text/javascript'>    
    $("#msjelim").delay(3000).hide(2000);
</script>
<?php
include '../controller/C_Actividad.php';
$obj = new C_Actividad();
$id = $_GET['cod'];
$tipo = $_GET['tipo'];
$url = '';
if($tipo == '1'){
    $url = '_actividad.php';
}else{
    $url = '_actividad_on.php';
}
$obj->__set('codigo', $id);
$rpta = $obj->elimActividad();
if ($rpta) {
    $obj->delete_intravisitas();
    ?>
    <div id="msjelim" class="alert alert-success">Se elimino corretamente.</div>
    
    <script>
        alert("OK, se ha eliminado");
        location.href = '<?php echo $url;?>';
    </script>

    <?php
} else {
    ?> 
    <script>
        alert("ERROR, no se puedo eliminar");
        location.href = '<?php echo $url;?>';
    </script>
    <?php
}