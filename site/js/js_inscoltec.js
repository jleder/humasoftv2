function mostrarOcultar(opc, id) {
                var sist = document.getElementById(id);                
                if (opc === 1) {
                    sist.style.display = "block";                    
                }
                if (opc === 2) {
                    sist.style.display = "none";                    
                }
            }
            
function cargar(div, pagina)
{
    $(div).load(pagina);
}

function convertMayuscula(id){
            var etiqueta = document.getElementById(id);
            var texto = etiqueta.value.toUpperCase();            
            etiqueta.value = texto;                       
        }

function hola(){
    alert('Jeje');
}

function calcularMedia(){
    alert("hola mundo");
}

function imprSelec(id)
{
    var ficha = document.getElementById(id);
    var ventimp = window.open(' ', 'popimpr');
    ventimp.document.write(ficha.innerHTML);
    ventimp.document.close();
    ventimp.print();
    ventimp.close();
}

function confirmSubmit()
{
    var agree = confirm("¿Desea realmente ELIMINAR este registro?");
    if (agree)
        return true;
    else
        return false;
}

//METODO PARA EL CALENDARIO 
$(function() {
    var dateToday = new Date();
    var dates = $( "#cal, #to" ).datepicker({
        dateFormat: 'yy/mm/dd',
        changeMonth: true,
        changeYear: true,
        //minDate: dateToday,
        monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'MiÃ©rcoles', 'Jueves', 'Viernes', 'Sabado'],
        dayNamesShort: ['Dom','Lun','Mar','Mie','Juv','Vie','Sab'],
        dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
        weekHeader: 'Sm',
        defaultDate: "w",
                    
        numberOfMonths: 1,
        onSelect: function( selectedDate ) {
            var option = this.id == "cal" ? "minDate" : "maxDate",
            instance = $( this ).data( "datepicker" ),
            date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings );
            dates.not( this ).datepicker( "option", option, date );
        }
    });
});

//METODO PARA EL CALENDARIO  2
$(function() {
    var dateToday = new Date();
    var dates = $( "#cal2, #to" ).datepicker({
        dateFormat: 'yy/mm/dd',
        changeMonth: true,
        changeYear: true,
        //minDate: dateToday,
        monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'MiÃ©rcoles', 'Jueves', 'Viernes', 'Sabado'],
        dayNamesShort: ['Dom','Lun','Mar','Mie','Juv','Vie','Sab'],
        dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
        weekHeader: 'Sm',
        defaultDate: "+1d",
                    
        numberOfMonths: 1,
        onSelect: function( selectedDate ) {
            var option = this.id == "cal2" ? "minDate" : "maxDate",
            instance = $( this ).data( "datepicker" ),
            date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings );
            dates.not( this ).datepicker( "option", option, date );
        }
    });
});



//Nuevo metodo a implementar
//var dateToday = new Date();
//var dates = $("#from, #to").datepicker({
//    defaultDate: "+1w",
//    changeMonth: true,
//    numberOfMonths: 3,
//    minDate: dateToday,
//    onSelect: function(selectedDate) {
//        var option = this.id == "from" ? "minDate" : "maxDate",
//            instance = $(this).data("datepicker"),
//            date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
//        dates.not(this).datepicker("option", option, date);
//    }
//});