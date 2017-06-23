<?php
include '../controller/C_ClientexVendedor.php';
$clvdb01 = new ClientexVendedor();
$clvdb02 = new ClientexVendedorCompartido();
$codclv = trim($_GET['cod']);

$clvdb01->__set('codclv', $codclv);
$getdatos = $clvdb01->listarByCod();

$clvdb02->__set('codclv', $codclv);
$lista = $clvdb02->listarByCodClv();
?>
<div class="row">
    <div class="col-lg-2">
        Cliente:
    </div>
    <div class="col-lg-8">
        <?php echo strtoupper($getdatos[12]); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-2">
        Vendedor Titular:
    </div>
    <div class="col-lg-8">
        <?php echo strtoupper($getdatos[11]); ?>
    </div>
</div>
<br/>
<br/>
<div class="row">
    <div class="col-lg-12">
        <table class="table table-hover" style="font-size: 11px;">
            <thead>
                <tr>
                    <th>Nombre de Vendedor</th>
                    <th>% Compartido PAQ</th>
                    <th>Observaciones</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($lista) > 0) {
                    foreach ($lista as $value) {
                        echo '<tr>';
                        echo '<td>' . $value['nomven'] . '</td>';
                        echo '<td>' . $value['comisionpaq'] . '</td>';
                        echo '<td>' . $value['obs'] . '</td>';
                        echo '<td>';
                        ?>
                    <a onClick="return confirmSubmit()" href="javascript:cargar('#divclvdb2', '_cliente_empcomp_elim.php?cod=<?php echo trim($value['codigo']); ?>')" title="Eliminar"><img src="img/iconos/trash.png" height="20" /></a>
                    <?php
                    echo '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr>';
                echo '<td colspan="4">No comparte comisiones</td>';
                echo '</tr>';
            }
            ?>                
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        
        <a class="btn btn-info btn-sm" href="#" onclick="cargar('#divclixempleado', '_cliente_empcomp.php?cod=<?php echo $codclv; ?>')">Actualizar Tabla </a>
        <a class="btn btn-primary btn-sm" href="#" onclick="cargar('#divclvdb2', '_cliente_empcomp_reg.php?cod=<?php echo $codclv; ?>')">Agregar Compartir Comision</a>
    </div>
</div>
<br/>
<div class="row" id="divclvdb2">
    
</div>