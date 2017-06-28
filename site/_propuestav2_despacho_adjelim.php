<?php
include '../controller/C_Solicitud.php';
$obj = new C_Propuesta();
$codigo = $_GET['id'];
$file = $_GET['file'];

$rpta = $obj->deleteFilePropAprob($codigo, $file);

if ($rpta) {
    ?>    
    <script>
        alert('SE ELIMINO CORRECTAMENTE :)!!');
    </script>
    <?php
} else {
    ?> 
    <script>
        alert('ERROR, NO SE PUDO ELIMINAR!!');
    </script>
    <?php
}
?>
<script type='text/javascript'>
    $("#mensaje").delay(5000).hide(2500);
</script>