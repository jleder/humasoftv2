<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../controller/C_Reportes.php';
$obj = new C_Reportes();

$codrep = $_GET['cod'];
$obj->__set('codrep', trim($codrep));
$lista = $obj->listarRepTecnicoxCod();

$fecreg = date("Y/m/d", strtotime($lista[24]));
$fechavisita = date("Y/m/d", strtotime($lista[8]));
$horaingreso = $obj->arreglarHora($lista[9], $lista[10]);
$horasalida = $obj->arreglarHora($lista[11], $lista[12]);
?>
<!--calendario-->        
<script type="text/javascript" src="js/js_inscoltec.js"></script>        
<style type="text/css">            
    @import "util/media/themes/smoothness/jquery-ui-1.8.4.custom.css";            
</style> 
<script>

    $(document).ready(function () {
        $("#form").submit(function (e) {
            e.preventDefault();

            var f = $(this);
            var formData = new FormData(document.getElementById("form"));

            $.ajax({
                url: "../controller/C_Reportes.php",
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            })
                    .done(function (res) {
                        $("#principal").html(res);
                    });
        });
    });
</script>
<div class="box">
    <div class="box-header">
                            <div class="box-name">
                                <i class="fa fa-list-alt"></i>
                                <span>Editar Reporte Comercial</span>
                            </div>
                            <div class="box-icons">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="expand-link">
                                    <i class="fa fa-expand"></i>
                                </a>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                            <div class="no-move"></div>
                        </div>
    <div class="box-content">
        <form id="form" name="form" action="#" method="POST">
            <div class="row">
                <div class="col-lg-2">
                    Código de Reporte
                    <input class="form-control" name="codrep" id="codrep" readonly="" value="<?php echo trim($lista[0]); ?>" />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    Cliente
                    <select class="form-control" name="cliente">
                        <option value="<?php echo $lista[1]; ?>"><?php echo strtoupper($lista[2]); ?></option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    Contacto
                    <input class="form-control " name="contacto" id="contacto" value="<?php echo strtoupper($lista[7]); ?>" />
                </div>
                <div class="col-lg-2">
                    Fecha de Registro
                    <input class="form-control " name="fecreg" id="cal2" value="<?php echo $fecreg; ?>" />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2">
                    Fecha de Visita
                    <input class="form-control " name="fechavisita" id="cal" value="<?php echo $fechavisita; ?>" />
                </div>
                <div class="col-lg-2">
                    Hora Ingreso            
                    <?php echo $obj->generarHoraActualizada('horaingreso', 'form-control ', $horaingreso); ?>
                </div>
                <div class="col-lg-2">
                    Hora Salida
                    <?php echo $obj->generarHoraActualizada('horasalida', 'form-control ', $horasalida); ?>
                </div>
            </div>    
            <br/>
            <div class="row">
                <div class="col-lg-6" style="text-align: center;">
                    <input type="submit" class="btn btn-success btn-sm" value="Guardar" />
                    <input type="hidden" name="accion" value="ModRepComAdmin" />
                </div>
            </div>
            <br/>
        </form>
        <p id="principal"></p>
    </div>

</div>
