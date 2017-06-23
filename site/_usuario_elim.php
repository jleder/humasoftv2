<?php
include '../controller/C_Usuario.php';

$obj = new C_Usuario();
$id = $_GET['id'];
$obj->__set('coduse', $id);
$rpta = $obj->delete_aausdb01();

if ($rpta) {
    //header('Location:http://localhost:8080/humasoftv2/site/Dashboard.php#_usuario.php');
    ?>    
    <script>
        alert('Se elimino con éxito');
    from_unico('', 'ajax-content', '_usuario.php');
    </script>
    <?php
} else {
    ?>
    <script>
        alert('Error. Propuesta NO se pudo eliminar');
    </script>
    <?php
}
?>

<script type='text/javascript'>
    $("#mensaje").delay(5000).hide(2500);
</script>