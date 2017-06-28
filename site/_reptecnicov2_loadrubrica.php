<?php
include '../controller/C_Reportes.php';
$obj = new C_Reportes();

$codcliente = $_GET['cod'];
$obj->__set('codcliente', $codcliente);
$lista = $obj->cargarEncargadoxCliente();

?>



<select class="form-control" name="rubrica" id="rubrica" onchange="firmadoporOtro()">
    <option value="0">..::Seleccione</option>
    <?php
    if (count($lista) > 0) {
        for ($i = 0; $i < (count($lista)); $i++) {
            ?>
            <option value="<?php echo trim($lista[$i][0]) ?>"><?php echo trim($lista[$i][0]); ?></option>
            <?php }
        ?>
        <option value="NINGUNO">NINGUNO</option>
        <option value="otro">..::Otro</option>
    <?php } else {    ?>                                         
        <option value="NINGUNO">NINGUNO</option>
        <option value="otro">..::Otro</option>
    <?php }?>
</select>