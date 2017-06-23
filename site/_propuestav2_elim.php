<?php
include '../controller/C_Solicitud.php';
$obj = new C_Propuesta();

$id = $_GET['cod'];
$obj->__set('codprop', $id);
$rpta2 = $obj->delete_propdb11ByCodProp();
$rpta3 = $obj->delete_propdb12ByCodProp();
if ($rpta2 && $rpta3) { 
    //Eliminar archivos
    $rpta = $obj->deletePropxAprob();
    if ($rpta) {
        ?>
        <div id="mensaje" class="alert alert-success">Propuesta Se elimino corretamente.</div>
        <script>            
            from_unico('<?php echo $_GET['cod']; ?>', 'principal', '_propuestav2.php');
        </script>
        <?php
    } else {
        ?>
        <script>
            alert('Error. Propuesta NO se pudo eliminar');
        </script>
        <?php
    }
} else {
    ?> 
        <div class="alert alert-danger">No se pudo eliminar, debido a que estA PROPUESTA tiene datos asociados.</div>        
    <?php
}
?>

<script type='text/javascript'>
    $("#mensaje").delay(5000).hide(2500);
</script>