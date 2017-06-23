<?php
include '../controller/C_Cliente.php';
$obj = new C_Cliente();
$obj_ubic = new Ubicacion();

$id = $_GET['id'];
$obj->__set('codcliente', trim($id));
$lista = $obj->getClienteByID();
$list_zona = $obj_ubic->getSubZonaByZona();
$list_ubic = $obj_ubic->getDepaProvDist();

$validado = 'Si';
if ($lista[9] == 'f') {
    $validado = 'No';
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />                    
        <link rel="stylesheet" href="css/layout_html5.css" type="text/css" media="all" />

    </head>
    <body> 
        <div class="row">
            <div id="breadcrumb" class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="#">Clientes</a></li>
                    <li><a href="#">Actualizar Datos de Clientes</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="box">
                    <div class="box-header">
                        <div class="box-name">
                            <i class="fa fa-edit"></i>
                            <span>Cliente</span>
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
                        <h4 class="page-header">Actualizar Datos de Cliente</h4>
                        <form id="form" name="form" action="#" method="post" enctype="multipart/form-data">
                            <div id="form_reg">
                                <div class="row">
                                    <div class="col-sm-3">
                                        Nro RUC
                                        <input type="text" maxlength="15" id="codcliente" value="<?php echo $lista[0] ?>" placeholder="NRO RUC" name="codcliente" required="" class="form-control">
                                        <input type="hidden" id="codigoactual" value="<?php echo $lista[0] ?>" placeholder="NRO RUC" name="codigoactual" required="" class="form-control">
                                    </div>
                                    <div class="col-sm-6">
                                        Razon Social
                                        <input type="text" maxlength="80" id="nombre" value="<?php echo $lista[1] ?>" placeholder="Razon Social" name="nombre" required="" class="form-control">
                                    </div> 
                                    <div class="col-sm-3">
                                        Abreviatura
                                        <input type="text" maxlength="10" id="abrev" value="<?php echo $lista[5] ?>" placeholder="Abreviatura" name="abrev" required="" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        Página Web
                                        <input type="text" maxlength="70" id="web" value="<?php echo $lista[4] ?>" placeholder="Página Web" name="web" class="form-control">
                                    </div>
                                    <div class="col-sm-3">
                                        Telefono
                                        <input type="text" maxlength="15" id="telefono" value="<?php echo $lista[3] ?>" placeholder="Telefono" name="telefono" class="form-control">
                                    </div>                            
                                    <div class="col-sm-6">
                                        Dirección
                                        <input type="text" maxlength="100" id="direccion" value="<?php echo $lista[2] ?>" placeholder="Direccion" name="direccion"  class="form-control">
                                    </div>
                                </div>
                                <div class="row">


                                    <div class="col-sm-4">
                                        Zona
                                        <select name="zona" id="zona">
                                            <option value="<?php echo $lista[13] . '-' . $lista[15]; ?>"><?php echo $lista[14] . ' - ' . $lista[16]; ?></option>
                                            <option value="<?php echo $lista[13] . '-' . $lista[15]; ?>">cambiar por...</option>
                                            <?php
                                            foreach ($list_zona as $zona) {
                                                echo '<option value="' . $zona['codzona'] . '-' . $zona['codsubzona'] . '">' . $zona['zona'] . ' - ' . $zona['subzona'] . '</option>';
                                            }
                                            ?>
                                        </select>                                        
                                    </div>
                                    <div class="col-sm-6">
                                        Departamento - Provincia - Distrito
                                        <select name="ubicacion" id="ubicacion">
                                            <option value="<?php echo $lista[12] . '-' . $lista[11] . '-' . $lista[10]; ?>"><?php echo $lista[8] . ' - ' . $lista[7] . ' - ' . $lista[6]; ?></option>
                                            <option value="<?php echo $lista[12] . '-' . $lista[11] . '-' . $lista[10]; ?>">cambiar por...</option>
                                            <?php
                                            foreach ($list_ubic as $ubic) {
                                                echo '<option value="' . $ubic['codigo'] . '">' . $ubic['ubicacion'] . '</option>';
                                            }
                                            ?>
                                        </select>                                        
                                    </div>                                    
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        Validar Cliente:
                                        <select name="validado" id="validado" class="form-control">
                                            <option value="<?php echo $lista[9]; ?>"><?php echo $validado; ?></option>
                                            <option value="<?php echo $lista[9]; ?>">cambiar por...</option>
                                            <option value="t">Si</option>
                                            <option value="f">No</option>
                                        </select>                                
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-sm-12" style="text-align: center">                            
                                        <input type="submit" value="Guardar" class="btn btn-primary" />
                                        <a href="#" onclick="cargar('#principal', '_cliente.php')" class="btn btn-danger">Regresar</a>
                                        <input type="hidden" id="accion" name="accion" value="ActCliente" />                    
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>    
        <br/>
        <div id="result"></div>
        <script>           
            
            function Select2Test() {                
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
                    var ubic = $("#ubicacion option:selected").html();
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