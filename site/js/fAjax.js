function obtiene_http_request()
{
    var req = false;
    try
    {
        req = new XMLHttpRequest(); /* p.e. Firefox */
    } catch (err1)
    {
        try
        {
            req = new ActiveXObject("Msxml2.XMLHTTP");
            /* algunas versiones IE */
        } catch (err2)
        {
            try
            {
                req = new ActiveXObject("Microsoft.XMLHTTP");
                /* algunas versiones IE */
            } catch (err3)
            {
                req = false;
            }
        }
    }
    return req;
}
var miPeticion = obtiene_http_request();

function from(cod1, div, accion, url) {
    var mi_aleatorio = parseInt(Math.random() * 99999999);//para que no guarde la p�gina en el cach�...
    var vinculo = url + "?cod=" + cod1 + "&accion=" + accion + "&rand=" + mi_aleatorio;
    //alert(vinculo);
    miPeticion.open("GET", vinculo, true);//ponemos true para que la petici�n sea asincr�nica
    miPeticion.onreadystatechange = miPeticion.onreadystatechange = function () {
        if (miPeticion.readyState == 4)
        {
            //alert(miPeticion.readyState);
            if (miPeticion.status == 200)
            {
                //alert(miPeticion.status);
                //var http=miPeticion.responseXML;
                var http = miPeticion.responseText;
                document.getElementById(div).innerHTML = http;

            }
        }/*else
         {
         document.getElementById(ide).innerHTML="<img src='ima/loading.gif' title='cargando...' />";
         
         }*/
    }
    miPeticion.send(null);

}

function from_2(cod1, cod2, div, url) {
    var mi_aleatorio = parseInt(Math.random() * 99999999);//para que no guarde la p�gina en el cach�...
    var vinculo = url + "?cod1=" + cod1 + "&cod2=" + cod2 + "&rand=" + mi_aleatorio;

    miPeticion.open("GET", vinculo, true);//ponemos true para que la petici�n sea asincr�nica
    miPeticion.onreadystatechange = miPeticion.onreadystatechange = function () {
        if (miPeticion.readyState == 4)
        {
            //alert(miPeticion.readyState);
            if (miPeticion.status == 200)
            {
                //alert(miPeticion.status);
                //var http=miPeticion.responseXML;
                var http = miPeticion.responseText;
                document.getElementById(div).innerHTML = http;

            }
        }
    }
    miPeticion.send(null);
}

function from_3(cod1, cod2, cod3, div, url) {
    var mi_aleatorio = parseInt(Math.random() * 99999999);//para que no guarde la p�gina en el cach�...
    var vinculo = url + "?cod1=" + cod1 + "&cod2=" + cod2 + "&cod3=" + cod3 + "&rand=" + mi_aleatorio;

    miPeticion.open("GET", vinculo, true);//ponemos true para que la petici�n sea asincr�nica
    miPeticion.onreadystatechange = miPeticion.onreadystatechange = function () {
        if (miPeticion.readyState == 4)
        {
            //alert(miPeticion.readyState);
            if (miPeticion.status == 200)
            {
                //alert(miPeticion.status);
                //var http=miPeticion.responseXML;
                var http = miPeticion.responseText;
                document.getElementById(div).innerHTML = http;

            }
        }
    }
    miPeticion.send(null);
}

function from_4(cod1, cod2, cod3, cod4, div, url) {
    var mi_aleatorio = parseInt(Math.random() * 99999999);//para que no guarde la p�gina en el cach�...
    var vinculo = url + "?cod1=" + cod1 + "&cod2=" + cod2 + "&cod3=" + cod3 + "&cod4=" + cod4 + "&rand=" + mi_aleatorio;

    miPeticion.open("GET", vinculo, true);//ponemos true para que la petici�n sea asincr�nica
    miPeticion.onreadystatechange = miPeticion.onreadystatechange = function () {
        if (miPeticion.readyState == 4)
        {
            //alert(miPeticion.readyState);
            if (miPeticion.status == 200)
            {
                //alert(miPeticion.status);
                //var http=miPeticion.responseXML;
                var http = miPeticion.responseText;
                document.getElementById(div).innerHTML = http;

            }
        }
    }
    miPeticion.send(null);
}

function from_5(cod1, cod2, cod3, cod4, cod5, div, url) {
    var mi_aleatorio = parseInt(Math.random() * 99999999);//para que no guarde la p�gina en el cach�...
    var vinculo = url + "?cod1=" + cod1 + "&cod2=" + cod2 + "&cod3=" + cod3 + "&cod4=" + cod4 + "&cod5=" + cod5 + "&rand=" + mi_aleatorio;

    miPeticion.open("GET", vinculo, true);//ponemos true para que la petici�n sea asincr�nica
    miPeticion.onreadystatechange = miPeticion.onreadystatechange = function () {
        if (miPeticion.readyState == 4)
        {
            //alert(miPeticion.readyState);
            if (miPeticion.status == 200)
            {
                //alert(miPeticion.status);
                //var http=miPeticion.responseXML;
                var http = miPeticion.responseText;
                document.getElementById(div).innerHTML = http;

            }
        }
    }
    miPeticion.send(null);
}

