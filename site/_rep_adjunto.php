<?php
@session_start();
include_once '../controller/C_Reportes.php';
$obj = new C_Reportes();
$id = $_GET['id'];
$tipo = $_GET['tipo'];
$obj->__set('codrep', $id);


$reporte = $obj->listarRepTecnicoxCod();
$cliente = $reporte[2];
$encargado = $reporte[7];
$adjunto = $obj->getAdjuntoByCodRep();

//SOLUCION PARA LA HORA CON UN DIGITO
function arreglarHora($hora, $minuto) {
    $h = strlen($hora);
    $m = strlen($minuto);
    if ($h == 1) {
        $hora = '0' . $hora;
    }
    if ($m == 1) {
        $minuto = '0' . $minuto;
    }
    $resultado = $hora . ':' . $minuto;
    if ($resultado == ':') {
        $resultado = '';
    }
    return $resultado;
}

//
$horaingreso = arreglarHora($reporte[9], $reporte[10]);
$horasalida = arreglarHora($reporte[11], $reporte[12]);
?>
<html>
    <head>             

    </head>
    <body>
        <div class="container">
            <div style="padding: 10px; margin-left: 10px; margin-top: 10px;">        
                <?php if ($tipo == 1) { ?>
                    <h4 style="text-align: center">ARCHIVOS ADJUNTOS DEL REPORTE N° <?php echo $reporte[0]; ?></h4>
                <?php } else { ?>
                    <h4 style="text-align: center">ARCHIVO ADJUNTO DE VISITA COMERCIAL</h4>
                <?php } ?>
                <div class="panel panel-primary">
                    <div class="panel-heading"><label>Detalles del Reporte</label></div>
                    <div class="panel-body">



                        <div class="row">
                            <div class="col-lg-6">                        
                                <div class="col-lg-12">Cliente:  <?php echo $cliente; ?>                            
                                </div>                    
                                <div class="col-lg-12">Encargado: <?php echo $encargado; ?>                            
                                </div>                    
                                <div class="col-lg-12">Asesor: <?php echo $reporte[6]; ?>                            
                                </div>                    
                            </div>

                            <div class="col-lg-6">
                                <div class="col-lg-12">Reporte Fecha Visita: <?php echo date("Y/m/d", strtotime($reporte[8])); ?>
                                </div>                    
                                <div class="col-lg-12">Hora Ingreso: <?php echo $horaingreso; ?>
                                </div>
                                <div class="col-lg-12">Hora Salida: <?php echo $horasalida; ?>
                                </div>                        
                            </div>                                            
                        </div>  
                        <?php foreach ($adjunto as $value) { ?>
                            <div class="row" style="">                                  
                                <div class="col-lg-12">
                                    <br/>
                                    <strong>Nombre de Archivo:</strong> <?php echo $value[2]; ?><br/>
                                    <strong>Descripcion:</strong> <?php echo $value[3]; ?><br/>
                                     <?php if ($tipo == 1) { ?>
                                    <a class="btn btn-success btn-sm" target="_blank" href="archivos/reptecnico/<?php echo trim($value[2]); ?>"><img height="15px" src="img/iconos/download-icon.png" /> Descargar</a>
                                    <?php } else { ?>
                                    <a class="btn btn-success btn-sm" target="_blank" href="archivos/repcomercial/<?php echo trim($value[2]); ?>"><img height="15px" src="img/iconos/download-icon.png" /> Descargar</a>
                                    <?php } ?>
                                </div>                                
                            </div>                            
                        <?php } ?>
                        <center> 
                            <BR/>
                            <?php if ($tipo == 1) { ?>
                                <a onclick="cargar('#principal', '_reptecnicov2.php')" class="btn btn-danger" href="#">Volver</a>
                            <?php } else { ?>
                                <a onclick="cargar('#principal', '_repcomercialv2.php')" class="btn btn-danger" href="#">Volver</a>
                            <?php } ?>

                        </center>        
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
