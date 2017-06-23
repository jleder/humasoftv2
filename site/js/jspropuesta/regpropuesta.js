/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 * 
 * 
 * 
 */



$(document).ready(function () {

    //Texarea Wysiwyg
    TinyMCEStart('#condicion2', null);
    // Load script of Select2 and run this
    LoadSelect2Script(Select2Test);
    WinMove();


    //Cargar Tipo Cotizacion
    $("#tipocotizacion").change(function () {
        // var tipo = $(this).find("option:selected").html();  //con esto consigo el nombre
        var tipo = $(this).find("option:selected").val();  //con esto consigo el valor
        if (tipo === 'POR VOLUMEN') {
            $("#divaplicacion").css("display", "none");
            $("#divha").css("display", "none");
            $("#divfactor").css("display", "block");
            $("#ha").val("1");
            from_unico(tipo, 'divfactor', '_propuestav2_porvolumen.php');
        } else if (tipo === 'POR HECTAREA') {
            var codcli = $("#combobox").val();
            $("#divaplicacion").css("display", "none");
            $("#divha").css("display", "block");
            $("#divfactor").css("display", "block");
            from_unico(codcli, 'divfactor', '_propuestav2_loadfactor.php');
        } else if (tipo === 'OTROS PRODUCTOS') {
            $("#divaplicacion").css("display", "block");
            $("#divfactor").css("display", "none");
            $("#divha").css("display", "block");
            $("#ha").val("1");
        }
    });

//   $("#dcto").keyup(function (e) {
//        if (e.keyCode == 13) {
//            alert("No presionar Enter");
//            e.preventDefault();
//        }
//    });

//    cargar variedad




    $("#cultivo").change(function (e) {
        //alert("entre");




        var variable = $(this).val();
        var categoria = variable.split(",");
        var cultivo = categoria[0];
        if (cultivo === 'otro') {
            $("#divvariedad").hide(500);
            $("#divnewcultivo").show(750);
            $("#divnewvariedad").show(1000);
        } else {
            $("#newcultivo").val("");
            $("#newvariedad").val("");
            $("#divnewcultivo").hide(500);
            $("#divnewvariedad").hide(500);
            $("#divvariedad").show(500);
            from_2('loadVariedad', cultivo, 'divvariedad', '_propuestav2_loadall.php');
        }
        e.preventDefault();
    });

    $("#efenologica").change(function (e) {
        //alert("entre");
        var etapa = $(this).find("option:selected").val();
        if (etapa === 'otro') {
            $("#divnewefenologica").show("slow");
        } else {
            $("#newefenologica").val("");
            $("#divnewefenologica").hide("slow");
        }
        e.preventDefault();
    });



    //Cargar DIV Nuevo Cultivo


    //Cargar DIV Nueva Variedad    
//    $("#variedad").change(function (e) {        
//        var variedad = $("#variedad").val();                
//        if (variedad === 'otro') {
//            $("#divnewvariedad").show(1000);
//        } else {
//            $("#newvariedad").val("");
//            $("#divnewvariedad").hide(500);
//        }
//        e.preventDefault();
//    });

    //Cargar Variedad

    //Obtener precio de producto
    $("#comboprod").change(function () {
        var modo = 'Insert';
        var codprod = $(this).val();
        from_2(modo, codprod, 'divpreciou', '_propuestav2_getprecioprod.php');
    });

    //Obtener precio de producto desde update item
//    $("#comboprod_update").change(function () {
//        alert("entre");
//        var modo = 'Update';
//        var codprod = $(this).val();        
//        from_2(modo, codprod, 'divpreciou_update', '_propuestav2_getprecioprod.php');
//    });

    //Cargar Factores Convencional por Cliente
    $("#combobox").change(function (e) {
        var cliente = $(this).val();
        var res_cliente = cliente.split("|");
        var codcli = res_cliente[0];
        var abreviatura = res_cliente[1];
        if (abreviatura) {
            var codpropuesta = $("#codprop").val();
            $("#codprop").val(abreviatura + '-' + codpropuesta);
        }
        from_unico(codcli, 'divcontacto', '_propuestav2_loadcontactos.php');
        e.preventDefault();
    });

    $("#form").submit(function (e) {
        e.preventDefault();

        //alert("Entre!!!");

        var demo = 'NO';
        if ($('#demo').is(':checked')) {
            demo = 'SI';
        }
        var rpta = validar();
        if (rpta === true) {
            var f = $(this);
            var formData = new FormData(document.getElementById("form"));

            var nomcliente = $("#combobox option:selected").html();
            var codvendedor = $("#vendedor").val();
            if (codvendedor === 'Asesor Externo') {
                var nomasesorexterno = $("#asesorexterno option:selected").html();
                formData.append("nomasesorexterno", nomasesorexterno);
            } else {
                var nomvendedor = $("#vendedor option:selected").html();
                formData.append("nomvendedor", nomvendedor);
            }
            formData.append("nomcliente", nomcliente);
            formData.append("demo", demo);

            $.ajax({
                url: "../controller/C_Propuestas.php",
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            })
                    .done(function (res) {
                        $("#result").html(res);
                        location.href ="_propuestav2.php";
                    });
        }
    });
});


