<?php
require_once '../controller/C_Viaticos.php';
$viaticos = new Viatico();
$ubicacion = new Ubicacion();
$empleados = new Empleado();
$listaEmp = $empleados->listarEmpleadoAll();

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

            function Select2Test() {
                $("#codpersona").select2();
                //$("#codviatico").select2();                
                $("#codtipo").select2();
                $("#codzona").select2();
                $("#codlugar").select2();
            }

            function desdePrecioVenta() {
                var pventa = $("#pventa").val();
                var igv = $("#igv").val();
                var valigv = 0;
                var valor = 0;
                valigv = parseFloat(pventa) * (parseFloat(igv) / 100);
                valor = parseFloat(pventa) - parseFloat(valigv);
                $("#valor").val(valor.toFixed(2));
                $("#valigv").val(valigv.toFixed(2));
            }

            function desdePrecioxGalon() {
                var pgalon = $("#pgalon").val();
                var galones = $("#galones").val();
                var pventa = 0;
                pventa = parseFloat(pgalon) * parseFloat(galones);
                $("#pventa").val(pventa.toFixed(2));
                desdePrecioVenta();
            }

            function verificarTipo() {
                var codtipo = $("#codtipo").val();
                if (codtipo === '01') {
                    $("#divcombustible").css("display", "block");
                    $("#combustible").val("t");
                } else {
                    $("#divcombustible").css("display", "none");
                    $("#combustible").val("f");
                }
            }

            $(document).ready(function () {

                LoadSelect2Script(Select2Test);
                WinMove();
                $('#fecha').datepicker({setDate: new Date(), dateFormat: 'dd/mm/yy'});

                $("#form").submit(function (e) {
                    e.preventDefault();
                    var f = $(this);
                    var formData = new FormData(document.getElementById("form"));
                    var zona = $("#codzona option:selected").html();
                    formData.append("zona", zona);

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
                    <li><a href="#">Registrar Detalle de Viáticos</a></li>
                </ol>
            </div>
        </div>
        <div class="row">                        
            <div class="col-xs-12 col-sm-12">
                <div class="box">
                    <div class="box-header">
                        <div class="box-name">
                            <i class="fa fa-briefcase"></i>
                            <span>Formulario para Registrar Detalle de Viáticos</span>
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
                        <form id="form" name="form" action="#" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <h5 class="page-header">Datos de Viático</h5>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Persona <span class="obl">(*)</span>:</label>
                                <div class="col-sm-3">
                                    <select id="codpersona"  name="codpersona" onchange="loadPeriodosByCodPersona()">                                                    
                                        <option value="0">- Seleccione -</option>
                                        <?php foreach ($listaEmp as $valor) { ?>                                
                                            <option value="<?php echo trim($valor[0]); ?>"> <?php echo trim($valor[1] . ' ' . $valor[2]); ?></option>
                                        <?php } ?>
                                    </select>                                             
                                </div>                                
                                <label class="col-sm-2 control-label">Periodo <span class="obl">(*)</span>:</label>
                                <div class="col-sm-3" id="divperiodos">
                                    <select name="codviatico" id="codviatico" class="form-control">
                                        <option value="0">- Seleccione -</option>                                                                                        
                                    </select>                                                
                                </div>
                            </div>
                            <div class="form-group" id="divinfoviatico">                                
                            </div>                            
                            <h5 class="page-header">Detalle de Viático</h5>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Tipo Viatico <span class="obl">(*)</span>:</label>
                                <div class="col-sm-3">                                    
                                    <input type="hidden" name="combustible" id="combustible" value="f" />
                                    <select name="codtipo" id="codtipo" onchange="verificarTipo()">
                                        <option value="0">- Seleccione -</option>
                                        <?php
                                        foreach ($listaTipoViaticos as $tipo) {
                                            ?>                                
                                            <option value="<?php echo trim($tipo[1]); ?>"> <?php echo trim($tipo[2]); ?></option>
                                        <?php } ?>                                                    
                                    </select>  
                                </div>
                                <label class="col-sm-2 control-label">Fecha <span class="obl">(*)</span>:</label>
                                <div class="col-sm-3">
                                    <input type = "text" name = "fecha" placeholder="dd/mm/yyyy" value = "" class="form-control" id="fecha" />
                                </div>
                            </div>                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Tipo Documento <span class="obl">(*)</span>:</label>
                                <div class="col-sm-3">
                                    <input type = "text" name = "doctipo" placeholder="" value = "" class="form-control" id="doctipo" />
                                </div>
                                <label class="col-sm-2 control-label">Nro. Documento <span class="obl">(*)</span>:</label>
                                <div class="col-sm-3">
                                    <input type = "text" name = "docnum" placeholder="" value = "" class="form-control" id="docnum" />
                                </div>
                            </div>
                            <div class="form-group">                            
                                <label class="col-sm-2 control-label">Razon Social:</label>
                                <div class="col-sm-3">
                                    <input type = "text" name = "proveedor" placeholder="" value = "" class="form-control" id="proveedor" />
                                </div>
                                <label class="col-sm-2 control-label">Concepto:</label>
                                <div class="col-sm-3">
                                    <input type = "text" name = "concepto" placeholder="" value = "" class="form-control" id="concepto" />
                                </div>
                            </div>                            
                            <div class="form-group">                            
                                <label class="col-sm-2 control-label">Zona:</label>
                                <div class="col-sm-3">
                                    <select name="codzona" id="codzona">
                                        <option value="0">- Seleccione -</option>
                                        <?php
                                        foreach ($listaZona as $zona) {
                                            ?>                                
                                            <option value="<?php echo trim($zona[0] . '|' . $zona[1]); ?>"> <?php echo trim($zona[2] . ' - ' . $zona[3]); ?></option>
                                        <?php } ?>                                                    
                                    </select>  
                                </div>
                                <label class="col-sm-2 control-label">Distrito:</label>
                                <div class="col-sm-4">
                                    <select name="codlugar" id="codlugar">
                                        <option value="0">- Seleccione -</option>
                                        <?php
                                        foreach ($listaDist as $lugar) {
                                            ?>                                
                                            <option value="<?php echo trim($lugar['codigo']); ?>"> <?php echo trim($lugar['ubicacion']); ?></option>
                                        <?php } ?>                                                    
                                    </select>  
                                </div>
                            </div>
                            <div id="divcombustible" style="display: none;">
                                <h5 class="page-header">Detalles de Combustibles y Lubrificantes</h5>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Vehiculo <span class="obl">(*)</span>:</label>
                                    <div class="col-sm-3">
                                        <input type = "text" name = "vehiculo" placeholder="" value = "" class="form-control" id="vehiculo" />
                                    </div>
                                    <label class="col-sm-2 control-label">Placa <span class="obl">(*)</span>:</label>
                                    <div class="col-sm-3">
                                        <input type = "text" name = "placa" placeholder="" value = "" class="form-control" id="placa" />
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Km Cierre <span class="obl">(*)</span>:</label>
                                    <div class="col-sm-3">
                                        <input type = "text" name = "kmcierre" placeholder="" value = "" class="form-control" id="kmcierre" />
                                    </div>
                                    <label class="col-sm-2 control-label">Km Recorrido <span class="obl">(*)</span>:</label>
                                    <div class="col-sm-3">
                                        <input type = "text" name = "kmrecorrido" placeholder="" value = "" class="form-control" id="kmrecorrido" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Nro Galones <span class="obl">(*)</span>:</label>
                                    <div class="col-sm-3">
                                        <input type = "number" name = "galones" step="any" value = "" class="form-control" id="galones" />
                                    </div>
                                    <label class="col-sm-2 control-label">Precio x Galón <span class="obl">(*)</span>:</label>
                                    <div class="col-sm-3">
                                        <input type = "number" name = "pgalon" step="any" value = "" class="form-control" id="pgalon" onblur="desdePrecioxGalon()" />
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group" style="">
                                <div class="col-sm-5"></div>
                                <label class="col-sm-2 control-label">Valor</label>
                                <div class="col-sm-3">
                                    <input type = "number" name = "valor" step="any" value = "0" class="form-control" id="valor" />
                                </div>                                    
                            </div>
                            <div class="form-group">
                                <div class="col-sm-5"></div>                                
                                <label class="col-sm-2 control-label">IGV</label>
                                <div class="col-sm-1">
                                    <input type = "number" name = "igv" step="any" value = "18" class="form-control" id="igv" />
                                </div>
                                <div class="col-sm-2">
                                    <input type = "number" name = "valigv" step="any" value = "0" class="form-control" id="valigv" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-5"></div>                                
                                <label class="col-sm-2 control-label">Precio Venta</label>                                    
                                <div class="col-sm-3">
                                    <input type = "number" name = "pventa" step="any" value = "0" class="form-control" id="pventa" onblur="desdePrecioVenta()" />
                                </div>                                
                            </div>                            
                            <div class="form-group">
                                <div class="col-sm-12" style="text-align: center;">
                                    <input type="submit" value="Guardar" class="btn btn-success" />
                                    <a href="#" onclick="cargar('#principal', '_viaticos.php')" class="btn btn-danger">Regresar</a>
                                    <input type="hidden" id="accion" name="accion" value="RegDetalleViatico" />
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