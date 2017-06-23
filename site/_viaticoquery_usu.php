<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../controller/C_Viaticos.php';
$viaticos = new Viatico();
$ubicacion = new Ubicacion();
$empleados = new Empleado();

$viaticos->codpersona = $_SESSION['codpersona'];
$empleados->codpersona = $_SESSION['codpersona'];
$listaEmp = $empleados->listarEmpleadoByCod();
$listaPeriodos = $viaticos->listarPerViaticoByCodPersona();

$listaTipoViaticos = $viaticos->listarTipoViaticoAll();
$listaZona = $ubicacion->getSubZonaByZona();
$listaDist = $ubicacion->getDepaProvDist();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />                            
        <script type="text/javascript">
            function loadPeriodosByCodPersona() {

                var codpersona = $("#codpersona").val();
                from_2('LoadPeriodoByCodPersona', codpersona, 'divperiodos', '_viatico_ajax.php');
            }

            function consultarViatico() {
                var codpersona = $("#codpersona").val();
                var codviatico = $("#codviatico").val();
                from_2(codpersona, codviatico, 'divviatico_res', '_viaticoquery_res.php');
            }
            
            function consultarViatico() {
                var codpersona = $("#codpersona").val();
                var codviatico = $("#codviatico").val();
                from_2(codpersona, codviatico, 'divviatico_res', '_viaticoquery_res.php');
            }

            function Select2Test() {                
                $("#codviatico").select2();
            }

            $(document).ready(function () {

                // Load script of Select2 and run this
                LoadSelect2Script(Select2Test);
                WinMove();
            });
        </script>                
    </head>
    <body> 
        <div class="row">
            <div id="breadcrumb" class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="#">Viáticos</a></li>
                    <li><a href="#">Consulta de Viáticos</a></li>
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
                    <div class="box-content form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Persona <span class="obl">(*)</span>:</label>
                            <div class="col-sm-3">
                                <select id="codpersona"  name="codpersona" class="form-control">
                                    <option value="<?php echo $listaEmp[0]; ?>"><?php echo $listaEmp[1] . ' ' . $listaEmp[2]; ?></option>                                    
                                </select>                                             
                            </div>                                
                            <label class="col-sm-1 control-label">Periodo <span class="obl">(*)</span>:</label>
                            <div class="col-sm-2" id="divperiodos">
                                <select name="codviatico" id="codviatico">
                                    <option value="0">- Seleccione -</option>
                                    <?php
                                    foreach ($listaPeriodos as $valor) {
                                        ?>                                
                                        <option value="<?php echo trim($valor[0]); ?>"> <?php echo trim($valor[1] . '/' . $valor[2]); ?></option>
                                    <?php } ?>                                                    
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <a class="btn btn-primary" href="#" onclick="consultarViatico()">Consultar</a>                                
                            </div>
                        </div>
                        <hr/>
                        <div class="form-group">
                            <div class="col-xs-12" id="divviatico_res"></div>
                        </div>                    
                    </div>


                </div>
            </div>
        </div>                
    </body>
</html>