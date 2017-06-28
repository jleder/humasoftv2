<?php
include '../controller/C_Reportes.php';
$obj1 = new C_Reportes();
$obj2 = new C_Reportes();

$id = $_GET['cod'];
if ($id != 'nuevo' && $id != '0') {
    $obj1->__set('codfundo', $id);
    $lista1 = $obj1->cargarLotexFundo();

    $obj2->__set('codfundo', $id);
    $lista2 = $obj2->cargarLotexFundo();
} else {
    $lista1;
    $lista2;
}
?>
<script>
//    function cargarlotetestigo() {
//        var codlote = $("#codlotetestigo").val();        
//        var divtestigo = $("#divtestigo").val();
//        if (codlote === 'nuevo') {
//            divtestigo.style.display = "block";
//        } else {
//            divtestigo.style.display = "none";
//            from_unico(codlote, 'divlotetestigo', '_reptecnicov2_loadlotetest.php');
//        }
//    }    
</script>

<div class="col-lg-6">
    <div class="panel panel-info">
        <div class="panel-heading">Lote Huma Gro</div>
        <div class="panel-body">
            <div class="form-group">
                <div class="col-sm-12">
                    <label class="control-label">Lote Huma Gro</label>
                    <select onchange="cargarlotehuma()" onblur="cargarlotehuma()" name="codlotehuma" class="form-control" id="codlotehuma">                                    
                        <option value="NULL">..::NINGUNO::..</option>
                        <option value="nuevo">..::CREAR NUEVO LOTE::..</option>
                        <?php foreach ($lista1 as $value) { ?>
                            <option value="<?php echo trim($value[0]); ?>"><?php echo trim($value[1]); ?></option>
                        <?php } ?>
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
                    <label class="control-label">Lote Testigo</label>
                    <select onchange="cargarlotetestigo()" onblur="cargarlotetestigo()" name="codlotetestigo" class="form-control" id="codlotetestigo">
                        <option value="ninguno">..::NINGUNO::..</option>
                        <option value="nuevo">..::CREAR NUEVO LOTE::..</option>
                        <?php foreach ($lista2 as $value2) { ?>
                            <option value="<?php echo trim($value2[0]); ?>"><?php echo trim($value2[1]); ?></option>
                        <?php } ?>
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

