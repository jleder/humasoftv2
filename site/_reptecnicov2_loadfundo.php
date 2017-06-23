<?php
include '../controller/C_Reportes.php';
$obj = new C_Reportes();

$codcliente = $_GET['cod1'];
$atendido = $_GET['cod2'];
$obj->__set('codcliente', $codcliente);

$lista = $obj->cargarEncargadoxCliente();
$lfundo = $obj->cargarFundoxClienteOrdeByCod();
$numRep = $obj->generarCodRepTecnico($atendido);
?>
<script>
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

    function loadRubrica() {
        var id_cliente = $("#codcliente").val();
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


</script>
<div class="form-group">
    <label class="col-sm-2 control-label">Fundo <span class="obl">(*)</span>:</label>
    <div class="col-lg-2">                                        
        <select class="form-control " name="codfundo" id="codfundo" onblur="cargarLote()" onchange="cargarLote()">                
            <option value="0">..::Seleccione Fundo</option>
            <?php
            if (count($lfundo) > 0) {
                for ($i = 0; $i < (count($lfundo)); $i++) {
                    ?>
                    <option value="<?php echo trim($lfundo[$i][1]); ?>"><?php echo trim($lfundo[$i][2]); ?></option>
                    <?php
                }
            }
            ?>                                         
            <option value="nuevo">..::Otro</option>
        </select>
    </div>
    <div id="divnvofundo" class="col-sm-2" hidden="">        
        <input maxlength="80" class="form-control" id="nomfundo" type="text" name="nomfundo" value="" placeholder="Nombre de Fundo" />
    </div>
</div>

<div class="col-lg-2">

    Contacto <span class="obl">(*)</span>:
    <select class="form-control" name="contacto" id="contacto" onblur="loadRubrica()" onchange="loadRubrica()">
        <option value="0">..::Seleccione</option>
        <?php
        if (count($lista) > 0) {
            for ($i = 0; $i < (count($lista)); $i++) {
                ?>
                <option value="<?php echo trim($lista[$i][0]) ?>"><?php echo trim($lista[$i][0]) . ' - ' . $lista[$i][1]; ?></option>
            <?php }
            ?>
            <option value="otro">..::Otro</option>
            <?php
        } else {
            ?>
            <option value="otro">..::Otro</option>
        <?php }
        ?>                                         
    </select>
</div>
<div id="divencargado" hidden="">
    <div class="col-lg-2">
        Nombre Contacto:
        <input maxlength="50" type="text" class="form-control" name="newcontacto" id="newcontacto" value=""  />
    </div>
    <div class="col-lg-2">
        Cargo Contacto:
        <input maxlength="30" type="text" class="form-control" name="carcontacto" id="carcontacto" value=""  />
    </div>
    <div class="col-lg-2">
        Celular Contacto:
        <input maxlength="15" type="text" class="form-control" name="celcontacto" id="celcontacto" value=""  />
    </div>
</div>
<div class="col-lg-2">
    Número Reporte:
    <input maxlength="20" type="text" class="form-control" name="codrep" id="codrep" value="<?php echo $numRep; ?>"  />
</div>