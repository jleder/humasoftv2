<?php
header("Cache-Control: no-cache, must-revalidate");
$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["conectado"])) {
    if ($_SESSION["conectado"] == 'SI') {

        require_once '../controller/C_Viaticos.php';
        $viaticos = new Viatico();
        $ubicacion = new Ubicacion();
        $empleados = new Empleado();        
        $listaEmp = $empleados->listarEmpleadoAll();

        $listaTipoViaticos = $viaticos->listarTipoViaticoAll();
        $listaZona = $ubicacion->getSubZonaByZona();
        $listaDist = $ubicacion->getDepaProvDist();
        //$numaleat = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 20);
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
                                        <li><a href="dashboard.php">Dashboard</a></li>
                                        <li><a href="#">Viáticos</a></li>
                                        <li><a href="#">Registrar Viáticos</a></li>
                                    </ol>
                                </div>
                            </div>

                            <div class="row">                        
                                <div class="col-xs-12 col-sm-12">
                                    <div class="box">
                                        <div class="box-header">
                                            <div class="box-name">
                                                <i class="fa fa-briefcase"></i>
                                                <span>Formulario para Registrar Viáticos <?php //echo $numaleat;  ?></span>
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
                                            <div class="form-group" >
                                                <label class="col-sm-2 control-label">Persona <span class="obl">(*)</span>:</label>
                                                <div class="col-sm-3">
                                                    <select id="codpersona"  name="codpersona" onchange="loadCargoByCodPersona()">                                                    
                                                        <option value="0">- Seleccione -</option>
                                                        <?php foreach ($listaEmp as $valor) { ?>                                
                                                            <option value="<?php echo trim($valor[0]); ?>"> <?php echo trim($valor[1] . ' ' . $valor[2]); ?></option>
                                                        <?php } ?>
                                                    </select>                                             
                                                </div>                                
                                                <label class="col-sm-2 control-label">Periodo <span class="obl">(*)</span>:</label>
                                                <div class="col-sm-1">
                                                    <select name="periodo" id="periodo" class="form-control">                                        
                                                        <option value="I">- I -</option>
                                                        <option value="II">- II -</option>
                                                    </select>                                                
                                                </div>
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
                                            <div class="row">
                                                <label class="col-sm-2 control-label">Cargo:</label>
                                                <div class="col-sm-3" id="divcargo">
                                                    <input type = "text" name = "cargo" placeholder="Escribir Cargo" value = "" class="form-control" id="cargo" />
                                                </div>
                                                <label class="col-sm-2 control-label">Saldo Anterior:</label>
                                                <div class="col-sm-2">
                                                    <input type = "number" name = "saldo" placeholder="" value = "0" class="form-control" id="saldo" />
                                                </div>
                                            </div>                                                               
                                            <br/>
                                            <h5 class="page-header">Ingresos, Transferencia, Depósitos, etc.</h5>
                                            <div class="form-group">                                                
                                                <div class="col-md-12 text-center">
                                                    
                                                    <button type="button" class="btn btn-primary" onclick="mostrarDivRegistrar('ingreso')">Registrar Ingreso</button>
                                                    <button type="button" class="btn btn-primary" onclick="mostrarDivRegistrar('egreso')">Registrar Egreso</button>                                                    
                                                </div>
                                            </div>
                                            <div class="form-group" id="divingreso" style="display: none;">
                                                <div class="col-md-6">
                                                    <form id="form_ingreso" name="form_ingreso" action="#" method="post" enctype="multipart/form-data">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading"><h4 class="title">Registrar Ingreso</h4></div>
                                                            <div class="panel-body">

                                                                <div class="form-group">
                                                                    <label class="col-md-2 control-label">Fecha:</label><div class="col-md-4"><input type="text" class="form-control" name="fecingreso" id="fecingreso" placeholder="" value="<?php echo date("d/m/Y");?>"/></div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="col-md-2 control-label">Detalle:</label><div class="col-md-8"><input type="text" class="form-control" name="descripcion" id="descripcion" /></div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="col-md-2 control-label">Monto:</label><div class="col-md-4"><input type="number" class="form-control" name="monto" id="monto" step="any" value="0" /></div>
                                                                </div>
                                                            </div>
                                                            <div class="panel-footer">
                                                                <div class="form-group">
                                                                    <div class="col-md-12 text-center">
                                                                        <button type="submit" id="ingreso_submit" class="btn btn-success btn-label-left">
                                                                            <span><i class="fa fa-clock-o"></i></span>
                                                                            Guardar
                                                                        </button>
                                                                    </div>
                                                                    <input type="hidden" name="accion" id="accion" value="RegViaticoIngreso" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="form-group" id="divegreso" style="display: none;">
                                                <div class="col-md-12">
                                                    <form id="form_egreso" name="form_egreso" action="#" method="post" enctype="multipart/form-data">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading"><h4 class="title">Registrar Egreso</h4></div>
                                                            <div class="panel-body">                                                                
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
                                                                        <input type = "text" name = "fecha" placeholder="dd/mm/yyyy" value = "<?php echo date("d/m/Y");?>" class="form-control" id="fecha" />
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
                                                            </div>
                                                            <div class="panel-footer">
                                                                <div class="form-group">
                                                                    <div class="col-sm-12" style="text-align: center;">                                                                        
                                                                        <button type="submit" id="egreso_submit" class="btn btn-success btn-label-left">
                                                                            <span><i class="fa fa-clock-o"></i></span>
                                                                            Guardar
                                                                        </button>
                                                                        <input type="hidden" id="accion" name="accion" value="RegViaticoEgreso" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12" id="respuesta">

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

                    function enviarDatos() {

                        var sendInfo = {
                            Name: 'Juan Leder',
                            Address: 'Lima Santa Anita',
                            Phone: '950650711',
                        };

                        $.ajax({
                            url: '_viaticodeting_reg.php',
                            type: 'GET',
                            dataType: 'html',
                            data: {objeto: sendInfo},
                            success: function (res) {
                                //$('<h1/>').text(json.title).appendTo('body');
                                //$('<div class="content"/>').html(json.html).appendTo('body');
                                $("#resultados").html(res);
                            },
                            error: function (jqXHR, status, error) {
                                alert('Disculpe, existió un problema');
                            },
                            complete: function (jqXHR, status) {
                                alert('Petición realizada');
                                $("#getresult").load('_viatico_lista.php');
                            }
                        });
                    }

                    function loadCargoByCodPersona() {
                        var codpersona = $("#codpersona").val();
                        from_2('LoadCargo', codpersona, 'divcargo', '_viatico_ajax.php');
                    }

                    function CloseModalBoxIngreso() {
                        var modalbox = $('#modalbox2');
                        modalbox.fadeOut('fast', function () {
                            modalbox.find('.modal-header-name span').children().remove();
                            modalbox.find('.devoops-modal-inner').children().remove();
                            modalbox.find('.devoops-modal-bottom').children().remove();
                            $('body').removeClass("body-expanded");
                        });
                    }

                    function Select2Test() {
                        $("#codpersona").select2();
                        //$("#codviatico").select2();
                        $("#codtipo").select2();
                        $("#codzona").select2();
                        $("#codlugar").select2();
                        $("#periodo_mes").select2();

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

                    function validarPeriodo() {
                        var codpersona = $("#codpersona").val();
                        var periodo_mes = $("#periodo_mes").val();
                        var periodo_ano = $("#periodo_ano").val();

                        if (codpersona === '0') {
                            alert('Debe seleccionar una persona.');
                            $("#codpersona").focus();
                            return false;
                        } else if (periodo_mes === '0') {
                            alert('Debe seleccionar un mes.');
                            $("#periodo_mes").focus();
                            return false;
                        } else if (periodo_ano === "") {
                            alert('Debe ingresar año.');
                            $("#periodo_ano2").focus();
                            return false;
                        }
                        return true;
                    }

                    $(document).ready(function () {
                        LoadSelect2Script(Select2Test);
                        WinMove();
                        $('#fecha').datepicker({setDate: new Date(), dateFormat: 'dd/mm/yy'});
                        $('#fecingreso').datepicker({setDate: new Date(), dateFormat: 'dd/mm/yy'});

                        $("#form_ingreso").submit(function (e) {
                            e.preventDefault();
                            var f = $(this);
                            var formData = new FormData(document.getElementById("form_ingreso"));
                            var codpersona = $("#codpersona").val();
                            var periodo = $("#periodo").val();
                            var periodo_mes = $("#periodo_mes").val();
                            var periodo_ano = $("#periodo_ano").val();
                            var cargo = $("#cargo").val();
                            var saldo = $("#saldo").val();
                            //var nomcli = $("#codcli option:selected").html();                                                        
                            formData.append("codpersona", codpersona);
                            formData.append("periodo", periodo);
                            formData.append("periodo_mes", periodo_mes);
                            formData.append("periodo_ano", periodo_ano);
                            formData.append("cargo", cargo);
                            formData.append("saldo", saldo);

                            $.ajax({
                                url: "../controller/C_Viaticos.php",
                                type: "post",
                                dataType: "html",
                                data: formData,
                                cache: false,
                                contentType: false,
                                processData: false,
                                success: function (res) {
                                    $("#divingreso").css("display", "none");
                                    $("#respuesta").html(res);
                                },
                                error: function (jqXHR, status, error) {
                                    alert('Disculpe, existió un problema');
                                },
                                complete: function (jqXHR, status) {
                                    //alert('Petición realizada');
                                    //$("#getresult").load('_viatico_lista.php');
                                }
                            });
                        });

                        $("#form_egreso").submit(function (e) {                            
                            e.preventDefault();
                            var f = $(this);
                            var formData = new FormData(document.getElementById("form_egreso"));

                            var zona = $("#codzona option:selected").html();
                            var codpersona = $("#codpersona").val();
                            var periodo = $("#periodo").val();
                            var periodo_mes = $("#periodo_mes").val();
                            var periodo_ano = $("#periodo_ano").val();
                            var cargo = $("#cargo").val();
                            var saldo = $("#saldo").val();

                            formData.append("codpersona", codpersona);
                            formData.append("periodo", periodo);
                            formData.append("periodo_mes", periodo_mes);
                            formData.append("periodo_ano", periodo_ano);
                            formData.append("cargo", cargo);
                            formData.append("saldo", saldo);
                            formData.append("zona", zona);

                            $.ajax({
                                url: "../controller/C_Viaticos.php",
                                type: "post",
                                dataType: "html",
                                data: formData,
                                cache: false,
                                contentType: false,
                                processData: false,
                                success: function (res) {
                                    $("#divegreso").css("display", "none");
                                    $("#respuesta").html(res);
                                },
                                error: function (jqXHR, status, error) {
                                    alert('Disculpe, existió un problema al enviar el formulario');
                                },
                                complete: function (jqXHR, status) {
                                    alert('Petición realizada');
                                    //$("#getresult").load('_viatico_lista.php');
                                },
                                timeout: 10000
                            });
                        });

                    });

                    function mostrarDivRegistrar(tipo) {

                        var validado = validarPeriodo();

                        if (validado) {
                            if (tipo === 'ingreso') {
                                $("#divingreso").css("display", "block");
                                $("#divegreso").css("display", "none");
                            } else if (tipo === 'egreso') {
                                $("#divingreso").css("display", "none");
                                $("#divegreso").css("display", "block");
                            }
                        }
                    }
                </script>
            </body>
        </html>
        <?php
    }
} else {
    header("Location:recursos/logout.php");
}
?>