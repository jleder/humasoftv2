<?php
include '../controller/C_ClientexVendedor.php';
$obj = new ClientexVendedor();
$id = $_GET['cod'];
$obj->__set('codclv', $id);
$rpta = $obj->delete_clvdb01();
if ($rpta) {
    ?>
    <div id="mensaje" class="alert alert-success">Se elimino corretamente.</div>
    <script>
        from_unico('', 'divclixempleado', '_cliente_emp.php');
    </script>
    <?php
} else {
    ?> 
    <script>
        alert('Error. Propuesta NO se pudo eliminar');
    </script>
    <?php
}