<?php
@session_start();
date_default_timezone_set("America/Bogota");
include_once '../controller/C_Solicitud.php';
$pro = new C_Propuesta();
$desp = new C_Despacho();
$detd = new C_DetalleDespacho();

//$hoy = $obj->obtFechadeHoy();
$codigo = $_GET['cod'];
$pro->__set('codprop', $codigo);
$detprop = $pro->getPropuestasxAprobGerenteByCod();

$desp->__set('codprop', $codigo);
$listdesp = $desp->despachosByCodprop();

//cargar archivos DESPACHO subidos
$despachos = $pro->getFileDespachoByCodprop();

//$coddespachos = $desp->getcantidaddespachos();
//************* CLIENTE 
//************* URGENCIA
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 

        <!--calendario-->        
        <script type="text/javascript" src="js/js_inscoltec.js"></script>
        <!--<script src="util/media/js/jquery.js" type="text/javascript"></script>-->
        <style type="text/css">            
            @import "util/media/themes/smoothness/jquery-ui-1.8.4.custom.css";            
            .centro { text-align: center;}
            #form_reg {
                font-family: inherit; font-size: smaller;
            }
            .row { margin-top: 5px;}
            .derecha {text-align: right; }
            .tablinha { border: solid 1.5px; }
            .tablinha td, th { padding: 5px;}
            .subtitulo { color: #000077; font-size: small;}
            #portapdf { 
                width: 100%; 
                height: 500px; 
                border: 1px solid #484848; 
                margin: 0 auto; 
            } 
            .entregado { background-color: #9de9a2; }
            .noentregado { background-color: #f2f2f1;; }            

            .panel-heading label { font-size: 1.5em;}
            .panel-body { font-size: 1.2em;}
        </style>  

    </head>
    <body> 
        <div id="divdetdespacho" class="container" style="width: 200mm;">
            <form id="form" name="form" action="#" method="post" enctype="multipart/form-data" class="formulario">            
                <div id="form_reg">
                    <div class="panel panel-default">
                        <div class="panel-heading"><label>Estado de Despachos</label></div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12" style="text-align: center; color: blue; font-size: larger;">
                                    Propuesta Aprobada Nro.: <?php echo $detprop[0]; ?> <br/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">Fecha de Registro:</div>
                                <div class="col-lg-6"><?php echo date("d/m/Y", strtotime($detprop[4])); ?></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">Cliente:</div>
                                <div class="col-lg-6"><?php echo $detprop[2]; ?></div>                                
                            </div>
                            <div class="row">
                                <div class="col-lg-3">Contacto:</div>
                                <div class="col-lg-6"><?php echo $detprop[5]; ?></div>                                
                            </div>
                            <div class="row">
                                <div class="col-lg-3">Asesor:</div>
                                <div class="col-lg-3"><?php echo $detprop[8]; ?></div>                                
                                <div class="col-lg-3">Elaborado por:</div>
                                <div class="col-lg-3"><?php echo $detprop[9]; ?></div>                                
                            </div>
                            <div class="row">
                                <div class="col-lg-3">Cultivo:</div>
                                <div class="col-lg-3"><?php echo $detprop[10]; ?></div>                                
                                <div class="col-lg-3">Variedad:</div>
                                <div class="col-lg-3"><?php echo $detprop[11]; ?></div>                                
                            </div>                            
                            <div class="row">
                                <div class="col-lg-3">Forma de Pago:</div>
                                <div class="col-lg-3"><?php
                                    if (!empty($detprop[18])) {
                                        echo $detprop[18];
                                    } else {
                                        echo 'No Definido';
                                    }
                                    ?></div>                                
                                <div class="col-lg-3">Intereses:</div>
                                <div class="col-lg-3"><?php
                                    if ($detprop[19] <> '') {
                                        echo $detprop[19] . '%';
                                    }
                                    ?></div>                                
                            </div>

                            <div class="row">
                                <div class="col-lg-3">Obervaciones:</div>
                                <div class="col-lg-9"><?php echo $detprop[17]; ?></div>                                                                
                            </div>
                            <hr/>                            
                            <div class="row" style="text-align: center; font-size: 14px;">
                                <div class="col-lg-12">Despachos para esta Propuesta</div>                                                                                                                           
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <a class="btn btn-default btn-sm" href="#" onclick="javascript:cargar('#divdespacho', '_propuestav2_despacho_reg.php?cod=<?php echo trim($codigo); ?>')" >Agregar Nuevo Despacho</a><br/><br/>
                                </div>
                                <div class="col-lg-3">
                                    <a class="btn btn-default btn-sm" href="#" onclick="javascript:cargar('#divdespachoadj', '_propuestav2_despacho_adj.php?cod=<?php echo trim($codigo); ?>')" >Adjunta un archivo</a><br/><br/>
                                </div>
                            </div>
                            <div class="row" id="divdespachoadj">                              
                            </div>

                            <div class="row">
                                <div class="col-lg-12">

                                    <?php
                                    if (count($despachos) > 0) {
                                        echo '<h4>Archivo(s) de este Despacho:</h4>';
                                        ?>
                                    <table class="table table-striped" style="font-size: 10px;">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Nombre de Archivo</th>
                                                    <th><span class="fa fa-cogs"></span></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i=0;
                                                foreach ($despachos as $despacho) {
                                                    $i++;
                                                    $url = html_entity_decode($despacho["url"]);
                                                    $codarchivo = $despacho["codarchivo"];
                                                    ?>   
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><a href="archivos/propuestas/<?php echo htmlentities($url); ?>" target="_blank"><?php echo $url; ?></a> </td>
                                                    <td><a style="background-color: red; color: white; padding: 3px;" onclick="return confirmSubmit()" href="javascript:cargar('#deletefiledes', '_propuestav2_despacho_adjelim.php?file=<?php echo urlencode($url) ?>&id=<?php echo $codarchivo; ?>')">Eliminar</a></td>
                                                </tr>                                                
                                                <?php
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    <?php } ?>

                                </div>

                            </div>
                            <div id="deletefiledes"></div>
                            <div class="row" >

                                <div class="col-lg-12" id="divdespacho">
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-lg-12">
                                    <h4>Información de Despachos</h4>
                                    <?php
                                    if (count($listdesp)) {
                                        $c = 0;
                                        foreach ($listdesp as $despachos) {
                                            $detd->__set('coddesp', $despachos['coddesp']);
                                            $estdespacho = $detd->getLastDetDespByCoddesp();
                                            $colorestilo = '';
                                            $estado = '';
                                            if ($estdespacho) {
                                                if ($estdespacho[3] == 'ENTREGADO') {
                                                    $colorestilo = '#9de9a2';
                                                    $estado = $estdespacho[3];
                                                } else {
                                                    $colorestilo = '#f2f2f1';
                                                    $estado = $estdespacho[3];
                                                }
                                            } else {
                                                $colorestilo = '#f2f2f1';
                                                $estado = '<span style="color: orange;">Desconocido</span></p>';
                                            }

                                            $c++;
                                            ?>
                                            <div class="row" style="background-color: <?php echo $colorestilo; ?>; margin: 3px; padding: 5px;"> 
                                                <div class="col-lg-4">                                            
                                                    Despacho: <?php echo $despachos['descripcion']; ?><br/>
                                                </div>
                                                <div class="col-lg-8">                                            
                                                    Estado: 
                                                    <?php
                                                    echo $estado;
                                                    ?>

                                                </div>
                                            </div>
                                            <div class="row" style="margin: 3px; padding: 5px;"> 
                                                <div class="col-lg-4">                                                                                        
                                                    Prioridad: <?php echo $despachos['prioridad']; ?><br/>
                                                    Entrega Prevista: <?php echo date("d/m/Y", strtotime($despachos['fecprev'])); ?><br/>
                                                    Monto Despachado: <?php echo $despachos['moneda'] . number_format($despachos['montodesp'], 2); ?><br/>
                                                    Saldo: <?php echo $despachos['moneda'] . number_format($despachos['saldo'], 2); ?><br/>
                                                    Observaciones: <?php echo $despachos['obs']; ?><br/>
                                                    <a class="btn btn-default" href="#divdespacho" onclick="javascript:cargar('#divdespacho', '_propuestav1_despacho_edit.php?cod=<?php echo trim($despachos['coddesp']); ?>')" title="Modificar">
                                                        <img src="img/iconos/edit.png" height="15" />
                                                    </a>                                                             
                                                    <a class="btn btn-default" onClick="return confirmSubmit()" href="javascript:cargar('#principal', '_propuestav1_despacho_elim.php?cod1=<?php echo trim($codigo); ?>&cod2=<?php echo trim($despachos['coddesp']); ?>&tipo=1')" title="Eliminar">
                                                        <img src="img/iconos/trash.png" height="15" />
                                                    </a>                                                        
                                                </div>
                                                <div class="col-lg-8">                                            
                                                    <p>Seguimiento de este Despacho</p>
                                                    <table style="font-size: 0.9em; width: 100%">
                                                        <thead>
                                                            <tr style="background-color: #f2f2f1;">                                                                                                                                                                                
                                                                <th>ESTADO DESPACHO</th>
                                                                <th>FECHA ESTADO</th>
                                                                <th>OBSERVACIONES</th>                                                        
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $lista = $detd->getDetDespByCoddesp();
                                                            if (count($lista)) {
                                                                foreach ($lista as $value) {
                                                                    ?>
                                                                    <tr>                                                                        
                                                                        <td><?php echo $value['estado']; ?></td>
                                                                        <td><?php echo date("d/m/Y", strtotime($value['fecha'])); ?></td>
                                                                        <td><?php echo $value['obs']; ?></td>                                                                
                                                                        <td>
                                                                            <a class="btn btn-default" href="#divdespacho<?php echo $c; ?>" onclick="javascript:cargar('#divdespacho<?php echo $c; ?>', '_propuestav1_detdesp_edit.php?cod=<?php echo trim($value['codigo']); ?>')" title="Modificar">
                                                                                <img src="img/iconos/edit.png" height="10" />
                                                                            </a>
                                                                            <a class="btn btn-default" onClick="return confirmSubmit()" href="javascript:cargar('#principal', '_propuestav1_despacho_elim.php?cod1=<?php echo trim($codigo); ?>&cod2=<?php echo trim($value['codigo']); ?>&tipo=2')" title="Eliminar">
                                                                                <img src="img/iconos/trash.png" height="10" />
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            } else {
                                                                echo '<td colspan=5 style="color: red;">No hay estados registrados</td>';
                                                            }
                                                            ?>
                                                        </tbody>
                                                        <tfoot>                                            
                                                            <tr style="">

                                                                <td colspan="2">
                                                                    <a class="btn btn-default btn-sm" href="#divdespacho<?php echo $c; ?>" onclick="javascript:cargar('#divdespacho<?php echo $c; ?>', '_propuestav2_detdesp_reg.php?cod1=<?php echo $despachos["coddesp"] ?>')" title="Adicionar Estado">
                                                                        <img src="img/iconos/add.jpg" height="15" /> 
                                                                    </a> Agregar Estado
                                                                </td>

                                                                <td></td>
                                                                <td></td>                                                
                                                                <td></td>                                                        
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                    <br/>
                                                    <div style="font-size: 0.9em;" id="divdespacho<?php echo $c; ?>">
                                                    </div>

                                                </div>
                                            </div>

                                            <br/><br/>
                                            <?php
                                        }
                                    } else {
                                        echo '<span>No hay despachos programados para esta propuesta</span>';
                                    }
                                    ?>
                                </div>

                            </div>                                                                                                                                                                                                                                                        
                        </div>  
                    </div>
                    <center>                                                                        
                        <a href="#" onclick="cargar('#principal', '_propuestav2.php')" class="btn btn-danger btn-sm">Volver</a>                                                
                        <a href="#" onclick="cargar('#divdetdespacho', '_propuestav2_detdespacho.php?cod=<?php echo $codigo; ?>')" class="btn btn-info btn-sm">Actualizar</a>                                                                        
                    </center>
                </div>                       
            </form>
            <br/>
            <p><div id="result"></div>
        </div>
    </body>
</html>