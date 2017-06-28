<?php
session_start();

$indice = $_GET['indice'];

unset($_SESSION['car'][$indice]);
unset($_SESSION['item'][$indice]);
unset($_SESSION['und'][$indice]);
unset($_SESSION['cardesp'][$indice]);

$_SESSION['car'] = array_values($_SESSION['car']);
$_SESSION['item'] = array_values($_SESSION['item']);
$_SESSION['und'] = array_values($_SESSION['und']);
$_SESSION['cardesp'] = array_values($_SESSION['cardesp']);
?>
<div id="mensaje" class="alert alert-success">Item se elimino corretamente.</div>
<script>
    from_unico('', 'divexperimento', '_propuestav2_vista_previa.php');
</script>