function getnewprecio(id) {
    var cod = $("#prec" + id).val();
    var divnewprec = document.getElementById("divnewprec" + id);
    if (cod === 'otroprec') {
        divnewprec.style.display = "block";
    } else {
        divnewprec.style.display = "none";

    }
}

function getprecio() {
    var codprod = $("#comboprod").val();
    from_unico(codprod, 'divpreciou', '_propuestav2_getprecioprod.php');
}

function otroCultivo() {
    var variable = document.getElementById("cultivo").value;
    var div = document.getElementById('divnewcultivo');
    var newvariable = document.getElementById('newcultivo');
    if (variable === 'otro') {

        div.style.display = "block";
        newvariable.required;
    } else {
        newvariable.value = '';
        div.style.display = "none";
    }
}

function loadNuevaVariedad() {
    var variedad = $("#variedad").val();
    if (variedad === 'otro') {
        $("#divnewvariedad").show("slow");
    } else {
        $("#newvariedad").val("");
        $("#divnewvariedad").hide("slow");
    }
}

//Cargar ultimos factores de aprobacion de cliente    

function verDIVPrecios() {
    var precio60 = $("#precio60").val();
    var divprecio = document.getElementById('divprecios');

    if (precio60 === 'Si') {
        divprecio.style.display = "block";
    } else {
        divprecio.style.display = "none";
    }
}

function crearItemHa() {
    var itemdesc = $("#itemdesc").val();
    if (itemdesc === '') {
        alert('Debe ingresar descripcion de este item.');
        $("#itemdesc").focus();
    } else {

        //variables de propuesta
        var codprop = $("#codprop").val();
        var cliente = $("#combobox option:selected").html();
        var contacto = $("#contacto").val();

        var plantilla = $("#tipoprop").val();
        var dcto = $("#dcto").val(); //descuento
        var ha = $("#ha").val(); //hectarea                
        var pcc = $("#pcc").val(); //precio convencional confirmado
        var pca = $("#pca").val(); //precio convencional aproximado
        var precioAMBT = $("#preambt").val(); //precio final con descuento
        var fau = $("#factor").val(); //factor aprobacion usuario                
        var nitrogeno = $('input:radio[name=nitrogeno]:checked').val();
        var pud = 'f';
        var pup = 'f';
        var verfc = 'f';
        var itemdesc_pup = $("#itemdesc_pup").val();
        var estado = 'PENDIENTE';
        var modificado = 'FALSE';
        var valigv = $("#valigv").val();
        var incluyeigv = 'f';

        if ($('#checkigv').is(':checked')) {
            incluyeigv = 't';
        }

        if ($('#pud').is(':checked')) {
            pud = 't';
        }

        if ($('#pup').is(':checked')) {
            pup = 't';
        }

        if ($('#verfc').is(':checked')) {
            verfc = 't';
        }

        if (fau !== '0') {
            var item = [dcto, pcc, pca, precioAMBT, fau, ha, nitrogeno, plantilla, pud, estado, modificado, incluyeigv, valigv, pup, '', verfc];
            var prop = [codprop, cliente, contacto];
            from_4(item, itemdesc, prop, itemdesc_pup, 'divexperimento', '_propuestav2_vista_previa.php');
            cargar('#divproductos', '_vacio.php');
            limpiarCamposItem();
        } else {
            alert('EL FACTOR DE APROBACIÓN NO PUEDE ESTAR EN CERO. DAR CLIC EN EL BOTON "OK" QUE ESTÁ A LA DERECHA DEL CAMPO DESCUENTO');
        }
    }
}

