<?php
@session_start();
date_default_timezone_set("America/Bogota");
include_once '../controller/C_Reportes.php';
$obj = new C_Reportes();
$obj->insertarAccion('Hizo clic en el boton Crear Rep. Técnico');
$lista = $obj->listarSoloClientes();

$hoy = date("d/m/Y");
//  $nropreg = array('01', '02', '03'); */
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
        <style>            
            /*.row { margin-top: 5px;}*/
            .text-small { width: 70px;} .text-medium { width: 120px;}
            .obl { font-weight: bolder; color: red; }
            .texto-opaco { color: #666666; font-size: smaller; }
            #form_reg {
                font-family: inherit; font-size: small;
            }
        </style>                  
        <script>

            function cargarFundo() {
                var codcliente = $("#combobox").val();
                var divnvocliente = document.getElementById('divnvocliente');
                var ruc = document.getElementById('ruc');
                var nomcliente = document.getElementById('nomcliente');
                var atendido = $('input:radio[name=atendido]:checked').val();

                if (codcliente === 'nuevo') {
                    divnvocliente.style.display = "block";
                    ruc.required;
                    nomcliente.required;
                } else {
                    divnvocliente.style.display = "none";
                    ruc.value = '';
                    nomcliente.value = '';
                }
                from_2(codcliente, atendido, 'divfundo', '_reptecnicov2_loadfundo.php');

            }

            function cargarLote() {
                var codfundo = $("#codfundo").val();
                var divnvofundo = document.getElementById('divnvofundo');
                var nomfundo = document.getElementById('nomfundo');
                if (codfundo === 'nuevo') {
                    divnvofundo.style.display = "block";
                    nomfundo.required;
                    from_unico(codfundo, 'divlote', '_reptecnicov2_loadlote.php');
                } else {
                    divnvofundo.style.display = "none";
                    nomfundo.value = '';
                    from_unico(codfundo, 'divlote', '_reptecnicov2_loadlote.php');
                }
            }

            function cargarlotehuma() {
                var codlote = $("#codlotehuma").val();
                if (codlote === 'NULL') {
                    from_unico(codlote, 'divlotehuma', '_vacio.php');
                } else {
                    from_unico(codlote, 'divlotehuma', '_reptecnicov2_loadlotehuma.php');
                }
            }

            function cargarlotetestigo() {
                var codlotetestigo = $("#codlotetestigo").val();
                //var divtestigo = $("#divtestigo").val();
                if (codlotetestigo === 'ninguno') {
                    from_unico(codlotetestigo, 'divlotetestigo', '_vacio.php');
                    //divtestigo.style.display = "block";
                } else {
                    //divtestigo.style.display = "none";
                    from_unico(codlotetestigo, 'divlotetestigo', '_reptecnicov2_loadlotetest.php');

                }
            }

            function firmadoporOtro() {
                var variable = $("#rubrica").val();
                var otro = document.getElementById('divrubrica2');
                var rubrica2 = document.getElementById('rubrica2');
                if (variable === 'otro') {

                    otro.style.display = "block";
                    rubrica2.required;
                } else {
                    rubrica2.value = '';
                    otro.style.display = "none";
                }
            }

            function loadRubrica() {
                var id_cliente = $("#combobox").val();
                var variable = document.getElementById("contacto").value;
                var div = document.getElementById('divencargado');
                var encargado2 = document.getElementById('newcontacto');
                if (variable === 'otro') {
                    div.style.display = "block";
                    encargado2.required;
                } else {
                    encargado2.value = '';
                    div.style.display = "none";
                }
                from_unico(id_cliente, 'rubrica', '_reptecnicov2_loadrubrica.php');
            }

            function validaFormulario() {
                var codrep = $("#codrep").val();
                var ruc = $("#ruc").val();
                var codcliente = $("#combobox").val();
                var nomcliente = $("#nomcliente").val();
                var codfundo = $("#codfundo").val();
                var nomfundo = $("#nomfundo").val();
                var contacto = $("#contacto").val();
                var newcontacto = $("#newcontacto").val();
                var rubrica = $("#rubrica").val();
                var rubrica2 = $("#rubrica2").val();
                //var localvisita = $("#localvisita").val();
                var fechavisita = $("#cal").val();
                var horaingreso = $("#horaingreso").val();
                var horasalida = $("#horasalida").val();
                var codlotehuma = $("#codlotehuma").val();
                var humanombre = $("#humanombre").val();
                var codlotetest = $("#codlotetestigo").val();
                var testnombre = $("#testnombre").val();


                if (codfundo === "0") {
                    alert('Debe seleccionar un fundo');
                    $("#codfundo").focus();
                    return false;
                } else if (codfundo === "nuevo" && nomfundo === "") {
                    alert('Debe ingresar Nombre de Fundo');
                    $("#nomfundo").focus();
                    return false;
                } else if (codcliente === "nuevo" && ruc === "") {
                    alert('Debe ingresar nro de RUC o DNI');
                    $("#ruc").focus();
                    return false;
                } else if (codcliente === "nuevo" && nomcliente === '') {
                    alert('Debe ingresar Razon Social');
                    $("#nomcliente").focus();
                    return false;
                } else if (contacto === "0") {
                    alert('Debe seleccionar un contacto');
                    $("#contacto").focus();
                    return false;
                } else if (contacto === "otro" && newcontacto === "") {
                    alert('Debe escribir nombre de contacto');
                    $("#newcontacto").focus();
                    return false;
                } else if (codrep === "") {
                    alert('Escriba un código para el Reporte');
                    $("#codrep").focus();
                    return false;
                } else if (fechavisita === "") {
                    alert('Debe escribir una fecha de visita valida');
                    $("#cal").focus();
                    return false;
                } else if (horaingreso === "00:00") {
                    alert('Debe seleccionar hora de ingreso');
                    $("#horaingreso").focus();
                    return false;
                } else if (horasalida === "00:00") {
                    alert('Debe seleccionar hora de salida');
                    $("#horasalida").focus();
                    return false;
                } else if (horaingreso >= horasalida) {
                    alert('La hora salida debe ser mayor que la hora de ingreso.');
                    $("#horasalida").focus();
                    return false;
                } else if (rubrica === "0") {
                    alert('Seleccionar persona que firmo el reporte');
                    $("#rubrica").focus();
                    return false;
                } else if (rubrica === "otro" && rubrica2 === "") {
                    alert('Escribir nombre de la persona que firmo el reporte');
                    $("#rubrica2").focus();
                    return false;
                } else if (codlotehuma === "nuevo" && humanombre === "") {
                    alert('Debe ingresar Nombre de Lote');
                    $("#humanombre").focus();
                    return false;
                } else if (codlotetest === "nuevo" && testnombre === "") {
                    alert('Debe ingresar Nombre de Lote');
                    $("#testnombre").focus();
                    return false;
                }

                //if (!$("#mayor").is(":checked")) {
//                    alert("Debe confirmar que es mayor de 18 años.");
//                    return false;
//                }
                return true;
            }

            $(document).ready(function () {
                $("#form").submit(function (e) {
                    e.preventDefault();
                    var rpta = validaFormulario();
                    if (rpta === true) {


                        //alert('Guardando datos. Por favor espere.... No presionar dos veces el boton Guardar.');
                        $("#cargando").html('<h2> <img src="img/iconos/loading.gif" width="25" height="25" alt="loading"/> Enviando datos...</h2>');

                        var f = $(this);
                        var formData = new FormData(document.getElementById("form"));

                        var codcliente = $("#combobox").val();
                        var nomcliente2 = '';

                        if (codcliente !== "nuevo" && codcliente !== "0") {
                            nomcliente2 = $("#combobox option:selected").html();
                        }

                        formData.append("nomcliente2", nomcliente2);

                        $.ajax({
                            url: "../controller/C_Reportes.php",
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

                        // ... resto del código de mi ejercicio
                    }
                });
            });


            //Cargar New Valor
            function otroCultivoHuma() {
                var valor = $("#humatipocultivo").val();
                var div = document.getElementById('divnewcultivohuma');
                var newvalor = document.getElementById('newcultivohuma');
                if (valor === 'otro') {
                    div.style.display = "block";
                    newvalor.required;
                } else {
                    newvalor.value = '';
                    div.style.display = "none";
                    from_2(valor, 'opc_humavariedad', 'divvariedadhuma', '_reptecnicov2_loadvariedad.php');
                }
            }
            
            

//Cargar New Valor
            function otroVariedadHuma() {
                var valor = $("#humavariedad").val();
                var div = document.getElementById('divnewvariedadhuma');
                var newvalor = document.getElementById('newvariedadhuma');
                if (valor === 'OTRO') {
                    div.style.display = "block";
                    newvalor.required;
                } else {
                    newvalor.value = '';
                    div.style.display = "none";
                }
            }

//Cargar New Valor
            function otroPatronHuma() {
                var valor = $("#humapatron").val();
                var div = document.getElementById('divnewpatronhuma');
                var newvalor = document.getElementById('newpatronhuma');
                if (valor === 'OTRO') {

                    div.style.display = "block";
                    newvalor.required;
                } else {
                    newvalor.value = '';
                    div.style.display = "none";
                }
            }


            //Cargar New Valor
            function otroCultivoTest() {
                var valor = $("#testtipocultivo").val();
                var div = document.getElementById('divnewcultivotest');
                var newvalor = document.getElementById('newcultivotest');
                if (valor === 'otro') {
                    div.style.display = "block";
                    newvalor.required;
                } else {
                    newvalor.value = '';
                    div.style.display = "none";
                    from_2(valor, 'opc_testvariedad', 'divvariedadtest', '_reptecnicov2_loadvariedad.php');
                }
            }
            
            

//Cargar New Valor
            function otroVariedadTest() {
                var valor = $("#testvariedad").val();
                var div = document.getElementById('divnewvariedadtest');
                var newvalor = document.getElementById('newvariedadtest');
                if (valor === 'OTRO') {
                    div.style.display = "block";
                    newvalor.required;
                } else {
                    newvalor.value = '';
                    div.style.display = "none";
                }
            }

//Cargar New Valor
            function otroPatronTest() {
                var valor = $("#testpatron").val();
                var div = document.getElementById('divnewpatrontest');
                var newvalor = document.getElementById('newpatrontest');
                if (valor === 'OTRO') {

                    div.style.display = "block";
                    newvalor.required;
                } else {
                    newvalor.value = '';
                    div.style.display = "none";
                }
            }

            function cambiarCodigo() {
                var atendido = $('input:radio[name=atendido]:checked').val();
                var codrep = $("#codrep").val();

                if (codrep !== "") {

                    var codreporte = $("#codrep").val().split('-');
                    var cod0 = codreporte[0];
                    var cod1 = codreporte[1];
                    var cod2 = codreporte[2];

                    switch (atendido) {
                        case '1':
                            cod0 = 'VTSI';
                            break;
                        case '2':
                            cod0 = 'LTSI';
                            break;
                        case '3':
                            cod0 = 'VTNO';
                            break;
                        case '4':
                            cod0 = 'LTNO';
                            break;
                    }
                    $("#codrep").val(cod0 + '-' + cod1 + '-' + cod2);
                }
            }

            function loadObs() {

                cambiarCodigo();
                var div = document.getElementById('divobs');
                var divlote = document.getElementById('divlote');
                var obs = document.getElementById('obs');

                if (document.getElementById('vtno').checked || document.getElementById('ltno').checked) {
                    //Male radio button is checked                    
                    div.style.display = "block";
                    divlote.style.display = "none";
                    obs.required;
                } else if (document.getElementById('vtsi').checked || document.getElementById('ltsi').checked) {
                    //Female radio button is checked                    
                    divlote.style.display = "block";
                    div.style.display = "none";
                    obs.value = '';
                }
            }
        </script>                
    </head>
    <body>          
        <div class="row">
            <div id="breadcrumb" class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="#">Visitas</a></li>
                    <li><a href="#">Comercial</a></li>
                </ol>
            </div>
        </div>
        <div class="row">                        
            <div class="col-xs-12 col-sm-12">
                <div class="box">
                    <div class="box-header">
                        <div class="box-name">
                            <i class="fa fa-search"></i>
                            <span>Registrar Reporte Comercial</span>
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
                        <form class="form-horizontal" role="form" method="POST" action="#" id="form">
                            <div class="row" style="font-size: small;" >
                                <div class="col-lg-3"> 
                                    <div style="background: #62d880; text-align: center; padding: 5px;">
                                        <center><input type="radio" checked="" name="atendido" id="vtsi" onclick="loadObs()" value="1" /></center>
                                        <p>VTSI = Visita Técnica Atendida</p>                                                                                                    
                                    </div>
                                </div>                    
                                <div class="col-lg-3"> 
                                    <div style="background: #ff9999; text-align: center; padding: 5px;">
                                        <center><input type="radio" name="atendido" id="vtno" onclick="loadObs()" value="3" /></center>
                                        <p>VTNO = Visita Técnica No Atendida</p>
                                    </div>
                                </div>                    
                                <div class="col-lg-3"> 
                                    <div style="background:  #ccf64e; text-align: center; padding: 5px;">
                                        <center><input type="radio" name="atendido" id="ltsi" onclick="loadObs()" value="2" /></center>
                                        <p>LTSI = Llamada Técnica Atendida</p>                              
                                    </div>
                                </div>
                                <div class="col-lg-3"> 
                                    <div style="background: #ffcc00; text-align: center; padding: 5px;">
                                        <center><input type="radio" name="atendido" id="ltno" onclick="loadObs()" value="4" /></center>
                                        <p>LTNO = Llamada Técnica No Antendida</p>                              
                                    </div>
                                </div>
                            </div>
                            <div class="row">                         
                                <div class="col-lg-3">Escribir nombre de Cliente <span class="obl">(*)</span>:
                                    <select id="combobox"  name="codcliente" onchange="cargarFundo()" onblur="cargarFundo()">
                                        <!--EN EL VALUE DEBE SER EL CODIGO DE FUNDO, PORQUE CON EL CODIGO DE FUNDO OBTENGO EL CULTIVO Y TAMBIEN EL ID DE CLIENTE-->
                                        <option value="0"></option>
                                        <option value="nuevo">..::Crear Nuevo Cliente</option>
                                        <?php foreach ($lista as $valor) { ?>                                
                                            <option value="<?php echo $valor[0] ?>"> <?php echo $valor[1]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div id="divnvocliente" hidden="">
                                    <div class="col-lg-2">
                                        NRO RUC o DNI <span class="obl">(*)</span>:
                                        <input class="form-control" maxlength="15" id="ruc" type="text" name="ruc" value="" placeholder="" />
                                    </div>
                                    <div class="col-lg-2">
                                        Razón Social <span class="obl">(*)</span>:
                                        <input maxlength="80" class="form-control" id="nomcliente" type="text" name="nomcliente" value="" placeholder="" />
                                    </div>
                                </div>
                                <div id="divfundo">
                                    <div class="col-lg-2">
                                        Fundo <span class="obl">(*)</span>:
                                        <select name="codfundo" id="codfundo" onblur="cargarLote()" onchange="cargarLote()">
                                            <option value="0">..::Seleccione Fundo</option>                                        
                                        </select>
                                    </div>
                                    <div id="divnvofundo" class="col-lg-2" hidden="">
                                        Nombre de Fundo <span class="obl">(*)</span>:
                                        <input maxlength="80" class="form-control" id="nomfundo" type="text" name="nomfundo" value="" placeholder="" />
                                    </div>

                                    <div class="col-lg-2">
                                        Contacto <span class="obl">(*)</span>:
                                        <select class="form-control" name="contacto" id="contacto" onblur="loadRubrica()" onchange="loadRubrica()">
                                            <option value="0">..::Seleccione</option>                                        
                                        </select>
                                    </div>
                                    <div id="divencargado" hidden="">                                    
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <hr/>
                                </div>
                            </div>
                            <div class="form-group">                                    
                                <label class="col-sm-2 control-label"><br/>Datos de Visita</label>                                    
                                <div class="col-sm-2">
                                    <label class="control-label">Fecha</label>
                                    <div class="has-feedback">
                                        <input onblur="" type = "text" name = "fechavisita" placeholder="Fecha" value = "<?php echo $hoy; ?>" class="form-control" id="cal" />
                                        <span class="fa fa-calendar form-control-feedback"></span>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label class="control-label">Hora Ingreso</label>
                                    <?php echo $obj->generarHora('horaingreso', 'form-control'); ?>
                                </div>
                                <div class="col-sm-2">
                                    <label class="control-label">Hora Salida</label>
                                    <?php echo $obj->generarHora('horasalida', 'form-control'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><br/>Datos Próxima Visita</label>                                    
                                <div class="col-sm-2">
                                    <label class="control-label">Fecha</label>
                                    <div class="has-feedback">
                                        <input type = "text" name = "fechaproxvis" placeholder="Fecha" value = "" class="form-control" id="cal2" />
                                        <span class="fa fa-calendar form-control-feedback"></span>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label class="control-label">Hora</label>
                                    <?php echo $obj->generarHora('horaproxvis', 'form-control'); ?>
                                </div>
                                <div class="col-lg-6">
                                    <label class="control-label">Motivo o Proposito</label>
                                    <input maxlength="" type="text" name="propositovis" placeholder="" value = "" class="form-control" id="propositovis" />
                                </div>
                            </div>                           
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Firmado por: <i class="obl">(*)</i></label>
                                <div id="divrubrica1" class="col-sm-2">                                     
                                    <select name="rubrica" id="rubrica" class="form-control" onchange="firmadoporOtro()">
                                        <option value="0">..::Seleccione</option>                                                                
                                        <option value="NINGUNO">NINGUNO</option>
                                        <option value="otro">..::Otro</option>
                                    </select>
                                </div>
                                <div id="divrubrica2" class="col-lg-2" hidden="">                                    
                                    <input maxlength="50" placeholder="Firmado por" type="text" name="rubrica2" id="rubrica2" value="" class="form-control" />
                                </div>
                                <label class="col-sm-2 control-label">Nota al Cliente</label>
                                <div class="col-lg-4">
                                    <textarea name = "nota" class="form-control" id="nota"></textarea>
                                </div>                            
                                <div class="col-lg-12">
                                    <hr/>
                                </div>
                            </div>
                            <div class="row" id="divobs" hidden="">
                                <div class="col-lg-12">
                                    Observaciones: (Detallar porque no fue atendido)
                                    <textarea class="form-control" name="obs" id="obs" rows="3" cols="20"></textarea>
                                </div>
                            </div>
                            <div id="divlote" class="row">
                                <div class="col-lg-6">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">Lote Humagro</div>
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    Lote Humagro
                                                    <select onchange="cargarlotehuma()" onblur="cargarlotehuma()" name="codlotehuma" class="form-control" id="codlotehuma">                                    
                                                        <option value="NULL">..::NINGUNO::..</option>
                                                        <option value="nuevo">..::CREAR NUEVO LOTE::..</option>                                    
                                                    </select>              
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div class="box">
                                                        <div class="box-content" id="divlotehuma">


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-6">
                                    <div class="panel panel-danger">
                                        <div class="panel-heading">Lote Testigo</div>
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    Lote Testigo
                                                    <select onchange="cargarlotetestigo()" onblur="cargarlotetestigo()" name="codlotetestigo" class="form-control" id="codlotetestigo">                                                
                                                        <option value="ninguno">..::NINGUNO::..</option>
                                                        <option value="nuevo">..::CREAR NUEVO LOTE::..</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div class="box">
                                                        <div class="box-content" id="divlotetestigo">

                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                            
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <p>
                                        <br/>
                                        Subir Archivos o Imagenes: <span class="alert-warning" >(Tamaño Máximo 1Mb)</span>
                                        <input class="" type="file"  name="imagenes[]" id="imagen1" value="" /> <br/>
                                        <input type="text" name="leyenda[]" id="comment1" maxlength="100" class="form-control" value="" placeholder="Descripcion de archivo." />
                                    </p>
                                    <p>                                    
                                        <input class="" type="file"  name="imagenes[]" id="imagen2" value="" /><br/>
                                        <input type="text" name="leyenda[]" id="comment2" maxlength="100" class="form-control" value="" placeholder="Descripcion de archivo." />
                                    </p>
                                    <p>                                   
                                        <input class="" type="file"  name="imagenes[]" id="imagen3" value="" /><br/>
                                        <input type="text" name="leyenda[]" id="comment3" maxlength="100" class="form-control" value="" placeholder="Descripcion de archivo." />
                                    </p>
                                    <p>                                   
                                        <input class="" type="file"  name="imagenes[]" id="imagen4" value="" /><br/>
                                        <input type="text" name="leyenda[]" id="comment4" maxlength="100" class="form-control" value="" placeholder="Descripcion de archivo." />
                                    </p>
                                </div>  
                            </div>
                            <div class="row" style="text-align: center">
                                <?php if ($_SESSION['usuario'] == 'JLP' || $_SESSION['usuario'] == 'ISA' || $_SESSION['usuario'] == 'CSA') { ?>
                                    <span>Es prueba? </span><input type="text" id="prueba" name="prueba" value="SI" />
                                <?php } else { ?>
                                    <input type="hidden" name="prueba" id="prueba" value="NO" />
                                <?php } ?>                            
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div id="cargando"></div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-2">
                                    <button type="cancel" class="btn btn-default btn-label-left">
                                        <span><i class="fa fa-clock-o txt-danger"></i></span>
                                        Cancel
                                    </button>
                                </div>
                                <div class="col-sm-2">

                                </div>
                                <div class="col-sm-2">
                                    <button type="submit" class="btn btn-primary btn-label-left">
                                        <span><i class="fa fa-clock-o"></i></span>
                                        Submit
                                    </button>
                                </div>
                                <input type="hidden" id="accion" name="accion" value="RegRepTecnico" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>            
        </div>
        <br/>

        <div id="result"></div>        
        <script type="text/javascript">
            function Select2Test() {
                //$("#tactividad").select2();
                $("#combobox").select2();
                $("#codfundo").select2();
            }
            $(document).ready(function () {
                // Load script of Select2 and run this
                LoadSelect2Script(Select2Test);
                WinMove();
                // Initialize datepicker
                //$('#input_date').datepicker({setDate: new Date()});




                //$('#input_date2').datepicker({setDate: new Date()});                
                // Add tooltip to form-controls
                $('.form-control').tooltip();
            });

            $(function () {
                $('#cal').datepicker($.extend({
                    showMonthAfterYear: false,
                    dateFormat: 'dd/mm/yy'
                },
                        $.datepicker.regional['es']
                        ));
            });
            $(function () {
                $('#cal2').datepicker($.extend({
                    showMonthAfterYear: false,
                    dateFormat: 'dd/mm/yy'
                }
                ));
            });
        </script>
    </body>
</html>