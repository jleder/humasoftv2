<?php
@session_start();
if ($_SESSION["conectado"] == 'SI') {
    date_default_timezone_set("America/Bogota");
    include_once '../controller/C_Solicitud.php';
    $sol = new C_Solicitud();
    $pro = new C_Propuesta();

    $codprop = $_GET['cod'];
    $pro->__set('codprop', $codprop);
    $propuesta = $pro->getPropuestasxAprobGerenteByCod();
    $detitem = $pro->getItemByCodProp();

    $pro->__set('codcliente', $propuesta[1]);
    $factores = $pro->getLast5Factores();

    $cultivo = $sol->listarCultivos();
    $efenologica = $pro->getEtapaFenologica();
    $asesor = $pro->listarAsesores();
    $listcatzona = $pro->listar_catzona();

    function ordenarCarrito($datos) {
        //ordenar array
        foreach ($datos as $clave => $fila) {
            $categoria[$clave] = $fila['ordenta'];
            $producto[$clave] = $fila['ordenprod'];
        }
        array_multisort($categoria, SORT_ASC, $producto, SORT_ASC, $datos);
        return $datos;
    }
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />     
            <style>
                .row { margin-top: 5px;}
                .obl { font-weight: bolder; color: red; } 
                .numericos { padding: 2px; width: 70%; height: 23px; }
                .txtnum { width: 100px; }         
                .mas {float: left; text-align: center; min-height: 45px; display: flex; align-items: center; margin-left: 3px; margin-right: 3px;}
                .cuadrito { font-size: 0.9em; text-align: center; width: auto; min-height: 45px; height: auto; background-color: #e8e8e8; padding: 5px 3px 5px 3px; margin-left: 5px; margin-right: 5px; float: left; display: flex; align-items: center; border-color: #000000; border-style: ridge; border-width: 1px; }
                .cuadront { float: left; min-height: 45px;}
                .cuadrito2 { font-size: 0.9em; text-align: center; border-style: double; border-width: 1px; border-color: #000; padding: 3px; }

                .cuadro_two { float: left; height: 80px; width: 90px; background-color: #e2e2e2; align-items: center; padding-top: 10px; }
                .cuadro_one {float: left; padding: 5px; height: 125px; width: 100px; background-color:  #666666; margin-right: 10px; }

            </style>  
            <!--calendario-->        
            <script type="text/javascript" src="js/js_inscoltec.js"></script>      
            <script type="text/javascript" src="js/fAjax.js"></script>
            <script type="text/javascript" src="js/jquery-3.1.0.min.js"></script>      
            <link rel="stylesheet" type="text/css" href="css/bootstrap.css">                    

            <script type="text/javascript">

                function validar() {
                    var codprop = $("#codpropold").val();
                    var cliente = $("#combobox").val();
                    if (codprop === "") {
                        alert('Debe escribir nro de proopuesta');
                        $("#codprop").focus();
                        return false;
                    } else if (cliente === "") {
                        alert('Debe seleccionar un cliente');
                        $("#combobox").focus();
                        return false;
                    }
                    return true;
                }



                $(document).ready(function () {
                    $("#form").submit(function (e) {
                        e.preventDefault();
                        var rpta = validar();
                        if (rpta === true) {
                            var f = $(this);
                            var formData = new FormData(document.getElementById("form"));
                            var aprobar = $("#estadoaprob").val();
                            var codcliente = $("#combobox").val();
                            var nomcliente = $("#combobox option:selected").text();
                            var cultivo = $("#cultivo option:selected").text();
                            var zona = $("#zona option:selected").text();

                            formData.append("estadoaprob", aprobar);
                            formData.append("codcliente", codcliente);
                            formData.append("nomcliente", nomcliente);
                            formData.append("cultivo", cultivo);
                            formData.append("zona", zona);
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
                function setPorcentajes(dscto, costototal, corredor) {
                    var inicio = parseFloat(dscto) - 5;
                    var fin = parseFloat(dscto) + 5;
                    var i = 0;
                    while (inicio <= fin) {
                        $("#lbl" + corredor + i).html(inicio);
                        i++;
                        inicio++;
                    }

                    var home = parseFloat(dscto) - 5;
                    var end = parseFloat(dscto) + 5;
                    var j = 0;
                    var monto = 0;
                    while (home <= end) {

                        var porcent = (1 - (parseFloat(home) / 100));
                        monto = (parseFloat(costototal) * parseFloat(porcent));
                        //alert("monto: "+monto);                            
                        $("#monto" + corredor + j).html(monto.toFixed(2));
                        if (parseFloat(home) === parseFloat(dscto)) {
                            $("#preambt" + corredor).val(monto.toFixed(2));
                            $("#preambtshow" + corredor).val(monto.toFixed(2));
                        }
                        j++;
                        home++;
                    }

                    //var precioAMBT = $("#preambt" + corredor).val();                        
                    //var precioTotalE = $("#pretotalE" + corredor).html();
                    //setFactor(precioAMBT, precioTotalE, corredor);
                }

                function setdscto(corredor) {
                    var dscto = $("#dscto" + corredor).val();
                    var costototal = $("#costototal" + corredor).val(); //precio sin descuento                                                
                    setPorcentajes(dscto, costototal, corredor);
                    actualizarTabla(corredor);
                }

                function actualizarTabla(corredor) {

                    var coditem = $("#pv2_coditem" + corredor).val();
                    var ha = $("#pv2_ha" + corredor).val();
                    var dscto = $("#dscto" + corredor).val();
                    var div = 'divtable' + corredor;
                    var item = [coditem, ha];
                    from_3(dscto, corredor, item, div, '_propuestav2_aprob02_verweb_tbl.php');
                }

                function setmonto() {
                    var preambt = $("#preambt").val();
                    var costototal = $("#costototal").html();
                    var perc = 100 * (parseFloat(preambt) / parseFloat(costototal));
                    $("#dscto").val(perc.toFixed(2));
                    var dscto = perc.toFixed(2);
                    setPorcentajes(dscto, costototal);
                }

                function loadObs(estado, corredor) {

                    if (estado === 'APROBADO') {
                        $("#estadoitem" + corredor).val("APROBADO");
                        $("#divobs" + corredor).css("display", "none");
                        $("#modificado" + corredor).val("F");
                        $("#obstext" + corredor).html("Usted seleccionó: Aprobar Tal Como Está.");
                    } else if (estado === 'APROBADO CON CAMBIOS') {
                        $("#divobs" + corredor).css("display", "block");
                        $("#estadoitem" + corredor).val("APROBADO");
                        $("#modificado" + corredor).val("T");
                        $("#obstext" + corredor).html("Usted seleccionó: APROBAR CON CAMBIOS.");
                    } else if (estado === 'NO APROBADO') {
                        $("#divobs" + corredor).css("display", "block");
                        $("#estadoitem" + corredor).val("NO APROBADO");
                        $("#modificado" + corredor).val("F");
                        $("#obstext" + corredor).html("Usted seleccionó: NO APROBADO.");
                    }
                }

                function insert_comentario(coditem, corredor) {
                    var codprop = $("#codprop").val();
                    var coditem = coditem;
                    var comentario = $("#comentario" + corredor).val();
                    var divcomentario = 'divcomentario' + corredor;
                    if (comentario !== '') {
                        from_3(codprop, coditem, comentario, divcomentario, '_propuestav2_coment_reg.php');
                    } else {
                        alert("Debe ingresar un comentario.");
                        $("#comentario" + corredor).focus();
                    }
                    location.reload();
                }

                var formatNumber = {
                    separador: ",", // separador para los miles
                    sepDecimal: '.', // separador para los decimales
                    formatear: function (num) {
                        num += '';
                        var splitStr = num.split('.');
                        var splitLeft = splitStr[0];
                        var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
                        var regx = /(\d+)(\d{3})/;
                        while (regx.test(splitLeft)) {
                            splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
                        }
                        return this.simbol + splitLeft + splitRight;
                    },
                    new : function (num, simbol) {
                        this.simbol = simbol || '';
                        return this.formatear(num);
                    }
                };

                function actualizarTabla2(a) {
                    //a = corredor item                    

                    var litrosxha = 0;
                    var ptotal = 0;
                    var subtotal = 0;
                    var total = 0;
                    var ptotalE = 0;

                    var ncar = $("#ncar" + a).val();
                    var ha = $("#pv2_ha" + a).val();
                    var dcto = $("#pv2_descuento" + a).val();
                    var pud = $("#pv2_pud" + a).val();
                    var emi = 0; //emi Precio E - Monto o Importe Total
                    var fag = 0; //factor aprobación gerente
                    var fau = 0; //factor aprobación usuario
                    var precxha = 0;


                    for (var i = 0; i < ncar; i++) {

                        //ENTRADA
                        var litros = $("#litros" + a + i).val();
                        var precioA = $("#precio" + a + i).val();
                        var preciodcto = $("#preciodcto" + a + i).val();
                        var precioE = $("#precioEE" + a + i).val();

                        //CALCULOS
                        litrosxha = (parseFloat(litros) * parseFloat(ha));
                        ptotalE += (parseFloat(precioE) * litrosxha);
                        if (pud === 't') {
                            ptotal = (parseFloat(litrosxha) * parseFloat(preciodcto));
                        } else if (pud === 'f') {
                            ptotal = (parseFloat(litrosxha) * parseFloat(precioA));
                        }

                        //SALIDA                                                
                        subtotal += parseFloat(ptotal);
                        $("#verltsxha" + a + i).val(litrosxha.toFixed(2));
                        $("#vercostototal" + a + i).html(parseFloat(ptotal.toFixed(2)));

                        $("#ltsxha" + a + i).val(litrosxha);
                        $("#costototal" + a + i).html(parseFloat(ptotal));
                    }

                    //**** CALCULOS

                    //CALCULAR PRECIO TOTAL                    
                    if (pud === 'f') {
                        total = (parseFloat(subtotal) * (100 - (parseFloat(dcto)))) / 100;
                    } else {
                        total = parseFloat(subtotal);
                    }



                    //CALCULAR FACTOR DE APROBACIÓN
                    if (ptotalE > 0) {
                        emi = parseFloat(total) - parseFloat(ptotalE);
                        fag = (parseFloat(emi) / parseFloat(ptotalE)) * 100;
                        fau = parseFloat(fag) - 25;
                    } else {
                        emi = parseFloat(total) - parseFloat(ptotalE);
                        fag = (parseFloat(emi) / parseFloat(ptotalE)) * 100;
                        fau = parseFloat(fag) - 25;
                        alert("Uno de los productos carece de precio E. Contactar con el Gerente");
                    }



                    if (ha > 1) {
                        precxha = parseFloat(total) / parseFloat(ha);
                        $("#verprecxha" + a).html(parseFloat(precxha.toFixed(2)));
                    }

                    //SALIDAS                                        
                    $("#phgsubtotal" + a).html(parseFloat(subtotal.toFixed(2)));
                    $("#verprecioambt" + a).html(parseFloat(total.toFixed(2)));
                    $("#precioambt" + a).val(parseFloat(total));
                    $("#verfau" + a).html(parseFloat(fau.toFixed(2)));
                    $("#pv2_fa" + a).val(parseFloat(fau));
                    $("#precio_totalE" + a).val(parseFloat(ptotalE));
                }
            </script>                
        </head>
        <body>            
            <div class="container">
                <form id="form" name="form" action="#" method="post" enctype="multipart/form-data">
                    <p style="text-align: right;">
                        <input type = "hidden" name = "codprop" placeholder="" value = "<?php echo $propuesta[0]; ?>" class="" id="codprop" />
                    </p>
                    <div class="row">
                        <div class="col-lg-3">
                            Número Propuesta <span class="obl">(*)</span>:
                            <input required="" type = "text" name = "codprop" placeholder="" value = "<?php echo $propuesta[0]; ?>" class="form-control input-sm" id="codprop" />
                            <input type = "hidden" name = "codpropold" value = "<?php echo $propuesta[0]; ?>" id="codpropold" />
                        </div>
                        <div class="col-lg-6">
                            Cliente <span class="obl">(*)</span>:
                            <input type = "hidden" name = "codclienteold" value = "<?php echo $propuesta[1]; ?>" id="codclienteold" />
                            <select class="form-control input-sm" id="combobox"  name="codcliente">
                                <option value="<?php echo $propuesta[1]; ?>"><?php echo $propuesta[2]; ?></option>
                                <option value="nuevo">..::Crear Nuevo Cliente</option>
                                <?php foreach ($lista as $valor) { ?>                                
                                    <option value="<?php echo $valor[0] ?>"> <?php echo trim($valor[1]); ?></option>
                                <?php } ?>
                            </select>
                        </div>                                            
                    </div>
                    <div class="row">

                        <div class="col-lg-2">
                            Cultivo:                                    
                            <select class="form-control input-sm" id="cultivo"  name="cultivo">
                                <option value="<?php echo '0,' . trim($propuesta[10]); ?>"><?php echo trim($propuesta[10]); ?></option>
                                <option value="0">Cambiar por...</option>                                                                                
                                <?php foreach ($cultivo as $valor) { ?>                                
                                    <option value="<?php echo trim($valor['codele']) . ',' . trim($valor['desele']); ?>"> <?php echo trim($valor['desele']); ?></option>
                                <?php } ?>
                                <option value="otro">..::Otro Cultivo</option>
                            </select>
                        </div>
                        <div id="divnewcultivo" class="col-lg-2" hidden="">
                            Nuevo Cultivo:
                            <input type="text" name="newcultivo" maxlength="50" placeholder="Escribir Cultivo" class="form-control input-sm" id="newcultivo" value="" />                                           
                        </div>
                        <div class="col-lg-2" id="divvariedad">
                            Variedad:                                    
                            <input type="text" name="variedad" maxlength="50" placeholder="Escribir Variedad" class="form-control input-sm" id="variedad" value="<?php echo trim($propuesta[11]); ?>" />
                        </div>
                        <div id="divnewvariedad" class="col-lg-2" hidden="">
                            Nueva Variedad:
                            <input type="text" name="newvariedad" maxlength="50" placeholder="Escribir Variedad" class="form-control input-sm" id="newvariedad" value="" />
                        </div>                                
                        <div class="col-lg-2">
                            Etapa Fenologica:                                                                                                            
                            <select class="form-control input-sm" id="efenologica"  name="efenologica">
                                <option value="<?php echo trim($propuesta[12]); ?>"><?php echo trim($propuesta[12]); ?></option>
                                <option value="0">cambiar por...</option>
                                <?php foreach ($efenologica as $etapa) { ?>                                
                                    <option value="<?php echo trim($etapa['desele']); ?>"> <?php echo trim($etapa['desele']); ?></option>
                                <?php } ?>
                                <option value="otro">otra...</option>
                            </select>
                        </div>
                        <div id="divnewefenologica" class="col-lg-2" hidden="">
                            Nueva Etapa:
                            <input type="text" name="newefenologica" maxlength="50" placeholder="Escribir Etapa" class="form-control input-sm" id="newefenologica" value="" />
                        </div>
                        <div class="col-lg-3">
                            Forma de Pago:                                                                                                            
                            <select class="form-control input-sm" id="fpago"  name="fpago">
                                <option value="<?php echo $propuesta[18]; ?>"><?php echo $propuesta[18]; ?></option>
                                <option value="<?php echo $propuesta[18]; ?>">cambiar por...</option>
                                <option value="A TRATAR">A TRATAR</option>
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
                    </div>
                    <div class="row">                                
                        <div class="col-lg-8">
                            Asunto:
                            <input required="" type = "text" name="asunto" value = "<?php echo trim($propuesta[6]); ?>" class="form-control input-sm" id="asunto" />
                        </div>
                        <div class="col-lg-4">
                            Contactos:
                            <input required="" type = "text" name="contacto" value = "<?php echo trim($propuesta[5]); ?>" class="form-control input-sm" id="contacto" placeholder="Ing. Juan Perez e Ing. Carlos Lopez" />
                        </div>
                    </div>
                    <div class="row">                                
                        <div class="col-lg-3">
                            Vendedor:
                            <select class="form-control input-sm" id="vendedor"  name="vendedor">
                                <option value="<?php echo trim($propuesta[8]); ?>"><?php echo trim($propuesta[8]); ?></option>
                                <option value="0">cambiar por...</option>                                
                                <?php foreach ($asesor as $valor) { ?>                                
                                    <option value="<?php echo $valor[0] ?>"> <?php echo $valor[1]; ?></option>
                                <?php } ?>
                                <option value="Venta Directa">Venta Directa</option>
                                <option value="Asesor Externo">Asesor Externo</option>
                            </select>
                        </div>                        
                        <div class="col-lg-3">
                            Zona
                            <select class="form-control input-sm" id="zona"  name="zona" onchange="mostrarLugares()">
                                <option value="<?php echo trim($propuesta[13]); ?>"><?php echo trim($propuesta[13]); ?></option>
                                <option value="0">cambiar por...</option>
                                <?php foreach ($listcatzona as $catzona) { ?>                                
                                    <option value="<?php echo $catzona['codele'] ?>"> <?php echo $catzona['desele']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            Lugar
                            <input type="text" name="lugar" id="lugar" class="form-control input-sm" value="<?php echo $propuesta[14]; ?>" />
                        </div>
                        <div class="col-lg-3">
                            Demo
                            <select class="form-control input-sm" id="demo"  name="demo">
                                <option value="<?php echo $propuesta[15]; ?>"><?php echo $propuesta[15]; ?></option>
                                <option value="<?php echo $propuesta[15]; ?>">cambiar por...</option>
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            Texto de Propuesta:
                            <textarea name="obs" id="obs" rows="3" cols="20" class="form-control"><?php echo trim($propuesta[3]); ?></textarea>
                        </div>                                
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            Observaciones para Aprobación: (Esta información será vista solo por el Gerente)
                            <textarea class="form-control input-sm" name="obs_atec" id="obs_atec" rows="3"><?php echo $propuesta[17]; ?></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">                                
                            <p style="background-color: whitesmoke; padding: 10px; color: blue;">Últimos FACTORES DE APROBACIÓN de este CLIENTE.</p>
                            <?php
                            if (count($factores) > 0) {
                                ?>
                                <table class="table table-striped" style="font-size: 11px;">
                                    <tbody>
                                        <tr style="">
                                            <td>Fecha: </td>
                                            <td>Propuesta: </td>
                                            <td>Factor: </td>
                                        </tr>
                                        <?php
                                        foreach ($factores as $valfactor) {
                                            $fecreg = date("d/m/Y", strtotime($valfactor['fecreg']));
                                            echo '<tr>';
                                            echo '<td>' . $fecreg . '</td>';
                                            echo '<td>' . $valfactor['codprop'] . '</td>';
                                            echo '<td>' . $valfactor['fa'] . '</td>';
                                            echo '</tr>';
                                        }
                                        ?>                                                            
                                    </tbody>
                                </table>
                                <?php
                            } else {
                                echo '<p style="color: red">Este cliente aún no posee FACTORES DE APROBACIÓN.</p>';
                            }
                            ?>
                        </div>
                    </div>



                    <?php
                    //RECORRER ITEM
                    $ndetitem = count($detitem);
                    $_SESSION['itemcar'] = $detitem;
                    $corredor = 0;

                    if ($ndetitem > 0) {
                        foreach ($detitem as $item) {

                            $ha = $item['ha'];
                            $nitrogeno = $item['nitrogeno'];
                            $pud = $item['pud']; //precio unitario descuento
                            $pup = $item['pup']; //precio unnitario producto
                            $plantilla = $item['plantilla'];
                            $coditem = $item['coditem'];
                            ?>
                            <div id="divitem" style="box-shadow: 0px 0px 1px black;">
                                <!--parametros ocultos de item  pv2 = propuesta version 2-->                                                                
                                <input type="hidden" name="ndetitem" value="<?php echo $ndetitem; ?>" />
                                <input type="hidden" name="coditem<?php echo $corredor; ?>" value="<?php echo $item['coditem']; ?>" />                                                                
                                <input type="hidden" id="pv2_nitrogeno<?php echo $corredor; ?>" name="pv2_nitrogeno<?php echo $corredor; ?>" value="<?php echo $item['nitrogeno']; ?>" />
                                <input type="hidden" name="pv2_plantilla<?php echo $corredor; ?>" value="<?php echo $item['plantilla']; ?>" />
                                <input type="hidden" id="pv2_pud<?php echo $corredor; ?>" name="pv2_pud<?php echo $corredor; ?>" value="<?php echo $item['pud']; ?>" />
                                <input type="hidden" name="pv2_estado<?php echo $corredor; ?>" value="<?php echo $item['estado']; ?>" />
                                <input type="hidden" name="pv2_modificado<?php echo $corredor; ?>" value="<?php echo $item['modificado']; ?>" />
                                <!--fin de parametros ocultos-->                                    

                                <div style="background-color: #000000; color: white; padding: 3px;">
                                    <h4 style=""><?php echo 'Item ' . ($corredor + 1) . ': ' . $item['itemdesc']; ?></h4>
                                    <input type="hidden" name="pv2_itemdesc<?php echo $corredor; ?>" value="<?php echo $item['itemdesc']; ?>" />
                                </div>
                                <div style="padding: 5px">  
                                    <?php if ($pup <> 't') { ?>
                                        <div class="row">
                                            <div class="col-md-3">Descuento</div>
                                            <div class="col-md-2">                                                                                        
                                                <?php
                                                if ($item['pud'] == 't') {
                                                    echo $item['descuento'];
                                                    ?>
                                                    <input type="hidden" id="pv2_descuento<?php echo $corredor; ?>" name="pv2_descuento<?php echo $corredor; ?>" value="<?php echo $item['descuento']; ?>" />
                                                    <?php
                                                } else {
                                                    ?>
                                                    <input type="number" step="any" id="pv2_descuento<?php echo $corredor; ?>" name="pv2_descuento<?php echo $corredor; ?>" value="<?php echo $item['descuento']; ?>" />                                                
                                                    <!--<a class="btn btn-default btn-sm" href="#">Calcular</a>-->
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="col-md-3">Hectareas</div>
                                            <div class="col-md-2">                                                                                                                                    
                                                <input type="number" id="pv2_ha<?php echo $corredor; ?>" name="pv2_ha<?php echo $corredor; ?>" value="<?php echo $item['ha']; ?>" />
                                            </div>
                                            <div class="col-md-3">Precion Convencional Confirmado</div>
                                            <div class="col-md-2">
                                                <input type="number" id="pv2_pcc<?php echo $corredor; ?>" name="pv2_pcc<?php echo $corredor; ?>" value="<?php echo $item['pcc']; ?>" />
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="col-md-3">Precion Convencional Aproximado</div>
                                            <div class="col-md-2">
                                                <input type="number" id="pv2_pca<?php echo $corredor; ?>" name="pv2_pca<?php echo $corredor; ?>" value="<?php echo $item['pca']; ?>" />
                                            </div>
                                        </div>
                                    <?php } else { ?>

                                        <div class="row">
                                            <div class="col-md-3">Hectareas</div>
                                            <div class="col-md-2">                                                                                                                                    
                                                <input type="number" id="pv2_ha<?php echo $corredor; ?>" name="pv2_ha<?php echo $corredor; ?>" value="<?php echo $item['ha']; ?>" />
                                            </div>
                                        </div>
                                        <div class="row">                                    
                                            <input type="hidden" id="pv2_descuento<?php echo $corredor; ?>" name="pv2_descuento<?php echo $corredor; ?>" value="<?php echo $item['descuento']; ?>" />
                                            <div class="col-md-3">Precion Convencional Confirmado</div>
                                            <div class="col-md-2">
                                                <input type="number" id="pv2_pcc<?php echo $corredor; ?>" name="pv2_pcc<?php echo $corredor; ?>" value="<?php echo $item['pcc']; ?>" />
                                            </div>
                                            <div class="col-md-3">Precion Convencional Aproximado</div>
                                            <div class="col-md-2">
                                                <input type="number" id="pv2_pca<?php echo $corredor; ?>" name="pv2_pca<?php echo $corredor; ?>" value="<?php echo $item['pca']; ?>" />
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div id="divtable<?php echo $corredor; ?>">
                                        <div class="row">
                                            <div class="col-lg-12">                                                                                             
                                                <p>Análisis Económico:</p>


                                                <?php
                                                //Crear Carrito.
                                                $carrito = array();

                                                $pro->__set('coditem', $coditem);
                                                $detproductos = $pro->getDetallePropxAprobGerenteByCodProp();

                                                //RECORRER DETALLE DE PRODUCTOS
                                                foreach ($detproductos as $producto) {

                                                    $codigo = $producto['codprod'];
                                                    $precio = $producto['costo'];
                                                    $preciodcto = $producto['preciodcto'];

                                                    $taplicacion = trim($producto['taplicacion']);
                                                    $ordenta = trim($producto['ordenta']);
                                                    $litros = $producto['cantidad'];
                                                    $congelado = $producto['congelado'];


                                                    $pro->__set('codprod', $codigo);
                                                    $getproducto = $pro->getProdxPrecioByCod();

                                                    if ($getproducto) {
                                                        $orden = $getproducto[0]['orden'];
                                                        $catprod = $getproducto[0]['codcate'];
                                                        $nomcate = $getproducto[0]['desele'];
                                                        $codprod = $getproducto[0]['codigo'];
                                                        $nomprod = $getproducto[0]['nombre'];
                                                        $umedida = $getproducto[0]['umedida'];

                                                        $precioA = $getproducto[0]['precio'];
                                                        $precioB = $getproducto[1]['precio'];
                                                        $precioC = $getproducto[2]['precio'];
                                                        $precioD = $getproducto[3]['precio'];
                                                        $precioE = $getproducto[4]['precio'];

                                                        //$indice = array_search(trim($codigo), array_column($carrito, 'codprod'));
                                                        //if (strlen($indice) != '') {   // ME PASE HORAS INVESTIGANDO COMO HACER QUE EL CERO NO TE TOME COMO VACIO "". SOLUCION UTILIZAR = strlen
                                                        //} else {
                                                        array_push($carrito, array('ordenta' => $ordenta, 'taplicacion' => $taplicacion, 'ordenprod' => $orden, 'codprod' => trim($codprod), 'nomprod' => $nomprod, 'umedida' => $umedida, 'precioA' => $precioA, 'precioB' => $precioB, 'precioC' => $precioC, 'precioD' => $precioD, 'precioE' => $precioE, 'precio' => $precio, 'preciodcto' => $preciodcto, 'cantidad' => $litros, 'congelado' => $congelado));
                                                        //}
                                                    }
                                                }

                                                $arrr = ordenarCarrito($carrito);
                                                $carrito = $arrr;

                                                $vectorund = $pro->getUnidades();
                                                $aplicaciones = array_unique(array_column($carrito, 'taplicacion'));

                                                $_SESSION['itemtbl' . $corredor] = $item;
                                                $_SESSION['vectorund' . $corredor] = $vectorund;
                                                $_SESSION['carrito' . $corredor] = $carrito;
                                                $ncar = count($carrito);

                                                /* echo '<pre>';
                                                  print_r($item);
                                                  echo '</pre>';
                                                 */
                                                //Mostrando los tipos de aplicaciones
                                                $napp = 0;
                                                foreach ($aplicaciones as $app) {
                                                    $nomapp = $app;
                                                    $novo_texto = wordwrap($nomapp, 10, "<br />\n");
                                                    //echo "$novo_texto\n";

                                                    if ($napp == 0) {
                                                        if ($novo_texto == trim('FERTIRRIEGO')) {
                                                            if (count($vectorund)) {
                                                                foreach ($vectorund as $valund) {
                                                                    if ($valund['codnut'] == 'N' && $nitrogeno == 'no') {
                                                                        echo '<div class="cuadront"><div class="cuadrito2"><strong>' . $valund['codnut'] . '</strong></div><div class="cuadrito2">' . $valund['unidad'] . '</div></div>';
                                                                        echo '<div class="mas">/</div>';
                                                                    } elseif ($valund['codnut'] == 'N' && $nitrogeno == '50') {
                                                                        echo '<div class="cuadront"><div class="cuadrito2"><strong>' . $valund['codnut'] . '</strong></div><div class="cuadrito2">' . $valund['unidad'] . '</div></div>';
                                                                        echo '<div class="mas">50%</div>';
                                                                    } else {
                                                                        echo '<div class="cuadront"><div class="cuadrito2"><strong>' . $valund['codnut'] . '</strong></div><div class="cuadrito2">' . $valund['unidad'] . '</div></div>';
                                                                    }
                                                                }
                                                            }
                                                        } else {
                                                            echo '<div class="cuadrito">' . $novo_texto . '</div>';
                                                        }
                                                    } else {
                                                        echo '<div class="mas">+</div><div class="cuadrito">' . $novo_texto . '</div>';
                                                    }
                                                    $napp++;
                                                }
                                                ?>
                                                <br/><br/><br/><br/>
                                                <input type="hidden" name="ncar<?php echo $corredor; ?>" id="ncar<?php echo $corredor; ?>" value="<?php echo $ncar; ?>" />
                                                <?php
                                                if ($plantilla == "HECTAREA PAQ") {


                                                    if ($pup == 't') {

                                                        $costo_total = 0;
                                                        $costo_totalA = 0;
                                                        $costo_totalE = 0;

                                                        $precio_total = 0;
                                                        $precio_totalA = 0;
                                                        $precio_totalB = 0;
                                                        $precio_totalC = 0;
                                                        $precio_totalD = 0;
                                                        $precio_totalE = 0;
                                                        $recorrido = 0;
                                                        $precxdcto = 0;
                                                        $c = 0;

                                                        foreach ($carrito as $car) {

                                                            $codprod = $car['codprod'];
                                                            $ltxha = ($car['cantidad'] * $ha);

                                                            $costo_total = $ltxha * $car['precio'];
                                                            $costo_total_dcto = $ltxha * $car['preciodcto'];
                                                            $precxdcto += $costo_total_dcto;



                                                            $costo_totalA = $car['precioA'] * $ltxha;
                                                            $costo_totalB = $car['precioB'] * $ltxha;
                                                            $costo_totalC = $car['precioC'] * $ltxha;
                                                            $costo_totalD = $car['precioD'] * $ltxha;
                                                            $costo_totalE = $car['precioE'] * $ltxha;

                                                            $precio_total += $costo_total;
                                                            $precio_totalA += $costo_totalA;
                                                            $precio_totalB += $costo_totalB;
                                                            $precio_totalC += $costo_totalC;
                                                            $precio_totalD += $costo_totalD;
                                                            $precio_totalE += $costo_totalE;


                                                            if ($car['congelado'] == 'T') {
                                                                $costo_congelado = $car['preciodcto'] * $ltxha;
                                                                $precio_totalcongelado+= $costo_congelado;
                                                            }
                                                            ?>                                    
                                                            <div class="row">
                                                                <div class="col-lg-9" style="margin-left: 10mm;">
                                                                    <table class="table1" border="1" style=" font-size: 11px; width:100%;" align="left">
                                                                        <thead>
                                                                            <tr style="background-color: #dcdcdc; padding: 10px;">
                                                                                <td style="padding: 5px; text-align: center;">Productos HUMA GRO</td>
                                                                                <td style="text-align: center;">Litros/Ha</td>
                                                                                <td style="text-align: center;">Litros/<?php echo $ha; ?> Ha</td>
                                                                                <td style="text-align: center;">Precio Unit</td>
                                                                                <td style="text-align: center;">Precio Unit Dcto</td>                            
                                                                                <td style="text-align: center;">Precio Total</td>                                        
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>                                    
                                                                                <td style="">
                                                                                    <input type="hidden" id="codprod<?php echo $corredor . $c; ?>" name="codprod<?php echo $corredor . $c; ?>" value="<?php echo $car['codprod']; ?>" />
                                                                                    <input type="hidden" id="taplicacion<?php echo $corredor . $c; ?>" name="taplicacion<?php echo $corredor . $c; ?>" value="<?php echo $car['taplicacion']; ?>" />
                                                                                    <input type="hidden"  name="ordenta<?php echo $corredor . $c; ?>" value="<?php echo $car['ordenta']; ?>" />
                                                                                    <input type="hidden"  name="ordenprod<?php echo $corredor . $c; ?>" value="<?php echo $car['ordenprod']; ?>" />
                                                                                    <input type="hidden"  name="umedida<?php echo $corredor . $c; ?>" value="<?php echo $car['umedida']; ?>" />
                                                                                    <input type="hidden" id="precioEE<?php echo $corredor . $c; ?>" name="precioEE<?php echo $corredor . $c; ?>" value="<?php echo $car['precioE']; ?>" />
                                                                                    <?php echo $car['nomprod']; ?>
                                                                                </td>
                                                                                <td style="text-align: center;">
                                                                                    <input type="hidden" id="litros<?php echo $corredor . $c; ?>" name="litros<?php echo $corredor . $c; ?>" value="<?php echo $car['cantidad']; ?>" />
                                                                                    <?php echo number_format($car['cantidad'], 2); ?>
                                                                                </td>
                                                                                <td style="text-align: center;">
                                                                                    <input type="hidden" id="ltsxha<?php echo $corredor . $c; ?>" name="ltsxha<?php echo $corredor . $c; ?>" value="<?php echo $ltxha; ?>" />
                                                                                    <?php echo number_format($ltxha, 2); ?>
                                                                                </td>
                                                                                <td style="text-align: center;">
                                                                                    <input type="hidden" id="precio<?php echo $corredor . $c; ?>" name="precio<?php echo $corredor . $c; ?>" value="<?php echo $car['precio']; ?>" />
                                                                                    $<?php echo $car['precio']; ?>
                                                                                </td>
                                                                                <td style="text-align: center;">
                                                                                    <input type="hidden" id="preciodcto<?php echo $corredor . $c; ?>" name="preciodcto<?php echo $corredor . $c; ?>" value="<?php echo $car['preciodcto']; ?>" />
                                                                                    $<?php echo $car['preciodcto']; ?></td>
                                                                                <td style="text-align: center;">
                                                                                    $<?php echo number_format($costo_total, 2); ?>
                                                                                </td>                                        
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="1" style="border-left: 0px; border-bottom: 0px;">** Bidones de 10 Litros</td>
                                                                                <td colspan="3" style="text-align: center; font-style: italic;">HUMA GRO Precio con descuento</td>
                                                                                <td style="text-align: center; font-weight: bolder;">TOTAL</td>
                                                                                <td style="text-align: center;;">
                                                                                    $<?php echo number_format($costo_total_dcto, 2); ?>
                                                                                    <input type="hidden" id="costototal<?php echo $corredor . $c; ?>" name="costototal<?php echo $corredor . $c; ?>" value="<?php echo $costo_total_dcto; ?>" />
                                                                                </td>
                                                                            </tr>                                                                                                                                                
                                                                            
                                                                        
                                                                        
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <br/>
                                                            <br/>
                                                            <?php
                                                            $c++;
                                                        }
                                                        ?>                                                            
                                                        <input type="hidden" id="precioambt<?php echo $corredor; ?>" name="precioambt<?php echo $corredor; ?>"  value="<?php echo $precxdcto; ?>" />
                                                        <?php
                                                    } else {
                                                        ?>

                                                        <table class="table table-striped" style="font-size: 11px;">
                                                            <thead>
                                                                <tr style="background-color: #cccccc">
                                                                    <td style="width: 10%;">Aplicación</td>
                                                                    <td style="width: 20%;">Producto</td>
                                                                    <td style="width: 10%; text-align: right;">Lts/Ha</td>
                                                                    <td style="width: 10%; text-align: right;">Lts/<?php echo $ha ?> Ha.</td>
                                                                    <td  style="width: 10%; text-align: right">Precio Unit</td>   
                                                                    <?php if ($pud == 't') { ?>
                                                                        <td  style="width: 10%; text-align: right">Precio Unit Dcto</td>
                                                                    <?php } ?>
                                                                    <td  style="width: 10%; text-align: right">Precio Total</td>                                            
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $costo_total = 0;
                                                                $costo_totalA = 0;
                                                                $costo_totalE = 0;

                                                                $precio_total = 0;
                                                                $precio_totalA = 0;
                                                                $precio_totalB = 0;
                                                                $precio_totalC = 0;
                                                                $precio_totalD = 0;
                                                                $precio_totalE = 0;
                                                                $recorrido = 0;
                                                                $c = 0;

                                                                foreach ($carrito as $car) {
                                                                    $ltxha = $car['cantidad'] * $ha;
                                                                    if ($pud == 't') {
                                                                        $costo_total = $car['preciodcto'] * $ltxha;
                                                                    } else {
                                                                        $costo_total = $car['precio'] * $ltxha;
                                                                    }

                                                                    $costo_totalA = $car['precioA'] * $ltxha;
                                                                    $costo_totalB = $car['precioB'] * $ltxha;
                                                                    $costo_totalC = $car['precioC'] * $ltxha;
                                                                    $costo_totalD = $car['precioD'] * $ltxha;
                                                                    $costo_totalE = $car['precioE'] * $ltxha;

                                                                    $precio_total += $costo_total;
                                                                    $precio_totalA += $costo_totalA;
                                                                    $precio_totalB += $costo_totalB;
                                                                    $precio_totalC += $costo_totalC;
                                                                    $precio_totalD += $costo_totalD;
                                                                    $precio_totalE += $costo_totalE;
                                                                    ?>
                                                                    <tr>
                                                                        <td>
                                                                            <?php
                                                                            if ($recorrido > 0) {
                                                                                $indiceant = $recorrido - 1;
                                                                                if (trim($carrito[$recorrido]['taplicacion']) <> trim($carrito[$indiceant]['taplicacion'])) {
                                                                                    echo $car['taplicacion'];
                                                                                }
                                                                            } else {
                                                                                echo $car['taplicacion'];
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <input type="hidden" id="codprod<?php echo $corredor . $c; ?>" name="codprod<?php echo $corredor . $c; ?>" value="<?php echo $car['codprod']; ?>" />
                                                                            <input type="hidden" id="taplicacion<?php echo $corredor . $c; ?>" name="taplicacion<?php echo $corredor . $c; ?>" value="<?php echo $car['taplicacion']; ?>" />
                                                                            <input type="hidden"  name="ordenta<?php echo $corredor . $c; ?>" value="<?php echo $car['ordenta']; ?>" />
                                                                            <input type="hidden"  name="ordenprod<?php echo $corredor . $c; ?>" value="<?php echo $car['ordenprod']; ?>" />
                                                                            <input type="hidden"  name="umedida<?php echo $corredor . $c; ?>" value="<?php echo $car['umedida']; ?>" />
                                                                            <input type="hidden" id="precioEE<?php echo $corredor . $c; ?>" name="precioEE<?php echo $corredor . $c; ?>" value="<?php echo $car['precioE']; ?>" />

                                                                            <?php echo $car['nomprod']; ?>
                                                                        </td>                                                
                                                                        <td style="text-align: right;">
                                                                            <input type="number" class="numericos" id="litros<?php echo $corredor . $c; ?>" name="litros<?php echo $corredor . $c; ?>" step="any" value="<?php echo $car['cantidad']; ?>" />
                                                                        </td>                                                
                                                                        <td style="text-align: right;">
                                                                            <input type="number" step="any" class="numericos" id="verltsxha<?php echo $corredor . $c; ?>" value="<?php echo $ltxha; ?>" />
                                                                            <input type="hidden" id="ltsxha<?php echo $corredor . $c; ?>" name="ltsxha<?php echo $corredor . $c; ?>" value="<?php echo $ltxha; ?>" />
                                                                        </td>
                                                                        <td style="text-align: right;">
                                                                            <input type="number" step="any" class="numericos" id="precio<?php echo $corredor . $c; ?>" name="precio<?php echo $corredor . $c; ?>" value="<?php echo $car['precio']; ?>" />
                                                                        </td> 
                                                                        <?php if ($pud == 't') { ?>
                                                                            <td style="text-align: right">
                                                                                <input type="number" class="numericos" id="preciodcto<?php echo $corredor . $c; ?>" name="preciodcto<?php echo $corredor . $c; ?>" value="<?php echo $car['preciodcto']; ?>" step="any" />
                                                                            </td>
                                                                        <?php } elseif ($pud == 'f') { ?>
                                                                    <input type="hidden" class="numericos" id="preciodcto<?php echo $corredor . $c; ?>" name="preciodcto<?php echo $corredor . $c; ?>" value="<?php echo $car['preciodcto']; ?>" step="any" />
                                                                <?php } ?>
                                                                <td style="text-align: right">
                                                                    $<span id="vercostototal<?php echo $corredor . $c; ?>"><?php echo number_format($costo_total, 2); ?></span>
                                                                    <input type="hidden" id="costototal<?php echo $corredor . $c; ?>" name="costototal<?php echo $corredor . $c; ?>" value="<?php echo $costo_total; ?>" step="any"  />
                                                                </td>
                                                                </tr>                              
                                                                <?php
                                                                $recorrido++;
                                                                $c++;
                                                            }
                                                            if ($pud == 'f') {
                                                                ?>
                                                                <tr>
                                                                    <td colspan="3"></td>
                                                                    <td colspan="2" style="text-align: right; font-weight: bold;">Sub Total:</td>
                                                                    <td style="text-align: right; font-weight: bold; color: blue;">                                                                        
                                                                        $<span id="phgsubtotal<?php echo $corredor; ?>"><?php echo number_format($precio_total, 2); ?></span>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                            }

                                                            if ($pud == 'f') {
                                                                $precxdcto = ($precio_total * (100 - ($item['descuento']))) / 100;
                                                            } else {
                                                                $precxdcto = $precio_total;
                                                            }
                                                            ?>
                                                            <tr>
                                                                <?php if ($pud == 't') { ?>
                                                                    <td></td>
                                                                <?php } ?>
                                                                <td colspan="2"></td>
                                                                <td colspan="3" style="text-align: right; font-weight: bold;">Precio HUMA GRO con Descuento:</td>
                                                                <td style="text-align: right; font-weight: bold; color: blue;">
                                                                    $<span id="verprecioambt<?php echo $corredor; ?>"><?php echo number_format($precxdcto, 2); ?></span>
                                                                    <input type="hidden" id="precioambt<?php echo $corredor; ?>" name="precioambt<?php echo $corredor; ?>"  value="<?php echo $precxdcto; ?>" />
                                                                </td>
                                                            </tr>
                                                            <?php
                                                            if ($ha > 1) {
                                                                $precxha = $precxdcto / $ha;
                                                                ?> 
                                                                <tr>
                                                                    <?php if ($pud == 't') { ?>
                                                                        <td></td>
                                                                    <?php } ?>
                                                                    <td colspan="2"></td>
                                                                    <td colspan="3">HUMA GRO Precio con descuento para <?php echo $ha; ?> Ha.</td>                        
                                                                    <td style="text-align: right;">
                                                                        $<span id="verprecxha<?php echo $corredor; ?>"><?php echo number_format($precxha, 2); ?></span>                                                                    
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                            </tbody>
                                                        </table>

                                                        <?php
                                                    }
                                                } elseif ($plantilla == 'VOLUMEN PAQ') {
                                                    ?>
                                                    <table class="table table-striped" style="font-size: 11px;">
                                                        <thead>
                                                            <tr style="background-color: #cccccc">                                                                    
                                                                <td>Productos</td>
                                                                <td style="text-align: right;">Litros</td>                                                                    
                                                                <td  style="text-align: right">Precio Unit</td>   
                                                                <?php if ($pud == 't') { ?>
                                                                    <td  style="text-align: right">Precio Unit Dcto</td>
                                                                <?php } ?>
                                                                <td  style="text-align: right">Precio Total</td>                                            
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $costo_total = 0;
                                                            $costo_totalA = 0;
                                                            $costo_totalE = 0;

                                                            $precio_total = 0;
                                                            $precio_totalA = 0;
                                                            $precio_totalB = 0;
                                                            $precio_totalC = 0;
                                                            $precio_totalD = 0;
                                                            $precio_totalE = 0;
                                                            $recorrido = 0;

                                                            foreach ($carrito as $car) {
                                                                $ltxha = $car['cantidad'] * 1;
                                                                if ($pud == 't') {
                                                                    $costo_total = $car['preciodcto'] * $ltxha;
                                                                } else {
                                                                    $costo_total = $car['precio'] * $ltxha;
                                                                }

                                                                $costo_totalA = $car['precioA'] * $ltxha;
                                                                $costo_totalB = $car['precioB'] * $ltxha;
                                                                $costo_totalC = $car['precioC'] * $ltxha;
                                                                $costo_totalD = $car['precioD'] * $ltxha;
                                                                $costo_totalE = $car['precioE'] * $ltxha;

                                                                $precio_total += $costo_total;
                                                                $precio_totalA += $costo_totalA;
                                                                $precio_totalB += $costo_totalB;
                                                                $precio_totalC += $costo_totalC;
                                                                $precio_totalD += $costo_totalD;
                                                                $precio_totalE += $costo_totalE;
                                                                ?>
                                                                <tr>                                                                        
                                                                    <td>
                                                                        <input type="hidden" id="codprod<?php echo $corredor . $c; ?>" name="codprod<?php echo $corredor . $c; ?>" value="<?php echo $car['codprod']; ?>" />
                                                                        <input type="hidden" id="taplicacion<?php echo $corredor . $c; ?>" name="taplicacion<?php echo $corredor . $c; ?>" value="<?php echo $car['taplicacion']; ?>" />
                                                                        <input type="hidden"  name="ordenta<?php echo $corredor . $c; ?>" value="<?php echo $car['ordenta']; ?>" />
                                                                        <input type="hidden"  name="ordenprod<?php echo $corredor . $c; ?>" value="<?php echo $car['ordenprod']; ?>" />
                                                                        <input type="hidden"  name="umedida<?php echo $corredor . $c; ?>" value="<?php echo $car['umedida']; ?>" />
                                                                        <input type="hidden" id="precioEE<?php echo $corredor . $c; ?>" name="precioEE<?php echo $corredor . $c; ?>" value="<?php echo $car['precioE']; ?>" />
                                                                        <?php echo $car['nomprod']; ?>                                                                        
                                                                    </td>
                                                                    <td style="text-align: right;">
                                                                        <input type="number" class="numericos" id="litros<?php echo $corredor . $c; ?>" name="litros<?php echo $corredor . $c; ?>" step="any" value="<?php echo $car['cantidad']; ?>" />
                                                                    </td>
                                                                    <td style="text-align: right">
                                                                        <input type="number" step="any" class="numericos" id="precio<?php echo $corredor . $c; ?>" name="precio<?php echo $corredor . $c; ?>" value="<?php echo $car['precio']; ?>" />
                                                                    </td>
                                                                    <?php if ($pud == 't') { ?>
                                                                        <td style="text-align: right">
                                                                            <input type="number" class="numericos" id="preciodcto<?php echo $corredor . $c; ?>" name="preciodcto<?php echo $corredor . $c; ?>" value="<?php echo $car['preciodcto']; ?>" step="any" />
                                                                        </td>
                                                                    <?php } elseif ($pud == 'f') { ?>
                                                                <input type="hidden" class="numericos" id="preciodcto<?php echo $corredor . $c; ?>" name="preciodcto<?php echo $corredor . $c; ?>" value="<?php echo $car['preciodcto']; ?>" step="any" />
                                                            <?php } ?>
                                                            <td style="text-align: right">
                                                                $<span id="vercostototal<?php echo $corredor . $c; ?>"><?php echo number_format($costo_total, 2); ?></span>
                                                                <input type="hidden" id="costototal<?php echo $corredor . $c; ?>" name="costototal<?php echo $corredor . $c; ?>" value="<?php echo $costo_total; ?>" step="any"  />
                                                            </td>
                                                            </tr>                              
                                                            <?php
                                                            $recorrido++;
                                                        }
                                                        if ($pud == 'f') {
                                                            ?>
                                                            <tr>
                                                                <td colspan="2"></td>
                                                                <td colspan="1" style="text-align: right; font-weight: bold;">Sub Total:</td>
                                                                <td style="text-align: right; font-weight: bold; color: blue;">
                                                                    $<span id="phgsubtotal<?php echo $corredor; ?>"><?php echo number_format($precio_total, 2); ?></span>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }

                                                        if ($pud == 'f') {
                                                            $precxdcto = ($precio_total * (100 - ($item['descuento']))) / 100;
                                                        } else {
                                                            $precxdcto = $precio_total;
                                                        }
                                                        ?>
                                                        <tr>
                                                            <?php if ($pud == 't') { ?>
                                                                <td></td>
                                                            <?php } ?>
                                                            <td colspan="1"></td>
                                                            <td colspan="2" style="text-align: right; font-weight: bold;">Precio HUMA GRO con Descuento:</td>
                                                            <td style="text-align: right; font-weight: bold; color: blue;">
                                                                $<span id="verprecioambt<?php echo $corredor; ?>"><?php echo number_format($precxdcto, 2); ?></span>
                                                                <input type="hidden" id="precioambt<?php echo $corredor; ?>" name="precioambt<?php echo $corredor; ?>"  value="<?php echo $precxdcto; ?>" />
                                                            </td>
                                                        </tr>                                                        
                                                        </tbody>
                                                    </table> 

                                                <?php } ?>

                                            </div>
                                        </div>
                                        <?php if ($pup <> 't') { ?>
                                            <div class="row" style="text-align: left">
                                                <div class="col-lg-12">
                                                    <a class="btn btn-primary btn-sm" id="" onclick="actualizarTabla2(<?php echo $corredor; ?>)" href="#nndivtable<?php echo $corredor; ?>" >Actualizar</a>
                                                </div>                                            
                                            </div>
                                            <div class="row">                                                                                       
                                                <div class="col-lg-6">      
                                                    <input type="hidden" id="precio_totalE<?php echo $corredor; ?>" name="precio_totalE<?php echo $corredor; ?>" value="<?php echo $precio_totalE; ?>" />                                                
                                                    <h4>Factor Aprobación Usuario: <span style="background-color: yellow; padding: 3px;" id="verfau<?php echo $corredor; ?>"><?php echo ($item['fa']); ?></span>  </h4>
                                                    <input type="hidden" name="pv2_fa<?php echo $corredor; ?>" id="pv2_fa<?php echo $corredor; ?>" value="<?php echo ($item['fa']); ?>" />
                                                    <h4>Estado: <?php echo $pro->getestadoPropuesta($item['estado']); ?>  </h4>
                                                </div>                                            
                                            </div>

                                            <hr/>                                        
                                            <div class="row">                                             
                                                <div class="col-lg-5" id="divcomentario<?php echo $corredor ?>">
                                                    <h4>Comentarios</h4>                                                    
                                                    <?php
                                                    $pro->__set('coditem', $item['coditem']);
                                                    $comentarios = $pro->getComentariosByCodItem();
                                                    if (count($comentarios) > 0) {
                                                        foreach ($comentarios as $comment) {
                                                            $fecha = date("d/m/y h:i", strtotime($comment["fecreg"]));
                                                            echo '<p style="color: #08088A;"><strong>' . $fecha . ' ' . $comment["desuse"] . '</strong> dice:</p>';
                                                            echo '<p style="color: grey">' . $comment["comentario"] . '</p>';
                                                        }
                                                    } else {
                                                        echo '<span class="alert alert-primary">No se encontraron comentarios.</span>';
                                                    }
                                                    ?>
                                                    <br/><br/>
                                                    <p>Agregar comentario:</p>
                                                    <textarea class="form-control input-sm" name="comentario<?php echo $corredor; ?>" id="comentario<?php echo $corredor; ?>" rows="3" cols="20"></textarea>
                                                    <p style="margin-top: 2px; text-align: right;"><a class="btn btn-success btn-sm" href="#divcomentario" onclick="insert_comentario(<?php echo $coditem; ?>, <?php echo $corredor; ?>)">Agregar comentario</a></p>                                                    
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="row">                                                                                       
                                                <div class="col-lg-6">      
                                                    <input type="hidden" id="precio_totalE<?php echo $corredor; ?>" name="precio_totalE<?php echo $corredor; ?>" value="<?php echo $precio_totalE; ?>" />                                                    
                                                    <input type="hidden" name="pv2_fa<?php echo $corredor; ?>" id="pv2_fa<?php echo $corredor; ?>" value="<?php echo ($item['fa']); ?>" />                                                    
                                                </div>                                            
                                            </div>                                            
                                        <?php } ?>

                                    </div><!--Aqui termina el divtable-->      
                                    <br/><br/>                                                                                        
                                    <!--Fin del cuerpo del item-->
                                </div>
                                <!--Fin del divitem-->
                            </div>
                            <br/>

                            <?php
                            $corredor++;
                        }
                    } else {
                        echo 'No se ha registrado ningún item.';
                    }
                    ?>

                    <!-- ESTO ESTÁ FUERA DE TODO-->

                    <br/>
                    <div class="row">
                        <div class="col-lg-12">                                                                                                                               
                            <p style="text-align: center">                            
                                <input type="submit" value="OK" class="btn btn-success btn-lg" />
                                <input type="hidden" id="accion" name="accion" value="UpdatePropuestaV2" />
                            </p>                                               
                        </div>
                    </div>
                </form>
                <br/>
                <div id="result"></div>                    
            </div>
            <script src="autocompleteboot/js/bootstrap.js" type="text/javascript"></script>
            <script src="autocompleteboot/js/bootstrap-combobox.js" type="text/javascript"></script>                
        </body>
    </html>

    <?php
} else {
    echo 'Para consultar estos datos debe iniciar sesión.';
}
?>