function crearItemVol() {
    var itemdesc = $("#itemdesc").val();
    if (itemdesc === '') {
        alert('Debe ingresar descripcion de este item.');
        $("#itemdesc").focus();
    } else {

        var plantilla = $("#tipoprop").val();
        var dcto = $("#dcto").val();//descuento
        var ha = $("#ha").val(); //hectarea                
        var pcc = $("#pcc").val(); //precio convencional confirmado
        var pca = $("#pca").val(); //precio convencional aproximado
        var precioAMBT = $("#preambt").val(); //precio final con descuento
        var fau = $("#factor").val(); //factor aprobacion usuario        
        var pud = 'f';
        var estado = 'PENDIENTE';
        var modificado = 'FALSE';
        var valigv = $("#valigv").val();
        var incluyeigv = 'f';

        if ($('#checkigv').is(':checked')) {
            incluyeigv = 't';
        }

        if ($('#pud').is(':checked')) {
            pud = 't';
        }

        if (fau !== '0') {
            var item = [dcto, pcc, pca, precioAMBT, fau, ha, '', plantilla, pud, estado, modificado, incluyeigv, valigv];
            from_2(item, itemdesc, 'divexperimento', '_propuestav2_vista_previa.php');
            cargar('#divproductos', '_vacio.php');
            limpiarCamposItem();
        } else {
            alert('EL FACTOR DE APROBACIÓN NO PUEDE ESTAR EN CERO. DAR CLIC EN EL BOTON "OK" QUE ESTÁ A LA DERECHA DEL CAMPO DESCUENTO');
        }
    }
}

function limpiarCamposItem() {
    $("#itemdesc").val("");
    $("#ha").val("1");
}

//$("#cargatab2").click(function (evento) {    
//    alert("Has pulsado el enlace, pero vamos a cancelar el evento...nPor tanto, no vamos a llevarte a DesarrolloWeb.com");
//    evento.preventDefault();
//});



function obtenerProductosCongelados() {
    var congelito = new Array();
    var congelados = ["congN", "congP", "congK", "congCa", "congMg", "congS", "congB", "congCo", "congCu", "congFe", "congMn", "congMo", "congSi", "congZn"];
    for (var i = 0; i < congelados.length; i++) {
        if ($('#' + congelados[i]).is(':checked')) {
            congelito.push("T");
        } else {
            congelito.push("F");
        }
    }
    return congelito;

}

function obtenerProductosCongeladosUpdate() {
    var congelito = new Array();
    var congelados = ["cong_updateN", "cong_updateP", "cong_updateK", "cong_updateCa", "cong_updateMg", "cong_updateS", "cong_updateB", "cong_updateCo", "cong_updateCu", "cong_updateFe", "cong_updateMn", "cong_updateMo", "cong_updateSi", "cong_updateZn"];
    for (var i = 0; i < congelados.length; i++) {
        if ($('#' + congelados[i]).is(':checked')) {
            congelito.push("T");
        } else {
            congelito.push("F");
        }
    }
    return congelito;

}

function obtenerPreciosEstablecidos() {

    var establecido = new Array();
    var establecidos = ["estN", "estP", "estK", "estCa", "estMg", "estS", "estB", "estCo", "estCu", "estFe", "estMn", "estMo", "estSi", "estZn"];
    for (var i = 0; i < establecidos.length; i++) {
        if ($('#' + establecidos[i]).is(':checked')) {
            establecido.push("T");
        } else {
            establecido.push("F");
        }
    }
    return establecido;

}

