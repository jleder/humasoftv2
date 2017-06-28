<?php

/* 
 * Proyecto Humasoft.
 * Desarrollado por Juan Leder
 */
require_once '../controller/C_Viaticos.php';
$empleados = new Empleado();
$viaticos = new Viatico();
$empleados->codpersona = $_SESSION['codpersona'];
$listaEmp = $empleados->listarEmpleadoByCod();

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />                            
        <script type="text/javascript">           
            function loadCargo() {
                var codpersona = $("#codpersona").val();
                from_2('LoadCargo', codpersona, 'divcargo', '_viatico_ajax.php');
            }

            function Select2Test() {
                $("#periodo_mes").select2();                
            }

            $(document).ready(function () {

                // Load script of Select2 and run this
                LoadSelect2Script(Select2Test);
                WinMove();                
                

                $("#form").submit(function (e) {
                    e.preventDefault();
                    var f = $(this);
                    var formData = new FormData(document.getElementById("form"));

                    $.ajax({
                        url: "../controller/C_Viaticos.php",
                        type: "post",
                        dataType: "html",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false
                    })
                            .done(function (res) {
                                $("#result").html(res);
                            });
                });
            });
        </script>                
    </head>
    <body> 
        <div class="row">
            <div id="breadcrumb" class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="#">Viáticos</a></li>
                    <li><a href="#">Registrar Periodo de Viáticos</a></li>
                </ol>
            </div>
        </div>
        <div class="row">                        
            <div class="col-xs-12 col-sm-12">
                <div class="box">
                    <div class="box-header">
                        <div class="box-name">
                            <i class="fa fa-briefcase"></i>
                            <span>Formulario para Registrar Periodo de Viáticos</span>
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
                    <div class="box-content">
                        <h4 class="page-header">Llenar Datos</h4>
                        <form id="form" name="form" action="#" method="post" enctype="multipart/form-data" class="form-horizontal">

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Persona <span class="obl">(*)</span>:</label>
                                <div class="col-sm-4">
                                    <select id="codpersona"  name="codpersona" onchange="loadCargo()" class="form-control">
                                        <option value="<?php echo $listaEmp[0]; ?>"><?php echo $listaEmp[1].' '.$listaEmp[2];?></option>
                                    </select>
                                </div>                                            
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Periodo <span class="obl">(*)</span>:</label>
                                <div class="col-sm-2">
                                    <select name="periodo_mes" id="periodo_mes">
                                        <option value="0">- Seleccione -</option>
                                        <?php
                                        $meses = $viaticos->cargarMeses();
                                        foreach ($meses as $key => $mes) {
                                            ?>                                
                                            <option value="<?php echo trim($key); ?>"> <?php echo trim($mes); ?></option>
                                        <?php } ?>                                                    
                                    </select>                                                
                                </div>
                                <div class="col-sm-2">
                                    <input type = "number" name = "periodo_ano" placeholder="" value = "<?php echo date("Y"); ?>" class="form-control" id="periodo_ano" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Cargo:</label>
                                <div class="col-sm-2" id="divcargo">
                                    <input type = "text" name = "cargo" placeholder="Escribir Cargo" value = "<?php echo $listaEmp[15];?>" class="form-control" id="cargo" />
                                </div>
                                <label class="col-sm-2 control-label">Saldo Anterior:</label>
                                <div class="col-sm-2">
                                    <input type = "number" name = "saldo" placeholder="" value = "0" class="form-control" id="saldo" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12" style="text-align: center;">
                                    <input type="submit" value="Guardar" class="btn btn-success" />
                                    <a href="#" onclick="cargar('#principal', '_viaticos.php')" class="btn btn-danger">Regresar</a>
                                    <input type="hidden" id="accion" name="accion" value="RegViatico" />                    
                                </div>
                            </div>

                        </form>
                        <div class="row">
                            <div class="col-sm-12" id="result">                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>                
    </body>
</html>
