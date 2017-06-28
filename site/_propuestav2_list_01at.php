<?php
/*
 * Proyecto Humasoft.
 * Desarrollado por Juan Leder
 */
?>

<div class="row">                        
    <div class="col-xs-12 col-sm-12">
        <div class="box">
            <div class="box-header">
                <div class="box-name">
                    <i class="fa fa-dollar"></i>
                    <span>Tabla de Propuestas Huma Gro (Elaboración de Propuestas)</span>
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
            <div class="box-content form-horizontal">                                             
                <div id="divpropuesta">               
                    <a class="btn btn-primary" href="_propuestav2_reg.php">Nueva Propuesta</a>
                    <table  class="table table-bordered table-striped table-hover table-heading" id="datatable-1" style="font-size: 10px;">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Fecha Registro</th>
                                <th>Código de Propuesta</th>
                                <th style="width: 300px;">Razon Social de Cliente</th>                                
                                <th style="width: 100px;">Vendedor</th>
                                <th>Demo</th>
                                <th>Ha</th>
                                <th>Monto</th>
                                <th>Dscto</th>
                                <th>Estado GER</th>
                                <th>Estado COM</th>                                
                                <th style="text-align: center; font-size: medium;"><span class="fa fa-cog"></span></th>                                                
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $listaprop = $obj->getPropuestasxAprobGerente();
                            $corredor = 0;
                            foreach ($listaprop as $valor) {
                                $corredor++;
                                if ($valor['demo'] == 'SI') {
                                    $demo = '<span style="background-color: #22aadd; padding: 3px; color: white;">SI</span>';
                                } else {
                                    $demo = '<span style="background-color: #f4f4fa; padding: 3px; color: #000;">NO</span>';
                                }
                                ?>                        
                                <tr>
                                    <td style="text-align: center;"><?php echo $corredor; ?></td>
                                    <td><?php echo date("d/m/Y G:i", strtotime($valor['fecreg'])); ?></td>
                                    <td><?php echo $valor['codprop'] ?></td>
                                    <td><?php echo $valor['nomcliente'] ?></td>
                                    <td><?php echo $valor['vendedor'] ?></td>
                                    <td><?php echo $demo; ?></td>
                                    <?php
                                    //Estado Gerencial
                                    $obj->__set('codprop', $valor['codprop']);
                                    $array_item = $obj->getItemPropuestaByCodProp();
                                    ?>
                                    <td>
                                        <?php
                                        foreach ($array_item as $item1) {
                                            echo '<p>' . $item1['ha'] . '</p>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        foreach ($array_item as $item2) {
                                            echo '<p>$' . $item2['precioambt'] . '</p>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        foreach ($array_item as $item3) {
                                            echo '<p>' . $item3['descuento'] . '%</p>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        foreach ($array_item as $item4) {
                                            $valestado = $obj->getestadoPropuesta(trim($item4['estado']));
                                            echo '<p>' . $valestado . '</p>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        //Estado Comercial                                        
                                        $ecom->__set('codprop', $valor['codprop']);
                                        $estado_com = $ecom->obtener_ultimo_estado_by_codprop();
                                        if (count($estado_com) > 0) {
                                            $estilo = $obj->getestiloestado($estado_com[0]['estado']);
                                            echo '<span class="' . $estilo . '">' . $estado_com[0]['estado'] . '</span>';
                                        }
                                        ?>
                                    </td>                                    
                                    <td style="text-align: center;">
                                        <a class="btn2 btn-icon" target="_blank" href="_propuestav2_update.php?cod=<?php echo trim($valor['codprop']); ?>" title="Ver o Modificar Propuesta"><img src="img/iconos/ver.png" style="height: 15px; width: 15px;"/></a>
                                        <a class="btn2 btn-icon" target="_blank" href="_propuestav2_getpdf.php?codprop=<?php echo trim($valor['codprop']); ?>" title="PDF"><img src="img/iconos/pdficon2.png" style="height: 15px; width: 15px;"/></a>
                                        <a class="btn2 btn-icon" target="_blank" href="_propuestav2_genword.php?codprop=<?php echo trim($valor['codprop']); ?>" title="Descargar Word Personalizado"><img src="img/iconos/wordicon.png" style="height: 15px; width: 15px;"/></a>
                                        <a class="btn2 btn-icon" target="_blank" href="_propuestav2_genexcel.php?codprop=<?php echo trim($valor['codprop']); ?>" title="Descargar Excel"><img src="img/iconos/excelicon.png" style="height: 15px; width: 15px;"/></a>                                        
                                        <a class="btn2 btn-icon" href="_propuestav2_archivo_at.php?codprop=<?php echo trim($valor['codprop']); ?>" title="Archivos"><img src="img/iconos/file-icon.png" style="height: 15px; width: 15px;"/></a>
                                        <a class="btn2 btn-icon" onClick="return confirmSubmit();" href="javascript:cargar('#divpropuesta', '_propuestav2_elim.php?cod=<?php echo trim($valor['codprop']); ?>')" title="Eliminar"><img src="img/iconos/trash.png" style="height: 15px; width: 15px;"/></a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>
</div>                            