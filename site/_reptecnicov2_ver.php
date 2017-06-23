<?php
session_start();
include '../controller/C_Reportes.php';
//

$obj = new C_Reportes();
$obj->insertarAccion('Hizo clic en el boton Ver Rep. Técnico');
$id = $_GET['cod'];
$obj->__set('codrep', $id);
//$result = $obj->visto();

$reporte = $obj->listarRepTecnicoxCod();

$huma = FALSE;
$test = FALSE;

if ($reporte[19] != '') {
    $huma = TRUE;
}
if ($reporte[20] != '') {
    $test = TRUE;
}
$obj->__set('codcliente', trim($reporte[1]));
$usuarios = $obj->getContactosByCliente();

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
    return $resultado;
}

//
$horaingreso = arreglarHora($reporte[9], $reporte[10]);
$horasalida = arreglarHora($reporte[11], $reporte[12]);
$horaproxvis = arreglarHora($reporte[14], $reporte[15]);

//SOLUCION A FECHA NULA
$fechaprox = '';
if ($reporte[13] != null) {
    $fechaprox = date("Y/m/d", strtotime($reporte[13]));
}
if ($horaproxvis == '00:00') {
    $horaproxvis = '';
}

$titulo = $obj->getTituloVerRepTecnico($reporte[21]);
?>

<head>
    <script type="text/javascript">


        $(document).ready(function () {
            $("#form_mail").submit(function () {
                $(this).serialize();
                //alert(cadena);
                //return false;
                $.post("../controller/C_Reportes.php", $(this).serialize(), function (data) {
                    //alert('datosenviados');
                    $("#respuesta").html(data); //data is everything you 'echo' on php side
                });
                return false;
            });
        });



//        $(document).on("click", ".open-Modal", function () {
//            var myDNI = $(this).data('id');
//            $(".modal-body #mailpara").val(myDNI);
//        });