function addbyVolumen() {
    //alert('entro en procesar litros');
    var congelito = new Array(); // Obtiene los precios congelados
    var litros = [$("#ltN").val(), $("#ltP").val(), $("#ltK").val(), $("#ltCa").val(), $("#ltMg").val(), $("#ltS").val(), $("#ltB").val(), $("#ltCo").val(), $("#ltCu").val(), $("#ltFe").val(), $("#ltMn").val(), $("#ltMo").val(), $("#ltSi").val(), $("#ltZn").val()];
    var precios = [$("#precN").val(), $("#precP").val(), $("#precK").val(), $("#precCa").val(), $("#precMg").val(), $("#precS").val(), $("#precB").val(), $("#precCo").val(), $("#precCu").val(), $("#precFe").val(), $("#precMn").val(), $("#precMo").val(), $("#precSi").val(), $("#precZn").val()];
    //var newprec = [$("#newprecN").val(), $("#newprecP").val(), $("#newprecK").val(), $("#newprecCa").val(), $("#vprecMg").val(), $("#newprecS").val(), $("#newprecB").val(), $("#newprecCo").val(), $("#newprecCu").val(), $("#newprecFe").val(), $("#newprecMn").val(), $("#newprecMo").val(), $("#newprecSi").val(), $("#newprecZn").val()];
    var bidones = [$("#bdN").val(), $("#bdP").val(), $("#bdK").val(), $("#bdCa").val(), $("#bdMg").val(), $("#bdS").val(), $("#bdB").val(), $("#bdCo").val(), $("#bdCu").val(), $("#bdFe").val(), $("#bdMn").val(), $("#bdMo").val(), $("#bdSi").val(), $("#bdZn").val()];

    congelito = obtenerProductosCongelados();
    var tipo = 'BYVOLUMEN';
    var plantilla = $("#tipoprop").val();
    //*****************************
    var verprec = $("#precio60").val();
    var dcto = $("#dcto").val();
    var pca = $("#pca").val();
    var pcc = $("#pcc").val();
    var pud = 'f';
    var pup = 'f';
    var valigv = $("#valigv").val();
    var incluyeigv = 'f';

    if ($('#checkigv').is(':checked')) {
        incluyeigv = 't';
    }

    if ($('#pud').is(':checked')) {
        pud = 't';
    }

    if ($('#pup').is(':checked')) {
        pup = 't';
    }


    //para ahorrar variables, enviar verprec y ha en un array    
    var variables = [tipo, verprec, dcto, pca, pcc, pud, incluyeigv, valigv, pup];
    if (plantilla === 'VOLUMEN PAQ') {
        from_6(litros, 'factores', variables, precios, congelito, bidones, 'divproductos', '_propuestav2_volpaq_detalle.php');
    } else if (plantilla === 'VOLUMEN PUD') {
        from_6(litros, 'factores', variables, precios, congelito, bidones, 'divproductos', '_propuestav2_volpud_detalle.php');
    }
}


function addbyProducto() {
    var codprod = $("#comboprod").val();
    var cantidad = $("#cantidad").val();
    var precio = $("#precio").val();
    var preciodcto = $("#preciodcto").val();
    var ha = $("#ha").val();
    var dcto = $("#dcto").val();
    var pca = $("#pca").val();
    var pcc = $("#pcc").val();
    var tipoprop = $("#tipoprop").val();
    var factorb = $("#bidones").val();
    var pud = 'f';
    var pup = 'f';
    var verfc = 'f';
    var valigv = $("#valigv").val();
    var incluyeigv = 'f';

    if ($('#checkigv').is(':checked')) {
        incluyeigv = 't';
    }

    if ($('#pud').is(':checked')) {
        pud = 't';
    }

    if ($('#pup').is(':checked')) {
        pup = 't';
    }

    if ($('#verfc').is(':checked')) {
        verfc = 't';
    }

    if (codprod === "") {
        alert('Debe seleccionar un producto');
        $("#comboprod").focus();
        return false;
    } else if (cantidad === "0") {
        alert('Debe ingresar litros');
        $("#cantidad").focus();
        return false;
    } else if (precio === "0") {
        alert('Debe ingresar precio');
        $("#precio").focus();
        return false;
    } else {
        var tipo = 'BYPRODUCTO'; //PROD = Productos
        var codtipoa = $("#tipoa").val();
        var nomtipoa = $("#tipoa option:selected").html();
        var congelar = $("#congelar2").val();
        var variables = [tipo, precio, codtipoa, nomtipoa, congelar, dcto, pca, pcc, preciodcto, factorb, pud, incluyeigv, valigv, pup, verfc];

        if (tipoprop === 'HECTAREA PAQ') {
            from_4(codprod, cantidad, variables, ha, 'divproductos', '_propuestav2_hapaq_detalle.php');
            $("#comboprod").focus();
        } else if (tipoprop === 'VOLUMEN PAQ') {
            from_4(codprod, cantidad, variables, ha, 'divproductos', '_propuestav2_volpaq_detalle.php');
            $("#comboprod").focus();
        }
    }
}

function calcularPrecioAMBT(precioTotal, precioTotalE, totalCongelado) {
    var dcto = $("#dcto").val();
    var valor = (1 - (parseFloat(dcto) / 100));
    var precioAMBT = (parseFloat(precioTotal) * parseFloat(valor)) + parseFloat(totalCongelado);
    $("#preambt").val(precioAMBT.toFixed(2));

    calcularFactorAprobacion(precioAMBT, precioTotalE);
    calcularPrecioSaldo();
}

function calcularPorcentajeAMB(precioTotal, precioTotalE, totalCongelado) {
    var precioAMBT = $("#preambt").val();
    var precioDescongelado = parseFloat(precioAMBT) - parseFloat(totalCongelado);
    var descuento = 100 - ((parseFloat(precioDescongelado) * 100) / parseFloat(precioTotal));
    $("#dcto").val(descuento.toFixed(2));
    //Calcular Factor de Aprobación                                                
    calcularFactorAprobacion(precioAMBT, precioTotalE);
    calcularPrecioSaldo();
}