function from_6(cod1, cod2, cod3, cod4, cod5, cod6, div, url) {
    var mi_aleatorio = parseInt(Math.random() * 99999999);//para que no guarde la p�gina en el cach�...
    var vinculo = url + "?cod1=" + cod1 + "&cod2=" + cod2 + "&cod3=" + cod3 + "&cod4=" + cod4 + "&cod5=" + cod5 + "&cod6=" + cod6 + "&rand=" + mi_aleatorio;

    miPeticion.open("GET", vinculo, true);//ponemos true para que la petici�n sea asincr�nica
    miPeticion.onreadystatechange = miPeticion.onreadystatechange = function () {
        if (miPeticion.readyState == 4)
        {
            //alert(miPeticion.readyState);
            if (miPeticion.status == 200)
            {
                //alert(miPeticion.status);
                //var http=miPeticion.responseXML;
                var http = miPeticion.responseText;
                document.getElementById(div).innerHTML = http;

            }
        }
    }
    miPeticion.send(null);
}

function from_7(cod1, cod2, cod3, cod4, cod5, cod6, cod7, div, url) {
    var mi_aleatorio = parseInt(Math.random() * 99999999);//para que no guarde la p�gina en el cach�...
    var vinculo = url + "?cod1=" + cod1 + "&cod2=" + cod2 + "&cod3=" + cod3 + "&cod4=" + cod4 + "&cod5=" + cod5 + "&cod6=" + cod6 + "&cod7=" + cod7 + "&rand=" + mi_aleatorio;

    miPeticion.open("GET", vinculo, true);//ponemos true para que la petici�n sea asincr�nica
    miPeticion.onreadystatechange = miPeticion.onreadystatechange = function () {
        if (miPeticion.readyState === 4)
        {
            //alert(miPeticion.readyState);
            if (miPeticion.status === 200)
            {
                //alert(miPeticion.status);
                //var http=miPeticion.responseXML;
                var http = miPeticion.responseText;
                document.getElementById(div).innerHTML = http;

            }
        }
    };
    miPeticion.send(null);
}
//NO FUNCIONA.
function from_702(cod1, cod2, cod3, cod4, cod5, cod6, cod7, div, url) {
    var mi_aleatorio = parseInt(Math.random() * 99999999);//para que no guarde la p�gina en el cach�...
    var vinculo = url + "?cod1=" + cod1 + "&cod2=" + cod2 + "&cod3=" + cod3 + "&cod4=" + cod4 + "&cod5=" + cod5 + "&cod6=" + cod6 + "&cod7=" + cod7 + "&rand=" + mi_aleatorio;

    miPeticion.open("GET", vinculo, true);//ponemos true para que la petici�n sea asincr�nica
    miPeticion.onreadystatechange = miPeticion.onreadystatechange = function () {
        if (miPeticion.readyState === 4)
        {
            //alert(miPeticion.readyState);
            if (miPeticion.status === 200)
            {
                //alert(miPeticion.status);
                //var http=miPeticion.responseXML;
                var http = miPeticion.responseText;
                document.getElementById(div).innerHTML = http;

            }
        }
    };
    miPeticion.send(null);
}


function from_unico(var1, div, url) {
    var mi_aleatorio = parseInt(Math.random() * 99999999);//para que no guarde la p�gina en el cach�...
    var vinculo = url + "?cod=" + var1 + "&rand=" + mi_aleatorio;
    //alert(vinculo);
    miPeticion.open("GET", vinculo, true);//ponemos true para que la petici�n sea asincr�nica
    miPeticion.onreadystatechange = miPeticion.onreadystatechange = function () {
        if (miPeticion.readyState === 4)
        {
            //alert(miPeticion.readyState);
            if (miPeticion.status === 200)
            {
                //alert(miPeticion.status);
                //var http=miPeticion.responseXML;
                var http = miPeticion.responseText;
                document.getElementById(div).innerHTML = http;

            }
        }/*else
         {
         document.getElementById(ide).innerHTML="<img src='ima/loading.gif' title='cargando...' />";
         
         }*/
    }
    miPeticion.send(null);

}

//***************************************************************************************
function fromss(idgrado, idse, idseccion, url) {
    var mi_aleatorio = parseInt(Math.random() * 99999999);//para que no guarde la p�gina en el cach�...
    var vinculo = url + "?id_grado=" + idgrado + "&id_seccion=" + idse + "&rand=" + mi_aleatorio;
    //alert(vinculo);
    miPeticion.open("GET", vinculo, true);//ponemos true para que la petici�n sea asincr�nica
    miPeticion.onreadystatechange = miPeticion.onreadystatechange = function () {
        if (miPeticion.readyState == 4)
        {
            //alert(miPeticion.readyState);
            if (miPeticion.status == 200)
            {
                //alert(miPeticion.status);
                //var http=miPeticion.responseXML;
                var http = miPeticion.responseText;
                document.getElementById(idseccion).innerHTML = http;

            }
        }/*else
         {
         document.getElementById(ide).innerHTML="<img src='ima/loading.gif' title='cargando...' />";
         
         }*/
    }
    miPeticion.send(null);
}
//************************************************************************************************
function limpiar()
{
    document.form.reset();

}

function limpiara()
{
    document.form.txtseccion.reset();
    document.form.txtidalumno.reset();


}