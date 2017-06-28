<?php
include '../controller/C_Solicitud.php';
$desp = new C_Despacho();

$coddesp = $_GET['coddesp'];
$desp->__set('coddesp', $coddesp);

$lista = $desp->despachosByCoddesp();
?>
<script>
    $(document).ready(function () {
        $("#despacho_mod").submit(function (e) {
            e.preventDefault();
            var f = $(this);            
            var formData = new FormData(document.getElementById("despacho_mod"));
            formData.append("accion", 'ActDespacho');

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
                        $("#resultado4").html(res);
                    });
        });
    });

</script>
<form id="despacho_mod" name="despacho_mod" action="#" method="POST" enctype="multipart/form-data">                    
    <div class="panel panel-warning">
        <div class="panel-heading">Actualizar Despacho</div>
        <div class="panel-body" style="font-size: 0.8em;">                                            
            <div class="row">                                
                <div class="col-lg-6">Prioridad
                    <select name="prioridad" id="prioridad" class="form-control input-sm">                                        
                        <option value="<?php echo $lista[2]; ?>"><?php echo $lista[2]; ?></option>
                        <option value="<?php echo $lista[2]; ?>">cambiar por...</option>
                        <option value="NORMAL">NORMAL (72hrs)</option>
                        <option value="URGENTE">URGENTE (48hrs)</option>
                        <option value="MUY URGENTE">MUY URGENTE</option>
                    </select> 
                </div>
                <div class="col-lg-6">Entrega Prevista
                    <input type="text" name="fecprev" id="cal" class="form-control input-sm" value="<?php echo date("Y/m/d", strtotime($lista[3])); ?>" />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">Monto Despachado
                    <input type="number" step="any" name="montodesp" class="form-control input-sm" value="<?php echo $lista[6]; ?>" />
                </div>                                
                <div class="col-lg-4">Saldo
                    <input type="number" step="any" name="saldo" class="form-control input-sm" value="<?php echo $lista[7]; ?>" />
                </div>                                
                <div class="col-lg-4">Moneda
                    <?php
                    $moneda = '$. DOLAR';
                    if ($lista[8] <> '$') {
                        $moneda = 'S/. SOLES';
                    }
                    ?>
                    <select name="moneda" id="moneda" class="form-control input-sm">
                        <option value="<?php echo $lista[8]; ?>"><?php echo $moneda; ?></option>
                        <option value="<?php echo $lista[8]; ?>">cambiar por...</option>
                        <option value="$">$. DOLAR</option>
                        <option value="S/.">S/. SOLES</option>
                    </select>
                </div>                                
            </div>
            <div class="row">
                <div class="col-lg-12">Descripción:
                    <input type="text" maxlength="90" name="descripcion" class="form-control input-sm" value="<?php echo $lista[4]; ?>" required="" />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">Observación:
                    <textarea class="form-control" name="obs" rows="4" cols="5"><?php echo $lista[5]; ?></textarea>
                </div>
            </div> 
            <br/>
            <div class="row" style="text-align: center">
                <input type="submit" value="Actualizar" class="btn btn-success" />
                <input type="hidden" name="codprop" id="codprop" value="<?php echo $lista[1]; ?>" />
                <input type="hidden" name="coddesp" id="coddesp" value="<?php echo $lista[0]; ?>" />
            </div>
        </div>
    </div>            
</form>

<div id="resultado4"></div>