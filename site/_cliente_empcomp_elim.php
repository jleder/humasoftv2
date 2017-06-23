<?php
include '../controller/C_ClientexVendedor.php';
$obj = new ClientexVendedorCompartido();

$id = $_GET['cod'];
$obj->__set('codigo', $id);
$rpta = $obj->delete_clvdb02();
if ($rpta) {
    ?>
    <div class="alert alert-success">Se elimino corretamente.</div>
    <?php
} else {
    ?> 
    <div class="alert alert-danger">No se pudo eliminar, debido a que este cliente tiene datos asociados.</div>
    <?php
}