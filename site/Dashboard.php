<?php
header("Cache-Control: no-cache, must-revalidate");
$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["conectado"])) {
    if ($_SESSION["conectado"] == 'SI') {
        include_once '../controller/C_Portada.php';
        ?>

        <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="utf-8">
                <title>Humasoft</title>
                <meta name="description" content="description">
                <meta name="author" content="Juan">
                <?php include 'head.php';?>                
            </head>
            <body>
                <!--Start Header-->
                <div id="screensaver">
                    <canvas id="canvas"></canvas>
                    <i class="fa fa-lock" id="screen_unlock"></i>
                </div>
<!--                <div id="modalbox">
                    <div class="devoops-modal">
                        <div class="devoops-modal-header">
                            <div class="modal-header-name">
                                <span>Basic table Dahsboard</span>
                            </div>
                            <div class="box-icons">
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="devoops-modal-inner">
                        </div>
                        <div class="devoops-modal-bottom">
                        </div>
                    </div>
                </div>                                -->
                <?php include 'header.php';?>
                <!--End Header-->
                <!--Start Container-->
                <div id="main" class="container-fluid">
                    <div class="row">
                        <div id="sidebar-left" class="col-xs-2 col-sm-2">
                            <?php include 'menu.php';?>
                        </div>
                        <!--Start Content-->
                        <div id="content" class="col-xs-12 col-sm-10">
                            <div class="preloader">
                                <img src="img/devoops_getdata.gif" class="devoops-getdata" alt="preloader"/>
                            </div>
                            <div id="ajax-content"></div>
                        </div>
                        <!--End Content-->
                    </div>
                </div>
                <!--End Container-->
                <?php include 'script.php';?>
                
            </body>
        </html>
        <?php
    }
} else {
    header("Location:recursos/logout.php");
}