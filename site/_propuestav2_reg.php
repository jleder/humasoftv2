<?php
header("Cache-Control: no-cache, must-revalidate");
$estado_session = session_status();
date_default_timezone_set("America/Bogota");

if ($estado_session == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["conectado"])) {
    if ($_SESSION["conectado"] == 'SI') {
        //@session_start();
        date_default_timezone_set("America/Bogota");
        include_once '../controller/C_Propuestas.php';
        $cli = new C_Cliente();
        $pro = new C_Propuesta();
        $prod = new C_Producto();

        $clientes = $cli->listarSoloClientes();
        $vendedor = $pro->listarVendedores();
        $asesor_ext = $pro->listarVendedoresExternos();
        $cultivo = $pro->listarCultivos();
        $efenologica = $pro->getEtapaFenologica();
        $listaprod = $prod->getProductosAll();
        $tipoa = $pro->getTipoAplicacion();

        $codprop = date("dmy");
        $codprop.='-V01';
        ?>        
        <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="utf-8">
                <title>Humasoft</title>
                <meta name="description" content="description">
                <meta name="author" content="Juan">
                <?php include 'head.php'; ?>   
                <style>            
                    .obl { font-weight: bolder; color: red; } 
                    .numericos, .agroselect { padding: 2px; width: 90%; height: 23px; }
                    .cuadro_two { float: left; height: 80px; width: 90px; background-color: #3fafd7; align-items: center; padding-top: 10px; }
                    .cuadro_one {float: left; padding: 5px; height: 100px; width: 100px; background-color: #666666; margin-right: 10px; }
                </style>
            </head>
            <body> 
                <?php include 'header.php'; ?>
                <!--End Header-->
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
                                        <li><a href="_propuestav2.php">Propuesta</a></li>
                                        <li><a href="_propuestav2_reg.php">Registrar Propuesta</a></li>
                                    </ol>
                                </div>
                            </div>

                            <div class="row">                        
                                <div class="col-xs-12 col-sm-12">
                                    <div class="box">
                                        <div class="box-header">
                                            <div class="box-name">
                                                <i class="fa fa-briefcase"></i>
                                                <span>Formulario para Registrar Propuestas</span>
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
                                            <div class="row">            
                                                <div class="col-md-12">                                                    
                                                    <form id="form" name="form" action="#" method="post" enctype="multipart/form-data">                      
                                                        <div class="tab-content">
                                                            <div class="tab-pane active" id="tab1">
                                                                <div class="row">       
                                                                    <div class="col-lg-12">

                                                                        <div class="panel panel-default">
                                                                            <div class="panel-heading">Datos Generales</div>
                                                                            <div class="panel-body" style="">
                                                                                <div class="row">                                                
                                                                                    <div class="col-sm-3">
                                                                                        <label>Activar Modo de Prueba</label>
                                                                                    </div>
                                                                                    <div class="col-sm-2">
                                                                                        <div class="toggle-switch toggle-switch-success">
                                                                                            <label>                                                            
                                                                                                <input type="checkbox" name="modoprueba" value="ON">
                                                                                                <div class="toggle-switch-inner"></div>
                                                                                                <div class="toggle-switch-switch"><i class="fa fa-check"></i></div>
                                                                                            </label>                                                        
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">                                                
                                                                                    <div class="col-lg-7" id="divcliente">                                    
                                                                                        Cliente <span class="obl">(*)</span>:
                                                                                        <input type="hidden" name="nuevocliente" id="nuevocliente" value="F" />
                                                                                        <select id="combobox" name="codcliente" title="Escribir nombre de Cliente">                                                        
                                                                                            <?php foreach ($clientes as $cliente) { ?>                                
                                                                                                <option value="<?php echo trim($cliente[0]) . '|' . trim($cliente[2]); ?>|"> <?php echo trim($cliente['cliente']); ?></option>
                                                                                            <?php } ?>
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-lg-3">
                                                                                        Código Propuesta <span class="obl">(*)</span>:
                                                                                        <input required="" type = "text" name = "codprop" id="codprop" value = "<?php echo '0' . $codprop; ?>" class="form-control " title="Código de Propuesta" />
                                                                                    </div>                                                                                                                                    
                                                                                    <div class="col-lg-2" id="divaddnewcliente">
                                                                                        <br/>
                                                                                        <a class="btn btn-warning btn-sm" onclick="mostrarNewclienteModal()" href="#ninguno">Nuevo Cliente</a>
                                                                                    </div>                                                                                    
                                                                                </div>                                                                                        
                                                                                <div class="row">
                                                                                    <div id="divcontacto">                                                
                                                                                        <div class="col-lg-2">
                                                                                            Contactos:                                                        
                                                                                            <select class="form-control " name="contacto" id="contacto" onchange="personalizarContacto()">
                                                                                                <option value="0">seleccione...</option>                                                            
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="col-lg-2">
                                                                                            Trato:                                                        
                                                                                            <select class="form-control " name="trato" id="trato" onchange="personalizarTrato()">
                                                                                                <option value=""></option>
                                                                                                <option value="Sr.">Sr.</option>
                                                                                                <option value="Sra.">Sra.</option>
                                                                                                <option value="Sres.">Sres.</option>
                                                                                                <option value="Ing.">Ing.</option>
                                                                                                <option value="Dr.">Ing.</option>
                                                                                                <option value="otro">Otro</option>
                                                                                            </select>
                                                                                        </div>
                                                                                        <div style="display: none" id="divtrato" class="col-lg-2">
                                                                                            Escribir Trato:
                                                                                            <input type = "text" name="newtrato" id="newtrato" value = "" class="form-control " />
                                                                                        </div>
                                                                                        <div style="display: none" id="divnewcontacto" class="col-lg-4">
                                                                                            Contacto Personalizado:
                                                                                            <input type = "text" name="newcontacto" id="newcontacto" value = "" class="form-control " placeholder="Ing. Juan Perez e Ing. Carlos Lopez" />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-3"> 
                                                                                        Vendedor <span class="obl">(*)</span>:
                                                                                        <select class="form-control " id="vendedor" onchange="mostrarAsesorExterno()"  name="vendedor">
                                                                                            <option value="0">..::Seleccione::..</option>
                                                                                            <?php foreach ($vendedor as $valor) { ?>
                                                                                                <option value="<?php echo $valor[0] ?>"> <?php echo $valor[7] . ' ' . $valor[1]; ?></option>
                                                                                            <?php } ?>
                                                                                            <option value="Venta Directa">Venta Directa</option>
                                                                                            <option value="Asesor Externo">Asesor Externo</option>
                                                                                        </select>
                                                                                    </div>  
                                                                                    <div class="col-lg-3" id="divasesorexterno" style="display: none;"> 
                                                                                        Asesor Externo <span class="obl">(*)</span>:
                                                                                        <select class="form-control " id="asesorexterno"  name="asesorexterno">
                                                                                            <option value="0">..::Seleccione::..</option>
                                                                                            <?php foreach ($asesor_ext as $valorex) { ?>                                
                                                                                                <option value="<?php echo $valorex[0] ?>"> <?php echo $valorex[1]; ?></option>
                                                                                            <?php } ?>                                                        
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-lg-3">
                                                                                        Forma de Pago:                                                                                                            
                                                                                        <select class="form-control " id="fpago"  name="fpago">
                                                                                            <option value="A TRATAR">A TRATAR</option>
                                                                                            <option value="CONTADO">CONTADO</option>
                                                                                            <option value="CONTRA ENTREGA">CONTRA ENTREGA</option>
                                                                                            <option value="FACTURA 10 DIAS">FACTURA 10 DIAS</option>
                                                                                            <option value="FACTURA 15 DIAS">FACTURA 15 DIAS</option>
                                                                                            <option value="FACTURA 30 DIAS">FACTURA 30 DIAS</option>
                                                                                            <option value="FACTURA 30/60 DIAS">FACTURA 30/60 DIAS</option>
                                                                                            <option value="FACTURA 45 DIAS">FACTURA 45 DIAS</option>
                                                                                            <option value="FACTURA 60 DIAS">FACTURA 60 DIAS</option>
                                                                                            <option value="FACTURA 90 DIAS">FACTURA 90 DIAS</option>
                                                                                            <option value="FACTURA 120 DIAS">FACTURA 120 DIAS</option>
                                                                                            <option value="LETRA 30">LETRA 30</option>
                                                                                            <option value="LETRA 60">LETRA 60</option>
                                                                                            <option value="LETRA 85/92/99/106/113/120">LETRA 85/92/99/106/113/120</option>
                                                                                            <option value="LETRA 90">LETRA 90</option>
                                                                                            <option value="LETRA 110/120">LETRA 110/120</option>                                        
                                                                                            <option value="LETRA 120">LETRA 120</option>                                        
                                                                                            <option value="LETRA 140">LETRA 140</option>
                                                                                            <option value="LETRA 145">LETRA 145</option>
                                                                                            <option value="LETRA 150">LETRA 150</option>
                                                                                            <option value="LETRA 180">LETRA 180</option>
                                                                                            <option value="LETRA 30/60/120">LETRA 30/60/120</option>
                                                                                            <option value="LETRA 30/90/120">LETRA 30/90/120</option>
                                                                                            <option value="LETRA 120/150">LETRA 120/150</option>
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-lg-2">
                                                                                        Demostración:
                                                                                        <div class="toggle-switch toggle-switch-success">
                                                                                            <label>                                                            
                                                                                                <input type="checkbox" name="" id="demo" value="NO">
                                                                                                <div class="toggle-switch-inner"></div>
                                                                                                <div class="toggle-switch-switch"><i class="fa fa-check"></i></div>
                                                                                            </label>                                                        
                                                                                        </div>                                                    
                                                                                    </div>
                                                                                </div>

                                                                                <div class="row">                                
                                                                                    <div class="col-lg-2">
                                                                                        Cultivo:                                    
                                                                                        <select class="form-control " id="cultivo"  name="cultivo">
                                                                                            <option value="">seleccione...</option>
                                                                                            <?php foreach ($cultivo as $valor) { ?>                                
                                                                                                <option value="<?php echo trim($valor['codele']) . ',' . trim($valor['desele']); ?>"> <?php echo trim($valor['desele']); ?></option>
                                                                                            <?php } ?>
                                                                                            <option value="otro">..::Otro Cultivo</option>
                                                                                        </select>
                                                                                    </div>
                                                                                    <div id="divnewcultivo" class="col-lg-2" hidden="">
                                                                                        Nuevo Cultivo:
                                                                                        <input type="text" name="newcultivo" maxlength="50" placeholder="Escribir Cultivo" class="form-control " id="newcultivo" value="" />                                           
                                                                                    </div>
                                                                                    <div class="col-lg-2" id="divvariedad">
                                                                                        Variedad:                                    
                                                                                        <select class="form-control " name="variedad" id="variedad" onblur="loadNuevaVariedad()">
                                                                                            <option value="">seleccione...</option>                                                                                
                                                                                        </select>
                                                                                    </div>
                                                                                    <div id="divnewvariedad" class="col-lg-2" hidden="">
                                                                                        Nueva Variedad:
                                                                                        <input type="text" name="newvariedad" maxlength="50" placeholder="Escribir Variedad" class="form-control " id="newvariedad" value="" />
                                                                                    </div>                                
                                                                                    <div class="col-lg-2">
                                                                                        Etapa Fenologica:                                                                                                            
                                                                                        <select class="form-control " id="efenologica"  name="efenologica">
                                                                                            <option value="">seleccione...</option>
                                                                                            <?php foreach ($efenologica as $etapa) { ?>                                
                                                                                                <option value="<?php echo trim($etapa['desele']); ?>"> <?php echo trim($etapa['desele']); ?></option>
                                                                                            <?php } ?>
                                                                                            <option value="otro">otra...</option>
                                                                                        </select>
                                                                                    </div>
                                                                                    <div id="divnewefenologica" class="col-lg-2" hidden="">
                                                                                        Nueva Etapa:
                                                                                        <input type="text" name="newefenologica" maxlength="50" placeholder="Escribir Etapa" class="form-control " id="newefenologica" value="" />
                                                                                    </div>
                                                                                    <div class="col-lg-2">
                                                                                        Despachos
                                                                                        <input class="form-control " type="number" min="0" max="100" name="numdespacho" id="numdespacho" value="1" />
                                                                                    </div>
                                                                                </div>                                                                                                                   
                                                                                <div class="row">                                
                                                                                    <div class="col-lg-12">
                                                                                        Asunto:
                                                                                        <input required="" type = "text" name="asunto" value = "Propuesta Económica - Fertilizantes Liquidos Coloidales HUMA GRO con Tecnología Micro Carbono" class="form-control " id="asunto" />
                                                                                    </div>
                                                                                </div> 
                                                                                <div class="row">
                                                                                    <div class="col-lg-12">
                                                                                        Detalle de Asunto:
                                                                                        <textarea name="obs" id="obs" rows="3" cols="20" class="form-control">Según lo solicitado, enviamos esta propuesta económica de nuestros productos HUMA GRO con Tecnología Micro Carbono. Opción 1.a Precios Unitarios con Dscto Simple; y 1.b Precios con Dscto por Paquete/Volumen Preferencial.</textarea>
                                                                                    </div>                                
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-lg-12">
                                                                                        Observaciones para Aprobación: (Esta información será vista solo por el Gerente)
                                                                                        <textarea class="form-control " name="obs_atec" id="obs_atec" rows="3"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-lg-12">
                                                                                        Condiciones Técnicas y de Ventas:
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-lg-12">
                                                                                        <textarea class="form-control" id="condicion2" name="condicion2" rows="10" cols="20"><?php include './_propuestav2_condiciones.php'; ?></textarea>
                                                                                    </div>
                                                                                </div>                                                                                                                                                                              
                                                                                <div class="row">
                                                                                    <div class="col-lg-12" id="divlastfactores"></div>
                                                                                </div>                                   
                                                                            </div>
                                                                        </div>   
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12" style="text-align: right">
                                                                        1 de 3 <a class="btn btn-info btn-sm" id="cargatab2" onclick="goTab2()" href="#tab2" data-toggle="tab">Siguiente</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane" id="tab2">

                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="panel panel-default">
                                                                            <div class="panel-heading">Opciones de Propuesta</div>
                                                                            <div class="panel-body" style="">                                                                        
                                                                                <div class="row">
                                                                                    <div class="col-lg-12">
                                                                                        <input type="checkbox" name="pup" id="pup" onclick="mostrarPUP()" value="PUP" /> Crear opción 1.a de Productos con Descuento Unitário.<br/>                                                    
                                                                                    </div>
                                                                                    <div class="col-lg-12" id="divpup" style="display: none;">
                                                                                        <br/>
                                                                                        Título de Opción 1.a
                                                                                        <input type = "text" name="itemdesc_pup" id="itemdesc_pup" value = "1.a) Propuesta de Nutrición Micro Carbono HUMA GRO. Precio Unitario con Descuento" class="form-control " />
                                                                                    </div>

                                                                                    <div class="col-lg-12">                                                    
                                                                                        <h4>1. Escribir Título de esta Opción:</h4>
                                                                                        <input type = "text" name="itemdesc" value = "1.a) Propuesta de Nutrición Micro Carbono HUMA GRO, precio con dscto. por paquete, volumen y productos que forman parte de la misma." class="form-control " id="itemdesc" placeholder="" />
                                                                                    </div>                                
                                                                                </div>                                            
                                                                                <div class="row">
                                                                                    <div class="col-lg-12">
                                                                                        <h4 id="linetipo">2. Seleccionar Tipo de Propuesta:</h4>
                                                                                        <input type="hidden" name="tipoprop" id="tipoprop" value="HECTAREA PAQ" />
                                                                                        <div style="clear: both"></div>
                                                                                        <div class="cuadro_one">
                                                                                            <div class="cuadro_two">
                                                                                                <p style="text-align: center;"><a href="#" onclick="tipoPropuesta('HECTAREA PAQ')" ><img src="img/iconos/prop4.png" height="50px" /></a></p>
                                                                                            </div>
                                                                                            <div style="clear: both"></div>
                                                                                            <p style="text-align: center; color: white;">Hectárea</p>
                                                                                        </div>
                                                                                        <!--                                                    <div class="cuadro_one">
                                                                                                                                                <div class="cuadro_two">
                                                                                                                                                    <p style="text-align: center;"><a href="#linetipo" onclick="tipoPropuesta('HECTAREA PUD')" ><img src="img/iconos/prop3.png" height="50px" /></a></p>
                                                                                                                                                </div>
                                                                                                                                                <div style="clear: both"></div>
                                                                                                                                                <p style="text-align: center; color: white;">Hectárea PUD</p>
                                                                                                                                            </div>                                                                                                        -->
                                                                                        <div class="cuadro_one">
                                                                                            <div class="cuadro_two">
                                                                                                <p style="text-align: center;"><a href="#" onclick="tipoPropuesta('VOLUMEN PAQ')" ><img src="img/iconos/prop2.png" height="50px" /></a></p>
                                                                                            </div>
                                                                                            <div style="clear: both"></div>
                                                                                            <p style="text-align: center; color: white;">Volumen</p>
                                                                                        </div>                                                    
                                                                                        <!--                                                    <div class="cuadro_one">
                                                                                                                                                <div class="cuadro_two">
                                                                                                                                                    <p style="text-align: center;"><a href="#linetipo" onclick="tipoPropuesta('VOLUMEN PUD')" ><img src="img/iconos/prop1.png" height="50px" /></a></p>
                                                                                                                                                </div>
                                                                                                                                                <div style="clear: both"></div>
                                                                                                                                                <p style="text-align: center; color: white;">Volumen PUD</p>
                                                                                                                                            </div>-->
                                                                                        <div style="clear: both"></div>                                                    
                                                                                        <br/>
                                                                                        <div class="row">
                                                                                            <div class="col-lg-12" id="hapaq">
                                                                                                <p class="lead">Hectárea PAQ</p>
                                                                                                <p>Hectárea con descuento por Paquete</p>                                                            
                                                                                            </div>                                                        
                                                                                            <div class="col-lg-12" id="volpaq" style="display: none;">
                                                                                                <p class="lead">Volumen PAQ</p>
                                                                                                <p>Volumen con descuento por Paquete</p>                                                            
                                                                                            </div>                                                        
                                                                                        </div>
                                                                                        <hr/>                                                    
                                                                                    </div>                                                
                                                                                </div>
                                                                                <div class="row"> 
                                                                                    <div class="col-lg-12">
                                                                                        <h4>3. Ingresar Datos</h4>
                                                                                    </div>
                                                                                </div>



                                                                                <div id="divplantilla">
                                                                                    <?php include './_propuestav2_hapaq.php'; ?>

                                                                                </div>
                                                                                <!--                                            <div class="col-lg-2" id="divha">
                                                                                                                                Hectareas:
                                                                                                                                <input type = "number" step="any" name="ha" value = "1" class="form-control " id="ha" />
                                                                                                                            </div>-->
                                                                                <div class="row" id="divfactor"> 

                                                                                </div>
                                                                                <div id="divaplicacion" style="display: none;">                                
                                                                                    <div class="row">
                                                                                        <div class="col-lg-12"><h5>Por Producto:</h5></div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-lg-4">                                    
                                                                                            Producto:           
                                                                                            <select id="comboprod"  name="comboprod" onchange="" onblur="">
                                                                                                <option value=""></option>                
                                                                                                <?php foreach ($listaprod as $val) { ?>                                
                                                                                                    <option value="<?php echo $val[0] ?>"> <?php echo trim($val[2]); ?></option>
                                                                                                <?php } ?>
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="col-lg-3">
                                                                                            Tipo Aplicación:
                                                                                            <select class="form-control" name="tipoa" id="tipoa">
                                                                                                <?php
                                                                                                foreach ($tipoa as $aplicacion) {
                                                                                                    ?>
                                                                                                    <option value="<?php echo trim($aplicacion['codele']); ?>"><?php echo trim($aplicacion['desele']); ?></option>                                            
                                                                                                    <?php
                                                                                                }
                                                                                                ?>
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="col-lg-3">
                                                                                            Litros/Ha.
                                                                                            <input type="number" name="cantidad" id="cantidad" class="form-control " value="0" step="any" min="0" />
                                                                                        </div> 
                                                                                        <div id="" class="col-lg-2">
                                                                                            Presentación Bidones                                                            
                                                                                            <select name="bidones" id="bidones" class="form-control " >
                                                                                                <option value="10.00">10 LT</option>
                                                                                                <option value="9.46">9.46 LT</option>
                                                                                            </select>
                                                                                        </div>                                                    

                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div id="divpreciou">
                                                                                            <div class="col-lg-2">
                                                                                                Precio Unitário
                                                                                                <input type="number" name="precio" id="precio" class="form-control " value="0" step="any" min="0" />
                                                                                            </div>                                                        
                                                                                            <div id="" class="col-lg-2">
                                                                                                Precio Dscto
                                                                                                <input type="number" name="preciodcto" id="preciodcto" class="form-control " value="0" step="any" min="0" />
                                                                                            </div>
                                                                                            <div class="col-lg-2">
                                                                                                Congelar Precio Dcto
                                                                                                <select class="form-control " name="congelar2" id="congelar2" id="tipoa">
                                                                                                    <option value="F">No</option>
                                                                                                    <option value="T">Si</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-lg-3">
                                                                                        </div>
                                                                                        <div style="text-align: right" class="col-lg-3">
                                                                                            <br/>
                                                                                            <a href="#" class="btn btn-primary" onclick="addbyProducto()" >Insertar o Actualizar Productos</a>                                
                                                                                        </div>                                                    
                                                                                    </div>                                                
                                                                                </div>                                            
                                                                                <hr/>
                                                                                <div class="row">
                                                                                    <div class="col-md-12" id="divproductos">

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="row">                                
                                                                    <div class="col-lg-12" style="text-align: right">
                                                                        2 de 3 <a class="btn btn-default btn-sm" href="#tab1" data-toggle="tab">Anterior</a> <a class="btn btn-info btn-sm" id="cargatab3" onclick="goTab3()" href="#tab3" data-toggle="tab">Vista Preliminar</a>
                                                                    </div>
                                                                </div>
                                                            </div>                        
                                                            <div class="tab-pane" id="tab3">
                                                                <div class="panel panel-default">
                                                                    <div class="panel-heading">Vista Previa de Propuesta</div>
                                                                    <div class="panel-body" style="">                                    
                                                                        <div class="row">                        
                                                                            <div class="col-xs-12" id="divexperimento">

                                                                            </div>
                                                                        </div>

                                                                        <div class="row" style="text-align: right; padding: 5px;">                        
                                                                            <div class="col-lg-12">
                                                                                3 de 3 <a class="btn btn-default btn-sm" href="#tab2" data-toggle="tab">Anterior</a>
                                                                                <input type="submit" value="Finalizar Propuesta" class="btn btn-success" />
                                                                                <input type="hidden" id="accion" name="accion" value="RegPropuestaV2" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-lg-12" id="result"></div>
                                                        </div>
                                                    </form>
                                                </div>            
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
                <script type="text/javascript" src="js/jspropuesta/regpropuesta.js"></script>
                <script type="text/javascript">


                                                                            function mostrarNewclienteModal() {
                                                                                var header = 'Registrar Estado Comercial';
                                                                                var form = $(
                                                                                        '<form id="form_ec_reg" name="form_ec_reg" action="#" method="post" enctype="multipart/form-data">' +
                                                                                        '<div class="row">' +
                                                                                        '<input type = "hidden" name = "codprop" placeholder="codprop" value = "<?php echo $codprop; ?>" class="form-control" id="codprop" />' +
                                                                                        '<div class="col-lg-12">' +
                                                                                        'Fecha<input type = "date" name = "fecha" placeholder="fecha" value = "" class="form-control" id="fecha" />' +
                                                                                        '</div>' +
                                                                                        '</div>' +
                                                                                        '<div class="row">' +
                                                                                        '<div class="col-lg-12">' +
                                                                                        'Estado' +
                                                                                        '<select name="estado" id="estado" class="form-control" onchange="verificarEstadoComercial()" >' +
                                                                                        '<option value="EN VENDEDOR">EN VENDEDOR</option>' +
                                                                                        '<option value="EN CLIENTE">EN CLIENTE</option>' +
                                                                                        '<option value="EN SEGUIMIENTO">EN SEGUIMIENTO</option>' +
                                                                                        '<option value="APROBADO">APROBADO</option>' +
                                                                                        '<option value="NO APROBADO">NO APROBADO</option>' +
                                                                                        '<option value="OTRO">OTRO</option>' +
                                                                                        '</select>' +
                                                                                        '</div>' +
                                                                                        '</div>' +
                                                                                        '<div class="row" id="divestado" style="display: none;">' +
                                                                                        '<div class="col-lg-12">' +
                                                                                        'Escribir nuevo Estado Comercial' +
                                                                                        '<input type="text" class="form-control" name="estado2" id="estado2" maxlength="50" />' +
                                                                                        '</div>' +
                                                                                        '</div>' +
                                                                                        '<div class="row">' +
                                                                                        '<div class="col-lg-12">' +
                                                                                        'Observaciones:' +
                                                                                        '<textarea name="obs" id="obs" rows="4" cols="20" class="form-control"></textarea>' +
                                                                                        '</div>' +
                                                                                        '</div>' +
                                                                                        '</form>');
                                                                                var button = $('<button id="cancelar_estado" type="cancel" class="btn btn-danger btn-label-left">' +
                                                                                        '<span><i class="fa fa-clock-o txt-danger"></i></span>' +
                                                                                        'Cancelar' +
                                                                                        '</button>' +
                                                                                        '<button type="submit" id="submit_estado" class="btn btn-success btn-label-left pull-right">' +
                                                                                        '<span><i class="fa fa-clock-o"></i></span>' +
                                                                                        'Enviar' +
                                                                                        '</button>');
                                                                                OpenModalBox(header, form, button);
                                                                                $('#cancelar_estado').on('click', function () {
                                                                                    CloseModalBox();
                                                                                });
                                                                                $('#submit_estado').on('click', function () {

                                                                                    var codprop = $("#codprop").val();
                                                                                    var fecha = $("#fecha").val();
                                                                                    var estado = $("#estado").val();
                                                                                    var mensaje = $("#obs").val();

                                                                                    var objEstado = {
                                                                                        codprop: codprop,
                                                                                        fecha: fecha,
                                                                                        estado: estado,
                                                                                        obs: mensaje
                                                                                    };

                                                                                    if (validarEstadoComercial()) {
                                                                                        $.ajax({
                                                                                            url: '../controller/C_Propuestas.php',
                                                                                            type: 'post',
                                                                                            dataType: 'html',
                                                                                            success: function (res) {
                                                                                                $("#result_estado").html(res);
                                                                                                location.reload();
                                                                                            },
                                                                                            error: function (jqXHR, status, error) {
                                                                                                alert('Disculpe, existió un problema');
                                                                                            },
                                                                                            complete: function (jqXHR, status) {

                                                                                                //$("#" + divcomentario).load('_propuestav2_coment_list.php?coditem=' + coditem + '&corredor=' + corredor);

                                                                                            },
                                                                                            data: {accion: 'RegEstadoComercialV2', obj: objEstado}
                                                                                        });
                                                                                        CloseModalBox();
                                                                                    }
                                                                                });
                                                                            }



                                                                            function validar() {
                                                                                var codprop = $("#codprop").val();
                                                                                var cliente = $("#combobox").val();
                                                                                var ruc = $("#ruc").val();
                                                                                var contacto = $("#contacto").val();
                                                                                var newcontacto = $("#newcontacto").val();
                                                                                var monto = $("#monto").val();
                                                                                var vendedor = $("#vendedor").val();

                                                                                if (codprop === "") {
                                                                                    alert('Debe escribir nro de propuesta');
                                                                                    $("#codprop").focus();
                                                                                    return false;
                                                                                } else if (contacto === "0") {
                                                                                    alert('Debe seleccionar un contacto');
                                                                                    $("#contacto").focus();
                                                                                    return false;
                                                                                } else if (contacto === "otro" && newcontacto === "") {
                                                                                    alert('Debe escribir contactos');
                                                                                    $("#newcontacto").focus();
                                                                                    return false;
                                                                                } else if (monto === "0.0") {
                                                                                    alert('Ingrese monto mayor a 0.0');
                                                                                    $("#monto").focus();
                                                                                    return false;
                                                                                } else if (vendedor === "0") {
                                                                                    alert('Seleccione un Vendedor');
                                                                                    $("#vendedor").focus();
                                                                                    return false;
                                                                                }
                                                                                return true;
                                                                            }

                                                                            function cargarPreciosxProducto() {
                                                                                var modo = 'Update';
                                                                                var codprod = $("#comboprod_update").val();
                                                                                from_2(modo, codprod, 'divpreciou_update', '_propuestav2_getprecioprod.php');
                                                                            }

                                                                            function addbyUnidad() {
                                                                                //alert('ENTRE');
                                                                                var codcli = $("#combobox").val();
                                                                                var newcli = $("#ruc").val();
                                                                                var tipoprop = $("#tipoprop").val();

                                                                                if (codcli === '' && newcli === '') {
                                                                                    alert("Debe seleccionar un cliente o número de RUC/DNI");
                                                                                    $("#combobox").focus();
                                                                                } else {

                                                                                    var unidades = [$("#unN").val(), $("#unP").val(), $("#unK").val(), $("#unCa").val(), $("#unMg").val(), $("#unS").val(), $("#unB").val(), $("#unCo").val(), $("#unCu").val(), $("#unFe").val(), $("#unMn").val(), $("#unMo").val(), $("#unSi").val(), $("#unZn").val()];
                                                                                    var factores = [$("#fcN").val(), $("#fcP").val(), $("#fcK").val(), $("#fcCa").val(), $("#fcMg").val(), $("#fcS").val(), $("#fcB").val(), $("#fcCo").val(), $("#fcCu").val(), $("#fcFe").val(), $("#fcMn").val(), $("#fcMo").val(), $("#fcSi").val(), $("#fcZn").val()];
                                                                                    var bidones = [$("#bdN").val(), $("#bdP").val(), $("#bdK").val(), $("#bdCa").val(), $("#bdMg").val(), $("#bdS").val(), $("#bdB").val(), $("#bdCo").val(), $("#bdCu").val(), $("#bdFe").val(), $("#bdMn").val(), $("#bdMo").val(), $("#bdSi").val(), $("#bdZn").val()];
                                                                                    var precios = [$("#precN").val(), $("#precP").val(), $("#precK").val(), $("#precCa").val(), $("#precMg").val(), $("#precS").val(), $("#precB").val(), $("#precCo").val(), $("#precCu").val(), $("#precFe").val(), $("#precMn").val(), $("#precMo").val(), $("#precSi").val(), $("#precZn").val()];
                                                                                    //var newprec = [$("#newprecN").val(), $("#newprecP").val(), $("#newprecK").val(), $("#newprecCa").val(), $("#vprecMg").val(), $("#newprecS").val(), $("#newprecB").val(), $("#newprecCo").val(), $("#newprecCu").val(), $("#newprecFe").val(), $("#newprecMn").val(), $("#newprecMo").val(), $("#newprecSi").val(), $("#newprecZn").val()];                    
                                                                                    var congelito = new Array();
                                                                                    congelito = obtenerProductosCongelados();

                                                                                    //var establecido = new Array();
                                                                                    //establecido = obtenerPreciosEstablecidos();                    

                                                                                    var tipo = 'BYUNIDAD'; //UND = Unidad
                                                                                    //*****************************
                                                                                    //var verprec = $("#precio60").val();
                                                                                    var ha = $("#ha").val();
                                                                                    var dcto = $("#dcto").val();
                                                                                    var pca = $("#pca").val();
                                                                                    var pcc = $("#pcc").val();
                                                                                    var pud = 'f';
                                                                                    var pup = 'f';
                                                                                    var verfc = 'f';
                                                                                    var valigv = $("#valigv").val();
                                                                                    var incluyeigv = 'f';

                                                                                    if ($('#checkigv').is(':checked')) {
                                                                                        incluyeigv = 't';
                                                                                    }

                                                                                    if ($('#pud').is(':checked')) {
                                                                                        pud = 't';
                                                                                    }

                                                                                    if ($('#pup').is(':checked')) {
                                                                                        pup = 't';
                                                                                    }

                                                                                    if ($('#verfc').is(':checked')) {
                                                                                        verfc = 't';
                                                                                    }

                                                                                    var nitrogeno = $('input:radio[name=nitrogeno]:checked').val();
                                                                                    //$('input:radio[name=edad]:checked')
                                                                                    //para ahorrar variables, enviar verprec y ha en un array
                                                                                    var variables = [tipo, 'verprec', ha, nitrogeno, dcto, pca, pcc, pud, incluyeigv, valigv, pup, verfc];

                                                                                    if (tipoprop === 'HECTAREA PAQ') {
                                                                                        from_6(unidades, factores, variables, precios, congelito, bidones, 'divproductos', '_propuestav2_hapaq_detalle.php');
                                                                                    }
                                                                                }
                                                                            }

                                                                            function addbyUnidad_Update() {

                                                                                var unidades = [$("#un_updateN").val(), $("#un_updateP").val(), $("#un_updateK").val(), $("#un_updateCa").val(), $("#un_updateMg").val(), $("#un_updateS").val(), $("#un_updateB").val(), $("#un_updateCo").val(), $("#un_updateCu").val(), $("#un_updateFe").val(), $("#un_updateMn").val(), $("#un_updateMo").val(), $("#un_updateSi").val(), $("#un_updateZn").val()];
                                                                                var factores = [$("#fc_updateN").val(), $("#fc_updateP").val(), $("#fc_updateK").val(), $("#fc_updateCa").val(), $("#fc_updateMg").val(), $("#fc_updateS").val(), $("#fc_updateB").val(), $("#fc_updateCo").val(), $("#fc_updateCu").val(), $("#fc_updateFe").val(), $("#fc_updateMn").val(), $("#fc_updateMo").val(), $("#fc_updateSi").val(), $("#fc_updateZn").val()];
                                                                                var bidones = [$("#bd_updateN").val(), $("#bd_updateP").val(), $("#bd_updateK").val(), $("#bd_updateCa").val(), $("#bd_updateMg").val(), $("#bd_updateS").val(), $("#bd_updateB").val(), $("#bd_updateCo").val(), $("#bd_updateCu").val(), $("#bd_updateFe").val(), $("#bd_updateMn").val(), $("#bd_updateMo").val(), $("#bd_updateSi").val(), $("#bd_updateZn").val()];
                                                                                var precios = [$("#prec_updateN").val(), $("#prec_updateP").val(), $("#prec_updateK").val(), $("#prec_updateCa").val(), $("#prec_updateMg").val(), $("#prec_updateS").val(), $("#prec_updateB").val(), $("#prec_updateCo").val(), $("#prec_updateCu").val(), $("#prec_updateFe").val(), $("#prec_updateMn").val(), $("#prec_updateMo").val(), $("#prec_updateSi").val(), $("#precZn").val()];
                                                                                var congelito = new Array();
                                                                                congelito = obtenerProductosCongelados();

                                                                                //*****************************                
                                                                                var posicion = $("#posicion").val();
                                                                                var ha = $("#ha_update").val();
                                                                                var dcto = $("#dcto_update").val();
                                                                                var pca = $("#pca_update").val();
                                                                                var pcc = $("#pcc_update").val();
                                                                                var nitrogeno = $('input:radio[name=nitrogeno]:checked').val();
                                                                                var pud = 'f';
                                                                                var valigv = $("#valigv_update").val();
                                                                                var incluyeigv = 'f';

                                                                                if ($('#checkigv_update').is(':checked')) {
                                                                                    incluyeigv = 't';
                                                                                }

                                                                                if ($('#pud_update').is(':checked')) {
                                                                                    pud = 't';
                                                                                }

                                                                                //para ahorrar variables, enviar verprec y ha en un array
                                                                                var variables = [posicion, dcto, pca, pcc, ha, nitrogeno, pud, incluyeigv, valigv];
                                                                                from_7('producto_add_byunidad', variables, unidades, factores, precios, congelito, bidones, 'divproductos_update', '_propuestav2_hapaq_detalle_10.php');
                                                                            }

                                                                            function generarTablaxHas() {
                                                                                var tipoprop = $("#tipoprop").val();
                                                                                var tipo = 'ONLYTABLE'; //UND = Unidad
                                                                                //*****************************                
                                                                                var ha = $("#ha").val();
                                                                                var dcto = $("#dcto").val();
                                                                                var pca = $("#pca").val();
                                                                                var pcc = $("#pcc").val();
                                                                                var pud = 'f';
                                                                                var pup = 'f';
                                                                                var verfc = 'f';
                                                                                var valigv = $("#valigv").val();
                                                                                var incluyeigv = 'f';

                                                                                if ($('#checkigv').is(':checked')) {
                                                                                    incluyeigv = 't';
                                                                                }

                                                                                if ($('#pud').is(':checked')) {
                                                                                    pud = 't';
                                                                                }

                                                                                if ($('#pup').is(':checked')) {
                                                                                    pup = 't';
                                                                                }

                                                                                if ($('#verfc').is(':checked')) {
                                                                                    verfc = 't';
                                                                                }

                                                                                var variables = [tipo, ha, dcto, pca, pcc, pud, incluyeigv, valigv, pup, verfc];
                                                                                from_3(tipoprop, '', variables, 'divproductos', '_propuestav2_hapaq_detalle.php');
                                                                            }

                                                                            function generarTablaxVol() {
                                                                                var tipoprop = $("#tipoprop").val();
                                                                                var tipo = 'ONLYTABLE'; //UND = Unidad
                                                                                //*****************************                
                                                                                var ha = $("#ha").val();
                                                                                var dcto = $("#dcto").val();
                                                                                var pca = $("#pca").val();
                                                                                var pcc = $("#pcc").val();
                                                                                var pud = 'f';
                                                                                var valigv = $("#valigv").val();
                                                                                var incluyeigv = 'f';

                                                                                if ($('#checkigv').is(':checked')) {
                                                                                    incluyeigv = 't';
                                                                                }

                                                                                if ($('#pud').is(':checked')) {
                                                                                    pud = 't';
                                                                                }

                                                                                var variables = [tipo, ha, dcto, pca, pcc, pud, incluyeigv, valigv];
                                                                                from_3(tipoprop, '', variables, 'divproductos', '_propuestav2_volpaq_detalle.php');
                                                                            }

                                                                            //            function addcontacto() {
                                                                            //                var contacto = $("#contacto").val();
                                                                            //                var contactos = $("#contactos").val();
                                                                            //                var newcontacto = $("#newcontacto").val();
                                                                            //                if (contacto !== "otro" && contacto !== "0") {
                                                                            //                    if (contactos === "") {
                                                                            //                        $("#contactos").val(contactos + contacto);
                                                                            //                    } else {
                                                                            //                        $("#contactos").val(contactos + ", " + contacto);
                                                                            //                    }
                                                                            //                } else if (contacto === "otro" && newcontacto === "") {
                                                                            //                    alert("Debe ingresar nombre de contacto");
                                                                            //                    $("#newcontacto").focus();
                                                                            //                } else if (newcontacto !== "") {
                                                                            //                    if (contactos === "") {
                                                                            //                        $("#contactos").val(contactos + newcontacto);
                                                                            //                        $("#newcontacto").val("");
                                                                            //                    } else {
                                                                            //                        $("#contactos").val(contactos + ", " + newcontacto);
                                                                            //                        $("#newcontacto").val("");
                                                                            //                    }
                                                                            //                }
                                                                            //            }

                                                                            function addbyProductoUpdate() {
                                                                                var codprod = $("#comboprod_update").val();
                                                                                var cantidad = $("#cantidad_update").val();
                                                                                var precio = $("#precio_update").val();
                                                                                var preciodcto = $("#preciodcto_update").val();
                                                                                var factorb = $("#bidones_update").val();
                                                                                var ha = $("#ha_update").val();
                                                                                var dcto = $("#dcto_update").val();
                                                                                var pca = $("#pca_update").val();
                                                                                var pcc = $("#pcc_update").val();
                                                                                var tipoprop = $("#tipoprop_update").val();
                                                                                var pud = 'f';
                                                                                var pup = 'f';
                                                                                var valigv = $("#valigv").val();
                                                                                var incluyeigv = 'f';

                                                                                if ($('#checkigv_update').is(':checked')) {
                                                                                    incluyeigv = 't';
                                                                                }

                                                                                if ($('#pud_update').is(':checked')) {
                                                                                    pud = 't';
                                                                                }

                                                                                if ($('#pup_update').is(':checked')) {
                                                                                    pup = 't';
                                                                                }

                                                                                if (codprod === "") {
                                                                                    alert('Debe seleccionar un producto');
                                                                                    $("#comboprod_update").focus();
                                                                                    return false;
                                                                                } else if (cantidad === "0") {
                                                                                    alert('Debe ingresar litros');
                                                                                    $("#cantidad_update").focus();
                                                                                    return false;
                                                                                } else if (precio === "0") {
                                                                                    alert('Debe ingresar precio');
                                                                                    $("#precio_update").focus();
                                                                                    return false;
                                                                                } else {
                                                                                    var modo = 'producto_add_byproduct'; //PROD = Productos
                                                                                    var codtipoa = $("#tipoa_update").val();
                                                                                    var nomtipoa = $("#tipoa_update option:selected").html();
                                                                                    var congelar = $("#congelar2_update").val();
                                                                                    var var_item = [dcto, pcc, pca, ha, pud, incluyeigv, valigv, pup];
                                                                                    var var_prod = [codtipoa, nomtipoa, codprod, precio, preciodcto, congelar, cantidad, factorb];
                                                                                    //

                                                                                    if (tipoprop === 'HECTAREA PAQ') {
                                                                                        from_3(modo, var_item, var_prod, 'divproductos_update', '_propuestav2_hapaq_detalle_10.php');
                                                                                        $("#comboprod_update").focus();
                                                                                    } else if (tipoprop === 'VOLUMEN PAQ') {
                                                                                        from_4(codprod, cantidad, variables, ha, 'divproductos_update', '_propuestav2_volpaq_detalle_10.php');
                                                                                        $("#comboprod_update").focus();
                                                                                    }
                                                                                }
                                                                            }

                                                                            function onenter(e) {
                                                                                if (e.keyCode == 13) {
                                                                                    alert("No presionar Enter");
                                                                                    e.preventDefault();
                                                                                }
                                                                            }

                                                                            function tipoPropuesta(tipo) {

                                                                                if (tipo === 'HECTAREA PAQ') {
                                                                                    $("#tipoprop").val("HECTAREA PAQ");
                                                                                    $("#volpud").css("display", "none");
                                                                                    $("#volpaq").css("display", "none");
                                                                                    $("#hapud").css("display", "none");
                                                                                    $("#hapaq").css("display", "block");
                                                                                    var codcli = $("#combobox").val();
                                                                                    $("#divaplicacion").css("display", "none");
                                                                                    $("#divha").css("display", "block");
                                                                                    $("#divfactor").css("display", "block");
                                                                                    //from_unico(codcli, 'divfactor', '_propuestav2_loadfactor.php');
                                                                                    from_unico(codcli, 'divplantilla', '_propuestav2_hapaq.php');

                                                                                } else if (tipo === 'OTROS PRODUCTOS') {
                                                                                    $("#divaplicacion").css("display", "block");
                                                                                    $("#divfactor").css("display", "none");
                                                                                    $("#divha").css("display", "block");
                                                                                    $("#ha").val("1");

                                                                                } else if (tipo === 'VOLUMEN PAQ') {
                                                                                    $("#tipoprop").val("VOLUMEN PAQ");
                                                                                    $("#volpud").css("display", "none");
                                                                                    $("#volpaq").css("display", "block");
                                                                                    $("#hapud").css("display", "none");
                                                                                    $("#hapaq").css("display", "none");
                                                                                    $("#divaplicacion").css("display", "block");
                                                                                    $("#divfactor").css("display", "none");
                                                                                    $("#divha").css("display", "block");
                                                                                    $("#ha").val("1");
                                                                                    var codcli = $("#combobox").val();
                                                                                    from_unico('', 'divfactor', '_propuestav2_porvolumen.php');
                                                                                    from_unico(codcli, 'divplantilla', '_propuestav2_volpaq.php');

                                                                                } else if (tipo === 'POR UNIDADES') {
                                                                                    $("#divaplicacion").css("display", "none");
                                                                                    $("#divfactor").css("display", "block");
                                                                                    var codcli = $("#combobox").val();
                                                                                    var modo = "Insert";
                                                                                    from_2(codcli, modo, 'divfactor', '_propuestav2_loadfactor.php');

                                                                                } else if (tipo === 'POR LITROS') {
                                                                                    $("#divaplicacion").css("display", "block");
                                                                                    $("#divfactor").css("display", "none");
                                                                                    $("#divha").css("display", "block");

                                                                                } else if (tipo === 'POR VOLUMEN') {
                                                                                    $("#divaplicacion").css("display", "none");
                                                                                    $("#divfactor").css("display", "block");
                                                                                    $("#divha").css("display", "block");
                                                                                    from_unico('', 'divfactor', '_propuestav2_porvolumen.php');
                                                                                }
                                                                            }

                                                                            function tipoPropuestaUpdateItem(tipo) {
                                                                                if (tipo === 'POR UNIDADES') {
                                                                                    //$("#").css("display", "none");
                                                                                    //$("#addproductos").css("display", "block");
                                                                                    var codcli = $("#combobox").val();
                                                                                    var posicion = $("#posicion").val();
                                                                                    var modo = "Update";
                                                                                    from_3(codcli, modo, posicion, 'addproductos_update', '_propuestav2_loadfactor.php');
                                                                                } else if (tipo === 'POR LITROS') {
                                                                                    from_3('', '', '', 'addproductos_update', '_propuestav2_loadproductos.php');
                                                                                }
                                                                            }

                                                                            function goTab2() {
                                                                                var result = validar();
                                                                                var elemento = document.getElementById("cargatab2");
                                                                                var cliente = $("#combobox").val();
                                                                                var res_cliente = cliente.split("|");
                                                                                var codcli = res_cliente[0];
                                                                                var modo = 'Insert';
                                                                                if (result === false) {
                                                                                    elemento.href = "#tab1";
                                                                                } else {
                                                                                    from_2(codcli, modo, 'divfactor', '_propuestav2_loadfactor.php');
                                                                                    $("#itemdesc_pup").focus();
                                                                                    elemento.href = "#tab2";
                                                                                }
                                                                            }

                                                                            function goTab3() {
                                                                                var elemento = document.getElementById("cargatab3");
                                                                                if (haycarrito === false) {
                                                                                    alert('ADVERTENCIA. EL CARRITO DE PRODUCTOS ESTÁ VACIO. DAR CLIC EN EL BOTÓN "GUARDAR ITEM" Y LUEGO CLIC EN EL BOTON "SIGUIENTE".');
                                                                                    elemento.href = "#tab2";
                                                                                } else {
                                                                                    elemento.href = "#tab3";
                                                                                }
                                                                            }

                                                                            function mostrarPUP() {
                                                                                var tipodcto = $("#pup").val();
                                                                                if (tipodcto === 'PREPOR') {
                                                                                    $("#divtipodcto").css("display", "block");
                                                                                } else if (tipodcto === 'PRE60') {
                                                                                    $("#divtipodcto").css("display", "none");
                                                                                    $("#dcto").val("0");
                                                                                }

                                                                                if ($('#pup').is(':checked')) {
                                                                                    $("#divpup").css("display", "block");
                                                                                    $("#itemdesc").val("1.b) Propuesta de Nutrición Micro Carbono HUMA GRO, precio con dscto. por paquete, volumen y productos que forman parte de la misma.");
                                                                                } else {
                                                                                    $("#divpup").css("display", "none");
                                                                                    $("#itemdesc").val("1.a) Propuesta de Nutrición Micro Carbono HUMA GRO, precio con dscto. por paquete, volumen y productos que forman parte de la misma.");
                                                                                }
                                                                            }

                                                                            function eliminarItem_vista_previa(indice) {
                                                                                from_unico(indice, 'divexperimento', '_propuestav2_vista_previa_elim.php');
                                                                            }

                                                                            function goTab20() {
                                                                                var elemento = document.getElementById("cargatab2");
                                                                                elemento.href = "#tab1";
                                                                            }

                                                                            function updateItem() {
                                                                                var posicion = $("#posicion").val();
                                                                                var dcto = $("#dcto_update").val();
                                                                                var pcc = $("#pcc_update").val();
                                                                                var pca = $("#pca_update").val();
                                                                                var preambt = $("#preambt_update").val();
                                                                                var fau = $("#factor_update").val();
                                                                                var ha = $("#ha_update").val();
                                                                                var nitrogeno = $('input:radio[name=nitrogeno_update]:checked').val();
                                                                                var plantilla = "HECTAREA PAQ";
                                                                                var pud = 'f';
                                                                                var estado = "PENDIENTE";
                                                                                var modificado = "FALSE";
                                                                                var incluyeigv = "f";
                                                                                var valigv = $("#valigv_update").val();
                                                                                var pup = $("#pup_update").val();
                                                                                var titulo_item = $("#titulo_item_update").val();

                                                                                if ($('#pud_update').is(':checked')) {
                                                                                    pud = 't';
                                                                                }

                                                                                var array_item = [dcto, pcc, pca, preambt, fau, ha, nitrogeno, plantilla, pud, estado, modificado, incluyeigv, valigv, pup];
                                                                                from_3(posicion, array_item, titulo_item, 'divexperimento', '_propuestav2_hapaq_detalle_update2.php');
                                                                            }

                                                                            function vervistaprevia() {
                                                                                from_unico('', 'divexperimento', '_propuestav2_vista_previa.php');
                                                                            }
                </script>
            </body>
        </html>
        <?php
    }
} else {
    header("Location:recursos/logout.php");
}
?>
