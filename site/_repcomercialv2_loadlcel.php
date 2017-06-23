<?php
include '../controller/C_Reportes.php';
$obj = new C_Reportes();

$id = $_GET['cod'];
$obj->__set('codcontacto', $id);

$lista = $obj->getContactoByID();
if (count($lista) > 0) {
    ?>
<div class="col-lg-2">         
        <input placeholder="Celular Contacto" required="" maxlength="15" class="form-control" type="text"  name="celcontacto" id="celcontacto" value="<?php echo $lista[4]?>" />
    </div>
    <div class="col-lg-2">                
        <input placeholder="Cargo Contacto" maxlength="30" type="text" class="form-control" name="carcontacto" id="carcontacto" value="<?php echo $lista[2]?>"  />
    </div>

    

<?php } else { ?>
    <div class="col-lg-2"> 
        Celular Contacto:
        <input maxlength="15" class="form-control" type="text"  name="celcontacto" id="celcontacto" value="" />
    </div>
    <div class="col-lg-2">        
        Cargo Contacto:
        <input maxlength="30" type="text" class="form-control" name="carcontacto" id="carcontacto" value=""  />
    </div>
<?php } ?>
