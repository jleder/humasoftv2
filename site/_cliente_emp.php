<?php
include '../controller/C_ClientexVendedor.php';
$obj = new ClientexVendedor();
$lista = $obj->listarAll();
?>
<div class="row">
    <div class="col-lg-12">    
        <a style="font-size: 11px;" href="#" class="btn btn-default" onclick="javascript:cargar('#divclixempleado', '_cliente_emp_reg.php')">
            <span>Registrar Cliente por Vendedor</span>
        </a>
    </div>
</div>
<hr/>
<div class="row" id="divclixempleado">
    <div class="col-lg-12">
        <table class="table table-hover" style="font-size: 11px;">
            <thead>
                <tr>
                    <th>Vendedor</th>
                    <th>Cliente</th>
                    <th>Fecha Inicio</th>
                    <th>% Comision PAQ</th>
                    <th>Compartido</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($lista as $value) {
                    $compartido = 'SI';
                    if ($value['compartido'] == 'f') {
                        $compartido = 'NO';
                    }
                    echo '<tr>';
                    echo '<td>' . $value['nomven'] . '</td>';
                    echo '<td>' . $value['nomcli'] . '</td>';
                    echo '<td>' . $value['fecapertura'] . '</td>';
                    echo '<td>' . $value['comisionpaq'] . '</td>';
                    echo '<td>' . $compartido . '</td>';
                    echo '<td>';
                    ?>                
                <a href="#" onclick="cargar('#divclixempleado', '_cliente_empcomp.php?cod=<?php echo trim($value['codclv']); ?>')" title="Compartir Comision con otros vendedores"><img src="img/iconos/icon-user.png" height="20" /> </a>
                <a href="#" onclick="cargar('#divclixempleado', '_cliente_emp_edit.php?cod=<?php echo trim($value['codclv']); ?>')" title="Modificar"><img src="img/iconos/editar.jpg" height="20" /> </a>
                <a onClick="return confirmSubmit()" href="javascript:cargar('#divclixempleado', '_cliente_emp_elim.php?cod=<?php echo trim($value['codclv']); ?>')" title="Eliminar"><img src="img/iconos/trash.png" height="20" /></a>
                <?php
                echo '</td>';
                echo '</tr>';
            }
            ?>
            </tbody>
        </table>
        <p>
            Para compartir comisión con otros vendedores clic en el icono <img src="img/iconos/icon-user.png" height="15px" />
        </p>
    </div>
</div>