<?php
@session_start();
$_SESSION["conectado"] = 'SI';
$_SESSION["usuario"] = 'ADM';
$_SESSION["nombreUsuario"] = 'Salvador Giha';

include_once '../controller/C_Solicitud.php';
//include_once '../controller/C_Producto.php';
$obj = new C_Propuesta();
unset($_SESSION['carrito']);
unset($_SESSION['car']);
?>
<html>
    <head>  
        <meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8" />
        <link rel="stylesheet" href="css/layout_html5.css" type="text/css" media="all" />                          
        <script src="util/media/js/js_menu.js" type="text/javascript"></script>               
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">   
        <link rel="stylesheet" href="css/layout_html5.css" type="text/css" media="all" />      
        <script type="text/javascript" src="js/jquery-3.1.0.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui.js"></script>  <!-- ESTA LIBRERIA PERMITE CONTROLAR EFECTOS, CALENDARIO, COLORES, ETC   -->
        <script type="text/javascript" src="js/fAjax.js"></script>     
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/js_inscoltec.js"></script>            
    </head>
    <body>                                        
        <div id="principal">
            <div class="row" style="">
                <h1>Propuestas HUMA GRO</h1>
            </div>
            <div class="row" style="font-size: x-small;" >
                <div class="col-lg-6">                
                    <a  href="#" class="btn btn-default btn-sm" onclick="javascript:cargar('#principal', '_propuestav2.web.php')">
                        <img src="img/iconos/propuesta.png" height="20px" title="Crear nuevo registro"  >
                        <span>Listar Propuestas</span>
                    </a>
                    <?php if ($_SESSION['usuario'] == 'JLP' || $_SESSION['usuario'] == 'ADM') { ?>
                        <a  href="#" class="btn btn-default btn-sm" onclick="javascript:cargar('#bodytable', '_propuestav2_aprob01.php')">
                            <img src="img/iconos/reloj-de-arena.png" height="20px" title="Propuestas Pendientes"  >
                            <span>Pendientes</span>
                        </a>
                    <?php } ?>
                </div>
            </div>
            <div class="row" style="">            
                <div class="col-lg-12">
                    <div id='bodytable' style="height: 700px; overflow: scroll; ">           
                        <h3>Lista de Propuestas a ser aprobadas por el Gerente</h3>
                        <table class="table table-striped" style=" padding: 5px; font-size: 10px;">
                            <thead>
                                <tr style="color: white; background-color: #1da8f4;">
                                    <th>Fecha Registro</th>
                                    <th>Nro. Propuesta</th>
                                    <th>Cliente</th>                                
                                    <th>Forma de Pago</th>
                                    <th>Demo</th>
                                    <th>Vendedor</th>
                                    <th>Estado</th>                                                
                                    <th></th>                                                
                                </tr>                   
                            </thead>
                            <tbody>
                                <?php
                                $listaprop = $obj->getPropuestasxAprobGerente();
                                foreach ($listaprop as $valor) {
                                    if ($valor['demo'] == 'SI') {
                                        $demo = '<span style="background-color: #22aadd; padding: 3px; color: white;">SI</span>';
                                    } else {
                                        $demo = '<span style="background-color: #f4f4fa; padding: 3px; color: #000;">NO</span>';
                                    }
                                    ?>                        
                                    <tr>
                                        <td><?php echo date("d/m/Y", strtotime($valor['fecreg'])); ?></td>
                                        <td><?php echo $valor['codprop'] ?></td>
                                        <td><?php echo $valor['nomcliente'] ?></td>
                                        <td><?php echo $valor['fpago'] ?></td>
                                        <td><?php echo $demo; ?></td>
                                        <td><?php echo $valor['vendedor'] ?></td>                        
                                        <td>
                                            <?php
                                            $obj->__set('codprop', $valor['codprop']);
                                            $estados = $obj->getEstadoItemPropuesta();

                                            foreach ($estados as $estado) {
                                                $valestado = $obj->getestadoPropuesta(trim($estado['estado']));
                                                echo '<p>' . $valestado . '</p>';
                                            }
                                            ?>
                                        </td>                                        
                                        <td style="width: 10%;">                                
                                            <a target="_blank" href="_propuestav2_update.php?cod=<?php echo trim($valor['codprop']); ?>" title="Modificar"><img src="img/iconos/ver.png" height="20" /></a>                                        
                                            <a target="_blank" href="_propuestav2_getpdf.php?codprop=<?php echo trim($valor['codprop']); ?>" title="PDF"><img src="img/iconos/pdficon2.png" height="20" /></a>                                        
                                            <a onClick="return confirmSubmit()" href="javascript:cargar('#principal', '_propuestav2_elim.php?cod=<?php echo trim($valor['codprop']); ?>')" title="Eliminar"><img src="img/iconos/trash.png" height="20" /></a>
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
    </body>
</html>

