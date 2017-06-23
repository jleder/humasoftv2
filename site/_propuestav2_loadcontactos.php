<?php
include '../controller/C_Propuestas.php';
$pro = new C_Propuesta();

$codcliente = $_GET['cod'];
$pro->__set("codcliente", $codcliente);

$lista = $pro->loadContactosByCodCliente();
?>
<div class="col-lg-2">
    Contactos:
    <select class="form-control " name="contacto" id="contacto" onblur="" onchange="personalizarContacto()">
        <option value="0">seleccione...</option>
        <?php
        if (count($lista) > 0) {
            foreach ($lista as $contacto) {
                ?>
                <option value="<?php echo trim($contacto['nombre']); ?>"><?php echo trim($contacto['nombre']); ?></option>
                <?php
            }
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
<div class="col-lg-2">
    Trato:                                                        
    <select class="form-control " name="trato" id="trato" onchange="personalizarTrato()">
        <option value=""></option>
        <option value="Sr.">Sr.</option>
        <option value="Sra.">Sra.</option>
        <option value="Sres.">Sres.</option>
        <option value="Ing.">Ing.</option>
        <option value="otro">Otro</option>
    </select>
</div>
<div style="display: none" id="divtrato" class="col-lg-2">
    Escribir Trato:
    <input type = "text" name="newtrato" id="newtrato" value = "" class="form-control " />
</div>
<div style="display: none" id="divnewcontacto" class="col-lg-4">
    Contacto Personalizado:
    <input type = "text" name="newcontacto" id="newcontacto" value = "" class="form-control " placeholder="Ing. Juan Perez e Ing. Carlos Lopez" />
</div>






