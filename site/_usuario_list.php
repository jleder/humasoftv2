<?php
/*
 * Proyecto Humasoft.
 * Desarrollado por Juan Leder
 */
@session_start();
include_once '../controller/C_Usuario.php';
$obj = new C_Usuario();
$lista = $obj->listar_aausdb01_todos();
?>

<div class="box">
    <div class="box-header">
        <div class="box-name">
            <i class="fa fa-users"></i>
            <span>Usuarios de Intranet</span>
        </div>
        <div class="box-icons">
            <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
            </a>
            <a class="expand-link">
                <i class="fa fa-expand"></i>
            </a>
            <a class="close-link">
                <i class="fa fa-times"></i>
            </a>
        </div>
        <div class="no-move"></div>
    </div>
    <div class="box-content no-padding">
        <table  class="table table-bordered table-striped table-hover table-heading table-datatable" id="datatable-1" style="font-size: 10px; ">
            <thead>
                <tr>
                    <th>NRO.</th>   
                    <th>TITULAR</th>
                    <th>USUARIO</th>
                    <th>CLAVE</th>
                    <th>VENDEDOR</th>
                    <th>ASESOR COMERCIAL</th>
                    <th>ASESOR TECNICO</th>
                    <th>ACTIVO</th>
                    <th>OPCIONES</th>                            
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($lista) > 0) {
                    $i = 0;
                    foreach ($lista as $value) {
                        $i++;
                        $activo = 'SI';
                        $coduse = trim($value["coduse"]);
                        if ($value['activo'] == 'f') {
                            $activo = 'NO';
                        }
                        ?>
                        <tr style="">
                            <td width="5%"><?php echo $i ?></td>
                            <td width=""><?php echo $value['desuse']; ?></td>
                            <td width=""><?php echo $value['coduse']; ?></td>
                            <td width=""><?php echo $value['pwduse']; ?></td>
                            <td width=""><?php echo $value['vendedor']; ?></td>
                            <td width=""><?php echo $value['vc']; ?></td>
                            <td width=""><?php echo $value['vt']; ?></td>
                            <td width=""><?php echo $activo; ?></td>
                            <td width="" align="center">
                                <a onclick="cargar('#divuserypermiso', '_usuario_editar.php?id=<?php echo trim($coduse); ?>')" href="#" title="Modificar usuario" class="btn btn-default"><span class="fa fa-edit txt-info"></span></a>
                                <a onclick="return confirmSubmit()" href="javascript:cargar('#divuserypermiso', '_usuario_elim.php?id=<?php echo trim($coduse); ?>')" title="Eliminar usuario" class="btn btn-danger"><span class="fa fa-trash-o"></span></a>
                            </td>                               
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
        <br/>                                
    </div>
</div>                                       