<?php
$codigo = $_GET['cod'];
?>
<script>
    function cerrar() {
        window.close();
    }
</script>
<p>Se ha actualizado el ESTADO DE LA PROPUESTA con éxito.</p>
<p>Si desea ver nuevamente esta PROPUESTA o hacer algún cambio, dar clic en el siguiente enlace <a href="_propuestav2_aprob02_verweb.php?cod=<?php echo $codigo; ?>"><?php echo $codigo; ?></a></p>
<br/>
<input type=button value="Cerrar Pagina" onclick="window.close()"> 