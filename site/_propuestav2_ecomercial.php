<?php
@session_start();
include_once '../controller/C_Propuestas.php';
$ecom = new C_EstadoComercial();

$codprop = trim($_GET['codprop']);
$ecom->__set('codprop', $codprop);
?>
<html>
    <head>  
        <meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8" />
        <link rel="stylesheet" href="css/layout_html5.css" type="text/css" media="all" />                                                          
    </head>
    <body>   

        <div class="row" style="">
            <div class="col-lg-12">
                <h3>Lista de Estados Comerciales</h3>
            </div>
        </div>        
        <div class="row" style="font-size: x-small;" >
            <div class="col-lg-4">
                <a  href="#" class="btn btn-default btn-sm" onclick="javascript:cargar('#bodytable2', '_propuestav2_ecomercial_reg.php?codprop=<?php echo $codprop; ?>')">
                    <img src="img/iconos/Add.png" height="20px" title="Crear nuevo estado"  >
                    <span>Registrar Estado</span>
                </a>                                                    
            </div>                
        </div>
        <br/>
        <div class="row" style="">            
            <div class="col-lg-12">
                <div id='bodytable2' style="min-height: 400px;">                                   
                    <table class="table table-striped" style=" padding: 5px; font-size: 10px;">
                        <thead>
                            <tr style="color: white; background-color: #1da8f4;">
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Observaciones</th>
                                <th></th>                                                
                            </tr>                    
                        </thead>
                        <tbody>
                            <?php
                            $lista = $ecom->listar_propdb16_all_by_codprop();
                            if (count($lista) > 0) {
                                foreach ($lista as $valor) {
                                    ?>                        
                                    <tr>
                                        <td><?php echo date("d/m/Y", strtotime($valor['fecha'])); ?></td>
                                        <td><?php echo $valor['estado'] ?></td>
                                        <td><?php echo $valor['obs'] ?></td>                                        
                                        <td>
                                            <a class="btn btn-default" href="#" onclick="javascript:cargar('#bodytable', '_propuestav2_ecomercial_edit.php?codestado=<?php echo trim($valor['codestado']); ?>&codprop=<?php echo trim($codprop); ?>')" title="Modificar Estado Comercial"><img src="img/iconos/edit.png" height="15" /></a>
                                            <a class="btn btn-default" onClick="return confirmSubmit()" href="javascript:cargar('#bodytable2', '_propuestav2_ecomercial_elim.php?codestado=<?php echo trim($valor['codestado']); ?>&codprop=<?php echo trim($codprop); ?>')" title="Eliminar Estado Comercial"><img src="img/iconos/trash.png" height="15" /></a>
                                        </td>                                    
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo '<tr>';
                                echo '<td colspan="4">No se encontraron datos.</td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>    
            </div>            
        </div>
    </body>
</html>

