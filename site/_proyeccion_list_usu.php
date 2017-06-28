<?php
header("Cache-Control: no-cache, must-revalidate");
$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["conectado"])) {
    if ($_SESSION["conectado"] == 'SI') {

        include '../controller/C_Proyecciones.php';
        $proy = new Proyeccion();
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
                                        <li><a href="#">Proyección</a></li>
                                        <li><a href="#">Listado de Proyecciones</a></li>
                                    </ol>
                                </div>
                            </div>

                            <div class="row">                        
                                <div class="col-xs-12 col-sm-12">
                                    <div class="box">
                                        <div class="box-header">
                                            <div class="box-name">
                                                <i class="fa fa-briefcase"></i>
                                                <span>Listado de Proyecciones </span>
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
                                            <div class="form-group">
                                                <label class="col-md-1 control-label">Asesor</label>
                                                <div class="col-md-2">
                                                    <select id="codasesor"  name="codasesor">
                                                        <option value="<?php echo $_SESSION['codpersona']; ?>"><?php echo $_SESSION['nombreUsuario']; ?></option>                                                            
                                                    </select>                                                      
                                                </div>
                                                <label class="col-md-1 control-label">Mes</label>
                                                <div class="col-md-2">
                                                    <select name="proy_mes" id="proy_mes">
                                                        <option value="0">- Seleccione -</option>
                                                        <?php
                                                        $meses = $proy->cargarMeses();
                                                        foreach ($meses as $key => $mes) {
                                                            ?>                                
                                                            <option value="<?php echo trim($key); ?>"> <?php echo trim($mes); ?></option>
                                                        <?php } ?>                                                    
                                                    </select>                                                        
                                                </div>
                                                <label class="col-md-1 control-label">Año</label>
                                                <div class="col-md-2"><input type="number" name="proy_ano" id="proy_ano" value="<?php echo date("Y"); ?>"/></div>
                                                <div class="col-md-2">
                                                    <button type="button" id="btn_consultar" class="btn btn-primary btn-label-left"><span><i class="fa fa-plus-circle"></i></span> Listar</button>
                                                </div>
                                            </div>
                                            <hr/>
                                            <div class="form-group">
                                                <div class="col-md-12" id="divresult"></div>
                                            </div>
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

                    function Select2Test() {
                        $("#proy_mes").select2();
                        $("#codcliente").select2();
                        $("#codasesor").select2();
                        $("#codprod").select2();
                        $("#cultivo").select2();
                    }

                    $(document).ready(function () {                        

                        $('#btn_consultar').on('click', function () {

                            var codasesor = $("#codasesor").val();
                            var proy_mes = $("#proy_mes").val();
                            var proy_ano = $("#proy_ano").val();

                            var objeto = {
                                codasesor: codasesor,
                                proy_mes: proy_mes,
                                proy_ano: proy_ano
                            };

                            $.ajax({
                                url: '_proyeccion_queryasesor_result.php',
                                type: 'post',
                                dataType: 'html',
                                success: function (res) {
                                    $("#divresult").html(res);
                                    //location.reload();
                                },
                                error: function (jqXHR, status, error) {
                                    alert('Disculpe, existió un problema');
                                },
                                complete: function (jqXHR, status) {
                                    //$("#" + divcomentario).load('_propuestav2_coment_list.php?coditem=' + coditem + '&corredor=' + corredor);
                                },
                                data: {obj: objeto}
                            });


                        });


                        LoadSelect2Script(Select2Test);
                        WinMove();
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