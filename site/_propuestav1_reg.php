<?php
@session_start();
date_default_timezone_set("America/Bogota");
include_once '../controller/C_Solicitud.php';
$sol = new C_Solicitud();
$pro = new C_Propuesta();

$lista = $sol->listarSoloClientes();
$asesor = $pro->listarAsesores();
$cultivo = $sol->listarCultivos();
$hoy = $sol->obtFechadeHoy();
$listcatzona = $pro->listar_catzona();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />     
        <style>
            .row { margin-top: 5px;}
            .obl { font-weight: bolder; color: red; }            
        </style>  
        <!--calendario-->        
        <script type="text/javascript" src="js/js_inscoltec.js"></script>        
        <style type="text/css">            
            @import "util/media/themes/smoothness/jquery-ui-1.8.4.custom.css";            
        </style>
        <script type="text/javascript">
            function otroCultivo() {
                var valor = $("#cultivo").val();
                var div = document.getElementById('divnewcultivo');
                var newvalor = document.getElementById('newcultivo');
                if (valor === 'otro') {
                    div.style.display = "block";
                    newvalor.required;
                } else {
                    newvalor.value = '';
                    div.style.display = "none";
                }
            }

            function mostrarRegDespacho() {
                var creardesp = $("#creardesp").val();
                var divregdesp = document.getElementById('divregdesp');

                switch (creardesp) {
                    case 'NO':
                        divregdesp.style.display = "none";
                        break;
                    case 'SI':
                        divregdesp.style.display = "block";
                        break;
                }
            }

            function mostrarFormMsj() {
                var enviarmail = $("#enviarmail").val();
                var divsendmail = document.getElementById('divsendmail');

                switch (enviarmail) {
                    case 'NO':
                        divsendmail.style.display = "none";
                        break;
                    case 'SI':
                        divsendmail.style.display = "block";
                        break;
                }
            }

            function mostrarLugares() {
                var catzona = $("#zona").val();
                from_unico(catzona, 'divlugar', '_propuestav1_loadlugar.php');
            }


            function cargarCorreoVendedor() {
                var coduse = $("#asesor").val();
                from_unico(coduse, 'divmailpara', '_propuestav1_reg_loadmail.php');
            }

            function validarWord(formulario, archivo) {
                extensiones_permitidas = new Array(".doc", ".docx", ".dotx", ".dot", ".txt");
                mierror = "";
                if (!archivo) {
                    //Si no tengo archivo, es que no se ha seleccionado un archivo en el formulario 
                    mierror = "No has seleccionado ningún archivo";
                    alert(mierror);
                    //return false;
                } else {
                    //recupero la extensión de este nombre de archivo 
                    extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase();
                    alert(extension);
                    //compruebo si la extensión está entre las permitidas 
                    permitida = false;
                    for (var i = 0; i < extensiones_permitidas.length; i++) {
                        if (extensiones_permitidas[i] == extension) {
                            permitida = true;
                            break;
                        }
                    }
                    if (!permitida) {
                        mierror = "Comprueba la extensión de los archivos a subir. \nSólo se pueden subir archivos con extensiones: " + extensiones_permitidas.join();
                        alert(mierror);
                    } else {
                        //submito! 
                        alert("Todo correcto. Voy a submitir el formulario.");
                        formulario.submit();
                        return 1;
                    }
                }
                //si estoy aqui es que no se ha podido submitir 
                alert(mierror);
                return 0;
            }

            function validar() {
                var codprop = $("#codprop").val();
                var cliente = $("#combobox").val();
                var contacto = $("#contacto").val();
                var vendedor = $("#asesor").val();
                var monto = $("#monto").val();
                var zona = $("#zona").val();

                if (codprop === "") {
                    alert('Debe escribir nro de proopuesta');
                    $("#codprop").focus();
                    return false;
                } else if (cliente === "") {
                    alert('Debe seleccionar un cliente');
                    $("#combobox").focus();
                    return false;
                } else if (contacto === "") {
                    alert('Debe ingresar nombre de contacto');
                    $("#contacto").focus();
                    return false;
                } else if (monto === "0.0") {
                    alert('Ingrese monto mayor a 0.0');
                    $("#monto").focus();
                    return false;
                } else if (vendedor === "0") {
                    alert('Debe seleccionar un vendedor');
                    $("#asesor").focus();
                    return false;
                } else if (zona === "0") {
                    alert('Debe especificar una zona');
                    $("#zona").focus();
                    return false;
                }
                return true;
            }


            $(document).ready(function () {
                $("#form").submit(function (e) {
                    e.preventDefault();
                    var rpta = validar();
                    if (rpta === true) {
                        $("#cargando").html('<h2> <img src="img/iconos/loading.gif" width="25" height="25" alt="loading"/> Enviando datos...</h2>');
                        var nomcliente = $("#combobox option:selected").html();
                        var f = $(this);
                        var formData = new FormData(document.getElementById("form"));

                        formData.append("nomcliente", nomcliente);

//                    var word = this.validarWord();
//                    if(word === 1){
//                        alert("Archivo OK");
//                    }

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
                                    $("#result").html(res);
                                });
                    }
                });
            });
        </script>                
    </head>
    <body> 
        <div class="col-lg-12">
            <form id="form" name="form" action="#" method="post" enctype="multipart/form-data">
                <div id="etiqueta">   
                    <img src="img/iconos/Add.png" height="45px"/>   
                    <label>Crear Propuesta</label>
                </div>            
                <div class="panel panel-default">
                    <div class="panel-body" style="">
                        <div class="row">
                            <div class="col-lg-6" style="min-height: 500px;">
                                <div class="row">
                                    <div class="col-lg-3">
                                        Numero Propuesta <span class="obl">(*)</span>:
                                    </div>
                                    <div class="col-lg-5">
                                        <input required="" type = "text" name = "codprop" placeholder="" value = "" class="form-control input-sm" id="codprod" />
                                        <!--pattern="[A-Za-z]{0,9}"-->
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        Versión <span class="obl">(*)</span>:
                                    </div>
                                    <div class="col-lg-2">
                                        <input required="" min="1" type = "number" name = "version" placeholder="" value = "1" class="form-control input-sm" id="version" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        Fecha Envío a Cliente <span class="obl">(*)</span>:
                                    </div>
                                    <div class="col-lg-4">                                    
                                        <input type="text" required="" name="fecenvio" placeholder="fecha" value="<?php echo $hoy; ?>" class="form-control input-sm" id="cal2" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3"> 
                                        Cliente <span class="obl">(*)</span>:
                                    </div>
                                    <div class="col-lg-9"> 
                                        <select class="form-control input-sm" id="combobox"  name="codcliente">                                        
                                            <option value=""></option>
                                            <option value="nuevo">..::Crear Nuevo Cliente</option>
                                            <?php foreach ($lista as $valor) { ?>                                
                                                <option value="<?php echo $valor[0] ?>"> <?php echo trim($valor[1]); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        Contacto:
                                    </div>
                                    <div class="col-lg-9">
                                        <input type = "text" maxlength="50" name = "contacto" placeholder="contacto" value = "" class="form-control input-sm" id="contacto" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        Cultivo <span class="obl">(*)</span>:
                                    </div>                                
                                    <div class="col-lg-4">                                    
                                        <select class="form-control input-sm" id="cultivo"  name="cultivo" onchange="otroCultivo()" onblur="otroCultivo()">                                                                
                                            <?php foreach ($cultivo as $valor) { ?>                                
                                                <option value="<?php echo $valor['desele']; ?>"> <?php echo $valor['desele']; ?></option>
                                            <?php } ?>                                        
                                            <option value="SP">SOLO PRODUCTOS</option>
                                            <option value="otro">..::Nuevo Cultivo</option>
                                        </select>
                                    </div>
                                    <div id="divnewcultivo" class="col-lg-5" hidden="">                                    
                                        <input type="text" name="newcultivo" placeholder="Escribir cultivo" class="form-control input-sm" id="newcultivo" value="" />                                       
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        Ha <span class="obl">(*)</span>:
                                    </div>
                                    <div class="col-lg-3">
                                        <input type = "number" name = "ha" value="0.0" class="form-control input-sm" id="ha" step="any" />
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="checkbox" name="islts" id="pxp" value="SI" /> Por Volumen
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        Monto sin IGV <span class="obl">(*)</span>:
                                    </div>
                                    <div class="col-lg-3">
                                        <input type = "number" name = "monto" value="0.0" required="" class="form-control input-sm" id="monto" step="any" />
                                    </div>
                                    <div class="col-lg-2">
                                        <select name="moneda" id="moneda" class="form-control input-sm">
                                            <option value="$">$. DOLAR</option>
                                            <option value="S/.">S/. SOLES</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <select name="tprecio" id="tprecio" class="form-control input-sm">
                                            <option value="PUD">Precio Unitario con Dscto.</option>
                                            <option value="PAQ">Precio por Paquete</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        Descuento (%) aplicado a esta propuesta <span class="obl">(*)</span>:
                                    </div>
                                    <div class="col-lg-3">
                                        <input type = "number" name = "descuento" placeholder="" step="any" value = "0.0" class="form-control input-sm" id="descuento" />
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="checkbox" name="pxp" id="pxp" value="SI" /> Precio Por Producto
                                    </div>
                                </div>                           
                                <div class="row">
                                    <div class="col-lg-3"> 
                                        Vendedor <span class="obl">(*)</span>:
                                    </div>
                                    <div class="col-lg-9"> 
                                        <select class="form-control input-sm" id="asesor"  name="asesor" onchange="cargarCorreoVendedor()" onblur="cargarCorreoVendedor()">
                                            <option value="0">..::Seleccione::..</option>
                                            <?php foreach ($asesor as $valor) { ?>                                
                                                <option value="<?php echo $valor[0] ?>"> <?php echo $valor[1]; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        Elaborado por <span class="obl">(*)</span>:
                                    </div>
                                    <div class="col-lg-9">
                                        <input type = "text" name = "elaboradopor" placeholder="elaboradopor" value = "Kateryn Mendoza" class="form-control input-sm" id="elaboradopor" />
                                    </div>   
                                </div>                            
                                <div class="row">
                                    <div class="col-lg-3">
                                        Estado Aprobación <span class="obl">(*)</span>:
                                    </div>
                                    <div class="col-lg-2">
                                        <select name="aprobado" class="form-control input-sm">
                                            <option value="EN VENDEDOR">EN VENDEDOR</option>
                                            <option value="EN CLIENTE">EN CLIENTE</option>
                                            <option value="EN SEGUIMIENTO">EN SEGUIMIENTO</option>
                                            <option value="APROBADO">APROBADO</option>
                                            <option value="NO APROBADO">NO APROBADO</option>
                                        </select>
                                    </div>   
                                    <div class="col-lg-2">
                                        <input type="text" name="fecha" placeholder="fecha" value="<?php echo $hoy; ?>" class="form-control input-sm" id="cal" />
                                    </div> 
                                    <div class="col-lg-5">
                                        <input type="text" name="obsaprob" placeholder="Motivo" value="" class="form-control input-sm" />                                    
                                    </div> 

                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        Forma de Pago:
                                    </div>
                                    <div class="col-lg-4">
                                        <select name="fpago" id="fpago" class="form-control input-sm">
                                            <option value=""></option>
                                            <option value="CONTADO">CONTADO</option>
                                            <option value="CONTRA ENTREGA">CONTRA ENTREGA</option>
                                            <option value="FACTURA 10 DIAS">FACTURA 10 DIAS</option>
                                            <option value="FACTURA 15 DIAS">FACTURA 15 DIAS</option>
                                            <option value="FACTURA 30 DIAS">FACTURA 30 DIAS</option>
                                            <option value="FACTURA 30/60 DIAS">FACTURA 30/60 DIAS</option>
                                            <option value="FACTURA 45 DIAS">FACTURA 45 DIAS</option>
                                            <option value="FACTURA 60 DIAS">FACTURA 60 DIAS</option>
                                            <option value="FACTURA 90 DIAS">FACTURA 90 DIAS</option>
                                            <option value="FACTURA 120 DIAS">FACTURA 120 DIAS</option>
                                            <option value="LETRA 30">LETRA 30</option>
                                            <option value="LETRA 60">LETRA 60</option>
                                            <option value="LETRA 85/92/99/106/113/120">LETRA 85/92/99/106/113/120</option>
                                            <option value="LETRA 90">LETRA 90</option>
                                            <option value="LETRA 100">LETRA 100</option>
                                            <option value="LETRA 110/120">LETRA 110/120</option>
                                            <option value="LETRA 120">LETRA 120</option>                                        
                                            <option value="LETRA 140">LETRA 140</option>
                                            <option value="LETRA 145">LETRA 145</option>
                                            <option value="LETRA 150">LETRA 150</option>
                                            <option value="LETRA 180">LETRA 180</option>
                                            <option value="LETRA 30/60/120">LETRA 30/60/120</option>
                                            <option value="LETRA 30/90/120">LETRA 30/90/120</option>
                                            <option value="LETRA 120/150">LETRA 120/150</option>                                                                                
                                        </select>
                                    </div>
                                    <div class="col-lg-1">Interes %</div>
                                    <div class="col-lg-2"><input min="0" type="number" class="form-control input-sm" name="interes" value="0" /></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        Especificar Zona:
                                    </div>
                                    <div class="col-lg-3"> 
                                        <select class="form-control input-sm" id="zona"  name="zona" onchange="mostrarLugares()">
                                            <option value="0">..::Seleccione::..</option>
                                            <?php foreach ($listcatzona as $catzona) { ?>                                
                                                <option value="<?php echo $catzona['codele'] ?>"> <?php echo $catzona['desele']; ?></option>
                                            <?php } ?>
                                            <option value="NN">Otro</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3" id="divlugar"> 
                                        <select class="form-control input-sm" id="lugar"  name="lugar">
                                            <option value="0">..::Seleccione Lugar::..</option>
                                        </select>
                                    </div>

                                </div>


                                <div class="row">
                                    <div class="col-lg-3">
                                        Observaciones
                                    </div>
                                    <div class="col-lg-9">
                                        <textarea name="obs" id="obs" rows="4" cols="20" class="form-control"></textarea>
                                    </div> 
                                </div>

                                <div class="row">
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-9">
                                        <?php if ($_SESSION['usuario'] == 'JLP' || $_SESSION['usuario'] == 'CSA') { ?>
                                            <span>Es prueba? </span><input type="text" name="prueba" id="prueba" value="SI" />
                                            <br/><br/>
                                        <?php } else { ?>
                                            <input type="hidden" name="prueba" id="prueba" value="NO" />
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3" style="background-color: #f2f2f2; padding: 10px; min-height: 500px;">
                                <div class="col-lg-12">
                                    <br/>Subir Propuesta en PDF:                                 
                                    <input class="" type="file"  name="pdf" id="imagen1" value="" /> <br/>                                
                                </div>
                                <div class="col-lg-12">
                                    <br/>Subir Propuesta en Word:                                 
                                    <input class="" type="file"  name="word" id="imagen1" value="" /> <br/>                                
                                </div>
                                <div class="col-lg-12">
                                    <br/>Subir Propuesta en Excel:                                 
                                    <input class="" type="file"  name="excel" id="imagen1" value="" /> <br/>                                
                                </div>
                                <div class="col-lg-12">
                                    <br/>Subir Orden de Compra:
                                    <input class="" type="file"  name="guiaoc" id="imagen1" value="" /> <br/>                                
                                </div>
                                <div class="col-lg-12">
                                    <br/>Subir Factura:
                                    <input class="" type="file"  name="factura" id="imagen1" value="" /> <br/>                                
                                </div>
                                <div class="col-lg-12">
                                    <br/>Subir Guia de Remision:
                                    <input class="" type="file"  name="remision" id="imagen1" value="" /> <br/>                                
                                </div>

                            </div>
                            <div class="col-lg-3">
                                <div class="row">
                                    <div class="col-lg-6"> Enviar mensaje a vendedor:</div>
                                    <div class="col-lg-6"> 
                                        <select name="enviarmail" id="enviarmail" class="form-control input-sm" onchange="mostrarFormMsj()">                                        
                                            <option value="SI">SI</option>
                                            <option value="NO">NO</option>
                                        </select>                                    
                                    </div>
                                </div>
                                <div class="row" id="divsendmail">
                                    <div class="col-lg-12">
                                        <div class="panel panel-primary" style="background: whitesmoke; font-size: 0.8em;">
                                            <div class="panel-heading">
                                                Enviar Correo
                                            </div>
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-lg-3">Tu Nombre: </div>
                                                    <div class="col-lg-9"><input type="text" class="form-control input-sm" name="mailnom" id="mailnom" value="<?php echo $_SESSION['nombreUsuario']; ?>" placeholder="Anonimo" /></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3">Tu Correo: </div>
                                                    <div class="col-lg-9"><input type="email" class="form-control input-sm" name="mailde" id="mailde" value="<?php echo $_SESSION['email_usuario']; ?>" placeholder="tucorreo@ejemplo.com" /></div>
                                                </div>
                                                <div class="row" id="divmailpara">
                                                    <div class="col-lg-3">Para: </div>
                                                    <div class="col-lg-9">                                                                                                                                                               
                                                        <input type="email" id="mailpara" class="form-control input-sm"  name="mailpara" value="" placeholder="usuario1@ejemplo.com; usuario2@ejemplo.com" />                                            
                                                    </div>                           
                                                </div>                                    
                                                <div class="row">
                                                    <div class="col-lg-3">Mensaje: </div>
                                                    <div class="col-lg-9">                            
                                                        <textarea placeholder="Escriba un Mensaje" class="form-control" id="mailmsj" name="mailmsj" rows="4" cols="20"></textarea>
                                                    </div>
                                                </div>                                                            
                                            </div>                                
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6"> Deseas crear Despacho:</div>
                                    <div class="col-lg-6"> 
                                        <select name="creardesp" id="creardesp" class="form-control input-sm" onchange="mostrarRegDespacho()">
                                            <option value="NO">NO</option>
                                            <option value="SI">SI</option>
                                        </select>                                    
                                    </div>
                                </div>
                                <div class="row" id="divregdesp" hidden="">
                                    <div class="col-lg-12">
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
                                                        <input type="text" name="fecprev" id="cal" class="form-control input-sm" value="<?php echo $hoy; ?>" />
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
                                                        <select name="monedadesp" id="moneda" class="form-control input-sm">
                                                            <option value="$">$. DOLAR</option>
                                                            <option value="S/.">S/. SOLES</option>
                                                        </select>
                                                    </div>                                
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">Descripción:
                                                        <input type="text" maxlength="90" name="descripcion" class="form-control input-sm" value="" />
                                                    </div>
                                                    <div class="col-lg-12">Observación:
                                                        <textarea class="form-control" name="obsdesp" rows="4" cols="5"></textarea>
                                                    </div>
                                                </div>                                                                                                    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="cargando"></div>
                            </div>
                        </div>
                        <div class="row" style="text-align: center">
                            <a href="#" onclick="cargar('#principal', '_propuestav1.php')" class="btn btn-danger">Regresar</a>
                            <input type="submit" value="Guardar" class="btn btn-success" />
                            <input type="hidden" id="accion" name="accion" value="RegPropuesta" />
                        </div>

                    </div>                
                </div>                       
            </form>
            <br/>
            <p><div id="result"></div>

            <script src="autocompleteboot/js/bootstrap.js" type="text/javascript"></script>
            <script src="autocompleteboot/js/bootstrap-combobox.js" type="text/javascript"></script>
            <script type="text/javascript">
                                //<![CDATA[
                                $(document).ready(function () {
                                    $('#combobox').combobox();
                                });
                                //]]>
            </script>
        </div>
    </body>
</html>