<?php
/*
 * Proyecto Humasoft.
 * Desarrollado por Juan Leder
 */
?>
<!DOCTYPE html>
<html >
    <head>
        <meta charset="UTF-8">
        <title>HUMASOFT</title>   
        <!--<script src="js/devoops.js"></script>-->
    </head>

    <body>



        <div class="row">
            <div id="breadcrumb" class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="#">RR.HH.</a></li>
                    <li><a href="#">Lista de Empleados</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-right">
                <button type="button" name="add" id="add" data-toggle="modal" data-target="#modalbox2" class="btn btn-warning">Adicionar 2</button>
                <a class="btn btn-primary">Abrir</a>
            </div>
        </div>
        <div id="add_data_Modal" class="modal fade">
            <!--            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Registrar Empleado</h4>
                                </div>
                                <div class="modal-body">
                                    <form method="post" id="inser_form">
                                        <label>Nombre de Empleado</label>
                                        <input type="text" name="nombre" class="form-control" />                                
                                        <br/>
                                        <input type="submit" name="insert" id="insert" class="btn btn-success" value="Enviar" />
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>-->

        </div>
        <div id="screensaver">
            <canvas id="canvas"></canvas>
            <i class="fa fa-lock" id="screen_unlock"></i>
        </div>
        <div id="modalbox">
            <div class="devoops-modal">
                <div class="devoops-modal-header">
                    <div class="modal-header-name">
                        <span>Registrar Empleado</span>
                    </div>
                    <div class="box-icons">
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="devoops-modal-inner">
                    Hoa<a class="btn btn-default" href="#" onclick="cerrar()">Cerrar</a>
                </div>
                <div class="devoops-modal-bottom">
                    asadasd
                </div>
            </div>
        </div>
        <script>
            function cerrar() {
                CloseModalBox();
            }
        </script>



    </body>
</html>
