<?php
date_default_timezone_set("America/Bogota");
include '../controller/C_OrdenCompra.php';
$ocom = new OrdenCompra();
$ocod = new OrdenCompraDetalle();
$obj_proveedor = new Proveedor();
$obj_producto = new C_Producto();

$listaProductos = $obj_producto->getProductosAll();

$numero_oc = $_GET['cod'];
$ocom->__set('numero_oc', $numero_oc);
$ocod->__set('numero_oc', $numero_oc);

$listaoc = $ocom->listarOCByNumOC();

//Obteniendo Variables
$codproveedor = $listaoc[1];
$nomprovedor = $listaoc[2];
$codcia = $listaoc[3];
$contacto = $listaoc[4];
$via = $listaoc[5];
$fpago = $listaoc[6];
$fecha_oc = $listaoc[7];
$obs = $listaoc[8];
$descia = $listaoc[10];
$dircia = $listaoc[11];
$telcia = $listaoc[12];
$ruccia = $listaoc[13];
$dirent = $listaoc[14];
$discia = $listaoc[15];
$pais = $listaoc[16];
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />     
        <style>            
            ol li {
                list-style-type: lower-latin;
            }

            .row {
                margin-right: 5mm;
                margin-left: 3mm;
                width: 175mm;
                font-size: 11px;
                padding-left: 5mm;
            }

            .row-tablemargen {                
                margin-left: 10mm;
                width: 170mm;
            }

            .row:before,
            .row:after {
                display: table;
                content: " ";
            }

            .row:after {
                clear: both;
            }

            .row:before,
            .row:after {
                display: table;
                content: " ";
            }

            .row:after {
                clear: both;
            }


            .col-lg-1,            
            .col-lg-2,            
            .col-lg-3,            
            .col-lg-4,            
            .col-lg-5,            
            .col-lg-6,            
            .col-lg-7,            
            .col-lg-8,            
            .col-lg-9,            
            .col-lg-10,            
            .col-lg-11,            
            .col-lg-12 {
                position: relative;
                min-height: 1px;
                padding-right: 15px;
                padding-left: 15px;
            }

            .table-striped > tbody > tr:nth-child(odd) > td,
            .table-striped > tbody > tr:nth-child(odd) > th {
                background-color: #f9f9f9;
            }

            table {
                max-width: 100%;
                background-color: transparent;                                
            }

            th {
                text-align: left;
            }

            .table1 {
                width: 100%;
                margin-bottom: 20px;
                border-collapse: collapse;
                border-color: #00FF00;                
                font-size: 9px;
            }

            .table1 td { vertical-align: middle; padding: 3px 3px 3px 3px;}
            .table1 tr:nth-child(even) {
                background-color: #666666;
            }

            /*.table1  thead  tr  td { padding-top: 27px; padding-bottom: 7px; }*/

            .table > thead > tr > th,
            .table > tbody > tr > th,
            .table > tfoot > tr > th,
            .table > thead > tr > td,
            .table > tbody > tr > td,
            .table > tfoot > tr > td {
                padding: 8px;
                line-height: 1.428571429;
                vertical-align: top;
                border-top: 1px solid #666666;
            }

            .table > thead > tr > th {
                vertical-align: bottom;
                border-bottom: 2px solid #dddddd;
            }

            .table > caption + thead > tr:first-child > th,
            .table > colgroup + thead > tr:first-child > th,
            .table > thead:first-child > tr:first-child > th,
            .table > caption + thead > tr:first-child > td,
            .table > colgroup + thead > tr:first-child > td,
            .table > thead:first-child > tr:first-child > td {
                border-top: 0;
            }

            .table > tbody + tbody {
                border-top: 2px solid #dddddd;
            }

            .table .table {
                background-color: #ffffff;
            }

            .pagina { }


            .row { margin-top: 5px;}
            .obl { font-weight: bolder; color: red; } 
            .numericos { padding: 2px; width: 90%; height: 23px; }
            .txtnum { width: 100px; }         
            .mas {vertical-align: middle; float: left; text-align: center; min-height: 45px; display: flex; align-items: center; margin-left: 3px; margin-right: 3px;}
            .cuadrito { vertical-align: middle; font-size: 9px; text-align: center; width: auto; min-height: 45px; height: auto; background-color: #e8e8e8; padding-top: 3px; margin-left: 5px; margin-right: 5px; float: left; border-color: #000000; border-style: ridge; border-width: 1px; }
            .cuadront { float: left; background-color: #e8e8e8; min-height: 45px; text-align: center; font-size: 9px; }
            .cuadrito2 { font-size: 0.9em; text-align: center; border-style: double; border-width: 1px; border-color: #000; padding: 3px; }

            .cuadro_two { float: left; height: 80px; width: 90px; background-color: #e2e2e2; align-items: center; padding-top: 10px; }
            .cuadro_one {float: left; padding: 5px; height: 125px; width: 100px; background-color:  #666666; margin-right: 10px; }
            .asunto { text-indent: 30px;  }
            .asunto span { text-decoration: underline; font-weight: 400; }
            .pruebaa { font-size: 10px; }
            .textcurvo { font-style: italic; text-decoration: underline; font-weight: 400;  }


        </style>                          
    </head>
    <body>        
        <div class="row">
            <div class="col-lg-7">
                <table>
                    <tr>
                        <td style="width: 170mm; text-align: center"><img src="img/iconos/logo1.jpg" height="70px;" /></td>                        
                    </tr>
                    <tr>
                        <td style="width: 170mm; text-align: center;">
                            <h2>Purchase Order</h2>
                            <label style="font-size: 14px; font-weight: bolder;"><?php echo $numero_oc; ?></label>
                        </td>                        
                    </tr>
                </table>                    
            </div>
        </div>
        <div class="row">
            <div class="col-lg-7" style="text-align: left; font-size: 11px;">
                <br/>
                <table style="width: 170mm; font-size: 11px;">                    
                    <tbody>
                        <tr>
                            <td style="width: 30mm;">Provider</td>
                            <td style="width: 65mm;"><?php echo trim($nomprovedor); ?></td>
                            <td style="width: 30mm;"></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>                
            </div>
        </div>    
        <div class="row">
            <div class="col-lg-7" style="font-size: 11px;">
                <br/>
                <strong>Bill To</strong>
                <table style="width: 170mm; font-size: 11px;">                    
                    <tbody>
                        <tr>
                            <td style="width: 30mm;">Name</td>
                            <td style="width: 65mm;"><?php echo trim($descia); ?></td>
                            <td style="width: 30mm;"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td colspan="3"><?php echo trim($dircia); ?></td>                            
                        </tr>
                        <tr>
                            <td>City, ST Zip</td>
                            <td><?php echo trim($discia); ?></td>
                            <td>Phone</td>
                            <td><?php echo trim($telcia); ?></td>
                        </tr>
                        <tr>
                            <td>Country</td>
                            <td><?php echo trim($pais); ?></td>
                            <td>Contact</td>
                            <td><?php echo trim($contacto); ?></td>
                        </tr>
                    </tbody>
                </table>                                
            </div>
        </div>
        <div class="row">
            <div class="col-lg-7" style="font-size: 11px;">
                <br/>
                <strong>Ship To</strong>
                <table style="width: 170mm; font-size: 11px;">                    
                    <tbody>
                        <tr>
                            <td style="width: 30mm;">Address</td>
                            <td colspan="3"><?php echo trim($dirent); ?></td>                                                        
                        </tr>                        
                        <tr>
                            <td style="width: 30mm;">Shipping Method</td>
                            <td style="width: 65mm;"><?php echo trim($via); ?></td>
                            <td style="width: 30mm;">Payment Terms</td>
                            <td><?php echo trim($fpago); ?></td>
                        </tr>
                        <tr>
                            <td>Est. Pickup Date:</td>
                            <td colspan="3"></td>                            
                        </tr>
                    </tbody>
                </table>                                
            </div>
        </div>
        <br/>
        <br/>
        <!--Detalle de Compra-->
        <div class="row">
            <div class="col-lg-7" style="font-size: 11px;">
                <table class="table1" border="1" style=" font-size: 10px;" align="left">
                    <thead>
                        <tr style="background-color: #cccccc">
                            <th style="width: 10mm; text-align: center; padding: 5px;">Pallet Quantity</th>
                            <th style="width: 10mm; text-align: center; padding: 5px;">Totte Quantity</th>
                            <th style="width: 12mm; text-align: center; padding: 5px;">Product Quantity</th>
                            <th style="width: 10mm; text-align: center; padding: 5px;">Unit of Measure</th>
                            <th style="width: 10mm; text-align: center; padding: 5px;">Container Size</th>
                            <th style="width: 43mm; text-align: center; padding: 5px;">Product Name</th>
                            <th style="width: 10mm; text-align: center; padding: 5px;">Unit Price</th>
                            <th style="width: 15mm; text-align: center; padding: 5px;">Total US$</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $query = $ocod->listarByNumOC();
                        if (count($query) > 0) {

                            foreach ($query as $detalle) {
                                $totalprod = ($detalle['cantidad']*$detalle['preciou']);
                                ?>
                        <tr style="font-size: 9px;">                                    
                                    <td style="text-align: center;"><?php if($detalle['presentacion']=='PALLET'){ echo $detalle['cantidadp'];}?></td>
                                    <td style="text-align: center;"><?php if($detalle['presentacion']=='TOTTE'){ echo $detalle['cantidadp'];}?></td>
                                    <td style="text-align: right;"><?php echo $detalle['cantidad'];?></td>
                                    <td style="text-align: center;"><?php echo $detalle['umedida'];?></td>
                                    <td style="text-align: center;"><?php echo $detalle['container'];?></td>
                                    <td><?php echo $detalle['nombre'];?></td>
                                    <td style="text-align: right;">$<?php echo number_format($detalle['preciou'],2);?></td>
                                    <td style="text-align: right;">$<?php echo number_format($totalprod, 2);?></td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="8">No hay productos registrados</td>
                            </tr>
                            <?php
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-lg-7" style="font-size: 11px;">
                <strong>Notes:</strong><br/>
                <?php echo trim($obs); ?>
            </div>
        </div>
        <br/>
        <br/>
        <br/>
        <div class="row">
            <div class="col-lg-7" style="text-align: right; font-size: 11px;">
                _______________________________________<br/>
                <pre>Authorized By      Date:  <?php echo date("d/m/Y", strtotime($fecha_oc)); ?></pre>
            </div>
        </div>
    </body>
</html>

