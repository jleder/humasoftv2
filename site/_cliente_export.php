<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="row">
    <div id="breadcrumb" class="col-md-12">
        <ol class="breadcrumb">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="#">Clientes</a></li>
            <li><a href="#">Exportar Datos de Clientes</a></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        Datos: 
        <select name="dato">
            <option>Exportar Clientes</option>
            <option>Exportar Fundos</option>
            <option>Exportar Contactos</option>
        </select>        
    </div>
    <div class="col-md-1">
        <a class="btn btn-default" target="_blank" href="exportar/_clientes_excel.php">Excel</a>
    </div>
</div>