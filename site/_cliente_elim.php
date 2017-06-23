<?php
include '../controller/C_Cliente.php';

$obj = new C_Cliente();
$id = $_GET['id'];
$obj->__set('codcliente', $id);
$rpta = $obj->deleteCliente();
?>

<div class="row">
    <div id="breadcrumb" class="col-md-12">
        <ol class="breadcrumb">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="#">Clientes</a></li>
            <li><a href="#">Eliminar Cliente</a></li>
        </ol>
    </div>
</div>        
<div class="row">
    <div class="col-sm-12">
        <?php
        if ($rpta) {
            ?>
            <div class="alert alert-success">Se elimino corretamente.</div>
            <?php
        } else {
            ?>
            <div class="alert alert-danger">No se pudo eliminar, debido a que este cliente tiene datos asociados.</div>
            <?php
        }
        ?>
    </div>
</div>
