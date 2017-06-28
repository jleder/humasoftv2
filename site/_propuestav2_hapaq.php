<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="row">
    <div class="col-lg-12">
        <table  style="font-size: 1em; td { padding: 9px;}">            
            <tbody>
                <tr>
                    <td style="width: 300px;">Número de Hectáreas <span class="obl">*</span> </td>
                    <td>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                <input required="" type = "number" step="any" name="ha" value = "1" class="form-control " id="ha" />
                                <span class="input-group-addon"><i class="fa fa-dot-circle-o"></i></span>
                            </div>
                        </div>                        
                </tr>
<!--                <tr>
                    <td>Descuento por Paquete % <span class="obl">*</span></td>
                    <td><input type = "number" step="any" name="dcto" value = "0" class="form-control " id="dcto" /></td>
                </tr>-->
                <tr>
                    <td>Precio Convencional Aproximado</td>
                    <td>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-money"></i></span>                                
                                <input type = "number" step="any" name="pca" value = "0" class="form-control" id="pca" />
                                <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Precio Convencional Confirmado</td>
                    <td>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-money"></i></span>                                
                                <input type = "number" step="any" name="pcc" value = "0" class="form-control " id="pcc" />
                                <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                            </div>
                        </div>                        
                    </td>
                </tr>
                <tr>
                    <td>Otros</td>
                    <td>
                        <div class="checkbox">
                            <label>
                                <input onclick="loadIGV()" type="checkbox" name="checkigv" id="checkigv" value="IGV" /> Incluir IGV
                                <i class="fa fa-square-o small"></i>
                            </label>
                        </div>
                        <div id="divigv" style="display: none;">
                            <label>
                                <input class="form-control " type="number" name="valigv" id="valigv" value="18" />                                
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" checked="" name="mta" id="mta" value="MTA" /> Mostrar Columna Tipo Aplicación
                                <i class="fa fa-square-o small"></i>
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="pud" id="pud" value="PUD" /> Mostrar Precio Unitario con Descuento por Paquete
                                <i class="fa fa-square-o small"></i>
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="verfc" id="verfc" value="MFC" /> Mostrar Factor de Conversion al Cliente
                                <i class="fa fa-square-o small"></i>
                            </label>
                        </div>                        
                    </td>
                </tr>
                <tr>
                    <td>Seleccione Tipo de Descuento</td>
                    <td>
                        <select name="tipodcto" class="form-control" id="tipodcto" onchange="mostrarCampoDcto()">
                            <option value="PREPOR">Por Porcentaje</option>
                            <option value="PRE60">Precios 60</option>
                            <option value="PRECLI">Precio Cliente Antiguo</option>
                            <option value="PREPRO">Precio Promocion</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <div id="divtipodcto">
                            <input type = "number" step="any" name="dcto" value = "0" class="form-control " id="dcto" />
                        </div>

                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td><a class="btn btn-primary" onclick="generarTablaxHas()">Generar Tabla</a></td>
                </tr>                
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <h4>4. Agregar Productos</h4>            
        <div class="cuadro_one">
            <div class="cuadro_two">
                <p style="text-align: center;"><button type="button" onclick="tipoPropuesta('POR UNIDADES')" ><img src="img/iconos/unidad-icon.png" height="50px" /></button></p>
            </div>
            <div style="clear: both"></div>
            <p style="text-align: center; color: white;">Por Unidades</p>
        </div>                                                    
        <div class="cuadro_one">
            <div class="cuadro_two">
                <p style="text-align: center;"><button type="button" onclick="tipoPropuesta('POR LITROS')" ><img src="img/iconos/bottle-icon.png" height="50px" /></button></p>
            </div>
            <div style="clear: both"></div>
            <p style="text-align: center; color: white;">Por Producto</p>
        </div>                                                    
    </div>

</div>
