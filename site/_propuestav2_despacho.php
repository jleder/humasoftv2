<?php
header("Cache-Control: no-cache, must-revalidate");
$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["conectado"])) {
    if ($_SESSION["conectado"] == 'SI') {
        include_once '../controller/C_Propuestas.php';
        $desp = new C_Despacho();

        $codprop = trim($_GET['codprop']);
        $desp->__set('codprop', $codprop);
        ?>
        <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="utf-8">
                <title>Humasoft</title>
                <meta name="description" content="description">
                <meta name="author" content="Juan">
                <?php include 'head.php'; ?>   
            </head>
            <body> 
                <?php include 'header.php'; ?>
                <!--End Header-->

                <!--Start Container-->
                <div id="main" class="container-fluid">
                    <div class="row">
                        <div id="sidebar-left" class="col-xs-2 col-sm-2">
                            <?php include 'menu.php'; ?>
                        </div>
                        <!--Start Content-->                        
                        <div id="content" class="col-xs-12 col-sm-10">                            
                            <div class="row">
                                <div id="breadcrumb" class="col-md-12">
                                    <ol class="breadcrumb">
                                        <li><a href="Dashboard.php">Dashboard</a></li>
                                        <li><a href="_propuestav2.php">Propuestas</a></li>
                                        <li><a href="#">Ver Despachos</a></li>
                                    </ol>
                                </div>
                            </div>

                            <div class="row">                        
                                <div class="col-xs-12 col-sm-12">
                                    <div class="box">
                                        <div class="box-header">
                                            <div class="box-name">
                                                <i class="fa fa-briefcase"></i>
                                                <span>Despacho por Propuesta </span>
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
                                            <h5 class="page-header">Datos de Viático</h5>

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
                                                                    <td style="text-align:center;"><?php echo $valor['moneda'] . $valor['montodesp'] ?></td>
                                                                    <td style="text-align:center;"><?php echo $valor['moneda'] . $valor['saldo'] ?></td>                                
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

                                        </div>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                        <!--End Content-->
                    </div>
                </div>
                <!--End Container-->
                <?php include 'script.php'; ?>

                <script type="text/javascript">
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
            </body>
        </html>
        <?php
    }
} else {
    header("Location:recursos/logout.php");
}
?>