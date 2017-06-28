<?php
header("Cache-Control: no-cache, must-revalidate");
$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["conectado"])) {
    if ($_SESSION["conectado"] == 'SI') {

        //@session_start();
        date_default_timezone_set("America/Bogota");
        include_once '../controller/C_Reportes.php';
        $obj = new C_Reportes();
        $lista = $obj->listarSoloClientes();
        $lcult = $obj->listarCultivos();
        $obj->insertarAccion('Hizo clic en el boton Registrar Rep. Comercial');
        ?>
        <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="utf-8">
                <title>Humasoft</title>
                <meta name="description" content="description">
                <meta name="author" content="Juan">
                <?php include 'head.php'; ?>   
                <style>            
                    /*.row { margin-top: 5px;}*/
                    .text-small { width: 70px;} .text-medium { width: 120px;}
                    .obl { font-weight: bolder; color: red; }
                    .texto-opaco { color: #666666; font-size: smaller; }
                    #form_reg {
                        font-family: inherit; font-size: small;
                    }
                </style>
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
                                        <li><a href="_repcomercialv2.php">Visitas</a></li>
                                        <li><a href="_repcomercialv2_reg.php">Comerciales</a></li>
                                    </ol>
                                </div>
                            </div>

                            <div class="row">                        
                                <div class="col-xs-12 col-sm-12">
                                    <div class="box">
                                        <div class="box-header">
                                            <div class="box-name">
                                                <i class="fa fa-android"></i>
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
                                            <form class="form-horizontal" action="#" accept="" method="POST" enctype="multipart/form-data" name="form" id="form" >
                                                <div class="form-group" style="font-size: 10px;" >                                            
                                                    <div class="col-sm-3"> 
                                                        <div style="background: #62d880; text-align: center; padding: 5px;">
                                                            <center><input type="radio" checked="" name="atendido" id="atendido_presencial" onclick="loadLocal()" value="1" /></center>
                                                            <p>VCSI<br/>Visita Comercial Atendida</p>                                                                                                    
                                                        </div>
                                                    </div>                    
                                                    <div class="col-sm-3"> 
                                                        <div style="background: #ff9999; text-align: center; padding: 5px;">
                                                            <center><input type="radio" name="atendido" id="noatendido_presencial" onclick="loadLocal()" value="3" /></center>
                                                            <p>VCNO<br/>Visita Comercial No Atendida</p>
                                                        </div>
                                                    </div>                    
                                                    <div class="col-sm-3"> 
                                                        <div style="background:  #ccf64e; text-align: center; padding: 5px;">
                                                            <center><input type="radio" name="atendido" id="atendido_llamada" onclick="loadLocal()" value="2" /></center>
                                                            <p>LCSI<br/>Llamada Comercial Atendida</p>                              
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3"> 
                                                        <div style="background: #ffcc00; text-align: center; padding: 5px;">
                                                            <center><input type="radio" name="atendido" id="noatendido_llamada" onclick="loadLocal()" value="4" /></center>
                                                            <p>LCNO<br/>Llamada Comercial No Atendida</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Cliente <span class="obl">(*)</span>:</label>
                                                    <div class="col-sm-4">
                                                        <select id="combobox"  name="codcliente" onchange="cargarFundo()" onblur="cargarFundo()">
                                                            <!--EN EL VALUE DEBE SER EL CODIGO DE FUNDO, PORQUE CON EL CODIGO DE FUNDO OBTENGO EL CULTIVO Y TAMBIEN EL ID DE CLIENTE-->
                                                            <option value="0"></option>
                                                            <option value="nuevo">..::Crear Nuevo Cliente</option>
                                                            <?php foreach ($lista as $valor) { ?>                                
                                                                <option value="<?php echo trim($valor[0]); ?>"> <?php echo trim($valor[1]); ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-4"></div>
                                                </div>
                                                <div class="form-group">
                                                    <div id="divnvocliente" hidden="">                                    
                                                        <div class="col-sm-2">
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label class="control-label">Razón Social <span class="obl">(*)</span>:</label>
                                                            <input maxlength="80" class="form-control" id="nomcliente" type="text" name="nomcliente" value="" placeholder="" />
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label class="control-label">NRO RUC o DNI<span class="obl">(*)</span>:</label>
                                                            <input maxlength="15" class="form-control" id="ruc" type="text" name="ruc" value="" placeholder="" onblur="" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="divfundo">
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Fundo <span class="obl">(*)</span>:</label>
                                                        <div class="col-lg-3">                                        
                                                            <select class="form-control " name="codfundo" id="codfundo" onblur="cargarLote()" onchange="cargarLote()">                
                                                                <option value="0">..::Seleccione Fundo</option>                            
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">                                    
                                                        <label class="col-sm-2 control-label">Contacto <span class="obl">(*)</span>:</label>
                                                        <div class="col-sm-2">                                        
                                                            <select class="form-control " name="contacto" id="contacto" onblur="loadRubrica()" onchange="loadRubrica()">
                                                                <option value="0">..::Seleccione Contacto</option>                            
                                                            </select>
                                                        </div>
                                                        <div id="divencargado" class="col-sm-2" hidden="">                                
                                                        </div>     
                                                        <div id="divcelcontacto">
                                                            <div class="col-sm-2">                                             
                                                                <input maxlength="15" class="form-control " type="text"  name="celcontacto" id="celcontacto" value="" placeholder="Celular Contacto" />
                                                            </div>
                                                            <div class="col-sm-2">                                            
                                                                <input maxlength="30" type="text" class="form-control " name="carcontacto" id="carcontacto" value="" placeholder="Cargo de Contacto" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Número Reporte <span class="obl">(*)</span>:</label>
                                                        <div class="col-lg-2">                                        
                                                            <input maxlength="20" type="text" class="form-control " name="codrep" id="codrep" value=""  />
                                                        </div>                                    
                                                    </div>
                                                </div>                                                                                    
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Zona <span class="obl">(*)</span>:</label>
                                                    <div class="col-sm-3">
                                                        <select name="zona" id="zona" class="form-control" onchange="loadZona()" onblur="loadZona()">                                                        
                                                            <option value="Sur Chico - Chincha">Sur Chico - Chincha</option>
                                                            <option value="Sur Chico - Cañete">Sur Chico - Cañete</option>
                                                            <option value="Sur Chico - Ica">Sur Chico - Ica</option>
                                                            <option value="Sur Chico - Pisco">Sur Chico - Pisco</option>
                                                            <option value="Sur Grande - Palpa">Sur Grande - Palpa</option>
                                                            <option value="Sur Grande - Nasca">Sur Grande - Nasca</option>
                                                            <option value="Sur Grande - Arequipa">Sur Grande - Arequipa</option>
                                                            <option value="Sur Grande - Tacna">Sur Grande - Tacna</option>   
                                                            <option value="Norte Chico - Huaral">Norte Chico - Huaral</option>
                                                            <option value="Norte Chico - Huacho">Norte Chico - Huacho</option>
                                                            <option value="Norte Chico - Huarmey">Norte Chico - Huarmey</option>
                                                            <option value="Norte Chico - Casma">Norte Chico - Casma</option>
                                                            <option value="Norte Grande - Trujillo">Norte Grande - Trujillo</option>
                                                            <option value="Norte Grande - Chiclayo">Norte Grande - Chiclayo</option>
                                                            <option value="Norte Grande - Piura">Norte Grande - Piura</option>
                                                            <option value="otro">..:: Otro ::..</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3" id="divzona" hidden="">
                                                        <input maxlength="80" type="text" name="zona2" id="zona2" value="" class="form-control" placeholder="Escribir Zona"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Cultivo <span class="obl">(*)</span>:</label>
                                                    <div class="col-sm-3">
                                                        <select class="form-control" id="cultivo"  name="cultivo">
                                                            <option value="0">..::Seleccione Cultivo</option>
                                                            <?php foreach ($lcult as $valor) { ?>                                
                                                                <option value="<?php echo $valor['desele']; ?>"> <?php echo $valor['desele']; ?></option>
                                                            <?php } ?>
                                                            <option value="otro">..:: Otro ::..</option>
                                                        </select>
                                                    </div>                                             
                                                    <div class="col-sm-3" id="divcultivo" hidden="">                       
                                                        <input maxlength="50" type="text" name="cultivo2" id="cultivo2" value="" class="form-control" placeholder="Escribir Cultivo" />
                                                    </div>                                
                                                </div>
                                                <div class="form-group" style="font-size: small;">                                     
                                                    <label class="col-sm-2 control-label"><br/>Detalle Visita</label>
                                                    <div class="col-sm-2">                              
                                                        <label class="control-label">Fecha Visita/Llamada <span class="obl">(*)</span>:</label>
                                                        <input type="text" class="form-control" required="" name="fechavisita" id="cal" value="<?php echo date("d/m/Y"); ?>" />
                                                    </div>                                                
                                                    <div class="col-sm-2">                                    
                                                        <label class="control-label">Hora Inicio <span class="obl">(*)</span>:</label>
                                                        <?php echo $obj->generarHora('horaingreso', 'form-control'); ?>
                                                    </div>                                
                                                    <div class="col-sm-2">
                                                        <label class="control-label">Hora Fin <span class="obl">(*)</span>:</label> 
                                                        <?php echo $obj->generarHora('horasalida', 'form-control'); ?>
                                                    </div>                                
                                                    <div id="divlocal" class="col-sm-4">
                                                        <label class="control-label">Local de Entrevista <span class="obl">(*)</span>:</label>
                                                        <input  maxlength="80" type="text" class="form-control" name="localvisita" id="localvisita" value="En el propio fundo" />
                                                    </div> 
                                                </div>
                                                <div class="form-group">
                                                    <hr/>
                                                </div>
                                                <div class="form-group" style="font-size: small;">                                     
                                                    <label class="col-sm-2 control-label">Notas de visita anterior</label>
                                                    <div class="col-sm-8">                              
                                                        <textarea class="form-control" id="humarpta1" name="huma[]" rows="4" cols="20"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group" style="font-size: small;">                                     
                                                    <label class="col-sm-2 control-label">Temas tratados en esta visita/llamada <span class="obl">(*)</span></label>
                                                    <div class="col-sm-8">                              
                                                        <textarea class="form-control" id="humarpta2" name="huma[]" rows="4" cols="20"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group" style="font-size: small;">                                     
                                                    <label class="col-sm-2 control-label">Notas de esta visita (Notas de fotos) o posibles pedidos</label>
                                                    <div class="col-sm-8">                              
                                                        <textarea class="form-control" id="humarpta3" name="huma[]" rows="4" cols="20"></textarea>
                                                    </div>
                                                </div>
                                                <!--                                                <div class="form-group">
                                                                                                    <div class="col-md-12 text-center">
                                                                                                        <button class="btn btn-default" onclick="verobs()" type="button">Ver Contenido de TextArea</button>
                                                                                                    </div>
                                                                                                </div>-->
                                                <div class="row" style="font-size: small;">
                                                    <hr/>
                                                    <div class="col-lg-2">
                                                        <input type="checkbox" class="checkbox-primary" onclick="loadProxVis()" name="proximavis" id="proximavis" value="ON" /> Agendar próxima visita.
                                                    </div>    
                                                    <div id="divproxvis" hidden="">
                                                        <div class="col-lg-3"> Lugar de Visita:<br/>
                                                            <input maxlength="80" type="text" name="localproxvis" id="localproxvis" class="form-control" />
                                                        </div>
                                                        <div class="col-lg-2"> Fecha:<br/>                        
                                                            <input type="text" name="fechaproxvis" value="" id="cal2" placeholder="Año/Mes/Dia" class="form-control" />
                                                        </div>                    
                                                        <div class="col-lg-2"> Hora:<br/>                        
                                                            <?php echo $obj->generarHora('horaproxvis', 'form-control'); ?>
                                                        </div>
                                                        <div class="col-lg-3"> Proposito Próxima Visita::<br/>
                                                            <input type="text" name="propositovis" id="propositovis" class="form-control" />                    
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
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div id="cargando"></div>
                                                    </div>
                                                </div>

                                                <div class="row" style="text-align: center">
                                                    <!--Opciones para el administrador-->
                                                    <?php if ($_SESSION['usuario'] == 'JLP' || $_SESSION['usuario'] == 'ISA' || $_SESSION['usuario'] == 'CSA') { ?>
                                                        <span>Es prueba? </span><input type="text" name="prueba" id="prueba" value="SI" />
                                                        <br/><br/>
                                                    <?php } else { ?>
                                                        <input type="hidden" name="prueba" id="prueba" value="NO" />
                                                    <?php } ?>

                                                    <input type="hidden" name="accion" id="accion" value="RegRepComercial" />
                                                    <input type="submit" class="btn btn-primary" value="Guardar" />
                                                    <a class="btn btn-danger" href="_repcomercialv2.php"> Volver</a>
                                                </div>
                                            </form>
                                            <div class="row">
                                                <div class="col-md-12" id="result">

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

                    function cargarFundo2() {
                        var id_cliente = $("#codcli").val();
                        from_unico(id_cliente, 'numrep', '_cargar_encargadoxclienteCom2.php');
                    }

                    function loadZona() {
                        var codzona = $("#zona").val();
                        var divzona = document.getElementById('divzona');
                        var zona2 = document.getElementById('zona2');
                        if (codzona === 'otro') {
                            divzona.style.display = "block";
                            zona2.required;
                        } else {
                            divzona.style.display = "none";
                            zona2.value = '';
                        }
                    }

                    function loadProxVis() {
                        var donde = $("#combobox option:selected").html();
                        var div = document.getElementById('divproxvis');
                        var var1 = document.getElementById('proximavis');
                        var var2 = document.getElementById('localproxvis');
                        var var3 = document.getElementById('propositovis');
                        if (var1.checked) {
                            //Male radio button is checked                    
                            div.style.display = "block";
                            var2.value = $.trim(donde);
                        } else {
                            //Female radio button is checked                    
                            div.style.display = "none";
                            var3.value = '';
                            var2.value = '';
                        }
                    }

                    function loadCultivo() {
                        var codcultivo = $("#cultivo").val();
                        var div = document.getElementById('divcultivo');
                        var cultivo2 = document.getElementById('cultivo2');
                        if (codcultivo === 'otro') {
                            div.style.display = "block";
                            cultivo2.required;
                        } else {
                            div.style.display = "none";
                            cultivo2.value = '';
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
                                    cod0 = 'VCSI';
                                    break;
                                case '2':
                                    cod0 = 'LCSI';
                                    break;
                                case '3':
                                    cod0 = 'VCNO';
                                    break;
                                case '4':
                                    cod0 = 'LCNO';
                                    break;
                            }
                            $("#codrep").val(cod0 + '-' + cod1 + '-' + cod2);
                        }
                    }

                    function loadLocal() {

                        cambiarCodigo();

                        var div = document.getElementById('divlocal');
                        var localvisita = document.getElementById('localvisita');
                        if (document.getElementById('atendido_presencial').checked || document.getElementById('noatendido_presencial').checked) {
                            //Male radio button is checked                    
                            div.style.display = "block";
                            localvisita.required;
                            localvisita.value = 'En el propio fundo';
                        } else if (document.getElementById('atendido_llamada').checked || document.getElementById('noatendido_llamada').checked) {
                            //Female radio button is checked                    
                            div.style.display = "none";
                            localvisita.value = '';
                        }
                    }

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
                        from_2(codcliente, atendido, 'divfundo', '_repcomercialv2_loadfundo.php');
                    }

                    function cargarLote() {
                        var codfundo = $("#codfundo").val();
                        var divnvofundo = document.getElementById('divnvofundo');
                        var nomfundo = document.getElementById('nomfundo');
                        if (codfundo === 'nuevo') {
                            divnvofundo.style.display = "block";
                            nomfundo.required;
                        } else {
                            divnvofundo.style.display = "none";
                            nomfundo.value = '';
                        }
                    }

                    function loadRubrica() {
                        var variable = $("#contacto").val();
                        var div = document.getElementById('divencargado');
                        var encargado2 = $("#newcontacto").val();
                        var celcontacto = document.getElementById('celcontacto');
                        if (variable === 'otro') {
                            div.style.display = "block";
                            encargado2.required;
                            celcontacto.value = '';
                        } else {
                            encargado2.value = '';
                            div.style.display = "none";
                            from_unico(variable, 'divcelcontacto', '_repcomercialv2_loadlcel.php');
                        }


                    }

                    function otroEncargado() {
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
                    }

                    //                    function verobs(){
                    //                        
                    //                        var humarpta1 = $("#humarpta1").val();
                    //                        var humarpta2 = $("#humarpta2").val();
                    //                        var humarpta3 = $("#humarpta3").val();
                    //                        alert('1: '+humarpta1);
                    //                        alert('2: '+humarpta2);
                    //                        alert('3: '+humarpta3);
                    //                    }

                    function validaFormulario() {
                        //var codrep = $("#codrep").val();
                        var ruc = $("#ruc").val();
                        var codcliente = $("#combobox").val();
                        var nomcliente = $("#nomcliente").val();
                        var codfundo = $("#codfundo").val();
                        var nomfundo = $("#nomfundo").val();
                        var contacto = $("#contacto").val();
                        var newcontacto = $("#newcontacto").val();
                        var cultivo = $("#cultivo").val();
                        //var telcontacto = $("#telcontacto").val();
                        //var localvisita = $("#localvisita").val();
                        var fechavisita = $("#cal").val();
                        var horaingreso = $("#horaingreso").val();
                        var horasalida = $("#horasalida").val();
                        //var humarpta2 = $("#humarpta2").val();



                        if (codfundo === "0") {
                            alert('Debe seleccionar un fundo');
                            $("#codfundo").focus();
                            return false;
                        } else if (codfundo === "nuevo" && nomfundo === "") {
                            alert('Debe ingresar nombre de Fundo');
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
                            //} else if (codrep === "") {
                            //    alert('Escriba un código para el Reporte');
                            //$("#codrep").focus();
                            //return false;
                        } else if (cultivo === "0") {
                            alert('Debe seleccionar un cultivo');
                            $("#cultivo").focus();
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
                        }
                        //                        else if (humarpta2 === "") {
                        //                            alert('Debe describir los temas tratados en esta visita.');
                        //                            $("#humarpta2").focus();
                        //                            return false;
                        //                        }
                        return true;
                    }

                    var cargarCultivo = function () {
                        var codcultivo = $("#cultivo").val();
                        var div = document.getElementById('divcultivo');
                        var cultivo2 = document.getElementById('cultivo2');
                        if (codcultivo === 'otro') {
                            div.style.display = "block";
                            cultivo2.required;
                        } else {
                            div.style.display = "none";
                            cultivo2.value = '';
                        }
                        e.preventDefault();
                    };


                    $("#cultivo").bind("change blur", loadCultivo);  //llamando a un funcion javascrip
                    //$("#cultivo").bind("change blur", cargarCultivo);  //llamando a un variable funcion jquery. No poner parentesis.

                    $(document).ready(function () {

                        // Create Wysiwig editor for textare
                        //                        TinyMCEStart('#humarpta1', null);
                        //                        TinyMCEStart('#humarpta2', null);
                        //                        TinyMCEStart('#humarpta3', null);
                        // Load script of Select2 and run this
                        LoadSelect2Script(Select2Test);
                        WinMove();
                        // Add tooltip to form-controls
                        //$('.form-control').tooltip();

                        $("#form").submit(function (e) {
                            e.preventDefault();
                            var rpta = validaFormulario();
                            if (rpta === true) {
                                $("#cargando").html('<h2> <img src="img/iconos/loading.gif" width="25" height="25" alt="loading"/> Enviando datos...</h2>');
                                var f = $(this);
                                var nomcontacto = $("#contacto option:selected").html();
                                var formData = new FormData(document.getElementById("form"));
                                formData.append("nomcontacto", nomcontacto);

                                $.ajax({
                                    url: "../controller/C_Reportes.php",
                                    type: "post",
                                    dataType: "html",
                                    data: formData,
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    success: function (res) {
                                        $("#cargando").delay(500).hide(1);
                                        $("#result").html(res);
                                        $("#result").delay(2000).hide(2000);

                                    },
                                    error: function (jqXHR, status, error) {
                                        alert('Disculpe, existió un problema');
                                    },
                                    complete: function (jqXHR, status) {
                                        //alert('Petición realizada');
                                        //$("#getresult").load('_viatico_lista.php');
                                    }
                                });


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
                                            $("#cargando").delay(500).hide(1);
                                            $("#result").html(res);
                                            $("#result").delay(2000).hide(2000);
                                        });
                                // ... resto del código de mi ejercicio
                            }
                        });
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
                    function Select2Test() {
                        //$("#tactividad").select2();
                        $("#combobox").select2();
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