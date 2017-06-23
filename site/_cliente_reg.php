<?php
header("Cache-Control: no-cache, must-revalidate");
$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["conectado"])) {
    if ($_SESSION["conectado"] == 'SI') {
        //session_start();
        include '../controller/C_Cliente.php';
        $obj_ubic = new Ubicacion();
//$list_depa = $obj_ubic->getDepartamentos();
        $list_zona = $obj_ubic->getSubZonaByZona();
        $list_ubic = $obj_ubic->getDepaProvDist();
        ?>
        <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="utf-8">
                <title>Humasoft</title>
                <meta name="description" content="description">
                <meta name="author" content="Juan">
                <?php include 'head.php'; ?>   
            </head>
            <body> 
                <?php include 'header.php'; ?>
                <!--End Header-->

                <!--Start Container-->
                <div id="main" class="container-fluid">
                    <div class="row">
                        <div id="sidebar-left" class="col-xs-2 col-sm-2">
                            <?php include 'menu.php'; ?>
                        </div>
                        <!--Start Content-->                        
                        <div id="content" class="col-xs-12 col-sm-10">
                            <div class="row">
                                <div id="breadcrumb" class="col-md-12">
                                    <ol class="breadcrumb">
                                        <li><a href="Dashboard.php">Dashboard</a></li>
                                        <li><a href="#">Clientes</a></li>
                                        <li><a href="_cliente_reg.php">Registrar Cliente</a></li>
                                    </ol>
                                </div>
                            </div>
                            <div class="row">                        
                                <div class="col-xs-12 col-sm-12">
                                    <div class="box">
                                        <div class="box-header">
                                            <div class="box-name">
                                                <i class="fa fa-briefcase"></i>
                                                <span>Registrar Cliente</span>
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
                                        <div class="box-content form-horizontal">                                                                    

                                            <h4 class="page-header" style="text-align: center;">Llenar Datos de Cliente</h4>
                                            <form id="form" name="form" action="#" method="post" enctype="multipart/form-data">

                                                <div id="form_reg">
                                                    <div class="panel panel-default">
                                                        <div class="panel-body">
                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <label class="control-label ">RUC o DNI</label>  <span class="text-danger">(*)</span>
                                                                    <input type="text" id="codigo" maxlength="15" value="" placeholder="NRO RUC" name="codigo" required="" class="form-control">                                
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <label class="control-label ">Razon Social</label>  <span class="text-danger">(*)</span>
                                                                    <input type="text" id="nombre" maxlength="80" value="" placeholder="Razon Social" name="nombre" required="" class="form-control">
                                                                </div>   
                                                                <div class="col-sm-3">
                                                                    <label class="control-label ">Abreviatura</label> <span class="text-danger">(*)</span>
                                                                    <input type="text" maxlength="10" id="abrev" value="" placeholder="Ejemplo: AGRHU" name="abrev" required="" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <label class="control-label ">Página Web</label>
                                                                    <input type="text" maxlength="70" id="web" value="" placeholder="www.ejemplo.com" name="web"  class="form-control">
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <label class="control-label ">Teléfono</label>
                                                                    <input type="text" maxlength="15" id="telefono" value="" placeholder="Telefono" name="telefono"  class="form-control">
                                                                </div>

                                                                <div class="col-sm-6">
                                                                    <label class="control-label ">Dirección</label>
                                                                    <input type="text" maxlength="100" id="direccion" value="" placeholder="Direccion" name="direccion"  class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <label class="control-label ">Zona (Opcional)</label>
                                                                    <select name="zona" id="zona">
                                                                        <option value="0">seleccione...</option>
                                                                        <?php
                                                                        foreach ($list_zona as $zona) {
                                                                            echo '<option value="' . $zona['codzona'] . '-' . $zona['codsubzona'] . '">' . $zona['zona'] . ' - ' . $zona['subzona'] . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <label class="control-label ">Departamento - Provincia - Distrito</label>
                                                                    <select name="ubicacion" id="ubicacion">
                                                                        <option value="0">seleccione...</option>
                                                                        <?php
                                                                        foreach ($list_ubic as $ubic) {
                                                                            echo '<option value="' . $ubic['codigo'] . '">' . $ubic['ubicacion'] . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row" hidden="">
                                                                <div class="col-sm-4">
                                                                    <label class="control-label ">Departamento</label>
                                                                    <select id="departamento" name="departamento" onchange="loadProvByDepa()">
                                                                        <option value="0">seleccione...</option>
                                                                        <?php
//                                                    foreach ($list_depa as $depa) {
//                                                        echo '<option value="' . $depa['coddepa'] . '">' . $depa['departamento'] . '</option>';
//                                                    }
                                                                        ?>
                                                                    </select>                                                
                                                                </div>                                            
                                                                <div class="col-sm-4" id="divprovincia">
                                                                    <label class="control-label ">Provincia</label>
                                                                    <select id="provincia" name="provincia" onchange="loadDistByProv()" class="form-control">
                                                                        <option value="0">seleccione...</option>                                                    
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-4" id="divdistrito">
                                                                    <label class="control-label ">Distrito</label>
                                                                    <select id="ciudad" name="ciudad" class="form-control">
                                                                        <option value="0">seleccione...</option>                                                    
                                                                    </select>                                                
                                                                </div>
                                                            </div>                                        
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <label class="control-label ">Notas</label>
                                                                    <textarea name="notas" id="notas" class="form-control" rows="4" cols="20"></textarea>
                                                                </div>                            
                                                            </div>                                                                        
                                                        </div>
                                                    </div>
                                                    <center>
                                                        <input type="submit" value="Guardar" class="btn btn-primary" />
                                                        <a href="#" onclick="cargar('#principal', '_cliente.php')" class="btn btn-danger">Regresar</a>
                                                        <input type="hidden" id="accion" name="accion" value="RegCliente" />                    
                                                    </center>
                                                </div>                       
                                            </form>
                                            <br/>
                                            <p><div id="result"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                        <!--End Content-->
                    </div>
                </div>
                <!--End Container-->
                <?php include 'script.php'; ?>

                <script type="text/javascript">

                    function loadProvByDepa() {
                        var coddepa = $('#departamento').val();
                        from_2('LoadProvincia', coddepa, 'divprovincia', '_cliente_reg_load.php');
                    }

                    function loadDistByProv() {
                        var codprov = $('#provincia').val();
                        from_2('LoadDistrito', codprov, 'divdistrito', '_cliente_reg_load.php');
                    }

                    function Select2Test() {
                        $("#departamento").select2();
                        $("#zona").select2();
                        $("#ubicacion").select2();
                        //$("#ciudad").select2();
                    }
                    $(document).ready(function () {
                        LoadSelect2Script(Select2Test);
                        WinMove();

                        $("#form").submit(function (event) {
                            event.preventDefault();

                            var formData = new FormData(document.getElementById("form"));

        //                    var depa = $("#departamento option:selected").html();
        //                    var prov = $("#provincia option:selected").html();
        //                    var dist = $("#ciudad option:selected").html();
                            var ubic = $("#ubicacion option:selected").html();
        //                    formData.append("departamento", depa);
        //                    formData.append("provincia", prov);
        //                    formData.append("ciudad", dist);
                            formData.append("ubicacion_desc", ubic);
                            $.ajax({
                                url: "../controller/C_Cliente.php",
                                type: "post",
                                dataType: "html",
                                data: formData,
                                cache: false,
                                contentType: false,
                                processData: false
                            })
                                    .done(function (res) {
                                        $("#result").html(res);
                                    });
                        });

                    });
                </script>
            </body>
        </html>
        <?php
    }
} else {
    header("Location:recursos/logout.php");
}
?>