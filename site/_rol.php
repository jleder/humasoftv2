<?php
include '../controller/C_Permisos.php';
$rol = new Rol();
?>
<script>
    $(document).ready(function () {
        $("#perfil_reg").submit(function (e) {
            e.preventDefault();
            var f = $(this);
            var formData = new FormData(document.getElementById("perfil_reg"));

            $.ajax({
                url: "../controller/C_Usuario.php",
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            })
                    .done(function (res) {
                        $("#resultado").html(res);
                    });

        });
    });
</script>
<div class="row">
    <div id="breadcrumb" class="col-md-12">
        <ol class="breadcrumb">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="#">Rol</a></li>
            <li><a href="#">Lista de Roles</a></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="well">                    
            <h4 class="page-header">Lista de Roles</h4>
            <a class="btn btn-primary"><i class="fa fa-plus"></i> Agregar</a>
            <table class="table table-striped" style=" padding: 5px; font-size: 10px;">
                <thead>
                    <tr style="color: white; background-color: #1da8f4;">                    
                        <th>Codigo</th>
                        <th>Descripción</th>
                        <th></th>        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $lista = $rol->getRolAll();
                    $i = 1;
                    foreach ($lista as $roles) {
                        ?>
                        <tr>                        
                            <th><?php echo $roles['codrol']; ?></th>
                            <th><?php echo $roles['descripcion']; ?></th>
                            <th>
                                <a onClick="cargar('#divperfil', '_adm_perfil_edit.php?id_perfil=<?php echo trim($roles['codrol']); ?>')" href="#" title="Modificar Perfil"><img src="img/iconos/edit.png" /></a>
                                <a onClick="return confirmSubmit()" href="javascript:cargar('#divuserypermiso', '_adm_perfil_elim.php?id_perfil=<?php echo trim($perfil['id_perfil']); ?>')" title="Eliminar Perfil"><img src="img/iconos/delete.png" /></a>
                            </th>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="row" id="modalbox">
    <div class="col-lg-5" id="divperfil">
        <form id="perfil_reg" name="perfil_reg" action="#" method="post" enctype="multipart/form-data">
            <div id="form_reg">
                <div class="panel panel-default">                        
                    <div class="panel-heading">Registrar Rol</div>
                    <div class="panel-body">                                                            
                        <div class="row">
                            <div class="col-lg-12">
                                Nombre de Perfil<input required="" maxlength="50" type = "text" name = "nombre" placeholder="nombre" value = "" class="form-control" id="nombre" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                Descripcion de Perfil                                
                                <textarea name="obs" id="obs" rows="4" cols="20" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row" style="text-align: right;">
                            <div class="col-lg-12">
                                <br/>
                                <input type="submit" value="Guardar" class="btn btn-success" />                                
                                <input type="hidden" id="accion" name="accion" value="RegPerfil" />
                            </div>
                        </div>
                    </div>  
                </div>
                <br/>
                <div id="resultado"></div>

            </div>                       
        </form>

    </div>
</div>    


