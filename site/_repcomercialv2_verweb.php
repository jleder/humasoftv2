<?php
session_start();
include '../controller/C_Reportes.php';
//
$obj = new C_Reportes();
$id = $_GET['cod'];
$obj->__set('codrep', $id);
//$result = $obj->visto();

$reporte = $obj->listarRepTecnicoxCod();

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
    if ($resultado == ':') {
        $resultado = '';
    }
    return $resultado;
}

//
$horaingreso = arreglarHora($reporte[9], $reporte[10]);
$horasalida = arreglarHora($reporte[11], $reporte[12]);
$horaproxvis = arreglarHora($reporte[14], $reporte[15]);

//SOLUCION A FECHA NULA
$fechaprox = '';
if (!empty(trim($reporte[13]))) {
    $fechaprox = date("d/m/Y", strtotime($reporte[13]));
}
if ($horaproxvis == '00:00' || empty(trim($horaproxvis))) {
    $horaproxvis = '';
}
?>

<head>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">                    
    <link rel="stylesheet" href="css/layout_html5.css" type="text/css" media="all" />      
    <script type="text/javascript" src="js/jquery-3.1.0.min.js"></script>
            <!--<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>-->                        
    <script type="text/javascript" src="js/fAjax.js"></script>     
    <script type="text/javascript" src="js/bootstrap.min.js"></script>     
    <script type="text/javascript" src="js/jquery-ui.js"></script>
    <script type="text/javascript" src="js/js_inscoltec.js"></script>            

    <script type="text/javascript">


        $(document).ready(function () {
            $("#form_mail").submit(function () {
                $(this).serialize();
                //alert(cadena);
                //return false;
                $.post("../controller/C_Reportes.php", $(this).serialize(), function (data) {
                    //alert('datosenviados');
                    $("#resultados").html(data); //data is everything you 'echo' on php side
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
        .preg td{ text-align: justify; background: #cccccc; padding: 4px; font-size: small;  }  .img { width: 200mm; height: 100px;} .result td { font-weight: bold; font-size: 11px; padding-left: 5px; } .titulo td{font-size: 9px; padding-left: 5px;} 
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
<div class="container" id="resultados">

    <div class="row">
        <center>
            <div class="margen" style="font-size: 9px;">
                <table style="width: 190mm;">          
                    <tbody>
                        <tr>
                            <td style="width: 190mm; text-align: center;"><img class="img" src="../site/img/logo_reptecnico.JPG" /></td>                    
                        </tr>
                        <tr style="">
                            <td style="width: 190mm;"><h4 style="text-align: center">
                                    <?php if ($reporte[21] == 1) $titulo = 'REPORTE VISITA COMERCIAL'; ?>
                                    <?php if ($reporte[21] == 2) $titulo = 'REPORTE LLAMADA COMERCIAL'; ?>
                                    <?php if ($reporte[21] == 3) $titulo = 'REPORTE VISITA COMERCIAL NO ATENDIDA'; ?>
                                    <?php
                                    if ($reporte[21] == 4)
                                        $titulo = 'REPORTE LLAMADA COMERCIAL NO ATENDIDA';
                                    echo $titulo;
                                    ?>
                                    <span class="codrep">N° <?php echo $reporte[0]; ?></span></h4></td>                                                           
                        </tr>
                    </tbody>
                </table>          
                <table style="width: 190mm; background: #ccffcc; padding: 5px" >
                    <tbody>                                
                        <tr class="titulo">
                            <td style="width: 60mm;"><br/>Empresa:</td>
                            <td style="width: 60mm;"><br/>Fundo:</td>
                            <td style="width: 70mm;" colspan="2"><br/>Contacto:</td>
                        </tr>
                        <tr class="result">
                            <td>
                                <strong><?php echo $reporte[2]; ?></strong>
                            </td>
                            <td><?php echo $reporte[4]; ?></td>
                            <td colspan="2"><?php echo $reporte[7]; ?></td>                    
                        </tr>                        
                        <tr class="titulo">
                            <td style="width: 60mm;"><br/>Zona:</td>
                            <td style="width: 60mm;"><br/>Cultivo:</td>
                            <td style="width: 70mm;" colspan="2"><br/></td>
                        </tr>
                        <tr class="result">
                            <td>
                                <?php echo $reporte[22]; ?>
                            </td>
                            <td><?php echo $reporte[23]; ?></td>
                            <td colspan="2"></td>                    
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
                    </tbody>
                </table>
                <br/>
                <?php
                $rptaHuma = $obj->obtRespuestasHumarepTecnico();
                $nrptaHuma = count($rptaHuma);
                ?>
                <!--Aqui va el codigo del lote-->        
                <table style="width: 190mm;">               
                    <tbody>
                        <tr>
                            <td style="background-color: #66ccff; text-align: center; width: 190mm;" colspan="5"><h5>DETALLES DE LA VISITA</h5></td>
                        </tr>                                    
                        <tr class="">
                            <td colspan="5"></td>
                        </tr>
                        <tr class="preg">
                            <td style="width: 190mm;"> Visita Anterior </td>
                        </tr>
                        <tr>
                            <td style="width: 190mm; font-size: small;">
                                <?php
                                if ($nrptaHuma > 0) {
                                    echo $rptaHuma[0][6];
                                }
                                ?><br/><br/>
                            </td>                            
                        </tr>
                        <tr class="preg">
                            <td style="width: 190mm; "> Temas tratados en esta visita/llamada </td>
                        </tr>
                        <tr>
                            <td style="width: 190mm; font-size: small;">
                                <?php
                                if ($nrptaHuma > 0) {
                                    echo $rptaHuma[1][6];
                                }
                                ?><br/><br/>
                            </td>
                        </tr>
                        <tr class="preg">
                            <td style="width: 190mm;"> Notas de esta visita (Notas de fotos) o posibles pedidos </td>
                        </tr>
                        <tr>
                            <td style="width: 190mm; font-size: small;">
                                <?php
                                if ($nrptaHuma > 0) {
                                    echo $rptaHuma[2][6];
                                }
                                ?><br/><br/>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br/>
                <table style="width: 190mm; padding: 5px; font-size: small">            
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
                            <td style="text-align: center;"><br/><br/><br/><strong><?php echo $reporte[7]; ?></strong></td>                    
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
                </p>
            </div>
        </center>
    </div>
    <div class="row">    
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            <hr/>
            <br/>            
            <form id="form_mail" action="#" name="form_mail" method="POST">
                <div class="panel-info" style="background: whitesmoke">
                    <div class="panel-heading">
                        Enviar PDF Adjunto
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-3">Tu Nombre: </div>
                            <div class="col-lg-9"><input type="text" class="form-control" name="nombre" id="nombre" value="" placeholder="Anonimo" /></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">Tu Correo: </div>
                            <div class="col-lg-9"><input type="email" class="form-control" name="de" id="de" value="" placeholder="tucorreo@ejemplo.com" /></div>
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
        </div>    
        <div class="col-lg-3"></div>
    </div>
</div>
