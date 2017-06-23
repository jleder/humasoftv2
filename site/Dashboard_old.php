<?php
header("Cache-Control: no-cache, must-revalidate");
$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}

include_once '../controller/C_Portada.php';
$obj = new C_Portada();
if (isset($_SESSION["conectado"])) {
    if ($_SESSION["conectado"] == 'SI') {
        ?>

        <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="utf-8">
                <title>Humasoft</title>
                <meta name="description" content="description">
                <meta name="author" content="DevOOPS">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <link href="plugins/bootstrap/bootstrap.css" rel="stylesheet">
                <link href="plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet">
                <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
                <link href='http://fonts.googleapis.com/css?family=Righteous' rel='stylesheet' type='text/css'>
                <link href="plugins/fancybox/jquery.fancybox.css" rel="stylesheet">
                <link href="plugins/fullcalendar/fullcalendar.css" rel="stylesheet">
                <link href="plugins/xcharts/xcharts.min.css" rel="stylesheet">
                <link href="plugins/select2/select2.css" rel="stylesheet">
                <link href="css/style.css" rel="stylesheet">
                <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
                <!--[if lt IE 9]>
                                <script src="http://getbootstrap.com/docs-assets/js/html5shiv.js"></script>
                                <script src="http://getbootstrap.com/docs-assets/js/respond.min.js"></script>
                <![endif]-->
            </head>
            <body>
                <!--Start Header-->
                <div id="screensaver">
                    <canvas id="canvas"></canvas>
                    <i class="fa fa-lock" id="screen_unlock"></i>
                </div>
                <div id="modalbox">
                    <div class="devoops-modal">
                        <div class="devoops-modal-header">
                            <div class="modal-header-name">
                                <span>Basic table</span>
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
                </div>
                <header class="navbar">
                    <div class="container-fluid expanded-panel">
                        <div class="row">
                            <div id="logo" class="col-xs-12 col-sm-2">
                                <a href="dashboard.php">Humasoft</a>
                            </div>
                            <div id="top-panel" class="col-xs-12 col-sm-10">
                                <div class="row">
                                    <div class="col-xs-8 col-sm-4">
                                        <a href="#" class="show-sidebar">
                                            <i class="fa fa-bars"></i>
                                        </a>
                                        <div id="search">
                                            <input type="text" placeholder="search"/>
                                            <i class="fa fa-search"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-8 top-panel-right">
                                        <ul class="nav navbar-nav pull-right panel-menu">
                                            <li class="hidden-xs">
                                                <a href="index.html" class="modal-link">
                                                    <i class="fa fa-bell"></i>
                                                    <span class="badge">7</span>
                                                </a>
                                            </li>
                                            <li class="hidden-xs">
                                                <a class="ajax-link" href="ajax/calendar.html">
                                                    <i class="fa fa-calendar"></i>
                                                    <span class="badge">7</span>
                                                </a>
                                            </li>
                                            <li class="hidden-xs">
                                                <a href="ajax/page_messages.html" class="ajax-link">
                                                    <i class="fa fa-envelope"></i>
                                                    <span class="badge">7</span>
                                                </a>
                                            </li>
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle account" data-toggle="dropdown">
                                                    <div class="avatar">
                                                        <?php if ($_SESSION['foto'] != '') { ?>
                                                            <img class="img-rounded" src="img/usuarios/<?php echo $_SESSION['foto']; ?>" />
                                                        <?php } else { ?>
                                                            <img class="img-rounded" src="img/usuarios/no_photo.png" />
                                                        <?php } ?>
                                                    </div>
                                                    <i class="fa fa-angle-down pull-right"></i>
                                                    <div class="user-mini pull-right">
                                                        <span class="welcome">Welcome,</span>
                                                        <span><?php echo $_SESSION['nombreUsuario']; ?></span>
                                                    </div>
                                                </a>
                                                <ul class="dropdown-menu">                                                    
                                                    <li>
                                                        <a href="recursos/logout.php">
                                                            <i class="fa fa-power-off"></i>
                                                            <span class="hidden-sm text">Logout</span>                                                    
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
                <!--End Header-->
                <!--Start Container-->
                <div id="main" class="container-fluid">
                    <div class="row">
                        <div id="sidebar-left" class="col-xs-2 col-sm-2">
                            <ul class="nav main-menu">
                                <li>
                                    <a href="Dashboard.php">
                                        <i class="fa fa-dashboard"></i>
                                        <span class="hidden-xs">Dashboard</span>
                                    </a>
                                </li>
                                <li class="dropdown"> 
                                    <a href="#" class="dropdown-toggle">
                                        <i class="fa fa-bookmark"></i>
                                        <span class="hidden-xs">Visitas</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="ajax-link" href="_reptecnicov2_reg.php">Técnicas</a></li>
                                        <li><a class="ajax-link" href="_repcomercialv2_reg.php">Comerciales</a></li>
                                        <li><a class="ajax-link" href="_actividad_reg.php">Otros</a></li>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle">                                                
                                                <!--<i class="fa fa-plus-square"></i>-->
                                                <span class="hidden-xs">Consultas</span>
                                            </a>
                                            <ul class="dropdown-menu">                                                
                                                <li><a class="ajax-link" title="Reportes Técnicos" href="_reptecnicov2.php">Tecnicas</a></li>
                                                <li><a class="ajax-link" title="Reportes Comerciales" href="_repcomercialv2.php">Comerciales</a></li>
                                                <li><a class="ajax-link" title="Actividades AMBT" href="_actividad.php">Otros</a></li>
                                                <li><a class="ajax-link" title="Multas y Sanciones" href="_consultas.php">Multas</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>


                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle">
                                        <i class="fa fa-users"></i>
                                        <span class="hidden-xs">Clientes</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="ajax-link" href="_cliente_reg.php">Registrar Cliente</a></li>
                                        <li><a class="ajax-link" href="_none.php">Registrar Fundo</a></li>
                                        <li><a class="ajax-link" href="_none.php">Registrar Contactos</a></li>
                                        <li><a class="ajax-link" href="_none.php">Registrar Lotes</a></li>
                                        <li><a class="ajax-link" href="_cliente_emp_reg.php">Reg. Clientes x Vendedor</a></li>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle">                                                
                                                <i class="fa fa-plus-square"></i>
                                                <span class="hidden-xs">Consultas</span>
                                            </a>
                                            <ul class="dropdown-menu">                                                
                                                <li><a class="ajax-link" title="Lista de Clientes" href="_cliente.php">Lista de Clientes</a></li>
                                                <li><a class="ajax-link" title="Clientes por Validar" href="_clientes_pendientes.php">Clientes Pendientes</a></li>
                                                <li><a class="ajax-link" title="Exportar Clientes" href="_cliente_export.php">Exportar Clientes</a></li>
                                            </ul>
                                        </li>                                        
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle">
                                        <i class="fa fa-flag"></i>
                                        <span class="hidden-xs">Importaciones</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="ajax-link" href="_ordimport_reg.php">Crear Orden Import.</a></li>
                                        <li><a class="ajax-link" href="_ordimport.php">Ver Orden Import.</a></li>
                                        <li><a class="ajax-link" href="_none.php">Estado de Orden Import.</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle">
                                        <i class="fa  fa-puzzle-piece"></i>
                                        <span class="hidden-xs">Inventarios</span>
                                    </a>
                                    <ul class="dropdown-menu">                                        
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle">                                                
                                                <i class="fa fa-plus-square"></i>
                                                <span class="hidden-xs">Ingreso por</span>
                                            </a>
                                            <ul class="dropdown-menu">                                                
                                                <li><a class="ajax-link" title="Orden de Importación" href="_mov_ingreso_oi_reg.php">Orden de Importación</a></li>
                                                <li><a class="ajax-link" href="_none.php">Orden de Compra</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle">                                                
                                                <i class="fa fa-plus-square"></i>
                                                <span class="hidden-xs">Salida por</span>
                                            </a>
                                            <ul class="dropdown-menu">                                                
                                                <li><a class="ajax-link" title="Orden de Pedido" href="_none.php">Orden de Pedido</a></li>
                                            </ul>
                                        </li>
                                        <li><a class="ajax-link" href="_none.php">Almacenes</a></li>
                                        <li><a class="ajax-link" href="_none.php">Productos</a></li>
                                        <li><a class="ajax-link" href="_none.php">Transacciones</a></li>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle">                                                
                                                <i class="fa fa-plus-square"></i>
                                                <span class="hidden-xs">Consultas</span>
                                            </a>
                                            <ul class="dropdown-menu">                                                
                                                <li><a class="ajax-link" title="Consultar Stock de Productos por Almacen" href="_inv_stockxalma.php">Stock x Almacen</a></li>
                                                <li><a class="ajax-link" title="Orden de Pedido" href="_none.php">Ingreso x Importacion</a></li>
                                                <li><a class="ajax-link" title="Orden de Pedido" href="_none.php">Ingreso x Orden Compra</a></li>
                                                <li><a class="ajax-link" title="Orden de Pedido" href="_none.php">Salida x Orden Pedido</a></li>
                                                <li><a class="ajax-link" title="Orden de Pedido" href="_none.php">Traslado de Mercaderia</a></li>
                                                <li><a class="ajax-link" title="Orden de Pedido" href="home.php">Productos + Vendidos</a></li>
                                            </ul>
                                        </li>                                        
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle">
                                        <i class="fa fa-file-text"></i>
                                        <span class="hidden-xs">Viaticos</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="ajax-link" href="_viatico_reg.php">Reg Periodo Viatico</a></li>
                                        <li><a class="ajax-link" href="_viaticodet_reg.php">Reg Detalle Viatico</a></li>                                        
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle">
                                                <i class="fa fa-plus-square"></i>
                                                <span class="hidden-xs">Consultas</span>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a class="ajax-link" title="Orden de Importación" href="_propuestav2_cliente.php">Consultar Viatico</a></li>                                                
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle">
                                        <i class="fa fa-file-text"></i>
                                        <span class="hidden-xs">Propuestas</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="ajax-link" href="_propuestav2_reg.php">Registrar Propuesta</a></li>
                                        <li><a class="ajax-link" href="_propuestav2.php">Lista de Propuestas</a></li>
                                        <?php if ($_SESSION['usuario'] == 'JLP' || $_SESSION['usuario'] == 'ADM') { ?>
                                            <li><a class="ajax-link" href="_propuestav2_aprob01.php">Pendientes</a></li>
                                        <?php } ?>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle">
                                                <i class="fa fa-plus-square"></i>
                                                <span class="hidden-xs">Consultas</span>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a class="ajax-link" title="Orden de Importación" href="_propuestav2_cliente.php">Propuestas por Cliente</a></li>
                                                <li><a class="ajax-link" href="#">Propuestas por Rango de Fecha</a></li>
                                                <li><a class="ajax-link" href="#">Propuestas por Vendedor</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle">
                                        <i class="fa fa-user"></i>
                                        <span class="hidden-xs">RR.HH.</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="ajax-link" href="_empleado_reg.php">Empleado</a></li>
                                        <li><a class="ajax-link" href="_empleadoext_reg.php">Empleado Externo</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle">
                                        <i class="fa fa-lock"></i>
                                        <span class="hidden-xs">Seguridad</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="ajax-link" href="_usuario.php">Usuarios</a></li>
                                        <li><a class="ajax-link" href="_ordimport_reg.php">Perfil</a></li>
                                        <li><a class="ajax-link" href="_ordimport_reg.php">Usuario x Perfil</a></li>
                                        <li><a class="ajax-link" href="_ordimport.php">Recursos</a></li>
                                        <li><a class="ajax-link" href="_ordimport.php">Perfil x Recursos</a></li>
                                        <li><a class="ajax-link" href="_permisos.php">Permiso</a></li>
                                    </ul>
                                </li>                                
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle">
                                        <i class="fa fa-cogs"></i>
                                        <span class="hidden-xs">Mantenedores</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="ajax-link" href="_ordimport_reg.php">Proveedores</a></li>                                        
                                        <li><a class="ajax-link" href="_ordimport_reg.php">Formas de Pago</a></li>
                                        <li><a class="ajax-link" href="_ordimport_reg.php">Cultivos</a></li>
                                        <li><a class="ajax-link" href="_ordimport_reg.php">Variedades</a></li>
                                        <li><a class="ajax-link" href="_ordimport.php">Tiendas</a></li>
                                        <li><a class="ajax-link" href="_ordimport.php">Zonas</a></li>                                                                               
                                    </ul>
                                </li>
                            </ul>
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
                <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
                <!--<script src="http://code.jquery.com/jquery.js"></script>-->
                <script src="plugins/jquery/jquery-2.1.0.min.js"></script>
                <script src="plugins/jquery-ui/jquery-ui.min.js"></script>        
                <!-- Include all compiled plugins (below), or include individual files as needed -->
                <script src="plugins/bootstrap/bootstrap.min.js"></script>
                <script src="plugins/justified-gallery/jquery.justifiedgallery.min.js"></script>
                <script src="plugins/tinymce/tinymce.min.js"></script>
                <script src="plugins/tinymce/jquery.tinymce.min.js"></script>
                <!-- All functions for this theme + document.ready processing -->
                <script src="js/devoops.js"></script>
                <script src="js/js_inscoltec.js"></script>
                <script src="js/fAjax.js"></script>
                <script>
                    function cargar(div, pagina)
                    {
                        $(div).load(pagina);
                    }

                </script>
            </body>
        </html>
        <?php
    }
} else {
    header("Location:recursos/logout.php");
}