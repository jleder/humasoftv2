<?php
@session_start();
include_once '../controller/C_Solicitud.php';
$desp = new C_Despacho();

$codprop = trim($_GET['codprop']);
$desp->__set('codprop', $codprop);
?>
<html>
    <head>  
        <meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8" />
        <link rel="stylesheet" href="css/layout_html5.css" type="text/css" media="all" />                                                          
        <!--calendario-->        
        <script type="text/javascript" src="js/js_inscoltec.js"></script>        
        <style type="text/css">            
            @import "util/media/themes/smoothness/jquery-ui-1.8.4.custom.css";            
        </style>
        <!--FIN DE CALENDARIO-->
        <script>
            $(document).ready(function () {
                
                $("#despacho_reg").submit(function (e) {
                    e.preventDefault();
                    var f = $(this);
                    var formData = new FormData(document.getElementById("despacho_reg"));
                    formData.append("accion", 'RegDespacho');

                    $.ajax({
                        url: "../controller/C_Solicitud.php",
                        type: "post",
                        dataType: "html",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false
                    })
                            .done(function (res) {
                                $("#resultado").html(res);
                            });
                });               
            });
        </script>
    </head>
    <body>   

        <div class="row" style="">
            <div class="col-lg-12">
                <h3>Lista de Despachos para esta Propuesta</h3>
            </div>
        </div>                
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <div id="resultado"></div>
            </div>
        </div>
        <br/>
        <div class="row" style="">            
            <div class="col-lg-4" id="divdespacho">                
                <form id="despacho_reg" name="despacho_reg" action="#" method="POST" enctype="multipart/form-data">                    
                    <div class="panel panel-info">
                        <div class="panel-heading">Despacho</div>
                        <div class="panel-body" style="font-size: 0.8em;">                                            
                            <div class="row">                                
                                <div class="col-lg-6">Prioridad
                                    <select name="prioridad" id="prioridad" class="form-control input-sm">                                        
                                        <option value="NORMAL">NORMAL (72hrs)</option>
                                        <option value="URGENTE">URGENTE (48hrs)</option>
                                        <option value="MUY URGENTE">MUY URGENTE</option>
                                    </select> 
                                </div>
                                <div class="col-lg-6">Entrega Prevista
                                    <input type="text" name="fecprev" id="cal" class="form-control input-sm" value="<?php echo date("Y/m/d"); ?>" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">Monto Despachado
                                    <input type="number" step="any" name="montodesp" class="form-control input-sm" value="0" />
                                </div>                                
                                <div class="col-lg-4">Saldo
                                    <input type="number" step="any" name="saldo" class="form-control input-sm" value="0" />
                                </div>                                
                                <div class="col-lg-4">Moneda
                                    <select name="moneda" id="moneda" class="form-control input-sm">
                                        <option value="$">$. DOLAR</option>
                                        <option value="S/.">S/. SOLES</option>
                                    </select>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-lg-12">Descripción:
                                    <input type="text" maxlength="90" name="descripcion" class="form-control input-sm" value="" required="" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">Observación:
                                    <textarea class="form-control" name="obs" rows="4" cols="5"></textarea>
                                </div>
                            </div> 
                            <br/>
                            <div class="row" style="text-align: center">
                                <input type="submit" value="Guardar" class="btn btn-success" />
                                <input type="hidden" name="codprop" id="codprop" value="<?php echo $codprop; ?>" />
                            </div>
                        </div>
                    </div>            
                </form>                                            
            </div>
            <div class="col-lg-8">                
                <table class="table table-striped" style=" padding: 5px; font-size: 10px;">
                    <thead>
                        <tr style="color: white; background-color: #1da8f4;">
                            <th>Fecha Registro</th>
                            <th>Código Propuesta</th>
                            <th>Despacho</th>
                            <th>Entrega Prevista</th>
                            <th>Monto Despachado</th>
                            <th>Saldo</th>                            
                            <th>Estado</th>
                            <th></th>                                                
                        </tr>                    
                    </thead>
                    <tbody>
                        <?php
                        $lista = $desp->despachosByCodprop();
                        foreach ($lista as $valor) {
                            ?>                        
                            <tr>
                                <td><?php echo date("d/m/Y", strtotime($valor['fecreg'])); ?></td>
                                <td><?php echo $valor['codprop'] ?></td>                                
                                <td><?php echo $valor['descripcion'] ?></td>
                                <td><strong><?php echo date("d/m/Y", strtotime($valor['fecprev'])); ?></strong></td>
                                <td style="text-align:center;"><?php echo $valor['moneda'].$valor['montodesp'] ?></td>
                                <td style="text-align:center;"><?php echo $valor['moneda'].$valor['saldo'] ?></td>                                
                                <td></td>
                                <td>
                                    <a class="btn btn-default" href="#" onclick="javascript:cargar('#divdespacho', '_propuestav2_despacho_edit.php?coddesp=<?php echo trim($valor['coddesp']); ?>')" title="Modificar Estado Comercial"><img src="img/iconos/edit.png" height="15" /></a>
                                    <a class="btn btn-default" onClick="return confirmSubmit()" href="javascript:cargar('#resultado', '_propuestav2_despacho_elim.php?cod1=<?php echo trim($valor['coddesp']); ?>&cod2=0&tipo=1')" title="Eliminar Despacho"><img src="img/iconos/trash.png" height="15" /></a>
                                </td>                                    
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                <a class="btn btn-info btn-sm" onclick="cargar('#bodytable', '_propuestav2_despacho.php?codprop=<?php echo trim($codprop); ?>')" >Actualizar Tabla</a>
            </div>
        </div>
    </body>
</html>

