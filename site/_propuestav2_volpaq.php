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
                    <td style="width: 300px;">Número de Hectáreas (Opcional)</td>
                    <td><input required="" type = "number" step="any" name="ha" value = "1" class="form-control input-sm" id="ha" /></td>
                </tr>
                <tr>
                    <td>Descuento por Paquete % <span class="obl">*</span></td>
                    <td><input type = "number" step="any" name="dcto" value = "0" class="form-control input-sm" id="dcto" /></td>
                </tr>
                <tr>
                    <td>Precio Convencional Aproximado</td>
                    <td><input type = "number" step="any" name="pca" value = "0" class="form-control input-sm" id="pca" /></td>
                </tr>
                <tr>
                    <td>Precio Convencional Confirmado</td>
                    <td><input type = "number" step="any" name="pcc" value = "0" class="form-control input-sm" id="pcc" /></td>
                </tr>
<!--                <tr>
                    <td>Precio HUMA GRO con Descuento</td>
                    <td><input type = "number" step="any" name="preambt2" value = "0" class="form-control input-sm" id="preambt2" /></td>
                </tr>-->
                <tr>
                    <td>Otros</td>
                    <td>
                        <p><input onclick="loadIGV()" type="checkbox" name="checkigv" id="checkigv" value="IGV" /> Incluir IGV</p>
                        <p id="divigv" style="display: none" ><input class="form-control input-sm" type="number" name="valigv" id="valigv" value="18" /></p>
                        <p><input type="checkbox" name="pud" id="pud" value="PUD" /> Mostrar Precio Unitario con Descuento</p>
                    </td>
                </tr>
                 <tr>
                    <td></td>
                    <td><a class="btn btn-primary btn-sm" onclick="generarTablaxVol()">Generar Tabla</a></td>
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
                <p style="text-align: center;"><a href="#volpaq" onclick="tipoPropuesta('POR VOLUMEN')" ><img src="img/iconos/unidad-icon.png" height="50px" /></a></p>
            </div>
            <div style="clear: both"></div>
            <p style="text-align: center; color: white;">Por Volumen</p>
        </div>                                                    
        <div class="cuadro_one">
            <div class="cuadro_two">
                <p style="text-align: center;"><a href="#volpaq" onclick="tipoPropuesta('POR LITROS')" ><img src="img/iconos/bottle-icon.png" height="50px" /></a></p>
            </div>
            <div style="clear: both"></div>
            <p style="text-align: center; color: white;">Por Producto</p>
        </div>                                                    
    </div>

</div>