function calcularPrecioSaldo() {
    var precioAMBT = $("#preambt").val();
    var pcc = $("#pcc").val();
    var pca = $("#pca").val();

    if (parseFloat(pcc) > 0) {
        var presaldo = parseFloat(pcc) - parseFloat(precioAMBT);
        $("#presaldo").val(presaldo.toFixed(2));
    } else {
        if (parseFloat(pca) > 0) {
            var presaldo = parseFloat(pca) - parseFloat(precioAMBT);
            $("#presaldo").val(presaldo.toFixed(2));
        }
    }
}

function calcularFactorAprobacion(precioAMBT, precioTotalE) {
    var x = parseFloat(precioAMBT) - parseFloat(precioTotalE);
    var fag = (parseFloat(x) / parseFloat(precioTotalE)) * 100; //Factor Aprobacion Gerencial
    var fau = parseFloat(fag) - 25; //Factor Aprobacion Usuario

    if (parseFloat(fau) < 40) {
        $("#factoraprob").css({'color': 'red'});
    } else {
        $("#factoraprob").css({'color': 'black'});
    }

    $("#factor").val(fau.toFixed(2));
    $("#factoraprob").html(fau.toFixed(2));
}

function mostrar(id) {
    var idpre = 'pre' + id;
    var idcon = 'con' + id;
    var divpre = document.getElementById(idpre);
    var divcon = document.getElementById(idcon);

    if (divpre.style.display === "block" && divcon.style.display === "block") {
        divpre.style.display = "none";
        divcon.style.display = "none";
    } else {
        divpre.style.display = "block";
        divcon.style.display = "block";
    }
}

function mostrarAsesorExterno() {
    var asesor = $("#vendedor").val();
    if (asesor === 'Asesor Externo') {
        $("#divasesorexterno").css("display", "block");
    } else {
        $("#divasesorexterno").css("display", "none");
    }
}

function personalizarContacto() {
    var contacto = $("#contacto").val();
    if (contacto === 'otro') {
        $("#divnewcontacto").css("display", "block");
    } else {
        $("#divnewcontacto").css("display", "none");
        $("#newcontacto").val("");
    }
}

function personalizarTrato() {
    var trato = $("#trato").val();
    if (trato === 'otro') {
        $("#divtrato").css("display", "block");
    } else {
        $("#divtrato").css("display", "none");
        $("#newtrato").val("");
    }
}

function mostrarCampoDcto() {
    var tipodcto = $("#tipodcto").val();
    if (tipodcto === 'PREPOR') {
        $("#divtipodcto").css("display", "block");
    } else if (tipodcto === 'PRE60') {
        $("#divtipodcto").css("display", "none");
        $("#dcto").val("0");
    }
}

function loadlastfactores() {
    var codcli = $("#combobox").val();
    from_unico(codcli, 'divlastfactores', '_propuestav2_lastfactores.php');
}

function ajustarFactores() {
    if ($('#ajustefactor').is(':checked')) {
        $('[id*=fc]').prop('readonly', false);
    } else {
        $('[id*=fc]').prop('readonly', true);
    }
}

//function mostrarNewcliente() {
//    var codcli = "";
//    $("#divaddnewcliente").css("display", "none");
//    $("#divnewcliente").css("display", "block");
//    $("#nuevocliente").val("T");
//    $('#combobox').val('0');
//    $('#combobox').change();
//    alert("Si estoy actualizando 2");
//    //Actualizar Factores
//    from_unico(codcli, 'divfactor', '_propuestav2_loadfactor.php');
//}

function ocultarNewcliente() {
    $("#divaddnewcliente").css("display", "block");
    $("#divnewcliente").css("display", "none");
    $("#nuevocliente").val("F");
    //limpiar campos
    $("#ruc").val("");
    $("#razonsocial").val("");
    $("#abrev").val("");
}

function loadIGV() {
    if ($('#checkigv').is(':checked')) {
        $("#divigv").css("display", "block");
    } else {
        $("#divigv").css("display", "none");

    }
}

function cargarNuevoContacto() {

    var variable = $("#contacto").val();
    if (variable === 'otro') {
        $("#divnewcontacto").css("display", "block");
    } else {
        $("#newcontacto").val("");
        $("#divnewcontacto").css("display", "none");
    }
}

function Select2Test() {
    $("#combobox").select2();
    $("#comboprod").select2();
    $('#comboprod_update').select2();
}