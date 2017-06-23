<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="row">
    <div id="breadcrumb" class="col-md-12">
        <ol class="breadcrumb">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="#">Importaciones</a></li>
            <li><a href="#">Registrar Desaduanaje</a></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12">
        <div class="box">
            <div class="box-header">
                <div class="box-name">
                    <i class="fa fa-search"></i>
                    <span>Desaduanaje</span>
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
                <h4 class="page-header">Formulario de Registro</h4>
                <form class="form-horizontal" role="form" method="POST" action="#" id="form_reg">
                    <div class="form-group has-success">
                        <label class="col-sm-2 control-label">Orden de Compra</label>
                        <div class="col-sm-2 has-feedback">                        
                            <span class="fa fa-tags txt-success form-control-feedback"></span>
                            <input type="text" class="form-control" name="numero_oc" id="numero_oc" placeholder="Numero">                        
                        </div>
                        <div class="col-sm-2 has-feedback">
                            <input type="text" class="form-control" placeholder="Fecha" id="fec_oc" name="fec_oc">
                            <span class="fa fa-calendar txt-success form-control-feedback"></span>
                        </div>
                        <label class="col-sm-2 control-label">Factura</label>
                        <div class="col-sm-2 has-feedback">
                            <span class="fa fa-tags txt-success form-control-feedback"></span>
                            <input type="text" class="form-control" placeholder="Número" name="numero_fac" id="numero_fac">                        
                        </div>
                        <div class="col-sm-2 has-feedback">
                            <input type="text" class="form-control" placeholder="Fecha" id="fec_fac" name="fec_fac">
                            <span class="fa fa-calendar txt-success form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="form-group has-success">
                        <label class="col-sm-2 control-label">Desaduanaje</label>
                        <div class="col-sm-2 has-feedback">
                            <input type="text" class="form-control" placeholder="Fecha Inicio">
                            <span class="fa fa-calendar txt-success form-control-feedback"></span>
                        </div>
                        <div class="col-sm-2 has-error has-feedback">
                            <input type="text" class="form-control" placeholder="Fecha Fin">
                            <span class="fa fa-calendar txt-danger form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Regimén Aduanero</label>
                        <div class="col-sm-4 has-feedback">
                            <select class="form-control">
                                <option>IMPORTACIÓN DEFINITIVA (10)</option>
                                <option>DEPOSITO ADUANERO (70)</option>
                            </select>
                        </div>

                        <label class="col-sm-2 control-label">Modalidad</label>
                        <div class="col-sm-4 has-feedback">
                            <select class="form-control">
                                <option>DIFERIDO</option>
                                <option>NORMAL</option>
                            </select>
                        </div>                    
                    </div>                                
                    <hr/>                                                
                    <div class="form-group has-warning">
                        <label class="col-sm-2 control-label">Fecha Nacionalización</label>
                        <div class="col-sm-2 has-feedback">
                            <span class="fa fa-calendar form-control-feedback"></span>
                            <input type="text" class="form-control" placeholder="Fecha" data-toggle="tooltip" data-placement="bottom" title="Ingrese número de Orden de Compra">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Número DAM</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" placeholder="Número" data-toggle="tooltip" data-placement="bottom" title="Ingrese número de Orden de Compra">

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Fecha Numeración</label>
                        <div class="col-sm-2 has-feedback">
                            <span class="fa fa-calendar form-control-feedback"></span>
                            <input type="text" class="form-control" placeholder="Fecha" data-toggle="tooltip" data-placement="bottom" title="Ingrese número de Orden de Compra">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Fecha Pago DAM</label>
                        <div class="col-sm-2 has-feedback">
                            <span class="fa fa-calendar form-control-feedback"></span>
                            <input type="text" class="form-control" placeholder="Fecha" data-toggle="tooltip" data-placement="bottom" title="Ingrese número de Orden de Compra">
                        </div>
                    </div>                
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Canal</label>
                        <div class="col-sm-2">
                            <select class="form-control">
                                <option>ROJO</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Fecha Levante</label>
                        <div class="col-sm-2 has-feedback">
                            <input type="text" class="form-control" placeholder="Fecha" data-toggle="tooltip" data-placement="bottom" title="Ingrese número de Orden de Compra">
                            <span class="fa fa-calendar form-control-feedback"></span>
                        </div>
                    </div>                
                    <div class="form-group has-feedback">
                        <label class="col-sm-2 control-label">Fecha Retiro Aduana</label>
                        <div class="col-sm-2">
                            <input type="text" id="fec_retiro" class="form-control" placeholder="Fecha">
                            <span class="fa fa-calendar form-control-feedback"></span>
                        </div>                    
                    </div>                                
                    <div class="clearfix"></div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-2">
                            <button type="cancel" class="btn btn-default btn-label-left">
                                <span><i class="fa fa-clock-o txt-danger"></i></span>
                                Cancel
                            </button>
                        </div>
                        <div class="col-sm-2">

                        </div>
                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-primary btn-label-left">
                                <span><i class="fa fa-clock-o"></i></span>
                                Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
// Run Select2 plugin on elements
//function DemoSelect2(){
//	$('#s2_with_tag').select2({placeholder: "Select OS"});
//	$('#s2_country').select2();
//}
// Run timepicker
//function DemoTimePicker(){
//	$('#input_time').timepicker({setDate: new Date()});
//}
    $(document).ready(function () {
        // Create Wysiwig editor for textare
        TinyMCEStart('#wysiwig_simple', null);
        TinyMCEStart('#wysiwig_full', 'extreme');
        // Add slider for change test input length
        FormLayoutExampleInputLength($(".slider-style"));
        // Initialize datepicker
        $('#input_date').datepicker({setDate: new Date()});
        $('#fec_oc').datepicker({setDate: new Date()});
        $('#fec_fac').datepicker({setDate: new Date()});
        $('#fec_retiro').datepicker({setDate: new Date()});
        // Load Timepicker plugin
        LoadTimePickerScript(DemoTimePicker);
        // Add tooltip to form-controls
        $('.form-control').tooltip();
        LoadSelect2Script(DemoSelect2);
        // Load example of form validation
        LoadBootstrapValidatorScript(DemoFormValidator);
        // Add drag-n-drop feature to boxes
        WinMove();
    });
</script>