//        function loadCorreos() {
//            var para = document.getElementById("mailpara").val();
//            para.value = 'juanleder@gmail.com';
//        }

        function otroCorreo() {
            var otro = document.getElementById('otro');
            var div = document.getElementById('divcorreo');
            var para = document.getElementById('mailpara');
            if (otro.checked) {
                div.style.display = "block";
                para.required;
            } else {
                div.style.display = "none";
                para.value = '';
            }
        }
    </script>
    <style>
        .margen { margin-left: 3mm;}
        .preg td{ text-align: justify; background: #cccccc; padding: 4px; font-size: small; }  .img { width: 200mm; height: 100px;} .result td { font-weight: bold; font-size: 11px; padding-left: 5px; } .titulo td{font-size: 9px; padding-left: 5px;}
        .codrep { color: #ff0000; }

        .table.tableau { text-align: left; background-color: #ccccff; border: solid 1px #cccccc; }
        .table.tableau td { width: 15mm; font-family: courier; }
        .table.tableau th { width: 15mm; font-family: courier; }

        .table.rep { vertical-align: top; padding: 3px;  }
        .table.rep td { width: 95mm;  border: solid 1px #cccccc; text-align: justify; }
        .table.rep th { width: 95mm;  border: solid 1px #cccccc; text-align: center; background: #ccccff; }

        .table.cabecera { vertical-align: top; }
        .table.cabecera td { width: 95mm;  border: solid 1px #cccccc; text-align: justify; }
        .table.cabecera th { width: 95mm;  border: solid 1px #cccccc; text-align: center; background: #ccccff; }

        .blue {background-color: #66ccff; text-align: center; padding: 3px; width: 190mm; }
    </style>
</head>
<div id="respuesta" style="background-color: white;">
    <center>
        <div class="margen" style="font-size: 9px;">
            <table style="width: 190mm;">          
                <tbody>
                    <tr>
                        <td style="width: 190mm; text-align: center;"><img class="img" src="../site/img/logo_reptecnico.JPG" /></td>                    
                    </tr>
                    <tr style="">
                        <td style="width: 190mm;"><h4 style="text-align: center"><?php echo $titulo; ?> <span class="codrep">N° <?php echo $reporte[0]; ?></span></h4></td>                                                           
                    </tr>
                </tbody>
            </table>          
            <table style="width: 190mm; background: #ccffcc;" >
                <tbody>                                
                    <tr class="titulo">
                        <td style="width: 60mm;"><br/>Empresa:</td>
                        <td style="width: 60mm;"><br/>Fundo:</td>
                        <td style="width: 70mm;" colspan="2"><br/>Encargado:</td>
                    </tr>
                    <tr class="result">
                        <td>
                            <strong><?php echo $reporte[2]; ?></strong>
                        </td>
                        <td><?php echo $reporte[4]; ?></td>
                        <td colspan="2"><?php echo $reporte[7]; ?></td>                    
                    </tr>                        
                    <tr class="titulo">
                        <td><br/>Asesor:</td>
                        <td><br/>Fecha Visita:</td>
                        <td><br/>Hora Ingreso:</td>
                        <td><br/>Hora Salida:</td>
                    </tr>
                    <tr class="result">
                        <td><?php echo $reporte[6]; ?></td>
                        <td><?php echo date("d/m/Y", strtotime($reporte[8])); ?></td>
                        <td><?php echo $horaingreso ?></td>
                        <td><?php echo $horasalida; ?></td>
                    </tr>

<!--<tr>
    <td colspan="7"><hr/></td>
</tr>-->
                </tbody>
            </table>
            <br/>
            <?php
            if ($reporte[21] == 3 || $reporte[21] == 4) {
                ?>

                <table style="width: 190mm; font-size: small;">               
                    <tr>
                        <td>
                            Observaciones: <br/>
                            <?php
                            $obs = $obj->getObs();
                            echo $obs[6];
                            ?>
                        </td>
                    </tr>
                </table>
                <?php
            }

            if ($huma == TRUE) {
                $obj->__set('codlote', $reporte[19]);
                $lshuma = $obj->getLoteByID2();
                $rptaHuma = $obj->obtRespuestasHumarepTecnico();
                ?>
                <!--Aqui va el codigo del lote-->        
                <table style="width: 190mm;">               
                    <tbody>
                        <tr>
                            <td style="background-color: #66ccff; text-align: center; width: 190mm;" colspan="5"><h5>LOTE HUMAGRO</h5></td>
                        </tr>            
                        <tr class="titulo">
                            <td style="width: 38mm;" colspan="1"><br/>Nombre de Lote</td>            
                            <td style="width: 38mm;" colspan="1"><br/>Ha. Trabajada</td>
                            <td style="width: 38mm;" colspan="1"><br/>Tipo de Cultivo</td>
                            <td style="width: 38mm;" colspan="1"><br/>Edad de Cultivo</td>                                                                                                          
                            <td style="width: 38mm;" colspan="1"><br/>Variedad</td>                                
                        </tr>
                        <tr class="result">
                            <td colspan="1"><strong><?php echo $lshuma[3]; ?></strong></td>
                            <td colspan="1"><strong><?php echo $lshuma[5]; ?></strong></td>                                           
                            <td colspan="1"><strong><?php echo $lshuma[6]; ?></strong></td>                    
                            <td><strong><?php echo $lshuma[11]; ?></strong></td>
                            <td><strong><?php echo $lshuma[8]; ?></strong></td>

                        </tr>
                        <tr class="titulo">
                            <td colspan="1"><br/>Patron</td>
                            <td colspan="1"><br/>Etapa Fenologica</td>                                                    
                            <td colspan="1"><br/>Tipo de Suelo</td>                    
                            <td colspan="1"><br/>Tipo de Riego</td>
                            <td><br/>Densidad por Ha.</td>
                        </tr>
                        <tr class="result">
                            <td colspan="1" style=""><strong><?php echo $lshuma[9]; ?></strong></td>
                            <td colspan="1" style=""><strong><?php echo $lshuma[12]; ?></strong></td>                                        
                            <td colspan="1"><strong><?php echo $lshuma[14]; ?></strong></td>                    
                            <td colspan="1"><strong><?php echo $lshuma[13]; ?></strong></td>
                            <td><strong><?php echo $lshuma[10]; ?></strong></td>                
                        </tr>    
                        <tr class="">
                            <td colspan="5"><br/></td>
                        </tr>
                        <tr class="preg">
                            <td style="width: 190mm;" colspan="5">Antecedentes a la visita (Temas por ver, resolver y/o planificar) </td>
                        </tr>
                        <tr>
                            <td style="width: 190mm; font-size: small;" colspan="5">
                                <?php echo $rptaHuma[0][6]; ?><br/><br/>
                            </td>                            
                        </tr>
                        <tr class="preg">
                            <td style="width: 190mm;" colspan="5">Visita de Rutina - Seguimiento (Evaluación)</td>
                        </tr>
                        <tr>
                            <td style="width: 190mm; font-size: small;" colspan="5">
                                <?php echo $rptaHuma[1][6]; ?><br/><br/>
                            </td>
                        </tr>
                        <tr class="preg">
                            <td style="width: 190mm;" colspan="5">Recomendaciones / Notas </td>
                        </tr>
                        <tr>
                            <td style="width: 190mm; font-size: small;" colspan="5">
                                <?php echo $rptaHuma[2][6]; ?><br/><br/>
                            </td>
                        </tr>
                    </tbody>
                </table>
            <?php } ?>
            <br/>
            <?php
            if ($test == TRUE) {
                $obj->__set('codlote', $reporte[20]);
                $lstest = $obj->getLoteByID2();
                $rptaTest = $obj->obtRespuestasTestrepTecnico();
                ?>
                <!--Aqui va el codigo del lote-->

                <table style="width: 190mm; font-size: small;">               
                    <tbody>
                        <tr>
                            <td style="background-color: #ffcccc; height: 20px; width: 190mm;" colspan="5"><h5 style="text-align: center">LOTE TESTIGO</h5></td>
                        </tr>
                        <tr class="titulo">
                            <td style="width: 38mm;" colspan="1"><br/>Nombre de Lote</td>            
                            <td style="width: 38mm;" colspan="1"><br/>Ha. Trabajada</td>
                            <td style="width: 38mm;" colspan="1"><br/>Tipo de Cultivo</td>
                            <td style="width: 38mm;" colspan="1"><br/>Edad de Cultivo</td>                                                                                                          
                            <td style="width: 38mm;" colspan="1"><br/>Variedad</td>                                
                        </tr>
                        <tr class="result">
                            <td colspan="1"><strong><?php echo $lstest[3]; ?></strong></td>
                            <td colspan="1"><strong><?php echo $lstest[5]; ?></strong></td>                                           
                            <td colspan="1"><strong><?php echo $lstest[6]; ?></strong></td>                    
                            <td><strong><?php echo $lstest[11]; ?></strong></td>
                            <td><strong><?php echo $lstest[8]; ?></strong></td>

                        </tr>
                        <tr class="titulo">
                            <td colspan="1"><br/>Patron</td>
                            <td colspan="1"><br/>Etapa Fenologica</td>                                                    
                            <td colspan="1"><br/>Tipo de Suelo</td>                    
                            <td colspan="1"><br/>Tipo de Riego</td>
                            <td><br/>Densidad por Ha.</td>
                        </tr>
                        <tr class="result">
                            <td colspan="1" style=""><strong><?php echo $lstest[9]; ?></strong></td>
                            <td colspan="1" style=""><strong><?php echo $lstest[12]; ?></strong></td>                                        
                            <td colspan="1"><strong><?php echo $lstest[14]; ?></strong></td>                    
                            <td colspan="1"><strong><?php echo $lstest[13]; ?></strong></td>
                            <td><strong><?php echo $lstest[10]; ?></strong></td>                
                        </tr>
                        <tr class="">
                            <td colspan="5"><br/></td>
                        </tr>
                        <tr class="preg">
                            <td style="width: 190mm;" colspan="5">Antecedentes a la visita (Temas por ver, resolver y/o planificar) </td>
                        </tr>
                        <tr>
                            <td style="width: 190mm;" colspan="5">
                                <?php echo $rptaTest[0][6]; ?><br/><br/>
                            </td>                            
                        </tr>
                        <tr class="preg">
                            <td style="width: 190mm;" colspan="5">Visita de Rutina - Seguimiento (Evaluación)</td>
                        </tr>
                        <tr>
                            <td style="width: 190mm;" colspan="5">
                                <?php echo $rptaTest[1][6]; ?><br/><br/>
                            </td>
                        </tr>
                        <tr class="preg">
                            <td style="width: 190mm;" colspan="5">Recomendaciones / Notas </td>
                        </tr>
                        <tr>
                            <td style="width: 190mm;" colspan="5">
                                <?php echo $rptaTest[2][6]; ?><br/><br/>
                            </td>
                        </tr>

                    </tbody>
                </table>
            <?php } ?>
            <br/>


            <table style="width: 190mm; padding: 5px; font-size: small;">            
                <tbody> 
                    <tr>
                        <td style="width: 190mm;" colspan="2"><br/><strong>Notas al cliente:</strong><br/> <?php echo $reporte[17]; ?></td>                    
                    </tr>                
                    <tr>
                        <td style="width: 95mm;"><br/><strong>Próxima Visita:</strong></td>                    
                        <td style="width: 95mm;"><br/><strong>Motivo:</strong></td>
                    </tr>
                    <tr class="">
                        <td style="width: 95mm;"><?php echo $fechaprox . ' - ' . $horaproxvis; ?></td>                    
                        <td style="width: 95mm;"><?php echo $reporte[16]; ?></td>
                    </tr>
                    <tr>
                        <td style="text-align: center;"><br/><br/><br/><strong><?php echo $reporte[18]; ?></strong></td>                    
                        <td style="text-align: center;"><br/><br/><br/><strong><?php echo $reporte[6]; ?></strong></td>
                    </tr>
                    <tr>
                        <td style="text-align: center;"> FIRMADO POR </td>                    
                        <td style="text-align: center;">ASESOR HUMAGRO</td>
                    </tr>

                </tbody>
            </table>
            <p style="text-align: center;">
                <br/><br/><br/>
                <a class="btn btn-primary" href="#" onclick="cargar('#principal', '_reptecnicov2_reg.php')">Crear Visita Técnica</a>             
                <a class="btn btn-danger" href="#" onclick="cargar('#principal', '_reptecnicov2.php')"> Volver </a>            
            </p>
        </div>





    </center>
    <div class="row">    
        <div class="col-lg-3"></div>
        <div class="col-lg-6" id="">
            <hr/>
            <br/>
            <?php if ($_SESSION['usuario'] == 'ADM' || $_SESSION['usuario'] == 'JLP') { ?>
                <form id="form_mail" action="#" name="form_mail" method="POST">
                    <div class="panel-info" style="background: whitesmoke">
                        <div class="panel-heading">
                            Enviar PDF Adjunto
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-3">Tu Nombre: </div>
                                <div class="col-lg-9"><input type="text" class="form-control" name="nombre" id="nombre" value="" placeholder="Anonimo" /></div>
                                <div class="col-lg-3">Tu Correo: </div>
                                <div class="col-lg-9"><input type="text" class="form-control" name="de" id="de" value="" placeholder="tucorreo@ejemplo.com" /></div>
                                <div class="col-lg-3">Para: </div>
                                <div class="col-lg-9"> 
                                    <?php
                                    foreach ($usuarios as $correo) {
                                        if (!empty(trim(($correo[7])))) {
                                            ?>
                                            <input type="checkbox" onclick="" name="correos[]" value="<?php echo $correo[7]; ?>" /> <?php echo $correo[7] . ' ' . $correo[1]; ?><br/>        
                                            <?php
                                        }
                                    }
                                    ?>                                
                                    <input type="checkbox" name="otro" id="otro" onclick="otroCorreo()" value="ON" /> Otro<br/>
                                    <div id="divcorreo" hidden="">
                                        <input type="text" id="mailpara" class="form-control"  name="mailpara" value="" placeholder="usuario@ejemplo.com" />
                                    </div>
                                </div>
                                <!--Ventana Modal-->
                                <!--                            <div class="col-lg-2"><button class="btn btn-primary" data-toggle="modal" data-target="#miventana"> Buscar </button> </div>
                                
                                                            <div class="modal fade" id="miventana" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                            <h4>Seleccione Correos</h4>
                                
                                                                        </div>
                                                                        <div class="modal-body">
                                
                                                                            <input type="text" class="form-control" name="" /> <br/>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-default" data-dismiss="modal"> Cerrar</button>
                                                                            <button type="button" class="btn btn-primary" onclick="loadCorreos()" > Aceptar</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                
                                                            </div>-->


                            </div>
                            <div class="row">
                                <div class="col-lg-3">Asunto: </div>
                                <div class="col-lg-9"><input placeholder="Asunto" type="text" id="mailasunto" class="form-control" name="mailasunto" value="" /></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">Mensaje: </div>
                                <div class="col-lg-9">                            
                                    <textarea placeholder="Escriba un Mensaje" class="form-control" id="mailmsj" name="mailmsj" rows="4" cols="20"></textarea>
                                </div>
                            </div>                        
                            <div class="row" style="text-align: center">
                                <br/><br/>
                                <input type="hidden" name="accion" id="accion" value="EnviarPDFaCliente" />
                                <input type="hidden" name="codrep" id="codrep" value="<?php echo trim($id); ?>" />
                                <input class="btn btn-success" type="submit" value=" Enviar " />
                            </div>
                        </div>
                        <div class="panel-footer">
                            Se enviará una copia a tu correo.
                        </div>
                    </div>                                                

                </form>
            <?php } ?>

        </div>    
        <div class="col-lg-3"></div>
    </div>
</div>
